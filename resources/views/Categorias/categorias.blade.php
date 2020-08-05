@extends("layouts.main")
@section("content")
    <div class="container-fluid">
        <h1 class="mt-4">Categorias
            <div class="btn-group" role="group">
                <button class="btn btn-sm btn-success"
                        id="botonAbrirModalNuevaCategoria"
                        data-toggle="modal" data-target="#modalNuevaCategoria">
                    <span class="fas fa-plus"></span> Nueva
                </button>
                <div class="btn-group" role="group">
                    <button id="btnGroupDrop1" type="button" class="btn btn-warning dropdown-toggle"
                            data-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="false">
                        Tipos de Categorias
                    </button>
                    <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                        <button class="dropdown-item" data-toggle="modal" data-target="#modalNuevoTipoCategoria"><span
                                class="fas fa-plus"></span> Crear nueva
                        </button>
                        <a class="dropdown-item" href="{{route("verTipoCategorias")}}"><span
                                class="fas fa-external-link-alt"></span> Ver & editar</a>
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
                <span class="fas fa-check"></span> {{session("exito")}}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif
        @if(session("error"))
            <div class="alert alert-danger alert-dismissible" role="alert">
                <span class="fa fa-save"></span> {{session("error")}}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif
        <div class="pagination pagination-sm ">
            {{$categorias->links()}}
            <form action="{{route("buscarCategorias")}}"
                  enctype="multipart/form-data" method="GET"
                  class="d-none d-md-inline-block form-inline
                           ml-auto mr-0 mr-md-2 my-0 my-md-0 mb-md-2">
                <!--- METODO PARA BUSCAR PRODUCTOS EN EL INDEX DE PRODUCTOS -->
                <div class="input-group" style="width: 300px">
                    <input class="form-control" type="text"
                           id="busquedaInput"
                           name="busqueda"
                           @if(session("busqueda"))
                           value="{{$busqueda}}"
                           @endif
                           placeholder="Buscar..." aria-label="Search"
                           aria-describedby="basic-addon2"/>
                    <div class="input-group-append">
                        <a id="borrarBusqueda" class="btn btn-danger hideClearSearch" style="color: white"
                           href="{{route("categorias")}}">&times;</a>
                        <button class="btn btn-primary" type="submit"><i class="fas fa-search"></i></button>
                    </div>
                </div>
            </form>
        </div>
        @if($categorias->count()==0)
            <div class="alert alert-info  alert-dismissible" role="alert">
                <h4 class="alert-heading"><span class="fas fa-exclamation-triangle"></span> ¡Ups! Al parecer no hay
                    categorías ingresadas aún.</h4>
                <hr>
                <p class="mb-0">Pulsa el boton superior <span class="fas fa-plus"></span> para agregar una nueva categoria
                    o presiona <a href="javascript:void(0);"
                                  data-toggle="modal"
                                  data-target="#modalNuevaCategoria">aquí</a></p>
            </div>
        @else
            <table class="table">
                <thead class="thead-dark">
                <tr>
                    <th>#</th>
                    <th>Nombre</th>
                    <th>Tipo</th>
                    <th>Descripción</th>
                    <th><span class="fas fa-info-circle"></span></th>
                </tr>
                </thead>
                <tbody>
                @foreach($categorias as $categoria)
                    <tr>
                        <td>{{$noPagina++}}</td>
                        <td>
                            <button id="callModalVistaPrevia{{$categoria->id}}"
                                    data-src_img="{{$categoria->img_url}}"
                                    @if($categoria->img_url)
                                    data-toggle="modal"
                                    data-target="#modalVistaPrevia"
                                    @endif
                                    style="opacity: 0"></button>
                            <img src="/images/categorias/{{$categoria->img_url}}"
                                 onclick="$('#callModalVistaPrevia{{$categoria->id}}').click()"
                                 width="100px" height="100px" class="image-class"
                                 onerror="this.src='/images/noimage.jpg'"> {{$categoria->name}}</td>
                        <td>{{$categoria->tipo_categoria}}</td>
                        @if(!$categoria->descripcion)
                            <td>N/A</td>
                        @else
                            <td>{{$categoria->descripcion}}</td>
                        @endif

                        <td>
                            <button class="btn btn-sm btn-success"
                                    data-toggle="modal"
                                    data-target="#modalEditarCategoria"
                                    data-nombre="{{$categoria->name}}"
                                    data-id="{{$categoria->id}}"
                                    data-descripcion="{{$categoria->descripcion}}"
                                    data-img_url="{{$categoria->img_url}}"
                                    data-id_tipo_categoria="{{$categoria->id_categoria}}"
                                    title="Editar">
                                <span class="fas fa-pencil-alt"></span>
                            </button>
                            <button class="btn btn-sm btn-danger"
                                    title="Borrar"
                                    data-toggle="modal"
                                    data-id_categoria="{{$categoria->id}}"
                                    data-nombre="{{$categoria->name}}"
                                    data-target="#modalBorrarCategoria">
                                <span class="fas fa-trash"></span>
                            </button>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @endif
        @if(session("idNuevaCategoria"))
            <script>
                document.onreadystatechange = function () {
                    if (document.readyState) {
                        document.getElementById("botonAbrirModalNuevaCategoria").click();
                    }
                }
            </script>
        @endif
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
                <form method="POST" action="{{route("nuevaCategoria")}}" enctype="multipart/form-data">

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
    <div class="modal fade" id="modalNuevoTipoCategoria" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-" role="document">
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
                        <div class="form-group">
                            <label for="imagenCategoria">Seleccione una imagen de portada (opcional): </label>
                            <div class="input-group image-preview-tipo-categoria">

                                <input type="text" name="imagen_url"
                                       class="form-control image-preview-filename-tipo-categoria"
                                       disabled="disabled">
                                <!-- don't give a name === doesn't send on POST/GET -->
                                <span class="input-group-btn">
                                <!-- image-preview-clear button -->
                                <button type="button" class="btn btn-outline-danger image-preview-clear-tipo-categoria"
                                        style="display:none;">
                                    <span class="fas fa-times"></span> Clear
                                </button>
                                    <!-- image-preview-input -->
                                <div class="btn btn-default image-preview-input-tipo-categoria">
                                    <span class="fas fa-folder-open"></span>
                                    <span class="image-preview-input-title-tipo-categoria">Seleccionar</span>
                                    <input type="file" accept="image/png, image/jpeg, image/gif"
                                           name="imagen_url"/>
                                    <!-- rename it -->
                                </div></span>
                            </div><!-- /input-group image-preview [TO HERE]-->

                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" name="fuenteRuta"
                               value="{{\Illuminate\Support\Facades\Route::currentRouteName()}}">
                        <button type="submit" class="btn btn-success">Crear</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!--                modal editar categoria -->
    <div class="modal fade" id="modalEditarCategoria" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header" style="background: #2a2a35">
                    <h5 class="modal-title" style="color: white"><span class="fas fa-pencil-alt"></span> Editar
                        categoria</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span style="color: white" aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="post" action="{{route("editarCategoria")}}" enctype="multipart/form-data">
                    @method("PUT")
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <input id="nombreEditarCategoria" placeholder="Nombre de categoria" name="name"
                                   class="form-control" max="100" required>
                        </div>
                        <div class="form-group">
                            <label for="tipoNuevaCategoria">Seleccione el tipo de Categoria
                            </label>
                            <br>
                            <select name="id_categoria"
                                    required
                                    style="width: 85%"
                                    class="select2TipoCategoria form-control" id="tipoCategoriaEditar">
                                <option disabled selected value="">Seleccione</option>
                                @foreach($tipoCategorias as $tipoCategoria)
                                    <option value="{{$tipoCategoria->id}}" @if(session("idNuevaCategoria"))
                                        {{session("idNuevaCategoria") == $tipoCategoria->id ? 'selected="selected"':''}}
                                        @endif>{{$tipoCategoria->name}}</option>
                                @endforeach
                            </select>
                            <!---- Boton para crear un nuevo tipo de categoria- -->
                            <a class="btn btn-sm btn-outline-success"
                               data-toggle="modal"
                               data-target="#modalNuevoTipoCategoria">
                                <i class="fas fa-plus" style="color: green"></i></a>

                        </div>

                        <div class="form-group">
                            <label for="descripcionNuevaCategoria">Descripción de categoria (Opcional):</label>
                            <textarea class="form-control"
                                      name="descripcion"
                                      id="descripcionEditarCategoria"
                                      maxlength="192"></textarea>
                        </div>
                        <img id="imgVistaPreviaEditarCategoria"
                             height="150px" width="150px"
                             style="object-fit: contain"
                             onerror="this.src='/images/noimage.jpg'">
                        <label for="imagenCategoria">Seleccione una imagen (opcional): </label>
                        <div class="input-group image-preview">
                            <input type="text" name="imagen_url" class="form-control image-preview-filename"
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
                                           name="imagen_url"/>
                                    <!-- rename it -->
                                </div>
                            </span>
                        </div><!-- /input-group image-preview [TO HERE]-->

                    </div>
                    <div class="modal-footer">
                        <input id="idCategoria" name="id" type="hidden">
                        <button type="submit" class="btn btn-success">Editar</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- ..............................modal vista previa................................. -->
    <div class="modal fade" id="modalVistaPrevia" tabindex="-1" role="dialog">
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
                         style="display:block; width: 100%;
                         object-fit: contain;
                          max-height: 650px;
                          margin-left: auto;
                         margin-right: auto;"
                         onerror="this.src='/images/noimage.jpg'"
                    >
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- -------------------------------MODAL BORRAR CATEGORIA---------------------------------- -->
    <div class="modal fade" id="modalBorrarCategoria" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <form method="post" action="{{route("borrarCategoria")}}" enctype="multipart/form-data">
                    @method("DELETE")
                    @csrf
                    <div class="modal-header" style="background: #2a2a35">
                        <h5 class="modal-title" style="color: white"><span class="fas fa-trash"></span> Borrar Categoria
                        </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span style="color: white" aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p> ¿Estás seguro que deseas borrar este la categoria con nombre ' <label
                                id="nombreCategoriaBorrarModal"></label>'?</p>

                    </div>
                    <div class="modal-footer">
                        <input id="idCategoria" name="id" type="hidden" value="">
                        <button type="submit" class="btn btn-danger">Borrar</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    </div>
                </form>
            </div>

        </div>
    </div>


    <style>
        .image-preview-input-tipo-categoria {
            position: relative;
            overflow: hidden;
            margin: 0px;
            color: #333;
            background-color: #fff;
            border-color: #ccc;
        }

        .image-preview-input-tipo-categoria input[type=file] {
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

        .image-preview-input-title-tipo-categoria {
            margin-left: 2px;
        }

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

        .image-class {
            border-radius: 50%;
            object-fit: cover;
        }
        .image-class:hover{
            opacity: 0.7;
            transition: all 0.1s ease-in-out;
        }
    </style>
@endsection

