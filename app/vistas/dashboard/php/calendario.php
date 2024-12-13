<?php
class calendario{
	var $nombre_dias = array('Domingo','Lunes','Martes','Miercoles','Jueves','Viernes','Sabado');
	
	function mostrar($tope, $diaDehoy){

			$mes=$tope;
				$anio=date('Y',time());
				$ano = date("Y");
				setlocale(LC_TIME, 'spanish');  
		 		$nombreMEs = strftime("%B",mktime(0, 0, 0, $mes, 1, 2000)); 

				if($mes==1){ $mes_anterior=12; $anio_anterior = $anio-1; }
				else{ $mes_anterior = $mes-1; $anio_anterior = $anio; }
				
				$ultimo_dia_mes_anterior = date('t',mktime(0,0,0,$mes_anterior,1,$anio_anterior));
				
				$dia=7;
				if(strlen($mes)==1) $mes='0'.$mes;
			?><br>
		<table align="center" cellpadding="0" cellspacing="4" width="95%" border="0" class="table sombraPlana">
	        <thead>
			 <tr class="naranja_light">
			  <td align="center" style="min-width:100px;"><?php echo $this->nombre_dias[1]?></td>
			  <td align="center" style="min-width:100px;"><?php echo $this->nombre_dias[2]?></td>
			  <td align="center" style="min-width:100px;"><?php echo $this->nombre_dias[3]?></td>
			  <td align="center" style="min-width:100px;"><?php echo $this->nombre_dias[4]?></td>
			  <td align="center" style="min-width:100px;"><?php echo $this->nombre_dias[5]?></td>
			  <td align="center" style="min-width:100px;"><?php echo $this->nombre_dias[6]?></td>
			  <td align="center" style="min-width:100px;"><?php echo $this->nombre_dias[0]?></td>
			 </tr>
	        </thead>
        	<tbody>
		<?php		
			$numero_primer_dia = date('w', mktime(0,0,0,$mes,$dia,$anio));
			$ultimo_dia = date('t', mktime(0,0,0,$mes,$dia,$anio));
			$diferencia_mes_anterior = $ultimo_dia_mes_anterior - ($numero_primer_dia-1);
			$total_dias=$numero_primer_dia+$ultimo_dia;
			$diames=1;

			$diames2 = date("d");
			$mes2    = date("m");

			$hoyes = date("Y-m-d");

			$j=1;
			while($j<=$total_dias){

				echo "<tr> \n";

				$i=0;
				$k=1; 
				while($i<7){
					if($j<=$numero_primer_dia){
						echo "<td class=\"disabled\" id='cambiazo'>  \n";
						echo "<div class=\"headbox\"> \n";
						echo "</div>";
						echo "<div class=\"bodybox\"></div> \n";
						echo "</td> \n";
						$diferencia_mes_anterior++;
					}elseif($diames > $ultimo_dia){
						echo "<td class=\"disabled\" id='cambiazo'> \n";
						echo "<div class=\"headbox\"> \n";
						echo "</div>";
						echo "<div class=\"bodybox\"></div> \n";
						echo"</td> \n";
						$k++; 
					}else{
						if($diames<10) $diames_con_cero='0'.$diames;
						else $diames_con_cero=$diames;
						
							if($diames < $diaDehoy){
								$semana = date('w',  mktime(0,0,0,$mes2,$diames,$ano));
								$fecha  = $ano."-".$mes2."-".$diames;
								if ($semana == 0 || $semana == 6) {
									$html = '<td align="right" >';
									$html .= "<div class=\"headbox\"> \n";
									$html .= $diames;
									$html .= "</div> \n";
									$html .= "<div class=\"bodybox \">";
									$html .= "&nbsp;";
									$html .= "</div></td> \n";
								}else{
									$html = '<td class="cursor" href="'.controlador::$rutaAPP.'app/vistas/configuraciones/php/control_calendario.php?fecha='.$ano.'-'.$mes2.'-'.$diames.'" data-fancybox data-type="iframe" data-preload="true" data-width="100%" data-height="100%"  align="right" style="min-width:100px;height:100px;background-color:#ffe6ff;">';
									$html .= "<div class=\"headbox\"> \n";
									$html .= $diames;
									$html .= "</div> \n";
									$html .= "<div class=\"bodybox\">";
									$html .= "&nbsp;";
									$html .= "</div></td> \n";
								}
								
							echo $html;
							}elseif($diames2 == $diaDehoy){

								$semana = date('w',  mktime(0,0,0,$mes2,$diames,$ano));
								$fecha  = $ano."-".$mes2."-".$diames;

								if ($semana == 0 || $semana == 6) {
									$html = '<td align="right">';
									$html .= "<div  class=\"headbox\"> \n";
									$html .= $diames;
									$html .= "</div> \n";
									$html .= "<div class='bodybox'>";
									$html .= "</div></td> \n";
								}else{
									$html = '<td class="cursor" href="'.controlador::$rutaAPP.'app/vistas/configuraciones/php/control_calendario.php?fecha='.$ano.'-'.$mes2.'-'.$diames.'" data-fancybox data-type="iframe" data-preload="true" data-width="100%" data-height="100%"  align="right" style="min-width:100px;height:100px;background-color:#ffe6ff;">';
									$html .= "<div class=\"headbox\"> \n";
									$html .= $diames;
									$html .= "</div> \n";
									$html .= "<div class='bodybox'>";
									$html .= "&nbsp;";
									$html .= "</div></td> \n";
								}
							echo $html;
							}else{
								$semana = date('w',  mktime(0,0,0,$mes2,$diames,$ano));
								$fecha  = $ano."-".$mes2."-".$diames;
								if ($semana == 0) {
									$html = '<td align="right">';
									$html .= "<div class=\"headbox\"> \n";
									$html .= $diames;
									$html .= "</div> \n";
									$html .= "<div class=\"bodybox\">";
									$html .= "&nbsp;";
									$html .= "</div></td> \n";
								}else{
									$html = '<td align="right">';
									$html .= "<div class=\"headbox\"> \n";
									$html .= $diames;
									$html .= "</div> \n";
									$html .= "<div class=\"bodybox\">";
									$html .= "&nbsp;";
									$html .= "</div></td>\n";
								}

							echo $html;
							}
						$diames++;
					}
					$i++;
					$j++;
				}
				echo "</tr> \n";
			}
		?>
         </tbody>
		</table><br>
		<?php
	}
}
?>
