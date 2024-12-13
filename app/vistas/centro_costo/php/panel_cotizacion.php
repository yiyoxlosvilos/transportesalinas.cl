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

  $idUser      = $_SESSION['IDUSER'];
  $idSucursal  = $_SESSION['IDSUCURSAL'];

  $codigo = "COT-".$recursos->conteo_cotizacion();
?>
<script src="<?= controlador::$rutaAPP ?>app/vistas/centro_costo/asset/js/js.js?v=<?= rand() ?>"></script>
<link href="<?= controlador::$rutaAPP ?>app/vistas/centro_costo/asset/css/css.css?v=<?= rand() ?>" rel="stylesheet" type="text/css" />

<script src="<?= controlador::$rutaAPP ?>app/recursos/js/table.js?v=<?= rand() ?>"></script>
<link href="<?= controlador::$rutaAPP ?>app/recursos/css/table.css?v=<?= rand() ?>" rel="stylesheet" type="text/css" />

<link rel="stylesheet" href="<?= controlador::$rutaAPP ?>app/recursos/css/choices.css?v=<?= rand() ?>">
<script src="<?= controlador::$rutaAPP ?>app/recursos/js/choice.js?v=<?= rand() ?>"></script>

<input type="hidden" name="url_link" id="url_link" value="<?= controlador::$rutaAPP ?>">
<input type="hidden" name="idSucursal" id="idSucursal" value="<?= $idSucursal ?>">
<input type="hidden" name="idUser" id="idUser" value="<?= $idUser ?>">

<div class="row" id="procesar_venta">
  <div class="d-flex flex-wrap align-items-center">
    <span class="h2 animate__animated animate__pulse"><i class="fas fa-receipt text-danger"></i> <span class="ocultar text-danger">Nueva cotizaci&oacute;n</span></span>
  </div>
  <hr class="mt-2 mb-3"/>
  <div class="col-lg-15 p-2 mt-1 mb-2 ml-2 animate__animated animate__fadeIn border" id="panel_caja">
    <input type="hidden" name="id_usuario" id="id_usuario" value="<?= $idCli ?>">
    <div class="entero7 ">
      <table width="100%" align="center" cellpadding="4" cellspacing="4" class="table table-striped">
        <tr>
          <td  class="bold"><b>C&oacute;digo Cotizaci&oacute;n:</b>
            <input type="text" name="codigo_servicio" id="codigo_servicio" value="<?= $codigo ?>" class="form-control  bg-white" readonly="readonly">
          </td>
          <td  class="bold"><b>Seleccionar Cliente:</b>
            <?= $recursos->select_clientes() ?>
          </td>
        </tr>
        <tr>
          <td  class="bold"><b>Fecha cotizaci&oacute;n:</b>
            <input type="date" name="fecha_inicio" id="fecha_inicio" value="<?= Utilidades::fecha_hoy() ?>" class="form-control ">
          </td>
          <td  class="bold"><b>Fecha Vigencia:</b>
            <input type="date" name="fecha_termino" id="fecha_termino" value="<?= Utilidades::fecha_hoy() ?>" class="form-control ">
          </td>
        </tr>
        <tr>
          <td  class="bold"><b>Descuentos:</b></td>
          <td>
            <input type="number" name="descuentos" id="descuentos" value="0" class="form-control ">
          </td>
        </tr>
        <tr>
          <td colspan="2" class="bold"><b>T&eacute;rminos y condiciones:</b>
            <textarea name="comentario_servicio" id="comentario_servicio" class="form-control "></textarea>
          </td>
        </tr>
        <tr>
          <td colspan="2" class="bold"><b>Items cotizaci&oacute;n: <span class="fas fa-plus-circle text-success cursor" id="add"></span></b>
            <table class="table table-bordered" id="listar_productos">
              <tr>
                <td width="21.6%"><input type="text" name="titulo[]" placeholder="Nombre" class="form-control titulo_list" /></td>
                <td width="15%"><select name="exento[]" class="form-control titulo_list"><option value="0">¿Exento?</option><option value="1">SI</option><option value="2">NO</option></select></td>
                <td width="15%"><input type="number" id="unidad0" name="unidad[]" placeholder="Unidad" class="form-control monto_list" onchange="calcular_monto_valor(0)" /></td>
                <td width="21.6%"><input type="number" id="monto0" name="monto[]" placeholder="Valor" class="form-control monto_list" onchange="calcular_monto_valor(0)" /></td>
                <td width="21.6%"><span id="total0" class="text-dark"></span></td>
                <td width="5%">&nbsp;</td>
              </tr>
            </table>
          </td>
        </tr>
      </table>
    </div>
    <div class="entero ">
      <table  align="center">
        <tr>
          <td align="center">
            <button type="button" id="grabar" class="btn btn-primary form-control shadow" onclick="crear_cotizacion()">Crear <i class="bi bi-save"></i></button>
          </td>
        </tr>
      </table>
    </div>
  </div>
</div>
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
  });

  $(document).on('click', '.btn_remove', function(){
    var button_id = $(this).attr("id"); 
    $('#row'+button_id+'').remove();
  });
</script>
