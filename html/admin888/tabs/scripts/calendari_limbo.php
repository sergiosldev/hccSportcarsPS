<?php

/* Classe amb  diferents funcions de calendari*/
if(!isset($_REQUEST['ciudad']))$_REQUEST['ciudad']='';
//$_REQUEST['ciudad']='';

include_once 'CalendarioLimbo.php';
//include_once 'reservas_limbo.php';
include_once 'config_limbo.php' ;
include_once 'functions.php';
 

$a=new CalendariLimbo();

$a->genera_calendario_mes($_GET['mes'],$_GET['ano'],array()); 


?>
