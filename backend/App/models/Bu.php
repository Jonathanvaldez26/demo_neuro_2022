<?php
namespace App\models;
defined("APPPATH") OR die("Access denied");

use \Core\Database;
use \Core\MasterDom;
use \App\interfaces\Crud;
use \App\controllers\UtileriasLog;

class Bu implements Crud{

    public static function getAll(){
      $mysqli = Database::getInstance();
      $query=<<<sql
       SELECT b.id_bu, b.clave, b.nombre, b.fecha_alta, ua.nombre as creo FROM bu b
 INNER JOIN utilerias_administradores ua on ua.utilerias_administradores_id = b.utilerias_administradores_id  ORDER BY b.nombre ASC;
sql;
      return $mysqli->queryAll($query);
    }

    public static function insert($bu){
	    $mysqli = Database::getInstance(1);
      $query=<<<sql
        INSERT INTO bu VALUES(null, :nombre, 1,null)
sql;
        $parametros = array(
          ':nombre'=>$bu->_nombre_bu
        );

        $id = $mysqli->insert($query,$parametros);
        $accion = new \stdClass();
        $accion->_sql= $query;
        $accion->_parametros = $parametros;
        $accion->_id = $id;
        
        return $id;
    }

    public static function update($empresa){
      $mysqli = Database::getInstance(1);
      $query=<<<sql
      UPDATE catalogo_empresa SET clave = :clave, rfc = :rfc, razon_social = :razon_social, email = :email, telefono = :telefono WHERE catalogo_empresa_id = :id
sql;
      $parametros = array(
        ':clave'=>$empresa->_clave,
        ':rfc'=>$empresa->_rfc,
        ':razon_social'=>$empresa->_razon_social,
        ':email'=>$empresa->_email,
        'telefono_uno'=>$empresa->_telefono_uno,
        'telefono_dos'=>$empresa->_telefono_dos,
        'domicilio_fiscal'=>$empresa->_domicilio_fiscal,
        'sitio_web'=>$empresa->_sitio_web
      );
      $accion = new \stdClass();
      $accion->_sql= $query;
      $accion->_parametros = $parametros;
      $accion->_id = $empresa->_catalogo_empresa_id;
      // UtileriasLog::addAccion($accion);
        return $mysqli->update($query, $parametros);
    }

    public static function delete($id){
      $mysqli = Database::getInstance();
      $select = <<<sql
      SELECT e.catalogo_empresa_id FROM catalogo_empresa e WHERE e.catalogo_empresa_id = $id
sql;

      $sqlSelect = $mysqli->queryAll($select);
      if(count($sqlSelect) >= 1){
        return array('seccion'=>2, 'id'=>$id); // NO elimina
      }else{
        $query = <<<sql
        UPDATE catalogo_empresa SET status = 2 WHERE catalogo_empresa.catalogo_empresa_id = $id;
sql;
        $mysqli->update($query);

        $accion = new \stdClass();
        $accion->_sql= $query;
        $accion->_parametros = $parametros;
        $accion->_id = $id;
        // UtileriasLog::addAccion($accion);
        return array('seccion'=>1, 'id'=>$id); // Cambia el status a eliminado
      }
    }

    public static function verificarRelacion($id){
      $mysqli = Database::getInstance();
      $select = <<<sql
      SELECT e.catalogo_empresa_id FROM catalogo_empresa e JOIN catalogo_colaboradores c
      ON e.catalogo_empresa_id = c.catalogo_empresa_id WHERE e.catalogo_empresa_id = $id
sql;
      $sqlSelect = $mysqli->queryAll($select);
      if(count($sqlSelect) >= 1)
        return array('seccion'=>2, 'id'=>$id); // NO elimina
      else
        return array('seccion'=>1, 'id'=>$id); // Cambia el status a eliminado
      
    }

    public static function getById($id){
      $mysqli = Database::getInstance();
      $query=<<<sql
      SELECT catalogo_empresa_id, clave, rfc, razon_social, email, telefono_uno, telefono_dos, domicilio_fiscal, sitio_web, fecha_alta, status FROM catalogo_empresa WHERE catalogo_empresa_id = 5;
sql;
      return $mysqli->queryOne($query);
    }

    public static function getByIdReporte($id){
      $mysqli = Database::getInstance();
      $query=<<<sql
      SELECT e.catalogo_empresa_id, e.nombre, e.descripcion, e.status, s.nombre as status FROM catalogo_empresa e JOIN catalogo_status s ON s.catalogo_status_id = e.status WHERE e.status!=2 AND e.catalogo_empresa_id = $id
sql;

      return $mysqli->queryOne($query);
    }


    public static function getStatus(){
      $mysqli = Database::getInstance();
      $query=<<<sql
      SELECT * FROM catalogo_encargado
sql;
      return $mysqli->queryAll($query);
    }

    public static function getRFC($rfc_empresa){
      $mysqli = Database::getInstance();
      $query =<<<sql
      SELECT * FROM `catalogo_empresa` WHERE `rfc` LIKE '$rfc_empresa' 
sql;
      $dato = $mysqli->queryOne($query);
      return ($dato>=1) ? 1 : 2 ;
    }

    public static function getIdComparacion($id, $nombre){
      $mysqli = Database::getInstance();
      $query =<<<sql
      SELECT * FROM catalogo_empresa WHERE catalogo_empresa_id = '$id' AND nombre Like '$nombre' 
sql;
      $dato = $mysqli->queryOne($query);
      // 0

      if($dato>=1){
        return 1;
      }else{
        return 2;
      }
    }
}
