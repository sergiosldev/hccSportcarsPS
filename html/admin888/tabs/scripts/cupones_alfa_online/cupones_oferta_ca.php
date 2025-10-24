 <?php
include dirname(__FILE__).'/../config_events.php';
include dirname(__FILE__).'/funciones_cupon_oferta_ca.php'; 
include dirname(__FILE__).'/funciones_cupon_oferta_historico_ca.php'; 
include dirname(__FILE__).'/funciones_ofertas_ca.php'; 

//include dirname(__FILE__).'/funciones_cupon_vista.php';              

//die('creadas '.$_GET['creadas'].' idoferta: '.$_GET['id_oferta'].' cupon: '.$_GET['cupon']);
//en caso de que $_GET['creadas'] == 0 (registro de ofertas 'histórico'), id_oferta será el id de histórico id_oferta_hist
$id_oferta = request('id_oferta'); 
$id_distribuidor = request('id_distribuidor'); 
 
/*if (isset($_GET['cupon']))
{
    //si cupon = 0 siginfica que se ha eliminado el cupón.
    if ($_GET['cupon']==0)
    {
        if ($_GET['creadas']==0)
        {
            $oferta = new OfertaHistorico(null,$id_oferta); 
            $id_oferta = $oferta->id;
            unset($oferta);        
        }
        
    }
    else 
    {
        if ($_GET['creadas']==0) //creadas == 0 indica el registro de ofertas (histórico).
            $id_oferta = OfertaCuponHistorico($_GET['cupon']);    
        else
            $id_oferta = OfertaCupon($_GET['cupon']);     
    }
}   
*/

//die('creadas '.$_GET['creadas'].' idoferta: '.$_GET['id_oferta'].' cupon: '.$_GET['cupon']);

if (request('creadas')==0) //creadas == 0 indica el registro de ofertas (histórico).
{
    
    if (trim($id_oferta)=='' and trim(request('cupon'))!='') 
        $id_oferta = OfertaCuponHistorico(request('cupon'));
        //die($id_oferta);
    if ($id_distribuidor)
    {
     
	 $cupones = GetCuponesOfertaHistorico (null,null,null,null,$id_distribuidor);
   
     if (count($cupones)==0) die('No se han encontrado cupones');
     $o = array();
    }
    else 
    {
     $cupones = GetCuponesOfertaHistorico($id_oferta);

	 if (count($cupones)==0) die('No se han encontrado cupones');
     $o = GetOfertasHistoricoCA($id_oferta);
     $o = $o[0];
    }
         //die('error '.$id_oferta.'-'.$_GET['cupon']);
    
}
else
{
    $cupones = GetCuponesOfertaHistorico($id_oferta);
    if (count($cupones)==0) die('No se han encontrado cupones');
    $o = GetOfertasCA($id_oferta);
    $o = $o[0];
    
}

 
$validados=0;
$pendientes=0;
$vendidos=0;
$facturados=0;
$cobrados=0;
$comerciales=0;
//$devueltos=0;

foreach ($cupones as $n) {if ($n->usado==0) $pendientes+=1;else $validados+=1;}
foreach ($cupones as $n) 
{
    if ($n->vendido==1) $vendidos+=1;
    if ($n->facturado==1) $facturados+=1;
    if ($n->cobrado==1) $cobrados+=1;
    if ($n->comercial==1) $comerciales+=1;
}

//foreach ($cupones as $n) {if (trim($n->transaccionRembolso)!='') $devueltos+=1;}
$ancho_campos_cabecera = array(14,14,14,14,14,14,14,14);

//Vista de establecimientos: (deberá psarse a un tpl)
?>
<div id="cupones">  
    <table>
        <tr class="cabecera">
            <td width='2%'></td>
            <td style="width:<?php echo($ancho_campos_cabecera[0]);?>%;"><span class="label_">Vendidos</span></td>
            <td style="width:<?php echo($ancho_campos_cabecera[1]);?>%;"><span class="label_">Validados</span></td>
            <td style="width:<?php echo($ancho_campos_cabecera[2]);?>%;"><span class="label_">Pendientes</span></td>
            <td style="width:<?php echo($ancho_campos_cabecera[3]);?>%;"><span class="label_">Facturados</span></td>
            <td style="width:<?php echo($ancho_campos_cabecera[4]);?>%;"><span class="label_">Cobrados</span></td>
            <td style="width:<?php echo($ancho_campos_cabecera[5]);?>%;"><span class="label_">Comerciales</span></td>
            
            <!--<td style="width:20%;"><span class="label_">Devueltos</span></td>-->
         
            <td style="<?php echo(isset($_GET['id_distribuidor'])?'visibility:hidden':'')?>;width:<?php echo($ancho_campos_cabecera[6]);?>%;"><span class="label_">Nº Oferta</span></td>
            <td><span class="label_"></span></td>
        </tr>
        <tr>    
     <!--<td style="width:20%;text-align:left;"><input type="button"  onclick="javascript:buscar_cheque(<?php echo($id_establecimiento);?>)" value="Validar"></td> -->
          <td width='10%'></td>
          <td>
              <input class="input" type="text" style="text-align:center;width:60px;" disabled value="<?php echo($vendidos);?>">
          </td>
          <td>
              <input class="input" type="text" style="text-align:center;width:60px;" disabled value="<?php echo($validados);?>">
          </td>
          <td>
              <input class="input" type="text" disabled  style="text-align:center;width:60px;" value="<?php echo($pendientes);?>">
          </td>
          <td><input class="input" type="text" disabled  style="text-align:center;width:60px;" value="<?php echo($facturados);?>"></td>
          <td><input class="input" type="text" disabled  style="text-align:center;width:60px;" value="<?php echo($cobrados);?>"></td>
          <td><input class="input" type="text" disabled  style="text-align:center;width:60px;" value="<?php echo($comerciales);?>"></td>
          
          <!--<td style="width:15%;">
              <input class="input" type="text" disabled  style="text-align:center;width:60px;" value="<?php //echo($devueltos);?>">
          </td>-->
     
          <td>
              <input class="input" type="text" disabled  style="<?php echo(isset($_GET['id_distribuidor'])?'visibility:hidden':'')?>;text-align:center;width:60px;" value="<?php echo($id_oferta);?>">
          </td>

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
        <?php /* 
            if ($o->observaciones!="")  $class='no_disponible'; 
            else $class="marcat_gris";            
       */ ?>

       <!-- <td class="<?php echo($class);?>" style="padding:4px;">
            <a class="<?php echo($class);?>" style="font-size:14px;color:white;" href="javascript:observaciones_cupon_oferta(<?php echo($idOferta);?>,0,'<?php echo($o->observaciones);?>',<?php echo($_GET['creadas']);?>)">
            Observaciones</a>
        </td> -->           
      </tr>
      <table width="95%">   

      <!--
          <tr>
       <td width='2%'></td>
       <td class="inicial" ></td>
       <td class="borderg num_cupon" style="font-weight:bold;">Cupón</td>
      
       <td colspan="7">
       </td>

       </tr> -->


    <?php
   
    //cabecera_cupones();
    $i=0;

    $id_oferta_cabecera = $id_oferta;
    foreach($cupones as $c)
      {
        //var_dump($c);die;
      $i=$i+1;   

      $year = substr($c->fechaIni,0,4);
      $month = substr($c->fechaIni,5,2);
      $day = substr($c->fechaIni,8,2);
      $hour = substr($c->fechaIni,11,5);
      $sfecha = $day."/".$month."/".$year." ".$hour;

      
     $o = GetOfertasHistoricoCA($c->idOfertaHist);
     $o = $o[0];      
            
//var_dump($c);
    $ancho_comun=1;
    $ancho_columnas = array(4,4,30,12,$ancho_comun,$ancho_comun,$ancho_comun,$ancho_comun,$ancho_comun,$ancho_comun,$ancho_comun,$ancho_comun,$ancho_comun);
    if ($i==1){
    ?>
      <tr style="text-align:right;color:#555555;font-weight:bold;font-size:11px;">
       <td width='<?php echo($ancho_columnas[0]);?>%'></td>
       <td width='<?php echo($ancho_columnas[1]);?>%'></td>
       <td width='<?php echo($ancho_columnas[2]);?>%'></td>
       <td width='<?php echo($ancho_columnas[3]);?>%' ></td>
       <td class="registro_cupon" width='<?php echo($ancho_columnas[4]);?>%' ></td>
       <td class="registro_cupon" width='<?php echo($ancho_columnas[5]);?>%' ></td>
       <td class="registro_cupon" width='<?php echo($ancho_columnas[6]);?>%' ></td>
       <td class="registro_cupon" width='<?php echo($ancho_columnas[7]);?>%' ></td>
       <td class="registro_cupon" width='<?php echo($ancho_columnas[8]);?>%' ></td>
       <td  width='<?php echo($ancho_columnas[9]);?>%' ></td>
       <td class="registro_cupon" width='<?php echo($ancho_columnas[10]);?>%' >F.</td>
       <td style="font-weight:bold;"  width='<?php echo($ancho_columnas[11]);?>%' class="registro_cupon">Co.</td>
       <td style="font-weight:bold;" class="registro_cupon"  width='<?php echo($ancho_columnas[12]);?>%' >Cm.</td>
     </tr>
     <?php } ?>
      <tr>
       <td width='2%'></td>
       <td class="inicial" ><?php echo($i." - ");?></td>
       <td class="inicial" ><?php echo($o->idDesc);?></td>
       
       <td class="num_cupon"><?php echo($c->cupon);?></td>
       <!--<td class="borderg" style="width:150px;"><?php //echo($c->transaccionCompra);?></td>-->
       <?php //printf("%06d", $c->cupon);  ?>
       <td class="registro_cupon boton_dispon">
            <?php
                $class='no_disponible';$titulo='??';
                if ($c->usado==1) {$class='no_disponible';$titulo='Cupón validado';}
                else if ($c->usado==3) {$class='cancelado';$titulo='Cupón cancelado';}
                else
                {
                if ($c->vendido==1)  {$class='vendido';$titulo='Cupón vendido';}
                }
            
                $style_dispon = (($c->usado==1)?'font-size:10px;color:#FFFFFF;':'').'display:block;width:105px;height:17px;text-align:center;';
            ?>
            <?php if ($c->vendido == 1 or $c->usado == 1 or $c->usado == 3) { ?>
                    <?php
                    if (isset($_GET['id_distribuidor']))
                    {
                    ?>
                    <a title="<?php echo($titulo);?>" style="<?php echo($style_dispon);?>" class="<?php echo($class);?>" href="javascript:validar_cupon_oferta(<?php echo($id_oferta);?>,'<?php echo($c->cupon);?>',<?php echo(($c->usado==0)?0:1);?>,0,<?php echo($c->idDistribuidor);?>)">
                    <?php } else  {?>
                    <a title="<?php echo($titulo);?>" style="<?php echo($style_dispon);?>" class="<?php echo($class);?>" href="javascript:validar_cupon_oferta(<?php echo($id_oferta);?>,'<?php echo($c->cupon);?>',<?php echo(($c->usado==0)?0:1);?>,0)">
                    <?php } ?>
                    
            <?php } else { ?>
                    <a title="<?php echo($titulo);?>"  style="<?php echo($style_dispon);?>" class="<?php echo($class);?>" href="javascript:void();">
            <?php }
                if ($c->usado==3 or $c->usado==0)  { 
                    if ($c->usado==3) echo('cancelado');?>
             <?php } elseif($c->usado==1) echo($sfecha);?> 
            </a>
       </td>
       <td class="registro_cupon observaciones">
            <?php 
                if ($c->observaciones!="")  $class='no_disponible'; 
                else $class="marcat_gris";            
            
            if (isset($_GET['id_distribuidor']))
            {
            ?>
                <a  class="<?php echo($class);?> botones_texto" style="width:102px;" href="javascript:observaciones_cupon_oferta(<?php echo($id_oferta);?>,'<?php echo($c->cupon);?>','<?php echo($c->observaciones);?>',<?php echo($_GET['creadas']);?>,<?php echo($id_distribuidor);?>)">
                Observaciones</a>
            <?php
            }
            else 
            {?>
                <a  class="<?php echo($class);?> botones_texto" style="width:102px;" href="javascript:observaciones_cupon_oferta(<?php echo($id_oferta);?>,'<?php echo($c->cupon);?>','<?php echo($c->observaciones);?>',<?php echo($_GET['creadas']);?>)">
                Observaciones</a>
            <?php
            } ?>
            
       </td>
       <td class="registro_cupon email">
            <?php
            if (isset($_GET['id_distribuidor']))
            {
            ?>
            <a style="width:22px;font-size:10px;color:white;" class="marcat_gris" href="javascript:mail_cupon_oferta(<?php echo($id_oferta);?>,'<?php echo($c->cupon);?>',0,<?php echo($c->idDistribuidor);?>)">
            <?php } else  {?>
            <a style="width:22px;font-size:10px;color:white;" class="marcat_gris" href="javascript:mail_cupon_oferta(<?php echo($id_oferta);?>,'<?php echo($c->cupon);?>',0)">
            <?php } ?>
            <img width="22px;" src='tabs/img/email.png'></a>
       </td>
       <td class="registro_cupon cancelar" >
            <?php
            if (isset($_GET['id_distribuidor']))
            {
            ?>
                <a title="Cancelar cupón" style="border:none;background:none;width:20px;height:22px;display:block;" class="disponible" href="javascript:validar_cupon_oferta(<?php echo($id_oferta);?>,'<?php echo($c->cupon);?>',3,0,<?php echo($c->idDistribuidor)?>)">
            <?php } else { ?>
                <a title="Cancelar cupón" style="border:none;background:none;width:20px;height:22px;display:block;" class="disponible" href="javascript:validar_cupon_oferta(<?php echo($id_oferta);?>,'<?php echo($c->cupon);?>',3,0)">
            <?php } ?>
                <img style="width:20px;height:20px;" src="../../../img/calabera.png">
                </a>    
       </td>
       <?php
       $idofertaHist = ($id_oferta_cabecera!=0)?$c->idOfertaHist:0;
       ?>
       <td class="registro_cupon cancelar" >
            <?php
            if (isset($_GET['id_distribuidor']))
            {
            ?>
                <a title="Eliminar cupón" style="border:none;background:none;width:20px;height:22px;display:block;" class="disponible" href="javascript:validar_cupon_oferta(<?php echo($c->idOfertaHist);?>,'<?php echo($c->cupon);?>',4,0,<?php echo($c->idDistribuidor);?>)">
            <?php } else { ?>
                <a title="Eliminar cupón" style="border:none;background:none;width:20px;height:22px;display:block;" class="disponible" href="javascript:validar_cupon_oferta(<?php echo($c->idOfertaHist);?>,'<?php echo($c->cupon);?>',4,0)">
            <?php } ?>                        
                <img style="width:20px;height:20px;" src="../img/esborra.gif">
                </a>    
       </td>

       <td style="padding-left:10px;font-weight:bold;" class="registro_cupon cliente">
            <?php
            if (isset($_GET['id_distribuidor']) and $_GET['id_distribuidor'] == _DISTRIBUIDOR_PRUEBA_)
            {
            ?>
			<a class="marcat_gris botones_texto" style="width:120px;" title="Datos usuario"  href="javascript:edita_distribuidor(<?php echo($c->idDistribuidor);?>,<?php echo($idofertaHist);?>,1,'<?php echo($c->cupon);?>');">
			<?php
			} else 
			{ ?>
			<a class="marcat_gris botones_texto" style="width:120px;" title="Datos usuario"  href="javascript:edita_distribuidor(<?php echo($c->idDistribuidor);?>,<?php echo($idofertaHist);?>,1);">
			<?php
			} ?>
			Datos Distribuidor
                </a>    
       </td>

       <td class="registro_cupon" style="padding-right:10px;">
            <?php
            if (isset($_GET['id_distribuidor']))
            {
            ?>           
            <a href="javascript:validar_cupon_oferta(<?php echo($c->idOfertaHist);?>,'<?php echo($c->cupon);?>',<?php echo($c->facturado?6:5);?>,0,<?php echo($c->idDistribuidor)?>)" id="facturado" title="Cupón <?php echo($c->facturado?"":"no");?> facturado" >
            <?php } else { ?>
            <a href="javascript:validar_cupon_oferta(<?php echo($c->idOfertaHist);?>,'<?php echo($c->cupon);?>',<?php echo($c->facturado?6:5);?>,0)" id="facturado" title="Cupón <?php echo($c->facturado?"":"no");?> facturado" >
            <?php } ?>    

               <img style="width:17px;height:20px;" src="../../../../img/<?php if ($c->facturado) echo('facturado.png'); else echo('no_facturado.png');?>">
            </a>    
       </td>
       <td class="registro_cupon" style="padding-right:10px;">
           <?php
           if (isset($_GET['id_distribuidor']))
            {
            ?>           
            <a href="javascript:validar_cupon_oferta(<?php echo($c->idOfertaHist);?>,'<?php echo($c->cupon);?>',<?php echo($c->cobrado?8:7);?>,0,<?php echo($c->idDistribuidor)?>)" id="cobrado" title="Cupón <?php echo($c->cobrado?"":"no");?> cobrado" >
            <?php } else { ?>
            <a href="javascript:validar_cupon_oferta(<?php echo($c->idOfertaHist);?>,'<?php echo($c->cupon);?>',<?php echo($c->cobrado?8:7);?>,0)" id="cobrado" title="Cupón <?php echo($c->cobrado?"":"no");?> cobrado" >
            <?php } ?>               
                <img style="width:17px;height:20px;" src="../../../../img/<?php if ($c->cobrado) echo('facturado.png'); else echo('no_facturado.png');?>">
            </a>    
       </td>
       <td>
           <?php
           if (isset($_GET['id_distribuidor']))
            {
            ?>           
            <a href="javascript:validar_cupon_oferta(<?php echo($c->idOfertaHist);?>,'<?php echo($c->cupon);?>',<?php echo($c->comercial?10:9);?>,0,<?php echo($c->idDistribuidor)?>)" id="comercial" title="Cupón <?php echo($c->comercial?"":"no");?> comercial" >
            <?php } else { ?>
            <a href="javascript:validar_cupon_oferta(<?php echo($c->idOfertaHist);?>,'<?php echo($c->cupon);?>',<?php echo($c->comercial?10:9);?>,0)" id="comercial" title="Cupón <?php echo($c->comercial?"":"no");?> comercial" >
            <?php } ?>               
               <img style="width:17px;height:20px;" src="../../../../img/<?php if ($c->comercial) echo('facturado.png'); else echo('no_facturado.png');?>">
            </a>    
       </td>
       
       <?php
       /*
        if ($c->transaccionRembolso!="")
       {
          $year = substr($c->fechaRembolso,0,4);
          $month = substr($c->fechaRembolso,5,2);
          $day = substr($c->fechaRembolso,8,2);
          $hour = substr($c->fechaRembolso,11);
          $sfechaRembolso = $day."/".$month."/".$year." ".$hour;
           
        */ 
        ?>
       <!--<td class="registro_cupon">
        <span class="devuelto" title="<?php //echo($sfechaRembolso);?>">Devuelto</span>
       </td>
       -->
       <?php
       //}
       ?>

       </tr>
    <?php
    //if ($i==15) echo("</table></td><td><table>");
    } 
?>     
      </table>
      </td>
     </tr> 
    </table> 
</div> <!-- fin div cupones -->    

<style>
    .botones_texto{
        color:#FFFFFF !important;
        font-size:10px;
        width:90px;
        padding:2px;
        display:block;        
    } 

/*ancho columnas (<td>) */

    .inicial
    {
        width:19px;
    }


    .boton_dispon
    {
        width:107px;
    }

    .num_cupon
    {
        width:106px;
    }

    .observaciones
    {
        width:105px;
    }

    .devuelto
    {
        width:50px;
        background-color: #FF0000;
        padding:2px;
        color:#FFFFFF;
        font-weight:bold;
        border:1px solid #000000;
        text-decoration:blink;
    }
    .email
    {
        width:22px;
    }

    .cancelar
    {
        width:22px;
    }

    .cliente
    {
        width:107px;
    }

    /* fin ancho columnas */

    .boton_talonario {
    background: none repeat scroll 0 0 #888888;
    color: #FFFFFF;
    font-style: italic;}

    #cupones {
        font-size:12px;
    }

    .registro_cupon {
        height:30px;
        padding-right:9px;
        vertical-align:middle;
        text-align:left;
    }

   
</style>

