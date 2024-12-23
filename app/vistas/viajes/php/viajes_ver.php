<?php
  require_once __dir__."/../../../controlador/controlador.php";
  require_once __dir__."/../../../controlador/viajesControlador.php";
  require_once __dir__."/../../../controlador/utilidadesControlador.php";
  require_once __dir__."/../../../controlador/recursosControlador.php";
  require_once __dir__."/../../../recursos/head.php";

  $centroCostos= new Viajes();
  $recursos    = new Recursos();
  $utilidades  = new Utilidades();
  $mvc         = new controlador();

  $idCotizacion  = $_REQUEST['idCotizacion'];
  $mes         = Utilidades::fecha_mes();
  $ano         = Utilidades::fecha_ano();
?>
<script src="<?= controlador::$rutaAPP ?>app/vistas/rrhh/asset/js/js.js?v=<?= rand() ?>"></script>
<link href="<?= controlador::$rutaAPP ?>app/vistas/rrhh/asset/css/css.css?v=<?= rand() ?>" rel="stylesheet" type="text/css" />
<input type="hidden" name="url_link" id="url_link" value="<?= controlador::$rutaAPP ?>">


<?php 
  echo $centroCostos->cotizacion_clientes_ver($idCotizacion, $mes, $ano);
  
  echo '<script>
              window.print();
            </script>';
?>