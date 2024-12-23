<?php
  session_start();
  require_once __dir__."/../../../controlador/controlador.php";
  $mvc         = new controlador();

  require_once __dir__."/../../../controlador/centroCostoControlador.php";
  require_once __dir__."/../../../controlador/recursosControlador.php";
  require_once __dir__."/../../../controlador/utilidadesControlador.php";
  require_once __dir__."/../../../recursos/head.php";

  $centroCostos= new CentroCostos();
  $utilidades  = new Utilidades();
  $recursos    = new Recursos();

  $dia         = Utilidades::fecha_dia();
  $mes         = Utilidades::fecha_mes();
  $ano         = Utilidades::fecha_ano();
  $hoy         = Utilidades::fecha_hoy();

  $idFlete     = $_REQUEST['idFlete'];
?>
<script src="<?= controlador::$rutaAPP ?>app/vistas/centro_costo/asset/js/js.js?v=<?= rand() ?>"></script>
<link href="<?= controlador::$rutaAPP ?>app/vistas/centro_costo/asset/css/css.css?v=<?= rand() ?>" rel="stylesheet" type="text/css" />

<script src="<?= controlador::$rutaAPP ?>app/recursos/js/table.js?v=<?= rand() ?>"></script>
<link href="<?= controlador::$rutaAPP ?>app/recursos/css/table.css?v=<?= rand() ?>" rel="stylesheet" type="text/css" />

<link rel="stylesheet" href="<?= controlador::$rutaAPP ?>app/recursos/css/choices.css?v=<?= rand() ?>">
<script src="<?= controlador::$rutaAPP ?>app/recursos/js/choice.js?v=<?= rand() ?>"></script>

<input type="hidden" name="url_link" id="url_link" value="<?= controlador::$rutaAPP ?>">
<input type="hidden" name="idServicio" id="idServicio" value="ALL">

<div class="row" id="procesar_venta">

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
                            <h6>Detalles</h6>
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
                            <h6>Editar</h6>
                          </div></a></li>
                      <li class="nav-item" role="presentation"> <a class="nav-link" id="budget-project-tab" data-bs-toggle="pill" href="#budget-project" role="tab" aria-controls="budget-project" aria-selected="false" tabindex="-1">
                          <div class="absolute-border"></div>
                          <div class="nav-rounded">
                            <div class="product-icons">
                              <i class="fas fa-truck h6"></i>
                            </div>
                          </div>
                          <div class="product-tab-content">
                            <h6>Anexos</h6>
                          </div></a></li>
                      <li class="nav-item" role="presentation"><a class="nav-link" id="team-project-tab" data-bs-toggle="pill" href="#team-project" role="tab" aria-controls="team-project" aria-selected="false" tabindex="-1">
                          <div class="absolute-border"></div>
                          <div class="nav-rounded">
                            <div class="product-icons">
                             <i class="fas fa-dollar-sign h6"></i>
                            </div>
                          </div>
                          <div class="product-tab-content">
                            <h6>Pagos</h6>
                          </div></a></li>
                      <li class="nav-item" role="presentation"><a class="nav-link " id="attachment-tab" data-bs-toggle="pill" href="#attachment" role="tab" aria-controls="attachment" aria-selected="true">
                          <div class="absolute-border"></div>
                          <div class="nav-rounded">
                            <div class="product-icons">
                              <i class="fas fa-receipt h6"></i>
                            </div>
                          </div>
                          <div class="product-tab-content">
                            <h6>Imprimir</h6>
                          </div></a></li>
                    </ul>
                  </div>
                </div>
              </div>
              <div class="col-xxl-10 recent-xl-77 col-xl-9 box-col-9">
                <div class="row">
                  <div class="col">
                    <div class="tab-content" id="add-product-pills-tabContent">
                      <div class="tab-pane fade active show" id="overview-project" role="tabpanel" aria-labelledby="overview-project-tab">
                        <div class="row">
                          <div class="col-8">
                            <h3 class="text-dark mb-2"><i class="mdi mdi-format-list-bulleted"></i> Detalles de Viaje</h3>
                          </div>    
                        </div>
                      </div>
                      <div class="tab-pane fade" id="target-project" role="tabpanel" aria-labelledby="target-project-tab">
                        <div class="row">
                          <div class="col-8">
                            <h3 class="text-dark mb-2"><i class="mdi mdi-format-list-bulleted"></i> Editar Viaje</h3>
                          </div>
                          <div class="col-lg-15"><?= $centroCostos->formulario_editar_flete($idFlete); ?></div>   
                        </div>
                      </div>
                      <div class="tab-pane fade" id="budget-project" role="tabpanel" aria-labelledby="budget-project-tab">
                        <div class="row">
                          <div class="col-8">
                            <h3 class="text-dark mb-2"><i class="mdi mdi-format-list-bulleted"></i> Anexos Viaje</h3>
                          </div>    
                        </div>
                      </div>
                      <div class="tab-pane fade" id="team-project" role="tabpanel" aria-labelledby="team-project-tab">
                        <div class="row">
                          <div class="col-8">
                            <h3 class="text-dark mb-2"><i class="mdi mdi-format-list-bulleted"></i> Ingresar Pagos</h3>
                          </div>    
                        </div>
                      </div>
                      <div class="tab-pane fade active" id="attachment" role="tabpanel" aria-labelledby="attachment-tab">
                        <div class="row">
                          <div class="col-8">
                            <h3 class="text-dark mb-2"><i class="mdi mdi-format-list-bulleted"></i> Descargar e Imprimir</h3>
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
    var multipleCancelButton = new Choices("#inputOrigen", {
      removeItemButton: true,
    });
  });
  $(document).ready(function() { 
    var multipleCancelButton = new Choices("#inputDestino", {
      removeItemButton: true,
    });
  });
</script>