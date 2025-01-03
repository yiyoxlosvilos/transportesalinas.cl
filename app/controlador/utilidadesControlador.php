<?php
	class Utilidades {
		public static function fecha_hoy(){
			$hoy = date("Y-m-d");

			return $hoy;
		}

		public static function fecha_hoy_hora(){
			$hoy = date("Y-m-d H:i:s");

			return $hoy;
		}

		public static function tipos_estado($estado){
			if($estado == 1){
				$tipo = '<span class="text-success">Vigente</span>';
			}elseif($estado == 2){
				$tipo = '<span class="text-info">Flete</span>';
			}elseif($estado == 3){
				$tipo = '<span class="text-danger">Merma</span>';
			}

			return $tipo;
		}

		public static function tipos_estado_agenda($estado){
			if($estado == 1){
				$tipo = '<span class="text-success">Vigente</span>';
			}elseif($estado == 2){
				$tipo = '<span class="text-info">Cancelada</span>';
			}elseif($estado == 3){
				$tipo = '<span class="text-danger">Anulada</span>';
			}

			return $tipo;
		}

		public static function fecha_dia(){
			$hoy = date("d");

			return $hoy;
		}

		public static function rut($rut){
		    $parte4 = substr($rut, -1); // seria solo el numero verificador
		    $parte1 = substr($rut,0,-1); //de esta manera toma todos los caracteres desde el 8 hacia la izq
		    return number_format((int)$parte1,0, ',','.')."-".$parte4; 
		}

		public static function fecha_mes(){
			$hoy = date("m");

			return $hoy;
		}
	
		public static function fecha_ano(){
			$hoy = date("Y");

			return $hoy;
		}

		public static function fecha_ano_restar($cantidad){
			$hoy   = date("Y");
			$fecha = date("Y", strtotime($hoy."- ".$cantidad." year"));

			return $fecha;
		}

		public static function hora(){
			$hoy = date("H:i:s");

			return $hoy;
		}

		public static function limpiaRut($rut){

	        $monto1 = str_replace(" ", "", $rut);
	        $monto2 = str_replace("-", "", $monto1);
	        $monto3 = str_replace(".", "", $monto2);
	        
	        return $monto3;
	    }

	    public static function arregloOp($numOperacion){

			$contador  = strlen($numOperacion);

		    if($contador == 10){
		      $nuevaOperacion = "0".$numOperacion;
		    }else{
		      $nuevaOperacion = $numOperacion;
		    }

		    return $nuevaOperacion;
		}

	    public static function validaRut($rut){

	    	if(strpos($rut,"-")==false){
	    	   $RUT[0] = substr($rut, 0, -1);
	    	   $RUT[1] = substr($rut, -1);
	    	}else{
	    	   $RUT = explode("-", trim($rut));
	    	}
	    	$elRut = str_replace(".", "", trim($RUT[0]));
	    	$factor = 2;
	    	for($i = strlen($elRut)-1; $i >= 0; $i--):
	    	   $factor = $factor > 7 ? 2 : $factor;
	    	   @$suma += $elRut[$i]*$factor++;
	    	endfor;
	    	   $resto = $suma % 11;
	    	   $dv = 11 - $resto;
	    	if($dv == 11){
	    	   $dv=0;
	    	}else if($dv == 10){
	    	   $dv="k";
	    	}else{
	    	   $dv=$dv;
	    	}
	    	if($dv == trim(strtolower($RUT[1]))){
	    	   return 1;
	    	}else{
	    	   return 0;
	    	}
	    }

	    public static function arreglo_fecha($fecha){
			$explorar = explode("-", $fecha);

			if($explorar[0] < 9){
				$dia = "0".$explorar[0];
			}else{
				$dia = $explorar[0];
			}

			if($explorar[1] < 9){
				$mes = "0".$explorar[1];
			}else{
				$mes = $explorar[1];
			}

			$fecha   = $explorar[2]."-".$mes."-".$dia;

			return $fecha;
		}

		 public static function arreglo_fecha2($fecha){
			$explorar = explode("-", $fecha);
			$fecha    = $explorar[2]."-".$explorar[1]."-".$explorar[0];

			return $fecha;
		}

		public static function arreglo_fechas_horas($fecha){
			$saca_hora= explode(" ", $fecha);

			$explorar = explode("-", $saca_hora[0]);
			$fecha    = $explorar[2]."-".$explorar[1]."-".$explorar[0]." | ".$saca_hora[1];

			return $fecha;
		}

		public static function arreglo_fecha3($fecha){
			$explorar = explode("-", $fecha);
			$fecha    = $explorar[2]."/".$explorar[1]."/".$explorar[0];

			return $fecha;
		}

		public static function obtener_dias_habiles($fechainicio, $fechafin, $diasferiados = array()) {
	        $fechainicio = strtotime($fechainicio);
	        $fechafin    = strtotime($fechafin);

	        $diainc 	 = 24*60*60;
	        $diashabiles = array();

	        for($midia  = $fechainicio; $midia <= $fechafin; $midia += $diainc){
	            if(!in_array(date('N', $midia), array(6,7))){ 
	                if(!in_array(date('Y-m-d', $midia), $diasferiados)){
	                	array_push($diashabiles, date('Y-m-d', $midia));
	                }
	            }
	        }
	       
	        return $diashabiles;
		}

		public static function meses_listado(){
			$html 	= "";
			$mesF   = date("m");
			$anoF   = date("Y");
			$dias   = date('t', mktime(0,0,0, $mesF, 1, $anoF));
			for($i=1; $i <= $dias; $i++){
				$html .="'".$i."'";
			}
			return $html;
		}

		public static function calcular_fechas($fecha_inicial, $fecha_final){

			$dias = (strtotime($fecha_inicial)-strtotime($fecha_final))/86400;

			$dias = abs($dias); 
			$dias = floor($dias);

			return $dias;

		}

		public static function contador_fecha($fecha1, $fecha2){
	        $fecha1     = explode("-",$fecha1);
	        $fecha2     = explode("-",$fecha2);
	        $fechaUno   = mktime( 0, 0, 0, $fecha1[1] , $fecha1[2] , $fecha1[0] );
	        $fechaDos   = mktime( 0, 0, 0, $fecha2[1] , $fecha2[2] , $fecha2[0] );
	        $diasR      = ($fechaDos - $fechaUno);
	        $dias       = round(($diasR) / (60 * 60 * 24));
	        return $dias;   
	    }

		public static function matar_espacio($texto){
			$remmplaza = str_replace(" ", "&nbsp;", $texto);
			return $remmplaza;
		}

		public static function dias_pasados($fecha_inicial, $fecha_final){
			$dias = (strtotime($fecha_inicial)-strtotime($fecha_final))/86400;
			$dias = abs($dias); $dias = floor($dias);
			return $dias;
		}

		public static function miles($monto){
		    return number_format($monto,2, ',','.');
		}

		public static function miles2($monto){
		    return number_format($monto,2, ',','.');
		}

		public static function numeros($monto){
		    return number_format($monto,0, ',','.');
		}

		public static function peso($monto){
		    return number_format($monto,2, ',',',');
		}

		public static function monto($monto){
		    return "$&nbsp;".number_format($monto,0, ',','.');
		}

		public static function monto2($monto){
		    return "$ ".number_format($monto,0, ',','.');
		}
		
		public static function monto3($monto){
			if($monto > 0){
				return "<span class='text-info'>$&nbsp;".number_format($monto,0, ',','.')."</span>";
			}else{
				return "$&nbsp;".number_format($monto,0, ',','.');
			}
		}

		public static function monto_color($monto){
			if($monto > 0){
				return "<span class='text-primary'>$&nbsp;".number_format($monto,0, ',','.')."</span>";
			}elseif($monto < 0){
				return "<span class='text-danger'>$&nbsp;".number_format($monto*-1,0, ',','.')."</span>";
			}else{
				return "<span class='text-dark'>$&nbsp;".number_format($monto,0, ',','.')."</span>";
			}
		}

		public static function peso_color($monto){
			if($monto > 0){
				return "<span class='text-info'>".number_format($monto,2, ',','.')."</span>";
			}elseif($monto < 0){
				return "<span class='text-danger'>".number_format($monto*-1,2, ',','.')."</span>";
			}else{
				return "<span class='text-dark'>".number_format($monto,2, ',','.')."</span>";
			}
		}

		public static function numeros_color($monto){
			if($monto > 0){
				return "<span class='text-info'>".number_format($monto,0, ',','.')."</span>";
			}elseif($monto < 0){
				return "<span class='text-danger'>".number_format($monto*-1,0, ',','.')."</span>";
			}else{
				return "<span class='text-dark'>".number_format($monto,0, ',','.')."</span>";
			}
		}

		public static function mostrar_mes($mes){
			$meses  = array("","Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");

			return $meses[$mes*1];
		}

		public static function select_agrupacion_cards_mensual($funcion, $idSelect, $ano,$mes){

			if(strlen($funcion) > 0){
				$script = ' onchange="'.$funcion.'('.$ano.')"';
			}else{
				$script = '';
			}

			$meses  = array("","Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");

			$html = '<select id="'.$idSelect.'" class="form-select form-select-sm" '.$script.'>';

			for ($i=1; $i < count($meses); $i++) { 
				if($i == $mes){
					$html .= '<option value="'.$i.'" selected="selected">'.$meses[$i].'</option>';

				}else{
					$html .= '<option value="'.$i.'">'.$meses[$i].'</option>';
				}
			}

            $html .='         </select>';

            return $html;
		}

		public static function select_agrupacion_cards($funcion, $idSelect, $ano, $mes){

			if(strlen($funcion) > 0){
				$script = ' onchange="'.$funcion.'('.$ano.', '.$mes.')"';
			}else{
				$script = '';
			}

			$meses  = array("","Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");

			$html = '<select id="'.$idSelect.'" class="form-select" '.$script.'>';

			for ($i=1; $i < count($meses); $i++) { 
				if($i == $mes){
					$html .= '<option value="'.$i.'" selected="selected">'.$meses[$i].'</option>';

				}else{
					$html .= '<option value="'.$i.'">'.$meses[$i].'</option>';
				}
			}

            $html .='         </select>';

            return $html;
		}

		public static function select_agrupacion_cards_mes($funcion, $idSelect, $mes){

			if(strlen($funcion) > 0){
				$script = ' onchange="'.$funcion.'('.$mes.')"';
			}else{
				$script = '';
			}

			$meses  = array("","Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");

			$html = '<select id="'.$idSelect.'" class="form-select shadow bg-white" '.$script.'>';

			for ($i=1; $i < count($meses); $i++) { 
				if($i == $mes){
					$html .= '<option value="'.$i.'" selected="selected">'.$meses[$i].'</option>';

				}else{
					$html .= '<option value="'.$i.'">'.$meses[$i].'</option>';
				}
			}

            $html .='         </select>';

            return $html;
		}

		public static function select_agrupacion_cards_mes_busqueda($funcion, $idSelect, $mes){

			if(strlen($funcion) > 0){
				$script = ' onchange="'.$funcion.'('.$mes.')"';
			}else{
				$script = '';
			}

			$meses  = array("","Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");

			$html = '<select id="'.$idSelect.'" class="form-control shadow bg-white" '.$script.'>
						<option value="0">Todos</option>';

			for ($i=1; $i < count($meses); $i++) { 
				if($i == $mes){
					$html .= '<option value="'.$i.'" selected="selected">'.$meses[$i].'</option>';

				}else{
					$html .= '<option value="'.$i.'">'.$meses[$i].'</option>';
				}
			}

            $html .='         </select>';

            return $html;
		}

		public static function select_agrupacion_anos_busqueda($funcion, $idSelect, $ano){

			if(strlen($funcion) > 0){
				$script = ' onchange="'.$funcion.'('.$ano.')"';
			}else{
				$script = '';
			}

			$html = '<select id="'.$idSelect.'" class="form-control shadow bg-white" '.$script.'>
						<option value="0">Todos</option>';

			for ($i=2018; $i <= date("Y"); $i++) { 
				if($i == $ano){
					$html .= '<option value="'.$i.'" selected="selected">'.$i.'</option>';

				}else{
					$html .= '<option value="'.$i.'">'.$i.'</option>';
				}
			}

            $html .='         </select>';

            return $html;
		}

		public static function select_agrupacion_anos($funcion, $idSelect, $ano){

			if(strlen($funcion) > 0){
				$script = ' onchange="'.$funcion.'('.$ano.')"';
			}else{
				$script = '';
			}

			$html = '<select id="'.$idSelect.'" class="form-control shadow bg-white" '.$script.'>';

			for ($i=2018; $i <= date("Y"); $i++) { 
				if($i == $ano){
					$html .= '<option value="'.$i.'" selected="selected">'.$i.'</option>';

				}else{
					$html .= '<option value="'.$i.'">'.$i.'</option>';
				}
			}

            $html .='         </select>';

            return $html;
		}

		public static function activo_get($get, $tipoMenu){
			if($get == $tipoMenu){
				return 'active animate__animated animate__headShake';
			}
		}

		public static function subfijo($xx){ // esta función regresa un subfijo para la cifra
		    $xx = trim($xx);
		    $xstrlen = strlen($xx);
		    if ($xstrlen == 1 || $xstrlen == 2 || $xstrlen == 3)
		        $xsub = "";
		    
		    if ($xstrlen == 4 || $xstrlen == 5 || $xstrlen == 6)
		        $xsub = "Mil";
		    
		    return $xsub;
		}

		public static function texto_a_letra($xcifra3){

		    $xcifra2 = str_replace(".", "",$xcifra3);
		    $xcifra1 = str_replace("$", "",$xcifra2);
		    $xcifra4 = str_replace(" ", "",$xcifra1);
		    //------	 CONVERTIR NUMEROS A LETRAS	   ---------------		    
		    $xarray = array(0 => "Cero", 1 => "Un", "Dos", "Tres", "Cuatro", "Cinco", "Seis", "Siete", "Ocho", "Nueve", 
		        "Diez", "Once", "Doce", "Trece", "Catorce", "Quince", "Dieciseis", "Diecisiete", "Dieciocho", 
		        "Diecinueve", "Veinti", 
		        30 => "Treinta", 40 => "Cuarenta", 50 => "Cincuenta", 60 => "Sesenta", 70 => "Setenta", 80 => "Ochenta", 
		        90 => "Noventa", 100 => "Ciento", 200 => "Doscientos", 300 => "Trescientos", 400 => "Cuatrocientos", 
		        500 => "Quinientos", 600 => "Seiscientos", 700 => "Setecientos", 800 => "Ochocientos", 
		        900 => "Novecientos");
		    
		    $xcifra = trim($xcifra4);
		    //$xlength = strlen($xcifra);
		    $xpos_punto = strpos($xcifra, ",");
		    $xaux_int = $xcifra;
		    $xdecimales = "00";
		    if ($xpos_punto > 0) {
		        $xaux_int = substr($xcifra, 0, $xpos_punto); // obtengo el entero de la cifra a covertir
		        $xdecimales = substr($xcifra."00", $xpos_punto + 1, 2); // obtengo los valores decimales
		    }
		    
		    $XAUX = str_pad($xaux_int, 18, " ", STR_PAD_LEFT); // ajusto la longitud de la cifra, para que sea divisible por centenas de miles (grupos de 6)
		    $xcadena = "";
		    for($xz = 0; $xz < 3; $xz++){
		        $xaux = substr($XAUX, $xz * 6, 6);
		        $xi = 0; $xlimite = 6; // inicializo el contador de centenas xi y establezco el límite a 6 dígitos en la parte entera
		        $xexit = true; // bandera para controlar el ciclo del While	
		        while ($xexit){
		            if ($xi == $xlimite){ // si ya llegó al límite m&aacute;ximo de enteros
		                break; // termina el ciclo
		            }
		            
		            $x3digitos = ($xlimite - $xi) * -1; // comienzo con los tres primeros digitos de la cifra, comenzando por la izquierda
		            $xaux = substr($xaux, $x3digitos, abs($x3digitos)); // obtengo la centena (los tres dígitos)
		            for ($xy = 1; $xy < 4; $xy++){ // ciclo para revisar centenas, decenas y unidades, en ese orden
		                switch ($xy) {
		                    case 1: // checa las centenas
		                        if (substr($xaux, 0, 3) < 100){ // si el grupo de tres dígitos es menor a una centena ( < 99) no hace nada y pasa a revisar las decenas
		                        }else{
		                            @$xseek = $xarray[substr($xaux, 0, 3)]; // busco si la centena es número redondo (100, 200, 300, 400, etc..)
		                            if ($xseek){
		                                $xsub = Utilidades::subfijo($xaux); // devuelve el subfijo correspondiente (Millón, Millones, Mil o nada)
		                                if (substr($xaux, 0, 3) == 100) 
		                                        $xcadena = " ".$xcadena." Cien ".$xsub;
		                                else
		                                    $xcadena = " ".$xcadena." ".$xseek." ".$xsub;
		                                $xy = 3; // la centena fue redonda, entonces termino el ciclo del for y ya no reviso decenas ni unidades
		                            }else{ // entra aquí si la centena no fue numero redondo (101, 253, 120, 980, etc.)
		                                $xseek = $xarray[substr($xaux, 0, 1) * 100]; // toma el primer caracter de la centena y lo multiplica por cien y lo busca en el arreglo (para que busque 100,200,300, etc)
		                                $xcadena = " ".$xcadena." ".$xseek;
		                            } // ENDIF ($xseek)
		                        } // ENDIF (substr($xaux, 0, 3) < 100)
		                        break;
		                    case 2: // checa las decenas (con la misma lógica que las centenas)
		                        if (substr($xaux, 1, 2) < 10){
		                        }else{
		                            @$xseek = $xarray[substr($xaux, 1, 2)];
		                            if ($xseek){
		                                $xsub = Utilidades::subfijo($xaux);
		                                if (substr($xaux, 1, 2) == 20)
		                                        $xcadena = " ".$xcadena." Veinte ".$xsub;
		                                else
		                                    $xcadena = " ".$xcadena." ".$xseek." ".$xsub;
		                                $xy = 3;
		                            }else{
		                                $xseek = $xarray[substr($xaux, 1, 1) * 10];
		                                if (substr($xaux, 1, 1) * 10 == 20)
		                                        $xcadena = " ".$xcadena." ".$xseek;
		                                else
		                                    $xcadena = " ".$xcadena." ".$xseek." y ";
		                            } // ENDIF ($xseek)
		                        } // ENDIF (substr($xaux, 1, 2) < 10)
		                        break;
		                    case 3: // checa las unidades
		                        if (substr($xaux, 2, 1) < 1){ // si la unidad es cero, ya no hace nada
		                        }else{
		                            $xseek = $xarray[substr($xaux, 2, 1)]; // obtengo directamente el valor de la unidad (del uno al nueve)
		                            $xsub = Utilidades::subfijo($xaux);
		                            $xcadena = " ".$xcadena." ".$xseek." ".$xsub;
		                        } // ENDIF (substr($xaux, 2, 1) < 1)
		                        break;
		                } // END SWITCH
		            } // END FOR
		            
		            $xi = $xi + 3;
		        } // ENDDO
		        
		        if (substr($xcadena, -6, 6) == "Millon") // si la cadena obtenida termina en Millon, entonces le agrega al fina la palabra DE
		                $xcadena.= " De";
		        if (substr($xcadena, -8, 8) == "Millones") // si la cadena obtenida en Millones, entoncea le agrega al fina la palabra DE
		                $xcadena.= " De";
		        // ----------- esta línea la puedes cambiar de acuerdo a tus necesidades o a tu país -------
		        if (trim($xaux) != ""){
		            switch ($xz){
		                case 0:
		                    if (trim(substr($XAUX, $xz * 6, 6)) == "1")
		                            $xcadena.= "Un Billon ";
		                    else
		                        $xcadena.= " Billones ";
		                    break;
		                case 1:
		                    if (trim(substr($XAUX, $xz * 6, 6)) == "1")
		                            $xcadena.= "Un Millon ";
		                    else
		                        $xcadena.= " Millones ";
		                    break;
		                case 2:
		                    if ($xcifra < 1 ){
		                        $xcadena = "Cero Pesos";
		                    }
		                    if ($xcifra >= 1 && $xcifra < 2){
		                        $xcadena = "Un PESO";
		                    }
		                    if ($xcifra >= 2){
		                        $xcadena.= " Pesos"; // 
		                    }
		                    break;
		            } // endswitch ($xz)
		        } // ENDIF (trim($xaux) != "")
		        //
		        //------------------      en este caso, para México se usa esta leyenda     ----------------
		        
		        $xcadena5 = str_replace("Veinti ", "Veinti", $xcadena); // quito el espacio para el Veinti, para que quede: VeintiCuatro, VeintiUn, VeintiDos, etc
		        $xcadena4 = str_replace("  ", " ", $xcadena5); // quito espacios dobles
		        $xcadena3 = str_replace("Un Un", "Un", $xcadena4); // quito la duplicidad
		        $xcadena2 = str_replace("  ", " ", $xcadena3); // quito espacios dobles
		        $xcadena1 = str_replace("Billon Millones", "Billon", $xcadena2); // corrigo la leyenda
		        $xcadena0 = str_replace("Billones Millones", "Billones", $xcadena1); // corrigo la leyenda

		    } // ENDFOR	($xz)
		    
		    return trim($xcadena0);
		}

		public static function retrocedeFecha($mora){
	        $fecha      = Utilidades::fecha_hoy();
	        $nuevafecha = strtotime('-'.$mora.' day' , strtotime( $fecha ));
	        $nuevafecha = date('Y-m-d' , $nuevafecha);

	    	return $nuevafecha;
	    }

	    public static function aumentaDeFecha($mora){
	        $fecha      = Utilidades::fecha_hoy();
	        $nuevafecha = strtotime('+'.$mora.' day' , strtotime( $fecha )) ;
	        $nuevafecha = date('Y-m-d', $nuevafecha);

	        return $nuevafecha;
	    }

	    public static function arreglo_operacion($numOperacion){
	    	return substr($numOperacion, 0,2)."&#45;".substr($numOperacion, 2,5)."&#45;".substr($numOperacion, 7,4);
	    }

	    public static function estado_exento($idExento){
	    	$html = '';
	    	if($idExento == 0 || $idExento == 2){
	    		$html = 'NO';
	    	}else{
	    		$html = 'SI';
	    	}

	    	return $html;
	    }

	    public static function select_exento($idExento){
	    	$html ='<select name="exento" id="exento" class="form-control titulo_list">
	    				<option value="0">¿Exento?</option>';

	    	$data = array(array(1, "SI"), array(2, "NO"));

			$j=1;
			for ($i=0; $i < count($data); $i++) { 
				if($data[$i][0] == $idExento){
					$html .= '<option value="'.$data[$i][0].'" selected>'.$data[$i][1].'</option>';
				}else{
					$html .= '<option value="'.$data[$i][0].'">'.$data[$i][1].'</option>';
				}
				
			}

	    	$html.='</select>';

	    	return $html;
	    }

	    public static function select_estado_agenda($estado){
	    	$html ='<select name="estado" id="estado" class="form-control titulo_list" onchange="cambiar_Estado()">';

	    	$data = array(array(1, "VIGENTE"), array(2, "CANCELDA"), array(3, "ANULADA"));

			$j=1;
			for ($i=0; $i < count($data); $i++) { 
				if($data[$i][0] == $estado){
					$html .= '<option value="'.$data[$i][0].'" selected>'.$data[$i][1].'</option>';
				}else{
					$html .= '<option value="'.$data[$i][0].'">'.$data[$i][1].'</option>';
				}
				
			}

	    	$html.='</select>';

	    	return $html;
	    }

	    public static function tipos_categorias($estado){
			if($estado == 1){
				$tipo = 'Unitario';
			}elseif($estado == 2){
				$tipo = 'Granel';
			}elseif($estado == 3){
				$tipo = 'Metros';
			}

			return $tipo;
		}

		public static function format_patente($patente) {
	        // Verifica si el texto tiene al menos 6 caracteres
	        if (strlen($patente) === 6) {
	            // Divide el string en partes
	            $parte1 = substr($patente, 0, 2); // primeras dos letras
	            $parte2 = substr($patente, 2, 2); // siguiente par de números
	            $parte3 = substr($patente, 4, 2); // últimos dos números

	            // Combina con guiones
	            return "{$parte1}-{$parte2}-{$parte3}";
	        }

	        // Retorna el texto original si no tiene el formato esperado
	        return strtoupper($patente);
	    }

	    public static function generarCorrelativo($numero, $longitud = 5) {
		    // Formatea el número con ceros a la izquierda para que tenga la longitud especificada
		    return str_pad($numero, $longitud, '0', STR_PAD_LEFT);
		}

	}
?>