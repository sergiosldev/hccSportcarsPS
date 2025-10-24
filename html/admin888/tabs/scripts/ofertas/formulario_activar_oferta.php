
<div id="activar_oferta" style="display:none;float:left;width:100%;" >
    <div id='form_activar_oferta' style='text-align:left;padding:10px; background:#fff;'>
    <fieldset>
    <legend>Activar Oferta </legend>
    <div id="msg_error_activ" style="font-size:18px;color:red;"></div>  
    <FORM ACTION="javascript:;" action="" METHOD="POST" id="frm_activar_oferta" name="frm_activar_oferta">
          <table class="opcion_activar">
			<tr>    
				<td class="opcion_activar">
				  <table class="opcion_activar2">
					<tr><td><legend>Introduzca el periodo de duraci&oacute;n de la oferta </legend></td></tr>  
					<tr height="10px;"><td></td></tr>
					<tr class="periodo"><td><input id="tperiodo" name="tperiodo" type="text" value="" style="width:100px;" onkeypress="return (validarNumerico(event));"/></td></tr>
					<tr class="periodo"><td><input type="button" value="Activar" onclick="seleccionar_periodo($('#tperiodo').val());"/></td></tr>
					<tr height="10px;"><td></td></tr>
					<!--<tr class="periodo"><td style="vertical-align:bottom;"><INPUT id="boton_activar" name="boton_activar" TYPE="submit" class="boto" value="Aceptar"></td></tr>-->
				   </table>
				</td>
				<td id="empresas" class="opcion_activar">
				<table class="opcion_activar2">
					<tr><td><legend>Seleccione las empresas a visualizar</legend></td></tr>  
					<tr height="10px;"><td></td></tr>
					<tr>
						<td>
						<span class="periodo2">Motor Club&nbsp; </span>
						<input type="checkbox" id="motorclub">
						</td>
					</tr>
					<tr>
						<td>
							<span class="periodo2">Dream Cars </span> 
							<input type="checkbox" id="dreamcars">
						</td>
					</tr>
					<tr>
						<td>
							<span class="periodo2">Hcc Sport Cars&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </span> 
							<input type="checkbox" id="hcc">
						</td>	
					</tr>
				</table>
				</td>
				<td id="reinicio_periodo" class="opcion_activar">
				<table class="opcion_activar2">
					<tr><td><legend>Reinicio autom&aacute;tico del periodo?</legend></td></tr>  
					<tr height="10px;"><td></td></tr>
					<tr>
						<td>
						<span class="periodo2" >Reinicio autom&aacute;tico</span>
						<input type="checkbox" id="cperiodo_automatico">
						</td>
					</tr>
				</table>
				</td>
			</tr>
			<tr>
				<td colspan="2" style="text-align:right">
					<input type="button" id="bguardar_empresa" value="guardar empresas + reinicio" onclick="guardar_empresa(true);" style="width:200px;display:none;">
				</td>
			</tr>
		   </table>
		   <INPUT style="visibility:hidden;" id="boton_activar" name="boton_activar" TYPE="submit" class="boto" value="Aceptar">
           <input type="hidden" id="id_oferta_fba" name="id_oferta_fba">
           <input type="hidden" id="periodo_fba" name="periodo_fba">
           <input type="hidden" id="activa_fba" name="activa_fba">
           <input type="hidden" id="tipo_oferta_fba" name="tipo_oferta_fba">  
           <input type="hidden" id="cliente_especial_fba" name="cliente_especial_fba">
           <input type="hidden" id="periodo_automatico_fba" name="periodo_automatico_fba">       
	</FORM> 
    </fieldset>
    </div>
</div>
<style>
    .periodo{font-size:17px;text-align:center;}
    .periodo2{font-size:15px;text-align:left;width:160px;float:left;}	
    .opcion_activar{height:100px;vertical-align:top;}
</style>

<script type="text/javascript">


	/** el parámetro opción corresponde al periodo en días **/
	function seleccionar_periodo(opcion)
	{
	    
		//periodo en horas.
		var nopcion = parseInt(opcion)*24;
		if ((id_('motorclub').checked || id_('dreamcars').checked || id_('hcc').checked) == false)
			{
				alert('Debe seleccionar al menos una empresa');
				return;
			}

	    if (document.getElementById('activa_fba').value==1 && 
			document.getElementById('periodo_fba').value==nopcion && 
			document.getElementById('cliente_especial_fba').value!=1  
			)
	    {
	        if (!confirm('Esta oferta ya ha sido activada. ¿Desea volver a activarla para este periodo?'))
				return;
	    }
	    id_('periodo').value=nopcion;
	    id_('periodo_fba').value=nopcion;
		var motorclub = 0;
		var dreamcars = 0;
		var hcc = 0;
		if (id_('motorclub').checked) motorclub = 1;
		if (id_('dreamcars').checked) dreamcars = 1;
		if (id_('hcc').checked) hcc = 1;
	    envia_formulario_activar_oferta(id_('id_oferta_fba').value,nopcion,1,id_('tipo_oferta_fba').value,motorclub,dreamcars,hcc);
		guardar_empresa(false);
	}


	function guardar_empresa(show_message)
	{
		var motorclub = 0;
		var dreamcars = 0;
		var hcc = 0;
		var periodo_automatico=0;
		if (id_('motorclub').checked) motorclub = 1;
		if (id_('dreamcars').checked) dreamcars = 1;
		if (id_('hcc').checked) hcc = 1;
		if (id_('cperiodo_automatico').checked) periodo_automatico=1;
		
		enviar_formulario_guardar_empresa(id_('id_oferta_fba').value,motorclub,dreamcars,hcc,periodo_automatico,show_message);   
	}
</script>
