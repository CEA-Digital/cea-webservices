<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Categorias extends Model
{
    protected $fillable=["name","descripcion","id_categoria","img_url"];
    protected $appends=["tipo_categoria"];

    public function getTipoCategoriaAttribute(){
        return TipoCategoria::where("id",$this->id_categoria)->value("name");
    }
}
