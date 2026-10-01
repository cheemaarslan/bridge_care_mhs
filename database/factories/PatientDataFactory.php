<?php

namespace Database\Factories;

use Carbon\Carbon;
use App\Models\Device;
use App\Models\Patient;
use App\Models\PatientData;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PatientData>
 */
class PatientDataFactory extends Factory
{
    protected $model = PatientData::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'patient_id' => Patient::inRandomOrder()->first()->id,
            'date_time' => Carbon::now()->subDays(random_int(0, 30)),
            'data' => [
                'sys' => rand(80,170),
                'dia' => rand(70,120),
                'pul' => rand(70,120),
                'ihb' =>false,
                'hand' =>false,
            ],
        ];
    }
}
