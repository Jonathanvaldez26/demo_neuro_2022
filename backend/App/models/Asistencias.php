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
            INSERT INTO asistencias(id_asistencia, clave, nombre, descripcion, fecha_asistencia, hora_asistencia_inicio, hora_asistencia_fin, url, utilerias_administrador_id)
            VALUES(null, :clave, :nombre, :descripcion, :fecha_asistencia, :hora_asistencia_inicio, :hora_asistencia_fin, :url, :utilerias_administrador_id);
sql;


            $parametros = array(
            
            ':clave'=>$data->_clave,
            ':nombre'=>$data->_nombre,
            ':descripcion'=>$data->_descripcion,
            ':fecha_asistencia'=>$data->_fecha_asistencia,
            ':hora_asistencia_inicio'=>$data->_hora_asistencia_inicio,
            ':hora_asistencia_fin'=>$data->_hora_asistencia_fin,
            ':url'=> $data->_url,
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