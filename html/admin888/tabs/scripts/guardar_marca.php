<?php                             
include_once(dirname(__FILE__).'/../../../config/config.inc.php');         
$id=$_GET['id'];         
$sciudad=$_GET['ciudad'];                             
$origen=$_GET['origen'];
$marcado=$_GET['marcado'];          

$sql = ' select 1 
		 from eventos_marcados
		 where id = '.$id.' and 
			   ciudad = "'.$sciudad.'" ';
/*if ($id==64796)
{
	die($sql);
}*/
$re=Db::getInstance()->ExecuteS($sql);

if (!$re)			   
{
	$sql = ' insert into eventos_marcados (origen,ciudad,id,marcado)
			values ("'.$origen.'","'.$sciudad.'",'.$id.','.$marcado.');';
}
else
{
	$sql = ' update eventos_marcados                                                                          
		 set marcado='.$marcado.'    
		 where id = '.$id.' and ciudad = "'.$sciudad.'" and origen="'.$origen.'" ';                        
}		 
	//die($sql);	 
$re=Db::getInstance()->Execute($sql);		                    
?>   
