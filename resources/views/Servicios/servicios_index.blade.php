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
                <div class="btn-group" role="group">
                    <button id="btnGroupDrop1" type="button" class="btn btn-warning dropdown-toggle" data-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="false">
                        Tipos de Categorias
                    </button>
                    <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                        <button class="dropdown-item" data-toggle="modal" data-target="#modalNuevoTipoCategoria"><span class="fas fa-plus"></span> Crear nueva</button>
                        <a class="dropdown-item" href="{{route("verTipoCategorias")}}"><span class="fas fa-external-link-alt"></span> Ver & editar</a>
                    </div>
                </div>
            </div>
        </h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb" style="background: transparent">
                <li class="breadcrumb-item" aria-current="page"><a href="/">Inicio</a></li>
                <li class="breadcrumb-item active" aria-current="page">Categorias</li>
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
        <table class="table">
            <thead class="thead-dark">
            <tr>
                <th>#</th>
                <th>Nombre</th>
                 <th>Descripción</th>
                <th>Condiciones</th>
                <th>Pecio</th>
                <th>Empresa</th>
                <th>Categoria</th>
                <th>Imagen</th>

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
                    <td>{{$servicio->servicio_img_id}}</td>





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

                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="nombreNuevoServicio">Nombre del servicio</label>
                            <input required class="form-control" name="name" id="nombreNuevoServicio" maxlength="100">
                        </div>

                        <div class="form-group">
                            <label for="descripcioNuevoServicio">Descripción</label>
                            <input required class="form-control" name="descripcion" id="descripcioNuevoServicio" maxlength="100">
                        </div>

                        <div class="form-group">
                            <label for="condicionesNuevoServicio">Condiciones</label>
                            <input required class="form-control" name="descripcion" id="condicionesNuevoServicio" maxlength="100">
                        </div>

                        <div class="form-group">
                            <label for="precioNuevoServicio">Precio</label>
                            <input type="number" required class="form-control" name="descripcion" id="precioNuevoServicio" maxlength="5">
                        </div>
                        <div class="form-group">
                            <label for="EmpresaNuevoServicio">Seleccione la empresa
                                <!---- Boton para crear un nuevo tipo de categoria- -->
                            </label>
                            <br>
                            <select name="id_empresa"
                                    required
                                    style="width: 85%"
                                    class="select2TipoCategoria form-control" id="tipoNuevaCategoria">
                                <option disabled selected value="">Seleccione</option>
                                @foreach($empresas as $empresa)
                                    <option value="{{$empresa->id}}" @if(session("idNuevaCategoria"))
                                        {{session("idNuevaCategoria") == $tipoCategoria->id ? 'selected="selected"':''}}
                                        @endif>{{$empresa->name}}</option>
                                @endforeach
                            </select>
                            <a class="btn btn-sm btn-outline-success"
                               data-toggle="modal"
                               data-target="#modalNuevoTipoCategoria">
                                <i class="fas fa-plus" style="color: green"></i></a>
                        </div>
                        <div class="form-group">
                            <label for="descripcionNuevaCategoria">Descripción de nueva categoria (Opcional):</label>
                            <textarea class="form-control"
                                      name="descripcion"
                                      id="descripcionNuevaCategoria"
                                      maxlength="192"></textarea>
                        </div>
                        <label for="imagenCategoria">Seleccione una imagen (opcional): </label>
                        <div class="input-group image-preview">

                            <input type="text" class="form-control image-preview-filename" disabled="disabled">
                            <!-- don't give a name === doesn't send on POST/GET -->
                            <span class="input-group-btn">
                                <!-- image-preview-clear button -->
                                <button type="button" class="btn btn-outline-danger image-preview-clear"
                                        style="display:none;">
                                    <span class="fas fa-times"></span> Clear
                                </button>
                                <!-- image-preview-input -->
                                <div class="btn btn-default image-preview-input">
                                    <span class="fas fa-folder-open"></span>
                                    <span class="image-preview-input-title">Seleccionar</span>
                                    <input type="file" accept="image/png, image/jpeg, image/gif"
                                           name="imagen_url"/>
                                    <!-- rename it -->
                                </div>
                            </span>
                        </div><!-- /input-group image-preview [TO HERE]-->
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

