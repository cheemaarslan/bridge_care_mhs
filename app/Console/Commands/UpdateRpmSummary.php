<?php

namespace App\Console\Commands;

use App\Models\Patient;
use App\Models\Setting;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class UpdateRpmSummary extends Command
{
    protected $signature = 'rpm:update-summary {--patient_id=}';
    protected $description = 'Update RPM patient summary cache';

    public function handle()
    {
        $startTime = microtime(true);
        Log::info('Starting RPM Summary Update Command');

        $rpm_record_from = Setting::search('rpm_record_from');
        $to   = Carbon::now()->toDateString();
        $from = Carbon::now()->subMonth()->toDateString();

        if ($rpm_record_from) {
            $from = $rpm_record_from;
        }

        $patientId = $this->option('patient_id');

        // ── Build patient base query ─────────────────────────────────────────
        $patientsQuery = Patient::query()
            ->where('enrol_in_rpm', true)
            ->where('status', true);

        if ($patientId) {
            $patientsQuery->where('id', $patientId);
        }

        $patientIds = $patientsQuery->pluck('id')->toArray();

        if (empty($patientIds)) {
            $this->info('No RPM patients found.');
            return;
        }

        $this->info('Updating ' . count($patientIds) . ' patients...');

        // ── Step A: All averages in one query ────────────────────────────────
        $avgData = DB::table('patient_data')
            ->whereIn('patient_id', $patientIds)
            ->selectRaw('
                patient_id,
                AVG(CAST(JSON_UNQUOTE(JSON_EXTRACT(data, "$.sys")) AS DECIMAL(10,2))) as avg_sys,
                AVG(CAST(JSON_UNQUOTE(JSON_EXTRACT(data, "$.dia")) AS DECIMAL(10,2))) as avg_dia,
                AVG(CAST(JSON_UNQUOTE(JSON_EXTRACT(data, "$.pul")) AS DECIMAL(10,2))) as avg_pul
            ')
            ->groupBy('patient_id')
            ->get()
            ->keyBy('patient_id');

        // ── Step B: Last reading per patient in one query ────────────────────
        $lastReadingData = DB::table('patient_data as pd')
            ->join(
                DB::raw('(SELECT patient_id, MAX(date_time) as max_dt
                          FROM patient_data
                          WHERE patient_id IN (' . implode(',', $patientIds) . ')
                          GROUP BY patient_id) as latest'),
                function ($join) {
                    $join->on('pd.patient_id', '=', 'latest.patient_id')
                         ->on('pd.date_time',  '=', 'latest.max_dt');
                }
            )
            ->select([
                'pd.patient_id',
                DB::raw('JSON_UNQUOTE(JSON_EXTRACT(pd.data, "$.sys")) as last_sys'),
                DB::raw('JSON_UNQUOTE(JSON_EXTRACT(pd.data, "$.dia")) as last_dia'),
                DB::raw('JSON_UNQUOTE(JSON_EXTRACT(pd.data, "$.pul")) as last_pul'),
                'pd.date_time as last_reading_time',
            ])
            ->get()
            ->keyBy('patient_id');

        // ── Step C: Days with reading in date range in one query ─────────────
        $daysData = DB::table('patient_data')
            ->whereIn('patient_id', $patientIds)
            ->whereBetween('date_time', [$from, $to])
            ->selectRaw('patient_id, COUNT(DISTINCT DATE(date_time)) as days_count')
            ->groupBy('patient_id')
            ->get()
            ->keyBy('patient_id');

        // ── Step D: Time tracking in date range in one query ─────────────────
        $timeData = DB::table('time_tracks')
            ->whereIn('patient_id', $patientIds)
            ->whereBetween('engagement_date', [$from, $to])
            ->selectRaw('
                patient_id,
                COALESCE(SUM(minutes), 0) as total_minutes,
                COALESCE(SUM(seconds), 0) as total_seconds
            ')
            ->groupBy('patient_id')
            ->get()
            ->keyBy('patient_id');

        // ── Step E: Phone calls in date range in one query ───────────────────
        $callData = DB::table('patient_phone_calls')
            ->whereIn('patient_id', $patientIds)
            ->whereBetween('date', [$from, $to])
            ->selectRaw('patient_id, 1 as has_call')
            ->groupBy('patient_id')
            ->get()
            ->keyBy('patient_id');

        // ── Step F: Build upsert rows in PHP, one bulk upsert ────────────────
        $rows = [];
        $now  = now()->toDateTimeString();

        foreach ($patientIds as $pid) {
            $avg     = $avgData->get($pid);
            $last    = $lastReadingData->get($pid);
            $days    = $daysData->get($pid);
            $time    = $timeData->get($pid);
            $hasCall = $callData->has($pid);

            $avg_sys = $avg->avg_sys ?? 0;
            $avg_dia = $avg->avg_dia ?? 0;
            $last_sys = $last->last_sys ?? 0;
            $last_dia = $last->last_dia ?? 0;

            // Category order
            if ($avg_sys >= 165 || $avg_dia >= 120)     $category_order = 4;
            elseif ($avg_sys >= 140 || $avg_dia >= 90)  $category_order = 3;
            elseif ($avg_sys >= 130 || $avg_dia >= 80)  $category_order = 2;
            else                                         $category_order = 1;

            // Status order
            if ($last_sys >= 165 || $last_dia >= 120)     $status_order = 4;
            elseif ($last_sys >= 140 || $last_dia >= 90)  $status_order = 3;
            elseif ($last_sys >= 130 || $last_dia >= 80)  $status_order = 2;
            else                                           $status_order = 1;

            $rows[] = [
                'patient_id'              => $pid,
                'avg_sys'                 => $avg->avg_sys ?? null,
                'avg_dia'                 => $avg->avg_dia ?? null,
                'avg_pul'                 => $avg->avg_pul ?? null,
                'last_sys'                => $last->last_sys ?? null,
                'last_dia'                => $last->last_dia ?? null,
                'last_pul'                => $last->last_pul ?? null,
                'last_reading_time'       => $last->last_reading_time ?? null,
                'category_order'          => $category_order,
                'status_order'            => $status_order,
                'total_minutes'           => $time->total_minutes ?? 0,
                'total_seconds'           => $time->total_seconds ?? 0,
                'days_with_reading_count' => $days->days_count ?? 0,
                'has_phone_call'          => $hasCall ? 1 : 0,
                'updated_at'              => $now,
            ];
        }

        // ── Single bulk upsert — one query for all patients ──────────────────
        // Process in chunks of 200 to avoid hitting MySQL packet limits
        foreach (array_chunk($rows, 200) as $chunk) {
            DB::table('patient_rpm_summary')->upsert(
                $chunk,
                ['patient_id'],  // unique key
                [                // columns to update
                    'avg_sys',
                    'avg_dia',
                    'avg_pul',
                    'last_sys',
                    'last_dia',
                    'last_pul',
                    'last_reading_time',
                    'category_order',
                    'status_order',
                    'total_minutes',
                    'total_seconds',
                    'days_with_reading_count',
                    'has_phone_call',
                    'updated_at',
                ]
            );
        }

        $elapsed = round(microtime(true) - $startTime, 2);

        Log::info("RPM Summary updated: " . count($patientIds) .
                  " patients in {$elapsed}s");

        $this->info('RPM Summary updated successfully! ' .
                    count($patientIds) . ' patients in ' . $elapsed . 's');
    }
}
