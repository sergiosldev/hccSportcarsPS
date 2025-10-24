<link rel="stylesheet" href="../../../scripts/calendario/css/style.css" />
<div id="hotel_disponible" style="display:none;float:left;width:100%;">
    <div id='form_hoteles_disponibles' style='text-align:left;padding:10px; background:#fff;'>
    <fieldset>
    <legend>Seleccionar hoteles activos</legend>
    <div id="msg_error2"></div>   
	<h2>Hoteles con disponibilidad</h2>
	<FORM ACTION="javascript:;" onsubmit=""  METHOD="POST" id="frm_hoteles_disponibles" name="frm_hoteles_disponibles" style="text-algin:left;margin-left:50px;">
	</FORM>
</fieldset>
 </div> 
</div> 
  

<style type="text/css">
</style>     	 

<script type="text/javascript">
function guardar_codigo(ciudad,codigo)
{
	var ale='&gg'+(Math.floor(Math.random()*50000))+'=1';
	<?php 
	$texto = utf8_decode('Se va a guardar el nuevo hotel seleccionado. Esta seguro de que desea continuar?'); 
	?>
	if (confirm("<?php echo($texto);?>"))
	{
		var r=ajax.load('tabs/scripts/guardar_codigo_hotel.php?ciudad='+ciudad+'&codigo='+codigo+ale);
	}
	else 
	{		 
        $("input:radio[name=ciudad_"+ciudad+"]").each(function()
           {
            if( $(this).attr("id") == "codigo_"+codigo)
            {
                $(this).attr('checked', false);
            }
           	else
            {
                $(this).attr('checked', 'checked');
            }

          });

		     
	}

}

</script>


	
	