<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\ChronicCondition;
use App\Models\PlannedIntervention;

class ChronicConditionController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'permission:crud_chronic_condition']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $chronic_condition = ChronicCondition::all();
        return view('chronic-condition.index', compact('chronic_condition'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('chronic-condition.create');
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
            'chronic_condition_name' => ['required', 'string', 'min:1', 'unique:chronic_conditions'],
            'code' => ['required', 'string']
        ]);
        $data['slug'] = Str::slug($request->chronic_condition_name);
        $chronic_condition = ChronicCondition::create($data);
        return back()->with('status', 'A new Chronic Condition has been added');

//        return redirect()->route('chronic-condition.edit', $chronic_condition)->with('status', 'A new Chronic Condition has been added');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(ChronicCondition $chronic_condition)
    {
        return view('chronic-condition.show', compact('chronic_condition'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(ChronicCondition $chronic_condition)
    {
        return view('chronic-condition.edit', compact('chronic_condition'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ChronicCondition $chronic_condition)
    {
        $data = $request->validate([
            'chronic_condition_name' => ['required', 'string', 'min:1', Rule::unique('chronic_conditions')->ignore($chronic_condition)],
            'code' => ['required', 'string']
        ]);
        $data['slug'] = Str::slug($request->chronic_condition_name);

        $chronic_condition->update($data);

        // $model = new ChronicCondition();
        // $chronic_condition = ChronicCondition::create([
        //     'chronic_condition_name' => $request->chronic_condition_name,
        //     'slug' => $model->slug($request->chronic_condition_name)
        // ]);

        // foreach ($request->symptom as $item => $value) {

        //     PlannedIntervention::create([
        //         'chronic_condition_id' => $chronic_condition->id,
        //         'symptom' => $request->symptom[$item],
        //         'planned_intervention' => $request->planned_intervention[$item],
        //         'person_responsible' => $request->person_responsible[$item],
        //         'time' => $request->time[$item],
        //     ]);
        // }

        return redirect()->route('chronic-condition.index')->with('status', 'Chronic Condition has been updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(ChronicCondition $chronic_condition)
    {
        //
        $chronic_condition->delete();
        return redirect()->route('chronic-condition.index')->with('status', 'Chronic Condition has been removed');
    }
}
