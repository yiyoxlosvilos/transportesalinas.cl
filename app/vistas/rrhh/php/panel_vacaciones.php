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
  <p align="left" class="text-primary font-weight-light h3">Panel Vacaciones y permisos</p>
  <hr class="mt-2 mb-3"/>
  <div class="col-xl-6 col-md-6 mb-4 animate__animated animate__fadeIn">
    <div class="container mb-4" id="editar_trabajador">
      <?= $rrhh->card_vacaciones_trabajador($idTrabajador); ?>
    </div>
  </div>
  <div class="col-xl-6 col-md-6 mb-4 animate__animated animate__fadeIn animate__slow" id="panel_permisos">
    <div class="row mb-2">
        <h3>Realizar Permiso</h3>
        <table width="90%" align="center" cellpadding="5" cellspacing="5" class="arriba_top10 sombraPlana">   
        <tr class="blanco">
          <td align="left" colspan="2">Tipo Permiso:</td>
        </tr>
        <tr class="plomo">
          <td align="left" colspan="2">
            <?= $recursos->select_tipo_permiso(0) ?>
          </td>
        </tr>
        <tr class="blanco">
          <td width="50%" align="left">Desde:</td>
          <td width="50%" align="left">Hasta:</td>
        </tr>
        <tr class="plomo">
          <td width="50%" align="left">
            <input type="date" class="form-control" name="desde" id="desde" value="<?= $hoy ?>" oninput="calcular_dias()">
          </td>
          <td width="50%" align="left">
            <input type="date" class="form-control" name="hasta" id="hasta" value="<?= $hoy ?>" oninput="calcular_dias()">
          </td>
        </tr>
        <tr class="blanco">
          <td colspan="2">Dias a utilizar: <span id="cantidad_dias" class="text-success">0</span> <input type="hidden" name="dias" id="dias" value="0"></td>
        </tr>
        <tr class="blanco">
          <td colspan="2" align="left">Comentario:</td>
        </tr>
        <tr class="plomo">
          <td colspan="2" align="left">
            <textarea rows="5" class="form-control" name="comentario" id="comentario"></textarea>
          </td>
        </tr>
        <tr class="blanco">
          <td colspan="2" align="left">
            <table width="70%" align="center">
              <tr>
                <td align="center">
                  <button type="button" id="grabar" class="btn btn-primary form-control shadow" onclick="grabar_permiso(<?= $idTrabajador ?>)">Grabar Permiso<i class="bi bi-save"></i></button>
                </td>
              </tr>
            </table>
          </td>
        </tr>
        </table>
    </div>
  </div>
</div>