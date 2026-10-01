<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Medication extends Model
{
    use HasFactory;
    protected $guarded = [
        'id'
    ];
    /**
     * Get the user that owns the Medication
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function getFormattedDateAttribute()
    {
        return Carbon::parse($this->attributes['created_at'])->diffForHumans();
    }
    public function patient()
    {
        return $this->belongsTo(Patient::class, 'patient_id');
    }
}
