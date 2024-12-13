<?php
  require_once __dir__."/../../controlador/utilidadesControlador.php";
  require_once __dir__."/../../controlador/recursosControlador.php";
  require_once __dir__."/../../controlador/centroCostoControlador.php";
  require_once __dir__."/../../recursos/head.php";

  $centroCostos= new CentroCostos();
  $recursos    = new Recursos();
  $mvc2        = new controlador();
  $mvc2->iniciar_sesion();
	$dia         = Utilidades::fecha_dia();
	$mes         = Utilidades::fecha_mes();
  $ano         = Utilidades::fecha_ano();
  $hoy         = Utilidades::fecha_hoy();

  // MENU
  $mvc2->menu_usuarios();
?>
<script src="<?= controlador::$rutaAPP ?>app/vistas/centro_costo/asset/js/js.js?v=<?= rand() ?>"></script>
<link href="<?= controlador::$rutaAPP ?>app/vistas/centro_costo/asset/css/css.css?v=<?= rand() ?>" rel="stylesheet" type="text/css" />

<script src="<?= controlador::$rutaAPP ?>app/recursos/js/table.js?v=<?= rand() ?>"></script>
<link href="<?= controlador::$rutaAPP ?>app/recursos/css/table.css?v=<?= rand() ?>" rel="stylesheet" type="text/css" />

<input type="hidden" name="url_link" id="url_link" value="<?= controlador::$rutaAPP ?>">
<!DOCTYPE html>
<html>
<body id="body-pd">
  <div class="row paddingtop40px mt-5">
    <div class="card-block text-center">

      <button class="btn btn-light bg-gradient" onclick="location.reload()"><i class="fa fa-home h4 text-dark"></i>&nbsp;<span class="ocultar"></span></button>

      <button class="btn btn-danger bg-gradient" href="app/vistas/centro_costo/php/panel_cotizacion.php" data-fancybox data-type="iframe" data-preload="true" data-width="1200" data-height="1200"><i class="fas fa-receipt h4 text-white"></i>&nbsp;<span class="ocultar">Cotizaci&oacute;n</span></button>

      <button class="btn btn-success bg-gradient" href="app/vistas/centro_costo/php/panel_caja.php" data-fancybox data-type="iframe" data-preload="true" data-width="1200" data-height="1200"><i class="fas fa-handshake h4 text-white"></i>&nbsp;<span class="ocultar">Servicios</span></button>
      
      <button class="btn btn-primary bg-gradient" href="app/vistas/centro_costo/php/estado_pago.php" data-fancybox data-type="iframe" data-preload="true" data-width="1200" data-height="1200"><i class="fas fa-hand-holding-usd h4 text-white"></i>&nbsp;<span class="ocultar">EDP</span></button>

      <button class="btn btn-dark bg-gradient" onclick="traer_menu_principal('centro_costo')"><i class="fas fa-suitcase h4 text-white"></i>&nbsp;<span class="ocultar">Centro&nbsp;Costo</span></button>

      <button class="btn btn-warning bg-gradient" href="<?= controlador::$rutaAPP ?>app/vistas/centro_costo/php/panel_bodega.php" data-fancybox data-type="iframe" data-preload="true" data-width="1200" data-height="1200"><i class="fas fa-user-check h4 text-white"></i>&nbsp;<span class="ocultar">Clientes</span></button>

    </div>
    <div class="row mt-3" id="traer_productos_categoria">
      <h3 class="border-bottom m-1">Cotizaciones Pendientes</h3>
      <div class="col-md-12 border shadow">
        <div class="row"><?= $centroCostos->panel_cotizaciones() ?></div>
      </div>
      <h3 class="border-bottom m-1 mt-5">Servicios Activos</h3>
      <div class="col-md-12 border shadow">
        <div class="row"><?= $centroCostos->servicios_activos() ?></div>
      </div>
      <h3 class="border-bottom p-2 mt-5">Cotizaciones Aceptadas</h3>
      <div class="col-md-12 border shadow">
        <div class="row"><?= $centroCostos->panel_cotizaciones_aceptadas() ?></div>
      </div>
      <h3 class="border-bottom p-2 mt-5">Servicios Aceptados</h3>
      <div class="col-md-12 border shadow" >
        <div class="row"><?= $centroCostos->servicios_aceptados() ?></div>
      </div>
      <h3 class="border-bottom p-2 mt-5">EDP Pagados</h3>
      <div class="col-md-12 border shadow" >
        <div class="row"><?= $centroCostos->edp_aceptados() ?></div>
      </div>
    </div>
  </div>
</body>
</html>
<script>
  $(document).ready(function() {
    $("#servicios_pendientes").DataTable({     
      "aLengthMenu": [[5, 10, 20, 30, -1], [5, 10, 20, 30, "Todos"]],
      "iDisplayLength": 5
   });
  });

  $(document).ready(function() {
    $("#cotizaciones_pendientes").DataTable({     
      "aLengthMenu": [[5, 10, 20, 30, -1], [5, 10, 20, 30, "Todos"]],
      "iDisplayLength": 5
   });
  });

  $(document).ready(function() {
    $("#servicios_aceptados").DataTable({     
      "aLengthMenu": [[5, 10, 20, 30, -1], [5, 10, 20, 30, "Todos"]],
      "iDisplayLength": 5
   });
  });

  $(document).ready(function() {
    $("#cotizaciones_aceptados").DataTable({     
      "aLengthMenu": [[5, 10, 20, 30, -1], [5, 10, 20, 30, "Todos"]],
      "iDisplayLength": 5
   });
  });

  $(document).ready(function() {
    $("#EDP_aceptados").DataTable({     
      "aLengthMenu": [[5, 10, 20, 30, -1], [5, 10, 20, 30, "Todos"]],
      "iDisplayLength": 5
   });
  });
</script>