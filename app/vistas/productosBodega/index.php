<?php
  require_once __dir__."/../../controlador/productosBodegaControlador.php";
  require_once __dir__."/../../controlador/utilidadesControlador.php";
  require_once __dir__."/../../recursos/head.php";

  $productos   = new ProductosBodega();
  $utilidades  = new Utilidades();
  $mvc2        = new controlador();

	$dia         = Utilidades::fecha_dia();
	$mes         = Utilidades::fecha_mes();
  $ano         = Utilidades::fecha_ano();
  $hoy         = Utilidades::fecha_hoy();

  // MENU
  $mvc2->menu_usuarios();
?>
<link href="<?= controlador::$rutaAPP ?>app/recursos/css/table.css" rel="stylesheet" type="text/css" />
<link href="<?= controlador::$rutaAPP ?>app/vistas/productosBodega/asset/css/css.css" rel="stylesheet" type="text/css" />
<input type="hidden" name="url_link" id="url_link" value="<?= controlador::$rutaAPP ?>">
<!DOCTYPE html>
<html>
<body id="body-pd">
  <div class="row paddingtop40px mt-5 mb-4">
    <div class="card-block text-center">
      <button class="btn btn-success" type="button" href="<?= controlador::$rutaAPP ?>app/vistas/productosBodega/php/nuevo_producto.php" data-fancybox data-type="iframe" data-preload="true" data-width="100%" data-height="600">Nuevo&nbsp;&nbsp;&nbsp;<i class="bi bi-plus-circle-dotted"></i></button>
      <button class="btn btn-danger" onclick="ofertar_productos()">Ofertar Productos&nbsp;&nbsp;<i class="bi bi-cash-coin"></i></button>
      <button class="btn btn-dark" onclick="promocionar_productos()">Promocionar Productos&nbsp;&nbsp;<i class="bi bi-file-bar-graph"></i></button>
      <button class="btn btn-primary" type="button" href="<?= controlador::$rutaAPP ?>app/vistas/productosBodega/php/nueva_categoria.php" data-fancybox data-type="iframe" data-preload="true" data-width="100%" data-height="1200">Configuracion&nbsp;&nbsp;&nbsp;<i class="bi bi-gear-wide-connected"></i></button>
    </div>
    <hr class="mt-2 mb-3"/>
    <!-- LISTADOS DE PRODUCTOS -->
    <div class="row overflow-auto ">
      <div class="row justify-content-center aling-content-center">
        <div class="col-8">
          <table width="100%"  border="0" cellpadding="2" cellspacing="5" class="table shadow table-bordered animate__animated  animate__fadeIn rounded">
            <tr class="bg-info">
              <td width="45%" class="text-white">TIPO</td>
              <td width="45%" class="text-white">ACCIÓN</td>
              <td width="10%" class="text-white">&nbsp;</td>
              <td width="10%" class="text-white">&nbsp;</td>
            </tr>
            <tr>
              <td>
                <select class="form-select border shadow-sm" id="tipo_busqueda" name="tipo_busqueda" onchange="tipo_buscar()" >
                    <option value="1">CÓDIGO</option>
                    <option value="2">CATEGORIAS</option>
                </select>
              </td>
              <td id="resultado_tipo_busqueda"><input type="text" class="form-control" id="codigo_producto" name="codigo_producto" /></td>
              <td>
                  <center>
                    <button  type="button" class="btn btn-primary bx bx-search-alt" id="buscador" onclick="buscador_de_productos(0)">&nbsp;Buscar</button>
                  </center>
              </td>
              <td>
                <center>
                  <button  type="button" class="btn btn-success fas fa-angle-double-down" id="buscador" onclick="buscador_de_productos(1)">&nbsp;Exportar</button></center>
              </td>
            </tr>
          </table>
        </div>
      </div>
      <div class="col-15" id="filtro_productos"><?= $productos->traer_productos_table(1) ?></div>
    </div>
    <div class="row" id="menus_traer"></div>
  </div>
</div>
</body>
</html>
<script src="<?= controlador::$rutaAPP ?>app/recursos/js/table.js"></script>
<script src="<?= controlador::$rutaAPP ?>app/vistas/productosBodega/asset/js/js.js?v=<?= rand() ?>"></script>