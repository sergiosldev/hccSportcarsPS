<div  id="menu_ofertas_creadas" style="display:none;width:928px;padding-top:4px;padding-bottom:1px;margin-left:22px;border:1px solid #aaa;background-image:url(../img/barra_.png)">
<input type="hidden" id="id_oferta">
<input type="hidden" id="periodo">
<input type="hidden" id="cliente_especial">
<input type="hidden" id="menu_hcc">
<input type="hidden" id="menu_GT">
<input type="hidden" id="periodo_automatico">
<a class="opcion_menu" href="javascript:edita_oferta(id_('id_oferta').value,'<?php echo($tipo);?>');"><span style="border:1px solid #ffffff;padding:1px"><img src="<?php echo(URL_ROOT);?>img/edit.gif"  alt="" /></span>EDITAR</a>
<span style="font-weight:bold;font-size:15px">|</span>
<a class="opcion_menu" href="javascript:borrar_oferta(id_('id_oferta').value,1,0,id_('cliente_especial').value,'<?php echo($tipo);?>');"> <span style="border:1px solid #ffffff;padding:1px"><img src="<?php echo(URL_ROOT);?>img/esborra.gif"  alt="" /></span>ELIMINAR</a>
<span style="font-weight:bold;font-size:15px">|</span>
<a class="opcion_menu" href="javascript:aviso(false);editar_formulario_activar();"> ACTIVAR</a>
<span style="font-weight:bold;font-size:15px">|</span> 
<a class="opcion_menu" href="javascript:validar_cliente_especial();"> DESACTIVAR</a>
</div>

<script>
    function validar_cliente_especial()
    {
        if (id_('cliente_especial').value==1)
            alert('Las ofertas especiales no se pueden desactivar');
        else  activar_oferta(id_('id_oferta').value,0,id_('periodo').value,'<?php echo($tipo);?>',id_('cliente_especial').value,id_('menu_hcc').value,id_('menu_GT').value,id_('periodo_automatico').value);  
    }

	
	function editar_formulario_activar()
	{
		var ale='&gg'+(Math.floor(Math.random()*50000))+'=1';
	    r=ajax.load('<?php echo $base_scripts ?>ajax_ofertas_bd.php?valores_activacion=1&id_oferta='+id_('id_oferta').value+ale); 
		var arr=r.split('#');
		id_('periodo').value=arr[0];
		id_('periodo_automatico').value=arr[1];
		id_('menu_hcc').value=arr[2];
		id_('menu_GT').value=arr[3];

		if (r.indexOf('Error')!=-1) 
		{   
			alert(r);
			return;
		}
		else  
		{
			activar_oferta(id_('id_oferta').value,1,id_('periodo').value,'<?php echo($tipo);?>',id_('cliente_especial').value,id_('menu_hcc').value,id_('menu_GT').value,id_('periodo_automatico').value);	
		}

	}
	
	function aviso(activo)
	{
		if (activo)
			alert(id_('menu_hcc').value+'-'+id_('menu_GT').value+'checkeds: '+id_('menu_hcc').checked+'-'+id_('menu_GT').checked);
		
	}
</script>