<?php
  require_once __dir__."/../../controlador/bodegaProductosControlador.php";
  require_once __dir__."/../../controlador/utilidadesControlador.php";
  require_once __dir__."/../../controlador/productosBodegaControlador.php";
  require_once __dir__."/../../recursos/head.php";

  error_reporting(E_ALL);
  ini_set('display_errors', 0);


  $bodega      = new Bodega();
  $productosBod= new ProductosBodega();
  $utilidades  = new Utilidades();
  $mvc2        = new controlador();

	$dia         = Utilidades::fecha_dia();
	$mes         = Utilidades::fecha_mes();
  $ano         = Utilidades::fecha_ano();
  $hoy         = Utilidades::fecha_hoy();

  $inicio   = $ano.'-'.$mes.'-01';
  $final    = date("Y-m-t", strtotime($inicio));

  // MENU
  $mvc2->menu_usuarios();
?>
<script src="<?= controlador::$rutaAPP ?>app/recursos/js/table.js?v=<?= rand() ?>"></script>
<link href="<?= controlador::$rutaAPP ?>app/recursos/css/table.css?v=<?= rand() ?>" rel="stylesheet" type="text/css" />

<script src="<?= controlador::$rutaAPP ?>app/vistas/bodega/asset/js/js.js?v=<?= rand() ?>"></script>
<link href="<?= controlador::$rutaAPP ?>app/vistas/bodega/asset/css/css.css?v=<?= rand() ?>" rel="stylesheet" type="text/css" />

<input type="hidden" name="url_link" id="url_link" value="<?= controlador::$rutaAPP ?>">
<!DOCTYPE html>
<html>
<body id="body-pd">
  <div class="row paddingtop40px mt-5">
    <div class="card-block text-center">
      <button class="btn btn-warning" type="button" href="<?= controlador::$rutaAPP ?>app/vistas/productosBodega/php/nuevo_producto.php" data-fancybox data-type="iframe" data-preload="true" data-width="100%" data-height="600">Nuevo Producto&nbsp;&nbsp;&nbsp;<i class="bi bi-plus-circle-dotted"></i></button>

      <button class="btn btn-success" type="button" href="<?= controlador::$rutaAPP ?>app/vistas/bodega/php/ingresos_productos.php" data-fancybox data-type="iframe" data-preload="true" data-width="100%" data-height="1200">
        Ingreso Productos&nbsp;&nbsp;&nbsp;<i class="fas fa-arrow-alt-circle-up"></i>
      </button>
      <button class="btn btn-primary" type="button" href="<?= controlador::$rutaAPP ?>app/vistas/bodega/php/salidas_productos.php" data-fancybox data-type="iframe" data-preload="true" data-width="100%" data-height="1200">
        Salida Productos&nbsp;&nbsp;&nbsp;<i class="fas fa-arrow-alt-circle-down"></i>
      </button>
      <button class="btn btn-danger" type="button" href="<?= controlador::$rutaAPP ?>app/vistas/bodega/php/merma_producto.php" data-fancybox data-type="iframe" data-preload="true" data-width="100%" data-height="1200">
        Merma&nbsp;&nbsp;&nbsp;<i class="fas fa-trash-alt"></i>
      </button>
      <button class="btn btn-light bg-gradient" type="button" href="<?= controlador::$rutaAPP ?>app/vistas/bodega/php/nueva_categoria.php" data-fancybox data-type="iframe" data-preload="true" data-width="100%" data-height="1200">
              Configuracion&nbsp;&nbsp;&nbsp;<i class="bi bi-gear-wide-connected"></i>
      </button>
    </div>
    <hr class="mt-2 mb-3"/>
<!-- LISTADOS DE PRODUCTOS -->
    <div class="container-fluid">
      <div class="wrapper">
        <div class="list-group list-group-flush border-bottom scrollarea">
          <div class="row">
            <div class="col"><h2 align="center" class=" me-2 text-primary"> <i class='fas fa-warehouse nav_icon h2'></i> Bodega</h2></div>
          </div>
          <div class="row my-5">
            <div class="col p-2 border" id="traer_reporteria">
              <?= $productosBod->traer_productos_table(1); ?>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- HOSTORIAL DE BODEGA -->
    <div class="row mb-4 my-5">
      <div class="col-sm-12 col-md-3 col-xl-4 border">
        <h3 align="center" class="border-bottom me-2 text-success">Ingresos Productos</h3>
        <?= $bodega->listado_adminitracion_bodega($ano, $mes, 2); ?>
      </div>
      <div class="col-sm-12 col-md-3 col-xl-4 border">
        <h3 align="center" class="border-bottom me-2 text-info">Salidas Productos</h3>
        <?= $bodega->listado_adminitracion_bodega($ano, $mes, 1); ?>
      </div>
      <div class="col-sm-12 col-md-3 col-xl-4 border">
        <h3 align="center" class="border-bottom me-2 text-danger">Mermas Productos</h3>
        <?= $bodega->listado_adminitracion_bodega($ano, $mes, 3); ?>
      </div>
    </div>
  </div>
</div>
</body>
</html>

<script>
  $(document).ready(function() {
    $('#productos').DataTable({     
      "aLengthMenu": [[5, 10, 20, 30, -1], [5, 10, 20, 30, "Todos"]],
        "iDisplayLength": 20
    });
  });
</script>