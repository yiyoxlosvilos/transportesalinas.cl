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
<script src="<?= controlador::$rutaAPP ?>app/vistas/parametros/asset/js/upload.js?v=<?= rand() ?>"></script>

<link href="<?= controlador::$rutaAPP ?>app/vistas/rrhh/asset/css/css.css?v=<?= rand() ?>" rel="stylesheet" type="text/css" />
<link href="<?= controlador::$rutaAPP ?>app/recursos/css/upload.css?v=<?= rand() ?>" rel="stylesheet" type="text/css" />

<input type="hidden" name="url_link" id="url_link" value="<?= controlador::$rutaAPP ?>">
<div class="row mb-4">
  <p align="left" class="text-success font-weight-light h3">Editar Logo</p>
  <hr class="mt-2 mb-3"/>
    <div class="container mb-4" id="cambiar_logo">
       <div dir=rtl class="file-loading">
                  <input id="input-b8" name="input-b8[]" multiple type="file">
              </div>
              <script>
                $(document).ready(function() {
                    $("#input-b8").fileinput({
                        rtl: true,
                        dropZoneEnabled: false,
                        allowedFileExtensions: ["jpg", "png", "gif"]
                    });
                });
              </script>
    </div>
</div>