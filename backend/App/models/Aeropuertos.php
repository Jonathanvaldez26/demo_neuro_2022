<?php
namespace App\models;
defined("APPPATH") OR die("Access denied");

use \Core\Database;
use \App\interfaces\Crud;
use \App\controllers\UtileriasLog;

class Aeropuertos implements Crud{

    public static function getAll(){

	      $mysqli = Database::getInstance();
        $query=<<<sql
        SELECT * FROM aeropuertos
sql;
        return $mysqli->queryAll($query);
    }

    public static function insert($aeropuerto){
	    $mysqli = Database::getInstance();
      $query=<<<sql
      INSERT INTO aeropuertos (id_aeropuerto, estado, ciudad, aeropuerto, iata) VALUES ( :estado, :ciudad, :aeropuerto, :iata);
sql;
      $parametros = array(
        ':estado'=>$aeropuerto->_estado,
        ':ciudad'=>$aeropuerto->_ciudad,
        ':aeropuerto'=>$aeropuerto->_aeropuerto,
        ':iata'=>$aeropuerto->_iata
      );
        $id = $mysqli->insert($query,$parametros);
        $accion = new \stdClass();
        $accion->_sql= $query;
        $accion->_parametros = $parametros;
        $accion->_id = $id;

        UtileriasLog::addAccion($accion);
        return $id;
    }

    public static function update($perfil){
      $mysqli = Database::getInstance(true);
      $query=<<<sql
      UPDATE utilerias_perfiles SET nombre = :nombre, descripcion = :descripcion, status = :status WHERE perfil_id = :perfil_id
sql;
      $parametros = array(
         ':perfil_id'=>$perfil->_perfil_id,
         ':nombre'=>$perfil->_nombre,
         ':descripcion'=>$perfil->_descripcion,
         ':status'=>$perfil->_status
      );
      $accion = new \stdClass();
      $accion->_sql= $query;
      $accion->_parametros = $parametros;
      $accion->_id = $perfil->_perfil_id;
      UtileriasLog::addAccion($accion);
        return $mysqli->update($query, $parametros);
    }

    public static function delete($id){
      $mysqli = Database::getInstance();
      /*$select = <<<sql
      SELECT e.catalogo_empresa_id FROM catalogo_empresa e JOIN catalogo_colaboradores c
      ON e.catalogo_empresa_id = c.catalogo_empresa_id WHERE e.catalogo_empresa_id = $id
sql;

      $sqlSelect = $mysqli->queryAll($select);
      if(count($sqlSelect) >= 1){
        return array('seccion'=>2, 'id'=>$id); // NO elimina
      }else{*/
        //UPDATE catalogo_empresa SET status = '2' WHERE catalogo_empresa.catalogo_empresa_id = $id;
        $query = <<<sql
        UPDATE utilerias_perfiles SET status = 2 WHERE utilerias_perfiles.perfil_id = $id;
sql;
        $mysqli->update($query);
        $accion = new \stdClass();
        $accion->_sql= $query;
        $accion->_parametros = $parametros;
        $accion->_id = $id;
        UtileriasLog::addAccion($accion);
        return array('seccion'=>1, 'id'=>$id); // Cambia el status a eliminado
      //}
    }

    public static function getById($id){
      $mysqli = Database::getInstance();
      $query=<<<sql
      SELECT * FROM utilerias_perfiles WHERE perfil_id = $id
sql;
      return $mysqli->queryOne($query);
    }

    public static function getByIdReporte($id){
      $mysqli = Database::getInstance();
      $query=<<<sql
      SELECT
        u.perfil_id,
        u.nombre,
        u.descripcion,
        s.nombre AS nombre_status
      FROM utilerias_perfiles u
      JOIN catalogo_status s
      ON u.status = s.catalogo_status_id
      WHERE u.status != 2 AND u.perfil_id = $id
sql;

      return $mysqli->queryOne($query);
    }

    public static function getStatus(){
      $mysqli = Database::getInstance();
      $query=<<<sql
      SELECT * FROM catalogo_status
sql;
      return $mysqli->queryAll($query);
    }

    public static function getSeccionesMenu(){
      $mysqli = Database::getInstance();
      $query=<<<sql
      SELECT * FROM utilerias_secciones
sql;
      return $mysqli->queryAll($query);
    }

    public static function getUser($user){
      $mysqli = Database::getInstance();
      $query =<<<sql
      SELECT * FROM utilerias_perfiles WHERE nombre LIKE '$user' 
sql;
      $dato = $mysqli->queryOne($query);
      return ($dato>=1) ? 1 : 2 ;
    }
}
