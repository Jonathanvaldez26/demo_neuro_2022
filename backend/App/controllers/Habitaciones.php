<?php

namespace App\controllers;

defined("APPPATH") or die("Access denied");

use \Core\View;
use \Core\MasterDom;
use \App\controllers\Contenedor;
use \Core\Controller;
use \App\models\Habitaciones as HabitacionesDao;
use \App\models\Asistentes as AsistentesDao;
use \App\models\Pases as PasesDao;

class Habitaciones extends Controller
{

  private $_contenedor;

  function __construct()
  {
    parent::__construct();
    $this->_contenedor = new Contenedor;
    View::set('header', $this->_contenedor->header());
    View::set('footer', $this->_contenedor->footer());
    if (Controller::getPermisosUsuario($this->__usuario, "seccion_habitaciones", 1) == 0)
      header('Location: /Principal/');
  }

  public function getUsuario()
  {
    return $this->__usuario;
  }

  public function index()
  {
    setlocale(LC_TIME, "spanish");
//     $extraHeader = <<<html
// html;

    //tab asistetes
    $tabla_asistentes = '';
    $optionsHotel = '';
    $optionsCategoriaHotel = '';
    $cant_huespedes_permitida = 0;
    $btnAddUser = '';
    $modal_asigna_habitacion = '';
    $jsModal = '';
    $fecha_inicio_evento_str = strtotime("2022/04/06");
    $fecha_inicio_evento = date('Y-m-d', $fecha_inicio_evento_str);
    $fecha_fin_evento_str = strtotime("2022/04/09");
    $fecha_fin_evento = date('Y-m-d', $fecha_fin_evento_str);


    $hoteles = HabitacionesDao::getAll();
    foreach ($hoteles as $key => $value) {
      $optionsHotel .= <<<html
          <option value="{$value['id_hotel']}" selected>{$value['nombre_hotel']}</option>
html;
    }

    $CategoriasHabitacion = HabitacionesDao::getAllCategoriasHabitaciones();
    foreach ($CategoriasHabitacion as $key => $value) {
      $optionsCategoriaHotel .= <<<html
            <option value="{$value['id_categoria_habitacion']}">{$value['nombre_categoria']}</option>
html;
    }

    $asistentes = AsistentesDao::getAllRegisterConHabitacion();
   
    foreach ($asistentes as $key => $value) {
      $habitacionCompartida = AsistentesDao::getUsuariosByClaveHabitacion($value['clave']);

      if (empty($habitacionCompartida['img']) || $habitacionCompartida['img'] == null) {
        $img_user = "/img/user.png";
      } else {
        $img_user = "https://convencionasofarma2022.mx/img/users_conave/{$value['img']}";
      }


      $tabla_asistentes .= <<<html
      <tr>
      <td>
      <div class="d-flex px-3 py-1">
          <div>
html;          
          foreach ($habitacionCompartida as $key => $val) {
            $tabla_asistentes.= <<<html
            <img src="{$img_user}" class="avatar me-3 mb-2" alt="image" ><br>
html;
         }
         $tabla_asistentes .= <<<html
          </div>
          <div class="d-flex flex-column justify-content-center">
html;
      $cont_user = 0;
      foreach ($habitacionCompartida as $key => $val) {
         $cont_user++;
         $tabla_asistentes.= <<<html
         <h6 class="mb-0 text-sm"><span class="fas fa-user-md"></span>
         <a href="javascript:;" data-bs-toggle="tooltip" data-bs-original-title="Quitar huesped de la habitacion" class="btn_quitar_huesped" data-value="{$val['id_asigna_habitacion']}" value="{$val['id_asigna_habitacion']}"> ({$cont_user}) {$val['nombre']} | {$val['email']} | {$val['telefono']}</a></h6>
html;
      }

      $tabla_asistentes .= <<<html
            <p class="text-sm font-weight-bold text-secondary mb-0"><span class="fas fa-hotel"></span> {$value['nombre_categoria']}</p>
            <p class="text-sm font-weight-bold text-secondary mb-0"><span class="fa fa-hotel"></span> No. habitación {$value['id_habitacion']} </p>
            </div>
          </div>
      </td>
html;
      // <td class="align-middle text-center text-sm">
      //     foreach ($distinct as $key => $val) {
      //       if ($val['nombre_usuario'] != $value['nombre_usuario']) {
      //         $tabla_asistentes .= <<<html
      //         <h6 class="mb-0 text-sm">{$val['nombre_usuario']} {$val['apellido_paterno']} {$val['apellido_materno']}</h6>
      //         <p class="text-sm font-weight-bold text-secondary mb-0"><span class="fa fa-hotel"></span> {$value['nombre_categoria']}</p>
      // html;
      //       }
      //     }
      // </td>

      //Validacion de lugares disponibles
      $habitacion = HabitacionesDao::getCategoriasHabitacionesById($value['id_categoria_habitacion'])[0];
      $cant_huespedes_permitida = $habitacion['huespedes'];

      $countAsistentes = AsistentesDao::getCountAsistentesByClave($value['clave'])[0];

      $con_lugares_disponibles = $countAsistentes['total_asignados'] % $cant_huespedes_permitida;
      $total_lugares_disponibles = $cant_huespedes_permitida - $countAsistentes['total_asignados'];

      $status_disponible = $con_lugares_disponibles > 0 ? "<span class='badge bg-warning text-dark'>Hay ".$total_lugares_disponibles." lugares disponible</span>" : "<span class='badge bg-success '>Habitación llena</span>";

      $btnAddUser = $con_lugares_disponibles > 0 ? "<a href='javascript:;' data-bs-toggle='tooltip' data-bs-original-title='Asignar usuario' class='btn_asignar_usuario' data-value='{$value['clave']}' data-toggle='modal' data-target='#asignaUsuario{$value['clave']}'><i class='fa fa-hotel' aria-hidden='true'></i></a>" : "";

      $tabla_asistentes .= <<<html
                
            <td class="align-middle text-center text-sm">
                <p class="text-sm font-weight-bold mb-0 text-dark">{$status_disponible} </p>
            </td>
            
            <td class="align-middle text-center text-sm">
                <p class="text-sm font-weight-bold mb-0 text-dark">{$value['nombre_administrador']}</p>
            </td>
            <td class="align-middle text-end">
                <div class="d-flex px-3 py-1 justify-content-center align-items-center">
                  {$btnAddUser}
                </div>
              </td>
            </tr>
html;

    $modal_asigna_habitacion .= <<<html
    <div class="modal fade" id="asignaUsuario{$value['clave']}" role="dialog" aria-labelledby="asignaUsuarioLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form class="form-horizontal form_asig_habitacion"  action="" method="POST" id="">
                <div class="modal-header">
                    <h5 class="modal-title" id="asignaUsuarioLabel">Asignar Habitacion</h5>
                    <button type="button" class="btn bg-gradient-danger" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="card-body pt-0">
                        <div class="row">
html;
      
              $selectUsersinHabitacion = AsistentesDao::getAllRegisterSinHabitacion();

              

              $modal_asigna_habitacion .= <<<html
                  <div class="col-12 align-self-center">
                  <input type="hidden" id="clave_ah" name="clave_ah" value="{$value['clave']}">
                  <label class="form-label mt-4">Nombre del Asistente *</label><br>
                          <select class="select_2_add_user" name="id_asistente" data-clave="{$value['clave']}" >
                                 <option value="" disabled selected>Selecciona una opción</option>
html;
              foreach($selectUsersinHabitacion as $key => $v)
              {
                $modal_asigna_habitacion .= <<<html
                <option value="{$v['id_registro_acceso']}">{$v['nombre']}</option>
html;
              }          
              $modal_asigna_habitacion .= <<<html
                                    </select>
                                    
                                </div>

                              </div>


                              <div class="row mb-3">
                                <div class="col-md-6 col-sm-12 align-self-center asign_huesped">
                                    <label class="form-label">IN *</label><br>
                                    <input type="date" class="form-control" id="date_in" name="date_in" min="{$fecha_inicio_evento}" max="{$fecha_fin_evento}">
                                </div>
                                <div class="col-md-6 col-sm-12 align-self-center asign_huesped">
                                    <label class="form-label">OUT *</label><br>
                                    <input type="date" class="form-control" id="date_out" name="date_out"  min="{$fecha_inicio_evento}" max="{$fecha_fin_evento}">
                                </div>
                              </div>

                              <div class="row mb-3">
                                  <div class="col-md-6 col-sm-12 align-self-center asign_huesped">
                                      <label class="form-label">Hora de Vuelo</label><br>
                                      <div class="input-group">
                                          <input type="text" class="form-control" placeholder="vuelo" aria-label="vuelo" aria-describedby="basic-addon1" id="vuelo{$value['clave']}" name="vuelo" readonly>
                                          <span class="input-group-text" id="svuelo"><i class="fa fa-info-circle"></i></span>
                                      </div>
                                  </div>
                                  <div class="col-md-6 col-sm-12 align-self-center asign_huesped">
                                      <label class="form-label">Numero de habitación (opcional)</label><br>
                                      <input type="number" class="form-control" id="numero_habitacion" name="numero_habitacion" value="{$value['id_habitacion']}">
                                  </div>
                              </div>


                              <div class="row mb-3">
                                  <div class="col-md-12 align-self-center asign_huesped">
                                    <label class="form-label">Comentarios (opcional)</label><br>
                                    <textarea name="comentarios" id="comentarios" class="form-control" cols="30" rows="5"></textarea>
                                  </div>
                              </div>

                          </div>

                      </div>
                      <div class="modal-footer">
                          <button class="btn bg-gradient-success ms-auto mb-0 mx-4" type="submit" title="Actualizar">Actualizar</button>
                          <a class="btn bg-gradient-secondary mb-0 js-btn-prev" data-dismiss="modal" title="Prev" >Cancelar</a>
                      
                          <!--<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                          <button type="submit" class="btn btn-primary" id="save_habitacion">Save changes</button>-->
                      </div>
                  </form>
              </div>
          </div>
      </div>
html;

     

    }

    //tab habitaciones
    $habitaciones = HabitacionesDao::getHabitaciones();
    $tabla_habitaciones = '';
    $optionsCategoriaHotelHabitaciones = '';
    $modal_edit_habitacion = '';

    $CategoriasHabitacionSelect = HabitacionesDao::getCategoriasHabitacionesDistict();
    
    foreach ($CategoriasHabitacionSelect as $key => $value) {
      $optionsCategoriaHotelHabitaciones .= <<<html
            <option value="{$value['id_categoria_habitacion']}">{$value['nombre_categoria']}</option>
html;
    }

    $total_habitaciones_ocupadas = AsistentesDao::getAllRegisterConHabitacionByCategoria(1);

   // var_dump($optionsCategoriaHotelHabitaciones);

    foreach ($habitaciones as $key => $value) {

    //habitaciones opupadas
     $total_habitaciones_ocupadas = AsistentesDao::getAllRegisterConHabitacionByCategoria($value['id_categoria_habitacion']);
     $total_ocupadas = count($total_habitaciones_ocupadas);
     
     //habitaciones disponibles
     $habitaciones_disponibles = $value['cant_habitaciones'] - $total_ocupadas;

      $tabla_habitaciones .= <<<html
      <tr>
        <td class="align-middle text-center text-sm">
          {$value['nombre_categoria']}
        </td>
        <td class="align-middle text-center text-sm">
          {$value['cant_habitaciones']}
        </td>
        <td class="align-middle text-center text-sm">
          {$habitaciones_disponibles}
        </td>
        <td class="align-middle text-center text-sm">
        {$total_ocupadas}
        </td>
        <td class="align-middle text-center text-sm">
        <a href='javascript:;' data-bs-toggle='tooltip' data-bs-original-title='Actualizar habitación' class='btn_asignar_usuario' data-value='{$value['id_categoria_habitacion']}' data-toggle='modal' data-target='#edit-habitacion{$value['id_categoria_habitacion']}'><i class='fa fa-hotel' aria-hidden='true'></i></a>
        </td>
      </tr>
html;

$modal_edit_habitacion .= <<<html
    <div class="modal fade" id="edit-habitacion{$value['id_categoria_habitacion']}" role="dialog" aria-labelledby="edit-habitacionLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <form class="form-horizontal form_edit_habitacion"  action="" method="POST" id="">
                    <div class="modal-header">
                        <h5 class="modal-title" id="edit-habitacionLabel">Editar habitación</h5>
                        <button type="button" class="btn bg-gradient-danger" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="card-body pt-0">
                            <div class="row">
html;
      

              $modal_edit_habitacion .= <<<html
                

                              </div>


                              <div class="row mb-3">
                              <input type="hidden" id="total_habitaciones" name="total_habitaciones" value="{$value['cant_habitaciones']}" /> 
                              <input type="hidden" id="habitaciones_disponibles" name="habitaciones_disponibles" value="{$habitaciones_disponibles}" /> 
                              <input type="hidden" id="habitaciones_ocupadas" name="habitaciones_ocupadas" value="{$total_ocupadas}" /> 
                                <input type="hidden" id="id_categoria_habitacion" name="id_categoria_habitacion" value="{$value['id_categoria_habitacion']}" /> 
                                <div class="col-md-6 col-sm-12 align-self-center asign_huesped">
                                    <label class="form-label">Categoria Habitación</label><br>
                                    <input type="text" class="form-control" id="nombre_categoria" name="nombre_categoria" readonly value="{$value['nombre_categoria']}">
                                </div>
                                <div class="col-md-6 col-sm-12 align-self-center asign_huesped">
                                    <label class="form-label">Cantidad de Habitaciones</label><br>
                                    <input type="numbre" class="form-control" id="cant_habitaciones" name="cant_habitaciones" value="" >
                                </div>
                              </div>

                          </div>

                      </div>
                      <div class="modal-footer">

                          <button class="btn bg-gradient-success ms-auto mb-0 mx-4" type="submit" title="Actualizar">Actualizar</button>
                          <a class="btn bg-gradient-secondary mb-0 js-btn-prev" data-dismiss="modal" title="Prev" >Cancelar</a>

                          <!--<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                          <button type="submit" class="btn btn-primary" id="edit_habitacion">Save changes</button>-->
                      </div>
                  </form>
                </div>
          </div>
      </div>
html;
    }
     



    //tab hoteles
    $hotel = HabitacionesDao::getAll()[0];
    $fechas = $hotel['fechas'];
    $dates = '';
    $tabla_categorias = '';
    $modal_habitaciones = '';
    $th_table_fechas = '';
    $array_total_huespedes = [];
    // echo $fechas;
    $fecha = explode(",", $fechas);

    $fecha_de = $fecha[array_key_first($fecha)];
    $fecha_al = $fecha[array_key_last($fecha)];


    foreach ($fecha as $key => $value) {
      //convertir fecha a letras
      $new_date = date("d-m-Y", strtotime($value));
      $dia_en_letras = strftime("%A", strtotime($new_date));
      utf8_decode($dia_en_letras);


      $fecha_split = explode("-", $value);
      //$fecha_split[2]; // dia


      $dates .= <<<html
        <div class="col-12 col-lg-6 date">
          <label class="form-label mt-4">Fechas * </label>
          <input type="date" class="form-control " id="fecha{$key}" name="fecha[]" required="" value="{$value}">
        </div>
html;

      $th_table_fechas .= <<<html
      <th data-sortable="" style="width: 10.0774%;"><a href="#" class="dataTable-sorter">{$value}</a></th>
html;
    }

    $categoriasHabitaciones = HabitacionesDao::getCategoriasHabitaciones($hotel['id_hotel']);
    // var_dump($categoriasHabitaciones);

    foreach ($categoriasHabitaciones as $key => $value) {
      $tabla_categorias .= <<<html
            <tr>
                <td> <p class="text-xs font-weight-bold ms-2 mb-0">{$value['nombre_categoria']}</p> </td>
              
html;
      //se reinicia el array
      $array_total_huespedes = [];
      foreach ($fecha as $key => $f) {
        if ($f == $fecha[array_key_last($fecha)]) {
          $tabla_categorias .= <<<html
      <td class="font-weight-bold"> <p class="text-xs font-weight-bold ms-2 mb-0">OUT</p></td>
html;
        } else {
          array_push($array_total_huespedes, $value['total_huespedes']);
          $tabla_categorias .= <<<html
      <td class="font-weight-bold"> <p class="text-xs font-weight-bold ms-2 mb-0">{$value['total_huespedes']}</p></td>
html;
        }
      }
      $total_huespedes = array_sum($array_total_huespedes);
      $stay = $total_huespedes * $value['huespedes'];

      // var_dump($total_huespedes);
      $tabla_categorias .= <<<html
                <td class="font-weight-bold"> <p class="text-xs font-weight-bold ms-2 mb-0">{$total_huespedes}</p></td>
                <td class="font-weight-bold"> <p class="text-xs font-weight-bold ms-2 mb-0">{$value['huespedes']}</p></td>
                <td class="font-weight-bold"> <p class="text-xs font-weight-bold ms-2 mb-0">{$stay}</p></td>
                <td> <a href="#" type="button" name="id" class="btn bg-gradient-primary" data-toggle="modal" data-target="#edit-habitacion{$value['id_categoria_habitacion']}"><span class="fa fa-pencil-square-o" style="color:white" ></span> </a>  </td>
 
html;

      $modal_habitaciones .= <<<html
            <div class="modal fade" id="edit-habitacion{$value['id_categoria_habitacion']}" tabindex="-1" role="dialog" aria-labelledby="edit-habitacionLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="edit-habitacionLabel">Editar Categoria</h5>
                            <button type="button" class="btn bg-gradient-danger" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
            
                        <div class="modal-body">
                            <form class="form-horizontal" id="update_form_cat" action="" method="POST">
                            <input id="id_categoria_habitacion" name="id_categoria_habitacion"  class="form-control" type="hidden" placeholder="Sencilla" "  value="{$value['id_categoria_habitacion']}">
                                <div class="card-body pt-0">
                                    <div class="row">
                                        <div class="col-12 col-lg-6">
                                            <label class="form-label">Nombre *</label>
                                            <div class="input-group c">
                                                <select id="id_hotel" name="id_hotel" maxlength="29"  class="form-control" type="text" placeholder="Thompson" required="required" onfocus="focused(this)" onfocusout="defocused(this)" onkeyup="javascript:this.value=this.value.toUpperCase();">
                                                    <option value="" disabled>Selecciona un Hotel</option>
html;
      $hoteles = HabitacionesDao::getAll();

      foreach ($hoteles as $key => $value_cat) {
        if ($value['id_hotel' == $value_cat]) {
          $modal_habitaciones .= <<<html
                    <option value="{$value_cat['id_hotel']}" selected> {$value_cat['nombre_hotel']}</option>
html;
        } else {
          $modal_habitaciones .= <<<html
                    <option value="{$value_cat['id_hotel']}">{$value_cat['nombre_hotel']}</option>
html;
        }
      }

      $modal_habitaciones .= <<<html
                                   </select>
                                            </div>
                                        </div>
                                    </div>
            
                                    <div class="row mb-4">
                                        <div class="col-12 col-lg-6">
                                            <label class="form-label">Categoría Habitación *</label>
                                            <div class="input-group">
                                                <input id="categoria_habitacion" name="categoria_habitacion" maxlength="29"  class="form-control" type="text" placeholder="SENCILLA" required="required" onfocus="focused(this)" onfocusout="defocused(this)" value="{$value['categoria_habitacion']}" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();">
                                            </div>
                                        </div>
            
                                        <div class="col-12 col-lg-6">
                                            <label class="form-label">Nombre Categoría *</label>
                                            <div class="input-group">
                                                <input id="nombre_categoria" name="nombre_categoria" maxlength="29"  class="form-control" type="text" placeholder="Sencilla" required="required" onfocus="focused(this)" onfocusout="defocused(this)" value="{$value['nombre_categoria']}">
                                            </div>
                                        </div>
                                    </div>
            
                                    <div class="row mb-4">
                                        <div class="col-12 col-lg-6">
                                            <label class="form-label">Cupo Huéspedes *</label>
                                            <div class="input-group">
                                                <input id="huespedes" name="huespedes" maxlength="10" class="form-control" type="number" placeholder="SENCILLA" required="required" onfocus="focused(this)" onfocusout="defocused(this)" value="{$value['huespedes']}" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();">
                                            </div>
                                        </div>
            
                                        <div class="col-12 col-lg-6">
                                            <label class="form-label">Total Huéspedes *</label>
                                            <div class="input-group">
                                                <input id="total_huespedes" name="total_huespedes" maxlength="10" class="form-control" type="number" placeholder="SENCILLA" required="required" value="{$value['total_huespedes']}" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();">
                                            </div>
                                        </div>
                                    </div>
            
                                    <div class="row">
                                        <div class="button-row d-flex mt-4 col-12">
                                            <a class="btn bg-gradient-danger mb-0 js-btn-prev" data-dismiss="modal" title="Prev">Cancelar</a>
                                            <button class="btn bg-gradient-primary ms-auto mb-0" type="submit" title="Actualizar">Actualizar</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <br>
html;
    }

    // echo count($fecha);
    // echo "<br>";
    // echo $fecha[0]; 
    // echo $fecha[1]; 
    
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

    View::set('optionsCategoriaHotel', $optionsCategoriaHotel);
    View::set('optionsHotel', $optionsHotel);
    View::set('optionsCategoriaHotelHabitaciones', $optionsCategoriaHotelHabitaciones);
    View::set('tabla_asistentes', $tabla_asistentes);
    View::set('modal_asigna_habitacion', $modal_asigna_habitacion);
    View::set('modal_habitaciones', $modal_habitaciones);
    View::set('modal_edit_habitacion', $modal_edit_habitacion);
    View::set('hotel', $hotel);
    View::set('dates', $dates);
    View::set('fecha_de', $fecha_de);
    View::set('fecha_al', $fecha_al);
    View::set('tabla_habitaciones', $tabla_habitaciones);
    View::set('tabla_categorias', $tabla_categorias);
    View::set('th_table_fechas', $th_table_fechas);
    View::set('fecha_inicio_evento', $fecha_inicio_evento);
    View::set('fecha_fin_evento', $fecha_fin_evento);
    View::set('asideMenu',$this->_contenedor->asideMenu());
    View::set('header', $this->_contenedor->header());
    View::set('footer', $this->_contenedor->footer());
    View::render("habitaciones_all");
  }

  public function CrearHabitacion()
  {
    $data = new \stdClass();

    $hotel = $_POST['hotel'];
    $categoria_habitacion = $_POST['cat_habitacion'];
    $administrador = $_SESSION['utilerias_administradores_id'];
    $cant_habitaciones = $_POST['cant_habitaciones'];


    $data->_hotel = $hotel;
    $data->_categoria_habitacion = $categoria_habitacion;
    $data->_administrador = $administrador;
    $data->_cant_habitaciones = $cant_habitaciones;

    $id = HabitacionesDao::insert($data);
    if ($id) {
      echo "success";
    } else {
      echo "fail";
    }
  }

  public function Actualizar()
  {
    $documento = new \stdClass();


    if ($_SERVER['REQUEST_METHOD'] == 'POST') {


      $id_hotel = $_POST['id_hotel'];
      $cliente = $_POST['cliente'];
      $evento = $_POST['evento'];
      $lugar = $_POST['lugar'];
      $total_habitaciones = $_POST['total_habitaciones'];
      $nombre_hotel = $_POST['nombre_hotel'];
      $fechas = $_POST['fecha'];
      $fechas_ = implode(",", $fechas);


      $documento->_id_hotel = $id_hotel;
      $documento->_cliente = $cliente;
      $documento->_evento = $evento;
      $documento->_lugar = $lugar;
      $documento->_total_habitaciones = $total_habitaciones;
      $documento->_nombre_hotel = $nombre_hotel;
      $documento->_fechas = $fechas_;

      $update = HabitacionesDao::update($documento);

      if ($update) {

        echo 'success';
      } else {
        echo 'fail';
      }
    } else {
      echo 'fail REQUEST';
    }
  }

  public function ActualizarCategoria()
  {
    $documento = new \stdClass();

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

      $id_categoria_habitacion = $_POST['id_categoria_habitacion'];
      // $id_hotel = $_POST['id_hotel'];
      $categoria_habitacion = $_POST['categoria_habitacion'];
      $nombre_categoria = $_POST['nombre_categoria'];
      $huespedes = $_POST['huespedes'];
      $total_huespedes = $_POST['total_huespedes'];

      $documento->_id_categoria_habitacion = $id_categoria_habitacion;
      // $documento->_id_hotel = $id_hotel;
      $documento->_categoria_habitacion = $categoria_habitacion;
      $documento->_nombre_categoria = $nombre_categoria;
      $documento->_huespedes = $huespedes;
      $documento->_total_huespedes = $total_huespedes;

      $update = HabitacionesDao::updateCategoria($documento);

      if ($update) {
        echo 'success';
      } else {
        echo 'fail';
      }
    } else {
      echo 'fail REQUEST';
    }
  }

  public function BuscarHabitacion()
  {
    $no_habitacion = $_POST['no_habitacion'];

    $seacrh_habitacion = HabitacionesDao::BuscarHabitacion($no_habitacion)[0];

    if ($seacrh_habitacion) {

      $data = [
        'status' => 'encontrado',
        'msg' => 'Este numero de habitacion ya esta registrado'
      ];
    } else {
      $data = [
        'status' => 'no se encontro'
      ];
    }

    echo json_encode($data);
  }


  public function BuscaHabitacion()
  {
    $no_habitacion = $_POST['no_habitacion'];

    $search = HabitacionesDao::BuscaHabitacion($no_habitacion)[0];

    if ($search) {

      $data = [
        'status' => 'success',
        'msg' => 'Este numero de habitacion ya esta registrado'
      ];
    } else {
      $data = [
        'status' => 'error'
      ];
    }

    echo json_encode($data);
  }

  public function BuscaHabitacionCheckin()
  {
    $no_habitacion = $_POST['no_habitacion'];
    $categoria_habitacion = $_POST['categoria_habitacion'];

    $msg = '';
    $color = '';

    //contar registros de habitaciones por numero de habitacion
    $search = HabitacionesDao::BuscaHabitacionCountCheckin($no_habitacion,$categoria_habitacion)[0];
    

    if($search['total'] > 0 ){
      $getCategoriaHabitacion = HabitacionesDao::getCategoriasHabitacionesById($search['id_categoria_habitacion'])[0];
    }    

    if($getCategoriaHabitacion){

      if($getCategoriaHabitacion['huespedes'] > $search['total']){
        $msg = 'Habitación con espacio';
        $color = 'green';
      }else{
        $msg = 'Habitación llena';
        $color = 'red';
      }
  
    }


    if ($search) {

      $data = [
        'status' => 'success',
        'msg' => $msg,
        'color' => $color 
      ];
    } else {
      $data = [
        'status' => 'error'
      ];
    }

    echo json_encode($data);
  }

  public function searchAsistentes()
  {
    $asistente = $_POST['asistente'];


    if (isset($asistente) && !empty($asistente)) {
      $Asistente = AsistentesDao::getUsuarioByName($asistente);

      echo json_encode($Asistente);
    }
  }

  public function categoriaHabitacion()
  {
    $cat_habitacion = $_POST['cat_habitacion'];


    if (isset($cat_habitacion) && !empty($cat_habitacion)) {
      $asistentes = AsistentesDao::getAllRegisterSinHabitacion();
      $habitacion = HabitacionesDao::getCategoriasHabitacionesById($cat_habitacion)[0];

      $data = [
        'categoria_habitacion' => $habitacion,
        'asistentes' => $asistentes
      ];
      echo json_encode($data);
    }
  }


  public function AsignarHabitacion()
  {
    // echo $_POST['asistente_name'];
    $cont = 0;

    $documento = new \stdClass();

    $id_categoria_habitacion = $_POST['asigna_cat_habitacion'];
    $asistente_name = $_POST['asistente_name'];
    $id_administrador = $_SESSION['utilerias_administradores_id'];
    $clave = $this->generateRandomString();
    $fecha_in = $_POST['date_in'];
    $fecha_out = $_POST['date_out'];
    $comentarios = $_POST['comentarios'];
    $numero_habitacion = $_POST['numero_habitacion'];


    $documento->_id_categoria_habitacion = $id_categoria_habitacion;
    $documento->_id_administrador = $id_administrador;
    $documento->_clave = $clave;

    //$id = HabitacionesDao::insertAsignaHabitacion($documento);

    foreach ($asistente_name as $key => $value) {

      $documento->_id_registro_acceso = $value;
      $documento->_fecha_in = $fecha_in[$key];
      $documento->_fecha_out = $fecha_out[$key];
      $documento->_comentarios = $comentarios[$key];
      $documento->_numero_habitacion = $numero_habitacion[$key];
      $id = HabitacionesDao::insertAsignaHabitacion($documento);
      $cont++;

      // echo $value;
    }
    if ($cont > 0) {
      echo 'success';
    }
  }

  public function UpdateHabitacion()
  {
    $id_asigna_habitacion = $_POST['id_asigna_habitacion'];
    $numero_habitacion = $_POST['num_habitacion'];
    $documento = new \stdClass();


    $documento->_id_asigna_habitacion = $id_asigna_habitacion;
    $documento->_numero_habitacion = $numero_habitacion;


    $update = HabitacionesDao::updateHabitacionUsuario($documento);
    if ($update) {
      echo 'success';
    }else{
      echo 'fail';
    }
  }

  public function quitarUsuarioHabitacion()
  {
    $id_ah = $_POST['id_ah'];

    $delete = HabitacionesDao::deleteAsignaHabitacion($id_ah);
    if ($delete) {
      echo "success";
    } else {
      echo "fail";
    }
  }

  public function agregarUsusarioHabitacion()
  {
    $documento = new \stdClass();
    
    $clave_ah = $_POST['clave_ah'];
    $asigna_habitacion = HabitacionesDao::getAsignaHabitacionByClave($clave_ah)[0];


    $id_categoria_habitacion = $asigna_habitacion['id_categoria_habitacion'];
    $id_asistente = $_POST['id_asistente'];
    $fecha_in = $_POST['date_in'];
    $fecha_out = $_POST['date_out'];
    $numero_habitacion = $_POST['numero_habitacion'];
    $comentarios = $_POST['comentarios'];
    $id_administrador = $_SESSION['utilerias_administradores_id'];

    $documento->_id_categoria_habitacion = $id_categoria_habitacion;
    $documento->_id_administrador = $id_administrador;
    $documento->_clave = $clave_ah;
    $documento->_id_registro_acceso = $id_asistente;
    $documento->_fecha_in = $fecha_in;
    $documento->_fecha_out = $fecha_out;
    $documento->_numero_habitacion = $numero_habitacion;
    $documento->_comentarios = $comentarios;

    $id = HabitacionesDao::insertAsignaHabitacion($documento);

    if ($id) {
      echo "success";
    } else {
      "fail";
    }
  }

  public function getAsistenteId()
  {
    $id_asis = $_POST['id_asis'];
    $registro_acceso = AsistentesDao::getIdRegistroAcceso($id_asis)[0];
    $pase_abordar = PasesDao::getByIdUser($registro_acceso['utilerias_asistentes_id'])[0];
    $asistentes = AsistentesDao::getAllRegisterSinHabitacionSelect($registro_acceso['id_registro_acceso']);


    if (!empty($pase_abordar) || !is_null($pase_abordar)) {
      $respuesta = [
        'pase' => $pase_abordar,
        'msg' => 'Se encontro tu pase de abordar',
        'asistentes' => $asistentes,
        'status' => 'success'
      ];
    } else {
      $respuesta = [
        'pase' => $pase_abordar,
        'msg' => 'No se ha cargado el vuelo',
        'asistentes' => $asistentes,
        'status' => 'error'
      ];
    }

    echo json_encode($respuesta);
  }


  public function editarHabitacion(){

    //total de habitaciones ocupadas
    $id_categoria_habitacion = $_POST['id_categoria_habitacion'];
    $cant_habitaciones = $_POST['cant_habitaciones'];

    $total_habitaciones = $_POST['total_habitaciones'];
    $habitaciones_disponibles = $_POST['habitaciones_disponibles'];
    $habitaciones_ocupadas = $_POST['habitaciones_ocupadas'];


    if($cant_habitaciones < $habitaciones_ocupadas){
      $data = [
        'status' => 'error',
        'msg' => 'Tienes '.$habitaciones_ocupadas.' habitaciones ocupadas, no puedes reducir la cantidad'
      ];

      echo json_encode($data);
      
    }else{
      $documento = new \stdClass();
    
      $documento->_id_categoria_habitacion = $id_categoria_habitacion;
      $documento->_cant_habitaciones = $cant_habitaciones;

      $update = HabitacionesDao::updateHabitacionesHotel($documento);

      if($update){
        $data = [
          'status' => 'success',
          'msg' => '¡Se actualizo la información correctamente!!'
        ];
        echo json_encode($data);
        //echo 'success';
      }else{
        $data = [
          'status' => 'fail',
          'msg' => '¡Ocurrio un error, contactar a Soporte técnico!!'
        ];
        echo json_encode($data);
        //echo 'fail';
      }
      
    }
  }

  function generateRandomString($length = 6)
  {
    return substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, $length);
  }
}
