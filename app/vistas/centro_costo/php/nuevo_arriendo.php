<?php
  require_once __dir__."/../../../controlador/controlador.php";
  require_once __dir__."/../../../controlador/productosControlador.php";
  require_once __dir__."/../../../controlador/recursosControlador.php";
  require_once __dir__."/../../../controlador/utilidadesControlador.php";
  require_once __dir__."/../../../recursos/head.php";

  $productos   = new Productos();
  $recursos    = new Recursos();
  $utilidades  = new Utilidades();
  $mvc2        = new controlador();

  $dia         = Utilidades::fecha_dia();
  $mes         = Utilidades::fecha_mes();
  $ano         = Utilidades::fecha_ano();
  $hoy         = Utilidades::fecha_hoy();

  $idServicio  = $_REQUEST['idServicio'];
?>
<script src="<?= controlador::$rutaAPP ?>app/vistas/centro_costo/asset/js/js.js?v=<?= rand() ?>"></script>
<link href="<?= controlador::$rutaAPP ?>app/vistas/centro_costo/asset/css/css.css?v=<?= rand() ?>" rel="stylesheet" type="text/css" />

<link rel="stylesheet" href="<?= controlador::$rutaAPP ?>app/recursos/css/choices.css?v=<?= rand() ?>">
<script src="<?= controlador::$rutaAPP ?>app/recursos/js/choice.js?v=<?= rand() ?>"></script>

<input type="hidden" name="url_link" id="url_link" value="<?= controlador::$rutaAPP ?>">
<div class="row mb-4">
  <p align="left" class="text-primary font-weight-light h3"><i class="fas fa-truck text-primary"></i>&nbsp;&nbsp; Ingresar nuevo arriendo</p>
  <hr class="mt-2 mb-3"/>
    <div class="mb-4 shadow p-4">
      <div class="row">
        <div class="col-lg-6 p-3 mb-2 bg-white  border">
          <label for="inputPrecio"><b>* Tipo de servicio:</b></label>
          <input type="text" class="form-control shadow" id="inputTipoServicio" placeholder="Escribir Tipo de servicio">
        </div>
        <div class="col-lg-6 p-3 mb-2 bg-white  border">
          <label for="inputPrecio"><b>* Proyecto:</b></label>
          <input type="text" class="form-control shadow" id="inputProyecto" placeholder="Escribir nombre Proyecto">
        </div>
        <div class="col-lg-6 p-3 mb-2 bg-white  border">
          <label for="inputPrecio"><b>* Contacto:</b></label>
          <input type="text" class="form-control shadow" id="inputContacto" placeholder="Escribir Contacto">
        </div>
        <div class="col-lg-6 p-3 mb-2 bg-white  border">
          <label for="inputPrecio"><b>* Mes servicio:</b></label>
          <?= Utilidades::select_agrupacion_cards_mes('', 'mes', $mes) ?>
        </div>
        <div class="col-lg-15 p-3 border">
          <label for="inputSucursal"><b>Descripción</b></label>
            <span id="validador_curso"></span>
            <textarea class="form-control shadow" id="inputDescripcion" rows="5"></textarea>
        </div>

        <div class="col-lg-15 p-3 border">
          <label for="inputSucursal"><b>Items cotizaci&oacute;n: <span class="fas fa-plus-circle text-success cursor" id="add" onclick="agregar_arriendo()"></span></b></label>
          <table class="table table-bordered" id="listar_productos">
            <tr>
              <th>IDENTIFICACIÓN&nbsp;CAMIÓN</th>
              <th>HRS CONTRATADAS</th>
              <th>VALOR HR</th>
              <th>HRS REALIZADAS</th>
              <th>VALOR&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
              <th>&nbsp;</th>
            </tr>
              <tr>
                <td>
                  <input type="text" name="camion[]" placeholder="Identificación" class="form-control titulo_list" />
                </td>
                <td>
                   <input type="number" name="hors_contratadas[]" placeholder="Horas Contratadas" class="form-control titulo_list" />
                </td>
                <td>
                  <input type="number" name="valor_hora[]" id="valor_hora0" placeholder="Valor horas" class="form-control titulo_list" onchange="calcular_valor_item_arriendo(0)" />
                </td>
                <td>
                  <input type="number" name="hrs_realizadas[]" id="hrs_realizadas0" placeholder="Horas realizadas" class="form-control titulo_list" onchange="calcular_valor_item_arriendo(0)" />
                </td>
                <td>
                  <span id="total_item0" class="text-dark"></span>
                </td>
                <td width="5%">&nbsp;</td>
              </tr>
            </table>
        </div>
            
        <div class="col-lg-2 mb-2">
          <label for="inputTipo">&nbsp;</label>
          <button type="button" id="grabar" class="btn btn-primary form-control shadow" onclick="grabar_nuevo_arriendo(<?= $idServicio ?>)">Grabar <i class="bi bi-save"></i></button>
        </div>
      </div>
    </div>
</div>