<?php

namespace App\Observers;

use Carbon\Carbon;
use App\Models\Code;
use App\Models\Patient;
use App\Models\PatientPhoneCall;
use App\Models\RpmCode;
use App\Models\TimeTrack;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class TimeTrackObserver
{
    public function created(TimeTrack $timeTrack)
    {
        $id              = $timeTrack->id;
        $patient_id      = $timeTrack->patient_id;
        $minutes         = $timeTrack->minutes;
        $seconds         = $timeTrack->seconds;
        $engagement_type = $timeTrack->engagement_type;
        $note            = $timeTrack->note;

        if ($engagement_type == "Phone Call" || $engagement_type == "Video Call") {
            PatientPhoneCall::create([
                'patient_id'    => $patient_id,
                'time_track_id' => $timeTrack->id,
                'date'          => $timeTrack->engagement_date,
            ]);
        }

        $total_minutes = TimeTrack::where('patient_id', $patient_id)
            ->whereMonth('engagement_date', Carbon::now()->month)->sum('minutes') + $minutes;

        $total_seconds = TimeTrack::where('patient_id', $patient_id)
            ->whereMonth('engagement_date', Carbon::now()->month)->sum('seconds') + $seconds;

        if ($total_seconds >= 60) {
            $extra_minutes  = floor($total_seconds / 60);
            $total_minutes += $extra_minutes;
        }

        $code = "99457";
        if ($total_minutes >= 20) {
            $code = "99458";
        }

        RpmCode::create([
            'patient_id'    => $patient_id,
            'time_track_id' => $id,
            'code'          => $code,
            'minutes'       => $minutes,
            'seconds'       => $seconds,
            'note'          => $note,
        ]);

        $this->updateRpmSummary($patient_id);
    }

    public function updated(TimeTrack $timeTrack)
    {
        RpmCode::where('time_track_id', $timeTrack->id)->update([
            'minutes' => $timeTrack->minutes,
            'seconds' => $timeTrack->seconds,
        ]);

        if ($timeTrack->engagement_type == "Phone Call" || $timeTrack->engagement_type == "Video Call") {
            PatientPhoneCall::updateOrCreate(
                [
                    'patient_id'    => $timeTrack->patient_id,
                    'time_track_id' => $timeTrack->id,
                ],
                [
                    'date' => $timeTrack->engagement_date,
                ]
            );
        }

        $this->updateRpmSummary($timeTrack->patient_id);
    }

    public function deleted(TimeTrack $timeTrack)
    {
        RpmCode::where('time_track_id', $timeTrack->id)->delete();
        $this->updateRpmSummary($timeTrack->patient_id);
    }

    public function restored(TimeTrack $timeTrack)
    {
        //
    }

    public function forceDeleted(TimeTrack $timeTrack)
    {
        //
    }

    private function updateRpmSummary($patient_id)
    {
        try {
            if (!$patient_id) return;

            $total_minutes = TimeTrack::where('patient_id', $patient_id)
                ->whereMonth('engagement_date', Carbon::now()->month)
                ->whereYear('engagement_date', Carbon::now()->year)
                ->sum('minutes');

            $total_seconds = TimeTrack::where('patient_id', $patient_id)
                ->whereMonth('engagement_date', Carbon::now()->month)
                ->whereYear('engagement_date', Carbon::now()->year)
                ->sum('seconds');

            $days_with_reading_count = DB::table('patient_data')
                ->where('patient_id', $patient_id)
                ->whereMonth('date_time', Carbon::now()->month)
                ->whereYear('date_time', Carbon::now()->year)
                ->selectRaw('COUNT(DISTINCT DATE(date_time)) as days')
                ->value('days') ?? 0;

            $has_phone_call = PatientPhoneCall::where('patient_id', $patient_id)
                ->whereMonth('date', Carbon::now()->month)
                ->whereYear('date', Carbon::now()->year)
                ->exists() ? 1 : 0;

            DB::table('patient_rpm_summary')->updateOrInsert(
                ['patient_id' => $patient_id],
                [
                    'total_minutes'           => $total_minutes,
                    'total_seconds'           => $total_seconds,
                    'days_with_reading_count' => $days_with_reading_count,
                    'has_phone_call'          => $has_phone_call,
                    'updated_at'              => now(),
                ]
            );
        } catch (\Exception $e) {
            Log::error('TimeTrackObserver RPM summary update failed for patient ' . $patient_id . ': ' . $e->getMessage());
        }
    }
}
