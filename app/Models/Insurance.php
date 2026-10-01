<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Insurance extends Model
{
    use HasFactory;
    protected $guarded = [
        'id'
    ];

    public function setInsuranceNameAttribute($insurance_name)
    {
        $this->attributes['insurance_name'] = $insurance_name;
        $this->attributes['slug'] = $this->slug($insurance_name);
    }

    public function slug($first_name)
    {
        $check = Insurance::latest()->first();
        $max=1;
        if($check != null){

            $max = Insurance::latest('id')->first()->id + 1;
        }
        $slug = Str::slug($first_name);
        if(Insurance::where('slug', $slug)->exists()){
            $slug = $slug.$max;
        }
        else{
            $slug = $slug;
        }
        return $slug;
    }

}

