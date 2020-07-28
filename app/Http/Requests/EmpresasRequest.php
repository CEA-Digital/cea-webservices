<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EmpresasRequest extends FormRequest
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
            "id_contacto"=>"required|integer",
        ];
    }
    public function messages()
    {
        return [
            "name.required"=>"El nombre de empresa es requerido",
            "direccion.required"=>"La dirección es requerida",
            "id_categoria.numeric"=>"Se requiere una categoria para la empresa",
            "id_contacto"=>"Se requiere ingresar el contacto de la empresa"
        ];
    }
}
