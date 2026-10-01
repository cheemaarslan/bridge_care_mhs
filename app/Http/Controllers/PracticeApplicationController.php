<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use App\Models\PracticeApplication;
use Illuminate\Support\Facades\Hash;
use App\Models\CoordinatorApplication;
use App\Models\User;

class PracticeApplicationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $coordinator_application = CoordinatorApplication::where('status', 0)->get();
        $practice_application = PracticeApplication::where('status', 0)->get();
        // dd($practice_application);
        return view('application.index' , compact('practice_application','coordinator_application'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('application.practice.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request);
        $data = $request->validate([
            'first_name' => ['required', 'min:3' , 'max:30'],
            'last_name' => ['required', 'min:3' , 'max:30'],
            'user_name' => ['required', 'min:3' , 'max:50', 'unique:practice_applications'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:practice_applications'],
            'user_image' => ['nullable','image','mimes:jpeg,png,jpg,gif,svg','max:4048'],
            'state' => ['nullable'],
            'city' => ['nullable'],
            'address' => ['required','min:1', 'max:255'],

        ]);
        $practice = PracticeApplication::create($request->all());
        // dd($practice);

        return redirect()->back()->with('status' , 'Practice Application has been submitted');
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
        return view('application.practice.show');

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        
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
        $application = PracticeApplication::findOrFail($id);
        $application->update(['status' => 1]);
        // dd($application);
        $new_data = User::create([
            'first_name'=> $application->first_name,
            'last_name' => $application->last_name,
            'user_name' => $application->user_name,
            'email' => $application->email,
            'user_image' => $application->user_image,
            'state' => $application->state,
            'city' => $application->city,
            'address' => $application->address,
            'status' => 0,
            'password'=>Hash::make('secrete123'),
        ]);
        dd($new_data);

        $new_data->assignRole('practice');
        dd($new_data);
        // $new_data->save();
        return response(200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy()
    {

    }
    // public function approve()
    // {
        
    // }
}
