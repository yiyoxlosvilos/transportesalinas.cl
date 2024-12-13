<?php 
	date_default_timezone_set("America/Santiago");
	require_once __dir__."/../../../controlador/controlador.php";
	require_once __dir__."/../../../controlador/bodegaProductosControlador.php";
	require_once __dir__."/../../../recursos/head.php";

	$bodega      = new Bodega();
?>
<script src="<?= controlador::$rutaAPP ?>app/recursos/js/table.js?v=<?= rand() ?>"></script>
<link href="<?= controlador::$rutaAPP ?>app/recursos/css/table.css?v=<?= rand() ?>" rel="stylesheet" type="text/css" />
<script src="<?= controlador::$rutaAPP ?>app/vistas/bodega/asset/js/js.js?v=<?= rand() ?>"></script>
<link href="<?= controlador::$rutaAPP ?>app/vistas/bodega/asset/css/css.css?v=<?= rand() ?>" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="<?= controlador::$rutaAPP ?>app/recursos/css/choices.css?v=<?= rand() ?>">
<script src="<?= controlador::$rutaAPP ?>app/recursos/js/choice.js?v=<?= rand() ?>"></script>
<input type="hidden" name="url_link" id="url_link" value="<?= controlador::$rutaAPP ?>">

<div class="row d-flex justify-content-center mt-100">
    <p align="left" class="text-success font-weight-light h3"><i class="fas fa-arrow-alt-circle-up"></i> Ingresos Productos</p>
    <div class="col-md-7">
        <?= $bodega->select_productos_multiple(1); ?> 
    </div>
    <div class="col-md-3">
        <span class="btn btn-primary w-lg waves-effect waves-light w-100 waves-effect waves-light " type="button" onclick="ingresos_productos_lista()">
            Buscar&nbsp;&nbsp;&nbsp;<i class="bi bi-search"></i>
        </span>
    </div>
    <hr class="mt-2 mb-3"/>
    <div class="col-md-15" id="resultado_ingreso"></div>
</div>