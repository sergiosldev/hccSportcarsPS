<?php
//mts 12062012. Fichero ajax para leer las observaciones de un cupón..
include dirname(__FILE__).'/funciones_cupon.php'; 
include dirname(__FILE__).'/funciones_talonario.php'; 
$c_id_establecimiento=$_GET['id_establecimiento'];
$c_numero_talonario=$_GET['numero_talonario'];
$c_numero_cupon=$_GET['numero_cupon'];
$c_id_talonario = $_GET['id_talonario'];

if ($c_numero_cupon==0) //si el no. cupón es cero estaremos tratando las observaciones del talonario.
{
    $talonario= GetTalonario($c_id_establecimiento,$c_id_talonario);
    echo($talonario->observaciones);   
}   
else 
{
    $cupon = GetCupon($c_id_establecimiento,$c_numero_talonario,$c_numero_cupon);
    $cupon = $cupon[0];
    echo($cupon->observaciones);   
} 

?>