<?php echo $header;?>

<body class="g-sidenav-show  bg-gray-100">
    <aside class="bg-white-aside sidenav navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-3 " id="sidenav-main">
        <div class="sidenav-header" style="margin-bottom: 30px;">
            <i class="fas fa-times p-3 cursor-pointer text-secondary opacity-5 position-absolute end-0 top-0 d-none d-xl-none" aria-hidden="true" id="iconSidenav"></i>

            <a class="navbar-brand m-0" href="/Principal/" target="_blank">
                <img src="/assets/img/favicon.png" class="navbar-brand-img h-100" alt="main_logo">
                <span class="ms-1 font-weight-bold">ADMIN CONVENCIÓN</span>
                <p style="margin-top: 15px;"><span class="fa fa-user" style="color: #344767"></span> <?php echo $_SESSION['nombre']; ?></p>
            </a>


        </div>
        <hr class="horizontal dark mt-0">


        <div class="collapse navbar-collapse  w-auto h-auto h-100" id="sidenav-collapse-main">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a href="/Principal/" role="button" class="nav-link" aria-expanded="false">
                        <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center d-flex align-items-center justify-content-center  me-2">
                            <span class="fa fa-home" style="color: #344767"></span>
                        </div>
                        <span class="nav-link-text ms-1">Principal</span>
                    </a>

                </li>

                <!--<li class="nav-item">
                    <a data-bs-toggle="collapse" onclick="catalogos()" href="#catalogos" class="nav-link " aria-controls="catalogos" role="button" aria-expanded="false">
                        <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center d-flex align-items-center justify-content-center  me-2">
                            <span class="fa fa-sitemap" style="color: #344767"></span>
                        </div>
                        <span class="nav-link-text ms-1">Catálogos</span>
                    </a>
                    <div class="collapse " id="catalogos" hidden>
                        <ul class="nav ms-4 ps-3">
                            <li class="nav-item ">
                                <a class="nav-link " href="/Bu/">
                                    <span class="sidenav-mini-icon"> B </span>
                                    <span class="sidenav-normal">Bu Asofarma</span>
                                </a>
                            </li>
                            <li class="nav-item ">
                                <a class="nav-link " href="/Lineas/">
                                    <span class="sidenav-mini-icon"> L </span>
                                    <span class="sidenav-normal">Lineas Asofarma</span>
                                </a>
                            </li>
                            <li class="nav-item ">
                                <a class="nav-link " href="/Posiciones/">
                                    <span class="sidenav-mini-icon"> P </span>
                                    <span class="sidenav-normal"> Posiciones Asofarma </span>
                                </a>
                            </li>
                            <li class="nav-item ">
                                <a class="nav-link " href="/Restaurantes/">
                                    <span class="sidenav-mini-icon"> R </span>
                                    <span class="sidenav-normal"> Restaurates </span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <hr class="horizontal dark" />
                            </li>
                            <li class="nav-item ">
                            <a class="nav-link " href="/Restaurantes/">
                                <span class="sidenav-mini-icon"> E </span>
                                <span class="sidenav-normal"> Restaurates </span>
                            </a>
                        </li>
                        </ul>
                    </div>
                </li>-->
                <li class="nav-item">
                    <a href="/Asistentes/" class="nav-link active" aria-controls="applicationsExamples" role="button" aria-expanded="false">
                        <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center d-flex align-items-center justify-content-center  me-2">
                            <span class="fa fa-users" style="color: white"></span>
                        </div>
                        <span class="nav-link-text ms-1">Asistentes</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="/Vuelos/" class="nav-link " aria-controls="applicationsExamples" role="button" aria-expanded="false">
                        <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center d-flex align-items-center justify-content-center  me-2">
                            <span class="fa fa-plane" style="color: #344767"></span>
                        </div>
                        <span class="nav-link-text ms-1">Vuelos</span>
                    </a>
                </li>
                <!--<li class="nav-item">
                    <a href="/PickUp/" class="nav-link " aria-controls="ecommerceExamples" role="button" aria-expanded="false">
                        <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center d-flex align-items-center justify-content-center  me-2">
                            <span class="fa fa-bus" style="color: #344767"></span>
                        </div>
                        <span class="nav-link-text ms-1">PickUp</span>
                    </a>
                </li>-->
                <li class="nav-item">
                    <a href="/Habitaciones/" class="nav-link " aria-controls="authExamples" role="button" aria-expanded="false">
                        <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center d-flex align-items-center justify-content-center  me-2">
                            <span class="fa fa-shield-virus" style="color: #344767"></span>
                        </div>
                        <span class="nav-link-text ms-1">Habitaciones</span>
                    </a>
                </li>
                <!--<li class="nav-item">
                    <a href="/Cenas/" class="nav-link " aria-controls="authExamples" role="button" aria-expanded="false">
                        <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center d-flex align-items-center justify-content-center  me-2">
                            <span class="fa fa-coffee" style="color: #344767"></span>
                        </div>
                        <span class="nav-link-text ms-1">Cenas</span>
                    </a>
                </li> -->
                <li class="nav-item">
                    <a href="/Asistencias/" class="nav-link " aria-controls="basicExamples" role="button" aria-expanded="false">
                        <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center d-flex align-items-center justify-content-center  me-2">
                            <span class="fa fa-bell" style="color: #344767"></span>
                        </div>
                        <span class="nav-link-text ms-1">Asistencias</span>
                    </a>
                </li>
                <li class="nav-item">
                    <hr class="horizontal dark" />
                    <h6 class="ps-4  ms-2 text-uppercase text-xs font-weight-bolder opacity-6">SALUD</h6>
                </li>
                <li class="nav-item">
                    <a href="/ComprobantesVacunacion/" class="nav-link " aria-controls="basicExamples" role="button" aria-expanded="false">
                        <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center d-flex align-items-center justify-content-center  me-2">
                            <span class="fa fa-shield-virus" style="color: #344767"></span>
                        </div>
                        <span class="nav-link-text ms-1">Comprobante Vacunación</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="/PruebasCovidUsuarios/" class="nav-link " aria-controls="basicExamples" role="button" aria-expanded="false">
                        <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center d-flex align-items-center justify-content-center  me-2">
                            <span class="fa fa-virus-slash" style="color: #344767"></span>
                        </div>
                        <span class="nav-link-text ms-1">Pruebas Covid Usuarios</span>
                    </a>
                </li>
                <!--

              <li class="nav-item">
                  <hr class="horizontal dark" />
                  <h6 class="ps-4  ms-2 text-uppercase text-xs font-weight-bolder opacity-6">OTROS</h6>
              </li>
              <li class="nav-item">
                  <a href="/Configuracion/" class="nav-link " aria-controls="applicationsExamples" role="button" aria-expanded="false">
                      <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center d-flex align-items-center justify-content-center  me-2">
                          <span class="fa fa-tools" style="color: #344767"></span>
                      </div>
                      <span class="nav-link-text ms-1">Configuración</span>
                  </a>
              </li>
              <li class="nav-item">
                  <a data-bs-toggle="collapse" onclick="utilerias()" href="#utilerias" class="nav-link " aria-controls="utilerias" role="button" aria-expanded="false">
                      <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center d-flex align-items-center justify-content-center  me-2">
                          <span class="fa fa-user-circle-o" style="color: #344767"></span>
                      </div>
                      <span class="nav-link-text ms-1">Utilerias</span>
                  </a>
                  <div class="collapse " id="utilerias" hidden>
                      <ul class="nav ms-4 ps-3">
                          <li class="nav-item ">
                              <a class="nav-link " href="/Administradores/">
                                  <span class="sidenav-mini-icon"> A </span>
                                  <span class="sidenav-normal">Administradores</span>
                              </a>
                          </li>
                          <li class="nav-item ">
                              <a class="nav-link " href="/Perfiles/">
                                  <span class="sidenav-mini-icon"> P </span>
                                  <span class="sidenav-normal"> Perfiles </span>
                              </a>
                          </li>
                          <li class="nav-item ">
                              <a class="nav-link " href="/Log/">
                                  <span class="sidenav-mini-icon"> L </span>
                                  <span class="sidenav-normal"> Log </span>
                              </a>
                          </li>
                      </ul>
                  </div>
              </li>
-->
                          </ul>
                      </div>

                  </aside>
                  <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
                      <!-- Navbar -->
        <nav class="navbar navbar-main navbar-expand-lg position-sticky mt-4 top-1 px-0 mx-4 shadow-none border-radius-xl z-index-sticky" id="navbarBlur" data-scroll="true">
            <div class="container-fluid py-1 px-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
                        <li class="breadcrumb-item text-sm">
                            <a class="opacity-3 text-dark" href="javascript:;">
                                <svg width="12px" height="12px" class="mb-1" viewBox="0 0 45 40" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                                    <title>shop </title>
                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                        <g transform="translate(-1716.000000, -439.000000)" fill="#252f40" fill-rule="nonzero">
                                            <g transform="translate(1716.000000, 291.000000)">
                                                <g transform="translate(0.000000, 148.000000)">
                                                    <path d="M46.7199583,10.7414583 L40.8449583,0.949791667 C40.4909749,0.360605034 39.8540131,0 39.1666667,0 L7.83333333,0 C7.1459869,0 6.50902508,0.360605034 6.15504167,0.949791667 L0.280041667,10.7414583 C0.0969176761,11.0460037 -1.23209662e-05,11.3946378 -1.23209662e-05,11.75 C-0.00758042603,16.0663731 3.48367543,19.5725301 7.80004167,19.5833333 L7.81570833,19.5833333 C9.75003686,19.5882688 11.6168794,18.8726691 13.0522917,17.5760417 C16.0171492,20.2556967 20.5292675,20.2556967 23.494125,17.5760417 C26.4604562,20.2616016 30.9794188,20.2616016 33.94575,17.5760417 C36.2421905,19.6477597 39.5441143,20.1708521 42.3684437,18.9103691 C45.1927731,17.649886 47.0084685,14.8428276 47.0000295,11.75 C47.0000295,11.3946378 46.9030823,11.0460037 46.7199583,10.7414583 Z"></path>
                                                    <path d="M39.198,22.4912623 C37.3776246,22.4928106 35.5817531,22.0149171 33.951625,21.0951667 L33.92225,21.1107282 C31.1430221,22.6838032 27.9255001,22.9318916 24.9844167,21.7998837 C24.4750389,21.605469 23.9777983,21.3722567 23.4960833,21.1018359 L23.4745417,21.1129513 C20.6961809,22.6871153 17.4786145,22.9344611 14.5386667,21.7998837 C14.029926,21.6054643 13.533337,21.3722507 13.0522917,21.1018359 C11.4250962,22.0190609 9.63246555,22.4947009 7.81570833,22.4912623 C7.16510551,22.4842162 6.51607673,22.4173045 5.875,22.2911849 L5.875,44.7220845 C5.875,45.9498589 6.7517757,46.9451667 7.83333333,46.9451667 L19.5833333,46.9451667 L19.5833333,33.6066734 L27.4166667,33.6066734 L27.4166667,46.9451667 L39.1666667,46.9451667 C40.2482243,46.9451667 41.125,45.9498589 41.125,44.7220845 L41.125,22.2822926 C40.4887822,22.4116582 39.8442868,22.4815492 39.198,22.4912623 Z"></path>
                                                </g>
                                            </g>
                                        </g>
                                    </g>
                                </svg>
                            </a>
                        </li>
                        <li class="breadcrumb-item text-sm opacity-5 text-dark">Principal</li>
                        <li class="breadcrumb-item text-sm opacity-10 text-dark">Asistentes</li>
                    </ol>
                </nav>
                <div class="sidenav-toggler sidenav-toggler-inner d-xl-block d-none ">
                    <a href="javascript:;" class="nav-link text-body p-0">
                        <div class="sidenav-toggler-inner">
                            <i class="sidenav-toggler-line"></i>
                            <i class="sidenav-toggler-line"></i>
                            <i class="sidenav-toggler-line"></i>
                        </div>
                    </a>
                </div>
                <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4" id="navbar">
                    <div class="ms-md-auto pe-md-3 d-flex align-items-center">
                    </div>
                    <ul class="navbar-nav  justify-content-end">
                        <li class="nav-item d-flex align-items-center">
                            <a href="/Login/cerrarSession" class="nav-link text-body font-weight-bold px-0">
                                <i class="fa fa-power-off me-sm-1"></i>
                                <span class="d-sm-inline d-none">Logout</span>
                            </a>
                        </li>
                    </ul>
                    <ul class="navbar-nav  justify-content-end">
                        <!-- <li class="nav-item d-flex align-items-center">
                            <a href="/Login/" class="nav-link text-body font-weight-bold px-0" >
                                <i class="fa fa-user me-sm-1"></i>
                                <span class="d-sm-inline d-none">Sign In</span>
                            </a>
                        </li> -->

                        <li class="nav-item d-xl-none ps-3 d-flex align-items-center">
                            <a href="javascript:;" class="nav-link text-body p-0" id="iconNavbarSidenav">
                                <div class="sidenav-toggler-inner">
                                    <i class="sidenav-toggler-line"></i>
                                    <i class="sidenav-toggler-line"></i>
                                    <i class="sidenav-toggler-line"></i>
                                </div>
                            </a>
                        </li>
                        <li class="nav-item px-2 d-flex align-items-center">

                        </li>
                        <!-- <li class="nav-item dropdown pe-2 d-flex align-items-center">
                            <a href="javascript:;" class="nav-link text-body p-0" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fa fa-bell cursor-pointer"></i>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end px-2 py-3 me-sm-n4" aria-labelledby="dropdownMenuButton">
                                <li class="mb-2">
                                    <a class="dropdown-item border-radius-md" href="javascript:;">
                                        <div class="d-flex py-1">
                                            <div class="my-auto">
                                                <img src="../../assets/img/team-2.jpg" class="avatar avatar-sm  me-3 " alt="user image">
                                            </div>
                                            <div class="d-flex flex-column justify-content-center">
                                                <h6 class="text-sm font-weight-normal mb-1">
                                                    <span class="font-weight-bold">New message</span> from Laur
                                                </h6>
                                                <p class="text-xs text-secondary mb-0">
                                                    <i class="fa fa-clock me-1"></i>
                                                    13 minutes ago
                                                </p>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                                <li class="mb-2">
                                    <a class="dropdown-item border-radius-md" href="javascript:;">
                                        <div class="d-flex py-1">
                                            <div class="my-auto">
                                                <img src="../../assets/img/small-logos/logo-spotify.svg" class="avatar avatar-sm bg-gradient-dark  me-3 " alt="logo spotify">
                                            </div>
                                            <div class="d-flex flex-column justify-content-center">
                                                <h6 class="text-sm font-weight-normal mb-1">
                                                    <span class="font-weight-bold">New album</span> by Travis Scott
                                                </h6>
                                                <p class="text-xs text-secondary mb-0">
                                                    <i class="fa fa-clock me-1"></i>
                                                    1 day
                                                </p>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item border-radius-md" href="javascript:;">
                                        <div class="d-flex py-1">
                                            <div class="avatar avatar-sm bg-gradient-secondary  me-3  my-auto">
                                                <svg width="12px" height="12px" viewBox="0 0 43 36" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                                                    <title>credit-card</title>
                                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                        <g transform="translate(-2169.000000, -745.000000)" fill="#FFFFFF" fill-rule="nonzero">
                                                            <g transform="translate(1716.000000, 291.000000)">
                                                                <g transform="translate(453.000000, 454.000000)">
                                                                    <path class="color-background" d="M43,10.7482083 L43,3.58333333 C43,1.60354167 41.3964583,0 39.4166667,0 L3.58333333,0 C1.60354167,0 0,1.60354167 0,3.58333333 L0,10.7482083 L43,10.7482083 Z" opacity="0.593633743"></path>
                                                                    <path class="color-background" d="M0,16.125 L0,32.25 C0,34.2297917 1.60354167,35.8333333 3.58333333,35.8333333 L39.4166667,35.8333333 C41.3964583,35.8333333 43,34.2297917 43,32.25 L43,16.125 L0,16.125 Z M19.7083333,26.875 L7.16666667,26.875 L7.16666667,23.2916667 L19.7083333,23.2916667 L19.7083333,26.875 Z M35.8333333,26.875 L28.6666667,26.875 L28.6666667,23.2916667 L35.8333333,23.2916667 L35.8333333,26.875 Z"></path>
                                                                </g>
                                                            </g>
                                                        </g>
                                                    </g>
                                                </svg>
                                            </div>
                                            <div class="d-flex flex-column justify-content-center">
                                                <h6 class="text-sm font-weight-normal mb-1">
                                                    Payment successfully completed
                                                </h6>
                                                <p class="text-xs text-secondary mb-0">
                                                    <i class="fa fa-clock me-1"></i>
                                                    2 days
                                                </p>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                            </ul>
                        </li> -->
                    </ul>
                </div>
            </div>
        </nav>
        <!-- End Navbar -->

        <div class="container-fluid py-4">
            <div class=" mt-7 mb-4">
                <div class="card card-body mt-n6 overflow-hidden">
                    <div class="row gx-4">
                        <div class="col-auto">
                            <div class="bg-gradient-red avatar avatar-xl position-relative">
                                <!-- <img src="../../assets/img/bruce-mars.jpg" alt="profile_image" class="w-100 border-radius-lg shadow-sm"> -->
                                <span class="fa fa-users" style="font-size: xx-large;"></span>
                            </div>
                        </div>
                        <div class="col-auto my-auto">
                            <div class="h-100">
                                <h5 class="mb-1">
                                    Asistentes ASOFARMA (Invitados)
                                </h5>
                                <p class="mb-0 font-weight-bold text-sm">
                                </p>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6 my-sm-auto ms-sm-auto me-sm-0 mx-auto mt-3">
                            <div class="nav-wrapper position-relative end-0">
                                <ul class="nav nav-pills nav-fill p-1 bg-transparent" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link mb-0 px-0 py-1 active" href="#Invitados" data-bs-toggle="tab" href="javascript:;" role="tab" aria-selected="true">
                                            <span class="fa fa-door-open"></span>
                                            <span class="ms-1">Acceso Invitados</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <div class="row">
                <div class="col-12">
                    <div class="card">

                        <div class="card-header pb-0">
                            <div class="d-lg-flex">
                                <div>
                                    <p class="text-sm mb-0">
                                        En esta sección se podran visualizar todos los usuarios que han finalizado su registro, si usted desea ver quienes no han terminado el registro dirijasé a la pestaña nuevos accesos
                                    </p>

                                </div>
                               
                                <div class="ms-auto my-auto mt-lg-0 mt-4">
                                    <div class="ms-auto my-auto">

                                        <div class="modal fade" id="import" tabindex="-1" aria-hidden="true">
                                            <div class="modal-dialog mt-lg-10">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="ModalLabel">Import CSV</h5>
                                                        <i class="fas fa-upload ms-3"></i>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <p>You can browse your computer for a file.</p>
                                                        <input type="text" placeholder="Browse file..." class="form-control mb-3">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox" value="" id="importCheck" checked="">
                                                            <label class="custom-control-label" for="importCheck">I accept the terms and conditions</label>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn bg-gradient-secondary btn-sm" data-bs-dismiss="modal">Close</button>
                                                        <button type="button" class="btn bg-gradient-primary btn-sm">Upload</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-3 col-sm-12">
                                <div>
                                    <form class="form-inline my-2 my-lg-0" action="/Asistentes/buscarUsuario" method="post" style="display:flex;">
                                        <input class="form-control mr-sm-2" type="search" id="search" name="search" placeholder="Search" aria-label="Search">
                                        <button class="btn btn-success my-2 my-sm-0" type="submit">Search</button>
                                    </form>
                                </div>
                                </div>
                            </div>
                            
                        </div>
                        <div class="card-body px-0 pb-0">
                            <div class="tab-content" id="v-pills-tabContent">
                                <div class="tab-pane fade show position-relative active height-350 border-radius-lg" id="Invitados" role="tabpanel" aria-labelledby="Invitados">
                                    <div class="table-responsive p-0">
                                        <table class="align-items-center mb-0 table table-borderless" id="user_list_table">
                                            <thead class="thead-light">
                                                <tr>

                                                    <th class="text-uppercase text-secondary text-center text-xxs font-weight-bolder opacity-7">Usuario</th>
                                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Otros Datos</th>
                                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Status</th>
                                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Acciones</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php echo $tabla;
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                            </div>

                        </div>
                    </div>
                </div>
            </div>

            <!-- <div class="row">
                <div class="col-12">
                    <div class="card">
                        
                        <div class="card-header pb-0">
                            <div class="d-lg-flex">
                                <div>
                                    <p class="text-sm mb-0">
                                        En esta sección se podran visualizar todos los usuarios que han finalizado su registro, si usted desea ver quienes no han terminado el registro dirijasé a la pestaña nuevos accesos
                                    </p>
                                </div>
                                <div class="ms-auto my-auto mt-lg-0 mt-4">
                                    <div class="ms-auto my-auto">
                                       
                                        <div class="modal fade" id="import" tabindex="-1" aria-hidden="true">
                                            <div class="modal-dialog mt-lg-10">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="ModalLabel">Import CSV</h5>
                                                        <i class="fas fa-upload ms-3"></i>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <p>You can browse your computer for a file.</p>
                                                        <input type="text" placeholder="Browse file..." class="form-control mb-3">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox" value="" id="importCheck" checked="">
                                                            <label class="custom-control-label" for="importCheck">I accept the terms and conditions</label>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn bg-gradient-secondary btn-sm" data-bs-dismiss="modal">Close</button>
                                                        <button type="button" class="btn bg-gradient-primary btn-sm">Upload</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body px-0 pb-0">
                            <div class="tab-content" id="v-pills-tabContent">
                                <div class="tab-pane fade show position-relative active height-350 border-radius-lg" id="Invitados" role="tabpanel" aria-labelledby="Invitados">
                                    <div class="table-responsive p-0">
                                        <table class="align-items-center mb-0 table table-borderless" id="user_list_table">
                                            <thead class="thead-light">
                                                <tr>

                                                    <th class="text-uppercase text-secondary text-center text-xxs font-weight-bolder opacity-7">Usuario</th>
                                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Otros Datos</th>
                                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Status</th>
                                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Acciones</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            <?php //echo $tabla; 
                                            ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                            </div>

                        </div>
                    </div>
                </div>
            </div> -->

            <footer class="footer pt-3  ">
                <div class="container-fluid">
                    <div class="row align-items-center justify-content-lg-between">
                        <div class="col-lg-6 mb-lg-0 mb-4">
                            <div class="copyright text-center text-sm text-muted text-lg-start">
                                © <script>
                                    document.write(new Date().getFullYear())
                                </script>,
                                made with <i class="fa fa-heart"></i> by
                                <a href="https://www.grupolahe.com" class="font-weight-bold" target="_blank">Grupo LAHE</a>
                            </div>
                        </div>
                    </div>
                </div>
            </footer>

    </main>
</body>

<?php echo $footer; ?>

<script>
    if (window.history.replaceState) { // verificamos disponibilidad
    window.history.replaceState(null, null, window.location.href);
}
</script>

<script src="//cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js" defer></script>
<link rel="stylesheet" href="//cdn.datatables.net/1.11.4/css/jquery.dataTables.min.css" />

<script>
    $(document).ready(function() {
        $('#user_list_table').DataTable({
            "drawCallback": function(settings) {
                $('.current').addClass("btn bg-gradient-danger btn-rounded").removeClass("paginate_button");
                $('.paginate_button').addClass("btn").removeClass("paginate_button");
                $('.dataTables_length').addClass("m-4");
                $('.dataTables_info').addClass("mx-4");
                $('.dataTables_filter').addClass("m-4");
                $('input').addClass("form-control");
                $('select').addClass("form-control");
                $('.previous.disabled').addClass("btn-outline-danger opacity-5 btn-rounded mx-2");
                $('.next.disabled').addClass("btn-outline-danger opacity-5 btn-rounded mx-2");
                $('.previous').addClass("btn-outline-danger btn-rounded mx-2");
                $('.next').addClass("btn-outline-danger btn-rounded mx-2");
                $('a.btn').addClass("btn-rounded");
            },
            "language": {

                "sProcessing": "Procesando...",
                "sLengthMenu": "Mostrar _MENU_ registros",
                "sZeroRecords": "No se encontraron resultados",
                "sEmptyTable": "Ningún dato disponible en esta tabla",
                "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
                "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
                "sInfoPostFix": "",
                "sSearch": "Buscar:",
                "sUrl": "",
                "sInfoThousands": ",",
                "sLoadingRecords": "Cargando...",
                "oPaginate": {
                    "sFirst": "Primero",
                    "sLast": "Último",
                    "sNext": "Siguiente",
                    "sPrevious": "Anterior"
                },
                "oAria": {
                    "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
                    "sSortDescending": ": Activar para ordenar la columna de manera descendente"
                }

            }
        });

        $('#user_list_table_faltante').DataTable({
            "drawCallback": function(settings) {
                $('.current').addClass("btn bg-gradient-danger btn-rounded").removeClass("paginate_button");
                $('.paginate_button').addClass("btn").removeClass("paginate_button");
                $('.dataTables_length').addClass("m-4");
                $('.dataTables_info').addClass("mx-4");
                $('.dataTables_filter').addClass("m-4");
                $('input').addClass("form-control");
                $('select').addClass("form-control");
                $('.previous.disabled').addClass("btn-outline-danger opacity-5 btn-rounded mx-2");
                $('.next.disabled').addClass("btn-outline-danger opacity-5 btn-rounded mx-2");
                $('.previous').addClass("btn-outline-danger btn-rounded mx-2");
                $('.next').addClass("btn-outline-danger btn-rounded mx-2");
                $('a.btn').addClass("btn-rounded");
            },
            "language": {

                "sProcessing": "Procesando...",
                "sLengthMenu": "Mostrar _MENU_ registros",
                "sZeroRecords": "No se encontraron resultados",
                "sEmptyTable": "Ningún dato disponible en esta tabla",
                "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
                "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
                "sInfoPostFix": "",
                "sSearch": "Buscar:",
                "sUrl": "",
                "sInfoThousands": ",",
                "sLoadingRecords": "Cargando...",
                "oPaginate": {
                    "sFirst": "Primero",
                    "sLast": "Último",
                    "sNext": "Siguiente",
                    "sPrevious": "Anterior"
                },
                "oAria": {
                    "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
                    "sSortDescending": ": Activar para ordenar la columna de manera descendente"
                }

            }
        });

        $(".btn_download").on("click", function(event) {
            event.preventDefault();
            var valueButton = $(this).attr('id');
            var code = $(this).attr('data-value');
            var id_constancia = $(this).attr('data-id');

            document.getElementById('a-download' + id_constancia).click();


            $.ajax({
                url: "/Home/enviarEmail",
                type: "POST",
                data: {
                    code: code
                },
                cache: false,
                dataType: "json",
                // contentType: false,
                // processData: false,
                beforeSend: function() {
                    console.log("Procesando....");

                },
                success: function(respuesta) {
                    console.log(respuesta);

                    Swal.fire(
                        'OK',
                        'Your certificate has been sent !!!',
                        'Success'
                    );

                },
                error: function(respuesta) {
                    console.log(respuesta);
                }

            });

        });


        $('table#user_list_table').on("click", "button.btn_qr", function(event) {
            event.preventDefault();

            var valueButton = $(this).val();
            $(this).hide();

            $.ajax({
                url: "/Asistentes/generaterQr",
                type: "POST",
                data: {
                    id_ticket_virtual: valueButton
                },
                cache: false,
                dataType: "json",
                // contentType: false,
                // processData: false,
                beforeSend: function() {
                    console.log("Procesando....");

                },
                success: function(respuesta) {
                    //console.log(respuesta);

                    //boton descargar
                    $("#btn-download" + valueButton).attr("data-id", respuesta.id_constancia);
                    $("#btn-download" + valueButton).attr("data-value", respuesta.code);
                    $("#btn-download" + valueButton).removeClass("d-none");
                    $("#btn-download" + valueButton).attr("href", respuesta.ruta_constancia);
                    //$("#btn-download"+valueButton).attr("target", "_blank");

                    // a de descargar pdf
                    $("#a-download" + valueButton).attr("href", respuesta.ruta_constancia);
                    $("#a-download" + valueButton).attr("download", "");

                },
                error: function(respuesta) {
                    console.log(respuesta);
                }

            });
        });

    });
</script>