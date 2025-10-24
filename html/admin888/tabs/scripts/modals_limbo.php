
<div style='display:none;float:left;width:100%;height:100%;'>
  <div id="buscar_contact_limbo" style='text-align:left;padding:10px; background:#fff;'>
	<fieldset>
	<legend id='titulo_formulario'></legend>
   <div id="msg_error"></div>  
   <FORM ACTION="javascript:;"  METHOD="GET" onsubmit="enviar_buscar_limbo()" id="form_buscar_limbo" name="form_buscar_limbo"> 
    <table width="400px" >
		   <tr>    
		    <td><span class="label_">Email</span><span style="color:#f00"></span></td>
		    <td><INPUT TYPE="text" NAME="emailb" id="emailb">
			
			<INPUT TYPE="hidden" NAME="buscapilotos" id="buscapilotos">
			</td>
		    </tr>
			<tr>
		    <td><span class="label_">Nombre</span><span style="color:#f00"></span></td>
		    <td><INPUT TYPE="text" NAME="nombreb" id="nombreb">
			</td>
		    </tr>
			<!--<tr>
		    <td><span class="label_">Nombre persona regala</span><span style="color:#f00"></span></td>
		    <td><INPUT TYPE="text" NAME="nombreregalab" id="nombreregalab">
			</td>
		    </tr>-->
			<tr>
		    <td><span class="label_">Telefono</span><span style="color:#f00"></span></td>
		    <td><INPUT TYPE="text" NAME="telefonob" id="telefonob">
			</td>
		    </tr>
			
			<tr>
		    <td><span class="label_">Ciudad</span><span style="color:#f00"></span></td>
		    <td>
		    <select name="ciudadb" id="ciudadb">
             <option value="*">Todas</option>
             <option value="">Barcelona</option>
             <option value="valencia">Valencia</option>
             <option value="madrid">Madrid</option>
             <option value="andalucia">Andaluc&iacute;a</option>
             <option value="cantabria">Cantabria</option>
             <option value="rutas_turisticas">Rutas tur&iacute;sticas</option>
            </select> 	
				
			</td>
		    </tr>
			
			
			<tr>
		    <td><span class="label_">CODIGO</span><span style="color:#f00"></span></td>
		    <td><INPUT TYPE="text" NAME="codigob" id="codigob">
			</td>
		    </tr>
			<tr>
		    <td><span class="label_">DIA</span><span style="color:#f00"></span></td>
		    <td><INPUT TYPE="text" NAME="diab" id="diab">
			</td>
		    </tr>
			<tr>
		    <td><span class="label_">TIPO</span><span style="color:#f00"></span></td>
		    <td><INPUT TYPE="text" NAME="tipob" id="tipob">
			</td>
		    </tr>
			<tr>
		    <td><br><INPUT TYPE="reset" style="border:1px solid #7766aa"  value="Limpia">
			</td>
		    <td><br><INPUT TYPE="submit" style="border:1px solid #7766aa" value="Busca">
			</td>
		    </tr>
     </table>             
	</FORM>

 </div> 
 </fieldset>
</div> 
	