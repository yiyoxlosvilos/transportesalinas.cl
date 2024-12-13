<?php
  session_start();
  require_once __dir__."/../../../controlador/controlador.php";
  $mvc         = new controlador();

  require_once __dir__."/../../../controlador/centroCostoControlador.php";
  require_once __dir__."/../../../controlador/recursosControlador.php";
  require_once __dir__."/../../../controlador/utilidadesControlador.php";
  require_once __dir__."/../../../recursos/head.php";

  $centroCostos= new CentroCostos();
  $utilidades  = new Utilidades();
  $recursos    = new Recursos();

  $dia         = Utilidades::fecha_dia();
  $mes         = Utilidades::fecha_mes();
  $ano         = Utilidades::fecha_ano();
  $hoy         = Utilidades::fecha_hoy();

  $idUser      = $_SESSION['IDUSER'];
  $idSucursal  = $_SESSION['IDSUCURSAL'];
  $idCotizacion= $_REQUEST['idCotizacion'];

  $datos_cotizacion = $recursos->datos_cotizacion_id($idCotizacion);
  $datos_clientes   = $recursos->datos_clientes($datos_cotizacion[0]['coti_cliente']);

?>
<script src="<?= controlador::$rutaAPP ?>app/vistas/centro_costo/asset/js/js.js?v=<?= rand() ?>"></script>
<link href="<?= controlador::$rutaAPP ?>app/vistas/centro_costo/asset/css/css.css?v=<?= rand() ?>" rel="stylesheet" type="text/css" />

<script src="<?= controlador::$rutaAPP ?>app/recursos/js/table.js?v=<?= rand() ?>"></script>
<link href="<?= controlador::$rutaAPP ?>app/recursos/css/table.css?v=<?= rand() ?>" rel="stylesheet" type="text/css" />

<link rel="stylesheet" href="<?= controlador::$rutaAPP ?>app/recursos/css/choices.css?v=<?= rand() ?>">
<script src="<?= controlador::$rutaAPP ?>app/recursos/js/choice.js?v=<?= rand() ?>"></script>

<script src="<?= controlador::$rutaAPP ?>app/vistas/centro_costo/asset/js/upload_cotizacion.js?v=<?= rand() ?>"></script>
<link href="<?= controlador::$rutaAPP ?>app/recursos/css/upload.css?v=<?= rand() ?>" rel="stylesheet" type="text/css" />

<input type="hidden" name="url_link" id="url_link" value="<?= controlador::$rutaAPP ?>">
<input type="hidden" name="idSucursal" id="idSucursal" value="<?= $idSucursal ?>">
<input type="hidden" name="idUser" id="idUser" value="<?= $idUser ?>">
<input type="hidden" name="codigo_cotizacion" id="codigo_cotizacion" value="<?= $datos_cotizacion[0]['coti_codigo'] ?>">

<div class="row" id="procesar_venta">
  <div class="d-flex flex-wrap align-items-center">
    <span class="h2 animate__animated animate__pulse"><i class="fas fa-receipt text-danger"></i> <span class="ocultar text-danger">Cotizaci&oacute;n N&deg;: <span class="text-dark"><?= $datos_cotizacion[0]['coti_codigo'] ?>.</span></span></span>
  </div>
  <hr class="mt-2 mb-3"/>
  <div class="col-12 p-2 mt-1 mb-2 ml-2 animate__animated animate__fadeIn border p-1" >
    <div class="row" id="editar_cliente">
      <div class="col-md-3">
        <h5 class="text-dark f-w-300 mt-4">Cliente:<br><?= $datos_clientes[0]['cli_nombre'] ?></h5>
      </div>
      <div class="col-md-3">
        <h5 class="text-dark f-w-300 mt-4">Fecha cotizacion:<br><?= $datos_cotizacion[0]['coti_fecha'] ?></h5>
      </div> 
      <div class="col-md-3">
        <h5 class="text-dark f-w-300 mt-4">Fecha vigencia:<br><?= $datos_cotizacion[0]['coti_vigencia'] ?></h5>
      </div>
      <div class="col-md-3"><br>
        <i class="bi bi-pencil-square text-primary cursor" onclick="traer_editar_cotizacion(<?= $idCotizacion ?>)"></i>
      </div> 
    </div>
    <div class="row " id="editar_items">
      <?= $centroCostos->listado_items_cotizacion_quitar($datos_cotizacion[0]['coti_codigo']) ?>
    </div>
  </div>
  <div class="col-12 p-2 mt-1 mb-2 ml-2 animate__animated animate__fadeIn border p-1" id="panel_caja">
    <div class="row" style="min-height:200px;">
      <div class="col-lg-15">
        <h6>Nuevos Items cotizaci&oacute;n: <span class="fas fa-plus-circle text-success cursor" id="add"></span></h6>
        <hr>
        <table class="table" id="listar_productos">
        </table>
        <table  align="center" style="display:none;" id="grabar_boton">
          <tr>
            <td align="center">
              <button type="button" id="grabar" class="btn btn-success form-control shadow" onclick="agregar_items_cotizacion()">Agregar <i class="bi bi-save"></i></button>
            </td>
          </tr>
        </table>
      </div>      
    </div>
    <div class="row" style="min-height:200px;">
      <div class="col-lg-15">
        <h6>Agregar imagenes a cotizaci&oacute;n: <span class="fas fa-plus-circle text-success cursor" onclick="agregar_imagen_cotizacion(<?= $idCotizacion ?>)"></span></h6>
        <hr>
        <div id="imagen_cotizacion"><?= $centroCostos->traer_documentos_cotizacion($idCotizacion) ?></div>
      </div>      
    </div>
  </div>
</div>
<?php
  if($datos_cotizacion[0]['coti_estado'] == 1){
?>
<div class="row">
  <table  class="col-md-3 mt-5" align="center">
    <tr>
      <td align="center"><button type="button" id="grabar" class="btn btn-primary form-control shadow" onclick="aceptar_cotizacion(<?= $idCotizacion ?>)">Aceptar <i class="bi bi-save"></i></button></td>
      <td>&nbsp;</td>
      <td align="center"><button type="button" id="grabar" class="btn btn-danger form-control shadow" onclick="rechazar_cotizacion(<?= $idCotizacion ?>)">Rechazar <i class="bi bi-x-square"></i></button></td>
    </tr>
  </table>
</div>
<?php 
  }
?>
<script>
  var i = 1;
  $(document).ready(function() { 
    var multipleCancelButton = new Choices("#clientes", {
          removeItemButton: true,
      });
  });

  $('#add').click(function(){
    i++;
    $('#listar_productos').append('<tr id="row'+i+'"><td><input type="text" name="titulo[]" placeholder="Nombre" class="form-control name_list" /></td><td><select name="exento[]" class="form-control titulo_list"><option value="0">¿Exento?</option><option value="1">SI</option><option value="2">NO</option></select></td><td><input type="number" id="unidad'+i+'" name="unidad[]" placeholder="Unidad" class="form-control monto_list" onchange="calcular_monto_valor('+i+')" /></td><td><input type="text" id="monto'+i+'" onchange="calcular_monto_valor('+i+')" name="monto[]" placeholder="Valor" class="form-control name_list" /></td><td><span id="total'+i+'" class="text-dark"></span></td><td><span class="fas fa-trash text-danger cursor btn_remove" name="remove" id="'+i+'"></span></td></tr>');
    $("#grabar_boton").show();
  });

  $(document).on('click', '.btn_remove', function(){
    var button_id = $(this).attr("id"); 
    $('#row'+button_id+'').remove();
    i--;
    if(i == 1){
      $("#grabar_boton").hide();
    }

  });
</script>
