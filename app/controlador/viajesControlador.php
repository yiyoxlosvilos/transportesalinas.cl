<?php
ini_set('error_log', __DIR__ . '/php_errors.log');

	require_once __dir__."/../modelo/obtener_datos.php";
	require_once __dir__."/../controlador/utilidadesControlador.php";
	require_once __dir__."/../controlador/recursosControlador.php";
	require_once __dir__."/../controlador/finanzasControlador.php";

	class Viajes extends GetDatos {

		public function __construct(){
			parent::__construct();
	    }

	    public function datos_servicios($idServicio){
	    	$sql    = $this->selectQuery("SELECT * FROM servicios
					   					  WHERE    		serv_id  IN($idServicio)");

	    	return $sql;
	    }

	    public function primer_servicio($idServicio){
	    	$sql = $this->selectQuery("SELECT * FROM fletes
									  WHERE  		 fle_servicio IN($idServicio)
									  AND    		 fle_estado   = 1
									  ORDER BY 		 fle_carga DESC LIMIT 1");
	    	return $sql;
	    }

	    public function ultimo_servicio($idServicio){
	    	$sql = $this->selectQuery("SELECT * FROM fletes
									  WHERE  		 fle_servicio IN($idServicio)
									  AND    		 fle_estado   = 1
									  ORDER BY 		 fle_arribo DESC LIMIT 1");
	    	return $sql;
	    }

	    public function servicios_activos(){
	    	$recursos = new Recursos();
			$html    = '<table width="100%" cellspacing="3" class="border p-2 mt-4 table table-sm table-striped table-responsive" id="servicios_pendientes">
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

			$sql    = $this->selectQuery("SELECT * FROM servicios
					   					  WHERE    		serv_estado = 1
					   					  ORDER BY 		serv_id DESC");
			$j=1;
			for ($i=0; $i < count($sql); $i++) {
				//calulo progreso
				$dias_obra   = 0;
				$dias_espera = 0;

				$nombre_cliente = $recursos->datos_clientes_servicio($sql[$i]['serv_cliente']);
				$datos_flete    = $recursos->datos_fletes($sql[$i]['serv_id']);
				$monto_servicio = $recursos->datos_fletes_monto($sql[$i]['serv_id']);				
				$monto_traslados  = $recursos->datos_traslados_monto($sql[$i]['serv_id']);
				$monto_arriendos  = $recursos->datos_arriendos_monto($sql[$i]['serv_id']);

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

		public function traer_montos_asigandos_listar_informe_tipo($codigo, $tipo){
			$html    = 0;
			$sql     = $this->selectQuery("SELECT      adp_id, adp_usuario, adp_producto_maquinaria, 
													   adp_proyecto, adp_proyecto_temporal, adp_fecha,
													   adp_tipo, adp_estado, adp_comentario, 
													   adp_monto
										    FROM       asignacion_de_proyectos_productos_maquinaria
										    WHERE      adp_proyecto_temporal = '$codigo'
										    AND        adp_tipo              = $tipo");

			for ($i=0; $i < count($sql); $i++) {

				$html += $sql[$i]['adp_monto'];
				
			}

			return $html;
		}

		public function mostrar_detalle_servicio_informe($idServicio){
			$recursos   = new Recursos();
			$finanzas   = new Finanzas();

			$mostrar 	= '';
			$sql 		= $this->datos_servicios($idServicio);

			for ($i=0; $i < count($sql); $i++) {

				$monto_cotizacion = $recursos->datos_cotizacion_monto($sql[$i]['serv_cliente']);
				$monto_servicio   = $recursos->datos_fletes_monto($idServicio);
				$monto_traslados  = $recursos->datos_traslados_monto($idServicio);
				$monto_arriendos  = $recursos->datos_arriendos_monto($idServicio);
				$monto_gastos     = $recursos->datos_gastos_monto($idServicio);
				$monto_facturas   = $recursos->datos_facturas_monto($idServicio);
				$sub_total        = (($monto_servicio+$monto_traslados+$monto_arriendos)-$monto_gastos);

				$mostrar .= '<div class="col-md-15 col-xl-15">
					<div class="row">
						<div class="col border shadow-sm p-3 m-1 bg-white rounded h4">Monto Cotizaci&oacute;n <br><span class="text-dark">'.Utilidades::monto($monto_cotizacion).'</span></div>
						<div class="col border shadow-sm p-3 m-1 bg-white rounded h4">Monto Servicio <br><span class="text-success">'.Utilidades::monto($monto_servicio+$monto_traslados+$monto_arriendos).'</span></div>
						<div class="col border shadow-sm p-3 m-1 bg-white rounded h4">Descto. Gastos<br><span class="text-danger">'.Utilidades::monto($monto_gastos).'</span></div>
						<div class="col border shadow-sm p-3 m-1 bg-white rounded h4">Sub-Total <br><span class="text-primary">'.Utilidades::monto($sub_total).'</span></div>
					</div>
					<hr>
					<div class="row">
				      <div class="row nav nav-pills navbar navbar-expand-lg navbar-light " id="v-pills-tab" aria-orientation="horizontal" role="tablist">
				        <div class="nav-link  col text-center active cursor" data-bs-toggle="tab" href="#home1" role="tab">
				            <span class="mdi mdi-truck-check-outline cursor h5">&nbsp;&nbsp;Fletes</span>
				        </div>
				        <div class="nav-link  col text-center cursor" data-bs-toggle="tab" href="#transporte" role="tab">
				            <span class="mdi mdi-bus cursor h5">&nbsp;&nbsp;Traslados</span>
				        </div>
				        <div class="nav-link  col text-center cursor" data-bs-toggle="tab" href="#arriendos" role="tab">
				            <span class="mdi mdi-truck-outline cursor h5">&nbsp;&nbsp;Arriendos</span>
				        </div>
				        <div class="nav-link col  text-center cursor" data-bs-toggle="tab" href="#profile1" role="tab">
				            <span class="mdi mdi-currency-usd cursor h5">&nbsp;&nbsp;Gastos</span>
				        </div>
				        <div class="nav-link col  text-center cursor" data-bs-toggle="tab" href="#messages1" role="tab">
				        	<span class="mdi mdi-inbox-full h5 cursor">&nbsp;&nbsp;Facturas</span>
				        </div>
				      </div>
				      <div class="tab-content border" id="v-pills-tabContent">
				        <div class="tab-pane active" id="home1" role="tabpanel">
				          <div class="d-flex flex-wrap align-items-center mb-4">
				            <h3 class="text-center text-primary mb-2"><span class="mdi mdi-format-list-bulleted"></span> Detalles Fletes</h3>
				          </div>
				          '.$this->traer_fletes_asigandos($sql[$i]['serv_id']).'
				        </div>
				        <div class="tab-pane" id="transporte" role="tabpanel">
				          <div class="d-flex flex-wrap align-items-center mb-4">
				            <h3 class="text-center text-primary mb-2"><span class="mdi mdi-format-list-bulleted"></span> Detalles Traslados</h3>
				          </div>
				          '.$this->listado_de_traslados($idServicio).'
				        </div>
				        <div class="tab-pane" id="arriendos" role="tabpanel">
				          <div class="d-flex flex-wrap align-items-center mb-4">
				            <h3 class="text-center text-primary mb-2"><span class="mdi mdi-format-list-bulleted"></span> Detalles Arriendos</h3>
				          </div>
				         '.$this->listado_de_arriendo($idServicio).'
				        </div>
				        <div class="tab-pane" id="profile1" role="tabpanel">
				          <div class="d-flex flex-wrap align-items-center mb-4">
				            <h3 class="text-center text-primary mb-2"><span class="mdi mdi-format-list-bulleted"></span> Detalles Gastos</h3>
				          </div>
				          '.$finanzas->listado_gastos(0, 0, $idServicio).'
				        </div>
				        <div class="tab-pane" id="messages1" role="tabpanel">
				          <div class="d-flex flex-wrap align-items-center mb-4">
				            <h3 class="text-center text-primary mb-2"><span class="mdi mdi-format-list-bulleted"></span> Detalles Facturas</h3>
				          </div>
				          <p class="h4">Facturas Proveedores</p>
				          '.$finanzas->listado_facturas_proveedores(0, 0, $idServicio).'
				          <p class="h4">Facturas Clientes</p>
				          '.$finanzas->listado_facturas_clientes($mes, $ano, $idServicio).'
				        </div>
				      </div>
				    </div></div>';

			}

			return $mostrar;
		}

		public function traer_fletes_asigandos($idServicio){
			$recursos= new Recursos();

			$sql     = $this->selectQuery("SELECT * FROM fletes
										   WHERE  		 fle_servicio = $idServicio
										   AND    		 fle_estado   = 1");

			$html    = '<table width="100%" cellspacing="3" class="table table-sm shadow" id="maquinarias">
							<thead>
							<tr class="table-info">
								<th align="left">Fecha&nbsp;Cargu&iacute;o</th>
								<th align="left">Fecha&nbsp;Arribo</th>
								<th align="left">Conductor&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
								<th align="left">Rut&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
								<th align="left">Tracto&nbsp;&nbsp;&nbsp;&nbsp;</th>
								<th align="left">Rampla</th>
								<th align="left">Origen</th>
								<th align="left">Destino</th>
								<th align="left">N&deg;&nbsp;Guia</th>
								<th align="left">Tarifa&nbsp;Flete</th>
								<th align="left">Estadia</th>
								<th align="left">&nbsp;</th>
							</tr>
							</thead>
							<tbody>';

			for ($i=0; $i < count($sql); $i++) {
				$producto   = $recursos->datos_productos($sql[$i]['fle_producto']);
				$rampla     = $recursos->datos_productos($sql[$i]['fle_rampla']);
				$trabajador = $recursos->datos_trabajador($sql[$i]['fle_chofer']);

				$explorar_origen = explode(",", $sql[$i]['fle_origen']);
				if(count($explorar_origen) > 1){
					$nombre_origen = '<ul>';
					for ($o=0; $o < count($explorar_origen); $o++) {
						$origen     	= $recursos->datos_comuna($explorar_origen[$o]);
						$nombre_origen .= '<li>'.$origen[0]['nombre'].'</li>';
					}
					$nombre_origen .= '</ul>';
				}else{
					$origen     	= $recursos->datos_comuna($sql[$i]['fle_origen']);
					$nombre_origen 	= $origen[0]['nombre'];
				}

				$explorar_destino = explode(",", $sql[$i]['fle_destino']);
				if(count($explorar_destino) > 1){
					$nombre_destino = '<ul>';
					for ($d=0; $d < count($explorar_destino); $d++) {
						$destino     	 = $recursos->datos_comuna($explorar_destino[$d]);
						$nombre_destino .= '<li>'.$destino[0]['nombre'].'</li>';
					}
					$nombre_origen .= '</ul>';
				}else{
					$destino     	= $recursos->datos_comuna($sql[$i]['fle_destino']);
					$nombre_destino = $destino[0]['nombre'];
				}

				$html  .= '<tr>
								<td><small>'.Utilidades::arreglo_fecha2($sql[$i]['fle_carga']).'</small></td>
								<td><small>'.Utilidades::arreglo_fecha2($sql[$i]['fle_arribo']).'</small></td>
								<td><small>'.$trabajador[0]['tra_nombre'].'</small></td>
								<td><small>'.Utilidades::rut($trabajador[0]['tra_rut']).'</small></td>
								<td><small>'.$producto[0]['prod_cli_patente'].'</small></td>
								<td><small>'.$rampla[0]['prod_cli_patente'].'</small></td>
								<td><small>'.$nombre_origen.'</small></td>
								<td><small>'.$nombre_destino.'</small></td>
								<td><small>'.$sql[$i]['fle_guia'].'</small></td>
								<td align="center"><small>'.Utilidades::monto3($sql[$i]['fle_valor']).'</small></td>
								<td align="center"><small>'.Utilidades::monto3($sql[$i]['fle_estadia']).'</small></td>
								<td>
									<i class="far fa-eye text-primary ver" href="'.controlador::$rutaAPP.'app/vistas/centro_costo/php/panel_flete.php?idFlete='.$sql[$i]['fle_id'].'" data-fancybox="" data-type="iframe" data-preload="true" data-width="100%" data-height="1200"></i>
								</td>
							</tr>';
				
			}

			$html  .= '</tbody></table>';

			return $html;
		}

		public function traer_fletes_asigandos_print($idServicio){
			$recursos 		= new Recursos();
			$tota_flete 	= 0;
			$total_estaria 	= 0;

			$neto =0;

			$sql     = $this->selectQuery("SELECT * FROM fletes
										   WHERE  		 fle_servicio = $idServicio
										   AND    		 fle_estado   = 1");

			$html    = '<div  style="width:100%;float:left;min-height:550px;" class="border mt-2">
						<table id="maquinarias" class="mt-2 table table-bordered table-sm">
							<thead>
							<tr style="background-color:#e0ebeb;" class="bg-light text-dark border-bottom">
								<th align="left"><small>Fecha&nbsp;Carga</small></th>
								<th align="left"><small>Conductor</small></th>
								<th align="left"><small>Tracto</small></th>
								<th align="left"><small>Rampla</small></th>
								<th align="left"><small>Origen</small></th>
								<th align="left"><small>Destino</small></th>
								<th align="left"><small>N&deg;&nbsp;Guia</small></th>
								<th align="left"><small>Tarifa</small></th>
								<th align="left"><small>Estadia</small></th>
							</tr>
							</thead>
							<tbody>';

			for ($i=0; $i < count($sql); $i++) {
				$producto   = $recursos->datos_productos($sql[$i]['fle_producto']);
				$rampla     = $recursos->datos_productos($sql[$i]['fle_rampla']);
				$trabajador = $recursos->datos_trabajador($sql[$i]['fle_chofer']);
				//$origen     = $recursos->datos_comuna($sql[$i]['fle_origen']);
				//$destino    = $recursos->datos_comuna($sql[$i]['fle_destino']);

				$explorar_origen = explode(",", $sql[$i]['fle_origen']);
				if(count($explorar_origen) > 1){
					$nombre_origen = '<ul>';
					for ($o=0; $o < count($explorar_origen); $o++) {
						$origen     	= $recursos->datos_comuna($explorar_origen[$o]);
						$nombre_origen .= '<li>'.$origen[0]['nombre'].'</li>';
					}
					$nombre_origen .= '</ul>';
				}else{
					$origen     	= $recursos->datos_comuna($sql[$i]['fle_origen']);
					$nombre_origen 	= $origen[0]['nombre'];
				}

				$explorar_destino = explode(",", $sql[$i]['fle_destino']);
				if(count($explorar_destino) > 1){
					$nombre_destino = '<ul>';
					for ($d=0; $d < count($explorar_destino); $d++) {
						$destino     	 = $recursos->datos_comuna($explorar_destino[$d]);
						$nombre_destino .= '<li>'.$destino[0]['nombre'].'</li>';
					}
					$nombre_origen .= '</ul>';
				}else{
					$destino     	= $recursos->datos_comuna($sql[$i]['fle_destino']);
					$nombre_destino .= $destino[0]['nombre'];
				}

				$tota_flete 	+= $sql[$i]['fle_valor'];
				$total_estaria 	+= $sql[$i]['fle_estadia'];
				$neto           += ($total_estaria+$tota_flete);

				$html  .= '<tr>
								<td><small>'.Utilidades::arreglo_fecha2($sql[$i]['fle_carga']).'</small></td>
								<td><small>'.$trabajador[0]['tra_nombre'].'</small></td>
								<td><small>'.$producto[0]['prod_cli_patente'].'</small></td>
								<td><small>'.$rampla[0]['prod_cli_patente'].'</small></td>
								<td><small>'.$nombre_origen.'</small></td>
								<td><small>'.$nombre_destino.'</small></td>
								<td><small>'.$sql[$i]['fle_guia'].'</small></td>
								<td align="center"><small>'.Utilidades::monto3($sql[$i]['fle_valor']).'</small></td>
								<td align="center"><small>'.Utilidades::monto3($sql[$i]['fle_estadia']).'</small></td>
							</tr>';
				
			}

			$iva=($neto*0.19);

			$html .= '</tbody></table>
			</div>';

			return $html;
		}

		public function traer_productos_asigandos_listar_informe_tipo($codigo, $tipo){
			$recursos= new Recursos();

			$sql     = $this->selectQuery("SELECT   adp_id, adp_usuario, adp_producto_maquinaria, 
													adp_proyecto, adp_proyecto_temporal, adp_fecha,
													adp_tipo, adp_estado, adp_comentario, 
													adp_monto
										    FROM    asignacion_de_proyectos_productos_maquinaria
										    WHERE   adp_proyecto_temporal = '$codigo'
										    AND     adp_tipo              = $tipo");

			if($tipo == 3){
				$html    = '<table width="100%" cellspacing="3"  id="chofer">
							<thead>
							<tr class="sombraPlana" style="background-color:#E8F8F5;">
								<th align="left">Nombre</th>
								<th align="left">Cargo</th>
								<th align="left">Monto</th>
								<th align="left">&nbsp;</th>
							</tr>
							</thead>
							<tbody>';
			}elseif($tipo == 4){
				$html    = '<table width="100%" cellspacing="3"  id="facturas">
							<thead>
							<tr class="sombraPlana" style="background-color:#E8F8F5;">
								<th align="left">N&deg; Factura</th>
								<th align="left">Cliente</th>
								<th align="left">Monto</th>
								<th align="left">&nbsp;</th>
							</tr>
							</thead>
							<tbody>';
			}elseif($tipo == 5){
				$html    = '<table width="100%" cellspacing="3"  id="gastos">
							<thead>
							<tr class="sombraPlana" style="background-color:#E8F8F5;">
								<th align="left">Nombre</th>
								<th align="left">Tipo</th>
								<th align="left">Monto</th>
								<th align="left">&nbsp;</th>
							</tr>
							</thead>
							<tbody>';
			}

			for ($i=0; $i < count($sql); $i++) {

				if($tipo == 3){
					$datos_trabajador = $recursos->datos_trabajador($sql[$i]['adp_producto_maquinaria']);

					$html  .= '<tr href="validador_gastos.php?tipo=52&idAsignacion='.$sql[$i]['adp_id'].'" id="cambiazo2" class="fancybox cursor sombraPlana" id="cambiazo2" class="cursor sombraPlana">
								<td><small>'.$datos_trabajador[0]['tra_nombre'].'</small></td>
								<td><small>'.$datos_trabajador[0]['tra_cargo'].'</small></td>
								<td><small>'.Utilidades::monto($sql[$i]['adp_monto']).'</small></td>
								<td><small>'.Utilidades::arreglo_fecha2($sql[$i]['adp_fecha']).'</small></td>
							</tr>';

				}elseif($tipo == 4){
					$datos_facturas = $recursos->datos_facturas_proveedores($sql[$i]['adp_producto_maquinaria']);

					$html  .= '<tr id="cambiazo2" class="cursor sombraPlana">
								<td><small>'.$datos_facturas[0]['fac_folio'].'</small></td>
								<td><small>'.$datos_facturas[0]['proveedor_nombre'].'</small></td>
								<td><small>'.Utilidades::monto($sql[$i]['adp_monto']).'</small></td>
								<td><small>'.Utilidades::arreglo_fecha2($sql[$i]['adp_fecha']).'</small></td>
							</tr>';
				}elseif($tipo == 5){
					$datos_gastos = $recursos->datos_gastos('adp_producto_maquinaria');

					$html  .= '<tr id="cambiazo2" class="cursor sombraPlana">
								<td><small>'.$datos_gastos[0]['tpgas_nombre'].'</small></td>
								<td><small>'.$datos_gastos[0]['tpcom_nombre'].'</small></td>
								<td><small>'.Utilidades::monto($sql[$i]['adp_monto']).'</small></td>
								<td><small>'.Utilidades::arreglo_fecha2($sql[$i]['adp_fecha']).'</small></td>
							</tr>';
				}
				
			}

			$html  .= '</body></table>';

			return $html;
		}

		public function asignar_productos_cotizacion($idProducto){
			$recursos    = new Recursos();

			$html 	     = '<div class="row mt-4">';
			$data        = array();
			$productos   = '';
			$productos_id= '';

			foreach ($idProducto as $key => $value) {
				$data[$key] = $value;
			}

			for ($i = 0; $i < count($data); $i++) {
				$datos_nombre = $recursos->datos_productos($data[$i]);

				$html .= '<div class="row m-1 bg-soft-light">
							<div class="col-sm-4 p-3">
								<h6>Viaje N&deg;:</h6>
								<span class="text-dark">
									'.ucfirst($datos_nombre[0]['prod_cli_producto']).' - '.ucwords($datos_nombre[0]['prod_cli_patente']).'
						  			<input type="hidden" name="idProducto" id="idProducto" value="'.$datos_nombre[0]['prod_cli_id'].'">
						  		</span>
							</div>
							<div class="col-sm-4 p-3 ">
								<h6>Tracto:</h6>
								<span class="text-dark">
									'.ucfirst($datos_nombre[0]['prod_cli_producto']).' - '.ucwords($datos_nombre[0]['prod_cli_patente']).'
						  			<input type="hidden" name="idProducto" id="idProducto" value="'.$datos_nombre[0]['prod_cli_id'].'">
						  		</span>
							</div>
							<div class="col-sm-4 p-3 ">
								<h6>Valor Viaje:</h6>
								<span class="text-dark">
									<input type="text" class="form-control shadow" id="inputFlete" placeholder="Valor" autocomplete="off" value="0">
						  		</span>
							</div>
							<div class="col-sm-4 p-3 ">
								<h6>N&deg; Guia:</h6>
								<span class="text-dark">
									<input type="text" class="form-control shadow" id="inputGuia" placeholder="N&deg; Guia" autocomplete="off">
						  		</span>
							</div>
							<div class="col-sm-6 p-3 ">
								<h6>Origen:</h6>
								<span class="text-dark">
									'.$recursos->seleccionar_localidad(0, 'inputOrigen', 1).'
						  		</span>
							</div>
							<div class="col-sm-6 p-3 ">
								<h6>Destino:</h6>
								<span class="text-dark">
									'.$recursos->seleccionar_localidad(0, 'inputDestino', 1).'
						  		</span>
							</div>
							<div class="col-sm-4 p-3 ">
								<h6>Fecha Carga:</h6>
								<span class="text-dark">
									<input type="date" class="form-control shadow" id="inputCarga" value="'.Utilidades::fecha_hoy().'" autocomplete="off" >
						  		</span>
							</div>
							<div class="col-sm-4 p-3 ">
								<h6>Fecha Arribo:</h6>
								<span class="text-dark">
									<input type="date" class="form-control shadow" id="inputArribo" value="'.Utilidades::fecha_hoy().'" autocomplete="off" >
						  		</span>
							</div>
							<div class="col-sm-4 p-3 ">
								<h6>Fecha Descarga:</h6>
								<span class="text-dark">
									<input type="date" class="form-control shadow" id="inputDescarga" value="'.Utilidades::fecha_hoy().'" autocomplete="off" >
						  		</span>
							</div>
							<div class="col-sm-4 p-3 ">
								<h6>Chofer:</h6>
								<span class="text-dark">
									'.$recursos->seleccionar_trabajadores().'
						  		</span>
							</div>
							<div class="col-sm-4 p-3 ">
								<h6>Semirremolque ?:</h6>
								<div class="row">
									<span class="col">
										<select class="form-control shadow" id="inputRemolque" onchange="semirremolque()">
							  				<option value="0">NO</option>
							  				<option value="1">SI</option>
							  			</select>
							  		</span>
							  		<span class="col" style="display:none;" id="semirremolque">
										'.$recursos->seleccionar_productos_general(2).'
							  		</span>
								</div>
							</div>
							<div class="col-sm-4 p-3 ">
								<h6>Estadia ?:</h6>
								<div class="row">
									<span class="col">
										<select class="form-control shadow" id="inputEstadia" onchange="estadia()">
							  				<option value="0">NO</option>
							  				<option value="1">SI</option>
							  			</select>
							  		</span>
							  		<span class="col" style="display:none;" id="estadia">
										<input type="text" class="form-control shadow" id="inputMontoEstadia" placeholder="Monto Estadia" autocomplete="off" value="0">
							  		</span>
								</div>
							</div>
							<div class="col-sm-12 p-3 ">
								<h6>Descripción del Trabajo:</h6>
								<span class="text-dark">
									<textarea class="form-control shadow" id="inputGlosa" placeholder="Glosa" row="5"></textarea>
						  		</span>
							</div>

							<table class="table border rounded table-striped" align="center" cellpadding="0" cellspacing="0">
						  		<tr>
						  			<th colspan="2">
						  				<div class="row">
						  					<div class="col">
											  	<button type="button" id="grabar" class="btn btn-success form-control shadow" onclick="grabar_flete()">Asignar&nbsp;Flete&nbsp;<i class="fas fa-truck-moving text-dark"></i></button>
											</div>
											<div class="col">
											  	<button type="button" id="grabar" class="btn btn-light form-control shadow" onclick="location.reload()">Cancelar&nbsp;<i class="fas fa-undo text-dark"></i></button>
											</div>
						  				</div>
						  			</th>
						  		</tr>
						  	</table>
					  	</div>';
			}

			$html .= '<div class="col-3 mx-auto" style="display:none;" id="continuar">
					  	<button type="button" id="cancelar" class="btn btn-primary form-control shadow" onclick="parent.location.reload()">Continuar&nbsp;&nbsp;&nbsp;<i class="fas fa-arrow-right"></i></button>
					  </div>';

			return $html;
		}

		public function grabar_flete($idServicio, $idProducto, $inputFlete, $inputGuia, $inputOrigen, $inputDestino, $inputCarga, $inputArribo, $inputTrabajador, $inputRampla, $inputMontoEstadia, $inputGlosa, $inputDescarga){
			$recursos = new Recursos();
			$hoy = Utilidades::fecha_hoy();
			$sql = $this->insert_query("INSERT INTO fletes(fle_servicio, fle_producto, fle_rampla, fle_valor, fle_guia, fle_origen, fle_destino, fle_carga, fle_arribo, fle_chofer, fle_estadia, fle_glosa, fle_creacion, fle_estado, fle_descarga) VALUES('$idServicio', '$idProducto', '$inputRampla', '$inputFlete', '$inputGuia', '$inputOrigen', '$inputDestino', '$inputCarga', '$inputArribo', '$inputTrabajador', '$inputMontoEstadia', '$inputGlosa', '$hoy', 1, '$inputDescarga')");

			//$recursos->cambiar_producto_estado($idProducto, 1);

			if($sql){
                return TRUE;
            }else{
                return FALSE;
            }
		}

		public function formulario_editar_flete($idFlete){
			$recursos    = new Recursos();
			$datos_flete = $recursos->datos_fletes_id($idFlete);

			$html 	     = '<div class="row mt-4">';
			$data        = array();
			$productos   = '';
			$productos_id= '';

			for ($i = 0; $i < count($datos_flete); $i++) {
				$datos_nombre = $recursos->datos_productos($datos_flete[$i]['fle_producto']);

				$html .= '<div class="row shadow-sm">
							<div class="col-sm-4   bg-white ">
								<h6>Tracto:</h6>
								<span class="text-dark">
									'.ucfirst($datos_nombre[0]['prod_cli_producto']).' - '.ucwords($datos_nombre[0]['prod_cli_patente']).'
						  			<input type="hidden" name="idProducto" id="idProducto" value="'.$datos_nombre[0]['prod_cli_id'].'">
						  		</span>
							</div>
							<div class="col-sm-4   bg-white ">
								<h6>Valor Flete:</h6>
								<span class="text-dark">
									<input type="text" class="form-control shadow" id="inputFlete" placeholder="Valor" autocomplete="off" value="'.$datos_flete[$i]['fle_valor'].'">
						  		</span>
							</div>
							<div class="col-sm-4   bg-white ">
								<h6>N&deg; Guia:</h6>
								<span class="text-dark">
									<input type="text" class="form-control shadow" id="inputGuia" placeholder="N&deg; Guia" autocomplete="off" value="'.$datos_flete[$i]['fle_guia'].'">
						  		</span>
							</div>
							<div class="col-sm-6   bg-white ">
								<h6>Origen:</h6>
								<span class="text-dark">
									'.$recursos->seleccionar_localidad2($idFlete, 'inputOrigen', 1).'
						  		</span>
							</div>
							<div class="col-sm-6   bg-white ">
								<h6>Destino:</h6>
								<span class="text-dark">
									'.$recursos->seleccionar_localidad2($idFlete, 'inputDestino', 2).'
						  		</span>
							</div>
							<div class="col-sm-4   bg-white ">
								<h6>Fecha Carga:</h6>
								<span class="text-dark">
									<input type="date" class="form-control shadow" id="inputCarga" value="'.$datos_flete[$i]['fle_carga'].'" autocomplete="off" >
						  		</span>
							</div>
							<div class="col-sm-4   bg-white ">
								<h6>Fecha Arribo:</h6>
								<span class="text-dark">
									<input type="date" class="form-control shadow" id="inputArribo" value="'.$datos_flete[$i]['fle_arribo'].'" autocomplete="off" >
						  		</span>
							</div>
							<div class="col-sm-4   bg-white ">
								<h6>Fecha Descarga:</h6>
								<span class="text-dark">
									<input type="date" class="form-control shadow" id="inputDescarga" value="'.$datos_flete[$i]['fle_descarga'].'" autocomplete="off" >
						  		</span>
							</div>
							<div class="col-sm-4   bg-white ">
								<h6>Chofer:</h6>
								<span class="text-dark">
									'.$recursos->seleccionar_trabajadores($datos_flete[$i]['fle_chofer']).'
						  		</span>
							</div>
							<div class="col-sm-4   bg-white ">
								<h6>Semirremolque:</h6>
								<div class="row">
							  		<span class="col"   id="semirremolque">
										'.$recursos->seleccionar_productos_general(2, $datos_flete[$i]['fle_rampla']).'
							  		</span>
								</div>
							</div>
							<div class="col-sm-4   bg-white ">
								<h6>Estadia:</h6>
								<div class="row">
							  		<span class="col" id="estadia">
										<input type="text" class="form-control shadow" id="inputMontoEstadia" placeholder="Monto Estadia" autocomplete="off" value="'.$datos_flete[$i]['fle_estadia'].'">
							  		</span>
								</div>
							</div>

							<div class="col-sm-12   bg-white ">
								<h6>Descripción del Trabajo:</h6>
								<span class="text-dark">
									<textarea class="form-control shadow" id="inputGlosa" placeholder="Glosa" row="5">'.$datos_flete[$i]['fle_glosa'].'</textarea>
						  		</span>
							</div>

							<table class="table border rounded table-striped" align="center" cellpadding="0" cellspacing="0">
						  		<tr>
						  			<th colspan="2">
						  				<div class="row">
						  					<div class="col">
											  	<button type="button" id="grabar" class="btn btn-success form-control shadow" onclick="editar_flete('.$datos_flete[$i]['fle_id'].')">Editar&nbsp;<i class="fas fa-truck-moving text-dark"></i></button>
											</div>
											<div class="col">
											  	<button type="button" id="grabar" class="btn btn-danger form-control shadow" onclick="quitar_flete('.$datos_flete[$i]['fle_id'].')">Quitar&nbsp;<i class="far fa-window-close text-dark"></i></button>
											</div>
						  				</div>
						  			</th>
						  		</tr>
						  	</table>
					  	</div>';
			}

			return $html;
		}

		public function editar_flete($idFlete, $idProducto, $inputFlete, $inputGuia, $inputOrigen, $inputDestino, $inputCarga, $inputArribo, $inputTrabajador, $inputRampla, $inputMontoEstadia, $inputGlosa, $inputDescarga){
			$hoy = Utilidades::fecha_hoy();
			$sql = $this->update_query("UPDATE 	fletes
										SET    	fle_producto 	= '$idProducto',
												fle_rampla 		= '$inputRampla', 
												fle_valor 		= '$inputFlete', 
												fle_guia 		= '$inputGuia', 
												fle_origen 		= '$inputOrigen', 
												fle_destino 	= '$inputDestino', 
												fle_carga 		= '$inputCarga', 
												fle_arribo 		= '$inputArribo',
												fle_descarga    = '$inputDescarga',
												fle_chofer 		= '$inputTrabajador', 
												fle_estadia 	= '$inputMontoEstadia', 
												fle_glosa 		= '$inputGlosa'
										WHERE   fle_id 			= $idFlete");

			if($sql){
                return TRUE;
            }else{
                return FALSE;
            }
		}

		public function quitar_flete($idFlete){
			$sql = $this->delete_query("DELETE FROM fletes
										WHERE   	fle_id = $idFlete");

			if($sql){
                return TRUE;
            }else{
                return FALSE;
            }
		}

		public function quitar_gasto($idGasto){
			$sql = $this->delete_query("DELETE FROM gastos_empresa
										WHERE   	gas_id = $idGasto");

			if($sql){
                return TRUE;
            }else{
                return FALSE;
            }
		}

		public function cotizacion_servicio($idServicio, $mes, $ano){
	    	$recursos 		 = new Recursos();

	    	$empresa    	 = $recursos->datos_empresa();
	    	$parametros 	 = $recursos->datos_parametros();
	    	$datos_servicios = $this->datos_servicios($idServicio);
	    	$datos_clientes  = $recursos->datos_clientes($datos_servicios[0]['serv_cliente']);
	    	$primer_servicio = $this->primer_servicio($idServicio);
			$ultimo_servicio = $this->ultimo_servicio($idServicio);

	    	$html 	  	= '<div class="row">
			    			<table width="100%" align="center">
								<tr>
									<td width="33.3%">
										 <table style="font-size:14px;" cellpadding="1">
										 	<tr>
										 		<td><small>'.$empresa[0]['emp_razonsocial'].'</small></td>
										 	</tr>
										 	<tr>
										 		<td><small>'.Utilidades::rut($empresa[0]['emp_rut']).'</small></td>
										 	</tr>
										 	<tr>
										 		<td><small>'.$empresa[0]['emp_direccion'].'</small></td>
										 	</tr>
										 </table>
									</td>
									<td width="33.3%">&nbsp;</td>
									<td width="33.3%" align="center">
									<img src="'.controlador::$rutaAPP.'app/recursos/img/'.$parametros[0]['par_logo'].'" width="40%" align="center"></td>
								</tr>
							  </table>
							  <h4 class="text-primary" align="center">'.$datos_servicios[0]['serv_codigo'].'</h4>
							  <table width="100%" align="center"  cellpadding="1">
								<tr>
									<td><b>Raz&oacute;n Social:</b><br><small>'.$datos_servicios[0]['serv_cliente'].'</small></td>
									<td><b>Rut:</b><br><small>'.Utilidades::rut($datos_clientes[0]['cli_rut']).'</small></td>
									<td><b>Giro:</b><br><small>'.Utilidades::rut($datos_clientes[0]['cli_giro']).'</small></td>
									<td class="border"><b>Responsable:</b><br>&nbsp;<small>'.$datos_clientes[0]['cli_reesponsable'].'</small></td>
								</tr>
								<tr>
									<td><b>Fecha de Inicio:</b><br><small>'.Utilidades::arreglo_fecha3($primer_servicio[0]['fle_carga']).'</small></td>
									<td>&nbsp;</td>
									<td><b>Fecha de Término:</b><br>&nbsp;<small>'.Utilidades::arreglo_fecha3($ultimo_servicio[0]['fle_arribo']).'</small></td>
								</tr>
							  </table>';
			$html.= $this->traer_fletes_asigandos_print2($idServicio);
			$html.= $this->listado_de_traslados_print($idServicio);
			$html.= $this->mostrar_listado_de_arriendo_print($idServicio);

	    	return $html;
	    }

	    public function mostrar_listado_de_arriendo_print($idArriendo){
	    	$recursos 	= new Recursos();
	    	$desde      = $ano.'-'.$mes.'-01';
	    	$ultimo_dia = date("t", strtotime($desde));
	    	$hasta  	= $ano.'-'.$mes.'-'.$ultimo_dia;
	    	$hoy        = Utilidades::fecha_hoy();
	    	$neto       = 0;

	    	$sql    	= $this->selectQuery("SELECT * FROM item_arriendo
	    									  LEFT JOIN 	arriendos
	    									  ON 			arriendos.arriendo_id = item_arriendo.item_arriendo_id
										  	  WHERE    		item_arriendo.item_estado     != 0
										  	  AND 			arriendos.arriendo_servicio_id = $idArriendo
										  	  ORDER BY      item_arriendo.item_id ASC");

			$html = ' <table id="listado_facturas_proveedores" class="table table-sm table-bordered mt-2">
			            <thead >
			              	<tr class="table-info">
								<th>IDENTIFICACIÓN CAMIÓN</th>
								<th>HORAS CONTRATADAS</th>
								<th>VALOR HORA</th>
								<th>CANTIDAD DE HORAS REALIZADAS</th>
								<th>VALOR</th>
							</tr>
			            </thead>
			            <tbody>';

			for ($i=0; $i < count($sql); $i++) {
				$cantidad_total = ($sql[$i]['item_valor_hr']*$sql[$i]['item_hr_realizadas']);

				$html .= '<tr>
				          	<td>'.$sql[$i]['item_camion'].'</td>
				          	<td>'.$sql[$i]['item_hrs_contratadas'].'</td>
				          	<td>'.Utilidades::monto($sql[$i]['item_valor_hr']).'</td>
				          	<td>'.$sql[$i]['item_hr_realizadas'].'</td>
				          	<td>'.Utilidades::monto($cantidad_total).'</td>
				          </tr>';

			}


			$html .= ' 
						</tbody>
					  </table>';

			if($i > 0){
				return $html;
			}
	    }

	    public function traer_fletes_asigandos_print2($idServicio){
			$recursos= new Recursos();

			$sql     = $this->selectQuery("SELECT * FROM fletes
										   WHERE  		 fle_servicio = $idServicio
										   AND    		 fle_estado   = 1");

			$html    = '<table width="100%" cellspacing="3" class="table table-sm table-bordered mt-2" id="maquinarias">
							<thead>
							<tr class="table-info">
								<th align="left">Fletes&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
								<th align="left">Conductor&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
								<th align="left">Rut&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
								<th align="left">Tracto&nbsp;&nbsp;&nbsp;&nbsp;</th>
								<th align="left">Origen</th>
								<th align="left">Destino</th>
								<th align="left">N&deg;&nbsp;Guia</th>
								<th align="left">Tarifa&nbsp;Flete</th>
								<th align="left">Estadia</th>
							</tr>
							</thead>
							<tbody>';

			for ($i=0; $i < count($sql); $i++) {
				$producto   = $recursos->datos_productos($sql[$i]['fle_producto']);
				$rampla     = $recursos->datos_productos($sql[$i]['fle_rampla']);
				$trabajador = $recursos->datos_trabajador($sql[$i]['fle_chofer']);

				$explorar_origen = explode(",", $sql[$i]['fle_origen']);
				if(count($explorar_origen) > 1){
					$nombre_origen = '<ul>';
					for ($o=0; $o < count($explorar_origen); $o++) {
						$origen     	= $recursos->datos_comuna($explorar_origen[$o]);
						$nombre_origen .= '<li>'.$origen[0]['nombre'].'</li>';
					}
					$nombre_origen .= '</ul>';
				}else{
					$origen     	= $recursos->datos_comuna($sql[$i]['fle_origen']);
					$nombre_origen 	= $origen[0]['nombre'];
				}

				$explorar_destino = explode(",", $sql[$i]['fle_destino']);
				if(count($explorar_destino) > 1){
					$nombre_destino = '<ul>';
					for ($d=0; $d < count($explorar_destino); $d++) {
						$destino     	 = $recursos->datos_comuna($explorar_destino[$d]);
						$nombre_destino .= '<li>'.$destino[0]['nombre'].'</li>';
					}
					$nombre_origen .= '</ul>';
				}else{
					$destino     	= $recursos->datos_comuna($sql[$i]['fle_destino']);
					$nombre_destino = $destino[0]['nombre'];
				}

				$html  .= '<tr>
								<td><small><b>Carga:</b><br>'.Utilidades::arreglo_fecha2($sql[$i]['fle_carga']).'</small><br><small><b>Arribo:</b><br>'.Utilidades::arreglo_fecha2($sql[$i]['fle_arribo']).'</small><br><small><b>Descarga:</b><br>'.Utilidades::arreglo_fecha2($sql[$i]['fle_descarga']).'</small></td>
								<td><small>'.$trabajador[0]['tra_nombre'].'</small></td>
								<td><small>'.Utilidades::rut($trabajador[0]['tra_rut']).'</small></td>
								<td><small>'.$producto[0]['prod_cli_patente'].'</small></td>
								<td><small>'.$nombre_origen.'</small></td>
								<td><small>'.$nombre_destino.'</small></td>
								<td><small>'.$sql[$i]['fle_guia'].'</small></td>
								<td align="center"><small>'.Utilidades::monto3($sql[$i]['fle_valor']).'</small></td>
								<td align="center"><small>'.Utilidades::monto3($sql[$i]['fle_estadia']).'</small></td>
							</tr>';
				
			}

			$html  .= '</tbody></table>';

			if($i > 0){
				return $html;
			}
		}

	    public function listado_de_traslados_print($idServicio){
	    	$recursos 	= new Recursos();
	    	$desde      = $ano.'-'.$mes.'-01';
	    	$ultimo_dia = date("t", strtotime($desde));
	    	$hasta  	= $ano.'-'.$mes.'-'.$ultimo_dia;
	    	$hoy        = Utilidades::fecha_hoy();
	    	$neto       = 0;
	    	

	    	$sql    	= $this->selectQuery("SELECT * FROM traslados
										  	  WHERE    		traslados_estado     != 0
										  	  AND 			traslados_servicio 	 = $idServicio
										  	  ORDER BY      traslados_id ASC");

			$html = ' <table id="listado_facturas_proveedores" class="table table-sm table-bordered mt-2">
			            <thead >
			              	<tr class="table-info">
								<th>TRASLADO</th>
								<th>CANTIDAD</th>
								<th>FECHA</th>
								<th>VALOR</th>
								<th>TOTAL</th>
							</tr>
			            </thead>
			            <tbody>';

			for ($i=0; $i < count($sql); $i++) {

				$mostrar_localidad 	= '';
		    	$mostrar_fecha 		= '';

				$cantidad_total = ($sql[$i]['traslados_cantidad']*$sql[$i]['traslados_valor']);
				$fechas 		= trim($sql[$i]['traslados_fechas'], ';');
				$explorar_fecha = explode(";", $fechas);
				$explorar_local = explode(",", $sql[$i]['traslados']);
				

				if(count($explorar_fecha) > 0){

					for ($j=0; $j < count($explorar_fecha); $j++) { 

						$cambiar_fecha = explode("-", $explorar_fecha[$j]);

						$mostrar_fecha  .= ''.$cambiar_fecha[2].'-'.$cambiar_fecha[1].', ';
					}
				}

				if(count($explorar_local) > 0){

					for ($k=0; $k < count($explorar_local); $k++) { 
						$mostrar_localidad  .= ''.$recursos->nombre_localidad($explorar_local[$k]).' - ';
					}

				}

				$html .= '<tr>
				          	<td>'.trim($mostrar_localidad, '- ').'</td>
				          	<td>'.$sql[$i]['traslados_cantidad'].'</td>
				          	<td>'.trim($mostrar_fecha, ', ').'</td>
				          	<td>'.Utilidades::monto($sql[$i]['traslados_valor']).'</td>
				          	<td>'.Utilidades::monto($cantidad_total).'</td>
				          </tr>';
				$neto += $cantidad_total;
			}

			$total = ($neto*1.19);
			$iva   = ($total-$neto);

			$html .= ' 
						</tbody>
					  </table>';
			if($i > 0){
				return $html;
			}
			
	    }

	    public function crear_servicio($codigo_servicio, $fecha_inicio, $fecha_termino, $comentario_servicio, $clientes){
	    	$hoy = Utilidades::fecha_hoy();

	    	$sql = $this->insert_query("INSERT INTO servicios(serv_codigo, serv_cliente, serv_comentario, serv_fecha_inicio, serv_fecha_termino, serv_creacion, serv_estado) VALUES('$codigo_servicio', '$clientes', '$comentario_servicio', '$fecha_inicio', '$fecha_termino', '$hoy', 1)");

	    	$sql2= $this->update_query("UPDATE conteo_servicios
				   						SET    cont_ven_correlativo = cont_ven_correlativo+1");

	    	if($sql){
                return $sql2;
            }else{
                return FALSE;
            }
	    }

	    public function mostrar_servicios_asignados($inputServicio){
	    	$recursos = new Recursos();
	    	$html     = '';

	    	foreach ($inputServicio as $key => $value) {
				$data[$key] = $value;
			}

			for ($i = 0; $i < count($data); $i++) {
	    		$html .= $data[$i].",";
			}

			$datos   = "".substr($html, 0, -1)."";

			$listado = $this->traer_fletes_asigandos_grupo($datos);

			return $listado;
	    }

	    public function traer_fletes_asigandos_grupo($idServicio){
			$recursos= new Recursos();

			$tota_flete 	= 0;
			$total_estaria 	= 0;
			$neto          	= 0;

			$sql     = $this->selectQuery("SELECT * FROM fletes
										   WHERE  		 fle_servicio = $idServicio
										   AND    		 fle_estado   = 1");

			$html    = '<table width="100%" cellspacing="3" class="border p-2 mt-4" id="maquinarias" style="font-size:13px;">
							<thead>
							<tr class="table-info">
								<th align="left">Fecha</th>
								<th align="left">Conductor</th>
								<th align="left">Rut</th>
								<th align="left">Tracto</th>
								<th align="left">Rampla</th>
								<th align="left">Origen</th>
								<th align="left">Destino</th>
								<th align="left">N&deg;&nbsp;Guia</th>
								<th align="left">Tarifa</th>
								<th align="left">Estadia</th>
							</tr>
							</thead>
							<tbody>';

			for ($i=0; $i < count($sql); $i++) {
				$producto   = $recursos->datos_productos($sql[$i]['fle_producto']);
				$rampla     = $recursos->datos_productos($sql[$i]['fle_rampla']);
				$trabajador = $recursos->datos_trabajador($sql[$i]['fle_chofer']);
				$origen     = $recursos->datos_comuna($sql[$i]['fle_origen']);
				$destino    = $recursos->datos_comuna($sql[$i]['fle_destino']);

				$explorar_origen = explode(",", $sql[$i]['fle_origen']);
				if(count($explorar_origen) > 1){
					$nombre_origen = '<ul>';
					for ($o=0; $o < count($explorar_origen); $o++) {
						$origen     	= $recursos->datos_comuna($explorar_origen[$o]);
						$nombre_origen .= '<li>'.$origen[0]['nombre'].'</li>';
					}
					$nombre_origen .= '</ul>';
				}else{
					$origen     	= $recursos->datos_comuna($sql[$i]['fle_origen']);
					$nombre_origen 	= $origen[0]['nombre'];
				}

				$explorar_destino = explode(",", $sql[$i]['fle_destino']);
				if(count($explorar_destino) > 1){
					$nombre_destino = '<ul>';
					for ($d=0; $d < count($explorar_destino); $d++) {
						$destino     	 = $recursos->datos_comuna($explorar_destino[$d]);
						$nombre_destino .= '<li>'.$destino[0]['nombre'].'</li>';
					}
					$nombre_origen .= '</ul>';
				}else{
					$destino     	= $recursos->datos_comuna($sql[$i]['fle_destino']);
					$nombre_destino = $destino[0]['nombre'];
				}

				$html  .= '<tr>
								<td><small>'.Utilidades::arreglo_fecha2($sql[$i]['fle_carga']).'</small></td>
								<td><small>'.$trabajador[0]['tra_nombre'].'</small></td>
								<td><small>'.Utilidades::rut($trabajador[0]['tra_rut']).'</small></td>
								<td><small>'.$producto[0]['prod_cli_patente'].'</small></td>
								<td><small>'.$rampla[0]['prod_cli_patente'].'</small></td>
								<td><small>'.$nombre_origen.'</small></td>
								<td><small>'.$nombre_destino.'</small></td>
								<td><small>'.$sql[$i]['fle_guia'].'</small></td>
								<td align="center"><small>'.Utilidades::monto3($sql[$i]['fle_valor']).'</small></td>
								<td align="center"><small>'.Utilidades::monto3($sql[$i]['fle_estadia']).'</small></td>
							</tr>';

				$tota_flete 	+= $sql[$i]['fle_valor'];
				$total_estaria 	+= $sql[$i]['fle_estadia'];
								
			}
			$neto        += ($total_estaria+$tota_flete);
			$iva  	     =  ($neto*0.19);
			$total_pagar = $neto+($iva);

			$html .= '</tbody></table>
					 <input type="hidden" class="neto" id="neto" value="'.$neto.'">
					 <input type="hidden" class="iva" id="iva" value="'.$iva.'">
					 <input type="hidden" class="total_pagar" id="total_pagar" value="'.$total_pagar.'">
					 <table width="40%" align="center" cellspacing="3" id="maquinarias" class="mt-5">
					  <tr class="text-dark">
								<th align="left" class="border-bottom sborder-bottom">Neto</th>
								<th align="left" class="border-bottom sborder-bottom bg-white text-success">'.Utilidades::monto($neto).'</th>
					  </tr>
					  <tr class="text-dark">
								<th align="left" class="border-bottom border-bottom">IVA</th>
								<th align="left" class="border-bottom border-bottom bg-white text-danger">'.Utilidades::monto($iva).'</th>
					  </tr>
					  <tr class="text-dark">
								<th align="left" class="border-bottom border-bottom">Total a Pagar</th>
								<th align="left" class="border-bottom border-bottom bg-white text-dark">'.Utilidades::monto($neto+($iva)).'</th>
					  </tr>';

			$html  .= '</tbody></table>';

			return $html;
		}


		public function datos_edp_id($idEstadoPago){
	    	$sql    = $this->selectQuery("SELECT * FROM estado_de_pago
					   					  WHERE    		edp_id  = $idEstadoPago");

	    	return $sql;
	    }

	    public function primer_servicio_edp($idServicio){
	    	$sql = $this->selectQuery("SELECT * FROM fletes
									  WHERE  		 fle_servicio = $idServicio
									  AND    		 fle_estado   = 1
									  ORDER BY 		 fle_carga DESC LIMIT 1");
	    	return $sql;
	    }

	    public function ultimo_servicio_edp($idServicio){
	    	$sql = $this->selectQuery("SELECT * FROM fletes
									  WHERE  		 fle_servicio = $idServicio
									  AND    		 fle_estado   = 1
									  ORDER BY 		 fle_arribo DESC LIMIT 1");
	    	return $sql;
	    }


		public function mostrar_edp($idEstadoPago){
	    	$recursos 		 = new Recursos();

	    	$empresa    	 = $recursos->datos_empresa();
	    	$parametros 	 = $recursos->datos_parametros();
	    	$datos_serv      = $this->datos_edp_id($idEstadoPago);
	    	$datos_servicios = $this->data_id_pago_servicios($idEstadoPago);
	    	$datos_clientes  = $this->data_servicio_edp($idEstadoPago);


	    	$primer_servicio = $this->primer_servicio($datos_servicios);
			$ultimo_servicio = $this->ultimo_servicio($datos_servicios);

	    	$html 	  	= '<div class="row">
			    			<table width="100%" align="center">
								<tr>
									<td width="33.3%">
										 <table style="font-size:14px;" cellpadding="1">
										 	<tr>
										 		<td><small>'.$empresa[0]['emp_razonsocial'].'</small></td>
										 	</tr>
										 	<tr>
										 		<td><small>'.Utilidades::rut($empresa[0]['emp_rut']).'</small></td>
										 	</tr>
										 	<tr>
										 		<td><small>'.$empresa[0]['emp_direccion'].'</small></td>
										 	</tr>
										 </table>
									</td>
									<td width="33.3%">&nbsp;</td>
									<td width="33.3%" align="center">
									<img src="'.controlador::$rutaAPP.'app/recursos/img/'.$parametros[0]['par_logo'].'" width="40%" align="center"></td>
								</tr>
							  </table>
							  <h4 class="text-success" align="center">'.$datos_serv[0]['edp_codigo'].'</h4>
							  <table width="100%" align="center"  cellpadding="1" class="mt-3">
								<tr>
									<td><b>Raz&oacute;n Social:</b><br><small>'.$datos_clientes[0]['cli_nombre'].'</small></td>
									<td><b>Rut:</b><br><small>'.Utilidades::rut($datos_clientes[0]['cli_rut']).'</small></td>
									<td><b>Giro:</b><br><small>'.$datos_clientes[0]['cli_giro'].'</small></td>
									<td class="border"><b>Responsable:</b><br>&nbsp;<small>'.$datos_clientes[0]['cli_reesponsable'].'</small></td>
								</tr>
								<tr>
									<td><b>Fecha de Inicio:</b><br><small>'.Utilidades::arreglo_fecha3($primer_servicio[0]['fle_carga']).'</small></td>
									<td>&nbsp;</td>
									<td><b>Fecha de Término:</b><br>&nbsp;<small>'.Utilidades::arreglo_fecha3($ultimo_servicio[0]['fle_arribo']).'</small></td>
								</tr>
							  </table>';
			$html.= $this->estado_pago_servicios($idEstadoPago);

	    	return $html;
	    }

	    public function datos_codigo_edp($codigo_edp, $fecha_pago, $hoy, $glosa){
	    	$sql = $this->selectQuery("SELECT * FROM estado_de_pago 
	    							   WHERE 		 edp_codigo 	= '$codigo_edp'
	    							   AND           edp_glosa  	= '$glosa'
	    							   AND           edp_fecha_pago = '$fecha_pago'
	    							   AND 			 edp_creacion   = '$hoy'");

	    	return $sql;
	    }

	    public function procesar_edp($codigo_edp, $glosa, $inputServicio, $fecha_pago){
	    	$hoy = Utilidades::fecha_hoy();

	    	$sql = $this->insert_query("INSERT INTO estado_de_pago(edp_codigo, edp_fecha_pago, edp_glosa, edp_creacion, edp_estado) VALUES ('$codigo_edp', '$fecha_pago', '$glosa', '$hoy', 1)");

	    	if($sql){
	    		$datos_edp 	  = $this->datos_codigo_edp($codigo_edp, $fecha_pago, $hoy, $glosa);
	    		$idEstadoPago = $datos_edp[0]['edp_id'];

	    		foreach ($inputServicio as $key => $value) {
					$data[$key] = $value;
				}

				for ($i = 0; $i < count($data); $i++) {
		    		$this->insert_query("INSERT INTO edp_servicio(edpserv_edp, edpserv_serv, edpserv_estado) 
		    							 VALUES($idEstadoPago, $data[$i], 1)");

		    		$this->update_query("UPDATE servicios
		    							 SET    serv_estado = 2
		    							 WHERE  serv_id 	= $data[$i]");

		    		$this->update_query("UPDATE fletes
		    							 SET    fle_edp 	= $idEstadoPago
		    							 WHERE  fle_servicio= $data[$i]");

		    		$this->update_query("UPDATE conteo_edp
		    							 SET    cont_ven_correlativo = cont_ven_correlativo+1");
				}

	    		return $idEstadoPago;
	    	}else{
	    		return 0;
	    	}
	    }

	    public function data_id_pago_servicios($idEstadoPago){
	    	$html= '';
	    	$sql = $this->selectQuery("SELECT * FROM edp_servicio WHERE edpserv_edp = $idEstadoPago");

	    	for ($i=0; $i < count($sql); $i++) { 
	    		$html .= $sql[$i]['edpserv_serv'].',';
	    	}

	    	$datos   = "".substr($html, 0, -1)."";

			return $datos;
	    }

	    public function estado_pago_servicios($idEstadoPago){
	    	$recursos = new Recursos();
	    	$sql 	  = $this->data_id_pago_servicios($idEstadoPago);

	    	$monto_servicio   = $recursos->datos_fletes_monto($sql);
			$monto_traslados  = $recursos->datos_traslados_monto($sql);
			$monto_arriendos  = $recursos->datos_arriendos_monto($sql);

			$sub_total 	= ($monto_servicio+$monto_traslados+$monto_arriendos);
			$total 		= ($sub_total*1.19);
			$iva   		= ($total-$sub_total);

	    	$listado = $this->traer_fletes_asigandos_print2($sql);
			$listado.= $this->listado_de_traslados_print($sql);
			$listado.= $this->mostrar_listado_de_arriendo_print($sql);

			$listado.= '<table class="table table-striped mt-2">
				          <tr>
				              <td>&nbsp;</td>
				              <th align="right">NETO:</th>
				              <th align="left">'.Utilidades::monto($sub_total).'</th>
				            </tr>
				            <tr>
				              <td>&nbsp;</td>
				              <th align="right">IVA:</th>
				              <th align="left">'.Utilidades::monto($iva).'</th>
				            </tr>
				            <tr>
				              <td>&nbsp;</td>
				              <th align="right">TOTAL:</th>
				              <th align="left">'.Utilidades::monto($total).'</th>
				            </tr>
				            </table>';


			return $listado;
	    }

	    public function traer_fletes_asigandos_edp($idServicio){
			$recursos= new Recursos();

			$tota_flete 	= 0;
			$total_estaria 	= 0;
			$neto          	= 0;

			$xplode = explode(",", $idServicio);

			if(count($xplode) > 1){
				$script = " AND fle_servicio IN($idServicio)";
			}else{
				$script = " AND fle_servicio = $idServicio";
			}

			$sql     = $this->selectQuery("SELECT * FROM fletes
										   WHERE  		 fle_estado   = 1
										   $script");

			$html    = '<table width="100%" cellspacing="3" class="border table table-responsive p-2 mt-4" id="maquinarias" >
							<thead>
							<tr class="bg-soft-info">
								<th align="left">Fecha</th>
								<th align="left">Conductor</th>
								<th align="left">Rut</th>
								<th align="left">Tracto</th>
								<th align="left">Rampla</th>
								<th align="left">Origen</th>
								<th align="left">Destino</th>
								<th align="left">N&deg;&nbsp;Guia</th>
								<th align="left">Tarifa</th>
								<th align="left">Estadia</th>
							</tr>
							</thead>
							<tbody>';

			for ($i=0; $i < count($sql); $i++) {
				$producto   = $recursos->datos_productos($sql[$i]['fle_producto']);
				$rampla     = $recursos->datos_productos($sql[$i]['fle_rampla']);
				$trabajador = $recursos->datos_trabajador($sql[$i]['fle_chofer']);
				$origen     = $recursos->datos_comuna($sql[$i]['fle_origen']);
				$destino    = $recursos->datos_comuna($sql[$i]['fle_destino']);

				$explorar_origen = explode(",", $sql[$i]['fle_origen']);
				if(count($explorar_origen) > 1){
					$nombre_origen = '<ul>';
					for ($o=0; $o < count($explorar_origen); $o++) {
						$origen     	= $recursos->datos_comuna($explorar_origen[$o]);
						$nombre_origen .= '<li>'.$origen[0]['nombre'].'</li>';
					}
					$nombre_origen .= '</ul>';
				}else{
					$origen     	= $recursos->datos_comuna($sql[$i]['fle_origen']);
					$nombre_origen 	= $origen[0]['nombre'];
				}

				$explorar_destino = explode(",", $sql[$i]['fle_destino']);
				if(count($explorar_destino) > 1){
					$nombre_destino = '<ul>';
					for ($d=0; $d < count($explorar_destino); $d++) {
						$destino     	 = $recursos->datos_comuna($explorar_destino[$d]);
						$nombre_destino .= '<li>'.$destino[0]['nombre'].'</li>';
					}
					$nombre_origen .= '</ul>';
				}else{
					$destino     	= $recursos->datos_comuna($sql[$i]['fle_destino']);
					$nombre_destino = $destino[0]['nombre'];
				}

				$html  .= '<tr>
								<td><small>'.Utilidades::arreglo_fecha2($sql[$i]['fle_carga']).'</small></td>
								<td><small>'.$trabajador[0]['tra_nombre'].'</small></td>
								<td><small>'.Utilidades::rut($trabajador[0]['tra_rut']).'</small></td>
								<td><small>'.$producto[0]['prod_cli_patente'].'</small></td>
								<td><small>'.$rampla[0]['prod_cli_patente'].'</small></td>
								<td><small>'.$nombre_origen.'</small></td>
								<td><small>'.$nombre_destino.'</small></td>
								<td><small>'.$sql[$i]['fle_guia'].'</small></td>
								<td align="center"><small>'.Utilidades::monto3($sql[$i]['fle_valor']).'</small></td>
								<td align="center"><small>'.Utilidades::monto3($sql[$i]['fle_estadia']).'</small></td>
							</tr>';

				$tota_flete 	+= $sql[$i]['fle_valor'];
				$total_estaria 	+= $sql[$i]['fle_estadia'];
								
			}
			$neto        += ($total_estaria+$tota_flete);
			$iva  	     =  ($neto*0.19);
			$total_pagar = $neto+($iva);

			$html .= '</tbody></table>
					 <input type="hidden" class="neto" id="neto" value="'.$neto.'">
					 <input type="hidden" class="iva" id="iva" value="'.$iva.'">
					 <input type="hidden" class="total_pagar" id="total_pagar" value="'.$total_pagar.'">
					 <table width="40%" align="center" cellspacing="3" id="maquinarias" class="mt-5">
					  <tr class="text-dark">
								<th align="left" class="border-bottom sborder-bottom">Neto</th>
								<th align="left" class="border-bottom sborder-bottom bg-white text-success">'.Utilidades::monto($neto).'</th>
					  </tr>
					  <tr class="text-dark">
								<th align="left" class="border-bottom border-bottom">IVA</th>
								<th align="left" class="border-bottom border-bottom bg-white text-danger">'.Utilidades::monto($iva).'</th>
					  </tr>
					  <tr class="text-dark">
								<th align="left" class="border-bottom border-bottom">Total a Pagar</th>
								<th align="left" class="border-bottom border-bottom bg-white text-dark">'.Utilidades::monto($neto+($iva)).'</th>
					  </tr>';

			$html  .= '</tbody></table>';

			return $html;
		}

	    public function data_servicio_edp($idEstadoPago){
	    	$sql = $this->selectQuery("SELECT * FROM edp_servicio 
	    							   LEFT JOIN     estado_de_pago
	    							   ON            estado_de_pago.edp_id = edp_servicio.edpserv_edp
	    							   LEFT JOIN     servicios
	    							   ON            servicios.serv_id     = edp_servicio.edpserv_serv
                                       LEFT JOIN     cotizaciones
                                       ON            cotizaciones.coti_id  = servicios.serv_cliente
	    							   LEFT JOIN     clientes
	    							   ON            clientes.cli_id       = cotizaciones.coti_cliente
	    							   WHERE 		 edpserv_edp 		   = $idEstadoPago");

	    	return $sql;
	    }

	    public function panel_centro_costos($cliente_id = 0){
	    	$recursos = new Recursos();
	    	$hoy      = Utilidades::fecha_hoy();

	    	$html= '<div class="row border-bottom">
	    				<div class="col">
	    					<h2 align="center">EDP Pendientes</h2>
	    				</div>
	    				<div class="col">'.$recursos->seleccionar_clientes_disponibles($cliente_id).'</div>
	    			</div>';

	    	if($cliente_id > 0){
	    		$sql = $this->selectQuery(" SELECT * FROM estado_de_pago 
	    									LEFT JOIN edp_servicio 
	    									ON edp_servicio.edpserv_id = estado_de_pago.edp_id 
	    									left join servicios 
	    									ON servicios.serv_id = edp_servicio.edpserv_serv 
	    									left join cotizaciones 
	    									on cotizaciones.coti_id = servicios.serv_cliente 
	    									LEFT JOIN clientes 
	    									on clientes.cli_id = cotizaciones.coti_cliente 
	    									WHERE edp_estado = 1 
	    									AND     clientes.cli_id = $cliente_id
	    									ORDER BY estado_de_pago.edp_creacion ASC");
	    	}else{
	    		$sql = $this->selectQuery("SELECT * FROM estado_de_pago WHERE edp_estado = 1 ORDER BY edp_creacion ASC");
	    	}

	    	$html .= '<table id="centro_costo" class="table display" style="width:100%">
				        <thead>
				            <tr class="bg-soft-light">
				                <th></th>
				                <th>Código</th>
				                <th>Cliente</th>
				                <th>Fecha Creación</th>
				                <th>Fecha Pago</th>
				                <th>Estado EDP</td>
				                <th>&nbsp;</td>
				            </tr>
				        </thead>
				        <tbody>
				        ';

	    	for ($i=0; $i < count($sql); $i++) { 
	    		$datos_clientes  = $this->data_servicio_edp($sql[$i]['edp_id']);

	    		if($datos_clientes[0]['edp_fecha_pago'] < $hoy){
	    			$color = 'text-danger';
	    			$estado= 'Vencido';
	    			$icono = '<span class="fas fa-exclamation-triangle text-danger animate__animated animate__flash animate__infinite animate__slow"></span>';
	    		}elseif($datos_clientes[0]['edp_fecha_pago'] == $hoy){
	    			$color = 'text-info';
	    			$estado= 'Pendiente';
	    			$icono = '<span class="fas fa-clock text-info"></span>';
	    		}else{
	    			$color = 'text-success';
	    			$estado= 'Vigente';
	    			$icono = '<span class="fas fa-check text-success"></span>';
	    		}

	    		$html .= '<tr>
					        	<td><span class="h5 fas fa-folder-plus text-success cursor" onclick="ver_hijo('.$i.')"></span></td>
					        	<td>'.$sql[$i]['edp_codigo'].'</td>
					        	<td>'.$datos_clientes[0]['cli_nombre'].'</td>
					        	<td>'.Utilidades::arreglo_fecha2($datos_clientes[0]['edp_creacion']).'</td>
					        	<td class="'.$color.'">'.Utilidades::arreglo_fecha2($datos_clientes[0]['edp_fecha_pago']).'</td>
					        	<td class="'.$color.'">'.$icono.' '.$estado.'</td>
					        	<td>
					        		<div class="row ">
						            	<div class="col text-center"><span class="h5 far fa-eye text-primary cursor" href="'.controlador::$rutaAPP.'app/vistas/centro_costo/php/panel_edp.php?idEstadoPago='.$sql[$i]['edp_id'].'" data-fancybox data-type="iframe" data-preload="true" data-width="100%" data-height="1300"></span></div>
						                <div class="col text-center"><span class="h5 fas fa-file-pdf text-danger cursor"  href="'.controlador::$rutaAPP.'app/vistas/centro_costo/php/mostrar_edp.php?idEstadoPago='.$sql[$i]['edp_id'].'" data-fancybox data-type="iframe" data-preload="true" data-width="600" data-height="800"></span></div>
						                <div class="col text-center"><span class="h5 fas fa-file-excel text-success cursor" onclick="obtener_informe_edp('.$sql[$i]['edp_id'].')"></span></div>
						            </div>
					            </td>
					        </tr>
					        <tr id="hijo'.$i.'" style="display:none;">
					    		<td colspan="7" class="bg-white">'.$this->estado_pago_servicios($sql[$i]['edp_id']).'</td>
					    	</tr>';
	    	}

	    	$html .= '</tbody></table>';

	    	return $html;
	    }

	   /* public function panel_centro_costos(){
	    	$html= '<h2 align="center">EDP Pendientes</h2>';
	    	$sql = $this->selectQuery("SELECT * FROM estado_de_pago WHERE edp_estado = 1");

	    	for ($i=0; $i < count($sql); $i++) { 
	    		$datos_clientes  = $this->data_servicio_edp($sql[$i]['edp_id']);

	    		$html .= '
	    		<div class="col-md-12 col-xl-6 mt-3 mb-3 border p-2 shadow">

				    <div class="row justify-content-center">
				        <div class="col">
				            <div class="row">
				            	<div class="col"><h5 class="text-left align-middle">C&oacute;digo: <span class="text-primary">'.$sql[$i]['edp_codigo'].'</span></h5></div>
				            	<div class="col"><h5 class="text-left align-middle">Cliente: <span class="text-primary">'.$datos_clientes[0]['cli_nombre'].'</span></h5></div>
				        	</div>
				            <hr>
				            <div class="row ">
				            	<div class="col text-center"><span class="h5 far fa-eye text-primary cursor" href="'.controlador::$rutaAPP.'app/vistas/centro_costo/php/panel_edp.php?idEstadoPago='.$sql[$i]['edp_id'].'" data-fancybox data-type="iframe" data-preload="true" data-width="100%" data-height="1300"></span></div>
				                <div class="col text-center"><span class="h5 fas fa-file-pdf text-danger cursor"  href="'.controlador::$rutaAPP.'app/vistas/centro_costo/php/mostrar_edp.php?idEstadoPago='.$sql[$i]['edp_id'].'" data-fancybox data-type="iframe" data-preload="true" data-width="600" data-height="800"></span></div>
				                <div class="col text-center"><span class="h5 fas fa-file-excel text-success cursor" onclick="obtener_informe_edp('.$sql[$i]['edp_id'].')"></span></div>
				            </div>
				                <hr>
				            <div class="products p-2 table-responsive">
				            	'.$this->servicios_edp($sql[$i]['edp_id']).'
				            </div>
				            </div>
				        </div>
				    </div>
				</div>';
	    	}

	    	return $html;
	    }*/

	    public function mostrar_detalle_servicio_informe_edp($idEstadoPago){
			$recursos   = new Recursos();
			$finanzas   = new Finanzas();

			
			$edp        = $this->data_servicio_edp($idEstadoPago);
			$data       = $this->data_id_pago_servicios($idEstadoPago);
			$sql 		= $this->datos_servicios($data);

			$mostrar 	= '<h2>EDP: '.$edp[0]['edp_codigo'].'</h2><hr>';

			for ($i=0; $i < count($sql); $i++) {

				$monto_servicio = $recursos->datos_fletes_monto($idServicio);
				$monto_gastos   = $recursos->datos_gastos_monto($idServicio);
				$monto_facturas = $recursos->datos_facturas_monto($idServicio);
				$sub_total      = ($monto_servicio-$monto_gastos);
				$nombre_cliente = $recursos->datos_clientes($sql[$i]['serv_cliente']);
				$tipo_pago      = $recursos->tipos_pagos_x_id($sql[$i]['serv_tipo_pago']);

				$mostrar .= '
					<div class="row mt-1 border" style="border:1px;">
						<table width="100%" >
							<tr>
								<td>
									<h2>'.$sql[$i]['serv_codigo'].'</h2>
								</td>
							</tr>
						</table>
						<hr>
						<div class="col p-2 rounded table-responsive" id="listar_productos">
							<table width="100%">
								<tr>
									<td>
										<h3><i class="bi bi-truck-flatbed text-primary"></i> Fletes</h3>
									</td>
								</tr>
							</table>
							'.$this->traer_fletes_asigandos($sql[$i]['serv_id']).'
						</div>
					</div>
					<div class="row mt-1">
						<div class="col p-2 rounded table-responsive" id="listar_productos">
							<table width="100%">
								<tr>
									<td>
										<h3><span class="fas fa-dollar-sign text-primary"></span> Gastos</h3>
									</td>
								</tr>
							</table>
							'.$finanzas->listado_gastos(0, 0, $sql[$i]['serv_id']).'					
						</div>
					</div>
					<div class="row mt-1">
						<div class="col p-2 rounded table-responsive" id="listar_productos">
							<table width="100%">
								<tr>
									<td>
										<h3><span class="fas fa-receipt text-primary"></span> Factura Proveedores</h3>
									</td>
								</tr>
							</table>
							'.$finanzas->listado_facturas_proveedores(0, 0, $sql[$i]['serv_id']).'					
						</div>
					</div><hr>';

			}

			return $mostrar;
		}

		public function finalizar_edp($idUsuario, $idEstadoPago, $fecha_pago, $glosa, $neto, $iva, $total_pagar){
			$hoy    = Utilidades::fecha_hoy();
			$hora   = Utilidades::hora();

			$sql    = $this->insert_query("INSERT INTO caja_cliente(c_cli_tipoMovimiento, c_cli_prod_cliente, c_cli_monto, c_cli_user_cli, c_cli_empresa, c_cli_fecha, c_cli_hora, c_cli_estado, c_cli_lote)
					   						VALUES(3, '$idEstadoPago', '$total_pagar', '$idUsuario', 1, '$hoy', '$hora', 2, '$idEstadoPago')");

			$sql2   = $this->insert_query("INSERT INTO ventascliente(ven_cli_operacion, ven_cli_montoInicial, ven_cli_montoReal, ven_iva, ven_cli_usuario, ven_cli_empresa, ven_cli_fecha, ven_cli_hora, ven_cli_estado) 
					   VALUES('$idEstadoPago', '$total_pagar', '$neto', '$iva', '$idUsuario', 1, '$hoy', '$hora', 1)");

			$sql3   = $this->update_query("UPDATE estado_de_pago 
										   SET    edp_estado 		= 2,
										   		  edp_pagado   		= '$hoy',
										   		  edp_glosa_pago 	= '$glosa'
										   WHERE  edp_id            = $idEstadoPago");

			if($sql || $sql2 || $sql3){
				return TRUE;
			}else{
				return FALSE;
			}
		}


		public function card_info_cliente($idCliente){

	    	$recursos = new Recursos();
	    	$html     = '';

			$sql      = $this->selectQuery("SELECT * FROM clientes
										    WHERE 		  cli_id = $idCliente");

			for ($i=0; $i < count($sql); $i++) {

				$html  .=  '<table class="table table-striped">
				 			<thead>
								<tr>
									<th width="50%" align="left">Raz&oacute;n social:</th>
									<th width="50%" align="left">Rut:</th>
								</tr>
								<tr>
									<td align="left">'.$sql[$i]['cli_nombre'].'</td>
									<td align="left">'.$sql[$i]['cli_rut'].'</td>
								</tr>
								<tr>
									<th width="50%" align="left">E-mail:</th>
									<th width="50%" align="left">Fono:</th>
								</tr>
								<tr>
									<td align="left">'.$sql[$i]['cli_email'].'</td>
									<td align="left">'.$sql[$i]['cli_telefono'].'</td>
								</tr>
								<tr>
									<td>
										<button class="btn btn-primary" onclick="traer_editar_cliente('.$sql[$i]['cli_id'].')">Editar&nbsp;&nbsp;&nbsp;<i class="bi bi-pencil-square"></i></button>
									</td>
									<td>
										<button class="btn btn-danger" onclick="quitar_cliente('.$sql[$i]['cli_id'].')">Quitar&nbsp;&nbsp;&nbsp;<i class="bi bi-trash"></i></button>
									</td>
								</tr>
								</thead>
							</table>';
			}

			return $html;	    	
	    }

	    public function traer_editar_cliente($idCliente){
			$recursos = new Recursos();
	    	$html     = '';

			$sql      = $this->selectQuery("SELECT * FROM clientes
										    WHERE 		  cli_id = $idCliente");

			$data = "validar_rut('finanzas')";

			for ($i=0; $i < count($sql); $i++) {
				$html  .=  '<div class="row mb-4">
							  <p align="left" class="text-info font-weight-light h3">Editar Trabajador</p>
							  <hr class="mt-2 mb-3"/>
							    <div class="container mb-4">
							      <div class="row">
							        <table width="90%" align="center" class="" cellpadding="5" cellspacing="0">
										<tr>
											<td>Rut: <small id="validar_rut"></small></td>
											<td><input type="text" name="inputRut" id="inputRut" class="form-control shadow" onchange="'.$data.'" value="'.$sql[$i]['cli_rut'].'"></td>
										</tr>
										<tr>
											<td>Raz&oacute;n Social: </td>
											<td><input type="text" name="inputRazonSocial" id="inputRazonSocial" class="form-control shadow" value="'.$sql[$i]['cli_nombre'].'"></td>
										</tr>
										<tr>
											<td>Giro: </td>
											<td><input type="text" name="inputGiro" id="inputGiro" class="form-control shadow" value="'.$sql[$i]['cli_giro'].'"></td>
										</tr>
										<tr>
											<td>Tel&eacute;fono: </td>
											<td><input type="text" name="inputTelefono" id="inputTelefono" class="form-control shadow" value="'.$sql[$i]['cli_telefono'].'"></td>
										</tr>
										<tr>
											<td>E-Mail: </td>
											<td><input type="text" name="inputEmail" id="inputEmail" class="form-control shadow" value="'.$sql[$i]['cli_email'].'"></td>
										</tr>
										<tr>
											<td>Direcci&oacute;n: </td>
											<td><input type="text" name="inputDireccion" id="inputDireccion" class="form-control shadow" value="'.$sql[$i]['cli_direccion'].'"></td>
										</tr>
										<tr>
											<td>Localidad: </td>
											<td>
												<input type="text" name="inputLocalidad" id="inputLocalidad" class="form-control shadow" value="'.$sql[$i]['cli_comuna'].'">
											</td>
										</tr>
										<tr>
											<td colspan="2">
												<table  width="50%" align="center">
													<tr>
														<td>
															<button type="button" id="grabar" class="btn btn-success form-control shadow" onclick="grabar_editar_cliente_control('.$sql[$i]['cli_id'].')">Editar <i class="bi bi-save"></i></button>
														</td>
													</tr>
												</table>
											</td>
										</tr>
									</table>
							      </div>
							    </div>
							</div>';
			}

			return $html;
		}

		public function grabar_editar_cliente_control($idCliente, $inputRazonSocial, $inputGiro, $inputRut, $inputTelefono, $inputEmail, $inputDireccion, $inputLocalidad){
			$limpia_rut = Utilidades::limpiaRut($inputRut);

			$sql = $this->update_query("UPDATE clientes 
										SET    cli_nombre  		= '$inputRazonSocial', 
										       cli_giro  		= '$inputGiro', 
											   cli_rut  		= '$limpia_rut', 
											   cli_telefono  	= '$inputTelefono', 
											   cli_direccion 	= '$inputDireccion', 
											   cli_comuna 		= '$inputLocalidad',  
											   cli_email  		= '$inputEmail'
										WHERE  cli_id           = $idCliente");

			if($sql){
				return TRUE;
			}else{
				return FALSE;
			}
		}

		public function quitar_cliente($idCliente){

			$sql = $this->delete_query("DELETE FROM clientes
										WHERE  		cli_id = $idCliente");

			if($sql){
				return TRUE;
			}else{
				return FALSE;
			}
		}

		public function agregar_items_cotizacion($codigo_cotizacion, $titulo_items, $unidad_items, $monto_items, $exento_items){

			$explode_titulo = explode(";", $titulo_items);
			$explode_unidad = explode(";", $unidad_items);
			$explode_monto  = explode(";", $monto_items);
			$explode_exento = explode(";", $exento_items);

			for ($i=0; $i < count($explode_titulo); $i++) { 
				if($explode_monto[$i] > 0){
					$sql2 = $this->insert_query("INSERT INTO item_cotizaciones(item_codigo_cotizacion, item_nombre, item_unidad, item_exento, item_valor, item_estado) 
											 VALUES ('$codigo_cotizacion', '$explode_titulo[$i]', '$explode_unidad[$i]', '$explode_exento[$i]', '$explode_monto[$i]', 1)");
				}
			}


			if($i > 0){
				return TRUE;
			}else{
				return FALSE;
			}
		}

		public function crear_cotizacion($codigo_servicio, $fecha_inicio, $fecha_termino, $comentario_servicio, $clientes, $titulo_items, $unidad_items, $monto_items, $exento_items, $descuentos){
			$recursos 	= new Recursos();
			$comentario = nl2br($comentario_servicio);
			$sql = $this->insert_query("INSERT INTO cotizaciones(coti_codigo, coti_cliente, coti_fecha, coti_vigencia, coti_descuentos, coti_glosa, coti_estado) 
										VALUES ('$codigo_servicio', '$clientes', '$fecha_inicio', '$fecha_termino', '$descuentos', '$comentario', 1)");

			$explode_titulo = explode(";", $titulo_items);
			$explode_unidad = explode(";", $unidad_items);
			$explode_monto  = explode(";", $monto_items);
			$explode_exento = explode(";", $exento_items);

			for ($i=0; $i < count($explode_titulo); $i++) { 
				if($explode_monto[$i] > 0){
					$sql2 = $this->insert_query("INSERT INTO item_cotizaciones(item_codigo_cotizacion, item_nombre, item_unidad, item_exento, item_valor, item_estado) 
											 VALUES ('$codigo_servicio', '$explode_titulo[$i]', '$explode_unidad[$i]', '$explode_exento[$i]', '$explode_monto[$i]', 1)");
				}
			}

			$recursos->upCorrelativoCotizacion();

			if($sql){
				return TRUE;
			}else{
				return FALSE;
			}
		}

		public function quitar_items_cotizacion($idCotizacion){
			
			$sql = $this->delete_query("DELETE FROM item_cotizaciones WHERE item_id = $idCotizacion");


			if($sql){
				return TRUE;
			}else{
				return FALSE;
			}
		}

		public function listado_items_cotizacion($codigo_cotizacion){
	    	$sql 	 = $this->data_id_pago_servicios($codigo_cotizacion);

			$listado = $this->traer_items_cotizacion($codigo_cotizacion);

			return $listado;
	    }

	    public function traer_datos_items_cotizacion($codigo_cotizacion, $tipo){
			$recursos 	 = new Recursos();

			$html    	 = 0;
			$neto    	 = 0;
			$nuevo_monto = 0;

			$dato_cotizacion = $recursos->datos_cotizacion_real_codigo($codigo_cotizacion);

			$sql     = $this->selectQuery("SELECT * FROM item_cotizaciones
										   WHERE  		 item_codigo_cotizacion = '$codigo_cotizacion'
										   AND    		 item_estado            = 1");

			for ($i=0; $i < count($sql); $i++) {
				if($sql[$i]['item_exento'] == 0 || $sql[$i]['item_exento'] == 2){
		    		$neto   += $sql[$i]['item_valor']*$sql[$i]['item_unidad'];
		    	}				
			}

			if($dato_cotizacion[0]['coti_descuentos'] > 0){
				$nuevo_monto += $dato_cotizacion[0]['coti_descuentos'];
			}

			$iva  	     = (($neto-$nuevo_monto)*0.19);
			$total_pagar = (($neto+$iva)-$nuevo_monto);

			switch ($tipo) {
				case 'neto':
					$html    += $neto;
					break;
				case 'iva':
					$html    += $iva;
					break;
				case 'total':
					$html    += $total_pagar;
					break;
				default:
					$html    += 0;
					break;
			}

			return $html;
		}


	    public function traer_items_cotizacion($codigo_cotizacion){
			$recursos= new Recursos();

			$tota_flete 	= 0;
			$total_estaria 	= 0;
			$neto          	= 0;
			$descuentos     = '';

			$dato_cotizacion= $recursos->datos_cotizacion_real_codigo($codigo_cotizacion);

			$sql     = $this->selectQuery("SELECT * FROM item_cotizaciones
										   WHERE  		 item_codigo_cotizacion = '$codigo_cotizacion'
										   AND    		 item_estado            = 1");

			$html    = '<table width="100%" cellspacing="3" class="border p-2 mt-4 table table-striped" id="maquinarias" style="font-size:14px;">
							<thead>
							<tr  >
								<th align="left">N&deg;</th>
								<th align="left">Titulo</th>
								<th align="left">Exento</th>
								<th align="left">Unidad</th>
								<th align="left">Valor</th>
								<th align="left">Total</th>
							</tr>
							</thead>
							<tbody>';
			$j = 1;
			for ($i=0; $i < count($sql); $i++) {

				$html  .= '<tr>
								<td>'.$j++.'</td>
								<td>'.$sql[$i]['item_nombre'].'</td>
								<td>'.Utilidades::estado_exento($sql[$i]['item_exento']).'</td>
								<td>'.$sql[$i]['item_unidad'].'</td>
								<td>'.Utilidades::monto($sql[$i]['item_valor']).'</td>
								<th>'.Utilidades::monto($sql[$i]['item_valor']*$sql[$i]['item_unidad']).'</th>
							</tr>';
				if($sql[$i]['item_exento'] == 0 || $sql[$i]['item_exento'] == 2){
		    		$neto   += $sql[$i]['item_valor']*$sql[$i]['item_unidad'];
		    	}				
			}

			$nuevo_monto = 0;

			if($dato_cotizacion[0]['coti_descuentos'] > 0){
				$descuentos .=' <tr class="text-dark">
									<th align="left" class="border-bottom sborder-bottom">Descuentos</th>
									<th align="left" class="border-bottom sborder-bottom bg-white text-dark">'.Utilidades::monto($dato_cotizacion[0]['coti_descuentos']).'</th>
							  	</tr>
							  	<tr class="text-dark">
									<th align="left" class="border-bottom sborder-bottom">Total</th>
									<th align="left" class="border-bottom sborder-bottom bg-white text-dark">'.Utilidades::monto($neto-$dato_cotizacion[0]['coti_descuentos']).'</th>
							  	</tr>';
				$nuevo_monto += $dato_cotizacion[0]['coti_descuentos'];
			}

			$iva  	     = (($neto-$nuevo_monto)*0.19);
			$total_pagar = (($neto+$iva)-$nuevo_monto);

			$html .= '</tbody></table>
					 <input type="hidden" class="neto" id="neto" value="'.$neto.'">
					 <input type="hidden" class="iva" id="iva" value="'.$iva.'">
					 <input type="hidden" class="descuentos" id="descuentos" value="'.$dato_cotizacion[0]['coti_descuentos'].'">
					 <input type="hidden" class="total_pagar" id="total_pagar" value="'.$total_pagar.'">
					 <table width="40%" align="center" cellspacing="3" id="maquinarias" class="mt-5">
					 	<tr class="text-dark">
							<th align="left" class="border-bottom sborder-bottom">Neto</th>
							<th align="left" class="border-bottom sborder-bottom bg-white text-info">'.Utilidades::monto($neto).'</th>
					  	</tr>
					  	'.$descuentos.'
					  	<tr class="text-dark">
							<th align="left" class="border-bottom border-bottom">IVA</th>
							<th align="left" class="border-bottom border-bottom bg-white text-danger">'.Utilidades::monto($iva).'</th>
					  	</tr>
					  	<tr class="text-dark">
							<th align="left" class="border-bottom border-bottom">Total a Pagar</th>
							<th align="left" class="border-bottom border-bottom bg-white text-success">'.Utilidades::monto($total_pagar).'</th>
					  	</tr>';

			$html  .= '</tbody></table>';

			return $html;
		}

		public function panel_cotizaciones(){
			$html 	  = '';
			$recursos = new Recursos();

			$html    = '<table width="100%" cellspacing="3" class="border p-2 mt-4 table table-sm table-striped table-responsive" id="cotizaciones_pendientes">
							<thead>
							<tr  >
								<th align="left">N&deg;</th>
								<th align="left">Codigo</th>
								<th align="left">Fecha</th>
								<th align="left">Vigencia</th>
								<th align="left">Cliente</th>
								<th align="left">Glosa</th>
								<th align="left">Total</th>
								<th align="left">&nbsp;</th>
							</tr>
							</thead>
							<tbody>';

			$inicio  = Utilidades::fecha_ano()."-".Utilidades::fecha_mes()."-01";
	    	$final 	 = date("Y-m-t", strtotime($inicio));

	    	$sql 	  = $this->selectQuery("SELECT * FROM 	cotizaciones 
	    									WHERE 			coti_estado = 1
	    									ORDER BY        coti_id DESC");
	    	$j=1;
	    	for ($i=0; $i < count($sql); $i++) { 
	    		$datos_clientes  = $recursos->datos_clientes($sql[$i]['coti_cliente']);

	    		$dato_cotizacion = $recursos->datos_cotizacion_real_codigo($sql[$i]['coti_codigo']);

	    		$html .= '

	    			<tr>
						<td align="left">'.$j++.'</td>
						<td align="left">'.$sql[$i]['coti_codigo'].'</td>
						<td align="left">'.Utilidades::arreglo_fecha2($sql[$i]['coti_fecha']).'</td>
						<td align="left">'.Utilidades::arreglo_fecha2($sql[$i]['coti_vigencia']).'</td>
						<td align="left">'.$datos_clientes[0]['cli_nombre'].'</td>
						<td align="left" style="font-size:14px;">'.$sql[$i]['coti_glosa'].'</td>
						<td align="left">'.Utilidades::monto($this->traer_datos_items_cotizacion($sql[$i]['coti_codigo'], 'total')).'</td>
						<td align="left">
							<div class="col text-center"><span class="p-2 far fa-eye text-primary cursor" href="'.controlador::$rutaAPP.'app/vistas/centro_costo/php/ver_cotizacion.php?idCotizacion='.$sql[$i]['coti_id'].'" data-fancybox data-type="iframe" data-preload="true" data-width="100%" data-height="1300"></span></div>
				            <div class="col text-center"><span class="p-2 fas fa-file-pdf text-danger cursor"  href="'.controlador::$rutaAPP.'app/vistas/centro_costo/php/cotizacion_ver.php?idCotizacion='.$sql[$i]['coti_id'].'" data-fancybox data-type="iframe" data-preload="true" data-width="600" data-height="800"></span></div>
						</td>
					</tr>';
	    	}

	    	$html .= '</tbody>
	    			</table>';

	    	return $html;
			/*$html 	  = '';
			$recursos = new Recursos();
	    	$sql 	  = $this->selectQuery("SELECT * FROM cotizaciones WHERE coti_estado = 1");

	    	for ($i=0; $i < count($sql); $i++) { 
	    		$datos_clientes  = $recursos->datos_clientes($sql[$i]['coti_cliente']);

	    		$html .= '

	    			<div class="col-md-12 col-xl-12 border mb-2">
                        <div class="card">
                        	<div class="card-block">
                            	<h4 class="text-center">C&oacute;digo: <span class="text-danger">'.$sql[$i]['coti_codigo'].'</span></h4>
                            	<div class="row">
                                	<div class="col-6">
                                    	<h6 class="text-dark f-w-300 mt-4">Cliente:</h6>
                                	</div>
                           			<div class="col-6">
                                    	<h6 class="text-dark f-w-300 mt-4">'.$datos_clientes[0]['cli_nombre'].'</h6>
                             		</div>
                            	</div>
                             	<div class="products p-2">
				                	'.$this->listado_items_cotizacion($sql[$i]['coti_codigo']).'
				            	</div>
                    	</div>
                            <div class="row">
                                <div class="col text-center"><span class="h5 far fa-eye text-primary cursor" href="'.controlador::$rutaAPP.'app/vistas/centro_costo/php/ver_cotizacion.php?idCotizacion='.$sql[$i]['coti_id'].'" data-fancybox data-type="iframe" data-preload="true" data-width="100%" data-height="1300"></span></div>
				                <div class="col text-center"><span class="h5 fas fa-file-pdf text-danger cursor"  href="'.controlador::$rutaAPP.'app/vistas/centro_costo/php/cotizacion_ver.php?idCotizacion='.$sql[$i]['coti_id'].'" data-fancybox data-type="iframe" data-preload="true" data-width="600" data-height="800"></span></div>
                            </div>
                        </div>
                    </div>';
	    	}

	    	return $html;*/
	    }

	    public function listado_items_cotizacion_quitar($codigo_cotizacion){
	    	$sql 	 = $this->data_id_pago_servicios($codigo_cotizacion);

			$listado = $this->traer_items_cotizacion_quitar($codigo_cotizacion);

			return $listado;
	    }

	    public function traer_items_cotizacion_quitar($codigo_cotizacion){
			$recursos= new Recursos();

			$tota_flete 	= 0;
			$total_estaria 	= 0;
			$neto          	= 0;
			$descuentos     = '';

			$dato_cotizacion= $recursos->datos_cotizacion_real_codigo($codigo_cotizacion);

			$sql     = $this->selectQuery("SELECT * FROM item_cotizaciones
										   WHERE  		 item_codigo_cotizacion = '$codigo_cotizacion'
										   AND    		 item_estado            = 1");

			$html    = '<table  class="border p-2 mt-4 table table-striped table-responsive" id="maquinarias" style="font-size:14px;">
							<thead>
							<tr  >
								<th align="left">N&deg;</th>
								<th align="left">Titulo</th>
								<th align="left">Exento</th>
								<th align="left">Unidad</th>
								<th align="left">Valor</th>
								<th align="left">Total</th>
								<th align="left">&nbsp;</th>
								<th align="left">&nbsp;</th>
							</tr>
							</thead>
							<tbody>';
			$j =1;
			for ($i=0; $i < count($sql); $i++) {

				$html  .= '<tr>
								<td>'.$j++.'</td>
								<td>'.$sql[$i]['item_nombre'].'</td>
								<td>'.Utilidades::estado_exento($sql[$i]['item_exento']).'</td>
								<td>'.$sql[$i]['item_unidad'].'</td>
								<td>'.Utilidades::monto($sql[$i]['item_valor']).'</td>
								<th>'.Utilidades::monto($sql[$i]['item_valor']*$sql[$i]['item_unidad']).'</th>
								<td><i class="bi bi-pencil-square text-primary cursor" onclick="traer_editar_items_cotizacion('.$sql[$i]['item_id'].')"></i></td>
								<td><span class="fas fa-trash text-danger cursor" onclick="quitar_items_cotizacion('.$sql[$i]['item_id'].')"></span></td>
							</tr>';

				if($sql[$i]['item_exento'] == 0 || $sql[$i]['item_exento'] == 2){
		    		$neto   += ($sql[$i]['item_valor']*$sql[$i]['item_unidad']);
		    	}		
			}


			$nuevo_monto = 0;

			if($dato_cotizacion[0]['coti_descuentos'] > 0){
				$descuentos .=' <tr class="text-dark">
									<th align="left" class="border-bottom sborder-bottom">Descuentos</th>
									<th align="left" class="border-bottom sborder-bottom bg-white text-dark">'.Utilidades::monto($dato_cotizacion[0]['coti_descuentos']).'</th>
							  	</tr>
							  	<tr class="text-dark">
									<th align="left" class="border-bottom sborder-bottom">Total</th>
									<th align="left" class="border-bottom sborder-bottom bg-white text-dark">'.Utilidades::monto($neto-$dato_cotizacion[0]['coti_descuentos']).'</th>
							  	</tr>';
				$nuevo_monto += $dato_cotizacion[0]['coti_descuentos'];
			}

			$iva  	     = (($neto-$nuevo_monto)*0.19);
			$total_pagar = (($neto+$iva)-$nuevo_monto);

			$html .= '</tbody></table>
					 <input type="hidden" class="neto" id="neto" value="'.$neto.'">
					 <input type="hidden" class="iva" id="iva" value="'.$iva.'">
					 <input type="hidden" class="total_pagar" id="total_pagar" value="'.$total_pagar.'">
					 <table width="40%" align="center" cellspacing="3" id="maquinarias" class="mt-5">
					 	<tr class="text-dark">
							<th align="left" class="border-bottom sborder-bottom">Neto</th>
							<th align="left" class="border-bottom sborder-bottom bg-white text-success">'.Utilidades::monto($neto).'</th>
					  	</tr>
					  	'.$descuentos.'
					  	<tr class="text-dark">
							<th align="left" class="border-bottom border-bottom">IVA</th>
							<th align="left" class="border-bottom border-bottom bg-white text-danger">'.Utilidades::monto($iva).'</th>
					  	</tr>
					  	<tr class="text-dark">
							<th align="left" class="border-bottom border-bottom">Total a Pagar</th>
							<th align="left" class="border-bottom border-bottom bg-white text-primary">'.Utilidades::monto($total_pagar).'</th>
					  	</tr>';

			$html  .= '</tbody></table>';

			return $html;
		}

		public function aceptar_cotizacion($idCotizacion){

			$sql = $this->update_query("UPDATE cotizaciones 
										SET    coti_estado = 2
										WHERE  coti_id = $idCotizacion");


			if($sql){
				return TRUE;
			}else{
				return FALSE;
			}
		}

		public function rechazar_cotizacion($idCotizacion){

			$sql = $this->update_query("UPDATE cotizaciones 
										SET    coti_estado = 0
										WHERE  coti_id     = $idCotizacion");


			if($sql){
				return TRUE;
			}else{
				return FALSE;
			}
		}

		public function cotizacion_clientes_ver($idCotizacion, $mes, $ano){
	    	$recursos 		  = new Recursos();

	    	$datos_cotizacion = $recursos->datos_cotizacion_id($idCotizacion);
  			$datos_clientes   = $recursos->datos_clientes($datos_cotizacion[0]['coti_cliente']);

  			$anexos_datos     = $recursos->datos_cotizacion_anexos($idCotizacion);

	    	$empresa    	  = $recursos->datos_empresa();
	    	$parametros 	  = $recursos->datos_parametros();

	    	$html 	  	= '<div class="row">
			    			<table width="100%" align="center">
								<tr>
									<td width="33.3%">
										 <table style="font-size:14px;" cellpadding="1">
										 	<tr>
										 		<td><small>'.$empresa[0]['emp_razonsocial'].'</small></td>
										 	</tr>
										 	<tr>
										 		<td><small>'.Utilidades::rut($empresa[0]['emp_rut']).'</small></td>
										 	</tr>
										 	<tr>
										 		<td><small>'.$empresa[0]['emp_direccion'].'</small></td>
										 	</tr>
										 </table>
									</td>
									<td width="33.3%">&nbsp;</td>
									<td width="33.3%" align="center">
									<img src="'.controlador::$rutaAPP.'app/recursos/img/'.$parametros[0]['par_logo'].'" width="40%" align="center"></td>
								</tr>
							  </table>
							  <h4 class="text-primary" align="center">Cotizaci&oacute;n N&deg;: '.$datos_cotizacion[0]['coti_codigo'].'</h4>
							  <table width="100%" align="center" class="border table" cellpadding="1">
								<tr>
									<td><b>Raz&oacute;n Social:</b><br><small>'.$datos_clientes[0]['cli_nombre'].'</small></td>
									<td><b>Rut:</b><br><small>'.Utilidades::rut($datos_clientes[0]['cli_rut']).'</small></td>
									<td><b>Giro:</b><br><small>'.$datos_clientes[0]['cli_giro'].'</small></td>
									<td><b>Fecha:</b><br><small>'.Utilidades::arreglo_fecha2($datos_cotizacion[0]['coti_fecha']).'</small></td>
									<td><b>Valido Hasta:</b><br><small>'.Utilidades::arreglo_fecha2($datos_cotizacion[0]['coti_vigencia']).'</small></td>
								</tr>
							  </table>';
			$html.= '<div class="row">';
			$html.= $this->traer_items_cotizacion_print($datos_cotizacion[0]['coti_codigo']);
			$html.= '</div>';

			$html.= '<table width="100%" align="center" class="border table" cellpadding="1">
						<tr>
							<td align="center"><b>Terminos y Condiciones:</b></td>
						</tr>
						<tr>
							<td><p class="text-justify">'.str_replace('.', '. ', $datos_cotizacion[0]['coti_glosa']).'</p></td>
						</tr>
					</table>';

			if(count($anexos_datos) > 0){
				$html.= '<div style="page-break-after: always;"></div>';
				$html.= '<table width="100%" align="center" class="border table" cellpadding="1">
							<tr>
								<td align="center"><b>Anexos Cotizaci&oacute;n:</b></td>
							</tr>
						</table>
						<div class="row">';

						for ($i=0; $i < count($anexos_datos); $i++) { 
							$html .= '<div class="col-6"><img src="'.controlador::$rutaAPP.'app/repositorio/documento_edp/'.$anexos_datos[$i]['doc_ruta'].'" class="img-thumbnail"></div>';
						}

				$html.= '</div>';
			}

	    	return $html;
	    }

	    public function traer_items_cotizacion_print($codigo_cotizacion){
			$recursos= new Recursos();

			$tota_flete 	= 0;
			$total_estaria 	= 0;
			$neto          	= 0;
			$descuentos     = '';

			$dato_cotizacion= $recursos->datos_cotizacion_real_codigo($codigo_cotizacion);

			$sql     = $this->selectQuery("SELECT * FROM item_cotizaciones
										   WHERE  		 item_codigo_cotizacion = '$codigo_cotizacion'
										   AND    		 item_estado            = 1");

			$html    = '<table width="100%" cellspacing="3" class="border p-2 mt-4 table table-striped table-responsive" id="maquinarias" style="font-size:14px;">
							<thead>
							<tr  >
								<th align="left">N&deg;</th>
								<th align="left">Titulo</th>
								<th align="left">Unidad</th>
								<th align="left">Valor</th>
								<th align="left">Total</th>
							</tr>
							</thead>
							<tbody>';
			$j =1;
			for ($i=0; $i < count($sql); $i++) {

				$html  .= '<tr>
								<td>'.$j++.'</td>
								<td>'.$sql[$i]['item_nombre'].'</td>
								<td>'.$sql[$i]['item_unidad'].'</td>
								<td>'.Utilidades::monto($sql[$i]['item_valor']).'</td>
								<th>'.Utilidades::monto($sql[$i]['item_valor']*$sql[$i]['item_unidad']).'</th>
							</tr>';
				if($sql[$i]['item_exento'] == 0 || $sql[$i]['item_exento'] == 2){
		    		$neto   += $sql[$i]['item_valor']*$sql[$i]['item_unidad'];
		    	}		
			}

			$nuevo_monto = 0;

			if($dato_cotizacion[0]['coti_descuentos'] > 0){
				$descuentos .=' <tr class="text-dark">
									<td>&nbsp;</td>
									<td>&nbsp;</td>
									<th align="left" class="border-bottom sborder-bottom">Descuentos</th>
									<th align="left" class="border-bottom sborder-bottom bg-white text-dark">'.Utilidades::monto($dato_cotizacion[0]['coti_descuentos']).'</th>
							  	</tr>
							  	<tr class="text-dark">
							  		<td>&nbsp;</td>
							  		<td>&nbsp;</td>
									<th align="left" class="border-bottom sborder-bottom">Total</th>
									<th align="left" class="border-bottom sborder-bottom bg-white text-dark">'.Utilidades::monto($neto-$dato_cotizacion[0]['coti_descuentos']).'</th>
							  	</tr>';
				$nuevo_monto += $dato_cotizacion[0]['coti_descuentos'];
			}

			$iva  	     = (($neto-$nuevo_monto)*0.19);
			$total_pagar = (($neto+$iva)-$nuevo_monto);

			$html .= '</tbody></table>
					 <table align="center" cellspacing="3" id="maquinarias" class="table border col-md-3">
					 	<tr class="text-dark">
						 	<td>&nbsp;</td>
						 	<td>&nbsp;</td>
							<th align="left" class="border-bottom sborder-bottom">Neto</th>
							<th align="left" class="border-bottom sborder-bottom bg-white text-success">'.Utilidades::monto($neto).'</th>
					  	</tr>
					  	'.$descuentos.'
					  	<tr class="text-dark">
					  		<td>&nbsp;</td>
						 	<td>&nbsp;</td>
							<th align="left" class="border-bottom border-bottom">IVA 19%</th>
							<th align="left" class="border-bottom border-bottom bg-white text-danger">'.Utilidades::monto($iva).'</th>
					  	</tr>
					  	<tr class="text-dark">
					  		<td>&nbsp;</td>
						 	<td>&nbsp;</td>
							<th align="left" class="border-bottom border-bottom">Total a Pagar</th>
							<th align="left" class="border-bottom border-bottom bg-white text-primary">'.Utilidades::monto($total_pagar).'</th>
					  	</tr>';

			$html  .= '</tbody></table>';

			return $html;
		}

		public function panel_cotizaciones_aceptadas(){
			$html 	  = '';
			$recursos = new Recursos();

			$html    = '<table width="100%" cellspacing="3" class="border p-2 mt-4 table table-sm table-striped table-responsive" id="cotizaciones_aceptados">
							<thead>
							<tr  >
								<th align="left">N&deg;</th>
								<th align="left">Codigo</th>
								<th align="left">Fecha</th>
								<th align="left">Vigencia</th>
								<th align="left">Cliente</th>
								<th align="left">Glosa</th>
								<th align="left">Total</th>
								<th align="left">&nbsp;</th>
							</tr>
							</thead>
							<tbody>';

			$inicio  = Utilidades::fecha_ano()."-".Utilidades::fecha_mes()."-01";
	    	$final 	 = date("Y-m-t", strtotime($inicio));

	    	$sql 	  = $this->selectQuery("SELECT * FROM 	cotizaciones 
	    									WHERE 			coti_estado = 2
	    									ORDER BY        coti_id DESC");
	    	$j=1;
	    	for ($i=0; $i < count($sql); $i++) { 
	    		$datos_clientes  = $recursos->datos_clientes($sql[$i]['coti_cliente']);

	    		$dato_cotizacion = $recursos->datos_cotizacion_real_codigo($sql[$i]['coti_codigo']);

	    		$html .= '

	    			<tr>
						<td align="left">'.$j++.'</td>
						<td align="left">'.$sql[$i]['coti_codigo'].'</td>
						<td align="left">'.Utilidades::arreglo_fecha2($sql[$i]['coti_fecha']).'</td>
						<td align="left">'.Utilidades::arreglo_fecha2($sql[$i]['coti_vigencia']).'</td>
						<td align="left">'.$datos_clientes[0]['cli_nombre'].'</td>
						<td align="left" style="font-size:14px;">'.$sql[$i]['coti_glosa'].'</td>
						<td align="left">'.Utilidades::monto($this->traer_datos_items_cotizacion($sql[$i]['coti_codigo'], 'total')).'</td>
						<td align="left">
							<div class="col text-center"><span class="p-2 far fa-eye text-primary cursor" href="'.controlador::$rutaAPP.'app/vistas/centro_costo/php/ver_cotizacion.php?idCotizacion='.$sql[$i]['coti_id'].'" data-fancybox data-type="iframe" data-preload="true" data-width="100%" data-height="1300"></span></div>
				            <div class="col text-center"><span class="p-2 fas fa-file-pdf text-danger cursor"  href="'.controlador::$rutaAPP.'app/vistas/centro_costo/php/cotizacion_ver.php?idCotizacion='.$sql[$i]['coti_id'].'" data-fancybox data-type="iframe" data-preload="true" data-width="600" data-height="800"></span></div>
						</td>
					</tr>';
	    	}

	    	$html .= '</tbody>
	    			</table>';

	    	return $html;
	    }

	    public function traer_editar_cotizacion($idCotizacion){
	    	$html             = '';
	    	$recursos 		  = new Recursos();
	    	$datos_cotizacion = $recursos-> datos_cotizacion_id($idCotizacion);

	    	for ($i=0; $i < count($datos_cotizacion); $i++) { 
	    		$html .= '<table width="100%" align="center" cellpadding="4" cellspacing="4" class="table bg-soft-info">
	    					<tr>
	    						<td colspan="2"><h4 class="text-primary">Editar Cotizacion</h4></td>
	    					</tr>
				        <tr>
				          <td colspan="2" class="bold"><b>Seleccionar Cliente:</b>
				            '.$recursos->select_clientes($datos_cotizacion[$i]['coti_cliente']).'
				          </td>
				        </tr>
				        <tr>
				          <td  class="bold"><b>Fecha cotizaci&oacute;n:</b>
				            <input type="date" name="fecha_inicio" id="fecha_inicio" value="'.$datos_cotizacion[$i]['coti_fecha'].'" class="form-control ">
				          </td>
				          <td  class="bold"><b>Fecha Vigencia:</b>
				            <input type="date" name="fecha_termino" id="fecha_termino" value="'.$datos_cotizacion[$i]['coti_vigencia'].'" class="form-control ">
				          </td>
				        </tr>
				        <tr>
				          <td  class="bold"><b>Descuentos:</b></td>
				          <td>
				            <input type="number" name="descuentos" id="descuentos" value="'.$datos_cotizacion[$i]['coti_descuentos'].'" class="form-control ">
				          </td>
				        </tr>
				        <tr>
				          <td colspan="2" class="bold"><b>T&eacute;rminos y condiciones:</b>
				            <textarea name="comentario_servicio" id="comentario_servicio" class="form-control ">'.$datos_cotizacion[$i]['coti_glosa'].'</textarea>
				          </td>
				        </tr>
				        <tr>
				        	<td>
				        		<button type="button" id="grabar" class="btn btn-info form-control shadow" onclick="grabar_editar_cotizacion('.$idCotizacion.')">Editar <i class="bi bi-save"></i></button>
				        	</td>
				        	<td>
				        		<button type="button" id="grabar" class="btn btn-dark form-control shadow" onclick="location.reload()">Cancelar <i class="bi bi-save"></i></button>
				        	</td>
				        </tr>
				      </table>';
	    	}

	    	return $html;	    	
	    }

	    public function grabar_editar_cotizacion($idCotizacion, $fecha_inicio, $fecha_termino, $comentario_servicio, $clientes, $descuentos){
	    
			$sql = $this->update_query("UPDATE 	cotizaciones
										SET    	coti_cliente    = '$clientes',
												coti_fecha		= '$fecha_inicio',
												coti_vigencia   = '$fecha_termino',
												coti_descuentos = '$descuentos',
												coti_glosa      = '$comentario_servicio'
										WHERE   coti_id  		= $idCotizacion");

			if($sql){
                return TRUE;
            }else{
                return FALSE;
            }
	    }

	    public function traer_editar_items_cotizacion($idItems){
	    	$html             = '';
	    	$recursos 		  = new Recursos();
	    	$datos_cotizacion = $recursos->datos_items_cotizacion_id($idItems);

	    	for ($i=0; $i < count($datos_cotizacion); $i++) { 
	    		$html .= '<table class="table table-bordered bg-soft-info" id="listar_productos">
				            <tr>
				                <td>Nombre:<br><input type="text" name="titulo" id="titulo" placeholder="Nombre" class="form-control titulo_list" value="'.$datos_cotizacion[$i]['item_nombre'].'" /></td>
				                <td>Unidad:<br><input type="number" name="unidad" id="unidad" placeholder="Unidad" class="form-control monto_list" value="'.$datos_cotizacion[$i]['item_unidad'].'" /></td>
				            </tr>
					        <tr>
				                <td>¿Exento?:<br>'.Utilidades::select_exento($datos_cotizacion[$i]['item_exento']).'</td>
				                <td>Monto:<br><input type="number" name="monto" id="monto" placeholder="Valor" class="form-control monto_list" value="'.$datos_cotizacion[$i]['item_valor'].'" /></td>
				            </tr>
					        <tr>
					        	<td>
					        		<button type="button" id="grabar" class="btn btn-info form-control shadow" onclick="grabar_editar_items_cotizacion('.$idItems.')">Editar <i class="bi bi-save"></i></button>
					        	</td>
					        	<td>
					        		<button type="button" id="grabar" class="btn btn-dark form-control shadow" onclick="location.reload()">Cancelar <i class="bi bi-save"></i></button>
					        	</td>
					        </tr>
					      </table>';
	    	}

	    	return $html;	
	    }

	    public function grabar_editar_items_cotizacion($idItems, $titulo, $unidad, $monto, $exento){
	    	$sql = $this->update_query("UPDATE 	item_cotizaciones
										SET    	item_nombre     = '$titulo',
												item_unidad		= '$unidad',
												item_valor      = '$monto',
												item_exento     = '$exento'
										WHERE   item_id  		= $idItems");

			if($sql){
                return TRUE;
            }else{
                return FALSE;
            }
	    }

	    public function servicios_aceptados(){
	    	$recursos = new Recursos();
			$html    = '<table width="100%" cellspacing="3" class="border p-2 mt-4 table table-sm table-striped table-responsive" id="servicios_aceptados">
							<thead>
							<tr  >
								<th align="left">N&deg;</th>
								<th align="left">Codigo</th>
								<th align="left">EDP</th>
								<th align="left">Fecha</th>
								<th align="left">Vigencia</th>
								<th align="left">Cliente</th>
								<th align="left">Cantidad Fletes</th>
								<th align="left">Total</th>
								<th align="left">&nbsp;</th>
							</tr>
							</thead>
							<tbody>';

			$sql    = $this->selectQuery("SELECT * FROM   	servicios
										  LEFT JOIN       	edp_servicio
										  ON              	edp_servicio.edpserv_serv = servicios.serv_id
										  LEFT JOIN       	estado_de_pago
										  ON              	estado_de_pago.edp_id     = edp_servicio.edpserv_edp
										  WHERE    			serv_estado = 2
										  ORDER BY 			serv_id DESC");
			$j=1;
			for ($i=0; $i < count($sql); $i++) {
				//calulo progreso
				$dias_obra   = 0;
				$dias_espera = 0;

				$nombre_cliente = $recursos->datos_clientes_servicio($sql[$i]['serv_cliente']);
				$datos_flete    = $recursos->datos_fletes($sql[$i]['serv_id']);
				$monto_servicio = $recursos->datos_fletes_monto($sql[$i]['serv_id']);

				$html .= '

							<tr  >
								<td align="left">'.$j++.'</td>
								<td align="left">'.$sql[$i]['serv_codigo'].'</td>
								<td align="left">'.$sql[$i]['edp_codigo'].'</td>
								<td align="left">'.Utilidades::arreglo_fecha2($sql[$i]['serv_fecha_inicio']).'</td>
								<td align="left">'.Utilidades::arreglo_fecha2($sql[$i]['serv_fecha_termino']).'</td>
								<td align="left">'.$nombre_cliente[0]['cli_nombre'].'</td>
								<td align="left">'.count($datos_flete).'</td>
								<td align="left">'.Utilidades::monto($monto_servicio).'</td>
								<td align="left">
									<div class="col mt-1 p-2 d-flex justify-content-center"> <span class="far fa-eye text-primary cursor" href="'.controlador::$rutaAPP.'app/vistas/centro_costo/php/panel_servicios.php?idServicio='.$sql[$i]['serv_id'].'" data-fancybox data-type="iframe" data-preload="true" data-width="100%" data-height="1300"></span></div>
									<div class="col mt-1 p-2 d-flex justify-content-center"><span class="fas fa-file-pdf text-danger cursor" href="'.controlador::$rutaAPP.'app/vistas/centro_costo/php/cotizacion_servicio.php?idServicio='.$sql[$i]['serv_id'].'" data-fancybox data-type="iframe" data-preload="true" data-width="600" data-height="800"></span></div>
                                    <div class="col mt-1 p-2 d-flex justify-content-center"><span class="fas fa-file-excel text-success cursor" onclick="obtener_informe('.$sql[$i]['serv_id'].')"></span></div>
								</td>
							</tr>';
			}

			$html .= '</tbody>
	    			</table>';

			return $html;
		}

		public function edp_aceptados(){
	    	$recursos = new Recursos();
			$html    = '<table width="100%" cellspacing="3" class="border p-2 mt-4 table table-sm table-striped table-responsive" id="EDP_aceptados">
							<thead>
							<tr  >
								<th align="left">N&deg;</th>
								<th align="left">Codigo EDP</th>
								<th align="left">Fecha Creaccion</th>
								<th align="left">Fecha Pago</th>
								<th align="left">&nbsp;</th>
							</tr>
							</thead>
							<tbody>';

			$sql    = $this->selectQuery("SELECT * FROM estado_de_pago WHERE edp_estado = 2");
			$j=1;
			for ($i=0; $i < count($sql); $i++) {
				//calulo progreso
				$dias_obra   = 0;
				$dias_espera = 0;

				$nombre_cliente = $recursos->datos_clientes_servicio($sql[$i]['serv_cliente']);
				$datos_flete    = $recursos->datos_fletes($sql[$i]['serv_id']);
				$monto_servicio = $recursos->datos_fletes_monto($sql[$i]['serv_id']);

				$html .= '

							<tr  >
								<td align="left">'.$j++.'</td>
								<td align="left">'.$sql[$i]['edp_codigo'].'</td>
								<td align="left">'.Utilidades::arreglo_fecha2($sql[$i]['edp_creacion']).'</td>
								<td align="left">'.Utilidades::arreglo_fecha2($sql[$i]['edp_fecha_pago']).'</td>
								<td align="left">
									<div class="col text-center"><span class="h5 far fa-eye text-primary cursor" href="'.controlador::$rutaAPP.'app/vistas/centro_costo/php/panel_edp.php?idEstadoPago='.$sql[$i]['edp_id'].'" data-fancybox data-type="iframe" data-preload="true" data-width="100%" data-height="1300"></span></div>
					                <div class="col text-center"><span class="h5 fas fa-file-pdf text-danger cursor"  href="'.controlador::$rutaAPP.'app/vistas/centro_costo/php/mostrar_edp.php?idEstadoPago='.$sql[$i]['edp_id'].'" data-fancybox data-type="iframe" data-preload="true" data-width="600" data-height="800"></span></div>
					                <div class="col text-center"><span class="h5 fas fa-file-excel text-success cursor" onclick="obtener_informe_edp('.$sql[$i]['edp_id'].')"></span></div>
								</td>
							</tr>';
			}

			$html .= '</tbody>
	    			</table>';

			return $html;
		}

		public function servicios_edp($idEstadoPago){
	    	$recursos = new Recursos();
			$html    = '<table width="100%" cellspacing="3" class="border p-2 mt-4 table table-striped table-sm" id="servicios_aceptados">
							<thead>
							<tr  class="bg-white">
								<th align="left">N&deg;</th>
								<th align="left">Codigo</th>
								<th align="left">EDP</th>
								<th align="left">Fecha</th>
								<th align="left">Vigencia</th>
								<th align="left">Cliente</th>
								<th align="left">Fletes</th>
								<th align="left">Total</th>
								<th align="left">&nbsp;</th>
								<th align="left">&nbsp;</th>
								<th align="left">&nbsp;</th>
							</tr>
							</thead>
							<tbody>';

			$sql    = $this->selectQuery("SELECT * FROM   	servicios
										  LEFT JOIN       	edp_servicio
										  ON              	edp_servicio.edpserv_serv = servicios.serv_id
										  LEFT JOIN       	estado_de_pago
										  ON              	estado_de_pago.edp_id     = edp_servicio.edpserv_edp
										  WHERE    			edp_servicio.edpserv_edp  = $idEstadoPago
										  ORDER BY 			serv_id DESC");
			$j=1;
			for ($i=0; $i < count($sql); $i++) {
				//calulo progreso
				$dias_obra   = 0;
				$dias_espera = 0;

				$nombre_cliente = $recursos->datos_clientes_servicio($sql[$i]['serv_cliente']);
				$datos_flete    = $recursos->datos_fletes($sql[$i]['serv_id']);
				$monto_servicio = $recursos->datos_fletes_monto($sql[$i]['serv_id']);

				$html .= '

							<tr  >
								<td align="left">'.$j++.'</td>
								<td align="left">'.$sql[$i]['serv_codigo'].'</td>
								<td align="left">'.$sql[$i]['edp_codigo'].'</td>
								<td align="left">'.Utilidades::arreglo_fecha2($sql[$i]['serv_fecha_inicio']).'</td>
								<td align="left">'.Utilidades::arreglo_fecha2($sql[$i]['serv_fecha_termino']).'</td>
								<td align="left">'.$nombre_cliente[0]['cli_nombre'].'</td>
								<td align="left">'.count($datos_flete).'</td>
								<td align="left">'.Utilidades::monto($monto_servicio).'</td>
								<td align="left">
									<div class="col mt-1 p-2 d-flex justify-content-center"> <span class="far fa-eye text-primary cursor" href="'.controlador::$rutaAPP.'app/vistas/centro_costo/php/panel_servicios.php?idServicio='.$sql[$i]['serv_id'].'" data-fancybox data-type="iframe" data-preload="true" data-width="100%" data-height="1300"></span></div>
								</td>
								<td align="left">
									<div class="col mt-1 p-2 d-flex justify-content-center"><span class="fas fa-file-pdf text-danger cursor" href="'.controlador::$rutaAPP.'app/vistas/centro_costo/php/cotizacion_servicio.php?idServicio='.$sql[$i]['serv_id'].'" data-fancybox data-type="iframe" data-preload="true" data-width="600" data-height="800"></span></div>
								</td>
								<td align="left">
                                    <div class="col mt-1 p-2 d-flex justify-content-center"><span class="fas fa-file-excel text-success cursor" onclick="obtener_informe('.$sql[$i]['serv_id'].')"></span></div>
								</td>
							</tr>';
			}

			$html .= '</tbody>
	    			</table>';

			return $html;
		}

		public function formulario_editar_edp($idEdp){
			$html = '';

			$sql    = $this->selectQuery("SELECT * FROM estado_de_pago WHERE edp_id = $idEdp");

			for ($i=0; $i < count($sql); $i++) { 
				$html .= '
				<table class="table">
					<tr>
						<td>C&oacute;digo EDP:<br>
							<input type="text"  name="codigo_edp2" id="codigo_edp2" value="'.$sql[$i]['edp_codigo'].'" class="form-control bg-white">
						</td>
					</tr>
					<tr>
						<td>Fecha Pago:<br>
							<input type="date"  name="fecha_pago" id="fecha_pago" value="'.$sql[$i]['edp_creacion'].'" class="form-control bg-white">
						</td>
					</tr>
					<tr>
						<td>Glosa EDP:<br>
							<input type="text"  name="glosa" id="glosa" placeholder="Glosa" value="'.$sql[$i]['edp_glosa'].'" class="form-control bg-white"/>
						</td>
					</tr>
					<tr>
						<td>
							<button type="button" id="grabar" class="btn btn-primary form-control shadow" onclick="grabar_editar_edp('.$idEdp.')">Editar <i class="bi bi-save"></i></button>
						</td>
					</tr>
				</table>';
			}

			return $html;
			
		}

		public function grabar_editar_edp($idEdp, $codigo_edp, $fecha_pago, $glosa){
			$this->update_query("UPDATE estado_de_pago
								 SET 	edp_codigo 	   = '$codigo_edp',
								 		edp_fecha_pago = '$fecha_pago',
								 		edp_glosa      = '$glosa'
								 WHERE  edp_id 		   = $idEdp");
		}

		public function eliminar_edp($idEdp){
			$servicios = $this->data_id_pago_servicios($idEdp);
			$xplode    = explode(",", $servicios);

			for ($i=0; $i < count($xplode); $i++) { 
				$this->update_query("UPDATE servicios SET serv_estado=1 WHERE serv_id = $xplode[$i]");
			}

			$this->delete_query("DELETE FROM estado_de_pago WHERE edp_id = $idEdp");

		}

		public function traer_documentos_edp($idEstadoPago){
	    	$recursos = new Recursos();
	    	$sql      = $this->selectQuery("SELECT * FROM documentos_edp
					    				    WHERE  		  doc_edp = $idEstadoPago");

			$html     = '<table class="table table-striped">
							<thead>
								<tr>
									<th>Titulo Documento</th>
									<th>&nbsp;</th>
									<th>&nbsp;</th>
								</tr>
							</thead>
							<tbody>';
			//doc_id, doc_titulo, doc_ruta, doc_fin_documento
			for ($i=0; $i < count($sql); $i++) {
				$html  .= '
						<tr class="cambiazo">
							<td>'.$sql[$i]['doc_titulo'].'</td>
							<td align="center">
								<button class="btn btn-primary" type="button" href="'.controlador::$rutaAPP.'app/repositorio/documento_edp/'.$sql[$i]['doc_ruta'].'" data-fancybox data-type="iframe" data-preload="true" data-width="100%" data-height="1200"><i class="bi bi-eye"></i></button>
							</td>
							<td align="center">
								<button class="btn btn-danger" type="button" onclick="quitar_documento_edp('.$sql[$i]['doc_id'].')"><i class="bi-trash"></i></button>
							</td>
						</tr>';
			}

			$html .= '</tbody>
					</table>';

			return $html;
		}

		public function grabar_insertar_documento_edp($nombre, $inputTitulo, $inputEstadoPago){

			$grabar = $this->insert_query("INSERT INTO documentos_edp(doc_edp, doc_titulo, doc_ruta, doc_estado) 
					   					   VALUES('$inputEstadoPago', '$inputTitulo', '$nombre', 1)");

			if($grabar){
				return TRUE;
			}else{
				return FALSE;
			}
		}

		public function grabar_insertar_documento_cotizacion($nombre, $inputTitulo, $inputCotizacion){

			$grabar = $this->insert_query("INSERT INTO documentos_cotizacion(doc_coti, doc_titulo, doc_ruta, doc_estado) 
					   					   VALUES('$inputCotizacion', '$inputTitulo', '$nombre', 1)");

			if($grabar){
				return TRUE;
			}else{
				return FALSE;
			}
		}

		public function traer_documentos_cotizacion($inputCotizacion){
			$html     = '';
	    	$recursos = new Recursos();
	    	$sql      = $this->selectQuery("SELECT * FROM documentos_cotizacion
					    				    WHERE  		  doc_coti = $inputCotizacion");

	    	if(count($sql) > 0){
	    		$html    .= '<table class="table table-striped">
								<thead>
									<tr>
										<th>Titulo Documento</th>
										<th>&nbsp;</th>
										<th>&nbsp;</th>
									</tr>
								</thead>
								<tbody>';
				//doc_id, doc_titulo, doc_ruta, doc_fin_documento
				for ($i=0; $i < count($sql); $i++) {
					$html  .= '
							<tr class="cambiazo">
								<td>'.$sql[$i]['doc_titulo'].'</td>
								<td align="center">
									<button class="btn btn-primary" type="button" href="'.controlador::$rutaAPP.'app/repositorio/documento_edp/'.$sql[$i]['doc_ruta'].'" data-fancybox data-type="iframe" data-preload="true" data-width="100%" data-height="1200"><i class="bi bi-eye"></i></button>
								</td>
								<td align="center">
									<button class="btn btn-danger" type="button" onclick="quitar_documento_edp('.$sql[$i]['doc_id'].')"><i class="bi-trash"></i></button>
								</td>
							</tr>';
				}

				$html .= '</tbody>
						</table>';
	    	}			

			return $html;
		}

		public function listado_arriendos($mes, $ano, $idServicio){
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

		public function traslados_agregados($idServicio){
			$recursos = new Recursos();

			$html = '<div class="col-xl-6">
	    				<h3 class="text-info"><i class="fas fa-bus text-info"></i>&nbsp;&nbsp; Asignar Traslado</h3>
	    			 </div>
	    			 <div class="col-xl-6">
	    				<table width="100%">
	    					<tr>';
	    	$html.= '			<td>
	    							<button class="btn btn-success" type="button" href="'.controlador::$rutaAPP.'app/vistas/centro_costo/php/nuevo_traslados.php?idServicio='.$idServicio.'" data-fancybox="" data-type="iframe" data-preload="true" data-width="100%" data-height="1200">
	    								<i class="bi bi-plus-square"></i>
	    							</button>
	    						</td>';

	    	$html.= '
	    					</tr>
	    				</table>
	    			 </div>
	    			 <hr class="mt-2 mb-3"/>
	    			 <div class="col-xl-15 animate__animated animate__fadeInLeft">'.$this->listado_de_traslados($idServicio).'</div>';

			return $html;
	    }

	    public function listado_de_traslados($idServicio){
	    	$recursos 	= new Recursos();
	    	$desde      = $ano.'-'.$mes.'-01';
	    	$ultimo_dia = date("t", strtotime($desde));
	    	$hasta  	= $ano.'-'.$mes.'-'.$ultimo_dia;
	    	$hoy        = Utilidades::fecha_hoy();
	    	$neto       = 0;
	    	

	    	$sql    	= $this->selectQuery("SELECT * FROM traslados
										  	  WHERE    		traslados_estado     != 0
										  	  AND 			traslados_servicio 	 = $idServicio
										  	  ORDER BY      traslados_id ASC");

			$html = ' <table id="listado_facturas_proveedores" class="table shadow">
			            <thead >
			              	<tr class="table-info">
								<th>TRASLADO</th>
								<th>CANTIDAD</th>
								<th>FECHA</th>
								<th>VALOR</th>
								<th>TOTAL</th>
								<th>&nbsp;</th>
							</tr>
			            </thead>
			            <tbody>';

			for ($i=0; $i < count($sql); $i++) {

				$mostrar_localidad 	= '';
		    	$mostrar_fecha 		= '';

				$cantidad_total = ($sql[$i]['traslados_cantidad']*$sql[$i]['traslados_valor']);
				$fechas 		= trim($sql[$i]['traslados_fechas'], ';');
				$explorar_fecha = explode(";", $fechas);
				$explorar_local = explode(",", $sql[$i]['traslados']);
				

				if(count($explorar_fecha) > 0){

					for ($j=0; $j < count($explorar_fecha); $j++) { 

						$cambiar_fecha = explode("-", $explorar_fecha[$j]);

						$mostrar_fecha  .= ''.$cambiar_fecha[2].'-'.$cambiar_fecha[1].', ';
					}
				}

				if(count($explorar_local) > 0){

					for ($k=0; $k < count($explorar_local); $k++) { 
						$mostrar_localidad  .= ''.$recursos->nombre_localidad($explorar_local[$k]).' - ';
					}

				}

				$html .= '<tr>
				          	<td>'.trim($mostrar_localidad, '- ').'</td>
				          	<td>'.$sql[$i]['traslados_cantidad'].'</td>
				          	<td>'.trim($mostrar_fecha, ', ').'</td>
				          	<td>'.Utilidades::monto($sql[$i]['traslados_valor']).'</td>
				          	<td>'.Utilidades::monto($cantidad_total).'</td>
				          	<td align="center">
				          		<i class="far fa-eye text-primary ver" href="'.controlador::$rutaAPP.'app/vistas/centro_costo/php/editar_traslados.php?idTraslado='.$sql[$i]['traslados_id'].'" data-fancybox="" data-type="iframe" data-preload="true" data-width="100%" data-height="1200"></i>
				          	</td>
				          </tr>';
				$neto += $cantidad_total;
			}

			$total = ($neto*1.19);
			$iva   = ($total-$neto);

			$html .= ' 
						<tr>
							<td colspan="3">&nbsp;</td>
							<th align="right">NETO:</th>
							<th align="left">'.Utilidades::monto($neto).'</th>
						</tr>
						<tr>
							<td colspan="3">&nbsp;</td>
							<th align="right">IVA:</th>
							<th align="left">'.Utilidades::monto($iva).'</th>
						</tr>
						<tr>
							<td colspan="3">&nbsp;</td>
							<th align="right">TOTAL:</th>
							<th align="left">'.Utilidades::monto($total).'</th>
						</tr>
						</tbody>
					  </table>';

			return $html;
	    }
	    public function grabar_nuevo_traslado($idServicio, $inputOrigen, $inputDestino, $inputRegreso, $inputValor, $inputCantidad, $inputDescripcion, $inputFecha_items){
			$hoy 		= Utilidades::fecha_hoy();

			$mostrar_regreso = '';
			if($inputRegreso > 0){
				$mostrar_regreso = ','.$inputRegreso;
			}

			$traslados = $inputOrigen.','.$inputDestino.''.$mostrar_regreso;

			$sql 		= $this->insert_query("INSERT INTO traslados(traslados_servicio, traslados, traslados_cantidad, traslados_fechas, traslados_valor, traslados_descripcion, traslados_estado) 
											   VALUES('$idServicio', '$traslados', '$inputCantidad', '$inputFecha_items', '$inputValor', '$inputDescripcion', 1)");

			if($sql){
                return TRUE;
            }else{
                return FALSE;
            }
	    }

	    public function arriendos_agregados($idServicio){
			$recursos = new Recursos();

			$html = '<div class="col-xl-6">
	    				<h3 class="text-primary"><i class="fas fa-truck text-primary"></i>&nbsp;&nbsp; Asignar Arriendos</h3>
	    			 </div>
	    			 <div class="col-xl-6">
	    				<table width="100%">
	    					<tr>';
	    	$html.= '			<td>
	    							<button class="btn btn-success" type="button" href="'.controlador::$rutaAPP.'app/vistas/centro_costo/php/nuevo_arriendo.php?idServicio='.$idServicio.'" data-fancybox="" data-type="iframe" data-preload="true" data-width="100%" data-height="1200">
	    								<i class="bi bi-plus-square"></i>
	    							</button>
	    						</td>';

	    	$html.= '
	    					</tr>
	    				</table>
	    			 </div>
	    			 <hr class="mt-2 mb-3"/>
	    			 <div class="col-xl-15 animate__animated animate__fadeInLeft">'.$this->listado_de_arriendo($idServicio).'</div>';

			return $html;
	    }

	    public function listado_arriendos_agregados($idServicio){
			$recursos = new Recursos();

			$html = '<div class="col-xl-6">
	    				<h3 class="text-primary"><i class="fas fa-truck text-primary"></i>&nbsp;&nbsp; Asignar Arriendos</h3>
	    			 </div>
	    			 <div class="col-xl-6">
	    				<table width="100%">
	    					<tr>';
	    	$html.= '			<td>
	    							<button class="btn btn-success" type="button" href="'.controlador::$rutaAPP.'app/vistas/centro_costo/php/nuevo_arriendo.php?idServicio='.$idServicio.'" data-fancybox="" data-type="iframe" data-preload="true" data-width="100%" data-height="1200">
	    								<i class="bi bi-plus-square"></i>
	    							</button>
	    						</td>';

	    	$html.= '
	    					</tr>
	    				</table>
	    			 </div>
	    			 <hr class="mt-2 mb-3"/>
	    			 <div class="col-xl-15 animate__animated animate__fadeInLeft">'.$this->listado_de_arriendo($idServicio).'</div>';

			return $html;
	    }


	    public function grabar_nuevo_arriendo($idServicio, $inputTipoServicio, $inputProyecto, $inputContacto, $mes, $inputDescripcion, $camion_items, $hors_contrata_items, $valor_items, $hr_realizada_items){
	    	$recursos 	= new Recursos();
			$hoy 		= Utilidades::fecha_hoy();

			$sql= $this->insert_query("INSERT INTO arriendos (arriendo_servicio_id, arriendo_tipo_servicio, arriendo_proyecto, arriendo_contacto, arriendo_mes, arriendo_descripcion, arriendo_creacion, arriendo_estado) VALUES ('$idServicio', '$inputTipoServicio', '$inputProyecto', '$inputContacto', '$mes', '$inputDescripcion', '$hoy', 1)");


			$datos_arriendos_ultimo = $recursos->datos_arriendos_ultimo($idServicio);

			$ultimo_id 			= $datos_arriendos_ultimo[0]['arriendo_id'];

			$explode_camion 	= explode(";", $camion_items);
			$explode_hors_cont 	= explode(";", $hors_contrata_items);
			$explode_valor 		= explode(";", $valor_items);
			$explode_hr_real 	= explode(";", $hr_realizada_items);

			for ($i=0; $i<count($explode_camion); $i++) { 
				if($explode_camion[$i] != ''){

					$total = ($explode_valor[$i]*$explode_hr_real[$i]);

					$this->insert_query("INSERT INTO item_arriendo (item_arriendo_id, item_camion, item_hrs_contratadas, item_valor_hr, item_hr_realizadas, item_total, item_creacion, item_estado) 
										 VALUES ('$ultimo_id', '$explode_camion[$i]', '$explode_hors_cont[$i]', '$explode_valor[$i]', '$explode_hr_real[$i]', '$total', '$hoy', 1)");
				}
			}

			if($sql){
                return TRUE;
            }else{
                return FALSE;
            }
	    }

	    public function listado_de_arriendo($idArriendo){
	    	$recursos 	= new Recursos();
	    	$desde      = $ano.'-'.$mes.'-01';

	    	$ultimo_dia = date("t", strtotime($desde));
	    	$hasta  	= $ano.'-'.$mes.'-'.$ultimo_dia;
	    	$hoy        = Utilidades::fecha_hoy();

	    	$neto       = 0;
	    	
	    	$sql    	= $this->selectQuery("SELECT * FROM arriendos
										  	  WHERE    		arriendo_estado     	!= 0
										  	  AND 			arriendo_servicio_id 	 = $idArriendo
										  	  ORDER BY      arriendo_id  ASC");

	    	$html = '';
	    	$j 	  = 1;
			for ($i=0; $i < count($sql); $i++) {

				$html .= '<div class="row p-3 border">
		    				<div class="col border"><strong>N&deg;: '.$j++.' </strong>
		    					<div class="col text-center"><span class="p-2 far fa-eye text-primary cursor" href="'.controlador::$rutaAPP.'app/vistas/centro_costo/php/editar_arriendo.php?idArriendo='.$sql[$i]['arriendo_id'].'" data-fancybox data-type="iframe" data-preload="true" data-width="100%" data-height="1300"></span>
		    					</div>
		    					
		    				</div>
		    				<div class="col border"><strong>TIPO DE SERVICIO:<br>'.$sql[$i]['arriendo_tipo_servicio'].'</strong></div>
		    				<div class="col border"><strong>PROYECTO:<br>'.$sql[$i]['arriendo_proyecto'].'</strong></div>
		    				<div class="col border"><strong>CONTACTO:<br>'.$sql[$i]['arriendo_contacto'].'</strong></div>
		    				<div class="col border"><center><strong>Mes de:<br>'.Utilidades::mostrar_mes($sql[$i]['arriendo_mes']).'</strong></center></div>
		    				<div class="col-15 mt-2 p-1 bg-light"><strong>Descripción:<br>'.$sql[$i]['arriendo_descripcion'].'</strong></div>';
				$html .= $this->mostrar_listado_de_arriendo($sql[$i]['arriendo_id']);

				$html .= '</div>';
			}

			return $html;
	    }

	    public function mostrar_listado_de_arriendo($idArriendo){
	    	$recursos 	= new Recursos();
	    	$desde      = $ano.'-'.$mes.'-01';
	    	$ultimo_dia = date("t", strtotime($desde));
	    	$hasta  	= $ano.'-'.$mes.'-'.$ultimo_dia;
	    	$hoy        = Utilidades::fecha_hoy();
	    	$neto       = 0;

	    	$sql    	= $this->selectQuery("SELECT * FROM item_arriendo
										  	  WHERE    		item_estado     != 0
										  	  AND 			item_arriendo_id = $idArriendo
										  	  ORDER BY      item_id ASC");

			$html = ' <table id="listado_facturas_proveedores" class="table table-sm table-bordered mt-2">
			            <thead >
			              	<tr class="table-primary">
								<th>IDENTIFICACIÓN CAMIÓN</th>
								<th>HORAS CONTRATADAS</th>
								<th>VALOR HORA</th>
								<th>CANTIDAD DE HORAS REALIZADAS</th>
								<th>VALOR</th>
							</tr>
			            </thead>
			            <tbody>';

			for ($i=0; $i < count($sql); $i++) {
				$cantidad_total = ($sql[$i]['item_valor_hr']*$sql[$i]['item_hr_realizadas']);

				$html .= '<tr>
				          	<td>'.$sql[$i]['item_camion'].'</td>
				          	<td>'.$sql[$i]['item_hrs_contratadas'].'</td>
				          	<td>'.Utilidades::monto($sql[$i]['item_valor_hr']).'</td>
				          	<td>'.$sql[$i]['item_hr_realizadas'].'</td>
				          	<td>'.Utilidades::monto($cantidad_total).'</td>
				          </tr>';

				$neto += $cantidad_total;
			}

			$total = ($neto*1.19);
			$iva   = ($total-$neto);

			$html .= ' 
						<tr>
							<td colspan="3">&nbsp;</td>
							<th align="right">NETO:</th>
							<th align="left">'.Utilidades::monto($neto).'</th>
						</tr>
						<tr>
							<td colspan="3">&nbsp;</td>
							<th align="right">IVA:</th>
							<th align="left">'.Utilidades::monto($iva).'</th>
						</tr>
						<tr>
							<td colspan="3">&nbsp;</td>
							<th align="right">TOTAL:</th>
							<th align="left">'.Utilidades::monto($total).'</th>
						</tr>
						</tbody>
					  </table>';

			return $html;
	    }

	    public function mostrar_listado_de_arriendo_editar($idArriendo){
	    	$recursos 	= new Recursos();
	    	$desde      = $ano.'-'.$mes.'-01';
	    	$ultimo_dia = date("t", strtotime($desde));
	    	$hasta  	= $ano.'-'.$mes.'-'.$ultimo_dia;
	    	$hoy        = Utilidades::fecha_hoy();
	    	$neto       = 0;
	    	

	    	$sql    	= $this->selectQuery("SELECT * FROM item_arriendo
										  	  WHERE    		item_estado     != 0
										  	  AND 			item_arriendo_id = $idArriendo
										  	  ORDER BY      item_id ASC");

			$html = ' <table id="listar_productos" class="table table-sm table-bordered mt-2">
			            <thead >
			              	<tr class="table-light">
								<th>IDENTIFICACIÓN CAMIÓN</th>
								<th>HORAS CONTRATADAS</th>
								<th>VALOR HORA</th>
								<th>CANTIDAD DE HORAS REALIZADAS</th>
								<th>VALOR</th>
								<th>&nbsp;</th>
							</tr>
			            </thead>
			            <tbody>';
			$j = 1;
			for ($i=0; $i < count($sql); $i++) {
				$cantidad_total = ($sql[$i]['item_valor_hr']*$sql[$i]['item_hr_realizadas']);

				$html .= '<tr  id="row'.$j.'">
				          	<td><input type="text" name="camion[]" placeholder="Identificación" class="form-control titulo_list" value="'.$sql[$i]['item_camion'].'" /></td>
				          	<td><input type="number" name="hors_contratadas[]" placeholder="Horas Contratadas" class="form-control titulo_list" value="'.$sql[$i]['item_hrs_contratadas'].'" /></td>
				          	<td><input type="number" name="valor_hora[]" id="valor_hora0" placeholder="Valor horas" class="form-control titulo_list" onchange="calcular_valor_item_arriendo(0)" value="'.$sql[$i]['item_valor_hr'].'" /></td>
				          	<td><input type="number" name="hrs_realizadas[]" id="hrs_realizadas0" placeholder="Horas realizadas" class="form-control titulo_list" onchange="calcular_valor_item_arriendo(0)" value="'.$sql[$i]['item_hr_realizadas'].'" /></td>
				          	<td>'.Utilidades::monto($cantidad_total).'</td>
				          	<td><span class="fas fa-trash text-danger cursor btn_remove" name="remove" id="'.$j.'" onClick="quitar_arriendo('.$j.')"></span></td>
				          </tr>';

				$j++;

				$neto += $cantidad_total;
			}
  

			$html .= '</tbody>
					  </table>';

			return $html;
	    }

	    public function eliminar_registros_previos($idArriendo){
	    	$this->delete_query("DELETE FROM item_arriendo WHERE item_arriendo_id = $idArriendo");
	    }

	    public function editar_arriendo($idArriendo, $inputTipoServicio, $inputProyecto, $inputContacto, $mes, $inputDescripcion, $camion_items, $hors_contrata_items, $valor_items, $hr_realizada_items){
	    	$recursos 	= new Recursos();
			$hoy 		= Utilidades::fecha_hoy();

			$sql = $this->update_query('UPDATE  arriendos
										SET     arriendo_tipo_servicio	= $inputTipoServicio, 
												arriendo_proyecto		= $inputProyecto, 
												arriendo_contacto		= $inputContacto, 
												arriendo_mes			= $mes, 
												arriendo_descripcion	= $inputDescripcion
										WHERE   arriendo_id 			= $idArriendo');

			$this->eliminar_registros_previos($idArriendo);

			$explode_camion 	= explode(";", $camion_items);
			$explode_hors_cont 	= explode(";", $hors_contrata_items);
			$explode_valor 		= explode(";", $valor_items);
			$explode_hr_real 	= explode(";", $hr_realizada_items);

			for ($i=0; $i<count($explode_camion); $i++) { 
				if($explode_camion[$i] != ''){

					$total = ($explode_valor[$i]*$explode_hr_real[$i]);

					$this->insert_query("INSERT INTO item_arriendo (item_arriendo_id, item_camion, item_hrs_contratadas, item_valor_hr, item_hr_realizadas, item_total, item_creacion, item_estado) 
										 VALUES ('$idArriendo', '$explode_camion[$i]', '$explode_hors_cont[$i]', '$explode_valor[$i]', '$explode_hr_real[$i]', '$total', '$hoy', 1)");
				}
			}

			if($sql){
                return TRUE;
            }else{
                return FALSE;
            }
	    }

	    public function editar_traslado($idTraslado, $inputOrigen, $inputDestino, $inputRegreso, $inputValor, $inputCantidad, $inputDescripcion, $inputFecha_items){
			$hoy 		= Utilidades::fecha_hoy();

			$mostrar_regreso = '';
			if($inputRegreso > 0){
				$mostrar_regreso = ','.$inputRegreso;
			}

			$traslados = $inputOrigen.','.$inputDestino.''.$mostrar_regreso;

			$sql = $this->update_query("UPDATE 	traslados
										SET 	traslados 				= '$traslados', 
												traslados_cantidad		= '$inputCantidad', 
												traslados_fechas		= '$inputFecha_items', 
												traslados_valor			= '$inputValor', 
												traslados_descripcion 	= '$inputDescripcion'
										WHERE   traslados_id 			= $idTraslado");

			if($sql){
                return TRUE;
            }else{
                return FALSE;
            }
	    }
	    
	   /**  FIN CENTRO COSTO  **/

	} // END CLASS
?>