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
?>
<script src="<?= controlador::$rutaAPP ?>app/recursos/js/table.js?v=<?= rand() ?>"></script>
<link href="<?= controlador::$rutaAPP ?>app/recursos/css/table.css?v=<?= rand() ?>" rel="stylesheet" type="text/css" />
<script src="<?= controlador::$rutaAPP ?>app/vistas/productos/asset/js/js.js?v=<?= rand() ?>"></script>
<link href="<?= controlador::$rutaAPP ?>app/vistas/productos/asset/css/css.css?v=<?= rand() ?>" rel="stylesheet" type="text/css" />
<input type="hidden" name="url_link" id="url_link" value="<?= controlador::$rutaAPP ?>">
<div class="row">
  <div class="col-lg-6 mb-2 shadow">
    <div class="container mb-4">
      <div class="row">
        <div class="col">
          <div class="col-lg-3 mb-2">
            <p align="center" class="text-secondary font-weight-light h4">Categorías</p>
          </div> 
        </div>
        <div class="col">
          <div class="col-lg-3 mb-2">
            <!--<span class="btn btn-success w-lg waves-effect waves-light w-100 waves-effect waves-light " type="button" onclick="nueva_categoria()">
              <i class="bi bi-plus-circle-dotted"></i>
            </span>-->
          </div>
        </div>
        <div class="col-15" id="nueva_categoria">
          <?= $recursos->listado_categorias_productos() ?>
        </div>
      </div>
    </div>
  </div>
  <div class="col-lg-6 mb-2 shadow">
    <div class="container mb-4">
      <div class="row">
        <div class="col">
          <div class="col-lg-3 mb-2">
            <p align="center" class="text-secondary font-weight-light h4">Marcas</p>
          </div>
        </div>
        <div class="col">
          <div class="col-lg-3 mb-2">
            <span class="btn btn-success w-lg waves-effect waves-light w-100 waves-effect waves-light " type="button" onclick="nueva_marca()">
              <i class="bi bi-plus-circle-dotted"></i>
            </span>
          </div>
        </div>
        <div class="col-15" id="nueva_marca">
          <?= $recursos->listado_marcas_productos() ?>
        </div>
      </div>
    </div>
  </div>
</div>
<script>
  $(document).ready(function() {
    $("#categorias_list").DataTable({     
        "aLengthMenu": [[5, 10, 20], [5, 10, 20]],
        "iDisplayLength": 10
    });
    $("#marcas_list").DataTable({     
        "aLengthMenu": [[5, 10, 20], [5, 10, 20]],
        "iDisplayLength": 10
    });
  });
</script>