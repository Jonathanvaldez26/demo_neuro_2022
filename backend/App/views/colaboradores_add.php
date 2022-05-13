<?php echo $header;?>
<div class="right_col">
  <div class="col-md-12 col-sm-12 col-xs-12 col-lg-12">
    <div class="x_panel tile fixed_height_240">
      <div class="x_title">
        <br><br>
        <h1>Agregar nuevo Colaborador</h1>
        <div class="clearfix"></div>
      </div>
      <div class="x_content">
        <form class="form-horizontal" id="add" action="/Colaboradores/colaboradorAdd" method="POST" enctype="multipart/form-data">
          <div class="form-group ">

            <div class="form-group">
              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="nombre">Nombre <span class="required">*</span></label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <input type="text" name="nombre" id="nombre" class="form-control col-md-6 col-xs-12" placeholder="Ingresa el nombre" value="<?php echo utf8_encode($colaborador_existente['nombre'])?>" <?php echo $hidden;?>>
              </div>
            </div>

            <div class="form-group">
              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="apellido_paterno">Apellido Paterno <span class="required">*</span></label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <input type="text" name="apellido_paterno" id="apellido_paterno" class="form-control col-md-7 col-xs-12" placeholder="Ingresa el apellido paterno" value="<?php echo utf8_encode($colaborador_existente['ap_pat'])?>" <?php echo $hidden;?>>
              </div>
            </div>

            <div class="form-group">
              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="apellido_materno">Apellido Materno <span class="required">*</span></label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <input type="text" name="apellido_materno" id="apellido_materno" class="form-control col-md-7 col-xs-12" placeholder="Ingresa el apellido materno" value="<?php echo utf8_encode($colaborador_existente['ap_mat'])?>" <?php echo $hidden;?>>
              </div>
            </div>

            <?php if($colaborador_existente['identificador']!=''){ ?>
            <div class="form-group">
              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="identificador">Identificador<span class="required">*</span></label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <input type="text" name="identificador" id="identificador" class="form-control col-md-7 col-xs-12" placeholder="Ingresa el identificador" value="<?= $colaborador_existente['identificador']?>" <?php echo $hidden;?>>
              </div>
            </div>
            <?php } ?>

            <div class="form-group">
              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="pago">Motivo Baja: <span class="required">*</span></label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <select class="form-control" name="motivo" id="motivo">
                  <option value="">Selecciona un motivo</option>
                  <?php echo $idMotivo; ?>
                </select>
              </div>
            </div>

            <div class="form-group">
              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="sexo">Sexo <span class="required">*</span></label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <div id="gender" data-toggle="buttons">
                  <label class="btn btn-default <?php echo ($colaborador_existente['sexo']=='M')? 'active':''; ?>" data-toggle-class="btn" style="color: #41b0d9;" data-toggle-passive-class="btn-default">
                    <input type="radio" name="genero" value="masculino" <?php echo ($colaborador_existente['sexo']=='M')? 'checked':''; ?>> &nbsp; Masculino &nbsp;
                  </label>
                  <label class="btn btn-default <?php echo ($colaborador_existente['sexo']=='F')? 'active':''; ?>" data-toggle-class="btn" style="color: #d749a7;" data-toggle-passive-class="btn-default">
                    <input type="radio" name="genero" value="femenino" <?php echo ($colaborador_existente['sexo']=='F')? 'checked':''; ?> >  &nbsp;  &nbsp; Femenino  &nbsp;  &nbsp;
                  </label>
                </div>
              </div>
            </div>

            <div class="form-group">
              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="numero_identificacion">Número de Identificación <span class="required">*</span></label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <input type="text" name="numero_identificacion" id="numero_identificacion" class="form-control col-md-7 col-xs-12" placeholder="Ingresa el número de Identificación">
              </div>
            </div>

            <div class="form-group">
              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="rfc">RFC <span class="required">*</span></label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <input type="text" name="rfc" id="rfc" class="form-control col-md-7 col-xs-12" placeholder="Ingresa RFC" value="<?= $colaborador_existente['rfc']?>" <?php echo $hidden;?>>
              </div>
            </div>

            <div class="form-group">
              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="id_catalogo_empresa">Catálogo Empresa<span class="required">*</span></label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <select class="form-control" name="id_catalogo_empresa" id="id_catalogo_empresa">
                  <option value="" hidden >Selecciona una empresa del Catálogo de Empresas</option>
                  <?php echo $idEmpresa; ?>
                </select>
              </div>
            </div>

            <div class="form-group">
              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="catalogo_lector_id">Catálogo Lector Primario<span class="required">*</span></label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <select class="form-control" name="id_catalogo_lector" id="id_catalogo_lector">
                  <option value="" hidden >Selecciona un lectos del Catálogo del Lectores</option>
                  <?php echo $idLector; ?>
                </select>
              </div>
            </div>

 	    <div class="form-group">
              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="catalogo_lector_secundario_id">Catálogo Lector Secundario</label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <select class="form-control" name="id_catalogo_lector_secundario" id="id_catalogo_lector_secundario">
                  <option value="0">Catálogo del Lector Secundario Nulo o Vacio</option>
                  <?php echo $idLectorSecundario; ?>
                </select>
              </div>
            </div>

            <div class="form-group">
              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="id_catalogo_ubicacion">Catálogo Ubicación<span class="required">*</span></label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <select class="form-control" name="id_catalogo_ubicacion" id="id_catalogo_ubicacion">
                  <option value="" >Selecciona una ubicación del Catálogo de Ubicaciones</option>
                  <?php echo $idUbicacion; ?>
                </select>
              </div>
            </div>

            <div class="form-group">
              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="id_catalogo_departamento">Catálogo Departamento<span class="required">*</span></label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <select class="form-control" name="id_catalogo_departamento" id="id_catalogo_departamento">
                  <option value="" hidden >Selecciona un departamento del Catálogo de Departamento</option>
                  <?php echo $idDepartamento; ?>
                </select>
              </div>
            </div>

            <div class="form-group">
              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="id_catalogo_puesto">Catálogo Puesto<span class="required">*</span></label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <select class="form-control" name="id_catalogo_puesto" id="id_catalogo_puesto">
                  <option value="" hidden >Selecciona un puesto del Catálogo de Puesto</option>
                  <?php echo $idPuesto; ?>
                </select>
              </div>
            </div>

            <div class="form-group">
              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="id_catalogo_puesto">Tipo de Intercalado<span class="required">*</span></label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <select class="form-control" name="tipo_horario" id="tipo_horario">
                  <option value="" >Selecciona un tipo de horario</option>
                  <option value="diario">Diario</option>
                  <option value="semanal">Semanal</option>
                </select>
              </div>
            </div>

            <div class="form-group">
              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="horario">Horario por default<span class="required">*</span></label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <select class="form-control" name="horario[]" id="horario_1">
                  <option value="-1">Selecciona un Horario</option>
                  <?php echo $horario; ?>
                </select>
              </div>
            </div>

            <div class="form-group">
              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="horario">Horario 2<span class="required">*</span></label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <select class="form-control" name="horario[]" id="horario_2">
                  <option value="">Selecciona un Horario</option>
                  <?php echo $horario; ?>
                </select>
              </div>
            </div>

            <div class="form-group">
              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="horario">Horario 3<span class="required">*</span></label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <select class="form-control" name="horario[]" id="horario_3">
                  <option value="">Selecciona un Horario</option>
                  <?php echo $horario; ?>
                </select>
              </div>
            </div>

            <div class="form-group">
              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="horario">Horario 4<span class="required">*</span></label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <select class="form-control" name="horario[]" id="horario_4">
                  <option value="">Selecciona un Horario</option>
                  <?php echo $horario; ?>
                </select>
              </div>
            </div>

            <div class="form-group">
              <fieldset>
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="descripcion">Fecha Alta<span class="required">*</span></label>
                <div class="control-group">
                  <div class="controls">
                    <div class="col-md-6 col-sm-6 col-xs-12 xdisplay_inputx form-group has-feedback">
                      <div class="form-control-wrapper">
                        <input type="text" id="date-new1" name="fecha_alta" class="form-control has-feedback-left" placeholder="Fecha Alta" value="<?= $colaborador_existente['fecha_alta']?>" <?php echo $hidden;?>>
                        <span class="fa fa-calendar-o form-control-feedback left" aria-hidden="true"></span>
                        <span id="inputSuccess2Status2" class="sr-only">(success)</span>
                      </div>
                    </div>
                  </div>
                </div>
              </fieldset>
            </div>

            <div class="form-group">
              <fieldset>
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="descripcion">Fecha Baja<span class="required">*</span></label>
                <div class="control-group">
                  <div class="controls">
                    <div class="col-md-6 col-sm-6 col-xs-12 xdisplay_inputx form-group has-feedback">
                      <div class="form-control-wrapper">
                        <input type="text" id="date-new2" name="fecha_baja" class="form-control has-feedback-left" placeholder="Fecha baja" >
                        <span class="fa fa-calendar-o form-control-feedback left" aria-hidden="true"></span>
                        <span id="inputSuccess2Status2" class="sr-only">(success)</span>
                      </div>
                    </div>
                  </div>
                </div>
              </fieldset>
            </div>

            <!--div class="form-group">
              <fieldset>
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="descripcion">Fecha Alta<span class="required">*</span></label>
                <div class="control-group">
                  <div class="controls">
                    <div class="col-md-6 col-sm-6 col-xs-12 xdisplay_inputx form-group has-feedback">
                      <input type="text" id="fecha_alta" name="fecha_alta1" class="form-control has-feedback-left" placeholder="Fecha Alta" aria-describedby="inputSuccess2Status2" value="<?= $colaborador_existente['fecha_alta']?>" <?php echo $hidden;?>>
                      <span class="fa fa-calendar-o form-control-feedback left" aria-hidden="true"></span>
                      <span id="inputSuccess2Status2" class="sr-only">(success)</span>
                    </div>
                  </div>
                </div>
              </fieldset>
            </div-->

            <!--div class="form-group">
              <fieldset>
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="descripcion">Fecha Baja<span class="required">*</span></label>
                <div class="control-group">
                  <div class="controls">
                    <div class="col-md-6 col-sm-6 col-xs-12 xdisplay_inputx form-group has-feedback">
                      <input type="text" id="fecha_baja" name="fecha_baja" class="form-control has-feedback-left" placeholder="Fecha Baja" aria-describedby="inputSuccess2Status2">
                      <span class="fa fa-calendar-o form-control-feedback left" aria-hidden="true"></span>
                      <span id="inputSuccess2Status2" class="sr-only">(success)</span>
                    </div>
                  </div>
                </div>
              </fieldset>
            </div-->

            <div class="form-group">
              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="foto">Foto <span class="required">*</span></label>

              <div class="col-md-9 col-sm-9 col-xs-9">
                <div class="col-md-8 col-sm-8 col-xs-8">
                  <input type="file" name="foto" id="foto" class="btn form-control" value="<?php echo $colaborador['foto']; ?>">
                </div>

                <div class="col-md-12 col-sm-12 col-xs-12">
                  <img id="vista_previa" class="form-control foto" src="/img/user.png" alt="Foto de Perfil">
                </div>
              </div>
            </div>

            <div class="form-group">
              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="pago">Pago <span class="required">*</span></label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <select class="form-control" name="pago" id="pago">
                  <?php echo $sPago; ?>
                </select>
              </div>
            </div>

	         <br />
            <div class="form-group">
              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="opcion">&nbsp;</label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <p>Para eliminar incentivos puedes darle click en la "X" o quitar la opcion del checkbox</p>
              </div>
            </div>

            <div class="form-group">
              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="incentivos">Incentivos<span class="required">*</span></label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <div class="col-md-9 col-sm-9 col-xs-9">
                  <select class="form-control" name="incentivos" id="incentivos">
                    <option value="" hidden>Selecciona un Incentivo</option>
                    <?php echo $idIncentivo; ?>
                  </select>
                </div>
                <div class="col-md-3 col-sm-3 col-xs-3">
                  <input type="button" class="btn btn-success" id="btnIncentivoAdd" value="Agregar">
                </div>
              </div>
            </div>

            <div class="form-group">
              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="incentivo">Incentivos Asignados</label>
              <div class="col-md-6 col-sm-6 col-xs-12" id="incentivos_asignados">
              </div>
            </div>

            <div class="form-group">
              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="opcion">Opción <span class="required">*</span></label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <input type="text" name="opcion" id="opcion" class="form-control" placeholder="Ingresa la opcion">
              </div>
            </div>

	           <div class="form-group">
              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="privilegiado">Privilegiado</label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <select class="form-control" name="privilegiado" id="privilegiado">
		              <option value="0" selected="selected">No</option>
		              <option value="1">Si</option>
                </select>
              </div>
            </div>

            <div class="form-group">
              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="status">Status<span class="required">*</span></label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <select class="form-control" name="status" id="status">
                <option value="" hidden >Selecciona un estatus</option>
                  <?php echo $sStatus; ?>
                </select>
              </div>
            </div>

            <input type="hidden" name="letra_ubicacion" id="letra_ubicacion">
            <input type="hidden" name="clave_noi" id="clave_noi" value="<?php echo $colaborador_existente['clave']?>">

            <div class="form-group">
              <div class="col-md-9 col-sm-9 col-xs-12 col-md-offset-2 col-xs-offset-3">
                <button class="btn btn-danger col-md-3 col-sm-3 col-xs-5" type="button" id="btnCancel">Cancelar</button>
                <button class="btn btn-primary col-md-3 col-sm-3 col-xs-5" type="reset" >Resetear</button>
                <button class="btn btn-success col-md-3 col-sm-3 col-xs-5" id="btnAdd" type="submit">Agregar</button>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<?php echo $footer;?>
