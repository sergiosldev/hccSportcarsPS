<?php
include dirname(__FILE__).'/settings.php'; 

//mts, validación de contraseña al tratar de borrar una oferta.
if (isset($_GET['password'])) 
{
    if ($_GET['password']==_PASSWD_DELETE_) $r='OK';    
    else $r='error_password'; 
}
echo $r;
?>