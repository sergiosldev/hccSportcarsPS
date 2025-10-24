<script type="text/javascript">

//Función complementara a validar cupón. Se ejecuta desde el formulario de contraseñas
//cuando tratamos de cancelar un cupón.
//el parámetro dia_sel sólo se utilizará en el botón para marcar eventos del apartado ("events").
function envia_formulario_validar_password_localizadores (archivo_operacion,archivo_retorno,datos,div_retorno,ancho_div_retorno,password)
  {
    if (password=='') {alert('Debe introducir la contraseña');return;}      
    var aleatorio='&gg'+(Math.floor(Math.random()*50000))+'=1';
    r=ajax.load('<?php echo $base_scripts ?>ajax_validar_password.php?password='+password+aleatorio);

    if (r.indexOf('error_password')!=-1) {alert('Contraseña incorrecta. Inténtelo de nuevo.'); id_('frm_validar_password_localizadores').reset();}
    else 
    {
        r=ajax.load('<?php echo $base_scripts ?>'+archivo_operacion+'?'+datos+aleatorio);


        ru = r.toUpperCase();     
        if (ru.indexOf('OK')==-1) {alert(r);}
        else  $.colorbox.close();

    }
    

 }

</script>


<div id="validar_password_localizadores" style="display:none;float:left;width:100%;" >
    <div id='form_validar_password_localizadores' style='text-align:left;padding:10px; background:#fff;'>
    <fieldset>
    <legend id="titulo"></legend>
    <div id="msg_error"></div>  
    <FORM ACTION="javascript:;" onsubmit="envia_formulario_validar_password_localizadores (id_('archivo_operacion').value,id_('archivo_retorno').value,id_('datos').value,id_('div_retorno').value,id_('ancho_div_retorno').value,id_('password').value)" METHOD="POST" id="frm_validar_password_localizadores" name="frm_validar_password_localizadores">
          <table >
            <tr><td colspan="2" class="cabecera" align="left">Introduzca la contraseña:</td></tr>
            <tr>
                <td><br><span class="label_">Contraseña</span><span style="color:#f00"></span></td>
                <td><br><INPUT TYPE="password" NAME="password" id="password"></td>
                <td  align="right" style="vertical-align:bottom;">
                    <INPUT id="boton_aceptar" name="boton_aceptar" TYPE="submit" class="boto" value="Aceptar" > 
                </td>
                <input type="hidden" id="archivo_operacion" name="archivo_retorno">
                <input type="hidden" id="archivo_retorno" name="archivo_retorno">
                <input type="hidden" id="datos" name="datos">
                <input type="hidden" id ="div_retorno" id="div_retorno">
                <input type="hidden" id="ancho_div_retorno" name="ancho_div_retorno">
            </tr>
           </table>
    </FORM> 
    </fieldset>
    </div>
</div>
