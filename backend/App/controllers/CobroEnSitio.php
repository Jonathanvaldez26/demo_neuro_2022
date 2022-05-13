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

class CobroEnSitio extends Controller{

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

      $permisos = Controller::getPermisoGlobalUsuario($this->__usuario)[0];

      $extraFooter =<<<html

      <script src="http://cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js" defer></script>
      <link rel="stylesheet" href="http://cdn.datatables.net/1.11.4/css/jquery.dataTables.min.css" />

      <script src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js" defer></script>
      <link rel="stylesheet" href="https://cdn.datatables.net/1.11.4/css/jquery.dataTables.min.css" />
      
      <script>

      </script>
  
html;


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

    View::set('asideMenu',$this->_contenedor->asideMenu());
    View::set('footer',$this->_contenedor->footer($extraFooter));
    View::render("pagosensitio_all");
  }

}
