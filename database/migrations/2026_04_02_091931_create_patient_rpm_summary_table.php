<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        Schema::create('patient_rpm_summary', function (Blueprint $table) {
            $table->unsignedBigInteger('patient_id')->primary();
            $table->decimal('avg_sys', 8, 2)->nullable();
            $table->decimal('avg_dia', 8, 2)->nullable();
            $table->decimal('avg_pul', 8, 2)->nullable();
            $table->string('last_sys')->nullable();
            $table->string('last_dia')->nullable();
            $table->string('last_pul')->nullable();
            $table->datetime('last_reading_time')->nullable();
            $table->timestamp('updated_at')->nullable();

            $table->foreign('patient_id')
                  ->references('id')
                  ->on('patients')
                  ->onDelete('cascade');
        });

        // Populate immediately with existing data
        DB::statement("
            INSERT INTO patient_rpm_summary
                (patient_id, avg_sys, avg_dia, avg_pul,
                 last_sys, last_dia, last_pul,
                 last_reading_time, updated_at)
            SELECT
                pd.patient_id,
                AVG(CAST(JSON_UNQUOTE(JSON_EXTRACT(pd.data, '$.sys')) AS DECIMAL(10,2))) as avg_sys,
                AVG(CAST(JSON_UNQUOTE(JSON_EXTRACT(pd.data, '$.dia')) AS DECIMAL(10,2))) as avg_dia,
                AVG(CAST(JSON_UNQUOTE(JSON_EXTRACT(pd.data, '$.pul')) AS DECIMAL(10,2))) as avg_pul,
                latest.last_sys,
                latest.last_dia,
                latest.last_pul,
                latest.last_reading_time,
                NOW()
            FROM patient_data pd
            JOIN (
                SELECT
                    pd2.patient_id,
                    JSON_UNQUOTE(JSON_EXTRACT(pd2.data, '$.sys')) as last_sys,
                    JSON_UNQUOTE(JSON_EXTRACT(pd2.data, '$.dia')) as last_dia,
                    JSON_UNQUOTE(JSON_EXTRACT(pd2.data, '$.pul')) as last_pul,
                    pd2.date_time as last_reading_time
                FROM patient_data pd2
                JOIN (
                    SELECT patient_id, MAX(date_time) as max_dt
                    FROM patient_data
                    GROUP BY patient_id
                ) as mx ON pd2.patient_id = mx.patient_id
                       AND pd2.date_time  = mx.max_dt
            ) as latest ON pd.patient_id = latest.patient_id
            GROUP BY pd.patient_id,
                     latest.last_sys,
                     latest.last_dia,
                     latest.last_pul,
                     latest.last_reading_time
        ");
    }

    public function down()
    {
        Schema::dropIfExists('patient_rpm_summary');
    }
};
