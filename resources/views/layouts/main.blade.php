<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"/>
    <meta name="description" content=""/>
    <meta name="author" content=""/>
    <title>Eureka Admin</title>

    <link href="{{asset("css/styles.css")}}" rel="stylesheet"/>
    <link href="{{asset("css/file-input.css")}}" media="all" rel="stylesheet" type="text/css"/>


    <link href="{{asset("https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css")}}" rel="stylesheet"
          crossorigin="anonymous"/>
    <script src="{{asset("js/font-awesome.js")}}"
            crossorigin="anonymous"></script>
    <link href="{{asset("https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css")}}"
          rel="stylesheet"/>
    <link href="{{asset("css/main.css")}}">
    <link href="{{asset("css/bd-wizard.css")}}" rel="stylesheet">


    <link href='{{asset("https://api.mapbox.com/mapbox-gl-js/v1.11.1/mapbox-gl.css")}}' rel='stylesheet' />
    <link
        rel="stylesheet"
        href="{{asset("https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-geocoder/v4.5.1/mapbox-gl-geocoder.css")}}"
        type="text/css"
    />

</head>
<body id="body" class="sb-nav-fixed">
<nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
    <button class="btn btn-link order-1 order-lg-0 ml-4" id="sidebarToggle" href="#"><i class="fas fa-bars"></i>
    </button>
    <a class="navbar-brand" href="/">Eureka Admón</a>
    <!-- Navbar Search-->
    <form class="d-none d-md-inline-block form-inline ml-auto mr-0 mr-md-3 my-2 my-md-0">
        <div class="input-group">
            <input class="form-control" type="text" placeholder="Buscar" aria-label="Search"
                   aria-describedby="basic-addon2"/>
            <div class="input-group-append">
                <button class="btn btn-primary" type="button"><i class="fas fa-search"></i></button>
            </div>
        </div>
    </form>
    <!-- Navbar-->
    <ul class="navbar-nav ml-auto ml-md-0">
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" id="userDropdown" href="#" role="button" data-toggle="dropdown"
               aria-haspopup="true" aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                <a class="dropdown-item" href="#">Settings</a>
                <a class="dropdown-item" href="#">Activity Log</a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="login.html">Logout</a>
            </div>
        </li>
    </ul>
</nav>
<div id="layoutSidenav">
    <div id="layoutSidenav_nav">
        <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
            <div class="sb-sidenav-menu">
                <div class="nav">
                    <div class="sb-sidenav-menu-heading">Core</div>
                    <a class="nav-link" href="/">
                        <div class="sb-nav-link-icon"><i class="fas fa-home"></i></div>
                        Inicio
                    </a>
                    <div class="sb-sidenav-menu-heading">Administración General</div>
                    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseLayouts"
                       aria-expanded="false" aria-controls="collapseLayouts">
                        <div class="sb-nav-link-icon"><i class="fas fa-building"></i></div>
                        Empresas
                        <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                    </a>
                    <div class="collapse" id="collapseLayouts" aria-labelledby="headingOne"
                         data-parent="#sidenavAccordion">
                        <nav class="sb-sidenav-menu-nested nav">
                            <a class="nav-link" href="{{route("empresas")}}">Empresas Asociadas</a>
                            <a class="nav-link" href="{{route("categorias")}}">Categorias</a>
                            <a class="nav-link" href="{{ url('servicios') }}">Servicios</a>
                            <a class="nav-link" href="{{ url('partners') }}">Partners</a>
                            <a class="nav-link" href="{{url('productos')}}">Productos</a>
                            <a class="nav-link" href="{{url('marcas')}}">Marcas</a>
                            <a class="nav-link" href="{{ url('promociones') }}">Promociones</a>


                        </nav>
                    </div>
                    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages"
                       aria-expanded="false" aria-controls="collapsePages">
                        <div class="sb-nav-link-icon"><i class="fas fa-book-open"></i></div>
                        Pages
                        <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                    </a>
                    <div class="collapse" id="collapsePages" aria-labelledby="headingTwo"
                         data-parent="#sidenavAccordion">
                        <nav class="sb-sidenav-menu-nested nav accordion" id="sidenavAccordionPages">
                            <a class="nav-link collapsed" href="#" data-toggle="collapse"
                               data-target="#pagesCollapseAuth" aria-expanded="false" aria-controls="pagesCollapseAuth">
                                Authentication
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                            </a>
                            <div class="collapse" id="pagesCollapseAuth" aria-labelledby="headingOne"
                                 data-parent="#sidenavAccordionPages">
                                <nav class="sb-sidenav-menu-nested nav">
                                    <a class="nav-link" href="login.html">Login</a>
                                    <a class="nav-link" href="register.html">Register</a>
                                    <a class="nav-link" href="password.html">Forgot Password</a>
                                </nav>
                            </div>
                            <a class="nav-link collapsed" href="#" data-toggle="collapse"
                               data-target="#pagesCollapseError" aria-expanded="false"
                               aria-controls="pagesCollapseError">
                                Error
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                            </a>
                            <div class="collapse" id="pagesCollapseError" aria-labelledby="headingOne"
                                 data-parent="#sidenavAccordionPages">
                                <nav class="sb-sidenav-menu-nested nav">
                                    <a class="nav-link" href="401.html">401 Page</a>
                                    <a class="nav-link" href="404.html">404 Page</a>
                                    <a class="nav-link" href="500.html">500 Page</a>
                                </nav>
                            </div>
                        </nav>
                    </div>
                </div>
            </div>
            <div class="sb-sidenav-footer">
                <div class="small">Logeado con:</div>
                Eureka
            </div>
        </nav>
    </div>
    <div id="layoutSidenav_content">
        <main>

            @yield("content")
        </main>
        <footer class="py-4 bg-light mt-auto">
            <div class="container-fluid">
                <div class="d-flex align-items-center justify-content-between small">
                    <div class="text-muted">Derechos Reservados &copy; Eureka 2020</div>
                    <div>
                        <a href="#">Politicas de Seguridad</a>
                        &middot;
                        <a href="#">Términos & condiciones</a>
                    </div>
                </div>
            </div>
        </footer>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.5.1.min.js" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.bundle.min.js"
        crossorigin="anonymous"></script>
<script src="js/scripts.js"></script>
<script src="{{asset("js/bootstrap-fileinput.js")}}" type="text/javascript"></script>
<script src="{{asset("js/bootstrap-fileinput-theme.js")}}" type="text/javascript"></script>

<script src="{{asset("js/jquery.steps.min.js")}}"></script>
<script src="{{asset("js/bd-wizard.js")}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
<script src="assets/demo/chart-area-demo.js"></script>
<script src="assets/demo/chart-bar-demo.js"></script>
<script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js" crossorigin="anonymous"></script>
<script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js" crossorigin="anonymous"></script>
<script src="assets/demo/datatables-demo.js"></script>

<script src="{{asset("https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-geocoder/v4.5.1/mapbox-gl-geocoder.min.js")}}"></script>
<script src='{{asset("https://api.mapbox.com/mapbox-gl-js/v1.11.1/mapbox-gl.js")}}'></script>
<script src="{{asset("js/mapbox-scripts.js")}}"></script>
<script src="{{asset("js/categorias.js")}}"></script>

<script src="{{asset("js/productos.js")}}"></script>
<script src="{{asset("js/marca.js")}}"></script>

<script src="{{asset("js/servicio.js")}}"></script>
<script src="{{asset("js/partners.js")}}"></script>
<script src="{{asset("js/promociones.js")}}"></script>




<script src="{{asset("js/empresas.js")}}"></script>
<script>

</script>
<script>
    $(document).ready(function () {
        $(".empresa2").select2({
            theme: "classic",
            placeholder: "Seleccione una opción"
        });

        $(".disponible2").select2({
            theme: "classic",
            placeholder: "Seleccione una opción"
        });
    });
</script>
<script>
    $(document).ready(function () {
        $(".tipoCategoria").select2({
            theme: "classic",
            placeholder: "Seleccione una opción"
        });
        $(".empresa").select2({
            theme: "classic",
            placeholder: "Seleccione una opción"
        });
        $(".disponible").select2({
            theme: "classic",
            placeholder: "Seleccione una opción"
        });
        $(".marca").select2({
            theme: "classic",
            placeholder: "Seleccione una opción"
        });
    });
</script>

</body>
</html>
