<?php 
	date_default_timezone_set("America/Santiago");
	require_once __dir__."/../../../controlador/controlador.php";
	require_once __dir__."/../../../controlador/productosBodegaControlador.php";
	require_once __dir__."/../../../controlador/recursosControlador.php";
	
	$mvc2        = new controlador();
	$productos   = new ProductosBodega();
	$recursos    = new Recursos();

	$accion      = $_REQUEST['accion'];

	switch ($accion) {
		case 'productos_ver':
			$estado = $_REQUEST['estado'];

			echo $productos->traer_productos_table(1);
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
			$inputCodigo 	 	 = $_REQUEST['inputCodigo'];
			$inputNombre 	 	 = $_REQUEST['inputNombre'];
			$inputCategoria  	 = $_REQUEST['inputCategoria'];
			$inputMarca 	 	 = $_REQUEST['inputMarca'];
			$inputPrecioCompra 	 = $_REQUEST['inputPrecioCompra'];
			$inputMargen 	 	 = $_REQUEST['inputMargen'];
			$inputPrecioVenta 	 = $_REQUEST['inputPrecioVenta'];
			$inputPrecioUtilidad = $_REQUEST['inputPrecioUtilidad'];
			$inputSucursal 	 	 = $_REQUEST['inputSucursal'];
			$inputTipoUnidad 	 = $_REQUEST['inputTipoUnidad'];
			$inputStock 		 = $_REQUEST['inputStock'];

			$grabar          	 = $productos->grabar_productos($inputCodigo, $inputNombre, $inputCategoria, $inputPrecioCompra, $inputMargen, $inputPrecioVenta, $inputPrecioUtilidad, $inputSucursal, $inputTipoUnidad, $inputMarca, $inputStock);

			if ($grabar > 0) {
				return true;
			}else{
				return false;
			}

			break;
		case 'editar_producto':
			$idProducto 	 		= $_REQUEST['idProducto'];
			$inputCodigo 	 		= $_REQUEST['inputCodigo'];
			$inputNombre 	 		= $_REQUEST['inputNombre'];
			$inputCategoria  		= $_REQUEST['inputCategoria'];
			$inputPrecioCompra 		= $_REQUEST['inputPrecioCompra'];
			$inputMargen 	 		= $_REQUEST['inputMargen'];
			$inputPrecioVenta 	 	= $_REQUEST['inputPrecioVenta'];
			$inputPrecioUtilidad 	= $_REQUEST['inputPrecioUtilidad'];
			$inputSucursal 	 		= $_REQUEST['inputSucursal'];
			$inputTipoUnidad 		= $_REQUEST['inputTipoUnidad'];
			$inputMarca 	 		= $_REQUEST['inputMarca'];

			$grabar          = $productos->editar_productos($idProducto, $inputCodigo, $inputNombre, $inputCategoria, $inputPrecioCompra, $inputMargen, $inputPrecioVenta, $inputPrecioUtilidad, $inputSucursal, $inputTipoUnidad, $inputMarca);

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
					      </div>
					      <div class="row">
					        <div class="col">
						    	<button type="button" id="grabar" class="btn btn-primary form-control shadow" onclick="crear_categoria()">Grabar <i class="bi bi-save"></i></button>
						   	</div>
						   	<div class="col">
						    	<button type="button" id="grabar" class="btn btn-dark form-control shadow" onclick="location.reload()">Cancelar <i class="fas fa-ban"></i></button>
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
		case 'quitar_marca':
			$idMarca     = $_REQUEST['idMarca'];

			return $productos->quitar_marca($idMarca);
			break;
		case 'consulta_codigo':
			$inputCodigo   = $_REQUEST['inputCodigo'];
			$existe_codigo = $recursos->datos_productos_codigo_bodega($inputCodigo);

			if(count($existe_codigo) > 0){
				echo '<span class="text-danger"> Existe</span>';
				echo '<script> $(".btn").prop("disabled", true);</script>';
				echo '<script> $("#codigo_existe").addClass("animate__animated animate__tada");</script>';
			}else{
				echo '<span class="text-success"> Válido</span>';
				echo '<script> $(".btn").prop("disabled", false);</script>';
				echo '<script> $("#codigo_existe").addClass("animate__animated animate__fadeInRight");</script>';
			}
			break;
		case 'imprimir_codigo_barra':
			$idProducto   = $_REQUEST['idProducto'];
			echo'<script src="'.controlador::$rutaAPP.'app/recursos/js/bar_code.js?v=<?= rand() ?>"></script>
				 <script src="'.controlador::$rutaAPP.'app/recursos/libs/jquery/jquery.min.js"></script>';
			echo $productos->codigo_barra_print($idProducto);
			break;
		case 'tipo_categoria':
			$inputTipo 	 = $_REQUEST['inputTipo'];

			echo $recursos->seleccion_categoria_cliente_bodega($inputTipo);

			
			break;
		case 'quitar_categoria_granel':
			$idCategoria 	 = $_REQUEST['idCategoria'];

			return $productos->quitar_categoria_granel($idCategoria);
			break;
		case 'quitar_categoria':
			$idCategoria 	 = $_REQUEST['idCategoria'];

			return $productos->quitar_categoria($idCategoria);
			break;
		case 'editar_categoria_granel':
			$idCategoria = $_REQUEST['idCategoria'];

			echo $productos->editar_categoria_granel($idCategoria);
			break;
		case 'grabar_editar_categoria_granel':
			$inputNombre = $_REQUEST['inputNombre'];
			$idCategoria = $_REQUEST['idCategoria'];

			return $productos->grabar_editar_categoria_granel($inputNombre, $idCategoria);
			break;
		case 'ofertar_productos':
			echo '  <div class="card card-w-30 ">
			            <div class="card-body">
			                <div class="d-flex flex-wrap align-items-center mb-4">
			                    <h2 class="card-title me-2 text-danger h2"><i class="bi bi-cash-coin"></i> Productos en Oferta</h2>
			                    <div class="ms-auto">
			                    	<button class="btn btn-danger" type="button" href="'.controlador::$rutaAPP.'app/vistas/productosBodega/php/panel_ofertas.php" data-fancybox data-type="iframe" data-preload="true" data-width="1800" data-height="1200">Nueva Oferta&nbsp;&nbsp;&nbsp;<i class="bi bi-plus-circle-dotted"></i></button>
			                    </div>
			                </div>
			                '.$productos->listado_ofertas().'
			            </div>
			        </div>';

			echo '<script>
					$(document).ready(function() {
				    $("#tabla_ofertas").DataTable({     
					      "aLengthMenu": [[10, 20, 30, -1], [10, 20, 30, "Todos"]],
					        "iDisplayLength": 20
					       });
					});
				  </script>';
			break;
		case 'ofertar_productos_formulario':
			$producto = $_REQUEST['productos'];

			echo $productos->formulario_productos_lista($producto);

			break;
		case 'grabar_ofertas':
			$productos_asignados = $_REQUEST['productos_asignados'];
			$precio_final 		 = $_REQUEST['precio_final'];
			$oferta 			 = $_REQUEST['oferta'];
			$finalizar 			 = $_REQUEST['finalizar'];

			$grabar = $productos->grabar_ofertas($productos_asignados, $precio_final, $oferta, $finalizar);

			echo $grabar;
			break;
		case 'anular_ofertas':
			$producto_id = $_REQUEST['producto_id'];

			$grabar = $productos->anular_ofertas($producto_id);

			echo $grabar;
			break;
		case 'promocionar_productos':
			echo '  <div class="card card-w-30 ">
			            <div class="card-body">
			                <div class="d-flex flex-wrap align-items-center mb-4">
			                    <h2 class="card-title me-2 text-dark h2"><i class="bi bi-cash-coin"></i> Productos en Promoción</h2>
			                    <div class="ms-auto">
			                    	<button class="btn btn-dark" type="button" href="'.controlador::$rutaAPP.'app/vistas/productosBodega/php/panel_promociones.php" data-fancybox data-type="iframe" data-preload="true" data-width="1800" data-height="1200">Nueva Promoción&nbsp;&nbsp;&nbsp;<i class="bi bi-plus-circle-dotted"></i></button>
			                    </div>
			                </div>
			                '.$productos->traer_promociones().'
			            </div>
			        </div>';

			echo '<script>
					$(document).ready(function() {
				    $("#tabla_ofertas").DataTable({     
					      "aLengthMenu": [[10, 20, 30, -1], [10, 20, 30, "Todos"]],
					        "iDisplayLength": 20
					       });
					});
				  </script>';
			break;
		case 'promocionar_productos_formulario':
			$producto = $_REQUEST['productos'];

			echo $productos->formulario_productos_promocion($producto);

			break;
		case 'consulta_codigo_promocion':
			$inputCodigo   = $_REQUEST['inputCodigo'];
			$existe_codigo = $recursos->datos_promociones_codigo($inputCodigo);

			if(count($existe_codigo) > 0){
				echo '<span class="text-danger"> Existe</span>';
				echo '<script> $(".btn").prop("disabled", true);</script>';
				echo '<script> $("#codigo_existe").addClass("animate__animated animate__tada");</script>';
			}else{
				echo '<span class="text-success"> Válido</span>';
				echo '<script> $(".btn").prop("disabled", false);</script>';
				echo '<script> $("#codigo_existe").addClass("animate__animated animate__fadeInRight");</script>';
			}
			break;
		case 'grabar_promocion':
			$inputNombre 		 = $_REQUEST['inputNombre'];
			$inputCodigo 		 = $_REQUEST['inputCodigo'];
			$inputStock 		 = $_REQUEST['inputStock'];
			$inputMonto 		 = $_REQUEST['inputMonto'];
			$inputFecha 		 = $_REQUEST['inputFecha'];
			$inputSucursal 		 = $_REQUEST['inputSucursal'];
			$productos_asignados = $_REQUEST['productos_asignados'];
			$cantidad_promo 	 = $_REQUEST['cantidad_promo'];

			$grabar = $productos->grabar_promocion($inputNombre, $inputCodigo, $inputStock, $inputMonto, $inputFecha, $inputSucursal, $productos_asignados, $cantidad_promo);

			echo $grabar;
			break;
		case 'editar_promocion':
			$idPromo 		 	 = $_REQUEST['idPromo'];
			$inputNombre 		 = $_REQUEST['inputNombre'];
			$inputCodigo 		 = $_REQUEST['inputCodigo'];
			$inputStock 		 = $_REQUEST['inputStock'];
			$inputMonto 		 = $_REQUEST['inputMonto'];
			$inputFecha 		 = $_REQUEST['inputFecha'];
			$inputSucursal 		 = $_REQUEST['inputSucursal'];
			$productos_asignados = $_REQUEST['productos_asignados'];
			$cantidad_promo 	 = $_REQUEST['cantidad_promo'];

			$grabar = $productos->editar_promocion($idPromo, $inputNombre, $inputCodigo, $inputStock, $inputMonto, $inputFecha, $inputSucursal, $productos_asignados, $cantidad_promo);

			echo $grabar;
			break;
		case 'anular_promocion':
			$idPromo= $_REQUEST['idPromo'];

			$grabar = $productos->anular_promocion($idPromo);

			echo $grabar;
			break;
		case 'tipo_busqueda':
			$tipo_busqueda = $_REQUEST['tipo_busqueda'];

			if($tipo_busqueda == 1){
				echo '	<div class="row">
		                  <div class="col">
		                    <input type="text" class="form-control" id="codigo_producto" name="codigo_producto" placeholder="Escribir Código Aqui." />
		                  </div>
		                </div>';
			}elseif($tipo_busqueda == 2){
				echo '	<div class="row">
						  <div class="col">
						  	<select class="form-select" name="tipo_producto" id="tipo_producto" onchange="buscar_categoria_tipo_producto()">
						  		<option value="1">Unitario</option>
						  		<option value="2">Granel</option>
						  	</select>
						  </div>
		                  <div class="col" id="categoria">'.$recursos->seleccion_categoria_cliente().'</div>
		                </div>';
			}
			break;
		case 'buscar_categoria_tipo_producto':
			$tipo_producto = $_REQUEST['tipo_producto'];

			if($tipo_producto == 1){
				echo $recursos->seleccion_categoria_cliente();
			}elseif($tipo_producto == 2){
				echo $recursos->seleccion_categoria_granel();
			}
			break;
		case 'buscador_de_productos':
			$tipo_busqueda = $_REQUEST['tipo_busqueda'];
			$print 		   =  $_REQUEST['print'];

			if($print == 1){
				header('Pragma: no-cache');
                header('Expires: 0');
                header('Content-Transfer-Encoding: none');
                header('Content-type: application/vnd.ms-excel;charset=utf-8');
                header("Content-Disposition: attachment; filename=productos".date("dmYhis").".xls");
			}

			if($tipo_busqueda == 1){
				$codigo_producto = $_REQUEST['codigo_producto'];

				echo $productos->traer_productos_consulta_busqueda_codigo($codigo_producto);
			}elseif($tipo_busqueda == 2){
				$tipo_producto 	= $_REQUEST['tipo_producto'];
				$inputCategoria = $_REQUEST['inputCategoria'];

				echo $productos->traer_productos_consulta_busqueda_prod($tipo_producto, $inputCategoria);
			}

			echo '<script>
					$(document).ready(function() {
				    $("#productos_list").DataTable({     
					      "aLengthMenu": [[10, 20, 30, -1], [10, 20, 30, "Todos"]],
					        "iDisplayLength": 20
					       });
					});
				  </script>';
			break;
		default:
			break;
	}
?>