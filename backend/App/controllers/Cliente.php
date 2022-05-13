<?php
namespace App\controllers;
defined("APPPATH") OR die("Access denied");

use \Core\View;
use \Core\MasterDom;
use \App\controllers\Contenedor;
use \App\models\Cliente AS ClienteDao;

class Cliente{

    private $_contenedor;

    function __construct(){
        $this->_contenedor = new Contenedor;
        View::set('header',$this->_contenedor->header());
        View::set('footer',$this->_contenedor->footer());
    }

    public function index() {
        $extraHeader =<<<html
html;
        $extraFooter =<<<html
html;
        View::set('header',$this->_contenedor->header($extraHeader));
        View::set('footer',$this->_contenedor->footer($extraFooter));
        View::render("clientes_all");
    }


    public function alerta($id, $parametro){
      $regreso = "/Cliente/";

      if($parametro == 'add'){
        $mensaje = "Se ha agregado correctamente";
      }else{
        if($parametro == 'edit'){
          $mensaje = "Se ha modificado correctamente";
        }else{
          if($parametro == 'delete'){
            $mensaje = "Se ha eliminado correctamente";
          }
        }
      }

      if($id){
        $class = "success";
      }else{
        $class = "error";
        $mensaje = "Ha ocurrido un problema ".$id;
      }
      View::set('class',$class);
      View::set('regreso',$regreso);
      View::set('mensaje',$mensaje);
      View::set('header',$this->_contenedor->header($extraHeader));
      View::set('footer',$this->_contenedor->footer($extraFooter));
      View::render("alerta");
    }
}
