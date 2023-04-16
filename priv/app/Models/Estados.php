<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Estados extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'esta_tnombre','esta_nestado'
    ];
}
