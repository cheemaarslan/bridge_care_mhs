<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PatientRpmSummary extends Model
{
    protected $table = 'patient_rpm_summary';
    public $timestamps = false;

    protected $fillable = [
        'patient_id',
        'avg_sys',
        'avg_dia',
        'avg_pul',
        'last_sys',
        'last_dia',
        'last_pul',
        'last_reading_time',
        'category_order',
        'status_order',
        'total_minutes',
        'total_seconds',
        'days_with_reading_count',
        'has_phone_call',
        'updated_at'
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

 
}
