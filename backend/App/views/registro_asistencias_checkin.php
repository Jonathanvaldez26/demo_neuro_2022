
<?php echo $header; ?>

<body class="g-sidenav-show  bg-gray-100">
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
    <!-- Navbar -->
    <div class="row">
        <div class="col-11 m-auto">
            <div class="mt-7 m-auto">
                <div class="card card-body mt-n6 overflow-hidden m-5">
                    <div class="row mb-0" >
                        <div class="col-auto">
                            <div class="bg-gradient-red avatar avatar-xl position-relative">
                                <!-- <img src="../../assets/img/bruce-mars.jpg" alt="profile_image" class="w-100 border-radius-lg shadow-sm"> -->
                                <span class="fa fa-bell" style="font-size: xx-large;"></span>
                            </div>
                        </div>
                        <div class="col-auto my-auto">
                            <div class="h-100">
                                <h5 class="mb-0">
                                    Listas de Asistencias:  
                                </h5>
                                <h6><b><?php echo $nombre;?></b> </h6>
                                <p class="mb-0 font-weight-bold text-sm">
                                    <?php echo $etiqueta_linea; ?>
                                </p>
                            </div>
                        </div>

                        <div class="col-lg-4 col-md-6 my-sm-auto ms-sm-auto me-sm-0 mx-auto mt-3">
                            <div class="nav-wrapper position-relative end-0">
                                <ul class="nav nav-pills nav-fill p-1 bg-transparent" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link mb-0 px-0 py-1 active" id="registro-tab" href="#cam1" data-bs-toggle="tab" href="javascript:;" role="tab" aria-selected="true">
                                            <span class="fa fa-clock-o"></span>
                                            <span class="ms-1">Registro</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link mb-0 px-0 py-1" id="lista-tab" href="#cam2" data-bs-toggle="tab" href="javascript:;" role="tab" aria-selected="false">
                                            <span class="fa fa-check-circle-o"></span>
                                            <span class="ms-1">Lista</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link mb-0 px-0 py-1" id="faltantes-tab" href="#cam3" data-bs-toggle="tab" href="javascript:;" role="tab" aria-selected="false">
                                            <span class="fa fa-check-circle-o"></span>
                                            <span class="ms-1">Faltantes</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="tab-content" id="v-pills-tabContent">
        <div class="tab-pane fade show position-relative active height-350 border-radius-lg" id="cam1" role="tabpanel" aria-labelledby="cam1">
    
            <div class="mt-7">
                <div class="row">
                    <div class="col-10 m-auto">
                        <div class="card card-body mt-n6 overflow-hidden">
                            <div class="col-12" >
                                <div class="">
                                    <div class="col-auto">
                                        <div class="row mt-4">
                                            <div class="col-lg-4 col-sm-6">
                                                <div class="card h-100">
                                                    <div class="card-header pb-0 p-3">
                                                        <div class="d-flex justify-content-between">
                                                            <h6 class="mb-0">Asistente: <br> <span id="nombre_completo" class="text-thin">Nombre</span> </h6>
                                                            <button type="button" class="btn btn-icon-only btn-rounded btn-outline-secondary mb-0 ms-2 btn-sm d-flex align-items-center justify-content-center" data-bs-toggle="tooltip" data-bs-placement="bottom" title="" data-bs-original-title="Información del asistente">
                                                                <i class="fas fa-info" aria-hidden="true"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                    <!-- <div class="card-body"> -->
                                                        <div class="row m-2">
                                                            <div class="col-5">
                                                                <img class="w-100 h-100 avatar" id="img_asistente" src="/img/user.png" alt="user">
                                                            </div>
                                                            <div class="col-6">
                                                                <h6>Linea: <span class="text-thin" id="linea_user"> Ninguna</span></h6> 
                                                                <h6>Bu: <span class="text-thin" id="bu_user"> Ninguna</span></h6>
                                                                <h6>Posicion: <span class="text-thin" id="posicion_user"> Ninguna</span></h6> 
                                                                <h6>Talla Player: <span class="text-thin" id="talla_palyera"> Ninguna</span></h6>
                                                            </div>
                                                        </div>
                                                        <br>
                                                        <div class="row m-2">
                                                            <h6>Correo: <span class="text-thin" id="correo_user"> _____</span></h6> 
                                                            <h6>Teléfono: <span class="text-thin" id="telefono_user"> 00 0000 0000</span></h6> 
                                                        </div>
                                                        <!-- <div class="row">
                                                            <div class="col-7 text-start">
                                                                <div class="chart">
                                                                    <canvas id="chart-pie" class="chart-canvas" height="400" style="display: block; box-sizing: border-box; height: 200px; width: 244.5px;" width="489"></canvas>
                                                                    <img src="https://www.muniplibre.gob.pe/assets/img/logos/usuario.jpg" alt="user">
                                                                </div>
                                                            </div>
                                                            <div class="col-5 my-auto">
                                                                <span class="badge badge-md badge-dot me-4 d-block text-start">
                                                                    <i class="bg-info"></i>
                                                                    <span class="text-dark text-xs">Facebook</span>
                                                                </span>
                                                                                                <span class="badge badge-md badge-dot me-4 d-block text-start">
                                                                    <i class="bg-primary"></i>
                                                                    <span class="text-dark text-xs">Direct</span>
                                                                </span>
                                                                                                <span class="badge badge-md badge-dot me-4 d-block text-start">
                                                                    <i class="bg-dark"></i>
                                                                    <span class="text-dark text-xs">Organic</span>
                                                                </span>
                                                                                                <span class="badge badge-md badge-dot me-4 d-block text-start">
                                                                    <i class="bg-secondary"></i>
                                                                    <span class="text-dark text-xs">Referral</span>
                                                                </span>
                                                            </div>
                                                        </div> -->
                                                    <!-- </div> -->
                                                    
                                                </div>
                                            </div>
                                            <div class="col-lg-8 col-sm-6 mt-sm-0 mt-4">
                                                <div class="card">
                                                    <div class="card-header pb-0 p-3">
                                                        <div class="d-flex justify-content-between">
                                                            <h6 class="mb-0"><span class="fa fa-list-alt"></span> <?php echo $nombre;?></h6>
                                                            <button type="button" class="btn btn-icon-only btn-rounded btn-outline-secondary mb-0 ms-2 btn-sm d-flex align-items-center justify-content-center" data-bs-toggle="tooltip" data-bs-placement="bottom" title="" data-bs-original-title="<?php echo $descripcion; ?>">
                                                                <i class="fas fa-info" aria-hidden="true"></i>
                                                            </button>
                                                        </div>
                                                        <hr>
                                                        <h7 class="mb-0"><span class="fa fa-calendar-alt"></span> <span id="fecha"><?php echo $fecha_asistencia; ?></span> | Asistencia abierta de <span class="fa fa-clock-o"></span> <span id="hora-inicio"><?php echo $hora_asistencia_inicio; ?></span> a <span class="fa fa-clock-o"></span> <span id="hora-fin"><?php echo $hora_asistencia_fin; ?></span> <strong> Hora Local Cancún</strong></h7>
                                                        <hr>
                                                        <br>
                                                        <div class="row gx-2 gx-sm-3">
                                                            <div class="col">
                                                                <div class="form-group">
                                                                    <input style="font-size: 35px" type="text" id="codigo_registro" name="codigo_registro" class="form-control form-control-lg text-center" minlength="6" maxlength="6" autocomplete="off" autocapitalize="off" autofocus>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="text-center">
                                                            <button onclick="focus_input()" class="btn bg-gradient-danger w-100 my-0 mb-5 ms-auto" type="submit" id="btn_registro_email">Verifica tu Código</button>
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
                </div>
            </div>
        </div>

        
    
        <div class="tab-pane fade position-relative height-350 border-radius-lg" id="cam2" role="tabpanel" aria-labelledby="cam2">
            <div class="row">
                <div class="col-10 m-auto">
                    <div class="card p-4" style="overflow-y: auto;">
                        <h4>Registrados</h4>
                        <table id="lista-reg" class="align-items-center mb-0 table table-borderless dataTable no-footer">
                            <thead>
                                <tr>
                                    <th>Nombre</th>
                                    <th>Información Personal</th>
                                    <th>Información de Trabajo</th>
                                    <th>Status<th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php echo $tabla;?>
                            </tbody>
                            
                        </table>
                    </div>
                </div>
            </div>
        </div>


        <div class="tab-pane fade position-relative height-350 border-radius-lg" id="cam3" role="tabpanel" aria-labelledby="cam2">
            <div class="row">
                <div class="col-10 m-auto">
                    <div class="card p-4" style="overflow-y: auto;">
                        <h4>Faltantes de Registro</h4>
                        <table id="lista-faltantes" class="align-items-center mb-0 table table-borderless dataTable no-footer">
                            <thead>
                                <tr>
                                    <th>Nombre</th>
                                    <th>Información Personal</th>
                                    <th>Información de Trabajo</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php echo $tabla_faltantes;?>
                            </tbody>
                            
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

<!-- Modal asignar habitacion-->
<div class="modal fade" id="asignar_habitacion" role="dialog" aria-labelledby="asignar_habitacionLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="asignar_habitacionLabel">Asignar Habitacion</h5>
                    <button type="button" class="btn bg-gradient-danger" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form class="form-horizontal" id="form_update_habitacion" action="" method="POST">
                    <div class="modal-body">
                        <div class="card-body pt-0">
                            <div class="row mb-3">
                                <div class="col-12 align-self-center mb-3">
                                    <label class="form-label mt-4">Coloque el Número de Habitación que fue asiganada </label>
                                    <input type="text" class="form-control" id="num_habitacion" name="num_habitacion">
                                </div>
                                <div class="col-12 align-self-center mb-3">
                                    <label class="form-label mt-4">Numero de Maletas (para imprimir etiquetas)</label>
                                    <input type="text" class="form-control" id="num_maletas" name="num_maletas">
                                </div>
                                <div id="cont_btn_pdf">

                                </div>
                                <div id="cont_btn_gatefe" style="display: flex; justify-content: start;">
                                
                                </div>
                                <input type="hidden" class="form-control" id="asistente_name" name="asistente_name">
                                <input type="hidden" class="form-control" id="id_asigna_habitacion" name="id_asigna_habitacion">
                                <input type="hidden" class="form-control" id="clave_habitacion" name="clave_habitacion">
                                <input type="hidden" id="codigo_registro_aux" name="codigo_registro_aux">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn bg-gradient-success ms-auto mb-0 mx-4" type="submit" title="Actualizar">Actualizar</button>
                        <a class="btn bg-gradient-secondary mb-0 js-btn-prev" data-dismiss="modal" title="Prev">Cancelar</a>
                        <!-- <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" id="save_habitacion">Save changes</button> -->
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!--End Modal-->
    
</main>


<!--   Core JS Files   -->
<script src="../../assets/js/core/popper.min.js"></script>
<script src="../../assets/js/core/bootstrap.min.js"></script>
<script src="../../assets/js/plugins/perfect-scrollbar.min.js"></script>
<script src="../../assets/js/plugins/smooth-scrollbar.min.js"></script>
<!-- Kanban scripts -->
<script src="../../assets/js/plugins/dragula/dragula.min.js"></script>
<script src="../../assets/js/plugins/jkanban/jkanban.js"></script>
<script src="../../assets/js/plugins/chartjs.min.js"></script>
<script src="../../assets/js/plugins/threejs.js"></script>
<script src="../../assets/js/plugins/orbit-controls.js"></script>

<script>
    function focus_input(){
        $("#codigo_registro").focus();
    }

    function borrarRegister(dato){
        $.ajax({
            url: "/CheckIn/borrarRegistrado/"+dato,
            type: "POST",
            dataType: 'json',
            beforeSend: function() {
                console.log("Procesando....");
            },
            success: function(respuesta) {
                swal("¡Se borró correctamente!", "", "success").
                then((value) => {
                    $("#codigo_registro").focus();
                    window.location.reload();
                });
            },
            error: function(respuesta) {
                swal("¡Ha ocurrido un error al intentar borrar el registro!", "", "warning").
                then((value) => {
                    $("#codigo_registro").focus();
                });
            }
        })
    }

    function bloquearRegistro(){
        let codigo = '';
        var link_a = $(location).attr('href');
        var clave_a = link_a.substr(link_a.indexOf('uro/')+4,link_a.length);

        let date = new Date();

        let anio = date.getFullYear();
        let mes = (parseInt(date.getMonth())+1);
        let dia = date.getDate();

        console.log(date);
        console.log(anio+' '+mes+' '+dia);

        let mes_asist = parseInt($('#fecha').html().substr(5,2));
        let dia_asist = parseInt($('#fecha').html().substr(8,2));
        let anio_asist = parseInt($('#fecha').html().substr(0,4));

        if (mes != mes_asist || dia != dia_asist || anio != anio_asist) {
            document.getElementById('codigo_registro').setAttribute('disabled','');
                if(mes_asist < 9){
                    if (dia < dia_asist || mes < mes_asist || anio < anio_asist) {
                        Swal.fire('¡El evento que registro su administrador ocurrirá el <br>'+dia_asist+'-0'+mes_asist+'-'+anio_asist+'!', 'Contacte a su administrador', "warning").
                        then((value) => {
                            $("#codigo_registro").focus();
                        });
                    } else if (dia > dia_asist || mes > mes_asist || anio > anio_asist) {
                        Swal.fire('¡El evento que registro su administrador ya ocurrió el <br>'+dia_asist+'-0'+mes_asist+'-'+anio_asist+'!', 'Contacte a su administrador', "warning").
                        then((value) => {
                            $("#codigo_registro").focus();
                        });
                    }
                } else{
                    Swal.fire('¡El evento que registro su administrador ya ocurrió el '+dia_asist+'-'+mes_asist+'-'+anio_asist+'! Contacte a su administrador', "", "warning").
                    then((value) => {
                        $("#codigo_registro").focus();
                    });
                }
        }
    }
    
    $(document).ready(function() {

        let codigo = '';
        var link_a = $(location).attr('href');
        var linea_clave = link_a.substr(link_a.indexOf('Checkin/')+8,link_a.length);
        let linea_ejecutivo = linea_clave.substr(0,linea_clave.indexOf('/'));
        let clave_a = linea_clave.substr(linea_clave.indexOf('/')+1);
        
        let numero_linea;
        switch (linea_ejecutivo) {
            case 'General':
                numero_linea = 0;
                break;

            case 'Directivos':
                numero_linea = 1;
                break;

            case 'Staff':
                numero_linea = 2;
                break;
            
            case 'Neurociencias':
                numero_linea = 3;
                break;
            
            case 'KaesOsteo':
                numero_linea = 4;
                break;
            
            case 'Cardio':
                numero_linea = 6;
                break;

            case 'Uro':
                numero_linea = 7;
                break;

            case 'Gastro':
                numero_linea = 8;
                break;

            case 'Gineco':
                numero_linea = 9;
                break;
            
            case 'MedicinaGeneral':
                numero_linea = 10;
                break;

            case 'Ole':
                numero_linea = 11;
                break;
            
            case 'Analgesia':
                numero_linea = 12;
                break;
        
            default:
                break;
        }

        bloquearRegistro();

        var table = $('#lista-reg').DataTable({
            "drawCallback": function( settings ) {
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
                $('.odd').addClass("bg-gray-conave-100");
            },
            "language": {
            
                "sProcessing":     "Procesando...",
                "sLengthMenu":     "Mostrar _MENU_ registros",
                "sZeroRecords":    "No se encontraron resultados",
                "sEmptyTable":     "Ningún dato disponible en esta tabla",
                "sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                "sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros",
                "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
                "sInfoPostFix":    "",
                "sSearch":         "Buscar:",
                "sUrl":            "",
                "sInfoThousands":  ",",
                "sLoadingRecords": "Cargando...",
                "oPaginate": {
                    "sFirst":    "Primero",
                    "sLast":     "Último",
                    "sNext":     "Siguiente",
                    "sPrevious": "Anterior"
                },
                "oAria": {
                    "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
                    "sSortDescending": ": Activar para ordenar la columna de manera descendente"
                }
            
            }
        });

        var table = $('#lista-faltantes').DataTable({
            "drawCallback": function( settings ) {
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
                $('.odd').addClass("bg-gray-conave-100");
            },
            "language": {
            
                "sProcessing":     "Procesando...",
                "sLengthMenu":     "Mostrar _MENU_ registros",
                "sZeroRecords":    "No se encontraron resultados",
                "sEmptyTable":     "Ningún dato disponible en esta tabla",
                "sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                "sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros",
                "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
                "sInfoPostFix":    "",
                "sSearch":         "Buscar:",
                "sUrl":            "",
                "sInfoThousands":  ",",
                "sLoadingRecords": "Cargando...",
                "oPaginate": {
                    "sFirst":    "Primero",
                    "sLast":     "Último",
                    "sNext":     "Siguiente",
                    "sPrevious": "Anterior"
                },
                "oAria": {
                    "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
                    "sSortDescending": ": Activar para ordenar la columna de manera descendente"
                }
            
            }
        });
        
        
        $("#codigo_registro").on('change',function(){

            codigo = $('#codigo_registro').val();
            $('#codigo_registro').val('');

            console.log("codigo " +codigo);
            console.log("clave_a " +clave_a);
            console.log("numero linea "+numero_linea);
            console.log("linea ejecutivo "+linea_ejecutivo);
        
            $.ajax({
                url: "/Checkin/registroChekIn",
                type: "POST",
                dataType: 'json',
                data:{codigo,clave_a,numero_linea},
                beforeSend: function() {
                    console.log("Procesando....");
                },
                success: function(respuesta) {
                    console.log(respuesta);
                    console.log("ddsfdsf"+respuesta);
                    if (respuesta.status == 'success') {
                        console.log("talla playeta "+respuesta.datos.talla_playera);
                        console.log(respuesta.msg_insert);
                        // let nombre_completo = respuesta.datos.nombre_completo;
                        $("#nombre_completo").html(respuesta.datos.nombre_completo);
                        $("#correo_user").html(respuesta.datos.email);
                        $("#telefono_user").html(respuesta.datos.telefono);
                        $("#asistente_name").val(respuesta.datos.id_registro_acceso);
                        $("#clave_habitacion").val(respuesta.clave_habitacion);
                        $("#id_asigna_habitacion").val(respuesta.id_asigna_habitacion);
                        $("#num_habitacion").val(respuesta.numero_habitacion);
                        if(respuesta.datos.talla_playera == null || respuesta.datos.talla_playera == ''){
                            $("#talla_playera").html("No se asigno talla");
                        }else{
                            $("#talla_playera").html(respuesta.datos.talla_playera);
                        }

                        // $("#no_habitacion").val(respuesta.numero_habitacion);
                        if (respuesta.numero_habitacion == 0) {
                            $("#numeroHabitacion").html("Sin Número de habitación");
                        } else {
                            $("#numeroHabitacion").html(respuesta.numero_habitacion);
                        }
                        $("#cont_btn_pdf").append(respuesta.anchor_abrir_pdf);
                        $("#cont_btn_gatefe").append(respuesta.anchor_abrir_gafete);

                        if (respuesta.datos.img != '' || respuesta.datos.img != null || respuesta.datos.img != NULL || respuesta.datos.img != 'null' ) {
                            
                            if (respuesta.datos.img == null) {
                                $("#img_asistente").attr('src','/img/user.png')
                            }else{
                                $("#img_asistente").attr('src','http://convencionasofarma2022.mx/img/users_conave/'+respuesta.datos.img);
                            }
                        } else {
                            $("#img_asistente").attr('src','/img/user.png');
                        }

                       

                        for (let index = 0; index < respuesta.linea_principal.length; index++) {
                            const element = respuesta.linea_principal[index];
                            if (element.id_linea_principal == respuesta.datos.id_linea_principal) {
                                $("#linea_user").html(element.nombre);
                            }
                        }

                        for (let index = 0; index < respuesta.bu.length; index++) {
                            const element = respuesta.bu[index];
                            if (element.id_bu == respuesta.datos.id_bu) {
                                $("#bu_user").html(element.nombre);
                            }
                        }

                        for (let index = 0; index < respuesta.posiciones.length; index++) {
                            const element = respuesta.posiciones[index];
                            if (element.id_posicion == respuesta.datos.id_posicion) {
                                $("#posicion_user").html(element.nombre);
                            }
                        }

                        for (let index = 0; index < respuesta.posiciones.length; index++) {
                            const element = respuesta.posiciones[index];
                            if (element.id_posicion == respuesta.datos.id_posicion) {
                                $("#posicion_user").html(element.nombre);
                            }
                        }

                        if(respuesta.msg_insert == 'success_find_assistant'){
                            Swal.fire({
                                title: '¡Lo sentimos, esta persona ya tiene su asistencia registrada!',
                                icon: 'warning',
                                timer: 1000,
                                didOpen: () => {
                                    const b = Swal.getHtmlContainer().querySelector('b')
                                    timerInterval = setInterval(() => {
                                    }, 100)
                                },
                                willClose: () => {
                                    clearInterval(timerInterval)
                                }
                                }).then((result) => {
                                $("#codigo_registro").focus();
                            })
                            // Swal.fire({
                            //     title: '¡Asistencia Registrada con éxito!',
                            //     icon: 'success',
                            //     timer: 1000,
                            //     didOpen: () => {
                            //         const b = Swal.getHtmlContainer().querySelector('b')
                            //         timerInterval = setInterval(() => {
                            //         }, 100)
                            //     },
                            //     willClose: () => {
                            //         clearInterval(timerInterval)
                            //     }
                            //     }).then((result) => {
                            //     $("#codigo_registro").focus();
                            // })
                        } 
                        else {
                         $("#asignar_habitacion").modal("show");

                        //    Swal.fire({
                        //         title: '¡Asistencia Registrada con éxito!',
                        //         icon: 'success',
                        //         timer: 1000,
                        //         didOpen: () => {
                        //             const b = Swal.getHtmlContainer().querySelector('b')
                        //             timerInterval = setInterval(() => {
                        //             }, 100)
                        //         },
                        //         willClose: () => {
                        //             clearInterval(timerInterval)
                        //         }
                        //         }).then((result) => {
                        //         $("#codigo_registro").focus();
                        //     })
                        }
                        
                    } else if (respuesta.status == 'fail_user') {
                        Swal.fire({
                            title: '¡Lo sentimos, esta persona no se encuentra registrada en nuestra base de datos!',
                            icon: 'warning',
                            timer: 1000,
                            didOpen: () => {
                                const b = Swal.getHtmlContainer().querySelector('b')
                                timerInterval = setInterval(() => {
                                }, 100)
                            },
                            willClose: () => {
                                clearInterval(timerInterval)
                            }
                            }).then((result) => {
                            $("#codigo_registro").focus();
                        })

                        // Swal.fire({
                        //         title: '¡Asistencia Registrada con éxito.!',
                        //         icon: 'success',
                        //         timer: 1000,
                        //         didOpen: () => {
                        //             const b = Swal.getHtmlContainer().querySelector('b')
                        //             timerInterval = setInterval(() => {
                        //             }, 100)
                        //         },
                        //         willClose: () => {
                        //             clearInterval(timerInterval)
                        //         }
                        //         }).then((result) => {
                        //         $("#codigo_registro").focus();
                        //     })

                        $("#nombre_completo").html('Nombre');
                        $("#img_asistente").attr('src','/img/user.png');
                        $("#linea_user").html('Ninguna');
                        $("#bu_user").html('Ninguna');
                        $("#posicion_user").html('Ninguna');
                        $("#talla_playera").html('Ninguna');
                        $("#correo_user").html('_____');
                        $("#telefono_user").html('00 0000 0000');
                        console.log(respuesta);
                    }else {
                        Swal.fire({
                            title: '¡Lo sentimos, esta persona no pertenece a la línea!',
                            icon: 'warning',
                            timer: 1000,
                            didOpen: () => {
                                const b = Swal.getHtmlContainer().querySelector('b')
                                timerInterval = setInterval(() => {
                                }, 100)
                            },
                            willClose: () => {
                                clearInterval(timerInterval)
                            }
                            }).then((result) => {
                            $("#codigo_registro").focus();
                        })
                        $("#nombre_completo").html('Nombre');
                        $("#img_asistente").attr('src','/img/user.png');
                        $("#linea_user").html('Ninguna');
                        $("#bu_user").html('Ninguna');
                        $("#posicion_user").html('Ninguna');
                        $("#correo_user").html('_____');
                        $("#telefono_user").html('00 0000 0000');
                        console.log(respuesta);
                    }
                   
                },
                error: function(respuesta) {
                    console.log(respuesta);
                    $("#nombre_completo").html('Nombre');
                        $("#img_asistente").attr('src','/img/user.png');
                        $("#linea_user").html('Ninguna');
                        $("#bu_user").html('Ninguna');
                        $("#posicion_user").html('Ninguna');
                        $("#correo_user").html('_____');
                        $("#telefono_user").html('00 0000 0000');
                    Swal.fire({
                        // title: '¡Lo sentimos, ocurrió un error!',
                        title: '¡Lo sentimos, esta persona no se encuentra registrada en nuestra base de datos!',
                        icon: 'warning',
                        timer: 2000,
                        didOpen: () => {
                            const b = Swal.getHtmlContainer().querySelector('b')
                            timerInterval = setInterval(() => {
                            }, 100)
                        },
                        willClose: () => {
                            clearInterval(timerInterval)
                        }
                        }).then((result) => {
                        $("#codigo_registro").focus();
                    })
                }
    
            });
        });
        
        $("#asigna_cat_habitacion").on("change", function() {
            var cat_habitacion = $(this).val();
            $.ajax({
                url: "/Habitaciones/categoriaHabitacion",
                type: "POST",
                data: {
                    cat_habitacion
                },
                dataType: "json",
                beforeSend: function() {
                    console.log("Procesando....");

                    $('#cont_asigna_huespedes .asign_huesped').remove();
                    $('#cont_asigna_huespedes .card').remove();


                },
                success: function(respuesta) {
                    // console.log(respuesta);
                    // console.log(respuesta.asistentes.length);



                    // $("#cont_asigna_huespedes").append('<div class="col-12 align-self-center asign_huesped">' +
                    //     '<label class="form-label mt-4">Asistentes *</label><br>' +
                    //     '<select class="form-control select_2" style="cursor: pointer;" name="asistente_name[]" id="asistente_name' + i + '" tabindex="-1" required>' +
                    //     '<option value="" disabled selected>Selecciona una opción</option>' +
                    //     '</select>' +
                    //     '</div>');

                    $("#cont_asigna_huespedes").append('<div class="card"><div class="card-body">' +
                        '<div class="row mb-3">' +
                        '<div class="col-md-6 col-sm-12 align-self-center asign_huesped">' +
                        '<label class="form-label">IN *</label><br>' +
                        '<input type="date" class="form-control" id="date_in" name="date_in[]" min="2022-04-06" max="2022-04-09">' +
                        '</div>' +
                        '<div class="col-md-6 col-sm-12 align-self-center asign_huesped">' +
                        '<label class="form-label">OUT *</label><br>' +
                        '<input type="date" class="form-control" id="date_out" name="date_out[]" min="2022-04-06" max="2022-04-09">' +
                        '</div>' +
                        '</div>' +
                        '<div class="row mb-3">' +
                        '<div class="col-md-6 col-sm-12 align-self-center asign_huesped">' +
                        '<label class="form-label">Numero de habitación (opcional)</label><br>' +
                        '<input type="number" class="form-control numero_habitacion" data-item="1" id="numero_habitacion" name="numero_habitacion[]" min="1" pattern="^[0-9]+">' +
                        '</div>' +
                        '<div class="col-md-6 col-sm-12 align-self-center asign_huesped">' +

                        '</div>' +
                        '<div class="col-md-6 col-sm-12 align-self-center asign_huesped">' +
                        '<span id="msg_numero_habitacion" style="font-size:13px; color:red;"></span>' +
                        '</div>' +
                        '</div>' +
                        '<div class="row mb-3">' +
                        '<div class="col-md-12 align-self-center asign_huesped">' +
                        '<label class="form-label">Comentarios (opcional)</label><br>' +
                        '<textarea name="comentarios[]" id="comentarios" class="form-control" cols="30" rows="5"></textarea>' +
                        '</div>' +
                        '</div>' +
                        '</div>' +
                        '</div><div class="asign_huesped"><br></div>');

                    $("#svuelo").attr('data-toggle', 'tooltip');
                    $("#svuelo").attr('data-original-title', 'Si usted desea modificar la hora consulte a la ejecutiva de linea');




                    // $(".select_2").select2();

                },
                error: function(respuesta) {
                    console.log(respuesta);
                }

            });
        });


        $('#cont_asigna_huespedes').on("change", "select.select_2", function(event) {
            console.log($(this).val());
            var id_asis = $(this).val();
            var data_item = $(this).attr('data-item');
            console.log(data_item);
            $.ajax({
                url: "/Habitaciones/getAsistenteId",
                type: "POST",
                data: {
                    id_asis
                },
                dataType: "json",
                beforeSend: function() {
                    console.log("Procesando....");

                },
                success: function(respuesta) {
                    console.log(respuesta);
                    if (respuesta.status == 'success') {
                        $('#vuelo' + data_item).val(respuesta.pase.hora_llegada_destino);
                    } else {
                        $('#vuelo' + data_item).val(respuesta.msg);
                    }

                    var next_select = (parseInt(data_item) + 1);
                    console.log($("#asistente_name" + next_select));
                    $("#asistente_name" + next_select).empty();
                    $("#asistente_name" + next_select).append('<option value="" disabled selected>Selecciona una opción</option>');

                    for (var j = 0; j < respuesta.asistentes.length; j++) {
                        // console.log(respuesta.asistentes[j].id_registro_acceso);
                        // console.log(respuesta.asistentes[j].nombre);
                        // console.log(respuesta.asistentes[j].apellido_paterno);
                        // console.log(respuesta.asistentes[j].apellido_materno);
                        $("#asistente_name" + next_select).append('<option value="' + respuesta.asistentes[j].id_registro_acceso + '">' + respuesta.asistentes[j].nombre + '</option>');
                    }
                },
                error: function(respuesta) {
                    console.log(respuesta);
                }

            });

        });

        $('#cont_asigna_huespedes').on("keyup", "input#numero_habitacion", function(event) {

            var no_habitacion = $(this).val();
            var categoria_habitacion = $("#asigna_cat_habitacion").val();
            $.ajax({
                url: "/Habitaciones/BuscaHabitacionCheckin",
                type: "POST",
                data: {
                    no_habitacion,
                    categoria_habitacion
                },
                dataType: 'json',
                beforeSend: function() {
                    console.log("Procesando....");

                },
                success: function(respuesta) {

                    console.log(respuesta);
                    if (respuesta.status == 'success') {
                        $("#msg_numero_habitacion").html(respuesta.msg);
                        $("#msg_numero_habitacion").css('color', respuesta.color);
                        // $("#save_habitacion").attr("disabled", "disabled");
                    } else {
                        $("#msg_numero_habitacion").html('');
                        // $("#save_habitacion").removeAttr("disabled");
                    }


                },
                error: function(respuesta) {
                    console.log(respuesta);
                }

            });
        });

        $("#form_asignar_habitacion").on('submit', function(event) {
            event.preventDefault();

            var formData = new FormData(document.getElementById("form_asignar_habitacion"));

            $.ajax({
                url: "/Habitaciones/AsignarHabitacion",
                type: "POST",
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                beforeSend: function() {
                    console.log("Procesando....");

                },
                success: function(respuesta) {

                    if (respuesta == 'success') {
                        swal("Se asigno la habitación correctamente!", "", "success").
                        then((value) => {
                            window.location.replace("/Habitaciones/");
                        });
                    }
                    console.log(respuesta);


                },
                error: function(respuesta) {
                    console.log('AQUI');
                    console.log(respuesta);
                }

            });

        });

        $("#form_update_habitacion").on('submit', function(event) {
            event.preventDefault();

            // var formData = new FormData(document.getElementById("form_update_habitacion"));
            var id_asigna_habitacion = $("#id_asigna_habitacion").val();
            var num_habitacion = $("#num_habitacion").val();
            var num_maletas = $("#num_maletas").val();


            console.log(id_asigna_habitacion);
            console.log(num_habitacion);
            console.log(num_maletas);
            $.ajax({
                url: "/Habitaciones/UpdateHabitacion",
                type: "POST",
                data: {
                    id_asigna_habitacion,
                    num_habitacion
                },
                beforeSend: function() {
                    console.log("Procesando....");

                },
                success: function(respuesta) {
                    // if (respuesta == 'success') {
                        swal("Se asigno la habitación correctamente!", "", "success").
                        then((value) => {
                            var nombre = $("#nombre_completo").text();
                            var codigo_user = $("#codigo_registro_aux").val() + '.pdf';

                            $("#a_abrir_etiqueta").css('display', 'none');
                            var ref = $("#a_abrir_etiqueta").attr('href');
                            var href = ref + '/' + num_maletas;
                            $("#a_abrir_etiqueta").attr('href', href);
                            $("#a_abrir_etiqueta")[0].click();

                            $("#a_abrir_gafete").css('display', 'block');
                            var ref1 = $("#a_abrir_gafete").attr('href');
                            var href1 = ref1;
                            $("#a_abrir_gafete").attr('href', href1);
                            $("#a_abrir_gafete")[0].click();

                            $("#numeroHabitacion").html(num_habitacion);

                        });
                    // }
                    console.log(respuesta);


                },
                error: function(respuesta) {
                    // console.log('AQUI 2');
                    console.log(respuesta);
                }

            });

        });
        
    });

    function imprimirPdf(nombrePdf) {

        console.log("Este es el nomnre " + nombrePdf);


        // Función ayudante
        const reemplazarEspaciosConEntidad = cadena => cadena.replaceAll(" ", "%20");
        // Estos parámetros podrían venir de cualquier lugar
        // Presta atención al escape de la backslash \
        var nombrePdf = "C:/pases_abordar/" + nombrePdf;
        // Debemos remover los espacios:
        //    nombrePdf = reemplazarEspaciosConEntidad(nombrePdf);

        const nombreImpresora = "Brother QL-700";
        const url = `http://localhost:8080/?nombrePdf=${nombrePdf}&impresora=${nombreImpresora}`;
        // Elemento DOM, solo es para depurar
        //    var $estado = document.querySelector("#estado");
        //    $estado.textContent = "Imprimiendo...";
        // Hacer petición...
        fetch(url)
        .then(respuesta => {
            // Si la respuesta es OK, entonces todo fue bien
            if (respuesta.status === 200) {
                //    $estado.textContent = "Impreso correctamente (salvo que se haya indicado un error por parte de PDFtoPrinter";
                console.log("Impresión OK");
            } else {
                // Si no, decodificamos el mensaje para ver el error
                respuesta.json()
                    .then(mensaje => {
                        //    $estado.textContent = "Error imprimiendo: " + mensaje;
                        console.log("Error: " + mensaje);
                    });
            }
        });
    }

</script>

</body>

<?php echo $footer; ?>

</html>