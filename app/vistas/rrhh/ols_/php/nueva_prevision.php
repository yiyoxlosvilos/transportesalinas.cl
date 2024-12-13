<?php
  require_once __dir__."/../../../controlador/controlador.php";
  require_once __dir__."/../../../controlador/productosControlador.php";
  require_once __dir__."/../../../controlador/utilidadesControlador.php";
  require_once __dir__."/../../../controlador/recursosControlador.php";
  require_once __dir__."/../../../recursos/head.php";

  $productos   = new Productos();
  $recursos    = new Recursos();
  $utilidades  = new Utilidades();
  $mvc         = new controlador();
?>
<script src="<?= controlador::$rutaAPP ?>app/vistas/rrhh/asset/js/js.js?v=<?= rand() ?>"></script>
<link href="<?= controlador::$rutaAPP ?>app/vistas/rrhh/asset/css/css.css?v=<?= rand() ?>" rel="stylesheet" type="text/css" />
<input type="hidden" name="url_link" id="url_link" value="<?= controlador::$rutaAPP ?>">
<div class="row mb-4" id="validar_prevision">
<?php 
  switch ($_REQUEST['accion']) {
    case 'prevision':
      echo '<div id="validar_pension">
            <table width="90%" align="center" cellpadding="5" cellspacing="5" class="table mt-5 sombraPlana">
              <tr class="verde">
                <th colspan="2" align="center">Ingresar Nueva previsi&oacute;n de salud</th>
              </tr>
              <tr class="blanco">
                <td width="50%" align="left">Nombre:</td>
                <td width="50%" align="left">Descuento:</td>
              </tr>
              <tr class="blanco">
                <td align="left">
                  <input type="text" class="form-control shadow" name="nombre" id="nombre" placeholder="Escribir nombre.">
                </td>
                <td align="left">
                  <input type="text" class="form-control shadow" name="descuentos" id="descuentos"  placeholder="ej: 0.77">
                </td>
              </tr>
              <tr class="blanco">
                <td align="center" colspan="2">
                  <table width="30%" align="center">
                    <tr>
                      <td align="center">
                       <button type="button" id="grabar" class="btn btn-primary form-control shadow" onclick="grabar_prevision()">Grabar <i class="bi bi-save"></i></button>
                      </td>
                    </tr>
                  </table>
                </td>
              </tr>
            </table>
            </div>';
      break;
    case 'pension':
      echo '<div id="validar_prevision">
            <table width="90%" align="center" cellpadding="5" cellspacing="5" class="table mt-5 sombraPlana">
              <tr class="verde">
                <th colspan="2" align="center">Ingresar Nueva previsi&oacute;n de salud</th>
              </tr>
              <tr class="blanco">
                <td width="50%" align="left">Nombre:</td>
                <td width="50%" align="left">Descuento:</td>
              </tr>
              <tr class="blanco">
                <td align="left">
                  <input type="text" class="form-control shadow" name="nombre" id="nombre" placeholder="Escribir nombre.">
                </td>
                <td align="left">
                  <input type="text" class="form-control shadow" name="descuentos" id="descuentos"  placeholder="ej: 0.77">
                </td>
              </tr>
              <tr class="blanco">
                <td align="center" colspan="2">
                  <table width="30%" align="center">
                    <tr>
                      <td align="center">
                       <button type="button" id="grabar" class="btn btn-primary form-control shadow" onclick="grabar_pensiones()">Grabar <i class="bi bi-save"></i></button>
                      </td>
                    </tr>
                  </table>
                </td>
              </tr>
            </table>
            </div>';
        break;     
      case 'isapre':
        echo '
            <div id="validar_isapre">
            <table width="90%" align="center" cellpadding="5" cellspacing="5" class="table mt-5 sombraPlana">
              <tr class="verde">
                <th colspan="2" align="center">Ingresar Nueva previsi&oacute;n 
                 salud</th>
              </tr>
              <tr class="blanco">
                <td align="left">Nombre:</td>
              </tr>
              <tr class="blanco">
                <td align="left">
                  <input type="text" class="form-control shadow" name="nombre" id="nombre" placeholder="Escribir nombre.">
                </td>

              </tr>
              <tr class="blanco">
                <td align="center" >
                  <table width="30%" align="center">
                    <tr>
                      <td align="center">

                       <button type="button" id="grabar" class="btn btn-primary form-control shadow" onclick="grabar_isapre()">Grabar <i class="bi bi-save"></i></button>
                      </td>
                    </tr>
                  </table>
                </td>
              </tr>
            </table>
            </div>';
      break;
      case 'caja':
         echo '
            <div id="validar_caja">
            <table width="90%" align="center" cellpadding="5" cellspacing="5" class="table mt-5 sombraPlana">
              <tr class="verde">
                <th colspan="2" align="center">Ingresar Nueva previsi&oacute;n de salud</th>
              </tr>
              <tr class="blanco">
                <td align="left">Nombre:</td>
              </tr>
              <tr class="blanco">
                <td align="left">
                  <input type="text" class="form-control shadow" name="nombre" id="nombre" placeholder="Escribir nombre.">
                </td>

              </tr>
              <tr class="blanco">
                <td align="center" >
                  <table width="30%" align="center">
                    <tr>
                      <td align="center">
                        
                       <button type="button" id="grabar" class="btn btn-primary form-control shadow" onclick="grabar_caja()">Grabar <i class="bi bi-save"></i></button>
                      </td>
                    </tr>
                  </table>
                </td>
              </tr>
            </table>';
    default:
      // code...
      break;
  }
?>
</div>