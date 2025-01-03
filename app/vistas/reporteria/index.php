<?php
  require_once __dir__."/../../controlador/reporteriaControlador.php";
  require_once __dir__."/../../controlador/utilidadesControlador.php";
  require_once __dir__."/../../recursos/head.php";

  $reporteria  = new Reporteria();
  $utilidades  = new Utilidades();
  $mvc2        = new controlador();

	$dia         = Utilidades::fecha_dia();
	$mes         = Utilidades::fecha_mes();
  $ano         = Utilidades::fecha_ano();
  $hoy         = Utilidades::fecha_hoy();
  $cant_dias   = date('t', mktime(0,0,0, $mes, 1, $ano));

  // MENU
  $mvc2->menu_usuarios();
?>
<script src="<?= controlador::$rutaAPP ?>app/recursos/js/table.js?v=<?= rand() ?>"></script>
<link href="<?= controlador::$rutaAPP ?>app/recursos/css/table.css?v=<?= rand() ?>" rel="stylesheet" type="text/css" />
<script src="<?= controlador::$rutaAPP ?>app/vistas/reporteria/asset/js/js.js?v=<?= rand() ?>"></script>
<link href="<?= controlador::$rutaAPP ?>app/vistas/reporteria/asset/css/css.css?v=<?= rand() ?>" rel="stylesheet" type="text/css" />
<input type="hidden" name="url_link" id="url_link" value="<?= controlador::$rutaAPP ?>">
<!DOCTYPE html>
<html>
<body id="body-pd">
  <div class="row paddingtop40px mt-5 mb-4">
    <div class="card-block text-center">
      <button class="btn btn-primary bg-gradient" onclick="location.reload()">Flujo Diario&nbsp;&nbsp;<i class="bi bi-cash"></i></button>
      <button class="btn btn-success bg-gradient" onclick="flujo_mensual()">Flujo Mensual&nbsp;&nbsp;<i class="bi bi-cash-coin"></i></button>
      <button hidden class="btn btn-info bg-gradient" onclick="informe_ventas()">Informe&nbsp;&nbsp;<i class="bi bi-file-bar-graph"></i></button>
      <button class="btn btn-warning bg-gradient" onclick="reporte_financiero()">Reporte&nbsp;&nbsp;<i class="bi bi-bank"></i></button>
      <button hidden class="btn btn-primary bg-gradient" onclick="estado_pago()">Estados de Pago&nbsp;&nbsp;<i class="fas fa-hand-holding-usd"></i></button>
    </div>
    <hr class="mt-2 mb-3"/>
    <div class="row overflow-auto" id="traer_reporteria">
      <?= $reporteria->traer_flujo_diario($mes, $ano, $cant_dias) ?>
    </div>
  </div>
</body>
</html>