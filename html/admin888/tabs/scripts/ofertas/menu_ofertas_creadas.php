<div  id="menu_ofertas_creadas" style="display:none;width:928px;padding-top:4px;padding-bottom:1px;margin-left:22px;border:1px solid #aaa;background-image:url(../img/barra_.png)">
<input type="hidden" id="id_oferta">
<input type="hidden" id="periodo">
<input type="hidden" id="cliente_especial">
<input type="hidden" id="menu_motorclub">
<input type="hidden" id="menu_dreamcars">
<input type="hidden" id="menu_hcc">
<input type="hidden" id="periodo_automatico">
<a class="opcion_menu" href="javascript:edita_oferta(id_('id_oferta').value,'<?php echo($tipo);?>');"><span style="border:1px solid #ffffff;padding:1px"><img src="<?php echo(URL_ROOT);?>img/edit.gif"  alt="" /></span>EDITAR</a>
<span style="font-weight:bold;font-size:15px">|</span>
<a class="opcion_menu" href="javascript:borrar_oferta(id_('id_oferta').value,1,0,id_('cliente_especial').value,'<?php echo($tipo);?>');"> <span style="border:1px solid #ffffff;padding:1px"><img src="<?php echo(URL_ROOT);?>img/esborra.gif"  alt="" /></span>ELIMINAR</a>
<span style="font-weight:bold;font-size:15px">|</span>
<a class="opcion_menu" href="javascript:validar_cliente_especial;activar_oferta(id_('id_oferta').value,1,id_('periodo').value,'<?php echo($tipo);?>',id_('cliente_especial').value,id_('menu_motorclub').value,id_('menu_dreamcars').value,id_('menu_hcc').value,id_('periodo_automatico').value);"> ACTIVAR</a>
<span style="font-weight:bold;font-size:15px">|</span> 
<a class="opcion_menu" href="javascript:validar_cliente_especial();"> DESACTIVAR</a>
</div>

<script>
    function validar_cliente_especial()
    {
        if (id_('cliente_especial').value==1)
            alert('Las ofertas especiales no se pueden desactivar');
        else  activar_oferta(id_('id_oferta').value,0,id_('periodo').value,'<?php echo($tipo);?>',id_('cliente_especial').value,id_('menu_motorclub').value,id_('menu_dreamcars').value,id_('menu_hcc').value,id_('periodo_automatico').value);  
    }
</script>