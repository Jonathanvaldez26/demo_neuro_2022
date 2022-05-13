<?php
namespace App\controllers;
defined("APPPATH") OR die("Access denied");

use \Core\View;
use \Core\Controller;
use \App\models\Linea as LineaDao;

class Lineas extends Controller{

    private $_contenedor;

    function __construct(){
        parent::__construct();
        $this->_contenedor = new Contenedor;
        View::set('header',$this->_contenedor->header());
        View::set('footer',$this->_contenedor->footer());
        if(Controller::getPermisosUsuario($this->__usuario, "seccion_lineas",1) == 0)
          header('Location: /Principal/');
    }

    public function getUsuario(){
      return $this->__usuario;
    }

    public function index() {
     $extraHeader =<<<html

html;

     $lineas = LineaDao::getAll();
     $tabla= '';
     foreach ($lineas as $key => $value) {
            $tabla.=<<<html
                <tr>
                  <!--td><input type="checkbox" name="borrar[]" value="{$value['clave']}"/></td-->
                  <td><h6 class="mb-0 text-sm">{$value['nombre']}</h6></td>
            
                  <td><p class="text-sm text-secondary mb-0">{$value['fecha_alta']}</p></td>
                  <td><h6 class="mb-0 text-sm">{$value['creo']}</h6></td>
                  <td><h6 class="mb-0 text-sm">{$value['nombre_bu']}</h6></td>
                </tr>
html;
        }

      $extraFooter =<<<html
        <script>
          $(document).ready(function(){
            $('#linea-list').DataTable({
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
      $permisoGlobalHidden = (Controller::getPermisoGlobalUsuario($this->__usuario)[0]['permisos_globales']) != 1 ? "style=\"display:none;\"" : "";
      $asistentesHidden = (Controller::getPermisosUsuario($this->__usuario, "seccion_asistentes", 1)==0)? "style=\"display:none;\"" : "";  
      $vuelosHidden = (Controller::getPermisosUsuario($this->__usuario, "seccion_vuelos", 1)==0)? "style=\"display:none;\"" : "";  
      $pickUpHidden = (Controller::getPermisosUsuario($this->__usuario, "seccion_pickup", 1)==0)? "style=\"display:none;\"" : "";
      $habitacionesHidden = (Controller::getPermisosUsuario($this->__usuario, "seccion_habitaciones", 1)==0)? "style=\"display:none;\"" : ""; 
      $cenasHidden = (Controller::getPermisosUsuario($this->__usuario, "seccion_cenas", 1)==0)? "style=\"display:none;\"" : ""; 
      $cenasHidden = (Controller::getPermisosUsuario($this->__usuario, "seccion_cenas", 1)==0)? "style=\"display:none;\"" : ""; 
      $aistenciasHidden = (Controller::getPermisosUsuario($this->__usuario, "seccion_asistencias", 1)==0)? "style=\"display:none;\"" : ""; 
      $vacunacionHidden = (Controller::getPermisosUsuario($this->__usuario, "seccion_vacunacion", 1)==0)? "style=\"display:none;\"" : ""; 
      $pruebasHidden = (Controller::getPermisosUsuario($this->__usuario, "seccion_pruebas_covid", 1)==0)? "style=\"display:none;\"" : "";
      $configuracionHidden = (Controller::getPermisosUsuario($this->__usuario, "seccion_configuracion", 1)==0)? "style=\"display:none;\"" : "";
      $utileriasHidden = (Controller::getPermisosUsuario($this->__usuario, "seccion_utilerias", 1)==0)? "style=\"display:none;\"" : "";  

      View::set('permisoGlobalHidden',$permisoGlobalHidden);
      View::set('asistentesHidden',$asistentesHidden);
      View::set('vuelosHidden',$vuelosHidden);
      View::set('pickUpHidden',$pickUpHidden);
      View::set('habitacionesHidden',$habitacionesHidden);
      View::set('cenasHidden',$cenasHidden);
      View::set('aistenciasHidden',$aistenciasHidden);
      View::set('vacunacionHidden',$vacunacionHidden);
      View::set('pruebasHidden',$pruebasHidden);
      View::set('configuracionHidden',$configuracionHidden);
      View::set('utileriasHidden',$utileriasHidden);

      View::set('tabla',$tabla);
      View::set('header',$this->_contenedor->header($extraHeader));
      View::set('footer',$this->_contenedor->footer($extraFooter));
      View::render("lineas_all");
    }

}
