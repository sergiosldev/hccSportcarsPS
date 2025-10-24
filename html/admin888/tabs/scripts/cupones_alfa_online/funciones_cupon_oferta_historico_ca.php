<?php
/** mts 04/05/2012. 
 * Funciones para mover información entre  los objetos de la clase CuponOferta (modelo)
 *  y la base de datos (las consultas, altas y modificaciones se harán a través de éstas)
 */

include_once(dirname(__FILE__).'/../../../../config/config.inc.php');
//include_once(dirname(__FILE__).'././../../../classes/CuponOfertaCA.php';
//include '../../../../classes/CuponOfertaHistoricoCA.php';
//include '../../../../classes/Db.php';
//include '../trazas.php';


$sufijo = '_distribuidores';


 
function GetCuponOfertaHistorico($inIdOferta=null,$inCupon=null)
{
    global $sufijo;
   
    $where = "true ";
    
    if (!empty($inIdOferta)) $where.=" and  id_oferta_hist = '".intval($inIdOferta)."'";
    if (!empty($inCupon)) $where.=" and cupon = '".pSQL($inCupon)."'";
    
    $sql = "SELECT * FROM ps_ofertas_cupones_historico".$sufijo."  WHERE ".$where;
    //$sql.= " ORDER BY CAST(cupon AS UNSIGNED) ASC ";
    $sql.= " ORDER BY cupon ASC ";
   
    //$query = mysql_query($sql);
    $query=Db::getInstance()->ExecuteS($sql);
    
    

    $cuponArray = array();
    foreach($query as $row)
    //while ($row = mysql_fetch_assoc($query))
    {
        $Cupon = new CuponOfertaHistoricoCA($row['cupon'],$row['codigo_reserva'],null,intval($inIdOferta),$row['id_distribuidor'],$row['descripcion'], $row['fecha_ini'],$row['fecha_fin'],$row['usado'],$row['vendido'],$row['observaciones'],$row['pdf_generado'],$row['transaccion_compra'],$row['transaccion_rembolso'],$row['fecha_compra'],$row['fecha_rembolso'],$row['email_compra'],$row['email_vendedor'],$row['precio_compra'],$row['ipn'],$row['pdt']);

        array_push($cuponArray, $Cupon);
    }
    return $cuponArray;
}


function GetCuponesOfertaHistorico($inIdOferta=null,$inTransaccionCompra=null,$inTransaccionRembolso=null,$inCupon=null,$inIdDistribuidor=null)
{
    global $sufijo;
    $where = '';         
    if ($inIdOferta!=null) $where .= (($where!='')?' and':'').' id_oferta_hist = '.intval($inIdOferta);    
    if ($inTransaccionCompra!=null) $where .= (($where!='')?' and':'').' transaccion_compra = "'.pSQL($inTransaccionCompra).'"';    
    if ($inTransaccionRembolso!=null) $where .= (($where!='')?' and':'').' transaccion_rembolso = "'.pSQL($inTransaccionRembolso).'"';    
    if ($inCupon!=null) $where .= (($where!='')?' and':'').' cupon = "'.pSQL($inCupon).'"';    
    if ($inIdDistribuidor!=null) $where .= (($where!='')?' and':'').' id_distribuidor = "'.intval($inIdDistribuidor).'"';  
	else $where .= (($where!='')?' and':'').' id_distribuidor != "'._DISTRIBUIDOR_PRUEBA_.'"';  
    
    if ($where=='') $where = ' WHERE false '; 
    else $where = ' WHERE '.$where;

    $sql = " SELECT * FROM ps_ofertas_cupones_historico".$sufijo." ".$where;
    //$sql.= " ORDER BY CAST(cupon AS UNSIGNED) ASC ";
    $sql.= " ORDER BY cupon ASC ";
//die($sql);
	//return($sql);
    //$query = mysql_query($sql ); 
    $query=Db::getInstance()->ExecuteS($sql);    
    $cuponArray = array();
    
    foreach($query as $row)
    //while ($row = mysql_fetch_assoc($query))
    {
                                                
        $CuponOferta = new CuponOfertaHistoricoCA($row['cupon'],$row['codigo_reserva'],null,intval($row['id_oferta_hist']), intval($row['id_distribuidor']),$row['descripcion'], $row['fecha_ini'],$row['fecha_fin'],$row['usado'],$row['vendido'],$row['observaciones'],$row['pdf_generado'],$row['transaccion_compra'],$row['transaccion_rembolso'],$row['fecha_compra'],$row['fecha_rembolso'],$row['email_compra'],$row['email_vendedor'],$row['precio_compra'],'',$row['facturado'],$row['cobrado'],$row['comercial']);
        array_push($cuponArray, $CuponOferta);
    }
    return $cuponArray;
}

function UpdateCuponHistorico($inIdOferta, $inCupon,$inUsado)
{
    global $connection;
    global $sufijo;
    // usado = 0: cupón disponible, usado = 3: cupón cancelado.

    //0: no usado, 1: usado, 3:cancelado.
    if ($inUsado == 0 or $inUsado==3)
        $sql = " UPDATE  ps_ofertas_cupones_historico".$sufijo." set usado = ".intval($inUsado).", fecha_ini = ''";
    //ponemos (5) o quitamos (6) la marca de facturado.
    else if ($inUsado == 5 or $inUsado == 6)
        $sql = " UPDATE  ps_ofertas_cupones_historico".$sufijo." set facturado = ".((intval($inUsado)==5)?1:0);
    //ponemos (7) o quitamos (8) la marca de facturado.
    else if ($inUsado == 7 or $inUsado == 8)
        $sql = " UPDATE  ps_ofertas_cupones_historico".$sufijo." set cobrado = ".((intval($inUsado)==7)?1:0);
    //ponemos (9) o quitamos (10) la marca de facturado.
    else if ($inUsado == 9 or $inUsado == 10)
        $sql = " UPDATE ps_ofertas_cupones_historico".$sufijo." set comercial = ".((intval($inUsado)==9)?1:0);
    //cupón = 1: cupón validado.
            else
        $sql = " UPDATE  ps_ofertas_cupones_historico".$sufijo." set usado = ".intval($inUsado).", fecha_ini = now()";
    
    $where = " true ";
    if (!empty($inIdOferta))  $where .= " and id_oferta_hist = '".intval($inIdOferta)."' ";
    if (!empty($inCupon))  $where .= " and cupon = '".pSQL($inCupon)."' ";
    else $where = "";

    if ($where != '')
    $sql.= ' WHERE '.$where;
//traza('test_cupon.txt',$sql);
   //return $sql;
    $result=mysql_query($sql);
    return 'OK';
 }


function UpdateCuponObservacionesHistorico($inIdOferta,$inCupon,$inObservaciones)
{
    global $connection;
    global $sufijo;
    $sql = " UPDATE  ps_ofertas_cupones_historico".$sufijo." set observaciones = '".pSQL($inObservaciones)."' ";
    $where = " true ";
    if (!empty($inIdOferta))  $where .= " and id_oferta_hist = '".intval($inIdOferta)."' ";
    if (!empty($inCupon))  $where .= " and cupon = '".pSQL($inCupon)."' ";
    else $where = "";

    if ($where != '')
    $sql.= ' WHERE '.$where;

   //return $sql;
    //$result=mysql_query($sql);
    $result=Db::getInstance()->Execute($sql);
    return 'OK';
 }



function UpdateCuponVendidoHistorico($inIdOferta,$inCupon,$inVendido)
{
    global $connection;
    global $sufijo;
        $sql = " UPDATE  ps_ofertas_cupones".$sufijo."  set vendido = ".intval($inVendido);
        $where = " true ";
        if (!empty($inIdOferta))  $where .= " and id_oferta_hist = '".intval($inIdOferta)."' ";
        if (!empty($inCupon))  $where .= " and cupon = '".pSQL($inCupon)."' ";
        else $where = "";
    
        if ($where != '')
        $sql.= ' WHERE '.$where;

    //return $sql;
    //$result=mysql_query($sql);
    $result=Db::getInstance()->Execute($sql);
    return 'OK';
}

function OfertaCuponHistorico($cupon)
{
    global $sufijo;
    $sql = " select id_oferta_hist from ps_ofertas_cupones_historico".$sufijo." where cupon='".pSQL($cupon)."'";

    //$result = mysql_query($sql ); 
    $result=Db::getInstance()->ExecuteS($sql);
    //$row = mysql_fetch_assoc($result);
    $row=$result[0];
    $id_oferta = intval($row['id_oferta_hist']);    
    return $id_oferta;   
}




