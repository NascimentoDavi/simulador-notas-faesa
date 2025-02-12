<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LyNota extends Model
{
    use HasFactory;

    protected $table = 'ly_notas';

    protected $fillable = [
        'ly_alunos_id',
        'ly_disciplina_id',
        'c1',
        'c2',
        'c3',
    ];

    public function aluno ()
    {
        return $this->belongsTo(LyAluno::class);
    }

    public function disciplina ()
    {
        return $this->belongsTo(LyDisciplina::class);
    }
}
