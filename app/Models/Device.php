<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Device extends Model
{
    use HasFactory;
    protected $guarded = [
        'id'
    ];
    public function setInstallDateAttribute($value)
    {
        if ($value){
            $this->attributes['install_date'] = set_format($value);
        }
    }
    public function setSetupDateAttribute($value)
    {
        if($value){
            $this->attributes['setup_date'] = set_format($value);

        }
    }
    public function getInstallDateAttribute()
    {
        if($this->attributes['install_date']){
            return Carbon::createFromFormat('Y-m-d', $this->attributes['install_date'])->format('m-d-Y');
        }
    }
    public function getSetupDateAttribute()
    {
        if($this->attributes['setup_date']){
            return Carbon::createFromFormat('Y-m-d', $this->attributes['setup_date'])->format('m-d-Y');
        }
    }

    public function patient()
    {
        return $this->belongsTo(Patient::class, 'patient_id');
    }

    public function data()
    {
        return $this->hasMany(PatientData::class)->latest('date_time');
    }
}
