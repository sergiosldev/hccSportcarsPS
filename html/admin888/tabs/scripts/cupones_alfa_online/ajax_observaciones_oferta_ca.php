<?php
//mts 12062012. Fichero ajax para leer las observaciones de un cupón..
include dirname(__FILE__).'/funciones_cupon_oferta_ca.php'; 
include dirname(__FILE__).'/funciones_cupon_oferta_historico_ca.php'; 
$c_id_oferta=$_GET['id_oferta'];
$c_cupon=$_GET['cupon'];
//die('creadas: '.$_GET['creadas'].' idoferta: '.$c_id_oferta.' cupon: '.$c_cupon);    
if ($_GET['creadas']=='1')
    $cupon = GetCuponOferta($c_id_oferta,$c_cupon);
else
    if (isset($_GET['id_distribuidor']))
    $cupon = GetCuponOfertaHistorico(null,$c_cupon,null,$id_distribuidor);
    else $cupon = GetCuponOfertaHistorico($c_id_oferta,$c_cupon);

    $cupon = $cupon[0];
echo($cupon->observaciones);   

?>