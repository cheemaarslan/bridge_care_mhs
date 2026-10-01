<?php

namespace Database\Seeders;

use App\Models\DeviceData;
use App\Models\Patient;
use App\Models\PatientData;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Patient::factory()->count(10)->create();
        PatientData::factory()->count(200)->create();
    }
}
