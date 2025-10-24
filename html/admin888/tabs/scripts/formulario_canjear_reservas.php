<?php
	include_once(dirname(__FILE__).'/../../../config/config.inc.php'); 
	$plataforma=new Plataforma();
	$plataformas=$plataforma->getPlataformas();
	unset($plataforma);
?>
 
<div id="buscar_res_canjear" style="display:none;float:left;width:100%;">
    <div id='form_canjear_reserva' style='text-align:left;padding:10px; background:#fff;'>
    <fieldset>
    <legend>Canjear Reservas</legend> 
    <div id="msg_error2"></div>            
	<FORM ACTION="javascript:;" onsubmit="buscar_reservas_canjear();"  METHOD="POST" id="frm_canjear_reservas" name="frm_canjear_reservas" style="text-algin:left;margin-left:50px;">
		<span class="label_ buscar_pilotosr">Or&iacute;gen</span></span>
		<select name="origen" id="origen" onchange="canvia_origen_canjear()">
		  <option value="">--Elija opcion--</option>           
		  <?php 
		  foreach($plataformas as $pl)
		  {
			echo('<option value="'.$pl['valor'].'">'.$pl['nombre'].'</option>');  
		  }
		  ?>
		  <option value="OTROS">OTROS</option>                                                
		</select>
		    <!--<br \>
		    <span class="label_ buscar_pilotos">Email</span><span style="color:#f00"></span>
		    <INPUT  class="buscar_pilotos" TYPE="text" NAME="emailb" id="emailb">
			<INPUT TYPE="hidden" NAME="buscapilotos" id="buscapilotos">
			<br /><br />
		    <span class="label_ buscar_pilotos">Nombre</span><span style="color:#f00"></span>
		    <INPUT  class="buscar_pilotos" TYPE="text" NAME="nombreb" id="nombreb">
		    <br /><br />
		    <span class="label_ buscar_pilotos">Telefono</span><span style="color:#f00"></span>
		    <INPUT  class="buscar_pilotos" TYPE="text" NAME="telefonob" id="telefonob">
		    <br /><br />
		    <span class="label_ buscar_pilotos">Ciudad</span><span style="color:#f00"></span>
		    <select  class="buscar_pilotos" name="ciudadb" id="ciudadb">
             <option value="*">Todas</option>
             <option value="">Barcelona</option>
             <option value="valencia">Valencia</option>
             <option value="madrid">Madrid</option>
             <option value="andalucia">Andaluc&iacute;a</option>
             <option value="cantabria">Cantabria</option>
             <option value="rutas_turisticas">Rutas tur&iacute;sticas</option>
            </select> 	
			<br />	<br />
		    <span class="label_ buscar_pilotos">CODIGO/CODIGOS</span><span style="color:#f00"></span>
		    <TEXTAREA class="buscar_pilotos" name="codigob" id="codigob" style="height:80px;width:630px;"></TEXTAREA>
		    <br /><br /><br />
		    <span class="label_ buscar_pilotos">DIA</span><span style="color:#f00"></span>
		    <INPUT  class="buscar_pilotos" TYPE="text" NAME="diab" id="diab">
		    
			<span style="display: block; margin-right: 0px; margin-bottom: 0px; margin-left: 0px; padding-right: 0px; padding-bottom: 0px; padding-left: 0px; width: 1%; height: 1%;">&nbsp;</span>
		    
			<span class="label_ buscar_pilotos">TIPO</span><span style="color:#f00"></span>
		    <INPUT  class="buscar_pilotos" TYPE="text" NAME="tipob" id="tipob">
			-->
		    <br /><br /><br />
		    <div style="display:block;float:left;">
		    <!--<INPUT class="buscar_pilotosr"  TYPE="reset" style="border:1px solid #7766aa;padding:5px;"  value="Limpia">-->
		    <INPUT class="buscar_pilotosr"  TYPE="submit" style="border:1px solid #7766aa;padding:5px;"  value="Busca">
		    </div>
	</FORM>
</fieldset>
 </div> 
</div> 
  
<style type="text/css">
	span.buscar_pilotosr 
	{
		display:inline-block;
		width:50px !important;
		text-align:left;
		float:left;
		font-size:14px;
		margin-top:10px;
	}
	
	#origen
	{
		background:#FFF;
		color:#000;
		float:left;
		border:2px solid #cccccc;
		margin-left:10px;
		margin-top:10px;
	}
	
</style> 
<!--<style type="text/css">
	span.buscar_pilotos 
	{
	display:inline-block;
	width:100px !important;
	text-align:left;
	float:left;
	}
	
	input[type="text"].buscar_pilotos,select.buscar_pilotos
	{
	display:inline-block;
	width:150px !important;
	text-align:left;
	float:left;
	}	
	
	textarea.buscar_pilotos
	{
	display:inline-block;
	text-align:left;
	float:left;
	margin-bottom:15px;
	}	
</style>     	 
-->
<script type="text/javascript">
function buscar_reservas_canjear(valor_listbox)   
{  
	if (valor_listbox==undefined)
	{
		var dades=obtenirDadesForm('frm_canjear_reservas');     
	}
	else
	{
	    var dades='origen='+encodeURIComponent(valor_listbox);
	}

	var ale='&gg'+(Math.floor(Math.random()*50000))+'=1';    
	var r=ajax.load('tabs/scripts/buscar_pilotos_canjear.php?'+dades+ale);          
	$('#listado_pilotos_canjear').html(r);    
	$.colorbox({width:'100%',inline:true, href:'#listado_pilotos_canjear',open:true});                 
}  
      
function canvia_origen_canjear()
{
	//buscar_reservas_canjear($('#origen').val());
}	  

function canvia_origen_canjear2()
{
	var valor_seleccionado=$('#origen option:selected').val();
	
	buscar_reservas_canjear(valor_seleccionado);
	
}	  

	  
/*
function ir_a_reserva(tipo,ciudad,fecha,id)  
{ 
	$("body").css("cursor", "progress");

     //tipus_ev=tipo;
     var sciudad;
     if (ciudad!='Barcelona')
     	sciudad=ciudad;
     else sciudad='';
	 
	 sciudad = sciudad.toLowerCase();
     canvia_ciudad(sciudad);
     canvia_tipus(tipo);  
	 var afecha = new Array();
	 afecha=fecha.split('-');
     v_mes_sel = afecha[1];
     v_ano_sel = afecha[0];
	 v_mes=v_mes_sel;
	 v_ano = v_ano_sel;
	 dia_sel = fecha;
     
	 
	 id_('calendari').innerHTML = crida(v_mes_sel, v_ano_sel,sciudad,tipus_ev);
     
     id_('graella').innerHTML='';
     
     id_('header_graella').style.display='none';  
     id_('msg_error').innerHTML='';
     get_graella(fecha);
	 id_('dia').innerHTML='Dia actual: <span style="color:#f04">'+dia_sel+'</span>';
     
	 
	 
	 
	 $('html,body').css("cursor","pointer");
     $.colorbox.close();   

	 window.location='#fila'+id;
     
}
*/  

</script>

<script type="text/javascript">

function marcar_no_visible(origen,ciudad,visible,indice)     
{
	if (visible==0)
	{
		$('#visible'+indice).val(1);
		$('#fila'+indice).css('background-color','#FFFFFF');		
		$('#boton'+indice).val('ocultar');
	}
	else
	{
		$('#visible'+indice).val(0);
		$('#fila'+indice).css('background-color','#FFF466');
		$('#boton'+indice).val('mostrar');
	} 
	
	guardar_marca_visible(origen,ciudad,indice,$('#visible'+indice).val());		                       
}

function marcar_canjeado(origen,ciudad,marcado,indice)   
{
	
	if (origen=='')
	{
		alert('Para poder marcar esta reserva debe especificar anteriormente un Origen');
		return;
	}
	if (marcado==1)
	{
		$('#marcado'+indice).val(0);
		$('#fila'+indice).css('background-color','#ffffff');
	}
	else
	{
		$('#marcado'+indice).val(1);
		$('#fila'+indice).css('background-color','#80F466');
	} 
	
	guardar_marca(origen,ciudad,indice,$('#marcado'+indice).val());		                          
	guardar_marca_visible(origen,ciudad,indice,1);		                       
}        

 
function marcar_especial(indice,tipo,marcado,ciudad,tipo_marca)
{
	//tipo_marca=0: marcamos una única reserva.
	if (!tipo_marca)
	{
		if (origen=='')
		{
			alert('Para poder marcar esta reserva debe especificar anteriormente un Origen'); 
			return;
		}
		if (marcado==1)
		{
			$('#marcado_especial'+indice).val(0);
			$('#reserva_especial'+indice).css('background-color','#ffffff');
			$('#reserva_especial'+indice).css('color','#000000');
		}
		else
		{
			$('#marcado_especial'+indice).val(1);
			$('#reserva_especial'+indice).css('background-color','#b244fd');
			$('#reserva_especial'+indice).css('color','#ffffff');
		} 
			
		marca_reserva_especial(indice,tipo,$('#marcado_especial'+indice).val(),ciudad);
	}
	//tipo_marca=1: marcamos varias reservas.
	else
	{
		marca_reserva_especial(indice,tipo,($('#marcado_especial'+indice).val()=='1')?0:1,ciudad);
	}
	//guardar_marca_especial(origen,ciudad,indice,$('#marcado_especial'+indice).val());		                          
	//guardar_marca_visible(origen,ciudad,indice,1);		                       
} 
 

 function guardar_marca(origen,ciudad,id,marcado)
{
  var ale='&gg'+(Math.floor(Math.random()*50000))+'=1'
  r = ajax.load('<?php echo $base_scripts ?>guardar_marca.php?origen='+origen+'&id=' + id + '&ciudad='+ciudad+'&marcado='+marcado+ale);                                                 
}	 

function guardar_marca_especial(origen,ciudad,id,marcado)
{
  var ale='&gg'+(Math.floor(Math.random()*50000))+'=1';
  r = ajax.load('<?php echo $base_scripts ?>guardar_marca_especial.php?origen='+origen+'&id=' + id + '&ciudad='+ciudad+'&marcado='+marcado+ale);                                                 
}	 



function guardar_marca_visible(origen,ciudad,id,visible)           
{
  var ale='&gg'+(Math.floor(Math.random()*50000))+'=1';
  r = ajax.load('<?php echo $base_scripts ?>guardar_marca_visible.php?origen='+origen+'&id=' + id + '&ciudad='+ciudad+'&visible='+visible+ale);                                                 
}	 


function eliminar_marcas()
{
  var ale='&gg'+(Math.floor(Math.random()*50000))+'=1';  
  r = ajax.load('<?php echo $base_scripts ?>eliminar_marcas.php?a=1'+ale);                                                 
}



	 
function canjear()       
{          
	//$('#colorbox').css('cursor','wait');
	document.body.style.cursor='wait';
	$('[id^=indice]').each(              
		function()
		{	
			if ($('#marcado'+$(this).val()).val()=='1')
			{
				//alert($('#marcado'+$(this).val()).val()+'-'+$('#ciudad'+$(this).val()).val());                                                 
				canjear_reserva($(this).val(),$('#marcado'+$(this).val()).val(),$('#ciudad'+$(this).val()).val());                                                                  
			}
		}
	);
	
	buscar_reservas_canjear();	                 
	eliminar_marcas();            
	//$('#colorbox').css('cursor','default');
	document.body.style.cursor='default';
	alert('Las reservas seleccionadas han sido canjeadas.');
	
}         

function canjear_reserva(id,marcado,ciudad) 
{
  var ale='&gg'+(Math.floor(Math.random()*50000))+'=1'
  r = ajax.load('<?php echo $base_scripts ?>canjear_reserva.php?id=' + id + '&ciudad='+ciudad+'&marcado='+marcado+ale);                                                 
}
 

function marcar_reservas_especiales()       
{          
	//$('#colorbox').css('cursor','wait');
	document.body.style.cursor='wait';
	var tipo;
	var marca;
	var ciudad;
	$('[id^=indice]').each(              
		function()
		{	
			
			if ($('#marcado'+$(this).val()).val()=='1')     
			{ 
				tipo=$('#tipo'+$(this).val()).val();
				marca=($('#marcado'+$(this).val()).val()=='1')?0:1;             
				ciudad=$('#ciudad'+$(this).val()).val();
				
				
				marcar_especial($(this).val(),tipo,marca,ciudad,1);
			}
		}
	);
	
	buscar_reservas_canjear();	                 
	eliminar_marcas();            
	//$('#colorbox').css('cursor','default');
	document.body.style.cursor='default';
	alert('Las reservas seleccionadas han sido marcadas como especiales.');
	
}         



 
 
function edita_busqueda(ciudad,tipo,id) //quan esborres pilot  
{
  var ale='&gg'+(Math.floor(Math.random()*50000))+'=1';
  id_('msg_error').innerHTML='';
  document.getElementById('form_alta').reset()
  $(".form_").colorbox({width:"60%", inline:true, href:"#form_",open:true});
  var cbclose=$.colorbox.close;  
  $.colorbox.close = function ()
    {
        buscar_reservas_canjear(); 
		//cbclose();
		$.colorbox.close = cbclose;
    }
  //id_('alta').style.display="block"
  r=ajax.load('<?php echo $base_scripts ?>ajax.php?id_edita='+id+ale+'&ciudad='+ciudad+'&tipus='+tipo);   
  eval(r);
  id_('edicio').value='true';
}

 
 function envia_formulari_busqueda() 
 {
    var ale='&gg'+(Math.floor(Math.random()*50000))+'=1'    
    var dades=obtenirDadesForm('form_alta');
	//alert(dades);
	var plazas=0;
	//alert(tipus_ev.substr(-15));
	//alert(dades);
	//alert(tipus_ev+' - '+tipus_ev.substr(-15));
    switch(tipus_ev.substr(-15))
    {
		case 'ruta_turistica1':
	    	plazas=1;
	    break;
    	case 'ruta_turistica2':
        	plazas=2;
        break;
		case 'ruta_turistica3':
	    	plazas=3;
	    break;
		case 'ruta_turistica4':
	    	plazas=5;
	    break;
    }

if (plazas>0) 
    {
	       if (!confirm('Si es la primera vez que modifica esta reserva se van a crear '+plazas+' reservas para la ruta.'+descripcion_ruta(tipus_ev)+ ' \nEn caso contrario se van a modificar todas las plazas asociadas a esta reserva. Esta seguro?'))
				return;
    }        

	//alert('diasel '+dia_sel);
    r=ajax.load('<?php echo $base_scripts ?>ajax.php?'+dades+ale+'&ciudad='+ciudad_aux);
    var ok=/OK/;
    if (ok.test(r)) 
    { 
     // recarrega graella
     //alert(r)
	  buscar_reservas_canjear();
	  id_('msg_error').innerHTML='RecepciÃ³n correcte';
      id_('alta').style.display="none"
    } 
    else 
    {    
     //id_('msg_error').innerHTML=r;
     alert(r);
     //get_graella(dia_sel)
	 buscar_reservas_canjear();
    }
}

 
</script>

