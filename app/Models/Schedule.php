<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'priority',
        'meeting_date',
        'meeting_time',
        'description',
        'minutes',
        'user_id',
        'is_checked'
    ];

     public function user()
    {
        return $this->belongsTo(User::class);
    }
}

