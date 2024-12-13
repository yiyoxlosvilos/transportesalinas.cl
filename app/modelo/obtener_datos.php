<?php
	include_once(__dir__."/BD_conexion.php");

	class GetDatos extends conexion_bd
	{
		public function ejecutar($sql){
			$result = $this->conexion->query($sql);
			return $result;
		}

		public function numero_filas($result){
			return $result->num_rows;
		}

		public function selectQuery($query){
			$datos = array();
			$this->conectar();

			$consulta =  $this->ejecutar($query);

			if($this->numero_filas($consulta)){
				while($arreglo = $consulta->fetch_assoc()){
					$datos[]   = $arreglo;
				}
			}

			$this->conexion->close();

			return $datos;
		}

		public function getLastInsert(){

			$last = $this->conexion->insert_id;
			$this->conexion->close();
			return $last;
		}

		public function insert_query($query){
			$this->conectar();

			$consulta = $this->ejecutar($query);

			return $this->getLastInsert();
		}

		public function update_query($query){
			$this->conectar();

			$consulta = $this->ejecutar($query);

			$this->conexion->close();

			return true;
		}

		public function delete_query($query){
			$this->conectar();

			$consulta = $this->ejecutar($query);

			$this->conexion->close();

			return true;
		}

		public function limpiaRut($rut){

	        $monto1 = str_replace(" ", "", $rut);
	        $monto2 = str_replace("-", "", $monto1);
	        $monto3 = str_replace(".", "", $monto2);
	        
	        return $monto3;
	    }

	    public function validaRut($rut){
	    	$rut 	= preg_replace('/[^k0-9]/i', '', $rut);
		    $dv  	= substr($rut, -1);
		    $numero = substr($rut, 0, strlen($rut)-1);
		    $i 		= 2;
		    $suma 	= 0;

		    if($numero*1 == $numero){
		    	foreach(array_reverse(str_split($numero)) as $v){
			        if($i == 8){
			            $i = 2;
			        }
			        $suma += $v * $i;
			        ++$i;
			    }

			    $dvr = 11-($suma%11);
			    
			    if($dvr == 11){
			        $dvr = 0;
			    }
			    if($dvr == 10){
			        $dvr = 'K';
			    }

			    if($dvr == strtoupper($dv)){
			        return 1;
			    }else{
			        return 0;
			    }

		    }else{
		    	return 2;
		    }		    
	    }
	}
?>