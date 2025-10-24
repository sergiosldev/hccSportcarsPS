<?php
	include('config_events_new.php');                  
	include_once(dirname(__FILE__).'/../../../config/config.inc.php'); 
	include_once('conversiones_html.php'); 
?>

	
<style>          
*{:
	font-size:11px;	           
}	
.capsalera{
font-size:13px;
font-weight:bold;
padding:5px;
color:#555;
border:1px solid #aaa;
background:#fff;	
width:14%;	
}
.columna
{
	font-size:13px;
	width:14%;
}

.destino
{
	background:#8ff;
}

.columnar
{
	border:1px solid;
}

.dif
{
	background-color:#ff7979;
}

.eq
{
	background-color:#ffffff;
}

</style>	

<?php   
  
  $fecha_inicial='2015-09-01';		                                                                       
  
  $sql=' select r.*,e.email_confirm,e.email,e.email_persona_regala 
		 from reubicaciones r,events'.request('ciudad').' e
		 where r.seguimiento=e.reubicado and 
			   e.reubicado!=0 and 
			   e.id="'.request('id').'" ';                                                                       
  //die($sql);
  $result=mysqli_query($link,$sql);                                                                   
  $n=mysqli_num_rows($result);                                                                   
  
  if (!$n) die ('@ERROR@');
  	

  echo('<div style="width:100%;margin:0 auto;margin-bottom:60px;">
	   <label style="margin:0 auto;margin-bottom:30px;width:50%;">REUBICACIONES (a partir de 26/09/2015)</label><br>');
  echo '<table width="100%">';
 
  echo '<tr>                   
	 <td class="capsalera" >Fecha Reubicaci&oacute;n</td>                                                                                                                                                                             
	 <td class="capsalera" >Email piloto</td>                                                                                                                                                                             
	 <td class="capsalera" >Email persona regala</td>                                                                                                                                                                             
	 <td class="capsalera" >Email confirm.</td>                                                                                                                                                                             
	 <td class="capsalera" >Ciudad Or&iacute;gen</td>                                                                                                                                                                             
	 <td class="capsalera" >Dia/hora Or&iacute;gen</td>            
	 <td class="capsalera" >Veh&iacute;culo Origen</td>                                                                                        
	 <td class="capsalera destino" >Ciudad Destino</td>                                                                                                                                                                             
	 <td class="capsalera destino" >Dia/hora Destino</td>            
	 <td class="capsalera destino" >Veh&iacute;culo Destino</td>                                                                                           
	 </tr>';	
 
$k=0;
 while($r=mysqli_fetch_object($result))  
	 {		
	 $sfecha=substr($r->fecha,0,10);
	 $sciudad_origen=($r->ciudad_origen=='')?'BARCELONA':strtoupper($r->ciudad_origen);
	 $sciudad_destino=($r->ciudad_destino=='')?'BARCELONA':strtoupper($r->ciudad_destino);
	 $email_piloto=trim($r->email);
	 $email_regala=trim($r->email_persona_regala);
	 $email_confirm=trim($r->email_confirm);
	 echo '<tr id="fila'.$r->id.'" style="background:'.$color.';border:1px solid;">';  
	 echo '<td class="columnar">'.$r->fecha.'</td>';    
	 echo '<td class="columnar">'.$email_piloto.'</td>';    
	 echo '<td class="columnar">'.$email_regala.'</td>';    
	 echo '<td class="columnar">'.$email_confirm.'</td>';    
	 $clase=($sciudad_origen!=$sciudad_destino)?'dif':'eq';
	 echo '<td class="columnar '.$clase.'">'.$sciudad_origen.'</td>';    
	 $clase=($r->fecha_origen!=$r->fecha_destino)?'dif':'eq';
	 echo '<td class="columnar '.$clase.'">'.$r->fecha_origen.'</td>';    
	 $clase=($r->tipo_origen!=$r->tipo_destino)?'dif':'eq';
	 echo '<td class="columnar '.$clase.'">'.return_tipus_e($r->tipo_origen).'</td>';    
	 echo '<td class="columnar destino" >'.$sciudad_destino.'</td>';    
	 echo '<td class="columnar destino">'.$r->fecha_destino.'</td>';    
	 echo '<td class="columnar destino">'.return_tipus_e($r->tipo_destino).'</td>';    
	 $k++;
 
	 echo '</tr>';		
	 }

 echo '</table>';
  
  
  
 function convert_caracters_hex($cad)
  {
 
  $cad=str_replace('ó', '&#243;', $cad);	
  $cad=str_replace('é', '&#233;', $cad);		
  $cad=str_replace('ñ', '&#241;', $cad);	
  $cad=str_replace('ú', '&#250;', $cad);	
  $cad=str_replace('á', '&#225;', $cad);		
  $cad=str_replace('í', '&#237;', $cad);
  $cad=str_replace('ç', '&#231;', $cad);
  $cad=str_replace('ò', '&#242;', $cad);	
  $cad=str_replace('è', '&#232;', $cad);		
  $cad=str_replace('ù', '&#249;', $cad);	
  $cad=str_replace('à', '&#224;', $cad);		
  $cad=str_replace('ì', '&#236;', $cad);
  $cad=str_replace('ñ', '&#241;', $cad);
  return $cad;
  }
  
  
  
  function return_tipus_e($t)
  {
  switch($t)
  {
   case 'ferrari':
   	    return 'Ferrari 430 20 Km   ';
   break;		
   case 'ferrari_porsche901':
   	    return 'Ferrari  430 20 Km  + Porsche  20 Km   ';
   break;	
   case 'lamborghini':
         return 'Lamborghini 20 Km';
   break;		
   case 'lamborghini_lotus':
         return 'Lamborghini 20 Km  + Porsche 20 Km ';
   break;		
   case 'porsche997_porsche996':
		return 'Porsche Turbo 20 Km +  Porsche Carrera S 20 Km ';		 
   break;	
   case 'porsche996':
		return 'Porsche 20 Km ';		 
   break;
   case 'porsche997':
		return 'Porsche 20 Km ';		 
   break;
   case '_porsche_':
		return 'Porsche 20 Km ';		 
   break;	
   case '_bporsche_':
		return 'Porsche  7 Km ';		                          
   break;	
   case '_lotus_':
		return 'Porsche 20 Km ';		 
   break;			
   case '_bferrari_':
    return 'Ferrari 430 7 Km ';                         
   break;
   case '_blamborghini_':
    return 'Lamborghini 7 Km';
   break;
   case '_corvette_':
    return 'Corvette 20 Km';
   break;
   case '_bcorvette_':
    return 'Corvette 7 Km';
   break;
   // BUGGY
   case '_buggy_':
    return 'BUGGY ';
   break;

  }	
  }  
  
   
  function  normalizar($cads)
  {
    $originales =  'ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜÝÞßàáâãäåæçèéêëì	îïðñòóôõöøùúûýýþÿŔŕ';
    $modificadas = 'aaaaaaaceeeeiiiidnoooooouuuuybsaaaaaaaceeeeiiiidnoooooouuuyybyRr';
	//$str=strtr($cadena,'\t\n\r\0\x0B','     ');
	$str=strtr($cads,utf8_decode($originales),$modificadas);
	$strf='';  
	//$strf = $str;
	for($i=0;$i<strlen($str);$i++)
	{
		if ((ord($str[$i])>64 and ord($str[$i])<123) || ord($str[$i])==32) $strf.= $str[$i];
	}
	//for($i=0;$i<strlen($strf);$i++) echo(ord($strf[$i]));
	//echo('<br>');
	return $strf;
  }  
?>