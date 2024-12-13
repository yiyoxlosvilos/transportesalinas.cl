<?php
  require_once      __dir__."/../../../controlador/controlador.php";
  require_once      __dir__."/../../../controlador/rrhhControlador.php";
  require_once      __dir__."/../../../controlador/recursosControlador.php";
  require_once      __dir__."/../../../controlador/utilidadesControlador.php";
  require_once      __dir__."/../../../recursos/head.php";

  $rrhh             = new Rrhh();
  $utilidades       = new Utilidades();
  $recursos         = new Recursos();
  $mvc2             = new controlador();

  $dia              = Utilidades::fecha_dia();
  $mes              = Utilidades::fecha_mes();
  $ano              = Utilidades::fecha_ano();
  $hoy              = Utilidades::fecha_hoy();
  $datos_recursos   = $recursos->datos_parametros();
  $datos_trabajador = $recursos->datos_trabajador($_REQUEST['idTrabajador']);
?>
<script src="<?= controlador::$rutaAPP ?>app/vistas/rrhh/asset/js/js.js?v=<?= rand() ?>"></script>
<script src="<?= controlador::$rutaAPP ?>app/vistas/rrhh/asset/js/upload.js?v=<?= rand() ?>"></script>
<link href="<?= controlador::$rutaAPP ?>app/vistas/rrhh/asset/css/perfil.css?v=<?= rand() ?>" rel="stylesheet" type="text/css" />
<link href="<?= controlador::$rutaAPP ?>app/recursos/css/upload.css?v=<?= rand() ?>" rel="stylesheet" type="text/css" />

<input type="hidden" name="url_link" id="url_link" value="<?= controlador::$rutaAPP ?>">
<input type="hidden" name="idTrabajador" id="idTrabajador" value="<?= $idTrabajador ?>">

<input type="hidden" name="valor_uf" id="valor_uf" value="<?= $datos_recursos[0]['par_uf'] ?>">
<input type="hidden" name="valor_utm" id="valor_utm" value="<?= $datos_recursos[0]['par_utm'] ?>">
<input type="hidden" name="sueldo_minimo" id="sueldo_minimo" value="<?= $datos_recursos[0]['par_sueldo_minimo'] ?>">
<input type="hidden" name="base_tributable" id="base_tributable" value="0">

<div class="row d-flex justify-content-center mt-100" id="traer_liquidacion">
  <div class="col">
    <table width="100%" align="center" cellpadding="6" cellspacing="6" class="table table-striped shadow">
      <tbody>
        <tr>
          <th align="center" class="lighter text-success">
            <span id="haber_liq">Sueldo l&iacute;quido<br></span>
            <input type="hidden" name="haber_liq2" id="haber_liq2" value="">
          </th>
        </tr>
      </tbody>
    </table>
  </div>
  <div class="col">
    <table width="100%" align="center" cellpadding="5" cellspacing="5" class="table table-striped shadow">
      <tbody>
        <tr>
          <th align="center" class="blanco lighter text-info">
            <span id="haber_tot">Haberes<br></span>
            <input type="hidden" name="haber_tot2" id="haber_tot2" value="">
          </th>
        </tr>
      </tbody>
    </table>
  </div>
  <div class="col">
    <table width="100%" align="center" cellpadding="5" cellspacing="5" class="table table-striped shadow">
      <tbody>
        <tr>
          <th align="center" class="blanco lighter text-danger">
            <span id="haber_dsc">Descuentos<br></span>
            <input type="hidden" name="haber_dsc2" id="haber_dsc2" value="">
          </th>
        </tr>
      </tbody>
    </table>
  </div>
  <div class="col">
    <button class="btn btn-success" type="button" onclick="generar_liquidacion_sueldo(<?= $_REQUEST['idTrabajador'] ?>)">Generar</button>
  </div>
  <hr class="mt-2 mb-3"/>
  <div class="col">
    <table width="100%" cellpadding="5" cellspacing="5" class="table-striped shadow">
      <tr class="text-info h4">
        <th colspan="2" align="center">Haberes</th>
      </tr>
        <tr class="blanco">
          <th align="left">Sueldo Base</th>
          <th align="left">D&iacute;as Trabajados</th>
        </tr>
        <tr class="blanco">
          <td align="left">
            <input type="number" class="form-control" name="sueldo_base" id="sueldo_base" placeholder="N&deg; sin puntos." onchange="simular_sueldo()" value="<?= $datos_trabajador[0]['tra_sueldo_base'] ?>">
          </td>
          <td align="left">
            <input type="number" class="form-control" name="dias_trabajado" id="dias_trabajado" placeholder="0" value="" min="1" max="30" onchange="simular_sueldo()">
          </td>
        </tr>
        <tr class="blanco">
          <td align="left">Gratificaci&oacute;n</td>
          <td align="left">Valor grat.</td>
        </tr>
        <tr class="blanco">
          <td align="left">
            <select class="form-control" name="gratifica" id="gratifica" onchange="simular_sueldo()">
              <option value="1">SI</option>
              <option value="2">NO</option>
              <option value="3">Editar</option>
            </select>
          </td>
          <td align="left">
            <input type="number" class="form-control" name="total_grati" id="total_grati" value="0">
          </td>
        </tr>
                <tr class="blanco">
                  <td align="left">Horas extra <small>(Opcional)</small>.</td>
                  <td align="left">Valor hr.</td>
                </tr>
                <tr class="blanco">
                  <td align="left">
                    <input type="number" class="form-control" name="hrextra" id="hrextra" value="0" onkeyup="simular_sueldo()">
                  </td>
                  <td align="left">
                    <input type="number" class="form-control" name="hrextra_total" id="hrextra_total" value="0">
                  </td>
                </tr>
                <tr class="blanco">
                  <td align="left">Comisiones <small>(Opcional)</small>.</td>
                  <td align="left">Bonos <small>(Opcional)</small>.</td>
                </tr>
                <tr class="blanco">
                  <td align="left">
                    <input type="number" class="form-control" name="comisiones" id="comisiones" value="0" onkeyup="simular_sueldo()">
                  </td>
                  <td align="left">
                    <input type="number" class="form-control" name="bonos" id="bonos" value="0" onkeyup="simular_sueldo()">
                  </td>
                </tr>
                <tr class="blanco">
                  <td align="left">Colaci&oacute;n <small>(Opcional)</small>.</td>
                  <td align="left">Movilizaci&oacute;n <small>(Opcional)</small>.</td>
                </tr>
                <tr class="blanco">
                  <td align="left">
                    <input type="number" class="form-control" name="colacion" id="colacion" value="0" onkeyup="simular_sueldo()">
                  </td>
                  <td align="left">
                    <input type="number" class="form-control" name="movilizacion" id="movilizacion" value="0" onkeyup="simular_sueldo()">
                  </td>
                </tr>
                <tr class="blanco">
                  <td align="left" colspan="2">&nbsp;</td>
                </tr>
                <tr class="blanco">
                  <td align="left" colspan="2">&nbsp;</td>
                </tr>
      </table>
    </div>
    <div class="col">
      <table  width="100%" cellpadding="6" cellspacing="6" class="table-striped shadow">
                <tr class="text-warning h4">
                  <th colspan="2" align="center">Descuentos</th>
                </tr>
                <tr class="blanco">
                  <td width="50%" align="left">AFP</td>
                  <td width="50%" align="left">Total AFP</td>
                </tr>
                <tr class="blanco">
                  <td align="left">
                    <?= $recursos->select_opciones_afp('simular_sueldo', 0); ?>
                  </td>
                  <td align="left">
                    <input type="number" class="form-control" name="total_afp" id="total_afp" value="0">
                  </td>
                </tr>
                <tr class="blanco">
                  <td align="left">Previsi&oacute;n</td>
                  <td align="left">Total Previsi&oacute;n</td>
                </tr>
                <tr class="blanco">
                  <td align="left">
                    <?= $recursos->select_opciones_prevision('simular_sueldo', 0); ?>
                  </td>
                  <td align="left">
                    <input type="number" class="form-control" name="total_salud" id="total_salud" value="0"><span id="valor_uf_isapre"></span>
                  </td>
                </tr>
                <tr class="blanco" style="display: none;" id="add_isapre">
                  <td align="left">
                    <select class="form-control" name="isapre" id="isapre" onchange="simular_sueldo()">
                      <option value="0">Seleccionar Isapre</option>
                       
                    </select>
                  </td>
                  <td align="left">Adicional ISAPRE.
                    <input type="number" class="form-control" name="adicional_isapre" id="adicional_isapre" value="0" onkeyup="simular_sueldo()"><span id="valor_uf_isapre_add"></span>
                  </td>
                </tr>
                <tr class="blanco" style="display: none;" id="impuesto_unico_add">
                  <td align="left" >Impuesto Unico.</td>
                  <td align="left">
                    <input type="number" class="form-control" name="impuesto_unico" id="impuesto_unico" value="0" readonly="readonly"  onchange="simular_sueldo()">
                  </td>
                </tr>
                <tr class="blanco">
                  <td align="left">Seguro Cesant&iacute;a</td>
                  <td align="left">APV <small>(Opcional)</small>.</td>
                </tr>
                <tr class="blanco">
                  <td align="left">
                    <input type="number" class="form-control" name="cesantia" id="cesantia" value="0" onkeyup="simular_sueldo()">
                  </td>
                  <td align="left">
                    <input type="number" class="form-control" name="apv" id="apv" value="0" onkeyup="simular_sueldo()">
                  </td>
                </tr>
                <tr class="blanco">
                  <td align="left">Anticipos <small>(Opcional)</small>.</td>
                  <td align="left">Seguro Vida. <small>(Opcional)</small>.</td>
                </tr>
                <tr class="blanco">
                  <td align="left">
                    <input type="number" class="form-control" name="anticipos" id="anticipos" value="0" onkeyup="simular_sueldo()">
                  </td>
                  <td align="left">
                    <input type="number" class="form-control" name="seguro_vida" id="seguro_vida" value="0" onkeyup="simular_sueldo()">
                  </td>
                </tr>
                <tr class="blanco">
                  <td align="left">Caja compensacion <small>(Opcional)</small>.</td>
                  <td align="left">&nbsp;</td>
                </tr>
                <tr class="blanco">
                  <td align="left">
                    <?= $recursos->caja_compensacion(); ?>
                  </td>
                  <td align="left">
                    <input type="number" class="form-control" name="monto_caja_compensacion" id="monto_caja_compensacion" value="0" onkeyup="simular_sueldo()">
                  </td>
                </tr>
              </table>
    </div>
</div>
<script type="text/javascript">
  $(document).ready(function() {
      $('#liquidaciones_list').DataTable({     
        "aLengthMenu": [[10, 20, 30, -1], [10, 20, 30, "Todos"]],
          "iDisplayLength": 10
         });
  });
</script>