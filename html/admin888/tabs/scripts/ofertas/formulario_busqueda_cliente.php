<div id="buscar_cliente_oferta" style="display:none;float:left;width:100%;" >
    <div id='form_busqueda_cliente' style='text-align:left;padding:10px; background:#fff;'>
    <fieldset>
    <legend>Búsqueda Cliente </legend>
    <div id="msg_error_cliente"></div>  
    <FORM ACTION="javascript:;" onsubmit="envia_formulario_clientes(registros_pagina_cliente)" METHOD="POST" id="frm_busqueda_cliente" name="frm_busqueda_cliente">
          <table >
            <tr><td colspan="2" class="cabecera" align="left">Criterio de búsqueda</td></tr>
            <tr>
                <td><br><span class="label_">Cliente</span><span style="color:#f00"></span></td>
                <td><br><INPUT TYPE="text" NAME="cliente_oferta" id="cliente_oferta"></td>
                <td  align="right" style="vertical-align:bottom;"><INPUT id="boton_buscar" name="boton_buscar" TYPE="submit" class="boto" value="Buscar" > </td>
            </tr>
           </table>
           <input type="hidden" id="filtro_cliente" name="filtro_cliente">
      <!-- <span class="label_">Campos obligatorios</span><span style="color:#f00">*</span> -->
    </FORM> 
    </fieldset>
    </div>
</div>
