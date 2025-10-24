<?php
//Este archivo permite generar aquellos cupones que no se han llegado a genera a causas de que las notificaciones IPN no 
//han llegado, y por lo tanto no se existen datos de la transacción, sino únicamente de la reserva previa al pago.

include_once(dirname(__FILE__).'/../../../../config/config.inc.php');
include(dirname(__FILE__).'/funciones_ofertas.php');           
include(dirname(__FILE__).'/trazas.php');
include_once(dirname(__FILE__).'/../../../../mails/class.phpmailer.php');   
include(dirname(__FILE__).'/../../../../scripts/funciones_codigos.php');


$reserva = new ReservaOferta();
$r=$reserva->get(null,$_GET['codigo_reserva']);
$id_usuario = $_GET['id_usuario'];
$usuario = new Usuario();
$result = $usuario->get($id_usuario);
if ($result===false) {traza(1,'Usuario'.$id_usuario.' no encontrado');die('Usuario no encontrado');}

marca_reserva_usuario($reserva);
$idofertahist = $reserva->idOfertaHist;
$idusuario = $usuario->id;
$ncupones = '';
//Crearemos tantos cupones como la cantidad seleccionada en el momento de la compra.
for($k=1;$k<=$reserva->cantidad;$k++)
  {
	  traza('cupones_perdidos.txt','1');
		  
	  
  $ret=reserva_cupon($usuario,$reserva->codigo,$reserva->idOfertaHist,'SIN TRANSAC',null,NULL,NULL,NULL,0,0);
  //echo($ret);die;
  if ($ret[0]===false) 
  {
	  unset($usuario);
	  unset($reserva);
	  echo "Error. No se ha podido generar el cupón.";die;
  }
  else 
  {
	  if ($ncupones=='') $ncupones = $ret[1];
	  else $ncupones .= ','.$ret[1];
  }
}
unset($reserva);
unset($usuario);
die($ncupones);

  
function reserva_cupon($usuario,$codigo_reserva,$id_oferta_hist,$transaccion,$fecha_pago,$email_compra,$email_vendedor,$precio_compra,$ipn,$pdt)
   {
    $ins = 0;
    $fechaIni = date('Y-m-d H:i:s');
    $fecha_pago = date('Y-m-d H:i:s');
    $fechaFin = "";
    $descripcion = "";
    traza('cupones_perdidos.txt','2');
           
 
	$sql="SELECT id_oferta_hist FROM `ps_oferta_historico` WHERE id_oferta_hist = '".$id_oferta_hist."'";
	$re=Db::getInstance()->ExecuteS($sql);
	traza('cupones_perdidos.txt','3');
	
	if(isset($re[0]['id_oferta_hist']))
	{
		$r = $re[0];    

		$codigo_cupon = generar_codigo_cupon();
			
		$cupon_oferta_hist = new CuponOfertaHistorico($codigo_cupon,$codigo_reserva,null,$r['id_oferta_hist'],$usuario->id,$descripcion, $fechaIni, $fechaFin,0,1,null,null,$transaccion,null,$fecha_pago,null,$email_compra,$email_vendedor,$precio_compra,$ipn,$pdt,'');  
	traza('cupones_perdidos.txt','4');
	
		$ins=$cupon_oferta_hist->Insert();
	
		$result = ($ins==='0')?false:true;
		if($result){
			unset($cupon_oferta);
			unset($cupon_oferta_hist);
			traza('cupones_perdidos.txt','5');
			
			return array(true,$codigo_cupon);
		}
		else {traza('cupones_perdidos.txt','6');
			return array(false,'Error al crear el registro de histórico del cupón');}
		
	}
	else {traza('cupones_perdidos.txt','7');
		return array(true,$codigo_cupon);}


 }
    
function generar_codigo_cupon()
{
   $res = new ReservaOferta();
   $codigo_encontrado = false;  
   while(!$codigo_encontrado)
   {
   $c=genera_num();
   if ($res->get($c)===false) $codigo_encontrado=true;
   }
   unset($res); 
   return $c;
}   
  
function marca_reserva_usuario($reserva){
 $r=$reserva->UpdateCampo('_exit',1,$reserva->id);
 return $r;
 }     
?>