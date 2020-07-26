<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Servicio extends Model
{
    protected $fillable=["name","descripcion","condiciones","precio","id_empresa","id_categoria","servicio_img_id"];
   // protected $appends=["empresas","categorias","resource_media"];




}
