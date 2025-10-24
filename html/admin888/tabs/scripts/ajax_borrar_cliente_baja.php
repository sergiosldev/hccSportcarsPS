<?php

include_once(dirname(__FILE__).'/../../../config/config.inc.php'); 
include_once('settings.php');

$password2 = _PASSWD_DELETE_; 
$password = tools::getValue('password');
$email = tools::getValue('email');

//mts, validación de contraseña al tratar de borrar una oferta.
if ($password) 
{
    if ($password==$password2)
    {
		$usuario=new Usuario();
		$usuario->DeleteFromEmail($email);
		$r='OK';
    }
    else $r='error_password';         
}

echo $r;
?>