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

        @if(session("errores"))

            <input id="idServicio" name="idServicio" value="{{session("idServicio")}}" type="hidden" >

            <script>
                var idServicio=document.getElementById("idServicio").value;

                document.onreadystatechange = function () {
                    if (document.readyState) {
                        document.getElementById("botonAbrirModalEditarServicio"+idServicio).click();
                    }
                }
            </script>
        @else

            @if ($errors->any())
                <script>
                    document.onreadystatechange = function () {
                        if (document.readyState) {
                            document.getElementById("botonAbrirModalNuevoServicio").click();
                        }
                    }
                </script>
            @endif
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
                        <a href="{{route('imagenes',$servicio->id)}}">
                        <button class="btn btn-sm btn-warning"
                                title="Borrar"
                           >
                            <span class="fas fa-info-square"></span>
                        </button>
                        </a>


                        <button class="btn btn-sm btn-success"
                                data-toggle="modal"
                                id="botonAbrirModalEditarServicio{{$servicio->id}}"
                                data-target="#modalEditarServicio"
                                data-nombre="{{$servicio->name}}"
                                data-id="{{$servicio->id}}"
                                data-descripcion="{{$servicio->descripcion}}"
                                data-condiciones="{{$servicio->condiciones}}"
                                data-precio="{{$servicio->precio}}"

                                data-id_empresa="{{$servicio->id_empresa}}"
                                data-id_categoria="{{$servicio->id_categoria}}"
                                data-img_url="{{$servicio->servicio_img_id}}"
                                data-id_tipo_categoria="{{$servicio->id_categoria}}"
                                title="Editar">
                            <span class="fas fa-pencil-alt"></span>
                        </button>
                        <button class="btn btn-sm btn-danger"
                                title="Borrar"
                                data-toggle="modal"
                                data-id_servicio="{{$servicio->id}}"
                                data-nombre="{{$servicio->name}}"
                                data-target="#modalBorrarServicio">
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
                            <input  name="name" id="nombreNuevoServicio" maxlength="100" value="{{ old('name') }}" class="form-control @error('name') is-invalid @enderror">
                            @error('name')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>

                                    </span>
                            @enderror
                        </div>


                        <div class="form-group">
                            <label for="condicionesNuevoServicio">Condiciones</label>
                            <input  class="form-control @error('condiciones') is-invalid @enderror" value="{{ old('condiciones') }}" name="condiciones" id="condicionesNuevoServicio" maxlength="192">
                            @error('condiciones')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>

                                    </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="precioNuevoServicio">Precio</label>
                            <input type="text"  class="form-control @error('precio') is-invalid @enderror" value="{{ old('precio') }}" name="precio" id="precioNuevoServicio"  maxlength="8"  pattern="[0-9]+">
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

                                    style="width: 85%"
                                    class="select2TipoCategoria form-control @error('id_empresa') is-invalid @enderror"  id="id_empresa">
                                <option disabled selected value="">Seleccione</option>
                                @foreach($empresas as $empresa)

                                    <option value="{{$empresa->id}}"@if (old('id_empresa') == $empresa->id) {{ 'selected' }} @endif>{{$empresa->name}}</option>

                                @endforeach
                            </select>
                            @error('id_empresa')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror

                        </div>

                        <div class="form-group">
                            <label for="CategoriaNuevoServicio">Seleccione la categoria
                                <!---- Boton para crear un nuevo tipo de categoria- -->
                            </label>
                            <br>
                            <select name="id_categoria"

                                    style="width: 85%"
                                    class="select2TipoCategoria form-control @error('id_categoria') is-invalid @enderror" id="id_categoria">
                                <option disabled selected value="">Seleccione</option>
                                @foreach($categorias as $categoria)


                                    <option value="{{$categoria->id}}"@if (old('id_categoria') == $categoria->id) {{ 'selected' }}@endif @if(session("idNuevaCategoria"))
                                        {{session("idNuevaCategoria") == $categoria->id ? 'selected="selected"':''}}
                                        @endif>{{$categoria->name}}</option>

                                @endforeach
                            </select>
                            @error('id_categoria')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                            <a class="btn btn-sm btn-outline-success"
                               data-toggle="modal"
                               data-target="#modalNuevaCategoria">
                                <i class="fas fa-plus" style="color: green"></i></a>
                        </div>
                        <div class="form-group">
                            <label for="descripcionNuevoServicio">Descripción del servicio (Opcional):</label>
                            <textarea class="form-control"
                                      name="descripcion"
                                      id="descripcionNuevaCategoria"
                                      maxlength="192">{{Request::old('descripcion')}}</textarea>
                        </div>

                        <label for="imagenCategoria">Seleccione una imagen (opcional): </label>
                        <div class="input-group image-preview">

                            <input type="text" name="servicio_img_id" class="form-control image-preview-filename @error('servicio_img_id') is-invalid @enderror"
                                   disabled="disabled">
                            @error('servicio_img_id')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                        @enderror

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
                                           name="servicio_img_id"/>
                                    <!-- rename it -->
                                </div>
                            </span>
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

    <div class="modal fade" id="modalEditarServicio" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header" style="background: #2a2a35">
                    <h5 class="modal-title" style="color: white"><span class="fas fa-pencil-alt"></span> Editar
                        servicio</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span style="color: white" aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="post" action="{{route("editarServicio")}}" enctype="multipart/form-data">
                    @method("PUT")
                    @csrf


                    @include('Alerts.errors')

                    <div class="modal-body">
                        <div class="form-group">
                            <input id="nombreEditarServicio" value="{{ old('name') }}" placeholder="Nombre de servicio" name="name" class="form-control" max="100" required>
                        </div>
                        <div class="form-group">
                            <input id="condicionesEditarServicio" placeholder="Condiciones" name="condiciones" class="form-control" max="100" required>
                        </div>

                        <div class="form-group">
                            <input id="precioEditarServicio" placeholder="precio" name="precio" class="form-control" max="100" required>
                        </div>
                        <div class="form-group">
                            <label for="tipoNuevaCategoria">Seleccione la empresa
                            </label>
                            <br>
                            <select name="id_empresa"
                                    required
                                    style="width: 85%"
                                    class="select2TipoCategoria form-control" id="idEmpresaEditar">
                                <option disabled selected value="">Seleccione</option>
                                @foreach($empresas as $empresa)
                                    <option value="{{$empresa->id}}" >{{$empresa->name}}</option>
                                @endforeach
                            </select>
                            <!---- Boton para crear un nuevo tipo de categoria- -->


                        </div>


                        <div class="form-group">
                            <label for="nuevaCategoria">Seleccione la categoria
                            </label>
                            <br>
                            <select name="id_categoria"
                                    required
                                    style="width: 85%"
                                    class="select2TipoCategoria form-control" id="idCategoriaEditar">
                                <option disabled selected value="">Seleccione</option>
                                @foreach($categorias as $categoria)
                                    <option value="{{$categoria->id}}" >{{$categoria->name}}</option>
                                @endforeach
                            </select>
                            <!---- Boton para crear un nuevo tipo de categoria- -->


                        </div>

                        <div class="form-group">
                            <label for="descripcionNuevaCategoria">Descripción de categoria (Opcional):</label>
                            <textarea class="form-control"
                                      name="descripcion"
                                      id="descripcionEditarServicio"
                                      maxlength="192"></textarea>
                        </div>
                        <img id="imgVistaPreviaEditarservicio"
                             height="150px" width="150px"
                             style="object-fit: contain"
                             onerror="this.src='/images/noimage.jpg'">
                        <label for="imagenCategoria">Seleccione una imagen (opcional): </label>
                        <div class="input-group image-preview">
                            <input type="text" name="servicio_img_id" class="form-control image-preview-filename"
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
                                           name="servicio_img_id"/>
                                    <!-- rename it -->
                                </div>
                            </span>
                        </div><!-- /input-group image-preview [TO HERE]-->

                    </div>
                    <div class="modal-footer">
                        <input id="idServicio" name="idServicio" type="hidden" >
                        <button type="submit" class="btn btn-success">Editar</button>
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
    <div class="modal fade" id="modalBorrarServicio" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <form method="post" action="{{route("destroyServicio")}}" enctype="multipart/form-data">
                    @method("DELETE")
                    @csrf
                    <div class="modal-header" style="background: #2a2a35">
                        <h5 class="modal-title" style="color: white"><span class="fas fa-trash"></span> Borrar Servicio
                        </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span style="color: white" aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>¿Estás seguro que deseas borrar este servicio con nombre ' <label
                                id="nombreservicio"></label>'?</p>

                    </div>
                    <div class="modal-footer">
                        <input id="idservicio" name="id" type="hidden" value="">
                        <button type="submit" class="btn btn-danger">Borrar</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    </div>
                </form>
            </div>

        </div>
    </div>

    <div class="modal fade" id="modalNuevaCategoria" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header" style="background: #2a2a35">
                    <h5 class="modal-title" style="color: white"><span class="fas fa-plus"></span> Agregar Categoría
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true" style="color: white">&times;</span>
                    </button>
                </div>
                <form method="POST" action="{{route("nuevaCategoriaModal")}}" enctype="multipart/form-data">

                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="nombreNuevaCategoria">Nombre de categoria</label>
                            <input required class="form-control" name="name"
                                   id="nombreNuevaCategoria" maxlength="100">
                        </div>
                        <div class="form-group">
                            <label for="tipoNuevaCategoria">Seleccione el tipo de Categoria

                            </label>
                            <br>
                            <select name="id_categoria"
                                    required
                                    style="width: 85%"
                                    class="select2TipoCategoria form-control" id="tipoNuevaCategoria">
                                <option disabled selected value="">Seleccione</option>
                                @foreach($tipoCategorias as $tipoCategoria)
                                    <option value="{{$tipoCategoria->id}}" @if(session("idNuevaCategoria"))
                                        {{session("idNuevaCategoria") == $tipoCategoria->id ? 'selected="selected"':''}}
                                        @endif>{{$tipoCategoria->name}}</option>
                                @endforeach
                            </select>
                            <!---- Boton para crear un nuevo tipo de categoria- -->

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

                            <input type="text" name="imagen_url" class="form-control image-preview-filename"
                                   disabled="disabled">
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


    <script>
        $(document).ready(function() {
            const genderOldValue = '{{ old('id_empresa') }}';

            if(genderOldValue !== '') {
                $('#id_empresa').val(genderOldValue);
            }
        });
    </script>


@endsection
