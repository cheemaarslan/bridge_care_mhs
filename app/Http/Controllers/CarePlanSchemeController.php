<?php

namespace App\Http\Controllers;

use App\Models\CarePlanScheme;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CarePlanSchemeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:crud_care_plan_scheme');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $schemes = CarePlanScheme::all();
        return view('care-plan.scheme.index', compact('schemes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('care-plan.scheme.create');
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
            'scheme_name' => ['required', 'string', 'min:5', 'max:255', 'unique:care_plan_schemes']
        ]);
        CarePlanScheme::create($data);
        return redirect()->route('care-plan-scheme.index')->with('status', 'Care Plan Scheme has been created');

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
    public function edit(CarePlanScheme $care_plan_scheme)
    {
        return view('care-plan.scheme.edit', compact('care_plan_scheme'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CarePlanScheme $care_plan_scheme)
    {
        $data = $request->validate([
            'scheme_name' => ['required', 'string', 'min:5', 'max:255', Rule::unique('care_plan_schemes')->ignore($care_plan_scheme)]
        ]);
        $care_plan_scheme->update($data);
        return redirect()->route('care-plan-scheme.index')->with('status', 'Care Plan Scheme has been updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
