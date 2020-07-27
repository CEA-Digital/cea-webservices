<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    protected $fillable=["name","description","unit_price","lote_price","disponible","id_product_img","id_categoria","id_empresa"];
    //
}
