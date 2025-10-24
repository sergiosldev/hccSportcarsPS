<?php
include('config_events.php');
include_once 'functions.php';

if(!isset($_REQUEST['ciudad']))$_REQUEST['ciudad']='';
//$_REQUEST['ciudad']='';

//print_r($_REQUEST);
if(isset($_REQUEST['id_alta']) && trim($_REQUEST['edicio'])=='false')
{
	//if(!es_pot_donar_alta()){ die('error'); }

	
	/*
if($_aux_=valida()){
		die('<div style="border:1px solid #f00;margin:3px;padding:3px;color:#f00;font-weight:bold;font-size:12px">'.$_aux_.'</div>'); 
	}

*/
	if(!porsche())die('Error de programa no se pueden introducir los datos');
	
	if($_REQUEST['tipus']=='porsche996'){
		 $sql='SELECT i.* FROM `events'.$_REQUEST['ciudad'].'` as i WHERE ( i.id_event="'.$_REQUEST['id_alta'].'") AND 
	 (i.tipus_event="porsche996" ) ';
	 $result=mysql_query($sql);
	 if(mysql_num_rows($result))$_REQUEST['tipus']='porsche997';
	}
	
	
	
	if(trim($_REQUEST['origen']=='OTROS'))$_REQUEST['origen']=$_REQUEST['otros'];
		
	$sql='INSERT INTO `events'.$_REQUEST['ciudad'].'` (
	id_event ,email ,telefon ,pilot,dia,tipus_event,persona_regala,email_persona_regala,mobil_persona_regala,coches,codi_localtzador,codi_consum,Observaciones,origen,plazas,email_confirm)
	VALUES ("'.request('id_alta').'", "'.request('email').'", "'.request('telefon').'", 
	"'.request('pilot').'","'.$aux[0].'","'.request('tipus').'"
	,"'.request('persona_regala').'","'.request('email_regala').'","'.request('telefon_regala').'","'.request('coches').'"
	,"'.request('codigo_localizador').'","'.request('codigo_consumo').'","'.request('Observaciones').'","'.request('origen').'","'.plazas($_REQUEST['tipus']).'"
	,"'.request('email1').'");';

	$result=mysql_query($sql,$link)  or die('error');
    echo 'OK';

}


if(isset($_REQUEST['imagen_news']))
{
    global $link;   
    include 'class.phpmailer.php';
    include '_newsletter_.php';
	die('');
}

if(isset($_REQUEST['ocupa']))
{
	
	// 1 sol cotxe
	$cad_plaza[0]='';
	$cad_plaza[1]='';
	
	if($_REQUEST['tipus']=='porsche996'){
		 $sql='SELECT i.* FROM `events'.$_REQUEST['ciudad'].'` as i WHERE ( i.id_event="'.$_REQUEST['ocupa'].'") AND 
	 (i.tipus_event="porsche996" ) ';
	 $result=mysql_query($sql);
	 if(mysql_num_rows($result))$_REQUEST['tipus']='porsche997';
	}
	// 1 sol cotxe
	if($_REQUEST['tipus']=='_porsche_' || $_REQUEST['tipus']=='_lotus_'){
		$cad_plaza[0]=',plazas';
	    $cad_plaza[1]=',"1"';
	}
	$sql='INSERT INTO `events'.$_REQUEST['ciudad'].'` (id_event,ocupa,pilot,tipus_event'.$cad_plaza[0].') VALUES("'.$_REQUEST['ocupa'].'","555","no disponible","'.$_REQUEST['tipus'].'"'.$cad_plaza[1].')';
	$result=mysql_query($sql,$link)  or die('error');
    echo 'OK'; 
}

if(isset($_REQUEST['ocupat']))
{
	
	// 1 sol cotxe
	
    $cad_plaza[0]='';
	$cad_plaza[1]='';
	
	$hores=explode('#',trim(file_get_contents('tarda.js')));
	
	if($_REQUEST['tipus']=='porsche996')$_REQUEST['tipus']='porsche997_porsche996';
	foreach($hores as $v){
		if(!$v)continue;
		
    /*
    if($_REQUEST['tipus']=='porsche996'){
		
	 $sql='SELECT i.* FROM `events` as i WHERE ( i.id_event="'.$v.'") AND 
		 (i.tipus_event="porsche996" ) ';
		 $result=mysql_query($sql);
		 if(mysql_num_rows($result))$_REQUEST['tipus']='porsche997';
        }
		
*/
       $aux=explode('@',$v);
       $perms=permisos($_REQUEST['tipus'],$aux[0],$aux[1]);
	   
		// 1 sol cotxe
		if($_REQUEST['tipus']=='_porsche_' || $_REQUEST['tipus']=='_lotus_' ){
			$cad_plaza[0]=',plazas';
		    $cad_plaza[1]=',"1"';
		}
		
		$sql='INSERT INTO `events'.$_REQUEST['ciudad'].'` (id_event,ocupa,pilot,tipus_event'.$cad_plaza[0].') VALUES("'.$v.'","555","no disponible","'.$_REQUEST['tipus'].'"'.$cad_plaza[1].')';
		if($perms)$result=mysql_query($sql,$link); // or die('error');


	}
    die('OK'); 
}


if(isset($_REQUEST['id_alta']) && trim($_REQUEST['edicio'])=='true')
{
	
	if(!porsche())die('Error de programa no se pueden introducir los datos');
	
/*
if($_aux_=valida()){
		die('<div style="border:1px solid #f00;margin:3px;padding:3px;color:#f00;font-weight:bold;font-size:12px">'.$_aux_.'</div>'); 
	}
*/

	//$aux=explode('@',request('id_alta'));
	
	$sql='UPDATE `events'.$_REQUEST['ciudad'].'` SET  email="'.request('email').'",
	telefon="'.request('telefon').'",pilot="'.request('pilot').'",
	dia="'.$aux[0].'",persona_regala="'.request('persona_regala').'",
	email_persona_regala="'.request('email_regala').'",mobil_persona_regala="'.request('telefon_regala').'",
	coches="'.request('coches').'",coches="'.request('coches').'"
	,codi_localtzador ="'.request('coches').'",codi_localtzador ="'.request('codigo_localizador').'"
	,codi_consum ="'.request('codigo_consumo').'",Observaciones ="'.request('Observaciones').'"
	,origen ="'.request('origen').'"
	,email_confirm ="'.request('email1').'"
	 Where id="'.request('id_inscrit').'"';
	 //echo $sql;
	$result=mysql_query($sql,$link)  or die('error'.mysql_error());
	echo 'OK';
	
}
else if(isset($_REQUEST['esborra_dia']))
  {
  	$sql='DELETE FROM `disponibles'.$_REQUEST['ciudad'].'` where data="'.request('esborra_dia').'" AND evento="'.request('tipus').'"  ';
    $result=mysql_query($sql,$link) or die('error');
  die('ok');
  }
else if(isset($_REQUEST['marca_dia']))
  {
  $sql='SELECT * FROM `disponibles'.$_REQUEST['ciudad'].'` where data="'.request('marca_dia').'" AND evento="'.request('tipus').'"  ';
  $result=mysql_query($sql,$link) or die('error');
  if(!mysql_num_rows($result))
   {
   $sql='INSERT INTO `disponibles'.$_REQUEST['ciudad'].'` (data,evento,color) values("'.request('marca_dia').'","'.request('tipus').'"
   ,"'.request('color').'" )  ';
   $result=mysql_query($sql,$link) or die('error');
   }
  else {// existeix s'ha de modificar color
  	$sql='UPDATE `disponibles'.$_REQUEST['ciudad'].'` SET color="'.request('color').'"  where data="'.request('marca_dia').'" AND evento="'.request('tipus').'" ';
   $result=mysql_query($sql,$link) or die('error');
  }
  die('ok'); 
  }

else if(isset($_REQUEST['esborra']))
  {
  	$sql='DELETE FROM `events'.$_REQUEST['ciudad'].'` where id="'.request('esborra').'"  ';
    $result=mysql_query($sql,$link) or die('error');
	
	echo 'OK';
  }
else if(isset($_GET['id_edita']))
{
	$cad_eval='';
    // mirem si ja existeix
	$sql='SELECT * FROM `events'.$_REQUEST['ciudad'].'` WHERE id="'.request('id_edita').'"';
    $result=mysql_query($sql,$link);
    $r=mysql_fetch_assoc($result);
    $cad_eval.='id_(\'pilot\').value=\''. $r['pilot'].'\'; ';
    $cad_eval.='id_(\'email\').value=\''. $r['email'].'\'; ';
	$cad_eval.='id_(\'telefon\').value=\''.urlencode(x_chars_cor(elimina_caracters($r['telefon']))).'\'; ';
	$cad_eval.='id_(\'persona_regala\').value=\''. $r['persona_regala'].'\'; ';
    $cad_eval.='id_(\'email_regala\').value=\''. $r['email_persona_regala'].'\'; ';
	$cad_eval.='id_(\'telefon_regala\').value=\''. $r['mobil_persona_regala'].'\'; ';
	$cad_eval.='id_(\'id_inscrit\').value=\''. $r['id'].'\'; ';
	$cad_eval.='id_(\'codigo_localizador\').value=\''. $r['codi_localtzador'].'\'; ';
	$cad_eval.='id_(\'codigo_consumo\').value=\''. $r['codi_consum'].'\'; ';
	
	$cad_eval.='id_(\'origen\').value=\''. $r['origen'].'\'; ';
	$cad_eval.='id_(\'tipus\').value=\''. $r['tipus_event'].'\'; ';
	$cad_eval.='id_(\'email1\').value=\''. $r['email_confirm'].'\'; ';
	$cad_eval.='id_(\'tipus_field\').style.display=\'none\'; ';
	$cad_eval.='id_(\'Observaciones\').value=decodeURIComponent(\''.urlencode(x_chars_cor(elimina_caracters($r['Observaciones']))).'\').replace(/#/gi," "); 
	';
	echo $cad_eval; 
}
else if(isset($_GET['email_']))
{
	$cad_eval='';
    // mirem si ja existeix
	$sql='SELECT * FROM `events'.$_REQUEST['ciudad'].'` WHERE id="'.request('email_').'"';
    $result=mysql_query($sql,$link);
    $r=mysql_fetch_assoc($result);
    //print_r($r);
	_envia_mails($r);   

}
else if(isset($_GET['mails']))
{
	envia_mails2($_GET['mails'],$_GET['txt']);   

}


else if(isset($_GET['marca_event']))
{
	$cad_eval='';
    // mirem si ja existeix
	$sql='UPDATE `events'.$_REQUEST['ciudad'].'` SET marcat ="'.request('mark').'" WHERE id="'.request('marca_event').'"';
    //echo $sql;
	$result=mysql_query($sql,$link);
    if($result)echo 'OK';
    else echo 'ERROR';
}


function plazas($t)
   {
  switch ($t)
    {
    case 'ferrari_porsche901':
	case 'lamborghini_lotus':
	case 'porsche997_porsche996':
		return 2;		 
		}
	return 1;	
   }


function es_pot_donar_alta()
   {
   global $link;		
   	$sql='SELECT i.* FROM events'.$_REQUEST['ciudad'].' as i WHERE i.id_event="'.request('id_alta').'" AND i.tipus_event="'.request('tipus').'"';
    $result=mysql_query($sql,$link);
	return (mysql_num_rows($result)<1);
   }

function valida()
   {
   	$cad='';
	
 if(trim($_REQUEST['email'])==''){$cad.='El email del piloto es obligatorio<br>'; }  
 else if (!filter_var($_REQUEST['email'], FILTER_VALIDATE_EMAIL)) {
   $cad.='El email del piloto es no tiene un formato valido<br>';
      }	
 if(trim($_REQUEST['email_regala'])==''){$cad.='El email de la persona que regala es obligatorio<br>'; }  
 else if (!filter_var($_REQUEST['email_regala'], FILTER_VALIDATE_EMAIL)) {
   $cad.='El email de la persona que regala  no tiene un formato valido<br>';
      }		    	
 if(trim($_REQUEST['telefon']=='')){$cad.='El teléfono del piloto es obligatorio<br>'; } 
 if(trim($_REQUEST['pilot']=='')){$cad.='El nombre del piloto es obligatorio<br>'; }
 
 if(trim($_REQUEST['persona_regala']=='')){$cad.='El nombre de la persona que regala  es obligatorio<br>'; } 
 if(trim($_REQUEST['telefon_regala']=='')){$cad.='El teléfono de la persona que regala es obligatorio<br>'; } 
 
 if(trim($_REQUEST['origen']=='')){$cad.='Deve escoger una opcion para el origen<br>'; } 
 if(trim($_REQUEST['origen']!='C.C')){
   if(trim($_REQUEST['codigo_localizador']=='')){$cad.='El codigo localizador obligatorio<br>';  }
   if(trim($_REQUEST['codigo_consumo']=='')){$cad.='El codigo consumo es obligatorio<br>';  }
 }
 if(trim($_REQUEST['origen']=='OTROS')){
   if(trim($_REQUEST['otros']=='')){$cad.='Deve indicar otro origen<br>';  
   }
 }
 $r='';
 return ''.$cad.'';
   }


  
function request($c)
   {return mysql_real_escape_string(strip_tags($_REQUEST[$c]));}
   
   function porsche()
     {
    /*
 if($_REQUEST['tipus']=='porsche997' || $_REQUEST['tipus']=='porsche996'){	
     $sql='SELECT i.* FROM `events` as i WHERE i.id_event="'.$_REQUEST['id_alta'].'" AND tipus_event="'.$_REQUEST['tipus'].'"';
     $result=mysql_query($sql);
	 if(mysql_num_rows($result))return false;
	 }
*/
	 if($_REQUEST['tipus']=='porsche997_porsche996'){	
     $sql='SELECT i.* FROM `events'.$_REQUEST['ciudad'].'` as i WHERE i.id_event="'.$_REQUEST['id_alta'].'" AND (tipus_event="porsche996" OR tipus_event="porsche997") ';
     $result=mysql_query($sql);
	 if(mysql_num_rows($result))return false;
	 }
	 return true;
     }
   

    function _envia_mails($r)
  {
  	   
include 'class.phpmailer.php';
include 'textos_mensajes.php';

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

    $mail->From = "info@motorclubexperience.com";

    $mail->FromName = "Motorclubexperience reenvio";

    $mail->Subject = 'Motorclubexperience reenvio';
	

    //$mail->AddAddress("motorclubexperience@hotmail.com");
   
    
	if($r['email_confirm']=='')$mail->AddAddress($r['email_persona_regala']);
	else $mail->AddAddress($r['email_confirm']);
	
	$mail->AddBCC("motorclubexperience@hotmail.com","oculto");

    $body= texto_reserva();
    
    /*
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
*/
	
	$body.= "<strong>Su reserva ha sido realizada con los siguientes datos</strong><br><br>";
	$body.= "<strong>Piloto: </strong>".convert_caracters_hex($r['pilot']).'<br>';
	$body.= "<strong>Email piloto: </strong>".$r['email'].'<br>';
	$body.= "<strong>Tel&eacute;fono piloto: </strong>".$r['telefon'].'<br>';
	$body.= "<strong>Dia: </strong>".$aux[0].'<br>';
	$body.= "<strong>Hora: </strong>".$aux[1].'<br>';
    $body.= "<strong>Evento: </strong>".return_tipus_e($r['tipus_event']).'<br>';
	$body.= "<strong>Persona que regala: </strong>".convert_caracters_hex($r['persona_regala']).'<br>';
	$body.= "<strong>Email persona que regala: </strong>".$r['email_persona_regala'].'<br>';
	$body.= "<strong>M&oacute;bil persona que regala: </strong>".$r['mobil_persona_regala'].'<br>';
	$body.= "<strong>C&oacute;digo localizador: </strong>".$r['codi_localtzador'].'<br>';
	$body.= "<strong>C&oacute;digo consumo: </strong>".$r['codi_consum'].'<br>';
	$body.= "<strong>Ciudad: </strong>".strtoupper(request('ciudad')).'<br>';
	$body.= "<strong>Observaciones: </strong>".convert_caracters_hex($r['Observaciones']).'<br>';
	
    $mail->Body = $body;
    //echo $body;
    $mail->IsHTML(true);
	$mail->Send();
    echo 'Mensaje enviado con exito';

  }
  
  
/*
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
         return 'Lamborghini 20 Km';
   break;		
   case 'lamborghini_lotus':
         return 'Lamborghini 20 Km  + Lotus Evora 20 Km ';
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
   case '_porsche_':
		return 'Porsche 20 Km ';		 
   break;	
   case '_lotus_':
		return 'Lotus 16 Km ';		 
   break;			
  }	
  }  
*/

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
 function elimina_caracters($cad)
  {
 
  $cad=str_replace('ó', 'o', $cad);	
  $cad=str_replace('é', 'e', $cad);		
  $cad=str_replace('ñ', 'n', $cad);	
  $cad=str_replace('ú', 'u', $cad);	
  $cad=str_replace('á', 'a', $cad);		
  $cad=str_replace('í', 'i', $cad);
  $cad=str_replace('ç', 'c', $cad);
  $cad=str_replace('ò', 'o', $cad);	
  $cad=str_replace('è', 'e', $cad);		
  $cad=str_replace('ù', 'u', $cad);	
  $cad=str_replace('à', 'a', $cad);		
  $cad=str_replace('ì', 'i', $cad);
  $cad=str_replace('ñ', 'n', $cad);
  $cad=str_replace('
', '', $cad);
  return $cad;
  }
  
  function x_chars_cor($cad)
  {
  	$ab=array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','Ñ','Ç','O','P','Q','R','S','T','U','V','W','X','Y','Z'
	,'a','b','c','d','e','f','g','h','i','j','k','l','m','n','ñ','ç','o','p','q','r','s','t','u','v','w','x','y','z'
	,' ','-','+','\'',',','€',':','.','0','1','2','3','4','5','6','7','8','9','_'); 
	$aux='';
	$cad=trim($cad);
  	for($i=0;$i<strlen($cad);$i++)
	  {
	   if(in_array(substr($cad,$i,1),$ab))$aux.=substr($cad,$i,1);  		
	  }
  return str_replace(' ','#',$aux);	  
  }
  
  function f_remove_odd_characters($string){
     // these odd characters appears usually 
       // when someone copy&paste from MSword to an HTML form
       $string = str_replace("\n","[NEWLINE]",$string);
       $string=htmlentities($string);
       $string=preg_replace('/[^(\x20-\x7F)]*/','',$string);
       $string=html_entity_decode($string);     
       $string = str_replace("[NEWLINE]","\n",$string);
       return $string;
  }
       

 function envia_mails2($ids,$msg)
  {
  	global $link;   
    include 'class.phpmailer.php';
	
	$mail = new PHPMailer();

    $mail->Host = "localhost";

    $mail->From = "info@motorclubexperience.com";

    $mail->FromName = "Motorclubexperience mensaje";

    $mail->Subject = 'Motorclubexperience mensaje';
	
	$cad_mail='';
	$ids=explode(',',$ids);
	foreach($ids as $id)
	  {
	  	if(trim($id)!='')
		 {
		 $sql='SELECT * FROM `events'.$_REQUEST['ciudad'].'` WHERE id="'.$id.'"';
         $result=mysql_query($sql,$link);
		 $r=mysql_fetch_assoc($result);
		 
		//$cad_mail.=$r['email_persona_regala'];
		// $cad_mail.=$r['email_confirm'];	
		
		if(trim($r['email_confirm'])==''){
		 //$mail->AddAddress($r['email_persona_regala']);
		 $mail->AddBCC($r['email_persona_regala'],"oculto");
		 }
		else {
		 // $mail->AddAddress($r['email_confirm']);  
		 $mail->AddBCC($r['email_confirm'],"oculto");
		}
		
	    }
	  }
   
	//$mail->AddAddress($r['email_persona_regala']);
	$mail->AddBCC("info@motorclubexperience.com","oculto");

    $body = "<strong>Mensaje</strong><br>";

    $body.= "<i>Enviado por Motorclubexperience </i><br><br>".convert_caracters_hex($msg);
	
    $mail->Body = $body;
    //echo $body;
    $mail->IsHTML(true);
	$mail->Send();
    echo 'Mensaje enviado con exito';

  }
  


?>