<div id="disponible_cupon" style="display:none;float:left;width:100%;" >
    <div id='form_disponible_cupon' style='text-align:left;padding:10px; background:#fff;'>
    <fieldset>
    <legend>Cambiar Cupón a estado disponible</legend>
    <div id="msg_error"></div>  
    <FORM ACTION="javascript:;" onsubmit="envia_formulario_cambiar_cupon_disponible(id_('id_establecimiento_dc').value,id_('id_talonario_dc').value,id_('num_talonario_dc').value,id_('ncupon_dc').value,id_('password').value)" METHOD="POST" id="frm_disponible_cupon" name="frm_disponible_cupon">
          <table >
            <tr><td colspan="2" class="cabecera" align="left">Introduzca la contraseña:</td></tr>
            <tr>
                <td><br><span class="label_">Contraseña</span><span style="color:#f00"></span></td>
                <td><br><INPUT TYPE="password" NAME="password" id="password"></td>
                <td  align="right" style="vertical-align:bottom;"><INPUT id="boton_disponible" name="boton_disponible" TYPE="submit" class="boto" value="Aceptar" > </td>
            </tr>
           </table>
           <input type="hidden" id="ncupon_dc" name="ncupon_dc">
           <input type="hidden" id="id_establecimiento_dc" name="id_establecimiento_dc">
           <input type="hidden" id="id_talonario_dc" name="id_talonario_dc">
           <input type="hidden" id="num_talonario_dc" name="num_talonario_dc">

    </FORM> 
    </fieldset>
    </div>
</div>
