<?php                             
include_once(dirname(__FILE__).'/../../../config/config.inc.php');         
$id=$_GET['id'];            
$sciudad=$_GET['ciudad'];                             
$marcado=$_GET['marcado_especial'];          

$sql = ' update events'.$sciudad.'
		 set marca_especial='.$marcado.'    
		 where id = '.$id;                        
	die($sql);	 
$re=Db::getInstance()->Execute($sql);	 	                               
?>   
