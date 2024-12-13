<?php 
	date_default_timezone_set("America/Santiago");
	require_once __dir__."/../../../controlador/controlador.php";
	require_once __dir__."/../../../controlador/bodegaProductosControlador.php";
	
	$mvc2        = new controlador();
	$bodega      = new Bodega();
	$accion      = $_REQUEST['accion'];

	switch ($accion) {
		case 'asignar_productos_merma':
			$productos = $_REQUEST['productos'];

			echo $bodega->asignar_productos_mermas($productos);
			break;
		case 'realizar_merma':
			$mvc2->iniciar_sesion();

			$idUser      = $_SESSION['IDUSER'];
			$productos   = $_REQUEST['productos'];
			$inputMotivo = $_REQUEST['inputMotivo'];
			$inputGlosa  = $_REQUEST['inputGlosa'];

			$grabar      = $bodega->realizar_merma($productos, $inputMotivo, $inputGlosa, $idUser);

			if ($grabar > 0) {
				return true;
			}else{
				return false;
			}

			break;
		case 'buscar_informes_bodega':
			$tipo_accion = $_REQUEST['tipo_accion'];
			$desde   	 = $_REQUEST['desde'];
			$hasta 		 = $_REQUEST['hasta'];

			if($tipo_accion == 1){ 		// INGRESOS
				$mostrar    = $bodega->productos_informe_entradas_bodega($desde, $hasta);
			}elseif($tipo_accion == 2){ // SALIDAS
				$mostrar    = $bodega->productos_informe_salidas_bodega($desde, $hasta);
			}elseif($tipo_accion == 3){ // MERMAS
				$mostrar    = $bodega->productos_informe_mermas_bodega($desde, $hasta);
			}

			echo $mostrar;

			break;
		case 'buscar_movimientos_caja':
			$desde   	 = $_REQUEST['desde'];
			$hasta 		 = $_REQUEST['hasta'];

			echo $bodega->listar_movimiento_bodega($desde, $hasta, 1, 11, 0);

			break;
		default:
			// Nada
			break;
	}
?>
