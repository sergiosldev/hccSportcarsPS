<?php
include_once(dirname(__FILE__).'/../../../../config.inc.php');   

$reserva = new ReservaOferta();

$r=$reserva->get(null,$_GET['codigo_reserva']);

$r=$reserva->UpdateCampo('cantidad',0,$reserva->id);


?>
