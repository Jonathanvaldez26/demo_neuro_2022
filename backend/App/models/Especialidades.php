<?php
namespace App\models;
defined("APPPATH") OR die("Access denied");

use \Core\Database;
use \App\interfaces\Crud;
use \App\controllers\UtileriasLog;

class Especialidades implements Crud{

    public static function getAll(){
        $mysqli = Database::getInstance();
        $query=<<<sql
        SELECT * FROM especialidades
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