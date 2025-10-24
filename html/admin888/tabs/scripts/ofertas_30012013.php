<?php
  
include dirname(__FILE__).'/config_events.php';
include_once(dirname(__FILE__).'/../../../config/defines.inc.php');
include dirname(__FILE__).'/funciones_ofertas.php'; 
include dirname(__FILE__).'/funciones_cupon_oferta_historico.php'; 
include dirname(__FILE__).'/funciones_ofertas_vista.php';             
include dirname(__FILE__).'/contador_periodos_oferta.php';             

$URL_ROOT='http://'.$_SERVER['HTTP_HOST'].__PS_BASE_URI__ ;
define('color_activo','#FFC0C0');
define('color_inactivo_blanco','#FFFFFF');
define('color_inactivo_blanco_over','#E8E8E8');
define('color_inactivo_gris','#CCCCCC');
define('color_inactivo_gris_over','#D2D2D2');
?>
<!--<script type="text/javascript" src="../../../js/jquery.js"></script>
<script type="text/javascript" src="../../../js/jquery.zclip.js"></script>-->

<?php
 
if ($_GET['creadas']==0)
{
    
    $ofertas = GetOfertasHistorico(null,null,'activas_inactivas');
   // var_dump($ofertas);die;
    $nofertas = count($ofertas);
    
    //Vista de ofertas: (deberá psarse a un tpl)
    ?>
    
    <div id="ofertas">  
    
        <?php
       
        //cabecera_ofertas();
        $maxorden = 0;
        $minorden = 999999999999;
        foreach($ofertas as $o) 
        {
            if ($o->activa and $o->orden>$maxorden) $maxorden=$o->orden;
            if ($o->activa and $o->orden<$minorden) $minorden=$o->orden;
        }
        
        $i=0;
        $procesando_inactivas=false;
        foreach($ofertas as $o)
        {
        $class = '';      
        $sdestacados = stripslashes($o->destacados);
        if ($o->clienteEspecial==1 and $o->caducada!=1) $class='class="activo"';
        ?>
         <table <?echo($class);?>  width="100%"  style="border:1px solid #CCCCCC;margin-left:12px;width:950px;padding:7px;">
         <?php  if ($o->activa==0 and !$procesando_inactivas)
           {
           ?>
           <tr>
           <td  colspan="8" style = "text-align:left;vertical-align:top;font-weight:bold;font-size:16px;" class="cabecera_oferta">Campañas Inactivas</td>
           </tr>
           <?php
           $procesando_inactivas=true;
           }
           ?>    
         </table>
         <table <?echo($class);?>  width="100%"  style="border:1px solid #CCCCCC;margin-left:12px;width:950px;padding:7px;">
             
           <tr style="height:33px;vertical-align:top;" <?php echo($class);?>>   
               <?php
               $url_detalle_oferta = $URL_ROOT.'detalle-oferta/'.$o->id.'-0-oferta.html';
               $imagenes = $o->getImagenes();
               //echo('oferta '.$o->id);var_dump($imagenes);
               foreach ($imagenes as $im) {if ($im['cover']) $nombre_imagen = $o->id.'-'.$im['id_image_oferta'].'.jpg';}
               //var_dump($imagenes);
               $size=80;
               list($Width, $Height, $tipo, $atr) = getimagesize(_PS_IMG_DIR_.'oh/'.$nombre_imagen);
               $w=($Width-$Height>=0)?('width="'.$size.'"'):'';
               $h=($Height-$Width>=0)?('height="'.$size.'"'):'';
               
               $cupones = getCuponesOfertaHistorico($o->id);
               $ncupones = count($cupones);
               
               $validados=0;
               $pendientes=0;
               $vendidos=0;
                
               foreach ($cupones as $n) {if ($n->usado==0) $pendientes+=1;else $validados+=1;}
               foreach ($cupones as $n) {if ($n->vendido==1) $vendidos+=1;}
               
              //var_dump($o)
               $precio=floatval($o->precioValor);
               if (floatval($o->descuento)!=0) $precio_oferta = floor(floatval($precio-$precio*$o->descuento/100));
               else $precio_oferta = $precio;
               $precio = round($precio,2);
               $precio_oferta = round($precio_oferta,2);
               //list($y,$m,$d)=split('-',substr($o->fechaInicio,0,10));
               list($y,$m,$d)=split('-',substr($o->fechaAlta,0,10));
               
               ?>
               <td width="25%" colspan="2" style = "text-align:left;" class="cabecera_oferta">Campaña del día &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span style="color:#3399FF;"><?php echo($d.'/'.$m.'/'.$y.' '.substr($o->fechaAlta,11));?></span>  </td>
               <td width="13%" class="cabecera_oferta">Estado</td> 
               <td width="12%" class="cabecera_oferta">Cupones</td> 
               <td width="12%" class="cabecera_oferta">Utilizado</td> 
               <td width="12%" class="cabecera_oferta">Por usar</td> 
               <td colspan="2" width="6%"  class="cabecera_oferta" style="text-align:left;">Acciones</td>    
               <td width="8%"  class="cabecera_oferta">
                   <?php
                           if ($o->activa==1) echo('Orden');
                   ?>
               </td>
           </tr>
           <tr>
               <td width="10%" class="texto_oferta" style="text-align:left;vertical-align:top;padding-top:20px;"><img  <?php echo($w.' '.$h);?> src="../../../img/oh/<?php echo($nombre_imagen);?>"></td>
               <td width="15%" class="texto_oferta" style="text-align:left;">
                   <table>
                       <tr><td  style='font-weight:bold;color:#3399FF;'><?php echo(utf8_encode($o->idDesc));?></td></tr>
                       <tr><td><div style="height:100px;width:200px;overflow:hidden;margin-bottom:10px;"><?php echo(substr_without_tags($sdestacados,0,200,'...'));?></div></td></tr>
                   </table>
               </td>
               <td width="13%" class="texto_oferta">
                   <input type="hidden" id="especiales_ofertas<?php echo($i);?>" value = "<?php echo($o->clienteEspecial);?>">
                   <input type="hidden" id="activa_ofertas<?php echo($i);?>" value = "<?php echo($o->activa);?>">
                    <?php
                    $fechaFin = $o->fechaFin;
                    $hora_futura = mktime(substr($fechaFin,11,2),substr($fechaFin,14,2),substr($fechaFin,17,2),substr($fechaFin,5,2),substr($fechaFin,8,2),substr($fechaFin,0,4));
                    $fecha_futura = date("d/m/Y H:i:s",$hora_futura);
                    ?>
                   <input type="hidden" id="fecha_ofertas<?php echo($i);?>" value = "<?php echo($fecha_futura);?>">
                   <input type="hidden" id="idofertash<?php echo($i);?>" value = "<?php echo($o->id);?>">
                   <input type="hidden" id="idofertas<?php echo($i);?>" value = "<?php echo($o->idOferta);?>">
                   <input type="hidden" id="tiempo_limite<?php echo($i);?>" >
                   <?php
                    if ($o->activa==1) 
                    {
                        $clase_activa= "boton_oferta_disponible";
                        $texto_activa= " Activa";
                    }
                    else
                    {
                        $clase_activa= "boton_oferta_caducada";
                        $texto_activa= " Inactiva";
                        if ($o->clienteEspecial==1 and $o->caducada==1) $texto_activa.='<br>(Cliente Especial)';
                    }
                   ?>
                   <div id="titulo_estado_oferta<?php echo($i);?>" class="<?php echo($clase_activa);?>"></div>
                   <br><span id="estado_oferta<?php echo($i);?>"><?php echo($texto_activa);?></span>
               </td>
               <td width="12%" class="texto_oferta valor_oferta"><?php echo($ncupones);?></td>
               <td width="12%" class="texto_oferta valor_oferta"><?php echo($validados);?></td>
               <td width="12%" class="texto_oferta valor_oferta"><?php echo($pendientes);?></td>
               <td width="5%" class="texto_oferta valor_oferta">
                    <a title="Borrar la campaña" id="activa" href="javascript:borrar_oferta('<?php echo($o->id);?>',0,<?php echo($ncupones);?>,<?php echo($o->clienteEspecial);?>)">
                        <img style="width:20px;height:20px;" src="<?php echo(URL_ROOT);?>img/esborra.gif"  alt="" />  
                    </a> 
           <!--<input class="boton" type="button" onclick="javascript:activar_talonarios(<?php echo($e->id);?>);" value='Mostrar ventas'>-->
     
               </td>
               <td class="texto_ofrerta valor_oferta" style="text-align:left;vertical-align:top;padding-top:0;">
                    <table >
                    <tr><td style="padding:7px;">    
                        <!--<a title="Ver lista de cupones" class="boton_ofertas"  href="javascript:cupones_usados_ofertas(<?php echo($o->id);?>,0)">Ver Lista</a>-->
                    <input type="button" title="Ver lista de cupones" class="boto"  value = 'Ver Lista' onClick="javascript:cupones_usados_ofertas(<?php echo($o->id);?>,0)">
                    </td></tr>
                    <tr><td style="padding:7px;">    
                        <!--<a title="Ver detalle de la campaña" target="_blank" class="boton_ofertas" href="<?php echo($url_detalle_oferta);?>">Ver detalle</a>-->
                        <a id = "detalle<?php echo($o->id);?>" style="display:none;" target="_blank" href="<?php echo($url_detalle_oferta);?>"></a>
                        <input type="button" value='Ver detalle' title="Ver detalle de la campaña"  class="boto" onClick="id_('detalle<?php echo($o->id);?>').click();">
                    </td></tr>
                    </table>
               </td> 
        <td class="position-cell" style="vertical-align:top;padding-top:10px;">
        <?php 
        if ($o->activa==1)
        { 
            if ($o->orden == $maxorden)
            {
                echo '[ <img src="../img/admin/up_d.gif" alt="" border="0"> ]<br><br>';
                if ($o->orden == $minorden)
                    echo '[ <img src="../img/admin/down_d.gif" alt="" border="0"> ]';
                else
                    echo '[ <a  href="javascript:cambiar_posicion_oferta('.$maxorden.',1,'.$o->id.');"><img src="../img/admin/down.gif" alt="" border="0"></a> ]';
            
            }
            elseif ($o->orden == $minorden) 
                echo '
                    [ <a href="javascript:cambiar_posicion_oferta('.$o->orden.',0,'.$o->id.');"><img src="../img/admin/up.gif" alt="" border="0"></a> ]<br><br>
                    [ <img src="../img/admin/down_d.gif" alt="" border="0"> ]';
            else
                echo '
                    [ <a  href="javascript:cambiar_posicion_oferta('.$o->orden.',0,'.$o->id.');""><img src="../img/admin/up.gif" alt="" border="0"></a> ]<br><br>
                    [ <a  href="javascript:cambiar_posicion_oferta('.$o->orden.',1,'.$o->id.');""><img src="../img/admin/down.gif" alt="" border="0"></a> ]';
        }?>
           </td>    
           </tr>
           

         </table> 
        <?php  
         $i++;  
         } 
        ?>
    <input type="hidden" id="num_ofertas" value="<?php echo(count($ofertas));?>">
    </div> <!-- fin div ofertas -->    



<?php
$ofertas_hist = $ofertas;
}
else 
{
    
    $ofertas = GetOfertas(null,'orden');
    
    
    ?>
    
    <div id="ofertas">  
    
        <?php
       
        
        $inactivo='inactivo_blanco';
        $maxorden = 0;
        $minorden = 999999999999;
        foreach($ofertas as $o) 
        {
            if ($o->orden>$maxorden) $maxorden=$o->orden;
            if ($o->orden<$minorden) $minorden=$o->orden;
        }
        ?>
        <?php
        foreach($ofertas as $o)
          {
            //En primer lugar recuperamos la url de la campaña asociada a la oferta.
            $ofertasHist = GetOfertasHistorico(null,$o->id,'activas');
            $url_detalle = '';
            foreach ($ofertasHist as $oh)
            {
                if ($oh->activa==1)
                {
                    $url_detalle = $URL_ROOT.'detalle-oferta/'.$ofertasHist[0]->id.'-0-oferta.html';
                    break;
                }
                
            }
                    
            //$inactivo = ($inactivo=='inactivo_blanco')?'inactivo_gris':'inactivo_blanco';
            $inactivo = 'inactivo_blanco';
            
            ?>  
            
        <table>
        <tr>

        <td>
            <table class="<?php echo(($o->clienteEspecial==1)?'activo':$inactivo);?>" style="margin-left:10px;height:71px;border:1px solid #CCCCCC;padding:7px;width:100%;">
               <tr>
                   <?php
                   $precio=floatval($o->precioValor);
                   if (floatval($o->descuento)!=0) $precio_oferta = floor(floatval($precio-$precio*$o->descuento/100));
                   else $precio_oferta = $precio;
                   $precio = round($precio,2);
                   $precio_oferta = round($precio_oferta,2);
                   /*
                   $fechaIni = $o->fechaInicio;
                   $fechaFin = $o->fechaFin;
                   if ($o->activa==1)
                    $periodo = calcular_periodo($fechaIni,$fechaFin);
                   else $periodo = 0;
                   */
                  $periodo = 24;
                  ?> 
                   <?php
                    if ($o->activa==1) 
                    {
                        $clase_activa= "boton_oferta_disponible";
                        $texto_activa= " Activa";
                    }
                    else
                    {
                        $clase_activa= "boton_oferta_caducada";
                        $texto_activa= " Inactiva";
                    }
                   ?>
                   <td width="30px" align="left">
                   <span class="texto_cabecera" style="height:21px;width:60px;"></span>                        
                   <div id="titulo_estado_oferta<?php echo($i);?>" class="<?php echo($clase_activa);?>" style="margin-left:0px;"></div>
                   </td>

                   <td width="200px"><span class="texto_cabecera" style="height:30px;width:200px;">Id Oferta</span> <span class="texto_normal"><?php echo(utf8_encode($o->idDesc).'('.$o->id.')');?></span></td>
                   <td width="184px" align="left"> <input type="button"  style="width:70px;height:30px;" class="boto"  text="Editar oferta"  onclick="javascript:edita_menu_oferta('<?php echo($o->id);?>','<?php echo($periodo);?>');" value="Editar"></td>
                   <td width="382px" align="left"  style="padding:0 15px 0 15px;"><span class="texto_cabecera" style="height:30px;">Link</span>  <input onclick="copia_link('<?php echo($url_detalle);?>');" type="text" readonly="readonly" style="width:382px;" text="Copiar link"  value='<?php echo($url_detalle);?>'></td>
                   <td class="position-cell" style="vertical-align:top;height:30px;">
                   <span class="texto_cabecera" style="color:#000000;height:30px;">Orden</span>    
                    <?php 
                    /*if ($o->activa==1)
                    { */
                        if ($o->orden == $maxorden)
                        {
                            echo '[ <img src="../img/admin/up_d.gif" alt="" border="0"> ]<br class="breakline">';
                            if ($o->orden == $minorden)
                                echo '[ <img src="../img/admin/down_d.gif" alt="" border="0"> ]';
                            else
                                echo '[ <a  href="javascript:cambiar_posicion_oferta_creada('.$maxorden.',1,'.$o->id.');"><img src="../img/admin/down.gif" alt="" border="0"></a> ]';
                        
                        }
                        elseif ($o->orden == $minorden) 
                            echo '
                                [ <a href="javascript:cambiar_posicion_oferta_creada('.$o->orden.',0,'.$o->id.');"><img src="../img/admin/up.gif" alt="" border="0"></a> ]<br class="breakline">
                                [ <img src="../img/admin/down_d.gif" alt="" border="0"> ]';
                        else
                            echo '
                                [ <a  href="javascript:cambiar_posicion_oferta_creada('.$o->orden.',0,'.$o->id.');""><img src="../img/admin/up.gif" alt="" border="0"></a> ]<br class="breakline">
                                [ <a  href="javascript:cambiar_posicion_oferta_creada('.$o->orden.',1,'.$o->id.');""><img src="../img/admin/down.gif" alt="" border="0"></a> ]';
                    //}
                    ?>
                   </td>             
                   
               </tr>
             </table> 
         </td>
        <td>
            <table  style="margin:0;margin-left:10px;border:1px solid #CCCCCC;padding:6px 0 6px 0;width:122px;">
               <tr>       
                   <td class="texto_cabecera" style="font-weight:bold;width:50px;padding:0 10px 0 10px;">Vip</td>
                   <td class="texto_cabecera" style="font-weight:bold">Duplicar oferta</td>
               </tr>
               <tr>
                   <?php
                    if ($o->activa==1) 
                    {
                        $clase_activa= "boton_oferta_disponible";
                        $texto_activa= " Activa";
                    }
                    else
                    {
                        $clase_activa= "boton_oferta_caducada";
                        $texto_activa= " Inactiva";
                    }
                   ?>
                   <td width="10%" align="left" style="padding:0 10px 0 10px;"> <input type="button" class="boto boton_marcar" onclick="javascript:marca_cliente_especial('<?php echo($o->id);?>','1','<?php echo($o->clienteEspecial);?>')"></td> 
                   <td width="10%" align="left" > <input type="button" class="boto boton_duplicar" onclick="javascript:duplicar_oferta('<?php echo($o->id);?>')"></td> 
               </tr>
            </table>
         </td>
         </tr>
         </table>
        <?php    
         } 
        ?>

    </div> <!-- fin div ofertas publicadas o campañas. -->    

<?php
}



?>





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

  .boton_duplicar,input.boton_duplicar:hover
   {
    background: none repeat scroll 0 0 #008000;
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
 
  .breakline
  {
      margin-bottom:5px;
      display:block;    
  }

</style>



