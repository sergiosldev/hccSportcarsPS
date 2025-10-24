<div id="observaciones_cupon_oferta" style="display:none;float:left;width:100%;" onload="alert(observaciones_oferta_ca);">
    <div id='form_observaciones_cupon_oferta_ca' style='text-align:left;padding:10px; background:#fff;'>
    <fieldset>
    <legend>Observaciones Cupón</legend>
    <div id="msg_error"></div>  
    <FORM ACTION="javascript:;" onsubmit="envia_formulario_observaciones();" METHOD="POST" id="frm_observaciones_cupon_oferta_ca" name="frm_observaciones_cupon_oferta_ca">
          <table >
            <tr><td colspan="2" class="cabecera" align="left">Introduzca el texto:</td></tr>
            <tr>
               <!-- <td><br><span class="label_">Observaciones</span><span style="color:#f00"></span></td> -->
                <td><br><textarea id="observacionesoferta_ca" wrap="hard" name="observacionesoferta_ca" cols="50" rows="3"></textarea></td>
            </tr>
            <tr>
                <td align="right" style="vertical-align:bottom;"><INPUT id="boton_guardar_observaciones_ca" name="boton_guardar_observaciones" TYPE="submit" class="boto" value="Aceptar" > </td>
            </tr>
           </table>
           <input type="hidden" id="ncupon_fo_ca" name="ncupon_fo_ca">
           <input type="hidden" id="id_oferta_fo_ca" name="id_oferta_fo_ca">
           <input type="hidden" id="creadas_fo_ca" name="creadas_fo_ca">
           <input type="hidden" id="id_distribuidor_fo_ca" name="id_distribuidor_fo_ca">
    </FORM> 
    <script type="text/javascript">
        function envia_formulario_observaciones()
        {
//            alert(id_('id_distribuidor_fo_ca').value);
            if (id_('id_distribuidor_fo_ca').value=='')
                envia_formulario_observaciones_cupon_oferta(id_('id_oferta_fo_ca').value,id_('ncupon_fo_ca').value,id_('observacionesoferta_ca').value,id_('creadas_fo_ca').value);
            else
                envia_formulario_observaciones_cupon_oferta(id_('id_oferta_fo_ca').value,id_('ncupon_fo_ca').value,id_('observacionesoferta_ca').value,id_('creadas_fo_ca').value,id_('id_distribuidor_fo_ca').value);           
        }
    </script>
    </fieldset>
    </div>
</div>
