<?php

namespace App\controllers;

defined("APPPATH") or die("Access denied");

use \Core\View;
use \App\models\RegistroCheckIn AS RegistroCheckInDao;
use \App\models\RegistroAsistencia AS RegistroAsistenciaDao;
use \App\models\Habitaciones as HabitacionesDao;
use \App\models\Asistentes as AsistentesDao;
use \DateTime;
use \DatetimeZone;


class Checkin
{
    //----------Directivos----------//
    public function General($id) {
        $extraHeader =<<<html
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link rel="apple-touch-icon" sizes="76x76" href="/assets/img/favicon.png">
        <link rel="icon" type="image/png" href="/assets/img/favicon.png">
        <title>
            General - Asistencia CONAVE Convención 2022 ASOFARMA
        </title>
        <!--     Fonts and icons     -->
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
        <!-- Nucleo Icons -->
        <link href="/assets/css/nucleo-icons.css" rel="stylesheet" />
        <link href="/assets/css/nucleo-svg.css" rel="stylesheet" />
        <!-- Font Awesome Icons -->
        <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
        <link href="/assets/css/nucleo-svg.css" rel="stylesheet" />
        <!-- CSS Files -->
        <link id="pagestyle" href="/assets/css/soft-ui-dashboard.css?v=1.0.5" rel="stylesheet" />
        <link rel="stylesheet" href="/css/alertify/alertify.core.css" />
        <link rel="stylesheet" href="/css/alertify/alertify.default.css" id="toggleCSS" />
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
        <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

html;
        $extraFooter =<<<html
        <script src="/js/jquery.min.js"></script>
        <script src="/js/validate/jquery.validate.js"></script>
        <script src="/js/alertify/alertify.min.js"></script>
        <!-- -------- END FOOTER 3 w/ COMPANY DESCRIPTION WITH LINKS & SOCIAL ICONS & COPYRIGHT ------- -->
        <!--   Core JS Files   -->
        <script src="/assets/js/core/popper.min.js"></script>
        <script src="/assets/js/core/bootstrap.min.js"></script>
        <script src="/assets/js/plugins/perfect-scrollbar.min.js"></script>
        <script src="/assets/js/plugins/smooth-scrollbar.min.js"></script>
        <!-- Kanban scripts -->
        <script src="/assets/js/plugins/dragula/dragula.min.js"></script>
        <script src="/assets/js/plugins/jkanban/jkanban.js"></script>
        <script>
            var win = navigator.platform.indexOf('Win') > -1;
            if (win && document.querySelector('#sidenav-scrollbar')) {
                var options = {
                    damping: '0.5'
                }
                Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
            }
        </script>
        <!-- Github buttons -->
        <script async defer src="https://buttons.github.io/buttons.js"></script>
        <!-- Control Center for Soft Dashboard: parallax effects, scripts for the example pages etc -->
        <script src="/assets/js/soft-ui-dashboard.min.js?v=1.0.5"></script>
        <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

        <script src="http://cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js" defer></script>
        <link rel="stylesheet" href="http://cdn.datatables.net/1.11.4/css/jquery.dataTables.min.css" />
        
        <script src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js" defer></script>
        <link rel="stylesheet" href="https://cdn.datatables.net/1.11.4/css/jquery.dataTables.min.css" />

        <script src="//cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js" defer></script>
        <link rel="stylesheet" href="//cdn.datatables.net/1.11.4/css/jquery.dataTables.min.css" />

html;

        $codigo = RegistroCheckInDao::getById($id);

        $lista_registrados = RegistroAsistenciaDao::getRegistrosAsistenciasByCode($id);

        $nombre_asistencia = RegistroCheckInDao::getRegistrosAsistenciasByCode($id)[0]['nombre_asistencia'];

        $tabla='';
        foreach ($lista_registrados as $key => $value) {
            $tabla.=<<<html
            <tr>
                <td><b>{$value['nombre_completo']} </b> <span class="badge badge-info" style="color: white; background: {$value['color_linea']};"> {$value['nombre_linea_ejecutivo']} </span></td>
                <td>
                    <u><a href="mailto:{$value['email']}"><span class="fa fa-mail-bulk"> </span> {$value['email']}</a></u>
                    <br><br>
                    <u><a href="https://api.whatsapp.com/send?phone=52{$value['telefono']}&text=Buen%20d%C3%ADa,%20te%20contacto%20de%20parte%20del%20Equipo%20Grupo%20LAHE%20%F0%9F%98%80" target="_blank"><span class="fa fa-whatsapp" style="color:green;"> </span> {$value['telefono']}</a></u>
                </td>
                <td>
                    <b>Línea: </b>{$value['nombre_linea']}
                    <br>
                    <b>BU: </b>{$value['nombre_bu']}
                    <br>
                    <b>Posición: </b>{$value['nombre_posicion']} 
                </td>
                
html;
            if ($value['status'] == 1) {
                $tabla.=<<<html
                <td class="text-center"><span class="badge badge-success">En Tiempo</span><td>
                <td>
                    <button class="btn btn-danger " onclick="borrarRegister({$value['id_registro_asistencia']})" type="button" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-original-title="Eliminar Registro de {$value['nombre_completo']}">
                        <i class="fas fa-trash"></i>
                    </button>
                </td>
            </tr>
html;
            } else if ($value['status'] == 2){
                $tabla.=<<<html
                <td class="text-center"><span class="badge badge-danger">Fuera del Horario</span><td>
                <td>
                    <button class="btn btn-danger " onclick="borrarRegister({$value['id_registro_asistencia']})" type="button" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-original-title="Eliminar Registro de {$value['nombre_completo']}">
                        <i class="fas fa-trash"></i>
                    </button>
                </td>
            </tr>
html;
            }
        }

        $etiqueta_linea =<<<html
            <span class="badge badge-info" style="background: #000; color: white;">General</span>    
html;

        foreach($codigo as $key => $value)
        {
            if($value['id_asistencia'] != '')
            {
                $flag = true;
                $nombre = $value['nombre'];
                $descripcion = $value['descripcion'];
                $fecha_asistencia = $value['fecha_asistencia'];
                $hora_asistencia_inicio = $value['hora_asistencia_inicio'];
                $hora_asistencia_fin = $value['hora_asistencia_fin'];
            }
        }


        ///--------------------FALTANTES--------------------///
        $lista_faltantes = RegistroCheckInDao::getAsistenciasFaltantes($id);
        $tabla_faltantes='';
        foreach ($lista_faltantes as $key => $value) {
            $tabla_faltantes.=<<<html
            <tr>
                <td><b>{$value['nombre_completo']} </b> <span class="badge badge-info" style="color: white; background: {$value['color_linea']};"> {$value['nombre_linea_ejecutivo']} </span></td>
                <td>
                    <u><a href="mailto:{$value['email']}"><span class="fa fa-mail-bulk"> </span> {$value['email']}</a></u>
                    <br><br>
                    <u><a href="https://api.whatsapp.com/send?phone=52{$value['telefono']}&text=Buen%20d%C3%ADa,%20te%20contacto%20de%20parte%20del%20Equipo%20Grupo%20LAHE%20%F0%9F%98%80" target="_blank"><span class="fa fa-whatsapp" style="color:green;"> </span> {$value['telefono']}</a></u>
                </td>
                <td>
                    <b>Línea: </b>{$value['nombre_linea']}
                    <br>
                    <b>BU: </b>{$value['nombre_bu']}
                    <br>
                    <b>Posición: </b>{$value['nombre_posicion']} 
                </td>
                <td>
                    <button class="btn btn-danger " onclick="borrarRegister({$value['id_registro_asistencia']})" type="button" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-original-title="Eliminar Registro de {$value['nombre_completo']}">
                        <i class="fas fa-trash"></i>
                    </button>
                </td>
            </tr>
html;
        }
        ///-------------------------------------------------///


        if($flag == true)
        {
            View::set('tabla',$tabla);
            View::set('tabla_faltantes',$tabla_faltantes);
            View::set('nombre',$nombre);
            View::set('etiqueta_linea',$etiqueta_linea);
            View::set('descripcion',$descripcion);
            View::set('nombre_asistencia',$nombre_asistencia);
            View::set('fecha_asistencia',$fecha_asistencia);
            View::set('hora_asistencia_inicio',$hora_asistencia_inicio);
            View::set('hora_asistencia_fin',$hora_asistencia_fin);
            View::set('header',$extraHeader);
            View::set('footer',$extraFooter);
            View::render("registro_asistencias_checkin");
        }
        else
        {
            // View::render("asistencias_panel_registro");
            View::render("asistencias_all_vacia");
        }
    }

    //----------Directivos----------//
    public function directivos($id) {
        $extraHeader =<<<html
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link rel="apple-touch-icon" sizes="76x76" href="/assets/img/favicon.png">
        <link rel="icon" type="image/png" href="/assets/img/favicon.png">
        <title>
            Directivos - Asistencia CONAVE Convención 2022 ASOFARMA
        </title>
        <!--     Fonts and icons     -->
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
        <!-- Nucleo Icons -->
        <link href="/assets/css/nucleo-icons.css" rel="stylesheet" />
        <link href="/assets/css/nucleo-svg.css" rel="stylesheet" />
        <!-- Font Awesome Icons -->
        <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
        <link href="/assets/css/nucleo-svg.css" rel="stylesheet" />
        <!-- CSS Files -->
        <link id="pagestyle" href="/assets/css/soft-ui-dashboard.css?v=1.0.5" rel="stylesheet" />
        <link rel="stylesheet" href="/css/alertify/alertify.core.css" />
        <link rel="stylesheet" href="/css/alertify/alertify.default.css" id="toggleCSS" />
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
        <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

html;
        $extraFooter =<<<html
        <script src="/js/jquery.min.js"></script>
        <script src="/js/validate/jquery.validate.js"></script>
        <script src="/js/alertify/alertify.min.js"></script>
        <!-- -------- END FOOTER 3 w/ COMPANY DESCRIPTION WITH LINKS & SOCIAL ICONS & COPYRIGHT ------- -->
        <!--   Core JS Files   -->
        <script src="/assets/js/core/popper.min.js"></script>
        <script src="/assets/js/core/bootstrap.min.js"></script>
        <script src="/assets/js/plugins/perfect-scrollbar.min.js"></script>
        <script src="/assets/js/plugins/smooth-scrollbar.min.js"></script>
        <!-- Kanban scripts -->
        <script src="/assets/js/plugins/dragula/dragula.min.js"></script>
        <script src="/assets/js/plugins/jkanban/jkanban.js"></script>
        <script>
            var win = navigator.platform.indexOf('Win') > -1;
            if (win && document.querySelector('#sidenav-scrollbar')) {
                var options = {
                    damping: '0.5'
                }
                Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
            }
        </script>
        <!-- Github buttons -->
        <script async defer src="https://buttons.github.io/buttons.js"></script>
        <!-- Control Center for Soft Dashboard: parallax effects, scripts for the example pages etc -->
        <script src="/assets/js/soft-ui-dashboard.min.js?v=1.0.5"></script>
        <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

        <script src="http://cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js" defer></script>
        <link rel="stylesheet" href="http://cdn.datatables.net/1.11.4/css/jquery.dataTables.min.css" />
        
        <script src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js" defer></script>
        <link rel="stylesheet" href="https://cdn.datatables.net/1.11.4/css/jquery.dataTables.min.css" />

        <script src="//cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js" defer></script>
        <link rel="stylesheet" href="//cdn.datatables.net/1.11.4/css/jquery.dataTables.min.css" />

html;

        $codigo = RegistroCheckInDao::getById($id);

        $lista_registrados = RegistroCheckInDao::getRegistrosAsistenciasByCodeAndLinea($id,1);

        $nombre_asistencia = RegistroCheckInDao::getRegistrosAsistenciasByCode($id)[0]['nombre_asistencia'];

        $tabla='';
        // var_dump($lista_registrados);
        foreach ($lista_registrados as $key => $value) {
            $tabla.=<<<html
            <tr>
                <td><b>{$value['nombre_completo']} </b> <span class="badge badge-info" style="color: white; background: {$value['color_linea']};"> {$value['nombre_linea_ejecutivo']} </span></td>
                <td>
                    <u><a href="mailto:{$value['email']}"><span class="fa fa-mail-bulk"> </span> {$value['email']}</a></u>
                    <br><br>
                    <u><a href="https://api.whatsapp.com/send?phone=52{$value['telefono']}&text=Buen%20d%C3%ADa,%20te%20contacto%20de%20parte%20del%20Equipo%20Grupo%20LAHE%20%F0%9F%98%80" target="_blank"><span class="fa fa-whatsapp" style="color:green;"> </span> {$value['telefono']}</a></u>
                </td>
                <td>
                    <b>Línea: </b>{$value['nombre_linea']}
                    <br>
                    <b>BU: </b>{$value['nombre_bu']}
                    <br>
                    <b>Posición: </b>{$value['nombre_posicion']} 
                </td>
                
html;
            if ($value['status'] == 1) {
                $tabla.=<<<html
                <td class="text-center"><span class="badge badge-success">En Tiempo</span><td>
                <td>
                    <button class="btn btn-danger " onclick="borrarRegister({$value['id_registro_asistencia']})" type="button" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-original-title="Eliminar Registro de {$value['nombre_completo']}">
                        <i class="fas fa-trash"></i>
                    </button>
                </td>
            </tr>
html;
            } else if ($value['status'] == 2){
                $tabla.=<<<html
                <td class="text-center"><span class="badge badge-danger">Fuera del Horario</span><td>
                <td>
                    <button class="btn btn-danger " onclick="borrarRegister({$value['id_registro_asistencia']})" type="button" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-original-title="Eliminar Registro de {$value['nombre_completo']}">
                        <i class="fas fa-trash"></i>
                    </button>
                </td>
            </tr>
html;
            }
        }

        $etiqueta_linea =<<<html
            <span class="badge badge-info" style="background: #34332f; color: white;">Directivos</span>    
html;

        foreach($codigo as $key => $value)
        {
            if($value['id_asistencia'] != '')
            {
                $flag = true;
                $nombre = $value['nombre'];
                $descripcion = $value['descripcion'];
                $fecha_asistencia = $value['fecha_asistencia'];
                $hora_asistencia_inicio = $value['hora_asistencia_inicio'];
                $hora_asistencia_fin = $value['hora_asistencia_fin'];
            }
        }


        ///--------------------FALTANTES--------------------///
        $lista_faltantes = RegistroCheckInDao::getRegistrosAsistenciasFaltantes($id,1);
        $tabla_faltantes='';
        foreach ($lista_faltantes as $key => $value) {
            $tabla_faltantes.=<<<html
            <tr>
                <td><b>{$value['nombre_completo']} </b> <span class="badge badge-info" style="color: white; background: {$value['color_linea']};"> {$value['nombre_linea_ejecutivo']} </span></td>
                <td>
                    <u><a href="mailto:{$value['email']}"><span class="fa fa-mail-bulk"> </span> {$value['email']}</a></u>
                    <br><br>
                    <u><a href="https://api.whatsapp.com/send?phone=52{$value['telefono']}&text=Buen%20d%C3%ADa,%20te%20contacto%20de%20parte%20del%20Equipo%20Grupo%20LAHE%20%F0%9F%98%80" target="_blank"><span class="fa fa-whatsapp" style="color:green;"> </span> {$value['telefono']}</a></u>
                </td>
                <td>
                    <b>Línea: </b>{$value['nombre_linea']}
                    <br>
                    <b>BU: </b>{$value['nombre_bu']}
                    <br>
                    <b>Posición: </b>{$value['nombre_posicion']} 
                </td>
                <td>
                    <button class="btn btn-danger " onclick="borrarRegister({$value['id_registro_asistencia']})" type="button" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-original-title="Eliminar Registro de {$value['nombre_completo']}">
                        <i class="fas fa-trash"></i>
                    </button>
                </td>
            </tr>
html;
        }
        ///-------------------------------------------------///


        if($flag == true)
        {
            View::set('tabla',$tabla);
            View::set('tabla_faltantes',$tabla_faltantes);
            View::set('nombre',$nombre);
            View::set('etiqueta_linea',$etiqueta_linea);
            View::set('descripcion',$descripcion);
            View::set('nombre_asistencia',$nombre_asistencia);
            View::set('fecha_asistencia',$fecha_asistencia);
            View::set('hora_asistencia_inicio',$hora_asistencia_inicio);
            View::set('hora_asistencia_fin',$hora_asistencia_fin);
            View::set('header',$extraHeader);
            View::set('footer',$extraFooter);
            View::render("registro_asistencias_checkin");
        }
        else
        {
            // View::render("asistencias_panel_registro");
            View::render("asistencias_all_vacia");
        }
    }

    //----------STAFF----------//
    public function staff($id) {
        $extraHeader =<<<html
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link rel="apple-touch-icon" sizes="76x76" href="/assets/img/favicon.png">
        <link rel="icon" type="image/png" href="/assets/img/favicon.png">
        <title>
            Staff - Asistencia CONAVE Convención 2022 ASOFARMA
        </title>
        <!--     Fonts and icons     -->
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
        <!-- Nucleo Icons -->
        <link href="/assets/css/nucleo-icons.css" rel="stylesheet" />
        <link href="/assets/css/nucleo-svg.css" rel="stylesheet" />
        <!-- Font Awesome Icons -->
        <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
        <link href="/assets/css/nucleo-svg.css" rel="stylesheet" />
        <!-- CSS Files -->
        <link id="pagestyle" href="/assets/css/soft-ui-dashboard.css?v=1.0.5" rel="stylesheet" />
        <link rel="stylesheet" href="/css/alertify/alertify.core.css" />
        <link rel="stylesheet" href="/css/alertify/alertify.default.css" id="toggleCSS" />
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
        <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

html;
        $extraFooter =<<<html
        <script src="/js/jquery.min.js"></script>
        <script src="/js/validate/jquery.validate.js"></script>
        <script src="/js/alertify/alertify.min.js"></script>
        <!-- -------- END FOOTER 3 w/ COMPANY DESCRIPTION WITH LINKS & SOCIAL ICONS & COPYRIGHT ------- -->
        <!--   Core JS Files   -->
        <script src="/assets/js/core/popper.min.js"></script>
        <script src="/assets/js/core/bootstrap.min.js"></script>
        <script src="/assets/js/plugins/perfect-scrollbar.min.js"></script>
        <script src="/assets/js/plugins/smooth-scrollbar.min.js"></script>
        <!-- Kanban scripts -->
        <script src="/assets/js/plugins/dragula/dragula.min.js"></script>
        <script src="/assets/js/plugins/jkanban/jkanban.js"></script>
        <script>
            var win = navigator.platform.indexOf('Win') > -1;
            if (win && document.querySelector('#sidenav-scrollbar')) {
                var options = {
                    damping: '0.5'
                }
                Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
            }
        </script>
        <!-- Github buttons -->
        <script async defer src="https://buttons.github.io/buttons.js"></script>
        <!-- Control Center for Soft Dashboard: parallax effects, scripts for the example pages etc -->
        <script src="/assets/js/soft-ui-dashboard.min.js?v=1.0.5"></script>
        <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

        <script src="http://cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js" defer></script>
        <link rel="stylesheet" href="http://cdn.datatables.net/1.11.4/css/jquery.dataTables.min.css" />
        
        <script src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js" defer></script>
        <link rel="stylesheet" href="https://cdn.datatables.net/1.11.4/css/jquery.dataTables.min.css" />

        <script src="//cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js" defer></script>
        <link rel="stylesheet" href="//cdn.datatables.net/1.11.4/css/jquery.dataTables.min.css" />

html;

        $codigo = RegistroCheckInDao::getById($id);

        $lista_registrados = RegistroCheckInDao::getRegistrosAsistenciasByCodeAndLinea($id,2);

        $nombre_asistencia = RegistroCheckInDao::getRegistrosAsistenciasByCode($id)[0]['nombre_asistencia'];

        $tabla='';
        foreach ($lista_registrados as $key => $value) {
            $tabla.=<<<html
            <tr>
                <td><b>{$value['nombre_completo']} </b> <span class="badge badge-info" style="color: white; background: {$value['color_linea']};"> {$value['nombre_linea_ejecutivo']} </span></td>
                <td>
                    <u><a href="mailto:{$value['email']}"><span class="fa fa-mail-bulk"> </span> {$value['email']}</a></u>
                    <br><br>
                    <u><a href="https://api.whatsapp.com/send?phone=52{$value['telefono']}&text=Buen%20d%C3%ADa,%20te%20contacto%20de%20parte%20del%20Equipo%20Grupo%20LAHE%20%F0%9F%98%80" target="_blank"><span class="fa fa-whatsapp" style="color:green;"> </span> {$value['telefono']}</a></u>
                </td>
                <td>
                    <b>Línea: </b>{$value['nombre_linea']}
                    <br>
                    <b>BU: </b>{$value['nombre_bu']}
                    <br>
                    <b>Posición: </b>{$value['nombre_posicion']} 
                </td>
                
html;
            if ($value['status'] == 1) {
                $tabla.=<<<html
                <td class="text-center"><span class="badge badge-success">En Tiempo</span><td>
                <td>
                    <button class="btn btn-danger " onclick="borrarRegister({$value['id_registro_asistencia']})" type="button" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-original-title="Eliminar Registro de {$value['nombre_completo']}">
                        <i class="fas fa-trash"></i>
                    </button>
                </td>
            </tr>
html;
            } else if ($value['status'] == 2){
                $tabla.=<<<html
                <td class="text-center"><span class="badge badge-danger">Fuera del Horario</span><td>
                <td>
                    <button class="btn btn-danger " onclick="borrarRegister({$value['id_registro_asistencia']})" type="button" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-original-title="Eliminar Registro de {$value['nombre_completo']}">
                        <i class="fas fa-trash"></i>
                    </button>
                </td>
            </tr>
html;
            }
        }

        $etiqueta_linea =<<<html
            <span class="badge badge-info" style="background: #3a3c3d; color: white;">Staff</span>    
html;

        foreach($codigo as $key => $value)
        {
            if($value['id_asistencia'] != '')
            {
                $flag = true;
                $nombre = $value['nombre'];
                $descripcion = $value['descripcion'];
                $fecha_asistencia = $value['fecha_asistencia'];
                $hora_asistencia_inicio = $value['hora_asistencia_inicio'];
                $hora_asistencia_fin = $value['hora_asistencia_fin'];
            }
        }


        ///--------------------FALTANTES--------------------///
        $lista_faltantes = RegistroCheckInDao::getRegistrosAsistenciasFaltantes($id,2);
        $tabla_faltantes='';
        foreach ($lista_faltantes as $key => $value) {
            $tabla_faltantes.=<<<html
            <tr>
                <td><b>{$value['nombre_completo']} </b> <span class="badge badge-info" style="color: white; background: {$value['color_linea']};"> {$value['nombre_linea_ejecutivo']} </span></td>
                <td>
                    <u><a href="mailto:{$value['email']}"><span class="fa fa-mail-bulk"> </span> {$value['email']}</a></u>
                    <br><br>
                    <u><a href="https://api.whatsapp.com/send?phone=52{$value['telefono']}&text=Buen%20d%C3%ADa,%20te%20contacto%20de%20parte%20del%20Equipo%20Grupo%20LAHE%20%F0%9F%98%80" target="_blank"><span class="fa fa-whatsapp" style="color:green;"> </span> {$value['telefono']}</a></u>
                </td>
                <td>
                    <b>Línea: </b>{$value['nombre_linea']}
                    <br>
                    <b>BU: </b>{$value['nombre_bu']}
                    <br>
                    <b>Posición: </b>{$value['nombre_posicion']} 
                </td>
                <td>
                    <button class="btn btn-danger " onclick="borrarRegister({$value['id_registro_asistencia']})" type="button" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-original-title="Eliminar Registro de {$value['nombre_completo']}">
                        <i class="fas fa-trash"></i>
                    </button>
                </td>
            </tr>
html;
        }
        ///-------------------------------------------------///


        if($flag == true)
        {
            View::set('tabla',$tabla);
            View::set('tabla_faltantes',$tabla_faltantes);
            View::set('nombre',$nombre);
            View::set('etiqueta_linea',$etiqueta_linea);
            View::set('descripcion',$descripcion);
            View::set('nombre_asistencia',$nombre_asistencia);
            View::set('fecha_asistencia',$fecha_asistencia);
            View::set('hora_asistencia_inicio',$hora_asistencia_inicio);
            View::set('hora_asistencia_fin',$hora_asistencia_fin);
            View::set('header',$extraHeader);
            View::set('footer',$extraFooter);
            View::render("registro_asistencias_checkin");
        }
        else
        {
            // View::render("asistencias_panel_registro");
            View::render("asistencias_all_vacia");
        }
    }

    //----------NEUROCIENCIAS----------//
    public function neurociencias($id) {
        $extraHeader =<<<html
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link rel="apple-touch-icon" sizes="76x76" href="/assets/img/favicon.png">
        <link rel="icon" type="image/png" href="/assets/img/favicon.png">
        <title>
            Neurociencias - Asistencia CONAVE Convención 2022 ASOFARMA
        </title>
        <!--     Fonts and icons     -->
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
        <!-- Nucleo Icons -->
        <link href="/assets/css/nucleo-icons.css" rel="stylesheet" />
        <link href="/assets/css/nucleo-svg.css" rel="stylesheet" />
        <!-- Font Awesome Icons -->
        <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
        <link href="/assets/css/nucleo-svg.css" rel="stylesheet" />
        <!-- CSS Files -->
        <link id="pagestyle" href="/assets/css/soft-ui-dashboard.css?v=1.0.5" rel="stylesheet" />
        <link rel="stylesheet" href="/css/alertify/alertify.core.css" />
        <link rel="stylesheet" href="/css/alertify/alertify.default.css" id="toggleCSS" />
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
        <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

html;
        $extraFooter =<<<html
        <script src="/js/jquery.min.js"></script>
        <script src="/js/validate/jquery.validate.js"></script>
        <script src="/js/alertify/alertify.min.js"></script>
        <!-- -------- END FOOTER 3 w/ COMPANY DESCRIPTION WITH LINKS & SOCIAL ICONS & COPYRIGHT ------- -->
        <!--   Core JS Files   -->
        <script src="/assets/js/core/popper.min.js"></script>
        <script src="/assets/js/core/bootstrap.min.js"></script>
        <script src="/assets/js/plugins/perfect-scrollbar.min.js"></script>
        <script src="/assets/js/plugins/smooth-scrollbar.min.js"></script>
        <!-- Kanban scripts -->
        <script src="/assets/js/plugins/dragula/dragula.min.js"></script>
        <script src="/assets/js/plugins/jkanban/jkanban.js"></script>
        <script>
            var win = navigator.platform.indexOf('Win') > -1;
            if (win && document.querySelector('#sidenav-scrollbar')) {
                var options = {
                    damping: '0.5'
                }
                Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
            }
        </script>
        <!-- Github buttons -->
        <script async defer src="https://buttons.github.io/buttons.js"></script>
        <!-- Control Center for Soft Dashboard: parallax effects, scripts for the example pages etc -->
        <script src="/assets/js/soft-ui-dashboard.min.js?v=1.0.5"></script>
        <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

        <script src="http://cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js" defer></script>
        <link rel="stylesheet" href="http://cdn.datatables.net/1.11.4/css/jquery.dataTables.min.css" />
        
        <script src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js" defer></script>
        <link rel="stylesheet" href="https://cdn.datatables.net/1.11.4/css/jquery.dataTables.min.css" />

        <script src="//cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js" defer></script>
        <link rel="stylesheet" href="//cdn.datatables.net/1.11.4/css/jquery.dataTables.min.css" />

html;

        $codigo = RegistroCheckInDao::getById($id);

        $lista_registrados = RegistroCheckInDao::getRegistrosAsistenciasByCodeAndLinea($id,3);

        $nombre_asistencia = RegistroCheckInDao::getRegistrosAsistenciasByCode($id)[0]['nombre_asistencia'];

        $tabla='';
        foreach ($lista_registrados as $key => $value) {
            $tabla.=<<<html
            <tr>
                <td><b>{$value['nombre_completo']} </b> <span class="badge badge-info" style="color: white; background: {$value['color_linea']};"> {$value['nombre_linea_ejecutivo']} </span></td>
                <td>
                    <u><a href="mailto:{$value['email']}"><span class="fa fa-mail-bulk"> </span> {$value['email']}</a></u>
                    <br><br>
                    <u><a href="https://api.whatsapp.com/send?phone=52{$value['telefono']}&text=Buen%20d%C3%ADa,%20te%20contacto%20de%20parte%20del%20Equipo%20Grupo%20LAHE%20%F0%9F%98%80" target="_blank"><span class="fa fa-whatsapp" style="color:green;"> </span> {$value['telefono']}</a></u>
                </td>
                <td>
                    <b>Línea: </b>{$value['nombre_linea']}
                    <br>
                    <b>BU: </b>{$value['nombre_bu']}
                    <br>
                    <b>Posición: </b>{$value['nombre_posicion']} 
                </td>
                
html;
            if ($value['status'] == 1) {
                $tabla.=<<<html
                <td class="text-center"><span class="badge badge-success">En Tiempo</span><td>
                <td>
                    <button class="btn btn-danger " onclick="borrarRegister({$value['id_registro_asistencia']})" type="button" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-original-title="Eliminar Registro de {$value['nombre_completo']}">
                        <i class="fas fa-trash"></i>
                    </button>
                </td>
            </tr>
html;
            } else if ($value['status'] == 2){
                $tabla.=<<<html
                <td class="text-center"><span class="badge badge-danger">Fuera del Horario</span><td>
                <td>
                    <button class="btn btn-danger " onclick="borrarRegister({$value['id_registro_asistencia']})" type="button" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-original-title="Eliminar Registro de {$value['nombre_completo']}">
                        <i class="fas fa-trash"></i>
                    </button>
                </td>
            </tr>
html;
            }
        }

        $etiqueta_linea =<<<html
            <span class="badge badge-info" style="background: #3154b5; color: white;">Neurociencias</span>    
html;

        foreach($codigo as $key => $value)
        {
            if($value['id_asistencia'] != '')
            {
                $flag = true;
                $nombre = $value['nombre'];
                $descripcion = $value['descripcion'];
                $fecha_asistencia = $value['fecha_asistencia'];
                $hora_asistencia_inicio = $value['hora_asistencia_inicio'];
                $hora_asistencia_fin = $value['hora_asistencia_fin'];
            }
        }


        ///--------------------FALTANTES--------------------///
        $lista_faltantes = RegistroCheckInDao::getRegistrosAsistenciasFaltantes($id,3);
        $tabla_faltantes='';
        foreach ($lista_faltantes as $key => $value) {
            $tabla_faltantes.=<<<html
            <tr>
                <td><b>{$value['nombre_completo']} </b> <span class="badge badge-info" style="color: white; background: {$value['color_linea']};"> {$value['nombre_linea_ejecutivo']} </span></td>
                <td>
                    <u><a href="mailto:{$value['email']}"><span class="fa fa-mail-bulk"> </span> {$value['email']}</a></u>
                    <br><br>
                    <u><a href="https://api.whatsapp.com/send?phone=52{$value['telefono']}&text=Buen%20d%C3%ADa,%20te%20contacto%20de%20parte%20del%20Equipo%20Grupo%20LAHE%20%F0%9F%98%80" target="_blank"><span class="fa fa-whatsapp" style="color:green;"> </span> {$value['telefono']}</a></u>
                </td>
                <td>
                    <b>Línea: </b>{$value['nombre_linea']}
                    <br>
                    <b>BU: </b>{$value['nombre_bu']}
                    <br>
                    <b>Posición: </b>{$value['nombre_posicion']} 
                </td>
                <td>
                    <button class="btn btn-danger " onclick="borrarRegister({$value['id_registro_asistencia']})" type="button" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-original-title="Eliminar Registro de {$value['nombre_completo']}">
                        <i class="fas fa-trash"></i>
                    </button>
                </td>
            </tr>
html;
        }
        ///-------------------------------------------------///


        if($flag == true)
        {
            View::set('tabla',$tabla);
            View::set('tabla_faltantes',$tabla_faltantes);
            View::set('nombre',$nombre);
            View::set('etiqueta_linea',$etiqueta_linea);
            View::set('descripcion',$descripcion);
            View::set('nombre_asistencia',$nombre_asistencia);
            View::set('fecha_asistencia',$fecha_asistencia);
            View::set('hora_asistencia_inicio',$hora_asistencia_inicio);
            View::set('hora_asistencia_fin',$hora_asistencia_fin);
            View::set('header',$extraHeader);
            View::set('footer',$extraFooter);
            View::render("registro_asistencias_checkin");
        }
        else
        {
            // View::render("asistencias_panel_registro");
            View::render("asistencias_all_vacia");
        }
    }

    //----------CARDIO----------//
    public function cardio($id) {
        $extraHeader =<<<html
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link rel="apple-touch-icon" sizes="76x76" href="/assets/img/favicon.png">
        <link rel="icon" type="image/png" href="/assets/img/favicon.png">
        <title>
            Cardio - Asistencia CONAVE Convención 2022 ASOFARMA
        </title>
        <!--     Fonts and icons     -->
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
        <!-- Nucleo Icons -->
        <link href="/assets/css/nucleo-icons.css" rel="stylesheet" />
        <link href="/assets/css/nucleo-svg.css" rel="stylesheet" />
        <!-- Font Awesome Icons -->
        <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
        <link href="/assets/css/nucleo-svg.css" rel="stylesheet" />
        <!-- CSS Files -->
        <link id="pagestyle" href="/assets/css/soft-ui-dashboard.css?v=1.0.5" rel="stylesheet" />
        <link rel="stylesheet" href="/css/alertify/alertify.core.css" />
        <link rel="stylesheet" href="/css/alertify/alertify.default.css" id="toggleCSS" />
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
        <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

html;
        $extraFooter =<<<html
        <script src="/js/jquery.min.js"></script>
        <script src="/js/validate/jquery.validate.js"></script>
        <script src="/js/alertify/alertify.min.js"></script>
        <!-- -------- END FOOTER 3 w/ COMPANY DESCRIPTION WITH LINKS & SOCIAL ICONS & COPYRIGHT ------- -->
        <!--   Core JS Files   -->
        <script src="/assets/js/core/popper.min.js"></script>
        <script src="/assets/js/core/bootstrap.min.js"></script>
        <script src="/assets/js/plugins/perfect-scrollbar.min.js"></script>
        <script src="/assets/js/plugins/smooth-scrollbar.min.js"></script>
        <!-- Kanban scripts -->
        <script src="/assets/js/plugins/dragula/dragula.min.js"></script>
        <script src="/assets/js/plugins/jkanban/jkanban.js"></script>
        <script>
            var win = navigator.platform.indexOf('Win') > -1;
            if (win && document.querySelector('#sidenav-scrollbar')) {
                var options = {
                    damping: '0.5'
                }
                Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
            }
        </script>
        <!-- Github buttons -->
        <script async defer src="https://buttons.github.io/buttons.js"></script>
        <!-- Control Center for Soft Dashboard: parallax effects, scripts for the example pages etc -->
        <script src="/assets/js/soft-ui-dashboard.min.js?v=1.0.5"></script>
        <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

        <script src="http://cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js" defer></script>
        <link rel="stylesheet" href="http://cdn.datatables.net/1.11.4/css/jquery.dataTables.min.css" />
        
        <script src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js" defer></script>
        <link rel="stylesheet" href="https://cdn.datatables.net/1.11.4/css/jquery.dataTables.min.css" />

        <script src="//cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js" defer></script>
        <link rel="stylesheet" href="//cdn.datatables.net/1.11.4/css/jquery.dataTables.min.css" />

html;

        $codigo = RegistroCheckInDao::getById($id);

        $lista_registrados = RegistroCheckInDao::getRegistrosAsistenciasByCodeAndLinea($id,6);

        $nombre_asistencia = RegistroCheckInDao::getRegistrosAsistenciasByCode($id)[0]['nombre_asistencia'];

        $tabla='';
        foreach ($lista_registrados as $key => $value) {
            $tabla.=<<<html
            <tr>
                <td><b>{$value['nombre_completo']} </b> <span class="badge badge-info" style="color: white; background: {$value['color_linea']};"> {$value['nombre_linea_ejecutivo']} </span></td>
                <td>
                    <u><a href="mailto:{$value['email']}"><span class="fa fa-mail-bulk"> </span> {$value['email']}</a></u>
                    <br><br>
                    <u><a href="https://api.whatsapp.com/send?phone=52{$value['telefono']}&text=Buen%20d%C3%ADa,%20te%20contacto%20de%20parte%20del%20Equipo%20Grupo%20LAHE%20%F0%9F%98%80" target="_blank"><span class="fa fa-whatsapp" style="color:green;"> </span> {$value['telefono']}</a></u>
                </td>
                <td>
                    <b>Línea: </b>{$value['nombre_linea']}
                    <br>
                    <b>BU: </b>{$value['nombre_bu']}
                    <br>
                    <b>Posición: </b>{$value['nombre_posicion']} 
                </td>
                
html;
            if ($value['status'] == 1) {
                $tabla.=<<<html
                <td class="text-center"><span class="badge badge-success">En Tiempo</span><td>
                <td>
                    <button class="btn btn-danger " onclick="borrarRegister({$value['id_registro_asistencia']})" type="button" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-original-title="Eliminar Registro de {$value['nombre_completo']}">
                        <i class="fas fa-trash"></i>
                    </button>
                </td>
            </tr>
html;
            } else if ($value['status'] == 2){
                $tabla.=<<<html
                <td class="text-center"><span class="badge badge-danger">Fuera del Horario</span><td>
                <td>
                    <button class="btn btn-danger " onclick="borrarRegister({$value['id_registro_asistencia']})" type="button" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-original-title="Eliminar Registro de {$value['nombre_completo']}">
                        <i class="fas fa-trash"></i>
                    </button>
                </td>
            </tr>
html;
            }
        }

        $etiqueta_linea =<<<html
            <span class="badge badge-info" style="background: #d62225; color: white;">Cardio</span>    
html;

        foreach($codigo as $key => $value)
        {
            if($value['id_asistencia'] != '')
            {
                $flag = true;
                $nombre = $value['nombre'];
                $descripcion = $value['descripcion'];
                $fecha_asistencia = $value['fecha_asistencia'];
                $hora_asistencia_inicio = $value['hora_asistencia_inicio'];
                $hora_asistencia_fin = $value['hora_asistencia_fin'];
            }
        }


        ///--------------------FALTANTES--------------------///
        $lista_faltantes = RegistroCheckInDao::getRegistrosAsistenciasFaltantes($id,6);
        $tabla_faltantes='';
        foreach ($lista_faltantes as $key => $value) {
            $tabla_faltantes.=<<<html
            <tr>
                <td><b>{$value['nombre_completo']} </b> <span class="badge badge-info" style="color: white; background: {$value['color_linea']};"> {$value['nombre_linea_ejecutivo']} </span></td>
                <td>
                    <u><a href="mailto:{$value['email']}"><span class="fa fa-mail-bulk"> </span> {$value['email']}</a></u>
                    <br><br>
                    <u><a href="https://api.whatsapp.com/send?phone=52{$value['telefono']}&text=Buen%20d%C3%ADa,%20te%20contacto%20de%20parte%20del%20Equipo%20Grupo%20LAHE%20%F0%9F%98%80" target="_blank"><span class="fa fa-whatsapp" style="color:green;"> </span> {$value['telefono']}</a></u>
                </td>
                <td>
                    <b>Línea: </b>{$value['nombre_linea']}
                    <br>
                    <b>BU: </b>{$value['nombre_bu']}
                    <br>
                    <b>Posición: </b>{$value['nombre_posicion']} 
                </td>
                <td>
                    <button class="btn btn-danger " onclick="borrarRegister({$value['id_registro_asistencia']})" type="button" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-original-title="Eliminar Registro de {$value['nombre_completo']}">
                        <i class="fas fa-trash"></i>
                    </button>
                </td>
            </tr>
html;
        }
        ///-------------------------------------------------///


        if($flag == true)
        {
            View::set('tabla',$tabla);
            View::set('tabla_faltantes',$tabla_faltantes);
            View::set('nombre',$nombre);
            View::set('etiqueta_linea',$etiqueta_linea);
            View::set('descripcion',$descripcion);
            View::set('nombre_asistencia',$nombre_asistencia);
            View::set('fecha_asistencia',$fecha_asistencia);
            View::set('hora_asistencia_inicio',$hora_asistencia_inicio);
            View::set('hora_asistencia_fin',$hora_asistencia_fin);
            View::set('header',$extraHeader);
            View::set('footer',$extraFooter);
            View::render("registro_asistencias_checkin");
        }
        else
        {
            // View::render("asistencias_panel_registro");
            View::render("asistencias_all_vacia");
        }
    }

    //-------------CARIO---------_--//
    public function uro($id) {
        $extraHeader =<<<html
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link rel="apple-touch-icon" sizes="76x76" href="/assets/img/favicon.png">
        <link rel="icon" type="image/png" href="/assets/img/favicon.png">
        <title>
            URO - Asistencia CONAVE Convención 2022 ASOFARMA
        </title>
        <!--     Fonts and icons     -->
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
        <!-- Nucleo Icons -->
        <link href="/assets/css/nucleo-icons.css" rel="stylesheet" />
        <link href="/assets/css/nucleo-svg.css" rel="stylesheet" />
        <!-- Font Awesome Icons -->
        <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
        <link href="/assets/css/nucleo-svg.css" rel="stylesheet" />
        <!-- CSS Files -->
        <link id="pagestyle" href="/assets/css/soft-ui-dashboard.css?v=1.0.5" rel="stylesheet" />
        <link rel="stylesheet" href="/css/alertify/alertify.core.css" />
        <link rel="stylesheet" href="/css/alertify/alertify.default.css" id="toggleCSS" />
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
        <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

html;
        $extraFooter =<<<html
        <script src="/js/jquery.min.js"></script>
        <script src="/js/validate/jquery.validate.js"></script>
        <script src="/js/alertify/alertify.min.js"></script>
        <!-- -------- END FOOTER 3 w/ COMPANY DESCRIPTION WITH LINKS & SOCIAL ICONS & COPYRIGHT ------- -->
        <!--   Core JS Files   -->
        <script src="/assets/js/core/popper.min.js"></script>
        <script src="/assets/js/core/bootstrap.min.js"></script>
        <script src="/assets/js/plugins/perfect-scrollbar.min.js"></script>
        <script src="/assets/js/plugins/smooth-scrollbar.min.js"></script>
        <!-- Kanban scripts -->
        <script src="/assets/js/plugins/dragula/dragula.min.js"></script>
        <script src="/assets/js/plugins/jkanban/jkanban.js"></script>
        <script>
            var win = navigator.platform.indexOf('Win') > -1;
            if (win && document.querySelector('#sidenav-scrollbar')) {
                var options = {
                    damping: '0.5'
                }
                Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
            }
        </script>
        <!-- Github buttons -->
        <script async defer src="https://buttons.github.io/buttons.js"></script>
        <!-- Control Center for Soft Dashboard: parallax effects, scripts for the example pages etc -->
        <script src="/assets/js/soft-ui-dashboard.min.js?v=1.0.5"></script>
        <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

        <script src="http://cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js" defer></script>
        <link rel="stylesheet" href="http://cdn.datatables.net/1.11.4/css/jquery.dataTables.min.css" />
        
        <script src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js" defer></script>
        <link rel="stylesheet" href="https://cdn.datatables.net/1.11.4/css/jquery.dataTables.min.css" />

        <script src="//cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js" defer></script>
        <link rel="stylesheet" href="//cdn.datatables.net/1.11.4/css/jquery.dataTables.min.css" />

html;

        $codigo = RegistroCheckInDao::getById($id);

        $lista_registrados = RegistroCheckInDao::getRegistrosAsistenciasByCodeAndLinea($id,7);
        $nombre_asistencia = RegistroCheckInDao::getRegistrosAsistenciasByCode($id)[0]['nombre_asistencia'];

        $tabla='';
        foreach ($lista_registrados as $key => $value) {
            $tabla.=<<<html
            <tr>
                <td><b>{$value['nombre_completo']} </b> <span class="badge badge-info" style="color: white; background: {$value['color_linea']};"> {$value['nombre_linea_ejecutivo']} </span></td>
                <td>
                    <u><a href="mailto:{$value['email']}"><span class="fa fa-mail-bulk"> </span> {$value['email']}</a></u>
                    <br><br>
                    <u><a href="https://api.whatsapp.com/send?phone=52{$value['telefono']}&text=Buen%20d%C3%ADa,%20te%20contacto%20de%20parte%20del%20Equipo%20Grupo%20LAHE%20%F0%9F%98%80" target="_blank"><span class="fa fa-whatsapp" style="color:green;"> </span> {$value['telefono']}</a></u>
                </td>
                <td>
                    <b>Línea: </b>{$value['nombre_linea']}
                    <br>
                    <b>BU: </b>{$value['nombre_bu']}
                    <br>
                    <b>Posición: </b>{$value['nombre_posicion']} 
                </td>
                
html;
            if ($value['status'] == 1) {
                $tabla.=<<<html
                <td class="text-center"><span class="badge badge-success">En Tiempo</span><td>
                <td>
                    <button class="btn btn-danger " onclick="borrarRegister({$value['id_registro_asistencia']})" type="button" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-original-title="Eliminar Registro de {$value['nombre_completo']}">
                        <i class="fas fa-trash"></i>
                    </button>
                </td>
            </tr>
html;
            } else if ($value['status'] == 2){
                $tabla.=<<<html
                <td class="text-center"><span class="badge badge-danger">Fuera del Horario</span><td>
                <td>
                    <button class="btn btn-danger " onclick="borrarRegister({$value['id_registro_asistencia']})" type="button" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-original-title="Eliminar Registro de {$value['nombre_completo']}">
                        <i class="fas fa-trash"></i>
                    </button>
                </td>
            </tr>
html;
            }
        }

        $etiqueta_linea =<<<html
            <span class="badge badge-info" style="background: #8165ac; color: white;">URO</span>    
html;

        foreach($codigo as $key => $value)
        {
            if($value['id_asistencia'] != '')
            {
                $flag = true;
                $nombre = $value['nombre'];
                $descripcion = $value['descripcion'];
                $fecha_asistencia = $value['fecha_asistencia'];
                $hora_asistencia_inicio = $value['hora_asistencia_inicio'];
                $hora_asistencia_fin = $value['hora_asistencia_fin'];
            }
        }

        ///--------------------FALTANTES--------------------///
        $lista_faltantes = RegistroCheckInDao::getRegistrosAsistenciasFaltantes($id,7);
        $tabla_faltantes='';
        foreach ($lista_faltantes as $key => $value) {
            $tabla_faltantes.=<<<html
            <tr>
                <td><b>{$value['nombre_completo']} </b> <span class="badge badge-info" style="color: white; background: {$value['color_linea']};"> {$value['nombre_linea_ejecutivo']} </span></td>
                <td>
                    <u><a href="mailto:{$value['email']}"><span class="fa fa-mail-bulk"> </span> {$value['email']}</a></u>
                    <br><br>
                    <u><a href="https://api.whatsapp.com/send?phone=52{$value['telefono']}&text=Buen%20d%C3%ADa,%20te%20contacto%20de%20parte%20del%20Equipo%20Grupo%20LAHE%20%F0%9F%98%80" target="_blank"><span class="fa fa-whatsapp" style="color:green;"> </span> {$value['telefono']}</a></u>
                </td>
                <td>
                    <b>Línea: </b>{$value['nombre_linea']}
                    <br>
                    <b>BU: </b>{$value['nombre_bu']}
                    <br>
                    <b>Posición: </b>{$value['nombre_posicion']} 
                </td>
                <td>
                    <button class="btn btn-danger " onclick="borrarRegister({$value['id_registro_asistencia']})" type="button" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-original-title="Eliminar Registro de {$value['nombre_completo']}">
                        <i class="fas fa-trash"></i>
                    </button>
                </td>
            </tr>
html;
        }
        ///-------------------------------------------------///


        if($flag == true)
        {
            View::set('tabla',$tabla);
            View::set('tabla_faltantes',$tabla_faltantes);
            View::set('nombre',$nombre);
            View::set('etiqueta_linea',$etiqueta_linea);
            View::set('descripcion',$descripcion);
            View::set('nombre_asistencia',$nombre_asistencia);
            View::set('fecha_asistencia',$fecha_asistencia);
            View::set('hora_asistencia_inicio',$hora_asistencia_inicio);
            View::set('hora_asistencia_fin',$hora_asistencia_fin);
            View::set('header',$extraHeader);
            View::set('footer',$extraFooter);
            View::render("registro_asistencias_checkin");
        }
        else
        {
            // View::render("asistencias_panel_registro");
            View::render("asistencias_all_vacia");
        }
    }

    //----------GASTRO----------//
    public function gastro($id) {
        $extraHeader =<<<html
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link rel="apple-touch-icon" sizes="76x76" href="/assets/img/favicon.png">
        <link rel="icon" type="image/png" href="/assets/img/favicon.png">
        <title>
            Gastro - Asistencia CONAVE Convención 2022 ASOFARMA
        </title>
        <!--     Fonts and icons     -->
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
        <!-- Nucleo Icons -->
        <link href="/assets/css/nucleo-icons.css" rel="stylesheet" />
        <link href="/assets/css/nucleo-svg.css" rel="stylesheet" />
        <!-- Font Awesome Icons -->
        <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
        <link href="/assets/css/nucleo-svg.css" rel="stylesheet" />
        <!-- CSS Files -->
        <link id="pagestyle" href="/assets/css/soft-ui-dashboard.css?v=1.0.5" rel="stylesheet" />
        <link rel="stylesheet" href="/css/alertify/alertify.core.css" />
        <link rel="stylesheet" href="/css/alertify/alertify.default.css" id="toggleCSS" />
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
        <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

html;
        $extraFooter =<<<html
        <script src="/js/jquery.min.js"></script>
        <script src="/js/validate/jquery.validate.js"></script>
        <script src="/js/alertify/alertify.min.js"></script>
        <!-- -------- END FOOTER 3 w/ COMPANY DESCRIPTION WITH LINKS & SOCIAL ICONS & COPYRIGHT ------- -->
        <!--   Core JS Files   -->
        <script src="/assets/js/core/popper.min.js"></script>
        <script src="/assets/js/core/bootstrap.min.js"></script>
        <script src="/assets/js/plugins/perfect-scrollbar.min.js"></script>
        <script src="/assets/js/plugins/smooth-scrollbar.min.js"></script>
        <!-- Kanban scripts -->
        <script src="/assets/js/plugins/dragula/dragula.min.js"></script>
        <script src="/assets/js/plugins/jkanban/jkanban.js"></script>
        <script>
            var win = navigator.platform.indexOf('Win') > -1;
            if (win && document.querySelector('#sidenav-scrollbar')) {
                var options = {
                    damping: '0.5'
                }
                Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
            }
        </script>
        <!-- Github buttons -->
        <script async defer src="https://buttons.github.io/buttons.js"></script>
        <!-- Control Center for Soft Dashboard: parallax effects, scripts for the example pages etc -->
        <script src="/assets/js/soft-ui-dashboard.min.js?v=1.0.5"></script>
        <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

        <script src="http://cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js" defer></script>
        <link rel="stylesheet" href="http://cdn.datatables.net/1.11.4/css/jquery.dataTables.min.css" />
        
        <script src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js" defer></script>
        <link rel="stylesheet" href="https://cdn.datatables.net/1.11.4/css/jquery.dataTables.min.css" />

        <script src="//cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js" defer></script>
        <link rel="stylesheet" href="//cdn.datatables.net/1.11.4/css/jquery.dataTables.min.css" />

html;

        $codigo = RegistroCheckInDao::getById($id);

        $lista_registrados = RegistroCheckInDao::getRegistrosAsistenciasByCodeAndLinea($id,8);

        $nombre_asistencia = RegistroCheckInDao::getRegistrosAsistenciasByCode($id)[0]['nombre_asistencia'];

        $tabla='';
        foreach ($lista_registrados as $key => $value) {
            $tabla.=<<<html
            <tr>
                <td><b>{$value['nombre_completo']} </b> <span class="badge badge-info" style="color: white; background: {$value['color_linea']};"> {$value['nombre_linea_ejecutivo']} </span></td>
                <td>
                    <u><a href="mailto:{$value['email']}"><span class="fa fa-mail-bulk"> </span> {$value['email']}</a></u>
                    <br><br>
                    <u><a href="https://api.whatsapp.com/send?phone=52{$value['telefono']}&text=Buen%20d%C3%ADa,%20te%20contacto%20de%20parte%20del%20Equipo%20Grupo%20LAHE%20%F0%9F%98%80" target="_blank"><span class="fa fa-whatsapp" style="color:green;"> </span> {$value['telefono']}</a></u>
                </td>
                <td>
                    <b>Línea: </b>{$value['nombre_linea']}
                    <br>
                    <b>BU: </b>{$value['nombre_bu']}
                    <br>
                    <b>Posición: </b>{$value['nombre_posicion']} 
                </td>
                
html;
            if ($value['status'] == 1) {
                $tabla.=<<<html
                <td class="text-center"><span class="badge badge-success">En Tiempo</span><td>
                <td>
                    <button class="btn btn-danger " onclick="borrarRegister({$value['id_registro_asistencia']})" type="button" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-original-title="Eliminar Registro de {$value['nombre_completo']}">
                        <i class="fas fa-trash"></i>
                    </button>
                </td>
            </tr>
html;
            } else if ($value['status'] == 2){
                $tabla.=<<<html
                <td class="text-center"><span class="badge badge-danger">Fuera del Horario</span><td>
                <td>
                    <button class="btn btn-danger " onclick="borrarRegister({$value['id_registro_asistencia']})" type="button" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-original-title="Eliminar Registro de {$value['nombre_completo']}">
                        <i class="fas fa-trash"></i>
                    </button>
                </td>
            </tr>
html;
            }
        }

        $etiqueta_linea =<<<html
            <span class="badge badge-info" style="background: #4ab856; color: white;">Gastro</span>    
html;

        foreach($codigo as $key => $value)
        {
            if($value['id_asistencia'] != '')
            {
                $flag = true;
                $nombre = $value['nombre'];
                $descripcion = $value['descripcion'];
                $fecha_asistencia = $value['fecha_asistencia'];
                $hora_asistencia_inicio = $value['hora_asistencia_inicio'];
                $hora_asistencia_fin = $value['hora_asistencia_fin'];
            }
        }


        ///--------------------FALTANTES--------------------///
        $lista_faltantes = RegistroCheckInDao::getRegistrosAsistenciasFaltantes($id,8);
        $tabla_faltantes='';
        foreach ($lista_faltantes as $key => $value) {
            $tabla_faltantes.=<<<html
            <tr>
                <td><b>{$value['nombre_completo']} </b> <span class="badge badge-info" style="color: white; background: {$value['color_linea']};"> {$value['nombre_linea_ejecutivo']} </span></td>
                <td>
                    <u><a href="mailto:{$value['email']}"><span class="fa fa-mail-bulk"> </span> {$value['email']}</a></u>
                    <br><br>
                    <u><a href="https://api.whatsapp.com/send?phone=52{$value['telefono']}&text=Buen%20d%C3%ADa,%20te%20contacto%20de%20parte%20del%20Equipo%20Grupo%20LAHE%20%F0%9F%98%80" target="_blank"><span class="fa fa-whatsapp" style="color:green;"> </span> {$value['telefono']}</a></u>
                </td>
                <td>
                    <b>Línea: </b>{$value['nombre_linea']}
                    <br>
                    <b>BU: </b>{$value['nombre_bu']}
                    <br>
                    <b>Posición: </b>{$value['nombre_posicion']} 
                </td>
                <td>
                    <button class="btn btn-danger " onclick="borrarRegister({$value['id_registro_asistencia']})" type="button" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-original-title="Eliminar Registro de {$value['nombre_completo']}">
                        <i class="fas fa-trash"></i>
                    </button>
                </td>
            </tr>
html;
        }
        ///-------------------------------------------------///


        if($flag == true)
        {
            View::set('tabla',$tabla);
            View::set('tabla_faltantes',$tabla_faltantes);
            View::set('nombre',$nombre);
            View::set('etiqueta_linea',$etiqueta_linea);
            View::set('descripcion',$descripcion);
            View::set('nombre_asistencia',$nombre_asistencia);
            View::set('fecha_asistencia',$fecha_asistencia);
            View::set('hora_asistencia_inicio',$hora_asistencia_inicio);
            View::set('hora_asistencia_fin',$hora_asistencia_fin);
            View::set('header',$extraHeader);
            View::set('footer',$extraFooter);
            View::render("registro_asistencias_checkin");
        }
        else
        {
            // View::render("asistencias_panel_registro");
            View::render("asistencias_all_vacia");
        }
    }

    //----------GINECO----------//
    public function gineco($id) {
        $extraHeader =<<<html
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link rel="apple-touch-icon" sizes="76x76" href="/assets/img/favicon.png">
        <link rel="icon" type="image/png" href="/assets/img/favicon.png">
        <title>
            Gineco - Asistencia CONAVE Convención 2022 ASOFARMA
        </title>
        <!--     Fonts and icons     -->
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
        <!-- Nucleo Icons -->
        <link href="/assets/css/nucleo-icons.css" rel="stylesheet" />
        <link href="/assets/css/nucleo-svg.css" rel="stylesheet" />
        <!-- Font Awesome Icons -->
        <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
        <link href="/assets/css/nucleo-svg.css" rel="stylesheet" />
        <!-- CSS Files -->
        <link id="pagestyle" href="/assets/css/soft-ui-dashboard.css?v=1.0.5" rel="stylesheet" />
        <link rel="stylesheet" href="/css/alertify/alertify.core.css" />
        <link rel="stylesheet" href="/css/alertify/alertify.default.css" id="toggleCSS" />
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
        <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

html;
        $extraFooter =<<<html
        <script src="/js/jquery.min.js"></script>
        <script src="/js/validate/jquery.validate.js"></script>
        <script src="/js/alertify/alertify.min.js"></script>
        <!-- -------- END FOOTER 3 w/ COMPANY DESCRIPTION WITH LINKS & SOCIAL ICONS & COPYRIGHT ------- -->
        <!--   Core JS Files   -->
        <script src="/assets/js/core/popper.min.js"></script>
        <script src="/assets/js/core/bootstrap.min.js"></script>
        <script src="/assets/js/plugins/perfect-scrollbar.min.js"></script>
        <script src="/assets/js/plugins/smooth-scrollbar.min.js"></script>
        <!-- Kanban scripts -->
        <script src="/assets/js/plugins/dragula/dragula.min.js"></script>
        <script src="/assets/js/plugins/jkanban/jkanban.js"></script>
        <script>
            var win = navigator.platform.indexOf('Win') > -1;
            if (win && document.querySelector('#sidenav-scrollbar')) {
                var options = {
                    damping: '0.5'
                }
                Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
            }
        </script>
        <!-- Github buttons -->
        <script async defer src="https://buttons.github.io/buttons.js"></script>
        <!-- Control Center for Soft Dashboard: parallax effects, scripts for the example pages etc -->
        <script src="/assets/js/soft-ui-dashboard.min.js?v=1.0.5"></script>
        <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

        <script src="http://cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js" defer></script>
        <link rel="stylesheet" href="http://cdn.datatables.net/1.11.4/css/jquery.dataTables.min.css" />
        
        <script src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js" defer></script>
        <link rel="stylesheet" href="https://cdn.datatables.net/1.11.4/css/jquery.dataTables.min.css" />

        <script src="//cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js" defer></script>
        <link rel="stylesheet" href="//cdn.datatables.net/1.11.4/css/jquery.dataTables.min.css" />

html;

        $codigo = RegistroCheckInDao::getById($id);

        $lista_registrados = RegistroCheckInDao::getRegistrosAsistenciasByCodeAndLinea($id,9);

        $nombre_asistencia = RegistroCheckInDao::getRegistrosAsistenciasByCode($id)[0]['nombre_asistencia'];

        $tabla='';
        foreach ($lista_registrados as $key => $value) {
            $tabla.=<<<html
            <tr>
                <td><b>{$value['nombre_completo']} </b> <span class="badge badge-info" style="color: white; background: {$value['color_linea']};"> {$value['nombre_linea_ejecutivo']} </span></td>
                <td>
                    <u><a href="mailto:{$value['email']}"><span class="fa fa-mail-bulk"> </span> {$value['email']}</a></u>
                    <br><br>
                    <u><a href="https://api.whatsapp.com/send?phone=52{$value['telefono']}&text=Buen%20d%C3%ADa,%20te%20contacto%20de%20parte%20del%20Equipo%20Grupo%20LAHE%20%F0%9F%98%80" target="_blank"><span class="fa fa-whatsapp" style="color:green;"> </span> {$value['telefono']}</a></u>
                </td>
                <td>
                    <b>Línea: </b>{$value['nombre_linea']}
                    <br>
                    <b>BU: </b>{$value['nombre_bu']}
                    <br>
                    <b>Posición: </b>{$value['nombre_posicion']} 
                </td>
                
html;
            if ($value['status'] == 1) {
                $tabla.=<<<html
                <td class="text-center"><span class="badge badge-success">En Tiempo</span><td>
                <td>
                    <button class="btn btn-danger " onclick="borrarRegister({$value['id_registro_asistencia']})" type="button" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-original-title="Eliminar Registro de {$value['nombre_completo']}">
                        <i class="fas fa-trash"></i>
                    </button>
                </td>
            </tr>
html;
            } else if ($value['status'] == 2){
                $tabla.=<<<html
                <td class="text-center"><span class="badge badge-danger">Fuera del Horario</span><td>
                <td>
                    <button class="btn btn-danger " onclick="borrarRegister({$value['id_registro_asistencia']})" type="button" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-original-title="Eliminar Registro de {$value['nombre_completo']}">
                        <i class="fas fa-trash"></i>
                    </button>
                </td>
            </tr>
html;
            }
        }

        $etiqueta_linea =<<<html
            <span class="badge badge-info" style="background: #ae1858; color: white;">Gineco</span>    
html;

        foreach($codigo as $key => $value)
        {
            if($value['id_asistencia'] != '')
            {
                $flag = true;
                $nombre = $value['nombre'];
                $descripcion = $value['descripcion'];
                $fecha_asistencia = $value['fecha_asistencia'];
                $hora_asistencia_inicio = $value['hora_asistencia_inicio'];
                $hora_asistencia_fin = $value['hora_asistencia_fin'];
            }
        }


        ///--------------------FALTANTES--------------------///
        $lista_faltantes = RegistroCheckInDao::getRegistrosAsistenciasFaltantes($id,9);
        $tabla_faltantes='';
        foreach ($lista_faltantes as $key => $value) {
            $tabla_faltantes.=<<<html
            <tr>
                <td><b>{$value['nombre_completo']} </b> <span class="badge badge-info" style="color: white; background: {$value['color_linea']};"> {$value['nombre_linea_ejecutivo']} </span></td>
                <td>
                    <u><a href="mailto:{$value['email']}"><span class="fa fa-mail-bulk"> </span> {$value['email']}</a></u>
                    <br><br>
                    <u><a href="https://api.whatsapp.com/send?phone=52{$value['telefono']}&text=Buen%20d%C3%ADa,%20te%20contacto%20de%20parte%20del%20Equipo%20Grupo%20LAHE%20%F0%9F%98%80" target="_blank"><span class="fa fa-whatsapp" style="color:green;"> </span> {$value['telefono']}</a></u>
                </td>
                <td>
                    <b>Línea: </b>{$value['nombre_linea']}
                    <br>
                    <b>BU: </b>{$value['nombre_bu']}
                    <br>
                    <b>Posición: </b>{$value['nombre_posicion']} 
                </td>
                <td>
                    <button class="btn btn-danger " onclick="borrarRegister({$value['id_registro_asistencia']})" type="button" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-original-title="Eliminar Registro de {$value['nombre_completo']}">
                        <i class="fas fa-trash"></i>
                    </button>
                </td>
            </tr>
html;
        }
        ///-------------------------------------------------///


        if($flag == true)
        {
            View::set('tabla',$tabla);
            View::set('tabla_faltantes',$tabla_faltantes);
            View::set('nombre',$nombre);
            View::set('etiqueta_linea',$etiqueta_linea);
            View::set('descripcion',$descripcion);
            View::set('nombre_asistencia',$nombre_asistencia);
            View::set('fecha_asistencia',$fecha_asistencia);
            View::set('hora_asistencia_inicio',$hora_asistencia_inicio);
            View::set('hora_asistencia_fin',$hora_asistencia_fin);
            View::set('header',$extraHeader);
            View::set('footer',$extraFooter);
            View::render("registro_asistencias_checkin");
        }
        else
        {
            // View::render("asistencias_panel_registro");
            View::render("asistencias_all_vacia");
        }
    }

    //----------MEDICINAGENERAL----------//
    public function medicinaGeneral($id) {
        $extraHeader =<<<html
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link rel="apple-touch-icon" sizes="76x76" href="/assets/img/favicon.png">
        <link rel="icon" type="image/png" href="/assets/img/favicon.png">
        <title>
            Medicina General - Asistencia CONAVE Convención 2022 ASOFARMA
        </title>
        <!--     Fonts and icons     -->
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
        <!-- Nucleo Icons -->
        <link href="/assets/css/nucleo-icons.css" rel="stylesheet" />
        <link href="/assets/css/nucleo-svg.css" rel="stylesheet" />
        <!-- Font Awesome Icons -->
        <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
        <link href="/assets/css/nucleo-svg.css" rel="stylesheet" />
        <!-- CSS Files -->
        <link id="pagestyle" href="/assets/css/soft-ui-dashboard.css?v=1.0.5" rel="stylesheet" />
        <link rel="stylesheet" href="/css/alertify/alertify.core.css" />
        <link rel="stylesheet" href="/css/alertify/alertify.default.css" id="toggleCSS" />
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
        <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

html;
        $extraFooter =<<<html
        <script src="/js/jquery.min.js"></script>
        <script src="/js/validate/jquery.validate.js"></script>
        <script src="/js/alertify/alertify.min.js"></script>
        <!-- -------- END FOOTER 3 w/ COMPANY DESCRIPTION WITH LINKS & SOCIAL ICONS & COPYRIGHT ------- -->
        <!--   Core JS Files   -->
        <script src="/assets/js/core/popper.min.js"></script>
        <script src="/assets/js/core/bootstrap.min.js"></script>
        <script src="/assets/js/plugins/perfect-scrollbar.min.js"></script>
        <script src="/assets/js/plugins/smooth-scrollbar.min.js"></script>
        <!-- Kanban scripts -->
        <script src="/assets/js/plugins/dragula/dragula.min.js"></script>
        <script src="/assets/js/plugins/jkanban/jkanban.js"></script>
        <script>
            var win = navigator.platform.indexOf('Win') > -1;
            if (win && document.querySelector('#sidenav-scrollbar')) {
                var options = {
                    damping: '0.5'
                }
                Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
            }
        </script>
        <!-- Github buttons -->
        <script async defer src="https://buttons.github.io/buttons.js"></script>
        <!-- Control Center for Soft Dashboard: parallax effects, scripts for the example pages etc -->
        <script src="/assets/js/soft-ui-dashboard.min.js?v=1.0.5"></script>
        <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

        <script src="http://cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js" defer></script>
        <link rel="stylesheet" href="http://cdn.datatables.net/1.11.4/css/jquery.dataTables.min.css" />
        
        <script src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js" defer></script>
        <link rel="stylesheet" href="https://cdn.datatables.net/1.11.4/css/jquery.dataTables.min.css" />

        <script src="//cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js" defer></script>
        <link rel="stylesheet" href="//cdn.datatables.net/1.11.4/css/jquery.dataTables.min.css" />

html;

        $codigo = RegistroCheckInDao::getById($id);

        $lista_registrados = RegistroCheckInDao::getRegistrosAsistenciasByCodeAndLinea($id,10);

        $nombre_asistencia = RegistroCheckInDao::getRegistrosAsistenciasByCode($id)[0]['nombre_asistencia'];

        $tabla='';
        foreach ($lista_registrados as $key => $value) {
            $tabla.=<<<html
            <tr>
                <td><b>{$value['nombre_completo']} </b> <span class="badge badge-info" style="color: white; background: {$value['color_linea']};"> {$value['nombre_linea_ejecutivo']} </span></td>
                <td>
                    <u><a href="mailto:{$value['email']}"><span class="fa fa-mail-bulk"> </span> {$value['email']}</a></u>
                    <br><br>
                    <u><a href="https://api.whatsapp.com/send?phone=52{$value['telefono']}&text=Buen%20d%C3%ADa,%20te%20contacto%20de%20parte%20del%20Equipo%20Grupo%20LAHE%20%F0%9F%98%80" target="_blank"><span class="fa fa-whatsapp" style="color:green;"> </span> {$value['telefono']}</a></u>
                </td>
                <td>
                    <b>Línea: </b>{$value['nombre_linea']}
                    <br>
                    <b>BU: </b>{$value['nombre_bu']}
                    <br>
                    <b>Posición: </b>{$value['nombre_posicion']} 
                </td>
                
html;
            if ($value['status'] == 1) {
                $tabla.=<<<html
                <td class="text-center"><span class="badge badge-success">En Tiempo</span><td>
                <td>
                    <button class="btn btn-danger " onclick="borrarRegister({$value['id_registro_asistencia']})" type="button" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-original-title="Eliminar Registro de {$value['nombre_completo']}">
                        <i class="fas fa-trash"></i>
                    </button>
                </td>
            </tr>
html;
            } else if ($value['status'] == 2){
                $tabla.=<<<html
                <td class="text-center"><span class="badge badge-danger">Fuera del Horario</span><td>
                <td>
                    <button class="btn btn-danger " onclick="borrarRegister({$value['id_registro_asistencia']})" type="button" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-original-title="Eliminar Registro de {$value['nombre_completo']}">
                        <i class="fas fa-trash"></i>
                    </button>
                </td>
            </tr>
html;
            }
        }

        $etiqueta_linea =<<<html
            <span class="badge badge-info" style="background: #8d206b; color: white;">Medicina General</span>    
html;

        foreach($codigo as $key => $value)
        {
            if($value['id_asistencia'] != '')
            {
                $flag = true;
                $nombre = $value['nombre'];
                $descripcion = $value['descripcion'];
                $fecha_asistencia = $value['fecha_asistencia'];
                $hora_asistencia_inicio = $value['hora_asistencia_inicio'];
                $hora_asistencia_fin = $value['hora_asistencia_fin'];
            }
        }


        ///--------------------FALTANTES--------------------///
        $lista_faltantes = RegistroCheckInDao::getRegistrosAsistenciasFaltantes($id,10);
        $tabla_faltantes='';
        foreach ($lista_faltantes as $key => $value) {
            $tabla_faltantes.=<<<html
            <tr>
                <td><b>{$value['nombre_completo']} </b> <span class="badge badge-info" style="color: white; background: {$value['color_linea']};"> {$value['nombre_linea_ejecutivo']} </span></td>
                <td>
                    <u><a href="mailto:{$value['email']}"><span class="fa fa-mail-bulk"> </span> {$value['email']}</a></u>
                    <br><br>
                    <u><a href="https://api.whatsapp.com/send?phone=52{$value['telefono']}&text=Buen%20d%C3%ADa,%20te%20contacto%20de%20parte%20del%20Equipo%20Grupo%20LAHE%20%F0%9F%98%80" target="_blank"><span class="fa fa-whatsapp" style="color:green;"> </span> {$value['telefono']}</a></u>
                </td>
                <td>
                    <b>Línea: </b>{$value['nombre_linea']}
                    <br>
                    <b>BU: </b>{$value['nombre_bu']}
                    <br>
                    <b>Posición: </b>{$value['nombre_posicion']} 
                </td>
                <td>
                    <button class="btn btn-danger " onclick="borrarRegister({$value['id_registro_asistencia']})" type="button" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-original-title="Eliminar Registro de {$value['nombre_completo']}">
                        <i class="fas fa-trash"></i>
                    </button>
                </td>
            </tr>
html;
        }
        ///-------------------------------------------------///


        if($flag == true)
        {
            View::set('tabla',$tabla);
            View::set('tabla_faltantes',$tabla_faltantes);
            View::set('nombre',$nombre);
            View::set('etiqueta_linea',$etiqueta_linea);
            View::set('descripcion',$descripcion);
            View::set('nombre_asistencia',$nombre_asistencia);
            View::set('fecha_asistencia',$fecha_asistencia);
            View::set('hora_asistencia_inicio',$hora_asistencia_inicio);
            View::set('hora_asistencia_fin',$hora_asistencia_fin);
            View::set('header',$extraHeader);
            View::set('footer',$extraFooter);
            View::render("registro_asistencias_checkin");
        }
        else
        {
            // View::render("asistencias_panel_registro");
            View::render("asistencias_all_vacia");
        }
    }

    //----------NEUROCIENCIAS----------//
    public function ole($id) {
        $extraHeader =<<<html
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link rel="apple-touch-icon" sizes="76x76" href="/assets/img/favicon.png">
        <link rel="icon" type="image/png" href="/assets/img/favicon.png">
        <title>
            Ole - Asistencia CONAVE Convención 2022 ASOFARMA
        </title>
        <!--     Fonts and icons     -->
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
        <!-- Nucleo Icons -->
        <link href="/assets/css/nucleo-icons.css" rel="stylesheet" />
        <link href="/assets/css/nucleo-svg.css" rel="stylesheet" />
        <!-- Font Awesome Icons -->
        <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
        <link href="/assets/css/nucleo-svg.css" rel="stylesheet" />
        <!-- CSS Files -->
        <link id="pagestyle" href="/assets/css/soft-ui-dashboard.css?v=1.0.5" rel="stylesheet" />
        <link rel="stylesheet" href="/css/alertify/alertify.core.css" />
        <link rel="stylesheet" href="/css/alertify/alertify.default.css" id="toggleCSS" />
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
        <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

html;
        $extraFooter =<<<html
        <script src="/js/jquery.min.js"></script>
        <script src="/js/validate/jquery.validate.js"></script>
        <script src="/js/alertify/alertify.min.js"></script>
        <!-- -------- END FOOTER 3 w/ COMPANY DESCRIPTION WITH LINKS & SOCIAL ICONS & COPYRIGHT ------- -->
        <!--   Core JS Files   -->
        <script src="/assets/js/core/popper.min.js"></script>
        <script src="/assets/js/core/bootstrap.min.js"></script>
        <script src="/assets/js/plugins/perfect-scrollbar.min.js"></script>
        <script src="/assets/js/plugins/smooth-scrollbar.min.js"></script>
        <!-- Kanban scripts -->
        <script src="/assets/js/plugins/dragula/dragula.min.js"></script>
        <script src="/assets/js/plugins/jkanban/jkanban.js"></script>
        <script>
            var win = navigator.platform.indexOf('Win') > -1;
            if (win && document.querySelector('#sidenav-scrollbar')) {
                var options = {
                    damping: '0.5'
                }
                Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
            }
        </script>
        <!-- Github buttons -->
        <script async defer src="https://buttons.github.io/buttons.js"></script>
        <!-- Control Center for Soft Dashboard: parallax effects, scripts for the example pages etc -->
        <script src="/assets/js/soft-ui-dashboard.min.js?v=1.0.5"></script>
        <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

        <script src="http://cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js" defer></script>
        <link rel="stylesheet" href="http://cdn.datatables.net/1.11.4/css/jquery.dataTables.min.css" />
        
        <script src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js" defer></script>
        <link rel="stylesheet" href="https://cdn.datatables.net/1.11.4/css/jquery.dataTables.min.css" />

        <script src="//cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js" defer></script>
        <link rel="stylesheet" href="//cdn.datatables.net/1.11.4/css/jquery.dataTables.min.css" />

html;

        $codigo = RegistroCheckInDao::getById($id);

        $lista_registrados = RegistroCheckInDao::getRegistrosAsistenciasByCodeAndLinea($id,11);

        $nombre_asistencia = RegistroCheckInDao::getRegistrosAsistenciasByCode($id)[0]['nombre_asistencia'];

        $tabla='';
        foreach ($lista_registrados as $key => $value) {
            $tabla.=<<<html
            <tr>
                <td><b>{$value['nombre_completo']} </b> <span class="badge badge-info" style="color: white; background: {$value['color_linea']};"> {$value['nombre_linea_ejecutivo']} </span></td>
                <td>
                    <u><a href="mailto:{$value['email']}"><span class="fa fa-mail-bulk"> </span> {$value['email']}</a></u>
                    <br><br>
                    <u><a href="https://api.whatsapp.com/send?phone=52{$value['telefono']}&text=Buen%20d%C3%ADa,%20te%20contacto%20de%20parte%20del%20Equipo%20Grupo%20LAHE%20%F0%9F%98%80" target="_blank"><span class="fa fa-whatsapp" style="color:green;"> </span> {$value['telefono']}</a></u>
                </td>
                <td>
                    <b>Línea: </b>{$value['nombre_linea']}
                    <br>
                    <b>BU: </b>{$value['nombre_bu']}
                    <br>
                    <b>Posición: </b>{$value['nombre_posicion']} 
                </td>
                
html;
            if ($value['status'] == 1) {
                $tabla.=<<<html
                <td class="text-center"><span class="badge badge-success">En Tiempo</span><td>
                <td>
                    <button class="btn btn-danger " onclick="borrarRegister({$value['id_registro_asistencia']})" type="button" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-original-title="Eliminar Registro de {$value['nombre_completo']}">
                        <i class="fas fa-trash"></i>
                    </button>
                </td>
            </tr>
html;
            } else if ($value['status'] == 2){
                $tabla.=<<<html
                <td class="text-center"><span class="badge badge-danger">Fuera del Horario</span><td>
                <td>
                    <button class="btn btn-danger " onclick="borrarRegister({$value['id_registro_asistencia']})" type="button" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-original-title="Eliminar Registro de {$value['nombre_completo']}">
                        <i class="fas fa-trash"></i>
                    </button>
                </td>
            </tr>
html;
            }
        }

        $etiqueta_linea =<<<html
            <span class="badge badge-info" style="background: #2d60ad; color: white;">Ole</span>    
html;

        foreach($codigo as $key => $value)
        {
            if($value['id_asistencia'] != '')
            {
                $flag = true;
                $nombre = $value['nombre'];
                $descripcion = $value['descripcion'];
                $fecha_asistencia = $value['fecha_asistencia'];
                $hora_asistencia_inicio = $value['hora_asistencia_inicio'];
                $hora_asistencia_fin = $value['hora_asistencia_fin'];
            }
        }


        ///--------------------FALTANTES--------------------///
        $lista_faltantes = RegistroCheckInDao::getRegistrosAsistenciasFaltantes($id,11);
        $tabla_faltantes='';
        foreach ($lista_faltantes as $key => $value) {
            $tabla_faltantes.=<<<html
            <tr>
                <td><b>{$value['nombre_completo']} </b> <span class="badge badge-info" style="color: white; background: {$value['color_linea']};"> {$value['nombre_linea_ejecutivo']} </span></td>
                <td>
                    <u><a href="mailto:{$value['email']}"><span class="fa fa-mail-bulk"> </span> {$value['email']}</a></u>
                    <br><br>
                    <u><a href="https://api.whatsapp.com/send?phone=52{$value['telefono']}&text=Buen%20d%C3%ADa,%20te%20contacto%20de%20parte%20del%20Equipo%20Grupo%20LAHE%20%F0%9F%98%80" target="_blank"><span class="fa fa-whatsapp" style="color:green;"> </span> {$value['telefono']}</a></u>
                </td>
                <td>
                    <b>Línea: </b>{$value['nombre_linea']}
                    <br>
                    <b>BU: </b>{$value['nombre_bu']}
                    <br>
                    <b>Posición: </b>{$value['nombre_posicion']} 
                </td>
                <td>
                    <button class="btn btn-danger " onclick="borrarRegister({$value['id_registro_asistencia']})" type="button" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-original-title="Eliminar Registro de {$value['nombre_completo']}">
                        <i class="fas fa-trash"></i>
                    </button>
                </td>
            </tr>
html;
        }
        ///-------------------------------------------------///


        if($flag == true)
        {
            View::set('tabla',$tabla);
            View::set('tabla_faltantes',$tabla_faltantes);
            View::set('nombre',$nombre);
            View::set('etiqueta_linea',$etiqueta_linea);
            View::set('descripcion',$descripcion);
            View::set('nombre_asistencia',$nombre_asistencia);
            View::set('fecha_asistencia',$fecha_asistencia);
            View::set('hora_asistencia_inicio',$hora_asistencia_inicio);
            View::set('hora_asistencia_fin',$hora_asistencia_fin);
            View::set('header',$extraHeader);
            View::set('footer',$extraFooter);
            View::render("registro_asistencias_checkin");
        }
        else
        {
            // View::render("asistencias_panel_registro");
            View::render("asistencias_all_vacia");
        }
    }

    //---------ANALGESIA-----------//
    public function analgesia($id) {
        $extraHeader =<<<html
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link rel="apple-touch-icon" sizes="76x76" href="/assets/img/favicon.png">
        <link rel="icon" type="image/png" href="/assets/img/favicon.png">
        <title>
            Analgesia - Asistencia CONAVE Convención 2022 ASOFARMA
        </title>
        <!--     Fonts and icons     -->
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
        <!-- Nucleo Icons -->
        <link href="/assets/css/nucleo-icons.css" rel="stylesheet" />
        <link href="/assets/css/nucleo-svg.css" rel="stylesheet" />
        <!-- Font Awesome Icons -->
        <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
        <link href="/assets/css/nucleo-svg.css" rel="stylesheet" />
        <!-- CSS Files -->
        <link id="pagestyle" href="/assets/css/soft-ui-dashboard.css?v=1.0.5" rel="stylesheet" />
        <link rel="stylesheet" href="/css/alertify/alertify.core.css" />
        <link rel="stylesheet" href="/css/alertify/alertify.default.css" id="toggleCSS" />
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
        <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

html;
        $extraFooter =<<<html
        <script src="/js/jquery.min.js"></script>
        <script src="/js/validate/jquery.validate.js"></script>
        <script src="/js/alertify/alertify.min.js"></script>
        <!-- -------- END FOOTER 3 w/ COMPANY DESCRIPTION WITH LINKS & SOCIAL ICONS & COPYRIGHT ------- -->
        <!--   Core JS Files   -->
        <script src="/assets/js/core/popper.min.js"></script>
        <script src="/assets/js/core/bootstrap.min.js"></script>
        <script src="/assets/js/plugins/perfect-scrollbar.min.js"></script>
        <script src="/assets/js/plugins/smooth-scrollbar.min.js"></script>
        <!-- Kanban scripts -->
        <script src="/assets/js/plugins/dragula/dragula.min.js"></script>
        <script src="/assets/js/plugins/jkanban/jkanban.js"></script>
        <script>
            var win = navigator.platform.indexOf('Win') > -1;
            if (win && document.querySelector('#sidenav-scrollbar')) {
                var options = {
                    damping: '0.5'
                }
                Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
            }
        </script>
        <!-- Github buttons -->
        <script async defer src="https://buttons.github.io/buttons.js"></script>
        <!-- Control Center for Soft Dashboard: parallax effects, scripts for the example pages etc -->
        <script src="/assets/js/soft-ui-dashboard.min.js?v=1.0.5"></script>
        <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

        <script src="http://cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js" defer></script>
        <link rel="stylesheet" href="http://cdn.datatables.net/1.11.4/css/jquery.dataTables.min.css" />
        
        <script src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js" defer></script>
        <link rel="stylesheet" href="https://cdn.datatables.net/1.11.4/css/jquery.dataTables.min.css" />

        <script src="//cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js" defer></script>
        <link rel="stylesheet" href="//cdn.datatables.net/1.11.4/css/jquery.dataTables.min.css" />

html;

        $codigo = RegistroCheckInDao::getById($id);

        $lista_registrados = RegistroCheckInDao::getRegistrosAsistenciasByCodeAndLinea($id,12);

        $nombre_asistencia = RegistroCheckInDao::getRegistrosAsistenciasByCode($id)[0]['nombre_asistencia'];

        $tabla='';
        foreach ($lista_registrados as $key => $value) {
            $tabla.=<<<html
            <tr>
                <td><b>{$value['nombre_completo']} </b> <span class="badge badge-info" style="color: white; background: {$value['color_linea']};"> {$value['nombre_linea_ejecutivo']} </span></td>
                <td>
                    <u><a href="mailto:{$value['email']}"><span class="fa fa-mail-bulk"> </span> {$value['email']}</a></u>
                    <br><br>
                    <u><a href="https://api.whatsapp.com/send?phone=52{$value['telefono']}&text=Buen%20d%C3%ADa,%20te%20contacto%20de%20parte%20del%20Equipo%20Grupo%20LAHE%20%F0%9F%98%80" target="_blank"><span class="fa fa-whatsapp" style="color:green;"> </span> {$value['telefono']}</a></u>
                </td>
                <td>
                    <b>Línea: </b>{$value['nombre_linea']}
                    <br>
                    <b>BU: </b>{$value['nombre_bu']}
                    <br>
                    <b>Posición: </b>{$value['nombre_posicion']} 
                </td>
                
html;
            if ($value['status'] == 1) {
                $tabla.=<<<html
                <td class="text-center"><span class="badge badge-success">En Tiempo</span><td>
                <td>
                    <button class="btn btn-danger " onclick="borrarRegister({$value['id_registro_asistencia']})" type="button" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-original-title="Eliminar Registro de {$value['nombre_completo']}">
                        <i class="fas fa-trash"></i>
                    </button>
                </td>
            </tr>
html;
            } else if ($value['status'] == 2){
                $tabla.=<<<html
                <td class="text-center"><span class="badge badge-danger">Fuera del Horario</span><td>
                <td>
                    <button class="btn btn-danger " onclick="borrarRegister({$value['id_registro_asistencia']})" type="button" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-original-title="Eliminar Registro de {$value['nombre_completo']}">
                        <i class="fas fa-trash"></i>
                    </button>
                </td>
            </tr>
html;
            }
        }

        $etiqueta_linea =<<<html
            <span class="badge badge-info" style="background: #165f6f; color: white;">Analgesia</span>    
html;

        foreach($codigo as $key => $value)
        {
            if($value['id_asistencia'] != '')
            {
                $flag = true;
                $nombre = $value['nombre'];
                $descripcion = $value['descripcion'];
                $fecha_asistencia = $value['fecha_asistencia'];
                $hora_asistencia_inicio = $value['hora_asistencia_inicio'];
                $hora_asistencia_fin = $value['hora_asistencia_fin'];
            }
        }


        ///--------------------FALTANTES--------------------///
        $lista_faltantes = RegistroCheckInDao::getRegistrosAsistenciasFaltantes($id,12);
        $tabla_faltantes='';
        foreach ($lista_faltantes as $key => $value) {
            $tabla_faltantes.=<<<html
            <tr>
                <td><b>{$value['nombre_completo']} </b> <span class="badge badge-info" style="color: white; background: {$value['color_linea']};"> {$value['nombre_linea_ejecutivo']} </span></td>
                <td>
                    <u><a href="mailto:{$value['email']}"><span class="fa fa-mail-bulk"> </span> {$value['email']}</a></u>
                    <br><br>
                    <u><a href="https://api.whatsapp.com/send?phone=52{$value['telefono']}&text=Buen%20d%C3%ADa,%20te%20contacto%20de%20parte%20del%20Equipo%20Grupo%20LAHE%20%F0%9F%98%80" target="_blank"><span class="fa fa-whatsapp" style="color:green;"> </span> {$value['telefono']}</a></u>
                </td>
                <td>
                    <b>Línea: </b>{$value['nombre_linea']}
                    <br>
                    <b>BU: </b>{$value['nombre_bu']}
                    <br>
                    <b>Posición: </b>{$value['nombre_posicion']} 
                </td>
                <td>
                    <button class="btn btn-danger " onclick="borrarRegister({$value['id_registro_asistencia']})" type="button" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-original-title="Eliminar Registro de {$value['nombre_completo']}">
                        <i class="fas fa-trash"></i>
                    </button>
                </td>
            </tr>
html;
        }
        ///-------------------------------------------------///


        if($flag == true)
        {
            View::set('tabla',$tabla);
            View::set('tabla_faltantes',$tabla_faltantes);
            View::set('nombre',$nombre);
            View::set('etiqueta_linea',$etiqueta_linea);
            View::set('descripcion',$descripcion);
            View::set('nombre_asistencia',$nombre_asistencia);
            View::set('fecha_asistencia',$fecha_asistencia);
            View::set('hora_asistencia_inicio',$hora_asistencia_inicio);
            View::set('hora_asistencia_fin',$hora_asistencia_fin);
            View::set('header',$extraHeader);
            View::set('footer',$extraFooter);
            View::render("registro_asistencias_checkin");
        }
        else
        {
            // View::render("asistencias_panel_registro");
            View::render("asistencias_all_vacia");
        }
    }


    //----------KAES OSTEO----------//
    public function kaesOsteo($id) {
        $extraHeader =<<<html
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link rel="apple-touch-icon" sizes="76x76" href="/assets/img/favicon.png">
        <link rel="icon" type="image/png" href="/assets/img/favicon.png">
        <title>
            KAES / OSTEO - Asistencia CONAVE Convención 2022 ASOFARMA
        </title>
        <!--     Fonts and icons     -->
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
        <!-- Nucleo Icons -->
        <link href="/assets/css/nucleo-icons.css" rel="stylesheet" />
        <link href="/assets/css/nucleo-svg.css" rel="stylesheet" />
        <!-- Font Awesome Icons -->
        <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
        <link href="/assets/css/nucleo-svg.css" rel="stylesheet" />
        <!-- CSS Files -->
        <link id="pagestyle" href="/assets/css/soft-ui-dashboard.css?v=1.0.5" rel="stylesheet" />
        <link rel="stylesheet" href="/css/alertify/alertify.core.css" />
        <link rel="stylesheet" href="/css/alertify/alertify.default.css" id="toggleCSS" />
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
        <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

html;
        $extraFooter =<<<html
        <script src="/js/jquery.min.js"></script>
        <script src="/js/validate/jquery.validate.js"></script>
        <script src="/js/alertify/alertify.min.js"></script>
        <!-- -------- END FOOTER 3 w/ COMPANY DESCRIPTION WITH LINKS & SOCIAL ICONS & COPYRIGHT ------- -->
        <!--   Core JS Files   -->
        <script src="/assets/js/core/popper.min.js"></script>
        <script src="/assets/js/core/bootstrap.min.js"></script>
        <script src="/assets/js/plugins/perfect-scrollbar.min.js"></script>
        <script src="/assets/js/plugins/smooth-scrollbar.min.js"></script>
        <!-- Kanban scripts -->
        <script src="/assets/js/plugins/dragula/dragula.min.js"></script>
        <script src="/assets/js/plugins/jkanban/jkanban.js"></script>
        <script>
            var win = navigator.platform.indexOf('Win') > -1;
            if (win && document.querySelector('#sidenav-scrollbar')) {
                var options = {
                    damping: '0.5'
                }
                Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
            }
        </script>
        <!-- Github buttons -->
        <script async defer src="https://buttons.github.io/buttons.js"></script>
        <!-- Control Center for Soft Dashboard: parallax effects, scripts for the example pages etc -->
        <script src="/assets/js/soft-ui-dashboard.min.js?v=1.0.5"></script>
        <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

        <script src="http://cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js" defer></script>
        <link rel="stylesheet" href="http://cdn.datatables.net/1.11.4/css/jquery.dataTables.min.css" />
        
        <script src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js" defer></script>
        <link rel="stylesheet" href="https://cdn.datatables.net/1.11.4/css/jquery.dataTables.min.css" />

        <script src="//cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js" defer></script>
        <link rel="stylesheet" href="//cdn.datatables.net/1.11.4/css/jquery.dataTables.min.css" />

html;

        $optionsCategoriaHotel = '';

        $CategoriasHabitacion = HabitacionesDao::getAllCategoriasHabitaciones();
        foreach ($CategoriasHabitacion as $key => $value) {
            $optionsCategoriaHotel .= <<<html
            <option value="{$value['id_categoria_habitacion']}">{$value['nombre_categoria']}</option>
html;
        }

        $codigo = RegistroCheckInDao::getById($id);

        $lista_registrados = RegistroCheckInDao::getRegistrosAsistenciasByCodeAndLinea($id,4);

        $nombre_asistencia = RegistroCheckInDao::getRegistrosAsistenciasByCode($id)[0]['nombre_asistencia'];

        $tabla='';
        foreach ($lista_registrados as $key => $value) {
            $tabla.=<<<html
            <tr>
                <td><b>{$value['nombre_completo']} </b> <span class="badge badge-info" style="color: white; background: {$value['color_linea']};"> {$value['nombre_linea_ejecutivo']} </span></td>
                <td>
                    <u><a href="mailto:{$value['email']}"><span class="fa fa-mail-bulk"> </span> {$value['email']}</a></u>
                    <br><br>
                    <u><a href="https://api.whatsapp.com/send?phone=52{$value['telefono']}&text=Buen%20d%C3%ADa,%20te%20contacto%20de%20parte%20del%20Equipo%20Grupo%20LAHE%20%F0%9F%98%80" target="_blank"><span class="fa fa-whatsapp" style="color:green;"> </span> {$value['telefono']}</a></u>
                </td>
                <td>
                    <b>Línea: </b>{$value['nombre_linea']}
                    <br>
                    <b>BU: </b>{$value['nombre_bu']}
                    <br>
                    <b>Posición: </b>{$value['nombre_posicion']} 
                </td>
                
html;
            if ($value['status'] == 1) {
                $tabla.=<<<html
                <td class="text-center"><span class="badge badge-success">En Tiempo</span><td>
                <td>
                    <button class="btn btn-danger " onclick="borrarRegister({$value['id_registro_asistencia']})" type="button" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-original-title="Eliminar Registro de {$value['nombre_completo']}">
                        <i class="fas fa-trash"></i>
                    </button>
                </td>
            </tr>
html;
            } else if ($value['status'] == 2){
                $tabla.=<<<html
                <td class="text-center"><span class="badge badge-danger">Fuera del Horario</span><td>
                <td>
                    <button class="btn btn-danger " onclick="borrarRegister({$value['id_registro_asistencia']})" type="button" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-original-title="Eliminar Registro de {$value['nombre_completo']}">
                        <i class="fas fa-trash"></i>
                    </button>
                </td>
            </tr>
html;
            }
        }

        $etiqueta_linea =<<<html
            <span class="badge badge-info" style="background: #b2b4d9; color: white;">KAES / OSTEO</span>    
html;

        foreach($codigo as $key => $value)
        {
            if($value['id_asistencia'] != '')
            {
                $flag = true;
                $nombre = $value['nombre'];
                $descripcion = $value['descripcion'];
                $fecha_asistencia = $value['fecha_asistencia'];
                $hora_asistencia_inicio = $value['hora_asistencia_inicio'];
                $hora_asistencia_fin = $value['hora_asistencia_fin'];
            }
        }


        ///--------------------FALTANTES--------------------///
        $lista_faltantes = RegistroCheckInDao::getRegistrosAsistenciasFaltantes($id,4);
        $tabla_faltantes='';
        foreach ($lista_faltantes as $key => $value) {
            $tabla_faltantes.=<<<html
            <tr>
                <td><b>{$value['nombre_completo']} </b> <span class="badge badge-info" style="color: white; background: {$value['color_linea']};"> {$value['nombre_linea_ejecutivo']} </span></td>
                <td>
                    <u><a href="mailto:{$value['email']}"><span class="fa fa-mail-bulk"> </span> {$value['email']}</a></u>
                    <br><br>
                    <u><a href="https://api.whatsapp.com/send?phone=52{$value['telefono']}&text=Buen%20d%C3%ADa,%20te%20contacto%20de%20parte%20del%20Equipo%20Grupo%20LAHE%20%F0%9F%98%80" target="_blank"><span class="fa fa-whatsapp" style="color:green;"> </span> {$value['telefono']}</a></u>
                </td>
                <td>
                    <b>Línea: </b>{$value['nombre_linea']}
                    <br>
                    <b>BU: </b>{$value['nombre_bu']}
                    <br>
                    <b>Posición: </b>{$value['nombre_posicion']} 
                </td>
                <td>
                    <button class="btn btn-danger " onclick="borrarRegister({$value['id_registro_asistencia']})" type="button" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-original-title="Eliminar Registro de {$value['nombre_completo']}">
                        <i class="fas fa-trash"></i>
                    </button>
                </td>
            </tr>
html;
        }
        ///-------------------------------------------------///


        if($flag == true)
        {
            View::set('tabla',$tabla);
            View::set('tabla_faltantes',$tabla_faltantes);
            View::set('nombre',$nombre);
            View::set('etiqueta_linea',$etiqueta_linea);
            View::set('descripcion',$descripcion);
            View::set('nombre_asistencia',$nombre_asistencia);
            View::set('fecha_asistencia',$fecha_asistencia);
            View::set('hora_asistencia_inicio',$hora_asistencia_inicio);
            View::set('hora_asistencia_fin',$hora_asistencia_fin);
            View::set('header',$extraHeader);
            View::set('footer',$extraFooter);
            View::render("registro_asistencias_checkin");
        }
        else
        {
            // View::render("asistencias_panel_registro");
            View::render("asistencias_all_vacia");
        }
    }



    public function mostrarLista($clave){
        $lista_registrados = RegistroCheckInDao::getRegistrosAsistenciasByCode($clave);

        echo json_encode($lista_registrados);
    }

    public function borrarRegistrado($id_user){

        $id_asistencia = '';
        $delete_registrado = RegistroCheckInDao::delete($id_user);

        echo json_encode($delete_registrado);
    }

    public function registroChekIn(){

        // $clave = $_POST['codigo'];
        // $code =  $_POST['clave_a'];

        $clave = $_POST['clave_a'];
        $code =  $_POST['codigo'];
        $linea = $_POST['numero_linea'];

        // if ($linea != 0 ) {
        //     $es_general = 'No es';
        //     $user_clave = RegistroCheckInDao::getInfoByLinea($clave,$linea)[0];
        // } else {
            $es_general = 'Si es';
            $user_clave = RegistroCheckInDao::getInfo($code)[0];
        // }

        // echo "clave ".$clave;
        // echo $user_clave['clave'];
        // var_dump($user_clave);
        // var_dump($user_clave['id_registro_acceso']);
        // exit;

        $clave_habitacion = '';
        $id_asigna_habitacion = '';

        // $user_clave = RegistroCheckInDao::getInfoByLinea($clave,$linea)[0];
        $existe_user = RegistroCheckInDao::getInfo($code);
        $linea_principal = RegistroCheckInDao::getLineaPrincipial();
        $bu = RegistroCheckInDao::getBu();
        $posiciones = RegistroCheckInDao::getPosiciones();
        $asistencia = RegistroCheckInDao::getIdRegistrosAsistenciasByCode($clave)[0];

        $habitaciones = HabitacionesDao::getAsignaHabitacionByIdRegAcceso($user_clave['id_registro_acceso'])[0];

        if ($habitaciones) {
            $clave_habitacion = $habitaciones['clave'];
            $id_asigna_habitacion = $habitaciones['id_asigna_habitacion'];
            $numero_habitacion = $habitaciones['id_habitacion'];
        }

        $fecha = new DateTime('now', new DateTimeZone('America/Cancun'));
        $hora_actual = substr($fecha->format(DATE_RFC822),15,5);
        // $a_tiempo = '';

        if ( intval(substr($hora_actual,0,2)) > intval(substr($asistencia['hora_asistencia_inicio'],0,2))
            && intval(substr($hora_actual,0,2)) < intval(substr($asistencia['hora_asistencia_fin'],0,2)) ) {
            $a_tiempo = 1;
            $aqui = 1;
        } else if(intval(substr($hora_actual,0,2)) == intval(substr($asistencia['hora_asistencia_fin'],0,2))
            && intval(substr($hora_actual,3,6)) <= intval(substr($asistencia['hora_asistencia_fin'],3,6))) {
            $a_tiempo = 1;
            $aqui = 2;
        } else if(intval(substr($hora_actual,0,2)) == intval(substr($asistencia['hora_asistencia_inicio'],0,2))
            && intval(substr($hora_actual,3,6)) >= intval(substr($asistencia['hora_asistencia_inicio'],3,6))) {
            $a_tiempo = 1;
            $aqui = 3;
        } else {
            $a_tiempo = 2;
            $aqui = 4;
        }
        // || substr($hora_actual,0,2) > substr($asistencia['hora_asistencia_fin'],0,2)

        // echo ($user_clave);

        if ($existe_user) {
            if($user_clave){
                $hay_asistente = RegistroCheckInDao::findAsistantById($user_clave['utilerias_asistentes_id'],$asistencia['id_asistencia'])[0];
                if ($hay_asistente) {
                    $msg_insert = 'success_find_assistant';
                } else {
                    $msg_insert = 'fail_not_found_assistant';
                    $insert = RegistroCheckInDao::addRegister($asistencia['id_asistencia'],$user_clave['utilerias_asistentes_id'],$a_tiempo);
                }

                if ($user_clave['nombre_linea_ejecutivo']) {
                    $linea_ejecutivo = $user_clave['nombre_linea_ejecutivo'];
                } else {
                    $linea_ejecutivo = 'no';
                }

                $data = [
                    'datos'=>$user_clave,
                    'linea_principal'=>$linea_principal,
                    'bu'=>$bu,
                    'posiciones'=>$posiciones,
                    'status'=>'success',
                    'msg_insert'=>$msg_insert,
                    'hay_asistente'=> $hay_asistente,
                    'asistencia'=> $asistencia,
                    'hora_actual'=>$hora_actual,
                    'a_tiempo'=>$a_tiempo,
                    'aqui'=>$aqui,
                    'linea'=>$linea,
                    'es_general'=>$es_general,
                    'linea_ejecutivo'=>$linea_ejecutivo,
                    'hora_actual'=>intval(substr($hora_actual,0,2)),
                    'hora_fin'=>intval(substr($asistencia['hora_asistencia_fin'],0,2)),
                    'clave_habitacion' => $clave_habitacion,
                    'id_asigna_habitacion' => $id_asigna_habitacion,
                    'numero_habitacion' => $numero_habitacion,
                    'id_registros_Acceso'=>$user_clave['id_registro_acceso'],
                    'anchor_abrir_pdf' => "<a href='/RegistroAsistencia/abrirpdf/{$user_clave['clave']}' target='_blank' style='display:none;' id='a_abrir_etiqueta'>abrir</a>",
                    'anchor_abrir_gafete' => "<a href='/RegistroAsistencia/abrirpdfGafete/{$user_clave['clave']}/{$user_clave['clave_ticket']}' target='_blank' style='display:none;' id='a_abrir_gafete' class='btn btn-info'><i class='fa fal fa-address-card' style='font-size: 18px;'></i>Presione esté botón para descargar el gafete</a>",

                ];
            }else{
                $data = [
                    'datos'=>$user_clave,
                    'linea'=>$linea,
                    'status'=>'fail'
                ];
            }
        } else {
            $data = [
                'datos'=>$user_clave,
                'linea'=>$linea,
                'status'=>'fail_user'
            ];
        }



        echo json_encode($data);
    }

    public function abrirpdfGafete($clave, $clave_ticket = null)
    {

        $this->generaterQr($clave_ticket);
        $datos_user = AsistentesDao::getRegistroAccesoHabitacionByClaveRA($clave)[0];
        $nombre_completo = $datos_user['nombre'] . " " . $datos_user['segundo_nombre'] . " " . $datos_user['apellido_materno'] . " " . $datos_user['apellido_paterno'];

        $pdf = new \FPDF($orientation = 'P', $unit = 'mm', array(390, 152));
        $pdf->AddPage();
        $pdf->SetFont('Arial', 'B', 8);    //Letra Arial, negrita (Bold), tam. 20
        $pdf->setY(1);
        $pdf->SetFont('Arial', 'B', 16);
        $pdf->Image('qrs/gafetes/'.$clave_ticket.'.png', 27, 40, 100, 100);

        //$pdf->Image('1.png', 1, 0, 190, 190);
        $pdf->SetFont('Arial', '', 5);    //Letra Arial, negrita (Bold), tam. 20
        //$nombre = utf8_decode("Jonathan Valdez Martinez");
        //$num_linea =utf8_decode("Línea: 39");
        //$num_linea2 =utf8_decode("Línea: 39");

        $pdf->SetXY(18.3, 300);
        $pdf->SetFont('Times', 'B', 35);
        #4D9A9B
        $pdf->SetTextColor(0, 0, 0);
        $pdf->Multicell(120, 10, $nombre_completo, 0, 'C');
        $pdf->output();
    }
  
}
