<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatePromocionRequest;
use App\Partner;
use App\Promocione;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class PromocionesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {

        if ($request) {
            $query = trim($request->get('search'));

            $promociones = DB::table("promociones")
                ->leftJoin("servicios", "promociones.id_servicio", "=", "servicios.id")
                ->leftJoin("categorias", "categorias.id", "=", "servicios.id_categoria")
                ->leftJoin("empresas", "empresas.id", "=", "servicios.id_empresa")
                ->select("promociones.*", "categorias.name As categoria_name", "servicios.id As servicio_id", "servicios.name As servicio_name", "servicios.descripcion As servicio_descripcion",
                    "servicios.condiciones As servicio_condiciones", "servicios.precio As servicio_precio",
                  "servicios.servicio_img_id", "empresas.name As empresa_name")
                 ->where('promociones.name','LIKE','%'.$query.'%') ->where('promociones.id_producto','=','0') ->orwhere('promociones.id_producto','=',null)->get();

             if($promociones != '[]'){
                $promociones->first()->precio_menos_descuento = '';

            }

            $servicios = DB::table("servicios")
                ->leftJoin("empresas", "servicios.id_empresa", "=", "empresas.id")
                ->select("servicios.id","servicios.name", "servicios.precio",
                     "empresas.name As name_empresa")->orderby('empresas.name','asc')->get();

            foreach ($promociones as $promocione){

                $promocione->precio_menos_descuento = $promocione->servicio_precio - ($promocione->porcentaje_descuento /100) * $promocione->servicio_precio ;


            }

                return view('Promociones.promociones_index')->with("servicios", $servicios)->with("promociones", $promociones);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreatePromocionRequest $request)
    {
        $promocion = new Promocione();




        $promocion->name = ucwords(strtolower($request->name));
        $promocion->descripcion = $request->descripcion;
        $promocion->id_servicio = $request->id_servicio;
        $promocion->porcentaje_descuento = $request->porcentaje_descuento;
        $promocion->fecha_inicio = $request->fecha_inicio;
        $promocion->fecha_fin = $request->fecha_fin;


        $promocion->save();


        return redirect()->route("promociones.index")
            ->withExito("Se creó un nuevo promocion con nombre '"
                .$request->input("name")."' con ID= ".$promocion->id."");
    }



    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }
    public function editarPromocion(Request $request)

    {


        try {
            $this->validate($request, [
                'name'=>'required|string|max:100',
                'descripcion'=>'max:192',
                'id_servicio'=>'required|integer',
                'fecha_inicio'=>'required|date',
                'fecha_fin'=>'required|date',

            ], $messages = [
                'name.required' => 'El nombre de la promoción es requerido.',
                'descripcion.max:192' => 'La descripción  no debe de llevar mas de 192 caracteres.',
                'id_servicio.required' => 'Se requiere un servicio para esta promoción.',
                'fecha_inicio.required' => 'Se requiere una fecha de inicio para esta promoción.',
                'fecha_fin.required' => 'Se requiere una fecha fin para esta promoción.',

            ]);



            $promocionRegsitro = Promocione::findOrFail($request->id);



            $promocionRegsitro->name = $request->get('name');
            $promocionRegsitro->descripcion = $request->get('descripcion');
            $promocionRegsitro->porcentaje_descuento = $request->get('porcentaje_descuento');
            $promocionRegsitro->id_servicio = $request->get('id_servicio');
            $promocionRegsitro->fecha_inicio = $request->get('fecha_inicio');
            $promocionRegsitro->fecha_fin = $request->get('fecha_fin');




            $promocionRegsitro->update();

            return redirect()->route("promociones.index")
                ->withExito("Se actualizó la promocion: " . $request->name);
        } catch (ValidationException $exception) {


            return redirect()->route("promocion.index")->with('idPromocion', $request->id)->with('errores', 'errores')->withErrors($exception->errors())
                ->withExito("hubo un error'");


        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroyPromocion(Request $request)
    {


        $promocion = Promocione::findOrFail($request->id);



        $promocion->delete();


        return redirect()->route("promociones.index")
            ->withExito("Se eliminó la promoción: ".$request->name);

    }
}
