<?php
  require_once __dir__."/../../../controlador/controlador.php";
  require_once __dir__."/../../../controlador/productosControlador.php";
  require_once __dir__."/../../../controlador/recursosControlador.php";
  require_once __dir__."/../../../controlador/utilidadesControlador.php";
  require_once __dir__."/../../../controlador/centroCostoControlador.php";

  $productos   = new Productos();
  $recursos    = new Recursos();
  $utilidades  = new Utilidades();
  $mvc2        = new controlador();
  $centroCostos= new CentroCostos();

  $dia         = Utilidades::fecha_dia();
  $mes         = Utilidades::fecha_mes();
  $ano         = Utilidades::fecha_ano();
  $hoy         = Utilidades::fecha_hoy();

  $idArriendo      = $_REQUEST['idArriendo'];
  $datos_arriendos = $recursos->datos_arriendos_id($idArriendo);
?>
<script src="<?= controlador::$rutaAPP ?>app/vistas/centro_costo/asset/js/js.js?v=<?= rand() ?>"></script>
<link href="<?= controlador::$rutaAPP ?>app/vistas/centro_costo/asset/css/css.css?v=<?= rand() ?>" rel="stylesheet" type="text/css" />

<link rel="stylesheet" href="<?= controlador::$rutaAPP ?>app/recursos/css/choices.css?v=<?= rand() ?>">
<script src="<?= controlador::$rutaAPP ?>app/recursos/js/choice.js?v=<?= rand() ?>"></script>

<input type="hidden" name="url_link" id="url_link" value="<?= controlador::$rutaAPP ?>">
<div class="row mb-4">
  <p align="left" class="text-primary font-weight-light h3"><i class="fas fa-truck text-primary"></i>&nbsp;&nbsp; Editar arriendo</p>
  <hr class="mt-2 mb-3"/>
    <div class="mb-4 shadow p-4">
      <div class="row">
        <div class="col-lg-6 p-3 mb-2 bg-white  border">
          <label for="inputPrecio"><b>* Tipo de servicio:</b></label>
          <input type="text" class="form-control shadow" id="inputTipoServicio" placeholder="Escribir Tipo de servicio" value="<?= $datos_arriendos[0]['arriendo_tipo_servicio'] ?>">
        </div>
        <div class="col-lg-6 p-3 mb-2 bg-white  border">
          <label for="inputPrecio"><b>* Proyecto:</b></label>
          <input type="text" class="form-control shadow" id="inputProyecto" placeholder="Escribir nombre Proyecto" value="<?= $datos_arriendos[0]['arriendo_proyecto'] ?>">
        </div>
        <div class="col-lg-6 p-3 mb-2 bg-white  border">
          <label for="inputPrecio"><b>* Contacto:</b></label>
          <input type="text" class="form-control shadow" id="inputContacto" placeholder="Escribir Contacto" value="<?= $datos_arriendos[0]['arriendo_contacto'] ?>">
        </div>
        <div class="col-lg-6 p-3 mb-2 bg-white  border">
          <label for="inputPrecio"><b>* Mes servicio:</b></label>
          <?= Utilidades::select_agrupacion_cards_mes('', 'mes', $datos_arriendos[0]['arriendo_mes']) ?>
        </div>
        <div class="col-xxl-6 col-xl-4 col-sm-12 pt-3 ">
          <b>Estado de Pago:</b>
          <?= $recursos->select_tipos_estados_pagos($datos_arriendos[0]['arriendo_estado_pago']) ?>
        </div>
        <div class="col-xxl-6 col-xl-4 col-sm-12 pt-3 ">
          <h6>Fecha de Arriendo:</h6>
          <span class="text-dark">
            <input type="date" class="form-control shadow" id="inputFechaPago" value="<?= $datos_arriendos[0]['arriendo_fecha'] ?>" autocomplete="off" onchange="calcular_fecha_pago()">
            <span class="text-danger" id="respuesta-pago"></span>
            </span>
        </div>
        <div class="col-xxl-12 col-xl-12 col-sm-12 mb-4 ">
          <b>Cliente:</b>
          <?= $recursos->select_clientes($datos_arriendos[0]['arriendo_cliente']) ?>
        </div>
        <div class="col-lg-15 p-3 border">
          <label for="inputSucursal"><b>Descripción</b></label>
            <span id="validador_curso"></span>
            <textarea class="form-control shadow" id="inputDescripcion" rows="5"><?= $datos_arriendos[0]['arriendo_descripcion'] ?></textarea>
        </div>

        <div class="col-lg-15 p-3 border">
          <label for="inputSucursal"><b>Items cotizaci&oacute;n: <span class="fas fa-plus-circle text-success cursor" id="add" onclick="agregar_arriendo()"></span></b></label>
          <?= $centroCostos->mostrar_listado_de_arriendo_editar($idArriendo) ?>
        </div>
            
        <div class="col-lg-2 mb-2">
          <label for="inputTipo">&nbsp;</label>
          <button type="button" id="grabar" class="btn btn-primary form-control shadow" onclick="editar_arriendo(<?= $idArriendo ?>)">Editar<i class="bi bi-save"></i></button>
        </div>
      </div>
    </div>
</div>