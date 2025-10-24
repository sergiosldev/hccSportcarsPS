<?php  
	include_once dirname(__FILE__).'/config_events_new.php';                         
	$horas = array('07:00','07:15','07:30','07:45','08:00','08:15','08:30','08:45','09:00','09:15','09:30','09:45','10:00','10:15','10:30','10:45','11:00','11:15','11:30','11:45','12:00','12:15','12:30','12:45','13:00','13:15','13:30','13:45','14:00','14:15','14:30','14:45','15:00','15:15','15:30','15:45','16:00','16:15','16:30','16:45','17:00','17:15','17:30','17:45','18:00','18:15','18:30','18:45','19:00','19:15','19:30','19:45','20:00','20:15','20:30','20:45','21:00','21:15','21:30','21:45','22:00');     
?>
	<!--<script type="text/javascript" src="tabs/js/funcs_sel_susp.js"></script>-->
 
	<div id="listado_telefonos" style="display:none;float:left;width:100%;" >
    	<div id='form_listao_telefonos' style='text-align:left;padding:10px; background:#fff;'>
	    <fieldset>
	    <legend>Listado tel&eacute;fonos</legend>
	    <div id="msg_error"></div>   
		
		<form action="javascript:;" onsubmit="abrir_listado_telefonos()" METHOD="POST" id="form_listado_telefonos" name="form_listado_telefonos" style="font-size:14px;">                                                                                                   
			<div id="centrar"> 
			<input type="hidden" name= "fdesde" id="fdesde_tel" value="">
			<input type="hidden" name= "fhasta" id="fhasta_tel" value="">

			<div style="float:left;width:70%;padding:20px;">
				   <div style="padding-left:6px;padding-right:5px;">    
						<div style="float:left;padding-right:2px;margin-left:0;" ><input type="radio" id='seleccion_piloto_tel' name="seleccion_cliente" value="telef_piloto" onclick="confirmar_seleccion_cliente_tel('seleccion_piloto_tel');">Tel&eacute;fonos Piloto</div>                   
						<div style="float:left;padding-right:2px;margin-left:10px;" ><input  style="float:left;" id='seleccion_persona_regala_tel' type="radio" name="seleccion_cliente" value="telef_persona_regala" onclick="confirmar_seleccion_cliente(seleccion_persona_regala_tel');">Tel&eacute;fonos Persona Regala</div>              
						<div style="float:left;padding-right:2px;margin-left:10px;" ><input  style="float:left;" id='seleccion_todos_tel' type="radio" checked="ckecked" name="seleccion_cliente" value="telef_todos"onclick="confirmar_seleccion_cliente_tel('seleccion_todos_tel');">Todos</div>        
						<input type="hidden" name="sel_cliente" id="sel_cliente_tel" value="telef_todos"> 
					</div>
			</div>
			<!-- Fecha Desde -->			
			<div style="float:left;width:70%;padding:20px;">
				<div style="float:left;padding-right:6px;">
				   <span style="float:left;padding-top:2px;padding-left:3px;padding-right:4px;">F.Desde</span>
				   <div style="float:left;" class="listitem">
						<select id="dia_fdesde_tel" name="dia_fdesde" width="10px;" onchange="actualizar_fecha('dia_fdesde_tel','mes_fdesde_tel','any_fdesde_tel','fdesde_tel',0);"> 
							<?php for($dia=1;$dia<=31;$dia++) { ?>
							<option  value="<?php echo($dia);?>"><?php echo($dia);?></option>
							<?php } ?> 
							<option value='0' selected = "selected"></option>
						</select>    
					</div>
					<div style="float:left;" class="listitem">
						<select id="mes_fdesde_tel" name="mes_fdesde"  width="10px;" onchange="actualizar_fecha('dia_fdesde_tel','mes_fdesde_tel','any_fdesde_tel','fdesde_tel',1);">
							<?php for($mes=1;$mes<=12;$mes++) { ?>
							<option  value="<?php echo($mes);?>"><?php echo($mes);?></option>
							<?php } ?> 
							<option value='0' selected = "selected"></option>
						</select>    
					</div>
					<div style="float:left;" class="listitem"> 
						<select id="any_fdesde_tel" name="any_fdesde" width="10px;" onchange="actualizar_fecha('dia_fdesde_tel','mes_fdesde_tel','any_fdesde_tel','fdesde_tel',2);">
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
						<select id="dia_fhasta_tel" name="dia_fhasta" width="10px;" onchange="actualizar_fecha('dia_fhasta_tel','mes_fhasta_tel','any_fhasta_tel','fhasta_tel',0);">     
							<?php for($dia=1;$dia<=31;$dia++) { ?>               
							<option value="<?php echo($dia);?>"><?php echo($dia);?></option>    
							<?php } ?> 
							<option value='0' selected = "selected"></option>
						</select>    
					</div>
					<div style="float:left;" class="listitem">
						<select id="mes_fhasta_tel" name="mes_fhasta"  width="10px;" onchange="actualizar_fecha('dia_fhasta_tel','mes_fhasta_tel','any_fhasta_tel','fhasta_tel',1);">
							<?php for($mes=1;$mes<=12;$mes++) { ?>
							<option  value="<?php echo($mes);?>"><?php echo($mes);?></option>
							<?php } ?> 
							<option value='0' selected = "selected"></option>
						</select>    
					</div>
					<div style="float:left;" class="listitem"> 
						<select id="any_fhasta_tel" name="any_fhasta" width="10px;" onchange="actualizar_fecha('dia_fhasta_tel','mes_fhasta_tel','any_fhasta_tel','fhasta_tel',2);">                         
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
						<select id="hdesde_tel" name="hdesde" width="10px;" onchange="validar_hora_tel('hdesde_tel');">                                                         
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
						<select id="hhasta_tel" name="hhasta" width="10px;" onchange="validar_hora_tel('hhasta_tel');">                           
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
				
				
			   <div style="float:left;width:70%;padding:6px;">
				   <div style="padding-left:6px;padding-right:5px;">
						<div style="float:left;padding-right:2px;margin-left:10px;" ><input type="checkbox" id='cferrari_tel' name="tipo_ferrari" value="ferrari" onClick="id_('tipo_coche_tel').value=this.value;">Ferrari</div>
						<div style="float:left;padding-right:2px;margin-left:10px;" ><input  style="float:left;" id='clambo_tel' type="checkbox" name="tipo_lambo" value="lamborghini" onClick="id_('tipo_coche_tel').value=this.value;">Lamborghini</div>
						<div style="float:left;padding-right:2px;margin-left:10px;" ><input  style="float:left;" id='cporsche_tel' type="checkbox" name="tipo_porsche" value="porsche" onClick="id_('tipo_coche_tel').value=this.value;">Porsche</div>
						<div style="float:left;padding-right:2px;margin-left:10px;" ><input  style="float:left;" id='ccorvette_tel' type="checkbox" name="tipo_corvette" value="corvette" onClick="id_('tipo_coche_tel').value=this.value;">Corvette</div>  
						<div style="float:left;padding-right:18px;margin-left:10px;" ><input  style="float:left;" id='ctodos_tel' type="checkbox" name="tipo_todos" value="todos" onClick="id_('tipo_coche_tel').value=this.value;">Todos</div>
						<input type="hidden" id="tipo_coche_tel">
					</div>
					<div style="float:left;padding-right:14px;margin-top:-2px;"> 
						<span style="float:left;border:1px solid #D2D2D2;background:#D2D2D2;padding:3px 0 3px 0;font-size:6px;line-height:15px;margin-left:10px;margin-right:20px;">&nbsp;</span>			
						<a href="javascript:limpiar_fechas_tel();"><img width="22px" alt="" src="tabs/img/limpiar.jpg">Limpiar</a>
					</div>
				</div>
			</div>




			<div style="width:75%;float:left;padding:31px;">
			<a  class="boton_descarga" 	 href="javascript:if (validar_fechas_tel()) descarga_telefonos_barcelona(id_('cferrari_tel').checked?'1':'',id_('clambo_tel').checked?'1':'',id_('cporsche_tel').checked?'1':'',id_('ccorvette_tel').checked?'1':'',id_('ctodos_tel').checked?'1':'',id_('fdesde_tel').value,id_('fhasta_tel').value,id_('hdesde_tel').value,id_('hhasta_tel').value,$('#sel_cliente_tel').val())"><span style="color:#f33;font-weight:bold;font-size:15px">@</span> BARCELONA </a>
			<a  class="boton_descarga"   href="javascript:if (validar_fechas_tel()) descarga_telefonos_madrid(id_('cferrari_tel').checked?'1':'',id_('clambo_tel').checked?'1':'',id_('cporsche_tel').checked?'1':'',id_('ccorvette_tel').checked?'1':'',id_('ctodos_tel').checked?'1':'',id_('fdesde_tel').value,id_('fhasta_tel').value,id_('hdesde_tel').value,id_('hhasta_tel').value,$('#sel_cliente_tel').val())" style="width:90px;"><span style="color:#f33;font-weight:bold;font-size:15px">@</span> MADRID </a>
			<a  class="boton_descarga"   href="javascript:if (validar_fechas_tel()) descarga_telefonos_valencia(id_('cferrari_tel').checked?'1':'',id_('clambo_tel').checked?'1':'',id_('cporsche_tel').checked?'1':'',id_('ccorvette_tel').checked?'1':'',id_('ctodos_tel').checked?'1':'',id_('fdesde_tel').value,id_('fhasta_tel').value,id_('hdesde_tel').value,id_('hhasta_tel').value,$('#sel_cliente_tel').val())"><span style="color:#f33;font-weight:bold;font-size:15px">@</span> VALENCIA </a>
			<a  class="boton_descarga"   href="javascript:if (validar_fechas_tel()) descarga_telefonos_andalucia(id_('cferrari_tel').checked?'1':'',id_('clambo_tel').checked?'1':'',id_('cporsche_tel').checked?'1':'',id_('ccorvette_tel').checked?'1':'',id_('ctodos_tel').checked?'1':'',id_('fdesde_tel').value,id_('fhasta_tel').value,id_('hdesde_tel').value,id_('hhasta_tel').value,$('#sel_cliente_tel').val())"><span style="color:#f33;font-weight:bold;font-size:15px">@</span> ANDALUC&Iacute;A</a>
			<a  class="boton_descarga"   href="javascript:if (validar_fechas_tel()) descarga_telefonos_cantabria(id_('cferrari_tel').checked?'1':'',id_('clambo_tel').checked?'1':'',id_('cporsche_tel').checked?'1':'',id_('ccorvette_tel').checked?'1':'',id_('ctodos_tel').checked?'1':'',id_('fdesde_tel').value,id_('fhasta_tel').value,id_('hdesde_tel').value,id_('hhasta_tel').value,$('#sel_cliente_tel').val())"><span style="color:#f33;font-weight:bold;font-size:15px">@</span> CANTABRIA</a>
			<a  class="boton_descarga"   href="javascript:if (validar_fechas_tel()) descarga_telefonos_all(id_('cferrari_tel').checked?'1':'',id_('clambo_tel').checked?'1':'',id_('cporsche_tel').checked?'1':'',id_('ccorvette_tel').checked?'1':'',id_('ctodos_tel').checked?'1':'',id_('fdesde_tel').value,id_('fhasta_tel').value,id_('hdesde_tel').value,id_('hhasta_tel').value,$('#sel_cliente_tel').val())" style="width:158px;"><span style="color:#f33;font-weight:bold;font-size:15px;">@</span> TODAS</a>
			</div>       
		</form>	
	    </fieldset>
    	</div>
	</div>

	  
<script type="text/javascript">
	function limpiar_fechas_tel()
	{
	    id_('ctodos').checked='checked';
		limpiar_fecha('dia_fdesde_tel','mes_fdesde_tel','any_fdesde_tel','fdesde_tel');limpiar_fecha('dia_fhasta_tel','mes_fhasta_tel','any_fhasta_tel','fhasta_tel');
	}
	function validar_fechas_tel()
	{
		if (validar_fecha(id_('dia_fdesde_tel').value,id_('mes_fdesde_tel').value,id_('any_fdesde_tel').value) && validar_fecha(id_('dia_fhasta_tel').value,id_('mes_fhasta_tel').value,id_('any_fhasta_tel').value))        
		return true;  
		else 
		{
			alert('Error al introducir las fechas');
			return false;
		}   
	}

	
	function confirmar_seleccion_cliente_tel(tipo)
	{
		var texto='';
		switch (tipo)        
		{
			case 'seleccion_piloto_tel':   
				texto='Si marca esta opción, al generar el excel se extraerán los números de tel. del PILOTO. Desea continuar?';
			break;
			case 'seleccion_persona_regala_tel':
				texto='Si marca esta opción, al generar el excel se extraerán los números de tel. de la PERSONA QUE REGALA. Desea continuar?';
			break;
			case 'seleccion_todos_tel':
				texto='Si marca esta opción, al generar el excel se extraerán los números de tel. del PILOTO y de la PERSONA QUE REGALA. Desea continuar?';
			break;
		}
	
		if (!confirm(texto)) 
		{
			$('#'+tipo+'_tel').attr('checked',false);
			$('#seleccion_todos_tel').attr('checked',true);
			$('#sel_cliente_tel').val('telef_todos');
		}
		else 
		{
			$('#sel_cliente_tel').val($('#'+tipo).val());
		}
	}

	
</script>	

<style type="text/css">
	.listitem
	{
	height:20px;
	border:1px solid;
	}
</style>

