<?php
namespace App\models;
defined("APPPATH") OR die("Access denied");

use \Core\Database;
use \App\interfaces\Crud;
use \App\controllers\UtileriasLog;

class Usuarios implements Crud{

    public static function getAll(){       
      $mysqli = Database::getInstance(true);
      $query =<<<sql
      SELECT * FROM registrados
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
      INSERT INTO registrados(nombre, apellidop, apellidom, email, prefijo, especialidad, telefono, id_pais, id_estado,identificador)
      VALUES(:nombre, :apellidop,:apellidom, :email, :prefijo, :especialidad, :telefono, :pais, :estado, :identificador);
sql;

          $parametros = array(

          ':nombre'=>$data->_nombre,
          ':apellidop'=>$data->_apellidop,
          ':apellidom'=>$data->_apellidom,
          ':email'=>$data->_email,
          ':prefijo'=>$data->_prefijo,
          ':especialidad'=>$data->_especialidad,
          ':telefono'=>$data->_telefono,
          ':pais'=>$data->_pais,
          ':estado'=>$data->_estado,
          ':identificador'=>$data->_identificador

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
      UPDATE registrados SET nombre = :nombre, apellidop = :apellidop, apellidom = :apellidom, prefijo = :prefijo, telefono = :telefono, id_pais = :id_pais, id_estado= :id_estado WHERE email = :email
sql;

    
      $parametros = array(
        ':nombre'=>$data->_nombre,
        ':apellidop'=>$data->_apellidop,
        ':apellidom'=>$data->_apellidom,
        ':prefijo'=>$data->_prefijo,
        ':telefono'=>$data->_telefono,
        ':id_pais'=>$data->_pais,
        ':id_estado' =>$data->_estado,
        ':email' =>$data->_email
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
        
    }
}