<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Clientes extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'clie_ncod','clie_nrut','clie_tdv','clie_trazon_social','clie_tdireccion','clie_tejecutivo','clie_nfono_fijo','clie_nfono_movil','clie_tcorreo','clie_nestado'
    ];
}
