<div id="buscar_cupon_oferta" style="display:none;float:left;width:100%;" >
    <div id='form_busqueda_oferta' style='text-align:left;padding:10px; background:#fff;'>
    <fieldset>
    <legend>Búsqueda Cupón </legend>
    <div id="msg_error"></div>  
    <FORM ACTION="javascript:;" onsubmit="envia_formulario_cupon_oferta()" METHOD="POST" id="frm_busqueda_oferta" name="frm_busqueda_oferta">
          <table >
            <tr><td colspan="2" class="cabecera" align="left">Número de cheque</td></tr>
            <tr>
                <td><br><span class="label_">Cheque</span><span style="color:#f00"></span></td>
                <td><br><INPUT TYPE="text" NAME="cupon_oferta" id="cupon_oferta"></td>
                <td  align="right" style="vertical-align:bottom;"><INPUT id="boton_buscar" name="boton_buscar" TYPE="submit" class="boto" value="Buscar" > </td>
            </tr>
           </table>
           <input type="hidden" id="id_oferta" name="id_oferta">
      <!-- <span class="label_">Campos obligatorios</span><span style="color:#f00">*</span> -->
    </FORM> 
    </fieldset>
    </div>
</div>
