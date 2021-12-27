<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Aula extends Model
{
    protected $table = 'aulas';
    protected $fillable = [
        'nome',
        'qtde_maxima',
        'nome_prof',
        'duracao',
        'data_hora',
        'qtde_aluno',
    ];

    
}
