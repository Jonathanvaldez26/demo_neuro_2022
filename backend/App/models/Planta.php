<?php
namespace App\models;
defined("APPPATH") OR die("Access denied");

use \Core\Database;
use \App\interfaces\Crud;
use \App\controllers\UtileriasLog;

class Planta implements Crud{

    public static function getAll(){

	$mysqli = Database::getInstance();
        $query=<<<sql
        SELECT
          p.catalogo_planta_id,
          p.nombre,
          p.descripcion,
          s.nombre as status
        FROM catalogo_planta p
        JOIN catalogo_status s
        ON s.catalogo_status_id = p.status WHERE p.status!=2
sql;
        return $mysqli->queryAll($query);
    }

    public static function insert($empresa){
	    $mysqli = Database::getInstance(1);
      $query=<<<sql
        INSERT INTO catalogo_planta VALUES(null, :nombre, :descripcion, :status)
sql;
        $parametros = array(
          ':nombre'=>$empresa->_nombre,
          ':descripcion'=>$empresa->_descripcion,
          ':status'=>$empresa->_status
        );
        $id = $mysqli->insert($query,$parametros);
        $accion = new \stdClass();
        $accion->_sql= $query;
        $accion->_parametros = $parametros;
        $accion->_id = $id;

        UtileriasLog::addAccion($accion);
        return $id;
    }


    public static function update($empresa){
      $mysqli = Database::getInstance();
      $query=<<<sql
      UPDATE catalogo_planta SET nombre = :nombre, descripcion = :descripcion, status = :status WHERE catalogo_planta_id = :id
sql;
      $parametros = array(
        ':id'=>$empresa->_catalogo_planta_id,
        ':nombre'=>$empresa->_nombre,
        ':descripcion'=>$empresa->_descripcion,
        ':status'=>$empresa->_status
      );
      $accion = new \stdClass();
      $accion->_sql= $query;
      $accion->_parametros = $parametros;
      $accion->_id = $empresa->_catalogo_planta_id;
      UtileriasLog::addAccion($accion);
      return $mysqli->update($query, $parametros);
    }

    public static function delete($id){
      $mysqli = Database::getInstance();
      $query=<<<sql
      UPDATE catalogo_planta SET status = 2 WHERE catalogo_planta_id = $id
sql;
      $accion = new \stdClass();
      $accion->_sql= $query;
      $accion->_parametros = $parametros;
      $accion->_id = $id;
      UtileriasLog::addAccion($accion);
      return $mysqli->update($query);
    }

    public static function getById($id){
      $mysqli = Database::getInstance();
      $query=<<<sql
      SELECT cp.catalogo_planta_id, cp.nombre, cp.descripcion, cp.status, cs.nombre AS nombre_status, cs.catalogo_status_id FROM catalogo_planta AS cp INNER JOIN catalogo_status AS cs WHERE catalogo_planta_id = $id AND cp.status = cs.catalogo_status_id 
sql;
      return $mysqli->queryOne($query);
    }

    public static function getByIdReporte($id){
      $mysqli = Database::getInstance();
      $query=<<<sql
      SELECT
        p.catalogo_planta_id,
        p.nombre,
        p.descripcion,
        s.nombre as status
      FROM catalogo_planta p
      JOIN catalogo_status s
      ON s.catalogo_status_id = p.status WHERE p.status!=2 AND p.catalogo_planta_id = $id
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

    
    public static function getNombrePlanta($nombre_planta){
      $mysqli = Database::getInstance();
      $query =<<<sql
      SELECT * FROM catalogo_planta WHERE nombre LIKE '$nombre_planta' 
sql;
      $dato = $mysqli->queryOne($query);
      return ($dato>=1) ? 1 : 2 ;
    }

    public static function getIdComparacion($id, $nombre){
      $mysqli = Database::getInstance();
      $query =<<<sql
      SELECT * FROM catalogo_planta WHERE catalogo_planta_id = '$id' AND nombre Like '$nombre' 
sql;
      $dato = $mysqli->queryOne($query);

      return ($dato>=1) ? 1 : 2;
    }

}
