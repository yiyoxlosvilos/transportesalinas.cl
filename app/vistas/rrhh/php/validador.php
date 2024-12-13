<?php 
	date_default_timezone_set("America/Santiago");
	require_once __dir__."/../../../controlador/controlador.php";
	require_once __dir__."/../../../controlador/rrhhControlador.php";
	require_once __dir__."/../../../controlador/recursosControlador.php";
	require_once __dir__."/../../../controlador/utilidadesControlador.php";
	
	$mvc2       = new controlador();
	$rrhh   	= new Rrhh();
	$recursos  	= new Recursos();

	$accion      = $_REQUEST['accion'];

	switch ($accion) {
		case 'liquidaciones_ver':
			$ano = Utilidades::fecha_ano();
			$mes = Utilidades::fecha_mes();

			echo $rrhh->traer_liquidaciones($ano, $mes);

			echo '<script>
					$(document).ready(function() {
				    $("#productos_list").DataTable({     
					      "aLengthMenu": [[10, 20, 30, -1], [10, 20, 30, "Todos"]],
					        "iDisplayLength": 20
					       });
					});
					$(document).ready(function() {
					    $(".counter").each(function () {
					        $(this).prop("Counter",0).animate({
					            Counter: $(this).text()
					        }, {
					            duration: 1000,
					            easing: "swing",
					            step: function (now) {
					                $(this).text(number_format(now));
					            }
					        });
					    });

					    var multipleCancelButton = new Choices("#productos", {
					        removeItemButton: true,
					    }); 
					});
				  </script>';
			break;
		case 'liquidaciones_buscar':
			$ano = $_REQUEST['ano'];
			$mes = $_REQUEST['mes'];

			echo $rrhh->traer_liquidaciones($ano, $mes);
			echo '<script>
					$(document).ready(function() {
				    $("#productos_list").DataTable({     
					      "aLengthMenu": [[10, 20, 30, -1], [10, 20, 30, "Todos"]],
					        "iDisplayLength": 20
					       });
					});
				  </script>';
			break;

		case 'generar_liquidacion_sueldo':
			$idTrabajador	       	 = $_REQUEST['idTrabajador'];
			$sueldo_base 			 = $_REQUEST['sueldo_base'];
			$dias_trabajado 		 = $_REQUEST['dias_trabajado'];
			$gratifica 				 = $_REQUEST['gratifica'];
			$total_grati 			 = $_REQUEST['total_grati'];
			$hrextra 				 = $_REQUEST['hrextra'];
			$hrextra_total 			 = $_REQUEST['hrextra_total'];
			$comisiones 			 = $_REQUEST['comisiones'];
			$bonos 				     = $_REQUEST['bonos'];
			$colacion 				 = $_REQUEST['colacion'];
			$movilizacion 			 = $_REQUEST['movilizacion'];
			$afp 				     = $_REQUEST['afp'];
			$total_afp 				 = $_REQUEST['total_afp'];
			$salud 				     = $_REQUEST['salud'];
			$total_salud 			 = $_REQUEST['total_salud'];
			$isapre 				 = $_REQUEST['isapre'];
			$adicional_isapre 		 = $_REQUEST['adicional_isapre'];
			$cesantia 				 = $_REQUEST['cesantia'];
			$apv 				     = $_REQUEST['apv'];
			$anticipos 				 = $_REQUEST['anticipos'];
			$seguro_vida 			 = $_REQUEST['seguro_vida'];
			$caja_compensacion 		 = $_REQUEST['caja_compensacion'];
			$monto_caja_compensacion = $_REQUEST['monto_caja_compensacion'];
			$impuesto_unico          = $_REQUEST['impuesto_unico'];
			$haber_tot2 			 = $_REQUEST['haber_tot2'];
			$haber_dsc2 			 = $_REQUEST['haber_dsc2'];
			$haber_liq2 			 = $_REQUEST['haber_liq2'];

			$grabar 				 = $rrhh->generar_liquidacion_sueldo($idTrabajador, $sueldo_base, $dias_trabajado, $gratifica, $total_grati, $hrextra, $hrextra_total, $comisiones, $bonos, $colacion, $movilizacion, $afp, $total_afp, $salud, $total_salud, $isapre, $adicional_isapre, $cesantia, $apv, $anticipos, $seguro_vida, $caja_compensacion, $monto_caja_compensacion, $impuesto_unico, $haber_tot2, $haber_dsc2, $haber_liq2);

			if($grabar){
				echo "<script>
						Swal.fire({
					          title:              'Liquidación Generada correctamente',
					          confirmButtonText:  'OK',
					          icon:               'success',
					    }).then((result) => {
					        if (result.isConfirmed) {
					           finalizado_liquidaciones(".$idTrabajador.");
					           parent.liquidaciones_ver();
					        }
					    })
					  </script>";
			}else{
				echo "<script>
						Swal.fire({
					          title:              'Error',
					          confirmButtonText:  'OK',
					          icon:               'error',
					    }).then((result) => {
					        if (result.isConfirmed) {
					           parent.reload();
					        }
					    })
					  </script>";
			}

			break;
		case 'finalizado_liquidaciones':
			$idTrabajador = $_REQUEST['idTrabajador'];
			$mes 		  = Utilidades::fecha_mes();
			$ano 		  = Utilidades::fecha_ano();

			echo $rrhh->data_finalizar_liquidacion($idTrabajador, $mes, $ano);
			break;
		case 'grabar_trabajador':
			$inputNombre 		= $_REQUEST['inputNombre'];
			$inputRut 			= $_REQUEST['inputRut'];
			$inputTelefono 		= isset($_REQUEST['inputTelefono']) ? $_REQUEST['inputTelefono'] : "0";
			$inputEmail 		= isset($_REQUEST['inputEmail']) ? $_REQUEST['inputEmail'] : "nn";
			$inputSueldo 		= $_REQUEST['inputSueldo'];
			$inputCargo 		= $_REQUEST['inputCargo'];
			$inputEmpresa 		= $_REQUEST['inputEmpresa'];
			$inputTipoContrato 	= $_REQUEST['inputTipoContrato'];
			$inputIngreso 		= $_REQUEST['inputIngreso'];
			$inputFin 			= isset($_REQUEST['inputFin']) ? $_REQUEST['inputFin'] : Utilidades::fecha_hoy();

			$grabar = $rrhh->grabar_trabajador($inputNombre, $inputRut, $inputTelefono, $inputEmail, $inputSueldo, $inputCargo, $inputEmpresa, $inputTipoContrato, $inputIngreso, $inputFin);

			echo $grabar;
			break;
		case 'traer_editar_trabajador':
			$idTrabajador 		= $_REQUEST['idTrabajador'];

			$grabar = $rrhh->traer_editar_trabajador($idTrabajador);
		
			echo $grabar;
			break;
		case 'editar_trabajador':
			$idTrabajador 		= $_REQUEST['idTrabajador'];
			$inputNombre 		= $_REQUEST['inputNombre'];
			$inputRut 			= $_REQUEST['inputRut'];
			$inputTelefono 		= $_REQUEST['inputTelefono'];
			$inputEmail 		= $_REQUEST['inputEmail'];
			$inputSueldo 		= $_REQUEST['inputSueldo'];
			$inputCargo 		= $_REQUEST['inputCargo'];
			$inputEmpresa 		= $_REQUEST['inputEmpresa'];
			$inputPrestacion 	= $_REQUEST['inputPrestacion'];
			$inputTipoContrato 	= $_REQUEST['inputTipoContrato'];
			$inputIngreso 		= $_REQUEST['inputIngreso'];
			$inputFin 			= $_REQUEST['inputFin'];

			$grabar = $rrhh->editar_trabajador($inputNombre, $inputRut, $inputTelefono, $inputEmail, $inputSueldo, $inputCargo, $inputEmpresa, $inputPrestacion, $inputTipoContrato, $inputIngreso, $inputFin, $idTrabajador);
		
			if ($grabar > 0) {
				return true;
			}else{
				return false;
			}
			break;
		case 'traer_nuevo_documento':
			$html = ' <div class="col-lg-15 mb-2">
				        <label for="inputTitulo"><b>Titulo</b></label>
				        <input type="text" class="form-control shadow" id="inputTitulo" placeholder="Titulo" autocomplete="off">
				      </div>
					  <div dir=rtl class="file-loading">
		    			<input id="input-b8" name="input-b8[]" multiple type="file">
					  </div>
					  <script>
						$(document).ready(function() {
							$("#input-b8").fileinput({
								tl: true,
								dropZoneEnabled: false,
								allowedFileExtensions: ["jpg", "png", "pdf"]
							});
						});
					  </script>';

			echo $html;
			break;
		case 'subir_documento_trabajador':
			$inputTitulo  = $_REQUEST['inputTitulo'];
			$idTrabajador = $_REQUEST['idTrabajador'];

			if ($_FILES){

				$name    			= $_FILES['file']['name'];
			    $extraer 			= explode(".", $name);
				$nombre  			= date("Ymd")."".date("Hi").".".$extraer[1];
				$destino 			= "../../../repositorio/documento_trabajador/".$nombre;
				$tipo   			= $_FILES['file']["type"];
				$ruta_provisional   = $_FILES['file']["tmp_name"];
				$carpeta            = "../../../repositorio/documento_trabajador/";

				if(move_uploaded_file($_FILES['file']['tmp_name'], $destino)){
					$rrhh->grabar_insertar_documento($nombre, $inputTitulo, $idTrabajador);
				
				}else{
			  		return false;
			  	}
			}else{
				return false;
			}
			break;
		case 'quitar_documento_trabajador':
			$idDocu = $_REQUEST['idDocu'];

			$grabar = $rrhh->quitar_documento_trabajador($idDocu);
		
			if ($grabar > 0) {
				return true;
			}else{
				return false;
			}
			break;
		case 'impuesto_unico':
			$sueldo_base 	= $_REQUEST['sueldo_base'];
			$impuesto_unico = $rrhh->calculo_impuesto_unico($sueldo_base);
			
			$html = '<td align="left" >Impuesto Unico.</td>
	                 <td align="left">
	                    <input type="number" class="form-control shadow" name="impuesto_unico" id="impuesto_unico" value="'.$impuesto_unico.'" readonly="readonly"  onchange="simular_sueldo()">
	                    <script>simular_sueldo();</script>
	                 </td>';

            echo $html;
			break;
		case 'vacaciones_ver':
			$ano = Utilidades::fecha_ano();
			$mes = Utilidades::fecha_mes();

			echo $rrhh->traer_vacaciones($ano, $mes);

			echo '<script>
					$(document).ready(function() {
				    $("#vacaciones_list").DataTable({     
					      "aLengthMenu": [[5, 10, 20, 30, -1], [5, 10, 20, 30, "Todos"]],
					        "iDisplayLength": 10
					       });
					});
					$(document).ready(function() {
				    $("#solicitudes_trabajadores").DataTable({     
					      "aLengthMenu": [[5, 10, 20, 30, -1], [5, 10, 20, 30, "Todos"]],
					        "iDisplayLength": 10
					       });
					});
				  </script>';
			break;
		case 'grabar_permiso':
			$mvc2->iniciar_sesion();
  			$idUser      	= $_SESSION['IDUSER'];
			$idTrabajador 	= $_REQUEST['idTrabajador'];
			$tipo_permiso 	= $_REQUEST['tipo_permiso'];
			$desde 			= $_REQUEST['desde'];
			$hasta 			= $_REQUEST['hasta'];
			$dias 			= $_REQUEST['dias'];
			$comentario 	= $_REQUEST['comentario'];

			$grabar = $rrhh->grabar_permiso($tipo_permiso, $desde, $hasta, $dias, $comentario, $idTrabajador, $idUser);
		
			if ($grabar > 0) {
				return true;
			}else{
				return false;
			}
			break;
		case 'quitar_solicitud':
			$idSolicitud = $_REQUEST['idSolicitud'];
			
			$grabar = $rrhh->quitar_solicitud($idSolicitud);
		
			if ($grabar > 0) {
				return true;
			}else{
				return false;
			}
			break;
		case 'mostrar_solicitudes':
			$mes = $_REQUEST['mes_permiso'];
			$ano = $_REQUEST['ano'];

			echo $rrhh->listar_solicitudes_vacaciones($ano, $mes);
			echo '<script>
					$(document).ready(function() {
				    $("#solicitudes_trabajadores").DataTable({     
					      "aLengthMenu": [[5, 10, 20, 30, -1], [5, 10, 20, 30, "Todos"]],
					        "iDisplayLength": 10
					       });
					});
				  </script>';
			break;
		case 'finiquitos_ver':
			$ano = Utilidades::fecha_ano();
			$mes = Utilidades::fecha_mes();

			echo $rrhh->finiquitos_ver($ano, $mes);

			echo '<script>
					$(document).ready(function() {
				    $("#vacaciones_list").DataTable({     
					      "aLengthMenu": [[5, 10, 20, 30, -1], [5, 10, 20, 30, "Todos"]],
					        "iDisplayLength": 10
					       });
					});
					$(document).ready(function() {
				    $("#solicitudes_trabajadores").DataTable({     
					      "aLengthMenu": [[5, 10, 20, 30, -1], [5, 10, 20, 30, "Todos"]],
					        "iDisplayLength": 10
					       });
					});
				  </script>';
			break;
		case 'generar_finiquito_trabajador':
			$idTrabajador                = $_REQUEST['idTrabajador'];
			$fecha_inicio 				 = $_REQUEST['fecha_inicio'];
			$fecha_final 				 = $_REQUEST['fecha_final'];
			$dias_trabajados 			 = $_REQUEST['dias_trabajados'];
			$factor_dia 				 = $_REQUEST['factor_dia'];
			$ano_trabajados 			 = $_REQUEST['ano_trabajados'];
			$vacaciones_tomadas 		 = $_REQUEST['vacaciones_tomadas'];
			$vacas_pendientes 			 = $_REQUEST['vacas_pendientes'];
			$dias_inabiles 				 = $_REQUEST['dias_inabiles'];
			$tot_vacas_pendientes 		 = $_REQUEST['tot_vacas_pendientes'];
			$tot_concepto_vacaciones 	 = $_REQUEST['tot_concepto_vacaciones'];
			$sueldo_base 				 = $_REQUEST['sueldo_base'];
			$bono_pendiente 			 = $_REQUEST['bono_pendiente'];
			$bonos_3_meses 				 = $_REQUEST['bonos_3_meses'];
			$renumeracion_diaria 		 = $_REQUEST['renumeracion_diaria'];
			$gratificacion 				 = $_REQUEST['gratificacion'];
			$bono_colacion 				 = $_REQUEST['bono_colacion'];
			$bono_movilizacion 			 = $_REQUEST['bono_movilizacion'];
			$total_sueldo_base 			 = $_REQUEST['total_sueldo_base'];
			$ano_servicio 				 = $_REQUEST['ano_servicio'];
			$previo_aviso 				 = $_REQUEST['previo_aviso'];
			$tot_vacas_pendientes_propor = $_REQUEST['tot_vacas_pendientes_propor'];
			$sub_total 					 = $_REQUEST['sub_total'];
			$total_haberes_mes 			 = $_REQUEST['total_haberes_mes'];
			$total_desctos_mes 			 = $_REQUEST['total_desctos_mes'];
			$total_pagar 				 = $_REQUEST['total_pagar'];
			$comentario 				 = $_REQUEST['comentario'];

			$grabar = $rrhh->grabar_finiquito_trabajador($idTrabajador, $fecha_inicio, $fecha_final, $dias_trabajados, $factor_dia, $ano_trabajados, $vacaciones_tomadas, $vacas_pendientes, $dias_inabiles, $tot_vacas_pendientes, $tot_concepto_vacaciones, $sueldo_base, $bono_pendiente, $bonos_3_meses, $renumeracion_diaria, $gratificacion, $bono_colacion, $bono_movilizacion, $total_sueldo_base, $ano_servicio, $previo_aviso, $tot_vacas_pendientes_propor, $sub_total, $total_haberes_mes, $total_desctos_mes, $total_pagar, $comentario);

			if($grabar){
				echo "<script>
						Swal.fire({
					          title:              'Liquidación Generada correctamente',
					          confirmButtonText:  'OK',
					          icon:               'success',
					    }).then((result) => {
					        if (result.isConfirmed) {
					           finalizar_finiquito(".$idTrabajador.");
					           parent.finiquitos_ver();
					        }
					    })
					  </script>";
			}else{
				echo "<script>
						Swal.fire({
					          title:              'Error',
					          confirmButtonText:  'OK',
					          icon:               'error',
					    }).then((result) => {
					        if (result.isConfirmed) {
					           location.reload();
					        }
					    })
					  </script>";
			}
			break;
		case 'finiquitos_buscar':
			$ano = $_REQUEST['ano'];
			$mes = $_REQUEST['mes_finiquito'];

			echo $rrhh->listar_finiquitos($ano, $mes);

			echo '<script>
					$(document).ready(function() {
				    $("#solicitudes_trabajadores").DataTable({     
					      "aLengthMenu": [[5, 10, 20, 30, -1], [5, 10, 20, 30, "Todos"]],
					        "iDisplayLength": 10
					       });
					});
				  </script>';
			break;
		case 'grabar_prevision':
			$nombre 	= $_REQUEST['nombre'];
			$descuentos = $_REQUEST['descuentos'];

			$grabar 	= $rrhh->grabar_prevision($nombre, $descuentos);

			if($grabar){
				echo "<script>
						Swal.fire({
					          title:              'Prevision grabada correctamente',
					          confirmButtonText:  'OK',
					          icon:               'success',
					    }).then((result) => {
					        if (result.isConfirmed) {
					           parent.configuraciones_ver();
					           location.reload();
					        }
					    })
					  </script>";
			}else{
				echo "<script>
						Swal.fire({
					          title:              'Error',
					          confirmButtonText:  'OK',
					          icon:               'error',
					    }).then((result) => {
					        if (result.isConfirmed) {
					           location.reload();
					        }
					    })
					  </script>";
			}

			break;
		case 'grabar_pensiones':
			$nombre 	= $_REQUEST['nombre'];
			$descuentos = $_REQUEST['descuentos'];

			$grabar 	= $rrhh->grabar_pensiones($nombre, $descuentos);

			if($grabar){
				echo "<script>
						Swal.fire({
					          title:              'Pension grabada correctamente',
					          confirmButtonText:  'OK',
					          icon:               'success',
					    }).then((result) => {
					        if (result.isConfirmed) {
					           parent.configuraciones_ver();
					           location.reload();
					        }
					    })
					  </script>";
			}else{
				echo "<script>
						Swal.fire({
					          title:              'Error',
					          confirmButtonText:  'OK',
					          icon:               'error',
					    }).then((result) => {
					        if (result.isConfirmed) {
					           location.reload();
					        }
					    })
					  </script>";
			}

			break;
		case 'grabar_isapre':
			$nombre 	= $_REQUEST['nombre'];
			$descuentos = $_REQUEST['descuentos'];

			$grabar 	= $rrhh->grabar_isapre($nombre);

			if($grabar){
				echo "<script>
						Swal.fire({
					          title:              'Isapre grabada correctamente',
					          confirmButtonText:  'OK',
					          icon:               'success',
					    }).then((result) => {
					        if (result.isConfirmed) {
					           parent.configuraciones_ver();
					           location.reload();
					        }
					    })
					  </script>";
			}else{
				echo "<script>
						Swal.fire({
					          title:              'Error',
					          confirmButtonText:  'OK',
					          icon:               'error',
					    }).then((result) => {
					        if (result.isConfirmed) {
					           location.reload();
					        }
					    })
					  </script>";
			}

			break;
		case 'grabar_caja':
			$nombre 	= $_REQUEST['nombre'];
			$descuentos = $_REQUEST['descuentos'];

			$grabar 	= $rrhh->grabar_caja($nombre);

			if($grabar){
				echo "<script>
						Swal.fire({
					          title:              'Caja grabada correctamente',
					          confirmButtonText:  'OK',
					          icon:               'success',
					    }).then((result) => {
					        if (result.isConfirmed) {
					           parent.configuraciones_ver();
					           location.reload();
					        }
					    })
					  </script>";
			}else{
				echo "<script>
						Swal.fire({
					          title:              'Error',
					          confirmButtonText:  'OK',
					          icon:               'error',
					    }).then((result) => {
					        if (result.isConfirmed) {
					           location.reload();
					        }
					    })
					  </script>";
			}

			break;
		case 'traer_editar_prevision':
			$id = $_REQUEST['id'];

			echo $rrhh->traer_editar_prevision($id);
			break;
		case 'grabar_editar_prevision':
			$id 		= $_REQUEST['id'];
			$nombre 	= $_REQUEST['nombre'];
			$descuentos = $_REQUEST['descuentos'];

			$grabar     = $rrhh->grabar_editar_prevision($id, $nombre, $descuentos);

			if($grabar){
				echo "<script>
						Swal.fire({
					          title:              'Prevision editada correctamente',
					          confirmButtonText:  'OK',
					          icon:               'success',
					    }).then((result) => {
					        if (result.isConfirmed) {
					           configuraciones_ver();
					        }
					    })
					  </script>";
			}else{
				echo "<script>
						Swal.fire({
					          title:              'Error',
					          confirmButtonText:  'OK',
					          icon:               'error',
					    }).then((result) => {
					        if (result.isConfirmed) {
					           configuraciones_ver();
					        }
					    })
					  </script>";
			}

			break;
		case 'quitar_prevision':
			$id = $_REQUEST['id'];
			
			$grabar = $rrhh->quitar_prevision($id);
		
			if ($grabar > 0) {
				return true;
			}else{
				return false;
			}
			break;
		case 'traer_editar_pensiones':
			$id = $_REQUEST['id'];

			echo $rrhh->traer_editar_pensiones($id);
			break;
		case 'grabar_editar_pension':
			$id 		= $_REQUEST['id'];
			$nombre 	= $_REQUEST['nombre'];
			$descuentos = $_REQUEST['descuentos'];

			$grabar     = $rrhh->grabar_editar_pensiones($id, $nombre, $descuentos);

			if($grabar){
				echo "<script>
						Swal.fire({
					          title:              'Pension editada correctamente',
					          confirmButtonText:  'OK',
					          icon:               'success',
					    }).then((result) => {
					        if (result.isConfirmed) {
					           configuraciones_ver();
					        }
					    })
					  </script>";
			}else{
				echo "<script>
						Swal.fire({
					          title:              'Error',
					          confirmButtonText:  'OK',
					          icon:               'error',
					    }).then((result) => {
					        if (result.isConfirmed) {
					           configuraciones_ver();
					        }
					    })
					  </script>";
			}
			break;
		case 'quitar_pension':
			$id = $_REQUEST['id'];
			
			$grabar = $rrhh->quitar_pension($id);
		
			if ($grabar > 0) {
				return true;
			}else{
				return false;
			}
			break;
		case 'traer_editar_isapre':
			$id = $_REQUEST['id'];

			echo $rrhh->traer_editar_isapre($id);
			break;
		case 'grabar_editar_isapre':
			$id 		= $_REQUEST['id'];
			$nombre 	= $_REQUEST['nombre'];

			$grabar     = $rrhh->grabar_editar_isapre($id, $nombre);

			if($grabar){
				echo "<script>
						Swal.fire({
					          title:              'Isapre editada correctamente',
					          confirmButtonText:  'OK',
					          icon:               'success',
					    }).then((result) => {
					        if (result.isConfirmed) {
					           configuraciones_ver();
					        }
					    })
					  </script>";
			}else{
				echo "<script>
						Swal.fire({
					          title:              'Error',
					          confirmButtonText:  'OK',
					          icon:               'error',
					    }).then((result) => {
					        if (result.isConfirmed) {
					           configuraciones_ver();
					        }
					    })
					  </script>";
			}
			break;
		case 'quitar_isapre':
			$id = $_REQUEST['id'];
			
			$grabar = $rrhh->quitar_isapre($id);
		
			if ($grabar > 0) {
				return true;
			}else{
				return false;
			}
			break;
		case 'traer_editar_caja':
			$id = $_REQUEST['id'];

			echo $rrhh->traer_editar_caja($id);
			break;
		case 'grabar_editar_caja':
			$id 		= $_REQUEST['id'];
			$nombre 	= $_REQUEST['nombre'];

			$grabar     = $rrhh->grabar_editar_caja($id, $nombre);

			if($grabar){
				echo "<script>
						Swal.fire({
					          title:              'Caja editada correctamente',
					          confirmButtonText:  'OK',
					          icon:               'success',
					    }).then((result) => {
					        if (result.isConfirmed) {
					           configuraciones_ver();
					        }
					    })
					  </script>";
			}else{
				echo "<script>
						Swal.fire({
					          title:              'Error',
					          confirmButtonText:  'OK',
					          icon:               'error',
					    }).then((result) => {
					        if (result.isConfirmed) {
					           configuraciones_ver();
					        }
					    })
					  </script>";
			}
			break;
		case 'quitar_caja':
			$id = $_REQUEST['id'];
			
			$grabar = $rrhh->quitar_caja($id);
		
			if ($grabar > 0) {
				return true;
			}else{
				return false;
			}
			break;
		case 'editar_sueldo_minimo':
			$sueldo_mini = $_REQUEST['sueldo_mini'];

			$grabar 	 = $rrhh->editar_sueldo_minimo($sueldo_mini);
		
			if ($grabar > 0) {
				return true;
			}else{
				return false;
			}
			break;
		case 'editar_uf':
			$sueldo_uf_mini = $_REQUEST['sueldo_uf_mini'];

			$grabar 		= $rrhh->editar_uf($sueldo_uf_mini);
		
			if ($grabar > 0) {
				return true;
			}else{
				return false;
			}
			break;
		case 'editar_utm':
			$sueldo_utm_mini = $_REQUEST['sueldo_utm_mini'];
			$grabar = $rrhh->editar_utm($sueldo_utm_mini);
		
			if ($grabar > 0) {
				return true;
			}else{
				return false;
			}
			break;
		default:
			break;
	}
?>