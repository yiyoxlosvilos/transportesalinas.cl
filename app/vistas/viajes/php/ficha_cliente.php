<?php
  require_once __dir__."/../../../controlador/controlador.php";
  require_once __dir__."/../../../controlador/rrhhControlador.php";
  require_once __dir__."/../../../controlador/centroCostoControlador.php";
  require_once __dir__."/../../../controlador/recursosControlador.php";
  require_once __dir__."/../../../controlador/utilidadesControlador.php";
  require_once __dir__."/../../../recursos/head.php";

  $rrhh        = new Rrhh();
  $utilidades  = new Utilidades();
  $recursos    = new Recursos();
  $centroCostos= new CentroCostos();
  $mvc2        = new controlador();
  $mvc2->iniciar_sesion();

  $dia         = Utilidades::fecha_dia();
  $mes         = Utilidades::fecha_mes();
  $ano         = Utilidades::fecha_ano();
  $hoy         = Utilidades::fecha_hoy();

  $idCliente   = $_REQUEST['idCliente'];
?>
<script src="<?= controlador::$rutaAPP ?>app/vistas/centro_costo/asset/js/js.js?v=<?= rand() ?>"></script>
<script src="<?= controlador::$rutaAPP ?>app/vistas/rrhh/asset/js/js.js?v=<?= rand() ?>"></script>
<script src="<?= controlador::$rutaAPP ?>app/vistas/centro_costo/asset/js/upload.js?v=<?= rand() ?>"></script>
<link href="<?= controlador::$rutaAPP ?>app/vistas/rrhh/asset/css/css.css?v=<?= rand() ?>" rel="stylesheet" type="text/css" />
<link href="<?= controlador::$rutaAPP ?>app/recursos/css/upload.css?v=<?= rand() ?>" rel="stylesheet" type="text/css" />

<input type="hidden" name="url_link" id="url_link" value="<?= controlador::$rutaAPP ?>">
<input type="hidden" name="idCliente" id="idCliente" value="<?= $idCliente ?>">
<div class="row">
  <p align="left" class="text-success font-weight-light h3">Panel Cliente</p>
  <hr class="mt-2 mb-3"/>
  <div class="col-xl-12 col-md-12 mb-4 animate__animated animate__fadeIn">
    <div class="container mb-4" id="editar_trabajador">
      <?= $centroCostos->card_info_cliente($idCliente) ?>
    </div>
  </div>
</div>