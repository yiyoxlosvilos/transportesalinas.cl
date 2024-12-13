<?php
	require_once __dir__."/../modelo/obtener_datos.php";
	require_once __dir__."/../controlador/utilidadesControlador.php";
	require_once __dir__."/../controlador/productosControlador.php";
	require_once __dir__."/../controlador/finanzasControlador.php";
	require_once __dir__."/../controlador/recursosControlador.php";
  	require_once __dir__."/../controlador/centroCostoControlador.php";


	class Ruta extends GetDatos {

		public function __construct(){
			parent::__construct();
	    }

	    public function consultar_hoja_ruta_login($inputRut, $inputCodigo){
	    	$sql = $this->selectQuery("SELECT * FROM fletes
	    							   LEFT JOIN     servicios
	    							   ON 		     servicios.serv_id     = fletes.fle_servicio
	    							   LEFT JOIN     trabajadores
	    							   ON            trabajadores.tra_id   = fletes.fle_chofer
	    							   WHERE         trabajadores.tra_rut  = '$inputRut'
	    							   AND           servicios.serv_codigo = '$inputCodigo'");

	    	return $sql;
	    }

	    public function consultar_hoja_ruta($inputRut, $inputCodigo){
	    	$sql = $this->selectQuery("SELECT * FROM fletes
	    							   LEFT JOIN     servicios
	    							   ON 		     servicios.serv_id     = fletes.fle_servicio
	    							   LEFT JOIN     trabajadores
	    							   ON            trabajadores.tra_id   = fletes.fle_chofer
	    							   WHERE         trabajadores.tra_rut  = '$inputRut'
	    							   AND           servicios.serv_codigo = '$inputCodigo'");

	    	return $sql;
	    }

	    public function control_hoja_ruta($idTrabajador, $idFlete, $idServicio){
	    	$sql = $this->selectQuery("SELECT * FROM hoja_ruta
	    							   WHERE         hoja_chofer   = $idTrabajador
	    							   AND           hoja_flete    = $idFlete
	    							   AND           hoja_servicio = $idServicio
	    							   AND           hoja_estado   = 1");

	    	return $sql;
	    }

	    public function mostrar_detalle_servicio_ruta($idServicio, $idTrabajador){
	    	$mostrar 		= '';
			$recursos     	= new Recursos();
			$finanzas     	= new Finanzas();
			$centroCostos 	= new CentroCostos();

			$hoy            = Utilidades::fecha_hoy();

			$sql 			= $centroCostos->datos_servicios($idServicio);
			$datos_flete    = $recursos->datos_fletes($idServicio);
			$monto_servicio = $recursos->datos_fletes_monto($idServicio);
			$monto_gastos   = $recursos->datos_gastos_monto_ruta($idServicio, $idTrabajador);
			$sub_total      = ($monto_servicio-$monto_gastos);
			$datos_hoja_ruta= $this->control_hoja_ruta($idTrabajador, $datos_flete[0]['fle_id'], $idServicio);

			$mostrar .= '<div class="d-flex flex-wrap align-items-center mb-4">
                        	<h2 class="text-primary border-bottom">Hoja de Ruta</h2>
	                        <div class="ms-auto">
	                        	<button class="btn-danger p-2 border rounded" onclick="cerrar_session()"><i class="bi bi-x-square  text-white"></i></button>
	                        </div>
                    	 </div>';

			if(count($datos_hoja_ruta) == 0){
				$mostrar .='
					<div class="row">
						<div class="col-sm-3 border p-3 mb-1 bg-white rounded h4">Ingresar Deposito <br>
							<input type="number" class="form-control" name="monto_inicial" id="monto_inicial" placeholder="Escribir Deposito">
						</div>
						<div class="col-sm-3 border p-3 mb-1 bg-white rounded h4">Ingresar Fecha <br>
							<input type="date" class="form-control" name="fecha_hoja" id="fecha_hoja" value="'.$hoy.'"></div>
						<div class="col-sm-3 border p-3 mb-1 bg-white rounded h4">Descripci&oacute;n <br>
							<input type="text" class="form-control" name="descripcion" id="descripcion" placeholder="Escribir Glosa"></div>
						<div class="col-sm-3 p-3 mb-1 bg-white h4">&nbsp;<br>
							<input type="hidden" name="idServicio" id="idServicio" value="'.$idServicio.'">
							<input type="hidden" name="idTrabajador" id="idTrabajador" value="'.$idTrabajador.'">
							<input type="hidden" name="idFlete" id="idFlete" value="'.$datos_flete[0]['fle_id'].'">
							<button class="btn btn-primary" onclick="grabar_hoja_ruta()">
	    						<i class="bi bi-save"></i>
	    					</button>
						</div>
					</div>';
			}else{
				$sub_total= ($datos_hoja_ruta[0]['hoja_deposito']-$monto_gastos);
				$mostrar .='
					<div class="row">
						<div class="col-sm-3 border p-3 mb-1 bg-white rounded h4">Deposito <br>'.Utilidades::monto($datos_hoja_ruta[0]['hoja_deposito']).'</div>
						<div class="col-sm-3 border p-3 mb-1 bg-white rounded h4">Gastos Ruta<br><span class="text-danger">'.Utilidades::monto($monto_gastos).'</span></div>
						<div class="col-sm-3 border p-3 mb-1 bg-white rounded h4">Resto <br><span class="text-dark">'.Utilidades::monto($sub_total).'</span></div>
						<div class="col-sm-2 p-3 mb-1 bg-white h4">&nbsp;<br>
							<button class="btn btn-primary" href="'.controlador::$rutaAPP.'app/vistas/ruta/php/nuevo_gasto.php?idServicio='.$idServicio.'&idTrabajador='.$idTrabajador.'&idFlete='.$datos_flete[0]['fle_id'].'" data-fancybox="" data-type="iframe" data-preload="true" data-width="100%" data-height="1200">
	    						<i class="fas fa-dollar-sign"></i> Nuevo
	    					</button>
						</div>
					</div>';
			}

			for ($i=0; $i < count($sql); $i++) {

				$nombre_cliente = $recursos->datos_clientes($sql[$i]['serv_cliente']);
				$tipo_pago      = $recursos->tipos_pagos_x_id($sql[$i]['serv_tipo_pago']);

				$origen     	= $recursos->datos_comuna($datos_flete[0]['fle_origen']);
				$destino    	= $recursos->datos_comuna($datos_flete[0]['fle_destino']);

				$mostrar .= '
					<div class="row mt-3">
						<div class="col p-2 rounded table-responsive" id="listar_productos">
							<table width="100%">
								<tr>
									<td>
										<h3><span class="fas fa-dollar-sign text-primary"></span> Gastos Ida: <span class="text-danger">'.$origen[0]['nombre'].'</span>.</h3>
									</td>
								</tr>
							</table>
							'.$finanzas->listado_gastos_ruta(0, 0, $idServicio, $idTrabajador, 1).'
							<table width="100%">
								<tr>
									<td>
										<h3><span class="fas fa-dollar-sign text-primary"></span> Gastos Retorno: <span class="text-danger">'.$destino[0]['nombre'].'</span>.</h3>
									</td>
								</tr>
							</table>
							'.$finanzas->listado_gastos_ruta(0, 0, $idServicio, $idTrabajador, 2).'				
						</div>
					</div>';
			}

			return $mostrar;
		}

		public function grabar_hoja_ruta($monto_inicial, $fecha_hoja, $descripcion, $idFlete, $idServicio, $idTrabajador){
			$sql = $this->insert_query("INSERT INTO hoja_ruta(hoja_chofer, hoja_flete, hoja_servicio, hoja_deposito, hoja_fecha, hoja_estado) 
										VALUES('$idTrabajador', '$idFlete', '$idServicio', '$monto_inicial', '$fecha_hoja', 1)");

			return $sql;
		}

		public function grabar_nuevo_gasto_ruta($tipo_gastos, $tipo_gastos_categorias, $inputNombre, $inputDescripcion, $inputFecha, $inputSucursal, $inputPrecio, $idServicio, $idTrabajador, $idFlete){
			$sql = $this->insert_query("INSERT INTO gastos_empresa(gas_categoria, gas_tipo, gas_monto, gas_fecha, gas_nombre, gas_descripcion, gas_estado, gas_sucursal, gas_servicio, gas_chofer, gas_flete) VALUES('$tipo_gastos', '$tipo_gastos_categorias', '$inputPrecio', '$inputFecha', '$inputNombre', '$inputDescripcion', 1, '$inputSucursal', '$idServicio', '$idTrabajador',' $idFlete')");

			return $sql;

		}

	   /**  FIN RUTA   **/

	} // END CLASS
?>