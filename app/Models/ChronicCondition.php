<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ChronicCondition extends Model
{
    use HasFactory;
    protected $guarded = [
        'id'
    ];

    public function patients()
    {
        return $this->belongsToMany(Patient::class, 'patient_chronic_conditions', 'patient_id', 'chronic_condition_id')->withPivot('patient_id','chronic_condition_id')->withTimestamps();
    }
    /**
     * Get all of the comments for the ChronicCondition
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function planned_interventions()
    {
        return $this->hasMany(PlannedIntervention::class);
    }

}
