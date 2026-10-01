<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Appointment extends Model
{
    use HasFactory;
    protected $guarded = [
        'id'
    ];

    public function setTitleAttribute($title)
    {
        $this->attributes['title'] = $title;
        $this->attributes['slug'] = $this->slug($title);
    }

    public function slug($title)
    {
        $check = Appointment::latest()->first();
        $max = 1;
        if ($check != null) {

            $max = Appointment::latest('id')->first()->id + 1;
        }
        $slug = Str::slug($title);
        if (Appointment::where('slug', $slug)->exists()) {
            $slug = $slug . $max;
        } else {
            $slug = $slug;
        }
        return $slug;
    }
    public function getStartDateFormatAttribute()
    {
        return Carbon::createFromFormat('m-d-Y', $this->attributes['start_date'])->format('Y-m-d');
    }
    public function getEndDateFormatAttribute()
    {
        return Carbon::createFromFormat('m-d-Y', $this->attributes['end_date'])->format('Y-m-d');

        // return Carbon::parse($this->attributes['end_date'])->format('Y-m-d');
    }
    // public function getStartTimeFormatAttribute()
    // {
    //     return Carbon::parse($this->attributes['start_time'])->format('h:i A');
    // }
    // public function getEndTimeFormatAttribute()
    // {
    //     return Carbon::parse($this->attributes['end_time'])->format('h:i A');
    // }
    // public function getStartFormatAttribute()
    // {
    //     $full_date = explode('T', $this->attributes['start']);
    //     $date_start = $full_date [0];
        
    //   return Carbon::createFromFormat('m-d-Y', $date_start)->format('Y-m-d H:i:s');
    //   // return Carbon::parse($this->attributes['start'])->format('Y-d-m H:i:s');
   
    // }
    // public function getEndFormatAttribute()
    // {
    //     $full_date = explode('T', $this->attributes['end']);
    //     $date_end = $full_date [0];    
    //     return Carbon::createFromFormat('m-d-Y', $date_end)->format('Y-m-d H:i:s');
    //   //  return Carbon::parse($this->attributes['end'])->format('Y-d-m H:i:s');
    // }
}
