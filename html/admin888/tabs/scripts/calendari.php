<?php
/* Classe amb  diferents funcions de calendari*/


if(!isset($_REQUEST['ciudad']))$_REQUEST['ciudad']='';
//$_REQUEST['ciudad']='';
include 'dies_graella.php';
include('config_events_new.php');
include_once 'functions.php';

class Calendari 
{  

// Constructor
public function Calendario() // S'ha d'arrelar tot   
 {}   

public function seleccionar_plantilla_graella($tipus)                                     
{                  
	if($tipus == '_buggy_')
	  include 'dies_graella4.php';                                            
	  //include 'dies_graella3.php';
	  //include 'd ies_graella.php';
	else if($tipus=='_bferrari_' || $tipus=='_blamborghini_' || $tipus=='_bporsche_' || $tipus=='_bcorvette_' || $tipus=='formula')                                       
	  include 'dies_graella4.php';   
	else 
	  include 'dies_graella.php';	        	                 
	
	return $array_hores;                                                                                        
}  


function dia_libre($dia,$tipus)                                                           
{                             	
	global $link;
	$hores1=$this->seleccionar_plantilla_graella($tipus);
	

	
/*	if (substr($dia,0,10)=='2015-10-03' && $tipus='_blamborghini_')                    
	{
		//var_dump($hores1);die;
	}           
	*/
	
	$hores=array();
	$i=0;
  
	foreach ($hores1 as $h=>$info)
	{
		if($h=='c' || !$h) continue;
		
		//if(($tipus=='_bferrari_' || $tipus=='_blamborghini_') && intval(substr($dia,5,2))>=10 && $i%2)                                               
		/*if(($tipus=='_bferrari_' ) && intval(substr($dia,5,2))>=10 && $i%2)                                               
		{
		    $i++;
		    continue ;
		}*/
		
		/*if(($tipus=='_porsche_' || $tipus=='_corvette_' ||  $tipus=='_lotus_' || $tipus=='_bporsche_' || $tipus=='_bcorvette_' || strrpos($tipus,'ruta_turistica')!==false) && $i%2) )
		//if( (strrpos($tipus,'ruta_turistica')!==false && $i%2) )
		{
		    $i++;
		    continue ;
		}*/
		
		/*****
		if(($tipus=='_bferrari_' || $tipus=='_blamborghini_') && intval(substr($dia,5,2))>=10 && $i%2)                
		{
		    $i++;
		    continue ;
		}
		*/
		
		if(($tipus=='_porsche_' || $tipus=='_corvette_' ||  $tipus=='_lotus_' || $tipus=='_bporsche_' || $tipus=='_bcorvette_' || strrpos($tipus,'ruta_turistica')!==false) && $i%2 )
		{
		    $i++;
		    continue ;
		}
		
		
		//if ($i%2) {$i++;continue;}
		else 
		{
			$hores[$h]=$info;  
			$i++;
		}	
	}
	
	//if ($dia=='2015-11-21') var_dump($hores);   
	
	$libre=false;          
	foreach($hores as $hora=>$info)                                        
	{   
		$hora_tmp=$dia.'@'.$hora;        
		
		$sql = ' select id_event from events'.$_REQUEST['ciudad'].' where id_event = "'.$hora_tmp.'" and tipus_event = "'.$tipus.'"';                                                                                                             
		//if ($hora=='08:07:00') echo($sql);
		//$result=mysql_query($sql,$link);                                             
		$result=mysqli_query($link,$sql);                                             
		$r=mysqli_fetch_assoc($result);                    

   
		
		if (mysqli_num_rows($result) == 0)              
		{
		    		     
/*		    if ($dia=='2015-09-26')
		    {   
			echo($sql);die;
		      //  die($r['id_event'].$sql);   
		    } */
			//die($sql);    
			if ($dia=='2015-04-18')      
			{  
				echo($sql);     
			}
		    
			$libre=true;
			break; 
		}
		else
		{
		}  
	}
		
		
return $libre;	
}


 
 
  
 // Traductor Ingles Espaï¿½ol Del dia de la setmana
public function traducir_dia_semana($diasemana) 
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
   
public function devolver_orden($diasemana) // torna ordre de dia
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
public function bisiesto($ano) // 2008 es bisiesto
   {return ($aux=(2008-$ano)%4)==0;}  
   
// Torna els dies d'un mes
public function devolver_diasmes($mes,$ano) // devuelve los dias que tiene un mes
   {
   if($mes==1|| $mes==3|| $mes==5 || $mes==7 || $mes==8|| $mes==10 || $mes==12)return 31;
   else if($mes==4|| $mes==6 || $mes==9 || $mes==11)return 30;
   if($this->bisiesto($ano))return 29;
   return 28;
   }  

// Genera el calendario d'un mes
public function genera_calendario_mes($mes,$ano,$accion='',$dia_marcado=false)
{
 
echo '<span class="calendario"><a href="javascript:ano(\'-\')">  <img src="'.URL_ROOT.'img/esquerra.gif"  alt="" /> </a>'.$ano.'<a href="javascript:ano(\'+\')">  <img src="'.URL_ROOT.'img/dreta.gif"  alt="" /> </a></span>'; // COLOCAR EL MES
$this->genera_calendario_mes_($mes,$ano,$accion,$dia_marcado);
}

private function genera_calendario_mes_($mes,$ano,$dias_marcados)
{
	
$dies_ocupats=dies_ocupats();	

$_MESES['cas']=array('Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre');                                                     

echo '<span class="calendario"><a href="javascript:mes(\'-\')">  <img src="'.URL_ROOT.'img/esquerra.gif"  alt="" /> </a> '.strtoupper($_MESES['cas'][$mes-1]).' <a href="javascript:mes(\'+\')">  <img src="'.URL_ROOT.'img/dreta.gif"  alt="" /> </a> </span>'; // COLOCAR EL MES                                       
echo '<table border=0 class="calendario">'; // CREAR TAULA                      
echo '<tr class="calendario"><td >Lun</td><td>Mar</td><td>Mier</td><td>Jue</td><td>Vier</td><td>Sab</td><td>Dom</td></tr><tr>'; // COLOCAR                                  
 //mts 29042012
 date_default_timezone_set("Europe/Paris");                
 //fin mts.
 $MARCAUNIX=mktime(0,0,0,$mes,1,$ano); //calcula en que cau el primer dia        
 $tiempo=getdate($MARCAUNIX);          

$orden_dia=$this->devolver_orden($tiempo['weekday']);          


$fila=1; // variable que conta les files            
$ocupat='';

for($i=1;$i<$orden_dia;$i++) echo '<td></td>'; // per situar el primer dia               
for($i=1;$i<=$this->devolver_diasmes($mes,$ano);$i++)                 
    {          
     $MARCAUNIX=mktime(0,0,0,$mes,$i,$ano);     
	 $tiempo=getdate($MARCAUNIX);
	 
	 
	 
	 $dias_marcados=array('Lunes','Martes','Miercoles','Jueves','Viernes'); //25092012                                    
	 //$marcat='marcat_blau'; modif mts 25092012
	 if(in_array($this->traducir_dia_semana($tiempo['weekday']),$dias_marcados))   
        $marcat='marcat';   
     else  $marcat = 'marcat_blau';
     // fin modif mts.
	 
	 $aux_i=$i;
	 $aux_mes=$mes;
	 if(strlen($i)==1) $aux_i='0'. $aux_i;
	 if(strlen($mes)==1) $aux_mes='0'. $aux_mes;
	 
	 $click='onclick="click_dia(\''.$ano.'-'.$aux_mes.'-'. $aux_i.'\')"';
	 $ocupat='';  
	 if(in_array($ano.'-'.$aux_mes.'-'. $aux_i,dies_ocupats()))
	 {
		 	if(in_array($ano.'-'.$aux_mes.'-'. $aux_i,dies_ocupats_color())){
				$marcat='no_marcat'; $click='onclick="click_dia(\''.$ano.'-'.$aux_mes.'-'. $aux_i.'\')"'; 
			}
			else if(dies_ocupats_lila($ano.'-'.$aux_mes.'-'. $aux_i)){
			    $marcat='marcat_lila'; $click='onclick="click_dia(\''.$ano.'-'.$aux_mes.'-'. $aux_i.'\')"'; 
            }else if(dies_ocupats_gris($ano.'-'.$aux_mes.'-'. $aux_i)){
                $marcat='marcat_gris'; $click='onclick="click_dia(\''.$ano.'-'.$aux_mes.'-'. $aux_i.'\')"'; 
            }else if(dies_ocupats_negre($ano.'-'.$aux_mes.'-'. $aux_i)){
                $marcat='marcat_negre'; $click='onclick="click_dia(\''.$ano.'-'.$aux_mes.'-'. $aux_i.'\')"'; 

			}else{
			    $marcat='marcat'; $click='onclick="click_dia(\''.$ano.'-'.$aux_mes.'-'. $aux_i.'\')"'; 
			 }
			//Comprobamos si existe algün día en el calenadrio.    

			
				
			$dia_libre = intval($this->dia_libre($ano.'-'.$aux_mes.'-'.$aux_i,$_REQUEST['tipus']));    
			
			//die('dialibre: '.$dia_libre);                              
			$ocupat='';
			if (!$dia_libre && $marcat!='marcat_negre')                      
			{
				//$marcat='marcat_lila'; $click='onclick="click_dia(\''.$ano.'-'.$aux_mes.'-'. $aux_i.'\')"';                                                              
				$ocupat=' (Oc.)';
			}     
			//if ($ano.'-'.$aux_mes.'-'.$aux_i=='2015-09-27' and $_REQUEST['tipus']=='_bferrari_')
						
			/*if (!$dia_libre && $marcat!='marcat_negre')
			{
				$marcat='marcat_lila'; $click='onclick="click_dia(\''.$ano.'-'.$aux_mes.'-'. $aux_i.'\')"'; 
			} 
			
			
*/     		
		}
		


		
/*
if($marcat!='marcat_blau' && ($this->traducir_dia_semana($tiempo['weekday'])=='Domingo' 
 || $this->traducir_dia_semana($tiempo['weekday'])=='Sabado')){
   	
 if(!graella_oc($ano.'-'.$aux_mes.'-'. $aux_i)){
 	$marcat='marcat'; $click='onclick="click_dia(\''.$ano.'-'.$aux_mes.'-'. $aux_i.'\')"'; 
 }
 }

*/
	 
	 if($this->traducir_dia_semana($tiempo['weekday'])=='Domingo')
	 {
	   $cad_aux='<td class="calendario '.$marcat.'" '.$click.' >'.$i.$ocupat.'</td></tr><tr>';
	   $fila++; // augmenta fila
	 }
	 else {
	  $dias_marcados=array('Lunes','Martes','Miercoles','Jueves','Viernes');
	  
	  /*if(in_array($this->traducir_dia_semana($tiempo['weekday']),$dias_marcados))	
	  $cad_aux='<td class="calendario marcat"  >'.$i.'</td>';
	 else $cad_aux='<td class="calendario '.$marcat.'" '.$click.' >'.$i.'</td>';
	 */
	 if(in_array($this->traducir_dia_semana($tiempo['weekday']),$dias_marcados))   
      //$cad_aux='<td class="calendario marcat"  >'.$i.'</td>';
      $cad_aux='<td class="calendario '.$marcat.'" '.$click.' >'.$i.'</td>';
     else $cad_aux='<td class="calendario '.$marcat.'" '.$click.' >'.$i.$ocupat.'</td>';
	
     }
	  echo $cad_aux;
	 }
 for($j=0;$j<=1;$j++)echo '<td>&nbsp;</td>';	 
  for($j=$fila;$j<=5;$j++)echo '</tr><tr><td>&nbsp;</td>';	 
  echo '</tr></table>';
  }
 
}

$a=new Calendari();

// per saber vermells mirar si num events dia correspon amb num hores


$a->genera_calendario_mes($_GET['mes'],$_GET['ano'],$dies_ocupats); // li hem de dir mns i any

function dies_ocupats() 
{
// SELECT DISTINCT(i.dia) FROM inscrits as i WHERE 8 in (SELECT COUNT(dia) FROM inscrits GROUP BY dia)
   global $link;
   $array=array();
   //$sql='SELECT * FROM  disponibles'.$_REQUEST['ciudad'].' WHERE evento="'.$_REQUEST['tipus'].'" ';

   //Para las rutas turísticas, para un tipo de evento dado, mostraremos el mismo calendario. 
   if (strpos($_REQUEST['tipus'],'ruta_turistica')!==false)   
   {	
   	if (strpos($_REQUEST['tipus'],'ferrari')!==false)
   	{
   		$where = ' evento like "%ferrari%"';
   	}
   	else   	if (strpos($_REQUEST['tipus'],'lamborghini')!==false)
   	{
   		$where = ' evento like "%lamborghini%"';
   		
   	}
   }	
   else $where = ' evento="'.$_REQUEST['tipus'].'" ';
   
   $sql='SELECT * FROM  disponibles'.$_REQUEST['ciudad'].' WHERE '.$where;
   	

   //$result=mysql_query($sql,$link);
   $result=mysqli_query($link,$sql);
   if ($result)
   while($r=mysqli_fetch_assoc($result)) {
	   $array[]= $r['data'].'';	
	 }
	return $array;	
}

function dies_ocupats_color()	{
		
// SELECT DISTINCT(i.dia) FROM inscrits as i WHERE 8 in (SELECT COUNT(dia) FROM inscrits GROUP BY dia)
   global $link;
   $array=array();
   
   //$sql='SELECT * FROM  disponibles'.$_REQUEST['ciudad'].' WHERE evento="'.$_REQUEST['tipus'].'" AND color="1" ';
   //Para las rutas turísticas, para un tipo de evento dado, mostraremos el mismo calendario. 
   if (strpos($_REQUEST['tipus'],'ruta_turistica')!==false)   
   {	
   	if (strpos($_REQUEST['tipus'],'ferrari')!==false)
   	{
   		$where = ' evento like "%ferrari%"';
   	}
   	else   	if (strpos($_REQUEST['tipus'],'lamborghini')!==false)
   	{
   		$where = ' evento like "%lamborghini%"';
   		
   	}
   }	
   else $where = ' evento="'.$_REQUEST['tipus'].'" ';
   
   $sql='SELECT * FROM  disponibles'.$_REQUEST['ciudad'].' WHERE '.$where. ' AND color="1" ';   
   //$result=mysql_query($sql,$link);
   $result=mysqli_query($link,$sql);
	while($r=mysqli_fetch_assoc($result)) {
	    $array[]= $r['data'].'';	
	}
	return $array;	
}

function dies_ocupats_negre($data) 
	{
	    global $link;
	    //$sql='SELECT * FROM  disponibles'.$_REQUEST['ciudad'].' WHERE evento="'.$_REQUEST['tipus'].'" AND color="3" AND data="'.$data.'" ';
	
	    //Para las rutas turísticas, para un tipo de evento dado, mostraremos el mismo calendario.
	    if (strpos($_REQUEST['tipus'],'ruta_turistica')!==false)
	    {
	        if (strpos($_REQUEST['tipus'],'ferrari')!==false)
	        {
	            $where = ' evento like "%ferrari%"';
	        }
	        else   	if (strpos($_REQUEST['tipus'],'lamborghini')!==false)
	        {
	            $where = ' evento like "%lamborghini%"';
	             
	        }
	    }
	    else $where = ' evento="'.$_REQUEST['tipus'].'" ';
	     
	    //color 3: cerrado, color 5:suspendido y enviado al limbo.
	    $sql='SELECT * FROM  disponibles'.$_REQUEST['ciudad'].' WHERE '.$where. ' AND color="5" AND data="'.$data.'" ';
	       
	    //$result=mysql_query($sql,$link);
		$result=mysqli_query($link,$sql);
	    if(mysqli_num_rows($result) )return true;
	    return false;
	}
	

function dies_ocupats_lila($data)	
	{ 
	global $link;
   //$sql='SELECT * FROM  disponibles'.$_REQUEST['ciudad'].' WHERE evento="'.$_REQUEST['tipus'].'" AND color="3" AND data="'.$data.'" ';
    
   //Para las rutas turísticas, para un tipo de evento dado, mostraremos el mismo calendario. 
   if (strpos($_REQUEST['tipus'],'ruta_turistica')!==false)   
   {	
   	if (strpos($_REQUEST['tipus'],'ferrari')!==false)
   	{
   		$where = ' evento like "%ferrari%"';
   	}
   	else   	if (strpos($_REQUEST['tipus'],'lamborghini')!==false)
   	{
   		$where = ' evento like "%lamborghini%"';
   		
   	}
   }	
   else $where = ' evento="'.$_REQUEST['tipus'].'" ';
   
   //color 3: cerrado, color 5:suspendido y enviado al limbo.
   $sql='SELECT * FROM  disponibles'.$_REQUEST['ciudad'].' WHERE '.$where. ' AND (color="3") AND data="'.$data.'" ';   
   
   //$result=mysql_query($sql,$link);
    $result=mysqli_query($link,$sql);
	if(mysqli_num_rows($result) )return true;
	return false;	
	}

//mts 07052012
function dies_ocupats_gris($data)   
    { 
    global $link;
   //$sql='SELECT * FROM  disponibles'.$_REQUEST['ciudad'].' WHERE evento="'.$_REQUEST['tipus'].'" AND color="4" AND data="'.$data.'" ';
   //Para las rutas turísticas, para un tipo de evento dado, mostraremos el mismo calendario. 
   if (strpos($_REQUEST['tipus'],'ruta_turistica')!==false)   
   {	
   	if (strpos($_REQUEST['tipus'],'ferrari')!==false)
   	{
   		$where = ' evento like "%ferrari%"';
   	}
   	else   	if (strpos($_REQUEST['tipus'],'lamborghini')!==false) 
   	{
   		$where = ' evento like "%lamborghini%"';
   		
   	}
   }	
   else $where = ' evento="'.$_REQUEST['tipus'].'" ';
   
   $sql='SELECT * FROM  disponibles'.$_REQUEST['ciudad'].' WHERE '.$where. ' AND color="4" AND data="'.$data.'" ';   
    
   //$result=mysql_query($sql,$link);
   $result=mysqli_query($link,$sql);
    if(mysqli_num_rows($result) )return true;
    return false;   
    }




?>
