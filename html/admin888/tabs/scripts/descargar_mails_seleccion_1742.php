<?php
include('config_events.php');    
//include(dirname(__FILE__).'/../../../config/config.inc.php');	  
$sql='';   

  
/*$t_aux=' tipus_event="'.$_REQUEST['tipus'].'" ';
if($_REQUEST['tipus']=='lamborghini')
     $t_aux='(tipus_event="lamborghini_lotus" OR tipus_event="lamborghini") ';
else if($_REQUEST['tipus']=='ferrari')
     $t_aux='(tipus_event="ferrari" OR tipus_event="ferrari_porsche901") ';

*/



  /*$bd=_DB_NAME_;
  $user=_DB_USER_;
  $server=_DB_SERVER_;
  $password=_DB_PASSWD_; 


  seleccion_plantilla($bd,$user,$server,$password,$asunto_plantilla,$body_plantilla);	
    */              
	
  seleccion_plantilla($bd,$user,$host,$password,$asunto_plantilla,$body_plantilla);		

  //die('asun '.$asunto_plantilla.' '.$body_plantilla);
  $link = mysql_connect($host, $user, $password) or die ("<p class='error'>Lo sentimos, no se puede conectar con el servidor de base de datos.</p>");               
  mysql_select_db($bd, $link) or die ("<p class='error'>Lo sentimos, no se puede conectar con la base de datos.</p>");                          


  
  $seleccion_piloto = false;  
  $seleccion_persona_regala = false;          
  $seleccion_confirm = false;   
//die('selcli '.$_REQUEST['sel_cliente']);

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
				default:
		}
	}


  if(isset($_REQUEST['emails_all']))  
  {    
	  $where1=' where (trim(email)!="" or trim(email_confirm)!="" or trim(email_persona_regala)!="")  ';      
	  $where2=' where (trim(email)!="" or trim(email_confirm)!="" or trim(email_persona_regala)!="")  ';
	  $where3=' where (trim(email)!="" or trim(email_confirm)!="" or trim(email_persona_regala)!="")  ';
	  $where4=' where (trim(email)!="" or trim(email_confirm)!="" or trim(email_persona_regala)!="")  ';
	  $where5=' where (trim(email)!="" or trim(email_confirm)!="" or trim(email_persona_regala)!="")  ';  
  
  
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
  
  SELECT pilot,telefon,persona_regala,mobil_persona_regala,email,email_persona_regala,email_confirm from events e '.$where1.'
  UNION ALL
  SELECT pilot,telefon,persona_regala,mobil_persona_regala,email,email_persona_regala,email_confirm  from eventsmadrid em '.$where2.' 
  UNION ALL
  SELECT pilot,telefon,persona_regala,mobil_persona_regala,email,email_persona_regala,email_confirm  from eventsvalencia ev '.$where3.' 
  UNION ALL
  SELECT pilot,telefon,persona_regala,mobil_persona_regala,email,email_persona_regala,email_confirm  from eventsandalucia ea '.$where4.' 
  UNION ALL
  SELECT pilot,telefon,persona_regala,mobil_persona_regala,email,email_persona_regala,email_confirm  from eventscantabria ec '.$where5.'         
  ';
  
  //die($sql);
  $result=mysql_query($sql); 
}


elseif(isset($_REQUEST['emails_bcn']))
  {
  $where = ' where (trim(email)!="" or trim(email_confirm)!="" or trim(email_persona_regala)!="")   ';
  
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
  SELECT pilot,telefon,persona_regala,mobil_persona_regala,email,email_persona_regala,email_confirm    from events '.$where.' 
  ';
  //die($sql);
  $result=mysql_query($sql);
}

elseif(isset($_REQUEST['emails_mad']))
  {
  $where = ' where (trim(email)!="" or trim(email_confirm)!="" or trim(email_persona_regala)!="")   ';
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
  SELECT pilot,telefon,persona_regala,mobil_persona_regala,email,email_persona_regala,email_confirm   from eventsmadrid '.$where.'
  ';
  //die($sql);
  $result=mysql_query($sql);
}
elseif(isset($_REQUEST['emails_val']))
  {
  $where = ' where (trim(email)!="" or trim(email_confirm)!="" or trim(email_persona_regala)!="")    ';
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
  SELECT pilot,telefon,persona_regala,mobil_persona_regala,email,email_persona_regala,email_confirm  from eventsvalencia '.$where.'
  ';

  $result=mysql_query($sql);
}
elseif(isset($_REQUEST['emails_and']))
  {
  $where = ' where (trim(email)!="" or trim(email_confirm)!="" or trim(email_persona_regala)!="")  ';          
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
  SELECT id_event,pilot,email_persona_regala,email,email_confirm,email,email_persona_regala,email_confirm   from eventsandalucia '.$where.'
  ';

  $result=mysql_query($sql);
 
 }	  
elseif(isset($_REQUEST['emails_can']))
  {
  $where = ' where (trim(email)!="" or trim(email_confirm)!="" or trim(email_persona_regala)!="")  ';
  	
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
  SELECT pilot,telefon,persona_regala,mobil_persona_regala,email,email_persona_regala,email_confirm from eventscantabria '.$where.'
  ';                                                     
  $result=mysql_query($sql);
}
else 
{ 	
  // $sql='SELECT id_event,email_persona_regala,email,email_confirm   from events where id_event like "'.$_REQUEST['telefons_day'].'%" ';
  $sql='SELECT pilot,telefon,persona_regala,mobil_persona_regala,email,email_persona_regala,email_confirm  from events'.$_REQUEST['ciudad'].' where id_event like "'.$_REQUEST['telefons_day'].'%" AND '.$t_aux.'';                                          
  $result=mysql_query($sql);                                                
}  
   

   
    
//die($sql); 
$emails=array();
 while($r=mysql_fetch_object($result))
	 {
	 	 $actualizar_email_pilot=false;
	 	 $actualizar_email_persona_regala=false;
         $actualizar_email_confirm=false;
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
	 
	 
	 
 	function seleccion_plantilla($bd,$user,$server,$password,&$asunto_plantilla,&$body_plantilla)                                    
	{
	//die;
		//echo($bd.' '.$server.'.'.$user.'.'.$password);die;
		$categoria_plantilla_correo = 39;             
		$link_plantilla = mysql_connect($server, $user, $password) or die ("<p class='error'>Lo sentimos, no se puede conectar con el servidor de base de datos.</p>");               
		mysql_select_db($bd, $link_plantilla) or die ("<p class='error'>Lo sentimos, no se puede conectar con la base de datos.</p>");                           
		$sbody_plantilla = ' select titulo,description from ps_product p,ps_product_lang l where l.id_product = p.id_product and p.active=1 and p.id_category_default  = '.$categoria_plantilla_correo.' limit 1 ';                                                   
		$rbody_plantilla= mysql_query($sbody_plantilla);          
		$row_plantilla = mysql_fetch_assoc($rbody_plantilla);      
		//$body_plantilla = utf8_decode($row_plantilla['description']);
		$body_plantilla = $row_plantilla['description'];                                         
		$asunto_plantilla = $row_plantilla['titulo'];                                                       
			
		mysql_close($link_plantilla);				                                                            

	}	
	   
	     
	function enviar_email($email,$header,$body_plantilla,$asunto_plantilla)                                                                                                                                                                                                                  
	  { 
		include_once (dirname(__FILE__).'/../../../scripts/phpmailer.php');             
		$mail = new PHPMailer();	   
		
		$mail->Host = "localhost";

		$mail->SMTPDebug  = 1; 
		
		$mail->SMTPAuth = true; 
		$mail->Port       = 25;    
		$mail->Username = "info@motorclubexperience.com";      
		$mail->Password = "75a47b59";    
		$mail->Helo = "www.motorclubexperience.com";	     

		$mail->From = "info@motorclubexperience.com";          
		$mail->CharSet = 'UTF-8';	
		$mail->FromName = "Motorclubexperience";        
		$mail->Subject =$asunto_plantilla;
		//.'-'.$email;      
		        
		//$mail->AddAddress($email);
		$mail->AddAddress('marctorraso2@gmail.com');                                       
		//$mail->AddAddress('soporte@motorclubexperience.com');                
		$mail->AddBCC("soporte@motorclubexperience.com","oc");   	  	         		    	               
		//$mail->AddBCC("info@motorclubexperience.com","oc");   	  	         		    	               
	 
		$border_gen=0;      
		$body=$body_plantilla;      
		
		$mail->Body = $body;          

		$mail->AddCustomHeader ($header);           

		$mail->IsHTML(true);
		
			
		$exito=$mail->Send();

		if (!$exito)
		{	

			return ('error '.$mail->ErrorInfo);
		}
		
		else 
		{
			return ('OK');
		}

	  }  	
	
	
	function enviar_emails($emails,$bnc_ids,$bnc_controls,$body_plantilla,$asunto_plantilla)                         
	{  

		//Actualizamos la tabla de emails de suspensión enviados.                                                    
		global $bd,$user,$server,$password;                                                               
		$lista_emails=$emails;   
		$nemails=count($lista_emails);                                               
//		var_dump($lista_emails);die;
		 //var_dump($emails);echo(count($emails));die;
		for ($i=0;$i<$nemails;$i++)
		{	
			$headers = "Errors-To: <bounce-".$bnc_ids[$i]."z".$bnc_controls[$i]."@motorclubexperience.com>";                                                    
			$email=$lista_emails[$i];        
			
			$envio=enviar_email($email,$headers,$body_plantilla,$asunto_plantilla);       
			//echo('envio: '.$envio.'<br>');                                 
			//Si no hay error marcamos el registro como enviado.
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
			$link3 = mysql_connect($server, $user, $password) or die ("<p class='error'>Lo sentimos, no se puede conectar con el servidor de base de datos.</p>");   
			mysql_select_db($bd, $link3) or die ("<p class='error'>Lo sentimos, no se puede conectar con la base de datos.</p>");
			
            $result3= mysql_query($upd);
            if (!$result3) {echo('Error durante la actualización _ '.$upd);}  
			mysql_close($link3);	
			
		}	 
	}	 
	//
   if(isset($_REQUEST['marcar_envio']) && $_REQUEST['marcar_envio']=="1")                         
   {  
		global $bd;
		global $user;   
		global $server;
		global $password;	

		die('DESACTIVADO');
		 
		
		$dt=date('Y-m-d H:i:s');                                                                             
		$sdt=explode(' ',$dt);
		$sdt1=implode('_',explode('-',$dt[0]));
		$sdt2=implode('',explode(':',$sdt[1]));                                   
			
		
		$emails_tmp = array();
		
		foreach  ($emails as $k=>$v)    
		{
			//if (!in_array($k,$emails)) 
			$emails_tmp[]=$k;
		}

		$emails=$emails_tmp;          
		//var_dump($emails);die;
		//die('count '.count($emails));               
		  
		$linkdel = mysql_connect($server, $user, $password) or die ("<p class='error'>Lo sentimos, no se puede conectar con el servidor de base de datos.</p>");                                                                                             
		mysql_select_db($bd, $linkdel) or die ("<p class='error'>Lo sentimos, no se puede conectar con la base de datos.</p>");          
		$delete = " DELETE FROM emails_enviar_suspension ";		
		$resultdel= mysql_query($delete);  
		mysql_close($linkdel);	    
		
		for ($i=0;$i<count($emails);$i++)                                                                                                                                                                                        
		{	     
			$insert = " INSERT INTO emails_enviar_suspension (email,enviado,error,fecha) VALUES ('".$emails[$i]."',0,0,now()) ";                                
			$linki = mysql_connect($server, $user, $password) or die ("<p class='error'>Lo sentimos, no se puede conectar con el servidor de base de datos.</p>");                                                                                            
			mysql_select_db($bd, $linki) or die ("<p class='error'>Lo sentimos, no se puede conectar con la base de datos.</p>");            
				
            //die($insert);   
            $resulti= mysql_query($insert);    

            if (!$resulti) 
			{
				echo('Error durante la actualización - '.$emails[$i].' _ '.$insert);
			}       
			mysql_close($linki);				  
		}	
		
		
		$duplicar= " CREATE TABLE mshop_bounces".$sdt1.' '.$sdt2." SELECT * FROM mshop_bounces ";                                                                                                  
		
		$delete = "delete from mshop_bounces		";                         
				
		$insert= "insert into mshop_bounces                                                                                                                                                                 
				(bnc_email,bnc_date,bnc_message,bnc_control,bnc_bounced,bnc_bouncedate)           
				 SELECT email,now(),'',LEFT(UUID(), 8),0,DATE('0000-00-00 00:00:00' )   
				 from emails_enviar_suspension    
				 ";      


		$linkd = mysql_connect($server, $user, $password) or die ("<p class='error'>Lo sentimos, no se puede conectar con el servidor de base de datos.</p>");                   
		mysql_select_db($bd, $linkd) or die ("<p class='error'>Lo sentimos, no se puede conectar con la base de datos.</p>");                      
		$query=mysql_query($duplicar); 
		$query=mysql_query($delete);
		$query=mysql_query($insert);

		mysql_close($linkd);			
 
		
		//$sql = " select email,bnc_id,bnc_control from emails_enviar_suspension ev,mshop_bounces mb where ev.fecha = (select max(ev2.fecha) from emails_enviar_suspension ev2) and  mb.bnc_email=ev.email and not(ev.error is not null and error!='0') and ev.enviado=0 order by ev.email limit 2 ";                                    
		
				$sql = " select email,bnc_id,bnc_control from emails_enviar_suspension ev,mshop_bounces mb where ev.fecha = (select max(ev2.fecha) from emails_enviar_suspension ev2) and  mb.bnc_email=ev.email and not(ev.error is not null and error!='0') and ev.enviado=0 order by ev.email ";                                     
		
		// def:
		//$sql = " select email,bnc_id,bnc_control from emails_enviar_suspension ev,mshop_bounces mb where ev.fecha = (select max(ev2.fecha) from emails_enviar_suspension ev2) and  mb.bnc_email=ev.email and not(ev.error is not null and error!='0') and ev.enviado=0 order by ev.email ";                                    
		//die($sql);
		$links = mysql_connect($server, $user, $password) or die ("<p class='error'>Lo sentimos, no se puede conectar con el servidor de base de datos.</p>");           
		mysql_select_db($bd, $links) or die ("<p class='error'>Lo sentimos, no se puede conectar con la base de datos.</p>");            
		$query = mysql_query($sql);
		mysql_close($links);
//var_dump($emails);die;
		$emailsf=array();  
		$k=0;     
		
		$rnd2=rand(1,10000);   
		
		while ($row = mysql_fetch_assoc($query))
		{
			$emailsf[]=$row['email'];
			$bnc_ids[]=$row['bnc_id'];
			$bnc_controls[]=$row['bnc_control'];
		$k++;
		}
		
		$emails=$emailsf;
		//mysql_close($link2);  
		
		enviar_emails($emails,$bnc_ids,$bnc_controls,$body_plantilla,$asunto_plantilla);
		die('enviado');
   }   
	   

	//Incluir la libreria PHPExcel 
	require_once '../../../phpexcel/Classes/PHPExcel.php';
	require_once "../../../phpexcel/Classes/PHPExcel/Writer/Excel2007.php";
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
   foreach($emails as $k=>$v)             
   {
  	if (trim($v)=='') $sv = 'cliente';
  	else $sv = $v;
  	//$sv=utf8_decode($sv);
  	$tmp=explode(' ',$sv);
  	$tmp=$tmp[0];
    //echo $k.chr(9).$sv.chr(9).$tmp."  \r\n";
  	if (trim($tmp)=='') $tmp='cliente';
  	$objPHPExcel->setActiveSheetIndex(0)->setCellValue(chr($pc).$j,$k);
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue(chr($pc+1).$j,$tmp);
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
  
  
  
// http://lon.motorclubexperience.com/admin888/tabs/scripts/descargar_mails.php?all_mails=
// http://lon.motorclubexperience.com/admin888/tabs/scripts/descargar_mails.php?mails_month=2011-05
?>


		