<?php

namespace App\Models;

use App\Notifications\PatientReading;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Notification;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PatientData extends Model
{
    use HasFactory;
    protected $guarded = [
        'id'
    ];
    protected $appends = ['formatted_actual_date','timestamp','category'];


    public function getFormattedDateAttribute()
    {
        return Carbon::parse($this->attributes['date_time'])->diffForHumans();
    }
    // public function getFormattedActualDateAttribute()
    // {
    //     return Carbon::parse($this->attributes['date_time'])->format('m-d-Y');
    // }

    public function getFormattedActualDateAttribute()
    {
        if (!isset($this->attributes['date_time'])) {
            return 'N/A'; // or return 'N/A'; or any default
        }

        return \Carbon\Carbon::parse($this->attributes['date_time'])->format('m-d-Y');
    }

    // public function getTimeStampAttribute()
    // {
    //     return Carbon::parse($this->attributes['date_time'])->timestamp;
    // }

    public function getTimeStampAttribute()
    {
        return isset($this->attributes['date_time']) && $this->attributes['date_time']
            ? Carbon::parse($this->attributes['date_time'])->timestamp
            : null;
    }

    // old code
    // public function getCategoryAttribute()
    // {
    //     $data = json_decode($this->attributes['data'], true);
    //     $sys = $data['sys'];
    //     $dia = $data['dia'];
    //     if($sys > 0 && $dia > 0){
    //         $category = "Crisis";
    //         if($sys <= 129 && $dia <= 79){
    //             $category = "Normal";
    //         }
    //         if(in_array($sys, range(130,139)) || in_array($dia, range(80,89))){
    //             $category = "Stage-1";
    //         }
    //         if(in_array($sys, range(140,164)) || in_array($dia, range(90,119))){
    //             $category = "Stage-2";
    //         }
    //         if($sys >= 165 || $dia >= 120){
    //             $category = "Crisis";
    //         }
    //         return $category;
    //     }
    //     else{
    //         return '-';
    //     }
    // }




    public function getCategoryAttribute()
    {
        if (!isset($this->attributes['data']) || empty($this->attributes['data'])) {
            return '-';
        }

        $data = json_decode($this->attributes['data'], true);

        if (json_last_error() !== JSON_ERROR_NONE || !is_array($data) || !isset($data['sys'], $data['dia'])) {
            return '-';
        }

        $sys = $data['sys'];
        $dia = $data['dia'];

      if($sys > 0 && $dia > 0){
            $category = "Crisis";
            if($sys <= 129 && $dia <= 79){
                $category = "Normal";
            }
            if(in_array($sys, range(130,139)) || in_array($dia, range(80,89))){
                $category = "Stage-1";
            }
            if(in_array($sys, range(140,164)) || in_array($dia, range(90,119))){
                $category = "Stage-2";
            }
            if($sys >= 165 || $dia >= 120){
                $category = "Crisis";
            }
            return $category;

        }
        else{
            return '-';
        }
    }

    protected $casts = [
        'data' => 'array'
    ];



    /**
     * Get the patient that owns the PatientData
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function patient()
    {
        return $this->belongsTo(Patient::class, 'patient_id');
    }
    public function device()
    {
        return $this->belongsTo(Device::class, 'device_id');
    }
}
