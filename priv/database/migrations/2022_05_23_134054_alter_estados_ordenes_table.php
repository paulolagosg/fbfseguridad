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
        if (Schema::hasTable('estados_ordenes')) {
            Schema::table('estados_ordenes', function (Blueprint $table) {
                $table->integer('esor_npermite_factura');
                $table->integer('esor_npermite_editar');
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasTable('estados_ordenes')) {
            Schema::table('estados_ordenes', function (Blueprint $table) {
                $table->dropColumn('esor_npermite_factura');
                $table->dropColumn('esor_npermite_editar');
            });
        }
    }
};
