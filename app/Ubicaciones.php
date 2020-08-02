<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ubicaciones extends Model
{
    protected $fillable=["id_empresa","descripcion","latitud","longitud"];
}
