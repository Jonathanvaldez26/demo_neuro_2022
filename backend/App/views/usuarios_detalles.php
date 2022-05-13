<?php echo $header; ?>
<title>
    Asistentes Detalles - <?php echo $detalles_registro['nombre'] . ' ';
                            echo $detalles_registro['segundo_nombre'] . ' ';
                            echo $detalles_registro['apellido_paterno'] . ' ';
                            echo $detalles_registro['apellido_materno']; ?> - MUSA - GRUPO LAHE
</title>

<body class="g-sidenav-show  bg-gray-100">
    <?php echo $asideMenu; ?>
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
                        <li class="breadcrumb-item text-sm opacity-5"><a class="text-dark" href="/Asistentes/">Asistentes</a></li>
                        <li class="breadcrumb-item text-sm opacity-10 text-dark">Detalles Cursos</li>
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
            <div class="row">
                <div class="col-lg-12 mx-auto">
                    <div class="card mb-4">
                        <div class="card-header p-3 pb-0">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6>Detalles - Asistente ASOFARMA</h6>
                                    <!-- <p class="text-sm mb-0">
                                        No. Asistente: <b><?php echo $id_asistente; ?></b>
                                    </p> -->
                                    <p class="text-sm mb-0">
                                        Fecha de Alta: <b><?php echo $detalles_registro['fecha_alta']; ?></b>
                                    </p>
                                    <p class="text-sm">
                                        Usuario: <b><?php echo $detalles['usuario']; ?></b>
                                    </p>
                                </div>
                                <!-- <a href="javascript:;" class="btn bg-gradient-secondary ms-auto mb-0">Invoice</a> -->
                            </div>
                        </div>
                        <div class="card-body p-3 pt-0">
                            <div class="row d-flex justify-content-center">
                                <!-- <div class="col-lg-3 col-md-3 col-12">
                                    <h6 class="mb-3">Log</h6>
                                    <div class="timeline timeline-one-side scroll-log">
                                        <div class="timeline-block mb-4">
                                            <label for="chk-0" class="timeline-step m-0">
                                                <i class="fa fa-bell text-warning  text-gradient text-secondary"></i>
                                            </label>
                                            <input class="chk" type="checkbox" id="chk-0">
                                            <label for="chk-0" class="timeline-content">
                                                <h6 class="text-dark text-sm font-weight-bold mb-0">Asistente received</h6>
                                            </label><br>
                                            <label for="chk-0" id="divss" class="timeline-content">
                                                <p class="text-secondary font-weight-bold text-xs mt-1 mb-0">22 DEC 7:20 AM</p>
                                            </label>
                                        </div>
                                        <div class="timeline-block mb-4">
                                            <label for="chk-1" class="timeline-step m-0">
                                                <i class="fa fa-pills text-danger text-gradient text-secondary"></i>
                                            </label>
                                            <input class="chk" type="checkbox" id="chk-1">
                                            <label for="chk-1" class="timeline-content">
                                                <h6 class="text-dark text-sm font-weight-bold mb-0">Generate Asistente id #1832412</h6>
                                            </label><br>
                                            <label for="chk-1" id="divss" class="timeline-content">
                                                <p class="text-secondary font-weight-bold text-xs mt-1 mb-0">22 DEC 7:21 AM</p>
                                            </label>
                                        </div>
                                        <div class="timeline-block mb-4">
                                            <label for="chk-2" class="timeline-step m-0">
                                                <i class="fa fa-check text-info text-gradient text-secondary"></i>
                                            </label>
                                            <input class="chk" type="checkbox" id="chk-2">
                                            <label for="chk-2" class="timeline-content">
                                                <h6 class="text-dark text-sm font-weight-bold mb-0">Asistente transmited to courier</h6>
                                            </label><br>
                                            <label for="chk-2" id="divss" class="timeline-content">
                                                <p class="text-secondary font-weight-bold text-xs mt-1 mb-0">22 DEC 8:10 AM</p>
                                            </label>
                                        </div>
                                        <div class="timeline-block mb-3">
                                            <label for="chk-3" class="timeline-step m-0">
                                                <i class="fa fa-virus text-success text-gradient"></i>
                                            </label>
                                            <input class="chk" type="checkbox" id="chk-3">
                                            <label for="chk-3" class="timeline-content">
                                                <h6 class="text-dark text-sm font-weight-bold mb-0">Asistente delivered</h6>
                                            </label><br>
                                            <label for="chk-3" id="divss" class="timeline-content">
                                                <p class="text-secondary font-weight-bold text-xs mt-1 mb-0">22 DEC 4:54 PM</p>
                                            </label>
                                        </div>
                                    </div>
                                </div> -->
                                <div class="col-md-9 col-12">
                                    <hr class="horizontal dark mt-0 mb-4">
                                    <div class="row">
                                        <div class="col-lg-6 col-md-6 col-12">
                                            <div class="d-flex">
                                                <div>
                                                    <?php echo $img_asistente; ?>
                                                </div>
                                                <div>
                                                    <span class="text-lg font-weight-bold mb-0 mt-2"><?php echo $detalles_registro['nombre'] . ' ';
                                                                                                        echo $detalles_registro['segundo_nombre'] . ' ';
                                                                                                        echo $detalles_registro['apellido_paterno'] . ' ';
                                                                                                        echo $detalles_registro['apellido_materno']; ?></span>&nbsp;&nbsp;&nbsp;<span class="badge badge-sm bg-gradient-success"> Activo</span>
                                                    <br> <br>
                                                    <p class="text-sm mb-3"></p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-12 my-auto text-end">

                                            <form class="form-horizontal" action="" method="POST">
                                                <button class="btn bg-gradient-primary mb-0" type="button" title="Editar Asistente" data-toggle="modal" data-target="#editar-asistente"><i class="fa fa-edit"></i></button>

                                                <input id="input-email" type="text" class="form-control" value="<?php echo $email; ?>" readonly hidden>

                                            </form>
                                            <!-- <p class="text-sm mt-2 mb-0">Do you like the product? Leave us a review <a href="javascript:;">here</a>.</p> -->
                                        </div>
                                    </div>
                                    <hr class="horizontal dark mt-4 mb-4">
                                    <div class="row">

                                        <div class="col-lg-12 col-md-12 col-12 mt-4 mt-md-0">
                                            <h6 class="mb-3">Secciones</h6>
                                            <!-- <div class="card card-body border card-plain border-radius-lg d-flex align-items-center flex-row">
                                                    <img class="w-10 me-3 mb-0" src="/img/users_conave/8mVMLa56xh.png" alt="logo">
                                                    <img class="w-10 me-3 mb-0" src="https://upload.wikimedia.org/wikipedia/commons/thumb/a/a4/Mastercard_2019_logo.svg/1200px-Mastercard_2019_logo.svg.png" alt="logo">
                                                    <h6 class="mb-0">****&nbsp;&nbsp;&nbsp;****&nbsp;&nbsp;&nbsp;****&nbsp;&nbsp;&nbsp;7852</h6>
                                                    <button type="button" class="btn btn-icon-only btn-rounded btn-outline-secondary mb-0 ms-2 btn-sm d-flex align-items-center justify-content-center ms-auto" data-bs-toggle="tooltip" data-bs-placement="bottom" title="" data-bs-original-title="We do not store card details">
                                                    <i class="fas fa-info" aria-hidden="true"></i>
                                                    </button>
                                                </div> -->
                                            <!-- <h6 class="mb-3 mt-4">Billing Information</h6> -->
                                            <div class="mt-2 nav-wrapper active position-relative end-0">
                                                <ul class="nav nav-pills nav-fill p-1 bg-transparent" role="tablist">
                                                    <li class="nav-item">
                                                        <a class="nav-link mb-0 px-0 py-1  active" href="#cam4" data-bs-toggle="tab" role="tab" aria-selected="true">
                                                            <span class="fa fa-syringe"></span>
                                                            <span class="ms-1">Cursos </span>
                                                        </a>
                                                    </li>
                                                    <!-- <li class="nav-item">
                                                        <a class="nav-link mb-0 px-0 py-1" href="#cam3" data-bs-toggle="tab" role="tab" aria-selected="false">
                                                            <span class="fa fa-virus"></span>
                                                            <span class="ms-1">Covid</span>
                                                        </a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a class="nav-link mb-0 px-0 py-1" href="#cam1" data-bs-toggle="tab" role="tab" aria-selected="false">
                                                            <span class="fa fa-plane"></span>
                                                            <span class="ms-1">Vuelos</span>
                                                        </a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a class="nav-link mb-0 px-0 py-1" href="#cam2" data-bs-toggle="tab" role="tab" aria-selected="false">
                                                            <span class="fa fa-ticket"></span>
                                                            <span class="ms-1">Ticket Virtual</span>
                                                        </a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a class="nav-link mb-0 px-0 py-1" href="#cam5" data-bs-toggle="tab" role="tab" aria-selected="false">
                                                            <span class="fa fa-ticket"></span>
                                                            <span class="ms-1">Impresión</span>
                                                        </a>
                                                    </li> -->
                                                </ul>
                                            </div>

                                            <div class="tab-content" id="v-pills-tabContent">
                                                <div class="tab-pane fade show position-relative height-350 border-radius-lg" id="cam2" role="tabpanel" aria-labelledby="cam2">
                                                    <style>
                                                        #main_ticket {
                                                            /* margin-top: 20px; */
                                                            text-align: center;
                                                        }
                                                    </style>
                                                    <div>
                                                        <?php echo $btn_genQr; ?>
                                                        <?php echo $btn_clave; ?>
                                                    </div>
                                                    <ul class="list-group mt-3">
                                                        <li class="list-group-item border-0 p-4 mb-2 bg-gray-100 border-radius-lg ">
                                                            <h3><?php echo $msg_clave; ?></h3>
                                                            <div class="row">
                                                                <!-- <div class="col-md-2 col-12 text-center"> -->
                                                                <!-- <div class="d-flex flex-column "> -->
                                                                <!-- <h3 class="mb-3 text-sm">Su Código es: </h3> -->
                                                                <img src="/qrs/<?php echo $clave_user; ?>.png" alt="" hidden>
                                                                <input id="codigo-qr" type="text" value="/qrs/<?php echo $clave_user; ?>.png" hidden readonly>
                                                                <!-- </div> -->
                                                                <!-- </div> -->
                                                                <input id="nombre-canvas" type="text" value="<?php echo $nombre; ?>" hidden readonly>
                                                                <input id="apellidos-canvas" type="text" value="<?php echo $apellidos; ?>" hidden readonly>
                                                                <div class="col-md-12 col-12 text-center">
                                                                    <div id="main_ticket" hidden>
                                                                        <canvas id="canvas_ticket" width="1220" height="457" name="ticket-<?php echo $clave_user; ?>" alt="ticket-<?php echo $clave_user; ?>" style="background: white; width: -webkit-fill-available;">
                                                                            <img src="/img/boleto_musa.jpg" alt="">
                                                                        </canvas> <!--  background-image: url('/img/ticket.jpg'); -->
                                                                    </div>
                                                                </div>

                                                            </div>
                                                        </li>
                                                    </ul>
                                                </div>

                                                <div class="tab-pane fade position-relative height-350 border-radius-lg" id="cam1" role="tabpanel" aria-labelledby="cam1">
                                                    <div class="row mt-4">
                                                        <div class="card mb-4">
                                                            <div class="card-header pb-0">
                                                                <h6></h6>
                                                            </div>
                                                            <div class="card-body px-0 pt-0 pb-2">
                                                                <div class="table-responsive p-0">
                                                                    <table id="table_aprobado" class="table align-items-center mb-0 table_rechazado">
                                                                        <thead>
                                                                            <tr>
                                                                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Status</th>
                                                                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Nombre del Asistente</th>
                                                                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Datos Comprobante</th>
                                                                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Documento</th>

                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>

                                                                            <!-- tabla ticket -->

                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="tab-pane fade position-relative height-350 border-radius-lg" id="cam3" role="tabpanel" aria-labelledby="cam3">
                                                    <div class="row mt-4">
                                                        <div class="card mb-4">
                                                            <div class="card-header pb-0">
                                                                <h6></h6>
                                                            </div>
                                                            <div class="card-body px-0 pt-0 pb-2">
                                                                <div class="table-responsive p-0">
                                                                    <table id="table_aprobado" class="table align-items-center mb-0 table_rechazado">
                                                                        <thead>
                                                                            <tr>
                                                                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Status</th>
                                                                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Nombre del Asistente</th>
                                                                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Datos Comprobante</th>
                                                                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Documento</th>

                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>

                                                                            <?php echo $tabla_prueba_covid; ?>

                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="tab-pane fade position-relative height-350 border-radius-lg active show" id="cam4" role="tabpanel" aria-labelledby="cam4">
                                                    <div class="row mt-4">
                                                        <div class="card mb-4">
                                                            <div class="card-header pb-0">
                                                                <h6></h6>
                                                            </div>
                                                            <div class="card-body px-0 pt-0 pb-2">
                                                                <div class="table-responsive p-0">
                                                                    <table class="align-items-center mb-0 table table-borderless" id="user_cursos">
                                                                        <thead class="thead-light">
                                                                            <tr>

                                                                                <th class="text-uppercase text-secondary text-center text-xxs font-weight-bolder opacity-7">Usuario</th>
                                                                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Otros datos</th>
                                                                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Acciones</th>
                                                                                <!-- <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Imprimir</th> -->
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            <?php echo $tablaUsersCursos;
                                                                            ?>
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="tab-pane fade show position-relative height-350 border-radius-lg" id="cam5" role="tabpanel" aria-labelledby="cam2">
                                                    <style>
                                                        #main_ticket {
                                                            /* margin-top: 20px; */
                                                            text-align: center;
                                                        }
                                                    </style>

                                                    <ul class="list-group mt-3">
                                                        <li class="list-group-item border-0 p-4 mb-2 bg-gray-100 border-radius-lg ">
                                                            <h3><?php echo $msg_clave; ?></h3>
                                                            <div class="row">
                                                                <a href='' target='_blank' style='display:none;' id='a_abrir_etiqueta'>abrir</a>

                                                                <div class="col-12 col-md-6">
                                                                    <div class="row">
                                                                        <div class="col-12 col-md-10">
                                                                            <h4>Gafete</h4>
                                                                            <?php echo $btn_gafete; ?>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="col-12 col-md-6">
                                                                    <form action="" id="form_etiquetas">
                                                                        <div class="row">
                                                                            <input type="hidden" id="clave_ra" name="clave_ra" value="<?php echo $clave_ra; ?>">
                                                                            <h4>Etiquetas</h4>
                                                                            <div class="col-md-6">
                                                                                <label>Número de Habitación</label>
                                                                                <input type="number" id="no_habitacion" name="no_habitacion" class="form-control" />
                                                                            </div>

                                                                            <div class="col-md-6">
                                                                                <label>Número de etiquetas</label>
                                                                                <input type="number" id="no_etiquetas" name="no_etiquetas" class="form-control" />
                                                                            </div>

                                                                            <div class="col-md-4 m-auto">
                                                                                <button id="btn_imprimir_etiquetas" class="btn btn-info mt-4" type="submit">Imprimir Etiquetas</button>
                                                                            </div>
                                                                        </div>

                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </li>
                                                    </ul>
                                                </div>

                                            </div>

                                        </div> <!-- <div class="d-flex justify-conts-2 font-weight-bold">Mediana</span> -->
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="editar-asistente" tabindex="-1" role="dialog" aria-labelledby="editar-asistenteLabel" aria-hidden="true">
            <div class="modal-dialog" role="document" style="max-width: 800px;">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editar-asistenteLabel">Editar Asistente</h5>
                        <button type="button" class="btn bg-gradient-danger" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form class="form-horizontal" id="update_detalles" action="" method="POST">
                            <div class="card-body pt-0">
                                <div class="row">
                                    <div class="col-12 col-lg-6">
                                        <!-- <input type="text" id="id_registro" name="id_registro" value="<?= $userData['id_registro'] ?> "> -->
                                        <label class="form-label">Nombre *</label>
                                        <div class="input-group">
                                            <input id="nombre" name="nombre" maxlength="29" pattern="[a-zA-Z ÑñáÁéÉíÍóÚ]*{2,254}" class="form-control" type="text" placeholder="Alec" required="" onfocus="focused(this)" onfocusout="defocused(this)" value="<?= $detalles_registro['nombre'] ?>" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();">
                                        </div>
                                    </div>
                                    <div class="col-12 col-lg-6">
                                        <label class="form-label">Segundo Nombre </label>
                                        <div class="input-group">
                                            <input id="segundo_nombre" name="segundo_nombre" maxlength="49" pattern="[a-zA-Z ÑñáÁéÉíÍóÚ]*{2,254}" class="form-control" type="text" placeholder="Alec" onfocus="focused(this)" onfocusout="defocused(this)" value="<?= $detalles_registro['segundo_nombre'] ?>" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();">
                                        </div>
                                    </div>

                                </div>

                                <div class="row">

                                    <div class="col-12 col-lg-6">
                                        <label class="form-label">Apellido Paterno *</label>
                                        <div class="input-group">
                                            <input id="apellido_paterno" name="apellido_paterno" maxlength="29" pattern="[a-zA-Z ÑñáÁéÉíÍóÚ]*{2,254}" class="form-control" type="text" placeholder="Thompson" required="required" onfocus="focused(this)" onfocusout="defocused(this)" value="<?= $detalles_registro['apellido_paterno'] ?>" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();">
                                        </div>
                                    </div>

                                    <div class="col-12 col-lg-6">
                                        <label class="form-label">Apellido Materno *</label>
                                        <div class="input-group">
                                            <input id="apellido_materno" name="apellido_materno" maxlength="29" pattern="[a-zA-Z ÑñáÁéÉíÍóÚ]*{2,254}" class="form-control" type="text" placeholder="Thompson" required="required" onfocus="focused(this)" onfocusout="defocused(this)" value="<?= $detalles_registro['apellido_materno'] ?>" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();">
                                        </div>
                                    </div>

                                </div>

                                <div class="row">
                                    <div class="col-12 col-lg-6">
                                        <label class="form-label mt-4">Fecha de Nacimiento * </label>
                                        <input type="date" class="form-control" id="fecha_nacimiento" name="fecha_nacimiento" required="" value="<?= $detalles_registro['fecha_nacimiento'] ?>">
                                    </div>

                                    <div class="col-lg-6 col-12">
                                        <label class="form-label mt-4">Número de Telefono *</label>
                                        <div class="input-group">
                                            <input id="telefono" name="telefono" minlength="10" maxlength="10" pattern="[0-9]" class="form-control" type="number" placeholder="+40 735 631 620" onfocus="focused(this)" onfocusout="defocused(this)" value="<?= $detalles_registro['telefono'] ?>" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-12 col-12">
                                        <label class="form-label mt-4">Email Registrado y Verificado *</label>
                                        <div class="input-group">
                                            <input id="email" name="email" maxlength="49" class="form-control" type="email" placeholder="example@email.com" onfocus="focused(this)" onfocusout="defocused(this)" value="<?= $detalles_registro['usuario'] ?>" readonly>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">

                                    <?php echo $res_alimenticias; ?>

                                    <!-- <div class="col-md-4">
                                        <label class="form-label mt-4">Alergias *</label>
                                        <input class="form-control" name="alergias" id="alergias" maxlength="149" name="alergias" data-color="dark" type="text" value="<?= $detalles_registro['alergias'] ?>" placeholder="" />
                                    
                                        <label class="form-label mt-4">Alergias Otro *</label>
                                        <input class="form-control" name="alergias_otro" id="alergias_otro" maxlength="149" name="alergias" data-color="dark" type="text" value="<?= $detalles_registro['alergias_otro'] ?>" placeholder="" />
                                    </div> -->


                                    <!-- <div class="col-md-4">
                                        <label class="form-label mt-4">Alergias Medicamento *</label>
                                        <input class="form-control" name="alergia_medicamento_cual" id="alergia_medicamento_cual" maxlength="149" name="alergias" data-color="dark" type="text" value="<?= $detalles_registro['alergia_medicamento_cual'] ?>" placeholder="" />
                                    </div> -->
                                </div>

                                <div class="row">
                                    <div class="button-row d-flex mt-4 col-12">
                                        <button class="btn bg-gradient-success ms-auto mb-0 mx-4" type="submit" title="Actualizar">Actualizar</button>
                                        <a class="btn bg-gradient-secondary mb-0 js-btn-prev" data-dismiss="modal" title="Prev">Cancelar</a>
                                    </div>
                                </div>
                            </div>

                    </div>
                    <!-- <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary">Save changes</button>
                    </div> -->
                </div>
            </div>
        </div>

    </main>
</body>

<script>
    $(document).ready(function() {
        // document.getElementById('main_ticket').removeAttribute('hidden');
        // app.loadPicture();

        let inicio = $('#barra_progreso').val();
        let duracion = $('#barra_progreso').attr('max');

        let porcentaje_num = (inicio*100)/parseInt(duracion);

        console.log("porcentaje "+porcentaje_num.toFixed(2));

        $('#usuarios a').addClass('active');
        $('#usuarios .fa-users').addClass('text-white');

        $("#form_etiquetas").on("submit", function(event) {
            event.preventDefault();
            var formData = new FormData(document.getElementById("form_etiquetas"));

            no_habitacion = $("#no_habitacion").val();
            clave_ra = $("#clave_ra").val();
            no_etiquetas = $("#no_etiquetas").val();

            console.log(no_habitacion);
            console.log(clave_ra);
            console.log(no_etiquetas);

            $("#a_abrir_etiqueta").attr("href", "/Asistentes/abrirpdf/" + clave_ra + "/" + no_etiquetas + "/" + no_habitacion);
            $("#a_abrir_etiqueta")[0].click();

        });

        var app = (function() {
            var canvas = document.getElementById('canvas_ticket');
            context = canvas.getContext('2d');

            var imgTicketFondo = new Image();
            imgTicketFondo.src = '/img/boleto_musa.jpg';

            imgTicketFondo.onload = function() {
                context.drawImage(imgTicketFondo, 0, 0);
            }

            // API
            public = {};

            // Public methods goes here...

            public.loadPicture = function() {

                // var imgTicketFondo = new Image();
                // imgTicketFondo.src = '/img/boleto_musa.jpg';

                // imgTicketFondo.onload = function() {
                //     context.drawImage(imgTicketFondo, 0, 0);
                // }

                context = canvas.getContext('2d');

                var imgCodeQr = new Image();
                imgCodeQr.src = $('#codigo-qr').val();

                imgCodeQr.onload = function() {
                    context.drawImage(imgTicketFondo, 0, 0);
                    context.drawImage(imgCodeQr, 870, 90);


                    var centerX = canvas.width / 2;
                    var centerY = canvas.height / 2;

                    context = canvas.getContext('2d');

                    context.font = "20pt Verdana";
                    context.fillStyle = "black";

                    context.fillText($('#nombre-canvas').val(), 280, centerY + 80);

                    context.font = "20pt Verdana";
                    context.fillStyle = "black";

                    context.fillText($('#apellidos-canvas').val(), 280, centerY + 110);
                }

            };

            return public;
        }());

        document.getElementById('main_ticket').removeAttribute('hidden');
        app.loadPicture();

        // $('#show_ticket').on('click', function(event) {
        //     // alert('Mostrar Ticket');
        //     // console.log('asdasdasdas');
        //     document.getElementById('main_ticket').removeAttribute('hidden');
        //     app.loadPicture();
        // })

        $('#generar_clave').on('click', function(event) {

            // Obtener id de utilerias asistentes del link
            var link_a = $(location).attr('href');
            var clave_a = link_a.substr(link_a.indexOf('Detalles/') + 9, link_a.length);

            let email_user = '';

            var formData = new FormData(document.getElementById("update_detalles"));
            for (var value of formData) {
                if (value.includes('email')) {
                    email_user = value[1];
                }
            }

            $.ajax({
                url: "/Asistentes/generarClave/" + email_user,
                type: "POST",
                data: formData,
                // dataType: 'json',
                beforeSend: function() {
                    console.log("Procesando....");


                },
                success: function(respuesta) {
                    // console.log(respuesta.status);

                    if (respuesta.status == 'success') {
                        if (respuesta.clave == 'ya_tiene') {
                            swal("!Ya tiene una clave generada!", "", "warning").
                            then((value) => {
                                //window.location.replace("/Asistentes")
                            });
                        } else {
                            swal("!Se generó la clave correctamente!", "", "success").
                            then((value) => {
                                window.location.replace("/Asistentes/Detalles/" + clave_a);
                            });
                        }
                        console.log(respuesta);
                        app.loadPicture();
                    } else {
                        swal("!No se pudo generar una clave para este usuario!", "", "warning").
                        then((value) => {
                            //window.location.replace("/Asistentes")
                        });
                    }
                },
                error: function(respuesta) {
                    console.log(respuesta.statuss);
                }

            });


        });

        $("#update_detalles").on("submit", function(event) {
            event.preventDefault();

            // alert("Hola");

            var formData = new FormData(document.getElementById("update_detalles"));
            for (var value of formData.values()) {
                console.log(value);
            }

            $.ajax({
                url: "/Asistentes/Actualizar",
                type: "POST",
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                beforeSend: function() {
                    console.log("Procesando....");


                },
                success: function(respuesta) {
                    // alert("Successs");
                    console.log(respuesta)
                    if (respuesta == 'success') {
                        Swal.fire({
                            title: "!Se actualizaron tus datos correctamente!",
                            html: '',
                            icon: "success",
                            timer: 1250,
                        }).
                        then((value) => {
                            window.location.reload();
                        });
                    } else {
                        Swal.fire({
                            title: '!Usted No Actualizó Nada!',
                            html: '',
                            icon: 'warning',
                            timer: 1000,
                        }).
                        then((value) => {
                            //window.location.replace("/Asistentes")
                        });
                    }
                },
                error: function(respuesta) {
                    console.log(respuesta);
                }

            });
        });

        $(".btn_quitar_user_curso").on("click", function() {
            var id_ac = $(this).attr('data-id');
            var nombre_user = $(this).attr('data-nombre-user');
            var nombre_curso = $(this).attr('data-nombre-curso');
            var porcentaje = $(this).attr('data-porcentaje')

            const SwalBootstrapMail = Swal.mixin({
                customClass: {
                    confirmButton: 'btn bg-gradient-info mx-2',
                    cancelButton: 'btn bg-gradient-danger mx-2'
                },
                buttonsStyling: false
            })

            SwalBootstrapMail.fire({
                title: '¿Estas seguro de eliminar el curso al usuario?',
                text: "Vas a quitarle el curso al usuario, cuenta con el "+porcentaje+" % de vizualización, una vez borrado se perderan los datos." ,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonText: 'Cancelar',
                confirmButtonText: 'Si'
            }).then((result) => {
                if (result.isConfirmed) {

                    //borrar aqui
                    $.ajax({
                        url: "/Cursos/deleteCourseUser",
                        type: "POST",
                        data: {
                            id_ac
                        },
                        beforeSend: function() {
                            console.log("Procesando....");
                        },
                        success: function(respuesta) {
                            console.log(respuesta);
                            if (respuesta == 'success') {

                                Swal.fire(
                                    '¡Se ha eliminado el curso ' + nombre_curso + ' al usuario ' + nombre_user + '!',
                                    '',
                                    'success'
                                ).then((data) => {
                                    // console.log();               
                                    window.location.reload();
                                })

                            } else {
                                Swal.fire(
                                    '!Falló!',
                                    'Hubo un error al borrar el curso',
                                    'error'
                                )
                            }

                        },
                        error: function(respuesta) {
                            console.log(respuesta);
                        }
                    });
                }
            })

        });


        $('input:radio[name="confirm_alergia"]').change(function() {
            if ($("#confirm_alergia_no").is(':checked')) {
                $(".medicamento_cual").css("display", "none");
                // $("#alergia_medicamento_cual").val("");
                $('#alergia_medicamento_cual').removeAttr('required');
            }

            if ($("#confirm_alergia_si").is(':checked')) {
                $(".medicamento_cual").css("display", "block");
                $("#alergia_medicamento_cual").attr('required', 'required');
            }
        });

        $('input:radio[name="restricciones_alimenticias"]').change(function() {
            if ($("#res_ali_5").is(':checked')) {
                $(".restricciones_alimenticias").css("display", "block");
                $("#restricciones_alimenticias_cual").attr('required', 'required');
            } else {
                $(".restricciones_alimenticias").css("display", "none");
                $('#restricciones_alimenticias_cual').removeAttr('required');
            }

        });
    });
</script>

<?php echo $footer; ?>