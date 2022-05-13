<?php
namespace App\models;
defined("APPPATH") OR die("Access denied");

use \Core\Database;
use \Core\MasterDom;
use \App\interfaces\Crud;

class UtileriasNotificaciones implements Crud{

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
      INSERT INTO notif VALUES(null,'$log->_titulo', '$log->_descripcion', NOW(), $log->_id_asistente, 0)
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
