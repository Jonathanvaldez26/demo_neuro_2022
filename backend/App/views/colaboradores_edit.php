<?php echo $header;?>
<div class="right_col">
  <div class="col-md-12 col-sm-12 col-xs-12 col-lg-12">
    <div class="x_panel tile fixed_height_240">
      <div class="x_title">
        <br><br>
        <h1>Editar Colaborador</h1>
        <div class="clearfix"></div>
      </div>
      <div class="x_content">
        <form class="form-horizontal" id="edit" action="/Colaboradores/colaboradorEdit" method="POST" enctype="multipart/form-data">
          <div class="form-group ">

            <div class="form-group">
              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="nombre">Nombre <span class="required">*</span></label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <input type="text" name="nombre" id="nombre" class="form-control col-md-6 col-xs-12" placeholder="Ingresa el nombre" value="<?php echo utf8_encode($colaborador['nombre']); ?>" <?php echo $hidden; ?> />
              </div>
            </div>

            <div class="form-group">
              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="apellido_paterno">Apellido Paterno <span class="required">*</span></label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <input <?php echo $hidden; ?> type="text" name="apellido_paterno" id="apellido_paterno" class="form-control col-md-7 col-xs-12" placeholder="Ingresa el apellido parterno" value="<?php echo utf8_encode($colaborador['apellido_paterno']); ?>">
              </div>
            </div>

            <div class="form-group">
              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="apellido_materno">Apellido Materno <span class="required">*</span></label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <input <?php echo $hidden; ?> type="text" name="apellido_materno" id="apellido_materno" class="form-control col-md-7 col-xs-12" placeholder="Ingresa el apellido materno" value="<?php echo utf8_encode($colaborador['apellido_materno']); ?>">
              </div>
            </div>

            <?php if($colaborador['identificador_noi']!=''){ ?>
            <div class="form-group">
              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="identificador">Identificador<span class="required">*</span></label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <input type="text" name="identificador" id="identificador" class="form-control col-md-7 col-xs-12" placeholder="Ingresa el identificador" value="<?= $colaborador['identificador_noi']?>" readonly>
              </div>
            </div>
            <?php } ?>

            <div class="form-group">
              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="pago">Motivo Baja: <span class="required">*</span></label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <select class="form-control" name="motivo" id="motivo">
                  <option value="">Selecciona un motivo de baja</option>
                  <?php echo $idMotivo; ?>
                </select>
              </div>
            </div>

            <div class="form-group">
              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="sexo">Sexo <span class="">*</span></label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <div id="gender" data-toggle="buttons">
                  <label class="btn btn-default <?php echo ($colaborador['sexo']=='masculino')? 'active' : ''; ?>" data-toggle-class="btn" style="color: #41b0d9;" data-toggle-passive-class="btn-default">
                    <input <?php echo $hidden; ?> type="radio" name="genero" value="masculino" <?php echo ($colaborador['sexo']=='masculino')? 'checked' : ''; ?> > &nbsp; Masculino &nbsp;
                  </label>
                  <label class="btn btn-default <?php echo ($colaborador['sexo']=='femenino')? 'active' : ''; ?>" data-toggle-class="btn" style="color: #d749a7;" data-toggle-passive-class="btn-default">
                    <input <?php echo $hidden; ?> type="radio" name="genero" value="femenino" <?php echo ($colaborador['sexo']=='femenino')? 'checked' : ''; ?> >  &nbsp;  &nbsp; Femenino  &nbsp;  &nbsp;
                  </label>
                </div>
              </div>

            </div>

            <div class="form-group">
              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="numero_identificacion">Número de Identificación <span class="required">*</span></label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <input type="text" name="numero_identificacion" id="numero_identificacion" class="form-control col-md-7 col-xs-12" placeholder="Ingresa el número de Identificación" value="<?php echo $colaborador['numero_identificador']; ?>">
              </div>
            </div>

            <div class="form-group">
              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="rfc">RFC <span class="required">*</span></label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <input <?php echo $hidden; ?> type="text" name="rfc" id="rfc" class="form-control col-md-7 col-xs-12" placeholder="Ingresa RFC" value="<?php echo $colaborador['rfc']; ?>">
              </div>
            </div>

            <div class="form-group">
              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="id_catalogo_empresa">ID Catálogo Empresa<span class="required">*</span></label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <select class="form-control" name="id_catalogo_empresa" id="id_catalogo_empresa">
                  <?php echo $idEmpresa; ?>
                </select>
              </div>
            </div>

            <div class="form-group">
              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="catalogo_lector_id">ID Catálogo Lector Primario<span class="required">*</span></label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <select class="form-control" name="catalogo_lector_id" id="catalogo_lector_id">
                  <?php echo $idLector; ?>
                </select>
              </div>
            </div>

	    <div class="form-group">
              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="catalogo_lector_id">ID Catálogo Lector Secundario</label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <select class="form-control" name="catalogo_lector_secundario_id" id="catalogo_lector_secundario_id">
                  <?php echo $idLectorSecundario; ?>
                </select>
              </div>
            </div>

            <div class="form-group">
              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="id_catalogo_ubicacion">ID Catálogo Ubicación<span class="required">*</span></label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <select class="form-control" name="id_catalogo_ubicacion" id="id_catalogo_ubicacion">
                  <?php echo $idUbicacion; ?>
                </select>
              </div>
            </div>

            <div class="form-group">
              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="id_catalogo_departamento">ID Catálogo Departamento<span class="required">*</span></label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <select class="form-control" name="id_catalogo_departamento" id="id_catalogo_departamento">
                  <?php echo $idDepartamento; ?>
                </select>
              </div>
            </div>

            <div class="form-group">
              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="id_catalogo_puesto">ID Catálogo Puesto<span class="required">*</span></label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <select class="form-control" name="id_catalogo_puesto" id="id_catalogo_puesto">
                  <?php echo $idPuesto; ?>
                </select>
              </div>
            </div>

            <div class="form-group">
              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="id_catalogo_puesto">Tipo de Intercalado<span class="required">*</span></label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <select class="form-control" name="tipo_horario" id="tipo_horario">
                  <option value="">Selecciona un tipo de horario</option>
                  <?php echo $sTipoHorario; ?>
                </select>
              </div>
            </div>

            <div class="form-group">
              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="horario">Horario Default<span class="required">*</span></label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <select class="form-control" name="horario[]" id="horario_1">
                  <option value="-1">Selecciona un Horario</option>
                  <?php echo $horarios_asignados[0].$horario; ?>
                </select>
              </div>
            </div>

            <div class="form-group">
              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="horario">Horario 2<span class="required">*</span></label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <select class="form-control" name="horario[]" id="horario_2">
                  <option value="">Selecciona un Horario</option>
                  <?php echo $horarios_asignados[1].$horario; ?>
                </select>
              </div>
            </div>

            <div class="form-group">
              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="horario">Horario 3<span class="required">*</span></label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <select class="form-control" name="horario[]" id="horario_3">
                  <option value="">Selecciona un Horario</option>
                  <?php echo $horarios_asignados[2].$horario; ?>
                </select>
              </div>
            </div>

            <div class="form-group">
              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="horario">Horario 4<span class="required">*</span></label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <select class="form-control" name="horario[]" id="horario_4">
                  <option value="">Selecciona un Horario</option>
                  <?php echo $horarios_asignados[3].$horario; ?>
                </select>
              </div>
            </div>
<!--
            <div class="form-group">
              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="horario">Horarios Asignados<span class="required">*</span></label>
              <div class="col-md-6 col-sm-6 col-xs-12" id="horarios_asignados">
                <?php echo $horarios_asignados; ?>
              </div>
            </div>
-->
            <!--div class="form-group">
              <fieldset>
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="descripcion">Fecha Alta<span class="required">*</span></label>
                <div class="control-group">
                  <div class="controls">
                    <div class="col-md-6 col-sm-6 col-xs-12 xdisplay_inputx form-group has-feedback">
                      <input <?php echo $hidden; ?> type="text" id="fecha_alta" name="fecha_alta" class="form-control has-feedback-left" placeholder="Fecha Alta" aria-describedby="inputSuccess2Status2" value="<?php echo $colaborador['fecha_alta']; ?>">
                      <span class="fa fa-calendar-o form-control-feedback left" aria-hidden="true"></span>
                      <span id="inputSuccess2Status2" class="sr-only">(success)</span>
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
                      <input type="text" id="fecha_baja" name="fecha_baja" class="form-control has-feedback-left" placeholder="Fecha Baja" aria-describedby="inputSuccess2Status2" value="<?php echo $colaborador['fecha_baja']; ?>">
                      <span class="fa fa-calendar-o form-control-feedback left" aria-hidden="true"></span>
                      <span id="inputSuccess2Status2" class="sr-only">(success)</span>
                    </div>
                  </div>
                </div>
              </fieldset>
            </div-->

            <div class="form-group">
              <fieldset>
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="descripcion">Fecha Alta<span class="required">*</span></label>
                <div class="control-group">
                  <div class="controls">
                    <div class="col-md-6 col-sm-6 col-xs-12 xdisplay_inputx form-group has-feedback">
                      <div class="form-control-wrapper">
                        <input type="text" id="date-new1" name="fecha_alta" class="form-control has-feedback-left" placeholder="Fecha Alta" value="<?php echo $colaborador['fecha_alta']; ?>">
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

            <div class="form-group">
              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="foto">Foto <span class="required">*</span></label>

              <div class="col-md-9 col-sm-9 col-xs-9">
                <div class="col-md-8 col-sm-8 col-xs-8">
                  <input type="file" name="foto" id="foto" class="btn form-control" value="<?php echo $colaborador['foto']; ?>">
                </div>

                <div class="col-md-12 col-sm-12 col-xs-12">
                  <img id="vista_previa" class="form-control foto" src="/img/colaboradores/<?=$colaborador['foto']?>" alt="Foto de Perfil">
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
              <?php echo $idIncentivos_asignados; ?>
              </div>
            </div>

            <div class="form-group">
              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="opcion">Opción <span class="required">*</span></label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <input type="text" name="opcion" id="opcion" class="form-control" placeholder="Ingresa la opcion" value="<?php echo $colaborador['opcion']; ?>">
              </div>
            </div>

            <div class="form-group">
              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="numero_empleado">Número Empleado <span class="required">*</span></label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <input <?php echo $hidden; ?> type="text" name="numero_empleado" id="numero_empleado" class="form-control" placeholder="Ingresa la empleado" value="<?php echo $colaborador['numero_empleado']; ?>" readonly>
              </div>
            </div>


	    <div class="form-group">
              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="privilegiado">Privilegiado</label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <select class="form-control" name="privilegiado" id="privilegiado">
		    <?php echo $idPrivilegiado; ?>
                </select>
              </div>
            </div>


            <div class="form-group">
              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="status">Status<span class="required">*</span></label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <select class="form-control" name="status" id="status">
                  <?php echo $sStatus; ?>
                </select>
              </div>
            </div>

            <input <?php echo $hidden; ?> type="hidden" name="catalogo_colaboradores_id" id="catalogo_colaboradores_id" value="<?php echo $colaborador['catalogo_colaboradores_id']; ?>">
            <input <?php echo $hidden; ?> type="hidden" name="clave_noi" id="clave_noi" value="<?php echo $colaborador['clave_noi']?>">

            <div class="form-group">
              <div class="col-md-9 col-sm-9 col-xs-12 col-md-offset-2 col-xs-offset-3">
                <button class="btn btn-danger col-md-3 col-sm-3 col-xs-5" type="button" id="btnCancel">Cancelar</button>
                <button class="btn btn-success col-md-3 col-sm-3 col-xs-5" id="btnAdd" type="submit">Actualizar</button>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<?php echo $footer;?>
