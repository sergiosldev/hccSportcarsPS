<div id="marcar_cliente_especial_oferta" style="display:none;float:left;width:100%;" >
    <div id='form_marcar_cliente_especial' style='text-align:left;padding:10px; background:#fff;'>
    <fieldset>
    <legend>Eliminar Oferta </legend>
    <div id="msg_error"></div>  
    <FORM ACTION="javascript:;" onsubmit="envia_formulario_marcar_oferta(id_('id_oferta_fmce').value,document.frm_marcar_cliente_especial.password.value,id_('creadas_fmce').value)" METHOD="POST" id="frm_marcar_cliente_especial" name="frm_marcar_cliente_especial">
          <table >
            <tr><td colspan="2" class="cabecera" align="left">Introduzca la contraseña:</td></tr>
            <tr>
                <td><br><span class="label_">Contraseña</span><span style="color:#f00"></span></td>
                <td><br><INPUT TYPE="password" NAME="password" id="password"></td>
                <td  align="right" style="vertical-align:bottom;"><INPUT id="boton_marcar" name="boton_marcar" TYPE="submit" class="boto" value="Aceptar" > </td>
            </tr>
           </table>
           <input type="hidden" id="id_oferta_fmce" name="id_oferta_fmce">
           <input type="hidden" id="creadas_fmce" name="creadas_fmce">
    </FORM> 
    </fieldset>
    </div>
</div>
