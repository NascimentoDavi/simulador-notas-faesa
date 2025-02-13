<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;


use Illuminate\Database\Eloquent\Model;

class LyAluno extends Model
{
    use HasFactory;

    protected $table = 'LY_ALUNOS';

    protected $fillable = [
        // It is not necessary to have fillabe fields. Only query application
    ];

    public function disciplinas ()
    {
        return $this->belongsToMany(LyDisciplina::class, 'ly_matriculas')->withTimestamps();
    }

    public function notas ()
    {
        return $this->hasMany(LyNota::class);
    }
}
