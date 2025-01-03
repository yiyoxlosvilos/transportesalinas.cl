<?php
	require_once __dir__."/../modelo/obtener_datos.php";
	require_once __dir__."/../controlador/utilidadesControlador.php";

	class Recursos extends GetDatos{

		public function nombre_marca($id){
			$data   = 0;
			$sql    = $this->selectQuery("SELECT * FROM marca_producto
					   					  WHERE  		mar_pro_id = $id");

			return ucfirst($sql[0]['mar_pro_nombre']);
		}

		public function listado_marcas_productos(){
			$sql    = $this->selectQuery("SELECT * FROM marca_producto
					   					  WHERE  		mar_pro_estado = 1");

			$html = ' <table id="marcas_list" class="table table-hover shadow-lg" style="width:100%">
			            <thead >
			              <tr class="table-info">
			                <th>Nombre</th>
			                <th>&nbsp;</th>
			                <th>&nbsp;</th>
			                <th>&nbsp;</th>
			              </tr>
			            </thead>
			            <tbody>';
			for ($i=0; $i < count($sql); $i++) { 
				$html .= '<tr>
				          	<td>'.ucfirst($sql[$i]['mar_pro_nombre']).'</td>
				          	<td>&nbsp;</td>
				          	<td>&nbsp;</td>
				          	<td align="center">
				          		<i class="bi bi-pencil-square text-primary ver" onclick="editar_marca('.$sql[$i]['mar_pro_id'].')"></i>
				          	</td>
				          </tr>';
			}

			$html .= ' </tbody>
					  </table>';

			return $html;
		}

		public function listado_marcas_productos_bodega(){
			$sql    = $this->selectQuery("SELECT * FROM marca_producto_bodega
					   					  WHERE  		mar_pro_estado = 1");

			$html = ' <table id="marcas_list" class="table table-hover shadow-lg" style="width:100%">
			            <thead >
			              <tr class="table-info">
			                <th>Nombre</th>
			                <th>&nbsp;</th>
			                <th>&nbsp;</th>
			                <th>&nbsp;</th>
			              </tr>
			            </thead>
			            <tbody>';
			for ($i=0; $i < count($sql); $i++) { 
				$html .= '<tr>
				          	<td>'.ucfirst($sql[$i]['mar_pro_nombre']).'</td>
				          	<td>&nbsp;</td>
				          	<td>&nbsp;</td>
				          	<td align="center">
				          		<i class="bi bi-pencil-square text-primary ver" onclick="editar_marca('.$sql[$i]['mar_pro_id'].')"></i>
				          	</td>
				          </tr>';
			}

			$html .= ' </tbody>
					  </table>';

			return $html;
		}


		public function nombre_categoria($id){
			$data   = 0;
			$sql    = $this->selectQuery("SELECT * FROM categoria_cliente
					   					  WHERE  		cate_id = $id");

			return ucfirst($sql[0]['cate_nombre']);
		}

		public function listado_categorias_productos(){
			$sql    = $this->selectQuery("SELECT * FROM categoria_cliente
					   					  WHERE  		cate_estado = 1");

			$html = ' <table id="categorias_list" class="table table-hover shadow-lg" style="width:100%">
			            <thead >
			              <tr class="table-info">
			                <th>Nombre</th>
			                <th>&nbsp;</th>
			                <th>&nbsp;</th>
			                <th>&nbsp;</th>
			              </tr>
			            </thead>
			            <tbody>';
			for ($i=0; $i < count($sql); $i++) { 
				$html .= '<tr>
				          	<td>'.ucfirst($sql[$i]['cate_nombre']).'</td>
				          	<td>&nbsp;</td>
				          	<td>&nbsp;</td>
				          	<td align="center">
				          		<i class="bi bi-pencil-square text-primary ver" onclick="editar_categoria('.$sql[$i]['cate_id'].')"></i>
				          	</td>
				          </tr>';
			}

			$html .= ' </tbody>
					  </table>';

			return $html;
		}

		public function listado_categorias_productos_bodega(){
			$sql    = $this->selectQuery("SELECT * FROM categoria_productos
					   					  WHERE  		cate_estado = 1");

			$html = ' <table id="categorias_list" class="table table-hover shadow-lg" style="width:100%">
			            <thead >
			              <tr class="table-info">
			                <th>Nombre</th>
			                <th>Categoría</th>
			                <th>&nbsp;</th>
			              </tr>
			            </thead>
			            <tbody>';
			for ($i=0; $i < count($sql); $i++) { 
				$html .= '<tr>
				          	<td>'.ucfirst($sql[$i]['cate_nombre']).'</td>
				          	<td>'.Utilidades::tipos_categorias($sql[$i]['cate_tipo']).'</td>
				          	<td align="center">
				          		<i class="bi bi-pencil-square text-primary ver" onclick="editar_categoria('.$sql[$i]['cate_id'].')"></i>
				          	</td>
				          </tr>';
			}

			$html .= ' </tbody>
					  </table>';

			return $html;
		}


		public function datos_fletes_gral(){
			$sql     = $this->selectQuery("SELECT * FROM fletes
										   WHERE  		 fle_estado != 0");

			return $sql;
		}

		public function datos_fletes_id($idFlete){
			$sql     = $this->selectQuery("SELECT * FROM fletes
										   WHERE  		 fle_id = $idFlete");

			return $sql;
		}

		public function datos_fletes($idServicio){
			$sql     = $this->selectQuery("SELECT * FROM fletes
										   WHERE  		 fle_servicio IN($idServicio)
										   AND    		 fle_estado   = 1");

			return $sql;
		}


		public function datos_fletes_monto($idServicio){
			$monto   = 0;
			$sql     = $this->datos_fletes($idServicio);

			for ($i=0; $i < count($sql); $i++) { 
				$monto += $sql[$i]['fle_valor']+$sql[$i]['fle_estadia'];
			}

			return $monto;
		}

		public function datos_traslados_monto($idServicio){
			$monto   = 0;
			$sql     = $this->selectQuery("SELECT * FROM traslados
										   WHERE  		 traslados_servicio IN($idServicio)
										   AND    		 traslados_estado   = 1");

			for ($i=0; $i < count($sql); $i++) { 
				$monto += ($sql[$i]['traslados_valor']*$sql[$i]['traslados_cantidad']);
			}

			return $monto;
		}

		public function datos_arriendos_monto($idServicio){
			$monto   = 0;
			$sql     = $this->selectQuery("SELECT * FROM item_arriendo
										   LEFT JOIN  	 arriendos
										   ON 			 arriendos.arriendo_id 			= item_arriendo.item_arriendo_id
										   WHERE  		 arriendos.arriendo_servicio_id IN($idServicio)
										   AND    		 arriendos.arriendo_estado   	= 1");

			for ($i=0; $i < count($sql); $i++) { 
				$monto += $sql[$i]['item_total'];
			}

			return $monto;
		}

		public function datos_arriendos_monto_id($idServicio){
			$monto   = 0;
			$sql     = $this->selectQuery("SELECT * FROM item_arriendo
										   LEFT JOIN  	 arriendos
										   ON 			 arriendos.arriendo_id 			= item_arriendo.item_arriendo_id
										   WHERE  		 arriendos.arriendo_id IN($idServicio)");

			for ($i=0; $i < count($sql); $i++) { 
				$monto += $sql[$i]['item_total'];
			}

			return $monto;
		}

		public function datos_comuna($idComuna){
			$sql  	= $this->selectQuery("SELECT * FROM cl_comuna
										  WHERE    		idComuna = $idComuna
										  AND           estado   = 1");

			return $sql;
		}

		public function nombre_localidad($id){
			$data   = 0;
			$sql    = $this->selectQuery("SELECT * FROM cl_comuna
					   					  WHERE  		idComuna = $id");

			return ucfirst($sql[0]['nombre']);
		}

		public function datos_gastos($idGasto){
			$sql    = $this->selectQuery("SELECT * FROM gastos_empresa
					   					  LEFT JOIN 	proveedor
					   					  ON 		 	proveedor.proveedor_id       = gastos_empresa.gas_proveedor
					   					  LEFT JOIN 	tipo_comprobante
					   					  ON 		 	tipo_comprobante.tpcom_id    = gastos_empresa.gas_tipo_dte
					   					  LEFT JOIN 	tipo_gastos
					   					  ON 		 	tipo_gastos.tpgas_id         = gastos_empresa.proveedor_id
					   					  WHERE     	gastos_empresa.gas_id        = $idGasto");

			if(count($sql) > 0){
				return $sql;
			}else{
				return null;
			}
		}

		public function datos_gasto_servicio($idServicio){
			$sql    = $this->selectQuery("SELECT * FROM gastos_empresa
					   					  WHERE     	gastos_empresa.gas_servicio  = $idServicio");

			if(count($sql) > 0){
				return $sql;
			}else{
				return null;
			}
		}

		public function datos_gastos_monto($idServicio){
			$monto   = 0;
			$sql     = $this->datos_gasto_servicio($idServicio);

			for ($i=0; $i < count(@$sql); $i++) { 
				$monto += $sql[$i]['gas_monto'];
			}

			return $monto;
		}

		public function datos_gasto_servicio_ruta($idServicio, $idTrabajador){
			$sql    = $this->selectQuery("SELECT * FROM gastos_empresa
					   					  WHERE     	gastos_empresa.gas_servicio  = $idServicio
					   					  AND           gastos_empresa.gas_chofer    = $idTrabajador");

			if(count($sql) > 0){
				return $sql;
			}else{
				return null;
			}
		}

		public function datos_gastos_monto_ruta($idServicio, $idTrabajador){
			$monto   = 0;
			$sql     = $this->datos_gasto_servicio_ruta($idServicio, $idTrabajador);

			for ($i=0; $i < count($sql); $i++) { 
				$monto += $sql[$i]['gas_monto'];
			}

			return $monto;
		}
		
		public function datos_facturas_proveedores($idFact){
			$sql    = $this->selectQuery("SELECT * FROM facturas_proveedores
					   					  LEFT JOIN 	proveedor
					   					  ON 		 	facturas_proveedores.fac_proveedor = proveedor.proveedor_id
					   					  WHERE     	facturas_proveedores.fac_id        = $idFact");

			if(count($sql) > 0){
				return $sql;
			}else{
				return null;
			}
		}

		public function datos_facturas_proveedores_servicio($idServicio){
			$sql    = $this->selectQuery("SELECT * FROM facturas_proveedores
					   					  LEFT JOIN 	proveedor
					   					  ON 		 	facturas_proveedores.fac_proveedor = proveedor.proveedor_id
					   					  WHERE     	facturas_proveedores.fac_servicio  = $idServicio");

			if(count($sql) > 0){
				return $sql;
			}else{
				return null;
			}
		}

		public function datos_facturas_monto($idServicio){
			$monto   = 0;
			$sql     = $this->datos_facturas_proveedores_servicio($idServicio);

			for ($i=0; $i < count($sql); $i++) { 
				$monto += $sql[$i]['fac_bruto'];
			}
			
			return $monto;
		}

		public function datos_clientes($idCliente){
			$sql    = $this->selectQuery("SELECT * FROM clientes
				   						  WHERE  		cli_id   = $idCliente");

			if(count($sql) > 0){
				return $sql;
			}else{
				return null;
			}
		}

		public function datos_clientes_servicio($idCotizacion){
			$sql    = $this->selectQuery("SELECT * FROM clientes
										  LEFT JOIN     cotizaciones
										  ON          	cotizaciones.coti_cliente = clientes.cli_id
				   						  WHERE  		cotizaciones.coti_id   	  = $idCotizacion");

			if(count($sql) > 0){
				return $sql;
			}else{
				return null;
			}
		}

		public function cliente_existe($rut){
			$sql    = $this->selectQuery("SELECT * FROM   clientes
				   						  WHERE  cli_rut   like '%$rut%'");

			return $sql;
		}

		public function datos_ventas($idLote){ 	//lote = numero de venta.

			$sql    = $this->selectQuery("SELECT * FROM ventascliente
				   						  WHERE    	    ven_cli_operacion = $idLote");

			if(count($sql) > 0){
				return $sql;
			}else{
				return null;
			}
		}

		public function historial_arriendo($idProducto){

			$sql    = $this->selectQuery("SELECT * FROM historial_productos
										  WHERE    		his_producto = $idProducto
										  ORDER BY 		his_id DESC LIMIT 1");

			if(count($sql) > 0){
				return $sql;
			}else{
				return null;
			}
		}

		public function datos_productos($idProducto){
			$sql    = $this->selectQuery("SELECT * FROM product_cliente
										  WHERE 		prod_cli_id = $idProducto");

			if(count($sql) > 0){
				return $sql;
			}else{
				return null;
			}
		}

		public function nombre_producto_patente($idProducto){
			$sql    = $this->selectQuery("SELECT * FROM product_cliente
										  WHERE 		prod_cli_id = $idProducto");

			return ucfirst($sql[0]['prod_cli_producto']).' '.ucwords($sql[0]['prod_cli_patente']);
		}

		public function datos_productos_codigo($codigo){
			$sql    = $this->selectQuery("SELECT * FROM product_cliente
										  WHERE 		prod_cli_codigo = '$codigo'");

			if(count($sql) > 0){
				return $sql;
			}else{
				return null;
			}
		}

		public function datos_productos_codigo_bodega($codigo){
			$sql    = $this->selectQuery("SELECT * FROM productos_bodega
										  WHERE 		prod_cli_codigo = '$codigo'");

			if(count($sql) > 0){
				return $sql;
			}else{
				return null;
			}
		}

		public function datos_trabajador($idTrabajador){
			$sql    = $this->selectQuery("SELECT * FROM trabajadores
										  WHERE 		tra_id = $idTrabajador");

			if(count($sql) > 0){
				return $sql;
			}else{
				return null;
			}
		}

		public function tipos_pagos_x_id($idTipoPago){

			$sql    = $this->selectQuery("SELECT * FROM tipos_pago
										  WHERE    		tipo_id = $idTipoPago");

			if(count($sql) > 0){
				return $sql;
			}else{
				return null;
			}
		}

		public function listado_categorias_gastos(){
			$sql    = $this->selectQuery("SELECT * FROM tipo_gastos
					   					  WHERE  		tpgas_estado = 1");

			$html = ' <table id="categorias_list" class="table table-hover shadow-lg" style="width:100%">
			            <thead >
			              <tr class="table-info">
			                <th>Nombre</th>
			                <th>&nbsp;</th>
			                <th>&nbsp;</th>
			                <th>&nbsp;</th>
			              </tr>
			            </thead>
			            <tbody>';
			for ($i=0; $i < count($sql); $i++) { 
				$html .= '<tr>
				          	<td>'.ucfirst($sql[$i]['tpgas_nombre']).'</td>
				          	<td>&nbsp;</td>
				          	<td>&nbsp;</td>
				          	<td align="center">
				          		<i class="bi bi-pencil-square text-primary ver" onclick="editar_categoria('.$sql[$i]['tpgas_id'].')"></i>
				          	</td>
				          </tr>';
			}

			$html .= ' </tbody>
					  </table>';

			return $html;
		}

		public function listado_tipo_categorias_gastos(){
			$sql    = $this->selectQuery("SELECT * FROM tipo_gastos_categoria
					   					  WHERE  		cate_estado = 1");

			$html = ' <table id="marcas_list" class="table table-hover shadow-lg" style="width:100%">
			            <thead >
			              <tr class="table-info">
			                <th>Nombre</th>
			                <th>Categoría</th>
			                <th>&nbsp;</th>
			                <th>&nbsp;</th>
			              </tr>
			            </thead>
			            <tbody>';
			for ($i=0; $i < count($sql); $i++) { 
				$html .= '<tr>
				          	<td>'.ucfirst($sql[$i]['cate_nombre']).'</td>
				          	<td>'.$this->nombre_tipo_gastos($sql[$i]['cate_tipo']).'</td>
				          	<td>&nbsp;</td>
				          	<td align="center">
				          		<i class="bi bi-pencil-square text-primary ver" onclick="editar_categoria_tipo('.$sql[$i]['cate_id'].')"></i>
				          	</td>
				          </tr>';
			}

			$html .= ' </tbody>
					  </table>';

			return $html;
		}

		public function editar_categoria_tipo($tipo_gastos){
			$html   = '';
			$sql    = $this->selectQuery("SELECT * FROM tipo_gastos_categoria
					   					  WHERE  		cate_id = $tipo_gastos");

			for ($i=0; $i < count($sql); $i++) { 
				$html .= ' <div class="row mb-4">
							  <p align="left" class="text-success font-weight-light h3">Editar Categoría</p>
							  <hr class="mt-2 mb-3"/>
							    <div class="container mb-4">
							      <div class="row">
							        <div class="col-10 mb-2">
							          <label for="inputNombre"><b>Nombre</b></label>
							          <input type="text" class="form-control shadow" id="inputNombre" placeholder="Nombre" autocomplete="off" value="'.$sql[$i]['cate_nombre'].'">
							        </div>
							        <div class="col-10 mb-2">
							          <label for="inputCategoria"><b>Categor&iacute;a</b></label>
							          '.$this->select_tipo_gastos("", $sql[$i]['cate_tipo']).'
							        </div>
							        <div class="col-5 mb-2">
							          <button type="button" id="grabar" class="btn btn-primary form-control shadow" onclick="grabar_editar_categoria_tipo('.$tipo_gastos.')">Editar <i class="bi bi-save"></i></button>
							        </div>
							        <div class="col-5 mb-2">
							          <button type="button" id="grabar" class="btn btn-danger form-control shadow" onclick="desactivar_categoria_tipo('.$tipo_gastos.')">Desactivar<i class="bi bi-save"></i></button>
							        </div>
							      </div>
							    </div>
							</div>';
			}

			return $html;
		}

		public function select_tipo_gastos($funcion, $idgasto){

			$sql = $this->selectQuery("SELECT * FROM tipo_gastos
					   				   WHERE  		 tpgas_estado = 1");

			if(strlen($funcion) > 0){
				$script = ' onchange="'.$funcion.'()"';
			}else{
				$script = '';
			}

			$html = '<select id="tipo_gastos" class="form-control shadow" '.$script.'>';
			$html .= '<option value="0" selected="selected">Seleccionar Gasto</option>';

			for ($i=0; $i <= count($sql); $i++) { 
				if($sql[$i]['tpgas_id'] == $idgasto && $sql[$i]['tpgas_id'] > 0){
					$html .= '<option value="'.$sql[$i]['tpgas_id'].'" selected="selected">'.$sql[$i]['tpgas_nombre'].'</option>';

				}elseif($sql[$i]['tpgas_id'] > 0){
					$html .= '<option value="'.$sql[$i]['tpgas_id'].'">'.$sql[$i]['tpgas_nombre'].'</option>';
				}
			}

            $html .='         </select>';

            return $html;
		}

		public function nombre_tipo_gastos($id){
			$data   = 0;
			$sql    = $this->selectQuery("SELECT * FROM tipo_gastos
					   					  WHERE  		tpgas_id = $id");

			return ucfirst($sql[0]['tpgas_nombre']);
		}

		public function select_tipo_categorias_gastos_dinamico($funcion, $idGasto){

			$sql    = $this->selectQuery("SELECT * FROM tipo_gastos_categoria
					   					  WHERE  		cate_estado = 1
					   					  AND           cate_tipo   = $idGasto");

			if(strlen($funcion) > 0){
				$script = ' onchange="'.$funcion.'()"';
			}else{
				$script = '';
			}

			$html = '<select id="tipo_gastos_categorias" class="form-control shadow" '.$script.'>';
			$html .= '<option value="0" selected="selected">Seleccionar Tipo</option>';

			for ($i=0; $i <= count($sql); $i++) { 

				if($sql[$i]['cate_id'] > 0){
					$html .= '<option value="'.$sql[$i]['cate_id'].'">'.$sql[$i]['cate_nombre'].'</option>';
				}
				
			}

            $html .='         </select>';

            return $html;
		}

		public function select_tipo_categorias_gastos($funcion, $idgasto){

			$sql    = $this->selectQuery("SELECT * FROM tipo_gastos_categoria
					   					  WHERE  		cate_estado = 1");

			if(strlen($funcion) > 0){
				$script = ' onchange="'.$funcion.'()"';
			}else{
				$script = '';
			}

			$html = '<select id="tipo_gastos" class="form-select form-select-sm" '.$script.'>';
			$html .= '<option value="0" selected="selected">Seleccionar Tipo</option>';

			for ($i=0; $i <= count($sql); $i++) { 
				if($sql[$i]['cate_id'] === $idgasto){
					$html .= '<option value="'.$sql[$i]['cate_id'].'" selected="selected">'.$sql[$i]['cate_nombre'].'</option>';

				}else{
					$html .= '<option value="'.$sql[$i]['cate_id'].'">'.$sql[$i]['cate_nombre'].'</option>';
				}
			}

            $html .='         </select>';

            return $html;
		}

		public function nombre_tipo_categorias_gastos($id){
			$data   = 0;
			$sql    = $this->selectQuery("SELECT * FROM tipo_gastos_categoria
					   					  WHERE  		cate_id = $id");

			return ucfirst($sql[0]['cate_nombre']);
		}

		public function datos_proveedores($idProoveedor){
			$sql    = $this->selectQuery("SELECT * FROM proveedor
										  WHERE  		proveedor_id = $idProoveedor");

			return $sql;
		}

		public function estado_factura($id){
			$sql    = $this->selectQuery("SELECT * FROM tipo_facturas
				   						  WHERE  		tip_id = $id");

			return $sql;
		}

		public function nombre_tipo_contrato($tipo){
			$sql    = $this->selectQuery("SELECT * FROM tipo_contratos
				   						  WHERE  		tip_id = $tipo");

			return $sql;
		}

		public function nombre_estado_contrato($tipo){
			$sql    = $this->selectQuery("SELECT * FROM tipo_estado_trabajador
				   						  WHERE  		tip_id = $tipo");

			return $sql;
		}

		public function select_proveedor($funcion, $idProveedor){

			$sql = $this->selectQuery("SELECT * FROM proveedor
				   					   WHERE  		 proveedor_estado = 1");

			if(strlen($funcion) > 0){
				$script = ' onchange="'.$funcion.'()"';
			}else{
				$script = '';
			}

			$html = '<select id="inputProveedor" class="form-control shadow" '.$script.'>';
			$html .= '<option value="0" selected="selected">Seleccionar Proveedor</option>';

			for ($i=0; $i <= count($sql); $i++) { 
				if($sql[$i]['proveedor_id'] === $idProveedor){
					$html .= '<option value="'.$sql[$i]['proveedor_id'].'" selected="selected">'.$sql[$i]['proveedor_nombre'].'</option>';

				}else{
					$html .= '<option value="'.$sql[$i]['proveedor_id'].'">'.$sql[$i]['proveedor_nombre'].'</option>';
				}
			}

            $html .='         </select>';

            return $html;
		}

		public function select_estado_factura($funcion, $idTipo){

			$sql = $this->selectQuery("SELECT * FROM tipo_facturas
				   					   WHERE  		 tip_estado = 1");

			if(strlen($funcion) > 0){
				$script = ' onchange="'.$funcion.'()"';
			}else{
				$script = '';
			}

			$html = '<select '.$script.' id="inputEstadoFactura" class="form-control shadow">
						<option value="0" selected="selected">Seleccionar Tipo</option>';

			foreach ($sql as $factura) { 
		        $selected = ($factura['tip_id'] == $idTipo) ? 'selected="selected"' : '';
		        $html .= '<option value="'.$factura['tip_id'].'" '.$selected.'>'.$factura['tip_nombre'].'</option>';
		    }

            $html .='         </select>';

            return $html;
		}

		public function select_tipo_contrato($funcion, $idTipo){
	    	$data   = 0;
			$sql    = $this->selectQuery("SELECT * FROM tipo_contratos
					   					  WHERE  		tip_estado = 1");

			if(strlen($funcion) > 0){
				$script = ' onchange="'.$funcion.'()"';
			}else{
				$script = '';
			}

			$html   = '<select '.$script.' name="inputTipoContrato" id="inputTipoContrato" class="form-select shadow">
						<option value="0">Seleccionar Tipo</option>';

			for ($i=0; $i < count($sql); $i++) { 
				if($sql[$i]['tip_id'] == $idTipo){
					$html   .= '<option value="'.$sql[$i]['tip_id'].'" selected="selected">'.$sql[$i]['tip_nombre'].'</option>';
				}else{
					$html   .= '<option value="'.$sql[$i]['tip_id'].'">'.$sql[$i]['tip_nombre'].'</option>';
				}
			}


			$html   .= '</select>';

			return $html;
		}

		public function datos_parametros(){
		    $sql    = $this->selectQuery("SELECT * FROM parametros
		    		   					  WHERE  		par_estado = 1");

			return $sql;
		}

		public function solo_logo(){
			$parametros = $this->datos_parametros();

			if(count($parametros[0]['par_logo']) == 0){
				$img = 'logo_cc2.png';
			}else{
				$img = $parametros[0]['par_logo'];
			}

			return $img;
		}

		public function imagen_empresa(){
			$parametros = $this->datos_parametros();

			if(count($parametros[0]['par_logo']) == 0){
				$img = '<img src="'.controlador::$rutaAPP.'app/recursos/img/logo_cc2.png" width="54%" align="center" >';
			}else{
				$img = '<img src="'.controlador::$rutaAPP.'app/recursos/img/'.$parametros[0]['par_logo'].'" width="54%" align="center" >';
			}

			return $img;
		}

		public function imagen_empresa_boleta(){
			$parametros = $this->datos_parametros();

			if(count($parametros[0]['par_logo']) == 0){
				$img = '<img src="'.controlador::$rutaAPP.'app/recursos/img/logo_cc2.png" width="50%" align="center" style="filter: grayscale(100%);">';
			}else{
				$img = '<img src="'.controlador::$rutaAPP.'app/recursos/img/'.$parametros[0]['par_logo'].'" width="50%" align="center" style="filter: grayscale(100%);">';
			}

			return $img;
		}

		public function minimo_impuesto_unico(){
		    $sql    = $this->selectQuery("SELECT * FROM impuesto_unico
		    		   					  WHERE  		imp_estado = 1
		    		   					  ORDER BY      imp_desde ASC 
		    		   					  LIMIT 1");

			return $sql;
		}

		public function rango_impuesto_unico($numero){
		    $sql    = $this->selectQuery("SELECT * FROM impuesto_unico
		    		   					  WHERE  		imp_estado  = 1
		    		   					  AND 			('$numero' >= imp_desde AND '$numero '<= imp_hasta)
		    		   					  ORDER BY      imp_desde ASC 
		    		   					  LIMIT 1");

			return $sql;
		}

		public function rebaja_impuesto_unico($idImpuesto, $mes){
		    $sql    = $this->selectQuery("SELECT * FROM impuestos_rebajas_mes
		    		   					  WHERE  		reb_mes   = '$mes'
		    		   					  AND 			reb_tramo = $idImpuesto
		    		   					  AND           reb_estado=1");

			return $sql;
		}

		public function select_opciones_afp($funcion, $idTipo){
	    	$data   = 0;
			$sql    = $this->selectQuery("SELECT * FROM pensiones
					   					  WHERE  		pre_estado = 1");

			if(strlen($funcion) > 0){
				$script = ' onchange="'.$funcion.'()"';
			}else{
				$script = '';
			}

			$html   = '<select '.$script.' name="afp" id="afp" class="form-select shadow">
						<option value="0">Seleccionar AFP</option>';

			for ($i=0; $i < count($sql); $i++) { 
				if($sql[$i]['pre_id'] == $idTipo){
					$html   .= '<option value="'.$sql[$i]['pre_descuento'].'" selected="selected">'.$sql[$i]['pre_nombre'].'</option>';
				}else{
					$html   .= '<option value="'.$sql[$i]['pre_descuento'].'">'.$sql[$i]['pre_nombre'].'</option>';
				}
			}

			$html   .= '</select>';

			return $html;
		}

		public function select_opciones_prevision($funcion, $idTipo){
	    	$data   = 0;
			$sql    = $this->selectQuery("SELECT * FROM previsiones
					   					  WHERE  		pre_estado = 1");

			if(strlen($funcion) > 0){
				$script = ' onchange="'.$funcion.'()"';
			}else{
				$script = '';
			}

			$html   = '<select '.$script.' name="salud" id="salud" class="form-select shadow">
						<option value="0">Seleccionar Previsi&oacute;n</option>';

			for ($i=0; $i < count($sql); $i++) { 
				if($sql[$i]['pre_id'] == $idTipo){
					$html   .= '<option value="'.$sql[$i]['pre_descuento'].'" selected="selected">'.$sql[$i]['pre_nombre'].'</option>';
				}else{
					$html   .= '<option value="'.$sql[$i]['pre_descuento'].'">'.$sql[$i]['pre_nombre'].'</option>';
				}
			}

			$html   .= '</select>';

			return $html;
		}

		public function datos_compensacion($idCaja){
			$sql    = $this->selectQuery("SELECT * FROM compensaciones
							    		  WHERE  		pre_id = $idCaja");

			return $sql;
		}

		public function caja_compensacion(){
	    	$data   = 0;
			$sql    = $this->selectQuery("SELECT * FROM compensaciones
							    		  WHERE  		pre_estado = 1");

			if(strlen($funcion) > 0){
				$script = ' onchange="'.$funcion.'()"';
			}else{
				$script = '';
			}

			$html   = '<select '.$script.' name="caja_compensacion" id="caja_compensacion" class="form-select shadow">
						<option value="0">Ninguna</option>';

			for ($i=0; $i < count($sql); $i++) { 
				if($sql[$i]['pre_id'] == $idTipo){
					$html   .= '<option value="'.$sql[$i]['pre_id'].'" selected="selected">'.$sql[$i]['pre_nombre'].'</option>';
				}else{
					$html   .= '<option value="'.$sql[$i]['pre_id'].'">'.$sql[$i]['pre_nombre'].'</option>';
				}
			}

			$html   .= '</select>';

			return $html;		   

		}

		public function select_tipo_permiso($idTipo){
	    	$data   = 0;
			$sql    = $this->selectQuery("SELECT * FROM   tipo_permiso_vacaciones
	    		   						  WHERE  tip_estado  = 1");

			$html   = '<select '.$script.' name="tipo_permiso" id="tipo_permiso" class="form-select shadow">
						<option value="0">Seleccionar Tipo</option>';

			for ($i=0; $i < count($sql); $i++) { 
				if($sql[$i]['tip_id'] == $idTipo){
					$html   .= '<option value="'.$sql[$i]['tip_id'].'" selected="selected">'.$sql[$i]['tip_nombre'].'</option>';
				}else{
					$html   .= '<option value="'.$sql[$i]['tip_id'].'">'.$sql[$i]['tip_nombre'].'</option>';
				}
			}

			$html   .= '</select>';

			return $html;		   

		}

		public function datos_trabajadores($idEstado){
	    	$sql  	= $this->selectQuery("SELECT * FROM trabajadores
	    								  WHERE         tra_estado = $idEstado
				   						  ORDER BY   	tra_nombre ASC");

	    	return $sql;
	    }

	    public function datos_liquidaciones_trabajador($idTrabajador, $mes, $ano){
	    	$desde 	= $ano.'-'.$mes.'-01';
	    	$hasta 	= date("Y-m-t", strtotime($desde));

	    	$sql  	= $this->selectQuery("SELECT * FROM liquidaciones_sueldo 
	    								  INNER JOIN 	trabajadores
	    								  ON  			trabajadores.tra_id = liquidaciones_sueldo.liquid_trabajador
	    								  WHERE         liquidaciones_sueldo.liquid_trabajador = $idTrabajador
	    								  AND           liquidaciones_sueldo.liquid_fecha 	   BETWEEN '$desde' AND '$hasta'
				   						  ORDER BY   	trabajadores.tra_nombre ASC");

	    	return $sql;
	    }

	    public function datos_finiquito_trabajador($idTrabajador){

	    	$sql  	= $this->selectQuery("SELECT * FROM finiquito_trabajador 
	    								  INNER JOIN 	trabajadores
	    								  ON  			trabajadores.tra_id = finiquito_trabajador.fin_trabajador
	    								  WHERE         finiquito_trabajador.fin_trabajador = $idTrabajador
				   						  ORDER BY   	trabajadores.tra_nombre ASC");

	    	return $sql;
	    }

	    public function datos_liquidaciones_trabajadores($idEstado, $ano, $mes){
	    	$desde 	= $ano.'-'.$mes.'-01';
	    	$hasta 	= date("Y-m-t", strtotime($desde));

	    	$sql  	= $this->selectQuery("SELECT * FROM trabajadores
	    								  INNER JOIN 	liquidaciones_sueldo
	    								  ON  			liquidaciones_sueldo.liquid_trabajador = trabajadores.tra_id
	    								  WHERE         trabajadores.tra_estado 			   = $idEstado
	    								  AND           liquidaciones_sueldo.liquid_fecha BETWEEN '$desde' AND '$hasta'
				   						  ORDER BY   	trabajadores.tra_nombre ASC");

	    	return $sql;
	    }

	    public function datos_empresa(){
	    	// emp_razonsocial, emp_rut, emp_direccion
			$sql  	= $this->selectQuery("SELECT * FROM empresa");

			return $sql;
	    }

	    public function datos_previsiones_general($id){
			$sql    = $this->selectQuery("SELECT * FROM previsiones
							    		  WHERE  		pre_id = $id");

			return $sql;
		}

		public function datos_pensiones_general($id){
			$sql    = $this->selectQuery("SELECT * FROM pensiones
							    		  WHERE  		pre_id = $id");

			return $sql;
		}

		public function datos_isapres_general($id){
			$sql    = $this->selectQuery("SELECT * FROM isapres
							    		  WHERE  		pre_id = $id");

			return $sql;
		}

		public function datos_compensaciones_general($id){
			$sql    = $this->selectQuery("SELECT * FROM compensaciones
							    		  WHERE  		pre_id = $id");

			return $sql;
		}

		public function datos_usuarios_todos(){
			$sql  	= $this->selectQuery("SELECT   us_cli_id, us_cli_tipoUsuario, us_cli_nombre, us_cli_nick, 
												   us_cli_pass, us_cli_rut, us_cli_empresa,
												   us_cli_sucursal, us_cli_mail
										  FROM     usuario_cli
										  WHERE    us_cli_estado   = 1
										  ORDER BY us_cli_id DESC");
			return $sql;
		}

		public function datos_usuario($idUsuario){ // us_cli_empresa
			$sql    = $this->selectQuery("SELECT * FROM usuario_cli WHERE us_cli_id=$idUsuario");

			return $sql;
		}

		public function datos_fecha_fin_entrega($numBoleta = 0){//caja_cliente
			$sql    = $this->selectQuery("SELECT * FROM caja_cliente
							    		  WHERE  		c_cli_lote = $numBoleta
							    		  ORDER BY c_cli_fecha_fin DESC LIMIT 1");

			return $sql;
		}

		public function select_sucursales($idSucursal = 0){
			
			$sql  	= $this->selectQuery("SELECT * FROM sucursales
										  WHERE    		suc_estado = 1");

			$html   = '<select   name="inputSucursal" id="inputSucursal" class="form-select shadow">
						<option value="0">Seleccionar Sucursal</option>';

			for ($i=0; $i < count($sql); $i++) { 
				if($sql[$i]['suc_id'] == $idSucursal){
					$html   .= '<option value="'.$sql[$i]['suc_id'].'" selected="selected">'.$sql[$i]['suc_nombre'].'</option>';
				}else{
					$html   .= '<option value="'.$sql[$i]['suc_id'].'">'.$sql[$i]['suc_nombre'].'</option>';
				}
			}

			$html   .= '</select>';

			return $html;
		}

		public function select_tipo_usuario($idTipoUsuario = 0){
			
			$sql  	= $this->selectQuery("SELECT * FROM categorias_usuarios
										  WHERE    		cat_estado = 1");

			$html   = '<select '.$script.' name="inputTipoUsuario" id="inputTipoUsuario" class="form-select shadow">
						<option value="0">Seleccionar Tipo Usuario</option>';

			for ($i=0; $i < count($sql); $i++) { 
				if($sql[$i]['cat_id'] == $idTipoUsuario){
					$html   .= '<option value="'.$sql[$i]['cat_id'].'" selected="selected">'.$sql[$i]['cat_nombre'].'</option>';
				}else{
					$html   .= '<option value="'.$sql[$i]['cat_id'].'">'.$sql[$i]['cat_nombre'].'</option>';
				}
			}

			$html   .= '</select>';

			return $html;
		}

		public function select_localidad($idLocalidad = 0){
			
			$sql  	= $this->selectQuery("SELECT * FROM cl_localidad
										  WHERE    		loc_estado = 1");

			$html   = '<select '.$script.' name="inputLocalidad" id="inputLocalidad" class="form-select shadow">
						<option value="0">Seleccionar Localidad</option>';

			for ($i=0; $i < count($sql); $i++) { 
				if($sql[$i]['loc_id'] == $idSucursal){
					$html   .= '<option value="'.$sql[$i]['loc_id'].'" selected="selected">'.$sql[$i]['loc_nombre'].'</option>';
				}else{
					$html   .= '<option value="'.$sql[$i]['loc_id'].'">'.$sql[$i]['loc_nombre'].'</option>';
				}
			}

			$html   .= '</select>';

			return $html;
		}

		public function seleccionar_localidad2($idFlete = 0, $nombre, $tipo_localidad = 0, $acciones= ''){

			$sql  	= $this->selectQuery("SELECT * FROM cl_comuna
										  WHERE    		estado = 1");
			$acciones='';
			if($acciones=='readonly'){
				$acciones='disabled';
			}

			$html   = '<select name="'.$nombre.'" id="'.$nombre.'" class="form-select shadow" multiple="multiple" '.$acciones.'>
						<option value="0">Seleccionar Localidad</option>';

			if($idFlete > 0){
				$datos_fletes_id =  $this->datos_fletes_id($idFlete);
				$explode_origen  = explode(",", $datos_fletes_id[0]['fle_origen']);
				$explode_destino = explode(",", $datos_fletes_id[0]['fle_destino']);

				$localidades = array();

				if($tipo_localidad == 1){
					for ($l=0; $l < count($explode_origen); $l++) { 
		            	$localidades[] = $explode_origen[$l];
	            	}
				}elseif($tipo_localidad == 2){
					for ($l=0; $l < count($explode_destino); $l++) { 
		            	$localidades[] = $explode_destino[$l];
	            	}
				}	 

				for ($i=0; $i < count($sql); $i++) { 
					if(in_array($sql[$i]['idComuna'], $localidades)){
						$html   .= '<option value="'.$sql[$i]['idComuna'].'" selected="selected">'.$sql[$i]['nombre'].'</option>';
					}else{
						$html   .= '<option value="'.$sql[$i]['idComuna'].'">'.$sql[$i]['nombre'].'</option>';
					}
				}
			}else{
				for ($i=0; $i < count($sql); $i++) { 
					if($sql[$i]['idComuna'] == $idLocalidad){
						$html   .= '<option value="'.$sql[$i]['idComuna'].'" selected="selected">'.$sql[$i]['nombre'].'</option>';
					}else{
						$html   .= '<option value="'.$sql[$i]['idComuna'].'">'.$sql[$i]['nombre'].'</option>';
					}
				}
			}

			

			$html   .= '</select>';

			return $html;
		}

		public function seleccionar_localidad($idLocalidad = 0, $nombre, $multiple = 0){
			$multiple_data = '';

			if($multiple == 1){
				$multiple_data = 'multiple="multiple"';
			}
			
			$sql  	= $this->selectQuery("SELECT * FROM cl_comuna
										  WHERE    		estado = 1");

			$html   = '<select name="'.$nombre.'" id="'.$nombre.'" class="form-select shadow" '.$multiple_data.'>
						<option value="0">Localidad</option>';

			for ($i=0; $i < count($sql); $i++) { 
				if($sql[$i]['idComuna'] == $idLocalidad){
					$html   .= '<option value="'.$sql[$i]['idComuna'].'" selected="selected">'.$sql[$i]['nombre'].'</option>';
				}else{
					$html   .= '<option value="'.$sql[$i]['idComuna'].'">'.$sql[$i]['nombre'].'</option>';
				}
			}

			$html   .= '</select>';

			return $html;
		}

		public function select_tipo_comprobante($idTipo = 0){
			
			$sql  	= $this->selectQuery("SELECT * FROM tipo_comprobante
										  WHERE    		tpgas_estado = 1");

			$html   = '<select onchange="tipo_documento()" name="tipo_dte" id="tipo_dte" class="form-select shadow">
						<option value="0">Seleccionar</option>';

			for ($i=0; $i < count($sql); $i++) { 
				if($sql[$i]['tpgas_id'] == $idTipo){
					$html   .= '<option value="'.$sql[$i]['tpcom_id'].'" selected="selected">'.$sql[$i]['tpcom_nombre'].'</option>';
				}else{
					$html   .= '<option value="'.$sql[$i]['tpcom_id'].'">'.$sql[$i]['tpcom_nombre'].'</option>';
				}
			}

			$html   .= '</select>';

			return $html;
		}

		public function select_tipos_pago($idTipo = 0){
			
			$sql  	= $this->selectQuery("SELECT * FROM tipos_pago
										  WHERE    		tipo_estado = 1");

			$html   = '<select onchange="tipo_pagar()" name="tipo_pago" id="tipo_pago" class="form-select shadow">
						<option value="0">Seleccionar</option>';

			for ($i=0; $i < count($sql); $i++) { 
				if($sql[$i]['tipo_id'] == $idTipo){
					$html   .= '<option value="'.$sql[$i]['tipo_id'].'" selected="selected">'.$sql[$i]['tipo_nombre'].'</option>';
				}else{
					$html   .= '<option value="'.$sql[$i]['tipo_id'].'">'.$sql[$i]['tipo_nombre'].'</option>';
				}
			}

			$html   .= '</select>';

			return $html;
		}

		public function select_clientes_buscar($idCliente = 0, $ano, $mes){
			
			$sql  	= $this->selectQuery("SELECT * FROM clientes
										  WHERE    		cli_estado = 1");

			$html   = '<select name="clientes" id="clientes" class="form-select shadow bg-white" onchange="mostrar_agendas('.$ano.', '.$mes.')">
						<option value="0">TODOS</option>';

			for ($i=0; $i < count($sql); $i++) { 
				if($sql[$i]['cli_id'] == $idCliente){
					$html   .= '<option value="'.$sql[$i]['cli_id'].'" selected="selected">'.$sql[$i]['cli_nombre'].'</option>';
				}else{
					$html   .= '<option value="'.$sql[$i]['cli_id'].'">'.$sql[$i]['cli_nombre'].'</option>';
				}
			}

			$html   .= '</select>';

			return $html;
		}

		public function select_clientes($idCliente = 0){
			
			$sql  	= $this->selectQuery("SELECT * FROM clientes
										  WHERE    		cli_estado = 1");

			$html   = '<select name="clientes" id="clientes" class="form-select shadow bg-white">
						<option value="0">Seleccionar cliente</option>';

			for ($i=0; $i < count($sql); $i++) { 
				if($sql[$i]['cli_id'] == $idCliente){
					$html   .= '<option value="'.$sql[$i]['cli_id'].'" selected="selected">'.$sql[$i]['cli_nombre'].'</option>';
				}else{
					$html   .= '<option value="'.$sql[$i]['cli_id'].'">'.$sql[$i]['cli_nombre'].'</option>';
				}
			}

			$html   .= '</select>';

			return $html;
		}

		public function correlativo($idEmpresa, $idSucursal){
			$data = 0;
			$sql  = $this->selectQuery("SELECT 	cont_ven_correlativo 
										FROM 	conteo_ventas 
										WHERE 	cont_ven_idEmpresa = $idEmpresa
										AND   	cont_ven_idSucursal= $idSucursal");

			for ($i=0; $i < count($sql); $i++) { 
				$data += $sql[$i]['cont_ven_correlativo'];
			}

			return $data;// code...
		}

		public function upCorrelativo($idEmpresa, $idSucursal){
			$sql = $this->update_query("UPDATE conteo_ventas 
										SET    cont_ven_correlativo = cont_ven_correlativo+1 
										WHERE 	cont_ven_idEmpresa = $idEmpresa
										AND   	cont_ven_idSucursal= $idSucursal");

			return $sql;
		}

		public function datos_clientes_cajas($numBoleta = 0){//caja_cliente
			$sql    = $this->selectQuery("SELECT * FROM caja_cliente
										  LEFT JOIN     clientes
										  ON            clientes.cli_id = caja_cliente.c_cli_clientes
							    		  WHERE  		caja_cliente.c_cli_lote = $numBoleta
							    		  ORDER BY 		caja_cliente.c_cli_clientes DESC LIMIT 1");

			return $sql;
		}

		public function fecha_pago_plazo($boleta){

			$sql    = $this->selectQuery("SELECT   gas_fecha_pago
										  FROM     pendiete_pago
										  WHERE    gas_boleta = $boleta");

			return $sql[0]['gas_fecha_pago'];
		}

		public function datos_pago_plazo($boleta){

			$sql    = $this->selectQuery("SELECT * FROM pendiete_pago
										  LEFT JOIN 	clientes
										  ON        	clientes.cli_id    		 = pendiete_pago.gas_cliente
										  WHERE    		pendiete_pago.gas_boleta = $boleta");

			return $sql;
		}

		public function datos_ventas_tipo_datos($boleta){
			$sql    = $this->selectQuery("SELECT * FROM ventascliente
										  LEFT JOIN 	tipos_pago
										  ON        	tipos_pago.tipo_id = ventascliente.ven_tipo_venta
										  WHERE    		ven_cli_operacion  = $boleta");

			return $sql;
		}

		public function datos_boleta($boleta){
			$sql    = $this->selectQuery("SELECT * FROM caja_cliente
										  LEFT JOIN     clientes
										  ON            clientes.cli_id 				= caja_cliente.c_cli_clientes
										  LEFT JOIN     ventascliente
										  ON            ventascliente.ven_cli_operacion	= caja_cliente.c_cli_lote
							    		  WHERE  		caja_cliente.c_cli_lote 		= $boleta
							    		  ORDER BY 		caja_cliente.c_cli_lote DESC LIMIT 1");

			return $sql;
		}

		public function seleccion_categoria_cliente($id = 0){
			$data   = 0;
			$sql    = $this->selectQuery("SELECT * FROM categoria_cliente
					   					  WHERE  		cate_estado = 1
					   					  ORDER BY 		cate_nombre ASC");

			$html   = '<select name="inputCategoria" id="inputCategoria" class="form-select shadow" onchange="traer_formulario_adicionar()">
						<option value="0">Seleccionar Categoría</option>';

			for ($i=0; $i < count($sql); $i++) { 
				if($sql[$i]['cate_id'] == $id){
					$html   .= '<option value="'.$sql[$i]['cate_id'].'" selected="selected">'.$sql[$i]['cate_nombre'].'</option>';
				}else{
					$html   .= '<option value="'.$sql[$i]['cate_id'].'">'.$sql[$i]['cate_nombre'].'</option>';
				}
			}


			$html   .= '</select>';

			return $html;
		}

		public function datos_productos_categoria($idCategoria){
			$sql    = $this->selectQuery("SELECT * FROM product_cliente
										  WHERE 		prod_cli_categoria = $idCategoria");

			if(count($sql) > 0){
				return $sql;
			}else{
				return null;
			}
		}

		public function datos_productos_boletas($boleta){
			$sql    = $this->selectQuery("SELECT * FROM caja_cliente
										  LEFT JOIN     product_cliente
										  ON  		    product_cliente.prod_cli_id 		= caja_cliente.c_cli_prod_cliente
				   						  WHERE  		caja_cliente.c_cli_lote           	= $boleta
				   						  AND    		caja_cliente.c_cli_tipoMovimiento 	= 3");

			return $sql;
		}

		public function select_productos_general($idCategoria = 0, $boleta){
			$script = '';
			if ($idCategoria > 0) {
				$script .= " AND prod_cli_categoria = $idCategoria";
			}
			
			$sql  	= $this->selectQuery("SELECT * FROM product_cliente
										  WHERE    		prod_cli_estado = 1".$script);

			$html   = '<select name="productos" id="productos" class="form-select shadow" onchange="traer_formulario_adicionar('.$boleta.')">
						<option value="0">Seleccionar</option>';

			for ($i=0; $i < count($sql); $i++) { 
				if($sql[$i]['prod_cli_id'] == $idCliente){
					$html   .= '<option value="'.$sql[$i]['prod_cli_id'].'" selected="selected">'.$sql[$i]['prod_cli_producto'].'</option>';
				}else{
					$html   .= '<option value="'.$sql[$i]['prod_cli_id'].'">'.$sql[$i]['prod_cli_producto'].' - '.$sql[$i]['prod_cli_patente'].'</option>';
				}
			}

			$html   .= '</select>';

			return $html;
		}

		public function historial_producto($boleta, $idProd){

			$sql    = $this->selectQuery("SELECT * FROM historial_productos
								   	      WHERE         his_boleta   = $boleta
								   	   	  AND      	 	his_producto = $idProd");

			return $html;

		}

		public function traer_clientes_consulta($estado = 0){
			$data     = 0;
			$recursos = new Recursos();

			if($estado == 0){
				$script = "";
			}else{
				$script = " WHERE cli_estado = ".$estado;	
			}

			$sql    = $this->selectQuery("SELECT * FROM clientes
										  $script
				   						  ORDER BY   	cli_nombre ASC");

			$html = ' <table id="clientes_list" class="table table-hover" style="width:100%">
			            <thead >
			              <tr class="table-info">
			                <th>Razon Social</th>
			                <th>Giro</th>
			                <th>Rut</th>
			                <th>Tel&eacute;fono</th>
			                <th>E-Mail</th>
			                <th>&nbsp;</th>
			              </tr>
			            </thead>
			            <tbody>';
			for ($i=0; $i < count($sql); $i++) { 
				$html .= '<tr>
				          	<td>'.$sql[$i]['cli_nombre'].'</td>
				          	<td>'.$sql[$i]['cli_giro'].'</td>
				          	<td>'.Utilidades::rut($sql[$i]['cli_rut']).'</td>
				          	<td>'.$sql[$i]['cli_telefono'].'</td>
				          	<td>'.$sql[$i]['cli_email'].'</td>
				          	<td>
				          		<i class="bi bi-journal-text text-info cursor" href="'.controlador::$rutaAPP.'app/vistas/centro_costo/php/ficha_cliente.php?idCliente='.$sql[$i]['cli_id'].'" data-fancybox data-type="iframe" data-preload="true" data-width="100%" data-height="1200"></i>
				          	</td>
				          </tr>';
			}

			$html .= ' </tbody>
					  </table>';

			return $html;
		}

		public function datos_metas($mes, $ano){
			$fecha  = $ano.'-'.$mes.'-01';

			$sql    = $this->selectQuery("SELECT * FROM metas_mensuales
										  WHERE    		meta_estado = 1
										  AND        	metas_mes   = '$fecha'");

			return $sql;
		}

		public function seleccionar_trabajadores($idTrabajador = 0){
			$sql  	= $this->datos_trabajadores(1);

			$html   = '<select name="inputTrabajador" id="inputTrabajador" class="form-select shadow">';
			$html   .= '<option value="0">Seleccionar</option>';


			for ($i=0; $i < count($sql); $i++) { 
				if($sql[$i]['tra_id'] == $idTrabajador){
					$html   .= '<option value="'.$sql[$i]['tra_id'].'" selected="selected">'.$sql[$i]['tra_nombre'].'</option>';
				}else{
					$html   .= '<option value="'.$sql[$i]['tra_id'].'">'.$sql[$i]['tra_nombre'].'</option>';
				}
			}

			$html   .= '</select>';

			return $html;
		}

		public function seleccionar_companante($idTrabajador = [])
		{
		    // Aseguramos que $idTrabajador sea un array, por si solo pasan un único ID
		    if (!is_array($idTrabajador)) {
		        $idTrabajador = explode(',', $idTrabajador);
		    }

		    $sql = $this->datos_trabajadores(1);

		    $html = '<select name="inputAcompanante[]" id="inputAcompanante" class="form-select shadow" multiple>';

		    for ($i = 0; $i < count($sql); $i++) {
		        // Verificamos si el ID del trabajador actual está en el array $idTrabajador
		        if (in_array($sql[$i]['tra_id'], $idTrabajador)) {
		            $html .= '<option value="' . $sql[$i]['tra_id'] . '" selected="selected">' . $sql[$i]['tra_nombre'] . '</option>';
		        } else {
		            $html .= '<option value="' . $sql[$i]['tra_id'] . '">' . $sql[$i]['tra_nombre'] . '</option>';
		        }
		    }

		    $html .= '</select>';

		    return $html;
		}


		public function seleccionar_productos_general($idCategoria = 0, $idProducto = 0){
			$script = '';
			if ($idCategoria > 0) {
				$script .= " AND prod_cli_categoria = $idCategoria";
			}
			
			$sql  	= $this->selectQuery("SELECT * FROM product_cliente
										  WHERE    		prod_cli_estado = 1".$script);

			$html   = '<select name="inputProducto" id="inputProducto" class="form-select shadow" >
						<option value="0">Seleccionar Rampla</option>';

			for ($i=0; $i < count($sql); $i++) { 
				if($sql[$i]['prod_cli_id'] == $idProducto){
					$html   .= '<option value="'.$sql[$i]['prod_cli_id'].'" selected="selected">'.$sql[$i]['prod_cli_producto'].' - '.$sql[$i]['prod_cli_patente'].'</option>';
				}else{
					$html   .= '<option value="'.$sql[$i]['prod_cli_id'].'">'.$sql[$i]['prod_cli_producto'].' - '.$sql[$i]['prod_cli_patente'].'</option>';
				}
			}

			$html   .= '</select>';

			return $html;
		}

		public function cambiar_producto_estado($idProducto, $estado){
			$this->update_query("UPDATE product_cliente 
					     		 SET    prod_cli_estado = $estado
					     		 WHERE  prod_cli_id     = $idProducto");

			return $sql;
		}

		public function conteo_servicios(){
			$sql = $this->selectQuery("SELECT cont_ven_correlativo
									   FROM   conteo_servicios
									   WHERE  cont_ven_estado = 1");

			for ($i=0; $i < count($sql); $i++) { 
				$mostrar += $sql[0]['cont_ven_correlativo'];
			}

			$contar = strlen($mostrar);

			if($contar == 1){
				$ver = "000".$mostrar;
			}elseif($contar == 2){
				$ver = "00".$mostrar;
			}elseif($contar == 3){
				$ver = "0".$mostrar;
			}else{
				$ver = $mostrar;
			}

			return $ver;
		}

		public function conteo_cotizacion(){
			$sql = $this->selectQuery("SELECT cont_ven_correlativo
									   FROM   conteo_cotizacion
									   WHERE  cont_ven_estado = 1");

			for ($i=0; $i < count($sql); $i++) { 
				$mostrar += $sql[0]['cont_ven_correlativo'];
			}

			$contar = strlen($mostrar);

			if($contar == 1){
				$ver = "000".$mostrar;
			}elseif($contar == 2){
				$ver = "00".$mostrar;
			}elseif($contar == 3){
				$ver = "0".$mostrar;
			}else{
				$ver = $mostrar;
			}

			return $ver;
		}

		public function conteo_edp(){
			$sql = $this->selectQuery("SELECT cont_ven_correlativo
									   FROM   conteo_edp
									   WHERE  cont_ven_estado = 1");

			for ($i=0; $i < count($sql); $i++) { 
				$mostrar += $sql[0]['cont_ven_correlativo'];
			}

			$contar = strlen($mostrar);

			if($contar == 1){
				$ver = "000".$mostrar;
			}elseif($contar == 2){
				$ver = "00".$mostrar;
			}elseif($contar == 3){
				$ver = "0".$mostrar;
			}else{
				$ver = $mostrar;
			}

			return $ver;
		}

		public function seleccionar_servicios_disponibles($idServicio = 0){
			
			$sql    = $this->selectQuery("SELECT * FROM servicios
										  LEFT JOIN     cotizaciones
										  ON            cotizaciones.coti_id  = servicios.serv_cliente
										  LEFT JOIN     clientes
										  ON            clientes.cli_id       = cotizaciones.coti_cliente
					   					  WHERE    		servicios.serv_estado = 1
					   					  ORDER BY 		servicios.serv_id DESC");

			$html   = '<select name="inputServicio" id="inputServicio" class="form-control bg-white" data-trigger placeholder="#" multiple>
			<option value="">Seleccionar Servicios</option>';

			for ($i=0; $i < count($sql); $i++) { 
				$html   .= '<option value="'.$sql[$i]['serv_id'].'">'.$sql[$i]['serv_codigo'].'. Cliente: '.$sql[$i]['cli_nombre'].'.</option>';
			}

			$html   .= '</select>';

			return $html;
		}

		public function upCorrelativoCotizacion(){
			$sql = $this->update_query("UPDATE conteo_cotizacion 
										SET    cont_ven_correlativo = cont_ven_correlativo+1");

			return $sql;
		}

		public function datos_cotizacion_id($idCotizacion){
		    $sql    = $this->selectQuery("SELECT * FROM cotizaciones
		    		   					  WHERE  		coti_id = $idCotizacion");

			return $sql;
		}

		public function datos_cotizacion_real_codigo($codigo_cotizacion){
		    $sql    = $this->selectQuery("SELECT * FROM cotizaciones
		    		   					  WHERE  		coti_codigo = '$codigo_cotizacion'");

			return $sql;
		}

		public function datos_cotizacion_codigo($codigo_cotizacion){
		    $sql    = $this->selectQuery("SELECT * FROM item_cotizaciones
		    		   					  WHERE  		item_codigo_cotizacion = '$codigo_cotizacion'");

			return $sql;
		}

		public function datos_items_cotizacion_id($idItems){
		    $sql    = $this->selectQuery("SELECT * FROM item_cotizaciones
		    		   					  WHERE  		item_id = $idItems");

			return $sql;
		}

		public function select_cotizaciones($idCotizacion = 0){
			
			$sql  	= $this->selectQuery("SELECT * FROM cotizaciones
										  WHERE    		coti_estado = 2");

			$html   = '<select name="cotizaciones" id="cotizaciones" class="form-select shadow bg-white">
						<option value="0">Seleccionar cotizacion</option>';

			for ($i=0; $i < count($sql); $i++) { 
				if($sql[$i]['coti_id'] == $idCliente){
					$html   .= '<option value="'.$sql[$i]['coti_id'].'" selected="selected">'.$sql[$i]['coti_codigo'].'</option>';
				}else{
					$html   .= '<option value="'.$sql[$i]['coti_id'].'">'.$sql[$i]['coti_codigo'].'</option>';
				}
			}

			$html   .= '</select>';

			return $html;
		}

		public function datos_cotizaciones_items($idCotizacion){
			$sql    = $this->selectQuery("SELECT * FROM cotizaciones
										  LEFT JOIN     item_cotizaciones
										  ON          	item_cotizaciones.item_codigo_cotizacion = cotizaciones.coti_codigo
				   						  WHERE  		cotizaciones.coti_id   	  = $idCotizacion");

			if(count($sql) > 0){
				return $sql;
			}else{
				return null;
			}
		}

		public function datos_cotizacion_monto($idCotizacion){
			$monto   = 0;
			$sql     = $this->datos_cotizaciones_items($idCotizacion);

			for ($i=0; $i < count($sql); $i++) { 

				if($sql[$i]['item_exento'] == 0 || $sql[$i]['item_exento'] == 2){
		    		$monto   += $sql[$i]['item_valor']-$sql[$i]['coti_descuentos'];
		    	}
			}

			return $monto;
		}

		public function datos_empresa_id($idEmpresa){
	    	// emp_razonsocial, emp_rut, emp_direccion
			$sql  	= $this->selectQuery("SELECT * FROM empresa
										  WHERE         emp_id = $idEmpresa");

			return $sql;
	    }

	    public function select_empresas($funcion, $idEmpresa){ 
	    	$data   = 0;
			$sql    = $this->datos_empresa();

			if(strlen($funcion) > 0){
				$script = ' onchange="'.$funcion.'()"';
			}else{
				$script = '';
			}

			$html   = '<select '.$script.' name="inputEmpresa" id="inputEmpresa" class="form-select shadow">
						<option value="0">Seleccionar Empresa</option>';

			for ($i=0; $i < count($sql); $i++) { 
				if($sql[$i]['emp_id'] == $idEmpresa){
					$html   .= '<option value="'.$sql[$i]['emp_id'].'" selected="selected">'.$sql[$i]['emp_razonsocial'].', '.Utilidades::rut($sql[$i]['emp_rut']).'.</option>';
				}else{
					$html   .= '<option value="'.$sql[$i]['emp_id'].'">'.$sql[$i]['emp_razonsocial'].', '.Utilidades::rut($sql[$i]['emp_rut']).'.</option>';
				}
			}


			$html   .= '</select>';

			return $html;
		}

		public function select_proyecto_servicio($funcion, $idPrestacion){ 
	    	$data   = 0;
			$sql    = $this->selectQuery("SELECT * FROM prestacion
										  LEFT JOIN     prestacion_tipo
										  ON            prestacion_tipo.pretip_id = prestacion.pre_tipo
										  WHERE    		pre_estado = 1");

			if(strlen($funcion) > 0){
				$script = ' onchange="'.$funcion.'()"';
			}else{
				$script = '';
			}

			$html   = '<select '.$script.' name="inputPrestacion" id="inputPrestacion" class="form-select shadow">
						<option value="0">Seleccionar Empresa</option>';

			for ($i=0; $i < count($sql); $i++) { 
				if($sql[$i]['pre_id'] == $idPrestacion){
					$html   .= '<option value="'.$sql[$i]['pre_id'].'" selected="selected">'.$sql[$i]['pretip_nombre'].': '.$sql[$i]['pre_titulo'].'.</option>';
				}else{
					$html   .= '<option value="'.$sql[$i]['pre_id'].'">'.$sql[$i]['pretip_nombre'].': '.$sql[$i]['pre_titulo'].'.</option>';
				}
			}


			$html   .= '</select>';

			return $html;
		}

		public function seleccionar_clientes_disponibles($idServicio = 0){
			
			$sql    = $this->selectQuery("SELECT * FROM fletes
										  LEFT JOIN 	servicios
										  ON            servicios.serv_id     = fletes.fle_servicio
										  LEFT JOIN     cotizaciones
										  ON            cotizaciones.coti_id  = servicios.serv_cliente
										  LEFT JOIN     clientes
										  ON            clientes.cli_id       = cotizaciones.coti_cliente
					   					  WHERE    		servicios.serv_estado IN(1, 2, 3)
					   					  GROUP BY      cotizaciones.coti_cliente
					   					  ORDER BY 		servicios.serv_id DESC");

			$html   = '<select name="inputClienteId" id="inputClienteId" class="form-select bg-white" onchange="mostrar_clientes()">
			<option value="">Todos Cliente</option>';

			for ($i=0; $i < count($sql); $i++) { 
				if($idServicio == $sql[$i]['cli_id']){
					$html   .= '<option value="'.$sql[$i]['cli_id'].'" selected="selected">Cliente: '.$sql[$i]['cli_nombre'].'.</option>';
				}else{
					$html   .= '<option value="'.$sql[$i]['cli_id'].'">Cliente: '.$sql[$i]['cli_nombre'].'.</option>';
				}
			}

			$html   .= '</select>';

			return $html;
		}

		public function datos_cotizacion_anexos($idCotizacion){
		    $sql    = $this->selectQuery("SELECT * FROM documentos_cotizacion
		    		   					  WHERE  		doc_coti = $idCotizacion");

			return $sql;
		}

		public function datos_agenda($idBitacora){
		    $sql    = $this->selectQuery("SELECT * FROM bitacora
		    		   					  WHERE  		fle_id = $idBitacora");

			return $sql;
		}

		public function datos_agenda_anexos($idBitacora){
		    $sql    = $this->selectQuery("SELECT * FROM documentos_bitacora
		    		   					  WHERE  		doc_coti = $idBitacora");

			return $sql;
		}

		public function datos_agenda_anexos_id($idDocu){
		    $sql    = $this->selectQuery("SELECT * FROM documentos_bitacora
		    		   					  WHERE  		doc_id = $idDocu");

			return $sql;
		}

		public function datos_arriendos_ultimo($arriendo_servicio_id){
		    $sql    = $this->selectQuery("SELECT * FROM arriendos
		    		   					  WHERE  		arriendo_servicio_id = $arriendo_servicio_id
		    		   					  ORDER BY 		arriendo_id DESC
		    		   					  LIMIT 1");

			return $sql;
		}

		public function datos_arriendos_id($idArriendo){
		    $sql    = $this->selectQuery("SELECT * FROM arriendos
		    		   					  WHERE  		arriendo_id = $idArriendo");

			return $sql;
		}

		public function datos_traslados_id($idTraslado){
		    $sql    = $this->selectQuery("SELECT * FROM traslados
		    		   					  WHERE  		traslados_id = $idTraslado");

			return $sql;
		}

		public function datos_facturas_clientes($idFact){
			$sql    = $this->selectQuery("SELECT * FROM facturas_clientes
					   					  WHERE     	fac_id        = $idFact");

			if(count($sql) > 0){
				return $sql;
			}else{
				return null;
			}
		}

		public function select_tipo_unidad($idTipoUnidad = 0){
			
			$sql  	= $this->selectQuery("SELECT * FROM tipo_unidad
										  WHERE    		tip_estado = 1");

			$html   = '<select '.$script.' name="inputTipoUnidad" id="inputTipoUnidad" class="form-select shadow"  >
						<option value="0">Seleccionar Tipo Unidad</option>';

			for ($i=0; $i < count($sql); $i++) { 
				if($sql[$i]['tip_id'] == $idTipoUnidad){
					$html   .= '<option value="'.$sql[$i]['tip_id'].'" selected="selected">'.$sql[$i]['tip_nombre'].'</option>';
				}else{
					$html   .= '<option value="'.$sql[$i]['tip_id'].'">'.$sql[$i]['tip_nombre'].'</option>';
				}
			}

			$html   .= '</select>';

			return $html;
		}

		public function seleccion_categoria_cliente_bodega($cate_tipo, $id = 0){
			$data   = 0;
			$sql    = $this->selectQuery("SELECT * FROM categoria_productos
					   					  WHERE  		cate_estado = 1
					   					  AND           cate_tipo   = $cate_tipo
					   					  ORDER BY 		cate_nombre ASC");

			$html   = '<select name="inputCategoria" id="inputCategoria" class="form-select shadow" onchange="traer_formulario_adicionar()">
						<option value="0">Seleccionar Categoría</option>';

			for ($i=0; $i < count($sql); $i++) { 
				if($sql[$i]['cate_id'] == $id){
					$html   .= '<option value="'.$sql[$i]['cate_id'].'" selected="selected">'.$sql[$i]['cate_nombre'].'</option>';
				}else{
					$html   .= '<option value="'.$sql[$i]['cate_id'].'">'.$sql[$i]['cate_nombre'].'</option>';
				}
			}


			$html   .= '</select>';

			return $html;
		}

		public function seleccion_categoria_granel($id = 0){
			$data   = 0;
			$sql    = $this->selectQuery("SELECT * FROM categoria_granel
					   					  WHERE  		cate_estado = 1
					   					  ORDER BY 		cate_nombre ASC");

			$html   = '<select name="inputCategoria" id="inputCategoria" class="form-select shadow">
						<option value="0">Seleccionar Categoría</option>';

			for ($i=0; $i < count($sql); $i++) { 
				if($sql[$i]['cate_id'] == $id){
					$html   .= '<option value="'.$sql[$i]['cate_id'].'" selected="selected">'.ucfirst($sql[$i]['cate_nombre']).'</option>';
				}else{
					$html   .= '<option value="'.$sql[$i]['cate_id'].'">'.ucfirst($sql[$i]['cate_nombre']).'</option>';
				}
			}


			$html   .= '</select>';

			return $html;
		}

		public function nombre_trabajador($idTrabajador){
			$sql    = $this->selectQuery("SELECT * FROM trabajadores
										  WHERE 		tra_id = $idTrabajador");

			return ucfirst($sql[0]['tra_nombre']);
		}

		public function nombre_clientes($idCliente){
			$sql    = $this->selectQuery("SELECT * FROM clientes
				   						  WHERE  		cli_id   = $idCliente");

			return ucfirst($sql[0]['cli_nombre']);
		}

		public function nombre_marca_bodega($id){
			$data   = 0;
			$sql    = $this->selectQuery("SELECT * FROM marca_producto_bodega
					   					  WHERE  		mar_pro_id = $id");

			return ucfirst($sql[0]['mar_pro_nombre']);
		}

		public function nombre_categoria_bodega($id){
			$data   = 0;
			$sql    = $this->selectQuery("SELECT * FROM categoria_productos
					   					  WHERE  		cate_id = $id");

			return ucfirst($sql[0]['cate_nombre']);
		}

		public function alerta_stock($stock, $tipo){
			$parametros = $this->datos_parametros();

			if($stock < $parametros[0]['par_limite_unitario'] && $tipo == 1){
	    		$stock_mostrar = '<span class="fas fa-exclamation-triangle text-danger animate__animated animate__flash animate__infinite animate__slow"></span>&nbsp;<span class="text-danger">'.Utilidades::miles($stock).' un.</span>';
	    	}elseif($stock > $parametros[0]['par_limite_unitario'] && $tipo == 1){
	    		$stock_mostrar = Utilidades::miles($stock).' un.';
	    	}elseif($stock < $parametros[0]['par_limite_granel'] && $tipo == 2){
	    		$stock_mostrar = '<span class="fas fa-exclamation-triangle text-danger animate__animated animate__flash animate__infinite animate__slow"></span>&nbsp;<span class="text-danger">'.Utilidades::miles($stock/1000).' kg.</span>';
	    	}elseif($stock > $parametros[0]['par_limite_granel'] && $tipo == 2){
	    		$stock_mostrar = Utilidades::miles($stock/1000).' kg.';
	    	}

	    	return $stock_mostrar;
		}

		public function select_lote_ingresos(){
			
			$sql  	= $this->correlativo_ingreso();

			$html   = '<select name="conteo_ingresos" id="conteo_ingresos" class="form-select shadow">';
			$j      = 1;
			for ($i=0; $i < $sql; $i++) {
				if($j == $sql){
					$html   .= '<option value="'.$j.'" selected>Lote N&deg;: '.$j++.'</option>';
				}else{
					$html   .= '<option value="'.$j.'">Lote N&deg;: '.$j++.'</option>';
				}
			}

			$html   .= '</select>';

			return $html;
		}

		public function correlativo_ingreso(){
			$data = 0;
			$sql  = $this->selectQuery("SELECT 	cont_ven_correlativo 
										FROM 	conteo_ingresos_bodega");

			for ($i=0; $i < count($sql); $i++) { 
				$data += $sql[$i]['cont_ven_correlativo'];
			}

			return $data;// code...
		}

		public function upCorrelativo_ingreso(){
			$sql = $this->update_query("UPDATE  conteo_ingresos_bodega 
										SET     cont_ven_correlativo= cont_ven_correlativo+1");

			return $sql;
		}

		public function correlativo_merma(){
			$data = 0;
			$sql  = $this->selectQuery("SELECT 	cont_ven_correlativo 
										FROM 	conteo_mermas_bodega");

			for ($i=0; $i < count($sql); $i++) { 
				$data += $sql[$i]['cont_ven_correlativo'];
			}

			return $data;// code...
		}

		public function upCorrelativo_merma(){
			$sql = $this->update_query("UPDATE  conteo_mermas_bodega 
										SET     cont_ven_correlativo= cont_ven_correlativo+1");

			return $sql;
		}

		public function imagen_empresa_pos(){
			$parametros = $this->datos_parametros();

			if(count($parametros[0]['par_logo']) == 0){
				$img = '<img src="'.controlador::$rutaAPP.'app/recursos/img/logo_cc2.png" alt="" height="60" class="mt-2 justify-content-center">';
			}else{
				$img = '<img src="'.controlador::$rutaAPP.'app/recursos/img/'.$parametros[0]['par_logo'].'" alt="" height="60" class="mt-2 justify-content-center">';
			}

			return $img;
		}

		public function select_lote_egreso(){
			
			$sql  	= $this->correlativo_egreso();

			$html   = '<select name="conteo_egreso" id="conteo_egreso" class="form-select shadow">';
			$j      = 1;
			for ($i=0; $i < $sql; $i++) {
				if($j == $sql){
					$html   .= '<option value="'.$j.'" selected>Lote N&deg;: '.$j++.'</option>';
				}else{
					$html   .= '<option value="'.$j.'">Lote N&deg;: '.$j++.'</option>';
				}
			}

			$html   .= '</select>';

			return $html;
		}

		public function correlativo_egreso(){
			$data = 0;
			$sql  = $this->selectQuery("SELECT 	cont_ven_correlativo 
										FROM 	conteo_egresos_bodega");

			for ($i=0; $i < count($sql); $i++) { 
				$data += $sql[$i]['cont_ven_correlativo'];
			}

			return $data;// code...
		}

		public function upCorrelativo_egreso(){
			$sql = $this->update_query("UPDATE  conteo_egresos_bodega 
										SET     cont_ven_correlativo= cont_ven_correlativo+1");

			return $sql;
		}


		public function select_lote_merma(){
			
			$sql  	= $this->correlativo_egreso();

			$html   = '<select name="conteo_ingresos" id="conteo_ingresos" class="form-select shadow">';
			$j      = 1;
			for ($i=0; $i < $sql; $i++) {
				if($j == $sql){
					$html   .= '<option value="'.$j.'" selected>Lote N&deg;: '.$j++.'</option>';
				}else{
					$html   .= '<option value="'.$j.'">Lote N&deg;: '.$j++.'</option>';
				}
			}

			$html   .= '</select>';

			return $html;
		}

		public function correlativo_viajes($idEmpresa, $idSucursal){
			$data = 0;
			$sql  = $this->selectQuery("SELECT 	cont_ven_correlativo 
										FROM 	conteo_viajes 
										WHERE 	cont_ven_idEmpresa = $idEmpresa
										AND   	cont_ven_idSucursal= $idSucursal");

			for ($i=0; $i < count($sql); $i++) { 
				$data += $sql[$i]['cont_ven_correlativo'];
			}

			return $data;// code...
		}

		public function upCorrelativo_viajes($idEmpresa, $idSucursal){
			$sql = $this->update_query("UPDATE conteo_viajes 
										SET    cont_ven_correlativo = cont_ven_correlativo+1 
										WHERE 	cont_ven_idEmpresa = $idEmpresa
										AND   	cont_ven_idSucursal= $idSucursal");

			return $sql;
		}

		public function select_tipos_estados_pagos($idTipo = 0){
			
			$sql  	= $this->selectQuery("SELECT * FROM tipos_estados_pagos
										  WHERE    		tipo_estado = 1");

			$html   = '<select onchange="calcular_fecha_pago()" name="tipos_estados_pagos" id="tipos_estados_pagos" class="form-select shadow">
						<option value="0">Seleccionar</option>';

			for ($i=0; $i < count($sql); $i++) { 
				if($sql[$i]['tipo_id'] == $idTipo){
					$html   .= '<option value="'.$sql[$i]['tipo_id'].'" selected="selected">'.$sql[$i]['tipo_nombre'].'</option>';
				}else{
					$html   .= '<option value="'.$sql[$i]['tipo_id'].'">'.$sql[$i]['tipo_nombre'].'</option>';
				}
			}

			$html   .= '</select>';

			return $html;
		}

		public function nombre_tipos_estados_pagos($idEstadoPago){
			$sql    = $this->selectQuery("SELECT * FROM tipos_estados_pagos
				   						  WHERE  		tipo_id    = $idEstadoPago");

			return ucfirst($sql[0]['tipo_nombre']);
		}

		public function datos_abonos_id($idServicio, $idTipoServicio){
			$sql     = $this->selectQuery("SELECT * FROM abonos_servicios
										   WHERE  		 abo_servicio		= $idServicio
										   AND  		 abo_tipo_servicio 	= $idTipoServicio");

			return $sql;
		}

		public function select_productos_simple($idCliente, $idCategoria = 0){
			$script = '';
			if ($idCategoria > 0) {
				$script .= " AND prod_cli_categoria = $idCategoria";
			}
			
			$sql  	= $this->selectQuery("SELECT * FROM product_cliente
										  WHERE    		prod_cli_estado = 1".$script);

			$html   = '<select name="productos" id="productos" class="form-select shadow">
						<option value="0">Seleccionar</option>';

			for ($i=0; $i < count($sql); $i++) { 
				if($sql[$i]['prod_cli_id'] == $idCliente){
					$html   .= '<option value="'.$sql[$i]['prod_cli_id'].'" selected="selected">'.$sql[$i]['prod_cli_producto'].' - '.$sql[$i]['prod_cli_patente'].'</option>';
				}else{
					$html   .= '<option value="'.$sql[$i]['prod_cli_id'].'">'.$sql[$i]['prod_cli_producto'].' - '.$sql[$i]['prod_cli_patente'].'</option>';
				}
			}

			$html   .= '</select>';

			return $html;
		}

		public function select_productos_multiple($idCliente, $idCategoria = 0){
			$script = '';
			if ($idCategoria > 0) {
				$script .= " AND prod_cli_categoria = $idCategoria";
			}
			
			$sql  	= $this->selectQuery("SELECT * FROM product_cliente
										  WHERE    		prod_cli_estado = 1".$script);

			$html   = '<select name="camion[]" id="camion" class="form-select shadow">
						<option value="0">Seleccionar</option>';

			for ($i=0; $i < count($sql); $i++) { 
				if($sql[$i]['prod_cli_id'] == $idCliente){
					$html   .= '<option value="'.$sql[$i]['prod_cli_id'].'" selected="selected">'.$sql[$i]['prod_cli_producto'].' - '.$sql[$i]['prod_cli_patente'].'</option>';
				}else{
					$html   .= '<option value="'.$sql[$i]['prod_cli_id'].'">'.$sql[$i]['prod_cli_producto'].' - '.$sql[$i]['prod_cli_patente'].'</option>';
				}
			}

			$html   .= '</select>';

			return $html;
		}

		public function select_tipo_servicio($funcion, $idgasto){

			$sql = $this->selectQuery("SELECT * FROM tipos_servicios
					   				   WHERE  		 tipo_estado = 1");

			if(strlen($funcion) > 0){
				$script = ' onchange="'.$funcion.'()"';
			}else{
				$script = '';
			}

			$html = '<select id="tipo_servicio" class="form-select shadow" '.$script.'>';
			$html .= '<option value="0">Seleccionar</option>';

			for ($i=0; $i <= count($sql); $i++) { 
				if($sql[$i]['tipo_id'] === $idgasto){
					$html .= '<option value="'.$sql[$i]['tipo_id'].'" selected="selected">'.$sql[$i]['tipo_nombre'].'</option>';

				}elseif($sql[$i]['tipo_id'] != ''){
					$html .= '<option value="'.$sql[$i]['tipo_id'].'">'.$sql[$i]['tipo_nombre'].'</option>';
				}
			}

            $html .='</select>';

            return $html;
		}

		public function select_servicios_id($funcion, $idTipoServicio, $idServicio){

			if($idTipoServicio == 1){
				$sql = $this->selectQuery("SELECT * FROM fletes
					   				   	   WHERE  		 fle_estado > 0
					   				   	   ORDER BY 	 fle_id DESC LIMIT 50");
			}elseif($idTipoServicio == 2){
				$sql = $this->selectQuery("SELECT * FROM fletes
					   				   	   WHERE  		 fle_estado > 0
					   				   	   ORDER BY 	 fle_id DESC LIMIT 50");
			}elseif($idTipoServicio == 2){
				$sql = $this->selectQuery("SELECT * FROM fletes
					   				   	   WHERE  		 fle_estado > 0
					   				   	   ORDER BY 	 fle_id DESC LIMIT 50");
			}

			if(strlen($funcion) > 0){
				$script = ' onchange="'.$funcion.'()"';
			}else{
				$script = '';
			}

			$html = '<select id="tipo_servicio" class="form-select shadow" '.$script.'>';
			$html .= '<option value="0">Seleccionar</option>';

			for ($i=0; $i <= count($sql); $i++) { 
				if($sql[$i]['tipo_id'] === $idgasto){
					$html .= '<option value="'.$sql[$i]['tipo_id'].'" selected="selected">'.$sql[$i]['tipo_nombre'].'</option>';

				}elseif($sql[$i]['tipo_id'] != ''){
					$html .= '<option value="'.$sql[$i]['tipo_id'].'">'.$sql[$i]['tipo_nombre'].'</option>';
				}
			}

            $html .='</select>';

            return $html;
		}

		public function select_tipo_servicios_cliente($funcion, $idTipoServicio, $idCliente){

			if($idTipoServicio == 1){
				$sql = $this->selectQuery("SELECT 		 clientes.cli_id, clientes.cli_nombre
										   FROM 		 fletes
										   LEFT JOIN     clientes
										   ON            clientes.cli_id 	= fletes.fle_cliente
					   				   	   WHERE  		 fletes.fle_estado 	> 0
					   				   	   GROUP BY 	 fletes.fle_cliente");
			}elseif($idTipoServicio == 2){
				$sql = $this->selectQuery("SELECT 		 clientes.cli_id, clientes.cli_nombre
										   FROM 		 traslados
										   LEFT JOIN     clientes
										   ON            clientes.cli_id = traslados.traslados_cliente
					   				   	   WHERE  		 traslados.traslados_estado > 0
					   				   	   GROUP BY 	 traslados.traslados_cliente");
			}elseif($idTipoServicio == 3){
				$sql = $this->selectQuery("SELECT 		 clientes.cli_id, clientes.cli_nombre
										   FROM 		 arriendos
										   LEFT JOIN     clientes
										   ON            clientes.cli_id = arriendos.arriendo_creacion 
					   				   	   WHERE  		 arriendos.arriendo_estado > 0
					   				   	   GROUP BY 	 arriendos.arriendo_creacion");
			}

			if(strlen($funcion) > 0){
				$script = ' onchange="'.$funcion.'()"';
			}else{
				$script = '';
			}

			$html = '<select id="servicio_cliente" class="form-select shadow" '.$script.'>';
			$html .= '<option value="0">Seleccionar</option>';

			for ($i=0; $i <= count($sql); $i++) { 
				if($sql[$i]['cli_id'] === $idCliente){
					$html .= '<option value="'.$sql[$i]['cli_id'].'" selected="selected">'.$sql[$i]['cli_nombre'].'</option>';

				}elseif($sql[$i]['cli_id'] != ''){
					$html .= '<option value="'.$sql[$i]['cli_id'].'">'.$sql[$i]['cli_nombre'].'</option>';
				}
			}

            $html .='</select>';

            return $html;
		}

		public function select_tipo_servicios_id($funcion, $idTipoServicio, $idCliente){

			if($idTipoServicio == 1){
				$sql = $this->selectQuery("SELECT 		 fletes.fle_id AS id, clientes.cli_nombre
										   FROM 		 fletes
										   LEFT JOIN     clientes
										   ON            clientes.cli_id 	= fletes.fle_cliente
					   				   	   WHERE  		 fletes.fle_estado 	> 0
					   				   	   AND           fletes.fle_cliente = $idCliente");
				$nombre = 'Viaje';
			}elseif($idTipoServicio == 2){
				$sql = $this->selectQuery("SELECT 		 traslados.traslados_id AS id, clientes.cli_nombre
										   FROM 		 traslados
										   LEFT JOIN     clientes
										   ON            clientes.cli_id = traslados.traslados_cliente
					   				   	   WHERE  		 traslados.traslados_estado > 0
					   				   	   AND      	 traslados.traslados_cliente  = $idCliente");
				$nombre = 'Traslado';
			}elseif($idTipoServicio == 3){
				$sql = $this->selectQuery("SELECT 		 arriendos.arriendo_id AS id, clientes.cli_nombre
										   FROM 		 arriendos
										   LEFT JOIN     clientes
										   ON            clientes.cli_id = arriendos.arriendo_creacion 
					   				   	   WHERE  		 arriendos.arriendo_estado > 0
					   				   	   AND 	     	 arriendos.arriendo_creacion = $idCliente");
				$nombre = 'Arriendo';
			}

			if(strlen($funcion) > 0){
				$script = ' onchange="'.$funcion.'()"';
			}else{
				$script = '';
			}

			$html = '<select id="servicio_prestado" class="form-select shadow" '.$script.'>';
			$html .= '<option value="0">Seleccionar</option>';

			for ($i=0; $i <= count($sql); $i++) { 
				if($sql[$i]['id'] == $idServicio && $sql[$i]['id'] > 0){
					$html .= '<option value="'.$sql[$i]['id'].'" selected="selected">'.$nombre.' N°: '.$sql[$i]['id'].', '.$sql[$i]['cli_nombre'].'</option>';

				}elseif($sql[$i]['id'] > 0){
					$html .= '<option value="'.$sql[$i]['id'].'">'.$nombre.' N°: '.$sql[$i]['id'].', '.$sql[$i]['cli_nombre'].'</option>';
				}
			}

            $html .='</select>';

            return $html;
		}


	} // FIN CONTROLADOR
?>