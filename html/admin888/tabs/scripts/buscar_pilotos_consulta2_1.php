<?php 
  
 include_once(dirname(__FILE__).'/../../../config/defines.inc.php');

 function consultar_pilotos($sql)
  {
	//Començar paginació, canviar querys
	$query_num_services =  mysql_query($sql);
	$num_total_registros = mysql_num_rows($query_num_services);
	//$num_total_registros = 10;
	
	//numero de registros por página
    $rowsPerPage = 1;

    //por defecto mostramos la página 1
    $pageNum = 1;
		
	//Cridar Ajax	

	/*
    //contando el desplazamiento
    $offset = ($pageNum - 1) * $rowsPerPage;
    $total_paginas = ceil($num_total_registros / $rowsPerPage);
	
	
	$sql .= "LIMIT $offset, $rowsPerPage";	
	*/
	
	
	//Consulta realitzada.
	$result=mysql_query($sql);

	//  die($sql);
	
	echo '<div id="res_consulta">';
	//Mostrar taula resultats.	
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
	 
	 if ($r->fecha_baja!=null)
		echo '<tr class="baja">';
	 else 
		echo '<tr>';
	 $ciudad = trim($r->ciudad);
	 if ($ciudad=='') $ciudad='Barcelona';
	 
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
	 
	 echo '<td  class="columna" style="border-bottom:1px solid #ccc" >'.$link_reserva.preg_replace("/(".strtoupper (trim($_REQUEST['telefonob'])).")/",'<span style="color:#f00" >\1</span>',strtoupper (trim($r->telefon))).'</a>';
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
	 
	 echo '<td  class="columna" style="border-bottom:1px solid #ccc" >'.$link_reserva.preg_replace("/(".strtoupper (trim($_REQUEST['telefonob'])).")/",'<span style="color:#f00" >\1</span>',strtoupper (trim($r->mobil_persona_regala))).'</a>';              
	 echo '</td>';

	 echo '<td  class="columna" style="border-bottom:1px solid #ccc;background:#8ff";>'.$link_reserva.preg_replace("/(".strtoupper (trim($_REQUEST['emailb'])).")/",'<span style="color:#f00" >\1</span>',strtoupper (trim($r->email_confirm))).'</a>';
	 echo '</td>';
	 
	 /** Columna códigos **/
	 $columna_codigo=''; 
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
	
	
	//Paginació Generada segons el resultat de la consulta, els numeros han de dur a js per canviar el contingut per ajax/DOM.

	if ($total_paginas > 1) {
		echo '<div class="pagination">';
		echo '<ul>';
			if ($pageNum != 1)
					echo '<li><a onclick="canviar_pag('.($pageNum-1).')" class="paginate" data="'.($pageNum-1).'">Anterior</a></li>';
				for ($i=1;$i<=$total_paginas;$i++) {
					if ($pageNum == $i)
							//si muestro el índice de la página actual, no coloco enlace
							echo '<li> <a onclick="canviar_pag(' . $i . ')" class="active">'.$i.'</a></li>';
					else
							//si el índice no corresponde con la página mostrada actualmente,
							//coloco el enlace para ir a esa página
							echo '<li><a onclick="canviar_pag(' . $i . ')" class="paginate" data="'.$i.'">'.$i.'</a></li>';
			}
			if ($pageNum != $total_paginas)
					echo '<li><a onclick="canviar_pag('.($pageNum+1).') " class="paginate" data="'.($pageNum+1).'">Siguiente</a></li>';
	   echo '</ul>';
	   echo '</div>';
	}
	
	echo '</div>';
	
	$imprimir ="	
	  <script>
			function canviar_pag(page) {	 
			  
			  var xhttp = new XMLHttpRequest();
			  
			  xhttp.onreadystatechange = function() {
				if (xhttp.readyState == 4 && xhttp.status == 200) {
				  document.getElementById(\"res_consulta\").innerHTML = xhttp.responseText;
				}
			  };	  
			  xhttp.open('GET','"._BASE_URL_."/admin888/tabs/scripts/buscar_pilotos_ajax.php?p='+page, true);
			  xhttp.send();
			}
	  </script>
	";
	

	echo $imprimir;
  }
  /**
  * Funció per convertir els caracters especials a codi hexadecimal que podem mostrar.
  *@param $cad Cadena que conté la informació a transformar.
  *@return Retorna la cadena amb els caracters especials transformats.
  */
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
  
  
  /**
  * Funció per identificar el vehicle a partir d'una variable.
  *@param $t 
  *@return retorna el tipus de vehicle que conte la variable.
  */
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
  
  /**
  * Funció per identificar les experiencies a partir d'un vehicle d'una variable.
  *@param $t
  *@return El tipus d'experencia que conte la variable.
  */
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
  
   /**
   *
   *@param $cads Cadena ha normalitzar.
   *@return Torna la cadena amb els caracters convertits.
   */
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