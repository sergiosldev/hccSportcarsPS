<?php

include dirname(__FILE__).'/scripts/config_events_new.php';
include_once dirname(__FILE__).'/scripts/funciones_ruta_localizadores.php';
?>
 

<script type="text/javascript" src="tabs/js/sha.js"></script>
     <script type="text/javascript" src="tabs/js/funcs.js"></script>
     <script type="text/javascript" src="tabs/js/ajax_load.js"></script>
     <script type="text/javascript" src="tabs/js/ajax_load_post.js"></script>
     <link rel="stylesheet" type="text/css" href="tabs/css/style.css">
     <link rel="stylesheet" type="text/css" href="tabs/css/botones_menu.css">
     <script src="tabs/js/tabpanel.js" type="text/javascript"></script>
     <link type="text/css" rel="stylesheet" href="../../css/tabpane.css" />
     <link media="screen" rel="stylesheet" href="tabs/modal/colorbox.css" />
     <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.4.4/jquery.min.js"></script>
     <script src="tabs/modal/colorbox/jquery.colorbox.js"></script>
<?php 
include dirname(__FILE__).'/scripts/formulario_validar_password_localizadores.php';   
?>

<div id="centrar">
	<div>
	<fieldset>
		<legend>Tipos de Ruta</legend><br>
		<?php 
			$tmp = new TipoRuta();
			$tiposRuta = $tmp->getTiposRuta();
			$i=1;	
			$id_tipo_ruta_defecto = 1;
			foreach ($tiposRuta as $t)
			{
			 if ($t->id_tipo_ruta == $id_tipo_ruta_defecto) $cactivo = "menu_activo";
			 else $cactivo = "";
		?>
			<a href="javascript:cambiar_activo(<?php echo($i);?>,<?php echo(count($tiposRuta));?>,<?php echo($t->id_tipo_ruta)?>);lista_localizadores(<?php echo($t->id_tipo_ruta);?>,'');" style="width:202px;" class="boton_menu <?php echo($cactivo);?>" id="ruta<?php echo($i);?>" ><?php echo($t->descripcion);?></a> 
		<?PHP
			$i++;
			}
		?>
		<input type="hidden" id="id_tipo_ruta" value="" name="id_tipo_ruta">
	</fieldset>
	</div>
	<div>
	<fieldset>
		<legend>Lista de Localizadores para la ruta <span style="font-weight:bold;"><?php /*"'.$descripcion.'"*/?></span></legend>
            <div class="dynamic-tab-pane-control tab-pane" id="tabPane1">
                <div class="tab-row">
                    <h4 class="tab selected" id='tab1'><a href="javascript:CambiarTab('',1,2);">1. Carga Manual.</a> </h4>
                    <h4 class="tab" id='tab2'><a href="javascript:CambiarTab('',2,2);">2. Carga Autom&aacute;tica.</a> </h4>
                </div>
                <div id="step1" class="tab-page" style="display: block;">
					<div id='cabecera_manual' class="fila cabecera" style="line-height:20px !important;">
						<div style="float:left;width:100%;">
							<span class="celda titulo texto"> C&oacute;digo Localizador</span>
							<span class="celda titulo texto email">Nombre y apellidos</span>
							<span class="celda titulo texto email">Origen</span>
						</div>
						
						<div style="float:left;width:100%;">
							<input class="celda" type="text" id="codigo_localizador" name="codigo_localizador">
							<input type="text" id="nombre_apellidos" name="nombre_apellidos" class="celda email" >
							<select id="origen_carga" name="origen_carga" style="margin-top: 7px; margin-left: 13px;margin-right:20px;border:1px solid #CCCCCC;width:170px;" onclick="if (typeof(this.selectedIndex) != 'undefined') actualizar_origen_manual(this.options[this.selectedIndex].value);">
								  <option value="">--Elija opcion--</option>
								  <option value="OFERTIX">OFERTIX</option>
								  <option value="OFFERUM">OFFERUM</option>
								  <option value="DOOPLAN">DOOPLAN</option>
								  <option value="GROUPALIA">GROUPALIA</option>
								  <option value="ATRAPALO">ATRAPALO</option>
								  <option value="GROUPON">GROUPON</option>
								  <option value="CODIGO_ALFA">CÓDIGO ALFA</option>
								  <option value="LA_TIENDA_MARCA">LA TIENDA MARCA</option>
								  <option value="DISFRUTALO">DISFRÚTALO</option>
								  <option value="COLECTIVIA">COLECTIVIA</option>
								  <option value="DACOTABOX">DACOTABOX</option>
								  <option value="SMARTBOX">SMARTBOX</option>
								  <option value="Ticket descuento">Ticket Descuento</option>
								  <option value="Ticket especial">Ticket Especial</option>
								  <option value="OTROS">OTROS</option>
							</select>
							<input type="hidden" id="origenf1" name="origenf1" value="">
							<!--<span class="celda titulo texto"> &nbsp;</span>-->
							<input type="button" id="guardar" name="guardar" style="width:130px;" onclick="if (validar_campos_form_manual()) guardar_localizador(id_('id_tipo_ruta').value,id_('nombre_apellidos').value,id_('codigo_localizador').value,id_('origenf1').value,id_('otros').value)" value="Guardar">
							<input type="hidden" id="id_localizador" name="id_localizador" value=""> 
						</div>
						<div style="float:left;width:100%;">
							<span id="texto_otros" class="celda titulo texto email" style="display:none;">Otros</span>
						</div>
						
						<div style="float:left;width:100%;">
							<input type="text" id="otros" name="otros" class="celda" style="display:none;">	
						</div>
					</div>
				</div>		
                <div id="step2" class="tab-page" style="display: none;">
						<?php 
						include dirname(__FILE__).'/scripts/formulario_carga_localizadores.php';
						?> 
				</div>		
			</div>	
		<div style="margin-top:10px;">
			<input type="button" id="actualizar" name="actualizar" style="width:130px;" onclick="lista_localizadores(id_('id_tipo_ruta').value,'');" value="Actualizar">		
		    <span  style="display:inline-block;margin-left:200px;">Localizador</span><input class="celda" type="text" id="codigo_localizador_buscado" name="codigo_localizador_buscado">
			<input type="button" id="buscar" name="buscar" style="width:130px;" onclick="lista_localizadores(id_('id_tipo_ruta').value,id_('codigo_localizador_buscado').value);" value="Buscar">					
		</div>
		<div id="lista_localizadores">
		<?php 
			$form = getFormLocalizadoresRuta(1);
			echo $form; 
		?>
		</div>
	</fieldset>
	</div>
</div>




<?php 


?> 

<script language="javascript">

	function validar_campos_form_manual()
	{
		var error = '';
		if (id_('origenf1').value == '') 
		{
			error = 'Debe seleccionar un origen';
		}
		
		if (id_('origenf1').value=='OTROS')
			if (id_('otros').value == '') 
			{
				error='Debe introducir la descripción del origen en "otros"';
			}

		if (id_('codigo_localizador').value == '') 
		{
			error = 'Debe introducir el codigo localizador';
		}
		
		if (error !='') {alert(error);return false;}
		return true;
	}
	function actualizar_origen_manual(origen)
	{
		id_('origenf1').value=origen;
		if (origen=='OTROS')  {id_('texto_otros').style.display='block';id_('otros').style.display='block';}
		else {id_('texto_otros').style.display='none';id_('otros').style.display='none';}
	}
	function cambiar_activo(indice,nelems,id_tipo_ruta)
	{
		for(var i=1;i<=nelems;i++)
		{
			if (i==indice) id_('ruta'+i).className='boton_menu menu_activo';
			else id_('ruta'+i).className='boton_menu';
			id_('id_tipo_ruta').value=id_tipo_ruta;
		}
	}
	
	
	function lista_localizadores(id_tipo_ruta,codigo_localizador)
	{
		var aleatorio = '&v'+Math.floor(Math.random()*50000)+'=1';
		var datos = 'operacion=listado'; 
		datos += '&id_tipo_ruta='+id_tipo_ruta;
		datos += '&codigo_localizador='+codigo_localizador;
		r=ajax.load('<?php echo $base_scripts ?>localizadores_ruta.php?'+datos+aleatorio);
		
		if (r.indexOf('#error')==-1)
			{
			id_('lista_localizadores').innerHTML = r;
			}
	}
	
	
	function guardar_localizador(id_tipo_ruta,nombre_apellidos,codigo_localizador,origen,otros)
	{
		var aleatorio = '&v'+Math.floor(Math.random()*50000)+'=1';
		var datos = 'operacion=guardar'; 
		datos += '&id_tipo_ruta='+id_tipo_ruta+'&nombre_apellidos='+nombre_apellidos+'&codigo_localizador='+codigo_localizador+'&origen='+origen+'&otros='+otros;
		//alert('<?php echo($base_scripts);?>localizadores_ruta.php?'+datos+aleatorio);
		var r = ajax.load('<?php echo($base_scripts);?>localizadores_ruta.php?'+datos+aleatorio);
		if (r.indexOf('OK')!=-1) 
		{
			lista_localizadores(id_tipo_ruta,'');		
		}
		else alert('Se ha producido un error al guardar el localizador. Es probable que el código de localizador ya exista para este tipo de ruta'); 
	}
	
	
	
	
	function borrar_localizador(id_localizador,id_tipo_ruta)
	{
		var aleatorio = '&v'+Math.floor(Math.random()*50000)+'=1';

        if (!confirm('Está seguro de que desea borrar este localizador?')) 
         {
             return;
         }
         else {
            id_('frm_validar_password_localizadores').reset();
            id_('archivo_operacion').value= 'localizadores_ruta.php'
            id_('archivo_retorno').value = '';
            id_('div_retorno').value= '';
            id_('ancho_div_retorno').value = 80;
			var datos = 'operacion=borrar'; 
			datos += '&id_localizador='+id_localizador;
            id_('datos').value = datos;

			var cbclose = $.colorbox.close;
			$.colorbox.close = function ()
			{
				lista_localizadores(id_tipo_ruta,'');
				$.colorbox.close = cbclose;
				cbclose();
			}
			
            $.colorbox({width:"42%", inline:true, href:"#form_validar_password_localizadores",open:true}); 
            return;          
         }	
	}
	
	/*function borrar_localizador(id_localizador,id_tipo_ruta)
	{
		var aleatorio = '&v'+Math.floor(Math.random()*50000)+'=1';
		var datos = 'operacion=borrar'; 
		datos += '&id_localizador='+id_localizador;
		//alert('<?php echo($base_scripts);?>localizadores_ruta.php?'+datos+aleatorio);
		var r = ajax.load('<?php echo($base_scripts);?>localizadores_ruta.php?'+datos+aleatorio);
		if (r.indexOf('OK')!=-1) 
		{
			lista_localizadores(id_tipo_ruta);
		}
	}*/

	
</script>
  
  
 <style>
 
 .celda
 {
  width:150px;
  margin:0 10px 0 10px;
 }
 .titulo
 {
  color:#006699;
 }
 
 .texto
 {
  text-align:left;
  font-weight:bold;
  display:inline-block;
  padding: 2px 4px;  
  font-size:11px;
  
 }
 
 .fila
 {
	width:100%;
	padding: 5px 0 5px 0;
	border: 1px solid #DFD5C3;
	height:120px;
	/*line-height:60px;*/

 }
 
 .cabecera1
 {
	height:121px !important;
 }
 
 .email
 {
  width:200px;
 }
 
 .cabecera2
 {
	height:60px !important;
	border:none;
 }
 
 </style>  