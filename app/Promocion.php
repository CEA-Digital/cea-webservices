<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Promocion extends Model
{
    protected $fillable=["name","descripcion","id_producto","id_servicio"];

}
