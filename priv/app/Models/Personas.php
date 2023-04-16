<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Personas extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'pers_nrut','pers_tdv','pers_tnombres','pers_tpaterno','pers_tmaterno','pers_fnacimiento','pers_tcorreo','pers_nfono_movil','pers_nfono_fijo','pers_bguardia','pers_nestado','eciv_ncod'
    ];
}
