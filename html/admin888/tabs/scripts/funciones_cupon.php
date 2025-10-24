<?php
/** mts 04/05/2012. 
 * Funciones para mover información entre  los objetos de la clase talonario (modelo)
 *  y la base de datos (las consultas, altas y modificaciones se harán a través de éstas)
 */

include_once(dirname(__FILE__).'/../../../config/config.inc.php');
include_once('config_events_new.php') ;

include '../../../Cupon.php';




function GetCupon($inIdEstablecimiento=null,$inNumTalonario=null,$inCupon=null)
{
	global $link;

    if (!empty($inIdEstablecimiento) and !empty($inNumTalonario) and !empty($inCupon))
    {

        $sql = "SELECT c.fecha,c.numero,c.usado,c.id_talonario,c.vendido,c.observaciones FROM ps_cupones c,ps_talonarios t WHERE c.id_establecimiento = ".$inIdEstablecimiento." and c.id_talonario=t.id_talonario and  c.id_establecimiento = t.id_establecimiento and t.numero = ".$inNumTalonario." and c.numero = ".$inCupon;
        $sql.= " ORDER BY numero ASC ";
        $query = mysqli_query($link,$sql ); 
    }
//return $sql;
    $cuponArray = array();
    while ($row = mysqli_fetch_assoc($query))
    {
        $Cupon = new Cupon($inIdEstablecimiento, $row['id_talonario'],$row['numero'], $row['usado'],$row['fecha'],$row['vendido'],$row['observaciones']);
        array_push($cuponArray, $Cupon);
    }
    return $cuponArray;
}


function GetCupones($inIdEstablecimiento=null,$inIdTalonario=null)
{
	global $link;
    if (!empty($inIdEstablecimiento) and !empty($inIdTalonario))
    {
        $sql = "SELECT fecha,fecha_venta,numero,usado,vendido,observaciones,facturado,cobrado,comercial FROM ps_cupones WHERE id_establecimiento = ".$inIdEstablecimiento." and id_talonario=".$inIdTalonario;
        $sql.= " ORDER BY CAST(numero AS UNSIGNED) ASC ";
        $query = mysqli_query($link,$sql ); 
    }

    $cuponArray = array();
    while ($row = mysqli_fetch_assoc($query))
    {
      
        $Cupon = new Cupon($inIdEstablecimiento, $inIdTalonario,$row['numero'], $row['usado'],$row['fecha'],$row['vendido'],$row['observaciones'],$row['facturado'],$row['cobrado'],$row['comercial'],$row['fecha_venta']);
        array_push($cuponArray, $Cupon);
    }
    return $cuponArray;
}
  
function UpdateCupon($inIdEstablecimiento, $inIdTalonario,$inNumero,$inUsado)
{
    global $link;
    //0: no usado, 1: usado, 3:cancelado.
    if ($inUsado == 0 or $inUsado==3)
        $sql = " UPDATE  ps_cupones set usado = ".$inUsado.", fecha = ''";
    //ponemos (4) o quitamos (5) la marca de facturado.
    else if ($inUsado == 4 or $inUsado == 5)
        $sql = " UPDATE  ps_cupones set facturado = ".(($inUsado==4)?1:0);
    else if ($inUsado == 6 or $inUsado == 7)
        $sql = " UPDATE  ps_cupones set cobrado = ".(($inUsado==6)?1:0);
    else if ($inUsado == 8 or $inUsado == 9)
        $sql = " UPDATE  ps_cupones set comercial = ".(($inUsado==8)?1:0);
    else
        $sql = " UPDATE  ps_cupones set usado = ".$inUsado.", fecha = now()";

        $sql = $sql. " WHERE id_establecimiento = ".$inIdEstablecimiento." and id_talonario = ".$inIdTalonario." and numero = ".$inNumero;

        
        
        
   //return $sql;
    $result=mysqli_query($link,$sql);
    return 'OK';
 }
     
 
function UpdateCuponObservaciones($inIdEstablecimiento, $inIdTalonario,$inNumero,$inObservaciones)  
{
    global $link;
    $sql = " UPDATE  ps_cupones set observaciones = '".$inObservaciones."' ";
    $sql = $sql. " WHERE id_establecimiento = ".$inIdEstablecimiento." and id_talonario = ".$inIdTalonario." and numero = ".$inNumero;

   //return $sql;
    $result=mysqli_query($link,$sql);
    return 'OK';
 }



function UpdateCuponVendido($inIdEstablecimiento, $inIdTalonario,$inNumero,$inVendido)
{
    global $link;
	$sql = " UPDATE  ps_cupones c,ps_talonarios t set c.vendido = ".$inVendido;
	if ($inVendido=='1') $sql .= ",c.fecha_venta = '".date("Y-n-j H:i:s")."'";
	$sql = $sql. " WHERE c.id_establecimiento = t.id_establecimiento and c.id_talonario=t.id_talonario and ";
	$sql = $sql. " c.id_establecimiento = ".$inIdEstablecimiento." and t.id_talonario = ".$inIdTalonario." and c.numero = ".$inNumero;

    $result=mysqli_query($link,$sql);
    return 'OK';
 }


function TalonarioCupon($id_establecimiento,$numero_cupon)
{
	global $link;
    $sql = " select id_talonario from ps_cupones where numero=".$numero_cupon." and id_establecimiento = ".$id_establecimiento;
    $result = mysqli_query($link,$sql); 

    $row = mysqli_fetch_assoc($result);
    $id_talonario = $row['id_talonario'];    
    return $id_talonario;   
}

function NumTalonarioCupon($id_establecimiento,$numero_cupon)
{
	global $link;
    $sql = " select t.numero from ps_cupones c,ps_talonarios t where t.id_talonario = c.id_talonario and t.id_establecimiento = c.id_establecimiento and c.numero=".$numero_cupon." and c.id_establecimiento = ".$id_establecimiento;
    $result = mysqli_query($link,$sql ); 

    $row = mysqli_fetch_assoc($result);
    $num_talonario = $row['numero'];    
    return $num_talonario;   
}



function EstablecimientoCupon($numero_cupon)
{
	global $link;
    $sql = " select t.id_establecimiento from ps_cupones c,ps_talonarios t where t.id_talonario = c.id_talonario and t.id_establecimiento = c.id_establecimiento and c.numero=".$numero_cupon;
    $result = mysqli_query($link,$sql ); 

    $row = mysqli_fetch_assoc($result);
    $id_establecimiento = $row['id_establecimiento'];    
    return $id_establecimiento;   
}

function InsertCupon($inIdEstablecimiento,$inIdTalonario,$inNumero)
{
/**/
}
?>


