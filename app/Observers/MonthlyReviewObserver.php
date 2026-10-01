<?php

namespace App\Observers;

use App\Models\MonthlyReview;
use App\Models\CcmCode;
use App\Models\Patient;
use App\Models\User;
use Carbon\Carbon;

class MonthlyReviewObserver
{
    /**
     * Handle the MonthlyReview "created" event.
     *
     * @param  \App\Models\MonthlyReview  $monthlyReview
     * @return void
     */
    public function created(MonthlyReview $monthlyReview)
    {
        // $patient = Patient::findOrFail($monthlyReview->patient_id);
        // $user = User::findOrFail($monthlyReview->created_by);

        // $total_time = ($monthlyReview->minutes * 60) + $monthlyReview->seconds;
        // $ccm_type = $patient->ccm_type;

        // $ccm_codes = [
        //     "Simple" => [
        //         'cpt_code' => 'CPT-99490',
        //         'cpt_time' => 1200,
        //         'cpt_additional_code' => 'CPT-99439',
        //         'cpt_additional_time' => 1200,
        //     ],
        //     "Complex" => [
        //         'cpt_code' => 'CPT-99487',
        //         'cpt_time' => 3600,
        //         'cpt_additional_code' => 'CPT-99489',
        //         'cpt_additional_time' => 1800,
        //     ],
        //     "Doctor" => [
        //         'cpt_code' => 'CPT-99491',
        //         'cpt_time' => 1800,
        //         'cpt_additional_code' => 'CPT-99437',
        //         'cpt_additional_time' => 1800,
        //     ],
        // ];

        // if ($ccm_type == "Simple") {
        //     $this->handleCcmCode("Simple", $ccm_codes, $total_time, $patient, $monthlyReview);
        // } 
        // if ($ccm_type == "Complex") {
        //     $this->handleCcmCode("Complex", $ccm_codes, $total_time, $patient, $monthlyReview);
        // } 
        // if ($user->hasRole('doctor')) {
        //     $this->handleCcmCode("Doctor", $ccm_codes, $total_time, $patient, $monthlyReview);
        // }
    }

    /**
     * Handle the MonthlyReview "updated" event.
     *
     * @param  \App\Models\MonthlyReview  $monthlyReview
     * @return void
     */
    public function updated(MonthlyReview $monthlyReview)
    {
        $patient = Patient::findOrFail($monthlyReview->patient_id);
        $user = User::findOrFail($monthlyReview->created_by);

        $total_time = ($monthlyReview->minutes * 60) + $monthlyReview->seconds;
        $ccm_type = $patient->ccm_type;

        $ccm_codes = [
            "Simple" => [
                'cpt_code' => 'CPT-99490',
                'cpt_time' => 1200,
                'cpt_additional_code' => 'CPT-99439',
                'cpt_additional_time' => 1200,
            ],
            "Complex" => [
                'cpt_code' => 'CPT-99487',
                'cpt_time' => 3600,
                'cpt_additional_code' => 'CPT-99489',
                'cpt_additional_time' => 1800,
            ],
            "Doctor" => [
                'cpt_code' => 'CPT-99491',
                'cpt_time' => 1800,
                'cpt_additional_code' => 'CPT-99437',
                'cpt_additional_time' => 1800,
            ],
        ];

        if ($ccm_type == "Simple") {
            $this->handleCcmCode("Simple", $ccm_codes, $total_time, $patient, $monthlyReview);
        } 
        if ($ccm_type == "Complex") {
            $this->handleCcmCode("Complex", $ccm_codes, $total_time, $patient, $monthlyReview);
        } 
        if ($user->hasRole('doctor')) {
            $this->handleCcmCode("Doctor", $ccm_codes, $total_time, $patient, $monthlyReview);
        }

    }

    /**
     * Handle the MonthlyReview "deleted" event.
     *
     * @param  \App\Models\MonthlyReview  $monthlyReview
     * @return void
     */
    public function deleted(MonthlyReview $monthlyReview)
    {
        //
    }

    /**
     * Handle the MonthlyReview "restored" event.
     *
     * @param  \App\Models\MonthlyReview  $monthlyReview
     * @return void
     */
    public function restored(MonthlyReview $monthlyReview)
    {
        //
    }

    /**
     * Handle the MonthlyReview "force deleted" event.
     *
     * @param  \App\Models\MonthlyReview  $monthlyReview
     * @return void
     */
    public function forceDeleted(MonthlyReview $monthlyReview)
    {
        //
    }
    private function handleCcmCode($type, $ccm_types, $total_time, Patient $patient, MonthlyReview $monthlyReview)
    {
        $ccm_type_data = $ccm_types[$type];

        $cpt_code = $ccm_type_data['cpt_code'];
        $cpt_time = $ccm_type_data['cpt_time'];
        $cpt_additional_code = $ccm_type_data['cpt_additional_code'];
        $cpt_additional_time = $ccm_type_data['cpt_additional_time'];

        $total_time = ($monthlyReview->minutes * 60) + $monthlyReview->seconds;

        $additional_codes_count = CcmCode::where('patient_id', $patient->id)
            ->where('code', $cpt_additional_code)
            ->whereMonth('created_at', Carbon::now()->month)
            ->count();

        $additional_time = max(0, $total_time - $cpt_time);
        $additional_codes_to_create = max(0, floor($additional_time / $cpt_additional_time) - $additional_codes_count);
        $additional_codes_to_delete = max(0, $additional_codes_count - floor($additional_time / $cpt_additional_time));

        if ($total_time >= $cpt_time) {

            if($type == "Doctor"){
                CcmCode::where('patient_id', $patient->id)
                    ->whereNotIn('code', [$cpt_code, $cpt_additional_code])
                    ->whereMonth('created_at', Carbon::now()->month)
                    ->delete();
            }

            $check = CcmCode::where('patient_id', $patient->id)
                ->where('code', $cpt_code)
                ->whereMonth('created_at', Carbon::now()->month)
                ->exists();

            if (!$check) {
                CcmCode::create([
                    'patient_id' => $patient->id,
                    'monthly_review_id' => $monthlyReview->id,
                    'code' => $cpt_code,
                ]);
                $patient->update(['last_ccm_performed' => Carbon::now()->toDateString()]);
            }

            if ($additional_time >= $cpt_additional_time) {
                for ($i = 0; $i < $additional_codes_to_create; $i++) {
                    CcmCode::create([
                        'patient_id' => $patient->id,
                        'monthly_review_id' => $monthlyReview->id,
                        'code' => $cpt_additional_code,
                    ]);
                }

                if ($additional_codes_to_create > 0) {
                    $patient->update(['last_ccm_performed' => Carbon::now()->toDateString()]);
                }
            }
        } else {
            CcmCode::where('patient_id', $patient->id)
                ->whereIn('code', [$cpt_code, $cpt_additional_code])
                ->whereMonth('created_at', Carbon::now()->month)
                ->delete();
        }

        // delete additional codes
        for ($i = 0; $i < $additional_codes_to_delete; $i++) {
            CcmCode::where('patient_id', $patient->id)
                ->where('code', $cpt_additional_code)
                ->whereMonth('created_at', Carbon::now()->month)
                ->orderBy('created_at', 'asc')
                ->firstOrFail()
                ->delete();
        }

    }

    
}
