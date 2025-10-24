<?php

    include('../config/config.inc.php');
    include dirname(__FILE__).'/funciones_ofertas.php'; 
    
    $texto = $_POST['texto_inicio'];
    //echo('ERROR ');var_dump(count(explode("\n",$texto)));die;
    $sql =  ' update ps_inicio set texto = "'.$texto.'"';
    
    $re=Db::getInstance()->ExecuteS($sql);
    if ($re===false) die('ERROR al modificar el texto de inicio');
    else die('OK');
?>    


