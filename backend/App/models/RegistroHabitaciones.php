<?php
namespace App\models;
defined("APPPATH") OR die("Access denied");

use \Core\Database;
use \App\interfaces\Crud;
use \App\controllers\UtileriasLog;

class RegistroHabitaciones{

    public static function getById($id){
        $mysqli = Database::getInstance();
        $query=<<<sql
        SELECT * FROM asistencias WHERE clave = '$id';
sql;
        return $mysqli->queryAll($query);
    }

    public static function getAsistentes(){
        $mysqli = Database::getInstance();
        $query=<<<sql
        SELECT id_registro_asistencia, id_asistencia, ras.fecha_alta AS fecha_alta_r_asistencias, ra.img AS imagen, clave,
        CONCAT(ra.nombre, ' ', ra.segundo_nombre, ' ', ra.apellido_paterno, ' ',ra.apellido_materno) AS nombre_completo
        FROM registros_asistencia ras
        INNER JOIN asistencias a
        INNER JOIN utilerias_asistentes ua
        INNER JOIN registros_acceso ra
        INNER JOIN linea_principal lp
        ON a.id_asistencia = ras.id_asistencias
        and ras.utilerias_asistentes_id = ua.utilerias_asistentes_id
        and ra.id_registro_acceso = ua.id_registro_acceso
sql;
        return $mysqli->queryAll($query);
    }

    public static function getInfo($clave){
        $mysqli = Database::getInstance();
        $query=<<<sql
        SELECT ra.*, ua.utilerias_asistentes_id
        FROM registros_acceso ra
        INNER JOIN utilerias_asistentes ua
        ON ua.id_registro_acceso = ra.id_registro_acceso
        INNER JOIN ticket_virtual tv
        ON tv.id_ticket_virtual = ra.id_ticket_virtual

        WHERE tv.clave = '$clave'
sql;

// SELECT ra.*, ua.*, lp.*, le.nombre AS nombre_linea_ejecutivo, le.color AS color_linea
//         FROM registros_acceso ra
//         INNER JOIN utilerias_asistentes ua
//         ON ua.id_registro_acceso = ra.id_registro_acceso
//         INNER JOIN linea_principal lp
//         ON ra.id_linea_principal = lp.id_linea_principal
//         INNER JOIN linea_ejecutivo le
//         ON lp.id_linea_ejecutivo = le.id_linea_ejecutivo
//         WHERE ra.clave = '$clave'
        return $mysqli->queryAll($query);
    }

    public static function getLineaPrincipial(){
        $mysqli = Database::getInstance();
        $query=<<<sql
        SELECT *
        FROM linea_principal
sql;
        return $mysqli->queryAll($query);
    }

    public static function getBu(){
        $mysqli = Database::getInstance();
        $query=<<<sql
        SELECT *
        FROM bu
sql;
        return $mysqli->queryAll($query);
    }

    public static function getPosiciones(){
        $mysqli = Database::getInstance();
        $query=<<<sql
        SELECT *
        FROM posiciones
sql;
        return $mysqli->queryAll($query);
    }

    public static function getRegistrosAsistenciasByCode($code){
        $mysqli = Database::getInstance();
        $query=<<<sql
        SELECT a.nombre AS nombre_asistencia, ras.utilerias_asistentes_id, ua.usuario, ras.id_registro_asistencia, ras.status,
        ra.telefono, ra.email,
        lp.nombre AS nombre_linea,
        b.nombre AS nombre_bu,
        p.nombre AS nombre_posicion,
        le.nombre AS nombre_linea_ejecutivo, le.color AS color_linea,
        CONCAT (ra.nombre,' ',ra.segundo_nombre,' ',apellido_paterno,' ',apellido_materno) AS nombre_completo
        FROM registros_asistencia ras
        INNER JOIN asistencias a
        INNER JOIN utilerias_asistentes ua
        INNER JOIN registros_acceso ra
        INNER JOIN linea_principal lp
        INNER JOIN posiciones p
        INNER JOIN bu b
        ON a.id_asistencia = id_asistencias
        and ua.utilerias_asistentes_id = ras.utilerias_asistentes_id
        and ra.id_registro_acceso = ua.id_registro_acceso
        and lp.id_linea_principal = ra.id_linea_principal
        and b.id_bu = ra.id_bu
        and p.id_posicion = ra.id_posicion
        INNER JOIN linea_ejecutivo le
        ON lp.id_linea_ejecutivo = le.id_linea_ejecutivo
        
        WHERE a.clave = '$code'
sql;
        return $mysqli->queryAll($query);
    }

    public static function countLista($code){
        $mysqli = Database::getInstance();
        $query=<<<sql
        SELECT COUNT(*) FROM `registros_asistencia` ras
        INNER JOIN asistencias a
        ON ras.id_asistencias = a.id_asistencia
        WHERE a.clave = '$code'
sql;
        return $mysqli->queryAll($query);
    }

    public static function addRegister($id_asistencia,$id_user,$status){
        $mysqli = Database::getInstance();
        $query=<<<sql
        INSERT INTO registros_asistencia ( `id_asistencias`, `utilerias_asistentes_id`, `fecha_alta`, `status`) 
        VALUES ($id_asistencia,$id_user,NOW(),$status)
sql;
        $id = $mysqli->insert($query);
        $accion = new \stdClass();
        $accion->_sql= $query;
        // $accion->_parametros = $parametros;
        $accion->_id = $id;
        return $id_user;
    }

    public static function getIdRegistrosAsistenciasByCode($code){
        $mysqli = Database::getInstance();
        $query=<<<sql
        SELECT *
        FROM asistencias
        WHERE clave = '$code'
sql;
        return $mysqli->queryAll($query);
    }

    public static function findAsistantById($id,$id_asist){
        $mysqli = Database::getInstance();
        $query=<<<sql
        SELECT * FROM `registros_asistencia` 
        WHERE utilerias_asistentes_id = $id and id_asistencias = $id_asist
sql;
        return $mysqli->queryAll($query);
    }

    public static function delete($id_registro_asistencia){
        $mysqli = Database::getInstance(true);
        $query=<<<sql
        DELETE FROM `registros_asistencia` WHERE id_registro_asistencia = $id_registro_asistencia 
sql;
        return $mysqli->delete($query);

    }

//     public static function addRegister($asistencia){
//         $mysqli = Database::getInstance();
//         $query=<<<sql
//         INSERT INTO `registros_asistencia` (`id_asistencias`, `utilerias_asistentes_id`, `fecha_alta`, `status`) 
//         VALUES (1,'[value-2]','[value-3]','[value-4]','[value-5]')
// sql;
//         return $mysqli->queryAll($query);
//     }
}