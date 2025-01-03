<?php
  require_once __dir__."/../../../controlador/controlador.php";
  require_once __dir__."/../../../controlador/productosControlador.php";
  require_once __dir__."/../../../controlador/productosBodegaControlador.php";
  require_once __dir__."/../../../controlador/recursosControlador.php";
  require_once __dir__."/../../../controlador/utilidadesControlador.php";
  require_once __dir__."/../../../recursos/head.php";

  $productos   = new Productos();
  $productosBod= new ProductosBodega();
  $recursos    = new Recursos();
  $utilidades  = new Utilidades();
  $mvc2        = new controlador();

  $dia         = Utilidades::fecha_dia();
  $mes         = Utilidades::fecha_mes();
  $ano         = Utilidades::fecha_ano();
  $hoy         = Utilidades::fecha_hoy();
?>
<script src="<?= controlador::$rutaAPP ?>app/vistas/productosBodega/asset/js/js.js"></script>
<link href="<?= controlador::$rutaAPP ?>app/vistas/productosBodega/asset/css/css.css" rel="stylesheet" type="text/css" />
<input type="hidden" name="url_link" id="url_link" value="<?= controlador::$rutaAPP ?>">
<div class="row mb-4">
  <p align="left" class="text-success font-weight-light h3">Nuevo Producto</p>
  <hr class="mt-2 mb-3"/>

      <div class="row">
        <div class="col-lg-4 mb-2">
          <label for="inputCategoria"><b>Código</b>&nbsp;&nbsp;<span class="h5" id="codigo_existe"></span></label>
          <input type="text" class="form-control shadow" id="inputCodigo" placeholder="Código Producto" autocomplete="off" onchange="consulta_codigo()">
        </div>
        <div class="col-lg-4 mb-2">
          <label for="inputNombre"><b>Nombre</b></label>
          <input type="text" class="form-control shadow" id="inputNombre" placeholder="Nombre" autocomplete="off">
        </div>
        <div class="col-lg-4 mb-2">
          <label for="inputCategoria"><b>Marca</b></label>
            <?= $productosBod->seleccion_marcas(0); ?>
        </div>
        <div class="col-lg-4 mb-2">
          <label for="inputTipoUnidad"><b>Tipo Unidad</b></label>
            <?= $recursos->select_tipo_unidad(0); ?>
        </div>
        <div class="col-lg-4 mb-2">
          <label for="tipo_categoria"><b>Tipo Categoría</b></label>
            <select name="tipo_categoria" id="tipo_categoria" class="form-select" onchange="tipo_categoria()">
              <option value="0">Seleccionar Tipo Categoría</option>
              <option value="1">Unitario</option>
              <option value="2">Granel</option>
              <option value="3">Metros</option>
            </select>
        </div>
        <div class="col-lg-4 mb-2">
          <label for="inputCategoria"><b>Categor&iacute;a</b></label>
          <span id="buscar_categoria">
            <select name="inputCategoria" id="inputCategoria" class="form-select shadow">
              <option value="0">Seleccionar Categoría</option>
            </select>
          </span>
        </div>
        <div class="col-lg-4 mb-2">
          <label for="inputStock"><b>Stock</b>&nbsp;&nbsp;<span class="text-primary" id="ejemplo"></span></label>
            <input type="number" class="form-control shadow" id="inputStock" placeholder="Escribir Stock">
        </div>
        <div class="col-lg-3 mb-2">
          <label for="inputPrecioCompra"><b>Monto de Compra</b></label>
            <input type="number" class="form-control shadow" id="inputPrecioCompra" placeholder="Escribir Monto">
        </div>
        <div class="col-lg-3 mb-2">
          <label for="inputMargen"><b>Margen de Ganancia</b></label>
            <input type="number" class="form-control shadow" id="inputMargen" placeholder="Escribir Margen" onchange="calcular_margen_porcentaje()">
        </div>
        <div class="col-lg-3 mb-2">
          <label for="inputPrecioVenta"><b>Monto de Venta</b></label>
            <input type="number" class="form-control shadow" id="inputPrecioVenta" placeholder="Monto de Venta" onchange="calcular_margen_neto()">
        </div>
        <div class="col-lg-3 mb-2">
          <label for="inputPrecioUtilidad"><b>Utilidad</b></label>
            <input type="number" class="form-control shadow" id="inputPrecioUtilidad" placeholder="Utilidad" readonly>
        </div>
        <div class="col-lg-4 mb-2">
          <label for="inputSucursal"><b>Sucursal</b></label>
            <?= $productos->seleccion_sucursal(0); ?>
        </div>
        <div class="col-lg-2 mb-2">
          <label for="inputTipo">&nbsp;</label>
          <button type="button" id="grabar" class="btn btn-primary form-control shadow" onclick="grabar_nuevo_producto()">Grabar <i class="bi bi-save"></i></button>
        </div>
      </div>

</div>
<script>
 $(document).ready(function() { 
      var multipleCancelButton = new Choices("#inputMarca", {
        removeItemButton: true,
      });
  });
</script>