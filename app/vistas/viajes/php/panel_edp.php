<?php
  session_start();
  require_once __dir__."/../../../controlador/controlador.php";
  $mvc         = new controlador();

  require_once __dir__."/../../../controlador/centroCostoControlador.php";
  require_once __dir__."/../../../controlador/recursosControlador.php";
  require_once __dir__."/../../../controlador/utilidadesControlador.php";
  require_once __dir__."/../../../recursos/head.php";

  $centroCostos    = new CentroCostos();
  $utilidades      = new Utilidades();
  $recursos        = new Recursos();

  $dia             = Utilidades::fecha_dia();
  $mes             = Utilidades::fecha_mes();
  $ano             = Utilidades::fecha_ano();
  $hoy             = Utilidades::fecha_hoy();

  $idEstadoPago    = $_REQUEST['idEstadoPago'];
  $datos_serv      = $centroCostos->datos_edp_id($idEstadoPago);
  $datos_servicios = $centroCostos->data_id_pago_servicios($idEstadoPago);
  $datos_clientes  = $centroCostos->data_servicio_edp($idEstadoPago);
  $primer_servicio = $centroCostos->primer_servicio($datos_servicios);
  $ultimo_servicio = $centroCostos->ultimo_servicio($datos_servicios);
?>

<script src="<?= controlador::$rutaAPP ?>app/vistas/centro_costo/asset/js/js.js?v=<?= rand() ?>"></script>
<link href="<?= controlador::$rutaAPP ?>app/vistas/centro_costo/asset/css/css.css?v=<?= rand() ?>" rel="stylesheet" type="text/css" />

<script src="<?= controlador::$rutaAPP ?>app/recursos/js/table.js?v=<?= rand() ?>"></script>
<link href="<?= controlador::$rutaAPP ?>app/recursos/css/table.css?v=<?= rand() ?>" rel="stylesheet" type="text/css" />

<link rel="stylesheet" href="<?= controlador::$rutaAPP ?>app/recursos/css/choices.css?v=<?= rand() ?>">
<script src="<?= controlador::$rutaAPP ?>app/recursos/js/choice.js?v=<?= rand() ?>"></script>

<script src="<?= controlador::$rutaAPP ?>app/vistas/centro_costo/asset/js/upload.js?v=<?= rand() ?>"></script>
<link href="<?= controlador::$rutaAPP ?>app/recursos/css/upload.css?v=<?= rand() ?>" rel="stylesheet" type="text/css" />

<input type="hidden" name="url_link" id="url_link" value="<?= controlador::$rutaAPP ?>">
<input type="hidden" name="idEstadoPago" id="idEstadoPago" value="<?= $idEstadoPago ?>">

<div class="row p-2 mt-2 mb-2 ml-2 animate__animated animate__fadeIn" id="traer_menu">
  <h3 class="mb-3">Estado de Pago N&deg;: <span class="text-success"><?= $datos_serv[0]['edp_codigo'] ?></span> </h3>
  <div class="col-md-12 col-xl-5 bg-soft-light">
    <div class="row m-2 pt-5" id="editar_edp">
      <h3 class="text-center text-primary">Procesar Pago</h3>
      <div class="col-6 border"><h6>Empresa:<br><span class="text-info"><?= $datos_clientes[0]['cli_nombre'] ?></span></h6></div>
      <div class="col-6 border"><h6>Rut:<br><span class="text-info"><?= Utilidades::rut($datos_clientes[0]['cli_rut']) ?></span></h6></div>
      <div class="col-6 border"><h6>Fecha Creaci&oacute;n:<br><span class="text-info"><?= Utilidades::arreglo_fecha2($datos_serv[0]['edp_creacion']) ?></span></h6></div>
      <div class="col-6 border"><h6>Fecha de pago<br><span class="text-info"><?= Utilidades::arreglo_fecha2($datos_serv[0]['edp_fecha_pago']) ?></span></h6></div>
      <div class="col-6 mt-2"><h6>Fecha Pagado</h6><input type="date" class="form-control border" name="fecha_pago" id="fecha_pago" value="<?= Utilidades::fecha_hoy() ?>"></div>
      <div class="col-6 mt-2"><h6>Glosa</h6><input type="text" class="form-control border" name="glosa" id="glosa" placeholder="Escribir Glosa..."></div>
      <div class="row mt-3">
        <div class="col">
          <button type="button" id="grabar" class="btn btn-success form-control shadow" onclick="finalizar_edp()">Realizar&nbsp;Pago&nbsp;<i class="bi bi-check-square-fill text-white"></i></button>
        </div>
        <div class="col">
          <button type="button" id="grabar" class="btn btn-info form-control shadow" onclick="editar_edp(<?= $idEstadoPago ?>)">Editar&nbsp;EDP&nbsp;<i class="mdi mdi-clipboard-edit-outlinemdi mdi-clipboard-edit-outline text-white"></i></button>
        </div>
        <div class="col">
          <button type="button" id="grabar" class="btn btn-danger form-control shadow" onclick="eliminar_edp(<?= $idEstadoPago ?>)">Eliminar&nbsp;EDP&nbsp;<i class="bi bi-x-octagon-fill text-white"></i></button>
        </div>
      </div>
    </div>
  </div>
  <div class="col-md-12 col-xl-7 ">
    <div class="row">
      <div class="row nav nav-pills navbar navbar-expand-lg navbar-light " id="v-pills-tab" aria-orientation="horizontal" role="tablist">
        <div class="nav-link  col text-center active" data-bs-toggle="tab" href="#home1" role="tab">
            <span class="bi bi-receipt cursor">&nbsp;&nbsp;Detalles Servicios</span>
          </div>
          <div class="nav-link col  text-center" data-bs-toggle="tab" href="#profile1" role="tab">
            <span class="bi bi-truck cursor">&nbsp;&nbsp;Detalles EDP</span>
          </div>
          <div class="nav-link col  text-center" data-bs-toggle="tab" href="#messages1" role="tab">
            <span class="bi bi-file-earmark-pdf-fill cursor">&nbsp;&nbsp;Documentos EDP</span>
          </div>
      </div>
      <div class="tab-content" id="v-pills-tabContent">
        <div class="tab-pane active" id="home1" role="tabpanel">
          <div class="d-flex flex-wrap align-items-center mb-4">
            <h3 class="text-center text-primary mb-2"><span class="bi bi-receipt"></span> Detalles Servicios</h3>
          </div>
          <?= $centroCostos->servicios_edp($idEstadoPago) ?>
        </div>
        <div class="tab-pane" id="profile1" role="tabpanel">
          <div class="d-flex flex-wrap align-items-center mb-4">
            <h3 class="text-center text-primary mb-2"><span class="bi bi-truck"></span> Detalles EDP</h3>
          </div>
          <?= $centroCostos->estado_pago_servicios($idEstadoPago) ?>
        </div>
        <div class="tab-pane" id="messages1" role="tabpanel">
          <div class="d-flex flex-wrap align-items-center mb-4">
            <h3 class="text-center text-primary mb-2"><span class="bi bi-file-earmark-pdf-fill"></span> Documentos EDP</h3>
            <div class="ms-auto">
              <button class="btn btn-success d-flex justify-content-center" onclick="nuevo_documento_edp(<?= $idEstadoPago ?>)">Nuevo&nbsp;&nbsp;&nbsp;<i class="bi bi-filetype-pdf"></i></button>
            </div>
          </div>
          <div class="row" id="panel_documentos"><?= $centroCostos->traer_documentos_edp($idEstadoPago); ?></div>
        </div>
      </div>
    </div>
  </div>
</div>