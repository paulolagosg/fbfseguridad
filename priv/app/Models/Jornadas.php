<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jornadas extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $fillable = [
        'jorn_tnombre',
        'jorn_nestado'
    ];
}
