<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TimeTrack extends Model
{
    use HasFactory;
    protected $guarded = [
        'id'
    ];
    protected $appends = ['formatted_engagement_date'];

    public function getFormattedEngagementDateAttribute()
    {
        return Carbon::createFromFormat('Y-m-d', $this->attributes['engagement_date'])->format('m-d-Y');
    }

    public function patient()
    {
        return $this->belongsTo(Patient::class, 'patient_id');
    }
}
