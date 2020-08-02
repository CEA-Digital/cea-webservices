<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Producto extends Model
{
    protected $fillable=["name","description","unit_price","lote_price","disponible","id_categoria","id_empresa"];
    //


}
