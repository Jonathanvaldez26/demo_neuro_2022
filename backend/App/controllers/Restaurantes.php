<?php

namespace App\controllers;

defined("APPPATH") or die("Access denied");

use \Core\View;
use \Core\MasterDom;
use \App\controllers\Contenedor;
use \Core\Controller;
use \App\models\Restaurantes as RestaurantesDao;

class Restaurantes extends Controller
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
html;

$extraFooter =<<<html
<script>
  $(document).ready(function(){

    $('#restaurantes-list').DataTable({
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
  });
</script>
html;

    $restaurantes = RestaurantesDao::getAll();
    $tabla = '';
    $modal = '';
    foreach ($restaurantes as $key => $value) {
      $tabla.=<<<html
          <tr>
              <!--td><input type="checkbox" name="borrar[]" value="{$value['id_restaurante']}"/></td-->
              <!--td><h6 class="mb-0 text-sm">{$value['id_restaurante']}</h6></td-->
              <td><h6 class="mb-0 text-sm">{$value['nombre']}</h6></td>
              <!--td><h6 class="mb-0 text-sm">{$value['clave']}</h6></td-->
              <td><h6 class="mb-0 text-sm">{$value['direccion']}</h6></td>
              <td>
              <u><a href="https://api.whatsapp.com/send?phone=52{$value['telefono']}&text=Buen%20d%C3%ADa,%20te%20contacto%20de%20parte%20del%20Equipo%20Grupo%20LAHE%20%F0%9F%98%80" target="_blank"><p class="text-sm font-weight-bold text-secondary mb-0"><span class="fa fa-whatsapp" style="font-size: 13px; color:green;"></span> {$value['telefono']}</p></a></u>
              </td>
              <td><h6 class="mb-0 text-sm">{$value['codigo_vestimenta']}</h6></td>
              <td><h6 class="mb-0 text-sm">{$value['capacidad']}</h6></td>
              <td>
                  <button type="button" class="btn bg-gradient-primary btn-icon-only" data-toggle="modal" data-target="#Modal_Editar-{$value['id_restaurante']}" data-bs-toggle="tooltip" data-bs-placement="left" data-bs-original-title="Editar Registro de {$value['nombre']} - {$value['id_restaurante']}"><i class="fa fa-edit" aria-hidden="true"></i></button>
                  <button type="button" class="btn bg-gradient-danger btn-icon-only" onclick="borrarRestaurante({$value['id_restaurante']})" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-original-title="Eliminar Registro de {$value['nombre']} - {$value['id_restaurante']}">
                      <i class="fas fa-trash"></i>
                  </button>
              </td>
          </tr>
    html;

    $modal .= $this->generarModal($value);
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
    View::set('tabla', $tabla);
    View::set('modal', $modal);
    View::set('header', $this->_contenedor->header($extraHeader));
    View::set('footer', $this->_contenedor->footer($extraFooter));
    View::render("restaurantes_all");
  }

  public function restaurantesAdd() {

    $data = new \stdClass();
    $data->_clave = $this->generateRandomString(10);
    $data->_nombre = MasterDom::getData('nombre');
    $data->_direccion = MasterDom::getData('direccion');
    $data->_capacidad = MasterDom::getData('capacidad');
    $data->_codigo_vestimenta = MasterDom::getData('codigo_vestimenta');
    $data->_telefono = MasterDom::getData('telefono');
    // $data->_url_asistencia = "/RegistroAsistencia/codigo/"."".$data->_clave = $this->generateRandomString();
    /*$data->_utilerias_administrador_id = MasterDom::getData('utilerias_administrador_id');*/

    $id = RestaurantesDao::insert($data);
    if($id >= 1){
      // $this->alerta($id,'add');
      header('Location: /Restaurantes');
    }else{
      // $this->alerta($id,'error');
      header('Location: /Restaurantes');
    }
  }

  public function borrarRestaurante($id){
    $delete_registrado = RestaurantesDao::delete($id);
    echo json_encode($delete_registrado);
  }

  public function generarModal($datos){
    $modal = <<<html
    <div class="modal fade" id="Modal_Editar-{$datos['id_restaurante']}" role="dialog" aria-labelledby="Modal_Editar_Label" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="Modal_Editar_Label">Editar Restaurante</h5>
                    <button type="button" class="btn btn-danger" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal add_restaurante" id="add_restaurante" action="" method="POST">
                        <input id="id_restaurante" name="id_restaurante" type="text" value="{$datos['id_restaurante']}" readonly hidden>
                        <div class="form-group row">
                            <div class="col-md-12 col-12" >
                                <label class="form-label">Nombre *</label>
                                <div class="input-group">
                                    <input id="nombre" name="nombre" maxlength="29" pattern="[a-zA-Z ÑñáÁéÉíÍóÚ]*{2,254}" class="form-control" type="text" placeholder="Le Bon Vine" required="" onfocus="focused(this)" onfocusout="defocused(this)" value="{$datos['nombre']}" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();">
                                </div>
                            </div>
                            <div class="col-md-6 col-12" >
                                <label class="form-label">Teléfono *</label>
                                <div class="input-group">
                                    <input id="telefono" name="telefono" maxlength="29" class="form-control" min="0" type="number" placeholder="+52 55 1234 5678" required="" onfocus="focused(this)" onfocusout="defocused(this)" value="{$datos['telefono']}" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();">
                                </div>
                            </div>
                            <div class="col-md-6 col-12" >
                                <label class="form-label">Capacidad *</label>
                                <div class="input-group">
                                    <input id="capacidad" name="capacidad" maxlength="29" class="form-control" min="0" type="number" placeholder="300" required="" onfocus="focused(this)" onfocusout="defocused(this)" value="{$datos['capacidad']}" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();">
                                </div>
                            </div>
                            <div class="col-md-12 col-12" >
                                <label class="form-label">Direccion *</label>
                                <div class="input-group">
                                    <textarea id="direccion" name="direccion" class="form-control" type="text" placeholder="Calle s/n #12, Col ..." required="" onfocus="focused(this)" onfocusout="defocused(this)">{$datos['direccion']}</textarea>
                                </div>
                            </div>
                            <div class="col-md-12 col-12" >
                                <label class="form-label">Código de Vestimenta *</label>
                                <div class="input-group">
                                    <textarea id="codigo_vestimenta" name="codigo_vestimenta" class="form-control" type="text" placeholder="Zapatos, Camisa, etc..." required="" onfocus="focused(this)" onfocusout="defocused(this)" >{$datos['codigo_vestimenta']}</textarea>
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

        $id_restaurante = $_POST['id_restaurante'];
        $nombre = $_POST['nombre'];
        $telefono = $_POST['telefono'];
        $capacidad = $_POST['capacidad'];
        $direccion = $_POST['direccion'];
        $codigo_vestimenta = $_POST['codigo_vestimenta'];

        $documento->_id_restaurante = $id_restaurante;
        $documento->_nombre = $nombre;
        $documento->_telefono = $telefono;
        $documento->_capacidad = $capacidad;
        $documento->_direccion = $direccion;
        $documento->_codigo_vestimenta = $codigo_vestimenta;

        $id = RestaurantesDao::update($documento);

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
