<?php 
	date_default_timezone_set("America/Santiago");
	require_once __dir__."/../../../controlador/controlador.php";
	require_once __dir__."/../../../controlador/rutaControlador.php";
	require_once __dir__."/../../../controlador/recursosControlador.php";
	require_once __dir__."/../../../controlador/utilidadesControlador.php";
	
	$mvc2       = new controlador();
	$recursos  	= new Recursos();
	$ruta  	    = new Ruta();

	$accion      = $_REQUEST['accion'];

	switch ($accion) {
		case 'ingresar_hoja_ruta':
			$inputRut 		= $_REQUEST['inputRut'];
			$inputCodigo 	= $_REQUEST['inputCodigo'];

			$validar_ingreso= $ruta->consultar_hoja_ruta_login($inputRut, $inputCodigo);

			if(count($validar_ingreso) > 0){
				session_start();

				$_SESSION["RUTCHOFER"]     = $inputRut;
				$_SESSION["CODSERVICIO"]   = $inputCodigo;
				$_SESSION["IDCHOFER"]      = $validar_ingreso[0]["fle_chofer"];
				$_SESSION["IDCODSERVICIO"] = $validar_ingreso[0]["fle_servicio"];

				$data = array();

				foreach ($validar_ingreso as $key => $value) {
					$data[$key] = $value;
				}

				echo '<script>location.reload();</script>';
			}else{
				echo '<script>
						Swal.fire({
					          title:              "** Error **",
					          text:               "Los datos ingresados no corresponden a un viaje.",
					          showDenyButton:     false,
					          showCancelButton:   false,
					          confirmButtonText:  "OK",
					          icon:               "error",
					    }).then((result) => {
					        if (result.isConfirmed) {
					        	location.reload();
					         }
					    })
						
					  </script>';
			}

			break;
		case 'grabar_hoja_ruta':
			$monto_inicial = $_REQUEST['monto_inicial'];
			$fecha_hoja    = $_REQUEST['fecha_hoja'];
			$descripcion   = $_REQUEST['descripcion'];
			$idServicio    = $_REQUEST['idServicio'];
			$idTrabajador  = $_REQUEST['idTrabajador'];
			$idFlete       = $_REQUEST['idFlete'];

			$grabar = $ruta->grabar_hoja_ruta($monto_inicial, $fecha_hoja, $descripcion, $idFlete, $idServicio, $idTrabajador);

			if($grabar){
				return TRUE;
			}else{
				return FALSE;
			}
			break;
		case 'grabar_nuevo_gasto_ruta':
			$idServicio 			= $_REQUEST['idServicio'];
			$idTrabajador 			= $_REQUEST['idTrabajador'];
			$idFlete 				= $_REQUEST['idFlete'];
			$inputNombre 			= $_REQUEST['inputNombre'];
			$inputPrecio 			= $_REQUEST['inputPrecio'];
			$tipo_gastos 			= $_REQUEST['tipo_gastos'];
			$tipo_gastos_categorias = $_REQUEST['tipo_gastos_categorias'];
			$inputSucursal 			= $_REQUEST['inputSucursal'];
			$inputDescripcion 		= $_REQUEST['inputDescripcion'];
			$inputFecha 			= $_REQUEST['inputFecha'];

			$grabar      			= $ruta->grabar_nuevo_gasto_ruta($tipo_gastos, $tipo_gastos_categorias, $inputNombre, $inputDescripcion, $inputFecha, $inputSucursal, $inputPrecio, $idServicio, $idTrabajador, $idFlete);

			return $grabar;
			break;
		case 'cerrar_session':
			if(!isset($_SESSION)){
				session_start();
			}

			$_SESSION["RUTCHOFER"]     = '';
			$_SESSION["CODSERVICIO"]   = '';
			$_SESSION["IDCHOFER"]      = '';
			$_SESSION["IDCODSERVICIO"] = '';

			if(session_destroy()){
				echo '<script>location.reload();</script>';
			}			
			break;
		default:
			break;
	}
?>