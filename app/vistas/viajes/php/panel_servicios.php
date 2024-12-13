<?php
  session_start();
  require_once __dir__."/../../../controlador/controlador.php";
  $mvc         = new controlador();

  require_once __dir__."/../../../controlador/centroCostoControlador.php";
  require_once __dir__."/../../../controlador/recursosControlador.php";
  require_once __dir__."/../../../controlador/utilidadesControlador.php";
  require_once __dir__."/../../../recursos/head.php";

  //error_reporting(E_ALL);
    ///ini_set('display_errors', 1);

  $centroCostos= new CentroCostos();
  $utilidades  = new Utilidades();
  $recursos    = new Recursos();

  $dia         = Utilidades::fecha_dia();
  $mes         = Utilidades::fecha_mes();
  $ano         = Utilidades::fecha_ano();
  $hoy         = Utilidades::fecha_hoy();

  $idServicio      = $_REQUEST['idServicio'];
  $datos_servicios = $centroCostos->datos_servicios($idServicio);
?>
<script src="<?= controlador::$rutaAPP ?>app/vistas/centro_costo/asset/js/js.js?v=<?= rand() ?>"></script>
<link href="<?= controlador::$rutaAPP ?>app/vistas/centro_costo/asset/css/css.css?v=<?= rand() ?>" rel="stylesheet" type="text/css" />

<script src="<?= controlador::$rutaAPP ?>app/recursos/js/table.js?v=<?= rand() ?>"></script>
<link href="<?= controlador::$rutaAPP ?>app/recursos/css/table.css?v=<?= rand() ?>" rel="stylesheet" type="text/css" />

<link rel="stylesheet" href="<?= controlador::$rutaAPP ?>app/recursos/css/choices.css?v=<?= rand() ?>">
<script src="<?= controlador::$rutaAPP ?>app/recursos/js/choice.js?v=<?= rand() ?>"></script>

<input type="hidden" name="url_link" id="url_link" value="<?= controlador::$rutaAPP ?>">
<input type="hidden" name="idServicio" id="idServicio" value="<?= $idServicio ?>">

<div class="row" id="procesar_venta">
  <div class="d-flex flex-wrap align-items-center mb-4">
    <span class="h2 animate__animated animate__pulse"><i class="bi bi-bookmark ocultar"></i> <span class="cursor" onclick="location.reload()"><?= $datos_servicios[0]['serv_codigo'] ?></span></span>
    <div class="ms-auto">
      <button class="btn btn-soft-light waves-effect waves-light" onclick="location.reload()"><i class="fas fa-home h4 text-info"></i> <span class="ocultar"></span></button>
    </div>
    <div class="ms-auto">
      <button class="btn btn-danger" onclick="traer_menu('asignar_producto')"><i class="fas fa-truck-moving h4 text-white"></i> <span class="ocultar">Fletes</span></button>
    </div>
    <div class="ms-auto">
      <button class="btn btn-info" onclick="asignar_traslados()"><i class="fas fa-bus h4 text-white"></i> <span class="ocultar">Traslados</span></button>
    </div>
    <div class="ms-auto">
      <button class="btn btn-primary" onclick="asignar_arriendo()"><i class="fas fa-truck h4 text-white"></i> <span class="ocultar">Arriendos</span></button>
    </div>
    <div class="ms-auto">
      <button class="btn btn-dark" onclick="gastos_empresa()"><i class="fas fa-dollar-sign h4 text-white"></i> <span class="ocultar">Gastos</span></button>
    </div>
    <div class="ms-auto">
      <button class="btn btn-success" onclick="facturas_proveedores()"><i class="fas fa-receipt h4 text-white"></i> <span class="ocultar">Facturas Proveedores</span></button>
    </div>
    <div class="ms-auto">
      <button class="btn btn-warning" onclick="facturas_clientes()"><i class="fas fa-receipt h4 text-white"></i> <span class="ocultar">Facturas Clientes</span></button>
    </div>
  </div>
  <hr class="m-1"/>
  <div class="row p-2 mb-2 ml-2 animate__animated animate__fadeIn" id="traer_menu">
    <?= $centroCostos->mostrar_detalle_servicio_informe($idServicio) ?>
  </div>
</div>
