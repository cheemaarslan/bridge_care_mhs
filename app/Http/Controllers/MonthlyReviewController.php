<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Patient;
use App\Models\Practice;
use App\Models\Medication;
use Illuminate\Http\Request;
use App\Models\MonthlyReview;
use App\Models\MonthlyReviewAnswer;
use App\Models\MonthlyReviewScheme;

class MonthlyReviewController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('can_create_monthly_review')->only('create');

    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Patient $patient)
    {
        $care_manager = auth()->user();
        if($patient->care_manager){
            $care_manager = $patient->care_manager;
        }
        MonthlyReview::where('patient_id', $patient->id)->where('status', 'Incomplete')->delete();
        $schemes =  MonthlyReviewScheme::with('questions')->get();
        return view('monthly-review.create',compact('patient', 'care_manager','schemes'));
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
            MonthlyReview::where('patient_id', $request->patient_id)->update(['active' => 0]);
            $monthly_review = MonthlyReview::create([
                'patient_id' => $request->patient_id,
                'created_by' => $request->user()->id,
                'reference_no' => $this->reference_no(),
                'status' => 'Incomplete',
                'completed_at' => Carbon::now()->toDateString(),
            ]);

            return response()->json([
                'monthly_review' => $monthly_review,
                'status' => 200
            ]);
        }
        else{
            $monthly_review = MonthlyReview::findOrFail($request->monthly_review_id);
            $monthly_review->update([
                'status' => 'Complete',
                'completed_at' => Carbon::now()->toDateString(),
                'updated_at' => Carbon::now(),
            ]);

            $patient = Patient::findOrFail($monthly_review->patient_id);

            return redirect()->route('patient.show', ['patient' => $monthly_review->patient, 'type' => 'ccm'])->with('status', 'Monthly Review has been Created');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\MonthlyReview  $monthly_review
     * @return \Illuminate\Http\Response
     */
    public function show(MonthlyReview $monthly_review)
    {
        $practice = Practice::findOrFail($monthly_review->patient->practice_id);

        $schemes = MonthlyReviewScheme::with(['questions', 'questions.answer' => function($q) use($monthly_review){
            $q->where('monthly_review_id', $monthly_review->id);
        }])->get();
        return view('monthly-review.show', compact('monthly_review','schemes', 'practice'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\MonthlyReview  $monthly_review
     * @return \Illuminate\Http\Response
     */
    public function edit(MonthlyReview $monthly_review)
    {
        //
        $schemes = MonthlyReviewScheme::with(['questions', 'questions.answer' => function($q) use($monthly_review){
            $q->where('monthly_review_id', $monthly_review->id);
        }])->get();
        $care_manager = auth()->user();
        $patient = Patient::findOrFail($monthly_review->patient->id);
        if($patient->care_manager){
            $care_manager = $patient->care_manager;
        }
        $medications = Medication::where('patient_id', $patient->id)->whereMonth('created_at', Carbon::now()->subMonth(1))->latest()->get();

        return view('monthly-review.edit', compact('care_manager','monthly_review','schemes', 'medications'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\MonthlyReview  $monthly_review
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, MonthlyReview $monthly_review)
    {
        $monthly_review->update([
            'completed_at' => Carbon::now()->toDateString(),
            'updated_at' => Carbon::now(),
        ]);
        if($monthly_review->status == "Incomplete"){
            $monthly_review->update(['status' => 'Complete']);

            $patient = Patient::findOrFail($monthly_review->patient_id);
        }
        return redirect()->route('patient.show', ['patient' => $monthly_review->patient, 'type' => 'ccm'])->with('status', 'Monthly Review has been updated');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\MonthlyReview  $monthly_review
     * @return \Illuminate\Http\Response
     */
    public function destroy(MonthlyReview $monthly_review)
    {
        //
    }
    public function filter($filter)
    {
        $monthly_reviews = [];
        if($filter === "remaining"){
            $monthly_reviews = Patient::WhereDoesntHave('monthly_review', function($query){
                $query->where('active', true);
            })
            ->where('status', true)
            ->where('enrol_in_ccm', true)->get();
        }
        else if($filter === "less-than"){
            $monthly_reviews = Patient::whereHas('monthly_review', function($query){
                $query->where('active', true);
                $query->where('minutes','<', '10');
            })
            ->where('status', true)
            ->where('enrol_in_ccm', true)->get();
        }
        else if($filter === "greater-than"){
            $monthly_reviews = Patient::whereHas('monthly_review', function($query){
                $query->where('active', true);
                $query->where('minutes','>', '10');
            })
            ->where('status', true)
            ->where('enrol_in_ccm', true)->get();
        }
        else{
            $monthly_reviews = Patient::whereHas('monthly_review', function($query){
                $query->where('active', true);
            })
            ->where('status', true)
            ->where('enrol_in_ccm', true)->get();

        }
        return view('monthly-review.filter', compact('monthly_reviews'));
    }

    public function history(Patient $patient)
    {
        $monthly_reviews = MonthlyReview::where('patient_id', $patient->id)->orderBy('active', 'desc')->get();
        return view('monthly-review.history', compact('patient','monthly_reviews'));
    }
    public function answer(Request $request)
    {
        MonthlyReviewAnswer::updateOrCreate(
            [
                'monthly_review_id' => $request->monthly_review_id,
                'monthly_review_question_id' => $request->monthly_review_question_id,
                'question' => $request->question,
            ],
            [
                'comment' => $request->comment,
                'answer' => $request->answer
            ]
        );

        return response(200);
    }
    public function reference_no()
    {

        $string = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $reference_no = substr(str_shuffle($string), 0, 10);
        if(MonthlyReview::where('reference_no', $reference_no)->exists()){
            $this->reference_no();
        }
        return $reference_no;
    }
}
