<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatePromocionRequest;
use App\Promocione;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
    public function destroy($id)
    {
        //
    }
}
