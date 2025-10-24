<?php
include_once(dirname(__FILE__).'/../../../classes/ReservaOferta.php');   
include_once(dirname(__FILE__).'/../../../classes/Db.php');  
$reserva = new ReservaOferta();

$r=$reserva->get(null,$_GET['codigo_reserva']);

$r=$reserva->UpdateCampo('cantidad',0,$reserva->id);


?>
