<?php
/** mts 04/05/2012. 
 * Funciones para mover información entre  los objetos de la clase CuponOferta (modelo)
 *  y la base de datos (las consultas, altas y modificaciones se harán a través de éstas)
 */

include_once(dirname(__FILE__).'/../../../config/config.inc.php');

include '../../../CuponOferta.php';

$bd=_DB_NAME_;
$user=_DB_USER_;
$server=_DB_SERVER_;
$password=_DB_PASSWD_;
$root='images';

$connection = mysql_connect($server, $user, $password) or die ("<p class='error'>Lo sentimos, no se puede conectar con el servidor de base de datos.</p>");
mysql_select_db($bd, $connection) or die ("<p class='error'>Lo sentimos, no se puede conectar con la base de datos.</p>");




function GetCuponOfertaHistorico($inIdOferta=null,$inCupon=null)
{
   
    if (!empty($inIdOferta)and !empty($inCupon))
    {

        $sql = "SELECT * FROM ps_ofertas_cupones_historico  WHERE id_oferta_hist = ".$inIdOferta." and cupon = '".$inCupon."'";
        //$sql.= " ORDER BY CAST(cupon AS UNSIGNED) ASC ";
        $sql.= " ORDER BY cupon ASC ";
   
        $query = mysql_query($sql); 
    
    }

    $cuponArray = array();
    while ($row = mysql_fetch_assoc($query))
    {
        $Cupon = new CuponOfertaHistorico($row['cupon'],$row['codigo_reserva'],null,$inIdOferta,$row['id_usuario'],$row['descripcion'], $row['fecha_ini'],$row['fecha_fin'],$row['usado'],$row['vendido'],$row['observaciones'],$row['pdf_generado'],$row['transaccion_compra'],$row['transaccion_rembolso'],$row['fecha_compra'],$row['fecha_rembolso'],$row['email_compra'],$row['email_vendedor'],$row['precio_compra'],$row['ipn'],$row['pdt']);

        array_push($cuponArray, $Cupon);
    }
    return $cuponArray;
}


function GetCuponesOfertaHistorico($inIdOferta=null,$inTransaccionCompra=null,$inTransaccionRembolso=null,$inCupon=null)
{
    $where = '';         
    if ($inIdOferta!=null) $where .= (($where!='')?'and':'').' id_oferta_hist = '.$inIdOferta;    
    if ($inTransaccionCompra!=null) $where .= (($where!='')?'and':'').' transaccion_compra = "'.$inTransaccionCompra.'"';    
    if ($inTransaccionRembolso!=null) $where .= (($where!='')?'and':'').' transaccion_rembolso = "'.$inTransaccionRembolso.'"';    
    if ($inCupon!=null) $where .= (($where!='')?'and':'').' cupon = "'.$inCupon.'"';    
    if ($where=='') $where = ' WHERE false '; 
    else $where = ' WHERE '.$where;

    $sql = " SELECT * FROM ps_ofertas_cupones_historico ".$where;
    //$sql.= " ORDER BY CAST(cupon AS UNSIGNED) ASC ";
    $sql.= " ORDER BY cupon ASC ";
//return($sql);
    $query = mysql_query($sql ); 
    
    $cuponArray = array();
    while ($row = mysql_fetch_assoc($query))
    {
      
        $CuponOferta = new CuponOfertaHistorico($row['cupon'],$row['codigo_reserva'],null,$row['id_oferta_hist'], $row['id_usuario'],$row['descripcion'], $row['fecha_ini'],$row['fecha_fin'],$row['usado'],$row['vendido'],$row['observaciones'],$row['pdf_generado'],$row['transaccion_compra'],$row['transaccion_rembolso'],$row['fecha_compra'],$row['fecha_rembolso'],$row['email_compra'],$row['email_vendedor'],$row['precio_compra'],$row['ipn'],$row['pdt']);
        array_push($cuponArray, $CuponOferta);
    }
    return $cuponArray;
}

function UpdateCuponHistorico($inIdOferta, $inCupon,$inUsado)
{
    global $connection;
    // usado = 0: cupón disponible, usado = 3: cupón cancelado.
    if ($inUsado == 0 or $inUsado == 3)
    {
        $sql = " UPDATE  ps_ofertas_cupones_historico set usado = ".$inUsado.", fecha_ini = ''";
    }
    //cupón = 1: cupón validado.
    else
        $sql = " UPDATE  ps_ofertas_cupones_historico set usado = ".$inUsado.", fecha_ini = now()";

        $sql = $sql. " WHERE id_oferta_hist = ".$inIdOferta." and cupon= '".$inCupon."'";

   //return $sql;
    $result=mysql_query($sql);
    return 'OK';
 }


function UpdateCuponObservacionesHistorico($inIdOferta,$inCupon,$inObservaciones)
{
    global $connection;
    $sql = " UPDATE  ps_ofertas_cupones_historico set observaciones = '".$inObservaciones."' ";
    $sql = $sql. " WHERE id_oferta_hist = ".$inIdOferta." and cupon = '".$inCupon."'";

   //return $sql;
    $result=mysql_query($sql);
    return 'OK';
 }



function UpdateCuponVendidoHistorico($inIdOferta,$inCupon,$inVendido)
{
    global $connection;
        $sql = " UPDATE  ps_ofertas_cupones , set vendido = ".$inVendido;
        $sql = $sql. " WHERE id_oferta_hist = ".$inIdOferta." and cupon = '".$inCupon."'";

    //return $sql;
    $result=mysql_query($sql);
    return 'OK';
}

function OfertaCuponHistorico($cupon)
{
    if (strlen($cupon)==13)
        $sql = " select id_oferta_hist from ps_ofertas_cupones_historico where cupon='".$cupon."'";
    else 
        $sql = " select id_oferta_hist from ps_ofertas_cupones_historico where transaccion_compra='".$cupon."'";

    $result = mysql_query($sql ); 

    $row = mysql_fetch_assoc($result);
    $id_oferta = $row['id_oferta_hist'];    
    return $id_oferta;   
}




