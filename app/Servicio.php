<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;


class Servicio extends Model
{
    protected $fillable=["name","descripcion","condiciones","precio","id_empresa","id_categoria","servicio_img_id"];
   // protected $appends=["empresas","categorias","resource_media"];


    public static function setCaratula($foto, $actual = false)
    {
        if ($foto){
            if($actual){
                Storage::disk('public')->delete("images/servivio/$actual");
            }
            $imageName = Str::random(20).'.jpg';
            $imagen = Image::make($foto)->encode('jpg',75);

            Storage::disk('public')->put("images/servicio/$imageName",$imagen->stream());
            return $imageName;


        }else{
            return false;
        }



    }

}
