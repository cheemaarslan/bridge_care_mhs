<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('patient_phone_calls', function (Blueprint $table) {
            $table->index(['patient_id', 'date'], 'idx_ppc_patient_date');
        });
    }

    public function down()
    {
        Schema::table('patient_phone_calls', function (Blueprint $table) {
            $table->dropIndex('idx_ppc_patient_date');
        });
    }
};
