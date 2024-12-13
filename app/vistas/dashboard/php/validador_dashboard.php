<?php
	date_default_timezone_set("America/Santiago");
	require_once __dir__."/../../../controlador/controlador.php";
	require_once __dir__."/../../../controlador/dashboardControlador.php";
 
	$dash         = new DashBoard();
	$accion       = $_REQUEST['accion'];

	switch ($accion) {
		case 'mostrar_metas':
			$fecha_meta = $_REQUEST['fecha_meta'];
			$ano 	    = $_REQUEST['ano'];

			echo $dash->contenido_metas($fecha_meta, $ano);
		break;

		case 'mostrar_graficos':
			$idGrafico = $_REQUEST['idGrafico'];

			$html .= '<script>
						var radialchartColors = getChartColorsArray("#invested-overview");
						var options = {
						    chart: {
						        height: 270,
						        type: "radialBar",
						        offsetY: -10
						    },
						    plotOptions: {
						        radialBar: {
						            startAngle: -130,
						            endAngle: 130,
						            dataLabels: {
						                name: {
						                    show: false
						                },
						                value: {
						                    offsetY: 10,
						                    fontSize: "18px",
						                    color: undefined,
						                    formatter: function (val) {
						                        return val + "%";
						                    }
						                }
						            }
						        }
						    },
						    colors: [radialchartColors[0]],
						    fill: {
						        type: "gradient",
						        gradient: {
						            shade: "dark",
						            type: "horizontal",
						            gradientToColors: [radialchartColors[1]],
						            shadeIntensity: 0.15,
						            inverseColors: false,
						            opacityFrom: 1,
						            opacityTo: 1,
						            stops: [0, 100]
						        },
						    },
						    stroke: {
						        dashArray: 4,
						    },
						    legend: {
						        show: false
						    },
						    series: ['.rand(0,100).'],
						    labels: ["Series A"],
						}

						var chart = new ApexCharts(
						    document.querySelector("#invested-overview"),
						    options
						);

						chart.render();</script>';

			return $html;
		break;

		case 'mostrar_facturas_ventas':
			$fecha_meta = $_REQUEST['fecha_meta'];
			$ano 	    = $_REQUEST['ano'];

			echo $dash->panel_card_facturas_ventas($ano, $fecha_meta);
			echo '<script>initCounterNumber();</script>';
		break;

		case 'mostrar_facturas_compras':
			$fecha_meta = $_REQUEST['fecha_meta'];
			$ano 	    = $_REQUEST['ano'];

			echo $dash->panel_card_facturas_compra($ano, $fecha_meta);
			echo '<script>initCounterNumber();</script>';
		break;

		case 'mostrar_pagos_pendientes':
			$fecha_meta = $_REQUEST['fecha_meta'];
			$ano 	    = $_REQUEST['ano'];

			echo $dash->panel_pagos_pendientes($ano, $fecha_meta);
			echo '<script>initCounterNumber();</script>';
			echo '<script>initCounterPorcent();</script>';
		break;

		case 'mostrar_gastos':
			$fecha_meta = $_REQUEST['fecha_meta'];
			$ano 	    = $_REQUEST['ano'];

			echo $dash->panel_gastos_realizados($ano, $fecha_meta);
			echo '<script>initCounterNumber();</script>';
			echo '<script>initCounterPorcent();</script>';
		break;

		default:
			echo '<script>parent.location.reload()</script>';
			break;
	}
?>