@extends("layouts.main")
@section("content")
    <div class="container-fluid">
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
            <div class="col-lg-4 order-lg-1 text-center">

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
                        <h2>{{$empresa->name}}<small>Designer</small></h2>
                        <div class="icon-block">
                                <span class="fas fa-map-marker-alt"
                                      style="color: red"></span> {{$empresa->direccion}}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-8 order-lg-2">
                <ul class="nav nav-tabs">
                    <li class="nav-item">
                        <a href="" data-target="#profile" data-toggle="tab" class="nav-link active">Profile</a>
                    </li>
                    <li class="nav-item">
                        <a href="" data-target="#messages" data-toggle="tab" class="nav-link">Messages</a>
                    </li>
                    <li class="nav-item">
                        <a href="" data-target="#edit" data-toggle="tab" class="nav-link">Edit</a>
                    </li>
                </ul>
                <div class="tab-content py-4">
                    <div class="tab-pane active" id="profile">
                        <h5 class="mb-3">Perfil de la empresa</h5>
                        <div class="row">
                            <div class="col-md-6">
                                <h6>Dirección</h6>
                                <p>
                                    {{$empresa->direccion}}
                                </p>
                                <h6>Categoria</h6>
                                <p>
                                    {{$empresa->nombre_categoria}}
                                </p>
                            </div>
                            <div class="col-md-6">
                                <h6>Recent badges</h6>
                                <a href="#" class="badge badge-dark badge-pill">html5</a>
                                <a href="#" class="badge badge-dark badge-pill">react</a>
                                <a href="#" class="badge badge-dark badge-pill">codeply</a>
                                <a href="#" class="badge badge-dark badge-pill">angularjs</a>
                                <a href="#" class="badge badge-dark badge-pill">css3</a>
                                <a href="#" class="badge badge-dark badge-pill">jquery</a>
                                <a href="#" class="badge badge-dark badge-pill">bootstrap</a>
                                <a href="#" class="badge badge-dark badge-pill">responsive-design</a>
                                <hr>
                                <span class="badge badge-primary"><i class="fa fa-user"></i> 900 Followers</span>
                                <span class="badge badge-success"><i class="fa fa-cog"></i> 43 Forks</span>
                                <span class="badge badge-danger"><i class="fa fa-eye"></i> 245 Views</span>
                            </div>
                            <div class="col-md-12">
                                <h5 class="mt-2"><span class="fas fa-map-marked-alt float-right"></span> Ubicaciones
                                    Guardadas</h5>
                                <table class="table table-sm table-hover table-striped">
                                    <tbody>
                                    @if(($empresa->ubicaciones)->count()>0)
                                        @foreach($empresa->ubicaciones as $ubicacion)
                                            <tr>
                                                <td>
                                                   <a target="popup"
                                                       href="https://www.google.com/maps?q={{$ubicacion->latitud}},{{$ubicacion->longitud}}">
                                                       <span class="fas fa-map-marker-alt" style="color: red"></span> {{$ubicacion->descripcion}}
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
                        <form role="form">
                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label form-control-label">First name</label>
                                <div class="col-lg-9">
                                    <input class="form-control" type="text" value="Jane">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label form-control-label">Last name</label>
                                <div class="col-lg-9">
                                    <input class="form-control" type="text" value="Bishop">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label form-control-label">Email</label>
                                <div class="col-lg-9">
                                    <input class="form-control" type="email" value="email@gmail.com">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label form-control-label">Company</label>
                                <div class="col-lg-9">
                                    <input class="form-control" type="text" value="">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label form-control-label">Website</label>
                                <div class="col-lg-9">
                                    <input class="form-control" type="url" value="">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label form-control-label">Address</label>
                                <div class="col-lg-9">
                                    <input class="form-control" type="text" value="" placeholder="Street">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label form-control-label"></label>
                                <div class="col-lg-6">
                                    <input class="form-control" type="text" value="" placeholder="City">
                                </div>
                                <div class="col-lg-3">
                                    <input class="form-control" type="text" value="" placeholder="State">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label form-control-label">Time Zone</label>
                                <div class="col-lg-9">
                                    <select id="user_time_zone" class="form-control" size="0">
                                        <option value="Hawaii">(GMT-10:00) Hawaii</option>
                                        <option value="Alaska">(GMT-09:00) Alaska</option>
                                        <option value="Pacific Time (US &amp; Canada)">(GMT-08:00) Pacific Time (US
                                            &amp; Canada)
                                        </option>
                                        <option value="Arizona">(GMT-07:00) Arizona</option>
                                        <option value="Mountain Time (US &amp; Canada)">(GMT-07:00) Mountain Time (US
                                            &amp; Canada)
                                        </option>
                                        <option value="Central Time (US &amp; Canada)" selected="selected">(GMT-06:00)
                                            Central Time (US &amp; Canada)
                                        </option>
                                        <option value="Eastern Time (US &amp; Canada)">(GMT-05:00) Eastern Time (US
                                            &amp; Canada)
                                        </option>
                                        <option value="Indiana (East)">(GMT-05:00) Indiana (East)</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label form-control-label">Username</label>
                                <div class="col-lg-9">
                                    <input class="form-control" type="text" value="janeuser">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label form-control-label">Password</label>
                                <div class="col-lg-9">
                                    <input class="form-control" type="password" value="11111122333">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label form-control-label">Confirm password</label>
                                <div class="col-lg-9">
                                    <input class="form-control" type="password" value="11111122333">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label form-control-label"></label>
                                <div class="col-lg-9">
                                    <input type="reset" class="btn btn-secondary" value="Cancel">
                                    <input type="button" class="btn btn-primary" value="Save Changes">
                                </div>
                            </div>
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
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.19), 0 6px 6px rgba(0, 0, 0, 0.23);
        text-align: center;
        height: 368px;
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
        border-radius: 25%;
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


</style>
