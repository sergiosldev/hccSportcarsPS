<div id="desbloquear_cupon_oferta" style="display:none;float:left;width:100%;" >
    <div id='form_desbloquear_cupon_oferta_ca' style='text-align:left;padding:10px; background:#fff;'>
    <fieldset>
    <legend>Desbloquear Cupón </legend>
    <div id="msg_error"></div>  
    <FORM ACTION="javascript:;" onsubmit="envia_formulario_desbloquear_cupon_oferta(id_('id_oferta_fd_ca').value,id_('ncupon_fd_ca').value,id_('password').value,id_('creadas_fd_ca').value,id_('id_distribuidor_ca').value)" METHOD="POST" id="frm_desbloquear_cupon_oferta_ca" name="frm_desbloquear_cupon_oferta_ca">
          <table >
            <tr><td colspan="2" class="cabecera" align="left">Introduzca la contraseña:</td></tr>
            <tr>
                <td><br><span class="label_">Contraseña</span><span style="color:#f00"></span></td>
                <td><br><INPUT TYPE="password" NAME="password" id="password"></td>
                <td  align="right" style="vertical-align:bottom;"><INPUT id="boton_desbloquear" name="boton_desbloquear" TYPE="submit" class="boto" value="Aceptar" > </td>
            </tr>
           </table>
           <input type="hidden" id="ncupon_fd_ca" name="ncupon_fd_ca">
           <input type="hidden" id="id_oferta_fd_ca" name="id_oferta_fd_ca">
           <input type="hidden" id="creadas_fd_ca" name="creadas_fd_ca">
           <input type="hidden" id="id_distribuidor_ca" name="id_distribuidor_ca">
    </FORM> 
    </fieldset>
    </div>
</div>
