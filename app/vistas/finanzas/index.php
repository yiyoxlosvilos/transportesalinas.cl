<?php
  require_once __dir__."/../../controlador/finanzasControlador.php";
  require_once __dir__."/../../controlador/utilidadesControlador.php";
  require_once __dir__."/../../recursos/head.php";

  $finanzas  = new Finanzas();
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
<script src="<?= controlador::$rutaAPP ?>app/vistas/finanzas/asset/js/js.js?v=<?= rand() ?>"></script>
<link href="<?= controlador::$rutaAPP ?>app/vistas/finanzas/asset/css/css.css?v=<?= rand() ?>" rel="stylesheet" type="text/css" />
<input type="hidden" name="url_link" id="url_link" value="<?= controlador::$rutaAPP ?>">
<!DOCTYPE html>
<html>
<body id="body-pd">
  <div class="row paddingtop40px mt-5 mb-4">
    <div class="card-block text-center">
      <!--<button class="btn btn-primary" onclick="location.reload()">Pagos Pendientes&nbsp;&nbsp;<i class="bi bi-wallet2"></i></button>-->
      <button class="btn btn-success bg-gradient" onclick="gastos_empresa()">Gastos Empresa&nbsp;&nbsp;<i class="bi bi-credit-card"></i></button>
      <button class="btn btn-info bg-gradient" onclick="facturas_proveedores()">Facturas Proveedores&nbsp;&nbsp;<i class="bi bi-cash-stack"></i></button>
      <button hidden class="btn btn-primary bg-gradient" onclick="facturas_clientes_panel()">Facturas Clientes&nbsp;&nbsp;<i class="bi bi-cash-stack"></i></button>
      <button class="btn btn-danger bg-gradient" onclick="metas_ventas()">Metas&nbsp;&nbsp;<i class="bi bi-speedometer"></i></button>
    </div>
    <hr class="mt-2 mb-3"/>
    <div class="row overflow-auto" id="traer_finanzas">
      <?= $finanzas->gastos_empresa($mes, $ano, '') ?>
    </div>
  </div>
</body>
</html>