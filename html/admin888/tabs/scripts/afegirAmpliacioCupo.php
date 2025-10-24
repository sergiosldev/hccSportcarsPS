<?php

	include_once dirname(__FILE__).'/../../../config/config.inc.php'; 

	if($_POST["codiLocalitzador"]!=""){
		$data = date('Y-m-d H:i:s');
		
		$sql = 'Insert into ampliaciones values ('.$_POST["Plataforma"].',"'.$_POST["codiLocalitzador"].'","'.$_POST["codiConsum"].'","'.$data.'")';
		$result=db::getinstance()->execute($sql);
	}
	header('Location: ./../../index.php?tab=AdminAmpliaCupo');
?>