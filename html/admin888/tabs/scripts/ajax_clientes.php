<?php

include dirname(__FILE__).'/../../../classes/Db.php';
include dirname(__FILE__).'/../../../classes/Usuario.php';


$id_cliente = $_GET['id_cliente'];
$operacion = $_GET['operacion'];
//mts, validación de contraseña al tratar de borrar una oferta.
if ($operacion=='borrar')
{          
    $cliente = new Usuario($id_cliente);
	$cliente->get();
	
    $r=$cliente->Delete();
    if ($r) $r='OK';
    else $r='Error al eliminar el cliente';
}

echo $r;
?>
