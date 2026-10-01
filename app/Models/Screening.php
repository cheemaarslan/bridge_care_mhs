<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Screening extends Model
{
    use HasFactory;
    protected $guarded = [
        'id'
    ];

    public function setScreeningNameAttribute($screening_name)
    {
        $this->attributes['screening_name'] = $screening_name;
        $this->attributes['slug'] = $this->slug($screening_name);
    }

    public function slug($screening_name)
    {
        $check = Screening::latest()->first();
        $max=1;
        if($check != null){

            $max = Screening::latest('id')->first()->id + 1;
        }  
        $slug = Str::slug($screening_name);
        if(Screening::where('slug', $slug)->exists()){
            $slug = $slug.$max;
        }
        else{
            $slug = $slug;
        }
        return $slug;
    }
}
