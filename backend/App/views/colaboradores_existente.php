<?php echo $header;?>
<div class="right_col">
  <div class="col-md-12 col-sm-12 col-xs-12 col-lg-12">
    <div class="x_panel tile fixed_height_240">
      <div class="x_title">
        <br><br>
        <h1>Agregando un nuevo Colaborador</h1>
        <div class="clearfix"></div>
      </div>
      <div class="x_content">
        <form class="form-horizontal" id="form-existente" action="" method="POST">
          <div class="form-group ">

            <div class="form-group">
              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="nombre">Colaborador Existente <span class="required">*</span></label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <input name="existente" id="existente" type="checkbox" name="my-checkbox" checked>
              </div>
            </div>

            <div class="form-group" id="identificador">
              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="identificador">Identificador<span class="required">*</span></label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <select class="form-control" name="identificador" id="identificador">
                <option value="" hidden>Selecciona un identificador</option>
                  <?php echo $sIdentificador; ?>
                </select>
              </div>
            </div>

            <div class="panel-body" id="tabla_muestra">
              <div class="dataTable_wrapper">
                <table class="table table-striped table-bordered table-hover" id="muestra-cupones">
                  <thead>
                    <tr>
                      <th ></th>
                      <th>Nombre</th>
                      <th>Apellido Paterno</th>
                      <th>Apellido Materno</th>
                      <th>RFC</th>
                      <th>Fecha Alta</th>
                    </tr>
                  </thead>
                  <tbody id="registros">
                    <?= $sColaboradorExistente; ?>
                  </tbody>
                </table>
              </div>
            </div>

            <div class="form-group">
              <div class="col-md-9 col-sm-9 col-xs-12 col-md-offset-2 col-xs-offset-3">
                <a class="btn btn-danger col-md-3 col-sm-3 col-xs-5" type="button" id="btnCancel" href="/Colaboradores/">Cancelar</a>
                <button class="btn btn-success col-md-3 col-sm-3 col-xs-5" id="btnAceptar" type="submit">Aceptar</button>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<?php echo $footer;?>
