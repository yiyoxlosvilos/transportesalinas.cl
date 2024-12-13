<?php
  session_start();
  require_once __dir__."/../../../controlador/controlador.php";
  $mvc         = new controlador();

  require_once __dir__."/../../../controlador/ventasControlador.php";
  require_once __dir__."/../../../controlador/recursosControlador.php";
  require_once __dir__."/../../../controlador/utilidadesControlador.php";
  require_once __dir__."/../../../recursos/head.php";

  $ventas      = new Ventas();
  $utilidades  = new Utilidades();
  $recursos    = new Recursos();

  $dia         = Utilidades::fecha_dia();
  $mes         = Utilidades::fecha_mes();
  $ano         = Utilidades::fecha_ano();
  $hoy         = Utilidades::fecha_hoy();

  $idUser      = $_SESSION['IDUSER'];
  $idSucursal  = $_SESSION['IDSUCURSAL'];
?>
<script src="<?= controlador::$rutaAPP ?>app/vistas/centro_costo/asset/js/js.js?v=<?= rand() ?>"></script>
<link href="<?= controlador::$rutaAPP ?>app/vistas/centro_costo/asset/css/css.css?v=<?= rand() ?>" rel="stylesheet" type="text/css" />

<script src="<?= controlador::$rutaAPP ?>app/recursos/js/table.js?v=<?= rand() ?>"></script>
<link href="<?= controlador::$rutaAPP ?>app/recursos/css/table.css?v=<?= rand() ?>" rel="stylesheet" type="text/css" />

<link rel="stylesheet" href="<?= controlador::$rutaAPP ?>app/recursos/css/choices.css?v=<?= rand() ?>">
<script src="<?= controlador::$rutaAPP ?>app/recursos/js/choice.js?v=<?= rand() ?>"></script>

<input type="hidden" name="url_link" id="url_link" value="<?= controlador::$rutaAPP ?>">
<input type="hidden" name="idSucursal" id="idSucursal" value="<?= $idSucursal ?>">
<input type="hidden" name="idUser" id="idUser" value="<?= $idUser ?>">

<div class="row" id="procesar_venta">
  <div class="d-flex flex-wrap align-items-center mb-4">
    <span class="h2 animate__animated animate__pulse"><i class="bi bi-search"></i> <span class="ocultar">Panel Cliente</span></span>
    <div class="ms-auto">
      <button class="btn btn-success" onclick="nuevo_cliente_control()"><i class="bi bi-person-bounding-box h4 text-white"></i> <span class="ocultar">Nuevo</span></button>
    </div>
  </div>
  <hr class="mt-2 mb-3"/>
  <div class="col-lg-15 p-2 mt-2 mb-2 ml-2 animate__animated animate__fadeIn shadow" id="panel_caja">
    <?= $recursos->traer_clientes_consulta(); ?>
  </div>
</div>
<script>
  $(document).ready(function() {
    $("#clientes_list").DataTable({     
        "aLengthMenu": [[10, 20, 30, -1], [10, 20, 30, "Todos"]],
          "iDisplayLength": 20
         });
  });
</script>
