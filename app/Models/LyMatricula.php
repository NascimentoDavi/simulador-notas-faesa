<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LyMatricula extends Model
{
    use HasFactory;

    protected $table = 'ly_matriculas';

    protected $fillable = [
        'ly_aluno_id',
        'ly_disciplina_id',
    ];
}
