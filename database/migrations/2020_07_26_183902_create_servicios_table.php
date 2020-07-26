<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServiciosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('servicios', function (Blueprint $table) {
            $table->id();
            $table->foreignId("id_categoria")->references("id")->on("categorias");
            $table->foreignId("id_empresa")->references("id")->on("empresas");
            $table->string("name",100);
            $table->string("descripcion",192)->nullable();
            $table->string("condiciones")->nullable();
            $table->double("precio");
            $table->string("servicio_img_id")->nullable();
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
        Schema::dropIfExists('servicios');
    }
}
