<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Patient;
use App\Models\Practice;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;


class PracticeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:crud_practice')->except('selected_practice', 'show');
        $this->middleware('permission:view_practice_patient')->only('show');
    }

    public function index()
    {
        $practices = Practice::withCount('patients')->get();
        return view('practice.index', compact('practices'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('practice.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'practice_name' => ['required', 'min:1', 'max:255', 'unique:practices'],
            'type' => ['required', 'string','min:1', 'max:255'],
            'address' => ['required', 'string','min:1', 'max:255'],
            'contact_no' => ['required', 'string']
        ]);
        $data['slug'] = Str::slug($request->practice_name);
        Practice::create($data);
        return redirect()->route('practice.index')->with('status', 'A New Practice has been added');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Practice $practice)
    {
        $rpm_record_from = Setting::search('rpm_record_from');

        $to = Carbon::now()->toDateString();
        $from = Carbon::now()->subMonth()->toDateString();

        if($rpm_record_from){
            $from = $rpm_record_from;
        }
        $ccm_patients = Patient::with('care_manager', 'care_plan')
        ->withSum(['time_tracks' => function($query){
            $query->whereMonth('engagement_date', Carbon::now()->month);
        }], 'minutes')->withSum(['time_tracks' => function($query){
            $query->whereMonth('engagement_date', Carbon::now()->month);
        }], 'seconds')
        ->where('enrol_in_ccm', true)->where('practice_id', $practice->id)->where('status', true)->latest()->get();

        $rpm_patients = Patient::with(['last_patient_data','care_manager','doctor'])
            ->with(['phone_call' => function($query) use($to,$from){
                $query->whereBetween('date', [$from,$to]);
            }])
            ->with(['days_with_reading' => function($query) use($to,$from){
                $query->select('patient_id', DB::raw('Date(date_time) as date'));
                $query->whereBetween('date_time', [$from,$to]);
                $query->groupBy('patient_id','date');
            }])
            ->withSum(['time_tracks' => function($query) use($to,$from){
                $query->whereBetween('engagement_date', [$from,$to]);
            }], 'minutes')->withSum(['time_tracks' => function($query) use($to,$from){
                $query->whereBetween('engagement_date', [$from,$to]);
            }], 'seconds')
            ->withAvg('patient_data','data->pul')
            ->withAvg('patient_data','data->sys')
            ->withAvg('patient_data','data->dia')
            ->where('enrol_in_rpm', true)
            ->where('practice_id', auth()->user()->practice_id)
            ->where('status', true)->orderBy('first_name', 'asc')->get();
        $unenrolled_patients = Patient::where('status', false)->where('practice_id', $practice->id)->get();

        $rpm = session('rpm', false);
        $unenrolled = session('unenrolled', false);
        if($rpm || $unenrolled){
            $ccm = session('ccm', false);
        }
        else{
            $ccm = session('rpm', true);
        }


        $select_category_rpm = session('select_category_rpm', 'None');
        $select_status_rpm = session('select_status_rpm', 'None');
        $select_time_taken_rpm = session('select_time_taken_rpm', 'None');
        $select_last_checked_rpm = session('select_last_checked_rpm', 'None');


        $select_covid_status_ccm = session('select_covid_status_ccm', 'None');
        $select_gender_ccm = session('select_gender_ccm', 'None');
        $select_last_ccm_performed = session('select_last_ccm_performed', 'None');
        $select_minutes_rpm = session('select_minutes_rpm', 'None');
        $select_days_with_reading_rpm = session('select_days_with_reading_rpm', 'None');

        return view('practice.show', compact('to', 'from', 'ccm_patients','rpm_patients','unenrolled_patients',
        'ccm', 'rpm', 'unenrolled',
        'select_covid_status_ccm', 'select_gender_ccm', 'select_last_ccm_performed',
        'select_category_rpm', 'select_status_rpm', 'select_time_taken_rpm', 'select_last_checked_rpm','select_minutes_rpm', 'select_days_with_reading_rpm'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Practice $practice)
    {
        return view('practice.edit', compact('practice'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Practice $practice)
    {
        $data = $request->validate([
            'practice_name' => ['required', 'min:1', 'max:255', Rule::unique('practices')->ignore($practice)],
            'type' => ['required', 'string','min:1', 'max:255'],
            'address' => ['required', 'string','min:1', 'max:255'],
            'contact_no' => ['required', 'string']
        ]);
        $data['slug'] = Str::slug($request->practice_name);

        $practice->update($data);
        return redirect()->route('practice.index')->with('status', 'A Practice has been updated');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Practice $practice)
    {
        return redirect()->route('practice.index')->with('status', 'Practice cannot be removed');
    }

    public function selected_practice(Request $request)
    {
       
        Log::info('Practice Controller - Selected Practice Function Called', $request->all());

        $care_managers = User::whereHas('roles', function($query){
            $query->where('name','care-manager');
        })->where('practice_id', $request->practice_id)->get();

        $doctors = User::whereHas('roles', function($query){
            $query->where('name','doctor');
        })->where('practice_id', $request->practice_id)->get();

        return response([
            'care_managers' => $care_managers,
            'doctors' => $doctors,

        ]);
    }
}
