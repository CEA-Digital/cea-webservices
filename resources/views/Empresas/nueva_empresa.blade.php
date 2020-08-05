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
            <div id="wizard-empresa">
                <h3>
                    <div class="media">
                        <div class="bd-wizard-step-icon"><i class="fas  fa-info-circle"></i></div>
                        <div class="media-body">
                            <div class="bd-wizard-step-title"> Datos generales</div>
                            <div class="bd-wizard-step-subtitle">Paso 1</div>
                        </div>
                    </div>
                </h3>
                <section>
                    @include('Alerts.errors')
                    @if($fase==1)
                        <form id="fase1" method="POST" action="{{route("nuevaEmpresa")}}" enctype="multipart/form-data">
                            @csrf
                            @method("post")
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="nombre_empresa"><strong style="color: red">*</strong>Nombre de la
                                        empresa:</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text"><span class="fas fa-heading"></span></div>
                                        </div>
                                        <input class="form-control"
                                               required
                                               value="{{old("name")}}"
                                               placeholder="Ingrese el nombre de la empresa"
                                               name="name" id="nombre_empresa" type="text"
                                               max="80">
                                    </div>

                                    <small class="text-muted">
                                        Este es el nombre será público y es el distintivo de la empresa</small>
                                </div>
                                <div class="form-group col-md-6" id="locationField">
                                    <label for="direccion"><strong style="color: red">*</strong>Dirección de la
                                        empresa:</label>

                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text"><span class="fas fa-map-marker-alt"></span>
                                            </div>
                                        </div>
                                        <textarea class="form-control" name="direccion"
                                                  id="direccion"
                                                  type="text"
                                                  required
                                                  placeholder="Ingrese una dirección">{{old("direccion")}}</textarea>

                                    </div>
                                    <small class="text-muted">
                                        Se podrán agregar más direcciones en la información de la empresa</small>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="tipoNuevaCategoria"><strong style="color: red">*</strong>Seleccione el
                                        tipo de Categoria que pertenece la empresa :
                                    </label>
                                    <br>
                                    <select name="id_categoria"
                                            required
                                            style="width: 90%"
                                            class="select2TipoCategoria form-control  @error('id_categoria') is-invalid @enderror"
                                            id="tipoNuevaCategoria">
                                        <option disabled selected value="">Seleccione</option>
                                        @foreach($tipoCategorias as $categoria)
                                            <option value="{{$categoria->id}}"
                                            @if(session("idNuevaCategoria"))
                                                value="{{session("idNuevaCategoria")}}"
                                                {{session("idNuevaCategoria") == $categoria->id ? 'selected="selected"':''}}
                                                @endif
                                            @if(old("id_categoria"))
                                                {{old("id_categoria") == $categoria->id ? 'selected="selected"':''}}
                                                @endif
                                            >{{$categoria->name}}

                                            </option>
                                        @endforeach
                                    </select>
                                    <!---- Boton para crear un nuevo tipo de categoria- -->
                                    <button class="btn btn-sm btn-outline-success"
                                       data-toggle="modal"
                                       data-target="#modalNuevoTipoCategoria">
                                        <i class="fas fa-plus" style="color: green"></i>
                                    </button>
                                </div>
                            </div>

                            <hr>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                        <label for="telefono"><strong style="color: red">*</strong>Telefono #1 :</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text"><span class="fas fa-phone"></span></div>
                                        </div>
                                        <input class="form-control @error('telefono') is-invalid @enderror" name="telefono"
                                               required
                                               max="99999999"
                                               value="{{old("telefono")}}"
                                               type="number"
                                               aria-valuemax="8"
                                               maxlength="8"
                                               min="1"
                                               id="telefono" placeholder="9999-9999">

                                    </div>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="telefono">Telefono #2 (opcional)</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text"><span class="fas fa-phone"></span></div>
                                        </div>
                                        <input class="form-control @error('telefono_opcional') is-invalid @enderror" name="telefono_opcional"
                                               max="99999999"
                                               min="1"
                                               value="{{old("telefono_opcional")}}"
                                               maxlength="8"
                                               id="telefono_opcional" type="number" placeholder="9999-9999">
                                    </div>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="correo"><strong style="color: red">*</strong>Ingrese el correo
                                        empresarial:</label>

                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">@</div>
                                        </div>
                                        <input name="correo" type="email"
                                               placeholder="ejemplo@ejemplo.com"
                                               value="{{old("correo")}}"
                                               required id="correo" class="form-control @error('correo') is-invalid @enderror">
                                    </div>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="sitio_web">Ingrese el sitio web:</label>

                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">@</div>
                                        </div>
                                        <input name="sitio_web"
                                               value="{{old("sitio_web")}}"
                                               placeholder="www.empresa.com" type="text" id="sitio_web"
                                               class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="facebook">Facebook:</label>

                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text"><span class="fab fa-facebook"></span></div>
                                        </div>
                                        <input class="form-control"
                                               name="facebook"
                                               value="{{old("facebook")}}"
                                               placeholder="www.facebook.com/ejemplo" id="facebook">
                                    </div>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="instagram">Instagram:</label>

                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text"><span class="fab fa-instagram"></span></div>
                                        </div>
                                        <input class="form-control"
                                               value="{{old("instagram")}}"
                                               name="instagram"
                                               placeholder="www.instagram.com/ejemplo" id="instagram">
                                    </div>
                                </div>
                            </div>


                            <hr>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="imagenCategoria">Seleccione una imagen de perfil (opcional): </label>
                                    <div class="input-group image-preview-profile">

                                        <input type="text" name="imagen_url"
                                               class="form-control image-preview-filename-profile"
                                               disabled="disabled">
                                        <!-- don't give a name === doesn't send on POST/GET -->
                                        <span class="input-group-btn">
                                <!-- image-preview-clear button -->
                                <button type="button" class="btn btn-outline-danger image-preview-clear-profile"
                                        style="display:none;">
                                    <span class="fas fa-times"></span> Clear
                                </button>
                                            <!-- image-preview-input -->
                                <div class="btn btn-default image-preview-input-profile">
                                    <span class="fas fa-folder-open"></span>
                                    <span class="image-preview-input-title-profile">Seleccionar</span>
                                    <input type="file" accept="image/png, image/jpeg, image/gif"
                                           name="profile_img_url"/>
                                    <!-- rename it -->
                                </div>
                            </span>
                                    </div><!-- /input-group image-preview [TO HERE]-->
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="imagenCategoria">Seleccione una imagen (opcional): </label>
                                    <div class="input-group image-preview">

                                        <input type="text" name="imagen_url"
                                               class="form-control image-preview-filename"
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
                                           name="portada_img_url"/>
                                    <!-- rename it -->
                                </div></span>
                                    </div><!-- /input-group image-preview [TO HERE]-->
                                </div>
                            </div>
                            <input name="fase" value="1" type="hidden">

                            <button class="btn btn-success pull-right" style=" -webkit-box-pack: end;
            justify-content: flex-end;">Siguiente
                            </button>
                        </form>
                    @endif
                </section>
                <h3>
                    <div class="media">
                        <div class="bd-wizard-step-icon"><i class="fas  fa-map-marker"></i></div>
                        <div class="media-body">
                            <div class="bd-wizard-step-title">Ubicaciones</div>
                            <div class="bd-wizard-step-subtitle">Paso 2</div>
                        </div>
                    </div>
                </h3>
                <section>

                </section>
                <h3>
                    <div class="media">
                        <div class="bd-wizard-step-icon"><i class="fas  fa-info-circle"></i></div>
                        <div class="media-body">
                            <div class="bd-wizard-step-title">Cátalogo de Imagenes</div>
                            <div class="bd-wizard-step-subtitle">Step 3</div>
                        </div>
                    </div>
                </h3>
                <section>
                    <label>Selecciona una o varias imagenes <span class="badge badge-dark"> (opcional)</span>:
                    </label>
                    <div class="form-group">
                        <div class="file-loading">
                            <input id="imagenes_empresa" type="file" name="file" multiple class="file"
                                   data-overwrite-initial="false" data-max-file-count="10" data-min-file-count="1">
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalNuevoTipoCategoria" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
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
                        <div class="form-group">
                            <label for="imagenCategoria">Seleccione una imagen de portada (opcional): </label>
                            <div class="input-group image-preview-tipo-categoria">

                                <input type="text" name="imagen_url"
                                       class="form-control image-preview-filename-tipo-categoria"
                                       disabled="disabled">
                                <!-- don't give a name === doesn't send on POST/GET -->
                                <span class="input-group-btn">
                                <!-- image-preview-clear button -->
                                <button type="button" class="btn btn-outline-danger image-preview-clear-tipo-categoria"
                                        style="display:none;">
                                    <span class="fas fa-times"></span> Clear
                                </button>
                                    <!-- image-preview-input -->
                                <div class="btn btn-default image-preview-input-tipo-categoria">
                                    <span class="fas fa-folder-open"></span>
                                    <span class="image-preview-input-title-tipo-categoria">Seleccionar</span>
                                    <input type="file" accept="image/png, image/jpeg, image/gif"
                                           name="imagen_url"/>
                                    <!-- rename it -->
                                </div></span>
                            </div><!-- /input-group image-preview [TO HERE]-->

                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" name="fuenteRuta"
                               value="{{\Illuminate\Support\Facades\Route::currentRouteName()}}">
                        <button type="submit" class="btn btn-success">Crear</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <style>
        .image-preview-input-tipo-categoria {
            position: relative;
            overflow: hidden;
            margin: 0px;
            color: #333;
            background-color: #fff;
            border-color: #ccc;
        }

        .image-preview-input-tipo-categoria input[type=file] {
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

        .image-preview-input-title-tipo-categoria {
            margin-left: 2px;
        }
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
