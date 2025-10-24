 

<?php

include dirname(__FILE__).'/config_events_new.php';
include dirname(__FILE__).'/funciones_talonario.php'; 
include dirname(__FILE__).'/funciones_talonario_vista.php';              

$id_establecimiento = $_GET['id_establecimiento'];
$talonarios = GetTalonarios($id_establecimiento);
$num_talonarios = 0;
foreach($talonarios as $tmp) $num_talonarios=$num_talonarios+1;


//Vista de establecimientos: (deberá psarse a un tpl)
?>
<div id="talonarios">  
    <p class="cabecera" style="font-style:italic;font-size:18px;"><br>Talonarios<br></p>
    <br>
    <?php
   
    cabecera_talonarios();
    $i=0;

    $max_rango_anterior = 0;
    
    echo(' <table width="100%">');
    
    if ($num_talonarios == 0)
    {
        ?>
      <!--<tr></tr><td width="53%"  >  </td>
           <td align="right" valign="center">-->
         <div style = "width:265px;float:right;"><input type="button" class="boton_talonario" value="Crear Talonario" onClick="alta_talonario(<?php echo($id_establecimiento);?>);"></div>
     <!--</td></tr>-->
     <?php      
    }
    else 
    foreach($talonarios as $t)
      {
      $i=$i+1;    
    ?>
    
       <tr>
           <td width="2%" ><?php echo($i.' - ');?></td>
           <td width="15%" class="borderg"><input type="text" id="talonario<?php echo($i);?>"  name="talonario<?php echo($i);?>" value='<?php echo($t->numero);?>'></td>
           <td width="17%" class="borderg" ><input disabled type="text" id="min_rango<?php echo($i);?>" name="min_rango<?php echo($i);?>" value='<?php printf("%06d",$t->min_rango);?>'></td>
           <td width="17%" class="borderg" ><input disabled type="text" id="max_rango<?php echo($i);?>" name="max_rango<?php echo($i);?>" value='<?php printf("%06d",$t->max_rango);?>'></td>
           <td align="left" valign="center" >
                <input type="button" class="boton_talonario" value="Guardar" onclick="javascript:guardar(<?php echo($t->id_establecimiento);?>,<?php echo($t->id_talonario);?>,id_('talonario<?php echo($i);?>').value,id_('min_rango<?php echo($i);?>').value,id_('max_rango<?php echo($i);?>').value)">
                <input type="button" class="boton_talonario" value="Cupones Usados" onclick="javascript:cupones_usados(<?php echo($t->id_establecimiento);?>,<?php echo($t->id_talonario);?>,<?php echo($t->numero);?>)">
                <a id="activa" href="javascript:borra_talonario(<?php echo($t->id_establecimiento);?>,<?php echo($t->id_talonario);?>)">
                    <img src="<?php echo(URL_ROOT);?>img/esborra.gif"  alt="" />
                </a> 
           </td>
     <?php
       if ($i==$num_talonarios)
       { ?>
           <td align="right" valign="center">
               <input type="button" class="boton_talonario" value="Crear Talonario" onClick="alta_talonario(<?php echo($id_establecimiento);?>);">
           </td>
           
    <?php   
       } ?>
        
       </tr>
    <?php
    $max_rango_anterior = $t->max_rango;
    } 

    //$rango=29;
    //$min_propuesto = $t->max_rango+1;
    //$max_propuesto = $min_propuesto+$rango;
    //no eliminamos estas variables por si más adelante tuvieramos que modificar la aplicación para que 
    //nos propusiera un número de cupón en función del último registro guardado.
    $min_propuesto = "";
    $max_propuesto = "";
    
    if ($_GET['alta']==1) 
    {
     
    ?>
       <tr>
           <td width="2%" ><?php echo(($i+1).' - ');?></td>
           <td width="15%" class="borderg"><input type="text"  id="talonario<?php echo($i+1);?>" name="talonario<?php echo($i+1);?>" value=''></td>
           <td width="17%" class="borderg" ><input type="text" id="min_rango<?php echo($i+1);?>" onchange = "javascript:validar_min_rango(this,<?php echo($i+1);?>);" name="min_rango<?php echo($i+1);?>" value='<?php echo($min_propuesto);?>'></td>
           <td width="17%" class="borderg" ><input type="text" id="max_rango<?php echo($i+1);?>" name="max_rango<?php echo($i+1);?>" value='<?php echo($max_propuesto);?>'></td>
           <td align="left" valign="center" >
                <input type="button" class="boton_talonario" value="Guardar" onclick="javascript:guardar(<?php echo($id_establecimiento);?>,'null',id_('talonario<?php echo($i+1);?>').value,id_('min_rango<?php echo($i+1);?>').value,id_('max_rango<?php echo($i+1);?>').value)">
                <!--<input type="button" class="boton_talonario" value="Cupones Usados" onclick="javascript:cupones_usados(<?php echo($id_establecimiento);?>),null">-->
           </td>
       </tr>
   <?php 
    } 
   
  //  echo "<script type='text/javascript'>window.onload = function(){ focus(getElementById('talonario3')); }</script>";
    ?>
    </table> 
</div> <!-- fin div talonarios -->    


 
<style>

    .boton_talonario {
    background: none repeat scroll 0 0 #888888;
    color: #FFFFFF;
    font-style: italic;
}   
</style>

