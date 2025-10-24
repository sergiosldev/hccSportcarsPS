<?php
include_once(dirname(__FILE__).'/../../../config/config.inc.php');	     																                                                                                    

$usuario = tools::getValue('usuario');             
$ip=tools::GetUserIp();                                 
 
$sql='';                                                                                                                                    

seleccion_plantilla($asunto_plantilla,$body_plantilla);		                                                                                     
 
$seleccion_piloto = false;                         
$seleccion_persona_regala = false;                                     
$seleccion_confirm = false;       
$seleccion_usuario=false;                    
$max_emails_por_ejecucion = 20;	

if ($_REQUEST['sel_cliente']!='')                                                                             
{                                
	switch($_REQUEST['sel_cliente'])   
	{
		case 'email_piloto':  
			$seleccion_piloto=true;
			break;
		case 'email_persona_regala':  
			$seleccion_persona_regala=true;
			break;
		case 'email_confirm':  
			$seleccion_confirm=true;
			break;
		case 'email_usuario':  
			$seleccion_usuario=true;
			break;
			default:
	}
}

if(isset($_REQUEST['emails_all']))  
{    
  $where1=' where (trim(e.email)!="" or trim(email_confirm)!="" or trim(email_persona_regala)!="")  ';      
  $where2=' where (trim(em.email)!="" or trim(email_confirm)!="" or trim(email_persona_regala)!="")  ';
  $where3=' where (trim(ev.email)!="" or trim(email_confirm)!="" or trim(email_persona_regala)!="")  ';
  $where4=' where (trim(ea.email)!="" or trim(email_confirm)!="" or trim(email_persona_regala)!="")  ';
  $where5=' where (trim(ec.email)!="" or trim(email_confirm)!="" or trim(email_persona_regala)!="")  ';  


if ($_REQUEST['tipo_todos']=='')     
{
$where12='';
$where22='';
$where32='';
$where42='';
$where52='';
if ($_REQUEST['tipo_ferrari']!='')     
{
	if ($where12=='')
	{
	$where12=' and (e.tipus_event in ("_bferrari_","ferrari","ferrari_porsche901") ';   
	$where22=' and (em.tipus_event in ("_bferrari_","ferrari","ferrari_porsche901") ';   
	$where32=' and (ev.tipus_event in ("_bferrari_","ferrari","ferrari_porsche901") ';       
	$where42=' and (ea.tipus_event in ("_bferrari_","ferrari","ferrari_porsche901") ';    
	$where52=' and (ec.tipus_event in ("_bferrari_","ferrari","ferrari_porsche901") ';       
	}
	else 
	{
	$where12.=' or e.tipus_event in ("_bferrari_","ferrari","ferrari_porsche901") ';   
	$where22.=' or em.tipus_event in ("_bferrari_","ferrari","ferrari_porsche901") ';   
	$where32.=' or ev.tipus_event in ("_bferrari_","ferrari","ferrari_porsche901") ';       
	$where42.=' or ea.tipus_event in ("_bferrari_","ferrari","ferrari_porsche901") ';    
	$where52.=' or ec.tipus_event in ("_bferrari_","ferrari","ferrari_porsche901") ';       
	}
}			
if ($_REQUEST['tipo_lambo']!='')   
{
	if ($where12=='')
	{
	$where12=' and (e.tipus_event in ("_blamborghini_","lamborghini","lamborghini_lotus") ';   
	$where22=' and (em.tipus_event in ("_blamborghini_","lamborghini","lamborghini_lotus") ';   
	$where32=' and (ev.tipus_event in ("_blamborghini_","lamborghini","lamborghini_lotus")';       
	$where42=' and (ea.tipus_event in ("_blamborghini_","lamborghini","lamborghini_lotus") ';    
	$where52=' and (ec.tipus_event in ("_blamborghini_","lamborghini","lamborghini_lotus") ';       
	}
	else 
	{
	$where12.=' or e.tipus_event in ("_blamborghini_","lamborghini","lamborghini_lotus") ';   
	$where22.=' or em.tipus_event in ("_blamborghini_","lamborghini","lamborghini_lotus") ';   
	$where32.=' or ev.tipus_event in ("_blamborghini_","lamborghini","lamborghini_lotus") ';       
	$where42.=' or ea.tipus_event in ("_blamborghini_","lamborghini","lamborghini_lotus") ';    
	$where52.=' or ec.tipus_event in ("_blamborghini_","lamborghini","lamborghini_lotus") ';       
	}
}			
if ($_REQUEST['tipo_porsche']!='')   
{
	if ($where12=='')
	{
	$where12=' and (e.tipus_event in ("_bporsche_","_porsche_","porsche997","porsche996") ';   
	$where22=' and (em.tipus_event in ("_bporsche_","_porsche_","porsche997","porsche996") ';   
	$where32=' and (ev.tipus_event in ("_bporsche_","_porsche_","porsche997","porsche996")';       
	$where42=' and (ea.tipus_event in ("_bporsche_","_porsche_","porsche997","porsche996") ';    
	$where52=' and (ec.tipus_event in ("_bporsche_","_porsche_","porsche997","porsche996") ';       
	}
	else 
	{
	$where12.=' or e.tipus_event in ("_bporsche_","_porsche_","porsche997","porsche996") ';   
	$where22.=' or em.tipus_event in ("_bporsche_","_porsche_","porsche997","porsche996") ';   
	$where32.=' or ev.tipus_event in ("_bporsche_","_porsche_","porsche997","porsche996") ';       
	$where42.=' or ea.tipus_event in ("_bporsche_","_porsche_","porsche997","porsche996") ';    
	$where52.=' or ec.tipus_event in ("_bporsche_","_porsche_","porsche997","porsche996")';       
	}
}			
	
  if ($_REQUEST['tipo_corvette']!='')   
	{
		if ($where12=='')
		{
			$where12=' and (e.tipus_event in ("_bcorvette_","_corvette_") ';   
			$where22=' and (em.tipus_event in ("_bcorvette_","_corvette_") ';   
			$where32=' and (ev.tipus_event in ("_bcorvette_","_corvette_")';       
			$where42=' and (ea.tipus_event in ("_bcorvette_","_corvette_") ';    
			$where52=' and (ec.tipus_event in ("_bcorvette_","_corvette_") ';       
		}
		else 
		{
			$where12.=' or e.tipus_event in ("_bcorvette_","_corvette_") ';   
			$where22.=' or em.tipus_event in ("_bcorvette_","_corvette_") ';   
			$where32.=' or ev.tipus_event in ("_bcorvette_","_corvette_") ';       
			$where42.=' or ea.tipus_event in ("_bcorvette_","_corvette_") ';    
			$where52.=' or ec.tipus_event in ("_bcorvette_","_corvette_")';       
		}
	}			
  }	

  if ($where12!='')
  {
	$where1.=$where12.')';
	$where2.=$where22.')';
	$where3.=$where32.')';
	$where4.=$where42.')';
	$where5.=$where52.')';
  }
  
	
  if ($_REQUEST['fdesde']!='') 
	{
	 $where1 .=  ' and date(substring(e.id_event,1,10))>=date("'.$_REQUEST['fdesde'].'")';         
	 $where2 .=  ' and date(substring(em.id_event,1,10))>=date("'.$_REQUEST['fdesde'].'")';   
	 $where3 .=  ' and date(substring(ev.id_event,1,10))>=date("'.$_REQUEST['fdesde'].'")';   
	 $where4 .=  ' and date(substring(ea.id_event,1,10))>=date("'.$_REQUEST['fdesde'].'")';
	 $where5 .=  ' and date(substring(ec.id_event,1,10))>=date("'.$_REQUEST['fdesde'].'")';
	}
  if ($_REQUEST['fhasta']!='') 
	{
	 $where1 .=  ' and date(substring(e.id_event,1,10))<=date("'.$_REQUEST['fhasta'].'")';
	 $where2 .=  ' and date(substring(em.id_event,1,10))<=date("'.$_REQUEST['fhasta'].'")';
	 $where3 .=  ' and date(substring(ev.id_event,1,10))<=date("'.$_REQUEST['fhasta'].'")';
	 $where4 .=  ' and date(substring(ea.id_event,1,10))<=date("'.$_REQUEST['fhasta'].'")';
	 $where5 .=  ' and date(substring(ec.id_event,1,10))<=date("'.$_REQUEST['fhasta'].'")';
	} 


  if ($_REQUEST['hdesde']!='' && $_REQUEST['hdesde']!='0') 
	{
	$where1 .=  ' and concat(substring(e.id_event,1,10),\' \',substring(e.id_event,12,5)) >= "'.$_REQUEST['fdesde'].' '.$_REQUEST['hdesde'].'"';  
	$where2 .=  ' and concat(substring(em.id_event,1,10),\' \',substring(em.id_event,12,5)) >= "'.$_REQUEST['fdesde'].' '.$_REQUEST['hdesde'].'"';
	$where3 .=  ' and concat(substring(ev.id_event,1,10),\' \',substring(ev.id_event,12,5)) >= "'.$_REQUEST['fdesde'].' '.$_REQUEST['hdesde'].'"';
	$where4 .=  ' and concat(substring(ea.id_event,1,10),\' \',substring(ea.id_event,12,5)) >= "'.$_REQUEST['fdesde'].' '.$_REQUEST['hdesde'].'"';
	$where5 .=  ' and concat(substring(ec.id_event,1,10),\' \',substring(ec.id_event,12,5)) >= "'.$_REQUEST['fdesde'].' '.$_REQUEST['hdesde'].'"';   
	}
  if ($_REQUEST['hhasta']!='' && $_REQUEST['hhasta']!='0')   
	{
	$where1 .=  ' and concat(substring(e.id_event,1,10),\' \',substring(e.id_event,12,5)) <= "'.$_REQUEST['fhasta'].' '.$_REQUEST['hhasta'].'"';
	$where2 .=  ' and concat(substring(em.id_event,1,10),\' \',substring(em.id_event,12,5)) <= "'.$_REQUEST['fhasta'].' '.$_REQUEST['hhasta'].'"';
	$where3 .=  ' and concat(substring(ev.id_event,1,10),\' \',substring(ev.id_event,12,5)) <= "'.$_REQUEST['fhasta'].' '.$_REQUEST['hhasta'].'"';
	$where4 .=  ' and concat(substring(ea.id_event,1,10),\' \',substring(ea.id_event,12,5)) <= "'.$_REQUEST['fhasta'].' '.$_REQUEST['hhasta'].'"';
	$where5 .=  ' and concat(substring(ec.id_event,1,10),\' \',substring(ec.id_event,12,5)) <= "'.$_REQUEST['fhasta'].' '.$_REQUEST['hhasta'].'"';
	
	} 
	
  
  $sql='
  
  SELECT pilot,telefon,persona_regala,mobil_persona_regala,e.email,email_persona_regala,email_confirm,u.email email_usuario from events e left join ps_usuarios u on e.id_usuario=u.id_usuario '.$where1.'
  UNION ALL
  SELECT pilot,telefon,persona_regala,mobil_persona_regala,em.email,email_persona_regala,email_confirm,u.email email_usuario  from eventsmadrid em  left join ps_usuarios u on em.id_usuario=u.id_usuario '.$where2.' 
  UNION ALL
  SELECT pilot,telefon,persona_regala,mobil_persona_regala,ev.email,email_persona_regala,email_confirm,u.email email_usuario  from eventsvalencia ev  left join ps_usuarios u on ev.id_usuario=u.id_usuario '.$where3.' 
  UNION ALL
  SELECT pilot,telefon,persona_regala,mobil_persona_regala,ea.email,email_persona_regala,email_confirm,u.email email_usuario  from eventsandalucia ea  left join ps_usuarios u on ea.id_usuario=u.id_usuario '.$where4.' 
  UNION ALL
  SELECT pilot,telefon,persona_regala,mobil_persona_regala,ec.email,email_persona_regala,email_confirm,u.email email_usuario  from eventscantabria ec  left join ps_usuarios u on ec.id_usuario=u.id_usuario '.$where5.'         
  ';
    
  //die($sql);
  //$result=mysql_query($sql); 
  $dbi=db::getInstance();
  $result=$dbi->executeS($sql);
  
  unset($dbi);
  
  
  
}

elseif(isset($_REQUEST['emails_bcn']))
  {
  $where = ' where (trim(e.email)!="" or trim(email_confirm)!="" or trim(email_persona_regala)!="")   ';
  
    if ($_REQUEST['tipo_todos']=='')     
	  {
	  $where2='';
	  if ($_REQUEST['tipo_ferrari']!='')     
		{	
			if ($where2=='')
			{
				$where2=' and ( tipus_event in ("_bferrari_","ferrari","ferrari_porsche901") ';   
			}
			else 
			{
				$where2.=' or tipus_event in ("_bferrari_","ferrari","ferrari_porsche901") ';   
			}
		}			
	  if ($_REQUEST['tipo_lambo']!='')   
		{
			if ($where2=='')
			{
				$where2=' and ( tipus_event in ("_blamborghini_","lamborghini","lamborghini_lotus") ';   
			}
			else 
			{
				$where2.=' or tipus_event in ("_blamborghini_","lamborghini","lamborghini_lotus") ';   
			}
		}
	  if ($_REQUEST['tipo_porsche']!='')   
		{
			if ($where2=='')
			{
				$where2=' and ( tipus_event in ("_bporsche_","_porsche_","porsche997","porsche996") ';   
			}
			else 
			{
				$where2.=' or tipus_event in ("_bporsche_","_porsche_","porsche997","porsche996") ';   
			}
		}
		
	  if ($_REQUEST['tipo_corvette']!='')   
		{
			if ($where2=='')
			{
				$where2=' and ( tipus_event in ("_bcorvette_","_corvette_") ';   
			}
			else 
			{
				$where2.=' or tipus_event in ("_bcorvette_","_corvette_") ';   
			}
		}
		if ($where2!='') $where.=$where2.')';
  }  

  if ($_REQUEST['fdesde']!='') $where .=  ' and date(substring(id_event,1,10))>=date("'.$_REQUEST['fdesde'].'")';
  if ($_REQUEST['fhasta']!='') $where .=  ' and date(substring(id_event,1,10))<=date("'.$_REQUEST['fhasta'].'")';
  if ($_REQUEST['hdesde']!='' && $_REQUEST['hdesde']!='0') 
	$where .=  ' and concat(substring(id_event,1,10),\' \',substring(id_event,12,5)) >= "'.$_REQUEST['fdesde'].' '.$_REQUEST['hdesde'].'"';
  if ($_REQUEST['hhasta']!='' && $_REQUEST['hhasta']!='0') 
	$where .=  ' and concat(substring(id_event,1,10),\' \',substring(id_event,12,5)) <= "'.$_REQUEST['fhasta'].' '.$_REQUEST['hhasta'].'"';
    
  $sql='
  SELECT pilot,telefon,persona_regala,mobil_persona_regala,e.email,email_persona_regala,email_confirm,u.email email_usuario from events e  left join ps_usuarios u on e.id_usuario=u.id_usuario '.$where.' 
  ';
  //die($sql);
  $dbi=db::getInstance();
  $result=$dbi->executeS($sql);
  
  unset($dbi);
}

elseif(isset($_REQUEST['emails_mad']))
  {
  $where = ' where (trim(e.email)!="" or trim(email_confirm)!="" or trim(email_persona_regala)!="")   ';
  if ($_REQUEST['tipo_todos']=='')     
  {
  $where2='';
  if ($_REQUEST['tipo_ferrari']!='')     
	{	
		if ($where2=='')
		{
			$where2=' and ( tipus_event in ("_bferrari_","ferrari","ferrari_porsche901") ';   
		}
		else 
		{
			$where2.=' or tipus_event in ("_bferrari_","ferrari","ferrari_porsche901") ';   
		}
	}			
  if ($_REQUEST['tipo_lambo']!='')   
	{
		if ($where2=='')
		{
			$where2=' and ( tipus_event in ("_blamborghini_","lamborghini","lamborghini_lotus") ';   
		}
		else 
		{
			$where2.=' or tipus_event in ("_blamborghini_","lamborghini","lamborghini_lotus") ';   
		}
	}
  if ($_REQUEST['tipo_porsche']!='')   
	{
		if ($where2=='')
		{
			$where2=' and ( tipus_event in ("_bporsche_","_porsche_","porsche997","porsche996") ';   
		}
		else 
		{
			$where2.=' or tipus_event in ("_bporsche_","_porsche_","porsche997","porsche996") ';   
		}
	}
	
  if ($_REQUEST['tipo_corvette']!='')   
	{
		if ($where2=='')
		{
			$where2=' and ( tipus_event in ("_bcorvette_","_corvette_") ';   
		}
		else 
		{
			$where2.=' or tipus_event in ("_bcorvette_","_corvette_") ';   
		}
	}
	if ($where2!='') $where.=$where2.')';
  }  
  if ($_REQUEST['fdesde']!='') $where .=  ' and date(substring(id_event,1,10))>=date("'.$_REQUEST['fdesde'].'")';                        
  if ($_REQUEST['fhasta']!='') $where .=  ' and date(substring(id_event,1,10))<=date("'.$_REQUEST['fhasta'].'")';               
  if ($_REQUEST['hdesde']!='' && $_REQUEST['hdesde']!='0') 
	$where .=  ' and concat(substring(id_event,1,10),\' \',substring(id_event,12,5)) >= "'.$_REQUEST['fdesde'].' '.$_REQUEST['hdesde'].'"';
  if ($_REQUEST['hhasta']!='' && $_REQUEST['hhasta']!='0') 
	$where .=  ' and concat(substring(id_event,1,10),\' \',substring(id_event,12,5)) <= "'.$_REQUEST['fhasta'].' '.$_REQUEST['hhasta'].'"';
    
  $sql='
  SELECT pilot,telefon,persona_regala,mobil_persona_regala,e.email,email_persona_regala,email_confirm,u.email email_usuario from eventsmadrid  e left join ps_usuarios u on e.id_usuario=u.id_usuario '.$where.'
  ';
 
  
  $dbi=db::getInstance();                                                 
  
  $result=$dbi->executeS($sql);
  
  unset($dbi);
}


elseif(isset($_REQUEST['emails_val']))
  {
  $where = ' where (trim(e.email)!="" or trim(email_confirm)!="" or trim(email_persona_regala)!="")    ';
  if ($_REQUEST['tipo_todos']=='')     
  {
  $where2='';
  if ($_REQUEST['tipo_ferrari']!='')     
	{	
		if ($where2=='')
		{
			$where2=' and ( tipus_event in ("_bferrari_","ferrari","ferrari_porsche901") ';   
		}
		else 
		{
			$where2.=' or tipus_event in ("_bferrari_","ferrari","ferrari_porsche901") ';   
		}
	}			
  if ($_REQUEST['tipo_lambo']!='')   
	{
		if ($where2=='')
		{
			$where2=' and ( tipus_event in ("_blamborghini_","lamborghini","lamborghini_lotus") ';   
		}
		else 
		{
			$where2.=' or tipus_event in ("_blamborghini_","lamborghini","lamborghini_lotus") ';   
		}
	}
  if ($_REQUEST['tipo_porsche']!='')   
	{
		if ($where2=='')
		{
			$where2=' and ( tipus_event in ("_bporsche_","_porsche_","porsche997","porsche996") ';   
		}
		else 
		{
			$where2.=' or tipus_event in ("_bporsche_","_porsche_","porsche997","porsche996") ';   
		}
	}
	
  if ($_REQUEST['tipo_corvette']!='')   
	{
		if ($where2=='')
		{
			$where2=' and ( tipus_event in ("_bcorvette_","_corvette_") ';   
		}
		else 
		{
			$where2.=' or tipus_event in ("_bcorvette_","_corvette_") ';   
		}
	}
	if ($where2!='') $where.=$where2.')';
  }   
  if ($_REQUEST['fdesde']!='') $where .=  ' and date(substring(id_event,1,10))>=date("'.$_REQUEST['fdesde'].'")';                
  if ($_REQUEST['fhasta']!='') $where .=  ' and date(substring(id_event,1,10))<=date("'.$_REQUEST['fhasta'].'")';         
  if ($_REQUEST['hdesde']!='' && $_REQUEST['hdesde']!='0') 
	$where .=  ' and concat(substring(id_event,1,10),\' \',substring(id_event,12,5)) >= "'.$_REQUEST['fdesde'].' '.$_REQUEST['hdesde'].'"';
  if ($_REQUEST['hhasta']!='' && $_REQUEST['hhasta']!='0') 
	$where .=  ' and concat(substring(id_event,1,10),\' \',substring(id_event,12,5)) <= "'.$_REQUEST['fhasta'].' '.$_REQUEST['hhasta'].'"';
    
  $sql='
  SELECT pilot,telefon,persona_regala,mobil_persona_regala,e.email,email_persona_regala,email_confirm,u.email email_usuario from eventsvalencia e left join ps_usuarios u on e.id_usuario=u.id_usuario '.$where.'
  ';
  $dbi=db::getInstance();	
  $result=$dbi->executeS($sql);
  
  unset($dbi);
}


elseif(isset($_REQUEST['emails_and']))
  {
  $where = ' where (trim(e.email)!="" or trim(email_confirm)!="" or trim(email_persona_regala)!="")  ';          
  if ($_REQUEST['tipo_todos']=='')     
  {
  $where2='';
  if ($_REQUEST['tipo_ferrari']!='')     
	{	
		if ($where2=='')
		{
			$where2=' and ( tipus_event in ("_bferrari_","ferrari","ferrari_porsche901") ';   
		}
		else 
		{
			$where2.=' or tipus_event in ("_bferrari_","ferrari","ferrari_porsche901") ';   
		}
	}			
  if ($_REQUEST['tipo_lambo']!='')                                                                                                       
	{
		if ($where2=='')
		{
			$where2=' and ( tipus_event in ("_blamborghini_","lamborghini","lamborghini_lotus") ';   
		}
		else 
		{
			$where2.=' or tipus_event in ("_blamborghini_","lamborghini","lamborghini_lotus") ';   
		}
	}
  if ($_REQUEST['tipo_porsche']!='')                
	{
		if ($where2=='')
		{
			$where2=' and ( tipus_event in ("_bporsche_","_porsche_","porsche997","porsche996") ';   
		}
		else 
		{
			$where2.=' or tipus_event in ("_bporsche_","_porsche_","porsche997","porsche996") ';   
		}
	}
	
  if ($_REQUEST['tipo_corvette']!='')       
	{  
		if ($where2=='')
		{
			$where2=' and ( tipus_event in ("_bcorvette_","_corvette_") ';   
		}
		else 
		{
			$where2.=' or tipus_event in ("_bcorvette_","_corvette_") ';   
		}
	}
	if ($where2!='') $where.=$where2.')';
  }   
  
  if ($_REQUEST['fdesde']!='') $where .=  ' and date(substring(id_event,1,10))>=date("'.$_REQUEST['fdesde'].'")';    
  if ($_REQUEST['fhasta']!='') $where .=  ' and date(substring(id_event,1,10))<=date("'.$_REQUEST['fhasta'].'")';
  if ($_REQUEST['hdesde']!='' && $_REQUEST['hdesde']!='0') 
	$where .=  ' and concat(substring(id_event,1,10),\' \',substring(id_event,12,5)) >= "'.$_REQUEST['fdesde'].' '.$_REQUEST['hdesde'].'"';  
  if ($_REQUEST['hhasta']!='' && $_REQUEST['hhasta']!='0') 
	$where .=  ' and concat(substring(id_event,1,10),\' \',substring(id_event,12,5)) <= "'.$_REQUEST['fhasta'].' '.$_REQUEST['hhasta'].'"';  
  
  $sql='
  SELECT id_event,pilot,email_persona_regala,e.email,email_confirm,e.email,email_persona_regala,email_confirm,u.email email_usuario from eventsandalucia  e left join ps_usuarios u on e.id_usuario=u.id_usuario '.$where.'
  ';
  
  $dbi=db::getInstance();
  $result=$dbi->executeS($sql);
  
  unset($dbi);
 
 }	  
elseif(isset($_REQUEST['emails_can']))
  {
  $where = ' where (trim(e.email)!="" or trim(email_confirm)!="" or trim(email_persona_regala)!="")  ';
  	
  if ($_REQUEST['tipo_todos']=='')     
  {
  $where2='';
  if ($_REQUEST['tipo_ferrari']!='')     
	{	
		if ($where2=='')
		{
			$where2=' and ( tipus_event in ("_bferrari_","ferrari","ferrari_porsche901") ';   
		}
		else 
		{
			$where2.=' or tipus_event in ("_bferrari_","ferrari","ferrari_porsche901") ';   
		}
	}			
  if ($_REQUEST['tipo_lambo']!='')   
	{
		if ($where2=='')
		{
			$where2=' and ( tipus_event in ("_blamborghini_","lamborghini","lamborghini_lotus") ';   
		}
		else 
		{
			$where2.=' or tipus_event in ("_blamborghini_","lamborghini","lamborghini_lotus") ';   
		}
	}
  if ($_REQUEST['tipo_porsche']!='')   
	{
		if ($where2=='')
		{
			$where2=' and ( tipus_event in ("_bporsche_","_porsche_","porsche997","porsche996") ';   
		}
		else 
		{
			$where2.=' or tipus_event in ("_bporsche_","_porsche_","porsche997","porsche996") ';   
		}
	}
	
  if ($_REQUEST['tipo_corvette']!='')   
	{
		if ($where2=='')
		{
			$where2=' and ( tipus_event in ("_bcorvette_","_corvette_") ';   
		}
		else 
		{
			$where2.=' or tipus_event in ("_bcorvette_","_corvette_") ';   
		}
	}
	if ($where2!='') $where.=$where2.')';
  }    
  
  if ($_REQUEST['fdesde']!='') $where .=  ' and substring(id_event,1,10)>="'.$_REQUEST['fdesde'].'"';
  if ($_REQUEST['fhasta']!='') $where .=  ' and substring(id_event,1,10)<="'.$_REQUEST['fhasta'].'"';
  
  if ($_REQUEST['hdesde']!='' && $_REQUEST['hdesde']!='0')                       
	$where .=  ' and concat(substring(id_event,1,10),\' \',substring(id_event,12,5)) >= "'.$_REQUEST['fdesde'].' '.$_REQUEST['hdesde'].'"';             
  if ($_REQUEST['hhasta']!='' && $_REQUEST['hhasta']!='0')                        
	$where .=  ' and concat(substring(id_event,1,10),\' \',substring(id_event,12,5)) <= "'.$_REQUEST['fhasta'].' '.$_REQUEST['hhasta'].'"';        
  
  $sql='
  SELECT pilot,telefon,persona_regala,mobil_persona_regala,e.email,email_persona_regala,email_confirm,u.email email_usuario from eventscantabria e left join ps_usuarios u on e.id_usuario=u.id_usuario  '.$where.'
  ';                     
  $dbi=	db::getInstance();
  $result=$dbi->executeS($sql);
  
  unset($dbi);
}
else 
{ 	
  // $sql='SELECT id_event,email_persona_regala,email,email_confirm   from events where id_event like "'.$_REQUEST['telefons_day'].'%" ';
  $sql='SELECT pilot,telefon,persona_regala,mobil_persona_regala,e.email,email_persona_regala,email_confirm,u.email email_usuario from events'.$_REQUEST['ciudad'].' e  left join ps_usuarios u on e.id_usuario=u.id_usuario where id_event like "'.$_REQUEST['telefons_day'].'%" AND '.$t_aux.'';                                           
  $dbi=db::getInstance();
  $result=$dbi->executeS($sql);   
  if (!$result) echo('Error al extraer la consulta de emails');
  unset($dbi);
}  
  
//die($sql);
   
    

 $emails=array();
 foreach($result as $r1)
	 {
		 $r=(object)$r1;

	 	 $actualizar_email_pilot=false;
	 	 $actualizar_email_persona_regala=false;
         $actualizar_email_confirm=false;
		 $actualizar_email_usuario=false;
		 if(isset($r->email) /* && !isset($emails[trim($r->email)]) */ && validar_email($r->email))
		 {
			$actualizar_email_pilot = true;             
		 }	  	 
		 
		 if(isset($r->email_persona_regala) /*&& !isset($emails[trim($r->email_persona_regala)])*/ && validar_email($r->email_persona_regala))		 
		 {     
			$actualizar_email_persona_regala = true;  	
		 }
	 	 

		 if(isset($r->email_confirm) /*&& !isset($emails[trim($r->email_confirm)])*/ && validar_email($r->email_confirm))
		 {
		     $actualizar_email_confirm = true;
		 }
		 			 

		 if(isset($r->email_usuario) /*&& !isset($emails[trim($r->email_confirm)])*/ && validar_email($r->email_usuario))
		 {
		     $actualizar_email_usuario = true;
		 }

					 
		 if ($seleccion_piloto)    
		 {  
			
		    
			if ($actualizar_email_pilot)  
			{  
				$emails[trim($r->email)]=$r->pilot;           
			}
/*			else if ($actualizar_email_persona_regala)
			{
				$emails[trim($r->email_persona_regala)]=$r->persona_regala;
			}
		 	else if ($actualizar_email_confirm)
			{
				$emails[trim($r->email_confirm)]=$r->persona_regala;
			}
			*/
		 }
		 else if ($seleccion_persona_regala)
		 {
		     
			if ($actualizar_email_persona_regala)
			{
				$emails[trim($r->email_persona_regala)]=$r->persona_regala;
			}
			/*else if ($actualizar_email_pilot)
			{
				$emails[trim($r->email)]=$r->pilot;
			}
		 	else if ($actualizar_email_confirm)
			{
				$emails[trim($r->email_confirm)]=$r->persona_regala;
			}
			*/
		 }
	    else if ($seleccion_confirm)
		 {
		     //echo($r->persona_regala.' '.trim($r->email_confirm).'--<br>');
		 	if ($actualizar_email_confirm)
			{
			    //echo($r->persona_regala.' '.trim($r->email_confirm).'<br>');
			    /*if ($r->persona_regala=='b')
			    {
			    die(trim($r->email_confirm));
			    }*/
			    
				$emails[trim($r->email_confirm)]=$r->persona_regala;
			}
		 }
		    /*else if ($actualizar_email_persona_regala)
			{
			    echo('test1');
				$emails[trim($r->email_persona_regala)]=$r->persona_regala;
			}
			else if ($actualizar_email_pilot)
			{  
			    echo('test2');
				$emails[trim($r->email)]=$r->pilot;
			}*/
		else if ($seleccion_usuario)
		{
			if ($actualizar_email_usuario)
				if (trim($r->email_usuario)!='')
					$emails[trim($r->email_usuario)]=$r->email_usuario;
		 }    
		 //todos los emails.
		 else
		 {
			 if ($actualizar_email_pilot)	 	 
			 {
				$emails[trim(strtolower($r->email))]=$r->pilot;                                                                             
			 }
			 
			 if ($actualizar_email_persona_regala && strtolower($r->email_persona_regala)!=strtolower($r->email))   
			 {
				$emails[trim(strtolower($r->email_persona_regala))]=$r->persona_regala;                                                                                                                                                                                                                                                                                  
			 }

			 if ($actualizar_email_confirm && strtolower($r->email_confirm)!=strtolower($r->email) && strtolower($r->email_confirm)!=strtolower($r->email_persona_regala))
			 {
			     $emails[trim(strtolower($r->email_confirm))]=$r->persona_regala;                   
			 }
			 if ($actualizar_email_usuario && strtolower($r->email_usuario)!=strtolower($r->email) && strtolower($r->email_usuario)!=strtolower($r->email_confirm) && strtolower($r->email_usuario)!=strtolower($r->email_persona_regala) )
			 {
				if (trim($r->email_usuario)!='')
					$emails[trim($r->email_usuario)]=$r->email_usuario;
			 }

		 }

	 }
	 //die($sql);           
	 /*foreach($emails as $k=>$v)
	 {
		echo($k.'<br>');
	 }
	 */
	


	//die($sql);
	 
	function validar_email($email)
	{
	    return(filter_var(trim($email), FILTER_VALIDATE_EMAIL)?true:false);              
	} 	 
	 
	 
	 
 	function seleccion_plantilla(&$asunto_plantilla,&$body_plantilla)                                    
	{
	//die;
		//echo($bd.' '.$server.'.'.$user.'.'.$password);die;
		$categoria_plantilla_correo = 39;                                                                                             
		$sql_body_plantilla = ' select titulo,description from ps_product p,ps_product_lang l where l.id_product = p.id_product and p.active=1 and p.id_category_default  = '.$categoria_plantilla_correo.' limit 1 ';                                                                                   
		
		$dbi=db::getInstance();
		//die('test');
		$rbody_plantilla=$dbi->executeS($sql_body_plantilla);                            
		
		if (!$rbody_plantilla) 
		{
			echo ('Error al buscar la plantilla');
			
			unset($dbi);
			return;
		}
		
		$row_plantilla=$rbody_plantilla[0];
		
		$body_plantilla = $row_plantilla['description'];                                         
		$asunto_plantilla = $row_plantilla['titulo'];                                                       
		
		unset($dbi);
		
	}	
	   
	     
	function enviar_email($mail,$email,$header,$body_plantilla,$asunto_plantilla)                                                                                                                                                                                                                   
	  { 		
		$mail->AddAddress($email);
		$mail->AddBCC("soporte@hccsoft.com","oc");                                                                 	  	         		    	                                                                                                                                                                       
	 
		$border_gen=0;      
		$body=$body_plantilla;      
		
		$mail->Body = $body;          
 
		$mail->AddCustomHeader ($header);           

		$mail->IsHTML(true);
		
			
		$exito=$mail->Send();
		
		$mail->ClearAddresses();

		if (!$exito)
		{	
			//unset($mail);
			return ('error '.$mail->ErrorInfo);
		}
		
		else 
		{
			//unset($mail);
			return ('OK');
		}

	  }  	
	
	


	function enviar_emails($emails,$bnc_ids,$bnc_controls,$body_plantilla,$asunto_plantilla,$nemails_total)                                                                                                           
	{  
        global $max_emails_por_ejecucion;
		
		$mail = new PHPMailer();	                                            
		$mail->Host = "localhost";

		//$mail->SMTPDebug  = 1; 
		
		$mail->SMTPAuth = true; 
		$mail->Port       = 587;    
		$mail->Username = EMAIL_INFO;          
		$mail->Password = PASSWD_EMAIL_INFO;    
		$mail->Helo = "www.".strtolower(_NOMBRE_LOGO_).".com";	                 

		$mail->From = EMAIL_INFO;                                
		$mail->CharSet = 'UTF-8';	                
		$mail->FromName = _NOMBRE_LOGO_;                    
		$mail->Subject =$asunto_plantilla;                       
		
		
		$lista_emails_enviar=$emails;                                                                                                                                                                                                                                                                                                
		//lista_emails contiene sólo los emails pendientes de enviar.
		$nemails=count($lista_emails_enviar);                                               
		
		$tb1=0;  
		  
		for ($i=0;$i<$nemails && $i<$max_emails_por_ejecucion;$i++)               
		{                   	
			$headers = "Errors-To: <bounce-".$bnc_ids[$i]."z".$bnc_controls[$i]."@".strtolower(_NOMBRE_LOGO_).".com>";                                                                 
			$email=$lista_emails_enviar[$i];                                                                       
			$t0 = FuncionesCodigos::microtime_float();
			$envio=enviar_email($mail,$email,$headers,$body_plantilla,$asunto_plantilla);                                                                                                                    
			$t0b+=(FuncionesCodigos::microtime_float()-$t0);      
			//$envio=enviar_email($email,$headers,$body_plantilla,$asunto_plantilla);         
			
			//echo('email: '.$email.',envio: '.$envio.'<br>');                                  
			//Si no hay error marcamos el registro como enviado.   
			$t1 = FuncionesCodigos::microtime_float();                                
			//$envio='OK';            
			
			if ($envio=='OK')    
			{
				$upd = ' UPDATE emails_enviar_suspension   
						 SET  enviado = 1,error=0
						 WHERE email = \''.$email.'\'';
			}   
			//Si hubo error en el envío lo añadimos en la  tabla.
			else
			{
				
				$upd = ' UPDATE emails_enviar_suspension                                                
						 SET  error=\''.$envio.'\'      
						 WHERE email = \''.$email.'\'';      
			}  
	                 				 
			//mysql_query("SET CHARACTER SET utf8 ");  
			$dbi=db::getInstance();			
			$result3=$dbi->execute($upd);                            
			unset($dbi);
			$t1b+=(FuncionesCodigos::microtime_float()-$t1);
		}	 
		//echo('tiempo '.$tb1.'<br>');
		//echo($i.' - '.$max_emails_por_ejecucion.' - '.$nemails_total);die;
		//Si hemos alcanzado el máximo de emails a enviar en cada ejecución, significa que deberemos continuar y por lo tanto
		//nos guardaremos el siguiente email a enviar.
		if ($i==$max_emails_por_ejecucion)
		{
			$ret=$nemails_total.'#1-'.$t0b.',nemails:'.$nemails.',i: '.$i.',max: '.$max_emails_por_ejecucion;                             
		}
		else 
		{
			$ret=$nemails_total.'#OK-'.$t0b.',nemails:'.$nemails.',i: '.$i.',max: '.$max_emails_por_ejecucion;                                                       
		}		
		return $ret;
	}	 
	 
	
	//
      
   if(isset($_REQUEST['marcar_envio']) && $_REQUEST['marcar_envio']=="1")                                              
   {  
		global $bd; 
		global $user;   
		global $server;
		global $password;	

		//die('DESACTIVADO');
		 
		
		$dt=date('Y-m-d H:i:s');                                                                             
		$sdt=explode(' ',$dt);  
		$sdt1=implode('',array_reverse(explode('-',$sdt[0])));            
		$sdt2=implode('',explode(':',$sdt[1]));                                   
			
		
		$emails_tmp = array();
		
		if (tools::getValue('email_siguiente')=='')
		{
			foreach  ($emails as $k=>$v)    
			{
				$emails_tmp[]=$k;  
				
			}

			$emails=$emails_tmp;          
			//var_dump($emails);die;
			//die('count '.count($emails));               
		
			$delete = " DELETE FROM emails_enviar_suspension ";		   
			$dbi=db::getInstance();
			$result3=$dbi->execute($delete);   
			
			unset($dbi);

		
			for ($i=0;$i<count($emails);$i++)                                                                                                                                                                                        
			{	     
				$insert = " INSERT INTO emails_enviar_suspension (email,enviado,error,fecha) VALUES ('".$emails[$i]."',0,0,now()) ";                                                                         

				$dbi=db::getInstance();       
				$resulti=$dbi->execute($insert);                                 
//die($insert); 
				if (!$resulti)               
				{
					echo('Error durante la actualización - '.$emails[$i].' _ '.$insert);                                       
				}       
				
				
				unset($dbi);

			}	
			
			 
			$duplicar= " CREATE TABLE mshop_bounces_".$sdt1.'_'.$sdt2." SELECT * FROM mshop_bounces ";                                                                                                                             
			//die($duplicar);
			
			//$delete = "delete from mshop_bounces		";                         
 					
			$insert= "insert into mshop_bounces                                                                                                                                                                 
					(bnc_email,bnc_date,bnc_message,bnc_control,bnc_bounced,bnc_bouncedate)             
					 SELECT email,now(),'',LEFT(UUID(), 8),0,DATE('0000-00-00 00:00:00' )    
					 from emails_enviar_suspension    
					 where email not in (select bnc_email from mshop_bounces)    ";      

			$dbi=db::getInstance();
			$query1=$dbi->execute($duplicar);     
			unset($dbi);
			
			/*$dbi=db::getInstance();                                                                                                             
			$query2=$dbi->execute($delete);     		  
			unset($dbi);*/
			
			$dbi=db::getInstance();                  
			$query3=$dbi->execute($insert);     		      
			unset($dbi);           
	 
	 		$sql = " select count(1) nemails_total from emails_enviar_suspension ev,mshop_bounces mb where date(substring(ev.fecha,1,10)) = (select max(date(substring(ev2.fecha,1,10))) from emails_enviar_suspension ev2)  and  mb.bnc_email=ev.email order by ev.email ";                                                                                                                                                                                                                                                                                                                                                                                                    
			$dbi=db::getInstance();                                                                                                      
			$query4=$dbi->executeS($sql);     		                          
			$nemails_total=$query4[0]['nemails_total'];       
			//$btest='1 '.$nemails_total;
			//var_dump('Emailstotal: '.$nemails_total);die;                                                                                                                                                                                                                                                                                                                                                     
			
			unset($dbi);                                                                                                    
		}	//fin email_siguiente==''    
		else
		{
			$nemails_total=tools::getValue('nemails_total');
			//$btest='2 '.$nemails_total;
		}

													
		 
		$sql = " select email,bnc_id,bnc_control                                
				 from emails_enviar_suspension ev,mshop_bounces mb 
				 where date(substring(ev.fecha,1,10)) = (select max(date(substring(ev2.fecha,1,10))) from emails_enviar_suspension ev2)  and  
					   mb.bnc_email=ev.email and not(ev.error is not null and error!='0') and 
					   ev.enviado=0 
				 order by ev.email limit 0,".($max_emails_por_ejecucion+1);																	                               ;                                                                                                                
		//$sql = " select email,bnc_id,bnc_control from emails_enviar_suspension ev,mshop_bounces mb where ev.fecha = (select max(ev2.fecha) from emails_enviar_suspension ev2) and  mb.bnc_email=ev.email order by ev.email ";                                                                                                                     
		$dbi=db::getInstance();
		$query=$dbi->executeS($sql);     		
		unset($dbi);
		//die($sql);
//var_dump($emails);die;
		$emailsf=array();  
		$bnc_ids=array();
		$bnc_controls=array();   
		$k=0;     
		
		$rnd2=rand(1,10000);   
			
		$k=0;	
		
		foreach($query as $row)                              
		{
  			$emailsf[]=$row['email'];                           
			$bnc_ids[]=$row['bnc_id'];  
			$bnc_controls[]=$row['bnc_control'];      
			$k++;   
		}
																			
	
	 										
		$emails=$emailsf;       
		//echo('emailsf');var_dump($emails);die;
		//mysql_close($link2);  
		//echo($btest);Die;
		$ret=enviar_emails($emailsf,$bnc_ids,$bnc_controls,$body_plantilla,$asunto_plantilla,$nemails_total);         
	 	$sql = " select max(id_envio) max from emails_enviar_suspension_historico ";                                                                                                               
		$dbi=db::getInstance();                                                                                                                
		$res=$dbi->executeS($sql);     		                                                 
		$max=intval($res[0]['max'])+1;                         
		unset($dbi);                 
        
		$semails=implode(',',array_map(function($a){return  '\''.$a.'\'';},$emailsf));                                                                                                                                     

		//sleep(5);	 

		//var_dump(tools::getSecureString($body_plantilla));die;
		
		$sql = ' insert into emails_enviar_suspension_historico                                                                                                                                                                                                                                         
				 (id_envio,email,fecha,enviado,error,bnc_fecha,bnc_bounced,bnc_message,asunto_email,body_email,ip,usuario)                            
				 select '.$max.',ev.email,ev.fecha,
				 case trim(ifnull(mb.bnc_message,\'\')) 
								   when \'\' 
								   then ev.enviado 
								   else 0 end,				 
				 ev.error,mb.bnc_date,mb.bnc_bounced,mb.bnc_message,                                       
				 "'.$asunto_plantilla.'","'.tools::getSecureString($body_plantilla).'",
				 inet_aton("'.GetUserIp_().'"),"'.$usuario.'"
				 from emails_enviar_suspension ev,mshop_bounces mb 
				 where mb.bnc_email=ev.email order by ev.email  and 
					   ev.email in ('.$semails.')';                                           
		  
//		echo($ret.$sql);die;	
																									
		$dbi=db::getInstance();                                                                                                         
		$res=$dbi->execute($sql);     		                          
		unset($dbi);
		
		die($ret);
   }   
	   

	//Incluir la libreria PHPExcel 
	
	include_once (dirname(__FILE__).'/../../../phpexcel/Classes/PHPExcel.php');                                                                          
	//die(dirname(__FILE__).'/../../../phpexcel/Classes/PHPExcel.php');    
	include_once (dirname(__FILE__).'/../../../phpexcel/Classes/PHPExcel/Writer/Excel2007.php');	     
	//die('test');   
	// Crea un nuevo objeto PHPExcel
	$objPHPExcel = new PHPExcel();   
	 
	// Establecer propiedades
	$objPHPExcel->getProperties()->setCreator("Cattivo");   
	$objPHPExcel->getProperties()->setLastModifiedBy("Cattivo");
	$objPHPExcel->getProperties()->setTitle("Listado de emails");
	$objPHPExcel->getProperties()->setSubject("Listado de emails");
	$objPHPExcel->getProperties()->setDescription("Listado de emails");
	$objPHPExcel->getProperties()->setKeywords("Excel Office 2007 openxml php");
	$objPHPExcel->getProperties()->setCategory("Emails"); 
	
	
	$anchos_columna = array(9,23);
	$i=0;
	$A=65;
	//$pc = $A+1; //primera columna con datos.
	$pc = $A;
	$prefijo_EXCEL5 = 'FF'; //Sólo cuando abramos el documento con formato Excel5 en lugar de Excel2007.
	
	$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(11);
	
	//**header("Content-type: application/ms-excel");       
	//**header("Content-Disposition: attachment; filename=telefonos.xls");   
  
  //echo $sql."\n\r";
  //echo 'Numero contactos:'.count($telefons)."\r\n\r\n";                                                                                                                       
   $j=1;		
   $objPHPExcel->setActiveSheetIndex(0)->setCellValue(chr($pc).$j,'cont');
   $objPHPExcel->setActiveSheetIndex(0)->setCellValue(chr($pc+1).$j,count($emails));
  

   $j=2;
   $i=0;
   
  
   //var_dump($telefons);die;
   //echo('<pre>');print_r($emails);echo('</pre>');die;
   foreach($emails as $k=>$v)             
   {
	   
  	if (trim($v)=='') $sv = 'cliente';
  	else $sv = $v;
	$sv='cliente';
  	//$sv=utf8_decode($sv);
	$tmp=explode(' ',$sv);
	$tmp=$tmp[0];
	
    //echo $k.chr(9).$sv.chr(9).$tmp."  \r\n";
	
  	if (trim($tmp)=='') $tmp='cliente';
	
	
  	$objPHPExcel->setActiveSheetIndex(0)->setCellValue(chr($pc).$j,$k);
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue(chr($pc+1).$j,$tmp);
	if ($i==25452) { die(chr($pc).$j.'-'.$k.'->'.$tmp);$break;}   
	
    $j++;
    $i++;
	
   }               
 
  
	$objPHPExcel->getActiveSheet()->getSheetView()->setZoomScale(100);

    $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5'); 
    $nombre_tmp=uniqid();
    $objWriter->save('../../../listados/'.$nombre_tmp.'.xls');
    $content  = file_get_contents('../../../listados/'.$nombre_tmp.'.xls');
    unlink('../../../listados/'.$nombre_tmp.'.xls');
	header("Content-type: application/ms-excel");    
	header("Content-Disposition: attachment; filename=listado_emails.xls");   
    header("Pragma: no-cache");
    header("Expires: 0");
    echo($content);


?>