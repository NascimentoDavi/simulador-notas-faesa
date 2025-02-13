<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LySimuladorNotaFormula extends Model
{
    use HasFactory;

    protected $table = 'LY_SIMULADOR_NOTA_FORMULAS';

    protected $fillable = [
        'name',
        'created_by',
        'formula',
        'cursos' // Courses where the formula can be applied.
    ];

    // It allows me to automatically cast certain attributes to a specified type when they are accessed.
    protected $casts = [
        'created_by' => 'string',
    ];
}
