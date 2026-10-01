<?php

namespace App\Observers;

use App\Models\PatientData;
use App\Models\Setting;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class RPMPatientDataObserver
{
    public function created(PatientData $patientData)
    {
        $this->updateSummary($patientData);
    }

    public function updated(PatientData $patientData)
    {
        $this->updateSummary($patientData);
    }

    private function updateSummary(PatientData $patientData)
    {
        try {
            $patientId = $patientData->patient_id;
            if (!$patientId) return;

            // Get averages for this patient only
            $summary = DB::table('patient_data')
                ->where('patient_id', $patientId)
                ->selectRaw('
                AVG(CAST(JSON_UNQUOTE(JSON_EXTRACT(data, "$.sys")) AS DECIMAL(10,2))) as avg_sys,
                AVG(CAST(JSON_UNQUOTE(JSON_EXTRACT(data, "$.dia")) AS DECIMAL(10,2))) as avg_dia,
                AVG(CAST(JSON_UNQUOTE(JSON_EXTRACT(data, "$.pul")) AS DECIMAL(10,2))) as avg_pul
            ')
                ->first();

            // The new reading IS the last reading since we just saved it
            $data        = $patientData->data;
            $last_sys    = $data['sys']      ?? null;
            $last_dia    = $data['dia']      ?? null;
            $last_pul    = $data['pul']      ?? null;
            $last_time   = $patientData->date_time;

            // Category order from averages
            $avg_sys = $summary->avg_sys ?? 0;
            $avg_dia = $summary->avg_dia ?? 0;
            if ($avg_sys >= 165 || $avg_dia >= 120)      $category_order = 4;
            elseif ($avg_sys >= 140 || $avg_dia >= 90)   $category_order = 3;
            elseif ($avg_sys >= 130 || $avg_dia >= 80)   $category_order = 2;
            else                                          $category_order = 1;

            // Status order from last reading
            if ($last_sys >= 165 || $last_dia >= 120)     $status_order = 4;
            elseif ($last_sys >= 140 || $last_dia >= 90)  $status_order = 3;
            elseif ($last_sys >= 130 || $last_dia >= 80)  $status_order = 2;
            else                                           $status_order = 1;

            // Update only avg and last reading fields
            // Minutes, days, calls don't change when a reading arrives
            DB::table('patient_rpm_summary')->updateOrInsert(
                ['patient_id' => $patientId],
                [
                    'avg_sys'           => $summary->avg_sys,
                    'avg_dia'           => $summary->avg_dia,
                    'avg_pul'           => $summary->avg_pul,
                    'last_sys'          => $last_sys,
                    'last_dia'          => $last_dia,
                    'last_pul'          => $last_pul,
                    'last_reading_time' => $last_time,
                    'category_order'    => $category_order,
                    'status_order'      => $status_order,
                    'updated_at'        => now(),
                ]
            );
        } catch (\Exception $e) {
            // Log the failure so you know the scheduler needs to catch up
            Log::error('RPMPatientDataObserver failed for patient ' .
                $patientData->patient_id . ': ' . $e->getMessage());
        }
    }
}
