<?php

	include_once dirname(__FILE__).'/funciones_ofertas.php';     
	
	$opciones = GetOpcionesOferta($_POST['id_oferta']);
	//var_dump($opciones);
	$nopciones = count($opciones);
	$nombre_opcion = 'opcion'; 
	switch($_POST['operacion_opcion'])
	{
		case 1: //añadir opción 
			$nopciones++;
			$nueva_opcion=true;
			opciones($_POST['id_oferta'],$nombre_opcion,$_POST['tab'],$opciones,$nueva_opcion);

			//nueva_opcion($nopciones,$nombre_opcion,$_POST['tab'],$_POST['id_oferta'],$opciones);
		break;
		case 2: //eliminar opción
			if ($_POST['id_opcion'])
				DeleteOpcionOferta($_POST['id_opcion']);
		break;
		default:	
		 	//mostrar lista completa de opciones.
			$nueva_opcion=false;
			opciones($_POST['id_oferta'],$nombre_opcion,$_POST['tab'],$opciones,$nueva_opcion);
		break;	
	}
	
	//if ($_POST['tab']!=1) echo('##'.($nopciones+1));
	echo('<input type="hidden" id="nopciones" value="'.($nopciones+1).'">');
	
	



	
	 function opciones($id_oferta,$nombre_opcion,$tab,$opciones,$nueva_opcion)
	 {
		//mostramos las pestañas
		$nopciones = count($opciones)+1;
		if ($nueva_opcion) $nopciones++;
		
		
		?>
		<div class="tab-row" id="row">              
		<!-- Pestaña con los datos de la oferta -->
			<h4 class="tab sub selected"  style="border-bottom:none !important;" id='tabopcion1'><a class="cabecera" align="left" href="#" onclick="CambiarTab('opcion',1,<?php echo($nopciones);?>);return(false);">
			<?php 
			if ($nopciones<=1) echo('Datos de la oferta<br>Opci&oacute;n 1'); 
			else echo('La oferta'); 
			?>
			</a> </h4>
			<?php

			//Pestañas de las opciones de la oferta
			$nopcion=2; 
			if ($nopciones>1) $nopcion_pestana = $nopcion-1;
			else $nopcion_pestana = $nopcion;

			foreach ($opciones  as $opcion)
			{

			?>
			<h4 class="tab sub" style="border-bottom:none !important;" id='tab<?php echo($nombre_opcion.$nopcion);?>'><a class="cabecera" href="#" onclick="CambiarTab('<?php echo($nombre_opcion);?>',<?php echo($nopcion);?>,<?php echo($nopciones);?>);return(false);">Opci&oacute;n <?php echo($nopcion_pestana);?></a> </h4>                
		<?php 
				$nopcion++;
				if ($nopciones>1) $nopcion_pestana = $nopcion-1;
				else $nopcion_pestana = $nopcion;
				
			}
			
			//Si hemos añadido una nueva opción esta será su pestaña.
			if ($nueva_opcion)
			{
			?>
			<h4 class="tab sub" style="border-bottom:none !important;" id='tab<?php echo($nombre_opcion.($nopcion));?>'><a class="cabecera" href="#" onclick="CambiarTab('<?php echo($nombre_opcion);?>',<?php echo($nopcion);?>,<?php echo($nopciones);?>);return(false);">Opci&oacute;n <?php echo($nopcion_pestana);?></a> </h4>
			<?php
			}
			?>
		</div>
		<?php 
		//mostramos el contenido de las pestañas.
		  
		?>
			<input type="button" id="opcion_nueva" name="opcion_nueva" value="+" style="float:left;margin-left: 4px;width: 20px;height: 20px;" onclick="add_tab_opcion(this);">
		
		   <!-- Formulario con los datos de la oferta -->
			<div id="stepopcion1" class="tab-page sub selected" style="display: block;background-color:#FFFFFF;">
			<?php include "tabla_oferta.php";	
			?>
			
			</div>
		<?php			
		   
		  //Formularios con los datos de las distintas opciones de la oferta 		   
		  $nopcion=2;
		  
		  foreach ($opciones as $opcion)
		  {
		  
			$id_opcion = $opcion->id;
			echo('<div id="step'.$nombre_opcion.$nopcion.'" class="tab-page sub selected" style="display: none;background-color:#FFFF7F;">');		
			echo('<a href="javascript:del_tab_opcion('.$id_opcion.',this);" id="opcion_menos" name="opcion_menos" value="" style="float:right;width: 100px;height: 22px;"><img src="tabs/img/esborra.gif" style="width:22px;"><span style="font-weight:bold;">Eliminar</span></a>');
			include "tabla_opcion.php";
			echo('</div>');
			$nopcion++;
		  }
		  
		//En el caso de que hayamos añadido una nueva oferta con el boton de añadir se creará un formulario vacío para la nueva opción.
		if ($nueva_opcion)
		{
			$id_opcion = '';
			echo('<div id="step'.$nombre_opcion.($nopcion).'" class="tab-page sub selected" style="display: none;background-color:#FFFF7F;">');
			echo('<a href="javascript:del_tab_opcion(id_(\'idopcion'.$nopcion.'\').value,this);" id="opcion_menos" name="opcion_menos" value="" style="float:right;width: 100px;height: 22px;"><img src="tabs/img/esborra.gif" style="width:22px;"><span style="font-weight:bold;">Eliminar</span></a>');
			
			include "tabla_opcion.php";
			echo('</div>');							  		
		}		
	
	 }
	 
	 
 
	
	?>
	
	<style>
		.tab {height:36px !important;}
	</style>
