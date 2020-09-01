@extends("layouts.main")
@section("content")
    <div class="container-fluid">
        <h1 class="mt-4">Marcas
            <div class="btn-group" role="group">
                <button class="btn btn-sm btn-success"
                        id="botonAbrirModalNuevaMarca"
                        data-toggle="modal" data-target="#modalCrearMarca">
                    <span class="fas fa-plus"></span> Nueva
                </button>
            </div>

        </h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item" aria-current="page" ><a href="/">Inicio</a></li>
                <li class="breadcrumb-item active" aria-current="page">Marcas</li>
            </ol>
            <div class="pagination pagination-sm">

                <form  class="d-none d-md-inline-block form-inline
                           ml-auto mr-0 mr-md-2 my-0 my-md-0 mb-md-2">
                    <div class="input-group" style="width: 300px">
                        <input class="form-control" name="search" type="search" placeholder="Search"
                               aria-label="Search">
                        <div class="input-group-append">
                            <a id="borrarBusqueda" class="btn btn-danger hideClearSearch" style="color: white"
                               href="{{route("marcas")}}">&times;</a>
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

        <!--------------------------Reabrir modal si hay errror---------------------------->
        @if(session("errores"))
            <input id="id_M" name="id_M" value="{{session("id_M")}}" type="hidden" >

            <script>
                var id=document.getElementById("id_M").value;
                document.onreadystatechange = function () {
                    if (document.readyState) {
                        document.getElementById("editar_M"+id).click();
                    }
                }
            </script>
            @else
            @if($errors->any())
            <script>
                document.onreadystatechange = function () {
                    if (document.readyState) {
                        document.getElementById("botonAbrirModalNuevaMarca").click();
                    }
                }
            </script>
            @endif
    @endif

        <table class="table">
            <thead class="thead-dark">
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Descripción</th>
                <th><span class="fas fa-info-circle"></span></th>
            </tr>
            </thead>
            <tbody>
            @if(!$marca)
                <tr>
                    <td colspan="4" style="align-items: center">No hay Marcas registradas</td>
                </tr>
            @endif
            @foreach($marca as $marca)
                <tr>
                    <td>{{$noPagina++}}</td>
                    <td>{{$marca->name}}</td>
                    @if(!$marca->description)
                    <td>N/A</td>
                    @endif
                    <td>
                        <button class="btn btn-sm btn-success"
                                title="Editar"
                                id="editar_M{{$marca->id}}"
                                data-toggle="modal"
                                data-target="#modalEditarMarca"
                                data-id="{{$marca->id}}"
                                data-name="{{$marca->name}}"
                                data-description="{{$marca->description}}">
                            <span class="fas fa-pencil-alt"></span>
                        </button>
                        <button class="btn btn-sm btn-danger"
                                title="Borrar"
                                data-toggle="modal"
                                data-target="#modalBorrarMarca"
                                data-id="{{$marca->id}}"
                                data-name="{{$marca->name}}">
                            <span class="fas fa-trash"></span>
                        </button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <!-----------------MODAL CREAR MARCA--------------------------------------->
        <div class="modal fade" id="modalCrearMarca" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header" style="background: #2a2a35">
                        <h5 class="modal-title" style="color: white"><span class="fas fa-pencil-alt"></span> Agregar Marca
                        </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span style="color: white" aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form method="post" action="{{route("nuevaMarca")}}" enctype="multipart/form-data">
                        @csrf
                    <div class="modal-body" style="object-fit: fill">
                        <div class="form-group">
                            <label for="name">Nombre Marca:</label>
                            <input type="text"
                                   class="form-control @error('name') is-invalid @enderror" name="name" id="name" maxlength="30"
                                   value="{{old('name')}}" required>
                            @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="descripcionNuevaMarca" >Descripcion (opcional):</label>
                            <textarea class="form-control @error('description') is-invalid @enderror"
                                      name="description"
                                      id="descripcionNuevaMarca"
                                      maxlength="192"
                            >{{Request::old('description')}}</textarea>
                            @error('description')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success" >Crear</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>

        <!-----------------------------MODA EDITAR MARCA------------------------------------>
        <div class="modal fade" id="modalEditarMarca" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header" style="background: #2a2a35">
                        <h5 class="modal-title" style="color: white"><span class="fas fa-pencil-alt"></span> Editar Marca
                        </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span style="color: white" aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form method="post" action="{{route("editarMarca")}}" enctype="multipart/form-data">
                        @method('PUT');
                        @csrf
                        <div class="modal-body" style="object-fit: fill">
                            <div class="form-group">
                                <label for="name">Nombre Marca:</label>
                                <input required="required" type="text"
                                       class="form-control @error('name') is-invalid @enderror" name="name" id="name" maxlength="30"
                                       value="{{old('name')}}"">
                                @error('name')
                                <span class="invalid-feedback" role="alert">
                                <strong>{{ $message}}</strong>
                            </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="descripcionNuevaMarca" >Descripcion (opcional):</label>
                                <textarea class="form-control @error('description') is-invalid @enderror"
                                          name="description"
                                          id="descripcionNuevaMarca"
                                          maxlength="192"
                                >{{Request::old('description')}}</textarea>
                                @error('description')
                                <span class="invalid-feedback" role="alert">
                                <strong>{{ $message}}</strong>
                            </span>
                                @enderror
                            </div>
                        </div>
                        <div class="modal-footer">
                            <input type="hidden" name="id" id="id_marca">
                            <button type="submit" class="btn btn-success" >Editar</button>
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>


        <!--------------------------MODAL BORRAR MARCA----------------------------------->
        <div class="modal fade" id="modalBorrarMarca" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-dialog-scrollable" role="document">
                <div class="modal-content">
                    <form method="post" action="{{route("borrarMarca")}}" enctype="multipart/form-data">
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
                            <p>¿Estás seguro que deseas borrar la marca <label
                                    id="nombreMarca"></label>? </p>
                            <p>¡¡¡Los productos que tienen registrada esta marca serán borrados!!!</p>
                        </div>
                        <div class="modal-footer">
                            <input id="id" name="id" type="hidden" value="">
                            <button type="submit" class="btn btn-danger">Borrar</button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>


    </div>
    @endsection
