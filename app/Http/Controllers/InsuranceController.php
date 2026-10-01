<?php

namespace App\Http\Controllers;

use App\Models\Insurance;
use Illuminate\Http\Request;

class InsuranceController extends Controller
{

    public function __construct()
    {
        $this->middleware(['auth', 'permission:crud_insurance']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $insurances = Insurance::all();
        return view('insurance.index', compact('insurances'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('insurance.create');
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
            'insurance_name' => ['required', 'string', 'min:1', 'max:255'],
            'address_line' => ['required', 'string', 'min:1', 'max:255'],
            'city' => ['required', 'string', 'min:1', 'max:255'],
            'state' => ['required', 'string', 'min:1', 'max:255'],
            'zip' => ['required', 'string', 'min:1', 'max:255'],
            'contact_no' => ['required', 'string', 'min:1', 'max:255'],
            'alternate_no' => ['required', 'string', 'min:1', 'max:255'],

        ]);

        Insurance::create($data);
        return redirect()->route('insurance.index')->with('status', 'A New Insurance has been Added successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Insurance $insurance)
    {
        return view('insurance.show',compact('insurance'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Insurance $insurance)
    {
        //dd($insurances);

        return view('insurance.edit', compact('insurance'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Insurance $insurance)
    {

        $data = $request->validate([
            'insurance_name' => ['required', 'string', 'min:1', 'max:255'],
            'address_line' => ['required', 'string', 'min:1', 'max:255'],
            'city' => ['required', 'string', 'min:1', 'max:255'],
            'state' => ['required', 'string', 'min:1', 'max:255'],
            'zip' => ['required', 'string', 'min:1', 'max:255'],
            'contact_no' => ['required', 'string', 'min:1', 'max:255'],
            'alternate_no' => ['required', 'string', 'min:1', 'max:255'],

        ]);

        $data = $request->all();
        // dd($data);

        $insurance->update($data);
        // dd($insurances);

        // $insurance->save();

        // $insurance->update($data->all());

        // Insurance::create($data);


        return redirect()->route('insurance.index')->with('status', 'Insurance has been updated successfully');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Insurance $insurance)
    {

        $insurance->delete();
        return redirect()->route('insurance.index')->with('status', 'Insurance has been deleted');
    }

}
