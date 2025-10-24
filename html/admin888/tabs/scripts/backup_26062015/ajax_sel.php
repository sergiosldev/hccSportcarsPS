<?php
include_once('config_events.php');
include_once 'functions.php';
if(!isset($_REQUEST['ciudad']))$_REQUEST['ciudad']='';

if(!isset($_REQUEST['ciudad_origen']))$_REQUEST['ciudad_origen']='';


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

	if( $tipo=='ferrari' ){
	$t_aux='(tipus_event="ferrari" OR tipus_event="ferrari_porsche901") ';
	} elseif($tipo=='lamborghini' ){
	$t_aux='(tipus_event="lamborghini_lotus" OR tipus_event="lamborghini") ';
	}

	if( $tipo_origen=='ferrari' ){
	$t_aux_origen='(tipus_event="ferrari" OR tipus_event="ferrari_porsche901") ';
	} elseif($tipo_origen=='lamborghini' ){
	$t_aux_origen='(tipus_event="lamborghini_lotus" OR tipus_event="lamborghini") ';
	}

	
	
	if ($tipo==$tipo_origen && $_REQUEST['hora_origen'] == $_REQUEST['hora']) 
	{
		die('ERROR: debe seleccionar una hora distinta a la del evento que desea reubicar ');
	}	
	
	$sql=' SELECT * FROM  events'.$_REQUEST['ciudad'].' where id_event="'.$_REQUEST['hora'].'" AND '.$t_aux;        
	//** Fin comprobación reserva

	$result=mysql_query($sql,$link)  or die('error');   
    $r=mysql_fetch_assoc($result);

	$ciudad = (trim($_REQUEST['ciudad'])=='')?'Barcelona':$_REQUEST['ciudad'];        
	//Si no hay reserva para la hora seleccionada realizaremos la reubicación (mantendremos los datos del registro y sólo cambiaremos la fecha y hora (id_event)
	if (!$r or trim($r['email']).trim($r['email']).trim($r['email_persona_regala'])=='')                    
		{
		if (trim($tipo)!=trim($tipo_origen)) $set_tipo = ', tipus_event = "'.$tipo.'"';     
		else $set_tipo = '';
		if ($_REQUEST['ciudad'] == $_REQUEST['ciudad_origen'])
			$update=' UPDATE events'.$_REQUEST['ciudad'].' set id_event = "'.$_REQUEST['hora'].'" '.$set_tipo.' where id_event="'.$_REQUEST['hora_origen'].'" AND '.$t_aux_origen.' AND id="'.$_REQUEST['idev'].'"';                       
		/*else
			$update=' INSERT into events'.$_REQUEST['ciudad'].' SELECT * FROM events'.$_REQUEST['ciudad_origen'].' where id_event="'.$_REQUEST['hora_origen'].'" AND '.$t_aux_origen;                
		*/
				//die($update);
		//echo($update);
		$result=mysql_query($update,$link)  or die('error');   
		die ('El evento '.$_REQUEST['tipo_origen'].' de '.$ciudad.' ha sido reubicado ');
		}
    else die('ERROR: el evento ya está ocupado para '.$ciudad.', para la fecha: '.$_REQUEST['hora'].' Y el tipo de evento '.$_REQUEST['tipo'].' '.$sql);   
	
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
   

?>