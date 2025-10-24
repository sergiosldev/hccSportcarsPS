<?php
include_once(dirname(__FILE__).'/../../../config/config.inc.php');
$perfilg=intval($_GET['perfil']); 
$usuariog=tools::getValue('usuario');  

define('AZUL','#B244FD');

//define('AZUL','#AAC1EA');
define('ROJO','#FF0000');
define('VERDE','#00FF00');
define('NARANJA','#ffa900');
if(!isset($_REQUEST['ciudad']))$_REQUEST['ciudad']='';  
//$_REQUEST['ciudad']='';

include('config_events_new.php');    

include_once 'functions.php';    

$array_hores=seleccionar_plantilla_graella($_REQUEST['tipus']);	  


define('TEMPS',$_REQUEST['data']); // Dia que li arriba
$libres=false;

disponible($array_hores);


function disponible($hores) {
  global $link,$persones,$libres,$perfilg,$usuariog;
  $inicializar_no_disponibles=false;
   

$i=0;
$j=0; //mts 24012013.
$tipus=$_REQUEST['tipus'];

$disponible=0;

foreach($hores as $hora=>$info) {
$_h=$info;

$info='';

$tipus=$_REQUEST['tipus'];  

$hora=str_replace('@','',$hora);


// cas graella 1 sol cotxe
if(($_REQUEST['tipus']=='_porsche_' || $_REQUEST['tipus']=='porsche' || $_REQUEST['tipus']=='_corvette_' || $_REQUEST['tipus']=='corvette' ||  $_REQUEST['tipus']=='_lotus_' || $_REQUEST['tipus']=='_bporsche_' || $_REQUEST['tipus']=='_bcorvette_' || strrpos($_REQUEST['tipus'],'ruta_turistica')!==false) && $i%2 ){
    
	if ( $_REQUEST['tipus']=='_bporsche_' ||$_REQUEST['tipus']=='_bcorvette_' )
	{
	if(!(($i+1)%$persones))echo '<tr><td colspan="3" style="height:1px;background:#444"></td></tr>';
    echo $sep; 
	}

    $i++;
    continue ; 
}

// cas graella buggy (2,3 fins a 4 persones per separació)
if($_REQUEST['tipus']=='_buggy_')
{
 //&& $i%2 
    switch($persones)
	{
		case 2:$mod=2;break;
		case 3:$mod=4;break;
		case 4:$mod=0;break;
		default: $mod=0;
	}
	if ($mod && ($i+1)%$mod==0 && $i)
		{
		$i++;
		continue;
		}
}

$sep=''; 
$hora_bona=$hora;  

 
if($_REQUEST['tipus']=='_bferrari_' || $_REQUEST['tipus']=='_blamborghini_' || $_REQUEST['tipus']=='_bporsche_' || $_REQUEST['tipus']=='_bcorvette_' || $_REQUEST['tipus']=='formula')
  $transform = 2;
//mts 24012013
else if($_REQUEST['tipus'] == '_buggy_') {$transform=3;} 
//fi mts.  
else $transform = 1;
//echo('transform: '.$transform.' persones: '.$persones);
$hora = label_hora($hora, $persones, $transform);                                                       

    $perms=permisos($tipus,TEMPS,$hora_bona);  
	//echo('hb:'.$hora_bona.',h2:'.TEMPS.',PERMS: '.$perms);


    // CAS RESERVA SOCI INACTIVA PERO DINS DEL PLAÇ
    if(substr($perms,0,2)!='@@') 
	{       
		//echo(marca_bautizo(TEMPS,$hora_bona,$tipus));
		if (!marca_bautizo(TEMPS,$hora_bona,$tipus))
		{

		  $disponible++;
			
		}

    }
	
  echo 'DISPONIBLE: ' . $disponible;
   
}

