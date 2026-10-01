<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Patient;
use App\Models\Insurance;
use App\Models\Practice;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Patient>
 */
class PatientFactory extends Factory
{

    protected $model = Patient::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $patient = new Patient();
        $first_name = $this->faker->firstName();
        $last_name = $this->faker->lastName();

        return [
            'patient_id' => $patient->unique_code(),
            'first_name' =>  $first_name,
            'last_name' => $last_name,
            'slug' => $patient->slug($first_name),
            'gender' => $this->faker->randomElement(['Male','Female']),
            'age' => rand(50,80),
            'dob' => $this->faker->dateTimeBetween('01-01-1950', '01-01-1970')->format('m-d-Y'),
            'email' => $this->faker->unique()->safeEmail(),
            'address' => $this->faker->address(),
            'contact_no' => '+1'.$this->faker->numerify('##########'),
            'care_manager_id'=> User::whereHas("roles", function($q){
                $q->where('name', '=', 'care-manager');
            })->inRandomOrder()->first()->id,
            'insurance_id' => Insurance::inRandomOrder()->first()->id,
            'practice_id' => 1,
            'enrol_in_ccm' => 1,
            'ccm_enrol_date' => $this->faker->dateTimeBetween('01-01-2019', '01-01-2022')->format('m-d-Y'),
            'ccm_type' => 'Simple',
            'consent' => 'Verbal Consent',
            'preferred_communication' => $this->faker->randomElement(['text','call', 'email']),
            'preferred_language' => $this->faker->randomElement(['any_time','morning', 'evening']),
            'preferred_time' => 'english',
            
        ];
    }
}
