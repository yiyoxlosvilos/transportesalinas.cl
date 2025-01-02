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

  $idFlete     = $_REQUEST['idFlete'];

  $datos_fletes = $recursos->datos_fletes_id($idFlete);
?>
<script src="<?= controlador::$rutaAPP ?>app/vistas/viajes/asset/js/js.js?v=<?= rand() ?>"></script>
<link href="<?= controlador::$rutaAPP ?>app/vistas/viajes/asset/css/css.css?v=<?= rand() ?>" rel="stylesheet" type="text/css" />

<script src="<?= controlador::$rutaAPP ?>app/recursos/js/table.js?v=<?= rand() ?>"></script>
<link href="<?= controlador::$rutaAPP ?>app/recursos/css/table.css?v=<?= rand() ?>" rel="stylesheet" type="text/css" />

<script src="<?= controlador::$rutaAPP ?>app/vistas/viajes/asset/js/upload.js?v=<?= rand() ?>"></script>
<link href="<?= controlador::$rutaAPP ?>app/recursos/css/upload.css?v=<?= rand() ?>" rel="stylesheet" type="text/css" />

<link rel="stylesheet" href="<?= controlador::$rutaAPP ?>app/recursos/css/choices.css?v=<?= rand() ?>">
<script src="<?= controlador::$rutaAPP ?>app/recursos/js/choice.js?v=<?= rand() ?>"></script>

<input type="hidden" name="url_link" id="url_link" value="<?= controlador::$rutaAPP ?>">
<input type="hidden" name="idServicio" id="idServicio" value="ALL">

<input type="hidden" name="idFlete" id="idFlete" value="<?= $idFlete ?>">
<input type="hidden" name="idTipoServicio" id="idTipoServicio" value="1">

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
                            <h6>Bitácora</h6>
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
                  <h3 class="text-dark mb-2"><i class="mdi mdi-format-list-bulleted"></i> Detalles de Viaje</h3>
                </div> 
                <div class="col-12" style="background-color: #f7f7f7"><?= $centroCostos->mostrar_formulario_flete($idFlete); ?></div> 
              </div>
            </div>
            <div class="tab-pane fade" id="overview-bitacora" role="tabpanel" aria-labelledby="overview-bitacora-tab">
              <div class="row">
                <div class="col-8">
                  <h3 class="text-dark mb-2"><i class="fas fa-book"></i> Bitácora de Viaje</h3>
                </div>
                <div class="col">
                  <button class="btn btn-sm btn-dark" onclick="nueva_bitacora(<?= $idFlete; ?>)"><i class="fas fa-plus text-white"></i> <span class="ocultar">Agregar</span></button>
                </div>
                <div class="row py-3" style="background-color: #f7f7f7" id="panel_bitacora"><?= $centroCostos->cargar_bitacora($idFlete, 1); ?></div> 
              </div>
            </div>
            <div class="tab-pane fade" id="target-project" role="tabpanel" aria-labelledby="target-project-tab">
              <div class="row">
                <div class="col-8">
                  <h3 class="text-dark mb-2"><i class="mdi mdi-format-list-bulleted"></i> Editar Viaje</h3>
                </div>
                <div class="row py-3" style="background-color: #f7f7f7" id="panel_editar"><?= $centroCostos->formulario_editar_flete($idFlete); ?></div>   
              </div>
            </div>
            <div class="tab-pane fade" id="budget-project" role="tabpanel" aria-labelledby="budget-project-tab">
              <div class="row">
                <div class="col-8">
                  <h3 class="text-dark mb-2"><i class="fas fa-paperclip"></i> Anexos Viaje</h3>
                </div>
                <div class="col">
                  <button class="btn btn-sm btn-dark" onclick="traer_nuevo_documento(<?= $idFlete; ?>)"><i class="fas fa-plus text-white"></i> <span class="ocultar">Agregar</span></button>
                </div>
                <div class="row py-3" style="background-color: #f7f7f7" id="panel_documentos"><?= $centroCostos->traer_documentos_asociados($idFlete, 1); ?></div>    
              </div>
            </div>
            <div class="tab-pane fade" id="team-project" role="tabpanel" aria-labelledby="team-project-tab">
              <div class="row">
                <div class="col-8">
                  <h3 class="text-dark mb-2"><i class="mdi mdi-format-list-bulleted"></i> Ingreso de Pagos</h3>
                </div>
                <!-- botones -->
                <div class="col">
                  <button class="btn btn-sm btn-dark" onclick="traer_nuevo_abono(<?= $idFlete; ?>)"><i class="fas fa-plus text-white"></i> <span class="ocultar">Abonar</span></button>
                </div>
                <div class="col">
                  <button class="btn btn-sm btn-dark" onclick="traer_procesar_pago(<?= $idFlete; ?>)"><i class="fas fa-plus text-white"></i> <span class="ocultar">Procesar Pago</span></button>
                </div>
                <!-- !botones -->

                <div class="col-md-15 mb-2 mt-3">
                  <div class="row">
                    <div class="col-xl-3 col-sm-6">
                      <!-- card -->
                      <div class="card card-h-100 border shadow-sm">
                        <!-- card body -->
                        <div class="card-body">
                          <div class="row align-items-center">
                            <div class="col">
                              <span class="text-muted mb-3 lh-1 d-block text-truncate">Valor Viaje</span>
                              <h4 class="mb-3">
                                <span class="counter-value" data-target="<?= $datos_fletes[0]['fle_valor'] ?>"><?= Utilidades::monto_color($datos_fletes[0]['fle_valor']) ?></span>
                              </h4>
                            </div>
                          </div>
                        </div><!-- end card body -->
                      </div><!-- end card -->
                    </div>

                    <div class="col-xl-3 col-sm-6">
                      <!-- card -->
                      <div class="card card-h-100 border shadow-sm">
                        <!-- card body -->
                        <div class="card-body">
                          <div class="row align-items-center">
                            <div class="col">
                              <span class="text-muted mb-3 lh-1 d-block text-truncate">Valor Estadia</span>
                              <h4 class="mb-3">
                                <span class="counter-value" data-target="<?= $datos_fletes[0]['fle_estadia'] ?>"><?= Utilidades::monto_color($datos_fletes[0]['fle_estadia']) ?></span>
                              </h4>
                            </div>
                          </div>
                        </div><!-- end card body -->
                      </div><!-- end card -->
                    </div>

                    <div class="col-xl-3 col-sm-6">
                      <!-- card -->
                      <div class="card card-h-100 border shadow-sm">
                        <!-- card body -->
                        <div class="card-body">
                          <div class="row align-items-center">
                            <div class="col">
                              <span class="text-muted mb-3 lh-1 d-block text-truncate">Descuentos</span>
                              <h4 class="mb-3">
                                <span class="counter-value" data-target="<?= $datos_fletes[0]['fle_descuento'] ?>"><?= Utilidades::monto_color(-$datos_fletes[0]['fle_descuento']) ?></span>
                              </h4>
                            </div>
                          </div>
                        </div><!-- end card body -->
                      </div><!-- end card -->
                    </div>


                    <div class="col-xl-3 col-sm-6">
                      <!-- card -->
                      <div class="card card-h-100 border shadow-sm">
                        <!-- card body -->
                        <div class="card-body">
                          <div class="row align-items-center">
                            <div class="col">
                              <span class="text-muted mb-3 lh-1 d-block text-truncate">Total</span>
                              <h4 class="mb-3">
                                <span class="counter-value" data-target="<?= (($datos_fletes[0]['fle_valor']+$datos_fletes[0]['fle_estadia'])-$datos_fletes[0]['fle_descuento']) ?>"><?= Utilidades::monto_color((($datos_fletes[0]['fle_valor']+$datos_fletes[0]['fle_estadia'])-$datos_fletes[0]['fle_descuento'])) ?></span>
                              </h4>
                            </div>
                          </div>
                        </div><!-- end card body -->
                      </div><!-- end card -->
                    </div>

                  </div>
                </div>  
              </div>
            </div>
            <div class="tab-pane fade active" id="attachment" role="tabpanel" aria-labelledby="attachment-tab">
                        <div class="row">
                          <div class="col-8">
                            <h3 class="text-dark mb-2"><i class="mdi mdi-format-list-bulleted"></i> Descargar e Imprimir</h3>
                            <div class="col-lg-15">
                              <button class="btn btn-danger fas fa-file-pdf text-white h2" href="<?= controlador::$rutaAPP?>/app/vistas/viajes/php/viajes_ver.php?idCotizacion=<?= $datos_fletes[0]['fle_id'] ?>" data-fancybox="" data-type="iframe" data-preload="true" data-width="1200" data-height="800"> Descargar e Imprimir</button>

                              <button class="btn btn-success fas fa-file-excel text-white h2" href="<?= controlador::$rutaAPP?>/app/vistas/viajes/php/cotizacion_ver.php?idCotizacion=<?= $datos_fletes[0]['fle_id'] ?>" data-fancybox="" data-type="iframe" data-preload="true" data-width="1200" data-height="800"> Descargar Excel</button>
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
</script>