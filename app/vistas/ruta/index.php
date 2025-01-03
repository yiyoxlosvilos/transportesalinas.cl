<?php
  require_once __dir__."/../../controlador/utilidadesControlador.php";
  require_once __dir__."/../../controlador/recursosControlador.php";
  require_once __dir__."/../../controlador/centroCostoControlador.php";
  require_once __dir__."/../../controlador/rutaControlador.php";
  require_once __dir__."/../../recursos/head.php";

  $centroCostos= new CentroCostos();
  $recursos    = new Recursos();
  $ruta        = new Ruta();
  $mvc2        = new controlador();

	$dia         = Utilidades::fecha_dia();
	$mes         = Utilidades::fecha_mes();
  $ano         = Utilidades::fecha_ano();
  $hoy         = Utilidades::fecha_hoy();

  session_start();
  $rutChofer       = $_SESSION['RUTCHOFER'];
  $codigo_servicio = $_SESSION['CODSERVICIO'];
?>
<script src="<?= controlador::$rutaAPP ?>app/vistas/ruta/asset/js/js.js?v=<?= rand() ?>"></script>
<script src="<?= controlador::$rutaAPP ?>app/vistas/centro_costo/asset/js/js.js?v=<?= rand() ?>"></script>
<link href="<?= controlador::$rutaAPP ?>app/vistas/ruta/asset/css/css.css?v=<?= rand() ?>" rel="stylesheet" type="text/css" />

<input type="hidden" name="url_link" id="url_link" value="<?= controlador::$rutaAPP ?>">
<!DOCTYPE html>
<html>
<body id="body-pd">
  <div class="row paddingtop40px mt-3" id="control_ruta">
<?php 
  if(strlen($rutChofer) == 0){
?>
    <div class="col-12 container d-flex justify-content-center" id="panel_ruta">
      <div class="card mx-5 my-5">
        <div class="card-body py-2 px-2 border shadow">
          <h2 align="center" class="card-heading py-3 px-5">Hoja de Ruta: <?= $codigo_servicio ?></h2>
          <div class="row rone mx-3 my-3">
            <div class="col-md-6">
              <div class="form-group"><label for="inputRut" >Rut Chofer</label><input type="text" class="form-control" id="inputRut" placeholder="Rut Chofer"></div>
            </div>
            <div class="col-md-6">
              <div class="form-group"><label for="inputCodigo" >Codigo Servicio</label><input type="text" class="form-control" id="inputCodigo" placeholder="C&oacute;digo Servicio"></div>
            </div>
          </div>
          <div class="row rtwo mx-3">
            <div class="col-md-6">
              <div class="form-group"><button type="submit" class="btn btn-primary mb-2" onclick="ingresar_hoja_ruta()">Ingresar&nbsp;&nbsp;<span class="fas fa-arrow-right"></span></button></div>
            </div>
          </div>
        </div>
      </div>
    </div>
<?php 
  }else{
    echo $ruta->mostrar_detalle_servicio_ruta($_SESSION["IDCODSERVICIO"], $_SESSION["IDCHOFER"]);
  }
?>
  </div>
</body>
</html>
<script>
</script>