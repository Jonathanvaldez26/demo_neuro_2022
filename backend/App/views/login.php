<?php
    echo $header;
?>
    <body class="">
    <main class="main-content main-content-bg mt-0">
        <section>
        <style>
            .bg-gradient-musa {
                background-image: linear-gradient(0deg, turquoise, pink 75%);
            }

            .bg-gradient-pink-white {
                background-image: linear-gradient(0deg, pink, #f7e1ebcc 75%);
            }

            .bg-gradient-red {
                background-image: linear-gradient(310deg, #ff0032 0%, #b10303 100%);
            }

            .morado-musa-text{
                color: rgb(98 56 246);
            }

            .bg-musa-morado{
                background-color: rgb(98 56 246);
            }

            .bg-pink{
                background-color: pink;
            }

            .bg-turquoise{
                background-color: turquoise;
            }
        </style>
            <div class="page-header min-vh-75">
                <div class="container">
                    <div class="row">
                        <div class="col-xl-4 col-lg-5 col-md-6 d-flex flex-column mx-auto">
                            <div class="card card-plain mt-8">
                                <div class="card-header pb-0 text-start">
                                    <h3 class="font-weight-bolder morado-musa-text">GRUPO LAHE</h3>
                                    <h5 class="font-weight-bolder morado-musa-text">Administrador MUSA 2022</h5>
                                    <p class="mb-0">Introduce tus credenciales para iniciar sesión.</p>
                                </div>
                                <div class="card-body">
                                    <form role="form" class="text-start" id="login" action="/Login/crearSession" method="POST" class="form-horizontal">
                                        <label>Correo Electrónico</label>
                                        <div class="mb-3">
                                            <input type="email" name="usuario" id="usuario" class="form-control" placeholder="usuario@grupolahe.com" aria-label="Email">
                                        </div>
                                        <div class="row">
                                            <div class="col-12">
                                                <label>Contraseña</label>
                                                <div class="mb-0">
                                                    <input type="password" name="password" id="password" class="form-control" placeholder="•••••••••" aria-label="Password">
                                                </div>
                                            </div>
                                            <!-- <div class="col-2" id="eye">
                                                <i class="fa fa-eye mt-4 pt-3"></i>
                                            </div> -->
                                        </div>
                                        <div class="text-center">
                                            <button type="button" id="btnEntrar" class="btn bg-gradient-musa morado-musa-text w-100 mt-4 mb-0">ENTRAR</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="oblique position-absolute top-0 h-100 d-md-block d-none me-n8">
                                <div class="oblique-image bg-cover position-absolute fixed-top ms-auto h-100 z-index-0 ms-n6" style="background-image:url('/assets/img/curved-images/fondo.jpg')"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
    <!-- -------- START FOOTER 3 w/ COMPANY DESCRIPTION WITH LINKS & SOCIAL ICONS & COPYRIGHT ------- -->
    <footer class="footer py-7">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 mx-auto text-center mb-0 mt-0">
                    <a href="javascript:;" target="_blank" class="text-secondary me-xl-4 me-4">
                        <span class="text-lg fab fa-facebook"></span>
                    </a>
                    <a href="javascript:;" target="_blank" class="text-secondary me-xl-4 me-4">
                        <span class="text-lg fab fa-twitter"></span>
                    </a>
                    <a href="javascript:;" target="_blank" class="text-secondary me-xl-4 me-4">
                        <span class="text-lg fab fa-instagram"></span>
                    </a>
                </div>
            </div>
            <div class="row">
                <div class="col-8 mx-auto text-center mt-0">
                    <p class="mb-0 text-secondary">
                        Copyright © <script>
                            document.write(new Date().getFullYear())
                        </script> Soft by Creative Grupo LAHE.
                    </p>
                </div>
            </div>
        </div>
    </footer>

</body>

<?php echo $footer; ?>