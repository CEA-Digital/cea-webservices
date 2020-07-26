<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
//-----------------------------------------PRODUCTOS ROUTES---------------------------------------------------------
Route::get("/empresas","EmpresaController@index")->name("empresas");//Permite mostrar las empresas asociadas
//--------------------------------------------CATEGORIAS ROUTES------------------------------------------------------
Route::get("/categorias","CategoriasController@index")->name("categorias");//Muestra las categorias de productos y/o empresas
Route::get("/categorias/tipos","CategoriasController@verTipoCategorias")->name("verTipoCategorias");
Route::post("/categoria/nueva","CategoriasController@storeCategoria")->name("nuevaCategoria");
Route::post("/tipo_categoria/nueva","CategoriasController@nuevoTipoCategoria")->name("nuevoTipoCategoria");// Crea una nueva categoria
//--------------------------------------------Servivios ROUTES------------------------------------------------------
Route::resource("/servicios", "ServiciosController");
