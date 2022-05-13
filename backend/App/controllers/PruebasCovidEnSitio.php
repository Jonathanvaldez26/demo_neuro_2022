<?php

namespace App\controllers;

defined("APPPATH") or die("Access denied");

use \Core\View;
use \Core\MasterDom;
use \App\controllers\Contenedor;
use \Core\Controller;
use \App\models\PruebasCovidEnSitio as PruebasCovidEnSitioDao;

class PruebasCovidEnSitio extends Controller
{

  private $_contenedor;

  function __construct()
  {
    parent::__construct();
    $this->_contenedor = new Contenedor;
    View::set('header', $this->_contenedor->header());
    View::set('footer', $this->_contenedor->footer());
    if (Controller::getPermisosUsuario($this->__usuario, "seccion_restaurantes", 1) == 0)
      header('Location: /Principal/');
  }

  public function getUsuario()
  {
    return $this->__usuario;
  }

  public function index()
  {
    $extraHeader = <<<html
      <style>
        .logo{
          width:100%;
          height:150px;
          margin: 0px;
          padding: 0px;
        }
      </style>
      <link rel="apple-touch-icon" sizes="76x76" href="https://foromusa.com/assets/images/Musa0-01.png">
      <link rel="icon" type="image/png" href="https://foromusa.com/assets/images/Musa0-01.png">
html;

$extraFooter =<<<html
<script>
  $(document).ready(function(){

    $('#pruebas-list').DataTable({
          "drawCallback": function(settings) {
              $('.current').addClass("btn bg-gradient-musa morado-musa-text btn-rounded").removeClass("paginate_button");
              $('.paginate_button').addClass("btn").removeClass("paginate_button");
              $('.dataTables_length').addClass("m-4");
              $('.dataTables_info').addClass("mx-4");
              $('.dataTables_filter').addClass("m-4");
              $('input').addClass("form-control");
              $('select').addClass("form-control");
              $('.previous.disabled').addClass("btn-outline-info opacity-5 btn-rounded mx-2");
              $('.next.disabled').addClass("btn-outline-info opacity-5 btn-rounded mx-2");
              $('.previous').addClass("btn-outline-info btn-rounded mx-2");
              $('.next').addClass("btn-outline-info btn-rounded mx-2");
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

      $('#sorteados-list').DataTable({
          "drawCallback": function(settings) {
              $('.current').addClass("btn bg-gradient-musa morado-musa-text btn-rounded").removeClass("paginate_button");
              $('.paginate_button').addClass("btn").removeClass("paginate_button");
              $('.dataTables_length').addClass("m-4");
              $('.dataTables_info').addClass("mx-4");
              $('.dataTables_filter').addClass("m-4");
              $('input').addClass("form-control");
              $('select').addClass("form-control");
              $('.previous.disabled').addClass("btn-outline-info opacity-5 btn-rounded mx-2");
              $('.next.disabled').addClass("btn-outline-info opacity-5 btn-rounded mx-2");
              $('.previous').addClass("btn-outline-info btn-rounded mx-2");
              $('.next').addClass("btn-outline-info btn-rounded mx-2");
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
  });
</script>
html;

    $pruebas = PruebasCovidEnSitioDao::getAll();
    $tabla = '';
    $modal = '';
    foreach ($pruebas as $key => $value) {
      $tabla.=<<<html
          <tr>
              <td><h6 class="mb-0 text-sm">{$value['nombre_completo']}</h6></td>
              <td><h6 class="mb-0 text-sm">{$value['fecha_prueba_covid']}</h6></td>
              <td><h6 class="mb-0 text-sm">{$value['tipo_prueba']}</h6></td>
              <td><h6 class="mb-0 text-sm">{$value['resultado']}</h6></td>
              <td><h6 class="mb-0 text-sm">{$value['documento']}</h6></td>
              <td>
                  <button type="button" class="btn bg-gradient-primary btn-icon-only" data-toggle="modal" data-target="#Modal_Editar-{$value['id_prueba_covid']}" data-bs-toggle="tooltip" data-bs-placement="left" data-bs-original-title="Editar Registro de {$value['nombre']} - {$value['id_prueba_covid']}"><i class="fa fa-edit" aria-hidden="true"></i></button>
                  <button type="button" class="btn bg-gradient-danger btn-icon-only" onclick="borrarPruebaCovid({$value['id_prueba_covid']})" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-original-title="Eliminar Registro de {$value['nombre']} - {$value['id_prueba_covid']}">
                      <i class="fas fa-trash"></i>
                  </button>
              </td>
          </tr>
    html;



      $modal .= $this->generarModal($value);
    }

    $asistentes = PruebasCovidEnSitioDao::getAsistentes();
    $asistente = '';
    foreach ($asistentes as $key => $value) {
      $asistente .=<<<html
        <option value="{$value['utilerias_asistentes_id']}">{$value['nombre_completo']} </option>
html;
    }

    $sorteados = PruebasCovidEnSitioDao::getAsistentes();
    $sorteado = '';
    foreach ($sorteados as $key => $value) {
      $sorteado .=<<<html
        <tr>
          <td>
            <h6 class="mx-8 m-auto text-sm">{$value['nombre_completo']} <span class="badge badge-info" style="color: white; background-color:{$value['color']};">{$value['linea']}</span></h6> 
            <hr>
            <div class="mx-8 m-auto d-flex flex-column justify-content-center">
              <u><a href="mailto:{$value['usuario']}"><h6 class="mb-0 text-sm"><span class="fa fa-mail-bulk" style="font-size: 13px"></span> {$value['usuario']}</h6></a></u>
              <u><a href="https://api.whatsapp.com/send?phone=52{$value['telefono']}&text=Buen%20d%C3%ADa,%20te%20contacto%20de%20parte%20del%20Equipo%20Grupo%20LAHE%20%F0%9F%98%80" target="_blank"><p class="text-sm font-weight-bold text-secondary mb-0"><span class="fa fa-whatsapp" style="font-size: 13px; color:green;"></span> {$value['telefono']}</p></a></u>
            </div>
          </td>
          <td><p class="text-center" style="font-size: small;"><span class="fa fa-calendar" style="font-size: 13px;"> </span> {$value['fecha_cita']}</p></td>
          <td><p class="text-center" style="font-size: small;"><span class="fa fa-clock" style="font-size: 13px;"> </span> {$value['hora_cita']}</p></td>
          <td class="text-center">
              <a href="https://api.whatsapp.com/send?phone=52{$value['telefono']}&text=Estimado%20(a):{$value['nombre_completo']}%20Te%20informamos%20que%20como%20parte%20de%20las%20medidas%20de%20seguridad%20sanitaria,%20has%20sido%20seleccionado%20de%20forma%20aleatoria%20para%20realizarte%20la%20prueba%20Ant%C3%ADgenos%20de%20detecci%C3%B3n%20del%20virus%20SARS%20CoV-2.,%20te%20solicitamos%20que%20asistas%20sin%20aseo%20nasal%20ni%20lavado%20dental,%20previo%20a%20la%20siguiente%20cita:%20%F0%9F%97%93%EF%B8%8F%20D%C3%ADa:%2007%20de%20Abril%20de%202022%20%E2%8F%B0%20Horario%20abierto:%20de%209:00%20am%20a%2011:45%20am%20%F0%9F%8F%A2%20Lugar:%20Consultorio%20M%C3%A9dico%20ubicado%20en%20Sal%C3%B3n%20Balam%20Te%20recordamos%20que%20esta%20prueba%20es%20obligatoria" class="btn bg-gradient-success btn-icon-only" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-original-title="Enviar mensaje a {$value['nombre_completo']} con número {$value['telefono']}">
                  <span class="fa fa-whatsapp" style="font-size: initial; "></span>
              </a>
          </td>
        </tr>
html;
    }

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
    View::set('asistente', $asistente);
    View::set('sorteado', $sorteado);
    View::set('tabla', $tabla);
    View::set('modal', $modal);
    View::set('asideMenu',$this->_contenedor->asideMenu());
    View::set('header', $this->_contenedor->header($extraHeader));
    View::set('footer', $this->_contenedor->footer($extraFooter));
    View::render("pruebas_sitio");
  }

  public function pruebaAdd(){

    $documento = new \stdClass();

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

      $usuario = $_POST["asistente"];
      $fecha_prueba = $_POST['fecha_prueba'];
      $tipo_prueba = $_POST['tipo_prueba'];
      $resultado = $_POST['resultado'];
      
      $nota = $_POST['nota'];
      $pdf = $this->generateRandomString();

      $file = $_FILES["file_"];
      move_uploaded_file($file["tmp_name"], "pruebas_covid/".$pdf.'.pdf');

      $documento->_user = $usuario;
      $documento->_fecha_prueba = $fecha_prueba;
      $documento->_tipo_prueba = $tipo_prueba;
      $documento->_resultado = $resultado;
      $documento->_url = $pdf.'.pdf';
      $documento->_nota = $nota;
      
      $id = PruebasCovidEnSitioDao::insert($documento);

      if ($id) {
          echo 'success';
          header('Location: /PruebasCovidEnSitio');
      } else {
          echo 'fail';
      }
  } else {
      echo 'fail REQUEST';
  }
}
  public function borrarPruebaCovid($id){
    $delete_registrado = PruebasCovidEnSitioDao::delete($id);
    echo json_encode($delete_registrado);
  }

  public function generarModal($datos){
    $modal = <<<html
    <div class="modal fade" id="Modal_Editar-{$datos['id_prueba_covid']}" role="dialog" aria-labelledby="Modal_Editar_Label" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="Modal_Editar_Label">Editar Prueba</h5>
                    <button type="button" class="btn btn-danger" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal editar_prueba" id="editar_prueba" action="" method="POST">
                        <input id="id_prueba_covid" name="id_prueba_covid" type="text" value="{$datos['id_prueba_covid']}" readonly hidden>
                        <div class="form-group row">
                            <div class="col-md-12 col-12" >
                                <label class="form-label">Nombre del Asistente*</label>
                                <input hidden id="asistente" name="asistente" class="form-control" type="number" value="{$datos['utilerias_asistentes_id']}" style="text-transform:uppercase;" readonly> 
                                <div class="input-group">
                                    <input id="nombre" name="nombre" maxlength="29" pattern="[a-zA-Z ÑñáÁéÉíÍóÚ]*{2,254}" class="form-control" type="text" placeholder="Le Bon Vine" required="" onfocus="focused(this)" onfocusout="defocused(this)" value="{$datos['nombre_completo']} " style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();" readonly> 
                                </div>
                            </div>
                            <div class="col-md-6 col-12" >
                                <label class="form-label">Fecha *</label>
                                <div class="input-group">
                                    <input id="fecha_prueba" name="fecha_prueba" min="2022-04-07" maxlength="29" class="form-control" type="date" placeholder="+52 55 1234 5678" required="" onfocus="focused(this)" onfocusout="defocused(this)" value="{$datos['fecha_prueba_covid']}" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();">
                                </div>
                            </div>
                            <div class="col-md-6 col-12" >
                                <label class="form-label">Tipo de Pureba *</label>
                                <div class="input-group">
                                    <input id="tipo_prueba" name="tipo_prueba" maxlength="29" class="form-control" type="text" placeholder="300" required="" onfocus="focused(this)" onfocusout="defocused(this)" value="Antigeno" readonly>
                                </div>
                            </div>
                            <div class="col-md-12 col-12" >
                                <label class="form-label">Resultado *</label>
                                <select name="resultado" id="resultado">
                                    <option selected disabled>Seleccione un Resultado</option>
                                    <option value="Negativo">Negativo</option>
                                    <option value="Positivo">Positivo</option>
                                </select>
                            </div>
                            <div class="col-md-12 col-12 my-4" >
                                <label class="form-label">Prueba (Documento) *</label>
                                <div class="input-group">
                                <input type="file" accept="application/pdf" class="form-control" value="{$datos['documento']}" id="file_" name="file_" required>
                                </div>
                            </div>
                            <div class="col-md-12 col-12" >
                                <label class="form-label">Nota *</label>
                                <div class="input-group">
                                    <textarea id="nota" name="nota" class="form-control" type="text" placeholder="Esta prueba fue ..." required="" onfocus="focused(this)" onfocusout="defocused(this)" value="{$datos['nota']}" >{$datos['nota']}</textarea>
                                </div>
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
html;

    return $modal;
  }

  public function Actualizar(){

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $documento = new \stdClass();

        $id_prueba_covid = $_POST['id_prueba_covid'];
        $asistente = $_POST['asistente'];
        $fecha = $_POST['fecha_prueba'];
        $tipo_prueba = $_POST['tipo_prueba'];
        $resultado = $_POST['resultado'];
        $nota = $_POST['nota'];

        $pdf = $this->generateRandomString();

        $file = $_FILES["file_"];
        move_uploaded_file($file["tmp_name"], "pruebas_covid/".$pdf.'.pdf');

        $documento->_id_prueba_covid = $id_prueba_covid;
        $documento->_asistente = $asistente;
        $documento->_fecha = $fecha;
        $documento->_tipo_prueba = $tipo_prueba;
        $documento->_resultado = $resultado;
        $documento->_nota = $nota;
        $documento->_url = $pdf.'.pdf';

        $id = PruebasCovidEnSitioDao::update($documento);

        if($id){
            echo "success";
          //header("Location: /Home");
        }else{
            echo "fail";
         // header("Location: /Home/");
        }

    } else {
        echo 'fail REQUEST';
    }
  }

  function generateRandomString($length = 6) { 
    return substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, $length); 
  } 
}
