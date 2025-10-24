<div id="seleccion_tipo" style="display:none;">
<fieldset style="display:none;">
  <a id="ciudad_barcelona" name="ciudad_c" class="boton_menu menu_activo" href="javascript:canvia_ciudad_sel('')">Barcelona</a> 
  <a id="ciudad_madrid" name="ciudad_c" class="boton_menu" href="javascript:canvia_ciudad_sel('madrid')">Madrid</a> 
  <a id="ciudad_valencia" name="ciudad_c" class="boton_menu" href="javascript:canvia_ciudad_sel('valencia')">Valencia</a> 
  <a id="ciudad_andalucia" name="ciudad_c" class="boton_menu" href="javascript:canvia_ciudad_sel('andalucia')">Andalucía</a> 
  <a id="ciudad_cantabria" name="ciudad_c" class="boton_menu" href="javascript:canvia_ciudad_sel('cantabria')">Cantabria</a> 
  </fieldset>
<fieldset>
  <legend>Tipo evento</legend>	
	<a id="ferrari"  style="margin-right:10px;" class="boton_menu_tipo menu_activo boton_mediano" href="javascript:actualizar_calendario_sel('ferrari')">Ferrari 20km</a>
	<a id="_bferrari_" style="margin-right:10px;"  class="boton_menu_tipo boton_mediano" href="javascript:actualizar_calendario_sel('_bferrari_')">Ferrari 7km</a>
	<a id="lamborghini" style="margin-right:10px;"  class="boton_menu_tipo boton_grande"  href="javascript:actualizar_calendario_sel('lamborghini')">Lamborghini 20km</a>
	<a id="_blamborghini_" style="margin-right:10;"  class="boton_menu_tipo boton_grande"  href="javascript:actualizar_calendario_sel('_blamborghini_')">Lamborghini 7km</a>
	<a id="_porsche_"  style="margin-right:10px;"  class="boton_menu_tipo boton_mediano"  href="javascript:actualizar_calendario_sel('_porsche_')">Porsche 20km</a>
	<a id="_bporsche_" style="margin-right:10px;"  class="boton_menu_tipo boton_mediano"  href="javascript:actualizar_calendario_sel('_bporsche_')">Porsche 7km</a>
    <a id="_buggy_"  style="margin-right:10px;"  class="boton_menu_tipo boton_small"  href="javascript:actualizar_calendario_sel('_buggy_')">BUGGY</a>
<!--	<a id="_lotus_"  style="margin-right:10px;"  class="boton_menu_tipo boton_small"  href="javascript:canvia_tipus_sel('_lotus_')">Lotus</a> -->
</fieldset>		     	  
</div>


<script>
	function actualizar_calendario_sel(tipo)
	{
	//alert(id_('tipo_origen').value.substring(1,6).toUpperCase());
	if (tipo!=id_('tipo_origen').value) 
	{
		var ruta_tipo_origen_bautizo = (id_('tipo_origen').value.substring(0,2)=='_b' && id_('tipo_origen').value.substring(1,6).toUpperCase()!='BUGGY');
		var ruta_tipo_selec_bautizo = (tipo.substring(0,2)=='_b' && tipo.substring(1,6).toUpperCase()!='BUGGY');
	//alert(id_('tipo_origen').value.substring(0,2));
		if (ruta_tipo_origen_bautizo && !ruta_tipo_selec_bautizo || !ruta_tipo_origen_bautizo && ruta_tipo_selec_bautizo)
			if (!confirm('Atención!!! La ruta original era '+(ruta_tipo_origen_bautizo?' de 7 km':' de 20 km')+', mientras que la ruta seleccionada es '+(ruta_tipo_selec_bautizo?' de 7km':' de 20 km')+'. Está seguro de que desea continuar?')) return;
	}
	canvia_tipus_sel(tipo); 
	id_('calendari_sel').innerHTML = crida_sel(v_mes_sel, v_ano_sel,id_('ciudad_origen').value,tipo);
	/*id_('seleccion_tipo').style.height='0';
	id_('seleccion_tipo').style.visibility='hidden';*/
	id_('seleccion_tipo').style.display='none';

	$.colorbox({width:'80%',height:'350px', inline:true, href:'#form_reubicar',open:true});	     
	}
</script>
<!--style>
.boton_small_reubic
{
	font-size:12px;
    height:30px;
    width:50px;
}
.boton_mediano_reubic
{
	font-size:12px;    
	height:30px;
    width:70px;
}
.boton_grande_reubic
{
	font-size:11px;
    height:30px;
    width:100px;
}   
</style-->
