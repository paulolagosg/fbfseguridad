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
        Schema::create('ordenes', function (Blueprint $table) {
            $table->increments('orde_ncod');
            $table->integer('pers_nrut_cliente');
            $table->date('orde_finicio');
            $table->date('orde_ftermino');
            $table->integer('orde_ndias');
            $table->decimal('orde_nvalor_dia',12,4);
            $table->decimal('orde_total_sin_iva',20,4);
            $table->decimal('orde_total_con_iva',20,4);
            $table->integer('orde_nfactura');
            $table->string('orde_oc_cliente');
            $table->integer('orde_nestado');
            $table->integer('jorn_ncod')->default(null);
            $table->integer('pers_nrut_guardia');
            //$table->foreign('estado')->references('id')->on('estados');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ordenes');
    }
};
