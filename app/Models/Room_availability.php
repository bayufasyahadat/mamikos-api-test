<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room_availability extends Model
{
    use HasFactory;

    protected $fillable = [
        'userid',
        'kostid',
        'ownerid',
        'status'
    ];

    protected $table = 'room_availability';
}
