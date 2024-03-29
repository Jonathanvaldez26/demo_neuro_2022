<?php

namespace App\controllers;

defined("APPPATH") or die("Access denied");

use \Core\View;
use \Core\MasterDom;
use \App\controllers\Contenedor;
use \Core\Controller;
use \App\models\PruebasCovidSitio as PruebasCovidSitioDao;
use \App\models\Asistencias as AsistenciasDao;
use \DateTime;
use \DatetimeZone;
use \App\models\Linea as LineaDao;

class Asistencias extends Controller
{

  private $_contenedor;

  function __construct()
  {
    parent::__construct();
    $this->_contenedor = new Contenedor;
    View::set('header', $this->_contenedor->header());
    View::set('footer', $this->_contenedor->footer());
    if (Controller::getPermisosUsuario($this->__usuario, "seccion_asistencias", 1) == 0)
      header('Location: /Principal/');
  }

  public function getUsuario()
  {
    return $this->__usuario;
  }

  public function index()
  {
    $extraHeader = <<<html
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

$extraFooter =<<<html
      <script>
        $(document).ready(function(){

          $('#asistencia-list').DataTable({
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
    $tabla = '';
    // $url_checkin = '#';
    // $url_directivos	= '#';
    // $url_staf	= '#';
    // $url_neurociencias	= '#';
    // $url_kaes_osteo	= '#';
    // $url_cardio	= '#';
    // $url_uro	= '#';
    // $url_gastro	= '#';
    // $url_gineco	= '#';
    // $url_medicina_general	= '#';
    // $url_ole	= '#';
    // $url_analgesia= '#';
    $datos = AsistenciasDao::getAll();
    
    foreach ($datos as $key => $value) {

      // var_dump($value['es_ckeckin']);
        if($value['es_ckeckin'] == 1){
          $url_checkin = $value['url_checkin'];
          $url_directivos	= $value['url_directivos'];
          
          $url_staf	= $value['url_staf'];
          $url_neurociencias	= $value['url_neurociencias	'];
          $url_kaes_osteo	= $value['url_checkinurl_kaes_osteo'];
          $url_cardio	= $value['url_cardio'];
          $url_uro	= $value['url_uro'];
          $url_gastro	= $value['url_gastro'];
          $url_gineco	= $value['url_gineco'];
          $url_medicina_general	= $value['url_medicina_general'];
          $url_ole	= $value['url_ole'];
          $url_analgesia= $value['url_analgesia'];

          $style_checkin = "display:block";

          $style_directivos = "display:block";
         
          $style_staf = "display:block";
        
          $style_neurociencias = "display:block";
        
          $style_kaes_osteo = "display:block";
        
          $style_cardio = "display:block";
      
          $style_uro = "display:block";
      
          $style_gastro = "display:block";
        
          $style_gineco = "display:block";
        
          $style_medicina_general = "display:block";
        
          $style_ole = "display:block";
        
          $style_analgecia = "display:block";

          
        }else if($value['es_ckeckin'] == '0'){

          if($value['es_ckeckin'] == '0'){
            $url_checkin = "#";
            $style_checkin = "display:none";
          }
          else{
            $url_checkin = $value['url_checkin'];
          }

          
          
          if($value['url_directivos'] == '0'){
            $url_directivos = "#";
            $style_directivos = "display:none";
          }
          else{
            $url_directivos	= $value['url_directivos'];
          }
  
          if($value['url_staf'] == '0'){
            $url_staf = "#";
            $style_staf = "display:none";
          }
          else{
            $url_staf	= $value['url_staf'];
          }
  
          if($value['url_neurociencias'] == '0'){
            $url_neurociencias = "#";
            $style_neurociencias = "display:none";
          }
          else{
            $url_neurociencias	= $value['url_neurociencias'];
          }
  
          if($value['url_kaes_osteo'] == '0'){
            $url_kaes_osteo = "#";
            $style_kaes_osteo = "display:none";
          }
          else{
            $url_kaes_osteo	= $value['url_kaes_osteo'];
          }
  
          if($value['url_cardio'] == '0'){
            $url_cardio = "#";
            $style_cardio = "display:none";
          }
          else{
            $url_cardio	= $value['url_cardio'];
          }
  
          if($value['url_uro'] == '0'){
            $url_uro =  "#";
            $style_uro = "display:none";
          }
          else{
            $url_uro	= $value['url_uro'];
          }
  
          if($value['url_gastro'] == '0'){
            $url_gastro = "#";
            $style_gastro = "display:none";
          }
          else{
            $url_gastro	= $value['url_gastro'];
          }
  
          if($value['url_gineco'] == '0'){
            $url_gineco = "#";
            $style_gineco = "display:none";
          }
          else{
            $url_gineco	= $value['url_gineco'];
          }
  
          if($value['url_medicina_general'] == '0'){
            $url_medicina_general = "#";
            $style_medicina_general = "display:none";
          }
          else{
            $url_medicina_general	= $value['url_medicina_general'];
          }
  
          if($value['url_ole'] == '0'){
            $url_ole = "#";
            $style_ole = "display:none";
          }
          else{
            $url_ole	= $value['url_ole'];
          }
  
          if($value['url_analgesia'] == '0'){
            $url_analgesia = "#";
            $style_analgecia = "display:none";
          }
          else{
            $url_analgesia= $value['url_analgesia'];
          }
          
          
        }


        
      
      $tabla.=<<<html
      <tr>
        <td>{$value['nombre']}</td>
        <td>{$value['descripcion']}</td>
        <td class="text-center">{$value['fecha_asistencia']}</td>
        <td class="text-center">{$value['hora_asistencia_inicio']}</td>
        <td class="text-center"><i class='fa-alarm-clock'></i>{$value['hora_asistencia_fin']}</td>
        <td class="text-center"><a href='{$url_directivos}' style='{$style_directivos}'><i class='fas fa-globe'></i></a></td>
        <td class="text-center"><a href='{$url_staf}' style='{$style_staf}'><i class='fas fa-globe'></i></a></td>
        <td class="text-center"><a href='{$url_neurociencias}' style='{$style_neurociencias}'><i class='fas fa-globe'></i></a></td>
        <td class="text-center"><a href='{$url_kaes_osteo}' style='{$style_kaes_osteo}'><i class='fas fa-globe'></i></a></td>
        <td class="text-center"><a href='{$url_cardio}' style='{$style_cardio}'><i class='fas fa-globe'></i></a></td>
        <td class="text-center"><a href='{$url_uro}' style='{$style_uro}'><i class='fas fa-globe'></i></a></td>
        <td class="text-center"><a href='{$url_gastro}' style='{$style_gastro}'><i class='fas fa-globe'></i></a></td>
        <td class="text-center"><a href='{$url_gineco}' style='{$style_gineco}'><i class='fas fa-globe'></i></a></td>
        <td class="text-center"><a href='{$url_medicina_general}' style='{$style_medicina_general}'><i class='fas fa-globe'></i></a></td>
        <td class="text-center"><a href='{$url_ole}' style='{$style_ole}'><i class='fas fa-globe'></i></a></td>
        <td class="text-center"><a href='{$url_analgesia}' style='{$style_analgecia}'><i class='fas fa-globe'></i></a></td>
        <td class="text-center"><a href='{$url_checkin}' style='{$style_checkin}'><i class='fas fa-globe'></i></a></td>
      </tr>
 
html;
}

      $lineas = '';
    
      foreach (LineaDao::getLineasEjecutivo() as $key => $value) {
        $lineas .= <<<html
                  <option value="{$value['id_linea_ejecutivo']}-{$value['nombre']}">{$value['nombre']}</option>
html;
      }


      View::set('lineas',$lineas);
      View::set('tabla',$tabla);
      View::set('header',$this->_contenedor->header($extraHeader));
      View::set('footer',$this->_contenedor->footer($extraFooter));
      View::render("asistencias_all");
    }
  

    public function asistenciasAdd() {

      $data = new \stdClass();
      $data->_clave = $this->generateRandomString();
      $data->_nombre = MasterDom::getData('nombre');
      $data->_descripcion = MasterDom::getData('descripcion');
      $data->_fecha_asistencia = MasterDom::getData('fecha_asistencia');
      $data->_hora_asistencia_inicio = MasterDom::getData('hora_asistencia_inicio');
      $data->_hora_asistencia_fin = MasterDom::getData('hora_asistencia_fin');
      $data->_es_ckeckin = MasterDom::getData('checkin');
      $data->_es_plenaria_individual = MasterDom::getData('plenaria');
      $data->_utilerias_administrador_id = $_SESSION['utilerias_administradores_id'];
      $linea = MasterDom::getData('id_linea');     
      $nombre_linea = explode("-", $linea);
      $nombre_linea = $nombre_linea[1];

     

      if($data->_es_ckeckin == 1){
        $data->_url_checkin = "/Checkin/General/"."".$data->_clave;
        $data->_plenaria_general = '0';
        $data->_url_plenaria_general = "0";
        $data->_es_plenaria_individual = '0';
        $data->_es_prueba_covid = '0';
        $data->_url_prueba_covid = '0';
        $data->_url_directivos = "/Checkin/DIRECTIVOS/"."".$data->_clave;
        $data->_url_staf = "/Checkin/STAFF/"."".$data->_clave;
        $data->_url_neurociencias = "/Checkin/NEUROCIENCIAS/"."".$data->_clave;
        $data->_url_kaes_osteo = "/Checkin/KAESOSTEO/"."".$data->_clave;
        $data->_url_cardio = "/Checkin/CARDIO/"."".$data->_clave;
        $data->_url_uro = "/Checkin/URO/"."".$data->_clave;
        $data->_url_gastro = "/Checkin/GASTRO/"."".$data->_clave;
        $data->_url_gineco = "/Checkin/GINECO/"."".$data->_clave;
        $data->_url_medicina_general = "/Checkin/MEDICINA GENERAL/"."".$data->_clave;
        $data->_url_ole = "/Checkin/OLE/"."".$data->_clave;
        $data->_url_analgesia = "/Checkin/ANALGESIA/"."".$data->_clave;
       
      }else{

        if($data->_es_plenaria_individual == 0){

          $data->_url_checkin = "/Checkin/General/"."".$data->_clave;
          $data->_plenaria_general = "1";
          $data->_url_plenaria_general = "/Checkin/General/"."".$data->_clave;
          $data->_es_prueba_covid = '0';
          $data->_url_prueba_covid = '0';
          $data->_url_directivos = "/Checkin/DIRECTIVOS/"."".$data->_clave;
          $data->_url_staf = "/Checkin/STAFF/"."".$data->_clave;
          $data->_url_neurociencias = "/Checkin/NEUROCIENCIAS/"."".$data->_clave;
          $data->_url_kaes_osteo = "/Checkin/KAESOSTEO/"."".$data->_clave;
          $data->_url_cardio = "/Checkin/CARDIO/"."".$data->_clave;
          $data->_url_uro = "/Checkin/URO/"."".$data->_clave;
          $data->_url_gastro = "/Checkin/GASTRO/"."".$data->_clave;
          $data->_url_gineco = "/Checkin/GINECO/"."".$data->_clave;
          $data->_url_medicina_general = "/Checkin/MEDICINA GENERAL/"."".$data->_clave;
          $data->_url_ole = "/Checkin/OLE/"."".$data->_clave;
          $data->_url_analgesia = "/Checkin/ANALGESIA/"."".$data->_clave;
         
          
        }else{

          $data->_url_checkin = "/Checkin/General/"."".$data->_clave;
          $data->_plenaria_general = '0';
          $data->_url_plenaria_general = "0";
          $data->_es_prueba_covid = '0';
          $data->_url_prueba_covid = '0';
   

          if($nombre_linea == 'DIRECTIVOS'){

            $data->_url_directivos = "/Checkin/DIRECTIVOS/"."".$data->_clave;
            $data->_url_staf = "0";
            $data->_url_neurociencias = "0";
            $data->_url_kaes_osteo = "0";
            $data->_url_cardio = "0";
            $data->_url_uro = "0";
            $data->_url_gastro = "0";
            $data->_url_gineco = "0";
            $data->_url_medicina_general = "0";
            $data->_url_ole = "0";
            $data->_url_analgesia = "0";

          }else if($nombre_linea == 'STAFF'){
            $data->_url_directivos = "0";
            $data->_url_staf = "/Checkin/STAFF/"."".$data->_clave;
            $data->_url_neurociencias = "0";
            $data->_url_kaes_osteo = "0";
            $data->_url_cardio = "0";
            $data->_url_uro = "0";
            $data->_url_gastro = "0";
            $data->_url_gineco = "0";
            $data->_url_medicina_general = "0";
            $data->_url_ole = "0";
            $data->_url_analgesia = "0";

          }
          else if($nombre_linea == 'NEUROCIENCIAS'){

            $data->_url_directivos = "0";
            $data->_url_staf = "0";
            $data->_url_neurociencias = "/Checkin/NEUROCIENCIAS/"."".$data->_clave;
            $data->_url_kaes_osteo = "0";
            $data->_url_cardio = "0";
            $data->_url_uro = "0";
            $data->_url_gastro = "0";
            $data->_url_gineco = "0";
            $data->_url_medicina_general = "0";
            $data->_url_ole = "0";
            $data->_url_analgesia = "0";
            
          }else if($nombre_linea == 'KAES / OSTEO'){

            $data->_url_directivos = "0";
            $data->_url_staf = "0";
            $data->_url_neurociencias ="0";
            $data->_url_kaes_osteo = "/Checkin/KAESOSTEO/"."".$data->_clave;
            $data->_url_cardio = "0";
            $data->_url_uro = "0";
            $data->_url_gastro = "0";
            $data->_url_gineco = "0";
            $data->_url_medicina_general = "0";
            $data->_url_ole = "0";
            $data->_url_analgesia = "0";
            
          }else if($nombre_linea == 'CARDIO'){

            $data->_url_directivos = "0";
            $data->_url_staf = "0";
            $data->_url_neurociencias = "0";
            $data->_url_kaes_osteo = "0";
            $data->_url_cardio = "/Checkin/CARDIO/"."".$data->_clave;
            $data->_url_uro = "0";
            $data->_url_gastro = "0";
            $data->_url_gineco = "0";
            $data->_url_medicina_general = "0";
            $data->_url_ole = "0";
            $data->_url_analgesia = "0";
            
          }else if($nombre_linea == 'URO'){

            $data->_url_directivos = "0";
            $data->_url_staf = "0";
            $data->_url_neurociencias = "0";
            $data->_url_kaes_osteo = "0";
            $data->_url_cardio = "0";
            $data->_url_uro = "/Checkin/URO/"."".$data->_clave;
            $data->_url_gastro = "0";
            $data->_url_gineco = "0";
            $data->_url_medicina_general = "0";
            $data->_url_ole = "0";
            $data->_url_analgesia = "0";
            
          }else if($nombre_linea == 'GASTRO'){

            $data->_url_directivos = "0";
            $data->_url_staf = "0";
            $data->_url_neurociencias = "0";
            $data->_url_kaes_osteo = "0";
            $data->_url_cardio = "0";
            $data->_url_uro = "0";
            $data->_url_gastro = "/Checkin/GASTRO/"."".$data->_clave;
            $data->_url_gineco = "0";
            $data->_url_medicina_general = "0";
            $data->_url_ole = "0";
            $data->_url_analgesia = "0";
            
          }else if($nombre_linea == 'GINECO'){

            $data->_url_directivos = "0";
            $data->_url_staf = "0";
            $data->_url_neurociencias = "0";
            $data->_url_kaes_osteo = "0";
            $data->_url_cardio = "0";
            $data->_url_uro = "0";
            $data->_url_gastro = "0";
            $data->_url_gineco = "/Checkin/GINECO/"."".$data->_clave;
            $data->_url_medicina_general = "0";
            $data->_url_ole = "0";
            $data->_url_analgesia = "0";
            
          }else if($nombre_linea == 'MEDICINA GENERAL'){

            $data->_url_directivos = "0";
            $data->_url_staf = "0";
            $data->_url_neurociencias = "0";
            $data->_url_kaes_osteo = "0";
            $data->_url_cardio = "0";
            $data->_url_uro = "0";
            $data->_url_gastro = "0";
            $data->_url_gineco = "0";
            $data->_url_medicina_general = "/Checkin/MEDICINA GENERAL/"."".$data->_clave;
            $data->_url_ole = "0";
            $data->_url_analgesia = "0";
            
          }else if($nombre_linea == 'OLE'){

            $data->_url_directivos = "0";
            $data->_url_staf = "0";
            $data->_url_neurociencias = "0";
            $data->_url_kaes_osteo = "0";
            $data->_url_cardio = "0";
            $data->_url_uro = "0";
            $data->_url_gastro = "0";
            $data->_url_gineco = "0";
            $data->_url_medicina_general = "0";
            $data->_url_ole = "/Checkin/OLE/"."".$data->_clave;
            $data->_url_analgesia = "0";
            
          }else if($nombre_linea == 'ANALGESIA'){

            $data->_url_directivos = "0";
            $data->_url_staf = "0";
            $data->_url_neurociencias = "0";
            $data->_url_kaes_osteo = "0";
            $data->_url_cardio = "0";
            $data->_url_uro = "0";
            $data->_url_gastro = "0";
            $data->_url_gineco = "0";
            $data->_url_medicina_general = "0";
            $data->_url_ole = "0";
            $data->_url_analgesia = "/Checkin/ANALGESIA/"."".$data->_clave;
            
          }
        }

        
      }

  
      $id = AsistenciasDao::insert($data);
      if($id >= 1){
        // $this->alerta($id,'add');
        echo '<script>
          alert("Asistencia Registrada con exito");
          window.location.href = "/Asistencias";
        </script>';
      }else{
        // $this->alerta($id,'error');
        echo '<script>
        alert("Error al registrar la aistencia, consulte a soporte");
        window.location.href = "/Asistencias";
      </script>';
      }


    }


    public function alerta($id, $parametro){
      $regreso = "/Asistencias/";

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



    function generateRandomString($length = 6) { 
      return substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, $length); 
  } 

  // View::set('permisoGlobalHidden', $permisoGlobalHidden);
  // View::set('asistentesHidden', $asistentesHidden);
  // View::set('vuelosHidden', $vuelosHidden);
  // View::set('pickUpHidden', $pickUpHidden);
  // View::set('habitacionesHidden', $habitacionesHidden);
  // View::set('cenasHidden', $cenasHidden);
  // View::set('aistenciasHidden', $aistenciasHidden);
  // View::set('vacunacionHidden', $vacunacionHidden);
  // View::set('pruebasHidden', $pruebasHidden);
  // View::set('configuracionHidden', $configuracionHidden);
  // View::set('utileriasHidden', $utileriasHidden);
  // View::set('header', $this->_contenedor->header($extraHeader));
  // View::set('footer', $this->_contenedor->footer($extraFooter));
  // View::render("asistencias_all");

}
