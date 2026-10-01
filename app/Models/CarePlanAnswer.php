<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class CarePlanAnswer extends Model
{
    use HasFactory, SoftDeletes;
    protected $guarded = [
        'id'
    ];


    /**
     * Get the user that owns the CarePlanAnswer
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function question()
    {
        return $this->belongsTo(CarePlanQuestion::class, 'care_plan_question_id');
    }


}
