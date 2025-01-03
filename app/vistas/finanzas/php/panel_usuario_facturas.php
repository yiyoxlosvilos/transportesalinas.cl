<?php
  require_once __dir__."/../../../controlador/controlador.php";
  require_once __dir__."/../../../controlador/finanzasControlador.php";
  require_once __dir__."/../../../controlador/recursosControlador.php";
  require_once __dir__."/../../../controlador/utilidadesControlador.php";
  require_once __dir__."/../../../recursos/head.php";

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
                  <div class="nav-rounded">
                    <div class="product-icons">
                      <i class="fas fa-shipping-fast h6"></i>
                    </div>
                  </div>
                  <div class="product-tab-content">
                    <h6>Proveedores</h6>
                  </div></a>
                </li>
                <li class="nav-item" role="presentation"> <a class="nav-link" id="target-project-tab" data-bs-toggle="pill" href="#target-project" role="tab" aria-controls="target-project" aria-selected="false" tabindex="-1">
                    <div class="absolute-border"></div>
                    <div class="nav-rounded">
                      <div class="product-icons">
                        <i class="fas fa-bus h6"></i>
                      </div>
                    </div>
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
                  <div class="row">
                    <div class="col-lg-15 mb-2 shadow">
                      <div class="container mb-4">
                        <div class="row">
                          <div class="col">
                            <div class="col-lg-3 mb-2">
                              <p align="center" class="text-secondary font-weight-light h4">Proveedores</p>
                            </div> 
                          </div>
                          <div class="col">
                            <div class="col-lg-3 mb-2">
                              <span class="btn btn-success w-lg waves-effect waves-light w-100 waves-effect waves-light " type="button" onclick="nuevo_proveedor()">
                                <i class="bi bi-plus-circle-dotted"></i>
                              </span>
                            </div>
                          </div>
                          <div class="col-15" id="nuevo_proveedor">
                            <?= $finanzas->listado_proveedores() ?>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>

                </div>
                <div class="tab-pane fade" id="target-project" role="tabpanel" aria-labelledby="target-project-tab">
                  <div class="row">
                    <div class="col-8">
                        <h3 class="text-dark mb-2"><span class="mdi mdi-format-list-bulleted"></span> Detalles Traslados</h3>
                      </div>
                    <div class="col">
                      <button class="btn btn-sm btn-dark" onclick="asignar_traslados()"><i class="fas fa-shipping-fast text-white"></i> <span class="ocultar">Nuevo Traslado</span></button>
                    </div>
                    <div class="col-15 mt-3" id="traer_traslados">
                      <?= $centroCostos->listado_de_traslados('') ?>
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