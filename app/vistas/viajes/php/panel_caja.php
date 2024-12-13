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

  $codigo = "SERV-".$recursos->conteo_servicios();
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
  <div class="d-flex flex-wrap align-items-center">
    <span class="h2 animate__animated animate__pulse"><i class="fas fa-handshake text-success"></i> <span class="ocultar text-success">Nuevo Servicio</span></span>
  </div>
  <hr class="mt-2 mb-3"/>
  <div class="col-lg-15 p-2 mt-1 mb-2 ml-2 animate__animated animate__fadeIn border" id="panel_caja">
    <input type="hidden" name="id_usuario" id="id_usuario" value="<?= $idCli ?>">
    <div class="entero7 ">
      <table width="100%" align="center" cellpadding="4" cellspacing="4" class="table table-striped">
        <tr>
          <td  class="bold"><b>C&oacute;digo Servicio:</b>
            <input type="text" name="codigo_servicio" id="codigo_servicio" value="<?= $codigo ?>" class="form-control  bg-white">
          </td>
          <td  class="bold"><b>Seleccionar Cotizaci&oacute;n:</b>
            <?= $recursos->select_cotizaciones() ?>
          </td>
        </tr>
        <tr>
          <td  class="bold"><b>Inicio Servicio:</b>
            <input type="date" name="fecha_inicio" id="fecha_inicio" value="<?= Utilidades::fecha_hoy() ?>" class="form-control ">
          </td>
          <td  class="bold"><b>Termino Servicio:</b>
            <input type="date" name="fecha_termino" id="fecha_termino" value="<?= Utilidades::fecha_hoy() ?>" class="form-control ">
          </td>
        </tr>
        <tr>
          <td colspan="2" class="bold"><b>Descripci&oacute;n:</b>
            <textarea name="comentario_servicio" id="comentario_servicio" class="form-control "></textarea>
          </td>
        </tr>
      </table>
    </div>
    <div class="entero7 " id="listar_productos"></div>
    <div class="entero ">
      <table  align="center">
        <tr>
          <td align="center">
            <button type="button" id="grabar" class="btn btn-primary form-control shadow" onclick="crear_servicio()">Crear <i class="bi bi-save"></i></button>
          </td>
        </tr>
      </table>
    </div>
  </div>
</div>
<script>
  $(document).ready(function() { 
    var multipleCancelButton = new Choices("#clientes", {
          removeItemButton: true,
      });
  });
</script>
