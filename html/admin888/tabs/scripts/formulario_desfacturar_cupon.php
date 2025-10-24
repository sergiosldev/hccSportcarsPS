<div id="desfacturar_cupon" style="display:none;float:left;width:100%;" >
    <div id='form_desfacturar_cupon' style='text-align:left;padding:10px; background:#fff;'>
    <fieldset>
    <legend id="texto_desfacturar">Marcar cupón como no facturado</legend>
    <div id="msg_error"></div>  
    <FORM ACTION="javascript:;" onsubmit="envia_formulario_desfacturar_cupon(id_('id_establecimiento_desc').value,id_('id_talonario_desc').value,id_('num_talonario_desc').value,id_('ncupon_desc').value,id_('password').value,id_('tipod').value)" METHOD="POST" id="frm_desfacturar_cupon" name="frm_desfacturar_cupon">
          <table >
            <tr><td colspan="2" class="cabecera" align="left">Introduzca la contraseña:</td></tr>
            <tr>
                <td><br><span class="label_">Contraseña</span><span style="color:#f00"></span></td>
                <td><br><INPUT TYPE="password" NAME="password" id="password"></td>
                <td  align="right" style="vertical-align:bottom;"><INPUT id="boton_desfacturar" name="boton_desfacturar" TYPE="submit" class="boto" value="Aceptar" > </td>
            </tr>
           </table>
           <input type="hidden" id="tipod" name="tipod">
           <input type="hidden" id="ncupon_desc" name="ncupon_desc">
           <input type="hidden" id="id_establecimiento_desc" name="id_establecimiento_desc">
           <input type="hidden" id="id_talonario_desc" name="id_talonario_desc">
           <input type="hidden" id="num_talonario_desc" name="num_talonario_desc">

    </FORM> 
    </fieldset>
    </div>
</div>
