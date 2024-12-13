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

<input type="hidden" name="valor_uf" id="uf_valor" value="<?= $datos_recursos[0]['par_uf'] ?>">
<input type="hidden" name="valor_utm" id="utm_valor" value="<?= $datos_recursos[0]['par_utm'] ?>">
<input type="hidden" name="sueldo_minimo" id="sueldo_minimo" value="<?= $datos_recursos[0]['par_sueldo_minimo'] ?>">
<div class="row d-flex justify-content-center mt-100" id="traer_finiquito">
  <h3 class="blanco">C&Aacute;LCULO FINIQUITO</h3>
  <div class="col-xl-6">
    <table width="100%" align="center" cellpadding="7" cellspacing="0" class="shadow">
              <tr class="bg-white">
                <td colspan="2" align="center">
                  <h4 align="center" class="text-info h4">Vacaciones Proporcionales Pendientes</h4>
                </td>
              </tr>
              <tr class="blanco">
                <td width="50%" align="left">Fecha contratado:</td>
                <td width="50%" align="left">Fecha Finiquito:</td>
              </tr>
              <tr class="blanco">
                <td width="50%" align="left">
                  <input type="date" class="form-control" name="fecha_inicio" id="fecha_inicio" value="<?= $datos_trabajador[0]['tra_contratacion'] ?>" readonly="readonly">
                </td>
                <td width="50%" align="left">
                  <input type="date" class="form-control" name="fecha_final" id="fecha_final" value="" onchange="calcular_finiquito_trabajador()">
                </td>
              </tr>
              <tr class="blanco">
                <td width="50%" align="left">Dias Trabajado:</td>
                <td width="50%" align="left">Factor Diario:</td>
              </tr>
              <tr class="blanco">
                <th width="50%" align="left">
                  <span style="color:#6633FF;" id="dias_trabajados_ver"></span>
                  <input type="hidden" class="form-control" name="dias_trabajados" id="dias_trabajados" value="" readonly="readonly">
                </th>
                <th width="50%" align="left">
                  <span style="color:#6633FF;" id="factor_dia_ver"></span>
                  <input type="hidden" class="form-control" name="factor_dia" id="factor_dia" value="" readonly="readonly">
                </th>
              </tr>
              <tr class="blanco">
                <td width="50%" align="left">A&ntilde;os Trabajados:</td>
                <td width="50%" align="left">Total Vacaciones otorgadas:</td>
              </tr>
              <tr class="blanco">
                <th width="50%" align="left">
                  <span style="color:#6633FF;" id="ano_trabajados_ver"></span>
                  <input type="hidden" class="form-control" name="ano_trabajados" id="ano_trabajados" value="" readonly="readonly">
                </th>
                <th width="50%" align="left">
                  <span style="color:#6633FF;" id="vacaciones_tomadas_ver"></span>
                  <input type="hidden" class="form-control" name="vacaciones_tomadas" id="vacaciones_tomadas" value="" readonly="readonly">
                </th>
              </tr>
              <tr class="blanco">
                <td width="50%" align="left">Vacaciones Pendientes:</td>
                <td width="50%" align="left">Dias Inh&aacute;biles(Desde fin contrato):</td>
              </tr>
              <tr class="blanco">
                <th width="50%" align="left">
                  <input type="number" class="form-control" name="vacas_pendientes" id="vacas_pendientes" value="0"  onchange="calcular_finiquito_trabajador()">
                </th>
                <th width="50%" align="left">
                  <input type="number" class="form-control" name="dias_inabiles" id="dias_inabiles" value="0" onchange="calcular_finiquito_trabajador()">
                </th>
              </tr>
              <tr class="blanco">
                <th width="50%" align="left">Total Vacaciones Pendientes:</th>
                <th width="50%" align="left">Total Concepto de Vacaciones:</th>
              </tr>
              <tr class="blanco">
                <th width="50%" align="left">
                  <span style="color:#6633FF;" id="tot_vacas_pendientes_ver"></span>
                  <input type="hidden" class="form-control naranja_light bold" name="tot_vacas_pendientes" id="tot_vacas_pendientes" value="0"  readonly="readonly">
                </th>
                <th width="50%" align="left">
                  <span style="color:#6633FF;" id="tot_concepto_vacaciones_ver"></span>
                  <input type="hidden" class="form-control naranja_light bold" name="tot_concepto_vacaciones" id="tot_concepto_vacaciones" value="0"  readonly="readonly">
                </th>
              </tr>
              <tr class="blanco">
                <td colspan="2" align="left">&nbsp;</td>
              </tr>
            </table>
  </div>
  <div class="col-xl-6">
    <table width="100%" align="center" cellpadding="7" cellspacing="0" class="shadow">
              <tr class="bg-white">
                <td colspan="2" align="center">
                  <h4 align="center" class="bg-white text-warning h4">Indemnizaci&oacute;n por Despido</h4>
                </td>
              </tr>
              <tr class="blanco">
                <td width="50%" align="left">Sueldo Base:</td>
                <td width="50%" align="left">Bonos del mes despido:</td>
              </tr>
              <tr class="blanco">
                <th width="50%" align="left">
                  <span style="color:#6633FF;"><?= Utilidades::monto3($datos_trabajador[0]['tra_sueldo_base']) ?></span>
                  <input type="hidden" class="form-control" name="sueldo_base" id="sueldo_base" value="<?= $datos_trabajador[0]['tra_sueldo_base'] ?>" readonly="readonly">
                </th>
                <th width="50%" align="left">
                  <input type="number" class="form-control" name="bono_pendiente" id="bono_pendiente" value="0" onchange="calcular_finiquito_trabajador()">
                </th>
              </tr>
              <tr class="blanco">
                <td width="50%" align="left">Bonos promedios <small>(&Uacute;ltimos 3 meses)</small>:</td>
                <td width="50%" align="left">Valor Remuneraci&oacute;n Diaria:</td>
              </tr>
              <tr class="blanco">
                <th width="50%" align="left">
                  <input type="number" class="form-control" name="bonos_3_meses" id="bonos_3_meses" value="0" onchange="calcular_finiquito_trabajador()">
                </th>
                <th width="50%" align="left">
                  <span style="color:#6633FF;" id="renumeracion_diaria_ver"></span>
                  <input type="hidden" class="form-control" name="renumeracion_diaria" id="renumeracion_diaria" value="" readonly="readonly">
                </th>
              </tr>
              <tr class="blanco">
                <td width="50%" align="left">Gratificaci&oacute;n Mensual:</td>
                <td width="50%" align="left">&nbsp;</td>
              </tr>
              <tr class="blanco">
                <th width="50%" align="left">
                  <span style="color:#6633FF;" id="gratificacion_ver"></span>
                  <input type="hidden" class="form-control" name="gratificacion" id="gratificacion" value="0">
                </th>
                <th width="50%" align="left">&nbsp;</th>
              </tr>
              <tr class="blanco">
                <td width="50%" align="left">Bono Colaci&oacute;n:</td>
                <td width="50%" align="left">Bono Movilizaci&oacute;n:</td>
              </tr>
              <tr class="blanco">
                <th width="50%" align="left">
                  <input type="number" class="form-control" name="bono_colacion" id="bono_colacion" value="0" onchange="calcular_finiquito_trabajador()">
                </th>
                <th width="50%" align="left">
                  <input type="number" class="form-control" name="bono_movilizacion" id="bono_movilizacion" value="0" onchange="calcular_finiquito_trabajador()">
                </th>
              </tr>
              <tr class="blanco">
                <th width="50%" align="left">Total a&ntilde;os servicio y Mes aviso:</th>
                <th width="50%" align="left">
                  <span style="color:#6633FF;" id="total_sueldo_base_ver"></span>
                  <input type="hidden" class="form-control naranja_light bold" name="total_sueldo_base" id="total_sueldo_base" value="0"  readonly="readonly">
                </th>
              </tr>
            </table>
  </div>
  <div class="col-xl-6">
    <table width="100%" align="center" cellpadding="7" cellspacing="0" class="table">
              <tr>
                <td colspan="2" >
                  <div class="text-info h3">CALCULO CON TOPES</div>
                  <table width="100%" align="center" cellpadding="7" cellspacing="0" class="table shadow">
                    <tr>
                      <th width="70%" align="left">Indemnizacion por A&ntilde;os de Servicio.</th>
                      <td width="30%">
                        <span id="ano_servicio_ver"></span>
                        <input type="hidden" name="ano_servicio" id="ano_servicio" value="">
                      </td>
                    </tr>
                    <tr>
                      <th width="70%" align="left">Indemnizacion sustitutivo aviso previo.</th>
                      <td width="30%">
                        <span id="previo_aviso_ver"></span>
                        <input type="hidden" name="previo_aviso" id="previo_aviso" value="">
                      </td>
                    </tr>
                    <tr>
                      <th width="70%" align="left">Vacaciones pendientes y/o proporcionales.</th>
                      <td width="30%">
                        <span id="tot_vacas_pendientes_propor_ver"></span>
                        <input type="hidden" name="tot_vacas_pendientes_propor" id="tot_vacas_pendientes_propor" value="">
                      </td>
                    </tr>
                    <tr>
                      <th width="70%" align="left">SUB-TOTAL</th>
                      <th width="30%" align="left">
                        <span id="sub_total_ver"></span
                        >
                        <input type="hidden" name="sub_total" id="sub_total" value="0">
                      </th>
                    </tr>
                    <tr>
                      <th colspan="2" align="center">Remuneracion del Mes</th>
                    </tr>
                    <tr>
                      <th width="70%" align="left">Total Haberes</th>
                      <th width="30%" align="left">
                        <input type="number" class="form-control" name="total_haberes_mes" id="total_haberes_mes" value="0" onchange="calcular_finiquito_trabajador()">
                      </th>
                    </tr>
                    <tr>
                      <th width="70%" align="left">Total Descuentos</th>
                      <th width="30%" align="left">
                        <input type="number" class="form-control" name="total_desctos_mes" id="total_desctos_mes" value="0" onchange="calcular_finiquito_trabajador()">
                      </th>
                    </tr>
                    <tr class="text-info h3">
                      <th width="70%" align="left">TOTAL A PAGAR</th>
                      <th width="30%" align="left">
                        <span id="total_pagar_ver"></span>
                        <input type="hidden" name="total_pagar" id="total_pagar" value="0"  readonly="readonly">
                      </th>
                    </tr>
                  </table>
                </td>
              </tr>
              <tr class="blanco">
                <td colspan="2" align="left">&nbsp;</td>
              </tr>
            </table>
  </div>
  <div class="col-xl-6">
    <table width="100%" align="center" cellpadding="7" cellspacing="0" >
              <tr class="blanco">
                <th colspan="2" align="center">Comentario motivo finiquito:<br>
                  <textarea rows="5" class="form-control" name="comentario" id="comentario"></textarea>
                </th>
              </tr>
              <tr class="blanco">
                <td colspan="2" align="left">&nbsp;</td>
              </tr>
              <tr class="blanco">
                <td colspan="2">
                  <table width="50%" align="center">
                    <tr>
                      <td align="center">
                        <div class="btn btn-success bordes sombraPlana" onclick="generar_finiquito_trabajador(<?= $datos_trabajador[0]['tra_id'] ?>)">Generar Finiquito</div>
                      </td>
                    </tr>
                  </table>
                </td>
              </tr>
              <tr class="blanco">
                <td colspan="2" align="left">&nbsp;</td>
              </tr>
            </table>
  </div>
            
</div>