<?php
//mts 12062012. Fichero Ajax para enviar la confirmación a un establecimiento desde el listado de cupones.
include (dirname(__FILE__).'/../../../config/defines.inc.php');
include dirname(__FILE__).'/funciones_cupon_oferta.php'; 
include dirname(__FILE__).'/funciones_cupon_oferta_historico.php'; 
include dirname(__FILE__).'/funciones_ofertas.php'; 
$c_id_oferta=$_GET['id_oferta'];
$c_cupon=$_GET['cupon'];
$c_email=$_GET['email'];

if ($_GET['creadas']=="1")    
    $cupon = GetCuponOferta($c_id_oferta,$c_cupon);
else 
    {
	$cupon = GetCuponOfertaHistorico($c_id_oferta,$c_cupon); 
    $oferta = GetOfertasHistorico($c_id_oferta); 
    $oferta = $oferta[0];
    $c_id_oferta = $oferta->idOferta;
    }
    
//die($c_email.' '.$c_id_oferta.' '.$c_cupon);
    
//var_dump($oferta);die;    
$cupon = $cupon[0];
//die($c_email.' '.$c_id_oferta.' '.$c_cupon);
envia_emails_cupon_admin($c_email,$c_id_oferta,$c_cupon);

function envia_emails_cupon_admin($email,$id_oferta,$ncupon)
  {
       
    include 'class.phpmailer.php';
    include 'textos_mensajes.php';

    //$aux=explode('@',request('id_alta'));
    
    $mail = new PHPMailer();

    $mail->Host = "localhost";
    

    $mail->From = EMAIL_EMP;
    $mail->FromName = NOMBRE_EMP;
    $mail->Subject = NOMBRE_EMP;

    $mail->AddAddress($email);
    $body='';
    $body = 'Prueba confirmaci&oacute;n desde Prestashop. No. oferta: '.$id_oferta.' cup&oacute;n: '.$ncupon;
   
    $mail->Body = $body;

    $mail->IsHTML(true);

    $mail->Send();
echo 'OK';

  }  

?>