<?php
  require_once __dir__."/../../../controlador/controlador.php";
  require_once __dir__."/../../../controlador/centroCostoControlador.php";
  require_once __dir__."/../../../controlador/utilidadesControlador.php";
  require_once __dir__."/../../../controlador/recursosControlador.php";
  

  $centroCostos= new CentroCostos();
  $recursos    = new Recursos();
  $utilidades  = new Utilidades();
  $mvc         = new controlador();

  $idServicio  = $_REQUEST['idServicio'];
  $mes         = Utilidades::fecha_mes();
  $ano         = Utilidades::fecha_ano();

  $monto_servicio   = $recursos->datos_fletes_monto($idServicio);
  $monto_traslados  = $recursos->datos_traslados_monto($idServicio);
  $monto_arriendos  = $recursos->datos_arriendos_monto($idServicio);

  $sub_total        = ($monto_servicio+$monto_traslados+$monto_arriendos);
  $total = ($sub_total*1.19);
  $iva   = ($total-$neto);
?>
<!-- Bootstrap Css -->
<link href="<?= controlador::$rutaAPP ?>app/recursos/css/utilidades.css" rel="stylesheet" type="text/css" />
<link href="<?= controlador::$rutaAPP ?>app/recursos/css/bootstrap.min.css" id="bootstrap-style" rel="stylesheet" type="text/css" />
<script src="<?= controlador::$rutaAPP ?>app/vistas/rrhh/asset/js/js.js"></script>
<link href="<?= controlador::$rutaAPP ?>app/vistas/rrhh/asset/css/css.css" rel="stylesheet" type="text/css" />
<input type="hidden" name="url_link" id="url_link" value="<?= controlador::$rutaAPP ?>">


<?php 
  echo $centroCostos->cotizacion_servicio($idServicio, $mes, $ano);

  echo '<table class="table table-striped">
          <tr>
              <td>&nbsp;</td>
              <th align="right">NETO:</th>
              <th align="left">'.Utilidades::monto($sub_total).'</th>
            </tr>
            <tr>
              <td>&nbsp;</td>
              <th align="right">IVA:</th>
              <th align="left">'.Utilidades::monto($iva).'</th>
            </tr>
            <tr>
              <td>&nbsp;</td>
              <th align="right">TOTAL:</th>
              <th align="left">'.Utilidades::monto($total).'</th>
            </tr>
            </table>';
  
  echo '<script>
              window.print();
            </script>';
?>