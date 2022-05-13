<?php
namespace App\controllers;
defined("APPPATH") OR die("Access denied");

use \Core\View;
use \Core\Controller;
use \App\models\Vuelos as VuelosDao;
use \App\models\Linea as LineaDao;
use \App\controllers\Mailer;

class PickUpLahe extends Controller{

    private $_contenedor;

    function __construct(){
        parent::__construct();
        $this->_contenedor = new Contenedor;
        View::set('header',$this->_contenedor->header());
        View::set('footer',$this->_contenedor->footer());
        if(Controller::getPermisosUsuario($this->__usuario, "seccion_vuelos",1) == 0)
            header('Location: /Principal/');
    }

    public function getUsuario(){
        return $this->__usuario;
    }

    public function index() {
        $extraHeader =<<<html
     <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
     <link href="//cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
html;

        $extraFooter =<<<html
        <script>
          $(document).ready(function(){
            $('#pickup-list').DataTable({
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

        $permisos = Controller::getPermisoGlobalUsuario($this->__usuario)[0];

        //  $vuelos = VuelosDao::getAllLlegada();
        if($permisos['permisos_globales'] == 1 || $permisos['permisos_globales'] == 5){
            $vuelos = VuelosDao::getAllLlegada();
        }else{
            $id_linea = LineaDao::getLineaByAdmin($_SESSION['utilerias_administradores_id'])[0];
            // var_dump($id_linea['id_linea_ejecutivo']);
            $vuelos = VuelosDao::getLlegadaByLinea($id_linea['id_linea_ejecutivo']);
        }
        //  var_dump($id_linea);
        $tabla= '';
//      foreach ($vuelos as $key => $value) {
//             $tabla.= <<<html
//             <tr>
//                  <td>
//                       <div class="d-flex px-3 py-1">
//                           <div class="d-flex flex-column justify-content-center">
//                               <h6 class="mb-0 text-sm"><span class="fa fa-user-md" style="font-size: 13px"></span> {$value['nombre']} <span class="badge badge-sm bg-gradient-success"> Activo</span></h6>
//                               <p class="text-sm font-weight-bold text-secondary mb-0"><span class="fa fa-calendar" style="font-size: 13px"></span> {$value['fecha_alta']}</p>
//                               <p class="text-sm mb-0"><span class="fa fa-plane" style="color: #125a16; font-size: 13px"></span> {$value['aeropuerto_llegada']}</p>
//                               <p class="text-sm mb-0"><span class="fa fa-flag" style="color: #353535; font-size: 13px"></span> {$value['aeropuerto_salida']}</p>
//                               <p class="text-sm mb-0"><span class="fa fa-ticket" style="color: #1a8fdd; font-size: 13px"></span> Número de Vuelo: <strong>{$value['numero_vuelo']}</strong></p>
//                               <p class="text-sm mb-0"><span class="fa fa-clock-o" font-size: 13px"></span> Hora Estimada de Llegada: {$value['hora_llegada_destino']}</p>
//                               <hr>
//                               <p class="text-sm font-weight-bold text-secondary mb-0"><span class="fa fa-sticky-note" style="font-size: 13px"></span> {$value['nota']}</p>
//                           </div>
//                       </div>
//                  </td>
//                  <td>
//                       <div class="d-flex px-3 py-1">
//                           <div class="d-flex flex-column justify-content-center">
//                               <u><a href="mailto:{$value['email']}"><h6 class="mb-0 text-sm"><span class="fa fa-mail-bulk" style="font-size: 13px"></span> {$value['email']}</h6></a></u>
//                               <u><a href="https://api.whatsapp.com/send?phone=52{$value['telefono']}&text=Buen%20d%C3%ADa,%20te%20contacto%20de%20parte%20del%20Equipo%20Grupo%20LAHE%20%F0%9F%98%80" target="_blank"><p class="text-sm font-weight-bold text-secondary mb-0"><span class="fa fa-whatsapp" style="font-size: 13px; color:green;"></span> {$value['telefono']}</p></a></u>
//                           </div>
//                       </div>
//                  </td>
//                  <td class="align-middle text-center text-sm">
//                      <p class="text-sm font-weight-bold mb-0 text-dark">{$value['nombre_registro']}</p><span class="badge badge-info" style="background-color: {$value['color']}; color: white;">{$value['nombre_linea_ejecutivo']}</span>

//                  </td>
//                 <td style="text-align:center; vertical-align:middle;">
//                     <a href="https://www.admin.convencionasofarma2022.mx/comprobante_vuelo_uno/{$value['link']}" data-bs-toggle="tooltip" data-bs-placement="bottom" title="" data-bs-original-title="Ver .PDF Pase de Abordar"><i class="fa fa-eye"></i></a>
//                 </td>

//             </tr>
// html;
//         }

        //  $vuelos = VuelosDao::getAllSalida();

        if($permisos['permisos_globales'] == 1 || $permisos['permisos_globales'] == 5){
            $vuelos_salida = VuelosDao::getAllSalida();
        }else{
            $id_linea = LineaDao::getLineaByAdmin($_SESSION['utilerias_administradores_id'])[0];
            // var_dump($id_linea['id_linea_ejecutivo']);
            $vuelos_salida = VuelosDao::getSalidaByLinea($id_linea['id_linea_ejecutivo']);
        }
        $tabla1= '';
        foreach ($vuelos_salida as $key => $value) {
            $tabla1.= <<<html
            <tr>
                 <td>
                      <div class="d-flex px-3 py-1">
                          <div class="d-flex flex-column justify-content-center">
                              <h6 class="mb-0 text-sm"><span class="fa fa-user-md" style="font-size: 13px"></span> {$value['nombre']} <span class="badge badge-sm bg-gradient-success"> Activo</span> </h6>
                              <p class="text-sm font-weight-bold text-secondary mb-0"><span class="fa fa-calendar" style="font-size: 13px"></span> {$value['fecha_alta']}</p>
                              <p class="text-sm mb-0"><span class="fa fa-plane" style="color: #125a16; font-size: 13px"></span> {$value['aeropuerto_llegada']}</p>
                              <p class="text-sm mb-0"><span class="fa fa-flag" style="color: #353535; font-size: 13px"></span> {$value['aeropuerto_salida']}</p>
                              <p class="text-sm mb-0"><span class="fa fa-ticket" style="color: #1a8fdd; font-size: 13px"></span> Número de Vuelo: <strong>{$value['numero_vuelo']}</strong></p>
                              <p class="text-sm mb-0"><span class="fa fa-clock-o" font-size: 13px"></span> Hora Estimada de Llegada: {$value['hora_llegada_destino']}</p>
                              <hr>
                              <p class="text-sm font-weight-bold text-secondary mb-0"><span class="fa fa-sticky-note" style="font-size: 13px"></span> {$value['nota']}</p>
                          </div>
                      </div>
                 </td>
                 <td>
                      <div class="d-flex px-3 py-1">
                          <div class="d-flex flex-column justify-content-center">
                              <u><a href="mailto:{$value['email']}"><h6 class="mb-0 text-sm"><span class="fa fa-mail-bulk" style="font-size: 13px"></span> {$value['email']}</h6></a></u>
                              <u><a href="https://api.whatsapp.com/send?phone=52{$value['telefono']}&text=Buen%20d%C3%ADa,%20te%20contacto%20de%20parte%20del%20Equipo%20Grupo%20LAHE%20%F0%9F%98%80" target="_blank"><p class="text-sm font-weight-bold text-secondary mb-0"><span class="fa fa-whatsapp" style="font-size: 13px; color:green;"></span> {$value['telefono']}</p></a></u>
                          </div>
                      </div>
                 </td>
                 <td class="align-middle text-center text-sm">
                     <p class="text-sm font-weight-bold mb-0 text-dark">{$value['nombre_registro']}</p><span class="badge badge-info" style="background-color: {$value['color']}; color: white;">{$value['nombre_linea_ejecutivo']}</span>
                 </td>
                 <td style="text-align:center; vertical-align:middle;">
                    <a href="https://www.admin.convencionasofarma2022.mx/comprobante_vuelo_dos/{$value['link']}" data-bs-toggle="tooltip" data-bs-placement="bottom" title="" data-bs-original-title="Ver .PDF Pase de Abordar"><i class="fa fa-eye"></i></a>
                </td>
                 
            </tr>
html;
        }


        $permisos = Controller::getPermisoGlobalUsuario($this->__usuario)[0];

        if($permisos['permisos_globales'] == 1 || $permisos['permisos_globales'] == 5){
            $itienerarios = VuelosDao::getItinerarios();
        }else{
            $id_linea = LineaDao::getLineaByAdmin($_SESSION['utilerias_administradores_id'])[0];
            $itienerarios = VuelosDao::getItinerariosByLinea($id_linea['id_linea_ejecutivo']);
        }

        //$itienerarios = VuelosDao::getItinerarios();
        $tabla_itinerarios = '';

        foreach ($itienerarios as $key => $value) {
            if ($value['aerolinea_escala_origen'] != NULL || $value['aerolinea_escala_destino'] != NULL || $value['aeropuerto_escala_salida'] != NULL || $value['aeropuerto_escala_regreso'] != NULL) {
                $tabla_itinerarios .=<<<html
        <tr>
            <td class="text-center">
                <span class="badge badge-secondary">Folio <i class="fas fa-hashtag"> </i> {$value['id_itinerario'] }</span>
                  <span class="badge badge-success">CON escala</span>
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
                  
                  <h6 class="mb-0 text-sm"> <span class="fa fa-plane"> </span> {$value['aeropuerto_salida']}</h6>
                  <h6 class="mb-0 text-sm"> <span class="fa fa-paper-plane"> </span> AEROLÍNEA: {$value['aerolinea_origen']}</h6>
                  <h6 class="mb-0 text-sm"> <span class="fa fa-calendar"> </span>: {$value['fecha_salida']}</h6>
                  <h6 class="mb-0 text-sm"> <span class="fa fa-clock"> </span>: {$value['hora_salida']}</h6>
html;
                if($value['aeropuerto_escala_salida'] != NULL){
                    $tabla_itinerarios .=<<<html
                  <hr>
                  <span class="badge badge-success">Escala</span><br>
                  <h6 class="mb-0 text-sm"> <span class="fa fa-plane"> </span> {$value['aeropuerto_escala_salida']}</h6>
                  <h6 class="mb-0 text-sm"> <span class="fa fa-paper-plane"> </span> AEROLÍNEA: {$value['aerolinea_escala_origen']}</h6>
                  <h6 class="mb-0 text-sm"> <span class="fa fa-calendar"> </span>: {$value['fecha_escala_salida']}</h6>
                  <h6 class="mb-0 text-sm"> <span class="fa fa-clock"> </span>: {$value['hora_escala_salida']}</h6>
html;
                }
                $tabla_itinerarios .=<<<html
                </div>
            </td> 
             <td>
                  
                  <h6 class="mb-0 text-sm"> <span class="fa fa-plane"> </span> {$value['aeropuerto_regreso']}</h6>
                  <h6 class="mb-0 text-sm"> <span class="fa fa-paper-plane"> </span> AEROLÍNEA: {$value['aerolinea_destino']}</h6>
                  <h6 class="mb-0 text-sm"> <span class="fa fa-calendar"> </span>: {$value['fecha_regreso']}</h6>
                  <h6 class="mb-0 text-sm"> <span class="fa fa-clock"> </span>: {$value['hora_regreso']}</h6>
html;
                if($value['aeropuerto_escala_regreso'] != NULL){
                    $tabla_itinerarios .=<<<html
                  <hr>
                  <span class="badge badge-success">Escala</span><br>
                  <h6 class="mb-0 text-sm"> <span class="fa fa-plane"> </span> {$value['aeropuerto_escala_regreso']}</h6>
                  <h6 class="mb-0 text-sm"> <span class="fa fa-paper-plane"> </span> AEROLÍNEA: {$value['aerolinea_escala_destino']}</h6>
                  <h6 class="mb-0 text-sm"> <span class="fa fa-calendar"> </span>: {$value['fecha_escala_regreso']}</h6>
                  <h6 class="mb-0 text-sm"> <span class="fa fa-clock"> </span>: {$value['hora_escala_regreso']}</h6>
                    
html;
                }

                $tabla_itinerarios .=<<<html
                  </div>
            </td> 
             <td>
                {$value['fecha_registro']}
            </td>
        </tr>
        
html;
            } else {
                $tabla_itinerarios .=<<<html
        <tr>
            <td class="text-center">
                <span class="badge badge-secondary">Folio <i class="fas fa-hashtag"> </i> {$value['id_itinerario'] }</span>
                <span class="badge badge-primary">Sin escala</span>
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
                  <h6 class="mb-0 text-sm"> <span class="fa fa-plane"> </span> {$value['aeropuerto_salida']}</h6>
                  <h6 class="mb-0 text-sm"> <span class="fa fa-paper-plane"> </span> AEROLÍNEA: {$value['aerolinea_origen']}</h6>
                  <h6 class="mb-0 text-sm"> <span class="fa fa-calendar"> </span>: {$value['fecha_salida']}</h6>
                  <h6 class="mb-0 text-sm"> <span class="fa fa-clock"> </span>: {$value['hora_salida']} - Formato 24 horas</h6>
            </td> 
             <td>
                  <h6 class="mb-0 text-sm"> <span class="fa fa-plane"> </span> {$value['aeropuerto_regreso']}</h6>
                  <h6 class="mb-0 text-sm"> <span class="fa fa-paper-plane"> </span> AEROLÍNEA: {$value['aerolinea_destino']}</h6>
                  <h6 class="mb-0 text-sm"> <span class="fa fa-calendar"> </span>: {$value['fecha_regreso']}</h6>
                  <h6 class="mb-0 text-sm"> <span class="fa fa-clock"> </span>: {$value['hora_regreso']} - Formato 24 horas</h6>
             
            </td> 
             <td>
                {$value['fecha_registro']}
            </td>
        </tr>
        
html;
            }


        }

        $id_linea = LineaDao::getLineaByAdmin($_SESSION['utilerias_administradores_id'])[0];

        // var_dump($id_linea);

        $totalvuelos = '';
        foreach (VuelosDao::getCountVuelos() as $key => $value)
        {
            $totalvuelos  = $value['usuarios'];
        }

        $totalvueloscargadosllegada = '';
        foreach (VuelosDao::getCountVuelosLlegada() as $key => $value)
        {
            $totalvueloscargadosllegada  = $value['total'];
        }

        $totalvueloscargadossalida = '';
        foreach (VuelosDao::getCountVuelosSalida() as $key => $value)
        {
            $totalvueloscargadossalida  = $value['total'];
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

        View::set('aerolineas', $this->getAerolineas());
        View::set('aeropuertos', $this->getAeropuertosAll());
        View::set('asistentesItinerartio', $this->getAsistentesItinerario());


        View::set('idAsistente',$this->getAsistentes());
        View::set('idAsistenteSalida',$this->getAsistentesSalida());
        View::set('idAeropuertoOrigen',$this->getAeropuertosOrigen());
        View::set('idAeropuertoDestino',$this->getAeropuertosDestino());
        View::set('idOrigenEscala',$this->getAeropuertosDestino());
        View::set('tabla',$tabla);
        View::set('tabla1',$tabla1);
        View::set('tabla_itinerarios',$tabla_itinerarios);
        View::set('totalvuelos',$totalvuelos);
        View::set('totalvueloscargadossalida',$totalvueloscargadossalida);
        View::set('totalvueloscargadosllegada',$totalvueloscargadosllegada);
        View::set('header',$this->_contenedor->header($extraHeader));
        View::set('footer',$extraFooter);
        View::render("vuelos_all");
    }

    public function uploadVueloUno(){


        $documento = new \stdClass();

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $utilerias_asistentes_id = $_POST['id_asistente'];
            $documento->_utilerias_asistentes_id = $utilerias_asistentes_id;

            $utilerias_administradores_id = $_POST["user_"];
            $documento->_utilerias_administradores_id = $utilerias_administradores_id;

            $clave = $this->generateClave();
            $documento->_clave = $clave;

            $id_aeropuerto_origen = $_POST['id_origen'];
            $documento->_id_aeropuerto_origen = $id_aeropuerto_origen;

            $id_aeropuerto_destino = $_POST['id_destino'];
            $documento->_id_aeropuerto_destino = $id_aeropuerto_destino;

            $numero_vuelo = $_POST['numero_vuelo'];
            $documento->_numero_vuelo = $numero_vuelo;

            $hora_llegada = $_POST['hora_llegada'];
            $documento->_hora_llegada = $hora_llegada;

            //Escala

            $id_aeropuerto_origen_escala = $_POST['id_origen_escala'];
            $documento->_id_aeropuerto_origen_escala = $id_aeropuerto_origen_escala;

            $id_aeropuerto_destino_escala = $_POST['id_destino_escala'];
            $documento->_id_aeropuerto_destino_escala = $id_aeropuerto_destino_escala;

            $numero_vuelo_escala = $_POST['numero_vuelo_escala'];
            $documento->_numero_vuelo_escala = $numero_vuelo_escala;

            $hora_llegada_escala = $_POST['hora_llegada_escala'];
            $documento->_hora_llegada_escala = $hora_llegada_escala;

            $file = $_FILES["file_"];
            $pdf = $this->generateRandomString();
            move_uploaded_file($file["tmp_name"], "comprobante_vuelo_uno/".$pdf.'.pdf');

            $documento->_url = $pdf.'.pdf';

            $notas = $_POST['notas'];

            $email = VuelosDao::getAsistentebyUAId($utilerias_asistentes_id)[0]['email'];
            $nombre = VuelosDao::getAsistentebyUAId($utilerias_asistentes_id)[0]['nombre_completo'];

            // echo $email;
            // echo $utilerias_asistentes_id;
            // exit;

            $msg = [
                'name' => $nombre,
                'email' => $email,
                'url'=>'https://www.admin.convencionasofarma2022.mx/comprobante_vuelo_uno/'.$pdf.'.pdf'
            ];

            if($notas == '')
            {
                $notas = 'Sin Notas';
                $documento->_notas = $notas;
            }
            else
            {
                $notas = $_POST['notas'];
                $documento->_notas = $notas;
            }

            $id = VuelosDao::insert($documento);

            if ($id) {

                $mailer = new Mailer();
                $mailer->mailVuelos($msg);
                echo 'success';

            } else {
                echo 'fail';
            }
        } else {
            echo 'fail REQUEST';
        }
    }

    public function uploadVueloDos(){


        $documento = new \stdClass();

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $utilerias_asistentes_id = $_POST['id_asistente_salida'];
            $documento->_utilerias_asistentes_id = $utilerias_asistentes_id;

            $utilerias_administradores_id = $_POST["user_salida"];
            $documento->_utilerias_administradores_id = $utilerias_administradores_id;

            $clave = $this->generateClave();
            $documento->_clave = $clave;

            $id_aeropuerto_origen = $_POST['id_origen_salida'];
            $documento->_id_aeropuerto_origen = $id_aeropuerto_origen;

            $id_aeropuerto_destino = $_POST['id_destino_salida'];
            $documento->_id_aeropuerto_destino = $id_aeropuerto_destino;

            $numero_vuelo = $_POST['numero_vuelo_salida'];
            $documento->_numero_vuelo = $numero_vuelo;

            $hora_llegada = $_POST['hora_llegada_salida'];
            $documento->_hora_llegada = $hora_llegada;

            //Escala

            $id_aeropuerto_origen_escala = $_POST['id_origen_escala_salida'];
            $documento->_id_aeropuerto_origen_escala = $id_aeropuerto_origen_escala;

            $id_aeropuerto_destino_escala = $_POST['id_destino_escala_salida'];
            $documento->_id_aeropuerto_destino_escala = $id_aeropuerto_destino_escala;

            $numero_vuelo_escala = $_POST['numero_vuelo_escala_salida'];
            $documento->_numero_vuelo_escala = $numero_vuelo_escala;

            $hora_llegada_escala = $_POST['hora_llegada_escala_salida'];
            $documento->_hora_llegada_escala = $hora_llegada_escala;

            $file = $_FILES["file_salida"];
            $pdf = $this->generateRandomString();
            move_uploaded_file($file["tmp_name"], "comprobante_vuelo_dos/".$pdf.'.pdf');

            $documento->_url = $pdf.'.pdf';

            $notas = $_POST['notas'];

            $email = VuelosDao::getAsistentebyUAId($utilerias_asistentes_id)[0]['email'];
            $nombre = VuelosDao::getAsistentebyUAId($utilerias_asistentes_id)[0]['nombre_completo'];

            // echo $email;
            // echo $utilerias_asistentes_id;
            // exit;

            $msg = [
                'name' => $nombre,
                'email' => $email,
                'url'=>'https://www.admin.convencionasofarma2022.mx/comprobante_vuelo_dos/'.$pdf.'.pdf'
            ];

            if($notas == '')
            {
                $notas = 'Sin Notas';
                $documento->_notas = $notas;
            }
            else
            {
                $notas = $_POST['notas_salida'];
                $documento->_notas = $notas;
            }

            $id = VuelosDao::insertSalida($documento);

            if ($id) {

                // $mailer = new Mailer();
                // $mailer->mailVuelosRegreso($msg);
                echo 'success';

            } else {
                echo 'fail';
            }
        } else {
            echo 'fail REQUEST';
        }
    }

    function generateRandomString($length = 10) {
        return substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, $length);
    }

    function generateClave($length = 6) {
        return substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, $length);
    }

    public function getAsistentes(){
        $asistentes = '';
        foreach (VuelosDao::getAsistenteNombre() as $key => $value) {
            $asistentes .=<<<html
        <option value="{$value['utilerias_asistentes_id']}"> {$value['nombre']}</option>
html;
        }
        return $asistentes;
    }

    public function getAsistentesSalida(){
        $asistentes = '';
        foreach (VuelosDao::getAsistenteNombreSalida() as $key => $value) {
            $asistentes .=<<<html
        <option value="{$value['utilerias_asistentes_id']}"> {$value['nombre']}</option>
html;
        }
        return $asistentes;
    }

    public function getAsistentesItinerario(){
        $asistentes = '';
        foreach (VuelosDao::getAsistenteNombreItinerario($_SESSION['utilerias_administradores_id']) as $key => $value) {
            $asistentes .=<<<html
            <option value="{$value['utilerias_asistentes_id']}">{$value['nombre']}</option>
html;
        }
        return $asistentes;
    }

    public function getAeropuertosOrigen(){
        $aeropuertos = '';
        foreach (VuelosDao::getAeropuertoOrigen() as $key => $value) {
            $aeropuertos .=<<<html
      <option value="{$value['id_aeropuerto']}"> {$value['iata']} - {$value['aeropuerto']}</option>
html;
        }
        return $aeropuertos;
    }

    public function getAeropuertosDestino(){
        $aeropuertos = '';
        foreach (VuelosDao::getAeropuertoDestino() as $key => $value) {
            $aeropuertos .=<<<html
      <option value="{$value['id_aeropuerto']}"> {$value['iata']} - {$value['aeropuerto']}</option>
html;
        }
        return $aeropuertos;
    }

    public function getAeropuertosAll(){
        $aeropuertos = '';
        foreach (VuelosDao::getAeropuertosAll() as $key => $value) {
            $aeropuertos .=<<<html
      <option value="{$value['id_aeropuerto']}"> {$value['iata']} - {$value['aeropuerto']}</option>
html;
        }
        return $aeropuertos;
    }

    public function getAerolineas(){
        $aerolineas = '';
        foreach (VuelosDao::getAerolineas() as $key => $value) {
            $aerolineas .=<<<html
      <option value="{$value['id_aerolinea']}"> {$value['nombre']} </option>
html;
        }
        return $aerolineas;
    }

    public function itinerario(){

        $documento = new \stdClass();

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $utilerias_asistentes_id = $_POST['id_asistente'];
            $documento->_utilerias_asistentes_id = $utilerias_asistentes_id;

            $asistente_name = VuelosDao::getAsistenteNombreItinerarioById($utilerias_asistentes_id)[0];
            $documento->_nombre_asistente = $asistente_name['nombre'];

            $msg = [
                'name' => $asistente_name['nombre'],
                'email' => $asistente_name['usuario']
            ];

            $utilerias_administradores_id = $_POST["user_"];
            $documento->_utilerias_administradores_id = $utilerias_administradores_id;


            $aerolinea_origen = $_POST['aerolinea_origen'];
            $documento->_aerolinea_origen = $aerolinea_origen;

            if(isset($_POST['aerolinea_escala_origen'])){
                $aerolinea_escala_origen = $_POST['aerolinea_escala_origen'];
            }else{
                $aerolinea_escala_origen = '';
            }
            $documento->_aerolinea_escala_origen = $aerolinea_escala_origen;

            if(isset($_POST['aerolinea_escala_destino'])){
                $aerolinea_escala_destino = $_POST['aerolinea_escala_destino'];
            }else{
                $aerolinea_escala_destino = '';
            }


            $documento->_aerolinea_escala_destino = $aerolinea_escala_destino;

            $aerolinea_destino = $_POST['aerolinea_destino'];
            $documento->_aerolinea_destino = $aerolinea_destino;

            $fecha_salida = $_POST['fecha_salida'];
            $documento->_fecha_salida = $fecha_salida;

            if(isset($_POST['fecha_escala_salida'])){
                $fecha_escala_salida = $_POST['fecha_escala_salida'];
            }else{
                $fecha_escala_salida = '';
            }
            $documento->_fecha_escala_salida = $fecha_escala_salida;

            if(isset($_POST['fecha_escala_regreso'])){
                $fecha_escala_regreso = $_POST['fecha_escala_regreso'];
            }else{
                $fecha_escala_regreso = '';
            }
            $documento->_fecha_escala_regreso = $fecha_escala_regreso;

            $hora_salida = $_POST['hora_salida'];
            $documento->_hora_salida = $hora_salida;


            if(isset($_POST['hora_escala_salida'])){
                $hora_escala_salida = $_POST['hora_escala_salida'];
            }else{
                $hora_escala_salida = '';
            }
            $documento->_hora_escala_salida = $hora_escala_salida;

            if(isset($_POST['hora_escala_regreso'])){
                $hora_escala_regreso = $_POST['hora_escala_regreso'];
            }else{
                $hora_escala_regreso = '';
            }
            $documento->_hora_escala_regreso = $hora_escala_regreso;

            $fecha_regreso = $_POST['fecha_regreso'];
            $documento->_fecha_regreso = $fecha_regreso;

            $hora_regreso = $_POST['hora_regreso'];
            $documento->_hora_regreso = $hora_regreso;

            $aeropuerto_salida = $_POST['aeropuerto_salida'];
            $documento->_aeropuerto_salida = $aeropuerto_salida;


            if(isset($_POST['aeropuerto_escala_salida'])){
                $aeropuerto_escala_salida = $_POST['aeropuerto_escala_salida'];
            }else{
                $aeropuerto_escala_salida = '';
            }
            $documento->_aeropuerto_escala_salida = $aeropuerto_escala_salida;

            if(isset($_POST['aeropuerto_escala_regreso'])){
                $aeropuerto_escala_regreso = $_POST['aeropuerto_escala_regreso'];
            }else{
                $aeropuerto_escala_regreso = '';
            }
            $documento->_aeropuerto_escala_regreso = $aeropuerto_escala_regreso;

            $aeropuerto_regreso = $_POST['aeropuerto_regreso'];
            $documento->_aeropuerto_regreso = $aeropuerto_regreso;

            $nota_itinerario = $_POST['nota_itinerario'];
            $documento->_nota_itinerario = $nota_itinerario;


            if($nota_itinerario == '')
            {
                $nota_itinerario = 'Sin Notas';
                $documento->_nota_itinerario = $nota_itinerario;
            }
            else
            {
                $nota_itinerario = $_POST['nota_itinerario'];
                $documento->_nota_itinerario = $nota_itinerario;
            }

            $id = VuelosDao::insertItinerario($documento);

            if ($id) {

                $mailer = new Mailer();
                $mailer->mailer($msg);
                echo 'success';

            } else {
                echo 'fail';
            }
        } else {
            echo 'fail REQUEST';
        }

    }

}
