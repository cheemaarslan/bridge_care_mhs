<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Symfony\Component\Console\Question\Question;

class CarePlanScheme extends Model
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
        $check = CarePlanScheme::latest()->first();
        $max=1;
        if($check != null){

            $max = CarePlanScheme::latest('id')->first()->id + 1;
        }  
        $slug = Str::slug($scheme_name);
        if(CarePlanScheme::where('slug', $slug)->exists()){
            $slug = $slug.$max;
        }
        else{
            $slug = $slug;
        }
        return $slug;
    }
    /**
     * Get all of the comments for the CarePlanScheme
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function questions()
    {
        return $this->hasMany(CarePlanQuestion::class);
    }

}
