<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CoordinatorApplication extends Model
{
    use HasFactory;
    protected $guarded = [
        'id'
    ];
    public function getUserImageAttribute()
    {
        return asset('images/users/'.$this->attributes['user_image']);
    }

    public function setFirstNameAttribute($first_name)
    {
        $this->attributes['first_name'] = $first_name;
        $this->attributes['slug'] = $this->slug($first_name);
    }

    public function slug($first_name)
    {
        $check = CoordinatorApplication::latest()->first();
        $max = 1;
        if ($check != null) {

            $max = CoordinatorApplication::latest('id')->first()->id + 1;
        }
        $slug = Str::slug($first_name);
        if (CoordinatorApplication::where('slug', $slug)->exists()) {
            $slug = $slug . $max;
        } else {
            $slug = $slug;
        }
        return $slug;
    }
}
