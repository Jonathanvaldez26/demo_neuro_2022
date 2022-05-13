<?php
namespace App\models;
defined("APPPATH") OR die("Access denied");

use \Core\Database;
use \App\interfaces\Crud;
use \App\controllers\UtileriasLog;

class Restaurantes implements Crud{

    public static function getAll(){
        $mysqli = Database::getInstance();
        $query=<<<sql
        SELECT * FROM restaurante
sql;
        return $mysqli->queryAll($query);
    }

    public static function getById($id){
        
    }
    public static function insert($data){
        $mysqli = Database::getInstance(1);
        $query=<<<sql
        INSERT INTO restaurante(clave, nombre, direccion, capacidad, codigo_vestimenta, telefono, status)
        VALUES(:clave, :nombre, :direccion, :capacidad, :codigo_vestimenta, :telefono, 1);
sql;
            $parametros = array(
            
            ':clave'=>$data->_clave,
            ':nombre'=>$data->_nombre,
            ':direccion'=>$data->_direccion,
            ':capacidad'=>$data->_capacidad,
            ':codigo_vestimenta'=>$data->_codigo_vestimenta,
            ':telefono'=>$data->_telefono,

            );

            $id = $mysqli->insert($query,$parametros);
            return $id;
    }

//     public static function update($data){
        
//         $mysqli = Database::getInstance();
//         $query=<<<sql
//             UPDATE restaurante SET 
            
//             nombre = :nombre

//             WHERE id_restaurante = :id_restaurante
// sql;

// //   nombre=':nombre',
// //             direccion=':direccion',
// //             capacidad=':capacidad',
// //             codigo_vestimenta=':codigo_vestimenta',
//         $parametros = array(
                    
//             // ':id_restaurante'=>$data->_id_restaurante,
//             ':nombre'=>$data->_nombre
//             // ':direccion'=>$data->_direccion,
//             // ':capacidad'=>$data->_capacidad,
//             // ':codigo_vestimenta'=>$data->_codigo_vestimenta,
//             // ':telefono'=>$data->_telefono,

//         );
  
//         $accion = new \stdClass();
//         $accion->_sql= $query;
//         $accion->_parametros = $parametros;
//         $accion->_id = $data->_administrador_id;
        
//         // var_dump($accion->_parametros);
//         return $mysqli->update($query, $parametros);
//     }

    public static function update($data){
        $mysqli = Database::getInstance(true);
        $query=<<<sql
        UPDATE restaurante SET nombre = :nombre, telefono = :telefono, capacidad = :capacidad, direccion = :direccion, codigo_vestimenta = :codigo_vestimenta
        WHERE id_restaurante = :id_restaurante
sql;
        $parametros = array(
            ':id_restaurante'=>$data->_id_restaurante,
            ':nombre'=>$data->_nombre,
            ':telefono'=>$data->_telefono,
            ':capacidad'=>$data->_capacidad,
            ':direccion'=>$data->_direccion,
            ':codigo_vestimenta'=>$data->_codigo_vestimenta
            
        );
        $accion = new \stdClass();
        $accion->_sql= $query;
        $accion->_parametros = $parametros;
        $accion->_id = $data->_administrador_id;

        return $mysqli->update($query,$parametros);

    }

    public static function delete($id){
        $mysqli = Database::getInstance(true);
        $query=<<<sql
        DELETE FROM restaurante WHERE id_restaurante = '$id'
sql;
        return $mysqli->delete($query);

    }
}