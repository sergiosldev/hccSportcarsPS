<?php
include_once (dirname(__FILE__).'/config_events_new.php');

include_once(dirname(__FILE__).'/../../../config/config.inc.php');
include_once dirname(__FILE__).'/funciones_cupon_oferta.php'; 

include_once dirname(__FILE__).'/funciones_clientes.php'; 

define('color_activo','#FFC0C0');
define('color_inactivo_blanco','#FFFFFF');
define('color_inactivo_blanco_over','#E8E8E8');
define('color_inactivo_gris','#CCCCCC');
define('color_inactivo_gris_over','#D2D2D2');
$ancho_columna = array(7,13,10,10,10,8,5,7);
?>

<?php 

$orden = $_GET['orden']; 
$direccion = $_GET['direccion'];
$filtro = $_GET['filtro'];
$registro_inicio = $_GET['registro_inicio'];  
//$nregistros_pagina = $_GET['nregistros_pagina'];  
$nregistros_pagina = 4;  
$compra_cliente = intval($_GET['compra_cliente']);
$pagina_fin = $_GET['pagina_fin'];   
$npaginas = null;    
$pagina_fin = null;       

$total_registros = GetNumClientes($orden,$direccion,null,trim($filtro),$registro_inicio,$nregistros_pagina,$compra_cliente);                                                       

$clientes = GetClientes($orden,$direccion,null,trim($filtro),$registro_inicio,$nregistros_pagina,$compra_cliente);                                                                                    

if ($registro_inicio+$nregistros_pagina>=$total_registros)                                   
{
	$registro_siguiente=1;    
}
else
{
	$registro_siguiente=$registro_inicio+$nregistros_pagina;    
}



if ($registro_inicio-$nregistros_pagina<=0)               
{
	$registro_anterior=1;     
}
else
{
	$registro_anterior=$registro_inicio-$nregistros_pagina;       
}
 
//echo($total_registros.'--'.$nregistros_pagina);              
$npaginas = intval($total_registros/$nregistros_pagina)?intval($total_registros/$nregistros_pagina)+1:1;     
$pagina_actual=pagina($registro_inicio,$total_registros,$npaginas);    

//Vista de clientes
?>   
 
<div id="clientes">    
    <form id ="lclientes" name="lclientes" method="POST" action="">        	 
	 <div style="width:50%;height:30px;display:block;margin-left:40%;"> 	
	
		 <input class="boto" style="float:left;" type="button" value="<<" onclick="get_lista_clientes(<?php echo($orden);?>,<?php echo($direccion);?>,'<?php echo(trim($filtro));?>',1,<?php echo($nregistros_pagina);?>,<?php echo($compra_cliente);?>)">            
		 <input class="boto"  style="float:left;" type="button" value="Anterior" onclick="get_lista_clientes(<?php echo($orden);?>,<?php echo($direccion);?>,'<?php echo(trim($filtro));?>',<?php echo($registro_anterior);?>,<?php echo($nregistros_pagina);?>,<?php echo($compra_cliente);?>)">          
		 <input class="boto"  style="float:left;" type="button" value="Siguiente" onclick="get_lista_clientes(<?php echo($orden);?>,<?php echo($direccion);?>,'<?php echo(trim($filtro));?>',<?php echo($registro_siguiente);?>,<?php echo($nregistros_pagina);?>,<?php echo($compra_cliente);?>)">               
		 <input class="boto"  style="float:left;" type="button" value=">>" onclick="get_lista_clientes(<?php echo($orden);?>,<?php echo($direccion);?>,'<?php echo(trim($filtro));?>',<?php echo(($npaginas-1)*$nregistros_pagina);?>,<?php echo($nregistros_pagina);?>,<?php echo($compra_cliente);?>)">     
		 <label style="width:60%;float:left;">p&aacute;gina <?php echo($pagina_actual.' / '.$npaginas.'	('.$total_registros.' clientes)'); ?></label>	 
	 </div>
	 <div style="width:50%;height:30px;display:block;margin-left:38%;">
	 	 <input style="float:left;margin-left:20px;" type="button" value="Con cupón" onclick="get_lista_clientes(<?php echo($orden);?>,<?php echo($direccion);?>,'<?php echo(trim($filtro));?>',1,<?php echo($nregistros_pagina);?>,1)">    
		 <input style="float:left;" type="button" value="Sin cupón" onclick="get_lista_clientes(<?php echo($orden);?>,<?php echo($direccion);?>,'<?php echo(trim($filtro));?>',1,<?php echo($nregistros_pagina);?>,-1)">  
		 <input style="float:left;" type="button" value="Todos" onclick="get_lista_clientes(<?php echo($orden);?>,<?php echo($direccion);?>,'<?php echo(trim($filtro));?>',1,<?php echo($nregistros_pagina);?>,0)">  
	 </div>
     <table width="100%"  style="border:1px solid #CCCCCC;margin-left:12px;width:950px;">        
       <tr style="height:12px;vertical-align:top;">                  
           <td class="cabecera_cliente" width="11%;">                             
				<a href="javascript:get_lista_clientes(0,<?php echo(($direccion=='1')?'0':'1');?>,'<?php echo(trim($filtro));?>',1,<?php echo($nregistros_pagina);?>);">                
					<img src="../../../img/admin/up.gif">
					<br>
					<img src="../../../img/admin/down.gif">
				</a>  
			</td> 
           <td class="cabecera_cliente" width="1%;">  
				<a href="javascript:get_lista_clientes(1,<?php echo(($direccion=='1')?'0':'1');?>,'<?php echo(trim($filtro));?>',1,<?php echo($nregistros_pagina);?>);">  
					<img src="../../../img/admin/up.gif">
					<br>
					<img src="../../../img/admin/down.gif">
				</a>
			</td> 
           <td width="68%;">
			<input type="hidden" id="direccion_orden" value="<?php echo($direccion);?>">
			<input type="hidden" id="orden" value="<?php echo($orden);?>">
		   </td>   
       </tr>
     </table>  
	 
    <?php

    $bPagoPendiente = false;
    foreach($clientes as $c)
      { 
      $cupones = $c->getCupones($c->id,'0');                      
	  
      $reservas = $c->getReservas($c->id,'0');                        
      
	  if (count($reservas)>0) $bPagoPendiente=true;
      else $bPagoPendiente=false;
	  
	  if (intval($c->registro_reserva)) 
	  {
		$registroreserva='[R]';
	  }
	  elseif ($c->registro_reserva=="0") 
	  {
		$registroreserva="[O]";
	  }
	  else $registroreserva=='';
	  
	  switch ($c->empresa)
		{
			case "0": 
				$empresa = 'Motor';
			break;

			case "1": 
				$empresa = 'Dream';
			break;
			case "2": 
				$empresa = 'Hcc';
			break;
			default:
				$empresa='';
		}	  
   
		if ($empresa!='') $empresa = '['.$empresa.']';
	  ?>
     <table width="100%"  style="border:1px solid #CCCCCC;margin-left:12px;width:950px;padding:7px;<?php echo(($c->eliminado==1)?'background:#FF3838;':'');?>">
       <tr style="height:33px;vertical-align:top;">   
           <td class="cabecera_cliente" width="<?php echo($ancho_columna[0]);?>%;">Nº Cliente</td> 
           <td class="cabecera_cliente" width="<?php echo($ancho_columna[1]);?>%;" style="text-align:left;">Nombre</td> 
           <td class="cabecera_cliente" width="<?php echo($ancho_columna[2]);?>%;">Teléfono</td> 
           <td class="cabecera_cliente" width="<?php echo($ancho_columna[3]);?>%;">Nº vales comprados</td> 
           <td class="cabecera_cliente" width="<?php echo($ancho_columna[4]);?>%;" style="text-align:left;"><?php if (count($cupones)>0){?>Ver Historial<?php } ?></td>        
           <td class="cabecera_cliente" width="<?php echo($ancho_columna[5]);?>%;" style="text-align:left;"><?php if($bPagoPendiente) echo('Reservas');?></td>      
           <td class="cabecera_cliente" width="<?php echo($ancho_columna[5]);?>%;" style="text-align:left;"><?php if ($c->eliminado!=1){?>Borrar<?php } ?></td>
           <td class="cabecera_cliente" width="<?php echo($ancho_columna[6]);?>%;" style="text-align:left;">Editar</td>    
       </tr>
       <tr>
           <td width="<?php echo($ancho_columna[0]);?>%;" class="texto_cliente valor_cliente"><?php echo($c->id.' '.$empresa.' '.$registroreserva);?></td>
           <td width="<?php echo($ancho_columna[1]);?>%;" style="text-align:left;" class="texto_cliente valor_cliente"><?php echo($c->nombre.' '.$c->apellidos);?></td>
           <td width="<?php echo($ancho_columna[2]);?>%;" class="texto_cliente valor_cliente"><?php echo($c->telefono);?></td>
           <td width="<?php echo($ancho_columna[3]);?>%;" class="texto_cliente valor_cliente"><?php echo(count($cupones));?></td>
           <td width="<?php echo($ancho_columna[4]);?>%;" style="padding:7px 0 7px 0;">    
                <input type="button" title="Ver Historial" style="width:70px;<?php if(count($cupones)==0) echo('visibility:hidden;');?>" class="boto"  value = 'Ver' onClick="javascript:historial_cliente(<?php echo($c->id);?>);">
           </td>
           <td width="<?php echo($ancho_columna[4]);?>%;" style="padding:7px 0 7px 0;">    
                <input type="button" title="Ver Reservas pendientes de pago" style="width:70px;<?php if(!$bPagoPendiente) echo('visibility:hidden;'); ?>" class="boto"  value = 'Reservas' onClick="javascript:historial_reservas(<?php echo($c->id);?>);">
           </td>
		   
           <td  width="<?php echo($ancho_columna[5]);?>" >
           <?php if ($c->eliminado!=1){?>
				<a title="Borrar el cliente" id="activa" href="javascript:borrar_cliente('<?php echo($c->id);?>')">
                    <img style="width:20px;height:20px;" src="<?php echo(URL_ROOT);?>img/esborra.gif"  alt="" />  
                </a> 
		   <?php } ?> 	
           </td>
		   
           
           <td width="<?php echo($ancho_columna[6]);?>" style="padding:7px 0 7px 0;">    
                <input style="width:70px;" type="button" title="Editar" class="boto"  value = 'Editar' onClick="javascript:edita_usuario(<?php echo($c->id);?>,0);">
           </td>
       </tr>
       

     </table> 
	 
    <?php    
     } 
    ?>
	 <div style="width:50%;height:30px;display:block;margin-left:40%;"> 	             
		 <input class="boto"  style="float:left;" type="button" value="<<" onclick="get_lista_clientes(<?php echo($orden);?>,<?php echo($direccion);?>,'<?php echo(trim($filtro));?>',1,<?php echo($nregistros_pagina);?>,<?php echo($compra_cliente);?>)">                                  
		 <input class="boto"  style="float:left;" type="button" value="Anterior" onclick="get_lista_clientes(<?php echo($orden);?>,<?php echo($direccion);?>,'<?php echo(trim($filtro));?>',<?php echo($registro_anterior);?>,<?php echo($nregistros_pagina);?>,<?php echo($compra_cliente);?>)">            
		 <input class="boto"  style="float:left;" type="button" value="Siguiente" onclick="get_lista_clientes(<?php echo($orden);?>,<?php echo($direccion);?>,'<?php echo(trim($filtro));?>',<?php echo($registro_siguiente);?>,<?php echo($nregistros_pagina);?>,<?php echo($compra_cliente);?>)">                   
		 <input class="boto"  style="float:left;" type="button" value=">>" onclick="get_lista_clientes(<?php echo($orden);?>,<?php echo($direccion);?>,'<?php echo(trim($filtro));?>',<?php echo($total_registros-$nregistros_pagina);?>,<?php echo($nregistros_pagina);?>,<?php echo($compra_cliente);?>)">     
		 <label style="width:60%;float:left;">p&aacute;gina <?php echo($pagina_actual.' / '.$npaginas);?></label>	   
	 </div>
	
</form>    
</div> <!-- fin div clientes -->    




<style>


.botones
{
/*    border-right: #336699 1px solid;
    border-top: #336699 1px solid;
    font-size: 12px;
    border-left: #336699 1px solid;
    width: auto;
    cursor: hand;
    color: #ffffff;
    border-bottom: #336699 1px solid;
    font-family: Arial, Helvetica, sans-serif;*/
    background-color: #31659c
}
  .texto_cabecera
  {
   font-size:12px;
   font-weight:bold;
   font-family:Arial;
  }
  .texto_normal
  {
   font-size:12px;
   font-weight:normal;
   font-family:Arial;   
  }
  span.texto_cabecera {display:block;}
  span.texto_normal {display:block;}
  .boton_marcar,input.boton_marcar:hover
   {
    background: none repeat scroll 0 0 #FF0000;
    display:block;
    width:30px;
    height:35px;
    text-align:center;
   }

  a.activo
  {
    background: none repeat scroll 0 0 <?php echo(color_activo);?>;
    color:#000000 !important;
  }  
      
  a.activo:hover
  {
    background: none repeat scroll 0 0 <?php echo(color_activo);?>;
    color:#000000 !important;
  }  
  table.activo,tr.activo,td.activo
  {
    background: none repeat scroll 0 0 <?php echo(color_activo);?>;
    border: 1px solid #888888;
    color:#000000 !important;
  }  

  table.activo:hover,td.activo:hover
  {
    background: none repeat scroll 0 0 <?php echo(color_activo);?>;
    border: 1px solid #888888;
    color:#000000 !important;
  }  
  

  table.inactivo_gris,td.inactivo_gris
  {
    background: none repeat scroll 0 0 <?php echo(color_inactivo_gris);?> !important;
    border: 1px solid #888888;
    color:#000000;
  }  
  
  a.inactivo_gris
  {
    background: none repeat scroll 0 0 <?php echo(color_inactivo_gris);?> !important;
    color:#000000;
  }  

  table.inactivo_gris:hover,td.inactivo_gris:hover
  {
    background: none repeat scroll 0 0  <?php echo(color_inactivo_gris_over);?> !important;
    border: 1px solid #888888;
    color:#000000;
  }  
  
  a.inactivo_gris:hover 
  {
    background: none repeat scroll 0 0  <?php echo(color_inactivo_gris_over);?> !important;
    color:#000000;
  }  

  table.inactivo_blanco,td.inactivo_blanco
  {
    background: none repeat scroll 0 0   <?php echo(color_inactivo_blanco);?>  !important;
    border: 1px solid #888888;
  }  
  
  a.inactivo_blanco
  {
    background: none repeat scroll 0 0  <?php echo(color_inactivo_blanco);?> !important;
  }  

  table.inactivo_blanco:hover,td.inactivo_blanco:hover
  {
    background: none repeat scroll 0 0   <?php echo(_color_inactivo_blanco_over);?>  !important;
    border: 1px solid #888888;
  }  
  a.inactivo_blanco:hover
  {
    background: none repeat scroll 0 0  <?php echo(_color_inactivo_blanco_over);?> !important;
  }  
  .cabecera_cliente {
        font-family: Arial;
        font-size: 12px;
        font-weight: bold;
        text-align: center;
    }
  .texto_cliente {
        font-family: Arial;
        font-size: 12px;
        text-align: center;
        vertical-align: top;
    }
  .valor_cliente {
        padding-top: 10px;
    }

</style>
 

<?php

function pagina($registro_inicio,$total_registros,$npaginas)                       
{
	if ($npaginas==1) 
	{
		$pagina=1;
	}	
	else 
	{
		$pagina=round($registro_inicio*$npaginas/$total_registros,0)+1;                                         
	}	
	
	return $pagina;
}

?>