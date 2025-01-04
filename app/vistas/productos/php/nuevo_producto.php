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
?>
<script src="<?= controlador::$rutaAPP ?>app/vistas/productos/asset/js/js.js?v=<?= rand() ?>"></script>
<link href="<?= controlador::$rutaAPP ?>app/vistas/productos/asset/css/css.css?v=<?= rand() ?>" rel="stylesheet" type="text/css" />
<input type="hidden" name="url_link" id="url_link" value="<?= controlador::$rutaAPP ?>">
<div class="row mb-4">
  <p align="left" class="text-success font-weight-light h3">Nueva Maquinaria</p>
  <hr class="mt-2 mb-3"/>
    <div class="container mb-4">
      <div class="row">
        <div class="col-lg-5 mb-2">
          <label for="inputCategoria"><b>Código</b> <span id="codigo_existe"></span></label>
          <input type="text" class="form-control shadow" id="inputCodigo" placeholder="Código Producto" autocomplete="off" onchange="consulta_codigo()">
        </div>
        <div class="col-lg-5 mb-2">
          <label for="inputNombre"><b>Nombre</b></label>
          <input type="text" class="form-control shadow" id="inputNombre" placeholder="Nombre" autocomplete="off">
        </div>
        <div class="col-lg-5 mb-2">
          <label for="inputMarca"><b>Marca</b></label>
          <?= $productos->seleccion_marcas(0, 0); ?>
        </div>
        <div class="col-lg-5 mb-2">
          <label for="inputCategoria"><b>Categor&iacute;a</b></label>
            <?= $productos->seleccion_categorias(0); ?>
        </div>
        <div class="col-lg-5 mb-2">
          <label for="inputPrecio"><b>Patente</b></label>
            <input type="text" class="form-control shadow" id="inputPatente" placeholder="Escribir Monto">
        </div>
        <div class="col-lg-5 mb-2">
          <label for="inputSucursal"><b>Sucursal</b></label>
            <span id="validador_curso"></span>
            <?= $productos->seleccion_sucursal(0); ?>
        </div>
        <div class="col-lg-2 mb-2">
          <label for="inputTipo">&nbsp;</label>
          <button type="button" id="grabar" class="btn btn-primary form-control shadow" onclick="grabar_nuevo_producto()">Grabar <i class="bi bi-save"></i></button>
        </div>
      </div>
    </div>
</div>