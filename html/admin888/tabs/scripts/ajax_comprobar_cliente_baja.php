<?php
	include_once(dirname(__FILE__).'/../../../config/config.inc.php');
	$email=tools::getValue('email');
	$usuario=new Usuario();	
	$res=$usuario->ComprobarEmailBaja($email,$usuarios,$reservas);
	$res=intval($res).'#Existen '.count($usuarios).' usuarios y '.count($reservas).' reservas para este email';
	echo($res);
?>
