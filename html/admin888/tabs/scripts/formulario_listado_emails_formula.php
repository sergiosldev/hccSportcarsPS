<?php  
	include_once dirname(__FILE__).'/config_events_new.php';                         
	$horas = array('07:00','07:15','07:30','07:45','08:00','08:15','08:30','08:45','09:00','09:15','09:30','09:45','10:00','10:15','10:30','10:45','11:00','11:15','11:30','11:45','12:00','12:15','12:30','12:45','13:00','13:15','13:30','13:45','14:00','14:15','14:30','14:45','15:00','15:15','15:30','15:45','16:00','16:15','16:30','16:45','17:00','17:15','17:30','17:45','18:00','18:15','18:30','18:45','19:00','19:15','19:30','19:45','20:00','20:15','20:30','20:45','21:00','21:15','21:30','21:45','22:00');     
?>
	<!--<script type="text/javascript" src="tabs/js/funcs_sel_susp.js"></script>-->
 
	<div id="listado_emails" style="display:none;float:left;width:100%;" >
    	<div id='form_listao_emails_formula' style='text-align:left;padding:10px; background:#fff;'>
	    <fieldset>
	    <legend>Listado Emails</legend>
	    <div id="msg_error"></div>   
		
		<form action="javascript:;" onsubmit="abrir_listado_emails(1)" METHOD="POST" id="form_listado_emails_formula" name="form_listado_emails_formula" style="font-size:14px;">                                                                                                   
			<div id="centrar"> 
			<input type="hidden" name= "fdesde" id="fdesde_formula" value="">
			<input type="hidden" name= "fhasta" id="fhasta_formula" value="">

			<div style="float:left;width:70%;padding:20px;">
				   <div style="padding-left:6px;padding-right:5px;">    
						<div style="float:left;padding-right:2px;margin-left:0;" ><input type="radio" id='seleccion_piloto' name="seleccion_cliente" value="email_piloto" onclick="confirmar_seleccion_cliente_formula('seleccion_piloto');">Emails Piloto</div>                   
						<div style="float:left;padding-right:2px;margin-left:10px;" ><input  style="float:left;" id='seleccion_persona_regala_formula' type="radio" name="seleccion_cliente" value="email_persona_regala" onclick="confirmar_seleccion_cliente_formula('seleccion_persona_regala');"><?php echo('Emails Persona Regala');?></div>              
						<div style="float:left;padding-right:2px;margin-left:10px;" ><input  style="float:left;" id='seleccion_confirm_formula' type="radio" name="seleccion_cliente" value="email_confirm" onclick="confirmar_seleccion_cliente_formula('seleccion_confirm');"><?php echo(('Emails de Confirmación'));?></div>              
						<div style="float:left;padding-right:2px;margin-left:10px;" ><input  style="float:left;" id='seleccion_usuario' type="radio"  name="seleccion_cliente" value="email_usuario" onclick="confirmar_seleccion_cliente_formula('seleccion_usuario');">Sólo emails de usuario</div>        					
						<div style="float:left;padding-right:2px;margin-left:10px;" ><input  style="float:left;" id='seleccion_todos_formula' type="radio" checked="ckecked" name="seleccion_cliente" value="email_todos" onclick="confirmar_seleccion_cliente_formula('seleccion_todos');">Todos</div>        
						<input type="hidden" name="sel_cliente" id="sel_cliente_formula" value="email_todos"> 
					</div>
			</div>
			<!-- Fecha Desde -->			
			<div style="float:left;width:70%;padding:20px;">
				<div style="float:left;padding-right:6px;">
				   <span style="float:left;padding-top:2px;padding-left:3px;padding-right:4px;">F.Desde</span>
				   <div style="float:left;" class="listitem">
						<select id="dia_fdesde_formula" name="dia_fdesde" width="10px;" onchange="actualizar_fecha('dia_fdesde_formula','mes_fdesde_formula','any_fdesde_formula','fdesde_formula',0);"> 
							<?php for($dia=1;$dia<=31;$dia++) { ?>
							<option  value="<?php echo($dia);?>"><?php echo($dia);?></option>
							<?php } ?> 
							<option value='0' selected = "selected"></option>
						</select>    
					</div>
					<div style="float:left;" class="listitem">
						<select id="mes_fdesde_formula" name="mes_fdesde"  width="10px;" onchange="actualizar_fecha('dia_fdesde_formula','mes_fdesde_formula','any_fdesde_formula','fdesde_formula',1);">
							<?php for($mes=1;$mes<=12;$mes++) { ?>
							<option  value="<?php echo($mes);?>"><?php echo($mes);?></option>
							<?php } ?> 
							<option value='0' selected = "selected"></option>
						</select>    
					</div>
					<div style="float:left;" class="listitem"> 
						<select id="any_fdesde_formula" name="any_fdesde" width="10px;" onchange="actualizar_fecha('dia_fdesde_formula','mes_fdesde_formula','any_fdesde_formula','fdesde_formula',2);">
							<?php $any1 = date('Y');
							for($any=$any1+5;$any>=$any1-5;$any--) { ?>
							<option value="<?php echo($any);?>"><?php echo($any);?></option>
							<?php } ?> 
							<option value='0' selected = "selected"></option>
						</select>    
					</div>
				</div>
			
				<!-- Fecha Hasta -->			
				<div style="float:left;padding-right:6px;">    
				   <span style="float:left;padding-top:2px;padding-left:3px;padding-right:4px;margin-left:20px;margin-right:10px;">F.Hasta</span>
				   <div style="float:left;" class="listitem">   
						<select id="dia_fhasta_formula" name="dia_fhasta" width="10px;" onchange="actualizar_fecha('dia_fhasta_formula','mes_fhasta_formula','any_fhasta_formula','fhasta_formula',0);">     
							<?php for($dia=1;$dia<=31;$dia++) { ?>               
							<option value="<?php echo($dia);?>"><?php echo($dia);?></option>    
							<?php } ?> 
							<option value='0' selected = "selected"></option>
						</select>    
					</div>
					<div style="float:left;" class="listitem">
						<select id="mes_fhasta_formula" name="mes_fhasta"  width="10px;" onchange="actualizar_fecha('dia_fhasta_formula','mes_fhasta_formula','any_fhasta_formula','fhasta_formula',1);">
							<?php for($mes=1;$mes<=12;$mes++) { ?>
							<option  value="<?php echo($mes);?>"><?php echo($mes);?></option>
							<?php } ?> 
							<option value='0' selected = "selected"></option>
						</select>    
					</div>
					<div style="float:left;" class="listitem"> 
						<select id="any_fhasta_formula" name="any_fhasta" width="10px;" onchange="actualizar_fecha('dia_fhasta_formula','mes_fhasta_formula','any_fhasta_formula','fhasta_formula',2);">                         
							<?php $any1 = date('Y');
							for($any=$any1+5;$any>=$any1-5;$any--) { ?>
							<option value="<?php echo($any);?>"><?php echo($any);?></option>
							<?php } ?> 
							<option value='0' selected = "selected"></option>
						</select>    
					</div>
				   </div>
			   </div>
				
			 <!-- horas-->
			 <div style="float:left;width:70%;padding:20px;">
				<div style="float:left;padding-right:65px;">
				   <span style="float:left;padding-top:2px;padding-left:3px;padding-right:4px;">H.Desde</span>            
				   <div style="float:left;" class="listitem">
						<select id="hdesde_formula" name="hdesde" width="10px;" onchange="validar_hora('hdesde_formula');">                                                         
							<?php 
							foreach($horas as $hora) 
							{ 
								if ($hora=='07:00')
								{
								?>
								<option value="<?php echo($hora);?>" selected="selected"><?php echo($hora);?></option>                   
								<?php
								} else {
								?>
								<option value="<?php echo($hora);?>"><?php echo($hora);?></option>                   
								<?php 
								} 
							}?> 
							<option value='0'></option>
						</select>    
					</div>
				</div>
			
				<!-- Hora Hasta -->			
				<div style="float:left;padding-right:6px;">
				   <span style="float:left;padding-top:2px;padding-left:3px;padding-right:4px;margin-left:20px;margin-right:10px;">H.Hasta</span>
				   <div style="float:left;" class="listitem">
						<select id="hhasta_formula" name="hhasta" width="10px;" onchange="validar_hora('hhasta_formula');">                           
							<?php 
							foreach($horas as $hora) 
							{ 
								if ($hora=='22:00')
								{
								?>
								<option  value="<?php echo($hora);?>" selected="selected"><?php echo($hora);?></option>         
								<?php
								} else {
								?>
								<option  value="<?php echo($hora);?>"><?php echo($hora);?></option>         
								<?php 
								}
							}							
							?> 
							<option value='0'></option>
						</select>    
					</div>
				   </div>
			   </div>			   
			   
			   <!-- fin horas  -->	
				
<!--descarga_emails_sel_formula_vendrell(id_('fdesde_formula').value,id_('fhasta_formula').value,id_('hdesde_formula').value,id_('hhasta_formula').value,$('#sel_cliente_formula').val(),id_('marcar_envio_formula').checked?'1':'') -->
<!-- alert(id_('fdesde_formula').value+id_('fhasta_formula').value+id_('hdesde_formula').value+id_('hhasta_formula').value+$('#sel_cliente_formula').val()+id_('marcar_envio_formula').checked); -->
			<div style="width:75%;float:left;padding:31px;clear:both;padding-left:13px;">
			<a  class="boton_descarga" 	 href="javascript:if (validar_fechas_formula()) descarga_emails_sel_formula_vendrell(id_('fdesde_formula').value,id_('fhasta_formula').value,id_('hdesde_formula').value,id_('hhasta_formula').value,$('#sel_cliente_formula').val())"><span style="color:#f33;font-weight:bold;font-size:15px">@</span> El Vendrell</a>
			<a  class="boton_descarga" 	 href="javascript:if (validar_fechas_formula()) descarga_emails_sel_formula_moradebre(id_('fdesde_formula').value,id_('fhasta_formula').value,id_('hdesde_formula').value,id_('hhasta_formula').value,$('#sel_cliente_formula').val())"><span style="color:#f33;font-weight:bold;font-size:15px">@</span> Mora d'ebre</a>
			<a  class="boton_descarga" 	 href="javascript:if (validar_fechas_formula()) descarga_emails_sel_formula_andalucia(id_('fdesde_formula').value,id_('fhasta_formula').value,id_('hdesde_formula').value,id_('hhasta_formula').value,$('#sel_cliente_formula').val())"><span style="color:#f33;font-weight:bold;font-size:15px">@</span>Andalucía </a>
			<a  class="boton_descarga" 	 href="javascript:if (validar_fechas_formula()) descarga_emails_sel_formula_segovia(id_('fdesde_formula').value,id_('fhasta_formula').value,id_('hdesde_formula').value,id_('hhasta_formula').value,$('#sel_cliente_formula').val())"><span style="color:#f33;font-weight:bold;font-size:15px">@</span>Segovia</a>
			<a  class="boton_descarga" 	 href="javascript:if (validar_fechas_formula()) descarga_emails_sel_formula_zaragoza(id_('fdesde_formula').value,id_('fhasta_formula').value,id_('hdesde_formula').value,id_('hhasta_formula').value,$('#sel_cliente_formula').val())"><span style="color:#f33;font-weight:bold;font-size:15px">@</span>Zaragoza</a>
			<a  class="boton_descarga" 	 href="javascript:if (validar_fechas_formula()) descarga_emails_sel_formula_valencia(id_('fdesde_formula').value,id_('fhasta_formula').value,id_('hdesde_formula').value,id_('hhasta_formula').value,$('#sel_cliente_formula').val())"><span style="color:#f33;font-weight:bold;font-size:15px">@</span>Valencia</a>
			<a  class="boton_descarga" 	 href="javascript:if (validar_fechas_formula()) descarga_emails_sel_formula_all(id_('fdesde_formula').value,id_('fhasta_formula').value,id_('hdesde_formula').value,id_('hhasta_formula').value,$('#sel_cliente_formula').val())"><span style="color:#f33;font-weight:bold;font-size:15px">@</span>Todas</a>
			</div>      				

			<!--<div style="width:75%;float:left;padding:31px;">             
			<a  class="boton_descarga" 	 href="javascript:if (validar_fechas()) descarga_emails_sel_formula_barcelona(id_('cferrari').checked?'1':'',id_('clambo').checked?'1':'',id_('cporsche').checked?'1':'',id_('ccorvette').checked?'1':'',id_('ctodos').checked?'1':'',id_('fdesde').value,id_('fhasta').value,id_('hdesde').value,id_('hhasta').value,$('#sel_cliente').val(),id_('marcar_envio').checked?'1':'')"><span style="color:#f33;font-weight:bold;font-size:15px">@</span> BARCELONA </a> 
			<a  class="boton_descarga"   href="javascript:if (validar_fechas()) descarga_emails_sel_formula_madrid(id_('cferrari').checked?'1':'',id_('clambo').checked?'1':'',id_('cporsche').checked?'1':'',id_('ccorvette').checked?'1':'',id_('ctodos').checked?'1':'',id_('fdesde').value,id_('fhasta').value,id_('hdesde').value,id_('hhasta').value,$('#sel_cliente').val(),id_('marcar_envio').checked?'1':'')" style="width:90px;"><span style="color:#f33;font-weight:bold;font-size:15px">@</span> MADRID </a>  
			<a  class="boton_descarga"   href="javascript:if (validar_fechas()) descarga_emails_sel_formula_valencia(id_('cferrari').checked?'1':'',id_('clambo').checked?'1':'',id_('cporsche').checked?'1':'',id_('ccorvette').checked?'1':'',id_('ctodos').checked?'1':'',id_('fdesde').value,id_('fhasta').value,id_('hdesde').value,id_('hhasta').value,$('#sel_cliente').val(),id_('marcar_envio').checked?'1':'')"><span style="color:#f33;font-weight:bold;font-size:15px">@</span> VALENCIA </a>  
			<a  class="boton_descarga"   href="javascript:if (validar_fechas()) descarga_emails_sel_formula_andalucia(id_('cferrari').checked?'1':'',id_('clambo').checked?'1':'',id_('cporsche').checked?'1':'',id_('ccorvette').checked?'1':'',id_('ctodos').checked?'1':'',id_('fdesde').value,id_('fhasta').value,id_('hdesde').value,id_('hhasta').value,$('#sel_cliente').val(),id_('marcar_envio').checked?'1':'')"><span style="color:#f33;font-weight:bold;font-size:15px">@</span> ANDALUC&Iacute;A</a>  
			<a  class="boton_descarga"   href="javascript:if (validar_fechas()) descarga_emails_sel_formula_cantabria(id_('cferrari').checked?'1':'',id_('clambo').checked?'1':'',id_('cporsche').checked?'1':'',id_('ccorvette').checked?'1':'',id_('ctodos').checked?'1':'',id_('fdesde').value,id_('fhasta').value,id_('hdesde').value,id_('hhasta').value,$('#sel_cliente').val(),id_('marcar_envio').checked?'1':'')"><span style="color:#f33;font-weight:bold;font-size:15px">@</span> CANTABRIA</a>  
			<a  class="boton_descarga"   href="javascript:if (validar_fechas()) descarga_emails_sel_all(id_('cferrari').checked?'1':'',id_('clambo').checked?'1':'',id_('cporsche').checked?'1':'',id_('ccorvette').checked?'1':'',id_('ctodos').checked?'1':'',id_('fdesde').value,id_('fhasta').value,id_('hdesde').value,id_('hhasta').value,$('#sel_cliente').val(),id_('marcar_envio').checked?'1':'')" style="width:158px;"><span style="color:#f33;font-weight:bold;font-size:15px;">@</span> TODAS</a>  
			</div>        
			-->
			<!-- BARRA DE PROGRESO (SE UTILIZARÁ POR EJEMPLO EN EL ENVÍO DE EMAILS) -->
			<label id="texto_barra_progreso2"></label><br>
			<div id="barra_progreso" style="display:none;">
				<div class="contenedor">
					<progress value=0 max=100 id="barra" class="barraStyle"></progress>
				</div>
			 </div>						
			<label style="display:none;width:50%;" id="texto_barra_progreso"></label>			
			
		</form>	
	    </fieldset>
    	</div>
	</div>

	  
<script type="text/javascript">
	function limpiar_fechas_formula()
	{
		limpiar_fecha('dia_fdesde_formula','mes_fdesde_formula','any_fdesde_formula','fdesde_formula');limpiar_fecha('dia_fhasta_formula','mes_fhasta_formula','any_fhasta_formula','fhasta_formula');
	}
	function validar_fechas_formula()
	{
		if (validar_fecha(id_('dia_fdesde_formula').value,id_('mes_fdesde_formula').value,id_('any_fdesde_formula').value) && validar_fecha(id_('dia_fhasta_formula').value,id_('mes_fhasta_formula').value,id_('any_fhasta_formula').value))        
		{
			return true;  
		}
		else 
		{
			alert('Error al introducir las fechas');
			return false;
		}   
	}

	
	function confirmar_seleccion_cliente_formula(tipo)
	{
		var texto='';
		switch (tipo)        
		{
			case 'seleccion_piloto':
				texto='Si marca esta opciónn, al generar el excel se extraerán los emails del PILOTO. Desea continuar?';   
			break;
			case 'seleccion_persona_regala':
				texto='Si marca esta opción, al generar el excel se extraerán los emails de la PERSONA QUE REGALA. Desea continuar?';   
			break;
			case 'seleccion_confirm':
				texto='Si marca esta opción, al generar el excel se extraerán los emails de confirmación. Desea continuar?';       
			break;
			case 'seleccion_usuario':
				texto='Si marca esta opción, al generar el excel se extraerán los emails de usuario. Desea continuar?';       
			break;
			case 'seleccion_todos':
				texto='Si marca esta opción, al generar el excel se extraeán los emails del PILOTO, de la PERSONA QUE REGALA así como los emails de CONFIRMAICÓN. Desea continuar?';   
			break;
		}
	
		if (!confirm(texto))   
		{
			$('#'+tipo).attr('checked',false);   
			$('#seleccion_todos_formula').attr('checked',true);  
			$('#sel_cliente_formula').val('email_todos'); 
		}
		else 
		{
			$('#sel_cliente_formula').val($('#'+tipo).val());    
		}
	}
  
	function actualizarBarraFormula(porcentaje) 
	{ 
	  $("#texto_barra_progreso").html(''); //actualizar etiqueta.

	  if ($('#texto_barra_progreso').css('display')=='none')          
	  {
		$('#texto_barra_progreso').show();
	  }				
	   
			
	  if (porcentaje != undefined && !isNaN(porcentaje))
	  {
			$('#barra').val(Math.round(porcentaje));     
	  }
			
	  $('#barra').attr('max',100);

	  $("#texto_barra_progreso").html(porcentaje+'%'); //actualizar etiqueta.

	  //$("#texto_barra_progreso2").html(porcentaje); //actualizar etiqueta.   
	}
	
</script>	


<style type="text/css">
	.listitem
	{
	height:20px;
	border:1px solid;
	}
</style>

