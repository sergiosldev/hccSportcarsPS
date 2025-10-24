    function _envia_mails($r)
  {
  	   
include 'class.phpmailer.php';

    $aux=explode('@',request('id_event'));
		
	if($r['tipus_event']!='porsche997' && $r['tipus_event']!='porsche996')
	  {
	  $h=explode(':',$aux[1]);
	  if($h[1]=='00' || $h[1]=='15'){
		$aux[1]=$h[0].':00:00';
	  }
	  else if($h[1]=='30' || $h[1]=='45'){
	    $aux[1]=$h[0].':30:00';
	  }

	}
	
	
	$mail = new PHPMailer();

    $mail->Host = "localhost";

    $mail->From = "Motorclub@motor.com";

    $mail->FromName = "Motorclubexperience";

    $mail->Subject = 'Motorclubexperience';
	

    //$mail->AddAddress("motorclubexperience@hotmail.com");
   
    $mail->AddAddress("ivanmaciagalan@hotmail.com");
	// $mail->AddAddress($r['email_persona_regala']);
	//$mail->AddBCC("ijkfjkdjd@hotmail.com","oculto");

    $body = "<strong>Mensaje</strong><br>";

    $body.= "<i>Enviado por Motorclubexperience </i><br><br>";
	

	 $body.= "
	 <strong>Su reserva ha sido realizada con exito</strong><br><br>
	 <strong>Recuerde que la hora que le asignamos es aproximada,<br>
	 pero deve presentarse 30 minutos antes de la hora solicitada <br>
	 es muy importante presentar esta confirmaci&oacute;n junto con el ticket bono, fotocopia del <br>
	 DNI y fotocopia del carnet de conducir.</strong><br><br>";
	 $body.= "<strong>Si desea cancelar o modificar esta reserva, debe hacerlo con <br>
	 una antelaci&oacute;n m&iacute;nima de 7 d&iacute;as
	 , llamando al 93 126 32 81 (de 10 a 13h por la ma&ntilde;ana<br> 
	 y de 16 a 19h por la tarde)</strong><br><br>";
	
	$body.= "<strong>Su reserva ha sido realizada con los siguientes datos</strong><br><br>";
	$body.= "<strong>Piloto: </strong>".convert_caracters_hex($r['pilot']).'<br>';
	$body.= "<strong>Email piloto: </strong>".$r['email').'<br>';
	$body.= "<strong>Tel&eacute;fono piloto: </strong>".$r['telefon'].'<br>';
	$body.= "<strong>Dia: </strong>".$aux[0].'<br>';
	$body.= "<strong>Hora: </strong>".$aux[1].'<br>';
    $body.= "<strong>Evento: </strong>".return_tipus_e($r['tipus_event']).'<br>';
	$body.= "<strong>Persona que regala: </strong>".convert_caracters_hex($r['persona_regala']).'<br>';
	$body.= "<strong>Email persona que regala: </strong>".$r['email_persona_regala'].'<br>';
	$body.= "<strong>M&oacute;bil persona que regala: </strong>".$r['mobil_persona_regala'].'<br>';
	$body.= "<strong>C&oacute;digo localizador: </strong>".$r['codi_localtzador'].'<br>';
	$body.= "<strong>C&oacute;digo consumo: </strong>".$r['codi_consum'].'<br>';
	$body.= "<strong>Observaciones: </strong>".convert_caracters_hex($r['Observaciones']).'<br>';
	
    $mail->Body = $body;

    $mail->IsHTML(true);

    $mail->Send();
    echo 'Mensaje enviado con exito';

  }
  
  
  function return_tipus_e($t)
  {
  switch($t)
  {
   case 'ferrari':
   	    return 'Ferrari 360 20 Km   ';
   break;		
   case 'ferrari_porsche901':
   	    return 'Ferrari  20 Km  + Porsche  20 Km   ';
   break;	
   case 'lamborghini':
         return 'Lamborghini 16 Km';
   break;		
   case 'lamborghini_lotus':
         return 'Lamborghini 16 Km  + Lotus Evora 16 Km ';
   break;		
   case 'porsche997_porsche996':
		return 'Porsche Turbo 20 Km +  Porsche Carrera S 20 Km ';		 
   break;	
   case 'porsche996':
		return 'Porsche 20 Km ';		 
   break;
   case 'porsche997':
		return 'Porsche 20 Km ';		 
   break;
   case '_lotus_':
		return 'Lotus Evora 16 Km ';		 
   break;			
  }	
  }  

function convert_caracters_hex($cad)
  {
 
  $cad=str_replace('ó', '&#243;', $cad);	
  $cad=str_replace('é', '&#233;', $cad);		
  $cad=str_replace('ñ', '&#241;', $cad);	
  $cad=str_replace('ú', '&#250;', $cad);	
  $cad=str_replace('á', '&#225;', $cad);		
  $cad=str_replace('í', '&#237;', $cad);
  $cad=str_replace('ç', '&#231;', $cad);
  $cad=str_replace('ò', '&#242;', $cad);	
  $cad=str_replace('è', '&#232;', $cad);		
  $cad=str_replace('ù', '&#249;', $cad);	
  $cad=str_replace('à', '&#224;', $cad);		
  $cad=str_replace('ì', '&#236;', $cad);
  $cad=str_replace('ñ', '&#241;', $cad);
  return $cad;
  }  
