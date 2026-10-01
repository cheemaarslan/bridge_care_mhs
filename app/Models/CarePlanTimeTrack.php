<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CarePlanTimeTrack extends Model
{
    use HasFactory;
    
    protected $guarded = [
        'id',
    ];

    public function getFormattedDateAttribute()
    {
        return Carbon::parse($this->attributes['created_at'])->format('Y-m-d');
    }
    public function getFormattedTimeAttribute()
    {
        return Carbon::parse($this->attributes['created_at'])->format('h:i A');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function scheme()
    {
        return $this->belongsTo(CarePlanScheme::class, 'care_plan_scheme_id');
    }
}
