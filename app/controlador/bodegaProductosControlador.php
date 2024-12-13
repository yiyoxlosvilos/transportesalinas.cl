<?php
	require_once __dir__."/../modelo/obtener_datos.php";
	require_once __dir__."/../controlador/utilidadesControlador.php";
	require_once __dir__."/../controlador/recursosControlador.php";
	require_once __dir__."/../controlador/productosControlador.php";

	error_reporting(E_ALL);
  ini_set('display_errors', 0);

	class Bodega {
		private $bodega_sucursal;

		public function __construct(){
	        $this->bodega_sucursal	= new GetDatos();
	    }

/**  INICIO BODEGA   **/

		public function select_productos_multiple($estado){
			$html = '<select id="productos" class="border rounded" placeholder="Buscar y seleccionar productos" multiple>';
			$sql  = $this->bodega_sucursal->selectQuery("SELECT * FROM   productos_bodega
														  WHERE 		  prod_cli_estado = $estado
				   										  ORDER BY   	  prod_cli_producto ASC");

			for ($i=0; $i < count($sql); $i++) { 
				$html .= '<option value="'.$sql[$i]['prod_cli_id'].'">'.$sql[$i]['prod_cli_producto'].'</option>';
			}

			$html .= '</select> ';

			return $html;
		}

		public function cantidad_productos_bodega($estado){
			$data   = 0;
			if ($estado == 0) {
				$script = ' >= 0';
			}else{
				$script = " = $estado";
			}

			$sql    = $this->selectQuery("SELECT * FROM producto_bodega
										  WHERE 		prod_cli_estado $script
				   						  ORDER BY   	prod_cli_producto ASC");

			for ($i=0; $i < count($sql); $i++) { 
				$data++;
			}

			return $data;
		}

	    public function traer_productos_bodega($estado){
	    	$html = '';

			$sql  = $this->selectQuery("SELECT * FROM producto_bodega
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

			$sql  = $this->selectQuery("SELECT * FROM  productos_bodega 
										LEFT JOIN      historial_productos
										ON             historial_productos.his_producto= productos_bodega.prod_cli_id
										LEFT JOIN      clientes
										ON 			   clientes.cli_id 			  	   = historial_productos.his_cliente
				   						WHERE  		   productos_bodega.prod_cli_id 	   = $idProducto");

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

			$sql  = $this->selectQuery("SELECT * FROM productos_bodega
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
				   							FROM   productos_bodega
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
				$datos_nombre = $this->datos_productos($data[$i]);
				$tipo_producto= $datos_nombre[0]['prod_cli_tipo'];

				if($tipo_producto == 0){
				    $ejemplo = "Ej.: 1";
				    $stock   = $this->stock_producto($datos_nombre[0]['prod_cli_id']);
				}else{
					$ejemplo = "Ej. Kg/Mt.: 8.5";
					$stock   = ($this->stock_producto_granel($datos_nombre[0]['prod_cli_id'])/1000);
				}

				$arreglo = "if(this.value>".$stock."){this.value='".$stock."';}else if(this.value<0){this.value='0';}";

				$productos .= '
								<tr>
									<td width="50%">
										<b class="text-dark">'.ucfirst($datos_nombre[0]['prod_cli_producto']).'<br><span class="text-danger">Stock Actual: '.$stock.'</span></b>
										<input type="hidden" name="productos_asignados[]" value="'.$datos_nombre[0]['prod_cli_id'].'">
									</td>
									<td width="50%">
										Stock: <span class="text-info">'.$ejemplo.'</span><br>
										<input type="number" class="form-control shadow" name="inputStock[]" placeholder="Ingresar Stock" autocomplete="off" onchange="'.$arreglo.'">
									<br>
						  			Glosa:<br><textarea class="form-control shadow" name="inputGlosa[]" placeholder="Glosa" row="5"></textarea></td>
						  		</tr>';
			}

			$html .= '<div class="col-10 mx-auto">
						<table class="table border rounded table-striped" align="center" cellpadding="5" cellspacing="5">
							<tr>
					  			<td width="50%"><b>Lote Merma:</b></td>
					  			<td width="50%">'.$recursos->select_lote_merma().'</td>
					  		</tr>
					  		'.$productos.'
					  	</table>
					  </div>
					  <div class="col-3 mx-auto">
					  	<label for="inputTipo">&nbsp;</label>
					  	<button type="button" id="grabar" class="btn btn-danger form-control shadow" onclick="realizar_merma()">Realizar Merma&nbsp;&nbsp;&nbsp;<i class="fas fa-trash-alt"></i></button>
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
										  LEFT JOIN     productos_bodega
										  ON            productos_bodega.prod_cli_id = historial_productos.his_producto
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
										  LEFT JOIN     productos_bodega
										  ON            productos_bodega.prod_cli_id 	  = caja_cliente.c_cli_prod_cliente
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
										  LEFT JOIN     productos_bodega
										  ON            productos_bodega.prod_cli_id = merma_productos.merma_producto
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

		public function ingresos_productos_lista($idProducto){
			$html 	   		= '<div class="row mt-4">';
			$data      		= array();
			$productos 		= '';
			$productos_id 	= '';
			$recursos  		= new Recursos();

			foreach ($idProducto as $key => $value) {
				$data[$key] = $value;
			}

			for ($i = 0; $i < count($data); $i++) {
				$datos_nombre = $this->datos_productos($data[$i]);
				$tipo_producto= $datos_nombre[0]['prod_cli_tipo'];

				if($tipo_producto == 0){
				    $ejemplo = "Ej.: 1";
				    $stock   = $this->stock_producto($datos_nombre[0]['prod_cli_id']);
				}else{
					$ejemplo = "Ej. Kg/Mt.: 8.5";
					$stock   = ($this->stock_producto_granel($datos_nombre[0]['prod_cli_id'])/1000);
				}

				$productos .= '
								<tr>
									<td width="50%">
										<b class="text-dark">'.ucfirst($datos_nombre[0]['prod_cli_producto']).'<br><span class="text-danger">Stock Actual: '.$stock.'</span></b>
										<input type="hidden" name="productos_asignados[]" value="'.$datos_nombre[0]['prod_cli_id'].'">
									</td>
									<td width="50%">
										Stock: <span class="text-info">'.$ejemplo.'</span><br>
										<input type="text" class="form-control shadow" name="inputStock[]" placeholder="Ingresar Stock" autocomplete="off">
									<br>
						  			Glosa:<br><textarea class="form-control shadow" name="inputGlosa[]" placeholder="Glosa" row="5"></textarea></td>
						  		</tr>';
			}

			$html .= '<div class="col-10 mx-auto">
						<table class="table border rounded table-striped" align="center" cellpadding="5" cellspacing="5">
							<tr>
					  			<td width="50%"><b>* Lote Ingreso:</b></td>
					  			<td width="50%">'.$recursos->select_lote_ingresos().'</td>
					  		</tr>
					  		<tr>
					  			<td width="50%"><b>* Factura Proveedor:</b></td>
					  			<td width="50%"><input type="text" class="form-control shadow" name="factura_proveedor" id="factura_proveedor" placeholder="Ingresar Factura" autocomplete="off"></td>
					  		</tr>
					  		'.$productos.'
					  	</table>
					  </div>
					  <div class="col-3 mx-auto">
					  	<label for="inputTipo">&nbsp;</label>
					  	<button type="button" id="grabar" class="btn btn-success form-control shadow" onclick="realizar_ingreso()">Realizar Ingreso&nbsp;&nbsp;&nbsp;<i class="fas fa-arrow-alt-circle-up"></i></button>
					  </div>
					  <div class="col-3 mx-auto">
					  	<label for="inputTipo">&nbsp;</label>
						<button type="button" id="cancelar" class="btn btn-secondary form-control shadow" onclick="parent.location.reload()">Cancelar&nbsp;&nbsp;&nbsp;<i class="bi bi-pencil-square"></i></button>
					  </div>
					</div>';

			return $html;
		}


		public function realizar_ingreso($productos, $stock, $glosa, $idUser, $conteo, $factura_proveedor){
			$recursos = new Recursos();
			$hoy      = Utilidades::fecha_hoy();
			$hora     = Utilidades::hora();

			$explore_productos = explode(";", $productos);
			$explore_stock     = explode(";", $stock);
			$explore_glosa     = explode(";", $glosa);

			for ($i=0; $i < count($explore_productos); $i++) {

				if($explore_productos[$i] > 0 && $explore_stock[$i] > 0){

					$datos_nombre = $this->datos_productos($explore_productos[$i]);

					if($datos_nombre[0]['prod_cli_tipo'] == 0){
						$stock_grabar = $explore_stock[$i];
					}else{
						$stock_grabar = ($explore_stock[$i]*1000);
					}

					$sql = $this->bodega_sucursal->selectQuery("SELECT * FROM stock_productos_bodega WHERE stock_producto = $explore_productos[$i]");

					if(count($sql) > 0){
						if($datos_nombre[0]['prod_cli_tipo'] == 0){
							$this->bodega_sucursal->update_query("UPDATE stock_productos_bodega 
								                 SET 	stock_cantidad    = stock_cantidad+$stock_grabar
								                 WHERE  stock_producto    = $explore_productos[$i]
								                ");

						}else{
							$this->bodega_sucursal->update_query("UPDATE stock_productos_bodega 
								                 SET 	stock_granel      = stock_granel+$stock_grabar
								                 WHERE  stock_producto    = $explore_productos[$i]
								                 ");
						}
					}else{
						if($datos_nombre[0]['prod_cli_tipo'] == 0){
							$this->bodega_sucursal->insert_query("INSERT INTO stock_productos_bodega(stock_producto, stock_cantidad, stock_granel, stock_estado) 
								 			 	 VALUES('$explore_productos[$i]', '$stock_grabar', 0, 1)");

						}else{
							$this->bodega_sucursal->insert_query("INSERT INTO stock_productos_bodega(stock_producto, stock_cantidad, stock_granel, stock_estado) 
								 			 	 VALUES('$explore_productos[$i]', 0, '$stock_grabar', 1)");
						}
					}				

					

					$this->bodega_sucursal->insert_query("INSERT INTO  historial_movimiento_bodega(his_usuario, his_producto_maquinaria, his_fecha, his_hora, his_tipo, his_suc_envia, his_cantidad, his_comentario, his_lote, his_estado, his_factura_proveedores)
					   					 VALUES('$idUser', '$explore_productos[$i]', '$hoy', '$hora', '2', '1', '$stock_grabar', '$explore_glosa[$i]', '$conteo', 1, '$factura_proveedor')");
				}
			}

			if($conteo >= $recursos->correlativo_ingreso()){
				$recursos->upCorrelativo_ingreso();
			}

			if($i > 0){
				return $conteo;

			}else{
				return 0;
			}
		}

		public function salidas_productos_lista($idProducto){
			$html 	   		= '<div class="row mt-4">';
			$data      		= array();
			$productos 		= '';
			$productos_id 	= '';
			$recursos  		= new Recursos();

			foreach ($idProducto as $key => $value) {
				$data[$key] = $value;
			}

			for ($i = 0; $i < count($data); $i++) {
				$datos_nombre = $this->datos_productos($data[$i]);
				$tipo_producto= $datos_nombre[0]['prod_cli_tipo'];

				if($tipo_producto == 0){
				    $ejemplo = "Ej.: 1";
				    $stock   = $this->stock_producto($datos_nombre[0]['prod_cli_id']);
				}else{
					$ejemplo = "Ej. Kg/Mt.: 8.5";
					$stock   = ($this->stock_producto_granel($datos_nombre[0]['prod_cli_id'])/1000);
				}

				$arreglo = "if(this.value>".$stock."){this.value='".$stock."';}else if(this.value<0){this.value='0';}";

				$productos .= '
								<tr>
									<td width="50%">
										<b class="text-dark">'.ucfirst($datos_nombre[0]['prod_cli_producto']).'<br><span class="text-danger">Stock Actual: '.$stock.'</span></b>
										<input type="hidden" name="productos_asignados[]" value="'.$datos_nombre[0]['prod_cli_id'].'">
									</td>
									<td width="50%">
										Stock: <span class="text-info">'.$ejemplo.'</span><br>
										<input type="number" class="form-control shadow" name="inputStock[]" placeholder="Ingresar Stock" autocomplete="off" onchange="'.$arreglo.'">
									<br>
						  			Glosa:<br><textarea class="form-control shadow" name="inputGlosa[]" placeholder="Glosa" row="5"></textarea></td>
						  		</tr>';
			}

			$html .= '<div class="col-10 mx-auto">
						<table class="table border rounded table-striped" align="center" cellpadding="5" cellspacing="5">
							<tr>
					  			<td colspan="2"><b>Datos de Salida:</b></td>
					  		</tr>
					  		<tr>
					  			<td><b>* ¿ Quién Retira ?</b><br><input type="text" name="nombre_retira" id="nombre_retira" class="form-control" placeholder="Escribir Nombre" value=""> </td>
					  			<td><b>* Rut de quien retira:</b>&nbsp;&nbsp;<small>Ej: 55555555-k</small><br><input type="text" name="rut_retira" id="rut_retira" class="form-control" placeholder="Escribir Rut" value=""> </td>
					  		</tr>
					  		<tr>
					  			<td><b>* Sucursal Destino:</b></td>
					  			<td>'.$recursos->select_sucursales(1).'</td>
					  		</tr>
					  		<tr>
					  			<td colspan="2"><b>Descripción:</b><br><textarea name="descripcion" id="descripcion" class="form-control" placeholder="Escribir Descripción"></textarea></td>
					  		</tr>
					  	</table>
					  	<center><h3>Listado de Productos:</h3></center>
						<table class="table border rounded table-striped" align="center" cellpadding="5" cellspacing="5">
							<tr>
					  			<td width="50%"><b>Lote Salida:</b></td>
					  			<td width="50%">'.$recursos->select_lote_egreso().'</td>
					  		</tr>
					  		'.$productos.'
					  	</table>
					  </div>
					  <div class="col-3 mx-auto">
					  	<label for="inputTipo">&nbsp;</label>
					  	<button type="button" id="grabar" class="btn btn-primary form-control shadow" onclick="realizar_salida()">Realizar Salida&nbsp;&nbsp;&nbsp;<i class="fas fa-arrow-alt-circle-down"></i></button>
					  </div>
					  <div class="col-3 mx-auto">
					  	<label for="inputTipo">&nbsp;</label>
						<button type="button" id="cancelar" class="btn btn-secondary form-control shadow" onclick="parent.location.reload()">Cancelar&nbsp;&nbsp;&nbsp;<i class="bi bi-pencil-square"></i></button>
					  </div>
					</div>';

			return $html;
		}

		public function realizar_salida($productos, $stock, $glosa, $idUser, $conteo, $nombre_retira, $rut_retira, $inputSucursal, $descripcion){
			$recursos = new Recursos();
			$hoy      = Utilidades::fecha_hoy();
			$hora     = Utilidades::hora();

			$explore_productos = explode(";", $productos);
			$explore_stock     = explode(";", $stock);
			$explore_glosa     = explode(";", $glosa);

			for ($i=0; $i < count($explore_productos); $i++) {

				if($explore_productos[$i] > 0 && $explore_stock[$i] > 0){

					$datos_nombre = $this->datos_productos($explore_productos[$i]);

					if($datos_nombre[0]['prod_cli_tipo'] == 0){
						$stock_unitario = $explore_stock[$i];
						$stock_granel 	= 0;

						$stock_grabar   = $stock_unitario;
					}else{
						$stock_unitario = 0;
						$stock_granel   = ($explore_stock[$i]*1000);

						$stock_grabar   = $stock_granel;
					}
					

					$this->bodega_sucursal->update_query("	UPDATE stock_productos_bodega 
													         SET 	stock_cantidad    = stock_cantidad-$stock_unitario,
													         		stock_granel      = stock_granel-$stock_granel
													         WHERE  stock_producto    = $explore_productos[$i]
													         ");

					$this->bodega_sucursal->insert_query("INSERT INTO  historial_movimiento_bodega(his_usuario, his_producto_maquinaria, his_fecha, his_hora, his_tipo, his_suc_envia, his_cantidad, his_comentario, his_lote, his_retira, his_rut, his_sucursal, his_comentario_retira, his_estado)
					   					 VALUES('$idUser', '$explore_productos[$i]', '$hoy', '$hora', '1', '1', '$stock_grabar', '$explore_glosa[$i]', '$conteo', '$nombre_retira', '$rut_retira', '$inputSucursal', '$descripcion', 1)");
				}
			}

			if($conteo >= $recursos->correlativo_egreso()){
				$recursos->upCorrelativo_egreso();
			}

			if($i > 0){
				return $conteo;

			}else{
				return 0;
			}
		}

		public function realizar_merma_dos($productos, $stock, $glosa, $idUser, $conteo){
			$recursos = new Recursos();
			$hoy      = Utilidades::fecha_hoy();
			$hora     = Utilidades::hora();

			$explore_productos = explode(";", $productos);
			$explore_stock     = explode(";", $stock);
			$explore_glosa     = explode(";", $glosa);

			for ($i=0; $i < count($explore_productos); $i++) {

				if($explore_productos[$i] > 0 && $explore_stock[$i] > 0){

					$datos_nombre = $this->datos_productos($explore_productos[$i]);

					if($datos_nombre[0]['prod_cli_tipo'] == 0){
						$stock_grabar = $explore_stock[$i];
					}else{
						$stock_grabar = ($explore_stock[$i]*1000);
					}
					

					$this->bodega_sucursal->update_query("UPDATE stock_productos_bodega 
								         SET 	stock_cantidad    = stock_cantidad-$stock_grabar
								         WHERE  stock_producto    = $explore_productos[$i]
								         ");

					$this->bodega_sucursal->insert_query("INSERT INTO  historial_movimiento_bodega(his_usuario, his_producto_maquinaria, his_fecha, his_hora, his_tipo, his_suc_envia, his_cantidad, his_comentario, his_lote, his_estado)
					   					 VALUES('$idUser', '$explore_productos[$i]', '$hoy', '$hora', '3', '1', '$stock_grabar', '$explore_glosa[$i]', '$conteo', 1)");

					//$this->grabar_merma($explore_productos[$i], 'Merma Producto', $explore_glosa[$i], $idUser);
				}
			}

			if($conteo >= $recursos->correlativo_merma()){
				$recursos->upCorrelativo_merma();
			}

			if($i > 0){
				return $conteo;

			}else{
				return 0;
			}
		}

		public function listado_adminitracion_bodega($ano, $mes, $tipo){
			$inicio  = $ano.'-'.$mes.'-01';
	    	$final 	 = date("Y-m-t", strtotime($inicio));

	    	if($tipo == 1){
		        $titulo = "salida";
		    }elseif($tipo == 2){
		        $titulo = "ingreso";
		    }elseif($tipo == 3){
		        $titulo = "merma";
		    }

			$sql = $this->bodega_sucursal->selectQuery("SELECT * FROM historial_movimiento_bodega
									   LEFT JOIN     productos_bodega
									   ON 			 productos_bodega.prod_cli_id 		   = historial_movimiento_bodega.his_producto_maquinaria
									   WHERE         historial_movimiento_bodega.his_fecha BETWEEN '$inicio' AND '$final'
									   AND           historial_movimiento_bodega.his_tipo  = $tipo
									   GROUP BY      historial_movimiento_bodega.his_lote");
			
			$html     = '<table width="100%" align="center" id="listado_'.$titulo.'" class="table table-hover">
							<thead>
								<tr class="plomo">
									<th align="left">Lote</th>
									<th align="left">Fecha</th>
									<th align="left">Hora</th>
									<th align="center">&nbsp;</th>
								</tr>
							</thead>
							<tbody>';

			for ($i=0; $i < count($sql); $i++) { 
				$html .= '<tr>
						  	<td align="left">Lote '.$titulo.' '.$sql[$i]['his_lote'].'</td>
							<td align="left">'.Utilidades::arreglo_fecha2($sql[$i]['his_fecha']).'</td>
							<td align="left">'.$sql[$i]['his_hora'].'</td>
							<td align="center">
								<li class="fas fa-print cursor text-primary" onclick="mostrar_informe('.$sql[$i]['his_lote'].', '.$tipo.')"></li>
							</td>
						  </tr>';
			}

			$html .= '</tbody>
					</table>';

			return $html;
		}

		public function listar_movimiento_bodega($desde, $hasta, $tipo=0, $inputSucursal = 11, $productos = 0){

			$unitario_ver = 0;
			$granel_ver	  = 0;
			$script     = "";

		    if($tipo > 0){
				$script .= " AND           historial_movimiento_bodega.his_tipo  = $tipo";
		    }

		    if($inputSucursal > 0){
				$script .= " AND           historial_movimiento_bodega.his_sucursal  = $inputSucursal";
		    }

		    if($productos > 0){
				$script .= " AND           historial_movimiento_bodega.his_producto_maquinaria  = $productos";
		    }


			$html 	  = '<table class="table table-hover" id="productos">
						<thead>
			              <tr class="bg-light">
			                <th align="left">N&deg; Envío</th>
			                <th align="left">Producto/os</th>
			                <th align="left">Cantidad Unitario</th>
			                <th align="left">Cantidad Granel</th>
			                <th align="left">Fecha Envio</th>
			                <th align="left">Hora Envio</th>
			                <th align="left">Usuario Envia</th>
			                <th align="center">&nbsp;</th>
			              </tr>
			              </thead>
			              <tbody>';

			$sql = $this->bodega_sucursal->selectQuery("SELECT * FROM historial_movimiento_bodega
														 LEFT JOIN     productos_bodega
														 ON 			 productos_bodega.prod_cli_id 		   = historial_movimiento_bodega.his_producto_maquinaria
														 LEFT JOIN     usuario_cli
														 ON            usuario_cli.us_cli_id                 = historial_movimiento_bodega.his_usuario
														 WHERE         historial_movimiento_bodega.his_fecha BETWEEN '$desde' AND '$hasta'
														 $script");

			for ($i=0; $i < count($sql); $i++) {

				if($sql[$i]['prod_cli_tipo'] == 0){
					$unitario	= $sql[$i]['his_cantidad'];
					$granel		= 0;

					$unitario_ver += $sql[$i]['his_cantidad'];
					$granel_ver	  += 0;

				}else{
					$unitario	= 0;
					$granel		= ($sql[$i]['his_cantidad']/1000);

					$unitario_ver += 0;
					$granel_ver	  += ($sql[$i]['his_cantidad']/1000);
				}

				if($sql[$i]['his_tipo'] == 1){
			        $titulo = "salida";
			    }elseif($sql[$i]['his_tipo'] == 2){
			        $titulo = "ingreso";
			    }elseif($sql[$i]['his_tipo'] == 3){
			        $titulo = "merma";
			    }

				$html .= '
					<tr >
						<td align="left">N&deg;  '.$sql[$i]['his_lote'].'</td>
						<td align="left">'.$sql[$i]['prod_cli_producto'].'</td>
						<td align="left">'.Utilidades::miles($unitario).'</td>
						<td align="left">'.Utilidades::peso($granel).'</td>
						<td align="left">'.Utilidades::arreglo_fecha2($sql[$i]['his_fecha']).'</td>
						<td align="left">'.$sql[$i]['his_hora'].'</td>
						<td align="left">'.$sql[$i]['us_cli_nombre'].'</td>
						<td align="center">
							<li class="fas fa-print cursor text-primary" onclick="mostrar_informe('.$sql[$i]['his_lote'].', '.$sql[$i]['his_tipo'].')"></li>
						</td>
					</tr>';
			}

			$html .= '</tbody>
			<tfooter>
					<tr class="bg-light">
						<th align="left">&nbsp;</th>
						
						<th align="left">Totales</th>
						<th align="left">'.Utilidades::miles($unitario_ver).' un.</th>
						<th align="left">'.Utilidades::peso($granel_ver).' Kg.</th>
						<th align="left">&nbsp;</th>
						<th align="left">&nbsp;</th>
						<th align="center">&nbsp;</th>
						<th align="center">&nbsp;</th>
					</tr>';

			$html .= '</tfooter></table>';
			
			return $html;
		}

		public function datos_historial_bodega($lote, $tipo_movimiento){
		    $sql    = $this->bodega_sucursal->selectQuery("SELECT * FROM historial_movimiento_bodega
		    		   					  WHERE  		his_lote = $lote
		    		   					  AND           his_tipo = $tipo_movimiento");

			return $sql;
		}

		public function datos_sucursales($idSucursal = 0){
			
			$sql  	= $this->bodega_sucursal->selectQuery("SELECT * FROM sucursales
										  WHERE    		suc_id = $idSucursal");

			return $sql;
		}

		public function datos_usuario($idUsuario){ // us_cli_empresa
			$sql    = $this->bodega_sucursal->selectQuery("SELECT * FROM usuario_cli WHERE us_cli_id=$idUsuario");

			return $sql;
		}

		public function datos_productos($idProducto){
			$sql    = $this->bodega_sucursal->selectQuery("SELECT * FROM productos_bodega
										  					WHERE 		prod_cli_id = $idProducto");

			if(count($sql) > 0){
				return $sql;
			}else{
				return null;
			}
		}

		//NUEVO BODEGA LINCONTRO
		public function stock_producto($id){
			$cantidad = 0;

			$sql      = $this->bodega_sucursal->selectQuery("SELECT   SUM(stock_cantidad) stock
										   FROM     stock_productos_bodega
										   WHERE    stock_producto = $id
										   GROUP BY stock_producto");
			for ($i=0; $i < count($sql); $i++) { 
				$cantidad += $sql[$i]['stock'];
			}

			return $cantidad;
		}

		public function stock_producto_granel($id){
			$cantidad = 0;

			$sql    = $this->bodega_sucursal->selectQuery("SELECT   SUM(stock_granel) stock
										   FROM     stock_productos_bodega
										   WHERE    stock_producto = $id
										   GROUP BY stock_producto");

			for ($i=0; $i < count($sql); $i++) { 
				$cantidad += $sql[$i]['stock'];
			}
		}

		public function grabar_categorias($inputNombre, $idUser, $tipo_categoria){
			$grabar = $this->bodega_sucursal->insert_query("INSERT INTO categoria_productos(cate_nombre, cate_usuario, cate_estado, cate_tipo) 
				   						   VALUES('$inputNombre', '$idUser', 1, $tipo_categoria)");

			if($grabar > 0){
				return TRUE;
			}else{
				return FALSE;
			}
		}

		public function grabar_marcas($inputNombre){
			$grabar = $this->bodega_sucursal->insert_query("INSERT INTO marca_producto_bodega(mar_pro_nombre, mar_pro_estado) 
				   						   VALUES('$inputNombre', 1)");

			if($grabar > 0){
				return TRUE;
			}else{
				return FALSE;
			}
		}

		public function editar_marca($idMarca){
			$html   = '';
			$sql    = $this->bodega_sucursal->selectQuery("SELECT * FROM marca_producto_bodega
					   					  WHERE  		mar_pro_id = $idMarca");

			for ($i=0; $i < count($sql); $i++) { 
				$html .= ' <div class="row mb-4">
							  <p align="left" class="text-success font-weight-light h3">Nueva Categoria</p>
							  <hr class="mt-2 mb-3"/>
							    <div class="container mb-4">
							      <div class="row">
							        <div class="col-10 mb-2">
							          <label for="inputNombre"><b>Nombre</b></label>
							          <input type="text" class="form-control shadow" id="inputNombre" placeholder="Nombre" autocomplete="off" value="'.$sql[$i]['mar_pro_nombre'].'">
							        </div>
							        <div class="col-10 mb-2">
							          <button type="button" id="grabar" class="btn btn-primary form-control shadow" onclick="grabar_editar_marca('.$idMarca.')">Editar <i class="bi bi-save"></i></button>
							        </div>
							      </div>
							    </div>
							</div>';
			}

			return $html;
		}

		public function editar_categoria($idCategoria){
			$html   = '';
			$sql    = $this->bodega_sucursal->selectQuery("SELECT * FROM categoria_productos
					   					  WHERE  		cate_id = $idCategoria");

			for ($i=0; $i < count($sql); $i++) { 
				$html .= ' <div class="row mb-4">
							  <p align="left" class="text-success font-weight-light h3">Nueva Categoria</p>
							  <hr class="mt-2 mb-3"/>
							    <div class="container mb-4">
							      <div class="row">
							        <div class="col-10 mb-2">
							          <label for="inputNombre"><b>Nombre</b></label>
							          <input type="text" class="form-control shadow" id="inputNombre" placeholder="Nombre" autocomplete="off" value="'.$sql[$i]['cate_nombre'].'">
							        </div>
							        <div class="col-10 mb-2">
							          <button type="button" id="grabar" class="btn btn-primary form-control shadow" onclick="grabar_editar_categoria('.$idCategoria.')">Editar <i class="bi bi-save"></i></button>
							        </div>
							      </div>
							    </div>
							</div>';
			}

			return $html;
		}

		public function grabar_editar_categoria($inputNombre, $idCategoria){
			$sql = $this->bodega_sucursal->update_query("UPDATE categoria_productos
										SET    cate_nombre = '$inputNombre'
										WHERE  cate_id     = $idCategoria");

			return $sql;
		}

		public function grabar_editar_marca($inputNombre, $idMarca){
			$sql = $this->bodega_sucursal->update_query("UPDATE marca_producto_bodega
										SET    mar_pro_nombre = '$inputNombre'
										WHERE  mar_pro_id     = $idMarca");

			return $sql;
		}

			


/**  FIN BODEGA   **/

	}// END CLASS
?>