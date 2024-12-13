<?php
	require_once __dir__."/../modelo/obtener_datos.php";
	require_once __dir__."/../controlador/utilidadesControlador.php";
	require_once __dir__."/../controlador/recursosControlador.php";

	class Ventas extends GetDatos {

		public function __construct(){
			parent::__construct();
	    }

	    

	    /**OLDER**/
	    public function listar_categorias(){

	    	$sql    = $this->selectQuery("SELECT cate_id, cate_nombre
										  FROM   categoria_cliente 
										  WHERE  cate_estado        = 1
										  ORDER BY cate_nombre ASC");
	    	$html ='';
	    	for ($i=0; $i < count($sql); $i++) {

	    		$html .= '<div class="col-sm-12 col-md-12 col-lg-4 col-xl-4">
				                <div class="row " style="padding: 10px;">
				                    <div class="col-xl-12">
				                        <div class="card cssanimation2 fadeInBottom2"> 
				                        	<div class="card-body cursor" onclick="ver_productos_categoria('.$sql[$i]['cate_id'].')">
				                                <div class="row" id="blockitems">
				                                    <div class="col-sm-3 col-md-1 col-lg-1 col-xl-1" id="icons_section">
				                                    	<i class="bi bi-bookmarks text-danger" style="font-size: 30px" aria-hidden="true"></i>
				                                    </div>
				                                    <div class="col-sm-8 col-md-9 col-lg-11 col-xl-11 text-info" id="heading_section">
				                                        <h6 class="text-info">'.$sql[$i]['cate_nombre'].'</h6>
				                                    </div>
				                                </div>
				                            </div>
				                        </div>
				                    </div>
				                </div>
				            </div>';
	    	}

	    	return $html;
		}

		public function traer_productos_categoria($idCategoria){

	    	$sql    = $this->selectQuery("SELECT * FROM product_cliente
				   						  WHERE  		prod_cli_estado 	= 1
				   						  AND    		prod_cli_categoria 	= $idCategoria");
	    	$html ='<div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
				        <div class="row" style="padding: 10px;">
				            <div class="col-xl-12">
				        		<i class="bi bi-arrow-left-circle-fill text-primary cursor h2" onclick="location.reload()"></i>
				        	</div>
				        </div>
				    </div>';
	    	for ($i=0; $i < count($sql); $i++) {

	    		if(strlen($sql[$i]['prod_cli_imagen']) > 0){

					$img = '<img src="'.controlador::$rutaAPP.'app/repositorio/'.$sql[$i]['prod_cli_imagen'].'" id="img_producto" class="bordes sombraPlana">';

				}else{

					$img = '<img src="'.controlador::$rutaAPP.'app/recursos/img/sinimagen.jpg" id="img_producto" class="bordes sombraPlana">';

				}

	    		$html .= '<div class="col-sm-12 col-md-12 col-lg-4 col-xl-4">
				                <div class="row" style="padding: 10px;">
				                    <div class="col-xl-12">
				                        <div class="card cssanimation2 fadeInBottom2"> 
				                        	<div class="card-body cursor" href="'.controlador::$rutaAPP.'app/vistas/ventas/php/panel_ventas.php?idProducto='.$sql[$i]['prod_cli_id'].'" data-fancybox data-type="iframe" data-preload="true" data-width="1400" data-height="1200">
				                                <div class="row" id="blockitems">
				                                    <div class="col-sm-3 col-md-1 col-lg-1 col-xl-1" id="icons_section">
				                                    	'.$img.'
				                                    </div>
				                                    <div class="col-sm-8 col-md-9 col-lg-11 col-xl-11 text-info" id="heading_section">
				                                        <h6 class="text-info">'.ucfirst($sql[$i]['prod_cli_producto']).'</h6>
				                                    </div>
				                                </div>
				                            </div>
				                        </div>
				                    </div>
				                </div>
				            </div>';
	    	}

	    	return $html;
		}

		public function grabar_nuevo_cliente($inputRazonSocial, $inputGiro, $inputRut, $inputTelefono, $inputEmail, $inputDireccion, $inputLocalidad){
			$hoy 		= Utilidades::fecha_hoy();
			$hora 		= Utilidades::hora();
			$limpia_rut = Utilidades::limpiaRut($inputRut);

			$sql = $this->insert_query("INSERT INTO clientes(cli_nombre, cli_giro, cli_rut, cli_telefono, cli_direccion, cli_comuna, cli_fecha, cli_hora, cli_email, cli_estado) 
				   						VALUES('$inputRazonSocial', '$inputGiro', '$limpia_rut', '$inputTelefono', '$inputDireccion', '$inputLocalidad', '$hoy', '$hora', '$inputEmail', 1)");

			if($sql){
				return TRUE;
			}else{
				return FALSE;
			}
		}

		public function listado_ventas($idUsuario){
			$html   = '<table width="100%" align="center" border="0" cellspacing="0" cellpadding="0" class="table">
						<tr>
							<th>Cod.</th>
							<th>Producto</th>
							<th>D&iacute;as</th>
							<th>Entrega</th>
							<th align="left">Monto</th>
							<th>&nbsp;</th>
						</tr>';

			$sql    = $this->selectQuery("SELECT * FROM caja_cliente
										  LEFT JOIN 	product_cliente
										  ON            product_cliente.prod_cli_id 	  = caja_cliente.c_cli_prod_cliente
										  WHERE    		caja_cliente.c_cli_user_cli       = $idUsuario
										  AND      		caja_cliente.c_cli_estado         = 1
										  AND      		caja_cliente.c_cli_tipo           = 0
										  AND      		caja_cliente.c_cli_tipoMovimiento = 3");


			for ($i=0; $i < count($sql); $i++) { 
				$html .= '  <tr id="cambiazo2">
								<td width="10%" align="center"><small>'.$sql[$i]['c_cli_prod_cliente'].'</small></td>
								<td width="35%"><small>'.$sql[$i]['prod_cli_producto'].'</small></td>
								<td width="5%" align="center">
									<b>'.$sql[$i]['c_cli_dias'].'</b>
								</td>
								<td width="25%" align="center"><small>'.Utilidades::arreglo_fecha2($sql[$i]['c_cli_fecha_fin']).'</small></td>
								<td width="25%" align="left"><small>'.Utilidades::monto($sql[$i]['c_cli_monto']).'</small></td>
								<td width="5%" align="center">
								<i class="bi bi-cart-x text-danger cursor" onclick="quitar_lista_caja('.$sql[$i]['c_cli_id'].')"></i>
									
								</td>
							</tr>';
			}

			$html .= '</table>';

			return $html;

		}

		public function total_pre_ventas($idUsuario){
			$html   = 0;

			$sql    = $this->selectQuery("SELECT * FROM caja_cliente
										  WHERE    		c_cli_user_cli       = $idUsuario
										  AND      		c_cli_estado         = 1
										  AND      		c_cli_tipo           = 0
										  AND      		c_cli_tipoMovimiento = 3");


			for ($i=0; $i < count($sql); $i++) { 
				$html += $sql[$i]['c_cli_monto'];
			}

			return $html;

		}

		public function grabar_caja($inputTipoVenta, $inputCosto, $inputDescuentos, $inputCantidad, $inputTotal, $idProducto, $idSucursal, $idUser){
			$hoy    = Utilidades::fecha_hoy();
			$hora   = Utilidades::hora();

			if($inputTipoVenta == 1){
				$cambio = date("Y-m-d", strtotime($hoy."+ ".$inputCantidad." day"));
			}else{
				$cambio = $hoy;
			}

			

			$sql    = $this->insert_query("INSERT INTO caja_cliente(c_cli_tipoMovimiento, c_cli_prod_cliente, c_cli_monto, c_cli_user_cli, c_cli_fecha, c_cli_fecha_fin, c_cli_dias, c_cli_hora, c_cli_estado, c_cli_tipo, c_cli_sucursal, c_cli_empresa, c_cli_nuevo_diario, c_cli_tipo_venta) 
					   VALUES(3, '$idProducto', '$inputTotal', '$idUser', '$hoy', '$cambio', '$inputCantidad', '$hora', 1, 0, '$idSucursal', 1, '$inputDescuentos', '$inputTipoVenta')");

			if($sql){
				return TRUE;
			}else{
				return FALSE;
			}
		}

		public function grabar_caja2($inputTipoVenta, $inputCosto, $inputDescuentos, $inputCantidad, $inputCantidadArticulo, $inputTotal, $idProducto, $idSucursal, $idUser){
			$hoy    = Utilidades::fecha_hoy();
			$hora   = Utilidades::hora();

			if($inputTipoVenta == 1){
				$cambio = date("Y-m-d", strtotime($hoy."+ ".$inputCantidad." day"));
			}else{
				$cambio = $hoy;
			}

			

			$sql    = $this->insert_query("INSERT INTO caja_cliente(c_cli_tipoMovimiento, c_cli_prod_cliente, c_cli_monto, c_cli_user_cli, c_cli_fecha, c_cli_fecha_fin, c_cli_dias, c_cli_hora, c_cli_estado, c_cli_tipo, c_cli_sucursal, c_cli_empresa, c_cli_nuevo_diario, c_cli_tipo_venta, c_cli_cantidad) 
					   VALUES(3, '$idProducto', '$inputTotal', '$idUser', '$hoy', '$cambio', '$inputCantidad', '$hora', 1, 0, '$idSucursal', 1, '$inputDescuentos', '$inputTipoVenta', '$inputCantidadArticulo')");

			if($sql){
				return TRUE;
			}else{
				return FALSE;
			}
		}

		public function quitar_lista_caja($idCaja){
			$sql = $this->delete_query("DELETE FROM caja_cliente WHERE c_cli_id = $idCaja");

			if($sql){
				return TRUE;
			}else{
				return FALSE;
			}
		}

		public function traer_panel_productos($idProducto){
			$recursos   = new Recursos();
			$existe 	= $this->producto_en_caja($idProducto);
			$productos 	= $recursos->datos_productos($idProducto);
			$html   	= '';

			if (count($existe) > 0) {
				for ($i=0; $i < count($existe); $i++) { 
					$html .= '<table width="100%" class="table">
						        <tr id="costo">
						          <th>Producto: </th>
						          <td id="tipo_venta">'.$existe[0]['prod_cli_producto'].'</td>
						        </tr>
						        <tr>
						        	<td colspan="2" align="center" class="text-info">Producto en carrito de venta. <i class="bi bi-cart2"></i> </td>
						        </tr>
						      </table>';
				}
			} else {

				if ($productos[0]['prod_cli_categoria'] == 9) {
					$tipo_categoria = '';
					$tipo_boton     = 'grabar_caja2';
				}else{
					$tipo_categoria = ' style="display:none;';
					$tipo_boton     = 'grabar_caja';
				}
				$html .= '<table width="100%" class="table">
					        <tr>
					          <th>Tipo Venta: </th>
					          <td>
					            <select class="form-control" id="inputTipoVenta" onclick="tipo_venta()">
					              <option value="0">Seleccionar</option>
					              <option value="1">Dias</option>
					              <option value="2">Horas</option>
					            </select>
					          </td>
					        </tr>
					        <tr style="display:none;" id="costo">
					          <th>Costo: </th>
					          <td id="tipo_venta">
					            <span class="text-info h4" id="monto_venta">$ 0</span>
					           <input type="hidden" name="inputCosto" id="inputCosto" value="0">
					          </td>
					        </tr>
					        <tr>
					          <th>Descuentos: </th>
					          <td>
					            <input type="number" name="inputDescuentos" id="inputDescuentos" class="form-control" onkeyup="descontar_monto_diario()" value="0">
					          </td>
					        </tr>
					        <tr '.$tipo_categoria.'>
					          <th>Cantidad articulos: </th>
					          <td>
					            <input type="number" name="inputCantidadArticulo" id="inputCantidadArticulo" class="form-control" onkeyup="descontar_monto_diario()" value="0">
					          </td>
					        </tr>
					        <tr>
					          <th>Cantidad dias/hrs: </th>
					          <td>
					            <input type="number" name="inputCantidad" id="inputCantidad" class="form-control" onkeyup="descontar_monto_diario()" value="0">
					          </td>
					        </tr>
					        <tr>
					          <th>Total: </th>
					          <td>
					            <span class="text-info h4" id="total_venta">$ 0</span>
					            <input type="hidden" name="inputTotal" id="inputTotal" class="form-control" value="0">
					          </td>
					        </tr>
					        <tr>
					          <td colspan="2" align="center">
					            <button class="btn btn-success" onclick="'.$tipo_boton.'('.$idProducto.')">
					              <i class="bi bi-cart3"></i> Agregar
					            </button>
					          </td>
					        </tr>
					      </table>';
			}

			return $html;
		}

		public function producto_en_caja($idProducto){
			$hora   = Utilidades::hora();

			$sql    = $this->selectQuery("SELECT * FROM caja_cliente 
										  LEFT JOIN     product_cliente
										  ON 			product_cliente.prod_cli_id 	= caja_cliente.c_cli_prod_cliente
										  WHERE  		caja_cliente.c_cli_prod_cliente = $idProducto
										  AND    		caja_cliente.c_cli_estado       = 1");

			return $sql;
		}

		public function informacion_cliente($rut){
			$html   = '';
			$sql    = $this->selectQuery("SELECT * FROM clientes 
										  WHERE  		cli_rut    = '$rut'
										  AND    		cli_estado = 1");

			for ($i=0; $i < count($sql); $i++) { 
				$html   .= '<input type="hidden" id="idCliente" name="idCliente" value="'.$sql[$i]['cli_id'].'">
							<table align="center" class="table" cellspacing="5" cellpadding="5">
								<tr>
									<td><b>Cliente:</b></td>
									<td>'.ucfirst($sql[$i]['cli_nombre']).'</td>
								</tr>
								<tr>
									<td><b>Tel&eacute;fono:</b></td>
									<td>'.$sql[$i]['cli_telefono'].'</td>
								</tr>
								<tr>
									<td colspan="2" align="center">
										<i class="bi bi-arrow-repeat text-success cursor" onclick="location.reload()"></i>
									</td>
								</tr>
							</table>';

				$html   .= '<script>confirmar_arriendo_cliente()</script>';
			}

			return $html;
		}

		public function traer_clientes_venta($inputNombre){
			$html   = '';
			$sql    = $this->selectQuery("SELECT * FROM clientes 
										  WHERE    		cli_nombre LIKE '%$inputNombre%'
										  ORDER BY 		cli_nombre ASC");
			if(count($sql) > 0){

				$html .= '<table width="95%" class="table"  cellspacing="0" cellpadding="1">
							<tr style="background-color: #fff;">
								<td><b>Nombre</b></td>
								<td align="center">&nbsp;</td>
							</tr>';

				for ($i=0; $i < count($sql); $i++) { 
					$html .='<tr id="cambiazo">
								<td>'.$sql[$i]['cli_nombre'].'</td>
								<td align="center">
									<i class="bi bi-check2-circle text-info cursor" onclick="consultar_clientes_id('.$sql[$i]['cli_id'].')"></i>
								</td>
							 </tr>';
				}

				$html .= '</table>';

			}else{

				$html .='<p align="center">Busqueda sin Resultados.</p>
						 <script>$("#ver_procesar").html("");</script>';

			}

			return $html;

		}

		public function informacion_cliente_id($idCliente){
			$html   = '';
			$sql    = $this->selectQuery("SELECT * FROM clientes 
										  WHERE  		cli_id   = $idCliente");

			for ($i=0; $i < count($sql); $i++) { 
				$html   .= '<input type="hidden" id="idCliente" name="idCliente" value="'.$sql[$i]['cli_id'].'">
							<table align="center" class="table" cellspacing="5" cellpadding="5">
								<tr>
									<td><b>Cliente:</b></td>
									<td>'.ucfirst($sql[$i]['cli_nombre']).'</td>
								</tr>
								<tr>
									<td><b>Tel&eacute;fono:</b></td>
									<td>'.$sql[$i]['cli_telefono'].'</td>
								</tr>
								<tr>
									<td colspan="2" align="center">
										<i class="bi bi-arrow-repeat text-success cursor" onclick="location.reload()"></i>
									</td>
								</tr>
							</table>';

				$html   .= '<script>confirmar_arriendo_cliente()</script>';
			}

			return $html;
		}

		public function upCaja_cliente($idUser, $idEmpresa, $correlativo, $clientes){
			$sql = $this->update_query("UPDATE caja_cliente 
										SET    c_cli_lote     = $correlativo, 
											   c_cli_estado   = 2,
											   c_cli_clientes = $clientes
										WHERE  c_cli_empresa  = $idEmpresa 
										AND    c_cli_user_cli = $idUser
										AND    c_cli_estado   = 1
										AND    c_cli_lote     = 0");

			return $sql;
		}

		public function cambiar_estado_producto($idProducto, $estado){
			$this->update_query("UPDATE product_cliente 
					     		 SET    prod_cli_estado = $estado
					     		 WHERE  prod_cli_id     = $idProducto");

			return $sql;
		}

		public function cambia_estado_producto($boleta){
			$sql = $this->selectQuery("SELECT c_cli_prod_cliente
									   FROM   caja_cliente
									   WHERE  c_cli_lote 		 = $boleta
									   AND    c_cli_prod_cliente > 0");

			for ($i=0; $i < count($sql); $i++) { 
				$this->cambiar_estado_producto($sql[$i]['c_cli_prod_cliente'], 2);
			}

		}

		public function cambia_estado_producto_anular($boleta){
			$sql = $this->selectQuery("SELECT c_cli_prod_cliente
									   FROM   caja_cliente
									   WHERE  c_cli_lote 		 = $boleta");

			for ($i=0; $i < count($sql); $i++) { 
				$this->cambiar_estado_producto($sql[$i]['c_cli_prod_cliente'], 1);
			}

		}

		public function grabar_dscto($cliente, $total2, $descto, $total, $usuario, $boleta){
			$hoy = Utilidades::fecha_hoy();

			$sql = $this->insert_query("INSERT INTO descuentos_clientes(desc_cliente, desc_fecha, desc_monto_real, desc_porcentaje, desc_monto_final, desc_emite, desc_boleta, desc_estado) 
										VALUES('$cliente', '$hoy', '$total2', '$descto', '$total', '$usuario', '$boleta', 1)");

			return $sql;
		}

		public function upCaja_cliente_descuento($idUser, $idEmpresa, $correlativo, $clientes, $tipo_pago, $total, $total2, $sucursal, $descto){
			$hoy    	= Utilidades::fecha_hoy();
			$hora   	= Utilidades::hora();

			if($tipo_pago == 2){
				$nu_total  = ($total/1.19);
				$calculo   = ($total2-$nu_total);
			}else{
				$calculo   = ($total2-$total);
			}

			// Tipo venta 1=venta directo, 2=venta en la entrega, 3=venta abonado **
			$sql    = $this->insert_query("INSERT INTO caja_cliente(c_cli_tipoMovimiento, c_cli_prod_cliente, c_cli_monto, c_cli_user_cli, c_cli_empresa, c_cli_fecha, c_cli_hora, c_cli_estado, c_cli_clientes, c_cli_sucursal, c_cli_lote) 
					   VALUES(6, 0, '-$calculo', '$idUser', '$idEmpresa', '$hoy', '$hora', 2, '$clientes', ', $sucursal', '$correlativo')");

			return $sql;
		}

		function agregar_pendientes_pago($tipo_pago, $total, $boleta, $cliente){
			if($tipo_pago == 4){
				$dias = 30;
			}elseif($tipo_pago == 5){
				$dias = 60;
			}elseif($tipo_pago == 6){
				$dias = 90;
			}

			$hoy    = Utilidades::fecha_hoy();
			$fin    = date("Y-m-d", strtotime($hoy."+ ".$dias." day"));

			// grabar pago por pagar
			$sql    = $this->insert_query("INSERT INTO pendiete_pago(gas_tipo, gas_monto, gas_fecha_ingreso, gas_fecha_pago, gas_boleta, gas_cliente, gas_estado) 
					   VALUES('$tipo_pago', '$total', '$hoy', '$fin', '$boleta', '$cliente', 1)");

			return $sql;

		}

		public function upCaja_cliente_por_pagar($idUser, $idEmpresa, $correlativo, $clientes, $tipo_pago, $total, $total2, $sucursal){
			$hoy    	= Utilidades::fecha_hoy();
			$hora   	= Utilidades::hora();

			$sql    	=  $this->insert_query("INSERT INTO caja_cliente(c_cli_tipoMovimiento, c_cli_prod_cliente, c_cli_monto, c_cli_user_cli, c_cli_empresa, c_cli_fecha, c_cli_hora, c_cli_estado, c_cli_clientes, c_cli_sucursal, c_cli_lote) 
					   VALUES(7, 0, '-$total2', '$idUser', '$idEmpresa', '$hoy', '$hora', 2, '$clientes', '$sucursal', '$correlativo')");

			return $sql;
		}

		public function upCaja_cliente_por_pagar_iva($idUser, $idEmpresa, $correlativo, $clientes, $tipo_pago, $total, $total2, $sucursal){
			$hoy    	= Utilidades::fecha_hoy();
			$hora   	= Utilidades::hora();

			$sql    	=  $this->insert_query("INSERT INTO caja_cliente(c_cli_tipoMovimiento, c_cli_prod_cliente, c_cli_monto, c_cli_user_cli, c_cli_empresa, c_cli_fecha, c_cli_hora, c_cli_estado, c_cli_clientes, c_cli_sucursal, c_cli_lote) 
				   VALUES(7, 0, '$total2', '$idUser', '$idEmpresa', '$hoy', '$hora', 2, '$clientes', '$sucursal', '$correlativo')");

			return $sql;
		}

		public function agregar_pendientes_pago_enlaentrega_abono($tipo_pago, $total, $efectivo, $transfer, $boleta, $cliente){
			$recursos 	= new Recursos();
			$hoy    	= Utilidades::fecha_hoy();
			$hora   	= Utilidades::hora();

			$dias   	= $recursos->datos_fecha_fin_entrega($boleta);

			$monto  	= ($total-($efectivo+$transfer));
			$nueva  	= $dias[0]['c_cli_fecha_fin'];

			$sql		= $this->insert_query("INSERT INTO pendiete_pago(gas_tipo, gas_monto, gas_fecha_ingreso, gas_fecha_pago, gas_boleta, gas_cliente, gas_estado) 
											   VALUES('$tipo_pago', '$monto', '$hoy', '$nueva', '$boleta', '$cliente', 1)");
	
			return $sql;
		}

		public function agregar_pendientes_pago_enlaentrega($tipo_pago, $total, $boleta, $cliente){
			$recursos 	= new Recursos();
			$hoy    	= Utilidades::fecha_hoy();
			$hora   	= Utilidades::hora();

			$dias   	= $recursos->datos_fecha_fin_entrega($boleta);

			$nueva  	= $dias[0]['c_cli_fecha_fin'];

			$sql     	= $this->insert_query("INSERT INTO pendiete_pago(gas_tipo, gas_monto, gas_fecha_ingreso, gas_fecha_pago, gas_boleta, gas_cliente, gas_estado) 
						VALUES('$tipo_pago', '$total', '$hoy', '$nueva', '$boleta', '$cliente', 1)");

			return $sql;
		}

		public function upCaja_cliente_abonado($idUser, $idEmpresa, $correlativo, $clientes, $tipo_pago, $efectivo, $transfer){
			$hoy    	= Utilidades::fecha_hoy();
			$hora   	= Utilidades::hora();
			$total  	= ($efectivo+$transfer);

			$sql    	=  $this->insert_query("INSERT INTO caja_cliente(c_cli_tipoMovimiento, c_cli_prod_cliente, c_cli_monto, c_cli_user_cli, c_cli_empresa, c_cli_fecha, c_cli_hora, c_cli_estado, c_cli_clientes, c_cli_lote) 
					   							VALUES(9, 0, '$total', '$idUser', '$idEmpresa', '$hoy', '$hora', 2, '$clientes', '$correlativo')");

			return $sql;
		}

		public function upCaja_cliente_iva($idUser, $idEmpresa, $correlativo, $clientes, $tipo_pago, $iva, $sucursal){
			$hoy    	= Utilidades::fecha_hoy();
			$hora   	= Utilidades::hora();

			$sql    	= $this->insert_query("INSERT INTO caja_cliente(c_cli_tipoMovimiento, c_cli_prod_cliente, c_cli_monto, c_cli_user_cli, c_cli_empresa, c_cli_fecha, c_cli_hora, c_cli_estado, c_cli_clientes, c_cli_sucursal, c_cli_lote) 
				   							   VALUES(10, 0, '$iva', '$idUser', '$idEmpresa', '$hoy', '$hora', 2, '$clientes', '$sucursal', '$correlativo')");

			return $sql;
		}

		public function procesar_venta($cliente, $tipo_pago, $transfer, $efectivo, $total, $vuelto, $usuario, $sucursal, $descto, $total2, $tipo_dte){
			$recursos 	= new Recursos();

			$hoy    	= Utilidades::fecha_hoy();
			$hora   	= Utilidades::hora();
			$empresa 	= 1;

			$boleta 	= $recursos->correlativo($empresa, $sucursal);

			//$total 	MONTO CON DESCUENTO, 
			//$total2 	MONTO SIN DESCUENTOS
			//$tipo_dte 1=BOLETA, 2=FACTURA, 3=COMPROBANTE DE VENTA

			if($tipo_dte == 2){
				$new_monto= ($total/1.19);
				$iva      = ($new_monto*1.19)-$new_monto;
			}else{
				$iva      = 0;
				$new_monto= $total;
			}

			$sql    = $this->insert_query("INSERT INTO ventascliente(ven_cli_operacion, ven_cli_montoInicial, ven_cli_montoReal, ven_cli_efectivoEntregado, ven_cli_transferencia, ven_cli_vuelto, ven_iva, ven_cli_boleta, ven_cli_usuario, ven_cli_empresa, ven_cli_sucursal, ven_cli_fecha, ven_cli_hora, ven_clientes, ven_tipo_venta, ven_cli_estado) 
					   VALUES('$boleta', '$total2', '$new_monto', '$efectivo', '$transfer', '$vuelto', '$iva', '$tipo_dte', '$usuario', '$empresa', '$sucursal', '$hoy', '$hora', '$cliente', '$tipo_pago', 1)");

			if($sql){

				$recursos->upCorrelativo($empresa, $sucursal);
				$this->upCaja_cliente($usuario, $empresa, $boleta, $cliente);
				$this->cambia_estado_producto($boleta);

				if($descto > 0){ //PAGOS CON DESCUENTOS
					$this->grabar_dscto($cliente, $total2, $descto, $total, $usuario, $boleta);
					$this->upCaja_cliente_descuento($usuario, $empresa, $boleta, $cliente, $tipo_dte, $total, $total2, $sucursal, $descto);
				}

				if($tipo_pago >= 4){                                                  //PAGOS A PLAZO 30,60,90
					$this->agregar_pendientes_pago($tipo_pago, $total, $boleta, $cliente);

					$nuevo_monto = $total-$iva;

					$this->upCaja_cliente_por_pagar($usuario, $empresa, $boleta, $cliente, $tipo_pago, $total, $nuevo_monto, $sucursal);

					if($iva > 0){
						$this->upCaja_cliente_por_pagar_iva($usuario, $empresa, $boleta, $cliente, $tipo_pago, $total, $iva, $sucursal);
					}
				}

				if($tipo_pago == 3){                                               //PAGOS ABONADOS
					$this->agregar_pendientes_pago_enlaentrega_abono($tipo_pago, $total, $efectivo, $transfer, $boleta, $cliente);
					$this->upCaja_cliente_abonado($usuario, $empresa, $boleta, $cliente, $tipo_pago, $efectivo, $transfer, $sucursal);

					if($iva > 0){
						$this->upCaja_cliente_por_pagar_iva($usuario, $empresa, $boleta, $cliente, $tipo_pago, $total, $iva, $sucursal);
					}

					$this->upCaja_cliente_por_pagar($usuario, $empresa, $boleta, $cliente, $tipo_pago, $total, $new_monto, $sucursal);
				}

				if($tipo_pago == 2){ //PAGOS EN LA ENTREGA
					$nuevo_monto = $total-$iva;

					$this->agregar_pendientes_pago_enlaentrega($tipo_pago, $total, $boleta, $cliente);
					$this->upCaja_cliente_por_pagar($usuario, $empresa, $boleta, $cliente, $tipo_pago, $total, $nuevo_monto, $sucursal);

					if($iva > 0){
						$this->upCaja_cliente_por_pagar_iva($usuario, $empresa, $boleta, $cliente, $tipo_pago, $total, $iva, $sucursal);
					}
				}


				if($tipo_dte == 2){ //PAGOS CON IVA

					if($tipo_pago == 1){
						$valor_iva = $iva;
					}else{
						$valor_iva = ($iva*-1);
					}

					$this->upCaja_cliente_iva($usuario, $empresa, $boleta, $cliente, $tipo_pago, $valor_iva, $sucursal);
				}
				$estado = $boleta;
			}else{
				$estado = 0;
			}

			return $estado;
		}

		public function listadoProductosComprados($boleta){
			$tot    = 0;
			$cant   = 0;
			$html 	= '<table width="100%">';

			$sql    = $this->selectQuery("SELECT     count(caja_cliente.c_cli_prod_cliente) suma, 
													 caja_cliente.c_cli_prod_cliente, 
													 sum(caja_cliente.c_cli_monto) monto, 
													 caja_cliente.c_cli_dias,
													 caja_cliente.c_cli_cantidad,
													 caja_cliente.c_cli_nuevo_diario,
													 product_cliente.prod_cli_monto,
													 product_cliente.prod_cli_producto
										   FROM      caja_cliente
										   LEFT JOIN product_cliente
										   ON        product_cliente.prod_cli_id 		= caja_cliente.c_cli_prod_cliente
										   WHERE     caja_cliente.c_cli_lote           	= $boleta
										   AND 		 caja_cliente.c_cli_tipoMovimiento 	= 3
										   GROUP BY  caja_cliente.c_cli_prod_cliente");

			for ($i=0; $i < count($sql); $i++) { 
				if($sql[$i]['c_cli_cantidad'] > 1){
					$cantidad = ', '.$sql[$i]['c_cli_cantidad'].' partes.';
					$monto_mostrar  = $sql[$i]['c_cli_dias'].' x '.Utilidades::monto($sql[$i]['prod_cli_monto']-$sql[$i]['c_cli_nuevo_diario']);
					$monto_mostrar .= '<br>'.$sql[$i]['c_cli_dias'].'pts. x '.Utilidades::monto($sql[$i]['c_cli_dias']*($sql[$i]['prod_cli_monto']-$sql[$i]['c_cli_nuevo_diario']));
				}else{	
					$cantidad = '';
					$monto_mostrar = $sql[$i]['c_cli_dias'].' x '.Utilidades::monto($sql[$i]['c_cli_dias']*($sql[$i]['prod_cli_monto']-$sql[$i]['c_cli_nuevo_diario']));
				}

				if($sql[$i]['monto'] > 0){

				$html .= '<tr>
							<td align="left"><small>'.$sql[$i]['suma'].' '.$sql[$i]['prod_cli_producto'].' '.$cantidad.'</small></td>
						  </tr>
						  <tr>
							<td align="right"><small>'.$monto_mostrar.'</small></td>
						  </tr>
						  <tr>
							<td align="right"><small>= '.Utilidades::monto($sql[$i]['monto']).'</small></td>
						  </tr>';
				}
			}

			$html .= '</table>';

			$html .= $this->tipo_de_pago($boleta);

			return $html;
		}

		public function tipo_de_pago($boleta){
			$recursos 	= new Recursos();
			$html   	= '';
			$html2  	= '';
			$sql    	= $this->selectQuery("SELECT * FROM ventascliente
										  	  LEFT JOIN 	tipos_pago
										  	  ON        	tipos_pago.tipo_id 				= ventascliente.ven_tipo_venta
										  	  WHERE     	ventascliente.ven_cli_operacion = $boleta");

			for ($i=0; $i < count($sql); $i++) { 
				$final   = $sql[$i]['ven_cli_montoReal'];
				$efect   = $sql[$i]['ven_cli_efectivoEntregado'];
				$trans   = $sql[$i]['ven_cli_transferencia'];
				$vuelt   = $sql[$i]['ven_cli_vuelto'];
				$tipov   = $sql[$i]['ven_tipo_venta'];
				$inicial = $sql[$i]['ven_cli_montoInicial'];
				$tipoDte = $sql[$i]['ven_cli_boleta'];
				$final2  = $final-($efect+$trans);
				$abono   = $efect+$trans;
				$calc    = $inicial-$final;

				if($tipoDte == 2){
					$calculo 	 = $final-$inicial;
					$calculo_iva = ($final*1.19);
					$desc_iva    = $calculo_iva-$final;

					$html2      .= ' <table width="100%">
										<tr>
											<td align="left"><b>IVA 19%:</b></td>
										</tr>
										<tr>
											<td align="right"><b>'.Utilidades::monto($desc_iva).'</b></td>
										</tr>
										<tr>
											<td align="left"><b>Total a pagar:</b></td>
										</tr>
										<tr>
											<td align="right"><b>'.Utilidades::monto($calculo_iva).'</b></td>
										</tr>
									</table>';
				}else{
					$desc_iva    = 0;
					$calculo     = 0;

					$html2      .= ' <table width="100%">
										<tr>
											<td align="left"><b>Total a pagar:</b></td>
										</tr>
										<tr>
											<td align="right"><b>'.Utilidades::monto($final).'</b></td>
										</tr>
									</table>';
				}

				if($calculo == 0){
					$html .= '';
				}else{
					$html .= '<div class="texto_boleta">
								<table width="100%">
									<tr>
										<td align="left">Descuentos:</td>
									</tr>
									<tr>
										<td align="right">'.Utilidades::monto($calculo).'</td>
									</tr>
								</table>
				   	   		 </div>';
				}

				if($tipov == 1){
					$html .= '<div class="texto_boleta" >
								<table width="100%" style="border-top: 1px dashed #000;">
									<tr>
										<td align="left">Sub-Total:</td>
									</tr>
									<tr>
										<td align="right">'.Utilidades::monto($final).'</td>
									</tr>
								</table>
							   </div>'.$html2;
				}elseif($tipov == 2){
					$html .= '<div class="texto_boleta" >
								<table width="100%" style="border-top: 1px dashed #000;">
									<tr>
										<td align="left">Sub-Total:</td>
									</tr>
									<tr>
										<td align="right">'.Utilidades::monto($final).'</td>
									</tr>
								</table>
								'.$html2.'
								<table width="100%">
									<tr>
										<td align="center"><b>'.$sql[$i]['tipo_nombre'].'</b></td>
									</tr>
								</table>
							   </div>';

				}elseif($tipov == 3){
					$html .= '<div class="texto_boleta" >
								<table width="100%" style="border-top: 1px dashed #000;">
									<tr>
										<td align="left">Sub-Total:</td>
									</tr>
									<tr>
										<td align="right">'.Utilidades::monto($final).'</td>
									</tr>
								</table>
								'.$html2.'
								<table width="100%" style="border-top: 1px dashed #000;">
									<tr>
										<td align="left">Abonado:</td>
									</tr>
									<tr>
										<td align="right">'.Utilidades::monto($abono).'</td>
									</tr>
								</table>
								<table width="100%">
									<tr>
										<td align="left">Restante:</td>
									</tr>
									<tr>
										<td align="right">'.Utilidades::monto($desc_iva+$final-$abono).'</td>
									</tr>
								</table>
								<table width="100%">
									<tr>
										<td align="center"><b>'.$sql[$i]['tipo_nombre'].'</b></td>
									</tr>
								</table>
							   </div>';
				}elseif($tipov == 4){
					$plazo = $recursos->fecha_pago_plazo($boleta);
					$html .= '<div class="texto_boleta" >
								<table width="100%" style="border-top: 1px dashed #000;">
									<tr>
										<td align="left">Sub-Total:</td>
									</tr>
									<tr>
										<td align="right">'.Utilidades::monto($final).'</td>
									</tr>
								</table>
								'.$html2.'
								<table width="100%">
									<tr>
										<td align="center"><b>'.$sql[$i]['tipo_nombre'].'</b></td>
									</tr>
									<tr>
										<td align="center"><b>Fecha de pago: '.Utilidades::arreglo_fecha2($plazo).'</b></td>
									</tr>
								</table>
							   </div>';

				}elseif($tipov == 5){
					$plazo = $recursos->fecha_pago_plazo($boleta);
					$html .= '<div class="texto_boleta" >
								<table width="100%" style="border-top: 1px dashed #000;">
									<tr>
										<td align="left">Sub-Total:</td>
									</tr>
									<tr>
										<td align="right">'.Utilidades::monto($final).'</td>
									</tr>
								</table>
								'.$html2.'
								<table width="100%">
									<tr>
										<td align="center"><b>'.$sql[$i]['tipo_nombre'].'</b></td>
									</tr>
									<tr>
										<td align="center"><b>Fecha de pago: '.Utilidades::arreglo_fecha2($plazo).'</b></td>
									</tr>
								</table>
							   </div>';
				}elseif($tipov == 6){
					$plazo = $recursos->fecha_pago_plazo($boleta);
					$html .= '<div class="texto_boleta" >
								<table width="100%" style="border-top: 1px dashed #000;">
									<tr>
										<td align="left">Sub-Total:</td>
									</tr>
									<tr>
										<td align="right">'.Utilidades::monto($final).'</td>
									</tr>
								</table>
								'.$html2.'
								<table width="100%">
									<tr>
										<td align="center"><b>'.$sql[$i]['tipo_nombre'].'</b></td>
									</tr>
									<tr>
										<td align="center"><b>Fecha de pago: '.Utilidades::arreglo_fecha2($plazo).'</b></td>
									</tr>
								</table>
							   </div>';

				}
			}

			return $html;
		}

		public function traer_anular_ventas($idUser, $dia){
			$recursos = new Recursos();
			$html 	  = '<div class="table-responsive-xl">
						 <table align="center" class="table table-hover" id="listado_ventas">
							<thead>
								<tr>
									<th>Tipo&nbsp;Venta</th>
									<th>N&deg;&nbsp;Boleta</th>
									<th>Cliente</th>
									<th>Monto</th>
									<th>Hora</th>
									<th>&nbsp;</th>
								</tr>
							</thead>
							<tbody>';

			$sql    = $this->selectQuery("SELECT    count(caja_cliente.c_cli_prod_cliente) suma, caja_cliente.c_cli_prod_cliente, 
												    caja_cliente.c_cli_user_cli, caja_cliente.c_cli_id, 
												    sum(caja_cliente.c_cli_monto) monto, caja_cliente.c_cli_lote, 
												    caja_cliente.c_cli_fecha, caja_cliente.c_cli_hora, clientes.cli_nombre
										  FROM      caja_cliente
										  LEFT JOIN clientes
										  ON        clientes.cli_id 	 			  = caja_cliente.c_cli_clientes
										  WHERE     caja_cliente.c_cli_user_cli       = $idUser
										  AND       caja_cliente.c_cli_fecha          = '$dia'
										  AND       caja_cliente.c_cli_estado         = 2
										  AND       caja_cliente.c_cli_tipoMovimiento IN(3,4,5,6)
										  GROUP BY  caja_cliente.c_cli_lote DESC");

			for ($i=0; $i < count($sql); $i++) { 
				$datos_ventas = $recursos->datos_ventas_tipo_datos($sql[$i]['c_cli_lote']);
				$html .= '<tr>
							<td>'.$datos_ventas[0]['tipo_nombre'].'</td>
							<td>'.$sql[$i]['c_cli_lote'].'</td>
							<td>'.$sql[$i]['cli_nombre'].'</td>
							<td>'.Utilidades::monto($sql[$i]['monto']).'</td>
							<td>'.$sql[$i]['c_cli_hora'].'</td>
							<td align="center">
								<i class="bi bi-cart-x text-danger cursor" onclick="anular_ventas('.$sql[$i]['c_cli_lote'].')"></i>
							</td>
						  </tr>';
			}

			$html .= '</tbody></table></div>';

			return $html;
		}

		public function anular_ventas($boleta, $motivo_texto, $idSucursal, $idUsuario){
			$hoy    = Utilidades::fecha_hoy();
			$hora   = Utilidades::hora();

			$sql    = $this->update_query("UPDATE caja_cliente 
										   SET    c_cli_estado 		= 3 
										   WHERE  c_cli_estado 		= 2 
										   AND    c_cli_lote   		= $boleta");

			$sql2    = $this->update_query("UPDATE ventascliente 
										    SET    ven_cli_estado    = 3 
										    WHERE  ven_cli_estado    = 1 
										    AND    ven_cli_operacion = $boleta");

			$sql3    = $this->update_query("UPDATE pendiete_pago 
										    SET    gas_estado    	 = 3
										    WHERE  gas_boleta        = $boleta");

			$sql4    = $this->update_query("UPDATE descuentos_clientes 
										    SET    desc_estado    	 = 3 
										    WHERE  desc_boleta       = $boleta");

			$sql5    = $this->cambia_estado_producto_anular($boleta);

			$sql6    = $this->insert_query("INSERT INTO anulacion_ventas(anula_usuario, anula_motivo, anula_fecha, anula_hora, anula_sucursal, anula_estado) 
											VALUES('$idUsuario', '$motivo_texto', '$hoy', '$hora', '$idSucursal', 1)");

			if($sql || $sql2 || $sql3 || $sql4 || $sql5 || $sql6){
				return TRUE;
			}else{
				return FALSE;
			}
		}

		public function traer_recepcion_pagos(){
			$hoy    = Utilidades::fecha_hoy();

			$sql    = $this->selectQuery("SELECT * FROM pendiete_pago 
										  LEFT JOIN 	tipos_pago
										  ON        	tipos_pago.tipo_id = pendiete_pago.gas_tipo
										  LEFT JOIN 	clientes
										  ON        	clientes.cli_id    = pendiete_pago.gas_cliente
										  WHERE     	pendiete_pago.gas_estado = 1
										  AND       	pendiete_pago.gas_tipo   > 1
										  ORDER BY  	pendiete_pago.gas_id DESC");

			$html   = '<div class="table-responsive">
						<table align="center" class="table table-hover" id="listado_recepcion_pagos">
							<thead>
								<tr>
									<th>N&deg;&nbsp;Boleta</th>
									<th>Cliente</th>
									<th>Monto</th>
									<th>Fecha&nbsp;Pago</th>
									<th>&nbsp;</th>
								</tr>
							</thead>
							<tbody>';

			for ($i=0; $i < count($sql); $i++) { 
				if($sql[$i]['gas_fecha_pago'] < $hoy){
					$tipo = 'class="text-danger"';
				}else{
					$tipo = 'class="text-info"';
				}

				$html   .= '<tr>
								<td>'.$sql[$i]['gas_boleta'].'</td>
								<td>'.$sql[$i]['cli_nombre'].'</td>
								<td>'.Utilidades::monto($sql[$i]['gas_monto']).'</td>
								<td '.$tipo.'>'.Utilidades::arreglo_fecha2($sql[$i]['gas_fecha_pago']).'</td>
								<td>
									<i class="bi bi-cash-stack text-info cursor" onclick="mostrar_formulario_pago('.$sql[$i]['gas_boleta'].')"></i>
								</td>
							</tr>';
			}

			$html   .= '</tbody></table></div>';

			return $html;
		}

		public function mostrar_formulario_pago($boleta, $idUsuario, $idSucursal){
			$recursos 	= new Recursos();
			$plazo  	= $recursos->datos_pago_plazo($boleta);

			$html 		='  <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
						        <div class="row" style="padding: 10px;">
						            <div class="col-xl-12">
						        		<i class="bi bi-arrow-left-circle-fill text-primary cursor h2" onclick="traer_recepcion_pagos()"></i>
						        	</div>
						        </div>
						    </div>';

			$html .= '<table align="center" class="table" cellspacing="3" cellpadding="3">
						<tr>
							<th>Boleta:</th>
							<th>N&deg;&nbsp; '.$boleta.'</th>
						</tr>
						<tr>
							<th>Cliente:</th>
							<th>'.$plazo[0]['cli_nombre'].'</th>
						</tr>
						<tr>
							<th>Total a Pagar:</th>
							<th>
								'.Utilidades::monto($plazo[0]['gas_monto']).'
								<input type="hidden" id="total_final" name="total_final" value="'.$plazo[0]['gas_monto'].'">
								<input type="hidden" id="cliente" name="cliente" value="'.$plazo[0]['gas_cliente'].'">
							</th>
						</tr>
						<tr>
							<th>Transferencias:</th>
							<td>
								<input type="number" id="transferencias" name="transferencias" class="form-control" value="0" onkeyup="calcula_vuelto()">
							</td>
						</tr>
						<tr>
							<th>Efectivo:</th>
							<td>
								<input type="number" id="efectivo" name="efectivo" class="form-control" value="0" onkeyup="calcula_vuelto3()">
							</td>
						</tr>
						<tr>
							<th>Vuelto:</th>
							<td>
								<input type="number" id="vuelto" name="vuelto" class="form-control" value="0" readonly>
							</td>
						</tr>
						<tr>
							<td colspan="2" align="center">
							<button class="btn btn-info" onclick="procesar_pago('.$boleta.', '.$idUsuario.', '.$idSucursal.')"><i class="bi bi-cash-coin h4 text-white"></i> Procesar</button>
							</td>
						</tr>
					  </table>';

			  return $html;
		}

		public function procesar_pago($boleta, $cliente, $transfer, $efectivo, $vuelto, $idUsuario, $idSucursal){
			$hoy     = Utilidades::fecha_hoy();
			$hora    = Utilidades::hora();

			$calculo = (($transfer+$efectivo)-$vuelto);
			$empresa = 1;
			// Tipo pago 1=pago directo, 2=pago en la entrega, 3=pago abonado **

			$sql  = $this->insert_query("INSERT INTO caja_cliente(c_cli_tipoMovimiento, c_cli_prod_cliente, c_cli_monto, c_cli_user_cli, c_cli_empresa, c_cli_fecha, c_cli_hora, c_cli_estado, c_cli_clientes, c_cli_sucursal, c_cli_lote) 
							   	 		 VALUES(8, 0, '$calculo', '$idUsuario', '$empresa', '$hoy', '$hora', 2, '$cliente', '$idSucursal', '$boleta')");

			$sql2 = $this->insert_query("UPDATE  pendiete_pago
							   	 		 SET     gas_estado = 2
							     		 WHERE   gas_boleta = $boleta");

			if($sql || $sql2){
				return TRUE;
			}else{
				return FALSE;
			}
		}

		public function traer_adicionar_arriendo(){
			$recursos = new Recursos();
			$html = '<table class="table" id="clientes">
						<tr>
							<td>
								'.$recursos->select_clientes().'
							</td>
							<td width="30px">
								<button type="button" id="grabar" class="btn btn-primary form-control shadow" onclick="buscar_adicionar_arriendo()"><i class="bi bi-search"></i></button>
							</td>
						</tr>
					 </table>';

			return $html;
		}

		public function buscar_adicionar_arriendo($idCliente){
			$hoy    = Utilidades::fecha_hoy();

			$sql    =  $this->selectQuery("SELECT   * FROM 	caja_cliente 
										   WHERE    		c_cli_estado   = 2
										   AND      		c_cli_clientes = $idCliente
										   AND      		c_cli_lote     > 0
                                           AND 				c_cli_entrega  IS NULL
                                           AND    			c_cli_fecha_fin > '$hoy'
                                           GROUP BY 		c_cli_lote");

			$html   = '<table align="center" class="table table-hover" id="listado_clientes">
						<thead>
							<tr>
								<th>Boleta</th>
								<th>Fecha Arriendo</th>
								<th>Fecha Entrega</th>
								<th>&nbsp;</th>
							</tr>
						</thead>
						<tbody>';

			for ($i=0; $i < count($sql); $i++) { 
				$html   .= '<tr>
								<td>'.$sql[$i]['c_cli_lote'].'</td>
								<td>'.$sql[$i]['c_cli_fecha'].'</td>
								<td>'.$sql[$i]['c_cli_fecha_fin'].'</td>
								<td>
									<i class="bi bi-cart-plus text-success ver" onclick="mostrar_detalles_adicion('.$sql[$i]['c_cli_lote'].', '.$idCliente.')"></i>
								</td>
							</tr>';
			}

			$html   .= '</tbody></table>';

			return $html;
		}

		public function productos_en_boleta($boleta){
			$recursos = new Recursos();
			$productos= $recursos->datos_productos_boletas($boleta);

			$html = '<div class="box_content">
					    <ol class="rounded-list">
					        <li>
					            <ol>';

			for ($i=0; $i < count($productos); $i++) { 

				if($productos[$i]['c_cli_entrega'] == 1){
					$color = ' class="bg-sucess text-dark"';
				}else{
					$color = '';
				}

				$html .= '<li ><a href="#" '.$color.'>COD: '.$productos[$i]['prod_cli_codigo'].' - '.$productos[$i]['prod_cli_producto'].'</a></li>';
			}
			
			$html .= '			</ol>
					        </li>
					    </ol>
					</div>';

			return $html;
		}

		public function mostrar_detalles_adicion($boleta, $idCliente){
			$recursos   = new Recursos();
			$datos      = $recursos->datos_boleta($boleta);

			$html 		= '<div class="row">
							<div class="col-sm-15 col-md-15 col-lg-15 col-xl-15 mb-3">
						        <div class="row" style="padding: 10px;">
						            <div class="col-xl-12">
						        		<i class="bi bi-arrow-left-circle-fill text-primary cursor h2" onclick="buscar_adicionar_arriendo2('.$idCliente.')"></i>
						        	</div>
						        </div>
						    </div>';

			$html .= '		<div class="col-lg-6 mb-3 shadow">
								<div class="h5 text-info">Datos Arriendo:</div>
								<table width="100%" cellpadding="5" cellspacing="5">
									<tr>
										<th width="50%" valing="middle">Boleta:</th>
										<td width="50%" class="bold plomo">'.$boleta.'</td>
									</tr>
									<tr>
										<th width="50%" valing="middle">Arriendo:</th>
										<td width="50%" class="bold plomo">'.$datos[0]['c_cli_fecha'].'</td>
									</tr>
									<tr>
										<th width="50%" valing="middle">Fin Arriendo:</th>
										<td width="50%" class="bold plomo">'.$datos[0]['c_cli_fecha_fin'].'</td>
									</tr>
									<tr>
										<th width="50%" valing="middle">Nombre:</th>
										<td width="50%" class="bold plomo">'.$datos[0]['cli_nombre'].'</td>
									</tr>
								</table>
								<div id="arribita" class="h5 text-success">Productos Arriendo:</div>
								'.$this->productos_en_boleta($boleta).'
							</div>

							<div class="col-lg-6 mb-3 shadow p-2">
								<div class="d-flex flex-wrap">
									<div class="h5 text-succ ess">Adicionar Arriendo:</div>
									<div class="ms-auto">'.$recursos->select_productos_general(0, $boleta).'</div>
								</div>
								<div id="mostrar_productos"></div>
							</div>

							<div class="col-sm-15 col-md-15 col-lg-15 col-xl-15 mb-3">
						        <table width="50%" align="center">
									<tr>
										<td align="center">
											<button class="btn btn-outline-dark animate__animated animate__pulse animate__slow" href="'.controlador::$rutaAPP.'app/vistas/ventas/php/validador.php?accion=mostrar_boleta&boleta='.$boleta.'" data-fancybox data-type="iframe" data-preload="true" data-width="1200" data-height="1200"><i class="bi bi-printer h5"></i> Comprobante</button>
										</td>
									</tr>
								</table>
						    </div>
						</div>';

			return $html;
		}

		public function traer_formulario_adicionar($boleta, $idProducto){ //  Q U I T A R **
			$recursos = new Recursos();

			$hoy      = Utilidades::fecha_hoy();
			$productos= $recursos->datos_productos($idProducto);

			$sql      = $this->selectQuery("SELECT * FROM caja_cliente
										    LEFT JOIN 	  ventascliente
										    ON        	  ventascliente.ven_cli_operacion 	= caja_cliente.c_cli_lote
										    WHERE    	  caja_cliente.c_cli_tipoMovimiento = 3
										    AND      	  caja_cliente.c_cli_lote           = $boleta
										    GROUP BY 	  caja_cliente.c_cli_tipoMovimiento DESC");


			for ($i=0; $i < count($sql); $i++) {

				$empresa       = $sql[$i]['c_cli_empresa'];
				$sucursal      = $sql[$i]['c_cli_sucursal'];
				$cantidad_dias = Utilidades::calcular_fechas($hoy, $sql[$i]['c_cli_fecha_fin']);
				$calculo       = ($cantidad_dias*$productos[0]['prod_cli_monto']); // monto real sin descuentos

				if($sql[$i]['ven_cli_boleta'] == 2){
					$nuevo_valor = ($calculo*1.19);
					$iva         = ($nuevo_valor-$calculo);
					$tot         = $calculo;
				}else{

					$iva             = 0;
					$nuevo_valor     = $calculo;
				}

				$html         .= '<input type="hidden" name="idProducto" id="idProducto" value="'.$idProducto.'">
								  <input type="hidden" name="boleta" id="boleta" value="'.$boleta.'">
								  <input type="hidden" name="empresa" id="empresa" value="'.$sql[$i]['c_cli_empresa'].'">
								  <input type="hidden" name="sucursal" id="sucursal" value="'.$sql[$i]['c_cli_sucursal'].'">
								  <input type="hidden" name="dias" id="dias" value="'.$cantidad_dias.'">
								  <input type="hidden" name="total" id="total" value="'.$nuevo_valor.'">
								  <input type="hidden" name="monto_real" id="monto_real" value="'.$calculo.'">
								  <input type="hidden" name="unitario" id="unitario" value="'.$productos[0]['prod_cli_monto'].'">
								  <input type="hidden" name="fecheEntrega" id="fecheEntrega" value="'.$sql[$i]['c_cli_fecha_fin'].'">
								  <input type="hidden" name="cliente" id="cliente" value="'.$sql[$i]['c_cli_clientes'].'">
								  <input type="hidden" name="idUsuario" id="idUsuario" value="'.$sql[$i]['c_cli_user_cli'].'">
								  <input type="hidden" name="iva" id="iva" value="'.$iva.'">';

				$html   .= '<table align="center" class="table">
								<tr>
									<th>Producto:</th>
									<td>'.$productos[0]['prod_cli_producto'].'</td>
								</tr>
								<tr>
									<th>Valor x dia:</th>
									<td>'.Utilidades::monto($productos[0]['prod_cli_monto']).'</td>
								</tr>
								<tr>
									<th>Cantidad Dias:</th>
									<td>'.$cantidad_dias.'</td>
								</tr>';

				if($sql[$i]['ven_cli_boleta'] == 2){
					$html   .= '<tr>
									<th>Sub-total:</th>
									<td>'.Utilidades::monto($tot).'</td>
								</tr>
								<tr>
									<th>IVA:</th>
									<td>'.Utilidades::monto($nuevo_valor-$tot).'</td>
								</tr>';
				}

				$html   .= '    <tr>
									<th>Total:</th>
									<td>'.Utilidades::monto($nuevo_valor).'</td>
								</tr>
								<tr>
									<th>Fecha Entrega:</th>
									<td>'.Utilidades::arreglo_fecha2($sql[$i]['c_cli_fecha_fin']).'</td>
								</tr>
							</table>
							<div id="grabar_adicion">
							<small ><p align="center">Cuando es pago en la entrega, 30, 60 y 90 dias seleccionar "Pago en la entrega".<p></small>
							<table align="center" class="table">
								<tr>
									<th width="30%">Tipo Pago:</th>
									<td width="70%">
										<select id="tipo_pago" class="form-control shadow" onchange="tipo_pagar()">
											<option value="0">Seleccionar Pago</option>
											<option value="1">-&nbsp;Pago directo</option>
											<option value="2">-&nbsp;Pago en la entrega</option>
										</select>
									</td>
								</tr>
								<tr id="oculto_1">
									<td>Transferencias:</td>
									<td>
										<input type="number" id="transferencias" name="transferencias" class="form-control shadow" value="0">
									</td>
								</tr>
								<tr id="oculto_2">
									<td>Efectivo:</td>
									<td>
										<input type="number" id="efectivo" name="efectivo" class="form-control shadow" value="0">
									</td>
								</tr>
								<tr id="oculto_4">
									<td colspan="2" align="center">
										<button class="btn btn-info animate__animated animate__pulse animate__slow" onclick="agregar_arriendo()"><i class="bi bi-cart-plus h5 text-white"></i> Agregar</button>
									</td>
								</tr>
							</table></div><div id="boleta"></div>';
			}

			return $html;
		}

		public function aumentar_por_pagar($total, $boleta){
			$this->update_query("UPDATE pendiete_pago 
								 SET    gas_monto     = gas_monto+$total
						         WHERE  gas_boleta    = $boleta");
		}

		public function grabar_adicional_caja($idProducto, $boleta, $empresa, $sucursal, $fecheEntrega, $dias, $transfer, $efectivo, $cliente, $idUsuario, $monto_real){
			$hoy    = Utilidades::fecha_hoy();
			$hora   = Utilidades::hora();

			$sql    = $this->insert_query("INSERT INTO caja_cliente(c_cli_tipoMovimiento, c_cli_prod_cliente, c_cli_monto, c_cli_user_cli, c_cli_empresa, c_cli_fecha, c_cli_fecha_fin, c_cli_dias, c_cli_hora, c_cli_estado, c_cli_clientes, c_cli_sucursal, c_cli_lote)
					   						VALUES(3, '$idProducto', '$monto_real', '$idUsuario', '$empresa', '$hoy', '$fecheEntrega', '$dias', '$hora', 2, '$cliente', '$sucursal', '$boleta')");

			if($sql){
				return TRUE;
			}else{
				return FALSE;
			}
		}

		public function aumentar_ventas_clientes($boleta, $total, $transfer, $efectivo, $monto_real, $iva){
			$recursos = new Recursos();

			$hoy      = Utilidades::fecha_hoy();
			$hora     = Utilidades::hora();
			$ventas   = $recursos->datos_ventas($boleta);

			for ($i=0; $i < count($ventas); $i++) { 
				$montoInicial      = $ventas[$i]['ven_cli_montoInicial']+$monto_real;
				$montoReal         = $ventas[$i]['ven_cli_montoReal']+$total;
				$efectivoEntregado = $ventas[$i]['ven_cli_efectivoEntregado']+$efectivo;
				$transferencia     = $ventas[$i]['ven_cli_transferencia']+$transfer;
				$iva               = $ventas[$i]['ven_iva']+$iva;

				$this->update_query("UPDATE  ventascliente
									 SET     ven_cli_montoInicial      = '$montoInicial', 
									 		 ven_cli_montoReal         = '$montoReal', 
									 		 ven_cli_efectivoEntregado = '$efectivoEntregado', 
									 		 ven_cli_transferencia     = '$transferencia',
									 		 ven_iva                   = '$iva'
									 WHERE   ven_cli_operacion         = '$boleta'");
			}

			if($i > 0){
				return TRUE;
			}else{
				return FALSE;
			}
		}

		public function traer_recepcion_equipos(){
			$hoy    = Utilidades::fecha_hoy();

			/* c_cli_lote, c_cli_fecha, c_cli_fecha_fin */

			$sql    = $this->selectQuery("SELECT * FROM caja_cliente 
										  LEFT JOIN 	clientes
										  ON        	clientes.cli_id    	= caja_cliente.c_cli_clientes
										  WHERE    		c_cli_estado    	= 2
										  AND           c_cli_entrega      is null
										  GROUP BY 		c_cli_lote
										  ORDER BY 		c_cli_id DESC");

			$html   = '<div class="table-responsive">
						<table align="center" class="table table-hover" id="listado_recepcion_pagos">
							<thead>
								<tr>
									<th>N&deg;&nbsp;Boleta</th>
									<th>Cliente</th>
									<th>Fecha&nbsp;Arriendo</th>
									<th>Fecha&nbsp;Entrega</th>
									<th>&nbsp;</th>
								</tr>
							</thead>
							<tbody>';

			for ($i=0; $i < count($sql); $i++) { 
				if($sql[$i]['c_cli_fecha_fin'] < $hoy){
					$tipo = 'class="text-danger"';
				}else{
					$tipo = 'class="text-info"';
				}

				$html   .= '<tr>
								<td>'.$sql[$i]['c_cli_lote'].'</td>
								<td>'.$sql[$i]['cli_nombre'].'</td>
								<td>'.Utilidades::arreglo_fecha2($sql[$i]['c_cli_fecha']).'</td>
								<td '.$tipo.'>'.Utilidades::arreglo_fecha2($sql[$i]['c_cli_fecha_fin']).'</td>
								<td>
									<i class="bi bi-truck text-info cursor" onclick="traer_recepcionar_arriendo('.$sql[$i]['c_cli_lote'].','.$sql[$i]['cli_id'].')"></i>
								</td>
							</tr>';
			}

			$html   .= '</tbody></table></div>';

			return $html;
		}

		public function nuevo_valor_con_descuento_neto($boleta, $dias_cobrar){
			$recursos   	 = new Recursos();
			$data            = 0;

			$datos_productos = $recursos->datos_productos_boletas($boleta);

			for ($i=0; $i < count($datos_productos); $i++) { 
				$data += (($datos_productos[$i]['prod_cli_monto']-$datos_productos[$i]['c_cli_nuevo_diario'])*$dias_cobrar);
			}

			return $data;
		}

		public function nuevo_valor_con_descuento_bruto($boleta, $dias_cobrar){
			$recursos   	 = new Recursos();
			$data            = 0;

			$datos_productos = $recursos->datos_productos_boletas($boleta);
			$tipo   		 = $datos_productos[0]['ven_cli_boleta'];

			for ($i=0; $i < count($datos_productos); $i++) { 
				$data += (($datos_productos[$i]['prod_cli_monto']-$datos_productos[$i]['c_cli_nuevo_diario'])*$dias_cobrar);
			}

			if($tipo == 2){
				return ($calc*1.19);
			}else{
				return $calc;
			}
		}

		public function traer_recepcionar_arriendo($boleta, $idCliente, $idUsuario, $idSucursal){
			$recursos     = new Recursos();
			$datos_cliente= $recursos->datos_clientes($idCliente);
			$datos_boleta = $recursos->datos_boleta($boleta);

			$idCliente    = $idUsuario;
			$sucu         = $idSucursal;
			$idCli        = $idCliente;
			$hoy    	  = Utilidades::fecha_hoy();
			$rut          = $datos_cliente[0]['cli_rut'];
			$tipoVenta    = $datos_boleta[0]['ven_tipo_venta'];
			$fecha_inicio = $datos_boleta[0]['c_cli_fecha'];
			$fecha_fin    = $datos_boleta[0]['c_cli_fecha_fin'];
			$dias_fin     = Utilidades::contador_fecha($hoy, $fecha_fin);
			$dias_cobrar  = Utilidades::contador_fecha($fecha_inicio, $hoy);
			$tipo_dte     = $datos_boleta[0]['ven_cli_boleta'];
			$dias_arriendo= $datos_boleta[0]['c_cli_dias'];

			if($tipo_dte == 2){
				$tip     = '<small>iva inc.</small>';
			}else{
				$tip     = '';
			}

			$total_abono = $datos_boleta[0]['ven_cli_efectivoEntregado'] + $datos_boleta[0]['ven_cli_transferencia'];
			$total_venta = $datos_boleta[0]['ven_cli_montoReal'] + $datos_boleta[0]['ven_iva'];
			$nuevo_valor = $this->nuevo_valor_con_descuento_neto($boleta, $dias_cobrar);
			$nuevo_valor2= $this->nuevo_valor_con_descuento_bruto($boleta, $dias_cobrar);

			$restante        = $total_venta-$total_abono;

			$total_valor   = $nuevo_valor2-$nuevo_valor;
			if($total_valor > 0){
				$ivaono = '<tr class="blanco">
							   	<th>IVA:</th>
								<td>
									'.Utilidades::monto($total_valor).'
									<input type="hidden" id="nuevo_iva" name="nuevo_iva" value="'.$total_valor.'">
								</td>
							   </tr>';
			}else{
				$ivaono = '<input type="hidden" id="nuevo_iva" name="nuevo_iva" value="0">';
			}

			if($dias_cobrar  > 0 && $dias_cobrar <= $dias_arriendo){

				  $tipoPago = '<table width="95%" align="center" class="table" cellspacing="4" cellpadding="4">
								<tr>
									<th>Total:</th>
									<td>
										'.Utilidades::monto($total_venta).' '.$tip.'
									</td>
								</tr>
								<tr>
									<th>Abonado:</th>
									<td>
										'.Utilidades::monto($total_abono).'
										<input type="hidden" id="abono" name="abono" class="form-control shadow" value="'.$total_abono.'" readonly>
									</td>
								</tr>
								<tr>
									<th>Total:</th>
									<td>
										'.Utilidades::monto($total_venta-$total_abono).' '.$tip.'
										<input type="hidden" id="total" name="total" value="'.$total_venta.'" >
										<input type="hidden" id="nuevo_total" name="nuevo_total" value="'.($total_venta-$total_abono).'" >
										<input type="hidden" id="ultimo_valor" name="ultimo_valor" value="'.$nuevo_valor.'" >
										<input type="hidden" id="total_ultimo_valor" name="total_ultimo_valor" value="'.($nuevo_valor-$total_abono).'" >
									</td>
								</tr>
								<tr class="blanco">
									<td colspan="2" class="text-info h6" align="center">Descuento por entrega anticipada:</td>
								</tr>
								<tr class="blanco">
									<th>D&iacute;as Cobrados:</th>
									<td>
										'.$dias_cobrar.' 
									</td>
								</tr>
								<tr class="blanco">
									<th>Nuevo Monto a Pagar:</th>
									<td>
										'.Utilidades::monto($nuevo_valor-$total_abono).'
									</td>
								</tr>
								'.$ivaono.'
								<tr>
									<th>Transferencias:</th>
									<td>
										<input type="number" id="transferencias" name="transferencias" class="form-control shadow" value="0" onkeyup="calcula_vuelto_anticipado()">
									</td>
								</tr>
								<tr>
									<th>Efectivo:</th>
									<td>
										<input type="number" id="efectivo" name="efectivo" class="form-control shadow" value="0" onkeyup="calcula_vuelto_anticipado()">
									</td>
								</tr>
								<tr>
									<th>Vuelto:</th>
									<td>
										<input type="number" id="vuelto" name="vuelto" class="form-control shadow" value="0" readonly>
									</td>
								</tr>
								<tr>
									<td colspan="2" align="center">
										<table width="20%" align="center">
											<tr>
												<td  align="center">
													<div class="text_link2 bold cursor titulo_130" onclick="finalizar_arriendo_anticipado('.$boleta.')">Procesar</div>
												</td>
											</tr>
										</table>
									</td>
								</tr>
							  </table>';
				}else{

					$tipoPago = '<table width="95%" align="center" class="arriba_2 abajo_3 verde" cellspacing="5" cellpadding="5">
								<tr >
									<th>Total:</th>
									<td>
										'.Utilidades::monto($total_venta).'
										<input type="hidden" id="total" name="total" class="form-control shadow" value="'.$total_venta.'" readonly>
									</td>
								</tr>
								<tr >
									<th>Abonado:</th>
									<td>
										'.Utilidades::monto($total_abono).'
										<input type="hidden" id="abono" name="abono" class="form-control shadow" value="'.$total_abono.'" readonly>
									</td>
								</tr>
								<tr >
									<th>Total a pagar:</th>
									<td>
										'.Utilidades::monto($total_venta-$total_abono).'
										<input type="hidden" id="nuevo_total" name="nuevo_total" class="form-control shadow" value="'.$total_venta.'" readonly>
									</td>
								</tr>
								'.$ivaono.'
								<tr>
									<th>Transferencias:</th>
									<td>
										<input type="number" id="transferencias" name="transferencias" class="form-control shadow" value="0" onkeyup="calcula_vuelto_entrega()">
									</td>
								</tr>
								<tr>
									<th>Efectivo:</th>
									<td>
										<input type="number" id="efectivo" name="efectivo" class="form-control shadow" value="0" onkeyup="calcula_vuelto_entrega()">
									</td>
								</tr>
								<tr>
									<th>Vuelto:</th>
									<td>
										<input type="number" id="vuelto" name="vuelto" class="form-control shadow" value="0" readonly>
									</td>
								</tr>
								<tr>
									<td colspan="2" align="center">
										<table width="20%" align="center">
											<tr>
												<td  align="center">
													<div class="text_link2 bold cursor titulo_130" onclick="finalizar_arriendo('.$boleta.')">Procesar</div>
												</td>
											</tr>
										</table>
									</td>
								</tr>
							  </table>';
				}

			$tipo_pago = $recursos->tipos_pagos_x_id($tipoVenta);

			$html =  '
				<input type="hidden" name="cod2" id="cod2" value="'.$rut.'">
				<div class="container">
					<div class="row">
						<div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
						    <div class="row" style="padding: 10px;">
						        <div class="col-xl-12">
						       		<i class="bi bi-arrow-left-circle-fill text-primary cursor h2" onclick="traer_recepcion_equipos()"></i>
						       	</div>
						    </div>
						</div>
						<div class="col-14 mt-2 p-1 sombraPlana">
								<div class="h5 text-dark">Datos Arriendo:</div>
								<div class="entero m-1">
									<table width="100%" cellpadding="5" cellspacing="5">
										<tr>
											<th width="50%" valing="middle">Boleta:</th>
											<td width="50%" class="bold plomo">'.$boleta.'</td>
										</tr>
										<tr>
											<th width="50%" valing="middle">Arriendo:</th>
											<td width="50%" class="bold plomo">'.Utilidades::arreglo_fecha2($fecha_inicio).'</td>
										</tr>
										<tr>
											<th width="50%" valing="middle">Fin Arriendo:</th>
											<td width="50%" class="bold plomo">'.Utilidades::arreglo_fecha2($fecha_fin).'</td>
										</tr>
										<tr>
											<th width="50%" valing="middle">Cliente:</th>
											<td width="50%" class="bold plomo">'.$datos_cliente[0]['cli_nombre'].'</td>
										</tr>
										<tr>
											<th width="50%" valing="middle">Tipo Pago:</th>
											<td width="50%" class="bold plomo">'.$tipo_pago[0]['tipo_nombre'].'</td>
										</tr>
									</table>
									<div id="arribita" class="h5 text-info">Productos Arrendados:</div>
									<div class="entero bordes">
										'.$this->productos_en_boleta($boleta).'
									</div>
								</div>
							</div>
							<div class="col-14 mt-5 p-1 sombraPlana">
								<table width="100%">
									<tr>
										<th width="80%">
											<div id="arribita" class="h5 text-dark">Recepcionar Arriendo:</div>
										</th>
										<td width="20%">
											<button type="button" class="btn btn-success" onclick="ver_listado_producto()"><i class="bi bi-boxes"></i> Productos</button>
										</td>
									</tr>
								</table>
								<div class="entero bordes">
									<div id="producto_boleta" style="display:none;">
										'.$this->productos_en_boleta_individual($boleta).'
									</div>
									<hr>
									'.$tipoPago.'
								</div>
							</div>
						</div>
					</div>';

			return $html;
		}

		public function mostrar_historial_productos($boleta, $idProducto){
			$recursos = new Recursos();
			$historial= $recursos->historial_producto($boleta, $idProducto);
			$html 	  = '';

			for ($i=0; $i < count($historial); $i++) { 
				$html 	  .= '<p>'.$historial[$i]['his_glosa'].'</p>';
			}

			return $html;
		}

		public function productos_en_boleta_individual($boleta){
			$recursos = new Recursos();
			$productos= $recursos->datos_productos_boletas($boleta);

			$html = '<div class="box_content">
					    <ol class="rounded-list">
					        <li>
					            <ol>';

			for ($i=0; $i < count($productos); $i++) {

				if($productos[$i]['c_cli_entrega'] == 1){

					$html  .= '
						<table width="95%" align="center" cellspacing="0" cellpadding="5" class="table">
							<tr >
								<td class="bold text-info">Cod:&nbsp;'.$productos[$i]['prod_cli_codigo'].'-'.$productos[$i]['prod_cli_producto'].'.</td>
								<td align="right"><b class="text-info">Entregado el '.Utilidades::arreglo_fecha2($productos[$i]['c_cli_fecha_entregado']).'</b>.</td>
							 </tr>
						</table><br>';
				}else{
					$html  .= '
						<table width="95%" align="center" cellspacing="0" cellpadding="5" class="table">
							<tr>
								<td class="bold">Cod:&nbsp;'.$productos[$i]['prod_cli_codigo'].'-'.$productos[$i]['prod_cli_producto'].'.</td>
								<td align="right">Escribir comentario de entrega.</td>
							 </tr>
							 <tr>
								<td colspan="2" id="cambiar'.$productos[$i]['prod_cli_id'].'">
									<textarea rows="3" id="comentario'.$productos[$i]['prod_cli_id'].'" name="comentario'.$productos[$i]['prod_cli_id'].'" class="form-control shadow" style="resize: none;">'.$this->mostrar_historial_productos($boleta, $idProducto).'</textarea>
								</td>
							 </tr>
							 <tr>
							 	<td colspan="2">
							 		<table width="100%" align="center">
										<tr>
											<td align="left">
												<small>Grabar Historial</small><br>
												<button type="button" class="btn btn-primary" onclick="grabar_historial('.$productos[$i]['prod_cli_id'].', '.$boleta.', '.$productos[$i]['c_cli_clientes'].')"><i class="bi bi-save text-white"></i></button>
											</td>
											<td>&nbsp;</td>
											<td  align="right">
												<small>Recepcion individual de este producto.</small><br>
												<button type="button" class="btn btn-success" onclick="recepcion_individual('.$productos[$i]['c_cli_id'].', '.$boleta.', '.$productos[$i]['c_cli_prod_cliente'].')"><li class="bi bi-truck text-white"></li></button>
											</td>
										</tr>
									</table>
							 	</td>
							 </tr>
						</table><br>';
				}
			}
			
			$html .= '			</ol>
					        </li>
					    </ol>
					</div>';

			return $html;
		}

		public function grabar_historial($boleta, $idCliente, $idProducto, $comentario, $tipo_venta){
			$hoy    = Utilidades::fecha_hoy();
			$hora   = Utilidades::hora();

			$sql    = $this->insert_query("INSERT INTO historial_productos(his_producto, his_cliente, his_tipo, his_glosa, his_fecha, his_hora, his_estado, his_boleta)
				       					   VALUES('$idProducto', '$idCliente', '$tipo_venta', '$comentario', '$hoy', '$hora', 1, '$boleta')");

			if ($sql) {
				return TRUE;
			}else{
				return FALSE;
			}
		}

		public function recepcion_individual($boleta, $idCliente, $idProducto, $comentario, $tipo_venta){
			$hoy    = Utilidades::fecha_hoy();
			$hora   = Utilidades::hora();

			$sql1   = $this->update_query("UPDATE caja_cliente
				   						   SET 	  c_cli_recepcion       = 1,
				   								  c_cli_entrega 		= 1,
				   	      						  c_cli_fecha_entregado = '$hoy',
				   	      						  c_cli_hora_entrega    = '$hora'
				   						   WHERE  c_cli_lote            = $boleta
				   						   AND    c_cli_prod_cliente    = $idProducto");

			$sql2   = $this->update_query("UPDATE product_cliente
				   						   SET 	  prod_cli_estado       = 1
				   						   WHERE  prod_cli_id           = $idProducto");

			$sql3   = $this->insert_query("INSERT INTO historial_productos(his_producto, his_cliente, his_tipo, his_glosa, his_fecha, his_hora, his_estado, his_boleta)
				       						VALUES('$idProducto', '$idCliente', '$tipo_venta', '$comentario', '$hoy', '$hora', 1, '$boleta')");

			if ($sql1 || $sql2 || $sql3) {
				return TRUE;
			}else{
				return FALSE;
			}
		}

		public function ver_historial_productos($boleta, $idProd){
			$html   = '';

			$sql    = $this->selectQuery("SELECT * FROM historial_productos
								   	      WHERE         his_boleta   = $boleta
								   	   	  AND      	 	his_producto = $idProd
								   	   	  ORDER BY 		his_id DESC LIMIT 1");

			for ($i=0; $i < count($sql); $i++) { 
				$html   .= '<textarea rows="3" id="comentario'.$idProd.'" name="comentario'.$idProd.'" class="form-control sombraPlana" style="resize: none;">'.$sql[$i]['his_glosa'].'</textarea>';
			}


			return $html;
		}

		public function upCaja_cliente_finalizar($boleta, $monto){
			$hoy    = Utilidades::fecha_hoy();
			$hora   = Utilidades::hora();

			$sql    = $this->selectQuery("SELECT * FROM caja_cliente
										  WHERE    		c_cli_lote         = $boleta
										  AND      		c_cli_prod_cliente > 0
										  GROUP BY 		c_cli_lote");

			for ($i=0; $i < count($sql); $i++) {
				$user_cli = $sql[$i]['c_cli_user_cli'];
				$empresa  = $sql[$i]['c_cli_empresa'];
				$lote     = $sql[$i]['c_cli_lote'];
				$clientes = $sql[$i]['c_cli_clientes'];
				$sucursal = $sql[$i]['c_cli_sucursal'];
				$entrega  = $sql[$i]['c_cli_entrega'];

				$this->insert_query("INSERT INTO caja_cliente(c_cli_tipoMovimiento, c_cli_monto, c_cli_user_cli, c_cli_empresa, c_cli_lote, c_cli_clientes, c_cli_sucursal, c_cli_entrega, c_cli_fecha, c_cli_hora, c_cli_estado) 
					   				 VALUES(11, '$monto', '$user_cli', '$empresa', '$lote', '$clientes', '$sucursal', '$entrega', '$hoy', '$hr', 2)");
			}

			if($i > 0){
				return TRUE;
			}else{
				return FALSE;
			}
		}

		public function upCaja_cliente_descuentos($boleta, $monto){
			$hoy    = Utilidades::fecha_hoy();
			$hora   = Utilidades::hora();

			$sql    = $this->selectQuery("SELECT * FROM caja_cliente
										  WHERE    		c_cli_lote         = $boleta
										  AND      		c_cli_prod_cliente > 0
										  GROUP BY 		c_cli_lote");

			for ($i=0; $i < count($sql); $i++) {
				$user_cli = $sql[$i]['c_cli_user_cli'];
				$empresa  = $sql[$i]['c_cli_empresa'];
				$lote     = $sql[$i]['c_cli_lote'];
				$clientes = $sql[$i]['c_cli_clientes'];
				$sucursal = $sql[$i]['c_cli_sucursal'];
				$entrega  = $sql[$i]['c_cli_entrega'];

				$this->insert_query("INSERT INTO caja_cliente(c_cli_tipoMovimiento, c_cli_monto, c_cli_user_cli, c_cli_empresa, c_cli_lote, c_cli_clientes, c_cli_sucursal, c_cli_entrega, c_cli_fecha, c_cli_hora, c_cli_estado) 
					   				 VALUES(12, '$monto', '$user_cli', '$empresa', '$lote', '$clientes', '$sucursal', '$entrega', '$hoy', '$hr', 2)");
			}

			if($i > 0){
				return TRUE;
			}else{
				return FALSE;
			}
		}

		public function finalizar_arriendo_anticipado($total, $ultimo_valor, $total_ultimo_valor, $nuevo_iva, $transfer, $efectivo, $vuelto, $abono, $boleta){
			$hoy    		 = Utilidades::fecha_hoy();
			$hora   		 = Utilidades::hora();

			$recursos        = new Recursos();
			$efectivo_total  = ($total-$ultimo_valor);
			$total2          = ($ultimo_valor+$nuevo_iva);

			$tipo_venta      = $recursos->datos_ventas_tipo_datos($boleta);

			$sql    = $this->update_query("UPDATE ventascliente
										   SET    ven_cli_montoReal         = '$ultimo_valor',
										   		  ven_cli_descuentos        = '$efectivo_total',
										   		  ven_iva                   = '$nuevo_iva',
										   		  ven_cli_transferencia     = '$transfer',
										   		  ven_cli_efectivoEntregado = '$efectivo',
										   		  ven_cli_vuelto            = '$vuelto'
										   WHERE  ven_cli_operacion         =  $boleta");

			if($sql){

				$sql2 = $this->update_query("UPDATE caja_cliente 
									   		 SET    c_cli_entrega         = 1,
									          		c_cli_fecha_entregado = '$hoy', 
									          		c_cli_hora_entrega    = '$hora'
									   		 WHERE  c_cli_lote            = $boleta");

				if($tipo_venta[0]['ven_tipo_venta'] <= 3){
					 $this->upCaja_cliente_finalizar($boleta, $total_ultimo_valor);
				}

				$this->upCaja_cliente_descuentos($boleta, $ultimo_valor);

				$this->cambia_estado_producto($boleta);

				$this->update_query("UPDATE pendiete_pago
					   				 SET    gas_monto   = '$total2', 
					   				 		gas_estado  = 2
					   				 WHERE  gas_boleta  =  $boleta");

				if($sql2){
					$estado = TRUE;
				}else{
					$estado = FALSE;
				}
			}else{

				$estado = FALSE;

			}

			return $estado;
		}

		public function finalizar_arriendo($transfer, $efectivo, $total, $vuelto, $abono, $boleta){
			$hoy    		 = Utilidades::fecha_hoy();
			$hora   		 = Utilidades::hora();

			$recursos        = new Recursos();
			$tipo_venta      = $recursos->datos_ventas_tipo_datos($boleta);

			$efectivo_total  = $efectivo-$vuelto;

			$sql = $this->update_query("UPDATE 	ventascliente
										SET    	ven_cli_efectivoEntregado = $efectivo_total+ven_cli_efectivoEntregado,
												ven_cli_transferencia     = '$transfer',
												ven_cli_vuelto            = '$vuelto'
										WHERE   ven_cli_operacion         = $boleta");

			if($sql){

				$sql2 = $this->update_query("UPDATE caja_cliente 
									   		 SET    c_cli_entrega         = 1,
									          		c_cli_fecha_entregado = '$hoy', 
									          		c_cli_hora_entrega    = '$hora'
									   		 WHERE  c_cli_lote            = $boleta");

				$this->upCaja_cliente_finalizar($boleta, $total_ultimo_valor);

				$this->cambia_estado_producto($boleta);

				$this->update_query("UPDATE pendiete_pago
					   				 SET    gas_estado  = 2
					   				 WHERE  gas_boleta  =  $boleta");
				if($sql2){
					$estado = TRUE;
				}else{
					$estado = FALSE;
				}
			}else{

				$estado = FALSE;

			}

			return $estado;
		}

		public function movimientos_de_caja($idUser, $dia){
			$recursos = new Recursos();
			$html 	  = '<div class="table-responsive-xl">
						 <table align="center" class="table table-hover" id="listado_ventas">
							<thead>
								<tr>
									<th>Tipo&nbsp;Venta</th>
									<th>N&deg;&nbsp;Boleta</th>
									<th>Cliente</th>
									<th>Monto</th>
									<th>Hora</th>
									<th>&nbsp;</th>
								</tr>
							</thead>
							<tbody>';

			$sql    = $this->selectQuery("SELECT    count(caja_cliente.c_cli_prod_cliente) suma, caja_cliente.c_cli_prod_cliente, 
												    caja_cliente.c_cli_user_cli, caja_cliente.c_cli_id, 
												    sum(caja_cliente.c_cli_monto) monto, caja_cliente.c_cli_lote, 
												    caja_cliente.c_cli_fecha, caja_cliente.c_cli_hora, clientes.cli_nombre
										  FROM      caja_cliente
										  LEFT JOIN clientes
										  ON        clientes.cli_id 	 			  = caja_cliente.c_cli_clientes
										  WHERE     caja_cliente.c_cli_user_cli       = $idUser
										  AND       caja_cliente.c_cli_fecha          = '$dia'
										  AND       caja_cliente.c_cli_estado         = 2
										  AND       caja_cliente.c_cli_tipoMovimiento IN(3,4,5,6)
										  GROUP BY  caja_cliente.c_cli_lote DESC");

			for ($i=0; $i < count($sql); $i++) { 
				$datos_ventas = $recursos->datos_ventas_tipo_datos($sql[$i]['c_cli_lote']);
				$html .= '<tr>
							<td>'.$datos_ventas[0]['tipo_nombre'].'</td>
							<td>'.$sql[$i]['c_cli_lote'].'</td>
							<td>'.$sql[$i]['cli_nombre'].'</td>
							<td>'.Utilidades::monto($sql[$i]['monto']).'</td>
							<td>'.$sql[$i]['c_cli_hora'].'</td>
							<td align="center">
								<i class="bi bi-eyes text-danger cursor" onclick="ver_boleta('.$sql[$i]['c_cli_lote'].')"></i>
							</td>
						  </tr>';
			}

			$html .= '</tbody></table></div>';

			return $html;
		}
	
	   /**  FIN VENTAS   **/

	} // END CLASS
?>