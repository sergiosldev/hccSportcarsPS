<div id="borrar_oferta" style="display:none;float:left;width:100%;" >
    <div id='form_borrar_oferta_ca' style='text-align:left;padding:10px; background:#fff;'>
    <fieldset>
    <legend>Eliminar Oferta </legend>
    <div id="msg_error"></div>  
    <FORM ACTION="javascript:;" onsubmit="envia_formulario_borrar_oferta(id_('id_oferta_fbo_ca').value,id_('password').value,id_('creadas_fbo_ca').value,id_('tipo_password_fbo_ca').value)" METHOD="POST" id="frm_borrar_oferta_ca" name="frm_borrar_oferta_ca">
          <table >
            <tr><td colspan="2" class="cabecera" align="left">Introduzca la contraseña:</td></tr>
            <tr>
                <td><br><span class="label_">Contraseña</span><span style="color:#f00"></span></td>
                <td><br><INPUT TYPE="password" NAME="password" id="password"></td>
                <td  align="right" style="vertical-align:bottom;"><INPUT id="boton_eliminar" name="boton_eliminar" TYPE="submit" class="boto" value="Aceptar" > </td>
            </tr>
           </table>
           <input type="hidden" id="id_oferta_fbo_ca" name="id_oferta_fbo_ca">
           <input type="hidden" id="creadas_fbo_ca" name="creadas_fbo_ca">
           <input type="hidden" id="tipo_password_fbo_ca" name="tipo_password_fbo_ca">
    </FORM> 
    </fieldset>
    </div>
</div>
