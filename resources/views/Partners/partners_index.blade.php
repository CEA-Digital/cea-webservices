@extends("layouts.main")
@section("content")
    <div class="container-fluid">
        <h1 class="mt-4">Partners
            <div class="btn-group" role="group">
                <button class="btn btn-sm btn-success"
                        id="botonAbrirModalNuevoPartners"
                        data-toggle="modal" data-target="#modalNuevoPartners">
                    <span class="fas fa-plus"></span> Nuevo
                </button>

            </div>
        </h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb" style="background: transparent">
                <li class="breadcrumb-item" aria-current="page"><a href="/">Inicio</a></li>
                <li class="breadcrumb-item active" aria-current="page">Partners</li>
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



        @if(session("errores"))


            <input id="idPartners" name="idPartners" value="{{session("idPartners")}}" type="hidden" >

            <script>
                var idPartners=document.getElementById("idPartners").value;

                document.onreadystatechange = function () {
                    if (document.readyState) {
                        document.getElementById("botonAbrirModalEditarPartners"+idPartners).click();
                    }
                }
            </script>
        @else

            @if ($errors->any())
                <script>
                    document.onreadystatechange = function () {
                        if (document.readyState) {
                            document.getElementById("botonAbrirModalNuevoPartners").click();
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
                           href="{{route("partners.index")}}">&times;</a>
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



                <th><span class="fas fa-info-circle"></span></th>
            </tr>
            </thead>
            <tbody>
            @if(!$partners)
                <tr>
                    <td colspan="4" style="align-items: center">No hay servicios</td>
                </tr>
            @endif
            @foreach($partners as $partners)
                <tr>
                    <td>{{$noPagina++}}</td>
                    <td>
                        <button id="callModalVistaPreviaPartners{{$partners->id}}"
                                data-src_img="{{$partners->servicio_img_id}}"
                                @if($partners->ruta_img)
                                data-toggle="modal"
                                data-target="#modalVistaPreviaPartners"
                                @endif
                                style="opacity: 0"></button>
                        <img  src="storage/images/partners/{{$partners->ruta_img}}"
                              onclick="$('#callModalVistaPreviaPartners{{$partners->id}}').click()"
                              width="150px" height="150px"  style="height:150px; max-height: 300px;object-fit: contain"
                              onerror="this.src='/images/noimage.jpg'"  alt="profile-sample1"> </td>

                    <td>{{$partners->name}}</td>
                    @if(!$partners->descripcion)
                        <td>N/A</td>
                    @else
                        <td>{{$partners->descripcion}}</td>
                    @endif

                    <td>

                        <button class="btn btn-sm btn-success"
                                data-toggle="modal"
                                id="botonAbrirModalEditarPartners{{$partners->id}}"
                                data-target="#modalEditarPartners"
                                data-nombre="{{$partners->name}}"
                                data-img_url="{{$partners->ruta_img}}"

                                data-id="{{$partners->id}}"
                                data-descripcion="{{$partners->descripcion}}"
                                title="Editar">
                            <span class="fas fa-pencil-alt"></span>
                        </button>
                        <button class="btn btn-sm btn-danger"
                                title="Borrar"
                                data-toggle="modal"
                                data-id_servicio="{{$partners->id}}"
                                data-nombre="{{$partners->name}}"
                                data-target="#modalBorrarPartners">
                            <span class="fas fa-trash"></span>
                        </button>
                    </td>
                </tr>
            @endforeach

            </tbody>
        </table>



    </div>


    <div class="modal fade" id="modalNuevoPartners" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header" style="background: #2a2a35">
                    <h5 class="modal-title" style="color: white"><span class="fas fa-plus"></span> Agregar Partners
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true" style="color: white">&times;</span>
                    </button>
                </div>
                <form method="POST" action="{{route('partners.store')}}" enctype="multipart/form-data">


                    @if(session("errores"))

                    @else

                        @include('Alerts.errors')

                    @endif



                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="nombreNuevoServicio">Nombre del Partners</label>
                            <input  name="name" id="nombreNuevoPartners" maxlength="100" value="{{ old('name') }}" class="form-control @error('name') is-invalid @enderror">


                        </div>


                         <div class="form-group">
                            <label for="descripcionNuevoServicio">Descripción del partners (Opcional):</label>
                            <textarea class="form-control"
                                      name="descripcion"
                                      id="descripcionNuevaPartners"
                                      maxlength="192">{{Request::old('descripcion')}}</textarea>
                        </div>

                        <label for="imagenPartners">Seleccione una imagen (opcional): </label>
                        <div class="input-group image-preview">

                            <input type="text" name="ruta_img" class="form-control image-preview-filename @error('ruta_img') is-invalid @enderror"
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
                                           name="ruta_img"/>
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

    <div class="modal fade" id="modalEditarPartners" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header" style="background: #2a2a35">
                    <h5 class="modal-title" style="color: white"><span class="fas fa-pencil-alt"></span> Editar
                        partners</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span style="color: white" aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="post" action="{{route("editarPartners")}}" enctype="multipart/form-data">
                    @method("PUT")
                    @csrf


                    @if(session("errores"))
                        @include('Alerts.errors')

                    @else

                    @endif
                    <div class="modal-body">
                        <div class="form-group">
                            <input id="nombreEditarPartners" value="{{ old('name') }}" placeholder="Nombre de servicio" name="name" class="form-control" max="100"  >
                        </div>









                        <div class="form-group">
                            <label for="descripcionNuevoPartners">Descripción de partners (Opcional):</label>
                            <textarea class="form-control"
                                      name="descripcion"
                                      id="descripcionEditarPartners"
                                      maxlength="192"></textarea>
                        </div>
                        <img id="imgVistaPreviaEditarPartners"
                             height="150px" width="150px"
                             style="object-fit: contain"
                             onerror="this.src='/images/noimage.jpg'">
                        <label for="imagenPartners">Seleccione una imagen (opcional): </label>
                        <div class="input-group image-preview">
                            <input type="text" name="ruta_img" class="form-control image-preview-filename"
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
                                           name="ruta_img"/>
                                    <!-- rename it -->
                                </div>
                            </span>
                        </div><!-- /input-group image-preview [TO HERE]-->

                    </div>
                    <div class="modal-footer">
                        <input id="idPartners" name="id" type="hidden" >
                        <button type="submit" class="btn btn-success">Editar</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <div class="modal fade" id="modalVistaPreviaPartners" tabindex="-1" role="dialog">
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
                         style="display:block; width: 47%; margin-left: auto; margin-right: auto;"
                         onerror="this.src='/images/noimage.jpg'"
                    >
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modalBorrarPartners" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <form method="post" action="{{route("destroyPartners")}}" enctype="multipart/form-data">
                    @method("DELETE")
                    @csrf
                    <div class="modal-header" style="background: #2a2a35">
                        <h5 class="modal-title" style="color: white"><span class="fas fa-trash"></span> Borrar Partners
                        </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span style="color: white" aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>¿Estás seguro que deseas borrar este Partners con nombre ' <label
                                id="nombrePartnes"></label>'?</p>

                    </div>
                    <div class="modal-footer">
                        <input id="idPartners" name="id" type="hidden" value="">
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


    <script>
        $(document).ready(function() {
            const genderOldValue = '{{ old('id_empresa') }}';

            if(genderOldValue !== '') {
                $('#id_empresa').val(genderOldValue);
            }
        });
    </script>


@endsection
