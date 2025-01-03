<?php
  require_once __dir__."/../../../controlador/controlador.php";
  require_once __dir__."/../../../controlador/productosControlador.php";
  require_once __dir__."/../../../controlador/recursosControlador.php";
  require_once __dir__."/../../../controlador/utilidadesControlador.php";
  

  $productos   = new Productos();
  $recursos    = new Recursos();
  $utilidades  = new Utilidades();
  $mvc2        = new controlador();

  $dia         = Utilidades::fecha_dia();
  $mes         = Utilidades::fecha_mes();
  $ano         = Utilidades::fecha_ano();
  $hoy         = Utilidades::fecha_hoy();

  $idServicio  = $_REQUEST['idServicio'];
?>
<script src="<?= controlador::$rutaAPP ?>app/vistas/finanzas/asset/js/js.js?v=<?= rand() ?>"></script>
<link href="<?= controlador::$rutaAPP ?>app/vistas/finanzas/asset/css/css.css?v=<?= rand() ?>" rel="stylesheet" type="text/css" />
<script src="<?= controlador::$rutaAPP ?>app/vistas/centro_costo/asset/js/upload_factura_clientes.js?v=<?= rand() ?>"></script>
<link href="<?= controlador::$rutaAPP ?>app/recursos/css/upload.css?v=<?= rand() ?>" rel="stylesheet" type="text/css" />

<input type="hidden" name="url_link" id="url_link" value="<?= controlador::$rutaAPP ?>">
<div class="row mb-4">
  <p align="left" class="text-success font-weight-light h3">Factura Cliente</p>
  <hr class="mt-2 mb-3"/>
    <div class="container mb-4">
      <div class="row">
        <div class="col-lg-5 mb-2">
          <label for="inputNumero"><b>N&deg; Factura:</b></label>
          <input type="number" class="form-control shadow" id="inputNumero" placeholder="Escribir N&deg; Factura" autocomplete="off">
        </div>
        <div class="col-lg-5 mb-2">
          <label for="inputMonto"><b>Monto Total:</b></label>
          <input type="number" class="form-control shadow" id="inputMonto" placeholder="Escribir Monto Factura" autocomplete="off">
        </div>
        <div class="col-lg-5 mb-2">
          <label for="inputFechaFactura"><b>Fecha Factura</b></label>
            <span id="validador_curso"></span>
            <input type="date" class="form-control shadow" id="inputFechaFactura" value="<?= $hoy ?>">
        </div>
        <div class="col-lg-5 mb-2">
          <label for="inputEstadoFactura"><b>Estado Factura</b></label>
          <?= $recursos->select_estado_factura('mostrar_fecha_pago', 0); ?>
        </div>
        <div class="col-lg-5 mb-2" id="mostrar_fecha_pago" style="display: none;">
          <label for="inputFechaPagoFactura"><b>Fecha de Pago para Factura</b></label>
          <span id="validador_curso"></span>
          <input type="date" class="form-control shadow" id="inputFechaPagoFactura" value="<?= $hoy ?>">
        </div>
        <div class="col-lg-5 mb-2" id="mostrar_fecha_pago">
          <label for="inputFechaPagoFactura"><b>Adjuntar PDF</b></label>
          <div dir=rtl class="file-loading">
            <input id="input-b8" name="input-b8[]" multiple type="file">
          </div>
        </div>
        <div class="col-lg-15">
          <label for="inputSucursal"><b>Descripción</b></label>
          <span id="validador_curso"></span>
          <textarea class="form-control shadow" id="inputDescripcion" rows="5"></textarea>
        </div>
        <div class="col-lg-2 mb-2">
          <label for="inputTipo">&nbsp;</label>
          <button type="button" id="grabar" class="btn btn-primary form-control shadow" onclick="grabar_nueva_factura_cliente(<?= $idServicio ?>)">Grabar <i class="bi bi-save"></i></button>
        </div>
      </div>
    </div>
</div>
<script>
  $(document).ready(function() {
    $("#input-b8").fileinput({
      tl: true,
      dropZoneEnabled: false,
      allowedFileExtensions: ["pdf"]
    });
  });
</script>