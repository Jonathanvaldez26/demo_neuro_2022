<?php
namespace App\models;
defined("APPPATH") OR die("Access denied");

use \Core\Database;
use \App\interfaces\Crud;

class Login implements Crud{

    public static function getAll(){}
    public static function insert($suscripcion){}
    public static function update($suscripcion){}
    public static function delete($id){}

    public static function getById($usuario){
        $mysqli = Database::getInstance(true);
        $query =<<<sql
        SELECT * FROM utilerias_administradores WHERE usuario LIKE :usuario AND contrasena LIKE :password 
sql;
        $params = array(
            ':usuario'=> $usuario->_usuario,
            ':password'=>$usuario->_password
        );

        return $mysqli->queryOne($query,$params);
    }

    public static function getUser($usuario){
        $mysqli = Database::getInstance(true);
        $query =<<<sql
        SELECT * FROM utilerias_administradores WHERE usuario = '$usuario' AND status = 1
sql;

        return $mysqli->queryAll($query);
    }
}
