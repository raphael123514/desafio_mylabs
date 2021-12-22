<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Aula extends Model
{
    protected $table = 'aulas';
    protected $fillable = [
        'id',
        'nome',
        'qtdeMaxima',
        'nomeProf',
        'duracao',
        'dataHoraAula',
    ];

    
}
