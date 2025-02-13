<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LyPessoa extends Model
{
    use HasFactory;

    protected $table = 'LY_PESSOAS';

    protected $fillable = [
        // Will not be needed. Only query operations.
    ];
}
