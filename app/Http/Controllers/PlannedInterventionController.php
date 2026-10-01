<?php

namespace App\Http\Controllers;

use App\Models\ChronicCondition;
use App\Models\PlannedIntervention;
use Illuminate\Http\Request;

class PlannedInterventionController extends Controller
{

    public function __construct()
    {
        $this->middleware(['auth']);
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
        $data =  $request->validate([
            'chronic_condition_id' => ['required', 'string', 'min:1'],
            'symptom' => ['required', 'string'],
            'planned_intervention' => ['required', 'string'],
            'person_responsible' => ['required', 'array', 'min:1'],
            'time' => ['required', 'string', 'min:1'],
            'desired_outcome' => ['required', 'string'],
            'prognosis' => ['required', 'string'],
        ]);
        $planned_intervention = PlannedIntervention::create($data);
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
        $planned_intervention = PlannedIntervention::findOrFail($id);
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
        $planned_intervention = PlannedIntervention::findOrFail($id);
        $planned_intervention->update([
            'person_responsible' => $request->person_responsible,
            'time' => $request->time,
            'symptom' => $request->symptom,
            'planned_intervention' => $request->planned_intervention,
            'desired_outcome' => $request->desired_outcome,
            'prognosis' => $request->prognosis,
        ]);
        if($request->ajax()){
            return response($planned_intervention);
        }
        return redirect()->route('chronic-condition.index')->with('Planned Intervention has been updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $planned_intervention = PlannedIntervention::findOrFail($id);
        $planned_intervention->delete();

        return redirect()->route('chronic-condition.index');
    }

    public function selected_chronic_condition(Request $request)
    {
        $data =  PlannedIntervention::where('chronic_condition_id', $request->chronic_condition_id)->get(['symptom']);
        return response($data);

    }
    public function selected_symptom(Request $request)
    {
        $data =  PlannedIntervention::where('chronic_condition_id', $request->chronic_condition_id)
        ->where('symptom', $request->symptom)->get(['planned_intervention','person_responsible','time','desired_outcome','prognosis']);
        return response($data);

    }

    // public function selected_planned_intervention(Request $request)
    // {
    //     $data =  PlannedIntervention::where('chronic_condition_id', $request->chronic_condition_id)
    //     ->where('symptom', $request->symptom)
    //     ->where('planned_intervention', $request->planned_intervention)->get(['person_responsible']);
    //     return response($data);

    // }


}
