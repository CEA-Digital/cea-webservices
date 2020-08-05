<?php

namespace App\Http\Controllers;

use App\Categorias;
use App\Contacto;
use App\Empresa;
use App\Http\Requests\CreateEmpresasRequest;
use App\TipoCategoria;
use App\Ubicaciones;
use Illuminate\Http\Request;

class EmpresaController extends Controller
{

    public function index(){
        $empresas = Empresa::paginate(10);
        return view("Empresas.empresas_dashboard")->withEmpresas($empresas);

    }
    public function show($id){
        $empresa = Empresa::findOrFail($id);
        $categorias = TipoCategoria::all();
        $contacto= Contacto::where("id","=",$empresa->id_contacto)->get();

        return view("Empresas.informacion_empresa")
            ->withEmpresa($empresa)
            ->withTipoCategorias($categorias)
            ->withContacto($contacto);
    }
    public function nuevaEmpresaForm($fase=1){
        $categorias = TipoCategoria::all();
        return view("Empresas.nueva_empresa")
            ->withFase($fase)
            ->withTipoCategorias($categorias);
    }
    public function store(CreateEmpresasRequest $request){
        $pathPortadas = public_path() . '/images/empresas/portadas/';//Carpeta publica de las imagenes
        $pathProfile = public_path() . '/images/empresas/profiles/';//Carpeta publica de las imagenes


        $validados = $request->validated();
        if ($validados) {
            /**Primero se inserta el contacto para asi asignarselo a la empresa*/
            $nuevoContacto = new Contacto();
            $nuevoContacto->telefono = $request->input("telefono");
            $nuevoContacto->telefono_opcional = $request->input("telefono_opcional");
            $nuevoContacto->correo = $request->input("correo");
            $nuevoContacto->sitio_web = $request->input("sitio_web");
            $nuevoContacto->facebook = $request->input("facebook");
            $nuevoContacto->instagram = $request->input("instagram");
            $nuevoContacto->save();
        }
        /** Creando una nueva empresa**/
        $nuevaEmpresa= new Empresa();
        $nuevaEmpresa->id_contacto=$nuevoContacto->id;
        $nuevaEmpresa->name= $request->input("name");
        $nuevaEmpresa->direccion=$request->input("direccion");
        $nuevaEmpresa->id_categoria=$request->input("id_categoria");

        /** Validando y creando la imagen de portada y perfil si estas son enviadas por el usuaio*/
        if (!file_exists($pathPortadas)) {
            mkdir($pathPortadas, 0777, true);
        }
        if($request->portada_img_url){
            $imagenPortada= $_FILES["portada_img_url"]["name"];
            $ruta = $_FILES["portada_img_url"]["tmp_name"];
            //-------------VALIDAR SI LA CARPETA EXISTE---------------------

            //-------------------------------------------------------------
            $destino = "images/empresas/portadas/" . $imagenPortada;
            copy($ruta, $destino);
            $nuevaEmpresa->portada_img_url=$imagenPortada;
        }
        if (!file_exists($pathProfile)) {
            mkdir($pathProfile, 0777, true);
        }
        if($request->profile_img_url){
            $imagenProfile= $_FILES["profile_img_url"]["name"];
            $ruta = $_FILES["profile_img_url"]["tmp_name"];
            //-------------VALIDAR SI LA CARPETA EXISTE---------------------

            //-------------------------------------------------------------
            $destino = "images/empresas/profiles/" . $imagenProfile;
            copy($ruta, $destino);
            $nuevaEmpresa->profile_img_url=$imagenProfile;
        }

        $nuevaEmpresa->save();
        return redirect()->route("nuevaUbicacionEmpresa",["id"=>$nuevaEmpresa->id])
            ->withExito("Se creó exitosamente la empresa con nombre ='{$request->input('name')}'
            con ID = {$nuevaEmpresa->id}");

    }

    public function editarEmpresa(Request $request){

    }
    public function nuevaUbicacionEmpresa($id){
        $ubicaciones=Ubicaciones::where("id_empresa","=",$id)->get();
        $empresa = Empresa::findOrFail($id);
        return view("Empresas.nueva_ubicacion_empresa")
            ->withUbicaciones($ubicaciones)
            ->withEmpresa($empresa)
            ->withIdEmpresa($id);
    }
}
