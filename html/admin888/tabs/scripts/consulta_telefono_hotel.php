<?php
include_once(dirname(__FILE__).'/../../../config/config.inc.php');
$hotel= new Hotel(tools::getValue('codigo'));
$datos=$hotel->get(tools::getValue('ciudad'),tools::getValue('codigo'));
die($datos['telefono']);
?>
