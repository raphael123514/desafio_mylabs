<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Checkin extends Model
{
    protected $table = 'checkins';
    
    protected $fillable = [
        'id',
        'user_id',
        'aulas_id',
    ];
}
