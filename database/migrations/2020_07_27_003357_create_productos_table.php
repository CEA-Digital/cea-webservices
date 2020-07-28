<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('productos', function (Blueprint $table) {
            $table->id();
            $table->string("name",70);
            $table->string("description",100);
            $table->decimal("unit_price",7,2);
            $table->decimal("lote_price",7,2);
            $table->boolean("disponible")->default(false);
            $table->foreignId("id_categoria")->references("id")->on("categorias");
            $table->foreignId("id_empresa")->references("id")->on("empresas");
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
        Schema::dropIfExists('productos');
    }
}
