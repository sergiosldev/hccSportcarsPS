<div id="borrar_cliente_baja" style="display:none;float:left;width:100%;" >
    <div id='form_borrar_baja_clientes' style='text-align:left;padding:10px; background:#fff;'>
    <fieldset>
    <legend>Eliminar Oferta </legend>
    <div id="msg_error"></div>  
    <FORM ACTION="javascript:;" onsubmit="envia_formulario_borrar_cliente_baja(id_('email_ba').value,id_('password_ba').value)" METHOD="POST" id="frm_borrar_baja_clientes" name="frm_borrar_baja_clientes">
          <table >
            <tr><td colspan="2" class="cabecera" align="left">Introduzca la contraseña:</td></tr>
            <tr>
                <td><br><span class="label_">Contraseña</span><span style="color:#f00"></span></td>
                <td><br><INPUT TYPE="password" NAME="password" id="password_ba"></td>
                <td  align="right" style="vertical-align:bottom;"><INPUT id="boton_eliminar_baja" name="boton_eliminar_baja" TYPE="submit" class="boto" value="Aceptar" > </td>
            </tr>
           </table>
           <input type="hidden" id="email_ba" name="email_ba">
    </FORM> 
    </fieldset>
    </div>
</div>
