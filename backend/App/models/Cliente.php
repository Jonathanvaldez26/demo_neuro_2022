<?php
namespace App\models;
defined("APPPATH") OR die("Access denied");

use \Core\Database;
use \App\interfaces\Crud;

class Cliente implements Crud{

    public static function getTipos(){
    	$mysqli = Database::getInstance();
    	$query=<<<sql
            SELECT * FROM `crm_clientes_tipo`
sql;
	   return $mysqli->queryAll($query);
    }

    public static function getEmail($usuario){
        $mysqli = Database::getInstance();
        $query=<<<sql
        SELECT * FROM `crm_clientes` WHERE email = :usuario ;
sql;
        return $mysqli->queryAll($query, array(':usuario'=>$usuario));
    }

    public static function getUsuario($usuario){
        $mysqli = Database::getInstance();
        $query=<<<sql
            SELECT * FROM `crm_usuarios` WHERE crm_usuarios_id = :usuario ;
sql;
        return $mysqli->queryOne($query, array(':usuario'=>$usuario));
    }

    public static function getUsuarios(){
        $mysqli = Database::getInstance();
        $query=<<<sql
            SELECT * FROM `crm_usuarios` WHERE estatus = 1 ;
sql;
        return $mysqli->queryAll($query);
    }

    public static function getTelefonoFijo($usuario){
        $mysqli = Database::getInstance();
        $query=<<<sql
            SELECT * FROM `crm_clientes` WHERE telefono_fijo = :usuario OR telefono_celular = :usuario ;
sql;
        return $mysqli->queryAll($query, array(':usuario'=>$usuario));
    }

    public static function getTelefonoCelular($usuario){
        $mysqli = Database::getInstance();
        $query=<<<sql
            SELECT * FROM `crm_clientes` WHERE telefono_celular = :usuario OR telefono_celular =:usuario ;
sql;
        return $mysqli->queryAll($query, array(':usuario'=>$usuario));
    }

    public static function getClientesUsuario($usuarios_id){
        $mysqli = Database::getInstance();
        $query=<<<sql
            SELECT cc.crm_clientes_id , if( cc.estatus =1, 'activo', 'inactivo' ) AS estatus_clientes, cc.email, cc.ap_paterno, cc.ap_materno, cc.nombre, cc.telefono_celular, cct.tipo, cu.usuario, cu.crm_usuarios_id

            FROM `crm_clientes` AS cc
            INNER JOIN crm_clientes_tipo AS cct USING (crm_clientes_tipo_id)
            INNER JOIN crm_usuarios AS cu USING (crm_usuarios_id)
            WHERE cc.estatus != 2
            AND cu.estatus != 2 AND cc.crm_usuarios_id = :usuarios_id ORDER By cc.mtime DESC;
sql;
        return $mysqli->queryAll($query, array(':usuarios_id'=>$usuarios_id));
    }

    public static function getAll(){

	$mysqli = Database::getInstance();
        $query=<<<sql
            SELECT cc.crm_clientes_id , if( cc.estatus =1, 'activo', 'inactivo' ) AS estatus_clientes, cc.email, cc.ap_paterno, cc.ap_materno, cc.nombre, cc.telefono_celular, cct.tipo, cu.usuario, cu.crm_usuarios_id

            FROM `crm_clientes` AS cc
            INNER JOIN crm_clientes_tipo AS cct USING (crm_clientes_tipo_id)
            INNER JOIN crm_usuarios AS cu USING (crm_usuarios_id)
            WHERE cc.estatus != 2
            AND cu.estatus != 2 ORDER By cc.mtime DESC;
sql;

        return $mysqli->queryAll($query);
    }

    public static function insert($datos){

	    $mysqli = Database::getInstance(1);
        $query=<<<sql
            INSERT INTO `inmobiliaria`.`crm_clientes` ( `ctime`,
            	`mtime`,
            	`nombre`,
            	`ap_paterno`,
            	`ap_materno`,
            	telefono_fijo,
            	telefono_celular,
            	img,
            	email,
            	fecha_nacimiento,
            	crm_clientes_tipo_id,
            	crm_usuarios_id,
            	comentario)
            	VALUES (NOW(), NOW(),
            	:nombre,
            	:ap_paterno,
            	:ap_materno,
            	:telefono_fijo,
            	:telefono_celular,
            	:img,
            	:email,
            	:fecha_nacimiento,
            	:crm_clientes_tipo_id,
            	:crm_clientes_id,
            	:comentario
            	);
sql;

	$params = array(
		':nombre'=>$datos->_nombre,
		':ap_paterno'=>$datos->_apPaterno,
		':ap_materno'=>$datos->_apMaterno,
		':fecha_nacimiento'=>$datos->_fechaNacimiento,
		':img'=>$datos->_img,
		':email'=>$datos->_email,
		':crm_clientes_tipo_id'=>$datos->_tipo,
		':telefono_fijo'=>$datos->_telefonoFijo,
		':telefono_celular'=>$datos->_telefonoCelular,
		':crm_clientes_id'=>$datos->_crm_clientes_id,
		':comentario'=>$datos->_comentario
		);

        return $mysqli->insert($query, $params);
    }


    public static function update($datos){

	    $params = array(
    		':id'=>$datos->_id,
            ':nombre'=>$datos->_nombre,
            ':ap_paterno'=>$datos->_apPaterno,
            ':ap_materno'=>$datos->_apMaterno,
            ':email'=>$datos->_email,
            ':crm_clientes_tipo_id'=>$datos->_tipo,
            ':telefono_celular'=>$datos->_telefonoCelular,
    		':crm_usuarios_id'=>$datos->_usuario,
            ':estatus'=>$datos->_estatus,
    		':comentario'=>$datos->_comentario
        );

	$img = 'img = img , ';
	if($datos->_img != ''){
	    $img = "img = :img, ";
	    $params[':img']=$datos->_img;
	}

	$fechaNacimiento = 'fecha_nacimiento = fecha_nacimiento , ';
        if($datos->_fechaNacimiento != ''){
            $fechaNacimiento = "fecha_nacimiento = :fecha_nacimiento, ";
            $params[':fecha_nacimiento']=$datos->_fechaNacimiento;
        }

	$telefonoFijo = 'telefono_fijo = telefono_fijo, ';
	if($datos->_telefonoFijo != 0){
	    $telefonoFijo =<<<sql
telefono_fijo = :telefono_fijo,
sql;
	    $params[':telefono_fijo']=$datos->_telefonoFijo;
	}

	$mysqli = Database::getInstance(true);
        $query=<<<sql
UPDATE `inmobiliaria`.`crm_clientes` SET
	    `ctime` = ctime,
        `mtime` = NOW(),
        `nombre` = :nombre,
        `ap_paterno` = :ap_paterno,
        `ap_materno` = :ap_materno,
        $telefonoFijo
        telefono_celular = :telefono_celular,
        $img
        email = :email,
        comentario = :comentario,
        $fechaNacimiento
        crm_clientes_tipo_id = :crm_clientes_tipo_id,
    	crm_usuarios_id = :crm_usuarios_id,
    	estatus = :estatus
	WHERE crm_clientes_id = :id ;
sql;


        return $mysqli->update($query, $params);
    }

    public static function delete($id){

	$mysqli = Database::getInstance();
        $query=<<<sql
UPDATE `crm_usuarios` SET estatus = 2 , mtime = NOW()
WHERE crm_usuarios_id = :id ;
sql;

        return $mysqli->update($query, array(':id'=>$id));
    }

    public static function getById($id){

	$mysqli = Database::getInstance();
        $query=<<<sql
SELECT * , if( estatus =1, 'activo', 'inactivo' ) AS estatus_clientes
FROM `crm_clientes`
INNER JOIN crm_clientes_tipo AS cct
USING ( crm_clientes_tipo_id )
WHERE crm_clientes_id = :id ;

sql;

        return $mysqli->queryOne($query, array(':id'=>$id));
    }


    public static function getClientes($id){

        $mysqli = Database::getInstance();
        $query=<<<sql
SELECT * FROM `crm_clientes`
WHERE crm_usuarios_id = :id ;
sql;
        return $mysqli->query($query, array(':id'=>$id));
    }
}
