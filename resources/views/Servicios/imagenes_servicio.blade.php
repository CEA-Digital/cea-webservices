@extends('layouts.main')

@section('content')


    <div class="container-fluid">
        <h1 class="mt-4">Galeria de imágenes
            <div class="btn-group" role="group">
                <a class="btn btn-sm btn-success"
                   id="botonAbrirModalNuevaCategoria"
                   href="{{route("agregarImg",$servicio[0]['id'])}}">
                    <span class="fas fa-plus"></span> Nueva
                </a>
            </div>
        </h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb" style="background: transparent">
                <li class="breadcrumb-item" aria-current="page"><a href="/">Inicio</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{$servicio[0]['name_empresa']}} servicio de {{$servicio[0]['name']}}</li>
            </ol>
        </nav>
        @if(session("exito"))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <span class="fas fa-check"></span> {{session("exito")}}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

         <div class="container col-md-12 ">


                <div class="row d-flex align-items-stretch" >


                    @foreach($imagenes as $imagen)
                         <div class="col-lg-3 col-md-4 col-sm-12 col-xs-12 mb-2">
                            <div class="card" style="width: 100%;   box-shadow: 0 10px 20px rgba(0,0,0,0.19), 0 6px 6px rgba(0,0,0,0.23);">
                                         <div class="text-center">


                                            <button id="callModalVistaPreviaGaleria{{$imagen->id}}"
                                                    data-src_img="{{$imagen->ruta}}"
                                                    @if($imagen->ruta)
                                                    data-toggle="modal"
                                                    data-target="#modalVistaPreviaServicio"
                                                    @endif
                                                    style="opacity: 0"></button>

                                            <img class="card-img-top" src="/storage/images/servicio/{{$imagen->ruta}}"
                                                  onclick="$('#callModalVistaPreviaGaleria{{$imagen->id}}').click()"
                                                  width="150px" height="150px"    style="height:150px; max-height: 300px;object-fit: contain"
                                                  onerror="this.src='/images/noimage.jpg'"   alt="profile-sample1">
                                        </div>

                                        <ul class="list-group list-group-unbordered mb-2 " style=" text-align: center">
                                            <li class="list-group-item "  >
                                                 <button class="btn btn-sm btn-success"
                                                        data-toggle="modal"
                                                        id="botonAbrirModalEditarImagen{{$imagen->id}}"
                                                        data-target="#modalEditarImagen"
                                                        data-ruta="{{$imagen->ruta}}"
                                                        data-id="{{$imagen->id}}"
                                                         title="Editar">
                                                    <span class="fas fa-pencil-alt"></span>
                                                </button>
                                                <button class="btn btn-sm btn-danger"
                                                        title="Borrar"
                                                        data-toggle="modal"
                                                        data-id="{{$imagen->id}}"
                                                          data-target="#modalBorrarImagen">

                                                    <span class="fas fa-trash"></span>
                                                </button>
                                        </ul>



                                    <!-- /.card-body -->
                                </div>
                         </div>


                    @endforeach
                </div>

        </div>

        <div class="modal fade" id="modalVistaPreviaServicio" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header" style="background: #2a2a35">
                        <h5 class="modal-title" style="color: white"><span class="fas fa-pencil-alt"></span> Vista Previa galeria
                        </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span style="color: white" aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body" style="object-fit: fill">
                        <img id="img"
                             style="display:block; width: 46%; margin-left: auto; margin-right: auto;"
                             onerror="this.src='/images/noimage.jpg'"
                        >
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>





        <div class="modal fade" id="modalEditarImagen" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header" style="background: #2a2a35">
                        <h5 class="modal-title" style="color: white"><span class="fas fa-pencil-alt"></span> Editar
                            servicio</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span style="color: white" aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form method="post" action="{{route("editarImagen")}}" enctype="multipart/form-data">
                        @method("PUT")
                        @csrf
                        @include('Alerts.errors')

                        <div class="modal-body">




                            <img id="imgVistaPreviaEditarservicio"
                                 height="150px" width="150px"
                                 style="object-fit: contain"
                                 onerror="this.src='/images/noimage.jpg'">
                            <label for="imagenCategoria">Seleccione una imagen (opcional): </label>
                            <div class="input-group image-preview">
                                <input type="text" name="ruta" class="form-control image-preview-filename"
                                       disabled="disabled">
                                <!-- don't give a name === doesn't send on POST/GET -->
                                <span class="input-group-btn">
                                <!-- image-preview-clear button -->
                                <button type="button" class="btn btn-outline-danger image-preview-clear"
                                        style="display:none;">
                                    <span class="fas fa-times"></span> Limpiar
                                </button>
                                    <!-- image-preview-input -->
                                <div class="btn btn-default image-preview-input">
                                    <span class="fas fa-folder-open"></span>
                                    <span class="image-preview-input-title">Seleccionar</span>
                                    <input type="file" accept="image/png, image/jpeg, image/gif"
                                           name="ruta"/>
                                    <!-- rename it -->
                                </div>
                            </span>
                            </div><!-- /input-group image-preview [TO HERE]-->

                        </div>
                        <div class="modal-footer">
                            <input id="idServicio" name="idServicio" type="hidden" value="{{$servicio[0]['id']}}" >
                            <input id="id" name="id" type="hidden" >

                            <button type="submit" class="btn btn-success">Editar</button>
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>


        <div class="modal fade" id="modalBorrarImagen" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-dialog-scrollable" role="document">
                <div class="modal-content">
                    <form method="post" action="{{route("destroyImagen")}}" enctype="multipart/form-data">
                        @method("DELETE")
                        @csrf
                        <div class="modal-header" style="background: #2a2a35">
                            <h5 class="modal-title" style="color: white"><span class="fas fa-trash"></span> Borrar imagen
                            </h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span style="color: white" aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <p>¿Estás seguro que deseas borrar esta imagen?</p>

                        </div>
                        <div class="modal-footer">
                            <input id="id" name="id" type="hidden">

                            <input id="idservicio" name="idServicio" type="hidden" value="{{$servicio[0]['id']}}">

                            <button type="submit" class="btn btn-danger">Borrar</button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>


        <style>
            .image-preview-input {
                position: relative;
                overflow: hidden;
                margin: 0px;
                color: #333;
                background-color: #fff;
                border-color: #ccc;
            }

            .image-preview-input input[type=file] {
                position: absolute;
                top: 0;
                right: 0;
                margin: 0;
                padding: 0;
                font-size: 20px;
                cursor: pointer;
                opacity: 0;
                filter: alpha(opacity=0);
            }

            .image-preview-input-title {
                margin-left: 2px;
            }
        </style>

@endsection
