<?php 
	date_default_timezone_set("America/Santiago");
	require_once __dir__."/../../../controlador/controlador.php";
	require_once __dir__."/../../../controlador/parametrosControlador.php";
	require_once __dir__."/../../../controlador/recursosControlador.php";
	require_once __dir__."/../../../controlador/utilidadesControlador.php";
	
	$mvc2       = new controlador();
	$parametros = new Parametros();

	$accion      = $_REQUEST['accion'];

	switch ($accion) {
		case 'grabar_usuario':
			$inputNombre      = $_REQUEST['inputNombre'];
			$inputRut         = $_REQUEST['inputRut'];
			$inputEmail       = $_REQUEST['inputEmail'];
			$inputContrasena  = $_REQUEST['inputContrasena'];
			$inputSucursal    = $_REQUEST['inputSucursal'];
			$inputTipoUsuario = $_REQUEST['inputTipoUsuario'];

			$grabar 		  = $parametros->grabar_usuario($inputNombre, $inputRut, $inputEmail, $inputContrasena, $inputSucursal, $inputTipoUsuario);

			if($grabar){
				return TRUE;
			}else{
				return FALSE;
			}

			break;
		case 'editar_usuario':
			$idUsuario        = $_REQUEST['idUsuario'];
			$inputNombre      = $_REQUEST['inputNombre'];
			$inputRut         = $_REQUEST['inputRut'];
			$inputEmail       = $_REQUEST['inputEmail'];
			$inputContrasena  = $_REQUEST['inputContrasena'];
			$inputSucursal    = $_REQUEST['inputSucursal'];
			$cambia_clave     = $_REQUEST['cambia_clave'];
			$inputTipoUsuario = $_REQUEST['inputTipoUsuario'];

			$grabar 		  = $parametros->editar_usuario($idUsuario, $inputNombre, $inputRut, $inputEmail, $inputContrasena, $inputSucursal, $inputTipoUsuario, $cambia_clave);

			if($grabar){
				return TRUE;
			}else{
				return FALSE;
			}

			break;
		case 'quitar_usuario':
			$idUsuario        = $_REQUEST['idUsuario'];

			$grabar 		  = $parametros->quitar_usuario($idUsuario);

			if($grabar){
				return TRUE;
			}else{
				return FALSE;
			}

			break;
		case 'grabar_sucursal':
			$inputNombre      = $_REQUEST['inputNombre'];

			$grabar 		  = $parametros->grabar_sucursal($inputNombre);

			if($grabar){
				return TRUE;
			}else{
				return FALSE;
			}

			break;
		case 'editar_sucursal':
			$idSucursal       = $_REQUEST['idSucursal'];
			$inputNombre      = $_REQUEST['inputNombre'];

			$grabar 		  = $parametros->editar_sucursal($idSucursal, $inputNombre);

			if($grabar){
				return TRUE;
			}else{
				return FALSE;
			}

			break;
		case 'desactivar_sucursal':
			$idSucursal       = $_REQUEST['idSucursal'];

			$grabar 		  = $parametros->desactivar_sucursal($idSucursal);

			if($grabar){
				return TRUE;
			}else{
				return FALSE;
			}

			break;
		case 'editar_empresa':
			$inputRazonSocial = $_REQUEST['inputRazonSocial'];
			$inputRut         = $_REQUEST['inputRut'];
			$inputDireccion   = $_REQUEST['inputDireccion'];

			$grabar 		  = $parametros->editar_empresa($inputRazonSocial, $inputRut, $inputDireccion);

			if($grabar){
				return TRUE;
			}else{
				return FALSE;
			}

			break;
		case 'cambiar_logo':

			if ($_FILES){

				$name    			= $_FILES['file']['name'];
			    $extraer 			= explode(".", $name);
				$nombre  			= date("Ymd")."".date("Hi").".".$extraer[1];
				$destino 			= "../../../recursos/img/".$nombre;
				$tipo   			= $_FILES['file']["type"];
				$ruta_provisional   = $_FILES['file']["tmp_name"];
				$carpeta            = "../../../recursos/img/";

		        //abrir foto original
		        if($tipo == 'image/jpeg'){
		            $original       = @imagecreatefromjpeg($ruta_provisional);
		        }elseif($tipo == 'image/png'){
		            $original       = @imagecreatefrompng($ruta_provisional);
		        }else{
		            die('no se pudo generar imagen');
		        }

		        $anchoOriginal      = imagesx($original);
		        $altoOriginal       = imagesy($original);

		        $ancho              = 586;
		        $alto               = round($ancho * $altoOriginal / $anchoOriginal);
		        $calidad            = 90;

		        $copia              = imagecreatetruecolor($ancho, $alto);
		        					  imagealphablending($copia, false);
		        					  imagesavealpha($copia,true);

		        $transparent 		= imagecolorallocatealpha($copia, 255, 255, 255, 127);
		        			   		  imagefilledrectangle($copia, 0, 0, $ancho, $alto, $transparent);
		        			   		  imagecopyresampled($copia, $original, 0, 0, 0, 0, $ancho, $alto, $anchoOriginal, $altoOriginal);

		        if($tipo == "image/jpg" || $tipo =="image/jpeg"){
		            $tipoes 		= imagejpeg($copia, $carpeta."".$nombre, $calidad);
		        }elseif($tipo == "image/png"){
		            $tipoes 		= imagepng($copia, $carpeta."".$nombre);
		        }

		        //expostar y guardar
		        if ($tipoes) {

		        	$grabar 		= $parametros->grabar_nuevo_logo($nombre);

		            if($grabar){
		              return true;
		            }else{
		              return false;
		            }

		            imagedestroy($original);
		            imagedestroy($copia);
		        }else{
		        	return false;
		        }
			}else{
				return false;
			}
			break;
		case 'grabar_localidad':
			$inputNombre = $_REQUEST['inputNombre'];

			$parametros->grabar_localidad($inputNombre);

			echo '<script>
						Swal.fire({
					          title:              "** Localidad creada correctamente **",
					          showDenyButton:     false,
					          showCancelButton:   false,
					          confirmButtonText:  "OK",
					          icon:               "success",
					    }).then((result) => {
					        if (result.isConfirmed) {
					        	parent.location.reload();
					         }
					    })
					  </script>';
			break;
		default:
			break;
	}
?>