<div id="borrar_imagen_oferta" style="display:none;float:left;width:100%;" >
    <div id='form_borrar_imagen_oferta_ca' style='text-align:left;padding:10px; background:#fff;'>
    <fieldset>
    <legend>Eliminar Imagen </legend>
    <div id="msg_error_im_of"></div>  
    <FORM ACTION="javascript:;" onsubmit="envia_form_borrar_imagen_oferta(id_('id_imagen_fbi_ca').value,id_('id_oferta_fbi_ca').value,id_('password').value)" METHOD="POST" id="frm_borrar_imagen_oferta_ca" name="frm_borrar_imagen_oferta_ca">
          <table >
            <tr><td colspan="2" class="cabecera" align="left">Introduzca la contraseña:</td></tr>
            <tr>
                <td><br><span class="label_">Contraseña</span><span style="color:#f00"></span></td>
                <td><br><INPUT TYPE="password" NAME="password" id="password"></td>
                <td  align="right" style="vertical-align:bottom;"><INPUT id="boton_eliminar" name="boton_eliminar" TYPE="submit" class="boto" value="Aceptar" > </td>
            </tr>
           </table>
           <input type="hidden" id="id_imagen_fbi_ca" name="id_imagen_fbi_ca">
           <input type="hidden" id="id_oferta_fbi_ca" name="id_oferta_fbi_ca">
    </FORM> 
    </fieldset>
    </div>
</div>
