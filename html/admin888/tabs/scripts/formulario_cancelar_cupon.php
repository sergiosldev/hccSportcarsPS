<div id="cancelar_cupon" style="display:none;float:left;width:100%;" >
    <div id='form_cancelar_cupon' style='text-align:left;padding:10px; background:#fff;'>
    <fieldset>
    <legend>Cancelar un cupón</legend>
    <div id="msg_error"></div>  
    <FORM ACTION="javascript:;" onsubmit="envia_formulario_cancelar_cupon(id_('id_establecimiento_cc').value,id_('id_talonario_cc').value,id_('num_talonario_cc').value,id_('ncupon_cc').value,id_('password').value)" METHOD="POST" id="frm_cancelar_cupon" name="frm_cancelar_cupon">
          <table >
            <tr><td colspan="2" class="cabecera" align="left">Introduzca la contraseña:</td></tr>
            <tr>
                <td><br><span class="label_">Contraseña</span><span style="color:#f00"></span></td>
                <td><br><INPUT TYPE="password" NAME="password" id="password"></td>
                <td  align="right" style="vertical-align:bottom;"><INPUT id="boton_cancelar" name="boton_cancelar" TYPE="submit" class="boto" value="Aceptar" > </td>
            </tr>
           </table>
           <input type="hidden" id="ncupon_cc" name="ncupon_cc">
           <input type="hidden" id="id_establecimiento_cc" name="id_establecimiento_cc">
           <input type="hidden" id="id_talonario_cc" name="id_talonario_cc">
           <input type="hidden" id="num_talonario_cc" name="num_talonario_cc">

    </FORM> 
    </fieldset>
    </div>
</div>
