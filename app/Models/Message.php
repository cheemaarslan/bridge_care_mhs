<?php

namespace App\Models;

use App\Notifications\PatientMessage;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Notification;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Message extends Model
{
    use HasFactory;
    protected $guarded = [
        'id'
    ];
    protected $appends = ['formatted_date'];
    public static function boot() {
        parent::boot();

        static::created(function($data) {
            if($data->type == "Incoming"){
                $users = User::whereHas('roles', function($query){
                    $query->where('name', 'super-admin');
                    $query->orWhere('name', 'admin');
                })->get();
                Notification::send($users, new PatientMessage($data));

            }
        });
    }

    public function getFormattedDateAttribute()
    {
        return Carbon::parse($this->attributes['created_at'])->diffForHumans();
    }

    /**
     * Get the conversation te Message
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function patient()
    {
        return $this->belongsTo(Patient::class, 'patient_id');
    }
}
