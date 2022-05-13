<?php
namespace App\controllers;
defined("APPPATH") OR die("Access denied");

use \Core\View;
use \Core\MasterDom;
use \App\controllers\Contenedor;
use \Core\Controller;
use \App\models\Aeropuertos AS AeropuertosDao;

class Aeropuertos extends Controller{

    private $_contenedor;

    function __construct(){
        parent::__construct();
        $this->_contenedor = new Contenedor;
        View::set('header',$this->_contenedor->header());
        View::set('footer',$this->_contenedor->footer());

        if(Controller::getPermisosUsuario($this->__usuario, "permisos_globales",1) == 0)
          header('Location: /Principal/');
    }

    public function index() {
      $extraFooter =<<<html
      <script>
        $(document).ready(function(){

          $('#muestra-cupones').DataTable( {
            "drawCallback": function( settings ) {
              $('.current').addClass("btn bg-gradient-danger btn-rounded").removeClass("paginate_button");
                    $('.paginate_button').addClass("btn").removeClass("paginate_button");
                    $('.dataTables_length').addClass("m-4");
                    $('.dataTables_info').addClass("mx-4");
                    $('.dataTables_filter').addClass("m-4");
                    // $('input').addClass("form-control");
                    $('.previous.disabled').addClass("btn-outline-danger opacity-5 btn-rounded mx-2");
                    $('.next.disabled').addClass("btn-outline-danger opacity-5 btn-rounded mx-2");
                    $('.previous').addClass("btn-outline-danger btn-rounded mx-2");
                    $('.next').addClass("btn-outline-danger btn-rounded mx-2");
                    $('.next').addClass("btn-outline-danger btn-rounded mx-2");
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
              $('#all').attr('action', '/Aeropuertos/generarPDF/');
              $('#all').attr('target', '_blank');
              $("#all").submit();
            });

            $("#export_excel").click(function(){
              $('#all').attr('action', '/Aeropuertos/generarExcel/');
              $('#all').attr('target', '_blank');
              $("#all").submit();
            });

            $("#delete").click(function(){
              var seleccionados = $("input[name='borrar[]']:checked").length;
              if(seleccionados>0){
                alertify.confirm('¿Segúro que desea eliminar lo seleccionado?', function(response){
                  if(response){
                    $('#all').attr('target', '');
                    $('#all').attr('action', '/Aeropuertos/delete');
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
      $aeropuertos = AeropuertosDao::getAll();
      $tabla= '';

      $sStatus = "";
//       foreach (AeropuertosDao::getStatus() as $key => $value) {
//         $sStatus .=<<<html
//         <option value="{$value['catalogo_status_id']}">{$value['nombre']}</option>
// html;
//       }

      foreach ($aeropuertos as $key => $value) {
        $tabla.=<<<html
                <tr>
                <td style="text-align:center; vertical-align:middle;"><input type="checkbox" name="borrar[]" value="{$value['id_aeropuerto']}"/></td>
                <td style="text-align:center; vertical-align:middle;">{$value['estado']}</td>
                <td style="text-align:center; vertical-align:middle;">{$value['ciudad']}</td>
                <td style="text-align:center; vertical-align:middle;">{$value['aeropuerto']}</td>
                <td style="text-align:center; vertical-align:middle;" class="center">
                    <a href="/Aeropuertos/edit/{$value['perfil_id']}" type="submit" name="id" class="btn bg-gradient-primary" ><span class="fa fa-pencil-square-o" style="color:white"></span> </a>  <!-- data-toggle="modal" data-target="#editModal{$value['perfil_id']}" -->
                </td><!--   -->
                </tr>
                
                <div class="modal" id="editModal{$value['perfil_id']}" tabindex="-1" role="dialog" aria-labelledby="editModal{$value['perfil_id']}" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="editModal{$value['perfil_id']}">Editar Perfil</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
                      <div class="right_col">
                      <div class="col-md-12 col-sm-12 col-xs-12 col-lg-12">
                        <div class="x_panel tile fixed_height_240">
                          <div class="x_title">
                            <br><br>
                            <h1>Editar un nuevo Perfil </h1>
                            <div class="clearfix"></div>
                          </div>
                          <div class="x_content">
                            <form class="form-horizontal" id="add" action="/Aeropuertos/perfilEdit" method="POST">
                              <div class="form-group ">
                    
                                <div class="form-group">
                                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="nombre">Nombre <span class="required">*</span></label>
                                  <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input type="text" name="nombre" id="nombre" class="form-control col-md-7 col-xs-12" placeholder="Nombre del perfil" value=" {$value['nombre']}">
                                  </div>
                                </div>
                    
                                <!--div class="form-group">
                                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="opciones">Opciones de secciones <span class="required">*</span></label>
                                  <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input type="text" name="opciones" id="opciones" class="form-control col-md-7 col-xs-12" placeholder="Nombre del perfil" value=" {$value['opciones']}">
                                  </div>
                                </div-->
                    
                                <div class="form-group">
                                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="descripcion">Descripci&oacute;n <span class="required">*</span></label>
                                  <div class="col-md-6 col-sm-6 col-xs-12">
                                    <textarea class="form-control" name="descripcion" id="descripcion" placeholder="Descripci&oacute;n la empresa"> {$value['descripcion']}</textarea>
                                  </div>
                                </div>
                    
                                <div class="form-group">
                                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="status">Estatus<span class="required">*</span></label>
                                  <div class="col-md-6 col-sm-6 col-xs-12">
                                    <select class="form-control" name="status" id="status">
                                    
                              <option value="" disabled selected>Selecciona un estatus</option>
                              
html;
                            foreach (AeropuertosDao::getStatus() as $key => $value) {
                              if ($value['nombre_status'] == 1) {
                                $sStatus .=<<<html
                                  <option value="{$value['catalogo_status_id']}" selected>{$value['nombre']}</option>
                                html;
                              }
                            }
                              

                          $tabla.=<<<html
                          {$sStatus}
                                    </select>
                                  </div>
                                </div>

                                {$value['perfil_id']}
                    
                                <input type="hidden" name="perfil_id" id="perfil_id" value="{$value['perfil_id']}">
                    
                                <div class="form-group">
                                  <div class="col-md-9 col-sm-9 col-xs-12 col-md-offset-2 col-xs-offset-3">
                                    <button class="btn btn-danger col-md-3 col-sm-3 col-xs-5" type="button" id="btnCancel">Cancelar</button>
                                    <button class="btn btn-primary col-md-3 col-sm-3 col-xs-5" type="reset" >Resetear</button>
                                    <button class="btn btn-success col-md-3 col-sm-3 col-xs-5" id="btnAdd" type="submit">Actualizar</button>
                                  </div>
                                </div>
                                <div id="resultado">
                    
                                </div>
                              </div>
                            </form>
                          </div>
                        </div>
                      </div>
                    </div>
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary">Save changes</button>
                      </div>
                    </div>
                  </div>
                </div>
                
html;

      $extraHeader =<<<html
          <title>
              Aeropuertos
          </title>
html;

      }
      View::set('AEROPUERTOS$aeropuertos',$aeropuertos);
      View::set('tabla',$tabla);
      View::set('header',$this->_contenedor->header($extraHeader));
      View::set('footer',$this->_contenedor->footer($extraFooter));
      View::render("aeropuertos_all");
    }

    public function Add(){
      $extraHeader =<<<html
      <link href="/css/switchery.min.css" rel="stylesheet">

html;
      $extraFooter =<<<html
      <script src="/js/icheck.min.js"></script>
      <script src="/js/switchery.min.js"></script>
      <link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
      <script src="/js/control_check.js"></script>
      <!--script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script-->

      <script>
        $(document).ready(function(){

          $.validator.addMethod("checkUserName",
            function(value, element) {
              var result = false;
              $.ajax({
                type:"POST",
                async: false,
                url: "/Aeropuertos/isValidateUser", // script to validate in server side
                data: {
                    usuario: function() {
                      return $("#nombre").val();
                    }},
                success: function(data) {
                    console.log("success::: " + data);
                    result = (data == "true") ? false : true;

                    if(result == true){
                      $('#availability').html('<span class="text-success glyphicon glyphicon-ok"></span>');
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
          );



          $("#add").validate({
            rules:{
              nombre:{
                required: true,
                checkUserName: true
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
          });

          $("#btnCancel").click(function(){
            window.location.href = "/Aeropuertos/";
          });//fin del btnAdd

        });//fin del document.ready
      </script>

      <script>
      $(document).on('click', '#deshabiltar', function() {
        $(".toggle").attr("disabled", "disabled");
      });
      $(document).on('click', '#habilitar', function() {
        $(".toggle").removeAttr("disabled");
      });
      </script>

html;
      $sStatus = "";
      foreach (AeropuertosDao::getStatus() as $key => $value) {
        $sStatus .=<<<html
        <option value="{$value['catalogo_status_id']}">{$value['nombre']}</option>
html;
      }

      $tabla1= '';
      foreach (AeropuertosDao::getSeccionesMenu() as $key => $value) {
        $tabla1.=<<<html
          <tr>
            <td>
              <!--input id="categoria" onclick="onClickHandler()"  type="checkbox" class="flat" value="{$value['utilerias_seccion_id']}" name="seccion{$value['utilerias_seccion_id']}"> {$value['nombre_seccion']} -->

              <input type="checkbox" id="myCheck{$value['utilerias_seccion_id']}" name="seccion{$value['utilerias_seccion_id']}" > {$value['nombre_seccion']}

              <!--button type="button" id="deshabiltar" class="btn btn-primary">Deshabiltar</button>
              <button type="button" id="habilitar" class="btn btn-primary">Habilitar</button-->
            </td>
            <td>
              <input class="toggle botonEstado" name="agregar{$value['utilerias_seccion_id']}" id="agregar{$value['utilerias_seccion_id']}" type="checkbox" data-toggle="toggle" disabled >
            </td>
            <td>
              <!--No <input type="checkbox" class="js-switch" id="b{$value['utilerias_seccion_id']}" name="editar{$value['utilerias_seccion_id']}"/> Si-->
              <input class="toggle botonEstado" name="editar{$value['utilerias_seccion_id']}" id="editar{$value['utilerias_seccion_id']}" type="checkbox" data-toggle="toggle" disabled >
            </td>
            <td>
              <!--No <input type="checkbox" class="js-switch" name="eliminar{$value['utilerias_seccion_id']}"/> Si -->
              <input class="toggle botonEstado" name="eliminar{$value['utilerias_seccion_id']}" id="eliminar{$value['utilerias_seccion_id']}" type="checkbox" data-toggle="toggle" disabled >
            </td>
        </tr>
html;
      }

      /*<input type="checkbox" class="flat" value="{$value['seccion_menu_id']}"> {$value['nombre_seccion']} <br>
      $getSeccionesMenu = "<label>";
      foreach (AeropuertosDao::getSeccionesMenu() as $key => $value) {
        $getSeccionesMenu .=<<<html
html;
      }
      $getSeccionesMenu .= "</label>";*/

      View::set('tabla', $tabla);
      View::set('sStatus',$sStatus);
      View::set('header',$this->_contenedor->header($extraHeader));
      View::set('footer',$this->_contenedor->footer($extraFooter));
      View::render("aeropuertos_add");
    }

    public function edit($id){
      $extraFooter =<<<html
      <script>
        $(document).ready(function(){

          $("#add").validate({
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
            window.location.href = "/Aeropuertos/";
          });//fin del btnAdd

        });//fin del document.ready
      </script>
html;
      $perfil = AeropuertosDao::getByID($id);

      $sStatus = "";
      foreach (AeropuertosDao::getStatus() as $key => $value) {
        $selected = ($value['catalogo_status_id']==$perfil['status'])? 'selected' : '';
        $sStatus .=<<<html
        <option $selected value="{$value['catalogo_status_id']}">{$value['nombre']}</option>
html;
      }
      View::set('perfil',$perfil);
      View::set('sStatus',$sStatus);
      View::set('header',$this->_contenedor->header(''));
      View::set('footer',$this->_contenedor->footer($extraFooter));
      View::render("perfil_edit");
    }

    public function delete(){
      $id = MasterDom::getDataAll('borrar');
      $array = array();
      foreach ($id as $key => $value) {
        $id = AeropuertosDao::delete($value);
        if($id['seccion'] == 2){
          array_push($array, array('seccion' => 2, 'id' => $id['id'] ));
        }else if($id['seccion'] == 1){
          array_push($array, array('seccion' => 1, 'id' => $id['id'] ));
        }
      }
      $this->alertas("Eliminacion de Perfil", $array, "/Aeropuertos/");
    }

     public function AeropuertosAdd(){
      $perfil = new \stdClass();
      $perfil->_nombre = MasterDom::getData('nombre');
      $perfil->_descripcion = MasterDom::getData('descripcion');
      $perfil->_status = MasterDom::getData('status');

      $id = AeropuertosDao::insert($perfil);
      if($id >= 1){
        $this->alerta($id,'add');
      }else{
        $this->alerta($id,'error');
      }


    }

    public function perfilAdd1(){

      $perfil = new \stdClass();
      $perfil->_nombre = MasterDom::getData('nombre');


      for ($i=1; $i <= 12; $i++) {
        $seccion = "seccion" . $i;
        $agregar = "agregar" . $i;
        $editar = "editar" . $i;
        $eliminar = "eliminar" . $i;
        $variable = 0;
        $varAgregar = 0;
        $varEditar = 0;
        $varEliminar = 0;
        if(MasterDom::getData($seccion) != ""){
          $variable = (MasterDom::getData($seccion) != "") ? $i : 0;
          $varAgregar = (MasterDom::getData($agregar) != "") ? 2 : 0;
          $varEditar = (MasterDom::getData($editar) != "") ? 3 : 0;
          $varEliminar = (MasterDom::getData($eliminar) != "") ? 4 : 0;
        }
        $muestra = $variable."-".$varAgregar."-".$varEditar."-".$varEliminar;
        $sel = "_seccion" . $i;
        $add = "_agregar" . $i;
        $edi = "_editar" . $i;
        $eli = "_eliminar" . $i;
        $permisos = "_permisos".$i;
        $perfil->$permisos = $muestra;
      }
      $perfil->_permisos_globales = (MasterDom::getData('permisos_globales') != "") ? 1 : 0;
      $perfil->_descripcion = MasterDom::getData('descripcion');
      $perfil->_status = MasterDom::getData('status');

      $id = AeropuertosDao::insert($perfil);
      if($id >= 1){
        $this->alerta($id,'add');
      }else{
        $this->alerta($id,'error');
      }
    }

    public function perfilEdit(){
      $perfil = new \stdClass();
      $perfil->_perfil_id = MasterDom::getData('perfil_id');
      $perfil->_nombre = MasterDom::getData('nombre');
      $perfil->_descripcion = MasterDom::getData('descripcion');
      $perfil->_status = MasterDom::getData('status');
      $id = AeropuertosDao::update($perfil);
      if($id >= 1){
        $this->alerta($id,'edit');
      }else{
        $this->alerta($id,'error');
      }
    }

    public function isValidateUser(){
      $dato = AeropuertosDao::getUser($_POST['usuario']);
      if($dato == 1){
        echo "true";
      }else{
        echo "false";
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
      <H1 class="titulo">Aeropuertos</H1>
      <table border="0" style="width:100%;text-align: center">
          <tr style="background-color:#B8B8B8;">
          <th><strong>Id</strong></th>
          <th><strong>Nombre</strong></th>
          <th><strong>Descripción</strong></th>
          <th><strong>Estatus</strong></th>
          </tr>
html;

      if($ids!=''){
        foreach ($ids as $key => $value) {
          $perfil = AeropuertosDao::getByIdReporte($value);
            $tabla.=<<<html
              <tr style="background-color:#B8B8B8;">
              <td style="height:auto; width: 200px;background-color:#E4E4E4;">{$perfil['perfil_id']}</td>
              <td style="height:auto; width: 200px;background-color:#E4E4E4;">{$perfil['nombre']}</td>
              <td style="height:auto; width: 200px;background-color:#E4E4E4;">{$perfil['descripcion']}</td>
              <td style="height:auto; width: 200px;background-color:#E4E4E4;">{$perfil['nombre_status']}</td>
              </tr>
html;
        }
      }else{
        foreach (AeropuertosDao::getAll() as $key => $perfil) {
          $tabla.=<<<html
            <tr style="background-color:#B8B8B8;">
            <td style="height:auto; width: 200px;background-color:#E4E4E4;">{$perfil['perfil_id']}</td>
            <td style="height:auto; width: 200px;background-color:#E4E4E4;">{$perfil['nombre']}</td>
            <td style="height:auto; width: 200px;background-color:#E4E4E4;">{$perfil['descripcion']}</td>
            <td style="height:auto; width: 200px;background-color:#E4E4E4;">{$perfil['nombre_status']}</td>
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
      //echo shell_exec('php -f /home/granja/backend/public/librerias/mpdf_apis/Api.php Aeropuertos '.json_encode(MasterDom::getDataAll('borrar')));
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


      $fila = 5;
      $adaptarTexto = true;

      $controlador = "Aeropuertos";
      $columna = array('A','B','C','D');
      $nombreColumna = array('Id','Nombre','Descripción','Estatus');
      $nombreCampo = array('perfil_id','nombre','descripcion','nombre_status');

      $objPHPExcel->getActiveSheet()->SetCellValue('A'.$fila, 'Reporte de Aeropuertos');
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
          $Aeropuertos = AeropuertosDao::getByIdReporte($value);
          foreach ($nombreCampo as $key => $campo) {
            $objPHPExcel->getActiveSheet()->SetCellValue($columna[$key].$fila, $Aeropuertos[$campo]);
            $objPHPExcel->getActiveSheet()->getStyle($columna[$key].$fila)->applyFromArray($estilo_celda);
            $objPHPExcel->getActiveSheet()->getStyle($columna[$key].$fila)->getAlignment()->setWrapText($adaptarTexto);
          }
          $fila +=1;
        }
      }else{
        foreach (AeropuertosDao::getAll() as $key => $value) {
          foreach ($nombreCampo as $key => $campo) {
            $objPHPExcel->getActiveSheet()->SetCellValue($columna[$key].$fila, $value[$campo]);
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
      $regreso = "/Aeropuertos/";

      if($parametro == 'add'){
        $mensaje = "Se ha agregado correctamente";
        $class = "success";
      }

      if($parametro == 'edit'){
        $mensaje = "Se ha modificado correctamente";
        $class = "success";
      }

      if($parametro == 'nothing'){
        $mensaje = "Al parecer no intentaste actualizar ningún campo";
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
              <h4>El ID <b>{$value['id']}</b>, no se puede eliminar, ya que esta siendo utilizado por el Catálogo de Gestión Colaboradores</h4>
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
