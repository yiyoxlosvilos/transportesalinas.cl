<?php
  session_start();
  require_once __dir__."/../../../controlador/controlador.php";
  $mvc         = new controlador();

  require_once __dir__."/../../../controlador/ventasControlador.php";
  require_once __dir__."/../../../controlador/recursosControlador.php";
  require_once __dir__."/../../../controlador/utilidadesControlador.php";
  require_once __dir__."/../../../recursos/head.php";

  $ventas      = new Ventas();
  $utilidades  = new Utilidades();
  $recursos    = new Recursos();

  $dia         = Utilidades::fecha_dia();
  $mes         = Utilidades::fecha_mes();
  $ano         = Utilidades::fecha_ano();
  $hoy         = Utilidades::fecha_hoy();

  $idProducto  = $_REQUEST['idProducto'];
  $idUser      = $_SESSION['IDUSER'];
  $idSucursal  = $_SESSION['IDSUCURSAL'];

  $producto    = $recursos->datos_productos($idProducto);
  $montoTotal  = $ventas->total_pre_ventas($idUser);
?>
<script src="<?= controlador::$rutaAPP ?>app/vistas/ventas/asset/js/js.js?v=<?= rand() ?>"></script>
<link href="<?= controlador::$rutaAPP ?>app/vistas/ventas/asset/css/css.css?v=<?= rand() ?>" rel="stylesheet" type="text/css" />

<script src="<?= controlador::$rutaAPP ?>app/recursos/js/table.js?v=<?= rand() ?>"></script>
<link href="<?= controlador::$rutaAPP ?>app/recursos/css/table.css?v=<?= rand() ?>" rel="stylesheet" type="text/css" />

<input type="hidden" name="url_link" id="url_link" value="<?= controlador::$rutaAPP ?>">
<input type="hidden" name="idSucursal" id="idSucursal" value="<?= $idSucursal ?>">
<input type="hidden" name="idUser" id="idUser" value="<?= $idUser ?>">

<input type="hidden" name="monto_diario" id="monto_diario" value="<?= $producto[0]['prod_cli_monto'] ?>">
<input type="hidden" name="monto_diario_nuevo" id="monto_diario_nuevo" value="<?= $producto[0]['prod_cli_monto'] ?>">
<input type="hidden" name="monto_hora" id="monto_hora" value="<?= $producto[0]['prod_cli_monto_hora'] ?>">
<input type="hidden" name="monto_hora_nuevo" id="monto_hora_nuevo" value="<?= $producto[0]['prod_cli_monto_hora'] ?>">
  <div class="row" id="procesar_venta">
    <div class="d-flex flex-wrap align-items-center mb-4">
      <span class="h2 animate__animated animate__pulse"><i class="bi bi-cart"></i> <?= $producto[0]['prod_cli_producto'] ?></span>
    </div>
    <hr class="mt-2 mb-3"/>
<?php
    if($idProducto > 0){
      echo '<div class="col-lg-6 p-2 mt-2 mb-2 ml-2 animate__animated animate__fadeIn animate__slow shadow" >
              <div class="d-flex flex-wrap align-items-center mb-4"></div>
              <div class="col-xl-12 animate__animated animate__fadeIn animate__slow" id="listado_productos">';
      echo $ventas->traer_panel_productos($idProducto); 

      echo '</div></div>';
    }
?>
  <div class="col-lg-6 p-2 mt-2 mb-2 ml-2 animate__animated animate__fadeIn animate__slow shadow" >
    <div class="d-flex flex-wrap align-items-center mb-2" id="listado_ventas">
       <?= $ventas->listado_ventas($idUser); ?>
    </div>
    <div class="col-12 ">
      <p align="center" class="h4 text-success">Total: <span id="cambiarValor"><?= Utilidades::monto3($montoTotal) ?></span></p>
      <input type="hidden" name="total_final" id="total_final" value="<?= $montoTotal ?>"><!-- MONTO CON DESCUENTO -->
      <input type="hidden" name="total_final2" id="total_final2" value="<?= $montoTotal ?>"><!-- MONTO SIN DESCUENTO -->
  </div>
  </div>

  <div class="col-lg-6 p-1 mt-2 mb-2 ml-2 animate__animated animate__fadeIn animate__slow shadow">
    <div class="col-xl-12 animate__animated animate__fadeIn animate__slow">
      <div id="panel_cliente"><table width="100%" cellpadding="5" cellspacing="5" class="table" align="center" style="padding: 1%;">
            <tr>
              <td align="center">
                <input type="text" name="inputRut" id="inputRutBuscar" class="form-control shadow" placeholder="Rut cliente" onkeyup="consultar_clientes_rut()"></td>
              <td align="center">
                <input type="text" name="inputNombre" id="inputNombreBuscar" class="form-control shadow" placeholder="Nombre cliente" onkeyup="consultar_clientes_nombre()"></td>
                <td>
                  <button class="btn btn-success" onclick="nuevo_cliente()">
                    <i class="bi bi-person-plus-fill"></i>
                  </button>
                </td>
            </tr>
          </table></div>
    </div>
      <div class="col-xl-12 animate__animated animate__fadeIn animate__slow" id="editar_cliente"></div>
  </div>

  <div class="col-lg-6 p-2 mt-2 mb-2 ml-2 animate__animated animate__fadeIn animate__slow shadow" >
    <div class="d-flex flex-wrap align-items-center mb-4">
      <p class="h4 text-info">Procesar Venta</p>
    </div>
    <div class="col-xl-12 animate__animated animate__fadeIn animate__slow" id="ver_procesar"></div>
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




