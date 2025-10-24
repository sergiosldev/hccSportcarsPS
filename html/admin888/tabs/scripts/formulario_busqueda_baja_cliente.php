<div id="buscar_baja_clientes" style="display:none;float:left;width:100%;" >
    <div id='form_busqueda_baja_clientes' style='text-align:left;padding:10px; background:#fff;'>
    <fieldset>
    <legend>Búsqueda Cliente bja</legend>
    <div id="msg_error_cliente"></div>  
    <FORM ACTION="javascript:;" onsubmit="envia_formulario_baja_clientes()" METHOD="POST" id="frm_busqueda_baja_clientes" name="frm_busqueda_baja_clientes">
          <table >
            <tr><td colspan="2" class="cabecera" align="left">Criterio de búsqueda</td></tr>
            <tr>
                <td><br><span class="label_">Email cliente</span><span style="color:#f00"></span></td>
                <td><br><INPUT TYPE="text" NAME="cliente_baja" id="cliente_baja"></td>
                <td align="right" style="vertical-align:bottom;"><INPUT id="boton_buscar" name="boton_buscar" TYPE="submit" class="boto" value="Eliminar" > </td>
            </tr>
           </table>
           <input type="hidden" id="filtro_cliente_baja" name="filtro_cliente_baja">
    </FORM> 
	<div id="lista_baja_clientes"></div>
    </fieldset>
    </div>
</div>
