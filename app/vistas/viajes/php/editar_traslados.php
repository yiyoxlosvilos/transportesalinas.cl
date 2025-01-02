<?php
  require_once __dir__."/../../../controlador/controlador.php";
  require_once __dir__."/../../../controlador/productosControlador.php";
  require_once __dir__."/../../../controlador/recursosControlador.php";
  require_once __dir__."/../../../controlador/utilidadesControlador.php";
  require_once __dir__."/../../../controlador/centroCostoControlador.php";
  require_once __dir__."/../../../recursos/head.php";
  
  $centroCostos= new CentroCostos();

  $productos   = new Productos();
  $recursos    = new Recursos();
  $utilidades  = new Utilidades();
  $mvc2        = new controlador();

  $dia         = Utilidades::fecha_dia();
  $mes         = Utilidades::fecha_mes();
  $ano         = Utilidades::fecha_ano();
  $hoy         = Utilidades::fecha_hoy();

  $idTraslado  = $_REQUEST['idTraslado'];

  $datos_traslado = $recursos->datos_traslados_id($idTraslado);

  //origen destino regreso
  $explorar_localidad = explode(",", $datos_traslado[0]['traslados']);
  $explorar_fecha     = explode(" ", $datos_traslado[0]['traslados_fecha_pago']);
?>
<script src="<?= controlador::$rutaAPP ?>app/vistas/centro_costo/asset/js/js.js?v=<?= rand() ?>"></script>
<link href="<?= controlador::$rutaAPP ?>app/vistas/centro_costo/asset/css/css.css?v=<?= rand() ?>" rel="stylesheet" type="text/css" />

<link rel="stylesheet" href="<?= controlador::$rutaAPP ?>app/recursos/css/choices.css?v=<?= rand() ?>">
<script src="<?= controlador::$rutaAPP ?>app/recursos/js/choice.js?v=<?= rand() ?>"></script>

<input type="hidden" name="url_link" id="url_link" value="<?= controlador::$rutaAPP ?>">
<div class="row mb-4">
  <p align="left" class="text-info font-weight-light h3"><i class="fas fa-bus text-info"></i>&nbsp;&nbsp; Editar traslado</p>
  <hr class="mt-2 mb-3"/>
    <div class="container mb-4 shadow p-4">
      <div class="row">
        <div class="col-lg-4 p-3 mb-2 bg-white  border">
          <h6>* Origen:</h6>
          <span class="text-dark">
          <?= $recursos->seleccionar_localidad($explorar_localidad[0], 'inputOrigen', 0) ?>
          </span>
        </div>
        <div class="col-lg-4 p-3 mb-2 bg-white  border">
          <h6>* Destino:</h6>
          <span class="text-dark">
          <?= $recursos->seleccionar_localidad($explorar_localidad[1], 'inputDestino', 0) ?>
          </span>
        </div>
        <div class="col-lg-4 p-3 mb-2 bg-white  border">
          <h6>Regreso:</h6>
          <span class="text-dark">
          <?= $recursos->seleccionar_localidad($explorar_localidad[2], 'inputRegreso', 0) ?>
          </span>
        </div>
        <div class="col-lg-6 mb-2 p-3 border">
          <label for="inputPrecio"><b>* Valor:</b></label>
            <input type="number" class="form-control shadow" id="inputValor" placeholder="Escribir Valor" value="<?= $datos_traslado[0]['traslados_valor'] ?>">
        </div>
        <div class="col-lg-6 mb-2 p-3 border">
          <label for="inputPrecio"><b>* Cantidad:</b></label>
            <input type="number" class="form-control shadow" id="inputCantidad" placeholder="Escribir Cantidad" onchange="agregar_fechas_edit()" value="<?= $datos_traslado[0]['traslados_cantidad'] ?>">
        </div>
        <div class="col-lg-15 mb-2 p-3 border">
          <label for="inputMarca"><b>* Fecha/as:</b></label>
          <div class="row" id="cantidad_fechas">
            <?php 

              $explorar_fechas = explode(";", $datos_traslado[0]['traslados_fechas']);
              $j = 1;
              for ($i=0; $i < count($explorar_fechas); $i++) { 

                if(strlen($explorar_fechas[$i]) > 0){
                  echo '<div class="col-6 p-2 border" id="row'.$j++.'"><input type="date" name="inputFecha[]" placeholder="Fecha" class="form-control name_list" value="'.$explorar_fechas[$i].'" /></div>';
                }
                
              }

              
            ?>
          </div>
        </div>
        <div class="col-xxl-6 col-xl-6 col-sm-12 pt-3 ">
          <b>Chofer:</b>
          <span class="text-dark">
            <?= $recursos->seleccionar_trabajadores($datos_traslado[0]['traslados_chofer']) ?>
            </span>
        </div>
        <div class="col-xxl-6 col-xl-6 col-sm-12 pt-3 ">
          <b>Acompañante/es:</b>
          <span class="text-dark">
            <?= $recursos->seleccionar_companante($datos_traslado[0]['traslados_acompanantes']) ?>
            </span>
        </div>
        <div class="col-xxl-6 col-xl-6 col-sm-12 pt-3 ">
          <b>Estado de Pago:</b>
          <?= $recursos->select_tipos_estados_pagos($datos_traslado[0]['traslados_estado_pago']) ?>
        </div>
        <div class="col-xxl-6 col-xl-6 col-sm-12 pt-3 ">
          <h6>Fecha de Traslado:</h6>
          <span class="text-dark">
            <input type="date" class="form-control shadow" id="inputFechaPago" value="<?= $explorar_fecha[0] ?>" autocomplete="off" onchange="calcular_fecha_pago()">
            <span class="text-danger" id="respuesta-pago"></span>
            </span>
        </div>
        <div class="col-xxl-12 col-xl-12 col-sm-12 mb-4 ">
          <b>Cliente:</b>
          <?= $recursos->select_clientes($datos_traslado[0]['traslados_cliente']) ?>
        </div>
        <div class="col-lg-15 p-3 border">
          <label for="inputSucursal"><b>Descripción</b></label>
            <span id="validador_curso"></span>
            <textarea class="form-control shadow" id="inputDescripcion" rows="5"><?= $datos_traslado[0]['traslados_descripcion'] ?></textarea>
        </div>
        <div class="col-lg-2 mb-2">
          <label for="inputTipo">&nbsp;</label>
          <button type="button" id="grabar" class="btn btn-primary form-control shadow" onclick="editar_traslado(<?= $idTraslado ?>)">Editar <i class="bi bi-save"></i></button>
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
  $(document).ready(function() { 
    var multipleCancelButton = new Choices("#inputRegreso", {
      removeItemButton: true,
    });
  });
  $(document).ready(function() { 
    var multipleCancelButton = new Choices("#inputTrabajador", {
      removeItemButton: true,
    });
  });

  $(document).ready(function() { 
    var multipleCancelButton = new Choices("#inputAcompanante", {
      removeItemButton: true,
    });
  });

</script>