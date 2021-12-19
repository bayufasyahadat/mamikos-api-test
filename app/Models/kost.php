<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class kost extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'userId',
        'image',
        'name',
        'location',
        'price',
        'description'
    ];

    protected $table = 'kost';
}
