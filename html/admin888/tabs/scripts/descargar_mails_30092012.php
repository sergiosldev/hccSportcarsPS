<?php

include('config_events.php');
$sql='';

$t_aux=' tipus_event="'.$_REQUEST['tipus'].'" ';
if($_REQUEST['tipus']=='lamborghini')
     $t_aux='(tipus_event="lamborghini_lotus" OR tipus_event="lamborghini") ';
else if($_REQUEST['tipus']=='ferrari')
     $t_aux='(tipus_event="ferrari" OR tipus_event="ferrari_porsche901") ';


if(isset($_REQUEST['mails_all']))
  {
 
  $sql='
  SELECT id_event,pilot,email_persona_regala,email,email_confirm   from events 
  UNION ALL
  SELECT id_event,pilot,email_persona_regala,email,email_confirm   from eventsmadrid 
  UNION ALL
  SELECT id_event,pilot,email_persona_regala,email,email_confirm   from eventsvalencia 
  
  ';
  $result=mysql_query($sql);
 
}else if(isset($_REQUEST['mails_day_conf'])){
  	
  // $sql='SELECT id_event,email_persona_regala,email,email_confirm   from events where id_event like "'.$_REQUEST['mails_day'].'%" ';
  $sql='SELECT id,pilot,id_event,email_confirm  from events'.$_REQUEST['ciudad'].' where id_event like "'.$_REQUEST['mails_day_conf'].'%" AND '.$t_aux.'';
  $result=mysql_query($sql);
	
} else {
  	
  // $sql='SELECT id_event,email_persona_regala,email,email_confirm   from events where id_event like "'.$_REQUEST['mails_day'].'%" ';
  $sql='SELECT id_event,pilot,email_persona_regala,email,email_confirm   from events'.$_REQUEST['ciudad'].' where id_event like "'.$_REQUEST['mails_day'].'%" AND '.$t_aux.'';
  $result=mysql_query($sql);
	
  }  

 while($r=mysql_fetch_object($result))
	 {
	 if(isset($r->email_persona_regala) && filter_var($r->email_persona_regala, FILTER_VALIDATE_EMAIL) && !isset($mails[trim($r->email_persona_regala)]))$mails[trim($r->email_persona_regala)]=' ::::  '.$r->pilot;;	
	 if(isset($r->email) && filter_var($r->email, FILTER_VALIDATE_EMAIL) && !isset($mails[trim($r->email)]))$mails[trim($r->email)]=' ::::  '.$r->pilot;;	
	 if(filter_var($r->email_confirm, FILTER_VALIDATE_EMAIL) && !isset($mails[trim($r->email_confirm)]))$mails[trim($r->email_confirm)]=' ::::  '.$r->pilot;	
	 }
  
  header("Content-type: application/octet-stream");
  header("Content-Disposition: attachment; filename=\"mails.rtf\"\n");
  //echo $sql."\n\r";
  echo 'Numero contactos:'.count($mails)."\r\n\r\n";
  foreach($mails as $k=>$v)
     echo $k."  \r\n";
  
// http://lon.motorclubexperience.com/admin888/tabs/scripts/descargar_mails.php?all_mails=
// http://lon.motorclubexperience.com/admin888/tabs/scripts/descargar_mails.php?mails_month=2011-05
?>