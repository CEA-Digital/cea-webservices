@extends("layouts.main")
@section("content")
    <div class="container-fluid">
        <h1 class="mt-4">Servicios
            <div class="btn-group" role="group">
                <button class="btn btn-sm btn-success"
                        id="botonAbrirModalNuevoServicio"
                        data-toggle="modal" data-target="#modalNuevoServicio">
                    <span class="fas fa-plus"></span> Nuevo
                </button>

            </div>
        </h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb" style="background: transparent">
                <li class="breadcrumb-item" aria-current="page"><a href="/">Inicio</a></li>
                <li class="breadcrumb-item active" aria-current="page">Servicios</li>
            </ol>
        </nav>
        @if(session("exito"))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{session("exito")}}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif
        @if ($errors->any())
            <script>
                document.onreadystatechange = function () {
                    if (document.readyState) {
                        document.getElementById("botonAbrirModalNuevoServicio").click();
                    }
                }
            </script>
        @endif
        <div class="pagination pagination-sm ">

            <form  class="d-none d-md-inline-block form-inline
                           ml-auto mr-0 mr-md-2 my-0 my-md-0 mb-md-2">
                <div class="input-group" style="width: 300px">
                    <input class="form-control" name="search" type="search" placeholder="Search"
                           aria-label="Search">
                    <div class="input-group-append">
                        <a id="borrarBusqueda" class="btn btn-danger hideClearSearch" style="color: white"
                           href="{{route("servicios.index")}}">&times;</a>
                        <button class="btn btn-primary" type="submit"><i class="fas fa-search"></i></button>
                    </div>

                </div>
            </form>


        </div>
        <div class="container" >
            <div class="row"  >
                <div class="col-md-4 main-section" >

                    {!! csrf_field() !!}
                    <div class="file-loading">
                        <input id="file-1" type="file" name="file"    data-overwrite-initial="true" data-min-file-count="1">

                    </div>

                </div>
            </div>
        </div>
        <table class="table">
            <thead class="thead-dark">
            <tr>
                <th>#</th>
                <th>Imagen</th>
                <th>Nombre</th>
                 <th>Descripción</th>
                <th>Condiciones</th>
                <th>Pecio</th>
                <th>Empresa</th>
                <th>Categoria</th>

                <th><span class="fas fa-info-circle"></span></th>
            </tr>
            </thead>
            <tbody>
            @if(!$servicios)
                <tr>
                    <td colspan="4" style="align-items: center">No hay servicios</td>
                </tr>
            @endif
            @foreach($servicios as $servicio)
                <tr>
                    <td>{{$noPagina++}}</td>
                    <td>
                        <button id="callModalVistaPreviaServicio{{$servicio->id}}"
                                data-src_img="{{$servicio->servicio_img_id}}"
                                @if($servicio->servicio_img_id)
                                data-toggle="modal"
                                data-target="#modalVistaPreviaServicio"
                                @endif
                                style="opacity: 0"></button>
                        <img  src="storage/images/servicio/{{$servicio->servicio_img_id}}"
                              onclick="$('#callModalVistaPreviaServicio{{$servicio->id}}').click()"
                              width="150px" height="150px" style="object-fit: contain"
                              onerror="this.src='/images/noimage.jpg'"> </td>

                    <td>{{$servicio->name}}</td>
                     @if(!$servicio->descripcion)
                        <td>N/A</td>
                    @else
                        <td>{{$servicio->descripcion}}</td>
                    @endif
                    @if(!$servicio->condiciones)
                        <td>N/A</td>
                    @else
                        <td>{{$servicio->condiciones}}</td>
                    @endif
                    <td>{{$servicio->precio}}</td>
                    <td>{{$servicio->name_empresa}}</td>
                    <td>{{$servicio->name_categoria}}</td>






                    <td>
                        <button class="btn btn-sm btn-success" title="Editar">
                            <span class="fas fa-pencil-alt"></span>
                        </button>
                        <button class="btn btn-sm btn-danger"
                                title="Borrar">
                            <span class="fas fa-trash"></span>
                        </button>
                    </td>
                </tr>
            @endforeach

            </tbody>
        </table>

        @if(session("idNuevaCategoria"))
            <script>
                document.onreadystatechange = function () {
                    if (document.readyState) {
                        document.getElementById("botonAbrirModalNuevoServicio").click();
                    }
                }
            </script>
        @endif
    </div>


    <div class="modal fade" id="modalNuevoServicio" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header" style="background: #2a2a35">
                    <h5 class="modal-title" style="color: white"><span class="fas fa-plus"></span> Agregar Servicio
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true" style="color: white">&times;</span>
                    </button>
                </div>
                <form method="POST" action="{{route('servicios.store')}}" enctype="multipart/form-data">

                    @include('Alerts.errors')


                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="nombreNuevoServicio">Nombre del servicio</label>
                            <input  name="name" id="nombreNuevoServicio" maxlength="100"  class="form-control @error('name') is-invalid @enderror">
                            @error('name')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>

                                    </span>
                            @enderror
                        </div>


                        <div class="form-group">
                            <label for="condicionesNuevoServicio">Condiciones</label>
                            <input required class="form-control @error('condiciones') is-invalid @enderror" name="condiciones" id="condicionesNuevoServicio" maxlength="192">
                            @error('condiciones')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>

                                    </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="precioNuevoServicio">Precio</label>
                            <input type="text" required class="form-control @error('precio') is-invalid @enderror" name="precio" id="precioNuevoServicio"  maxlength="8"  pattern="[0-9]+">
                            @error('precio')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>

                                    </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="EmpresaNuevoServicio">Seleccione la empresa
                                <!---- Boton para crear un nuevo tipo de categoria- -->
                            </label>
                            <br>
                            <select name="id_empresa"
                                    required
                                    style="width: 85%"
                                    class="select2TipoCategoria form-control @error('id_empresa') is-invalid @enderror" id="tipoNuevaCategoria">
                                <option disabled selected value="">Seleccione</option>
                                @foreach($empresas as $empresa)
                                    <option value="{{$empresa->id}}">{{$empresa->name}}</option>

                                @endforeach
                            </select>
                            @error('id_empresa')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                            <a class="btn btn-sm btn-outline-success"
                               data-toggle="modal"
                               data-target="">
                                <i class="fas fa-plus" style="color: green"></i></a>
                        </div>

                        <div class="form-group">
                            <label for="CategoriaNuevoServicio">Seleccione la categoria
                                <!---- Boton para crear un nuevo tipo de categoria- -->
                            </label>
                            <br>
                            <select name="id_categoria"
                                    required
                                    style="width: 85%"
                                    class="select2TipoCategoria form-control @error('id_categoria') is-invalid @enderror" id="id_categoria">
                                <option disabled selected value="">Seleccione</option>
                                @foreach($categorias as $categoria)
                                    <option value="{{$categoria->id}}">{{$categoria->name}}</option>

                                @endforeach
                            </select>
                            @error('id_categoria')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                            <a class="btn btn-sm btn-outline-success"
                               data-toggle="modal"
                               data-target="">
                                <i class="fas fa-plus" style="color: green"></i></a>
                        </div>
                        <div class="form-group">
                            <label for="descripcionNuevoServicio">Descripción del servicio (Opcional):</label>
                            <textarea class="form-control"
                                      name="descripcion"
                                      id="descripcionNuevaCategoria"
                                      maxlength="192"></textarea>
                        </div>
                        <label for="imagenServicio">Seleccione una imagen (opcional): </label>

                        <div class="container" >
                            <div class="row"  >
                                <div class="col-md-4 main-section" >

                                    {!! csrf_field() !!}
                                    <div class="file-loading">
                                        <input id="file-1" type="file" name="file"    data-overwrite-initial="true" data-min-file-count="1">

                                    </div>

                                </div>
                            </div>
                        </div>


                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">Crear</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
    <div class="modal fade" id="modalNuevoTipoCategoria" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header" style="background: #2a2a35">
                    <h5 class="modal-title" style="color: white">Crear nuevo tipo de categoria</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span style="color: white" aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{route("nuevoTipoCategoria")}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="nombreNuevoTipoCategoria">Ingrese el nombre:</label>
                            <input class="form-control"
                                   required name="name" id="nombreNuevoTipoCategoria" maxlength="100">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" name="fuenteRuta" value="/categoria">
                        <button type="submit" class="btn btn-success">Crear</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalVistaPreviaServicio" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header" style="background: #2a2a35">
                    <h5 class="modal-title" style="color: white"><span class="fas fa-pencil-alt"></span> Vista Previa
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span style="color: white" aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" style="object-fit: fill">
                    <img id="img"
                         style="display:block; width: 100%; margin-left: auto; margin-right: auto;"
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


    <style media="screen">
        #uploadForm,
        #imagePreview{
            width: 150px;
            margin:  auto;
        }

        img{
            max-width: 150px;
            height: 150px;
        }
    </style>


 @endsection

