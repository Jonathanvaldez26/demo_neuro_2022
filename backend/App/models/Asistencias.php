<?php
namespace App\models;
defined("APPPATH") OR die("Access denied");

use \Core\Database;
use \Core\MasterDom;
use \App\interfaces\Crud;
use \App\controllers\UtileriasLog;

class Asistencias implements Crud{
    public static function getAll(){
      $mysqli = Database::getInstance();
      $query=<<<sql
      SELECT * FROM asistencias
sql;
      return $mysqli->queryAll($query);
        
    }
    public static function getById($id){
         
    }
    public static function insert($data){
        $mysqli = Database::getInstance(1);
        $query=<<<sql
            INSERT INTO asistencias(id_asistencia, clave, nombre, descripcion, fecha_asistencia, hora_asistencia_inicio, hora_asistencia_fin, es_ckeckin, url_checkin, plenaria_general, url_plenaria_general, es_plenaria_individual, es_prueba_covid, url_prueba_covid, url_directivos, url_staf, url_neurociencias, url_kaes_osteo, url_cardio, url_uro, url_gastro, url_gineco, url_medicina_general, url_ole, url_analgesia, utilerias_administrador_id)
            VALUES(null, :clave, :nombre, :descripcion, :fecha_asistencia, :hora_asistencia_inicio, :hora_asistencia_fin, :es_ckeckin, :url_checkin, :plenaria_general, :url_plenaria_general, :es_plenaria_individual, :es_prueba_covid, :url_prueba_covid, :url_directivos, :url_staf, :url_neurociencias, :url_kaes_osteo, :url_cardio, :url_uro, :url_gastro, :url_gineco, :url_medicina_general, :url_ole, :url_analgesia, :utilerias_administrador_id);
sql;


            $parametros = array(
            
            ':clave'=>$data->_clave,
            ':nombre'=>$data->_nombre,
            ':descripcion'=>$data->_descripcion,
            ':fecha_asistencia'=>$data->_fecha_asistencia,
            ':hora_asistencia_inicio'=>$data->_hora_asistencia_inicio,
            ':hora_asistencia_fin'=>$data->_hora_asistencia_fin,
            ':es_ckeckin'=>$data->_es_ckeckin,
            ':url_checkin'=> $data->_url_checkin,
            ':plenaria_general'=> $data->_plenaria_general,
            ':url_plenaria_general'=> $data->_url_plenaria_general,
            ':es_plenaria_individual'=> $data->_es_plenaria_individual,
            ':es_prueba_covid'=> $data->_es_prueba_covid,
            ':url_prueba_covid'=> $data->_url_prueba_covid,
            ':url_directivos'=> $data->_url_directivos,
            ':url_staf'=> $data->_url_staf,
            ':url_neurociencias'=> $data->_url_neurociencias,
            ':url_kaes_osteo'=> $data->_url_kaes_osteo,
            ':url_cardio'=> $data->_url_cardio,
            ':url_uro'=> $data->_url_uro,
            ':url_gastro'=> $data->_url_gastro,
            ':url_gineco'=> $data->_url_gineco,
            ':url_medicina_general'=> $data->_url_medicina_general,
            ':url_ole'=> $data->_url_ole,
            ':url_analgesia'=> $data->_url_analgesia,
            ':utilerias_administrador_id'=> $data->_utilerias_administrador_id
           
            );
 
            $id = $mysqli->insert($query,$parametros);



            //UtileriasLog::addAccion($accion);
            return $id;
         
    }
    public static function update($data){
        
    }
    public static function delete($id){
        
    }
} 