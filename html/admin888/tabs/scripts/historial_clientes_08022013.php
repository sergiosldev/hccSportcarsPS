<?php 

include dirname(__FILE__).'/config_events.php';
include_once(dirname(__FILE__).'/../../../config/defines.inc.php');
include dirname(__FILE__).'/funciones_cupon_oferta.php'; 
include dirname(__FILE__).'/../../../classes/CuponOferta.php'; 
include dirname(__FILE__).'/../../../classes/Usuario.php'; 

$ancho_columna = array(7,13,10,10,10,10,10);
?>

<?php
$id_usuario = $_GET['id_usuario'];

$cliente = new Usuario();
$cupones = $cliente->getCupones($id_usuario,'1');
$historial = array();
$idOfertaHist = '';
$idDescOferta = '';
$fechaCompra = '';
$i=0;
$codigosCupon = array();
foreach ($cupones as $cupon)   
{

    if ($idOfertaHist!='' and ($idOfertaHist != $cupon->idOfertaHist or $fechaCompra!=implode('/',array_reverse (explode('-',substr($cupon->fechaCompra,0,10)))).substr($cupon->fechaCompra,10)) )
    {
        $historial[$i]['codigos'] = implode('<br>',$codigosCupon);
        $historial[$i]['venta'] = $i+1;
        $historial[$i]['id_oferta_hist'] = $idOfertaHist;
        $historial[$i]['fecha_compra'] = $fechaCompra;
        $historial[$i]['tipo_experiencia'] = $idDescOferta;
        $historial[$i]['numero_ventas'] = count($codigosCupon);

        $codigosCupon = array();
        $idOfertaHist = '';
        $idDescOferta = '';
        $fechaCompra = '';

        $i++;
    } 

    if ($idOfertaHist=='') 
    {
        $idOfertaHist = $cupon->idOfertaHist;
        $idDescOferta = $cupon->idDescOferta;
        $fechaCompra = implode('/',array_reverse (explode('-',substr($cupon->fechaCompra,0,10)))).substr($cupon->fechaCompra,10);
        
    }   
    $codigosCupon[]=$cupon->cupon;    

}

//Caso último registro.
$historial[$i]['codigos'] = implode('<br>',$codigosCupon);
$historial[$i]['venta'] = $i+1;
$historial[$i]['id_oferta_hist'] = $idOfertaHist;
$historial[$i]['fecha_compra'] = $fechaCompra;
$historial[$i]['tipo_experiencia'] = $idDescOferta;
$historial[$i]['numero_ventas'] = count($codigosCupon);


$venta_max = 0;

$n = count($historial);

//ordenamos por fecha para visualizar los datos.
for($i=1;$i<$n;$i++)
{
    for($j=0;$j<($n-$i);$j++)
    {
        $fecha_compra=explode('/',substr($historial[$j]['fecha_compra'],0,10));
        $hora_compra=explode(':',substr($historial[$j]['fecha_compra'],11));
        $fecha_compra = mktime($hora_compra[0],$hora_compra[1],$hora_compra[2],$fecha_compra[1],$fecha_compra[0],$fecha_compra[2]);           

        $fecha_compra_sig=explode('/',substr($historial[$j+1]['fecha_compra'],0,10));
        $hora_compra_sig=explode(':',substr($historial[$j+1]['fecha_compra'],11));
        $fecha_compra_sig = mktime($hora_compra_sig[0],$hora_compra_sig[1],$hora_compra_sig[2],$fecha_compra_sig[1],$fecha_compra_sig[0],$fecha_compra_sig[2]);           

        if($fecha_compra>$fecha_compra_sig)
        {
        $aux=$historial[$j];
        $historial[$j]=$historial[$j+1];
        $historial[$j+1]=$aux;
        }
    }
}


//Vista Historial clientes
?>

<div id="clientes">  
    <form id ="lhistorial" name="lhistorial" method="POST" action="">
    <?php
    $i=1;
    foreach($historial as $r)
      {
        $ncupones = count(explode('<br>',$r['codigos']));  
        //$cadena_cupones = '\''.str_replace('<br>','\',\'',$r['codigos']).'\'';
        $cadena_cupones = '\''.str_replace('<br>',',',$r['codigos']).'\'';
        
    ?>
     <table width="100%"  style="border:1px solid #CCCCCC;margin-left:12px;width:960px;padding:7px;">
       <tr style="height:33px;vertical-align:top;">   
           <td class="cabecera_cliente" width="<?php echo($ancho_columna[0]);?>%;">Códigos</td> 
           <td class="cabecera_cliente" width="<?php echo($ancho_columna[1]);?>%;">Fecha de Compra</td> 
           <td class="cabecera_cliente" width="<?php echo($ancho_columna[2]);?>%;" style="text-align:left;">Venta</td> 
           <td class="cabecera_cliente" width="<?php echo($ancho_columna[3]);?>%;">Tipo Experiencia<br>(Id)</td> 
           <td class="cabecera_cliente" width="<?php echo($ancho_columna[4]);?>%;">Nº ventas</td> 
           <td class="cabecera_cliente" width="<?php echo($ancho_columna[5]);?>%;">Renviar Cupones</td> 
       </tr>
       <tr>
           <td width="<?php echo($ancho_columna[0]);?>%;" class="texto_cliente valor_cliente"><?php echo($r['codigos']);?></td>
           <td width="<?php echo($ancho_columna[1]);?>%;" class="texto_cliente valor_cliente"><?php echo($r['fecha_compra']);?></td>
           <td width="<?php echo($ancho_columna[2]);?>%;" style="text-align:left;" class="texto_cliente valor_cliente"><?php echo($i);?></td>
           <td width="<?php echo($ancho_columna[3]);?>%;" class="texto_cliente valor_cliente"><?php echo($r['tipo_experiencia']);?></td>
           <td width="<?php echo($ancho_columna[4]);?>%;" class="texto_cliente valor_cliente"><?php echo($r['numero_ventas']);?></td>
           <td width="<?php echo($ancho_columna[5]);?>" style="padding:7px 0 7px 0;text-align:center;">
               <?php //echo($cadena_cupones);?>
                <input style="width:70px;<?php if ($ncupones==0) echo('visibility:hidden;');?>" type="button" title="Renviar Cupones" class="boto"  value = 'Renviar' onClick="javascript:document.body.style.cursor='wait';envia_cupones(<?php echo($id_usuario);?>,<?php echo($r['id_oferta_hist']);?>,<?php echo($cadena_cupones);?>);document.body.style.cursor='default';">
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
 

