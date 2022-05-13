
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
                                    Lista de Asistencia para Plenarias Individuales
                                </h5>
                                <h6><b>KAES / OSTEO</b></h6>
                                <p class="mb-0 font-weight-bold text-sm">
                                </p>
                            </div>
                        </div>

                        <div class="col-lg-4 col-md-6 my-sm-auto ms-sm-auto me-sm-0 mx-auto mt-3">
                            <div class="nav-wrapper position-relative end-0">
                                <ul class="nav nav-pills nav-fill p-1 bg-transparent" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link mb-0 px-0 py-1 active" href="#cam1" data-bs-toggle="tab" href="javascript:;" role="tab" aria-selected="true">
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
                                        <p style="color: green"><strong>Nota:</strong> Pida al asistente que escaneé su codigo <strong>QR</strong>, esté se encuentra en la sección de Ticket Virtual de la plataforma ó en su Gafete que se entrego de manera impresa en los módulos de registro a la llegada al hotel</p>
                                        <div class="row mt-4">
                                            <div class="col-lg-4 col-sm-6">
                                                <div class="card h-100">
                                                    <div class="card-header pb-0 p-3">
                                                        <div class="d-flex justify-content-between">
                                                            <h6 class="mb-0">Asistente: <br> <span id="nombre_completo" class="text-thin">Nombre</span> </h6>
                                                            <button type="button" class="btn btn-icon-only btn-rounded btn-outline-secondary mb-0 ms-2 btn-sm d-flex align-items-center justify-content-center" data-bs-toggle="tooltip" data-bs-placement="bottom" title="" data-bs-original-title="En está sección se muestran los datos generales del asistente.">
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
                                                            </div>
                                                        </div>
                                                        <br>
                                                        <div class="row m-2">
                                                            <h6>Correo: <span class="text-thin" id="correo_user"> _____</span></h6> 
                                                            <h6>Teléfono: <span class="text-thin" id="telefono_user"> 00 0000 0000</span></h6> 
                                                        </div>
                                                    
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
                                                        <h7 class="mb-0"><span class="fa fa-calendar-alt"></span> <span id="fecha"><?php echo $fecha_asistencia; ?></span> | Asistencia abierta de <span class="fa fa-clock-o"></span> <span id="hora-inicio"><strong><?php echo $hora_asistencia_inicio; ?></strong></span> a <span class="fa fa-clock-o"></span> <span id="hora-fin"><strong><?php echo $hora_asistencia_fin; ?></strong></span> <strong> (Hora Local Cancún)</strong></h7>
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
    </div>


    
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
        // alert(dato);
        $.ajax({
            url: "/RegistroAsistencia/borrarRegistrado/"+dato,
            type: "POST",
            dataType: 'json',
            beforeSend: function() {
                console.log("Procesando....");
                // alert('Se está borrando');
                
            },
            success: function(respuesta) {
                console.log(respuesta);
                console.log('despues de borrar');
                // alert('Bien borrado');
                swal("¡Se borró correctamente!", "", "success").
                then((value) => {
                    $("#codigo_registro").focus();
                    window.location.reload();
                });
            },
            error: function(respuesta) {
                console.log(respuesta);
                // alert('Error');
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
        var clave_a = link_a.substr(link_a.indexOf('codigo/')+7,link_a.length);

        let date = new Date();

        let anio = date.getFullYear();
        let mes = (parseInt(date.getMonth())+1);
        let dia = date.getDate();

        console.log(date);
        console.log(anio+' '+mes+' '+dia);

        let mes_asist = parseInt($('#fecha').html().substr(5,2));
        let dia_asist = parseInt($('#fecha').html().substr(8,2));
        let anio_asist = parseInt($('#fecha').html().substr(0,4));

        // console.log(anio_asist);

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
        var clave_a = link_a.substr(link_a.indexOf('KaesOsteo/')+10,link_a.length);
        
        bloquearRegistro();

        // mostrarDatos(clave_a);

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
        
        $("#codigo_registro").on('change',function(){

            codigo = $('#codigo_registro').val();
            $('#codigo_registro').val('');
            // $('#lista-reg > tbody').empty();

            console.log(codigo);
            console.log(clave_a);
        
            $.ajax({
                url: "/RegistroLinea/registroAsistenciaKaesOsteo/"+codigo+'/'+clave_a,
                type: "POST",
                // data: formData,
                dataType: 'json',
                beforeSend: function() {
                    console.log("Procesando....");
                },
                success: function(respuesta) {
                    console.log(respuesta.status);
                    if (respuesta.status == 'success') {
                        console.log(respuesta);
                        console.log(respuesta.msg_insert);
                        let nombre_completo = respuesta.datos.nombre+' '+respuesta.datos.segundo_nombre+' '+respuesta.datos.apellido_paterno +' '+respuesta.datos.apellido_materno;
                        $("#nombre_completo").html(nombre_completo);
                        $("#correo_user").html(respuesta.datos.email);
                        $("#telefono_user").html(respuesta.datos.telefono);

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

                        if(respuesta.msg_insert == 'success_find_assistant'){
                            Swal.fire({
                                title: '¡Lo sentimos, esta persona ya tiene su asistencia registrada!',
                                // html: 'I will close in <b></b> milliseconds.',
                                icon: 'warning',
                                timer: 1000,
                                // timerProgressBar: true,
                                didOpen: () => {
                                    // Swal.showLoading()
                                    const b = Swal.getHtmlContainer().querySelector('b')
                                    timerInterval = setInterval(() => {
                                        // b.textContent = Swal.getTimerLeft()
                                    }, 100)
                                },
                                willClose: () => {
                                    clearInterval(timerInterval)
                                }
                                }).then((result) => {
                                $("#codigo_registro").focus();
                            })
                        } else {
                            // window.location.replace("/RegistroAsistencia/codigo/"+clave_a);
                        }
                        
                        // mostrarDatos(clave_a);
                        // let tabla_registrados = $("#lista-reg");
                    } else {
                        Swal.fire({
                            title: '¡Lo sentimos, esta persona no pertenece a la Línea KAES / OSTEO!',
                            // html: 'I will close in <b></b> milliseconds.',
                            icon: 'warning',
                            timer: 1000,
                            // timerProgressBar: true,
                            didOpen: () => {
                                // Swal.showLoading()
                                const b = Swal.getHtmlContainer().querySelector('b')
                                timerInterval = setInterval(() => {
                                    // b.textContent = Swal.getTimerLeft()
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
                    // swal("¡Lo sentimos, ocurrió un error!", "", "warning").
                    // then((value) => {
                    //     $("#codigo_registro").focus();
                    // });
                    Swal.fire({
                        title: '¡Lo sentimos, ocurrió un error!',
                        // html: 'I will close in <b></b> milliseconds.',
                        icon: 'warning',
                        timer: 2000,
                        // timerProgressBar: true,
                        didOpen: () => {
                            // Swal.showLoading()
                            const b = Swal.getHtmlContainer().querySelector('b')
                            timerInterval = setInterval(() => {
                                // b.textContent = Swal.getTimerLeft()
                            }, 100)
                        },
                        willClose: () => {
                            clearInterval(timerInterval)
                        }
                        }).then((result) => {
                        $("#codigo_registro").focus();
                    })
                    // $("#nombre_completo").html('Nombre');
                    // $("#img_asistente").attr('src','/img/user.png');
                    // $("#linea_user").html('Ninguna');
                    // $("#bu_user").html('Ninguna');
                    // $("#correo_user").html('_____');
                    // $("#telefono_user").html('00 0000 0000');
                }
    
            });
        });
        
        
    });

</script>

</body>

<?php echo $footer; ?>

</html>