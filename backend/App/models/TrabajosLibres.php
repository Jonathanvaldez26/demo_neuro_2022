<?php
namespace App\models;
defined("APPPATH") OR die("Access denied");

use \Core\Database;
use \App\interfaces\Crud;
use \App\controllers\UtileriasLog;

class TrabajosLibres implements Crud{

    public static function getAll(){       
      $mysqli = Database::getInstance();
      $query=<<<sql
      SELECT * FROM trabajos_libres ORDER BY grupo, no_poster ASC
sql;
      return $mysqli->queryAll($query);
      
    }

    public static function getAllUsersCourse(){       
      $mysqli = Database::getInstance();
      $query=<<<sql
      SELECT re.codigo_beca,re.nombre, re.apellidop, re.apellidom, ac.id_asigna_curso, ac.id_curso, ac.id_registrado, cu.nombre as nombre_curso, cu.horario_transmision, cu.fecha_curso
      FROM registrados re 
      INNER JOIN asigna_curso ac ON (re.id_registrado = ac.id_registrado)
      INNER JOIN cursos cu ON (cu.id_curso = ac.id_curso) WHERE ac.status = 1
sql;
      return $mysqli->queryAll($query);
      
    }

    public static function getAllUsersCourseByClave($clave){       
      $mysqli = Database::getInstance();
      $query=<<<sql
      SELECT re.codigo_beca,re.nombre, re.apellidop, re.apellidom, ac.id_asigna_curso, ac.id_curso, ac.id_registrado, cu.nombre as nombre_curso, cu.horario_transmision, cu.fecha_curso, cu.duracion, pc.*
      FROM registrados re 
      INNER JOIN asigna_curso ac ON (re.id_registrado = ac.id_registrado)
      INNER JOIN cursos cu ON (cu.id_curso = ac.id_curso)
      LEFT JOIN progresos_cursos pc ON (pc.id_curso = ac.id_curso)
      WHERE re.clave = '$clave'
sql;
      return $mysqli->queryAll($query);
      
    }


    public static function getAllUsers(){       
      $mysqli = Database::getInstance();
      $query=<<<sql
      SELECT re.nombre, re.apellidop, re.apellidom, re.fecha_registro, re.clave, md.nombre as nombre_modalidad
      FROM registrados re
      INNER JOIN modalidad md ON(re.modalidad = md.id_modalidad)
sql;
      return $mysqli->queryAll($query);
      
    }

    public static function UpdateStatusAsignaCurso($data){
      $mysqli = Database::getInstance(true);
//       $query=<<<sql
//       UPDATE asigna_curso SET status = 0 WHERE id_asigna_curso  = :id_asigna_curso 
// sql;

      $query=<<<sql
      DELETE FROM asigna_curso WHERE id_asigna_curso  = :id_asigna_curso 
sql;

      $parametros = array(
        ':id_asigna_curso'=>$data->id_asigna_curso
      );

      // var_dump($parametros);
      // var_dump($query);
      // exit;
        // $accion = new \stdClass();
        // $accion->_sql= $query;
        // $accion->_parametros = $parametros;
        // $accion->_id = $hotel->_id_hotel;
        return $mysqli->update($query, $parametros);

    }

    public static function getCoursesNotSelectByUser($id_user){
      $mysqli = Database::getInstance(true);
      $query =<<<sql
      SELECT *  FROM cursos 
      WHERE id_curso NOT IN (SELECT cu.id_curso 
      FROM cursos cu
      INNER JOIN asigna_curso ac ON(cu.id_curso = ac.id_curso) WHERE ac.id_registrado = $id_user)
sql;
    
      return $mysqli->queryAll($query);

    }

    public static function getAllModalidad(){       
      $mysqli = Database::getInstance();
      $query=<<<sql
      SELECT * FROM modalidad      
sql;
      return $mysqli->queryAll($query);
      
    }

    public static function getPais(){       
      $mysqli = Database::getInstance();
      $query=<<<sql
      SELECT * FROM paises
sql;
      return $mysqli->queryAll($query);
    }



    public static function getStateByCountry($id_pais){
      $mysqli = Database::getInstance(true);
      $query =<<<sql
      SELECT * FROM estados where id_pais = '$id_pais'
sql;
    
      return $mysqli->queryAll($query);
    }
    public static function getById($id){
        
    }
    public static function insert($data){
      $mysqli = Database::getInstance(1);
      $query=<<<sql
      INSERT INTO trabajos_libres(clave,titulo, pdf,autor,email,grupo,no_poster)
      VALUES(:clave,:titulo, :pdf,:autor,:email,:grupo,:no_poster);
sql;


          $parametros = array(
          ':clave' => $data->_clave,
          ':titulo'=>$data->_titulo,
          ':pdf'=>$data->_pdf,
          ':autor'=>$data->_autor,
          ':email' =>$data->_email,
          ':grupo' =>$data->_grupo,
          ':no_poster' =>$data->_no_poster
          );
          $id = $mysqli->insert($query,$parametros);
          return $id;
        
    }

    public static function insertAsignaCurso($data){
      $mysqli = Database::getInstance(1);
      $query=<<<sql
      INSERT INTO asigna_curso(id_registrado,id_curso, fecha_asignacion,status)
      VALUES(:id_registrado,:id_curso, NOW(),1);
sql;

          $parametros = array(
          ':id_registrado' => $data->_id_registrado,
          ':id_curso'=>$data->_id_curso
          );
          $id = $mysqli->insert($query,$parametros);
          return $id;
        
    }

    public static function getUserRegister($email){
      $mysqli = Database::getInstance(true);
      $query =<<<sql
      SELECT * FROM registrados WHERE email = '$email'
sql;

      return $mysqli->queryAll($query);
  }
    public static function update($data){
      $mysqli = Database::getInstance(true);
      $query=<<<sql
      UPDATE cursos SET nombre = :nombre, fecha_curso = :fecha_curso, horario_transmision = :horario_transmision, id_modalidad = :id_modalidad, url = :url_curso, duracion = :duracion, descripcion= :descripcion WHERE id_curso = :id_curso
sql;

    
      $parametros = array(
        ':nombre'=>$data->_nombre,
        ':fecha_curso'=>$data->_fecha_curso,
        ':horario_transmision'=>$data->_horario_transmision,
        ':id_modalidad'=>$data->_id_modalidad,
        ':url_curso'=>$data->_url_curso,
        ':duracion'=>$data->_duracion,
        ':descripcion' =>$data->_descripcion,
        ':id_curso' => $data->_id_curso
      );

      // var_dump($parametros);
      // var_dump($query);
      // exit;
        // $accion = new \stdClass();
        // $accion->_sql= $query;
        // $accion->_parametros = $parametros;
        // $accion->_id = $hotel->_id_hotel;
        return $mysqli->update($query, $parametros);
        
    }

    public static function updateStatus($data){
      $mysqli = Database::getInstance(true);
      $query=<<<sql
      UPDATE cursos SET status = :status WHERE id_curso = :id_curso
sql;

      $parametros = array(
        ':status'=>$data->_status,
        ':id_curso'=>$data->_id_curso
      );

        // $accion = new \stdClass();
        // $accion->_sql= $query;
        // $accion->_parametros = $parametros;
        // $accion->_id = $hotel->_id_hotel;
        return $mysqli->update($query, $parametros);
        
    }

    public static function getAllCursos(){
      $mysqli = Database::getInstance();
      $query =<<<sql
      SELECT * FROM cursos
sql;
      return $mysqli->queryAll($query);
    }
    public static function delete($id){
        
    }
}