<?php
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);

	class controlador {

		public static $rutaAPP = "https://transportesalinas.cl/";

		// MANTENEDOR DE SESSIONES
		public function login() {
			include_once(__dir__."/../vistas/login/login.php");
		}

		public function validar() {
			include_once(__dir__."/../vistas/login/php/validador_login.php");
		}

		public function iniciar_sesion(){
			if(!isset($_SESSION)){
				session_start();
			}
			if (isset($_SESSION["IDUSER"])) {
				return true;
			}

			return false;
		}

		public function cerrar_sesion() {
			if(!isset($_SESSION)){
				session_start();
			}
			session_destroy();
			header('Location: '.controlador::$rutaAPP);
		}
		// MODULOS SISTEMA
		public function dashboard(){
			include_once(__dir__."/../vistas/dashboard/index.php");
		}

		// MODULOS PRODUCTOS
		public function productos(){
			include_once(__dir__."/../vistas/productos/index.php");
		}

		// MODULOS BODEGA
		public function bodega(){
			include_once(__dir__."/../vistas/bodega/index.php");
		}

		// MODULOS REPORTERIA
		public function reporteria(){
			include_once(__dir__."/../vistas/reporteria/index.php");
		}

		// MODULOS FINANZAS
		public function finanzas(){
			include_once(__dir__."/../vistas/finanzas/index.php");
		}

		// MODULOS RRHH
		public function rrhh(){
			include_once(__dir__."/../vistas/rrhh/index.php");
		}

		// MODULOS PARAMETROS
		public function parametros(){
			include_once(__dir__."/../vistas/parametros/index.php");
		}

		//MODULO VENTAS
		public function centro_costo(){
			include_once(__dir__."/../vistas/centro_costo/index.php");
		}


		public function menu_usuarios() {
			include_once(__dir__."/../vistas/menu.php");
		}

		public function ruta(){
			include_once(__dir__."/../vistas/ruta/index.php");
		}

		public function bitacora(){
			include_once(__dir__."/../vistas/bitacora/index.php");
		}

		public function viajes(){
			include_once(__dir__."/../vistas/viajes/index.php");
		}	
	}

?>