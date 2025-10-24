<?php
include (dirname(__FILE__) . '/../../../../classes/Db.php');
include (dirname(__FILE__) . '/../../../../classes/CuponOfertaHistoricoCA.php');


//cupones 
$cancelados=array();
$cupones = explode(',',$_GET['cupones']);
$id_oferta_hist = $_GET['id_oferta_hist'];

foreach($cupones as $cupon)
{
    $cupon=str_replace('"','',$cupon);
    $cupon_oferta_hist = new CuponOfertaHistoricoCA();   
    $r=$cupon_oferta_hist->get($cupon,null,$id_oferta_hist);
    if ($cupon_oferta_hist->usado==3) $cancelados[]=$cupon;
}

if (count($cancelados)>0) die('LOS CUPONES '.implode(',',$cancelados).' NO SE VAN A ENVIAR PORQUE ESTÁN BLOQUEADOS.# Para generarlos de nuevo debe realizarse una nueva compra online.');
else die('OK');
?>