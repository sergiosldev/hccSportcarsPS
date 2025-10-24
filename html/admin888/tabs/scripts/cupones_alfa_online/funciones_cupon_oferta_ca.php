<?php
/** mts 04/05/2012. 
 * Funciones para mover información entre  los objetos de la clase CuponOferta (modelo)
 *  y la base de datos (las consultas, altas y modificaciones se harán a través de éstas)
 */

include_once(dirname(__FILE__).'/../../../../config/config.inc.php');

include '../../../../classes/CuponOferta.php';

$bd=_DB_NAME_;
$user=_DB_USER_;
$server=_DB_SERVER_;
$password=_DB_PASSWD_;
$root='images';
$sufijo = '_distribuidores';

$connection = mysql_connect($server, $user, $password) or die ("<p class='error'>Lo sentimos, no se puede conectar con el servidor de base de datos.</p>");
mysql_select_db($bd, $connection) or die ("<p class='error'>Lo sentimos, no se puede conectar con la base de datos.</p>");




function GetCuponOferta($inIdOferta=null,$inCupon=null)
{
    global $sufijo;

    if (!empty($inIdOferta)and !empty($inCupon))
    {

        $sql = "SELECT * FROM ps_ofertas_cupones".$sufijo."  WHERE id_oferta = ".$inIdOferta." and cupon = '".$inCupon."'";
        $sql.= " ORDER BY CAST(cupon AS UNSIGNED) ASC ";
        $query = mysql_query($sql ); 
    }

    $cuponArray = array();
    while ($row = mysql_fetch_assoc($query))
    {
        $Cupon = new CuponOfertaCA($row['cupon'],$row['codigo_reserva'],$inIdOferta, $row['id_distribuidor'],$row['descripcion'], $row['fecha_ini'],$row['fecha_fin'],$row['usado'],$row['vendido'],$row['observaciones']);

        array_push($cuponArray, $Cupon);
    }
    return $cuponArray;
}


function GetCuponesOferta($inIdOferta=null)
{
    global $sufijo;
    
    if (!empty($inIdOferta) )
    {
        $sql = " SELECT cupon,codigo_reserva,id_distribuidor,descripcion,fecha_ini,fecha_fin,usado,vendido,observaciones FROM ps_ofertas_cupones".$sufijo." WHERE id_oferta = ".$inIdOferta;
        $sql.= " ORDER BY CAST(cupon AS UNSIGNED) ASC ";

        $query = mysql_query($sql ); 
    
    }

    $cuponArray = array();
    while ($row = mysql_fetch_assoc($query))
    {
      
        $CuponOferta = new CuponOfertaCA($row['cupon'],$row['codigo_reserva'],$inIdOferta, $row['id_distribuidor'],$row['descripcion'], $row['fecha_ini'],$row['fecha_fin'],$row['usado'],$row['vendido'],$row['observaciones']);
        array_push($cuponArray, $CuponOferta);
    }
    return $cuponArray;
}

function UpdateCupon($inIdOferta, $inCupon,$inUsado)
{
    global $connection;
    global $sufijo;
    //usado = 0: disponible, usado = 3: cancelado.
    if ($inUsado == 0 or $inUsado == 3)
    {
        $sql = " UPDATE  ps_ofertas_cupones".$sufijo." set usado = ".$inUsado.", fecha_ini = ''";
    }
    else
        $sql = " UPDATE  ps_ofertas_cupones".$sufijo." set usado = ".$inUsado.", fecha_ini = now()";

        $sql = $sql. " WHERE id_oferta = ".$inIdOferta." and cupon= ".$inCupon;

   //return $sql;
    $result=mysql_query($sql);
    return 'OK';
 }


function UpdateCuponObservaciones($inIdOferta,$inCupon,$inObservaciones)
{
    global $connection;
    global $sufijo;
    $sql = " UPDATE  ps_ofertas_cupones".$sufijo ." set observaciones = '".$inObservaciones."' ";
    $sql = $sql. " WHERE id_oferta = ".$inIdOferta." and cupon = ".$inCupon;

   //return $sql;
    $result=mysql_query($sql);
    return 'OK';
 }



function UpdateCuponVendido($inIdOferta,$inCupon,$inVendido)
{
    global $connection;
    global $sufijo;
        $sql = " UPDATE  ps_ofertas_cupones".$sufijo." set vendido = ".$inVendido;
        $sql = $sql. " WHERE id_oferta = ".$inIdOferta." and cupon = ".$inCupon;

    //return $sql;
    $result=mysql_query($sql);
    return 'OK';
 }

function OfertaCupon($cupon)
{
    global $sufijo;
    $sql = " select id_oferta from ps_ofertas_cupones".$sufijo." where cupon=".$cupon;
    $result = mysql_query($sql ); 

    $row = mysql_fetch_assoc($result);
    $id_oferta = $row['id_oferta'];    
    return $id_oferta;   
}




