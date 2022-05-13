<?php
namespace App\models;
defined("APPPATH") OR die("Access denied");

use \Core\Database;
use \App\interfaces\Crud;
use \App\controllers\UtileriasLog;

class Perfiles implements Crud{

    public static function getAll(){

	      $mysqli = Database::getInstance();
        $query=<<<sql
        SELECT p.perfil_id, p.nombre, p.descripcion, p.status, s.nombre AS nombre_status FROM utilerias_perfiles AS p INNER JOIN catalogo_status AS s ON (p.status = s.catalogo_status_id) WHERE p.status != 2 
sql;
        return $mysqli->queryAll($query);
    }

    public static function insert($perfil){
	    $mysqli = Database::getInstance(1);
      //INSERT INTO utilerias_perfil (id_permiso, nombre_perfil, permisos_empresas, permisos_plantas, permisos_horarios, permisos_departamentos, permisos_ubicaciones, permisos_lectores, permisos_dias_festivos, permisos_motivo_bajas, permisos_incidencias, permisos_puestos, permisos_incentivos, permisos_colaboradores, permisos_globales, descripcion, status) VALUES ('', :nombre, :permisos1, :permisos2, :permisos3, :permisos4, :permisos5, :permisos6, :permisos7, :permisos8, :permisos9, :permisos10, :permisos11, :permisos12, :permisos_globales, :descripcion, :status);
      $query=<<<sql
      INSERT INTO utilerias_perfiles (perfil_id, nombre, descripcion, status) VALUES (NULL, :nombre, :descripcion, :status);
sql;
      $parametros = array(
        ':nombre'=>$perfil->_nombre,
        ':descripcion'=>$perfil->_descripcion,
        ':status'=>$perfil->_status
      );
        /*$parametros = array(
          ':nombre'=>$perfil->_nombre,
          ':permisos1'=>$perfil->_permisos1,
          ':permisos2'=>$perfil->_permisos2,
          ':permisos3'=>$perfil->_permisos3,
          ':permisos4'=>$perfil->_permisos4,
          ':permisos5'=>$perfil->_permisos5,
          ':permisos6'=>$perfil->_permisos6,
          ':permisos7'=>$perfil->_permisos7,
          ':permisos8'=>$perfil->_permisos8,
          ':permisos9'=>$perfil->_permisos9,
          ':permisos10'=>$perfil->_permisos10,
          ':permisos11'=>$perfil->_permisos11,
          ':permisos12'=>$perfil->_permisos12,
          ':permisos_globales'=>$perfil->_permisos_globales,
          ':descripcion'=>$perfil->_descripcion,
          ':status'=>$perfil->_status,
        );*/
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
