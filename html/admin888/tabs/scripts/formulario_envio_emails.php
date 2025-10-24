<script type="text/javascript">
  function envia_formulario_emails (id_ev,ciudad,id_event,email_alternativo)
  { 
	  envio_cliente=0; 
	  envio_hotel=0;  
  
	  if($('#envio_cliente').attr("checked"))
	  { 
	  	envio_cliente=1;
	  }	

	  if($('#envio_hotel').attr("checked"))
	  { 
	  	envio_hotel=1;
	  }	

	  if (envio_cliente==0 && envio_hotel==0 && $.trim(email_alternativo)=='')                                        
	  {
			alert('Debe seleccionar a quien envia la reserva');                     
			return;             
	  }   	
     
	      
	  var ale='&gg'+(Math.floor(Math.random()*50000))+'=1';                                            

	  //alert('<?php echo $base_scripts ?>ajax.php?enviar_=2&envio_cliente='+envio_cliente+'&envio_hotel='+envio_hotel+'&email_alternativo='+email_alternativo+'&ciudad='+ciudad+ale);
	  ///return;           
	  r=ajax.load('<?php echo $base_scripts ?>ajax.php?email_='+id_ev+'&id_event='+id_event+'&envio_cliente='+envio_cliente+'&envio_hotel='+envio_hotel+'&email_alternativo='+email_alternativo+'&ciudad='+ciudad+ale);                                                             
//	  r=ajax.load('<?php echo $base_scripts ?>ajax.php?email_=' + id + '&ciudad='+ciudad_aux+'&id_event=' + t);
	  var ok=/OK/;         
	  if (ok.test(r)) 
	  { // recarrega graella
		  alert('Emails enviados');
		  $.colorbox.close();
	  }
 }  
 
 $(document).ready(function()
 {
	$('#email_alternativo').val('');
 }
 );
</script>



<div id="envio_emails" style="display:none;float:left;width:100%;">             
    <div id='form_envio_emails' style='text-align:left;padding:10px; background:#fff;'>
    <fieldset>
    <legend id="titulo"></legend>
    <div id="msg_error_" style="display:none;"></div>   
    <FORM ACTION="javascript:;" onsubmit="envia_formulario_emails($('#id_env_').val(),$('#ciudad_env_').val(),$('#id_event_env_').val(),$('#email_alternativo').val());" METHOD="POST" id="frm_envio_emails" name="frm_envio_emails">                                               
          <table>  
            <tr><td colspan="2" class="cabecera" align="left" style="padding-bottom:30px;">Seleccione la acci&oacute;n realizada:</td></tr>         
            <tr> 
                <td><span class="label_">Enviar Cliente:</span><span style="color:#f00"></span></td>                     
                <td><INPUT TYPE="checkbox" NAME="envio_cliente" id="envio_cliente" value="1" checked="checked"></td>                  
                <td><span class="label_">Enviar Hotel:</span><span style="color:#f00"></span></td>                
                <td><INPUT TYPE="checkbox" NAME="envio_hotel" id="envio_hotel" value="1"></td>                   
            </tr>
            <tr style="height:20px;">            
                <td style="padding-top:30px;">
					<span class="label_">Email alternativo:</span>                
                </td>
                <td style="padding-top:30px;" colspan="3">
                	<input id="email_alternativo" name="email_alternativo" type="text">   
                </td>                                            
            </tr>                
            <tr style="height:20px;">    
                <td colspan="3">&nbsp;</td>
            </tr>            
            </hr>
            <tr>                
                <td style="vertical-align:bottom;text-align:center;">                    
                <br/>           
                    <INPUT id="boton_aceptar" name="boton_aceptar" TYPE="submit" class="boto" value="Aceptar" >                                                                              
                </td>        
                <input type="hidden" id="envio_cliente_env" name="envio_cliente_env">                  
                <input type="hidden" id="envio_hotel_env" name="envio_hotel_env">                
                <input type="hidden" id="id_env_" name="id_env_">                  
                <input type="hidden" id="id_event_env_" name="id_event_env_">                  
                <input type="hidden" id="ciudad_env_" name="ciudad_env_">                                                
           </tr>
           </table>
    </FORM>                                      
    <br /> 
    <div id="msg_aviso" style="color:#ff0000;" style="display:none;"></div>   
    </fieldset>
    </div>
</div>
