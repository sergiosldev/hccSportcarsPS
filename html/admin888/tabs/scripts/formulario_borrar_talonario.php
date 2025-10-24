<div id="borrar_talonario" style="display:none;float:left;width:100%;" >
    <div id='form_borrar_talonario' style='text-align:left;padding:10px; background:#fff;'>
    <fieldset>
    <legend>Eliminar Talonario </legend>
    <div id="msg_error"></div>  
    <FORM ACTION="javascript:;" onsubmit="envia_formulario_talonario(id_('id_establecimiento_fbt').value,id_('id_talonario_fbt').value,id_('password').value)" METHOD="POST" id="frm_borrar_talonario" name="frm_borrar_talonario">
          <table >
            <tr><td colspan="2" class="cabecera" align="left">Introduzca la contraseña:</td></tr>
            <tr>
                <td><br><span class="label_">Contraseña</span><span style="color:#f00"></span></td>
                <td><br><INPUT TYPE="password" NAME="password" id="password"></td>
                <td  align="right" style="vertical-align:bottom;"><INPUT id="boton_eliminar" name="boton_eliminar" TYPE="submit" class="boto" value="Aceptar" > </td>
            </tr>
           </table>
           <input type="hidden" id="id_establecimiento_fbt" name="id_establecimiento_fbt">
           <input type="hidden" id="id_talonario_fbt" name="id_talonario_fbt">
      <!-- <span class="label_">Campos obligatorios</span><span style="color:#f00">*</span> -->
    </FORM> 
    </fieldset>
    </div>
</div>
