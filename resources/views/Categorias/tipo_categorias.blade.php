@extends("layouts.main")
@section("content")
    <div class="container-fluid">
        <h1 class="mt-4">Tipo de categorias
            <div class="btn-group" role="group">
                <button class="btn btn-sm btn-success"
                        id="botonAbrirModalNuevaCategoria"
                        data-toggle="modal" data-target="#modalNuevoTipoCategoria">
                    <span class="fas fa-plus"></span> Nueva
                </button>
            </div>
        </h1>

        <nav aria-label="breadcrumb">
            <ol class="breadcrumb" style="background: transparent">
                <li class="breadcrumb-item" aria-current="page"><a href="/">Inicio</a></li>

                <li class="breadcrumb-item" aria-current="page"><a href="{{route("categorias")}}">Categorias</a></li>
                <li class="breadcrumb-item active" aria-current="page">Tipos</li>
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
        <div class="pagination pagination-sm ">
            {{$tiposCategorias->links()}}
            <form action="{{route("buscarTipoCategorias")}}"
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
                           href="{{route("verTipoCategorias")}}">&times;</a>
                        <button class="btn btn-primary" type="submit"><i class="fas fa-search"></i></button>
                    </div>
                </div>
            </form>
        </div>
        @if($tiposCategorias->count()==0)
            <div class="alert alert-info  alert-dismissible" role="alert">
                <h4 class="alert-heading"><span class="fas fa-exclamation-triangle"></span> ¡Ups! Al parecer no hay
                    categorías ingresadas aún.</h4>
                <hr>
                <p class="mb-0">Pulsa el boton superior <span class="fas fa-plus"></span> para agregar una nueva
                    categoria
                    o presiona <a href="javascript:void(0);"
                                  data-toggle="modal"
                                  data-target="#modalNuevoTipoCategoria">aquí</a></p>
            </div>
        @else
            <table class="table">
                <thead class="thead-dark">
                <tr>
                    <th>#</th>
                    <th>Nombre</th>
                    <th>Creado a las:</th>
                    <th><span class="fas fa-info-circle"></span></th>
                </tr>
                </thead>
                <tbody>

                @foreach($tiposCategorias as $categoria)
                    <tr>
                        <td>{{$noPagina++}}</td>
                        <td>
                            <button id="callModalVistaPrevia{{$categoria->id}}"
                                    data-src_img="{{$categoria->img_url}}"
                                    @if($categoria->img_url)
                                    data-toggle="modal"
                                    data-target="#modalVistaPreviaTipoCategorias"
                                    @endif
                                    style="opacity: 0"></button>
                            <img src="/images/categorias/tipos/{{$categoria->img_url}}"
                                 class="image-class"
                                 onclick="$('#callModalVistaPrevia{{$categoria->id}}').click()"
                                 width="100px" height="100px"
                                 onerror="this.src='/images/noimage.jpg'"> {{$categoria->name}}</td>
                        <td>{{$categoria->created_at}}</td>
                        <td>
                            <button class="btn btn-sm btn-success"
                                    data-toggle="modal"
                                    data-target="#modalEditarTipoCategoria"
                                    data-id_categoria="{{$categoria->id}}"
                                    data-nombre="{{$categoria->name}}"
                                    data-src_img="{{$categoria->img_url}}"
                                    title="Editar">
                                <span class="fas fa-pencil-alt"></span>
                            </button>
                            <button class="btn btn-sm btn-danger"
                                    data-target="#modalBorrarTipoCategoria"
                                    data-toggle="modal"
                                    data-nombre="{{$categoria->name}}"
                                    data-id_categoria="{{$categoria->id}}"
                                    title="Borrar">
                                <span class="fas fa-trash"></span>
                            </button>
                        </td>
                    </tr>
                @endforeach


            </table>
        @endif
        <div class="pagination pagination-sm justify-content-center">
            {{$tiposCategorias->links()}}
        </div>
    </div>

    <div class="modal fade" id="modalNuevoTipoCategoria" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
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
                            <label for="nombreNuevoTipoCategoria"><strong style="color: red">*</strong> Ingrese el
                                nombre:</label>
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

    <div class="modal fade" id="modalBorrarTipoCategoria" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <form method="post" action="{{route("borrarTipoCategoria")}}" enctype="multipart/form-data">
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
                        <p>¿Estás seguro que deseas borrar este tipo de categoria con nombre ' <label
                                id="nombreTipoCategoriaBorrarModal"></label>'?</p>

                    </div>
                    <div class="modal-footer">
                        <input id="idCategoria" name="idCategoria" type="hidden" value="">
                        <button type="submit" class="btn btn-danger">Borrar</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    </div>
                </form>
            </div>

        </div>
    </div>

    <div class="modal fade" id="modalEditarTipoCategoria" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header" style="background: #2a2a35">
                    <h5 class="modal-title" style="color: white"><span class="fas fa-pencil-alt"></span> Editar tipo de
                        categoria</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span style="color: white" aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="post" action="{{route("editarTipoCategoria")}}" enctype="multipart/form-data">
                    @method("PUT")
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">

                            <label for="nombreCategoria">Modifique el nombre</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text"><span class="fas fa-heading"></span></div>
                                </div>
                                <input id="nombre_categoria" placeholder="Nombre del tipo de categoria"
                                       class="form-control" type="text" maxlength="100" required
                                       name="name">
                            </div>
                            <small class="text-muted justify-content-end">
                                Debe ser menos de 100 carácteres.
                            </small>
                        </div>
                        <img id="imgVistaPreviaEditarCategoria"
                             height="150px" width="150px"
                             style="object-fit: contain"
                             onerror="this.src='/images/noimage.jpg'">
                        <label for="imagenCategoria">Seleccione una imagen (opcional): </label>
                        <hr>
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
                        <input type="hidden" name="id" id="id">
                        <button type="submit" class="btn btn-success">Editar</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>

                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- ..............................modal vista previa................................. -->
    <div class="modal fade" id="modalVistaPreviaTipoCategorias" tabindex="-1" role="dialog">
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
                         style="display:block;
                         object-fit: contain;
                          max-height: 650px; width: 100%; margin-left: auto; margin-right: auto;"
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

        .image-class:hover {
            opacity: 0.7;
            transition: all 0.1s ease-in-out;
        }
    </style>
@endsection
