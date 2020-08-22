<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePromocionesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('promociones', function (Blueprint $table) {
            $table->id();
            $table->foreignId("id_producto")->references("id")->on("productos");
            $table->foreignId("id_servicio")->references("id")->on("servicios");
            $table->string("name",100);
            $table->string("descripcion",192)->nullable();
            $table->integer("porcentaje_descuento");

            $table->date("fecha_inicio");
            $table->date("fecha_fin");



            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('promociones');
    }
}
