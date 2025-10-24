<?php

include dirname(__FILE__).'/settings.php'; 
include dirname(__FILE__).'/funciones_establecimiento.php'; 


$e_id_establecimiento = $_GET['id_establecimiento'];
//mts, validación de contraseña al tratar de borrar un establecimiento.
if (isset($_GET['password'])) 
{
    if ($_GET['password']==_PASSWD_DELETE_)
        {
        $r=DeleteEstablecimiento($e_id_establecimiento);
        }
    else $r='error_password'; 
        
}

echo $r;
?>