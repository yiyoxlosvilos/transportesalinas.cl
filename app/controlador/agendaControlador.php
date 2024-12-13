<?php
	require_once __dir__."/../modelo/obtener_datos.php";
	require_once __dir__."/../controlador/utilidadesControlador.php";
	require_once __dir__."/../controlador/recursosControlador.php";
	require_once __dir__."/../controlador/bodegaControlador.php";

	class Agenda extends GetDatos {

		public function __construct(){
			parent::__construct();
	    }

	    public function grabar_bitacora($idProducto, $inputValor, $inputGuia, $inputEdp, $inputOrigen, $inputDestino, $inputFecha, $inputArribo, $inputTrabajador, $inputRampla, $inputMontoEstadia, $inputGlosa, $inputCoordinador, $inputDescarga, $inputCliente){
			$hoy 		= Utilidades::fecha_hoy();

			$this->insert_query("INSERT INTO bitacora(fle_producto, fle_valor, fle_guia, fle_edp, fle_origen, fle_destino, fle_carga, fle_arribo, fle_chofer, fle_rampla, fle_estadia, fle_coordinador, fle_glosa, fle_creacion, fle_estado, fle_descarga, fle_cliente) 
										VALUES('$idProducto', '$inputValor', '$inputGuia', '$inputEdp', '$inputOrigen', '$inputDestino', '$inputFecha', '$inputArribo', ' $inputTrabajador', '$inputRampla','$inputMontoEstadia','$inputCoordinador', '$inputGlosa', '$hoy', 1, '$inputDescarga', '$inputCliente')");

			return json_encode("realizado");
		}

		public function cambiar_Estado($idAgenda, $estado){
			$this->update_query("UPDATE bitacora SET fle_estado = $estado WHERE fle_id = $idAgenda");

			return json_encode("realizado");
		}

		public function traer_listado_agendas($mes, $ano, $clientes){
			$recursos   = new Recursos();

			$desde      = $ano.'-'.$mes.'-01';
	    	$ultimo_dia = date("t", strtotime($desde));
	    	$hasta  	= $ano.'-'.$mes.'-'.$ultimo_dia;
	    	$script 	= "";
	    	if($clientes > 0){
	    		$script .= " AND fle_cliente = '$clientes'";
	    	}

			$sql     	= $this->selectQuery("SELECT * FROM bitacora
										   	  WHERE  		fle_carga 	BETWEEN '$desde' AND '$hasta'
										   	  AND    		fle_estado  != 3
										   	  $script");

			$html    = '<table width="100%" cellspacing="3" class="table table-hover table-responsive shadow" id="maquinarias">
							<thead>
							<tr class="table-info">
								<th align="left">Cliente</th>
								<th align="left">Conductor</th>
								<th align="left" width="150px">Fecha</th>
								<th align="left">Tracto</th>
								<th align="left">Rampla</th>
								<th align="left">Origen</th>
								<th align="left">Destino</th>
								<th align="left">N&deg;&nbsp;Guia</th>
								<th align="left">OC/EDP</th>
								<th align="left">Tarifa&nbsp;Flete</th>
								<th align="left">Estadia</th>
								<th align="left">Coordinador</th>
								<th align="left">Factura</th>
								<th align="left">Estado</th>
								<th align="left">&nbsp;</th>
							</tr>
							</thead>
							<tbody>';

			

			for ($i=0; $i < count($sql); $i++) {

				$producto     = $recursos->datos_productos($sql[$i]['fle_producto']);
				$rampla       = $recursos->datos_productos($sql[$i]['fle_rampla']);
				$trabajador   = $recursos->datos_trabajador($sql[$i]['fle_chofer']);
				$origen       = $recursos->datos_comuna($sql[$i]['fle_origen']);
				$destino      = $recursos->datos_comuna($sql[$i]['fle_destino']);
				$datos_clientes   = $recursos->datos_clientes($sql[$i]['fle_cliente']);

				$explorar_edp = explode("-", $sql[$i]['fle_guia']);
				$explorar_guia= explode("-", $sql[$i]['fle_edp']);

				$ocedp 		  = '';
				$guias 		  = '';

				if(count($explorar_edp) >= 1){
					$ocedp .= '<ul>';
					for ($j=0; $j < count($explorar_edp); $j++) { 
						$ocedp .= '<li>'.$explorar_edp[$j].'</li>';
					}
					$ocedp .= '</ul>';
				}

				if(count($explorar_guia) >= 1){
					$guias .= '<ul>';
					for ($k=0; $k < count($explorar_guia); $k++) { 
						$guias .= '<li>'.$explorar_guia[$k].'</li>';
					}
					$guias .= '</ul>';
				}

				$html  .= '<tr>
								<td>'.$datos_clientes[0]['cli_nombre'].'</td>
								<td>'.Utilidades::matar_espacio($trabajador[0]['tra_nombre']).'</td>
								<td>
									<b class="text-primary">Cargu&iacute;o:&nbsp;</b><span class="text-primary">'.Utilidades::arreglo_fecha3($sql[$i]['fle_carga']).'</span><br>
									<b class="text-danger">Arribo:&nbsp;</b><span class="text-danger">'.Utilidades::arreglo_fecha3($sql[$i]['fle_arribo']).'</span>
									<br>
									<b class="text-dark">Descarga:&nbsp;</b><span class="text-dark">'.Utilidades::arreglo_fecha3($sql[$i]['fle_descarga']).'</span>
								</td>
								<td><b>Camión: </b>'.Utilidades::matar_espacio($producto[0]['prod_cli_producto']).'<br><b>Patente: </b>'.$producto[0]['prod_cli_patente'].'</td>
								<td><b>Rampla: </b>'.Utilidades::matar_espacio($rampla[0]['prod_cli_producto']).'<br><b>Patente: </b>'.$rampla[0]['prod_cli_patente'].'</td>
								<td>'.Utilidades::matar_espacio($origen[0]['nombre']).'</td>
								<td>'.Utilidades::matar_espacio($destino[0]['nombre']).'</td>
								<td>'.$ocedp.'</td>
								<td>'.$guias.'</td>
								<td align="left">'.Utilidades::monto3($sql[$i]['fle_valor']).'</td>
								<td align="left">'.Utilidades::monto3($sql[$i]['fle_estadia']).'</td>
								<td align="left">'.Utilidades::matar_espacio($sql[$i]['fle_coordinador']).'</td>
								<td align="left"></td>
								<td align="left">'.Utilidades::tipos_estado_agenda($sql[$i]['fle_estado']).'</td>
								<td>
									<i class="far fa-eye text-primary ver" href="'.controlador::$rutaAPP.'app/vistas/bitacora/php/panel_agenda.php?idAgenda='.$sql[$i]['fle_id'].'" data-fancybox="" data-type="iframe" data-preload="true" data-width="100%" data-height="1200"></i>
								</td>
							</tr>';
				
			}

			$html  .= '</tbody></table>';

			return $html;
		}

		public function traer_editar_agenda($idAgenda){
			$html         = '';
			$bodega 	  = new Bodega();
			$recursos 	  = new Recursos();
			$datos_agenda = $recursos->datos_agenda($idAgenda);

			for ($i=0; $i < count($datos_agenda); $i++) { 
				$html .= '<div class="row shadow-sm">
					        <div class="col-sm-6 p-3  bg-white ">
					            <h6>Tracto:</h6>
					            <span class="text-dark">
					                '.$bodega->select_productos_multiple(1, $datos_agenda[$i]['fle_producto']).'
					            </span>
					        </div>
					        <div class="col-sm-6 p-3  bg-white ">
					            <h6>Cliente:</h6>
					            <span class="text-dark">
					            '.$recursos->select_clientes($datos_agenda[$i]['fle_cliente']).'
					            </span>
					        </div>
					        <div class="col-sm-6 p-3  bg-white ">
					            <h6>Valor:</h6>
					            <span class="text-dark">
					                <input type="text" class="form-control shadow" id="inputValor" placeholder="Valor" autocomplete="off" value="'.$datos_agenda[$i]['fle_valor'].'">
					            </span>
					        </div>
					        <div class="col-sm-6 p-3  bg-white ">
					            <h6>N&deg; Guia/as:<span class="text-danger">Separar guias con - </span></h6>
					            <span class="text-dark">
					                <input type="text" class="form-control shadow" id="inputGuia" placeholder="N&deg; Guia" autocomplete="off" value="'.$datos_agenda[$i]['fle_guia'].'">
					            </span>
					        </div>
					        <div class="col-sm-6 p-3  bg-white ">
					            <h6>OC/EDP:<span class="text-danger">Separar OC/EDP con - </span></h6>
					            <span class="text-dark">
					                <input type="text" class="form-control shadow" id="inputEdp" placeholder="N&deg; Guia" autocomplete="off" value="'.$datos_agenda[$i]['fle_edp'].'">
					            </span>
					        </div>
					        <div class="col-sm-6 p-3  bg-white ">
					            <h6>Origen:</h6>
					            <span class="text-dark">
					                '.$recursos->seleccionar_localidad($datos_agenda[$i]['fle_origen'], 'inputOrigen').'
					            </span>
					        </div>
					        <div class="col-sm-6 p-3  bg-white ">
					            <h6>Destino:</h6>
					            <span class="text-dark">
					            	'.$recursos->seleccionar_localidad($datos_agenda[$i]['fle_destino'], 'inputDestino').'
					            </span>
					        </div>
					        <div class="col-sm-6 p-3  bg-white ">
					            <h6>Fecha:</h6>
					            <span class="text-dark">
					                <input type="date" class="form-control shadow" id="inputFecha" value="'.$datos_agenda[$i]['fle_carga'].'" autocomplete="off" >
					            </span>
					        </div>
					        <div class="col-sm-6 p-3  bg-white ">
					            <h6>Fecha Arribo:</h6>
					            <span class="text-dark">
					                <input type="date" class="form-control shadow" id="inputArribo" value="'.$datos_agenda[$i]['fle_arribo'].'" autocomplete="off" >
					            </span>
					        </div>
					        <div class="col-sm-6 p-3  bg-white ">
					            <h6>Fecha de Descarga:</h6>
					            <span class="text-dark">
					                <input type="date" class="form-control shadow" id="inputDescarga" value="'.$datos_agenda[$i]['fle_arribo'].'" autocomplete="off" >
					            </span>
					        </div>
					        <div class="col-sm-4 p-3  bg-white ">
					            <h6>Chofer:</h6>
					            <span class="text-dark">
					                '.$recursos->seleccionar_trabajadores($datos_agenda[$i]['fle_chofer']).'
					            </span>
					        </div>
					        <div class="col-sm-4 p-3  bg-white ">
					            <h6>Semirremolque ?:</h6>
					            <div class="row">
					                <span class="col">
					                    <select class="form-control shadow" id="inputRemolque" onchange="semirremolque()">
					                        <option value="0">NO</option>
					                        <option value="1">SI</option>
					                    </select>
					                </span>
					                <span class="col"  id="semirremolque">
					                   '.$recursos->seleccionar_productos_general(2, $datos_agenda[$i]['fle_rampla']).'
					                </span>
					            </div>
					        </div>
					        <div class="col-sm-4 p-3  bg-white ">
					            <h6>Estadia ?:</h6>
					            <div class="row">
					                <span class="col">
					                    <select class="form-control shadow" id="inputEstadia" onchange="estadia()">
					                        <option value="0">NO</option>
					                        <option value="1">SI</option>
					                    </select>
					                </span>
					                <span class="col"   id="estadia">
					                    <input type="text" class="form-control shadow" id="inputMontoEstadia" placeholder="Monto Estadia" autocomplete="off" value="'.$datos_agenda[$i]['fle_estadia'].'">
					                </span>
					            </div>
					        </div>
					        <div class="col-sm-6 p-3  bg-white ">
					            <h6>Coordinador:</h6>
					            <span class="text-dark">
					                 <textarea class="form-control shadow" id="inputCoordinador" placeholder="Coordinador" row="5">'.$datos_agenda[$i]['fle_coordinador'].'</textarea>
					            </span>
					        </div>
					        <div class="col-sm-6 p-3  bg-white ">
					            <h6>Descripción del Trabajo:</h6>
					            <span class="text-dark">
					                <textarea class="form-control shadow" id="inputGlosa" placeholder="Glosa" row="5">'.$datos_agenda[$i]['fle_glosa'].'</textarea>
					            </span>
					        </div>
					        <table class="table border rounded table-striped" align="center" cellpadding="0" cellspacing="0">
					            <tr>
					                <th colspan="2">
					                    <div class="row">
					                        <div class="col">
					                            <button type="button" id="grabar" class="btn btn-success form-control shadow" onclick="editar_bitacora('.$datos_agenda[$i]['fle_id'].')">Editar&nbsp;Agenda&nbsp;<i class="fas fa-truck-moving text-dark"></i></button>
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

			return $html;
		}

		public function editar_bitacora($idAgenda, $idProducto, $inputValor, $inputGuia, $inputEdp, $inputOrigen, $inputDestino, $inputFecha, $inputArribo, $inputTrabajador, $inputRampla, $inputMontoEstadia, $inputGlosa, $inputCoordinador, $inputDescarga, $inputCliente){
			$hoy 		= Utilidades::fecha_hoy();

			$this->update_query("UPDATE bitacora
								 SET 	fle_producto  	= '$idProducto', 
								 		fle_valor  		= '$inputValor', 
								 		fle_guia  		= '$inputGuia', 
								 		fle_edp  		= '$inputEdp', 
								 		fle_origen  	= '$inputOrigen', 
								 		fle_destino  	= '$inputDestino', 
								 		fle_carga  		= '$inputFecha', 
								 		fle_arribo  	= '$inputArribo', 
								 		fle_chofer  	= '$inputTrabajador', 
								 		fle_rampla  	= '$inputRampla', 
								 		fle_estadia  	= '$inputMontoEstadia', 
								 		fle_coordinador = '$inputCoordinador', 
								 		fle_glosa  		= '$inputGlosa', 
								 		fle_descarga    = '$inputDescarga',
								 		fle_cliente     = '$inputCliente'
								 WHERE  fle_id 			= $idAgenda");

			return json_encode("realizado");
		}

		public function grabar_insertar_documento_agenda($nombre, $idAgenda, $inputTitulo, $inputCliente, $inputDescripcion){
			$hoy 	= Utilidades::fecha_hoy();
			$this->insert_query("INSERT INTO documentos_bitacora(doc_folio, doc_coti, doc_cliente, doc_ruta, doc_fecha, doc_estado) 
					   					   VALUES('$inputTitulo', '$idAgenda', '$inputCliente', '$nombre', '$hoy', 1)");
		}

		public function traer_documentos_cotizacion($idAgenda){
			$html     = '';
	    	$recursos = new Recursos();
	    	$sql      = $this->selectQuery("SELECT * FROM documentos_bitacora
					    				    WHERE  		  doc_coti = $idAgenda");

	    	if(count($sql) > 0){
	    		$html    .= '<table class="table table-striped">
								<thead>
									<tr>
										<th>Folio</th>
										<th>Cliente</th>
										<th>&nbsp;</th>
										<th>&nbsp;</th>
									</tr>
								</thead>
								<tbody>';
				//doc_id, doc_titulo, doc_ruta, doc_fin_documento
				for ($i=0; $i < count($sql); $i++) {
					$html  .= '
							<tr class="cambiazo">
								<td>'.$sql[$i]['doc_folio'].'</td>
								<td>'.$sql[$i]['doc_cliente'].'</td>
								<td align="center">
									<button class="btn btn-primary" type="button" href="'.controlador::$rutaAPP.'app/repositorio/documento_edp/'.$sql[$i]['doc_ruta'].'" data-fancybox data-type="iframe" data-preload="true" data-width="100%" data-height="1200"><i class="bi bi-eye"></i></button>
								</td>
								<td align="center">
									<button class="btn btn-danger" type="button" onclick="quitar_documento_agenda('.$sql[$i]['doc_id'].')"><i class="bi-trash"></i></button>
								</td>
							</tr>';
				}

				$html .= '</tbody>
						</table>';
	    	}			

			return $html;
		}

		public function quitar_documento_agenda($idDocumento){
			$recursos 	  = new Recursos();
			$datos_agenda = $recursos->datos_agenda_anexos_id($idDocumento);

			unlink(controlador::$rutaAPP.'app/repositorio/documento_edp/'.$datos_agenda[0]['doc_ruta']);

			$this->delete_query("DELETE FROM documentos_bitacora WHERE doc_id = $idDocumento");

			
		}
	    
	   /**  FIN CENTRO COSTO  **/

	} // END CLASS
?>