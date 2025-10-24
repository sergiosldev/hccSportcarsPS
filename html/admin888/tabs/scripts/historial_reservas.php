<?php 

include dirname(__FILE__).'/config_events_new.php';
include_once(dirname(__FILE__).'/../../../config/defines.inc.php');
include dirname(__FILE__).'/funciones_cupon_oferta.php'; 
include dirname(__FILE__).'/funciones_ofertas.php'; 
include dirname(__FILE__).'/../../../classes/CuponOferta.php'; 
include dirname(__FILE__).'/../../../classes/Usuario.php'; 
include dirname(__FILE__).'/../../../classes/ReservaOferta.php'; 


$ancho_columna = array(7,13,10,10,10,10,10);
?>

<?php
$id_usuario = $_GET['id_usuario'];

$cliente = new Usuario();
$reservas = $cliente->getReservas($id_usuario,'0');
//Vista Historial clientes
?>

<div id="reservas">  
    <form id ="lreservas" name="lreservas" method="POST" action="">
    <?php
    $i=1;
    foreach($reservas as $r)
      {
      $ofertas = GetOfertasHistorico($r->idOfertaHist);
      $oferta = $ofertas[0];
      //var_dump($oferta);die;
        
    ?>
     <table width="100%"  style="border:1px solid #CCCCCC;margin-left:12px;width:960px;padding:7px;cellspacing:0;border-spacing:0;">
       <tr style="height:6px;vertical-align:top;<?php echo($r->exit==1?'':'background-color:#FF0000;color:#FFFFFF;');?>">   
           <td class="cabecera_cliente" width="<?php echo($ancho_columna[0]);?>%;">Código Reserva</td> 
           <td class="cabecera_cliente" width="<?php echo($ancho_columna[1]);?>%;">Campaña</td> 
           <td class="cabecera_cliente" width="<?php echo($ancho_columna[2]);?>%;" style="text-align:left;">fecha</td> 
           <td class="cabecera_cliente" width="<?php echo($ancho_columna[3]);?>%;">Pago Registrado</td> 
           <td class="cabecera_cliente" width="<?php echo($ancho_columna[4]);?>%;">Cantidad Registrada</td> 
           <td class="cabecera_cliente" width="<?php echo($ancho_columna[5]);?>%;">Cupones</td> 
           <td class="cabecera_cliente" width="<?php echo($ancho_columna[5]);?>%;">Desmarcar</td> 
           <td class="cabecera_cliente" width="<?php echo($ancho_columna[6]);?>%;">Envío</td> 
       </tr>
       <tr style="<?php echo($r->exit==1?'':'background-color:#FF0000;color:#FFFFFF;');?>">  
           <?php
           $fecha_arr = explode(' ',$r->fecha);
           $fecha = implode('/',array_reverse(explode('/',$fecha_arr[0]))).' '.$fecha_arr[1];
           
           ?>
           <td width="<?php echo($ancho_columna[0]);?>%;" class="texto_cliente valor_cliente"><?php echo($r->codigo);?></td>
           <td width="<?php echo($ancho_columna[1]);?>%;" class="texto_cliente valor_cliente"><?php echo($oferta->id.'-'.$oferta->idDesc);?></td>
           <td width="<?php echo($ancho_columna[2]);?>%;" style="text-align:left;" class="texto_cliente valor_cliente"><?php echo($fecha);?></td>
           <td width="<?php echo($ancho_columna[3]);?>%;" class="texto_cliente valor_cliente"><?php echo(($r->exit==1)?'SI':'NO');?></td>
           <td width="<?php echo($ancho_columna[4]);?>%;" class="texto_cliente valor_cliente"><?php echo($r->cantidad);?></td>
           <td width="<?php echo($ancho_columna[4]);?>%;" class="texto_cliente valor_cliente"><?php echo($r->cupones?$r->cupones:'0');?></td>
           <td width="<?php echo($ancho_columna[5]);?>" style="padding:7px 0 7px 0;text-align:center;">
               <?php //echo($cadena_cupones);?>
                <input style="width:70px;<?php if (((int)$r->cupones)>0) echo('visibility:hidden;');?>" type="button" title="Desmarcar la reserva" class="boto"  value = 'Desmarcar' onClick="envia_cupones(<?php echo($id_usuario);?>,<?php echo($r->idOfertaHist);?>,'@','<?php echo($r->codigo);?>');">
           </td>
           <td width="<?php echo($ancho_columna[5]);?>" style="padding:7px 0 7px 0;text-align:center;">
               <?php //echo($cadena_cupones);?>
                <input style="width:70px;<?php if (((int)$r->cupones)>0) echo('visibility:hidden;');?>" type="button" title="Generar y enviar cupones" class="boto"  value = 'Enviar' onClick="javascript:document.body.style.cursor='wait';envia_cupones(<?php echo($id_usuario);?>,<?php echo($r->idOfertaHist);?>,'#','<?php echo($r->codigo);?>');document.body.style.cursor='default';">
           </td>
       </tr>
       

     </table> 
    <?php    
     $i++;
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

</style>
 

