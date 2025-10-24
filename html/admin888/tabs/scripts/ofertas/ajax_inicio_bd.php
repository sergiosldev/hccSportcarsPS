<?php

    include(dirname(__FILE__).'/../../../../config/config.inc.php');
    include dirname(__FILE__).'/funciones_ofertas.php'; 
    
    $texto = $_POST['texto_inicio'];
    /*if ($_POST['lineas']>25)
    {echo ('ERROR: El número máximo de líneas debe ser 25. El número actual es de: '.$_POST['lineas']);die;}*/
  //  echo('ERROR ');var_dump(count(explode("\n",$texto)));die;
    $sql =  ' update ps_inicio set texto = "'.$texto.'"';
    
    $re=Db::getInstance()->ExecuteS($sql);
    if ($re===false) die('ERROR al modificar el texto de inicio');
    else die('OK');
?>    


