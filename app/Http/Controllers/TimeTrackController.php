<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\TimeTrack;
use Illuminate\Http\Request;

class TimeTrackController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware(['auth']);
        $this->middleware(['permission:read_time_track'])->only('index');
        $this->middleware(['permission:create_time_track'])->only('create','store');
        $this->middleware(['permission:update_time_track'])->only('update');
        $this->middleware(['permission:delete_time_track'])->only('destroy');
    }
    public function index()
    {
        //
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
        $time_track = TimeTrack::create([
            'user_id' => $request->user()->id,
            'patient_id' => $request->patient_id,
            'engagement_date' => set_format($request->engagement_date),
            'engagement_type' => $request->engagement_type,
            'entry_type' => $request->entry_type,
            'minutes' => $request->minutes,
            'seconds' => $request->seconds,
            'note' => $request->note,
        ]);
        $current_month_time = current_month_time($request->patient_id);
        return response()->json([
            'time_track' => $time_track,
            'current_month_time' => $current_month_time
        ]);
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
        $time_track = TimeTrack::findOrFail($id);
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

        $time_track = TimeTrack::findOrFail($id);
        $time_track->update([
            'engagement_type' => $request->engagement_type,
            'engagement_date' => set_format($request->engagement_date),
            'minutes' => $request->minutes,
            'minutes' => $request->minutes,
            'notes' => $request->note
        ]);

        return response($time_track);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $time_track = TimeTrack::findOrFail($id);
        $time_track->delete();

        return response(200);
    }
}
