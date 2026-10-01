<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CarePlanTest extends Model
{
    use HasFactory;
    protected $guarded = [
        'id'
    ];



    public function test()
    {
        return $this->belongsTo(Test::class, 'test_id');
    }
}
