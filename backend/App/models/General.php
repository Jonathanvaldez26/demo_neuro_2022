<?php
namespace App\models;
defined("APPPATH") OR die("Access denied");
use \Core\Database;
use \App\interfaces\Crud;
use \App\controllers\UtileriasLog;
class General implements Crud{
  // perfil_id -> 1.- ROOT 4.- Admin 5.- Personalizado 6. Recursos humanos
  // identificador_noi -> "" | "GATSA -> Pam liquidos" | "UNIDESH -> Pan deshidratados" | "VALLEJO" | "XOCHIMILCO"
  // planta_id -> "" | "GATSA -> Pam liquidos" | "UNIDESH -> Pan deshidratados" | "VALLEJO" | "XOCHIMILCO"
  public static function getAllColaboradores(){
    $mysqli = Database::getInstance();
    $query =<<<sql
    SELECT ua.utilerias_asistentes_id, ua.status, ra.telefono, ua.usuario, ra.numero_empleado, ra.id_ticket_virtual, ra.nombre, ra.segundo_nombre, ra.apellido_paterno, ra.apellido_materno, ra.img, ra.genero, ra.alergias, ra.alergias_otro, ra.alergia_medicamento_cual, ra.alergia_medicamento, ra.restricciones_alimenticias, ra.restricciones_alimenticias_cual, ra.id_linea_principal, ra.clave, lp.nombre as nombre_linea, bu.nombre as nombre_bu, ps.nombre as nombre_posicion, lp.id_linea_ejecutivo, le.nombre as nombre_linea_ejecutivo, le.color, al.utilerias_administradores_id_linea_asignada as id_ejecutivo_administrador, uad.nombre as nombre_ejecutivo
    FROM utilerias_asistentes ua
    INNER JOIN registros_acceso ra ON (ra.id_registro_acceso = ua.id_registro_acceso) 
    INNER JOIN bu ON (bu.id_bu = ra.id_bu) 
    INNER JOIN posiciones ps ON (ps.id_posicion = ra.id_posicion) 
    INNER JOIN linea_principal lp ON (ra.id_linea_principal = lp.id_linea_principal)
    INNER JOIN linea_ejecutivo le ON (le.id_linea_ejecutivo = lp.id_linea_ejecutivo)
    INNER JOIN asigna_linea al ON (al.id_linea_ejecutivo = le.id_linea_ejecutivo)
    INNER JOIN utilerias_administradores uad ON (uad.utilerias_administradores_id = al.utilerias_administradores_id_linea_asignada);
sql;
    return $mysqli->queryAll($query);
  }

  public static function getAllColaboradoresByName($search){
    $mysqli = Database::getInstance();
    $query =<<<sql
    SELECT ua.utilerias_asistentes_id, ua.status, ra.telefono, ua.usuario, ra.numero_empleado, ra.id_ticket_virtual, ra.nombre, ra.segundo_nombre, ra.apellido_paterno, ra.apellido_materno, ra.img, ra.genero, ra.alergias, ra.alergias_otro, ra.alergia_medicamento_cual, ra.alergia_medicamento, ra.restricciones_alimenticias, ra.restricciones_alimenticias_cual, ra.id_linea_principal, ra.clave, lp.nombre as nombre_linea, bu.nombre as nombre_bu, ps.nombre as nombre_posicion, lp.id_linea_ejecutivo, le.nombre as nombre_linea_ejecutivo, le.color, al.utilerias_administradores_id_linea_asignada as id_ejecutivo_administrador, uad.nombre as nombre_ejecutivo
    FROM utilerias_asistentes ua
    INNER JOIN registros_acceso ra ON (ra.id_registro_acceso = ua.id_registro_acceso) 
    INNER JOIN bu ON (bu.id_bu = ra.id_bu) 
    INNER JOIN posiciones ps ON (ps.id_posicion = ra.id_posicion) 
    INNER JOIN linea_principal lp ON (ra.id_linea_principal = lp.id_linea_principal)
    INNER JOIN linea_ejecutivo le ON (le.id_linea_ejecutivo = lp.id_linea_ejecutivo)
    INNER JOIN asigna_linea al ON (al.id_linea_ejecutivo = le.id_linea_ejecutivo)
    INNER JOIN utilerias_administradores uad ON (uad.utilerias_administradores_id = al.utilerias_administradores_id_linea_asignada)
    AND CONCAT_WS(ra.email,ra.nombre,ra.segundo_nombre,ra.apellido_materno,ra.apellido_paterno) LIKE '%$search%';
sql;
    return $mysqli->queryAll($query);
  }

  public static function getAsistentesFaltantes(){
    $mysqli = Database::getInstance();
    $query =<<<sql
    SELECT * FROM registros_acceso WHERE id_registro_acceso NOT IN (SELECT id_registro_acceso FROM utilerias_asistentes);
sql;

    return $mysqli->queryAll($query);
  }

  public static function getTicketByIdTicket($id){
    $mysqli = Database::getInstance();
    $query =<<<sql
    SELECT *
    FROM ticket_virtual
    WHERE id_ticket_virtual = $id
sql;
    return $mysqli->queryAll($query);
  }

  public static function searchAsistentesTicketbyId($id){
    $mysqli = Database::getInstance();
    $query =<<<sql
    SELECT ra.nombre, uasis.usuario, tv.clave
    FROM registros_acceso ra
    INNER JOIN utilerias_asistentes uasis ON (ra.id_registro_acceso = uasis.id_registro_acceso)
    LEFT JOIN ticket_virtual tv ON(ra.id_ticket_virtual = tv.id_ticket_virtual)
    WHERE uasis.utilerias_asistentes_id = $id
sql;

    return $mysqli->queryAll($query);
  }

  public static function searchItinerarioByAistenteId($id){
    $mysqli = Database::getInstance();
    $query =<<<sql
    SELECT ra.nombre, uasis.id_registro_acceso, uasis.utilerias_asistentes_id, it.utilerias_asistentes_id as id_uasis_it
    FROM registros_acceso ra
    INNER JOIN utilerias_asistentes uasis ON(ra.id_registro_acceso = uasis.id_registro_acceso)
    LEFT JOIN itinerario it ON(uasis.utilerias_asistentes_id = it.utilerias_asistentes_id)
    WHERE uasis.utilerias_asistentes_id = $id
sql;

    return $mysqli->queryAll($query);
  }



  public static function getPeriodo($data){
    $mysqli = Database::getInstance();
    if($data->_tipo_busqueda == 0){ /* CUANDO SE BUSCA UN UNICO PERIODO ABIERTO*/
      $query =<<<sql
SELECT * FROM prorrateo_periodo WHERE status = 0 AND tipo = "$data->_tipo" ORDER BY prorrateo_periodo_id ASC 
sql;
    }
    if($data->_tipo_busqueda == 1){ /* CUANDO SE BUSCA POR SEMANALES O QUINCENALES HISTORICOS */
      $query =<<<sql
SELECT * FROM prorrateo_periodo WHERE status != 0 AND tipo = "$data->_tipo" ORDER BY fecha_inicio DESC
sql;
    }
    if($data->_tipo_busqueda == 2){ /* CUANDO SE BUSCA UN UNICO PERIODO POR ID */
      $query =<<<sql
SELECT * FROM prorrateo_periodo WHERE prorrateo_periodo_id = "$data->_prorrateo_periodo_id" 
sql;
    }
    return $mysqli->queryAll($query);
  }
  public static function getStatus(){
      $mysqli = Database::getInstance();
      $query=<<<sql
      SELECT * FROM catalogo_status
sql;
        return $mysqli->queryAll($query);
    }
    public static function getAll(){
	$mysqli = Database::getInstance();
        $query=<<<sql
        SELECT * FROM catalogo_dia_festivo;
sql;
        return $mysqli->queryAll($query);
    }
    public static function getDatosUsuarioLogeado($user){
        $mysqli = Database::getInstance();
        $query=<<<sql
        SELECT * FROM utilerias_administradores WHERE usuario LIKE '$user'
sql;
        return $mysqli->queryOne($query);
    }
    public static function getDatosColaborador($idColaborador){
        $mysqli = Database::getInstance();
        $query=<<<sql
SELECT cc.catalogo_colaboradores_id, cc.clave_noi, cc.identificador_noi, cc.nombre, o.sal_diario, o.sdi
FROM catalogo_colaboradores cc 
INNER JOIN operacion_noi o ON (cc.clave_noi = o.clave) 
WHERE cc.catalogo_colaboradores_id = "$idColaborador" AND cc.identificador_noi = o.identificador 
sql;
        return $mysqli->queryOne($query);
    }
    public static function getDatosUsuario($user){
        $mysqli = Database::getInstance();
        $query=<<<sql
SELECT ua.administrador_id, ua.nombre, ua.perfil_id, ua.catalogo_planta_id, up.nombre AS nombre_perfil, cd.catalogo_departamento_id, cd.nombre, cp.nombre AS nombre_planta
FROM utilerias_administradores ua
JOIN utilerias_perfiles up USING( perfil_id )
JOIN catalogo_planta cp USING ( catalogo_planta_id )
JOIN utilerias_administradores_departamentos uad ON ( uad.id_administrador = ua.administrador_id )
JOIN catalogo_departamento cd ON ( cd.catalogo_departamento_id = uad.catalogo_departamento_id )
WHERE ua.usuario = "$user"
sql;
        return $mysqli->queryOne($query);
    }
    public static function insert($datos){
	      $mysqli = Database::getInstance(1);
        $query=<<<sql
        INSERT INTO catalogo_dia_festivo (catalogo_dia_festivo_id, nombre, descripcion, fecha, status) VALUES (NULL, :nombre, :descripcion, :fecha, '1');
sql;
    	$parametros = array(
    		':nombre'=>$datos->_nombre,
    		':descripcion'=>$datos->_descripcion,
    		':fecha'=>$datos->_fecha,
    	);
      $id = $mysqli->insert($query,$parametros);
      $accion = new \stdClass();
      $accion->_sql= $query;
      $accion->_parametros = $parametros;
      $accion->_id = $id;
      UtileriasLog::addAccion($accion);
      return $id;
    }
    public static function update($datos){
        $mysqli = Database::getInstance(true);
      $query=<<<sql
UPDATE catalogo_dia_festivo SET nombre = '122', descripcion = '1233', fecha = '2017-08-24', status = 2 WHERE catalogo_dia_festivo.catalogo_dia_festivo_id = :catalogo_dia_festivo_id;
sql;
      $parametros = array(
          ':catalogo_dia_festivo_id'=>$lectores->_catalogo_dia_festivo_id,
          ':nombre'=>$lectores->_nombre,
          ':descripcion'=>$lectores->_descripcion,
          ':fecha'=>$lectores->_fecha,
          ':status'=>$lectores->_status
        );
        $accion = new \stdClass();
        $accion->_sql= $query;
        $accion->_parametros = $parametros;
        $accion->_id = $lectores->_catalogo_dia_festivo_id;
        UtileriasLog::addAccion($accion);
        return $mysqli->update($query, $parametros);
    }
    public static function delete($id){
	$mysqli = Database::getInstance();
        $query=<<<sql
        DELETE FROM `catalogo_dia_festivo` WHERE `catalogo_dia_festivo`.`catalogo_dia_festivo_id` = $id
sql;
        $parametros = array(':id'=>$id);
        $accion = new \stdClass();
        $accion->_sql= $query;
        $accion->_parametros = $parametros;
        $accion->_id = $id;
        UtileriasLog::addAccion($accion);
        return $mysqli->update($query, $parametros);
    }
    public static function deleteById($id){
        $mysqli = Database::getInstance();
        $query=<<<sql
DELETE FROM catalogo_dia_festivo WHERE catalogo_dia_festivo.catalogo_dia_festivo_id = $id
sql;
      $accion = new \stdClass();
      $accion->_sql= $query;
      $accion->_parametros = $parametros;
      $accion->_id = $id;
      UtileriasLog::addAccion($accion);
        return $mysqli->queryOne($query);
    }
    public static function getById($id){
        $mysqli = Database::getInstance();
        $query=<<<sql
SELECT *  FROM catalogo_dia_festivo WHERE catalogo_dia_festivo_id = $id
sql;
      return $mysqli->queryOne($query);
    }
    public static function getPermisos($usuario){
      $mysqli = Database::getInstance();
      $query=<<<sql
      SELECT * FROM utilerias_permisos WHERE usuario LIKE '$usuario'   
sql;
      return $mysqli->queryAll($query);
    }
    public static function getUsuario($usuario){
      $mysqli = Database::getInstance();
      $query=<<<sql
      SELECT * FROM utilerias_permisos WHERE usuario LIKE '$usuario'   
sql;
      return $mysqli->queryOne($query);
    }
    /*
        Buscar los colaboradores 
        @tipo: SEMANAL o QUINCENAL
    */
    public static function getColaboradores($tipo, $perfilUsuario, $catalogoDepartamentoId, $catalogoPlantaId, $status, $identificadorNOI, $filtro){
      //echo "<pre>";print_r($status);echo "</pre>";
        $mysqli = Database::getInstance();
        if($perfilUsuario == 1 || $perfilUsuario == 4 || $perfilUsuario == 2){
            $query=<<<sql
SELECT 
cc.catalogo_colaboradores_id, cc.identificador_noi, cc.nombre, cc.apellido_paterno, cc.apellido_materno, cc.numero_identificador, cc.catalogo_departamento_id,
cc.pago, cc.foto, cd.nombre AS nombre_departamento, cp.nombre AS nombre_puesto, cu.nombre nombre_ubicacion, cc.catalogo_ubicacion_id, ce.nombre AS nombre_empresa, cc.numero_empleado
FROM catalogo_colaboradores cc 
INNER JOIN catalogo_departamento cd USING (catalogo_departamento_id)
INNER JOIN catalogo_puesto cp USING (catalogo_puesto_id)
INNER JOIN catalogo_ubicacion cu USING (catalogo_ubicacion_id) 
INNER JOIN catalogo_empresa ce USING (catalogo_empresa_id) 
sql;
            if($status == 1){
                $query.=<<<sql
WHERE cc.pago = "$tipo" AND cc.status = 1 AND cc.catalogo_ubicacion_id = "$catalogoPlantaId"
sql;
            }
            if($status == 2){
                $query.=<<<sql
WHERE cc.pago = "$tipo" AND cc.status = 1 AND cc.catalogo_ubicacion_id = "$catalogoPlantaId" AND cc.catalogo_departamento_id = "$catalogoDepartamentoId"
sql;
            }
            if($status == 3){
                $query.=<<<sql
WHERE cc.pago = "$tipo" AND cc.status = 1 AND cc.catalogo_ubicacion_id = "$catalogoPlantaId"
sql;
            }
            if($status == 4){
                $query.=<<<sql
WHERE cc.pago = "$tipo" AND cc.status = 1 AND cc.catalogo_departamento_id = "$catalogoDepartamentoId"
sql;
            }
            if($status == 5){ // TODAS LAS PLANTAS
                $query.=<<<sql
WHERE cc.status = 1 
sql;
            }
            if($status == 6){ // TODAS LAS PLANTAS
                $query.=<<<sql
WHERE cc.pago  = "$tipo" AND cc.status = 1 
sql;
            }
            if($status == 10){
                $query.=<<<sql
WHERE cc.pago = "$tipo" AND cc.status = 1 AND cc.identificador_noi = "$identificadorNOI"
sql;
            }
        }
        // PERFIL PARA 4 "Administrador" y 5 "Personalizado"
        if($perfilUsuario == 5){
            $query =<<<sql
SELECT 
cc.catalogo_colaboradores_id, cc.identificador_noi, cc.nombre, cc.apellido_paterno, cc.apellido_materno, cc.numero_identificador, cc.catalogo_departamento_id,
cc.pago, cc.foto, cd.nombre AS nombre_departamento, cp.nombre AS nombre_puesto, cu.nombre nombre_ubicacion, cc.catalogo_ubicacion_id, ce.nombre AS nombre_empresa, cc.numero_empleado
FROM catalogo_colaboradores cc 
INNER JOIN catalogo_departamento cd USING (catalogo_departamento_id)
INNER JOIN catalogo_puesto cp USING (catalogo_puesto_id)
INNER JOIN catalogo_ubicacion cu USING (catalogo_ubicacion_id)
INNER JOIN catalogo_empresa ce USING (catalogo_empresa_id)
WHERE cc.pago = "$tipo" AND cc.status = 1 AND cc.catalogo_departamento_id = "$catalogoDepartamentoId"
sql;
        }
        if($perfilUsuario == 6){
            $query=<<<sql
SELECT 
cc.catalogo_colaboradores_id, cc.identificador_noi, cc.nombre, cc.apellido_paterno, cc.apellido_materno, cc.numero_identificador, cc.catalogo_departamento_id,
cc.pago, cc.foto, cd.nombre AS nombre_departamento, cp.nombre AS nombre_puesto, cu.nombre nombre_ubicacion, cc.catalogo_ubicacion_id, ce.nombre AS nombre_empresa, cc.numero_empleado
FROM catalogo_colaboradores cc 
INNER JOIN catalogo_departamento cd USING (catalogo_departamento_id)
INNER JOIN catalogo_puesto cp USING (catalogo_puesto_id)
INNER JOIN catalogo_ubicacion cu USING (catalogo_ubicacion_id) 
INNER JOIN catalogo_empresa ce USING (catalogo_empresa_id)
sql;
            if($status == 1){ // ES DE RH XOCHIMILCO Y PUEDE VER TODO
                $query.=<<<sql
                WHERE cc.pago = "$tipo" AND cc.status = 1 
sql;
            }
            if($status == 2){ // ES DE RECUSOS HUMANOS Y PUEDE VER TODOS LOS DEPARTAMENTOS DE SU PLANTA EXCEPTO RH XOCHIMILCO
                $query.=<<<sql
                WHERE cc.pago = "$tipo" AND cc.status = 1 AND cc.catalogo_departamento_id = "$catalogoDepartamentoId" 
sql;
            }
             //WHERE cc.pago = "$tipo" AND cc.status = 1 AND cc.catalogo_ubicacion_id = "$catalogoPlantaId" AND cc.catalogo_departamento_id = "$catalogoDepartamentoId"
            if($status == 3){ // ES DE RH y tiene incentivos propios 
                $query.=<<<sql
                WHERE cc.pago = "$tipo" AND cc.status = 1 AND cc.identificador_noi = "$identificadorNOI" 
sql;
            }
            if($status == 4){ // ES DE RH y tiene incentivos propios 
                $query.=<<<sql
                WHERE cc.pago = "$tipo" AND cc.status = 1 AND cc.catalogo_ubicacion_id = "$catalogoPlantaId" AND cc.catalogo_departamento_id = "$catalogoDepartamentoId" 
sql;
            }
            if($status == 5){ // ES DE RH y tiene incentivos propios 
                $query.=<<<sql
                WHERE cc.pago = "$tipo" AND cc.status = 1 AND cc.catalogo_ubicacion_id = "$catalogoPlantaId"
sql;
            }
        }
        $nuevoFiltro = "";
        foreach ($filtro as $key => $value) {
          if(!empty($value)){
            if($value == 'vacio' && $key == 'c.identificador_noi') $nuevoFiltro .= " AND " . $key . " = " . "''" . " ";
            else $nuevoFiltro .= " AND " . $key . " = " . " '$value' " . " ";
          }
        }
        $query.= $nuevoFiltro;
        //echo $query;
        return $mysqli->queryAll($query);
    }
    public static function getLastPeriodo($tipo){
      $mysqli = Database::getInstance();
      $query=<<<sql
      SELECT * FROM `prorrateo_periodo` WHERE tipo = "$tipo" ORDER BY `prorrateo_periodo`.`fecha_inicio` DESC 
sql;
      return $mysqli->queryOne($query);
    }
    public static function getSalarioMinimo(){
      $mysqli = Database::getInstance();
      $query=<<<sql
SELECT * FROM `salario_minimo` ORDER BY `salario_minimo`.`id_salario` DESC LIMIT 1 
sql;
      return $mysqli->queryOne($query);
    }
    public static function insertSalarioMinimo($cantidad){
      $mysqli = Database::getInstance();
      $query=<<<sql
INSERT INTO salario_minimo (id_salario, cantidad) VALUES (NULL, '$cantidad');
sql;
      return $mysqli->insert($query);
    }
}