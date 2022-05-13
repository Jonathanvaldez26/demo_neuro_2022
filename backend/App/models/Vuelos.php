<?php
namespace App\models;
defined("APPPATH") OR die("Access denied");

use \Core\Database;
use \App\interfaces\Crud;
use \App\controllers\UtileriasLog;
use \App\controllers\UtileriasNotificacionesLog;

class Vuelos{
    public static function getAllLlegada(){
        $mysqli = Database::getInstance();
        $query=<<<sql
            SELECT pa.id_pase_abordar, pa.clave, CONCAT(ra.nombre," ", ra.segundo_nombre," ", ra.apellido_paterno," ", ra.apellido_materno) as nombre,
            pa.nota, ua.nombre as nombre_registro, ra.email, ra.telefono, pa.url AS link, pa.tipo, pa.envio_email
            FROM pases_abordar pa
            INNER JOIN utilerias_administradores ua on ua.utilerias_administradores_id = pa.utilerias_administradores_id
            INNER JOIN utilerias_asistentes uaa on uaa.utilerias_asistentes_id = pa.utilerias_asistentes_id
            INNER JOIN registros_acceso ra on ra.id_registro_acceso = uaa.id_registro_acceso
            WHERE tipo = 1 
sql;
        return $mysqli->queryAll($query);
    }

//     public static function getLlegadaByLinea($id_linea){
//         $mysqli = Database::getInstance(true);
//         $query =<<<sql
        

//             SELECT pa.id_pase_abordar, pa.clave, CONCAT(ra.nombre," ", ra.segundo_nombre," ", ra.apellido_paterno," ", ra.apellido_materno) as nombre, pa.fecha_alta, pa.numero_vuelo, pa.hora_llegada_destino, le.nombre AS nombre_linea_ejecutivo,
//             pa.nota , ua.nombre as nombre_registro, ra.email, ra.telefono, le.color, pa.url AS link
//             FROM pases_abordar pa
//             INNER JOIN utilerias_administradores ua on ua.utilerias_administradores_id = pa.utilerias_administradores_id
//             INNER JOIN utilerias_asistentes uaa on uaa.utilerias_asistentes_id = pa.utilerias_asistentes_id
//             INNER JOIN registros_acceso ra on ra.id_registro_acceso = uaa.id_registro_acceso
//             WHERE tipo = 1 and le.id_linea_ejecutivo = $id_linea
//             ORDER BY pa.fecha_alta DESC
// sql;

//         return $mysqli->queryAll($query);
//     }

    public static function getSalidaByLinea($id_linea){
        $mysqli = Database::getInstance(true);
        $query =<<<sql
        SELECT pa.id_pase_abordar, pa.clave, CONCAT(ra.nombre," ", ra.segundo_nombre," ", ra.apellido_paterno," ", ra.apellido_materno) as nombre,
            pa.nota , ua.nombre as nombre_registro, ra.email, ra.telefono,  pa.url AS link, pa.tipo
            FROM pases_abordar pa
            INNER JOIN utilerias_administradores ua on ua.utilerias_administradores_id = pa.utilerias_administradores_id
            INNER JOIN utilerias_asistentes uaa on uaa.utilerias_asistentes_id = pa.utilerias_asistentes_id
            INNER JOIN registros_acceso ra on ra.id_registro_acceso = uaa.id_registro_acceso
            WHERE pa.tipo = 2 ORDER BY pa.fecha_alta DESC
sql;

        return $mysqli->queryAll($query);
    }

    // SELECT pb.id_pase_abordar AS id_pb, pb.utilerias_asistentes_id, pb.nota, pb.status AS status_comprobante, 
    //         email, telefono, numero_empleado, 
    //         b.nombre AS nombre_bu, 
    //         p.nombre as nombre_posicion,
    //         lp.nombre AS nombre_linea,  
    //         CONCAT(ra.nombre, ' ',ra.segundo_nombre,' ',ra.apellido_paterno,' ',ra.apellido_materno) AS nombre_completo,
    //         le.nombre as nombre_linea_ejecutivo, le.color, al.utilerias_administradores_id_linea_asignada as id_ejecutivo_administrador, uad.nombre as nombre_ejecutivo
    //     FROM pases_abordar pb
    //     JOIN utilerias_asistentes u
    //     JOIN registros_acceso ra
    //     JOIN bu b
    //     JOIN linea_principal lp
    //     JOIN posiciones p
    //     JOIN linea_ejecutivo le
    //     JOIN asigna_linea al
    //     JOIN utilerias_administradores uad    
    //     ON pb.utilerias_asistentes_id = u.utilerias_asistentes_id
    //     and u.id_registro_acceso = ra.id_registro_acceso
    //     and b.id_bu = ra.id_bu
    //     and lp.id_linea_principal = ra.id_linea_principal
    //     and p.id_posicion = ra.id_posicion
    //     and le.id_linea_ejecutivo = lp.id_linea_ejecutivo
    //     and al.id_linea_ejecutivo = le.id_linea_ejecutivo
    //     and uad.utilerias_administradores_id = al.utilerias_administradores_id_linea_asignada
    //     where lp.id_linea_ejecutivo = '$id_linea'

    public static function getAllSalida(){
        $mysqli = Database::getInstance();
        $query=<<<sql
        SELECT pa.id_pase_abordar, pa.clave, CONCAT(ra.nombre," ", ra.segundo_nombre," ", ra.apellido_paterno," ", ra.apellido_materno) as nombre, 
            pa.nota , ua.nombre as nombre_registro, ra.email, ra.telefono,  pa.url AS link, pa.tipo, pa.envio_email
            FROM pases_abordar pa
            INNER JOIN utilerias_administradores ua on ua.utilerias_administradores_id = pa.utilerias_administradores_id
            INNER JOIN utilerias_asistentes uaa on uaa.utilerias_asistentes_id = pa.utilerias_asistentes_id
            INNER JOIN registros_acceso ra on ra.id_registro_acceso = uaa.id_registro_acceso
            WHERE pa.tipo = 2
sql;
        return $mysqli->queryAll($query);
    }

    public static function getById($id){
        
    }
    public static function insert($data){
        $mysqli = Database::getInstance(1);
        $query=<<<sql
        INSERT INTO pases_abordar (
            id_pase_abordar, 
            utilerias_asistentes_id, 
            utilerias_administradores_id, 
            clave,
            tiene_escala,
            url,
            nota, 
            tipo)

        VALUES (
            null, 
            :utilerias_asistentes_id, 
            :utilerias_administradores_id, 
            :clave, 
            :escala, 
            :url,
            :nota, 
            1)
sql;
        $parametros = array(
            ':utilerias_asistentes_id'=>$data->_utilerias_asistentes_id,
            ':utilerias_administradores_id'=>$data->_utilerias_administradores_id,
            ':clave'=>$data->_clave,
            ':escala'=>$data->_escala,
            ':url'=>$data->_url,
            ':nota'=>$data->_notas
        );

        $id = $mysqli->insert($query,$parametros);

        $accion = new \stdClass();
        $accion->_sql= $query;
        $accion->_id_asistente = $data->_utilerias_asistentes_id;
        $accion->_titulo = "Pase de abordar";
        $accion->_descripcion = 'Un ejecutivo ha cargado su '.$accion->_titulo;
        $accion->_id = $id;
        UtileriasNotificacionesLog::addAccion($accion);

        $log = new \stdClass();
        $log->_sql= $query;
        $log->_parametros = $parametros;
        $log->_id = $id;

        UtileriasLog::addAccion($log);
        
        return $id;

    }

    public static function insertSalida($data){
        $mysqli = Database::getInstance(1);
        $query=<<<sql
        INSERT INTO pases_abordar (
            id_pase_abordar, 
            utilerias_asistentes_id, 
            utilerias_administradores_id, 
            clave,
            tiene_escala,
            url,
            nota, 
            tipo)

        VALUES (
            null, 
            :utilerias_asistentes_id, 
            :utilerias_administradores_id, 
            :clave,
            :tiene_escala,
            :url,
            :nota, 
            2);
sql;
        $parametros = array(
            ':utilerias_asistentes_id'=>$data->_utilerias_asistentes_id,
            ':utilerias_administradores_id'=>$data->_utilerias_administradores_id,
            ':clave'=>$data->_clave,
            ':tiene_escala' =>$data->_escala,
            ':url'=>$data->_url,
            ':nota'=>$data->_notas
        );

        $id = $mysqli->insert($query,$parametros);
        $accion = new \stdClass();
        $accion->_sql= $query;
        $accion->_id_asistente = $data->_utilerias_asistentes_id;
        $accion->_titulo = "Pase de abordar";
        $accion->_descripcion = 'Un ejecutivo ha cargado su '.$accion->_titulo;
        $accion->_id = $id;
        UtileriasNotificacionesLog::addAccion($accion);

        $log = new \stdClass();
        $log->_sql= $query;
        $log->_parametros = $parametros;
        $log->_id = $id;

        UtileriasLog::addAccion($log);
        
        return $id;

    }

    public static function getAsistentebyUAId($id){
        $mysqli = Database::getInstance();
        $query=<<<sql
            SELECT ra.email, CONCAT (ra.nombre,' ',ra.segundo_nombre,' ',ra.apellido_paterno,' ',ra.apellido_materno) AS nombre_completo
            FROM registros_acceso ra
            INNER JOIN utilerias_asistentes ua
            ON ra.id_registro_acceso = ua.id_registro_acceso

            WHERE utilerias_asistentes_id = '$id'
sql;
        return $mysqli->queryAll($query);
    }

    public static function insertItinerario($data){
        $mysqli = Database::getInstance(1);
        $query=<<<sql
        INSERT INTO itinerario (id_itinerario, aerolinea_origen, aerolinea_escala_origen, aerolinea_destino, aerolinea_escala_destino, fecha_salida, fecha_escala_salida, hora_salida, hora_escala_salida, fecha_regreso, fecha_escala_regreso, hora_regreso, hora_escala_regreso, aeropuerto_salida, aeropuerto_escala_salida, aeropuerto_regreso, aeropuerto_escala_regreso, nota, utilerias_asistentes_id, utilerias_administradores_id, status, fecha_alta) 
        VALUES (null, :aerolinea_origen, :aerolinea_escala_origen,:aerolinea_destino, :aerolinea_escala_destino,:fecha_salida, :fecha_escala_salida,:hora_salida, :hora_escala_salida,:fecha_regreso, :fecha_escala_regreso,:hora_regreso, :hora_escala_regreso,:aeropuerto_salida, :aeropuerto_escala_salida, :aeropuerto_regreso, :aeropuerto_escala_regreso,:nota, :utilerias_asistentes_id, :utilerias_administradores_id, 1, NOW());
sql;
        $parametros = array(
            ':aerolinea_origen'=>$data->_aerolinea_origen,
            ':aerolinea_escala_origen'=>$data->_aerolinea_escala_origen,            
            ':aerolinea_destino'=>$data->_aerolinea_destino,
            ':aerolinea_escala_destino'=>$data->_aerolinea_escala_destino,
            ':fecha_salida'=>$data->_fecha_salida,
            ':fecha_escala_salida'=>$data->_fecha_escala_salida,
            ':hora_salida'=>$data->_hora_salida,
            ':hora_escala_salida'=>$data->_hora_escala_salida,
            ':fecha_regreso'=>$data->_fecha_regreso,
            ':fecha_escala_regreso'=>$data->_fecha_escala_regreso,
            ':hora_regreso'=>$data->_hora_regreso,
            ':hora_escala_regreso'=>$data->_hora_escala_regreso,
            ':aeropuerto_salida'=>$data->_aeropuerto_salida,
            ':aeropuerto_escala_salida'=>$data->_aeropuerto_escala_salida,
            ':aeropuerto_regreso'=>$data->_aeropuerto_regreso,
            ':aeropuerto_escala_regreso'=>$data->_aeropuerto_escala_regreso,
            ':nota'=>$data->_nota_itinerario,
            ':utilerias_asistentes_id'=>$data->_utilerias_asistentes_id,
            ':utilerias_administradores_id'=>$data->_utilerias_administradores_id
        );
        $id = $mysqli->insert($query,$parametros);
        $accion = new \stdClass();
        $accion->_sql= $query;
        $accion->_id_asistente = $data->_utilerias_asistentes_id;
        $accion->_titulo = "Itinerario";
        //$accion->_descripcion = 'Un ejecutivo ha cargado su '.$accion->_titulo;
        $accion->_descripcion = 'Hola '.$data->_nombre_asistente.', Tu itinerario de viaje ha sido cargado con exito <button class="btn btn-sm btn-info btn-itinerario" data-toggle="modal" data-target="#ver-itinerario" >Ver aquí</button>,';
        $accion->_id = $id;
        UtileriasNotificacionesLog::addAccion($accion);
        
        return $id;

    }

    public static function update($data){
        
    }

    public static function updateEmail($id_pase){
        $mysqli = Database::getInstance(true);
        $query=<<<sql
        UPDATE pases_abordar SET envio_email = 1 WHERE id_pase_abordar = $id_pase
sql;       
        
        return $mysqli->update($query);
    }

    public static function delete($id){
        $mysqli = Database::getInstance(true);
        $query=<<<sql
        DELETE FROM pases_abordar WHERE id_pase_abordar = $id 
sql;

        $log = new \stdClass();
        $log->_sql= $query;
        $log->_parametros = $id;
        $log->_id = $id;
        UtileriasLog::addAccion($log);
        
        return $mysqli->delete($query);
    }

    public static function getAsistenteNombre(){
        $mysqli = Database::getInstance();
        $query=<<<sql
        SELECT ra.id_registro_acceso, 
        CONCAT(ra.nombre, ' ', ra.segundo_nombre, ' ', ra.apellido_paterno, ' ', ra.apellido_materno) as nombre, ua.utilerias_asistentes_id 
        from utilerias_asistentes ua 
        INNER JOIN registros_acceso ra on ra.id_registro_acceso = ua.id_registro_acceso 
        WHERE ua.utilerias_asistentes_id NOT IN (SELECT utilerias_asistentes_id FROM pases_abordar where tipo = 1) 
        
        
sql;

        // AND cv.status = 1 AND pc.status = 2
        return $mysqli->queryAll($query);
    }

    public static function getAsistenteNombreSalida(){
        $mysqli = Database::getInstance();
        $query=<<<sql
        SELECT ra.id_registro_acceso, 
        CONCAT(ra.nombre, ' ', ra.segundo_nombre, ' ', ra.apellido_paterno, ' ', ra.apellido_materno) as nombre, ua.utilerias_asistentes_id 
        from utilerias_asistentes ua 
        INNER JOIN registros_acceso ra on ra.id_registro_acceso = ua.id_registro_acceso 
        WHERE ua.utilerias_asistentes_id NOT IN (SELECT utilerias_asistentes_id FROM pases_abordar where tipo = 2) 
sql;

// SELECT ra.id_registro_acceso, 
// CONCAT(ra.nombre, ' ', ra.segundo_nombre, ' ', ra.apellido_paterno, ' ', ra.apellido_materno) as nombre, 
//  ua.utilerias_asistentes_id 
// FROM utilerias_asistentes ua 
// INNER JOIN registros_acceso ra on ra.id_registro_acceso = ua.id_registro_acceso 
// ORDER BY `nombre` ASC;      

        // AND cv.status = 1 AND pc.status = 2
        return $mysqli->queryAll($query);
    }

    public static function getItinerarios(){
        $mysqli = Database::getInstance();
        $query=<<<sql
        
        SELECT 
        i.id_itinerario, 
        i.fecha_alta as fecha_registro,
        lp.nombre as nombre_linea,
        ra.telefono,
        ra.email,
        cao.nombre as aerolinea_origen, 
        caeo.nombre as aerolinea_escala_origen,
        cad.nombre as aerolinea_destino, 
        caed.nombre as aerolinea_escala_destino,
        i.fecha_escala_salida,
        i.hora_escala_salida,
        i.fecha_escala_regreso,
        i.hora_escala_regreso,
        i.fecha_salida, 
        i.hora_salida, 
        i.fecha_regreso, 
        i.hora_regreso,
        i.nota, 
        a.aeropuerto as aeropuerto_salida, 
        ae.aeropuerto as aeropuerto_escala_salida, 
        aa.aeropuerto as aeropuerto_regreso,
        aea.aeropuerto as aeropuerto_escala_regreso,
        concat(ra.nombre, " ", ra.segundo_nombre, " ", ra.apellido_paterno, " ", ra.apellido_materno) as nombre_completo
        FROM itinerario i 
        INNER JOIN catalogo_aerolinea cao on cao.id_aerolinea = i.aerolinea_origen 
        LEFT JOIN catalogo_aerolinea caeo on caeo.id_aerolinea = i.aerolinea_escala_origen
        INNER JOIN catalogo_aerolinea cad on cad.id_aerolinea = i.aerolinea_destino
        LEFT JOIN catalogo_aerolinea caed on caed.id_aerolinea = i.aerolinea_escala_destino
        INNER JOIN aeropuertos a on a.id_aeropuerto = i.aeropuerto_salida 
        LEFT JOIN aeropuertos ae on ae.id_aeropuerto = i.aeropuerto_escala_salida
        INNER JOIN aeropuertos aa on aa.id_aeropuerto = i.aeropuerto_regreso 
        LEFT JOIN aeropuertos aea on aea.id_aeropuerto = i.aeropuerto_escala_regreso
        INNER JOIN utilerias_asistentes ua on ua.utilerias_asistentes_id = i.utilerias_asistentes_id 
        INNER JOIN registros_acceso ra on ra.id_registro_acceso = ua.id_registro_acceso
        INNER JOIN utilerias_asistentes u ON u.id_registro_acceso = ra.id_registro_acceso        
        INNER JOIN linea_principal lp  ON lp.id_linea_principal = ra.especialidad          
        
sql;
        return $mysqli->queryAll($query);
    }

    public static function getItinerariosByLinea($id_linea){
        $mysqli = Database::getInstance(true);
        $query =<<<sql
        SELECT 
        i.id_itinerario, 
        i.fecha_alta as fecha_registro,
        b.nombre as nombre_bu,
        lp.nombre as nombre_linea,
        p.nombre as nombre_posicion,
        ra.telefono,
        ra.email,
        uad.nombre as nombre_ejecutivo,
       	le.color,
        le.nombre as nombre_linea_ejecutivo,
        cao.nombre as aerolinea_origen, 
        caeo.nombre as aerolinea_escala_origen, 
        cad.nombre as aerolinea_destino, 
        caed.nombre as aerolinea_escala_destino,
        i.fecha_escala_salida,
        i.hora_escala_salida,
        i.fecha_escala_regreso,
        i.hora_escala_regreso,
        i.fecha_salida, 
        i.hora_salida, 
        i.fecha_regreso, 
        i.hora_regreso,
        i.nota, 
        concat(ra.nombre, " ", ra.segundo_nombre, " ", ra.apellido_paterno, " ", ra.apellido_materno) as nombre_completo
        FROM itinerario i 
        INNER JOIN catalogo_aerolinea cao on cao.id_aerolinea = i.aerolinea_origen 
        LEFT JOIN catalogo_aerolinea caeo on caeo.id_aerolinea = i.aerolinea_escala_origen
        INNER JOIN catalogo_aerolinea cad on cad.id_aerolinea = i.aerolinea_destino
        LEFT JOIN catalogo_aerolinea caed on caed.id_aerolinea = i.aerolinea_escala_destino
        INNER JOIN utilerias_asistentes ua on ua.utilerias_asistentes_id = i.utilerias_asistentes_id 
        INNER JOIN registros_acceso ra on ra.id_registro_acceso = ua.id_registro_acceso
        INNER JOIN utilerias_asistentes u ON u.id_registro_acceso = ra.id_registro_acceso
        INNER JOIN bu b  ON b.id_bu = ra.id_bu
        INNER JOIN linea_principal lp  ON lp.id_linea_principal = ra.id_linea_principal
        INNER JOIN posiciones p ON p.id_posicion = ra.id_posicion
        INNER JOIN linea_ejecutivo le ON le.id_linea_ejecutivo = lp.id_linea_ejecutivo
        INNER JOIN asigna_linea al ON al.id_linea_ejecutivo = le.id_linea_ejecutivo
        INNER JOIN utilerias_administradores uad ON uad.utilerias_administradores_id = al.utilerias_administradores_id_linea_asignada
        WHERE lp.id_linea_ejecutivo = $id_linea
sql;

        return $mysqli->queryAll($query);
    }

    public static function getAsistenteNombreItinerario($id){
        $mysqli = Database::getInstance();
        $query=<<<sql
        SELECT ra.id_registro_acceso, 
        CONCAT(ra.nombre, ' ', ra.segundo_nombre, ' ', ra.apellido_paterno, ' ', ra.apellido_materno) as nombre, ua.utilerias_asistentes_id 
        from utilerias_asistentes ua 
        INNER JOIN registros_acceso ra on ra.id_registro_acceso = ua.id_registro_acceso 
        WHERE ua.utilerias_asistentes_id NOT IN (SELECT utilerias_asistentes_id FROM itinerario)
sql;
        return $mysqli->queryAll($query);
    }

//     public static function getAsistenteNombreItinerario($id_utilerias_administradores){
//         $mysqli = Database::getInstance();
//         $query=<<<sql
//         select ra.id_registro_acceso, CONCAT(ra.nombre, ' ', ra.segundo_nombre, ' ', ra.apellido_paterno, ' ', ra.apellido_materno) as nombre, ua.utilerias_asistentes_id from utilerias_asistentes ua 
//         INNER JOIN registros_acceso ra on ra.id_registro_acceso = ua.id_registro_acceso 
//         INNER JOIN comprobante_vacuna cv on cv.utilerias_asistentes_id = ua.utilerias_asistentes_id 
//         WHERE cv.validado = 1 AND ua.utilerias_asistentes_id 
//         NOT IN (SELECT utilerias_asistentes_id FROM itinerario)
// sql;
//         return $mysqli->queryAll($query);
//     }

    public static function getAsistenteNombreItinerarioById($id){
        $mysqli = Database::getInstance();
        $query=<<<sql
        select ra.id_registro_acceso, CONCAT(ra.nombre, ' ', ra.segundo_nombre, ' ', ra.apellido_paterno, ' ', ra.apellido_materno) as nombre, ua.utilerias_asistentes_id, ua.usuario 
        from utilerias_asistentes ua 
        INNER JOIN registros_acceso ra on ra.id_registro_acceso = ua.id_registro_acceso 
        INNER JOIN comprobante_vacuna cv on cv.utilerias_asistentes_id = ua.utilerias_asistentes_id
        INNER JOIN prueba_covid pc on pc.utilerias_asistentes_id = ua.utilerias_asistentes_id 
        WHERE cv.status = 1 and pc.status = 2 AND ua.utilerias_asistentes_id = $id;
sql;
        return $mysqli->queryAll($query);
    }

    public static function getAeropuertoOrigen(){
        $mysqli = Database::getInstance();
        $query=<<<sql
        SELECT * FROM `aeropuertos` where id_aeropuerto != 40 ORDER BY iata ASC;
sql;
        return $mysqli->queryAll($query);
    }

    public static function getAeropuertoDestino(){
        $mysqli = Database::getInstance();
        $query=<<<sql
        SELECT * FROM `aeropuertos` where id_aeropuerto = 40;
sql;
        return $mysqli->queryAll($query);
    }

    public static function getAeropuertosAll(){
        $mysqli = Database::getInstance();
        $query=<<<sql
        SELECT * FROM `aeropuertos`
sql;
        return $mysqli->queryAll($query);
    }

    public static function getCountVuelos(){
        $mysqli = Database::getInstance();
        $query=<<<sql
        SELECT COUNT(*) as usuarios FROM `utilerias_asistentes` where status = 1;
sql;
        return $mysqli->queryAll($query);
    }

    public static function getCountVuelosLlegada(){
        $mysqli = Database::getInstance();
        $query=<<<sql
        SELECT COUNT(*) as total FROM `pases_abordar` where tipo = 1;
sql;
        return $mysqli->queryAll($query);
    }

    public static function getCountVuelosSalida(){
        $mysqli = Database::getInstance();
        $query=<<<sql
        SELECT COUNT(*) as total FROM `pases_abordar` where tipo = 2;
sql;
        return $mysqli->queryAll($query);
    }

    public static function getAerolineas(){
        $mysqli = Database::getInstance();
        $query=<<<sql
            SELECT * FROM catalogo_aerolinea
sql;
        return $mysqli->queryAll($query);
    }

    public static function getPaseById($id){
        $mysqli = Database::getInstance();
        $query=<<<sql
        SELECT pa.id_pase_abordar, pa.clave, CONCAT(ra.nombre," ", ra.segundo_nombre," ", ra.apellido_paterno," ", ra.apellido_materno) as nombre, 
            pa.nota , ua.nombre as nombre_registro, ra.email, ra.telefono,  pa.url AS link, pa.tipo
            FROM pases_abordar pa
            INNER JOIN utilerias_administradores ua on ua.utilerias_administradores_id = pa.utilerias_administradores_id
            INNER JOIN utilerias_asistentes uaa on uaa.utilerias_asistentes_id = pa.utilerias_asistentes_id
            INNER JOIN registros_acceso ra on ra.id_registro_acceso = uaa.id_registro_acceso
            WHERE pa.id_pase_abordar = $id
sql;
        return $mysqli->queryAll($query);
    }

}