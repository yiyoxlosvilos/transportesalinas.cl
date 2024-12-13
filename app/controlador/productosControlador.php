<?php
	require_once __dir__."/../modelo/obtener_datos.php";
	require_once __dir__."/../controlador/utilidadesControlador.php";
	require_once __dir__."/../controlador/recursosControlador.php";

	class Productos extends GetDatos {
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
					$html   .= '<option value="'.$sql[$i]['cate_id'].'" selected="selected">'.$sql[$i]['cate_nombre'].'</option>';
				}else{
					$html   .= '<option value="'.$sql[$i]['cate_id'].'">'.$sql[$i]['cate_nombre'].'</option>';
				}
			}


			$html   .= '</select>';

			return $html;
		}

		public function seleccion_marcas($tipo, $idMarca){
			$data   = 0;
			$sql    = $this->selectQuery("SELECT * FROM marca_producto
					   					  WHERE  		mar_pro_estado = 1
					   					  AND     		mar_prod_tipo  = $tipo
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
			$grabar = $this->insert_query("INSERT INTO marca_producto(mar_pro_nombre, mar_pro_estado) 
				   						   VALUES('$inputNombre', 1)");

			if($grabar > 0){
				return TRUE;
			}else{
				return FALSE;
			}
		}

		public function editar_marca($idMarca){
			$html   = '';
			$sql    = $this->selectQuery("SELECT * FROM marca_producto
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
			$sql = $this->update_query("UPDATE marca_producto
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
					$titulo = '<h6 class="text-success">Bodega</h6>';
					$box    = 'box6';
					$por    = 'text-success';
					break;
				case 2:
					$titulo = '<h6 class="text-info">Flete</h6>';
					$box    = 'box2';
					$por    = 'text-info';
					break;
				case 3:
					$titulo = '<h6 class="text-danger">Merma</h6>';
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

			if($estado == 0){
				$script = "";
			}else{
				$script = " WHERE prod_cli_estado = ".$estado;	
			}

			$sql    = $this->selectQuery("SELECT * FROM product_cliente
										  $script
				   						  ORDER BY   prod_cli_producto ASC");

			$html = ' <table id="productos_list" class="table table-hover shadow-lg" style="width:100%">
			            <thead >
			              <tr class="table-info">
			                <th>Código</th>
			                <th>Nombre</th>
			                <th class="ocultar">Marca</th>
			                <th class="ocultar">Categor&iacute;a</th>
			                <th>Patente</th>
			                <th>Estado</th>
			                <th>&nbsp;</th>
			              </tr>
			            </thead>
			            <tbody>';
			for ($i=0; $i < count($sql); $i++) { 
				$html .= '<tr>
				          	<td>'.$sql[$i]['prod_cli_codigo'].'</td>
				          	<td>'.ucfirst($sql[$i]['prod_cli_producto']).'</td>
				          	<td class="ocultar">'.$recursos->nombre_marca($sql[$i]['prod_cli_marca']).'</td>
				          	<td class="ocultar">'.$recursos->nombre_categoria($sql[$i]['prod_cli_categoria']).'</td>
				          	<td>'.$sql[$i]['prod_cli_patente'].'</td>
				          	<td>'.Utilidades::tipos_estado($sql[$i]['prod_cli_estado']).'</td>
				          	<td align="center">
				          		<i class="bi bi-eye text-primary ver" href="'.controlador::$rutaAPP.'app/vistas/productos/php/panel_producto.php?idProducto='.$sql[$i]['prod_cli_id'].'" data-fancybox data-type="iframe" data-preload="true" data-width="100%" data-height="600"></i>
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

			$sql    = $this->selectQuery("SELECT * FROM product_cliente
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

			$sql    = $this->selectQuery("SELECT * FROM product_cliente
										  WHERE 		prod_cli_estado 
										  $script
				   						  ORDER BY   	prod_cli_producto ASC");

			for ($i=0; $i < count($sql); $i++) { 
				$data++;
			}

			return $data;
		}

		public function grabar_productos($inputCodigo, $inputNombre, $inputMarca, $inputCategoria, $inputPatente, $inputSucursal){			
			$hoy    = Utilidades::fecha_hoy();
			$hora   = Utilidades::hora();

			$grabar = $this->insert_query("INSERT INTO product_cliente(prod_cli_codigo, prod_cli_patente, prod_cli_producto, prod_cli_marca, prod_cli_categoria, prod_cli_unidad, prod_cli_fecha, prod_cli_hora, prod_cli_estado, prod_cli_tipo, prod_cli_sucursal) 
				   VALUES('$inputCodigo', '$inputPatente', '$inputNombre', '$inputMarca', '$inputCategoria', 1, '$hoy', '$hora', 1, 0, '$inputSucursal')");

			if($grabar > 0){
				return TRUE;
			}else{
				return FALSE;
			}
		}

		public function editar_productos($inputCodigo, $idProducto, $inputNombre, $inputMarca, $inputCategoria, $inputPatente, $inputSucursal){
			$hoy    = Utilidades::fecha_hoy();
			$hora   = Utilidades::hora();

			$sql    = $this->update_query("UPDATE product_cliente
										   SET    prod_cli_codigo    	= '$inputCodigo', 
										    	  prod_cli_producto 	= '$inputNombre', 
										   		  prod_cli_marca 		= '$inputMarca', 
										   		  prod_cli_categoria	= '$inputCategoria',  
										   		  prod_cli_patente 		= '$inputPatente',
										   		  prod_cli_fecha_modifi = '$hoy', 
										   		  prod_cli_hora_modifi 	= '$hora',
										   		  prod_cli_sucursal     = '$inputSucursal' 
										   WHERE  prod_cli_id     		= $idProducto");
			return $sql;
		}

		public function desactivar_productos($idProducto){
			$sql    = $this->update_query("UPDATE product_cliente
										   SET    prod_cli_estado 	= '3' 
										   WHERE  prod_cli_id     	= $idProducto");
			return $sql;
		}

		public function activar_producto($idProducto){
			$sql    = $this->update_query("UPDATE product_cliente
										   SET    prod_cli_estado 	= '1' 
										   WHERE  prod_cli_id     	= $idProducto");
			return $sql;
		}

		public function formulario_productos($idProducto){
			$html = '';

			$sql  = $this->selectQuery("SELECT * FROM product_cliente
									    WHERE         prod_cli_id = $idProducto");

			for ($i=0; $i < count($sql); $i++) {

				if($sql[$i]['prod_cli_estado'] == 2){
					$boton = '<button type="button" id="grabar" class="btn btn-success form-control shadow" onclick="activar_producto('.$idProducto.')">Activar&nbsp;&nbsp;&nbsp;<i class="bi bi-check2-square"></i></button>';
				}else{
					$boton = '';
				}

				$html .= '<div class="row shadow p-1">
							<div class="col-lg-10 mb-2">
					          <label for="inputCategoria"><b>Código</b>  <span id="codigo_existe"></span></label>
					          <input type="text" class="form-control shadow" id="inputCodigo" placeholder="Código Producto" autocomplete="off" value="'.$sql[$i]['prod_cli_codigo'].'" onchange="consulta_codigo()">
					        </div>
					        <div class="col-lg-10">
					          <label for="inputNombre"><b>Nombre</b></label>
					          <input type="text" class="form-control shadow" id="inputNombre" placeholder="Nombre" autocomplete="off" value="'.$sql[$i]['prod_cli_producto'].'">
					        </div>
					        <div class="col-lg-10">
					          <label for="inputMarca"><b>Marca</b></label>
					          '.$this->seleccion_marcas(0, $sql[$i]['prod_cli_marca']).'
					        </div>
					        <div class="col-lg-10">
					          <label for="inputCategoria"><b>Categor&iacute;a</b></label>
					          '.$this->seleccion_categorias($sql[$i]['prod_cli_categoria']).'
					        </div>
					        <div class="col-lg-5 mb-2">
					          <label for="inputPrecio"><b>Patente</b></label>
					            <input type="text" class="form-control shadow" id="inputPatente" placeholder="Escribir Monto" value="'.$sql[$i]['prod_cli_patente'].'">
					        </div>
					        <div class="col-lg-10">
					          <label for="inputSucursal"><b>Sucursal</b></label>
					            <span id="validador_curso"></span>
					            '.$this->seleccion_sucursal($sql[$i]['prod_cli_sucursal']).'
					        </div>
					        <div class="col-5" id="ver_editar">
					          <label for="inputTipo">&nbsp;</label>
					          <button type="button" id="grabar" class="btn btn-secondary form-control shadow" onclick="editar_producto('.$idProducto.')">Editar&nbsp;&nbsp;&nbsp;<i class="bi bi-pencil-square"></i></button>
					        </div>
					        <div class="col-5" id="ver_editar">
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
				   						FROM   product_cliente
				   						WHERE  prod_cli_id = $idProducto");

			for ($i=0; $i < count($sql); $i++) { 
				$cantidad = strlen($sql[$i]['prod_cli_imagen']);

				if($cantidad == 0){
					$img = '<img src="'.controlador::$rutaAPP.'app/recursos/img/sinimagen.jpg" width="54%" align="center" class="sombraPlana2">';
				}else{
					$img = '<img src="'.controlador::$rutaAPP.'app/repositorio/'.$sql[$i]['prod_cli_imagen'].'" width="54%" align="center" class="sombraPlana2">';
				}
			}

			$html .= '<p>Imag&eacute;n</p>
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

			$sql    = $this->update_query("UPDATE product_cliente
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
				   						FROM   product_cliente
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
									<i class="bi text-info cursor bi-printer" href="'.controlador::$rutaAPP.'app/vistas/productos/php/validador.php?accion=imprimir_codigo_barra&idProducto='.$idProducto.'" data-fancybox data-type="iframe" data-preload="true" data-width="300" data-height="200"></i>
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
				   						FROM   product_cliente
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

		/**  FIN PRODUCTOS   **/

	} // END CLASS
?>