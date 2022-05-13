<?php

namespace App\controllers;
//defined("APPPATH") OR die("Access denied");
require_once dirname(__DIR__) . '/../public/librerias/fpdf/fpdf.php';
require_once dirname(__DIR__) . '/../public/librerias/phpqrcode/qrlib.php';


use \Core\View;
use \Core\MasterDom;
use \App\controllers\Contenedor;
use \Core\Controller;
use \App\models\Colaboradores as ColaboradoresDao;
use \App\models\Accidentes as AccidentesDao;
use \App\models\General as GeneralDao;
use \App\models\Pases as PasesDao;
use \App\models\PruebasCovidUsuarios as PruebasCovidUsuariosDao;
use \App\models\ComprobantesVacunacion as ComprobantesVacunacionDao;
use \App\models\Asistentes as AsistentesDao;

use Generator;

class Asistentes extends Controller
{

    private $_contenedor;

    function __construct()
    {
        parent::__construct();
        $this->_contenedor = new Contenedor;
        View::set('header', $this->_contenedor->header());
        View::set('footer', $this->_contenedor->footer());
        // if (Controller::getPermisosUsuario($this->__usuario, "seccion_asistentes", 1) == 0)
        //     header('Location: /Principal/');
    }

    public function index()
    {

        View::set('asideMenu',$this->_contenedor->asideMenu());
        // View::set('tabla_faltantes', $this->getAsistentesFaltantes());
        // View::set('tabla', $this->getAllColaboradoresAsignados());
        View::render("asistentes_all");
    }

    //Metodo para reaslizar busqueda de usuarios, sin este metodo no podemos obtener informacion en la vista
    public function Usuario() {
        $search = $_POST['search'];       

        $all_ra = AsistentesDao::getAllRegistrosAcceso();
        $this->setTicketVirtual($all_ra);
        $this->setClaveRA($all_ra);

        $modal = '';
        foreach (GeneralDao::getAllColaboradoresByName($search) as $key => $value) {
            $modal .= $this->generarModal($value);
        }
        
        View::set('modal',$modal);    
        View::set('tabla', $this->getAllColaboradoresAsignadosByName($search));
        View::set('asideMenu',$this->_contenedor->asideMenu());    
        View::render("asistentes_all");
    }

    public function setTicketVirtual($asistentes){
        foreach ($asistentes as $key => $value) {
            if ($value['clave'] == '' || $value['clave'] == NULL || $value['clave'] == 'NULL') {
                $clave_10 = $this->generateRandomString(6);
                AsistentesDao::updateTicketVirtualRA($value['id_registro_acceso'], $clave_10);
            }
        }
    }

    public function setClaveRA($all_ra){
        foreach ($all_ra as $key => $value) {
            if ($value['clave'] == '' || $value['clave'] == NULL || $value['clave'] == 'NULL') {
                $clave_10 = $this->generateRandomString(10);
                AsistentesDao::updateClaveRA($value['id_registro_acceso'], $clave_10);
            }
        }
    }

    public function Detalles($id){

        $extraHeader = <<<html


        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
        <link href="Content/jquery.Jcrop.css" rel="stylesheet" />
        <style>
        .select2-container--default .select2-selection--single {
        height: 38px!important;
        border-radius: 8px!important;
        }
        .select2-container--default .select2-selection--single .select2-selection__rendered {
            color: #444;
            line-height: 32px;
        }
        .select2-container--default.select2-container--focus .select2-selection--multiple {
           // height: 38px!important;
            border-radius: 8px!important;
        }
        
        // .select2-container--default .select2-selection--multiple {
        //     height: 38px!important;
        //     border-radius: 8px!important;
        // }
        </style>

        

html;

        $extraFooter = <<<html
            <!--Select 2-->
            <script src="/js/jquery.min.js"></script>
            <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
            <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
            <!--   Core JS Files   -->
            <script src="../../../assets/js/core/popper.min.js"></script>
            <script src="../../../assets/js/core/bootstrap.min.js"></script>
            <script src="../../../assets/js/plugins/perfect-scrollbar.min.js"></script>
            <script src="../../../assets/js/plugins/smooth-scrollbar.min.js"></script>
            <!-- Kanban scripts -->
            <script src="../../../assets/js/plugins/dragula/dragula.min.js"></script>
            <script src="../../../assets/js/plugins/jkanban/jkanban.js"></script>
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
            <!--script src="../../../assets/js/soft-ui-dashboard.min.js?v=1.0.5"></script-->
            <script src="../../../assets/js/plugins/choices.min.js"></script>
            <script type="text/javascript" wfd-invisible="true">
                if (document.getElementById('choices-button')) {
                    var element = document.getElementById('choices-button');
                    const example = new Choices(element, {});
                }
                var choicesTags = document.getElementById('choices-tags');
                var color = choicesTags.dataset.color;
                if (choicesTags) {
                    const example = new Choices(choicesTags, {
                    delimiter: ',',
                    editItems: true,
                    maxItemCount: 5,
                    removeItemButton: true,
                    addItems: true,
                    classNames: {
                        item: 'badge rounded-pill choices-' + color + ' me-2'
                    }
                    });
                }
            </script>
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
            <!--script src="/assets/js/soft-ui-dashboard.min.js?v=1.0.5"--></script>

            <script>
                $(document).ready(function() {
                    // $('#select_alergico').select2();
                });

                $(".btn_iframe").on("click",function(){
                    var documento = $(this).attr('data-document');
                    var modal_id = $(this).attr('data-target');
                  
                    if($(modal_id+" iframe").length == 0){
                        $(modal_id+" .iframe").append('<iframe src="https://registro.foromusa.com/comprobante_vacunacion/'+documento+'" style="width:100%; height:700px;" frameborder="0" ></iframe>');
                    }          
                  });

                  $(".btn_iframe_pruebas_covid").on("click",function(){
                    var documento = $(this).attr('data-document');
                    var modal_id = $(this).attr('data-target');
                  
                    if($(modal_id+" iframe").length == 0){
                        $(modal_id+" .iframe").append('<iframe src="https://registro.foromusa.com/pruebas_covid/'+documento+'" style="width:100%; height:700px;" frameborder="0" ></iframe>');
                    }          
                  });


                  
            </script>

            <!-- VIEJO INICIO -->
            <script src="/js/jquery.min.js"></script>
        
            <script src="/js/custom.min.js"></script>

            <script src="/js/validate/jquery.validate.js"></script>
            <script src="/js/alertify/alertify.min.js"></script>
            <script src="/js/login.js"></script>
            <!-- VIEJO FIN -->

            <!--script src="http://cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js" defer></script>
            <link rel="stylesheet" href="http://cdn.datatables.net/1.11.4/css/jquery.dataTables.min.css" /-->

            <script src="//cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js" defer></script>
            <link rel="stylesheet" href="//cdn.datatables.net/1.11.4/css/jquery.dataTables.min.css" />
html;
        $detalles = AsistentesDao::getByClaveRA($id);
        $detalles_registro = AsistentesDao::getTotalByClaveRA($id);

        if ($detalles_registro[0]['img'] == '') {
            $img_asistente = <<<html
            <img src="/img/user.png" class="avatar avatar-xxl me-3" title="{$detalles_registro[0]['usuario']}" alt="{$detalles_registro[0]['usuario']}">
html;
        } else {
            $img_asistente = <<<html
            <img src="https://registro.foromusa.com/img/users_musa/{$detalles_registro[0]['img']}" class="avatar avatar-xxl me-3" title="{$detalles_registro[0]['usuario']}" alt="{$detalles_registro[0]['usuario']}">
html;
        }

        // var_dump($detalles_registro[0]['alergia']);
        if ($detalles_registro[0]['alergia'] == '') {
            $res_alimenticias = <<<html
            <div class="col-md-4 col-sm-12">
                <label class="form-label mt-4">Restricciones Alimentarias *</label>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="restricciones_alimenticias" id="res_ali_1" value="vegetariano">
                    <label class="form-check-label" for="res_ali_1">
                        Vegetariano
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="restricciones_alimenticias" id="res_ali_2" value="vegano">
                    <label class="form-check-label" for="res_ali_2">
                        Vegano
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="restricciones_alimenticias" id="res_ali_4" value="ninguna" checked>
                    <label class="form-check-label" for="res_ali_4">
                        Ninguna
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="restricciones_alimenticias" id="res_ali_5" value="otro">
                    <label class="form-check-label" for="res_ali_5">
                        Otro
                    </label>
                </div>
                <div class="col-md-12 col-sm-12 restricciones_alimenticias" style="display: none!important;">
                    <label class="form-label mt-4">¿Cual?</label>
                    <input id="restricciones_alimenticias_cual" name="restricciones_alimenticias_cual" maxlength="45" class="form-control" type="text" placeholder="Escriba su restricción" value="">
                </div>
            </div>
html;
        } else {
            if ($detalles_registro[0]['alergia'] == 'otro') {
                $res_alimenticias = <<<html
            <div class="col-md-4 col-sm-12">
                <label class="form-label mt-4">Restricciones Alimentarias *</label>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="restricciones_alimenticias" id="res_ali_1" value="vegetariano">
                    <label class="form-check-label" for="res_ali_1">
                        Vegetariano
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="restricciones_alimenticias" id="res_ali_2" value="vegano">
                    <label class="form-check-label" for="res_ali_2">
                        Vegano
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="restricciones_alimenticias" id="res_ali_4" value="ninguna" >
                    <label class="form-check-label" for="res_ali_4">
                        Ninguna
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="restricciones_alimenticias" id="res_ali_5" value="otro" checked>
                    <label class="form-check-label" for="res_ali_5">
                        Otro
                    </label>
                </div>
                <div class="col-md-12 col-sm-12 restricciones_alimenticias" >
                    <label class="form-label mt-4">¿Cual?</label>
                    <input id="restricciones_alimenticias_cual" name="restricciones_alimenticias_cual" maxlength="45" class="form-control" type="text" placeholder="Escriba su restricción" value="{$detalles_registro[0]['alergia_cual']}">
                </div>
            </div>
html;
            }

            if ($detalles_registro[0]['alergia'] == 'ninguna') {
                $res_alimenticias = <<<html
            <div class="col-md-4 col-sm-12">
                <label class="form-label mt-4">Restricciones Alimentarias *</label>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="restricciones_alimenticias" id="res_ali_1" value="vegetariano">
                    <label class="form-check-label" for="res_ali_1">
                        Vegetariano
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="restricciones_alimenticias" id="res_ali_2" value="vegano">
                    <label class="form-check-label" for="res_ali_2">
                        Vegano
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="restricciones_alimenticias" id="res_ali_4" value="ninguna" checked>
                    <label class="form-check-label" for="res_ali_4">
                        Ninguna
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="restricciones_alimenticias" id="res_ali_5" value="otro" >
                    <label class="form-check-label" for="res_ali_5">
                        Otro
                    </label>
                </div>
                <div class="col-md-12 col-sm-12 restricciones_alimenticias" style="display: none!important;">
                    <label class="form-label mt-4">¿Cual?</label>
                    <input id="restricciones_alimenticias_cual" name="restricciones_alimenticias_cual" maxlength="45" class="form-control" type="text" placeholder="Escriba su restricción" value="{$detalles_registro[0]['restricciones_alimenticias_cual']}">
                </div>
            </div>
html;
            }

            if ($detalles_registro[0]['alergia'] == 'vegano') {
                $res_alimenticias = <<<html
            <div class="col-md-4 col-sm-12">
                <label class="form-label mt-4">Restricciones Alimentarias *</label>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="restricciones_alimenticias" id="res_ali_1" value="vegetariano">
                    <label class="form-check-label" for="res_ali_1">
                        Vegetariano
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="restricciones_alimenticias" id="res_ali_2" value="vegano" checked>
                    <label class="form-check-label" for="res_ali_2">
                        Vegano
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="restricciones_alimenticias" id="res_ali_4" value="ninguna" >
                    <label class="form-check-label" for="res_ali_4">
                        Ninguna
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="restricciones_alimenticias" id="res_ali_5" value="otro" >
                    <label class="form-check-label" for="res_ali_5">
                        Otro
                    </label>
                </div>
                <div class="col-md-12 col-sm-12 restricciones_alimenticias" style="display: none!important;">
                    <label class="form-label mt-4">¿Cual?</label>
                    <input id="restricciones_alimenticias_cual" name="restricciones_alimenticias_cual" maxlength="45" class="form-control" type="text" placeholder="Escriba su restricción" value="{$detalles_registro[0]['restricciones_alimenticias_cual']}">
                </div>
            </div>
html;
            }

            if ($detalles_registro[0]['alergia'] == 'vegetariano') {
                $res_alimenticias = <<<html
            <div class="col-md-4 col-sm-12">
                <label class="form-label mt-4">Restricciones Alimentarias *</label>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="restricciones_alimenticias" id="res_ali_1" value="vegetariano" checked>
                    <label class="form-check-label" for="res_ali_1">
                        Vegetariano
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="restricciones_alimenticias" id="res_ali_2" value="vegano">
                    <label class="form-check-label" for="res_ali_2">
                        Vegano
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="restricciones_alimenticias" id="res_ali_4" value="ninguna" >
                    <label class="form-check-label" for="res_ali_4">
                        Ninguna
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="restricciones_alimenticias" id="res_ali_5" value="otro" >
                    <label class="form-check-label" for="res_ali_5">
                        Otro
                    </label>
                </div>
                <div class="col-md-12 col-sm-12 restricciones_alimenticias" style="display: none!important;">
                    <label class="form-label mt-4">¿Cual?</label>
                    <input id="restricciones_alimenticias_cual" name="restricciones_alimenticias_cual" maxlength="45" class="form-control" type="text" placeholder="Escriba su restricción" value="{$detalles_registro[0]['restricciones_alimenticias_cual']}">
                </div>
            </div>
html;
            }
        }

        $all_ra = AsistentesDao::getAllRegistrosAcceso();

        foreach ($all_ra as $key => $value) {
            if ($value['clave'] == '' || $value['clave'] == NULL || $value['clave'] == 'NULL') {
                $clave_10 = $this->generateRandomString(10);
                AsistentesDao::updateClaveRA($value['id_registro_acceso'], $clave_10);
            }
        }

        foreach ($all_ra as $key => $value) {
            if ($value['ticket_virtual'] == '' || $value['ticket_virtual'] == NULL || $value['ticket_virtual'] == 'NULL') {
                $clave_6 = $this->generateRandomString(6);
                $this->generaterQr($all_ra['ticket_virtual']);
                AsistentesDao::updateTicketVirtualRA($value['id_registro_acceso'], $clave_6);
            }
        }

        $email = AsistentesDao::getByClaveRA($id)[0]['usuario'];
        $clave_user = AsistentesDao::getRegistroAccesoByClaveRA($id)[0];
        $tv = AsistentesDao::getRegistroAccesoByClaveRA($id)[0]['ticket_virtual'];
        $nombre = AsistentesDao::getRegistroAccesoByClaveRA($id)[0]['nombre'].' '.AsistentesDao::getRegistroAccesoByClaveRA($id)[0]['segundo_nombre'];
        $apellidos = AsistentesDao::getRegistroAccesoByClaveRA($id)[0]['apellido_paterno'].' '.AsistentesDao::getRegistroAccesoByClaveRA($id)[0]['apellido_materno'];
        if ($clave_user['ticket_virtual'] == '' || $clave_user['ticket_virtual'] == NULL || $clave_user['ticket_virtual'] == 'NULL') {
            $msg_clave = 'No posee ningún código';
            $btn_clave = '';
            var_dump($clave_user['ticket_virtual']);
            $btn_genQr = <<<html
            <!--button type="button" id="generar_clave" title="Generar Ticket Virtual" class="btn bg-gradient-dark mb-0"><i class="fas fa-qrcode"></i></button-->
html;
        }

        $btn_gafete = "<a href='/RegistroAsistencia/abrirpdfGafete/{$clave_user['clave']}/{$clave_user['clave_ticket']}' target='_blank' id='a_abrir_gafete' class='btn btn-info' data-bs-toggle='tooltip' data-bs-placement='top' data-bs-original-title='Imprimir Gafetes'><i class='fa fal fa-address-card' style='font-size: 18px;'> </i> Presione esté botón para descargar el gafete</a>";
        // $btn_etiquetas = "<a href='/RegistroAsistencia/abrirpdf/{$clave_user['clave']}' target='_blank' id='a_abrir_etiqueta' class='btn btn-info'>Imprimir etiquetas</a>";
        $this->generaterQr($tv);


        $permisoGlobalHidden = (Controller::getPermisoGlobalUsuario($this->__usuario)[0]['permisos_globales']) != 1 ? "style=\"display:none;\"" : "";
        $asistentesHidden = (Controller::getPermisosUsuario($this->__usuario, "seccion_asistentes", 1) == 0) ? "style=\"display:none;\"" : "";
        $vuelosHidden = (Controller::getPermisosUsuario($this->__usuario, "seccion_vuelos", 1) == 0) ? "style=\"display:none;\"" : "";
        $pickUpHidden = (Controller::getPermisosUsuario($this->__usuario, "seccion_pickup", 1) == 0) ? "style=\"display:none;\"" : "";
        $habitacionesHidden = (Controller::getPermisosUsuario($this->__usuario, "seccion_habitaciones", 1) == 0) ? "style=\"display:none;\"" : "";
        $cenasHidden = (Controller::getPermisosUsuario($this->__usuario, "seccion_cenas", 1) == 0) ? "style=\"display:none;\"" : "";
        $cenasHidden = (Controller::getPermisosUsuario($this->__usuario, "seccion_cenas", 1) == 0) ? "style=\"display:none;\"" : "";
        $aistenciasHidden = (Controller::getPermisosUsuario($this->__usuario, "seccion_asistencias", 1) == 0) ? "style=\"display:none;\"" : "";
        $vacunacionHidden = (Controller::getPermisosUsuario($this->__usuario, "seccion_vacunacion", 1) == 0) ? "style=\"display:none;\"" : "";
        $pruebasHidden = (Controller::getPermisosUsuario($this->__usuario, "seccion_pruebas_covid", 1) == 0) ? "style=\"display:none;\"" : "";
        $configuracionHidden = (Controller::getPermisosUsuario($this->__usuario, "seccion_configuracion", 1) == 0) ? "style=\"display:none;\"" : "";
        $utileriasHidden = (Controller::getPermisosUsuario($this->__usuario, "seccion_utilerias", 1) == 0) ? "style=\"display:none;\"" : "";

        View::set('permisoGlobalHidden', $permisoGlobalHidden);
        View::set('asistentesHidden', $asistentesHidden);
        View::set('vuelosHidden', $vuelosHidden);
        View::set('pickUpHidden', $pickUpHidden);
        View::set('habitacionesHidden', $habitacionesHidden);
        View::set('cenasHidden', $cenasHidden);
        View::set('aistenciasHidden', $aistenciasHidden);
        View::set('vacunacionHidden', $vacunacionHidden);
        View::set('pruebasHidden', $pruebasHidden);
        View::set('configuracionHidden', $configuracionHidden);
        View::set('utileriasHidden', $utileriasHidden);

        View::set('id_asistente', $id);
        View::set('detalles', $detalles[0]);
        View::set('img_asistente', $img_asistente);
        View::set('email', $email);
        View::set('nombre', $nombre);
        View::set('apellidos', $apellidos);
        View::set('clave_user', $clave_user['clave_ticket']);
        View::set('msg_clave', $msg_clave);
        View::set('btn_gafete', $btn_gafete);
        View::set('clave_ra', $id);
        View::set('asideMenu',$this->_contenedor->asideMenu());
        View::set('btn_clave', $btn_clave);
        View::set('btn_genQr', $btn_genQr);
        // View::set('alergias_a', $alergias_a);
        View::set('res_alimenticias', $res_alimenticias);
        // View::set('alergia_medicamento_cual', $alergia_medicamento_cual);
        View::set('detalles_registro', $detalles_registro[0]);
        View::set('header', $this->_contenedor->header($extraHeader));
        View::set('footer', $this->_contenedor->footer($extraFooter));
        View::set('tabla_vacunacion', $this->getComprobanteVacunacionById($id));
        View::set('tabla_prueba_covid', $this->getPruebasCovidById($id));
        View::render("asistentes_detalles");
    }

    public function generaterQr($clave_ticket)
    {

        $codigo_rand = $clave_ticket;

        $config = array(
            'ecc' => 'H',    // L-smallest, M, Q, H-best
            'size' => 11,    // 1-50
            'dest_file' => '../public/qrs/' . $codigo_rand . '.png',
            'quality' => 90,
            'logo' => 'logo.jpg',
            'logo_size' => 100,
            'logo_outline_size' => 20,
            'logo_outline_color' => '#FFFF00',
            'logo_radius' => 15,
            'logo_opacity' => 100,
        );

        // Contenido del código QR
        $data = $codigo_rand;

        // Crea una clase de código QR
        $oPHPQRCode = new PHPQRCode();

        // establecer configuración
        $oPHPQRCode->set_config($config);

        // Crea un código QR
        $qrcode = $oPHPQRCode->generate($data);

        //   $url = explode('/', $qrcode );
    }

    public function Actualizar()
    {

        $documento = new \stdClass();

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $id_registro = $_POST['id_registro'];
            $nombre = $_POST['nombre'];
            $segundo_nombre = $_POST['segundo_nombre'];
            $apellido_paterno = $_POST['apellido_paterno'];
            $apellido_materno = $_POST['apellido_materno'];
            $fecha_nacimiento = $_POST['fecha_nacimiento'];
            $email = $_POST['email'];
            $telefono = $_POST['telefono'];
            // $alergias = $_POST['select_alergico'];
            // $alergias_otro = $_POST['alergias_otro'];
            $alergia_medicamento = $_POST['confirm_alergia'];
            if (isset($_POST['alergia_medicamento_cual'])) {
                $alergia_medicamento_cual = $_POST['alergia_medicamento_cual'];
            } else {
                $alergia_medicamento_cual = '';
            }
            $alergia_medicamento_cual = $_POST['alergia_medicamento_cual'];
            $restricciones_alimenticias = $_POST['restricciones_alimenticias'];
            $restricciones_alimenticias_cual = $_POST['restricciones_alimenticias_cual'];

            $documento->_nombre = $nombre;
            $documento->_segundo_nombre = $segundo_nombre;
            $documento->_apellido_paterno = $apellido_paterno;
            $documento->_apellido_materno = $apellido_materno;
            $documento->_fecha_nacimiento = $fecha_nacimiento;
            $documento->_email = $email;
            $documento->_telefono = $telefono;
            // $documento->_alergias = $alergias;
            // $documento->_alergias_otro = $alergias_otro;
            // $documento->_alergia_medicamento = $alergia_medicamento;
            // $documento->_alergia_medicamento_cual = $alergia_medicamento_cual;
            $documento->_restricciones_alimenticias = $restricciones_alimenticias;
            $documento->_restricciones_alimenticias_cual = $restricciones_alimenticias_cual;

            // var_dump($documento);
            $id = AsistentesDao::update($documento);

            if ($id) {
                echo "success";
            } else {
                echo "fail";
                // header("Location: /Home/");
            }
        } else {
            echo 'fail REQUEST';
        }
    }

    public function darClaveRegistrosAcceso($id, $clave)
    {
        AsistentesDao::updateClaveRA($id, $clave);
    }

    public function generarClave($email)
    {

        // $clave_user = AsistentesDao::getClaveByEmail($email)[0]['clave'];
        $tiene_ticket = AsistentesDao::getClaveByEmail($email)[0]['clave_ticket'];
        $tiene_clave = '';
        $clave_random = $this->generateRandomString(6);
        $id_registros_acceso = AsistentesDao::getRegistroByEmail($email)[0]['id_registro_acceso'];


        if ($tiene_ticket == NULL || $tiene_ticket == 'NULL' || $tiene_ticket == 0) {
            $tiene_clave = 'no_tiene';
            AsistentesDao::insertTicket($clave_random);
            $id_tv = AsistentesDao::getIdTicket($clave_random)[0]['id_ticket_virtual'];
            $asignar_clave = AsistentesDao::generateCodeOnTable($email, $id_tv);
        } else {
            $tiene_clave = 'ya_tiene';
            $asignar_clave = 1;
        }

        if ($asignar_clave) {
            $data = [
                'status' => 'success',
                'tiene_ticket' => $tiene_ticket,
                'clave' => $tiene_clave,
                // 'id_registros_acceso'=>$id_registros_acceso
            ];
        } else {
            $data = [
                'status' => 'fail'
            ];
        }

        echo json_encode($data);
    }

    public function getAllColaboradoresAsignados()
    {

        $html = "";
        foreach (GeneralDao::getAllColaboradores() as $key => $value) {
            if ($value['alergia'] == '' && $value['alergia_cual'] == '') {
                $alergia = 'No registro alergias';
            } else {
                if ($value['alergia'] == 'otro') {
                    $alergia = $value['alergia_cual'];
                } else {
                    $alergia = $value['alergia'];
                }
            }

            if ($value['alergia_medicamento'] == 'si') {
                if ($value['alergia_medicamento_cual'] == '') {
                    $alergia_medicamento = 'No registro alergias a medicamentos';
                } else {
                    $alergia_medicamento = $value['alergia_medicamento_cual'];
                }
            } else {
                $alergia_medicamento = 'No posee ninguna alergia';
            }

            if ($value['restricciones_alimenticias'] == 'ninguna' || $value['restricciones_alimenticias'] == '') {
                $restricciones_alimenticias = 'No registro restricciones alimenticias';
            } else {
                if ($value['restricciones_alimenticias'] == 'otro') {
                    $restricciones_alimenticias = $value['restricciones_alimenticias_cual'];
                } else {
                    $restricciones_alimenticias = $value['restricciones_alimenticias'];
                }
            }

            $value['apellido_paterno'] = utf8_encode($value['apellido_paterno']);
            $value['apellido_materno'] = utf8_encode($value['apellido_materno']);
            $value['nombre'] = utf8_encode($value['nombre']);

            if (empty($value['img']) || $value['img'] == null) {
                $img_user = "/img/user.png";
            } else {
                $img_user = "https://registro.foromusa.com/img/users_musa/{$value['img']}";
            }

            $estatus = '';
            if ($value['status'] == 1) {
                $estatus .= <<<html
                <span class="badge badge-success">Activo</span>
html;
            } else {
                $estatus .= <<<html
                <span class="badge badge-success">Inactivo</span>
html;
            }

            // 6c5df2a1307bb58194383e7e79ac9414
            $pases = PasesDao::getByIdUser($value['utilerias_asistentes_id']);
            $cont_pase_ida = 0;
            $cont_pase_regreso = 0;
            foreach ($pases as $key => $pas) {

                if ($pases >= 1) {

                    if ($pas['tipo'] == 1) {
                        $cont_pase_ida++;

                        if ($pas['status'] == 1) {

                            $pase_ida = '<p class="text-sm font-weight-bold mb-0 " style="cursor: pointer;" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-bs-original-title="Documento validado"><span class="fa fa-plane-departure" style=" font-size: 13px;"></span> Regreso (<i class="fa fa-solid fa-check" style="color: green;"></i>)</p> ';
                        } else {
                            $pase_ida = '<p class="text-sm font-weight-bold mb-0 " style="cursor: pointer;" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-bs-original-title="Documento pendiente de validar"><span class="fa fa-plane-departure" style="font-size: 13px;"></span> Regreso (<i class="fa fa-solid fa-hourglass-end" style="color: #1a8fdd;"></i>)</p> ';
                        }
                    } elseif ($pas['tipo'] == 2) {
                        $cont_pase_regreso++;

                        if ($pas['status'] == 1) {

                            $pase_regreso = '<p class="text-sm font-weight-bold mb-0 " style="cursor: pointer;" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-bs-original-title="Documento validado"><span class="fa fa-plane-arrival" style=" font-size: 13px;"></span> Llegada (<i class="fa fa-solid fa-check" style="color: green;"></i>)</p>';
                        } else {
                            $pase_regreso = '<p class="text-sm font-weight-bold mb-0 " style="cursor: pointer;" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-bs-original-title="Documento pendiente de validar"><span class="fa fa-plane-arrival" style="font-size: 13px"></span> Llegada (<i class="fa fa-solid fa-hourglass-end" style="color: #1a8fdd;"></i>)</p>';
                        }
                    }
                }
            }

            if ($cont_pase_regreso <= 0) {
                $pase_regreso = '<p class="text-sm font-weight-bold mb-0 " style="cursor: pointer;" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-bs-original-title="Aún no se sube el documento"><span class="fa fa-plane-arrival" style="font-size: 13px"></span> Llegada (<i class="fas fa-times" style="color: #7B241C;"></i>)</p>';
            }

            if ($cont_pase_ida <= 0) {
                $pase_ida = '<p class="text-sm font-weight-bold mb-0 " style="cursor: pointer;"  data-bs-toggle="tooltip" data-bs-placement="top" title="" data-bs-original-title="Aún no se sube el documento"><span class="fa fa-plane-departure" style="font-size: 13px;"></span> Regreso (<i class="fas fa-times" style="color: #7B241C;"></i>)</p>';
            }

            $pruebacovid = PruebasCovidUsuariosDao::getByIdUser($value['utilerias_asistentes_id'])[0];

            if ($pruebacovid) {

                if ($pruebacovid['status'] == 1) {
                    $pru_covid = '<p class="text-sm font-weight-bold mb-0 " style="cursor: pointer;" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-bs-original-title="Documento validado"><span class="fa fas fa-virus" style="font-size: 13px;"></span> Prueba Covid (<i class="fas fa-times" style="color:#7B241C;"></i>)</p>';
                } else{ 
                    if ($pruebacovid['status'] == 2) {
                        $pru_covid = '<p class="text-sm font-weight-bold mb-0 " style="cursor: pointer;" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-bs-original-title="Documento validado"><span class="fa fas fa-virus" style="font-size: 13px;"></span> Prueba Covid (<i class="fa fa-solid fa-check" style="color: green;"></i>)</p>';
                    } else {
                        $pru_covid = '<p class="text-sm font-weight-bold mb-0 " style="cursor: pointer;" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-bs-original-title="Documento pendiente de validar"><span class="fa fas fa-virus" style="font-size: 13px;"></span> Prueba Covid (<i class="fa fa-solid fa-hourglass-end" style="color: #1a8fdd;"></i>)</p>';
                
                    }
                }
            } else {
                $pru_covid = '<p class="text-sm font-weight-bold mb-0 " style="cursor: pointer;" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-bs-original-title="Aún no se sube el documento"><span class="fa fas fa-virus" style="font-size: 13px;"></span> Prueba Covid (<i class="fas fa-times" style="color:#7B241C;"></i>)</p>';
            }

            $comprobantecovid = ComprobantesVacunacionDao::getByIdUser($value['utilerias_asistentes_id'])[0];

            if ($comprobantecovid) {

                if ($comprobantecovid['validado'] == 1) {

                    $compro_covid = '<p class="text-sm font-weight-bold mb-0 " style="cursor: pointer;" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-bs-original-title="Documento validado"><span class="fa fa-file-text-o" style="font-size: 13px;"></span> Comprobante Covid (<i class="fa fa-solid fa-check" style="color: green;"></i>)</p>';
                } else {

                    $compro_covid = '<p class="text-sm font-weight-bold mb-0 " style="cursor: pointer;" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-bs-original-title="Documento pendiente de validar"><span class="fa fa-file-text-o" style="font-size: 13px;"></span> Comprobante Covid (<i class="fa fa-solid fa-hourglass-end" style="color:#1a8fdd;"></i>)</p>';
                }
            } else {
                $compro_covid = '<p class="text-sm font-weight-bold mb-0 " style="cursor: pointer;" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-bs-original-title="Aún no se sube el documento"><span class="fa fa-file-text-o" style="font-size: 13px;"></span> Comprobante Covid  (<i class="fas fa-times" style="color: #7B241C;" ></i>)</p>';
            }

            // $id_linea = $value['id_linea_principal'];           

            // $ticket_virtual = GeneralDao::searchAsistentesTicketbyId($value['utilerias_asistentes_id'])[0];


            // if ($ticket_virtual['clave'] != null) {

            //     $ticket_v = '<p class="text-sm font-weight-bold mb-0 " style="cursor: pointer;" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-bs-original-title="Ticket Virtual generado"><span class="fa fa-ticket" style="font-size: 13px;"></span> Ticket Virtual (<i class="fa fa-solid fa-check" style="color: green;"></i>)</p>';
            // } else {

            //     $ticket_v = '<p class="text-sm font-weight-bold mb-0 " style="cursor: pointer;" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-bs-original-title="No se ha generado su ticket virtual"><span class="fa fa-ticket" style="font-size: 13px;"></span> Ticket Virtual (<i class="fas fa-times" style="color: #7B241C;" ></i>)</p>';
            // }

            $itinerario = GeneralDao::searchItinerarioByAistenteId($value['utilerias_asistentes_id'])[0];

            if ($itinerario['id_uasis_it'] != null) {

                $itinerario_asis = '<p class="text-sm font-weight-bold mb-0 " style="cursor: pointer;" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-bs-original-title="Itinerario Cargado"><span class="fa fa-calendar-check-o" style="font-size: 13px;"></span> Itinerario (<i class="fa fa-solid fa-check" style="color: green;"></i>)</p>';
            } else {

                $itinerario_asis = '<p class="text-sm font-weight-bold mb-0 " style="cursor: pointer;" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-bs-original-title="No se ha cargado el itinerario"><span class="fa fa-calendar-check-o" style="font-size: 13px;"></span> Itinerario (<i class="fas fa-times" style="color: #7B241C;" ></i>)</p>';
            }


            $html .= <<<html
            <tr>
                <td>
                    <div class="d-flex px-3 py-1">
                        <div>
                            <img src="{$img_user}" class="avatar me-3" alt="image">
                        </div>
                        <div class="d-flex flex-column justify-content-center">
                    
                            <a href="/Asistentes/Detalles/{$value['clave']}" target="_blank">
                            <h6 class="mb-0 text-sm"><span class="fa fa-user-md" style="font-size: 13px"></span> {$value['nombre']} {$value['segundo_nombre']} {$value['apellido_paterno']} {$value['apellido_materno']} $estatus</h6></a>
                            <div class="d-flex flex-column justify-content-center">
                                <u><a href="mailto:{$value['email']}"><h6 class="mb-0 text-sm"><span class="fa fa-mail-bulk" style="font-size: 13px"></span> {$value['usuario']}</h6></a></u>
                                <u><a href="https://api.whatsapp.com/send?phone=52{$value['telefono']}&text=Buen%20d%C3%ADa,%20te%20contacto%20de%20parte%20del%20Equipo%20Grupo%20LAHE%20%F0%9F%98%80" target="_blank"><p class="text-sm font-weight-bold text-secondary mb-0"><span class="fa fa-whatsapp" style="font-size: 13px; color:green;"></span> {$value['telefono']}</p></a></u>
                            </div>
                            <!--<p class="text-sm mb-0"><span class="fa fa-solid fa-id-card" style="font-size: 13px;"></span> Número de empleado:  <span style="text-decoration: underline;">{$value['numero_empleado']}</span></p>-->
                            <hr>
                            <!--<p class="text-sm font-weight-bold mb-0 "><span class="fa fas fa-user-tie" style="font-size: 13px;"></span><b> Ejecutivo Asignado a Línea: </b><br><span class="fas fa-suitcase"> </span> {$value['nombre_ejecutivo']} <span class="badge badge-success" style="background-color:  {$value['color']}; color:white "><strong>{$value['nombre_linea_ejecutivo']}</strong></span></p>-->
                            
                        </div>
                    </div>
                </td>
         
                <td style="text-align:left; vertical-align:middle;"> 
                    
                    <!--<p class="text-sm font-weight-bold mb-0 "><span class="fa fa-business-time" style="font-size: 13px;"></span><b> Bu: </b>{$value['nombre_bu']}</p>-->
                    <p class="text-sm font-weight-bold mb-0 "><span class="fa fa-pills" style="font-size: 13px;"></span><b> Linea Principal: </b>{$value['nombre_linea']}</p>
                    <!--<p class="text-sm font-weight-bold mb-0 "><span class="fa fa-hospital" style="font-size: 13px;"></span><b> Posición: </b>{$value['nombre_posicion']}</p>-->

                    <!--hr>
                    <p class="text-sm font-weight-bold mb-0 "><span class="fas fa-egg-fried" style="font-size: 13px;"></span><b> Restricciones alimenticias: </b>{$value['restricciones_alimenticias']}</p>-->
                    
                    <p class="text-sm font-weight-bold mb-0 "><span class="fas fa-allergies" style="font-size: 13px;"></span><b> Alergias: </b>{$value['alergia']}{$value['alergia_cual']} <br>
                    {$value['alergia_medicamento_cual']}</p>

                    <!--<hr>
                    <p class="text-sm font-weight-bold mb-0 "><span class="fas fa-ban" style="font-size: 13px;"></span><b> Restricciones alimenticias: </b>{$restricciones_alimenticias}</p>
                    
                    <p class="text-sm font-weight-bold mb-0 "><span class="fas fa-allergies" style="font-size: 13px;"></span><b> Alergias:</b> {$alergia}

                    <p class="text-sm font-weight-bold mb-0 "><span class="fas fa-pills" style="font-size: 13px;"></span><b> Alergias a medicamentos:</b> {$alergia_medicamento}</p>-->

                </td>

        

          <td style="text-align:left; vertical-align:middle;"> 
            {$pase_ida}
            {$pase_regreso}
            {$ticket_v}
            {$pru_covid}
            {$compro_covid}
            {$itinerario_asis}  
          </td>
          
          <td style="text-align:center; vertical-align:middle;">
            <a href="/Asistentes/Detalles/{$value['clave']}" hidden><i class="fa fa-eye"></i></a>
            <button class="btn bg-pink btn-icon-only morado-musa-text" title="" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="Imprimir Gafetes"><i class="fas fa-print"></i></button>
            <button class="btn bg-turquoise btn-icon-only text-white" title="" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="Imprimir Etiquetas"><i class="fas fa-tag"></i></button>
            <!--button type="button" class="btn btn-outline-primary btn_qr" value="{$value['id_ticket_virtual']}"><span class="fa fa-qrcode" style="padding: 0px;"> {$ticket_virtual[0]['clave']}</span></button-->
          </td>
        </tr>
html;
        }
        return $html;
    }

    public function getAllColaboradoresAsignadosByName($name){

        $html = "";
        foreach (GeneralDao::getAllColaboradoresByName($name) as $key => $value) {
            if ($value['alergia'] == '' && $value['alergia_cual'] == '') {
                $alergia = 'No registro alergias';
            } else {
                if ($value['alergia'] == 'otro') {
                    $alergia = $value['alergia_cual'];
                } else {
                    $alergia = $value['alergia'];
                }
            }

            if ($value['alergia_medicamento'] == 'si') {
                if ($value['alergia_medicamento_cual'] == '') {
                    $alergia_medicamento = 'No registro alergias a medicamentos';
                } else {
                    $alergia_medicamento = $value['alergia_medicamento_cual'];
                }
            } else {
                $alergia_medicamento = 'No posee ninguna alergia';
            }

            if ($value['restricciones_alimenticias'] == 'ninguna' || $value['restricciones_alimenticias'] == '') {
                $restricciones_alimenticias = 'No registro restricciones alimenticias';
            } else {
                if ($value['restricciones_alimenticias'] == 'otro') {
                    $restricciones_alimenticias = $value['restricciones_alimenticias_cual'];
                } else {
                    $restricciones_alimenticias = $value['restricciones_alimenticias'];
                }
            }

            $value['apellido_paterno'] = utf8_encode($value['apellido_paterno']);
            $value['apellido_materno'] = utf8_encode($value['apellido_materno']);
            $value['nombre'] = utf8_encode($value['nombre']);

            if (empty($value['img']) || $value['img'] == null) {
                $img_user = "/img/user.png";
            } else {
                $img_user = "https://registro.foromusa.com/img/users_musa/{$value['img']}";
            }

            $estatus = '';
            if ($value['status'] == 1) {
                $estatus .= <<<html
                <span class="badge badge-success">Activo</span>
html;
            } else {
                $estatus .= <<<html
                <span class="badge badge-success">Inactivo</span>
html;
            }

            // 6c5df2a1307bb58194383e7e79ac9414
            $pases = PasesDao::getByIdUser($value['utilerias_asistentes_id']);
            $cont_pase_ida = 0;
            $cont_pase_regreso = 0;
            foreach ($pases as $key => $pas) {

                if ($pases >= 1) {

                    if ($pas['tipo'] == 1) {
                        $cont_pase_ida++;

                        if ($pas['status'] == 1) {

                            $pase_ida = '<p class="text-sm font-weight-bold mb-0 " style="cursor: pointer;" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-bs-original-title="Documento validado"><span class="fa fa-plane-departure" style=" font-size: 13px;"></span> Regreso (<i class="fa fa-solid fa-check" style="color: green;"></i>)</p> ';
                        } else {
                            $pase_ida = '<p class="text-sm font-weight-bold mb-0 " style="cursor: pointer;" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-bs-original-title="Documento pendiente de validar"><span class="fa fa-plane-departure" style="font-size: 13px;"></span> Regreso (<i class="fa fa-solid fa-hourglass-end" style="color: #1a8fdd;"></i>)</p> ';
                        }
                    } elseif ($pas['tipo'] == 2) {
                        $cont_pase_regreso++;

                        if ($pas['status'] == 1) {

                            $pase_regreso = '<p class="text-sm font-weight-bold mb-0 " style="cursor: pointer;" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-bs-original-title="Documento validado"><span class="fa fa-plane-arrival" style=" font-size: 13px;"></span> Llegada (<i class="fa fa-solid fa-check" style="color: green;"></i>)</p>';
                        } else {
                            $pase_regreso = '<p class="text-sm font-weight-bold mb-0 " style="cursor: pointer;" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-bs-original-title="Documento pendiente de validar"><span class="fa fa-plane-arrival" style="font-size: 13px"></span> Llegada (<i class="fa fa-solid fa-hourglass-end" style="color: #1a8fdd;"></i>)</p>';
                        }
                    }
                }
            }

            if ($cont_pase_regreso <= 0) {
                $pase_regreso = '<p class="text-sm font-weight-bold mb-0 " style="cursor: pointer;" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-bs-original-title="Aún no se sube el documento"><span class="fa fa-plane-arrival" style="font-size: 13px"></span> Llegada (<i class="fas fa-times" style="color: #7B241C;"></i>)</p>';
            }

            if ($cont_pase_ida <= 0) {
                $pase_ida = '<p class="text-sm font-weight-bold mb-0 " style="cursor: pointer;"  data-bs-toggle="tooltip" data-bs-placement="top" title="" data-bs-original-title="Aún no se sube el documento"><span class="fa fa-plane-departure" style="font-size: 13px;"></span> Regreso (<i class="fas fa-times" style="color: #7B241C;"></i>)</p>';
            }

            $pruebacovid = PruebasCovidUsuariosDao::getByIdUser($value['utilerias_asistentes_id'])[0];

            if ($pruebacovid) {

                if ($pruebacovid['status'] == 1) {
                    $pru_covid = '<p class="text-sm font-weight-bold mb-0 " style="cursor: pointer;" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-bs-original-title="Documento validado"><span class="fa fas fa-virus" style="font-size: 13px;"></span> Prueba Covid (<i class="fas fa-times" style="color:#7B241C;"></i>)</p>';
                } else { 
                    if ($pruebacovid['status'] == 2) {
                        $pru_covid = '<p class="text-sm font-weight-bold mb-0 " style="cursor: pointer;" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-bs-original-title="Documento validado"><span class="fa fas fa-virus" style="font-size: 13px;"></span> Prueba Covid (<i class="fa fa-solid fa-check" style="color: green;"></i>)</p>';
                    } else {
                        $pru_covid = '<p class="text-sm font-weight-bold mb-0 " style="cursor: pointer;" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-bs-original-title="Documento pendiente de validar"><span class="fa fas fa-virus" style="font-size: 13px;"></span> Prueba Covid (<i class="fa fa-solid fa-hourglass-end" style="color: #1a8fdd;"></i>)</p>';
                    }
                }
            } else {
                $pru_covid = '<p class="text-sm font-weight-bold mb-0 " style="cursor: pointer;" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-bs-original-title="Aún no se sube el documento"><span class="fa fas fa-virus" style="font-size: 13px;"></span> Prueba Covid (<i class="fas fa-times" style="color:#7B241C;"></i>)</p>';
            }

            $comprobantecovid = ComprobantesVacunacionDao::getByIdUser($value['utilerias_asistentes_id'])[0];

            if ($comprobantecovid) {

                if ($comprobantecovid['validado'] == 1) {

                    $compro_covid = '<p class="text-sm font-weight-bold mb-0 " style="cursor: pointer;" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-bs-original-title="Documento validado"><span class="fa fa-file-text-o" style="font-size: 13px;"></span> Comprobante Covid (<i class="fa fa-solid fa-check" style="color: green;"></i>)</p>';
                } else {

                    $compro_covid = '<p class="text-sm font-weight-bold mb-0 " style="cursor: pointer;" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-bs-original-title="Documento pendiente de validar"><span class="fa fa-file-text-o" style="font-size: 13px;"></span> Comprobante Covid (<i class="fa fa-solid fa-hourglass-end" style="color:#1a8fdd;"></i>)</p>';
                }
            } else {
                $compro_covid = '<p class="text-sm font-weight-bold mb-0 " style="cursor: pointer;" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-bs-original-title="Aún no se sube el documento"><span class="fa fa-file-text-o" style="font-size: 13px;"></span> Comprobante Covid  (<i class="fas fa-times" style="color: #7B241C;" ></i>)</p>';
            }



            $html .= <<<html
            <tr>
                <td>
                    <div class="d-flex px-3 py-1">
                        <div>
                            <img src="{$img_user}" class="avatar me-3" alt="image">
                        </div>
                        <div class="d-flex flex-column justify-content-center text-black">
                    
                            <a href="/Asistentes/Detalles/{$value['clave']}" target="_blank">
                                <h6 class="mb-0 text-sm text-move text-black">
                                    <span class="fa fa-user-md" style="font-size: 13px"></span> {$value['nombre']} {$value['segundo_nombre']} {$value['apellido_paterno']} {$value['apellido_materno']} $estatus
                                    </h6>
                                </a>
                            <div class="d-flex flex-column justify-content-center">
                                <u><a  href="mailto:{$value['email']}"><h6 class="mb-0 text-sm text-black"><span class="fa fa-mail-bulk" style="font-size: 13px"></span> {$value['usuario']}</h6></a></u>
                                <u><a target="_blank" href="https://api.whatsapp.com/send?phone=52{$value['telefono']}&text=Buen%20d%C3%ADa,%20te%20contacto%20de%20parte%20del%20Equipo%20Grupo%20LAHE%20%F0%9F%98%80" target="_blank"><p class="text-sm text-morado-musa font-weight-bold text-secondary mb-0"><span class="fa fa-whatsapp" style="font-size: 13px; color:green;"></span> {$value['telefono']}</p></a></u>
                            </div>
                            <!--<p class="text-sm mb-0"><span class="fa fa-solid fa-id-card" style="font-size: 13px;"></span> Número de empleado:  <span style="text-decoration: underline;">{$value['numero_empleado']}</span></p>-->
                            <hr>
                            <!--<p class="text-sm font-weight-bold mb-0 "><span class="fa fas fa-user-tie" style="font-size: 13px;"></span><b> Ejecutivo Asignado a Línea: </b><br><span class="fas fa-suitcase"> </span> {$value['nombre_ejecutivo']} <span class="badge badge-success" style="background-color:  {$value['color']}; color:white "><strong>{$value['nombre_linea_ejecutivo']}</strong></span></p>-->
                            
                        </div>
                    </div>
                </td>
         
                <td style="text-align:left; vertical-align:middle;"> 
                    
                    <!--<p class="text-sm font-weight-bold mb-0 "><span class="fa fa-business-time" style="font-size: 13px;"></span><b> Bu: </b>{$value['nombre_bu']}</p>-->
                    <p class="text-sm font-weight-bold mb-0 "><span class="fa fa-pills" style="font-size: 13px;"></span><b> Linea Principal: </b>{$value['nombre_linea']}</p>
                    <!--<p class="text-sm font-weight-bold mb-0 "><span class="fa fa-hospital" style="font-size: 13px;"></span><b> Posición: </b>{$value['nombre_posicion']}</p>-->

                    <!--hr>
                    <p class="text-sm font-weight-bold mb-0 "><span class="fas fa-egg-fried" style="font-size: 13px;"></span><b> Restricciones alimenticias: </b>{$value['restricciones_alimenticias']}</p>-->
                    
                    <p class="text-sm font-weight-bold mb-0 "><span class="fas fa-allergies" style="font-size: 13px;"></span><b> Alergias: </b>{$value['alergia']}{$value['alergia_cual']} <br>
                    {$value['alergia_medicamento_cual']}</p>

                    <!-- <hr>
                    <p class="text-sm font-weight-bold mb-0 "><span class="fas fa-ban" style="font-size: 13px;"></span><b> Restricciones alimenticias: </b>{$restricciones_alimenticias}</p>
                    
                    <p class="text-sm font-weight-bold mb-0 "><span class="fas fa-allergies" style="font-size: 13px;"></span><b> Alergias:</b> {$alergia}

                    <p class="text-sm font-weight-bold mb-0 "><span class="fas fa-pills" style="font-size: 13px;"></span><b> Alergias a medicamentos:</b> {$alergia_medicamento}</p>-->

                </td>

        

          <td style="text-align:left; vertical-align:middle;"> 
            {$pase_ida}
            {$pase_regreso}
            {$ticket_v}
            {$pru_covid}
            {$compro_covid}
          </td>
          
          <td style="text-align:center; vertical-align:middle;">
            <a href="/RegistroAsistencia/abrirpdfGafete/{$value['clave']}/{$value['ticket_virtual']}" class="btn bg-pink btn-icon-only morado-musa-text" title="Imprimir Gafetes" data-bs-placement="top" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="Imprimir Gafetes" target="_blank"><i class="fas fa-print"> </i></a>     

            <button class="btn bg-turquoise btn-icon-only text-white" data-toggle="modal" data-target="#modal-etiquetas-{$value['id_registro_acceso']}" id="btn-etiqueta-{$value['id_registro_acceso']}" data-bs-toggle="tooltip" data-bs-placement="left" data-bs-original-title="Imprimir Etiquetas" title="Imprimir Etiquetas"><i class="fas fa-tag"></i></button>
            
            <!--button type="button" class="btn btn-outline-primary btn_qr" value="{$value['id_ticket_virtual']}"><span class="fa fa-qrcode" style="padding: 0px;"> {$ticket_virtual[0]['clave']}</span></button-->
          </td>
        </tr>
html;
        }
       
        return $html;
    }

    public function generarModal($datos){
        $modal = <<<html
            <div class="modal fade" id="modal-etiquetas-{$datos['id_registro_acceso']}" role="dialog" aria-labelledby="" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modal-ver-pdf-Label">Etiquetas para {$datos['nombre']} {$datos['segundo_nombre']} {$datos['apellido_paterno']} {$datos['apellido_materno']} - {$datos['id_registro_acceso']}</h5>
                            <button type="button" class="btn btn-danger" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <input hidden id="id_registro_acceso" name="id_registro_acceso" type="text" value="{$datos['id_registro_acceso']}" readonly>
                            <div class="row">
                                <!--form action="" id="form_etiquetas"-->
                                    <div class="row">
                                    
                                        <script>
                                        $(document).ready(function() {
                                            

                                            $('#btn_imprimir_etiquetas_{$datos['id_registro_acceso']}').on("click", function(event) {
                                                no_habitacion_{$datos['id_registro_acceso']} = $("#no_habitacion_{$datos['id_registro_acceso']}").val();
                                                clave_ra_{$datos['id_registro_acceso']} = $("#clave_ra_{$datos['id_registro_acceso']}").val();
                                                no_etiquetas_{$datos['id_registro_acceso']} = $("#no_etiquetas_{$datos['id_registro_acceso']}").val();

                                                console.log(no_habitacion_{$datos['id_registro_acceso']});
                                                console.log(no_etiquetas_{$datos['id_registro_acceso']});
                                                console.log(clave_ra_{$datos['id_registro_acceso']});
                                                $('#btn_imprimir_etiquetas_{$datos['id_registro_acceso']}').attr("href", "/Asistentes/abrirpdf/" + clave_ra_{$datos['id_registro_acceso']} + "/" + no_etiquetas_{$datos['id_registro_acceso']} + "/" + no_habitacion_{$datos['id_registro_acceso']});
                                            });
                                        });
                                        </script>

                                        <div class="col-md-12">
                                            <input type="hidden" id="clave_ra_{$datos['id_registro_acceso']}" name="clave_ra_{$datos['id_registro_acceso']}" value="{$datos['clave']}" readonly>
                                        </div>

                                        <div class="col-md-6">
                                            <label>Número de Habitación</label>
                                            <input type="number" id="no_habitacion_{$datos['id_registro_acceso']}" name="no_habitacion_{$datos['id_registro_acceso']}" class="form-control">
                                        </div>

                                        <div class="col-md-6">
                                            <label>Número de etiquetas</label>
                                            <input type="number" id="no_etiquetas_{$datos['id_registro_acceso']}" name="no_etiquetas_{$datos['id_registro_acceso']}" class="form-control">
                                        </div>

                                        <div class="col-md-3 m-auto">
                                            <a href="" id="btn_imprimir_etiquetas_{$datos['id_registro_acceso']}" target="_blank" class="btn btn-info mt-4" type="submit">Imprimir Etiquetas</a>
                                        </div>
                                    </div>
                                <!--/form-->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
html;

        return $modal;
    }

    public function getComprobanteVacunacionById($id)
    {

        $comprobantes = ComprobantesVacunacionDao::getComprobateByClaveUser($id);
        $tabla = '';
        foreach ($comprobantes as $key => $value) {

            $tabla .= <<<html
        <tr>
          <td class="text-center">
            <span class="badge badge-success"><i class="fas fa-check"> </i> Aprobado</span> <br>
            <span class="badge badge-secondary">Folio <i class="fas fa-hashtag"> </i> {$value['id_c_v']}</span>
             <hr>
             <!--<p class="text-sm font-weight-bold mb-0 "><span class="fa fas fa-user-tie" style="font-size: 13px;"></span><b> Ejecutivo Asignado a Línea: </b><br><span class="fas fa-suitcase"> </span> {$value['nombre_ejecutivo']} <span class="badge badge-success" style="background-color:  {$value['color']}; color:white "><strong>{$value['nombre_linea_ejecutivo']}</strong></span></p>-->
                      
          </td>
          <td>
            <h6 class="mb-0 text-sm"> <span class="fas fa-user-md"> </span>  {$value['nombre_completo']}</h6>
            <!--<p class="text-sm font-weight-bold mb-0 "><span class="fa fa-business-time" style="font-size: 13px;"></span><b> Bu: </b>{$value['nombre_bu']}</p>-->
              <p class="text-sm font-weight-bold mb-0 "><span class="fa fa-pills" style="font-size: 13px;"></span><b> Linea Principal: </b>{$value['nombre_linea']}</p>
              <!--<p class="text-sm font-weight-bold mb-0 "><span class="fa fa-hospital" style="font-size: 13px;"></span><b> Posición: </b>{$value['nombre_posicion']}</p>-->

            <hr>

              <!--p class="text-sm font-weight-bold mb-0 "><span class="fa fas fa-user-tie" style="font-size: 13px;"></span><b> Ejecutivo Asignado a Línea: </b><br></p-->

              <!--p class="text-sm font-weight-bold mb-0 "><span class="fa fa-whatsapp" style="font-size: 13px; color:green;"></span><b> </b>{$value['telefono']}</p>
              <p class="text-sm font-weight-bold mb-0 "><span class="fa fa-mail-bulk" style="font-size: 13px;"></span><b>  </b><a "mailto:{$value['email']}">{$value['email']}</a></p-->

              <div class="d-flex flex-column justify-content-center">
                  <u><a href="mailto:{$value['email']}"><h6 class="mb-0 text-sm"><span class="fa fa-mail-bulk" style="font-size: 13px"></span> {$value['email']}</h6></a></u>
                  <u><a href="https://api.whatsapp.com/send?phone=52{$value['telefono']}&text=Buen%20d%C3%ADa,%20te%20contacto%20de%20parte%20del%20Equipo%20Grupo%20LAHE%20%F0%9F%98%80" target="_blank"><p class="text-sm font-weight-bold text-secondary mb-0"><span class="fa fa-whatsapp" style="font-size: 13px; color:green;"></span> {$value['telefono']}</p></a></u>
              </div>
          </td>
          <td>
            <p class="text-center" style="font-size: small;"><span class="fa fa-calendar-check-o" style="font-size: 13px;"></span> Fecha Carga: {$value['fecha_carga_documento']}</p>
            <p class="text-center" style="font-size: small;"><span class="fa fa-syringe" style="font-size: 13px;"></span> # Dosis: {$value['numero_dosis']}</p>
            <p class="text-center" style="font-size: small;"><span class="fa fa-cubes" style="font-size: 13px;"></span> <strong>Marca: {$value['marca_dosis']}</strong></p>
          </td>
          <td class="text-center">
            <button type="button" class="btn bg-gradient-primary btn_iframe" data-document="{$value['documento']}" data-toggle="modal" data-target="#ver-documento-{$value['id_c_v']}">
              <i class="fas fa-eye"></i>
            </button>
          </td>
        </tr>

        <div class="modal fade" id="ver-documento-{$value['id_c_v']}" tabindex="-1" role="dialog" aria-labelledby="ver-documento-{$value['id_c_v']}" aria-hidden="true">
          <div class="modal-dialog" role="document" style="max-width: 1000px;">
            <div class="modal-content">
              <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">Comprobante de Vacunación</h5>
                  <span type="button" class="btn btn-danger" data-dismiss="modal" aria-label="Close">
                      X
                  </span>
              </div>
              <div class="modal-body bg-gray-200">
                <div class="row">
                  <div class="col-md-8 col-12">
                    <div class="card card-body mb-4 iframe">
                      <!--<iframe src="https://registro.foromusa.com/comprobante_vacunacion/{$value['documento']}" style="width:100%; height:700px;" frameborder="0" >
                      </iframe>-->
                    </div>
                  </div>
                  <div class="col-md-4 col-12">
                    <div class="card card-body mb-4">
                      <h5>Datos Personales</h5>
                      <div class="mb-2">
                        <h6 class="fas fa-user"> </h6>
                        <span> <b>Nombre:</b> {$value['nombre_completo']}</span>
                        <span class="badge badge-success">Aprobado</span>
                      </div>
                      <!-- <div class="mb-2">
                        <h6 class="fas fa-address-card"> </h6>
                        <span> <b>Número de empleado:</b> {$value['numero_empleado']}</span>
                      </div>
                      <div class="mb-2">
                        <h6 class="fas fa-business-time"> </h6>
                        <span> <b>Bu:</b> {$value['nombre_bu']}</span>
                      </div>-->
                      <div class="mb-2">
                        <h6 class="fas fa-pills"> </h6>
                        <span> <b>Línea:</b> {$value['nombre_linea']}</span>
                      </div>
                      <!--<div class="mb-2">
                        <h6 class="fas fa-hospital"> </h6>
                        <span> <b>Posición:</b> {$value['nombre_posicion']}</span>
                      </div>-->
                      <div class="mb-2">
                        <h6 class="fa fa-mail-bulk"> </h6>
                        <span> <b>Correo Electrónico:</b> <u><a href="mailto:{$value['email']}">{$value['email']}</a></u></span>
                      </div>
                      <div class="mb-2">
                      <h6 class="fa fa-whatsapp" style="font-size: 13px; color:green;"> </h6>
                      <span> <b></b> <u><a href="https://api.whatsapp.com/send?phone=52{$value['telefono']}&text=Buen%20d%C3%ADa,%20te%20contacto%20de%20parte%20del%20Equipo%20Grupo%20LAHE%20%F0%9F%98%80" target="_blank">{$value['telefono']}</a></u></span>
                      </div>
                    </div>
                    <div class="card card-body mb-4">
                      <h5>Datos del Comprobante</h5>
                      <div class="mb-2">
                        <h6 class="fas fa-calendar"> </h6>
                        <span> <b>Fecha de alta:</b> {$value['fecha_carga_documento']}</span>
                      </div>
                      <div class="mb-2">
                        <h6 class="fas fa-hashtag"> </h6>
                        <span> <b>Número de Dósis:</b> {$value['numero_dosis']}</span>
                      </div>
                      <div class="mb-2">
                        <h6 class="fas fa-syringe"> </h6>
                        <span> <b>Marca:</b> {$value['marca_dosis']}</span>
                      </div>
                    </div>
                    <div class="card card-body">
                      <h5>Notas</h5>
html;

            if ($value['nota'] != '') {
                $tabla .= <<<html
                      <div class="editar_section" id="editar_section">
                        <p id="">
                          {$value['nota']}
                        </p>
                        <button id="editar_nota" type="button" class="btn bg-gradient-primary w-50 editar_nota" >
                          Editar
                        </button>
                      </div>

                      <div class="hide-section editar_section_textarea" id="editar_section_textarea">
                        <form class="form-horizontal guardar_nota" id="guardar_nota" action="" method="POST">
                          <input type="text" id="id_comprobante_vacuna" name="id_comprobante_vacuna" value="{$value['id_c_v']}" readonly style="display:none;"> 
                          <p>
                            <textarea class="form-control" name="nota" id="nota" placeholder="Agregar notas sobre la respuesta de la validación del documento" required> {$value['nota']} </textarea>
                          </p>
                          <div class="row">
                            <div class="col-md-6 col-12">
                            <button type="submit" id="guardar_editar_nota" class="btn bg-gradient-dark guardar_editar_nota" >
                              Guardar
                            </button>
                            </div>
                            <div class="col-md-6 col-12">
                              <button type="button" id="cancelar_editar_nota" class="btn bg-gradient-danger cancelar_editar_nota" >
                                Cancelar
                              </button>
                            </div>
                          </div>
                        </form>
                      </div>
html;
            } else {
                $tabla .= <<<html
                      <p>
                        {$value['nota']}
                      </p>
                      <form class="form-horizontal guardar_nota" id="guardar_nota" action="" method="POST">
                        <input type="text" id="id_comprobante_vacuna" name="id_comprobante_vacuna" value="{$value['id_c_v']}" readonly style="display:none;"> 
                        <p>
                          <textarea class="form-control" name="nota" id="nota" placeholder="Agregar notas sobre la respuesta de la validación del documento" required></textarea>
                        </p>
                        <button type="submit" class="btn bg-gradient-dark w-50" >
                          Guardar
                        </button>
                      </form>
html;
            }
            $tabla .= <<<html
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
html;
        }


        return $tabla;
    }

    public function getPruebasCovidById($id)
    {
        $pruebas = PruebasCovidUsuariosDao::getComprobateByIdUser($id);
        $tabla = '';
        foreach ($pruebas as $key => $value) {
            $tabla .= <<<html
        <tr>
          <td class="text-center">
            <span class="badge badge-success"><i class="fas fa-check"></i> Aprobada</span> <br>
            <span class="badge badge-secondary">Folio <i class="fas fa-hashtag"> </i> {$value['id_c_v']}</span>
            <hr>
            <!--<p class="text-sm font-weight-bold mb-0 "><span class="fa fas fa-user-tie" style="font-size: 13px;"></span><b> Ejecutivo Asignado a Línea: </b><br><span class="fas fa-suitcase"> </span> {$value['nombre_ejecutivo']} <span class="badge badge-success" style="background-color:  {$value['color']}; color:white "><strong>{$value['nombre_linea_ejecutivo']}</strong></span></p>-->
          </td>
          <td>
            <h6 class="mb-0 text-sm"> <span class="fas fa-user-md"> </span>  {$value['nombre_completo']}</h6>
            <!--<p class="text-sm font-weight-bold mb-0 "><span class="fa fa-business-time" style="font-size: 13px;"></span><b> Bu: </b>{$value['nombre_bu']}</p>-->
              <p class="text-sm font-weight-bold mb-0 "><span class="fa fa-pills" style="font-size: 13px;"></span><b> Linea Principal: </b>{$value['nombre_linea']}</p>
              <!--<p class="text-sm font-weight-bold mb-0 "><span class="fa fa-hospital" style="font-size: 13px;"></span><b> Posición: </b>{$value['nombre_posicion']}</p>-->

            <hr>

              <!--p class="text-sm font-weight-bold mb-0 "><span class="fa fas fa-user-tie" style="font-size: 13px;"></span><b> Ejecutivo Asignado a Línea: </b><br></p-->

              <!--p class="text-sm font-weight-bold mb-0 "><span class="fa fa-whatsapp" style="font-size: 13px; color:green;"></span><b> </b>{$value['telefono']}</p>
              <p class="text-sm font-weight-bold mb-0 "><span class="fa fa-mail-bulk" style="font-size: 13px;"></span><b>  </b><a "mailto:{$value['email']}">{$value['email']}</a></p-->

              <div class="d-flex flex-column justify-content-center">
                  <u><a href="mailto:{$value['email']}"><h6 class="mb-0 text-sm"><span class="fa fa-mail-bulk" style="font-size: 13px"></span> {$value['email']}</h6></a></u>
                  <u><a href="https://api.whatsapp.com/send?phone=52{$value['telefono']}&text=Buen%20d%C3%ADa,%20te%20contacto%20de%20parte%20del%20Equipo%20Grupo%20LAHE%20%F0%9F%98%80" target="_blank"><p class="text-sm font-weight-bold text-secondary mb-0"><span class="fa fa-whatsapp" style="font-size: 13px; color:green;"></span> {$value['telefono']}</p></a></u>
              </div>
          </td>
          <td>
            <p class="text-center" style="font-size: small;">{$value['fecha_carga_documento']}</p>
          </td>
          <td>
            <p class="text-center" style="font-size: small;">{$value['tipo_prueba']}</p>
          </td>
          <td>
            <p class="text-center" style="font-size: small;">{$value['resultado']}</p>
          </td>
          <td class="text-center">
            <button type="button" class="btn bg-gradient-primary btn_iframe_pruebas_covid" data-document="{$value['documento']}" data-toggle="modal" data-target="#ver-documento-{$value['id_c_v']}">
              <i class="fas fa-eye"></i>
            </button>
          </td>
        </tr>

        <div class="modal fade" id="ver-documento-{$value['id_c_v']}" tabindex="-1" role="dialog" aria-labelledby="ver-documento-{$value['id_c_v']}" aria-hidden="true">
          <div class="modal-dialog" role="document" style="max-width: 1000px;">
              <div class="modal-content">
                  <div class="modal-header">
                      <h5 class="modal-title" id="exampleModalLabel">Documento Prueba SARS-CoV-2</h5>
                      <span type="button" class="btn btn-danger" data-dismiss="modal" aria-label="Close">
                          X
                      </span>
                  </div>
                  <div class="modal-body bg-gray-200">
                    <div class="row">
                      <div class="col-md-8 col-12">
                        <div class="card card-body mb-4 iframe">
                          <!--<iframe src="/PDF/{$value['documento']}" style="width:100%; height:700px;" frameborder="0" >
                          </iframe>-->
                        </div>
                      </div>
                      <div class="col-md-4 col-12">
                        <div class="card card-body mb-4">
                          <h5>Datos Personales</h5>
                          <div class="mb-2">
                            <h6 class="fas fa-user"> </h6>
                            <span> <b>Nombre:</b> {$value['nombre_completo']}</span>
                            <span class="badge badge-success">Aprobado</span>
                          </div>
                          <!--<div class="mb-2">
                            <h6 class="fas fa-address-card"> </h6>
                            <span> <b>Número de empleado:</b> {$value['numero_empleado']}</span>
                          </div>
                          <div class="mb-2">
                            <h6 class="fas fa-business-time"> </h6>
                            <span> <b>Bu:</b> {$value['nombre_bu']}</span>
                          </div>-->
                          <div class="mb-2">
                            <h6 class="fas fa-pills"> </h6>
                            <span> <b>Línea:</b> {$value['nombre_linea']}</span>
                          </div>
                          <!--<div class="mb-2">
                            <h6 class="fas fa-hospital"> </h6>
                            <span> <b>Posición:</b> {$value['nombre_posicion']}</span>
                          </div>-->
                          <div class="mb-2">
                            <h6 class="fa fa-mail-bulk"> </h6>
                            <span> <b>Correo Electrónico:</b> <u><a href="mailto:{$value['email']}">{$value['email']}</a></u></span>
                          </div>
                          <div class="mb-2">
                            <h6 class="fa fa-whatsapp" style="font-size: 13px; color:green;"> </h6>
                            <span> <b></b> <u><a href="https://api.whatsapp.com/send?phone=52{$value['telefono']}&text=Buen%20d%C3%ADa,%20te%20contacto%20de%20parte%20del%20Equipo%20Grupo%20LAHE%20%F0%9F%98%80" target="_blank">{$value['telefono']}</a></u></span>
                          </div>
                        </div>
                        <div class="card card-body mb-4">
                          <h5>Datos de la Prueba</h5>
                          <div class="mb-2">
                            <h6 class="fas fa-calendar"> </h6>
                            <span> <b>Fecha de alta:</b> {$value['fecha_carga_documento']}</span>
                          </div>
                          <div class="mb-2">
                            <h6 class="fas fa-hashtag"> </h6>
                            <span> <b>Resultado:</b> {$value['resultado']}</span>
                          </div>
                          <div class="mb-2">
                            <h6 class="fas fa-syringe"> </h6>
                            <span> <b>Tipo de prueba:</b> {$value['tipo_prueba']}</span>
                          </div>
                        </div>
                        <div class="card card-body">
                          <h5>Notas</h5>
                          
html;
            if ($value['nota'] != '') {
                $tabla .= <<<html
                          <div class="editar_section" id="editar_section">
                            <p id="">
                              {$value['nota']}
                            </p>
                            <button id="editar_nota" type="button" class="btn bg-gradient-primary w-50 editar_nota" >
                              Editar
                            </button>
                          </div>

                          <div class="hide-section editar_section_textarea" id="editar_section_textarea">
                            <form class="form-horizontal guardar_nota" id="guardar_nota" action="" method="POST">
                              <input type="text" id="id_prueba_covid" name="id_prueba_covid" value="{$value['id_c_v']}" readonly style="display:none;"> 
                              <p>
                                <textarea class="form-control nota" name="nota" id="nota" placeholder="Agregar notas sobre la respuesta de la validación del documento" required> {$value['nota']} </textarea>
                              </p>
                              <div class="row">
                                <div class="col-md-6 col-12">
                                <button type="submit" id="guardar_editar_nota" class="btn bg-gradient-dark guardar_editar_nota" >
                                  Guardar
                                </button>
                                </div>
                                <div class="col-md-6 col-12">
                                  <button type="button" id="cancelar_editar_nota" class="btn bg-gradient-danger cancelar_editar_nota" >
                                    Cancelar
                                  </button>
                                </div>
                              </div>
                            </form>
                          </div>
html;
            } else {
                $tabla .= <<<html
                          <p>
                            {$value['nota']}
                          </p>
                          <form class="form-horizontal guardar_nota" id="guardar_nota" action="" method="POST">
                            <input type="text" id="id_prueba_covid" name="id_prueba_covid" value="{$value['id_c_v']}" readonly style="display:none;"> 
                            <p>
                              <textarea class="form-control nota" name="nota" id="nota" placeholder="Agregar notas sobre la respuesta de la validación del documento" required></textarea>
                            </p>
                            <button type="submit" class="btn bg-gradient-dark w-50" >
                              Guardar
                            </button>
                          </form>
html;
            }
            $tabla .= <<<html
                        </div>
                      </div>
                    </div>
                  </div>
              </div>
          </div>
        </div>
html;
        }


        return $tabla;
    }

    public function getAsistentesFaltantes()
    {

        $html = "";
        foreach (GeneralDao::getAsistentesFaltantes() as $key => $value) {


            $img_user = "/img/user.png";

            $value['apellido_paterno'] = utf8_encode($value['apellido_paterno']);
            $value['apellido_materno'] = utf8_encode($value['apellido_materno']);
            $value['nombre'] = utf8_encode($value['nombre']);



            $html .= <<<html
            <tr>
                <td>                    
                    <h6 class="mb-0 text-sm"><span class="fa fa-user-md" style="font-size: 13px"></span> {$value['nombre']} {$value['segundo_nombre']} {$value['apellido_paterno']} {$value['apellido_materno']}</h6>
                </td>
                <td>
                    <h6 class="mb-0 text-sm"><span class="fa fa-mail-bulk" style="font-size: 13px" aria-hidden="true"></span> {$value['email']}</h6>
                </td>
                <td>
                    <u><a href="https://api.whatsapp.com/send?phone=52{$value['telefono']}&text=Buen%20d%C3%ADa,%20te%20contacto%20de%20parte%20del%20Equipo%20Grupo%20LAHE%20%F0%9F%98%80" target="_blank"><p class="text-sm font-weight-bold text-secondary mb-0"><span class="fa fa-whatsapp" style="font-size: 13px; color:green;"></span> {$value['telefono']}</p></a></u>
                </td>
        </tr>
html;
        }
        return $html;
    }


    function generateRandomString($length = 6)
    {
        return substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, $length);
    }

    public function abrirpdf($clave, $noPages = null, $no_habitacion)
    {
        $datos_user = AsistentesDao::getRegistroAccesoByClaveRA($clave)[0];
        $nombre_completo = $datos_user['nombre'] . " " . $datos_user['segundo_nombre'] . " " . $datos_user['apellido_paterno'] . " " . $datos_user['apellido_materno'];
        //$nombre_completo = utf8_decode($_POST['nombre']);
        //$datos_user['numero_habitacion']
        


        $pdf = new \FPDF($orientation = 'L', $unit = 'mm', array(37, 155));

        for ($i = 1; $i <= $noPages; $i++) {


            $pdf->AddPage();
            $pdf->SetFont('Arial', 'B', 5);    //Letra Arial, negrita (Bold), tam. 20
            $textypos = 5;
            $pdf->setY(2);

            $pdf->Image('https://registro.foromusa.com/assets/pdf/iMAGEN_aso.png', 1, 0, 150, 40);
            $pdf->SetFont('Arial', '', 5);    //Letra Arial, negrita (Bold), tam. 20

            $pdf->SetXY(8.3, 9);
            $pdf->SetFont('Times', 'B', 10);
            #4D9A9B
            $pdf->SetTextColor(0, 0, 0);
            $pdf->Multicell(120, 4.2, $nombre_completo . utf8_decode(" #habitación"). " - " . $no_habitacion, 0, 'C');
 
            $textypos += 6;
            $pdf->setX(2);

            $textypos += 6;
        }

        $pdf->Output();
       
    }
}

class PHPQRCode
{ // class start

    /** Configuración predeterminada */
    private $_config = array(
        'ecc' => 'H',                       // Calidad del código QR L-menor, M, Q, H-mejor
        'size' => 15,                       // Tamaño del código QR 1-50
        'dest_file' => '',        // Ruta de código QR creada
        'quality' => 100,                    // Calidad de imagen
        'logo' => '',                       // Ruta del logotipo, vacío significa que no hay logotipo
        'logo_size' => null,                // tamaño del logotipo, nulo significa que se calcula automáticamente de acuerdo con el tamaño del código QR
        'logo_outline_size' => null,        // Tamaño del trazo del logotipo, nulo significa que se calculará automáticamente de acuerdo con el tamaño del logotipo
        'logo_outline_color' => '#FFFFFF',  // color del trazo del logo
        'logo_opacity' => 100,              // opacidad del logo 0-100
        'logo_radius' => 0,                 // ángulo de empalme del logo 0-30
    );


    public function set_config($config)
    {

        // Permitir configurar la configuración
        $config_keys = array_keys($this->_config);

        // Obtenga la configuración entrante y escriba la configuración
        foreach ($config_keys as $k => $v) {
            if (isset($config[$v])) {
                $this->_config[$v] = $config[$v];
            }
        }
    }

    /**
     * Crea un código QR
     * @param    Contenido del código QR String $ data
     * @return String
     */
    public function generate($data)
    {

        // Crea una imagen de código QR temporal
        $tmp_qrcode_file = $this->create_qrcode($data);

        // Combinar la imagen del código QR temporal y la imagen del logotipo
        $this->add_logo($tmp_qrcode_file);

        // Eliminar la imagen del código QR temporal
        if ($tmp_qrcode_file != '' && file_exists($tmp_qrcode_file)) {
            unlink($tmp_qrcode_file);
        }

        return file_exists($this->_config['dest_file']) ? $this->_config['dest_file'] : '';
    }

    /**
     * Crea una imagen de código QR temporal
     * @param    Contenido del código QR String $ data
     * @return String
     */
    private function create_qrcode($data)
    {

        // Imagen de código QR temporal
        $tmp_qrcode_file = dirname(__FILE__) . '/tmp_qrcode_' . time() . mt_rand(100, 999) . '.png';

        // Crea un código QR temporal
        \QRcode::png($data, $tmp_qrcode_file, $this->_config['ecc'], $this->_config['size'], 2);

        // Regresar a la ruta temporal del código QR
        return file_exists($tmp_qrcode_file) ? $tmp_qrcode_file : '';
    }

    /**
     * Combinar imágenes de códigos QR temporales e imágenes de logotipos
     * @param  String $ tmp_qrcode_file Imagen de código QR temporal
     */
    private function add_logo($tmp_qrcode_file)
    {

        // Crear carpeta de destino
        $this->create_dirs(dirname($this->_config['dest_file']));

        // Obtener el tipo de imagen de destino
        $dest_ext = $this->get_file_ext($this->_config['dest_file']);

        // Necesito agregar logo
        if (file_exists($this->_config['logo'])) {

            // Crear objeto de imagen de código QR temporal
            $tmp_qrcode_img = imagecreatefrompng($tmp_qrcode_file);

            // Obtener el tamaño de la imagen del código QR temporal
            list($qrcode_w, $qrcode_h, $qrcode_type) = getimagesize($tmp_qrcode_file);

            // Obtener el tamaño y el tipo de la imagen del logotipo
            list($logo_w, $logo_h, $logo_type) = getimagesize($this->_config['logo']);

            // Crea un objeto de imagen de logo
            switch ($logo_type) {
                case 1:
                    $logo_img = imagecreatefromgif($this->_config['logo']);
                    break;
                case 2:
                    $logo_img = imagecreatefromjpeg($this->_config['logo']);
                    break;
                case 3:
                    $logo_img = imagecreatefrompng($this->_config['logo']);
                    break;
                default:
                    return '';
            }

            // Establezca el tamaño combinado de la imagen del logotipo, si no se establece, se calculará automáticamente de acuerdo con la proporción
            $new_logo_w = isset($this->_config['logo_size']) ? $this->_config['logo_size'] : (int)($qrcode_w / 5);
            $new_logo_h = isset($this->_config['logo_size']) ? $this->_config['logo_size'] : (int)($qrcode_h / 5);

            // Ajusta la imagen del logo según el tamaño establecido
            $new_logo_img = imagecreatetruecolor($new_logo_w, $new_logo_h);
            imagecopyresampled($new_logo_img, $logo_img, 0, 0, 0, 0, $new_logo_w, $new_logo_h, $logo_w, $logo_h);

            // Determinar si se necesita un golpe
            if (!isset($this->_config['logo_outline_size']) || $this->_config['logo_outline_size'] > 0) {
                list($new_logo_img, $new_logo_w, $new_logo_h) = $this->image_outline($new_logo_img);
            }

            // Determine si se necesitan esquinas redondeadas
            if ($this->_config['logo_radius'] > 0) {
                $new_logo_img = $this->image_fillet($new_logo_img);
            }

            // Combinar logotipo y código QR temporal
            $pos_x = ($qrcode_w - $new_logo_w) / 2;
            $pos_y = ($qrcode_h - $new_logo_h) / 2;

            imagealphablending($tmp_qrcode_img, true);

            // Combinar las imágenes y mantener su transparencia
            $dest_img = $this->imagecopymerge_alpha($tmp_qrcode_img, $new_logo_img, $pos_x, $pos_y, 0, 0, $new_logo_w, $new_logo_h, $this->_config['logo_opacity']);

            // Generar imagen
            switch ($dest_ext) {
                case 1:
                    imagegif($dest_img, $this->_config['dest_file'], $this->_config['quality']);
                    break;
                case 2:
                    imagejpeg($dest_img, $this->_config['dest_file'], $this->_config['quality']);
                    break;
                case 3:
                    imagepng($dest_img, $this->_config['dest_file'], (int)(($this->_config['quality'] - 1) / 10));
                    break;
            }

            // No es necesario agregar logo
        } else {

            $dest_img = imagecreatefrompng($tmp_qrcode_file);

            // Generar imagen
            switch ($dest_ext) {
                case 1:
                    imagegif($dest_img, $this->_config['dest_file'], $this->_config['quality']);
                    break;
                case 2:
                    imagejpeg($dest_img, $this->_config['dest_file'], $this->_config['quality']);
                    break;
                case 3:
                    imagepng($dest_img, $this->_config['dest_file'], (int)(($this->_config['quality'] - 1) / 10));
                    break;
            }
        }
    }

    /**
     * Acaricia el objeto de la imagen
     * @param    Objeto de imagen Obj $ img
     * @return Array
     */
    private function image_outline($img)
    {

        // Obtener ancho y alto de la imagen
        $img_w = imagesx($img);
        $img_h = imagesy($img);

        // Calcula el tamaño del trazo, si no está configurado, se calculará automáticamente de acuerdo con la proporción
        $bg_w = isset($this->_config['logo_outline_size']) ? intval($img_w + $this->_config['logo_outline_size']) : $img_w + (int)($img_w / 5);
        $bg_h = isset($this->_config['logo_outline_size']) ? intval($img_h + $this->_config['logo_outline_size']) : $img_h + (int)($img_h / 5);

        // Crea un objeto de mapa base
        $bg_img = imagecreatetruecolor($bg_w, $bg_h);

        // Establecer el color del mapa base
        $rgb = $this->hex2rgb($this->_config['logo_outline_color']);
        $bgcolor = imagecolorallocate($bg_img, $rgb['r'], $rgb['g'], $rgb['b']);

        // Rellena el color del mapa base
        imagefill($bg_img, 0, 0, $bgcolor);

        // Combina la imagen y el mapa base para lograr el efecto de trazo
        imagecopy($bg_img, $img, (int)(($bg_w - $img_w) / 2), (int)(($bg_h - $img_h) / 2), 0, 0, $img_w, $img_h);

        $img = $bg_img;

        return array($img, $bg_w, $bg_h);
    }


    private function image_fillet($img)
    {

        // Obtener ancho y alto de la imagen
        $img_w = imagesx($img);
        $img_h = imagesy($img);

        // Crea un objeto de imagen con esquinas redondeadas
        $new_img = imagecreatetruecolor($img_w, $img_h);

        // guarda el canal transparente
        imagesavealpha($new_img, true);

        // Rellena la imagen con esquinas redondeadas
        $bg = imagecolorallocatealpha($new_img, 255, 255, 255, 127);
        imagefill($new_img, 0, 0, $bg);

        // Radio de redondeo
        $r = $this->_config['logo_radius'];

        // Realizar procesamiento de esquinas redondeadas
        for ($x = 0; $x < $img_w; $x++) {
            for ($y = 0; $y < $img_h; $y++) {
                $rgb = imagecolorat($img, $x, $y);

                // No en las cuatro esquinas de la imagen, dibuja directamente
                if (($x >= $r && $x <= ($img_w - $r)) || ($y >= $r && $y <= ($img_h - $r))) {
                    imagesetpixel($new_img, $x, $y, $rgb);

                    // En las cuatro esquinas de la imagen, elige dibujar
                } else {
                    // arriba a la izquierda
                    $ox = $r; // centro x coordenada
                    $oy = $r; // centro coordenada y
                    if ((($x - $ox) * ($x - $ox) + ($y - $oy) * ($y - $oy)) <= ($r * $r)) {
                        imagesetpixel($new_img, $x, $y, $rgb);
                    }

                    // parte superior derecha
                    $ox = $img_w - $r; // centro x coordenada
                    $oy = $r;        // centro coordenada y
                    if ((($x - $ox) * ($x - $ox) + ($y - $oy) * ($y - $oy)) <= ($r * $r)) {
                        imagesetpixel($new_img, $x, $y, $rgb);
                    }

                    // abajo a la izquierda
                    $ox = $r;        // centro x coordenada
                    $oy = $img_h - $r; // centro coordenada y
                    if ((($x - $ox) * ($x - $ox) + ($y - $oy) * ($y - $oy)) <= ($r * $r)) {
                        imagesetpixel($new_img, $x, $y, $rgb);
                    }

                    // abajo a la derecha
                    $ox = $img_w - $r; // centro x coordenada
                    $oy = $img_h - $r; // centro coordenada y
                    if ((($x - $ox) * ($x - $ox) + ($y - $oy) * ($y - $oy)) <= ($r * $r)) {
                        imagesetpixel($new_img, $x, $y, $rgb);
                    }
                }
            }
        }

        return $new_img;
    }

    // Combinar las imágenes y mantener su transparencia
    private function imagecopymerge_alpha($dest_img, $src_img, $pos_x, $pos_y, $src_x, $src_y, $src_w, $src_h, $opacity)
    {

        $w = imagesx($src_img);
        $h = imagesy($src_img);

        $tmp_img = imagecreatetruecolor($src_w, $src_h);

        imagecopy($tmp_img, $dest_img, 0, 0, $pos_x, $pos_y, $src_w, $src_h);
        imagecopy($tmp_img, $src_img, 0, 0, $src_x, $src_y, $src_w, $src_h);
        imagecopymerge($dest_img, $tmp_img, $pos_x, $pos_y, $src_x, $src_y, $src_w, $src_h, $opacity);

        return $dest_img;
    }


    private function create_dirs($path)
    {

        if (!is_dir($path)) {
            return mkdir($path, 0777, true);
        }

        return true;
    }


    private function hex2rgb($hexcolor)
    {
        $color = str_replace('#', '', $hexcolor);
        if (strlen($color) > 3) {
            $rgb = array(
                'r' => hexdec(substr($color, 0, 2)),
                'g' => hexdec(substr($color, 2, 2)),
                'b' => hexdec(substr($color, 4, 2))
            );
        } else {
            $r = substr($color, 0, 1) . substr($color, 0, 1);
            $g = substr($color, 1, 1) . substr($color, 1, 1);
            $b = substr($color, 2, 1) . substr($color, 2, 1);
            $rgb = array(
                'r' => hexdec($r),
                'g' => hexdec($g),
                'b' => hexdec($b)
            );
        }
        return $rgb;
    }


    private function get_file_ext($file)
    {
        $filename = basename($file);
        list($name, $ext) = explode('.', $filename);

        $ext_type = 0;

        switch (strtolower($ext)) {
            case 'jpg':
            case 'jpeg':
                $ext_type = 2;
                break;
            case 'gif':
                $ext_type = 1;
                break;
            case 'png':
                $ext_type = 3;
                break;
        }

        return $ext_type;
    }
} // class end

