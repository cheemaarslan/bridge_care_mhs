<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MonthlyReviewScheme extends Model
{
    use HasFactory;
    protected $guarded = [
        'id'
    ];

    public function setSchemeNameAttribute($scheme_name)
    {
        $this->attributes['scheme_name'] = $scheme_name;
        $this->attributes['slug'] = $this->slug($scheme_name);
    }

    public function slug($scheme_name)
    {
        $check = MonthlyReviewScheme::latest()->first();
        $max=1;
        if($check != null){

            $max = MonthlyReviewScheme::latest('id')->first()->id + 1;
        }  
        $slug = Str::slug($scheme_name);
        if(MonthlyReviewScheme::where('slug', $slug)->exists()){
            $slug = $slug.$max;
        }
        else{
            $slug = $slug;
        }
        return $slug;
    }

    
    public function questions()
    {
        return $this->hasMany(MonthlyReviewQuestion::class);
    }

}
