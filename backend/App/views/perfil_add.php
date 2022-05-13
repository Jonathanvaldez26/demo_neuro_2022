<?php echo $header;?>
<div class="right_col">
  <div class="col-md-12 col-sm-12 col-xs-12 col-lg-12">
    <div class="x_panel tile fixed_height_240">
      <div class="x_title">
        <br><br>
        <h1>Agregar un nuevo Perfil </h1>
        <div class="clearfix"></div>
      </div>
      <div class="x_content">
        <form class="form-horizontal" id="add" action="/Perfiles/perfilAdd" method="POST">
          <div class="form-group ">

            <div class="form-group">
              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="nombre">Nombre <span class="required">*</span></label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <input type="text" name="nombre" id="nombre" class="form-control col-md-7 col-xs-12" placeholder="Nombre del perfil">
              </div>
               <span id="availability"></span>
            </div>

            <!--div class="form-group">
              <label class="col-md-3 col-sm-3 col-xs-12 control-label">Secciones a visualizar
                <br>
                <small class="text-navy">Selecciona dentro de la <br> tabla que secciones deseas <br> que este perfil quieres <br> que visualice. <br> También asigna si deseas <br> que pueda realizar: 
                <ul>
                  <li>Agregar</li>
                  <li>Editar</li>
                  <li>Eliminar</li>
                </ul>
                </small> 
              </label>

              <div class="col-md-6 col-sm-6 col-xs-6">
                <table class="table table-striped table-hover" id="muestra-cupones">
                  <thead>
                    <tr>
                      <th>Sección</th>
                      <th>Crear</th>
                      <th>Editar</th>
                      <th>Eliminar</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php echo $tabla; ?>
                  </tbody>
                </table>

              </div>
            </div-->

            <div class="form-group">
              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="descripcion">Descripci&oacute;n <span class="required">*</span></label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <textarea class="form-control" name="descripcion" id="descripcion" placeholder="Descripci&oacute;n la empresa"></textarea>
              </div>
            </div>

            <div class="form-group">
              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="status">Estatus<span class="required">*</span></label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <select class="form-control" name="status" id="status">
                  <option value="" disabled selected>Selecciona un estatus</option>
                  <?php echo $sStatus; ?>
                </select>
              </div>
            </div>

            <div class="form-group">
              <div class="col-md-9 col-sm-9 col-xs-12 col-md-offset-2 col-xs-offset-3">
                <button class="btn btn-danger col-md-3 col-sm-3 col-xs-5" type="button" id="btnCancel">Cancelar</button>
                <button class="btn btn-primary col-md-3 col-sm-3 col-xs-5" type="reset" >Resetear</button>
                <button class="btn btn-success col-md-3 col-sm-3 col-xs-5" id="btnAdd" type="submit">Agregar</button>
              </div>
            </div>
            <div id="resultado">

            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<?php echo $footer;?>
