<?php

namespace App\Models;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Patient;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MyNotes extends Model
{
    use HasFactory;

    protected $guarded = [
        'id',
    ];
    protected $appends = [
        'formatted_date'
    ];


    public function getFormattedDateAttribute()
    {
        if (isset($this->attributes['date'])) {
            return Carbon::createFromFormat('Y-m-d', $this->attributes['date'])->format('m-d-Y');
        } else {
            return '-';
        }
    }

    public function setDateAttribute($value)
    {
        if($value){
            $this->attributes['date'] = set_format($value);
        }
        else{
            return '-';
        }
    }
    public function patient()
    {
        return $this->belongsTo(Patient::class, 'patient_id');
    }
}
