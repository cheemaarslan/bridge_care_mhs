<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\PracticeApplication;
use App\Models\CoordinatorApplication;

class CoordinatorApplicationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $practice_application = PracticeApplication::where('status', 0)->get();
        $coordinator_application = CoordinatorApplication::where('status', 0)->get();
        // dd($coordinator_application);
        return view('application.index' , compact('coordinator_application','practice_application'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('application.coordinator.create');

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        // dd($request);
        $data = $request->validate([
            'first_name' => ['required', 'min:3' , 'max:30'],
            'last_name' => ['required', 'min:3' , 'max:30'],
            'user_name' => ['required', 'min:3' , 'max:50', 'unique:coordinator_applications'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:coordinator_applications'],
            'user_image' => ['nullable','image','mimes:jpeg,png,jpg,gif,svg','max:4048'],
            'state' => ['nullable'],
            'city' => ['nullable'],
            'address' => ['required','min:1', 'max:255'],

        ]);
        // dd($data);
        $practice = CoordinatorApplication::create($data);
        return redirect()->back()->with('status' , 'Care Manager Application has been submitted');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(CoordinatorApplication $coordinator_application)
    {
        //
        return view('application.coordinator.show', compact('coordinator_application'));

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //

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
        //
       
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
