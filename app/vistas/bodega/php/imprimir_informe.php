<?php 
    date_default_timezone_set("America/Santiago");
    require_once __dir__."/../../../controlador/controlador.php";
    require_once __dir__."/../../../controlador/bodegaProductosControlador.php";
    require_once __dir__."/../../../controlador/utilidadesControlador.php";
    require_once __dir__."/../../../controlador/recursosControlador.php";
    require_once __dir__."/../../../recursos/head.php";

      error_reporting(E_ALL);
    ini_set('display_errors', 1);

    $bodega          = new Bodega();
    $recursos        = new Recursos();
    $lote            = $_REQUEST['lote'];
    $tipo_movimiento = $_REQUEST['tipo_movimiento'];

    $datos_historial_bodega = $bodega->datos_historial_bodega($lote, $tipo_movimiento);
    $datos_usuario          = $recursos->datos_usuario($datos_historial_bodega[0]['his_usuario']);

    if($datos_historial_bodega[0]['his_tipo'] == 1){
        $titulo = "Salida";
    }elseif($datos_historial_bodega[0]['his_tipo'] == 2){
        $titulo = "Ingreso";
    }elseif($datos_historial_bodega[0]['his_tipo'] == 3){
        $titulo = "Merma";
    }
?>
<script src="<?= controlador::$rutaAPP ?>app/recursos/js/table.js?v=<?= rand() ?>"></script>
<link href="<?= controlador::$rutaAPP ?>app/recursos/css/table.css?v=<?= rand() ?>" rel="stylesheet" type="text/css" />
<script src="<?= controlador::$rutaAPP ?>app/vistas/bodega/asset/js/js.js?v=<?= rand() ?>"></script>
<link href="<?= controlador::$rutaAPP ?>app/vistas/bodega/asset/css/css.css?v=<?= rand() ?>" rel="stylesheet" type="text/css" />

<input type="hidden" name="url_link" id="url_link" value="<?= controlador::$rutaAPP ?>">
    <div class="row justify-content-center">
        <div class="col-md-15">
            <div class="d-flex flex-row p-2">
                <div class="col"><?= $recursos->imagen_empresa_pos() ?></div>                
            </div>
            <h2 align="center" class="text-primary  border-bottom">Informe de <?= $titulo ?> N&deg;: <?= $lote ?></h2>
            <div class="table-responsive p-2">
                <table width="100%" class="table border">
                    <tbody>
                        <tr class="add">
                            <td><b>Realizado Por:</b><br><?= ucfirst($datos_usuario[0]['us_cli_nombre']) ?></td>
                            <td><b>Fecha:</b><br><?= Utilidades::arreglo_fecha2($datos_historial_bodega[0]['his_fecha']) ?></td>
                            <td><b>Hora:</b><br><?= $datos_historial_bodega[0]['his_hora'] ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="products p-2">
                <table class="table table-borderless border">
                    <thead>
                        <tr class="bg-light">
                            <th>C&Oacute;DIGO</th>
                            <th>PRODUCTO</th>
                            <th>STOCK</th>
                            <th align="left">DESCRIPCI&Oacute;N</th>
                        </tr>
                    </thead>
                    <tbody>
<?php
                        $unitario = 0;
                        $granel   = 0;
                        for ($i=0; $i < count($datos_historial_bodega); $i++) {
                            $datos_productos = $bodega->datos_productos($datos_historial_bodega[$i]['his_producto_maquinaria']);

                            if($datos_productos[0]['prod_cli_tipo'] == 0){
                                $cantidad = Utilidades::miles($datos_historial_bodega[$i]['his_cantidad']);
                                $unitario += $datos_historial_bodega[$i]['his_cantidad'];
                            }else{
                                $cantidad = Utilidades::peso($datos_historial_bodega[$i]['his_cantidad']/1000);
                                $granel   += $datos_historial_bodega[$i]['his_cantidad'];
                            }

                            echo '<tr class="content">
                                        <td>'.$datos_productos[0]['prod_cli_codigo'].'</td>
                                        <td>'.$datos_productos[0]['prod_cli_producto'].'</td>
                                        <td>'.$cantidad.'</td>
                                        <td class="text-left">'.$datos_historial_bodega[$i]['his_comentario'].'</td>
                                    </tr>';
                        }
?>
                    </tbody>
                </table>
            </div>
                <hr>
                <div class="products p-2">
                    <table class="table border">
                        <tbody>
                            <tr >
                                <td align="center"><h4>Total Unitarios<br><?= Utilidades::miles($unitario) ?></h4></td>
                                <td align="center"><h4>Total Granel<br><?= Utilidades::peso($granel/1000) ?></h4></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <hr>
        </div>
    </div>

<script>window.print();</script>