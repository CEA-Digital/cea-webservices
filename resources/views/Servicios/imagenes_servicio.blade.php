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

         <div class="container col-md-12 ">


                <div class="row d-flex align-items-stretch" >


                    @foreach($imagenes as $imagen)

                        <div class="col-lg-3 col-md-4 col-sm-12 col-xs-12 mb-2">
                            <div class="card" style="width: 100%;   box-shadow: 0 10px 20px rgba(0,0,0,0.19), 0 6px 6px rgba(0,0,0,0.23);">
                                         <div class="text-center">

                                            <h5>{{$imagen->ruta}}</h5>

                                            <button id="callModalVistaPreviaGaleria{{$imagen->id}}"
                                                    data-src_img="{{$imagen->ruta}}"
                                                    @if($imagen->ruta)
                                                    data-toggle="modal"
                                                    data-target="#modalVistaPreviaServicio"
                                                    @endif
                                                    style="opacity: 0"></button>

                                            <img class="card-img-top" src="/storage/images/servicio/{{$imagen->ruta}}"
                                                  onclick="$('#callModalVistaPreviaGaleria{{$imagen->id}}').click()"

                                                  width="180px" height="180px"    style="height:150px; max-height: 300px;object-fit: contain"
                                                  onerror="this.src='/images/noimage.jpg'"  alt="Card image cap">
                                        </div>

                                        <ul class="list-group list-group-unbordered mb-2">
                                            <li class="list-group-item ">

                                        <a href="{{route('editarImagen',$imagen->id)}}">  <button type="button" class="btn btn-primary float-left">Editar</button></a>
                                        <form action="{{route('destroyImagen',$imagen->id)}}" method="POST" onclick="
                                            return confirm('¿Seguro que quiere eliminar a ?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger float-right ">Eliminar</button>

                                        </form>
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
        <script src="{{asset("js/servicio.js")}}"></script>


@endsection
