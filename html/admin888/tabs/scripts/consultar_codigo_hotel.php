<?php
include_once (dirname(__FILE__).'/../../../config/config.inc.php');

//include_once (dirname(__FILE__).'/../../../classes/FuncionesSeguridad.php');
     
$ciudad=FuncionesSeguridad::seg($_GET['ciudad']);  
$fecha=FuncionesSeguridad::seg($_GET['fecha']);  
//die('test');
$DispHoteles=new DisponibilidadHotel(); 
//Buscamos si para esta fecha se seleccionó un hotel secundario.
$hoteles=$DispHoteles->getHotelesCiudad($ciudad,$fecha);          
      
//var_dump($hoteles);
if (count($hoteles)==0)
{   
    $hotel=new Hotel();
    
    //Si no hay seleccionado ningún hotel secundario (no hay registros en la tabla hoteles_disponibles),
    //devolveremos los datos del hotel secundario para parametrizar el botón "canviar de hotel"  
    $codigo=$hotel->getCodigoHotelDefecto($ciudad,0);
    $datos_hotel=$hotel->get($ciudad,$codigo);
    unset($hotel);
    //var_dump($datos_hotel);die;
	die($datos_hotel['codigo'].'#'.$datos_hotel['nombre'].'#0');			 		
}
else 
{
    $hotel=new Hotel();
    
    //Si hay seleccionado el hotel secundario (hay registros en la tabla hoteles_disponibles para esta fecha),
    //devolveremos los datos del hotel por defecto para parametrizar el botón "canviar de hotel"
    $codigo=$hotel->getCodigoHotelDefecto($ciudad,1);
    $datos_hotel=$hotel->get($ciudad,$codigo);
    unset($hotel);
    //var_dump($datos_hotel);die;
    die($datos_hotel['codigo'].'#'.$datos_hotel['nombre'].'#1');
}			 		
?>