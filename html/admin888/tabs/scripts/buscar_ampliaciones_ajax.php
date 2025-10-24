<?php

	$pageNum = $_GET['p'];
	$localizador = $_GET['f'];
	include_once('../../../config/config.inc.php');
	
	if($localizador==null){
		$localizador="''";
	}
	//Generem Query
	if($localizador=="''"){
		$sql = 'Select a.id_plataforma,p.nombre,a.localizador,a.consumo,a.fecha from ampliaciones a, plataformas p where a.id_plataforma = p.id_plataforma';
	}
	else{
		$sql = 'Select a.id_plataforma,p.nombre,a.localizador,a.consumo,a.fecha from ampliaciones a, plataformas p where a.id_plataforma = p.id_plataforma AND a.localizador like "%'.$localizador.'%" ';
	}
	
	//Començar paginació, canviar querys
	$query_num_services =  mysql_query($sql);
	$num_total_registros = mysql_num_rows($query_num_services);
	//$num_total_registros = 10;
	
	//numero de registros por página
    $rowsPerPage = 20;

    //por defecto mostramos la página 1 si no hay una pagina
	if($pageNum==null){
		$pageNum = 1;
	}
	
    //contando el desplazamiento
    $offset = ($pageNum - 1) * $rowsPerPage;
    $total_paginas = ceil($num_total_registros / $rowsPerPage);

	$sql .= " LIMIT $offset, $rowsPerPage";		

	//Consulta realitzada.
	//$result=mysql_query($sql);
    $result=db::getinstance()->executes($sql);

	//Mostrar taula resultats.	
 echo '<table width="100%">';
  echo '<tr>
		 <td class="capsalera" >Plataforma</td>
		 <td class="capsalera" >Codi Localizador</td>
		 <td class="capsalera" >Codi Consumo</td>
		 <td class="capsalera" >Dia/hora</td>
		 <td class="capsalera" >Esborrar</td>
		</tr>';	

foreach($result as $r)
	 {		
		
		 echo '<tr>';
		 echo '<td  class="columna" style="width:150px;color:#000;background:#fff;font-weight:bold;border-left:1px solid #ccc;border-bottom:1px solid #ccc;" >';
		 echo $r['nombre'].'</td>';
		 echo '<td  class="columna" style="width:150px;color:#000;background:#fff;font-weight:bold;border-bottom:1px solid #ccc;border-left:1px solid #ccc;">';
		 echo $r["localizador"].'</td>';
		 echo '<td  class="columna" style="width:150px;color:#000;background:#fff;font-weight:bold;border-bottom:1px solid #ccc;border-left:1px solid #ccc;">';
		 echo $r["consumo"].'</td>';
		 echo '<td  class="columna" style="width:150px;color:#000;background:#fff;font-weight:bold;border-left:1px solid #ccc;border-bottom:1px solid #ccc;">';
		 echo $r["fecha"].'</td>';	                 
		echo '<td  class="columna" style="width:150px;color:#000;background:#fff;font-weight:bold;border-left:1px solid #ccc;border-bottom:1px solid #ccc;" >';
		 echo '<a style="cursor:pointer;" onclick="javascript:eliminar(\''.$r["id_plataforma"].'\',\''.$r["fecha"].'\',\''.$r["localizador"].'\');">Eliminar </a></td>';
		 echo '</tr>';		
	 }
	 
	 echo '</table>';
	
	//Paginació Generada segons el resultat de la consulta, els numeros han de dur a js per canviar el contingut per ajax/DOM.
	if ($total_paginas > 1) {
		echo '<div class="pagination">';
		echo '<ul>';
		//Primera Pàgina
		echo '<li><a onclick="canviar_pag(1,'.$localizador.')" class="paginate" data="1">Primera Pàgina</a></li>';
			if ($pageNum != 1){
				echo '<li><a onclick="canviar_pag('.($pageNum-1).','.$localizador.')" class="paginate" data="'.($pageNum-1).'">Anterior</a></li>';
			}	
			
			if($pageNum>1){
				echo '<li><a onclick="canviar_pag(' . ($pageNum-1) . ','.$localizador.')" class="paginate" data="'.($pageNum-1).'">'.($pageNum-1).'</a></li>';	
			}
			
			echo '<li><a onclick="canviar_pag(' . $pageNum . ','.$localizador.')" class="active" data="'.$pageNum.'">'.$pageNum.'</a></li>';	
			
			if($pageNum<$total_paginas){
				echo '<li><a onclick="canviar_pag(' . ($pageNum+1) . ','.$localizador.')" class="paginate" data="'.($pageNum+1).'">'.($pageNum+1).'</a></li>';	
			}
			
			if ($pageNum != $total_paginas){
					echo '<li><a onclick="canviar_pag('.($pageNum+1).','.$localizador.') " class="paginate" data="'.($pageNum+1).'">Siguiente</a></li>';
			}	
		//Ultima Pàgina
		echo '<li><a onclick="canviar_pag('.($total_paginas).','.$localizador.')" class="paginate" data="'.($total_paginas).'">Ultima Pàgina</a></li>';
		echo '</ul>';
		echo '</div>';
	}
?>