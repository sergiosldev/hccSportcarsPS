<?php

	$pageNum = $_GET['p'];
	$nombreb = $_GET['nombreb'];
	$codigob = $_GET['codigob'];
	$ciudadb = $_GET['ciudadb'];
	$emailb = $_GET['emailb'];
	$telefonob = $_GET['telefonob'];
	$diab = $_GET['diab'];
	$tipob = $_GET['tipob'];
	 
	include_once('buscar_pilotos_2.php');
	include_once('../../../config/config.inc.php');
	
	$sql = consultar_pilotos_gen_consulta($nombreb,$codigob,$ciudadb,$emailb,$telefonob,$diab,$tipob,$lista_codigos);
	
	//Comen�ar paginaci�, canviar querys
	$query_num_services =  mysqli_query($link,$sql);
	$num_total_registros = mysqli_num_rows($query_num_services);
	//$num_total_registros = 10;
	
	//numero de registros por p�gina
    $rowsPerPage = 4;

    //por defecto mostramos la p�gina 1 si no hay una pagina
	if($pageNum==null){
		$pageNum = 1;
	}
	
    //contando el desplazamiento
    $offset = ($pageNum - 1) * $rowsPerPage;
    $total_paginas = ceil($num_total_registros / $rowsPerPage);

	$sql .= "LIMIT $offset, $rowsPerPage";		

	//Consulta realitzada.
	//$result=mysql_query($sql);
	
    $result=db::getinstance()->executes($sql);

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
	 <td class="capsalera" >Fecha Canjeado</td>
	 <td class="capsalera" >Val</td>
	 <td class="capsalera" >Reubicados</td>
	 
	 </tr>';	
	 

foreach($result as $r)
	 {		

	 $sfecha=substr($r['id_event'],0,10);
	 if (substr($r['ciudad'],0,5)=='Andal') $sciudad='andalucia';
	 else $sciudad=$r['ciudad'];
	 $link_reserva='<a href="javascript:ir_a_reserva(\''.return_tipus($r['tipus_event']).'\',\''.$sciudad.'\',\''.$sfecha.'\','.$r['id'].')">';
	 $link_reubicados='<a href="javascript:ir_a_reubicaciones(\''.return_tipus($r['tipus_event']).'\',\''.$sciudad.'\',\''.$sfecha.'\','.$r['id'].')">';
	 
	 $bbaja=($r['fecha_baja']!=null);
 	 if ($bbaja)
		echo '<tr class="baja">';
	 else 
		echo '<tr>';

	 $ciudad = trim($r['ciudad']);
	 if ($ciudad=='') $ciudad='Barcelona';
	 echo '<td class="columna tipocol1" style="border-bottom:1px solid #ccc" >'.$link_reserva.strtoupper ($ciudad).'</a>'; 
	 echo '</td>';
 
	 if ($bbaja)
		 echo '<td  class="columna tipocol1" style="font-weight:bold">'.$link_reserva.$r['id_event'].'</a></td>';   
	 else 
		 echo '<td  class="columna" style="color:#00f;background:#ff8;font-weight:bold">'.$link_reserva.$r['id_event'].'</a></td>';   
	 //echo '<td style="border-bottom:1px solid #ccc" >'.preg_replace("/(".strtoupper (convert_caracters_hex(trim($_REQUEST['nombreb']))).")/",'<span style="color:#f00" >\1</span>',strtoupper (trim($r->pilot)));
	 
	 if ($nombre!='')
		$str = preg_replace("/(".strtoupper (convert_caracters_hex($nombre)).")/",'<span style="color:#f00" >\1</span>',strtoupper (trim($r['pilot'])));
	 else 
		$str = trim($r['pilot']);

	 if ($apellido1!='')
		$str2 = preg_replace("/(".strtoupper (convert_caracters_hex($apellido1)).")/",'<span style="color:#f00" >\1</span>',strtoupper (trim($r['apellidos_piloto'])));
		
	 if ($apellido2!='')
		$str3 = preg_replace("/(".strtoupper (convert_caracters_hex($apellido2)).")/",'<span style="color:#f00" >\1</span>',strtoupper (trim($r['apellidos_piloto'])));

		
	 if ($apellido1=='' and $apellido2 =='') $str2 = trim($r['apellidos_piloto']);
			
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
	 if ($bbaja)
		echo '<td  class="columna tipocol1" style="border-bottom:1px solid #ccc" >'.$link_reserva.$str.' '.$str2.' '.$str3.'</a>';
	 else 
		echo '<td  class="columna" style="border-bottom:1px solid #ccc" >'.$link_reserva.$str.' '.$str2.' '.$str3.'</a>';	 echo '</td>';
	
 	 if ($bbaja)
		 echo '<td  class="columna tipocol1" style="border-bottom:1px solid #ccc" >'.$link_reserva.strtoupper (trim($r['email'])).'</a>';
	 else 
		 echo '<td  class="columna" style="border-bottom:1px solid #ccc" >'.$link_reserva.preg_replace("/(".strtoupper (trim($emailb)).")/",'<span style="color:#f00" >\1</span>',strtoupper (trim($r['email']))).'</a>';
	 echo '</td>';
	 
	 if ($bbaja)
		 echo '<td  class="columna tipocol1" style="border-bottom:1px solid #ccc" >'.$link_reserva.strtoupper (trim($r['telefon'])).'</a>';
	 else 
		 echo '<td  class="columna" style="border-bottom:1px solid #ccc" >'.$link_reserva.preg_replace("/(".strtoupper (trim($_REQUEST['telefonob'])).")/",'<span style="color:#f00" >\1</span>',strtoupper (trim($r['telefon']))).'</a>';
	 echo '</td>';
	 
//	 echo '<td style="border-bottom:1px solid #ccc" >'.preg_replace("/(".strtoupper (convert_caracters_hex(trim($_REQUEST['nombreb']))).")/",'<span style="color:#f00" >\1</span>',strtoupper (trim($r->persona_regala)));
	 if ($nombre!='' && !$bbaja)
		$str = preg_replace("/(".strtoupper (convert_caracters_hex($nombre)).")/",'<span style="color:#f00" >\1</span>',strtoupper (trim($r['persona_regala'])));
	 else
		$str = trim($r['persona_regala']);

	 if ($apellido1!='' && !$bbaja)
		$str2 = preg_replace("/(".strtoupper (convert_caracters_hex($apellido1)).")/",'<span style="color:#f00" >\1</span>',strtoupper (trim($r['apellidos_persona_regala'])));
	 else 
		$str2 = strtoupper (trim($r['apellidos_persona_regala']));
	
	 if ($apellido2!='' && !$bbaja)
		$str3 = preg_replace("/(".strtoupper (convert_caracters_hex($apellido2)).")/",'<span style="color:#f00" >\1</span>',strtoupper (trim($r['apellidos_persona_regala'])));
	 else 
		$str3 = strtoupper (trim($r['apellidos_persona_regala']));

	 if ($apellido1=='' and $apellido2 =='')	 $str3 = trim($r['apellidos_persona_regala']);
		
	 if ($bbaja)
		echo '<td  class="columna tipocol1" style="border-bottom:1px solid #ccc" >'.$link_reserva.$str.' -'.$str2.'- '.$str3.'</a>';
	 else 
		echo '<td  class="columna" style="border-bottom:1px solid #ccc" >'.$link_reserva.$str.' -'.$str2.'- '.$str3.'</a>';
	 echo '</td>';
	 
	 if ($bbaja)
		echo '<td  class="columna tipocol1" style="border-bottom:1px solid #ccc" >'.$link_reserva.strtoupper (trim($r['email_persona_regala'])).'</a>';
	 else 
		echo '<td  class="columna" style="border-bottom:1px solid #ccc" >'.$link_reserva.preg_replace("/(".strtoupper (trim($emailb)).")/",'<span style="color:#f00" >\1</span>',strtoupper (trim($r['email_persona_regala']))).'</a>';
	 echo '</td>';
	 
	 if($bbaja)
		echo '<td  class="columna tipocol1" style="border-bottom:1px solid #ccc" >'.$link_reserva.strtoupper (trim($r['mobil_persona_regala'])).'</a>';              
	 else 
		echo '<td  class="columna" style="border-bottom:1px solid #ccc" >'.$link_reserva.preg_replace("/(".strtoupper (trim($telefonob)).")/",'<span style="color:#f00" >\1</span>',strtoupper (trim($r['mobil_persona_regala']))).'</a>';              

	 echo '</td>';

	 if($bbaja)
		echo '<td  class="columna tipocol1" style="border-bottom:1px solid #ccc;";>'.$link_reserva.strtoupper (trim($r['email_confirm'])).'</a>';
	 else 
		echo '<td  class="columna" style="border-bottom:1px solid #ccc;background:#8ff";>'.$link_reserva.preg_replace("/(".strtoupper (trim($emailb)).")/",'<span style="color:#f00" >\1</span>',strtoupper (trim($r['email_confirm']))).'</a>';
	 echo '</td>';
	 
	 
	
	 
	 /** Columna c�digos **/
	 $columna_codigo=''; 
	 foreach ($lista_codigos as $elem)
	 {
	 	$cod_loc_pattern=strtoupper(trim($elem));
	 	$cod_loc=strtoupper(trim($r['codi_localtzador']));    
	 	$columna_codigo_loc = preg_replace('/('.$cod_loc_pattern.')/','<span style="color:#f00" >\1</span>',$cod_loc);                                                                                     
	 	if (strpos($columna_codigo_loc,'<span')!==false) break;
	 }
	 
	 $k=1;
	 echo '<td  class="columna tipocol1" style="border-bottom:1px solid #ccc" >'.$link_reserva.$columna_codigo_loc.'</a>';
	 echo '</td>';

	 foreach ($lista_codigos as $elem)
	 {
	 	$cod_cons_pattern=strtoupper(trim($elem));
	 	$cod_cons=strtoupper(trim($r['codi_consum']));    
	 	$columna_codigo_cons = preg_replace('/('.$cod_loc_pattern.')/','<span style="color:#f00" >\1</span>',$cod_cons);                                                                                     
	 	if (strpos($columna_codigo_cons,'<span')!==false) break;
	 } 
	  
	 echo '<td  class="columna tipocol1" style="border-bottom:1px solid #ccc" >'.$link_reserva.$columna_codigo_cons.'</a>';
	 /** fin columna c�digos **/
	 if ($bbaja)
		echo '<td  class="columna tipocol1" style="font-weight:bold">'.$link_reserva.return_tipus_e(trim($r['tipus_event'])).'</a></td>';
     else 	
	    echo '<td  class="columna" style="color:#000;background:#8ff;font-weight:bold">'.$link_reserva.return_tipus_e(trim($r['tipus_event'])).'</a></td>';
	 
	 if ($bbaja)
		echo '<td  class="columna tipocol1" style="width:150px;font-weight:bold;border-bottom:1px solid #ccc;">'.$link_reserva.trim($r['Observaciones']).'</a></td>';
	 else 
		echo '<td  class="columna" style="width:150px;color:#000;background:#fff;font-weight:bold;border-bottom:1px solid #ccc;">'.$link_reserva.trim($r['Observaciones']).'</a></td>';
	 
	 if ($bbaja)
		echo '<td  class="columna tipocol1" style="width:150px;font-weight:bold;border-bottom:1px solid #ccc;">'.$r['fecha_canjeado'].'</a></td>';
	 else 
		echo '<td  class="columna" style="width:150px;color:#000;background:#fff;font-weight:bold;border-bottom:1px solid #ccc;">'.$r['fecha_canjeado'].'</a></td>';
	 
	 if ($bbaja)
		echo '<td  class="columna tipocol1" style="background-color:'.(($r['marca_especial']!=1)?(($r['marcat']==1)?'#0f0':'#f00'):'#B244FD' ).';color:#000;font-weight:bold">'.$link_reserva.'&nbsp;&nbsp;&nbsp;&nbsp;</a></td>';	                 
	 else 
		echo '<td  class="columna" style="background-color:'.(($r['marca_especial']!=1)?(($r['marcat']==1)?'#0f0':'#f00'):'#B244FD' ).';color:#000;font-weight:bold">'.$link_reserva.'&nbsp;&nbsp;&nbsp;&nbsp;</a></td>';	                 
	 
	 echo '<td  class="columna">'.$link_reubicados.'<input type="button" value="Ver" style="width:100%;"\></a></td>';	 
	 echo '</tr>';	
	var_dump($r['marca_especial']);
	 
	 }
	 
	 echo '</table>';
	//Paginaci� Generada segons el resultat de la consulta, els numeros han de dur a js per canviar el contingut per ajax/DOM.

	if ($total_paginas > 1) {
		echo '<div class="pagination">';
		echo '<ul>';
			if ($pageNum != 1)
					echo '<li><a onclick="canviar_pag('.($pageNum-1).')" class="paginate" data="'.($pageNum-1).'">Anterior</a></li>';
				for ($i=1;$i<=$total_paginas;$i++) {
					if ($pageNum == $i)
							//si muestro el �ndice de la p�gina actual, no coloco enlace
							echo '<li> <a onclick="canviar_pag(' . $i . ')" class="active">'.$i.'</a></li>';
					else
							//si el �ndice no corresponde con la p�gina mostrada actualmente,
							//coloco el enlace para ir a esa p�gina
							echo '<li><a onclick="canviar_pag(' . $i . ')" class="paginate" data="'.$i.'">'.$i.'</a></li>';
			}
			if ($pageNum != $total_paginas)
					echo '<li><a onclick="canviar_pag('.($pageNum+1).') " class="paginate" data="'.($pageNum+1).'">Siguiente</a></li>';
	   echo '</ul>';
	   echo '</div>';
	}

?>