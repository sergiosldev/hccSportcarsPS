<?php
session_start();
$_SESSION['acceso_ofertas_ca_prestashop'] = date("Y-n-j H:i:s");
die($_SESSION['acceso_ofertas_ca_prestashop']);
?>