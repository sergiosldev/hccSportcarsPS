 <?php
include_once(dirname(__FILE__).'/config_events_new.php');

include dirname(__FILE__).'/funciones_cupon_oferta.php'; 

include dirname(__FILE__).'/funciones_cupon_oferta_historico.php'; 
$cupones=1;
include dirname(__FILE__).'/funciones_ofertas.php';  

//include dirname(__FILE__).'/funciones_cupon_vista.php';              

//die('creadas '.$_GET['creadas'].' idoferta: '.$_GET['id_oferta'].' cupon: '.$_GET['cupon']);
//en caso de que $_GET['creadas'] == 0 (registro de ofertas 'histórico'), id_oferta será el id de histórico id_oferta_hist
$id_oferta = intval($_GET['id_oferta']); 

//$id_oferta = $_POST['id_oferta'];  
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


if ($_GET['creadas']==0) //creadas == 0 indica el registro de ofertas (histórico).
{
 

    if (!$id_oferta && trim($_GET['cupon'])!='') 
	{
        $id_oferta = OfertaCuponHistorico($_GET['cupon']);
	}
	else 
	{
	//	die('idoferta '.$id_oferta);
	}
    //die('error '.$id_oferta.'-'.$_GET['cupon']);
	//die('idoferta '.$id_oferta);
    $cupones = GetCuponesOfertaHistorico($id_oferta);
	//echo('oferta: '.$id_oferta);var_dump($cupones);die('creadas '.$_GET['creadas']);
    if (count($cupones)==0) die('No se han encontrado cupones');
    $o = GetOfertasHistorico($id_oferta);
}
else
{
    $cupones = GetCuponesOferta($id_oferta);
    if (count($cupones)==0) die('No se han encontrado cupones');
    $o = GetOfertas($id_oferta);
}


$o = $o[0];
 

$validados=0;
$pendientes=0;
$vendidos=0;
$devueltos=0;

foreach ($cupones as $n) {if ($n->usado==0) $pendientes+=1;else $validados+=1;}
foreach ($cupones as $n) {if ($n->vendido==1) $vendidos+=1;}
foreach ($cupones as $n) {if (trim($n->transaccionRembolso)!='') $devueltos+=1;}


//Vista de establecimientos: (deberá psarse a un tpl)
?>
<div id="cupones">  
    <table>
        <tr class="cabecera">
            <td width='2%'></td>
            <td style="width:20%;"><span class="label_">Vendidos</span></td>
            <td style="width:20%;"><span class="label_">Validados</span></td>
            <td style="width:20%;"><span class="label_">Pendientes</span></td>
            <td style="width:20%;"><span class="label_">Devueltos</span></td>
            <td><span class="label_">Nº Oferta</span></td>
            <td><span class="label_"></span></td>
        </tr>
        <tr>    
     <!--<td style="width:20%;text-align:left;"><input type="button"  onclick="javascript:buscar_cheque(<?php echo($id_establecimiento);?>)" value="Validar"></td> -->
          <td width='10%'></td>
          <td style="width:20%;">
              <input class="input" type="text" style="text-align:center;width:60px;" disabled value="<?php echo($vendidos);?>">
          </td>
          <td style="width:20%;">
              <input class="input" type="text" style="text-align:center;width:60px;" disabled value="<?php echo($validados);?>">
          </td>
          <td style="width:15%;">
              <input class="input" type="text" disabled  style="text-align:center;width:60px;" value="<?php echo($pendientes);?>">
          </td>
          <td style="width:15%;">
              <input class="input" type="text" disabled  style="text-align:center;width:60px;" value="<?php echo($devueltos);?>">
          </td>
          <td style="width:15%;">
              <input class="input" type="text" disabled  style="text-align:center;width:60px;" value="<?php echo($id_oferta);?>">
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

    <br />
	<input id="btn_mover_a_cupon" type="button" style="display:block;" onclick="javascript:mover_a_cupon();" value="Ir a cupón marcado">                       
	<br />
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
      <table>   

      <tr>
       <td width='2%'></td>
       <td class="inicial" ></td>
	   <td style="font-weight:bold;">Origen</td>
       <td style="width:265px;font-weight:bold;" >Ruta</td>	   
       <td style="width:82px;font-weight:bold;" >F. Compra</td>	   
       <td class="borderg num_cupon" style="font-weight:bold;">Cupón</td>
       <td class="borderg" style="width:150px;font-weight:bold;">Transacción</td>
       <?php //printf("%06d", $c->cupon);  ?>
       <td colspan="7">
       </td>

       </tr>



    <?php
   
    //cabecera_cupones();
    $i=0;

    
    foreach($cupones as $c)
      {
        //var_dump($c);die;
      $i=$i+1;   

      $year = substr($c->fechaIni,0,4); 
      $month = substr($c->fechaIni,5,2);
      $day = substr($c->fechaIni,8,2);
      $hour = substr($c->fechaIni,11,5);
      $sfecha = $day."/".$month."/".$year." ".$hour;    
      
	  
	  $o = GetOfertasHistorico($c->idOfertaHist);                                        
      $o = $o[0];      

//var_dump($c);
	   
	   $opciones_of=GetOpcionesOfertaHist($c->idOfertaHist);                                    
	   
	   if (count($opciones_of)>0)  
		{
			foreach($opciones_of as $opc)
			{
			//var_dump($opc);echo('<br>');
				if ($opc->idOpcionOferta==$c->idOpcionOferta)
				{
					$idDesc = $opc->idDesc;         
					break;       
				}
			}
		}
		else $idDesc = $o->idDesc;        
    
	switch($c->empresa)
	{
		case 2:
			$emp = 'dream';
			break;
		case 3:
			$emp = 'hcc';
			break;
		default:
			$emp = 'motor';
	}

	/*       <tr <?php if (isset($_GET['cupon'])) {if ($_GET['cupon']==$c->cupon){echo('style="background: #ffc0c0;"');}}?>>  		*/

	?>
	
      <tr <?php if (isset($_GET['cupon'])) {if (strtolower($_GET['cupon'])==strtolower($c->cupon) || strtolower($_GET['cupon'])==strtolower($c->transaccionCompra)){echo('style="background: #ffc0c0;"');} }?>>                            
       <td width='2%'>
	   <?php 
		if (isset($_GET['cupon'])) 
		{
			if (strtolower($_GET['cupon'])==strtolower($c->cupon) || strtolower($_GET['cupon'])==strtolower($c->transaccionCompra))        
			{
			?>
			<a name="cupon_marcado"></a> 
			<?php
			}
		}
		?>
	   </td>
       <td class="inicial" ><?php echo($i." - ");?></td>                                           
	   <td><?php echo($emp);?></td>	             
       <td style="width:265px;"><?php echo($idDesc);?></td>                       
       <td class="borderg" style="font-size:10px;"><?php echo($c->fechaCompra);?></td>                      
	   <td class="borderg num_cupon"><?php echo($c->cupon);?></td>           
       <td class="borderg" style="width:150px;"><?php echo($c->transaccionCompra);?></td>
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
					<a title="<?php echo($titulo);?>" style="<?php echo($style_dispon);?>" class="<?php echo($class);?>" href="javascript:validar_cupon_oferta(<?php echo($id_oferta);?>,'<?php echo($c->cupon);?>',<?php echo(($c->usado==0)?0:1);?>,<?php echo($_GET['creadas']);?>)">
                    <?php /*
					<a title="<?php echo($titulo);?>" style="<?php echo($style_dispon);?>" class="<?php echo($class);?>" href="javascript:validar_cupon_oferta(<?php echo($c->idOfertaHist);?>,'<?php echo($c->cupon);?>',<?php echo(($c->usado==0)?0:1);?>,0);">
					<a title="<?php echo($titulo);?>" style="<?php echo($style_dispon);?>" class="<?php echo($class);?>" href="javascript:validar_cupon_oferta(<?php echo($id_oferta);?>,'<?php echo($c->cupon);?>',<?php echo(($c->usado==0)?0:1);?>,0);">
                    */ ?>    
						
            <?php } else { ?>
                    <a title="<?php echo($titulo);?>"  style="<?php echo($style_dispon);?>" class="<?php echo($class);?>" href="javascript:void();">
            <?php }
                if ($c->usado==3 or $c->usado==0)  { 
                    if ($c->usado==3) echo('cancelado');?>
             <?php } else echo($sfecha);?> 
            </a>
       </td>
       <td class="registro_cupon observaciones">
            <?php 
                if ($c->observaciones!="")  $class='no_disponible'; 
                else $class="marcat_gris";            
            ?>
            <a  class="<?php echo($class);?> botones_texto" style="width:102px;" href="javascript:observaciones_cupon_oferta(<?php echo($id_oferta);?>,'<?php echo($c->cupon);?>','<?php echo($c->observaciones);?>',<?php echo($_GET['creadas']);?>)">
            Observaciones</a>
       </td>
       <td class="registro_cupon email">
            <a style="width:22px;font-size:10px;color:white;" class="marcat_gris" href="javascript:mail_cupon_oferta(<?php echo($id_oferta);?>,'<?php echo($c->cupon);?>',<?php echo($_GET['creadas']);?>)">
            <img width="22px;" src='tabs/img/email.png'></a>
       </td>
       <td class="registro_cupon cancelar" >
                <a title="Cancelar cupón" style="border:none;background:none;width:20px;height:22px;display:block;" class="disponible" href="javascript:validar_cupon_oferta(<?php echo($id_oferta);?>,'<?php echo($c->cupon);?>',3,<?php echo($_GET['creadas']);?>)">
                <img style="width:20px;height:20px;" src="../../../img/calabera.png">
                </a>    
       </td>
       <td class="registro_cupon cancelar" >
                <a title="Eliminar cupón" style="border:none;background:none;width:20px;height:22px;display:block;" class="disponible" href="javascript:validar_cupon_oferta(<?php echo($id_oferta);?>,'<?php echo($c->cupon);?>',4,<?php echo($_GET['creadas']);?>)">
                <img style="width:20px;height:20px;" src="../img/esborra.gif">
                </a>    
       </td>

       <td style="padding-left:10px;font-weight:bold;" class="registro_cupon cliente">
                <a class="marcat_gris botones_texto" title="Datos usuario"  href="javascript:edita_usuario(<?php echo($c->idUsuario);?>,<?php echo($c->idOferta);?>);">
                Datos cliente
                </a>    
       </td>
       <?php
        if ($c->transaccionRembolso!="")
       {
          $year = substr($c->fechaRembolso,0,4);
          $month = substr($c->fechaRembolso,5,2);
          $day = substr($c->fechaRembolso,8,2);
          $hour = substr($c->fechaRembolso,11);
          $sfechaRembolso = $day."/".$month."/".$year." ".$hour;
           
        ?>
       <td class="registro_cupon">
        <span class="devuelto" title="<?php echo($sfechaRembolso);?>">Devuelto</span>
       </td>
       <?php
       }
       ?>

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

                                     

