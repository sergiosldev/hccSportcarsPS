<div id="desactivar_oferta" style="display:none;float:left;width:100%;" >
    <div id='form_desactivar_oferta_ca' style='text-align:left;padding:10px; background:#fff;'>
    <fieldset>
    <legend>Desactivar Oferta </legend>
    <div id="msg_error_desact_ca"  style="font-size:18px;color:red;"></div>  
    <FORM ACTION="javascript:;" onsubmit="envia_formulario_desactivar_oferta(id_('id_oferta_fbdo_ca').value,id_('password').value,id_('tipo_oferta_fbdo_ca').value)" METHOD="POST" id="frm_desactivar_oferta_ca" name="frm_desactivar_oferta_ca">
          <table > 
            <tr><td colspan="2" class="cabecera" align="left">Introduzca la contraseña:</td></tr>
            <tr>
                <td><br><span class="label_">Contraseña</span><span style="color:#f00"></span></td>
                <td><br><INPUT TYPE="password" NAME="password" id="password"></td>
                <td  align="right" style="vertical-align:bottom;"><INPUT id="boton_desactivar" name="boton_desactivar" TYPE="submit" class="boto" value="Aceptar" > </td>
            </tr>
           </table>
           <input type="hidden" id="id_oferta_fbdo_ca" name="id_oferta_fbdo">
           <input type="hidden" id="tipo_oferta_fbdo_ca" name="tipo_oferta_fbdo">
    </FORM> 
    </fieldset> 
    </div>
</div>
