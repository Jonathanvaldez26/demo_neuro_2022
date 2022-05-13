<?php echo $header;?>
<div class="right_col">
  <div class="col-md-12 col-sm-12 col-xs-12 col-lg-12">
    <div class="x_panel tile fixed_height_240">
      <div class="x_title">
        <br><br>
        <h1> Editar Empresa</h1>
        <div class="clearfix"></div>
      </div>
      <div class="x_content">
        <form class="form-horizontal" id="edit" action="/Empresa/empresaEdit" method="POST">
          <div class="form-group ">

            <div class="form-group">
              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="rfc">RFC <span class="required">*</span></label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <input type="text" name="rfc" id="rfc" class="form-control col-md-7 col-xs-12" placeholder="RFC de la Empresa" value="<?php echo $empresa['rfc']; ?>">
              </div>
              <span id="availability"></span>
            </div>

            <div class="form-group">
              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="razon_social">Razon Social <span class="required">*</span></label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <input type="text" name="razon_social" id="razon_social" class="form-control col-md-7 col-xs-12" placeholder="Grupo LAHE S.A. de C.V." value="<?php echo $empresa['razon_social']; ?>">
              </div>
              <span id="availability"></span>
            </div>

            <div class="form-group">
              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="email">Email <span class="required">*</span></label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <input type="email" name="email" id="email" class="form-control col-md-7 col-xs-12" placeholder="ejemplo@grupolahe.com" value="<?php echo $empresa['email']; ?>">
              </div>
              <span id="availability"></span>
            </div>

            <div class="form-group">
              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="telefono_uno">Telefono Uno <span class="required">*</span></label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <input type="number" name="telefono_uno" id="telefono_uno" class="form-control col-md-7 col-xs-12" placeholder="+52 0987654321" value="<?php echo $empresa['telefono_uno']; ?>">
              </div>
              <span id="availability"></span>
            </div>

            <div class="form-group">
              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="telefono_dos">Telefono Dos <span class="required">*</span></label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <input type="number" name="telefono_dos" id="telefono_dos" class="form-control col-md-7 col-xs-12" placeholder="+52 0987654321" value="<?php echo $empresa['telefono_dos']; ?>">
              </div>
              <span id="availability"></span>
            </div>

            <!-- <div class="form-group">
              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="descripcion">Descripci&oacute;n <span class="required">*</span></label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <textarea class="form-control" name="descripcion" id="descripcion" placeholder="Descripci&oacute;n la empresa"><?php echo $empresa['descripcion']; ?></textarea>
              </div>
            </div> -->

            <!-- <div class="form-group">
              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="descripcion">Status<span class="required">*</span></label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <select class="form-control" name="status" id="status">
                  <option value="" disabled selected>Selecciona un estatus</option>
                  <?php echo $status; ?>
                </select>
              </div>
            </div> -->

            <input type="hidden" name="catalogo_empresa_id" id="catalogo_empresa_id" value="<?php echo $empresa['catalogo_empresa_id']; ?>">

            <div class="form-group">
              <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                <button class="btn btn-danger col-md-5 col-sm-5 col-xs-5" type="button" id="btnCancel">Cancelar</button>
                <button class="btn btn-success col-md-5 col-sm-5 col-xs-5" id="btnAdd" type="submit">Actualizar</button>
              </div>
            </div>


          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<?php echo $footer;?>
