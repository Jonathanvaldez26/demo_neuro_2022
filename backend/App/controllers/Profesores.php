<?php

namespace App\controllers;
//defined("APPPATH") OR die("Access denied");
require_once dirname(__DIR__) . '/../public/librerias/fpdf/fpdf.php';
require_once dirname(__DIR__) . '/../public/librerias/phpqrcode/qrlib.php';


use \Core\View;
use \Core\MasterDom;
use \App\controllers\Contenedor;
use \Core\Controller;
use \App\models\General as GeneralDao;
use \App\models\Asistentes as AsistentesDao;
use \App\models\Usuarios as UsuariosDao;
use \App\models\Cursos as CursosDao;
use \App\models\Profesores as ProfesoresDao;
use Generator;

class Profesores extends Controller
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

    View::set('asideMenu', $this->_contenedor->asideMenu());
    // View::set('tabla', $this->getAllColaboradoresAsignados());
    View::render("profesores_all");
  }


  //Metodo para reaslizar busqueda de usuarios, sin este metodo no podemos obtener informacion en la vista
  public function Profesor()
  {
    $search = $_POST['search'];

    // $all_ra = AsistentesDao::getAllRegistrosAcceso();
    // $this->setTicketVirtual($all_ra);
    // $this->setClaveRA($all_ra);

    $modalEdit = '';
    foreach (ProfesoresDao::getAllProfesoresByName($search) as $key => $value) {
      $modalEdit .= $this->generarModalEditUser($value);
    }

    View::set('asideMenu', $this->_contenedor->asideMenu());
    View::set('tabla', $this->getAllProfesoresByName($search));
    View::set('modalEdit', $modalEdit);
    View::render("profesores_all");
  }

  public function Coordinador()
  {
    $search = $_POST['search'];

    $modalEditCoordinador = '';
    foreach (ProfesoresDao::getAllCoordinadoresByName($search) as $key => $value) {
      $modalEditCoordinador .= $this->generarModalEditUserCoordinador($value);
    }

    View::set('asideMenu', $this->_contenedor->asideMenu());
    View::set('tablaCoordinadores', $this->getAllCoordinadoresByName($search));
    View::set('modalEditCoordinador', $modalEditCoordinador);
    View::render("profesores_all");
  }

  public function saveData()
  {
    $data = new \stdClass();
    $imagen = MasterDom::getData('imagen');
    $data->_nombre = MasterDom::getData('nombre');
    $data->_prefijo = MasterDom::getData('prefijo');
    $data->_nacionalidad = MasterDom::getData('nacionalidad');
    $data->_descripcion = MasterDom::getData('descripcion');
    $data->_imagen = $this->generateRandomString() . '.png';
    // $data->_utilerias_administrador_id = $_SESSION['utilerias_administradores_id'];

    if (!file_exists('doctores/')) {
      mkdir('doctores/', 0777, true);
    }

    if (move_uploaded_file($imagen["tmp_name"], "doctores/" . $data->_imagen . '.png')) {
      $id = ProfesoresDao::insert($data);
      if ($id) {
        echo 'success';
      } else {
        echo 'fail';
      }
    }
  }

  public function saveDataCoordinador()
  {
    $data = new \stdClass();
    
    $data->_nombre = MasterDom::getData('nombre');
    $data->_prefijo = MasterDom::getData('prefijo');
   

    $id = ProfesoresDao::insertCoordinador($data);
    if ($id) {
      echo 'success';
    } else {
      echo 'fail';
    }
 
  }

  public function updateData()
  {
    $data = new \stdClass();
    $data->_nombre = MasterDom::getData('nombre');  
    $data->_nacionalidad = MasterDom::getData('nacionalidad');
    $data->_descripcion = MasterDom::getData('descripcion');
    $data->_id_profesor = MasterDom::getData('id_profesor');

    $id = ProfesoresDao::update($data);

    // var_dump($id);
    if ($id) {
      echo "success";
      // $this->alerta($id,'add');
      //header('Location: /PickUp');
    } else {
      echo "error";
      // header('Location: /PickUp');
      //var_dump($id);
    }
  }

  public function isUserValidate()
  {
    echo (count(UsuariosDao::getUserRegister($_POST['email'])) >= 1) ? 'true' : 'false';
  }

  public function setTicketVirtual($asistentes)
  {
    foreach ($asistentes as $key => $value) {
      if ($value['clave'] == '' || $value['clave'] == NULL || $value['clave'] == 'NULL') {
        $clave_10 = $this->generateRandomString(6);
        AsistentesDao::updateTicketVirtualRA($value['id_registro_acceso'], $clave_10);
      }
    }
  }

  public function setClaveRA($all_ra)
  {
    foreach ($all_ra as $key => $value) {
      if ($value['clave'] == '' || $value['clave'] == NULL || $value['clave'] == 'NULL') {
        $clave_10 = $this->generateRandomString(10);
        AsistentesDao::updateClaveRA($value['id_registro_acceso'], $clave_10);
      }
    }
  }

  public function Detalles($id)
  {

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

        #barra_progreso{
            width: -webkit-fill-available;
            height: 1rem;
            -webkit-appearance: none;
          }
          
          #barra_progreso::-webkit-progress-bar {
             background-color: #eee;
             border-radius: 50px;
          }
          
          #barra_progreso::-webkit-progress-value {
            background-color: rgba(23, 193, 232, 0.6);
            border-radius: 50px;
          }
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

    // echo $id;
    // var_dump($this->getUsersCourse($id));

    // exit;


    View::set('asideMenu', $this->_contenedor->asideMenu());
    View::set('header', $this->_contenedor->header($extraHeader));
    View::set('footer', $this->_contenedor->footer($extraFooter));
    // View::set('tabla', $this->getComprobanteVacunacionById($id));
    // View::set('tabla_prueba_covid', $this->getPruebasCovidById($id));
    View::set('tablaUsersCursos', $this->getUsersCourseByClave($id));
    View::render("usuarios_detalles");
  }

  public function getUsersCourseByClave($clave)
  {

    $html = "";
    foreach (CursosDao::getAllUsersCourseByClave($clave) as $key => $value) {
      $duracion = $value['duracion'];

      $duracion_sec = substr($duracion, strlen($duracion) - 2, 2);
      $duracion_min = substr($duracion, strlen($duracion) - 5, 2);
      $secs_totales = (intval($duracion_min) * 60) + intval($duracion_sec);


      $porcentaje_num = ($value['segundos'] * 100) / ($secs_totales);
      $porcentaje = number_format($porcentaje_num, 0);



      $html .= <<<html
            <tr>
                <td>
                    <div class="d-flex px-3 py-1">
                        
                        <div class="d-flex flex-column justify-content-center text-black">
                    
                            
                                <h6 class="mb-0 text-sm text-move text-black">
                                    <span class="fas fa-user" style="font-size: 13px"></span> {$value['nombre']} - {$value['apellidop']} - {$value['apellidom']}                                    
                                </h6>
                        </div>
                    </div>
                </td>
         
                <td style="text-align:left; vertical-align:middle;"> 
                    
                <div class="d-flex flex-column justify-content-center text-black">                    
                                    
                        <h6 class="mb-0 text-sm  text-black">
                            <p>Nombre : {$value['nombre_curso']} </p>                            
                            <p>Fecha : {$value['horario_transmision']}</p>
                            <p>Hora : {$value['fecha_curso']} </p> 
                            <p>Progreso : {$porcentaje} %</p> 
                            <progress id="barra_progreso" max="{$secs_totales}" value="{$value['segundos']}"></progress>                                    
                        </h6>
                </div>
                <hr>
                </td>

                <td>
                <div class="d-flex  justify-content-center text-black">
                     <button class="btn bg-gradient-danger mb-0 btn-icon-only btn_quitar_user_curso" data-id="{$value['id_asigna_curso']}" data-nombre-user="{$value['nombre']} {$value['apellidop']} {$value['apellidom']}" data-nombre-curso="{$value['nombre_curso']}" data-porcentaje="{$porcentaje}" type="button" title="Quitar Curso"><i class="fa fa-trash" aria-hidden="true"></i></button>                     
                     </div>
                </td>
        </tr>
html;
    }

    return $html;
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



  public function getAllProfesoresByName($name)
  {

    $html = "";
    // foreach (ProfesoresDao::getAllProfesoresByName($name) as $key => $value) {
    foreach (ProfesoresDao::getAllProfesoresByName($name) as $key => $value) {

      $value['nombre'] = utf8_encode($value['nombre']);

      // if (empty($value['img']) || $value['img'] == null) {
      //     $img_user = "/img/user.png";
      // } else {
      //     $img_user = "https://registro.foromusa.com/img/users_musa/{$value['img']}";
      // }

      $internacional = '';
      if ($value['internacional'] == 1) {
        $internacional .= <<<html
                <span class="badge badge-success">Internacional</span>
html;
      } else {
        $internacional .= <<<html
                <span class="badge badge-warning">Nacional</span>
html;
      }


      $html .= <<<html
            <tr>
                <td>
                    <div class="d-flex px-3 py-1">
                        
                        <div class="d-flex flex-column justify-content-center text-black">
                    
                            
                                <h6 class="mb-0 text-sm text-move text-black">
                                    <span class="fa fa-user-md" style="font-size: 13px"></span> {$value['nombre']} - {$internacional}

                                </h6>
                        </div>
                    </div>
                </td>
         
                <td style="text-align:left; vertical-align:middle;"> 
                    
                    <span>{$value['descripcion']}</span>

                </td>

                <td>
                     <button class="btn bg-gradient-primary mb-0 btn-icon-only" type="button" title="Editar Usuario" data-toggle="modal" data-target="#editar-usuario{$value['id_profesor']}"><i class="fa fa-edit" aria-hidden="true"></i></button>
                     <button class="btn bg-gradient-danger mb-0 btn-icon-only" id="btn-borrar-{$value['id_profesor']}" onclick="borrarProfesor({$value['id_profesor']})" type="button" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-original-title="Eliminar Profesor"><span class="fas fa-trash"></span></button>
                </td>
        </tr>
html;
    }

    return $html;
  }

  public function getAllCoordinadoresByName($name)
  {

    $html = "";
    // foreach (ProfesoresDao::getAllProfesoresByName($name) as $key => $value) {
    foreach (ProfesoresDao::getAllCoordinadoresByName($name) as $key => $value) {

      $value['nombre'] = utf8_encode($value['nombre']);

      // if (empty($value['img']) || $value['img'] == null) {
      //     $img_user = "/img/user.png";
      // } else {
      //     $img_user = "https://registro.foromusa.com/img/users_musa/{$value['img']}";
      // }


      $html .= <<<html
            <tr>
                <td>
                    <div class="d-flex px-3 py-1">
                        
                        <div class="d-flex flex-column justify-content-center text-black">
                    
                            
                                <h6 class="mb-0 text-sm text-move text-black">
                                    <span class="fa fa-user-md" style="font-size: 13px"></span> {$value['nombre']} 

                                </h6>
                        </div>
                    </div>
                </td>
         
                
                <td>
                     <button class="btn bg-gradient-primary mb-0 btn-icon-only" type="button" title="Editar Usuario" data-toggle="modal" data-target="#editar-usuario-coordinador{$value['id_coordinador']}"><i class="fa fa-edit" aria-hidden="true"></i></button>
                     <button class="btn bg-gradient-danger mb-0 btn-icon-only" id="btn-borrar-{$value['id_coordinador']}" onclick="borrarCoordinador({$value['id_coordinador']})" type="button" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-original-title="Eliminar Coordinador"><span class="fas fa-trash"></span></button>
                </td>
        </tr>
html;
    }

    return $html;
  }

  public function generarModalEditUser($datos)
  {

    $selectInternacional = '';

    if($datos['internacional'] == 1){
      $selectInternacional = <<<html
        <select class="multisteps-form__select form-control all_input_select" name="nacionalidad" id="nacionalidad" required>
            <option value="" selected>Selecciona una Opción</option>
            <option value="0">Nacional</option>
            <option value="1" selected>Internacional</option>
        </select>
html;
    }else{
      $selectInternacional = <<<html
        <select class="multisteps-form__select form-control all_input_select" name="nacionalidad" id="nacionalidad" required>
            <option value="" selected>Selecciona una Opción</option>
            <option value="0" selected>Nacional</option>
            <option value="1">Internacional</option>
        </select>
html;
    }

    $modal = <<<html
            <div class="modal fade" id="editar-usuario{$datos['id_profesor']}" role="dialog" aria-labelledby="" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">
                        Editar Usuario
                    </h5>

                    <span type="button" class="btn bg-gradient-danger" data-dismiss="modal" aria-label="Close">
                        X
                    </span>
                </div>
                <div class="modal-body">
                    <p style="font-size: 12px">A continuación ingrese los datos del usuario.</p>
                    <hr>
                    <form method="POST" enctype="multipart/form-data" class="form_datos_edit">
                    <input type="hidden" id="id_profesor" name="id_profesor" value = {$datos['id_profesor']}>
                    <div class="form-group row">
                        

                        <div class="form-group col-md-4">
                            <label class="control-label col-md-12 col-sm-1 col-xs-12" for="nombre">Nombre <span class="required">*</span></label>
                            <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Nombre" value="{$datos['nombre']}" require>
                        </div>


                        <div class="form-group col-md-4">
                            <label class="control-label col-md-12 col-sm-1 col-xs-12" for="nacionalidad">Nacionalidad <span class="required">*</span></label>
                            {$selectInternacional}
                        </div>

                        <div class="form-group col-md-12">
                            <label class="control-label col-md-12 col-sm-1 col-xs-12" for="descripcion">Descripción <span class="required">*</span></label>
                            <textarea id="descripcion" name="descripcion" class="form-control">{$datos['descripcion']}</textarea>
                        </div>


                        <div class="modal-footer">
                            <button type="submit" class="btn bg-gradient-success" id="btn_upload" name="btn_upload">Aceptar</button>
                            <button type="button" class="btn bg-gradient-secondary" data-dismiss="modal">Cancelar</button>
                        </div>
                    </div>
                </form>
                </div>

            </div>
                </div>
            </div>
html;

    return $modal;
  }

  public function generarModalEditUserCoordinador($datos)
  {

  
    $modal = <<<html
            <div class="modal fade" id="editar-usuario-coordinador{$datos['id_coordinador']}" role="dialog" aria-labelledby="" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">
                        Editar Usuario
                    </h5>

                    <span type="button" class="btn bg-gradient-danger" data-dismiss="modal" aria-label="Close">
                        X
                    </span>
                </div>
                <div class="modal-body">
                    <p style="font-size: 12px">A continuación ingrese los datos del usuario.</p>
                    <hr>
                    <form method="POST" enctype="multipart/form-data" id="form_datos_coordinador">
                        <div class="form-group row">
                            <div class="form-group col-md-4">
                                <label class="control-label col-md-12 col-sm-1 col-xs-12" for="prefijo">Prefijo <span class="required">*</span></label>
                                <select class="multisteps-form__select form-control all_input_select" name="prefijo" id="prefijo" required>
                                    <option value="" selected>Selecciona una Opción</option>
                                    <option value="Dr.">Dr.</option>
                                    <option value="Dra.">Dra.</option>
                                    <option value="Sr.">Sr.</option>
                                    <option value="Sra.">Sra.</option>
                                </select>
                            </div>

                            <div class="form-group col-md-4">
                                <label class="control-label col-md-12 col-sm-1 col-xs-12" for="nombre">Nombre <span class="required">*</span></label>
                                <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Nombre" value="{$datos['nombre']}" require>
                            </div>

                            <div class="modal-footer">
                                <button type="submit" class="btn bg-gradient-success" id="btn_upload_1" name="btn_upload_1">Aceptar</button>
                                <button type="button" class="btn bg-gradient-secondary" data-dismiss="modal">Cancelar</button>
                            </div>
                        </div>
                    </form>
                </div>

            </div>
                </div>
            </div>
html;

    return $modal;
  }

  public function borrarProfesor(){

    $id = $_POST['dato'];
    $delete_prof = ProfesoresDao::delete($id);

    echo json_encode($delete_prof);
}

public function borrarCoordinador(){

  $id = $_POST['dato'];
  $delete_prof = ProfesoresDao::deleteCoordinador($id);

  echo json_encode($delete_prof);
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
      $pdf->Multicell(120, 4.2, $nombre_completo . utf8_decode(" #habitación") . " - " . $no_habitacion, 0, 'C');

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
