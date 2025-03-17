<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LyDisciplina extends Model
{
    use HasFactory;
    
    protected $table = 'LY_TURMA';

    protected $fillable = [
        // It is not necessary to have fillabe fields. Only query application
    ];

    public function alunos ()
    {
        return $this->belongsToMany(LyAluno::class, 'ly_matriculas')->withTimestamps();
    }
}
