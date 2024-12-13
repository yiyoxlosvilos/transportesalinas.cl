<?php
  require_once __dir__."/../../controlador/productosControlador.php";
  require_once __dir__."/../../controlador/utilidadesControlador.php";
  require_once __dir__."/../../recursos/head.php";

  $productos   = new Productos();
  $utilidades  = new Utilidades();
  $mvc2        = new controlador();

	$dia         = Utilidades::fecha_dia();
	$mes         = Utilidades::fecha_mes();
  $ano         = Utilidades::fecha_ano();
  $hoy         = Utilidades::fecha_hoy();

  // MENU
  $mvc2->menu_usuarios();
?>
<script src="<?= controlador::$rutaAPP ?>app/recursos/js/table.js?v=<?= rand() ?>"></script>
<link href="<?= controlador::$rutaAPP ?>app/recursos/css/table.css?v=<?= rand() ?>" rel="stylesheet" type="text/css" />

<script src="<?= controlador::$rutaAPP ?>app/vistas/productos/asset/js/js.js?v=<?= rand() ?>"></script>
<link href="<?= controlador::$rutaAPP ?>app/vistas/productos/asset/css/css.css?v=<?= rand() ?>" rel="stylesheet" type="text/css" />
<input type="hidden" name="url_link" id="url_link" value="<?= controlador::$rutaAPP ?>">
<!DOCTYPE html>
<html>
<body id="body-pd">
  <div class="row paddingtop40px mt-5 mb-4">
    <div class="card-block text-center">
      <button class="btn btn-success bg-gradient" type="button" href="<?= controlador::$rutaAPP ?>app/vistas/productos/php/nuevo_producto.php" data-fancybox data-type="iframe" data-preload="true" data-width="100%" data-height="600">
              Nuevo&nbsp;&nbsp;&nbsp;<i class="bi bi-plus-circle-dotted"></i>
      </button>
      <button class="btn btn-danger bg-gradient" type="button" href="<?= controlador::$rutaAPP ?>app/vistas/bodega/php/merma_producto.php" data-fancybox data-type="iframe" data-preload="true" data-width="100%" data-height="1200">
              Merma&nbsp;&nbsp;&nbsp;<i class="bi bi-inboxes-fill"></i>
      </button>
      <button class="btn btn-primary bg-gradient" type="button" href="<?= controlador::$rutaAPP ?>app/vistas/productos/php/nueva_categoria.php" data-fancybox data-type="iframe" data-preload="true" data-width="100%" data-height="1200">
              Configuracion&nbsp;&nbsp;&nbsp;<i class="bi bi-gear-wide-connected"></i>
      </button>
    </div>
    <hr class="mt-2 mb-3"/>
    <?= $productos->traer_productos_cards(1) ?>
    <?= $productos->traer_productos_cards(2) ?>
    <?= $productos->traer_productos_cards(3) ?>
    <!-- LISTADOS DE PRODUCTOS -->
    <div class="container">
      <div class="row overflow-auto " id="filtro_productos">
          <?= $productos->traer_productos_table(0) ?>
      </div>
    </div>
  </div>
</div>
</body>
</html>
<script>
  initCounterNumber();
  initCounterPorcent();
</script>