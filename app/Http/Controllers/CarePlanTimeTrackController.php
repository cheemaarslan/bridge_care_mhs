<?php

namespace App\Http\Controllers;

use App\Models\CcmCode;
use App\Models\Patient;
use App\Models\CarePlan;
use Illuminate\Http\Request;
use App\Models\CarePlanTimeTrack;

class CarePlanTimeTrackController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(CarePlan $care_plan)
    {
        $ccm_codes = [
            "Simple" => [
                'cpt_code' => 'CPT-99490',
                'cpt_time' => 1200,
                'cpt_additional_code' => 'CPT-99439',
                'cpt_additional_time' => 1200,
            ],
            "Complex" => [
                'cpt_code' => 'CPT-99487',
                'cpt_time' => 3600,
                'cpt_additional_code' => 'CPT-99489',
                'cpt_additional_time' => 1800,
            ],
            "Doctor" => [
                'cpt_code' => 'CPT-99491',
                'cpt_time' => 3600,
                'cpt_additional_code' => 'CPT-99437',
                'cpt_additional_time' => 1800,
            ],
        ];
        
        $time_tracks = CarePlanTimeTrack::where('care_plan_id', $care_plan->id)->get();
        return view('care-plan.time-track', compact('time_tracks','care_plan'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
            'care_plan_id' => ['required'],
            'care_plan_scheme_id' => ['nullable'],
            'entry_type' => ['required'],
            'minutes' => ['required'],
            'seconds' => ['required'],
            'description' => ['required'],

        ]);
        $data['user_id'] = auth()->user()->id;
        $time_track = CarePlanTimeTrack::create($data);

        $this->update_care_plan($time_track->care_plan_id);
        if($request->ajax()){
            return response($time_track);
        }

        return back()->with('status', 'Care Plan Time has been added');
      }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $time_track = CarePlanTimeTrack::findOrFail($id);
        return response($time_track);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $time_track = CarePlanTimeTrack::findOrFail($id);
        $time_track->update([
            'minutes' => $request->minutes,
            'seconds' => $request->seconds,
            'description' => $request->description,
        ]);
        $this->update_care_plan($time_track->care_plan_id);

        if($request->ajax()){
            return response($time_track);
        }

        return back()->with('status', 'Care Plan Time has been updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $time_track = CarePlanTimeTrack::findOrFail($id);
        $care_plan_id = $time_track->care_plan_id;
        $time_track->delete();
        $this->update_care_plan($care_plan_id);
        return response(200);
    }
    public function update_care_plan($care_plan_id)
    {
        $minutes = CarePlanTimeTrack::where('care_plan_id', $care_plan_id)->sum('minutes');
        $seconds = CarePlanTimeTrack::where('care_plan_id', $care_plan_id)->sum('seconds');

        $total_seconds = ($minutes*60) + $seconds;
        $minutes = floor($total_seconds/60);
        $seconds = floor($total_seconds%60);
        $carePlan = CarePlan::findOrFail($care_plan_id);
        $carePlan->update([
            'minutes' => $minutes,
            'seconds' => $seconds,
        ]);
    }
}
