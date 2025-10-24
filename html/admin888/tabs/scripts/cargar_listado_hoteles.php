<?php 
	include_once (dirname(__FILE__).'/../../../config/config.inc.php');
	$disponibilidad_hotel = new DisponibilidadHotel();      
	
	
	$hoteles=array();
	$hoteles=$disponibilidad_hotel->getHotelesCiudad();
	$sciudad_ant="";
	
	//var_dump($hoteles);
	
	foreach ($hoteles as $hotel)				
	{
		if ($sciudad_ant != $hotel->ciudad)
		{
			echo('<span class="label_ lcabecera">'.$hotel->ciudad.'</span>');
			$sciudad_ant = $hotel->ciudad;					
		}
		
		
		echo('<div class="lradio">'.$hotel->nombre.'('.$hotel->codigo.')</div>');                					
	}

	unset($disponibilidad_hotel);
?>
