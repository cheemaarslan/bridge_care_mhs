<?php

namespace App\Http\Controllers;


use App\Models\MonthlyReview;
use App\Models\MonthlyReviewTimeTrack;
use Illuminate\Http\Request;

class MonthlyReviewTimeTrackController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(MonthlyReview $monthly_review)
    {
        $time_tracks = MonthlyReviewTimeTrack::where('monthly_review_id', $monthly_review->id)->get();
        return view('monthly-review.time-track', compact('time_tracks','monthly_review'));
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
            'monthly_review_id' => ['required'],
            'monthly_review_scheme_id' => ['nullable'],
            'entry_type' => ['required'],
            'minutes' => ['required'],
            'seconds' => ['required'],
            'description' => ['required'],

        ]);
        $data['user_id'] = auth()->user()->id;
        $time_track = MonthlyReviewTimeTrack::create($data);

        $this->update_monthly_review($time_track->monthly_review_id);
        if($request->ajax()){
            return response($time_track);
        }
        return back()->with('status', 'Monthly Review time has been saved');
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
        $time_track = MonthlyReviewTimeTrack::findOrFail($id);
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
        $time_track = MonthlyReviewTimeTrack::findOrFail($id);
        $time_track->update([
            'minutes' => $request->minutes,
            'seconds' => $request->seconds,
            'description' => $request->description,
        ]);
        $this->update_monthly_review($time_track->monthly_review_id);

        if($request->ajax()){
            return response($time_track);
        }

        return back()->with('status', 'Monthly Review Time has been updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $time_track = MonthlyReviewTimeTrack::findOrFail($id);
        $monthly_review_id = $time_track->monthly_review_id;
        $time_track->delete();
        $this->update_monthly_review($monthly_review_id);
        return response(200);
    }
    public function update_monthly_review($monthly_review_id)
    {
        $minutes = MonthlyReviewTimeTrack::where('monthly_review_id', $monthly_review_id)->sum('minutes');
        $seconds = MonthlyReviewTimeTrack::where('monthly_review_id', $monthly_review_id)->sum('seconds');

        $total_seconds = ($minutes*60) + $seconds;
        $minutes = floor($total_seconds/60);
        $seconds = floor($total_seconds%60);
        $monMonthlyReview = MonthlyReview::findOrFail($monthly_review_id);
        $monMonthlyReview->update([
            'minutes' => $minutes,
            'seconds' => $seconds,
        ]);
    }
}
