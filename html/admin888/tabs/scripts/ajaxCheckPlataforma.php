<?php 
include_once dirname(__FILE__).'/../../../config/config.inc.php'; 
	  $sql = "Select consumo from plataformas where id_plataforma =".$_GET["id"];

	  $result=db::getinstance()->executes($sql);

	  //Tractament de la consulta.
	
		if($result[0]["consumo"] == null){
			echo "1";
		}
		else{
			echo "0";
		}
	  
  

?>