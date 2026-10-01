<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Patient;
use App\Models\Medication;
use Illuminate\Http\Request;

class MedicationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware(['auth']);
        $this->middleware(['permission:create_medication'])->only('store');
        $this->middleware(['permission:update_medication'])->only('update');
        $this->middleware(['permission:delete_medication'])->only('destroy');

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
        $data = $request->validate([
            'patient_id' => ['required'],
            'care_plan_id' => ['nullable'],
            'monthly_review_id' => ['nullable'],
            'medication_name' => ['required'],
            'dose' => ['required'],
            'frequency' => ['required'],
            'route' => ['required'],
        ]);
        $medication =  Medication::create($data);
        return response($medication);
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
        $medication = Medication::findOrFail($id);
        return response($medication);
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
        $medication = Medication::findOrFail($id);

        $medication->medication_name = $request->medication_name;
        $medication->dose = $request->dose;
        $medication->frequency = $request->frequency;
        $medication->route = $request->route;
        $medication->save();

        return response($medication);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $medication = Medication::findOrFail($id);
        $medication->delete();

        $data = Medication::all();
        return response($data);    
    }

    public function carry_forward(Request $request)
    {
        $from = Carbon::now()->subMonth()->startOfMonth()->toDateString();
        $to = Carbon::now()->subMonth()->endOfMonth()->toDateString();

        $medications = Medication::where('patient_id', $request->patient_id)->whereBetween('created_at', [$from, $to])->get();

        if($medications->count() > 0){

            foreach($medications as $value){
                Medication::create([
                    'patient_id' => $request->patient_id,
                    'care_plan_id' => $request->care_plan_id,
                    'monthly_review_id' => $request->monthly_review_id,
                    'medication_name' => $value->medication_name,
                    'dose' => $value->dose,
                    'frequency' => $value->frequency,
                    'route' => $value->route,
                ]);
            }
        }
        return response($medications);

    }
}
