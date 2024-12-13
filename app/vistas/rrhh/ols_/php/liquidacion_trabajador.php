<?php
  require_once __dir__."/../../../controlador/controlador.php";
  require_once __dir__."/../../../controlador/rrhhControlador.php";
  require_once __dir__."/../../../controlador/utilidadesControlador.php";
  require_once __dir__."/../../../controlador/recursosControlador.php";
  require_once __dir__."/../../../recursos/head.php";

  $rrhh        = new Rrhh();
  $recursos    = new Recursos();
  $utilidades  = new Utilidades();
  $mvc         = new controlador();

  $idTrabajador= $_REQUEST['idTrabajador'];
  $print       = $_REQUEST['print'];
  $mes         = Utilidades::fecha_mes();
  $ano         = Utilidades::fecha_ano();
?>
<script src="<?= controlador::$rutaAPP ?>app/vistas/rrhh/asset/js/js.js?v=<?= rand() ?>"></script>
<link href="<?= controlador::$rutaAPP ?>app/vistas/rrhh/asset/css/css.css?v=<?= rand() ?>" rel="stylesheet" type="text/css" />
<input type="hidden" name="url_link" id="url_link" value="<?= controlador::$rutaAPP ?>">


<?php 
  echo $rrhh->liquidacion_de_sueldo($idTrabajador, $mes, $ano);
  
  if($print == 1){
        echo '<script>
              window.print();
            </script>';
      }
?>