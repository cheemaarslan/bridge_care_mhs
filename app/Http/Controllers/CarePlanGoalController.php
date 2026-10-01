<?php

namespace App\Http\Controllers;

use App\Models\CarePlanTreatmentGoal;
use Illuminate\Http\Request;

class CarePlanGoalController extends Controller
{
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
        $request->validate([
            'treatment_goal_id' => ['required'],
            'goal_name' => ['required'],
            'current' => ['required'],
            'goal' => ['required'],
            'barrier' => ['nullable'],
        ]);
        $treatment_goal = CarePlanTreatmentGoal::create([
            'care_plan_id' => $request->care_plan_id,
            'treatment_goal_id' => $request->treatment_goal_id,
            'goal_name' => $request->goal_name,
            'current' => $request->current,
            'goal' => $request->goal,
            'barrier' => $request->barrier
        ]);
        return response($treatment_goal);
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
        $treatment_goal = CarePlanTreatmentGoal::findOrFail($id);
        return response($treatment_goal);
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
        $treatment_goal = CarePlanTreatmentGoal::findOrFail($id);
        $treatment_goal->update([
            'treatment_goal_id' => $request->treatment_goal_id,
            'goal_name' => $request->goal_name,
            'current' => $request->current,
            'goal' => $request->goal,
            'barrier' => $request->barrier
        ]);
        return response($treatment_goal);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $treatment_goal = CarePlanTreatmentGoal::findOrFail($id);
        $treatment_goal->delete();
        return response(200);
    }
}
