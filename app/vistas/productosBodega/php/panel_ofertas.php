<?php 
	date_default_timezone_set("America/Santiago");
	require_once __dir__."/../../../controlador/controlador.php";
	require_once __dir__."/../../../controlador/bodegaControlador.php";
    require_once __dir__."/../../../controlador/productosControlador.php";
	require_once __dir__."/../../../recursos/head.php";

	$bodega      = new Bodega();
    $productos   = new Productos();

    $producto_id = $_REQUEST['producto_id'];

    if($producto_id > 0){
        $existe     = $productos->cosultaProductOferta(array($producto_id));
    }else{
        $existe     = 0;
    }

?>
<script src="<?= controlador::$rutaAPP ?>app/recursos/js/table.js"></script>
<link href="<?= controlador::$rutaAPP ?>app/recursos/css/table.css" rel="stylesheet" type="text/css" />
<script src="<?= controlador::$rutaAPP ?>app/vistas/productosBodega/asset/js/js.js"></script>
<link href="<?= controlador::$rutaAPP ?>app/vistas/productosBodega/asset/css/css.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="<?= controlador::$rutaAPP ?>app/recursos/css/choices.css">
<script src="<?= controlador::$rutaAPP ?>app/recursos/js/choice.js"></script>
<input type="hidden" name="url_link" id="url_link" value="<?= controlador::$rutaAPP ?>">
<?php
    if($existe == 0){
?>
<div class="row d-flex justify-content-center mt-100">
    <p align="left" class="text-danger font-weight-light h3"><i class="fas fa-arrow-alt-circle-up"></i>Productos Oferta</p>
    <div class="col-md-7">
        <?= $bodega->select_productos_normal(1); ?> 
    </div>
    <div class="col-md-3">
        <span class="btn btn-primary w-lg waves-effect waves-light w-100 waves-effect waves-light " type="button" onclick="ofertar_productos_formulario()">
            Buscar&nbsp;&nbsp;&nbsp;<i class="bi bi-search"></i>
        </span>
    </div>
    <hr class="mt-2 mb-3"/>
    <div class="col-md-15" id="resultado_ingreso"></div>
</div>
<?php
    }else{
?>
<div class="row d-flex justify-content-center mt-100">
    <p align="left" class="text-danger font-weight-light h3"><i class="fas fa-arrow-alt-circle-up"></i>Producto en Oferta</p>
    <hr class="mt-2 mb-3"/>
    <div class="col-md-15"><?= $productos->formulario_oferta_editar(array($producto_id)) ?></div>
</div>
<?php
    }
?>