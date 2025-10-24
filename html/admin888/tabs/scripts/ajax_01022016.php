<?php  
include_once(dirname(__FILE__).'/../../../config/config.inc.php');
include_once('config_events.php'); 
include_once 'functions.php';
//include_once('../../../classes/OfertaHistorico.php');
//include_once('../../../classes/FuncionesSeguridad.php');

require_once ( '../../../html2pdf/html2pdf.class.php');
include_once('../../../scripts/funciones_codigos.php');
include_once('../../../scripts/ip_functions.php');
//include_once('trazas.php');

  
 
function traza_a($fichero,$texto)
{
    file_put_contents($fichero, "[".date("r")."] : $texto".PHP_EOL, FILE_APPEND | LOCK_EX); 
} 

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
    
    if($_REQUEST['tipus']=='porsche996')
	{
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
	
	$ip=GetUserIp_();
    $sql='INSERT INTO `events'.$_REQUEST['ciudad'].'` (id_event,ocupa,pilot,tipus_event'.$cad_plaza[0].',ip) VALUES("'.$_REQUEST['ocupa'].'","555","no disponible","'.$_REQUEST['tipus'].'"'.$cad_plaza[1].',INET_ATON("'.$ip.'"))';
    //die('error '.$sql);

	$result=mysql_query($sql,$link)  or die('error '.mysql_error());
    echo 'OK'; 
}

if(isset($_REQUEST['ocupat']))
{
    
    
    //Marcamos ocupados maÃƒÂ±ana.
    // 1 sol cotxe
    $dia_sel=$_REQUEST['dia_selec'];
    if (in_array($_REQUEST['periodo'],array('m','mt')))
    {
		// 1 sol cotxe
		
		$cad_plaza[0]='';
		$cad_plaza[1]='';
		
		//$hores=explode('#',trim(file_get_contents('mati.js')));
		$hores=array();
		$hores1=seleccionar_plantilla_graella($_REQUEST['tipus']);
		foreach($hores1 as $h1=>$v1)
		{
			//echo($h1);
			if ($h1!='' and $h1!='c')
			{
				$hores[]=$dia_sel.'@'.$h1;
			}
			else if ($h1=='c')
			{
				break;
			}
		}
		
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
			$ip=GetUserIp_();
			$sql='INSERT INTO `events'.$_REQUEST['ciudad'].'` (id_event,ocupa,pilot,tipus_event'.$cad_plaza[0].',ip) VALUES("'.$v.'","556","no disponible","'.$_REQUEST['tipus'].'"'.$cad_plaza[1].',INET_ATON("'.$ip.'"))';
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
		
		//$hores=explode('#',trim(file_get_contents('tarda.js')));
		$hores=array();
		$hores1=seleccionar_plantilla_graella($_REQUEST['tipus']);
		
				
		$btarde=false;  
		foreach($hores1 as $h1=>$v1)
		{
			if ($btarde) 
			{
				if (trim($h1)!='')         
				{
					$hores[]=$dia_sel.'@'.$h1;   
				}
			}
			else 
			{
				if ($h1=='c')
				{
					$btarde=true;   
				}
				continue;
			}

		}		
		
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
			$ip=GetUserIp_();
			$sql='INSERT INTO `events'.$_REQUEST['ciudad'].'` (id_event,ocupa,pilot,tipus_event'.$cad_plaza[0].',ip) VALUES("'.$v.'","556","no disponible","'.$_REQUEST['tipus'].'"'.$cad_plaza[1].',INET_ATON("'.$ip.'"))';
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
    $id_event = $_REQUEST['id_alta'];   
    //$aux=explode('@',request('id_alta'));
    if (strpos($_REQUEST['ciudad'],'rutas_turisticas')!==false)     
    {
    	
    	$duplicar=false;
    	$id_event_ini = '';
    	$sql = ' SELECT * FROM events'.$_REQUEST['ciudad'].' where  id="'.request('id_inscrit').'"';
		$result=mysql_query($sql,$link)  or die('error'.mysql_error());
    	$r=mysql_fetch_assoc($result);
    	
    	if ($r) 
    	{
    		$reserva_a_duplicar=$r;
    		$id_event = $r['id_event'];
    		$id_event_ini = $r['id_event_ini'];
    		$plazas = plazas(request('tipus'));
    		
			//if ($plazas>1) 
			//$duplicar=true;       
    	}
		
    

		//Si estamos modificando los datos de una reserva para la que ya se duplicaron los datos segÃºn
		//el nÃºmero de plazas, actualizaremos todas las reservas asociadas con dichos datos.
		if(trim($id_event_ini)!='') //id_event_ini guardarÃ¡ el identificador de la reserva con la hora
									//inicial, de entre las que fueron duplicadas para un determinado nÃºmero de plazas.
		{
			$sql='UPDATE `events'.$_REQUEST['ciudad'].
			'` SET  email="'.request('email').'",
					tipus_event = "'.request('tipus').'",
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
					plazas ="'.$plazas.'"	
			 Where id_event_ini="'.$id_event_ini.'"';
		
			 $result=mysql_query($sql,$link)  or die('error'.mysql_error());    			
		}										     
		//Si la reserva se acaba de dar de alta y estamos modificando sus datos,
		//los actualizaremos para la hora seleccionada, y crearemos tantas reservas
		//idÃ©nticas como plazas estÃ©n asignadas al tipo de ruta turÃ­stica.
		else 										     
		{
			$sql='UPDATE `events'.$_REQUEST['ciudad'].
			'` SET  email="'.request('email').'",
					tipus_event = "'.request('tipus').'",
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
			 if ($result)
			 {
				$sql = ' SELECT * FROM events'.$_REQUEST['ciudad'].' where  id="'.request('id_inscrit').'"';
				$insertado=mysql_query($sql,$link)  or die('error'.mysql_error());
				$rinsertado=mysql_fetch_assoc($insertado);
				
				if ($rinsertado) 
				{
					$reserva_a_duplicar=$rinsertado;
				}
				else $reserva_a_duplicar=array();
			}
			 
			 duplicado_reservas_turisticas($id_event,$plazas,$reserva_a_duplicar);		
		}     		
   	}
    else 
    {
    	
		
    	$sql1 = ' SELECT * FROM events'.$_REQUEST['ciudad'].' where  id="'.request('id_inscrit').'"';
		$result1=mysql_query($sql1,$link)  or die('error'.mysql_error());
    	$r1=mysql_fetch_assoc($result1);
		
		if(strpos(strtoupper($r1['Observaciones']),'HCCSPORTSCAR')!==false) 	$empresa = 'Hccsportcars';               
		else if(strpos(strtoupper($r1['Observaciones']),'DREAMCARS')!==false)  $empresa = 'Dreamcarsexperience';     
		else $empresa = 'Motorclubexperience';                            

		
    	
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
				codi_localtzador ="'.request('codigo_localizador').'",
				codi_consum ="'.request('codigo_consumo').'",
				Observaciones ="'.request('Observaciones').'",
				origen ="'.request('origen').'",
				email_confirm ="'.request('email1').'",
				plazas ="'.plazas($_REQUEST['tipus']).'"	        
	     Where id="'.request('id_inscrit').'"';
	 
		 $result=mysql_query($sql,$link)  or die('error'.mysql_error().' '.$sql);              
		 $fnac=request('fecha_nacimiento');
		 
         //$fecha_nacimiento = substr($fnac,6,4).'-'.substr($fnac,3,2).'-'.substr($fnac,0,2);
         $fecha_nacimiento=implode('-',array_reverse(explode('/',$fnac)));
              
    
   //$fecha_nacimiento=date('Y-m-d H:i:s');                                         
   $fecha_alta = date('Y-m-d H:i:s');                                                 
   
   //traza('registro.txt','fa: '.$fecha_alta.' - fn: '.$fecha_nacimiento);
   $usuario = new Usuario();                  
           
   
   if (!$usuario->get(NULL,request('email_regala')))                              
   {   
		$usuario->id = 0;                                                                                                       
		$usuario->email = request('email_regala');               
		$usuario->nombre = request('persona_regala');
		$usuario->apellidos = request('apellidos_persona_regala');                                                                   
		$usuario->fechaNacimiento = $fecha_nacimiento;
		$usuario->sexo= request('apellidos_persona_regala');                                                                   
		$usuario->telefono = request('telefon_regala');                  
		$usuario->activo = 1;
		$usuario->fechaAlta = $fecha_alta;  
		$usuario->direccion = request('direccion');                        
		$usuario->poblacion = request('poblacion');                        
		$usuario->cPostal = request('codigo_postal');      
		//$usuario->ultimoPago = $inUltimoPago;
		//$usuario->pagados = $inPagados;
		//$usuario->fechaPagoForm = $inFechaPagoForm;
		//$usuario->ultimaTransaccion = $inUltimaTransaccion;
		$ip=GetUserIp_();                                        
		$usuario->ipAlta = $ip;         
		$usuario->nif = request('nif');            
                   
		  
		if (trim(request('password'))=='')                      
		{
		    $usuario->password2=Tools::passwdGen();
		    //$usuario->password=$usuario->password2;
		}  
        else		
        { 
		    $usuario->password2=trim(request('password'));                                       
		}

	                            	                         
		                         
		//$usuario->registro_reserva='';
		$usuario->manual=1;        
		$usuario->empresa=0; 
		//var_dump($usuario);die;
		//echo('passwd '.$usuario->password2);               
		$usuario->insert();                                                                                                                             
		envia_password_cliente($usuario->email,$usuario->password2,$empresa);                                  
	} 
	else
	{
	    
		$usuario->nombre=comparar_campos($usuario->nombre,request('persona_regala')); 
		$usuario->apellidos=comparar_campos($usuario->apellidos,request('apellidos_persona_regala'));
		$usuario->fechaNacimiento=comparar_campos($usuario->fechaNacimiento,$fecha_nacimiento);      
		$sexo = (request('sexo')=='Hombre')?1:2;
		$usuario->sexo=comparar_campos($usuario->sexo,$sexo);
		$usuario->poblacion=comparar_campos($usuario->poblacion,request('poblacion'));
		$usuario->telefono=comparar_campos($usuario->telefono,request('telefon_regala'));
		$usuario->direccion=comparar_campos($usuario->direccion,request('direccion'));
		$usuario->cPostal=comparar_campos($usuario->cPostal,request('codigo_postal'));
		if (trim(request('password'))!='')
		{
		    $usuario->password2=trim(request('password'));
		}
		else 
		{
		    $usuario->password2='';
		}
		
		$usuario->nif=comparar_campos($usuario->nif,request('nif'));                                                                                                                                              
		$usuario->ipAlta='';
		$usuario->registro_reserva='';
		$usuario->empresa='';
		$usuario->activo='';
		$usuario->fechaAlta='';
		$usuario->ultimoPago = '';
		$usuario->pagados = '';
		$usuario->fechaPagoForm = '';
		$usuario->ultimaTransaccion = '';
		
		$usuario->Update();           
	}
		 
	    echo 'OK';
	    	
    }
    
    
    
    
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
  	
  $color = request('color');
  if (strpos(strtoupper($_REQUEST['ciudad']),'RUTA_TURISTICA')===false)
  {	
 
	 if ($_REQUEST['color']==55) //suspensiÃ³n de los eventos del dÃ­a y evento seleccionados.
	 {
		$color=5;
		$tipus = request('tipus');
		
		$t_aux='';
		
		//CIUDAD
		if (strtolower($_REQUEST['ciudad'])=='barcelona') $ciudad_aux='';
		else $ciudad_aux=$_REQUEST['ciudad'];
		$ciudad=FuncionesSeguridad::seg($ciudad_aux);
		$ip=GetUserIp_();
		$observaciones=utf8_encode('SuspensiÃ³n');		

		//TIPO DE EVENTO
		if (strpos($tipus,'ferrari_ruta_turistica')!==false)
			$t_aux='i.tipus_event like "%ferrari_ruta_turistica%"';
		else if (strpos($tipus,'lamborghini_ruta_turistica')!==false)
			$t_aux='i.tipus_event like "%lamborghini_ruta_turistica%"';
		else	
			$t_aux='i.tipus_event="'.$tipus.'"';
		
		if( $tipus=='ferrari' )
		{
			$t_aux='(i.tipus_event="ferrari" OR i.tipus_event="ferrari_porsche901") ';
		} 
		elseif($tipus=='lamborghini' )
		{
			$t_aux='(i.tipus_event="lamborghini_lotus" OR i.tipus_event="lamborghini") ';
		}

		//EVENTOS A SUSPENDER.
		$sql = ' SELECT * FROM  `events'.$ciudad_aux.'` i where email_confirm!="" and pilot != "no disponible" and  substring(id_event,1,10)="'.request('marca_dia').'" AND '.$t_aux;
		//die($sql);
		//echo($sql);
		$result=mysql_query($sql,$link) or die ('error '.mysql_error());
		
		$eventos = array();
		if ($result)
		{
			while ($r=mysql_fetch_assoc($result))
			{
				$eventos[]=$r;
			}
	    }

		/******/		

		
		foreach($eventos as $evt)
		{		
			$existe=false;
			$sqle = " SELECT count(*) count FROM limbo WHERE 1=1 ";

			if ($ciudad!='')  
				$sqle .= " AND ciudad_evento='".$ciudad."' ";
			
			//if ($t_aux!='')  
			//	$sqle .= " AND ".$t_aux;
			$sqle .= " AND id_evento=".$evt['id'];
			
			
			$resulte=mysql_query($sqle,$link) or die ('error '.mysql_error());
			
			if ($resulte)
			{
				$re=mysql_fetch_assoc($resulte);
				if ($re and $re['count']>0) 
				{
					$existe=true;
				}
			}
					
					
			if(!$existe)
			{
				$insert= " INSERT INTO limbo  (id_evento,ciudad_evento,fecha,Observaciones,ip,tipo)
									  VALUES (".$evt['id'].",'".$ciudad."',now(),'".$observaciones."','".$ip."',2);";
				//die($insert);					  
				
				$result=mysql_query($insert,$link) or die ('error '.mysql_error());
				
			}
		}
		
		/** marcamos color dÃ­a **/
		
		  $sql='SELECT * FROM `disponibles'.$_REQUEST['ciudad'].'` where data="'.request('marca_dia').'" AND evento="'.request('tipus').'"  ';
		 // die($sql);
		  $result=mysql_query($sql,$link) or die('error');
		  if(!mysql_num_rows($result))
		   {
		   /*$sql='INSERT INTO `disponibles'.$_REQUEST['ciudad'].'` (data,evento,color) values("'.request('marca_dia').'","'.request('tipus').'"
		   ,"'.request('color').'" )  ';*/


			$sql='INSERT INTO `disponibles'.$_REQUEST['ciudad'].'` (data,evento,color) values("'.request('marca_dia').'","'.request('tipus').'"  
		   ,"'.$color.'" )  ';
		   
		   $result=mysql_query($sql,$link) or die('error');
		   }
		  else {// existeix s'ha de modificar color
			  $sql='UPDATE `disponibles'.$_REQUEST['ciudad'].'` SET color="'.$color.'"  where data="'.request('marca_dia').'" AND evento="'.request('tipus').'" ';
		   $result=mysql_query($sql,$link) or die('error');
		  }
		
		
		/** envÃ­o mails **/
			

		include "enviar_mails_suspension.php";
		//die($_REQUEST['marca_dia']);
		//envio_mails($ciudad,$tipus,$_REQUEST['marca_dia']);
/******/	  
	  
	  }
	  else
	  {
	  
		  $sql='SELECT * FROM `disponibles'.$_REQUEST['ciudad'].'` where data="'.request('marca_dia').'" AND evento="'.request('tipus').'"  ';
		  
		  $result=mysql_query($sql,$link) or die('error');
		  if(!mysql_num_rows($result))
		   {
		   $sql='INSERT INTO `disponibles'.$_REQUEST['ciudad'].'` (data,evento,color) values("'.request('marca_dia').'","'.request('tipus').'"
		   ,"'.request('color').'" )  ';
		   $result=mysql_query($sql,$link) or die('error');
		    if (request('color')==1)
			{
				actualizar_libres(request('tipus'),$_REQUEST['ciudad'],request('marca_dia'),es_bautizo(request('tipus')));		   
			}
		   }
		  else {// existeix s'ha de modificar color
			  $sql='UPDATE `disponibles'.$_REQUEST['ciudad'].'` SET color="'.request('color').'"  where data="'.request('marca_dia').'" AND evento="'.request('tipus').'" ';

			  $result=mysql_query($sql,$link) or die('error');
			  if (request('color')==1)
			  {
				actualizar_libres(request('tipus'),$_REQUEST['ciudad'],request('marca_dia'),es_bautizo(request('tipus')));			  
			  }
			  
		  }
	  }
  } 


  else
  {  
	  if (strrpos(request('tipus'),'bferrari')!==false)
	  	$where_tipus = ' evento like "_bferrari%"  '; 
	  else if (strrpos(request('tipus'),'ferrari')!==false)
	  	$where_tipus = ' evento like "ferrari%"  '; 
	  else if (strrpos(request('tipus'),'blamborghini')!==false)
	  	$where_tipus = ' evento like "_blamborghini%"  '; 
	  else if (strrpos(request('tipus'),'lamborghini')!==false)
	  	$where_tipus = ' evento like "lamborghini%"  '; 
	  	
	  $sql='SELECT * FROM `disponibles'.$_REQUEST['ciudad'].'` where data="'.request('marca_dia').'" AND '.$where_tipus;  
//die($sql);	  
	  $result=mysql_query($sql,$link) or die('error');        
	  if(!mysql_num_rows($result))
	   {
	   $sql='INSERT INTO `disponibles'.$_REQUEST['ciudad'].'` (data,evento,color) values("'.request('marca_dia').'","'.request('tipus').'"
	   ,"'.$color.'" )  ';
	   $result=mysql_query($sql,$link) or die('error');
	   }
	  else {// existeix s'ha de modificar color
	      $sql='UPDATE `disponibles'.$_REQUEST['ciudad'].'` SET color="'.$color.'"  where data="'.request('marca_dia').'" AND '.$where_tipus;
		  //die($sql);
	   $result=mysql_query($sql,$link) or die('error');
	  }
 }
   //die($sql);
  	
  	/*	
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
  */
  die('ok'); 
  }
else if (isset($_REQUEST['test_email_suspension']))  
{
	include "enviar_mails_suspension.php";
	
	envia_mail_test();

}
else if(isset($_REQUEST['esborra']))
  {
  	if ($_REQUEST['ciudad']=='rutas_turisticas')
    	$sql='DELETE e1 FROM `events'.$_REQUEST['ciudad'].'` AS e1 
    					JOIN `events'.$_REQUEST['ciudad'].'` AS e2
    					 on (e1.id_event_ini = e2.id_event_ini or (e1.id_event_ini is null and e1.id_event=e2.id_event)) 
    		where e2.id="'.request('esborra').'"  ';   
    else
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
    //$sql='SELECT * FROM `events'.$_REQUEST['ciudad'].'` WHERE id="'.request('id_edita').'"';
    $sql='SELECT e.*,u.nif,u.direccion,u.poblacion,u.cpostal,u.fecha_nacimiento 
          FROM `events'.$_REQUEST['ciudad'].'` e
          LEFT JOIN ps_usuarios u on e.email=u.email 
          WHERE id="'.request('id_edita').'"';
    
    $result=mysql_query($sql,$link) or die('error '.$sql);      
    
    $r=mysql_fetch_assoc($result);   
    //var_dump($r);die;
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
    $cad_eval.='id_(\'codigo_postal\').value=\''.$r['cpostal'].'\'; ';
    $cad_eval.='id_(\'direccion\').value=\''.str_replace('\'','´',$r['direccion']).'\'; ';
    $cad_eval.='id_(\'poblacion\').value=\''.tools::getSecureString($r['poblacion']).'\'; ';
    $cad_eval.='id_(\'nif\').value=\''.$r['nif'].'\'; ';

    $fechaNacimiento=$r['fecha_nacimiento'];
    $fnac = ($fechaNacimiento!='0000-00-00' and $fechaNacimiento!='')?(substr($fechaNacimiento,8,2).'/'.substr($fechaNacimiento,5,2).'/'.substr($fechaNacimiento,0,4)):'01/01/'.date('Y');
    list($dia_ini,$mes_ini,$any_ini) = explode('/',$fnac);    
     
    $cad_eval.='$(\'#dia_nac\').val('.$dia_ini.');';
    $cad_eval.='$(\'#mes_nac\').val('.$mes_ini.');';
    $cad_eval.='$(\'#any_nac\').val('.$any_ini.');';
    
      
    $cad_eval.='id_(\'origen\').value=\''. $r['origen'].'\'; ';
    //$cad_eval.='id_(\'tipus\').value=\''. $r['tipus_event'].'\'; ';
    $cad_eval.='id_(\'tipus\').value=\''. request('tipus').'\'; ';
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
    
	$id_hotel=intval($r['id_hotel']); 
	$fechaentrada=$r['fecha_entrada'];
	//print_r($r);
    //_envia_mails($r);
	  
	if (trim($r['email_confirm'])=='') 
		$destinatario = $r['email_persona_regala'];           
	else 
		$destinatario = $r['email_confirm'];         
				
    //ini_set('mail.log',$_SERVER['DOCUMENT_ROOT'].'/../mail.log');
	traza_a('envioreserva.txt','destinatario: '.$destinatario);
	
				 
	//EnvÃ­o manual
	//echo('condicion envio manual '.(request('envio_cliente')==1 || request('envio_hotel')==1 || trim(request('email_alternativo'))!=''));die;  
	
	if (request('envio_cliente')==1 || request('envio_hotel')==1 || trim(request('email_alternativo'))!='')             
	{ 
		if (request('envio_cliente')==1)                                              
		{      
			envia_mails_pdf_bd($_REQUEST['ciudad'],$r,$destinatario);                                      
			traza_a('envioreserva.txt','enviado a cliente '.$destinatario);                      
		}		
			 

		if (request('envio_hotel')==1)                                                                       
		{       
			
			$ciudad = request('ciudad');                                         
			if (trim($ciudad)=='') 
				$ciudad='barcelona';    
			
			traza_a('envioreserva.txt','codigo hotel '.$destinatario);       
			
			$codigo_hotel = codigo_hotel_ciudad($ciudad,substr($r['id_event'],0,10).' 00:00:00'); 
  			
			//$codigo_hotel=$codigo_hotel[0];
			
			//die('test '.$codigo_hotel); 
			traza_a('envioreserva.txt','despues codigo hotel '.$destinatario_hotel);                 
			 
			$destinatario_hotel = email_hotel($codigo_hotel);                              
			//die('error '.$destinatario_hotel);
			traza_a('envioreserva.txt','destinatario hotel '.$destinatario_hotel);                
			//$destinatario_hotel = 'marctorraso@gmail.com';	
	//		die('destinatario hotel :'.$destinatario_hotel);                                      	
			envia_mails_pdf_bd($_REQUEST['ciudad'],$r,$destinatario_hotel);    
			if (substr($r2['id_event'],0,4)!='2008')
			{	echo('2008');
				//enviar_mail_aviso_hotel($destinatario,$codigo_hotel,telefono_hotel($codigo_hotel),implode('/',array_reverse(explode('-',substr($fechaentrada,0,10)))));			
				traza_a('envioreserva.txt','enviado hotel 1 hotel '.$destinatario_hotel);     
			}
			else
			{
				echo('error dest hotell '.$destinatario_hotel);
			}
			
			if ($codigo_hotel==4949) 
			{
				envia_mails_pdf_bd($_REQUEST['ciudad'],$r,'collbato@eada.edu');  
				traza_a('envioreserva.txt','enviado hotel 2 hotel '.$destinatario_hotel);     

			}	
			
			traza_a('envioreserva.txt','enviado a hotel '.$destinatario_hotel);         
		}	    
		
		if (trim(request('email_alternativo'))!='')
		{                                        	
			envia_mails_pdf_bd($_REQUEST['ciudad'],$r,trim(request('email_alternativo')));
			traza_a('envioreserva.txt','enviado a alternativo'.trim(request('email_alternativo')));
		}	
				
	}
	//ReubicaciÃ³n.
	else
	{
		if($id_hotel) 
		{
			$ciudad = request('ciudad');                                                               
			if (trim($ciudad)=='') $ciudad='barcelona';                               
				
			$codigo_hotel = codigo_hotel_ciudad($ciudad,substr($r2['id_event'],0,10).' 00:00:00');               
			$destinatario_hotel = email_hotel($codigo_hotel);              
			//echo('error: desthot '.$destinatario_hotel.' - '.substr($r2['id_event'],0,4));                                                                                                                                        
			/*
			if (substr($r2['id_event'],0,4)!='2008')
			{
				envia_mails_pdf_bd($_REQUEST['ciudad'],$r,$destinatario_hotel);                                     
			}
			else
			{
				echo('error: desthot '.$destinatario_hotel);                                                                                                                                      
			}
			*/
			
		} 
		
//		die('error '.$destinatario_hotel);                         
		
		envia_mails_pdf_bd($_REQUEST['ciudad'],$r,$destinatario);                                         
		traza_a('envioreserva.txt','enviado a clienter '.$destinatario);                    
	}             
	
//	envia_mails_pdf_bd($_REQUEST['ciudad'],$r,$destinatario);	     
	envia_mails_pdf_bd($_REQUEST['ciudad'],$r,'motorclub');		
	traza_a('envioreserva.txt','enviado a motorclub');
	echo ('OK');

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

else if (isset($_REQUEST['buscar_limbo']))
{

//include('config_events.php');
	
  $nombre_apellidos = explode(' ',$_REQUEST['nombreb']);	
  $nombre_apellidos = array_map('trim',$nombre_apellidos);
  $nombre='';
  $apellido1 = '';
  $apellido2 = '';
  switch(count($nombre_apellidos))
  {
	case 1:	
		$nombre = $nombre_apellidos[0];
	break;
	case 2:	
		$nombre = $nombre_apellidos[0];
		$apellido1 = $nombre_apellidos[1];
	break;
	case 3:	 
		$nombre = $nombre_apellidos[0];
		$apellido1 = $nombre_apellidos[1];
		$apellido2 = $nombre_apellidos[2];
	break;

}

 
  $apellido1 = normalizar($apellido1);
  $apellido2 = normalizar($apellido2);
  $nombre = normalizar($nombre);
 
  //$nombre = str_replace('\t','',$nombre);
  $nombre=rtrim(trim($nombre));
  //echo(ord($nombre[strlen($nombre)-1]).'a');

  $apellido1=trim($apellido1);
  $apellido2=trim($apellido2);
  
 
  $condicion_nombre1='
  ucase(pilot)  like "%'.$nombre.'%" and ucase(pilot) like "%'.$apellido1.'%" and ucase(pilot) like "%'.$apellido2.'%" 
  OR
  ucase(pilot)  like "%'.$nombre.'%" and ucase(apellidos_piloto) like "%'.$apellido1.'%" and apellidos_piloto like "%'.$apellido2.'%"';

  $condicion_nombre2='
  ucase(persona_regala) like "%'.$nombre.'%" and ucase(persona_regala) like "%'.$apellido1.'%" and ucase(persona_regala) like "%'.$apellido2.'%" 
  OR
  ucase(persona_regala) like "%'.$nombre.'%" and ucase(apellidos_persona_regala) like "%'.$apellido1.'%" and ucase(apellidos_persona_regala) like "%'.$apellido2.'%"   
  ';

  $condicion_nombre3='
  ucase(apellidos_piloto) like "%'.$nombre.'%" and ucase(apellidos_piloto) like "%'.$apellido1.'%"   
  ';

  $condicion_nombre4='
  ucase(apellidos_persona_regala) like "%'.$nombre.'%" and ucase(apellidos_persona_regala) like "%'.$apellido1.'%"   
  ';

  $condicion_nombre = '('.$condicion_nombre1.' OR '.$condicion_nombre2.' OR '.$condicion_nombre3.' OR '.$condicion_nombre4.')';

/*  $condicion_nombre.= 'OR
  persona_regala   like "%'.$nombre.'%")
  ';
*/
     	
//  $nombre = $_REQUEST['nombreb'];
//  $apellidos = $_REQUEST['nombreb'];
 

  if($_REQUEST['ciudadb']!='*')  
  $sql='SELECT ciud.codi_consum codi_cons,ciud.id idev,ciud.*,"'.strtoupper($_REQUEST['ciudadb']).'" ciudad    
  from events'.$_REQUEST['ciudadb']. 
  ' ciud where 
  (email_persona_regala like "%'.trim($_REQUEST['emailb']).'%" OR 
  email  like "%'.trim($_REQUEST['emailb']).'%" OR
  email_confirm   like "%'.trim($_REQUEST['emailb']).'%") 
  AND
  (telefon  like "%'.trim($_REQUEST['telefonob']).'%" OR
  mobil_persona_regala  like "%'.trim($_REQUEST['telefonob']).'%") 
  AND
  '.$condicion_nombre.'
  AND
  (codi_localtzador   like "%'.trim($_REQUEST['codigob']).'%" OR
  codi_consum    like "%'.trim($_REQUEST['codigob']).'%") 
  AND
  id_event  like "%'.trim($_REQUEST['diab']).'%" 
  
  AND
  tipus_event   like "%'.trim($_REQUEST['tipob']).'%" 
  
  ORDER BY id_event 
  ';
  else $sql='
  SELECT b.codi_consum codi_cons,b.id idev,b.*,"Barcelona" ciudad    from events b where 
  (email_persona_regala like "%'.trim($_REQUEST['emailb']).'%" OR 
  email  like "%'.trim($_REQUEST['emailb']).'%" OR
  email_confirm   like "%'.trim($_REQUEST['emailb']).'%") 
  AND
  (telefon  like "%'.trim($_REQUEST['telefonob']).'%" OR
  mobil_persona_regala  like "%'.trim($_REQUEST['telefonob']).'%") 
  AND
  '.$condicion_nombre.'
  AND
  (codi_localtzador   like "%'.trim($_REQUEST['codigob']).'%" OR
  codi_consum    like "%'.trim($_REQUEST['codigob']).'%") 
  AND
  id_event  like "%'.trim($_REQUEST['diab']).'%" 
  
  AND
  tipus_event   like "%'.trim($_REQUEST['tipob']).'%" 
  
  
  UNION ALL
  
  SELECT m.codi_consum codi_cons,m.id idev,m.*,"Madrid" ciudad    from eventsmadrid m where 
  (email_persona_regala like "%'.trim($_REQUEST['emailb']).'%" OR 
  email  like "%'.trim($_REQUEST['emailb']).'%" OR
  email_confirm   like "%'.trim($_REQUEST['emailb']).'%") 
  AND
  (telefon  like "%'.trim($_REQUEST['telefonob']).'%" OR
  mobil_persona_regala  like "%'.trim($_REQUEST['telefonob']).'%") 
  AND
  '.$condicion_nombre.'
  AND
  (codi_localtzador   like "%'.trim($_REQUEST['codigob']).'%" OR
  codi_consum    like "%'.trim($_REQUEST['codigob']).'%") 
  AND
  id_event  like "%'.trim($_REQUEST['diab']).'%" 
  
  AND
  tipus_event   like "%'.trim($_REQUEST['tipob']).'%" 
  
  
  UNION ALL
   
  SELECT v.codi_consum codi_cons,v.id idev,v.*,"Valencia" ciudad    from eventsvalencia v where 
  (email_persona_regala like "%'.trim($_REQUEST['emailb']).'%" OR 
  email  like "%'.trim($_REQUEST['emailb']).'%" OR
  email_confirm   like "%'.trim($_REQUEST['emailb']).'%") 
  AND
  (telefon  like "%'.trim($_REQUEST['telefonob']).'%" OR
  mobil_persona_regala  like "%'.trim($_REQUEST['telefonob']).'%") 
  AND
  '.$condicion_nombre.'
  AND
  (codi_localtzador   like "%'.trim($_REQUEST['codigob']).'%" OR
  codi_consum    like "%'.trim($_REQUEST['codigob']).'%") 
  AND
  id_event  like "%'.trim($_REQUEST['diab']).'%" 
  
  AND
  tipus_event   like "%'.trim($_REQUEST['tipob']).'%" 
  
  
  
   
  UNION ALL
   
  SELECT a.codi_consum codi_cons,a.id idev,a.*,"Andalucia" ciudad    from eventsandalucia a where 
  (email_persona_regala like "%'.trim($_REQUEST['emailb']).'%" OR 
  email  like "%'.trim($_REQUEST['emailb']).'%" OR
  email_confirm   like "%'.trim($_REQUEST['emailb']).'%") 
  AND
  (telefon  like "%'.trim($_REQUEST['telefonob']).'%" OR
  mobil_persona_regala  like "%'.trim($_REQUEST['telefonob']).'%") 
  AND
  '.$condicion_nombre.'
  AND
  (codi_localtzador   like "%'.trim($_REQUEST['codigob']).'%" OR
  codi_consum    like "%'.trim($_REQUEST['codigob']).'%") 
  AND
  id_event  like "%'.trim($_REQUEST['diab']).'%" 
  
  AND
  tipus_event   like "%'.trim($_REQUEST['tipob']).'%" 
  

  
   
  UNION ALL
   
  SELECT c.codi_consum codi_cons,c.id idev,c.*,"Cantabria" ciudad  from eventscantabria c where 
  (email_persona_regala like "%'.trim($_REQUEST['emailb']).'%" OR 
  email  like "%'.trim($_REQUEST['emailb']).'%" OR
  email_confirm   like "%'.trim($_REQUEST['emailb']).'%") 
  AND
  (telefon  like "%'.trim($_REQUEST['telefonob']).'%" OR
  mobil_persona_regala  like "%'.trim($_REQUEST['telefonob']).'%") 
  AND
  '.$condicion_nombre.'
  AND
  (codi_localtzador   like "%'.trim($_REQUEST['codigob']).'%" OR
  codi_consum    like "%'.trim($_REQUEST['codigob']).'%") 
  AND
  id_event  like "%'.trim($_REQUEST['diab']).'%" 
  
  AND
  tipus_event   like "%'.trim($_REQUEST['tipob']).'%" 
  
  
  UNION ALL
   
  SELECT rt.codi_consum codi_cons,rt.id idev,rt.*,"rutas_turisticas" ciudad  from eventsrutas_turisticas rt where 
  (email_persona_regala like "%'.trim($_REQUEST['emailb']).'%" OR 
  email  like "%'.trim($_REQUEST['emailb']).'%" OR
  email_confirm   like "%'.trim($_REQUEST['emailb']).'%") 
  AND
  (telefon  like "%'.trim($_REQUEST['telefonob']).'%" OR
  mobil_persona_regala  like "%'.trim($_REQUEST['telefonob']).'%") 
  AND
  '.$condicion_nombre.'
  AND
  (codi_localtzador   like "%'.trim($_REQUEST['codigob']).'%" OR
  codi_consum    like "%'.trim($_REQUEST['codigob']).'%") 
  AND
  id_event  like "%'.trim($_REQUEST['diab']).'%" 
  
  AND
  tipus_event   like "%'.trim($_REQUEST['tipob']).'%"   
  
  ORDER BY id_event 

  ';

     
  $sql2 = ' select a.* from ('.$sql.') a where trim(a.pilot) != "no disponible"  order by date(substr(a.id_event,1,10)) desc ';
   //and a.codi_cons = "AALB61050786"

  //die($sql2);
  
  $result=mysql_query($sql2,$link) or die('error'.mysql_error());  
	
  $id_eventos = array();
 
  while($r=mysql_fetch_assoc($result))
	 {		
	 $id_eventos[]=$r['idev'];     
	 }

$sid_eventos = implode(',',$id_eventos);  
die($sid_eventos);
  
   
}

else if (isset($_REQUEST['enviar_limbo']))
{
	if (strtolower($_REQUEST['ciudad'])=='barcelona') $ciudad_aux='';
	else $ciudad_aux=$_REQUEST['ciudad'];
	$id=FuncionesSeguridad::seg($_REQUEST['id']);
	$ciudad=FuncionesSeguridad::seg($ciudad_aux);
	$tipo_limbo=intval($_REQUEST['tipo_limbo']);
	$limbo=intval($_REQUEST['limbo']);
	$ip=GetUserIp_();
	
	  
	
	//Si estÃ¡ en verde (la reserva ya estÃ¡ en el limbo), la eliminaremos.
	if ($limbo==1)
	{
		$sql = " DELETE  FROM limbo WHERE ciudad_evento='".$ciudad."' and id_evento='".$id."' ";
		//die($sql);	
		$result=mysql_query($sql,$link) or die ('error '.mysql_error());
		die('OK');
		
	}
	
	
	switch ($tipo_limbo)
	{
		case 1://cancelaciÃ³n sin fecha.
			$observaciones='CancelaciÃ³n sin Fecha';
			break;
		case 2://SuspensiÃ³n
			$observaciones='SuspensiÃ³n';
			break;
			
		default:
			$observaciones='';
	}
	
	
	
	$existe=false;
	$sql = " SELECT count(*) count FROM limbo WHERE ciudad_evento='".$ciudad."' and id_evento='".$id."' ";
	//die($sql);
	$result=mysql_query($sql,$link) or die ('error '.mysql_error());
	
	if ($result)
	{
		$r=mysql_fetch_assoc($result);
		if ($r and $r['count']>0) 
			$existe=true;
	}
	
	
	$id_event_limbo = '1900-01-01@00:00:00';                                                              
			
	if(!$existe)
	{
		$insert= " INSERT INTO limbo  (id_evento,ciudad_evento,fecha,Observaciones,ip,tipo)
							  VALUES (".$id.",'".$ciudad."',now(),'".$observaciones."','".$ip."',".$tipo_limbo.");";
		
		//Para las cancelaciones fuera de fecha, guardaremos la fecha actual de la reserva
		//en el campo id_event_ant, y pondremos como fecha provisional $id_event_limbo,
		//que es una fecha a la que no accederemos y que por lo tanto sÃ³lo serÃ¡ visible
		//desde el listado de reservas en limbo.
		
		if ($tipo_limbo==1)
		{
			
			$result=mysql_query($insert,$link) or die ('error '.mysql_error());
			
			$update = " UPDATE events".$ciudad."
					    SET id_event_ant=id_event,
					    	id_event='".$id_event_limbo."'
						WHERE id = ".$id;
						//die($update);
			$result=mysql_query($update,$link) or die ('error '.mysql_error());						
		}
		//en el caso de una suspensiÃ³n la reserva no se modificarÃ¡. tan sÃ³lo se crearÃ¡ el registro de limbo.
		else if ($tipo_limbo==2)
		{
			$result=mysql_query($insert,$link) or die ('error '.mysql_error());
		}
		
	}
	die ('OK');
	
}

function plazas($t)
   {
  switch ($t)
    {
    case 'ferrari_porsche901':
    case 'lamborghini_lotus':
    case 'porsche997_porsche996':
    case 'ferrari_ruta_turistica2':
    case 'lamborghini_ruta_turistica2':
    	return 2;         
    case 'ferrari_ruta_turistica3':
    case 'lamborghini_ruta_turistica3':
    	return 3;         
    case 'ferrari_ruta_turistica4':
    case 'lamborghini_ruta_turistica4':
    	return 5;         
    }
    return 1;    
   }
/*function plazas($t)
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
*/

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
 if(trim($_REQUEST['telefon']=='')){$cad.='El telÃƒÂ©fono del piloto es obligatorio<br>'; } 
 if(trim($_REQUEST['pilot']=='')){$cad.='El nombre del piloto es obligatorio<br>'; }
 
 if(trim($_REQUEST['persona_regala']=='')){$cad.='El nombre de la persona que regala  es obligatorio<br>'; } 
 if(trim($_REQUEST['telefon_regala']=='')){$cad.='El telÃƒÂ©fono de la persona que regala es obligatorio<br>'; } 
 
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
   {
   	return mysql_real_escape_string(strip_tags($_REQUEST[$c]));
   }
   

   
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

    //$mail->From = "info@motorclubexperience.com";
	$mail->From ="reservas.motorclubexperience.com";   

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
    $body.= "<strong>Evento: </strong>".return_tipus_e($r['tipus_event'],$r['Observaciones']).'<br>';
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
	$body.= "<strong>Ciudad: </strong>".ciudad_ruta($aux_ciudad,$r['tipus_event']).'<br>';
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
		//echo('obs1'.$r['Observaciones'].'2');
		$tipo=return_tipus_e($r['tipus_event'],$r['Observaciones']);
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
		//echo('obs2'.request('Observaciones').'3');
		$tipo=return_tipus_e(request('tipus'),request('Observaciones'));
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
					<span style="font-weight:bold;">Ciudad:</span> <span>'.ciudad_ruta($ciudad,$tipo).'</span>
				</p>	
				<p>
					<span style="font-weight:bold;">DÃƒÂ­a de la experiencia:</span> <span>'.implode('/',array_reverse(explode('-',$dia))).'</span>
				</p>	
				<p>
					<span style="font-weight:bold;">Hora escogida:</span> <span>'.$hora.'</span>
				</p>	
				<p>
					<span style="font-weight:bold;">Nombre:</span> <span>'.$piloto.' '.$apellidos_piloto.'</span>
				</p>	
				<p>
					<span style="font-weight:bold;">TelÃƒÂ©fono:</span> <span>'.$telefono.'</span>
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
					<span style="font-weight:bold;">TelÃƒÂ©fono:</span> <span>'.$telefono_regala.'</span>
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
					<span style="font-weight:bold;">DirecciÃƒÂ³n IP:</span> <span>'.$ip.'</span>
				</p>	
				<p>
					<span style="font-weight:bold;">Origen del cupÃƒÂ³n:</span> <span>'.$origen.'</span>
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
		<strong>Su reserva ha sido realizada tal y como nos ha indicado y registrado en nuestro sistema</strong>, revise todos sus datos de contacto, fecha y hora del evento y ciudad escogida. En caso de haber escogido alguna opciÃƒÂ³n incorrecta o existe algÃƒÂºn telÃƒÂ©fono o email incorrecto contacte a info@motorclubexperience.com para rectificar y recibir la nueva confirmaciÃƒÂ³n de reserva correctamente. (el sistema de reservas ÃƒÂºnicamente registra los datos que usted nos a indicado por lo que no tiene ninguna validez sin no va acompaÃƒÂ±ado del cupÃƒÂ³n comprado)
	</p>
	<p>
		<strong>Recuerde que la hora que le asignamos es aproximada</strong>, pero debe presentarse 30 minutos antes de la hora solicitada para entregar la documentaciÃƒÂ³n. <span class="importante">Es muy importante presentar esta confirmaciÃƒÂ³n junto con el cupÃƒÂ³n comprado, fotocopia del DNI y fotocopia del carnet de conducir en nuestras instalaciones. En caso de no presentar dicha documentaciÃƒÂ³n no se podrÃƒÂ¡ realizar el servicio.</span> Si desea cancelar o modificar esta reserva, debe hacerlo con una antelaciÃƒÂ³n mÃƒÂ­nima de 7 dÃƒÂ­as.
	</p>
    <p> 
		<strong>Tenga en cuenta que pueden derivarse retrasos, por ello la hora que le asignamos es aproximada, y los retrasos de salida con los deportivos pueden estar comprendidos entre 30 minutos y una hora y media aproximadamente como mucho</strong>, no es habitual, pero normalmente esto puede ocurrir a ultima hora de mediodÃƒÂ­a y a finales de la tarde.
    </p>
	<p>	
		Si su cupÃƒÂ³n estÃƒÂ¡ a punto de caducar o caduca para el dÃƒÂ­a que quiere realizar el evento pÃƒÂ³ngase en contacto con nosotros para ampliar la fecha de caducidad. Ya que una vez caducado no podremos activarlo ni prestar el servicio.
     <strong>'.$empresa.' no podrÃƒÂ¡ realizar ningÃƒÂºn servicio a todo participante que entregue su cupÃƒÂ³n caducado el dÃƒÂ­a del evento sin su justificante de ampliaciÃƒÂ³n de '.$empresa.'</strong></p>
	<p>
		<strong>Os recordamos que dicha actividad estÃƒÂ¡ sujeta a condiciones meteorolÃƒÂ³gicas y averÃƒÂ­as imprevistas. Todos aquellos eventos que sean suspendidos por dichas causas, serÃƒÂ¡n notificados al mismo email que ha recibido esta confirmaciÃƒÂ³n de reserva. Os recomendamos que la noche antes del evento revise su correo para asegurarse de que no hay ninguna anulaciÃƒÂ³n por incidente, ya sea meteorolÃƒÂ³gico, averÃƒÂ­as imprevistas etcÃ¢â‚¬Â¦ Revise su correo no deseado por favor.</strong></p>
Ã‚Â 	<p>
     <span class="importante">'.$empresa.' no se hace cargo</span> de los alojamientos de Hotel y desplazamientos, ya sean pÃƒÂºblicos o privados,  por consecuencia de las molestias ocasionadas por la suspensiÃƒÂ³n de las mencionadas condiciones de incidencias meteorolÃƒÂ³gicas o averÃƒÂ­as imprevistas que esta sujeta la actividad. Le recomendamos que si realiza un viaje en  aviÃƒÂ³n o dispone de una estancia en hotel, asegÃƒÂºrese de que tenga la opciÃƒÂ³n de cancelar para que pueda reservar para otro dÃƒÂ­a sin tener los gastos y molestias que puedan derivar una suspensiÃƒÂ³n. Si no esta conforme con las condiciones que le informamos en esta confirmaciÃƒÂ³n de reserva pÃƒÂ³ngase en contacto a info@motorclubexperience.com para anular su reserva.
	</p>	
	';

	$texto_puntos_encuentro =
	'<div class="lista_confirm">
		<p><strong>Madrid:</strong> Hotel Sara de Ur.  C/ Corcho, 26.  La Cabrera 28751 (Madrid)</p>

		<p><strong>Barcelona:</strong> Avda. Del Mestre Joan Muntaner nÃ‚Âº 12. Igualada 08700 ( Barcelona )</p>

		<p><strong>Valencia:</strong> Hotel la Carreta.  Situado en la Carretera de Madrid a Valencia, KM, 334  46370 Chiva (Valencia) 	pegado al circuito de Cheste.</p>

		<p><strong>AndalucÃƒÂ­a:</strong> Hotel Atalaya A-45, Km. 27, 14540 La Rambla - Montilla (C&oacute;rdoba)</p>

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
				<span class="importante" style="weight:bold;">Es muy importante que lea esta informaciÃƒÂ³n para que conozca las condiciones de uso.</span>
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
		$nombref .= str_replace('/','_',$piloto);
		$nombre_fichero = $nombref;

        //echo($cad);         
        
        ob_start();
		
        $html2pdf = new HTML2PDF('P', 'A4', 'fr');
        $html2pdf->setTestTdInOnePage(false);
		$view_html=0;
        $html2pdf -> writeHTML($cad, ($view_html==1));  
//die('aki6 '.$_GET['vista_previa'].'-'.$ncupon);   

        //Si estamos generando la vista previa del cupÃƒÂ³n generaremos un cÃƒÂ³digo aleatorio para el nombre del archivo pdf.
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


function enviar_mail_aviso_documentacion($destinatario)
{ 

	$nombref='';
	if(isset($_REQUEST['hccsportscars_reserva'])) 	$empresa = 'Hccsportcars';
	else if(isset($_REQUEST['dreamcars_reserva']))  $empresa = 'Dreamcarsexperience';
	else     										$empresa = 'Motorclubexperience';

	
	include_once 'class.phpmailer.php';
	include_once 'textos_mensajes.php';


	$mail = new PHPMailer();

    $mail->Host = "localhost";
	$mail -> CharSet = "UTF-8";
	

	if (strpos(request('tipus'),'ruta_turistica')!==false) 
		$mail->From = "reservas.turismo@motorclubexperience.com";
	else 
		$mail->From = "reservas@motorclubexperience.com";


	switch($empresa)
	{
		case 'Hccsportcars':
			$mail->FromName = "hccsportcars.com";
			$mail->Subject = "Aviso Importante sobre el evento!!";
		break;
		case 'Dreamcarsexperience':
			$mail->FromName = "Dreamcarsexperience";
			$mail->Subject = "Aviso Importante sobre el evento!!";
		break;
		case 'Motorclubexperience':
			$mail->FromName = "Motorclubexperience";
			$mail->Subject = "Aviso Importante sobre el evento!!";
		break;
	}


	$body.= '- <b>!Muy importante!</b> Recuerde presentar la confirmaci&oacute;n de la reserva junto con el cup&oacute;n original de compra ó regalo, la fotocopia del DNI  y la fotocopia del carnet de conducir.<br>';
	
	$body.= '<b>En caso de no presentar dicha documentaci&oacute;n no se podr&aacute; realizar el evento.</b> Recuerde tambi&eacute;n que debe presentarse 30 minutos antes de la hora solicitada. <br><br>';                                               
	$body.= "<span style='font-weight:normal;color:#6d6d6d;text-decoration:none;'>Este mensaje ha sido enviado por un sistema autom&aacute;tico. Por favor no responda a este e-mail directamente</span><br><br>";                        

	$body=utf8_encode($body);    

	
	$mail->AddAddress($destinatario);    
	//$mail->AddBCC("info@motorclubexperience.com","oculto");  

		
	
	$mail -> Body = $body;
    $mail -> IsHTML(true);
	$mail ->SMTPDebug  = 1;
	try
	{
		if (!$mail -> Send()) {
			echo('error ' . $mail -> ErrorInfo);
			$mail->AddAddress('marctorraso@gmail.com');
			$mail -> Send();
			//unlink(dirname(__FILE__) . '/../cupones/tmp/pdf_cupon' . $ncupon . '.html');
			return false;
		}
	}
	catch (phpmailerException $e) {
	  die ($e->errorMessage()); //Errores de PhpMailer
	  }
	 catch (Exception $e) {
	  die ($e->getMessage()); //Errores de cualquier otra cosa.
	}


}

function enviar_mail_aviso_hotel($destinatario,$id_hotel,$telefono_hotel,$fechaentrada)
{ 

	$nombref='';
	if(isset($_REQUEST['hccsportscars_reserva'])) 	$empresa = 'Hccsportcars';
	else if(isset($_REQUEST['dreamcars_reserva']))  $empresa = 'Dreamcarsexperience';
	else     										$empresa = 'Motorclubexperience';

	
	include_once 'class.phpmailer.php';
	include_once 'textos_mensajes.php';


	$mail = new PHPMailer();

    $mail->Host = "localhost";
	$mail -> CharSet = "UTF-8";
	

	if (strpos(request('tipus'),'ruta_turistica')!==false) 
		$mail->From = "reservas.turismo@motorclubexperience.com";
	else 
		$mail->From = "reservas@motorclubexperience.com";


	switch($empresa)
	{
		case 'Hccsportcars':
			$mail->FromName = "hccsportcars.com";
			$mail->Subject = "Aviso Importante sobre el Hotel!!";
		break;
		case 'Dreamcarsexperience':
			$mail->FromName = "Dreamcarsexperience";
			$mail->Subject = "Aviso Importante sobre el Hotel!!";
		break;
		case 'Motorclubexperience':
			$mail->FromName = "Motorclubexperience";
			$mail->Subject = "Aviso Importante sobre el Hotel!!";
		break;
	}

	
	$body.= '- !Muy importante! Recuerde llamar al hotel '.nombre_hotel($id_hotel).' al tel. '.$telefono_hotel .' para confirmar la reserva de la noche '.$fechaentrada.', ';                                               
	$body.= '<b>de lo contrario cabe la posibilidad de que no disponga de plaza para el día del evento</b>';     
	if ($_REQUEST['ciudad']=='')     
		$body.= ' .<br>Si su cupón dispone de cena llame para reservar mesa al 937779316. Restaurante "La Cassola".  Imprescindible aportar cupón.';                                                                                                                                                                   
	$body.= "<br><br><span style='font-weight:normal;color:#6d6d6d;text-decoration:none;'>Este mensaje ha sido enviado por un sistema autom&aacute;tico. Por favor no responda a este e-mail directamente</span><br><br>";
	
	$body=utf8_encode($body);    

	
	$mail->AddAddress($destinatario);
	$mail->AddBCC("info@motorclubexperience.com","oculto");

		
	
	$mail -> Body = $body;
    $mail -> IsHTML(true);
	$mail ->SMTPDebug  = 1;
	try
	{
		if (!$mail -> Send()) {
			echo('error ' . $mail -> ErrorInfo);
			$mail->AddAddress('marctorraso@gmail.com');
			$mail -> Send();
			//unlink(dirname(__FILE__) . '/../cupones/tmp/pdf_cupon' . $ncupon . '.html');
			return false;
		}
	}
	catch (phpmailerException $e) {
	  die ($e->errorMessage()); //Errores de PhpMailer
	  }
	 catch (Exception $e) {
	  die ($e->getMessage()); //Errores de cualquier otra cosa.
	}


}


function envia_mails_pdf_bd($ciudad,$r,$destinatario)
{
	$nombref='';  
	  
	if(strpos(strtoupper($r['Observaciones']),'HCCSPORTSCAR')!==false) 	$empresa = 'Hccsportcars';               
	else if(strpos(strtoupper($r['Observaciones']),'DREAMCARS')!==false)  $empresa = 'Dreamcarsexperience';     
	else $empresa = 'Motorclubexperience';                            
	
	traza_a('envioreserva.txt','generando confirmaciÃ³n');
	generar_pdf_confirm_reserva($nombref,$empresa,$_REQUEST['ciudad'],$r['id_event'],$r,true);
	traza_a('envioreserva.txt','confirmaciÃ³n generada');
	
	include_once 'class.phpmailer.php';
	include_once 'textos_mensajes.php';

	
	$mail = new PHPMailer();

    $mail->Host = "localhost";
	$mail -> CharSet = "UTF-8";
	
	
	
	if (strpos(request('tipus'),'ruta_turistica')!==false) 
		$mail->From = "reservas.turismo@motorclubexperience.com";
	else 
		$mail->From = "reservas@motorclubexperience.com";


	
	switch($empresa)
	{
		case 'Hccsportcars':
			//$mail->From = "info@hccsportcars.com";
			$mail->FromName = "hccsportcars.com";
			$mail->Subject = "ConfirmaciÃƒÂ³n de Reserva Hcc Sport Cars";
			//$mail->Subject = 'hccsportcars.com';
		break;
		case 'Dreamcarsexperience':
			//$mail->From = "info@dreamcarsexperience.com";
			$mail->FromName = "Dreamcarsexperience";
			$mail->Subject = "Confirmacion de Reserva Dream Cars Experience";
			//$mail->Subject = 'Dreamcarsexperience';
		break;
		case 'Motorclubexperience':
			//$mail->From = "info@motorclubexperience.com";
			$mail->FromName = "Motorclubexperience";
			$mail->Subject = "Confirmacion de Reserva Motor Club Experience";
			//$mail->Subject = 'Motorclubexperience';
		break;
	}

    //if($r['email_confirm']=='')$mail->AddAddress($r['email_persona_regala']);
    //else $mail->AddAddress($r['email_confirm']);	

//	$mail->AddBCC("motorclubexperience@hotmail.com","oculto");

   
	$body='';


	traza_a('envioreserva.txt','adjuntando pdf reserva');

    //dirname(__FILE__).'/
    $mail -> AddAttachment('../../../confirmacion_reservas/confirm_'.$nombref.'.pdf', 'confirmacion_reserva.pdf');
    
	traza_a('envioreserva.txt','pdf adjuntado');

	if ($destinatario!='motorclub')
	{
		traza_a('envioreserva.txt','asignando destinatario '.$destinatario);

		$mail->AddAddress($destinatario);           
		$mail->AddBCC("soporte@motorclubexperience.com","oculto");
		traza_a('envioreserva.txt','destinatario asignado');
		
		$body = "<strong></strong> Reserva para " . implode('/',array_reverse(explode('-',substr($r['id_event'],0,10)))) . "<br><br>";           
		$body .= "<i>Enviado por ".$empresa." </i><br><br>";
		$body .= "<strong>USUARIO: " . $r['persona_regala']." ".$r['apellidos_persona_regala']."</strong><br>
		<br><br>";
		$body .= "<i><strong>Le adjuntamos la confirmaciÃƒÂ³n de reserva que debe presentar junto con el vale comprado de la experiencia.</strong></i><br><br>";   
		$body.="<span style='font-weight:normal;color:#6d6d6d;text-decoration:none;'>Este mensaje ha sido enviado por un sistema automático. Por favor no responda a este e-mail directamente</span><br><br>";		
    }
	else
	{ 
		$mail->AddAddress('motorclubexperience@hotmail.com');  
		//$mail->AddBCC("soporte@motorclubexperience.com","oculto");
		//$mail->AddBCC("info@motorclubexperience.com","oculto");    

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
		$body.= "<strong>Evento: </strong>".return_tipus_e($r['tipus_event'],$r['Observaciones']).'<br>';
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
		$body.= "<strong>Ciudad: </strong>".ciudad_ruta($aux_ciudad,$r['tipus_event']).'<br>';
		$body.= "<strong>Observaciones: </strong>".convert_caracters_hex($r['Observaciones']).'<br>';
	}	
	
	$mail -> Body = $body;
    $mail -> IsHTML(true);
	
	traza_a('envioreserva.txt','enviando (send) a  -'.$destinatario);

    if (!$mail -> Send()) {
		traza_a('error_envio.txt',$mail -> ErrorInfo);
        echo('error ' . $mail -> ErrorInfo);
        if ($nombref!='') eliminar_archivos($nombref);
        unlink(dirname(__FILE__) . '/../../../confirmacion_reservas/confirm_'.$nombref.'.pdf');
        //unlink(dirname(__FILE__) . '/../cupones/tmp/pdf_cupon' . $ncupon . '.html');
        return false;
    }

	traza_a('envioreserva.txt','envio realizado -  '.$destinatario);

	
    if ($nombref!='') eliminar_archivos($nombref);

	traza_a('envioreserva.txt','archivo eliminado');
	
	
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
  
//Dada una reserva insertada, y un nÃºmero de plazas (de 2 a 5), que dependerÃ¡
//de la ruta turÃ­stica seleccionada, insertaremos tantas copias de la reserva 
//como plazas nos queden para completar dicho nÃºmero.
function duplicado_reservas_turisticas($id_event,$plazas,$reserva_a_duplicar)
{	
	global $link;
	$hores1=seleccionar_plantilla_graella(request('tipus'));
	$hores=array();
	$i=0;
  
	foreach ($hores1 as $h=>$info)
	{
		if($h=='c' || !$h) continue;	
		if ($i%2) {$i++;continue;}
		else {$hores[$h]=$info;$i++;}	
	}
	
	$inicio_duplicacion=false;
	$insertados=0;
	$rs=array();
	//Para evitar inyecciones sql.
	foreach ($reserva_a_duplicar as $clave=>$campo)
	{
		$rs[$clave]=FuncionesSeguridad::seg($campo);
	}

	
	
	//Recorremos todo el calendario hasta encontrar la hora de la reserva
	//insertada.  
	//begin();
	$inserts = array();
	foreach($hores as $hora=>$info) 
	{
		$hora_tmp=explode('@',$id_event);
		$dia_event=$hora_tmp[0];
		$hora_event=$hora_tmp[1];
		//if($hora=='c' || !$hora) continue;	
		//Si encontramos la hora de la reserva empezaremos la duplicaciÃ³n.
		if ($hora_event==$hora)
		{
			$inicio_duplicacion=true;
		}
		//Duplicaremos mientras no alcancemos el nÃºmero de plazas asignado al
		//tipo de ruta turistica.
		else if ($inicio_duplicacion && $insertados<$plazas-1)
		{
//			//consulta comprobar si ya existe un registro con id_event = $id_event	
			$id_event_nuevo = $dia_event.'@'.$hora;
			$sql = ' SELECT count(*) cont FROM events'.$_REQUEST['ciudad'].' where  id_event="'.$id_event_nuevo.'"';
			$ocupado=mysql_query($sql,$link)  or die('error'.mysql_error());
	    	$rocupado=mysql_fetch_assoc($ocupado);
	    	
	    	if ($rocupado['cont']>0) 
	    	{
	    		//continue;
	    		//rollback();
	    		die('Error: No se pueden reservar '.$plazas.' plazas consecutivas.');
	    	}

			
		    $sql='INSERT INTO `events'.$_REQUEST['ciudad'].'` (
		    id_event ,id_event_ini,email ,telefon ,pilot,dia,tipus_event,persona_regala,email_persona_regala,mobil_persona_regala,coches,codi_localtzador,codi_consum,Observaciones,origen,plazas,email_confirm)
		    VALUES ("'.$id_event_nuevo.'", "'.$id_event.'", "'.$rs['email'].'", "'.$rs['telefon'].'", 
		    "'.utf8_decode($rs['pilot']).'","'.$aux[0].'","'.request('tipus').'"
		    ,"'.$rs['persona_regala'].'","'.$rs['email_regala'].'","'.utf8_decode($rs['telefon_regala']).'","'.$rs['coches'].'"
		    ,"'.$rs['codigo_localizador'].'","'.$rs['codigo_consumo'].'","'.$rs['Observaciones'].'","'.$rs['origen'].'","'.plazas($rs['tipus']).'"
		    ,"'.$rs['email1'].'");';
    		
		    $inserts[]=$sql;
		    //$result=mysql_query($sql,$link)  or die('error '.mysql_error());
		    $insertados++;
		}
		else if ($inicio_duplicacion) {break;}
			
	}
	
	//si todo ha ido bien actualizaremos el campo id_event_ini, del evento seleccionado en el calendario de horas,  
	//e insertaremos las reservas duplicadas.
	$sql_primero = ' update  `events'.$_REQUEST['ciudad'].'` set id_event_ini = "'.$id_event.'" where id_event = "'.$id_event.'"';		
	$result=mysql_query($sql_primero,$link)  or die('error '.mysql_error());
	foreach ($inserts as $insert)
	{
		$result=mysql_query($insert,$link)  or die('error '.mysql_error());
	}
	die('OK');
	//commit();
 }	

		
		
	



/* Fi	 Noves confirmacions de reserva en format pdf **/
  
  
function convert_caracters_hex($cad) {
  $cad=str_replace('ÃƒÂ³', '&#243;', $cad);    
  $cad=str_replace('ÃƒÂ©', '&#233;', $cad);        
  $cad=str_replace('ÃƒÂ±', '&#241;', $cad);    
  $cad=str_replace('ÃƒÂº', '&#250;', $cad);    
  $cad=str_replace('ÃƒÂ¡', '&#225;', $cad);        
  $cad=str_replace('ÃƒÂ­', '&#237;', $cad);
  $cad=str_replace('ÃƒÂ§', '&#231;', $cad);
  $cad=str_replace('ÃƒÂ²', '&#242;', $cad);    
  $cad=str_replace('ÃƒÂ¨', '&#232;', $cad);        
  $cad=str_replace('ÃƒÂ¹', '&#249;', $cad);    
  $cad=str_replace('ÃƒÂ ', '&#224;', $cad);        
  $cad=str_replace('ÃƒÂ¬', '&#236;', $cad);
  $cad=str_replace('ÃƒÂ±', '&#241;', $cad);
  return $cad;
}
function elimina_caracters($cad) {
  $cad=str_replace('ÃƒÂ³', 'o', $cad);    
  $cad=str_replace('ÃƒÂ©', 'e', $cad);        
  $cad=str_replace('ÃƒÂ±', 'n', $cad);    
  $cad=str_replace('ÃƒÂº', 'u', $cad);    
  $cad=str_replace('ÃƒÂ¡', 'a', $cad);        
  $cad=str_replace('ÃƒÂ­', 'i', $cad);
  $cad=str_replace('ÃƒÂ§', 'c', $cad);
  $cad=str_replace('ÃƒÂ²', 'o', $cad);    
  $cad=str_replace('ÃƒÂ¨', 'e', $cad);        
  $cad=str_replace('ÃƒÂ¹', 'u', $cad);    
  $cad=str_replace('ÃƒÂ ', 'a', $cad);        
  $cad=str_replace('ÃƒÂ¬', 'i', $cad);
  $cad=str_replace('ÃƒÂ±', 'n', $cad);
  $cad=str_replace('
', '', $cad);
  return $cad;
}

function x_chars_cor($cad) {
      $ab=array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','Ãƒâ€˜','Ãƒâ€¡','O','P','Q','R','S','T','U','V','W','X','Y','Z'
    ,'a','b','c','d','e','f','g','h','i','j','k','l','m','n','ÃƒÂ±','ÃƒÂ§','o','p','q','r','s','t','u','v','w','x','y','z'
    ,' ','-','+','\'',',','Ã¢â€šÂ¬',':','.','0','1','2','3','4','5','6','7','8','9','_'); 
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
  
function ciudad_ruta($ciudad,$tipo_evento)
{

	if (strtoupper($ciudad)=='RUTAS_TURISTICAS')
	{
	 switch($tipo_evento)
	 {
	 	case 'ferrari_ruta_turistica1':
	 	case 'lamborghini_ruta_turistica1':
	 	case 'ferrari_ruta_turistica2':
	 	case 'lamborghini_ruta_turistica2':
	 			$ret = 'Barcelona';
	 			break;		
	 	case 'ferrari_ruta_turistica3':
	 	case 'lamborghini_ruta_turistica3':
	 			$ret = 'Sitges';
	 			break;		
	 	case 'ferrari_ruta_turistica4':
	 	case 'lamborghini_ruta_turistica4':
	 			$ret = 'Montserrat';
	 			break;		
	 }
	 
	}
	else $ret = $ciudad;

	return strtoupper($ret);
}
    
function canvia_textos_codigo($origen)
{
  
  $r=array();
  switch($origen)
   {
   	case 'LETS BONUS':
	$r[0]='Localizador';
	$r[1]='Codigo consumo';
	break;
	case 'GROUPALIA':
	$r[0]='Numero de vale';
	$r[1]='NumeraciÃƒÂ³n codigo de barras completo ';
	break;
	case 'OFFERUM':
	$r[0]='CÃƒÂ³digo del bono';
	$r[1]='CÃƒÂ³digo de validaciÃƒÂ³n';
	break;
	case 'ATRAPALO':
	$r[0]='NÃƒÂºmero de vale';
	$r[1]='CÃƒÂ³digo de reserva';
	break;
	case 'OFERTIX':
	$r[0]='CÃƒÂ³digo reserva';
	$r[1]='CÃƒÂ³digo de validaciÃƒÂ³n';
	break;
	case 'DOOPLAN':
	$r[0]='CÃƒÂ³digo ';
	$r[1]='CÃƒÂ³digo ';
	break;
	case 'LA_TIENDA_MARCA':
	$r[0]='NÃƒÂºmero de pedido ';
	$r[1]='CÃƒÂ³digo ';
	break;
	case 'DISFRUTALO':
	$r[0]='Localizador';
	$r[1]='Codigo consumo';
	break;
	case 'COLECTIVIA':
	$r[0]='CÃƒÂ³digo de identificaciÃƒÂ³n';
	$r[1]='CÃƒÂ³digo de seguridad';
	break;
	case 'DACOTABOX':
	$r[0]='CÃƒÂ³digo de barras del cheque';
	$r[1]='CÃƒÂ³digo de validaciÃƒÂ³n';
	break;
	case 'SMARTBOX':
	$r[0]='Localizador';
	$r[1]='Codigo consumo';
	break;
	
    case 'CODIGO_ALFA':
    $r[0]='CÃƒÂ³digo ';
    $r[1]='CÃƒÂ³digo ';
    break;

	default:
	$r[0]='Localizador';
	$r[1]='Codigo consumo';
	break;
   }
   return $r;		
}   
   
   
function codigo_hotel_activo($ciudad,$fecha)                                 
{ 
	traza_a('envioreserva.txt','calculando codigo hotel 1');      
	include_once (dirname(__FILE__).'/../../../classes/Db.php');
	include_once (dirname(__FILE__).'/../../../classes/Hotel.php');
	include_once (dirname(__FILE__).'/../../../classes/DisponibilidadHotel.php');
	$disponibilidad_hotel = new DisponibilidadHotel();     
						   		
	$hoteles=array();
	traza_a('envioreserva.txt','calculando codigo hotel 12 ');     
	$hoteles=$disponibilidad_hotel->getHotelesCiudad($ciudad,$fecha);                                                                                                                                                                                                                            
	
	traza_a('envioreserva.txt','calculando codigo hotel 2');     
	//echo('error t ');
	//var_dump($hoteles);
	 
	$hotel=new Hotel();        
	
	if (count($hoteles)==0)
	{
		$defecto=1;
	}
	else
	{
		$defecto=0;
	}

	$codigo_hotel=$hotel->getCodigoHotelDefecto($ciudad,$defecto);	  
	return array($codigo_hotel,$defecto); 
	/*foreach($hoteles as $hotel)
	{
		traza_a('envioreserva.txt','calculando codigo hotel 3');     

		if ($hotel->activo==1)  
		{
			traza_a('envioreserva.txt','calculando codigo hotel 4');     

			$codigo=$hotel->codigo;
			$defecto=$hotel->defecto;
			//unset($disponibilidad_hotel);
			return (array($codigo,$defecto));
		}
	}*/
	
}   
  
  
function codigo_hotel_ciudad($ciudad,$fecha)
{ 
	switch($ciudad)
	{
		case 'barcelona':
		//Ciutat d'Igualada
			$codigo ='4949';
			//$codigo=codigo_hotel_activo('barcelona',$fecha);		                 
			traza_a('envioreserva.txt','calculando codigo hotel n');     
			
		break;	
		case 'madrid':                                                                                                                                                                                                        
		//Sara de Ur                          
			                           
			$codigo=codigo_hotel_activo('madrid',$fecha);                                         
			$codigo=$codigo[0];
			//echo('codigo '.$codigo);  
			//$codigo=2;                                                                                                                                                                
			//$codigo = '1111';
		break;	
		//Cantabria
		case 'cantabria':
			//$codigo = '12345';
			//$codigo=codigo_hotel_activo('cantabria',$fecha);
			$codigo='12345';
			
		break;	
		//Atalaya
		case 'andalucia':
			$codigo=codigo_hotel_activo('andalucia',$fecha);
			$codigo=$codigo[0];
			//$codigo='Atalaya2015';
			
			//$codigo = 'Atalaya2015';
		break;
		//La carreta
		case 'valencia':
			//$codigo=codigo_hotel_activo('valencia',$fecha);
			$codigo='2030';
			//$codigo= '2030';
		break;
		//La carreta
		case 'zaragoza':
			//$codigo=codigo_hotel_activo('zaragoza',$fecha);
			$codigo='2030';
			
			//$codigo= '2030';
		break;
		default:
			$codigo='';
	}			
	return $codigo;	
}  
    
  
 
  /*

function codigo_hotel_ciudad($ciudad)
{
	switch($ciudad)
	{
		case 'barcelona':
		//Ciutat d'Igualada
			$codigo ='4949';
		break;	
		case 'madrid':
		//Sara de Ur
			$codigo = '1111';
		break;	
		//Vejo
		case 'cantabria':
			$codigo = '12345';
		break;	
		//Atalaya
		case 'andalucia':
			$codigo = 'Atalaya2015';
		break;
		//La carreta
		case 'valencia':
			$codigo= '2030';
		break;
		default:
			$codigo='';
	}			
	return $codigo;	
}  
  
  */
   

 function email_hotel($h)
   {
   	switch($h){
        case '99999': //test            
		return "marctorraso@gmail.com";
        break;
        case '4949': //hotel ciutat d'igualada
            //return "reservasciutatigualada@dormicumhotels.com";  
		return "bviamonte@eada.edu";                                  
		//return "marctorraso@yahoo.es";  
        break;
        /*
		case '3939': //hotel ciutat d'igualada
            return "gestion@hoteldongonzalo.com";
        break;   
		*/ 
		case 'Atalaya2015':
			return "reservas@hotelatalaya.es";
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
			//return "marctorraso@yahoo.es";
		break;
		case '2011':
			
			//return "recepcion@hotelciutatigualada.com";
			return "bviamonte@eada.edu";
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
        case '2':
            return "info@hotelmavi.es";
			//return "marctorraso@yahoo.es";
            break;
        case '5':
            return "reservas@hotelcastillodemontemayor.com";
            break;
        default:
		   
		   return "motorclubexperience@hotmail.com";
		break;
	}
	
   }
   
  function telefono_hotel($id_hotel)    
  {
	global $link;
    $sql = ' select telefono from ps_hotel where codigo= '.$id_hotel;   
  
	$result=mysql_query($sql,$link) or die('error'.mysql_error());    
 
	$r=mysql_fetch_assoc($result);
	$telef=$r['telefono'];     
	return $telef;
  }
      

  function nombre_hotel($id_hotel)
  {
	global $link;
    $sql = ' select nombre from ps_hotel where codigo= '.$id_hotel;   
  
	$result=mysql_query($sql,$link) or die('error'.mysql_error());    
	
	$r=mysql_fetch_assoc($result);
	$nombre=$r['nombre'];     
	return $nombre;
  }
	  
  function actualizar_libres($tipo,$ciudad,$fecha,$bautizo)                                                                                                                                                                                                                                  
  { 
	global $link;  
	$hores1=seleccionar_plantilla_graella($tipo);   
         
	$hores=array();
	
	$i=0;
      
	$tarde=false;
	$manana=true; 
	$es_bautizo=es_bautizo($tipo);
    //die('esbautizo '.$es_bautizo);   
	$hores2=array();

	

	
	
	//para el caso porsche nos quedaremos sÃ³lo con ... 14:00, 14:15, 14:30, 14:45, 15:00,...	
	//para el caso corvette 20km, abriremos sÃ³lo con ... 9,10:30,11:30,13,...
	//para el caso corvette 7km, abriremos sÃ³lo con ... 15:30, 16:30, 17:30, 18:30,...		

	//Las horas que guardemos en $hores2 serÃ¡n en principio las ocupadas. 

	$i=0;
	foreach($hores1 as $h1=>$info1) 
	{

	    
	    if($h1=='c' || !$h1)
	    {
	        if ($h1=='c')
	        {
	            $tarde=true;
	            $manana=false;
	        }
	        continue;
	    }
	    	    
	    
	    $hora_h = substr($h1,0,2);
	    $hora_hc = substr($h1,0,5);  
	    $hora_min = substr($h1,3,2);  
		
		if ($h1 && $h1!='c')
		{
			//if (($tipo=='_porsche_' || $tipo=='_corvette_' ||  $tipo=='_lotus_' || $tipo=='_bporsche_' || $tipo=='_bcorvette_' || strrpos($tipo,'ruta_turistica')!==false) && $i%2)
			if (($tipo=='_porsche_' ||  $tipo=='_lotus_' || $tipo=='_bporsche_'  || strrpos($tipo,'ruta_turistica')!==false) && $i%2)			
			{
			    if ($tipo=='_porsche_')
			    {
			        if (intval($hora_h)>7)
			        {
			            $i++;
			            continue;
			        }
			        else
			        {
			             $hores2[$h1]=$info1;
			             $i++;			         
			        }
			    }   
			    else 
			    {     
				    $i++;
				    continue;
			    }
			} 
			elseif ($tipo=='_corvette_') 
			{
			    if ($manana && in_array($hora_hc,array('09:00','10:30','11:30','13:00')))
			    {    
    				$i++;
    				continue;
			    }
			    else
			    {
			        $hores2[$h1]=$info1;
			        $i++;			         
			    }
			} 
			elseif ($tipo=='_bcorvette_')                                                                                    
			{
			    if ($tarde && in_array($hora_hc,array('15:30','16:30','17:30','18:30')))
			    {
				    $i++;
				    continue;
			    }
			    else
			    {
			        $hores2[$h1]=$info1;
			        $i++;			         
			    }
			} 
			elseif (!$es_bautizo && $manana &&  intval($hora_h)<=14 && (!in_array($hora_hc,array('12:00','12:15')) || $tipo=='_porsche_'))                                                                    
			{
				$i++;
				continue;
			}  
			elseif ($es_bautizo && $tarde && !($i%2) && ($hora_h>15 || ($hora_h==15 && $hora_min>22)))   
			{
			    //array('15:07','15:22','15:37','15:52','16:07','16:22','16:37','16:52','17:07','17:22','17:37','17:52','18:07','18:22','18:37','18:52',
			    $i++;
			    continue;
			}
				
			else 
			{
				$hores2[$h1]=$info1;
				$i++;
			}
		}
		else if ($h1=='c')
		{
			$hores2[$h1]=$info1;
		}
	}
	           
	
	$i=0;

	//Ocupamos las horas segÃºn el siguiente criterio:
	
	//20km: verdes de 8 a 13:30 (12:00 - 12:45 en rojo).
	//7km: verdes de 15:30 - 20:00h (una sÃ­ una no).
	//var_dump($hores2);die;
	
    /*	        
	foreach ($hores2 as $h=>$info)         
	{  

		$hora_h = substr($h,0,2);
		$hora_min = substr($h,3,2);
		
		
		if($h=='c' || !$h) 
		{ 
			if ($h=='c')   
			{
				$tarde=true;
				$manana=false;
				$hores[$h]=$info;
			}
			continue;
		}	 
		  
		//Si es bautizo y por la tarde ocuparemos uno no y uno sÃ­ alternativamente.  
		//En este punto falta filtrar por corvette.
		if ($tarde && $es_bautizo)    
		{ 
			if ($tipo!='_bcorvette_')
			{
				if ($hora_h<15 || ($hora_h==15 && $hora_min<30))      
				{
					$hores[$h]=$info;
					$i++;							
				}
				//elseif (!($i%2) && ($hora_h>15 || $hora_h==15 && $hora_min>=30))
				//elseif (($hora_h>15 || $hora_h==15 && $hora_min>=30) && !($i%2))                
				//***** elseif (($hora_h>15 || $hora_h==15 && $hora_min>=30) )
				elseif ($hora_h>15)
				{			
					$i++;
					continue;
				}
				else 
				{
					$hores[$h]=$info;
					$i++;				
				}
			}
			else 
			{
				$hores[$h]=$info;
				$i++;				
			}
		}
		else if ($manana && !$es_bautizo)
		{
			if ($tipo!='_corvette_')
			{
				//$tipo=='_porsche_' En el caso del porsche 7km se abrirÃ¡n todas las horas (incluida la franja de las 12:00am.).
				//$tipo=='_corvette_' En el caso del corvette tambiÃ©n se abrirÃ¡n las 12
				if ($tipo=='_lotus_' || $tipo=='_bporsche_' || $tipo=='_bcorvette_' || strrpos($tipo,'ruta_turistica')!==false)              
				{
					//En el caso de porsche no se tendrÃ¡ en cuenta la franja de las 12.
					if (substr($h,0,5)!='12:00' || $tipo=='_porsche_')
					{
						$i++;
						continue;
					} 	    				
				}
				else 
				{
					//if ((substr($h,0,5)!='12:00' && substr($h,0,5)!='12:15') || $tipo=='_porsche_')    
					if ((substr($h,0,5)!='12:00' || (substr($h,0,5)==12 && $hora_min<=30)) || $tipo=='_porsche_')
					{
						$i++;
						continue;
					} 	    				
					
				}
			 
				//Si son las 12 del mediodÃ­a (12 y 12:15 para ferrari, y lambo), se marcarÃ¡ como ocupado.					
				$hores[$h]=$info;
				$i++;
			}
			else 
			{
				$hores[$h]=$info;
				$i++;
				
			}
		}
		elseif ($tarde && !$es_bautizo)
		{
			$hores[$h]=$info;
			$i++;
		}
		elseif ($manana && $es_bautizo)
		{
			$hores[$h]=$info;
			$i++;
		}
		
	}     
	
	//Recorremos todo el calendario    
    */
	
  //  var_dump($hores);die;
	
	foreach($hores2 as $hora=>$info)            
	{
		/*
		if($hora=='c' || !$hora) 
		{ 
			if ($hora=='c')   
			{
				$tarde=true;
				$manana=false;
			}
			continue;
		}
		*/
		
		$libre=true;
		
		/*
		if ($tipo=='_corvette_' || $tipo=='_bcorvette_' || $tipo='_porsche_')    
		{
			$libre=true;  
		} 
		else 
		{
			$libre=permisos($tipo,$fecha,$hora);    
		}
		*/
		
		if ($libre)  
		{				
			$id_evento = $fecha.'@'.$hora;
			$ip=GetUserIp_();
			$sql='INSERT INTO `events'.$ciudad.'` (id_event,ocupa,pilot,tipus_event,plazas,ip) VALUES("'.$id_evento.'","557","no disponible","'.$tipo.'",0,INET_ATON("'.$ip.'"))';
			$result=mysql_query($sql,$link);
		}
	}
	

				
  }

  
  
  
   
  function  normalizar($cads)
  {
    $originales =  'Ãƒâ‚¬Ãƒï¿½Ãƒâ€šÃƒÆ’Ãƒâ€žÃƒâ€¦Ãƒâ€ Ãƒâ€¡ÃƒË†Ãƒâ€°ÃƒÅ Ãƒâ€¹ÃƒÅ’Ãƒï¿½ÃƒÅ½Ãƒï¿½Ãƒï¿½Ãƒâ€˜Ãƒâ€™Ãƒâ€œÃƒâ€�Ãƒâ€¢Ãƒâ€“ÃƒËœÃƒâ„¢ÃƒÅ¡Ãƒâ€ºÃƒÅ“Ãƒï¿½ÃƒÅ¾ÃƒÅ¸ÃƒÂ ÃƒÂ¡ÃƒÂ¢ÃƒÂ£ÃƒÂ¤ÃƒÂ¥ÃƒÂ¦ÃƒÂ§ÃƒÂ¨ÃƒÂ©ÃƒÂªÃƒÂ«ÃƒÂ¬ÃƒÂ­ÃƒÂ®ÃƒÂ¯ÃƒÂ°ÃƒÂ±ÃƒÂ²ÃƒÂ³ÃƒÂ´ÃƒÂµÃƒÂ¶ÃƒÂ¸ÃƒÂ¹ÃƒÂºÃƒÂ»ÃƒÂ½ÃƒÂ½ÃƒÂ¾ÃƒÂ¿Ã…â€�Ã…â€¢';
    $modificadas = 'aaaaaaaceeeeiiiidnoooooouuuuybsaaaaaaaceeeeiiiidnoooooouuuyybyRr';
	//$str=strtr($cadena,'\t\n\r\0\x0B','     ');
	$str=strtr($cads,utf8_decode($originales),$modificadas);
	$strf='';  
	//$strf = $str;
	for($i=0;$i<strlen($str);$i++)
	{
		if (ord($str[$i])>64 and ord($str[$i])<123) $strf.= $str[$i];
	}
	//for($i=0;$i<strlen($strf);$i++) echo(ord($strf[$i]));
	//echo('<br>');
	return $strf;
  }     
  function comparar_campos($campo_origen,$campo_modificado)
  {
	return (($campo_origen != $campo_modificado)?$campo_modificado:''); 
  }
  
  function envia_password_cliente($destinatario,$passwd,$empresa)
{
	
	switch(substr($empresa,0,3))
	{
		case 'Mot':
			$email_empresa = 'info@motorclubexperience.com';
		break;
		case 'Hcc':
			$email_empresa = 'info@hccsportcars.com';
		break;	
		case 'Dre':
			$email_empresa = 'info@dreamcarsexperience.com';
		break;
		default:
			$email_empresa = 'info@motorclubexperience.com';
	}
	
	
	include_once 'class.phpmailer.php';
	include_once 'textos_mensajes.php';

	
	$mail = new PHPMailer();

    $mail->Host = "localhost";
	$mail -> CharSet = "UTF-8";
	
	
	
	$mail->From = $email_empresa;
	//"info@motorclubexperience.com";

	$mail->FromName = $empresa;
	$mail->Subject = "Alta de usuario";
   
	$body='';


	$mail->AddAddress($destinatario);  
		
	
	$body = "<strong>Al realizar la reserva se ha creado un usuario nuevo para que pueda acceder a los apartados de reservas y a las ofertas de ".$empresa.".<br><br> Sus datos de acceso son:</strong><br><br>";                                                                             
	$body .= "<strong>Usuario: ".$destinatario."</strong><br><br>";       
	$body .= "<strong>Contrase&ntilde;a: " . $passwd."</strong><br><br>";
	$body .= "<strong>un saludo,<br><br>".$empresa;
	
	//$mail->AddAddress('motorclubexperience@hotmail.com');   
	//$mail->AddAddress('info@motorclubexperience.com');       
	
	$mail -> Body = $body;
    $mail -> IsHTML(true);

    if (!$mail -> Send()) 
	{
        echo('error ' . $mail -> ErrorInfo);
        if ($nombref!='') eliminar_archivos($nombref);
        return false;
    }

	
	echo 'OK'; 
  
}

?>