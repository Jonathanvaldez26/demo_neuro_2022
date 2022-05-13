<?php
namespace App\models;
defined("APPPATH") OR die("Access denied");

use \Core\Database;
use \App\interfaces\Crud;
use \App\controllers\UtileriasLog;
use \App\controllers\UtileriasNotificacionesLog;

class ComprobantesVacunacion implements Crud{
    public static function getAll(){
        $mysqli = Database::getInstance(true);
        $query =<<<sql
        SELECT cv.id_comprobante_vacuna AS id_c_v, cv.utilerias_asistentes_id, cv.nota, cv.status AS status_comprobante, cv.validado,
            email, telefono, fecha_carga_documento, fecha_carga_documento, numero_dosis, marca_dosis, documento,
            lp.nombre AS nombre_linea,  
            CONCAT(ra.nombre, ' ',ra.segundo_nombre,' ',ra.apellido_paterno,' ',ra.apellido_materno) AS nombre_completo,
              uad.nombre as nombre_ejecutivo
        FROM comprobante_vacuna cv
        JOIN utilerias_asistentes u
        JOIN registros_acceso ra
        JOIN linea_principal lp         
        JOIN utilerias_administradores uad    
        ON cv.utilerias_asistentes_id = u.utilerias_asistentes_id
        and u.id_registro_acceso = ra.id_registro_acceso
        and lp.id_linea_principal = ra.especialidad
        and uad.utilerias_administradores_id = lp.utilerias_administradores_id
sql;

        return $mysqli->queryAll($query);
    }
    
    
    public static function getById($id){
        $mysqli = Database::getInstance(true);
        $query =<<<sql
        SELECT * FROM comprobante_vacuna WHERE id_comprobante_vacuna  = '$id'
sql;

        return $mysqli->queryAll($query);
        
    }
    public static function insert($data){
        
    }

    public static function insertLog($ua_id,$fecha_doc,$n_dosis,$m_dosis,$doc,$nota){
        $mysqli = Database::getInstance();
        $query=<<<sql
        INSERT INTO log_comprobante_vacuna
        (utilerias_asistentes_id, fecha_carga_documento, numero_dosis, marca_dosis, 
        documento, nota, hora_rechazo) 
        
        VALUES('$ua_id','$fecha_doc','$n_dosis','$m_dosis','$doc','$nota',NOW())
sql;
  
        return $mysqli->insert($query);
    }

    public static function update($data){
        
    }
    public static function delete($id){
        $mysqli = Database::getInstance(true);
        $query=<<<sql
        DELETE FROM comprobante_vacuna WHERE id_comprobante_vacuna = $id 
sql;

        $log = new \stdClass();
        $log->_sql= $query;
        $log->_parametros = $id;
        $log->_id = $id;
        UtileriasLog::addAccion($log);
        
        return $mysqli->delete($query);
    }

    public static function contarComprobantesValidos(){
        $mysqli = Database::getInstance(true);
        $query =<<<sql
        SELECT COUNT(id_comprobante_vacuna) FROM comprobante_vacuna WHERE validado = 1
sql;

        return $mysqli->queryAll($query);        
    }

    public static function getComprobanteById($id){
        $mysqli = Database::getInstance();
        $query =<<<sql
        SELECT *, documento AS doc 
		FROM comprobante_vacuna
        WHERE id_comprobante_vacuna = '$id'
sql;

        return $mysqli->queryAll($query);        
    }

    public static function contarComprobantesValidosByLine($id){
        $mysqli = Database::getInstance(true);
        $query =<<<sql
        SELECT COUNT(*) FROM (SELECT cv.id_comprobante_vacuna AS id_c_v, cv.utilerias_asistentes_id, cv.nota, cv.status AS status_comprobante, cv.validado,
            email, telefono, fecha_carga_documento, numero_empleado, numero_dosis, marca_dosis, documento,
            b.nombre AS nombre_bu, 
            p.nombre as nombre_posicion,
            lp.nombre AS nombre_linea,
            lp.id_linea_principal AS id_linea_p
            FROM comprobante_vacuna cv
            JOIN utilerias_asistentes u
            JOIN registros_acceso ra
            JOIN bu b
            JOIN linea_principal lp
            JOIN posiciones p        
            ON cv.utilerias_asistentes_id = u.utilerias_asistentes_id
            and u.id_registro_acceso = ra.id_registro_acceso
            and b.id_bu = ra.id_bu
            and lp.id_linea_principal = ra.id_linea_principal
            and p.id_posicion = ra.id_posicion
            where lp.id_linea_ejecutivo = $id and cv.validado = 1) AS total
        
sql;

        return $mysqli->queryAll($query);        
    }

    public static function contarComprobantesTotales(){
        $mysqli = Database::getInstance(true);
        $query =<<<sql
        SELECT COUNT(id_comprobante_vacuna) FROM comprobante_vacuna
sql;

        return $mysqli->queryAll($query);        
    }

    public static function contarComprobantesTotalesByLine($id){
        $mysqli = Database::getInstance(true);
        $query =<<<sql
        SELECT COUNT(*) FROM (SELECT cv.id_comprobante_vacuna AS id_c_v, cv.utilerias_asistentes_id, cv.nota, cv.status AS status_comprobante, cv.validado,
            email, telefono, fecha_carga_documento, numero_empleado, numero_dosis, marca_dosis, documento,
            b.nombre AS nombre_bu, 
            p.nombre as nombre_posicion,
            lp.nombre AS nombre_linea
            FROM comprobante_vacuna cv
            JOIN utilerias_asistentes u
            JOIN registros_acceso ra
            JOIN bu b
            JOIN linea_principal lp
            JOIN posiciones p        
            ON cv.utilerias_asistentes_id = u.utilerias_asistentes_id
            and u.id_registro_acceso = ra.id_registro_acceso
            and b.id_bu = ra.id_bu
            and lp.id_linea_principal = ra.id_linea_principal
            and p.id_posicion = ra.id_posicion
            where lp.id_linea_ejecutivo = $id) AS total
sql;

        return $mysqli->queryAll($query);        
    }

    public static function contarComprobantesPorRevisar(){
        $mysqli = Database::getInstance(true);
        $query =<<<sql
        SELECT COUNT(id_comprobante_vacuna) FROM comprobante_vacuna WHERE validado = 0
sql;

        return $mysqli->queryAll($query);        
    }

    public static function contarComprobantesPorRevisarByLine($id){
        $mysqli = Database::getInstance(true);
        $query =<<<sql
        SELECT COUNT(*) FROM (SELECT cv.id_comprobante_vacuna AS id_c_v, cv.utilerias_asistentes_id, cv.nota, cv.status AS status_comprobante, cv.validado,
            email, telefono, fecha_carga_documento, numero_empleado, numero_dosis, marca_dosis, documento,
            b.nombre AS nombre_bu, 
            p.nombre as nombre_posicion,
            lp.nombre AS nombre_linea 
            FROM comprobante_vacuna cv
            JOIN utilerias_asistentes u
            JOIN registros_acceso ra
            JOIN bu b
            JOIN linea_principal lp
            JOIN posiciones p        
            ON cv.utilerias_asistentes_id = u.utilerias_asistentes_id
            and u.id_registro_acceso = ra.id_registro_acceso
            and b.id_bu = ra.id_bu
            and lp.id_linea_principal = ra.id_linea_principal
            and p.id_posicion = ra.id_posicion
            where lp.id_linea_ejecutivo = $id and cv.validado = 0) AS total
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
        SELECT COUNT(*) FROM (SELECT uas.utilerias_asistentes_id, ra.id_registro_acceso, lp.id_linea_principal, cv.id_comprobante_vacuna
        FROM utilerias_asistentes uas
        INNER JOIN registros_acceso ra ON(uas.id_registro_acceso = ra.id_registro_acceso)
        INNER JOIN linea_principal lp ON(lp.id_linea_principal = ra.id_linea_principal)
        INNER JOIN linea_ejecutivo le ON (le.id_linea_ejecutivo = lp.id_linea_ejecutivo)
        INNER JOIN comprobante_vacuna cv ON(cv.utilerias_asistentes_id = uas.utilerias_asistentes_id)
        WHERE le.id_linea_ejecutivo = $id) as total 
sql;

        return $mysqli->queryAll($query);        
    }
    
    public static function validar($data){
        $mysqli = Database::getInstance(true);
        $query=<<<sql
        UPDATE comprobante_vacuna SET validado = 1 WHERE id_comprobante_vacuna = :id_comprobante_vacuna
sql;
        $parametros = array(
            ':id_comprobante_vacuna'=>$data->_id_comprobante_vacuna
            
        );
        $accion = new \stdClass();
        $accion->_sql= $query;
        // $accion->_id = $id;
        $accion->_id_asistente = $data->_id_asistente;
        $accion->_titulo = "Comprobante de vacunación";
        $accion->_descripcion = 'Un ejecutivo ha validado su '.$accion->_titulo. ' exitosamente';
        UtileriasNotificacionesLog::addAccion($accion);


        $log = new \stdClass();
        $log->_sql= $query;
        $log->_parametros = $parametros;
        $log->_id = $data->_id_comprobante_vacuna;

        UtileriasLog::addAccion($log);

        return $mysqli->update($query,$parametros);

    }

    public static function rechazar($data){
        $mysqli = Database::getInstance(true);
        $query=<<<sql
        UPDATE comprobante_vacuna SET status = 0 WHERE id_comprobante_vacuna = :id_comprobante_vacuna
sql;

        $parametros = array(
            ':id_comprobante_vacuna'=>$data->_id_comprobante_vacuna
            
        );
        $accion = new \stdClass();
        $accion->_sql= $query;
        // $accion->_id = $id;
        $accion->_id_asistente = $data->_id_asistente;
        $accion->_titulo = "Comprobante de vacunación";
        $accion->_descripcion = 'Un ejecutivo ha rechazado su '.$accion->_titulo;
        UtileriasNotificacionesLog::addAccion($accion);

        $log = new \stdClass();
        $log->_sql= $query;
        $log->_parametros = $parametros;
        $log->_id = $data->_id_comprobante_vacuna;

        UtileriasLog::addAccion($log);

        return $mysqli->update($query,$parametros);

    }

    public static function updateNote($data){
        $mysqli = Database::getInstance(true);
        $query=<<<sql
        UPDATE comprobante_vacuna 
        SET nota = :nota 
        WHERE id_comprobante_vacuna = :id_comprobante_vacuna;
sql;
        $parametros = array(
        
        ':id_comprobante_vacuna'=>$data->_id_comprobante_vacuna,
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
        SELECT * FROM comprobante_vacuna WHERE utilerias_asistentes_id = '$id_usuario' and status = 1
sql;

        return $mysqli->queryAll($query);
   
    }
    ////PENDIENTE CONSULTA CORRECTA
    public static function getComprobatesByLinea($id_linea){
        $mysqli = Database::getInstance(true);
        $query =<<<sql
        SELECT cv.id_comprobante_vacuna AS id_c_v, cv.utilerias_asistentes_id, cv.nota, cv.status AS status_comprobante, cv.validado,
            email, telefono, fecha_carga_documento, numero_empleado, fecha_carga_documento, numero_dosis, marca_dosis, documento,
            b.nombre AS nombre_bu, 
            p.nombre as nombre_posicion,
            lp.nombre AS nombre_linea,  
            CONCAT(ra.nombre, ' ',ra.segundo_nombre,' ',ra.apellido_paterno,' ',ra.apellido_materno) AS nombre_completo,
            le.nombre as nombre_linea_ejecutivo, le.color, al.utilerias_administradores_id_linea_asignada as id_ejecutivo_administrador, uad.nombre as nombre_ejecutivo
        FROM comprobante_vacuna cv
        JOIN utilerias_asistentes u
        JOIN registros_acceso ra
        JOIN bu b
        JOIN linea_principal lp
        JOIN posiciones p
        JOIN linea_ejecutivo le
        JOIN asigna_linea al
        JOIN utilerias_administradores uad    
        ON cv.utilerias_asistentes_id = u.utilerias_asistentes_id
        and u.id_registro_acceso = ra.id_registro_acceso
        and b.id_bu = ra.id_bu
        and lp.id_linea_principal = ra.id_linea_principal
        and p.id_posicion = ra.id_posicion
        and le.id_linea_ejecutivo = lp.id_linea_ejecutivo
        and al.id_linea_ejecutivo = le.id_linea_ejecutivo
        and uad.utilerias_administradores_id = al.utilerias_administradores_id_linea_asignada
        where lp.id_linea_ejecutivo = $id_linea;
sql;

        return $mysqli->queryAll($query);
    }


    public static function getComprobateByClaveUser($id_clave){
        $mysqli = Database::getInstance(true);
        $query =<<<sql
        SELECT cv.id_comprobante_vacuna AS id_c_v, cv.utilerias_asistentes_id, cv.nota, cv.status AS status_comprobante, cv.validado,
            email, telefono, fecha_carga_documento, fecha_carga_documento, numero_dosis, marca_dosis, documento,
            lp.nombre AS nombre_linea,  
            CONCAT(ra.nombre, ' ',ra.segundo_nombre,' ',ra.apellido_paterno,' ',ra.apellido_materno) AS nombre_completo,
            uad.nombre as nombre_ejecutivo
        FROM comprobante_vacuna cv
        JOIN utilerias_asistentes u
        JOIN registros_acceso ra
        JOIN linea_principal lp
        
        
        
        JOIN utilerias_administradores uad    
        ON cv.utilerias_asistentes_id = u.utilerias_asistentes_id
        and u.id_registro_acceso = ra.id_registro_acceso
      
        and lp.id_linea_principal = ra.especialidad
        where ra.clave = '$id_clave';
sql;

        return $mysqli->queryAll($query);
    }

    public static function updateStatus($id){
        $mysqli = Database::getInstance(true);
        $query=<<<sql
        UPDATE comprobante_vacuna SET validado = 0, status = 1 WHERE id_comprobante_vacuna = $id
sql;       
        $log = new \stdClass();
        $log->_sql= $query;
        $log->_parametros = $id;
        $log->_id = $id;
        // UtileriasLog::addAccion($log);

        return $mysqli->update($query);
    }
}