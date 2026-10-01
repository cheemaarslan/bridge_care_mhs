<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\PatientData;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PatientDataController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware(['auth']);
        $this->middleware(['permission:read_patient_data'])->only('index');
        $this->middleware(['permission:create_patient_data'])->only('create','store');
        $this->middleware(['permission:update_patient_data'])->only('update');
        $this->middleware(['permission:delete_patient_data'])->only('destroy');

    }
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
        Log::info('Patient Data Received in PatientDataController: ' . json_encode($request->all()));

        $data = $request->validate([
            'pul' => ['nullable'],
            'sys' => ['required'],
            'dia' => ['required'],
            'device_id' => ['nullable'],
            'patient_id' => ['required'],
            'date_time' => ['required'],
        ]);
        $data['date_time'] = set_format($request->date_time).' '.Carbon::now()->toTimeString();
        $json_data = $request->only('pul','sys','dia','ihb','hand', $data['date_time']);
        $data['data'] = $json_data;

        $patient_data = PatientData::create($data);

        return response($patient_data);

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
        $data = PatientData::findOrFail($id);
        return response($data);
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
        $request->validate([
            'pul' => ['required'],
            'sys' => ['required'],
            'dia' => ['required'],
            'date_time' => ['required'],
        ]);
        $date_time = set_format($request->date_time).' '.Carbon::now()->toTimeString();

        $patient_data = PatientData::findOrFail($id);

        $json_data = $request->only('pul','sys','dia','ihb','hand', $patient_data->date_time);
        $patient_data->data = $json_data;
        $patient_data->date_time = $date_time;
        $patient_data->save();
        return response($patient_data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $patient_data = PatientData::findOrFail($id);
        $patient_data->delete();

        return response(200);
    }
    public function patient_data_filter(Request $request)
    {
        $from = Carbon::createFromFormat('m-d-Y', $request->from)->format('Y-m-d')." 00:00:00";
        $to = Carbon::createFromFormat('m-d-Y', $request->to)->format('Y-m-d')." 23:59:59";
        $pulse_rate = [];
        $diastolic = [];
        $systolic = [];
        $date = [];


        $data = PatientData::where('patient_id', $request->patient_id)
        ->whereBetween('date_time', [$from, $to])
        ->get();

        foreach($data as $key=>$value){
            // $pulse_rate[$key] = $value->data['pul'];
            // $systolic[$key] = $value->data['sys'];
            // $diastolic[$key] = $value->data['dia'];
            $pulse_rate[$key] = data_get($value->data, 'pul', null);
            $systolic[$key]   = data_get($value->data, 'sys', null);
            $diastolic[$key]  = data_get($value->data, 'dia', null);
            $date[$key] = $value->formatted_date;
        }


        return response()->json([
            'date' => $date,
            'pulse_rate' => $pulse_rate,
            'diastolic' => $diastolic,
            'systolic' => $systolic,
        ]);
    }

}
