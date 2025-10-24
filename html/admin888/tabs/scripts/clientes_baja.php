<?php
include_once dirname(__FILE__).'/config_events_new.php';
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

$total_registros = GetNumClientes($orden,$direccion,null,trim($filtro),$registro_inicio,$nregistros_pagina,$compra_cliente,false);                                                       

$clientes = GetClientes($orden,$direccion,null,trim($filtro),$registro_inicio,$nregistros_pagina,$compra_cliente,false);                                                                                    

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
$npaginas = 1;     
$pagina_actual=1;    

//Vista de clientes
?>   
 
<div id="clientes">    
    <form id ="lclientes" name="lclientes" method="POST" action="">        	 
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
           <td class="cabecera_cliente" width="<?php echo($ancho_columna[3]);?>%;">Email</td> 
           <td class="cabecera_cliente" width="<?php echo($ancho_columna[2]);?>%;">Teléfono</td> 
       </tr>
       <tr>
           <td width="<?php echo($ancho_columna[0]);?>%;" class="texto_cliente valor_cliente"><?php echo($c->id.' '.$empresa.' '.$registroreserva);?></td>
           <td width="<?php echo($ancho_columna[1]);?>%;" style="text-align:left;" class="texto_cliente valor_cliente"><?php echo($c->nombre.' '.$c->apellidos);?></td>
           <td width="<?php echo($ancho_columna[3]);?>%;" class="texto_cliente valor_cliente"><?php echo($c->email);?></td>
           <td width="<?php echo($ancho_columna[2]);?>%;" class="texto_cliente valor_cliente"><?php echo($c->telefono);?></td>
       </tr>
       

     </table> 
	 
    <?php    
     } 
    ?>
	
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

   div#clientes 
   {
	   margin-top:20px;
   }

</style>
 

