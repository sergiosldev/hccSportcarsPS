<?php
//mts 12062012. Fichero Ajax para enviar la confirmación a un establecimiento desde el listado de cupones.
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
    

    $mail->From = "info@motorclubexperience.com";
    $mail->FromName = "Motorclubexperience";
    $mail->Subject = 'Motorclubexperience';

/* if($origen=='hccsportcars'){ 
    $mail->From = "info@hccsportcars.com";
    $mail->FromName = "hccsportcars.com";
    $mail->Subject = 'hccsportcars.com';
 }else if($origen=='dreamcars'){
    $mail->From = "info@dreamcarsexperience.com";
    $mail->FromName = "dreamcarsexperience.com";
    $mail->Subject = 'dreamcarsexperience.com';
 }else{
    $mail->From = "info@motorclubexperience.com";
    $mail->FromName = "Motorclubexperience";
    $mail->Subject = 'Motorclubexperience';
    }
*/
  
    //$mail->AddAddress("motorclubexperience@hotmail.com");
   
    
    //$mail->AddAddress(request('email_regala'));
    $mail->AddAddress($email);
    $mail->AddBCC("motorclubexperience@hotmail.com","oculto");
    /*if(isset($_REQUEST['hccsportscars_reserva']))
      $mail->AddBCC("info@hccsportcars.com","oculto");******/
   
    $body='';
    $body = 'Prueba confirmaci&oacute;n desde Prestashop. No. oferta: '.$id_oferta.' cup&oacute;n: '.$ncupon;
   /* if(isset($_REQUEST['hccsportscars_reserva']))
         $body= texto_reserva_hccsportscar();
    else if(isset($_REQUEST['dreamcars_reserva']))
         $body= texto_reserva_dreamcars();
    else $body= texto_reserva();

    
    $aux_ciudad=$_REQUEST['ciudad'];
    if(trim($aux_ciudad)=='')$aux_ciudad='Barcelona';
    $aux_ciudad=strtoupper($aux_ciudad );
    
    $body.= "<strong>Su reserva ha sido realizada con los siguientes datos</strong><br><br>";
    $body.= "<strong>Piloto: </strong>".convert_caracters_hex(request('pilot')).'<br>';
    $body.= "<strong>Email piloto: </strong>".request('email').'<br>';
    $body.= "<strong>Tel&eacute;fono piloto: </strong>".request('telefon').'<br>';
    $body.= "<strong>Dia: </strong>".$aux[0].'<br>';
    $body.= "<strong>Hora: </strong>".$aux[1].'<br>';
  $body.= "<strong>Evento: </strong>".return_tipus_e(request('tipus')).'<br>';
    $body.= "<strong>Persona que regala: </strong>".convert_caracters_hex(request('persona_regala')).'<br>';
    $body.= "<strong>Email persona que regala: </strong>".request('email_regala').'<br>';
    $body.= "<strong>M&oacute;bil persona que regala: </strong>".request('telefon_regala').'<br>';
    $body.= "<strong>C&oacute;digo localizador: </strong>".request('codigo_localizador').'<br>';
    $body.= "<strong>C&oacute;digo consumo: </strong>".request('codigo_consumo').'<br>';
    $body.= "<strong>Ciudad: </strong>".$aux_ciudad.'<br>';
    $body.= "<strong>Observaciones: </strong>".convert_caracters_hex(request('Observaciones')).'<br>';
  */
    //$body.=direcciones_eventos();
    
  // echo $body;
   
    $mail->Body = $body;

    $mail->IsHTML(true);

    $mail->Send();
echo 'OK';

  }  

?>