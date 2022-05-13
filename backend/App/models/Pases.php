<?php
namespace App\models;
defined("APPPATH") OR die("Access denied");

use \Core\Database;
use \App\interfaces\Crud;

class Pases implements Crud{

    public static function getAll(){}
    public static function insert($suscripcion){}
    public static function update($suscripcion){}
    public static function delete($id){}
    public static function getById($usuario){}

    public static function getByIdUser($id_usuario){
        $mysqli = Database::getInstance(true);
        $query =<<<sql
        SELECT * FROM pases_abordar WHERE utilerias_asistentes_id = '$id_usuario'
sql;

        return $mysqli->queryAll($query);
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                    