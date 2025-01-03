<?php
  require_once __dir__."/../../../controlador/controlador.php";
  require_once __dir__."/../../../controlador/productosControlador.php";
  require_once __dir__."/../../../controlador/recursosControlador.php";
  require_once __dir__."/../../../controlador/utilidadesControlador.php";


  $productos   = new Productos();
  $recursos    = new Recursos();
  $utilidades  = new Utilidades();
  $mvc2        = new controlador();

  $dia         = Utilidades::fecha_dia();
  $mes         = Utilidades::fecha_mes();
  $ano         = Utilidades::fecha_ano();
  $hoy         = Utilidades::fecha_hoy();

  $idServicio  = $_REQUEST['idServicio'];
?>
<script src="<?= controlador::$rutaAPP ?>app/vistas/finanzas/asset/js/js.js?v=<?= rand() ?>"></script>
<link href="<?= controlador::$rutaAPP ?>app/vistas/finanzas/asset/css/css.css?v=<?= rand() ?>" rel="stylesheet" type="text/css" />
<input type="hidden" name="url_link" id="url_link" value="<?= controlador::$rutaAPP ?>">
<div class="row mb-4">
  <p align="left" class="text-success font-weight-light h3">Ingresar Gasto</p>
  <hr class="mt-2 mb-3"/>
    <div class="container mb-4">
      <div class="row">
        <div class="col-lg-5 mb-2">
          <label for="inputNombre"><b>Nombre Gasto</b></label>
          <input type="text" class="form-control shadow" id="inputNombre" placeholder="Escribir Nombre" autocomplete="off">
        </div>
        <div class="col-lg-5 mb-2">
          <label for="inputPrecio"><b>Monto Gasto</b></label>
            <input type="number" class="form-control shadow" id="inputPrecio" placeholder="Escribir Monto">
        </div>
        <div class="col-lg-5 mb-2">
          <label for="inputMarca"><b>Categoría Gasto</b></label>
          <?= $recursos->select_tipo_gastos('combo_select_categoria', 0); ?>
        </div>

        <div class="col-lg-5 mb-2" id="tipo_gastos_ver">
          <label for="inputMarca"><b>Tipo Gasto</b></label>
          <select id="tipo_gastos_categorias" class="form-control shadow">
            <option value="0" selected="selected">Seleccionar Tipo</option>
          </select>
        </div>
        <div class="col-lg-5 mb-2">
          <label for="inputSucursal"><b>Sucursal</b></label>
            <span id="validador_curso"></span>
            <?= $productos->seleccion_sucursal(0); ?>
        </div>
        <div class="col-lg-5 mb-2">
          <label for="inputSucursal"><b>Fecha Gasto</b></label>
            <span id="validador_curso"></span>
            <input type="date" class="form-control shadow" id="inputFecha" value="<?= $hoy ?>">
        </div>
        <div class="col-lg-15">
          <label for="inputSucursal"><b>Descripción</b></label>
            <span id="validador_curso"></span>
            <textarea class="form-control shadow" id="inputDescripcion" rows="5"></textarea>
        </div>
        <div class="col-lg-2 mb-2">
          <label for="inputTipo">&nbsp;</label>
          <button type="button" id="grabar" class="btn btn-primary form-control shadow" onclick="grabar_nuevo_gasto(<?= $idServicio ?>)">Grabar <i class="bi bi-save"></i></button>
        </div>
        <div class="col-lg-2 mb-2">
          <label for="inputTipo">&nbsp;</label>
          <button type="button" id="grabar" class="btn btn-dark form-control shadow" onclick="location.reload()">Cancelar <i class="bi bi-save"></i></button>
        </div>
      </div>
    </div>
</div>