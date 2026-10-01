<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class CarePlan extends Model
{
    use HasFactory, SoftDeletes;
    protected $appends = [
        'formatted_completed_at',
        'formatted_approved_at',
    ];
    protected $guarded = [
        'id'
    ];
    public function getFormattedCompletedAtAttribute()
    {
        if($this->attributes['status'] == "Complete" || $this->attributes['status'] == "Approved" || $this->attributes['status'] == "Awaiting Approval"){
            return Carbon::createFromFormat('Y-m-d', $this->attributes['completed_at'])->format('m-d-Y');
        }
        else{
            return '-';
        }
    }
    public function getFormattedApprovedAtAttribute()
    {
        if($this->attributes['status'] == "Approved"){
            return Carbon::createFromFormat('Y-m-d', $this->attributes['approved_at'])->format('m-d-Y');
        }
        else{
            return '-';
        }
    }

    public function patient()
    {
        return $this->belongsTo(Patient::class, 'patient_id');
    }
    public function care_plan_created_by()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
    public function care_plan_approved_by()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }





    public function time_tracks()
    {
        return $this->hasMany(CarePlanTimeTrack::class);
    }
    public function contacts()
    {
        return $this->hasMany(CarePlanContact::class);
    }
    public function medications()
    {
        return $this->hasMany(Medication::class);
    }
    public function planned_interventions()
    {
        return $this->hasMany(CarePlanPlannedIntervention::class);
    }
    public function treatment_goals()
    {
        return $this->hasMany(CarePlanTreatmentGoal::class);
    }
    public function care_plan_screenings()
    {
        return $this->hasMany(CarePlanScreening::class);
    }
    public function special_screenings()
    {
        return $this->hasMany(CarePlanSpecialScreening::class);
    }
    public function care_plan_tests()
    {
        return $this->hasMany(CarePlanTest::class);
    }
    public function notes()
    {
        return $this->hasMany(Note::class);
    }
}
