<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Empresa extends Model
{
    protected $fillable=["name","direccion","id_categoria","id_contacto","profile_img_url","portada_img_url"];
    protected $appends=["nombre_categoria","ubicaciones","contacto"];

    public function getNombreCategoriaAttribute(){
        $categoria= Categorias::findOrFail($this->id_categoria);
        return $categoria->name;
    }
    public function getUbicacionesAttribute(){
        $ubicaciones = Ubicaciones::where("id_empresa","=",$this->id)->get();
        return $ubicaciones;
    }
    public function getContactoAttribute(){
        $contacto = Contacto::findOrFail($this->id_contacto);
        return $contacto;
    }
}
