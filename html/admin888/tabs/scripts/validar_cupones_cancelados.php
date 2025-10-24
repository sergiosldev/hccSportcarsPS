<?php
include_once (dirname(__FILE__) . '/../../../config/config.inc.php');
include_once (dirname(__FILE__) . '/../../../classes/Db.php');
include_once (dirname(__FILE__) . '/../../../classes/CuponOfertaHistorico.php');


//cupones 
$cancelados=array();
$cupones = explode(',',$_GET['cupones']);
$id_oferta_hist = $_GET['id_oferta_hist'];
foreach($cupones as $cupon) 
{
    $strcupon=str_replace('"','',$cupon);
    $cupon_oferta_hist = new CuponOfertaHistorico();   
    $r=$cupon_oferta_hist->get($strcupon,null,$id_oferta_hist);
 	if ($cupon_oferta_hist->usado==3) $cancelados[]=$strcupon;
}

if (count($cancelados)>0) 
	{	
	if (count($cancelados)==count($cupones)) $todos_cancelados = 1;
	else $todos_cancelados=0;
	die($todos_cancelados.'#LOS CUPONES '.implode(',',$cancelados).' NO SE VAN A ENVIAR PORQUE ESTÁN BLOQUEADOS.# Para generarlos de nuevo debe realizarse una nueva compra online.');
	}
else die('OK');
?>