<?php
namespace App\models;
defined("APPPATH") OR die("Access denied");

use \Core\Database;
use \App\interfaces\Crud;
use \App\controllers\UtileriasLog;


class RegistroAsistencia{

    public static function getById($id){
        $mysqli = Database::getInstance();
        $query=<<<sql
        SELECT * FROM asistencias WHERE clave = '$id';
sql;
        return $mysqli->queryAll($query);
    }

    public static function getByIdDirectivos($id){
        $mysqli = Database::getInstance();
        $query=<<<sql
        SELECT * FROM asistencias WHERE clave = '$id' and es_plenaria_individual = 1 and url_directivos != '';
sql;
        return $mysqli->queryAll($query);
    }

    public static function getByIdStaff($id){
        $mysqli = Database::getInstance();
        $query=<<<sql
        SELECT * FROM asistencias WHERE clave = '$id' and es_plenaria_individual = 1 and url_staf != '';
sql;
        return $mysqli->queryAll($query);
    }

    public static function getByIdNeurociencias($id){
        $mysqli = Database::getInstance();
        $query=<<<sql
        SELECT * FROM asistencias WHERE clave = '$id' and es_plenaria_individual = 1 and url_staf != '';
sql;
        return $mysqli->queryAll($query);
    }

    public static function getNeurociencias(){
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

    public static function getByIdKaesOsteo($id){
        $mysqli = Database::getInstance();
        $query=<<<sql
        SELECT * FROM asistencias WHERE clave = '$id' and es_plenaria_individual = 1 and url_kaes_osteo != '';
sql;
        return $mysqli->queryAll($query);
    }

    public static function getByIdCardio($id){
        $mysqli = Database::getInstance();
        $query=<<<sql
        SELECT * FROM asistencias WHERE clave = '$id' and es_plenaria_individual = 1 and url_cardio != '';
sql;
        return $mysqli->queryAll($query);
    }

    public static function getByIdUro($id){
        $mysqli = Database::getInstance();
        $query=<<<sql
        SELECT * FROM asistencias WHERE clave = '$id' and es_plenaria_individual = 1 and url_uro != '';
sql;
        return $mysqli->queryAll($query);
    }


    public static function getByIdGastro($id){
        $mysqli = Database::getInstance();
        $query=<<<sql
        SELECT * FROM asistencias WHERE clave = '$id' and es_plenaria_individual = 1 and url_gastro != '';
sql;
        return $mysqli->queryAll($query);
    }

    public static function getByIdGineco($id){
        $mysqli = Database::getInstance();
        $query=<<<sql
        SELECT * FROM asistencias WHERE clave = '$id' and es_plenaria_individual = 1 and url_gineco != '';
sql;
        return $mysqli->queryAll($query);
    }

    public static function getByIdMedicinaGeneral($id){
        $mysqli = Database::getInstance();
        $query=<<<sql
        SELECT * FROM asistencias WHERE clave = '$id' and es_plenaria_individual = 1 and url_medicina_general != '';
sql;
        return $mysqli->queryAll($query);
    }

    public static function getByIdOle($id){
        $mysqli = Database::getInstance();
        $query=<<<sql
        SELECT * FROM asistencias WHERE clave = '$id' and es_plenaria_individual = 1 and url_ole != '';
sql;
        return $mysqli->queryAll($query);
    }

    public static function getByIdAnalgesia($id){
        $mysqli = Database::getInstance();
        $query=<<<sql
        SELECT * FROM asistencias WHERE clave = '$id' and es_plenaria_individual = 1 and url_analgesia != '';
sql;
        return $mysqli->queryAll($query);
    }

    public static function getInfo($clave){
        $mysqli = Database::getInstance();
        $query=<<<sql
        SELECT ra.*, ua.utilerias_asistentes_id, ra.ticket_virtual as clave_ticket
        FROM registros_acceso ra
        INNER JOIN utilerias_asistentes ua
        ON ua.id_registro_acceso = ra.id_registro_acceso
        WHERE ra.ticket_virtual = '$clave'
sql;

        return $mysqli->queryAll($query);
    }


    public static function getInfoDirectivos($clave){
        $mysqli = Database::getInstance();
        $query=<<<sql
        SELECT ra.*, ua.utilerias_asistentes_id, le.nombre
        FROM registros_acceso ra
        INNER JOIN utilerias_asistentes ua ON ua.id_registro_acceso = ra.id_registro_acceso
        INNER JOIN ticket_virtual tv ON tv.id_ticket_virtual = ra.id_ticket_virtual
        INNER JOIN linea_principal lp ON lp.id_linea_principal = ra.id_linea_principal
        INNER JOIN linea_ejecutivo le ON le.id_linea_ejecutivo = lp.id_linea_ejecutivo
        WHERE tv.clave = '$clave' and le.nombre = 'DIRECTIVOS';
sql;

        return $mysqli->queryAll($query);
    }


    public static function getInfoSTAFF($clave){
        $mysqli = Database::getInstance();
        $query=<<<sql
        SELECT ra.*, ua.utilerias_asistentes_id, le.nombre
        FROM registros_acceso ra
        INNER JOIN utilerias_asistentes ua ON ua.id_registro_acceso = ra.id_registro_acceso
        INNER JOIN ticket_virtual tv ON tv.id_ticket_virtual = ra.id_ticket_virtual
        INNER JOIN linea_principal lp ON lp.id_linea_principal = ra.id_linea_principal
        INNER JOIN linea_ejecutivo le ON le.id_linea_ejecutivo = lp.id_linea_ejecutivo
        WHERE tv.clave = '$clave' and le.nombre = 'STAFF';
sql;

        return $mysqli->queryAll($query);
    }


    public static function getInfoNEUROCIENCIAS($clave){
        $mysqli = Database::getInstance();
        $query=<<<sql
        SELECT ra.*, ua.utilerias_asistentes_id, le.nombre
        FROM registros_acceso ra
        INNER JOIN utilerias_asistentes ua ON ua.id_registro_acceso = ra.id_registro_acceso
        INNER JOIN ticket_virtual tv ON tv.id_ticket_virtual = ra.id_ticket_virtual
        INNER JOIN linea_principal lp ON lp.id_linea_principal = ra.id_linea_principal
        INNER JOIN linea_ejecutivo le ON le.id_linea_ejecutivo = lp.id_linea_ejecutivo
        WHERE tv.clave = '$clave' and le.nombre = 'NEUROCIENCIAS';
sql;

        return $mysqli->queryAll($query);
    }


    public static function getInfoKAESOSTEO($clave){
        $mysqli = Database::getInstance();
        $query=<<<sql
        SELECT ra.*, ua.utilerias_asistentes_id, le.nombre
        FROM registros_acceso ra
        INNER JOIN utilerias_asistentes ua ON ua.id_registro_acceso = ra.id_registro_acceso
        INNER JOIN ticket_virtual tv ON tv.id_ticket_virtual = ra.id_ticket_virtual
        INNER JOIN linea_principal lp ON lp.id_linea_principal = ra.id_linea_principal
        INNER JOIN linea_ejecutivo le ON le.id_linea_ejecutivo = lp.id_linea_ejecutivo
        WHERE tv.clave = '$clave' and le.nombre = 'KAES / OSTEO';
sql;

        return $mysqli->queryAll($query);
    }


    public static function getInfoCARDIO($clave){
        $mysqli = Database::getInstance();
        $query=<<<sql
        SELECT ra.*, ua.utilerias_asistentes_id, le.nombre
        FROM registros_acceso ra
        INNER JOIN utilerias_asistentes ua ON ua.id_registro_acceso = ra.id_registro_acceso
        INNER JOIN ticket_virtual tv ON tv.id_ticket_virtual = ra.id_ticket_virtual
        INNER JOIN linea_principal lp ON lp.id_linea_principal = ra.id_linea_principal
        INNER JOIN linea_ejecutivo le ON le.id_linea_ejecutivo = lp.id_linea_ejecutivo
        WHERE tv.clave = '$clave' and le.nombre = 'CARDIO';
sql;

        return $mysqli->queryAll($query);
    }


    public static function getInfoURO($clave){
        $mysqli = Database::getInstance();
        $query=<<<sql
        SELECT ra.*, ua.utilerias_asistentes_id, le.nombre
        FROM registros_acceso ra
        INNER JOIN utilerias_asistentes ua ON ua.id_registro_acceso = ra.id_registro_acceso
        INNER JOIN ticket_virtual tv ON tv.id_ticket_virtual = ra.id_ticket_virtual
        INNER JOIN linea_principal lp ON lp.id_linea_principal = ra.id_linea_principal
        INNER JOIN linea_ejecutivo le ON le.id_linea_ejecutivo = lp.id_linea_ejecutivo
        WHERE tv.clave = '$clave' and le.nombre = 'URO';
sql;

        return $mysqli->queryAll($query);
    }


    public static function getInfoGASTRO($clave){
        $mysqli = Database::getInstance();
        $query=<<<sql
        SELECT ra.*, ua.utilerias_asistentes_id, le.nombre
        FROM registros_acceso ra
        INNER JOIN utilerias_asistentes ua ON ua.id_registro_acceso = ra.id_registro_acceso
        INNER JOIN ticket_virtual tv ON tv.id_ticket_virtual = ra.id_ticket_virtual
        INNER JOIN linea_principal lp ON lp.id_linea_principal = ra.id_linea_principal
        INNER JOIN linea_ejecutivo le ON le.id_linea_ejecutivo = lp.id_linea_ejecutivo
        WHERE tv.clave = '$clave' and le.nombre = 'GASTRO';
sql;

        return $mysqli->queryAll($query);
    }


    public static function getInfoGINECO($clave){
        $mysqli = Database::getInstance();
        $query=<<<sql
        SELECT ra.*, ua.utilerias_asistentes_id, le.nombre
        FROM registros_acceso ra
        INNER JOIN utilerias_asistentes ua ON ua.id_registro_acceso = ra.id_registro_acceso
        INNER JOIN ticket_virtual tv ON tv.id_ticket_virtual = ra.id_ticket_virtual
        INNER JOIN linea_principal lp ON lp.id_linea_principal = ra.id_linea_principal
        INNER JOIN linea_ejecutivo le ON le.id_linea_ejecutivo = lp.id_linea_ejecutivo
        WHERE tv.clave = '$clave' and le.nombre = 'GINECO';
sql;

        return $mysqli->queryAll($query);
    }


    public static function getInfoMEDICINAGENERAL($clave){
        $mysqli = Database::getInstance();
        $query=<<<sql
        SELECT ra.*, ua.utilerias_asistentes_id, le.nombre
        FROM registros_acceso ra
        INNER JOIN utilerias_asistentes ua ON ua.id_registro_acceso = ra.id_registro_acceso
        INNER JOIN ticket_virtual tv ON tv.id_ticket_virtual = ra.id_ticket_virtual
        INNER JOIN linea_principal lp ON lp.id_linea_principal = ra.id_linea_principal
        INNER JOIN linea_ejecutivo le ON le.id_linea_ejecutivo = lp.id_linea_ejecutivo
        WHERE tv.clave = '$clave' and le.nombre = 'MEDICINA GENERAL';
sql;

        return $mysqli->queryAll($query);
    }


    public static function getInfoOLE($clave){
        $mysqli = Database::getInstance();
        $query=<<<sql
        SELECT ra.*, ua.utilerias_asistentes_id, le.nombre
        FROM registros_acceso ra
        INNER JOIN utilerias_asistentes ua ON ua.id_registro_acceso = ra.id_registro_acceso
        INNER JOIN ticket_virtual tv ON tv.id_ticket_virtual = ra.id_ticket_virtual
        INNER JOIN linea_principal lp ON lp.id_linea_principal = ra.id_linea_principal
        INNER JOIN linea_ejecutivo le ON le.id_linea_ejecutivo = lp.id_linea_ejecutivo
        WHERE tv.clave = '$clave' and le.nombre = 'OLE';
sql;

        return $mysqli->queryAll($query);
    }


    public static function getInfoANALGESIA($clave){
        $mysqli = Database::getInstance();
        $query=<<<sql
        SELECT ra.*, ua.utilerias_asistentes_id, le.nombre
        FROM registros_acceso ra
        INNER JOIN utilerias_asistentes ua ON ua.id_registro_acceso = ra.id_registro_acceso
        INNER JOIN ticket_virtual tv ON tv.id_ticket_virtual = ra.id_ticket_virtual
        INNER JOIN linea_principal lp ON lp.id_linea_principal = ra.id_linea_principal
        INNER JOIN linea_ejecutivo le ON le.id_linea_ejecutivo = lp.id_linea_ejecutivo
        WHERE tv.clave = '$clave' and le.nombre = 'ANALGESIA';
sql;

        return $mysqli->queryAll($query);
    }

    public static function getEspecialidades(){
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
        ra.telefono, ra.email, ra.especialidad, lp.nombre AS nombre_especialidad,
        CONCAT (ra.nombre,' ',ra.segundo_nombre,' ',apellido_paterno,' ',apellido_materno) AS nombre_completo
        FROM registros_asistencia ras
        INNER JOIN asistencias a
        INNER JOIN utilerias_asistentes ua
        INNER JOIN registros_acceso ra
        INNER JOIN linea_principal lp
        ON a.id_asistencia = id_asistencias
        and ua.utilerias_asistentes_id = ras.utilerias_asistentes_id
        and ra.id_registro_acceso = ua.id_registro_acceso
        and lp.id_linea_principal = ra.especialidad
        
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