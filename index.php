<?php
	ini_set('sql_mode', '');
	date_default_timezone_set("America/Santiago");
	require_once __dir__."/app/controlador/controlador.php";

	$mvc 		= new controlador();

	if($mvc->iniciar_sesion()){
		
		if(isset($_GET["action"]) && $_SESSION["TIPOUSER"] == 1){ //admin
			switch($_GET["action"]){
				case 'dashboard':
					$mvc->dashboard();
					break;
				case 'productos':
					$mvc->productos();
					break;
				case 'bodega':
					$mvc->bodega();
					break;
				case 'reporteria':
					$mvc->reporteria();
					break;
				case 'finanzas':
					$mvc->finanzas();
					break;
				case 'rrhh':
					$mvc->rrhh();
					break;
				case 'parametros':
					$mvc->parametros();
					break;
				case 'centro_costo':
					$mvc->centro_costo();
					break;
				case 'bitacora':
					$mvc->bitacora();
					break;
				case 'cerrar':
					$mvc->cerrar_sesion();
					break;
				default:
					$mvc->login();
					break;
			}
		}elseif(isset($_GET["action"]) && $_SESSION["TIPOUSER"] == 2){ //usuario
			switch($_GET["action"]){
				case 'centro_costo':
					$mvc->centro_costo();
				case 'cerrar':
					$mvc->cerrar_sesion();
					break;
				default:
					$mvc->login();
					break;
			}
		}else{
			$mvc->login();		
		}

	}else{

		if(isset($_GET["action"])){
			switch($_GET["action"]){

				//ACCIONES SIN INICIAR SESION
				case 'login':
					$mvc->login();
					break;
						
				case 'validar':
					$mvc->validar();
					break;
				case 'ruta':
					$mvc->ruta();
					break;					
				default:
					$mvc->login();
					break;
			}
		} else {
			$mvc->login();
		}

	}
?>