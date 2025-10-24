<?php
include_once (dirname(__FILE__).'/../../../config/config.inc.php');
         
//include_once (dirname(__FILE__).'/../../../classes/FuncionesSeguridad.php');
         
/* 
$ciudad=FuncionesSeguridad::seg($_GET['ciudad']);  
$codigo=FuncionesSeguridad::seg($_GET['codigo'],true);
*/
   
$ciudad=FuncionesSeguridad::seg($_GET['ciudad']);
$codigo=FuncionesSeguridad::seg($_GET['codigo'],true);
$fecha=FuncionesSeguridad::seg($_GET['fecha']);
$hotel_defecto=intval($_GET['hotel_defecto']);
$disponibilidad = intval($_GET['disponibilidad']);
  
$DispHoteles=new DisponibilidadHotel();

$hoteles=$DispHoteles->getHotelesCiudad($ciudad);

$hotel = new Hotel();         
$hotel->ciudad=$ciudad;
//if (count($hoteles)>=2)
$no_hotel_unico= $ciudad !='cantabria' && $ciudad!='valencia' && $ciudad!='barcelona' && $ciudad!='madrid';

if ($no_hotel_unico)  
{
	$codigo = $hotel->getCodigoHotelDefecto($ciudad,0);     
}
$hotel->codigo=$codigo;  
$hotel->fecha=$fecha;
$hotel->defecto=$hotel_defecto;   
$hotel->disponibilidad=$disponibilidad;
$hotel->Update_disponibilidad_fecha();  
unset ($hotel);
//var_dump($hoteles);echo('codigo '.$codigo.' ciudad. '.$ciudad);
foreach($hoteles as $h)
{
	if ($h->codigo!=$codigo)
	{
		$hdisp= new Hotel();
		$hdisp->ciudad=$ciudad;
		$hdisp->codigo=$h->codigo;
		$hdisp->Update_disponibilidad(0);
		unset ($hdisp);
	}
}
              
//$cad_eval.='id_(\'sexoh\').checked=\''.($usu->sexo==1).'\'; ';     
//$cad_eval.='id_(\'sexom\').checked=\''.($usu->sexo==2).'\'; ';          



?>