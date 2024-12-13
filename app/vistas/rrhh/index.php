<?php
  require_once __dir__."/../../controlador/bodegaControlador.php";
  require_once __dir__."/../../controlador/rrhhControlador.php";
  require_once __dir__."/../../controlador/utilidadesControlador.php";
  require_once __dir__."/../../recursos/head.php";

  $rrhh        = new Rrhh();
  $utilidades  = new Utilidades();
  $mvc2        = new controlador();
  $mvc2->iniciar_sesion();

	$dia         = Utilidades::fecha_dia();
	$mes         = Utilidades::fecha_mes();
  $ano         = Utilidades::fecha_ano();
  $hoy         = Utilidades::fecha_hoy();

  // MENU
  $mvc2->menu_usuarios();
?>
<script src="<?= controlador::$rutaAPP ?>app/recursos/js/table.js?v=<?= rand() ?>"></script>
<link href="<?= controlador::$rutaAPP ?>app/recursos/css/table.css?v=<?= rand() ?>" rel="stylesheet" type="text/css" />

<script src="<?= controlador::$rutaAPP ?>app/vistas/rrhh/asset/js/js.js?v=<?= rand() ?>"></script>
<script src="<?= controlador::$rutaAPP ?>app/vistas/rrhh/asset/js/progress.js?v=<?= rand() ?>"></script>
<link href="<?= controlador::$rutaAPP ?>app/vistas/rrhh/asset/css/css.css?v=<?= rand() ?>" rel="stylesheet" type="text/css" />

<input type="hidden" name="url_link" id="url_link" value="<?= controlador::$rutaAPP ?>">
<!DOCTYPE html>
<html>
<body id="body-pd">
  <div class="row paddingtop40px mt-5">
    <div class="card-block text-center">
      <button class="btn btn-success" type="button" onclick="location.reload()">
              Trabajadores&nbsp;&nbsp;&nbsp;<i class="bi bi-people-fill"></i>
      </button>
      <button class="btn btn-warning" type="button" href="<?= controlador::$rutaAPP ?>app/vistas/rrhh/php/simulador_sueldo.php" data-fancybox data-type="iframe" data-preload="true" data-width="100%" data-height="1200">
              Simulador&nbsp;&nbsp;&nbsp;<i class="bi bi-joystick"></i>
      </button>
      <button class="btn btn-info" type="button" onclick="liquidaciones_ver()">
              Liquidaciones&nbsp;&nbsp;&nbsp;<i class="bi bi-journal-check"></i>
      </button>
      <button class="btn btn-primary" type="button" onclick="vacaciones_ver()">
              Vacaciones&nbsp;&nbsp;&nbsp;<i class="bi  bi-sunglasses"></i>
      </button>
      <button class="btn btn-info" type="button" onclick="finiquitos_ver()">
              Finiquitos&nbsp;&nbsp;&nbsp;<i class="bi bi-journal-x"></i>
      </button>
      <button class="btn btn-dark" type="button" onclick="configuraciones_ver()">
              Configuraciones&nbsp;&nbsp;&nbsp;<i class="bi bi-gear-wide-connected"></i>
      </button>
    </div>
    <hr class="mt-2 mb-3"/>

<!-- LISTADOS DE PRODUCTOS -->
    <div class="row overflow-auto" id="panel_rrhh">
      <?= $rrhh->traer_trabajadores() ?>
    </div>
  </div>
</body>
</html>
<script>
  initCounterNumber();
  initCounterPorcent();
</script>