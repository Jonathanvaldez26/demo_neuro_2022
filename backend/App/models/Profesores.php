<?php
namespace App\models;
defined("APPPATH") OR die("Access denied");

use \Core\Database;
use \App\interfaces\Crud;
use \App\controllers\UtileriasLog;

class Profesores implements Crud{

    public static function getAll(){       
      $mysqli = Database::getInstance(true);
      $query =<<<sql
      SELECT * FROM profesores
sql;
    
      return $mysqli->queryAll($query);
      
    }

    public static function getAllCoordinadores(){       
      $mysqli = Database::getInstance(true);
      $query =<<<sql
      SELECT * FROM coordinadores
sql;
    
      return $mysqli->queryAll($query);
      
    }

    public static function getUserNotInCourse(){
      $mysqli = Database::getInstance(true);
      $query =<<<sql
      SELECT * FROM registrados re WHERE id_registrado NOT IN (SELECT ac.id_registrado FROM asigna_curso ac)
sql;    
      return $mysqli->queryAll($query);

    }

    public static function getPais(){       
      $mysqli = Database::getInstance();
      $query=<<<sql
      SELECT * FROM paises
sql;
      return $mysqli->queryAll($query);
    }



    public static function getStateByCountry($id_pais){
      $mysqli = Database::getInstance(true);
      $query =<<<sql
      SELECT * FROM estados where id_pais = '$id_pais'
sql;
    
      return $mysqli->queryAll($query);
    }
    public static function getById($id){
        
    }
    public static function insert($data){
      $mysqli = Database::getInstance(1);
      $query=<<<sql
      INSERT INTO profesores(prefijo, nombre, descripcion, img, internacional)
      VALUES(:prefijo, :nombre,:descripcion, :img, :internacional);
sql;

          $parametros = array(

          ':prefijo'=>$data->_prefijo,
          ':nombre'=>$data->_nombre,
          ':descripcion'=>$data->_descripcion,
          ':img'=>$data->_imagen,
          ':internacional'=>$data->_nacionalidad
          );
          $id = $mysqli->insert($query,$parametros);
          return $id;
        
    }

    public static function insertCoordinador($data){
      $mysqli = Database::getInstance(1);
      $query=<<<sql
      INSERT INTO coordinadores(prefijo, nombre)
      VALUES(:prefijo, :nombre);
sql;

          $parametros = array(
          ':prefijo'=>$data->_prefijo,
          ':nombre'=>$data->_nombre
          );
          $id = $mysqli->insert($query,$parametros);
          return $id;
        
    }

    public static function getUserRegister($email){
      $mysqli = Database::getInstance(true);
      $query =<<<sql
      SELECT * FROM registrados WHERE email = '$email'
sql;

      return $mysqli->queryAll($query);
  }
    public static function update($data){
      $mysqli = Database::getInstance(true);
      $query=<<<sql
      UPDATE profesores SET nombre = :nombre, descripcion = :descripcion, internacional = :internacional WHERE id_profesor = :id_profesor
sql;
      $parametros = array(
        ':nombre'=>$data->_nombre,
        ':descripcion'=>$data->_descripcion,
        ':internacional'=>$data->_nacionalidad,
        ':id_profesor'=>$data->_id_profesor
      );

      // var_dump($parametros);
      // var_dump($query);
      // exit;
        // $accion = new \stdClass();
        // $accion->_sql= $query;
        // $accion->_parametros = $parametros;
        // $accion->_id = $hotel->_id_hotel;
        return $mysqli->update($query, $parametros);
        
    }
    public static function delete($id){
      $mysqli = Database::getInstance(true);
        $query=<<<sql
        DELETE FROM profesores WHERE id_profesor = $id 
sql;

        // $log = new \stdClass();
        // $log->_sql= $query;
        // $log->_parametros = $id;
        // $log->_id = $id;
        // UtileriasLog::addAccion($log);
        
        return $mysqli->delete($query);
        
    }

    public static function deleteCoordinador($id){
      $mysqli = Database::getInstance(true);
        $query=<<<sql
        DELETE FROM coordinadores WHERE id_coordinador = $id 
sql;

        // $log = new \stdClass();
        // $log->_sql= $query;
        // $log->_parametros = $id;
        // $log->_id = $id;
        // UtileriasLog::addAccion($log);
        
        return $mysqli->delete($query);
        
    }

    public static function getAllProfesoresByName($search){
      $mysqli = Database::getInstance();
      $query =<<<sql
      SELECT * FROM profesores WHERE CONCAT_WS(nombre,descripcion) LIKE '%$search%';
sql;
      return $mysqli->queryAll($query);
    }

    public static function getAllCoordinadoresByName($search){
      $mysqli = Database::getInstance();
      $query =<<<sql
      SELECT * FROM coordinadores WHERE nombre LIKE '%$search%';
sql;
      return $mysqli->queryAll($query);
    }
}