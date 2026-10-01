<?php

namespace App\Models;

use App\Models\User;
use App\Models\Patient;
use App\Models\CarePlan;
use App\Models\Appointment;
use App\Models\CarePlanAnswer;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ActivityLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'model_type',
        'model_id',
        'subject',
        'description',
    ];

    /**
     * The user that the log belongs to.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    // In ActivityLog.php
// In ActivityLog.php
public function appointment()
{
    return $this->belongsTo(Appointment::class, 'model_id')->where('model_type', Appointment::class);
}
//add patient relationship to activity log model
public function patient()
{
    return $this->belongsTo(Patient::class, 'model_id')->where('model_type', Patient::class);
}

//add care plan relationship to activity log model
public function carePlan()
{
    return $this->belongsTo(CarePlan::class, 'model_id')->where('model_type', CarePlan::class);

}
//add relation care plan answer to activity log model
public function carePlanAnswer()
{
    return $this->belongsTo(CarePlanAnswer::class, 'model_id')->where('model_type', CarePlanAnswer::class);
}

}
