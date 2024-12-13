<?php
  require_once __dir__."/../../../controlador/controlador.php";
  require_once __dir__."/../../../controlador/utilidadesControlador.php";
  require_once __dir__."/../../../controlador/parametrosControlador.php";
  require_once __dir__."/../../../recursos/head.php";

  $parametros  = new Parametros();
  $utilidades  = new Utilidades();
  $mvc         = new controlador();

  $idSucursal  = $_REQUEST['idSucursal'];
?>
<script src="<?= controlador::$rutaAPP ?>app/vistas/parametros/asset/js/js.js?v=<?= rand() ?>"></script>
<link href="<?= controlador::$rutaAPP ?>app/vistas/parametros/asset/css/css.css?v=<?= rand() ?>" rel="stylesheet" type="text/css" />
<input type="hidden" name="url_link" id="url_link" value="<?= controlador::$rutaAPP ?>">
<div class="row mb-4">
  <p align="left" class="text-success font-weight-light h3">Editar Empresa</p>
  <hr class="mt-2 mb-3"/>
    <div class="container mb-4">
      <?= $parametros->traer_editar_empresa() ?>
    </div>
</div>