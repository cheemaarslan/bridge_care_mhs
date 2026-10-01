<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PatientChronicCondition extends Model
{
    use HasFactory;
    protected $guarded = [
        'id'
    ];

    public function chronic_condition()
    {
        return $this->belongsTo(ChronicCondition::class, 'chronic_condition_id');
    }
}
