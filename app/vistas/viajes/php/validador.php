<?php 

	date_default_timezone_set("America/Santiago");
	require_once __dir__."/../../../controlador/controlador.php";
	require_once __dir__."/../../../controlador/ventasControlador.php";
	require_once __dir__."/../../../controlador/productosControlador.php";
	require_once __dir__."/../../../controlador/viajesControlador.php";
	require_once __dir__."/../../../controlador/recursosControlador.php";
	require_once __dir__."/../../../controlador/utilidadesControlador.php";
	require_once __dir__."/../../../controlador/bodegaControlador.php";
	
	$mvc2       = new controlador();
	$ventas 	= new Ventas();
	$recursos   = new Recursos();
	$productos  = new Productos();
	$centroCosto= new Viajes();
	$bodega     = new Bodega();

	$accion      = $_REQUEST['accion'];

	switch ($accion) {
		case 'asignar_productos_cotizacion':
			$productos = $_REQUEST['productos'];

			echo $centroCosto->asignar_productos_cotizacion($productos);
			echo '	<script>
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
							var multipleCancelButton = new Choices("#inputTrabajador", {
						        removeItemButton: true,
						    });
						});
						$(document).ready(function() { 
							var multipleCancelButton = new Choices("#inputAcompanante", {
						        removeItemButton: true,
						    });
						});
						$(document).ready(function() { 
							var multipleCancelButton = new Choices("#inputProducto", {
						        removeItemButton: true,
						    });
						});
					</script>';
			break;
		case 'asignar_producto':
			echo '	<div class="container"><div class="row d-flex justify-content-center mt-100 border rounded p-1">
					    <p align="left" class="text-danger font-weight-light h3"><i class="fas fa-shipping-fast text-danger"></i>&nbsp;&nbsp;Crear Viaje</p>
					    <div class="col-md-7">
					    	'.$bodega->select_productos_multiple(1, 1).' 
					    </div>
					    <div class="col-md-3 my-1">
					        <button class="btn btn-primary waves-effect waves-light waves-light " type="button" onclick="asignar_productos_cotizacion()"><i class="bi bi-search"></i>
					        </button>
					    </div>
					    <hr class="mt-2 mb-3"/>
					    <div class="col-md-15" id="resultado_merma"></div>
					</div>
					</div>
					<script>
						$(document).ready(function() { 
							var multipleCancelButton = new Choices("#productos", {
						        removeItemButton: true,
						    });
						});
					</script>';
			break;
		case 'grabar_flete':
			$idServicio 		= $_REQUEST['idServicio'];
			$idProducto 		= $_REQUEST['idProducto'];
			$inputFlete 		= $_REQUEST['inputFlete'];
			$inputOrigen 		= $_REQUEST['inputOrigen'];
			$inputDestino 		= $_REQUEST['inputDestino'];
			$inputCarga 		= $_REQUEST['inputCarga'];
			$inputArribo 		= $_REQUEST['inputArribo'];
			$inputDescarga 		= $_REQUEST['inputDescarga'];
			$inputTrabajador 	= $_REQUEST['inputTrabajador'];
			$inputRampla 		= $_REQUEST['inputRampla'];
			$inputMontoEstadia 	= $_REQUEST['inputMontoEstadia'];
			$inputGlosa 		= $_REQUEST['inputGlosa'];
			$inputGuia_items    = $_REQUEST['inputGuia_items'];
			$inputAcompanante_items    = $_REQUEST['inputAcompanante_items'];
			$inputDescuento    = $_REQUEST['inputDescuento'];

			$tipos_estados_pagos    = $_REQUEST['tipos_estados_pagos'];
			$inputFechaPago    = $_REQUEST['inputFechaPago'];
			$clientes    = $_REQUEST['clientes'];

			



			$grabar         = $centroCosto->grabar_flete($idServicio, $idProducto, $inputFlete, $inputGuia_items, $inputOrigen, $inputDestino, $inputCarga, $inputArribo, $inputTrabajador, $inputRampla, $inputMontoEstadia, $inputGlosa, $inputDescarga, $inputAcompanante_items, $inputDescuento, $tipos_estados_pagos, $inputFechaPago, $clientes);

			echo $grabar;
			break;
		case 'editar_flete':
			$idFlete 			= $_REQUEST['idFlete'];
			$idServicio 		= $_REQUEST['idServicio'];
			$idProducto 		= $_REQUEST['idProducto'];
			$inputFlete 		= $_REQUEST['inputFlete'];
			$inputOrigen 		= $_REQUEST['inputOrigen'];
			$inputDestino 		= $_REQUEST['inputDestino'];
			$inputCarga 		= $_REQUEST['inputCarga'];
			$inputArribo 		= $_REQUEST['inputArribo'];
			$inputDescarga 		= $_REQUEST['inputDescarga'];
			$inputTrabajador 	= $_REQUEST['inputTrabajador'];
			$inputRampla 		= $_REQUEST['inputRampla'];
			$inputMontoEstadia 	= $_REQUEST['inputMontoEstadia'];
			$inputGlosa 		= $_REQUEST['inputGlosa'];
			$inputGuia_items    = $_REQUEST['inputGuia_items'];
			$inputAcompanante_items    = $_REQUEST['inputAcompanante_items'];
			$inputDescuento    = $_REQUEST['inputDescuento'];

			$tipos_estados_pagos    = $_REQUEST['tipos_estados_pagos'];
			$inputFechaPago    = $_REQUEST['inputFechaPago'];
			$clientes    = $_REQUEST['clientes'];

			$grabar         = $centroCosto->editar_flete($idFlete, $idServicio, $idProducto, $inputFlete, $inputGuia_items, $inputOrigen, $inputDestino, $inputCarga, $inputArribo, $inputTrabajador, $inputRampla, $inputMontoEstadia, $inputGlosa, $inputDescarga, $inputAcompanante_items, $inputDescuento, $tipos_estados_pagos, $inputFechaPago, $clientes);

			if($grabar){
				echo '<script>
						Swal.fire({
	                      title:              "Registro Realizado correctamente ",
	                      icon:               "success",
	                      showDenyButton:     false,
	                      showCancelButton:   false,
	                      confirmButtonText:  "OK",
	                      cancelButtonText:   "NO",
	                    }).then((result) => {
	                      parent.location.reload();
	                    }) 
					  </script>';
			}else{
				echo '<script>Swal.fire("Error", " ", "error");</script>';
			}
			break;
		case 'quitar_flete':
			$idFlete 			= $_REQUEST['idFlete'];

			$grabar         = $centroCosto->quitar_flete($idFlete);

			if($grabar){
				echo '<script>
						Swal.fire({
	                      title:              "Registro Realizado correctamente ",
	                      icon:               "success",
	                      showDenyButton:     false,
	                      showCancelButton:   false,
	                      confirmButtonText:  "OK",
	                      cancelButtonText:   "NO",
	                    }).then((result) => {
	                      parent.location.reload();
	                    }) 
					  </script>';
			}else{
				echo '<script>Swal.fire("Error", " ", "error");</script>';
			}
			break;
		case 'quitar_gasto':
			$idGasto 		= $_REQUEST['idGasto'];

			$grabar         = $centroCosto->quitar_gasto($idGasto);

			if($grabar){
				echo '<script>
						Swal.fire({
	                      title:              "Registro Realizado correctamente ",
	                      icon:               "success",
	                      showDenyButton:     false,
	                      showCancelButton:   false,
	                      confirmButtonText:  "OK",
	                      cancelButtonText:   "NO",
	                    }).then((result) => {
	                      parent.location.reload();
	                    }) 
					  </script>';
			}else{
				echo '<script>Swal.fire("Error", " ", "error");</script>';
			}
			break;
		case 'obtener_informe':
			$idServicio = $_REQUEST['idServicio'];

			header("Content-Type: application/vnd.ms-excel");
	    	header("Expires: 0");
	    	header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
	    	header("content-disposition: attachment;filename=detalles.xls");

			echo $centroCosto->mostrar_detalle_servicio_informe($idServicio);
			break;
		case 'crear_servicio':
			
			$codigo_servicio 	 = $_REQUEST['codigo_servicio'];
			$fecha_inicio 		 = $_REQUEST['fecha_inicio'];
			$fecha_termino 		 = $_REQUEST['fecha_termino'];
			$comentario_servicio = $_REQUEST['comentario_servicio'];
			$clientes 			 = $_REQUEST['clientes'];

			$grabar = $centroCosto->crear_servicio($codigo_servicio, $fecha_inicio, $fecha_termino, $comentario_servicio, $clientes);

			if($grabar){
				echo '<script>
						Swal.fire({
	                      title:              "Registro Realizado correctamente ",
	                      icon:               "success",
	                      showDenyButton:     false,
	                      showCancelButton:   false,
	                      confirmButtonText:  "OK",
	                      cancelButtonText:   "NO",
	                    }).then((result) => {
	                      parent.location.reload();
	                    }) 
					  </script>';
			}else{
				echo '<script>Swal.fire("Error", " ", "error");</script>';
			}
			break;
		case 'mostrar_servicios_asignados':
			$inputServicio = $_REQUEST['inputServicio'];

			echo $centroCosto->mostrar_servicios_asignados($inputServicio);
			break;
		case 'procesar_edp':
			$codigo_edp 	= $_REQUEST['codigo_edp'];
			$glosa 			= $_REQUEST['glosa'];
			$inputServicio 	= $_REQUEST['inputServicio'];
			$fecha_pago 	= $_REQUEST['fecha_pago'];

			$grabar 		= $centroCosto->procesar_edp($codigo_edp, $glosa, $inputServicio, $fecha_pago);

			if($grabar > 0){
				echo '<h2 class="fs-title text-center animate__animated animate__zoomInRight">Creado correctamente !</h2>
				      <br>
				      <div class="row justify-content-center" id="procesar_edp">
				      	<h1 style="font-size: xx-large;" align="center" class="fas fa-check text-success animate__animated animate__heartBeat"></h1>
				       </div>
				       <br><br>
				       <div class="row justify-content-center">
				           <div class="col-7 text-center">
				               <h5>Se ha creado EDP N&deg;: <span class="text-primary">'.$codigo_edp.'</span>.</h5>
				            </div>
				            <div class="col mt-1 h4 d-flex justify-content-center"><span class="fas fa-file-pdf text-danger cursor" href="'.controlador::$rutaAPP.'app/vistas/centro_costo/php/mostrar_edp.php?idEstadoPago='.$grabar.'" data-fancybox data-type="iframe" data-preload="true" data-width="600" data-height="800"></span></div>
				        </div>';
			}else{

				echo '<script>
						Swal.fire({
	                      title:              "Error ",
	                      icon:               "success",
	                      showDenyButton:     error,
	                      showCancelButton:   false,
	                      confirmButtonText:  "Reintentar",
	                      cancelButtonText:   "NO",
	                    }).then((result) => {
	                      location.reload();
	                    }) 
					  </script>';
			}
			break;
		case 'centro_costo':
			echo $centroCosto->panel_centro_costos();

			echo '<script>
						$("#centro_costo").DataTable({     
					      "aLengthMenu": [[5, 10, 20, 30, -1], [5, 10, 20, 30, "Todos"]],
					      "iDisplayLength": 5
					   });
					</script>';

			break;
		case 'mostrar_clientes':
			$cliente_id = $_REQUEST['cliente_id'];

			echo $centroCosto->panel_centro_costos($cliente_id);

			echo '<script>
						$("#centro_costo").DataTable({     
					      "aLengthMenu": [[5, 10, 20, 30, -1], [5, 10, 20, 30, "Todos"]],
					      "iDisplayLength": 5
					   });
					</script>';

			break;
		case 'obtener_informe_edp':
			$idEstadoPago = $_REQUEST['idEstadoPago'];

			header("Content-Type: application/vnd.ms-excel");
	    	header("Expires: 0");
	    	header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
	    	header("content-disposition: attachment;filename=obtener_informe_estado_de_pago.xls");

			echo $centroCosto->mostrar_detalle_servicio_informe_edp($idEstadoPago);
			break;
		case 'finalizar_edp':
		session_start();
			$idUsuario      = $_SESSION['IDUSER'];
			$idEstadoPago 	= $_REQUEST['idEstadoPago'];
			$fecha_pago 	= $_REQUEST['fecha_pago'];
			$glosa 			= $_REQUEST['glosa'];
			$neto 			= $_REQUEST['neto'];
			$iva 			= $_REQUEST['iva'];
			$total_pagar 	= $_REQUEST['total_pagar'];

			$grabar         = $centroCosto->finalizar_edp($idUsuario, $idEstadoPago, $fecha_pago, $glosa, $neto, $iva, $total_pagar);

			if($grabar){
				return TRUE;
			}else{
				return FALSE;
			}
			break;
		case 'nuevo_cliente_control':
			$data = "validar_rut('finanzas')";
			echo '<div id="cambiar" class="entero">
					<table width="90%" align="center" class="" cellpadding="5" cellspacing="0">
						<tr>
							<td>Rut: <small id="validar_rut"></small></td>
							<td><input type="text" name="inputRut" id="inputRut" class="form-control shadow" onchange="'.$data.'"></td>
						</tr>
						<tr>
							<td>Raz&oacute;n Social: </td>
							<td><input type="text" name="inputRazonSocial" id="inputRazonSocial" class="form-control shadow"></td>
						</tr>
						<tr>
							<td>Giro: </td>
							<td><input type="text" name="inputGiro" id="inputGiro" class="form-control shadow"></td>
						</tr>
						<tr>
							<td>Tel&eacute;fono: </td>
							<td><input type="text" name="inputTelefono" id="inputTelefono" class="form-control shadow"></td>
						</tr>
						<tr>
							<td>E-Mail: </td>
							<td><input type="text" name="inputEmail" id="inputEmail" class="form-control shadow"></td>
						</tr>
						<tr>
							<td>Direcci&oacute;n: </td>
							<td><input type="text" name="inputDireccion" id="inputDireccion" class="form-control shadow"></td>
						</tr>
						<tr>
							<td>Localidad: </td>
							<td>
								<input type="text" name="inputLocalidad" id="inputLocalidad" class="form-control shadow">
							</td>
						</tr>
						<tr>
							<td colspan="2">
								<table  width="50%" align="center">
									<tr>
										<td>
											<button type="button" id="grabar" class="btn btn-primary form-control shadow" onclick="grabar_nuevo_cliente_control()">Grabar <i class="bi bi-save"></i></button>
										</td>
									</tr>
								</table>
							</td>
						</tr>
					</table>
				</div>';
			break;
		case 'grabar_nuevo_cliente_control':

			$inputRazonSocial	= $_REQUEST['inputRazonSocial'];
			$inputGiro			= $_REQUEST['inputGiro'];
			$inputRut			= $_REQUEST['inputRut'];
			$inputTelefono		= $_REQUEST['inputTelefono'];
			$inputEmail			= $_REQUEST['inputEmail'];
			$inputDireccion		= $_REQUEST['inputDireccion'];
			$inputLocalidad		= $_REQUEST['inputLocalidad'];

			// VALIDAR CLIENTE.
			$existe_cliente = $recursos->cliente_existe($inputRut);

			$grabar         = $ventas->grabar_nuevo_cliente($inputRazonSocial, $inputGiro, $inputRut, $inputTelefono, $inputEmail, $inputDireccion, $inputLocalidad);

			if($existe_cliente[0]['cli_id'] > 0){
				echo '<script>
						Swal.fire("Alerta", "** Cliente Existe **", "warning");
						nuevo_cliente_control();
					  </script>';
			}elseif($grabar){
				echo '<script>
						Swal.fire({
					          title:              "** Cliente grabado correctamente **",
					          showDenyButton:     false,
					          showCancelButton:   false,
					          confirmButtonText:  "OK",
					          icon:               "success",
					    }).then((result) => {
					        if (result.isConfirmed) {
					        	location.reload();
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
					        	location.reload();
					         }
					    })
						
					  </script>';
			}
			break;
		case 'traer_editar_cliente':
			$idCliente 	= $_REQUEST['idCliente'];

			$grabar 	= $centroCosto->traer_editar_cliente($idCliente);
		
			echo $grabar;
			break;
		case 'grabar_editar_cliente_control':

			$idCliente			= $_REQUEST['idCliente'];
			$inputRazonSocial	= $_REQUEST['inputRazonSocial'];
			$inputGiro			= $_REQUEST['inputGiro'];
			$inputRut			= $_REQUEST['inputRut'];
			$inputTelefono		= $_REQUEST['inputTelefono'];
			$inputEmail			= $_REQUEST['inputEmail'];
			$inputDireccion		= $_REQUEST['inputDireccion'];
			$inputLocalidad		= $_REQUEST['inputLocalidad'];


			$grabar         = $centroCosto->grabar_editar_cliente_control($idCliente, $inputRazonSocial, $inputGiro, $inputRut, $inputTelefono, $inputEmail, $inputDireccion, $inputLocalidad);

			if($grabar){
				echo '<script>
						Swal.fire({
					          title:              "** Cliente grabado correctamente **",
					          showDenyButton:     false,
					          showCancelButton:   false,
					          confirmButtonText:  "OK",
					          icon:               "success",
					    }).then((result) => {
					        if (result.isConfirmed) {
					        	location.reload();
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
					        	location.reload();
					         }
					    })
						
					  </script>';
			}
			break;
		case 'quitar_cliente':
			$idCliente		= $_REQUEST['idCliente'];

			$grabar         = $centroCosto->quitar_cliente($idCliente);

			if($grabar){
				echo '<script>
						Swal.fire({
					          title:              "** Cliente borrado correctamente **",
					          showDenyButton:     false,
					          showCancelButton:   false,
					          confirmButtonText:  "OK",
					          icon:               "success",
					    }).then((result) => {
					        if (result.isConfirmed) {
					        	parent.location.reload();
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
					        	location.reload();
					         }
					    })
						
					  </script>';
			}
			break;
		case 'crear_cotizacion':
			$codigo_servicio   		= $_REQUEST['codigo_servicio'];
			$fecha_inicio   		= $_REQUEST['fecha_inicio'];
			$fecha_termino   		= $_REQUEST['fecha_termino'];
			$comentario_servicio   	= $_REQUEST['comentario_servicio'];
			$clientes   			= $_REQUEST['clientes'];
			$titulo_items   		= $_REQUEST['titulo_items'];
			$unidad_items   		= $_REQUEST['unidad_items'];
			$monto_items   			= $_REQUEST['monto_items'];
			$exento_items 			= $_REQUEST['exento_items'];
			$descuentos   			= $_REQUEST['descuentos'];

			$grabar 				= $centroCosto->crear_cotizacion($codigo_servicio, $fecha_inicio, $fecha_termino, $comentario_servicio, $clientes, $titulo_items, $unidad_items, $monto_items, $exento_items,$descuentos);

			if($grabar){
				echo '<script>
						Swal.fire({
					          title:              "** Cotizacion creada correctamente **",
					          showDenyButton:     false,
					          showCancelButton:   false,
					          confirmButtonText:  "OK",
					          icon:               "success",
					    }).then((result) => {
					        if (result.isConfirmed) {
					        	parent.location.reload();
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
					        	location.reload();
					         }
					    })
					  </script>';
			}
			break;
		case 'agregar_items_cotizacion':
			$codigo_cotizacion   	= $_REQUEST['codigo_cotizacion'];
			$titulo_items   		= $_REQUEST['titulo_items'];
			$unidad_items   		= $_REQUEST['unidad_items'];
			$monto_items   			= $_REQUEST['monto_items'];
			$exento_items  			= $_REQUEST['exento_items'];

			$grabar 				= $centroCosto->agregar_items_cotizacion($codigo_cotizacion, $titulo_items, $unidad_items, $monto_items, $exento_items);

			if($grabar){
				echo '<script>
						Swal.fire({
					          title:              "** Items agregados correctamente **",
					          showDenyButton:     false,
					          showCancelButton:   false,
					          confirmButtonText:  "OK",
					          icon:               "success",
					    }).then((result) => {
					        if (result.isConfirmed) {
					        	location.reload();
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
					        	location.reload();
					         }
					    })
					  </script>';
			}
			break;
		case 'quitar_items_cotizacion':
			$idCotizacion = $_REQUEST['idCotizacion'];

			$grabar 	  = $centroCosto->quitar_items_cotizacion($idCotizacion);

			if($grabar){
				echo '<script>
						Swal.fire({
					          title:              "** Items removido correctamente **",
					          showDenyButton:     false,
					          showCancelButton:   false,
					          confirmButtonText:  "OK",
					          icon:               "success",
					    }).then((result) => {
					        if (result.isConfirmed) {
					        	location.reload();
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
					        	location.reload();
					         }
					    })
					  </script>';
			}
			break;
		case 'aceptar_cotizacion':
			$idCotizacion = $_REQUEST['idCotizacion'];

			$grabar 	  = $centroCosto->aceptar_cotizacion($idCotizacion);

			if($grabar){
				echo '<script>
						Swal.fire({
					          title:              "** Cotización Aceptada correctamente **",
					          showDenyButton:     false,
					          showCancelButton:   false,
					          confirmButtonText:  "OK",
					          icon:               "success",
					    }).then((result) => {
					        if (result.isConfirmed) {
					        	parent.location.reload();
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
					        	location.reload();
					         }
					    })
					  </script>';
			}
			break;
		case 'rechazar_cotizacion':
			$idCotizacion = $_REQUEST['idCotizacion'];

			$grabar 	  = $centroCosto->rechazar_cotizacion($idCotizacion);

			if($grabar){
				echo '<script>
						Swal.fire({
					          title:              "** Cotización Rechazada correctamente **",
					          showDenyButton:     false,
					          showCancelButton:   false,
					          confirmButtonText:  "OK",
					          icon:               "success",
					    }).then((result) => {
					        if (result.isConfirmed) {
					        	parent.location.reload();
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
					        	location.reload();
					         }
					    })
					  </script>';
			}
			break;
		case 'traer_editar_cotizacion':
			$idCotizacion = $_REQUEST['idCotizacion'];

			echo $centroCosto->traer_editar_cotizacion($idCotizacion);
			break;
		case 'grabar_editar_cotizacion':
			$idCotizacion 			= $_REQUEST['idCotizacion'];
			$fecha_inicio 			= $_REQUEST['fecha_inicio'];
			$fecha_termino 			= $_REQUEST['fecha_termino'];
			$comentario_servicio 	= $_REQUEST['comentario_servicio'];
			$clientes 				= $_REQUEST['clientes'];
			$descuentos 			= $_REQUEST['descuentos'];

			$grabar 	  			= $centroCosto->grabar_editar_cotizacion($idCotizacion, $fecha_inicio, $fecha_termino, $comentario_servicio, $clientes, $descuentos);

			if($grabar){
				echo '<script>
						Swal.fire({
					          title:              "** Cotización Editada correctamente **",
					          showDenyButton:     false,
					          showCancelButton:   false,
					          confirmButtonText:  "OK",
					          icon:               "success",
					    }).then((result) => {
					        if (result.isConfirmed) {
					        	location.reload();
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
					        	location.reload();
					         }
					    })
					  </script>';
			}
			break;
		case 'traer_editar_items_cotizacion':
			$idItems = $_REQUEST['idItems'];

			echo $centroCosto->traer_editar_items_cotizacion($idItems);
			break;
		case 'grabar_editar_items_cotizacion':
			$idItems = $_REQUEST['idItems'];
			$titulo  = $_REQUEST['titulo'];
			$unidad  = $_REQUEST['unidad'];
			$monto 	 = $_REQUEST['monto'];
			$exento  = $_REQUEST['exento'];

			$grabar  = $centroCosto->grabar_editar_items_cotizacion($idItems, $titulo, $unidad, $monto, $exento);

			if($grabar){
				echo '<script>
						Swal.fire({
					          title:              "** Items Editado correctamente **",
					          showDenyButton:     false,
					          showCancelButton:   false,
					          confirmButtonText:  "OK",
					          icon:               "success",
					    }).then((result) => {
					        if (result.isConfirmed) {
					        	location.reload();
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
					        	location.reload();
					         }
					    })
					  </script>';
			}
			break;
		case 'editar_edp':
			$idEdp = $_REQUEST['idEdp'];
			echo $centroCosto->formulario_editar_edp($idEdp);
			break;
		case 'grabar_editar_edp':
			$idEdp 		 = $_REQUEST['idEdp'];
			$codigo_edp  = $_REQUEST['codigo_edp'];
			$fecha_pago  = $_REQUEST['fecha_pago'];
			$glosa 	 	 = $_REQUEST['glosa'];

			$centroCosto->grabar_editar_edp($idEdp, $codigo_edp, $fecha_pago, $glosa);

			echo '<script>
						Swal.fire({
					          title:              "** EDP Editado correctamente **",
					          showDenyButton:     false,
					          showCancelButton:   false,
					          confirmButtonText:  "OK",
					          icon:               "success",
					    }).then((result) => {
					        if (result.isConfirmed) {
					        	location.reload();
					         }
					    })
					  </script>';
			break;
		case 'eliminar_edp':
			$idEdp = $_REQUEST['idEdp'];

			echo $centroCosto->eliminar_edp($idEdp);

			echo '<script>
						Swal.fire({
					          title:              "** EDP borrado correctamente **",
					          showDenyButton:     false,
					          showCancelButton:   false,
					          confirmButtonText:  "OK",
					          icon:               "success",
					    }).then((result) => {
					        if (result.isConfirmed) {
					        	parent.location.reload();
					         }
					    })
					  </script>';
			break;
		case 'nuevo_documento_edp':
			$idEstadoPago = $_REQUEST['idEstadoPago'];

			$html = ' <div class="col-lg-15 mb-2">
				        <label for="inputTitulo"><b>Titulo</b></label>
				        <input type="text" class="form-control shadow" id="inputTitulo" placeholder="Titulo" autocomplete="off">
				        <input type="hidden" id="inputEstadoPago" value="'.$idEstadoPago.'">
				      </div>
					  <div dir=rtl class="file-loading">
		    			<input id="input-b8" name="input-b8[]" multiple type="file">
					  </div>
					  <script>
						$(document).ready(function() {
							$("#input-b8").fileinput({
								tl: true,
								dropZoneEnabled: false,
								allowedFileExtensions: ["pdf"],
								maxFileSize: 5120
							});
						});
					  </script>';

			echo $html;
			break;
		case 'subir_documento_edp':
			$inputTitulo  	 = $_REQUEST['inputTitulo'];
			$inputEstadoPago = $_REQUEST['inputEstadoPago'];

			if ($_FILES){

				$name    			= $_FILES['file']['name'];
			    $extraer 			= explode(".", $name);
				$nombre  			= date("Ymd")."".date("Hi").".".$extraer[1];
				$destino 			= "../../../repositorio/documento_edp/".$nombre;
				$tipo   			= $_FILES['file']["type"];
				$ruta_provisional   = $_FILES['file']["tmp_name"];
				$carpeta            = "../../../repositorio/documento_edp/";

				if(move_uploaded_file($_FILES['file']['tmp_name'], $destino)){
					$centroCosto->grabar_insertar_documento_edp($nombre, $inputTitulo, $inputEstadoPago);
				
				}else{
			  		return false;
			  	}
			}else{
				return false;
			}
			break;
		case 'agregar_imagen_cotizacion':
			$idCotizacion = $_REQUEST['idCotizacion'];

			$html = ' <div class="col-lg-15 mb-2">
				        <label for="inputTitulo"><b>Titulo</b></label>
				        <input type="text" class="form-control shadow" id="inputTitulo" placeholder="Titulo" autocomplete="off">
				        <input type="hidden" id="inputCotizacion" value="'.$idCotizacion.'">
				      </div>
					  <div dir=rtl class="file-loading">
		    			<input id="input-b8" name="input-b8[]" multiple type="file">
					  </div>
					  <script>
						$(document).ready(function() {
							$("#input-b8").fileinput({
								tl: true,
								dropZoneEnabled: false,
								allowedFileExtensions: ["jpg", "png"],
								maxFileSize: 5120
							});
						});
					  </script>';

			echo $html;
			break;
		case 'subir_documento_cotizacion':
			$inputTitulo  	 = $_REQUEST['inputTitulo'];
			$inputCotizacion = $_REQUEST['inputCotizacion'];

			if ($_FILES){

				$name    			= $_FILES['file']['name'];
			    $extraer 			= explode(".", $name);
				$nombre  			= date("Ymd")."".date("Hi").".".$extraer[1];
				$destino 			= "../../../repositorio/documento_edp/".$nombre;
				$tipo   			= $_FILES['file']["type"];
				$ruta_provisional   = $_FILES['file']["tmp_name"];
				$carpeta            = "../../../repositorio/documento_edp/";

				if(move_uploaded_file($_FILES['file']['tmp_name'], $destino)){
					$centroCosto->grabar_insertar_documento_cotizacion($nombre, $inputTitulo, $inputCotizacion);

			  		return json_encode("listo-subir");

				}else{
					mysqli_error();
			  		return json_encode("error-subir");
			  	}
			}else{
				return json_encode("error-file");

			}
			break;
		case 'asignar_traslados':
			$idServicio = $_REQUEST['idServicio'];

			echo $centroCosto->traslados_agregados($idServicio);
			break;
		case 'asignar_arriendo':
			$idServicio = $_REQUEST['idServicio'];

			echo $centroCosto->arriendos_agregados($idServicio);
			break;
		case 'grabar_nuevo_traslado':
			$idServicio 		= $_REQUEST['idServicio'];
			$inputOrigen 		= $_REQUEST['inputOrigen'];
			$inputDestino 		= $_REQUEST['inputDestino'];
			$inputRegreso 		= $_REQUEST['inputRegreso'];
			$inputValor 		= $_REQUEST['inputValor'];
			$inputCantidad 		= $_REQUEST['inputCantidad'];
			$inputDescripcion 	= $_REQUEST['inputDescripcion'];
			$inputFecha_items 	= $_REQUEST['inputFecha_items'];

			$centroCosto->grabar_nuevo_traslado($idServicio, $inputOrigen, $inputDestino, $inputRegreso, $inputValor, $inputCantidad, $inputDescripcion, $inputFecha_items);
			break;
		case 'grabar_nuevo_arriendo':
			$idServicio 		= $_REQUEST['idServicio'];
			$inputTipoServicio  = $_REQUEST['inputTipoServicio'];
			$inputProyecto 		= $_REQUEST['inputProyecto'];
			$inputContacto 		= $_REQUEST['inputContacto'];
			$mes 				= $_REQUEST['mes'];
			$inputDescripcion 	= $_REQUEST['inputDescripcion'];
			$camion_items 		= $_REQUEST['camion_items'];
			$hors_contrata_items= $_REQUEST['hors_contrata_items'];
			$valor_items 		= $_REQUEST['valor_items'];
			$hr_realizada_items = $_REQUEST['hr_realizada_items'];

			$centroCosto->grabar_nuevo_arriendo($idServicio, $inputTipoServicio, $inputProyecto, $inputContacto, $mes, $inputDescripcion, $camion_items, $hors_contrata_items, $valor_items, $hr_realizada_items);
			break;
		case 'editar_arriendo':
			$idArriendo 		= $_REQUEST['idArriendo'];
			$inputTipoServicio  = $_REQUEST['inputTipoServicio'];
			$inputProyecto 		= $_REQUEST['inputProyecto'];
			$inputContacto 		= $_REQUEST['inputContacto'];
			$mes 				= $_REQUEST['mes'];
			$inputDescripcion 	= $_REQUEST['inputDescripcion'];
			$camion_items 		= $_REQUEST['camion_items'];
			$hors_contrata_items= $_REQUEST['hors_contrata_items'];
			$valor_items 		= $_REQUEST['valor_items'];
			$hr_realizada_items = $_REQUEST['hr_realizada_items'];

			$centroCosto->editar_arriendo($idArriendo, $inputTipoServicio, $inputProyecto, $inputContacto, $mes, $inputDescripcion, $camion_items, $hors_contrata_items, $valor_items, $hr_realizada_items);
			break;
		case 'editar_traslado':
			$idTraslado 		= $_REQUEST['idTraslado'];
			$inputOrigen 		= $_REQUEST['inputOrigen'];
			$inputDestino 		= $_REQUEST['inputDestino'];
			$inputRegreso 		= $_REQUEST['inputRegreso'];
			$inputValor 		= $_REQUEST['inputValor'];
			$inputCantidad 		= $_REQUEST['inputCantidad'];
			$inputDescripcion 	= $_REQUEST['inputDescripcion'];
			$inputFecha_items 	= $_REQUEST['inputFecha_items'];

			$centroCosto->editar_traslado($idTraslado, $inputOrigen, $inputDestino, $inputRegreso, $inputValor, $inputCantidad, $inputDescripcion, $inputFecha_items);
			break;
		case 'traer_bitacora':
			$idFlete = $_REQUEST['idFlete'];

			$html = '
				<div class="row col-10 justify-content-center mx-5 my-5">
				  <div class="col-lg-6 p-3 mb-2 bg-white  border">
				    <label for="inputTitulo"><b>* Titulo:</b></label>
				    <input type="text" class="form-control shadow" id="inputTitulo" placeholder="Escribir Tipo de servicio">
				    <br>
				    <label for="inputFecha"><b>* Fecha:</b></label>
				    <input type="date" name="inputFecha" id="inputFecha" class="form-control shadow">
				    <br>
				    <div class="row">
				    	<div class="col">
				    		<button type="button" id="grabar" class="btn btn-primary form-control shadow" onclick="grabar_bitacora('.$idFlete.')">Grabar <i class="bi bi-save"></i></button>
				    	</div>
				    	<div class="col">
				    		<button type="button" id="grabar" class="btn btn-dark form-control shadow" onclick="cargar_bitacora('.$idFlete.')">Cancelar <i class="icofont icofont-refresh"></i></button>
				    	</div>
				    </div>
				    
				  </div>
				  <div class="col-lg-6 p-3 mb-2 bg-white  border">
				    <label for="inputDescripcion"><b>* Descripción:</b></label>
				    <textarea rows="8" class="form-control shadow" id="inputDescripcion" name="inputDescripcion" placeholder="Escribir Descripción"></textarea>
				  </div>
	
				</div>';

			echo $html;
			break;
		case 'grabar_bitacora':
			$idFlete 			= $_REQUEST['idFlete'];
			$inputTitulo 		= $_REQUEST['inputTitulo'];
			$inputDescripcion 	= $_REQUEST['inputDescripcion'];
			$inputFecha 		= $_REQUEST['inputFecha'];

			$html = $centroCosto->grabar_bitacora($idFlete, $inputTitulo, $inputDescripcion, $inputFecha, 1);

			echo $html;
			break;
		case 'cargar_bitacora':
			$idFlete = $_REQUEST['idFlete'];

			$html = $centroCosto->cargar_bitacora($idFlete, 1);

			echo $html;
			break;
		case 'cargar_editar_flete':
			$idFlete = $_REQUEST['idFlete'];

			$html = $centroCosto->formulario_editar_flete($idFlete, 1);

			echo $html;
			break;
		default:
			break;
	}
?>