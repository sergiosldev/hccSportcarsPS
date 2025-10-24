<?php
/* Classe amb  diferents funcions de calendari*/


if(!isset($_REQUEST['ciudad']))$_REQUEST['ciudad']='';
//$_REQUEST['ciudad']='';

include 'dies_graella.php';
include('config_events_new.php');
include_once 'functions.php';

class CalendarioHoteles { 

// Constructor
public function Calendario_Hoteles() // 
 {}  
 
 // Traductor Ingles Espa�ol Del dia de la setmana
public function traducir_dia_semanah($diasemana) 
   {
   if($diasemana=='Saturday')return 'Sabado';
   else if($diasemana=='Sunday')return 'Domingo';
   else if($diasemana=='Monday')return 'Lunes';
   else if($diasemana=='Tuesday')return 'Martes';
   else if($diasemana=='Wednesday')return 'Miercoles';
   else if($diasemana=='Thursday')return 'Jueves';
   else if($diasemana=='Friday')return 'Viernes';
   }
// Torna posicio dia setmana 
   
public function devolver_ordenh($diasemana) // torna ordre de dia
   {
   if($diasemana=='Saturday')return 6;
   else if($diasemana=='Sunday')return 7;
   else if($diasemana=='Monday')return 1;
   else if($diasemana=='Tuesday')return 2;
   else if($diasemana=='Wednesday')return 3;
   else if($diasemana=='Thursday')return 4;
   else if($diasemana=='Friday')return 5;
   }

// Torna any bisiesto   
public function bisiestoh($ano) // 2008 es bisiesto
   {return ($aux=(2008-$ano)%4)==0;}  
   
// Torna els dies d'un mes
public function devolver_diasmesh($mes,$ano) // devuelve los dias que tiene un mes
   {
   if($mes==1|| $mes==3|| $mes==5 || $mes==7 || $mes==8|| $mes==10 || $mes==12)return 31;
   else if($mes==4|| $mes==6 || $mes==9 || $mes==11)return 30;
   if($this->bisiestoh($ano))return 29;
   return 28;
   }  

// Genera el calendario d'un mes
public function genera_calendario_mesh($mes,$ano,$accion='',$dia_marcado=false)
{
 
echo '<span class="calendario"><a href="javascript:anoh(\'-\')">  <img src="'.URL_ROOT.'img/esquerra.gif"  alt="" /> </a>'.$ano.'<a href="javascript:anoh(\'+\')">  <img src="'.URL_ROOT.'img/dreta.gif"  alt="" /> </a></span>'; // COLOCAR EL MES
$this->genera_calendario_mes_h($mes,$ano,$accion,$dia_marcado);
}

private function genera_calendario_mes_h($mes,$ano,$dias_marcados)
{
	
//$dies_ocupats=dies_ocupats();	

$_MESES['cas']=array('Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre');

echo '<span class="calendario"><a href="javascript:mesh(\'-\')">  <img src="'.URL_ROOT.'img/esquerra.gif"  alt="" /> </a> '.strtoupper($_MESES['cas'][$mes-1]).' <a href="javascript:mesh(\'+\')">  <img src="'.URL_ROOT.'img/dreta.gif"  alt="" /> </a> </span>'; // COLOCAR EL MES
echo '<table border=0 class="calendario">'; // CREAR TAULA
echo '<tr class="calendario"><td >Lun</td><td>Mar</td><td>Mier</td><td>Jue</td><td>Vier</td><td>Sab</td><td>Dom</td></tr><tr>'; // COLOCAR 
 //mts 29042012
 date_default_timezone_set("Europe/Paris");
 //fin mts.
 $MARCAUNIX=mktime(0,0,0,$mes,1,$ano); //calcula en que cau el primer dia
 $tiempo=getdate($MARCAUNIX);

$orden_dia=$this->devolver_ordenh($tiempo['weekday']);


$fila=1; // variable que conta les files
if ($_REQUEST['ciudad']=='') $ciudad='barcelona';
else $ciudad=strtolower($_REQUEST['ciudad']);

for($i=1;$i<$orden_dia;$i++) echo '<td></td>'; // per situar el primer dia
for($i=1;$i<=$this->devolver_diasmesh($mes,$ano);$i++) 
    { 
     $MARCAUNIX=mktime(0,0,0,$mes,$i,$ano);
	 $tiempo=getdate($MARCAUNIX);
	 
	 
	 
	 /*$dias_marcados=array('Lunes','Martes','Miercoles','Jueves','Viernes'); //25092012
	 //$marcat='marcat_blau'; modif mts 25092012
	 if(in_array($this->traducir_dia_semanah($tiempo['weekday']),$dias_marcados))   
        $marcat='marcat';   
     else  $marcat = 'marcat_blau';
     // fin modif mts.
	 */ 
	 $aux_i=$i;
	 $aux_mesh=$mes;
	 if(strlen($i)==1) $aux_i='0'. $aux_i;
	 if(strlen($mes)==1) $aux_mesh='0'. $aux_mesh;
	 
	 
	 /****/
	 //$click='onclick="click_dia(\''.$ano.'-'.$aux_mes.'-'. $aux_i.'\')"';
	 $click='';
	 /*if(in_array($ano.'-'.$aux_mesh.'-'. $aux_i,dies_ocupats()))
	 {
		
		 	if(in_array($ano.'-'.$aux_mesh.'-'. $aux_i,dies_ocupats_color($ano.'-'.$aux_mesh.'-'. $aux_i)))
			{
				if($ano.'-'.$aux_mesh.'-'. $aux_i == '2015-05-09')
				{
				echo('col ');
				//var_dump(dies_ocupats_color($ano.'-'.$aux_mesh.'-'. $aux_i));
				}
				$marcat_calendario_defecto='no_marcat'; $click='onclick="click_dia(\''.$ano.'-'.$aux_mesh.'-'. $aux_i.'\')"'; 
			}
			else if(dies_ocupats_lila($ano.'-'.$aux_mesh.'-'. $aux_i))
			{
			    $marcat_calendario_defecto='marcat_lila';   $click='onclick="click_diah(\''.$ano.'-'.$aux_mesh.'-'. $aux_i.'\')"';
            }
			else if(dies_ocupats_gris($ano.'-'.$aux_mesh.'-'. $aux_i))
			{
                $marcat_calendario_defecto='marcat_gris';   $click='onclick="click_diah(\''.$ano.'-'.$aux_mesh.'-'. $aux_i.'\')"';
            }
			else if(dies_ocupats_negre($ano.'-'.$aux_mesh.'-'. $aux_i))
			{
                $marcat_calendario_defecto='marcat_negre';   $click='onclick="click_diah(\''.$ano.'-'.$aux_mesh.'-'. $aux_i.'\')"';
			}
			else
			{
			    $marcat_calendario_defecto='marcat'; 
				$click='onclick="click_diah(\''.$ano.'-'.$aux_mesh.'-'. $aux_i.'\')"';				
			}
		}
		*/
/****/
	 $marcat_calendario_defecto='marcat_blau';
	 $click='onclick="click_diah(\''.$ano.'-'.$aux_mesh.'-'. $aux_i.'\')"';
	 
	 $hs=hotel_secundario($ano.'-'.$aux_mesh.'-'.$aux_i,$ciudad);
	 $hd=hotel_defecto($ano.'-'.$aux_mesh.'-'.$aux_i,$ciudad);
	 //echo($hs.'-'.$hd.' ');
	 $ninguna_disponibilidad=($hs==2 || ($hs==0 && $hd==0));
	 $marcat=$ninguna_disponibilidad?'marcat_marro':(($hs==1)?'marcat_taronja':$marcat_calendario_defecto);          
	 //$marcat='no_marcat'; $click='onclick="click_dia(\''.$ano.'-'.$aux_mes.'-'. $aux_i.'\')"'; 
	 
	 if($this->traducir_dia_semanah($tiempo['weekday'])=='Domingo')
	 {
	   //$marcat='marcat';	
	   $cad_aux='<td class="calendario '.$marcat.'" '.$click.' >'.$i.'</td></tr><tr>';
	   $fila++; // augmenta fila
	 }
	 else 
	 {
	  $dias_marcados=array('Lunes','Martes','Miercoles','Jueves','Viernes');
	  
	 if(in_array($this->traducir_dia_semanah($tiempo['weekday']),$dias_marcados))   
	 {
	  if ($marcat==$marcat_calendario_defecto)
	  {
		$marcat='marcat';
	  }
	  //$click='';
      $cad_aux='<td class="calendario '.$marcat.'" '.$click.' >'.$i.'</td>';
	 } 
     else 
	 {
	 $cad_aux='<td class="calendario '.$marcat.'" '.$click.' >'.$i.'</td>';
	 }
	
     }
	  echo $cad_aux;
	 }
 for($j=0;$j<=1;$j++)echo '<td>&nbsp;</td>';	 
  for($j=$fila;$j<=5;$j++)echo '</tr><tr><td>&nbsp;</td>';	 
  echo '</tr></table>';
  }
 
}

$a=new CalendarioHoteles();
// per saber vermells mirar si num events dia correspon amb num hores


$a->genera_calendario_mesh($_GET['mes'],$_GET['ano'],$dies_ocupats); // li hem de dir mns i any



function hotel_secundario($dia,$ciudad)
{
   global $link;
   $array=array();
   
   $sql='SELECT * FROM  ps_hoteles_disponibles hd,ps_hotel h
         where hd.codigo_hotel=h.codigo and hd.ciudad=h.ciudad and 
               hd.ciudad = \''.$ciudad.'\'  and hd.fecha = date(\''.$dia.' 00:00:00\') and h.defecto=0';   
   $result=mysqli_query($link,$sql);
   //die($sql);
	$ret=0;//no hay hotel secundario
	while($r=mysqli_fetch_assoc($result)) 
	{
	    	$disponibilidad=$r['disponibilidad'];
	    	if ($disponibilidad==1) $ret=1;//hotel secundario con disponibilidad
	    	else $ret=2; //hotel secundario sin disponibilidad
	    	break;
	}
	
	return $ret;	
}


function hotel_defecto($dia,$ciudad)  
{
   global $link;
   $array=array();
   
   $sql='SELECT * FROM  ps_hoteles_disponibles hd,ps_hotel h
         where hd.codigo_hotel=h.codigo and hd.ciudad=h.ciudad and 
               hd.ciudad = \''.$ciudad.'\'  and hd.fecha = date(\''.$dia.' 00:00:00\') and h.defecto=1';   
   $result=mysqli_query($link,$sql);
   $ret=1;
   
   while($r=mysqli_fetch_assoc($result)) 
	{
	    	$ret=0;
			break;
	}
	
	return $ret;	
}

function dies_ocupats() 
{
   global $link;
   $array=array();

   $ciudad=($_REQUEST['ciudad']=='barcelona')?'':$_REQUEST['ciudad'];
   $sql='SELECT distinct data FROM  disponibles'.$ciudad;
   	
//die($sql);
   $result=mysqli_query($link,$sql);
	 while($r=mysqli_fetch_assoc($result)) {
	   $array[]= $r['data'].'';	
	 }
	return $array;	
}

function dies_ocupats_color($data)	
{
		
// SELECT DISTINCT(i.dia) FROM inscrits as i WHERE 8 in (SELECT COUNT(dia) FROM inscrits GROUP BY dia)
   global $link;
   $array=array();
   
   $ciudad=($_REQUEST['ciudad']=='barcelona')?'':$_REQUEST['ciudad'];   
   $sql='SELECT distinct data FROM  disponibles'.$ciudad.' WHERE color="1" and data="'.$data.'"';   
   //echo($sql);
   $result=mysqli_query($link,$sql);
	while($r=mysqli_fetch_assoc($result)) 
	{
	    $array[]= $r['data'].'';	
	}
	return $array;	
}

function dies_ocupats_negre($data) 
	{
	    global $link;
		$ciudad=($_REQUEST['ciudad']=='barcelona')?'':$_REQUEST['ciudad'];
	    $sql='SELECT distinct data FROM  disponibles'.$ciudad.' WHERE  color="5" AND data="'.$data.'" ';
	       
	    $result=mysqli_query($link,$sql);
	    if(mysqli_num_rows($result) )return true;
	    return false;
	}
	

function dies_ocupats_lila($data)	
	{ 
	global $link;
    $ciudad=($_REQUEST['ciudad']=='barcelona')?'':$_REQUEST['ciudad'];
    $sql='SELECT distinct data FROM  disponibles'.$ciudad.' WHERE color="3" AND data="'.$data.'" ';                 
   
    $result=mysqli_query($link,$sql);
	if(mysqli_num_rows($result) )return true;
	return false;	
	}

//mts 07052012
function dies_ocupats_gris($data)   
    { 
    global $link;
   
    $ciudad=($_REQUEST['ciudad']=='barcelona')?'':$_REQUEST['ciudad'];
	$sql='SELECT distinct data FROM  disponibles'.$_REQUEST['ciudad'].' WHERE color="4" AND data="'.$data.'" ';      
    
    $result=mysqli_query($link,$sql);
    if(mysqli_num_rows($result) )return true;
    return false;   
    }

  
?>
