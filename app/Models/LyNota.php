<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LyNota extends Model
{
    use HasFactory;

    protected $table = 'LY_NOTA';

    protected $fillable = [
        // It is not necessary to have fillabe fields. Only query application
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
