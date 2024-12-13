<?php
  require_once __dir__."/../../controlador/utilidadesControlador.php";
  require_once __dir__."/../../controlador/recursosControlador.php";
  require_once __dir__."/../../controlador/parametrosControlador.php";
  require_once __dir__."/../../recursos/head.php";

  $parametros  = new Parametros();
  $recursos    = new Recursos();
  $mvc2        = new controlador();
  $mvc2->iniciar_sesion();

	$dia         = Utilidades::fecha_dia();
	$mes         = Utilidades::fecha_mes();
  $ano         = Utilidades::fecha_ano();
  $hoy         = Utilidades::fecha_hoy();

  $empresa     = $recursos->datos_empresa();

  // MENU
  $mvc2->menu_usuarios();
?>
<script src="<?= controlador::$rutaAPP ?>app/vistas/parametros/asset/js/js.js?v=<?= rand() ?>"></script>
<link href="<?= controlador::$rutaAPP ?>app/vistas/parametros/asset/css/css.css?v=<?= rand() ?>" rel="stylesheet" type="text/css" />

<script src="<?= controlador::$rutaAPP ?>app/recursos/js/table.js?v=<?= rand() ?>"></script>
<link href="<?= controlador::$rutaAPP ?>app/recursos/css/table.css?v=<?= rand() ?>" rel="stylesheet" type="text/css" />

<input type="hidden" name="url_link" id="url_link" value="<?= controlador::$rutaAPP ?>">
<!DOCTYPE html>
<html>
<body id="body-pd">
  <div class="row paddingtop40px mt-5">
    <div class="col-6 p-2 mt-2 mb-2 ml-2 animate__animated animate__fadeIn animate__slow shadow">
      <div class="d-flex flex-wrap align-items-center mb-4">
        <p class="h4">Usuarios</p>
        <div class="ms-auto">
          <button class="btn btn-success" href="<?= controlador::$rutaAPP ?>app/vistas/parametros/php/nuevo_usuario.php" data-fancybox data-type="iframe" data-preload="true" data-width="800" data-height="600"><i class="bi bi-plus-square-dotted"></i></button>
        </div>
      </div>
      <div class="col-xl-12 animate__animated animate__fadeIn animate__slow" id="editar_prevision">
        <?= $parametros->listar_usuarios() ?>
      </div>
    </div>
    <div class="col-6 p-2 mt-2 mb-2 ml-2 animate__animated animate__fadeIn animate__slow shadow" >
      <div class="d-flex flex-wrap align-items-center mb-4">
        <p class="h4">Sucursales</p>
        <div class="ms-auto">
          <button class="btn btn-success" href="<?= controlador::$rutaAPP ?>app/vistas/parametros/php/nueva_sucursal.php" data-fancybox data-type="iframe" data-preload="true" data-width="800" data-height="600"><i class="bi bi-plus-square-dotted"></i></button>
        </div>
      </div>
      <div class="col-xl-12 animate__animated animate__fadeIn animate__slow" id="editar_pension">
        <?= $parametros->listar_sucursales(); ?>
      </div>
    </div>
    <div class="col-6 p-2 mt-2 mb-2 ml-2 animate__animated animate__fadeIn animate__slow shadow" >
      <div class="d-flex flex-wrap align-items-center mb-4">
        <p class="h4">Datos Empresa</p>
        <div class="ms-auto">
          <button class="btn btn-primary" href="<?= controlador::$rutaAPP ?>app/vistas/parametros/php/editar_empresa.php" data-fancybox data-type="iframe" data-preload="true" data-width="800" data-height="600"><i class="bi bi-pencil-square"></i></button>
        </div>
        <table width="100%" class="table">
          <tr>
            <th>Razón Social:</th>
            <td><?= $empresa[0]['emp_razonsocial'] ?></td>
          </tr>
          <tr>
            <th>Rut:</th>
            <td><?= Utilidades::rut($empresa[0]['emp_rut']) ?></td>
          </tr>
          <tr>
            <th>Dirección:</th>
            <td><?= $empresa[0]['emp_direccion'] ?></td>
          </tr>
        </table>
      </div>
    </div>
    <div class="col-6 p-2 mt-2 mb-2 ml-2 animate__animated animate__fadeIn animate__slow shadow" >
      <div class="d-flex flex-wrap align-items-center mb-4">
        <p class="h4">Logo Empresa</p>
        <div class="ms-auto">
          <button class="btn btn-primary" href="<?= controlador::$rutaAPP ?>app/vistas/parametros/php/editar_logo.php" data-fancybox data-type="iframe" data-preload="true" data-width="800" data-height="600"><i class="bi bi-pencil-square"></i></button>
        </div>
      </div>
      <div class="col-xl-12 animate__animated animate__fadeIn animate__slow" id="editar_pension">
         <table width="100%" class="table">
          <tr>
            <th>Imágen:</th>
            <td align="center">
              <?= $recursos->imagen_empresa(); ?>
            </td>
          </tr>
        </table>
      </div>
    </div>
    <div class="col-12 p-2 mt-2 mb-2 ml-2 animate__animated animate__fadeIn animate__slow shadow" >
      <div class="d-flex flex-wrap align-items-center mb-4">
        <p class="h4">Localidades</p>
        <div class="ms-auto">
          <button class="btn btn-success" href="<?= controlador::$rutaAPP ?>app/vistas/parametros/php/nueva_localidad.php" data-fancybox data-type="iframe" data-preload="true" data-width="800" data-height="600"><i class="bi bi-plus-square-dotted"></i></button>
        </div>
      </div>
      <div class="col-xl-12 animate__animated animate__fadeIn animate__slow" id="editar_pension">
        <?= $parametros->listar_localidades(); ?>
      </div>
    </div>
  </div>
</body>
</html>
<script>
  initCounterNumber();
  initCounterPorcent();

  $(document).ready(function() {
    $('#listado_usuario').DataTable({     
      "aLengthMenu": [[10, 20, 30, -1], [10, 20, 30, "Todos"]],
        "iDisplayLength": 20
       });
  });

  $(document).ready(function() {
    $('#listado_localidades').DataTable({     
      "aLengthMenu": [[10, 20, 30, -1], [10, 20, 30, "Todos"]],
        "iDisplayLength": 10
       });
  });
</script>