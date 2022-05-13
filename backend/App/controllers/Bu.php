<?php
namespace App\controllers;
defined("APPPATH") OR die("Access denied");

use \Core\View;
use \Core\MasterDom;
use \App\controllers\Contenedor;
use \Core\Controller;
use \App\models\Bu AS BuDao;

class Bu extends Controller{

    private $_contenedor;

    function __construct(){
        parent::__construct();
        $this->_contenedor = new Contenedor;
        View::set('header',$this->_contenedor->header());
        View::set('footer',$this->_contenedor->footer());
        if(Controller::getPermisosUsuario($this->__usuario, "seccion_bu",1) == 0)
          header('Location: /Principal/');

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

          $('#bu-list').DataTable({
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
            } );

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
      $bu = BuDao::getAll();
      $tabla= '';
      foreach ($bu as $key => $value) {
        $tabla.=<<<html
                <tr>
                <!--td><input type="checkbox" name="borrar[]" value="{$value['clave']}"/></td-->
                <td><h6 class="mb-0 text-sm">{$value['nombre']}</h6></td>
           
                <td><p class="text-sm text-secondary mb-0">{$value['fecha_alta']}</p></td>
                <td><h6 class="mb-0 text-sm">{$value['creo']}</h6></td>
                </tr>
html;
      }

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
      View::render("Bu_All");
    }

    public function Add(){
      $extraFooter =<<<html
     <script>
        $(document).ready(function(){
          $("#add").validate({
            rules:{
              nombre_bu:{
                required: true
              }
            },
            messages:{
              nombre_bu:{
                required: "Este campo es requerido"
              }
            }
          });//fin del jquery validate
       

          $("#btnCancel").click(function(){
            window.location.href = "/Bu/";
          });//fin del btnAdd

        });//fin del document.ready
      </script>
html;

      View::set('header',$this->_contenedor->header(''));
      View::render("bu_add");
      View::set('footer',$this->_contenedor->footer($extraFooter));

    }

    public function BuAdd(){
        $bu = new \stdClass();

        $nombre_bu = MasterDom::getDataAll('nombre_bu');
        $nombre_bu = MasterDom::procesoAcentosNormal($nombre_bu);
        $bu->_nombre_bu = $nombre_bu;


        $id = BuDao::insert($bu);
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
      $empresa = BuDao::getById($id);

      $status = "";
      foreach (BuDao::getStatus() as $key => $value) {
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
      $empresa = BuDao::getById($id);
      View::set('empresa',$empresa);
      View::set('header',$header);
      View::set('footer',$this->_contenedor->footer($extraFooter));
      View::render("empresa_view");
    }

    public function delete(){
      $id = MasterDom::getDataAll('borrar');
      $array = array();
      foreach ($id as $key => $value) {
        $id = BuDao::delete($value);
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
      $id = BuDao::verificarRelacion(MasterDom::getData('catalogo_empresa_id'));
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
          if(BuDao::update($empresa) > 0)
            $this->alerta($id,'edit');
          else
            $this->alerta($id,'nothing');
        }else{
          $this->alertas("Eliminacion de Empresas", $array, "/Empresa/");
        }
      }

      if($id['seccion'] == 1){
        array_push($array, array('seccion' => 1, 'id' => $id['id'] ));

        //$id = BuDao::update($empresa);

        if(MasterDom::getData('status') == 2){
          BuDao::update($empresa);
          $this->alerta(MasterDom::getData('catalogo_empresa_id'),'delete');
        }else{
          if(BuDao::update($empresa) >= 1) $this->alerta($id,'edit');
          else $this->alerta("",'no_cambios');
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
          $empresa = BuDao::getByIdReporte($value);
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
        foreach (BuDao::getAll() as $key => $empresa) {
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
          $empresa = BuDao::getByIdReporte($value);
          foreach ($nombreCampo as $key => $campo) {
            $objPHPExcel->getActiveSheet()->SetCellValue($columna[$key].$fila, html_entity_decode($empresa[$campo], ENT_QUOTES, "UTF-8"));
            $objPHPExcel->getActiveSheet()->getStyle($columna[$key].$fila)->applyFromArray($estilo_celda);
            $objPHPExcel->getActiveSheet()->getStyle($columna[$key].$fila)->getAlignment()->setWrapText($adaptarTexto);
          }
          $fila +=1;
        }
      }else{
        foreach (BuDao::getAll() as $key => $value) {
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
      $regreso = "/Bu/";

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

      $extraFooter =<<<html
        
html;

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
