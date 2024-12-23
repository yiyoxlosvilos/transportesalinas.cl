<?php
	date_default_timezone_set("America/Santiago");
	require_once __dir__."/../../../modelo/obtener_datos.php";


	$mvc_datos   = new GetDatos();

	$usr         = $_POST["usr"];
	$pass        = $_POST["pass"];
	$rec         = $_POST["rec"];

	if(isset($usr) && isset($pass)){

		$result = $mvc_datos->selectQuery("SELECT * FROM usuario_cli 
										   WHERE 		 us_cli_nick     = '".$usr."'
										   AND 			 us_cli_pass 	 = md5('".$pass."') 
										   AND 			 us_cli_estado   = 1");

			if(count($result) > 0){
				
				if(!isset($_SESSION)){
					session_start();
				}

				$_SESSION["IDUSER"]     = $result[0]["us_cli_id"];
				$_SESSION["TIPOUSER"]   = $result[0]["us_cli_tipoUsuario"];
				$_SESSION["USRCORREO"]  = $result[0]["us_cli_mail"];
				$_SESSION["NOMBREUSER"] = $result[0]["us_cli_nombre"];
				$_SESSION["IDSUCURSAL"] = $result[0]["us_cli_sucursal"];
				$_SESSION["IDEMPRESA"]  = $result[0]["us_cli_empresa"];
				
				if($result[0]["us_cli_tipoUsuario"] == 1 OR $result[0]["us_cli_tipoUsuario"] == 2){

					//sleep(60);

					if($result[0]["us_cli_tipoUsuario"] == 1){
						$info   = array('success' => true, 
									'msg' 	  => "Usuario Correcto", 
									'link' 	  => controlador::$rutaAPP."viajes");
					}elseif($result[0]["us_cli_tipoUsuario"] == 2){
						$info   = array('success' => true, 
									'msg' 	  => "Usuario Correcto", 
									'link' 	  => controlador::$rutaAPP."viajes");
					}
					
				}

			}else{
				$info = array('success' => false, 'msg' => "USUARIO DESCONOCIDO");
			}
	} else {
		$info = array('success' => false, 'msg' => "SIN DATOS PARA COMPARAR");
	}

	echo json_encode($info);
?>