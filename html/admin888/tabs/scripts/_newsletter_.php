<?php

	$mail = new PHPMailer();
    $mail->Host = "localhost";
    $mail->From = "info@motorclubexperience.com";
    $mail->FromName = "Motorclubexperience mensaje";
    $mail->Subject = 'Motorclubexperience mensaje';

	
  $sql='SELECT id_event,email_persona_regala,email,email_confirm   from events ';
  $result=mysql_query($sql);
  
  while($r=mysql_fetch_object($result))
	 {
	 if(filter_var($r->email_persona_regala, FILTER_VALIDATE_EMAIL) && !isset($mails[trim($r->email_persona_regala)]))$mails[trim($r->email_persona_regala)]=$r->id_event;	
	 if(filter_var($r->email, FILTER_VALIDATE_EMAIL) && !isset($mails[trim($r->email)]))$mails[trim($r->email)]=$r->id_event;	
	 if(filter_var($r->email_confirm, FILTER_VALIDATE_EMAIL) && !isset($mails[trim($r->email_confirm)]))$mails[trim($r->email_confirm)]=$r->id_event;	
	 }
 
 /*
 foreach($mails as $k=>$v)
     $mail->AddBCC($k,"oculto");
*/
 //$mail->AddBCC('ivanmaciagalan@hotmail.com',"oculto");
 $mail->AddBCC('info@motorclubexperience.com',"oculto");
 $mail->AddBCC('motorclubexperience@hotmail.com',"oculto");	 
 $mail->AddBCC('mardetalls@hotmail.com',"oculto");

    $body = '
<!DOCTYPE HTML PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><head>
<title>MOTORCLUBEXPERIENCE</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"><style type="text/css">
</style>
</head><body bgcolor="#ffffff">
  <table align="center" border="0" cellpadding="0" cellspacing="0" width="900px">
	  <tbody>
	     <tr>
	      <td  style="color:#000;background-color:#fff; font-size:11px" align="center" colspan="3">Si no ves correctamente este mensaje <a style="color:#aaa;"  href="https://www.motorclubexperience.com/">Haz click aqu&iacute;</a></td>
	
	    </tr>
	    <tr>
	      <td   style="color:#000;background-color:#fff; font-size:11px" align="center" colspan="3">Para asegurar la correcta recepci&#243;n de nuentros emails a&#241;ade nuestra direcci&#243;n de correo a tu lista de emails<br></a></td>
	    </tr>
		 <tr>
	      <td   style="border:1px solid #000; padding:10px;color:#000;background-color:#fff; font-size:12px"  colspan="3">
		  '.$_REQUEST['newslettereditor'].'
		  </td>
	    </tr>
		 <tr>
	      <td   style="border:0px solid #000; padding:10px;color:#000;background-color:#fff; font-size:11px" align="center" colspan="3">
		  <br/>
		  <img style="border:none" width="900px" src="https://www.motorclubexperience.com/'.$_REQUEST['imagen_news'].'" alt="Haga click aqui con el boton derecho para descargar imagenes,Para ayudar a proteger la confidencialidad, Outlook evito la descarga automatica de esta imagen de Internet"  />
		  </td>
	    </tr>
	  </tbody>
	</table>
</body>
</html>	
	
	';

   
	
    $mail->Body = $body;
    $mail->IsHTML(true);
	$mail->Send();
    echo 'Mensaje enviado con exito ';

?>