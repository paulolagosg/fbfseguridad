<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CursosPersonas extends Model
{
    use HasFactory;

     public $timestamps = false;

    protected $fillable = [
        'curs_ncod','pers_nrut','cupe_fexpira','cupe_nestado'
    ];
}
