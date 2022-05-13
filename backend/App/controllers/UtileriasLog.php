<?php
namespace App\controllers;
defined("APPPATH") OR die("Access denied");

use \Core\View;
use \Core\MasterDom;
use \App\controllers\Contenedor;
use \Core\Controller;
use \App\models\UtileriasLog AS UtileriasLogDao;

ini_set('memory_limit', '-1');

class UtileriasLog extends Controller{

    private $_contenedor;

    function __construct(){
        parent::__construct();
        $this->_contenedor = new Contenedor;
        View::set('header',$this->_contenedor->header());
        View::set('footer',$this->_contenedor->footer());

        if(Controller::getPermisosUsuario($this->__usuario, "permisos_globales",7) == 0)
          header('Location: /Home/');
    }

    public function index() {
      $extraFooter =<<<html
      <script src="/js/moment/moment.min.js"></script>
      <script src="/js/datepicker/scriptdatepicker.js"></script>
      <script src="/js/datepicker/datepicker2.js"></script>

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
              $('#all').attr('action', '/UtileriasLog/generarPDF/');
              $('#all').attr('target', '_blank');
              $("#all").submit();
            });

            $("#export_excel").click(function(){
              $('#all').attr('action', '/UtileriasLog/generarExcel/');
              $('#all').attr('target', '_blank');
              $("#all").submit();
            });

            $("#btnFiltro").click(function(){
              $('#all').attr('action', '/UtileriasLog/index');
              $('#all').attr('target', '');
              $("#all").submit();
            });

        });
      </script>
html;

      $fecha_inicio = MasterDom::getData('fecha_inicio');
      $fecha_fin = MasterDom::getData('fecha_fin');

      $where = '';
      if($fecha_inicio!='' || $fecha_fin!=''){
        $where = 'WHERE ';
        $where .= ($fecha_inicio!='')? 'fecha >=\''.$fecha_inicio.'\'' : '';
        $where .= ($fecha_inicio!='' && $fecha_fin!='')? ' AND ' : '';
        $where .= ($fecha_fin!='')? 'fecha <= \''.$fecha_fin.'\'' : '';
      }

      $logs = UtileriasLogDao::getAllFiltro($where);
      $tabla= '';
      foreach ($logs as $key => $value) {
        $tabla.=<<<html
                <tr>
                    <!--<td><input type="checkbox" name="borrar[]" value="{$value['log_id']}"/></td>-->
                    <td>{$value['fecha']}</td>
                    <td>{$value['usuario']}</td>
                    <td>{$value['descripcion']}</td>
                    <td>{$value['accion']}</td>
                </tr>
html;
      }
      View::set('tabla',$tabla);
      View::set('fecha_inicio',$fecha_inicio);
      View::set('fecha_fin',$fecha_fin);
      View::set('header',$this->_contenedor->header(''));
      View::set('footer',$this->_contenedor->footer($extraFooter));
      View::render("log_all");
    }
    public static function add($accion){}


    public static function addAccion($accion){
      $sql = str_replace(array("'",'`'),array('',''),$accion->_sql);

      $parametros = $accion->_parametros;
      $log = new \stdClass();
      $log->_usuario = MasterDom::getSesion('usuario');
      $log->_ip = MasterDom::getIPClient();

      if(preg_match_all('/INSERT INTO [A-Za-z_]+/', $sql,$tabla)){
        $tabla = str_replace('INSERT INTO','',$tabla[0]);
        $log->_tabla = $tabla[0];
        $log->_accion = 'INSERT';
        $log->_descripcion = 'El usuario '.$log->_usuario.' ha insertado el registro '.$accion->_id.' en '.$log->_tabla;

        foreach ($parametros as $key => $value) {
          $sql = str_replace($key,$value,$sql);
        }
        $log->_accion_sql = $sql;
      }elseif (preg_match_all('/UPDATE [A-Za-z_]+/', $sql,$tabla)) {
        $tabla = str_replace('UPDATE ','',$tabla[0]);
        $log->_tabla = $tabla[0];
        $log->_accion = 'UPDATE';
        $log->_descripcion = 'El usuario '.$log->_usuario.' ha actualizado el registro '.$accion->_id.' en '.$log->_tabla;

        foreach ($parametros as $key => $value) {
          $sql = str_replace($key,$value,$sql);
        }
        $log->_accion_sql = $sql;
      }elseif (preg_match_all('/DELETE FROM [A-Za-z_]+/', $sql,$tabla)) {
        $tabla = str_replace('DELETE FROM ','',$tabla[0]);
        $log->_tabla = $tabla[0];
        $log->_accion = 'DELETE';
        $log->_descripcion = 'El usuario '.$log->_usuario.' ha eliminado el registro '.$accion->_id.' en '.$log->_tabla;

        foreach ($parametros as $key => $value) {
          $sql = str_replace($key,$value,$sql);
        }
        $log->_accion_sql = $sql;
      }
      UtileriasLogDao::insert($log);
    }

    public function edit($id){}

    public function delete(){}

    public function generarPDF(){
      echo "Datos de borrar: ";
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
<link href="/css/styles_pdf.css" rel="stylesheet">
<img class="imagen" src="/img/ag_logo.png"/>
<br>
<div style="page-break-inside: avoid;" align='center'>
<H1 class="titulo">Logs</H1>
<table border="0" style="width:100%;text-align: center">
    <tr style="background-color:#B8B8B8;">
      <th><strong>Id</strong></th>
      <th><strong>Fecha</strong></th>
      <th><strong>Usuario</strong></th>
      <th><strong>Descripcion </strong></th>
      <th><strong>Acción </strong></th>
    </tr>
html;

      if($ids!=''){
        foreach ($ids as $key => $value) {
          $log = UtileriasLogDao::getById($value);
            $tabla.=<<<html
              <tr class="tr">
                <td style="height:auto; width: 200px;background-color:#E4E4E4;">{$log['log_id']}</td>
                <td style="height:auto; width: 200px;background-color:#E4E4E4;">{$log['fecha']}</td>
                <td style="height:auto; width: 200px;background-color:#E4E4E4;">{$log['usuario']}</td>
                <td style="height:auto; width: 200px;background-color:#E4E4E4;">{$log['descripcion']}</td>
                <td style="height:auto; width: 200px;background-color:#E4E4E4;">{$log['accion']}</td>
              </tr>
html;
        }
      }else{
        $fecha_inicio = MasterDom::getData('fecha_inicio');
        $fecha_fin = MasterDom::getData('fecha_fin');

        $where = '';
        if($fecha_inicio!='' || $fecha_fin!=''){
          $where = 'WHERE ';
          $where .= ($fecha_inicio!='')? 'fecha >=\''.$fecha_inicio.'\'' : '';
          $where .= ($fecha_inicio!='' && $fecha_fin!='')? ' AND ' : '';
          $where .= ($fecha_fin!='')? 'fecha <= \''.$fecha_fin.'\'' : '';
        }
        foreach (UtileriasLogDao::getAllFiltro($where) as $key => $log) {
          $tabla.=<<<html
            <tr style="background-color:#B8B8B8;">
              <td style="height:auto; width: 200px;background-color:#E4E4E4;">{$log['log_id']}</td>
              <td style="height:auto; width: 200px;background-color:#E4E4E4;">{$log['fecha']}</td>
              <td style="height:auto; width: 200px;background-color:#E4E4E4;">{$log['usuario']}</td>
              <td style="height:auto; width: 200px;background-color:#E4E4E4;">{$log['descripcion']}</td>
              <td style="height:auto; width: 200px;background-color:#E4E4E4;">{$log['accion']}</td>
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
      //echo shell_exec('php -f /home/granja/backend/public/librerias/mpdf_apis/Api.php Log '.json_encode(MasterDom::getDataAll('borrar')));
    }

    public function generarExcel(){
      $ids = MasterDom::getData('borrar');
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

      $controlador = "Log";
      $columna = array('A','B','C','D','E','F','G','H');
      $nombreColumna = array('Id','Fecha','Usuario','Descripción','Accion');
      $nombreCampo = array('log_id','fecha','usuario','descripcion','accion');

      $objPHPExcel->getActiveSheet()->SetCellValue('A'.$fila, 'Reporte de Logs');
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
          $empresa = UtileriasLogDao::getById($value);
          foreach ($nombreCampo as $key => $campo) {
            $objPHPExcel->getActiveSheet()->SetCellValue($columna[$key].$fila, html_entity_decode($empresa[$campo], ENT_QUOTES, "UTF-8"));
            $objPHPExcel->getActiveSheet()->getStyle($columna[$key].$fila)->applyFromArray($estilo_celda);
            $objPHPExcel->getActiveSheet()->getStyle($columna[$key].$fila)->getAlignment()->setWrapText($adaptarTexto);
          }
          $fila +=1;
        }
      }else{
        $fecha_inicio = MasterDom::getData('fecha_inicio');
        $fecha_fin = MasterDom::getData('fecha_fin');

        $where = '';
        if($fecha_inicio!='' || $fecha_fin!=''){
          $where = 'WHERE ';
          $where .= ($fecha_inicio!='')? 'fecha >=\''.$fecha_inicio.'\'' : '';
          $where .= ($fecha_inicio!='' && $fecha_fin!='')? ' AND ' : '';
          $where .= ($fecha_fin!='')? 'fecha <= \''.$fecha_fin.'\'' : '';
        }
        foreach (UtileriasLogDao::getAllFiltro($where) as $key => $value) {
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
      $regreso = "/Log/";

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
