 <script type="text/javascript">

function envia_formulario_tipo_limbo (id_ev,ciudad,tipo,limbo)
  {
	 
	  var ale='&gg'+(Math.floor(Math.random()*50000))+'=1';
      $('#msg_aviso').html('Espere mientras se crea el registro de limbo...');
	  r=ajax.load('<?php echo $base_scripts ?>ajax.php?enviar_limbo=1&limbo='+limbo+'&ciudad='+ciudad+'&id='+id_ev+'&tipo_limbo='+tipo+ale);
	  var ok=/OK/;
	  if (ok.test(r)) 
	  { // recarrega graella
		 
		  get_graella(dia_sel);		  
		 
		  $.colorbox.close();
	  }
 }

</script>


<div id="tipo_limbo" style="display:none;float:left;width:100%;" >
    <div id='form_tipo_limbo' style='text-align:left;padding:10px; background:#fff;'>
    <fieldset>
    <legend id="titulo"></legend>
    <div id="msg_error"></div>  
    <FORM ACTION="javascript:;" onsubmit="envia_formulario_tipo_limbo($('#idev_tl').val(),$('#ciudad_tl').val(),$('input[name=\'rtipo_limbo\']:checked').val(),$('#limbo_tl').val());" METHOD="POST" id="frm_tipo_limbo" name="frm_tipo_limbo">
          <table >
            <tr><td colspan="2" class="cabecera" align="left">Seleccione la acci&oacute;n realizada:</td></tr>
            <tr>
                <td><br /><span class="label_">Cancelaci&oacute;n sin fecha</span><span style="color:#f00"></span></td>
                <td><INPUT TYPE="radio" NAME="rtipo_limbo" id="cancelacion_sin_fecha" value="1" checked="checked"></td>   
            </tr>
            <tr style="height:20px;">    
                <td colspan="2">&nbsp;</td>
            </tr>            
            <tr>    
                <td><span class="label_">Suspensi&oacute;n</span><span style="color:#f00"></span></td>
                <td><INPUT TYPE="radio" NAME="rtipo_limbo" id="suspension" value="2"></td>
            </tr>
            </hr>
            <tr>       
                <td style="vertical-align:bottom;text-align:center;">
                <br/>
                    <INPUT id="boton_aceptar" name="boton_aceptar" TYPE="submit" class="boto" value="Aceptar" >       
                </td>
                <input type="hidden" id="idev_tl" name="idev_tl">
                <input type="hidden" id="ciudad_tl" name="ciudad_tl">
                <input type="hidden" id="limbo_tl" name="limbo_tl">
            </tr>
           </table>
    </FORM> 
    <br />
    <div id="msg_aviso" style="color:#ff0000;"></div>  
    </fieldset>
    </div>
</div>
