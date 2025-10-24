<div style='display:none'> 
  <div id='buscar_contact' style='text-align:left;padding:10px; background:#fff;'>
   <FORM ACTION="<?php echo $base_scripts ?>buscar_pilotos.php"  METHOD="GET" id="form_buscar" name="form_buscar" target="_blank">
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
		    <td><span class="label_">CÓDIGOS</span><span style="color:#f00"></span></td>
		    <!--<td><INPUT TYPE="text" NAME="codigob" id="codigob">-->
			<td>
			<TEXTAREA name="codigob" id="codigob" style="height:80px;width:630px;"></TEXTAREA>
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
		    <td><br><INPUT TYPE="submit" style="border:1px solid #7766aa"  value="Busca">
			</td>
		    </tr>
    </table >

	</FORM>
 </div> 
</div> 
<link rel="stylesheet" type="text/css" href="<?php echo $base_tabs ?>/dhtmlx/dhtmlxToolbar/codebase/skins/dhtmlxtoolbar_dhx_skyblue.css">
<link rel="stylesheet" type="text/css" href="<?php echo $base_tabs ?>/dhtmlx/dhtmlxEditor/codebase/skins/dhtmlxeditor_dhx_skyblue.css">
<script src="<?php echo $base_tabs ?>/dhtmlx/dhtmlxEditor/codebase/dhtmlxcommon.js" type="text/javascript"></script>
<script src="<?php echo $base_tabs ?>/dhtmlx/dhtmlxEditor/codebase/dhtmlxeditor.js" type="text/javascript"></script>
<script src="<?php echo $base_tabs ?>/dhtmlx/dhtmlxEditor/codebase/ext/dhtmlxeditor_ext.js"></script>
<script src="<?php echo $base_tabs ?>/dhtmlx/dhtmlxToolbar/codebase/dhtmlxtoolbar.js"></script>

	<!-- This contains the hidden content for inline calls 
	<div  id="ff">
		<div id='inline_example1' style='text-align:left;padding:10px; background:#fff;'>
		<p><strong>Enviar email.</strong></p>
		<p><strong>Mensage</strong></p>
		<p id="ed_">
		  <textarea id="mail_m" rows="4" cols="60">
           </textarea>

	   </p>
		<p>
		   <button type="button" style="width:100px" onclick="envia_email_massiu()">Envia</button>
        </p>
		</div>
	</div>
	-->
	

     	
<script>

function abrir_cerrar(ac)
  {
  if (ac == 1) {
  	document.getElementById('caixa_editor').style.display = 'block';
	editor.setContent('')
	window.location="#caixa_editor"
  }
  else 
  	if (ac == 0){ 
  	document.getElementById('caixa_editor').style.display = 'none'	
    editor.setContent('')
   }
  }

var editor;

function doOnLoad() {
	dhtmlx.image_path = "tabs/dhtmlx/dhtmlxEditor/codebase/imgs/";
    editor = new dhtmlXEditor("editorObj");
}
doOnLoad()

function oculta()
  {
  	document.getElementById('caixa_editor').style.display='none'
  }
//setTimeout('oculta()',800)
oculta()
</script>	
	
	