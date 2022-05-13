<?php
namespace App\models;
defined("APPPATH") OR die("Access denied");

use \Core\Database;
use \App\interfaces\Crud;
use \App\controllers\UtileriasLog;

class PruebasCovidEnSitio implements Crud{

    public static function getAll(){
        $mysqli = Database::getInstance();
        $query=<<<sql
        SELECT pc.*, CONCAT(ra.nombre,' ',ra.segundo_nombre,' ',ra.apellido_paterno,' ',ra.apellido_materno) AS nombre_completo
		FROM prueba_covid pc
        INNER JOIN utilerias_asistentes ua
        ON ua.utilerias_asistentes_id = pc.utilerias_asistentes_id
        INNER JOIN registros_acceso ra
        ON ra.id_registro_acceso = ua.id_registro_acceso
        WHERE pc.status = 3
sql;
        return $mysqli->queryAll($query);
    }

    public static function getById($id){
        
    }

    public static function getAsistentes(){
        $mysqli = Database::getInstance();
        $query=<<<sql
        SELECT esta.nombre, s.fecha_cita, s.hora_cita, u.usuario, CONCAT(ra.nombre,' ', ra.apellido_paterno,' ', ra.apellido_materno) as nombre_completo, ra.telefono, le.nombre as linea, u.utilerias_asistentes_id, le.color
FROM asigna_sorteo as ass INNER JOIN sorteo s on s.id_sorteo = ass.id_sorteo INNER JOIN utilerias_asistentes u ON ass.utilerias_asistentes_id = u.utilerias_asistentes_id INNER JOIN registros_acceso ra ON u.id_registro_acceso = ra.id_registro_acceso INNER JOIN bu b ON b.id_bu = ra.id_bu INNER JOIN linea_principal lp ON lp.id_linea_principal = ra.id_linea_principal INNER JOIN posiciones p ON p.id_posicion = ra.id_posicion INNER JOIN linea_ejecutivo le ON le.id_linea_ejecutivo = lp.id_linea_ejecutivo INNER JOIN asigna_linea al ON al.id_linea_ejecutivo = le.id_linea_ejecutivo INNER JOIN utilerias_administradores uad ON uad.utilerias_administradores_id = al.utilerias_administradores_id_linea_asignada 
INNER JOIN ciudades esta on esta.id_ciudades = ra.id_ciudades
WHERE fecha_cita = '2022-04-07' and esta.nombre != 'Guadalajara' and esta.nombre !='Aguascalientes' GROUP BY ra.id_registro_acceso

sql;
        return $mysqli->queryAll($query);
    }

    // CONSULTA INICIAL--------------
    // SELECT * FROM registros_acceso ra
    //     INNER JOIN utilerias_asistentes ua
    //     ON ua.id_registro_acceso = ra.id_registro_acceso

    public static function insert($data){
        $fecha_carga_documento = date("Y-m-d");
        $mysqli = Database::getInstance(1);
        $query=<<<sql
        INSERT INTO prueba_covid 
        
        (utilerias_asistentes_id, 
        fecha_carga_documento, 
        fecha_prueba_covid, 
        tipo_prueba, 
        resultado, 
        documento,
        nota,
        status) 
        
        VALUES 
        (:utilerias_asistentes_id, 
        NOW(), 
        :fecha_prueba_covid, 
        :tipo_prueba, 
        :resultado, 
        :documento,
        :nota,
        3);
sql;
    

        $parametros = array(
            ':utilerias_asistentes_id'=>$data->_user,
            ':fecha_prueba_covid'=>$data->_fecha_prueba,
            ':tipo_prueba'=>$data->_tipo_prueba,
            ':resultado'=>$data->_resultado,
            ':nota'=>$data->_nota,
            ':documento'=>$data->_url
        );

        $id = $mysqli->insert($query,$parametros);
        $accion = new \stdClass();
        $accion->_sql= $query;
        $accion->_parametros = $parametros;
        $accion->_id = $id;

        //UtileriasLog::addAccion($accion);
        return $id;
        // return "insert"+$data;
    }

    public static function update($data){
        $mysqli = Database::getInstance(true);
        $query=<<<sql
        UPDATE prueba_covid SET 

        utilerias_asistentes_id = :utilerias_asistentes_id,
        fecha_prueba_covid = :fecha_prueba_covid,
        tipo_prueba = :tipo_prueba,
        resultado = :resultado,
        documento = :documento,
        nota = :nota

        WHERE id_prueba_covid = :id_prueba_covid
sql;
        // var_dump($data);
        $parametros = array(
            ':id_prueba_covid'=>$data->_id_prueba_covid,
            ':utilerias_asistentes_id'=>$data->_asistente,
            ':fecha_prueba_covid'=>$data->_fecha,
            ':tipo_prueba'=>$data->_tipo_prueba,
            ':resultado'=>$data->_resultado,
            ':nota'=>$data->_nota,
            ':documento'=>$data->_url    
        );

        // var_dump($parametros);

        $accion = new \stdClass();
        $accion->_sql= $query;
        $accion->_parametros = $parametros;
        $accion->_id = $data->_administrador_id;

        return $mysqli->update($query,$parametros);

    }

    public static function delete($id){
        $mysqli = Database::getInstance(true);
        $query=<<<sql
        DELETE FROM prueba_covid WHERE id_prueba_covid = '$id'
sql;
        return $mysqli->delete($query);

    }
}