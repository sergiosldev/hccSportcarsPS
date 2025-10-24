<?php
/** mts 04/05/2012. 
 * Funciones para mover información entre  los objetos de la clase CuponOferta (modelo)
 *  y la base de datos (las consultas, altas y modificaciones se harán a través de éstas)
 */

//include_once(dirname(__FILE__).'/../../../config/config.inc.php');

//include dirname(__FILE__).'../../../CuponOferta.php';

/*$bd=_DB_NAME_;
$user=_DB_USER_;
$server=_DB_SERVER_;
$password=_DB_PASSWD_;
$root='images';

$link = mysqli_connect($server, $user, $password,$bd) or die ("<p class='error'>Lo sentimos, no se puede conectar con el servidor de base de datos.</p>");
*/
//mysql_select_db($bd, $connection) or die ("<p class='error'>Lo sentimos, no se puede conectar con la base de datos.</p>");




function GetCuponOferta($inIdOferta=null,$inCupon=null)
{
	global $link;
    if (!empty($inIdOferta)and !empty($inCupon))
    {

        $sql = "SELECT * FROM ps_ofertas_cupones  WHERE id_oferta = ".$inIdOferta." and cupon = '".$inCupon."'";
        $sql.= " ORDER BY CAST(cupon AS UNSIGNED) ASC ";
        $query = mysqli_query($link,$sql ); 
    }

    $cuponArray = array();
    while ($row = mysqli_fetch_assoc($query))
    {
        $Cupon = new CuponOferta($row['cupon'],$row['codigo_reserva'],$inIdOferta, $row['id_usuasrio'],$row['descripcion'], $row['fecha_ini'],$row['fecha_fin'],$row['usado'],$row['vendido'],$row['observaciones']);

        array_push($cuponArray, $Cupon);
    }
    return $cuponArray;
}


function GetCuponesOferta($inIdOferta=null)
{
	global $link;
    if (!empty($inIdOferta) )
    {
        $sql = " SELECT cupon,codigo_reserva,id_usuario,descripcion,fecha_ini,fecha_fin,usado,vendido,observaciones FROM ps_ofertas_cupones WHERE id_oferta = ".$inIdOferta;
        $sql.= " ORDER BY CAST(cupon AS UNSIGNED) ASC ";

        $query = mysqli_query($link,$sql); 
    
    }

    $cuponArray = array();
    while ($row = mysqli_fetch_assoc($query))
    {
      
        $CuponOferta = new CuponOferta($row['cupon'],$row['codigo_reserva'],$inIdOferta, $row['id_usuario'],$row['descripcion'], $row['fecha_ini'],$row['fecha_fin'],$row['usado'],$row['vendido'],$row['observaciones']);
        array_push($cuponArray, $CuponOferta);
    }
    return $cuponArray;
}

function UpdateCupon($inIdOferta, $inCupon,$inUsado)
{
    global $connection;
	global $link;
    //usado = 0: disponible, usado = 3: cancelado.
    if ($inUsado == 0 or $inUsado == 3)
    {
        $sql = " UPDATE  ps_ofertas_cupones set usado = ".$inUsado.", fecha_ini = ''";
    }
    else
        $sql = " UPDATE  ps_ofertas_cupones set usado = ".$inUsado.", fecha_ini = now()";

        $sql = $sql. " WHERE id_oferta = ".$inIdOferta." and cupon= ".$inCupon;

   //return $sql;
    $result=mysqli_query($link,$sql);
    return 'OK';
 }


function UpdateCuponObservaciones($inIdOferta,$inCupon,$inObservaciones)
{
	global $link;
    $sql = " UPDATE  ps_ofertas_cupones set observaciones = '".$inObservaciones."' ";
    $sql = $sql. " WHERE id_oferta = ".$inIdOferta." and cupon = ".$inCupon;

   //return $sql;
    $result=mysqli_query($link,$sql);
    return 'OK';
 }



function UpdateCuponVendido($inIdOferta,$inCupon,$inVendido)
{
	global $link;

	$sql = " UPDATE  ps_ofertas_cupones , set vendido = ".$inVendido;
	$sql = $sql. " WHERE id_oferta = ".$inIdOferta." and cupon = ".$inCupon;

    //return $sql;
    $result=mysqli_query($link,$sql);
    return 'OK';
 }

function OfertaCupon($cupon)
{
	global $link;
	
    $sql = " select id_oferta from ps_ofertas_cupones where cupon=".$cupon;
    $result = mysqli_query($link,$sql); 

    $row = mysqli_fetch_assoc($result);
    $id_oferta = $row['id_oferta'];    
    return $id_oferta;   
}




