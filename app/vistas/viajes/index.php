<?php
  require_once __dir__."/../../controlador/utilidadesControlador.php";
  require_once __dir__."/../../controlador/recursosControlador.php";
  require_once __dir__."/../../controlador/centroCostoControlador.php";
  require_once __dir__."/../../recursos/head.php";

  $centroCostos= new CentroCostos();
  $recursos    = new Recursos();
  $mvc2        = new controlador();
  $mvc2->iniciar_sesion();
	$dia         = Utilidades::fecha_dia();
	$mes         = Utilidades::fecha_mes();
  $ano         = Utilidades::fecha_ano();
  $hoy         = Utilidades::fecha_hoy();

  // MENU
  $mvc2->menu_usuarios();
?>
<script src="<?= controlador::$rutaAPP ?>app/vistas/viajes/asset/js/js.js?v=<?= rand() ?>"></script>
<link href="<?= controlador::$rutaAPP ?>app/vistas/viajes/asset/css/css.css?v=<?= rand() ?>" rel="stylesheet" type="text/css" />

<script src="<?= controlador::$rutaAPP ?>app/recursos/js/table.js?v=<?= rand() ?>"></script>
<link href="<?= controlador::$rutaAPP ?>app/recursos/css/table.css?v=<?= rand() ?>" rel="stylesheet" type="text/css" />

<input type="hidden" name="url_link" id="url_link" value="<?= controlador::$rutaAPP ?>">
<!DOCTYPE html>
<html>
<body id="body-pd">
  <div class="row paddingtop40px mt-5">
    <div class="d-flex flex-wrap align-items-center mb-4">
    <span class="h2 animate__animated animate__pulse"><i class="bi bi-bookmark ocultar"></i> <span class="cursor" onclick="location.reload()"></span></span>
    <div class="ms-auto">
      <button class="btn btn-soft-light waves-effect waves-light" onclick="location.reload()"><i class="fas fa-home h4 text-info"></i> <span class="ocultar"></span></button>
    </div>
    <div class="ms-auto">
      <button class="btn btn-danger" onclick="traer_menu('asignar_producto')"><i class="fas fa-truck-moving h4 text-white"></i> <span class="ocultar">Viajes</span></button>
    </div>
    <div class="ms-auto">
      <button class="btn btn-info" onclick="asignar_traslados()"><i class="fas fa-bus h4 text-white"></i> <span class="ocultar">Traslados</span></button>
    </div>
    <div class="ms-auto">
      <button class="btn btn-primary" onclick="asignar_arriendo()"><i class="fas fa-truck h4 text-white"></i> <span class="ocultar">Arriendos</span></button>
    </div>
    <div class="ms-auto">
      <button class="btn btn-dark" onclick="gastos_empresa()"><i class="fas fa-dollar-sign h4 text-white"></i> <span class="ocultar">Gastos</span></button>
    </div>
    <div class="ms-auto">
      <button class="btn btn-success" onclick="facturas_proveedores()"><i class="fas fa-receipt h4 text-white"></i> <span class="ocultar">Facturas Proveedores</span></button>
    </div>
    <div class="ms-auto">
      <button class="btn btn-warning" onclick="facturas_clientes()"><i class="fas fa-receipt h4 text-white"></i> <span class="ocultar">Facturas Clientes</span></button>
    </div>
  </div>
  <hr>
    <div class="row" id="traer_productos_categoria">
      <div class="row">
              <div class="row nav nav-pills navbar navbar-expand-lg navbar-light " id="v-pills-tab" aria-orientation="horizontal" role="tablist">
                <div class="nav-link  col text-center active cursor" data-bs-toggle="tab" href="#home1" role="tab">
                    <span class="mdi mdi-truck-check-outline cursor h5">&nbsp;&nbsp;Fletes</span>
                </div>
                <div class="nav-link  col text-center cursor" data-bs-toggle="tab" href="#transporte" role="tab">
                    <span class="mdi mdi-bus cursor h5">&nbsp;&nbsp;Traslados</span>
                </div>
                <div class="nav-link  col text-center cursor" data-bs-toggle="tab" href="#arriendos" role="tab">
                    <span class="mdi mdi-truck-outline cursor h5">&nbsp;&nbsp;Arriendos</span>
                </div>
                <div class="nav-link col  text-center cursor" data-bs-toggle="tab" href="#profile1" role="tab">
                    <span class="mdi mdi-currency-usd cursor h5">&nbsp;&nbsp;Gastos</span>
                </div>
                <div class="nav-link col  text-center cursor" data-bs-toggle="tab" href="#messages1" role="tab">
                  <span class="mdi mdi-inbox-full h5 cursor">&nbsp;&nbsp;Facturas</span>
                </div>
              </div>
              <div class="tab-content border" id="v-pills-tabContent">
                <div class="tab-pane active" id="home1" role="tabpanel">
                  <div class="d-flex flex-wrap align-items-center mb-4">
                    <h3 class="text-center text-primary mb-2"><span class="mdi mdi-format-list-bulleted"></span> Detalles Fletes</h3>
                  </div>
                  
                </div>
                <div class="tab-pane" id="transporte" role="tabpanel">
                  <div class="d-flex flex-wrap align-items-center mb-4">
                    <h3 class="text-center text-primary mb-2"><span class="mdi mdi-format-list-bulleted"></span> Detalles Traslados</h3>
                  </div>
                  
                </div>
                <div class="tab-pane" id="arriendos" role="tabpanel">
                  <div class="d-flex flex-wrap align-items-center mb-4">
                    <h3 class="text-center text-primary mb-2"><span class="mdi mdi-format-list-bulleted"></span> Detalles Arriendos</h3>
                  </div>
                 
                </div>
                <div class="tab-pane" id="profile1" role="tabpanel">
                  <div class="d-flex flex-wrap align-items-center mb-4">
                    <h3 class="text-center text-primary mb-2"><span class="mdi mdi-format-list-bulleted"></span> Detalles Gastos</h3>
                  </div>
                  
                </div>
                <div class="tab-pane" id="messages1" role="tabpanel">
                  <div class="d-flex flex-wrap align-items-center mb-4">
                    <h3 class="text-center text-primary mb-2"><span class="mdi mdi-format-list-bulleted"></span> Detalles Facturas</h3>
                  </div>
                  <p class="h4">Facturas Proveedores</p>
                  
                  <p class="h4">Facturas Clientes</p>
                  
                </div>
              </div>
            </div>
    </div>
  </div>
</body>
</html>
<script>
  $(document).ready(function() {
    $("#servicios_pendientes").DataTable({     
      "aLengthMenu": [[5, 10, 20, 30, -1], [5, 10, 20, 30, "Todos"]],
      "iDisplayLength": 5
   });
  });

  $(document).ready(function() {
    $("#cotizaciones_pendientes").DataTable({     
      "aLengthMenu": [[5, 10, 20, 30, -1], [5, 10, 20, 30, "Todos"]],
      "iDisplayLength": 5
   });
  });

  $(document).ready(function() {
    $("#servicios_aceptados").DataTable({     
      "aLengthMenu": [[5, 10, 20, 30, -1], [5, 10, 20, 30, "Todos"]],
      "iDisplayLength": 5
   });
  });

  $(document).ready(function() {
    $("#cotizaciones_aceptados").DataTable({     
      "aLengthMenu": [[5, 10, 20, 30, -1], [5, 10, 20, 30, "Todos"]],
      "iDisplayLength": 5
   });
  });

  $(document).ready(function() {
    $("#EDP_aceptados").DataTable({     
      "aLengthMenu": [[5, 10, 20, 30, -1], [5, 10, 20, 30, "Todos"]],
      "iDisplayLength": 5
   });
  });
</script>