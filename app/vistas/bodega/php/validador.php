<?php 
	session_start();

	date_default_timezone_set("America/Santiago");
	require_once __dir__."/../../../controlador/controlador.php";
	require_once __dir__."/../../../controlador/bodegaProductosControlador.php";
	//require_once __dir__."/../../../recursos/head.php";

	error_reporting(E_ALL);
	ini_set('display_errors', 1);

	
	$mvc2        = new controlador();
	$bodega      = new Bodega();
	$accion      = $_REQUEST['accion'];

	switch ($accion) {
		case 1://mostrar_productos_bodega
			$idProducto = $_REQUEST['idProducto'];

			echo $bodega->traer_productos_bodega_ver($idProducto);
			break;
		case 2://'mostrar_productos_arriendo'
			$idProducto = $_REQUEST['idProducto'];

			echo $bodega->traer_productos_arriendos_ver($idProducto);
		case 'ingresos_productos_lista':
			$productos = $_REQUEST['productos'];

			echo $bodega->ingresos_productos_lista($productos);
			break;
		case 'realizar_ingreso':
			$productos = $_REQUEST['productos'];
			$stock 	   = $_REQUEST['stock'];
			$glosa 	   = $_REQUEST['glosa'];
			$conteo	   = $_REQUEST['conteo_ingresos'];
			$factura_proveedor  = $_REQUEST['factura_proveedor'];
			$idUser    = $_SESSION['IDUSER'];

			echo $bodega->realizar_ingreso($productos, $stock, $glosa, $idUser, $conteo, $factura_proveedor);
			break;
		case 'salidas_productos_lista':
			$productos = $_REQUEST['productos'];

			echo $bodega->salidas_productos_lista($productos);
			break;
		case 'realizar_salida':
			$nombre_retira 	= $_REQUEST['nombre_retira'];
			$rut_retira 	= $_REQUEST['rut_retira'];
			$inputSucursal 	= $_REQUEST['inputSucursal'];
			$descripcion 	= $_REQUEST['descripcion'];
			$productos 		= $_REQUEST['productos'];
			$stock 	   		= $_REQUEST['stock'];
			$glosa 	   		= $_REQUEST['glosa'];
			$conteo	   		= $_REQUEST['conteo_ingresos'];
			$idUser    		= $_SESSION['IDUSER'];

			echo $bodega->realizar_salida($productos, $stock, $glosa, $idUser, $conteo, $nombre_retira, $rut_retira, $inputSucursal, $descripcion);
			break;
		case 'realizar_merma':
			$productos = $_REQUEST['productos'];
			$stock 	   = $_REQUEST['stock'];
			$glosa 	   = $_REQUEST['glosa'];
			$conteo	   = $_REQUEST['conteo_ingresos'];
			$idUser    = $_SESSION['IDUSER'];

			echo $bodega->realizar_merma_dos($productos, $stock, $glosa, $idUser, $conteo);
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
			$tipo_categoria = $_REQUEST['tipo_categoria'];

			$grabar      = $bodega->grabar_categorias($inputNombre, $idUser,$tipo_categoria); // ok

			return $grabar;
			break;
		case 'crear_marca':
			$inputNombre = $_REQUEST['inputNombre'];

			$grabar      = $bodega->grabar_marcas($inputNombre); // ok

			return $grabar;
			break;
		case 'editar_marca':
			$idMarca = $_REQUEST['idMarca'];

			echo $bodega->editar_marca($idMarca); // ok
			break;
		case 'editar_categoria':
			$idCategoria = $_REQUEST['idCategoria'];

			echo $bodega->editar_categoria($idCategoria); // ok
			break;
		case 'grabar_editar_categoria':
			$inputNombre = $_REQUEST['inputNombre'];
			$idCategoria = $_REQUEST['idCategoria'];

			return $bodega->grabar_editar_categoria($inputNombre, $idCategoria); // ok
			break;
		case 'grabar_editar_marca':
			$inputNombre = $_REQUEST['inputNombre'];
			$idMarca     = $_REQUEST['idMarca'];

			return $bodega->grabar_editar_marca($inputNombre, $idMarca); //ok
			break;
		case 'nueva_categoria':
			$html = '<div class="row mb-4">
					  <p align="left" class="text-success font-weight-light h3">Nueva Categoria</p>
					  <hr class="mt-2 mb-3"/>
					    <div class="container mb-4">
					      <div class="row">
					        <div class="col-6 mb-2">
					          <label for="inputNombre"><b>Nombre</b></label>
					          <input type="text" class="form-control shadow" id="inputNombre" placeholder="Nombre" autocomplete="off">
					        </div>
					        <div class="col-6 mb-2">
					        <label for="inputNombre"><b>Tipo Categoría</b></label>
					        	 <select name="tipo_categoria" id="tipo_categoria" class="form-select" onchange="tipo_categoria()">
						              <option value="0">Seleccionar Tipo Categoría</option>
						              <option value="1">Unitario</option>
						              <option value="2">Granel</option>
						              <option value="3">Metros</option>
						            </select>
					        </div>
					        <div class="col-10 mb-2">
					          <button type="button" id="grabar" class="btn btn-primary form-control shadow" onclick="crear_categoria()">Grabar <i class="bi bi-save"></i></button>
					        </div>
					      </div>
					    </div>
					</div>';

			echo $html;
			break;
		default:
			// Nada
			break;
	}
?>
