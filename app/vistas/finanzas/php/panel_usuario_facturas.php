<?php
  require_once __dir__."/../../../controlador/controlador.php";
  require_once __dir__."/../../../controlador/finanzasControlador.php";
  require_once __dir__."/../../../controlador/recursosControlador.php";
  require_once __dir__."/../../../controlador/utilidadesControlador.php";
  require_once __dir__."/../../../recursos/head_panel.php";

  $finanzas    = new Finanzas();
  $recursos    = new Recursos();
  $utilidades  = new Utilidades();
  $mvc2        = new controlador();

  $dia         = Utilidades::fecha_dia();
  $mes         = Utilidades::fecha_mes();
  $ano         = Utilidades::fecha_ano();
  $hoy         = Utilidades::fecha_hoy();
?>
<script src="<?= controlador::$rutaAPP ?>app/recursos/js/table.js?v=<?= rand() ?>"></script>
<link href="<?= controlador::$rutaAPP ?>app/recursos/css/table.css?v=<?= rand() ?>" rel="stylesheet" type="text/css" />
<script src="<?= controlador::$rutaAPP ?>app/vistas/finanzas/asset/js/js.js?v=<?= rand() ?>"></script>
<link href="<?= controlador::$rutaAPP ?>app/vistas/finanzas/asset/css/css.css?v=<?= rand() ?>" rel="stylesheet" type="text/css" />
<input type="hidden" name="url_link" id="url_link" value="<?= controlador::$rutaAPP ?>">
<div class="container-fluid main-scope-project">
      <div class="row scope-bottom-wrapper">
        <div class="col-xxl-2 recent-xl-23 col-xl-3 box-col-3">
          <div class="card"> 
            <div class="card-body">
              <ul class="sidebar-left-icons nav nav-pills" id="add-product-pills-tab" role="tablist">
                <li class="nav-item" role="presentation"> 
                  <a class="nav-link active" id="overview-project-tab" data-bs-toggle="pill" href="#overview-project" role="tab" aria-controls="overview-project" aria-selected="false" tabindex="-1">
                  <div class="absolute-border"></div>
                  <div class="product-tab-content">
                    <h6>Proveedores</h6>
                  </div></a>
                </li>
                <li class="nav-item" role="presentation"> <a class="nav-link" id="target-project-tab" data-bs-toggle="pill" href="#target-project" role="tab" aria-controls="target-project" aria-selected="false" tabindex="-1">
                    <div class="absolute-border"></div>
                    <div class="product-tab-content">
                      <h6>Clientes</h6>
                    </div></a>
                </li>
              </ul>
            </div>
          </div>
        </div>
        <div class="col-xxl-10 recent-xl-77 col-xl-9 box-col-9">
          <div class="row">
            <div class="col-12">
              <div class="tab-content" id="add-product-pills-tabContent">
                <div class="tab-pane fade active show" id="overview-project" role="tabpanel" aria-labelledby="overview-project-tab">
                    <div class="d-flex flex-wrap align-items-center mb-4">
                      <span class="h2 animate__animated animate__pulse"><i class="bi bi-search"></i> <span class="ocultar">Panel Proveedores</span></span>
                      <div class="ms-auto">
                        <button class="btn btn-success" onclick="nuevo_proveedor()"><i class="bi bi-person-bounding-box h4 text-white"></i> <span class="ocultar">Nuevo</span></button>
                      </div>
                    </div>
                    <hr class="mt-2 mb-3"/>
                    <div class="row" >
                      <div class="col-15" id="nuevo_proveedor">
                        <?= $finanzas->listado_proveedores() ?>
                      </div>
                    </div>                
                </div>
                <div class="tab-pane fade" id="target-project" role="tabpanel" aria-labelledby="target-project-tab">
                  <div class="row" id="procesar_venta">
                    <div class="d-flex flex-wrap align-items-center mb-4">
                      <span class="h2 animate__animated animate__pulse"><i class="bi bi-search"></i> <span class="ocultar">Panel Cliente</span></span>
                      <div class="ms-auto">
                        <button class="btn btn-success" onclick="nuevo_cliente_control()"><i class="bi bi-person-bounding-box h4 text-white"></i> <span class="ocultar">Nuevo</span></button>
                      </div>
                    </div>
                    <hr class="mt-2 mb-3"/>
                    <div class="col-lg-15 p-2 mt-2 mb-2 ml-2 animate__animated animate__fadeIn shadow" id="panel_caja">
                      <?= $recursos->traer_clientes_consulta(); ?>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>


<script>
  $(document).ready(function() {
    $("#proveedores_list").DataTable({     
        "aLengthMenu": [[5, 10, 20], [5, 10, 20]],
        "iDisplayLength": 10
    });
  });
</script>