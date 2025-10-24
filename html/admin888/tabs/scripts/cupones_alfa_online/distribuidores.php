<?php
include_once( dirname(__FILE__).'/../config_events.php');
include_once(dirname(__FILE__).'/../../../../config/config.inc.php');
include_once( dirname(__FILE__).'/funciones_cupon_oferta_historico_ca.php'); 

include_once( dirname(__FILE__).'/funciones_distribuidores.php'); 

$ancho_columna = array(7,13,10,10,10,8,5,7);
?>

<?php
$orden = $_GET['orden'];
$direccion = $_GET['direccion'];
$filtro = trim($_GET['filtro']); 

$distribuidores = GetDistribuidores($orden,$direccion,null,$filtro);
//var_dump($distribuidores);
?>
   
<div id="distribuidores">  
    <form id ="ldistribuidores" name="ldistribuidores" method="POST" action="">
     <table width="100%"  style="border:1px solid #CCCCCC;margin-left:12px;width:950px;">
       <tr style="height:12px;vertical-align:top;">   
           <td class="cabecera_cliente" width="11%;"><a href="javascript:get_lista_distribuidores(0,<?php echo(($direccion=='1')?'0':'1');?>);"><img src="../../../img/admin/up.gif"><br><img src="../../../img/admin/down.gif"></a></td> 
           <td class="cabecera_cliente" width="1%;"><a href="javascript:get_lista_distribuidores(1,<?php echo(($direccion=='1')?'0':'1');?>);"><img src="../../../img/admin/up.gif"><br><img src="../../../img/admin/down.gif"></a></td> 
           <td width="68%;"><input type="hidden" id="direccion_orden_ca" value="<?php echo($direccion);?>"><input type="hidden" id="orden_ca" value="<?php echo($orden);?>"></td>
       </tr>
     </table>   
    <?php
    
    foreach($distribuidores as $c)
      {
          
      $cupones = $c->getCupones($c->id,'0');
      
          ?>
     <table width="100%"  style="border:1px solid #CCCCCC;margin-left:12px;width:950px;padding:7px;">
       <tr style="height:33px;vertical-align:top;">   
           <td class="cabecera_cliente" width="<?php echo($ancho_columna[0]);?>%;">Número</td> 
           <td class="cabecera_cliente" width="<?php echo($ancho_columna[0]);?>%;" style="text-align:left;">Fecha Alta</td> 
           <td class="cabecera_cliente" width="<?php echo($ancho_columna[1]);?>%;" style="text-align:left;">Nombre</td> 
           <td class="cabecera_cliente" width="<?php echo($ancho_columna[1]);?>%;" style="text-align:left;">Contacto</td> 
           <td class="cabecera_cliente" width="<?php echo($ancho_columna[2]);?>%;">Teléfono</td> 
           <td class="cabecera_cliente" width="<?php echo($ancho_columna[3]);?>%;">Nº vales<br> comprados</td> 
           <td class="cabecera_cliente" width="<?php echo($ancho_columna[5]);?>%;" style="text-align:left;">Borrar</td>    
           <td class="cabecera_cliente" width="<?php echo($ancho_columna[6]);?>%;" style="text-align:left;">Editar</td>    
           <td class="cabecera_cliente" width="<?php echo($ancho_columna[6]);?>%;" style="text-align:left;"><?php if (count($cupones)>0){?>Ver Historial<?php } ?></td>              
           <td class="cabecera_cliente" width="<?php echo($ancho_columna[6]);?>%;" style="text-align:left;"><?php if (count($cupones)>0){?>Ver Cupones<?php } ?></td>    
           
       </tr>
       <tr>
           <td width="<?php echo($ancho_columna[0]);?>%;" class="texto_cliente valor_cliente"><?php echo($c->id);?></td>
           <td width="<?php echo($ancho_columna[0]);?>%;" style="text-align:left;" class="texto_cliente valor_cliente"><?php echo(implode('/',array_reverse(explode('-',substr($c->fechaAlta,0,10)))));?></td>
           <td width="<?php echo($ancho_columna[1]);?>%;" style="text-align:left;" class="texto_cliente valor_cliente"><?php echo($c->nombre);?></td>
           <td width="<?php echo($ancho_columna[1]);?>%;" style="text-align:left;" class="texto_cliente valor_cliente"><?php echo($c->nombreContacto);?> <?php echo($c->apellidosContacto);?></td>
           <td width="<?php echo($ancho_columna[2]);?>%;" class="texto_cliente valor_cliente"><?php echo($c->telefono);?></td>
           <td width="<?php echo($ancho_columna[3]);?>%;" class="texto_cliente valor_cliente"><?php echo(count($cupones));?></td>

          <!-- <td width="<?php echo($ancho_columna[4]);?>%;" style="padding:7px 0 7px 0;">    
                <input type="button" title="Ver Historial" style="width:70px;<?php if(count($cupones)==0) echo('visibility:hidden;');?>" class="boto"  value = 'Ver' onClick="javascript:historial_cliente(<?php echo($c->id);?>);">
           </td>
          -->


           <td  width="<?php echo($ancho_columna[5]);?>" >
                <a title="Borrar el cliente" id="activa" href="javascript:borrar_distribuidor('<?php echo($c->id);?>')">
                    <img style="width:20px;height:20px;" src="<?php echo(URL_ROOT);?>img/esborra.gif"  alt="" />  
                </a> 
           </td>
           
           <td width="<?php echo($ancho_columna[6]);?>" style="padding:7px 0 7px 0;">    
                <input style="width:70px;" type="button" title="Editar" class="boto"  value = 'Editar' onClick="javascript:edita_distribuidor(<?php echo($c->id);?>,0);">
           </td>
           <td width="<?php echo($ancho_columna[4]);?>%;" style="padding:7px 0 7px 0;">    
                <input type="button" title="Ver Historial" style="width:70px;<?php if(count($cupones)==0) echo('visibility:hidden;');?>" class="boto"  value = 'Ver' onClick="javascript:historial_distribuidor(<?php echo($c->id);?>);">
           </td>
           
           <td width="<?php echo($ancho_columna[6]);?>" style="padding:7px 0 7px 0;">    
                <input type="button" title="Ver lista de cupones" class="boto" style="width:70px;<?php if(count($cupones)==0) echo('visibility:hidden;');?>"  value = 'Ver Lista' onClick="javascript:cupones_usados_ofertas_ca(0,0,<?php echo($c->id);?>)">
           </td>
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
 

