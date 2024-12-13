<?php
  require_once __dir__."/../../../controlador/controlador.php";
  $mvc         = new controlador();

  require_once __dir__."/../../../controlador/rrhhControlador.php";
  require_once __dir__."/../../../controlador/recursosControlador.php";
  require_once __dir__."/../../../controlador/utilidadesControlador.php";
  require_once __dir__."/../../../recursos/head.php";

  $rrhh        = new Rrhh();
  $utilidades  = new Utilidades();
  $recursos    = new Recursos();

  $dia         = Utilidades::fecha_dia();
  $mes         = Utilidades::fecha_mes();
  $ano         = Utilidades::fecha_ano();
  $hoy         = Utilidades::fecha_hoy();

  $idTrabajador= $_REQUEST['idTrabajador'];

?>
<script src="<?= controlador::$rutaAPP ?>app/vistas/rrhh/asset/js/js.js?v=<?= rand() ?>"></script>
<script src="<?= controlador::$rutaAPP ?>app/vistas/rrhh/asset/js/upload.js?v=<?= rand() ?>"></script>
<link href="<?= controlador::$rutaAPP ?>app/vistas/rrhh/asset/css/css.css?v=<?= rand() ?>" rel="stylesheet" type="text/css" />
<link href="<?= controlador::$rutaAPP ?>app/recursos/css/upload.css?v=<?= rand() ?>" rel="stylesheet" type="text/css" />

<input type="hidden" name="url_link" id="url_link" value="<?= controlador::$rutaAPP ?>">
<input type="hidden" name="idTrabajador" id="idTrabajador" value="<?= $idTrabajador ?>">
<div class="row">
  <p align="left" class="text-success font-weight-light h3">Panel Trabajador</p>
  <hr class="mt-2 mb-3"/>
  <div class="col-xl-6 col-md-6 mb-4 animate__animated animate__fadeIn">
    <div class="container mb-4" id="editar_trabajador">
      <?= $rrhh->card_info_trabajador($idTrabajador); ?>
    </div>
  </div>
  <div class="col-xl-6 col-md-6 mb-4 animate__animated animate__fadeIn animate__slow" >
    <div class="row mb-2">
        <div class="col-md-6 mb-2">
          <h3>Documentos.</h3>           
        </div>
        <div class="col-md-6 mb-2">
          <button class="btn btn-success d-flex justify-content-center bg-gradient" onclick="traer_nuevo_documento()">Nuevo&nbsp;&nbsp;&nbsp;<i class="bi bi-filetype-pdf"></i></button>
        </div>
        <div class="col-md-15 mb-2" id="panel_documentos">
          <?= $rrhh->traer_documentos_asociados($idTrabajador); ?>
        </div>
    </div>
  </div>
</div>