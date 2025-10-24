<div id="desbloquear_cupon" style="display:none;float:left;width:100%;" >
    <div id='form_desbloquear_cupon' style='text-align:left;padding:10px; background:#fff;'>
    <fieldset>
    <legend>Desbloquear Cupón </legend>
    <div id="msg_error"></div>  
    <FORM ACTION="javascript:;" onsubmit="envia_formulario_desbloquear_cupon(id_('id_establecimiento_fd').value,id_('id_talonario_fd').value,id_('num_talonario_fd').value,id_('ncupon_fd').value,id_('password').value)" METHOD="POST" id="frm_desbloquear_cupon" name="frm_desbloquear_cupon">
          <table >
            <tr><td colspan="2" class="cabecera" align="left">Introduzca la contraseña:</td></tr>
            <tr>
                <td><br><span class="label_">Contraseña</span><span style="color:#f00"></span></td>
                <td><br><INPUT TYPE="password" NAME="password" id="password"></td>
                <td  align="right" style="vertical-align:bottom;"><INPUT id="boton_desbloquear" name="boton_desbloquear" TYPE="submit" class="boto" value="Aceptar" > </td>
            </tr>
           </table>
           <input type="hidden" id="ncupon_fd" name="ncupon_fd">
           <input type="hidden" id="id_establecimiento_fd" name="id_establecimiento_fd">
           <input type="hidden" id="id_talonario_fd" name="id_talonario_fd">
           <input type="hidden" id="num_talonario_fd" name="num_talonario_fd">

    </FORM> 
    </fieldset>
    </div>
</div>
