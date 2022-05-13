<?php
namespace App\models;
defined("APPPATH") OR die("Access denied");

use \Core\Database;
use \App\interfaces\Crud;
use \App\controllers\UtileriasLog;

class Puesto implements Crud{

    public static function getAll(){

	$mysqli = Database::getInstance();
        $query=<<<sql
        SELECT
          p.catalogo_puesto_id,
          p.nombre,
          p.descripcion,
          s.nombre AS status
        FROM catalogo_puesto p
        JOIN catalogo_status s
        ON p.status = s.catalogo_status_id
        WHERE p.status != 2
sql;
        return $mysqli->queryAll($query);
    }

    public static function insert($puesto){
	    $mysqli = Database::getInstance(1);
      $query=<<<sql
        INSERT INTO catalogo_puesto VALUES(null, :nombre, :descripcion, :status)
sql;
        $parametros = array(
          ':nombre'=>$puesto->_nombre,
          ':descripcion'=>$puesto->_descripcion,
          ':status'=>$puesto->_status
        );
        $id = $mysqli->insert($query,$parametros);
        $accion = new \stdClass();
        $accion->_sql= $query;
        $accion->_parametros = $parametros;
        $accion->_id = $id;

        UtileriasLog::addAccion($accion);
        return $id;
    }


    public static function update($puesto){
      $mysqli = Database::getInstance(true);
      $query=<<<sql
      UPDATE catalogo_puesto SET nombre = :nombre, descripcion = :descripcion, status = :status WHERE catalogo_puesto_id = :id
sql;
      $parametros = array(
        ':id'=>$puesto->_catalogo_puesto_id,
        ':nombre'=>$puesto->_nombre,
        ':descripcion'=>$puesto->_descripcion,
        ':status'=>$puesto->_status
      );
      $accion = new \stdClass();
      $accion->_sql= $query;
      $accion->_parametros = $parametros;
      $accion->_id = $puesto->_catalogo_puesto_id;
      UtileriasLog::addAccion($accion);
        return $mysqli->update($query, $parametros);
    }

    public static function delete($id){
      $mysqli = Database::getInstance();
      $select = <<<sql
      SELECT e.catalogo_puesto_id FROM catalogo_puesto e JOIN catalogo_colaboradores c
      ON e.catalogo_puesto_id = c.catalogo_puesto_id WHERE e.catalogo_puesto_id = $id
sql;

      $sqlSelect = $mysqli->queryAll($select);
      if(count($sqlSelect) >= 1){
        return array('seccion'=>2, 'id'=>$id); // NO elimina
      }else{
        $query = <<<sql
        UPDATE catalogo_puesto SET status = '2' WHERE catalogo_puesto.catalogo_puesto_id = $id;
sql;
        $mysqli->update($query);
        $accion = new \stdClass();
        $accion->_sql= $query;
        $accion->_parametros = $parametros;
        $accion->_id = $id;
        UtileriasLog::addAccion($accion);
        return array('seccion'=>1, 'id'=>$id); // Cambia el status a eliminado
      }
    }

    public static function getById($id){
      $mysqli = Database::getInstance();
      $query=<<<sql
      SELECT cp.catalogo_puesto_id, cp.nombre, cp.descripcion, cp.status, cs.catalogo_status_id, cs.nombre AS nombre_status FROM catalogo_puesto AS cp INNER JOIN catalogo_status AS cs WHERE catalogo_puesto_id = $id AND cp.status = cs.catalogo_status_id
sql;

      return $mysqli->queryOne($query);
    }

    public static function getByIdReporte($id){
      $mysqli = Database::getInstance();
      $query=<<<sql
      SELECT
        p.catalogo_puesto_id,
        p.nombre,
        p.descripcion,
        s.nombre AS status
      FROM catalogo_puesto p
      JOIN catalogo_status s
      ON p.status = s.catalogo_status_id
      WHERE p.status != 2 AND p.catalogo_puesto_id = $id
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

    public static function getNombrePuesto($nombre_puesto){
      $mysqli = Database::getInstance();
      $query =<<<sql
      SELECT * FROM catalogo_puesto WHERE nombre LIKE '$nombre_puesto' 
sql;
      $dato = $mysqli->queryOne($query);
      return ($dato>=1) ? 1 : 2 ;
    }

    public static function verificarRelacion($id){
      $mysqli = Database::getInstance();
      $select = <<<sql
      SELECT cp.catalogo_puesto_id FROM catalogo_puesto cp JOIN catalogo_colaboradores c ON cp.catalogo_puesto_id = c.catalogo_puesto_id WHERE cp.catalogo_puesto_id = $id
sql;
      $sqlSelect = $mysqli->queryAll($select);
      if(count($sqlSelect) >= 1)
        return array('seccion'=>2, 'id'=>$id); // NO elimina
      else
        return array('seccion'=>1, 'id'=>$id); // Cambia el status a eliminado
      
    }
}
