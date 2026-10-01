<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Practice extends Model
{
    use HasFactory;
    protected $guarded = [
        'id'
    ];




    public function doctor()
    {
        return $this->hasOne(Patient::class)->whereHas('roles', function($query){
            $query->where('name', 'doctor');
        });
    }
    /**
     * Get the doctor associated with the Practice
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function users()
    {
        return $this->hasMany(User::class);
    }
    public function patients()
    {
        return $this->hasMany(Patient::class);
    }
    
}
