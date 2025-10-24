<div id="observaciones_cupon_oferta" style="display:none;float:left;width:100%;" >
    <div id='form_observaciones_cupon_oferta' style='text-align:left;padding:10px; background:#fff;'>
    <fieldset>
    <legend>Observaciones Cupón</legend>
    <div id="msg_error"></div>  
    <FORM ACTION="javascript:;" onsubmit="envia_formulario_observaciones_cupon_oferta(id_('id_oferta_fo').value,id_('ncupon_fo').value,id_('observaciones_oferta').value,id_('creadas_fo').value)" METHOD="POST" id="frm_observaciones_cupon_oferta" name="frm_observaciones_cupon_oferta">
          <table >
            <tr><td colspan="2" class="cabecera" align="left">Introduzca el texto:</td></tr>
            <tr>
               <!-- <td><br><span class="label_">Observaciones</span><span style="color:#f00"></span></td> -->
                <td><br><textarea id="observaciones_oferta" wrap="hard" name="observaciones_oferta" cols="50" rows="3"></textarea></td>
            </tr>
            <tr>
                <td align="right" style="vertical-align:bottom;"><INPUT id="boton_guardar_observaciones" name="boton_guardar_observaciones" TYPE="submit" class="boto" value="Aceptar" > </td>
            </tr>
           </table>
           <input type="hidden" id="ncupon_fo" name="ncupon_fo">
           <input type="hidden" id="id_oferta_fo" name="id_oferta_fo">
           <input type="hidden" id="creadas_fo" name="creadas_fo">
    </FORM> 
    </fieldset>
    </div>
</div>
