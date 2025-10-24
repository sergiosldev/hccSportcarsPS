<div id="buscar_cupon_oferta_ca" style="display:none;float:left;width:100%;" >
    <div id='form_busqueda_oferta_ca' style='text-align:left;padding:10px; background:#fff;'>
    <fieldset>
    <legend>Búsqueda Cupón </legend>
    <div id="msg_error_ca"></div>  
    <FORM ACTION="javascript:;" onsubmit="envia_formulario_cupon_oferta()" METHOD="POST" id="frm_busqueda_oferta_ca" name="frm_busqueda_oferta_ca">
          <table >
            <tr><td colspan="2" class="cabecera" align="left">Número de cheque</td></tr>
            <tr>
                <td><br><span class="label_">Cheque</span><span style="color:#f00"></span></td>
                <td><br><INPUT TYPE="text" NAME="cupon_oferta_ca" id="cupon_oferta_ca"></td>
                <td  align="right" style="vertical-align:bottom;"><INPUT id="boton_buscar" name="boton_buscar" TYPE="submit" class="boto" value="Buscar" > </td>
            </tr>
           </table>
           <input type="hidden" id="id_oferta_ca" name="id_oferta_ca">
      <!-- <span class="label_">Campos obligatorios</span><span style="color:#f00">*</span> -->
    </FORM> 
    </fieldset>
    </div>
</div>
