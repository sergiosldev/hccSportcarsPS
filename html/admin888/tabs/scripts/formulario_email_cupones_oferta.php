<div id="email_cupones_oferta" style="display:none;float:left;width:100%;" >
    <div id='form_email_cupones_oferta' style='text-align:left;padding:10px; background:#fff;'>
    <fieldset>
    <legend>Confirmación cupón</legend>
    <div id="msg_error"></div>  
    <FORM ACTION="javascript:;" onsubmit="envia_formulario_email_cupon_oferta (id_('id_oferta_fec').value,id_('ncupon_fec').value,id_('email_cupon').value,id_('creadas_fec').value)" METHOD="POST" id="frm_email_cupones_oferta" name="frm_email_cupones_oferta">
          <table >
            <tr><td colspan="2" class="cabecera" align="left">Introduzca la dirección de emal:</td></tr>
            <tr>
               <!-- <td><br><span class="label_">Observaciones</span><span style="color:#f00"></span></td> -->
                <td><br><input type="text" style="width:400px;" id="email_cupon" name="email_cupon"></td>
            </tr>
            <tr>
                <td align="right" style="vertical-align:bottom;"><INPUT id="boton_guardar_email_cupon" name="boton_guardar_email_cupon" TYPE="submit" class="boto" value="Enviar Email" > </td>
            </tr>
           </table>
           <input type="hidden" id="ncupon_fec" name="ncupon_fec">
           <input type="hidden" id="id_oferta_fec" name="id_oferta_fec">
           <input type="hidden" id="creadas_fec" name="creadas_fec">
    </FORM> 
    </fieldset>
    </div>
</div>
