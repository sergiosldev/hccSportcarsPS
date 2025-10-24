<?php 
include_once (dirname(__FILE__).'/../../../config/config.inc.php');   
include dirname(__FILE__).'/config_events_new.php'; 
//include_once (dirname(__FILE__).'/../../../classes/FuncionesSeguridad.php');  
//include_once (dirname(__FILE__).'/../../../classes/Funciones.php');
$fs=new FuncionesSeguridad();
$ciudad=$fs->seg($_GET['ciudad']); 
$defecto=intval($_GET['hotel_defecto']);  
$fecha=$fs->seg($_GET['fecha']);   

$hotel=new Hotel();                
$codigo=$hotel->getCodigoHotelDefecto($ciudad,$defecto);
//var_dump($codigo);die;
$datos_hotel=$hotel->get($ciudad,$codigo);

$fviernes=Tools::fecha_semana($fecha,5);
$fsabado=Tools::fecha_semana($fecha,6);
$fdomingo=Tools::fecha_semana($fecha,7);

$bdisponibilidad_fecha=$hotel->getDisponibilidad($ciudad, $fecha);
$bdisponibilidad_viernes=$hotel->getDisponibilidad($ciudad, $fviernes);
$bdisponibilidad_sabado=$hotel->getDisponibilidad($ciudad, $fsabado);
$bdisponibilidad_domingo=$hotel->getDisponibilidad($ciudad, $fdomingo);
 
unset($hotel);   
if (count($datos_hotel)==0)
{
    $ret='';
}
else 
{
    $ret=$datos_hotel['codigo'].'#'.$datos_hotel['nombre'].'#'.intval($bdisponibilidad_fecha).'#'.$fviernes.'#'.intval($bdisponibilidad_viernes).'#'.$fsabado.'#'.intval($bdisponibilidad_sabado).'#'.$fdomingo.'#'.intval($bdisponibilidad_domingo); 
}              
die($ret);      
?> 