<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use App\Models\Setting;
use Carbon\Carbon;

return new class extends Migration
{
    public function up()
    {
        Schema::table('patient_rpm_summary', function (Blueprint $table) {
            $table->integer('category_order')->default(1)->after('last_reading_time');
            $table->integer('status_order')->default(1)->after('category_order');
            $table->integer('total_minutes')->default(0)->after('status_order');
            $table->integer('total_seconds')->default(0)->after('total_minutes');
            $table->integer('days_with_reading_count')->default(0)->after('total_seconds');
            $table->boolean('has_phone_call')->default(false)->after('days_with_reading_count');
        });

        // Populate the new columns for existing rows
        $rpm_record_from = Setting::search('rpm_record_from');
        $to   = Carbon::now()->toDateString();
        $from = Carbon::now()->subMonth()->toDateString();
        if ($rpm_record_from) {
            $from = $rpm_record_from;
        }

        DB::statement("
            UPDATE patient_rpm_summary rpm
            LEFT JOIN (
                SELECT patient_id,
                       COUNT(DISTINCT DATE(date_time)) as days_count
                FROM patient_data
                WHERE date_time BETWEEN '{$from}' AND '{$to}'
                GROUP BY patient_id
            ) dwr ON dwr.patient_id = rpm.patient_id
            LEFT JOIN (
                SELECT patient_id,
                       COALESCE(SUM(minutes), 0) as total_minutes,
                       COALESCE(SUM(seconds), 0) as total_seconds
                FROM time_tracks
                WHERE engagement_date BETWEEN '{$from}' AND '{$to}'
                GROUP BY patient_id
            ) tt ON tt.patient_id = rpm.patient_id
            LEFT JOIN (
                SELECT patient_id, 1 as has_call
                FROM patient_phone_calls
                WHERE date BETWEEN '{$from}' AND '{$to}'
                GROUP BY patient_id
            ) pc ON pc.patient_id = rpm.patient_id
            SET
                rpm.category_order = CASE
                    WHEN COALESCE(rpm.avg_sys, 0) >= 165 OR COALESCE(rpm.avg_dia, 0) >= 120 THEN 4
                    WHEN COALESCE(rpm.avg_sys, 0) >= 140 OR COALESCE(rpm.avg_dia, 0) >= 90  THEN 3
                    WHEN COALESCE(rpm.avg_sys, 0) >= 130 OR COALESCE(rpm.avg_dia, 0) >= 80  THEN 2
                    ELSE 1
                END,
                rpm.status_order = CASE
                    WHEN CAST(COALESCE(rpm.last_sys, 0) AS SIGNED) >= 165 OR CAST(COALESCE(rpm.last_dia, 0) AS SIGNED) >= 120 THEN 4
                    WHEN CAST(COALESCE(rpm.last_sys, 0) AS SIGNED) >= 140 OR CAST(COALESCE(rpm.last_dia, 0) AS SIGNED) >= 90  THEN 3
                    WHEN CAST(COALESCE(rpm.last_sys, 0) AS SIGNED) >= 130 OR CAST(COALESCE(rpm.last_dia, 0) AS SIGNED) >= 80  THEN 2
                    ELSE 1
                END,
                rpm.total_minutes           = COALESCE(tt.total_minutes, 0),
                rpm.total_seconds           = COALESCE(tt.total_seconds, 0),
                rpm.days_with_reading_count = COALESCE(dwr.days_count, 0),
                rpm.has_phone_call          = CASE WHEN pc.has_call IS NOT NULL THEN 1 ELSE 0 END
        ");
    }

    public function down()
    {
        Schema::table('patient_rpm_summary', function (Blueprint $table) {
            $table->dropColumn([
                'category_order',
                'status_order',
                'total_minutes',
                'total_seconds',
                'days_with_reading_count',
                'has_phone_call',
            ]);
        });
    }
};
