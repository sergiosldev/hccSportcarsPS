<script type="text/javascript">
	var tipos_seleccionados=''; 
	var dias_seleccionados='';
	$('#ferrari').removeClass($('#ferrari').attr('class')).addClass('boton_menu_tipo boton_mediano');          
	$('#_bferrari_').removeClass($('#_bferrari_').attr('class')).addClass('boton_menu_tipo boton_mediano');          
	$('#lamborghini').removeClass($('#lamborghini').attr('class')).addClass('boton_menu_tipo boton_grande');          
	$('#_blamborghini_').removeClass($('#_blamborghini_').attr('class')).addClass('boton_menu_tipo boton_grande');          
	$('#_porsche_').removeClass($('#_porsche_').attr('class')).addClass('boton_menu_tipo boton_mediano');          
	$('#_bporsche_').removeClass($('#_bporsche_').attr('class')).addClass('boton_menu_tipo boton_mediano');          
	$('#_corvette_').removeClass($('#_corvette_').attr('class')).addClass('boton_menu_tipo boton_mediano');          
	$('#_bcorvette_').removeClass($('#_bcorvette_').attr('class')).addClass('boton_menu_tipo boton_mediano');          
	$('#_buggy_').removeClass($('#_buggy_').attr('class')).addClass('boton_menu_tipo boton_small');          	
</script>

<div id="seleccion_tipo_susp">
<fieldset style="display:none;">

  <a id="ciudad_barcelona" name="ciudad_c" class="boton_menu menu_activo" href="javascript:canvia_ciudad_sel_susp('')">Barcelona</a> 
  <a id="ciudad_madrid" name="ciudad_c" class="boton_menu" href="javascript:canvia_ciudad_sel_susp('madrid')">Madrid</a> 
  <a id="ciudad_valencia" name="ciudad_c" class="boton_menu" href="javascript:canvia_ciudad_sel_susp('valencia')">Valencia</a> 
  <a id="ciudad_andalucia" name="ciudad_c" class="boton_menu" href="javascript:canvia_ciudad_sel_susp('andalucia')">Andalucía</a> 
  <a id="ciudad_cantabria" name="ciudad_c" class="boton_menu" href="javascript:canvia_ciudad_sel_susp('cantabria')">Cantabria</a> 
</fieldset>
<fieldset>
  <legend>Tipo evento</legend>	
	<a id="susp_ferrari"  style="margin-right:10px;" class="boton_menu_tipo boton_mediano" href="javascript:actualizar_calendario_sel_susp('ferrari')">Ferrari 20km</a>
	<a id="susp__bferrari_" style="margin-right:10px;width:80px;"  class="boton_menu_tipo boton_mediano" href="javascript:actualizar_calendario_sel_susp('_bferrari_')">Ferrari 7km</a>
	<a id="susp_lamborghini" style="margin-right:10px;"  class="boton_menu_tipo boton_grande"  href="javascript:actualizar_calendario_sel_susp('lamborghini')">Lamborghini 20km</a>
	<a id="susp__blamborghini_" style="margin-right:10;width:116px;"  class="boton_menu_tipo boton_grande"  href="javascript:actualizar_calendario_sel_susp('_blamborghini_')">Lamborghini 7km</a>
	<a id="susp__porsche_"  style="margin-right:10px;"  class="boton_menu_tipo boton_mediano"  href="javascript:actualizar_calendario_sel_susp('_porsche_')">Porsche 20km</a>
	<a id="susp__bporsche_" style="margin-right:10px;"  class="boton_menu_tipo boton_mediano"  href="javascript:actualizar_calendario_sel_susp('_bporsche_')">Porsche 7km</a>
	<a id="susp__corvette_"  style="margin-right:10px;width:99px;"  class="boton_menu_tipo boton_mediano"  href="javascript:actualizar_calendario_sel_susp('_corvette_')">Corvette 20km</a>
	<a id="susp__bcorvette_" style="margin-right:10px;"  class="boton_menu_tipo boton_mediano"  href="javascript:actualizar_calendario_sel_susp('_bcorvette_')">Corvette 7km</a>
    <a id="susp__buggy_"  style="display:none;margin-right:10px;"  class="boton_menu_tipo boton_small"  href="javascript:actualizar_calendario_sel_susp('_buggy_')">BUGGY</a>
    <div style="float:left;width:33%;margin-top:30px;font-weight:bold;font-size:20px"><input type="button" id="boton_vehichulos" value="Suspender selecci&oacute;n" onclick="suspender_seleccion();"></div>
  	<div id="msg_error_susp"></div>  
</fieldset>		     	  
</div>


<script>
	function suspender_seleccion()
	{
		var i;
		var j;
		var res = confirm('Se van a suspender todos los eventos de esta fecha para la ciudad y vehiculo seleccionados. Esta seguro de que desea continuar?');
		var ale='&g='+Math.floor(Math.random()*50000);

		
		//alert(ciudad_aux_sel_susp);
		//return;
		
		if (res==true)
		{
			var adias_sel = new Array();           

			adias_sel = dias_seleccionados.split(',');
			atipos_sel = tipos_seleccionados.split(',');

			/*
			for (i=0;i<adias_sel.length;i++)
			{
				alert(adias_sel[i]);          
			}					
 
			for (j=0;j<atipos_sel.length;j++)
			{
				alert(atipos_sel[j]);
			}					

			return;
			*/
			for (i=0;i<adias_sel.length;i++)
			{
				for (j=0;j<atipos_sel.length;j++)
				{
					$('#msg_error_susp').html('Procesando fecha '+adias_sel[i]+', evento: '+atipos_sel[j]);           
					r = ajax.load('<?php echo $base_scripts ?>ajax.php?marca_dia=' + adias_sel[i] + '&ciudad='+ciudad_aux_sel_susp+'&tipus='+atipos_sel[j]+'&color=55'+ale);                          
					alert(r);    		
				}					
			}					
		}
		
	}
	

	function actualizar_calendario_sel_susp(tipo)
	{
		if (tipo!=id_('tipo_origen').value) 
		{ 
			//var ruta_tipo_origen_bautizo_susp = (id_('tipo_origen_susp').value.substring(0,2)=='_b' && id_('tipo_origen_susp').value.substring(1,6).toUpperCase()!='BUGGY');     
			//var ruta_tipo_selec_bautizo = (tipo.substring(0,2)=='_b' && tipo.substring(1,6).toUpperCase()!='BUGGY');    
			   var atipos_sel = new Array();
			   var itemtoRemove;
			   if (tipo == 'lamborghini' || tipo=='_blamborghini_')
			   { 
				   if ( $('#susp_'+tipo).attr('class') == "boton_menu_tipo boton_grande menu_activo")
				   {
					  atipos_sel = tipos_seleccionados.split(',');
					  itemtoRemove = tipo;     
				   	  $('#susp_'+tipo).removeClass($('#susp_'+tipo).attr('class')).addClass('boton_menu_tipo boton_grande');          
					  atipos_sel.splice($.inArray(itemtoRemove, atipos_sel),1); 
					  tipos_seleccionados = atipos_sel.join(',');       					   
				   }
				   else     
				   {
					  if (tipos_seleccionados=='') tipos_seleccionados=tipo;   	
					  else tipos_seleccionados = tipos_seleccionados+','+tipo;
					  atipos_sel = tipos_seleccionados.split(',');
					  $('#susp_'+tipo).removeClass($('#susp_'+tipo).attr('class')).addClass('boton_menu_tipo boton_grande menu_activo');          
				   }
			   } 
			   else 
			   {   
				   {
					   if ( $('#susp_'+tipo).attr('class') == "boton_menu_tipo boton_mediano menu_activo")
					   { 
						  atipos_sel = tipos_seleccionados.split(',');
						  itemtoRemove = tipo;     
					   	  $('#susp_'+tipo).removeClass($('#susp_'+tipo).attr('class')).addClass('boton_menu_tipo boton_mediano');
						  atipos_sel.splice($.inArray(itemtoRemove, atipos_sel),1); 
						  tipos_seleccionados = atipos_sel.join(',');       
					   }					   	  
					   else     
					   {
						  if (tipos_seleccionados=='') tipos_seleccionados=tipo;   	
						  else tipos_seleccionados = tipos_seleccionados+','+tipo;
						  atipos_sel = tipos_seleccionados.split(',');						    
						  $('#susp_'+tipo).removeClass($('#susp_'+tipo).attr('class')).addClass('boton_menu_tipo boton_mediano menu_activo');  
					   }
				   }
			   }  
				   
		}
		


	}
</script>
