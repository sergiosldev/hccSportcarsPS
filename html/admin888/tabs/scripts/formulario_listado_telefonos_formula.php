<?php  
	include_once dirname(__FILE__).'/config_events_new.php';                         
	$horas = array('07:00','07:15','07:30','07:45','08:00','08:15','08:30','08:45','09:00','09:15','09:30','09:45','10:00','10:15','10:30','10:45','11:00','11:15','11:30','11:45','12:00','12:15','12:30','12:45','13:00','13:15','13:30','13:45','14:00','14:15','14:30','14:45','15:00','15:15','15:30','15:45','16:00','16:15','16:30','16:45','17:00','17:15','17:30','17:45','18:00','18:15','18:30','18:45','19:00','19:15','19:30','19:45','20:00','20:15','20:30','20:45','21:00','21:15','21:30','21:45','22:00');     
?>
 
	<div id="listado_telefonos" style="display:none;float:left;width:100%;" >
    	<div id='form_listao_telefonos_formula' style='text-align:left;padding:10px; background:#fff;'>
	    <fieldset>
	    <legend>Listado tel&eacute;fonos fórmula</legend>
	    <div id="msg_error"></div>   
		
		<form action="javascript:;" onsubmit="abrir_listado_telefonos_formula(1)" METHOD="POST" id="form_listado_telefonos_formula" name="form_listado_telefonos_formula" style="font-size:14px;">                                                                                                   
																															              
			<div id="centrar"> 
			<input type="hidden" name= "fdesde_formula" id="fdesde_tel_formula" value="">
			<input type="hidden" name= "fhasta_formula" id="fhasta_tel_formula" value="">

			<div style="float:left;width:70%;padding:20px;">
				   <div style="padding-left:6px;padding-right:5px;">    
						<div style="float:left;padding-right:2px;margin-left:0;" ><input type="radio" id='seleccion_piloto_tel_formula' name="seleccion_cliente_formula" value="telef_piloto_formula" onclick="confirmar_seleccion_cliente_tel_formula('seleccion_piloto_tel_formula');">Tel&eacute;fonos Piloto</div>                   
						<div style="float:left;padding-right:2px;margin-left:10px;" ><input  style="float:left;" id='seleccion_persona_regala_tel_formula' type="radio" name="seleccion_cliente_formula" value="telef_persona_regala_formula" onclick="confirmar_seleccion_cliente_formula(seleccion_persona_regala_tel_formula');">Tel&eacute;fonos Persona Regala</div>              
						<div style="float:left;padding-right:2px;margin-left:10px;" ><input  style="float:left;" id='seleccion_todos_tel_formula' type="radio" checked="ckecked" name="seleccion_cliente_formula" value="telef_todos_formula" onclick="confirmar_seleccion_cliente_tel_formula('seleccion_todos_tel_formula');">Todos</div>        
						<input type="hidden" name="sel_cliente_formula" id="sel_cliente_tel_formula" value="telef_todos_formula"> 
					</div>
			</div>
			<!-- Fecha Desde -->			
			<div style="float:left;width:70%;padding:20px;">
				<div style="float:left;padding-right:6px;">
				   <span style="float:left;padding-top:2px;padding-left:3px;padding-right:4px;">F.Desde</span>
				   <div style="float:left;" class="listitem">
						<select id="dia_fdesde_tel_formula" name="dia_fdesde_formula" width="10px;" onchange="actualizar_fecha('dia_fdesde_tel','mes_fdesde_tel','any_fdesde_tel','fdesde_tel',0);"> 
							<?php for($dia=1;$dia<=31;$dia++) { ?>
							<option  value="<?php echo($dia);?>"><?php echo($dia);?></option>
							<?php } ?> 
							<option value='0' selected = "selected"></option>
						</select>    
					</div>
					<div style="float:left;" class="listitem">
						<select id="mes_fdesde_tel_formula" name="mes_fdesde_formula"  width="10px;" onchange="actualizar_fecha('dia_fdesde_tel_formula','mes_fdesde_tel_formula','any_fdesde_tel_formula','fdesde_tel_formula',1);">
							<?php for($mes=1;$mes<=12;$mes++) { ?>
							<option  value="<?php echo($mes);?>"><?php echo($mes);?></option>
							<?php } ?> 
							<option value='0' selected = "selected"></option>
						</select>    
					</div>
					<div style="float:left;" class="listitem"> 
						<select id="any_fdesde_tel_formula" name="any_fdesde_formula" width="10px;" onchange="actualizar_fecha('dia_fdesde_tel_formula','mes_fdesde_tel_formula','any_fdesde_tel_formula','fdesde_tel_formula',2);">
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
						<select id="dia_fhasta_tel_formula" name="dia_fhasta_formula" width="10px;" onchange="actualizar_fecha('dia_fhasta_tel_formula','mes_fhasta_tel_formula','any_fhasta_tel_formula','fhasta_tel_formula',0);">     
							<?php for($dia=1;$dia<=31;$dia++) { ?>               
							<option value="<?php echo($dia);?>"><?php echo($dia);?></option>    
							<?php } ?> 
							<option value='0' selected = "selected"></option>
						</select>    
					</div>
					<div style="float:left;" class="listitem">
						<select id="mes_fhasta_tel_formula" name="mes_fhasta_formula"  width="10px;" onchange="actualizar_fecha('dia_fhasta_tel_formula','mes_fhasta_tel_formula','any_fhasta_tel_formula','fhasta_tel_formula',1);">
							<?php for($mes=1;$mes<=12;$mes++) { ?>
							<option  value="<?php echo($mes);?>"><?php echo($mes);?></option>
							<?php } ?> 
							<option value='0' selected = "selected"></option>
						</select>    
					</div>
					<div style="float:left;" class="listitem"> 
						<select id="any_fhasta_tel_formula" name="any_fhasta_formula" width="10px;" onchange="actualizar_fecha('dia_fhasta_tel_formula','mes_fhasta_tel_formula','any_fhasta_tel_formula','fhasta_tel_formula',2);">                         
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
						<select id="hdesde_tel_formula" name="hdesde" width="10px;" onchange="validar_hora_tel_formula('hdesde_tel_formula');">                                                         
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
						<select id="hhasta_tel_formula" name="hhasta_formula" width="10px;" onchange="validar_hora_tel_formula('hhasta_tel_formula');">                           
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
				
				

			   <input type="hidden" id="tipo_coche_tel" valud="formula">
			   <br />




			<div style="width:75%;float:left;padding:31px;clear:both;padding-left:13px;">
			<a  class="boton_descarga" 	 href="javascript:if (validar_fechas_tel_formula()) descarga_telefonos_formula_vendrell(id_('fdesde_tel_formula').value,id_('fhasta_tel_formula').value,id_('hdesde_tel_formula').value,id_('hhasta_tel_formula').value,$('#sel_cliente_tel_formula').val())"><span style="color:#f33;font-weight:bold;font-size:15px">@</span> El Vendrell</a>
			<a  class="boton_descarga" 	 href="javascript:if (validar_fechas_tel_formula()) descarga_telefonos_formula_moradebre(id_('fdesde_tel_formula').value,id_('fhasta_tel_formula').value,id_('hdesde_tel_formula').value,id_('hhasta_tel_formula').value,$('#sel_cliente_tel_formula').val())"><span style="color:#f33;font-weight:bold;font-size:15px">@</span> Mora d'ebre</a>
			<a  class="boton_descarga" 	 href="javascript:if (validar_fechas_tel_formula()) descarga_telefonos_formula_andalucia(id_('fdesde_tel_formula').value,id_('fhasta_tel_formula').value,id_('hdesde_tel_formula').value,id_('hhasta_tel_formula').value,$('#sel_cliente_tel_formula').val())"><span style="color:#f33;font-weight:bold;font-size:15px">@</span>Andalucía </a>
			<a  class="boton_descarga" 	 href="javascript:if (validar_fechas_tel_formula()) descarga_telefonos_formula_segovia(id_('fdesde_tel_formula').value,id_('fhasta_tel_formula').value,id_('hdesde_tel_formula').value,id_('hhasta_tel_formula').value,$('#sel_cliente_tel_formula').val())"><span style="color:#f33;font-weight:bold;font-size:15px">@</span>Segovia</a>
			<a  class="boton_descarga" 	 href="javascript:if (validar_fechas_tel_formula()) descarga_telefonos_formula_zaragoza(id_('fdesde_tel_formula').value,id_('fhasta_tel_formula').value,id_('hdesde_tel_formula').value,id_('hhasta_tel_formula').value,$('#sel_cliente_tel_formula').val())"><span style="color:#f33;font-weight:bold;font-size:15px">@</span>Zaragoza</a>
			<a  class="boton_descarga" 	 href="javascript:if (validar_fechas_tel_formula()) descarga_telefonos_formula_valencia(id_('fdesde_tel_formula').value,id_('fhasta_tel_formula').value,id_('hdesde_tel_formula').value,id_('hhasta_tel_formula').value,$('#sel_cliente_tel_formula').val())"><span style="color:#f33;font-weight:bold;font-size:15px">@</span>Valencia</a>
			</div>       
		   <div style="float:left;padding-right:14px;margin-top:-2px;clear:both;margin-left:23px;"> 
					<a href="javascript:limpiar_fechas_tel_formula();"><img width="22px" alt="" src="tabs/img/limpiar.jpg">Limpiar</a>
		   </div>
		</form>	
	    </fieldset>
    	</div>
	</div>

	  
<script type="text/javascript">
	function limpiar_fechas_tel_formula()
	{
	    id_('ctodos').checked='checked';
		limpiar_fecha('dia_fdesde_tel_formula','mes_fdesde_tel_formula','any_fdesde_tel_formula','fdesde_tel_formula');limpiar_fecha('dia_fhasta_tel_formula','mes_fhasta_tel_formula','any_fhasta_tel_formula','fhasta_tel_formula');
	}
	function validar_fechas_tel_formula()
	{
		if (validar_fecha(id_('dia_fdesde_tel_formula').value,id_('mes_fdesde_tel_formula').value,id_('any_fdesde_tel_formula').value) && validar_fecha(id_('dia_fhasta_tel_formula').value,id_('mes_fhasta_tel_formula').value,id_('any_fhasta_tel_formula').value))        
		return true;  
		else 
		{
			alert('Error al introducir las fechas');
			return false;
		}   
	}

	
	function confirmar_seleccion_cliente_tel_formula(tipo)
	{
		var texto='';
		switch (tipo)        
		{
			case 'seleccion_piloto_tel_formula':   
				texto='Si marca esta opción, al generar el excel se extraerán los números de tel. del PILOTO. Desea continuar?';
			break;
			case 'seleccion_persona_regala_tel_formula':
				texto='Si marca esta opción, al generar el excel se extraerán los números de tel. de la PERSONA QUE REGALA. Desea continuar?';
			break;
			case 'seleccion_todos_tel_formula':
				texto='Si marca esta opción, al generar el excel se extraerán los números de tel. del PILOTO y de la PERSONA QUE REGALA. Desea continuar?';
			break;
		}
	
		if (!confirm(texto)) 
		{
			$('#'+tipo+'_tel').attr('checked',false);
			$('#seleccion_todos_tel_formula').attr('checked',true);
			$('#sel_cliente_tel_formula').val('telef_todos');
		}
		else 
		{
			$('#sel_cliente_tel_formula').val($('#'+tipo).val());
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

