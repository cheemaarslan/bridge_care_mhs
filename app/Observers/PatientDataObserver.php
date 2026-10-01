<?php

namespace App\Observers;

use Carbon\Carbon;
use App\Models\Code;
use App\Models\User;
use App\Models\Device;
use App\Models\RpmCode;
use App\Models\PatientData;
use Illuminate\Support\Facades\DB;
use App\Notifications\PatientReading;
use Illuminate\Support\Facades\Notification;

class PatientDataObserver
{
    /**
     * Handle the PatientData "created" event.
     *
     * @param  \App\Models\PatientData  $patientData
     * @return void
     */
    public function created(PatientData $patientData)
    {
        $id = $patientData->id;
        $patient_id = $patientData->patient_id;
        if ($patient_id){
            if(PatientData::where('patient_id', $patient_id)->count() < 16){
                Device::where('patient_id', $patient_id)->update([
                    'setup_date' => Carbon::now()->format('Y-m-d')
                ]);
                RpmCode::create([
                    'patient_data_id' => $id,
                    'patient_id' => $patient_id,
                    'code' => "99453",
                    'note' => "Setup patient with blood pressure monitoring equipment",
                ]);
            }
            $patient_data = PatientData::where('patient_id', $patient_id)
                ->whereMonth('date_time', Carbon::now()->month)
                ->groupBy(DB::raw('Date(date_time)'))
                ->get();

            if($patient_data->count() >= 16){
                RpmCode::create([
                    'patient_data_id' => $id,
                    'patient_id' => $patient_id,
                    'code' => "99454",
                    'note' => 'Patient reading'
                ]);
            }
            $users = User::whereHas('roles', function($query){
                $query->where('name', 'super-admin');
                $query->orWhere('name', 'admin');
                $query->orWhere('name', 'doctor');
                $query->orWhere('name', 'care-manager');
            })->get();
            Notification::send($users, new PatientReading($patientData));
        }
    }

    /**
     * Handle the PatientData "updated" event.
     *
     * @param  \App\Models\PatientData  $patientData
     * @return void
     */
    public function updated(PatientData $patientData)
    {
        //
    }

    /**
     * Handle the PatientData "deleted" event.
     *
     * @param  \App\Models\PatientData  $patientData
     * @return void
     */
    public function deleted(PatientData $patientData)
    {
        //
    }

    /**
     * Handle the PatientData "restored" event.
     *
     * @param  \App\Models\PatientData  $patientData
     * @return void
     */
    public function restored(PatientData $patientData)
    {
        //
    }

    /**
     * Handle the PatientData "force deleted" event.
     *
     * @param  \App\Models\PatientData  $patientData
     * @return void
     */
    public function forceDeleted(PatientData $patientData)
    {
        //
    }
}
