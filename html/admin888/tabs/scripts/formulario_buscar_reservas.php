<div id="buscar_res" style="display:none;float:left;width:100%;">
    <div id='form_buscar_reserva' style='text-align:left;padding:10px; background:#fff;'>
    <fieldset>
    <legend>Buscar Reservas</legend>
    <div id="msg_error2"></div>   
	<FORM ACTION="javascript:;" onsubmit="buscar_reservas_();"  METHOD="POST" id="frm_buscar_reservas" name="frm_buscar_reservas" style="text-algin:left;margin-left:50px;">
		    <br \>
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
		    <br /><br /><br />
		    <div style="display:block;float:left;">
		    <INPUT class="buscar_pilotos"  TYPE="reset" style="border:1px solid #7766aa;padding:5px;"  value="Limpia">
		    <INPUT class="buscar_pilotos"  TYPE="submit" style="border:1px solid #7766aa;padding:5px;"  value="Busca">
		    </div>
	</FORM>
</fieldset>
 </div> 
</div> 
  

<style type="text/css">
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
   
<script type="text/javascript">
function buscar_reservas_()
{
	var dades=obtenirDadesForm('frm_buscar_reservas');
	var ale='&gg'+(Math.floor(Math.random()*50000))+'=1';
	
	var r=ajax.load('tabs/scripts/buscar_pilotos.php?'+dades+ale);
	
	$('#listado_pilotos').html(r);
	$.colorbox({height:'600px',width:'100%',inline:true, href:'#listado_pilotos',open:true});
}
     

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
     
	 
	 /** inicializar fecha junto deportivo **/
		var _d=dia_sel.split("-"); 
	  _d=_d[2]+'-'+_d[1]+'-'+_d[0];
	  //alert(dia_sel);
	   id_('acciones_dia').innerHTML=''+_d+' &#160;&#160;&#160;&#160;<a style="color:#0f0;background:#0f0;border:1px solid #0f0;padding:1px" href="javascript:ac_dia(\''+dia_sel+'\',1)">&#160;&#160;</a> '+
	   ' <a style="border:1px solid #33f;background:#33f;padding:1px" href="javascript:ac_dia(\''+dia_sel+'\',0)">&#160;&#160;</a>'+
	   ' <a style="border:1px solid #d0629e;background:#d0629e;padding:1px" href="javascript:ac_dia(\''+dia_sel+'\',3)">&#160;&#160;</a>'+
	   ' <a style="border:1px solid #f00;background:#f00;padding:1px" href="javascript:ac_dia(\''+dia_sel+'\',2)">&#160;&#160;</a>' +
	   ' <a style="border:1px solid #888888;background:#888888;padding:1px" href="javascript:ac_dia(\''+dia_sel+'\',4)">&#160;&#160;</a>'+
	   ' <a style="border:1px solid #000000;background:#000000;padding:1px" href="javascript:ac_dia(\''+dia_sel+'\',5)">&#160;&#160;</a>';	 
	 /** fin inicializar fecha **/
	 
	 
	 $('html,body').css("cursor","pointer");
     $.colorbox.close();   
	 window.location='#filagr'+id;
     
}
  

function ir_a_reubicaciones(tipo,ciudad,fecha,id)  
{ 
	$("body").css("cursor", "progress");

     var sciudad;
     if (ciudad!='Barcelona')
     	sciudad=ciudad;
     else sciudad='';
	 
	 sciudad = sciudad.toLowerCase();

	var ale='&gg'+(Math.floor(Math.random()*50000))+'=1';                  
	
	dades='tipo='+tipo;
	dades+='&ciudad='+sciudad;
	dades+='&fecha='+fecha;
	dades+='&id='+id;
	
	var r=ajax.load('tabs/scripts/reubicaciones.php?'+dades+ale);
	
	if (r.indexOf('@ERROR@')!=-1)
	{
		alert('No hay reubicaciones para esta reserva');
	}
	else
	{
		$('#listado_reubicaciones').html(r);
		var bcerrar=$.colorbox.close;
		$.colorbox({width:'82%',inline:true, href:'#listado_reubicaciones',open:true});
		$.colorbox.close=function()
		{
			$.colorbox.close=bcerrar;
			buscar_reservas_();		
		}
	}
	
      
}

  
</script>


	
	