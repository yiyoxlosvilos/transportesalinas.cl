<?php
	require_once __dir__."/../modelo/obtener_datos.php";
	require_once __dir__."/../controlador/utilidadesControlador.php";
	require_once __dir__."/../controlador/centroCostoControlador.php";

	class DashBoard extends GetDatos
	{
		public function __construct(){
			parent::__construct();
	    }

	    /*** HAY QUE COMPROBAR LOS ESTADOS DE MOVIMIENTOS DE CAJA ***/

	    /* Inicio Dashboard */
	    // MONTO DE ARRIENDO DIARIO
	    public function arriendos_diario($fecha){
			$data   = 0;
			$sql    = $this->selectQuery("SELECT * FROM caja_cliente
					   					  WHERE    	 	c_cli_tipoMovimiento = 3
					   					  AND      	 	c_cli_fecha          = '$fecha'
					   					  AND      	 	c_cli_estado         = 2
					   					  AND      	 	c_cli_entrega        = 0
					   					  ORDER BY 	 	c_cli_fecha_fin ASC");

			for ($i=0; $i < count($sql); $i++) { 
				$data += $sql[$i]['c_cli_monto'];
			}

			return $data;
		}

		public function arriendos_diario_card($mes, $ano){
			$data   = 0;

			$inicio  = $ano.'-'.$mes.'-01';
	    	$final 	 = date("Y-m-t", strtotime($inicio));

			$sql    = $this->selectQuery("SELECT * FROM caja_cliente
					   					  WHERE    	 	c_cli_tipoMovimiento IN(3, 4)
					   					  AND      	 	c_cli_fecha          BETWEEN '$inicio' AND '$final'
					   					  AND      	 	c_cli_estado         IN(1,2)
					   					  ORDER BY 	 	c_cli_fecha_fin ASC");

			for ($i=0; $i < count($sql); $i++) { 
				$data += $sql[$i]['c_cli_monto'];
			}

			echo Utilidades::monto2($data);
		}

	    // MONTOS DE ARRIENDOS POR DIA PARA CHARTS
		public function arriendos_diarios_historial_card($ano, $mes){
			$data   = '';
			$meses  = 13;
			$dias   = date("t")+1;

			for ($i=1; $i < $dias; $i++) {

				if(strlen($i) > 1){
					$dia = $i;
				}else{
					$dia = "0".$i;
				}

				$fechainicio = $ano.'-'.$mes."-".$dia;
				$sql         = $this->selectQuery(" SELECT 		SUM(c_cli_monto) monto 
										  	    	FROM 		caja_cliente
					   					  	    	WHERE    	c_cli_tipoMovimiento IN(3, 4)
					   					  	    	AND      	c_cli_fecha          = '$fechainicio'
					   					  	    	AND      	c_cli_estado         IN(1, 2)
					   					  	    	ORDER BY 	c_cli_fecha ASC");
				if($sql[0]['monto'] > 0){
					$data .= $sql[0]['monto'].',';
				}else{
					$data .= '0,';
				}
			}

			echo substr($data, 0, -1);
		}

		// MONTOS DE GASTOS POR DIA PARA CHARTS
		public function gastos_diarios_historial_card($ano, $mes){
			$data   = '';
			$meses  = 13;
			$dias   = date("t")+1;

			for ($i=1; $i < $dias; $i++) {

				if(strlen($i) > 1){
					$dia = $i;
				}else{
					$dia = "0".$i;
				}

				$fechainicio = $ano.'-'.$mes."-".$dia;
				$sql         = $this->selectQuery("SELECT * FROM gastos_empresa
							   					   WHERE    	 gas_fecha     = '$fechainicio'
							   					   AND      	 gas_estado    = 1");
				if($sql[0]['gas_monto'] > 0){
					$data .= $sql[0]['gas_monto'].',';
				}else{
					$data .= '0,';
				}
			}

			echo substr($data, 0, -1);
		}

		public function iva_diarios_historial_card($ano, $mes){
			$data   = '';
			$meses  = 13;
			$dias   = date("t")+1;

			for ($i=1; $i < $dias; $i++) {

				if(strlen($i) > 1){
					$dia = $i;
				}else{
					$dia = "0".$i;
				}

				$fechainicio = $ano.'-'.$mes."-".$dia;

				$sql         = $this->selectQuery("SELECT 	SUM(ven_iva) iva
												   FROM 	ventascliente
										  	       WHERE    ven_cli_fecha  = '$fechainicio'
										  	       AND      ven_cli_estado = 1
										  	       GROUP BY ven_cli_fecha");

				if($sql[0]['iva'] > 0){
					$data .= $sql[0]['iva'].',';
				}else{
					$data .= '0,';
				}
			}

			echo substr($data, 0, -1);
		}

		//VARIACION DE VENTAS POR DIARIAS
		public function variante_venta_diaria($fecha){
			$fecha_antes = date("Y-m-d", strtotime($fecha."- 1 days"));

			$monto_hoy = $this->arriendos_diario($fecha);
			$monto_ayer= $this->arriendos_diario($fecha_antes);
			$calcular  = ($monto_hoy-$monto_ayer);

			if($calcular == 0){
				$html = '<span class="badge bg-soft-info text-info">'.Utilidades::monto($calcular).'</span>
						 <span class="ms-1 text-muted font-size-13">sin variación</span>';
			}elseif($calcular >= 0){
				$html = '<span class="badge bg-soft-success text-success">+'.Utilidades::monto($calcular).'</span>
						 <span class="ms-1 text-muted font-size-13">que ayer.</span>';
			}else{
				$html = '<span class="badge bg-soft-warning text-warning">-'.Utilidades::monto($calcular).'k</span>
						 <span class="ms-1 text-muted font-size-13">que ayer.</span>';
			}

			return $html;
		}

		// MONTO DE ARRIENDO MENSUAL
		public function arriendos_mensual($mes, $ano){
			$data   = 0;
			$inicio = $ano.'-'.$mes.'-01';
	    	$final 	= date("Y-m-t", strtotime($inicio));

			$sql    = $this->selectQuery("SELECT * FROM caja_cliente
					   					  WHERE    	 	c_cli_tipoMovimiento = 3
					   					  AND      	 	c_cli_fecha          BETWEEN '$inicio' AND '$final'
					   					  AND      	 	c_cli_estado         = 2
					   					  AND      	 	c_cli_entrega        = 0
					   					  ORDER BY 	 	c_cli_fecha_fin ASC");

			for ($i=0; $i < count($sql); $i++) { 
				$data += $sql[$i]['c_cli_monto'];
			}

			return $data;
		}

		// MONTOS DE ARRIENDOS POR MENSUAL PARA CHARTS
		public function arriendos_mensuales_historial_card($ano){
			$data   = '';
			$meses  = 13;

			for ($i=1; $i < $meses; $i++) {

				if(strlen($i) > 1){
					$mes = $i;
				}else{
					$mes = "0".$i;
				}

				$inicio  = $ano.'-'.$mes.'-01';
	    		$final 	 = date("Y-m-t", strtotime($inicio));

				$sql         = $this->selectQuery(" SELECT 	 SUM(c_cli_monto) monto 
										  	    	FROM 	 caja_cliente
					   					  	    	WHERE    c_cli_tipoMovimiento = 3
					   					  	    	AND      c_cli_fecha          BETWEEN '$inicio' AND '$final'
					   					  	    	AND      c_cli_estado         = 2
					   					  	    	AND      c_cli_entrega        = 0
					   					  	    	ORDER BY c_cli_fecha ASC");
				if($sql[0]['monto'] > 0){
					$data .= $sql[0]['monto'].',';
				}else{
					$data .= '0,';
				}
			}

			return substr($data, 0, -1);
		}

		//VARIACION DE VENTAS MENSUALES
		public function variante_venta_mensual($ano, $mes){

			$mesAnterior = ($mes-1);

			$monto_hoy = $this->arriendos_mensual($ano, $mes);
			$monto_ayer= $this->arriendos_mensual($ano, $mesAnterior);
			$calcular  = ($monto_hoy-$monto_ayer);

			if($calcular == 0){
				$html = '<span class="badge bg-soft-info text-info">'.Utilidades::monto($calcular).'</span>
						 <span class="ms-1 text-muted font-size-13">sin variación.</span>';
			}elseif($calcular >= 0){
				$html = '<span class="badge bg-soft-success text-success">+'.Utilidades::monto($calcular).'</span>
						 <span class="ms-1 text-muted font-size-13">que '.Utilidades::mostrar_mes($mesAnterior).'.</span>';
			}else{
				$html = '<span class="badge bg-soft-warning text-warning">-'.Utilidades::monto($calcular).'k</span>
						 <span class="ms-1 text-muted font-size-13">que '.Utilidades::mostrar_mes($mesAnterior).'.</span>';
			}

			return $html;
		}

		// MONTOS DE IVA VENTAS 
		public function iva_venta_mensual($inicio, $final){
	    	$data   	= 0;
			$result 	= $this->selectQuery("SELECT ven_iva
										  	  FROM   ventascliente
										  	  WHERE  ven_cli_fecha  BETWEEN '$inicio' AND '$final'
										  	  AND    ven_cli_estado = 1");

			for ($i=0; $i < count($result); $i++) { 
				$data += $result[$i]['ven_iva'];
			}

			return $data;
		}

		public function iva_venta_diario($fecha){
	    	$data   	= 0;
			$result 	= $this->selectQuery("SELECT ven_iva
										  	  FROM   ventascliente
										  	  WHERE  ven_cli_fecha  BETWEEN '$fecha'
										  	  AND    ven_cli_estado = 1");

			for ($i=0; $i < count($result); $i++) { 
				$data += $result[$i]['ven_iva'];
			}

			return $data;
		}

		// MONTOS DE IVA PROVEEDORES 
		public function iva_compra_mensual($inicio, $final){
	    	$data   	= 0;

			$result 	= $this->selectQuery("SELECT fac_iva
										  	  FROM   facturas_proveedores
										  	  WHERE  fac_fecha_factura  BETWEEN '$inicio' AND '$final'
										  	  AND    fac_estado = 1");

			for ($i=0; $i < count($result); $i++) { 
				$data += $result[$i]['fac_iva'];
			}

			return $data;
		}

		// MONTOS DE IVA ACUMULADO
		public function iva_mensual($mes, $ano){
	    	$inicio  = $ano.'-'.$mes.'-01';
	    	$final 	 = date("Y-m-t", strtotime($inicio));

			$data   = $this->iva_venta_mensual($inicio, $final);

			echo Utilidades::monto2($data);
		}

		// MONTOS DE IVAS MENSUAL PARA CHARTS
		public function ivas_mensuales_historial_card($ano){
			$data   = '';
			$meses  = 13;

			for ($i=1; $i < $meses; $i++) {

				if(strlen($i) > 1){
					$mes = $i;
				}else{
					$mes = "0".$i;
				}

				$inicio  = $ano.'-'.$mes.'-01';
	    		$final 	 = date("Y-m-t", strtotime($inicio));

				$sql         = $this->iva_venta_mensual($inicio, $final);

				if($sql > 0){
					$data .= $sql.',';
				}else{
					$data .= '0,';
				}
			}

			return substr($data, 0, -1);
		}

		//VARIACION DE IVAS MENSUALES
		public function variante_iva_mensual($ano, $mes){

			$mesAnterior = ($mes-1);

			$monto_hoy = $this->iva_venta_mensual($ano, $mes);
			$monto_ayer= $this->iva_venta_mensual($ano, $mesAnterior);
			$calcular  = ($monto_hoy-$monto_ayer);

			if($calcular == 0){
				$html = '<span class="badge bg-soft-info text-info">'.Utilidades::monto($calcular).'</span>
						 <span class="ms-1 text-muted font-size-13">sin variación.</span>';
			}elseif($calcular >= 0){
				$html = '<span class="badge bg-soft-success text-success">+'.Utilidades::monto($calcular).'</span>
						 <span class="ms-1 text-muted font-size-13">que '.Utilidades::mostrar_mes($mesAnterior).'.</span>';
			}else{
				$html = '<span class="badge bg-soft-warning text-warning">-'.Utilidades::monto($calcular).'k</span>
						 <span class="ms-1 text-muted font-size-13">que '.Utilidades::mostrar_mes($mesAnterior).'.</span>';
			}

			return $html;
		}


		/* AGRUPACION DE CARDS */

		// CANTIDAD DE PRODUCTOS
		public function cantidad_productos_metas($mes, $ano){
	    	$data   = 0;
	    	$inicio = $ano.'-'.$mes.'-01';
	    	$final 	= date("Y-m-t", strtotime($inicio));

			$result = $this->selectQuery("SELECT * FROM caja_cliente
					   					  WHERE    		c_cli_tipoMovimiento = 3
					   					  AND      		c_cli_fecha          BETWEEN '$inicio' AND '$final'
					   					  AND      		c_cli_estado         = 2
					   					  ORDER BY 		c_cli_fecha ASC");

			for ($i=0; $i < count($result); $i++) { 
				$data++;
			}

			return $data;
		}

		// METAS MENSUALES
		public function metas_mensuales($mes, $ano){
	    	$data   = 0;
	    	$inicio = $ano."-".$mes."-01";

			$result = $this->selectQuery("SELECT * FROM metas_mensuales
					   					  WHERE    		metas_mes            = '$inicio'
					   					  AND      		meta_estado          = 1");

			for ($i=0; $i < count($result); $i++) { 
				$data += $result[$i]['meta_monto'];
			}

			return $data;
		}

		// CONTENIDO DE METAS
		public function contenido_metas($mes, $ano){
			$ventas 	= $this->ventas_mensual($mes, $ano);
			$productos 	= $this->cantidad_productos_metas($mes, $ano);
			$metas 		= $this->metas_mensuales($mes, $ano);
 
			if($metas > 0){
				$meta 		 = $metas;
				$por         = ($ventas*100);
				$ponderacion = round(($por/$metas),2);
			}else{
				$meta 		 = 0;
				$ponderacion = 0;
			}

			$html = '<div class="col-sm">
                        <div id="invested-overview" data-colors=\'["#4ba6ef", "#042a48"]\' class="apex-charts"></div>
                     </div>';

			$html .= '<div class="col-sm align-self-center" >
						<div class="mt-4 mt-sm-0">
							<div class="d-flex align-items-center">
						        <div class="avatar w-56 m-2 gd-success">
						            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trending-up">
						                  <polyline points="23 6 13.5 15.5 8.5 10.5 1 18"></polyline>
						                  <polyline points="17 6 23 6 23 12"></polyline>
						            </svg>
						        </div>
						        <div class="px-4 flex">
						            <p>Total Ventas</p>
						            <h5 class="counter-value" data-target="'.$ventas.'">0</h5>
						        </div>
						    </div>
						    <div class="d-flex align-items-center">
						        <div class="avatar w-56 m-2 bg-warning">
						            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trending-up text-white">
						                  <polyline points="23 6 13.5 15.5 8.5 10.5 1 18"></polyline>
						                  <polyline points="17 6 23 6 23 12"></polyline>
						            </svg>
						        </div>
						        <div class="px-4 flex">
						            <p>Servicios Realizados</p>
						            <h5 class="counter-value" data-target2="'.$productos.'">0</h5>
						        </div>
						    </div>
						    <div class="d-flex align-items-center">
						        <div class="avatar w-56 m-2 bg-danger">
						            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trending-up text-white">
						                  <polyline points="23 6 13.5 15.5 8.5 10.5 1 18"></polyline>
						                  <polyline points="17 6 23 6 23 12"></polyline>
						            </svg>
						        </div>
						        <div class="px-4 flex">
						            <p>Meta Establecida</p>
						            <h5 class="counter-value" data-target="'.$meta.'">0</h5>
						        </div>
						    </div>
                     </div>';
            $html .= '<div id="grafico_cambiar">
            			<script>
            				initCounterNumber();
							var radialchartColors = getChartColorsArray("#invested-overview");
							var options = {
							    chart: {
							        height: 450,
							        type: "radialBar",
							        offsetY: -10
							    },
							    plotOptions: {
							        radialBar: {
							            startAngle: -130,
							            endAngle: 130,
							            dataLabels: {
							                name: {
							                    show: true
							                },
							                value: {
							                    offsetY: 10,
							                    fontSize: "25px",
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
							            shadeIntensity: 0.30,
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
							    series: ['.$ponderacion.'],
							    labels: ["Progreso"],
							}

							var chart = new ApexCharts(
							    document.querySelector("#invested-overview"),
							    options
							);

							chart.render();</script>
						</div>';

			return $html;
		}

	    public function data_ventas_mensual($mes, $ano){
	    	$data   = 0;
	    	$inicio = $ano.'-'.$mes.'-01';
	    	$final 	= date("Y-m-t", strtotime($inicio));

			$result 	= $this->selectQuery("SELECT * FROM   caja_cliente
										  	  WHERE  c_cli_fecha  BETWEEN '$inicio' AND '$final'
										  	  AND    c_cli_tipoMovimiento = 3
										  	  AND    c_cli_estado 		  = 2");

			return $result;
		}

		public function data_inventario_stock_productos($mes, $ano, $tipo){
	    	$inicio = $ano.'-'.$mes.'-01';
	    	$final 	= date("Y-m-t", strtotime($inicio));

			$result 	= $this->selectQuery("SELECT * FROM inventario_stock_productos
										  	  WHERE  stock_fecha  	BETWEEN '$inicio' AND '$final'
										  	  AND    stock_tipo 	= $tipo
										  	  AND    stock_estado   = 2");

			return $result;
		}

		


		public function ventas_diarias($fecha){
		    $data   	= 0;
			$result 	= $this->selectQuery("SELECT ven_cli_montoReal
											  FROM   ventascliente
											  WHERE  ven_cli_fecha  = '$fecha'
											  AND    ven_cli_estado = 1");

			for ($i=0; $i < count($result); $i++) { 
				$data += $result[$i]['ven_cli_montoReal'];
			}

			return $data;
		}

		public function compra_mensual_proveedores($mes, $ano, $estado){
	    	$data   = 0;
	    	$inicio = $ano.'-'.$mes.'-01';
	    	$final 	= date("Y-m-t", strtotime($inicio));

			if($estado == 0){
				$script = " AND    fac_estado 	   IN(1,2)";
			}else{
				$script = " AND    fac_estado 	   = $estado";
			}


			$result = $this->selectQuery("SELECT fac_bruto
										  FROM   facturas_proveedores
										  WHERE  fac_fecha_factura BETWEEN '$inicio' AND  '$final'
										  $script");

			for ($i=0; $i < count($result); $i++) { 
				$data += $result[$i]['fac_bruto'];
			}

			return $data;
		}

		public function ventas_mensual($mes, $ano){
	    	$data   = 0;
	    	$inicio = $ano.'-'.$mes.'-01';
	    	$final 	= date("Y-m-t", strtotime($inicio));

			$result 	= $this->selectQuery("SELECT ven_cli_montoReal
										  	  FROM   ventascliente
										  	  WHERE  ven_cli_fecha  BETWEEN '$inicio' AND '$final'
										  	  AND    ven_cli_estado = 1");

			for ($i=0; $i < count($result); $i++) { 
				$data += $result[$i]['ven_cli_montoReal'];
			}

			return $data;
		}

		public function traer_arriendos($fecha){
			$result = $this->selectQuery("SELECT    c_cli_lote, c_cli_clientes, SUM(c_cli_monto) suma, 
													c_cli_fecha_fin, c_cli_hora, c_cli_lote
										  FROM      caja_cliente
										  WHERE     c_cli_tipoMovimiento = 3
										  AND      c_cli_fecha         = '$fecha'
										  AND       c_cli_estado         = 2
										  AND       c_cli_entrega        = 0
										  GROUP BY  c_cli_lote
										  ORDER BY  c_cli_fecha_fin ASC");

			$html = '<table width="100%" class="table table-borderless">
					  <thead>
					    <tr >
					      <th scope="col">#</th>
					      <th scope="col">Boleta</th>
					      <th scope="col">Cliente</th>
					      <th scope="col">Monto</th>
					      <th scope="col">Entrega</th>
					      <th scope="col">&nbsp;</th>
					    </tr>
					  </thead>
					  <tbody>';
			$j=1;
			for ($i=0; $i < count($result); $i++) { 
				$html .= '<tr >
					      <td scope="col">'.$j++.'</td>
					      <td scope="col">'.$result[$i]['c_cli_lote'].'</td>
					      <td scope="col">'.$result[$i]['c_cli_clientes'].'</td>
					      <td scope="col">'.Utilidades::monto($result[$i]['suma']).'</td>
					      <td scope="col">'.($result[$i]['c_cli_fecha_fin']).'</td>
					      <td scope="col" aling="center"><i href="'.controlador::$rutaAPP.'app/vistas/agendas/php/perfil_agenda.php?idAgenda='.$consultar[$i]['calendario_id'].'" data-fancybox data-type="iframe" data-preload="true" data-width="100%" data-height="720" class="bi bi-eye ver"></i></td>
					    </tr>';
			}


			$html .=  ' </tbody>
					</table>';


			return $html;
		}

		public function entregas_hoy($fecha){
			$result = $this->selectQuery("SELECT   c_cli_lote, c_cli_clientes, SUM(c_cli_monto) suma, 
												   c_cli_fecha_fin, c_cli_hora, c_cli_lote
				   						  FROM     caja_cliente
				   						  WHERE    c_cli_tipoMovimiento  = 3
				   						  AND      c_cli_fecha_fin       < '$fecha'
				   						  AND      c_cli_estado          = 2
				   						  AND      c_cli_entrega         = 0
				   						  GROUP BY c_cli_lote
				   						  ORDER BY c_cli_fecha_fin ASC");

			$html = '<table width="100%" class="table table-borderless">
					  <thead>
					    <tr >
					      <th scope="col">#</th>
					      <th scope="col">Boleta</th>
					      <th scope="col">Cliente</th>
					      <th scope="col">Monto</th>
					      <th scope="col">Entrega</th>
					      <th scope="col">&nbsp;</th>
					    </tr>
					  </thead>
					  <tbody>';
			$j=1;
			for ($i=0; $i < count($result); $i++) { 
				$html .= '<tr >
					      <td scope="col">'.$j.'</td>
					      <td scope="col">'.$result[$i]['c_cli_lote'].'</td>
					      <td scope="col">'.$result[$i]['c_cli_clientes'].'</td>
					      <td scope="col">'.Utilidades::monto($result[$i]['suma']).'</td>
					      <td scope="col">'.($result[$i]['c_cli_fecha_fin']).'</td>
					      <td scope="col" aling="center"><i href="'.controlador::$rutaAPP.'app/vistas/agendas/php/perfil_agenda.php?idAgenda='.$consultar[$i]['calendario_id'].'" data-fancybox data-type="iframe" data-preload="true" data-width="100%" data-height="720" class="bi bi-eye ver"></i></td>
					    </tr>';
			}


			$html .=  ' </tbody>
					</table>';

			if($i > 0){
				return $html;
			}else{
				return '** Sin Info **';
			}

			return $html;
		}

		public function total_facturas_ventas($ano, $mes){

			$inicio  	= $ano.'-'.$mes.'-01';
	    	$final 	  	= date("Y-m-t", strtotime($inicio));
			$total   	= 0;

			$sql    	= $this->selectQuery("SELECT * FROM facturas_venta 
										  	  WHERE 		fac_fecha  		BETWEEN '$inicio' AND '$final'
										  	  AND 			fac_estado 		> 0");

			for ($i=0; $i < count($sql); $i++) {
				$total += $sql[$i]['fac_bruto'];
			}

			return $total;
		}

		public function total_facturas_compra($ano, $mes){

			$inicio  	= $ano.'-'.$mes.'-01';
	    	$final 	  	= date("Y-m-t", strtotime($inicio));
			$total   	= 0;

			$sql    	= $this->selectQuery("SELECT * FROM facturas_proveedores 
										  	  WHERE 		fac_fecha  		BETWEEN '$inicio' AND '$final'
										  	  AND 			fac_estado 		> 0");

			for ($i=0; $i < count($sql); $i++) {
				$total += $sql[$i]['fac_bruto'];
			}

			return $total;
		}

		public function panel_card_facturas_compra($ano, $mes){
			$recursos = new Recursos();

			if(strlen($mes)==1){
				$mess = '0'.$mes;
			}else{
				$mess = $mes;
			}

			$inicio  	= $ano.'-'.$mess.'-01';
	    	$final 	  	= date("Y-m-t", strtotime($inicio));
			$pagadas 	= 0;
			$pendientes = 0;

			$sql    	= $this->selectQuery("SELECT * FROM facturas_proveedores 
										  	  WHERE 		fac_fecha_factura	BETWEEN '$inicio' AND '$final'
										  	  AND 			fac_estado 		> 0");

			$html = '<div class="col-sm">
                        <div class="card shadow-white card-h-100">
                            <div class="card-body p-0">
                                <div id="facturasDeCompras" class="carousel slide text-center widget-carousel" data-bs-ride="carousel">
                                	<div class="carousel-inner">';
			for ($i=0; $i < count($sql); $i++) {
				if($sql[$i]['fac_fecha_pagada'] != NULL){
					$pagadas 	+= $sql[$i]['fac_bruto'];
				}else{
					$pendientes += $sql[$i]['fac_bruto'];
				}

				if($i == 0){
					$active = "carousel-item active";
				}else{
					$active = "carousel-item";
				}

				$datos_proveedores = $recursos->datos_proveedores($sql[$i]['fac_proveedor']);

			    $html .= '
                            <div class="'.$active.'">
                                <div class="text-center p-4">
                                    <i class="bi bi-currency-dollar widget-box-1-icon"></i>
                                    <div class="avatar-md m-auto">
                                        <span class="avatar-title rounded-circle bg-soft-light font-size-24">
                                            <i class="bi bi-currency-dollar"></i>
                                        </span>
                                    </div>
                                    <table width="100%" class="table table-borderless font-size-14">
									  <thead>
									    <tr>
									      <th scope="col">Folio N&deg;:</th>
									      <td scope="col">'.Utilidades::miles($sql[$i]['fac_folio']).'</td>
									    </tr>
									    <tr>
									      <th scope="col">Neto</th>
									      <td scope="col">'.Utilidades::monto($sql[$i]['fac_neto']).'</td>
									    </tr>
									    <tr>
									      <th scope="col">Iva</th>
									      <td scope="col">'.Utilidades::monto($sql[$i]['fac_iva']).'</td>
									    </tr>
									    <tr>
									      <th scope="col">Bruto</th>
									      <td scope="col">'.Utilidades::monto($sql[$i]['fac_bruto']).'</td>
									    </tr>
									    <tr>
									      <th scope="col">Cliente:</th>
									      <td scope="col">'.$datos_proveedores[0]['proveedor_nombre'].'</td>
									    </tr>
									  </thead>
					  				</table>
                            	</div>
                            </div>';
			}

			$html .= '</div>';

			if($i == 0){
				$html .= '<div class="carousel-inner">
                            <div class="carousel-item bg-grey active">
                                <div class="text-center p-4">
                                    <i class="bi bi-wallet2 widget-box-1-icon"></i>
                                    <div class="avatar-md m-auto">
                                        <span class="avatar-title rounded-circle bg-soft-light font-size-24">
                                            <i class="bi bi-wallet2"></i>
                                        </span>
                                    </div>
                                    <table width="80%" class="table table-borderless font-size-13">
									  <tbody>
									    <tr>
									      <th scope="col">&nbsp;</th>
									      <td scope="col">&nbsp;</td>
									    </tr>
									    <tr>
									      <td scope="col" colspan="2" ><h3 align="center" class="fw-lighter"><i>S.R</i></h3></td>
									    </tr>
									    <tr>
									      <th scope="col">&nbsp;</th>
									      <td scope="col">&nbsp;</td>
									    </tr>
									  </tbody>
					  				</table>
                            	</div>
                            </div>
                          </div>';
			}                                         
                                        
            $html .= '                  <div class="carousel-indicators carousel-indicators-rounded">';
            for ($j=0; $j < count($sql); $j++) {
            	if($j == 0){
					$actv = 'class="active"';
				}else{
					$actv = "";
				}
            	$html .= '<button type="button" data-bs-target="#facturasDeCompras" data-bs-slide-to="'.$j.'" '.$actv.'
                                                            aria-current="true" aria-label="Slide 1"></button>';
            }
            
            $total_facturas 	  = ($pendientes+$pagadas);
            $factura_mes_anterior = $this->total_facturas_compra($ano, $mes-1);
            $variacion            = ($total_facturas-$factura_mes_anterior);

            if($variacion > 0){
            	$variante = '<span class="text-success">+ <span class="counter-value" data-target="'.$variacion.'">0</span></span> <i class="bi bi-arrow-bar-up ms-1 text-success"></i>';
            }else{
            	$variante = '<span class="text-danger">- <span class="counter-value" data-target="'.($variacion*-1).'">0</span></span> <i class="bi bi-arrow-bar-down ms-1 text-danger"></i>';
            }

            $html .= '                  </div><!-- end carousel-indicators -->
                                    </div><!-- end carousel -->
                                </div><!-- end card body -->
                            </div>
                        </div>
                        <div class="col-sm align-self-center">
                            <div class="mt-4 mt-sm-0">
                                <p class="mb-1">Total Facturas</p>
                                <h4 class="counter-value" data-target="'.$total_facturas.'">0</h4>
                                <p class="text-muted mb-4"> '.$variante.'</p>
                                <div class="row g-0">
                                    <div class="col-6">
                                        <div>
                                            <p class="mb-2 text-muted text-uppercase font-size-11">Pagadas</p>
                                            <h5 class="fw-medium counter-value text-primary" data-target="'.$pagadas.'">0</h5>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div>
                                            <p class="mb-2 text-muted text-uppercase font-size-11">Pendientes</p>
                                            <h5 class="fw-medium counter-value text-danger" data-target="'.$pendientes.'">0</h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>';
            return $html;
		}

		public function panel_card_facturas_ventas($ano, $mes){

			if(strlen($mes)==1){
				$mess = '0'.$mes;
			}else{
				$mess = $mes;
			}

			$inicio  	= $ano.'-'.$mess.'-01';
	    	$final 	  	= date("Y-m-t", strtotime($inicio));
			$pagadas 	= 0;
			$pendientes = 0;

			$sql    	= $this->selectQuery("SELECT * FROM facturas_clientes  
										  	  WHERE 		fac_fecha_factura  		BETWEEN '$inicio' AND '$final'
										  	  AND 			fac_estado 		> 0");

			$html = '<div class="col-sm">
                        <div class="card text-white card-h-100">
                            <div class="card-body p-0">
                                <div id="facturasDeVentas" class="carousel slide text-center widget-carousel" data-bs-ride="carousel">
                                	<div class="carousel-inner">';
			for ($i=0; $i < count($sql); $i++) {
				if($sql[$i]['fac_estado'] == 1){
					$pagadas 	+= $sql[$i]['fac_bruto'];
				}elseif($sql[$i]['fac_estado'] == 2){
					$pendientes += $sql[$i]['fac_bruto'];
				}

				if($i == 0){
					$active = "carousel-item active";
				}else{
					$active = "carousel-item";
				}

			    $html .= '
                            <div class="'.$active.'">
                                <div class="text-center p-4">
                                    <i class="bi bi-currency-dollar widget-box-1-icon"></i>
                                    <div class="avatar-md m-auto">
                                        <span class="avatar-title rounded-circle bg-soft-light text-white font-size-24">
                                            <i class="bi bi-currency-dollar"></i>
                                        </span>
                                    </div>
                                    <table width="100%" class="table table-borderless text-white font-size-14">
									  <thead>
									    <tr>
									      <th scope="col">Folio N&deg;:</th>
									      <td scope="col">'.Utilidades::miles($sql[$i]['fac_folio']).'</td>
									    </tr>
									    <tr>
									      <th scope="col">Neto</th>
									      <td scope="col">'.Utilidades::monto($sql[$i]['fac_neto']).'</td>
									    </tr>
									    <tr>
									      <th scope="col">Iva</th>
									      <td scope="col">'.Utilidades::monto($sql[$i]['fac_iva']).'</td>
									    </tr>
									    <tr>
									      <th scope="col">Bruto</th>
									      <td scope="col">'.Utilidades::monto($sql[$i]['fac_bruto']).'</td>
									    </tr>
									    <tr>
									      <th scope="col">Cliente:</th>
									      <td scope="col">'.$sql[$i]['fac_cliente'].'</td>
									    </tr>
									  </thead>
					  				</table>
                            	</div>
                            </div>';
			}

			$html .= '</div>';

			if($i == 0){
				$html .= '<div class="carousel-inner">
                            <div class="carousel-item bg-grey active">
                                <div class="text-center p-4">
                                    <i class="bi bi-wallet2 widget-box-1-icon"></i>
                                    <div class="avatar-md m-auto">
                                        <span class="avatar-title rounded-circle bg-soft-light font-size-24">
                                            <i class="bi bi-wallet2"></i>
                                        </span>
                                    </div>
                                    <table width="80%" class="table table-borderless font-size-13">
									  <tbody>
									    <tr>
									      <th scope="col">&nbsp;</th>
									      <td scope="col">&nbsp;</td>
									    </tr>
									    <tr>
									      <td scope="col" colspan="2" ><h3 align="center" class="fw-lighter"><i>S.R</i></h3></td>
									    </tr>
									    <tr>
									      <th scope="col">&nbsp;</th>
									      <td scope="col">&nbsp;</td>
									    </tr>
									  </tbody>
					  				</table>
                            	</div>
                            </div>
                          </div>';
			}                                         
                                        
            $html .= '                  <div class="carousel-indicators carousel-indicators-rounded">';
            for ($j=0; $j < count($sql); $j++) {
            	if($j == 0){
					$actv = 'class="active"';
				}else{
					$actv = "";
				}
            	$html .= '<button type="button" data-bs-target="#facturasDeVentas" data-bs-slide-to="'.$j.'" '.$actv.'
                                                            aria-current="true" aria-label="Slide 1"></button>';
            }
            
            $total_facturas 	  = ($pendientes+$pagadas);
            $factura_mes_anterior = $this->total_facturas_ventas($ano, $mes-1);
            $variacion            = ($total_facturas-$factura_mes_anterior);

            if($variacion > 0){
            	$variante = '<span class="text-success">+ <span class="counter-value" data-target="'.$variacion.'">0</span></span> <i class="bi bi-arrow-bar-up ms-1 text-success"></i>';
            }else{
            	$variante = '<span class="text-danger">- <span class="counter-value" data-target="'.($variacion*-1).'">0</span></span> <i class="bi bi-arrow-bar-down ms-1 text-danger"></i>';
            }

            $html .= '                  </div><!-- end carousel-indicators -->
                                    </div><!-- end carousel -->
                                </div><!-- end card body -->
                            </div>
                        </div>
                        <div class="col-sm align-self-center">
                            <div class="mt-4 mt-sm-0">
                                <p class="mb-1">Total Facturas</p>
                                <h4 class="counter-value" data-target="'.$total_facturas.'">0</h4>
                                <p class="text-muted mb-4"> '.$variante.'</p>
                                <div class="row g-0">
                                    <div class="col-6">
                                        <div>
                                            <p class="mb-2 text-muted text-uppercase font-size-11">Pagadas</p>
                                            <h5 class="fw-medium counter-value text-primary" data-target="'.$pagadas.'">0</h5>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div>
                                            <p class="mb-2 text-muted text-uppercase font-size-11">Pendientes</p>
                                            <h5 class="fw-medium counter-value text-danger" data-target="'.$pendientes.'">0</h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>';
            return $html;
		}

		public function panel_card_venta_hoy($hoy){
			$recursos = new Recursos();
			$html 	  = "";
		

			// $sql    = $this->selectQuery("SELECT * FROM servicios
			// 							  LEFT JOIN 	fletes
			// 							  ON 			fletes.fle_servicio 	= servicios.serv_id
			// 		   					  WHERE    		servicios.serv_estado 	= 1
			// 		   					  AND           fletes.fle_carga      	= '$hoy'
			// 		   					  ORDER BY 		servicios.serv_id DESC");

			$sql    = $this->selectQuery("SELECT * FROM fletes
					   					  WHERE    		fletes.fle_estado 	IN(1, 2)
					   					  AND           fletes.fle_carga    = '$hoy'
					   					  ORDER BY 		fletes.fle_id DESC");

			$html = '<div class="col-sm">
                        <div class="card shadow-white card-h-100">
                            <div class="card-body p-0">
                                <div id="cardVentasHoy" class="carousel slide text-center widget-carousel" data-bs-ride="carousel">
                                	<div class="carousel-inner">';

			for ($i=0; $i < count($sql); $i++) {

				//calulo progreso
				$dias_obra   = 0;
				$dias_espera = 0;

				$producto   	= $recursos->datos_productos($sql[$i]['fle_producto']);
				$rampla     	= $recursos->datos_productos($sql[$i]['fle_rampla']);
				$trabajador 	= $recursos->datos_trabajador($sql[$i]['fle_chofer']);
				$origen     	= $recursos->datos_comuna($sql[$i]['fle_origen']);
				$destino    	= $recursos->datos_comuna($sql[$i]['fle_destino']);

				if($i == 0){
					$active = "carousel-item active";
				}else{
					$active = "carousel-item";
				}

			    $html .= '
                            <div class="'.$active.'">
                                <div class="text-center p-4">
                                    <i class="bi bi-check2-all widget-box-1-icon text-secondary"></i>
                                    <table width="100%" class="table table-borderless font-size-14">
									  <thead>
									    <tr>
									      <th scope="col">Servicio N&deg;:</th>
									      <td scope="col" class="text-dark">'.$sql[$i]['serv_codigo'].'</td>
									    </tr>
									    <tr>
									      <th scope="col">Monto</th>
									      <td scope="col">'.Utilidades::monto($sql[$i]['fle_valor']).'</td>
									    </tr>
									    <tr>
									      <th scope="col">Chofer</th>
									      <td scope="col">'.$trabajador[0]['tra_nombre'].'</td>
									    </tr>
									    <tr>
									      <th scope="col">Origen<br><span class="text-info">'.$origen[0]['nombre'].'</span></td>
									      <th scope="col">Destino:<br><span class="text-danger">'.$destino[0]['nombre'].'</span></td>
									    </tr>
									    <tr>
									      <th scope="col">Tracto:</th>
									      <td scope="col">'.$producto[0]['prod_cli_producto'].' / '.$producto[0]['prod_cli_patente'].'</td>
									    </tr>
									  </thead>
					  				</table>
                            	</div>
                            </div>';
			}

			$html .= '</div>';

			if($i == 0){
				$html .= '<div class="carousel-inner">
                            <div class="carousel-item active bg-grey">
                                <div class="text-center p-4">
                                    <i class="bi bi-wallet2 widget-box-1-icon"></i>
                                    <div class="avatar-md m-auto">
                                        <span class="avatar-title rounded-circle bg-soft-light text-dark font-size-24">
                                            <i class="bi bi-wallet2"></i>
                                        </span>
                                    </div>
                                    <table width="80%" class="table table-borderless font-size-13">
									  <tbody>
									    <tr>
									      <th scope="col">&nbsp;</th>
									      <td scope="col">&nbsp;</td>
									    </tr>
									    <tr>
									      <td scope="col" colspan="2" ><h3 align="center" class="text-dark fw-lighter"><i>S.R</i></h3></td>
									    </tr>
									    <tr>
									      <th scope="col">&nbsp;</th>
									      <td scope="col">&nbsp;</td>
									    </tr>
									  </tbody>
					  				</table>
                            	</div>
                            </div>
                          </div>';
			}                                         
                                        
            $html .= ' 		<div class="carousel-indicators carousel-indicators-rounded">';

            for ($j=0; $j < count($sql); $j++) {
            	if($j == 0){
					$actv = 'class="active"';
				}else{
					$actv = "";
				}
            	$html .= '<button type="button" data-bs-target="#cardVentasHoy" data-bs-slide-to="'.$j.'" '.$actv.'
                                                            aria-current="true" aria-label="Slide 1"></button>';
            }
            

            $html .= '                  </div>
                                    </div>
                                </div>
                            </div>
                        </div>';
            return $html;
		}

		public function panel_card_venta_futuras($hoy){
			$recursos = new Recursos();
			$html 	  = "";

			$sql    = $this->selectQuery("SELECT * FROM fletes
					   					  WHERE    		fletes.fle_estado 	IN(1, 2)
					   					  AND           fletes.fle_carga    > '$hoy'
					   					  ORDER BY 		fletes.fle_id DESC");

			$html = '<div class="col-sm">
                        <div class="card shadow-white card-h-100">
                            <div class="card-body p-0">
                                <div id="cardVentasHoy" class="carousel slide text-center widget-carousel" data-bs-ride="carousel">
                                	<div class="carousel-inner">';

			for ($i=0; $i < count($sql); $i++) {

				//calulo progreso
				$dias_obra   = 0;
				$dias_espera = 0;

				$producto   	= $recursos->datos_productos($sql[$i]['fle_producto']);
				$rampla     	= $recursos->datos_productos($sql[$i]['fle_rampla']);
				$trabajador 	= $recursos->datos_trabajador($sql[$i]['fle_chofer']);
				$origen     	= $recursos->datos_comuna($sql[$i]['fle_origen']);
				$destino    	= $recursos->datos_comuna($sql[$i]['fle_destino']);

				if($i == 0){
					$active = "carousel-item active";
				}else{
					$active = "carousel-item";
				}

			    $html .= '
                            <div class="'.$active.'">
                                <div class="text-center p-4">
                                    <i class="bi bi-check2-all widget-box-1-icon text-secondary"></i>
                                    <table width="100%" class="table table-borderless font-size-14">
									  <thead>
									    <tr>
									      <th scope="col">Servicio N&deg;:</th>
									      <td scope="col" class="text-dark">'.$sql[$i]['serv_codigo'].'</td>
									    </tr>
									    <tr>
									      <th scope="col">Monto</th>
									      <td scope="col">'.Utilidades::monto($sql[$i]['fle_valor']).'</td>
									    </tr>
									    <tr>
									      <th scope="col">Chofer</th>
									      <td scope="col">'.$trabajador[0]['tra_nombre'].'</td>
									    </tr>
									    <tr>
									      <th scope="col">Origen<br><span class="text-info">'.$origen[0]['nombre'].'</span></td>
									      <th scope="col">Destino:<br><span class="text-danger">'.$destino[0]['nombre'].'</span></td>
									    </tr>
									    <tr>
									      <th scope="col">Tracto:</th>
									      <td scope="col">'.$producto[0]['prod_cli_producto'].' / '.$producto[0]['prod_cli_patente'].'</td>
									    </tr>
									  </thead>
					  				</table>
                            	</div>
                            </div>';
			}

			$html .= '</div>';

			if($i == 0){
				$html .= '<div class="carousel-inner">
                            <div class="carousel-item active bg-grey">
                                <div class="text-center p-4">
                                    <i class="bi bi-wallet2 widget-box-1-icon"></i>
                                    <div class="avatar-md m-auto">
                                        <span class="avatar-title rounded-circle bg-soft-light text-dark font-size-24">
                                            <i class="bi bi-wallet2"></i>
                                        </span>
                                    </div>
                                    <table width="80%" class="table table-borderless font-size-13">
									  <tbody>
									    <tr>
									      <th scope="col">&nbsp;</th>
									      <td scope="col">&nbsp;</td>
									    </tr>
									    <tr>
									      <td scope="col" colspan="2" ><h3 align="center" class="text-dark fw-lighter"><i>S.R</i></h3></td>
									    </tr>
									    <tr>
									      <th scope="col">&nbsp;</th>
									      <td scope="col">&nbsp;</td>
									    </tr>
									  </tbody>
					  				</table>
                            	</div>
                            </div>
                          </div>';
			}                                         
                                        
            $html .= ' 		<div class="carousel-indicators carousel-indicators-rounded">';

            for ($j=0; $j < count($sql); $j++) {
            	if($j == 0){
					$actv = 'class="active"';
				}else{
					$actv = "";
				}
            	$html .= '<button type="button" data-bs-target="#cardVentasHoy" data-bs-slide-to="'.$j.'" '.$actv.'
                                                            aria-current="true" aria-label="Slide 1"></button>';
            }
            

            $html .= '                  </div>
                                    </div>
                                </div>
                            </div>
                        </div>';
            return $html;
		}


		public function traer_monto_estado_pago($idEstadoPago){
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

		public function panel_pagos_pendientes($ano, $mes){
			$recursos       = new Recursos();
			$centroCostos   = new CentroCostos();
			$pagadas 		= 0;
			$pendientes 	= 0;
			$total_facturas = 0;


			$inicio  		= $ano.'-'.$mes.'-01';
	    	$final 	  		= date("Y-m-t", strtotime($inicio));

	    	$sql    = $this->selectQuery("SELECT * FROM estado_de_pago WHERE edp_estado = 1");


			$html = '<div class="col-sm">
                        <div class="card shadow-white card-h-100">
                            <div class="card-body p-0">
                                <div id="cardPagosPendientes" class="carousel slide text-center widget-carousel" data-bs-ride="carousel">
                                	<div class="carousel-inner">';

			for ($i=0; $i < count($sql); $i++) {

				$datos_clientes  = $centroCostos->data_servicio_edp($sql[$i]['edp_id']);

				if($i == 0){
					$active = "carousel-item active";
				}else{
					$active = "carousel-item";
				}

				$total_facturas += $this->traer_monto_estado_pago($sql[$i]['edp_id']);

			    $html .= '  <div class="'.$active.'">
                                <div class="text-center p-4">
                                    <i class="bi bi-check2-all widget-box-1-icon text-secondary"></i>
                                    <table width="100%" class="table table-borderless font-size-14">
									  <thead>
									    <tr>
									      <th scope="col">EDP N&deg;:</th>
									      <td scope="col">'.$sql[$i]['edp_codigo'].'</td>
									    </tr>
									    <tr>
									      <th scope="col">Cliente</th>
									      <td scope="col">'.$datos_clientes[0]['cli_nombre'].'</td>
									    </tr>
									    <tr>
									      <th scope="col">Monto</th>
									      <td scope="col">'.Utilidades::monto($this->traer_monto_estado_pago($sql[$i]['edp_id'])).'</td>
									    </tr>
									    <tr>
									      <th scope="col" colspan="2">
									      	<div class="col text-center"><span class="h5 fas fa-file-pdf text-danger cursor"  href="'.controlador::$rutaAPP.'app/vistas/centro_costo/php/mostrar_edp.php?idEstadoPago='.$sql[$i]['edp_id'].'" data-fancybox data-type="iframe" data-preload="true" data-width="600" data-height="800"></span></div>
									      </td>
									    </tr>
									  </thead>
					  				</table>
                            	</div>
                            </div>';
			}

			$html .= '</div>';

			if($i == 0){
				$html .= '<div class="carousel-inner">
                            <div class="carousel-item active bg-grey">
                                <div class="text-center p-4">
                                    <i class="bi bi-wallet2 widget-box-1-icon"></i>
                                    <div class="avatar-md m-auto">
                                        <span class="avatar-title rounded-circle bg-soft-light text-dark font-size-24">
                                            <i class="bi bi-wallet2"></i>
                                        </span>
                                    </div>
                                    <table width="80%" class="table table-borderless font-size-13">
									  <tbody>
									    <tr>
									      <th scope="col">&nbsp;</th>
									      <td scope="col">&nbsp;</td>
									    </tr>
									    <tr>
									      <td scope="col" colspan="2" ><h3 align="center" class="text-dark fw-lighter"><i>S.R</i></h3></td>
									    </tr>
									    <tr>
									      <th scope="col">&nbsp;</th>
									      <td scope="col">&nbsp;</td>
									    </tr>
									  </tbody>
					  				</table>
                            	</div>
                            </div>
                          </div>';
			}                                         
                                        
            $html .= ' 		<div class="carousel-indicators carousel-indicators-rounded">';

            for ($j=0; $j < count($sql); $j++) {
            	if($j == 0){
					$actv = 'class="active"';
				}else{
					$actv = "";
				}
            	$html .= '<button type="button" data-bs-target="#cardPagosPendientes" data-bs-slide-to="'.$j.'" '.$actv.'
                                                            aria-current="true" aria-label="Slide 1"></button>';
            }

            $html .= '                  </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm align-self-center">
                            <div class="mt-4 mt-sm-0">
                                <p class="mb-1">Monto Total</p>
                                <h4 class="counter-value" data-target="'.$total_facturas.'">0</h4>
                                <p class="mb-1">Cantidad Pagos</p>
                                <h4 class="counter-value" data-target2="'.$i.'">0</h4>
                                
                            </div>
                        </div>';
            return $html;
		}

		public function total_gastos($mes, $ano){
			$data = 0;

			$fechainicio  = $ano.'-'.$mes.'-01';
	    	$fechafin 	  = date("Y-m-t", strtotime($fechainicio));

			$sql    = $this->selectQuery("SELECT * FROM gastos_empresa
					   					  WHERE    		gas_fecha     BETWEEN '$fechainicio' AND '$fechafin'
					   					  AND      		gas_estado    = 1");

			for ($i=0; $i < count($sql); $i++) { 
				$data += $sql[$i]['gas_monto'];
			}

			echo Utilidades::monto2($data);
		}

		public function total_gastos_cards($inicio, $final, $estado){
			$data = 0;
			$sql    = $this->selectQuery("SELECT * FROM estado_de_pago 
										  WHERE    	    edp_creacion BETWEEN '$inicio' AND '$final'
										  AND    		edp_estado 		= $estado");

			for ($i=0; $i < count($sql); $i++) { 
				$data += $this->traer_monto_estado_pago($sql[$i]['edp_id']);
			}

			return $data;
		}

		public function panel_gastos_realizados($ano, $mes){
			$recursos       = new Recursos();
			$pagadas 		= 0;
			$pendientes 	= 0;
			$total_facturas = 0;

			$inicio  = $ano.'-'.$mes.'-01';
	    	$final 	  = date("Y-m-t", strtotime($inicio));

			$sql    = $this->selectQuery("SELECT * FROM gastos_empresa
										  LEFT JOIN     servicios
										  ON            servicios.serv_id = gastos_empresa.gas_servicio
										  WHERE    		gas_estado     	  =  1
										  AND           gas_fecha BETWEEN '$inicio' AND '$final'
										  ORDER BY 		gas_fecha DESC");

			$html = '<div class="col-sm">
                        <div class="card shadow-white card-h-100">
                            <div class="card-body p-0">
                                <div id="cardPagosPendientes" class="carousel slide text-center widget-carousel" data-bs-ride="carousel">
                                	<div class="carousel-inner">';

			for ($i=0; $i < count($sql); $i++) {

				if($i == 0){
					$active = "carousel-item active";
				}else{
					$active = "carousel-item";
				}

				$total_facturas += $sql[$i]['gas_monto'];

			    $html .= '  <div class="'.$active.'">
                                <div class="text-center p-4">
                                    <i class="bi bi-check2-all widget-box-1-icon text-secondary"></i>
                                    <table width="100%" class="table table-borderless font-size-14">
									  <thead>
									    <tr>
									      <th scope="col">Servicio N&deg;:</th>
									      <td scope="col">'.$sql[$i]['serv_codigo'].'</td>
									    </tr>
									    <tr>
									      <th scope="col">Monto</th>
									      <td scope="col">'.Utilidades::monto($sql[$i]['gas_monto']).'</td>
									    </tr>
									    <tr>
									      <th scope="col">Tipo Pago:</th>
									      <td scope="col">'.$recursos->nombre_tipo_gastos($sql[$i]['gas_categoria']).' - '.$recursos->nombre_tipo_categorias_gastos($sql[$i]['gas_tipo']).'</td>
									    </tr>
									    <tr>
									      <th scope="col">Fecha</th>
									      <td scope="col">'.$sql[$i]['gas_fecha'].'</td>
									    </tr>
									    <tr>
									      <th scope="col" colspan="2">Descripci&oacute;n</th>
									    </tr>
									    <tr>
									      <td scope="col" colspan="2">'.$sql[$i]['gas_descripcion'].'</td>
									    </tr>
									  </thead>
					  				</table>
                            	</div>
                            </div>';
			}

			$html .= '</div>';

			if($i == 0){
				$html .= '<div class="carousel-inner">
                            <div class="carousel-item active bg-grey">
                                <div class="text-center p-4">
                                    <i class="bi bi-wallet2 widget-box-1-icon"></i>
                                    <div class="avatar-md m-auto">
                                        <span class="avatar-title rounded-circle bg-soft-light text-dark font-size-24">
                                            <i class="bi bi-wallet2"></i>
                                        </span>
                                    </div>
                                    <table width="80%" class="table table-borderless font-size-13">
									  <tbody>
									    <tr>
									      <th scope="col">&nbsp;</th>
									      <td scope="col">&nbsp;</td>
									    </tr>
									    <tr>
									      <td scope="col" colspan="2" ><h3 align="center" class="text-dark fw-lighter"><i>S.R</i></h3></td>
									    </tr>
									    <tr>
									      <th scope="col">&nbsp;</th>
									      <td scope="col">&nbsp;</td>
									    </tr>
									  </tbody>
					  				</table>
                            	</div>
                            </div>
                          </div>';
			}                                         
                                        
            $html .= ' 		<div class="carousel-indicators carousel-indicators-rounded">';

            for ($j=0; $j < count($sql); $j++) {
            	if($j == 0){
					$actv = 'class="active"';
				}else{
					$actv = "";
				}
            	$html .= '<button type="button" data-bs-target="#cardPagosPendientes" data-bs-slide-to="'.$j.'" '.$actv.'
                                                            aria-current="true" aria-label="Slide 1"></button>';
            }

            $html .= '                  </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm align-self-center">
                            <div class="mt-4 mt-sm-0">
                                <p class="mb-1">Monto Total</p>
                                <h4 class="counter-value" data-target="'.$total_facturas.'">0</h4>
                                <p class="mb-1">Cantidad Gastos</p>
                                <h4 class="counter-value" data-target2="'.$i.'">0</h4>
                                
                            </div>
                        </div>';
            return $html;
		}

		public function total_gastos_cards_pendientes($ano){
			$data   = '';
			$meses  = 13;

			for ($i=1; $i < $meses; $i++) {

				if(strlen($i) > 1){
					$mes = $i;
				}else{
					$mes = "0".$i;
				}

				$fechainicio  = $ano.'-'.$mes.'-01';
	    		$fechafin 	  = date("Y-m-t", strtotime($fechainicio));

				$sql         = $this->total_gastos_cards($fechainicio, $fechafin, 1);

				if($sql > 0){
					$data .= $sql.',';
				}else{
					$data .= '0,';
				}
			}

			return substr($data, 0, -1);
		}

		public function total_gastos_cards_pagados($ano){
			$data   = '';
			$meses  = 13;

			for ($i=1; $i < $meses; $i++) {

				if(strlen($i) > 1){
					$mes = $i;
				}else{
					$mes = "0".$i;
				}

				$fechainicio  = $ano.'-'.$mes.'-01';
	    		$fechafin 	  = date("Y-m-t", strtotime($fechainicio));

				$sql         = $this->total_gastos_cards($fechainicio, $fechafin, 2);

				if($sql > 0){
					$data .= $sql.',';
				}else{
					$data .= '0,';
				}
			}

			return substr($data, 0, -1);
		}

		public function categorias_gastos(){
			$data 	= '';
			$result = $this->selectQuery("SELECT * FROM tipo_gastos
					   					  WHERE    		tpgas_estado  = 1");

			for ($i=0; $i < count($result); $i++) { 
				$data .= "'".$result[$i]['tpgas_nombre']."',";
			}

			if($i == 0){
				$data .= "'0',";
			}

			return substr($data, 0, -1);
		}

		public function montos_categorias_gastos($ano, $mes){
			$data 	= '';

			if(strlen($mes)==1){
				$mess = '0'.$mes;
			}else{
				$mess = $mes;
			}

			$inicio  = $ano.'-'.$mess.'-01';
	    	$final 	 = date("Y-m-t", strtotime($inicio));

			$result = $this->selectQuery("SELECT 	  sum(gastos_empresa.gas_monto) monto   
										  FROM 		  tipo_gastos
										  LEFT JOIN   gastos_empresa
										  ON 		  gastos_empresa.gas_categoria = tipo_gastos.tpgas_id
										  WHERE    	  tipo_gastos.tpgas_estado     = 1
										  AND 		  gastos_empresa.gas_fecha     BETWEEN '$inicio' AND '$final'
										  GROUP BY    gastos_empresa.gas_tipo");

			for ($i=0; $i < count($result); $i++) { 
				$data .= "'".$result[$i]['monto']."',";
			}

			if($i == 0){
				$data .= "'0',";
			}

			return substr($data, 0, -1);
		}

	}

	
?>