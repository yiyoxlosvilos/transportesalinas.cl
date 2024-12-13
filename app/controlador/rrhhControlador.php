<?php
	require_once __dir__."/../modelo/obtener_datos.php";
	require_once __dir__."/../controlador/utilidadesControlador.php";
	require_once __dir__."/../controlador/productosControlador.php";
	require_once __dir__."/../controlador/recursosControlador.php";

	class Rrhh extends GetDatos {

		public function __construct(){
			parent::__construct();
	    }

	    public function traer_trabajadores(){
	    	$neto_acumulado = 0;
	    	$productos      = new Productos();
	    	$html = '
	    			 <div class="d-flex flex-wrap align-items-center">
                        <h3><i class="bi bi-people-fill"></i>&nbsp;&nbsp;&nbsp;Administrador de trabajadores.</h3>
                        <div class="ms-auto">
                            <button class="btn btn-success" href="'.controlador::$rutaAPP.'app/vistas/rrhh/php/nuevo_trabajador.php" data-fancybox data-type="iframe" data-preload="true" data-width="100%" data-height="1200">Nuevo&nbsp;&nbsp;&nbsp;<i class="bi bi-person-plus-fill"></i></button>
                        </div>
                    </div>
	    			 <hr class="mt-2 mb-3"/>
	    			 <div class="row overflow-auto " id="filtro_productos">
				        '.$this->listar_trabajadores(0).'
				      </div>';

			$html .= '';

			return $html;
	    }

	    public function listar_trabajadores($idEstado){
	    	$recursos = new Recursos();

	    	$sql  	  = $this->selectQuery("SELECT * FROM trabajadores
	    									WHERE         tra_estado = 1
				   							ORDER BY   	  tra_nombre ASC");

	    	$html 	  = '<table id="productos_list" class="table table-hover shadow-lg animate__animated animate__fadeInLeft" style="width:100%">
		    			   <thead>
								<tr class="table-info">
									<th>Nombre</th>
									<th>Cargo</th>
									<th>Contrato</th>
									<th>Empresa</th>
									<th>Estado</th>
									<th>&nbsp;</th>
									<th>&nbsp;</th>
								</tr>
							</thead>
							<tbody>';

			for ($i=0; $i < count($sql); $i++) {
				$tipo_contrato 	 = $recursos->nombre_tipo_contrato($sql[$i]['tra_tipo_contrato']);
				$estado_contrato = $recursos->nombre_estado_contrato($sql[$i]['tra_estado']);
				$datos_empresa   = $recursos->datos_empresa_id($sql[$i]['tra_empresa']);
				$html .= '<tr>
							<td>'.strtoupper($sql[$i]['tra_nombre']).'</td>
							<td>'.strtoupper($sql[$i]['tra_cargo']).'</td>
							<td>'.$tipo_contrato[0]['tip_nombre'].'</td>
							<td>'.$datos_empresa[0]['emp_razonsocial'].'</td>
							<td>'.$estado_contrato[0]['tip_nombre'].'</td>
							<td>
								<i class="bi bi-eye text-primary cursor" href="'.controlador::$rutaAPP.'app/vistas/rrhh/php/panel_trabajador.php?idTrabajador='.$sql[$i]['tra_id'].'" data-fancybox data-type="iframe" data-preload="true" data-width="100%" data-height="1200"></i>
							</td>
							<td>
								<i class="bi bi-journal-text text-dark cursor" href="'.controlador::$rutaAPP.'app/vistas/rrhh/php/ficha_trabajador.php?idTrabajador='.$sql[$i]['tra_id'].'" data-fancybox data-type="iframe" data-preload="true" data-width="100%" data-height="1200"></i>
							</td>
						 </tr>';
			}

			$html .= '<tbody>
					</table>';

			return $html;
	    }


	    public function listar_trabajadores_sin_docu($idEstado){
	    	$recursos = new Recursos();

	    	$sql  	  = $this->selectQuery("SELECT * FROM trabajadores
	    									WHERE         tra_estado = 1
				   							ORDER BY   	  tra_nombre ASC");

	    	$html 	  = '<table id="productos_list" class="table table-hover animate__animated animate__fadeInLeft" style="width:100%">
		    			   <thead>
								<tr class="table-info">
									<th>Nombre</th>
									<th>Rut</th>
									<th>Cargo</th>
									<th>Contrato</th>
									<th>Empresa</th>
									<th>&nbsp;</th>
								</tr>
							</thead>
							<tbody>';

			for ($i=0; $i < count($sql); $i++) {
				$tipo_contrato 	 = $recursos->nombre_tipo_contrato($sql[$i]['tra_tipo_contrato']);
				$estado_contrato = $recursos->nombre_estado_contrato($sql[$i]['tra_estado']);
				$datos_empresa   = $recursos->datos_empresa_id($sql[$i]['tra_empresa']);
				$dato_documento  = $recursos->dato_documento_trabajador($sql[$i]['tra_id']);


				if(count($dato_documento) == 0){
					$html .= '<tr>
							<td>'.strtoupper($sql[$i]['tra_nombre']).'</td>
							<td>'.Utilidades::rut($sql[$i]['tra_rut']).'</td>
							<td>'.strtoupper($sql[$i]['tra_cargo']).'</td>
							<td>'.$tipo_contrato[0]['tip_nombre'].'</td>
							<td>'.$datos_empresa[0]['emp_razonsocial'].'</td>
							<td>
								<i class="bi bi-card-checklist text-primary cursor" href="'.controlador::$rutaAPP.'app/vistas/rrhh/php/panel_trabajador.php?idTrabajador='.$sql[$i]['tra_id'].'" data-fancybox data-type="iframe" data-preload="true" data-width="100%" data-height="1200"></i>
							</td>
						 </tr>';
				}
			}

			$html .= '<tbody>
					</table>';

			return $html;
	    }

	    public function card_info_trabajador($idTrabajador){

	    	$recursos = new Recursos();
	    	$html     = '';

			$sql      = $this->selectQuery("SELECT * FROM trabajadores
										    WHERE 		  tra_id = $idTrabajador");

			for ($i=0; $i < count($sql); $i++) {

				$tipo_contrato 	 = $recursos->nombre_tipo_contrato($sql[$i]['tra_tipo_contrato']);
				$estado_contrato = $recursos->nombre_estado_contrato($sql[$i]['tra_estado']);

				$html  .=  '<table class="table table-striped">
				 			<thead>
								<tr>
									<th width="50%" align="left">Nombre:</th>
									<th width="50%" align="left">Rut:</th>
								</tr>
								<tr>
									<td align="left">'.$sql[$i]['tra_nombre'].'</td>
									<td align="left">'.$sql[$i]['tra_rut'].'</td>
								</tr>
								<tr>
									<th width="50%" align="left">Sueldo Base:</th>
									<th width="50%" align="left">Cargo:</th>
								</tr>
								<tr>
									<td align="left">'.Utilidades::monto3($sql[$i]['tra_sueldo_base']).'</td>
									<td align="left">'.$sql[$i]['tra_cargo'].'</td>
								</tr>
								<tr>
									<th width="50%" align="left">Tipo Contrato:</th>
									<th width="50%" align="left">Fecha Ingreso:</th>
								</tr>
								<tr>
									<td align="left">'.$tipo_contrato[0]['tip_nombre'].'</td>
									<td align="left">'.Utilidades::arreglo_fecha2($sql[$i]['tra_contratacion']).'</td>
								</tr>
								<tr>
									<th align="left">Estado Contrato:</th>
									<td align="left">'.$estado_contrato[0]['tip_nombre'].'</td>
								</tr>
								<tr>
									<td colspan="2">
										<button class="btn btn-primary" onclick="traer_editar_trabajador('.$sql[$i]['tra_id'].')">Editar&nbsp;&nbsp;&nbsp;<i class="bi bi-pencil-square"></i></button>
									</td>
								</tr>
								</thead>
							</table>';
			}

			return $html;	    	
	    }

	    public function traer_documentos_asociados($idTrabajador){
	    	$recursos = new Recursos();
	    	$sql      = $this->selectQuery("SELECT * FROM documentos_trabajador
					    				    WHERE  		  doc_trabajador = $idTrabajador");

			$html     = '<table class="table table-striped">
							<thead>
								<tr>
									<th>Titulo</th>
									<th>Fecha T&eacute;rmino</th>
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
							<td>'.$sql[$i]['doc_fin_documento'].'</td>
							<td align="center">
								<button class="btn btn-primary" type="button" href="'.controlador::$rutaAPP.'app/repositorio/documento_trabajador/'.$sql[$i]['doc_ruta'].'" data-fancybox data-type="iframe" data-preload="true" data-width="100%" data-height="1200"><i class="bi bi-eye"></i></button>
							</td>
							<td align="center">
								<button class="btn btn-danger" type="button" onclick="quitar_documento_trabajador('.$sql[$i]['doc_id'].')"><i class="bi-trash"></i></button>
							</td>
						</tr>';
			}

			$html .= '</tbody>
					</table>';

			return $html;
		}

		public function grabar_trabajador($inputNombre, $inputRut, $inputTelefono, $inputEmail, $inputSueldo, $inputCargo, $inputEmpresa, $inputTipoContrato, $inputIngreso, $inputFin = null){

			$this->insert_query("INSERT INTO trabajadores(tra_nombre, tra_fono, tra_email, tra_rut, tra_sueldo_base, tra_cargo, tra_tipo_contrato, tra_contratacion, tra_fin_contrato, tra_empresa, tra_estado) VALUES ('$inputNombre', '$inputTelefono', '$inputEmail', '$inputRut', '$inputSueldo', '$inputCargo', '$inputTipoContrato', '$inputIngreso', '$inputFin', '$inputEmpresa', 1)");

			return TRUE;
		}

		public function traer_editar_trabajador($idTrabajador){
			$recursos = new Recursos();
	    	$html     = '';

			$sql      = $this->selectQuery("SELECT * FROM trabajadores
										    WHERE 		  tra_id = $idTrabajador");

			for ($i=0; $i < count($sql); $i++) {
				$finanzas      = 'finanzas';
				$tipo_contrato = 'comprobar_contrato';

				if($sql[$i]['tra_tipo_contrato'] == 1){
					$style     = 'style="display:none;"';
				}else{
					$style     = '';
				}

				$html  .=  '<div class="row mb-4">
							  <p align="left" class="text-info font-weight-light h3">Editar Trabajador</p>
							  <hr class="mt-2 mb-3"/>
							    <div class="container mb-4">
							      <div class="row">
							        <div class="col-lg-5 mb-2">
							          <label for="inputNombre"><b>Nombre</b></label>
							          <input type="text" class="form-control shadow" id="inputNombre" placeholder="Nombre" autocomplete="off" value="'.$sql[$i]['tra_nombre'].'">
							        </div>
							        <div class="col-lg-5 mb-2">
							            <label for="inputNombre"><b>Rut</b>&nbsp;&nbsp;&nbsp;<span id="validar_rut"></span></label>
							            <input type="text" class="form-control shadow" id="inputRut" placeholder="Rut" autocomplete="off" onchange="validar_rut('.$fianzas.')" value="'.$sql[$i]['tra_rut'].'">
							        </div>
							        <div class="col-lg-5 mb-2">
							            <label for="inputTelefono"><b>Tel&eacute;fono</b>&nbsp;&nbsp;&nbsp;<span id="validar_rut"></span></label>
							            <input type="text" class="form-control shadow" id="inputTelefono" placeholder="Telefono" autocomplete="off" value="'.$sql[$i]['tra_fono'].'">
							        </div>
							        <div class="col-lg-5 mb-2">
							            <label for="inputEmail"><b>E-Mail</b>&nbsp;&nbsp;&nbsp;<span id="validar_rut"></span></label>
							            <input type="text" class="form-control shadow" id="inputEmail" placeholder="E-Mail" autocomplete="off" value="'.$sql[$i]['tra_email'].'">
							        </div>
							        <div class="col-lg-5 mb-2">
							          <label for="inputSueldo"><b>Sueldo Base</b></label>
							            <input type="number" class="form-control shadow" id="inputSueldo" placeholder="Escribir Sueldo" value="'.$sql[$i]['tra_sueldo_base'].'">
							        </div>
							        <div class="col-lg-5 mb-2">
							          <label for="inputCargo"><b>Cargo</b></label>
							          <input type="text" class="form-control shadow" id="inputCargo" placeholder="Escribir Cargo" autocomplete="off" value="'.$sql[$i]['tra_cargo'].'">
							        </div>
							        <div class="col-lg-5 mb-2">
							          <label for="inputEmpresa"><b>Empresa</b></label>
							            '.$recursos->select_empresas('', $sql[$i]['tra_empresa']).'
							        </div>
							        <div class="col-lg-5 mb-2">
							          <label for="inputPrestacion"><b>Proyecto/Servicio</b></label>
							            '.$recursos->select_proyecto_servicio('',  $sql[$i]['tra_proyecto_servicio']).'
							        </div>
							        <div class="col-lg-5 mb-2">
							          <label for="inputCategoria"><b>Tipo Contrato</b></label>
							            '.$recursos->select_tipo_contrato($tipo_contrato, $sql[$i]['tra_tipo_contrato']).'
							        </div>
							        <div class="col-lg-5 mb-2">
							          <label for="inputIngreso"><b>Ingreso</b></label>
							          <input type="date" class="form-control shadow" id="inputIngreso" placeholder="Nombre" autocomplete="off" value="'.$sql[$i]['tra_contratacion'].'">
							        </div>
							        <div class="col-lg-5 mb-2" id="fin_contrato" '.$style.'>
							          <label for="inputFin"><b>Fin Contrato</b></label>
							          <input type="date" class="form-control shadow" id="inputFin" placeholder="Nombre" autocomplete="off" value="'.$sql[$i]['tra_fin_contrato'].'">
							        </div>
							        <div class="col-lg-5 mb-2">
							          <label for="inputTipo">&nbsp;</label>
							          <button type="button" id="grabar" class="btn btn-primary form-control shadow" onclick="editar_trabajador('.$sql[$i]['tra_id'].')">Grabar <i class="bi bi-save"></i></button>
							        </div>
							      </div>
							    </div>
							</div>';
			}

			return $html;
		}

		public function editar_trabajador($inputNombre, $inputRut, $inputTelefono, $inputEmail, $inputSueldo, $inputCargo, $inputEmpresa, $inputPrestacion, $inputTipoContrato, $inputIngreso, $inputFin, $idTrabajador){
			$grabar = $this->update_query("UPDATE trabajadores
										   SET    tra_nombre 		    = '$inputNombre', 
										   		  tra_rut 			    = '$inputRut', 
										   		  tra_sueldo_base 	    = '$inputSueldo', 
										   		  tra_cargo 		    = '$inputCargo', 
										   		  tra_tipo_contrato     = '$inputTipoContrato', 
										   		  tra_contratacion 	    = '$inputIngreso', 
										   		  tra_fin_contrato      = '$inputFin',
												  tra_fono 			    = '$inputTelefono', 
												  tra_email 		    = '$inputEmail', 
												  tra_empresa 		    = '$inputEmpresa', 
												  tra_proyecto_servicio = '$inputPrestacion'
										   WHERE  tra_id 			= $idTrabajador");

			if($grabar){
				return TRUE;
			}else{
				return FALSE;
			}
		}

		public function grabar_insertar_documento($nombre, $inputTitulo, $idTrabajador){

			$grabar = $this->insert_query("INSERT INTO documentos_trabajador(doc_trabajador, doc_titulo, doc_ruta, doc_estado) 
					   VALUES('$idTrabajador', '$inputTitulo', '$nombre', 1)");

			if($grabar){
				return TRUE;
			}else{
				return FALSE;
			}
		}

		public function quitar_documento_trabajador($idDocu){
			$grabar = $this->delete_query("DELETE FROM documentos_trabajador
					   					   WHERE       doc_id = $idDocu");

			if($grabar){
				return TRUE;
			}else{
				return FALSE;
			}
		}

		public function ficha_trabajador($idTrabajador){
			$recursos = new Recursos();
	    	$html     = '';

			$sql      = $this->selectQuery("SELECT * FROM trabajadores
										    WHERE 		  tra_id = $idTrabajador");

			for ($i=0; $i < count($sql); $i++) {
				$finanzas      = 'finanzas';
				$tipo_contrato = 'comprobar_contrato';

				$tipo_contrato 	 = $recursos->nombre_tipo_contrato($sql[$i]['tra_tipo_contrato']);
				$estado_contrato = $recursos->nombre_estado_contrato($sql[$i]['tra_estado']);

				if($sql[$i]['tra_tipo_contrato'] == 1){
					$style     = 'style="display:none;"';
				}else{
					$style     = '';
				}

				$html  .=  '<div class="row">
					            <div class="col-md-6">
					                <div class="row">
					                    <div class="col-12 bg-white p-0 px-3 py-3 mb-3">
					                        <div class="d-flex flex-column align-items-center">
					                            <p class="fw-bold h3 mt-3 text-primary">'.ucwords(strtolower($sql[$i]['tra_nombre'])).'</p>
					                            <p class="text-muted">'.ucwords(strtolower($sql[$i]['tra_cargo'])).'</p>
					                        </div>
					                    </div>
					                    <div class="col-12 bg-white p-0 px-2 pb-3 mb-3">
					                        <h5 class="text-dark"><i class="bi bi-sun-fill text-warning"></i>&nbsp;&nbsp;&nbsp;<b class="text-info">14</b> Dias</h5>
					                        <div class="progress mb-3" style="height: 5px">
					                            <div class="progress-bar bg-success" role="progressbar" style="width: 100%"
					                                aria-valuenow="72" aria-valuemin="0" aria-valuemax="100"></div>
					                        </div>
					                    </div>
					                </div>
					            </div>
					            <div class="col-md-6">
					                <div class="row">
					                    <div class="col-12 bg-white px-3 mb-3 pb-3">
					                        <div class="d-flex align-items-center justify-content-between border-bottom">
					                            <p class="py-2">Sueldo</p>
					                            <p class="py-2 text-muted">'.Utilidades::monto3($sql[$i]['tra_sueldo_base']).'</p>
					                        </div>
					                        <div class="d-flex align-items-center justify-content-between border-bottom">
					                            <p class="py-2">Rut</p>
					                            <p class="py-2 text-muted">'.$sql[$i]['tra_rut'].'</p>
					                        </div>
					                        <div class="d-flex align-items-center justify-content-between border-bottom">
					                            <p class="py-2">E-mail</p>
					                            <p class="py-2 text-muted">'.$sql[$i]['tra_email'].'</p>
					                        </div>
					                        <div class="d-flex align-items-center justify-content-between border-bottom">
					                            <p class="py-2">Fono</p>
					                            <p class="py-2 text-muted">'.$sql[$i]['tra_fono'].'</p>
					                        </div>
					                        <div class="d-flex align-items-center justify-content-between border-bottom">
					                            <p class="py-2">Tipo Contrato</p>
					                            <p class="py-2 text-muted">'.$tipo_contrato[0]['tip_nombre'].'</p>
					                        </div>
					                        <div class="d-flex align-items-center justify-content-between border-bottom">
					                            <p class="py-2">Fecha Ingreso</p>
					                            <p class="py-2 text-muted">'.Utilidades::arreglo_fecha2($sql[$i]['tra_contratacion']).'</p>
					                        </div>
					                        <div class="d-flex align-items-center justify-content-between border-bottom" '.$style.'>
					                            <p class="py-2">Fecha Egreso</p>
					                            <p class="py-2 text-muted">'.Utilidades::arreglo_fecha2($sql[$i]['tra_fin_contrato']).'</p>
					                        </div>
					                        <div class="d-flex align-items-center justify-content-between border-bottom">
					                            <p class="py-2">Estado Contrato</p>
					                            <p class="py-2 text-muted">'.$estado_contrato[0]['tip_nombre'].'</p>
					                        </div>
					                    </div>
					                </div>
					            </div>
					            <hr class="mb-1"/>
					            <div class="col-12 bg-white px-3 pb-2">'.$this->liquidaciones_trabajador($idTrabajador).'</div>
					        </div>';
			}

			return $html;
		}

		public function liquidaciones_trabajador($idTrabajador){
			$recursos = new Recursos();
	    	$html     = '';

			$sql      = $this->selectQuery("SELECT * FROM liquidaciones_sueldo
					   						WHERE    	  liquid_trabajador = $idTrabajador");

			$html    .= '<table width="100%" class="table table-striped" id="liquidaciones_list" align="center">
							<thead>
								<tr>
									<th align="left">&nbsp;</th>
									<th align="left">Fecha</th>
									<th align="left">Dias Trabajados</th>
									<th align="left">Sueldo L&iacute;quido</th>
									<th align="left">&nbsp;</th>
								</tr>
							</thead>
							<tbody>';
			for ($i=0; $i < count($sql); $i++) {
				$html   .= '<tr>
									<td align="left">&nbsp;</td>
									<td align="left">'.Utilidades::arreglo_fecha2($sql[$i]['liquid_fecha']).'</td>
									<td align="left">'.$sql[$i]['liquid_dias_trabajo'].'</td>
									<td align="left">'.Utilidades::monto3($sql[$i]['liquid_tot_liquido']).'</td>
									<td align="left">&nbsp;</td>
								</tr>';
			}

			$html   .= '</tbody>
					</table>';

			return $html;
		}

		public function calculo_impuesto_unico($sueldoBase){
			$recursos       = new Recursos();

			$mes            = Utilidades::fecha_mes();
			$ano            = Utilidades::fecha_ano();
			$fecha  		= $ano.'-09-01';

			$datos_recursos = $recursos->datos_parametros();
			$sueldo_factor  = ($sueldoBase/$datos_recursos[0]['par_utm']);
			$replace        = str_replace(",", ".", $sueldo_factor);

			$datos_impuestos= $recursos->rango_impuesto_unico($replace);
			$datos_rango    = $recursos->rebaja_impuesto_unico($datos_impuestos[0]['imp_id'], $fecha);
			$utm            = $datos_recursos[0]['par_utm'];

			$impuesto_unico = $datos_impuestos[0]['imp_desde'];
			$impuesto_factor= $datos_impuestos[0]['imp_factor'];

			$impuesto_pagar = ($sueldoBase*$impuesto_factor)-$datos_rango[0]['reb_rebaja'];

			if($datos_impuestos[0]['imp_desde'] >= 13.5){
				return round($impuesto_pagar);
			}else{
				return 0;
			}	
		}

		public function monto_liquidaciones($ano, $mes){
			$recursos       	= new Recursos();
			$data 			  	= 0;
			$total_liquidaciones= $recursos->datos_liquidaciones_trabajadores(1, $ano, $mes);

			for ($i=0; $i < count($total_liquidaciones); $i++) { 
				$data += $total_liquidaciones[$i]['liquid_tot_liquido'];
			}

			return $data;
		}

		public function traer_liquidaciones($ano, $mes){
			$recursos       	= new Recursos();

			$total_trabajadores = count($recursos->datos_trabajadores(1));
			$total_liquidaciones= count($recursos->datos_liquidaciones_trabajadores(1, $ano, $mes));
			$monto_liquidaciones= $this->monto_liquidaciones($ano, $mes);

			$no_generadas       = ($total_trabajadores-$total_liquidaciones);
			$porcentaje_ingreso = (($total_liquidaciones*100)/$total_trabajadores);
			$porcentaje_egreso  = (100-$porcentaje_ingreso);

	    	$html = '
	    			<div class="d-flex flex-wrap align-items-center">
                        <h3><i class="bi bi-journal-check"></i>&nbsp;&nbsp;&nbsp;Liquidaciones de sueldos: '.Utilidades::mostrar_mes($mes).' '.$ano.'.</h3>
                        <div class="ms-auto">
                        <input type="hidden" id="ano_liquidacion" name="ano_liquidacion" value="'.Utilidades::fecha_ano().'">
                            '.Utilidades::select_agrupacion_cards("mostrar_liquidaciones_sueldo", "fecha_liquidacion", $ano, $mes).'
                        </div>
                    </div>
	    			<hr class="mt-2 mb-3"/>
				    <section class="wow fadeIn animated mb-4 p-4" style="visibility: visible; animation-name: fadeIn;">
				      <div class="container mx-auto">
				        <div class="row ">
				        <!-- counter -->
				          <div class="col-md-4 bottom-margin border rounded p-2 text-center counter-section wow fadeInUp sm-margin-bottom-ten animated" data-wow-duration="300ms" style="visibility: visible; animation-duration: 300ms; animation-name: fadeInUp;">
				            <i class="bi bi-clipboard-check medium-icon text-success"></i>
				            <span id="anim-number-pizza" class="counter-number"></span>
				            <span class="timer counter alt-font appear" data-to="980" data-speed="7000">'.$total_liquidaciones.'</span>
				            <p class="counter-title text-success">Generadas</p>
				          </div>
				          <!-- end counter -->
				          <!-- counter -->
				          <div class="col-md-4 bottom-margin border rounded p-2 text-center counter-section wow fadeInUp sm-margin-bottom-ten animated" data-wow-duration="600ms" style="visibility: visible; animation-duration: 600ms; animation-name: fadeInUp;">
				            <i class="bi bi-exclamation-triangle  medium-icon text-info"></i>
				            <span class="timer counter alt-font appear" data-to="980" data-speed="7000">'.$no_generadas.'</span>
				            <span class="counter-title text-info">No Generadas</span>
				          </div>
				          <!-- end counter -->
				          <!-- counter -->
				          <div class="col-md-4 text-center border rounded p-2 counter-section wow fadeInUp animated" data-wow-duration="1200ms" style="visibility: visible; animation-duration: 1200ms; animation-name: fadeInUp;">
				            <i class="bi bi-currency-dollar medium-icon text-danger"></i>
				            <span class="timer counter alt-font appear" data-to="600" data-speed="7000">'.$monto_liquidaciones.'</span>
				            <span class="counter-title text-danger">Total Sueldos</span>
				          </div>
				          <!-- end counter -->
				        </div>
				      </div>
				    </section>
	    			<hr class="mt-2 mb-3"/>
	    			<div class="row overflow-auto " id="filtro_productos">
				        '.$this->listar_trabajadores_liquidacion($ano, $mes).'
				    </div>';

			return $html;
	    }

	    public function saber_si_hay_liquidaciones($idTrabajador, $ano, $mes){
	    	$desde 	= $ano.'-'.$mes.'-01';
	    	$hasta 	= date("Y-m-t", strtotime($desde));

			$sql    = $this->selectQuery("SELECT * FROM liquidaciones_sueldo
				   						  WHERE  		liquid_trabajador 	= $idTrabajador
				   						  AND           liquid_fecha 		BETWEEN '$desde' AND '$hasta'");

			return $sql;
		}

	    public function listar_trabajadores_liquidacion($ano, $mes){
	    	$recursos = new Recursos();

	    	$sql  	  = $this->selectQuery("SELECT * FROM trabajadores
	    									WHERE 		  tra_estado = 1
				   							ORDER BY   	  tra_nombre ASC");

	    	$html 	  = '<table id="productos_list" class="table table-hover shadow-lg" style="width:100%">
		    			   <thead>
								<tr class="table-info">
									<th>Nombre</th>
									<th>Cargo</th>
									<th>Contrato</th>
									<th>Empresa</th>
									<th>Sueldo</th>
									<th>Liquidacion</th>
								</tr>
							</thead>
							<tbody>';

			for ($i=0; $i < count($sql); $i++) {
				$tipo_contrato 	 = $recursos->nombre_tipo_contrato($sql[$i]['tra_tipo_contrato']);
				$estado_contrato = $this->saber_si_hay_liquidaciones($sql[$i]['tra_id'], $ano, $mes);
				$datos_empresa   = $recursos->datos_empresa_id($sql[$i]['tra_empresa']);

				if(count($estado_contrato) > 0){
					$estado_liquidacion = '<button class="btn btn-success" type="button" href="'.controlador::$rutaAPP.'app/vistas/rrhh/php/liquidacion_trabajador.php?accion=liquidacion_de_sueldo&idTrabajador='.$sql[$i]['tra_id'].'&print=1&fecha='.$estado_contrato[0]['liquid_fecha'].'" data-fancybox data-type="iframe" data-preload="true" data-width="100%" data-height="1200">Visualizar</button>';
				}else{
					$estado_liquidacion = '<button class="btn btn-info" type="button" href="'.controlador::$rutaAPP.'app/vistas/rrhh/php/generar_liquidacion.php?idTrabajador='.$sql[$i]['tra_id'].'" data-fancybox data-type="iframe" data-preload="true" data-width="100%" data-height="1200">Generar</button>';
				}

				$html .= '<tr>
							<td>'.strtoupper($sql[$i]['tra_nombre']).'</td>
							<td><small>'.strtoupper($sql[$i]['tra_cargo']).'</small></td>
							<td>'.$tipo_contrato[0]['tip_nombre'].'</td>
							<td>'.$datos_empresa[0]['emp_razonsocial'].'</td>
							<td>'.Utilidades::monto3($sql[$i]['tra_sueldo_base']).'</td>
							<td>'.$estado_liquidacion.'</td>
						 </tr>';
			}

			$html .= '<tbody>
					</table>';

			return $html;
	    }

	    public function generar_liquidacion_sueldo($idTrabajador, $sueldo_base, $dias_trabajado, $gratifica, $total_grati, $hrextra, $hrextra_total, $comisiones, $bonos, $colacion, $movilizacion, $afp, $total_afp, $salud, $total_salud, $isapre, $adicional_isapre, $cesantia, $apv, $anticipos, $seguro_vida, $caja_compensacion, $monto_caja_compensacion, $impuesto_unico, $haber_tot2, $haber_dsc2, $haber_liq2){
			$hoy    = Utilidades::fecha_hoy();
			$hora   = Utilidades::hora();

			$grabar = $this->insert_query("INSERT INTO liquidaciones_sueldo(liquid_trabajador, liquid_fecha, liquid_hora, liquid_sueldo_base, liquid_dias_trabajo, liquid_gratificacion, liquid_grati_monto, liquid_hr_extra, liquid_monto_hr_extra, liquid_comisiones, liquid_bonos, liquid_colacion, liquid_movilizacion, liquid_afp, liquid_monto_afp, liquid_prevision, liquid_prev_monto, liquid_isapre, liquid_adicional_isapre, liquid_cesantia, liquid_apv, liquid_anticipos, liquid_seguro_vida, liquid_caja, liquid_monto_caja, liquid_impuesto_unico, liquid_tot_haber, liquid_tot_descuento, liquid_tot_liquido, liquid_estado) 
					VALUES ('$idTrabajador', '$hoy', '$hora', '$sueldo_base', '$dias_trabajado', '$gratifica', '$total_grati', '$hrextra', '$hrextra_total', '$comisiones', '$bonos', '$colacion', '$movilizacion', '$afp', '$total_afp', '$salud', '$total_salud', '$isapre', '$adicional_isapre', '$cesantia', '$apv', '$anticipos', '$seguro_vida', '$caja_compensacion', '$monto_caja_compensacion', '$impuesto_unico', '$haber_tot2', '$haber_dsc2', '$haber_liq2', 1)");

			if($grabar){
				return TRUE;
			}else{
				return FALSE;
			}
	    }

	    public function data_finalizar_liquidacion($idTrabajador, $mes, $ano){
	    	$data  	  = '';
	    	$recursos = new Recursos();

	    	$datos    = $recursos->datos_liquidaciones_trabajador($idTrabajador, $mes, $ano);

	    	for ($i=0; $i < count($datos); $i++) { 
	    		$data .= '<div class="row shadow" style="margin-top:25px">
	    					<h3>Liquidaci&oacute;n de: <br><span class="text-success">'.$datos[$i]['tra_nombre'].'</span><br>se ha generado correctamente ahora puedes:</h3>
	    					<div class="col">
							    <button class="btn btn-info h3" type="button" href="'.controlador::$rutaAPP.'app/vistas/rrhh/php/liquidacion_trabajador.php?accion=liquidacion_de_sueldo&idTrabajador='.$idTrabajador.'&print=0&fecha='.$datos[$i]['liquid_fecha'].'"" data-fancybox data-type="iframe" data-preload="true" data-width="100%" data-height="1200">
									<i class="bi bi-file-earmark-text"></i> Ver Liquidaci&oacute;n
								</button>
							</div>
							<div class="col">
							    <button class="btn btn-success h3" type="button" href="'.controlador::$rutaAPP.'app/vistas/rrhh/php/liquidacion_trabajador.php?accion=liquidacion_de_sueldo&idTrabajador='.$idTrabajador.'&print=1&fecha='.$datos[$i]['liquid_fecha'].'"" data-fancybox data-type="iframe" data-preload="true" data-width="100%" data-height="1200">
									<i class="bi bi-printer"></i> Imprimir Liquidaci&oacute;n 
								</button>
							</div>
						</div>';
	    	}

			return $data;
	    }

	    public function liquidacion_de_sueldo($idTrabajador, $mes, $ano){
	    	$recursos 	= new Recursos();
	    	$parametros = $recursos->datos_parametros();
	    	$data 	  	= $recursos->datos_liquidaciones_trabajador($idTrabajador, $mes, $ano);
	    	$html 	  	= '';

	    	for ($i=0; $i < count($data); $i++) {
	    		$empresa    = $recursos->datos_empresa_id($data[$i]['tra_empresa']);

	    		$haberes 	 = $data[$i]['liquid_tot_haber']-($data[$i]['liquid_colacion']+$data[$i]['liquid_movilizacion']);
	    		$tributables = $haberes-($data[$i]['liquid_prev_monto']+$data[$i]['liquid_monto_afp']+$data[$i]['liquid_cesantia']);
	    		$html.= '
	    		<div class="row">
	    			<table width="80%" align="center" class="table">
						<tr>
							<td width="33.3%">
								 <table style="font-size:13px;">
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
					  <div class="col-15">
					  	<p align="center" class="h3">&nbsp;LIQUIDACIÓN REMUNERACIONES<br>'.Utilidades::mostrar_mes($mes).'</p>
					  </div>
					  <div class="col-15">
					  	<table width="90%" cellspacing="5" cellpadding="5" align="center" class="table sombraPlana2 bordes">
							<tr>
								<td width="50%">
									<table width="100%">
										<tr>
											<th>Nombre:</th>
											<td><small>'.ucfirst($data[$i]['tra_nombre']).'</small></td>
										</tr>
										<tr>
											<th>Rut:</th>
											<td><small>'.$data[$i]['tra_rut'].'</small></td>
										</tr>
										<tr>
											<th>Cargo:</th>
											<td><small>'.ucfirst($data[$i]['tra_cargo']).'</small></td>
										</tr>
										<tr>
											<th>Contrataci&oacute;n:</th>
											<td><small>'.Utilidades::arreglo_fecha2($data[$i]['tra_contratacion']).'</small></td>
										</tr>
									</table>
								</td>
								<td width="50%" align="center">
									 <table width="100%">
									 	<tr>
											<th>Sueldo Base:</th>
											<td>'.Utilidades::monto($data[$i]['liquid_sueldo_base']).'</td>
										</tr>
										<tr>
											<th>Dias Trabajados:</th>
											<td>'.$data[$i]['liquid_dias_trabajo'].'</td>
										</tr>
										<tr>
											<th>Base Imponible:</th>
											<td>'.Utilidades::monto($haberes).'</td>
										</tr>
										<tr>
											<th>Base Tributable:</th>
											<td>'.Utilidades::monto($tributables).'</td>
										</tr>
									</table>
								</td>
							</tr>
						  </table>
					  </div>
	    		</div>
	    		<div class="row">
		    		<div class="col">
		    			<table width="100%" align="center">
					  		<tr>
					  			<td align="center" class="h4">Haberes</td>
					  		</tr>
					  		<tr>
					  			<td align="center">
									<table width="100%" align="center" cellpadding="5">
										<tr>
									  		<th>Sueldo Base:</th>
									  		<td>'.Utilidades::monto($data[$i]['liquid_sueldo_base']).'</td>
									  	</tr>
									 	<tr>
									  		<th>Gratificaci&oacute;n:</th>
									  		<td>'.Utilidades::monto($data[$i]['liquid_grati_monto']).'</td>
									  	</tr>
									  	<tr>
											<th>Colaci&oacute;n:</th>
											<td>'.Utilidades::monto($data[$i]['liquid_colacion']).'</td>
										</tr>
										<tr>
											<th>Movilizaci&oacute;n:</th>
											<td>'.Utilidades::monto($data[$i]['liquid_movilizacion']).'</td>
										</tr>';
					if($data[$i]['liquid_monto_hr_extra'] > 0){
						$html .= '	 	<tr>
										  	<th>Hrs. Extras:</th>
										  	<td>'.Utilidades::monto($data[$i]['liquid_monto_hr_extra']).'</td>
										</tr>';
					}
					if ($data[$i]['liquid_comisiones'] > 0) {
						$html .= '	 	<tr>
										  	<th>Comisiones:</th>
										  	<td>'.Utilidades::monto($data[$i]['liquid_comisiones']).'</td>
										</tr>';
					}
					if ($data[$i]['liquid_bonos'] > 0) {
						$html .= '	 	<tr>
										  	<th>Bonos:</th>
										  	<td>'.Utilidades::monto($data[$i]['liquid_bonos']).'</td>
										</tr>';
					}
						
						
						
						$html .= '	</table>
									<table width="100%" cellpadding="5" class="border-top mt-2">
										<tr>
										  	<th align="left">Total Haberes:</th>
										  	<th align="left">'.Utilidades::monto($data[$i]['liquid_tot_haber']).'</th>
										</tr>
									</table>
					  			</td>
					  		</tr>
					  	</table>
		    		</div>
		    		<div class="col">
		    			<table width="100%" align="center">
					  		<tr>
					  			<td align="center" class="h4">Descuentos</td>
					  		</tr>
					  		<tr>
					  			<td align="center">';
			$html .= '				<table width="100%" align="center" cellpadding="5">
										<tr>
										  	<th>AFP <small>('.$data[$i]['liquid_afp'].'%)</small>:</th>
										  	<td>'.Utilidades::monto($data[$i]['liquid_monto_afp']).'</td>
										</tr>';

			if($data[$i]['liquid_apv'] > 0){
				$html .= '				<tr>
						  					<th>APV:</th>
						  					<td>'.Utilidades::monto($data[$i]['liquid_apv']).'</td>
						  				</tr>';
			}


			if($data[$i]['liquid_isapre'] == 0){
				$html .= '<tr>
						  	<th>FONASA <small>('.$data[$i]['liquid_prevision'].'%)</small>:</th>
						  	<td>'.Utilidades::monto($data[$i]['liquid_prev_monto']).'</td>
						  </tr>';
			}elseif($data[$i]['liquid_isapre'] == 1){
				$html .= '<tr>
						  	<th>ISAPRE:</th>
						  	<td>'.Utilidades::monto($data[$i]['liquid_prevision']).'</td>
						  </tr>';
			}

			if($data[$i]['liquid_adicional_isapre'] > 0){
				$html .= '<tr>
						  	<th>Adicional Isapre:</th>
						  	<td>'.Utilidades::monto($data[$i]['liquid_adicional_isapre']).'</td>
						  </tr>';
			}

			if($data[$i]['liquid_cesantia'] > 0){
				$html .= '<tr>
						  	<th>Seguro Cesantia:</th>
						  	<td>'.Utilidades::monto($data[$i]['liquid_cesantia']).'</td>
						  </tr>';
			}

			if($data[$i]['liquid_impuesto_unico'] > 0){
				$html .= '<tr>
						  	<th>Impuesto Unico:</th>
						  	<td>'.Utilidades::monto($data[$i]['liquid_impuesto_unico']).'</td>
						  </tr>';
			}

			if($data[$i]['liquid_anticipos'] > 0){
				$html .= '<tr>
						  	<th>Anticipos:</th>
						  	<td>'.Utilidades::monto($data[$i]['liquid_anticipos']).'</td>
						  </tr>';
			}

			if($data[$i]['liquid_seguro_vida'] > 0){
				$html .= '<tr>
						  	<th>Seguro Vida:</th>
						  	<td>'.Utilidades::monto($data[$i]['liquid_seguro_vida']).'</td>
						  </tr>';
			}

			if($data[$i]['liquid_caja'] > 0){
				$caja  = $recursos->datos_compensacion($data[$i]['liquid_caja']);
				$html .= '<tr>
						  	<th>'.$caja[0]['pre_nombre'].':</th>
						  	<td>'.Utilidades::monto($data[$i]['liquid_monto_caja']).'</td>
						  </tr>';
			}

			$html .= '
									</table>
									<table width="100%" cellpadding="5" class="border-top mt-2">
										<tr>
										  	<th align="left">Total Descuentos:</th>
										  	<th align="left">'.Utilidades::monto($data[$i]['liquid_tot_descuento']).'</th>
										</tr>
									</table>
								</td>
					  		</tr>
					  	</table>
		    		</div>
	    		</div>

			  <div class="row">
			  		<table width="100%" align="center" class="h3 mt-5 mb-5 sombraPlana2 bordes" cellpadding="5">
				  		<tr>
				  			<td align="left" class="tipo120">L&iacute;quido a Pagar:</td>
				  			<td align="left">
				  				 '.Utilidades::monto($data[$i]['liquid_tot_liquido']).'
				  			</td>
				  		</tr>
				  	</table>
			  		<table width="90%" cellpadding="3" align="center" class="sombraPlana bordes">
				  		<tr>
				  			<td align="left" class="bold">SON: '.strtoupper(Utilidades::texto_a_letra($data[$i]['liquid_tot_liquido'])).'</td>
				  		</tr>
				  		<tr>
				  			<td align="left">
				  				<i>Certifico que he recibido un monto de '.Utilidades::texto_a_letra($data[$i]['liquid_tot_liquido']).' es la suma indicada y no tengo cargo ni cobro alguno posterior que hacer a la empresa '.$empresa[0]['emp_razonsocial'].', por ninguno de los conceptos comprendidos en esta liquidaci&oacute;n.
				  			</td>
				  		</tr>
				  	</table><br>
			  </div>';
	    	}

	    	return $html;
	    }

	    public function listar_trabajadores_vacaciones($ano, $mes){
	    	$recursos = new Recursos();

	    	$sql  	  = $this->selectQuery("SELECT * FROM trabajadores
	    									WHERE 		  tra_estado = 1
				   							ORDER BY   	  tra_nombre ASC");

	    	$html 	  = '<table id="vacaciones_list" class="table table-hover shadow-lg animate__animated animate__fadeInLeft" style="width:100%">
		    			   <thead>
								<tr class="table-info">
									<th>Nombre</th>
									<th>Cargo</th>
									<th>Ingreso</th>
									<th>Empresa</th>
									<th>Vacaciones</th>
									<th>&nbsp;</th>
								</tr>
							</thead>
							<tbody>';

			for ($i=0; $i < count($sql); $i++) {
				if($sql[$i]['tra_tipo_contrato'] == 1){
					$tipo_contrato = $recursos->nombre_tipo_contrato($sql[$i]['tra_tipo_contrato']);
					$datos_empresa = $recursos->datos_empresa_id($sql[$i]['tra_empresa']);

					$html .= '<tr>
								<td>'.strtoupper($sql[$i]['tra_nombre']).'</td>
								<td><small>'.strtoupper($sql[$i]['tra_cargo']).'</small></td>
								<td>'.Utilidades::arreglo_fecha2($sql[$i]['tra_contratacion']).'</td>
								<td>'.$datos_empresa[0]['emp_razonsocial'].'</td>
								<td>'.$this->calculo_vacaciones($sql[$i]['tra_id'], 0, $ano, $mes).'</td>
								<td><i class="bi bi-sun-fill text-primary cursor" href="'.controlador::$rutaAPP.'app/vistas/rrhh/php/panel_vacaciones.php?idTrabajador='.$sql[$i]['tra_id'].'" data-fancybox data-type="iframe" data-preload="true" data-width="100%" data-height="1200"></i></td>
						 </tr>';
				}
			}

			$html .= '<tbody>
					</table>';

			return $html;
	    }

	    public function solicitudes_permisos_vacaciones($idTrabajador, $tipoPermiso, $ano, $mes){
	    	$data     = 0;
	    	$desde 	  = $ano.'-'.$mes.'-01';
	    	$hasta 	  = date("Y-m-t", strtotime($desde));

	    	if($tipoPermiso > 0){
	    		$script     = " AND sol_tipo_vacaciones =".$tipoPermiso;
	    	}elseif($tipoPermiso = 0){
	    		$script     = " AND sol_tipo_vacaciones IN(1,2)";
	    	}

	    	$sql  	  = $this->selectQuery("SELECT * FROM solicitudes_vacaciones
										    WHERE    	  sol_trabajador   		= $idTrabajador
										    $script
										    AND           sol_fecha_solicita    BETWEEN '$desde' AND '$hasta'
										    AND 		  sol_estado  			= 1
										    GROUP BY 	  sol_trabajador DESC");

	    	for ($i=0; $i < count($sql); $i++) { 
	    		$data     += $sql[$i]['sol_cantidad'];
	    	}

			return $data;
	    }

	    public function calculo_vacaciones($idTrabajador, $tipoPermiso, $ano, $mes){
	    	$recursos         = new Recursos();
			$datos_trabajador = $recursos->datos_trabajador($idTrabajador);

	    	$data_permiso     = $this->mostrar_permisos_trabajador($idTrabajador, $datos_trabajador[0]['tra_contratacion']);
	    	$calcular 		  = ($data_permiso['acumuladas']+$data_permiso['anuales']);

	    	return $calcular;
	    }

	    public function traer_vacaciones($ano, $mes){
			$recursos       	= new Recursos();

	    	$html = '
	    			<div class="d-flex flex-wrap align-items-center">
                        <h3><i class="bi bi-journal-check"></i>&nbsp;&nbsp;&nbsp;Vacaciones y Permisos: '.Utilidades::mostrar_mes($mes).' '.$ano.'.</h3>
                        <div class="ms-auto">
                            '.Utilidades::select_agrupacion_cards_mensual("mostrar_solicitudes", "mes_permiso", $ano, $mes).'
                        </div>
                    </div>
                    <div class="row overflow-auto " id="filtro_solicitudes" style="min-height:200px;">
                    '.$this->listar_solicitudes_vacaciones($ano, $mes).'			        
				    </div>
	    			<hr class="mt-2 mb-3"/>
	    			<h3><i class="bi bi-people-fill"></i>&nbsp;&nbsp;&nbsp;Listado Trabajadores.</h3>
	    			<div class="row overflow-auto " id="filtro_trabajadores">
				        '.$this->listar_trabajadores_vacaciones($ano, $mes).'
				    </div>';

			return $html;
	    }

	    public function finiquitos_ver($ano, $mes){

	    	$html = '<div class="d-flex flex-wrap align-items-center">
                        <h3><i class="bi bi-envelope-fill text-primary"></i>&nbsp;&nbsp;&nbsp;Finiquitos: '.Utilidades::mostrar_mes($mes).' '.$ano.'.</h3>
                        <div class="ms-auto">
                            '.Utilidades::select_agrupacion_cards_mensual("finiquitos_buscar", "mes_finiquito", $ano, $mes).'
                        </div>
                    </div>
                    <div class="row overflow-auto " id="filtro_finiquito" style="min-height:200px;">
                    '.$this->listar_finiquitos($ano, $mes).'			        
				    </div>
	    			<hr class="mt-2 mb-3"/>
	    			<h3><i class="bi bi-people-fill text-primary"></i>&nbsp;&nbsp;&nbsp;Listado Trabajadores.</h3>
	    			<div class="row overflow-auto " id="filtro_trabajadores">
				        '.$this->listar_trabajadores_finiquitos($ano, $mes).'
				    </div>';

			return $html;
	    }

	    public function listar_trabajadores_finiquitos($ano, $mes){
	    	$recursos = new Recursos();

	    	$sql  	  = $this->selectQuery("SELECT * FROM trabajadores
	    									WHERE 		  tra_estado = 1
				   							ORDER BY   	  tra_nombre ASC");

	    	$html 	  = '<table id="vacaciones_list" class="table table-hover shadow-lg animate__animated animate__fadeInLeft" style="width:100%">
		    			   <thead>
								<tr class="table-info">
									<th>Nombre</th>
									<th>Cargo</th>
									<th>Empresa</th>
									<th>Ingreso</th>
									<th>Dias Trabajados</th>
									<th>&nbsp;</th>
								</tr>
							</thead>
							<tbody>';

			for ($i=0; $i < count($sql); $i++) {
				if($sql[$i]['tra_tipo_contrato'] == 1){
					$tipo_contrato = $recursos->nombre_tipo_contrato($sql[$i]['tra_tipo_contrato']);
					$datos_empresa = $recursos->datos_empresa_id($sql[$i]['tra_empresa']);
					
					$html .= '<tr>
								<td>'.strtoupper($sql[$i]['tra_nombre']).'</td>
								<td><small>'.strtoupper($sql[$i]['tra_cargo']).'</small></td>
								<td><small>'.strtoupper($datos_empresa[0]['emp_razonsocial']).'</small></td>
								<td>'.Utilidades::arreglo_fecha2($sql[$i]['tra_contratacion']).'</td>
								<td>'.Utilidades::contador_fecha($sql[$i]['tra_contratacion'], Utilidades::fecha_hoy()).'</td>
								<td><i class="bi bi-envelope-fill text-primary cursor" href="'.controlador::$rutaAPP.'app/vistas/rrhh/php/panel_finiquito.php?idTrabajador='.$sql[$i]['tra_id'].'" data-fancybox data-type="iframe" data-preload="true" data-width="100%" data-height="1200"></i></td>
						 </tr>';
				}
			}

			$html .= '<tbody>
					</table>';

			return $html;
	    }

	    public function cantidad_vacaciones_trabajador($idTrabajador, $tipo){
	    	$recursos         	  = new Recursos();

	    	$mes_vacaciones   	  = 1.25;
	    	$ano_vacaciones   	  = 15;

	    	$datos_trabajador 	  = $recursos->datos_trabajador($idTrabajador);

	    	if($tipo == 1){ 		// acumulado
	    		$desde 			  = $datos_trabajador[0]['tra_contratacion'];
	    		$explorar_fecha   = explode("-", $datos_trabajador[0]['tra_contratacion']);

	    		$hasta 			  = $explorar_fecha[0]."-".$explorar_fecha[1]."-".$explorar_fecha[2];

		    	$firstDate  	  = new DateTime($desde);
				$secondDate 	  = new DateTime($hasta);
				$intvl 			  = $firstDate->diff($secondDate);

				$meses 			  = (($intvl->y*12)+$intvl->m);
				$vacaciones_mostrar= ($meses*$mes_vacaciones);

	    	}elseif($tipo == 2){ 	  // anual
	    		$explorar_fecha   = explode("-", $datos_trabajador[0]['tra_contratacion']);

		    	$desde            = $explorar_fecha[0]."-".$explorar_fecha[1]."-".$explorar_fecha[2];
		    	$hasta 			  = Utilidades::fecha_hoy();

		    	$firstDate  	  = new DateTime($desde);
				$secondDate 	  = new DateTime($hasta);

				$intvl 			  = $firstDate->diff($secondDate);

				$meses 			  = (($intvl->y*12)+$intvl->m);
				$vacaciones       = ($meses*$mes_vacaciones);

				if($vacaciones <= 15){
		    		$vacaciones_mostrar = $vacaciones;
		    	}else{
		    		$vacaciones_mostrar = 15;
		    	}
	    	}	    	

			return $vacaciones_mostrar;
	    }

	    public function mostrar_permisos_trabajador($idTrabajador, $fecha){
	    	$data_acumuladas = 0;
	    	$data_anuales    = 0;
	    	$tope_anual      = 15;
	    	$explorar_fecha  = explode("-", $fecha);

	    	//dias acumuladas y anuales
	    	$acumuladas     = $this->cantidad_vacaciones_trabajador($idTrabajador, 1);
			$anuales        = $this->cantidad_vacaciones_trabajador($idTrabajador, 2);

			$sql_acumuladas = $this->selectQuery("SELECT * FROM solicitudes_vacaciones
									   			  WHERE    	 	sol_trabajador   		= $idTrabajador
									   			  AND 			sol_tipo_vacaciones 	= 1
									   			  AND           sol_fecha_solicita     	BETWEEN '$desde' AND '$hasta'
									   			  AND 		  	sol_estado  			= 1");

			for ($i=0; $i < count($sql_acumuladas); $i++) { 
	    		$data_acumuladas += $sql_acumuladas[$i]['sol_cantidad'];
	    	}

	    	$sql_anuales    = $this->selectQuery("SELECT * FROM solicitudes_vacaciones
									   			  WHERE    	 	sol_trabajador   		= $idTrabajador
									   			  AND 			sol_tipo_vacaciones 	= 1
									   			  AND           sol_fecha_solicita     > '$desde'
									   			  AND 		  	sol_estado  			= 1");

	    	for ($i=0; $i < count($sql_anuales); $i++) { 
	    		$data_anuales += $sql_anuales[$i]['sol_cantidad'];
	    	}

	    	if($data_anuales > $anuales){
	    		$acumulados_anuales = ($data_anuales-$anuales);
	    		$anuales_mostrar    = 0;
	    	}else{
	    		$acumulados_anuales = 0;
	    		$anuales_mostrar    = ($anuales-$data_anuales);
	    	}

	    	return [
	    			'acumuladas' => (($acumuladas-$data_acumuladas)-$acumulados_anuales),
	    			'anuales' 	 => $anuales_mostrar
	    		   ];
	    }

	    public function card_vacaciones_trabajador($idTrabajador){

	    	$recursos = new Recursos();
	    	$html     = '';

			$sql      = $this->selectQuery("SELECT * FROM trabajadores
										    WHERE 		  tra_id = $idTrabajador");

			for ($i=0; $i < count($sql); $i++) {

				$tipo_contrato 	 = $recursos->nombre_tipo_contrato($sql[$i]['tra_tipo_contrato']);
				$estado_contrato = $recursos->nombre_estado_contrato($sql[$i]['tra_estado']);

				$data_permiso    = $this->mostrar_permisos_trabajador($idTrabajador, $sql[$i]['tra_contratacion']);

				$dias_restantes  = ($data_permiso['acumuladas']+$data_permiso['anuales']);

				$html  .=  '<input type="hidden" name="dias_restantes" id="dias_restantes" value="'.$dias_restantes.'">
							<table class="table table-striped">
					 			<thead>
									<tr>
										<th width="50%" align="left">Nombre:</th>
										<th width="50%" align="left">Fecha Ingreso:</th>
									</tr>
									<tr>
										<td align="left">'.$sql[$i]['tra_nombre'].'</td>
										<td align="left">'.Utilidades::arreglo_fecha2($sql[$i]['tra_contratacion']).'</td>
									</tr>
									<tr>
										<th width="50%" align="left">Tipo Contrato:</th>
										<th width="50%" align="left">Estado Contrato:</th>
									</tr>
									<tr>
										<td align="left">'.$tipo_contrato[0]['tip_nombre'].'</td>
										<td align="left">'.$estado_contrato[0]['tip_nombre'].'</td>
									</tr>
									<tr>
										<th width="50%" align="left" class="h4 text-success">Vacaciones acumuladas:</th>
										<th width="50%" align="left" class="h4 text-primary">Vacaciones anual:</th>
									</tr>
									<tr>
										<td align="left" class="h4 text-success">'.$data_permiso['acumuladas'].'</td>
										<td align="left" class="h4 text-primary">'.$data_permiso['anuales'].'</td>
									</tr>
									</thead>
								</table>';
			}

			return $html;	    	
	    }

	    public function grabar_permiso($tipo_permiso, $desde, $hasta, $dias, $comentario, $idTrabajador, $idUser){

			$grabar = $this->insert_query("INSERT INTO solicitudes_vacaciones(sol_trabajador, sol_fecha_solicita, sol_fecha_hasta, sol_usuario, sol_tipo_vacaciones, sol_cantidad, sol_comentario, sol_estado) 
	    			VALUES('$idTrabajador', '$desde', '$hasta', '$idUser', '$tipo_permiso', '$dias', '$comentario', 1)");

			if($grabar){
				return TRUE;
			}else{
				return FALSE;
			}
		}

		public function listar_solicitudes_vacaciones($ano, $mes){

	    	$desde 	  = $ano.'-'.$mes.'-01';
	    	$hasta 	  = date("Y-m-t", strtotime($desde));

	    	$recursos = new Recursos();

	    	$sql  	  = $this->selectQuery("SELECT * FROM trabajadores
	    									LEFT JOIN     solicitudes_vacaciones
	    									ON            solicitudes_vacaciones.sol_trabajador = trabajadores.tra_id
	    									LEFT JOIN     tipo_permiso_vacaciones
	    									ON            tipo_permiso_vacaciones.tip_id        = solicitudes_vacaciones.sol_tipo_vacaciones
	    									WHERE 		  trabajadores.tra_estado = 1
	    									AND           solicitudes_vacaciones.sol_fecha_solicita BETWEEN '$desde' AND '$hasta'
				   							ORDER BY   	  trabajadores.tra_nombre ASC");

	    	$html 	  = '
	    				<table id="solicitudes_trabajadores" class="table table-hover shadow-lg animate__animated animate__fadeInLeft" style="width:100%">
		    			   <thead>
								<tr>
									<th align="left">Tipo</th>
									<th align="left">Trabajador</th>
									<th align="left">Sale</th>
									<th align="left">Ingresa</th>
									<th align="left">Dias</th>
									<th align="left">&nbsp;</th>
								</tr>
							</thead>
							<tbody>';

			for ($i=0; $i < count($sql); $i++) {
				if($sql[$i]['tra_tipo_contrato'] == 1){
					$tipo_contrato = $recursos->nombre_tipo_contrato($sql[$i]['tra_tipo_contrato']);

					$html .= '<tr>
								<td>'.$sql[$i]['tip_nombre'].'</td>
								<td>'.strtoupper($sql[$i]['tra_nombre']).'</td>
								<td><small>'.Utilidades::arreglo_fecha2($sql[$i]['sol_fecha_solicita']).'</small></td>
								<td><small>'.Utilidades::arreglo_fecha2($sql[$i]['sol_fecha_hasta']).'</small></td>
								<td>'.$sql[$i]['sol_cantidad'].'</td>
								<td>
									<i class="bi bi-x-square text-danger cursor" onclick="quitar_solicitud('.$sql[$i]['sol_id'].')"></i>
								</td>
						 </tr>';
				}
			}

			$html .= '<tbody>
					</table>';

			return $html;
	    }

	    public function quitar_solicitud($idSolicitud){
			$grabar = $this->delete_query("DELETE FROM solicitudes_vacaciones
					   					   WHERE       sol_id = $idSolicitud");

			if($grabar){
				return TRUE;
			}else{
				return FALSE;
			}
		}

		public function grabar_finiquito_trabajador($idTrabajador, $fecha_inicio, $fecha_final, $dias_trabajados, $factor_dia, $ano_trabajados, $vacaciones_tomadas, $vacas_pendientes, $dias_inabiles, $tot_vacas_pendientes, $tot_concepto_vacaciones, $sueldo_base, $bono_pendiente, $bonos_3_meses, $renumeracion_diaria, $gratificacion, $bono_colacion, $bono_movilizacion, $total_sueldo_base, $ano_servicio, $previo_aviso, $tot_vacas_pendientes_propor, $sub_total, $total_haberes_mes, $total_desctos_mes, $total_pagar, $comentario){

			$hoy    = Utilidades::fecha_hoy();

			$sql    = $this->insert_query("INSERT INTO finiquito_trabajador(fin_trabajador, fin_contratacion, fin_fin_comtratacion, fin_dias_trabajado, fin_factor_dia, fin_ano_trabajado, fin_vacas_tomadas, fin_vacas_pendientes, fin_dias_inabiles, fin_tot_vacaciones, fin_sueldo_base, fin_bono_pendiente, fin_bonos_promedio, fin_renumeracion_diaria, fin_gratificacion, fin_colacion, fin_movilizacion, fin_total_sueldo_base, fin_ano_servicio, fin_total_previo_aviso, fin_proporcional, fin_sub_total, fin_total_haberes_mes, fin_total_dscto_mes, fin_total_pagar, fin_fecha_realizado, fin_comentario, fin_estado)
				   VALUES ('$idTrabajador', '$fecha_inicio', '$fecha_final', '$dias_trabajados', '$factor_dia', '$ano_trabajados', '$vacaciones_tomadas', '$vacas_pendientes', '$dias_inabiles', '$tot_concepto_vacaciones', '$sueldo_base', '$bono_pendiente', '$bonos_3_meses', '$renumeracion_diaria', '$gratificacion', '$bono_colacion', '$bono_movilizacion', '$total_sueldo_base', '$ano_servicio', '$previo_aviso', '$tot_vacas_pendientes_propor', '$sub_total', '$total_haberes_mes', '$total_desctos_mes', '$total_pagar', '$hoy', '$comenta', 1)");

			if($sql){
				$this->update_query("UPDATE trabajadores
					   			 	 SET    tra_estado 		 = 2,
					   			 	 		tra_fin_contrato = '$hoy'
					   			 	 WHERE  tra_id     		 = $idTrabajador");

				return TRUE;
			}else{
				return FALSE;
			}
		}

		public function documento_finiquito($idTrabajador){
	    	$recursos 	= new Recursos();

	    	$empresa    = $recursos->datos_empresa();
	    	$parametros = $recursos->datos_parametros();
	    	$trabajador = $recursos->datos_trabajador($idTrabajador);
	    	$data 	  	= $recursos->datos_finiquito_trabajador($idTrabajador, $mes, $ano);
	    	$html 	  	= '';

	    	for ($i=0; $i < count($data); $i++) {
	    		$html.= '
	    		<div class="row">
	    			<table width="80%" align="center" class="table">
						<tr>
							<td width="33.3%">
								 <table style="font-size:13px;">
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
					  <div class="col-15">
					  	<p align="center" class="h3">FINIQUITO TRABAJADOR</p>
					  </div>
					  <div class="col-15">
					  	<table width="90%" cellspacing="5" cellpadding="5" align="center" class="table sombraPlana2 bordes">
							<tr>
								<td>
									<table width="100%">
										<tr>
											<th>Nombre:</th>
											<td><small>'.ucfirst($data[$i]['tra_nombre']).'</small></td>
											<th>Rut:</th>
											<td><small>'.$data[$i]['tra_rut'].'</small></td>
										</tr>
										<tr>
											<th>Cargo:</th>
											<td><small>'.ucfirst($data[$i]['tra_cargo']).'</small></td>
											<th>Sueldo Base:</th>
											<td>'.Utilidades::monto($data[$i]['liquid_sueldo_base']).'</td>
										</tr>
										<tr>
											<th>Contrataci&oacute;n:</th>
											<td><small>'.Utilidades::arreglo_fecha2($data[$i]['tra_contratacion']).'</small></td>
											<th>Fin Contrato:</th>
											<td>'.Utilidades::arreglo_fecha2($data[$i]['tra_fin_contrato']).'</td>
										</tr>
									</table>
								</td>
							</tr>
						  </table>
					  </div>
	    		</div>
	    		<div class="row">
		    		<div class="col-xl-12 mb-2">
		    			<table width="95%" align="center" cellpadding="4" cellspacing="0" class="sombraPlana">
							<tr>
								<td colspan="4" align="center">
									<p align="center" class="h3">Vacaciones Proporcionales Pendientes</p>
								</td>
							</tr>
							<tr class="blanco">
								<th width="25%" align="left">Fecha contratado:</th>
								<td width="25%" align="left">'.Utilidades::arreglo_fecha2($data[$i]['fin_contratacion']).'</td>
								<th width="25%" align="left">Fecha Finiquito:</th>
								<td width="25%" align="left">'.Utilidades::arreglo_fecha2($data[$i]['fin_fin_comtratacion']).'</td>
							</tr>
							<tr class="blanco">
								<th width="25%" align="left">Dias Trabajado:</th>
								<td width="25%" align="left">'.$data[$i]['fin_dias_trabajado'].'</td>
								<th width="25%" align="left">Factor Diario:</th>
								<td width="25%" align="left">'.$data[$i]['fin_factor_dia'].'</td>
							</tr>
							<tr class="blanco">
								<th width="25%" align="left">A&ntilde;os Trabajados:</th>
								<td width="25%" align="left">'.$data[$i]['fin_ano_trabajado'].'</td>
								<th width="25%" align="left">Total Vacaciones otorgadas:</th>
								<td width="25%" align="left">'.$data[$i]['fin_vacas_tomadas'].'</td>
							</tr>
							<tr class="blanco">
								<th width="25%" align="left">Vacaciones Pendientes:</th>
								<td width="25%" align="left">'.$data[$i]['fin_vacas_pendientes'].'</td>
								<th width="25%" align="left">Dias Inh&aacute;biles(Desde fin contrato):</th>
								<td width="25%" align="left">'.$data[$i]['fin_dias_inabiles'].'</td>
							</tr>
							<tr class="blanco">
								<th width="25%" align="left">Total Vacaciones Pendientes:</th>
								<td width="25%" align="left">'.$data[$i]['fin_vacas_pendientes'].'</td>
								<th width="25%" align="left">Total Concepto de Vacaciones:</th>
								<td width="25%" align="left">'.Utilidades::monto($data[$i]['fin_tot_vacaciones']).'</td>
							</tr>
						</table>
		    		</div>
		    		<div class="col-xl-12 mb-2">
		    			<table width="95%" align="center" cellpadding="4" cellspacing="0" class="sombraPlana">
							<tr>
								<td colspan="4" align="center">
									<p align="center" class="h3">Indemnizaci&oacute;n por Despido</p>
								</td>
							</tr>
							<tr class="blanco">
								<th width="25%" align="left">Sueldo Base:</th>
								<td width="25%" align="left">'.Utilidades::monto($data[$i]['fin_sueldo_base']).'</td>
								<th width="25%" align="left">Bonos del mes despido:</th>
								<td width="25%" align="left">'.Utilidades::monto($data[$i]['fin_bono_pendiente']).'</td>
							</tr>
							<tr class="blanco">
								<th width="25%" align="left">Bonos promedios <small>(&Uacute;ltimos 3 meses)</small>:</th>
								<td width="25%" align="left">'.Utilidades::monto($data[$i]['fin_bonos_promedio']).'</td>
								<th width="25%" align="left">Valor Remuneraci&oacute;n Diaria:</th>
								<td width="25%" align="left">'.Utilidades::monto($data[$i]['fin_renumeracion_diaria']).'</td>
							</tr>
							<tr class="blanco">
								<th width="25%" align="left">Gratificaci&oacute;n Mensual:</th>
								<td width="25%" align="left">'.Utilidades::monto($data[$i]['fin_gratificacion']).'</td>
								<th width="25%" align="left">&nbsp;</th>
								<td width="25%" align="left">&nbsp;</td>
							</tr>
							<tr class="blanco">
								<th width="25%" align="left">Bono Colaci&oacute;n:</th>
								<td width="25%" align="left">'.Utilidades::monto($data[$i]['fin_colacion']).'</td>
								<th width="25%" align="left">Bono Movilizaci&oacute;n:</th>
								<td width="25%" align="left">'.Utilidades::monto($data[$i]['fin_movilizacion']).'</td>
							</tr>
							<tr class="blanco">
								<td colspan="4" align="left">&nbsp;</td>
							</tr>
							<tr class="blanco">
								<th colspan="2" width="50%" align="left">Total a&ntilde;os servicio y Mes aviso:</th>
								<td colspan="2" width="50%" align="left">'.Utilidades::monto($data[$i]['fin_total_sueldo_base']).'</td>
							</tr>
						</table>
		    		</div>
	    		</div>
	    		<div style="page-break-after:always">&nbsp;</div>
			  <div class="row">
			  	<p align="center" class="h3">CALCULO CON TOPES</p>
					<table width="100%" align="center" cellpadding="7" cellspacing="0" class="sombraPlana">
						<tr>
							<th width="70%" align="left">Indemnizacion por A&ntilde;os de Servicio.</th>
							<td width="30%">'.Utilidades::monto($data[$i]['fin_ano_servicio']).'</td>
						</tr>
						<tr>
							<th width="70%" align="left">Indemnizacion sustitutivo aviso previo.</th>
							<td width="30%">'.Utilidades::monto($data[$i]['fin_total_previo_aviso']).'</td>
						</tr>
						<tr>
							<th width="70%" align="left">Vacaciones pendientes y/o proporcionales.</th>
							<td width="30%">'.Utilidades::monto($data[$i]['fin_proporcional']).'</td>
						</tr>
						<tr>
							<th width="70%" align="left">SUB-TOTAL</th>
							<th width="30%" align="left">'.Utilidades::monto($data[$i]['fin_sub_total']).'</th>
						</tr>
						<tr>
							<th colspan="2" align="center" class="h4">Remuneracion del Mes</th>
						</tr>
						<tr>
							<th width="70%" align="left">Total Haberes</th>
							<th width="30%" align="left">'.Utilidades::monto($data[$i]['fin_total_haberes_mes']).'</th>
						</tr>
						<tr>
							<th width="70%" align="left">Total Descuentos</th>
							<th width="30%" align="left">'.Utilidades::monto($data[$i]['fin_total_dscto_mes']).'</th>
						</tr>
						<tr class="blanco" style="font-size:120%;">
							<th width="70%" align="left">TOTAL A PAGAR</th>
							<th width="30%" align="left">'.Utilidades::monto($data[$i]['fin_total_pagar']).'</th>
						</tr>
					</table>
			  		<table width="100%" align="center" class="h3 mt-5 mb-5 sombraPlana2 bordes" cellpadding="5">
				  		<tr>
				  			<td align="left" class="tipo120">L&iacute;quido a Pagar:</td>
				  			<td align="left">
				  				 '.Utilidades::monto($data[$i]['fin_total_pagar']).'
				  			</td>
				  		</tr>
				  	</table>
			  		<table width="90%" cellpadding="3" align="center" class="sombraPlana bordes">
				  		<tr>
				  			<td align="left" class="bold">SON: '.strtoupper(Utilidades::texto_a_letra($data[$i]['fin_total_pagar'])).'</td>
				  		</tr>
				  		<tr>
				  			<td align="left">
				  				<i>Certifico que he recibido un monto de '.Utilidades::texto_a_letra($data[$i]['fin_total_pagar']).' de la empresa '.$empresa[0]['emp_razonsocial'].', es la suma indicada y no tengo cargo ni cobro alguno posterior que hacer, por ninguno de los conceptos comprendidos en esta liquidaci&oacute;n.
				  			</td>
				  		</tr>
				  	</table><br>
				  	<table width="100%" align="center">
					  	<tr>
							<td align="center">&nbsp;</td>
						</tr>
						<tr>
							<td align="center">&nbsp;</td>
						</tr>
						<tr>
							<td align="center">________________________<br>'.strtoupper($trabajador[0]['tra_nombre']).'.<br>'.strtoupper($trabajador[0]['tra_cargo']).'</td>
						</tr>
						<tr>
							<td align="center">&nbsp;</td>
						</tr>
						<tr>
							<td align="center">&nbsp;</td>
						</tr>
					</table>
			  </div>';
	    	}

	    	return $html;
	    }

	    public function listar_finiquitos($ano, $mes){

	    	$desde 	  = $ano.'-'.$mes.'-01';
	    	$hasta 	  = date("Y-m-t", strtotime($desde));

	    	$recursos = new Recursos();

	    	$sql  	  = $this->selectQuery("SELECT * FROM trabajadores
	    									LEFT JOIN     finiquito_trabajador
	    									ON            finiquito_trabajador.fin_trabajador = trabajadores.tra_id
	    									WHERE 		  finiquito_trabajador.fin_fin_comtratacion BETWEEN '$desde' AND '$hasta'
				   							ORDER BY   	  finiquito_trabajador.fin_fin_comtratacion ASC");

	    	$html 	  = '
	    				<table id="solicitudes_trabajadores" class="table table-hover shadow-lg animate__animated animate__fadeInLeft" style="width:100%">
		    			   <thead>
								<tr>
									<th align="left">Trabajador</th>
									<th align="left">Fecha Finiquito</th>
									<th align="left">Monto</th>
									<th align="left">&nbsp;</th>
									<th align="left">&nbsp;</th>
								</tr>
							</thead>
							<tbody>';

			for ($i=0; $i < count($sql); $i++) {
				if($sql[$i]['tra_tipo_contrato'] == 1){
					$tipo_contrato = $recursos->nombre_tipo_contrato($sql[$i]['tra_tipo_contrato']);

					$html .= '<tr>
								<td>'.strtoupper($sql[$i]['tra_nombre']).'</td>
								<td><small>'.Utilidades::arreglo_fecha2($sql[$i]['fin_fin_comtratacion']).'</small></td>
								<td>'.Utilidades::monto($sql[$i]['fin_total_pagar']).'</td>
								<td>
									<i class="bi bi-eye text-primary cursor" href="'.controlador::$rutaAPP.'app/vistas/rrhh/php/documento_finiquito.php?idTrabajador='.$sql[$i]['tra_id'].'&print=0" data-fancybox data-type="iframe" data-preload="true" data-width="100%" data-height="1200"></i>
								</td>
								<td>
									<i class="bi bi-printer text-dark cursor" href="'.controlador::$rutaAPP.'app/vistas/rrhh/php/documento_finiquito.php?idTrabajador='.$sql[$i]['tra_id'].'&print=1" data-fancybox data-type="iframe" data-preload="true" data-width="100%" data-height="1200"></i>
								</td>
						 </tr>';
				}
			}

			$html .= '<tbody>
					</table>';

			return $html;
	    }

	    public function listar_salud_mostrar(){
	    	$sql  	= $this->selectQuery("SELECT * FROM previsiones
										  WHERE  		pre_estado = 1");

			$html   = '<table width="98%" align="center" id="lista_prevision" class="table table-hover">
						<thead>
							<tr class="plomo">
								<th>Nombre</th>
								<th>%</th>
								<th>&nbsp;</th>
								<th>&nbsp;</th>
							</tr>
						</thead>
						<tbody>';

			for ($i=0; $i < count($sql); $i++) { 
				$html   .= '<tr id="cambiazo2">
								<td>'.$sql[$i]['pre_nombre'].'</td>
								<td>'.$sql[$i]['pre_descuento'].'</td>
								<td>
									<i class="bi bi-pencil-square text-info cursor" onclick="traer_editar_prevision('.$sql[$i]['pre_id'].')"></i>
								</td>
								<td>
									<i class="bi bi-x-circle text-danger cursor" onclick="quitar_prevision('.$sql[$i]['pre_id'].')"></i>
								</td>
							</tr>';
			}
			$html   .= '</tbody>
						</table>';
			return $html;
		}

		public function listar_pension_mostrar(){
	    	$sql  	= $this->selectQuery("SELECT *FROM pensiones
										  WHERE  	   pre_estado = 1");

			$html   = '<table width="98%" align="center" id="lista_pension" class="table table-hover">
						<thead>
							<tr class="plomo">
								<th>Nombre</th>
								<th>%</th>
								<th>&nbsp;</th>
								<th>&nbsp;</th>
							</tr>
						</thead>
						<tbody>';

			for ($i=0; $i < count($sql); $i++) { 
				$html   .= '<tr id="cambiazo2">
								<td>'.$sql[$i]['pre_nombre'].'</td>
								<td>'.$sql[$i]['pre_descuento'].'</td>
								<td>
									<i class="bi bi-pencil-square text-info cursor" onclick="traer_editar_pensiones('.$sql[$i]['pre_id'].')"></i>
								</td>
								<td>
									<i class="bi bi-x-circle text-danger cursor" onclick="quitar_pension('.$sql[$i]['pre_id'].')"></i>
								</td>
							</tr>';
			}
			$html   .= '</tbody>
						</table>';
			return $html;
		}

		public function listar_isapres_mostrar(){
	    	$sql  	= $this->selectQuery("SELECT * FROM isapres
										  WHERE  		pre_estado = 1");

			$html   = '<table width="98%" align="center" id="lista_isapres" class="table table-hover">
						<thead>
							<tr class="plomo">
								<th>Nombre</th>
								<th>&nbsp;</th>
								<th>&nbsp;</th>
							</tr>
						</thead>
						<tbody>';

			for ($i=0; $i < count($sql); $i++) { 
				$html   .= '<tr id="cambiazo2">
								<td>'.$sql[$i]['pre_nombre'].'</td>
								<td>
									<i class="bi bi-pencil-square text-info cursor" onclick="traer_editar_isapre('.$sql[$i]['pre_id'].')"></i>
								</td>
								<td>
									<i class="bi bi-x-circle text-danger cursor" onclick="quitar_isapre('.$sql[$i]['pre_id'].')"></i>
								</td>
							</tr>';
			}
			$html   .= '</tbody>
						</table>';
			return $html;
		}

		public function listar_compensaciones_mostrar(){
	    	$sql  	= $this->selectQuery("SELECT * FROM compensaciones
										  WHERE  		pre_estado = 1");

			$html   = '<table width="98%" align="center" id="lista_compensaciones" class="table table-hover">
						<thead>
							<tr class="plomo">
								<th>Nombre</th>
								<th>&nbsp;</th>
								<th>&nbsp;</th>
							</tr>
						</thead>
						<tbody>';

			for ($i=0; $i < count($sql); $i++) { 
				$html   .= '<tr id="cambiazo2">
								<td>'.$sql[$i]['pre_nombre'].'</td>
								<td>
									<i class="bi bi-pencil-square text-info cursor" onclick="traer_editar_caja('.$sql[$i]['pre_id'].')"></i>
								</td>
								<td>
									<i class="bi bi-x-circle text-danger cursor" onclick="quitar_caja('.$sql[$i]['pre_id'].')"></i>
								</td>
							</tr>';
			}
			$html   .= '</tbody>
						</table>';
			return $html;
		}

		public function grabar_prevision($nombre, $descuentos){

			$grabar = $this->insert_query("INSERT INTO previsiones(pre_nombre, pre_descuento, pre_estado) 
					   					   VALUES('$nombre', $descuentos, 1)");

			if($grabar){
				return TRUE;
			}else{
				return FALSE;
			}
		}

		public function traer_editar_prevision($id){
	    	$html   	= '';
			$recursos 	= new Recursos();
			$prevision 	= $recursos->datos_previsiones_general($id);

	    	for ($i=0; $i < count($prevision); $i++) { 
	    		$html  .= ' <table width="90%" align="center" cellpadding="5" cellspacing="5" class="arriba_top10 sombraPlana">
								<tr class="verde">
									<th colspan="2" align="center">Editar previsi&oacute;n</th>
								</tr>
								<tr class="blanco">
									<td width="50%" align="left">Nombre:</td>
									<td width="50%" align="left">Descuento:</td>
								</tr>
								<tr class="blanco">
									<td align="left">
										<input type="text" class="form-control shadow" name="nombre" id="nombre" placeholder="Escribir nombre." value="'.$prevision[$i]['pre_nombre'].'">
									</td>
									<td align="left">
										<input type="text" class="form-control shadow" name="descuentos" id="descuentos"  placeholder="ej: 0.77" value="'.$prevision[$i]['pre_descuento'].'" min="1" max="30">
									</td>
								</tr>
								<tr class="blanco">
									<td align="center" colspan="2">
										<table width="30%" align="center">
											<tr>
												<td align="center">
													<button type="button" id="grabar" class="btn btn-primary form-control shadow" onclick="grabar_editar_prevision('.$id.')">Grabar <i class="bi bi-save"></i></button>
												</td>
											</tr>
										</table>
									</td>
								</tr>
							</table>';
	    	}

		    return $html;
		}

		public function grabar_editar_prevision($id, $nombre, $descuentos){
			$grabar = $this->update_query("UPDATE previsiones
										   SET    pre_nombre    = '$nombre',
											   	  pre_descuento = '$descuentos'
										   WHERE  pre_id        = $id");

			if($grabar){
				return TRUE;
			}else{
				return FALSE;
			}
		}

		public function quitar_prevision($id){
			$grabar = $this->delete_query("DELETE FROM previsiones WHERE  pre_id = $id");

			if($grabar){
				return TRUE;
			}else{
				return FALSE;
			}
		}

		public function grabar_pensiones($nombre, $descuentos){

			$grabar = $this->insert_query("INSERT INTO pensiones(pre_nombre, pre_descuento, pre_estado) 
					   					   VALUES('$nombre', $descuentos, 1)");

			if($grabar){
				return TRUE;
			}else{
				return FALSE;
			}
		}

		public function traer_editar_pensiones($id){
	    	$html   	= '';
			$recursos 	= new Recursos();
			$prevision 	= $recursos->datos_pensiones_general($id);

	    	for ($i=0; $i < count($prevision); $i++) { 
	    		$html  .= ' <table width="90%" align="center" cellpadding="5" cellspacing="5" class="arriba_top10 sombraPlana">
								<tr class="verde">
									<th colspan="2" align="center">Editar pension</th>
								</tr>
								<tr class="blanco">
									<td width="50%" align="left">Nombre:</td>
									<td width="50%" align="left">Descuento:</td>
								</tr>
								<tr class="blanco">
									<td align="left">
										<input type="text" class="form-control shadow" name="nombre" id="nombre" placeholder="Escribir nombre." value="'.$prevision[$i]['pre_nombre'].'">
									</td>
									<td align="left">
										<input type="text" class="form-control shadow" name="descuentos" id="descuentos"  placeholder="ej: 0.77" value="'.$prevision[$i]['pre_descuento'].'" min="1" max="30">
									</td>
								</tr>
								<tr class="blanco">
									<td align="center" colspan="2">
										<table width="30%" align="center">
											<tr>
												<td align="center">
													<button type="button" id="grabar" class="btn btn-primary form-control shadow" onclick="grabar_editar_pension('.$id.')">Grabar <i class="bi bi-save"></i></button>
												</td>
											</tr>
										</table>
									</td>
								</tr>
							</table>';
	    	}

		    return $html;
		}

		public function grabar_editar_pensiones($id, $nombre, $descuentos){
			$grabar = $this->update_query("UPDATE pensiones
										   SET    pre_nombre    = '$nombre',
											   	  pre_descuento = '$descuentos'
										   WHERE  pre_id        = $id");

			if($grabar){
				return TRUE;
			}else{
				return FALSE;
			}
		}

		public function quitar_pension($id){
			$grabar = $this->delete_query("DELETE FROM pensiones WHERE  pre_id = $id");

			if($grabar){
				return TRUE;
			}else{
				return FALSE;
			}
		}

		public function grabar_isapre($nombre){

			$grabar = $this->insert_query("INSERT INTO isapres(pre_nombre, pre_estado) 
					   					   VALUES('$nombre', 1)");

			if($grabar){
				return TRUE;
			}else{
				return FALSE;
			}
		}

		public function traer_editar_isapre($id){
	    	$html   	= '';
			$recursos 	= new Recursos();
			$prevision 	= $recursos->datos_isapres_general($id);

	    	for ($i=0; $i < count($prevision); $i++) { 
	    		$html  .= ' <table width="90%" align="center" cellpadding="5" cellspacing="5" class="arriba_top10 sombraPlana">
								<tr class="verde">
									<th align="center">Editar isapre</th>
								</tr>
								<tr class="blanco">
									<tdalign="left">Nombre:</td>
								</tr>
								<tr class="blanco">
									<td align="left">
										<input type="text" class="form-control shadow" name="nombre" id="nombre" placeholder="Escribir nombre." value="'.$prevision[$i]['pre_nombre'].'">
									</td>

								</tr>
								<tr class="blanco">
									<td align="center">
										<table width="30%" align="center">
											<tr>
												<td align="center">
													<button type="button" id="grabar" class="btn btn-primary form-control shadow" onclick="grabar_editar_isapre('.$id.')">Grabar <i class="bi bi-save"></i></button>
												</td>
											</tr>
										</table>
									</td>
								</tr>
							</table>';
	    	}

		    return $html;
		}

		public function grabar_editar_isapre($id, $nombre){
			$grabar = $this->update_query("UPDATE isapres
										   SET    pre_nombre    = '$nombre'
										   WHERE  pre_id        = $id");

			if($grabar){
				return TRUE;
			}else{
				return FALSE;
			}
		}

		public function quitar_isapre($id){
			$grabar = $this->delete_query("DELETE FROM isapres WHERE  pre_id = $id");

			if($grabar){
				return TRUE;
			}else{
				return FALSE;
			}
		}

		public function grabar_caja($nombre){

			$grabar = $this->insert_query("INSERT INTO compensaciones(pre_nombre, pre_estado) 
					   					   VALUES('$nombre', 1)");

			if($grabar){
				return TRUE;
			}else{
				return FALSE;
			}
		}

		public function traer_editar_caja($id){
	    	$html   	= '';
			$recursos 	= new Recursos();
			$prevision 	= $recursos->datos_compensaciones_general($id);

	    	for ($i=0; $i < count($prevision); $i++) { 
	    		$html  .= ' <table width="90%" align="center" cellpadding="5" cellspacing="5" class="arriba_top10 sombraPlana">
								<tr class="verde">
									<th align="center">Editar caja</th>
								</tr>
								<tr class="blanco">
									<tdalign="left">Nombre:</td>
								</tr>
								<tr class="blanco">
									<td align="left">
										<input type="text" class="form-control shadow" name="nombre" id="nombre" placeholder="Escribir nombre." value="'.$prevision[$i]['pre_nombre'].'">
									</td>

								</tr>
								<tr class="blanco">
									<td align="center">
										<table width="30%" align="center">
											<tr>
												<td align="center">
													<button type="button" id="grabar" class="btn btn-primary form-control shadow" onclick="grabar_editar_caja('.$id.')">Grabar <i class="bi bi-save"></i></button>
												</td>
											</tr>
										</table>
									</td>
								</tr>
							</table>';
	    	}

		    return $html;
		}

		public function grabar_editar_caja($id, $nombre){
			$grabar = $this->update_query("UPDATE compensaciones
										   SET    pre_nombre    = '$nombre'
										   WHERE  pre_id        = $id");

			if($grabar){
				return TRUE;
			}else{
				return FALSE;
			}
		}

		public function quitar_caja($id){
			$grabar = $this->delete_query("DELETE FROM compensaciones WHERE  pre_id = $id");

			if($grabar){
				return TRUE;
			}else{
				return FALSE;
			}
		}

		public function sueldo_minimo_editar(){
			$sql  	= $this->selectQuery("SELECT par_sueldo_minimo
		    		   					  FROM   parametros
		    		   					  WHERE  par_estado    = 1");

		    $html   = '<div class="col-xl-4 mb-3" id="minimo_editar">';

		    for ($i=0; $i < count($sql); $i++) { 
		    	$html  .= '<table width="90%" align="center" class="sombraPlana bordes" cellpadding="3" cellspacing="3">
		    				 <tr>
		    				 	<td colspan="2" align="left">Sueldo M&iacute;nimo</td>
		    				 </tr>
		    				 <tr>
		    				 	<td>
		    				 		<input type="number" class="form-control shadow" id="sueldo_mini" name="sueldo_mini" value="'.$sql[$i]['par_sueldo_minimo'].'">
		    				 	</td>
		    				 	<td>
		    				 		<span class="text_link cursor" onclick="editar_sueldo_minimo()">Editar</span>
		    				 	</td>
		    				 </tr>
		    			   </table>';
		    }

		    $html  .= '</div>';

		    return $html;
		}

		public function sueldo_uf_editar(){
		    $sql  	= $this->selectQuery("SELECT par_uf
		    		   					  FROM   parametros
		    		   					  WHERE  par_estado    = 1");

		    $html   = '<div class="col-xl-4 mb-3" id="uf_editar">';

		    for ($i=0; $i < count($sql); $i++) { 
		    	$html  .= '<table width="90%" align="center" class="sombraPlana bordes" cellpadding="3" cellspacing="3">
		    				 <tr>
		    				 	<td colspan="2" align="left">UF</td>
		    				 </tr>
		    				 <tr>
		    				 	<td>
		    				 		<input type="number" class="form-control shadow" id="sueldo_uf_mini" name="sueldo_uf_mini" value="'.$sql[$i]['par_uf'].'">
		    				 	</td>
		    				 	<td>
		    				 		<span class="text_link cursor" onclick="editar_uf()">Editar</span>
		    				 	</td>
		    				 </tr>
		    			   </table>';
		    }

		    $html  .= '</div>';

		    return $html;
		}

		public function sueldo_utm_editar(){
			$sql  	= $this->selectQuery("SELECT par_utm
		    		   					  FROM   parametros
		    		   					  WHERE  par_estado    = 1");

		    $html   = '<div class="col-xl-4 mb-3" id="utm_editar">';

		    for ($i=0; $i < count($sql); $i++) { 
		    	$html  .= '<table width="90%" align="center" class="sombraPlana bordes" cellpadding="3" cellspacing="3">
		    				 <tr>
		    				 	<td colspan="2" align="left">UTM</td>
		    				 </tr>
		    				 <tr>
		    				 	<td>
		    				 		<input type="number" class="form-control shadow" id="sueldo_utm_mini" name="sueldo_utm_mini" value="'.$sql[$i]['par_utm'].'">
		    				 	</td>
		    				 	<td>
		    				 		<span class="text_link cursor" onclick="editar_utm()">Editar</span>
		    				 	</td>
		    				 </tr>
		    			   </table>';
		    }

		    $html  .= '</div>';

		    return $html;
		}

		public function editar_sueldo_minimo($sueldo_minimo){
			$sql = $this->update_query("UPDATE parametros
										SET    par_sueldo_minimo = $sueldo_minimo
										WHERE  par_estado 		 = 1");
		}

		public function editar_uf($uf){
			$sql = $this->update_query("UPDATE parametros
										SET    par_uf 		= $uf
										WHERE  par_estado 	= 1");
		}

		public function editar_utm($utm){
			$sql = $this->update_query("UPDATE parametros
										SET    par_utm 		= $utm
										WHERE  par_estado 	= 1");
		}

	   /**  FIN FINANZAS   **/

	} // END CLASS
?>