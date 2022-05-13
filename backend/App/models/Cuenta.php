<?php
namespace App\models;
defined("APPPATH") OR die("Access denied");

use \Core\Database;
use \Core\MasterDom;
use \App\interfaces\Crud;
use \App\controllers\UtileriasLog;

class Cuenta implements Crud{

    public static function getAll(){
      $mysqli = Database::getInstance();
      $query=<<<sql
      SELECT catalogo_cuenta_id, catalogo_empresa_id, fecha_alta, status FROM catalogo_cuenta ORDER BY catalogo_cuenta_id ASC;
sql;
      return $mysqli->queryAll($query);
    }

    public static function insert($cuenta){
	    $mysqli = Database::getInstance(1);
      $query=<<<sql
      INSERT INTO catalogo_cuenta VALUES({$cuenta['catalogo_cuenta_id']}, 5, NOW(), 1)
sql;
        $parametros = array(
          ':catalogo_cuenta_id'=>$cuenta->_catalogo_cuenta_id+1,
          ':catalogo_empresa_id'=>$cuenta->_catalogo_empresa_id+1,
        );

        $id = $mysqli->insert($query,$parametros);
        $accion = new \stdClass();
        $accion->_sql= $query;
        $accion->_parametros = $parametros;
        $accion->_id = $id;

        UtileriasLog::addAccion($accion);
        return $id;
    }

    public static function update($cuenta){
      $mysqli = Database::getInstance(true);
      $query=<<<sql
      UPDATE catalogo_cuenta SET status = :status WHERE catalogo_cuenta_id = :id
      sql;
      $parametros = array(
        ':id'=>$cuenta->_catalogo_cuenta_id,
        ':status'=>$cuenta->_status,
      );
      $accion = new \stdClass();
      $accion->_sql= $query;
      $accion->_parametros = $parametros;
      $accion->_id = $cuenta->_catalogo_cuenta_id;
      UtileriasLog::addAccion($accion);
        return $mysqli->update($query, $parametros);
    }

    public static function delete($id){
      $mysqli = Database::getInstance();
      $select = <<<sql
      SELECT e.catalogo_cuenta_id FROM catalogo_cuenta e JOIN catalogo_colaboradores c
      ON e.catalogo_cuenta_id = c.catalogo_cuenta_id WHERE e.catalogo_cuenta_id = $id
sql;

      $sqlSelect = $mysqli->queryAll($select);
      if(count($sqlSelect) >= 1){
        return array('seccion'=>2, 'id'=>$id); // NO elimina
      }else{
        $query = <<<sql
        UPDATE catalogo_cuenta SET status = 2 WHERE catalogo_cuenta.catalogo_cuenta_id = $id;
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

    public static function verificarRelacion($id){
      $mysqli = Database::getInstance();
      $select = <<<sql
      SELECT e.catalogo_cuenta_id FROM catalogo_cuenta e JOIN catalogo_colaboradores c
      ON e.catalogo_cuenta_id = c.catalogo_cuenta_id WHERE e.catalogo_cuenta_id = $id
sql;
      $sqlSelect = $mysqli->queryAll($select);
      if(count($sqlSelect) >= 1)
        return array('seccion'=>2, 'id'=>$id); // NO elimina
      else
        return array('seccion'=>1, 'id'=>$id); // Cambia el status a eliminado
      
    }

    public static function getById($id){
      $mysqli = Database::getInstance();
      $query=<<<sql
      SELECT ce.catalogo_cuenta_id, ce.status FROM catalogo_cuenta AS ce WHERE catalogo_cuenta_id = $id 
sql;
      return $mysqli->queryOne($query);
    }

    public static function getByIdReporte($id){
      $mysqli = Database::getInstance();
      $query=<<<sql
      SELECT e.catalogo_cuenta_id, e.status FROM catalogo_cuenta e WHERE e.status!=2 AND e.catalogo_cuenta_id = $id
sql;

      return $mysqli->queryOne($query);
    }


    public static function getStatus(){
      $mysqli = Database::getInstance();
      $query=<<<sql
      SELECT * FROM catalogo_cuenta
sql;
      return $mysqli->queryAll($query);
    }

    public static function getNombre($nombre_cuenta){
      $mysqli = Database::getInstance();
      $query =<<<sql
      SELECT * FROM `catalogo_cuenta` WHERE `nombre` LIKE '$nombre_cuenta' 
sql;
      $dato = $mysqli->queryOne($query);
      return ($dato>=1) ? 1 : 2 ;
    }

    public static function getIdComparacion($id, $nombre){
      $mysqli = Database::getInstance();
      $query =<<<sql
      SELECT * FROM catalogo_cuenta WHERE catalogo_cuenta_id = '$id' AND nombre Like '$nombre' 
sql;
      $dato = $mysqli->queryOne($query);
      // 0

      if($dato>=1){
        return 1;
      }else{
        return 2;
      }
    }

    public static function getEmpresaById($id){
      $mysqli = Database::getInstance();
      $query=<<<sql
      SELECT razon_social, fecha_alta FROM catalogo_empresa WHERE catalogo_empresa_id = $id ORDER BY catalogo_empresa_id ASC;
      sql;
      return $mysqli->queryAll($query);
    }

    public static function getAllEmpresas(){
      $mysqli = Database::getInstance();
      $query=<<<sql
      SELECT e.catalogo_empresa_id, e.clave, e.rfc, e.razon_social, e.email, e.telefono_uno, e.telefono_dos, e.domicilio_fiscal, e.sitio_web, e.fecha_alta as status FROM catalogo_empresa e ORDER BY e.catalogo_empresa_id ASC;
      sql;
      return $mysqli->queryAll($query);
    }
}
