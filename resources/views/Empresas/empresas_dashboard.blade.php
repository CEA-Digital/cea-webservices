@extends("layouts.main")
@section("content")
    <div class="container-fluid">
        <h3 class="mt-4">Empresas Asociadas
            <div class="btn-group" role="group">
                <a class="btn btn-sm btn-success"
                   id="botonAbrirModalNuevaCategoria"
                   href="{{route("nuevaEmpresaForm")}}">
                    <span class="fas fa-plus"></span> Nueva
                </a>
            </div>
        </h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb" style="background: white">
                <li class="breadcrumb-item" aria-current="page"><a href="/">Inicio</a></li>
                <li class="breadcrumb-item active" aria-current="page">Empresas</li>
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

        @if($empresas->count()>0)
            <div class="pagination pagination-sm ">
                {{$empresas->links()}}
                <form action="{{route("buscarCategorias")}}"
                      enctype="multipart/form-data" method="GET"
                      class="d-none d-md-inline-block form-inline
                           ml-auto mr-0 mr-md-2 my-0 my-md-0 mb-md-2">
                    <!--- METODO PARA BUSCAR enuempresas EN EL INDEX DE empresas -->
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
                               href="{{route("empresas")}}">&times;</a>
                            <button class="btn btn-primary" type="submit"><i class="fas fa-search"></i></button>
                        </div>
                    </div>
                </form>
            </div>
        @endif

        @if($empresas->count()>0)
            <div class="row">
                @foreach($empresas as $empresa)
                    <div class="col-lg-3 col-md-4 col-sm-12 col-xs-12 mb-2">
                        <div class="card profile-card-3">
                            <div class="background-block">
                                <img src="/images/empresas/portadas/{{$empresa->portada_img_url}}"
                                     alt="profile-sample1"
                                     data-src_img="portadas/{{$empresa->portada_img_url}}"
                                     data-toggle="modal"
                                     onerror="this.src='/images/noimage.jpg'"
                                     data-target="#modalVistaPreviaImgEmpresa"
                                     class="background"/>
                            </div>
                            <div class="profile-thumb-block">
                                <img src="/images/empresas/profiles/{{$empresa->profile_img_url}}"
                                     data-src_img="profiles/{{$empresa->profile_img_url}}"
                                     data-toggle="modal"
                                     onerror="this.src='/images/noimage.jpg'"
                                     data-target="#modalVistaPreviaImgEmpresa"
                                     alt="profile-image" class="profile"/>
                            </div>
                            <div class="card-content">
                                <h4>{{$empresa->name}}<small>Plan Adquirido</small></h4>
                                <label title="{{$empresa->direccion}}" style="white-space:nowrap;height: 20px;
                                           width: 80%;
                                           overflow: hidden;text-overflow: ellipsis">
                                    <span class="fas fa-map-marker-alt"
                                          style="color: red"></span> {{$empresa->direccion}}</label>
                                <hr>
                                <a href="{{route("verEmpresa",["id"=>$empresa->id])}}" class="btn btn-primary"><span
                                        class="fas fa-eye"></span> Ver</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="pagination pagination-sm">
                {{$empresas->links()}}
            </div>
        @else
            <div class="alert alert-info  alert-dismissible" role="alert">
                <h4 class="alert-heading"><span class="fas fa-exclamation-triangle"></span> ¡Ups! Al parecer no hay
                    empresas ingresadas aún.</h4>
                <hr>
                <p class="mb-0">Pulsa el boton superior <span class="fas fa-plus"></span> para agregar una nueva empresa
                    o presiona <a href="{{route("nuevaEmpresaForm")}}">aquí</a></p>
            </div>
        @endif
    </div>
    <!-- Modal -->
    <div class="modal fade" id="modalCrearNuevaEmpresa" tabindex="-1" role="dialog"
         aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header" style="background: #2a2a35">
                    <h5 class="modal-title" style="color: white" id="exampleModalCenterTitle">
                        <span class="fas fa-plus"></span> Crea una nueva Empresa</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true" style="color: white">&times;</span>
                    </button>
                </div>
                <form>
                    <div class="modal-body">

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary">Save changes</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <style>

        /*Profile Card 3*/
        .profile-card-3 {
            font-family: 'Open Sans', Arial, sans-serif;
            position: relative;
            float: left;
            overflow: hidden;
            width: 100%;
            text-align: center;
            height: 400px;
            margin-bottom: 5px;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.19), 0 6px 6px rgba(0, 0, 0, 0.23);
            border: none;
        }

        .profile-card-3 .background-block {
            float: left;
            width: 100%;
            height: 200px;
            overflow: hidden;
        }

        .profile-card-3 .background-block .background {
            width: 100%;
            object-fit: contain;
            vertical-align: top;
            opacity: 1;
            -webkit-transform: scale(1.0);
            transform: scale(1.3);
        }

        .profile-card-3 .card-content {
            width: 100%;
            padding: 15px 25px;
            color: #232323;
            float: left;
            background: #efefef;
            height: 50%;
            border-radius: 0 0 5px 5px;
            position: relative;
            z-index: 999;
        }

        .profile-card-3 .card-content::before {
            content: '';
            background: #efefef;
            width: 120%;
            height: 100%;
            left: 11px;
            bottom: 51px;
            position: absolute;
            z-index: -1;
            transform: rotate(-13deg);
        }

        .profile-card-3 .profile {
            border-radius: 50%;
            position: absolute;
            bottom: 50%;
            height: 150px;
            left: 50%;
            object-fit: cover;
            max-width: 150px;
            opacity: 1;
            box-shadow: 3px 3px 20px rgba(0, 0, 0, 0.5);
            border: 2px solid rgba(255, 255, 255, 1);
            -webkit-transform: translate(-50%, 0%);
            transform: translate(-50%, 0%);
            z-index: 1000;
        }

        .profile-card-3 h4 {
            margin: 0 0 5px;
            font-weight: 600;
            font-size: 18px;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .profile-card-3 h4 small {
            display: block;
            font-size: 15px;
            margin-top: 10px;
            word-break: break-all;
        }

        .profile-card-3 i {
            display: inline-block;
            font-size: 16px;
            color: #232323;
            text-align: center;
            border: 1px solid #232323;
            width: 30px;
            height: 30px;
            line-height: 30px;
            border-radius: 50%;
            margin: 0 5px;
        }

        .profile-card-3 .icon-block {
            float: left;
            width: 100%;
            margin-top: 15px;
        }

        .profile-card-3 .icon-block a {
            text-decoration: none;
        }

        .profile-card-3 i:hover {
            background-color: #232323;
            color: #fff;
            text-decoration: none;
        }


    </style>
@endsection
