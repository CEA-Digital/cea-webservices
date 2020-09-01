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
            <div class="pagination pagination-sm">

                <form  class="d-none d-md-inline-block form-inline
                           ml-auto mr-0 mr-md-2 my-0 my-md-0 mb-md-2">
                    <div class="input-group" style="width: 300px">
                        <input class="form-control" name="search" type="search" placeholder="Search"
                               aria-label="Search">
                        <div class="input-group-append">
                            <a id="borrarBusqueda" class="btn btn-danger hideClearSearch" style="color: white"
                               href="{{route("productos")}}">&times;</a>
                            <button class="btn btn-primary" type="submit"><i class="fas fa-search"></i></button>
                        </div>
                    </div>
                </form>
            </div>
         </nav>

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

        @if(session("errores"))
            <input type="hidden" id="id_producto" name="id_producto" value="{{session("id_producto")}}">
            <script type="text/javascript">
                var id = document.getElementById("id_producto").value;
                document.onreadystatechange = function n(){
                    if (document.readyState){
                        document.getElementById("editarProducto"+id).click();
                    }
                }
            </script>
        @endif
        @if($errors->any())

            <script>
                document.onreadystatechange = function n(){
                    if (document.readyState){
                       document.getElementById("botonAbrirModalNuevoProducto").click();
                    }
                }
            </script>
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
                                style="opacity: 0">
                        </button>
                        <img src="/images/productos/{{$productos->imagen_url}}"
                             onclick="$('#callModalVistaPrevia{{$productos->id}}').click()"
                             width="150px" height="150px" style="object-fit: contain"
                             onerror="this.src='/images/noimage.jpg'"></td>

                    <td>{{$productos->name}}</td>
                    <td>{{$productos->unit_price}}</td>
                    <td>{{$productos->lote_price}}</td>
                     @if($productos->disponible===1)
                            <td>Disponible</td>
                            @else
                         <td>No Disponible</td>
                            @endif


                    <td>
                        <button class="btn btn-sm btn-info"
                                title="Ver"
                                data-toggle="modal"
                                data-target="#modalVerProducto"
                                data-name="{{$productos->name}}"
                                data-description="{{$productos->description}}"
                                data-id_categoria="{{$productos->nombre_categoria}}"
                                data-id_empresa="{{$productos->nombre_empresa}}"
                                data-unit_price="{{$productos->unit_price}}"
                                data-lote_price="{{$productos->lote_price}}"
                                data-disponible="{{$productos->disponible}}"
                                data-img_url="{{$productos->imagen_url}}"
                                data-id_marca="{{$productos->nombre_marca}}">
                            <span class="fas fa-eye"></span>
                        </button>
                        <button class="btn btn-sm btn-success"
                                id="editarProducto{{$productos->id}}"
                                data-toggle="modal"
                                data-target="#modalEditarProducto"
                                data-id="{{$productos->id}}"
                                data-name="{{$productos->name}}"
                                data-description="{{$productos->description}}"
                                data-id_categoria="{{$productos->id_categoria}}"
                                data-id_empresa="{{$productos->id_empresa}}"
                                data-unit_price="{{$productos->unit_price}}"
                                data-lote_price="{{$productos->lote_price}}"
                                data-disponible="{{$productos->disponible}}"
                                data-img_url="{{$productos->imagen_url}}"
                                data-id_marca="{{$productos->id_marca}}"
                                title="Editar">
                            <span class="fas fa-pencil-alt"></span>
                        </button>
                        <button class="btn btn-sm btn-danger"
                                title="Borrar"
                                data-toggle="modal"
                                data-target="#modalBorrarProducto"
                                data-id="{{$productos->id}}"
                                data-name="{{$productos->name}}">
                            <span class="fas fa-trash"></span>
                        </button>
                    </td>
                </tr>
            @endforeach

            </tbody>
        </table>

    </div>
    <!-----vista previa imagen------->
    <div class="modal fade" id="modalVistaPreviaProductos" tabindex="-1" role="dialog">
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

<!----------------------------------------------------MODAL NUEVO PRODUCTO------------------------------------------------------->
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
                <form id="nuevoP" method="POST" action="{{route("nuevoProducto")}}" enctype="multipart/form-data">

                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="nombreNuevoProducto">Nombre Producto</label>
                            <input class="form-control @error('name') is-invalid @enderror" name="name" id="nombreNuevoProducto" maxlength="100"
                                   value="{{ old('name')}}" required="required">
                            @error('name')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="descripcionNuevoProducto">Descripción de nuevo Producto (Opcional):</label>
                            <textarea class="form-control @error('description') is-invalid @enderror"
                                      name="description"
                                      id="descripcionNuevoProducto"
                                      maxlength="192"
                            >{{Request::old('description')}}</textarea>
                            @error('description')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="precioUnitarioProducto">Precio Unitario</label>
                            <input required="required" class="form-control @error('unit_price') is-invalid @enderror" name="unit_price"
                                   id="precioUnitarioProducto" maxlength="8"
                                   type="number"
                                   value="{{old('unit_price')}}">
                            @error('unit_price')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="precioUnitarioProducto">Precio Lote</label>
                            <input required="required" class="form-control @error('lote_price') is-invalid @enderror" name="lote_price" id="precioLoteProducto"
                                   maxlength="8"
                                   type="number"
                                   value="{{old('lote_price')}}">
                            @error('lote_price')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="tipoNuevaCategoria">Seleccione la Categoria
                            </label>
                            <br>
                            <select name="id_categoria"
                                    required="required"
                                    style="width: 85%"
                                    class="tipoCategoria form-control @error('id_categoria') is-invalid @enderror"
                                    id="tipoNuevaCategoria">
                                <option disabled selected value="s">Seleccione</option>
                                @foreach($categoria as $categorias)
                                    <option value="{{$categorias->id}}" @if(Request::old('id_categoria')==$categorias->id){{'selected'}}@endif
                                    @if(session("idNuevaCategoria"))
                                        {{session("idNuevaCategoria") == $categorias->id ? 'selected="selected"':''}}
                                        @endif>{{$categorias->name}}</option>
                                @endforeach
                            </select>
                            @error('id_categoria')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                        @enderror
                            <!---- Boton para crear un nuevo tipo de categoria- -->
                            <a class="btn btn-sm btn-outline-success"
                               data-toggle="modal"
                               data-target="#modalNuevaCategoria">
                                <i class="fas fa-plus" style="color: green"></i>
                            </a>
                        </div>

                        <div class="form-group">
                            <label for="empresa">Seleccione la empresa</label>
                            <br>
                            <select name="id_empresa"
                                    required="required"
                                    style="width: 85%"
                                    class="empresa form-control @error('id_empresa') is-invalid @enderror" id="empresa">
                                <option disabled selected value="s">Seleccione</option>
                                @foreach($empresas as $empresa)
                                    <option value="{{$empresa->id}}" @if(Request::old('id_empresa')==$empresa->id){{'selected'}}@endif
                                    @if(session("idEmpresa"))
                                        {{session("idEmpresa")==$empresa->id ? 'selected="selected"':''}}
                                        @endif>{{$empresa->name}}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="disponible">Seleccione si esta disponible
                            </label>
                            <br>
                            <select name="disponible"
                                    required="required"
                                    style="width: 85%"
                                    class="disponible form-control @error('disponible') is-invalid @enderror" id="disponible">
                                <option disabled selected value="s">Seleccione</option>
                                <option value="1"@if(Request::old('disponible')==1){{'selected'}}@endif>Si </option>
                                <option value="0"@if(Request::old('disponible')==0){{'selected'}}@endif>No </option>
                            </select>
                            <!---- Boton para crear un nuevo tipo de categoria- -->
                        </div>

                        <div class="form-group">
                            <label for="id_marca">Seleccione la marca</label>
                            <br>
                            <select name="id_marca"
                                    style="width: 85%" required="required"
                                    class="marca form-control @error('id_marca') is-invalid @enderror" id="marca">
                                <option disabled selected value="s">Seleccione</option>
                                @foreach($marca as $marcas)
                                    <option value="{{$marcas->id}}" @if(Request::old('id_marca')==$marcas->id){{'selected'}}@endif
                                    @if(session("idMarca"))
                                        {{session("idMarca")==$marcas->id ? 'selected="selected"':''}}
                                        @endif>{{$marcas->name}}
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
                        <button type="submit" id="nuevoP" class="btn btn-success">Crear</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                    </div>
                </form>

            </div>
        </div>
    </div>

    <!-----------------------------MODAL EDITAR PRODUCTO------------------------------->
    <div class="modal fade" id="modalEditarProducto" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header" style="background: #2a2a35">
                    <h5 class="modal-title" style="color: white"><span class="fas fa-plus"></span> Editar Producto
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true" style="color: white">&times;</span>
                    </button>
                </div>
                <form id="editarP" method="POST" action="{{route("editarProducto")}}" enctype="multipart/form-data">
                    @method("PUT")

                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="nombreNuevoProducto">Nombre Producto</label>
                            <input  class="form-control @error('name') is-invalid @enderror"
                                    name="name" id="nombreEditarProducto" maxlength="100" value="{{old('name')}}">
                            @error('name')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="descripcionNuevoProducto">Descripción de nuevo Producto (Opcional):</label>
                            <textarea class="form-control @error('description') is-invalid @enderror"
                                      name="description"
                                      id="descripcionEditarProducto"
                                      maxlength="192"
                            >{{Request::old('description')}}</textarea>
                            @error('description')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="precioUnitarioProducto">Precio Unitario</label>
                            <input required="required" class="form-control @error('unit_price') is-invalid @enderror"
                                   name="unit_price" id="precioUnitarioProducto"
                                   maxlength="8" type="number">
                            @error('unit_price')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="precioLoteProducto">Precio Lote</label>
                            <input required class="form-control @error('lote_price') is-invalid @enderror"
                                   name="lote_price" id="precioLoteProducto" maxlength="8" type="number">
                            @error('lote_price')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="tipoEditarCategoria">Seleccione la Categoria:
                            </label>
                            <br>
                            <select name="id_categoria"
                                    required="required"
                                    style="width: 85%"
                                    class="select2TipoCategoria form-control @error('id_categoria') is-invalid @enderror"
                                    id="tipoEditarCategoria" >
                                <option disabled selected value="">Seleccione</option>
                                @foreach($categoria as $categorias)
                                    <option value="{{$categorias->id}}">{{$categorias->name}}</option>
                                @endforeach
                            </select>
                            <!---- Boton para crear un nuevo tipo de categoria- -->
                            <a class="btn btn-sm btn-outline-success"
                               data-toggle="modal"
                               data-target="#modalNuevaCategoria">
                                <i class="fas fa-plus" style="color: green"></i>
                            </a>
                            @error('id_categoria')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="empresa">Seleccione la empresa</label>
                            <br>
                            <select name="id_empresa"
                                    required
                                    style="width: 85%"
                                    class="empresa2 form-control @error('id_empresa') is-invalid @enderror"
                                    id="empresa" required="required">
                                <option disabled selected value="">Seleccione</option>
                                @foreach($empresas as $empresa)
                                    <option value="{{$empresa->id}}">{{$empresa->name}}
                                    </option>
                                @endforeach
                            </select>
                            @error('id_empresa')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="tipoNuevaCategoria">Seleccion si esta disponible
                            </label>
                            <br>
                            <select name="disponible"
                                    required
                                    style="width: 85%"
                                    style="width: 85%"
                                    class="disponible2 form-control @error('disponible') is-invalid @enderror"
                                    id="disponible">
                                <option disabled selected value="">Seleccione</option>
                                <option value="1">Si</option>
                                <option value="0">No</option>
                            </select>
                            @error('disponible')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="empresa">Seleccione la marca</label>
                            <br>
                            <select name="id_marca"
                                    style="width: 85%"
                                    class="select2TipoCategoria form-control @error('id_marca') is-invalid @enderror"
                                    id="marca" required="required">
                                <option disabled selected value="">Seleccione</option>
                                @foreach($marca as $marca)
                                    <option value="{{$marca->id}}">{{$marca->name}}
                                    </option>
                                @endforeach
                            </select>
                            @error('id_marca')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
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
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input id="id_producto" name="id" type="hidden" >
                        <button type="submit" class="btn btn-success" id="id_producto" onclick="f()">Editar</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                    </div>
                </form>

            </div>
        </div>
    </div>

    <!------------------MODAL VER PRODUCTO-------------------------------->
    <div class="modal fade" id="modalVerProducto" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header" style="background: #2a2a35">
                    <h5 class="modal-title" style="color: white"><span class="fas fa-plus"></span> Detalle del Producto
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true" style="color: white">&times;</span>
                    </button>
                </div>
                    @include('Alerts.errors')

                    @csrf
                    <div class="modal-body row" >

                        <div class="col-sm-5">
                            <div class="image-border">
                                <img id="imgVistaPreviaEditarCategoria"
                                     height="217" width="217"
                                     style="object-fit: contain"
                                     onerror="this.src='/images/noimage.jpg'">
                            </div>
                            <b><label for="nombreNuevoProducto" id="nombreNuevoProducto"></label></b>
                        </div>

                        <div class="col-sm-7 card">
                            <div class="form-group">
                                <label for="descripcionNuevoProducto"><strong>Descripción del Producto:</strong></label>
                                <textarea disabled class="form-control transparent-input @error('description') is-invalid @enderror"
                                          name="description" id="descripcionNuevaCategoria" style="width: 70%"
                                          maxlength="192"></textarea>
                            </div>

                            <div class="form-group row">
                                <div class="col-sm-6"><label for="precioUnitarioProducto"><strong>Precio Unitario: </strong></label></div>
                                <div class="col-md-2"><label for="precioUnitarioProducto" id="precioUnitarioProducto"></label></div>
                            </div>

                            <div class="form-group row">
                                <div class="col-sm-6"><label for="precioLoteProducto"><strong>Precio Lote:</strong></label></div>
                                <div class="col-sm-2"><label for="precioLoteProducto" id="precioLoteProducto"></label></div>
                            </div>

                            <div class="form-group row">
                                <div class="col-sm-6"><label for="tipoNuevaCategoria"><strong>Categoria:</strong></label></div>
                                <div class="col-sm-2"><label for="tipoNuevaCategoria" id="tipoNuevaCategoria"></label></div>
                            </div>

                            <div class="form-group row">
                                <div class="col-sm-6"><label for="empresa"><strong>Empresa:</strong></label></div>
                                <div class="col-sm-4"><label for="empresa" id="empresa"></label></div>
                            </div>

                            <div class="form-group row">
                                <div class="col-sm-6"><label for="disponible"><strong>Disponibilidad:</strong></label></div>
                                <div class="col-sm-2"><label for="disponible" id="disponible"></label></div>
                            </div>

                            <div class="form-group row">
                                <div class="col-sm-6"><label for="marca"><strong>Marca:</strong></label></div>
                                <div class="col-sm-2"><label for="marca" id="marca"></label></div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button data-dismiss="modal" class="btn btn-success">Aceptar</button>
                    </div>
            </div>
        </div>
    </div>


    <!------------------MODAL BORRAR PRODUCTO---------------------------->
    <div class="modal fade" id="modalBorrarProducto" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <form method="post" action="{{route("borrarProducto")}}" enctype="multipart/form-data">
                    @method("DELETE")
                    @csrf
                    <div class="modal-header" style="background: #2a2a35">
                        <h5 class="modal-title" style="color: white"><span class="fas fa-trash"></span> Borrar Producto
                        </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span style="color: white" aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>¿Estás seguro que deseas borrar este producto con nombre <label
                                id="nombreProducto"></label>?</p>

                    </div>
                    <div class="modal-footer">
                        <input id="id_producto" name="id" type="hidden" value="">
                        <button type="submit" class="btn btn-danger">Borrar</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    </div>
                </form>
            </div>

        </div>
    </div>

    <!-------------------MODAL NUEVO CATEGORIA------------------------------>
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
                                    class="empresa2 form-control" id="tipoNuevaCategoria">
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
                        <button type="submit" class="btn btn-success" >Crear</button>
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
        .image-border{
            border: black 1px solid;
            padding: 3px;
            justify-content: center;
            align-items: center;
        }
        .transparent-input{
            background-color:rgba(0,0,0,0) !important;
            border:none !important;
            padding-left: 5px;
        }
        .modal-lg {
            max-width: 45% !important;
        }

    </style>



@endsection
