<?php 
	date_default_timezone_set("America/Santiago");
	require_once 		__dir__."/../../../controlador/controlador.php";
	require_once 		__dir__."/../../../controlador/productosControlador.php";
	require_once 		__dir__."/../../../controlador/finanzasControlador.php";
	require_once 		__dir__."/../../../controlador/utilidadesControlador.php";
	require_once 		__dir__."/../../../controlador/recursosControlador.php";
	
	$mvc2        		= new controlador();
	$finanzas  	 		= new Finanzas();
	$productos 	 		= new Productos();
	$recursos  	 		= new Recursos();
	$accion      		= $_REQUEST['accion'];

// 	error_reporting(E_ALL);
// ini_set('display_errors', 1);

	switch ($accion) {
		case 'gastos_empresa':
			$mes	   = Utilidades::fecha_mes();
			$ano	   = Utilidades::fecha_ano();
			$idServicio= $_REQUEST['idServicio'];

			echo $finanzas->gastos_empresa($mes, $ano, $idServicio);
			break;
		case 'buscar_gastos_empresa':
			$mes	   = $_REQUEST['mes'];
			$ano	   = $_REQUEST['ano'];

			echo $finanzas->gastos_empresa($mes, $ano);
			break;
		case 'buscar_pagos_pendientes':
			$mes	   = $_REQUEST['mes'];
			$ano	   = $_REQUEST['ano'];
			$cant_dias = date('t', mktime(0,0,0, $mes, 1, $ano));

			echo $finanzas->traer_pagos_pendientes($mes, $ano, $cant_dias);
			break;
		case 'mostrar_pagos_pendientes':
			$fecha	   = $_REQUEST['fecha'];
			$tipoPago  = $_REQUEST['tipoPago'];

			echo '<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
				  <link href="'.controlador::$rutaAPP.'app/recursos/css/utilidades.css" rel="stylesheet" type="text/css" />
				  <link href="'.controlador::$rutaAPP.'app/recursos/css/bootstrap.min.css" id="bootstrap-style" rel="stylesheet" type="text/css" />
				  <script src="'.controlador::$rutaAPP.'app/recursos/libs/jquery/jquery.min.js"></script>
				  <script src="'.controlador::$rutaAPP.'app/vistas/finanzas/asset/js/js.js?v='.rand().'"></script>
				  <input type="hidden" name="url_link" id="url_link" value="'.controlador::$rutaAPP.'">';

			echo $finanzas->traer_pagos_pendientes_fecha($fecha, $tipoPago);
			break;
		case 'detalles_pagos_pendientes':
			$boleta	   = $_REQUEST['boleta'];

			echo $finanzas->listado_productos_comprados($boleta);
			break;
		case 'nueva_categoria':
			$html = '<div class="row mb-4">
					  <p align="left" class="text-success font-weight-light h3">Nueva Categoria</p>
					  <hr class="mt-2 mb-3"/>
					    <div class="container mb-4">
					      <div class="row">
					        <div class="col-10 mb-2">
					          <label for="inputNombre"><b>Nombre</b></label>
					          <input type="text" class="form-control shadow" id="inputNombre" placeholder="Nombre" autocomplete="off">
					        </div>
					        <div class="col-10 mb-2">
					          <button type="button" id="grabar" class="btn btn-primary form-control shadow" onclick="crear_categoria()">Grabar <i class="bi bi-save"></i></button>
					        </div>
					      </div>
					    </div>
					</div>';

			echo $html;
			break;
		case 'crear_categoria':
			$mvc2->iniciar_sesion();
			$idUser      = $_SESSION['IDUSER'];
			$inputNombre = $_REQUEST['inputNombre'];

			$grabar      = $finanzas->grabar_categorias($inputNombre, $idUser);

			return $grabar;
			break;
		case 'editar_categoria':
			$idCategoria = $_REQUEST['idCategoria'];

			echo $finanzas->editar_categoria($idCategoria);
			break;
		case 'desactivar_categoria':
			$idCategoria = $_REQUEST['idCategoria'];

			echo $finanzas->desactivar_categoria($idCategoria);
			break;
		case 'grabar_editar_categoria':
			$inputNombre = $_REQUEST['inputNombre'];
			$idCategoria = $_REQUEST['idCategoria'];

			return $finanzas->grabar_editar_categoria($inputNombre, $idCategoria);
			break;
		case 'nuevo_tipo_categoria':
			$html = '<div class="row mb-4">
					  <p align="left" class="text-success font-weight-light h3">Nueva Categoria</p>
					  <hr class="mt-2 mb-3"/>
					    <div class="container mb-4">
					      <div class="row">
					        <div class="col-10 mb-2">
					          <label for="inputNombre"><b>Nombre</b></label>
					          <input type="text" class="form-control shadow" id="inputNombre" placeholder="Nombre" autocomplete="off">
					        </div>
					        <div class="col-10 mb-2">
					          <label for="inputNombre"><b>Categor&iacute;a</b></label>
					          '.$recursos->select_tipo_gastos("", 0).'
					        </div>
					        <div class="col-10 mb-2">
					          <button type="button" id="grabar" class="btn btn-primary form-control shadow" onclick="crear_tipo_categoria()">Grabar <i class="bi bi-save"></i></button>
					        </div>
					      </div>
					    </div>
					</div>';

			echo $html;
			break;
		case 'crear_tipo_categoria':
			$inputNombre = $_REQUEST['inputNombre'];
			$tipo_gastos = $_REQUEST['tipo_gastos'];

			return $finanzas->grabar_tipo_categoria($inputNombre, $tipo_gastos);
			break;
		case 'editar_categoria_tipo':
			$tipo_gastos = $_REQUEST['tipo_gastos'];

			echo $recursos->editar_categoria_tipo($tipo_gastos);
			break;
		case 'grabar_editar_categoria_tipo':
			$inputNombre = $_REQUEST['inputNombre'];
			$tipo_gastos = $_REQUEST['tipo_gastos'];
			$idTipo 	 = $_REQUEST['idTipo'];

			return $finanzas->grabar_editar_categoria_tipo($inputNombre, $tipo_gastos, $idTipo);
			break;
		case 'desactivar_categoria_tipo':
			$idCategoria = $_REQUEST['idCategoria'];

			echo $finanzas->desactivar_categoria_tipo($idCategoria);
			break;
		case 'combo_select_categoria':
			$tipo_gastos = $_REQUEST['tipo_gastos'];

			echo '<label for="inputMarca"><b>Tipo Gasto</b></label>';
			echo $recursos->select_tipo_categorias_gastos_dinamico('', $tipo_gastos);
			break;
		case 'grabar_nuevo_gasto':
			
			$idServicio 			= $_REQUEST['idServicio'];
			$inputNombre 			= $_REQUEST['inputNombre'];
			$inputPrecio 			= $_REQUEST['inputPrecio'];
			$tipo_gastos 			= $_REQUEST['tipo_gastos'];
			$tipo_gastos_categorias = $_REQUEST['tipo_gastos_categorias'];
			$inputSucursal 			= $_REQUEST['inputSucursal'];
			$inputDescripcion 		= $_REQUEST['inputDescripcion'];
			$inputFecha 			= $_REQUEST['inputFecha'];

			$grabar      			= $finanzas->grabar_nuevo_gasto($tipo_gastos, $tipo_gastos_categorias, $inputNombre, $inputDescripcion, $inputFecha, $inputSucursal, $inputPrecio, $idServicio);

			return $grabar;
			break;
		case 'facturas_proveedores':
			$mes	   = Utilidades::fecha_mes();
			$ano	   = Utilidades::fecha_ano();
			$idServicio= $_REQUEST['idServicio'];


			echo '	<script src="'.controlador::$rutaAPP.'app/recursos/js/table.js"></script>
					<link href="'.controlador::$rutaAPP.'app/recursos/css/table.css" rel="stylesheet" type="text/css" />';

			echo $finanzas->facturas_proveedores($mes, $ano, $idServicio);

			echo '<script>
					$(document).ready(function() {
				    $("#listado_facturas_proveedores").DataTable({     
					      "aLengthMenu": [[5, 10, 20, -1], [5, 10, 20, "Todos"]],
					        "iDisplayLength": 10
					       });
					});
				  </script>';
			break;
		case 'buscar_facturas_proveedores':
			$mes	   = $_REQUEST['mes'];
			$ano	   = $_REQUEST['ano'];

			echo '	<script src="'.controlador::$rutaAPP.'app/recursos/js/table.js"></script>
					<link href="'.controlador::$rutaAPP.'app/recursos/css/table.css" rel="stylesheet" type="text/css" />';

			echo $finanzas->facturas_proveedores($mes, $ano);

			echo '<script>
					$(document).ready(function() {
				    $("#listado_facturas_proveedores").DataTable({     
					      "aLengthMenu": [[5, 10, 20, -1], [5, 10, 20, "Todos"]],
					        "iDisplayLength": 10
					       });
					});
				  </script>';
			break;
		case 'nuevo_proveedor':
			$rut_validador = "validar_rut('finanzas')";

			$html = '<div class="row mb-4">
					  <p align="left" class="text-success font-weight-light h3">Nuevo Proveedor</p>
					  <hr class="mt-2 mb-3"/>
					    <div class="container mb-4">
					      <div class="row">
					        <div class="col-5 mb-2">
					          <label for="inputNombre"><b>Nombre</b></label>
					          <input type="text" class="form-control shadow" id="inputNombre" placeholder="Nombre" autocomplete="off">
					        </div>
					        <div class="col-5 mb-2">
					          <label for="inputNombre"><b>Rut</b><span id="validar_rut"></span></label>
					          <input type="text" class="form-control shadow" id="inputRut" placeholder="Rut" autocomplete="off" onchange="'.$rut_validador.'">
					        </div>
					        <div class="col-5 mb-2">
					          <label for="inputNombre"><b>Tel&eacute;fono</b></label>
					          <input type="text" class="form-control shadow" id="inputTelefono" placeholder="Telefono" autocomplete="off">
					        </div>
					        <div class="col-5 mb-2">
					          <label for="inputNombre"><b>E-Mail</b></label>
					          <input type="text" class="form-control shadow" id="inputMail" placeholder="E-Mail" autocomplete="off">
					        </div>
					        <div class="col-10 mt-3">
					          <button type="button" id="grabar" class="btn btn-primary form-control shadow" onclick="grabar_nuevo_proveedor()">Grabar <i class="bi bi-save"></i></button>
					        </div>
					      </div>
					    </div>
					</div>';

			echo $html;
			break;
		case 'validar_rut':
			$inputRut 	= $_REQUEST['inputRut'];
			$valida_rut = Utilidades::validaRut($inputRut);
			$html       = '';

			if($valida_rut == 1){
				$html  .= '<b class="text-primary"> Correcto.</b>';
				$html  .= "<script>$('#grabar').prop('disabled', false);</script>";
			}elseif($valida_rut == 0){
				$html  .= '<b class="text-danger"> Incorrecto.</b>';
				$html  .= "<script>$('#grabar').prop('disabled', true);</script>";
			}

			echo $html;			
			break;
		case 'grabar_nuevo_proveedor':
			$inputNombre 	= $_REQUEST['inputNombre'];
			$inputRut 		= $_REQUEST['inputRut'];
			$inputTelefono 	= $_REQUEST['inputTelefono'];
			$inputMail 		= $_REQUEST['inputMail'];

			$grabar      	= $finanzas->grabar_nuevo_proveedor($inputNombre, $inputRut, $inputTelefono, $inputMail);

			return $grabar;
			break;
		case 'grabar_nueva_factura':
			$inputNumero 			= $_REQUEST['inputNumero'];
			$inputProveedor 		= $_REQUEST['inputProveedor'];
			$inputMonto 			= $_REQUEST['inputMonto'];
			$inputFechaFactura 		= $_REQUEST['inputFechaFactura'];
			$inputEstadoFactura 	= $_REQUEST['inputEstadoFactura'];
			$inputFechaPagoFactura 	= $_REQUEST['inputFechaPagoFactura'];
			$inputSucursal 			= $_REQUEST['inputSucursal'];
			$inputDescripcion 		= $_REQUEST['inputDescripcion'];
			$idServicio      		= $_REQUEST['idServicio'];

			$grabar      			= $finanzas->grabar_nueva_factura($inputNumero, $inputProveedor, $inputMonto, $inputFechaFactura, $inputEstadoFactura, $inputFechaPagoFactura, $inputSucursal, $inputDescripcion, $idServicio);

			return $grabar;
			break;
		case 'traer_editar_factura':
			$idFactura = $_REQUEST['idFactura'];

			echo $finanzas->editar_factura_proveedores($idFactura);
			break;
		case 'grabar_editar_factura':
			$idFactura 				= $_REQUEST['idFactura'];
			$inputNumero 			= $_REQUEST['inputNumero'];
			$inputProveedor 		= $_REQUEST['inputProveedor'];
			$inputMonto 			= $_REQUEST['inputMonto'];
			$inputFechaFactura 		= $_REQUEST['inputFechaFactura'];
			$inputEstadoFactura 	= $_REQUEST['inputEstadoFactura'];
			$inputFechaPagoFactura 	= $_REQUEST['inputFechaPagoFactura'];
			$inputSucursal 			= $_REQUEST['inputSucursal'];
			$inputDescripcion 		= $_REQUEST['inputDescripcion'];

			$grabar      			= $finanzas->grabar_editar_factura($idFactura, $inputNumero, $inputProveedor, $inputMonto, $inputFechaFactura, $inputEstadoFactura, $inputFechaPagoFactura, $inputSucursal, $inputDescripcion);

			return $grabar;
			break;
		case 'desactivar_factura':
			$idFactura 				= $_REQUEST['idFactura'];

			$grabar      			= $finanzas->desactivar_factura($idFactura);

			return $grabar;
			break;
		case 'pagar_factura':
			$idFactura 				= $_REQUEST['idFactura'];

			$grabar      			= $finanzas->pagar_factura($idFactura);

			return $grabar;
			break;
		case 'editar_proveedores':
			$idProveedor = $_REQUEST['idProveedor'];

			echo $finanzas->editar_proveedores($idProveedor);
			break;
		case 'grabar_editar_proveedor':
			$idProveedor 	= $_REQUEST['idProveedor'];
			$inputNombre 	= $_REQUEST['inputNombre'];
			$inputRut 		= $_REQUEST['inputRut'];
			$inputTelefono 	= $_REQUEST['inputTelefono'];
			$inputMail 		= $_REQUEST['inputMail'];

			$grabar      	= $finanzas->grabar_editar_proveedor($idProveedor, $inputNombre, $inputRut, $inputTelefono, $inputMail);

			return $grabar;
			break;
		case 'metas_ventas':
			$ano	   = Utilidades::fecha_ano();

			echo $finanzas->metas_ventas($ano);
			break;
		case 'grabar_nueva_meta':
			$idUser 			= $_REQUEST['idUser'];
			$meta_mes 			= $_REQUEST['meta_mes'];
			$inputMonto 		= $_REQUEST['inputMonto'];
			$inputDescripcion 	= $_REQUEST['inputDescripcion'];

			$grabar      		= $finanzas->grabar_nueva_meta($meta_mes, $inputMonto, $inputDescripcion, $idUser);

			return $grabar;
			break;
		case 'anular_metas':
			$idMeta 		= $_REQUEST['idMeta'];
			$motivo_texto 	= $_REQUEST['motivo_texto'];

			$grabar   		= $finanzas->anular_metas($idMeta, $motivo_texto);

			if($grabar){
				echo '<script>
						Swal.fire({
					          title:              "Anulado correctamente",
					          showDenyButton:     false,
					          showCancelButton:   false,
					          confirmButtonText:  "OK",
					          icon:               "success",
					    }).then((result) => {
					        if (result.isConfirmed) {
					        	metas_ventas();
					         }
					    })
					  </script>';
			}else{
				echo '<script>
						Swal.fire({
					          title:              "** Error, reintente **",
					          showDenyButton:     false,
					          showCancelButton:   false,
					          confirmButtonText:  "OK",
					          icon:               "error",
					    }).then((result) => {
					        if (result.isConfirmed) {
					        	metas_ventas();
					         }
					    })
						
					  </script>';
			}
			break;
		case 'consultar_meta':
			$meta_mes      = $_REQUEST['meta_mes'];
			$ano   		   = $_REQUEST['ano'];

			$existe_codigo = $recursos->datos_metas($meta_mes, $ano);

			if(count($existe_codigo) > 0){
				echo '<span class="text-danger">Meta Existe</span>';
				echo '<script> $(".btn").prop("disabled", true);</script>';
			}else{
				echo '<span class="text-success">Meta Válida</span>';
				echo '<script> $(".btn").prop("disabled", false);</script>';
			}
			break;
		case 'facturas_clientes':
			$mes	   = Utilidades::fecha_mes();
			$ano	   = Utilidades::fecha_ano();
			$idServicio= $_REQUEST['idServicio'];


			echo '	<script src="'.controlador::$rutaAPP.'app/recursos/js/table.js"></script>
					<link href="'.controlador::$rutaAPP.'app/recursos/css/table.css" rel="stylesheet" type="text/css" />';

			echo $finanzas->facturas_clientes($mes, $ano, $idServicio);

			echo '<script>
					$(document).ready(function() {
				    $("#listado_facturas_proveedores").DataTable({     
					      "aLengthMenu": [[5, 10, 20, -1], [5, 10, 20, "Todos"]],
					        "iDisplayLength": 10
					       });
					});
				  </script>';
			break;
		case 'grabar_nueva_factura_cliente':
			$inputNumero 			= $_REQUEST['inputNumero'];
			$inputMonto 			= $_REQUEST['inputMonto'];
			$inputFechaFactura 		= $_REQUEST['inputFechaFactura'];
			$inputEstadoFactura 	= $_REQUEST['inputEstadoFactura'];
			$inputFechaPagoFactura 	= $_REQUEST['inputFechaPagoFactura'];
			$inputDescripcion 		= $_REQUEST['inputDescripcion'];
			$idServicio      		= $_REQUEST['idServicio'];
			$foto      				= $_REQUEST['foto'];
			$archivo      			= $_REQUEST['archivo'];

			$grabar      			= $finanzas->grabar_nueva_factura_cliente($inputNumero, $inputMonto, $inputFechaFactura, $inputEstadoFactura, $inputFechaPagoFactura, $inputDescripcion, $idServicio);



			if ($_FILES){

					$name    			= $_FILES['file']['name'];
				    $extraer 			= explode(".", $name);
					$nombre  			= date("Ymd")."".date("Hi").".".$extraer[1];
					$destino 			= "../../../repositorio/documento_edp/".$nombre;
					$tipo   			= $_FILES['file']["type"];
					$ruta_provisional   = $_FILES['file']["tmp_name"];
					$carpeta            = "../../../repositorio/documento_edp/";

					if(move_uploaded_file($_FILES['file']['tmp_name'], $destino)){
						$finanzas->grabar_insertar_documento($nombre, $idServicio);
					
					}else{
				  		return false;
				  	}
				}

			return $grabar;
			break;
		case 'traer_editar_factura_cliente':
			$idFactura = $_REQUEST['idFactura'];

			echo $finanzas->editar_factura_cliente($idFactura);
			break;
		case 'grabar_editar_factura_cliente':
			$idFactura 				= $_REQUEST['idFactura'];
			$inputNumero 			= $_REQUEST['inputNumero'];
			$inputMonto 			= $_REQUEST['inputMonto'];
			$inputFechaFactura 		= $_REQUEST['inputFechaFactura'];
			$inputEstadoFactura 	= $_REQUEST['inputEstadoFactura'];
			$inputFechaPagoFactura 	= $_REQUEST['inputFechaPagoFactura'];
			$inputDescripcion 		= $_REQUEST['inputDescripcion'];

			$grabar      			= $finanzas->grabar_editar_factura_cliente($idFactura, $inputNumero, $inputMonto, $inputFechaFactura, $inputEstadoFactura, $inputFechaPagoFactura, $inputDescripcion);

			return $grabar;
			break;
		case 'desactivar_factura_cliente':
			$idFactura 				= $_REQUEST['idFactura'];

			$grabar      			= $finanzas->desactivar_factura_cliente($idFactura);

			return $grabar;
			break;
		case 'pagar_factura_cliente':
			$idFactura 				= $_REQUEST['idFactura'];

			$grabar      			= $finanzas->pagar_factura_cliente($idFactura);

			return $grabar;
			break;
		case 'facturas_clientes_panel':

			echo '	<script src="'.controlador::$rutaAPP.'app/recursos/js/table.js"></script>
					<link href="'.controlador::$rutaAPP.'app/recursos/css/table.css" rel="stylesheet" type="text/css" />';

			echo '	<div class="col-xl-6 text-warning">
	    				<h3 class="text-dark"><i class="fas fa-receipt text-dark"></i>&nbsp;&nbsp; Facturas Cliente.</h3>
	    			</div>
	    			<div class="col-15">
	    				<p class="h3 text-danger">- Servicios Sin Facturas</p>
	    				'.$finanzas->servicios_sin_factura().'
	    				<p class="h3 text-success">- Servicios Con Facturas</p>
	    				'.$finanzas->servicios_con_factura().'
	    			</div>';

	    	echo '<script>
					$(document).ready(function() {
				    	$("#servicios_pendientes2").DataTable({     
					      "aLengthMenu": [[5, 10, 20, -1], [5, 10, 20, "Todos"]],
					      "iDisplayLength": 5
					    });
					    $("#servicios_pendientes1").DataTable({     
					      "aLengthMenu": [[5, 10, 20, -1], [5, 10, 20, "Todos"]],
					      "iDisplayLength": 10
					    });
					});
				  </script>';

			return $grabar;
			break;
		default:
			// Nada
			break;
	}
?>
