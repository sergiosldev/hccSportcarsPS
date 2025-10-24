<?php
include_once('config_events.php');
include_once 'functions.php';
include_once('../../../classes/OfertaHistorico.php');
require_once ( '../../../html2pdf/html2pdf.class.php');
include_once('../../../scripts/funciones_codigos.php');

 
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
    "'.utf8_decode(request('pilot')).'","'.$aux[0].'","'.request('tipus').'"
    ,"'.request('persona_regala').'","'.request('email_regala').'","'.utf8_decode(request('telefon_regala')).'","'.request('coches').'"
    ,"'.request('codigo_localizador').'","'.request('codigo_consumo').'","'.request('Observaciones').'","'.request('origen').'","'.plazas($_REQUEST['tipus']).'"
    ,"'.request('email1').'");';

    $result=mysql_query($sql,$link)  or die('error');
    echo 'OK';

}


if(isset($_REQUEST['imagen_news']))
{
    global $link;   
    include_once 'class.phpmailer.php';
    include_once '_newsletter_.php';
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
    if($_REQUEST['tipus']=='_porsche_' || $_REQUEST['tipus']=='_lotus_'
       || $_REQUEST['tipus']=='_bferrari_' || $_REQUEST['tipus']=='_blamborghini_'){
        $cad_plaza[0]=',plazas';
        $cad_plaza[1]=',"0"';
    }
    $sql='INSERT INTO `events'.$_REQUEST['ciudad'].'` (id_event,ocupa,pilot,tipus_event'.$cad_plaza[0].') VALUES("'.$_REQUEST['ocupa'].'","555","no disponible","'.$_REQUEST['tipus'].'"'.$cad_plaza[1].')';
    $result=mysql_query($sql,$link)  or die('error');
    echo 'OK'; 
}

if(isset($_REQUEST['ocupat']))
{
    
    
    //Marcamos ocupados mañana.
    // 1 sol cotxe
    
    if (in_array($_REQUEST['periodo'],array('m','mt')))
    {
		// 1 sol cotxe
		
		$cad_plaza[0]='';
		$cad_plaza[1]='';
		
		$hores=explode('#',trim(file_get_contents('mati.js')));
		
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
			if($_REQUEST['tipus']=='_porsche_' || $_REQUEST['tipus']=='_lotus_' 
		  || $_REQUEST['tipus']=='_bferrari_' || $_REQUEST['tipus']=='_blamborghini_'){
				$cad_plaza[0]=',plazas';
				$cad_plaza[1]=',"0"';
			}
			
			$sql='INSERT INTO `events'.$_REQUEST['ciudad'].'` (id_event,ocupa,pilot,tipus_event'.$cad_plaza[0].') VALUES("'.$v.'","555","no disponible","'.$_REQUEST['tipus'].'"'.$cad_plaza[1].')';
			if($perms)$result=mysql_query($sql,$link); // or die('error');


		 }
	}
	

    //Marcamos ocupados tarde.
    // 1 sol cotxe
    
    if (in_array($_REQUEST['periodo'],array('t','mt')))
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
			if($_REQUEST['tipus']=='_porsche_' || $_REQUEST['tipus']=='_lotus_' 
		  || $_REQUEST['tipus']=='_bferrari_' || $_REQUEST['tipus']=='_blamborghini_'){
				$cad_plaza[0]=',plazas';
				$cad_plaza[1]=',"0"';
			}
			
			$sql='INSERT INTO `events'.$_REQUEST['ciudad'].'` (id_event,ocupa,pilot,tipus_event'.$cad_plaza[0].') VALUES("'.$v.'","555","no disponible","'.$_REQUEST['tipus'].'"'.$cad_plaza[1].')';
			if($perms)$result=mysql_query($sql,$link); // or die('error');


		 }
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
    
    $sql='UPDATE `events'.$_REQUEST['ciudad'].
	'` SET  email="'.request('email').'",
			telefon="'.request('telefon').'",
			pilot="'.request('pilot').'",
			apellidos_piloto="'.request('apellidos_piloto').'",
			dia="'.$aux[0].'",
			persona_regala="'.request('persona_regala').'",
			apellidos_persona_regala="'.request('apellidos_persona_regala').'",
			email_persona_regala="'.request('email_regala').'",
			mobil_persona_regala="'.request('telefon_regala').'",
			coches="'.request('coches').'",coches="'.request('coches').'",
			codi_localtzador ="'.request('coches').'",
			codi_localtzador ="'.request('codigo_localizador').'",
			codi_consum ="'.request('codigo_consumo').'",
			Observaciones ="'.request('Observaciones').'",
			origen ="'.request('origen').'",
			email_confirm ="'.request('email1').'",
			plazas ="'.plazas($_REQUEST['tipus']).'"	
     Where id="'.request('id_inscrit').'"';

	 $result=mysql_query($sql,$link)  or die('error'.mysql_error());
    echo 'OK';
    
}

else if (isset($_REQUEST['edicio_estab']))    
{
    if(trim($_REQUEST['edicio_estab'])=='edicio')
    {
    $sql='UPDATE `ps_establecimientos` SET  nombre="'.request('nombre').'",
    direccion="'.request('direccion').'",email="'.request('email').'",
    telefono="'.request('telefono').'",nif="'.request('nif').'",
    usuario="'.request('usuario').'",password="'.request('password').'"
    ,cpostal ="'.request('cpostal').'",poblacion ="'.request('poblacion').'"
    ,id_provincia ="'.request('provincia').'",nombre_contacto ="'.request('nombre_contacto').'"
    ,apellidos_contacto ="'.request('apellidos_contacto').'" 
     Where id_establecimiento="'.request('id_establecimiento').'"';
    
     
    $result=mysql_query($sql,$link)  or die('error'.mysql_error());
    echo 'OK';
   
  }
if(trim($_REQUEST['edicio_estab'])=='alta')   
 {
            
    $sql='SELECT max(id_establecimiento)+1  id_estab FROM `ps_establecimientos`';
    $result=mysql_query($sql,$link);
    $r=mysql_fetch_assoc($result);
    $newId = $r['id_estab']; 
    if ($newId=="") $newId = '99';
	$fecha_alta=date('Y-m-d H:i:s');

              
    $sql='INSERT INTO `ps_establecimientos` (
    id_establecimiento ,nombre,direccion ,email,telefono,nif,usuario,password,cpostal,poblacion,id_provincia,fecha_alta,nombre_contacto,apellidos_contacto)
    VALUES ("'.$newId.'", "'.request('nombre').'", "'.request('direccion').'", 
    "'.request('email').'","'.request('telefono').'"
    ,"'.request('nif').'","'.request('usuario').'","'.request('password').'","'.request('cpostal').'"
    ,"'.request('poblacion').'","'.request('provincia').'","'.$fecha_alta.'","'.request('nombre_contacto').'","'.request('apellidos_contacto').'");';

   
    $result=mysql_query($sql,$link)  or die('error');
    echo 'OK'; }
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
/* mts 03052012 */ 
  else if(isset($_REQUEST['esborra_est']))
  {
              
    $sql='DELETE FROM `ps_cupones` where id_establecimiento="'.request('esborra_est').'"  ';
    $result=mysql_query($sql,$link) or die('error');
              
    $sql='DELETE FROM `ps_talonarios` where id_establecimiento="'.request('esborra_est').'"  ';
    $result=mysql_query($sql,$link) or die('error');
          
      
    $sql='DELETE FROM `ps_establecimientos` where id_establecimiento="'.request('esborra_est').'"  ';
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
    $cad_eval.='id_(\'apellidos_piloto\').value=\''. $r['apellidos_piloto'].'\'; ';
    $cad_eval.='id_(\'email\').value=\''. $r['email'].'\'; ';
    $cad_eval.='id_(\'telefon\').value=\''.urlencode(x_chars_cor(elimina_caracters($r['telefon']))).'\'; ';
    $cad_eval.='id_(\'persona_regala\').value=\''. $r['persona_regala'].'\'; ';
    $cad_eval.='id_(\'apellidos_persona_regala\').value=\''. $r['apellidos_persona_regala'].'\'; ';
    $cad_eval.='id_(\'email_regala\').value=\''. $r['email_persona_regala'].'\'; ';
    $cad_eval.='id_(\'telefon_regala\').value=\''. $r['mobil_persona_regala'].'\'; ';
    $cad_eval.='id_(\'id_inscrit\').value=\''. $r['id'].'\'; ';
    $cad_eval.='id_(\'codigo_localizador\').value=\''. $r['codi_localtzador'].'\'; ';
    $cad_eval.='id_(\'codigo_consumo\').value=\''. $r['codi_consum'].'\'; ';
    
    $cad_eval.='id_(\'origen\').value=\''. $r['origen'].'\'; ';
    $cad_eval.='id_(\'tipus\').value=\''. $r['tipus_event'].'\'; ';
    $cad_eval.='id_(\'email1\').value=\''. $r['email_confirm'].'\'; ';
    $cad_eval.='id_(\'tipus_field\').style.display=\'none\'; ';
    //mts 30092012
    if ($r['data_reserva']!='')
    $cad_eval.='id_(\'fecha_reserva\').value=\''. substr($r['data_reserva'],8,2).'/'.substr($r['data_reserva'],5,2).'/'.substr($r['data_reserva'],0,4).' '.substr($r['data_reserva'],11,5).'\'; ';
    //fin modif. mts.
    $cad_eval.='id_(\'Observaciones\').value=decodeURIComponent(\''.urlencode(x_chars_cor(elimina_caracters($r['Observaciones']))).'\').replace(/#/gi," "); 
    ';
    echo $cad_eval; 
}
/*** mts 01052012 edita establecimiento ***/
else if(isset($_GET['id_edita_estab']))
{
    $cad_eval='';
    // mirem si ja existeix
    $sql='SELECT * FROM `ps_establecimientos` WHERE id_establecimiento="'.$_GET['id_edita_estab'].'"';

    $result=mysql_query($sql,$link);
    $r=mysql_fetch_assoc($result);
    $cad_eval.='id_(\'nombre\').value=\''. $r['nombre'].'\'; ';
    $cad_eval.='id_(\'direccion\').value=\''. $r['direccion'].'\'; ';
    $cad_eval.='id_(\'email\').value=\''. $r['email'].'\'; ';
    $cad_eval.='id_(\'telefono\').value=\''.urlencode(x_chars_cor(elimina_caracters($r['telefono']))).'\'; ';
    $cad_eval.='id_(\'nif\').value=\''. $r['nif'].'\'; ';
    $cad_eval.='id_(\'usuario\').value=\''. $r['usuario'].'\'; ';
    $cad_eval.='id_(\'password\').value=\''. $r['password'].'\'; ';
    $cad_eval.='id_(\'cpostal\').value=\''. $r['cpostal'].'\'; ';
    $cad_eval.='id_(\'poblacion\').value=\''. $r['poblacion'].'\'; ';
    $cad_eval.='id_(\'provincia\').value=\''. $r['id_provincia'].'\'; ';
    $cad_eval.='id_(\'nombre_contacto\').value=\''. $r['nombre_contacto'].'\'; ';
    $cad_eval.='id_(\'apellidos_contacto\').value=\''. $r['apellidos_contacto'].'\'; ';
    $cad_eval.='id_(\'id_establecimiento\').value=\''. $r['id_establecimiento'].'\'; ';

    echo $cad_eval; 
}

else if(isset($_GET['email_']))
{
    $cad_eval='';
    // mirem si ja existeix
    //$sql='SELECT * FROM `events'.$_REQUEST['ciudad'].'` WHERE id="'.request('email_').'"';
	$sql='SELECT * FROM `events'.$_REQUEST['ciudad'].'` WHERE id="'.request('email_').'"';
    $result=mysql_query($sql,$link);
    $r=mysql_fetch_assoc($result);
    //print_r($r);
    //_envia_mails($r);
	if (trim($r['email_confirm'])=='') 
		$destinatario = $r['email_persona_regala'];
	else 
		$destinatario = $r['email_confirm'];

	envia_mails_pdf_bd($_REQUEST['ciudad'],$r,$destinatario);	
	envia_mails_pdf_bd($_REQUEST['ciudad'],$r,'motorclub');	
}
else if(isset($_GET['mails']))
{
    envia_mails2($_GET['mails'],$_GET['txt']);   

}


else if(isset($_GET['marca_event']))
{
    $cad_eval='';
    
	if (request('mark')==3) //marcamos bautizo
    {
        // mirem si ja existeix
    
        $sql=' select id_event,marca from `bautizos'.$_REQUEST['ciudad'].'`  WHERE id_event="'.request('marca_event').'" and tipus_event="'.$_REQUEST['tipus'].'"';
        //die($sql);
		$result=mysql_query($sql,$link);
        $reg=mysql_fetch_assoc($result);
        
        if (mysql_num_rows($result)>0)
        {  
            if ($reg['marca']!='1') $mb='1'; else $mb='0';           
            //die($reg['marcat_bateig'].' - '.$mb);
            $sql='UPDATE `bautizos'.$_REQUEST['ciudad'].'` SET marca ="'.$mb.'" WHERE id_event="'.request('marca_event').'" and tipus_event="'.$_REQUEST['tipus'].'"';
			//die($sql);
		   $result2=mysql_query($sql,$link);
            if($result2)echo 'OK';
            else echo 'ERROR';
        }
        else    
        {
            $sql='INSERT INTO `bautizos'.$_REQUEST['ciudad'].'` (id_event,tipus_event,marca) VALUES("'.request('marca_event').'","'.$_REQUEST['tipus'].'",1)';
            //die($sql);
            $result2=mysql_query($sql,$link); // or die('error');
            if($result2)echo 'OK';
            else echo 'ERROR';
        }    
    }

	else
	{
 // mirem si ja existeix
    $sql='UPDATE `events'.$_REQUEST['ciudad'].'` SET marcat ="'.request('mark').'" WHERE id="'.request('marca_event').'"';
    //echo $sql;
    $result=mysql_query($sql,$link);
    if($result)echo 'OK';
    else echo 'ERROR';
	}
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
   if(trim($_REQUEST['codigo_consumo']=='')){$cad.='El codigo consumo es obligatorior<br>';  }
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
    include_once 'class.phpmailer.php';
    include_once 'textos_mensajes.php';

    $aux=explode('@',request('id_event'));

      $mail = new PHPMailer();

    $mail->Host = "localhost";

    $mail->From = "info@motorclubexperience.com";

    $mail->FromName = "Motorclubexperience reenvio";

    $mail->Subject = 'Motorclubexperience reenvio';

   //$mail->AddAddress("motorclubexperience@hotmail.com");

    if($r['email_confirm']=='')$mail->AddAddress($r['email_persona_regala']);
    else $mail->AddAddress($r['email_confirm']);	

	//$mail->AddAddress('gestion@hoteldongonzalo.com');	
	//$mail->AddAddress('info@saradeur.com');	

//	$mail->AddAddress('reservas@hotel-lacarreta.com');
    $mail->AddBCC("motorclubexperience@hotmail.com","oculto");

    $body= texto_reserva();
	$aux_ciudad=$_REQUEST['ciudad'];
	if(trim($aux_ciudad)=='')$aux_ciudad='Barcelona';
	$aux_ciudad=strtoupper($aux_ciudad );
    
    $body.= "<strong>Su reserva ha sido realizada con los siguientes datos</strong><br><br>";
    $body.= "<strong>Fecha Reserva: </strong>".$r['data_reserva'].'<br>';
    $body.= "<strong> Direcci&oacute;n IP: </strong>".$r['ip'].'<br>';		
    $body.= "<strong>Nombre piloto: </strong>".convert_caracters_hex($r['pilot']).'<br>';
    $body.= "<strong>Apellidos piloto: </strong>".convert_caracters_hex($r['apellidos_piloto']).'<br>';
    $body.= "<strong>Email piloto: </strong>".$r['email'].'<br>';
    $body.= "<strong>Tel&eacute;fono piloto: </strong>".$r['telefon'].'<br>';
	$body.= "<strong>Origen: </strong>".str_replace('_',' ',$r['origen']).'<br>';
	
	if(trim($r['fecha_entrada'])!='' and substr(trim($r['fecha_entrada']),0,10)!='0000-00-00') 
	{
	//$body.= "<strong>Hotel: </strong>".nombre_hotel($_REQUEST['id_hotel']).'<br>';
	
	if ($r['origen']=='1') $alojamiento = 'Alojamiento + Desayuno';
	else $alojamiento = 'Media Pensi&oacute;n';
	$body.= "<strong>Alojamiento: </strong>".$alojamiento.'<br>';

	if (trim($r['fecha_entrada'])!='') $body.= "<strong>Fecha de entrada: </strong>".implode('/',array_reverse(explode('-',substr($r['fecha_entrada'],0,10))))."<br>";
	if (trim($r['fecha_salida'])!='') $body.= "<strong>Fecha de salida: </strong>".implode('/',array_reverse(explode('-',substr($r['fecha_salida'],0,10))))."<br>";
	
	if ($r['spa']==='1') $body.= "<strong>Este vale dispone de SPA</strong><br>";
	if (trim($r['persona_hotel'])!='') $body.= "<strong>Personal del hotel que realiz&oacute; la reserva: </strong>".utf8_decode($r['persona_hotel'])."<br>";

	}
	
	
    $body.= "<strong>Dia: </strong>".$aux[0].'<br>';
    $body.= "<strong>Hora: </strong>".$aux[1].'<br>';
    $body.= "<strong>Evento: </strong>".return_tipus_e($r['tipus_event']).'<br>';
    $body.= "<strong>Nombre persona que regala: </strong>".convert_caracters_hex($r['persona_regala']).'<br>';
    $body.= "<strong>Apellidos persona que regala: </strong>".convert_caracters_hex($r['apellidos_persona_regala']).'<br>';
    $body.= "<strong>Email persona que regala: </strong>".$r['email_persona_regala'].'<br>';
    $body.= "<strong>M&oacute;bil persona que regala: </strong>".$r['mobil_persona_regala'].'<br>';
	$textos_codigos = canvia_textos_codigo($r['origen']);
	$body.= "<strong>".utf8_decode($textos_codigos[0]).": </strong>".$r['codi_localtzador'].'<br>';
	if (!in_array($r['origen'],array('CODIGO_ALFA','DOOPLAN','LA_TIENDA_MARCA'))) 
		$body.= "<strong>".utf8_decode($textos_codigos[1]).": </strong>".$r['codi_consum'].'<br>';

//    $body.= "<strong>C&oacute;digo localizador: </strong>".$r['codi_localtzador'].'<br>';
///    $body.= "<strong>C&oacute;digo consumo: </strong>".$r['codi_consum'].'<br>';
    //$body.= "<strong>Ciudad: </strong>".strtoupper(request('ciudad')).'<br>';
	$body.= "<strong>Ciudad: </strong>".$aux_ciudad.'<br>';
    $body.= "<strong>Observaciones: </strong>".convert_caracters_hex($r['Observaciones']).'<br>';
    
    $mail->Body = $body;
    //echo $body;
    $mail->IsHTML(true);
    $mail->Send();
    echo 'Mensaje enviado con exito';

  }
  
  
  
/** Noves confirmacions de reserva en format pdf **/

function generar_pdf_confirm_reserva(&$nombre_fichero,$empresa,$ciudad,$id_event,$r,$bd=false)
{    

	if(trim($ciudad)=='')$ciudad='Barcelona';
	$ciudad=strtoupper($ciudad );
	//echo('emp '.$empresa);
	switch($empresa)
	{
		case 'Hccsportcars':
			$url_base = 'http://www.hccsportcars.com';
			$imagen_fondo = 'fondo_confirmacion_hcc.png';
		break;
		case 'Dreamcarsexperience':
			$url_base = 'http://www.dreamcarsexperience.com';
			$imagen_fondo = 'fondo_confirmacion_dreamcars.png';		
		break;
		case 'Motorclubexperience':
			$url_base = 'http://www.motorclubexperience.com';
			$imagen_fondo = 'fondo_confirmacion.png';
		break;
	}
	
    $aux=explode('@',$id_event);
		
	if($tipus!='porsche997' && $tipus!='porsche996')
	 {
		  $h=explode(':',$aux[1]);
		  if($h[1]=='00' || $h[1]=='15'){
			$aux[1]=$h[0].':00:00';
		  }
		  else if($h[1]=='30' || $h[1]=='45'){
			$aux[1]=$h[0].':30:00';
		  }
	}
	

    if ($bd)
	{
		$fecha_reserva=$r['data_reserva'];
		$ip=$r['ip'];
		$origen=$r['origen'];
		
		$piloto=convert_caracters_hex($r['pilot']);
		$apellidos_piloto=convert_caracters_hex($r['apellidos_piloto']);
		$email=$r['email'];
		$telefono=$r['telefon'];
		$dia=$aux[0];
		$hora=$aux[1];
		$tipo=return_tipus_e($r['tipus_event']);
		$persona_regala=convert_caracters_hex($r['persona_regala']);
		$apellidos_persona_regala=convert_caracters_hex($r['apellidos_persona_regala']);
		$nif_regala = convert_caracters_hex($r['nif']);  
		$email_regala= $r['email_persona_regala'];
		$telefono_regala=$r['mobil_persona_regala'];

		$localizador= $r['codi_localtzador'];
		$consumo= '';
		$texto_localizador='Localizador';
		if (!in_array($r['origen'],array('CODIGO_ALFA','DOOPLAN','LA_TIENDA_MARCA')))
			{
			$consumo = $r['codi_consum'];
			$texto_consumo='Consumo';
			}
			
			
		$observaciones = convert_caracters_hex($r['Observaciones']);
	
	
	}
	else
	{	
		$id_alta = request('id_alta');
		$fecha_reserva=request('data_reserva');
		$ip=request('ip');
		$origen=request('origen');
		
		$piloto=convert_caracters_hex(request('pilot'));
		$apellidos_piloto=convert_caracters_hex(request('apellidos_piloto'));
		$email=request('email');
		$telefono=request('telefon');
		$dia=$aux[0];
		$hora=$aux[1];
		$tipo=return_tipus_e(request('tipus'));
		$persona_regala=convert_caracters_hex(request('persona_regala'));
		$apellidos_persona_regala=convert_caracters_hex(request('apellidos_persona_regala'));
		$nif_regala = convert_caracters_hex(request('nif'));
		$email_regala= request('email_regala');
		$telefono_regala=request('telefon_regala');
		$localizador= request('codigo_localizador');   
		$consumo= '';
		//$textos_codigos = canvia_textos_codigo(request('origen'));
		//$texto_localizador = utf8_decode($textos_codigos[0]);
		$texto_localizador='Localizador';
		if (!in_array(request('origen'),array('CODIGO_ALFA','DOOPLAN','LA_TIENDA_MARCA')))
			{
			$consumo = request('codigo_consumo');
			//$texto_consumo = utf8_decode($textos_codigos[1]);
			$texto_consumo='Consumo';
			}
			
			
		$observaciones = convert_caracters_hex(request('Observaciones'));
	}

	$ancho_principal=700;
	$ancho_tabla_cuadro = 334;
	$ancho_cuadro = 334;
	$alto_tabla_cuadro = 150;
	$alto_cuadro = 100;
	$alto_cuadro2 = 70;
	$ancho_pestana1=250;
	$ancho_pestana2=580;
	$ancho_pestana3=145;
	$fuente_general=11;
	
	
    try 
    { 
	
	$cad = '
	<style>
	.borde_cuadro
	{
		border: 1px solid #CCCCCC;
	}
	.borde_pestana
	{
		border: 1px solid #CCCCCC;
		border-bottom:none;
	}
	.importante
	{
		color:#ff0000;
	}
	.tabla_cuadro_principal
	{
		width:'.$ancho_principal.'px;
		font-size:'.$fuente_general.'px;
		margin-top:15px;
		margin-left:20px;
	}
	.cuadro_principal
	{
		width:'.$ancho_principal.'px;
		border-spacing:0;
		padding-top:12px;
		//padding-left:10px;
	}
	.tabla_cuadro_menor
	{
		width:'.$ancho_tabla_cuadro.'px;
		height:'.$alto_tabla_cuadro.'px;
		border-spacing:0;
		padding-top:12px;
	}
	.cuadro_menor
	{
		//width:'.$ancho_cuadro.'px;
		height:'.$alto_cuadro.'px;
		box-shadow: 10px 10px 5px #888888;
		
	}

	.cuadro_menor_inferior
	{
		width:'.$ancho_cuadro.'px;
		height:'.$alto_cuadro2.'px;
	}
	.pestana1
	{
		width:'.$ancho_pestana1.'px;
		height:20px;
		vertical-align:middle;
	}
	.pestana1_resto
	{
		width:'.($ancho_cuadro-$ancho_pestana1).'px;
	}
	.pestana2
	{
		width:'.$ancho_pestana2.'px;
		height:20px;
		vertical-align:middle;		
	}
	.pestana2_resto
	{
		width:'.($ancho_principal-$ancho_pestana2).'px;
	}
	.pestana3
	{
		width:'.$ancho_pestana3.'px;
		height:20px;
		vertical-align:middle;	
	}
	.pestana3_resto
	{
		width:'.($ancho_principal-$ancho_pestana3).'px;
	}

	div.lista_confirm span,div.datos_persona,div.lista_confirm p
	{
		margin:0;
		text-indent:0;
		text-align:left;

	}
	div.lista_confirm p
	{
		padding:5px;
	}
	div.lista_confirm span
	{
		padding: 5px !important;
	}
	
	#condiciones p{margin-bottom:1px;padding:5px;}
	
	div.datos_pestana
	{
		padding:5px;
	}
	</style> ';
	


	
	
				  
				  
	// cuadro superior izquierdo 
				  
	$cuadro1 = 		
	'<table class="tabla_cuadro_menor" cellspacing="0" cellpadding="0">
	  <tr>
		<td class="pestana1 borde_pestana">
			<div class="datos_pestana">
				<strong>Datos del piloto registrados por el usuario </strong>
			</div>
		</td>
		<td class="pestana1_resto">
		</td>
	  </tr>
	  <tr>
		<td colspan="2" class="cuadro_menor borde_cuadro">
			<div class="lista_confirm">
				<p>
					<span style="font-weight:bold;">Evento:</span> <span>'.$tipo.'</span>
				</p>	
				<p>
					<span style="font-weight:bold;">Ciudad:</span> <span>'.$ciudad.'</span>
				</p>	
				<p>
					<span style="font-weight:bold;">Día de la experiencia:</span> <span>'.implode('/',array_reverse(explode('-',$dia))).'</span>
				</p>	
				<p>
					<span style="font-weight:bold;">Hora escogida:</span> <span>'.$hora.'</span>
				</p>	
				<p>
					<span style="font-weight:bold;">Nombre:</span> <span>'.$piloto.' '.$apellidos_piloto.'</span>
				</p>	
				<p>
					<span style="font-weight:bold;">Teléfono:</span> <span>'.$telefono.'</span>
				</p>	
				<p>
					<span style="font-weight:bold;">Email:</span> <span>'.$email.'</span>
				</p>	
			</div>							
		</td>
	  </tr>
	 </table>';

	// cuadro superior derecho 
	$cuadro2 ='
  	<table class="tabla_cuadro_menor" cellspacing="0" cellpadding="0" style="margin-left:20px;">
	  <tr>
		<td class="pestana1 borde_pestana">
			<div class="datos_pestana">
				<strong>Datos de la persona que regala </strong>
			</div>
		</td>
		<td class="pestana1_resto">
		</td>
	  </tr>
	  <tr>
		<td colspan="2"  class="cuadro_menor borde_cuadro">
			<div class="lista_confirm">
				<p>
					<span style="font-weight:bold;">Nombre:</span> <span>'.$persona_regala.'</span>
				</p>	
				<p>
					<span style="font-weight:bold;">Apellidos:</span> <span>'.$apellidos_persona_regala.'</span>
				</p>	
				<p>
					<span style="font-weight:bold;">Teléfono:</span> <span>'.$telefono_regala.'</span>
				</p>	
				<p>
					<span style="font-weight:bold;">Dni/Nie:</span> <span>'.$nif_regala.'</span>
				</p>	
				<p>
					<span style="font-weight:bold;">Email:</span> <span>'.$email_regala.'</span>
				</p>	
				<p>
				&nbsp;
				</p>	
				<p>
				&nbsp;
				</p>	
			</div>							
		</td>
	  </tr>
	 </table>';
		
	//** cuadro inferior izquierdo 
	$cuadro3='
	<table class="tabla_cuadro_menor" cellspacing="0" cellpadding="0">
	  <tr>
		<td class="pestana1 borde_pestana">
			<div class="datos_pestana">
				<strong>Datos de registro introducidos por el usuario </strong>
			</div>
		</td>
		<td class="pestana1_resto">
		</td>
	  </tr>
	  <tr>
		<td colspan="2"  class="cuadro_menor borde_cuadro">
			<div class="lista_confirm">
				<p>
					<span style="font-weight:bold;">Fecha de registro:</span> <span>'.implode('/',array_reverse(explode('-',substr($fecha_reserva,0,10)))).' a las '.substr($fecha_reserva,11).'</span>
				</p>	
				<p>
					<span style="font-weight:bold;">Dirección IP:</span> <span>'.$ip.'</span>
				</p>	
				<p>
					<span style="font-weight:bold;">Origen del cupón:</span> <span>'.$origen.'</span>
				</p>	
				<p>
					<span style="font-weight:bold;">'.$texto_localizador.':</span> <span>'.$localizador.'</span>
				</p>	';
			if ($consumo!='')
			$cuadro3 .= '
				<p>
					<span style="font-weight:bold;">'.$texto_consumo.':</span> <span>'.$consumo.'</span>
				</p>';	
	$cuadro3 .=						'	
			</div>							
		</td>
	  </tr>
	 </table>';	

	 //** cuadro inferior derecho 
	$cuadro4='
	<table class="tabla_cuadro_menor" cellspacing="0" cellpadding="0" style="margin-left:20px;">
	  <tr>
		<td class="pestana1 borde_pestana">
			<div class="datos_pestana">
				<strong>Observaciones </strong>
			</div>	
		</td>
		<td class="pestana1_resto">
		</td>
	  </tr>
	  <tr>
		<td colspan="2" class="cuadro_menor borde_cuadro">
			<div class="lista_confirm">
				<p>
					<span>'.$observaciones.'</span>
				</p>	
			</div>							
		</td>
	  </tr>
	</table>';
 

	
	
   //** Texto de marcos inferiores 

	$texto_condiciones = 
	'<p>
		<strong>Su reserva ha sido realizada tal y como nos ha indicado y registrado en nuestro sistema</strong>, revise todos sus datos de contacto, fecha y hora del evento y ciudad escogida. En caso de haber escogido alguna opción incorrecta o existe algún teléfono o email incorrecto contacte a info@motorclubexperience.com para rectificar y recibir la nueva confirmación de reserva correctamente. (el sistema de reservas únicamente registra los datos que usted nos a indicado por lo que no tiene ninguna validez sin no va acompañado del cupón comprado)
	</p>
	<p>
		<strong>Recuerde que la hora que le asignamos es aproximada</strong>, pero debe presentarse 30 minutos antes de la hora solicitada para entregar la documentación. <span class="importante">Es muy importante presentar esta confirmación junto con el cupón comprado, fotocopia del DNI y fotocopia del carnet de conducir en nuestras instalaciones. En caso de no presentar dicha documentación no se podrá realizar el servicio.</span> Si desea cancelar o modificar esta reserva, debe hacerlo con una antelación mínima de 7 días.
	</p>
    <p> 
		<strong>Tenga en cuenta que pueden derivarse retrasos, por ello la hora que le asignamos es aproximada, y los retrasos de salida con los deportivos pueden estar comprendidos entre 30 minutos y una hora y media aproximadamente como mucho</strong>, no es habitual, pero normalmente esto puede ocurrir a ultima hora de mediodía y a finales de la tarde.
    </p>
	<p>	
		Si su cupón está a punto de caducar o caduca para el día que quiere realizar el evento póngase en contacto con nosotros para ampliar la fecha de caducidad. Ya que una vez caducado no podremos activarlo ni prestar el servicio.
     <strong>'.$empresa.' no podrá realizar ningún servicio a todo participante que entregue su cupón caducado el día del evento sin su justificante de ampliación de '.$empresa.'</strong></p>
	<p>
		<strong>Os recordamos que dicha actividad está sujeta a condiciones meteorológicas y averías imprevistas. Todos aquellos eventos que sean suspendidos por dichas causas, serán notificados al mismo email que ha recibido esta confirmación de reserva. Os recomendamos que la noche antes del evento revise su correo para asegurarse de que no hay ninguna anulación por incidente, ya sea meteorológico, averías imprevistas etc… Revise su correo no deseado por favor.</strong></p>
 	<p>
     <span class="importante">'.$empresa.' no se hace cargo</span> de los alojamientos de Hotel y desplazamientos, ya sean públicos o privados,  por consecuencia de las molestias ocasionadas por la suspensión de las mencionadas condiciones de incidencias meteorológicas o averías imprevistas que esta sujeta la actividad. Le recomendamos que si realiza un viaje en  avión o dispone de una estancia en hotel, asegúrese de que tenga la opción de cancelar para que pueda reservar para otro día sin tener los gastos y molestias que puedan derivar una suspensión. Si no esta conforme con las condiciones que le informamos en esta confirmación de reserva póngase en contacto a info@motorclubexperience.com para anular su reserva.
	</p>	
	';

	$texto_puntos_encuentro =
	'<div class="lista_confirm">
		<p><strong>Madrid:</strong> Hotel Sara de Ur.  C/ Corcho, 26.  La Cabrera 28751 (Madrid)</p>

		<p><strong>Barcelona:</strong> Avda. Mestre Montaner nº 12. Igualada 08700 ( Barcelona )</p>

		<p><strong>Valencia:</strong> Hotel la Carreta.  Situado en la Carretera de Madrid a Valencia, KM, 334  46370 Chiva (Valencia) 	pegado al circuito de Chester.</p>

		<p><strong>Andalucía:</strong> Hotel Don Gonzalo.  Ctra. Nal. 331 Córdoba-Málaga, KM 47 14550 Montilla (Andalucía)</p>

		<p><strong>Cantabria:</strong> Hotel Vejo.  Avenida de Cantabria, 83  (39200) Reinosa (Cantabria)</p>
	</div>
	';

   
	
	
    //** marco inferior arriba
	
	$cuadro_inferior1=
	'
	<table class="cuadro_principal" cellspacing="0" cellpadding="0">
	<tr>
		<td class="pestana2 borde_pestana">
			<div class="datos_pestana">
				<span class="importante" style="weight:bold;">Es muy importante que lea esta información para que conozca las condiciones de uso.</span>
			</div>	
		</td>
		<td class="pestana2_resto">
		</td>
	</tr>
	<tr>
		<td id="condiciones" colspan="2" class="borde_cuadro">
			<div>
			'.$texto_condiciones.'
			</div>

		</td>
	</tr>
	</table>';
	
    //** marco inferior abajo 
	
	$cuadro_inferior2=
	'
	<table class="cuadro_principal" cellspacing="0" cellpadding="0">
	<tr>
		<td class="pestana3 borde_pestana">
			<div class="datos_pestana">
				<strong>Puntos de encuentro</strong>
			</div>	
		</td>
		<td class="pestana3_resto">
		</td>
	</tr>
	<tr>
		<td colspan="2" class="borde_cuadro">
			<div>
			'.$texto_puntos_encuentro.'
			</div>
		</td>
	</tr>
	</table>';
	
	//$cuadro_inferior1='';
	//$cuadro_inferior2='';
	//$texto_puntos_encuentro='';
	$cad .= ' 
    <table id="confirmacion" class="tabla_cuadro_principal" cellspacing="0" cellpadding="0">
	<tr>
	  <td style="height:70px;" colspan="2">
	  </td>
	</tr>
	<tr>
	  <td>
	  '.$cuadro1.'
	  </td>
	  <td>
	  '.$cuadro2.'
	  </td>
	</tr>
	<tr>
	  <td>
	  '.$cuadro3.'
	  </td>
	  <td>
	  '.$cuadro4.'
	  </td>
	</tr>
	<tr>
		<td colspan="2">
		'.$cuadro_inferior1.'
		</td>
	</tr>
	<tr>
		<td colspan="2"> 
		'.$cuadro_inferior2.'
		</td>
	</tr>
	</table>';
				  
     
	 
     $cad = '<page backimg="http://www.motorclubexperience.com/img/'.$imagen_fondo.'">'.$cad.'</page>';
				  
	
	
        $cad = convert_caracters_hex($cad);
		
		$nombref = generar_codigo();
		$nombref .= $piloto;
		$nombre_fichero = $nombref;

        //echo($cad);         
        
        ob_start();
		
        $html2pdf = new HTML2PDF('P', 'A4', 'fr');
        $html2pdf->setTestTdInOnePage(false);
		$view_html=0;
        $html2pdf -> writeHTML($cad, ($view_html==1));  
//die('aki6 '.$_GET['vista_previa'].'-'.$ncupon);   

        //Si estamos generando la vista previa del cupón generaremos un código aleatorio para el nombre del archivo pdf.
        //$html2pdf -> Output('confirmacion_reservas/confirm_' . $nombref . '.pdf', 'F');
		$html2pdf -> Output('../../../confirmacion_reservas/confirm_' . $nombref . '.pdf', 'F');
       
//header("Content-Disposition: inline; filename=foo.pdf");
    //$content  = file_get_contents('../cupones/tmp/cupon' . $ncupon . '.pdf');
return true;

         
    } catch(HTML2PDF_exception $e) {
        echo $e;
        eliminar_archivos($nombref);

        return false;
    }


}



function envia_mails_pdf_bd($ciudad,$r,$destinatario)
{
	$nombref='';
	
	if(strpos(strtoupper($r['Observaciones']),'HCCSPORTSCAR')!==false) 	$empresa = 'Hccsportcars';
	else if(strpos(strtoupper($r['Observaciones']),'DREAMCARS')!==false)  $empresa = 'Dreamcarsexperience';
	else $empresa = 'Motorclubexperience';
	
	generar_pdf_confirm_reserva($nombref,$empresa,$_REQUEST['ciudad'],$r['id_event'],$r,true);
	
	include_once 'class.phpmailer.php';
	include_once 'textos_mensajes.php';

	
	$mail = new PHPMailer();

    $mail->Host = "localhost";
	$mail -> CharSet = "UTF-8";
	switch($empresa)
	{
		case 'Hccsportcars':
			$mail->From = "info@hccsportcars.com";
			$mail->FromName = "hccsportcars.com";
			$mail->Subject = "Confirmación de Reserva Hcc Sport Cars";
			//$mail->Subject = 'hccsportcars.com';
		break;
		case 'Dreamcarsexperience':
			$mail->From = "info@dreamcarsexperience.com";
			$mail->FromName = "Dreamcarsexperience";
			$mail->Subject = "Confirmación de Reserva Dream Cars Experience";
			//$mail->Subject = 'Dreamcarsexperience';
		break;
		case 'Motorclubexperience':
			$mail->From = "info@motorclubexperience.com";
			$mail->FromName = "Motorclubexperience";
			$mail->Subject = "Confirmación de Reserva Motor Club Experience";
			//$mail->Subject = 'Motorclubexperience';
		break;
	}

    //if($r['email_confirm']=='')$mail->AddAddress($r['email_persona_regala']);
    //else $mail->AddAddress($r['email_confirm']);	

//	$mail->AddBCC("motorclubexperience@hotmail.com","oculto");

   
	$body='';



    //dirname(__FILE__).'/
    $mail -> AddAttachment('../../../confirmacion_reservas/confirm_'.$nombref.'.pdf', 'confirmacion_reserva.pdf');
    

	if ($destinatario!='motorclub')
	{
		$mail->AddAddress($destinatario);
		
		$body = "<strong></strong> Reserva para " . implode('/',array_reverse(explode('-',substr($r['id_event'],0,10)))) . "<br><br>";
		$body .= "<i>Enviado por ".$empresa." </i><br><br>";
		$body .= "<strong>USUARIO: " . $r['persona_regala']." ".$r['apellidos_persona_regala']."</strong><br>
		<br><br>";
		$body .= "<i><strong>Le adjuntamos la confirmación de reserva que debe presentar junto con el vale comprado de la experiencia.</strong></i><br><br>";
    }
	else
	{
		$mail->AddAddress('motorclubexperience@hotmail.com');
		//$mail->AddBCC("marctorraso@gmail.com","oculto");

		//$mail->AddAddress('marctorraso@yahoo.es');
		$aux_ciudad=$_REQUEST['ciudad'];
		if(trim($aux_ciudad)=='')$aux_ciudad='Barcelona';
		$aux_ciudad=strtoupper($aux_ciudad );
		
		$body.= "<strong>Su reserva ha sido realizada con los siguientes datos</strong><br><br>";
		$body.= "<strong>Fecha Reserva: </strong>".$r['data_reserva'].'<br>';
		$body.= "<strong> Direcci&oacute;n IP: </strong>".$r['ip'].'<br>';		
		$body.= "<strong>Nombre piloto: </strong>".convert_caracters_hex($r['pilot']).'<br>';
		$body.= "<strong>Apellidos piloto: </strong>".convert_caracters_hex($r['apellidos_piloto']).'<br>';
		$body.= "<strong>Email piloto: </strong>".$r['email'].'<br>';
		$body.= "<strong>Tel&eacute;fono piloto: </strong>".$r['telefon'].'<br>';
		$body.= "<strong>Origen: </strong>".str_replace('_',' ',$r['origen']).'<br>';
		
		
		if(trim($r['fecha_entrada'])!='' and substr(trim($r['fecha_entrada']),0,10)!='0000-00-00') 
		{
		//$body.= "<strong>Hotel: </strong>".nombre_hotel($_REQUEST['id_hotel']).'<br>';
		
		if ($r['origen']=='1') $alojamiento = 'Alojamiento + Desayuno';
		else $alojamiento = 'Media Pensi&oacute;n';
		$body.= "<strong>Alojamiento: </strong>".$alojamiento.'<br>';

		if (trim($r['fecha_entrada'])!='') $body.= "<strong>Fecha de entrada: </strong>".implode('/',array_reverse(explode('-',substr($r['fecha_entrada'],0,10))))."<br>";
		if (trim($r['fecha_salida'])!='') $body.= "<strong>Fecha de salida: </strong>".implode('/',array_reverse(explode('-',substr($r['fecha_salida'],0,10))))."<br>";
		
		if ($r['spa']==='1') $body.= "<strong>Este vale dispone de SPA</strong><br>";
		if (trim($r['persona_hotel'])!='') $body.= "<strong>Personal del hotel que realiz&oacute; la reserva: </strong>".utf8_decode($r['persona_hotel'])."<br>";

		}
		
		
		$body.= "<strong>Dia: </strong>".$aux[0].'<br>';    
		$body.= "<strong>Hora: </strong>".$aux[1].'<br>';
		$body.= "<strong>Evento: </strong>".return_tipus_e($r['tipus_event']).'<br>';
		$body.= "<strong>Nombre persona que regala: </strong>".convert_caracters_hex($r['persona_regala']).'<br>';
		$body.= "<strong>Apellidos persona que regala: </strong>".convert_caracters_hex($r['apellidos_persona_regala']).'<br>';
		$body.= "<strong>Email persona que regala: </strong>".$r['email_persona_regala'].'<br>';
		$body.= "<strong>M&oacute;bil persona que regala: </strong>".$r['mobil_persona_regala'].'<br>';
		$textos_codigos = canvia_textos_codigo($r['origen']);
		$body.= "<strong>".utf8_decode($textos_codigos[0]).": </strong>".$r['codi_localtzador'].'<br>';
		if (!in_array($r['origen'],array('CODIGO_ALFA','DOOPLAN','LA_TIENDA_MARCA'))) 
			$body.= "<strong>".utf8_decode($textos_codigos[1]).": </strong>".$r['codi_consum'].'<br>';

	//    $body.= "<strong>C&oacute;digo localizador: </strong>".$r['codi_localtzador'].'<br>';
	///    $body.= "<strong>C&oacute;digo consumo: </strong>".$r['codi_consum'].'<br>';
		//$body.= "<strong>Ciudad: </strong>".strtoupper(request('ciudad')).'<br>';
		$body.= "<strong>Ciudad: </strong>".$aux_ciudad.'<br>';
		$body.= "<strong>Observaciones: </strong>".convert_caracters_hex($r['Observaciones']).'<br>';
	}	
	$mail -> Body = $body;
    $mail -> IsHTML(true);

    if (!$mail -> Send()) {
        echo('error ' . $mail -> ErrorInfo);
        if ($nombref!='') eliminar_archivos($nombref);
        unlink(dirname(__FILE__) . '/../../../confirmacion_reservas/confirm_'.$nombref.'.pdf');
        //unlink(dirname(__FILE__) . '/../cupones/tmp/pdf_cupon' . $ncupon . '.html');
        return false;
    }

    if ($nombref!='') eliminar_archivos($nombref);

	echo 'OK'; 
  
}

function eliminar_archivos($nombref) {
    unlink(dirname(__FILE__) . '/../../../confirmacion_reservas/confirm_' . $nombref . '.pdf');
    //unlink(dirname(__FILE__) . '/../cupones/tmp/pdf_cupon' . $ncupon . '.html');

}
  
function generar_codigo()
{
   $c=genera_num();
   return $c;
}   
  
/* Fi	 Noves confirmacions de reserva en format pdf **/
  
  
function convert_caracters_hex($cad) {
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
function elimina_caracters($cad) {
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

function x_chars_cor($cad) {
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
    include_once 'class.phpmailer.php';
    
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
  
   
function canvia_textos_codigo($origen){
  
  $r=array();
  switch($origen)
   {
   	case 'LETS BONUS':
	$r[0]='Localizador';
	$r[1]='Codigo consumo';
	break;
	case 'GROUPALIA':
	$r[0]='Numero de vale';
	$r[1]='Numeración codigo de barras completo ';
	break;
	case 'OFFERUM':
	$r[0]='Código del bono';
	$r[1]='Código de validación';
	break;
	case 'ATRAPALO':
	$r[0]='Número de vale';
	$r[1]='Código de reserva';
	break;
	case 'OFERTIX':
	$r[0]='Código reserva';
	$r[1]='Código de validación';
	break;
	case 'DOOPLAN':
	$r[0]='Código ';
	$r[1]='Código ';
	break;
	case 'LA_TIENDA_MARCA':
	$r[0]='Número de pedido ';
	$r[1]='Código ';
	break;
	case 'DISFRUTALO':
	$r[0]='Localizador';
	$r[1]='Codigo consumo';
	break;
	case 'COLECTIVIA':
	$r[0]='Código de identificación';
	$r[1]='Código de seguridad';
	break;
	case 'DACOTABOX':
	$r[0]='Código de barras del cheque';
	$r[1]='Código de validación';
	break;
	case 'SMARTBOX':
	$r[0]='Localizador';
	$r[1]='Codigo consumo';
	break;
	
    case 'CODIGO_ALFA':
    $r[0]='Código ';
    $r[1]='Código ';
    break;

	default:
	$r[0]='Localizador';
	$r[1]='Codigo consumo';
	break;
   }
   return $r;		
}   
  

?>