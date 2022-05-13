<?php
namespace App\models;
defined("APPPATH") OR die("Access denied");

use \Core\Database;
use \Core\MasterDom;
use \App\interfaces\Crud;

class UtileriasLog implements Crud{

    public static function getAll(){
      $mysqli = Database::getInstance();
      $query =<<<sql
        SELECT * FROM utilerias_log
	ORDER BY `utilerias_log`.`log_id` DESC
	LIMIT 1000
sql;
      return $mysqli->queryAll($query);
    }

    public static function getAllFiltro($where){
      $mysqli = Database::getInstance();
      $query =<<<sql
        SELECT * FROM utilerias_log $where
	ORDER BY `utilerias_log`.`log_id` DESC
        LIMIT 1000
sql;
      return $mysqli->queryAll($query);
    }

    public static function insert($log){
	    $mysqli = Database::getInstance(1);
      $query =<<<sql
      INSERT INTO utilerias_log VALUES(null, NOW(), ' $log->_usuario', '$log->_descripcion', '$log->_accion', '$log->_ip', '$log->_accion_sql')
sql;

      return $mysqli->insert($query);
    }

    public static function update($empresa){
      $mysqli = Database::getInstance(true);
      return $mysqli->update($query, $parametros);
    }

    public static function delete($id){
      $mysqli = Database::getInstance();
      return$mysqli->update($query);
    }

    public static function getById($id){
      $mysqli = Database::getInstance();
      $query =<<<sql
        SELECT * FROM utilerias_log WHERE log_id = $id
sql;
      return $mysqli->queryOne($query);
    }


}
