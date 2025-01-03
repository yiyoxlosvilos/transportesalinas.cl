<?php
  require_once __dir__."/../../controlador/utilidadesControlador.php";
  require_once __dir__."/../../controlador/recursosControlador.php";
  require_once __dir__."/../../controlador/viajesControlador.php";
  require_once __dir__."/../../controlador/finanzasControlador.php";
  require_once __dir__."/../../recursos/head.php";

  $centroCostos= new Viajes();
  $recursos    = new Recursos();
  $mvc2        = new controlador();
  $mvc2->iniciar_sesion();

  $finanzas    = new Finanzas();

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
                  <a class="nav-link active" id="overview-project-tab" data-bs-toggle="pill" href="#overview-project" role="tab" aria-controls="overview-project" aria-selected="false" tabindex="-1">
                  <div class="absolute-border"></div>
                  <div class="nav-rounded">
                    <div class="product-icons">
                      <i class="fas fa-shipping-fast h6"></i>
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
                        <i class="fas fa-bus h6"></i>
                      </div>
                    </div>
                    <div class="product-tab-content">
                      <h6>Traslados</h6>
                    </div></a></li>
                <li class="nav-item" role="presentation"> <a class="nav-link" id="budget-project-tab" data-bs-toggle="pill" href="#budget-project" role="tab" aria-controls="budget-project" aria-selected="false" tabindex="-1">
                  <div class="absolute-border"></div>
                  <div class="nav-rounded">
                    <div class="product-icons">
                      <i class="fas fa-truck h6"></i>
                    </div>
                  </div>
                  <div class="product-tab-content">
                    <h6>Arriendos</h6>
                  </div></a></li>
                <li class="nav-item" role="presentation"><a class="nav-link" id="team-project-tab" data-bs-toggle="pill" href="#team-project" role="tab" aria-controls="team-project" aria-selected="false" tabindex="-1">
                  <div class="absolute-border"></div>
                  <div class="nav-rounded">
                    <div class="product-icons">
                     <i class="fas fa-dollar-sign h6"></i>
                    </div>
                  </div>
                  <div class="product-tab-content">
                    <h6>Gastos</h6>
                  </div></a></li>
                <li class="nav-item" role="presentation"><a class="nav-link " id="attachment-tab" data-bs-toggle="pill" href="#attachment" role="tab" aria-controls="attachment" aria-selected="true">
                  <div class="absolute-border"></div>
                  <div class="nav-rounded">
                    <div class="product-icons">
                      <i class="fas fa-receipt h6"></i>
                    </div>
                  </div>
                  <div class="product-tab-content">
                    <h6>Facturas</h6>
                  </div></a></li>
                <li class="nav-item" role="presentation"><a class="nav-link" id="activity-project-tab" data-bs-toggle="pill" href="#activity-project" role="tab" aria-controls="activity-project" aria-selected="false" tabindex="-1">
                  <div class="absolute-border"></div>
                  <div class="nav-rounded">
                    <div class="product-icons">
                      <i class="fas fa-user-tie h6"></i>
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
                    <div class="col-6">
                      <h3 class="text-dark mb-2"><span class="mdi mdi-format-list-bulleted"></span> Detalles Viajes</h3>
                    </div>
                    <div class="col-3 mb-1">
                      <table width="100%">
                        <tr>
                          <td><?= Utilidades::select_agrupacion_cards('', 'mes_viajes', $ano, $mes) ?></td>
                          <td><?= Utilidades::select_agrupacion_anos('', 'ano_viajes', $ano) ?></td>
                          <td>
                            <button class="btn btn-primary" onclick="buscar_viajes()">
                              <i class="bi bi-search"></i>
                            </button>
                          </td>
                        </tr>
                      </table>
                    </div>
                    <div class="col-3">
                      <button class="btn btn-sm btn-dark" onclick="traer_menu('asignar_producto')"><i class="fas fa-shipping-fast text-white"></i> <span class="ocultar">Nuevo Viaje</span></button>
                    </div>
                    <div class="col-15 border-top" id="traer_productos_categoria">
                      <h3 class="mt-5 mb-4 text-success">Vigentes</h3>
                      <?= $centroCostos->traer_fletes_asigandos($mes, $ano, '') ?>
                      <h3 class="mt-5 mb-4 text-danger">Pagados</h3>
                      <?= $centroCostos->traer_fletes_asigandos($mes, $ano, 2) ?>
                    </div>
                  </div>
                </div>
                <div class="tab-pane fade" id="target-project" role="tabpanel" aria-labelledby="target-project-tab">
                  <div class="row">
                    <div class="col-6">
                      <h3 class="text-dark mb-2"><span class="mdi mdi-format-list-bulleted"></span> Detalles Traslados</h3>
                    </div>
                    <div class="col-3 mb-1">
                      <table width="100%">
                        <tr>
                          <td><?= Utilidades::select_agrupacion_cards('', 'mes_traslados', $ano, $mes) ?></td>
                          <td><?= Utilidades::select_agrupacion_anos('', 'ano_traslados', $ano) ?></td>
                          <td>
                            <button class="btn btn-primary" onclick="buscar_traslados()">
                              <i class="bi bi-search"></i>
                            </button>
                          </td>
                        </tr>
                      </table>
                    </div>
                    <div class="col-3">
                      <button class="btn btn-sm btn-dark" onclick="asignar_traslados()"><i class="fas fa-shipping-fast text-white"></i> <span class="ocultar">Nuevo Traslado</span></button>
                    </div>
                    <div class="col-15 mt-3" id="traer_traslados">
                      <h3 class="mt-5 mb-4 text-success">Vigentes</h3>
                      <?= $centroCostos->listado_de_traslados($mes, $ano, '', '') ?>
                      <h3 class="mt-5 mb-4 text-danger">Pagados</h3>
                      <?= $centroCostos->listado_de_traslados($mes, $ano, '', 2) ?>
                    </div>
                  </div>
                </div>
                <div class="tab-pane fade" id="budget-project" role="tabpanel" aria-labelledby="budget-project-tab">
                  <div class="row">
                    <div class="col-6">
                      <h3 class="text-dark mb-2"><span class="mdi mdi-format-list-bulleted"></span> Detalles Arriendo</h3>
                    </div>
                    <div class="col-3 mb-1">
                      <table width="100%">
                        <tr>
                          <td><?= Utilidades::select_agrupacion_cards('', 'mes_arriendo', $ano, $mes) ?></td>
                          <td><?= Utilidades::select_agrupacion_anos('', 'ano_arriendo', $ano) ?></td>
                          <td>
                            <button class="btn btn-primary" onclick="buscar_arriendo()">
                              <i class="bi bi-search"></i>
                            </button>
                          </td>
                        </tr>
                      </table>
                    </div>
                    <div class="col-3">
                      <button class="btn btn-sm btn-dark" onclick="asignar_arriendo()"><i class="fas fa-shipping-fast text-white"></i> <span class="ocultar">Nuevo Arriendo</span></button>
                    </div>
                    <div class="col-15 mt-3" id="traer_arriendos">
                      <h3 class="mt-5 mb-4 text-success">Vigentes</h3>
                      <?= $centroCostos->listado_de_arriendo($mes, $ano, '', '') ?>
                      <h3 class="mt-5 mb-4 text-danger">Pagados</h3>
                      <?= $centroCostos->listado_de_arriendo($mes, $ano, '', 2) ?>
                    </div>
                  </div>
                </div>
                <div class="tab-pane fade" id="team-project" role="tabpanel" aria-labelledby="team-project-tab">
                  <div class="row">
                    <div class="col-8">
                        <h3 class="text-dark mb-2"><span class="mdi mdi-format-list-bulleted"></span> Detalles Gastos</h3>
                      </div>
                    <div class="col">
                      <button class="btn btn-sm btn-dark" onclick="gastos_empresa()"><i class="fas fa-dollar-sign text-white"></i> <span class="ocultar">Agregar Gasto</span></button>
                      <button class="btn btn-success" type="button" href="<?= controlador::$rutaAPP ?>app/vistas/finanzas/php/panel_finanzas.php" data-fancybox="" data-type="iframe" data-preload="true" data-width="100%" data-height="1200">
                      <i class="bi bi-gear-wide-connected"></i>
                    </button>
                    </div>
                    <div class="col-15 mt-3" id="traer_gastos">
                      <?= $finanzas->listado_gastos($mes, $ano, '') ?>
                    </div>
                  </div>
                </div>
                <div class="tab-pane fade" id="attachment" role="tabpanel" aria-labelledby="attachment-tab">
                  <div class="row">
                    <div class="col-6">
                      <h3 class="text-dark mb-2"><span class="mdi mdi-format-list-bulleted"></span> Detalles Facturas</h3>
                    </div>
                    <div class="col-3">
                      <table width="100%">
                        <tr>
                          <td><?= Utilidades::select_agrupacion_cards('', 'mes_facturas', $ano, $mes) ?></td>
                          <td><?= Utilidades::select_agrupacion_anos('', 'ano_facturas', $ano) ?></td>
                          <td>
                            <button class="btn btn-primary" onclick="buscar_facturas_proveedores()">
                              <i class="bi bi-search"></i>
                            </button>
                          </td>
                        </tr>
                      </table>
                    </div>
                    <div class="col-3">
                      <button class="btn btn-sm btn-dark" onclick="nueva_factura()"><i class="fas fa-receipt text-white"></i> <span class="ocultar">Agregar Factura</span></button>
                      <button class="btn btn-success" type="button" href="<?= controlador::$rutaAPP ?>app/vistas/finanzas/php/panel_usuario_facturas.php" data-fancybox="" data-type="iframe" data-preload="true" data-width="100%" data-height="1200">
                        <i class="bi bi-gear-wide-connected"></i>
                      </button>
                    </div>
                    <div class="col-15 mt-3" id="traer_facturas">
                      <?= $finanzas->facturas_proveedores($mes, $ano, '') ?>
                    </div>
                  </div>
                </div>
                <div class="tab-pane fade" id="activity-project" role="tabpanel" aria-labelledby="activity-project-tab">
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
  </div>
</body>
</html>
<script>
  $(document).ready(function() {
    $("#listado_traslados").DataTable({     
      "aLengthMenu": [[5, 10, 20, 30, -1], [5, 10, 20, 30, "Todos"]],
      "iDisplayLength": 5
   });
  });

   $(document).ready(function() {
    $("#listado_traslados_listas").DataTable({     
      "aLengthMenu": [[5, 10, 20, 30, -1], [5, 10, 20, 30, "Todos"]],
      "iDisplayLength": 5
   });
  });

  $(document).ready(function() {
    $("#listado_arriendos").DataTable({     
      "aLengthMenu": [[5, 10, 20, 30, -1], [5, 10, 20, 30, "Todos"]],
      "iDisplayLength": 5
   });
  });

  $(document).ready(function() {
    $("#maquinarias").DataTable({     
      "aLengthMenu": [[5, 10, 20, 30, -1], [5, 10, 20, 30, "Todos"]],
      "iDisplayLength": 5
   });
  });

  $(document).ready(function() {
    $("#maquinarias_listas").DataTable({     
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

  $(document).ready(function() {
    $("#clientes_list").DataTable({     
        "aLengthMenu": [[5, 10, 20], [5, 10, 20]],
        "iDisplayLength": 10
    });
  });
</script>