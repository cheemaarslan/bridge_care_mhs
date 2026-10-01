<?php

namespace App\Models;

use Carbon\Carbon;
use App\Models\Note;
use App\Models\User;
use App\Models\Patient;
use App\Models\Medication;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MonthlyReview extends Model
{
    use HasFactory;
    protected $guarded = [
        'id'
    ];
    protected $appends = [
        'formatted_completed_at',
    ];
    public function getFormattedCompletedAtAttribute()
    {
        if($this->attributes['status'] == "Complete"){
            return Carbon::createFromFormat('Y-m-d', $this->attributes['completed_at'])->format('m-d-Y');
        }
        else{
            return '-';
        }
    }

    public function monthly_review_created_by()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function patient()
    {
        return $this->belongsTo(Patient::class, 'patient_id');
    }

    public function medications()
    {
        return $this->hasMany(Medication::class);
    }
    public function notes()
    {
        return $this->hasMany(Note::class);
    }
}
