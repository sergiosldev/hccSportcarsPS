<?php

include_once(dirname(__FILE__).'/../../config/config.inc.php');                                                                                                                                                                
include_once(dirname(__FILE__).'/../functions.php');                                                  
 
class AdminEnvios
{
	public function viewAccess($disable = false)
	{
		return true;
	}  
}


$enviar = tools::getValue('enviar');

$envios = new ListadoEnvios();                                                                         

if ($enviar=='1')
{  
	$email_enviar = tools::getValue('email_selec');                                                                                                                      
	$body_enviar = tools::getDecodedValue('body_selec');   
	$asunto_enviar = tools::getDecodedValue('asunto_selec');          
	ListadoEnvios::enviarEmail($email_enviar,$asunto_enviar,$body_enviar);           
}
else
{
	$email_enviar = '';
	$body_enviar = '';
	$asunto_enviar = '';
}


$email = tools::getValue('email');                                                                                                                  
$fecha_desde = tools::getValue('fecha_desde');                           
$fecha_hasta = tools::getValue('fecha_hasta');                        
$fenviado = tools::getValue('tenviado');                                                      
$registro_inicio = (tools::getValue('registro_inicio')=='')?0:tools::getValue('registro_inicio');                                                               
//if (intval($registro_inicio)>0) die($registro_inicio);
$envios->femail=$email;                                        
$envios->ffecha_desde=$fecha_desde;                                
$envios->ffecha_hasta=$fecha_hasta;                                   
$envios->fenviado=$fenviado;                                                                          

$paginacion = new Paginacion();   


$paginacion->numRegistrosPagina = 50;

if (!$envios->actualizarHistorico())
	die('Error al actualizar el histórico');

$total_registros=$envios->getNumRegistros($registro_inicio,$paginacion->numRegistrosPagina);                                                    
$paginacion->numRegistros=$total_registros;

$paginacion->registroInicio=$registro_inicio;


$listado_envios=$envios->get($registro_inicio,$paginacion->numRegistrosPagina);                       



//echo($total_registros.'--'.$nregistros_pagina);              
$numPaginas = $paginacion->numPaginas();
$pagina_actual=$paginacion->pagina();                     
$registro_anterior=$paginacion->registroAnterior();
$registro_siguiente=$paginacion->registroSiguiente();      

$paginacion->registroInicio=$registro_inicio;

$ultima_pagina=$paginacion->pagina();

$paginacion->registroInicio=$registro_inicio;
//var_dump($listado_envios);
  
?>

<!--
<script type="text/javascript" src="../../js/ajax_load.js"></script>
<script type="text/javascript" src="../../js/ajax_load_post.js"></script>
-->   

<div id="centrar">              
	<div>
	<fieldset id="admin_envios"> 
		<legend>Env&iacute;os<span style="font-weight:bold;"></span></legend>  
			<div style="display: block;">
			<form id="frm_envios" name="frm_envios" action="" method="POST">	 			
				<?php 				
					$name='fecha';                                        
					$nameId1='fecha_desde';            
					$nameId2='fecha_hasta';                         
					$width='style="width:70px;font-size:9px;"';    
					$keyPress = 'onkeypress="formSubmit(event, \'submitEnvios\');"';         
					includeDatepicker(array($nameId1,$nameId2));                 
					echo '<span class="texto">F. Desde <input type="text" id="'.$nameId1.'" name="'.$nameId1.'" value="'.(isset($fecha_desde) ? $fecha_desde : '').'"'.$width.' '.$keyPress.' /></span>';                          
					echo '<span class="texto">F. Hasta <input type="text" id="'.$nameId2.'" name="'.$nameId2.'" value="'.(isset($fecha_hasta) ? $fecha_hasta : '').'"'.$width.' '.$keyPress.' /></span>';                         
				?>
				<span class="texto">Email&nbsp;<input type="text" id="email" name="email" value="<?php echo($email);?>"></span>                                                                      
				<br style="clear:both;"/><br style="clear:both;"/>
				<span class="texto">Enviado&nbsp;</span>                                
				<div id="seleccion_enviado"> 
						<span><label>S&iacute;&nbsp;</label><input type="radio" id="tenviado_si" name="tenviado" value="1" <?php echo(($fenviado==1)?' checked ':'');?>></span>                  
						<span><label>No&nbsp;</label><input type="radio" id="tenviado_no" name="tenviado" value="2" <?php echo(($fenviado==2)?' checked ':'');?>></span>      
						<span><label>Todos&nbsp;</label><input type="radio" id="tenviado_todos" name="tenviado" value="0" <?php echo(($fenviado==0)?' checked ':'');?>></span>                            
				</div>   				                                   
				<input type="hidden" id="registro_inicio" name="registro_inicio" value="<?php echo($pagina->registroInicio);?>"/>     
				<input type="submit" id="submitEnvios" name="submitEnvios" value="Filtrar">                  
			</form>	
			</div>	
		</legend>
	</fieldset>
	<br style="clear:both;"/>			
	<div id="bloque_paginacion"> 	
		 <label>p&aacute;gina <?php echo($pagina_actual.' / '.$numPaginas.'	('.$total_registros.' env&iacute;os)'); ?></label>	 
		 <input class="boto" style="float:left;" type="button" value="<<" onclick="$('#registro_inicio').val(0);$('#frm_envios').submit();">               
		 <input class="boto"  style="float:left;" type="button" value="Anterior" onclick="$('#registro_inicio').val('<?php echo($registro_anterior);?>');$('#frm_envios').submit();">          
		 <input class="boto"  style="float:left;" type="button" value="Siguiente" onclick="$('#registro_inicio').val('<?php echo($registro_siguiente);?>');$('#frm_envios').submit();">                   
		 <input class="boto"  style="float:left;" type="button" value=">>" onclick="$('#registro_inicio').val('<?php echo($paginacion->registroUltimo());?>');$('#frm_envios').submit();">       
		 
	</div>
	
	</div>
	<table id="listado_envios">                                     
		<tr class="cabecera">
		<td class="extremo_inicio" style="width:50px;">Fecha</td>
		<td style="width:50px;">Email</td>
		<td style="width:5px;">Enviado</td>
		<td style="width:150px;">Asunto Email</td>
		<td style="width:150px;">Error</td>
		<td class="extremo_final" style="width:150px;">Texto error</td>
		</tr>
		<?php
			$i=0;
			$id=0;
			foreach($listado_envios as $envio)
			{
				if (!$id)
				{
					$id=$envio['id_envio'];
					$k=0;
				}
				else
				{
					if ($id!=$envio['id_envio'])
					{
						$id=$envio['id_envio'];
						$k++;
					}
				}
				
				
				$mensaje_tmp=$envios->mensajeEmail($envio['bnc_message']);
				$mensaje_reducido=$mensaje_tmp[0];
				$detalle_mensaje=$mensaje_tmp[1];
				$enviado=($envio['enviado']==1)?'<span class="boton_enviado"></span>':'<span class="boton_no_enviado"></span>';  
				//echo('<tr class="datos" style="background:'.(!($i%2)?'#ffffff;':'#eeeeee').'">');
				echo('<tr class="datos" style="background:'.(!($k%2)?'#ffffff;':'#eeeeee').'">');
				echo('<td>'.$envio['fecha'].'</td>');                                
				echo('<td>
						<a href="javascript:" onclick="javascript:ocultar_label('.$id.');"/>
							<span id="lbl_email_'.$id.'">'.$envio['email'].'</span>
							<input style="display:none;" type="text" id="email_'.$id.'"  value="'.$envio['email'].'" 
							onblur="javascript:actualizar_label('.$id.');"
							/>							
						</a>
					</td>');                   
				echo('<td>'.$enviado.'</td>');                          
				echo('<td>'.$envio['asunto_email'].'<input type="hidden" id="asunto_'.$id.'" value="'.$envio['asunto_email'].'"/>
							<input type="hidden" id="body_'.$id.'"  value="'.tools::getHtmlValue('1',$envio['body_email']).'" />
							
					</td>');                                      
				echo('<td><a href="javascript:void();" title="'.$detalle_mensaje.'">'.$mensaje_reducido.'</a></td>');                                
				echo('<td>'.$envio['bnc_message'].'</td>');
				echo('<td><input type="button" class="boto" value="Enviar" onclick="javascript:actualizar_campos_seleccion('.$id.');"/></td>');   
				echo('</tr>');
				$i++;
			}
		?>	
	</table>
	<form id="frmEnviarEmail" name="frmEnviarEmail" action="" method="POST" style="display:none;">
		<input type="hidden" id="email_selec" name="email_selec" value="" />
		<input type="hidden" id="asunto_selec" name="asunto_selec" value="" />
		<input type="hidden" id="body_selec" name="body_selec" value="" />
		<input type="hidden" id="enviar" name="enviar" value="0" />
		<input type="submit" style="display:none;" />
	</form>
 </div> 
 <div id="someid"></div>

 <script type="text/javascript">
	
	/*if ('<?php echo($enviar);?>'=='1')  
	{
		alert('Enviado'); 
		
	}
	*/
	 
	function actualizar_campos_seleccion(id_envio)     
	{		
		$('#enviar').val(1);		
		$('#email_selec').val($('#email_'+id_envio).val());         
		$('#asunto_selec').val($('#asunto_'+id_envio).val());      
		$('#body_selec').val($('#body_'+id_envio).val());           
		
		setTimeout(function(){$('#frmEnviarEmail').submit();}, 2000);                            
		//alert('Enviado. Recargando página...');
	}  
	
	function actualizar_label(id_envio)
	{
		//$('#email_'.id_envio).focus();
		$('#lbl_email_'+id_envio).html($('#email_'+id_envio).val());	
		mostrar_label(id_envio);
	}
	
	
	/*function abandonar_campo(e,id_envio)
	{
		var code = e.keyCode || e.which;
		if(code == 13 || code == 9) 
		{
			mostrar_label(id_envio);
		}	
	}*/
	
	function mostrar_label(id_envio)
	{
		$('#email_'+id_envio).hide();
		$('#lbl_email_'+id_envio).show();
	}
	
	function ocultar_label(id_envio)
	{
		$('#email_'+id_envio).show();
		$('#lbl_email_'+id_envio).hide();
		//$('#email_'+id_envio).focus();
	}
	
 </script>
<?php
	unset ($pagina);
	unset ($envios);

?>