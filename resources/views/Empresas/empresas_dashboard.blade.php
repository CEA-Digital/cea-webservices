@extends("layouts.main")
@section("content")
    <div class="container-fluid">
        <h1 class="mt-4">Empresas Asociadas
            <div class="btn-group" role="group">
                <a class="btn btn-sm btn-success"
                        id="botonAbrirModalNuevaCategoria"
                href="{{route("nuevaEmpresaForm")}}">
                    <span class="fas fa-plus"></span> Nueva
                </a>
            </div>
        </h1>
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
                    <!--- METODO PARA BUSCAR empresas EN EL INDEX DE empresas -->
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
        @endif

        @if($empresas->count()>0)
            <div class="row">
                @foreach($empresas as $empresa)
                    <div class="col-lg-4 col-md-3 col-sm-12 col-xs-12 mb-2">
                        <div class="card" style="width: 18rem;">
                            <img class="card-img-top" src="..." alt="Card image cap">
                            <div class="card-body">
                                <h5 class="card-title">{{$empresa->name}}</h5>
                                <p class="card-text">
                                    <span class="fas fa-map-marker-alt"
                                          style="color: red"></span> {{$empresa->direccion}}
                                </p>
                                <a href="#" class="btn btn-primary">Go somewhere</a>
                            </div>
                        </div>
                    </div>

                @endforeach
            </div>
        @else
            <div class="alert alert-info  alert-dismissible" role="alert">
                <h4 class="alert-heading"><span class="fas fa-exclamation-triangle"></span> ¡Ups! Al parecer no hay
                    empresas ingresadas aún.</h4>
                <hr>
                <p class="mb-0">Pulsa el boton superior <span class="fas fa-plus"></span> para agregar una nueva empresa
                    o presiona <a href="#">aquí</a></p>
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

@endsection
