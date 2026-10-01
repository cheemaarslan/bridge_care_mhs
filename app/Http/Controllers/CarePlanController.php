<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Test;
use App\Models\Patient;
use App\Models\CarePlan;
use App\Models\Screening;
use App\Models\CarePlanTest;
use Illuminate\Http\Request;
use App\Mail\ApproveCarePlan;
use App\Models\TreatmentGoal;
use App\Models\CarePlanAnswer;
use App\Models\CarePlanScheme;
use App\Models\ChronicCondition;
use App\Models\CarePlanScreening;
use Illuminate\Support\Facades\Log;
use App\Models\ActivityLog;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Models\CarePlanTreatmentGoal;
use App\Models\CarePlanSpecialScreening;
use App\Models\CarePlanPlannedIntervention;
use App\Models\Practice;
use App\Models\User;
use Illuminate\Support\Facades\URL;

class CarePlanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('auth')->except('care_plan_public');
        $this->middleware('can_create_care_plan')->only('create');
        $this->middleware('can_send_for_approval')->only('send_for_approval');
        $this->middleware(['permission:approve_care_plan'])->only('approve','index');

    }

    public function index()
    {
        $awaiting_approval = CarePlan::with(['patient' => function($query){
            $query->where('status', true);
            $query->where('enrol_in_ccm', true);
        }])->where('status', 'Awaiting Approval')->get();

        $approved = CarePlan::with(['patient' => function($query){
            $query->where('status', true);
            $query->where('enrol_in_ccm', true);
        }])->where('status', 'Approved')->get();
      
        return view('care-plan.index', compact('awaiting_approval', 'approved'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Patient $patient)
    {
        CarePlan::where('patient_id', $patient->id)->where('status', 'Incomplete')->delete();

        $schemes = CarePlanScheme::with('questions')->get();
        $chronic_conditions = ChronicCondition::all();
        $screenings = Screening::where(function($q) use($patient){
            $q->where('gender', $patient->gender);
            $q->orWhere('gender', 'Both');
        })->where(function($q) use($patient){
            $q->where('min_age', '<=',$patient->age);
            $q->orWhere('min_age', null);
        })->where(function($q) use($patient){
            $q->where('max_age', '>=',$patient->age);
            $q->orWhere('max_age', null);

        })->get();


        $tests = Test::where(function($q) use($patient){
            $q->where('gender', $patient->gender);
            $q->orWhere('gender', 'Both');
        })->where(function($q) use($patient){
            $q->where('min_age', '<=',$patient->age);
            $q->orWhere('min_age', null);

        })->where(function($q) use($patient){
            $q->where('max_age', '>=',$patient->age);
            $q->orWhere('max_age', null);

        })->get();
        $goals = TreatmentGoal::all();

        return view('care-plan.create', compact('patient','schemes','chronic_conditions','goals','screenings','tests'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if($request->ajax()){
            CarePlan::where('patient_id', $request->patient_id)->update(['active' => 0]);
            $care_plan = CarePlan::create([
                'patient_id' => $request->patient_id,
                'created_by' => $request->user()->id,
                'reference_no' => $this->reference_no(),
                'status' => 'Incomplete',
                'completed_at' => Carbon::now()->toDateString(),
            ]);
    

            return response()->json([
                'care_plan' => $care_plan,
                'status' => 200
            ]);
        }
        else{
            $care_plan = CarePlan::findOrFail($request->care_plan_id);
            $patient = Patient::findOrFail($care_plan->patient_id);
            $care_plan->update([
                'status' => 'Complete',
                'completed_at' => Carbon::now()->toDateString(),
                'updated_at' => Carbon::now(),
            ]);
            
              $subject = 'Care Plan Created';
            $description = 'Care Plan for Patient '.$care_plan->patient->first_name.' '.$care_plan->patient->last_name.' has been created with reference no '.$care_plan->reference_no;
            $modelType = CarePlan::class;   
            $modelId = $care_plan->id;
            $this->logActivity($subject, $description, $modelType, $modelId);

            return redirect()->route('patient.show',['patient' => $care_plan->patient, 'type' => 'ccm'])->with('status', 'Care Plan has been Created');
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(CarePlan $care_plan)
    {
        $practice = Practice::findOrFail($care_plan->patient->practice_id);
        $schemes = CarePlanScheme::with(['questions', 'questions.answer' => function($q) use($care_plan){
            $q->where('care_plan_id', $care_plan->id);
        }])->get();

        return view('care-plan.show', compact('care_plan','schemes', 'practice'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(CarePlan $care_plan)
    {
        $patient = Patient::findOrFail($care_plan->patient_id);
        $screenings = Screening::where(function($q) use($patient){
            $q->where('gender', $patient->gender);
            $q->orWhere('gender', 'Both');
        })->where(function($q) use($patient){
            $q->where('min_age', '<=',$patient->age);
            $q->orWhere('min_age', null);
        })->where(function($q) use($patient){
            $q->where('max_age', '>=',$patient->age);
            $q->orWhere('max_age', null);

        })->get();


        $tests = Test::where(function($q) use($patient){
            $q->where('gender', $patient->gender);
            $q->orWhere('gender', 'Both');
        })->where(function($q) use($patient){
            $q->where('min_age', '<=',$patient->age);
            $q->orWhere('min_age', null);

        })->where(function($q) use($patient){
            $q->where('max_age', '>=',$patient->age);
            $q->orWhere('max_age', null);

        })->get();
        $goals = TreatmentGoal::all();


        $schemes = CarePlanScheme::with(['questions', 'questions.answer' => function($q) use($care_plan){
            $q->where('care_plan_id', $care_plan->id);
        }])->get();
        $chronic_conditions = ChronicCondition::all();

        return view('care-plan.edit', compact('care_plan','schemes','chronic_conditions','goals','tests','screenings'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CarePlan $care_plan)
    {
        $care_plan->update([
            'completed_at' => Carbon::now()->toDateString(),
            'updated_at' => Carbon::now(),
        ]);
        if($care_plan->status == "Incomplete"){
            $care_plan->update(['status' => 'Complete']);

            $patient = Patient::findOrFail($care_plan->patient_id);
        }
        
              $subject = 'Care Plan Updated';
        $description = 'Care Plan for Patient '.$care_plan->patient->first_name.' '.$care_plan->patient->last_name.' has been updated with reference no '.$care_plan->reference_no;
        $modelType = CarePlan::class;
        $modelId = $care_plan->id;
        $this->logActivity($subject, $description, $modelType, $modelId);
        return redirect()->route('patient.show', ['patient' => $care_plan->patient, 'type' => 'ccm'])->with('status', 'Care Plan has been updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(CarePlan $care_plan)
    {
        //
    }
    
    
    
      //restore care plan
    public function restore($id)
    {
        $care_plan = CarePlan::withTrashed()->where('id', $id)->firstOrFail();
        $care_plan->restore();
          $subject = 'Care Plan Restored';
        $description = 'Care Plan for Patient '.$care_plan->patient->first_name.' '.$care_plan->patient->last_name.' has been restored with reference no '.$care_plan->reference_no;
        $modelType = CarePlan::class;
        $modelId = $care_plan->id;
        $this->logActivity($subject, $description, $modelType, $modelId);
        return redirect()->back()->with('status', 'Care Plan has been restored');
    }

    
    
    public function set(Request $request)
    {
        $care_plan = CarePlan::findOrFail($request->care_plan_id);
        if($request->set === "1"){
            $care_plan->update([
                'active' => true
            ]);

            CarePlan::where('patient_id', $care_plan->patient_id)->where('id', '!=', $care_plan->id)->update([
                'active' => false
            ]);
        }
        else{
            $care_plan->update([
                'active' => false
            ]);
        }
        return response(200);
    }
    public function care_plan_public(CarePlan $care_plan)
    {
        $practice = Practice::findOrFail($care_plan->patient->practice_id);

        $schemes = CarePlanScheme::with(['questions', 'questions.answer' => function($q) use($care_plan){
            $q->where('care_plan_id', $care_plan->id);
        }])->get();

        return view('care-plan.public', compact('care_plan','schemes', 'practice'));
    }

    public function filter($filter)
    {
        $care_plans = [];
        if($filter === "remaining"){
            $care_plans = Patient::WhereDoesntHave('care_plan', function($query){
                $query->where('active', true);
            })
            ->where('status', true)
            ->where('enrol_in_ccm', true)->get();
        }
        else if($filter === "less-than"){
            $care_plans = Patient::whereHas('care_plan', function($query){
                $query->where('active', true);
                $query->where('minutes','<', '10');
            })
            ->where('status', true)
            ->where('enrol_in_ccm', true)->get();
        }
        else if($filter === "greater-than"){
            $care_plans = Patient::whereHas('care_plan', function($query){
                $query->where('active', true);
                $query->where('minutes','>=', '10');
            })
            ->where('status', true)
            ->where('enrol_in_ccm', true)->get();
        }
        else{
            $care_plans = Patient::whereHas('care_plan', function($query){
                $query->where('active', true);
            })
            ->where('status', true)
            ->where('enrol_in_ccm', true)->get();

        }
        return view('care-plan.filter', compact('care_plans'));
    }

    public function history(Patient $patient)
    {
       $care_plans = CarePlan::withTrashed()
        ->where('patient_id', $patient->id)
        ->orderBy('active', 'desc')
        ->get();
        return view('care-plan.history', compact('patient','care_plans'));
    }
    public function send_for_approval(Request $request)
    {
    
        $care_plan = CarePlan::findOrFail($request->care_plan_id);

        $care_plan->update([
            'status' => 'Awaiting Approval',
            'care_plan_comment' => $request->care_plan_comment,
            'date' => Carbon::now()->toDateString(),
        ]);
        if($request->ajax()){
            return response(200);
        }
        
          $subject = 'Care Plan Sent for Approval';
        $description = 'Care Plan for Patient '.$care_plan->patient->first_name.' '.$care_plan->patient->last_name.' has been sent for approval with reference no '.$care_plan->reference_no;
        $modelType = CarePlan::class;
        $modelId = $care_plan->id;
        $this->logActivity($subject, $description, $modelType, $modelId);
        return back()->with('status', 'Care Plan has been sent for approval');

    }
    public function approve(Request $request)
    {
        
         $care_plan = CarePlan::where('id', $request->care_plan_id)
                         ->where('patient_id', $request->patient_id)
                         ->firstOrFail();
        $patient = Patient::findOrFail($care_plan->patient_id);
        $minutes = 20;
        if($patient->ccm_type == "Complex"){
            $minutes = 60;
        }
        if($care_plan->minutes < $minutes) {
            abort(403, 'Please complete your '.$minutes.' minutes before Approval');
        }
        $care_plan->update([
            'status' => 'Approved',
            'approved_by' => Auth::user()->id,
            'approved_at' => Carbon::now()->toDateString(),
        ]);
        $link = URL::signedRoute('care-plan.public', $care_plan);
        $doctor = User::find($care_plan->patient->doctor_id);

        if ($care_plan->patient->email && $doctor) {
//            Mail::to($care_plan->patient->email)->send(new ApproveCarePlan($link, $doctor));
        }
        else{
            return redirect()->route('patient.show', ['patient' => $care_plan->patient, 'type' => 'ccm'])->with('status', 'Care Plan has been approved, But Patient Email Does Not Exist');
        }
        
        
          $subject = 'Care Plan Approved';
        $description = 'Care Plan for Patient '.$care_plan->patient->first_name.' '.$care_plan->patient->last_name.' has been approved with reference no '.$care_plan->reference_no;
        $modelType = CarePlan::class;
        $modelId = $care_plan->id;
        $this->logActivity($subject, $description, $modelType, $modelId);


        return redirect()->route('patient.show', ['patient' => $care_plan->patient, 'type' => 'ccm'])->with('status', 'Care Plan has been approved');
    }

    public function answer(Request $request)
    {
        CarePlanAnswer::updateOrCreate(
            [
                'care_plan_id' => $request->care_plan_id,
                'care_plan_question_id' => $request->care_plan_question_id,
                'question' => $request->question,
            ],
            [
                'comment' => $request->comment,
                'answer' => $request->answer
            ]
        );

        return response(200);
    }

    public function non_application_screening(Request $request)
    {
        $screenings = Screening::all();
        return response($screenings);

    }
    public function non_application_test(Request $request)
    {
        $test = Test::all();

        return response($test);
    }
    public function special_screening_store(Request $request)
    {
        $data = $request->validate([
            'care_plan_id' => ['required'],
            'screening_name' => ['required'],
            'points' => ['required'],
            'screening_description' => ['required'],

        ]);
        CarePlanSpecialScreening::updateOrCreate(
            [
                'care_plan_id' => $request->care_plan_id,
                'screening_name' => $request->screening_name,
            ],
            [
                'points' => $request->points,
                'screening_description' => $request->screening_description,
            ]
        );
        return response(200);
    }


    public function reference_no()
    {

        $string = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $reference_no = substr(str_shuffle($string), 0, 10);
        if(CarePlan::where('reference_no', $reference_no)->exists()){
            $this->reference_no();
        }
        return $reference_no;
    }
    
    
      public function logActivity($subject, $description, $modelType, $modelId)
    {
        try {
            ActivityLog::create([
                'user_id' => Auth::id(),
                'model_type' => $modelType,
                'model_id' => $modelId,
                'subject' => $subject,
                'description' => $description,
            ]);
        } catch (\Exception $e) {
dd($e->getMessage());
            Log::error('Log Activity Error: ' . $e->getMessage());
        }
    }
}
