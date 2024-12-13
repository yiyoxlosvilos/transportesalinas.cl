<?php 
	class conexion_bd
	{
		protected $conexion;
		protected $esta_conectado = false;

		 public function __construct() {
	        $this->conexion = new mysqli("localhost", "centroc1", "x*5m-bG7B47EfS", "centroc1_tr4nsc4p_cc");
	    }

		public function conectar(){

			if ($this->conexion->connect_errno) {
				echo "Error de conexion".$this->conexion->connect_error;

				$this->esta_conectado = false;
			} else {
				$this->esta_conectado = true;
				$this->conexion = new mysqli("localhost", "centroc1", "x*5m-bG7B47EfS", "centroc1_tr4nsc4p_cc");
			}

			return $this->esta_conectado;
		}
	}
?>