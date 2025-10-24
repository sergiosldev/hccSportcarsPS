<?php
function traza($fichero,$texto)
{
    file_put_contents($fichero, "[".date("r")."] : $texto".PHP_EOL, FILE_APPEND | LOCK_EX); 
} 


function traza2($fichero,$texto)
{
    file_put_contents($fichero, $texto.PHP_EOL, FILE_APPEND | LOCK_EX); 
} 
?>