<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EstadosCiviles extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'eciv_tnombre','eciv_nestado'
    ];
}
