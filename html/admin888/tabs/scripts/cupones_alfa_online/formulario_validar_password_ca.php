<div id="validar_password" style="display:none;float:left;width:100%;" >
    <div id='form_validar_password_ca' style='text-align:left;padding:10px; background:#fff;'>
    <fieldset>
    <legend id="titulo"></legend>
    <div id="msg_error"></div>  
    <FORM ACTION="javascript:;" onsubmit="envia_formulario_validar_password (id_('archivo_operacion_ca').value,id_('archivo_retorno_ca').value,id_('datos_ca').value,id_('div_retorno_ca').value,id_('ancho_div_retorno_ca').value,id_('password').value)" METHOD="POST" id="frm_validar_password_ca" name="frm_validar_password_ca">
          <table >
            <tr><td colspan="2" class="cabecera" align="left">Introduzca la contraseña:</td></tr>
            <tr>
                <td><br><span class="label_">Contraseña</span><span style="color:#f00"></span></td>
                <td><br><INPUT TYPE="password" NAME="password" id="password"></td>
                <td  align="right" style="vertical-align:bottom;">
                    <INPUT id="boton_aceptar" name="boton_aceptar" TYPE="submit" class="boto" value="Aceptar" > 
                </td>
                <input type="hidden" id="archivo_operacion_ca" name="archivo_retorno_ca">
                <input type="hidden" id="archivo_retorno_ca" name="archivo_retorno_ca">
                <input type="hidden" id="datos_ca" name="datos_ca">
                <input type="hidden" id ="div_retorno_ca" id="div_retorno_ca">
                <input type="hidden" id="ancho_div_retorno_ca" name="ancho_div_retorno_ca">
            </tr>
           </table>
    </FORM> 
    </fieldset>
    </div>
</div>
