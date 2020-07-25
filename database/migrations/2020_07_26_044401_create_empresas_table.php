<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmpresasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('empresas', function (Blueprint $table) {
            $table->id();
            $table->string("name",100);
            $table->string("direccion");
            $table->foreignId("id_categoria")->references("id")->on("categorias");
            $table->foreignId("id_contacto")->references("id")->on("contactos");
            $table->foreignId("id_profile_img")->references("id")->on("resources_media");
            $table->foreignId("id_portada_img")->references("id")->on("resources_media");
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
        Schema::dropIfExists('empresas');
    }
}
