<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Appointment;
use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AppointmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware(['auth']);
        $this->middleware(['permission:read_appointment'])->only('index');
        $this->middleware(['permission:create_appointment'])->only('create','store');
        $this->middleware(['permission:update_appointment'])->only('update');
        $this->middleware(['permission:delete_appointment'])->only('destroy');

    }
    public function index()
    {
        $appointments = Appointment::orderBy('start_date', 'desc')
        ->get();
        $today_appointments = $appointments->where('start_date', Carbon::now()->format('m-d-Y'));

        $doctors = User::whereHas('roles', function($query){
            $query->where('name','doctor');
        })->get();

        $patients = Patient::all();
       
        return view('appointment.index', compact('appointments','today_appointments','doctors','patients'));
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
            'title' => ['required'],
            'patient_id' => ['required'],
            'doctor_id' => ['required'],
            'start_date' => ['required'],
            'end_date' => ['required'],
            'start_time' => ['required'],
            'end_time' => ['required'],
            'category' => ['required'],
            'description' => ['required'],
            
        ]);
        $data['start'] = set_start($request->start_date, $request->start_time);
        $data['end'] = set_end($request->end_date, $request->end_time);


        $appointment = Appointment::create($data);


        $start_date = $appointment->start_date;
        $end_date = $appointment->end_date;

        if($request->is_recurring && $request->repeat_after){
            $this->save_recurring($request->repeat_after, $request->repeat_option, $request->cycles, 
            $appointment, $start_date, $end_date);
        }

        return back()->with('status', 'A new Appointment has been created');
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
        $appointment = Appointment::findOrFail($id);
        return response($appointment);
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
        $data = $request->validate([
            'title' => ['required'],
            'patient_id' => ['required'],
            'doctor_id' => ['required'],
            'start_date' => ['required'],
            'end_date' => ['required'],
            'start_time' => ['required'],
            'end_time' => ['required'],
            'category' => ['required'],
            'description' => ['required'],
            
        ]);
        $appointment = Appointment::findOrFail($id);
        $data['start'] = set_start($request->start_date, $request->start_time);
        $data['end'] = set_end($request->end_date, $request->end_time);
        $appointment->update($data);

        $start_date = $appointment->start_date;
        $end_date = $appointment->end_date;

        if($request->is_recurring && $request->repeat_after){
            $this->save_recurring($request->repeat_after, $request->repeat_option, $request->cycles, 
            $appointment, $start_date, $end_date);
        }
        return back()->with('status', 'An Appointment has been updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Appointment::where('id', $id)->delete();
        return back()->with('status', 'An Appointment has been deleted');
    }

    public function save_recurring($repeat_after, $repeat_option, $cycles, $appointment, $start_date, $end_date)
    {
        for($i = 1; $i<=$cycles; $i++){

            $start_date = Carbon::createFromFormat('m-d-Y', $start_date);
            $end_date = Carbon::createFromFormat('m-d-Y', $end_date);

            if($repeat_option == "Week"){
                $start_date = $start_date->addWeeks($repeat_after)->format('m-d-Y');
                $end_date = $end_date->addWeeks($repeat_after)->format('m-d-Y');
            }
            elseif($repeat_option == "Month"){
                $start_date = $start_date->addMonths($repeat_after)->format('m-d-Y');
                $end_date = $end_date->addMonths($repeat_after)->format('m-d-Y');
            }
            elseif($repeat_option == "Year"){
                $start_date = $start_date->addYears($repeat_after)->format('m-d-Y');
                $end_date = $end_date->addYears($repeat_after)->format('m-d-Y');
            }
            else{
                $start_date = $start_date->addDays($repeat_after)->format('m-d-Y');
                $end_date = $end_date->addDays($repeat_after)->format('m-d-Y');

            }

            $start = set_start($start_date, $appointment->start_time);
            $end = set_end($end_date, $appointment->end_time);

            $replicate = $appointment->replicate()->fill([
                'start' => $start,
                'end' => $end,
                'start_date' => $start_date,
                'end_date' => $end_date,
            ]);       
            $replicate->save();  
            $start_date = $replicate->start_date;
            $end_date = $replicate->end_date;
        }
    }

    public function filter_appointment(Request $request)
    {
        $appointments = [];
        $today_appointments = [];

        if($request->patient_id && $request->doctor_id){

            $appointments = Appointment::where('patient_id', $request->patient_id)->where('doctor_id', $request->doctor_id)
            ->orderBy('start_date', 'desc')->get();
            $today_appointments = $appointments->where('start_date', Carbon::now()->toDateString());
        }
        else if(!$request->patient_id && $request->doctor_id){
            $appointments = Appointment::where('doctor_id', $request->doctor_id)
            ->orderBy('start_date', 'desc')->get();
            $today_appointments = $appointments->where('start_date', Carbon::now()->toDateString());
        }
        else if(!$request->doctor_id && $request->patient_id){
            $appointments = Appointment::where('patient_id', $request->patient_id)
            ->orderBy('start_date', 'desc')->get();
            $today_appointments = $appointments->where('start_date', Carbon::now()->toDateString());
        }
        else{
            $appointments = Appointment::orderBy('start_date', 'desc')
            ->get();
            $today_appointments = $appointments->where('start_date', Carbon::now()->toDateString());
        }

        return response()->json([
            'appointments' => $appointments,
            'today_appointments' => $today_appointments
        ]);
    }

}
