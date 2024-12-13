<?php
  require_once __dir__."/../../../controlador/controlador.php";
  require_once __dir__."/../../../controlador/productosControlador.php";
  require_once __dir__."/../../../controlador/utilidadesControlador.php";
  require_once __dir__."/../../../recursos/head.php";

  $productos   = new Productos();
  $utilidades  = new Utilidades();
  $mvc2        = new controlador();

  $dia         = Utilidades::fecha_dia();
  $mes         = Utilidades::fecha_mes();
  $ano         = Utilidades::fecha_ano();
  $hoy         = Utilidades::fecha_hoy();

  $idProducto  = $_REQUEST['idProducto'];
?>
<script src="<?= controlador::$rutaAPP ?>app/vistas/productos/asset/js/js.js?v=<?= rand() ?>"></script>
<script src="<?= controlador::$rutaAPP ?>app/vistas/productos/asset/js/upload.js?v=<?= rand() ?>"></script>
<link href="<?= controlador::$rutaAPP ?>app/vistas/productos/asset/css/css.css?v=<?= rand() ?>" rel="stylesheet" type="text/css" />
<link href="<?= controlador::$rutaAPP ?>app/recursos/css/upload.css?v=<?= rand() ?>" rel="stylesheet" type="text/css" />
<script src="<?= controlador::$rutaAPP ?>app/recursos/js/bar_code.js?v=<?= rand() ?>"></script>

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
    <div class="col-xl-10 mb-2" id="subir_foto_producto">
      <?= $productos->imagen_producto($idProducto) ?>
    </div>
    <div class="col-xl-10 mb-2">
      <p>C&oacute;digo Barra</p>
      <?= $productos->codigo_barra($idProducto) ?>
    </div>
    <div class="col-xl-10 mb-2">
      <p>Informaci&oacute;n</p>
      <?= $productos->historial_producto($idProducto) ?>
    </div>
  </div>
</div>