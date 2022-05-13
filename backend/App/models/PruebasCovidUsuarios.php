<?php
namespace App\models;
defined("APPPATH") OR die("Access denied");

use \Core\Database;
use \App\interfaces\Crud;
use \App\controllers\UtileriasLog;
use \App\controllers\UtileriasNotificacionesLog;

class PruebasCovidUsuarios implements Crud{
    public static function getAll(){
        $mysqli = Database::getInstance(true);
        $query =<<<sql
        SELECT pc.id_prueba_covid AS id_c_v, pc.utilerias_asistentes_id, pc.status AS status_prueba, pc.resultado, pc.tipo_prueba, fecha_carga_documento, tipo_prueba, pc.nota, resultado, email, telefono, documento,  CONCAT(ra.nombre, ' ',ra.segundo_nombre,' ',ra.apellido_paterno,' ',ra.apellido_materno) AS nombre_completo,
            lp.nombre AS nombre_linea, 
            uad.nombre as nombre_ejecutivo
        FROM prueba_covid pc
        JOIN utilerias_asistentes u
        JOIN registros_acceso ra
        JOIN linea_principal lp        
        JOIN utilerias_administradores uad    
        ON pc.utilerias_asistentes_id = u.utilerias_asistentes_id
        and u.id_registro_acceso = ra.id_registro_acceso
        and lp.id_linea_principal = ra.especialidad
        and uad.utilerias_administradores_id = lp.utilerias_administradores_id
sql;

        return $mysqli->queryAll($query);
    }
    public static function getById($id){
        
    }
    public static function insert($data){
        
    }
    public static function update($data){
        
    }
    public static function updateStatus($id){
        $mysqli = Database::getInstance(true);
        $query=<<<sql
        UPDATE prueba_covid SET status = 0 WHERE id_prueba_covid = $id
sql;       
        $log = new \stdClass();
        $log->_sql= $query;
        $log->_parametros = $id;
        $log->_id = $id;
        // UtileriasLog::addAccion($log);

        return $mysqli->update($query);
    }
    public static function delete($id){
        $mysqli = Database::getInstance(true);
        $query=<<<sql
        DELETE FROM prueba_covid WHERE id_prueba_covid = $id 
sql;

        $log = new \stdClass();
        $log->_sql= $query;
        $log->_parametros = $id;
        $log->_id = $id;
        UtileriasLog::addAccion($log);
        
        return $mysqli->delete($query);
    }

    public static function insertLog($ua_id,$fecha_doc,$fecha_prueba,$tipo_prueba,$doc,$nota){
        $mysqli = Database::getInstance();
        $query=<<<sql
        INSERT INTO log_prueba_covid
        (utilerias_asistentes_id, fecha_carga_documento, fecha_prueba_covid, 
        tipo_prueba, documento, nota, hora_rechazo) 
        
        VALUES('$ua_id','$fecha_doc','$fecha_prueba','$tipo_prueba','$doc','$nota',NOW())
sql;
  
        return $mysqli->insert($query);
    }

    public static function validar($data){
        $mysqli = Database::getInstance(true);
        $query=<<<sql
        UPDATE prueba_covid SET status = 2 WHERE id_prueba_covid = :id_prueba_covid;
sql;
        $parametros = array(
            ':id_prueba_covid'=>$data->_id_prueba_covid
            
        );
        $accion = new \stdClass();
        $accion->_sql= $query;
        // $accion->_id = $id;
        $accion->_id_asistente = $data->_id_asistente;
        $accion->_titulo = "Prueba covid";
        $accion->_descripcion = 'Un ejecutivo ha validado su '.$accion->_titulo. ' exitosamente';
        UtileriasNotificacionesLog::addAccion($accion);

        $accion = new \stdClass();
        $accion->_sql= $query;
        $accion->_parametros = $parametros;
        $accion->_id = $data->_id_prueba_covid;
        UtileriasLog::addAccion($accion);

        return $mysqli->update($query,$parametros);
    }

    

    public static function rechazar($data){
        $mysqli = Database::getInstance(true);
        $query=<<<sql
        UPDATE prueba_covid SET status = 1 WHERE id_prueba_covid = :id_prueba_covid;
sql;
        $parametros = array(
            ':id_prueba_covid'=>$data->_id_prueba_covid
            
        );

        $accion = new \stdClass();
        $accion->_sql= $query;
        // $accion->_id = $id;
        $accion->_id_asistente = $data->_id_asistente;
        $accion->_titulo = "Prueba covid";
        $accion->_descripcion = 'Un ejecutivo ha rechazado su '.$accion->_titulo;
        UtileriasNotificacionesLog::addAccion($accion);

        $accion = new \stdClass();
        $accion->_sql= $query;
        $accion->_parametros = $parametros;
        $accion->_id = $data->_id_prueba_covid;
        UtileriasLog::addAccion($accion);

        return $mysqli->update($query,$parametros);

    }

    public static function updateNote($data){
        $mysqli = Database::getInstance(true);
        $query=<<<sql
        UPDATE prueba_covid SET nota = :nota WHERE id_prueba_covid = :id_prueba_covid;
sql;
        $parametros = array(
        
        ':id_prueba_covid'=>$data->_id_prueba_covid,
        ':nota'=>$data->_nota,
        
        );

        $accion = new \stdClass();
        $accion->_sql= $query;
        $accion->_parametros = $parametros;
        $accion->_id = $data->_administrador_id;
        UtileriasLog::addAccion($accion);
        return $mysqli->update($query, $parametros);

    }

    public static function getByIdUser($id_usuario){
        $mysqli = Database::getInstance(true);
        $query =<<<sql
        SELECT * FROM prueba_covid WHERE utilerias_asistentes_id = '$id_usuario'
sql;

        return $mysqli->queryAll($query);
   
    }

    public static function getPruebaById($id){
        $mysqli = Database::getInstance();
        $query =<<<sql
        SELECT *, documento AS doc
		FROM prueba_covid
        WHERE id_prueba_covid = '$id'
sql;

        return $mysqli->queryAll($query);        
    }

    public static function contarPruebasValidosByLine($id){
        $mysqli = Database::getInstance(true);
        $query =<<<sql
        SELECT COUNT(*) FROM (SELECT pc.id_prueba_covid AS id_c_v, pc.utilerias_asistentes_id, pc.nota, pc.status AS status_comprobante,
            email, telefono, fecha_carga_documento, numero_empleado, documento,
            b.nombre AS nombre_bu, 
            p.nombre as nombre_posicion,
            lp.nombre AS nombre_linea,
            lp.id_linea_principal AS id_linea_p
            FROM prueba_covid pc
            JOIN utilerias_asistentes u
            JOIN registros_acceso ra
            JOIN bu b
            JOIN linea_principal lp
            JOIN posiciones p        
            ON pc.utilerias_asistentes_id = u.utilerias_asistentes_id
            and u.id_registro_acceso = ra.id_registro_acceso
            and b.id_bu = ra.id_bu
            and lp.id_linea_principal = ra.id_linea_principal
            and p.id_posicion = ra.id_posicion
            where lp.id_linea_ejecutivo = $id and pc.status = 2) AS total
        
sql;

        return $mysqli->queryAll($query);        
    }

    public static function contarPruebasValidos(){
        $mysqli = Database::getInstance(true);
        $query =<<<sql
        SELECT COUNT(id_prueba_covid) FROM prueba_covid WHERE status = 2
sql;

        return $mysqli->queryAll($query);        
    }

    public static function contarPruebasTotalesByLine($id){
        $mysqli = Database::getInstance(true);
        $query =<<<sql
        SELECT COUNT(*) FROM (SELECT pc.id_prueba_covid AS id_c_v, pc.utilerias_asistentes_id, pc.nota, pc.status AS status_comprobante,
        email, telefono, fecha_carga_documento, numero_empleado, documento,
        b.nombre AS nombre_bu, 
        p.nombre as nombre_posicion,
        lp.nombre AS nombre_linea
        FROM prueba_covid pc
        JOIN utilerias_asistentes u
        JOIN registros_acceso ra
        JOIN bu b
        JOIN linea_principal lp
        JOIN posiciones p        
        ON pc.utilerias_asistentes_id = u.utilerias_asistentes_id
        and u.id_registro_acceso = ra.id_registro_acceso
        and b.id_bu = ra.id_bu
        and lp.id_linea_principal = ra.id_linea_principal
        and p.id_posicion = ra.id_posicion 
        where lp.id_linea_ejecutivo = '$id') AS total
sql;
        return $mysqli->queryAll($query);
    }

    public static function contarPruebasTotales(){
        $mysqli = Database::getInstance(true);
        $query =<<<sql
        SELECT COUNT(id_prueba_covid) FROM prueba_covid
sql;

        return $mysqli->queryAll($query);        
    }

    public static function contarPruebasPorRevisar(){
        $mysqli = Database::getInstance(true);
        $query =<<<sql
        SELECT COUNT(id_prueba_covid) FROM prueba_covid WHERE status = 0
sql;

        return $mysqli->queryAll($query);        
    }

    public static function contarPruebasPorRevisarByLine($id){
        $mysqli = Database::getInstance(true);
        $query =<<<sql
        SELECT COUNT(*) FROM (SELECT pc.id_prueba_covid AS id_c_v, pc.utilerias_asistentes_id, pc.nota, pc.status AS status_comprobante,
            email, telefono, fecha_carga_documento, numero_empleado, documento,
            b.nombre AS nombre_bu, 
            p.nombre as nombre_posicion,
            lp.nombre AS nombre_linea 
            FROM prueba_covid pc
            JOIN utilerias_asistentes u
            JOIN registros_acceso ra
            JOIN bu b
            JOIN linea_principal lp
            JOIN posiciones p        
            ON pc.utilerias_asistentes_id = u.utilerias_asistentes_id
            and u.id_registro_acceso = ra.id_registro_acceso
            and b.id_bu = ra.id_bu
            and lp.id_linea_principal = ra.id_linea_principal
            and p.id_posicion = ra.id_posicion
            where lp.id_linea_ejecutivo = $id and pc.status = 0) AS total
sql;

        return $mysqli->queryAll($query);        
    }

    public static function contarAsistentes(){
        $mysqli = Database::getInstance(true);
        $query =<<<sql
        SELECT COUNT(utilerias_asistentes_id) FROM utilerias_asistentes
sql;

        return $mysqli->queryAll($query);        
    }

    public static function contarAsistentesByLine($id){
        $mysqli = Database::getInstance(true);
        $query =<<<sql
        SELECT COUNT(*) FROM (SELECT uas.utilerias_asistentes_id, ra.id_registro_acceso, lp.id_linea_principal, pc.id_prueba_covid
        FROM utilerias_asistentes uas
        INNER JOIN registros_acceso ra ON(uas.id_registro_acceso = ra.id_registro_acceso)
        INNER JOIN linea_principal lp ON(lp.id_linea_principal = ra.id_linea_principal)
        INNER JOIN linea_ejecutivo le ON (le.id_linea_ejecutivo = lp.id_linea_ejecutivo)
        INNER JOIN prueba_covid pc ON(pc.utilerias_asistentes_id = uas.utilerias_asistentes_id)
        WHERE le.id_linea_ejecutivo = $id) as total 
sql;

        return $mysqli->queryAll($query);        
    }

    public static function getComprobatesByLinea($id_linea){
        $mysqli = Database::getInstance(true);
        $query =<<<sql
        SELECT pc.id_prueba_covid AS id_c_v, pc.utilerias_asistentes_id, pc.nota, pc.status AS status_prueba,
            email, telefono, fecha_carga_documento, numero_empleado, fecha_carga_documento, pc.tipo_prueba, pc.resultado, pc.fecha_prueba_covid, documento,
            b.nombre AS nombre_bu, 
            p.nombre as nombre_posicion,
            lp.nombre AS nombre_linea,  
            CONCAT(ra.nombre, ' ',ra.segundo_nombre,' ',ra.apellido_paterno,' ',ra.apellido_materno) AS nombre_completo,
            le.nombre as nombre_linea_ejecutivo, le.color, al.utilerias_administradores_id_linea_asignada as id_ejecutivo_administrador, uad.nombre as nombre_ejecutivo
        FROM prueba_covid pc
        JOIN utilerias_asistentes u
        JOIN registros_acceso ra
        JOIN bu b
        JOIN linea_principal lp
        JOIN posiciones p
        JOIN linea_ejecutivo le
        JOIN asigna_linea al
        JOIN utilerias_administradores uad    
        ON pc.utilerias_asistentes_id = u.utilerias_asistentes_id
        and u.id_registro_acceso = ra.id_registro_acceso
        and b.id_bu = ra.id_bu
        and lp.id_linea_principal = ra.id_linea_principal
        and p.id_posicion = ra.id_posicion
        and le.id_linea_ejecutivo = lp.id_linea_ejecutivo
        and al.id_linea_ejecutivo = le.id_linea_ejecutivo
        and uad.utilerias_administradores_id = al.utilerias_administradores_id_linea_asignada
        where lp.id_linea_ejecutivo = $id_linea
sql;

        return $mysqli->queryAll($query);
    }

    public static function getComprobateByIdUser($id_asis){
        $mysqli = Database::getInstance(true);
        $query =<<<sql
        SELECT pc.id_prueba_covid AS id_c_v, pc.utilerias_asistentes_id, pc.status AS status_prueba, pc.resultado, pc.tipo_prueba, fecha_carga_documento, tipo_prueba, pc.nota, resultado, email, telefono, documento,  CONCAT(ra.nombre, ' ',ra.segundo_nombre,' ',ra.apellido_paterno,' ',ra.apellido_materno) AS nombre_completo,
            lp.nombre AS nombre_linea, 
            uad.nombre as nombre_ejecutivo
        FROM prueba_covid pc
        JOIN utilerias_asistentes u
        JOIN registros_acceso ra
        JOIN linea_principal lp        
        JOIN utilerias_administradores uad    
        ON pc.utilerias_asistentes_id = u.utilerias_asistentes_id
        and u.id_registro_acceso = ra.id_registro_acceso
        and lp.id_linea_principal = ra.especialidad
        where ra.clave = '$id_asis';
sql;

        return $mysqli->queryAll($query);
    }
}