<?php
	require_once __dir__."/../modelo/obtener_datos.php";
	require_once __dir__."/../controlador/utilidadesControlador.php";
	require_once __dir__."/../controlador/recursosControlador.php";

	class Parametros extends GetDatos {

		public function __construct(){
			parent::__construct();
	    }

	    public function listar_usuarios(){
	    	$recursos = new Recursos();

	    	$sql  	  = $this->selectQuery("SELECT * FROM usuario_cli
	    									LEFT JOIN     categorias_usuarios
	    									ON    		  categorias_usuarios.cat_id = usuario_cli.us_cli_tipoUsuario
										    LEFT JOIN     sucursales
										    ON            sucursales.suc_id          = usuario_cli.us_cli_sucursal
                                            WHERE    	  usuario_cli.us_cli_estado  = 1
										    ORDER BY 	  usuario_cli.us_cli_id DESC");

			$html     = '<table width="98%" align="center" id="listado_usuario" class="table table-hover">
							<tr class="plomo">
								<th align="left">Nombre</th>
								<th align="left">Tipo</th>
								<th align="left">Sucursal</th>
								<th align="center" colspan="2">&nbsp;</th>
							</tr>';

			for ($i=0; $i < count($sql); $i++) { 
				$html   .= '<tr id="cambiazo2">
								<td>'.$sql[$i]['us_cli_nombre'].'</td>
								<td>'.$sql[$i]['cat_nombre'].'</td>
								<td>'.$sql[$i]['suc_nombre'].'</td>
								<td align="center">
									<i class="bi bi-eye text-primary cursor" href="'.controlador::$rutaAPP.'app/vistas/parametros/php/editar_usuario.php?idUsuario='.$sql[$i]['us_cli_id'].'" data-fancybox data-type="iframe" data-preload="true" data-width="100%" data-height="1200"></i>
								</td>
								<td align="center">
									<i class="bi bi-x-circle text-danger cursor" onclick="quitar_usuario('.$sql[$i]['us_cli_id'].')"></i>
								</td>
							</tr>';
			}

			$html   .= '</table>';

			return $html;
		}

		public function listar_sucursales(){
		    $recursos = new Recursos();
		    $sql  	  = $this->selectQuery("SELECT * FROM sucursales
		    								WHERE         suc_estado = 1");

			$html     = '<table width="98%" align="center" id="listado_usuario" class="table table-hover">
							<tr class="plomo">
								<th align="left">Nombre</th>
								<th align="center" colspan="2">&nbsp;</th>
							</tr>';

			for ($i=0; $i < count($sql); $i++) { 
				$html   .= '<tr id="cambiazo2">
								<td>'.$sql[$i]['suc_nombre'].'</td>
								<td align="center">
									<i class="bi bi-eye text-primary cursor" href="'.controlador::$rutaAPP.'app/vistas/parametros/php/editar_sucursal.php?idSucursal='.$sql[$i]['suc_id'].'" data-fancybox data-type="iframe" data-preload="true" data-width="100%" data-height="1200"></i>
								</td>
								<td align="center">
									<i class="bi bi-x-circle text-danger cursor" onclick="desactivar_sucursal('.$sql[$i]['suc_id'].')"></i>
								</td>
							</tr>';
			}

			$html   .= '</table>';

			return $html;
		}

		public function grabar_usuario($inputNombre, $inputRut, $inputEmail, $inputContrasena, $inputSucursal, $inputTipoUsuario){
			$encrip 	= md5($inputContrasena);
			$limpia_rut = Utilidades::limpiaRut($inputRut);

			$grabar = $this->insert_query("INSERT INTO usuario_cli(us_cli_tipoUsuario, us_cli_nombre, us_cli_nick, us_cli_pass, us_cli_rut, us_cli_sucursal, us_cli_mail, us_cli_estado) 
				   						   VALUES('$inputTipoUsuario', '$inputNombre', '$limpia_rut', '$encrip', '$limpia_rut', '$inputSucursal', '$inputEmail', 1)");

			if($grabar){
				return TRUE;
			}else{
				return FALSE;
			}
		}

		public function editar_usuario($idUsuario, $inputNombre, $inputRut, $inputEmail, $inputContrasena, $inputSucursal, $inputTipoUsuario, $cambia_clave){

			$limpia_rut = Utilidades::limpiaRut($inputRut);

			if($cambia_clave == 0){
				$grabar = $this->update_query("UPDATE usuario_cli 
					   						   SET    us_cli_tipoUsuario 	= '$inputTipoUsuario', 
					   						   		  us_cli_nombre 		= '$inputNombre', 
					   						   		  us_cli_nick 			= '$limpia_rut', 
					   						   		  us_cli_rut 			= '$limpia_rut', 
					   						   		  us_cli_sucursal 		= '$inputSucursal', 
					   						   		  us_cli_mail 			= '$inputEmail'
					   						   WHERE  us_cli_id 			= $idUsuario");
			}else{
				$encrip 	 = md5($inputContrasena);
				$grabar = $this->update_query("UPDATE usuario_cli 
					   						   SET    us_cli_tipoUsuario 	= '$inputTipoUsuario', 
					   						   		  us_cli_nombre 		= '$inputNombre', 
					   						   		  us_cli_nick 			= '$limpia_rut', 
					   						   		  us_cli_rut 			= '$limpia_rut',
					   						   		  us_cli_pass 			= '$encrip',
					   						   		  us_cli_sucursal 		= '$inputSucursal', 
					   						   		  us_cli_mail 			= '$inputEmail'
					   						   WHERE  us_cli_id 			= $idUsuario");
			}


			if($grabar){
				return TRUE;
			}else{
				return FALSE;
			}
		}

		public function quitar_usuario($idUsuario){
			$grabar = $this->update_query("UPDATE usuario_cli 
				   						   SET    us_cli_estado 	    = 0
				   						   WHERE  us_cli_id 			= $idUsuario");


			if($grabar){
				return TRUE;
			}else{
				return FALSE;
			}
		}

		public function traer_editar_usuario($idUsuario){
			$recursos = new Recursos();
			$html 	  = '';

			$sql  = $this->selectQuery("SELECT * FROM usuario_cli
	    								WHERE         us_cli_id = $idUsuario");

			for ($i=0; $i < count($sql); $i++) { 
				$html .= '<div class="row">
					        <div class="col-lg-5 mb-2">
					          <label for="inputNombre"><b>Nombre</b></label>
					          <input type="text" class="form-control shadow" id="inputNombre" placeholder="Nombre" autocomplete="off" value="'.$sql[$i]['us_cli_nombre'].'">
					        </div>
					        <div class="col-lg-5 mb-2">
					            <label for="inputNombre"><b>Rut</b>&nbsp;&nbsp;&nbsp;<span id="validar_rut"></span></label>
					            <input type="text" class="form-control shadow" id="inputRut" placeholder="Rut" autocomplete="off" value="'.$sql[$i]['us_cli_rut'].'">
					        </div>
					        <div class="col-lg-5 mb-2">
					          <label for="inputSueldo"><b>E-Mail:</b></label>
					          <input type="text" class="form-control shadow" id="inputEmail" placeholder="Escribir E-Mail" value="'.$sql[$i]['us_cli_mail'].'">
					        </div>
					        <div class="col-lg-5 mb-2">
					        	<label for="inputSueldo"><b>cambiar Contraseña ?:</b></label>
					        	<select name="cambia_clave" id="cambia_clave" class="form-select shadow" onclick="cambia_clave()">
									<option value="0">NO</option>
									<option value="1">SI</option>
								</select>
					        </div>
					        <div class="col-lg-8 mb-2" style="display:none;" id="contrasena">
					          <label for="inputCargo"><b>Contrase&ntilde;a</b></label>
					          <input type="password" class="form-control shadow" id="inputContrasena" placeholder="Escribir Cargo" autocomplete="off">
					        </div>
					        <div class="col-lg-5 mb-2">
					          <label for="inputCategoria"><b>Sucursal</b></label>
					            '.$recursos->select_sucursales($sql[$i]['us_cli_sucursal']).'
					        </div>
					        <div class="col-lg-5 mb-2">
					          <label for="inputIngreso"><b>Tipo Usuario</b></label>
					          '.$recursos->select_tipo_usuario($sql[$i]['us_cli_tipoUsuario']).'
					        </div>
					        <div class="col-lg-5 mb-2">
					          <label for="inputTipo">&nbsp;</label>
					          <button type="button" id="grabar" class="btn btn-primary form-control shadow" onclick="editar_usuario('.$sql[$i]['us_cli_id'].')">Grabar <i class="bi bi-save"></i></button>
					        </div>
				      	</div>';
			}

			return $html;
		}

		public function grabar_sucursal($inputNombre){
			$grabar = $this->insert_query("INSERT INTO sucursales(suc_nombre, suc_estado) 
				   						   VALUES('$inputNombre', 1)");

			if($grabar){
				return TRUE;
			}else{
				return FALSE;
			}
		}

		public function editar_sucursal($idSucursal, $inputNombre){
			$grabar = $this->update_query("UPDATE sucursales 
				   						   SET    suc_nombre 	    = '$inputNombre'
				   						   WHERE  suc_id 			= $idSucursal");

			if($grabar){
				return TRUE;
			}else{
				return FALSE;
			}
		}

		public function desactivar_sucursal($idSucursal){
			$grabar = $this->update_query("UPDATE sucursales 
				   						   SET    suc_estado 	    = 0
				   						   WHERE  suc_id 			= $idSucursal");

			if($grabar){
				return TRUE;
			}else{
				return FALSE;
			}
		}

		public function traer_editar_sucursal($idSucursal){
			$recursos = new Recursos();
			$html 	  = '';

			$sql  = $this->selectQuery("SELECT * FROM sucursales
	    								WHERE         suc_id = $idSucursal");

			for ($i=0; $i < count($sql); $i++) { 
				$html .= '<div class="row">
					        <div class="col-lg-5 mb-2">
					          <label for="inputNombre"><b>Nombre</b></label>
					          <input type="text" class="form-control shadow" id="inputNombre" placeholder="Nombre" autocomplete="off" value="'.$sql[$i]['suc_nombre'].'">
					        </div>
					        <div class="col-lg-5 mb-2">
					          <label for="inputTipo">&nbsp;</label>
					          <button type="button" id="grabar" class="btn btn-primary form-control shadow" onclick="editar_sucursal('.$sql[$i]['suc_id'].')">Grabar <i class="bi bi-save"></i></button>
					        </div>
				      	</div>';
			}

			return $html;
		}

		public function traer_editar_empresa(){
			$html 	  = '';

			$sql  = $this->selectQuery("SELECT * FROM empresa");

			for ($i=0; $i < count($sql); $i++) { 
				$html .= '<div class="row">
					        <div class="col-lg-5 mb-2">
					          <label for="inputNombre"><b>Razón Social</b></label>
					          <input type="text" class="form-control shadow" id="inputRazonSocial" placeholder="Nombre" autocomplete="off" value="'.$sql[$i]['emp_razonsocial'].'">
					        </div>
					        <div class="col-lg-5 mb-2">
					          <label for="inputNombre"><b>Rut</b></label>
					          <input type="text" class="form-control shadow" id="inputRut" placeholder="Nombre" autocomplete="off" value="'.$sql[$i]['emp_rut'].'">
					        </div>
					        <div class="col-lg-5 mb-2">
					          <label for="inputNombre"><b>Dirección</b></label>
					          <input type="text" class="form-control shadow" id="inputDireccion" placeholder="Nombre" autocomplete="off" value="'.$sql[$i]['emp_direccion'].'">
					        </div>
					        <div class="col-lg-5 mb-2">
					          <label for="inputTipo">&nbsp;</label>
					          <button type="button" id="grabar" class="btn btn-primary form-control shadow" onclick="editar_empresa()">Grabar <i class="bi bi-save"></i></button>
					        </div>
				      	</div>';
			}

			return $html;
		}

		public function editar_empresa($inputRazonSocial, $inputRut, $inputDireccion){
			$grabar = $this->update_query("UPDATE empresa 
				   						   SET    emp_razonsocial	= '$inputRazonSocial',
											      emp_rut			= '$inputRut',
											      emp_direccion 	= '$inputDireccion'");

			if($grabar){
				return TRUE;
			}else{
				return FALSE;
			}
		}

		public function grabar_nuevo_logo($inputNombre){
			$grabar = $this->update_query("UPDATE parametros 
				   						   SET    par_logo	= '$inputNombre'");

			if($grabar){
				return TRUE;
			}else{
				return FALSE;
			}
		}

		public function listar_localidades(){
		    $recursos = new Recursos();
		    $sql  	  = $this->selectQuery("SELECT * FROM cl_comuna
		    								WHERE         estado = 1");

			$html     = '<table width="98%" align="center" id="listado_localidades" class="table table-hover">
							<thead>
								<tr class="plomo">
									<th align="left">Nombre</th>
								</tr>
							</thead>
							<tbody>';

			for ($i=0; $i < count($sql); $i++) { 
				$html   .= '<tr id="cambiazo2">
								<td>'.$sql[$i]['nombre'].'</td>
							</tr>';
			}

			$html   .= '</tbody>';

			$html   .= '</table>';

			return $html;
		}

		public function grabar_localidad($inputNombre){
			$this->insert_query("INSERT INTO cl_comuna(nombre, estado) 
				   				 VALUES('$inputNombre', 1)");
		}

	
	   /**  FIN PARAMETROS   **/

	} // END CLASS
?>