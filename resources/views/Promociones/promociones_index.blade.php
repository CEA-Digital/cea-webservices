@extends("layouts.main")
@section("content")
    <div class="container-fluid">
        <h1 class="mt-4">Promociones


            <div class="btn-group" role="group">
                <button class="btn btn-sm btn-success"
                        id="botonAbrirModalNuevaPromocion"
                        data-toggle="modal" data-target="#modalNuevaPromocion">
                    <span class="fas fa-plus"></span> Nuevo
                </button>

                <div class="btn-group float-right  margin-bottom">
                    <button type="button" class="btn btn-success  dropdown-toggle  "
                            data-toggle="dropdown">
                        Servicios<span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu" role="menu">


                        <a href="{{route('promociones.index')}}" class="dropdown-item">
                            Productos
                        </a>
                    </ul>
                </div>



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
                <span class="fas fa-check"></span> {{session("exito")}}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif



        @if(session("errores"))


            <input id="idPromocion" name="idPromocion" value="{{session("idPromocion")}}" type="hidden" >

            <script>
                var idPromocion=document.getElementById("idPromocion").value;

                document.onreadystatechange = function () {
                    if (document.readyState) {
                        document.getElementById("botonAbrirModalEditarPromocion"+idPromocion).click();
                    }
                }
            </script>
        @else

            @if ($errors->any())
                <script>
                    document.onreadystatechange = function () {
                        if (document.readyState) {
                            document.getElementById("botonAbrirModalNuevaPromocion").click();
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
                           href="{{route("promociones.index")}}">&times;</a>
                        <button class="btn btn-primary" type="submit"><i class="fas fa-search"></i></button>
                    </div>

                </div>
            </form>


        </div>

        <div class="container col-md-12 ">


            <div class="row d-flex align-items-stretch" >


                @foreach($promociones as $promocion)

                     <div class="flip-card">
                        <div class="flip-card-inner">

                            <div class="flip-card-front">

                                <div   >
                                <h6 class="profile-username text-center">{{$promocion->name}} </h6>
                                <h6> @if($promocion->porcentaje_descuento)
                                        {{$promocion->porcentaje_descuento}}% de descuento @else

                                     <h6>Sin descuento</h6>
                                    @endif</h6>
                            </div>

                                <button id="callModalVistaPreviaPromocion{{$promocion->id}}"
                                        data-src_img="{{$promocion->servicio_img_id}}"
                                        @if($promocion->servicio_img_id)
                                        data-toggle="modal"
                                        data-target="#modalVistaPreviaPromocion"
                                        @endif
                                        style="opacity: 0"></button>

                                <img class="card-img-top" src="/storage/images/servicio/{{$promocion->servicio_img_id}}"
                                     onclick="$('#callModalVistaPreviaPromocion{{$promocion->servicio_img_id}}').click()"
                                     width="150px" height="150px"    style="height:200px; max-height: 500px;object-fit: contain"
                                     onerror="this.src='/images/noimage.jpg'"   alt="profile-sample1">


                                <div style=" color:#ffffff">
                                <ul class="list-group list-group-unbordered mb-2"  >
                                    <li class="list-group-item "style="background: #4e555b;">
                                <h6>{{$promocion->empresa_name}}</h6>
                                <div style=" font-size: 15px;">{{$promocion->servicio_name}} </div>
                                        <div style=" font-size: 15px;">{{$promocion->descripcion}} </div>
                                        <div style=" font-size: 15px;"> {{$promocion->fecha_inicio}} a  {{$promocion->fecha_fin}}</div>





                                </ul>
                                </div>

                            </div>
                            <div class="flip-card-back">
                                <h4>Detalle</h4>
                                <ul class="list-group list-group-unbordered mb-2">
                                    <li class="list-group-item " style="background: #4e555b;">

                                        @if($promocion->porcentaje_descuento != '0')
                                        <a style="text-decoration: line-through;" >{{$promocion->servicio_precio}} Lps</a>
                                        <a  >{{$promocion->precio_menos_descuento}} Lps</a>
                                    @else
                                            <a  >{{$promocion->servicio_precio}} Lps</a>
                                    @endif

                                    <li class="list-group-item" style="background: #4e555b;" >
                                        <a >{{$promocion->servicio_condiciones}}</a>
                                    </li>

                                    @if($promocion->servicio_descripcion)
                                    <li class="list-group-item"style="background: #4e555b;">
                                        <a>{{$promocion->servicio_descripcion}}</a>
                                    </li>
                                    @endif
                                    <li class="list-group-item"style="background: #4e555b;">
                                        <a >{{$promocion->categoria_name}}</a>
                                    </li>
                                </ul>

                            </div>
                        </div>

                         <div>
                          <button class="btn btn-sm btn-success"
                                 data-toggle="modal"
                                 id="botonAbrirModalEditarPromocion{{$promocion->id}}"
                                 data-target="#modalEditarImagen"
                                 data-ruta="{{$promocion->servicio_img_id}}"
                                 data-id="{{$promocion->id}}"
                                 title="Editar">
                             <span class="fas fa-pencil-alt"></span>
                         </button>
                         <button class="btn btn-sm btn-danger"
                                 title="Borrar"
                                 data-toggle="modal"
                                 data-id="{{$promocion->id}}"
                                 data-target="#modalBorrarPromocion">

                             <span class="fas fa-trash"></span>
                         </button>
                         </div>
                    </div>




                @endforeach
        </div>

    </div>





    <div class="modal fade" id="modalNuevaPromocion" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header" style="background: #2a2a35">
                    <h5 class="modal-title" style="color: white"><span class="fas fa-plus"></span> Agregar servicio de promoción
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true" style="color: white">&times;</span>
                    </button>
                </div>
                <form method="POST" action="{{route('promociones.store')}}" enctype="multipart/form-data">


                    @if(session("errores"))

                    @else

                        @include('Alerts.errors')

                    @endif



                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="nombreNuevaPromocion">Nombre de la promoción</label>
                            <input  name="name" id="nombreNuevaPromocion" maxlength="100" value="{{ old('name') }}" class="form-control @error('name') is-invalid @enderror">


                        </div>

                        <div class="form-group">
                            <label for="PromocionNuevoServicio">Seleccione el servicio
                                <!---- Boton para crear un nuevo tipo de categoria- -->
                            </label>
                            <br>
                            <select name="id_servicio"

                                    style="width: 85%"
                                    class="select2TipoCategoria form-control @error('id_servicio') is-invalid @enderror"  id="id_servicio">
                                <option disabled selected value="">Seleccione</option>
                                @foreach($servicios as $servicio)

                                    <option value="{{$servicio->id}}"@if (old('id_servicio') == $servicio->id) {{ 'selected' }} @endif>{{$servicio->name}} , {{$servicio->precio}} Lps, {{$servicio->name_empresa}}</option>

                                @endforeach
                            </select>


                        </div>



                        <div class="form-group">
                            <label for="descripcionNuevaPromocion">Descripción de la promoción (Opcional):</label>
                            <textarea class="form-control"
                                      name="descripcion"
                                      id="descripcionNuevaPartners"
                                      maxlength="192">{{Request::old('descripcion')}}</textarea>
                        </div>

                        <div class="form-group">
                            <label for="porcentajeDescPromocion">Porcentaje de descuento (opcional)</label>
                            <input type="number"  class="form-control @error('porcentaje_descuento') is-invalid @enderror" value="{{ old('porcentaje_descuento') }}" name="porcentaje_descuento" id="porcentaje_descuento"  max="100" maxlength="3"  pattern="[0-9]+">

                        </div>

                        <div class="form-group">
                            <label for="fecha_inicio">Fecha de inicio </label>
                            <input type="date" class="form-control @error('fecha_inicio') is-invalid @enderror" name="fecha_inicio" value="{{old('fecha_inicio')}}" id="fecha_inicio"    >
                            @error('fecha_inicio')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>

                                    </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="fecha_fin">Fecha fin </label>
                            <input type="date" class="form-control @error('fecha_fin') is-invalid @enderror" name="fecha_fin" value="{{old('fecha_fin')}}" id="fecha_fin"    >
                            @error('fecha_fin')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>

                                    </span>
                            @enderror
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
                <form method="post" action="{{route("promociones.store")}}" enctype="multipart/form-data">
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
                        <p>¿Estás seguro que deseas borrar Partners ' <label
                                id="nombrePartners"></label>'?</p>

                    </div>
                    <div class="modal-footer">
                        <input id="idPartners" name="id" type="hidden" value="">
                        <input id="nombre_hidden" name="name" type="hidden" value="">

                        <button type="submit" class="btn btn-danger">Borrar</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    </div>
                </form>
            </div>

        </div>
    </div>





    <style>



        body {
            font-family: Arial, Helvetica, sans-serif;
        }

        .flip-card {
             width: 225px;
            text-align: center;
         margin-right: 20px;
            height: 440px;
            perspective: 1000px;
        }

        .flip-card-inner {
            position: relative;
            width: 100%;
            height: 400px;
             transition: transform 0.6s;
            transform-style: preserve-3d;
            box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2);
        }

        .flip-card:hover .flip-card-inner {
            transform: rotateY(180deg);
        }

        .flip-card-front, .flip-card-back {
            position: absolute;
            width: 100%;
            height: 100%;
            -webkit-backface-visibility: hidden;
            backface-visibility: hidden;
        }


        .flip-card-front {
             color: black;
        }

        .flip-card-back {
            background-color: #4e555b;
            color: white;
            transform: rotateY(180deg);
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
