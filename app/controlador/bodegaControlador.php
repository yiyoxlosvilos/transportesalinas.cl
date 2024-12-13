<?php
	require_once __dir__."/../modelo/obtener_datos.php";
	require_once __dir__."/../controlador/utilidadesControlador.php";
	require_once __dir__."/../controlador/recursosControlador.php";
	require_once __dir__."/../controlador/productosControlador.php";

	class Bodega extends GetDatos {
		public function __construct(){
			parent::__construct();
	    }

/**  INICIO BODEGA   **/

		public function select_productos_multiple($estado, $tipo = 0){
			$script = "";

			if ($tipo == 1) {
				$script .= " AND prod_cli_categoria = $tipo";
			}

			$html = '<select id="productos" class="border rounded" placeholder="Buscar y seleccionar productos" >';
			$sql  = $this->selectQuery("SELECT * FROM product_cliente
										WHERE 		  prod_cli_estado = $estado
										$script
				   						ORDER BY   	  prod_cli_producto ASC");

			for ($i=0; $i < count($sql); $i++) { 
				$html .= '<option value="'.$sql[$i]['prod_cli_id'].'">'.$sql[$i]['prod_cli_producto'].' - '.$sql[$i]['prod_cli_patente'].'</option>';
			}

			$html .= '</select> ';

			return $html;
		}

	    public function traer_productos_bodega($estado){
	    	$html = '';

			$sql  = $this->selectQuery("SELECT * FROM product_cliente
										WHERE 		  prod_cli_estado   = $estado
				   						ORDER BY   	  prod_cli_producto ASC");

			for ($i=0; $i < count($sql); $i++) { 
				$html   .= '<span href="'.controlador::$rutaAPP.'app/vistas/bodega/php/validador.php?accion=1&idProducto='.$sql[$i]['prod_cli_id'].'" data-fancybox data-type="iframe" data-preload="true" data-width="100%" class="cursor mb-1 list-group-item list-group-item-action py-3 lh-tight" aria-current="true">
			                    <div class="d-flex w-100 align-items-center justify-content-between">
			                      <strong class="mb-1">'.ucfirst($sql[$i]['prod_cli_producto']).'</strong>
			                      <small>'.Utilidades::monto($sql[$i]['prod_cli_monto']).'</small>
			                    </div>
			                	<div class="col-10 mb-1 small text-uppercase"<b>Código</b>: '.$sql[$i]['prod_cli_codigo'].'</div>
			                </span>';
			}

			

			return $html;
		}

		public function traer_productos_bodega_ver($idProducto){
			$html 	  = '<div class="row mt-4">';
			$recursos = new Recursos();

			$sql  = $this->selectQuery("SELECT * FROM  product_cliente 
										LEFT JOIN      historial_productos
										ON             historial_productos.his_producto= product_cliente.prod_cli_id
										LEFT JOIN      clientes
										ON 			   clientes.cli_id 			  	   = historial_productos.his_cliente
				   						WHERE  		   product_cliente.prod_cli_id 	   = $idProducto");

			for ($i=0; $i < count($sql); $i++) {

				if($sql[$i]['his_id'] > 0){
					$fecha_arriendo = $sql[0]['his_fecha'].', '.$sql[0]['his_hora'];
					$glosa          = $sql[0]['his_glosa'];
				}else{
					$fecha_arriendo = 'S.R.';
					$glosa          = 'S.R.';
				}

				$html .= '<table class="table table-striped" cellpadding="5" cellspacing="5">
					  		<tr>
					  			<th>Producto:</th>
					  			<td class="borde_bajo">'.ucfirst($sql[$i]['prod_cli_producto']).'</td>
					  		</tr>
					  		<tr>
					  			<th>C&oacute;digo:</th>
					  			<td class="borde_bajo">'.$sql[$i]['prod_cli_codigo'].'</td>
					  		</tr>
					  		<tr>
					  			<th>Costo x d&iacute;a:</th>
					  			<td class="borde_bajo">'.Utilidades::monto($sql[$i]['prod_cli_monto']).'</td>
					  		</tr>
					  		<tr>
					  			<th>Ultimo Arriendo:&nbsp;</th>
					  			<td class="borde_bajo">'.$fecha_arriendo.'</td>
					  		</tr>
					  		<tr>
					  			<th colspan="2">Glosa:</th>
					  		</tr>
					  		<tr>
					  			<td colspan="2">'.$glosa.'</td>
					  		</tr>
					  	  </table>';
			}

			$html 	 .= '</div>';

			return $html;
		}

		public function traer_productos_arriendo($estado){
	    	$html 	  = '';
	    	$recursos = new Recursos();

			$sql  = $this->selectQuery("SELECT * FROM product_cliente
										WHERE 		  prod_cli_estado   = $estado
				   						ORDER BY   	  prod_cli_fin_arriendo ASC");

			for ($i=0; $i < count($sql); $i++) { 

				$datos   = $this->datos_productos_arriendo($sql[$i]['prod_cli_id']);
				$cliente = $recursos->datos_clientes($datos[0]['c_cli_clientes']);

				$html   .= '<span href="'.controlador::$rutaAPP.'app/vistas/bodega/php/validador.php?accion=2&idProducto='.$sql[$i]['prod_cli_id'].'" data-fancybox data-type="iframe" data-preload="true" data-width="100%" data-height="500" class="cursor mb-1 list-group-item list-group-item-action py-3 lh-tight" aria-current="true">
			                    <div class="d-flex w-100 align-items-center justify-content-between">
			                      <strong class="mb-1">'.ucfirst($sql[$i]['prod_cli_producto']).'</strong>
			                      <small>'.Utilidades::monto($datos[0]['c_cli_monto']).'</small>
			                    </div>
			                	<div class="col-10 mb-1 small text-uppercase"><b>Código</b>: '.$sql[$i]['prod_cli_codigo'].'</div>
			                	<div class="col-10 mb-1 small text-uppercase"><b>Cliente</b>: <span class="text-primary">'.$cliente[0]['cli_nombre'].'</span></div>
			                	<div class="col-10 mb-1 small text-uppercase"><b>Fecha Arriendo</b>: <span class="text-success">'.Utilidades::arreglo_fecha2($datos[0]['c_cli_fecha']).'</span> | <b>Fecha Entrega</b>: <span class="text-danger">'.Utilidades::arreglo_fecha2($datos[0]['c_cli_fecha_fin']).'</span></div>
			                </span>';
			}

			

			return $html;
		}

		public function traer_productos_arriendos_ver($idProducto){
			$html 	  = '<div class="row mt-4">';
			$recursos = new Recursos();
			$hoy      = Utilidades::fecha_hoy();

			$sql  	  = $this->selectQuery("SELECT prod_cli_id, prod_cli_producto
				   							FROM   product_cliente
				   							WHERE  prod_cli_id 		= $idProducto");

			for ($i=0; $i < count($sql); $i++) {

				$datos_caja  = $this->datos_productos_arriendo($idProducto);
				$datos_venta = $recursos->datos_ventas($datos_caja[0]['c_cli_lote']);
				$cliente 	 = $recursos->datos_clientes($datos_caja[0]['c_cli_clientes']);
				$venta       = $recursos->tipos_pagos_x_id($datos_venta[0]['ven_tipo_venta']);

				$html .= '<table class="table table-striped" align="center" cellpadding="5" cellspacing="5">
					  		<tr>
					  			<th width="100%" colspan="2" class="naranja tipo115" align="center" id="texto_chico">D&iacute;as para la entrega: '.Utilidades::dias_pasados($hoy, $datos_caja[0]['c_cli_fecha_fin']).'</th>
					  		</tr>
					  		<tr>
					  			<th width="30%" class="plomo2">Producto:</th>
					  			<td width="70%" class="borde_bajo">'.ucfirst($sql[$i]['prod_cli_producto']).'</td>
					  		</tr>
					  		<tr>
					  			<th width="30%" class="plomo2">C&oacute;digo:</th>
					  			<td width="70%" class="borde_bajo">'.$sql[$i]['prod_cli_codigo'].'</td>
					  		</tr>
					  		<tr>
					  			<th width="30%" class="plomo2">Cliente:</th>
					  			<td width="70%" class="borde_bajo">'.ucfirst($cliente[0]['cli_nombre']).'</td>
					  		</tr>
					  		<tr>
					  			<th width="30%" class="plomo2">Tel&eacute;fono:</th>
					  			<td width="70%" class="borde_bajo">'.$cliente[0]['cli_telefono'].'</td>
					  		</tr>
					  		<tr>
					  			<th width="30%" class="plomo2">Fecha Arriendo:&nbsp;</th>
					  			<td width="70%" class="borde_bajo">'.Utilidades::arreglo_fecha2($datos_caja[0]['c_cli_fecha']).'</td>
					  		</tr>
					  		<tr>
					  			<td width="30%" class="plomo2">Fecha Entrega:&nbsp;</td>
					  			<td width="70%" class="borde_bajo">'.Utilidades::arreglo_fecha2($datos_caja[0]['c_cli_fecha_fin']).'</td>
					  		</tr>
					  		<tr>
					  			<th width="30%" class="plomo2">Tipo Venta:&nbsp;</th>
					  			<td width="70%" class="borde_bajo">'.$venta[0]['tipo_nombre'].'</td>
					  		</tr>
					  	 </table>';
			}

			$html 	 .= '</div>';

			return $html;
		}

		public function datos_productos_arriendo($idProducto){
			$sql  = $this->selectQuery("SELECT * FROM caja_cliente
									    WHERE    	  c_cli_prod_cliente  = $idProducto
									    ORDER BY 	  c_cli_id DESC LIMIT 1");

			return $sql;
		}

		public function asignar_productos_mermas($idProducto){
			$html 	  = '<div class="row mt-4">';
			$data     = array();
			$productos= '';
			$productos_id= '';
			$recursos = new Recursos();

			foreach ($idProducto as $key => $value) {
				$data[$key] = $value;
			}

			for ($i = 0; $i < count($data); $i++) {
				$datos_nombre = $recursos->datos_productos($data[$i]);
				$productos       .= '<div class="col-sm-6 text-danger">- '.ucfirst($datos_nombre[0]['prod_cli_producto']).'</div>';
				$productos_id    .= $datos_nombre[0]['prod_cli_id'].',';
			}
			$html .= '<div class="col-10 mx-auto">
						<table class="table border rounded table-striped" align="center" cellpadding="5" cellspacing="5">
					  		<tr>
					  			<th>Producto/os de Baja:</th>
					  			<td>
					  				'.$productos.'
					  				<input type="hidden" name="productos_asignados" id="productos_asignados" value="'.substr($productos_id, 0, -1).'">
					  			</td>
					  		</tr>
					  		<tr>
					  			<th>Motivo Merma:</th>
					  			<td>
					  				<input type="text" class="form-control shadow" id="inputMotivo" placeholder="Motivo" autocomplete="off">
					  			</td>
					  		</tr>
					  		<tr>
					  			<th colspan="2">Glosa:</th>
					  		</tr>
					  		<tr>
					  			<td colspan="2"><textarea class="form-control shadow" id="inputGlosa" placeholder="Glosa" row="5"></textarea></td>
					  		</tr>
					  	</table>
					  </div>
					  <div class="col-3 mx-auto">
					  	<label for="inputTipo">&nbsp;</label>
					  	<button type="button" id="grabar" class="btn btn-danger form-control shadow" onclick="realizar_merma()">Realizar Merma&nbsp;&nbsp;&nbsp;<i class="bi bi-inboxes-fill"></i></button>
					  </div>
					  <div class="col-3 mx-auto">
					  	<label for="inputTipo">&nbsp;</label>
						<button type="button" id="cancelar" class="btn btn-secondary form-control shadow" onclick="parent.location.reload()">Cancelar&nbsp;&nbsp;&nbsp;<i class="bi bi-pencil-square"></i></button>
					  </div>
					</div>';

			return $html;
		}

		public function grabar_merma($idProducto, $inputMotivo, $inputGlosa, $idUser){
			$hoy    = Utilidades::fecha_hoy();
			$hora   = Utilidades::hora();

			$grabar = $this->insert_query("INSERT INTO merma_productos(merma_producto, merma_motivo, merma_glosa, merma_fecha, merma_hora, merma_usuario, merma_estado) 
				   VALUES('$idProducto', '$inputMotivo', '$inputGlosa', '$hoy', '$hora', '$idUser', 1)");

			if($grabar > 0){
				return TRUE;
			}else{
				return FALSE;
			}
		}

		public function realizar_merma($product_list, $inputMotivo, $inputGlosa, $idUser){
			$productos = new Productos();
			$data      = explode(",", $product_list);

			for ($i = 0; $i < count($data); $i++) {
				$productos->desactivar_productos($data[$i]);
				$this->grabar_merma($data[$i], $inputMotivo, $inputGlosa, $idUser);
			}

			if($i > 0){
				return true;
			}else{
				return false;
			}
		}

		public function productos_informe_entradas_bodega($desde, $hasta){

			$sql    = $this->selectQuery("SELECT * FROM historial_productos
										  LEFT JOIN     product_cliente
										  ON            product_cliente.prod_cli_id = historial_productos.his_producto
										  LEFT JOIN     clientes
										  ON 			clientes.cli_id 			= historial_productos.his_cliente
				   						  WHERE         historial_productos.his_fecha 	 BETWEEN '$desde' AND '$hasta'
										  ORDER BY   	historial_productos.his_id DESC");

			$html = ' <table class="table table-hover shadow-lg" style="width:100%">
			            <thead >
			              <tr class="table-info">
			                <th>Producto</th>
			                <th>Cliente</th>
			                <th>Fecha Ingreso</th>
			                <th>Boleta</th>
			                <th>Glosa</th>
			              </tr>
			            </thead>
			            <tbody>';

			for ($i=0; $i < count($sql); $i++) {

				if($sql[$i]['his_boleta'] > 0){
					$boleta = $sql[$i]['his_boleta'];
				}else{
					$boleta = 'NN';
				}

				$html .= '<tr>
			                <td>'.$sql[$i]['prod_cli_producto'].'</td>
			                <td>'.$sql[$i]['cli_nombre'].'</td>
			                <td>'.Utilidades::arreglo_fecha2($sql[$i]['his_fecha']).'</td>
			                <td>'.$boleta.'</td>
			                <td>'.$sql[$i]['his_glosa'].'</td>
			              </tr>';
			}
			
			$html .= '</tbody>
					</table>';

			return $html;
		}

		public function productos_informe_salidas_bodega($desde, $hasta){

			$sql    = $this->selectQuery("SELECT * FROM caja_cliente
										  LEFT JOIN     product_cliente
										  ON            product_cliente.prod_cli_id 	  = caja_cliente.c_cli_prod_cliente
										  LEFT JOIN     clientes
										  ON 			clientes.cli_id 				  = caja_cliente.c_cli_clientes
				   						  WHERE         caja_cliente.c_cli_fecha 		  BETWEEN '$desde' AND '$hasta'
				   						  AND           caja_cliente.c_cli_tipoMovimiento = 3
										  ORDER BY   	caja_cliente.c_cli_id DESC");

			$html = ' <table class="table table-hover shadow-lg" style="width:100%">
			            <thead >
			              <tr class="table-info">
			                <th>Producto</th>
			                <th>Cliente</th>
			                <th>Fecha Salida</th>
			                <th>Boleta</th>
			              </tr>
			            </thead>
			            <tbody>';

			for ($i=0; $i < count($sql); $i++) {

				if($sql[$i]['c_cli_lote'] > 0){
					$boleta = $sql[$i]['c_cli_lote'];
				}else{
					$boleta = 'NN';
				}

				$html .= '<tr>
			                <td>'.$sql[$i]['prod_cli_producto'].'</td>
			                <td>'.$sql[$i]['cli_nombre'].'</td>
			                <td>'.Utilidades::arreglo_fecha2($sql[$i]['c_cli_fecha']).'</td>
			                <td>'.$boleta.'</td>
			              </tr>';
			}
			
			$html .= '</tbody>
					</table>';

			return $html;
		}

		public function productos_informe_mermas_bodega($desde, $hasta){

			$sql    = $this->selectQuery("SELECT * FROM merma_productos
										  LEFT JOIN     product_cliente
										  ON            product_cliente.prod_cli_id = merma_productos.merma_producto
				   						  WHERE         merma_productos.merma_fecha BETWEEN '$desde' AND '$hasta'
										  ORDER BY   	merma_productos.merma_id DESC");

			$html = ' <table class="table table-hover shadow-lg" style="width:100%">
			            <thead >
			              <tr class="table-info">
			                <th>Producto</th>
			                <th>Fecha Merma</th>
			                <th>Motivo</th>
			              </tr>
			            </thead>
			            <tbody>';

			for ($i=0; $i < count($sql); $i++) {

				$html .= '<tr>
			                <td>'.$sql[$i]['prod_cli_producto'].'</td>
			                <td>'.Utilidades::arreglo_fecha2($sql[$i]['merma_fecha']).'</td>
			                <td>'.$sql[$i]['merma_motivo'].'</td>
			              </tr>';
			}
			
			$html .= '</tbody>
					</table>';

			return $html;
		}

/**  FIN BODEGA   **/

	}// END CLASS
?>