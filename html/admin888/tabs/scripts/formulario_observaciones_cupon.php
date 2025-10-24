<div id="observaciones_cupon" style="display:none;float:left;width:100%;" >
    <div id='form_observaciones_cupon' style='text-align:left;padding:10px; background:#fff;'>
    <fieldset>
    <legend>Observaciones Cupón</legend>
    <div id="msg_error"></div>  
    <FORM ACTION="javascript:;" onsubmit="envia_formulario_observaciones_cupon(id_('id_establecimiento_fo').value,id_('id_talonario_fo').value,id_('num_talonario_fo').value,id_('ncupon_fo').value,id_('observaciones').value)" METHOD="POST" id="frm_observaciones_cupon" name="frm_observaciones_cupon">
          <table >
            <tr><td colspan="2" class="cabecera" align="left">Introduzca el texto:</td></tr>
            <tr>
               <!-- <td><br><span class="label_">Observaciones</span><span style="color:#f00"></span></td> -->
                <td><br><textarea id="observaciones" wrap="hard" name="observaciones" cols="50" rows="8"></textarea></td>
            </tr>
            <tr>
                <td align="right" style="vertical-align:bottom;"><INPUT id="boton_guardar_observaciones" name="boton_guardar_observaciones" TYPE="submit" class="boto" value="Aceptar" > </td>
            </tr>
           </table>
           <input type="hidden" id="ncupon_fo" name="ncupon_fo">
           <input type="hidden" id="id_establecimiento_fo" name="id_establecimiento_fo">
           <input type="hidden" id="id_talonario_fo" name="id_talonario_fo">
           <input type="hidden" id="num_talonario_fo" name="num_talonario_fo">
    </FORM> 
    </fieldset>
    </div>
</div>
