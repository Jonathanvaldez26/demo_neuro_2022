<?php
namespace App\models;
defined("APPPATH") OR die("Access denied");

use \Core\Database;
use \App\interfaces\Crud;
use \App\controllers\UtileriasLog;

class Administradores implements Crud{
//     public static function getAll(){
//         $mysqli = Database::getInstance();
//         $query=<<<sql
//             SELECT a.utilerias_administradores_id, a.nombre, a.usuario, a.perfil_id, a.descripcion, a.status, a.code, s.nombre AS nombre_status, p.nombre AS nombre_perfil
//             FROM utilerias_administradores AS a
//             INNER JOIN utilerias_permisos AS per ON (a.usuario = per.usuario)
//             INNER JOIN catalogo_status AS s ON (a.status = s.catalogo_status_id)
//             INNER JOIN utilerias_perfiles AS p ON(a.perfil_id = p.perfil_id)
//             WHERE a.usuario = per.usuario AND a.status = 1
// sql;
//         return $mysqli->queryAll($query);
//     }

    public static function getAll(){
      $mysqli = Database::getInstance();
      $query=<<<sql
      SELECT a.utilerias_administradores_id, a.nombre, a.usuario, a.perfil_id, a.descripcion, a.status, a.code, p.nombre AS nombre_perfil
      FROM utilerias_administradores AS a
      INNER JOIN utilerias_perfiles AS p ON(a.perfil_id = p.perfil_id)
      WHERE  a.status = 1
sql;
      return $mysqli->queryAll($query);
  }
    
    public static function getById($id){
        $mysqli = Database::getInstance();
        $query=<<<sql
            SELECT * FROM utilerias_administradores WHERE utilerias_administradores_id  = $id
sql;
        return $mysqli->queryOne($query);
        
    }

    public static function getByCode($code){
      $mysqli = Database::getInstance();
      $query=<<<sql
          SELECT * FROM utilerias_administradores WHERE code  = '$code'
sql;
      return $mysqli->queryOne($query);
      
  }

  public static function getAllByCode($code){
    $mysqli = Database::getInstance();
    $query=<<<sql
    SELECT * FROM utilerias_administradores WHERE code  = '$code'
sql;
    return $mysqli->queryOne($query);
    
}


  public static function getAsignaLine($id_admin){
    $mysqli = Database::getInstance();
    $query=<<<sql
    SELECT * FROM asigna_linea WHERE utilerias_administradores_id_linea_asignada = $id_admin
sql;
    return $mysqli->queryOne($query);
  
}



public static function getAllWithOutLineaByCode($code){
  $mysqli = Database::getInstance();
  $query=<<<sql
  SELECT * from utilerias_administradores WHERE code  = '$code'
sql;
  return $mysqli->queryOne($query);
  
}

    public static function insert($administradores){
	    $mysqli = Database::getInstance(1);
        $query=<<<sql
            INSERT INTO utilerias_administradores(nombre, usuario, contrasena, perfil_id, descripcion, fecha_alta, code,status) 
            VALUES (:nombre, :usuario, :contrasena, :perfil_id, :descripcion, NOW(),:code ,1)
sql;
            $parametros = array(
            ':nombre'=>$administradores->_nombre,
            ':usuario'=>$administradores->_usuario,
            ':contrasena'=>$administradores->_contrasena,
            ':perfil_id'=>$administradores->_perfil_id,
            ':descripcion'=>$administradores->_descripcion,
            ':code'=>$administradores->_code
            );

            $id = $mysqli->insert($query,$parametros);

            $accion = new \stdClass();
            $accion->_sql= $query;
            $accion->_parametros = $parametros;
            $accion->_id = $id;

            //UtileriasLog::addAccion($accion);
            return $id;
    }

    public static function insertPermisos($permisos){

        $mysqli = Database::getInstance(1);
        $query=<<<sql
        INSERT INTO utilerias_permisos (usuario, permisos_globales, seccion_principal, seccion_asistentes, 	seccion_bu, seccion_lineas, seccion_posiciones, seccion_restaurantes, seccion_gafete, seccion_vuelos, seccion_pickup, seccion_habitaciones, seccion_cenas, seccion_vacunacion, seccion_pruebas_covid, seccion_asistencias, seccion_utilerias, seccion_configuracion) VALUES (:usuario, :permisos_globales, :seccion_principal, :seccion_asistentes, :seccion_bu, :seccion_lineas, :seccion_posiciones, :seccion_restaurantes, :seccion_gafete, :seccion_vuelos, :seccion_pickup, :seccion_habitaciones, :seccion_cenas, :seccion_vacunacion, :seccion_pruebas_covid, :seccion_asistencias, :seccion_utilerias, :seccion_configuracion);
sql;
        $parametros = array(
          ':usuario'=>$permisos->_usuario,
          ':permisos_globales'=>$permisos->_permisos_globales,
          ':seccion_principal'=>$permisos->_seccion_principal,
          ':seccion_asistentes'=>$permisos->_seccion_asistentes,
          ':seccion_bu'=>$permisos->_seccion_bu,
          ':seccion_lineas'=>$permisos->_seccion_lineas,
          ':seccion_posiciones'=>$permisos->_seccion_posiciones,
          ':seccion_restaurantes'=>$permisos->_seccion_restaurantes,
          ':seccion_gafete'=>$permisos->_seccion_gafete,
          ':seccion_vuelos'=>$permisos->_seccion_vuelos,
          ':seccion_pickup'=>$permisos->_seccion_pickup,
          ':seccion_habitaciones'=>$permisos->_seccion_habitaciones,
          ':seccion_cenas'=>$permisos->_seccion_cenas,
          ':seccion_vacunacion'=>$permisos->_seccion_vacunacion,
          ':seccion_pruebas_covid'=>$permisos->_seccion_pruebas_covid,
          ':seccion_asistencias'=>$permisos->_seccion_asistencias,
          ':seccion_utilerias'=>$permisos->_seccion_utilerias,
          ':seccion_configuracion'=>$permisos->_seccion_configuracion
        );
  
        $id = $mysqli->insert($query,$parametros);
  
        $accion = new \stdClass();
        $accion->_sql= $query;
        $accion->_parametros = $parametros;
        $accion->_id = $id;
  
       // UtileriasLog::addAccion($accion);
        return $id;
    }

    public static function update($data){
        
    }
    public static function delete($id){
      $mysqli = Database::getInstance();
      $query = <<<sql
      UPDATE utilerias_administradores SET status = 2 WHERE utilerias_administradores_id = $id and usuario != 'root@grupolahe.com';
sql;
      $sql = $mysqli->update($query);
      //$accion = new \stdClass();
      //$accion->_sql= $query;
      //$accion->_parametros = $parametros;
     // $accion->_id = $id;
      //UtileriasLog::addAccion($accion);
      return array('seccion'=>1, 'id'=>$id); // Cambia el status a eliminado
        
    }

    public static function getUser($user){
      $mysqli = Database::getInstance();
      $query =<<<sql
      SELECT * FROM utilerias_administradores WHERE usuario LIKE '$user'
sql;
      $dato = $mysqli->queryOne($query);
      return ($dato>=1) ? 1 : 2 ;
    }

    ///////////
    public static function getDepartamentosAdministrador($id){
        
    }
    public static function getPlantas(){
        
    }
    public static function getPerfiles(){
      $mysqli = Database::getInstance();
      $query=<<<sql
      SELECT * FROM utilerias_perfiles WHERE status != 2
sql;
      return $mysqli->queryAll($query);
        
    }

    public static function getPerfil(){
        $mysqli = Database::getInstance();
        $query=<<<sql
        SELECT * FROM utilerias_perfiles
sql;
        return $mysqli->queryAll($query);
    }
    public static function User(){
        
    }
    public static function getStatus(){
      $mysqli = Database::getInstance();
      $query=<<<sql
      SELECT * FROM catalogo_status
sql;
      return $mysqli->queryAll($query);
        
    }
    public static function getSeccionesMenu(){
        $mysqli = Database::getInstance();
        $query=<<<sql
        SELECT * FROM utilerias_secciones ORDER BY utilerias_seccion_id
sql;
        return $mysqli->queryAll($query);
      }
    public static function getDepartamentos(){
        
    }
    public static function getPermisosByUser($usuario){
        $mysqli = Database::getInstance();
        $query=<<<sql
        SELECT * FROM utilerias_permisos WHERE usuario = '$usuario'
sql;
        return $mysqli->queryOne($query);
    }

    public static function updateDataAdministrador($administrador){
        $mysqli = Database::getInstance();
        $query=<<<sql
        UPDATE utilerias_administradores SET perfil_id = :perfil_id, descripcion = :descripcion, status = :status WHERE usuario = :usuario;
sql;
        $parametros = array(
          ':usuario'=>$administrador->_usuario,
          ':perfil_id'=>$administrador->_perfil_id,
          ':descripcion'=>$administrador->_descripcion,
          ':status'=>$administrador->_status
        );
        
        $accion = new \stdClass();
        $accion->_sql= $query;
        $accion->_parametros = $parametros;
        $accion->_id = $administrador->_administrador_id;
        //UtileriasLog::addAccion($accion);
        return $mysqli->update($query, $parametros);
    }

    public static function updatePermisosUsuario($permisos){
        $mysqli = Database::getInstance();


        $query=<<<sql
        UPDATE utilerias_permisos SET permisos_globales = :permisos_globales, seccion_principal = :seccion_principal, seccion_asistentes = :seccion_asistentes, seccion_bu = :seccion_bu, seccion_lineas = :seccion_lineas, seccion_posiciones = :seccion_posiciones, seccion_restaurantes = :seccion_restaurantes, seccion_gafete = :seccion_gafete, seccion_vuelos = :seccion_vuelos, seccion_pickup = :seccion_pickup, seccion_habitaciones = :seccion_habitaciones, seccion_cenas = :seccion_cenas, seccion_vacunacion = :seccion_vacunacion, seccion_pruebas_covid = :seccion_pruebas_covid, seccion_asistencias = :seccion_asistencias, seccion_utilerias = :seccion_utilerias, seccion_configuracion = :seccion_configuracion WHERE usuario = :usuario;
sql;
        $parametros = array(
          ':usuario'=>$permisos->_usuario,
          ':permisos_globales'=>$permisos->_permisos_globales,
          ':seccion_principal'=>$permisos->_seccion_principal,
          ':seccion_asistentes'=>$permisos->_seccion_asistentes,
          ':seccion_bu'=>$permisos->_seccion_bu,
          ':seccion_lineas'=>$permisos->_seccion_lineas,
          ':seccion_posiciones'=>$permisos->_seccion_posiciones,
          ':seccion_restaurantes'=>$permisos->_seccion_restaurantes,
          ':seccion_gafete'=>$permisos->_seccion_gafete,
          ':seccion_vuelos'=>$permisos->_seccion_vuelos,
          ':seccion_pickup'=>$permisos->_seccion_pickup,
          ':seccion_habitaciones'=>$permisos->_seccion_habitaciones,
          ':seccion_cenas'=>$permisos->_seccion_cenas,
          ':seccion_vacunacion'=>$permisos->_seccion_vacunacion,
          ':seccion_pruebas_covid'=>$permisos->_seccion_pruebas_covid,
          ':seccion_asistencias'=>$permisos->_seccion_asistencias,
          ':seccion_utilerias'=>$permisos->_seccion_utilerias,
          ':seccion_configuracion'=>$permisos->_seccion_configuracion
          
        );
          $accion = new \stdClass();
          $accion->_sql= $query;
          $accion->_parametros = $parametros;
          $accion->_id = $permisos->_administrador_id;
          //UtileriasLog::addAccion($accion);
          return $mysqli->update($query, $parametros);
          
      
    }

    
}