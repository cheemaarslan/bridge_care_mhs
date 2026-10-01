<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CarePlanQuestion extends Model
{
    use HasFactory;
    protected $guarded = [
        'id'
    ];

    protected $casts = [
        'option' => 'array'
    ];

    /**
     * Get the user that owns the CarePlanQuestion
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function schemes()
    {
        return $this->belongsTo(CarePlanScheme::class, 'care_plan_scheme_id');
    }

    /**
     * Get the answer associated with the CarePlanQuestion
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function answer()
    {
        return $this->hasOne(CarePlanAnswer::class);
    }
}
