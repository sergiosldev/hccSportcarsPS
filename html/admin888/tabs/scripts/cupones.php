<?php
include dirname(__FILE__).'/config_events_new.php';
include dirname(__FILE__).'/funciones_cupon.php'; 
include dirname(__FILE__).'/funciones_establecimiento.php'; 
include dirname(__FILE__).'/funciones_talonario.php'; 
//include dirname(__FILE__).'/funciones_cupon_vista.php';              


$id_establecimiento = $_GET['id_establecimiento'];
$id_talonario = $_GET['id_talonario'];
$numero_talonario = $_GET['numero_talonario'];
 
if (isset($_GET['numero_cupon']))
{
    $id_establecimiento = EstablecimientoCupon($_GET['numero_cupon']);
    $id_talonario = TalonarioCupon($id_establecimiento,$_GET['numero_cupon']);
    $numero_talonario = NumTalonarioCupon($id_establecimiento,$_GET['numero_cupon']);
}   


$cupones = GetCupones($id_establecimiento,$id_talonario);

if (count($cupones)==0) die('error');
$e = GetEstablecimientos($id_establecimiento);
$e = $e[0];

$t = GetTalonario($id_establecimiento,$id_talonario);



$validados=0;
$pendientes=0;
$vendidos=0;
$facturados=0;
$cobrados=0;
$comerciales=0;

foreach ($cupones as $n) {if ($n->usado==0) $pendientes+=1;else $validados+=1;}
foreach ($cupones as $n) 
{
    if ($n->vendido==1) $vendidos+=1;
    if ($n->facturado==1) $facturados+=1;
    if ($n->cobrado==1) $cobrados+=1;
    if ($n->comercial==1) $comerciales+=1;
}


//Vista de establecimientos: (deberá psarse a un tpl)
?>
<div id="cupones">  
    <table>
        <tr class="cabecera">
            <td width='100px'></td>
            <td style="width:150px;"><span class="etiqueta_">Vendidos</span></td><td style="width:150px;"><span class="etiqueta_">Validados</span></td>
            <td style="width:150px;"><span class="etiqueta_">Pendientes</span></td>
            <td style="width:150px;"><span class="etiqueta_">Facturados</span></td>
            <td style="width:150px;"><span class="etiqueta_">Cobrados</span></td>
            <td style="width:150px;"><span class="etiqueta_">Comerciales</span></td>
            <td style="width:150px;"><span class="etiqueta_">Nº Talonario</span></td>
            <td style="width:150px;"><span class="etiqueta_"></span></td>
        </tr>
        <tr>    
     <!--<td style="width:20%;text-align:left;"><input type="button"  onclick="javascript:buscar_cheque(<?php echo($id_establecimiento);?>)" value="Validar"></td> -->
          <td width='100px'></td>
          <td><input class="input" type="text" style="text-align:center;width:60px;" disabled value="<?php echo($vendidos);?>"></td>
          <td><input class="input" type="text" style="text-align:center;width:60px;" disabled value="<?php echo($validados);?>"></td>
          <td><input class="input" type="text" disabled  style="text-align:center;width:60px;" value="<?php echo($pendientes);?>"></td>
          <td><input class="input" type="text" disabled  style="text-align:center;width:60px;" value="<?php echo($facturados);?>"></td>
          <td><input class="input" type="text" disabled  style="text-align:center;width:60px;" value="<?php echo($cobrados);?>"></td>
          <td><input class="input" type="text" disabled  style="text-align:center;width:60px;" value="<?php echo($comerciales);?>"></td>
          <td><input class="input" type="text" disabled  style="text-align:center;width:60px;" value="<?php echo($numero_talonario);?>"></td>
        </tr>
    </table>    
    <!--<p class="cabecera" >Empresa </p>-->
    <p>     </p>
    <table>
        <tr>
            <td width='5%'></td>
            <td class="columna_cabecera1"><span class="etiqueta_"><font size="3px;" color="red" >Establecimiento:</span><?php echo($e->usuario);?></font></td> 
            <td colspan="2"><span class="etiqueta_">Dirección:</span><?php echo($e->direccion);?></td>
        </tr>
        <tr>
            <td width='3%'></td>
            <td class="columna_cabecera1"><span class="etiqueta_">Población:</span><?php echo($e->poblacion);?></td> 
            <td class="columna_cabecera2"><span class="etiqueta_">Provincia:</span><?php echo($e->provincia);?></td>
                <?php 
                    if ($t->observaciones!="")  $class='no_disponible'; 
                    else $class="marcat_gris";            
                ?>

            <td class="<?php echo($class);?>" style="padding:4px;">
                <a class="<?php echo($class);?>" style="font-size:14px;color:white;" href="javascript:observaciones_cupon(<?php echo($id_establecimiento);?>,<?php echo($numero_talonario);?>,<?php echo($id_talonario);?>,0,'<?php echo($t->observaciones);?>')">
                Observaciones</a>
            </td>            
        </tr>
        <tr>
            <td width='3%'></td>
            <td class="columna_cabecera1"><span class="etiqueta_">Persona de Contacto:</span><?php echo($e->nombre)?></td> 
            <td colspan="2"><span class="etiqueta_">Teléfono:</span><?php echo($e->telefono);?></td>
        </tr>
    </table>
    <!--<p class="cabecera" >Talonario: <?php echo($numero_talonario);?></p>-->
    
    <br>
    <table width="700px;">
      <tr>
     <td>
      <table width="520px;">   
    <?php
   
    //cabecera_cupones();
    $i=0;

    
    foreach($cupones as $c)
      {
      $i=$i+1;   
      $year = substr($c->fecha,0,4);
      $month = substr($c->fecha,5,2);
      $day = substr($c->fecha,8,2);
      $hour = substr($c->fecha,11,5);
      $sfecha = $day."/".$month."/".$year." ".$hour;
        
      $year = substr($c->fechaVenta,0,4);
      $month = substr($c->fechaVenta,5,2);
      $day = substr($c->fechaVenta,8,2);
      $hour = substr($c->fechaVenta,11,5);
      if ($day.$month.$hour!='')
        $sfecha_venta = $day."/".$month."/".$year." ".$hour;
      else $sfecha_venta = '';
      if ($i == 1 or $i == 16)
      {        
    ?>
      <tr style="text-align:right;color:#555555;font-weight:bold;font-size:11px;">
       <td width='100px'></td>
       <td width='100px'></td>
       <td width="100px" class="borderg"></td>
       <td class="registro_cupon"></td>
       <td class="registro_cupon"></td>
       <td class="registro_cupon"></td>
       <td class="registro_cupon"></td>
       <td class="registro_cupon"></td>
       <td style="width:10px;"></td>
       <td class="registro_cupon">F.</td>
       <td style="font-weight:bold;width:0%;" class="registro_cupon">Co.</td>
       <td style="font-weight:bold;width:0%;" class="registro_cupon" >Cm.</td>
       <td>
       </td>
       <td></td>
     </tr>
    <?php 
      } ?>  
      <tr>
       <td></td>
       <td><?php echo($i." - ");?></td>
       <td class="borderg"><?php printf("%06d", $c->numero); ?></td>
       <td class="registro_cupon">
            <?php 
            if ($c->usado==1)  {$class='no_disponible'; $titulo='Cupón validado';}
            else if ($c->usado==3) {$class='cancelado';$titulo='Cupón cancelado';}
            else {
                if ($c->vendido==1)  {$class='vendido';$titulo='Cupón vendido';}
                else {$class='disponible';$titulo='Cupón disponible';}
            }
            ?>
            <?php //mts 12052012.  Sólo activaremos la función de validación para los cupones vendidos o validados.
            
            if ($c->usado == 1 or $c->usado == 3) $estilo = 'font-size:10px;color:#FFFFFF;';
            else if ($c->vendido == 1) $estilo = 'font-size:10px;color:#000000;';
            else $estilo=''; 
               if($c->vendido==1 or $c->usado==1 or $c->usado==3) { ?> 
                <a title="<?php echo($titulo);?>" style="<?php echo($estilo);?>display:block;width:105px;height:17px;text-align:center;" onmouseover="this.style.backgroundcolor='#FFFFFF;'" class="<?php echo($class);?>" href="javascript:validar_cupon(<?php echo($c->id_establecimiento);?>,<?php echo($numero_talonario);?>,<?php echo($c->id_talonario);?>,<?php echo($c->numero);?>,<?php echo($c->usado==0?'0':'1');?>)">
            <?php } else {?>
                <a title="<?php echo($titulo);?>" style="<?php echo($estilo);?>display:block;width:105px;height:17px;text-align:center;"  onmouseover="this.style.backgroundcolor='#FFFFFF;'" class="<?php echo($class);?>" href="javascript:">
            <?php } ?>    
            <?php if (($c->usado==0 and $c->vendido!=1) or $c->usado==3)  
                echo(($c->usado==3)?"Cancelado":""); 
                else if ($c->vendido==1 and $c->usado==0) echo($sfecha_venta); 
                else echo($sfecha);
            ?> 
                </a>
       </td>
       <td class="registro_cupon">
            <?php 
                if ($c->observaciones!="")  $class='no_disponible'; 
                else $class="marcat_gris";            
            ?>
            <a style="width:150px;font-size:10px;color:white;" class="<?php echo($class);?>" href="javascript:observaciones_cupon(<?php echo($c->id_establecimiento);?>,<?php echo($numero_talonario);?>,<?php echo($c->id_talonario);?>,<?php echo($c->numero);?>,'<?php echo($c->observaciones);?>')">
            Observaciones</a>
       </td>
       <td class="registro_cupon">
            <a style="width:22px;font-size:10px;color:white;" class="marcat_gris" href="javascript:mail_cupon(<?php echo($c->id_establecimiento);?>,<?php echo($numero_talonario);?>,<?php echo($c->id_talonario);?>,<?php echo($c->numero);?>)">
            <img width="22px;" src='tabs/img/email.png'></a>
       </td>
       <td class="registro_cupon">
           <?php if ($c->vendido==1)   
                    {?>
                    <a title="Cambiar a disponible" style="width:20px;height:15px;display:block;" class="disponible" href="javascript:validar_cupon(<?php echo($c->id_establecimiento);?>,<?php echo($numero_talonario);?>,<?php echo($c->id_talonario);?>,<?php echo($c->numero);?>,2)">
                    </a>    
           <?php    } ?>
       </td>
       <td class="registro_cupon" >
                <a title="Cancelar cupón" style="border:none;background:none;width:20px;height:22px;display:block;" class="disponible" href="javascript:validar_cupon(<?php echo($c->id_establecimiento);?>,<?php echo($numero_talonario);?>,<?php echo($c->id_talonario);?>,<?php echo($c->numero);?>,3)">
                <img style="width:20px;height:20px;" src="../../../img/calabera.png">
                </a>    
       </td>
         
       <!--<td style="padding-left:10px;font-weight:bold;width:17%;" class="registro_cupon">
                <a title="Datos establecimiento" style="font-size:10px;width:20px;height:22px;display:block;" href="javascript:edita_establecimiento(<?php echo($c->id_establecimiento);?>,<?php echo($c->id_talonario);?>,<?php echo($numero_talonario);?>);">
                Datos establ.
                </a>    
       </td>-->
       <td style="width:10px;"></td>
       <td class="registro_cupon" style="padding-right:10px;">
            <a href="javascript:validar_cupon(<?php echo($c->id_establecimiento);?>,<?php echo($numero_talonario);?>,<?php echo($c->id_talonario);?>,<?php echo($c->numero);?>,<?php echo($c->facturado?5:4);?>)" id="facturado" title="Cupón <?php echo($c->facturado?"":"no");?> facturado" >
               <img style="width:17px;height:20px;" src="../../../img/<?php if ($c->facturado) echo('facturado.png'); else echo('no_facturado.png');?>">
            </a>    
       </td>
       <td class="registro_cupon" style="padding-right:10px;">
            <a href="javascript:validar_cupon(<?php echo($c->id_establecimiento);?>,<?php echo($numero_talonario);?>,<?php echo($c->id_talonario);?>,<?php echo($c->numero);?>,<?php echo($c->cobrado?7:6);?>)" id="cobrado" title="Cupón <?php echo($c->cobrado?"":"no");?> cobrado" >
                <img style="width:17px;height:20px;" src="../../../img/<?php if ($c->cobrado) echo('facturado.png'); else echo('no_facturado.png');?>">
            </a>    
       </td>
       <td>
            <a href="javascript:validar_cupon(<?php echo($c->id_establecimiento);?>,<?php echo($numero_talonario);?>,<?php echo($c->id_talonario);?>,<?php echo($c->numero);?>,<?php echo($c->comercial?9:8);?>)" id="comercial" title="Cupón <?php echo($c->comercial?"":"no");?> comercial" >
               <img style="width:17px;height:20px;" src="../../../img/<?php if ($c->comercial) echo('facturado.png'); else echo('no_facturado.png');?>">
            </a>    
       </td>
       <td></td>
       </tr>
    <?php
    if ($i==15) echo("</table></td><td><table width='520px;'>");
    } 
?>     
      </table>
      </td>
     </tr> 
    </table> 
</div> <!-- fin div talonarios -->    

<style>

    
    .columna_cabecera1 {
        width:44%;
    }

    .columna_cabecera2 {
        width:35%;
    }

    .etiqueta_ {
        color: #444444;
        font-style: italic;
        padding-right:5px;
    }
    .boton_talonario {
    background: none repeat scroll 0 0 #888888;
    color: #FFFFFF;
    font-style: italic;
    }
    #cupones {
        font-size:12px;
    }    
    
    .registro_cupon {
        height:30px;
        padding-right:9px;
        vertical-align:middle;
        text-align:left;
    }
    /*1px solid #E0D0B1      * /
    
   
</style>

