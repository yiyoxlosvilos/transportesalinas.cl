<?php
	require_once __dir__."/../modelo/obtener_datos.php";
	require_once __dir__."/../controlador/utilidadesControlador.php";
	require_once __dir__."/../controlador/productosControlador.php";
	require_once __dir__."/../controlador/recursosControlador.php";

	class Finanzas extends GetDatos {
		public function __construct(){
			parent::__construct();
	    }

	    public function traer_pagos_pendientes($mes, $ano, $cant_dias){
	    	$neto_acumulado = 0;
	    	$html = '<div class="col-xl-6">
	    				<h3><i class="bi bi-wallet2"></i>&nbsp;&nbsp;Pagos Pendientes.</h3>
	    			 </div>
	    			 <div class="col-xl-6">
	    				<table width="100%">
	    					<tr>
	    						<td>'.Utilidades::select_agrupacion_cards('', 'mes', $ano, $mes).'</td>
	    						<td>'.Utilidades::select_agrupacion_anos('', 'ano', $ano).'</td>
	    						<td><button class="btn btn-primary" onclick="buscar_pagos_pendientes()"><i class="bi bi-search"></i></button></td>
	    					</tr>
	    				</table>
	    			 </div>
	    			 <hr class="mt-2 mb-3"/>
	    			 <table align="center" cellspacing="5" cellpadding="5" class="table shadow animate__animated animate__fadeInLeft">
						<tr>
							<th align="left" class="text-primary">&nbsp;</th>';

			for ($i=1; $i <= $cant_dias; $i++) {
				$html .= '<th align="center" class="plomo">'.$i.'</th>';
			}

			$html .= '  </tr>';

			$html .= $this->traer_ingresos_pendientes($mes, $ano, $cant_dias);

			$html .= '</table>';

			return $html;
	    }

	    public function traer_ingresos_pendientes($mes, $ano, $cant_dias){
	    	$html = '';

	    	$sql  = $this->selectQuery("SELECT * FROM tipos_pago 
			    						WHERE    	  tipo_estado = 1
			    						AND           tipo_id    != 1
			     						ORDER BY 	  tipo_nombre ASC");

	    	for ($i=0; $i < count($sql); $i++) { 
	    		$html .= '<tr class="cambiazo">';
	    		$html .= '	<td align="left" class="text-dark plomo font-size-17">'.Utilidades::matar_espacio(ucfirst($sql[$i]['tipo_nombre'])).'</td>';
	    		$html .= $this->ingresos_pendientes($sql[$i]['tipo_id'], $mes, $ano, $cant_dias);
	    		$html .= '</tr>';
	    	}

	    	$html .= '<tr>';
	    	$html .= '	<th align="left" class="text-primary plomo font-size-15">Total Pendientes</th>';

	    	for ($i=1; $i <= $cant_dias; $i++) {
	    		$fecha  	= $ano.'-'.$mes.'-'.$i;
	    		$pendientes = $this->monto_pagos_pendientes(0, $fecha);

	    		if ($pendientes > 0) {
	    			$html .= '	<th class="font-size-13 text-primary ">'.Utilidades::monto3($pendientes).'</th>';
	    		}else{
	    			$html .= '	<th class="font-size-13">'.Utilidades::monto3($pendientes).'</th>';
	    		}
	    	}

	    	$html .= '</tr>';

	    	return $html;
	    }

	    public function ingresos_pendientes($tipoPago, $mes, $ano, $cant_dias){
	    	$html = '';

	    	for ($i=1; $i <= $cant_dias; $i++) {
	    		$fecha  	= $ano.'-'.$mes.'-'.$i;
	    		$pendientes = $this->monto_pagos_pendientes($tipoPago, $fecha);

	    		if ($pendientes > 0) {
	    			$html .= '	<td class="font-size-13 text-primary cursor" data-fancybox data-type="iframe" data-preload="true" data-width="100%" data-height="600" href="'.controlador::$rutaAPP.'app/vistas/finanzas/php/validador_finanzas.php?accion=mostrar_pagos_pendientes&fecha='.$fecha.'&tipoPago='.$tipoPago.'">'.Utilidades::monto3($pendientes).'</td>';
	    		}else{
	    			$html .= '	<td class="font-size-13">'.Utilidades::monto3($pendientes).'</td>';
	    		}
	    	}

	    	return $html;
	    }

	    public function monto_pagos_pendientes($tipoPago, $fecha){
	   		$html  = 0;

	   		if($tipoPago > 0){
	   			$script = " AND    	   gas_tipo       = $tipoPago";
	   		}else{
	   			$script = '';
	   		}

	   		$sql   = $this->selectQuery("SELECT * FROM pendiete_pago
						    		     WHERE  	   gas_fecha_pago = '$fecha'
						    		      $script
						    		     AND    	   gas_estado	  = 1");
	   		for ($i=0; $i < count($sql); $i++) { 
	   			$html  += $sql[$i]['gas_monto'];
	   		}

	   		return $html; 
	    }

	    public function traer_pagos_pendientes_fecha($fecha, $tipoPago){
	    	$recursos = new Recursos();

	    	$sql      = $this->selectQuery("SELECT * FROM pendiete_pago
	    									LEFT JOIN 	  clientes
	    									ON            clientes.cli_id 				= pendiete_pago.gas_cliente
							    		    WHERE  	      pendiete_pago.gas_fecha_pago 	= '$fecha'
							    		    AND    	      pendiete_pago.gas_tipo       	= $tipoPago
							    		    AND    	      pendiete_pago.gas_estado	 	= 1"); 

		    $html   = '<div class="row overflow-auto">
		    			<div class="col-xl-6 mt-5">
			    			<table width="100%" class="table shadow">
			    				<tr>
			    					<th>Boleta</th>
			    					<th>Cliente</th>
			    					<th>Monto</th>
			    					<th>&nbsp;</th>
			    				</tr>';

		    for ($i=0; $i < count($sql); $i++) {
			    $html   .= '	<tr>
				    				<td>'.$sql[$i]['gas_boleta'].'</td>
				    				<td>'.$sql[$i]['cli_nombre'].'</td>
				    				<td>'.Utilidades::monto3($sql[$i]['gas_monto']).'</td>
				    				<td><i class="far fa-eye text-primary cursor text_link2" onclick="detalles_pagos_pendientes('.$sql[$i]['gas_boleta'].')"></i></td>
				    			</tr>';
		    }

		    $html   .= '	</table>
		    		   	</div>
		    		   	<div class="col-xl-6 mt-5" id="traer_productos_boleta">&nbsp;</div>
		    		   </div>';

		    return $html;

		}

		public function listado_productos_comprados($boleta){
			$sql = $this->selectQuery("SELECT * FROM caja_cliente
									   LEFT JOIN     product_cliente
									   ON 			 caja_cliente.c_cli_prod_cliente   = product_cliente.prod_cli_id
									   WHERE    	 caja_cliente.c_cli_lote           = $boleta
									   AND 			 caja_cliente.c_cli_tipoMovimiento = 3"); 

			$html = '<table width="100%" class="table shadow">';

			for ($i=0; $i < count($sql); $i++) { 
				$html .= ' <tr>
							  <th align="left">Producto</th>
							  <td align="left">'.$sql[$i]['prod_cli_producto'].'</td>
						   </tr>
						   <tr>
						   	  <th align="left">Monto</th>
							  <td align="left">'.Utilidades::monto3($sql[$i]['c_cli_monto']).'</td>
						   </tr>
						   <tr>
						      <th align="left">Dias Arriendo</th>
							  <td align="left"> '.$sql[$i]['c_cli_dias'].'</td>
						  </tr>
						  <tr>
						      <th align="left" colspan="2">&nbsp;</th>
						  </tr>';
			}

			$html .= '</table>';
			//$html .=  tipo_de_pago($boleta);

			return $html;
		}

		public function gastos_empresa($mes, $ano, $idServicio = 0){
	    	$html = '<div class="col-xl-6">
	    				<h3><i class="fas fa-dollar-sign"></i>&nbsp;&nbsp; Gastos.</h3>
	    			 </div>
	    			 <div class="col-xl-6">
	    				<table width="100%">
	    					<tr>';
	    	if ($idServicio == 0) {
	    		$html.= '		<td>'.Utilidades::select_agrupacion_cards('', 'mes', $ano, $mes).'</td>
	    						<td>'.Utilidades::select_agrupacion_anos('', 'ano', $ano).'</td>
	    						<td>
	    							<button class="btn btn-primary" onclick="buscar_gastos_empresa()">
	    								<i class="bi bi-search"></i>
	    							</button>
	    						</td>';
	    	}else{
	    		$html.= '			<td>
	    							<button class="btn btn-success" type="button" href="'.controlador::$rutaAPP.'app/vistas/finanzas/php/nuevo_gasto.php?idServicio='.$idServicio.'" data-fancybox="" data-type="iframe" data-preload="true" data-width="100%" data-height="1200">
	    								<i class="bi bi-plus-square"></i>
	    							</button>
	    						</td>';
	    	}

	    	$html.= '			<td>
	    							<button class="btn btn-dark" type="button" href="'.controlador::$rutaAPP.'app/vistas/finanzas/php/panel_finanzas.php" data-fancybox="" data-type="iframe" data-preload="true" data-width="100%" data-height="1200">
	    								<i class="bi bi-gear-wide-connected"></i>
	    							</button>
	    						</td>
	    					</tr>
	    				</table>
	    			 </div>
	    			 <hr class="mt-2 mb-3"/>
	    			 <div class="col-xl-15 animate__animated animate__fadeInLeft">'.$this->listado_gastos($mes, $ano, $idServicio).'</div>';

			return $html;
	    }

	    public function listado_gastos($mes, $ano, $idServicio){
	    	$script     = "";
			$desde      = $ano.'-'.$mes.'-01';
	    	$ultimo_dia = date("t", strtotime($desde));
	    	$hasta  	= $ano.'-'.$mes.'-'.$ultimo_dia;

	    	if($idServicio > 0){
	    		$script   .= " AND gastos_empresa.gas_servicio = $idServicio";
	    	}else{
	    		$script   .= " AND gastos_empresa.gas_fecha BETWEEN '$desde' AND '$hasta'";
	    	}

			$sql 		= $this->selectQuery("SELECT * FROM gastos_empresa
											  LEFT JOIN     tipo_gastos
											  ON 			tipo_gastos.tpgas_id 			= gastos_empresa.gas_categoria 	
											  LEFT JOIN 	tipo_gastos_categoria
											  ON 			tipo_gastos_categoria.cate_id 	= gastos_empresa.gas_tipo
											  LEFT JOIN     trabajadores
											  ON 			trabajadores.tra_id             = gastos_empresa.gas_chofer
									   		  WHERE  		gastos_empresa.gas_estado   	= 1
									   		  $script
									   		  ORDER BY 	 	gastos_empresa.gas_fecha ASC"); 

			$html   	= '<table width="100%" class="table shadow">
							<thead>
							<tr class="table-info">
								<th align="left">Categoria</th>
								<th align="left">Tipo</th>
								<th align="left">Fecha</th>
								<th align="left">Trabajador</th>
								<th align="left">Descripción</th>
								<th align="left">Monto</th>
								<th align="left">&nbsp;</th>
							</tr>
							</thead>
							<tbody>';
			$sum = 0;

			if (count($sql) > 0) {
				for ($i=0; $i < count($sql); $i++) { 
					$sum    += $sql[$i]['gas_monto'];
					$html   .= '<tr id="cambiazo2" >
									<td>'.$sql[$i]['tpgas_nombre'].'</td>
									<td>'.$sql[$i]['cate_nombre'].'</td>
									<td>'.Utilidades::arreglo_fecha2($sql[$i]['gas_fecha']).'</td>
									<td>'.$sql[$i]['tra_nombre'].'</td>
									<td>'.$sql[$i]['gas_descripcion'].'</td>
									<td>'.Utilidades::monto3($sql[$i]['gas_monto']).'</td>
									<td><li class="fas fa-window-close text-danger cursor" onclick="quitar_gasto('.$sql[$i]['gas_id'].')"></li></td>				
								</tr>';
				}

				$html .= '<tr class="plomo">
							<th align="right" colspan="5">Total</th>
							<th align="left" colspan="2"><h5>'.Utilidades::monto3($sum).'</h5></th>					
						</tr>';
			}else{
				$html .= '<tr id="cambiazo2">
							<td colspan="6" align="center"><h3>Sin Registros.</h3></td>
						</tr>';
			}

			$html .= '</tbody></table>';	

			return $html;
		}

		public function listado_gastos_ruta($mes, $ano, $idServicio, $idTrabajador, $tipo_gasto){ //$tipo_gasto: 1 = Ida, 2 = Regreso.
			$recursos 	= new Recursos();
	    	$script     = "";
			$desde      = $ano.'-'.$mes.'-01';
	    	$ultimo_dia = date("t", strtotime($desde));
	    	$hasta  	= $ano.'-'.$mes.'-'.$ultimo_dia;

	    	if($idServicio > 0){
	    		$script   .= " AND gastos_empresa.gas_servicio = $idServicio";
	    	}else{
	    		$script   .= " AND gastos_empresa.gas_fecha BETWEEN '$desde' AND '$hasta'";
	    	}

	    	if($tipo_gasto == 1){
	    		$tipo = "ida";
	    	}elseif($tipo_gasto == 2){
	    		$tipo = "regreso";
	    	}

			$sql 		= $this->selectQuery("SELECT * FROM gastos_empresa
											  LEFT JOIN 	tipo_gastos_categoria
											  ON 			tipo_gastos_categoria.cate_id 	  = gastos_empresa.gas_tipo
											  LEFT JOIN 	sucursales
											  ON 			sucursales.suc_id 				  = gastos_empresa.gas_sucursal
									   		  WHERE  		gastos_empresa.gas_estado   	  = 1
									   		  $script
									   		  AND           gastos_empresa.gas_chofer         = $idTrabajador
									   		  AND           tipo_gastos_categoria.cate_nombre LIKE '%$tipo%'
									   		  ORDER BY 	 	gastos_empresa.gas_fecha ASC"); 

			$html   	= '<table width="100%" class="table border">
							<thead>
							<tr class="table-info">
								<th align="left">Categoria</th>
								<th align="left">Tipo</th>
								<th align="left">Fecha</th>
								<th align="left">Descripci&oacute;n</th>
								<th align="left">Monto</th>
								<th align="left">&nbsp;</th>
							</tr>
							</thead>
							<tbody>';
			$sum = 0;

			if (count($sql) > 0) {
				for ($i=0; $i < count($sql); $i++) { 
					$sum    += $sql[$i]['gas_monto'];
					$html   .= '<tr id="cambiazo2" >
									<td>'.$recursos->nombre_tipo_gastos($sql[$i]['gas_categoria']).'</td>
									<td>'.$recursos->nombre_tipo_categorias_gastos($sql[$i]['gas_tipo']).'</td>
									<td>'.Utilidades::arreglo_fecha2($sql[$i]['gas_fecha']).'</td>
									<td>'.$sql[$i]['gas_descripcion'].'</td>
									<td>'.Utilidades::monto3($sql[$i]['gas_monto']).'</td>
									<td><li class="fas fa-window-close text-danger cursor" onclick="quitar_gasto('.$sql[$i]['gas_id'].')"></li></td>				
								</tr>';
				}

				$html .= '<tr class="plomo">
							<th align="right" colspan="5">Total</th>
							<th align="left" colspan="2"><h5>'.Utilidades::monto3($sum).'</h5></th>					
						</tr>';
			}else{
				$html .= '<tr id="cambiazo2">
							<td colspan="6" align="center"><h3>Sin Registros.</h3></td>
						</tr>';
			}

			$html .= '</tbody></table>';	

			return $html;
		}

		public function grabar_categorias($inputNombre, $idUser){
			$grabar = $this->insert_query("INSERT INTO tipo_gastos(tpgas_nombre, tpgas_estado) 
				   						   VALUES('$inputNombre', 1)");

			if($grabar > 0){
				return TRUE;
			}else{
				return FALSE;
			}
		}

		public function editar_categoria($idCategoria){
			$html   = '';
			$sql    = $this->selectQuery("SELECT * FROM tipo_gastos
					   					  WHERE  		tpgas_id = $idCategoria");

			for ($i=0; $i < count($sql); $i++) { 
				$html .= ' <div class="row mb-4">
							  <p align="left" class="text-success font-weight-light h3">Editar Categoría</p>
							  <hr class="mt-2 mb-3"/>
							    <div class="container mb-4">
							      <div class="row">
							        <div class="col-10 mb-2">
							          <label for="inputNombre"><b>Nombre</b></label>
							          <input type="text" class="form-control shadow" id="inputNombre" placeholder="Nombre" autocomplete="off" value="'.$sql[$i]['tpgas_nombre'].'">
							        </div>
							        <div class="col-5 mb-2">
							          <button type="button" id="grabar" class="btn btn-primary form-control shadow" onclick="grabar_editar_categoria('.$idCategoria.')">Editar <i class="bi bi-save"></i></button>
							        </div>
							        <div class="col-5 mb-2">
							          <button type="button" id="grabar" class="btn btn-danger form-control shadow" onclick="desactivar_categoria('.$idCategoria.')">Desactivar<i class="bi bi-save"></i></button>
							        </div>
							      </div>
							    </div>
							</div>';
			}

			return $html;
		}

		public function grabar_editar_categoria($inputNombre, $idCategoria){
			$sql = $this->update_query("UPDATE tipo_gastos
										SET    tpgas_nombre = '$inputNombre'
										WHERE  tpgas_id     = $idCategoria");

			return $sql;
		}

		public function desactivar_categoria($idCategoria){
			$sql = $this->update_query("UPDATE tipo_gastos
										SET    tpgas_estado = 0
										WHERE  tpgas_id     = $idCategoria");

			return $sql;
		}

		public function grabar_tipo_categoria($inputNombre, $tipo_gastos){
			$grabar = $this->insert_query("INSERT INTO tipo_gastos_categoria(cate_nombre, cate_estado, cate_tipo) 
				   						   VALUES('$inputNombre', 1, '$tipo_gastos')");

			if($grabar > 0){
				return TRUE;
			}else{
				return FALSE;
			}
		}

		public function grabar_editar_categoria_tipo($inputNombre, $tipo_gastos, $idTipo){
			$sql = $this->update_query("UPDATE tipo_gastos_categoria
										SET    cate_nombre = '$inputNombre',
											   cate_tipo   = '$tipo_gastos'
										WHERE  cate_id     = $idTipo");

			return $sql;
		}

		public function desactivar_categoria_tipo($idCategoria){
			$sql = $this->update_query("UPDATE tipo_gastos_categoria
										SET    cate_estado = 0
										WHERE  cate_id     = $idCategoria");

			return $sql;
		}

		public function grabar_nuevo_gasto($tipo_gastos, $tipo_gastos_categorias, $inputNombre, $inputDescripcion, $inputFecha, $inputSucursal, $inputPrecio, $idServicio, $tipo_servicio, $servicio_cliente, $servicio_prestado){

			$grabar = $this->insert_query("INSERT INTO gastos_empresa(gas_categoria, gas_tipo, gas_monto, gas_fecha, gas_nombre, gas_descripcion, gas_estado, gas_sucursal, gas_servicio) VALUES('$tipo_gastos', '$tipo_gastos_categorias', '$inputPrecio', '$inputFecha', '$inputNombre', '$inputDescripcion', 1, '$inputSucursal', '$idServicio', '$tipo_servicio', '$servicio_cliente', '$servicio_prestado')");

			if($grabar > 0){
				return TRUE;
			}else{
				return FALSE;
			}

		}

		public function facturas_proveedores($mes, $ano, $idServicio = 0){
			$recursos = new Recursos();
	    	$html 	  = '
	    				<div class="col-xl-6 text-success">
	    				<h3 class="text-success"><i class="fas fa-receipt text-success"></i>&nbsp;&nbsp; Facturas Proveedores.</h3>
	    			 </div>
	    			 <div class="col-xl-6">
	    				<table width="100%">
	    					<tr>';

	    	if ($idServicio == 0) {
	    		$html 	 .=    '<td>'.Utilidades::select_agrupacion_cards('', 'mes', $ano, $mes).'</td>
	    						<td>'.Utilidades::select_agrupacion_anos('', 'ano', $ano).'</td>
	    						<td>
	    							<button class="btn btn-primary" onclick="buscar_facturas_proveedores()">
	    								<i class="bi bi-search"></i>
	    							</button>
	    						</td>';
	    	}

	    	if ($idServicio > 0) {
	    		$html 	 .=    '<td>
	    							<button class="btn btn-success" type="button" href="'.controlador::$rutaAPP.'app/vistas/finanzas/php/nueva_factura.php?idServicio='.$idServicio.'" data-fancybox="" data-type="iframe" data-preload="true" data-width="100%" data-height="1200">
	    								<i class="bi bi-plus-square"></i>
	    							</button>
	    						</td>';
	    	}

	    	$html 	 .=    '	<td>
	    							<button class="btn btn-dark" type="button" href="'.controlador::$rutaAPP.'app/vistas/finanzas/php/panel_proveedores.php" data-fancybox="" data-type="iframe" data-preload="true" data-width="100%" data-height="1200">
	    								<i class="bi bi-gear-wide-connected"></i>
	    							</button>
	    						</td>
	    					</tr>
	    				</table>
	    			 </div>
	    			 <hr class="mt-2 mb-3"/>
	    			 <div class="col-xl-15 animate__animated animate__fadeInLeft">
	    			 	'.$this->listado_facturas_proveedores($mes, $ano, $idServicio).'
	    			 </div>';

			return $html;
	    }

	    public function listado_facturas_proveedores($mes, $ano, $idServicio){
	    	$recursos 	= new Recursos();
	    	$desde      = $ano.'-'.$mes.'-01';
	    	$ultimo_dia = date("t", strtotime($desde));
	    	$hasta  	= $ano.'-'.$mes.'-'.$ultimo_dia;
	    	$hoy        = Utilidades::fecha_hoy();
	    	$total      = 0;
	    	$script     = '';

	    	if($idServicio > 0){
	    		$script   .= " AND fac_servicio = $idServicio";
	    	}else{
	    		$script   .= " AND fac_fecha_factura  BETWEEN '$desde' AND '$hasta'";
	    	}

	    	$sql    	= $this->selectQuery("SELECT * FROM facturas_proveedores
										  	  WHERE    		fac_estado != 3 
										  	  $script
										  	  ORDER BY      fac_fecha_pago DESC");

			$html = ' <table id="listado_facturas_proveedores" class="table shadow">
			            <thead >
			              	<tr class="table-info">
								<th>N&deg; Factura</th>
								<th>Fecha Pago</th>
								<th>Dias Restantes</th>
								<th>Proveedor</th>
								<th>Monto Pago</th>
								<th>Estado</th>
								<th>&nbsp;</th>
							</tr>
			            </thead>
			            <tbody>';

			for ($i=0; $i < count($sql); $i++) {

				$dias    		  = Utilidades::contador_fecha($hoy, $sql[$i]['fac_fecha_pago']);
				$nombre_proveedor = $recursos->datos_proveedores($sql[$i]['fac_proveedor']);
				$factura_estado   = $recursos->estado_factura($sql[$i]['fac_estado']);

				if($sql[$i]['fac_estado'] == 2){
					$mostramos = '<span class="text-danger">'.$dias.'</span>';
				}else{
					$mostramos = '---';
				}

				$html .= '<tr>
				          	<td>'.$sql[$i]['fac_folio'].'</td>
				          	<td>'.Utilidades::arreglo_fecha2($sql[$i]['fac_fecha_pago']).'</td>
				          	<td>'.$mostramos.'</td>
				          	<td>'.$nombre_proveedor[0]['proveedor_nombre'].'</td>
				          	<td>'.Utilidades::monto3($sql[$i]['fac_bruto']).'</td>
				          	<td>'.$factura_estado[0]['tip_nombre'].'</td>
				          	<td align="center">
				          		<i class="far fa-eye text-primary ver" href="'.controlador::$rutaAPP.'app/vistas/finanzas/php/panel_facturas.php?idFactura='.$sql[$i]['fac_id'].'" data-fancybox="" data-type="iframe" data-preload="true" data-width="100%" data-height="1200"></i>
				          	</td>
				          </tr>';
				$total += $sql[$i]['fac_bruto'];
			}

			$html .= ' 
						<tr>
							<td colspan="3">&nbsp;</td>
							<th align="right">Total:</th>
							<th align="left">'.Utilidades::monto3($total).'</th>
							<td align="center">&nbsp;</td>
							<td align="center">&nbsp;</td>
						</tr>
						</tbody>
					  </table>';

			return $html;
	    }

	    public function info_facturas_proveedores($idFactura){
	    	$recursos 	= new Recursos();
	    	$hoy        = Utilidades::fecha_hoy();
	    	$total      = 0;

	    	$sql    	= $this->selectQuery("SELECT * FROM facturas_proveedores
										  	  WHERE    		fac_id = $idFactura");

			$html = '';

			for ($i=0; $i < count($sql); $i++) {

				if($sql[$i]['fac_estado'] == 2){
					$dias      = Utilidades::contador_fecha($hoy, $sql[$i]['fac_fecha_pago']);
					$mostramos = '	<tr>
							          	<th><b>Dias al Pago:</b></th>
							          	<td>'.$dias.'</td>
							        </tr>';
				}else{
					$mostramos = '';
				}
			
				$nombre_proveedor = $recursos->datos_proveedores($sql[$i]['fac_proveedor']);
				$factura_estado   = $recursos->estado_factura($sql[$i]['fac_estado']);

				$html .= '<table id="listado_facturas_proveedores" class="table" style="width:100%">
							<tr>
					          	<th><b>N&deg; Factura:</b></th>
					          	<td>'.$sql[$i]['fac_folio'].'</td>
					        </tr>
					        <tr>
					          	<th><b>Proveedor:</b></th>
					          	<td>'.$nombre_proveedor[0]['proveedor_nombre'].'</td>
					        </tr>
					        <tr>
					          	<th><b>Monto:</b></th>
					          	<td>'.Utilidades::monto3($sql[$i]['fac_bruto']).'</td>
					        </tr>
					        <tr>
					          	<th><b>Fecha Factura:</b></th>
					          	<td>'.Utilidades::arreglo_fecha2($sql[$i]['fac_fecha_factura']).'</td>
					        </tr>
					        '.$mostramos.'
					        <tr>
					          	<th><b>Fecha Pago:</b></th>
					          	<td>'.Utilidades::arreglo_fecha2($sql[$i]['fac_fecha_pago']).'</td>
					        </tr>
					        <tr>
					          	<th><b>Estado Factura:</b></th>
					          	<td>'.$factura_estado[0]['tip_nombre'].'</td>
					        </tr>
					        <tr>
					          	<th colspan="2"><b>Descripción:</b></th>
					        </tr>
					        <tr>
					          	<td colspan="2">'.$sql[$i]['fac_comentario'].'</td>
					        </tr>
					        <tr>
					          	<td>
					          		<button type="button" id="grabar" class="btn btn-primary form-control shadow" onclick="traer_editar_factura('.$idFactura.')">Editar <i class="bi bi-save"></i></button>
					          	</td>
					          	<td>
					          		<button type="button" id="grabar" class="btn btn-danger form-control shadow" onclick="desactivar_factura('.$idFactura.')">Desactivar<i class="bi bi-save"></i></button>
					          	</td>
					        </tr> 
				          </table>';
			}

			return $html;
	    }

	    public function editar_factura_proveedores($idFactura){
	    	$recursos  = new Recursos();
	    	$productos = new Productos();

	    	$sql       = $this->selectQuery("SELECT * FROM facturas_proveedores
										  	 WHERE    		fac_id = $idFactura");

	    	for ($i=0; $i < count($sql); $i++) {

	    		if($sql[$i]['fac_estado'] == 1){
	    			$fecha_pagado = '<div class="col-lg-5 mb-2" id="mostrar_fecha_pago" style="display: none;">
					          <label for="inputFechaPagoFactura"><b>Fecha Pago Factura</b></label>
					            <span id="validador_curso"></span>
					            <input type="date" class="form-control shadow" id="inputFechaPagoFactura" value="'.$sql[$i]['fac_fecha_pago'].'">
					        </div>';
	    		}else{
	    			$fecha_pagado = '<div class="col-lg-5 mb-2" id="mostrar_fecha_pago">
					          <label for="inputFechaPagoFactura"><b>Fecha Pago Factura</b></label>
					            <span id="validador_curso"></span>
					            <input type="date" class="form-control shadow" id="inputFechaPagoFactura" value="'.$sql[$i]['fac_fecha_pago'].'">
					        </div>';
	    		}

	    		$html = '<div class="container mb-4">
					      <div class="row">
					        <div class="col-lg-5 mb-2">
					          <label for="inputNumero"><b>N&deg; Factura:</b></label>
					          <input type="number" class="form-control shadow" id="inputNumero" placeholder="Escribir N&deg; Factura" autocomplete="off" value="'.$sql[$i]['fac_folio'].'">
					        </div>
					        <div class="col-lg-5 mb-2">
					          <label for="inputProveedor"><b>Proveedor</b></label>
					            '.$recursos->select_proveedor('', $sql[$i]['fac_proveedor']).'
					        </div>
					        <div class="col-lg-5 mb-2">
					          <label for="inputMonto"><b>Monto:</b></label>
					          <input type="number" class="form-control shadow" id="inputMonto" placeholder="Escribir Monto Factura" autocomplete="off" value="'.$sql[$i]['fac_bruto'].'">
					        </div>
					        <div class="col-lg-5 mb-2">
					          <label for="inputFechaFactura"><b>Fecha Factura</b></label>
					            <span id="validador_curso"></span>
					            <input type="date" class="form-control shadow" id="inputFechaFactura"  value="'.$sql[$i]['fac_fecha_factura'].'">
					        </div>
					        <div class="col-lg-5 mb-2">
					          <label for="inputEstadoFactura"><b>Estado Factura</b></label>
					          '.$recursos->select_estado_factura('mostrar_fecha_pago', $sql[$i]['fac_estado']).'
					        </div>
					        '.$fecha_pagado.'
					        <div class="col-lg-5 mb-2">
					          <label for="inputSucursal"><b>Sucursal</b></label>
					            <span id="validador_curso"></span>
					            '.$productos->seleccion_sucursal($sql[$i]['fac_sucursal']).'
					        </div>
					        <div class="col-lg-15">
					          <label for="inputSucursal"><b>Descripción</b></label>
					            <span id="validador_curso"></span>
					            <textarea class="form-control shadow" id="inputDescripcion" rows="5">'.$sql[$i]['fac_comentario'].'</textarea>
					        </div>
					        <div class="col-lg-15 mb-2">
					          <label for="inputTipo">&nbsp;</label>
					          <button type="button" id="grabar" class="btn btn-primary form-control shadow" onclick="grabar_editar_factura('.$idFactura.')">Grabar <i class="bi bi-save"></i></button>
					        </div>
					      </div>
					    </div>';
	    	}

			echo $html; 
	    }

	    public function listado_proveedores(){
			$sql    = $this->selectQuery("SELECT * FROM proveedor
										  WHERE  		proveedor_estado = 1");

			$html = ' <table id="proveedores_list" class="table table-hover shadow-lg" style="width:100%">
			            <thead >
			              <tr class="table-info">
			                <th>Nombre</th>
			                <th>Rut</th>
			                <th>Telefono</th>
			                <th>E-Mail</th>
			                <th>&nbsp;</th>
			              </tr>
			            </thead>
			            <tbody>';
			for ($i=0; $i < count($sql); $i++) { 
				$html .= '<tr>
				          	<td>'.ucfirst($sql[$i]['proveedor_nombre']).'</td>
				          	<td>'.$sql[$i]['proveedor_rut'].'</td>
				          	<td>'.$sql[$i]['proveedor_telefono'].'</td>
				          	<td>'.$sql[$i]['proveedor_email'].'</td>
				          	<td align="center">
				          		<i class="bi bi-pencil-square text-primary ver" onclick="editar_proveedores('.$sql[$i]['proveedor_id'].')"></i>
				          	</td>
				          </tr>';
			}

			$html .= ' </tbody>
					  </table>';

			return $html;
		}

		public function editar_proveedores($idProveedor){
			$sql    = $this->selectQuery("SELECT * FROM proveedor
										  WHERE  		proveedor_id = $idProveedor");

			$html = '';
			for ($i=0; $i < count($sql); $i++) { 
				$rut_validador = "validar_rut('finanzas')";

				$html .= '	<div class="row mb-4">
								<p align="left" class="text-success font-weight-light h3">Nuevo Proveedor</p>
								<hr class="mt-2 mb-3"/>
								<div class="container mb-4">
								      <div class="row">
								        <div class="col-5 mb-2">
								          <label for="inputNombre"><b>Nombre</b></label>
								          <input type="text" class="form-control shadow" id="inputNombre" placeholder="Nombre" autocomplete="off" value="'.$sql[$i]['proveedor_nombre'].'">
								        </div>
								        <div class="col-5 mb-2">
								          <label for="inputNombre"><b>Rut</b><span id="validar_rut"></span></label>
								          <input type="text" class="form-control shadow" id="inputRut" placeholder="Rut" autocomplete="off" onchange="'.$rut_validador.'" value="'.$sql[$i]['proveedor_rut'].'">
								        </div>
								        <div class="col-5 mb-2">
								          <label for="inputNombre"><b>Tel&eacute;fono</b></label>
								          <input type="text" class="form-control shadow" id="inputTelefono" placeholder="Telefono" autocomplete="off" value="'.$sql[$i]['proveedor_telefono'].'">
								        </div>
								        <div class="col-5 mb-2">
								          <label for="inputNombre"><b>E-Mail</b></label>
								          <input type="text" class="form-control shadow" id="inputMail" placeholder="E-Mail" autocomplete="off" value="'.$sql[$i]['proveedor_email'].'">
								        </div>
								        <div class="col-10 mt-3">
								          <button type="button" id="grabar" class="btn btn-primary form-control shadow" onclick="grabar_editar_proveedor('.$sql[$i]['proveedor_id'].')">Grabar <i class="bi bi-save"></i></button>
								        </div>
								      </div>
								</div>
							</div>';
			}

			echo $html;
		}

		public function grabar_nuevo_proveedor($inputNombre, $inputRut, $inputTelefono, $inputMail){
			$hoy 	= Utilidades::fecha_hoy();
			$hora   = Utilidades::hora();

			$grabar = $this->insert_query("INSERT INTO proveedor(proveedor_nombre, proveedor_rut, proveedor_telefono, proveedor_email, proveedor_fecha, proveedor_hora, proveedor_estado) 
				   						   VALUES('$inputNombre', '$inputRut', '$inputTelefono', '$inputMail', '$hoy', '$hora', 1)");

			if($grabar > 0){
				return TRUE;
			}else{
				return FALSE;
			}
		}

		public function grabar_nueva_factura($inputNumero, $inputProveedor, $inputMonto, $inputFechaFactura, $inputEstadoFactura, $inputFechaPagoFactura, $inputSucursal, $inputDescripcion, $idServicio){
			$neto   = round($inputMonto/1.19);
			$iva    = ($inputMonto-$neto);
			$bruto  = $inputMonto;

			$grabar = $this->insert_query("INSERT INTO facturas_proveedores(fac_folio, fac_servicio, fac_proveedor, fac_neto, fac_iva, fac_bruto, fac_fecha_factura, fac_fecha_pago, fac_comentario, fac_sucursal, fac_estado) VALUES('$inputNumero', '$idServicio', '$inputProveedor', '$neto', '$iva', '$bruto', '$inputFechaFactura', '$inputFechaPagoFactura', '$inputDescripcion', '$inputSucursal', '$inputEstadoFactura')");

			if($grabar > 0){
				return TRUE;
			}else{
				return FALSE;
			}
		}

		public function grabar_editar_factura($idFactura, $inputNumero, $inputProveedor, $inputMonto, $inputFechaFactura, $inputEstadoFactura, $inputFechaPagoFactura, $inputSucursal, $inputDescripcion){
			$neto   = round($inputMonto/1.19);
			$iva    = ($inputMonto-$neto);
			$bruto  = $inputMonto;

			$grabar = $this->update_query("UPDATE 	facturas_proveedores 
										   SET 		fac_folio 			= '$inputNumero', 
										   			fac_proveedor 		= '$inputProveedor', 
										   			fac_neto 			= '$neto', 
										   			fac_iva 			= '$iva', 
										   			fac_bruto 			= '$bruto', 
										   			fac_fecha_factura  	= '$inputFechaFactura', 
										   			fac_fecha_pago 		= '$inputFechaPagoFactura', 
										   			fac_comentario 		= '$inputDescripcion', 
										   			fac_sucursal 		= '$inputSucursal', 
										   			fac_estado 			= '$inputEstadoFactura'
										   WHERE    fac_id = $idFactura");

			if($grabar > 0){
				return TRUE;
			}else{
				return FALSE;
			}
		}

		public function pagar_factura($idFactura){
			$grabar = $this->update_query("UPDATE 	facturas_proveedores 
										   SET 		fac_estado 	= 1
										   WHERE    fac_id 		= $idFactura");

			if($grabar > 0){
				return TRUE;
			}else{
				return FALSE;
			}
		}

		public function desactivar_factura($idFactura){
			$grabar = $this->update_query("UPDATE 	facturas_proveedores 
										   SET 		fac_estado 	= 3
										   WHERE    fac_id 		= $idFactura");

			if($grabar > 0){
				return TRUE;
			}else{
				return FALSE;
			}
		}

		public function estado_factura_proveedores($idFactura){
	    	$recursos  = new Recursos();
	    	$productos = new Productos();

	    	$sql       = $this->selectQuery("SELECT * FROM facturas_proveedores
										  	 WHERE    		fac_id = $idFactura");

	    	for ($i=0; $i < count($sql); $i++) {

	    		if($sql[$i]['fac_estado'] == 2){
	    			$html   .= '<table id="listado_facturas_proveedores" class="table" style="width:100%">
							<tr>
								<td align="left">Total a Pagar:</td>
								<td align="left">'.Utilidades::monto3($sql[$i]['fac_bruto']).'</td>
							</tr>
							<tr>
								<td align="left">Fecha Pago:</td>
								<td align="left">'.Utilidades::arreglo_fecha2($sql[$i]['fac_fecha_pago']).'</td>
							</tr>
						</table>
						<table class="table" style="width:100%">
							<tr>
								<td align="center">
									<button type="button" id="grabar" class="btn btn-success form-control shadow" onclick="pagar_factura('.$idFactura.')">Efectuar Pago <i class="bi bi-save"></i></button>
								</td>
							</tr>
						</table>';
	    		}else{
	    			$html   .= '<table id="listado_facturas_proveedores" class="table" style="width:100%">
							<tr>
								<td align="left">Total Pagado:</td>
								<td align="left">'.Utilidades::monto3($sql[$i]['fac_bruto']).'</td>
							</tr>
							<tr>
								<td align="left">Fecha Pago:</td>
								<td align="left">'.Utilidades::arreglo_fecha2($sql[$i]['fac_fecha_factura']).'</td>
							</tr>
							<tr>
								<td align="left">Fecha Pagado:</td>
								<td align="left">'.Utilidades::arreglo_fecha2($sql[$i]['fac_fecha_pago']).'</td>
							</tr>
						</table>';
	    		}
	    	}

			echo $html; 
	    }

	    public function grabar_editar_proveedor($idProveedor, $inputNombre, $inputRut, $inputTelefono, $inputMail){
			$grabar = $this->update_query("UPDATE 	proveedor
										   SET    	proveedor_nombre 	= '$inputNombre', 
										   			proveedor_rut		= '$inputRut', 
										   			proveedor_telefono	= '$inputTelefono', 
										   			proveedor_email		= '$inputMail'
										   WHERE    proveedor_id        = $idProveedor");

			if($grabar > 0){
				return TRUE;
			}else{
				return FALSE;
			}
		}

		public function metas_ventas($ano){
			$recursos = new Recursos();
	    	$html 	  = '<div class="col-xl-6">
	    				<h3><i class="bi bi-speedometer"></i>&nbsp;&nbsp; Metas de Ventas.</h3>
	    			 </div>
	    			 <div class="col-xl-6">
	    				<table width="100%">
	    					<tr>
	    						<td> </td>
	    						<td>'.Utilidades::select_agrupacion_anos('', 'ano', $ano).'</td>
	    						<td>
	    							<button class="btn btn-primary" onclick="buscar_metas_ventas()">
	    								<i class="bi bi-search"></i>
	    							</button>
	    						</td>
	    						<td>
	    							<button class="btn btn-success" type="button" href="'.controlador::$rutaAPP.'app/vistas/finanzas/php/nueva_meta.php" data-fancybox="" data-type="iframe" data-preload="true" data-width="100%" data-height="1200">
	    								<i class="bi bi-plus-square"></i>
	    							</button>
	    						</td>
	    					</tr>
	    				</table>
	    			 </div>
	    			 <hr class="mt-2 mb-3"/>
	    			 <div class="col-xl-15 animate__animated animate__fadeInLeft">
	    			 	'.$this->lista_metas_ventas($ano).'
	    			 </div>';

			return $html;
	    }

		public function lista_metas_ventas($ano){

			$desde      = $ano.'-01-01';
	    	$hasta		= $ano.'-12-31';

	    	$sql       = $this->selectQuery("SELECT * FROM metas_mensuales
										  	 WHERE    	   meta_estado = 1
										  	 AND           metas_mes BETWEEN '$desde' AND '$hasta'");

	    	$html = ' <table id="metas_ventas_list" class="table table-hover shadow-lg" style="width:100%">
			            <thead >
			              <tr class="table-info">
			                <th>Monto</th>
			                <th>Mes</th>
			                <th>Descripción</th>
			                <th>&nbsp;</th>
			              </tr>
			            </thead>
			            <tbody>';
			for ($i=0; $i < count($sql); $i++) { 
				$metas_mes = explode('-', $sql[$i]['metas_mes']);
				$html .= '<tr>
				          	<td>'.Utilidades::monto3($sql[$i]['meta_monto']).'</td>
				          	<td>'.Utilidades::mostrar_mes($metas_mes[1]).'</td>
				          	<td>'.$sql[$i]['meta_descripcion'].'</td>
				          	<td align="center">
				          		<i class="bi bi-x-square text-danger ver" onclick="anular_metas('.$sql[$i]['metas_id'].')"></i>
				          	</td>
				          </tr>';
			}

			$html .= ' </tbody>
					  </table>';

			return $html;
	    }

	    public function grabar_nueva_meta($meta_mes, $inputMonto, $inputDescripcion, $idUser){
	    	$ano    = Utilidades::fecha_ano();
	    	$hoy    = Utilidades::fecha_hoy();
	    	$mes    = $ano.'-'.$meta_mes.'-01';

			$grabar = $this->insert_query("INSERT INTO metas_mensuales(meta_monto, metas_mes, meta_descripcion, meta_creacion, meta_usuario, meta_estado)
										   VALUES('$inputMonto', '$mes', '$inputDescripcion', '$hoy', '$idUser', 1)");

			if($grabar > 0){
				return TRUE;
			}else{
				return FALSE;
			}
		}

		public function anular_metas($idMeta, $motivo_texto){
	    	$hoy    = Utilidades::fecha_hoy();

	    	$grabar = $this->update_query("UPDATE   metas_mensuales
	    								   SET 		meta_anulado 			= '$hoy',
	    								   			meta_descripcion_anulado= '$motivo_texto',
	    								   			meta_estado 			= 0
	    								   WHERE 	metas_id 				= $idMeta");

			if($grabar > 0){
				return TRUE;
			}else{
				return FALSE;
			}
		}

		// FACTURAS CLIENTES
		public function facturas_clientes($mes, $ano, $idServicio = 0){
			$recursos = new Recursos();

			$sql    	= $this->selectQuery("SELECT * FROM facturas_clientes
										  	  WHERE    		fac_estado 	!= 3 
										  	  AND           fac_servicio = $idServicio
										  	  ORDER BY      fac_fecha_pago DESC");

	    	$html 	  = '
	    				<div class="col-xl-6 text-warning">
	    				<h3 class="text-dark"><i class="fas fa-receipt text-warning"></i>&nbsp;&nbsp; Facturas Cliente.</h3>
	    			 </div>
	    			 <div class="col-xl-6">
	    				<table width="100%">
	    					<tr>';

	    	// if ($idServicio == 0) {
	    	// 	$html 	 .=    '<td>'.Utilidades::select_agrupacion_cards('', 'mes', $ano, $mes).'</td>
	    	// 					<td>'.Utilidades::select_agrupacion_anos('', 'ano', $ano).'</td>
	    	// 					<td>
	    	// 						<button class="btn btn-primary" onclick="buscar_facturas_clientes()">
	    	// 							<i class="bi bi-search"></i>
	    	// 						</button>
	    	// 					</td>';
	    	// }

	    	if ($idServicio > 0 && count($sql) == 0) {
	    		$html 	 .=    '<td>
	    							<button class="btn btn-success" type="button" href="'.controlador::$rutaAPP.'app/vistas/finanzas/php/nueva_factura_cliente.php?idServicio='.$idServicio.'" data-fancybox="" data-type="iframe" data-preload="true" data-width="100%" data-height="1200">
	    								<i class="bi bi-plus-square"></i>
	    							</button>
	    						</td>';
	    	}

	    	$html 	 .=    '
	    					</tr>
	    				</table>
	    			 </div>
	    			 <hr class="mt-2 mb-3"/>
	    			 <div class="col-xl-15 animate__animated animate__fadeInLeft">
	    			 	'.$this->listado_facturas_clientes($mes, $ano, $idServicio).'
	    			 </div>';

			return $html;
	    }

	    public function grabar_nueva_factura_cliente($inputNumero, $inputMonto, $inputFechaFactura, $inputEstadoFactura, $inputFechaPagoFactura, $inputDescripcion, $idServicio){
			$neto   = round($inputMonto/1.19);
			$iva    = ($inputMonto-$neto);
			$bruto  = $inputMonto;

			$grabar = $this->insert_query("INSERT INTO facturas_clientes(fac_folio, fac_servicio, fac_neto, fac_iva, fac_bruto, fac_fecha_factura, fac_fecha_pago, fac_comentario, fac_estado) VALUES('$inputNumero', '$idServicio', '$neto', '$iva', '$bruto', '$inputFechaFactura', '$inputFechaPagoFactura', '$inputDescripcion', '$inputEstadoFactura')");

			return $grabar;
		}

		public function grabar_insertar_documento($nombre, $idServicio){

			$grabar = $this->update_query("UPDATE facturas_clientes SET fac_documento = '$nombre' WHERE fac_servicio = $idServicio");

			return $grabar;
		}

		public function listado_facturas_clientes($mes, $ano, $idServicio){
	    	$recursos 	= new Recursos();
	    	$desde      = $ano.'-'.$mes.'-01';
	    	$ultimo_dia = date("t", strtotime($desde));
	    	$hasta  	= $ano.'-'.$mes.'-'.$ultimo_dia;
	    	$hoy        = Utilidades::fecha_hoy();
	    	$total      = 0;
	    	$script     = '';

	    	if($idServicio > 0){
	    		$script   .= " AND fac_servicio = $idServicio";
	    	}else{
	    		$script   .= " AND fac_fecha_factura  BETWEEN '$desde' AND '$hasta'";
	    	}

	    	$sql    	= $this->selectQuery("SELECT * FROM facturas_clientes
										  	  WHERE    		fac_estado != 3 
										  	  $script
										  	  ORDER BY      fac_fecha_pago DESC");

			$html = ' <table id="listado_facturas_proveedores" class="table shadow">
			            <thead >
			              	<tr class="table-info">
								<th>N&deg; Factura</th>
								<th>Fecha Pago</th>
								<th>Dias Restantes</th>
								<th>Monto Pago</th>
								<th>Estado</th>
								<th>&nbsp;</th>
							</tr>
			            </thead>
			            <tbody>';

			for ($i=0; $i < count($sql); $i++) {

				$dias    		  = Utilidades::contador_fecha($hoy, $sql[$i]['fac_fecha_pago']);
				$nombre_proveedor = $recursos->datos_proveedores($sql[$i]['fac_proveedor']);
				$factura_estado   = $recursos->estado_factura($sql[$i]['fac_estado']);

				if($sql[$i]['fac_estado'] == 2){
					$mostramos = '<span class="text-danger">'.$dias.'</span>';
				}else{
					$mostramos = '---';
				}

				$html .= '<tr>
				          	<td>'.$sql[$i]['fac_folio'].'</td>
				          	<td>'.Utilidades::arreglo_fecha2($sql[$i]['fac_fecha_pago']).'</td>
				          	<td>'.$mostramos.'</td>
				          	<td>'.Utilidades::monto3($sql[$i]['fac_bruto']).'</td>
				          	<td>'.$factura_estado[0]['tip_nombre'].'</td>
				          	<td align="center">
				          		<i class="far fa-eye text-primary ver" href="'.controlador::$rutaAPP.'app/vistas/finanzas/php/panel_facturas.php?idFactura='.$sql[$i]['fac_id'].'&tipo=2" data-fancybox="" data-type="iframe" data-preload="true" data-width="100%" data-height="1200"></i>
				          	</td>
				          </tr>';
				$total += $sql[$i]['fac_bruto'];
			}

			$html .= ' 
						<tr>
							<td colspan="2">&nbsp;</td>
							<th align="right">Total:</th>
							<th align="left">'.Utilidades::monto3($total).'</th>
							<td align="center">&nbsp;</td>
							<td align="center">&nbsp;</td>
						</tr>
						</tbody>
					  </table>';

			return $html;
	    }

	    public function info_facturas_clientes($idFactura){
	    	$recursos 	= new Recursos();
	    	$hoy        = Utilidades::fecha_hoy();
	    	$total      = 0;

	    	$sql    	= $this->selectQuery("SELECT * FROM facturas_clientes
										  	  WHERE    		fac_id = $idFactura");

			$html = '';

			for ($i=0; $i < count($sql); $i++) {

				if($sql[$i]['fac_estado'] == 2){
					$dias      = Utilidades::contador_fecha($hoy, $sql[$i]['fac_fecha_pago']);
					$mostramos = '	<tr>
							          	<th><b>Dias al Pago:</b></th>
							          	<td>'.$dias.'</td>
							        </tr>';
				}else{
					$mostramos = '';
				}

				$factura_estado   = $recursos->estado_factura($sql[$i]['fac_estado']);

				$html .= '<table id="listado_facturas_proveedores" class="table" style="width:100%">
							<tr>
					          	<th><b>N&deg; Factura:</b></th>
					          	<td>'.$sql[$i]['fac_folio'].'</td>
					        </tr>
					        <tr>
					          	<th><b>Monto:</b></th>
					          	<td>'.Utilidades::monto3($sql[$i]['fac_bruto']).'</td>
					        </tr>
					        <tr>
					          	<th><b>Fecha Factura:</b></th>
					          	<td>'.Utilidades::arreglo_fecha2($sql[$i]['fac_fecha_factura']).'</td>
					        </tr>
					        '.$mostramos.'
					        <tr>
					          	<th><b>Fecha Pago:</b></th>
					          	<td>'.Utilidades::arreglo_fecha2($sql[$i]['fac_fecha_pago']).'</td>
					        </tr>
					        <tr>
					          	<th><b>Estado Factura:</b></th>
					          	<td>'.$factura_estado[0]['tip_nombre'].'</td>
					        </tr>
					        <tr>
					          	<th colspan="2"><b>Descripción:</b></th>
					        </tr>
					        <tr>
					          	<td colspan="2">'.$sql[$i]['fac_comentario'].'</td>
					        </tr>
					        <tr>
					          	<td>
					          		<button type="button" id="grabar" class="btn btn-primary form-control shadow" onclick="traer_editar_factura_cliente('.$idFactura.')">Editar <i class="bi bi-save"></i></button>
					          	</td>
					          	<td>
					          		<button type="button" id="grabar" class="btn btn-danger form-control shadow" onclick="desactivar_factura_cliente('.$idFactura.')">Desactivar<i class="bi bi-save"></i></button>
					          	</td>
					        </tr> 
				          </table>';
			}

			return $html;
	    }

	    public function estado_factura_clientes($idFactura){
	    	$recursos  = new Recursos();
	    	$productos = new Productos();

	    	$sql       = $this->selectQuery("SELECT * FROM facturas_clientes
										  	 WHERE    		fac_id = $idFactura");

	    	for ($i=0; $i < count($sql); $i++) {

	    		if($sql[$i]['fac_estado'] == 2){
	    			$html   .= '<table id="listado_facturas_proveedores" class="table" style="width:100%">
							<tr>
								<td align="left">Total a Pagar:</td>
								<td align="left">'.Utilidades::monto3($sql[$i]['fac_bruto']).'</td>
							</tr>
							<tr>
								<td align="left">Fecha Pago:</td>
								<td align="left">'.Utilidades::arreglo_fecha2($sql[$i]['fac_fecha_pago']).'</td>
							</tr>
						</table>
						<table class="table" style="width:100%">
							<tr>
								<td align="center">
									<button type="button" id="grabar" class="btn btn-success form-control shadow" onclick="pagar_factura_cliente('.$idFactura.')">Efectuar Pago <i class="bi bi-save"></i></button>
								</td>
							</tr>
						</table>';
	    		}else{
	    			$html   .= '<table id="listado_facturas_proveedores" class="table" style="width:100%">
							<tr>
								<td align="left">Total Pagado:</td>
								<td align="left">'.Utilidades::monto3($sql[$i]['fac_bruto']).'</td>
							</tr>
							<tr>
								<td align="left">Fecha Pago:</td>
								<td align="left">'.Utilidades::arreglo_fecha2($sql[$i]['fac_fecha_factura']).'</td>
							</tr>
							<tr>
								<td align="left">Fecha Pagado:</td>
								<td align="left">'.Utilidades::arreglo_fecha2($sql[$i]['fac_fecha_pago']).'</td>
							</tr>
						</table>';
	    		}
	    	}

			echo $html; 
	    }

	     public function editar_factura_cliente($idFactura){
	    	$recursos  = new Recursos();
	    	$productos = new Productos();

	    	$sql       = $this->selectQuery("SELECT * FROM facturas_clientes
										  	 WHERE    		fac_id = $idFactura");

	    	for ($i=0; $i < count($sql); $i++) {

	    		if($sql[$i]['fac_estado'] == 1){
	    			$fecha_pagado = '<div class="col-lg-5 mb-2" id="mostrar_fecha_pago" style="display: none;">
					          <label for="inputFechaPagoFactura"><b>Fecha Pago Factura</b></label>
					            <span id="validador_curso"></span>
					            <input type="date" class="form-control shadow" id="inputFechaPagoFactura" value="'.$sql[$i]['fac_fecha_pago'].'">
					        </div>';
	    		}else{
	    			$fecha_pagado = '<div class="col-lg-5 mb-2" id="mostrar_fecha_pago">
					          <label for="inputFechaPagoFactura"><b>Fecha Pago Factura</b></label>
					            <span id="validador_curso"></span>
					            <input type="date" class="form-control shadow" id="inputFechaPagoFactura" value="'.$sql[$i]['fac_fecha_pago'].'">
					        </div>';
	    		}

	    		$html = '<div class="container mb-4">
					      <div class="row">
					        <div class="col-lg-5 mb-2">
					          <label for="inputNumero"><b>N&deg; Factura:</b></label>
					          <input type="number" class="form-control shadow" id="inputNumero" placeholder="Escribir N&deg; Factura" autocomplete="off" value="'.$sql[$i]['fac_folio'].'">
					        </div>
					        <div class="col-lg-5 mb-2">
					          <label for="inputMonto"><b>Monto:</b></label>
					          <input type="number" class="form-control shadow" id="inputMonto" placeholder="Escribir Monto Factura" autocomplete="off" value="'.$sql[$i]['fac_bruto'].'">
					        </div>
					        <div class="col-lg-5 mb-2">
					          <label for="inputFechaFactura"><b>Fecha Factura</b></label>
					            <span id="validador_curso"></span>
					            <input type="date" class="form-control shadow" id="inputFechaFactura"  value="'.$sql[$i]['fac_fecha_factura'].'">
					        </div>
					        <div class="col-lg-5 mb-2">
					          <label for="inputEstadoFactura"><b>Estado Factura</b></label>
					          '.$recursos->select_estado_factura('mostrar_fecha_pago', $sql[$i]['fac_estado']).'
					        </div>
					        '.$fecha_pagado.'
					        <div class="col-lg-15">
					          <label for="inputSucursal"><b>Descripción</b></label>
					            <span id="validador_curso"></span>
					            <textarea class="form-control shadow" id="inputDescripcion" rows="5">'.$sql[$i]['fac_comentario'].'</textarea>
					        </div>
					        <div class="col-lg-15 mb-2">
					          <label for="inputTipo">&nbsp;</label>
					          <button type="button" id="grabar" class="btn btn-primary form-control shadow" onclick="grabar_editar_factura_cliente('.$idFactura.')">Grabar <i class="bi bi-save"></i></button>
					        </div>
					      </div>
					    </div>';
	    	}

			echo $html; 
	    }

	    public function grabar_editar_factura_cliente($idFactura, $inputNumero, $inputMonto, $inputFechaFactura, $inputEstadoFactura, $inputFechaPagoFactura, $inputDescripcion){
			$neto   = round($inputMonto/1.19);
			$iva    = ($inputMonto-$neto);
			$bruto  = $inputMonto;

			$grabar = $this->update_query("UPDATE 	facturas_clientes 
										   SET 		fac_folio 			= '$inputNumero', 
										   			fac_neto 			= '$neto', 
										   			fac_iva 			= '$iva', 
										   			fac_bruto 			= '$bruto', 
										   			fac_fecha_factura  	= '$inputFechaFactura', 
										   			fac_fecha_pago 		= '$inputFechaPagoFactura', 
										   			fac_comentario 		= '$inputDescripcion',  
										   			fac_estado 			= '$inputEstadoFactura'
										   WHERE    fac_id = $idFactura");

			if($grabar > 0){
				return TRUE;
			}else{
				return FALSE;
			}
		}

		public function desactivar_factura_cliente($idFactura){
			$grabar = $this->update_query("UPDATE 	facturas_clientes 
										   SET 		fac_estado 	= 3
										   WHERE    fac_id 		= $idFactura");

			if($grabar > 0){
				return TRUE;
			}else{
				return FALSE;
			}
		}


		public function pagar_factura_cliente($idFactura){
			$grabar = $this->update_query("UPDATE 	facturas_clientes 
										   SET 		fac_estado 	= 1
										   WHERE    fac_id 		= $idFactura");

			if($grabar > 0){
				return TRUE;
			}else{
				return FALSE;
			}
		}


		public function servicios_con_factura(){
	    	$recursos = new Recursos();
			$html    = '<table width="100%" cellspacing="3" class="border p-2 mt-4 table table-sm table-striped table-responsive" id="servicios_pendientes1">
							<thead>
							<tr  >
								<th align="left">N&deg;</th>
								<th align="left">Codigo</th>
								<th align="left">Fecha</th>
								<th align="left">Vigencia</th>
								<th align="left">Cliente</th>
								<th align="left">Fletes</th>
								<th align="left">Total</th>
								<th align="left">&nbsp;</th>
							</tr>
							</thead>
							<tbody>';

			$sql    = $this->selectQuery("SELECT * FROM facturas_clientes 
										  LEFT JOIN 	servicios
										  ON  			servicios.serv_id 				= facturas_clientes.fac_servicio 
					   					  WHERE    		servicios.serv_estado 			= 1
					   					  AND           facturas_clientes.fac_estado    != 3
					   					  ORDER BY 		servicios.serv_id DESC");
			$j=1;
			for ($i=0; $i < count($sql); $i++) {
				//calulo progreso
				$dias_obra   		= 0;
				$dias_espera 		= 0;

				$nombre_cliente 	= $recursos->datos_clientes_servicio($sql[$i]['serv_cliente']);
				$datos_flete    	= $recursos->datos_fletes($sql[$i]['serv_id']);
				$monto_servicio 	= $recursos->datos_fletes_monto($sql[$i]['serv_id']);				
				$monto_traslados  	= $recursos->datos_traslados_monto($sql[$i]['serv_id']);
				$monto_arriendos  	= $recursos->datos_arriendos_monto($sql[$i]['serv_id']);

				$html .= '

							<tr  >
								<td align="left">'.$j++.'</td>
								<td align="left">'.$sql[$i]['serv_codigo'].'</td>
								<td align="left">'.Utilidades::arreglo_fecha2($sql[$i]['serv_fecha_inicio']).'</td>
								<td align="left">'.Utilidades::arreglo_fecha2($sql[$i]['serv_fecha_termino']).'</td>
								<td align="left">'.$nombre_cliente[0]['cli_nombre'].'</td>
								<td align="left">'.count($datos_flete).'</td>
								<td align="left">'.Utilidades::monto($monto_servicio+$monto_traslados+$monto_arriendos).'</td>
								<td align="left">
									<div class="col mt-1 p-2 d-flex justify-content-center"> <span class="far fa-eye text-primary cursor" href="'.controlador::$rutaAPP.'app/vistas/centro_costo/php/panel_servicios.php?idServicio='.$sql[$i]['serv_id'].'" data-fancybox data-type="iframe" data-preload="true" data-width="100%" data-height="1300"></span></div>
									<div class="col mt-1 p-2 d-flex justify-content-center"><span class="fas fa-file-pdf text-danger cursor" href="'.controlador::$rutaAPP.'app/vistas/centro_costo/php/cotizacion_servicio.php?idServicio='.$sql[$i]['serv_id'].'" data-fancybox data-type="iframe" data-preload="true" data-width="1200" data-height="800"></span></div>
                                    <div class="col mt-1 p-2 d-flex justify-content-center"><span class="fas fa-file-excel text-success cursor" onclick="obtener_informe('.$sql[$i]['serv_id'].')"></span></div>
								</td>
							</tr>';
			}

			$html .= '</tbody>
	    			</table>';

			return $html;
		}

		public function servicios_sin_factura(){
	    	$recursos = new Recursos();
			$html    = '<table width="100%" cellspacing="3" class="border p-2 mt-4 table table-sm table-striped table-responsive" id="servicios_pendientes2">
							<thead>
							<tr  >
								<th align="left">N&deg;</th>
								<th align="left">Codigo</th>
								<th align="left">Fecha</th>
								<th align="left">Vigencia</th>
								<th align="left">Cliente</th>
								<th align="left">Fletes</th>
								<th align="left">Total</th>
								<th align="left">&nbsp;</th>
							</tr>
							</thead>
							<tbody>';

			$sql    = $this->selectQuery("	SELECT *
											FROM 		servicios
											LEFT JOIN 	facturas_clientes ON servicios.serv_id = facturas_clientes.fac_servicio
											WHERE 		facturas_clientes.fac_servicio IS NULL
											AND 		servicios.serv_estado in(1,2)
											ORDER BY 	servicios.serv_id DESC;");
			$j=1;
			for ($i=0; $i < count($sql); $i++) {
				//calulo progreso
				$dias_obra   		= 0;
				$dias_espera 		= 0;

				$nombre_cliente 	= $recursos->datos_clientes_servicio($sql[$i]['serv_cliente']);
				$datos_flete    	= $recursos->datos_fletes($sql[$i]['serv_id']);
				$monto_servicio 	= $recursos->datos_fletes_monto($sql[$i]['serv_id']);				
				$monto_traslados  	= $recursos->datos_traslados_monto($sql[$i]['serv_id']);
				$monto_arriendos  	= $recursos->datos_arriendos_monto($sql[$i]['serv_id']);

				$html .= '

							<tr  >
								<td align="left">'.$j++.'</td>
								<td align="left">'.$sql[$i]['serv_codigo'].'</td>
								<td align="left">'.Utilidades::arreglo_fecha2($sql[$i]['serv_fecha_inicio']).'</td>
								<td align="left">'.Utilidades::arreglo_fecha2($sql[$i]['serv_fecha_termino']).'</td>
								<td align="left">'.$nombre_cliente[0]['cli_nombre'].'</td>
								<td align="left">'.count($datos_flete).'</td>
								<td align="left">'.Utilidades::monto($monto_servicio+$monto_traslados+$monto_arriendos).'</td>
								<td align="left">
									<div class="col mt-1 p-2 d-flex justify-content-center"> <span class="far fa-eye text-primary cursor" href="'.controlador::$rutaAPP.'app/vistas/centro_costo/php/panel_servicios.php?idServicio='.$sql[$i]['serv_id'].'" data-fancybox data-type="iframe" data-preload="true" data-width="100%" data-height="1300"></span></div>
									<div class="col mt-1 p-2 d-flex justify-content-center"><span class="fas fa-file-pdf text-danger cursor" href="'.controlador::$rutaAPP.'app/vistas/centro_costo/php/cotizacion_servicio.php?idServicio='.$sql[$i]['serv_id'].'" data-fancybox data-type="iframe" data-preload="true" data-width="1200" data-height="800"></span></div>
                                    <div class="col mt-1 p-2 d-flex justify-content-center"><span class="fas fa-file-excel text-success cursor" onclick="obtener_informe('.$sql[$i]['serv_id'].')"></span></div>
								</td>
							</tr>';
			}

			$html .= '</tbody>
	    			</table>';

			return $html;
		}

	   /**  FIN FINANZAS   **/

	} // END CLASS
?>