   <table>
		<!-- <tr><td colspan="2" class="cabecera" align="left">Datos de la Oferta</td></tr>  -->     
		<tr>
		<td><br><span class="label_">Título</span><span style="color:#f00">*</span></td>
		<td><br><textarea  NAME="titulo" id="titulo" class="input" style="width:98.5%;resize:none;"  rows="3" value=""></textarea></td>
	   </tr>
	
	   <tr><td colspan="2" height="10px;"></td></tr>
	
	   <tr>
		<td><span class="label_">Subtítulo</span><span style="color:#f00"></span></td>
		<td><textarea NAME="subtitulo" id="subtitulo" class="input"  style="width:98.5%;resize:none;" rows="3" value=""></textarea></td>
	   </tr>
	
	   <tr><td colspan="2" height="10px;"></td></tr>
	
	   <tr>
		<td><span class="label_">Id Interno</span><span style="color:#f00" >*</span></td>
		<td><INPUT TYPE="text" NAME="idinterno" id="idinterno" class="input" style="width:98.5%;" value=""></td>
	   </tr>
	
	   <tr><td colspan="2" height="10px;"></td></tr>
	
	   <tr>
		<td><span class="label_">Texto opci&oacute;n de pago</span></td>
		<td><INPUT TYPE="text" NAME="idinterno_opcion" id="idinterno_opcion" class="input" style="width:98.5%;" value=""></td>
	   </tr>
	
	   <tr><td colspan="2" height="10px;"></td></tr>

	   <tr>
		<td><span class="label_">Tipo de Servicio</span><span style="color:#f00" >*</span></td>
		<td>
			<select name="tipo_servicio" id="tipo_servicio">
				<?php
		$s=getTiposServicio();
		//var_dump($s);
		foreach($s as $r)
		echo('<option value="'.$r['id'].'">'.$r['desc'].'</option>');
		?>
			</select>
		</td>
	   </tr>
	
	   <tr><td colspan="2" height="10px;"></td></tr>
	   <tr>
		<td><span class="label_">Destacados</span><span style="color:#f00" ></span></td>
		<td>
		<div class="lang_3" style="display:block;float: left;">                        
			<textarea type="text"  style="width:600px;height:500px;" wrap="hard" class="rte"  id="destacados" name="destacados"></textarea>
		</div>
		<!-- rows="10" cols="80" -->
		</td>
	   </tr>
	
	   <tr><td colspan="2" height="10px;"></td></tr>
	
	   <tr>
		<td><span class="label_">Condiciones</span><span style="color:#f00" ></span></td>
		<td>
		<div class="lang_3" style="display:block;float: left;">                        
			<textarea   style="width:600px;height:500px;" wrap="hard" class="rte" rows="10" cols="80" id="condiciones" name="condiciones"></textarea>
		</div>
		</td>
	   </tr>
	
	   <tr><td colspan="2" height="10px;"></td></tr>
	
	   <tr>
		<td><span class="label_">Descripción</span><span style="color:#f00" ></span></td>
		<td>
		<div class="lang_3" style="display:block;float: left;">                        
			<textarea   style="width:600px;height:800px;" wrap="hard" class="rte" rows="10" cols="80" id="descripcion" name="descripcion"></textarea>
		</div>
		</td>
	   </tr>
	   <tr><td colspan="2" height="10px;"></td></tr>
	<!--                               <tr>
	   <td style="padding-left:110px;height:50px;" colspan="2"><input type="button" style="width:50px;padding:2px;background-color:#787878;border:1px solid #000000;color:#FFFFFF;" onclick="tinyMCE.get('descripcion_cupones').setContent(stripHTML(tinyMCE.get('descripcion').getContent()));" value="Copiar descripción"></td>    
	   </tr>
	-->
	   <tr>
		<td><span class="label_">Descripción <br>Cupones</span><span style="color:#f00" ></span></td>
		<td>
		<div class="lang_3" style="display:block;float: left;">                        
			<textarea  style="width:600px;height:500px;" wrap="hard" class="rte" rows="10" cols="80" id="descripcion_cupones" name="descripcion_cupones"></textarea>
		</div>
			</td>
	   </tr>
	   <tr><td colspan="2" height="10px;"></td></tr>
	   <tr>
		<td><span class="label_">Link Video</span></td>
		<td>
		<div class="lang_3" style="display:block;float: left;">                        
			<input style="width:590px;" type="text" id="link_video_oferta" name="link_video_oferta">
		</div>
		</td>
	   </tr>
	   <tr><td colspan="2" height="10px;"></td></tr>
	   <tr>
		<td><span class="label_">Link Video 2</span></td> 
		<td>
		<div class="lang_3" style="display:block;float: left;">                        
			<input style="width:590px;" type="text" id="link_video_oferta2" name="link_video_oferta2">
		</div>
		</td>
	   </tr>
	   <tr><td colspan="2" height="10px;"></td></tr>
	   <tr>
		<td><span class="label_">Link Video Dreamcars</span></td> 
		<td>
		<div class="lang_3" style="display:block;float: left;">                        
			<input style="width:590px;" type="text" id="link_video_oferta_dreamcars" name="link_video_oferta_dreamcars">
		</div>
		</td>
	   </tr>
	   <tr><td colspan="2" height="10px;"></td></tr>
	   <tr>
		<td><span class="label_">Link Video Dreamcars 2 </span></td> 
		<td>
		<div class="lang_3" style="display:block;float: left;">                        
			<input style="width:590px;" type="text" id="link_video_oferta_dreamcars2" name="link_video_oferta_dreamcars2">
		</div>
		</td>
	   </tr>
	   <tr><td colspan="2" height="10px;"></td></tr>
	   <tr>
		<td><span class="label_">Link Video Hcc</span></td> 
		<td>
		<div class="lang_3" style="display:block;float: left;">                        
			<input style="width:590px;" type="text" id="link_video_oferta_hcc" name="link_video_oferta_hcc">
		</div>
		</td>
	   </tr>
	   <tr><td colspan="2" height="10px;"></td></tr>
	   <tr>
		<td><span class="label_">Link Video Hcc 2</span></td> 
		<td>
		<div class="lang_3" style="display:block;float: left;">                        
			<input style="width:590px;" type="text" id="link_video_oferta_hcc2" name="link_video_oferta_hcc2">
		</div>
		</td>
	   </tr>
	   <tr>
		<td><br><br><span class="label_">Cantidad</span><span style="color:#f00" ></span><br><br></td>
		<td>
		<div class="lang_3" style="display:block;float: left;">                        
		<input type="hidden" id="multiple_cantidad" value="1"><br>
		<span  class="label_">Múltiple de 1: </span><INPUT id="multiple_uno" TYPE="RADIO" checked="checked" NAME="multiple_uno" VALUE="Múltiple de 1" onclick="id_('multiple_cantidad').value=1;id_('multiple_dos').checked=false;"> 
		&nbsp;&nbsp;&nbsp;&nbsp;
		<span  class="label_">Múltiple de 2:</span> <INPUT TYPE="RADIO" id="multiple_dos" NAME="multiple_dos" VALUE="Múltiple de 2" onclick="id_('multiple_cantidad').value=2;id_('multiple_uno').checked=false;">
		</div>
		<br><br></td>
	   </tr>
	
	
	   <tr><td colspan="2" height="10px;"></td></tr>
	
	   <tr>
		<td><span class="label_">Precio Valor</span><span style="color:#f00" >*</span></td>
		<td><INPUT TYPE="text" NAME="precio_valor" id="precio_valor" class="input" value=""></td>
	   </tr>
	
	   <tr><td colspan="2" height="10px;"></td></tr>
	
	   <tr>
		<td><span class="label_">Descuento (%)</span><span style="color:#f00" >*</span></td>
		<td><INPUT TYPE="text" NAME="descuento" id="descuento" class="input" value=""></td>
	   </tr>
	
	   <tr><td colspan="2" height="10px;"></td></tr>
	
	   <tr>
		<td><span class="label_">Ahorro</span><span style="color:#f00" >*</span></td>
		<td><INPUT TYPE="text" NAME="ahorro" id="ahorro" class="input" value=""></td>
	   </tr>
	
	   <tr><td colspan="2" height="10px;"></td></tr>
	
	   <tr>
		<td><span class="label_">Precio Final</span><span style="color:#f00" >*</span></td>
		<td><INPUT TYPE="text" NAME="precio_final" id="precio_final" class="input" value=""></td>
	   </tr>
	
	   <tr><td colspan="2" height="10px;"></td></tr>
	

	   <tr><td colspan="2" height="10px;"></td></tr>
	
	   <tr style="display:none;">
		<td><span class="label_">Fecha Inicio</span><span style="color:#f00" ></span></td>
		<td><INPUT TYPE="text" disabled NAME="fecha_inicio" id="fecha_inicio" class="input value=""></td>
	   </tr>
	
	   <tr><td colspan="2" height="10px;"></td></tr>
	
	   <tr style="display:none;">
		<td><span class="label_">Fecha Fin</span><span style="color:#f00" ></span></td>
		<td><INPUT TYPE="text" NAME="fecha_fin" id="fecha_fin" class="input" value=""></td>
	   </tr>
	   <tr>
		<td aligh="left" style="padding-bottom:10px;"><INPUT id="boton_vista_previa" style="visibility:hidden;" TYPE="button" class="boto" value="Vista Previa Cupón" onclick="ver_vista_previa_cupon(0);" ></td>	   
	   </tr>
	   <tr>
		<td >
		   <INPUT TYPE="hidden" id="edicio_oferta" NAME="edicio_oferta" value="" >
		   <INPUT TYPE="hidden" id="idoferta" NAME="idoferta" value="" >
		   <INPUT TYPE="hidden" id="oferta_activa" NAME="oferta_activa" value="" > 
		   <INPUT TYPE="hidden" id="cliente_especial" NAME="cliente_especial" value="" > 
	   </tr>
   </table>
