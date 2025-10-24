<script type="text/javascript">
	function resultadoUpload(estado) 
	{
		if (estado==0)
		 {
		 lista_localizadores(1);
		 reset_formulario();
		 alert('Los localizadores se cargaron con éxito');
		 }
		 else 
		 {
		 id_('msg_error').innerHTML=estado;
		 }
	} 

  function reset_formulario()
  {
	id_('origenf').value='';
	form_carga_localizadores.origen_carga.selectedIndex=0;
	id_('archivo_carga').value='';
  }
</script>

<FORM  target="iframeUpload" action="tabs/scripts/ajax_archivo_localizadores.php<?php echo('?ale='.rand(0,50000));?>" METHOD="POST" id="form_carga_localizadores" name="form_carga_localizadores" enctype='multipart/form-data'>
   <div>
		<span>Origen:&nbsp;</span>
		<select id="origen_carga" name="origen_carga" style="margin-top: 7px; margin-left: 13px;border:1px solid #CCCCCC;width:100px;" onclick="if (typeof(this.selectedIndex) != 'undefined') actualizar_origen(this.options[this.selectedIndex].value);">
		   	  <option value="">--Elija opcion--</option>
			  <option value="LETSBONUS">LETS BONUS</option>
			  <option value="GROUPALIA">GROUPALIA</option>
			  <option value="GROUPON">GROUPON</option>
		</select>
		<input type="hidden" id="origenf" name="origenf" value="">
	   <br>	
	   <span>Seleccione el archivo con los localizadores:</span>		
	   <input class="input" type="file" id="archivo_carga" name="archivo_carga" />
       <INPUT TYPE="button" class="boto" value="Cargar datos" id="cargar_excel" onclick="if (validar_campos_form_automatica()) {javascript:submit();}"> 
       <INPUT TYPE="button" class="boto" value="Limpia" onclick="javascript:reset_formulario();"> </td>
	   
	   <div style="font-size:18px;color:red;" id="msg_error" >	   
	   <iframe name="iframeUpload" style="display:none;"></iframe>			
   </div>
</FORM>

<script>
	function validar_campos_form_automatica()
	{
		var error = '';
		if (id_('origenf').value == '') 
		{
			error = 'Debe seleccionar un origen';
		}
		else if (id_('archivo_carga').value == '') 
		{
			error = 'Debe seleccionar un archivo';
		}
		
		/*if (id_('origenf1').value=='OTROS')
			if (id_('otros').value == '') 
			{
				error='Debe introducir la descripción del origen en "otros"';
			}*/

		if (error!='') {alert(error);return false;}
		return true;
	}
	
	function actualizar_origen(origen)
	{
		id_('origenf').value=origen;
	/*	var aleatorio = '&v'+Math.floor(Math.random()*50000)+'=1';
		var datos = 'origen='+origen; 
		datos += '&id_tipo_ruta='+id_tipo_ruta;
		r=ajax.load('<?php echo $base_scripts ?>localizadores_ruta.php?'+datos+aleatorio);
		
		if (r.indexOf('#error')==-1)
			{
			id_('lista_localizadores').innerHTML = r;
			}
*/
	}
</script>