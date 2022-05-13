<?php
    echo $header;
?>

<div id="particles-js">
    
    <div style="position: absolute; width: 50%; height: auto;">
        
        <div style="width: 70%; margin-left: 60%; margin-top: 30%; background: #fff; padding: 20px;">
            <div style="width: 100%;" >
                <div style="text-align: center;">
                    <img  src="/img/logogranja.png" alt="Login">
                </div>
                <br>
                <h1 style="color: #ed9f34; font-size: 30px; text-align: center;">Iniciar Sesión</h1>
            
                <form id="login" action="/Login/crearSession" method="POST" class="form-horizontal">

                    <br><br>

                    <div class="form-group">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <span sclass="col-md-1 col-sm-1 col-xs-1" id="availability"> </span>
                            <input type="text" name="usuario" id="usuario" class="form-control col-md-5 col-xs-12" placeholder="Usuario">
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <input type="password" name="password" id="password" class="form-control col-md-5 col-xs-12" placeholder="Contraseña">
                        </div>
                    </div>

                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <button type="button" id="btnEntrar" class="btn btn-warning col-md-4 col-sm-4 col-xs-4 pull-right">Entrar <i class="glyphicon glyphicon-log-in"></i></button>
                        </div>
                    </div>

                    <div id="retroclockbox1" hidden>

                    </div>
                </form>
            </div>
        </div>

    </div>

</div> 
<?php echo $footer; ?>