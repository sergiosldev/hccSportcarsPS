	<?
	global $cookie;
	$id_acceso_usuarios1 = array(12);
	$id_acceso_usuarios2 = array(13);
	$id_acceso_usuarios3 = array(14);	
	if (in_array($cookie->id_employee,$id_acceso_usuarios1)) $perfil=1;
	else if (in_array($cookie->id_employee,$id_acceso_usuarios2)) $perfil=2;
	else if (in_array($cookie->id_employee,$id_acceso_usuarios3)) $perfil=3;
	else $perfil=0;
	include_once(dirname(__FILE__).'/../../../config.inc.php');
	$opciones=db::getInstance()->executeS('select * from plataformas ');
	$empresas=db::getInstance()->execute('select id_empresa,nombre from empresas');
	?>
	<div id="alta" style="display:none;float:left;width:100%;" >
	<div id='form_' style='text-align:left;padding:10px; background:#fff;'>
	<fieldset>
    <legend>Altas / Modificaciones <a href="javascript:ocultar_form()" >X</a></legend>
	<div id="msg_error"></div>	
	<FORM ACTION="javascript:;" onsubmit="envia_formulari()" METHOD="POST" id="form_alta_res" name="form_alta_res">
    <table><tr><td align="left" valign="top">
		  <table >
		    <tr><td colspan="2" class="cabecera" align="left">Datos piloto</td></tr>
		   <tr>
		    <td><br><span class="label_">Nombre piloto</span><span style="color:#f00"></span></td>
		    <td><br><INPUT TYPE="text" NAME="pilot" id="pilot1"></td>
		   </tr>
		   <tr>
		    <td><span class="label_">Apellidos piloto</span><span style="color:#f00"></span></td>
		    <td><INPUT TYPE="text" NAME="apellidos_piloto" id="apellidos_piloto1"></td>
		   </tr>
		   <tr>
		    <td><span class="label_">Email</span><span style="color:#f00"></span></td>
		    <td><INPUT TYPE="text" NAME="email" id="email11"></td>
		    </tr>
		    <tr>
			<td valign="top"><span class="label_">Teléfono</span><span style="color:#f00"></span></td>
			<td ><INPUT TYPE="text" NAME="telefon" id="telefon1">
			
		   <INPUT TYPE="hidden" id="edicio11" NAME="edicio" value="false" >
		   <INPUT TYPE="hidden" id="id_alta1" NAME="id_alta" >
		   <INPUT TYPE="hidden" id="tipus11" NAME="tipus" value='' >
		   <INPUT TYPE="hidden" id="id_inscrit1" NAME="id_inscrit" >
		   <INPUT TYPE="hidden" id="ciudad" NAME="ciudad" value='' >
		   </td>
		   </tr>
		   <tr>
		    <td><span class="label_">Email confirmacion</span><span style="color:#f00"></span></td>
		    <td><INPUT TYPE="text" NAME="email1" id="email_confirm1"></td>
		    </tr>
		   <!--<tr>
		    <td>Tipus event</td>	
		   <td><select name="tipus">
		   	  <option value="porsche">porsche</option>
			  <option value="ferrari">ferrari</option>
		   </select></td>	
		   </tr> -->
		  
		   </table>
	   </td>
	   <td align="left" valign="top">		   
		   <table style="display:inline">
		   <tr><td colspan="2" align="left" class="cabecera" >Datos persona que regala</td></tr>
		   <tr>
		    <td><br><span class="label_">Nombre</span></td>
		    <td><br><INPUT TYPE="text" NAME="persona_regala" id="persona_regala1"></td>
		   </tr>
		   <tr>
		    <td><span class="label_">Apellidos</span></td>
		    <td><INPUT TYPE="text" NAME="apellidos_persona_regala" id="apellidos_persona_regala1"></td>
		   </tr>
		   <tr>
		    <td><span class="label_">Email</span></td>
		    <td><INPUT TYPE="text" NAME="email_regala" id="email_regala1" onchange=""></td>
		    </tr>
		    <tr>
			<td><span class="label_">Teléfono</span></td>
			<td><INPUT TYPE="text" NAME="telefon_regala" id="telefon_regala1"></td>
		   </tr>
		   <tr>
            <td><span class="obligatorio">*</span>Sexo</td>
                <td ><table><tr>
                    <td class="seleccion_radio" style="width:132x;color:#ffffff;">Hombre:<input type="radio" name="sexo" id="sexo1" value="Hombre" checked="checked" style="width:10px" <?php echo(($usuario->sexo==1)?'checked':'');?> /><br />                 
                    </td>
                    <td class="seleccion_radio" style="color:#ffffff;">Mujer:<input type="radio" name="sexo" id="sexo2" value="Mujer" style="width:10px" <?php echo(($usuario->sexo==2)?'checked':'');?> /><br />                                                                                            
                    </td>
                </tr></table>
            </td>		   
			</tr>
			<tr>
			<td>Fecha de nacimiento&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>			
			<td>
				<table cellpadding="0" cellspacing="0">
					<tr>
					<td>
					<?php 
					
						$usuario=new Usuario();
						/*if ($usuario->fechaNacimiento!='0000-00-00' and $usuario->fechaNacimiento!='')
						{
							$fnac=(substr($usuario->fechaNacimiento,8,2).'/'.substr($usuario->fechaNacimiento,5,2).'/'.substr($usuario->fechaNacimiento,0,4));                                                                                                             
						}
						else						
						{
							$fnac='01/01/'.date('Y');                                   
						}*/
					   $fnac='01/01/'.date('Y');                                   
					   list($dia_ini,$mes_ini,$any_ini) = explode('/',$fnac);
					?>       
						<input type="hidden" name= "fecha_nacimiento" id="fecha_nacimiento" value="<?php echo($fnac);?>" />
						<select id="dia_nac" name="dia_nac" style="width:50px;" onchange="actualizar_fecha_nacimiento(0);"> 
							<?php for($dia=1;$dia<=31;$dia++) { ?>
							<option <?php if ($dia==$dia_ini) echo('selected = "selected"');?> value="<?php echo($dia);?>"><?php echo($dia);?></option>
							<?php } ?> 
						</select>    
					</td>
					<td>
						<select id="mes_nac" name="mes_nac" style="width:50px;" onchange="actualizar_fecha_nacimiento(1);">
							<?php for($mes=1;$mes<=12;$mes++) { ?>
							<option <?php if ($mes==$mes_ini) echo('selected = "selected"');?> value="<?php echo($mes);?>"><?php echo($mes);?></option>
							<?php } ?> 
						</select>    
					</td>
					<td> 
						<select id="any_nac" name="any_nac" style="width:61px;" onchange="actualizar_fecha_nacimiento(2);">
							<?php $any1 = date('Y');
							for($any=$any1;$any>=$any1-150;$any--) { ?>
							<option <?php if ($any==$any_ini) echo('selected = "selected"');?> value="<?php echo($any);?>"><?php echo($any);?></option>
							<?php } ?> 
						</select>    
					</td>    
					</tr>
				</table>			
			</td>
			</tr>
            <tr>
            <td>Contrase&ntilde;a</td>
            <td colspan="2"><input type="password" name="password" id="password1" value="" /><br />
            </td>
            </tr>
			
            <tr>
            <td>Dni/Nie</td>
            <td colspan="2"><input type="text" name="nif" id="nif1" value="<?php echo($usuario->nif);?>" /><br />      
            </td>
            </tr>

            <tr>    
            <td>Direccion</td>
            <td colspan="2"><input type="text" name="direccion" id="direccion1" style="width:250px" value="<?php echo($usuario->direccion);?>" /><br />
            </td>
            </tr>
            <tr>  
            <td>Codigo Postal</td>
            <td colspan="2"><input type="text" name="codigo_postal" id="codigo_postal1" value="<?php echo($usuario->cPostal);?>" onkeypress="return onlyNumbersDano(event)" /><br />
            </td>
            </tr>
            <tr>
            <td>Ciudad</td>
            <td colspan="2"><input type="text" name="poblacion" id="poblacion1" value="<?php echo($usuario->poblacion);?>" /><br />
            </td>
            </tr>
		  
		   <tr>	
		   <td colspan="2" align="right">
		   <?php if ($perfil!=3) 
		   {
		   ?>
		   <INPUT TYPE="submit" class="boto" value="Guardar" > 
		   <INPUT TYPE="Reset" class="boto" value="Limpia"> </td>
		   <?php 
		   }
		   ?>
		   </tr>
		   
		   </table>
	   </td></tr></table>
	   <table width="100%">
	   	    <tr id="tipus_field1">
	   	      <td colspan="2">
	   	      	<fieldset style="width:150px">
    <legend>Tipo evento</legend>
	
	<table width="100%" border="0" style="display:inline">
    <!--
	<tr>
        <td align="center" style="background:#ffcc77;">
	
	<span class="label_g" style="color:#000">Porsche </span><input id="rporsche" type="radio" name="tipus_ev" value="porsche" checked="checked"  style="margin-right:10px"  onchange="canvia_tipus_2('porsche996')">
	
	<span class="label_g">porsche997 </span><input id="rporsche" type="radio" name="tipus_ev" value="porsche" style="margin-right:10px" onchange="canvia_tipus_2('porsche997')">
	
	   </td>
    </tr> -->
    <tr>
      <td  style="background:#ff0000;">
        <input type="radio" id="rpp" name="tipus_ev" value="lotus" style="margin-right:10px"  onchange="canvia_tipus_2('porsche997_porsche996')">
        <span class="label_g" style="color:#fff" > Porsche996 + Porsche997 </span>
	</td>
    </tr>
</table>
<table width="300" border="0" style="display:inline">
    <tr>
        <td  style="background:#ffcc77;">
	<input type="radio" id="rpp" name="tipus_ev" value="lotus" style="margin-right:10px"  onchange="canvia_tipus_2('ferrari')">
    <span class="label_g" style="color:#000">Ferrari </span>
  </td>
    </tr>
    <tr>
      <td  style="background:#ff0000;">	
	<input type="radio" id="rpp" name="tipus_ev" value="lotus" style="margin-right:10px"  onchange="canvia_tipus_2('ferrari_porsche901')">
    <span class="label_g" style="color:#fff"> Ferrari + Porsche911 </span>
  </td>
    </tr>
</table>
<table width="300" border="0" style="display:inline">
    <tr>
      <td  style="background:#ffcc77;">
	   <input type="radio" id="rpp" name="tipus_ev" value="_porsche_" style="margin-right:10px"  onchange="canvia_tipus_2('_porsche_')">
       <span class="label_g" style="color:#000">Porsche </span>
     </td>
    </tr>
    <tr>
      <td  style="background:#ffcc77;">
	    <input type="radio" id="rpp" name="tipus_ev" value="_lotus_" style="margin-right:10px"  onchange="canvia_tipus_2('_lotus_')">
        <span class="label_g" style="color:#000">Lotus </span>
      </td>
    </tr>   
</table>


<table width="300" border="0" style="display:inline">
    <tr>
      <td  style="background:#ffcc77;">
	   <input type="radio" id="rpp" name="tipus_ev" value="lotus" style="margin-right:10px"  onchange="canvia_tipus_2('lamborghini')">
       <span class="label_g" style="color:#000">Lamborghini </span>
	  </td>
    </tr>
    <tr>
      <td  style="background:#ff0000;">
	   <input type="radio" id="rpp" name="tipus_ev" value="lotus" style="margin-right:10px"  onchange="canvia_tipus_2('lamborghini_lotus')">
       <span class="label_g" style="color:#fff"> Lamborghini + Lotus </span>
	  </td>
    </tr>
</table>
  </fieldset>	
				
	   	      </td>	
		    </tr> 
	   	    <tr>
		    <td colspan="1"><span class="label_">Origen</span></td>
		    <td colspan="1" class="bottom">
			<!--<INPUT TYPE="text" NAME="origen" id="origen1">-->
			<select id="origen1" name="origen" data-valor="Origen">
               <option value="0">Elija un orígen</option>
               <?php foreach($opciones as $opcion)
			   {?>
                   	<option value="<?php echo($opcion['valor']);?>"><?php echo($opcion['nombre']);?></option>
				<?php 
			   }?>				
            </select>			
			</td>
		    </tr>
	   	    <tr>
		    <td colspan="1"><span class="label_">Vehículo</span></td>
		    <td colspan="1" class="bottom"><label id="vehiculo"></label></td>
		    </tr>
			<tr>
		    <td colspan="1"><span class="label_">Código Localizador</span><span style="color:#f00"></span></td>
		    <td colspan="1" class="bottom"><INPUT TYPE="text" NAME="codigo_localizador" id="codigo_localizador1"></td>
		    </tr>
		    <tr>
			<td colspan="1"><span class="label_">Código Consumo</span><span style="color:#f00"></span></td>
			<td colspan="1" class="bottom"><INPUT TYPE="text" NAME="codigo_consumo" id="codigo_consumo1"></td>  
		   </tr>
            <tr>
            <td colspan="1"><span class="label_">Fecha de Reserva</span><span style="color:#f00"></span></td>
            <td colspan="1" class="bottom"><INPUT TYPE="text"  NAME="fecha_reserva" id="fecha_reserva1" disabled="disabled"> </td>
           </tr>		    
		   <tr>
			<td colspan="1" valign="top"><span class="label_"><br>Observaciones</span><span style="color:#f00"></span></td>
			<td colspan="1" class="bottom"><br><textarea rows="3" cols="50" NAME="Observaciones" id="Observaciones1" ></textarea></td>
		   </tr>
			<select id="mpresa" name="empresa" data-valor="Empresa">
               <option value="-1">Elija una empresa</option>
               <?php foreach($empresas as $empresa)
			   {?>
                   	<option value="<?php echo($empresa['id_empresa']);?>"><?php echo($empresa['nombre']);?></option>
				<?php 
			   }?>				
            </select>			
	   </table><br>
	   <span class="label_">Campos obligatorios</span><span style="color:#f00">*</span>
	</FORM> 
	</fieldset>
	</div>
	</div>
<script  type="text/javascript">
//
//<![CDATA[

  
  function buscar_en_lista(buscado,lista)
  {
      for(var i=0;i<lista.options.length;i++)
      {
          if (lista.options[i].value==buscado)
          {
              lista.selectedIndex = i;
              break;
          }
      }
  }
  
  
  
  function actualizar_fecha_nacimiento(elem)  
    {
        //alert(lpad('k','22',1));
        var dia = id_('dia_nac').value.toString();
        var mes = id_('mes_nac').value.toString();
        var any = id_('any_nac').value.toString();
        
        if (esFechaValida(dia,mes,any))
        {        
            if (dia+mes+any!='')
                id_('fecha_nacimiento').value = lpad('0',dia,2)+'/'+lpad('0',mes,2)+'/'+any;
            else id_('fecha_nacimiento').value = '';
        }
        else 
        {
         switch (elem)
         {
             case 0:   
                dia=parseInt(id_('fecha_nacimiento').value.toString().substring(0,2));
                buscar_en_lista(dia,id_('dia_nac'));
                break;
             case 1:
                //alert(id_('fecha_nacimiento').value.toString().substring(3,5));break;
                mes=parseInt(id_('fecha_nacimiento').value.toString().substring(3,5));
                //alert(mes);
                buscar_en_lista(mes,id_('mes_nac'));
                break;
             case 2:
                 any=parseInt(id_('fecha_nacimiento').value.toString().substring(6,10));
                 buscar_en_lista(any,id_('any_nac'));
                 break;
             default: alert ('parámetro erróneo');
         }   
        }
    }
    
  function esFechaValida(dia,mes,anio)
  {
    switch(mes){
        case '1':case '3':case '5':case '7':case '8':case '10':case '12':
            numDias=31;
            break;
        case '4':case '6':case '9':case '11':
            numDias=30;
            break;
        case '2':
            if (comprobarSiBisiesto(anio)){ numDias=29; }else{ numDias=28;}
            break;
        default:            
            return false;
    }
    if (dia>numDias || dia==0)
    {
         alert("Formato de fecha incorrecto. El mes seleccionado tiene "+numDias+" días ");
         return false;
    }
  return true;  
  }
 
  function comprobarSiBisiesto(anio)
  {
    if ( ( anio % 100 != 0) && ((anio % 4 == 0) || (anio % 400 == 0))) return true;
    else return false;
  }    
  function lpad(caracter,cadena,longitud_final)
  {
      if (longitud_final<cadena.length) return cadena;
      var cadena_final = cadena;
      for (var i = 0;i<longitud_final-cadena.length;i++)
      {
          cadena_final = caracter+cadena_final; 
      }
     return (cadena_final);
  }
  
function validar_enter(event)
{
	if (event.keyCode == 13) {javascript:id_('valida_usuario').value='validar';id_('acceder').click();} 
}
 
//]]> 
</script>