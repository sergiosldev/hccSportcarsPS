<?php

/* mts 24022012, modif. validación códigos localizador */
include('../config/config.inc.php');

/* fin modif. mts */
include('config_events.php');
include('funciones_validacion.php');
//print_r($_REQUEST);

if(!isset($_REQUEST['ciudad']))$_REQUEST['ciudad']='';
//$_REQUEST['ciudad']='';

if(!isset($_REQUEST['ciudad']))$_REQUEST['ciudad']='';
//$_REQUEST['ciudad']='';

//mts 14032012
if ($_REQUEST['tipus']=='ferrari_360') $_REQUEST['tipus']='ferrari';

if(isset($_REQUEST['codigo_valida']))
  {
  /* mts 24032012 Modif. para validar códigos de localizador ya existentes en la b.d */    
  //if(codigo_existe($_REQUEST['codigo_valida'])) die('ERROR_EXIST');	
  /* fin modif mts */
  if(codigos_validos($_REQUEST['codigo_valida']) ){
  	session_start();
	$_SESSION["accessevents"] = date("Y-n-j H:i:s");
	die('OK');
	}
  else die('ERROR');	
  } 
/*mts 24032012, validamos que el código de localizador no esté registrado */  
function codigo_existe($c)
{
    $sql='SELECT * FROM events WHERE codi_localtzador like "'.$c.'";';
  
    $result=mysql_query($sql);    
    
    if(mysql_num_rows($result)!=0) return true;  
    else return false;
           
}  
/* fin modif mts */
function codigos_validos($c)
 {
 	     

 	/* fin validación mts */
 	if(strtoupper(substr($c,0,2))=='LT' || 
	strtoupper(substr($c,0,1))=='A' || 
	strtoupper(substr($c,0,2))=='TI' || 
	strtoupper(substr($c,0,3))=='MDT' ||
	strtoupper(substr($c,0,3))=='O' ||
	strtoupper(substr($c,0,3))=='F' || 
	strtoupper($c)=='GTPASION' ||
    strtoupper($c)=='A6TO6' ||
    strtoupper($c)=='OSCE895461' ||

	strtoupper(substr($c,0,2))=='21' )
	 return true;
	return false; 
 }

if(isset($_REQUEST['id_alta']) && trim($_REQUEST['edicio'])=='false')
{

	//die('aki');

	
	// if(!es_pot_donar_alta()){ die('error'); }
    
    //mts 25042012.  si se trata de una promoción, se añade el texto Extra 49 euros en observaciones.
    if (request('tipus')=='ferrari_porsche901' || request('tipus')=='lamborghini_lotus')
    {
        if ($_REQUEST['Observaciones']<>'') $_REQUEST['Observaciones'] = ' Extra 49 &euro; - '.$_REQUEST['Observaciones'];    
        else $_REQUEST['Observaciones'] = ' Extra 49 &euro;';
    } 
        
	/*if (request('alojamiento_ad')=='0') $_alojamiento = 0;
	else if (request('alojamiento_ad')=='1')  $_alojamiento = 1;
    else $_alojamiento = '';
	*/
	if(trim($_REQUEST['alojamiento_ad'])=='')        
		$_alojamiento='';
	else
	{
	if (request('alojamiento_ad')=='0') $_alojamiento = '0';
	else if (request('alojamiento_ad')=='1')  $_alojamiento = '1';
    }
	//die('akir'.$_alojamiento);
	
	if (request('es_spa')=='1') $_spa=1; 
	else $_spa=0;
		
	if($_REQUEST['id_hotel'])
	 {
	 if (request('fechaentrada')!='') $_fecha_entrada = implode('-',array_reverse(explode('/',request('fechaentrada'))));
	 if (request('fechasalida')!='') $_fecha_salida = implode('-',array_reverse(explode('/',request('fechasalida'))));
     }
	 else
	 {
	 $_fecha_entrada = '';
	 $_fecha_salida = '';
	 }
	if (trim(request('persona_hotel'))!='') $_persona_hotel = request('persona_hotel');	
		
	if($_REQUEST['id_hotel'])
	 {
	 if ($_REQUEST['Observaciones']<>'') $_REQUEST['Observaciones']= $_REQUEST['persona_hotel'].'-'.$_REQUEST['Observaciones'];    
     else $_REQUEST['Observaciones'] = $_REQUEST['persona_hotel'];

     //$texto=($_alojamiento==0)?' Alojamiento + Desayuno':'Media Pensi&oacute;n';
	 
	 if ($_alojamiento=='') $texto='';
	 else if($_alojamiento=='0') $texto=' Alojamiento + Desayuno';
	 else if ($_alojamiento=='1') $texto='Media Pensi&oacute;n';
	 
	 
	 if ($_spa==1) $texto.= ' - El vale dispone de SPA';
	 if ($_REQUEST['Observaciones']<>'') $_REQUEST['Observaciones'] = $texto.' - '.$_REQUEST['Observaciones'];    
     else $_REQUEST['Observaciones'] = $texto;

	 if ($_REQUEST['Observaciones']<>'') $_REQUEST['Observaciones'] = nombre_hotel($_REQUEST['id_hotel']).' - '.$_REQUEST['Observaciones'];   
     else $_REQUEST['Observaciones'] = nombre_hotel($_REQUEST['id_hotel']);
	 }
		
 	if (strtoupper(request('origen'))=='OTROS') $origen_observ = request('otros');	
	else $origen_observ = request('origen');
    
	$_REQUEST['Observaciones'] = str_replace('_',' ',$origen_observ).' - '.$_REQUEST['Observaciones'];    

		
    if(isset($_REQUEST['hccsportscars_reserva']))
	   $_REQUEST['Observaciones']='HCCSPORTSCAR '.$_REQUEST['Observaciones'];
	else if(isset($_REQUEST['dreamcars_reserva']))
	   $_REQUEST['Observaciones']='DREAMCARS '.$_REQUEST['Observaciones'];


	
	
	if (valida_formato_fecha_caducidad(request('fecha_caducidad'))===false)
    {
        $_aux= " Formato de fecha incorrecto.";
            
        die('<div style="border:1px solid #f00;margin:3px;padding:3px;color:#f00;font-weight:bold;font-size:12px">'.$_aux.'</div>');        
    }
	//die(valida_fecha_caducidad(request('fecha_caducidad'),request('id_alta')));
	//die(valida_fecha_caducidad(request('fecha_caducidad'),request('id_alta'))); 
	//if (!valida_fecha_caducidad(request('fecha_caducidad'),request('id_alta')) && strtoupper(request('fecha_caducidad'))!=='CA' && strtoupper(request('fecha_caducidad'))!=='SI' && strtoupper(request('fecha_caducidad'))!=='SIN FECHA DE CADUCIDAD' )
	if (!valida_fecha_caducidad(request('fecha_caducidad'),request('id_alta')) && request('fecha_caducidad')!=='00/00/0000')
	{
        $_aux= " Su cupón está caducado para la fecha que ha escogido en realizar el evento, contacte a info@motorclubexperience.com y solicite que le amplíen la fecha de caducidad, y le envíen el cupón de ampliación. Esta gestión es muy importante,  ya que el día del evento los organizadores no admiten cupones caducados sin su confirmación de ampliación. Con lo cual será imposible prestar los servicios. Para más información contacte al 931263281 - 680697109.";
            
        die('<div style="border:1px solid #f00;margin:3px;padding:3px;color:#f00;font-weight:bold;font-size:12px">'.$_aux.'</div>'); 	    
	}
	if (str_replace(' ','',$_REQUEST['id_hotel'])=='' && valida_ip(GetUserIp_())==false)
    {   
        $_aux= "Ha superado el límite de reservas para este mes. Póngase en contacto con nosotros y se la realizaremos de forma manual.";
            
        die('<div style="border:1px solid #f00;margin:3px;padding:3px;color:#f00;font-weight:bold;font-size:12px">'.$_aux.'</div>'); 
    }
   
   
   
	
	if($_aux_=valida()){
		die('<div style="border:1px solid #f00;margin:3px;padding:3px;color:#f00;font-weight:bold;font-size:12px">'.$_aux_.'</div>'); 
	}  
	
   	//Para el caso (Hotel Ciutat Igualada) no validará el nif.
	if(!($_REQUEST['id_hotel'] && ($_REQUEST['id_hotel']=='4949' || $_REQUEST['id_hotel']='2011')))	
	{

		$ret=check_nif_cif_nie(request('nif'));
			//die('2');
		//die('res:'.$ret);  
		if ($ret===false)
		{
			$_aux= " Formato de nif incorrecto.";
				
			die('<div style="border:1px solid #f00;margin:3px;padding:3px;color:#f00;font-weight:bold;font-size:12px">'.$_aux.'</div>');        
		}
		//else die('a'.$a);
	}
    if($_REQUEST['tipus']=='porsche996'){
		 $sql='SELECT i.* FROM `events'.$_REQUEST['ciudad'].'` as i WHERE ( i.id_event="'.$_REQUEST['id_alta'].'") AND 
	 (i.tipus_event="porsche996" ) ';
	 $result=mysql_query($sql);
	 if(mysql_num_rows($result))$_REQUEST['tipus']='porsche997';
	}
	
	if(trim($_REQUEST['origen']=='OTROS'))$_REQUEST['origen']=$_REQUEST['otros'];

	if(!isset($_REQUEST['email1']))$_REQUEST['email1']='';
	
 
    if(!es_pot_donar_alta())
       	die('<div style="border:1px solid #f00;margin:3px;padding:3px;color:#f00;font-weight:bold;font-size:12px">YA ESTA OCUPADA LA HORA EN QUESTIÓN, HA SIDO OCUPADA MIENTRAS USTED ESTABA EN RESERVAS </div>'); 
	

	
/*	mts 27092012 $sql='INSERT INTO `events'.$_REQUEST['ciudad'].'` (
	id_event ,email ,telefon ,pilot,dia,tipus_event,persona_regala,email_persona_regala,mobil_persona_regala,coches,codi_localtzador,codi_consum,Observaciones,origen,plazas,email_confirm,data_reserva)
	VALUES ("'.request('id_alta').'", "'.request('email').'", "'.request('telefon').'", 
	"'.request('pilot').'","'.$aux[0].'","'.request('tipus').'"
	,"'.request('persona_regala').'","'.request('email_regala').'","'.request('telefon_regala').'","'.request('coches').'"
	,"'.request('codigo_localizador').'","'.request('codigo_consumo').'","'.request('Observaciones').'","'.request('origen').'","'.plazas($_REQUEST['tipus']).'"
	,"'.request('email1').'","'.date('Y-m-j',now()).'");';

*/


//if (strtoupper(request('fecha_caducidad'))=='CA' || strtoupper(request('fecha_caducidad'))=='SI' || strtoupper(request('fecha_caducidad'))=='SIN FECHA DE CADUCIDAD'  )
if (request('fecha_caducidad')=='00/00/0000')
    $sfecha_caducidad = '';
else $sfecha_caducidad = request('fecha_caducidad');




$sql='INSERT INTO `events'.$_REQUEST['ciudad'].'` (
    id_event ,email ,telefon ,pilot,dia,tipus_event,persona_regala,email_persona_regala,mobil_persona_regala,coches,codi_localtzador,codi_consum,Observaciones,origen,plazas,email_confirm,data_reserva,data_caducitat_cupo,ip,cupon,nif,alojamiento,spa,persona_hotel,apellidos_piloto,apellidos_persona_regala,fecha_entrada,fecha_salida)
    VALUES ("'.
	request('id_alta').'", "'.
	request('email').'", "'.
	request('telefon').'","'.
	request('pilot').'","'.
	$aux[0].'","'.
	request('tipus').'","'.
	request('persona_regala').'","'.
	request('email_regala').'","'.
	request('telefon_regala').'","'.
	request('coches').'","'.
	request('codigo_localizador').'","'.
	request('codigo_consumo').'","'.
	request('Observaciones').'","'.
	request('origen').'","'.
	plazas($_REQUEST['tipus']).'","'.
	request('email1').'","'.
	request('data_reserva').'","'.
	$sfecha_caducidad.'",INET_ATON("'.request('ip').'"),"'.
	request('fileUpload').'","'.
	request('nif').'","'.
	$_alojamiento.'","'.
	$_spa.'","'.
	$_persona_hotel.'","'.
	request('apellidos_piloto').'","'.
	request('apellidos_persona_regala').'","'.
	$_fecha_entrada.'","'.
	$_fecha_salida.'");';
   
//fin modif. mts 27092012. 
	
	
	$result=mysql_query($sql,$link)  or die('error '.mysql_error());
     
	 
	 if($result)
	 {
		 // En cas d'id d'hotel
		 if(str_replace(' ','',$_REQUEST['id_hotel'])!='')
			envia_mails_hotel();
		 else 
		 {
			envia_mails();
			envia_oferta_mails();
		 }


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



function es_pot_donar_alta(){
   global $link;
   
   // afegit per assegurar tiro
   $t_aux=' tipus_event="'.request('tipus').'" ';
   
    if( $_REQUEST['tipus']=='ferrari' || $_REQUEST['tipus']=='ferrari_porsche901' ){
  	$t_aux='(i.tipus_event="ferrari" OR i.tipus_event="ferrari_porsche901") ';
	}
 else if($_REQUEST['tipus']=='lamborghini' || $_REQUEST['tipus']=='lamborghini_lotus'  ){
  	$t_aux='(i.tipus_event="lamborghini_lotus" OR i.tipus_event="lamborghini") ';
   }
   
   		
   	$sql='SELECT i.* FROM events'.$_REQUEST['ciudad'].' as i WHERE i.id_event="'.request('id_alta').'" AND '.$t_aux.'';

    $result=mysql_query($sql,$link);
	return (mysql_num_rows($result)<1);
   }

function valida()
   {
   	$cad='';
	//Para el hotel Ciutat Igualada sólo se validarán el mail de confirmación y la fecha de caducidad.
	 if(!($_REQUEST['id_hotel'] && ($_REQUEST['id_hotel']=='4949' || $_REQUEST['id_hotel']=='2011')))		
	 {
		 if(trim($_REQUEST['email'])==''){$cad.='El email del piloto es obligatorio<br>'; }  
		 else if (!filter_var($_REQUEST['email'], FILTER_VALIDATE_EMAIL)) {
		   $cad.='El email del piloto es no tiene un formato valido<br>';
			  }	

		 if(trim($_REQUEST['email_regala'])==''){$cad.='El email de la persona que regala es obligatorio<br>'; }  
		 else
		if ( !filter_var($_REQUEST['email_regala'], FILTER_VALIDATE_EMAIL)) {
		   $cad.='El email de la persona que regala  no tiene un formato valido<br>';
			  }		    	

		 if(trim($_REQUEST['telefon']=='')){$cad.='El teléfono del piloto es obligatorio<br>'; } 
		 
		else
		   if ( !preg_match('/^[0-9]{1,}$/',$_REQUEST['telefon'])) {
		   $cad.='El telefono del piloto no es valido<br>';
			  }	
		 
		 if(trim($_REQUEST['pilot'])==''){$cad.='El nombre del piloto es obligatorio<br>'; }
		 if(trim($_REQUEST['apellidos_piloto'])==''){$cad.='Los apellidos del piloto son obligatorios<br>'; }


		 if ($_REQUEST['id_hotel'] && $_REQUEST['alojamiento_ad']=='') $cad.='El tipo de alojamiento es obligatorio<br>';
	}

	if(isset($_REQUEST['email1'])){
		if(trim($_REQUEST['email1'])==''){$cad.='El email de confirmación de reserva es obligatorio<br>'; } 
		if(trim($_REQUEST['email2'])==''){$cad.='El email de confirmación de reserva repetido es obligatorio<br>'; }
		if(trim($_REQUEST['email1'])!='' && trim($_REQUEST['email2'])!=''){ 
		  if(trim($_REQUEST['email1'])!=trim($_REQUEST['email2'])){
		  $cad.='Los emails de confirmación de reserva deven coincidir<br>';
		  }
		  if ( !filter_var($_REQUEST['email1'], FILTER_VALIDATE_EMAIL)) {
		  $cad.='El email de  confirmación de reserva  no tiene un formato valido<br>';
		  }	
		  if ( !filter_var($_REQUEST['email2'], FILTER_VALIDATE_EMAIL)) {
		  $cad.='El email de  confirmación de reserva repetido  no tiene un formato valido<br>';
		  }
		}
	}
	//Para el hotel Ciutat Igualada sólo se validarán el mail de confirmación y la fecha de caducidad.	
	if(!($_REQUEST['id_hotel'] && ($_REQUEST['id_hotel']=='4949' || $_REQUEST['id_hotel']=='2011')))	
	{
		 if(trim($_REQUEST['persona_regala']=='')){$cad.='El nombre de la persona que regala  es obligatorio<br>'; } 
		 if(trim($_REQUEST['apellidos_persona_regala']=='')){$cad.='Los apellidos de la persona que regala son obligatorios<br>'; } 
		 if(trim($_REQUEST['nif']=='')){$cad.='El nif es obligatorio<br>'; } 
		 if(trim($_REQUEST['telefon_regala']=='')){$cad.='El teléfono de la persona que regala es obligatorio<br>'; } 

		 else
		   if ( !preg_match('/^[0-9]{1,}$/', $_REQUEST['telefon_regala'])) {
		   $cad.='El telefono de la persona que regala  no es valido<br>';
			  }		    
		 /*echo('alojamiento '.$_REQUEST['alojamiento'].'-'.$_REQUEST['spa']);*/
		 if($_REQUEST['id_hotel'])
		 {
		 if(trim($_REQUEST['alojamiento_ad'])==''){$cad.='El tipo de alojamiento es obligatorio<br>'; } 
		 if(trim($_REQUEST['spa']=='')){$cad.='El campo "El vale dispone de SPA" es obligatorio<br>'; } 
		 if(trim($_REQUEST['fechaentrada']=='')){$cad.='La fecha de entrada es obligatoria<br>'; } 
		 if(trim($_REQUEST['fechasalida']=='')){$cad.='La fecha de salida es obligatoria<br>'; }  
		 }
		 
		 
		 $valida_codigos_aux=true;
		 if(!str_replace(' ','',$_REQUEST['origen'])){$cad.='Debe escoger una opcion para el origen<br>'; } 
		 else if(trim($_REQUEST['origen'])!='C.C' &&  !( trim($_REQUEST['origen'])=='OTROS'  && strtoupper(trim($_REQUEST['otros']))=='GTPASION' ) ){
		 
		   $r=canvia_textos_codigo($_REQUEST['origen']);
		   /*
		if(trim($_REQUEST['codigo_localizador']=='')){$cad.='El '.$r['0'].' es obligatorio<br>'; $valida_codigos_aux=false; }
		   if(trim($_REQUEST['codigo_consumo']=='' && trim($_REQUEST['origen']!='DOOPLAN'))){$cad.='El '.$r['1'].' es obligatorio<br>'; $valida_codigos_aux=false; }
		 
		*/
		   if(!str_replace(' ','',$_REQUEST['codigo_localizador']) ){$cad.='El '.$r['0'].' es obligatorio<br>'; $valida_codigos_aux=false; }
		   //mts. 18/05. CÓDIGO ALFA.
		   if(!str_replace(' ','',$_REQUEST['codigo_consumo']) && trim($_REQUEST['origen'])!='DOOPLAN' and trim($_REQUEST['origen'])!='CODIGO_ALFA'  and $_REQUEST['origen']!='LA_TIENDA_MARCA'){$cad.='El '.$r['1'].' es obligatorio<br>'; $valida_codigos_aux=false; }
		 }
		 
		 if(trim($_REQUEST['origen']=='OTROS')){
		   if(trim($_REQUEST['otros']=='')){$cad.='Debe indicar otro origen<br>';  
		   }
		 }
		 $r='';
		 if($valida_codigos_aux && str_replace(' ','',$_REQUEST['origen']!='') )$r=valida_codigos();
	}  
	if($r)$cad.=$r;
    return ''.$cad.'';
}

function valida_formato_fecha_caducidad($fecha_caducidad)
{
    
   //return false;//return(is_numeric(substring($fecha_caducidad,1,2)));
    //return ((strtoupper($fecha_caducidad)=='CA' || strtoupper($fecha_caducidad)=='SI' || strtoupper($fecha_caducidad)=='SIN FECHA DE CADUCIDAD'  ) || is_numeric(substr($fecha_caducidad,0,2)) && is_numeric(substr($fecha_caducidad,3,2)) && is_numeric(substr($fecha_caducidad,6,4)) && substr($fecha_caducidad,2,1).substr($fecha_caducidad,5,1)=='//' && substr($fecha_caducidad,10)=='' ); 
	return (is_numeric(substr($fecha_caducidad,0,2)) && is_numeric(substr($fecha_caducidad,3,2)) && is_numeric(substr($fecha_caducidad,6,4)) && substr($fecha_caducidad,2,1).substr($fecha_caducidad,5,1)=='//' && substr($fecha_caducidad,10)=='' ); 
}
//mts 03102012. fecha de caducidad.
function valida_fecha_caducidad($fecha_caducidad,$fecha_escogida)
{
  $valoresPrimera = explode ("/", $fecha_caducidad);   
  $valoresSegunda = explode ("-", $fecha_escogida); 

  $diaPrimera    = $valoresPrimera[0];  
  $mesPrimera  = $valoresPrimera[1];  
  $anyoPrimera   = $valoresPrimera[2]; 


  $diaSegunda   = substr($valoresSegunda[2],0,2);  
  $mesSegunda = $valoresSegunda[1];  
  $anyoSegunda  = $valoresSegunda[0];

  //die($diaPrimera.'/'.$mesPrimera.'/'.$anyoPrimera.' - seg: '.$diaSegunda.'/'.$mesSegunda.'/'.$anyoSegunda)  ;

  //$diasPrimeraJuliano = gregoriantojd($mesPrimera, $diaPrimera, $anyoPrimera);  
  //$diasSegundaJuliano = gregoriantojd($mesSegunda, $diaSegunda, $anyoSegunda);     
    $diasPrimeraJuliano = mktime ( 9 , 0, 0 , $mesPrimera, $diaPrimera, $anyoPrimera ) ;
    $diasSegundaJuliano = mktime ( 9 , 0, 0 , $mesSegunda, $diaSegunda, $anyoSegunda ) ;
   // return false;
   //return($diaPrimera.'/'.$mesPrimera.'/'.$anyoPrimera.': '.$diasPrimeraJuliano.' --- '.$diaSegunda.'/'.$mesSegunda.'/'.$anyoSegunda.': '.$diasSegundaJuliano);


  if(!checkdate($mesPrimera, $diaPrimera, $anyoPrimera)){
    // "La fecha ".$primera." no es v&aacute;lida";
    return 0;
  }elseif(!checkdate($mesSegunda, $diaSegunda, $anyoSegunda)){
    // "La fecha ".$segunda." no es v&aacute;lida";
    return 0;
  }else{ 
    return  ($diasPrimeraJuliano - $diasSegundaJuliano>0);
  } 

}

//mts 27092012. funcíón booleana que devuelve "Verdadero" si no se han realizado ya 4 reservas en el mes de la reserva actual
// para la ip pasada como argumento (ip de la reserva actual).
function valida_ip($ip_arg)
{
    global $link;   
    $sql1='SELECT count(*) as nregs FROM events WHERE substring(data_reserva,1,7) = "'.date('Y-m').'" and INET_NTOA(ip)="'.$ip_arg.'"';
    $sql2='SELECT count(*) as nregs FROM eventsmadrid WHERE substring(data_reserva,1,7) = "'.date('Y-m').'" and INET_NTOA(ip)="'.$ip_arg.'"';
    $sql3='SELECT count(*) as nregs FROM eventsvalencia WHERE substring(data_reserva,1,7) = "'.date('Y-m').'" and INET_NTOA(ip)="'.$ip_arg.'"';
    $sql4='SELECT count(*) as nregs FROM eventsandalucia WHERE substring(data_reserva,1,7) = "'.date('Y-m').'" and INET_NTOA(ip)="'.$ip_arg.'"';
    
    $result1=mysql_query($sql1,$link); 
    $result2=mysql_query($sql2,$link); 
    $result3=mysql_query($sql3,$link); 
    $result4=mysql_query($sql4,$link); 
    
    $row1 = mysql_fetch_assoc($result1);
    $row2 = mysql_fetch_assoc($result2);
    $row3 = mysql_fetch_assoc($result3);
    $row4 = mysql_fetch_assoc($result4);

    //die($row1['nregs']);
        // die(ceil($row1['nregs'])+ceil($row2['nregs'])+ceil($row3['nregs'])+ceil($row4['nregs']));   
         //+intval($row2['nregs'])+intval($row3['nregs'])+intval($row4['nregs'])
    if (ceil($row1['nregs'])+ceil($row2['nregs'])+ceil($row3['nregs'])+ceil($row4['nregs'])>=4) return false;
    else return true;
 }

function valida_codigos()
   {
   	global $link;
	/* mts 25032012, se validarán los códigos sin importar el resto de datos, ni el piloto, ni el origen, ni nigún otro 
	// condicions permeses
	if(trim($_REQUEST['origen'])=='C.C' )return '';
    
	if(trim($_REQUEST['origen'])=='OFERTIX' )return '';
    
	if(trim($_REQUEST['origen'])=='OTROS'  && strtoupper(trim($_REQUEST['otros'] ) )=='GTPASION' )return '';
    
	// tickets
	if(substr(trim($_REQUEST['origen']),0,6)=='Ticket' && (substr(strtoupper(trim($_REQUEST['codigo_localizador'])),0,3)=='TIC' || substr(strtoupper(trim($_REQUEST['codigo_consumo'])),0,3)=='TIC'))return '';
    // condicions permeses fi
   
	$sql='SELECT * FROM events'.$_REQUEST['ciudad'].' WHERE (codi_localtzador like "'.trim(request('codigo_localizador')).'" OR codi_consum like "'.trim(request('codigo_consumo')).'")
	AND id_event NOT LIKE "2011-06-18%" 
	AND id_event NOT LIKE "2011-06-19%"
	AND id_event NOT LIKE "2011-07-17%"
	AND id_event NOT LIKE "2011-07-02%"
	AND id_event NOT LIKE "2011-08-21%" AND id_event NOT LIKE "2011-08-28%" 
	AND id_event NOT LIKE "2011-09-10%" AND id_event NOT LIKE "2011-09-11%" 
	AND id_event NOT LIKE "2011-11-26%" AND id_event NOT LIKE "2011-11-27%" 
	AND id_event NOT LIKE "2011-07-03%" 
	AND id_event NOT LIKE "2011-07-09%" 
	AND id_event NOT LIKE "2011-07-10%" 
	AND id_event NOT LIKE "2011-10-15%" 
	AND id_event NOT LIKE "2011-10-16%" '; // mirem quants en queden
	
	
	
	if($_REQUEST['ciudad']=='valencia'){ // solo en valencia
	$sql.=' 
	AND !(id_event LIKE "2011-10-22%" AND tipus_event LIKE "ferrari%" ) 
	AND !(id_event LIKE "2011-10-23%" AND tipus_event LIKE "ferrari%" ) ';	
		
	}
	
	
	
	// CASO DOOPLAN
	if(trim($_REQUEST['origen'])=='DOOPLAN' )$sql='SELECT * FROM events'.$_REQUEST['ciudad'].' WHERE (codi_localtzador="'.trim(request('codigo_localizador')).'" )';
	
	
	$r=canvia_textos_codigo($_REQUEST['origen']);
	
	$cadena_aux='El '.$r[0].' o el '.$r[1].' ya se encuentran registrados';
	if($r[1]==$r[0])$cadena_aux='El '.$r[0].' ya se encuentra registrado';
	
    */
	
    // mts 18/05
    // CASO TICKET DESCUENTO
    
    
    
    if (trim($_REQUEST['origen']) == 'Ticket Descuento' or trim($_REQUEST['origen']) == 'Ticket Especial' or strtoupper( request('codigo_localizador')) == 'A6TO6'  or strtoupper(request('codigo_localizador')) == 'OSCE895461') 
    return;
 
    // CASO DOOPLAN
    if(trim($_REQUEST['origen'])=='DOOPLAN' )
    {
        $sql='SELECT * FROM events'.$_REQUEST['ciudad'].' WHERE (codi_localtzador="'.trim(request('codigo_localizador')).'" )';
    }   
    //mts 18/05/2012.
    else if(trim($_REQUEST['origen'])=='CODIGO_ALFA' )
    {
        //$sql='SELECT * FROM events'.$_REQUEST['ciudad'].' WHERE (codi_localtzador="'.trim(request('codigo_localizador')).'" )';
        $sql = 'SELECT * FROM ps_cupones WHERE numero='.trim(request('codigo_localizador')).' and vendido = 1 ';
    }       
    //Validación para todos los casos (cualquier origen distinto de dooplan)
    else 
    {
       /* mts 13042012, modificación, se validará el código en todas las ciudades */     
        //$sql='SELECT * FROM events'.$_REQUEST['ciudad'].' WHERE (codi_localtzador="'.trim(request('codigo_localizador')).'" and codi_consum = "'.trim(request('codigo_consumo')).'")';
         $sql1='SELECT * FROM events WHERE (codi_localtzador="'.trim(request('codigo_localizador')).'" and codi_consum = "'.trim(request('codigo_consumo')).'")';
         $sql2='SELECT * FROM eventsmadrid WHERE (codi_localtzador="'.trim(request('codigo_localizador')).'" and codi_consum = "'.trim(request('codigo_consumo')).'")';
         $sql3='SELECT * FROM eventsvalencia WHERE (codi_localtzador="'.trim(request('codigo_localizador')).'" and codi_consum = "'.trim(request('codigo_consumo')).'")';
         $sql4='SELECT * FROM eventsandalucia WHERE (codi_localtzador="'.trim(request('codigo_localizador')).'" and codi_consum = "'.trim(request('codigo_consumo')).'")';
 
        /* fin modif. mts. */ 
    }


    $r=canvia_textos_codigo($_REQUEST['origen']);
    
    if (strtoupper( request('codigo_localizador')) == 'TEST15' )    
        return('Este cupón está caducado y por lo tanto no puede realizarse la reserva.');
    else{
        if (trim($_REQUEST['origen'])=='GROUPON')
           $cadena_aux='Introduza la letra A delante del código para realizar la reserva ';
        elseif (trim($_REQUEST['origen'])=='CODIGO_ALFA') 
           $cadena_aux = 'Debe activar el cupón antes de poder realizar la reserva';
        //mts 21052012
        elseif (trim($_REQUEST['origen'])=='Ticket descuento'){$cadena_aux='';} 
        else if(isset($_REQUEST['hccsportscars_reserva']))    
        {     
        $cadena_aux='El '.$r[0].' o el '.$r[1].' ya se encuentran registrados. Póngase en contacto a través del <a style="color:#fff" href="javascript:parent.location=\'https://www.hccsportcars.com/contact-form.php#contactform\'">formulario de contacto</a> para consultar la incidencia ';
        if($r[1]==$r[0])$cadena_aux='El '.$r[0].' ya se encuentra registrado.Póngase en contacto a través del <a style="color:#fff" href="javascript:parent.location=\'https://www.hccsportcars.com/contact-form.php#contactform\'">formulario de contacto</a> para consultar la incidencia ';   
        }
        else if(isset($_REQUEST['dreamcars_reserva']))
        {
        $cadena_aux='El '.$r[0].' o el '.$r[1].' ya se encuentran registrados. Póngase en contacto a través del <a style="color:#fff" href="https://www.dreamcarsexperience.com/contact-form.php#contactform">formulario de contacto</a> para consultar la incidencia ';
        if($r[1]==$r[0])$cadena_aux='El '.$r[0].' ya se encuentra registrado. Póngase en contacto a través del <a style="color:#fff" href="https://www.dreamcarsexperience.com/contact-form.php#contactform">formulario de contacto</a> para consultar la incidencia ';  
        }
        else 
        {
        $cadena_aux='El '.$r[0].' o el '.$r[1].' ya se encuentran registrados. Póngase en contacto a través del <a style="color:#fff" href="https://www.motorclubexperience.com/contact-form.php#contactform">formulario de contacto</a> para consultar la incidencia ';
        if($r[1]==$r[0])$cadena_aux='El '.$r[0].' ya se encuentra registrado. Póngase en contacto a través del <a style="color:#fff" href="https://www.motorclubexperience.com/contact-form.php#contactform">formulario de contacto</a> para consultar la incidencia ';         
        }    
    }

	/* fin modif mts */
	
	
	/* mts 13042012, modif. consulta códigos de localizador para que los compruebe en todas las ciudades y no
     * unicamente en la ciudad seleccionada 
	$result=mysql_query($sql,$link); 
	
	if(mysql_num_rows($result)!=0){ 
	  return $cadena_aux;
	}// si no hi ha cap inscrit
   //return $sql;
   */

   
    if(trim($_REQUEST['origen'])=='DOOPLAN' )
    {
    $result=mysql_query($sql,$link); 
    
    if(mysql_num_rows($result)!=0){ 
      return $cadena_aux;
     }// si no hi ha cap inscrit
        
    }
    //mts 18052012.
    else if (trim($_REQUEST['origen']) == 'CODIGO_ALFA')
    {
    $result=mysql_query($sql,$link); 
    
    if(mysql_num_rows($result)==0){ 
      return $cadena_aux;
     }
    } 
    else{
    $result1=mysql_query($sql1,$link); 
    $result2=mysql_query($sql2,$link); 
    $result3=mysql_query($sql3,$link); 
    $result4=mysql_query($sql4,$link); 
        
    if(mysql_num_rows($result1)!=0 or mysql_num_rows($result2)!=0  or mysql_num_rows($result3)!=0 or mysql_num_rows($result4)!=0 ){ 
      return $cadena_aux;
     }// si no hi ha cap inscrit
   //return $sql;
    }
   
     /* fin modif. mts 13042012 */ 
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
  
function request($c)
   {return mysql_real_escape_string(strip_tags($_REQUEST[$c]));}


  

  
function return_tipus_e($t)
  {
  switch($t)
  {
   case 'ferrari':
   	    /*if ($_REQUEST['ciudad']=='madrid' || $_REQUEST['ciudad']=='andalucia')
   	    return 'Ferrari 360 20 Km   ';
		else {*/
   	    return 'Ferrari 430 20 Km   ';
		//}
   break;		
   //Bautismos. 
   case '_bferrari_':
        /*if ($_REQUEST['ciudad']=='madrid' || $_REQUEST['ciudad']=='andalucia')
        return 'Ferrari 360 7 Km   ';
        else {*/
        return 'Ferrari 430 7 Km   ';
        //}
   break;       

   case '_blamborghini_':
         return 'Lamborghini 7 Km';
   break;       
   case '_bporsche_':
         return 'Porche 7 Km';
   break;       
   //Fin Bautismos
   case 'ferrari_porsche901':
   	    return 'Ferrari  20 Km  + Porsche  20 Km   ';
   break;	
   case 'lamborghini':
         return 'Lamborghini 20 Km';
   break;		
   case 'lamborghini_lotus':
         //return 'Lamborghini 20 Km  + Lotus Evora 20 Km ';
   return 'Lamborghini 20 Km  + Porsche 20 Km ';
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
		return 'Porsche 20Km ';		 
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
  
  

function envia_mails()
  {
  	   
include 'class.phpmailer.php';
include 'textos_mensajes.php';
    $tipus=request('tipus');
    $aux=explode('@',request('id_alta'));
	if($tipus!='porsche997' && $tipus!='porsche996' && $tipus!='_bferrari_' && $tipus!='_blamborghini_')
	  {
    	  $h=explode(':',$aux[1]);
    	  if($h[1]=='00' || $h[1]=='15'){
    		$aux[1]=$h[0].':00:00';
    	  }
    	  else if($h[1]=='30' || $h[1]=='45'){
    	    $aux[1]=$h[0].':30:00';
    	  }
      }
      else if ($tipus=='_bferrari_' || $tipus=='_blamborghini_')
      {   echo($tipus);
          $h=explode(':',$aux[1]);
          for($i=0;$i<=45;$i+=15)
          {
              echo('h1 :'.$h[1]);
              echo('i: '.$i);
            if((int)$h[1]==$i || (int)$h[1]==$i+7){$aux[1]=$h[0].':'.(($i>9)?$i:'0'.$i).':00';}
          }
      }  

	
	
	
	$mail = new PHPMailer();

    $mail->Host = "localhost";
	
 if(isset($_REQUEST['hccsportscars_reserva'])){
 	$mail->From = "info@hccsportcars.com";
    $mail->FromName = "hccsportcars.com";
    $mail->Subject = 'hccsportcars.com';
 }else if(isset($_REQUEST['dreamcars_reserva'])){
 	$mail->From = "info@dreamcarsexperience.com";
    $mail->FromName = "dreamcarsexperience.com";
    $mail->Subject = 'dreamcarsexperience.com';
 }else{
 	$mail->From = "info@motorclubexperience.com";
    $mail->FromName = "Motorclubexperience";
    $mail->Subject = 'Motorclubexperience';
	}

    //$mail->AddAddress("motorclubexperience@hotmail.com");
   
    
	//$mail->AddAddress(request('email_regala'));
	$mail->AddAddress(request('email1'));
    $mail->AddBCC("motorclubexperience@hotmail.com","oculto");
    if(isset($_REQUEST['hccsportscars_reserva']))
	  $mail->AddBCC("info@hccsportcars.com","oculto");
   
	$body='';
    if(isset($_REQUEST['hccsportscars_reserva']))
	     $body= texto_reserva_hccsportscar();
	else if(isset($_REQUEST['dreamcars_reserva']))
	     $body= texto_reserva_dreamcars();
    else $body= texto_reserva();

	
	$aux_ciudad=$_REQUEST['ciudad'];
	if(trim($aux_ciudad)=='')$aux_ciudad='Barcelona';
	$aux_ciudad=strtoupper($aux_ciudad );
	
	$body.= "<strong>Su reserva ha sido realizada con los siguientes datos</strong><br><br>";  
    //mts 27092012
    $body.= "<strong>Fecha Reserva: </strong>".request('data_reserva').'<br>';
    $body.= "<strong> Direcci&oacute;n IP: </strong>".request('ip').'<br>';
	//fin modif mts 27092012
	$body.= "<strong>Nombre piloto: </strong>".convert_caracters_hex(request('pilot')).'<br>';
	$body.= "<strong>Apellidos piloto: </strong>".convert_caracters_hex(request('apellidos_piloto')).'<br>';
	
	$body.= "<strong>Email piloto: </strong>".request('email').'<br>';
	$body.= "<strong>Tel&eacute;fono piloto: </strong>".request('telefon').'<br>';

	$body.= "<strong>Origen: </strong>".request('origen').'<br>';
	
	$body.= "<strong>Dia: </strong>".$aux[0].'<br>';
	$body.= "<strong>Hora: </strong>".$aux[1].'<br>';
  $body.= "<strong>Evento: </strong>".return_tipus_e(request('tipus')).'<br>';
	$body.= "<strong>Nombre de la persona que regala: </strong>".convert_caracters_hex(request('persona_regala')).'<br>';
	$body.= "<strong>Apellidos de la persona que regala: </strong>".convert_caracters_hex(request('apellidos_persona_regala')).'<br>';
	$body.= "<strong>DNI persona que regala: </strong>".convert_caracters_hex(request('nif')).'<br>';
	$body.= "<strong>Email persona que regala: </strong>".request('email_regala').'<br>';
	$body.= "<strong>M&oacute;vil persona que regala: </strong>".request('telefon_regala').'<br>';
	$textos_codigos = canvia_textos_codigo(request('origen'));
	$body.= "<strong>".utf8_decode($textos_codigos[0]).": </strong>".request('codigo_localizador').'<br>';
	if (!in_array(request('origen'),array('CODIGO_ALFA','DOOPLAN','LA_TIENDA_MARCA'))) 
		$body.= "<strong>".utf8_decode($textos_codigos[1]).": </strong>".request('codigo_consumo').'<br>';
	//$body.= "<strong>C&oacute;digo localizador: </strong>".request('codigo_localizador').'<br>';
	//$body.= "<strong>C&oacute;digo consumo: </strong>".request('codigo_consumo').'<br>';
	$body.= "<strong>Ciudad: </strong>".$aux_ciudad.'<br>';
	$body.= "<strong>Observaciones: </strong>".convert_caracters_hex(request('Observaciones')).'<br>';
  
  $body.=direcciones_eventos();
	
  // echo $body;
   
    $mail->Body = $body;

    $mail->IsHTML(true);

    $mail->Send();
echo 'OK';

  }  
  

  
function envia_oferta_mails()
  {  	   
	include 'class.phpmailer.php';
	include 'textos_mensajes.php';
    $tipus=request('tipus');
    $aux=explode('@',request('id_alta'));
	if($tipus!='porsche997' && $tipus!='porsche996' && $tipus!='_bferrari_' && $tipus!='_blamborghini_')      
	  {
    	  $h=explode(':',$aux[1]);
    	  if($h[1]=='00' || $h[1]=='15'){
    		$aux[1]=$h[0].':00:00';
    	  }
    	  else if($h[1]=='30' || $h[1]=='45'){
    	    $aux[1]=$h[0].':30:00';
    	  }
      }
      else if ($tipus=='_bferrari_' || $tipus=='_blamborghini_')
      {   echo($tipus);
          $h=explode(':',$aux[1]);
          for($i=0;$i<=45;$i+=15)
          {
              echo('h1 :'.$h[1]);
              echo('i: '.$i);
            if((int)$h[1]==$i || (int)$h[1]==$i+7){$aux[1]=$h[0].':'.(($i>9)?$i:'0'.$i).':00';}
          }
      }  

	
	
	
	$mail = new PHPMailer();

    $mail->Host = "localhost";
	
 if(isset($_REQUEST['hccsportscars_reserva'])){
	$url_base='www.hccsportcars.com';
 	$mail->From = "info@hccsportcars.com";
    $mail->FromName = "hccsportcars.com";
    $mail->Subject = 'hccsportcars.com';
 }else if(isset($_REQUEST['dreamcars_reserva'])){
	$url_base='www.dreamcarsexperience.com';
 	$mail->From = "info@dreamcarsexperience.com";
    $mail->FromName = "dreamcarsexperience.com";
    $mail->Subject = 'dreamcarsexperience.com';
 }else{
	$url_base='www.motorclubexperience.com';
 	$mail->From = "info@motorclubexperience.com";
    $mail->FromName = "Motorclubexperience";
    $mail->Subject = 'Motorclubexperience';
	}

    //$mail->AddAddress("motorclubexperience@hotmail.com");
   
    
	//$mail->AddAddress(request('email_regala'));
	$mail->AddAddress(request('email1'));
   /* $mail->AddBCC("motorclubexperience@hotmail.com","oculto");
    if(isset($_REQUEST['hccsportscars_reserva']))
	  $mail->AddBCC("info@hccsportcars.com","oculto");
   */
	$body='';
    
	/*
	if(isset($_REQUEST['hccsportscars_reserva']))
	     $body= texto_reserva_hccsportscar();
	else if(isset($_REQUEST['dreamcars_reserva']))
	     $body= texto_reserva_dreamcars();
    else $body= texto_reserva();
	*/
	
	
	$aux_ciudad=$_REQUEST['ciudad'];


	if(trim($aux_ciudad)=='')$aux_ciudad='Barcelona';
	$aux_ciudad=strtoupper($aux_ciudad );
	$url_base=$url_base.'/detalle-oferta';
    //mts 27092012
	switch($aux_ciudad)
	{
		case '':
				$body = body_email_oferta($aux_ciudad,0);
				//$link=$url_base.'/48-0-oferta.html';	
		break;
		case 'madrid':
				$body = body_email_oferta($aux_ciudad,26);
				//$link=$url_base.'/48-0-oferta.html';	
		break;
		case 'cantabria':
				$body = body_email_oferta($aux_ciudad,46);
		break;
		case 'andalucia':
				$body = body_email_oferta($aux_ciudad,25);
		break;
		case 'valencia':
				$body = body_email_oferta($aux_ciudad,35);
		break;
	}
	$body.= "<strong>Oferta:</strong><br><br>";  

   
    $mail->Body = $body;

    $mail->IsHTML(true);

    $mail->Send();
echo 'OK';

  }  
  
  
function body_email_oferta($ciudad,$idOferta)
{
	$oferta = new Oferta_($idOferta);
	
	$body.= ' <ul id="oferta_list" class="clear" style="margin-top:0px;padding-left:0px;">';
	$body.='<div class="div_oferta" style="border:0px #fff solid;background: url(\'../../../img/fondo_lista_ofertas.png\') repeat-x;">';
	$body.='	<div class="ajax_block_oferta first_item clearfix">';
	$body.='		<div class="center_block">';

	$pathim = "/img/oh/";
	$nombref = $URL_ROOT.$pathim.$oferta->id.'-'.$oferta->idImagenPortada.'.jpg';
	list($heightim,$widthim) = getImageSize($nombref);   
	/*{capture name="heightim"}{getImSizeHeight image=$nombref maxw=284 maxh=258}{/capture}*/

	
	if ($heightim>$widthim} 
		$heightim=258;	
	if ($heightim<$widthim) 
		$widthim=284;	
	/*{$oferta->titulo|escape:'htmlall':'UTF-8'}*/
	
	$body.='<div style="line-height:258px;height:258px;width:284px;display:block;vertical-align:middle;float:left;border:solid 1px;background-color:#000000;box-sizing: border-box;-moz-box-sizing: border-box;-ms-box-sizing: border-box;-webkit-box-sizing: border-box;" title="'.$oferta->titulo.'">';
	$body.='					<img style="vertical-align:middle;" src="'.$URL_ROOT.'/img/oh/'.$oferta->id.'-'.$oferta->idImagenPortada.'.jpg'.'" alt="'.$oferta->titulo.'" height="'.$heightim.'" width="'.$heightim.'"/><span style="font-size:1px;" width="1px">&nbsp;</span>';
	$body.='			  	</div>';
	$body.='				<div style="float:left;width:614px;padding:0 0 0 20px;padding-top:0;">   ';
    $body.='						<div style="float:left;width:373px;padding-right:10px;box-sizing: border-box;-moz-box-sizing: border-box;-ms-box-sizing: border-box;-webkit-box-sizing: border-box;">';
	$body.='					    <div style="height:170px;overflow:hidden;">	';
	$body.='							<div class="oferta_desc">';
	$body.='								<h3 class="oferta_desc" style="max-height:94px;overflow:hidden;margin:5px 0 8px;font-size:17px;">';
	$body.=										$oferta->titulo;
	$body.='								</h3>';
	$body.='							</div>';
	$body.='							<div id="resumen">';
	$body.='								<p class="oferta_desc">';
	$body.=										$oferta->subtitulo;
	$body.='								</p>';
	$body.='							</div>';
	$body.='						</div>';
	$body.='						<div id="tiempo_limite_'.$oferta->id.'" class="tiempo_lista">';
	$body.='						</div>';
	$body.='					</div>';
	$body.='					<div style="float:right;width:231px;height:238px;float:left;padding-top:20px;box-sizing: border-box;-moz-box-sizing: border-box;-ms-box-sizing: border-box;-webkit-box-sizing: border-box;">';
	$body.='						<div style=\'background:url("'.$URL_ROOT.'img/precios_reducido.png'.'") no-repeat scroll left top transparent;height:100px;padding-bottom:50px;\'>';
	$body.='							<div id="precio" class="precio_lista" style="padding-left:2px;">';
	$body.=									$oferta->precioValor.'€';
	$body.='							</div>';
	$body.='							<div id="descuento" class="precio_lista">'.$oferta->descuento.'%';
	$body.='							</div>';
	$body.='							<div id="ahorro" class="precio_lista">';
	$body.=									$oferta->ahorro.'€';
	$body.='							</div>';
	$body.='						</div>';

	$body.='						<div style=\'background:url("'.$URL_ROOT.'img/boton_oferta.png'.'") no-repeat scroll left top transparent;height:100px;padding-top:13px;margin-left:0 !important;\' id="precio2" class="precio_lista" style="font-size:18px;padding-top:34px;margin-left:14px;width:168px;">';
	$body.=									$oferta->precioFinal.'€';
	$body.='						</div>';
							/* |truncate:360:'...'|strip_tags:'UTF-8'|escape:'htmlall':'UTF-8'} */	
	$body.='						<a style="float:left;width:136px;margin-left:6px;" href="'.$URL_ROOT.'detalle-oferta/'.$oferta->id.'-0-oferta.html'.'" title="'.$oferta->destacados.'"><img  src="'.$URL_ROOT.'/img/ver_oferta.png" alt="" /></a>';
	$body.='					</div>			';
								
	$body.='					<div style="float:right;margin-top:14px;">';
	$body.='					</div>';
	$body.='				</div>';
	/*final center block*/
	$body.='		</div>  	';	
	
	/*final div ajax_block_oferta*/
	$body.='	</div>   ';
	$body.='</div> 	';

	$cont = $cont+1;
	if ( $cont == 2)
			$cont=0;
	$body.='</ul>';
	
	$body.='<style>
		h3.oferta_desc {
	    color: #FFFFFF;
	    font-size: 18px;
	    margin-left: 0;
	}
	div#resumen p {
    color: #FFFFFF;
    font-size: 15px;
    margin-bottom: 30px;
	}
	</style>
	';
	
	//Ofertas list
	$body.='	<style>
		html {border:none;background-color:#000000;}
		body {background-color:#000000;}
		</style>';

		
	return $body;	
	}  
  
  
  
/*

function envia_mails()
  {
  	   
include 'class.phpmailer.php';

    $aux=explode('@',request('id_alta'));
		
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
	
	
	
	$mail = new PHPMailer();

    $mail->Host = "localhost";

    $mail->From = "info@motorclubexperience.com";

    $mail->FromName = "Motorclubexperience";

    $mail->Subject = 'Motorclubexperience';
	

    $mail->AddAddress("motorclubexperience@hotmail.com");
   
    
	//$mail->AddAddress(request('email_regala'));
	$mail->AddAddress(request('email1'));
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
	
  // echo $body;
   
    $mail->Body = $body;

    $mail->IsHTML(true);

    $mail->Send();
echo 'OK';

  }
*/

function nombre_hotel($h)
{
  	switch($h){
        case '99999': //test            
		return "test";
        break;
        case '4949': //hotel ciutat d'igualada
            return "Ciutat Igualada";
        break;
        case '3939': //hotel ciutat d'igualada
            return "Hotel Don Gonzalo";
        break;   
		case '12345'://hotel vejo
			return "Hotel Vejo";			
		break;
        case '1000':
			
			return "Hotel América";
		break;
        case '2929':
            
            return "Hotel Juaneca";
        break;
	    case '1111':
			
			return "Hotel Sara De Ur";
		break;
		case '2011':
			
			return "Hotel Ciutat Igualada";
		break;
		case '2030':
			return "Hotel la Carreta";
		break;
        case '0010':
            return "Hotel Husa Masia Bach";
            break;
        default:
		   
		   return "Motor Club Experience";
		break;
		}
}

function email_hotel($h)
   {
   	switch($h){
        case '99999': //test            
		return "marctorraso@gmail.com";
        break;
        case '4949': //hotel ciutat d'igualada
            return "reservasciutatigualada@dormicumhotels.com";
        break;
        case '3939': //hotel ciutat d'igualada
            return "gestion@hoteldongonzalo.com";
        break;   
		case '12345'://hotel vejo
			return "reservas@hotelvejo.es";			
			//return "marctorraso@gmail.com";			
		break;
        case '1000':
			
			return "info@hotel-america.es";
		break;
        case '2929':
            
            return "recepcion@hoteljuaneca.es";
        break;
	    case '1111':
			
			return "info@saradeur.com";
		break;
		case '2011':
			
			return "recepcion@hotelciutatigualada.com";
		break;
		case '2030':
			return "reservas@hotel-lacarreta.com";
		break;
        case '0010':
            return "reservas@hotelhusamasiabach.es";
            break;
        case '6666':
            return "reservas@hotelvejo.es";
            break;
        default:
		   
		   return "motorclubexperience@hotmail.com";
		break;
	}
	
   }



function envia_mails_hotel()
  {
  	   
include 'class.phpmailer.php';
include 'textos_mensajes.php';
    
    $tipus = request('tipus');

    $aux=explode('@',request('id_alta'));
		
	if($tipus!='porsche997' && $tipus!='porsche996' && $tipus!='_bferrari_' && $tipus!='_blamborghini_')
	  {
    	  $h=explode(':',$aux[1]);
    	  if($h[1]=='00' || $h[1]=='15'){
    		$aux[1]=$h[0].':00:00';
    	  }
    	  else if($h[1]=='30' || $h[1]=='45'){
    	    $aux[1]=$h[0].':30:00';
    	  }
      }
      else if ($tipus=='_bferrari_' || $tipus=='_blamborghini_')
      {   echo($tipus);
          $h=explode(':',$aux[1]);
          for($i=0;$i<=45;$i+=15)
          {
              echo('h1 :'.$h[1]);
              echo('i: '.$i);
            if((int)$h[1]==$i || (int)$h[1]==$i+7){$aux[1]=$h[0].':'.(($i>9)?$i:'0'.$i).':00';}
          }
      }  
	
	
	
	$mail = new PHPMailer();

    $mail->Host = "localhost";

    /****/

	if(isset($_REQUEST['hccsportscars_reserva'])){
		$mail->From = "info@hccsportcars.com";
		$mail->FromName = "hccsportcars.com";
		$mail->Subject = 'hccsportcars.com';
	 }else if(isset($_REQUEST['dreamcars_reserva'])){
		$mail->From = "info@dreamcarsexperience.com";
		$mail->FromName = "dreamcarsexperience.com";
		$mail->Subject = 'dreamcarsexperience.com';
	 }else{
		$mail->From = "info@motorclubexperience.com";
		$mail->FromName = "Motorclubexperience";
		$mail->Subject = 'Motorclubexperience';
		}
	
	/****/
	
	
//    $mail->From = "info@motorclubexperience.com";

//    $mail->FromName = "Motorclubexperience";

//    $mail->Subject = 'Motorclubexperience';
	

    $mail->AddBCC("motorclubexperience@hotmail.com","oculto");
   
   
	$mail->AddBCC(request('email1'),"oculto");
	
	
	$mail->AddBCC(email_hotel(str_replace(' ','',$_REQUEST['id_hotel'])  ),"oculto");

    
    $body= texto_reserva_hotel();
    
 
	
	$aux_ciudad=$_REQUEST['ciudad'];
	if(trim($aux_ciudad)=='')$aux_ciudad='Barcelona';
	$aux_ciudad=strtoupper($aux_ciudad );
	
	$body.= "<strong>Su reserva ha sido realizada con los siguientes datos</strong><br><br>";
    $body.= "<strong>Fecha Reserva: </strong>".request('data_reserva').'<br>';
    $body.= "<strong> Direcci&oacute;n IP: </strong>".request('ip').'<br>';	
	$body.= "<strong>Nombre piloto: </strong>".convert_caracters_hex(request('pilot')).'<br>';
	$body.= "<strong>Apellidos piloto: </strong>".convert_caracters_hex(request('apellidos_piloto')).'<br>';
	$body.= "<strong>Email piloto: </strong>".request('email').'<br>';
	$body.= "<strong>Tel&eacute;fono piloto: </strong>".request('telefon').'<br>';
	$body.= "<strong>Origen: </strong>".str_replace('_',' ',request('origen')).'<br>';

	$body.= "<strong>Hotel: </strong>".nombre_hotel($_REQUEST['id_hotel']).'<br>';
	
	if(trim(request('alojamiento_ad'))=='') $alojamiento='';        
	else if (request('alojamiento_ad')=='0') $alojamiento = 'Alojamiento + Desayuno';
	else $alojamiento = 'Media Pensi&oacute;n';
	
	$body.= "<strong>Alojamiento: </strong>".$alojamiento.'<br>';
	//if (trim(request('fechaentrada'))!='') $body.= "<strong>Fecha de entrada: </strong>".request('fechaentrada')."<br>";
	//if (trim(request('fechasalida'))!='') $body.= "<strong>Fecha de salida: </strong>".request('fechasalida')."<br>";
 
	if (trim(request('fechaentrada'))!='') $body.= "<strong>Fecha de entrada: </strong>".request('fechaentrada')."<br>";
	if (trim(request('fechasalida'))!='') $body.= "<strong>Fecha de salida: </strong>".request('fechasalida')."<br>";
	
	if (request('es_spa')==='1') $body.= "<strong>Este vale dispone de SPA</strong><br>";
	if (trim(request('persona_hotel'))!='') $body.= "<strong>Personal del hotel que realiz&oacute; la reserva: </strong>".utf8_decode(request('persona_hotel'))."<br>";

	$body.= "<strong>Dia: </strong>".$aux[0].'<br>';
	$body.= "<strong>Hora: </strong>".$aux[1].'<br>';
    $body.= "<strong>Evento: </strong>".return_tipus_e(request('tipus')).'<br>';
	$body.= "<strong>Nombre de la persona que regala: </strong>".convert_caracters_hex(request('persona_regala')).'<br>';
	$body.= "<strong>Apellidos de la persona que regala: </strong>".convert_caracters_hex(request('apellidos_persona_regala')).'<br>';
	$body.= "<strong>DNI persona que regala: </strong>".convert_caracters_hex(request('nif')).'<br>';
	$body.= "<strong>Email persona que regala: </strong>".request('email_regala').'<br>';
	$body.= "<strong>M&oacute;vil persona que regala: </strong>".request('telefon_regala').'<br>';
	$textos_codigos = canvia_textos_codigo(request('origen'));
	$body.= "<strong>".utf8_decode($textos_codigos[0]).": </strong>".request('codigo_localizador').'<br>';
	if (!in_array(request('origen'),array('CODIGO_ALFA','DOOPLAN','LA_TIENDA_MARCA'))) 
		$body.= "<strong>".utf8_decode($textos_codigos[1]).": </strong>".request('codigo_consumo').'<br>';

	//$body.= "<strong>C&oacute;digo localizador: </strong>".request('codigo_localizador').'<br>';
	//$body.= "<strong>C&oacute;digo consumo: </strong>".request('codigo_consumo').'<br>';
	$body.= "<strong>Ciudad: </strong>".$aux_ciudad.'<br>';
	$body.= "<strong>Observaciones: </strong>".convert_caracters_hex(request('Observaciones')).'<br>';
	
  // echo $body;
   
    $mail->Body = $body;

    $mail->IsHTML(true);

    $mail->Send();
    echo 'OK';

  }  
   
 function GetUserIp_()
    {
      
       $ip = "";
       if(isset($_SERVER)) {
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) 
          {
             $ip=$_SERVER['HTTP_CLIENT_IP'];
          } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
             $ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
          } else {
             $ip=$_SERVER['REMOTE_ADDR'];
          }
       } else {
         if ( getenv( 'HTTP_CLIENT_IP' ) ) {
           $ip = getenv( 'HTTP_CLIENT_IP' );
         } elseif ( getenv( 'HTTP_X_FORWARDED_FOR' ) ) {
           $ip = getenv( 'HTTP_X_FORWARDED_FOR' );
         } else {
           $ip = getenv( 'REMOTE_ADDR' );
      }
  } 
   // En algunos casos muy raros la ip es devuelta repetida dos veces separada por coma 
   if(strstr($ip,','))
    {
      $ip = array_shift(explode(',',$ip));
    }
   return $ip;
  } 
   
   
?>
