<?php
namespace App\controllers;
defined("APPPATH") OR die("Access denied");

use \App\models\General AS GeneralDao;
use \Core\Controller;

require_once dirname(__DIR__).'/../public/librerias/mpdf/mpdf.php';
require_once dirname(__DIR__).'/../public/librerias/phpexcel/Classes/PHPExcel.php';
class Contenedor_2 extends Controller{


    function __construct(){
      parent::__construct();
    }

    public function getUsuario(){
      return $this->__usuario;
    }

    public function asideMenu(){

      // $permisos = (Controller::getPermisoUser($this->__usuario)['perfil_id']) != 1 ? "style=\"display:none;\"" : "";

      $menu = <<<html
      <aside class="bg-white-aside sidenav navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-3 " id="sidenav-main">
        <div class="sidenav-header" style="margin-bottom: 30px;">
            <i class="fas fa-times p-3 cursor-pointer text-secondary opacity-5 position-absolute end-0 top-0 d-none d-xl-none" aria-hidden="true" id="iconSidenav"></i>

            <a class="navbar-brand m-0" href="/Principal/" target="_blank">
                <img src="/assets/img/favicon.png" class="navbar-brand-img h-100" alt="main_logo">
                <span class="ms-1 font-weight-bold"></span>
                <p style="margin-top: 15px;"><span class="fa fa-user morado-musa-text"></span> {$_SESSION['nombre']}</p>
            </a>


        </div>
        <hr class="horizontal dark mt-0">


        <div class="collapse navbar-collapse  w-auto h-auto h-100" id="sidenav-collapse-main">
            <ul class="navbar-nav">
                <!--li class="nav-item">
                    <a href="/Principal/" class="nav-link active" role="button" aria-expanded="false">
                        <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center d-flex align-items-center justify-content-center  me-2">
                            <span class="fa fa-home text-white" ></span>
                        </div>
                        <span class="nav-link-text ms-1">Principal</span>
                    </a>
                </li-->

                <li id="principal" class="nav-item" >
                    <a href="/Principal/" class="nav-link " aria-controls="applicationsExamples" role="button" aria-expanded="false">
                        <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center d-flex align-items-center justify-content-center  me-2">
                            <span class="fa fa-home morado-musa-text"></span>
                        </div>
                        <span class="nav-link-text ms-1">Principal</span>
                    </a>
                </li>

                <li id="usuarios" class="nav-item">
                    <a href="/Usuarios/" class="nav-link " aria-controls="applicationsExamples" role="button" aria-expanded="false">
                        <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center d-flex align-items-center justify-content-center  me-2">
                            <span class="fa fa-users morado-musa-text"></span>
                        </div>
                        <span class="nav-link-text ms-1">Usuarios</span>
                    </a>
                </li>

                <li id="cursos" class="nav-item">
                    <a href="/Cursos/" class="nav-link " aria-controls="applicationsExamples" role="button" aria-expanded="false">
                        <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center d-flex align-items-center justify-content-center  me-2">
                            <span class="fas fa-play morado-musa-text"></span>
                        </div>
                        <span class="nav-link-text ms-1">Cursos</span>
                    </a>
                </li>

                <li id="transmision" class="nav-item">
                    <a href="/Transmision/" class="nav-link " aria-controls="applicationsExamples" role="button" aria-expanded="false">
                        <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center d-flex align-items-center justify-content-center  me-2">
                            <span class="fas fa-play morado-musa-text"></span>
                        </div>
                        <span class="nav-link-text ms-1">Transmision</span>
                    </a>
                </li>

                <li id="profesores" class="nav-item">
                    <a href="/Profesores/" class="nav-link " aria-controls="applicationsExamples" role="button" aria-expanded="false">
                        <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center d-flex align-items-center justify-content-center  me-2">
                            <span class="fa fa-users morado-musa-text"></span>
                        </div>
                        <span class="nav-link-text ms-1">Profesores</span>
                    </a>
                </li>

                <li id="encuestas" class="nav-item">
                    <a href="/Encuestas/" class="nav-link " aria-controls="applicationsExamples" role="button" aria-expanded="false">
                        <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center d-flex align-items-center justify-content-center  me-2">
                            <span class="fa fa-users morado-musa-text"></span>
                        </div>
                        <span class="nav-link-text ms-1">Encuestas</span>
                    </a>
                </li>

                <li id="programa" class="nav-item">
                    <a href="/Programa/" class="nav-link " aria-controls="applicationsExamples" role="button" aria-expanded="false">
                        <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center d-flex align-items-center justify-content-center  me-2">
                            <span class="fa fa-users morado-musa-text"></span>
                        </div>
                        <span class="nav-link-text ms-1">Programa</span>
                    </a>
                </li>
                
                

                <li id="asistentes" class="nav-item" >
                    <a href="/Asistentes/" class="nav-link " aria-controls="applicationsExamples" role="button" aria-expanded="false">
                        <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center d-flex align-items-center justify-content-center  me-2">
                            <span class="fa fa-users morado-musa-text"></span>
                        </div>
                        <span class="nav-link-text ms-1">Asistentes</span>
                    </a>
                </li>
                <li id="vuelos" class="nav-item" >
                    <a href="/Vuelos/" class="nav-link " aria-controls="applicationsExamples" role="button" aria-expanded="false">
                        <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center d-flex align-items-center justify-content-center  me-2">
                            <span class="fa fa-plane morado-musa-text"></span>
                        </div>
                        <span class="nav-link-text ms-1">Vuelos</span>
                    </a>
                </li>
                <!--<li id="pickup" class="nav-item" >
                    <a href="/PickUp/" class="nav-link " aria-controls="ecommerceExamples" role="button" aria-expanded="false">
                        <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center d-flex align-items-center justify-content-center  me-2">
                            <span class="fa fa-bus morado-musa-text"></span>
                        </div>
                        <span class="nav-link-text ms-1">PickUp</span>
                    </a>
                </li>-->
               <!-- <li id="habitaciones" class="nav-item" >
                    <a href="/Habitaciones/" class="nav-link " aria-controls="authExamples" role="button" aria-expanded="false">
                        <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center d-flex align-items-center justify-content-center  me-2">
                            <span class="fa fa-hotel morado-musa-text"></span>
                        </div>
                        <span class="nav-link-text ms-1">Habitaciones</span>
                    </a>
                </li>-->
                
                <li id="asistencias" class="nav-item" >
                    <a href="/Asistencias/" class="nav-link " aria-controls="basicExamples" role="button" aria-expanded="false">
                        <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center d-flex align-items-center justify-content-center  me-2">
                            <span class="fa fa-bell morado-musa-text"></span>
                        </div>
                        <span class="nav-link-text ms-1">Asistencias</span>
                    </a>
                </li>
                <li id="salud" class="nav-item" >
                    <hr class="horizontal dark" />
                    <h6 class="ps-4  ms-2 text-uppercase text-xs font-weight-bolder opacity-6">PAGOS EN SITIO</h6>
                </li>
                <li id="pagos" class="nav-item" >
                    <a href="/CobroEnSitio/" class="nav-link " aria-controls="basicExamples" role="button" aria-expanded="false">
                        <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center d-flex align-items-center justify-content-center  me-2">
                            <span class="fa fa-money morado-musa-text"></span>
                        </div>
                        <span class="nav-link-text ms-1">Cobrar en Sitio</span>
                    </a>
                </li>
                <li id="pruebas_usuario" class="nav-item" >
                    <a href="/PruebasCovidUsuarios/" class="nav-link " aria-controls="basicExamples" role="button" aria-expanded="false">
                        <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center d-flex align-items-center justify-content-center  me-2">
                            <span class="fa fa-virus-slash morado-musa-text"></span>
                        </div>
                        <span class="nav-link-text ms-1">Pruebas Covid Usuarios</span>
                    </a>
                </li>

                <!-- <li id="pruebas_sitio" class="nav-item" >
                    <a href="/PruebasCovidEnSitio/" class="nav-link" aria-controls="basicExamples" role="button" aria-expanded="false">
                        <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center d-flex align-items-center justify-content-center  me-2">
                            <span class="fa fa-virus morado-musa-text" ></span>
                        </div>
                        <span class="nav-link-text ms-1">Pruebas Covid En Sitio</span>
                    </a>
                </li>-->

                <li id="config" class="nav-item" >
                    <hr class="horizontal dark" />
                    <h6 class="ps-4  ms-2 text-uppercase text-xs font-weight-bolder opacity-6">OTROS</h6>
                </li>
                <li id="configuracion" class="nav-item" >
                    <a href="/Configuracion/" class="nav-link " aria-controls="applicationsExamples" role="button" aria-expanded="false">
                        <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center d-flex align-items-center justify-content-center  me-2">
                            <span class="fa fa-tools morado-musa-text"></span>
                        </div>
                        <span class="nav-link-text ms-1">Configuración</span>
                    </a>
                </li>
                <li id="util" class="nav-item" >
                    <a data-bs-toggle="collapse" onclick="utilerias()" href="#utilerias" class="nav-link " aria-controls="utilerias" role="button" aria-expanded="false">
                        <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center d-flex align-items-center justify-content-center  me-2">
                            <span class="fa fa-user-circle-o morado-musa-text"></span>
                        </div>
                        <span class="nav-link-text ms-1">Utilerias</span>
                    </a>
                    <div class="collapse " id="utilerias" hidden>
                        <ul class="nav ms-4 ps-3">
                            <li id="administradores" class="nav-item ">
                                <a class="nav-link " href="/Administradores/">
                                    <span class="sidenav-mini-icon"> A </span>
                                    <span class="sidenav-normal">Administradores</span>
                                </a>
                            </li>
                            <li id="perfiles" class="nav-item ">
                                <a class="nav-link " href="/Perfiles/">
                                    <span class="sidenav-mini-icon"> P </span>
                                    <span class="sidenav-normal"> Perfiles </span>
                                </a>
                            </li>
                            <li id="log" class="nav-item ">
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
html; 

      return $menu;
    }

    public function header($extra = ''){
     $usuario = $this->__usuario;
     
        // $principal = Controller::getPermisosUsuario($usuario, "seccion_principal", 1);
        // $principalAdd = Controller::getPermisosUsuario($usuario, "seccion_principal", 1);
        // $asistentes = Controller::getPermisosUsuario($usuario, "seccion_asistentes", 1);
        // $asistentessAdd = Controller::getPermisosUsuario($usuario, "seccion_asistentes", 1);
        // $bu = Controller::getPermisosUsuario($usuario, "seccion_bu", 1);
        // $buAdd = Controller::getPermisosUsuario($usuario, "seccion_bu", 1);
        // $lineas = Controller::getPermisosUsuario($usuario, "seccion_lineas", 1);
        // $lineasAdd = Controller::getPermisosUsuario($usuario, "seccion_lineas", 1);
        // $posiciones = Controller::getPermisosUsuario($usuario, "seccion_posiciones", 1);
        // $posicionesAdd = Controller::getPermisosUsuario($usuario, "seccion_posiciones", 1);
        // $restaurantes = Controller::getPermisosUsuario($usuario, "seccion_restaurantes", 1);
        // $restaurantesAdd = Controller::getPermisosUsuario($usuario, "seccion_restaurantes", 1);
        // $gafete = Controller::getPermisosUsuario($usuario, "seccion_gafete", 1);
        // $gafeteAdd = Controller::getPermisosUsuario($usuario, "seccion_gafete", 1);
        // $vuelos = Controller::getPermisosUsuario($usuario, "seccion_vuelos", 1);
        // $vuelosAdd = Controller::getPermisosUsuario($usuario, "seccion_vuelos", 1);
        // $pickup = Controller::getPermisosUsuario($usuario, "seccion_pickup", 1);
        // $pickupAdd = Controller::getPermisosUsuario($usuario, "seccion_pickup", 1);
        // $habitaciones = Controller::getPermisosUsuario($usuario, "seccion_habitaciones", 1);
        // $habitacionesAdd = Controller::getPermisosUsuario($usuario, "seccion_habitaciones", 1);
        // $cenas = Controller::getPermisosUsuario($usuario, "seccion_cenas", 1);
        // $cenasAdd = Controller::getPermisosUsuario($usuario, "seccion_cenas", 1);
        // $vacunacion = Controller::getPermisosUsuario($usuario, "seccion_vacunacion", 1);
        // $vacunacionAdd = Controller::getPermisosUsuario($usuario, "seccion_vacunacion", 1);

        // $pruebas_covid = Controller::getPermisosUsuario($usuario, "seccion_pruebas_covid", 1);
        // $pruebas_covidAdd = Controller::getPermisosUsuario($usuario, "seccion_pruebas_covid", 1);
        // $asistencias = Controller::getPermisosUsuario($usuario, "seccion_asistencias", 1);
        // $asistenciasAdd = Controller::getPermisosUsuario($usuario, "seccion_asistencias", 1);
        // $utilerias = Controller::getPermisosUsuario($usuario, "seccion_utilerias", 1);
        // $utileriasAdd = Controller::getPermisosUsuario($usuario, "seccion_utilerias", 1);
        // $configuracion = Controller::getPermisosUsuario($usuario, "seccion_configuracion", 1);
        // $configuracionAdd = Controller::getPermisosUsuario($usuario, "seccion_configuracion", 1);
      
     $header =<<<html
        <!DOCTYPE html>
        <html lang="es">
        
          <head>
            <meta charset="utf-8">
            <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
            <link rel="apple-touch-icon" sizes="76x76" href="https://foromusa.com/assets/images/Musa0-01.png">
            <link rel="icon" type="image/png" href="https://foromusa.com/assets/images/Musa0-01.png">
            
            <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
            <!-- Nucleo Icons -->
            <link href="../../assets/css/nucleo-icons.css" rel="stylesheet" />
            <link href="../../assets/css/nucleo-svg.css" rel="stylesheet" />
            <!-- Font Awesome Icons -->
            <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
            <link href="../../assets/css/nucleo-svg.css" rel="stylesheet" />
            <!-- CSS Files -->
            <link id="pagestyle" href="../../assets/css/soft-ui-dashboard.css?v=1.0.5" rel="stylesheet" />
            <!-- TEMPLATE VIEJO-->
            <link rel="stylesheet" href="/css/alertify/alertify.core.css" />
            <link rel="stylesheet" href="/css/alertify/alertify.default.css" id="toggleCSS" />

            <meta charset="utf-8" />
            <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
            <link rel="icon" type="image/png" href="../../assets/img/favicon.png">

            <!--     Fonts and icons     -->
            <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
            <!-- Nucleo Icons -->
            <link href="../../assets/css/nucleo-icons.css" rel="stylesheet" />
            <link href="../../assets/css/nucleo-svg.css" rel="stylesheet" />
            <!-- Font Awesome Icons -->
            <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
            <link href="../../assets/css/nucleo-svg.css" rel="stylesheet" />
            <!-- CSS Files -->
            <link id="pagestyle" href="../../assets/css/soft-ui-dashboard.css?v=1.0.5" rel="stylesheet" />

            <link rel="stylesheet" href="/css/alertify/alertify.default.css" id="toggleCSS" />
            <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">

            <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
            <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>

            <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
            <link rel="stylesheet" href="http://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
              
            <script src="http://cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js" defer></script>
            <link rel="stylesheet" href="http://cdn.datatables.net/1.11.4/css/jquery.dataTables.min.css" />
            
            <script src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js" defer></script>
            <link rel="stylesheet" href="https://cdn.datatables.net/1.11.4/css/jquery.dataTables.min.css" />

           <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
           <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
           <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
           <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>

           <script charset="UTF-8" src="//web.webpushs.com/js/push/9d0c1476424f10b1c5e277f542d790b8_1.js" async></script>
           
            <!-- TEMPLATE VIEJO-->

            <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
            <!-- Nucleo Icons -->
            <link href="../../../assets/css/nucleo-icons.css" rel="stylesheet" />
            <link href="../../../assets/css/nucleo-svg.css" rel="stylesheet" />
            <!-- Font Awesome Icons -->
            <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
            <link href="../../../assets/css/nucleo-svg.css" rel="stylesheet" />
            <!-- CSS Files -->
            <link id="pagestyle" href="../../../assets/css/soft-ui-dashboard.css?v=1.0.5" rel="stylesheet" />
            <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
            <link href="//cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
            <style>
            .select2-container--default .select2-selection--single {
            height: 38px!important;
            border-radius: 8px!important;
            
            }
            .select2-container {
              width: 100%!important;
              
          }
           
            </style>
        </head>
html;



    return $header.$extra;
    }

    public function footer($extra = ''){
        $footer =<<<html
        <!-- jQuery -->

          <script>
            function catalogos() {
                var catalogo = document.getElementById("catalogos");

                if (catalogo.hasAttribute('hidden')) {
                    catalogo.removeAttribute('hidden');
                } else {
                    catalogo.setAttribute('hidden','')
                }
            }

            function utilerias() {
                var utileria = document.getElementById("utilerias");

                if (utileria.hasAttribute('hidden')) {
                    utileria.removeAttribute('hidden');
                } else {
                    utileria.setAttribute('hidden','')
                }
            }
        </script>

        <script src="/js/jquery.min.js"></script>
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
        
      <!-- Github buttons -->
        <script async defer src="https://buttons.github.io/buttons.js"></script>
      <!-- Control Center for Soft Dashboard: parallax effects, scripts for the example pages etc -->
        <script src="../../assets/js/soft-ui-dashboard.min.js?v=1.0.5"></script>


        <!-- VIEJO INICIO -->
        <script src="/js/jquery.min.js"></script>
       
        <script src="/js/custom.min.js"></script>

        <script src="/js/validate/jquery.validate.js"></script>
        <script src="/js/alertify/alertify.min.js"></script>
        <script src="/js/login.js"></script>
        <!-- VIEJO FIN -->

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

        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
        <link rel="stylesheet" href="http://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">

        <script src="http://cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js" defer></script>
        <link rel="stylesheet" href="http://cdn.datatables.net/1.11.4/css/jquery.dataTables.min.css" />
        
        <script src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js" defer></script>
        <link rel="stylesheet" href="https://cdn.datatables.net/1.11.4/css/jquery.dataTables.min.css" />
           
        <script src="//cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js" defer></script>
        <link rel="stylesheet" href="//cdn.datatables.net/1.11.4/css/jquery.dataTables.min.css" />

        <script src="/js/jquery.min.js"></script>
        <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

        <!-- jQuery -->
        <script src="/js/jquery.min.js"></script>
        <!--   Core JS Files   -->
        <script src="/assets/js/core/popper.min.js"></script>
        <script src="/assets/js/core/bootstrap.min.js"></script>
        <script src="/assets/js/plugins/perfect-scrollbar.min.js"></script>
        <script src="/assets/js/plugins/smooth-scrollbar.min.js"></script>
        <!-- Kanban scripts -->
        <script src="/assets/js/plugins/dragula/dragula.min.js"></script>
        <script src="/assets/js/plugins/jkanban/jkanban.js"></script>
        <script src="/assets/js/plugins/chartjs.min.js"></script>
        <script src="/assets/js/plugins/threejs.js"></script>
        <script src="/assets/js/plugins/orbit-controls.js"></script>
        
    <!-- Github buttons -->
        <script async defer src="https://buttons.github.io/buttons.js"></script>
    <!-- Control Center for Soft Dashboard: parallax effects, scripts for the example pages etc -->
        <script src="/assets/js/soft-ui-dashboard.min.js?v=1.0.5"></script>
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
        <script src="//cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
       
        <script>
          var ctx = document.getElementById("chart-bars").getContext("2d");

          new Chart(ctx, {
            type: "bar",
            data: {
              labels: ["Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
              datasets: [{
                label: "Sales",
                tension: 0.4,
                borderWidth: 0,
                borderRadius: 4,
                borderSkipped: false,
                backgroundColor: "#fff",
                data: [450, 200, 100, 220, 500, 100, 400, 230, 500],
                maxBarThickness: 6
              }, ],
            },
            options: {
              responsive: true,
              maintainAspectRatio: false,
              plugins: {
                legend: {
                  display: false,
                }
              },
              interaction: {
                intersect: false,
                mode: 'index',
              },
              scales: {
                y: {
                  grid: {
                    drawBorder: false,
                    display: false,
                    drawOnChartArea: false,
                    drawTicks: false,
                  },
                  ticks: {
                    suggestedMin: 0,
                    suggestedMax: 500,
                    beginAtZero: true,
                    padding: 15,
                    font: {
                      size: 14,
                      family: "Open Sans",
                      style: 'normal',
                      lineHeight: 2
                    },
                    color: "#fff"
                  },
                },
                x: {
                  grid: {
                    drawBorder: false,
                    display: false,
                    drawOnChartArea: false,
                    drawTicks: false
                  },
                  ticks: {
                    display: false
                  },
                },
              },
            },
          });


          var ctx2 = document.getElementById("chart-line").getContext("2d");

          var gradientStroke1 = ctx2.createLinearGradient(0, 230, 0, 50);

          gradientStroke1.addColorStop(1, 'rgba(203,12,159,0.2)');
          gradientStroke1.addColorStop(0.2, 'rgba(72,72,176,0.0)');
          gradientStroke1.addColorStop(0, 'rgba(203,12,159,0)'); //purple colors

          var gradientStroke2 = ctx2.createLinearGradient(0, 230, 0, 50);

          gradientStroke2.addColorStop(1, 'rgba(20,23,39,0.2)');
          gradientStroke2.addColorStop(0.2, 'rgba(72,72,176,0.0)');
          gradientStroke2.addColorStop(0, 'rgba(20,23,39,0)'); //purple colors

          new Chart(ctx2, {
            type: "line",
            data: {
              labels: ["Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
              datasets: [{
                  label: "Mobile apps",
                  tension: 0.4,
                  borderWidth: 0,
                  pointRadius: 0,
                  borderColor: "#cb0c9f",
                  borderWidth: 3,
                  backgroundColor: gradientStroke1,
                  fill: true,
                  data: [50, 40, 300, 220, 500, 250, 400, 230, 500],
                  maxBarThickness: 6

                },
                {
                  label: "Websites",
                  tension: 0.4,
                  borderWidth: 0,
                  pointRadius: 0,
                  borderColor: "#3A416F",
                  borderWidth: 3,
                  backgroundColor: gradientStroke2,
                  fill: true,
                  data: [30, 90, 40, 140, 290, 290, 340, 230, 400],
                  maxBarThickness: 6
                },
              ],
            },
            options: {
              responsive: true,
              maintainAspectRatio: false,
              plugins: {
                legend: {
                  display: false,
                }
              },
              interaction: {
                intersect: false,
                mode: 'index',
              },
              scales: {
                y: {
                  grid: {
                    drawBorder: false,
                    display: true,
                    drawOnChartArea: true,
                    drawTicks: false,
                    borderDash: [5, 5]
                  },
                  ticks: {
                    display: true,
                    padding: 10,
                    color: '#b2b9bf',
                    font: {
                      size: 11,
                      family: "Open Sans",
                      style: 'normal',
                      lineHeight: 2
                    },
                  }
                },
                x: {
                  grid: {
                    drawBorder: false,
                    display: false,
                    drawOnChartArea: false,
                    drawTicks: false,
                    borderDash: [5, 5]
                  },
                  ticks: {
                    display: true,
                    color: '#b2b9bf',
                    padding: 20,
                    font: {
                      size: 11,
                      family: "Open Sans",
                      style: 'normal',
                      lineHeight: 2
                    },
                  }
                },
              },
            },
          });


          (function() {
            const container = document.getElementById("globe");
            const canvas = container.getElementsByTagName("canvas")[0];

            const globeRadius = 100;
            const globeWidth = 4098 / 2;
            const globeHeight = 1968 / 2;

            function convertFlatCoordsToSphereCoords(x, y) {
              let latitude = ((x - globeWidth) / globeWidth) * -180;
              let longitude = ((y - globeHeight) / globeHeight) * -90;
              latitude = (latitude * Math.PI) / 180;
              longitude = (longitude * Math.PI) / 180;
              const radius = Math.cos(longitude) * globeRadius;

              return {
                x: Math.cos(latitude) * radius,
                y: Math.sin(longitude) * globeRadius,
                z: Math.sin(latitude) * radius
              };
            }

            function makeMagic(points) {
              const {
                width,
                height
              } = container.getBoundingClientRect();

              // 1. Setup scene
              const scene = new THREE.Scene();
              // 2. Setup camera
              const camera = new THREE.PerspectiveCamera(45, width / height);
              // 3. Setup renderer
              const renderer = new THREE.WebGLRenderer({
                canvas,
                antialias: true
              });
              renderer.setSize(width, height);
              // 4. Add points to canvas
              // - Single geometry to contain all points.
              const mergedGeometry = new THREE.Geometry();
              // - Material that the dots will be made of.
              const pointGeometry = new THREE.SphereGeometry(0.5, 1, 1);
              const pointMaterial = new THREE.MeshBasicMaterial({
                color: "#989db5",
              });

              for (let point of points) {
                const {
                  x,
                  y,
                  z
                } = convertFlatCoordsToSphereCoords(
                  point.x,
                  point.y,
                  width,
                  height
                );

                if (x && y && z) {
                  pointGeometry.translate(x, y, z);
                  mergedGeometry.merge(pointGeometry);
                  pointGeometry.translate(-x, -y, -z);
                }
              }

              const globeShape = new THREE.Mesh(mergedGeometry, pointMaterial);
              scene.add(globeShape);

              container.classList.add("peekaboo");

              // Setup orbital controls
              camera.orbitControls = new THREE.OrbitControls(camera, canvas);
              camera.orbitControls.enableKeys = false;
              camera.orbitControls.enablePan = false;
              camera.orbitControls.enableZoom = false;
              camera.orbitControls.enableDamping = false;
              camera.orbitControls.enableRotate = true;
              camera.orbitControls.autoRotate = true;
              camera.position.z = -265;

              function animate() {
                // orbitControls.autoRotate is enabled so orbitControls.update
                // must be called inside animation loop.
                camera.orbitControls.update();
                requestAnimationFrame(animate);
                renderer.render(scene, camera);
              }
              animate();
            }

            function hasWebGL() {
              const gl =
                canvas.getContext("webgl") || canvas.getContext("experimental-webgl");
              if (gl && gl instanceof WebGLRenderingContext) {
                return true;
              } else {
                return false;
              }
            }

            function init() {
              if (hasWebGL()) {
                window
                window.fetch("https://raw.githubusercontent.com/creativetimofficial/public-assets/master/soft-ui-dashboard-pro/assets/js/points.json")
                  .then(response => response.json())
                  .then(data => {
                    makeMagic(data.points);
                  });
              }
            }
            init();
          })();
        </script>
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
        <script src="../../assets/js/soft-ui-dashboard.min.js?v=1.0.5"></script>
       
        
html;



    return $footer.$extra;
    }

}
