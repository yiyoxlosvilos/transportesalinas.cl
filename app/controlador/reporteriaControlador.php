<?php
	require_once __dir__."/../modelo/obtener_datos.php";
	require_once __dir__."/../controlador/utilidadesControlador.php";
	require_once __dir__."/../controlador/recursosControlador.php";
	require_once __dir__."/../controlador/centroCostoControlador.php";


	class Reporteria extends GetDatos {
		public function __construct(){
			parent::__construct();
	    }

	    public function traer_flujo_diario($mes, $ano, $cant_dias){
	    	$neto_acumulado = 0;
	    	$html = '<div class="col-xl-6">
	    				<h3><i class="bi bi-cash"></i>&nbsp;&nbsp;Fujo de caja, Diario.</h3>
	    			 </div>
	    			 <div class="col-xl-6">
	    				<table width="100%">
	    					<tr>
	    						<td>'.Utilidades::select_agrupacion_cards('', 'mes', $ano, $mes).'</td>
	    						<td>'.Utilidades::select_agrupacion_anos('', 'ano', $ano).'</td>
	    						<td><button class="btn btn-primary" onclick="buscar_flujo_diario()"><i class="bi bi-search"></i></button></td>
	    					</tr>
	    				</table>
	    			 </div>
	    			 <hr class="mt-2 mb-3"/>
	    			 <table align="center" cellspacing="5" cellpadding="5" class="shadow animate__animated animate__fadeInLeft">
						<tr>
							<th align="left" class="text-primary"><i class="bi bi-graph-up-arrow"></i> Ingresos</th>';

			for ($i=1; $i <= $cant_dias; $i++) {
				$html .= '<th align="center" class="plomo">'.$i.'</th>';
			}

			$html .= '  </tr>';

			$html .= $this->traer_ingresos_diarios($mes, $ano, $cant_dias);

			$html .= '  </tr>';
			$html .= '  <td colspan="'.($cant_dias+1).'">&nbsp;</td>';
			$html .= '  </tr>';

			$html .= '  <tr>
							<th align="left" class="text-danger"><i class="bi bi-graph-down-arrow"></i> Egresos</th>';

			for ($i=1; $i <= $cant_dias; $i++) {
				$html .= '<th align="center" class="plomo">'.$i.'</th>';
			}

			$html .= '  </tr>';

			$html .= $this->traer_egresos_diarios($mes, $ano, $cant_dias);

			$html .= '  </tr>';
			$html .= '  <td colspan="'.($cant_dias+1).'">&nbsp;</td>';
			$html .= '  </tr>';

			$html .= '  <tr>
							<th align="left" class="text-info"><i class="bi bi-cash-stack"></i> Saldo Neto</th>';

			for ($i=1; $i <= $cant_dias; $i++) {
				$fecha_neto  	 = $ano.'-'.$mes.'-'.$i;
				$saldo_neto 	 = $this->montos_ventas_categorias(0, $fecha_neto);
				$gastos      	 = $this->montos_egresos_categorias(0, $fecha_neto);
				$dctos_clientes  = $this->dsctos_ventas($fecha_neto);
				$sueldos 		 = $this->montos_sueldos($fecha_neto);
				$iva_neto        = $this->montos_iva_ventas($fecha_neto);
				$proveedores     = $this->facturas_proveedores_diario($fecha_neto);
				$descuentos      = ($gastos+$sueldos+$dctos_clientes+$proveedores);

				if($iva_neto < 0){
	    			$iva_mostrar = ($iva_neto*-1);
	    		}else{
	    			$iva_mostrar = $iva_neto;
	    		}

				$total_neto 	 = (($saldo_neto+$iva_mostrar)-$descuentos);
				$neto_acumulado += $total_neto;

				if($total_neto > 0){
					$html .= '<th align="center" class="plomo text-info">'.Utilidades::monto3($total_neto).'</th>';
				}elseif($total_neto == 0){
					$html .= '<th align="center" class="plomo text-dark">'.Utilidades::monto3($total_neto).'</th>';
				}else{
					$html .= '<th align="center" class="plomo text-danger">'.Utilidades::monto3($total_neto*-1).'</th>';
				}
				
			}

			$html .= '  </tr>';

			$html .= '  <tr>
							<th align="left" class="text-success"><i class="bi bi-wallet2"></i> Saldo Acumulado</th>';

			for ($i=1; $i <= $cant_dias; $i++) {

				$fecha_acumulado 	 = $ano.'-'.$mes.'-'.$i;
				$saldo_acumulado 	 = $this->montos_ventas_categorias(0, $fecha_acumulado);
				$descuentos_acum 	 = $this->montos_egresos_categorias(0, $fecha_acumulado);
				$iva_acumulado       = $this->montos_iva_ventas($fecha_acumulado);
				$proveedores         = $this->facturas_proveedores_diario($fecha_acumulado);

				if($iva_acumulado < 0){
	    			$iva_mostrar 	 = ($iva_acumulado*-1);
	    		}else{
	    			$iva_mostrar 	 = $iva_acumulado;
	    		}

	    		$total_acumulado     = (($saldo_acumulado+$iva_mostrar)-($descuentos_acum+$proveedores));

				$suma 		 	 	 = $total_acumulado;
				$resto[$i]       	 = $total_acumulado+$resto[$i-1];

				if($resto[$i] > 0){
					$html .= '<th align="center" class="plomo text-success">'.Utilidades::monto3($resto[$i]).'</th>';
				}elseif($resto[$i] == 0){
					$html .= '<th align="center" class="plomo text-dark">'.Utilidades::monto3($resto[$i]).'</th>';
				}else{
					$html .= '<th align="center" class="plomo text-danger">'.Utilidades::monto3($resto[$i]*-1).'</th>';
				}
			}

			$html .= '  </tr>';

			$html .= '</table>';

			return $html;
	    }

	    public function traer_ingresos_diarios($mes, $ano, $cant_dias){
	    	$html = '';

	    	$html .= '<tr class="cambiazo">';
	    	$html .= '	<td align="left" class="text-dark plomo font-size-15">Servicios</td>';
	    	$html .= $this->ingresos_categorias(0, $mes, $ano, $cant_dias);
	    	$html .= '</tr>';

	    	$html .= '<tr class="cambiazo">';
	    	$html .= '	<td align="left" class="text-dark plomo font-size-14">IVA Compra</td>';

	    	for ($i=1; $i <= $cant_dias; $i++) { 
	    		$fecha= $ano.'-'.$mes.'-'.$i;
	    		$iva  = $this->montos_iva_ventas($fecha);

	    		if($iva < 0){
	    			$iva_mostrar = ($iva*-1);
	    		}else{
	    			$iva_mostrar = $iva;
	    		}

	    		if ($iva_mostrar > 0) {
	    			$html .= '	<td class="font-size-13 text-primary">'.Utilidades::monto3($iva_mostrar).'</td>';
	    		}else{
	    			$html .= '	<td class="font-size-13">'.Utilidades::monto3($iva_mostrar).'</td>';
	    		}
	    	}

	    	$html .= '</tr>';

	    	$html .= '<tr>';
	    	$html .= '	<th align="left" class="text-primary plomo font-size-15">Total Ingresos</th>';

	    	for ($i=1; $i <= $cant_dias; $i++) { 
	    		$fecha_total 	= $ano.'-'.$mes.'-'.$i;
	    		$iva         	= $this->montos_iva_ventas($fecha_total);
	    		$total_ingresos = $this->montos_ventas_categorias(0, $fecha_total);

	    		if($iva < 0){
	    			$iva_mostrar = ($iva*-1);
	    		}else{
	    			$iva_mostrar = $iva;
	    		}

	    		if($total_ingresos > 0){
	    			$html .= '	<th class="font-size-14 plomo text-primary">'.Utilidades::monto3($total_ingresos+$iva_mostrar).'</th>';
	    		}else{
	    			$html .= '	<th class="font-size-14 plomo text-dark">'.Utilidades::monto3($total_ingresos+$iva_mostrar).'</th>';
	    		}
	    	}

	    	$html .= '</tr>';

	    	return $html;
	    }

	    public function montos_iva_ventas($fecha){
	    	$data  = 0;
	    	$sql  = $this->selectQuery("SELECT 		SUM(c_cli_monto) suma
										FROM 		caja_cliente
										WHERE 		c_cli_fecha   		  = '$fecha'
		    		   					AND    		c_cli_estado    	  = 2
		    		   					AND         c_cli_tipoMovimiento  = 10
										GROUP BY 	c_cli_fecha");

	    	for ($i=0; $i < count($sql); $i++) { 
				$data += $sql[$i]['suma'];
			}

			return $data;
	    }

	    public function montos_ventas_categorias($cate_id, $fecha){
	    	$data = 0;

	    	/*if($cate_id > 0){
	    		$script = " AND prod_cli_categoria = $cate_id";
	    	}else{
	    		$script = "";
	    	}*/

	    	$sql  = $this->selectQuery("SELECT 		SUM(caja_cliente.c_cli_monto) suma
										FROM 		product_cliente
										LEFT JOIN 	caja_cliente
										ON   		caja_cliente.c_cli_prod_cliente    = product_cliente.prod_cli_id
										WHERE 		caja_cliente.c_cli_fecha   	       = '$fecha'
										$script
										AND    		caja_cliente.c_cli_tipoMovimiento  IN(3, 4)
		    		   					AND    		caja_cliente.c_cli_estado          IN(1, 2)
										GROUP BY 	caja_cliente.c_cli_prod_cliente");

	    	for ($i=0; $i < count($sql); $i++) { 
				$data += $sql[$i]['suma'];
			}

			return $data;
	    }

	    public function montos_egresos_categorias($tipoGasto, $fecha){
	    	$data = 0;

	    	if($tipoGasto > 0){
	    		$script = " AND gas_categoria = $tipoGasto";
	    	}else{
	    		$script = "";
	    	}

	    	$sql  = $this->selectQuery("SELECT SUM(gas_monto) suma
	    		   						FROM   gastos_empresa
	    		   						WHERE  gas_fecha   	   = '$fecha'
	    		   						 $script
	    		   						AND    gas_estado      = 1");

	    	for ($i=0; $i < count($sql); $i++) { 
				$data += $sql[$i]['suma'];
			}

			return $data;
	    }

	    public function ingresos_categorias($cate_id, $mes, $ano, $cant_dias){
	    	$html = '';

	    	for ($i=1; $i <= $cant_dias; $i++) {
	    		$fecha  = $ano.'-'.$mes.'-'.$i;
	    		$ventas = $this->montos_ventas_categorias($cate_id, $fecha);

	    		if ($ventas > 0) {
	    			$html .= '	<td class="font-size-13 text-primary">'.Utilidades::monto3($ventas).'</td>';
	    		}else{
	    			$html .= '	<td class="font-size-13">'.Utilidades::monto3($ventas).'</td>';
	    		}
	    	}

	    	return $html;
	    }

	    public function egresos_gastos($cate_id, $mes, $ano, $cant_dias){
	    	$html = '';

	    	for ($i=1; $i <= $cant_dias; $i++) {
	    		$fecha  = $ano.'-'.$mes.'-'.$i;
	    		$ventas = $this->montos_egresos_categorias($cate_id, $fecha);

	    		if ($ventas > 0) {
	    			$html .= '	<td class="font-size-13 text-danger">'.Utilidades::monto3($ventas).'</td>';
	    		}else{
	    			$html .= '	<td class="font-size-13">'.Utilidades::monto3($ventas).'</td>';
	    		}
	    	}

	    	return $html;
	    }

	    public function dsctos_ventas($fecha){
	    	$data = 0;

	    	$sql  = $this->selectQuery("SELECT SUM(ven_cli_montoInicial-ven_cli_montoReal) suma
			    	   					FROM   ventascliente
			    	   					WHERE  ven_cli_fecha   = '$fecha'
			    	   					AND    ven_cli_estado  = 1");

	    	for ($i=0; $i < count($sql); $i++) { 
				$data += $sql[$i]['suma'];
			}

			return $data;
		}

		public function montos_sueldos($fecha){
	    	$data = 0;

	    	$sql  = $this->selectQuery("SELECT SUM(liquid_tot_haber) suma
		    	   						FROM   liquidaciones_sueldo
		    	   						WHERE  liquid_fecha    = '$fecha'
		    	   						AND    liquid_estado   = 1");

	    	for ($i=0; $i < count($sql); $i++) { 
				$data += $sql[$i]['suma'];
			}

			return $data;
		}

	    public function traer_egresos_diarios($mes, $ano, $cant_dias){
	    	$html = '';

	    	$sql  = $this->selectQuery("SELECT tpgas_id, tpgas_nombre 
					      				FROM   tipo_gastos 
					      				WHERE  tpgas_estado = 1");

	    	for ($i=0; $i < count($sql); $i++) { 
	    		$html .= '<tr class="cambiazo">';
	    		$html .= '	<td align="left" class="text-dark plomo font-size-15">'.Utilidades::matar_espacio(ucfirst($sql[$i]['tpgas_nombre'])).'</td>';
	    		$html .= $this->egresos_gastos($sql[$i]['tpgas_id'], $mes, $ano, $cant_dias);
	    		$html .= '</tr>';
	    	}

	    	$html .= '<tr class="cambiazo">';
	    	$html .= '	<td align="left" class="text-dark plomo font-size-14">Dctos Clientes</td>';

	    	for ($i=1; $i <= $cant_dias; $i++) { 
	    		$fecha  = $ano.'-'.$mes.'-'.$i;
	    		$otros  = $this->dsctos_ventas($fecha);

	    		if ($otros > 0) {
	    			$html .= '	<td class="font-size-13 text-danger">'.Utilidades::monto3($otros).'</td>';
	    		}else{
	    			$html .= '	<td class="font-size-13">'.Utilidades::monto3($otros).'</td>';
	    		}
	    	}

	    	$html .= '</tr>';

	    	$html .= '<tr class="cambiazo">';
	    	$html .= '	<td align="left" class="text-dark plomo font-size-14">Sueldos</td>';

	    	for ($i=1; $i <= $cant_dias; $i++) { 
	    		$fecha   = $ano.'-'.$mes.'-'.$i;
	    		$suedos  = $this->montos_sueldos($fecha);

	    		if ($otros > 0) {
	    			$html .= '	<td class="font-size-13 text-danger">'.Utilidades::monto3($suedos).'</td>';
	    		}else{
	    			$html .= '	<td class="font-size-13">'.Utilidades::monto3($suedos).'</td>';
	    		}
	    	}

	    	$html .= '</tr>';

	    	$html .= '<tr class="cambiazo">';
	    	$html .= '	<td align="left" class="text-dark plomo font-size-14">Facturas Provedores</td>';

	    	for ($i=1; $i <= $cant_dias; $i++) { 
	    		$fecha   = $ano.'-'.$mes.'-'.$i;
	    		$proveedores  = $this->facturas_proveedores_diario($fecha);

	    		if ($proveedores > 0) {
	    			$html .= '	<td class="font-size-13 text-danger">'.Utilidades::monto3($proveedores).'</td>';
	    		}else{
	    			$html .= '	<td class="font-size-13">'.Utilidades::monto3($proveedores).'</td>';
	    		}
	    	}

	    	$html .= '</tr>';

	    	$html .= '<tr>';
	    	$html .= '	<th align="left" class="text-danger plomo font-size-15">Total Egresos</th>';

	    	for ($i=1; $i <= $cant_dias; $i++) { 
	    		$fecha_total   = $ano.'-'.$mes.'-'.$i;
	    		$egreso_dctos  = $this->dsctos_ventas($fecha_total);
				$egreso_sueldo = $this->montos_sueldos($fecha_total);
	    		$egreso_gastos = $this->montos_egresos_categorias(0, $fecha_total);
	    		$provee_gastos = $this->facturas_proveedores_diario($fecha_total);
	    		$egreso        = ($egreso_dctos+$egreso_sueldo+$egreso_gastos+$provee_gastos);

	    		if($egreso > 0){
	    			$html .= '	<th class="font-size-14 plomo text-danger">'.Utilidades::monto3($egreso).'</th>';
	    		}else{
	    			$html .= '	<th class="font-size-14 plomo text-dark">'.Utilidades::monto3($egreso).'</th>';
	    		}

	    		
	    	}

	    	$html .= '</tr>';

	    	return $html;
	    }

	    public function traer_flujo_mensual($mes, $ano, $cant_dias){
	    	$neto_acumulado = 0;
	    	$html = '<div class="col-xl-6">
	    				<h3><i class="bi bi-cash-coin"></i>&nbsp;&nbsp;Fujo de caja, Mensual.</h3>
	    			 </div>
	    			 <div class="col-xl-6">
	    				<table width="100%">
	    					<tr>
	    						<td>&nbsp;</td>
	    						<td>'.Utilidades::select_agrupacion_anos('', 'ano', $ano).'</td>
	    						<td><button class="btn btn-primary" onclick="buscar_flujo_mensual()"><i class="bi bi-search"></i></button></td>
	    					</tr>
	    				</table>
	    			 </div>
	    			 <hr class="mt-2 mb-3"/>
	    			 <table align="center" cellspacing="5" cellpadding="5" class="shadow animate__animated animate__fadeInLeft">
						<tr>
							<th align="left" class="text-primary"><i class="bi bi-graph-up-arrow"></i> Ingresos</th>';

			for ($i=1; $i <= $cant_dias; $i++) {
				$html .= '<th align="center" class="plomo">'.Utilidades::mostrar_mes($i).'</th>';
			}

			$html .= '  </tr>';

			$html .= $this->traer_ingresos_mensual($ano, $cant_dias);

			$html .= '  </tr>';
			$html .= '  <td colspan="'.($cant_dias+1).'">&nbsp;</td>';
			$html .= '  </tr>';

			$html .= '  <tr>
							<th align="left" class="text-danger"><i class="bi bi-graph-down-arrow"></i> Egresos</th>';

			for ($i=1; $i <= $cant_dias; $i++) {
				$html .= '<th align="center" class="plomo">'.Utilidades::mostrar_mes($i).'</th>';
			}

			$html .= '  </tr>';

			$html .= $this->traer_egresos_mensual($ano, $cant_dias);

			$html .= '  </tr>';
			$html .= '  <td colspan="'.($cant_dias+1).'">&nbsp;</td>';
			$html .= '  </tr>';

			$html .= '  <tr>
							<th align="left" class="text-info"><i class="bi bi-cash-stack"></i> Saldo Neto</th>';

			for ($i=1; $i <= $cant_dias; $i++) {

				$saldo_neto 	 = $this->montos_ventas_categorias_mensual(0, $i, $ano);
				$iva_neto        = $this->montos_iva_ventas_mensual($i, $ano);
				$gastos  		 = $this->montos_egresos_categorias_mensual(0, $i, $ano);
	    		$otros   		 = $this->dsctos_ventas_mensual($i, $ano);
				$suedos  		 = $this->montos_sueldos_mensual($i, $ano);
				$proveedores     = $this->facturas_proveedores_mensual($i, $ano);

				$descuentos  	 = ($gastos+$otros+$suedos+$proveedores);

				if($iva_neto < 0){
	    			$iva_mostrar = ($iva_neto*-1);
	    		}else{
	    			$iva_mostrar = $iva_neto;
	    		}

				$total_neto 	 = (($saldo_neto+$iva_mostrar)-$descuentos);
				$neto_acumulado += $total_neto;

				if($total_neto > 0){
					$html .= '<th align="center" class="plomo text-info">'.Utilidades::monto3($total_neto).'</th>';
				}elseif($total_neto == 0){
					$html .= '<th align="center" class="plomo text-dark">'.Utilidades::monto3($total_neto).'</th>';
				}else{
					$html .= '<th align="center" class="plomo text-danger">'.Utilidades::monto3($total_neto*-1).'</th>';
				}
				
			}

			$html .= '  </tr>';

			$html .= '  <tr>
							<th align="left" class="text-success"><i class="bi bi-wallet2"></i> Saldo Acumulado</th>';

			for ($i=1; $i <= $cant_dias; $i++) {

				$saldo_acumulado 	 = $this->montos_ventas_categorias_mensual(0, $i, $ano);
				$iva_acumulado       = $this->montos_iva_ventas_mensual($i, $ano);

				$gastos  			 = $this->montos_egresos_categorias_mensual(0, $i, $ano);
	    		$otros   			 = $this->dsctos_ventas_mensual($i, $ano);
				$suedos  			 = $this->montos_sueldos_mensual($i, $ano);
				$proveedores     	 = $this->facturas_proveedores_mensual($i, $ano);

				$descuentos_acum  	 = ($gastos+$otros+$suedos+$proveedores);

				if($iva_acumulado < 0){
	    			$iva_mostrar 	 = ($iva_acumulado*-1);
	    		}else{
	    			$iva_mostrar 	 = $iva_acumulado;
	    		}

	    		$total_acumulado     = (($saldo_acumulado+$iva_mostrar)-$descuentos_acum);

				$suma 		 	 	 = $total_acumulado;
				$resto[$i]       	 = $total_acumulado+$resto[$i-1];

				if($resto[$i] > 0){
					$html .= '<th align="center" class="plomo text-success">'.Utilidades::monto3($resto[$i]).'</th>';
				}elseif($resto[$i] == 0){
					$html .= '<th align="center" class="plomo text-dark">'.Utilidades::monto3($resto[$i]).'</th>';
				}else{
					$html .= '<th align="center" class="plomo text-danger">'.Utilidades::monto3($resto[$i]*-1).'</th>';
				}
			}

			$html .= '  </tr>';

			$html .= '</table>';

			return $html;
	    }

	    public function traer_ingresos_mensual($ano, $cant_dias){
	    	$html = '';

	    	$html .= '<tr class="cambiazo">';
	    	$html .= '	<td align="left" class="text-dark plomo font-size-15">Servicios</td>';
	    	$html .= $this->ingresos_categorias_mensual(0, $ano, $cant_dias);
	    	$html .= '</tr>';

	    	$html .= '<tr class="cambiazo">';
	    	$html .= '	<td align="left" class="text-dark plomo font-size-14">IVA</td>';

	    	for ($i=1; $i <= $cant_dias; $i++) { 
	    		$iva  = $this->montos_iva_ventas_mensual($i, $ano);

	    		if($iva < 0){
	    			$iva_mostrar = ($iva*-1);
	    		}else{
	    			$iva_mostrar = $iva;
	    		}

	    		if ($iva_mostrar > 0) {
	    			$html .= '	<td class="font-size-13 text-primary">'.Utilidades::monto3($iva_mostrar).'</td>';
	    		}else{
	    			$html .= '	<td class="font-size-13">'.Utilidades::monto3($iva_mostrar).'</td>';
	    		}
	    	}

	    	$html .= '</tr>';

	    	$html .= '<tr>';
	    	$html .= '	<th align="left" class="text-primary plomo font-size-15">Total Ingresos</th>';

	    	for ($i=1; $i <= $cant_dias; $i++) {
	    		$iva         	= $this->montos_iva_ventas_mensual($i, $ano);
	    		$total_ingresos = $this->montos_ventas_categorias_mensual(0, $i, $ano);

	    		if($iva < 0){
	    			$iva_mostrar = ($iva*-1);
	    		}else{
	    			$iva_mostrar = $iva;
	    		}

	    		if($total_ingresos > 0){
	    			$html .= '	<th class="font-size-14 plomo text-primary">'.Utilidades::monto3($total_ingresos+$iva_mostrar).'</th>';
	    		}else{
	    			$html .= '	<th class="font-size-14 plomo text-dark">'.Utilidades::monto3($total_ingresos+$iva_mostrar).'</th>';
	    		}
	    	}

	    	$html .= '</tr>';

	    	return $html;
	    }

	    public function ingresos_categorias_mensual($cate_id, $ano, $cant_dias){
	    	$html = '';

	    	for ($i=1; $i <= $cant_dias; $i++) {
	    		$ventas = $this->montos_ventas_categorias_mensual($cate_id, $i, $ano);

	    		if ($ventas > 0) {
	    			$html .= '	<td class="font-size-13 text-primary">'.Utilidades::monto3($ventas).'</td>';
	    		}else{
	    			$html .= '	<td class="font-size-13">'.Utilidades::monto3($ventas).'</td>';
	    		}
	    	}

	    	return $html;
	    }

	    public function montos_ventas_categorias_mensual($cate_id, $mes, $ano){
	    	$data 		= 0;
	    	$desde      = $ano.'-'.$mes.'-01';
	    	$ultimo_dia = date("t", strtotime($desde));
	    	$hasta  	= $ano.'-'.$mes.'-'.$ultimo_dia;

	    	if($cate_id > 0){
	    		$script = " AND prod_cli_categoria = $cate_id";
	    	}else{
	    		$script = "";
	    	}

	    	$sql  = $this->selectQuery("SELECT 		SUM(caja_cliente.c_cli_monto) suma
										FROM 		product_cliente
										LEFT JOIN 	caja_cliente
										ON   		caja_cliente.c_cli_prod_cliente    = product_cliente.prod_cli_id
										WHERE 		caja_cliente.c_cli_fecha   	       BETWEEN '$desde' AND '$hasta'
										$script
										AND    		caja_cliente.c_cli_tipoMovimiento  IN(3, 4)
		    		   					AND    		caja_cliente.c_cli_estado          IN(1, 2)
										GROUP BY 	caja_cliente.c_cli_prod_cliente");

	    	for ($i=0; $i < count($sql); $i++) { 
				$data += $sql[$i]['suma'];
			}

			return $data;
	    }

	    public function cantidad_ventas_categorias_mensual($cate_id, $mes, $ano){
	    	$data 		= 0;
	    	$desde      = $ano.'-'.$mes.'-01';
	    	$ultimo_dia = date("t", strtotime($desde));
	    	$hasta  	= $ano.'-'.$mes.'-'.$ultimo_dia;

	    	if($cate_id > 0){
	    		$script = " AND prod_cli_categoria = $cate_id";
	    	}else{
	    		$script = "";
	    	}

	    	$sql  = $this->selectQuery("SELECT 		caja_cliente.c_cli_id
										FROM 		product_cliente
										LEFT JOIN 	caja_cliente
										ON   		caja_cliente.c_cli_prod_cliente    = product_cliente.prod_cli_id
										WHERE 		caja_cliente.c_cli_fecha   	       BETWEEN '$desde' AND '$hasta'
										$script
										AND    		caja_cliente.c_cli_tipoMovimiento  = 3
		    		   					AND    		caja_cliente.c_cli_estado          = 2");

	    	for ($i=0; $i < count($sql); $i++) { 
				$data ++;
			}

			return $data;
	    }

	    public function montos_iva_ventas_mensual($mes, $ano){
	    	$data  		= 0;
	    	$desde      = $ano.'-'.$mes.'-01';
	    	$ultimo_dia = date("t", strtotime($desde));
	    	$hasta  	= $ano.'-'.$mes.'-'.$ultimo_dia;

	    	$sql  		= $this->selectQuery("SELECT 	SUM(c_cli_monto) suma
											  FROM 		caja_cliente
											  WHERE 	c_cli_fecha   		  BETWEEN '$desde' AND '$hasta'
		    		   						  AND    	c_cli_estado    	  = 2
		    		   						  AND       c_cli_tipoMovimiento  = 10
											  GROUP BY 	c_cli_fecha");

	    	for ($i=0; $i < count($sql); $i++) { 
				$data += $sql[$i]['suma'];
			}

			return $data;
	    }

	    public function traer_egresos_mensual($ano, $cant_dias){
	    	$html = '';

	    	$sql  = $this->selectQuery("SELECT tpgas_id, tpgas_nombre 
					      				FROM   tipo_gastos 
					      				WHERE  tpgas_estado = 1");

	    	for ($i=0; $i < count($sql); $i++) { 
	    		$html .= '<tr class="cambiazo">';
	    		$html .= '	<td align="left" class="text-dark plomo font-size-15">'.Utilidades::matar_espacio(ucfirst($sql[$i]['tpgas_nombre'])).'</td>';
	    		$html .= $this->egresos_gastos_mensual($sql[$i]['tpgas_id'], $ano, $cant_dias);
	    		$html .= '</tr>';
	    	}

	    	$html .= '<tr class="cambiazo">';
	    	$html .= '	<td align="left" class="text-dark plomo font-size-14">Dctos Clientes</td>';

	    	for ($i=1; $i <= $cant_dias; $i++) { 
	    		$otros  = $this->dsctos_ventas_mensual($i, $ano);

	    		if ($otros > 0) {
	    			$html .= '	<td class="font-size-13 text-danger">'.Utilidades::monto3($otros).'</td>';
	    		}else{
	    			$html .= '	<td class="font-size-13">'.Utilidades::monto3($otros).'</td>';
	    		}
	    	}

	    	$html .= '</tr>';

	    	$html .= '<tr class="cambiazo">';
	    	$html .= '	<td align="left" class="text-dark plomo font-size-14">Sueldos</td>';

	    	for ($i=1; $i <= $cant_dias; $i++) { 
	    		$suedos  = $this->montos_sueldos_mensual($i, $ano);

	    		if ($otros > 0) {
	    			$html .= '	<td class="font-size-13 text-danger">'.Utilidades::monto3($suedos).'</td>';
	    		}else{
	    			$html .= '	<td class="font-size-13">'.Utilidades::monto3($suedos).'</td>';
	    		}
	    	}

	    	$html .= '</tr>';

	    	$html .= '<tr class="cambiazo">';
	    	$html .= '	<td align="left" class="text-dark plomo font-size-14">Facturas Provedores</td>';

	    	for ($i=1; $i <= $cant_dias; $i++) { 
	    		$proveedores = $this->facturas_proveedores_mensual($i, $ano);

	    		if ($proveedores > 0) {
	    			$html .= '	<td class="font-size-13 text-danger">'.Utilidades::monto3($proveedores).'</td>';
	    		}else{
	    			$html .= '	<td class="font-size-13">'.Utilidades::monto3($proveedores).'</td>';
	    		}
	    	}

	    	$html .= '</tr>';

	    	$html .= '<tr>';
	    	$html .= '	<th align="left" class="text-danger plomo font-size-15">Total Egresos</th>';

	    	for ($i=1; $i <= $cant_dias; $i++) { 
	    		$gastos  = $this->montos_egresos_categorias_mensual(0, $i, $ano);
	    		$otros   = $this->dsctos_ventas_mensual($i, $ano);
				$suedos  = $this->montos_sueldos_mensual($i, $ano);
				$proveedores = $this->facturas_proveedores_mensual($i, $ano);

				$egreso  = ($gastos+$otros+$suedos+$proveedores);

	    		if($egreso > 0){
	    			$html .= '	<th class="font-size-14 plomo text-danger">'.Utilidades::monto3($egreso).'</th>';
	    		}else{
	    			$html .= '	<th class="font-size-14 plomo text-dark">'.Utilidades::monto3($egreso).'</th>';
	    		}

	    		
	    	}

	    	$html .= '</tr>';

	    	return $html;
	    }


	    public function egresos_gastos_mensual($cate_id, $ano, $cant_dias){
	    	$html = '';

	    	for ($i=1; $i <= $cant_dias; $i++) {

	    		$ventas = $this->montos_egresos_categorias_mensual($cate_id, $i, $ano);

	    		if ($ventas > 0) {
	    			$html .= '	<td class="font-size-13 text-danger">'.Utilidades::monto3($ventas).'</td>';
	    		}else{
	    			$html .= '	<td class="font-size-13">'.Utilidades::monto3($ventas).'</td>';
	    		}
	    	}

	    	return $html;
	    }

	    public function montos_egresos_categorias_mensual($tipoGasto, $mes, $ano){
	    	$data 		= 0;
	    	$desde      = $ano.'-'.$mes.'-01';
	    	$ultimo_dia = date("t", strtotime($desde));
	    	$hasta  	= $ano.'-'.$mes.'-'.$ultimo_dia;

	    	if($tipoGasto > 0){
	    		$script = " AND gas_categoria = $tipoGasto";
	    	}else{
	    		$script = "";
	    	}

	    	$sql  = $this->selectQuery("SELECT SUM(gas_monto) suma
	    		   						FROM   gastos_empresa
	    		   						WHERE  gas_fecha   	   BETWEEN '$desde' AND '$hasta'
	    		   						 $script
	    		   						AND    gas_estado      = 1");

	    	for ($i=0; $i < count($sql); $i++) { 
				$data += $sql[$i]['suma'];
			}

			return $data;
	    }

	    public function dsctos_ventas_mensual($mes, $ano){
	    	$data 		= 0;
	    	$desde      = $ano.'-'.$mes.'-01';
	    	$ultimo_dia = date("t", strtotime($desde));
	    	$hasta  	= $ano.'-'.$mes.'-'.$ultimo_dia;

	    	$sql  		= $this->selectQuery("SELECT 	SUM(c_cli_monto) suma
											  FROM 		caja_cliente
											  WHERE 	c_cli_fecha   		  BETWEEN '$desde' AND '$hasta'
		    		   						  AND    	c_cli_estado    	  = 2
		    		   						  AND       c_cli_tipoMovimiento  = 6
											  GROUP BY 	c_cli_fecha");

	    	for ($i=0; $i < count($sql); $i++) { 
				$data += $sql[$i]['suma']*-1;
			}

			return $data;
		}

		public function facturas_proveedores_diario($fecha){
	    	$data 		= 0;
	    	$sql  		= $this->selectQuery("SELECT SUM(fac_bruto) suma
		    	   							  FROM   facturas_proveedores
		    	   							  WHERE  fac_fecha_pagada    = '$fecha'
		    	   							  AND    fac_estado			 = 1");

	    	for ($i=0; $i < count($sql); $i++) { 
				$data += $sql[$i]['suma'];
			}

			return $data;
		}

		public function facturas_proveedores_mensual($mes, $ano){
	    	$data 		= 0;
	    	$desde      = $ano.'-'.$mes.'-01';
	    	$ultimo_dia = date("t", strtotime($desde));
	    	$hasta  	= $ano.'-'.$mes.'-'.$ultimo_dia;

	    	$sql  		= $this->selectQuery("SELECT SUM(fac_bruto) suma
		    	   							  FROM   facturas_proveedores
		    	   							  WHERE  fac_fecha_pagada    BETWEEN '$desde' AND '$hasta'
		    	   							  AND    fac_estado			 = 1");

	    	for ($i=0; $i < count($sql); $i++) { 
				$data += $sql[$i]['suma'];
			}

			return $data;
		}

		public function montos_sueldos_mensual($mes, $ano){
	    	$data 		= 0;
	    	$desde      = $ano.'-'.$mes.'-01';
	    	$ultimo_dia = date("t", strtotime($desde));
	    	$hasta  	= $ano.'-'.$mes.'-'.$ultimo_dia;

	    	$sql  		= $this->selectQuery("SELECT SUM(liquid_tot_haber) suma
		    	   							  FROM   liquidaciones_sueldo
		    	   							  WHERE  liquid_fecha    BETWEEN '$desde' AND '$hasta'
		    	   							  AND    liquid_estado   = 1");

	    	for ($i=0; $i < count($sql); $i++) { 
				$data += $sql[$i]['suma'];
			}

			return $data;
		}

		public function informe_ventas($mes, $ano){
			$iva  = $this->montos_iva_ventas_mensual($mes, $ano);

			if($iva > 0){
				$iva_mostrar = $this->montos_iva_ventas_mensual($mes, $ano);
			}else{
				$iva_mostrar = ($this->montos_iva_ventas_mensual($mes, $ano)*-1);
			}

			$html = '<div class="col-xl-6">
	    				<h3><i class="bi bi-cash"></i>&nbsp;&nbsp;Informe de Ventas.</h3>
	    			 </div>
	    			 <div class="col-xl-6">
	    				<table width="100%">
	    					<tr>
	    						<td>'.Utilidades::select_agrupacion_cards('', 'mes', $ano, $mes).'</td>
	    						<td>'.Utilidades::select_agrupacion_anos('', 'ano', $ano).'</td>
	    						<td><button class="btn btn-primary" onclick="buscar_informe_ventas()"><i class="bi bi-search"></i></button></td>
	    					</tr>
	    				</table>
	    			 </div>
	    			 <hr class="mt-2 mb-3"/>
	    			 <div class="col-xl-6 col-md-6">
						<div class="card animate__animated animate__fadeInLeft shadow">
							<div class="card-body text-center">
								<div>
									<h3 class="text-info"><i class="bi bi-clipboard-data  mb-4"></i><br>Resumen de Ventas</h3>
								</div>
								<p class="mt-2 card-text">
									Realizadas en el mes de <b>'.Utilidades::mostrar_mes($mes).' '.$ano.'</b>
								</p>
								<div class="border-top pt-3">
									<div class="row">
										<div class="col-3">
											<p class="text-primary">Ventas Realizadas</p>
											<h2 class="text-primary">'.Utilidades::monto3($this->montos_ventas_categorias_mensual(0, $mes, $ano)).'</h2>
										</div>
										<div class="col-3">
											<p class="text-danger">Iva</p>
											<h2 class="text-danger">'.Utilidades::monto3($iva_mostrar).'</h2>
										</div>
										<div class="col-3">
											<p class="text-info">Productos</p>
											<h2 class="text-info">'.Utilidades::miles($this->cantidad_ventas_categorias_mensual(0, $mes, $ano)).'</h2>
										</div>
										<div class="col-3">
											<p class="text-success">Descargar</p>
											<h1 class="text-success cursor" title="Descargar">
												<a href="'.controlador::$rutaAPP.'app/vistas/reporteria/php/validador_reporteria.php?accion=informe_ventas_imprimir&mes='.$mes.'&ano='.$ano.'"><i class="bi bi-box-arrow-down"></i></a>
											</h1>
										</div>
										<hr class="mt-2 mb-3"/>
										<div class="col-11">
											<p class="text-success">&nbsp;</p>
										</div>
									</div>
								</div>
							</div>
						</div>
					 </div>
					 <div class="col-xl-6 col-md-6">
					 	<div class="card animate__animated animate__fadeInLeft shadow">
					 		<div class="card-body text-center">
						 		<div>
									<h3 class="text-info"><i class="bi bi-box2-heart"></i><br>Top productos</h3>
								</div>
						 		'.$this->top_ten_productos($mes, $ano).'
						 	</div>
					 	</div>
					 </div>';

	    	return $html;
		}

		public function top_ten_productos($mes, $ano){
			$data     	= 0;
			$recursos 	= new Recursos();
			$desde      = $ano.'-'.$mes.'-01';
	    	$ultimo_dia = date("t", strtotime($desde));
	    	$hasta  	= $ano.'-'.$mes.'-'.$ultimo_dia;

			$sql    = $this->selectQuery("SELECT * FROM product_cliente
										  LEFT JOIN		caja_cliente
										  ON            caja_cliente.c_cli_prod_cliente 	= product_cliente.prod_cli_id
										  WHERE    		caja_cliente.c_cli_tipoMovimiento   = 3
										  AND      		caja_cliente.c_cli_prod_cliente     > 0
										  AND      		caja_cliente.c_cli_estado           = 2
										  AND      		caja_cliente.c_cli_fecha 			BETWEEN '$desde' AND '$hasta'
										  GROUP BY 		caja_cliente.c_cli_prod_cliente 	LIMIT 10");

			$html = ' <table id="productos_list" class="table table-hover" style="width:100%">
			            <thead >
			              <tr class="table-info">
			                <th>Nombre</th>
			                <th class="ocultar">Marca</th>
			                <th class="ocultar">Categor&iacute;a</th>
			              </tr>
			            </thead>
			            <tbody>';
			for ($i=0; $i < count($sql); $i++) { 
				$html .= '<tr>
				          	<td>'.ucfirst($sql[$i]['prod_cli_producto']).'</td>
				          	<td class="ocultar">'.$recursos->nombre_marca($sql[$i]['prod_cli_marca']).'</td>
				          	<td class="ocultar">'.$recursos->nombre_categoria($sql[$i]['prod_cli_categoria']).'</td>
				          </tr>';
			}

			$html .= ' </tbody>
					  </table>';

			return $html;
		}

		public function listado_productos_imprime($mes, $ano){

			$data     	= 0;
			$recursos 	= new Recursos();
			$desde      = $ano.'-'.$mes.'-01';
	    	$ultimo_dia = date("t", strtotime($desde));
	    	$hasta  	= $ano.'-'.$mes.'-'.$ultimo_dia;

			$sql    = $this->selectQuery("SELECT * FROM product_cliente
										  LEFT JOIN		caja_cliente
										  ON            caja_cliente.c_cli_prod_cliente   = product_cliente.prod_cli_id
										  WHERE    		caja_cliente.c_cli_tipoMovimiento = 3
										  AND      		caja_cliente.c_cli_estado         != 3
										  AND      		caja_cliente.c_cli_fecha          BETWEEN '$desde' AND '$hasta'
										  ORDER BY 		caja_cliente.c_cli_id ASC");

			$html = '<table id="tabla2" cellspacing="0" cellpadding="1" class="sombraPlana2">
						<tr>
							<th align="left">N&deg;</th>
							<th align="left">Boleta</th>
							<th align="left">C&oacute;digo</th>
							<th align="left">Nombre</th>
							<th align="left">Monto</th>
							<th align="left">Fecha Arriendo</th>
							<th align="left">Fecha Entrega</th>
						</tr>';
			$j=1;
			for ($i=0; $i < count($sql); $i++) { 
				$html .= '<tr>
							<td>'.$j++.'</td>
				          	<td>'.$sql[$i]['c_cli_lote'].'</td>
				          	<td class="ocultar">'.$sql[$i]['prod_cli_codigo'].'</td>
				          	<td class="ocultar">'.$sql[$i]['prod_cli_producto'].'</td>
				          	<td class="ocultar">'.$sql[$i]['c_cli_monto'].'</td>
				          	<td class="ocultar">'.$sql[$i]['c_cli_fecha'].'</td>
				          	<td class="ocultar">'.$sql[$i]['c_cli_fecha_fin'].'</td>
				          </tr>';
			}

			$html .= ' </tbody>
					  </table>';

			return $html;
		}

		public function reporte_financiero($mes, $ano){
			$iva  			 = $this->montos_iva_ventas_mensual($mes, $ano);
			$saldo 	 		 = $this->montos_ventas_categorias_mensual(0, $mes, $ano);
			$gastos  		 = $this->montos_egresos_categorias_mensual(0, $mes, $ano);
	    	$otros   		 = $this->dsctos_ventas_mensual($mes, $ano);
			$suedos  		 = $this->montos_sueldos_mensual($mes, $ano);
			$proveedores	 = $this->facturas_proveedores_mensual($mes, $ano);

			if($iva > 0){
				$iva_mostrar = $iva;
			}else{
				$iva_mostrar = ($iva*-1);
			}

			$descuentos  	 = ($gastos+$otros+$suedos+$iva_mostrar+$proveedores);
			$total  		 = ($saldo-$descuentos);

			$html = '<div class="col-xl-6">
	    				<h3><i class="bi bi-bank"></i>&nbsp;&nbsp;Reporte Financiero.</h3>
	    			 </div>
	    			 <div class="col-xl-6">
	    				<table width="100%">
	    					<tr>
	    						<td align="center">'.Utilidades::select_agrupacion_cards('', 'mes', $ano, $mes).'</td>
	    						<td align="center">'.Utilidades::select_agrupacion_anos('', 'ano', $ano).'</td>
	    						<td align="center"><button class="btn btn-primary" onclick="buscar_reporte_financiero()"><i class="bi bi-search"></i></button></td>
	    						<td align="center"><button class="btn btn-warning" data-fancybox data-type="iframe" data-preload="true" data-width="100%" data-height="600" href="'.controlador::$rutaAPP.'app/vistas/reporteria/php/validador_reporteria.php?accion=imprimir_reporte_financiero&mes='.$mes.'&ano='.$ano.'"><i class="bi bi-printer-fill"></i></button></td>
	    					</tr>
	    				</table>
	    			 </div>
	    			 <hr class="mt-2 mb-3"/>
	    			 <div class="col-xl-6 col-md-6">
						<div class="card animate__animated animate__fadeInLeft shadow">
							<div class="card-body text-center">
								<div>
									<h2 class="text-info"><i class="bi bi-calendar3"></i><br>Resumen '.Utilidades::mostrar_mes($mes).'</h2>
								</div>
								<div class="border-top pt-3">
									<div class="row">
										<table class="table">
											<tr>
												<th>
													<p class="text-dark">Ventas Realizadas</p>
												</th>
												<th>
													<h4 class="text-primary">'.Utilidades::monto3($saldo).'</h4>
												</th>
											</tr>
											<tr>
												<th>
													<p class="text-dark">Descuentos</p>
												</th>
												<th>
													<h4 class="text-danger">'.Utilidades::monto3($descuentos).'</h4>
												</th>
											</tr>
											<tr>
												<th>
													<p class="text-dark">Total</p>
												</th>
												<th>
													<h4 class="text-success">'.Utilidades::monto3($total).'</h4>
												</th>
											</tr>
										</table>
									</div>
								</div>
							</div>
						</div>
					 </div>
					 <div class="col-xl-6 col-md-6">
					 	<div class="card animate__animated animate__fadeInLeft shadow">
					 		<div class="card-body text-center">
						 		<div>
									<h2 class="text-success"><i class="bi bi-piggy-bank"></i><br>Montos Inversionistas</h2>
								</div>
						 		<div class="border-top pt-3">
									<div class="row">
										'.$this->reparto_invercionistas($total).'
									</div>
								</div>
						 	</div>
					 	</div>
					 </div>';

	    	return $html;
		}

		public function print_reporte_financiero($mes, $ano){
			$iva  			 = $this->montos_iva_ventas_mensual($mes, $ano);
			$saldo 	 		 = $this->montos_ventas_categorias_mensual(0, $mes, $ano);
			$gastos  		 = $this->montos_egresos_categorias_mensual(0, $mes, $ano);
	    	$otros   		 = $this->dsctos_ventas_mensual($mes, $ano);
			$suedos  		 = $this->montos_sueldos_mensual($mes, $ano);

			if($iva > 0){
				$iva_mostrar = $iva;
			}else{
				$iva_mostrar = ($iva*-1);
			}

			$descuentos  	 = ($gastos+$otros+$suedos+$iva_mostrar);
			$total  		 = ($saldo-$descuentos);

			$html = ' <div class="col-xl-10 col-md-10">
						<div class="card animate__animated animate__fadeInLeft shadow">
							<div class="card-body text-center">
								<div>
									<h2 class="text-info"><i class="bi bi-calendar3"></i><br>Resumen '.Utilidades::mostrar_mes($mes).'</h2>
								</div>
								<div class="border-top pt-3">
									<div class="row">
										<table class="table">
											<tr>
												<th>
													<p class="text-dark">Ventas Realizadas</p>
												</th>
												<th>
													<h4 class="text-primary">'.Utilidades::monto3($saldo).'</h4>
												</th>
											</tr>
											<tr>
												<th>
													<p class="text-dark">Descuentos</p>
												</th>
												<th>
													<h4 class="text-danger">'.Utilidades::monto3($descuentos).'</h4>
												</th>
											</tr>
											<tr>
												<th>
													<p class="text-dark">Total</p>
												</th>
												<th>
													<h4 class="text-success">'.Utilidades::monto3($total).'</h4>
												</th>
											</tr>
										</table>
									</div>
								</div>
							</div>
						</div>
					 </div>
					 <div class="col-xl-10 col-md-10">
					 	<div class="card animate__animated animate__fadeInLeft shadow">
					 		<div class="card-body text-center">
						 		<div>
									<h2 class="text-success"><i class="bi bi-piggy-bank"></i><br>Montos Inversionistas</h2>
								</div>
						 		<div class="border-top pt-3">
									<div class="row">
										'.$this->reparto_invercionistas($total).'
									</div>
								</div>
						 	</div>
					 	</div>
					 </div>';

	    	return $html;
		}

		public function reparto_invercionistas($monto){

			$sql    = $this->selectQuery("SELECT * FROM inversionistas
		    		   					  WHERE  		in_estado = 1");

		    $html   = '<table class="table">';

		    for ($i = 0; $i < count($sql); $i++) {
		    	$porc    = ($sql[$i]['in_porcentaje_invercion']/100);
		    	$reparto = ($monto*$porc);

		    	$html   .= '<tr>
							 <th><h5 class="text-dark">'.$sql[$i]['inv_nombre'].'</h5></th>
							 <th><h4 class="text-info">'.Utilidades::monto3($reparto).'</h4></th>
						   </tr>';
		    }
		    $html       .= '</table>';


		    return $html;
		}

		public function traer_monto_estado_pago_final($idEstadoPago){
			$recursos= new Recursos();
			$total   = 0;

			$sql     = $this->selectQuery("SELECT * FROM edp_servicio 
	    							       LEFT JOIN     estado_de_pago
	    							       ON            estado_de_pago.edp_id = edp_servicio.edpserv_edp
	    							       LEFT JOIN     servicios
	    							       ON            servicios.serv_id     = edp_servicio.edpserv_serv
	    							       LEFT JOIN     fletes
	    							       ON            fletes.fle_servicio   = servicios.serv_id
	    							       WHERE 		 edpserv_edp 		   = $idEstadoPago");

			for ($i=0; $i < count($sql); $i++) {
				$total += $sql[$i]['fle_valor'];				
			}

			return $total;
		}

		public function listado_estados_pagos_finalizados(){
			$recursos       = new Recursos();
			$centroCostos   = new CentroCostos();
			$pagadas 		= 0;
			$pendientes 	= 0;
			$total_facturas = 0;


	    	$sql    = $this->selectQuery("SELECT * FROM estado_de_pago WHERE edp_estado = 2");


			$html = ' <table id="productos_list" class="table table-hover shadow-lg" style="width:100%">
			            <thead >
			              <tr class="table-info">
			                <th>Código</th>
			                <th>Cliente</th>
			                <th class="ocultar">Fecha Creación</th>
			                <th class="ocultar">Fecha Pagado</th>
			                <th>Monto</th>
			                <th>&nbsp;</th>
			              </tr>
			            </thead>
			            <tbody>';

			for ($i=0; $i < count($sql); $i++) {
				$datos_clientes  = $centroCostos->data_servicio_edp($sql[$i]['edp_id']);

				$html .= '<tr>
			                <td>'.$sql[$i]['edp_codigo'].'</td>
			                <td>'.$datos_clientes[0]['cli_nombre'].'</td>
			                <td>'.Utilidades::arreglo_fecha2($sql[$i]['edp_creacion']).'</td>
			                <td>'.Utilidades::arreglo_fecha2($sql[$i]['edp_pagado']).'</td>
			                <td>'.Utilidades::monto($this->traer_monto_estado_pago_final($sql[$i]['edp_id'])).'</td>
			                <td><div class="col text-center"><span class="h5 fas fa-file-pdf text-danger cursor"  href="'.controlador::$rutaAPP.'app/vistas/centro_costo/php/mostrar_edp.php?idEstadoPago='.$sql[$i]['edp_id'].'" data-fancybox data-type="iframe" data-preload="true" data-width="600" data-height="800"></span></div></td>
			              </tr>';
			}

			$html .= '<tbody></table>';                                        
                                        

            return $html;
		}






		/**  FIN REPORTERIAS   **/

	} // END CLASS
?>