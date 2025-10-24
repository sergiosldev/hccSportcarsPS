<script type="text/javascript">

//Función complementara a validar cupón. Se ejecuta desde el formulario de contraseñas
//cuando tratamos de cancelar un cupón.
//el parámetro dia_sel sólo se utilizará en el botón para marcar eventos del apartado ("events").
function envia_formulario_validar_password (archivo_operacion,archivo_retorno,datos,div_retorno,ancho_div_retorno,password)
  {
    //alert(datos);
	if (password=='') {alert('Debe introducir la contraseña');return;}      
    var aleatorio='&gg'+(Math.floor(Math.random()*50000))+'=1';
    ///alert(dades);
    r=ajax.load('<?php echo $base_scripts ?>ajax_validar_password.php?password='+password+aleatorio);
    //alert(r); 
    if (r.indexOf('error_password')!=-1) {alert('Contraseña incorrecta. Inténtelo de nuevo.'); id_('frm_validar_password').reset();}
    else 
    { 
        //$.colorbox.close();  
        //antes width:80%
        //alert('llamada operacion: '+'<?php echo $base_scripts ?>'+archivo_operacion+'?'+datos+aleatorio);
        
        r=ajax.load('<?php echo $base_scripts ?>'+archivo_operacion+'?'+datos+aleatorio);                 
		//r=ajax_post.load('<?php echo $base_scripts ?>'+archivo_operacion,datos+aleatorio);                 
        //si hemos eliminado el cupón, lo quitaremos de la lista de parámetros para la llamada a la carga del grid de cupones,
        //ya que en caso de recibir un número de cupón lo utiliza para comprobaciones que una vez eliminado ya no tienen sentido.
        //alert(datos);   
        //alert(r);
	
		if (archivo_retorno=='events.php')
		{
			//alert(r);
			//alert(dia_sel);
			var ok=/OK/;
			get_graella(dia_sel);
			id_('alta').style.display="none";
			$.colorbox.close();
			return;          
		}
   

        ru = r.toUpperCase();     
        if (ru.indexOf('OK')==-1) {alert(r);}
        else 
            { 
          //  alert(' colorbox ret '+{width:ancho_div_retorno+"%", inline:true, href:"#"+div_retorno,open:true});
                if (archivo_retorno!='clientes.php' && archivo_retorno!='ofertas.php')
                    $.colorbox({width:ancho_div_retorno+"%", inline:true, href:"#"+div_retorno,open:true}); 
                //alert(datos+aleatorio);    
                r=ajax.load('<?php echo $base_scripts ?>'+archivo_retorno+'?'+datos+aleatorio);  
				//r=ajax_post.load('<?php echo $base_scripts ?>'+archivo_retorno,datos+aleatorio);
				//alert('<?php echo $base_scripts ?>'+archivo_retorno+datos+aleatorio);
				
                if (r.indexOf('error')!=-1)
                {
                    if (archivo_retorno=='cupones_ofertas.php')
                     r = " <div style='font-weight:bold;color:red;font-size:18px;'>No existen cupones para esta oferta</div>";    
                    
                }

                switch(archivo_retorno)
                {
                    case 'clientes.php':
                       id_(div_retorno).innerHTML = r;
                       $.colorbox.close();
                       break;
                    case 'ofertas.php':  
                       id_(div_retorno).innerHTML = r;
                       $.colorbox.close();
                       break;    
                    default:
                        id_(div_retorno).innerHTML = r;   
                }
            }
    }
    

 }

</script>


<div id="validar_password" style="display:none;float:left;width:100%;" >
    <div id='form_validar_password' style='text-align:left;padding:10px; background:#fff;'>
    <fieldset>
    <legend id="titulo"></legend>
    <div id="msg_error"></div>  
    <FORM ACTION="javascript:;" onsubmit="envia_formulario_validar_password (id_('archivo_operacion').value,id_('archivo_retorno').value,id_('datos').value,id_('div_retorno').value,id_('ancho_div_retorno').value,id_('password').value)" METHOD="POST" id="frm_validar_password" name="frm_validar_password">
          <table >
            <tr><td colspan="2" class="cabecera" align="left">Introduzca la contraseña:</td></tr>
            <tr>
                <td><br><span class="label_">Contraseña</span><span style="color:#f00"></span></td>
                <td><br><INPUT TYPE="password" NAME="password" id="password"></td>
                <td  align="right" style="vertical-align:bottom;">
                    <INPUT id="boton_aceptar" name="boton_aceptar" TYPE="submit" class="boto" value="Aceptar" > 
                </td>
                <input type="hidden" id="archivo_operacion" name="archivo_retorno">
                <input type="hidden" id="archivo_retorno" name="archivo_retorno">
                <input type="hidden" id="datos" name="datos">
                <input type="hidden" id ="div_retorno" id="div_retorno">
                <input type="hidden" id="ancho_div_retorno" name="ancho_div_retorno">
            </tr>
           </table>
    </FORM> 
    </fieldset>
    </div>
</div>
