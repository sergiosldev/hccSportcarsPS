	
	<div id="alta" style="display:none;float:left;width:100%;" >
	<div id='form_' style='text-align:left;padding:10px; background:#fff;'>
	<fieldset>
    <legend>Altas / Modificaciones <a href="javascript:ocultar_form()" >X</a></legend>
	<div id="msg_error"></div>	
	<FORM ACTION="javascript:;" onsubmit="envia_formulari()" METHOD="POST" id="form_alta" name="form_alta">
    <table><tr><td align="left" valign="top">
		  <table >
		    <tr><td colspan="2" class="cabecera" align="left">Datos piloto</td></tr>
		   <tr>
		    <td><br><span class="label_">Piloto</span><span style="color:#f00"></span></td>
		    <td><br><INPUT TYPE="text" NAME="pilot" id="pilot"></td>
		   </tr>
		   <tr>
		    <td><span class="label_">Email</span><span style="color:#f00"></span></td>
		    <td><INPUT TYPE="text" NAME="email" id="email"></td>
		    </tr>
		    <tr>
			<td valign="top"><span class="label_">Teléfono</span><span style="color:#f00"></span></td>
			<td ><INPUT TYPE="text" NAME="telefon" id="telefon">
			
		   <INPUT TYPE="hidden" id="edicio" NAME="edicio" value="false" >
		   <INPUT TYPE="hidden" id="id_alta" NAME="id_alta" >
		   <INPUT TYPE="hidden" id="tipus" NAME="tipus" value='' >
		   <INPUT TYPE="hidden" id="id_inscrit" NAME="id_inscrit" >
		   <INPUT TYPE="hidden" id="ciudad" NAME="ciudad" value='' >
		   </td>
		   </tr>
		   <tr>
		    <td><span class="label_">Email confirmacion</span><span style="color:#f00"></span></td>
		    <td><INPUT TYPE="text" NAME="email1" id="email1"></td>
		    </tr>
		   <!--<tr>
		    <td>Tipus event</td>	
		   <td><select name="tipus">
		   	  <option value="porsche">porsche</option>
			  <option value="ferrari">ferrari</option>
		   </select></td>	
		   </tr> -->
		  
		   </table>
	   </td>
	   <td align="left" valign="top">
		   
		   <table style="display:inline">
		   <tr><td colspan="2" align="left" class="cabecera" >Datos persona que regala</td></tr>
		   <tr>
		    <td><br><span class="label_">Nombre</span></td>
		    <td><br><INPUT TYPE="text" NAME="persona_regala" id="persona_regala"></td>
		   </tr>
		   <tr>
		    <td><span class="label_">Email</span></td>
		    <td><INPUT TYPE="text" NAME="email_regala" id="email_regala"></td>
		    </tr>
		    <tr>
			<td><span class="label_">Teléfono</span></td>
			<td><INPUT TYPE="text" NAME="telefon_regala" id="telefon_regala"></td>
		   </tr>
		  
		   <tr>	
		   <td colspan="2" align="right"><INPUT TYPE="submit" class="boto" value="Guardar" > <INPUT TYPE="Reset" class="boto" value="Limpia"> </td>
		   </tr>
		   
		   </table>
	   </td></tr></table>
	   <table width="100%">
	   	    <tr id="tipus_field">
	   	      <td colspan="2">
	   	      	<fieldset style="width:150px">
    <legend>Tipo evento</legend>
	
	<table width="100%" border="0" style="display:inline">
    <!--
	<tr>
        <td align="center" style="background:#ffcc77;">
	
	<span class="label_g" style="color:#000">Porsche </span><input id="rporsche" type="radio" name="tipus_ev" value="porsche" checked="checked"  style="margin-right:10px"  onchange="canvia_tipus_2('porsche996')">
	
	<span class="label_g">porsche997 </span><input id="rporsche" type="radio" name="tipus_ev" value="porsche" style="margin-right:10px" onchange="canvia_tipus_2('porsche997')">
	
	   </td>
    </tr> -->
    <tr>
      <td  style="background:#ff0000;">
        <input type="radio" id="rpp" name="tipus_ev" value="lotus" style="margin-right:10px"  onchange="canvia_tipus_2('porsche997_porsche996')">
        <span class="label_g" style="color:#fff" > Porsche996 + Porsche997 </span>
	</td>
    </tr>
</table>
<table width="300" border="0" style="display:inline">
    <tr>
        <td  style="background:#ffcc77;">
	<input type="radio" id="rpp" name="tipus_ev" value="lotus" style="margin-right:10px"  onchange="canvia_tipus_2('ferrari')">
    <span class="label_g" style="color:#000">Ferrari </span>
  </td>
    </tr>
    <tr>
      <td  style="background:#ff0000;">	
	<input type="radio" id="rpp" name="tipus_ev" value="lotus" style="margin-right:10px"  onchange="canvia_tipus_2('ferrari_porsche901')">
    <span class="label_g" style="color:#fff"> Ferrari + Porsche911 </span>
  </td>
    </tr>
</table>
<table width="300" border="0" style="display:inline">
    <tr>
      <td  style="background:#ffcc77;">
	   <input type="radio" id="rpp" name="tipus_ev" value="_porsche_" style="margin-right:10px"  onchange="canvia_tipus_2('_porsche_')">
       <span class="label_g" style="color:#000">Porsche </span>
     </td>
    </tr>
    <tr>
      <td  style="background:#ffcc77;">
	    <input type="radio" id="rpp" name="tipus_ev" value="_lotus_" style="margin-right:10px"  onchange="canvia_tipus_2('_lotus_')">
        <span class="label_g" style="color:#000">Lotus </span>
      </td>
    </tr>
   
</table>


<table width="300" border="0" style="display:inline">
    <tr>
      <td  style="background:#ffcc77;">
	   <input type="radio" id="rpp" name="tipus_ev" value="lotus" style="margin-right:10px"  onchange="canvia_tipus_2('lamborghini')">
       <span class="label_g" style="color:#000">Lamborghini </span>
	  </td>
    </tr>
    <tr>
      <td  style="background:#ff0000;">
	   <input type="radio" id="rpp" name="tipus_ev" value="lotus" style="margin-right:10px"  onchange="canvia_tipus_2('lamborghini_lotus')">
       <span class="label_g" style="color:#fff"> Lamborghini + Lotus </span>
	  </td>
    </tr>
</table>
  </fieldset>	
				
	   	      </td>	
		    </tr> 
	   	    <tr>
		    <td colspan="1"><span class="label_">Origen</span></td>
		    <td colspan="1"><INPUT TYPE="text" NAME="origen" id="origen"></td>
		    </tr>
			<tr>
		    <td colspan="1"><span class="label_">Código Localizador</span><span style="color:#f00"></span></td>
		    <td colspan="1"><INPUT TYPE="text" NAME="codigo_localizador" id="codigo_localizador"></td>
		    </tr>
		    <tr>
			<td colspan="1"><span class="label_">Código Consumo</span><span style="color:#f00"></span></td>
			<td colspan="1"><INPUT TYPE="text" NAME="codigo_consumo" id="codigo_consumo"></td>
		   </tr>
		    <tr>
			<td colspan="1" valign="top"><span class="label_"><br>Observaciones</span><span style="color:#f00"></span></td>
			<td colspan="1"><br><textarea rows="3" cols="50" NAME="Observaciones" id="Observaciones" ></textarea></td>
		   </tr>
	   </table><br>
	   <span class="label_">Campos obligatorios</span><span style="color:#f00">*</span>
	</FORM> 
	</fieldset>
	</div>
	</div>
