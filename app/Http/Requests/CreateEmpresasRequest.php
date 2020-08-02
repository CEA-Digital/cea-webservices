<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateEmpresasRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "name" => "required|string|max:100",
            "direccion" => "required|max:192",
            "id_categoria"=>"required|integer",
            "telefono"=>"required|unique:contactos,telefono|max:99999999|integer",
            "correo"=>"required|unique:contactos,correo",
            "telefono_opcional"=>"nullable|unique:contactos,telefono_opcional|max:99999999"
        ];
    }
    public function messages()
    {
        return [
            "name.required"=>"El nombre de empresa es requerido",
            "direccion.required"=>"La dirección es requerida",
            "id_categoria.numeric"=>"Se requiere una categoria para la empresa",
            "telefono.required"=>"Se requiere que ingrese el número principal para la empresa.",
            "correo.required"=>"Se requiere que ingrese el correo empresarial para la empresa.",
            "telefono.max"=>"El télefono debe ser menor a 9 cáracteres.",
            "telefono.unique"=>"El télefono ingresado ya está registrado.",
            "telefono_opcional.unique"=>"El télefono opcional ya está registrado.",
            "telefono_opcional.max"=>"El télefono debe ser menor a 9 carácteres.",
            "correo.unique"=>"El correo ingresado ya está registrado."
        ];
    }
}
