<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateResourcesMediaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('resources_media', function (Blueprint $table) {
            $table->id();
            $table->string("ruta");
            $table->tinyInteger("id_prod");
            $table->tinyInteger("id_serv");
            $table->tinyInteger("id_empresa");
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
        Schema::dropIfExists('resources_media');
    }
}
