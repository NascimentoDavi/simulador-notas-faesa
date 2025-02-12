<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LyAluno extends Model
{
    use HasFactory;

    protected $table = 'ly_alunos';

    protected $fillable = [
        'name',
        'email',
        'birth_date',
        'telefone',
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
