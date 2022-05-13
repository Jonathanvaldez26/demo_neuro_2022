<?php echo $header; ?>
<!-- page content -->
		<div class="right_col " role="main">
			<div class="">
				<div class="page-title">
					<div class="title_left">
						<br><br><br><br>
					</div>
				</div>

				<div class="clearfix"></div>
				
				<div class="row">
					<div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3 col-xs-offset-3 profile_details">
						<div class="well profile_view">
							<div class="col-sm-12">
								<h4 class="brief"><i><b>Usuario: </b><?php echo $usuario['usuario']; ?> <b> Perfil:</b> <?php echo $usuario['nombre_perfil']; ?></i></h4>
								<div class="left col-xs-7">
									<h2>Nombre: <?php echo $usuario['nombre']; ?></h2><br>
									<p><strong>Descripción usuario: </strong><?php echo $usuario['descripcion'] ?></p>
								</div>

								<div class="right col-xs-5 text-center">
									<img src="/img/user.png" alt="" class="img-circle img-responsive">
								</div>
							</div>

							<div class="col-xs-12 bottom text-center">	
								<div class="col-xs-12 col-sm-6 emphasis">
									<button type="button" class="btn btn-success btn-xs" id="mostrar"> <i class="fa fa-user">
									</i> Cambiar Contraseña <i class="fa fa-comments-o"></i> </button>
								</div>
							</div>
						</div>
					</div>
				</div>
				
				<div class="cambio_password" style="display: none;">
					<form class="form-horizontal" id="add" action="/Usuario/cambioPassword" method="POST">
						<div class="form-group ">

							<div class="form-group">
								<label class="control-label col-md-5 col-sm-5 col-xs-12" for="pwd_actual">Contraseña Actual <span class="required">*</span></label>
								<div class="col-md-4 col-sm-4 col-xs-4">
									<input type="password" name="pwd_actual" id="pwd_actual" class="form-control col-md-5 col-xs-10" placeholder="Ingresa tu contraseña actual">
								</div>
								<span id="availability"></span>
							</div>

							<div class="form-group">
								<label class="control-label col-md-5 col-sm-5 col-xs-12" for="pwd_nueva">Contraseña Nueva <span class="required">*</span></label>
								<div class="col-md-4 col-sm-4 col-xs-4">
									<input type="password" name="pwd_nueva" id="pwd_nueva" class="form-control col-md-5 col-xs-10" placeholder="Contraseña nueva">
								</div>
								<span id="availability"></span>
							</div>

							<div class="form-group">
								<label class="control-label col-md-5 col-sm-5 col-xs-12" for="pwd_nueva_repetir">Repetir Contraseña <span class="required">*</span></label>
								<div class="col-md-4 col-sm-4 col-xs-4">
									<input type="password" name="pwd_nueva_repetir" id="pwd_nueva_repetir" class="form-control col-md-6 col-xs-11" placeholder="Repite la contraseña">
								</div>
								<span id="availability"></span>
							</div>

							<div class="form-group">
								<div class="col-md-9 col-sm-9 col-xs-12 col-md-offset-4 col-xs-offset-7">
									<button class="btn btn-success col-md-5 col-sm-5 col-xs-5" id="btnAdd" type="submit">Actualizar</button>
								</div>
							</div>
						</div>
					</form>
				</div>


			</div>
		</div>
        <!-- /page content -->
<?php echo $footer; ?>
