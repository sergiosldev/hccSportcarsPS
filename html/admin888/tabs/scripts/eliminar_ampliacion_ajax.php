<?php

	$id = $_GET['id'];
	$fecha = $_GET['fecha'];
	include_once('../../../config/config.inc.php');
	
	$sql = 'DELETE FROM ampliaciones WHERE id_plataforma like "'.$id.'" AND fecha = "'.$fecha.'" ';
		
	//Consulta realitzada.
	//$result=mysql_query($sql);
    $result=Db::getInstance()->Execute($sql);
	
	include_once("buscar_ampliaciones_ajax.php");
?>