<?php

namespace App\controllers;

defined("APPPATH") or die("Access denied");

use \Core\View;
use \Core\MasterDom;
use \App\controllers\Contenedor;
use \App\models\Login AS LoginDao;

require_once dirname(__DIR__) . '/../public/librerias/fpdf/fpdf.php';

class Login
{
    private $_contenedor;

    public function index()
    {
        $extraHeader = <<<html
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link rel="apple-touch-icon" sizes="76x76" href="/assets/img/favicon.png">
        <link rel="icon" type="image/png" href="/img/favicon.png">
        <title>
            GRUPO LAHE
        </title>
        <!--     Fonts and icons     -->
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
        <!-- Nucleo Icons -->
        <link href="/assets/css/nucleo-icons.css" rel="stylesheet" />
        <link href="/assets/css/nucleo-svg.css" rel="stylesheet" />
        <!-- Font Awesome Icons -->
        <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
        <link href="/assets/css/nucleo-svg.css" rel="stylesheet" />
        <!-- CSS Files -->
        <link id="pagestyle" href="/assets/css/soft-ui-dashboard.css?v=1.0.5" rel="stylesheet" />
        <link rel="stylesheet" href="/css/alertify/alertify.core.css" />
        <link rel="stylesheet" href="/css/alertify/alertify.default.css" id="toggleCSS" />
        
        <script charset="UTF-8" src="//web.webpushs.com/js/push/9d0c1476424f10b1c5e277f542d790b8_1.js" async></script>

html;
        $extraFooter =<<<html
        <script src="/js/jquery.min.js"></script>
        <script src="/js/validate/jquery.validate.js"></script>
        <script src="/js/alertify/alertify.min.js"></script>
        <!-- -------- END FOOTER 3 w/ COMPANY DESCRIPTION WITH LINKS & SOCIAL ICONS & COPYRIGHT ------- -->
        <!--   Core JS Files   -->
        <script src="/assets/js/core/popper.min.js"></script>
        <script src="/assets/js/core/bootstrap.min.js"></script>
        <script src="/assets/js/plugins/perfect-scrollbar.min.js"></script>
        <script src="/assets/js/plugins/smooth-scrollbar.min.js"></script>
        <!-- Kanban scripts -->
        <script src="/assets/js/plugins/dragula/dragula.min.js"></script>
        <script src="/assets/js/plugins/jkanban/jkanban.js"></script>
        <script>
            var win = navigator.platform.indexOf('Win') > -1;
            if (win && document.querySelector('#sidenav-scrollbar')) {
                var options = {
                    damping: '0.5'
                }
                Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
            }
        </script>
        <!-- Github buttons -->
        <script async defer src="https://buttons.github.io/buttons.js"></script>
        <!-- Control Center for Soft Dashboard: parallax effects, scripts for the example pages etc -->
        <script src="/assets/js/soft-ui-dashboard.min.js?v=1.0.5"></script>

      

        <script>

            

            $(document).ready(function(){

                // var show = $(#eye);
                // console.log('a'+show);

                $.validator.addMethod("checkUserName",function(value, element) {
                  var response = false;
                    $.ajax({
                        type:"POST",
                        async: false,
                        url: "/Login/isUserValidate",
                        data: {usuario: $("#usuario").val()},
                        success: function(data) {
                            if(data=="true"){
                                $('#btnEntrar').attr("disabled", false);
                                response = true;
                            }else{
                                $('#btnEntrar').attr("disabled", true);
                            }
                        }
                    });

                    return response;
                },"El usuario no es correcto");

                $("#login").validate({
                    rules:{
                        usuario:{
                            required: true,
                            checkUserName: true
                        },
                        password:{
                            required: true,
                        }
                    },
                    messages:{
                        usuario:{
                            required: "<br>Este campo es requerido",
                        },
                        password:{
                            required: "<br>Este campo es requerido",
                        }
                    }
                });

                $("#btnEntrar").click(function(){
                    $.ajax({
                        type: "POST",
                        url: "/Login/verificarUsuario",
                        data: $("#login").serialize(),
                        success: function(response){
                            if(response!=""){
                                var usuario = jQuery.parseJSON(response);
                                if(usuario.nombre!=""){
                                    $("#login").append('<input type="hidden" name="autentication" id="autentication" value="OK"/>');
                                    $("#login").append('<input type="hidden" name="nombre" id="nombre" value="'+usuario.nombre+'"/>');
                                    $("#login").submit();
                            }else{
                                alertify.alert("Error de autenticación <br> El usuario o contraseña es incorrecta");
                            }
                            }else{
                                alertify.alert("Error de autenticación <br> El usuario o contraseña es incorrecta");
                            }
                        }
                    });
                });


          
            });
        </script>
html;
        View::set('header',$extraHeader);
        View::set('footer',$extraFooter);
        View::render("login");
    }

    public function isUserValidate(){
        echo (count(LoginDao::getUser($_POST['usuario']))>=1)? 'true' : 'false';
    }

    public function verificarUsuario(){
        $usuario = new \stdClass();
        $usuario->_usuario = MasterDom::getData("usuario");
        $usuario->_password = MD5(MasterDom::getData("password"));
        $user = LoginDao::getById($usuario);
        if (count($user)>=1) {
            $user['nombre'] = utf8_encode($user['nombre']);
            echo json_encode($user);
        }
    }

    public function crearSession(){
        $usuario = new \stdClass();
        $usuario->_usuario = MasterDom::getData("usuario");
        $usuario->_password = MD5(MasterDom::getData("password"));
        $user = LoginDao::getById($usuario);
        session_start();
        $_SESSION['usuario'] = $user['usuario'];
        $_SESSION['nombre'] = $user['nombre'];
        $_SESSION['utilerias_administradores_id'] = $user['utilerias_administradores_id'];

        header("location: /Principal/");
    }

    public function cerrarSession(){
        //session_start();
        unset($_SESSION);
        session_unset();
        session_destroy();
        header("Location: /Login/");
    }

  
}
