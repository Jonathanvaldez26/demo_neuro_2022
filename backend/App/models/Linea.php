<?php
namespace App\models;
defined("APPPATH") OR die("Access denied");

use \Core\Database;
use \App\interfaces\Crud;
use \App\controllers\UtileriasLog;

class Linea implements Crud{
    public static function getAll(){
        $mysqli = Database::getInstance();
        $query=<<<sql
        SELECT lp.id_linea_principal, lp.clave, lp.nombre, lp.fecha_alta, ua.nombre as creo, b.nombre AS nombre_bu
        FROM linea_principal lp
        INNER JOIN utilerias_administradores ua ON ua.utilerias_administradores_id = lp.utilerias_administradores_id 
        INNER JOIN bu b ON b.id_bu = lp.id_bu 
        ORDER BY b.nombre and lp.nombre ASC
        
        
sql;
        return $mysqli->queryAll($query);
    }
    public static function getById($id){
        $mysqli = Database::getInstance(true);
        $query =<<<sql
        SELECT * FROM linea_ejecutivo WHERE id_linea_ejecutivo = $id
sql;

        return $mysqli->queryAll($query);
        
    }
    public static function insert($data){
        
    }
    public static function update($data){
        
    }
    public static function delete($id){
        
    }

    public static function getLineasAll(){
        $mysqli = Database::getInstance(true);
        $query =<<<sql
        SELECT * FROM linea_principal
sql;

        return $mysqli->queryAll($query);
    }

    public static function getLineasSinEjecutivo(){
        $mysqli = Database::getInstance(true);
        $query =<<<sql
        SELECT lp.*
        FROM linea_principal lp
        WHERE lp.id_linea_principal NOT IN (select id_linea_principal from asigna_linea)
sql;

        return $mysqli->queryAll($query);
    }

    public static function getLineas(){
        $mysqli = Database::getInstance(true);
        $query =<<<sql
        SELECT * FROM linea_ejecutivo
sql;

        return $mysqli->queryAll($query);
    }

    public static function getLineaTodos(){
        $mysqli = Database::getInstance(true);
        $query =<<<sql
        SELECT * FROM `linea_principal` WHERE nombre = 'todos'
sql;

        return $mysqli->queryAll($query);
    }

    public static function getLineaEjecutivo(){
        $mysqli = Database::getInstance(true);
        $query =<<<sql
        SELECT lp.*
        FROM linea_principal lp
        WHERE lp.id_linea_principal NOT IN (select id_linea_principal from asigna_linea)
sql;

        return $mysqli->queryAll($query);
    }

    public static function getLineasEjecutivo(){
        $mysqli = Database::getInstance(true);
        $query =<<<sql
        SELECT * FROM linea_ejecutivo
sql;

        return $mysqli->queryAll($query);
    }

    public static function insertAsignaLinea($asigaLinea){
	    $mysqli = Database::getInstance(1);
        $query=<<<sql
            INSERT INTO asigna_linea(id_linea_ejecutivo, utilerias_administradores_id_linea_asignada, fecha_alta, status, utilerias_administradores) 
            VALUES (:id_linea_ejecutivo, :utilerias_administradores_id_linea_asignada, NOW(), 1, :utilerias_administradores)
sql;
            $parametros = array(
            ':id_linea_ejecutivo'=>$asigaLinea->_linea_id,
            ':utilerias_administradores_id_linea_asignada'=>$asigaLinea->_utilerias_administradores_linea_asignada,
            ':utilerias_administradores'=>$asigaLinea->_utilerias_administradores
            );

            $id = $mysqli->insert($query,$parametros);

            return $id;
    }

    public static function updateAsignaLinea($user){
        $mysqli = Database::getInstance(true);
        $query=<<<sql
        UPDATE asigna_linea SET id_linea_ejecutivo = :id_linea_ejecutivo, utilerias_administradores = :utilerias_administradores WHERE utilerias_administradores_id_linea_asignada = :utilerias_administradores_id_linea_asignada;
sql;
        $parametros = array(
          ':id_linea_ejecutivo'=>$user->_linea_id,
          ':utilerias_administradores'=>$user->_utilerias_administradores,
          ':utilerias_administradores_id_linea_asignada'=>$user->_usuario_id
         
        );
        //   $accion = new \stdClass();
        //   $accion->_sql= $query;
        //   $accion->_parametros = $parametros;
        //   $accion->_id = $hotel->_id_hotel;
          return $mysqli->update($query, $parametros);
      }

      public static function getLineaByAdmin($id){
        $mysqli = Database::getInstance(true);
        $query =<<<sql
        SELECT ua.nombre, ua.utilerias_administradores_id, al.id_linea_ejecutivo, le.nombre as nombre_linea
        FROM utilerias_administradores ua
        INNER JOIN asigna_linea al ON(ua.utilerias_administradores_id = al.utilerias_administradores_id_linea_asignada)
        INNER JOIN linea_ejecutivo le ON(le.id_linea_ejecutivo = al.id_linea_ejecutivo)
        WHERE ua.utilerias_administradores_id = $id
sql;

        return $mysqli->queryAll($query);

      }
}