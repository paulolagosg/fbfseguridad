<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clientes', function (Blueprint $table) {
            $table->increments('clie_ncod');
            $table->integer('clie_nrut');
            $table->string('clie_tdv',1);
            $table->string('clie_trazon_social');
            $table->string('clie_tdireccion');
            $table->string('clie_tejecutivo');
            $table->bigInteger('clie_nfono_fijo');
            $table->bigInteger('clie_nfono_movil');
            $table->string('clie_tcorreo');
            $table->integer('clie_nestado');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('clientes');
    }
};
