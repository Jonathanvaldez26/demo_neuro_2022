<?php
namespace App\controllers;
defined("APPPATH") OR die("Access denied");

use \Core\View;
use \Core\MasterDom;
use \App\controllers\Contenedor;
use \Core\Controller;
use \App\models\Empresa AS EmpresaDao;

class Linea extends Controller{

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

          $("#muestra-cupones").tablesorter();
          var oTable = $('#muestra-cupones').DataTable({
                "columnDefs": [{
                    "orderable": false,
                    "targets": 0
                }],
                 "order": false
            });

            // Remove accented character from search input as well
            $('#muestra-cupones input[type=search]').keyup( function () {
                var table = $('#example').DataTable();
                table.search(
                    jQuery.fn.DataTable.ext.type.search.html(this.value)
                ).draw();
            });

            var checkAll = 0;
            $("#checkAll").click(function () {
              if(checkAll==0){
                $("input:checkbox").prop('checked', true);
                checkAll = 1;
              }else{
                $("input:checkbox").prop('checked', false);
                checkAll = 0;
              }

            });

            $("#export_pdf").click(function(){
              $('#all').attr('action', '/Empresa/generarPDF/');
              $('#all').attr('target', '_blank');
              $("#all").submit();
            });

            $("#export_excel").click(function(){
              $('#all').attr('action', '/Empresa/generarExcel/');
              $('#all').attr('target', '_blank');
              $("#all").submit();
            });

            $("#delete").click(function(){
              var seleccionados = $("input[name='borrar[]']:checked").length;
              if(seleccionados>0){
                alertify.confirm('¿Segúro que desea eliminar lo seleccionado?', function(response){
                  if(response){
                    $('#all').attr('target', '');
                    $('#all').attr('action', '/Empresa/delete');
                    $("#all").submit();
                    alertify.success("Se ha eliminado correctamente");
                  }
                });
              }else{
                alertify.confirm('Selecciona al menos uno para eliminar');
              }
            });

        });
      </script>
html;
      $empresas = EmpresaDao::getAll();
      //$usuario = $this->__usuario;
      //$editarHidden = (Controller::getPermisosUsuario($usuario, "seccion_empresas", 5)==1)? "" : "style=\"display:none;\"";
      //$eliminarHidden = (Controller::getPermisosUsuario($usuario, "seccion_empresas", 6)==1)? "" : "style=\"display:none;\"";
      $tabla= '';
      $status= '';
      foreach ($empresas as $key => $value) {
          if($value['status'] = 1){
              $status =<<<html
                 <span class="badge badge-dot me-1">
                        <i class="bg-success"></i>
                 </span>   
html;
          }elseif ($value['status'] = 2)
          {
              $status =<<<html
                 <span class="badge badge-dot me-1">
                        <i class="bg-danger"></i>
                 </span>   
html;
          }
        $tabla.=<<<html
                <tr>
                <td><input type="checkbox" name="borrar[]" value="{$value['catalogo_empresa_id']}"/></td>
                <td><h6 class="mb-0 text-sm">{$status}{$value['clave']}</h6></td>
                <td>
                    <div class="d-flex px-2 py-1">
                         <div>
                              <img src="../../../assets/img/team-2.jpg" class="avatar avatar-sm me-3" alt="avatar image">
                         </div>
                         <div class="d-flex flex-column justify-content-center">
                            <h6 class="mb-0 text-sm">{$value['rfc']}</h6>
                         </div>
                    </div>
                </td>
                <td><p class="text-sm text-secondary mb-0">{$value['razon_social']}</p></td>
                <td><span class="text-secondary text-center text-sm">{$value['fecha_alta']}</span></td>
                <td class="center" >
                    <a href="/Empresa/edit/{$value['catalogo_empresa_id']}" type="submit" name="id" class="btn btn-outline-primary"><span class="fa fa-pencil-square-o"></span> </a>
                    <a href="/Empresa/show/{$value['catalogo_empresa_id']}" type="submit" name="id_empresa" class="btn btn-outline-success"><span class="fa fa-eye" ></span> </a>
                    <button type="submit" name="id_empresa" class="btn btn-outline-info"><span class="fa fa-eye"></span></button>                
                </td>
                </tr>
html;
      }
      $pdfHidden = (Controller::getPermisosUsuario($usuario, "seccion_empresas", 2)==1)?  "" : "style=\"display:none;\"";
      $excelHidden = (Controller::getPermisosUsuario($usuario, "seccion_empresas", 3)==1)? "" : "style=\"display:none;\"";
      $agregarHidden = (Controller::getPermisosUsuario($usuario, "seccion_empresas", 4)==1)? "" : "style=\"display:none;\"";
      View::set('pdfHidden',$pdfHidden);
      View::set('excelHidden',$excelHidden);
      View::set('agregarHidden',$agregarHidden);
      View::set('tabla',$tabla);
      View::set('header',$this->_contenedor->header($extraheader));
      View::set('footer',$this->_contenedor->footer($extraFooter));
      View::render("Linea_all");
    }

    public function Add(){
      $extraFooter =<<<html
      <script>
        $(document).ready(function(){
          $.validator.addMethod("verificarRFC",
            function(value, element) {
              var result = false;
              $.ajax({
                type:"POST",
                async: false,
                url: "/Empresa/validarRFC", // script to validate in server side
                data: {
                    nombre: function() {
                      return $("#rfc").val();
                    }},
                success: function(data) {
                    console.log("success::: " + data);
                    result = (data == "true") ? false : true;
                    if(result == true){
                      $('#availability').html('<span class="text-success glyphicon glyphicon-ok"></span><span> Nombre disponible</span>');
                      $('#register').attr("disabled", true);
                    }else{
                      $('#availability').html('<span class="text-danger glyphicon glyphicon-remove"></span>');
                      $('#register').attr("disabled", false);
                    }
                }
              });
              // return true if username is exist in database
              return result;
              },
              "<li>¡Este nombre ya está en uso. Intenta con otro!</li><li> Si no es visible en la tabla inicial, contacta a soporte técnico</li>"
          );
          $("#add").validate({
            rules:{
              rfc:{
               required: true,
               verificarRFC: true
              },
              razon_social:{
                required: true
              },
              email:{
                required: true
              },
              telefono_uno:{
                required: true
              },
              telefono_dos:{
                required: true
              },
              domicilio_fiscal:{
                required: true
              },
              sitio_web:{
                required: true
              }
            },
            messages:{
              rfc:{
                required: "Este campo es requerido",
                minlength: "Este campo debe tener minimo 13 caracteres"
              },
              razon_social:{
                required: "Este campo es requerido",
                minlength: "Este campo debe tener minimo 5 caracteres"
              },
              email:{
                required: "Este campo es requerido"
              },
              telefono_uno:{
                required: "Este campo es requerido"
              },
              telefono_dos:{
                required: "Este campo es requerido"
              },
              domicilio_fiscal:{
                required: "Este campo es requerido"
              },
              sitio_web:{
                required: "Este campo es requerido"
              }
            }
          });//fin del jquery validate

          $("#btnCancel").click(function(){
            window.location.href = "/Empresa/";
          });//fin del btnAdd

        });//fin del document.ready
      </script>
html;

      View::set('header',$this->_contenedor->header(''));
      View::render("Linea_add");
      View::set('footer',$this->_contenedor->footer($extraFooter));

    }

    public function empresaAdd(){
        $empresa = new \stdClass();

        $rfc = MasterDom::getDataAll('rfc');
        $rfc = MasterDom::procesoAcentosNormal($rfc);
        $empresa->_rfc = $rfc;

        $rest = substr("rfc", 0, -10);
        $empresa->_clave = $rest;

        $razon_social = MasterDom::getDataAll('razon_social');
        $razon_social = MasterDom::procesoAcentosNormal($razon_social);
        $empresa->_razon_social = $razon_social;

        $email= MasterDom::getDataAll('email');
        $email= MasterDom::procesoAcentosNormal($email);
        $empresa->_email = $email;

        $telefono_uno= MasterDom::getDataAll('telefono_uno');
        $empresa->_telefono_uno = $telefono_uno;

        $telefono_dos= MasterDom::getDataAll('telefono_dos');
        $empresa->_telefono_dos = $telefono_dos;

        $domicilio_fiscal= MasterDom::getDataAll('domicilio_fiscal');
        $domicilio_fiscal= MasterDom::procesoAcentosNormal($domicilio_fiscal);
        $empresa->_domicilio_fiscal = $domicilio_fiscal;

        $sitio_web= MasterDom::getDataAll('sitio_web');
        $empresa->_sitio_web = $sitio_web;

        $empresa->_status = MasterDom::getData('status');

        $id = EmpresaDao::insert($empresa);
        if($id >= 1){
            $this->alerta($id,'add');
        }else{
            $this->alerta($id,'error');
        }
    }

    public function edit($id){
      $extraFooter =<<<html
      <script>
        $(document).ready(function(){
          $.validator.addMethod("verificarRFC",
            function(value, element) {
              var result = false;
              $.ajax({
                type:"POST",
                async: false,
                url: "/Empresa/validarOtroRFC", // script to validate in server side
                data: {
                    nombre: function() {
                      return $("#nombre").val();
                    },
                    id: function(){
                      return $("#catalogo_empresa_id").val();
                    }
                },
                success: function(data) {
                    console.log("success::: " + data);
                    result = (data == "true") ? true : false;

                    if(result == true){
                      $('#availability').html('<span class="text-success glyphicon glyphicon-ok"></span><span> Nombre disponible</span>');
                      $('#register').attr("disabled", true);
                    }

                    if(result == false){
                      $('#availability').html('<span class="text-danger glyphicon glyphicon-remove"></span>');
                      $('#register').attr("disabled", false);
                    }
                }
              });
              // return true if username is exist in database
              return result;
              },
              "<li>¡Este nombre ya está en uso. Intenta con otro!</li><li> Si no es visible en la tabla inicial, contacta a soporte técnico</li>"
          );
          $("#edit").validate({
            rules:{
              nombre:{
                required: true
              },
              descripcion:{
                required: true
              },
              status:{
                required: true
              }
            },
            messages:{
              nombre:{
                required: "Este campo es requerido"
              },
              descripcion:{
                required: "Este campo es requerido"
              },
              status:{
                required: "Este campo es requerido"
              }
            }
          });//fin del jquery validate

          $("#btnCancel").click(function(){
            window.location.href = "/Empresa/";
          });//fin del btnAdd

        });//fin del document.ready
      </script>
html;
      $empresa = EmpresaDao::getById($id);

      $status = "";
      foreach (EmpresaDao::getStatus() as $key => $value) {
        $selected = ($empresa['status']==$value['catalogo_status_id'])? 'selected' : '';
        $status .=<<<html
        <option {$selected} value="{$value['catalogo_status_id']}">{$value['nombre']}</option>
html;
      }

      View::set('status',$status);
      View::set('empresa',$empresa);
      View::set('header',$this->_contenedor->header(''));
      View::set('footer',$this->_contenedor->footer($extraFooter));
      View::render("empresa_edit");
    }

    public function show($id){
      $header =<<<html
        <!DOCTYPE html>
        <html lang="en">
          <head>
            <meta charset="utf-8" />
            <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
            <link rel="apple-touch-icon" sizes="76x76" href="/assets/img/favicon.png">
            <link rel="icon" type="image/png" href="/assets/img/favicon.png">
            <title>
               GRUPO LAHE
            </title>
            <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
            <!-- Nucleo Icons -->
            <link href="../../assets/css/nucleo-icons.css" rel="stylesheet" />
            <link href="../../assets/css/nucleo-svg.css" rel="stylesheet" />
            <!-- Font Awesome Icons -->
            <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
            <link href="../../assets/css/nucleo-svg.css" rel="stylesheet" />
            <!-- CSS Files -->
            <link id="pagestyle" href="../../assets/css/soft-ui-dashboard.css?v=1.0.5" rel="stylesheet" />
            <!-- TEMPLATE VIEJO-->
            <link rel="stylesheet" href="/css/alertify/alertify.core.css" />
            <link rel="stylesheet" href="/css/alertify/alertify.default.css" id="toggleCSS" />

            <meta charset="utf-8" />
            <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
            <link rel="icon" type="image/png" href="../../assets/img/favicon.png">
            <title>
              Soft UI Dashboard PRO by Creative Tim
            </title>
            <!--     Fonts and icons     -->
            <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
            <!-- Nucleo Icons -->
            <link href="../../assets/css/nucleo-icons.css" rel="stylesheet" />
            <link href="../../assets/css/nucleo-svg.css" rel="stylesheet" />
            <!-- Font Awesome Icons -->
            <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
            <link href="../../assets/css/nucleo-svg.css" rel="stylesheet" />
            <!-- CSS Files -->
            <link id="pagestyle" href="../../assets/css/soft-ui-dashboard.css?v=1.0.5" rel="stylesheet" />


           <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
            
           <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
           <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
           <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
           <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
            <!-- TEMPLATE VIEJO-->
        </head>
html;
      $extraFooter =<<<html
      <script>
        $(document).ready(function(){
          $.validator.addMethod("verificarRFC",
            function(value, element) {
              var result = false;
              $.ajax({
                type:"POST",
                async: false,
                url: "/Empresa/validarOtroRFC", // script to validate in server side
                data: {
                    nombre: function() {
                      return $("#nombre").val();
                    },
                    id: function(){
                      return $("#catalogo_empresa_id").val();
                    }
                },
                success: function(data) {
                    console.log("success::: " + data);
                    result = (data == "true") ? true : false;

                    if(result == true){
                      $('#availability').html('<span class="text-success glyphicon glyphicon-ok"></span><span> Nombre disponible</span>');
                      $('#register').attr("disabled", true);
                    }

                    if(result == false){
                      $('#availability').html('<span class="text-danger glyphicon glyphicon-remove"></span>');
                      $('#register').attr("disabled", false);
                    }
                }
              });
              // return true if username is exist in database
              return result;
              },
              "<li>¡Este nombre ya está en uso. Intenta con otro!</li><li> Si no es visible en la tabla inicial, contacta a soporte técnico</li>"
          );
          $("#edit").validate({
            rules:{
              nombre:{
                required: true,
                minlength: 5
              },
              descripcion:{
                required: true,
                minlength: 5
              },
              status:{
                required: true
              }
            },
            messages:{
              nombre:{
                required: "Este campo es requerido",
                minlength: "Este campo debe tener minimo 5 caracteres"
              },
              descripcion:{
                required: "Este campo es requerido",
                minlength: "Este campo debe tener minimo 5 caracteres"
              },
              status:{
                required: "Este campo es requerido"
              }
            }
          });//fin del jquery validate

          $("#btnCancel").click(function(){
            window.location.href = "/Empresa/";
          });//fin del btnAdd

        });//fin del document.ready
      </script>
html;
      $empresa = EmpresaDao::getById($id);
      View::set('empresa',$empresa);
      View::set('header',$header);
      View::set('footer',$this->_contenedor->footer($extraFooter));
      View::render("empresa_view");
    }

    public function delete(){
      $id = MasterDom::getDataAll('borrar');
      $array = array();
      foreach ($id as $key => $value) {
        $id = EmpresaDao::delete($value);
        if($id['seccion'] == 2){
          array_push($array, array('seccion' => 2, 'id' => $id['id'] ));
        }else if($id['seccion'] == 1){
          array_push($array, array('seccion' => 1, 'id' => $id['id'] ));
        }
      }
      $this->alertas("Eliminacion de Empresas", $array, "/Empresa/");
    }

    public function empresaEdit(){
      $empresa = new \stdClass();
      $empresa->_catalogo_empresa_id = MasterDom::getData('catalogo_empresa_id');
      $id = EmpresaDao::verificarRelacion(MasterDom::getData('catalogo_empresa_id'));
      $nombre = MasterDom::getDataAll('nombre');
      $nombre = MasterDom::procesoAcentosNormal($nombre);
      $empresa->_nombre = $nombre;
      $descripcion = MasterDom::getDataAll('descripcion');
      $descripcion = MasterDom::procesoAcentosNormal($descripcion);
      $empresa->_descripcion = $descripcion;
      $empresa->_status = MasterDom::getData('status');

      $array = array();
      if($id['seccion'] == 2){
        array_push($array, array('seccion' => 2, 'id' => $id['id'] ));
        //
        $idStatus = (MasterDom::getData('status')!=2) ? true : false;
        if($idStatus){
          if(EmpresaDao::update($empresa) > 0)
            $this->alerta($id,'edit');
          else
            $this->alerta($id,'nothing');
        }else{
          $this->alertas("Eliminacion de Empresas", $array, "/Empresa/");
        }
      }

      if($id['seccion'] == 1){
        array_push($array, array('seccion' => 1, 'id' => $id['id'] ));

        //$id = EmpresaDao::update($empresa);

        if(MasterDom::getData('status') == 2){
          EmpresaDao::update($empresa);
          $this->alerta(MasterDom::getData('catalogo_empresa_id'),'delete');
        }else{
          if(EmpresaDao::update($empresa) >= 1) $this->alerta($id,'edit');
          else $this->alerta("",'no_cambios');
        }

      }
    }

    public function validarRFC(){
      $dato = EmpresaDao::getRFC($_POST['rfc']);
      if($dato == 1){
        echo "true";
      }else{
        echo "false";
      }
    }

    public function validarOtroRFC(){
      $id = EmpresaDao::getIdComparacion($_POST['id'], $_POST['nombre']);
      if($id == 1)
        echo "true";

      if($id == 2){
        $dato = EmpresaDao::getNombreEmpresa($_POST['nombre']);
        if($dato == 2){
          echo "true";
        }else{
          echo "false";
        }
      }

    }

    public function generarPDF(){
      $ids = MasterDom::getDataAll('borrar');
      $mpdf=new \mPDF('c');
      $mpdf->defaultPageNumStyle = 'I';
      $mpdf->h2toc = array('H5'=>0,'H6'=>1);
      $style =<<<html
      <style>
        .imagen{
          width:100%;
          height: 150px;
          background: url(/img/ag_logo.png) no-repeat center center fixed;
          background-size: cover;
          -moz-background-size: cover;
          -webkit-background-size: cover
          -o-background-size: cover;
        }

        .titulo{
          width:100%;
          margin-top: 30px;
          color: #F5AA3C;
          margin-left:auto;
          margin-right:auto;
        }
      </style>
html;
$tabla =<<<html
  <img class="imagen" src="/img/ag_logo.png"/>
  <br>
  <div style="page-break-inside: avoid;" align='center'>
  <H1 class="titulo">Empresas</H1>
  <table border="0" style="width:100%;text-align: center">
    <tr style="background-color:#B8B8B8;">
    <th><strong>Id</strong></th>
    <th><strong>Nombre</strong></th>
    <th><strong>Descripción</strong></th>
    <th><strong>Status</strong></th>
    </tr>
html;

      if($ids!=''){
        foreach ($ids as $key => $value) {
          $empresa = EmpresaDao::getByIdReporte($value);
            $tabla.=<<<html
              <tr style="background-color:#B8B8B8;">
              <td style="height:auto; width: 200px;background-color:#E4E4E4;">{$empresa['catalogo_empresa_id']}</td>
              <td style="height:auto; width: 200px;background-color:#E4E4E4;">{$empresa['nombre']}</td>
              <td style="height:auto; width: 200px;background-color:#E4E4E4;">{$empresa['descripcion']}</td>
              <td style="height:auto; width: 200px;background-color:#E4E4E4;">{$empresa['status']}</td>
              </tr>
html;
        }
      }else{
        foreach (EmpresaDao::getAll() as $key => $empresa) {
          $tabla.=<<<html
            <tr style="background-color:#B8B8B8;">
            <td style="height:auto; width: 200px;background-color:#E4E4E4;">{$empresa['catalogo_empresa_id']}</td>
            <td style="height:auto; width: 200px;background-color:#E4E4E4;">{$empresa['nombre']}</td>
            <td style="height:auto; width: 200px;background-color:#E4E4E4;">{$empresa['descripcion']}</td>
            <td style="height:auto; width: 200px;background-color:#E4E4E4;">{$empresa['status']}</td>
            </tr>
html;
          }
      }
      $tabla .=<<<html
      </table>
      </div>
html;
      $mpdf->WriteHTML($style,1);
      $mpdf->WriteHTML($tabla,2);
      //$nombre_archivo = "MPDF_".uniqid().".pdf";/* se genera un nombre unico para el archivo pdf*/
  	  print_r($mpdf->Output());/* se genera el pdf en la ruta especificada*/
  	  //echo $nombre_archivo;/* se imprime el nombre del archivo para poder retornarlo a CrmCatalogo/index */

      exit;
      //$ids = MasterDom::getDataAll('borrar');
      //echo shell_exec('php -f /home/granja/backend/public/librerias/mpdf_apis/Api.php Empresa '.json_encode(MasterDom::getDataAll('borrar')));
    }

    public function generarExcel(){
      $ids = MasterDom::getDataAll('borrar');
      $objPHPExcel = new \PHPExcel();
      $objPHPExcel->getProperties()->setCreator("jma");
      $objPHPExcel->getProperties()->setLastModifiedBy("jma");
      $objPHPExcel->getProperties()->setTitle("Reporte");
      $objPHPExcel->getProperties()->setSubject("Reorte");
      $objPHPExcel->getProperties()->setDescription("Descripcion");
      $objPHPExcel->setActiveSheetIndex(0);

      /*AGREGAR IMAGEN AL EXCEL*/
      //$gdImage = imagecreatefromjpeg('http://52.32.114.10:8070/img/ag_logo.jpg');
      $gdImage = imagecreatefrompng('http://52.32.114.10:8070/img/ag_logo.png');
      // Add a drawing to the worksheetecho date('H:i:s') . " Add a drawing to the worksheet\n";
      $objDrawing = new \PHPExcel_Worksheet_MemoryDrawing();
      $objDrawing->setName('Sample image');$objDrawing->setDescription('Sample image');
      $objDrawing->setImageResource($gdImage);
      //$objDrawing->setRenderingFunction(\PHPExcel_Worksheet_MemoryDrawing::RENDERING_JPEG);
      $objDrawing->setRenderingFunction(\PHPExcel_Worksheet_MemoryDrawing::RENDERING_PNG);
      $objDrawing->setMimeType(\PHPExcel_Worksheet_MemoryDrawing::MIMETYPE_DEFAULT);
      $objDrawing->setWidth(50);
      $objDrawing->setHeight(125);
      $objDrawing->setCoordinates('A1');
      $objDrawing->setWorksheet($objPHPExcel->getActiveSheet());

      $estilo_titulo = array(
        'font' => array('bold' => true,'name'=>'Verdana','size'=>16, 'color' => array('rgb' => 'FEAE41')),
        'alignment' => array('horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_CENTER),
        'type' => \PHPExcel_Style_Fill::FILL_SOLID
      );

      $estilo_encabezado = array(
        'font' => array('bold' => true,'name'=>'Verdana','size'=>14, 'color' => array('rgb' => 'FEAE41')),
        'alignment' => array('horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_CENTER),
        'type' => \PHPExcel_Style_Fill::FILL_SOLID
      );

      $estilo_celda = array(
        'font' => array('bold' => false,'name'=>'Verdana','size'=>12,'color' => array('rgb' => 'B59B68')),
        'alignment' => array('horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_CENTER),
        'type' => \PHPExcel_Style_Fill::FILL_SOLID

      );


      $fila = 9;
      $adaptarTexto = true;

      $controlador = "Empresa";
      $columna = array('A','B','C','D');
      $nombreColumna = array('Id','Nombre','Descripción','Status');
      $nombreCampo = array('catalogo_empresa_id','nombre','descripcion','status');

      $objPHPExcel->getActiveSheet()->SetCellValue('A'.$fila, 'Reporte de Empresas');
      $objPHPExcel->getActiveSheet()->mergeCells('A'.$fila.':'.$columna[count($nombreColumna)-1].$fila);
      $objPHPExcel->getActiveSheet()->getStyle('A'.$fila)->applyFromArray($estilo_titulo);
      $objPHPExcel->getActiveSheet()->getStyle('A'.$fila)->getAlignment()->setWrapText($adaptarTexto);

      $fila +=1;

      /*COLUMNAS DE LOS DATOS DEL ARCHIVO EXCEL*/
      foreach ($nombreColumna as $key => $value) {
        $objPHPExcel->getActiveSheet()->SetCellValue($columna[$key].$fila, $value);
        $objPHPExcel->getActiveSheet()->getStyle($columna[$key].$fila)->applyFromArray($estilo_encabezado);
        $objPHPExcel->getActiveSheet()->getStyle($columna[$key].$fila)->getAlignment()->setWrapText($adaptarTexto);
        $objPHPExcel->getActiveSheet()->getColumnDimensionByColumn($key)->setAutoSize(true);
      }
      $fila +=1; //fila donde comenzaran a escribirse los datos

      /* FILAS DEL ARCHIVO EXCEL */
      if($ids!=''){
        foreach ($ids as $key => $value) {
          $empresa = EmpresaDao::getByIdReporte($value);
          foreach ($nombreCampo as $key => $campo) {
            $objPHPExcel->getActiveSheet()->SetCellValue($columna[$key].$fila, html_entity_decode($empresa[$campo], ENT_QUOTES, "UTF-8"));
            $objPHPExcel->getActiveSheet()->getStyle($columna[$key].$fila)->applyFromArray($estilo_celda);
            $objPHPExcel->getActiveSheet()->getStyle($columna[$key].$fila)->getAlignment()->setWrapText($adaptarTexto);
          }
          $fila +=1;
        }
      }else{
        foreach (EmpresaDao::getAll() as $key => $value) {
          foreach ($nombreCampo as $key => $campo) {
            $objPHPExcel->getActiveSheet()->SetCellValue($columna[$key].$fila, html_entity_decode($value[$campo], ENT_QUOTES, "UTF-8"));
            $objPHPExcel->getActiveSheet()->getStyle($columna[$key].$fila)->applyFromArray($estilo_celda);
            $objPHPExcel->getActiveSheet()->getStyle($columna[$key].$fila)->getAlignment()->setWrapText($adaptarTexto);
          }
          $fila +=1;
        }
      }

      $objPHPExcel->getActiveSheet()->getStyle('A1:'.$columna[count($columna)-1].$fila)->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
      for ($i=0; $i <$fila ; $i++) {
        $objPHPExcel->getActiveSheet()->getRowDimension($i)->setRowHeight(20);
      }

      $objPHPExcel->getActiveSheet()->setTitle('Reporte');

      header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
      header('Content-Disposition: attachment;filename="Reporte AG '.$controlador.'.xlsx"');
      header('Cache-Control: max-age=0');
      header('Cache-Control: max-age=1');
      header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
      header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT');
      header ('Cache-Control: cache, must-revalidate');
      header ('Pragma: public');

      \PHPExcel_Settings::setZipClass(\PHPExcel_Settings::PCLZIP);
      $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
      $objWriter->save('php://output');
    }

    public function alerta($id, $parametro){
      $regreso = "/Empresa/";

      if($parametro == 'add'){
        $mensaje = "Se ha agregado correctamente";
        $class = "success";
      }

      if($parametro == 'edit'){
        $mensaje = "Se ha modificado correctamente";
        $class = "success";
      }

      if($parametro == 'delete'){
        $mensaje = "Se ha eliminado la empresa {$id}, ya que cambiaste el estatus a eliminado";
        $class = "success";
      }

      if($parametro == 'nothing'){
        $mensaje = "Posibles errores: <li>No intentaste actualizar ningún campo</li> <li>Este dato ya esta registrado, comunicate con soporte técnico</li> ";
        $class = "warning";
      }

      if($parametro == 'no_cambios'){
        $mensaje = "No intentaste actualizar ningún campo";
        $class = "warning";
      }

      if($parametro == 'union'){
        $mensaje = "Al parecer este campo de está ha sido enlazada con un campo de Catálogo de Colaboradores, ya que esta usuando esta información";
        $class = "info";
      }

      if($parametro == "error"){
        $mensaje = "Al parecer ha ocurrido un problema";
        $class = "danger";
      }


      View::set('class',$class);
      View::set('regreso',$regreso);
      View::set('mensaje',$mensaje);
      View::set('header',$this->_contenedor->header($extraHeader));
      View::set('footer',$this->_contenedor->footer($extraFooter));
      View::render("alerta");
    }

    public function alertas($title, $array, $regreso){
      $mensaje = "";
      foreach ($array as $key => $value) {
        if($value['seccion'] == 2){
          $mensaje .= <<<html
            <div class="alert alert-danger" role="alert">
              <h4>El ID <b>{$value['id']}</b>, no se puede eliminar, ya que esta siendo utilizado por el Catálogo de Colaboradores</h4>
            </div>
html;
        }

        if($value['seccion'] == 1){
          $mensaje .= <<<html
            <div class="alert alert-success" role="alert">
              <h4>El ID <b>{$value['id']}</b>, se ha eliminado</h4>
            </div>
html;
        }
      }
      View::set('regreso', $regreso);
      View::set('mensaje', $mensaje);
      View::set('titulo', $title);
      View::render("alertas");
    }

}
