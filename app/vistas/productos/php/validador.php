<?php 
	date_default_timezone_set("America/Santiago");
	require_once __dir__."/../../../controlador/controlador.php";
	require_once __dir__."/../../../controlador/productosControlador.php";
	require_once __dir__."/../../../controlador/recursosControlador.php";
	
	$mvc2        = new controlador();
	$productos   = new Productos();
	$recursos    = new Recursos();

	$accion      = $_REQUEST['accion'];

	switch ($accion) {
		case 'productos_ver':
			$estado = $_REQUEST['estado'];

			echo $productos->traer_productos_table($estado);
			echo '<script>
					$(document).ready(function() {
				    $("#productos_list").DataTable({     
					      "aLengthMenu": [[10, 20, 30, -1], [10, 20, 30, "Todos"]],
					        "iDisplayLength": 20
					       });
					});
				  </script>';
			break;
		case 'productos_grabar':
			$inputCodigo 	= $_REQUEST['inputCodigo'];
			$inputNombre 	= $_REQUEST['inputNombre'];
			$inputMarca 	= $_REQUEST['inputMarca'];
			$inputCategoria = $_REQUEST['inputCategoria'];
			$inputPatente 	= $_REQUEST['inputPatente'];
			$inputSucursal 	= $_REQUEST['inputSucursal'];

			$grabar         = $productos->grabar_productos($inputCodigo, $inputNombre, $inputMarca, $inputCategoria, $inputPatente, $inputSucursal);

			if ($grabar > 0) {
				return true;
			}else{
				return false;
			}

			break;
		case 'editar_producto':
			$inputCodigo 	= $_REQUEST['inputCodigo'];
			$idProducto 	= $_REQUEST['idProducto'];
			$inputNombre 	= $_REQUEST['inputNombre'];
			$inputMarca 	= $_REQUEST['inputMarca'];
			$inputCategoria = $_REQUEST['inputCategoria'];
			$inputPatente 	= $_REQUEST['inputPatente'];
			$inputSucursal 	= $_REQUEST['inputSucursal'];

			$grabar         = $productos->editar_productos($inputCodigo, $idProducto, $inputNombre, $inputMarca, $inputCategoria, $inputPatente, $inputSucursal);

			if ($grabar > 0) {
				return true;
			}else{
				return false;
			}

			break;
		case 'desactivar_producto':
			$idProducto 	= $_REQUEST['idProducto'];

			$grabar         = $productos->desactivar_productos($idProducto);

			if ($grabar > 0) {
				return true;
			}else{
				return false;
			}

			break;
		case 'activar_producto':
			$idProducto 	= $_REQUEST['idProducto'];

			$grabar         = $productos->activar_producto($idProducto);

			if ($grabar > 0) {
				return true;
			}else{
				return false;
			}

			break;
		case 'cambiar_foto_producto':
			$idProducto = $_REQUEST['idProducto'];
			$html 	    = ' <div dir=rtl class="file-loading">
		    					<input id="input-b8" name="input-b8[]" multiple type="file">
							</div>
							<script>
								$(document).ready(function() {
								    $("#input-b8").fileinput({
								        rtl: true,
								        dropZoneEnabled: false,
								        allowedFileExtensions: ["jpg", "png", "gif"]
								    });
								});
							</script>';

			echo $html;

			break;
		case 'subir_foto_producto':
			$idProducto = $_REQUEST['idProducto'];

			if ($_FILES){

				$name    			= $_FILES['file']['name'];
			    $extraer 			= explode(".", $name);
				$nombre  			= date("Ymd")."".date("Hi").".".$extraer[1];
				$destino 			= "../../../repositorio/".$nombre;
				$tipo   			= $_FILES['file']["type"];
				$ruta_provisional   = $_FILES['file']["tmp_name"];
				$carpeta            = "../../../repositorio/";

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
		        $ancho              = 582;
		        $alto               = 437;
		        $calidad            = 95;
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

		        	$grabar 		= $productos->grabar_imagen_producto($nombre, $idProducto);

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
		case 'nueva_categoria':
			$html = '<div class="row mb-4">
					  <p align="left" class="text-success font-weight-light h3">Nueva Categoria</p>
					  <hr class="mt-2 mb-3"/>
					    <div class="container mb-4">
					      <div class="row">
					        <div class="col-10 mb-2">
					          <label for="inputNombre"><b>Nombre</b></label>
					          <input type="text" class="form-control shadow" id="inputNombre" placeholder="Nombre" autocomplete="off">
					        </div>
					        <div class="col-10 mb-2">
					          <button type="button" id="grabar" class="btn btn-primary form-control shadow" onclick="crear_categoria()">Grabar <i class="bi bi-save"></i></button>
					        </div>
					      </div>
					    </div>
					</div>';

			echo $html;
			break;

		case 'nueva_marca':
			$html = '<div class="row mb-4">
					  <p align="left" class="text-success font-weight-light h3">Nueva Marca</p>
					  <hr class="mt-2 mb-3"/>
					    <div class="container mb-4">
					      <div class="row">
					        <div class="col-10 mb-2">
					          <label for="inputMarca"><b>Nombre</b></label>
					          <input type="text" class="form-control shadow" id="inputMarca" placeholder="Nombre" autocomplete="off">
					        </div>
					        <div class="col-10 mb-2">
					          <button type="button" id="grabar" class="btn btn-primary form-control shadow" onclick="crear_marca()">Grabar <i class="bi bi-save"></i></button>
					        </div>
					      </div>
					    </div>
					</div>';

			echo $html;
			break;
		case 'crear_categoria':
			$mvc2->iniciar_sesion();
			$idUser      = $_SESSION['IDUSER'];
			$inputNombre = $_REQUEST['inputNombre'];

			$grabar      = $productos->grabar_categorias($inputNombre, $idUser);

			return $grabar;
			break;
		case 'crear_marca':
			$inputNombre = $_REQUEST['inputNombre'];

			$grabar      = $productos->grabar_marcas($inputNombre);

			return $grabar;
			break;
		case 'editar_marca':
			$idMarca = $_REQUEST['idMarca'];

			echo $productos->editar_marca($idMarca);
			break;
		case 'editar_categoria':
			$idCategoria = $_REQUEST['idCategoria'];

			echo $productos->editar_categoria($idCategoria);
			break;
		case 'grabar_editar_categoria':
			$inputNombre = $_REQUEST['inputNombre'];
			$idCategoria = $_REQUEST['idCategoria'];

			return $productos->grabar_editar_categoria($inputNombre, $idCategoria);
			break;
		case 'grabar_editar_marca':
			$inputNombre = $_REQUEST['inputNombre'];
			$idMarca     = $_REQUEST['idMarca'];

			return $productos->grabar_editar_marca($inputNombre, $idMarca);
			break;
		case 'consulta_codigo':
			$inputCodigo   = $_REQUEST['inputCodigo'];
			$existe_codigo = $recursos->datos_productos_codigo($inputCodigo);

			if(count($existe_codigo) > 0){
				echo '<span class="text-danger"> Existe</span>';
				echo '<script> $(".btn").prop("disabled", true);</script>';
			}else{
				echo '<span class="text-success"> Válido</span>';
				echo '<script> $(".btn").prop("disabled", false);</script>';
			}
			break;
		case 'imprimir_codigo_barra':
			$idProducto   = $_REQUEST['idProducto'];
			echo'<script src="'.controlador::$rutaAPP.'app/recursos/js/bar_code.js?v=<?= rand() ?>"></script>
				 <script src="'.controlador::$rutaAPP.'app/recursos/libs/jquery/jquery.min.js"></script>';
			echo $productos->codigo_barra_print($idProducto);
			break;
		default:
			break;
	}
?>