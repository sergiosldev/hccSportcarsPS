<?php
/** mts 04/05/2012. 
 * Funciones para mover información entre  los objetos de la clase CuponOferta (modelo)
 *  y la base de datos (las consultas, altas y modificaciones se harán a través de éstas)
 */

//include_once(dirname(__FILE__).'/../../../config/config.inc.php');
 
include_once(dirname(__FILE__).'/config_events_new.php');

function GetCuponOfertaHistorico($inIdOferta=null,$inCupon=null)
{
	global $link;
    if (!empty($inIdOferta)and !empty($inCupon))
    {

        $sql = "SELECT * FROM ps_ofertas_cupones_historico  WHERE id_oferta_hist = ".intval($inIdOferta)." and cupon = '".pSQL($inCupon)."'";
        //$sql.= " ORDER BY CAST(cupon AS UNSIGNED) ASC ";
        $sql.= " ORDER BY cupon ASC ";
   
        $query = mysqli_query($link,$sql); 
    
    }


	
    $cuponArray = array();
    while ($row = mysqli_fetch_assoc($query))
    {
        $Cupon = new CuponOfertaHistorico($row['cupon'],$row['codigo_reserva'],null,intval($inIdOferta),intval($row['id_usuario']),$row['descripcion'], $row['fecha_ini'],$row['fecha_fin'],$row['usado'],$row['vendido'],$row['observaciones'],$row['pdf_generado'],$row['transaccion_compra'],$row['transaccion_rembolso'],$row['fecha_compra'],$row['fecha_rembolso'],$row['email_compra'],$row['email_vendedor'],$row['precio_compra'],$row['ipn'],$row['pdt'],$row['descripcion'],$row['empresa']);
		$Cupon->idOpcionOferta = $row['id_opcion_oferta'];
        array_push($cuponArray, $Cupon);
    }
    return $cuponArray;
}


function GetCuponesOfertaHistorico($inIdOferta=null,$inTransaccionCompra=null,$inTransaccionRembolso=null,$inCupon=null)
{
	global $link;
	
    $where = '';         
    if ($inIdOferta!=null) $where .= (($where!='')?'and':'').' id_oferta_hist = '.intval($inIdOferta);    
    if ($inTransaccionCompra!=null) $where .= (($where!='')?'and':'').' transaccion_compra = "'.pSQL($inTransaccionCompra).'"';      
    if ($inTransaccionRembolso!=null) $where .= (($where!='')?'and':'').' transaccion_rembolso = "'.pSQL($inTransaccionRembolso).'"';    
    if ($inCupon!=null) $where .= (($where!='')?'and':'').' cupon = "'.pSQL($inCupon).'"';    
    if ($where=='') $where = ' WHERE false '; 
    else $where = ' WHERE '.$where;

    $sql = " SELECT * FROM ps_ofertas_cupones_historico ".$where;
    //$sql.= " ORDER BY CAST(cupon AS UNSIGNED) ASC ";
    $sql.= " ORDER BY cupon ASC ";
//return($sql);
	//die($sql);
	//if ($inIdOferta==515) die($sql);
    $query = mysqli_query($link,$sql );
	//echo($sql);var_dump($query);die;	
    //var_dump($query);die;
    $cuponArray = array();
    while ($row = mysqli_fetch_assoc($query))
    {
      
        $CuponOferta = new CuponOfertaHistorico($row['cupon'],$row['codigo_reserva'],null,intval($row['id_oferta_hist']), intval($row['id_usuario']),$row['descripcion'], $row['fecha_ini'],$row['fecha_fin'],$row['usado'],$row['vendido'],$row['observaciones'],$row['pdf_generado'],$row['transaccion_compra'],$row['transaccion_rembolso'],$row['fecha_compra'],$row['fecha_rembolso'],$row['email_compra'],$row['email_vendedor'],$row['precio_compra'],$row['ipn'],$row['pdt'],$row['descripcion'],$row['empresa']);                                               
		$CuponOferta->idOpcionOferta = $row['id_opcion_oferta'];
		$CuponOferta->transaccionCompra = $row['transaccion_compra'];

        array_push($cuponArray, $CuponOferta);
    }
    return $cuponArray;
}

function UpdateCuponHistorico($inIdOferta, $inCupon,$inUsado)
{
    global $link;
    // usado = 0: cupón disponible, usado = 3: cupón cancelado.
    if ($inUsado == 0 or $inUsado == 3)
    {
        $sql = " UPDATE  ps_ofertas_cupones_historico set usado = ".intval($inUsado).", fecha_ini = ''";
    }
    //cupón = 1: cupón validado.
    else
        $sql = " UPDATE  ps_ofertas_cupones_historico set usado = ".intval($inUsado).", fecha_ini = now()";

        $sql = $sql. " WHERE id_oferta_hist = ".$inIdOferta." and cupon= '".pSQL($inCupon)."'";

   //return $sql;
    $result=mysqli_query($link,$sql);
    return 'OK';
 }


function UpdateCuponObservacionesHistorico($inIdOferta,$inCupon,$inObservaciones)
{
    global $link;
    $sql = " UPDATE  ps_ofertas_cupones_historico set observaciones = '".pSQL($inObservaciones)."' ";
    $sql = $sql. " WHERE id_oferta_hist = ".intval($inIdOferta)." and cupon = '".pSQL($inCupon)."'";

   //return $sql;
    $result=mysqli_query($link,$sql);
    return 'OK';
 }



function UpdateCuponVendidoHistorico($inIdOferta,$inCupon,$inVendido)
{
    global $link;
        $sql = " UPDATE  ps_ofertas_cupones , set vendido = ".intval($inVendido);
        $sql = $sql. " WHERE id_oferta_hist = ".intval($inIdOferta)." and cupon = '".pSQL($inCupon)."'";

    //return $sql;
    $result=mysqli_query($link,$sql);
    return 'OK';
}
 
function OfertaCuponHistorico($cupon)
{
	global $link;
    if (strlen($cupon)==13)
	{
		$sql = " select id_oferta_hist from ps_ofertas_cupones_historico where cupon='".pSQL($cupon)."'";
	}        
    else if (strpos($cupon,'<br>')!==false)
	{
		$sql = " select id_oferta_hist from ps_ofertas_cupones_historico ";
		$cupones=explode('<br>',$cupon);
		$k=0;
		foreach ($cupones as $cup)
		{
			if (!$k)
				$w.="'".pSQL($cup)."'";
			else 
				$w.=",'".pSQL($cup)."'";
			$k=1;
		}
		$w=' where cupon in ('.$w.')';
		$sql.=$w;
	}
	else 
	{
		$sql = " select id_oferta_hist from ps_ofertas_cupones_historico where transaccion_compra='".pSQL($cupon)."'";
	}
        

	//die($sql);
    $result = mysqli_query($link,$sql ); 

    $row = mysqli_fetch_assoc($result);

    $id_oferta = $row['id_oferta_hist'];    
    return $id_oferta;   
}




