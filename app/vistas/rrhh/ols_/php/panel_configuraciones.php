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
<link href="<?= controlador::$rutaAPP ?>app/vistas/rrhh/asset/css/css.css?v=<?= rand() ?>" rel="stylesheet" type="text/css" />

<script src="<?= controlador::$rutaAPP ?>app/recursos/js/table.js?v=<?= rand() ?>"></script>
<link href="<?= controlador::$rutaAPP ?>app/recursos/css/table.css?v=<?= rand() ?>" rel="stylesheet" type="text/css" />

<input type="hidden" name="url_link" id="url_link" value="<?= controlador::$rutaAPP ?>">
<input type="hidden" name="idTrabajador" id="idTrabajador" value="<?= $idTrabajador ?>">
<div class="row">
  <p align="left" class="text-primary font-weight-light h3">Configuración Renumeraciones</p>
  <hr class="mt-2 mb-3"/>
  <div class="col-xl-15 m-1 animate__animated animate__fadeIn animate__slow ">
    <p class="h4" align="center">Par&aacute;metros</p>
  </div>
  <?= $rrhh->sueldo_minimo_editar(); ?>
  <?= $rrhh->sueldo_uf_editar(); ?>
  <?= $rrhh->sueldo_utm_editar(); ?>
  <div class="col-6 p-2 mt-2 mb-2 ml-2 animate__animated animate__fadeIn animate__slow shadow">
    <div class="d-flex flex-wrap align-items-center mb-4">
      <p class="h4">Previsiones Salud</p>
      <div class="ms-auto">
        <button class="btn btn-success" href="<?= controlador::$rutaAPP ?>app/vistas/rrhh/php/nueva_prevision.php?accion=prevision" data-fancybox data-type="iframe" data-preload="true" data-width="800" data-height="600"><i class="bi bi-plus-square-dotted"></i></button>
      </div>
    </div>
    <div class="col-xl-12 animate__animated animate__fadeIn animate__slow" id="editar_prevision">
       <?= $rrhh->listar_salud_mostrar() ?>
    </div>
  </div>
  <div class="col-6 p-2 mt-2 mb-2 ml-2 animate__animated animate__fadeIn animate__slow shadow" >
    <div class="d-flex flex-wrap align-items-center mb-4">
      <p class="h4">Previsiones Pensiones</p>
      <div class="ms-auto">
        <button class="btn btn-success" href="<?= controlador::$rutaAPP ?>app/vistas/rrhh/php/nueva_prevision.php?accion=pension" data-fancybox data-type="iframe" data-preload="true" data-width="800" data-height="600"><i class="bi bi-plus-square-dotted"></i></button>
      </div>
    </div>
    <div class="col-xl-12 animate__animated animate__fadeIn animate__slow" id="editar_pension">
       <?= $rrhh->listar_pension_mostrar() ?>
    </div>
  </div>
  <div class="col-6 p-2 mt-2 mb-2 ml-2 animate__animated animate__fadeIn animate__slow shadow" id="panel_permisos">
    <div class="d-flex flex-wrap align-items-center mb-4">
      <p class="h4">Isapres</p>
      <div class="ms-auto">
        <button class="btn btn-success" href="<?= controlador::$rutaAPP ?>app/vistas/rrhh/php/nueva_prevision.php?accion=isapre" data-fancybox data-type="iframe" data-preload="true" data-width="800" data-height="600"><i class="bi bi-plus-square-dotted"></i></button>
      </div>
    </div>
    <div class="col-xl-12 animate__animated animate__fadeIn animate__slow" id="editar_isapre">
       <?= $rrhh->listar_isapres_mostrar() ?>
    </div>
  </div>
  <div class="col-6 p-2 mt-2 mb-2 ml-2 animate__animated animate__fadeIn animate__slow shadow" id="panel_permisos">
    <div class="d-flex flex-wrap align-items-center mb-4">
      <p class="h4">Caja Compensaci&oacute;n</p>
      <div class="ms-auto">
        <button class="btn btn-success" href="<?= controlador::$rutaAPP ?>app/vistas/rrhh/php/nueva_prevision.php?accion=caja" data-fancybox data-type="iframe" data-preload="true" data-width="800" data-height="600"><i class="bi bi-plus-square-dotted"></i></button>
      </div>
    </div>
    <div class="col-xl-12 animate__animated animate__fadeIn animate__slow" id="editar_caja">
       <?= $rrhh->listar_compensaciones_mostrar() ?>
    </div>
  </div>
</div>
<script type="text/javascript">
  $(document).ready(function() {
    $("#lista_prevision").DataTable({     
      "aLengthMenu": [[5, 10], [5, 10]],
      "iDisplayLength": 5
    });
  });

  $(document).ready(function() {
    $("#lista_pension").DataTable({     
      "aLengthMenu": [[5, 10], [5, 10]],
      "iDisplayLength": 5
    });
  });

  $(document).ready(function() {
    $("#lista_isapres").DataTable({     
      "aLengthMenu": [[5, 10], [5, 10]],
      "iDisplayLength": 5
    });
  });

  $(document).ready(function() {
    $("#lista_compensaciones").DataTable({     
      "aLengthMenu": [[5, 10], [5, 10]],
      "iDisplayLength": 5
    });
  });
</script>




