<?php
	include('config_events_new.php');                  
	include_once(dirname(__FILE__).'/../../../config/config.inc.php'); 
	$plataforma=new Plataforma();
	$plataformas=$plataforma->getPlataformas();
	unset($plataforma);
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
}
.columna
{
	font-size:13px;
}
</style>	

<?php   
  
  $fecha_inicial='2015-09-01';		
  $nombre_apellidos = explode(' ',$_REQUEST['nombreb']);	
  $nombre_apellidos = array_map('trim',$nombre_apellidos);
  $nombre='';
  $apellido1 = '';
  $apellido2 = '';
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

  $condicion_origen =  ' (
						  origen like "%'.trim($_REQUEST['origen']).'%"  or 
						  origen not in (select valor from plataformas)
						 ) ';                                                                                                                                     

  
  
/*  $condicion_nombre.= 'OR
  persona_regala   like "%'.$nombre.'%")
  ';
*/
     	
//  $nombre = $_REQUEST['nombreb'];
//  $apellidos = $_REQUEST['nombreb'];
 
  $_REQUEST['ciudadb']='*';
  
  if($_REQUEST['ciudadb']!='*')  
  $sql='SELECT *,"'.strtoupper($_REQUEST['ciudadb']).'" ciudad    
  from events'.$_REQUEST['ciudadb'].
  ' where 
  (email_persona_regala like "%'.trim($_REQUEST['emailb']).'%" OR 
  email  like "%'.trim($_REQUEST['emailb']).'%" OR
  email_confirm   like "%'.trim($_REQUEST['emailb']).'%") 
  AND
  (telefon  like "%'.trim($_REQUEST['telefonob']).'%" OR
  mobil_persona_regala  like "%'.trim($_REQUEST['telefonob']).'%") 
  AND
  '.$condicion_nombre.'
  AND
  '.$condicion_codigos.'
  AND
  '.$condicion_origen.'
  AND  
  id_event  like "%'.trim($_REQUEST['diab']).'%"  
  AND
  tipus_event   like "%'.trim($_REQUEST['tipob']).'%" 
  AND
  date(substring(id_event,1,10))>date("'.$fecha_inicial.'")
  AND marcat!="1"
  AND (marca_especial=0
  OR marca_especial IS Null)
  
  ORDER BY id_event ';
  else 
  $sql='
  SELECT *,"Barcelona" ciudad    
  from events where           
  (email_persona_regala like "%'.trim($_REQUEST['emailb']).'%" OR 
  email  like "%'.trim($_REQUEST['emailb']).'%" OR
  email_confirm   like "%'.trim($_REQUEST['emailb']).'%")              
  AND
  (
  telefon  like "%'.trim($_REQUEST['telefonob']).'%" OR                   
  mobil_persona_regala  like "%'.trim($_REQUEST['telefonob']).'%")                         
  AND
  '.$condicion_nombre.'
  AND
  '.$condicion_codigos.'
  AND
  id_event  like "%'.trim($_REQUEST['diab']).'%"   
  AND
  '.$condicion_origen.'
  AND
  tipus_event   like "%'.trim($_REQUEST['tipob']).'%"  
  AND
  date(substring(id_event,1,10))>date("'.$fecha_inicial.'")
  AND marcat!="1" 
   AND (marca_especial=0
  OR marca_especial IS Null)  
  UNION ALL
  
  SELECT *,"Madrid" ciudad    from eventsmadrid where 
  (email_persona_regala like "%'.trim($_REQUEST['emailb']).'%" OR 
  email  like "%'.trim($_REQUEST['emailb']).'%" OR
  email_confirm   like "%'.trim($_REQUEST['emailb']).'%") 
  AND
  (telefon  like "%'.trim($_REQUEST['telefonob']).'%" OR
  mobil_persona_regala  like "%'.trim($_REQUEST['telefonob']).'%") 
  AND
  '.$condicion_nombre.'  
  AND
  '.$condicion_codigos.'          
  AND
  id_event  like "%'.trim($_REQUEST['diab']).'%"               
  AND
  '.$condicion_origen.'
  AND 
  tipus_event   like "%'.trim($_REQUEST['tipob']).'%"          
  AND
  date(substring(id_event,1,10))>date("'.$fecha_inicial.'")
  AND marcat!="1"
   AND (marca_especial=0
  OR marca_especial IS Null) 
  UNION ALL   
  SELECT *,"Valencia" ciudad    from eventsvalencia    
  where                                                                                                                                          
  (email_persona_regala like "%'.trim($_REQUEST['emailb']).'%" OR 
  email  like "%'.trim($_REQUEST['emailb']).'%" OR
  email_confirm   like "%'.trim($_REQUEST['emailb']).'%") 
  AND
  (telefon  like "%'.trim($_REQUEST['telefonob']).'%" OR
  mobil_persona_regala  like "%'.trim($_REQUEST['telefonob']).'%") 
  AND
  '.$condicion_nombre.'
  AND
  '.$condicion_codigos.'
  AND
  '.$condicion_origen.'
  AND
  id_event  like "%'.trim($_REQUEST['diab']).'%"   
  AND
  tipus_event   like "%'.trim($_REQUEST['tipob']).'%" 
  AND
  date(substring(id_event,1,10))>date("'.$fecha_inicial.'")
  AND marcat!="1"
   AND (marca_especial=0
  OR marca_especial IS Null)  
  UNION ALL
  SELECT *,"Andalucía" ciudad    from eventsandalucia where 
  (email_persona_regala like "%'.trim($_REQUEST['emailb']).'%" OR 
  email  like "%'.trim($_REQUEST['emailb']).'%" OR
  email_confirm   like "%'.trim($_REQUEST['emailb']).'%") 
  AND
  (telefon  like "%'.trim($_REQUEST['telefonob']).'%" OR
  mobil_persona_regala  like "%'.trim($_REQUEST['telefonob']).'%") 
  AND
  '.$condicion_nombre.'
  AND
  '.$condicion_codigos.'
  AND
  '.$condicion_origen.'
  AND
  id_event  like "%'.trim($_REQUEST['diab']).'%" 
  
  AND  
  tipus_event   like "%'.trim($_REQUEST['tipob']).'%" 
  
  AND
  date(substring(id_event,1,10))>date("'.$fecha_inicial.'")
  AND marcat!="1"
   AND (marca_especial=0
  OR marca_especial IS Null)  
   
  UNION ALL
   
  SELECT *,"Cantabria" ciudad  from eventscantabria where 
  (email_persona_regala like "%'.trim($_REQUEST['emailb']).'%" OR 
  email  like "%'.trim($_REQUEST['emailb']).'%" OR
  email_confirm   like "%'.trim($_REQUEST['emailb']).'%") 
  AND
  (telefon  like "%'.trim($_REQUEST['telefonob']).'%" OR
  mobil_persona_regala  like "%'.trim($_REQUEST['telefonob']).'%") 
  AND
  '.$condicion_nombre.'
  AND
  '.$condicion_codigos.'
  AND
  '.$condicion_origen.'
  AND
  id_event  like "%'.trim($_REQUEST['diab']).'%"   
  AND
  tipus_event   like "%'.trim($_REQUEST['tipob']).'%"   
  AND
  date(substring(id_event,1,10))>date("'.$fecha_inicial.'")
  AND marcat!="1"
   AND (marca_especial=0
  OR marca_especial IS Null)  

  
  UNION ALL
   
  SELECT *,"rutas_turisticas" ciudad  from eventsrutas_turisticas where 
  (email_persona_regala like "%'.trim($_REQUEST['emailb']).'%" OR 
  email  like "%'.trim($_REQUEST['emailb']).'%" OR
  email_confirm   like "%'.trim($_REQUEST['emailb']).'%") 
  AND
  (telefon  like "%'.trim($_REQUEST['telefonob']).'%" OR
  mobil_persona_regala  like "%'.trim($_REQUEST['telefonob']).'%") 
  AND
  '.$condicion_nombre.'
  AND
  '.$condicion_codigos.'
  AND              
  '.$condicion_origen.'
  AND  
  id_event  like "%'.trim($_REQUEST['diab']).'%"    
  
  AND
  tipus_event   like "%'.trim($_REQUEST['tipob']).'%"                                                                                     
  AND                    
  date(substring(id_event,1,10))>date("'.$fecha_inicial.'")                                 
  AND marcat!="1" 
   AND (marca_especial=0
  OR marca_especial IS Null)

  ORDER BY id_event 
  ';

  $division_origen=explode(' ',str_replace('_',' ',trim($_REQUEST['origen'])));
  //El orden de las reserva será el siguiente:
  //1: reservas con el origen seleccionado en el buscador (existirá por tanto en la tabla plataformas).
  //2: reservas que sin estar en la tabla plataformas, sí tienen un origen parecido al seleccionado en el buscador.
  //3: reservas que sin cumplir ninguno de los criterios anteriores, sí tiene la primera palabra en el orig. seleccionado en el buscador.
  //4: reservas que no cumplen ninguno de los criterios anteriores.
  $sql = ' select a.*,
				  ifnull(em.marcado,a.marcat) marcado_def,
				  ifnull(env.id,"SI") visible,
				  ifnull(pl.nombre,a.origen) nombre_origen,
				  
				  case ifnull(pl.valor,"nulo") 
					when "nulo" then 
							case a.origen like "%'.str_replace('_',' ',trim($_REQUEST['origen'])).'%"    
							when true then 2
							else 
								case a.origen like "%'.$division_origen[0].'%"                   
								when true then 3
								else 
									case a.origen like "%'.substr($division_origen[0],0,4).'%" when true then 3       
									else 4   
									end
								end
							end
					else 1 
					end 
				  orden_origen    
  from ('.$sql.') a left join plataformas pl on a.origen = pl.valor                                      
					left join eventos_marcados em on a.id=em.id and a.ciudad = em.ciudad                   
					left join eventos_marcado_no_visible env on a.id=env.id and a.ciudad=env.ciudad
  where trim(a.pilot) != "no disponible" 
  order by orden_origen asc,nombre_origen asc,date(substr(a.id_event,1,10)) asc  ';                                                       
  
  //die($sql);
  
  //echo $sql; 
  
  if($_REQUEST['ciudadb']=='*')echo 'CIUDAD TODAS<br><br>';        
  else if($_REQUEST['ciudadb']=='')echo 'CIUDAD BARCELONA<br><br>';
  else echo 'CIUDAD '.strtoupper($_REQUEST['ciudadb']).'<br><br>';
  
  //echo($sql);
  $result=mysqli_query($link,$sql);                                                                   
  
//  die($sql);
  echo('<div style="width:50%;margin:0 auto;margin-bottom:60px;">
	   <label style="margin-top:10px;margin-right: 12px">Plataformas:</label>');
	$listbox='		
	<select name="origen" id="origen" onchange="canvia_origen_canjear2()" style="float:left;width:200px;">
		<option value="">--Elija opcion--</option>';           

  foreach($plataformas as $pl)
  {
	 $listbox.='<option value="'.$pl['valor'].'">'.$pl['nombre'].'</option>';    
  }

  $listbox.='
  <option value="OTROS">OTROS</option>                                                
		</select>
';
 echo($listbox);
 echo('<input type="button" value="Canjear" onclick="canjear();" style="float:left;margin-left:10px;margin-top:10px;"/>');	
 //echo('<input type="button" value="Marcar reserva especial" onclick="marcar_reservas_especiales();" style="float:left;margin-left:10px;margin-top:10px;"/>');	
 echo('</div>');
 echo '<table width="100%">';
 
  echo '<tr>
	 <td class="capsalera" ></td>         
	 <td class="capsalera" >Ciudad</td>         
	 <td class="capsalera" >Marcado especial</td>         
	 <td class="capsalera" >Dia/hora</td>           
	 <td class="capsalera" >Origen</td>                                                                                  
	 <td class="capsalera" >Piloto</td>          
	 <td class="capsalera" >Persona que regala</td>          
	 <td class="capsalera"  width="50px" >Email. Confirm</td>         
	 <td class="capsalera" >Cod. Localizador</td>         
	 <td class="capsalera" >Cod. Consumo</td>         
	 <td class="capsalera" >Event</td>        
	 <td class="capsalera" style="width:150px;">Observacions<span style="color:#fff;">_________</span></td>                                    
	 <td class="capsalera" >Val</td>         
	 </tr>';	
 
/* 
  echo '<tr>
	 <td class="capsalera" >Ciudad</td>
	 <td class="capsalera" >Dia/hora</td>
	 <td class="capsalera" >Origen</td>                                                                                  
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
	 
	 </tr>';	
	 
	 */
$k=0;
 while($r=mysqli_fetch_object($result))
	 {		
	 //los registros marcados como no visibles no se mostrarán como resultado de la búsqueda.
	 if ($r->visible!='SI') continue;
	 $sfecha=substr($r->id_event,0,10);
	 if (substr($r->ciudad,0,5)=='Andal') $sciudad='andalucia';
	 else $sciudad=strtolower($r->ciudad);
	 $link_canjear='<a href="javascript:marcar_canjeado(\''.$r->nombre_origen.'\',\''.$sciudad.'\',parseInt($(\'#marcado'.$r->id.'\').val()),'.$r->id.')" style="color:inherit;">';              
	 $link_marcar_especial='<a href="javascript:marcar_especial('.$r->id.',\''.$r->tipus_event.'\',parseInt($(\'#marcado_especial'.$r->id.'\').val()),\''.$sciudad.'\',0)" style="background-color:#b244fd;color:#ffffff;">';                            	 
	 $link_editar='<a href="javascript:edita_busqueda(\''.((strtoupper($sciudad)=='BARCELONA')?'':$sciudad).'\',\''.$r->tipus_event.'\','.$r->id.')">';                                                                                                             
	  
	 $smarcat=$r->marcado_def;  
	 $svisible=$r->visible;
	 $smarcado_especial	=$r->marca_especial;
	
	if ($svisible!='SI')
	 {
		$svisible='0';
		$color='#FFF466';          
	 }
	 else
	 {
		 $svisible='1';
		 if($smarcat=='1')
		 {
			$color='#80F466';   
		 }
		 else
		 {
			$color='#fffffff';
		 }
	 }
	 
	 if ($marcado_especial=='1')
	 {
		$color_especial='#b244fd';
	 }
	 else
	 {
		$color_especial='#FFFFFF';
	 }
	 
	 //$link_marcar_no_visible='<a href="javascript:marcar_no_visible(\''.$r->nombre_origen.'\',\''.$sciudad.'\',$(\'#visible'.$r->id.'\').val(),'.$r->id.')">';                                       
	 $link_marcar_no_visible='<input id="boton'.$r->id.'" type="button" value="'.((intval($svisible)==1)?'ocultar':'mostrar').'" style="width:100%;" onclick="marcar_no_visible(\''.$r->nombre_origen.'\',\''.$sciudad.'\',$(\'#visible'.$r->id.'\').val(),'.$r->id.')">';                                       
	 
	 echo '<tr id="fila'.$r->id.'" style="background:'.$color.';">';
	 $ciudad = trim($r->ciudad);   
	 echo '<td style="display:none;"><input type="hidden" id="indice'.$k.'" value="'.intval($r->id).'"></td>';    
	 $k++;
	 echo '<td style="display:none;"><input type="hidden" id="marcado'.$r->id.'" value="'.intval($smarcat).'"></td>';    
	 echo '<td style="display:none;"><input type="hidden" id="marcado_especial'.$r->id.'" value="'.intval($smarcado_especial).'"></td>';    
	 echo '<td style="display:none;">
			<input type="hidden" id="visible'.$r->id.'" value="'.intval($svisible).'">
			<input type="hidden" id="tipo'.$r->id.'" value="'.$r->tipus_event.'">			
		   </td>';      
	 echo '<td style="display:none;background-color:'.$color_especial.'"><input style="background-color:#b244fd;" type="hidden" id="ciudad'.$r->id.'" value="'.$sciudad.'"> '.$link_canjear.'</a></td>';    
	 echo '<td class="columna" style="border-bottom:1px solid #ccc" >'.$link_marcar_no_visible.'</td>';
	 echo '<td id="reserva_especial'.$r->id.'" class="columna" style="border-bottom:1px solid #ccc" >'.$link_canjear.$sciudad.'</a></td>';  
	 echo '<td class="columna" style="border-bottom:1px solid #ccc" >'.$link_marcar_especial.'&nbsp;&nbsp;&nbsp;E&nbsp;&nbsp;&nbsp;</a></td>';       
	 echo '</a></td>';
 
	 echo '<td  class="columna" style="color:#00f;background:#ff8;font-weight:bold;font-size:10px;">'.$link_canjear.$r->id_event.'</a></td>';   
	 //echo '<td style="border-bottom:1px solid #ccc" >'.preg_replace("/(".strtoupper (convert_caracters_hex(trim($_REQUEST['nombreb']))).")/",'<span style="color:#f00" >\1</span>',strtoupper (trim($r->pilot)));
	 echo '<td  class="columna" style="border-bottom:1px solid #ccc;">'.$link_canjear.$r->nombre_origen.'</a></td>';   
	 
	 /*
	 if ($nombre!='')
		$str = preg_replace("/(".strtoupper (convert_caracters_hex($nombre)).")/",'<span style="color:#f00" >\1</span>',strtoupper (trim($r->pilot)));
	 else 
		$str = trim($r->pilot);

	 if ($apellido1!='')
		$str2 = preg_replace("/(".strtoupper (convert_caracters_hex($apellido1)).")/",'<span style="color:#f00" >\1</span>',strtoupper (trim($r->apellidos_piloto)));
		
	 if ($apellido2!='')
		$str3 = preg_replace("/(".strtoupper (convert_caracters_hex($apellido2)).")/",'<span style="color:#f00" >\1</span>',strtoupper (trim($r->apellidos_piloto)));

		
	 if ($apellido1=='' and $apellido2 =='') $str2 = trim($r->apellidos_piloto);
	*/

	$str=trim($r->pilot);
	$str2=$r->apellidos_piloto;
	$str3='';
		
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
	 echo '<td  class="columna" style="border-bottom:1px solid #ccc" >'.$link_canjear.$str.' '.$str2.' '.$str3.'</a>';
	 echo '</td>';
	
	 /*echo '<td  class="columna" style="border-bottom:1px solid #ccc" >'.$link_canjear.preg_replace("/(".strtoupper (trim($_REQUEST['emailb'])).")/",'<span style="color:#f00" >\1</span>',strtoupper (trim($r->email))).'</a>';
	 echo '</td>';*/
	 
	 /*echo '<td  class="columna" style="border-bottom:1px solid #ccc" >'.$link_canjear.preg_replace("/(".strtoupper (trim($_REQUEST['telefonob'])).")/",'<span style="color:#f00" >\1</span>',strtoupper (trim($r->telefon))).'</a>';
	 echo '</td>';*/
	 
//	 echo '<td style="border-bottom:1px solid #ccc" >'.preg_replace("/(".strtoupper (convert_caracters_hex(trim($_REQUEST['nombreb']))).")/",'<span style="color:#f00" >\1</span>',strtoupper (trim($r->persona_regala)));
	 
	 /*if ($nombre!='')
		$str = preg_replace("/(".strtoupper (convert_caracters_hex($nombre)).")/",'<span style="color:#f00" >\1</span>',strtoupper (trim($r->persona_regala)));
	 else
		$str = trim($r->persona_regala);

	 if ($apellido1!='')
		$str2 = preg_replace("/(".strtoupper (convert_caracters_hex($apellido1)).")/",'<span style="color:#f00" >\1</span>',strtoupper (trim($r->apellidos_persona_regala)));
	 if ($apellido2!='')
		$str3 = preg_replace("/(".strtoupper (convert_caracters_hex($apellido2)).")/",'<span style="color:#f00" >\1</span>',strtoupper (trim($r->apellidos_persona_regala)));

	 if ($apellido1=='' and $apellido2 =='')	 $str3 = trim($r->apellidos_persona_regala);
	 */
	 $str=trim($r->persona_regala);
	 $str2=trim($r->apellidos_persona_regala);
	 $str3='';
		
	 echo '<td  class="columna" style="border-bottom:1px solid #ccc" >'.$link_canjear.$str.' '.$str2.' '.$str3.'</a>';
	 echo '</td>';
	 
	 /*echo '<td  class="columna" style="border-bottom:1px solid #ccc" >'.$link_canjear.preg_replace("/(".strtoupper (trim($_REQUEST['emailb'])).")/",'<span style="color:#f00" >\1</span>',strtoupper (trim($r->email_persona_regala))).'</a>';
	 echo '</td>';
	 
	 echo '<td  class="columna" style="border-bottom:1px solid #ccc" >'.$link_canjear.preg_replace("/(".strtoupper (trim($_REQUEST['telefonob'])).")/",'<span style="color:#f00" >\1</span>',strtoupper (trim($r->mobil_persona_regala))).'</a>';              
	 echo '</td>';
	 

	 echo '<td  class="columna" style="border-bottom:1px solid #ccc;background:#8ff";>'.$link_canjear.preg_replace("/(".strtoupper (trim($_REQUEST['emailb'])).")/",'<span style="color:#f00" >\1</span>',strtoupper (trim($r->email_confirm))).'</a>';
	 echo '</td>';
	 mts***
	*/

	 echo '<td  width="50px" class="columna" style="font-size:9px;border-bottom:1px solid #ccc;background:#8ff";>'.$link_canjear.preg_replace("/(".strtoupper (trim($_REQUEST['emailb'])).")/",'<span style="color:#f00" >\1</span>',strtoupper (trim($r->email_confirm))).'</a>';           
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
	 echo '<td  class="columna" style="border-bottom:1px solid #ccc" >'.$link_canjear.$columna_codigo_loc.'</a>';
	 echo '</td>';

	 foreach ($lista_codigos as $elem)
	 {
	 	$cod_cons_pattern=strtoupper(trim($elem));
	 	$cod_cons=strtoupper(trim($r->codi_consum));    
	 	$columna_codigo_cons = preg_replace('/('.$cod_loc_pattern.')/','<span style="color:#f00" >\1</span>',$cod_cons);                                                                                     
	 	if (strpos($columna_codigo_cons,'<span')!==false) break;
	 } 
	  
	 echo '<td  class="columna" style="border-bottom:1px solid #ccc" >'.$link_canjear.$columna_codigo_cons.'</a>';
	 /** fin columna códigos **/
	 echo '<td  class="columna" style="color:#000;background:#8ff;font-weight:bold">'.$link_canjear.return_tipus_e(trim($r->tipus_event)).'</a></td>';
	 echo '<td  class="columna" style="width:150px;color:#000;background:#fff;font-weight:bold;border-bottom:1px solid #ccc;">'.$link_editar.trim($r->Observaciones).'</a></td>';  
	 echo '<td  class="columna" style="background-color:'.(($r->marcat==1)?'#0f0':'#f00').';color:#000;font-weight:bold">'.$link_canjear.'&nbsp;&nbsp;&nbsp;&nbsp;</a></td>';	           
	 echo '</tr>';		
	 }

 echo '</table>';
  
 echo('<br><input type="button" value="Canjear" onclick="canjear();"/>');
 //echo('<input type="button" value="Marcar reserva especial" onclick="marcar_reservas_especiales();"/>');	
  
  
  
 // header("Content-type: application/octet-stream");
 // header("Content-Disposition: attachment; filename=\"mails.rtf\"\n");
  /*DUPLICATS */
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
  
   
   /*DUPLICAT*/
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