<?php

/**
  * AmpliaCupo tab for admin panel, AdminAmpliaCupo.php
  * @category admin
  *
  * @author PrestaShop <support@prestashop.com>
  * @copyright PrestaShop
  * @license http://www.opensource.org/licenses/osl-3.0.php Open-source licence 3.0
  * @version 1.3
  *
  */
	include_once dirname(__FILE__).'/../../config/config.inc.php'; 
	include dirname(__FILE__).'/scripts/config_events.php'; 
	//Creació formulari Actualitzar taula ampliació.
	include dirname(__FILE__).'/scripts/buscarPlataforma.php';   
	//Recollim el option generat.
	$result = buscarPlataforma();

?>


<link rel="stylesheet" type="text/css" href="tabs/css/style.css">
<link rel="stylesheet" type="text/css" href="tabs/css/botones_menu.css">
<script type="text/javascript" src="tabs/js/funcs.js?id=<?php echo(rand(0,50000));?>"></script>
<script type="text/javascript" src="tabs/js/ajax_load.js"></script>
<script type="text/javascript" src="tabs/js/ajax_load_post.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.4.4/jquery.min.js"></script>

<!-- Començar la pestanya Ampliació Cupo -->
<div id="centrar">

	<!-- Formulari per Afegir una Ampliació de cupo -->
	<div style="display: block; float: left; width: 100%; text-align: left; padding: 10px; background: rgb(255, 255, 255) none repeat scroll 0% 0%; display: block;" id="form_ampliacion_cupon" id="ampliacion_cupon">
			<fieldset>
				<legend>Ampliación Cupones</legend>

				<form id="form_amp_cupo" name="form_amp_cupo" action="./tabs/scripts/afegirAmpliacioCupo.php"  method="POST">
					 <select name="Plataforma" id="Plataforma" onchange="checkPlataforma(this.value)">
					  <?php echo $result;?>
					</select> 
					<input type="text" name="codiLocalitzador" id="codiLocalitzador" placeholder="Localitzador"/>
					<input type="text" name="codiConsum" id="codiConsum" placeholder="Consum"/>
					<input type="submit" id="actCupo" value="Actualitzar Cupon" class="boto"/>
				</form>
			</fieldset>
	</div>
	
	<!-- Cercador dels Cupons Ampliats -->
	<div style="display: block; float: left; width: 100%; text-align: left; padding: 10px; background: rgb(255, 255, 255) none repeat scroll 0% 0%; display: block;" id="buscar_cupon_ampliacion">
			<fieldset>
			<legend>Búsqueda Cupón</legend>
			<div id="msg_error"></div>  
				<form name="frm_cerca_ampliacio" id="frm_cerca_ampliacio" method="POST" action="javascript:;">
					<table>
						<tbody>
							<tr>
								<td align="left" class="cabecera" colspan="2">Número de Localizador</td>
							</tr>
							<tr>
								<td><br/><span class="label_">Localitzador: </span></td>
								<td><br/><input type="text" id="cupon_oferta" name="cupon_oferta" onKeyup="javascript:canviar_pag(1,this.value);"></td>
							</tr>
						</tbody>
					</table>
				</form>
			</fieldset>
	</div>
	
	<!-- Llistat dels Cupons Ampliats -->
	<div style="display: block; float: left; width: 100%; text-align: left; padding: 10px; background: rgb(255, 255, 255) none repeat scroll 0% 0%; display: block;" id="llistat_Ampliacions">
		<fieldset>
		<legend>Listado Cupones</legend>
			<div id="res_consulta"></div>
		</fieldset>
	</div>
	
</div>

<!-- Inici Scripts -->
<script>
	function checkPlataforma(val) {

		r = ajax.load('<?php echo $base_scripts?>ajaxCheckPlataforma.php?id='+val);  

		if(r == 1){
			document.getElementById("codiConsum").style.display="none"; 
			document.getElementById("codiConsum").value=""; 
		}
		else{
			document.getElementById("codiConsum").style.display="initial"; 
		}
	}
	
	function eliminar(id,fecha,loc) {

		var confirmacio = confirm("Voleu eliminar el codi: "+loc+" ?");

		if(confirmacio == true){
			var xhttp = new XMLHttpRequest();
	
			  xhttp.onreadystatechange = function() {
				if (xhttp.readyState == 4 && xhttp.status == 200) {
				  document.getElementById("res_consulta").innerHTML = xhttp.responseText;
				}
			  };
			xhttp.open('GET','<?php echo $base_scripts?>eliminar_ampliacion_ajax.php?id='+id+'&fecha='+fecha, true);
			xhttp.send();
		}
	}

			
	function canviar_pag(page,fil) {	 
	  
	  var xhttp = new XMLHttpRequest();
	
	  xhttp.onreadystatechange = function() {
		if (xhttp.readyState == 4 && xhttp.status == 200) {
		  //Introduim dins del div amb id="res_consulta" el resultat del ajax.
		  document.getElementById("res_consulta").innerHTML = xhttp.responseText;
		}
	  };

		xhttp.open('GET','<?php echo $base_scripts?>buscar_ampliaciones_ajax.php?f='+fil+'&p='+page, true);
		xhttp.send();
	}
	//Un cop el document esta carregat executem la funció per mostrar la primera pàgina.
	$( document ).ready(canviar_pag(1,""));
		
</script>