<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CcmCode extends Model
{
    use HasFactory;
    protected $guarded = [
        'id'
    ];
    protected $appends = [
        'last_ccm_performed'
    ];

    public function getLastCcmPerformedAttribute()
    {
        return Carbon::parse($this->attributes['created_at'])->format('m-d-Y');
    }
    public function patient()
    {
        return $this->belongsTo(Patient::class, 'patient_id')->where('status', 1);
    }
    public function simple()
    {
        return $this->belongsTo(Patient::class, 'patient_id')->where('ccm_type', 'Simple');
    }
    public function complex()
    {
        return $this->belongsTo(Patient::class, 'patient_id')->where('ccm_type', 'Complex');
    }
    public function care_plan()
    {
        return $this->belongsTo(Patient::class, 'care_plan_id');
    }
    public function monthly_review()
    {
        return $this->belongsTo(Patient::class, 'monthly_review_id');
    }
}
