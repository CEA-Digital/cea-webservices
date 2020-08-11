<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class Partner extends Model
{
    protected $fillable=["name","descripcion","ruta_img"];



    public static function setCaratula($foto, $actual = false)
    {
        if ($foto){
            if($actual){
                Storage::disk('public')->delete("images/partners/$actual");
            }
            $imageName = Str::random(20).'.jpg';
            $imagen = Image::make($foto)->encode('jpg',75);

            Storage::disk('public')->put("images/partners/$imageName",$imagen->stream());
            return $imageName;


        }else{
            return false;
        }




    }

    public static function deleteCaratula($foto)
    {
        if ($foto){
            Storage::disk('public')->delete("images/partners/$foto");

        }else{
            return false;
        }




    }

}
