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
}
.columna
{
font-size:13px;
}
</style>	
<?php

  include('config_events.php');                
	
  $nombre_apellidos = explode(' ',$_REQUEST['nombreb']);	
  $nombre_apellidos = array_map('trim',$nombre_apellidos);
  $nombre='';
  $apellido1 = '';
  $apellido2 = '';
  
  $telefono=str_replace('-','',str_replace(' ','',$_REQUEST['telefonob']));
  
  switch(count($nombre_apellidos))
  {
	case 1:	
		$nombre = $nombre_apellidos[0];
	break;
	case 2:	
		$nombre = $nombre_apellidos[0];
		$apellido1 = $nombre_apellidos[1];
	break;
	case 3:	 
		$nombre = $nombre_apellidos[0];
		$apellido1 = $nombre_apellidos[1];
		$apellido2 = $nombre_apellidos[2];
	break;

	case 4:	 
		$nombre = $nombre_apellidos[0];
		$apellido1 = $nombre_apellidos[1].' '.$nombre_apellidos[2].' '.$nombre_apellidos[3];
		$apellido2 = '';
	break;

}
 
  $apellido1 = normalizar($apellido1);
  $apellido2 = normalizar($apellido2);
  $nombre = normalizar($nombre);
 
  //$nombre = str_replace('\t','',$nombre);
  $nombre=rtrim(trim($nombre));
  //echo(ord($nombre[strlen($nombre)-1]).'a');

  $apellido1=trim($apellido1);
  $apellido2=trim($apellido2);
  

  /** CONDICIÓN CÓDIGOS **/
  $codigos = trim($_REQUEST['codigob']);                 
  
  $lista_codigos = str_replace("\r","",$codigos);             
  
  $lista_codigos = explode("\n",$codigos);                                                                                                                     
  
  //var_dump($lista_codigos);
  $lista_codigos = array_map(function ($a){return trim($a);},$lista_codigos);                                               
  $slista_codigos = implode(",",$lista_codigos);    
      
  $indice=0;
  $condicion_codigos='';
    

  foreach($lista_codigos as $scodigo)
  {
	  
  	$condicion_codigos2 =  
	  ' (codi_localtzador   like "%'.$scodigo.'%" OR
	  codi_consum    like "%'.$scodigo.'%") ';
  	   
  	if ($indice==1) 
  	{  
  		$condicion_codigos .= ' OR '.$condicion_codigos2;     
  	}    	 
  	else 
  	{
  		$condicion_codigos .= $condicion_codigos2;
  	}
  	 
  	$indice=1;	 
  	 
  }
   
  $condicion_codigos = ' ('.$condicion_codigos.') ';
  
  /** FIN CONDICIÓN CÓDIGOS **/ 
  
  
 
  $condicion_nombre1='
  ucase(pilot)  like "%'.$nombre.'%" and ucase(pilot) like "%'.$apellido1.'%" and ucase(pilot) like "%'.$apellido2.'%" 
  OR
  ucase(pilot)  like "%'.$nombre.'%" and ucase(apellidos_piloto) like "%'.$apellido1.'%" and apellidos_piloto like "%'.$apellido2.'%"';

  $condicion_nombre2='
  ucase(persona_regala) like "%'.$nombre.'%" and ucase(persona_regala) like "%'.$apellido1.'%" and ucase(persona_regala) like "%'.$apellido2.'%" 
  OR
  ucase(persona_regala) like "%'.$nombre.'%" and ucase(apellidos_persona_regala) like "%'.$apellido1.'%" and ucase(apellidos_persona_regala) like "%'.$apellido2.'%"   
  ';

  $condicion_nombre3='
  ucase(apellidos_piloto) like "%'.$nombre.'%" and ucase(apellidos_piloto) like "%'.$apellido1.'%"   
  ';

  $condicion_nombre4='
  ucase(apellidos_persona_regala) like "%'.$nombre.'%" and ucase(apellidos_persona_regala) like "%'.$apellido1.'%"   
  ';

  $condicion_nombre = '('.$condicion_nombre1.' OR '.$condicion_nombre2.' OR '.$condicion_nombre3.' OR '.$condicion_nombre4.')';

/*  $condicion_nombre.= 'OR
  persona_regala   like "%'.$nombre.'%")
  ';
*/
     	
//  $nombre = $_REQUEST['nombreb'];
//  $apellidos = $_REQUEST['nombreb'];
 

  if($_REQUEST['ciudadb']!='*')  
  $sql='SELECT *,"'.strtoupper($_REQUEST['ciudadb']).'" ciudad    
  from events'.$_REQUEST['ciudadb'].
  ' where 
  (email_persona_regala like "%'.trim($_REQUEST['emailb']).'%" OR 
  email  like "%'.trim($_REQUEST['emailb']).'%" OR
  email_confirm   like "%'.trim($_REQUEST['emailb']).'%") 
  AND
  (telefon  like "%'.trim($telefono).'%" OR
  mobil_persona_regala  like "%'.trim($telefono).'%") 
  AND
  '.$condicion_nombre.'
  AND
  '.$condicion_codigos.'
  AND
  id_event  like "%'.trim($_REQUEST['diab']).'%" 
  
  AND
  tipus_event   like "%'.trim($_REQUEST['tipob']).'%" 
  
  ORDER BY id_event 
  ';
  else $sql='
  SELECT *,"Barcelona" ciudad    from events where 
  (email_persona_regala like "%'.trim($_REQUEST['emailb']).'%" OR 
  email  like "%'.trim($_REQUEST['emailb']).'%" OR
  email_confirm   like "%'.trim($_REQUEST['emailb']).'%") 
  AND
  (telefon  like "%'.trim($telefono).'%" OR
  mobil_persona_regala  like "%'.trim($telefono).'%") 
  AND
  '.$condicion_nombre.'
  AND
  '.$condicion_codigos.'
  AND
  id_event  like "%'.trim($_REQUEST['diab']).'%" 
  
  AND
  tipus_event   like "%'.trim($_REQUEST['tipob']).'%" 
  
  
  UNION ALL
  
  SELECT *,"Madrid" ciudad    from eventsmadrid where 
  (email_persona_regala like "%'.trim($_REQUEST['emailb']).'%" OR 
  email  like "%'.trim($_REQUEST['emailb']).'%" OR
  email_confirm   like "%'.trim($_REQUEST['emailb']).'%") 
  AND
  (telefon  like "%'.trim($telefono).'%" OR
  mobil_persona_regala  like "%'.trim($telefono).'%") 
  AND
  '.$condicion_nombre.'
  AND
  '.$condicion_codigos.'
  AND
  id_event  like "%'.trim($_REQUEST['diab']).'%"   
  AND
  tipus_event   like "%'.trim($_REQUEST['tipob']).'%" 
  
  
  UNION ALL
   
  SELECT *,"Valencia" ciudad    from eventsvalencia where 
  (email_persona_regala like "%'.trim($_REQUEST['emailb']).'%" OR 
  email  like "%'.trim($_REQUEST['emailb']).'%" OR
  email_confirm   like "%'.trim($_REQUEST['emailb']).'%") 
  AND
  (telefon  like "%'.trim($telefono).'%" OR
  mobil_persona_regala  like "%'.trim($telefono).'%") 
  AND
  '.$condicion_nombre.'
  AND
  '.$condicion_codigos.'
  AND
  id_event  like "%'.trim($_REQUEST['diab']).'%" 
  
  AND
  tipus_event   like "%'.trim($_REQUEST['tipob']).'%" 
  
  
  
   
  UNION ALL
   
  SELECT *,"Andalucía" ciudad    from eventsandalucia where 
  (email_persona_regala like "%'.trim($_REQUEST['emailb']).'%" OR 
  email  like "%'.trim($_REQUEST['emailb']).'%" OR
  email_confirm   like "%'.trim($_REQUEST['emailb']).'%") 
  AND
  (telefon  like "%'.trim($telefono).'%" OR
  mobil_persona_regala  like "%'.trim($telefono).'%") 
  AND
  '.$condicion_nombre.'
  AND
  '.$condicion_codigos.'
  AND
  id_event  like "%'.trim($_REQUEST['diab']).'%" 
  
  AND
  tipus_event   like "%'.trim($_REQUEST['tipob']).'%" 
  

  
   
  UNION ALL
   
  SELECT *,"Cantabria" ciudad  from eventscantabria where 
  (email_persona_regala like "%'.trim($_REQUEST['emailb']).'%" OR 
  email  like "%'.trim($_REQUEST['emailb']).'%" OR
  email_confirm   like "%'.trim($_REQUEST['emailb']).'%") 
  AND
  (telefon  like "%'.trim($telefono).'%" OR
  mobil_persona_regala  like "%'.trim($telefono).'%") 
  AND
  '.$condicion_nombre.'
  AND
  '.$condicion_codigos.'
  AND
  id_event  like "%'.trim($_REQUEST['diab']).'%" 
  
  AND
  tipus_event   like "%'.trim($_REQUEST['tipob']).'%" 
  
  
  UNION ALL
   
  SELECT *,"rutas_turisticas" ciudad  from eventsrutas_turisticas where 
  (email_persona_regala like "%'.trim($_REQUEST['emailb']).'%" OR 
  email  like "%'.trim($_REQUEST['emailb']).'%" OR
  email_confirm   like "%'.trim($_REQUEST['emailb']).'%") 
  AND
  (telefon  like "%'.trim($telefono).'%" OR
  mobil_persona_regala  like "%'.trim($telefono).'%") 
  AND
  '.$condicion_nombre.'
  AND
  '.$condicion_codigos.'
  AND
  id_event  like "%'.trim($_REQUEST['diab']).'%" 
  
  AND
  tipus_event   like "%'.trim($_REQUEST['tipob']).'%"   
  
  ORDER BY id_event 

  ';

  
  $sql = ' select a.* from ('.$sql.') a where trim(a.pilot) != "no disponible" order by date(substr(a.id_event,1,10)) desc ';
  //die($sql);
  
  //echo $sql;
  if($_REQUEST['ciudadb']=='*')echo 'CIUDAD TODAS<br><br>'; 
  else if($_REQUEST['ciudadb']=='')echo 'CIUDAD BARCELONA<br><br>';
  else echo 'CIUDAD '.strtoupper($_REQUEST['ciudadb']).'<br><br>';
  
  $result=mysql_query($sql);
//  die($sql);
	
 echo '<table width="100%">';
  echo '<tr>
	 <td class="capsalera" >Ciudad</td>
	 <td class="capsalera" >Dia/hora</td>
	 <td class="capsalera" >Pilot</td>
	 <td class="capsalera" >Email pilot</td>
	 <td class="capsalera" >Telefon pilot</td>
	 <td class="capsalera" >Persona que regala</td>
	 <td class="capsalera" >Email persona que regala</td>
	 <td class="capsalera" >Telefon persona regala</td>
	 <td class="capsalera" >Email. Confirm</td>
	 <td class="capsalera" >Cod. Localizador</td>
	 <td class="capsalera" >Cod. Consumo</td>
	 <td class="capsalera" >Event</td>
	 <td class="capsalera" style="width:150px;">Observacions<span style="color:#fff;">_________</span></td>
	 <td class="capsalera" >Val</td>
	 <td class="capsalera" >Reubicados</td>
	 
	 </tr>';	

 while($r=mysql_fetch_object($result))
	 {		

	 $sfecha=substr($r->id_event,0,10);
	 if (substr($r->ciudad,0,5)=='Andal') $sciudad='andalucia';
	 else $sciudad=$r->ciudad;
	 $link_reserva='<a href="javascript:ir_a_reserva(\''.return_tipus($r->tipus_event).'\',\''.$sciudad.'\',\''.$sfecha.'\','.$r->id.')">';
	 $link_reubicados='<a href="javascript:ir_a_reubicaciones(\''.return_tipus($r->tipus_event).'\',\''.$sciudad.'\',\''.$sfecha.'\','.$r->id.')">';
 
	 
	 echo '<tr>';
	 $ciudad = trim($r->ciudad);
	 echo '<td class="columna" style="border-bottom:1px solid #ccc" >'.$link_reserva.preg_replace("/(".strtoupper (trim($_REQUEST['ciudad'])).")/",'<span style="color:#f00" >\1</span>',strtoupper ($ciudad)).'</a>'; 
	 echo '</a></td>';
 
	 echo '<td  class="columna" style="color:#00f;background:#ff8;font-weight:bold">'.$link_reserva.$r->id_event.'</a></td>';   
	 //echo '<td style="border-bottom:1px solid #ccc" >'.preg_replace("/(".strtoupper (convert_caracters_hex(trim($_REQUEST['nombreb']))).")/",'<span style="color:#f00" >\1</span>',strtoupper (trim($r->pilot)));
	 
	 if ($nombre!='')
		$str = preg_replace("/(".strtoupper (convert_caracters_hex($nombre)).")/",'<span style="color:#f00" >\1</span>',strtoupper (trim($r->pilot)));
	 else 
		$str = trim($r->pilot);

	 if ($apellido1!='')
		$str2 = preg_replace("/(".strtoupper (convert_caracters_hex($apellido1)).")/",'<span style="color:#f00" >\1</span>',strtoupper (trim($r->apellidos_piloto)));
		
	 if ($apellido2!='')
		$str3 = preg_replace("/(".strtoupper (convert_caracters_hex($apellido2)).")/",'<span style="color:#f00" >\1</span>',strtoupper (trim($r->apellidos_piloto)));

		
	 if ($apellido1=='' and $apellido2 =='') $str2 = trim($r->apellidos_piloto);
		
		
/*	
	//echo($nombre);
	//echo('<br>'.$r->pilot);
	 if ($nombre!='')    
		$str = preg_replace("/(".strtoupper ($nombre).")/",'<span style="color:#f00" >\1</span>',strtoupper (trim($r->pilot)));    
	 if ($apellido1!='')   
		$str2 = preg_replace("/(".strtoupper ($apellido1).")/",'<span style="color:#f00" >\1</span>',strtoupper (trim($r->apellidos_piloto)));   
	 if ($apellido2!='')   
		$str3 = preg_replace("/(".strtoupper ($apellido2).")/",'<span style="color:#f00" >\1</span>',strtoupper (trim($r->apellidos_piloto)));      

*/
	 echo '<td  class="columna" style="border-bottom:1px solid #ccc" >'.$link_reserva.$str.' '.$str2.' '.$str3.'</a>';
	 echo '</td>';
	
	 echo '<td  class="columna" style="border-bottom:1px solid #ccc" >'.$link_reserva.preg_replace("/(".strtoupper (trim($_REQUEST['emailb'])).")/",'<span style="color:#f00" >\1</span>',strtoupper (trim($r->email))).'</a>';
	 echo '</td>';
	 
	 echo '<td  class="columna" style="border-bottom:1px solid #ccc" >'.$link_reserva.preg_replace("/(".strtoupper (trim($telefono)).")/",'<span style="color:#f00" >\1</span>',strtoupper (trim($r->telefon))).'</a>';
	 echo '</td>';
	 
//	 echo '<td style="border-bottom:1px solid #ccc" >'.preg_replace("/(".strtoupper (convert_caracters_hex(trim($_REQUEST['nombreb']))).")/",'<span style="color:#f00" >\1</span>',strtoupper (trim($r->persona_regala)));
	 if ($nombre!='')
		$str = preg_replace("/(".strtoupper (convert_caracters_hex($nombre)).")/",'<span style="color:#f00" >\1</span>',strtoupper (trim($r->persona_regala)));
	 else
		$str = trim($r->persona_regala);

	 if ($apellido1!='')
		$str2 = preg_replace("/(".strtoupper (convert_caracters_hex($apellido1)).")/",'<span style="color:#f00" >\1</span>',strtoupper (trim($r->apellidos_persona_regala)));
	 if ($apellido2!='')
		$str3 = preg_replace("/(".strtoupper (convert_caracters_hex($apellido2)).")/",'<span style="color:#f00" >\1</span>',strtoupper (trim($r->apellidos_persona_regala)));

	 if ($apellido1=='' and $apellido2 =='')	 $str3 = trim($r->apellidos_persona_regala);
		
	 echo '<td  class="columna" style="border-bottom:1px solid #ccc" >'.$link_reserva.$str.' -'.$str2.'- '.$str3.'</a>';
	 echo '</td>';
	 
	 echo '<td  class="columna" style="border-bottom:1px solid #ccc" >'.$link_reserva.preg_replace("/(".strtoupper (trim($_REQUEST['emailb'])).")/",'<span style="color:#f00" >\1</span>',strtoupper (trim($r->email_persona_regala))).'</a>';
	 echo '</td>';
	 
	 echo '<td  class="columna" style="border-bottom:1px solid #ccc" >'.$link_reserva.preg_replace("/(".strtoupper (trim($telefono)).")/",'<span style="color:#f00" >\1</span>',strtoupper (trim($r->mobil_persona_regala))).'</a>';              
	 echo '</td>';

	 echo '<td  class="columna" style="border-bottom:1px solid #ccc;background:#8ff";>'.$link_reserva.preg_replace("/(".strtoupper (trim($_REQUEST['emailb'])).")/",'<span style="color:#f00" >\1</span>',strtoupper (trim($r->email_confirm))).'</a>';
	 echo '</td>';


	 
	 /** Columna códigos **/
	 $columna_codigo=''; 
	 //echo('lc: ');var_dump($lista_codigos);
	 foreach ($lista_codigos as $elem)
	 {
	 	$cod_loc_pattern=strtoupper(trim($elem));
	 	$cod_loc=strtoupper(trim($r->codi_localtzador));    
	 	$columna_codigo_loc = preg_replace('/('.$cod_loc_pattern.')/','<span style="color:#f00" >\1</span>',$cod_loc);                                                                                     
	 	if (strpos($columna_codigo_loc,'<span')!==false) break;
	 }
	 
	 $k=1;
	 echo '<td  class="columna" style="border-bottom:1px solid #ccc" >'.$link_reserva.$columna_codigo_loc.'</a>';
	 echo '</td>';

	 foreach ($lista_codigos as $elem)
	 {
	 	$cod_cons_pattern=strtoupper(trim($elem));
	 	$cod_cons=strtoupper(trim($r->codi_consum));    
	 	$columna_codigo_cons = preg_replace('/('.$cod_loc_pattern.')/','<span style="color:#f00" >\1</span>',$cod_cons);                                                                                     
	 	if (strpos($columna_codigo_cons,'<span')!==false) break;
	 } 
	  
	 echo '<td  class="columna" style="border-bottom:1px solid #ccc" >'.$link_reserva.$columna_codigo_cons.'</a>';
	 /** fin columna códigos **/
	 echo '<td  class="columna" style="color:#000;background:#8ff;font-weight:bold">'.$link_reserva.return_tipus_e(trim($r->tipus_event)).'</a></td>';
	 echo '<td  class="columna" style="width:150px;color:#000;background:#fff;font-weight:bold;border-bottom:1px solid #ccc;">'.$link_reserva.trim($r->Observaciones).'</a></td>';
	 echo '<td  class="columna" style="background-color:'.(($r->marcat==1)?'#0f0':'#f00').';color:#000;font-weight:bold">'.$link_reserva.'&nbsp;&nbsp;&nbsp;&nbsp;</a></td>';	                 
	 echo '<td  class="columna">'.$link_reubicados.'<input type="button" value="Ver" style="width:100%;"\></a></td>';	               
	 echo '</tr>';		
	 }

 echo '</table>';
  
  
  
  
 // header("Content-type: application/octet-stream");
 // header("Content-Disposition: attachment; filename=\"mails.rtf\"\n");
  
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
  
  
    function return_tipus($t)
  {
  	$tipos=array('_bferrari_','ferrari','_blamborghini_','lamborghini','_bporsche_','_porsche_','_bcorvette_','_corvette_');
  	$tipos_cmp=array('_bferrari_','ferrari','_blamborghini_','lamborghini','_bporsche_','porsche','_bcorvette_','corvette');
  	$stipo='ferrari';
  	$i=0;
  	foreach($tipos_cmp as $tipo)
  	{
  		if (strpos($t,$tipo)!==false)
  		{
  			$stipo=$tipos[$i];
  			break;
  		}
  		$i++;
  	}
  	
  	return $stipo;
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