<?php

include dirname(__FILE__).'/config_events.php';
include dirname(__FILE__).'/funciones_ofertas.php'; 

include dirname(__FILE__).'/funciones_ofertas_vista.php';             

if ($_GET['creadas']==0)
{
    $ofertas = GetOfertasHistorico();
    //Vista de ofertas: (deberá psarse a un tpl)
    ?>
    
    <div id="ofertas">  
    
        <?php
       
        cabecera_ofertas();
        
        
        foreach($ofertas as $o)
          {
        ?>
         <table width="100%">
           <tr>
               <?php
               $precio=floatval($o->precioValor);
               if (floatval($o->descuento)!=0) $precio_oferta = floor(floatval($precio-$precio*$o->descuento/100));
               else $precio_oferta = $precio;
               $precio = round($precio,2);
               $precio_oferta = round($precio_oferta,2);
               
               ?>
               <td width="15%" class="borderg"><?php echo(utf8_encode($o->fechaInicio));?>  </td>
               <td width="15%" class="borderg"><?php if ($o->fechaInicio<$o->fechaFin) echo(utf8_encode($o->fechaFin));?>  </td>
               <td  width="15%" class="borderg " align="left" > <?php echo(utf8_encode($o->idDesc).'('.$o->id.')');?></td>
               <td align="left" valign="center" >
                    <a id="activa" href="javascript:borrar_oferta('<?php echo($o->id);?>',0)">
                        <img src="<?php echo(URL_ROOT);?>img/esborra.gif"  alt="" />
                    </a> 
                    <input type="button" class="boton_mostrar_ventas" value="Mostrar Ventas" onclick="javascript:cupones_usados_ofertas(<?php echo($o->id);?>,0)">
    
           <!--<input class="boton" type="button" onclick="javascript:activar_talonarios(<?php echo($e->id);?>);" value='Mostrar ventas'>-->
    
               </td>
           </tr>
         </table> 
        <?php    
         } 
        ?>
    </div> <!-- fin div ofertas -->    

<?php
}
else 
{
    
    $ofertas = GetOfertas();
    ?>
    
    <div id="ofertas">  
    
        <?php
       
    cabecera_ofertas_creadas();
        
        
        foreach($ofertas as $o)
          {
        ?>
         <table width="100%">
           <tr>
               <?php
               $precio=floatval($o->precioValor);
               if (floatval($o->descuento)!=0) $precio_oferta = floor(floatval($precio-$precio*$o->descuento/100));
               else $precio_oferta = $precio;
               $precio = round($precio,2);
               $precio_oferta = round($precio_oferta,2);
               
                ?> 
               <td  width="15%" class="borderg " align="left" > <a href="javascript:edita_menu_oferta('<?php echo($o->id);?>')"><?php echo(utf8_encode($o->idDesc).'('.$o->id.')');?></a></td>
               <td align="left" valign="center" >
    
           <!--<input class="boton" type="button" onclick="javascript:activar_talonarios(<?php echo($e->id);?>);" value='Mostrar ventas'>-->
    
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
   .boton {
    background: none repeat scroll 0 0 #888888;
    color: #FFFFFF;
    font-style: italic;
</style>
 

