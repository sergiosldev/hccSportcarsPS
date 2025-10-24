<?php

include('config_events.php');

if($_REQUEST['tipus']=='porsche997' || $_REQUEST['tipus']=='porsche996' )
include 'dies_graella2.php';
else include 'dies_graella.php';
include_once 'functions.php';

define('TEMPS',$_REQUEST['data']); // Dia que li arriba
$libres=false;


graella($array_hores);

/*
 $hores array(hora,info) 
 $lliure array(hora)  
 */
function graella($hores)
{
	global $link,$persones,$libres;
?>

<?php	


$i=0;
$info=' ';
$tipus=$_REQUEST['tipus'];


foreach($hores as $hora=>$info)
  {


$tipus=$_REQUEST['tipus'];  
$hora=str_replace('@','',$hora);
  	
if($hora=='c'){
	?>
	<?php
	continue ; 
}	



// cas graella 1 sol cotxe

if($_REQUEST['tipus']=='_lotus_' && $i%2 ){
	$i++;
	continue ; 
}


$hora_bona=$hora;  
if($persones==2 && $i%$persones){
	$hora=resta_quart($hora);
}

///


if($i%2 && trim($tipus)=='porsche996'){
	$tipus='porsche997';
	}
else if($i%2 && trim($tipus)=='porsche997'){
	$tipus='porsche996';
	}
  
    $perms=permisos($tipus,TEMPS,$hora_bona);



$t_aux='i.tipus_event="'.$tipus.'"';

// graellas dobles <<  si estreu aixo i es posen tipus queda com abans
  if( !$perms && ($tipus=='porsche997' || $tipus=='porsche996') ){
	$t_aux='(i.tipus_event="porsche997_porsche996" OR i.tipus_event="porsche997" OR i.tipus_event="porsche996") ';
	}

  if( $tipus=='ferrari' ){
  	$t_aux='(i.tipus_event="ferrari" OR i.tipus_event="ferrari_porsche901") ';
	}

  if($tipus=='lamborghini' ){
  	$t_aux='(i.tipus_event="lamborghini_lotus" OR i.tipus_event="lamborghini") ';
   }


// fi graelles dobles

	$sql='SELECT i.* FROM `events` as i WHERE i.id_event="'.TEMPS.'@'.$hora_bona.'" AND '.$t_aux.'';
    $result=mysql_query($sql);
	
	
	if(mysql_num_rows($result) ){
   
	}else {$libres=true;  }
 // recuperem info
	?>
	
	<?php 
	
	$i++;
  }
	?>
<?php	
}

if($libres==true)echo 'SL';
else echo 'NL';  
  
   
?>