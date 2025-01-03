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

  $idServicio  = '';
?>
<script src="<?= controlador::$rutaAPP ?>app/vistas/finanzas/asset/js/js.js?v=<?= rand() ?>"></script>
<link href="<?= controlador::$rutaAPP ?>app/vistas/finanzas/asset/css/css.css?v=<?= rand() ?>" rel="stylesheet" type="text/css" />
<input type="hidden" name="url_link" id="url_link" value="<?= controlador::$rutaAPP ?>">
<div class="row mb-4">
  <hr class="mt-2 mb-3"/>
    <div class="container mb-4">
      <div class="row">
        <div class="col border justify-content-center align-content-center" id="panel_proveedores">
          <div class="row">
            <div class="col"><h4 class="text-primary">Crear Factura Proveedores</h4></div>
            <div class="col-3"><button class="btn btn-sm btn-success" onclick="nueva_factura()"><i class="fas fa-receipt text-white"></i></button></div>
          </div>
        </div>
        <div class="col border justify-content-center align-content-center" id="panel_clientes">
          <div class="row">
            <div class="col"><h4 class="text-primary">Crear Factura Clientes</h4></div>
            <div class="col-3"><button class="btn btn-sm btn-success" onclick="nueva_factura()"><i class="fas fa-receipt text-white"></i></button></div>
          </div>
        </div>
      </div>
    </div>
</div>