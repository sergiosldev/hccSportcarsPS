<?php                             
include_once(dirname(__FILE__).'/../../../config/config.inc.php');         
$id=$_GET['id'];         
$ciudad=$_GET['ciudad'];                             

if (strtoupper($ciudad)=='BARCELONA') $ciudad='';
$marcado=intval($_GET['marcado']);          
$ciudad=strtolower(trim($ciudad));

$sql = ' update events'.$ciudad.'                                                                         
		 set marcat='.$marcado;

if ($marcado)		 
{
	$sql .= '
		   ,fecha_canjeado=\''.date('Y-m-d H:i:s').'\'  ';  
}		   
else
{
	$sql .= '
		   ,fecha_desmarcado=\''.date('Y-m-d H:i:s').'\'  ';
}		   
		   
$sql.=   ' where id = '.$id;                           


$re=Db::getInstance()->Execute($sql);		                      

?>   
