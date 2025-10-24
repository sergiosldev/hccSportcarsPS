
<div class="cl" ></div>


<!-- mts 3092012, reestructuració menú.
<div  style="padding-top:4px;padding-bottom:1px;padding-left:3px;border:1px solid #aaa;background-image:url(../img/barra_.png)">
<a style="color:#333;"  href="javascript:print_pdf('m')"><img src="<?php echo URL_ROOT ?>img/printButton.png" alt="" /> MAÑANA PDF</a> 
<a style="color:#333;"  href="javascript:print_pdf('t')"><img src="<?php echo URL_ROOT ?>img/printButton.png" alt="" /> TARDE PDF</a> 


<a style="color:#333;"  href="javascript:print_g('m')"><img src="<?php echo URL_ROOT ?>img/printButton.png" alt="" /> MAÑANA</a> 
<a  href="javascript:print_g('t')"><img src="<?php echo URL_ROOT ?>img/printButton.png" alt="" /> TARDE</a>  
<!-<a class='example8' href="#"><img width="22px" alt="" src="tabs/img/email.png"> ENVIAR CORREOS</a>--
<a  href="javascript:abrir_cerrar(1)"><img width="22px" alt="" src="tabs/img/email.png"> ENVIAR MAILS</a>
<a  href="javascript:ocupar_tarde()"><span style="border:1px solid #f00;background:#f00;padding:1px">&nbsp;&nbsp;</span> OCUPA TARDE</a>
<a  href="javascript:descarga_mails_all()"><span style="color:#f33;font-weight:bold;font-size:15px">@</span> EMAILS TODOS</a>
<a  href="javascript:descarga_mails_dia()"><span style="color:#f33;font-weight:bold;font-size:15px">@</span> EMAILS DIA</a>
<a  href="javascript:descarga_mails_dia_conf()"><span style="color:#f33;font-weight:bold;font-size:15px">@</span> EMAILS CONF</a>


<a class='buscar_contact' href="#"><img width="22px" alt="" src="../modules/yasearch/logo.gif">  BUSCAR</a>
<a class='form_' href="#"></a>
</div>
-->

<div  style="padding-top:4px;padding-bottom:1px;padding-left:3px;border:1px solid #aaa;background-image:url(../img/barra_.png)">
<a style="color:#333;"  href="javascript:mostrar_menu_print()"><img src="<?php echo URL_ROOT ?>img/printButton.png" alt="" /> IMPRIMIR</a> 
<a  href="javascript:ocultar_menus();abrir_cerrar(1);"><img width="22px" alt="" src="tabs/img/email.png"> ENVIAR MAILS</a>
<a  href="javascript:ocupar_horas('m');ocultar_menus()"><span style="border:1px solid #f00;background:#f00;padding:1px">&nbsp;&nbsp;</span> OCUPA M.</a>
<a  href="javascript:ocupar_horas('t');ocultar_menus()"><span style="border:1px solid #f00;background:#f00;padding:1px">&nbsp;&nbsp;</span> OCUPA T.</a>
<a  href="javascript:ocupar_horas('mt');ocultar_menus()"><span style="border:1px solid #f00;background:#f00;padding:1px">&nbsp;&nbsp;</span> OCUPA M. Y T.</a>
<a  href="javascript:mostrar_menu_emails_ciudad();limpiar_fechas();"><span style="color:#f33;font-weight:bold;font-size:15px">@</span> EMAILS CIUDAD</a>
<a  href="javascript:mostrar_menu_emails()"><span style="color:#f33;font-weight:bold;font-size:15px">@</span> EMAILS DIAS</a>
<a  href="javascript:descargar_cupones()"><span style="color:#f33;font-weight:bold;font-size:15px">@</span> DESCARGAR CUPONES SERV.</a>
<a class='buscar_contact' onclick="ocultar_menus();" href="#"><img width="22px" alt="" src="../modules/yasearch/logo.gif">  BUSCAR</a>
<!--document.getElementById('print').display='block';document.getElementById('emails').display='none';-->
</div>
<!--
<div  id="print" style="display:none;padding-top:4px;padding-bottom:1px;padding-left:3px;border:1px solid #aaa;background-image:url(../img/barra_.png)">
<a style="color:#333;"  href="javascript:print_pdf('m')"><img src="<?php echo URL_ROOT ?>img/printButton.png" alt="" /> MAÑANA PDF</a> 
<a style="color:#333;"  href="javascript:print_pdf('t')"><img src="<?php echo URL_ROOT ?>img/printButton.png" alt="" /> TARDE PDF</a> 
<a style="color:#333;"  href="javascript:print_pdf('mt')"><img src="<?php echo URL_ROOT ?>img/printButton.png" alt="" /> MAÑANA Y TARDE PDF</a> 
</div>
-->
<div  id="print" style="display:none;padding-top:4px;padding-bottom:1px;padding-left:3px;border:1px solid #aaa;background-image:url(../img/barra_.png)">
    <a style="color:#333;"  href="javascript:mostrar_menu_print_organizador()"><img src="<?php echo URL_ROOT ?>img/printButton.png" alt="" /> ORGANIZADOR</a> 
    <!--<a style="color:#333;"  href="javascript:mostrar_menu_print_instructor()"><img src="<?php echo URL_ROOT ?>img/printButton.png" alt="" /> INSTRUCTOR</a> -->
	<a style="color:#333;"  href="javascript:document.getElementById('print_organizador').style.display='none';javascript:print_excel('i')"><img src="<?php echo URL_ROOT ?>img/printButton.png" alt="" /> INSTRUCTOR</a> 
	<a style="color:#333;"  href="javascript:document.getElementById('print_organizador').style.display='none';javascript:print_excel('todos')"><img src="<?php echo URL_ROOT ?>img/printButton.png" alt="" /> INSTRUCTOR (20km+7km)</a> 
	</div>
<div id="print_organizador" style="display:none;padding-top:4px;padding-bottom:1px;padding-left:3px;border:1px solid #aaa;background-image:url(../img/barra_.png)">
    <!--<a style="color:#333;"  href="javascript:print_pdf('m')"><img src="<?php echo URL_ROOT ?>img/printButton.png" alt="" /> MAÑANA PDF</a>-->
	<a style="color:#333;"  href="javascript:print_organizadores('m')"><img src="<?php echo URL_ROOT ?>img/printButton.png" alt="" /> MAÑANA PDF</a>
    <a style="color:#333;"  href="javascript:print_organizadores('t')"><img src="<?php echo URL_ROOT ?>img/printButton.png" alt="" /> TARDE PDF</a> 
    <a style="color:#333;"  href="javascript:print_organizadores('mt')"><img src="<?php echo URL_ROOT ?>img/printButton.png" alt="" /> MAÑANA Y TARDE PDF</a> 
    <a style="color:#333;"  href="javascript:print_organizadores_20km7km()"><img src="<?php echo URL_ROOT ?>img/printButton.png" alt="" /> MAÑANA Y TARDE (20km+7km) PDF</a> 
    <a style="color:#333;"  href="javascript:print_organizadores_20km7km_todos()"><img src="<?php echo URL_ROOT ?>img/printButton.png" alt="" /> MAÃ‘ANA Y TARDE (20km+7km TODOS) PDF</a> 
	
</div>

<div id="print_instructor" style="display:none;padding-top:4px;padding-bottom:1px;padding-left:3px;border:1px solid #aaa;background-image:url(../img/barra_.png)">
    <a style="color:#333;"  href="javascript:print_excel('i')"><img src="<?php echo URL_ROOT ?>img/printButton.png" alt="" /> INSTRUCTORES</a> 
</div>


<div  id="emails" style="display:none;padding-top:4px;padding-bottom:1px;padding-left:3px;border:1px solid #aaa;background-image:url(../img/barra_.png)">
<a  href="javascript:descarga_mails_dia()"><span style="color:#f33;font-weight:bold;font-size:15px">@</span> EMAILS DIA</a>
<a  href="javascript:descarga_mails_dia_conf()"><span style="color:#f33;font-weight:bold;font-size:15px">@</span> EMAILS CONF</a>
</div>

<div  id="emails_ciudad" style="display:none;height:46px;padding-top:4px;padding-bottom:1px;padding-left:1px;border:1px solid #aaa;background-image:url(../img/barra_.png)">
 <div style="height:23px;">
	<input type="hidden" name= "fdesde" id="fdesde" value="">
	<input type="hidden" name= "fhasta" id="fhasta" value="">
	<!-- Fecha Desde -->			
	<div style="float:left;padding-right:6px;">
	   <span style="float:left;padding-top:2px;padding-left:3px;padding-right:4px;">F.Desde</span>
	   <div style="float:left;">
			<select id="dia_fdesde" name="dia_fdesde" width="10px;" onchange="actualizar_fecha('dia_fdesde','mes_fdesde','any_fdesde','fdesde',0);"> 
				<?php for($dia=1;$dia<=31;$dia++) { ?>
				<option  value="<?php echo($dia);?>"><?php echo($dia);?></option>
				<?php } ?> 
				<option value='0' selected = "selected"></option>
			</select>    
		</div>
		<div style="float:left;">
			<select id="mes_fdesde" name="mes_fdesde"  width="10px;" onchange="actualizar_fecha('dia_fdesde','mes_fdesde','any_fdesde','fdesde',1);">
				<?php for($mes=1;$mes<=12;$mes++) { ?>
				<option  value="<?php echo($mes);?>"><?php echo($mes);?></option>
				<?php } ?> 
				<option value='0' selected = "selected"></option>
			</select>    
		</div>
		<div style="float:left;"> 
			<select id="any_fdesde" name="any_fdesde" width="10px;" onchange="actualizar_fecha('dia_fdesde','mes_fdesde','any_fdesde','fdesde',2);">
				<?php $any1 = date('Y');
				for($any=$any1;$any>=$any1-10;$any--) { ?>
				<option value="<?php echo($any);?>"><?php echo($any);?></option>
				<?php } ?> 
				<option value='0' selected = "selected"></option>
			</select>    
		</div>
	</div>

	<!-- Fecha Hasta -->			
	<div style="float:left;padding-right:6px;">
	   <span style="float:left;padding-top:2px;padding-left:3px;padding-right:4px;margin-left:20px;margin-right:10px;">F.Hasta</span>
	   <div style="float:left;">
			<select id="dia_fhasta" name="dia_fhasta" width="10px;" onchange="actualizar_fecha('dia_fhasta','mes_fhasta','any_fhasta','fhasta',0);"> 
				<?php for($dia=1;$dia<=31;$dia++) { ?>
				<option value="<?php echo($dia);?>"><?php echo($dia);?></option>
				<?php } ?> 
				<option value='0' selected = "selected"></option>
			</select>    
		</div>
		<div style="float:left;">
			<select id="mes_fhasta" name="mes_fhasta"  width="10px;" onchange="actualizar_fecha('dia_fhasta','mes_fhasta','any_fhasta','fhasta',1);">
				<?php for($mes=1;$mes<=12;$mes++) { ?>
				<option  value="<?php echo($mes);?>"><?php echo($mes);?></option>
				<?php } ?> 
				<option value='0' selected = "selected"></option>
			</select>    
		</div>
		<div style="float:left;"> 
			<select id="any_fhasta" name="any_fhasta" width="10px;" onchange="actualizar_fecha('dia_fhasta','mes_fhasta','any_fhasta','fhasta',2);">                         
				<?php $any1 = date('Y');
				for($any=$any1;$any>=$any1-10;$any--) { ?>
				<option value="<?php echo($any);?>"><?php echo($any);?></option>
				<?php } ?> 
				<option value='0' selected = "selected"></option>
			</select>    
		</div>
	   </div>
		
	   <div style="padding-left:6px;padding-right:5px;">
	   <span style="float:left;border:1px solid #D2D2D2;background:#D2D2D2;padding:3px 0 3px 0;font-size:6px;line-height:15px;margin-left:18px;margin-right:15px;">&nbsp;</span>
			<div style="float:left;padding-right:2px;margin-left:10px;" ><input type="radio" id='cferrari' name="tipoc" value="ferrari" onClick="id_('tipo_coche').value=this.value;">Ferrari</div>
			<div style="float:left;padding-right:2px;margin-left:10px;" ><input  style="float:left;" id='clambo' type="radio" name="tipoc" value="lamborghini" onClick="id_('tipo_coche').value=this.value;">Lamborghini</div>
			<div style="float:left;padding-right:2px;margin-left:10px;" ><input  style="float:left;" id='cferrarilambo' type="radio" name="tipoc" value="ferrari_lamborghini" onClick="id_('tipo_coche').value=this.value;">Ferrari y Lamborghini</div>
			<div style="float:left;padding-right:18px;margin-left:10px;" ><input  style="float:left;" id='ctodos' type="radio" name="tipoc" value="todos" onClick="id_('tipo_coche').value=this.value;">Todos</div>
			<input type="hidden" id="tipo_coche">
		</div>
		<div style="float:left;padding-right:14px;margin-top:-2px;"> 
			<span style="float:left;border:1px solid #D2D2D2;background:#D2D2D2;padding:3px 0 3px 0;font-size:6px;line-height:15px;margin-left:10px;margin-right:20px;">&nbsp;</span>			
			<a href="javascript:limpiar_fechas();"><img width="22px" alt="" src="tabs/img/limpiar.jpg">Limpiar</a>
		</div>
	</div>
<script>


function limpiar_fechas()
{
    id_('ctodos').checked='checked';
	limpiar_fecha('dia_fdesde','mes_fdesde','any_fdesde','fdesde');limpiar_fecha('dia_fhasta','mes_fhasta','any_fhasta','fhasta');
}
function validar_fechas()
{
if (validar_fecha(id_('dia_fdesde').value,id_('mes_fdesde').value,id_('any_fdesde').value) && validar_fecha(id_('dia_fhasta').value,id_('mes_fhasta').value,id_('any_fhasta').value))
return true;
else {alert('Error al introducir las fechas');return false;}
}
</script>
<div style="width:984px;float:left;">
<a  class="boton_descarga" href="javascript:if (validar_fechas()) descarga_mails_barcelona(id_('tipo_coche').value,id_('fdesde').value,id_('fhasta').value)"><span style="color:#f33;font-weight:bold;font-size:15px">@</span> BARCELONA </a>
<a  class="boton_descarga"   href="javascript:if (validar_fechas()) descarga_mails_madrid(id_('tipo_coche').value,id_('fdesde').value,id_('fhasta').value)" style="width:90px;"><span style="color:#f33;font-weight:bold;font-size:15px">@</span> MADRID </a>
<a  class="boton_descarga"   href="javascript:if (validar_fechas()) descarga_mails_valencia(id_('tipo_coche').value,id_('fdesde').value,id_('fhasta').value)"><span style="color:#f33;font-weight:bold;font-size:15px">@</span> VALENCIA </a>
<a  class="boton_descarga"   href="javascript:if (validar_fechas()) descarga_mails_andalucia(id_('tipo_coche').value,id_('fdesde').value,id_('fhasta').value)"><span style="color:#f33;font-weight:bold;font-size:15px">@</span> ANDALUCÍA</a>
<a  class="boton_descarga"   href="javascript:if (validar_fechas()) descarga_mails_cantabria(id_('tipo_coche').value,id_('fdesde').value,id_('fhasta').value)"><span style="color:#f33;font-weight:bold;font-size:15px">@</span> CANTABRIA</a>
<a  class="boton_descarga"   href="javascript:if (validar_fechas()) descarga_mails_all(id_('tipo_coche').value,id_('fdesde').value,id_('fhasta').value)" style="width:158px;"><span style="color:#f33;font-weight:bold;font-size:15px;">@</span> TODOS LOS EMAILS</a>
</div>
</div>

<style>
	a.boton_descarga {display:block;width:110px;float:left;}
</style>


<a class='form_' href="#"></a>
<!-- fin mts 30092012 -->
</div>