<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;
    protected $guarded = [
        'id'
    ];

    protected $casts = [
        'languages' => 'array',
        'engagement_types' => 'array'
    ];

    public function getFormattedRpmRecordFromAttribute()
    {
        if($this->attributes['rpm_record_from']){
            return Carbon::createFromFormat('Y-m-d', $this->attributes['rpm_record_from'])->format('m-d-Y');
        }
    }
    public function setRpmRecordFromAttribute($value)
    {
        if($value){
            $this->attributes['rpm_record_from'] = set_format($value);
        }
    }
    
    public static function search($key)
    {
        return Setting::pluck($key)->first();
    }

}
