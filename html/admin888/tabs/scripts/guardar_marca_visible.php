<?php                             
include_once(dirname(__FILE__).'/../../../config/config.inc.php');         
$id=$_GET['id'];         
$sciudad=$_GET['ciudad'];                             
$origen=$_GET['origen'];
$visible=$_GET['visible'];

if ($visible=='0')   
{ 
	$sql = ' select 1 
			 from eventos_marcado_no_visible   
			 where id = '.$id.' and 
				   ciudad = "'.$sciudad.'" ';

	$re=Db::getInstance()->ExecuteS($sql);

	if (!$re)			       
	{
		$sql = ' insert into eventos_marcado_no_visible (origen,ciudad,id)   
				values ("'.$origen.'","'.$sciudad.'",'.$id.');';  
	}
}
else 
{
	$sql= ' delete from eventos_marcado_no_visible where id = '.$id.' and ciudad = "'.$sciudad.'" and origen="'.$origen.'" ';                        
}		 
	//die($sql);	 
$re=Db::getInstance()->Execute($sql);	
//echo('visible '.$visible.' '.$sql);	                    
?>   
