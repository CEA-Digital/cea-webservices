@extends("layouts.main")
@section("content")
    <div class="container-fluid">
        <input id="saved_markers" type="hidden" value="{{$empresa->ubicaciones}}">
        <h3 class="mt-4">Detalle Empresa
        </h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb" style="background: white">
                <li class="breadcrumb-item" aria-current="page"><a href="/">Inicio</a></li>
                <li class="breadcrumb-item"><a href="{{route("empresas")}}">Empresas</a></li>
                <li class="breadcrumb-item active" aria-current="page">Detalle</li>

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
        <div class="row my-2">
            <div class="col-lg-4 order-lg-2 text-center">
                <div class="card profile-card-3">
                    <div class="background-block">
                        <img src="/images/empresas/portadas/{{$empresa->portada_img_url}}"
                             alt="profile-sample1"
                             data-src_img="portadas/{{$empresa->portada_img_url}}"
                             data-toggle="modal"
                             data-target="#modalVistaPreviaImgEmpresa"
                             class="background"/>
                    </div>
                    <div class="profile-thumb-block">
                        <img src="/images/empresas/profiles/{{$empresa->profile_img_url}}"
                             data-src_img="profiles/{{$empresa->profile_img_url}}"
                             data-toggle="modal"
                             data-target="#modalVistaPreviaImgEmpresa"
                             alt="profile-image" class="profile"/>
                    </div>
                    <div class="card-content">
                        <h2>{{$empresa->name}}<small>Plan Adquirido</small></h2>
                        <div class="icon-block">
                                <span class="fas fa-map-marker-alt"
                                      style="color: red"></span> {{$empresa->direccion}}
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-content">
                        <h4 class="mt-4">
                            <span class="fas fa-map-marker-alt" style="color: red"></span>
                            Ubicaciones de la empresa</h4>
                        <div class="pt-2" id="direcciones_empresa" style="width: 100%; height: 250px;"></div>
                    </div>
                </div>
            </div>
            <div class="col-lg-8 order-lg-2">
                <ul class="nav nav-tabs">
                    <li class="nav-item">
                        <a href="" data-target="#profile" data-toggle="tab" class="nav-link active">Perfil</a>
                    </li>
                    <li class="nav-item">
                        <a href="" data-target="#messages" data-toggle="tab" class="nav-link">Productos</a>
                    </li>
                    <li class="nav-item">
                        <a href="" data-target="#edit" data-toggle="tab" class="nav-link">Editar</a>
                    </li>
                </ul>
                <div class="tab-content py-4">
                    <div class="tab-pane active" id="profile">
                        <h5 class="mb-3">Perfil de la empresa</h5>
                        <div class="row">
                            <div class="col-md-6">
                                <h6><strong>Dirección</strong></h6>
                                <p>
                                    {{$empresa->direccion}}
                                </p>
                                <h6><strong>Categoria</strong></h6>
                                <p>
                                    <a class=" btn-link" title="Ver"
                                       href="{{route("buscarTipoCategorias",["busqueda"=>$empresa->nombre_categoria])}}">
                                        {{$empresa->nombre_categoria}} <span
                                            class="fas fa-external-link-alt "></span></a>
                                </p>
                            </div>
                            <div class="col-md-6">
                                <h6><span class="fas fa-store"></span> Tiendas:</h6>
                                <a href="#" class="badge badge-dark badge-pill">html5</a>
                                <a href="#" class="badge badge-dark badge-pill">react</a>
                                <a href="#" class="badge badge-dark badge-pill">codeply</a>
                                <a href="#" class="badge badge-dark badge-pill">angularjs</a>
                                <a href="#" class="badge badge-dark badge-pill">css3</a>
                                <a href="#" class="badge badge-dark badge-pill">jquery</a>
                                <a href="#" class="badge badge-dark badge-pill">bootstrap</a>
                                <a href="#" class="badge badge-dark badge-pill">responsive-design</a>
                                <hr>
                                <span class="badge badge-primary"><i
                                        class="fab fa-product-hunt"></i> 900 Productos</span>
                                <span class="badge badge-success"><i class="fa fa-cog"></i> 43 Servicios</span>
                                <span class="badge badge-danger"><i class="fa fa-eye"></i> 245 Seguidores</span>
                            </div>

                            <div class="col-md-12">
                                <hr>
                                <h5 class="mt-2">
                                    <span class="fas fa-map-marked-alt float-right"></span>
                                    <a class="btn btn-sm btn-success float-right mr-2"
                                       href="{{route("nuevaUbicacionEmpresa",["id"=>$empresa->id])}}">
                                        <span class="fas fa-pencil-alt"></span></a> Ubicaciones
                                    Guardadas</h5>
                                <table class="table table-sm table-hover table-striped">
                                    <tbody>
                                    @if(($empresa->ubicaciones)->count()>0)
                                        @foreach($empresa->ubicaciones as $ubicacion)
                                            <tr>
                                                <td>
                                                    <a target="popup"
                                                       href="https://www.google.com/maps?q={{$ubicacion->latitud}},{{$ubicacion->longitud}}">
                                                        <span class="fas fa-map-marker-alt"
                                                              style="color: red"></span> {{$ubicacion->descripcion}}
                                                        <span class="fas fa-external-link-alt"></span></a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td>No hay ubicaciones registradas aún para esta empresa</td>
                                        </tr>
                                    @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <!--/row-->
                    </div>
                    <div class="tab-pane" id="messages">
                        <div class="alert alert-info alert-dismissable">
                            <a class="panel-close close" data-dismiss="alert">×</a> This is an <strong>.alert</strong>.
                            Use this to show important messages to the user.
                        </div>
                        <table class="table table-hover table-striped">
                            <tbody>
                            <tr>
                                <td>
                                    <span class="float-right font-weight-bold">3 hrs ago</span> Here is your a link to
                                    the latest summary report from the..
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <span class="float-right font-weight-bold">Yesterday</span> There has been a request
                                    on your account since that was..
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <span class="float-right font-weight-bold">9/10</span> Porttitor vitae ultrices
                                    quis, dapibus id dolor. Morbi venenatis lacinia rhoncus.
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <span class="float-right font-weight-bold">9/4</span> Vestibulum tincidunt
                                    ullamcorper eros eget luctus.
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <span class="float-right font-weight-bold">9/4</span> Maxamillion ais the fix for
                                    tibulum tincidunt ullamcorper eros.
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="tab-pane" id="edit">
                        @include("Alerts.errors")
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
                                               @if(old("name"))
                                               @error("name")
                                               value="{{old("name")}}"
                                               @enderror
                                               @else
                                               value="{{$empresa->name}}"
                                               @endif
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
                                                  placeholder="Ingrese una dirección">
                                            @if(old("direccion"))
                                            @error("direccion"){{old("direccion")}}@enderror
                                            @else
                                            {{$empresa->direccion}}
                                            @endif
                                        </textarea>

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
                                                    @if($empresa->id_categoria)
                                                    value="{{$empresa->id_categoria}}"
                                                {{$empresa->id_categoria == $categoria->id ? 'selected="selected"':''}}
                                                @endif
                                            @if(old("id_categoria"))
                                                {{old("id_categoria") == $categoria->id ? 'selected="selected"':''}}
                                                @endif
                                            >{{$categoria->name}}

                                            </option>
                                        @endforeach
                                    </select>
                                    <!---- Boton para crear un nuevo tipo de categoria- -->
                                    <button class="btn btn-sm btn-outline-success">
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
                                        <input class="form-control @error('telefono') is-invalid @enderror"
                                               name="telefono"
                                               required
                                               max="99999999"
                                               @if(old("telefono"))
                                               @error("telefono")
                                               value="{{old("telefono")}}"
                                               @enderror
                                               @else
                                               value="{{$empresa->contacto->telefono}}"
                                               @endif
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
                                        <input class="form-control @error('telefono_opcional') is-invalid @enderror"
                                               name="telefono_opcional"
                                               max="99999999"
                                               min="1"
                                               @if(old("telefono_opcional"))
                                               @error("telefono_opcional")
                                               value="{{old("telefono_opcional")}}"
                                               @enderror
                                               @else
                                               value="{{$empresa->contacto->telefono_opcional}}"
                                               @endif
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
                                               @if(old("correo"))
                                               @error("correo")
                                               value="{{old("correo")}}"
                                               @enderror
                                               @else
                                               value="{{$empresa->contacto->correo}}"
                                               @endif
                                               required id="correo"
                                               class="form-control @error('correo') is-invalid @enderror">
                                    </div>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="sitio_web">Ingrese el sitio web:</label>

                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">@</div>
                                        </div>
                                        <input name="sitio_web"
                                               @if(old("sitio_web"))
                                               @error("sitio_web")
                                               value="{{old("sitio_web")}}" @enderror
                                               @else
                                               value="{{$empresa->contacto->sitio_web}}"
                                               @endif
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
                                               @if(old("facebook"))
                                               value="{{old("facebook")}}"
                                               @else
                                               value="{{$empresa->contacto->facebook}}"
                                               @endif
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
                                               @if(old("instagram"))
                                               value="{{old("instagram")}}"
                                               @else
                                               value="{{$empresa->contacto->instagram}}"
                                               @endif
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

                    </div>
                </div>
            </div>


        </div>
    </div>
    <!-- ..............................modal vista previa................................. -->
    <div class="modal fade" id="modalVistaPreviaImgEmpresa" tabindex="-1" role="dialog">
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

@endsection
<style>

    /*Profile Card 3*/
    .profile-card-3 {
        font-family: 'Open Sans', Arial, sans-serif;
        position: relative;
        float: left;
        overflow: hidden;
        width: 100%;
        text-align: center;
        height: 368px;
        margin-bottom: 5px;
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

    .profile-card-3 h2 {
        margin: 0 0 5px;
        font-weight: 600;
        font-size: 25px;
    }

    .profile-card-3 h2 small {
        display: block;
        font-size: 15px;
        margin-top: 10px;
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
