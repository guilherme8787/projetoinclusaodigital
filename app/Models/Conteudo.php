<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Conteudo extends Model
{
    use HasFactory;

    protected $table = 'conteudos';

    protected $fillable = [
        'id',
        'titulo',
        'ciclo',
        'funcionamento',
        'formato',
        'tipo',
        'categoria',
        'disciplina',
        'hashtag',
        'descricao',
        'link',
        'validado_no_tablet',
        'baixado_launcher',
        'created_at',
        'updated_at'
    ];

}
