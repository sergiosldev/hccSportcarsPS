<script type="text/javascript">
  function envia_selecciona_vehiculos()
  { 
	  var sel_ferrari=0; 
	  var sel_lamborghini=0;
	  var sel_porsche=0;
	  var sel_corvette=0;
	  var sel_todos=0;
  


	  if($('#sel_ferrari').attr("checked"))
	  { 
	  	sel_ferrari=1;
	  }	

	  if($('#sel_lamborghini').attr("checked"))                          
	  { 
	  	sel_lamborghini=1;
	  }	

	  
	  if($('#sel_porsche').attr("checked"))
	  { 
	  	sel_porsche=1;
	  }	


	  if($('#sel_corvette').attr("checked"))
	  { 
	  	sel_corvette=1;
	  }	
	  
	  if($('#sel_todos').attr("checked"))
	  { 
	  	sel_todos=1;
	  }	
	  

 

	  
	  if (sel_todos==0 && sel_ferrari==0 && sel_lamborghini==0  && sel_porsche==0  && sel_corvette==0)                                         
	  {
			alert('Debe seleccionar el vehÃ­culo');                       
			return;             
	  }   	
     
	                                            
	  var ale='&gg'+(Math.floor(Math.random()*50000))+'=1';                                            
 
	  $.colorbox.close();
	  alert('Se van a generar los listados');
	  //$.colorbox.close();

	  get_graella_organizadores_20km7km_todos(sel_ferrari,sel_lamborghini,sel_porsche,sel_corvette,sel_todos);

	  var ok=/OK/;         

	  if (ok.test(r)) 
	  { 
		  //$.colorbox.close();
	  }
 }  
</script>



<div id="seleccion_vehiculos" style="display:none;float:left;width:100%;">             
    <div id='form_seleccion_vehiculos' style='text-align:left;padding:10px; background:#fff;'>
    <fieldset>
    <legend id="titulo"></legend>
    <div id="msg_error_" style="display:none;"></div>   
    <FORM ACTION="javascript:;" onsubmit="envia_selecciona_vehiculos($('#fecha_sel_vehiculos').val());" METHOD="POST" id="frm_seleccion_vehiculos" name="frm_seleccion_vehiculos">                                               
          <table style="width:300px;">  
            <tr><td colspan="4" class="cabecera" align="left" style="padding-bottom:30px;">Seleccione el veh&iacute;culo:</td></tr>              
            <tr> 
                <td><span class="label_">Ferrari:</span><span style="color:#f00"></span></td>                      
                <td><INPUT TYPE="checkbox" NAME="sel_ferrari" id="sel_ferrari" value="1" checked="checked" onclick="seleccionar('sel_ferrari',this.checked);"></td>                    
                <td class="col_sel_vehiculos"><span class="label_">Lamborghini</span><span style="color:#f00"></span></td>                  
                <td><INPUT TYPE="checkbox" NAME="sel_lamborghini" id="sel_lamborghini" value="1" onclick="seleccionar('sel_lamborghini',this.checked);"></td>                   
                <td class="col_sel_vehiculos"><span class="label_">Porsche</span><span style="color:#f00"></span></td>                  
                <td><INPUT TYPE="checkbox" NAME="sel_porsche" id="sel_porsche" value="1" onclick="seleccionar('sel_porsche',this.checked);"></td>                   
            </tr>
            <tr>
                <td><span class="label_">Corvette</span><span style="color:#f00"></span></td>                  
                <td><INPUT TYPE="checkbox" NAME="sel_corvette" id="sel_corvette" onclick="seleccionar('sel_corvette',this.checked);" value="1"></td>                    
                <td class="col_sel_vehiculos"><span class="label_">Todos</span><span style="color:#f00"></span></td>                  
                <td><INPUT TYPE="checkbox" NAME="sel_todos" id="sel_todos" value="1" onclick="seleccionar('sel_todos',this.checked);"></td>
                <td></td>         
				<td></td>                           
            </tr>
            <tr style="height:20px;">    
                <td colspan="4">&nbsp;</td>
            </tr>            
            </hr>
            <tr>                
                <td style="vertical-align:bottom;text-align:center;">                    
                <br/>           
                    <INPUT id="boton_aceptar" name="boton_aceptar" TYPE="submit" class="boto" value="Aceptar" >                                                                              
                </td>        
                <input type="hidden" id="sel_ferrari_vh" name="sel_ferrari_vh">                  
                <input type="hidden" id="sel_lamborghini_vh" name="sel_lamborghini_vh">                
                <input type="hidden" id="sel_porsche_vh" name="sel_porsche_vh">                  
                <input type="hidden" id="sel_corvette_vh" name="sel_corvette_vh">                   
            </tr>
           </table>
    </FORM>                                      
    <br /> 
    <div id="msg_aviso_vh" style="color:#ff0000;" style="display:none;"></div>   
    </fieldset>
    </div>
</div>

<style type="text/css">
	.col_sel_vehiculos
	{
		padding-left:58px;
	}

</style>
 
<script type="text/javascript">
	function seleccionar(campo, pchecked)
	{
		if (campo=='sel_todos') 
		{
			if (pchecked)
			{
				$('#sel_ferrari').attr('checked',false);
				$('#sel_porsche').attr('checked',false);
				$('#sel_lamborghini').attr('checked',false);
				$('#sel_corvette').attr('checked',false);
				$('#sel_ferrari_vh').val(0);
				$('#sel_porsche_vh').val(0);
				$('#sel_lamborghini_vh').val(0);
				$('#sel_corvette_vh').val(0);
			}
			
			else
			{
				$('#sel_ferrari').attr('checked',true);
				$('#sel_porsche').attr('checked',false);
				$('#sel_lamborghini').attr('checked',false);
				$('#sel_corvette').attr('checked',false);
				$('#sel_ferrari_vh').val(1);
				$('#sel_porsche_vh').val(0);
				$('#sel_lamborghini_vh').val(0);
				$('#sel_corvette_vh').val(0);
			}
			
		}
		else		
		{
				$('#sel_todos').attr('checked',false);
				$('#sel_todos_vh').val(0);
		}
		
	}
</script>