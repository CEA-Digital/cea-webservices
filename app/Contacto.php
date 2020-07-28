<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contacto extends Model
{
    protected $fillable=["telefono","telefono_opcional","correo","sitio_web","facebook","instagram"];
}
