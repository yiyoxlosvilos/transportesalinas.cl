<?php
  require_once __dir__."/../../../controlador/controlador.php";
  require_once __dir__."/../../../controlador/utilidadesControlador.php";
  require_once __dir__."/../../../controlador/recursosControlador.php";
  require_once __dir__."/../../../recursos/head.php";

  $recursos    = new Recursos();
  $utilidades  = new Utilidades();
  $mvc         = new controlador();

  $dia         = Utilidades::fecha_dia();
  $mes         = Utilidades::fecha_mes();
  $ano         = Utilidades::fecha_ano();
  $hoy         = Utilidades::fecha_hoy();
?>
<script src="<?= controlador::$rutaAPP ?>app/vistas/parametros/asset/js/js.js?v=<?= rand() ?>"></script>
<link href="<?= controlador::$rutaAPP ?>app/vistas/parametros/asset/css/css.css?v=<?= rand() ?>" rel="stylesheet" type="text/css" />
<input type="hidden" name="url_link" id="url_link" value="<?= controlador::$rutaAPP ?>">
<div class="row mb-4">
  <p align="left" class="text-success font-weight-light h3">Nuevo Usuario</p>
  <hr class="mt-2 mb-3"/>
    <div class="container mb-4">
      <div class="row">
        <div class="col-lg-5 mb-2">
          <label for="inputNombre"><b>Nombre</b></label>
          <input type="text" class="form-control shadow" id="inputNombre" placeholder="Nombre" autocomplete="off">
        </div>
        <div class="col-lg-5 mb-2">
            <label for="inputNombre"><b>Rut</b>&nbsp;&nbsp;&nbsp;<span id="validar_rut"></span></label>
            <input type="text" class="form-control shadow" id="inputRut" placeholder="Rut" autocomplete="off" onchange="validar_rut('finanzas')">
        </div>
        <div class="col-lg-5 mb-2">
          <label for="inputSueldo"><b>E-Mail:</b></label>
            <input type="text" class="form-control shadow" id="inputEmail" placeholder="Escribir Sueldo">
        </div>
        <div class="col-lg-5 mb-2">
          <label for="inputCargo"><b>Contrase&ntilde;a</b></label>
          <input type="password" class="form-control shadow" id="inputContrasena" placeholder="Escribir Cargo" autocomplete="off">
        </div>
        <div class="col-lg-5 mb-2">
          <label for="inputCategoria"><b>Sucursal</b></label>
            <?= $recursos->select_sucursales(); ?>
        </div>
        <div class="col-lg-5 mb-2">
          <label for="inputIngreso"><b>Tipo Usuario</b></label>
          <?= $recursos->select_tipo_usuario() ?>
        </div>
        <div class="col-lg-5 mb-2">
          <label for="inputTipo">&nbsp;</label>
          <button type="button" id="grabar" class="btn btn-primary form-control shadow" onclick="grabar_usuario()">Grabar <i class="bi bi-save"></i></button>
        </div>
      </div>
    </div>
</div>