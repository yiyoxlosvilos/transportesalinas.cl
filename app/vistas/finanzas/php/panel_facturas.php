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

  $idFactura   = $_REQUEST['idFactura'];
  $tipo        = isset($_REQUEST['tipo']) ? $_REQUEST['tipo'] : "";

  
?>
<script src="<?= controlador::$rutaAPP ?>app/recursos/js/table.js?v=<?= rand() ?>"></script>
<link href="<?= controlador::$rutaAPP ?>app/recursos/css/table.css?v=<?= rand() ?>" rel="stylesheet" type="text/css" />
<script src="<?= controlador::$rutaAPP ?>app/vistas/finanzas/asset/js/js.js?v=<?= rand() ?>"></script>
<link href="<?= controlador::$rutaAPP ?>app/vistas/finanzas/asset/css/css.css?v=<?= rand() ?>" rel="stylesheet" type="text/css" />

<input type="hidden" name="url_link" id="url_link" value="<?= controlador::$rutaAPP ?>">
<div class="row">
  <div class="col-lg-6 mb-2 shadow">
    <div class="container mb-4">
      <div class="row">
        <div class="col-15">
          <p align="center" class="text-secondary font-weight-light h4">Datos Factura</p> 
        </div>
        <div class="col-15" id="traer_editar_factura">
          <?php 
            if($tipo == 2){
              echo $finanzas->info_facturas_clientes($idFactura);
            }else{ 
              echo $finanzas->info_facturas_proveedores($idFactura);
            }
          ?>
        </div>
      </div>
    </div>
  </div>
  <div class="col-lg-6 mb-2 shadow">
    <div class="container mb-4">
      <div class="row">
        <div class="col-15">
          <p align="center" class="text-secondary font-weight-light h4">Estado Factura</p>
        </div>
        <div class="col-15" id="desactivar_factura">
          <?php 
            if($tipo == 2){
              echo $finanzas->estado_factura_clientes($idFactura);
            }else{ 
              echo $finanzas->estado_factura_proveedores($idFactura);
            }
          ?>
        </div>
<?php 
        if($tipo == 2){
          $fac  = $recursos->datos_facturas_clientes($idFactura);

          // echo '<div id="pdf-viewer">
          //         <embed src="'.controlador::$rutaAPP.'app/repositorio/documento_edp/'.$fac[0]['fac_documento'].'" type="application/pdf" width="100%" height="600px" />
          //       </div>';
        }
?>
        
      </div>
    </div>
  </div>
</div>
<script>
  $(document).ready(function() {
    $("#categorias_list").DataTable({     
        "aLengthMenu": [[5, 10, 20], [5, 10, 20]],
        "iDisplayLength": 10
    });
    $("#marcas_list").DataTable({     
        "aLengthMenu": [[5, 10, 20], [5, 10, 20]],
        "iDisplayLength": 10
    });
  });
</script>