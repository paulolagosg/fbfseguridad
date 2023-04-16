<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ordenes extends Model
{
    use HasFactory;

    public $timestamps = false;
    
    protected $fillable = [
        'orde_ncod','pers_nrut_cliente','orde_finicio','orde_ftermino','orde_ndias','orde_nvalor_dia','orde_total_sin_iva','orde_total_con_iva','orde_nfactura','orde_oc_cliente','orde_nestado','jorn_ncod','pers_nrut_guardia'
    ];
}
