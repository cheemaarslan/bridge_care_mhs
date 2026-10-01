<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CarePlanContact;

class CarePlanContactController extends Controller
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
        $contact =  CarePlanContact::create([
            'care_plan_id' => $request->care_plan_id,
            'full_name' => $request->full_name,
            'type' => $request->type,
            'address' => $request->address,
            'contact_no' => $request->contact_no,
        ]);
        return response($contact);
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
        $contact = CarePlanContact::findOrFail($id);
        return response($contact);
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
        $contact = CarePlanContact::findOrFail($id);
        $contact->update([
            'full_name' => $request->full_name,
            'type' => $request->type,
            'address' => $request->address,
            'contact_no' => $request->contact_no,
        ]);
        return response($contact);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $contact = CarePlanContact::findOrFail($id);
        $contact->delete();
        return response(200);
    }
}
