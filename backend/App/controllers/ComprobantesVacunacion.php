<?php
namespace App\controllers;
defined("APPPATH") OR die("Access denied");

use \Core\View;
use \Core\MasterDom;
use \App\controllers\Contenedor;
use \Core\Controller;
use \App\models\ComprobantesVacunacion as ComprobantesVacunacionDao;
use \App\models\Linea as LineaDao;
use \App\models\Asistentes as AsistentesDao;

class ComprobantesVacunacion extends Controller{

    private $_contenedor;

    function __construct(){
        parent::__construct();
        $this->_contenedor = new Contenedor;
        View::set('header',$this->_contenedor->header());
        View::set('footer',$this->_contenedor->footer());
    }

    public function getUsuario(){
      return $this->__usuario;
    }

    public function index() {
     $extraHeader =<<<html
      <style>
        .logo{
          width:100%;
          height:150px;
          margin: 0px;
          padding: 0px;
        }
      </style>
html;

      $btnVacunacionEditarHidden = (Controller::getPermisosUsuario($this->__usuario, "seccion_vacunacion", 5) == 0) ? "style=\"display:none;\"" : "";

      $tabla = '';
      $tabla_no_v = '';
      $tabla_rechazados = '';

      $permisos = Controller::getPermisoGlobalUsuario($this->__usuario)[0];
      
      if($permisos['permisos_globales'] == 1 || $permisos['permisos_globales'] == 5){
        $comprobantes = ComprobantesVacunacionDao::getAll();
      }else{
        $id_linea = LineaDao::getLineaByAdmin($_SESSION['utilerias_administradores_id'])[0];
        // var_dump($id_linea['utilerias_administradores_id']);
        $comprobantes = ComprobantesVacunacionDao::getComprobatesByLinea($id_linea['id_linea_ejecutivo']);
      }


      foreach ($comprobantes as $key => $value) {

        if ($value['status_comprobante'] == 0) {
          
          // print('asdasdasdadas');
          $tabla_rechazados .= <<<html
            <tr>
              <td class="text-center">
                <span class="badge badge-danger"> <i class="fas fa-times"> </i> Rechazado</span> <br>
                <span class="badge badge-secondary">Folio <i class="fas fa-hashtag"> </i> {$value['id_c_v'] }</span>
                 <hr>
                 <p class="text-sm font-weight-bold mb-0 "><span class="fa fas fa-user-tie" style="font-size: 13px;"></span><b> Ejecutivo Asignado a Línea: </b><br><span class="fas fa-suitcase"> </span> {$value['nombre_ejecutivo']} <span class="badge badge-success" style="background-color:  {$value['color']}; color:white "><strong>{$value['nombre_linea_ejecutivo']}</strong></span></p>
                    
              </td>
              <td>
                  <h6 class="mb-0 text-sm"> <span class="fas fa-user-md"> </span>  {$value['nombre_completo']}</h6>
                  <p class="text-sm font-weight-bold mb-0 "><span class="fa fa-business-time" style="font-size: 13px;"></span><b> Bu: </b>{$value['nombre_bu']}</p>
                    <p class="text-sm font-weight-bold mb-0 "><span class="fa fa-pills" style="font-size: 13px;"></span><b> Linea Principal: </b>{$value['nombre_linea']}</p>
                    <p class="text-sm font-weight-bold mb-0 "><span class="fa fa-hospital" style="font-size: 13px;"></span><b> Posición: </b>{$value['nombre_posicion']}</p>

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
                              <!--<iframe src="https://www.convencionasofarma2022.mx/comprobante_vacunacion/{$value['documento']}" style="width:100%; height:700px;" frameborder="0" >
                              </iframe>-->
                            </div>
                          </div>
                          <div class="col-md-4 col-12">
                            <div class="card card-body mb-4">
                              <h5>Datos Personales</h5>
                              <div class="mb-2">
                                <h6 class="fas fa-user"> </h6>
                                <span> <b>Nombre:</b> {$value['nombre_completo']}</span>
                                <span class="badge badge-danger">Rechazado</span>
                              </div>
                              <div class="mb-2">
                                <h6 class="fas fa-address-card"> </h6>
                                <span> <b>Número de empleado:</b> {$value['numero_empleado']}</span>
                              </div>
                              <div class="mb-2">
                                <h6 class="fas fa-business-time"> </h6>
                                <span> <b>Bu:</b> {$value['nombre_bu']}</span>
                              </div>
                              <div class="mb-2">
                                <h6 class="fas fa-pills"> </h6>
                                <span> <b>Línea:</b> {$value['nombre_linea']}</span>
                              </div>
                              <div class="mb-2">
                                <h6 class="fas fa-hospital"> </h6>
                                <span> <b>Posición:</b> {$value['nombre_posicion']}</span>
                              </div>
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
                          $tabla_rechazados .=<<<html
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
                        }else{
                          $tabla_rechazados .=<<<html
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
                        $tabla_rechazados .=<<<html
                            </div>
                          </div>
                        </div>
                      </div>
                  </div>
              </div>
            </div>
html;
        } else {

          $id_linea = $value['id_linea_principal'];
          // $encargado = AsistentesDao::getEncargadoLinea($id_linea);

          if ($value['validado'] == 1) {
            $tabla .= <<<html
              <tr>
                <td class="text-center">
                  <span class="badge badge-success"><i class="fas fa-check"> </i> Aprobado</span> <br>
                  <span class="badge badge-secondary">Folio <i class="fas fa-hashtag"> </i> {$value['id_c_v'] }</span>
                   <hr>
                   <p class="text-sm font-weight-bold mb-0 "><span class="fa fas fa-user-tie" style="font-size: 13px;"></span><b> Ejecutivo Asignado a Línea: </b><br><span class="fas fa-suitcase"> </span> {$value['nombre_ejecutivo']} <span class="badge badge-success" style="background-color:  {$value['color']}; color:white "><strong>{$value['nombre_linea_ejecutivo']}</strong></span></p>
                            
                </td>
                <td>
                  <h6 class="mb-0 text-sm"> <span class="fas fa-user-md"> </span>  {$value['nombre_completo']}</h6>
                  <p class="text-sm font-weight-bold mb-0 "><span class="fa fa-business-time" style="font-size: 13px;"></span><b> Bu: </b>{$value['nombre_bu']}</p>
                    <p class="text-sm font-weight-bold mb-0 "><span class="fa fa-pills" style="font-size: 13px;"></span><b> Linea Principal: </b>{$value['nombre_linea']}</p>
                    <p class="text-sm font-weight-bold mb-0 "><span class="fa fa-hospital" style="font-size: 13px;"></span><b> Posición: </b>{$value['nombre_posicion']}</p>

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
                            <!--<iframe src="https://www.convencionasofarma2022.mx/comprobante_vacunacion/{$value['documento']}" style="width:100%; height:700px;" frameborder="0" >
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
                            <div class="mb-2">
                              <h6 class="fas fa-address-card"> </h6>
                              <span> <b>Número de empleado:</b> {$value['numero_empleado']}</span>
                            </div>
                            <div class="mb-2">
                              <h6 class="fas fa-business-time"> </h6>
                              <span> <b>Bu:</b> {$value['nombre_bu']}</span>
                            </div>
                            <div class="mb-2">
                              <h6 class="fas fa-pills"> </h6>
                              <span> <b>Línea:</b> {$value['nombre_linea']}</span>
                            </div>
                            <div class="mb-2">
                              <h6 class="fas fa-hospital"> </h6>
                              <span> <b>Posición:</b> {$value['nombre_posicion']}</span>
                            </div>
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
                          $tabla .=<<<html
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
                        }else{
                          $tabla .=<<<html
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
                        $tabla .=<<<html
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
html;
          }
  
          if ($value['validado'] == 0) {
            $tabla_no_v .= <<<html
            
              <tr>
                <td class="text-center">
                  <span class="badge badge-warning text-dark"><i class="fas fa-clock"></i> Pendiente</span><br>
                  <span class="badge badge-secondary">Folio <i class="fas fa-hashtag"> </i> {$value['id_c_v'] }</span>
                   <hr>
                   <p class="text-sm font-weight-bold mb-0 "><span class="fa fas fa-user-tie" style="font-size: 13px;"></span><b> Ejecutivo Asignado a Línea: </b><br><span class="fas fa-suitcase"> </span> {$value['nombre_ejecutivo']} <span class="badge badge-success" style="background-color:  {$value['color']}; color:white "><strong>{$value['nombre_linea_ejecutivo']}</strong></span></p>
                    
                </td>
                <td>
                  <h6 class="mb-0 text-sm"> <span class="fas fa-user-md"> </span>  {$value['nombre_completo']}</h6>
                  <p class="text-sm font-weight-bold mb-0 "><span class="fa fa-business-time" style="font-size: 13px;"></span><b> Bu: </b>{$value['nombre_bu']}</p>
                    <p class="text-sm font-weight-bold mb-0 "><span class="fa fa-pills" style="font-size: 13px;"></span><b> Linea Principal: </b>{$value['nombre_linea']}</p>
                    <p class="text-sm font-weight-bold mb-0 "><span class="fa fa-hospital" style="font-size: 13px;"></span><b> Posición: </b>{$value['nombre_posicion']}</p>

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
                                
                              </div>
                            </div>
                            <div class="col-md-4 col-12">
                              <div class="card card-body mb-4">
                                <h5>Datos Personales</h5>
                                <div class="mb-2">
                                  <h6 class="fas fa-user"> </h6>
                                  <span> <b>Nombre:</b> {$value['nombre_completo']}</span>
                                  <span class="badge badge-warning"><i class="fas fa-clock"></i> Pendiente</span>
                                </div>
                                <div class="mb-2">
                                  <h6 class="fas fa-address-card"> </h6>
                                  <span> <b>Número de empleado:</b> {$value['numero_empleado']}</span>
                                </div>
                                <div class="mb-2">
                                  <h6 class="fas fa-business-time"> </h6>
                                  <span> <b>Bu:</b> {$value['nombre_bu']}</span>
                                </div>
                                <div class="mb-2">
                                  <h6 class="fas fa-pills"> </h6>
                                  <span> <b>Línea:</b> {$value['nombre_linea']}</span>
                                </div>
                                <div class="mb-2">
                                  <h6 class="fas fa-hospital"> </h6>
                                  <span> <b>Posición:</b> {$value['nombre_posicion']}</span>
                                </div>
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
                              <h5 class="mb-2">Notas</h5>
html;

              if ($value['nota'] != '') {
                $tabla_no_v .=<<<html
                  <div class="editar_section" id="editar_section">
                    <p id="">
                      {$value['nota']}
                    </p>
                    <button id="editar_nota" type="button" class="btn bg-gradient-primary w-50 editar_nota" >
                      Editar
                    </button>
                  </div>

                  <div class="hide-section editar_section_textarea" id="editar_section_textarea">
                    <form class="form-horizontal guardar_nota_pendiente" id="guardar_nota_pendiente" action="" method="POST">
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
              }else{
                $tabla_no_v .=<<<html
                  <p>
                    {$value['nota']}
                  </p>
                  <form class="form-horizontal guardar_nota_pendiente" id="guardar_nota_pendiente" action="" method="POST">
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

              $tabla_no_v .= <<<html
                                
                                
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="pt-4 modal-footer">
                          <div class="row text-center">
                            <div class="col-md-6 col-12">
                              <form class="form-horizontal btn_validar" id="" action="" method="POST">
                                <input type="text" id="id_comprobante" name="id_comprobante" value="{$value['id_c_v']}" readonly style="display:none;" hidden>
                                <input type="text" id="id_asistente" name="id_asistente" value="{$value['utilerias_asistentes_id']}" readonly style="display:none;" hidden>
                                <button type="submit" class="btn bg-gradient-success" {$btnVacunacionEditarHidden}>
                                  Aceptar
                                </button>
                              </form>
                            </div>
                            <div class="col-md-6 col-12">
                              <form class="form btn_rechazar" id="btn_rechazar" action="" method="POST">
                                <input type="text" id="id_comprobante" name="id_comprobante" value="{$value['id_c_v']}" readonly style="display:none;">
                                <input type="text" id="id_asistente" name="id_asistente" value="{$value['utilerias_asistentes_id']}" readonly style="display:none;" hidden>
                                <button type="submit" class="btn bg-gradient-secondary" {$btnVacunacionEditarHidden} >
                                  Rechazar
                                </button>
                              </form>
                            </div>
                            
                          </div>
                        </div>
                    </div>
                    
                </div>
              </div>
html;
          }
        }      
    }

      $extraFooter =<<<html

      <script src="http://cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js" defer></script>
      <link rel="stylesheet" href="http://cdn.datatables.net/1.11.4/css/jquery.dataTables.min.css" />

      <script src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js" defer></script>
      <link rel="stylesheet" href="https://cdn.datatables.net/1.11.4/css/jquery.dataTables.min.css" />
      
      <script>
        $(document).ready(function() {
    
            $(".btn_validar").on("submit", function(event) {
                event.preventDefault();
    
                var formData = $(this).serialize();
                console.log(formData);
                // for (var value of formData.values()) {
                //     console.log(value);
                // }
    
                $.ajax({
                    url: CoCobroEnSitio          type: "POST",
                    data: formData,
                    beforeSend: function() {
                        console.log("Procesando....");
                    },
                    success: function(respuesta) {
                        console.log(respuesta);
                        if (respuesta == 'success') {
                            swal("¡Se validó correctamente el comprobante!", "", "success").
                            then((value) => {
                                window.location.replace(CobroEnSitio);
        CobroEnSitio;
                        } else {
                            swal("¡No se pudo validar correctamente el comprobante!", "", "warning").
                            then((value) => {
                                window.location.replace(CobroEnSitio)
                       CobroEnSitio           }
                    },
                    error: function(respuesta) {
                        console.log(respuesta);
                    }
    
                });
            });
    
            $(".btn_rechazar").on("submit", function(event) {
                event.preventDefault();
    
                var formData = $(this).serialize();
                console.log(formData);
    
                $.ajax({
                    url: CobroEnSitio,
                    type: "POST",
   CobroEnSitio formData,
                    beforeSend: function() {
                        console.log("Procesando....");
                    },
                    success: function(respuesta) {
                        console.log(respuesta);
                        if (respuesta == 'success') {
                            swal("¡Se rechazó correctamente el comprobante!", "", "success").
                            then((value) => {
                                window.location.replace(CobroEnSitio);
                            });
                        } CobroEnSitio             swal("¡No se pudo rechazar correctamente el comprobante!", "", "warning").
                            then((value) => {
                                window.location.replace(CobroEnSitio)
                            });
                        }
               CobroEnSitio      error: function(respuesta) {
                        console.log(respuesta);
                    }
    
                });
            });

            $(".guardar_nota").on("submit", function(event) {
              event.preventDefault();
  
              var formData = $(this).serialize();
              console.log(formData);
  
              $.ajax({
                  url: CobroEnSitio,
                  type: "POST",
                  data: formData,
                  befCobroEnSitio                      console.log("Procesando....");
                  },
                  success: function(respuesta) {
                      console.log(respuesta);
                      if (respuesta == 'success') {
                          swal("¡Se guardó correctamente la nota!", "", "success").
                          then((value) => {
                              window.location.replace(CobroEnSitio);
                          });
                          var ta = document.getElementById("nota");
             CobroEnSitioribute('disabled','');
  
                          // var btn_cancelar = document.getElementById('cancelar_editar_nota');
                          // btn_cancelar.setAttribute('hidden','');

                          $('.cancelar_editar_nota').attr('hidden');

                          // var btn_guardar = document.getElementById('guardar_editar_nota');
                          // btn_guardar.setAttribute('hidden','');

                          $('.guardar_editar_nota').attr('hidden');
  
                      } else {
                          swal("¡No se pudo guardar correctamente la nota!", "", "warning").
                          then((value) => {
                              //window.location.replace("/ComprobantesVacunacion/")
                          });
                      }
                  },
                  error: function(resCobroEnSitio          console.log(respuesta);
                  }
  
              });
          });

          $(".guardar_nota_pendiente").on("submit", function(event) {
            event.preventDefault();

            var formData = $(this).serialize();
            console.log(formData);

            $.ajax({
                url: CobroEnSitio,
                type: "POST",
                data: formData,
                beforeSend: function() {
                    conCobroEnSitio..");
                },
                success: function(respuesta) {
                    console.log(respuesta);
                    if (respuesta == 'success') {
                        swal("¡Se guardó correctamente la nota!", "", "success").
                        then((value) => {
                            // window.location.replace("/ComprobantesVacunacion/");
                        });
                        var ta = document.getElementById("nota");
                        ta.setAttribute('dCobroEnSitio                 // var btn_cancelar = document.getElementById('cancelar_editar_nota');
                        // btn_cancelar.setAttribute('hidden','');

                        $('.cancelar_editar_nota').attr('hidden');

                        // var btn_guardar = document.getElementById('guardar_editar_nota');
                        // btn_guardar.setAttribute('hidden','');

                        $('.guardar_editar_nota').attr('hidden');

                    } else {
                        swal("¡No se pudo guardar correctamente la nota!", "", "warning").
                        then((value) => {
                            // window.location.replace("/ComprobantesVacunacion/")
                        });
                    }
                },
                error: function(respuesta) {
                    conCobroEnSitio               }

            });
        });
  
          $(".editar_nota").on("click", function(event) {
            console.log('Holaa');
              $('.editar_section').addClass('hide-section').removeClass('show-section');
              $('.editar_section_textarea').addClass('show-section').removeClass('hide-section');
          });
  
          $(".cancelar_editar_nota").on("click", function(event) {
              $('.editar_section_textarea').addClass('hide-section').removeClass('show-section');
              $('.editar_section').addClass('show-section').removeClass('hide-section');
              console.log('Holaa');
          });

          $(".btn_iframe").on("click",function(){
            var documento = $(this).attr('data-document');
            var modal_id = $(this).attr('data-target');
          
            if($(modal_id+" iframe").length == 0){
                $(modal_id+" .iframe").append('<iframe src="https://www.convencionasofarma2022.mx/comprobante_vacunacion/'+documento+'" style="width:100%; height:700px;" frameborder="0" ></iframe>');
            }          
          });

          $('#table_pendientes').DataTable({
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

          $('#table_rechazado').DataTable({
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

          $('#table_aprobado').DataTable({
            "drawCallback": function( settings ) {
            $('.current').addClass("btn bg-gradient-danger btn-rounded").removeClass("paginate_button");
            $('.paginate_button').addClass("btn").removeClass("paginate_button");
            $('.dataTables_length').addClass("m-4");
            $('.dataTables_info').addClass("mx-4");
            $('.dataTables_filter').addClass("m-4");
            $('input').addClass("form-control").css('border-radius: 10px;');
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
      $id_linea = LineaDao::getLineaByAdmin($_SESSION['utilerias_administradores_id'])[0];


      //-----------------------------//
      if($permisos['permisos_globales'] == 1 || $permisos['permisos_globales'] == 5){
        $comprobantes_validos = ComprobantesVacunacionDao::contarComprobantesValidos();
      }
      else{
        $comprobantes_validos = ComprobantesVacunacionDao::contarComprobantesValidosByLine($id_linea['id_linea_ejecutivo']);
      }
      
      foreach ($comprobantes_validos[0] as $key => $value) {
        $numero_validos = $value;
      }

      //----------------------------//

      if($permisos['permisos_globales'] == 1 || $permisos['permisos_globales'] == 5){
        $asistentes_total = ComprobantesVacunacionDao::contarAsistentes();
      }else{
        $asistentes_total = ComprobantesVacunacionDao::contarAsistentesByLine($id_linea['id_linea_ejecutivo']);
      }

      
      foreach ($asistentes_total[0] as $key => $value) {
        $numero_asistentes = $value;
      }

       //-----------------------------//
      if($permisos['permisos_globales'] == 1 || $permisos['permisos_globales'] == 5){
        $comprobantes_total = ComprobantesVacunacionDao::contarComprobantesTotales();
      }else{
        $comprobantes_total = ComprobantesVacunacionDao::contarComprobantesTotalesByLine($id_linea['id_linea_ejecutivo']);
      }
      foreach ($comprobantes_total[0] as $key => $value) {
        $numero_comprobantes = $value;
      }
      //-----------------------------//

      //-----------------------------//

      if($permisos['permisos_globales'] == 1 || $permisos['permisos_globales'] == 5){
        $comprobantes_sin_revisar = ComprobantesVacunacionDao::contarComprobantesPorRevisar();
      }else{
        $comprobantes_sin_revisar = ComprobantesVacunacionDao::contarComprobantesPorRevisarByLine($id_linea['id_linea_ejecutivo']);
      }
      
      foreach ($comprobantes_sin_revisar[0] as $key => $value) {
        $numero_sin_revisar = $value;
      }
      //-----------------------------//

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
   
     

    View::set('comprobantes',$comprobantes);
    View::set('numero_sin_revisar',$numero_sin_revisar);
    View::set('numero_comprobantes',$numero_comprobantes);
    View::set('numero_asistentes',$numero_asistentes);
    View::set('numero_validos',$numero_validos);
    View::set('tabla',$tabla);
    View::set('tabla_no_v',$tabla_no_v);
    View::set('tabla_rechazados',$tabla_rechazados);
    View::set('header',$this->_contenedor->header($extraHeader));
    View::set('footer',$this->_contenedor->footer($extraFooter));
    View::render("comprobantesvacunacion_all");
  }

    public function Validar(){

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
          $documento = new \stdClass();

            $id_comprobante = $_POST['id_comprobante'];
            $id_asistente = $_POST['id_asistente'];

            $documento->_id_comprobante_vacuna = $id_comprobante;
            $documento->_id_asistente = $id_asistente;

            $id = ComprobantesVacunacionDao::validar($documento);

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

    public function Rechazar(){

      if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $documento = new \stdClass();
        $id_comprobante = $_POST['id_comprobante'];
        $id_asistente = $_POST['id_asistente'];
        
        $documento->_id_comprobante_vacuna = $id_comprobante;
        $documento->_id_asistente = $id_asistente;

        $comprobante = ComprobantesVacunacionDao::getComprobanteById($id_comprobante)[0];

        $ua_id = $comprobante['utilerias_asistentes_id'];
        $fecha_carga_doc = $comprobante['fecha_carga_documento'];
        $numero_dosis = $comprobante['numero_dosis'];
        $marca_dosis = $comprobante['marca_dosis'];
        $nota = $comprobante['nota'];
        $documento_prueba = $comprobante['doc'];

        $id = ComprobantesVacunacionDao::rechazar($documento);
        ComprobantesVacunacionDao::insertLog($ua_id,$fecha_carga_doc,$numero_dosis,$marca_dosis,$documento_prueba,$nota);

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

    public function GuardarNota(){


      $documento = new \stdClass();


        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $id_comprobante_vacuna = $_POST['id_comprobante_vacuna'];
            $nota = $_POST['nota'];

            $documento->_id_comprobante_vacuna = $id_comprobante_vacuna;
            $documento->_nota = $nota;

            $id = ComprobantesVacunacionDao::updateNote($documento);


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
}
