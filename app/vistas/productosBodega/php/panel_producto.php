<?php
ini_set('display_errors', 1);
  ini_set('display_startup_errors', 1);
  error_reporting(E_ALL);

  require_once __dir__."/../../../controlador/controlador.php";
  require_once __dir__."/../../../controlador/productosBodegaControlador.php";
  require_once __dir__."/../../../controlador/utilidadesControlador.php";
  require_once __dir__."/../../../controlador/recursosControlador.php";
  require_once __dir__."/../../../recursos/head_panel.php";

  $productos   = new ProductosBodega();
  $mvc2        = new controlador();
  $recursos    = new Recursos();

  $dia         = Utilidades::fecha_dia();
  $mes         = Utilidades::fecha_mes();
  $ano         = Utilidades::fecha_ano();
  $hoy         = Utilidades::fecha_hoy();

  $idProducto  = $_REQUEST['idProducto'];

  $prod        = $recursos->datos_productos($idProducto);

  if($prod[0]['prod_cli_tipo'] == 0){
    $stock     = $recursos->alerta_stock($recursos->stock_producto($prod[0]['prod_cli_id']), 1);
  }elseif($prod[0]['prod_cli_tipo'] == 1){
    $stock     = $recursos->alerta_stock($recursos->stock_producto_granel($prod[0]['prod_cli_id']), 2);
  }
?>
<script src="<?= controlador::$rutaAPP ?>app/vistas/productosBodega/asset/js/js.js?v=<?= rand() ?>"></script>
<script src="<?= controlador::$rutaAPP ?>app/vistas/productosBodega/asset/js/upload.js"></script>
<link href="<?= controlador::$rutaAPP ?>app/vistas/productosBodega/asset/css/css.css" rel="stylesheet" type="text/css" />
<link href="<?= controlador::$rutaAPP ?>app/recursos/css/upload.css" rel="stylesheet" type="text/css" />
<script src="<?= controlador::$rutaAPP ?>app/recursos/js/bar_code.js"></script>

<input type="hidden" name="url_link" id="url_link" value="<?= controlador::$rutaAPP ?>">
<input type="hidden" name="idProducto" id="idProducto" value="<?= $idProducto ?>">
<div class="row">
  <p align="left" class="text-success font-weight-light h3">Panel Producto</p>
  <hr class="mt-2 mb-3"/>
  <div class="col-xl-6 col-md-6 mb-4 animate__animated animate__fadeIn">
    <div class="container mb-4">
      <?= $productos->formulario_productos($idProducto); ?>
    </div>
  </div>
  <div class="col-xl-6 col-md-6 mb-4 animate__animated animate__fadeIn animate__slow" >
    <div class="col-xl-10 mb-2 border" id="stock_producto">
      <h4><center><b>Stock<br><?= $stock ?></b></center></h4>
    </div>
    <div class="col-xl-10 mb-2" id="subir_foto_producto">
      <?= $productos->imagen_producto($idProducto) ?>
    </div>
    <div class="col-xl-10 mb-2">
      <p><b>C&oacute;digo Barra</b></p>
      <?= $productos->codigo_barra($idProducto) ?>
    </div>
  </div>
</div>