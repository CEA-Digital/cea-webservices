<?php

namespace App\Http\Controllers;

use App\Http\Requests\PartnersRequest;
use App\Partner;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class PartnerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request) {
            $query = trim($request->get('search'));




            $partners = Partner::Orderby('name', 'ASC')->get();
             return view('Partners.partners_index')->with("partners", $partners)->withNoPagina(1);
        }
    }
    public function editarPartners(Request $request)
    {

        try {
            $this->validate($request, [
                'name'=>'required|string|max:100',
                'descripcion'=>'max:192',

            ],$messages = [
                'name.required' => 'El nombre del servicio es requerido.',
                 'descripcion.max:192' => 'La descripción  no debe de llevar mas de 192 caracteres.',

            ]);




            $partnersRegsitro =  Partner::findOrFail($request->id);




            if($foto = Partner::setCaratula($request->ruta_img, $partnersRegsitro->ruta_img)){
                $request->request->add(['imagen_partners'=>$foto]);
                $partnersRegsitro->ruta_img = $request->imagen_partners;

            }

            $partnersRegsitro->name = $request->get('name');
            $partnersRegsitro->descripcion= $request->get('descripcion');
            $partnersRegsitro->update();

            return redirect()->route("partners.index")
                ->withExito("Se actualizó el paterns '".$request->name);
        }
        catch (ValidationException $exception) {


            return redirect()->route("partners.index")->with( 'img',$request->ruta_img)->with( 'idPartners',$request->id)->with( 'errores' ,'errores')->withErrors($exception->errors())
                ->withExito("hubo un error'");



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
    public function store(PartnersRequest $request)
    {
        $partners = new Partner();


        $foto ='';
        if($foto = Partner::setCaratula($request->ruta_img)){
            $request->request->add(['imagen_partners'=>$foto]);
            $partners->ruta_img = $request->imagen_partners;

        }

        $partners->name = ucwords(strtolower($request->name));
        $partners->descripcion = $request->descripcion;


        $partners->save();


        return redirect()->route("partners.index")
            ->withExito("Se creó un nuevo partners con nombre '"
                .$request->input("name")."' con ID= ".$partners->id."");
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
