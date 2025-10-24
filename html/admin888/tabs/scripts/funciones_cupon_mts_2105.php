<?php
/** mts 04/05/2012. 
 * Funciones para mover información entre  los objetos de la clase talonario (modelo)
 *  y la base de datos (las consultas, altas y modificaciones se harán a través de éstas)
 */

include_once(dirname(__FILE__).'/../../../config/config.inc.php');

include '../../../Cupon.php';

$bd=_DB_NAME_;
$user=_DB_USER_;
$server=_DB_SERVER_;
$password=_DB_PASSWD_;
$root='images';

$connection = mysql_connect($server, $user, $password) or die ("<p class='error'>Lo sentimos, no se puede conectar con el servidor de base de datos.</p>");
mysql_select_db($bd, $connection) or die ("<p class='error'>Lo sentimos, no se puede conectar con la base de datos.</p>");




function GetCupon($inIdEstablecimiento=null,$inNumTalonario=null,$inCupon=null)
{

    if (!empty($inIdEstablecimiento) and !empty($inNumTalonario) and !empty($inCupon))
    {

        $sql = "SELECT c.fecha,c.numero,c.usado,c.id_talonario FROM ps_cupones c,ps_talonarios t WHERE c.id_establecimiento = ".$inIdEstablecimiento." and c.id_talonario=t.id_talonario and  c.id_establecimiento = t.id_establecimiento and t.numero = ".$inNumTalonario." and c.numero = ".$inCupon;
        $sql.= " ORDER BY numero ASC ";
        $query = mysql_query($sql ); 
    }
//return $sql;
    $cuponArray = array();
    while ($row = mysql_fetch_assoc($query))
    {
      
        $Cupon = new Cupon($inIdEstablecimiento, $row['id_talonario'],$row['numero'], $row['usado'],$row['fecha']);
        array_push($cuponArray, $Cupon);
    }
    return $cuponArray;
}


function GetCupones($inIdEstablecimiento=null,$inIdTalonario=null)
{
    if (!empty($inIdEstablecimiento) and !empty($inIdTalonario))
    {
        $sql = "SELECT fecha,numero,usado,vendido FROM ps_cupones WHERE id_establecimiento = ".$inIdEstablecimiento." and id_talonario=".$inIdTalonario;
        $sql.= " ORDER BY numero ASC ";
        $query = mysql_query($sql ); 
    }

    $cuponArray = array();
    while ($row = mysql_fetch_assoc($query))
    {
      
        $Cupon = new Cupon($inIdEstablecimiento, $inIdTalonario,$row['numero'], $row['usado'],$row['fecha'],$row['vendido']);
        array_push($cuponArray, $Cupon);
    }
    return $cuponArray;
}

function UpdateCupon($inIdEstablecimiento, $inIdTalonario,$inNumero,$inUsado)
{
    global $connection;
    if ($inUsado == 0)
        $sql = " UPDATE  ps_cupones set usado = ".$inUsado.", fecha = ''";
    else
        $sql = " UPDATE  ps_cupones set usado = ".$inUsado.", fecha = now()";

        $sql = $sql. " WHERE id_establecimiento = ".$inIdEstablecimiento." and id_talonario = ".$inIdTalonario." and numero = ".$inNumero;

   //return $sql;
    $result=mysql_query($sql);
    return 'OK';
 }


function UpdateCuponVendido($inIdEstablecimiento, $inNumTalonario,$inNumero,$inVendido)
{
    global $connection;
        $sql = " UPDATE  ps_cupones c,ps_talonarios t set c.vendido = ".$inVendido;
        $sql = $sql. " WHERE c.id_establecimiento = t.id_establecimiento and c.id_talonario=t.id_talonario and ";
        $sql = $sql. " c.id_establecimiento = ".$inIdEstablecimiento." and t.numero = ".$inNumTalonario." and c.numero = ".$inNumero;

    //return $sql;
    $result=mysql_query($sql);
    return 'OK';
 }


function TalonarioCupon($id_establecimiento,$numero_cupon)
{
    $sql = " select id_talonario from ps_cupones where numero=".$numero_cupon." and id_establecimiento = ".$id_establecimiento;
    $result = mysql_query($sql ); 

    $row = mysql_fetch_assoc($result);
    $id_talonario = $row['id_talonario'];    
    return $id_talonario;   
}

function NumTalonarioCupon($id_establecimiento,$numero_cupon)
{
    $sql = " select t.numero from ps_cupones c,ps_talonarios t where t.id_talonario = c.id_talonario and t.id_establecimiento = c.id_establecimiento and c.numero=".$numero_cupon." and c.id_establecimiento = ".$id_establecimiento;
    $result = mysql_query($sql ); 

    $row = mysql_fetch_assoc($result);
    $num_talonario = $row['numero'];    
    return $num_talonario;   
}



function EstablecimientoCupon($numero_cupon)
{
    $sql = " select t.id_establecimiento from ps_cupones c,ps_talonarios t where t.id_talonario = c.id_talonario and t.id_establecimiento = c.id_establecimiento and c.numero=".$numero_cupon;
    $result = mysql_query($sql ); 

    $row = mysql_fetch_assoc($result);
    $id_establecimiento = $row['id_establecimiento'];    
    return $id_establecimiento;   
}

function InsertCupon($inIdEstablecimiento,$inIdTalonario,$inNumero)
{
/**/
}
?>


