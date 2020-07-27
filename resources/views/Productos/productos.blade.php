@extends("layouts.main")
@section("content")
    <div class="container-fluid">
        <h1 class="mt-4">Productos
            <div class="btn-group" role="group">
                <button class="btn btn-sm btn-success"
                        id="botonAbrirModalNuevoProducto"
                        data-toggle="modal" data-target="#modalNuevoProducto">
                    <span class="fas fa-plus"></span> Nueva
                </button>
            </div>

        </h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item" aria-current="page" ><a href="/">Inicio</a></li>
                <li class="breadcrumb-item active" aria-current="page">Productos</li>
            </ol>
         <</nav>
        @if(session("exito"))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{session("exito")}}
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

        <table class="table">
            <thead class="thead-dark">
            <tr>
                <th>#</th>
                <th>Imagen</th>
                <th>Nombre</th>
                <th>Precio Unitario</th>
                <th>Pecio Lote</th>
                <th>Disponible</th>


                <th><span class="fas fa-info-circle"></span></th>
            </tr>
            </thead>
            <tbody>
            @if(!$productos)
                <tr>
                    <td colspan="4" style="align-items: center">No hay productos</td>
                </tr>
            @endif
            @foreach($productos as $productos)
                <tr>
                    <td>{{$noPagina++}}</td>

                    <td>
                        <button id="callModalVistaPrevia{{$productos->id}}"
                                data-src_img="{{$productos->imagen_url}}"
                                @if($productos->imagen_url)
                                data-toggle="modal"
                                data-target="#modalVistaPreviaProductos"
                                @endif
                                style="opacity: 0"></button>
                        <img src="/images/productos/{{$productos->imagen_url}}"
                             onclick="$('#callModalVistaPrevia{{$productos->id}}').click()"
                             width="250px" height="250px" style="object-fit: contain"
                             onerror="this.src='/images/noimage.jpg'"> {{$productos->nombre_categoria}}</td>
                    <td>{{$productos->name}}</td>
                    <td>{{$productos->unit_price}}</td>
                    <td>{{$productos->lote_price}}</td>
                    <td>{{$productos->disponible}}</td>

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

    </div>

    <div class="modal fade" id="modalNuevoProducto" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header" style="background: #2a2a35">
                    <h5 class="modal-title" style="color: white"><span class="fas fa-plus"></span> Agregar Producto
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true" style="color: white">&times;</span>
                    </button>
                </div>
                <form method="POST" action="{{route("nuevoProducto")}}" enctype="multipart/form-data">

                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="nombreNuevoProducto">Nombre Producto</label>
                            <input required class="form-control" name="name" id="nombreNuevoProducto" maxlength="100">
                        </div>

                        <div class="form-group">
                            <label for="descripcionNuevoProducto">Descripción de nuevo Producto (Opcional):</label>
                            <textarea class="form-control"
                                      name="descripcion"
                                      id="descripcionNuevaCategoria"
                                      maxlength="192"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="precioUnitarioProducto">Precio Unitario</label>
                            <input required class="form-control" name="unit_price" id="precioUnitarioProducto" maxlength="7" type="number">
                        </div>
                        <div class="form-group">
                            <label for="precioUnitarioProducto">Precio Lote</label>
                            <input required class="form-control" name="lote_price" id="precioLoteProducto" maxlength="8" type="number">
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
                                @foreach($tipoCategoria as $categoria)
                                    <option value="{{$categoria->id}}"
                                    @if(session("idNuevaCategoria"))
                                        {{session("idNuevaCategoria") == $categoria->id ? 'selected="selected"':''}}
                                        @endif>{{$categoria->name}}</option>
                                @endforeach
                            </select>
                            <!---- Boton para crear un nuevo tipo de categoria- -->
                            <a class="btn btn-sm btn-outline-success"
                               data-toggle="modal"
                               data-target="#modalNuevoTipoCategoria">
                                <i class="fas fa-plus" style="color: green"></i></a>
                        </div>
                        <div class="form-group">
                            <label for="empresa">Seleccione la empresa</label>
                            <br>
                            <select name="id_empresa"

                            style="width: 85%"
                            class="select2TipoCategoria form-control" id="empresa">
                                <option disabled selected value="">Seleccione</option>
                                @foreach($empresas as $empresa)
                                    <option value="{{$empresa->id}}" @if(session("idEmpresa"))
                                            {{session("idEmpresa")==$empresa->id ? 'selected="selected"':''}}
                                    @endif>{{$empresa->name}}
                                    </option>
                                    @endforeach
                            </select>
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
    <script src="{{asset("js/http_maxcdn.bootstrapcdn.com_bootstrap_4.0.0-beta_js_bootstrap.js")}}"
            type="text/javascript">
    </script>

@endsection
