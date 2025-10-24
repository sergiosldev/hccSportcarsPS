<?php
include dirname(__FILE__).'/../settings.php'; 

//mts, validación de contraseña al tratar de borrar una oferta.
$password=($_GET['tipo_password']=='facturados')?_PASSWD_DELETE_FACTURADOS_:_PASSWD_DELETE_;

if (isset($_GET['password'])) 
{
    if ($_GET['password']==$password) $r='OK';    
    else $r='error_password'; 
}
echo $r;
?>