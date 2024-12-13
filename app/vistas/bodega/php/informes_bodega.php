<?php 
	date_default_timezone_set("America/Santiago");
	require_once __dir__."/../../../controlador/controlador.php";
    require_once __dir__."/../../../controlador/bodegaProductosControlador.php";
	require_once __dir__."/../../../controlador/utilidadesControlador.php";
	require_once __dir__."/../../../recursos/head.php";

	$bodega      = new Bodega();
?>
<script src="<?= controlador::$rutaAPP ?>app/recursos/js/table.js?v=<?= rand() ?>"></script>
<link href="<?= controlador::$rutaAPP ?>app/recursos/css/table.css?v=<?= rand() ?>" rel="stylesheet" type="text/css" />
<script src="<?= controlador::$rutaAPP ?>app/vistas/bodega/asset/js/js.js?v=<?= rand() ?>"></script>
<link href="<?= controlador::$rutaAPP ?>app/vistas/bodega/asset/css/css.css?v=<?= rand() ?>" rel="stylesheet" type="text/css" />

<input type="hidden" name="url_link" id="url_link" value="<?= controlador::$rutaAPP ?>">

<div class="row d-flex justify-content-center mt-100">
    <p align="left" class="text-info font-weight-light h3">Informes Bodega</p>
    <div class="col-md-3">Tipo Búsqueda:
        <select id="tipo_accion" class="border rounded form-control mb-2">
            <option value="0">Seleccionar Tipo</option>
            <option value="1">Ingresos de Bodega</option>
            <option value="2">Salidas de Bodega</option>
            <option value="3">Mermas Realizadas</option>
        </select> 
    </div>
    <div class="col-md-3">Desde:
        <input type="date" name="desde" id="desde" value="<?= Utilidades::fecha_hoy() ?>" class="border rounded form-control mb-2">
    </div>
    <div class="col-md-3">Hasta:
        <input type="date" name="hasta" id="hasta" value="<?= Utilidades::fecha_hoy() ?>" class="border rounded form-control mb-2">
    </div>
    <div class="col-md-3">&nbsp;
        <span class="btn btn-primary w-lg waves-effect waves-light w-100 waves-effect waves-light " type="button" onclick="buscar_informes_bodega()">
            Buscar&nbsp;&nbsp;&nbsp;<i class="bi bi-search"></i>
        </span>
    </div>
    <hr class="mt-2 mb-3"/>
    <div class="col-md-15" id="resultado_busqueda"></div>
</div>