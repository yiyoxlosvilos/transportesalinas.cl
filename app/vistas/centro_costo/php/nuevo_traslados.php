<?php
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

  $idServicio  = $_REQUEST['idServicio'];
?>
<script src="<?= controlador::$rutaAPP ?>app/vistas/centro_costo/asset/js/js.js?v=<?= rand() ?>"></script>
<link href="<?= controlador::$rutaAPP ?>app/vistas/centro_costo/asset/css/css.css?v=<?= rand() ?>" rel="stylesheet" type="text/css" />

<link rel="stylesheet" href="<?= controlador::$rutaAPP ?>app/recursos/css/choices.css?v=<?= rand() ?>">
<script src="<?= controlador::$rutaAPP ?>app/recursos/js/choice.js?v=<?= rand() ?>"></script>

<input type="hidden" name="url_link" id="url_link" value="<?= controlador::$rutaAPP ?>">
<div class="row mb-4">
  <p align="left" class="text-info font-weight-light h3"><i class="fas fa-bus text-info"></i>&nbsp;&nbsp; Ingresar nuevo traslado</p>
  <hr class="mt-2 mb-3"/>
    <div class="container mb-4 shadow p-4">
      <div class="row">
        <div class="col-lg-4 p-3 mb-2 bg-white  border">
          <h6>* Origen:</h6>
          <span class="text-dark">
          <?= $recursos->seleccionar_localidad(0, 'inputOrigen', 0) ?>
          </span>
        </div>
        <div class="col-lg-4 p-3 mb-2 bg-white  border">
          <h6>* Destino:</h6>
          <span class="text-dark">
          <?= $recursos->seleccionar_localidad(0, 'inputDestino', 0) ?>
          </span>
        </div>
        <div class="col-lg-4 p-3 mb-2 bg-white  border">
          <h6>Regreso:</h6>
          <span class="text-dark">
          <?= $recursos->seleccionar_localidad(0, 'inputRegreso', 0) ?>
          </span>
        </div>
        <div class="col-lg-6 mb-2 p-3 border">
          <label for="inputPrecio"><b>* Valor:</b></label>
            <input type="number" class="form-control shadow" id="inputValor" placeholder="Escribir Valor">
        </div>
        <div class="col-lg-6 mb-2 p-3 border">
          <label for="inputPrecio"><b>* Cantidad:</b></label>
            <input type="number" class="form-control shadow" id="inputCantidad" placeholder="Escribir Cantidad" onchange="agregar_fechas()">
        </div>
        <div class="col-lg-15 mb-2 p-3 border">
          <label for="inputMarca"><b>* Fecha/as:</b></label>
          <div class="row" id="cantidad_fechas"></div>
        </div>
        <div class="col-lg-15 p-3 border">
          <label for="inputSucursal"><b>Descripción</b></label>
            <span id="validador_curso"></span>
            <textarea class="form-control shadow" id="inputDescripcion" rows="5"></textarea>
        </div>
        <div class="col-lg-2 mb-2">
          <label for="inputTipo">&nbsp;</label>
          <button type="button" id="grabar" class="btn btn-primary form-control shadow" onclick="grabar_nuevo_traslado(<?= $idServicio ?>)">Grabar <i class="bi bi-save"></i></button>
        </div>
      </div>
    </div>
</div>
<script>
  $(document).ready(function() { 
    var multipleCancelButton = new Choices("#inputOrigen", {
      removeItemButton: true,
    });
  });
  $(document).ready(function() { 
    var multipleCancelButton = new Choices("#inputDestino", {
      removeItemButton: true,
    });
  });
  $(document).ready(function() { 
    var multipleCancelButton = new Choices("#inputRegreso", {
      removeItemButton: true,
    });
  });
</script>