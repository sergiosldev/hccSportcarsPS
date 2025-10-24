<?php
include_once('config_events_new.php');
include_once 'functions.php';
include_once('../../../scripts/ip_functions.php');
if(!isset($_REQUEST['ciudad']))$_REQUEST['ciudad']='';

if(!isset($_REQUEST['ciudad_origen']))$_REQUEST['ciudad_origen']='';

$ip=GetUserIp_(); 

if(isset($_REQUEST['id_reubica']))  
{ 
    /*if(!porsche())die('Error de programa no se pueden introducir los datos');
    
    if($_REQUEST['tipus']=='porsche996'){
         $sql='SELECT i.* FROM `events'.$_REQUEST['ciudad'].'` as i WHERE ( i.id_event="'.$_REQUEST['id_alta'].'") AND 
     (i.tipus_event="porsche996" ) ';
     $result=mysql_query($sql);
     if(mysql_num_rows($result))$_REQUEST['tipus']='porsche997';
    }
    
                     
   
    if(trim($_REQUEST['origen']=='OTROS'))$_REQUEST['origen']=$_REQUEST['otros'];
    */    
    //Comprobamos si la fecha y hora en la que queremos reubicar tiene alguna reserva.
	//** Inicio comprobación reserva
	
	$tipo=$_REQUEST['tipo'];  
	$tipo_origen = $_REQUEST['tipo_origen'];

	
	
	$perms=permisos($tipo,$_REQUEST['data'],$hora_bona);   
	
	if (marca_bautizo($_REQUEST['data'],$hora_bona,$tipo))
		$bautizo=true;
	else $bautizo=false;
	
	
	$t_aux='tipus_event="'.$tipo.'"';
	$t_aux_origen='tipus_event="'.$tipo_origen.'"';

	if( $tipo=='_porsche_'  || $tipo=='porsche')
	{
		$t_aux='(tipus_event like "%porsche%" and tipus_event not like "%ferrari%" and tipus_event not like "%lamborghini%") ';
	}
	elseif($tipo=='_corvette_' || $tipo=='corvette')
	{
		$t_aux='(tipus_event like "%corvette%" and tipus_event not like "%ferrari%" and tipus_event not like "%lamborghini%") ';  
	}
	elseif( $tipo=='ferrari' )
	{
		$t_aux='(tipus_event="ferrari" OR tipus_event="ferrari_porsche901") ';
	} 
	elseif($tipo=='lamborghini' )
	{
		$t_aux='(tipus_event="lamborghini_lotus" OR tipus_event="lamborghini") ';
	}

	if( $tipo_origen=='_porsche_' || $tipo_origen=='porsche')
	{
		$t_aux_origen='(tipus_event like "%porsche%" and tipus_event not like "%ferrari%" and tipus_event not like "%lamborghini%") ';
	}
	elseif($tipo_origen=='_corvette_' || $tipo_origen=='corvette')     
	{
		$t_aux_origen='(tipus_event like "%corvette%" and tipus_event not like "%ferrari%" and tipus_event not like "%lamborghini%") ';    
	}
	elseif( $tipo_origen=='ferrari' )
	{
		$t_aux_origen='(tipus_event="ferrari" OR tipus_event="ferrari_porsche901") ';
	} 
	elseif($tipo_origen=='lamborghini' )
	{
		$t_aux_origen='(tipus_event="lamborghini_lotus" OR tipus_event="lamborghini") ';
	}


	
	
	if ($ciudad==$_REQUEST['ciudad'] && $tipo==$tipo_origen && $_REQUEST['hora_origen'] == $_REQUEST['hora'])                                    
	{    
		die('ERROR: debe seleccionar una hora distinta a la del evento que desea reubicar ');            
	}   	
	
	$sql1=' SELECT * FROM  events'.$_REQUEST['ciudad_origen'].' where id_event="'.$_REQUEST['hora_origen'].'" AND '.$t_aux_origen;          
	
	$sql=' SELECT * FROM  events'.$_REQUEST['ciudad'].' where id_event="'.$_REQUEST['hora'].'" AND '.$t_aux;          
	
	
	
	
	//die('error '.$sql);
	//** Fin comprobación reserva
	$result1=mysqli_query($link,$sql1)  or die('error');    
    $r1=mysqli_fetch_assoc($result1);

	
	$result=mysqli_query($link,$sql)  or die('error');    
    $r=mysqli_fetch_assoc($result);

	$ciudad = (trim($_REQUEST['ciudad'])=='')?'Barcelona':$_REQUEST['ciudad'];
	$ciudad_origen = (trim($_REQUEST['ciudad_origen'])=='')?'Barcelona':$_REQUEST['ciudad_origen'];  
	$email_piloto=trim($r1['email']);
	$email_persona_regala=trim($r1['email_persona_regala']);
	$email_confirm=trim($r1['email_confirm']);
	//Si no hay reserva para la hora seleccionada realizaremos la reubicación (mantendremos los datos del registro y sólo cambiaremos la fecha y hora (id_event)
	
	$shora=explode('@',$_REQUEST['hora']);                        
	$shora=$shora[0].' '.$shora[1];  
	$shora_origen=explode('@',$_REQUEST['hora_origen']);                                                 
	$shora_origen=$shora_origen[0].' '.$shora_origen[1];                                             

	$sreubicado=$r1['reubicado'];
	
	if (!$r or trim($r['email']).trim($r['email']).trim($r['email_persona_regala'])=='')                    
	{
		if (trim($tipo)!=trim($tipo_origen)) $set_tipo = ', tipus_event = "'.$tipo.'"';                                                                                  
		else $set_tipo = '';                 
		if ($_REQUEST['ciudad'] == $_REQUEST['ciudad_origen'])
		{
			$update=' UPDATE events'.$_REQUEST['ciudad'].' set id_event = "'.$_REQUEST['hora'].'" '.$set_tipo.' where id_event="'.$_REQUEST['hora_origen'].'" AND '.$t_aux_origen.' AND id="'.$_REQUEST['idev'].'"  ';          
			/*if ($id=='83.40.145.49')
			{
			die($update);
			}*/
			
			$delete='';
		}
		else 
		{
		    $update =' INSERT INTO events'.$_REQUEST['ciudad'].' 
		        (id_event,email,telefon,telefon_fixe,codi_localtzador,codi_consum,pilot,apellidos_piloto,dia,persona_regala,
		         apellidos_persona_regala,mobil_persona_regala,fixe_persona_regala,email_persona_regala,tipus_event,coches,
		         Observaciones,marcat,origen,plazas,ocupa,email_confirm,socio,data_reserva,data_caducitat_cupo,ip,cupon,nif,
		         alojamiento,spa,persona_hotel,fecha_entrada,fecha_salida,id_event_ant,tipo_servicio,id_hotel,nombre_hotel,reubicado) 
		         SELECT "'.$_REQUEST['hora'].'",email,telefon,telefon_fixe,codi_localtzador,codi_consum,pilot,apellidos_piloto,
		         dia,persona_regala,apellidos_persona_regala,mobil_persona_regala,fixe_persona_regala,email_persona_regala,
		         "'.$tipo.'",coches,Observaciones,marcat,origen,plazas,ocupa,email_confirm,socio,data_reserva,
		         data_caducitat_cupo,ip,cupon,nif,alojamiento,spa,persona_hotel,fecha_entrada,fecha_salida,id_event_ant,
		         tipo_servicio,id_hotel,nombre_hotel,reubicado
		         FROM events'.$_REQUEST['ciudad_origen'].' co 
		         WHERE co.id_event = "'.$_REQUEST['hora_origen'].'" AND '.$t_aux_origen.' AND  id="'.$_REQUEST['idev'].'"';     

		         $delete = ' DELETE FROM events'.$_REQUEST['ciudad_origen'].' 
                 WHERE id_event = "'.$_REQUEST['hora_origen'].'" AND '.$t_aux_origen.' AND  id="'.$_REQUEST['idev'].'"';		             
                 		                 
		}
		
		
		
		
		if (substr($_REQUEST['hora_origen'],0,4)==1900)
		{
			$delete_limbo = ' delete from limbo where id_evento='.$_REQUEST['idev'].' and ciudad_evento = "'.$_REQUEST['ciudad_origen'].'"';                       
		}
		else
		{
			$delete_limbo='';
		}
		

		    
		/*else
			$update=' INSERT into events'.$_REQUEST['ciudad'].' SELECT * FROM events'.$_REQUEST['ciudad_origen'].' where id_event="'.$_REQUEST['hora_origen'].'" AND '.$t_aux_origen;                
		*/
				//die($update);
		//echo($update);
		     
		$result=mysqli_query($link,$update)  or die('error');

		$id="";
		
		
		
		if ($delete!='')      
		{
		  $id=mysqli_insert_id($link);   
		  $result=mysqli_query($link,$delete)  or die('error');     
		}  
		        
		if ($delete_limbo!='')
		{
			//die('error '.$delete_limbo);
			$result=mysqli_query($link,$delete_limbo)  or die('error');            
		}
		
		//Guardamos un registro en el histórico de reubicaciones.
				
		$sid=($id=='')?$_REQUEST['idev']:$id;              
		
		if (!$sreubicado)  
		{
			$seguimiento=time();                            
			$updater=' UPDATE events'.$_REQUEST['ciudad'].' set reubicado='.$seguimiento.' where id_event="'.$_REQUEST['hora'].'" AND  id="'.$sid.'"  ';          
			//die('error '.$updater);
			$result_r=mysqli_query($link,$updater)  or die('error ');                      
		}
		else
		{
			$seguimiento=$sreubicado;  
		}
		
		
		
		$insert_reubic = ' INSERT into reubicaciones (fecha,id_evento_origen,ciudad_origen,fecha_origen,tipo_origen,                                                                      
														  id_evento_destino,ciudad_destino,fecha_destino,tipo_destino,ip,seguimiento,email_piloto,email_persona_regala,email_confirm)                                                                                           
										   values		 (now(),"'.$_REQUEST['idev'].'","'.$_REQUEST['ciudad_origen'].'","'.$shora_origen.'","'.$tipo_origen.'",                    
														  "'.$sid.'","'.$_REQUEST['ciudad'].'","'.$shora.'","'.$tipo.'",inet_aton("'.$ip.'"),"'.$seguimiento.'","'.$email_piloto.'","'.$email_persona_regala.'","'.$email_confirm.'"); '; 
		
		$result=mysqli_query($link,$insert_reubic)  or die('error '.$insert_reubic);                   
		
		die ($id.'#El evento '.$_REQUEST['tipo_origen'].' de '.$ciudad_origen.' ha sido reubicado ');                            
	}
    else 
	{
		die('ERROR: el evento ya está ocupado para '.$ciudad.', para la fecha: '.$_REQUEST['hora'].' Y el tipo de evento '.$_REQUEST['tipo'].' '.$sql);   
	}	
	 
}

   function porsche()
     {
     global $link;
    /*
 if($_REQUEST['tipus']=='porsche997' || $_REQUEST['tipus']=='porsche996'){    
     $sql='SELECT i.* FROM `events` as i WHERE i.id_event="'.$_REQUEST['id_alta'].'" AND tipus_event="'.$_REQUEST['tipus'].'"';
     $result=mysql_query($sql);
     if(mysql_num_rows($result))return false;
     }
*/
     if($_REQUEST['tipus']=='porsche997_porsche996'){    
     $sql='SELECT i.* FROM `events'.$_REQUEST['ciudad'].'` as i WHERE i.id_event="'.$_REQUEST['id_alta'].'" AND (tipus_event="porsche996" OR tipus_event="porsche997") ';
     $result=mysqli_query($link,$sql);
     if(mysqli_num_rows($result))return false;
     }
     return true;
     }
   

?>