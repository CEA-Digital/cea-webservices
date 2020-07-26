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
    </div>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb" style="background: transparent">
            <li class="breadcrumb-item" aria-current="page"><a href="/">Inicio</a></li>

            <li class="breadcrumb-item" aria-current="page"><a href="{{route("categorias")}}">Categorias</a></li>
            <li class="breadcrumb-item active" aria-current="page">Tipos</li>
        </ol>
    </nav>
    @if(session("exito"))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{session("exito")}}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif
    <div class="modal fade" id="modalNuevoTipoCategoria" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-dialog-scrollable" role="document">
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
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" name="fuenteRuta" value="/categoria/tipo">
                        <button type="submit" class="btn btn-success">Crear</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


@endsection
