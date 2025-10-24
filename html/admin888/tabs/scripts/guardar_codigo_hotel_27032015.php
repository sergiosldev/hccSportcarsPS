<?php
include_once (dirname(__FILE__).'/../../../config/config.inc.php');

//include_once (dirname(__FILE__).'/../../../classes/FuncionesSeguridad.php');
     
$ciudad=FuncionesSeguridad::seg($_GET['ciudad']);  
$codigo=FuncionesSeguridad::seg($_GET['codigo'],true); 

$hotel = new Hotel();         
$hotel->ciudad=$ciudad;
$hotel->codigo=$codigo;     
$hotel->Update_disponibilidad(1);
unset ($hotel);
$DispHoteles=new DisponibilidadHotel();
$hoteles=$DispHoteles->getHotelesCiudad($ciudad);
foreach($hoteles as $h)
{
	if ($h->codigo!=$codigo)
	{
		$hotel= new Hotel();
		$hotel->ciudad=$ciudad;
		$hotel->codigo=$h->codigo;
		$hotel->Update_disponibilidad(0);
		unset ($hotel);
	}
}

//$cad_eval.='id_(\'sexoh\').checked=\''.($usu->sexo==1).'\'; ';     
//$cad_eval.='id_(\'sexom\').checked=\''.($usu->sexo==2).'\'; ';          



?>