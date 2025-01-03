<?php
	require_once __dir__."/../modelo/obtener_datos.php";
	require_once __dir__."/../controlador/utilidadesControlador.php";
	require_once __dir__."/../controlador/recursosControlador.php";
	require_once __dir__."/../controlador/bodegaProductosControlador.php";

	class ProductosBodega extends GetDatos {
		public function __construct(){
			parent::__construct();
	    }

	    public function seleccion_sucursal($sucursal_id){
	    	$data   = 0;
			$sql    = $this->selectQuery("SELECT * FROM sucursales
					   					  WHERE  		suc_estado = 1");

			$html   = '<select name="inputSucursal" id="inputSucursal" class="form-select shadow">
						<option value="0">Seleccionar Sucursal</option>';

			for ($i=0; $i < count($sql); $i++) { 
				if($sql[$i]['suc_id'] == $sucursal_id){
					$html   .= '<option value="'.$sql[$i]['suc_id'].'" selected="selected">'.$sql[$i]['suc_nombre'].'</option>';
				}else{
					$html   .= '<option value="'.$sql[$i]['suc_id'].'">'.$sql[$i]['suc_nombre'].'</option>';
				}
			}


			$html   .= '</select>';

			return $html;
		}

		public function seleccion_categorias($id){

			$data   = 0;
			$sql    = $this->selectQuery("SELECT * FROM categoria_cliente
					   					  WHERE  		cate_estado = 1
					   					  ORDER BY 		cate_nombre ASC");

			$html   = '<select name="inputCategoria" id="inputCategoria" class="form-select shadow">
						<option value="0">Seleccionar Categoría</option>';

			for ($i=0; $i < count($sql); $i++) { 
				if($sql[$i]['cate_id'] == $id){
					$html   .= '<option value="'.$sql[$i]['cate_id'].'" selected="selected">'.utf8_encode($sql[$i]['cate_nombre']).'</option>';
				}else{
					$html   .= '<option value="'.$sql[$i]['cate_id'].'">'.utf8_encode($sql[$i]['cate_nombre']).'</option>';
				}
			}


			$html   .= '</select>';

			return $html;
		}

		public function seleccion_categorias_producto($id){

			$data   = 0;
			$sql    = $this->selectQuery("SELECT * FROM categoria_producto
					   					  WHERE  		cate_estado = 1
					   					  ORDER BY 		cate_nombre ASC");

			$html   = '<select name="inputCategoria" id="inputCategoria" class="form-select shadow">
						<option value="0">Seleccionar Categoría</option>';

			for ($i=0; $i < count($sql); $i++) { 
				if($sql[$i]['cate_id'] == $id){
					$html   .= '<option value="'.$sql[$i]['cate_id'].'" selected="selected">'.utf8_encode($sql[$i]['cate_nombre']).'</option>';
				}else{
					$html   .= '<option value="'.$sql[$i]['cate_id'].'">'.utf8_encode($sql[$i]['cate_nombre']).'</option>';
				}
			}


			$html   .= '</select>';

			return $html;
		}

		public function seleccion_marcas($idMarca){
			$data   = 0;
			$sql    = $this->selectQuery("SELECT * FROM marca_producto_bodega
					   					  WHERE  		mar_pro_estado = 1
					   					  ORDER BY 		mar_pro_nombre ASC");

			$html   = '<select name="inputMarca" id="inputMarca" class="form-select shadow">
						<option value="0">Seleccionar Marca</option>';

			for ($i=0; $i < count($sql); $i++) { 
				if($sql[$i]['mar_pro_id'] === $idMarca){
					$html   .= '<option value="'.$sql[$i]['mar_pro_id'].'" selected="selected">'.$sql[$i]['mar_pro_nombre'].'</option>';
				}else{
					$html   .= '<option value="'.$sql[$i]['mar_pro_id'].'">'.$sql[$i]['mar_pro_nombre'].'</option>';
				}
			}


			$html   .= '</select>';

			return $html;
		}

		public function grabar_categorias($inputNombre, $idUser){
			$grabar = $this->insert_query("INSERT INTO categoria_cliente(cate_nombre, cate_usuario, cate_estado) 
				   						   VALUES('$inputNombre', '$idUser', 1)");

			if($grabar > 0){
				return TRUE;
			}else{
				return FALSE;
			}
		}

		public function editar_categoria($idCategoria){
			$html   = '';
			$sql    = $this->selectQuery("SELECT * FROM categoria_cliente
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

		public function grabar_marcas($inputNombre){
			$grabar = $this->insert_query("INSERT INTO marca_producto_bodega(mar_pro_nombre, mar_pro_estado) 
				   						   VALUES('$inputNombre', 1)");

			if($grabar > 0){
				return TRUE;
			}else{
				return FALSE;
			}
		}

		public function editar_marca($idMarca){
			$html   = '';
			$sql    = $this->selectQuery("SELECT * FROM marca_producto_bodega
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

		public function grabar_editar_categoria($inputNombre, $idCategoria){
			$sql = $this->update_query("UPDATE categoria_cliente
										SET    cate_nombre = '$inputNombre'
										WHERE  cate_id     = $idCategoria");

			return $sql;
		}

		public function grabar_editar_marca($inputNombre, $idMarca){
			$sql = $this->update_query("UPDATE marca_producto_bodega
										SET    mar_pro_nombre = '$inputNombre'
										WHERE  mar_pro_id     = $idMarca");

			return $sql;
		}

		public function traer_productos_cards($estado){
			$cantidad_variable = $this->cantidad_productos($estado);
			$cantidad_total    = $this->cantidad_productos(0);
			$porcentaje 	   = round((($cantidad_variable*100)/$cantidad_total));

			switch ($estado) {
				case 1:
					$titulo = '<h6 class="text-success">Productos Bodega</h6>';
					$box    = 'box6';
					$por    = 'text-success';
					break;
				case 2:
					$titulo = '<h6 class="text-info">Productos Arriendo</h6>';
					$box    = 'box2';
					$por    = 'text-info';
					break;
				case 3:
					$titulo = '<h6 class="text-danger">Productos Merma</h6>';
					$box    = 'box5';
					$por    = 'text-danger';
					break;
				default:
					// code...
					break;
			}

			$html = '	<div class="col-xl-4 col-md-6 mb-4 animate__animated animate__fadeInLeft">
					      <div class="producto card card-h-100 shadow " onclick="productos_ver('.$estado.')">
					        <div class="card-body">
					          '.$titulo.'<span class="'.$por.' m-l-10">'.$porcentaje.'%</span>
					          <h5 class="m-b-30 f-w-700 text-dark counter-value" data-target2="'.$cantidad_variable.'">0</h5>
					          <div class="progress">
					              <div class="progress-bar '.$box.'" style="width:25%"></div>
					          </div>
					        </div>
					      </div>
					    </div>';

			return $html;
		}

		public function traer_productos_table($estado){
			$data     = 0;
			$recursos = new Recursos();
			$bodega   = new Bodega();

			if($estado == 0){
				$script = "";
			}else{
				$script = " WHERE prod_cli_estado = ".$estado;	
			}

			$sql    = $this->selectQuery("SELECT * FROM productos_bodega
										  $script");

			$html = ' <table id="productos_list" class="table table-hover shadow-lg animate__animated animate__fadeInLeft" style="width:100%">
			            <thead >
			              <tr class="table-info">
			                <th>Código</th>
			                <th>Nombre</th>
			                <th>Marca</th>
			                <th>Categor&iacute;a</th>
			                <th>Tipo&nbsp;Producto</th>
			                <th>Monto</th>
			                <th>Stock</th>
			                <th>Estado</th>
			                <th>&nbsp;</th>
			              </tr>
			            </thead>
			            <tbody>';
			for ($i=0; $i < count($sql); $i++) {

				if($sql[$i]['prod_cli_tipo'] == 0){
					$stock 		   = $recursos->alerta_stock($bodega->stock_producto($sql[$i]['prod_cli_id']), 1);
					$tipo_producto = 'Unitario';
				}else{
					$stock 		   = $recursos->alerta_stock($bodega->stock_producto_granel($sql[$i]['prod_cli_id']), 2);
					$tipo_producto = 'Granel';
				}

				/*if(strlen($stock) > 0){
					
				}*/

				$html .= '<tr>
					          	<td>'.$sql[$i]['prod_cli_codigo'].'</td>
					          	<td>'.ucfirst(($sql[$i]['prod_cli_producto'])).'</td>
					          	<td>'.($recursos->nombre_marca_bodega($sql[$i]['prod_cli_marca'])).'</td>
					          	<td>'.($recursos->nombre_categoria_bodega($sql[$i]['prod_cli_categoria'])).'</td>
					          	<td>'.$tipo_producto.'</td>
					          	<td>'.Utilidades::monto($sql[$i]['prod_cli_monto']).'</td>
					          	<td>'.$stock.'</td>
					          	<td>'.Utilidades::tipos_estado($sql[$i]['prod_cli_estado']).'</td>
					          	<td align="center">
					          		<i class="bi bi-eye text-primary ver" href="'.controlador::$rutaAPP.'app/vistas/productosBodega/php/panel_producto.php?idProducto='.$sql[$i]['prod_cli_id'].'" data-fancybox data-type="iframe" data-preload="true" data-width="100%" data-height="600"></i>
					          	</td>
					          </tr>';

				
			}

			$html .= ' </tbody>
					  </table>';

			return $html;
		}

		public function traer_productos_consulta($estado){
			$data     = 0;
			$recursos = new Recursos();

			if($estado == 0){
				$script = "";
			}else{
				$script = " WHERE prod_cli_estado = ".$estado;	
			}

			$sql    = $this->selectQuery("SELECT * FROM productos_bodega
										  $script
				   						  ORDER BY   prod_cli_producto ASC");

			$html = ' <table id="productos_list" class="table table-hover shadow-lg" style="width:100%">
			            <thead >
			              <tr class="table-info">
			                <th>Nombre</th>
			                <th class="ocultar">Marca</th>
			                <th class="ocultar">Categor&iacute;a</th>
			                <th>Monto</th>
			                <th>Estado</th>
			              </tr>
			            </thead>
			            <tbody>';
			for ($i=0; $i < count($sql); $i++) { 
				$html .= '<tr>
				          	<td>'.ucfirst($sql[$i]['prod_cli_producto']).'</td>
				          	<td class="ocultar">'.$recursos->nombre_marca($sql[$i]['prod_cli_marca']).'</td>
				          	<td class="ocultar">'.$recursos->nombre_categoria($sql[$i]['prod_cli_categoria']).'</td>
				          	<td>'.Utilidades::monto($sql[$i]['prod_cli_monto']).'</td>
				          	<td>'.Utilidades::tipos_estado($sql[$i]['prod_cli_estado']).'</td>
				          </tr>';
			}

			$html .= ' </tbody>
					  </table>';

			return $html;
		}

		public function cantidad_productos($estado){
			$data   = 0;
			if ($estado == 0) {
				$script = ' >= 0';
			}else{
				$script = " = $estado";
			}

			$sql    = $this->selectQuery("SELECT * FROM productos_bodega
										  WHERE 		prod_cli_estado $script
				   						  ORDER BY   	prod_cli_producto ASC");

			for ($i=0; $i < count($sql); $i++) { 
				$data++;
			}

			return $data;
		}

		public function grabar_productos($inputCodigo, $inputNombre, $inputCategoria, $inputPrecioCompra, $inputMargen, $inputPrecioVenta, $inputPrecioUtilidad, $inputSucursal, $inputTipoUnidad, $inputMarca, $inputStock){			
			$hoy    = Utilidades::fecha_hoy();
			$hora   = Utilidades::hora();

			if($inputTipoUnidad <= 2){
				$tipo_prod = 0;
			}else{
				$tipo_prod = 1;
			}

			$grabar = $this->insert_query("INSERT INTO productos_bodega(prod_cli_codigo, prod_cli_producto, prod_cli_categoria, prod_cli_unidad, prod_cli_monto_inicial, prod_cli_monto, prod_cli_aumento, prod_cli_utilidad, prod_cli_fecha, prod_cli_hora, prod_cli_estado, prod_cli_tipo, prod_cli_sucursal, prod_cli_marca,prod_cli_empresa) 
				   VALUES('$inputCodigo', '$inputNombre', '$inputCategoria', '$inputTipoUnidad', '$inputPrecioCompra', '$inputPrecioVenta', '$inputMargen', '$inputPrecioUtilidad', '$hoy', '$hora', 1, '$tipo_prod', '$inputSucursal', '$inputMarca', 1)");

			$sql    = $this->selectQuery("SELECT * FROM productos_bodega
										  WHERE 		prod_cli_producto = '$inputNombre'
										  AND           prod_cli_monto    = '$inputPrecioVenta'
										  AND           prod_cli_fecha    = '$hoy'");

			$idProducto = $sql[0]['prod_cli_id'];

			if($inputTipoUnidad <= 2){
				$unitario = $inputStock;
				$granel   = 0;
			}else{
				$unitario = 0;
				$granel   = ($inputStock*1000);
			}

			$this->insert_query("INSERT INTO stock_productos_bodega(stock_producto, stock_cantidad, stock_granel, stock_estado, stock_sucursal, stock_empresa) 
								 VALUES('$idProducto', '$unitario', '$granel', 1, '$inputSucursal', 1)");

			if($grabar > 0){
				return TRUE;
			}else{
				return FALSE;
			}
		}

		public function editar_productos($idProducto, $inputCodigo, $inputNombre, $inputCategoria, $inputPrecioCompra, $inputMargen, $inputPrecioVenta, $inputPrecioUtilidad, $inputSucursal, $inputTipoUnidad, $inputMarca){
			$hoy    = Utilidades::fecha_hoy();
			$hora   = Utilidades::hora();

			$sql    = $this->update_query("UPDATE productos_bodega
										   SET    prod_cli_codigo    	= '$inputCodigo', 
										    	  prod_cli_producto 	= '$inputNombre', 
										   		  prod_cli_marca 		= '$inputMarca', 
										   		  prod_cli_categoria	= '$inputCategoria',  
										   		  prod_cli_monto 		= '$inputPrecioVenta',
										   		  prod_cli_aumento 		= '$inputMargen',
										   		  prod_cli_monto_inicial= '$inputPrecioCompra',
										   		  prod_cli_utilidad 	= '$inputPrecioUtilidad',
										   		  prod_cli_fecha_modifi = '$hoy', 
										   		  prod_cli_hora_modifi 	= '$hora',
										   		  prod_cli_sucursal     = '$inputSucursal',
										   		  prod_cli_unidad 		= '$inputTipoUnidad'
										   WHERE  prod_cli_id     		= $idProducto");
			return $sql;
		}

		public function desactivar_productos($idProducto){
			$sql    = $this->update_query("UPDATE productos_bodega
										   SET    prod_cli_estado 	= '3',
										   		  prod_cli_codigo   = 'ANULADO'
										   WHERE  prod_cli_id     	= $idProducto");
			return $sql;
		}

		public function activar_producto($idProducto){
			$sql    = $this->update_query("UPDATE productos_bodega
										   SET    prod_cli_estado 	= '1' 
										   WHERE  prod_cli_id     	= $idProducto");
			return $sql;
		}

		public function formulario_productos($idProducto){
			$recursos = new Recursos();
			$html 	  = '';

			$sql  = $this->selectQuery("SELECT * FROM productos_bodega
									    WHERE         prod_cli_id = $idProducto");

			for ($i=0; $i < count($sql); $i++) {

				if($sql[$i]['prod_cli_estado'] == 3 || $sql[$i]['prod_cli_estado'] == 2){
					$boton = '<button type="button" id="grabar" class="btn btn-success form-control shadow" onclick="activar_producto('.$idProducto.')">Activar&nbsp;&nbsp;&nbsp;<i class="bi bi-check2-square"></i></button>';
				}else{
					$boton = '<button type="button" id="grabar" class="btn btn-danger form-control shadow" onclick="desactivar_producto('.$idProducto.')">Desactivar&nbsp;&nbsp;&nbsp;<i class="bi bi-x-octagon"></i></button>';
				}

				$html .= '<div class="row shadow p-1">
							<div class="col-lg-6 mb-2">
					          <label for="inputCategoria"><b>Código</b>  <span id="codigo_existe"></span></label>
					          <input type="text" class="form-control shadow" id="inputCodigo" placeholder="Código Producto" autocomplete="off" value="'.$sql[$i]['prod_cli_codigo'].'" onchange="consulta_codigo()">
					        </div>
					        <div class="col-lg-6">
					          <label for="inputNombre"><b>Nombre</b></label>
					          <input type="text" class="form-control shadow" id="inputNombre" placeholder="Nombre" autocomplete="off" value="'.$sql[$i]['prod_cli_producto'].'">
					        </div>
					        <div class="col-lg-4 mb-2">
					          <label for="inputCategoria"><b>Marca</b></label>
					            '.$this->seleccion_marcas($sql[$i]['prod_cli_marca']).'
					        </div>
					        <div class="col-lg-4 mb-2">
					          <label for="inputTipoUnidad"><b>Tipo Unidad</b></label>
					            '.$recursos->select_tipo_unidad($sql[$i]['prod_cli_unidad']).'
					        </div>
					        <div class="col-lg-4">
					          <label for="inputCategoria"><b>Categor&iacute;a</b></label>
					          '.$this->seleccion_categorias_producto($sql[$i]['prod_cli_categoria']).'
					        </div>
					        <div class="col-lg-3 mb-2">
					          <label for="inputPrecioCompra"><b>Monto de Compra</b></label>
					            <input type="number" class="form-control shadow" id="inputPrecioCompra" placeholder="Escribir Monto" value="'.$sql[$i]['prod_cli_monto_inicial'].'">
					        </div>
					        <div class="col-lg-3 mb-2">
					          <label for="inputMargen"><b>Margen de Ganancia</b></label>
					            <input type="number" class="form-control shadow" id="inputMargen" placeholder="Escribir Margen" onchange="calcular_margen_porcentaje()" value="'.$sql[$i]['prod_cli_aumento'].'">
					        </div>
					        <div class="col-lg-3 mb-2">
					          <label for="inputPrecioVenta"><b>Monto de Venta</b></label>
					            <input type="number" class="form-control shadow" id="inputPrecioVenta" placeholder="Monto de Venta" onchange="calcular_margen_neto()" value="'.$sql[$i]['prod_cli_monto'].'">
					        </div>
					        <div class="col-lg-3 mb-2">
					          <label for="inputPrecioUtilidad"><b>Utilidad</b></label>
					            <input type="number" class="form-control shadow" id="inputPrecioUtilidad" placeholder="Utilidad" readonly value="'.$sql[$i]['prod_cli_utilidad'].'">
					        </div>
							<div class="col-lg-4">
					          <label for="inputSucursal"><b>Sucursal</b></label>
					            <span id="validador_curso"></span>
					            '.$this->seleccion_sucursal($sql[$i]['prod_cli_sucursal']).'
					        </div>
					        <div class="col-lg-4" id="ver_editar">
					          <label for="inputTipo">&nbsp;</label>
					          <button type="button" id="grabar" class="btn btn-secondary form-control shadow" onclick="editar_producto('.$idProducto.')">Editar&nbsp;&nbsp;&nbsp;<i class="bi bi-pencil-square"></i></button>
					        </div>
					        <div class="col-lg-4" id="ver_editar">
					          <label for="inputTipo">&nbsp;</label>
					          '.$boton.'
					        </div>
					      </div>';
			}

			return $html;
		}

		public function imagen_producto($idProducto){
			$html = '';
			$sql  = $this->selectQuery("SELECT prod_cli_imagen
				   						FROM   productos_bodega
				   						WHERE  prod_cli_id = $idProducto");

			for ($i=0; $i < count($sql); $i++) { 
				$cantidad = strlen($sql[$i]['prod_cli_imagen']);

				if($cantidad == 0){
					$img = '<img src="'.controlador::$rutaAPP.'app/recursos/img/sinimagen.jpg" width="54%" align="center" class="sombraPlana2">';
				}else{
					$img = '<img src="'.controlador::$rutaAPP.'app/repositorio/'.$sql[$i]['prod_cli_imagen'].'" width="54%" align="center" class="sombraPlana2">';
				}
			}

			$html .= '<p><b>Imag&eacute;n</b></p>
					  <table align="center" class="tabla_arriendo shadow" cellpadding="6" cellspacing="2">
						<tr>
							<td width="60%">'.$img.'</td>
							<td align="center" >
								<button type="button" id="grabar" class="btn btn-primary form-control shadow" onclick="cambiar_foto_producto('.$idProducto.')">Cambiar&nbsp;&nbsp;&nbsp;<i class="bi bi-image-alt"></i></button>
							</td>
						</tr>
					 </table>';

			return $html;
		}

		public function grabar_imagen_producto($nombre, $idProducto){
			$hoy    = Utilidades::fecha_hoy();
			$hora   = Utilidades::hora();

			$sql    = $this->update_query("UPDATE productos_bodega
										   SET    prod_cli_imagen    	= '$nombre', 
										   		  prod_cli_fecha_modifi = '$hoy', 
										   		  prod_cli_hora_modifi 	= '$hora' 
										   WHERE  prod_cli_id     		= $idProducto");
			return $sql;
		}

		public function historial_producto($idProducto){
			$html   = '';
			$sql    = $this->selectQuery("SELECT * FROM historial_productos
				   						  WHERE         his_producto 	 = $idProducto
										  ORDER BY   	his_id DESC LIMIT 1");

			/*his_id, his_producto, his_cliente, his_tipo, his_glosa, his_fecha, his_hora, his_estado*/

			for ($i=0; $i < count($sql); $i++) { 
				$html .= '  <table width="100%" class="table table-striped shadow">
								<tr>
									<th>Fecha:</th>
									<td class="plomo">'.$sql[$i]['his_fecha'].'</td>
							  	</tr>
							  	<tr>
									<th>Hora:</th>
									<td class="plomo">'.$sql[$i]['his_hora'].'</td>
							  	</tr>
							  	<tr>
									<th>Cliente:</th>
									<td class="plomo">'.$sql[$i]['his_cliente'].'</td>
							  	</tr>
							  	<tr>
									<th>Estado:</th>
									<td class="plomo">'.$sql[$i]['his_estado'].'</td>
							  	</tr>
							  	<tr>
									<td colspan="2" class="plomo">Glosa:<br>'.$sql[$i]['his_glosa'].'</td>
							  	</tr>
							</table>';
			}

			if($i == 0){
				$html .= '<table width="100%" class="table shadow">
							<tr>
								<td align="center">** No hay historial de este producto **</td>
						  	</tr>
						  </table>';
			}

			return $html;
		}

		public function codigo_barra($idProducto){
			$html = '';
			$sql  = $this->selectQuery("SELECT prod_cli_codigo
				   						FROM   productos_bodega
				   						WHERE  prod_cli_id = $idProducto");

			for ($i=0; $i < count($sql); $i++) { 
				$html .= '	<table align="center" class="tabla_arriendo shadow" cellpadding="6" cellspacing="2">
								<tr>
									<td width="70%">
										<svg class="barcode"
										  jsbarcode-value="'.$sql[$i]['prod_cli_codigo'].'"
										  jsbarcode-textmargin="0"
										  jsbarcode-fontoptions="bold">
										</svg>		
									</td>
									<td align="center" >
									<i class="bi text-info cursor bi-printer" href="'.controlador::$rutaAPP.'app/vistas/productosBodega/php/validador.php?accion=imprimir_codigo_barra&idProducto='.$idProducto.'" data-fancybox data-type="iframe" data-preload="true" data-width="300" data-height="200"></i>
									</td>
								</tr>
						 	</table>

					 ';
				$html .= '<script>JsBarcode(".barcode").init();</script>';
			}

			return $html;
		}

		public function codigo_barra_print($idProducto){
			$html = '';
			$sql  = $this->selectQuery("SELECT prod_cli_codigo
				   						FROM   productos_bodega
				   						WHERE  prod_cli_id = $idProducto");

			for ($i=0; $i < count($sql); $i++) { 
				$html .= '<svg class="barcode"
						    jsbarcode-value="'.$sql[$i]['prod_cli_codigo'].'"
						    jsbarcode-textmargin="0"
						    jsbarcode-fontoptions="bold">
						  </svg>';
				$html .= '<script>JsBarcode(".barcode").init();</script>';
				$html .= '<script>window.print();</script>';
			}

			return $html;
		}

		public function listado_ofertas(){
			$html 	= '';

			$sql    = $this->selectQuery(" SELECT * FROM 	productos_bodega
										   LEFT JOIN  		ofertas_productos
										   ON         		ofertas_productos.ofer_prod 	= productos_bodega.prod_cli_id
										   WHERE 	  		productos_bodega.prod_cli_oferta > 0
										   AND              ofertas_productos.ofer_estado   = 1
										   ORDER BY   		productos_bodega.prod_cli_id");
			
			$html .= '<table id="tabla_ofertas" cellspacing="0" cellpadding="1" class="table table-hover border">
						<thead>
							<tr class="bg-soft-light">
								<th align="left">&nbsp;</th>
								<th align="left">Cod</th>
								<th align="left">Nombre</th>
								<th align="left">Monto Real</th>
								<th align="left">Oferta</th>
								<th align="left">Monto Final</th>
								<th align="left">Fin Oferta</th>
								<th align="left">&nbsp;</th>
							</tr>
						</thead>
						<tbody>';
		    $j = 1;
		    for ($i=0; $i < count($sql); $i++) { 
		    	$html .= '
						<tr>
							<td align="center" id="tabla">'.$j++.'</td>
							<td align="left">'.$sql[$i]['prod_cli_codigo'].'</td>
							<td align="left">'.$sql[$i]['prod_cli_producto'].'</td>
							<td align="left">'.Utilidades::monto3($sql[$i]['prod_cli_monto']).'</td>
							<td align="left">'.$sql[$i]['ofer_desc'].'&nbsp;%</td>
							<td align="left">'.Utilidades::monto3($sql[$i]['prod_cli_oferta']).'</td>
							<td align="left">'.Utilidades::arreglo_fecha2($sql[$i]['ofer_fecha']).'</td>
							<td align="center">
								<i class="bi bi-eye text-primary ver" href="'.controlador::$rutaAPP.'app/vistas/productosBodega/php/panel_ofertas.php?producto_id='.$sql[$i]['prod_cli_id'].'" data-fancybox data-type="iframe" data-preload="true" data-width="100%" data-height="600"></i>
							</td>
						</tr>';
		    }

			$html .= '</tbody>
					</table>';

			return $html;
		}

		public function formulario_productos_lista($idProducto){
			$html 	   		= '<div class="row mt-4">';
			$data      		= array();
			$productos 		= '';
			$productos_id 	= '';
			$recursos  		= new Recursos();

			foreach ($idProducto as $key => $value) {
				$data[$key] = $value;
			}

			for ($i = 0; $i < count($data); $i++) {
				$datos_nombre = $recursos->datos_productos($data[$i]);

				if($datos_nombre[0]['prod_cli_oferta'] == 0){
					$final  = $datos_nombre[0]['prod_cli_monto'];
				}else{
					$final  = $datos_nombre[0]['prod_cli_oferta'];
				}
		

				$productos .= '
								<tr>
									<td align="center"> 
										<h4 class="text-dark">'.ucfirst($datos_nombre[0]['prod_cli_producto']).'</h4>
										<input type="hidden" name="productos_asignados" id="productos_asignados" value="'.$datos_nombre[0]['prod_cli_id'].'">
									</td>
								</tr>
								<tr>
									<td>
										<table align="center" class="table table-striped bg-white">
											<tr>
												<td align="left" class="bold">Precio Compra:<input type="hidden" name="monto_inicial" id="monto_inicial" value="'.$datos_nombre[0]['prod_cli_monto_inicial'].'"></td>
												<td align="left">'.Utilidades::monto3($datos_nombre[0]['prod_cli_monto_inicial']).'</td>
											</tr>
											<tr>
												<td align="left" class="bold">Precio Venta:<input type="hidden" name="monto" id="monto" value="'.$datos_nombre[0]['prod_cli_monto'].'"></td>
												<td align="left">'.Utilidades::monto3($datos_nombre[0]['prod_cli_monto']).'</td>
											</tr>
											<tr>
												<td align="left" class="bold plomo">Oferta %:</td>
												<td align="left" class="plomo">
													<input type="number" name="oferta" id="oferta" class="form-control" onchange="cambiarMonto()">&nbsp;<span class="bold"></span>
												</td>
											</tr>
											<tr>
												<td align="left" class="bold plomo">Precio Final:<input type="hidden" name="precio_final" id="precio_final" value="'.$final.'"></td>
												<td align="left" class="plomo agrandaTxt" id="trae">'.Utilidades::monto3($final).'</td>
											</tr>
											<tr style="display: none;" id="perdida">
												<td align="center" class="text-danger" colspan="2">Con el descuento ingresado estas teniendo una Perdida de: <span id="monto_perdida"></span></td>
											</tr>
											<tr>
												<td align="left" class="bold plomo">Finalizar el:</td>
												<td align="left" class="plomo">
													<input type="date" name="finalizar" id="finalizar" class="form-control">
												</td>
											</tr>
										</table>
									</td>
						  		</tr>';
			}

			$html .= '<div class="col-10 mx-auto">
						<table class="table border rounded table-striped " align="center" cellpadding="5" cellspacing="5">
					  		'.$productos.'
					  	</table>
					  </div>
					  <div class="col-3 mx-auto">
					  	<label for="inputTipo">&nbsp;</label>
					  	<button type="button" id="grabar" class="btn btn-success form-control shadow" onclick="grabar_ofertas()">Realizar Oferta&nbsp;&nbsp;&nbsp;<i class="fas fa-arrow-alt-circle-up"></i></button>
					  </div>
					  <div class="col-3 mx-auto">
					  	<label for="inputTipo">&nbsp;</label>
						<button type="button" id="cancelar" class="btn btn-secondary form-control shadow" onclick="location.reload()">Cancelar&nbsp;&nbsp;&nbsp;<i class="bi bi-pencil-square"></i></button>
					  </div>
					</div>';

			return $html;
		}

		public function cosultaProductOferta($idProducto){

			foreach ($idProducto as $key => $value) {
				$data[$key] = $value;
			}

			$id = 0;

			for ($i=0; $i < count($data); $i++) { 
				$sql    = $this->selectQuery(" SELECT    productos_bodega.prod_cli_id 
										       FROM      productos_bodega
										       LEFT JOIN ofertas_productos 
										       ON 		 productos_bodega.prod_cli_id     = ofertas_productos.ofer_prod
										       WHERE     productos_bodega.prod_cli_oferta > 0
										       AND       ofertas_productos.ofer_estado   = 1
										       AND       productos_bodega.prod_cli_id     = $data[$i]");

				for ($i=0; $i < count($sql); $i++) { 
					$id += $sql[$i]['prod_cli_id'];
				}
			}

			if($id > 0){
				$estado = 1;
			}else{
				$estado = 0;
			}

			return $estado;
		}

		public function grabar_ofertas($productos_asignados, $precio_final, $oferta, $finalizar){
			$clear_oferta= $this->update_query("UPDATE ofertas_productos
												SET    ofer_estado = 0
												WHERE  ofer_prod   = $productos_asignados");

			$producto_up = $this->update_query("UPDATE productos_bodega
												SET    prod_cli_oferta = '$precio_final'
												WHERE  prod_cli_id     = $productos_asignados");

			$oferta      = $this->insert_query("INSERT INTO ofertas_productos(ofer_prod, ofer_desc, ofer_fecha, ofer_estado)
												VALUES('$productos_asignados', '$oferta', '$finalizar', 1)");

			return json_encode("realizado");
		}

		public function formulario_oferta_editar($idProducto){
			$html 	   		= '<div class="row mt-4">';
			$data      		= array();
			$productos 		= '';
			$productos_id 	= '';
			$recursos  		= new Recursos();

			foreach ($idProducto as $key => $value) {
				$data[$key] = $value;
			}

			for ($i = 0; $i < count($data); $i++) {
				$datos_nombre = $recursos->datos_productos($data[$i]);
				$datos_ofertas= $recursos->datos_ofertas($data[$i]);

				if($datos_nombre[0]['prod_cli_oferta'] == 0){
					$final  = $datos_nombre[0]['prod_cli_monto'];
				}else{
					$final  = $datos_nombre[0]['prod_cli_oferta'];
				}
		
				$productos .= '
								<tr>
									<td align="center"> 
										<h4 class="text-dark">'.ucfirst($datos_nombre[0]['prod_cli_producto']).'</h4>
										<input type="hidden" name="productos_asignados" id="productos_asignados" value="'.$datos_nombre[0]['prod_cli_id'].'">
									</td>
								</tr>
								<tr>
									<td>
										<table align="center" class="table table-striped bg-white">
											<tr>
												<td align="left" class="bold">Precio Compra:<input type="hidden" name="monto_inicial" id="monto_inicial" value="'.$datos_nombre[0]['prod_cli_monto_inicial'].'"></td>
												<td align="left">'.Utilidades::monto3($datos_nombre[0]['prod_cli_monto_inicial']).'</td>
											</tr>
											<tr>
												<td align="left" class="bold">Precio Venta:<input type="hidden" name="monto" id="monto" value="'.$datos_nombre[0]['prod_cli_monto'].'"></td>
												<td align="left">'.Utilidades::monto3($datos_nombre[0]['prod_cli_monto']).'</td>
											</tr>
											<tr>
												<td align="left" class="bold plomo">Oferta %:</td>
												<td align="left" class="plomo">
													<input type="number" name="oferta" id="oferta" class="form-control" onchange="cambiarMonto()" value="'.$datos_ofertas[0]['ofer_desc'].'">&nbsp;<span class="bold"></span>
												</td>
											</tr>
											<tr>
												<td align="left" class="bold plomo">Precio Final:<input type="hidden" name="precio_final" id="precio_final" value="'.$final.'"></td>
												<td align="left" class="plomo agrandaTxt" id="trae">'.Utilidades::monto3($final).'</td>
											</tr>
											<tr style="display: none;" id="perdida">
												<td align="center" class="text-danger" colspan="2">Con el descuento ingresado estas teniendo una Perdida de: <span id="monto_perdida"></span></td>
											</tr>
											<tr>
												<td align="left" class="bold plomo">Finalizar el:</td>
												<td align="left" class="plomo">
													<input type="date" name="finalizar" id="finalizar" class="form-control" value="'.$datos_ofertas[0]['ofer_fecha'].'">
												</td>
											</tr>
										</table>
									</td>
						  		</tr>';
			}

			$html .= '<div class="col-10 mx-auto">
						<table class="table border rounded table-striped " align="center" cellpadding="5" cellspacing="5">
					  		'.$productos.'
					  	</table>
					  </div>
					  <div class="col-3 mx-auto">
					  	<label for="inputTipo">&nbsp;</label>
					  	<button type="button" id="grabar" class="btn btn-success form-control shadow" onclick="grabar_ofertas()">Editar Oferta&nbsp;&nbsp;&nbsp;<i class="fas fa-arrow-alt-circle-up"></i></button>
					  </div>
					  <div class="col-3 mx-auto">
					  	<label for="inputTipo">&nbsp;</label>
						<button type="button" id="cancelar" class="btn btn-danger form-control shadow" onclick="anular_ofertas('.$datos_nombre[0]['prod_cli_id'].')">Anular Oferta&nbsp;&nbsp;&nbsp;<i class="bi bi-pencil-square"></i></button>
					  </div>
					</div>';

			return $html;
		}

		public function anular_ofertas($producto_id){
			$clear_oferta= $this->update_query("UPDATE ofertas_productos
												SET    ofer_estado = 0
												WHERE  ofer_prod   = $producto_id");

			$clear_oferta2= $this->update_query("UPDATE productos_bodega 
												 SET    prod_cli_oferta = 0 
												 WHERE  prod_cli_id     = $producto_id");

			return json_encode("realizado");
		}

		public function traer_promociones(){

			$estado  = array(1 => 'Activo', 0 => 'Inactivo');

			$html ='<table width="90%" align="center" cellspacing="0" class="sombraPlana2">
						<tr style="background-color: #5B8ACD; color: #fff;">
							
						</tr>';

			$sql    = $this->selectQuery("SELECT * FROM promociones WHERE promo_estado = 1");

			$html .= '<table id="tabla_ofertas" cellspacing="0" cellpadding="1" class="table table-hover border">
						<thead>
							<tr class="bg-soft-light">
								<th width="10%" align="left">Nombre</th>
								<th width="10%" align="left">C&oacute;digo</th>
								<th width="30%" align="left">Productos</th>
								<th width="10%" align="left">Monto</th>
								<th width="10%" align="left">Stock</th>
								<th width="10%" align="left">Inicio</th>
								<th width="10%" align="left">Fin</th>
								<th width="5%" align="left">Estado</th>
								<th align="left">&nbsp;</th>
							</tr>
						</thead>
						<tbody>';
		    $j = 1;
		    for ($i=0; $i < count($sql); $i++) { 
		    	$html .= '
						<tr>
							<td align="left">'.$sql[$i]['promo_nombre'].'</td>
							<td align="left">'.$sql[$i]['promo_codigo'].'</td>
							<td align="left">'.$this->listado_productos_promo($sql[$i]['promo_codigo']).'</td>
							<td align="left">'.Utilidades::monto3($sql[$i]['promo_precio']).'</td>
							<td align="left">'.Utilidades::miles($sql[$i]['promo_stock']).'</td>
							<td align="left">'.Utilidades::arreglo_fecha2($sql[$i]['promo_creacion']).'</td>
							<td align="left">'.Utilidades::arreglo_fecha2($sql[$i]['promo_fin']).'</td>
							<td align="left">'.$estado[$sql[$i]['promo_estado']].'</td>
							<td width="20px" align="center">
								<i class="bi bi-eye text-primary ver" href="'.controlador::$rutaAPP.'app/vistas/productosBodega/php/panel_promociones.php?promo_id='.$sql[$i]['promo_id'].'" data-fancybox data-type="iframe" data-preload="true" data-width="100%" data-height="100%"></i>
							</td>
						</tr>';
		    }

			$html .= '</tbody>
					</table>';

			return $html;
		}

		public function listado_productos_promo($codigo){

			$sql    = $this->selectQuery(" SELECT 		 promociones_productos.pro_cantidad contador, productos_bodega.prod_cli_producto
										   FROM 		 promociones_productos
										   LEFT JOIN     productos_bodega
										   ON 			 productos_bodega.prod_cli_id = promociones_productos.pro_producto
										   WHERE    	 promociones_productos.pro_codigo_promo = '$codigo'");
			$html   = '<ul>';

			for ($i=0; $i < count($sql); $i++) { 
				$html   .= '<li>'.$sql[$i]['contador'].' x '.$sql[$i]['prod_cli_producto'].'.</li>';
			}

			$html   .= '</ul>';

			return $html;
		}

		public function formulario_productos_promocion($idProducto){
			$html 	   		= '<div class="row mt-4">';
			$data      		= array();
			$productos 		= '';
			$productos_id 	= '';
			$recursos  		= new Recursos();

			foreach ($idProducto as $key => $value) {
				$data[$key] = $value;
			}

			for ($i = 0; $i < count($data); $i++) {
				$datos_nombre = $recursos->datos_productos($data[$i]);

				if($datos_nombre[0]['prod_cli_oferta'] == 0){
					$final  = $datos_nombre[0]['prod_cli_monto'];
				}else{
					$final  = $datos_nombre[0]['prod_cli_oferta'];
				}

				$productos .= '
								<tr>
									<td align="left"> 
										<span class="text-dark">'.ucfirst(($datos_nombre[0]['prod_cli_producto'])).'</span><br><span class="text-danger">'.Utilidades::monto3($datos_nombre[0]['prod_cli_monto']).'</span>
										<input type="hidden" name="productos_asignados[]" id="productos_asignados" value="'.$datos_nombre[0]['prod_cli_id'].'">
									</td>
									<td>
										<table align="center" class="table bg-white">
											<tr>
												<td align="left" class="bold">Cantidad:</td>
												<td align="left"><input type="number" name="cantidad_promo[]" id="cantidad_promo" class="form-control"></td>
											</tr>
										</table>
									</td>
						  		</tr>';
			}

			$html .= '<form name="form_promociones" id="form_promociones">
						<h3 align="center" class="text-dark">Crear Nueva Promoción</h3>
						<div class="row">
							<div class="col-10 mx-auto border mb-4 p-2">
								<div class="row">
									<div class="col-lg-4 mb-2">
							        	<label for="inputNombre"><b>Nombre:</b><br><small>Escribir Nombre de la promoci&oacute;n Ej: Combo 1</small></label>
							        	<input type="text" name="inputNombre" id="inputNombre" class="form-control">
							        </div>

							        <div class="col-lg-4 mb-2">
							        	<label for="inputCodigo"><b>C&oacute;digo:</b>&nbsp;<span id="codigo_existe"></span>&nbsp;&nbsp;<small>Escribir c&oacute;digo que asignar&aacute; a la promoci&oacute;n Ej: Promo1.</small></label>
							        	<input type="text" name="inputCodigo" id="inputCodigo" class="form-control bordesLight sombraPlana2" onchange="consulta_codigo_promocion()">
							        </div>

							        <div class="col-lg-4 mb-2">
							        	<label for="inputStock"><b>Stock:</b>&nbsp;<small>Escribir la cantidad de Stock de la promoci&oacute;n a crear.</small></label>
							        	<input type="text" name="inputStock" id="inputStock" class="form-control">
							        </div>

							        <div class="col-lg-4 mb-2">
							        	<label for="inputMonto"><b>Monto Promoci&oacute;n:</b>&nbsp;<small>Escribir el monto de la promoci&oacute;n.</small></label>
							        	<input type="number" name="inputMonto" id="inputMonto" class="form-control">
							        </div>

							        <div class="col-lg-4 mb-2">
							        	<label for="inputFecha"><b>Fin Promoci&oacute;n:</b>&nbsp;<small>Elegir fin periodo de actividad de la promoci&oacute;n.</small></label>
							        	<input type="date" name="inputFecha" id="inputFecha" class="form-control">
							        </div>

							        <div class="col-lg-4 mb-2">
							        	<label for="inputSucursal"><b>Sucursal:</b></label>
							        	'.$recursos->select_sucursales().'
							        </div>
							    </div>
						    </div>
						</div>
						<div class="row">
						   <div class="col-10 mx-auto">
								<table class="table table-hover border rounded" align="center" cellpadding="5" cellspacing="5">
									<tr class="bg-soft-light">
										<th>Productos</th>
										<th>Cantidad</th>
									</tr>
							  		'.$productos.'
							  	</table>
						    </div>
						</div>
						<div class="row">
							<div class="col-3 mx-auto">
								<label for="inputTipo">&nbsp;</label>
								<button type="button" id="grabar" class="btn btn-success form-control shadow" onclick="grabar_promocion()">Realizar Promoción&nbsp;&nbsp;&nbsp;<i class="fas fa-arrow-alt-circle-up"></i></button>
							</div>
							<div class="col-3 mx-auto">
								<label for="inputTipo">&nbsp;</label>
								<button type="button" id="cancelar" class="btn btn-secondary form-control shadow" onclick="location.reload()">Cancelar&nbsp;&nbsp;&nbsp;<i class="bi bi-pencil-square"></i></button>
							</div>
						</div>
					  </form>';

			return $html;
		}

		public function grabar_promocion($inputNombre, $inputCodigo, $inputStock, $inputMonto, $inputFecha, $inputSucursal, $productos_asignados, $cantidad_promo){
			$hoy = Utilidades::fecha_hoy();
			$hora= Utilidades::hora();

			$this->insert_query("INSERT INTO promociones(promo_nombre, promo_codigo, promo_precio, promo_stock, promo_creacion, promo_creacion_hr, promo_fin, promo_sucursal, promo_estado)
								 VALUES('$inputNombre', '$inputCodigo', '$inputMonto', '$inputStock', '$hoy', '$hora', '$inputFecha', '$inputSucursal', 1)");

			$explode_productos_asignados = explode(";", $productos_asignados);
			$explode_cantidad_promo 	 = explode(";", $cantidad_promo);

			for ($i=0; $i < count($explode_productos_asignados); $i++) {
				if($explode_cantidad_promo[$i] > 0){
					$this->insert_query("INSERT INTO promociones_productos(pro_producto, pro_cantidad, pro_codigo_promo, pro_estado)
								         VALUES('$explode_productos_asignados[$i]', '$explode_cantidad_promo[$i]', '$inputCodigo', 1)");
				}
			}

			return json_encode("realizado");
		}

		public function formulario_promocion_editar($idPromo){
			$html 	   		= '<div class="row mt-4">';
			$data      		= array();
			$productos 		= '';
			$productos_id 	= '';
			$recursos  		= new Recursos();

			$datos_promociones = $recursos->datos_promociones($idPromo);

			if(count($datos_promociones) > 0){
				$datos_productos = $recursos->datos_productos_promociones($datos_promociones[0]['promo_codigo']);

				for ($i = 0; $i < count($datos_productos); $i++) {
					$datos_nombre = $recursos->datos_productos($datos_productos[$i]['pro_producto']);

					$productos .= '
									<tr>
										<td align="left"> 
											<span class="text-dark">'.ucfirst($datos_nombre[0]['prod_cli_producto']).'</span><br><span class="text-danger">'.Utilidades::monto3($datos_nombre[0]['prod_cli_monto']).'</span>
											<input type="hidden" name="productos_asignados[]" id="productos_asignados" value="'.$datos_nombre[0]['prod_cli_id'].'">
										</td>
										<td>
											<table align="center" class="table bg-white">
												<tr>
													<td align="left" class="bold">Cantidad:</td>
													<td align="left"><input type="number" name="cantidad_promo[]" id="cantidad_promo" class="form-control" value="'.$datos_productos[$i]['pro_cantidad'].'"></td>
												</tr>
											</table>
										</td>
							  		</tr>';
				}

				$html .= '<form name="form_promociones" id="form_promociones">
						<h3 align="center" class="text-dark">Promoción: '.$datos_promociones[0]['promo_nombre'].'</h3>
						<div class="row">
							<div class="col-10 mx-auto border mb-4 p-2">
								<div class="row">
									<div class="col-lg-4 mb-2">
							        	<label for="inputNombre"><b>Nombre:</b><br><small>Escribir Nombre de la promoci&oacute;n Ej: Combo 1</small></label>
							        	<input type="text" name="inputNombre" id="inputNombre" class="form-control" value="'.$datos_promociones[0]['promo_nombre'].'">
							        </div>

							        <div class="col-lg-4 mb-2">
							        	<label for="inputCodigo"><b>C&oacute;digo:</b>&nbsp;<span id="codigo_existe"></span>&nbsp;&nbsp;<small>Escribir c&oacute;digo que asignar&aacute; a la promoci&oacute;n Ej: Promo1.</small></label>
							        	<input type="text" name="inputCodigo" id="inputCodigo" class="form-control bordesLight sombraPlana2" onchange="consulta_codigo_promocion()" value="'.$datos_promociones[0]['promo_codigo'].'">
							        </div>

							        <div class="col-lg-4 mb-2">
							        	<label for="inputStock"><b>Stock:</b>&nbsp;<small>Escribir la cantidad de Stock de la promoci&oacute;n a crear.</small></label>
							        	<input type="text" name="inputStock" id="inputStock" class="form-control" value="'.$datos_promociones[0]['promo_stock'].'">
							        </div>

							        <div class="col-lg-4 mb-2">
							        	<label for="inputMonto"><b>Monto Promoci&oacute;n:</b>&nbsp;<small>Escribir el monto de la promoci&oacute;n.</small></label>
							        	<input type="number" name="inputMonto" id="inputMonto" class="form-control" value="'.$datos_promociones[0]['promo_precio'].'">
							        </div>

							        <div class="col-lg-4 mb-2">
							        	<label for="inputFecha"><b>Fin Promoci&oacute;n:</b>&nbsp;<small>Elegir fin periodo de actividad de la promoci&oacute;n.</small></label>
							        	<input type="date" name="inputFecha" id="inputFecha" class="form-control" value="'.$datos_promociones[0]['promo_fin'].'">
							        </div>

							        <div class="col-lg-4 mb-2">
							        	<label for="inputSucursal"><b>Sucursal:</b></label>
							        	'.$recursos->select_sucursales($datos_promociones[0]['promo_sucursal']).'
							        </div>
							    </div>
						    </div>
						</div>
						<div class="row">
						   <div class="col-10 mx-auto">
								<table class="table table-hover border rounded" align="center" cellpadding="5" cellspacing="5">
									<tr class="bg-soft-light">
										<th>Productos</th>
										<th>Cantidad</th>
									</tr>
							  		'.$productos.'
							  	</table>
						    </div>
						</div>
						<div class="row">
							<div class="col-3 mx-auto">
							  	<label for="inputTipo">&nbsp;</label>
							  	<button type="button" id="grabar" class="btn btn-success form-control shadow" onclick="editar_promocion('.$datos_promociones[0]['promo_id'].')">Editar Promoción&nbsp;&nbsp;&nbsp;<i class="fas fa-arrow-alt-circle-up"></i></button>
							</div>
							<div class="col-3 mx-auto">
							  	<label for="inputTipo">&nbsp;</label>
								<button type="button" id="cancelar" class="btn btn-danger form-control shadow" onclick="anular_promocion('.$datos_promociones[0]['promo_id'].')">Anular Promoción&nbsp;&nbsp;&nbsp;<i class="bi bi-pencil-square"></i></button>
							</div>
						</div>
					  </form>';
			}

			

			return $html;
		}

		public function consulta_promo_existente($idPromo){

			$sql = $this->selectQuery("SELECT * FROM promociones
									   WHERE         promo_id = $idPromo");

			for ($i=0; $i < count($sql); $i++) { 
				$id += $sql[$i]['promo_id'];
			}

			if($id > 0){
				$estado = 1;
			}else{
				$estado = 0;
			}

			return $estado;
		}

		public function editar_promocion($idPromo, $inputNombre, $inputCodigo, $inputStock, $inputMonto, $inputFecha, $inputSucursal, $productos_asignados, $cantidad_promo){
			$hoy = Utilidades::fecha_hoy();
			$hora= Utilidades::hora();

			$this->update_query("UPDATE promociones 
								 SET 	promo_nombre 		= '$inputNombre', 
								 		promo_codigo 		= '$inputCodigo', 
								 		promo_precio 		= '$inputMonto', 
								 		promo_stock 		= '$inputStock',			 
								 		promo_editar_fecha 	= '$hoy', 
								 		promo_editar_hr 	= '$hora', 
								 		promo_fin 			= '$inputFecha', 
								 		promo_sucursal 		= '$inputSucursal'
								 WHERE 	promo_id 			= $idPromo");

			$explode_productos_asignados = explode(";", $productos_asignados);
			$explode_cantidad_promo 	 = explode(";", $cantidad_promo);

			for ($i=0; $i < count($explode_productos_asignados); $i++) {
				if($explode_cantidad_promo[$i] > 0){
					$this->update_query("UPDATE promociones_productos
										 SET    pro_cantidad 			= '$explode_cantidad_promo[$i]'
										 WHERE  pro_codigo_promo 		= '$inputCodigo'
										 AND    pro_producto 			= $explode_productos_asignados[$i]");
				}
			}

			return json_encode("realizado");
		}

		public function anular_promocion($idPromo){
			$recursos          = new Recursos();
			$datos_promociones = $recursos->datos_promociones($idPromo);
			$codigo_promo      = $datos_promociones[0]['promo_codigo'];

			$this->delete_query("DELETE FROM promociones_productos 
								 WHERE       pro_codigo_promo = '$codigo_promo'");

			$this->delete_query("DELETE FROM promociones 
								 WHERE       promo_id = $idPromo");

			return json_encode("realizado");
		}

		public function traer_productos_consulta_busqueda_codigo($codigo_producto = ''){
			$data     = 0;
			$recursos = new Recursos();

			$sql    = $this->selectQuery("SELECT * FROM productos_bodega
										  WHERE 		prod_cli_codigo = '$codigo_producto'");

			$html = ' <table id="productos_list" class="table table-hover shadow-lg animate__animated animate__fadeInLeft" style="width:100%">
			            <thead >
			              <tr class="table-info">
			                <th>C&oacute;digo</th>
			                <th>Nombre</th>
			                <th>Marca</th>
			                <th>Categor&iacute;a</th>
			                <th>Tipo&nbsp;Producto</th>
			                <th>Monto</th>
			                <th>Stock</th>
			                <th>Estado</th>
			                <th>&nbsp;</th>
			              </tr>
			            </thead>
			            <tbody>';

			for ($i=0; $i < count($sql); $i++) {

				if($sql[$i]['prod_cli_tipo'] == 0){
					$stock 		   = $recursos->alerta_stock($recursos->stock_producto($sql[$i]['prod_cli_id']), 1);
					$tipo_producto = 'Unitario';
				}else{
					$stock 		   = $recursos->alerta_stock($recursos->stock_producto_granel($sql[$i]['prod_cli_id']), 2);
					$tipo_producto = 'Granel';
				}

				$html .= '<tr>
					          	<td>'.$sql[$i]['prod_cli_codigo'].'</td>
					          	<td>'.ucfirst(($sql[$i]['prod_cli_producto'])).'</td>
					          	<td>'.($recursos->nombre_marca($sql[$i]['prod_cli_marca'])).'</td>
					          	<td>'.($recursos->nombre_categoria($sql[$i]['prod_cli_categoria'])).'</td>
					          	<td>'.$tipo_producto.'</td>
					          	<td>'.Utilidades::monto($sql[$i]['prod_cli_monto']).'</td>
					          	<td>'.$stock.'</td>
					          	<td>'.Utilidades::tipos_estado($sql[$i]['prod_cli_estado']).'</td>
					          	<td align="center">
					          		<i class="bi bi-eye text-primary ver" href="'.controlador::$rutaAPP.'app/vistas/productosBodega/php/panel_producto.php?idProducto='.$sql[$i]['prod_cli_id'].'" data-fancybox data-type="iframe" data-preload="true" data-width="100%" data-height="600"></i>
					          	</td>
					          </tr>';
			}

			$html .= ' </tbody>
					  </table>';

			return $html;
		}

		public function traer_productos_consulta_busqueda_prod($tipo_producto, $categoria){
			$data     = 0;
			$recursos = new Recursos();
			$script   = '';
			
			if($categoria == 0){
				$script .= " WHERE prod_cli_tipo = $tipo_producto";	
			}elseif($categoria > 0){
				$script .= " WHERE prod_cli_categoria 	= $categoria";	
			}

			$sql    = $this->selectQuery("SELECT * FROM productos_bodega
										  	$script
										  AND 			prod_cli_estado = 1");

			$html = ' <table id="productos_list" class="table table-hover shadow-lg animate__animated animate__fadeInLeft" style="width:100%">
			            <thead >
			              <tr class="table-info">
			                <th>C&oacute;digo</th>
			                <th>Nombre</th>
			                <th>Marca</th>
			                <th>Categor&iacute;a</th>
			                <th>Tipo&nbsp;Producto</th>
			                <th>Monto</th>
			                <th>Estado</th>
			                <th>&nbsp;</th>
			              </tr>
			            </thead>
			            <tbody>';

			for ($i=0; $i < count($sql); $i++) {

				if($sql[$i]['prod_cli_tipo'] == 0){
					//$stock 		   = $recursos->alerta_stock($recursos->stock_producto($sql[$i]['prod_cli_id']), 1);
					$tipo_producto = 'Unitario';
				}else{
					//$stock 		   = $recursos->alerta_stock($recursos->stock_producto_granel($sql[$i]['prod_cli_id']), 2);
					$tipo_producto = 'Granel';
				}

				$html .= '<tr>
					          	<td>'.$sql[$i]['prod_cli_codigo'].'</td>
					          	<td>'.ucfirst(($sql[$i]['prod_cli_producto'])).'</td>
					          	<td>'.($recursos->nombre_marca($sql[$i]['prod_cli_marca'])).'</td>
					          	<td>'.($recursos->nombre_categoria($sql[$i]['prod_cli_categoria'])).'</td>
					          	<td>'.$tipo_producto.'</td>
					          	<td>'.Utilidades::monto($sql[$i]['prod_cli_monto']).'</td>
					          	<td>'.Utilidades::tipos_estado($sql[$i]['prod_cli_estado']).'</td>
					          	<td align="center">
					          		<i class="bi bi-eye text-primary ver" href="'.controlador::$rutaAPP.'app/vistas/productosBodega/php/panel_producto.php?idProducto='.$sql[$i]['prod_cli_id'].'" data-fancybox data-type="iframe" data-preload="true" data-width="100%" data-height="600"></i>
					          	</td>
					          </tr>';
			}

			$html .= ' </tbody>
					  </table>';

			return $html;
		}

		/**  FIN PRODUCTOS   **/

	} // END CLASS
?>