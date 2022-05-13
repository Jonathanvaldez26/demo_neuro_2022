<?php
namespace App\controllers;
defined("APPPATH") OR die("Access denied");

use \Core\View;
use \Core\MasterDom;
use \App\controllers\Contenedor;
use \Core\Controller;
use \App\models\Cliente AS ClienteDao;
use \App\models\Administradores AS AdministradoresDao;

class Usuario extends Controller{

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
        
html;
        $extraFooter =<<<html
         <script>
        $(document).ready(function(){
          $.validator.addMethod("verificarPassword",
                    function(value, element) {
                        var result = false;
                        $.ajax({
                            type:"POST",
                            async: false,
                            url: "/Usuario/validarPassword", // funcion para validar la contraseña
                            data: {
                                pwd_actual: function() {
                                    return $("#pwd_actual").val();
                            }},
                            success: function(data) {
                                console.log("success::: " + data);
                                result = (data == "1") ? true : false;
                                if(result == true){
                                    $('#availability').html('<span class="text-success glyphicon glyphicon-ok"></span><span> </span>');
                                    $('#register').attr("disabled", true);
                                }else{
                                    $('#availability').html('<span class="text-danger glyphicon glyphicon-remove"></span>');
                                    $('#register').attr("disabled", false);
                                }
                            }
                        }); 
                        return result;
                    },
                    "La contraseña no es correcta"
          );

          $("#add").validate({
            rules:{
              pwd_actual:{
                required: true,
                verificarPassword: true
              },
              pwd_nueva:{
                required: true
              },
              pwd_nueva_repetir:{
                required: true,
                equalTo: "#pwd_nueva"
              }
            },
            messages:{
              pwd_actual:{
                required: "Este campo es requerido"
              },
              pwd_nueva:{
                required: "Este campo es requerido"
              },
              pwd_nueva_repetir:{
                required: "Este campo es requerido",
                equalTo: "Las contraseñas deben ser iguales"
              }
            }
          });//fin del jquery validate
          
          $("#mostrar").click(function(){
            $('.cambio_password').show(500,function() {
            });
          });

          

        });//fin del document.ready
      </script>
html;
        $usuario = $this->__usuario;
        $datosUsuario = AdministradoresDao::getUserDatos($usuario);
        View::set('usuario',$datosUsuario);
        View::set('header',$this->_contenedor->header($extraHeader));
        View::set('footer',$this->_contenedor->footer($extraFooter));
        View::render("usuario_all");
    }

    public function cambioPassword(){
      $pwd = new \stdClass();
      $pwdActual = MasterDom::getDataAll('pwd_actual');
      $pwd->_pwdActual = $pwdActual;
      
      $pwdNueva1 = MD5(MasterDom::getDataAll('pwd_nueva'));
      $pwdNueva2 = MD5(MasterDom::getDataAll('pwd_nueva_repetir'));
      $pwd->_pwd_nueva = MasterDom::getDataAll('pwd_nueva');
      $pwd->_usuario = $this->getUsuario();
      
      if(AdministradoresDao::updateNuevaContrasenia($pwd)>0) $this->alerta("success_edit");
      else  $this->alerta("danger");
      

    }

    public function validarPassword(){
      echo (AdministradoresDao::getPwdActual(MD5($_POST['pwd_actual']))>0)?"1":"2";
    }

    public function logout(){
        session_start();
        session_unset();
        session_destroy();
        header("Location:/login&?login=1");
    }


    public function alerta($parametro){
      $regreso = "/Usuario/";

      if($parametro == 'add'){
        $mensaje = "Se ha agregado correctamente";
        $class = "success";
      }elseif($parametro == 'error_pwd'){
        $mensaje = "Tu contraseña actual no es correcta";
        $class = "success";
      }elseif($parametro == 'success_edit'){
        $mensaje = "Se ha modificado la contraseña";
        $class = "success";
        $redireccion = header("refresh: 1; url = /Usuario/logout");
        View::set('redireccion',$redireccion);
      }elseif($parametro == 'danger'){
        $mensaje = "Al parecer hay un error";
        $class = "danger";
      }
      
      View::set('class',$class);
      View::set('redireccion',$redireccion);
      View::set('regreso',$regreso);
      View::set('mensaje',$mensaje);
      View::set('header',$this->_contenedor->header($extraHeader));
      View::set('footer',$this->_contenedor->footer($extraFooter));
      View::render("alerta");
    }
}
