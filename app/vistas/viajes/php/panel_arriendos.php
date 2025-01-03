<?php
  session_start();
  require_once __dir__."/../../../controlador/controlador.php";
  $mvc         = new controlador();

  require_once __dir__."/../../../controlador/viajesControlador.php";
  require_once __dir__."/../../../controlador/recursosControlador.php";
  require_once __dir__."/../../../controlador/utilidadesControlador.php";
  require_once __dir__."/../../../recursos/head_panel.php";

  $centroCostos= new Viajes();
  $utilidades  = new Utilidades();
  $recursos    = new Recursos();

  $dia         = Utilidades::fecha_dia();
  $mes         = Utilidades::fecha_mes();
  $ano         = Utilidades::fecha_ano();
  $hoy         = Utilidades::fecha_hoy();

  $idTraslados = $_REQUEST['idArriendo'];

  $datos_fletes = $recursos->datos_arriendos_id($idTraslados);
?>
<script src="<?= controlador::$rutaAPP ?>app/vistas/viajes/asset/js/js.js?v=<?= rand() ?>"></script>
<link href="<?= controlador::$rutaAPP ?>app/vistas/viajes/asset/css/css.css?v=<?= rand() ?>" rel="stylesheet" type="text/css" />

<script src="<?= controlador::$rutaAPP ?>app/recursos/js/table.js?v=<?= rand() ?>"></script>
<link href="<?= controlador::$rutaAPP ?>app/recursos/css/table.css?v=<?= rand() ?>" rel="stylesheet" type="text/css" />

<script src="<?= controlador::$rutaAPP ?>app/vistas/viajes/asset/js/upload_traslados.js?v=<?= rand() ?>"></script>
<link href="<?= controlador::$rutaAPP ?>app/recursos/css/upload.css?v=<?= rand() ?>" rel="stylesheet" type="text/css" />

<link rel="stylesheet" href="<?= controlador::$rutaAPP ?>app/recursos/css/choices.css?v=<?= rand() ?>">
<script src="<?= controlador::$rutaAPP ?>app/recursos/js/choice.js?v=<?= rand() ?>"></script>

<input type="hidden" name="url_link" id="url_link" value="<?= controlador::$rutaAPP ?>">
<input type="hidden" name="idServicio" id="idServicio" value="ALL">

<input type="hidden" name="idArriendo" id="idArriendo" value="<?= $idTraslados ?>">
<input type="hidden" name="idFlete" id="idFlete" value="<?= $idTraslados ?>">
<input type="hidden" name="idTipoServicio" id="idTipoServicio" value="3">

  <div class="row scope-bottom-wrapper" id="procesar_venta">
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

                      <li class="nav-item" role="presentation"> 
                        <a class="nav-link" id="overview-bitacora-tab" data-bs-toggle="pill" href="#overview-bitacora" role="tab" aria-controls="overview-bitacora" aria-selected="false" tabindex="-1">
                          <div class="absolute-border"></div>
                          <div class="nav-rounded">
                            <div class="product-icons">
                              <i class="fas fa-book h6"></i>
                            </div>
                          </div>
                          <div class="product-tab-content">
                            <h6>Notas</h6>
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
                              <i class="fas fa-paperclip h6"></i>
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
                <div class="col-12">
                  <h3 class="text-dark mb-2"><i class="mdi mdi-format-list-bulleted"></i> Detalle Arriendo</h3>
                </div> 
                <div class="col-12" style="background-color: #f7f7f7"><?= $centroCostos->detalle_de_arriendo($idTraslados); ?></div> 
              </div>
            </div>
            <div class="tab-pane fade" id="overview-bitacora" role="tabpanel" aria-labelledby="overview-bitacora-tab">
              <div class="row">
                <div class="col-8">
                  <h3 class="text-dark mb-2"><i class="fas fa-book"></i> Notas de Arriendos</h3>
                </div>
                <div class="col">
                  <button class="btn btn-sm btn-dark" onclick="nueva_bitacora_arriendos(<?= $idTraslados; ?>)"><i class="fas fa-plus text-white"></i> <span class="ocultar">Agregar</span></button>
                </div>
                <div class="row py-3" style="background-color: #f7f7f7" id="panel_bitacora"><?= $centroCostos->cargar_bitacora($idTraslados, 3); ?></div> 
              </div>
            </div>
            <div class="tab-pane fade" id="target-project" role="tabpanel" aria-labelledby="target-project-tab">
              <div class="row py-3" style="background-color: #f7f7f7" id="panel_editar"></div> 
            </div>
            <div class="tab-pane fade" id="budget-project" role="tabpanel" aria-labelledby="budget-project-tab">
              <div class="row">
                <div class="col-8">
                  <h3 class="text-dark mb-2"><i class="fas fa-paperclip"></i> Anexos Traslados</h3>
                </div>
                <div class="col">
                  <button class="btn btn-sm btn-dark" onclick="traer_nuevo_documento(<?= $idTraslados; ?>)"><i class="fas fa-plus text-white"></i> <span class="ocultar">Agregar</span></button>
                </div>
                <div class="row py-3" style="background-color: #f7f7f7" id="panel_documentos"><?= $centroCostos->traer_documentos_asociados($idTraslados, 3); ?></div>    
              </div>
            </div>
            <div class="tab-pane fade" id="team-project" role="tabpanel" aria-labelledby="team-project-tab">
              <div class="row">

                <div class="col-8">
                  <h3 class="text-dark mb-2"><i class="mdi mdi-format-list-bulleted"></i> Ingreso de Pagos</h3>
                </div>
                <!-- botones -->
                <div class="col">
                  <button class="btn btn-sm btn-danger" onclick="traer_nuevo_abono_traslado(<?= $idTraslados; ?>)" id="traer_nuevo_abono"><i class="fas fa-plus text-white"></i> <span class="ocultar">Abonar</span></button>
                </div>
                <div class="col">
                  <button class="btn btn-sm btn-dark" onclick="traer_procesar_pago_traslado(<?= $idTraslados; ?>)" id="traer_procesar_pago"><i class="fas fa-plus text-white"></i> <span class="ocultar">Procesar Pago</span></button>
                </div>
                <!-- !botones -->

                <div class="col-md-15 mb-2 mt-5" id="panel_de_pagos">
                  <?= $centroCostos->traer_panel_pagos_arriendos($idTraslados); ?>
                </div>

              </div>
            </div>
            <div class="tab-pane fade active" id="attachment" role="tabpanel" aria-labelledby="attachment-tab">
              <div class="row">
                <div class="col-8">
                  <h3 class="text-dark mb-2"><i class="mdi mdi-format-list-bulleted"></i> Descargar e Imprimir</h3>
                  <div class="col-lg-15">
                    <button class="btn btn-danger fas fa-file-pdf text-white h1" href="<?= controlador::$rutaAPP?>/app/vistas/viajes/php/traslados_ver.php?idTraslado=<?= $datos_fletes[0]['traslados_id'] ?>" data-fancybox="" data-type="iframe" data-preload="true" data-width="1200" data-height="800"></button>
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
    var multipleCancelButton = new Choices("#inputAcompanante", {
      removeItemButton: true,
    });
  });
  $(document).ready(function() { 
    var multipleCancelButton = new Choices("#inputDestino", {
      removeItemButton: true,
    });
  });

  traer_arriendos_editar(<?= $idTraslados ?>);
</script>