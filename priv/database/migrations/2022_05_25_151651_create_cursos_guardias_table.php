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
        Schema::create('cursos_guardias', function (Blueprint $table) {
            $table->increments('cupe_ncod');
            $table->integer('curs_ncod');
            $table->integer('pers_nrut');
            $table->date('cupe_fexpira');
            $table->integer('cupe_nestado');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cursos_guardias');
    }
};
