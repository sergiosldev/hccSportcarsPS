<div id="borrar_establecimiento" style="display:none;float:left;width:100%;" >
    <div id='form_borrar_establecimiento' style='text-align:left;padding:10px; background:#fff;'>
    <fieldset>
    <legend>Eliminar Establecimiento </legend>
    <div id="msg_error"></div>  
    <FORM ACTION="javascript:;" onsubmit="envia_formulario_establecimiento(id_('id_establecimiento_fbe').value,id_('password').value)" METHOD="POST" id="frm_borrar_establecimiento" name="frm_borrar_establecimiento">
          <table >
            <tr><td colspan="2" class="cabecera" align="left">Introduzca la contraseña:</td></tr>
            <tr>
                <td><br><span class="label_">Contraseña</span><span style="color:#f00"></span></td>
                <td><br><INPUT TYPE="password" NAME="password" id="password"></td>
                <td  align="right" style="vertical-align:bottom;"><INPUT id="boton_eliminar" name="boton_eliminar" TYPE="submit" class="boto" value="Aceptar" > </td>
            </tr>
           </table>
           <input type="hidden" id="id_establecimiento_fbe" name="id_establecimiento_fbe">

    </FORM> 
    </fieldset>
    </div>
</div>
