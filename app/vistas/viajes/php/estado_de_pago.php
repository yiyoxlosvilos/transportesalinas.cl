<?php
  require_once __dir__."/../../../controlador/controlador.php";
  require_once __dir__."/../../../controlador/centroCostoControlador.php";
  require_once __dir__."/../../../controlador/utilidadesControlador.php";
  require_once __dir__."/../../../controlador/recursosControlador.php";
  require_once __dir__."/../../../recursos/head.php";

  $centroCostos= new CentroCostos();
  $recursos    = new Recursos();
  $utilidades  = new Utilidades();
  $mvc         = new controlador();

  $idServicio  = $_REQUEST['idServicio'];
  $mes         = Utilidades::fecha_mes();
  $ano         = Utilidades::fecha_ano();
?>
<script src="<?= controlador::$rutaAPP ?>app/vistas/rrhh/asset/js/js.js?v=<?= rand() ?>"></script>
<link href="<?= controlador::$rutaAPP ?>app/vistas/rrhh/asset/css/css.css?v=<?= rand() ?>" rel="stylesheet" type="text/css" />
<?php 
  echo $centroCostos->cotizacion_servicio($idServicio, $mes, $ano);
  
  echo '<script>
              window.print();
            </script>';
?>