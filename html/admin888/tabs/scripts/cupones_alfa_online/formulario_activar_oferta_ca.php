<div id="activar_oferta_ca" style="display:none;float:left;width:100%;" >
    <div id='form_activar_oferta_ca' style='text-align:left;padding:10px; background:#fff;'>
    <fieldset>
    <legend>Activar Oferta </legend>
    <div id="msg_error_activ_ca" style="font-size:18px;color:red;"></div>  
    <FORM ACTION="javascript:;" action="" METHOD="POST" id="frm_activar_oferta_ca" name="frm_activar_oferta_ca">
<!--          <table>
            <tr><td><legend>Seleccione el periodo de duración de la oferta </legend></td></tr>  
            <tr height="10px;"><td></td></tr>
            <tr class="periodo"><td>24 horas <INPUT id="24h" TYPE="RADIO" NAME="24h" VALUE="24" onclick="seleccionar_periodo(this);"></td></tr> 
            <tr class="periodo"><td>48 horas <INPUT id="48h" TYPE="RADIO" NAME="48h" VALUE="48" onclick="seleccionar_periodo(this);"></td></tr> 
            <tr class="periodo"><td>72 horas <INPUT id="72h" TYPE="RADIO" NAME="72h" VALUE="72" onclick="seleccionar_periodo(this);"></td></tr> 
            <tr class="periodo"><td>96 horas <INPUT id="96h" TYPE="RADIO" NAME="96h" VALUE="96" onclick="seleccionar_periodo(this);"></td></tr> 
            <tr height="10px;"><td></td></tr>
           </table>
-->           
           <INPUT style="visibility:hidden;" id="boton_activar" name="boton_activar" TYPE="submit" class="boto" value="Aceptar">
           <input type="hidden" id="id_oferta_fba_ca" name="id_oferta_fba_ca">
           <input type="hidden" id="activa_fba_ca" name="activa_fba_ca">
    </FORM> 
    </fieldset>
    </div>
</div>
<style>
    .periodo{font-size:20px;text-align:center;}
</style>

<script type="text/javascript">
    function seleccionar_periodo(opcion)
    {
        //alert(document.getElementById('periodo_fba').value);
        //alert(document.getElementById('activa_fba').value);
        //and document.getElementById('periodo_fba').value==opcion.value
        if (document.getElementById('activa_fba_ca').value==1)
        {
            alert('Esta oferta ya ha sido activada');
            return;
        }
        envia_formulario_activar_oferta(id_('id_oferta_fba_ca').value,1);
    }
</script>
