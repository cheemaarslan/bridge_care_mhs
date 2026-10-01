<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CarePlanPlannedIntervention;

class CarePlanPlannedInterventionController extends Controller
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
            
        ]);
        $planned_intervention =  CarePlanPlannedIntervention::create([
            'care_plan_id' => $request->care_plan_id,
            'chronic_condition_id' => $request->chronic_condition_id,
            'chronic_condition_name' => $request->chronic_condition_name,
            'symptom' => $request->symptom,
            'planned_intervention' => $request->planned_intervention,
            'person_responsible' => $request->person_responsible,
            'time' => $request->time,
            'desired_outcome' => $request->desired_outcome,
            'prognosis' => $request->prognosis,
        ]);
        return response($planned_intervention);
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
        $planned_intervention = CarePlanPlannedIntervention::findOrFail($id);
        return response($planned_intervention);
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
        $planned_intervention = CarePlanPlannedIntervention::findOrFail($id);
        $planned_intervention->update([
            'chronic_condition_id' => $request->chronic_condition_id,
            'chronic_condition_name' => $request->chronic_condition_name,
            'symptom' => $request->symptom,
            'planned_intervention' => $request->planned_intervention,
            'person_responsible' => $request->person_responsible,
            'time' => $request->time,
            'desired_outcome' => $request->desired_outcome,
            'prognosis' => $request->prognosis,
        ]);
        return response($planned_intervention);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $planned_intervention = CarePlanPlannedIntervention::findOrFail($id);
        $planned_intervention->delete();
        return response(200);
    }
}
