<?php
if(!isset($_REQUEST['ciudad']))$_REQUEST['ciudad']='';
//$_REQUEST['ciudad']='';
include('config_events_new.php');
// BUGGY
if($_REQUEST['tipus'] == '_buggy_')
  include 'dies_graella3.php';
else if($_REQUEST['tipus']=='_bferrari_' || $_REQUEST['tipus']=='_blamborghini_')
  include 'dies_graella4.php';
else 
  include 'dies_graella.php';

  include_once 'functions.php';

define('TEMPS',$_REQUEST['data']); // Dia que li arriba
$libres=false;

graella($array_hores);
         
/*
 $hores array(hora,info) 
 $lliure array(hora)  
 */
function graella($hores) {
  global $link,$persones,$libres;
  $ancho_columna=array(80,270,80,80,80,80);
  
?>
 
<table style="height:55px;border:none;">
<tr>
    <td width="<?php echo($ancho_columna[0]);?>px"></td>
    <td width="<?php echo($ancho_columna[1]);?>px" align="left" style="color:#000;font-size:13px;text-align:left;font-weight:bold;"></td>
    <td width="<?php echo($ancho_columna[2]+$ancho_columna[3]);?>px" align="left" style="color:#000;font-size:13px;text-align:left;font-weight:bold;">DIA: <?php echo(implode('/',array_reverse(explode('-',$_REQUEST['data']))));?><br>Igualada</td>
    <td colspan="<?php echo(count($ancho_columna)-4);?>"></td>
</tr>
</table>
<table class="ma" cellspacing=0 style="border-spacing:0;border:1px solid;border-bottom:none;">
<tr>
    <td width="<?php echo($ancho_columna[0]);?>px"  class="cabecera_listado">Hora</td>
    <td width="<?php echo($ancho_columna[1]);?>px" class="cabecera_listado">Nombre cliente</td>
    <td width="<?php echo($ancho_columna[2]);?>px"  class="cabecera_listado"><?php echo($_REQUEST['tipus']);?></td>
    <td width="<?php echo($ancho_columna[3]);?>px" class="cabecera_listado">porsche</td>
    <td width="<?php echo($ancho_columna[4]);?>px"  class="cabecera_listado">copiloto</td>
    <td width="<?php echo($ancho_columna[5]);?>px"  class="cabecera_listado">Anulado</td>
</tr>
<?php    
$i=0;
$info=' ';
$tipus=$_REQUEST['tipus'];
$tarda='';
$mati='#';

foreach($hores as $hora=>$info) {
$_h=$info;

$info='';

$tipus=$_REQUEST['tipus'];  
$hora=str_replace('@','',$hora);
if($hora=='c'){
 ?>
  </table>
  <table class="ta" cellspacing=0 style="border-spacing:0;border:1px solid;border-top:0;">
    <tr style="visibility:hidden;">
       <td width="<?php echo($ancho_columna[0]);?>px"><!--Tarde<br><br />--></td>
       <td colspan="<?php echo(count($ancho_columna)-1);?>"></td>
    </tr>    
    
<?php
  $tarda='#';
  $mati='';
  continue ; 
}

// cas graella 1 sol cotxe
if(($_REQUEST['tipus']=='_porsche_' || $_REQUEST['tipus']=='_lotus_') && $i%2 ){
    $i++;
    continue ; 
}

$sep=''; 
$hora_bona=$hora;  


if($_REQUEST['tipus']=='_bferrari_' || $_REQUEST['tipus']=='_blamborghini_')
  $transform = 2;
else $transform = 1;

$hora = label_hora($hora, $persones, $transform);

    //$perms=permisos($tipus,TEMPS,$hora_bona);

    $cad='<button  class="no_disponible">·</button>';
    

    $t_aux='i.tipus_event="'.$tipus.'"';

   // graellas dobles amb dos tipus d'events <<  si estreu aixo i es posen tipus queda com abans

  if( $tipus=='ferrari' ){
    $t_aux='(i.tipus_event="ferrari" OR i.tipus_event="ferrari_porsche901") ';
  } elseif($tipus=='lamborghini' ){
    $t_aux='(i.tipus_event="lamborghini_lotus" OR i.tipus_event="lamborghini") ';
  }
    $tipo_reg = '';
// fi graelles doblesvf

    $sql='SELECT i.*,b.marca as marca_bautizo FROM `events'.$_REQUEST['ciudad'].'` as i LEFT JOIN bautizos b ON i.id_event = b.id_event and i.tipus_event = b.tipus_event WHERE i.id_event="'.TEMPS.'@'.$hora_bona.'" AND '.$t_aux.'';
    $result=mysqli_query($link,$sql);
    if(mysqli_num_rows($result)) { // plaza ocupada
      $cad='<button  class="no_disponible">·</button>';
      $r=mysqli_fetch_assoc($result);
      $tipo_reg = $r['tipus_event'];
      
      
      //width="12%" width="13%" width="13%"   width="15%"  width="17%"
      
         $cliente = utf8_encode($r['pilot']);
    } else {
        $cliente = '&nbsp;';
    }

    $hora_cmp = $hora;
    //echo('hora '.$hora_cmp.' comparacion '.(strtotime($hora_cmp)==strtotime('12:00')));
    if (strtotime($hora_cmp) >= strtotime('12:00') and strtotime($hora_cmp)<strtotime('12:30') or 
        strtotime($hora_cmp) >= strtotime('14:30') and strtotime($hora_cmp)<strtotime('16:00') or 
        strtotime($hora_cmp) >= strtotime('19:30')
        ) 
         $clase_especial = 'registro_especial';  
    else $clase_especial ='';
    
    $info='
     <td width="'.$ancho_columna[1].'px" class="texto_listado '.$clase_especial .'">'.(($cliente!='no disponible')?$cliente:'&nbsp;').'  </td>
     <td width="'.$ancho_columna[2].'px" class="texto_listado '.$clase_especial .'">&nbsp;</td>
     <td width="'.$ancho_columna[3].'px" class="texto_listado '.$clase_especial.'">&nbsp;</td>
     <td width="'.$ancho_columna[4].'px" class="texto_listado '.$clase_especial.'">&nbsp;</td>
     <td width="'.$ancho_columna[5].'px" class="texto_listado '.$clase_especial.'">&nbsp;</td>';

 // recuperem info
    ?>
    <tr>
        <td width="<?php echo($ancho_columna[0]);?>px"  class="texto_listado" style="background-color:#B2A1C7;text-align:center;">
          <?php echo  ''.substr($hora,0,strlen($hora)-3)  ?>&#160;&#160; 
        </td>
        <?php echo $info; ?>
    </tr>
    <?php
    // BUGGY mod 3 places
    /*if(!(($i+1)%$persones))echo '<tr><td colspan="3" style="height:1px;background:#444"></td></tr>';
    echo $sep;*/ 
    $i++;
  }
  ?>
</table>
<table style="border:none;"><tr><td height="20px"></td></tr></table>
<table style="border:1px solid;border-spacing:0;">
  <tr><td width="<?php echo($ancho_columna[0]);?>px"  class="texto_listado" style="background-color:#FCD5B4;">Instructor</td><td class="texto_listado" width="<?php echo($ancho_columna[1]);?>px">&nbsp;</td></tr>  
  <tr><td width="<?php echo($ancho_columna[0]);?>px"  class="texto_listado" style="background-color:#FCD5B4;">Total</td><td class="texto_listado" width="<?php echo($ancho_columna[1]);?>px">&nbsp;</td></tr>  
</table>
<?php
}

?>
<style>
 .cabecera_listado{
     color:#000;
     background-color:#B8CCE4;
     font-size:13px;
     border: 1px solid #000000;
     text-align:center;
     font-weight:bold;
 }

 .texto_listado{
     padding-left:5px;
     color:#000;
     font-size:13px;
     border: 1px solid #000000; 
     text-align:left;
 }

 .registro_especial{
     background-color:#C5BE97;
 }

 .mostra{
    display:none;
    width:0px;
}
</style>

