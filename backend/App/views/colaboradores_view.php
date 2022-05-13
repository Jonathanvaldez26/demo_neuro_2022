<?php echo $header;?>
<div class="right_col">
  <div class="col-md-12 col-sm-12 col-xs-12 col-lg-12">
    <div class="x_panel tile fixed_height_240">
      <div class="x_title">
        <br><br>
        <h1> Datos del Colaborador <small> con id <?php echo $colaborador['catalogo_colaboradores_id']; ?> </small></h1>
        <div class="clearfix"></div>
      </div>
      <div class="x_content">
          <div class="form-group ">

            <div class="col-md-6 col-sm-6 col-xs-6 col-md-offset-4">
              <img id="vista_previa" class="form-control foto" src="/img/colaboradores/<?=$colaborador['foto']?>" alt="Foto de Perfil">
            </div>

            <div class="dashboard-widget-content">
              <ul class="list-unstyled timeline widget">
                <li>
                  <div class="block">
                    <div class="block_content">
                      <h2 class="title">
                        <a>Nombre completo del Colaborador</a>
                      </h2>
                      <div class="byline"></div>
                      <p class="excerpt"><?php echo $colaborador['nombre'] . " " . $colaborador['apellido_paterno'] . " " . $colaborador['apellido_materno']; ?></p>
                    </div>
                  </div>
                </li>

                <li>
                  <div class="block">
                    <div class="block_content">
                      <h2 class="title">
                        <a>Identificador de NOI</a>
                      </h2>
                      <div class="byline"></div>
                      <p class="excerpt"><?php echo $colaborador['identificador_noi']; ?></p>
                    </div>
                  </div>
                </li>

                <?php if($idMotivo!=''){ ?>
                <li>
                  <div class="block">
                    <div class="block_content">
                      <h2 class="title">
                        <a>Motivo de baja</a>
                      </h2>
                      <div class="byline"></div>
                      <input type="text" class="form-control" value="<?php echo $idMotivo; ?>">
                    </div>
                  </div>
                </li>
                <?php } ?>

                <li>
                  <div class="block">
                    <div class="block_content">
                      <h2 class="title">
                        <a>Sexo</a>
                      </h2>
                      <div class="byline"></div>
                      <p class="excerpt"><?php echo $colaborador['sexo']; ?></p>
                    </div>
                  </div>
                </li>

                <li>
                  <div class="block">
                    <div class="block_content">
                      <h2 class="title">
                        <a>RFC</a>
                      </h2>
                      <div class="byline"></div>
                      <p class="excerpt"><?php echo $colaborador['rfc']; ?></p>
                    </div>
                  </div>
                </li>

                <li>
                  <div class="block">
                    <div class="block_content">
                      <h2 class="title">
                        <a>Empresa</a>
                      </h2>
                      <div class="byline"></div>
                      <p class="excerpt"><?php echo $nombreEmpresa['nombre_empresa']; ?></p>
                    </div>
                  </div>
                </li>

		<li>
                  <div class="block">
                    <div class="block_content">
                      <h2 class="title">
                        <a>Lector</a>
                      </h2>
                      <div class="byline"></div>
                      <p class="excerpt"><?php echo $nombreLector['nombre']; ?></p>
                    </div>
                  </div>
                </li>

                <li>
                  <div class="block">
                    <div class="block_content">
                      <h2 class="title">
                        <a>Ubicación</a>
                      </h2>
                      <div class="byline"></div>
                      <p class="excerpt"><?php echo $nombreUbicacion['nombre']; ?></p>
                    </div>
                  </div>
                </li>

                <li>
                  <div class="block">
                    <div class="block_content">
                      <h2 class="title">
                        <a>Departamento</a>
                      </h2>
                      <div class="byline"></div>
                      <p class="excerpt"><?php echo $nombreDepartamento['nombre']; ?></p>
                    </div>
                  </div>
                </li>

                <li>
                  <div class="block">
                    <div class="block_content">
                      <h2 class="title">
                        <a>Puesto</a>
                      </h2>
                      <div class="byline"></div>
                      <p class="excerpt"><?php echo $nombrePuesto['nombre']; ?></p>
                    </div>
                  </div>
                </li>

                <li>
                  <div class="block">
                    <div class="block_content">
                      <h2 class="title">
                        <a>Horario</a>
                      </h2>
                      <div class="byline"></div>
                      <p class="excerpt"><?php echo $horario; ?></p>
                    </div>
                  </div>
                </li>

                <li>
                  <div class="block">
                    <div class="block_content">
                      <h2 class="title">
                        <a>Fecha alta</a>
                      </h2>
                      <div class="byline"></div>
                      <p class="excerpt"><?php echo $colaborador['fecha_alta']; ?></p>
                    </div>
                  </div>
                </li>

                <li>
                  <div class="block">
                    <div class="block_content">
                      <h2 class="title">
                        <a>Fecha baja</a>
                      </h2>
                      <div class="byline"></div>
                      <p class="excerpt"><?php echo $colaborador['fecha_baja']; ?></p>
                    </div>
                  </div>
                </li>

                <li>
                  <div class="block">
                    <div class="block_content">
                      <h2 class="title">
                        <a>Pago</a>
                      </h2>
                      <div class="byline"></div>
                      <p class="excerpt"><?php echo $colaborador['pago'] ?></p>
                    </div>
                  </div>
                </li>

                <li>
                  <div class="block">
                    <div class="block_content">
                      <h2 class="title">
                        <a>Incentivo</a>
                      </h2>
                      <div class="byline"></div>
                      <p class="excerpt"><?php echo $nomIncentivos; ?></p>
                    </div>
                  </div>
                </li>

                <li>
                  <div class="block">
                    <div class="block_content">
                      <h2 class="title">
                        <a>Opción</a>
                      </h2>
                      <div class="byline"></div>
                      <p class="excerpt"><?php echo ($colaborador['option']!="") ? $colaborador['option'] : "No hay ninguna opción"; ?></p>
                    </div>
                  </div>
                </li>

                <li>
                  <div class="block">
                    <div class="block_content">
                      <h2 class="title">
                        <a>Número de empleado</a>
                      </h2>
                      <div class="byline"></div>
                      <p class="excerpt"><?php echo $colaborador['numero_empleado']; ?></p>
                    </div>
                  </div>
                </li>

		<li>
                  <div class="block">
                    <div class="block_content">
                      <h2 class="title">
                        <a>Privilegiado</a>
                      </h2>
                      <div class="byline"></div>
                      <p class="excerpt"><?php echo $idPrivilegiado; ?></p>
                    </div>
                  </div>
                </li>

                <li>
                  <div class="block">
                    <div class="block_content">
                      <h2 class="title">
                        <a>Status</a>
                      </h2>
                      <div class="byline"></div>
                      <p class="excerpt"><?php echo $colaborador['status']; ?></p>
                    </div>
                  </div>
                </li>
                
              </div>
                      
              </ul>

              <div class="form-group">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <a class="btn btn-success col-md-2 col-sm-1 col-xs-1" type="submit" id="btnCancel">
                  <span class="glyphicon glyphicon-chevron-left pull-left"></span> Regresar
                </a>
              </div>
            </div>
            </div>


      </div>
    </div>
  </div>
</div>

<?php echo $footer;?>
