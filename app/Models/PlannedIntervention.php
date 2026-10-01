<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlannedIntervention extends Model
{
    use HasFactory;
    protected $guarded = [
        'id'
    ];
    protected $casts = [
        'person_responsible' => 'array'
    ];


    public function chronic_condition()
    {
        return $this->belongsTo(ChronicCondition::class, 'chronic_condition_id');
    }
}
