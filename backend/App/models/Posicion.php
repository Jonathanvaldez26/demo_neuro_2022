<?php
namespace App\models;
defined("APPPATH") OR die("Access denied");

use \Core\Database;
use \App\interfaces\Crud;
use \App\controllers\UtileriasLog;

class Posicion implements Crud{
    public static function getAll(){
        $mysqli = Database::getInstance();
        $query=<<<sql
    SELECT p.id_posicion, p.clave, p.nombre, p.fecha_alta, ua.nombre as creo, lp.nombre AS nombre_linea_p, b.nombre AS nombre_bu
    FROM posiciones p
    INNER JOIN utilerias_administradores ua on ua.utilerias_administradores_id = p.utilerias_administradores_id
    INNER JOIN linea_principal lp ON p.id_linea_principal = lp.id_linea_principal
    INNER JOIN bu b ON b.id_bu = lp.id_bu
    ORDER BY b.nombre and lp.nombre and p.nombre ASC
sql;
        return $mysqli->queryAll($query);
    }
    public static function getById($id){
        
    }
    public static function insert($data){
        
    }
    public static function update($data){
        
    }
    public static function delete($id){
        
    }
}