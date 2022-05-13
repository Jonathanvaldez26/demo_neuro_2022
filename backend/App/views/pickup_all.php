<?php echo $header; ?>
<body class="g-sidenav-show  bg-gray-100">
<aside class="bg-white-aside sidenav navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-3 " id="sidenav-main">
<div class="sidenav-header" style="margin-bottom: 30px;">
        <i class="fas fa-times p-3 cursor-pointer text-secondary opacity-5 position-absolute end-0 top-0 d-none d-xl-none" aria-hidden="true" id="iconSidenav"></i>
        <a class="navbar-brand m-0" href="/Principal/" target="_blank">
            <img src="/assets/img/favicon.png" class="navbar-brand-img h-100" alt="main_logo">
            <span class="ms-1 font-weight-bold"></span>
            <p style="margin-top: 15px;"><span class="fa fa-user" style="color: #344767"></span> <?php echo $_SESSION['nombre'];?></p>
        </a>
        
        
    </div>
    <hr class="horizontal dark mt-0">
    <div class="collapse navbar-collapse  w-auto h-auto h-100" id="sidenav-collapse-main">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a href="/Principal/" class="nav-link" role="button" aria-expanded="false">
                    <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center d-flex align-items-center justify-content-center  me-2">
                        <span class="fa fa-home" style="color: #344767"></span>
                    </div>
                    <span class="nav-link-text ms-1">Principal</span>
                </a>
            </li>
        
            <li class="nav-item">
                <a href="/Asistentes/" class="nav-link " aria-controls="applicationsExamples" role="button" aria-expanded="false">
                    <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center d-flex align-items-center justify-content-center  me-2">
                        <span class="fa fa-users" style="color: #344767"></span>
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
            <li class="nav-item">
                <a href="/PickUp/" class="nav-link active" aria-controls="ecommerceExamples" role="button" aria-expanded="false">
                    <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center d-flex align-items-center justify-content-center  me-2">
                        <span class="fa fa-bus" style="color: #fff"></span>
                    </div>
                    <span class="nav-link-text ms-1">PickUp</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="/Habitaciones/" class="nav-link " aria-controls="authExamples" role="button" aria-expanded="false">
                    <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center d-flex align-items-center justify-content-center  me-2">
                        <span class="fa fa-hotel" style="color: #344767"></span>
                    </div>
                    <span class="nav-link-text ms-1">Habitaciones</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="/Cenas/" class="nav-link " aria-controls="authExamples" role="button" aria-expanded="false">
                    <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center d-flex align-items-center justify-content-center  me-2">
                        <span class="fa fa-coffee" style="color: #344767"></span>
                    </div>
                    <span class="nav-link-text ms-1">Cenas</span>
                </a>
            </li>
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
                    <span class="nav-link-text ms-1">Pruebas Covid Asistentes</span>
                </a>
            </li>
            <li class="nav-item">
                <hr class="horizontal dark" />
                <h6 class="ps-4  ms-2 text-uppercase text-xs font-weight-bolder opacity-6">OTROS</h6>
            </li>
            <li class="nav-item">
                <a href="#applicationsExamples" class="nav-link " aria-controls="applicationsExamples" role="button" aria-expanded="false">
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
                                <span class="sidenav-normal"> Perfiles  </span>
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
                    <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="/Principal/">Principal</a></li>
                    <li class="breadcrumb-item text-sm text-dark active" aria-current="page">PickUp</li>
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
                </ul>
            </div>
        </div>
    </nav>
    <div class="container-fluid py-3 col-md-12">
        <div class="card card-body" id="profile">
            <div class="row justify-content-center align-items-center">
                <div class="col-auto">
                    <div class="bg-gradient-red avatar avatar-xl position-relative">
                        <!-- <img src="../../assets/img/bruce-mars.jpg" alt="profile_image" class="w-100 border-radius-lg shadow-sm"> -->
                        <span class="fa fa-bus" style="font-size: xx-large;"></span>
                    </div>
                </div>
                <div class="col-sm-auto col-8">
                    <div class="h-100">
                        <h5 class="mb-1 font-weight-bolder col-sm-auto col-8">
                            PickUp
                        </h5>
                        <p class="mb-0 font-weight-bold text-sm col-sm-auto col-8">
                            Registros Existentes
                        </p>
                    </div>
                </div>
                <div class="col-sm-auto ms-sm-auto mt-sm-0 mt-3 d-flex"></div>
            </div>
        </div>
        <br>
        <div class="d-flex m-0">
            <div class="ms-auto d-flex">
                <div class="pe-4 mt-1 position-relative">
                    <hr class="vertical dark mt-0">
                </div>
                <div class="ps-4">
                    <div class="panel-body" <?php echo $visible; ?>></div>
                    <button type="button" class="btn bg-gradient-info btn-icon-only mb-0 mt-3" data-toggle="modal" data-target="#Modal_Add"><i class="fa fa-plus" aria-hidden="true"></i></button>
                    <button type="button" class="btn bg-gradient-secondary btn-icon-only mb-0 mt-3" data-container="body" data-bs-toggle="popover" data-bs-placement="top" data-bs-content="Todo cambio que usted realice en el sistema será guardado con fecha, usuario y transacción.">
                        <span class="fa fa-info"></span>
                    </button>
                </div>
            </div>
        </div>
        <br>
        <div class="col-12">
            <div class="card">
                <div class="table-responsive text-center">
                    <table class="table align-items-center mb-0 table table-striped table-bordered" id="pickup-list">
                        <thead>
                            <tr>
                                <!-- <th><input type="checkbox" name="checkAll" id="checkAll" value=""/></th> -->
                                <!-- <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">ID</th> -->
                                <!-- <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">PickUp</th> -->
                                <!-- <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Clave</th> -->
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Asistente</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Fecha de Cita</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Hora de Cita</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Punto de Reunión</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Encargado</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Fecha de Alta</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php echo $tabla; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="Modal_Add"  role="dialog" aria-labelledby="Modal_AddLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="Modal_AddLabel">Agregar PickUp</h5>
                    <button type="button" class="btn btn-danger" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="POST" id="add_pickup" action="/PickUp/pickupAdd">
                        <div class="form-group row">
                            <div class="col-md-12 col-12" >
                                <label class="form-label">Asistente *</label>
                                <div class="input-group">
                                <select id="asistente" name="asistente" class="form-control select_2" required="" onfocus="focused(this)" onfocusout="defocused(this)" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();">
                                        <option value="" disabled selected>Seleccione un asistente</option>
                                        <?php echo $select_asist;?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6 col-12" >
                                <label class="form-label">Fecha de Cita *</label>
                                <div class="input-group">
                                    <input id="fecha_cita" name="fecha_cita" class="form-control" type="date" placeholder="Le Bon Vine" required="" onfocus="focused(this)" onfocusout="defocused(this)" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();">
                                </div>
                            </div>
                            <div class="col-md-6 col-12" >
                                <label class="form-label">Hora de Cita *</label>
                                <div class="input-group">
                                    <input id="hora_cita" name="hora_cita" class="form-control" type="time" placeholder="+52 55 1234 5678" required="" onfocus="focused(this)" onfocusout="defocused(this)" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();">
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12 col-12" >
                                <label class="form-label">Punto de reunión *</label>
                                <div class="input-group">
                                    <!-- <select id="punto_reunion" name="punto_reunion" class="form-control select_2" required="" onfocus="focused(this)" onfocusout="defocused(this)" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();">
                                        <option value="" disabled selected>Seleccione un asistente</option>
                                        <option value="punto" >punto de reunion</option>
                                    </select> -->
                                    <input id="punto_reunion" name="punto_reunion" class="form-control" type="text" placeholder="" required="" onfocus="focused(this)" onfocusout="defocused(this)" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();">
                                </div>
                            </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn bg-gradient-success">Agregar</button>
                        <button type="button" class="btn bg-gradient-secondary" data-dismiss="modal">Cancelar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <?php echo $modal; ?>
    </main></body>
    <script>
    function borrarPickUp(dato){
        $.ajax({
            url: "/PickUp/borrarPickUp/"+dato,
            type: "POST",
            dataType: 'json',
            beforeSend: function() {
                console.log("Procesando....");
                // alert('Se está borrando');
                
            },
            success: function(respuesta) {
                console.log(respuesta);
                console.log('despues de borrar');
                Swal.fire("¡Se eliminó correctamente!", "", "success").
                then((value) => {
                    window.location.reload();
                });
            },
            error: function(respuesta) {
                console.log(respuesta);
                // alert('Error');
                Swal.fire("¡Ha ocurrido un error al intentar eliminar el registro!", "", "warning").
                then((value) => {
                    window.location.reload();
                });
            }
        });
    }

    $(document).ready(function() {

        $('.select_2').select2();

        $('.add_pickup').on("submit", function(event) {
            event.preventDefault();
            var formData = $(this).serialize();
            console.log(formData);
            // for (var value of formData.values()) {
            //     console.log(value);
            // }
            $.ajax({
                url: "/PickUp/Actualizar",
                type: "POST",
                data: formData,
                beforeSend: function() {
                    console.log("Procesando....");
                },
                success: function(respuesta) {
                    console.log(respuesta);
                    if (respuesta == 'success') {
                        Swal.fire("¡Se ha actualizado correctamente el Pickup!", "", "success").
                        then((value) => {
                            window.location.reload();
                        });
                    } else {
                        swal("¡No se pudo actualizar correctamente el Pickup!", "", "warning").
                        then((value) => {
                            // window.location.replace("/ComprobantesVacunacion/")
                        });
                    }
                },
                error: function(respuesta) {
                    console.log(respuesta);
                }
            });
        });
    });
</script>
<?php echo $footer; ?>