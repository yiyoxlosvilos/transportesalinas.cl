<?php
  session_start();
  require_once __dir__."/../../../controlador/controlador.php";
  require_once __dir__."/../../../controlador/productosControlador.php";
  require_once __dir__."/../../../controlador/recursosControlador.php";
  require_once __dir__."/../../../controlador/utilidadesControlador.php";
  require_once __dir__."/../../../recursos/head.php";

  $productos   = new Productos();
  $recursos    = new Recursos();
  $utilidades  = new Utilidades();
  $mvc2        = new controlador();

  $dia         = Utilidades::fecha_dia();
  $mes         = Utilidades::fecha_mes();
  $ano         = Utilidades::fecha_ano();
  $hoy         = Utilidades::fecha_hoy();

  $idUser      = $_SESSION['IDUSER'];
  $idSucursal  = $_SESSION['IDSUCURSAL'];
?>
<script src="<?= controlador::$rutaAPP ?>app/vistas/finanzas/asset/js/js.js?v=<?= rand() ?>"></script>
<link href="<?= controlador::$rutaAPP ?>app/vistas/finanzas/asset/css/css.css?v=<?= rand() ?>" rel="stylesheet" type="text/css" />
<input type="hidden" name="url_link" id="url_link" value="<?= controlador::$rutaAPP ?>">
<div class="row mb-4">
  <p align="left" class="text-success font-weight-light h3">Nueva Meta</p>
  <hr class="mt-2 mb-3"/>
    <div class="container mb-4">
      <div class="row">
        <div class="col-lg-5 mb-2">
          <label for="inputNumero"><b>Mes Meta:</b></label>
          
        </div>
        <div class="col-lg-5 mb-2">
          <?= Utilidades::select_agrupacion_cards_mensual('consultar_meta', 'meta_mes', $ano, 0) ?>
        </div>
        <div class="col-lg-5 mb-2">
          <label for="inputMonto"><b>Monto:</b></label>
        </div>
        <div class="col-lg-5 mb-2">
          <input type="number" class="form-control shadow" id="inputMonto" placeholder="Escribir Monto" autocomplete="off">
        </div>
        <div class="col-lg-5 mb-2"></div>
        <div class="col-lg-15">
          <label for="inputSucursal"><b>Descripción</b></label>
            <span id="validador_curso"></span>
            <textarea class="form-control shadow" id="inputDescripcion" rows="5"></textarea>
        </div>
        <div class="col-lg-2 mb-2">
          <label for="inputTipo" id="resultado_meta">&nbsp;</label>
          <button type="button" id="grabar" class="btn btn-primary form-control shadow" onclick="grabar_nueva_meta(<?= $idUser ?>)">Grabar <i class="bi bi-save"></i></button>
        </div>
      </div>
    </div>
</div>