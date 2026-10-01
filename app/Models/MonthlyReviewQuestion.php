<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MonthlyReviewQuestion extends Model
{
    use HasFactory;
    protected $guarded = [
        'id'
    ];
    
    protected $casts = [
        'option' => 'array'
    ];


    public function schemes()
    {
        return $this->belongsTo(MonthlyReviewScheme::class, 'monthly_review_scheme_id');
    }

    /**
     * Get the answer associated with the CarePlanQuestion
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function answer()
    {
        return $this->hasOne(MonthlyReviewAnswer::class);
    }
}
