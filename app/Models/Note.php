<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
    use HasFactory;

    protected $guarded = [
        'id',
    ];
    protected $appends = [
        'formatted_date'
    ];


    public function getFormattedDateAttribute()
    {
        if($this->attributes['date']){
            return Carbon::createFromFormat('Y-m-d', $this->attributes['date'])->format('m-d-Y');
        }
        else{
            return '-';
        }
    }
    public function setDateAttribute($value)
    {
        if($value){
            $this->attributes['date'] = set_format($value);
        }
        else{
            return '-';
        }
    }

    /**
     * Get the user that owns the Note
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function care_plan()
    {
        return $this->belongsTo(CarePlan::class, 'care_plan_id');
    }
    public function monthly_review()
    {
        return $this->belongsTo(MonthlyReview::class, 'monthly_review_id');
    }
}
