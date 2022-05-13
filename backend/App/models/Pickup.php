<?php
namespace App\models;
defined("APPPATH") OR die("Access denied");
use \Core\Database;
use \App\interfaces\Crud;
use \App\controllers\UtileriasLog;
class Pickup implements Crud{
    public static function getAll(){
        $mysqli = Database::getInstance();
        $query=<<<sql
        SELECT pu.* , uad.nombre AS nombre_admin,
        ra.telefono, ra.email,
		CONCAT (ra.nombre,' ',ra.segundo_nombre,' ',ra.apellido_paterno,' ',ra.apellido_materno) AS nombre_completo
        FROM pickup pu
        INNER JOIN utilerias_asistentes ua
        ON ua.utilerias_asistentes_id = pu.utilerias_asistentes_id
        INNER JOIN registros_acceso ra
        ON ra.id_registro_acceso = ua.id_registro_acceso
        INNER JOIN utilerias_administradores uad
        ON uad.utilerias_administradores_id = pu.utilerias_administradores_id
sql;
        return $mysqli->queryAll($query);
    }
    public static function getAllAsistentes(){
        $mysqli = Database::getInstance();
        $query=<<<sql
        SELECT *, CONCAT( ra.nombre,' ',ra.segundo_nombre,' ',ra.apellido_paterno,' ',ra.apellido_materno) AS nombre_completo
        FROM utilerias_asistentes ua
        INNER JOIN registros_acceso ra
        ON ra.id_registro_acceso = ua.id_registro_acceso
sql;
        return $mysqli->queryAll($query);
    }
    public static function getById($id){
        
    }
    public static function insert($data){
        $mysqli = Database::getInstance(1);
        $query=<<<sql
        INSERT INTO pickup(clave, id_punto_reunion_pickup,fecha_cita, hora_cita, utilerias_asistentes_id, utilerias_administradores_id )
        VALUES(:clave, :punto_reunion,:fecha_cita, :hora_cita, :utilerias_asistentes_id, :utilerias_administrador_id);
sql;
            $parametros = array(

            ':clave'=>$data->_clave,
            // ':nombre'=>$data->_nombre,
            ':fecha_cita'=>$data->_fecha_cita,
            ':hora_cita'=>$data->_hora_cita,
            ':utilerias_administrador_id'=>$data->_utilerias_administrador_id,
            ':utilerias_asistentes_id'=>$data->_utilerias_asistentes_id,
            ':punto_reunion'=>$data->_punto_reunion
            // ':telefono'=>$data->_telefono,

            );
            $id = $mysqli->insert($query,$parametros);
            return $id;
    }
    
    public static function update($data){
        $mysqli = Database::getInstance(true);
        $query=<<<sql
        UPDATE pickup SET fecha_cita = :fecha_cita, hora_cita = :hora_cita
        WHERE id_pickup = :id_pickup
sql;
        $parametros = array(
            ':id_pickup'=>$data->_id_pickup,
            ':fecha_cita'=>$data->_fecha_cita,
            ':hora_cita'=>$data->_hora_cita
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
        DELETE FROM pickup WHERE id_pickup = '$id'
sql;
        return $mysqli->delete($query);
    }
}