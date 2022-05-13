<?php
namespace App\controllers;
defined("APPPATH") OR die("Access denied");

use \Core\View;
use \Core\MasterDom;
use \App\controllers\Contenedor;
use \Core\Controller;
use \App\models\Log as LogDao;

class Log extends Controller{

    private $_contenedor;

    function __construct(){
        parent::__construct();
        $this->_contenedor = new Contenedor;
        View::set('header',$this->_contenedor->header());
        View::set('footer',$this->_contenedor->footer());

        // if(Controller::getPermisosUsuario($this->__usuario, "permisos_globales",1) == 0)
        //   header('Location: /Principal/');
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

      $log = LogDao::getAll();
      $tabla = '';
     
      foreach ($log as $key => $value) {
      
      $tabla.=<<<html
      <tr>
        <td>{$value['fecha']}</td>
        <td>{$value['usuario']}</td>
        <td class="text-center">{$value['descripcion']}</td>
        <td class="text-center">{$value['accion']}</td>
      </tr>
 
html;
      }
      View::set('header',$this->_contenedor->header($extraHeader));
      View::set('footer',$this->_contenedor->footer($extraFooter));
      View::set('tabla',$tabla);
      View::render("log_all");
    }

}
