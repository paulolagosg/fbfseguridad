<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EstadosOrdenes extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'esor_tnombre','esor_nestado','esor_npermite_factura','esor_npermite_editar','orde_tcomentario'
    ];
}
