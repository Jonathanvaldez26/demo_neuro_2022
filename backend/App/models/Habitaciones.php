<?php
namespace App\models;
defined("APPPATH") OR die("Access denied");

use \Core\Database;
use \App\interfaces\Crud;
use \App\controllers\UtileriasLog;

class Habitaciones implements Crud{
    
    public static function getAll(){
        $mysqli = Database::getInstance();
      $query=<<<sql
       SELECT * FROM hoteles;
sql;
      return $mysqli->queryAll($query);
        
    }

    public static function getHabitaciones(){
      $mysqli = Database::getInstance();
      $query=<<<sql
      SELECT ah.cant_habitaciones, ch.id_categoria_habitacion,ch.id_hotel,ch.nombre_categoria, ch.huespedes
      FROM habitaciones_hotel ah
      INNER JOIN categorias_habitaciones ch ON (ah.id_categoria_habitacion = ch.id_categoria_habitacion)
sql;
    return $mysqli->queryAll($query);
      
  }
    public static function getById($id){
        
    }
    public static function insert($data){

      $mysqli = Database::getInstance();
      $query = <<<sql
      INSERT INTO habitaciones_hotel VALUES(null,:id_hotel,:id_categoria_habitacion, :cant_habitaciones,:utilerias_administradores_id, NOW(), 1)                        
sql;

      $parametros = array(
          ':id_hotel' => $data->_hotel,
          ':id_categoria_habitacion' => $data->_categoria_habitacion,
          ':utilerias_administradores_id' => $data->_administrador,
          ':cant_habitaciones' => $data->_cant_habitaciones
      );

      $id = $mysqli->insert($query, $parametros);
      $accion = new \stdClass();
      $accion->_sql = $query;
      $accion->_parametros = $parametros;
      $accion->_id = $id;

      return $id;
        
    }


    public static function update($hotel){
      $mysqli = Database::getInstance(true);
      $query=<<<sql
      UPDATE hoteles SET nombre_hotel = :nombre_hotel, cliente = :cliente, evento = :evento, fechas = :fechas, lugar = :lugar, total_habitaciones =	:total_habitaciones WHERE id_hotel = :id_hotel;
sql;
      $parametros = array(
        ':id_hotel'=>$hotel->_id_hotel,
        ':nombre_hotel'=>$hotel->_nombre_hotel,
        ':cliente'=>$hotel->_cliente,
        ':evento'=>$hotel->_evento,
        ':fechas'=>$hotel->_fechas,
        ':total_habitaciones'=>$hotel->_total_habitaciones,
        ':lugar' =>$hotel->_lugar
      );
        $accion = new \stdClass();
        $accion->_sql= $query;
        $accion->_parametros = $parametros;
        $accion->_id = $hotel->_id_hotel;
        return $mysqli->update($query, $parametros);
    }

    public static function updateCategoria($hotel_cat){
      $mysqli = Database::getInstance(true);
      $query=<<<sql
      UPDATE categorias_habitaciones SET categoria_habitacion = :categoria_habitacion, nombre_categoria = :nombre_categoria, huespedes = :huespedes, total_huespedes = :total_huespedes WHERE id_categoria_habitacion = :id_categoria_habitacion
sql;
      $parametros = array(
        ':id_categoria_habitacion'=>$hotel_cat->_id_categoria_habitacion,
        ':categoria_habitacion'=>$hotel_cat->_categoria_habitacion,
        ':nombre_categoria'=>$hotel_cat->_nombre_categoria,
        ':huespedes'=>$hotel_cat->_huespedes,
        ':total_huespedes'=>$hotel_cat->_total_huespedes,
      );

        $accion = new \stdClass();
        $accion->_sql= $query;
        $accion->_parametros = $parametros;
        $accion->_id = $hotel_cat->_id_habitacion;
        return $mysqli->update($query, $parametros);
    }

    public static function updateHabitacionUsuario($habitacion){
      $mysqli = Database::getInstance(true);
      $query=<<<sql
      UPDATE asigna_habitacion SET id_habitacion = :numero_habitacion WHERE id_asigna_habitacion = :id_asigna_habitacion
sql;
      $parametros = array(
        ':numero_habitacion'=>$habitacion->_numero_habitacion,
        ':id_asigna_habitacion'=>$habitacion->_id_asigna_habitacion
      );

        $accion = new \stdClass();
        $accion->_sql= $query;
        $accion->_parametros = $parametros;
        $accion->_id = $habitacion->_id_habitacion;
        return $mysqli->update($query, $parametros);
    }

    public static function updateHabitacionesHotel($hotel){
      $mysqli = Database::getInstance(true);
      $query=<<<sql
      UPDATE habitaciones_hotel SET cant_habitaciones = :cant_habitaciones WHERE id_categoria_habitacion = :id_categoria_habitacion;
sql;
      $parametros = array(
        ':cant_habitaciones'=>$hotel->_cant_habitaciones,
        ':id_categoria_habitacion'=>$hotel->_id_categoria_habitacion
      );
        $accion = new \stdClass();
        $accion->_sql= $query;
        $accion->_parametros = $parametros;
        $accion->_id = $hotel->_id_hotel;
        return $mysqli->update($query, $parametros);
    }

    public static function BuscarHabitacion($no_habitacion){
      $mysqli = Database::getInstance(true);
        $query =<<<sql
        SELECT * FROM habitaciones_hotel WHERE numero_habitacion LIKE '$no_habitacion'
sql;

        return $mysqli->queryAll($query);
    }

    public static function BuscaHabitacion($no_habitacion){
      $mysqli = Database::getInstance(true);
        $query =<<<sql
        SELECT DISTINCT id_habitacion FROM asigna_habitacion WHERE id_habitacion LIKE '$no_habitacion'
sql;

        return $mysqli->queryAll($query);
    }

    public static function BuscaHabitacionCountCheckin($no_habitacion, $id_categoria_habitacion){
      $mysqli = Database::getInstance(true);
        $query =<<<sql
        SELECT count(*) as total, id_categoria_habitacion FROM asigna_habitacion WHERE id_habitacion = '$no_habitacion' and id_categoria_habitacion = '$id_categoria_habitacion'
sql;

        return $mysqli->queryAll($query);
    }
    
    public static function delete($id){
        
    }

    public static function getAllCategoriasHabitaciones(){
      $mysqli = Database::getInstance(true);
      $query =<<<sql
      SELECT * FROM categorias_habitaciones
sql;

      return $mysqli->queryAll($query);
 
    }

    public static function getCategoriasHabitacionesDistict(){
      $mysqli = Database::getInstance(true);
      $query =<<<sql
      SELECT * FROM categorias_habitaciones WHERE id_categoria_habitacion NOT IN (SELECT id_categoria_habitacion FROM habitaciones_hotel) ORDER BY nombre_categoria ASC
sql;

      return $mysqli->queryAll($query);
 
    }

    public static function getCategoriasHabitaciones(){
      $mysqli = Database::getInstance(true);
      $query =<<<sql
      SELECT * FROM categorias_habitaciones 
sql;

      return $mysqli->queryAll($query);
 
    }

    public static function getCategoriasHabitacionesById($id){
      $mysqli = Database::getInstance();
      $query=<<<sql
      SELECT * FROM categorias_habitaciones WHERE id_categoria_habitacion = $id
sql;
      return $mysqli->queryAll($query);
        
    }

    public static function getAsignaHabitacionByClave($clave){
      $mysqli = Database::getInstance();
      $query=<<<sql
      SELECT * FROM asigna_habitacion WHERE clave = '$clave'
sql;
      return $mysqli->queryAll($query);
        
    }

    public static function getAsignaHabitacionByIdRegAcceso($id){
      $mysqli = Database::getInstance();
      $query=<<<sql
      SELECT * FROM asigna_habitacion WHERE id_registro_acceso = $id
sql;
      return $mysqli->queryAll($query);
        
    }

    public static function insertAsignaHabitacion($data){
      $mysqli = Database::getInstance(1);
      $query=<<<sql
      INSERT INTO asigna_habitacion (id_categoria_habitacion, id_habitacion, id_registro_acceso, clave, date_in, date_out, comentarios, status, utilerias_administradores_id) VALUES  (:id_categoria_habitacion, :id_habitacion , :id_registro_acceso, :clave, :date_in, :date_out, :comentarios, 1, :utilerias_administradores_id);
sql;

    $parametros = array(
      ':id_categoria_habitacion'=>$data->_id_categoria_habitacion,
      ':id_registro_acceso'=>$data->_id_registro_acceso,
      ':clave'=>$data->_clave,
      ':date_in'=>$data->_fecha_in,
      ':date_out'=>$data->_fecha_out,
      ':comentarios'=>$data->_comentarios,
      ':id_habitacion'=>$data->_numero_habitacion,
      ':utilerias_administradores_id'=>$data->_id_administrador
          
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

  public static function deleteAsignaHabitacion($id){
    $mysqli = Database::getInstance();
    $query=<<<sql
    DELETE FROM asigna_habitacion WHERE id_asigna_habitacion  = $id
sql;
          
    return $mysqli->update($query);
    
  
  }

  

}