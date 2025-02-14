<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LyMatricula extends Model
{
    use HasFactory;

    protected $table = 'LY_MATRICULA';

    protected $fillable = [
        // It is not necessary to have fillabe fields. Only query application
    ];
}
