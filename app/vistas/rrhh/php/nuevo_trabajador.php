<?php
  require_once __dir__."/../../../controlador/controlador.php";
  require_once __dir__."/../../../controlador/productosControlador.php";
  require_once __dir__."/../../../controlador/utilidadesControlador.php";
  require_once __dir__."/../../../controlador/recursosControlador.php";
  require_once __dir__."/../../../recursos/head.php";

  $productos   = new Productos();
  $recursos    = new Recursos();
  $utilidades  = new Utilidades();
  $mvc         = new controlador();

  $dia         = Utilidades::fecha_dia();
  $mes         = Utilidades::fecha_mes();
  $ano         = Utilidades::fecha_ano();
  $hoy         = Utilidades::fecha_hoy();
?>
<script src="<?= controlador::$rutaAPP ?>app/vistas/rrhh/asset/js/js.js?v=<?= rand() ?>"></script>
<link href="<?= controlador::$rutaAPP ?>app/vistas/rrhh/asset/css/css.css?v=<?= rand() ?>" rel="stylesheet" type="text/css" />
<input type="hidden" name="url_link" id="url_link" value="<?= controlador::$rutaAPP ?>">
<div class="row mb-4">
  <p align="left" class="text-success font-weight-light h3">Nuevo Trabajador</p>
  <hr class="mt-2 mb-3"/>
    <div class="container mb-4">
      <div class="row">
        <div class="col-lg-5 mb-2">
          <label for="inputNombre"><b>Nombre</b></label>
          <input type="text" class="form-control shadow" id="inputNombre" placeholder="Nombre" autocomplete="off" value="">
        </div>
        <div class="col-lg-5 mb-2">
            <label for="inputNombre"><b>Rut</b>&nbsp;&nbsp;&nbsp;<span id="validar_rut"></span></label>
            <input type="text" class="form-control shadow" id="inputRut" placeholder="Rut" autocomplete="off" onchange="validar_rut('finanzas')" value="">
        </div>
        <div class="col-lg-5 mb-2">
            <label for="inputTelefono"><b>Tel&eacute;fono</b>&nbsp;&nbsp;&nbsp;<small>si no tiene ingresar un 0</small></label>
            <input type="number" class="form-control shadow" id="inputTelefono" placeholder="Telefono" autocomplete="off" value="">
        </div>
        <div class="col-lg-5 mb-2">
            <label for="inputEmail"><b>E-Mail</b>&nbsp;&nbsp;&nbsp;<small>si no tiene ingresar un 0</small></label>
            <input type="text" class="form-control shadow" id="inputEmail" placeholder="E-Mail" autocomplete="off" value="">
        </div>
        <div class="col-lg-5 mb-2">
          <label for="inputSueldo"><b>Sueldo Base</b></label>
            <input type="number" class="form-control shadow" id="inputSueldo" placeholder="Escribir Sueldo" value="">
        </div>
        <div class="col-lg-5 mb-2">
          <label for="inputCargo"><b>Cargo</b></label>
          <input type="text" class="form-control shadow" id="inputCargo" placeholder="Escribir Cargo" autocomplete="off" value="">
        </div>
        <div class="col-lg-5 mb-2">
          <label for="inputEmpresa"><b>Empresa</b></label>
            <?= $recursos->select_empresas('', 0); ?>
        </div>
        <div class="col-lg-5 mb-2">
          <label for="inputCategoria"><b>Tipo Contrato</b></label>
            <?= $recursos->select_tipo_contrato('comprobar_contrato', 0); ?>
        </div>
        <div class="col-lg-5 mb-2">
          <label for="inputIngreso"><b>Ingreso</b></label>
          <input type="date" class="form-control shadow" id="inputIngreso" placeholder="Nombre" autocomplete="off" value="<?= $hoy ?>">
        </div>
        <div class="col-lg-5 mb-2" id="fin_contrato" style="display:none;">
          <label for="inputFin"><b>Fin Contrato</b></label>
          <input type="date" class="form-control shadow" id="inputFin" placeholder="Nombre" autocomplete="off" value="<?= $hoy ?>">
        </div>
        <div class="col-lg-5 mb-2">
          <label for="inputTipo">&nbsp;</label>
          <button type="button" id="grabar" class="btn btn-primary form-control shadow" onclick="grabar_trabajador()">Grabar <i class="bi bi-save"></i></button>
        </div>
      </div>
    </div>
</div>