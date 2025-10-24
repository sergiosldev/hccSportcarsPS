<?php

include('config_events_new.php');
$sql='';

$t_aux=' tipus_event="'.$_REQUEST['tipus'].'" ';
if($_REQUEST['tipus']=='lamborghini')
     $t_aux='(tipus_event="lamborghini_lotus" OR tipus_event="lamborghini") ';
else if($_REQUEST['tipus']=='ferrari')
     $t_aux='(tipus_event="ferrari" OR tipus_event="ferrari_porsche901") ';


if(isset($_REQUEST['mails_all']))
  {
  $where1=' where true ';
  $where2=' where true ';
  $where3=' where true ';
  $where4=' where true ';
  $where5=' where true ';

  if ($_REQUEST['tipoc']!='') 
	{
	 switch($_REQUEST['tipoc'])
	 {
		case 'ferrari': 
			$where1.=' and e.tipus_event in ("_bferrari_","ferrari","ferrari_porsche901") ';
			$where2.=' and em.tipus_event in ("_bferrari_","ferrari","ferrari_porsche901") ';
			$where3.=' and ev.tipus_event in ("_bferrari_","ferrari","ferrari_porsche901") ';
			$where4.=' and ea.tipus_event in ("_bferrari_","ferrari","ferrari_porsche901") ';
			$where5.=' and ec.tipus_event in ("_bferrari_","ferrari","ferrari_porsche901") ';
			break;
		case 'lamborghini':
			$where1.=' and e.tipus_event in ("_blamborghini_","lamborghini","lamborghini_lotus") ';
			$where2.=' and em.tipus_event in ("_blamborghini_","lamborghini","lamborghini_lotus") ';
			$where3.=' and ev.tipus_event in ("_blamborghini_","lamborghini","lamborghini_lotus") ';
			$where4.=' and ea.tipus_event in ("_blamborghini_","lamborghini","lamborghini_lotus") ';
			$where5.=' and ec.tipus_event in ("_blamborghini_","lamborghini","lamborghini_lotus") ';
			break;
		case 'ferrari_lamborghini':
			$where1.=' and e.tipus_event in ("_bferrari_","ferrari","ferrari_porsche901","_blamborghini_","lamborghini","lamborghini_lotus") ';
			$where2.=' and em.tipus_event in ("_bferrari_","ferrari","ferrari_porsche901","_blamborghini_","lamborghini","lamborghini_lotus") ';
			$where3.=' and ev.tipus_event in ("_bferrari_","ferrari","ferrari_porsche901","_blamborghini_","lamborghini","lamborghini_lotus") ';
			$where4.=' and ea.tipus_event in ("_bferrari_","ferrari","ferrari_porsche901","_blamborghini_","lamborghini","lamborghini_lotus") ';
			$where5.=' and ec.tipus_event in ("_bferrari_","ferrari","ferrari_porsche901","_blamborghini_","lamborghini","lamborghini_lotus") ';
			break;
		default;
	  }
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

  
  $sql='
  SELECT id_event,pilot,email_persona_regala,email,email_confirm   from events e '.$where1.'
  UNION ALL
  SELECT id_event,pilot,email_persona_regala,email,email_confirm   from eventsmadrid em '.$where2.' 
  UNION ALL
  SELECT id_event,pilot,email_persona_regala,email,email_confirm   from eventsvalencia ev '.$where3.' 
  UNION ALL
  SELECT id_event,pilot,email_persona_regala,email,email_confirm   from eventsandalucia ea '.$where4.' 
  UNION ALL
  SELECT id_event,pilot,email_persona_regala,email,email_confirm   from eventscantabria ec '.$where5.' 
  
  ';
  //die($sql);
  $result=mysqli_query($link,$sql);
 
}


elseif(isset($_REQUEST['mails_bcn']))
  {
  $where = ' where true ';
  
  if ($_REQUEST['tipoc']!='') 
	{
	 switch($_REQUEST['tipoc'])
	 {
		case 'ferrari': 
			$where.=' and tipus_event in ("_bferrari_","ferrari","ferrari_porsche901") ';
			break;
		case 'lamborghini':
			$where.=' and tipus_event in ("_blamborghini_","lamborghini","lamborghini_lotus") ';
			break;
		case 'ferrari_lamborghini':
			$where.=' and tipus_event in ("_bferrari_","ferrari","ferrari_porsche901","_blamborghini_","lamborghini","lamborghini_lotus") ';
			break;
		default;
	  }
    }  
  if ($_REQUEST['fdesde']!='') $where .=  ' and date(substring(id_event,1,10))>=date("'.$_REQUEST['fdesde'].'")';
  if ($_REQUEST['fhasta']!='') $where .=  ' and date(substring(id_event,1,10))<=date("'.$_REQUEST['fhasta'].'")';


  $sql='
  SELECT id_event,pilot,email_persona_regala,email,email_confirm   from events '.$where.' 
  ';
 // die($sql);
  $result=mysqli_query($link,$sql);
}

elseif(isset($_REQUEST['mails_mad']))
  {
  $where = ' where true ';
  if ($_REQUEST['tipoc']!='') 
	{
	 switch($_REQUEST['tipoc'])
	 {
		case 'ferrari': 
			$where.=' and tipus_event in ("_bferrari_","ferrari","ferrari_porsche901") ';
			break;
		case 'lamborghini':
			$where.=' and tipus_event in ("_blamborghini_","lamborghini","lamborghini_lotus") ';
			break;
		case 'ferrari_lamborghini':
			$where.=' and tipus_event in ("_bferrari_","ferrari","ferrari_porsche901","_blamborghini_","lamborghini","lamborghini_lotus") ';
			break;
		default;
	  }
    }  
  
  if ($_REQUEST['fdesde']!='') $where .=  ' and date(substring(id_event,1,10))>=date("'.$_REQUEST['fdesde'].'")';
  if ($_REQUEST['fhasta']!='') $where .=  ' and date(substring(id_event,1,10))<=date("'.$_REQUEST['fhasta'].'")';
 
  $sql='
  SELECT id_event,pilot,email_persona_regala,email,email_confirm   from eventsmadrid '.$where.'
  ';
  $result=mysqli_query($link,$sql);
}
elseif(isset($_REQUEST['mails_val']))
  {
  $where = ' where true ';
  if ($_REQUEST['tipoc']!='') 
	{
	 switch($_REQUEST['tipoc'])
	 {
		case 'ferrari': 
			$where.=' and tipus_event in ("_bferrari_","ferrari","ferrari_porsche901") ';
			break;
		case 'lamborghini':
			$where.=' and tipus_event in ("_blamborghini_","lamborghini","lamborghini_lotus") ';
			break;
		case 'ferrari_lamborghini':
			$where.=' and tipus_event in ("_bferrari_","ferrari","ferrari_porsche901","_blamborghini_","lamborghini","lamborghini_lotus") ';
			break;
		default;
	  }
    }  
  
  if ($_REQUEST['fdesde']!='') $where .=  ' and date(substring(id_event,1,10))>=date("'.$_REQUEST['fdesde'].'")';
  if ($_REQUEST['fhasta']!='') $where .=  ' and date(substring(id_event,1,10))<=date("'.$_REQUEST['fhasta'].'")';

  $sql='
  SELECT id_event,pilot,email_persona_regala,email,email_confirm   from eventsvalencia '.$where.'
  ';

  $result=mysqli_query($link,$sql);
}
elseif(isset($_REQUEST['mails_and']))
  {
  $where = ' where true ';
  if ($_REQUEST['tipoc']!='') 
	{
	 switch($_REQUEST['tipoc'])
	 {
		case 'ferrari': 
			$where.=' and tipus_event in ("_bferrari_","ferrari","ferrari_porsche901") ';
			break;
		case 'lamborghini':
			$where.=' and tipus_event in ("_blamborghini_","lamborghini","lamborghini_lotus") ';
			break;
		case 'ferrari_lamborghini':
			$where.=' and tipus_event in ("_bferrari_","ferrari","ferrari_porsche901","_blamborghini_","lamborghini","lamborghini_lotus") ';
			break;
		default;
	  }
    }
  if ($_REQUEST['fdesde']!='') $where .=  ' and date(substring(id_event,1,10))>=date("'.$_REQUEST['fdesde'].'")';
  if ($_REQUEST['fhasta']!='') $where .=  ' and date(substring(id_event,1,10))<=date("'.$_REQUEST['fhasta'].'")';

  $sql='
  SELECT id_event,pilot,email_persona_regala,email,email_confirm   from eventsandalucia '.$where.'
  ';

  $result=mysqli_query($link,$sql);
 
 }	
elseif(isset($_REQUEST['mails_can']))
  {
  $where = ' where true ';
  if ($_REQUEST['tipoc']!='') 
	{
	 switch($_REQUEST['tipoc'])
	 {
		case 'ferrari': 
			$where.=' and tipus_event in ("_bferrari_","ferrari","ferrari_porsche901") ';
			break;
		case 'lamborghini':
			$where.=' and tipus_event in ("_blamborghini_","lamborghini","lamborghini_lotus") ';
			break;
		case 'ferrari_lamborghini':
			$where.=' and tipus_event in ("_bferrari_","ferrari","ferrari_porsche901","_blamborghini_","lamborghini","lamborghini_lotus") ';
			break;
		default;
	  }
    }  
	
  if ($_REQUEST['fdesde']!='') $where .=  ' and date(substring(id_event,1,10))>=date("'.$_REQUEST['fdesde'].'")';
  if ($_REQUEST['fhasta']!='') $where .=  ' and date(substring(id_event,1,10))<=date("'.$_REQUEST['fhasta'].'")';

  $sql='
  SELECT id_event,pilot,email_persona_regala,email,email_confirm   from eventscantabria '.$where.'
  ';
  $result=mysqli_query($link,$sql);
}
else if(isset($_REQUEST['mails_day_conf'])){
  	
  // $sql='SELECT id_event,email_persona_regala,email,email_confirm   from events where id_event like "'.$_REQUEST['mails_day'].'%" ';
  $sql='SELECT id,pilot,id_event,email_confirm  from events'.$_REQUEST['ciudad'].' where id_event like "'.$_REQUEST['mails_day_conf'].'%" AND '.$t_aux.'';
  $result=mysqli_query($link,$sql);
	
} else {
  	
  // $sql='SELECT id_event,email_persona_regala,email,email_confirm   from events where id_event like "'.$_REQUEST['mails_day'].'%" ';
  $sql='SELECT id_event,pilot,email_persona_regala,email,email_confirm   from events'.$_REQUEST['ciudad'].' where id_event like "'.$_REQUEST['mails_day'].'%" AND '.$t_aux.'';
  $result=mysqli_query($link,$sql);
	
  }  
 
 while($r=mysqli_fetch_object($result))
	 {
	 if(isset($r->email_persona_regala) && filter_var(trim($r->email_persona_regala), FILTER_VALIDATE_EMAIL) && !isset($mails[trim($r->email_persona_regala)]))$mails[trim($r->email_persona_regala)]=' ::::  '.$r->pilot;;	
	 if(isset($r->email) && filter_var(trim($r->email), FILTER_VALIDATE_EMAIL) && !isset($mails[trim($r->email)]))$mails[trim($r->email)]=' ::::  '.$r->pilot;;	
	 if(filter_var(trim($r->email_confirm), FILTER_VALIDATE_EMAIL) && !isset($mails[trim($r->email_confirm)]))$mails[trim($r->email_confirm)]=' ::::  '.$r->pilot;		 
	 }
  
  header("Content-type: application/octet-stream");
  header("Content-Disposition: attachment; filename=\"mails.rtf\"\n");
  //echo $sql."\n\r";
  echo 'Numero contactos:'.count($mails)."\r\n\r\n";
  foreach($mails as $k=>$v)
     echo $k."  \r\n";
  
?>