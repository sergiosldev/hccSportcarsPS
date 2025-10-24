   <table>
		<tr><td colspan="2" class="cabecera" align="left">Datos de la Opci&oacute;n</td></tr>     
		<tr>
		<td><br><span class="label_">Título</span><span style="color:#f00">*</span></td> 
		<td><br><textarea  NAME="titulo_opcion<?php echo($nopcion);?>" id="titulo_opcion<?php echo($nopcion);?>" class="input" style="width:98.5%;resize:none;"  rows="3" value=""></textarea></td>  
	   </tr>
	
	   <tr><td colspan="2" height="10px;"></td></tr>
	
	   <tr>
		<td><span class="label_">Subtítulo</span><span style="color:#f00"></span></td>
		<td><textarea NAME="subtitulo_opcion<?php echo($nopcion);?>" id="subtitulo_opcion<?php echo($nopcion);?>" class="input"  style="width:98.5%;resize:none;" rows="3" value=""></textarea></td>
	   </tr>
	
	   <tr><td colspan="2" height="10px;"></td></tr>
	
	   <tr>
		<td><span class="label_">Id Interno Opci&oacute;n</span><span style="color:#f00" >*</span></td>
		<td><INPUT TYPE="text" NAME="idinterno_opcion<?php echo($nopcion);?>" id="idinterno_opcion<?php echo($nopcion);?>" class="input" style="width:98.5%;" value=""></td>
	   </tr>
	
	   <tr><td colspan="2" height="10px;"></td></tr>
	
	
	   <tr>
		<td><span class="label_">Destacados</span><span style="color:#f00" ></span></td>
		<td>
		<div class="lang_3" style="display:block;float: left;">                        
			<textarea type="text"  style="width:600px;height:500px;" wrap="hard" class="rte"  id="destacados_opcion<?php echo($nopcion);?>" name="destacados_opcion<?php echo($nopcion);?>"></textarea>
		</div>
		<!-- rows="10" cols="80" -->
		</td>
	   </tr>
	
	   <tr><td colspan="2" height="10px;"></td></tr>
	
	   <tr>
		<td><span class="label_">Condiciones</span><span style="color:#f00" ></span></td>
		<td>
		<div class="lang_3" style="display:block;float: left;">                        
			<textarea   style="width:600px;height:500px;" wrap="hard" class="rte" rows="10" cols="80" id="condiciones_opcion<?php echo($nopcion);?>" name="condiciones_opcion<?php echo($nopcion);?>"></textarea>
		</div>
		</td>
	   </tr>
	
	   <tr><td colspan="2" height="10px;"></td></tr>
	
	   <tr>
		<td><span class="label_">Descripción</span><span style="color:#f00" ></span></td>
		<td>
		<div class="lang_3" style="display:block;float: left;">                        
			<textarea   style="width:600px;height:800px;" wrap="hard" class="rte" rows="10" cols="80" id="descripcion_opcion<?php echo($nopcion);?>" name="descripcion_opcion<?php echo($nopcion);?>"></textarea>
		</div>
		</td>
	   </tr>
	
	   <tr><td colspan="2" height="10px;"></td></tr>
	
	   <tr>
		<td><span class="label_">Precio Valor</span><span style="color:#f00" >*</span></td>
		<td><INPUT TYPE="text" NAME="precio_valor_opcion<?php echo($nopcion);?>" id="precio_valor_opcion<?php echo($nopcion);?>" class="input" value=""></td>
	   </tr>
	
	   <tr><td colspan="2" height="10px;"></td></tr>
	
	   <tr>
		<td><span class="label_">Descuento (%)</span><span style="color:#f00" >*</span></td>
		<td><INPUT TYPE="text" NAME="descuento_opcion<?php echo($nopcion);?>" id="descuento_opcion<?php echo($nopcion);?>" class="input" value=""></td>
	   </tr>
	
	   <tr><td colspan="2" height="10px;"></td></tr>
	
	   <tr>
		<td><span class="label_">Ahorro</span><span style="color:#f00" >*</span></td>
		<td><INPUT TYPE="text" NAME="ahorro_opcion<?php echo($nopcion);?>" id="ahorro_opcion<?php echo($nopcion);?>" class="input" value=""></td>  
	   </tr>
	
	   <tr><td colspan="2" height="10px;"></td></tr>
	
	   <tr>
		<td><span class="label_">Precio Final</span><span style="color:#f00" >*</span></td>
		<td><INPUT TYPE="text" NAME="precio_final_opcion<?php echo($nopcion);?>" id="precio_final_opcion<?php echo($nopcion);?>" class="input" value=""></td>
	   </tr>
	
	   <tr><td colspan="2" height="10px;"></td></tr>
	
		<tr>
		<td >
		   <INPUT TYPE="hidden" id="idopcion<?php echo($nopcion);?>" NAME="idopcion<?php echo($nopcion);?>" value="<?php echo($id_opcion);?>" >
		</td>
		<?php if ($id_opcion!='') $style = 'display:block'; else $style='display:none'; ?>  
		<td aligh="left" style="padding-bottom:10px;"><INPUT id="boton_vista_previa<?php echo($nopcion);?>" style="<?php echo($style);?>;visibility:visible;" TYPE="button" class="boto" value="Vista Previa Cupón" onclick="ver_vista_previa_cupon('<?php echo($id_opcion);?>');" ></td>
		
	   </tr>
   </table>
