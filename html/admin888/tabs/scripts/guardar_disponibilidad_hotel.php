<?php
include_once (dirname(__FILE__).'/../../../config/config.inc.php');

//include_once (dirname(__FILE__).'/../../../classes/FuncionesSeguridad.php');
     
$ciudad=FuncionesSeguridad::seg($_GET['ciudad']);  
$codigo=FuncionesSeguridad::seg($_GET['codigo'],true); 
$fecha=FuncionesSeguridad::seg($_GET['fecha']);  
$activo=intval($_GET['activo']);                                                                                                                                                                                                                                                                   

$hotel = new Hotel();         
$hotel->ciudad=$ciudad;
$hotel->codigo=$codigo;     
$hotel->Update_disponibilidad_fecha(1,$fecha);
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
		$hotel->Delete_disponibilidad_fecha($fecha);
		unset ($hotel);
	}
}

?>