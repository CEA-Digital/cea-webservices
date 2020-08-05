@extends("layouts.main")
@section("content")
    <div class="container-fluid">
        <h3 class="mt-4"><span class="fas fa-map-marked-alt"></span> Ubicaciones Empresa '{{$empresa->name}}'</h3>

        <input type="hidden" id="saved_markers" value="{{$ubicaciones}}">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb" style="background: white">
                <li class="breadcrumb-item" aria-current="page"><a href="/">Inicio</a></li>
                <li class="breadcrumb-item" aria-current="page"><a href="{{route("empresas")}}">Empresas</a></li>
                <li class="breadcrumb-item" aria-current="page"><a href="{{route("verEmpresa",["id"=> $empresa->id])}}">{{$empresa->name}}</a></li>
                <li class="breadcrumb-item active" aria-current="page">Ubicaciones</li>

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

        @include("Alerts.errors")
        <div class="card card-body">
            <div id="wizard-empresa">
                <h3>
                    <div class="media">
                        <div class="bd-wizard-step-icon"><i class="fas  fa-map-marker-alt"></i></div>
                        <div class="media-body">
                            <div class="bd-wizard-step-title"> Ubicaciones</div>
                            <div class="bd-wizard-step-subtitle">Las ubicaciones son tomadas con longitud y latitud
                            </div>
                        </div>
                    </div>
                </h3>
                <section>
                    <button class="btn btn-sm btn-success pull-righ"
                            id="nuevaUbicacionBtn"
                            title="Agregar ubicación seleccionada"
                            disabled
                            data-toggle="modal" data-target="#modalNuevaUbicacion">
                        <span class="fas fa-map-marker-alt"></span>
                        Agregar ubicación
                    </button>
                    <a class="btn btn-outline-danger btn-sm" href="{{route("verEmpresa",["id"=>$empresa->id])}}" ><span class="fas fa-times"></span> Finalizar</a>
                    <input type="hidden" name="latitud" id="latitud" placeholder="latitud">
                    <input type="hidden" name="longitud" id="longitud" placeholder="Longitud">
                    <hr>

                    <div class="form-row">
                        <div class="col-md-7" id="map" style='width: 100%; height: 550px;'></div>
                        <div class="col-md-5">
                            <div class="list-group">
                                <button type="button" class="list-group-item list-group-item-action active disabled">
                                    <span class="fas fa-map-marked-alt"></span> Ubicaciones Guardadas
                                </button>
                                @if($ubicaciones->count()>0)
                                    @foreach($ubicaciones as $ubicacion)
                                        <button type="button"
                                                class="list-group-item list-group-item-action">
                                            <div><span class="fas fa-map-marker-alt"></span>
                                                <strong>{{$ubicacion->descripcion}}
                                                </strong>
                                                <a class="btn btn-sm btn-outline-danger"
                                                   data-toggle="modal"
                                                   title="Eliminar Ubicación"
                                                   data-target="#modalEliminarUbicacion"
                                                   style="float: right"
                                                   data-id="{{$ubicacion->id}}"
                                                   href="javascript:void(0)"><span class="fas fa-trash"></span></a>
                                                <a class="btn btn-sm btn-outline-success"
                                                   style="float: right"
                                                   title="Editar Ubicación"
                                                   href="javascript:void(0)">
                                                    <span class="fas fa-pencil-alt"></span>
                                                </a>

                                            </div>
                                            <hr>
                                            <span class="fas fa-location-arrow">
                                            </span> [{{$ubicacion->longitud}}, {{$ubicacion->latitud}}]
                                        </button>
                                    @endforeach
                                @else
                                    <button type="button" class="list-group-item list-group-item-action" disabled>
                                        <span class="fas fa-exclamation-triangle"></span> No hay ubicaciones registradas
                                        aún
                                    </button>
                                @endif

                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
        <div class="modal fade" id="modalEliminarUbicacion" tabindex="-1" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title"><span class="fas fa-trash"></span> Borrar Ubicación</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form method="post" action="{{route("eliminarUbicacion")}}">
                        @method("DELETE")
                        @csrf
                        <div class="modal-body">
                            <p>¿Estás seguro que deseas borrar esta ubicación?</p>
                        </div>
                        <div class="modal-footer">

                            <input name="id_empresa" value="{{$idEmpresa}}" type="hidden">
                            <input name="id" id="id_ubicacion" type="hidden">
                            <button type="submit" class="btn btn-danger"><span class="fas fa-trash"></span> Eliminar
                            </button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>

                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="modal fade" id="modalNuevaUbicacion" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title"><span style="color: red" class="fas fa-map-marker"></span> Agregar nueva
                            ubicación</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="{{route("nuevaUbicacion")}}"
                          method="POST"
                          enctype="multipart/form-data">
                        @method("post")
                        @csrf
                        <div class="modal-body">

                            <div class="form-group">
                                <label for="descripcion"><strong style="color: red">*</strong>
                                    Ingrese la descripción de la ubicación</label>
                                <div class="input-group">
                                    <input name="descripcion" required id="descripcion" class="form-control">
                                </div>
                            </div>

                        </div>
                        <div class="modal-footer">
                            <input value="{{$idEmpresa}}" type="hidden" name="id_empresa">
                            <input name="latitud" type="hidden" id="latitud_modal" placeholder="latitud">
                            <input name="longitud" type="hidden" id="longitud_modal" placeholder="Longitud">
                            <button type="submit" class="btn btn-success">Guardar</button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
