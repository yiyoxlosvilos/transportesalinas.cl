<?php 
	date_default_timezone_set("America/Santiago");
	require_once __dir__."/../../../controlador/controlador.php";
	require_once __dir__."/../../../controlador/reporteriaControlador.php";
	require_once __dir__."/../../../controlador/utilidadesControlador.php";
	
	$mvc2        = new controlador();
	$reproteria  = new Reporteria();
	$accion      = $_REQUEST['accion'];

	switch ($accion) {
		case 'buscar_flujo_diario':
			$mes	   = $_REQUEST['mes'];
			$ano	   = $_REQUEST['ano'];
			$cant_dias = date('t', mktime(0,0,0, $mes, 1, $ano));

			echo $reproteria->traer_flujo_diario($mes, $ano, $cant_dias);
			break;
		case 'flujo_mensual':
			$ano	   = Utilidades::fecha_ano();
			$cant_dias = 12; //12 = meses

			echo $reproteria->traer_flujo_mensual($mes, $ano, $cant_dias);
			break;
		case 'buscar_flujo_mensual':
			$ano	   = $_REQUEST['ano'];
			$cant_dias = 12; //12 = meses

			echo $reproteria->traer_flujo_mensual($mes, $ano, $cant_dias);
			break;
		case 'informe_ventas':
			$mes	   = Utilidades::fecha_mes();
			$ano	   = Utilidades::fecha_ano();

			echo $reproteria->informe_ventas($mes, $ano);
			break;
		case 'informe_ventas_imprimir':
			$mes	   = $_REQUEST['mes'];
			$ano	   = $_REQUEST['ano'];

			header("Content-Type: application/vnd.ms-excel");
		    header("Expires: 0");
		    header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
		    header("content-disposition: attachment;filename=detalle_ventas.xls");

			echo $reproteria->listado_productos_imprime($mes, $ano);
			break;
		case 'buscar_informe_ventas':
			$mes	   = $_REQUEST['mes'];
			$ano	   = $_REQUEST['ano'];

			echo $reproteria->informe_ventas($mes, $ano);
			break;
		case 'reporte_financiero':
			$mes	   = Utilidades::fecha_mes();
			$ano	   = Utilidades::fecha_ano();

			echo $reproteria->reporte_financiero($mes, $ano);
			break;
		case 'buscar_reporte_financiero':
			$mes	   = $_REQUEST['mes'];
			$ano	   = $_REQUEST['ano'];

			echo $reproteria->reporte_financiero($mes, $ano);
			break;
		case 'imprimir_reporte_financiero':
			$mes	   = $_REQUEST['mes'];
			$ano	   = $_REQUEST['ano'];

			echo '<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
				  <link href="'.controlador::$rutaAPP.'app/recursos/css/utilidades.css?v=<?= rand() ?>" rel="stylesheet" type="text/css" />
				  <link href="'.controlador::$rutaAPP.'app/recursos/css/bootstrap.min.css?v=<?= rand() ?>" id="bootstrap-style" rel="stylesheet" type="text/css" />';

			echo $reproteria->print_reporte_financiero($mes, $ano);
			echo "<script>window.print();</script>";
			break;
		case 'estado_pago':
			echo $reproteria->listado_estados_pagos_finalizados();

			echo '<script>
					$(document).ready(function() {
				    $("#productos_list").DataTable({     
					      "aLengthMenu": [[10, 20, 30, -1], [10, 20, 30, "Todos"]],
					        "iDisplayLength": 20
					       });
					});
				  </script>';
			break;
		default:
			// Nada
			break;
	}
?>
