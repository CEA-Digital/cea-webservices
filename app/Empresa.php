<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Empresa extends Model
{
    protected $fillable=["name","direccion","id_categoria","id_contacto","id_profile_img","id_portada_img"];
}
