<?php
	require_once __dir__."/../modelo/obtener_datos.php";
	require_once __dir__."/../controlador/utilidadesControlador.php";


	class Login extends GetDatos
	{

		public function __construct(){
			parent::__construct();
	        $this->hoy   	  = date("Y-m-d H:i:s");
	        $this->utilidades = new Utilidades();
	        $this->mvc_datos  = new GetDatos();
	    }

	    public function hash_pass($pass)
	    {
	    	return md5($pass);
	    }

		public function login_usuario($usr, $pass){
			$hash   = $this->hash_pass($pass);

			$result = $this->selectQuery("SELECT * FROM usuario_cli 
										  	   WHERE 		 us_cli_nick     = $usr
										  	   AND 			 us_cli_pass 	 = '$hash' 
										  	   AND 			 us_cli_estado   = 1");
			return $result;
		}

	}

	
?>