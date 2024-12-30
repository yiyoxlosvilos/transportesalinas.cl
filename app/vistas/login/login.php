<?php 
    session_start();
    session_destroy();

	date_default_timezone_set("America/Santiago");
	require_once __dir__."/../../modelo/obtener_datos.php";
	require_once __dir__."/../../recursos/head.php";
?>
<script src="<?= controlador::$rutaAPP ?>app/vistas/login/asset/js/js.js?v=<?= rand() ?>"></script>
<div class="auth-page">
    <div class="container-fluid p-0">
        <div class="row g-0 slide-in-fwd-center">
            <div class="col-xxl-4 col-lg-4 col-md-7">
                <div class="auth-full-page-content d-flex p-sm-5 p-4">
                    <div class="w-100">
                        <div class="d-flex flex-column h-100">
                            <div class="my-3 text-center slide-in-elliptic-top-fwd">
                                <a href="index.php" class="d-block auth-logo">
                                    <img src="<?= controlador::$rutaAPP ?>app/recursos/img/logo_nuevo.jpg" alt="" height="99">
                                </a>
                            </div>
                            <div class="auth-content my-auto">
                                <form  class="needs-validation color-gris padding_3 sombra_plana borde bounce-in-left" novalidate>
                                    <div class="mb-3">
                                        <label class="form-label" for="usuario">Usuario</label>
                                        <input type="text" class="form-control" id="usuario" placeholder="Ingresar Usuario" name="usuario" required>
                                    </div>
                                    <div class="mb-3">
                                        <div class="form-group mb-3">
                                            <label>Contraseña</label>
                                            <input type="password" id="pass" placeholder="Ingresar Contraseña" required class="form-control" />
                                        </div>
                                    </div>
                                    <div class="row mb-4">
                                        <div class="col">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="remember-check">
                                                <label class="form-check-label" for="remember-check">
                                                    Recordar session
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mb-3 ">
                                        <span class="btn btn-success w-lg waves-effect waves-light w-100 waves-effect waves-light " type="button" onclick="ingresar()">Ingresar&nbsp;&nbsp;<li class="fas fa-check font-size-14">&nbsp;&nbsp;</li></span>
                                    </div>
                                </form>
                            </div>
                            <div class="mt-4 mt-md-5 text-center">
                                <p class="mb-0">©<script>
                                        document.write(new Date().getFullYear())
                                    </script> Centro Comercio<br>"La evolución del Mercado"</p>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end auth full page content -->
            </div>
            <!-- end col -->
            <div class="col-xxl-8 col-lg-8 col-md-7">
                <div class="auth-bg pt-md-5 p-4 d-flex">
                    <div class="bg-overlay bg-comercio"></div>
                    <ul class="bg-bubbles">
                        <li></li>
                        <li></li>
                        <li></li>
                        <li></li>
                        <li></li>
                        <li></li>
                        <li></li>
                        <li></li>
                        <li></li>
                        <li></li>
                        <li></li>
                    </ul>
                    <!-- end bubble effect -->
                    <div class="row justify-content-center align-items-center">
                        <div class="col-xl-7">
                            <div class="p-0 p-sm-4 px-xl-0">
                                <div id="reviewcarouselIndicators" class="carousel slide" data-bs-ride="carousel">
                                    <div class="carousel-indicators carousel-indicators-rounded justify-content-start ms-0 mb-0">
                                        <button type="button" data-bs-target="#reviewcarouselIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                                        <button type="button" data-bs-target="#reviewcarouselIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
                                        <button type="button" data-bs-target="#reviewcarouselIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
                                    </div>
                                    <!-- end carouselIndicators -->
                                    <div class="carousel-inner">
                                        
                                    </div>
                                    <!-- end carousel-inner -->
                                </div>
                                <!-- end review carousel -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end col -->
        </div>
        <!-- end row -->
    </div>
    <!-- end container fluid -->
</div>