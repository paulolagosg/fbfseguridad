<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cursos extends Model
{
    use HasFactory;

     public $timestamps = false;

    protected $fillable = [
        'curs_ncod','curs_tnombre','curs_nestado'
    ];
}
