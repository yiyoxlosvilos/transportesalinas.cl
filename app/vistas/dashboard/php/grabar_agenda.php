<?php
	date_default_timezone_set("America/Santiago");

	require_once 	__dir__.'/../../../controlador/dashboardControlador.php';
	require_once 	__dir__.'/../../../recursos/PHPExcel/Classes/PHPExcel.php';

	$idUser			= $_POST['idUser'];
	$idCategoria	= $_POST['idCategoria'];
	$idSubCategoria	= $_POST['idSubCategoria'];
	$desde			= $_POST['desde'];
	$hasta			= $_POST['hasta'];
	$result			= $_POST['result'];
	$hora_ini 		= $_POST['hora_ini'];
	$hora_fin 		= $_POST['hora_fin'];
	$idNivel 		= $_POST['idNivel'];
	$idCurso 		= $_POST['idCurso'];

	$configuracion	= new DashBoard();
	$mvc_datos    	= new GetDatos();

	$grabar         = $configuracion->grabar_registro_calendario($idUser, $idCategoria, $idSubCategoria, $desde, $hasta, $result, $hora_ini, $hora_fin, $idNivel, $idCurso);

	if ($grabar) {
		return false;
	}else{
		return false;
	}
?>