@extends("layouts.main")
@section("content")
    <div class="container-fluid">
        <h1 class="mt-4">Nueva Empresa</h1>

        <nav aria-label="breadcrumb">
            <ol class="breadcrumb" style="background: white">
                <li class="breadcrumb-item" aria-current="page"><a href="/">Inicio</a></li>
                <li class="breadcrumb-item" aria-current="page"><a href="{{route("empresas")}}">Empresas</a></li>
                <li class="breadcrumb-item" aria-current="page">Nuevo</li>
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

        <div class="card card-body">
            <form>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <div class="input-group-text"><span class="fas fa-heading"></span></div>
                            </div>
                            <input class="form-control"
                                   placeholder="Ingrese el nombre de la empresa"
                                   name="name" id="nombre_empresa" type="text"
                                   max="100">
                        </div>
                    </div>
                    <div class="form-group col-md-6" id="locationField">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <div class="input-group-text"><span class="fas fa-map-marker-alt"></span></div>
                            </div>
                            <textarea class="form-control" name="direccion"
                                      id="autocomplete"
                                      type="text"
                                      required
                                      placeholder="Ingrese una dirección"></textarea>

                        </div>
                        <small class="text-muted">
                            Se podrán agregar más direcciones en la información de la empresa</small>
                    </div>


                </div>


                <div class="card card-body">
                    <label>Selecciona una o varias imagenes <span class="badge badge-dark"> (opcional)</span>: </label>
                    <div class="form-group">
                        <div class="file-loading">
                            <input id="imagenes_empresa" type="file" name="file" multiple class="file"
                                   data-overwrite-initial="false" data-min-file-count="2">
                        </div>
                    </div>
                </div>

            </form>
        </div>
    </div>
    <style>
        .image-preview-input-profile {
            position: relative;
            overflow: hidden;
            margin: 0px;
            color: #333;
            background-color: #fff;
            border-color: #ccc;
        }

        .image-preview-input-profile input[type=file] {
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

        .image-preview-input-title-profile {
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
    </style>
@endsection