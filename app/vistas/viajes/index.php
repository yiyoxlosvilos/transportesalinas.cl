<?php
  require_once __dir__."/../../controlador/utilidadesControlador.php";
  require_once __dir__."/../../controlador/recursosControlador.php";
  require_once __dir__."/../../controlador/viajesControlador.php";
  require_once __dir__."/../../recursos/head.php";

  $centroCostos= new Viajes();
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
<link rel="stylesheet" href="<?= controlador::$rutaAPP ?>app/recursos/css/choices.css?v=<?= rand() ?>">
<script src="<?= controlador::$rutaAPP ?>app/recursos/js/choice.js?v=<?= rand() ?>"></script>
<script src="<?= controlador::$rutaAPP ?>app/vistas/viajes/asset/js/js.js?v=<?= rand() ?>"></script>
<link href="<?= controlador::$rutaAPP ?>app/vistas/viajes/asset/css/css.css?v=<?= rand() ?>" rel="stylesheet" type="text/css" />

<script src="<?= controlador::$rutaAPP ?>app/recursos/js/table.js?v=<?= rand() ?>"></script>
<link href="<?= controlador::$rutaAPP ?>app/recursos/css/table.css?v=<?= rand() ?>" rel="stylesheet" type="text/css" />

<input type="hidden" name="url_link" id="url_link" value="<?= controlador::$rutaAPP ?>">
<!DOCTYPE html>
<html>
<body id="body-pd">
  <div class="row paddingtop40px mt-5">
    <div class="container-fluid main-scope-project">
      <div class="row scope-bottom-wrapper">
              <div class="col-xxl-2 recent-xl-23 col-xl-3 box-col-3">
                <div class="card"> 
                  <div class="card-body">
                    <ul class="sidebar-left-icons nav nav-pills" id="add-product-pills-tab" role="tablist">
                      <li class="nav-item" role="presentation"> 
                        <a class="nav-link" id="overview-project-tab" data-bs-toggle="pill" href="#overview-project" role="tab" aria-controls="overview-project" aria-selected="false" tabindex="-1">
                          <div class="absolute-border"></div>
                          <div class="nav-rounded">
                            <div class="product-icons">
                              <i class="fas fa-shipping-fast h4"></i>
                            </div>
                          </div>
                          <div class="product-tab-content">
                            <h6>Viajes</h6>
                          </div></a>
                      </li>
                      <li class="nav-item" role="presentation"> <a class="nav-link" id="target-project-tab" data-bs-toggle="pill" href="#target-project" role="tab" aria-controls="target-project" aria-selected="false" tabindex="-1">
                          <div class="absolute-border"></div>
                          <div class="nav-rounded">
                            <div class="product-icons">
                              <i class="fas fa-bus h4"></i>
                            </div>
                          </div>
                          <div class="product-tab-content">
                            <h6>Traslados</h6>
                          </div></a></li>
                      <li class="nav-item" role="presentation"> <a class="nav-link" id="budget-project-tab" data-bs-toggle="pill" href="#budget-project" role="tab" aria-controls="budget-project" aria-selected="false" tabindex="-1">
                          <div class="absolute-border"></div>
                          <div class="nav-rounded">
                            <div class="product-icons">
                              <i class="fas fa-truck h4"></i>
                            </div>
                          </div>
                          <div class="product-tab-content">
                            <h6>Arriendos</h6>
                          </div></a></li>
                      <li class="nav-item" role="presentation"><a class="nav-link" id="team-project-tab" data-bs-toggle="pill" href="#team-project" role="tab" aria-controls="team-project" aria-selected="false" tabindex="-1">
                          <div class="absolute-border"></div>
                          <div class="nav-rounded">
                            <div class="product-icons">
                             <i class="fas fa-dollar-sign h4"></i>
                            </div>
                          </div>
                          <div class="product-tab-content">
                            <h6>Gastos</h6>
                          </div></a></li>
                      <li class="nav-item" role="presentation"><a class="nav-link active" id="attachment-tab" data-bs-toggle="pill" href="#attachment" role="tab" aria-controls="attachment" aria-selected="true">
                          <div class="absolute-border"></div>
                          <div class="nav-rounded">
                            <div class="product-icons">
                              <i class="fas fa-receipt h4"></i>
                            </div>
                          </div>
                          <div class="product-tab-content">
                            <h6>Facturas Proveedores</h6>
                          </div></a></li>
                      <li class="nav-item" role="presentation"><a class="nav-link" id="activity-project-tab" data-bs-toggle="pill" href="#activity-project" role="tab" aria-controls="activity-project" aria-selected="false" tabindex="-1">
                          <div class="absolute-border"></div>
                          <div class="nav-rounded">
                            <div class="product-icons">
                              <i class="fas fa-receipt h4"></i>
                            </div>
                          </div>
                          <div class="product-tab-content">
                            <h6>Facturas Clientes</h6>
                          </div></a></li>
                    </ul>
                  </div>
                </div>
              </div>
              <div class="col-xxl-10 recent-xl-77 col-xl-9 box-col-9">
                <div class="row">
                  <div class="col-12">
                    <div class="tab-content" id="add-product-pills-tabContent">
                      <div class="tab-pane fade active show" id="overview-project" role="tabpanel" aria-labelledby="overview-project-tab">
                        <div class="row">
                          <div class="col-15">
                            <div class="ms-auto">
                              <button class="btn btn-sm btn-success" onclick="traer_menu('asignar_producto')"><i class="fas fa-shipping-fast h4 text-white"></i> <span class="ocultar">Nuevo Viajes</span></button>
                            </div>
                          </div>
                          <div class="col-15">
                            <div class="d-flex flex-wrap align-items-center mb-4">
                              <h3 class="text-center text-primary mb-2"><span class="mdi mdi-format-list-bulleted"></span> Detalles Viajes</h3>
                            </div>
                             <?= $centroCostos->traer_fletes_asigandos() ?>
                          </div>
    
                        </div>
                      </div>

                      <div class="tab-pane fade" id="target-project" role="tabpanel" aria-labelledby="target-project-tab">
                      </div>
                      <div class="tab-pane fade" id="budget-project" role="tabpanel" aria-labelledby="budget-project-tab">
                      </div>
                      <div class="tab-pane fade" id="team-project" role="tabpanel" aria-labelledby="team-project-tab">
                      </div>
                      <div class="tab-pane fade active show" id="attachment" role="tabpanel" aria-labelledby="attachment-tab"></div>
                      <div class="tab-pane fade" id="activity-project" role="tabpanel" aria-labelledby="activity-project-tab"> </div>
                    </div>
                  </div>
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