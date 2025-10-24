<?php
//mts 12062012. Fichero Ajax para enviar la confirmación a un establecimiento desde el listado de cupones.
include_once(dirname(__FILE__).'/../../../config/defines.inc.php');
include dirname(__FILE__).'/funciones_cupon.php'; 
$c_id_establecimiento=$_GET['id_establecimiento'];
$c_numero_talonario=$_GET['numero_talonario'];
$c_numero_cupon=$_GET['numero_cupon'];
$c_email=$_GET['email'];

    
$cupon = GetCupon($c_id_establecimiento,$c_numero_talonario,$c_numero_cupon);
$cupon = $cupon[0];
envia_emails_cupon_admin($c_email,$c_numero_talonario,$c_numero_cupon);

function envia_emails_cupon_admin($email,$ntalonario,$ncupon)
  {
       
    include 'class.phpmailer.php';
    include 'textos_mensajes.php';

    //$aux=explode('@',request('id_alta'));
    
    $mail = new PHPMailer();

    $mail->Host = "localhost";
    

    $mail->From = EMAIL_EMP;
    $mail->FromName = _NOMBRE_EMP_;
    $mail->Subject = _NOMBRE_EMP_;

    $mail->AddAddress($email);
    $body='';
    $body = 'Prueba confirmaci&oacute;n desde Prestashop. Talonario: '.$ntalonario.' cup&oacute;n: '.$ncupon;
   
    $mail->Body = $body;

    $mail->IsHTML(true);

    $mail->Send();
echo 'OK';

  }  

?>