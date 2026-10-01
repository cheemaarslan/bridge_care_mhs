<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TreatmentGoal extends Model
{
    use HasFactory;
    protected $guarded = [
        'id'
    ];

    public function setGoalNameAttribute($goal_name)
    {
        $this->attributes['goal_name'] = $goal_name;
        $this->attributes['slug'] = $this->slug($goal_name);
    }

    public function slug($goal_name)
    {
        $check = TreatmentGoal::latest()->first();
        $max=1;
        if($check != null){

            $max = TreatmentGoal::latest('id')->first()->id + 1;
        }  
        $slug = Str::slug($goal_name);
        if(TreatmentGoal::where('slug', $slug)->exists()){
            $slug = $slug.$max;
        }
        else{
            $slug = $slug;
        }
        return $slug;
    }
}
