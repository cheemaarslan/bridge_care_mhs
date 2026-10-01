<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Test extends Model
{
    use HasFactory;
    protected $guarded = [
        'id'
    ];

    public function setTestNameAttribute($test_name)
    {
        $this->attributes['test_name'] = $test_name;
        $this->attributes['slug'] = $this->slug($test_name);
    }

    public function slug($test_name)
    {
        $check = Test::latest()->first();
        $max=1;
        if($check != null){

            $max = Test::latest('id')->first()->id + 1;
        }  
        $slug = Str::slug($test_name);
        if(Test::where('slug', $slug)->exists()){
            $slug = $slug.$max;
        }
        else{
            $slug = $slug;
        }
        return $slug;
    }
}
