<?php
namespace App\models;
defined("APPPATH") OR die("Access denied");

use \Core\Database;
use \App\interfaces\Crud;
use \App\controllers\UtileriasLog;

class Motivobajas implements Crud{

    public static function getAll(){

    $mysqli = Database::getInstance();
        $query=<<<sql
        SELECT
          m.catalogo_motivo_baja_id,
          m.nombre,
          m.descripcion,
          s.nombre AS status
        FROM catalogo_motivo_baja m
        JOIN catalogo_status s
        ON m.status = catalogo_status_id
        WHERE m.status !=2
sql;
        return $mysqli->queryAll($query);
    }

    public static function insert($data){
      $mysqli = Database::getInstance(1);
      $query=<<<sql
      INSERT INTO catalogo_motivo_baja (catalogo_motivo_baja_id, nombre, descripcion, status) VALUES (NULL, :nombre, :descripcion, :status);
sql;
        $parametros = array(
           ':nombre'=>$data->_nombre,
           ':descripcion'=>$data->_descripcion,
           ':status'=>$data->_status
        );
        $id = $mysqli->insert($query,$parametros);
        $accion = new \stdClass();
        $accion->_sql= $query;
        $accion->_parametros = $parametros;
        $accion->_id = $id;

        UtileriasLog::addAccion($accion);
        return $id;
    }


    public static function update($horario){
      $mysqli = Database::getInstance(true);
      $query=<<<sql
      UPDATE catalogo_motivo_baja SET nombre = :nombre, descripcion = :descripcion, status = :status WHERE catalogo_motivo_baja.catalogo_motivo_baja_id = :catalogo_motivo_baja_id;
sql;
      $parametros = array(
         ':catalogo_motivo_baja_id'=>$horario->_catalogo_motivo_baja_id,
         ':nombre'=>$horario->_nombre,
         ':descripcion'=>$horario->_descripcion,
         ':status'=>$horario->_status
      );
      $accion = new \stdClass();
      $accion->_sql= $query;
      $accion->_parametros = $parametros;
      $accion->_id = $horario->_catalogo_motivo_baja_id;
      UtileriasLog::addAccion($accion);
        return $mysqli->update($query, $parametros);
    }

    public static function delete($id){
      $mysqli = Database::getInstance();
      $select = <<<sql
      SELECT cmb.catalogo_motivo_baja_id FROM catalogo_motivo_baja cmb JOIN catalogo_colaboradores c WHERE cmb.catalogo_motivo_baja_id = c.motivo AND cmb.catalogo_motivo_baja_id = $id
sql;

      $sqlSelect = $mysqli->queryAll($select);
      if(count($sqlSelect) >= 1){
        return array('seccion'=>2, 'id'=>$id); // NO elimina
      }else{
        $query = <<<sql
        UPDATE catalogo_motivo_baja SET status = 2 WHERE catalogo_motivo_baja_id = $id
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
SELECT cmb.catalogo_motivo_baja_id, cmb.nombre, cmb.descripcion, cmb.status, cs.catalogo_status_id, cs.nombre AS nombre_status FROM catalogo_motivo_baja AS cmb INNER JOIN catalogo_status As cs WHERE cmb.catalogo_motivo_baja_id = $id AND cmb.status = cs.catalogo_status_id
sql;
      return $mysqli->queryOne($query);
    }

    public static function getByIdReporte($id){
      $mysqli = Database::getInstance();
      $query=<<<sql
      SELECT
        m.catalogo_motivo_baja_id,
        m.nombre,
        m.descripcion,
        s.nombre AS status
      FROM catalogo_motivo_baja m
      JOIN catalogo_status s
      ON m.status = catalogo_status_id
      WHERE m.status !=2 AND m.catalogo_motivo_baja_id = $id
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

    public static function getNombreMotivobaja($nombre_motivo_baja){
      $mysqli = Database::getInstance();
      $query =<<<sql
      SELECT * FROM `catalogo_motivo_baja` WHERE `nombre` LIKE '$nombre_motivo_baja' 
sql;
      $dato = $mysqli->queryOne($query);
      return ($dato>=1) ? 1 : 2 ;
    }

    public static function verificarRelacion($id){
      $mysqli = Database::getInstance();
      $select = <<<sql
      SELECT cmb.catalogo_motivo_baja_id FROM catalogo_motivo_baja cmb JOIN catalogo_colaboradores c WHERE cmb.catalogo_motivo_baja_id = c.motivo AND cmb.catalogo_motivo_baja_id = $id
sql;
      $sqlSelect = $mysqli->queryAll($select);
      if(count($sqlSelect) >= 1)
        return array('seccion'=>2, 'id'=>$id); // NO elimina
      else
        return array('seccion'=>1, 'id'=>$id); // Cambia el status a eliminado
      
    }


}
