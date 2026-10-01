<?php

namespace App\Models;

use Carbon\Carbon;
use App\Models\MyNotes;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Patient extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [
        'id',
    ];

    public function getPatientImageAttribute()
    {
        return asset('/images/patients/' . $this->attributes['patient_image']);
    }
    public function setFirstNameAttribute($first_name)
    {
        $this->attributes['first_name'] = $first_name;
    }

    function unique_code()
    {
        $check = Patient::latest()->first();
        $max = 1;
        if ($check != null) {

            $max = Patient::latest('id')->first()->id + 1;
        }
        $string = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $code = substr(str_shuffle($string), 0, 10);
        return $code . $max;
    }
    public function slug($first_name)
    {
        $check = Patient::latest()->first();
        $max = 1;
        if ($check != null) {

            $max = Patient::latest('id')->first()->id + 1;
        }
        $slug = Str::slug($first_name);
        if (Patient::where('slug', $slug)->exists()) {
            $slug = $slug . $max;
        } else {
            $slug = $slug;
        }
        return $slug;
    }

    public function getDobAttribute()
    {
        return Carbon::createFromFormat('Y-m-d', $this->attributes['dob'])->format('m-d-Y');
    }
    public function setDobAttribute($value)
    {
        $this->attributes['dob'] = set_format($value);
    }

    public function getFormattedCcmEnrolDateAttribute()
    {
        if($this->attributes['ccm_enrol_date']){
            return Carbon::createFromFormat('Y-m-d', $this->attributes['ccm_enrol_date'])->format('m-d-Y');
        }
        else{
            return '-';
        }
    }
    public function setCcmEnrolDateAttribute($value)
    {
        if($value){
            $this->attributes['ccm_enrol_date'] = set_format($value);
        }
        else{
            return '-';
        }
    }
    public function getFormattedRpmEnrolDateAttribute()
    {
        if($this->attributes['rpm_enrol_date']){
            return Carbon::createFromFormat('Y-m-d', $this->attributes['rpm_enrol_date'])->format('m-d-Y');
        }
        else{
            return '-';
        }
    }
    public function setRpmEnrolDateAttribute($value)
    {
        if($value){
            $this->attributes['rpm_enrol_date'] = set_format($value);
        }
        else{
            return '-';
        }
    }

    public function getFormattedLastCheckedAttribute()
    {
        if($this->attributes['last_checked']){
            return Carbon::parse($this->attributes['last_checked'])->diffForHumans();
        }
        else{
            return '-';
        }
    }

    public function getFormattedLastCcmPerformedAttribute()
    {
        // Check if the attribute is set and not null
        if (isset($this->attributes['last_ccm_performed']) && !is_null($this->attributes['last_ccm_performed'])) {
            return Carbon::parse($this->attributes['last_ccm_performed'])->format('m-d-Y');
        } else {
            return '-';
        }
    }
    




    //HasOne Relationship

    public function care_plan()
    {
        return $this->hasOne(CarePlan::class)->where('active', true);
    }
    public function phone_call()
    {
        return $this->hasOne(PatientPhoneCall::class);
    }
    public function monthly_review()
    {
        return $this->hasOne(MonthlyReview::class)->where('active', true);
    }
    public function last_monthly_review()
    {
        return $this->hasOne(MonthlyReview::class);
    }


    public function device()
    {
        return $this->hasOne(Device::class);
    }
    public function last_patient_data()
    {
        return $this->hasOne(PatientData::class)->latest('date_time');
    }
    public function insurance()
    {
        return $this->belongsTo(Insurance::class, 'insurance_id');
    }
    public function practice()
    {
        return $this->belongsTo(Practice::class, 'patient_id');
    }
    public function care_manager()
    {
        return $this->belongsTo(User::class, 'care_manager_id');
    }
    public function doctor()
    {
        return $this->belongsTo(User::class, 'doctor_id');
    }
    public function chronic_conditions()
    {
        return $this->belongsToMany(ChronicCondition::class, 'patient_chronic_conditions', 'patient_id', 'chronic_condition_id')->withPivot('patient_id','chronic_condition_id')->withTimestamps();
    }

    //HasMany Relationship
    public function messages()
    {
        return $this->hasMany(Message::class);
    }
    public function latest_message()
    {
        return $this->hasOne(Message::class)->latest()->where('read', 0);
    }
    public function rpm_codes()
    {
        return $this->hasMany(RpmCode::class);
    }
    public function latest_ccm_code()
    {
        return $this->hasOne(CcmCode::class)->latest();
    }
    public function ccm_codes()
    {
        return $this->hasMany(CcmCode::class);
    }
    public function current_ccm_codes()
    {
        return $this->hasMany(CcmCode::class)->whereMonth('created_at', Carbon::now()->month);
    }
    public function medications()
    {
        return $this->hasMany(Medication::class)->latest();
    }
    public function notes()
    {
        return $this->hasMany(Note::class)->latest();
    }
    public function patient_data()
    {
        return $this->hasMany(PatientData::class)->latest('date_time');
    }
    public function time_tracks()
    {
        return $this->hasMany(TimeTrack::class)->latest();
    }
    public function patient_notes()
    {
        return $this->hasMany(MyNotes::class)->latest();
    }
    public function days_with_reading()
    {
        return $this->hasMany(PatientData::class)->latest();
    }
    public function appointments()
    {
        return $this->hasMany(Appointment::class)->latest();
    }

}
