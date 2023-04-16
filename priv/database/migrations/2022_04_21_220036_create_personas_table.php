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
        Schema::create('personas', function (Blueprint $table) {
            $table->increments('pers_ncod');
            $table->integer('pers_nrut');
            $table->string('pers_tdv',1);
            $table->string('pers_tnombres');
            $table->string('pers_tpaterno');
            $table->string('pers_tmaterno');
            $table->date('pers_fnacimiento');
            $table->string('pers_tcorreo');
            $table->string('pers_nfono_movil');
            $table->string('pers_nfono_fijo');
            $table->integer('pers_bguardia');
            $table->integer('pers_nestado');
            $table->integer('eciv_ncod');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('guardias');
    }
};
