 <?php
include dirname(__FILE__).'/config_events_new.php';
include dirname(__FILE__).'/funciones_cupon_oferta.php'; 
include dirname(__FILE__).'/funciones_cupon_oferta_historico.php'; 
include dirname(__FILE__).'/funciones_ofertas.php'; 

//include dirname(__FILE__).'/funciones_cupon_vista.php';              


//en caso de que $_GET['creadas'] == 0 (registro de ofertas 'histórico'), id_oferta será el id de histórico id_oferta_hist
$id_oferta = $_GET['id_oferta']; 
if (isset($_GET['cupon']))
{
    if ($_GET['creadas']==0) //creadas == 0 indica el registro de ofertas (histórico).
        $id_oferta = OfertaCuponHistorico($_GET['cupon']);    
    else
        $id_oferta = OfertaCupon($_GET['cupon']);     
}   

if ($_GET['creadas']==0) //creadas == 0 indica el registro de ofertas (histórico).
{
    $cupones = GetCuponesOfertaHistorico($id_oferta);
    if (count($cupones)==0) die('error');
    $o = GetOfertasHistorico($id_oferta);
}
else 
{ 
    $cupones = GetCuponesOferta($id_oferta);
    if (count($cupones)==0) die('error');
    $o = GetOfertas($id_oferta);
}

$o = $o[0];


$validados=0;
$pendientes=0;
$vendidos=0;

foreach ($cupones as $n) {if ($n->usado==0) $pendientes+=1;else $validados+=1;}
foreach ($cupones as $n) {if ($n->vendido==1) $vendidos+=1;}


//Vista de establecimientos: (deberá psarse a un tpl)
?>
<div id="cupones">  
    <table>
        <tr class="cabecera">
            <td width='10%'></td>
            <td style="width:20%;"><span class="label_">Vendidos</span></td><td style="width:20%;"><span class="label_">Validados</span></td><td style="width:20%;"><span class="label_">Pendientes</span></td><td><span class="label_">Nº Oferta</span></td>
        </tr>
        <tr>    
     <!--<td style="width:20%;text-align:left;"><input type="button"  onclick="javascript:buscar_cheque(<?php echo($id_establecimiento);?>)" value="Validar"></td> -->
          <td width='10%'></td>
          <td style="width:20%;"><input class="input" type="text" style="text-align:center;width:60px;" disabled value="<?php echo($vendidos);?>"></td><td style="width:20%;"><input class="input" type="text" style="text-align:center;width:60px;" disabled value="<?php echo($validados);?>"></td><td style="width:15%;"><input class="input" type="text" disabled  style="text-align:center;width:60px;" value="<?php echo($pendientes);?>"></td><td style="width:15%;"><input class="input" type="text" disabled  style="text-align:center;width:60px;" value="<?php echo($id_oferta);?>"></td>
        </tr>
    </table>    
    <!--<p class="cabecera" >Empresa </p>-->
    <p>     </p>
<!--    <table>
        <tr>
            <td width='3%'></td>

            <td style="width:25%;"><span class="label_"><font size="3px;" color="red" >Oferta:</span><?php echo($e->usuario);?></font></td> <td style="width:15%;"><span class="label_">Dirección:</span><?php echo($e->direccion);?></td>
        </tr>
-        
        <tr>
            <td width='3%'></td>
                
            <td style="width:25%;"><span class="label_">Población:</span><?php echo($e->poblacion);?></td> <td style="width:15%;"><span class="label_">Provincia:</span><?php echo($e->provincia);?></td>
        </tr>
        <tr>
            <td width='3%'></td>

            <td style="width:25%;"><span class="label_">Persona de Contacto:</span><?php echo($e->nombre)?></td> <td style="width:15%;"><span class="label_">Teléfono:</span><?php echo($e->telefono);?></td>
        </tr>
    </table>
-->
    <!--<p class="cabecera" >Talonario: <?php echo($numero_talonario);?></p>-->

    <br>
    <table width="100%">
      <tr>
     <td>
      <table>   
    <?php
   
    //cabecera_cupones();
    $i=0;

    
    foreach($cupones as $c)
      {
        
      $i=$i+1;   

      $year = substr($c->fechaIni,0,4);
      $month = substr($c->fechaIni,5,2);
      $day = substr($c->fechaIni,8,2);
      $hour = substr($c->fechaIni,11,5);
      $sfecha = $day."/".$month."/".$year." ".$hour;

    ?>
      <tr>
       <td width='10%'></td>
       <td width='12%' ><?php echo($i." - ");?></td>
       <td width="16%" class="borderg"><?php printf("%06d", $c->cupon); ?></td>
       <td align="left" valign="center">
            <?php /*if ($c->usado==1)  $class='no_disponible'; 
            else {*/
                if ($c->vendido==1 && $c->usado==0)  $class='vendido';
                else if ($c->vendido==1) $class='no_disponible';
                /*else $class='disponible';
            }*/
            ?>

<?php /*
            <?php //mts 12052012.  Sólo activaremos la función de validación para los cupones vendidos o validados. 
               if($c->usado==1) { ?> 
                <a style="width:150px;" class="<?php echo($class);?>" href="javascript:validar_cupon_oferta(<?php echo($c->idOferta);?>,<?php echo($c->cupon);?>,<?php echo($c->usado==0?'0':'1');?>)">
            <?php } else {?>
                <a style="width:150px;" class="<?php echo($class);?>" href="javascript:">
            <?php } ?>    
            
 */ ?>                
            <a style="width:150px;" class="<?php echo($class);?>" href="javascript:validar_cupon_oferta(<?php echo($c->idOferta);?>,<?php echo($c->cupon);?>,<?php echo($c->usado==0?'0':'1');?>,<?php echo($creadas);?>)">


            <?php if ($c->usado==0)  {?>
              &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
             <?php } else echo($sfecha);?> 
 
            </a>
       </td>
       <td align="left" valign="center">
            <?php 
                if ($c->observaciones!="")  $class='no_disponible'; 
                else $class="marcat_gris";            
            ?>
            <a style="width:150px;font-size:10px;color:white;" class="<?php echo($class);?>" href="javascript:observaciones_cupon_oferta(<?php echo($c->idOferta);?>,<?php echo($c->cupon);?>,'<?php echo($c->observaciones);?>',<?php echo($creadas);?>)">
            Observaciones</a>
       </td>
       <td align="left" valign="center">
            <a style="width:22px;font-size:10px;color:white;" class="marcat_gris" href="javascript:mail_cupon_oferta(<?php echo($c->idOferta);?>,<?php echo($c->cupon);?>,<?php echo($creadas);?>)">
            <img width="22px;" src='tabs/img/email.png'></a>
       </td>

       </tr>
    <?php
    if ($i==15) echo("</table></td><td><table>");
    } 
?>     
      </table>
      </td>
     </tr> 
    </table> 
</div> <!-- fin div cupones -->    

<style>

    .boton_talonario {
    background: none repeat scroll 0 0 #888888;
    color: #FFFFFF;
    font-style: italic;

    #cupones {
        font-size:12px;
    /*1px solid #E0D0B1      * /
    }
}   
</style>

