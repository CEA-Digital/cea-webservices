<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProductosController extends Controller
{
    //
    public function index(){
        return view("Productos.productos");
    }
}
