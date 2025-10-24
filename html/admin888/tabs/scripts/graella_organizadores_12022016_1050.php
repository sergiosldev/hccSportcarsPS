<link rel="stylesheet" type="text/css" href="../css/style.css">

<?php
 
if(!isset($_REQUEST['ciudad']))$_REQUEST['ciudad']='';
//$_REQUEST['ciudad']='';

include('config_events.php');
// BUGGY
if($_REQUEST['tipus'] == '_buggy_')
  include 'dies_graella4.php';
  //include 'dies_graella3.php';
  //include 'dies_graella.php';
else if($_REQUEST['tipus']=='_bferrari_' || $_REQUEST['tipus']=='_blamborghini_')
  include 'dies_graella4.php';
else  
  include 'dies_graella.php';

include_once 'functions.php';

define('TEMPS',$_REQUEST['data']); // Dia que li arriba
$libres=false;
ob_start();
graella($array_hores);
$content = ob_get_contents();
ob_end_clean();
die($content);
/*
 $hores array(hora,info) 
 $lliure array(hora)  
 */
function graella($hores) {
  global $link,$persones,$libres;

  
echo('<div style="padding-left:100px;"><span class="cabecera">Dia actual:</span> <span style="color:#f04;font-weight:bold;">'.implode('/',array_reverse(explode('-',TEMPS))).'</span><span class="cabecera" style="margin-left:330px;">'.strtoupper(($_REQUEST['ciudad']=='')?'Barcelona':$_REQUEST['ciudad']).'</span></div>');
  
?>

<table style="border:none;">
<?php
echo('<tr><td style="width:600px;text-align:center;"><legend style="font-weight:bold;padding:5px;font-size:14px;background-color:#ddd;color:#000;text-align:center;">'.return_tipus_e($_REQUEST['tipus']).'</legend></td></tr>');
?>
</table> 
<?php if ($_REQUEST['horas']!='t') 
{?>
<table  width="678px" class="ma" id="ma" cellspacing="0" cellpadding="0" style="padding-top:10px;padding-right:5px;border-spacing:0 14px;">
<?php 
header_pdf();
?>
<tr>
 <td style="width:50px;color:#000;font-size:13px;" align="left" class="info hora">Mañana<br><br /></td>
 <td style="width:10px;"></td>
 <td style="width:38px;" > </td>
  <td colspan="7"> </td>
</tr>
<?php    
}




$i=0;
$j=0; //mts 24012013.
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
	 
	 if($_REQUEST['horas']=='m') break;
 	 if($_REQUEST['horas']=='mt') echo('</table>'); 
 ?>
	<table cellspacing="0" cellpadding="0" width="678px" style="padding-top:10px;padding-right:5px;border-spacing:0 14px;"  class="ta" id="tarde">
	<?php if ($_REQUEST['horas']!='m') header_pdf(); ?>
    <tr>
      <td style="width:50px;color:#000;font-size:13px;" align="left" class="info hora">Tarde<br><br></td>
      <td style="width:10px;"></td>
      <td style="width:38px;"> </td>
      <td colspan="7"> </td>
    </tr>
<?php
  


  $tarda='#';
  $matif=$mati;
  $mati='';
  continue ; 
}
else if ($mati=='#' and $_REQUEST['horas']=='t') continue;

// cas graella 1 sol cotxe
if(($_REQUEST['tipus']=='_porsche_' || $_REQUEST['tipus']=='_lotus_') && $i%2 ){
    $i++;
    continue ; 
}

// cas graella buggy (2,3 fins a 4 persones per separació)
if($_REQUEST['tipus']=='_buggy_')
{
 //&& $i%2 
    switch($persones)
	{
		case 2:$mod=2;break;
		case 3:$mod=4;break;
		case 4:$mod=0;break;
		default: $mod=0;
	}
	if ($mod && ($i+1)%$mod==0 && $i)
		{
		$i++;
		continue;
		}
}

$sep=''; 
$hora_bona=$hora;  


if($_REQUEST['tipus']=='_bferrari_' || $_REQUEST['tipus']=='_blamborghini_')
  $transform = 2;
//mts 24012013
else if($_REQUEST['tipus'] == '_buggy_') {$transform=3;} 
//fi mts.  
else $transform = 1;

$hora = label_hora($hora, $persones, $transform);

    $perms=permisos($tipus,TEMPS,$hora_bona);

    if(!$perms) {
       $cad='<div  id="disponibilidad"    class="no_disponible cuadro">&nbsp;&nbsp;&nbsp;&nbsp;</div>';
    }
    // CAS RESERVA SOCI INACTIVA PERO DINS DEL PLAÇ
    if(substr($perms,0,2)=='@@') {
      $cad='<div  id="disponibilidad"    class="no_disponible cuadro">'.$perms.'</div>';
    }
    /** mts 28042012, desactivamos botón disponibilidad */
    else {        
		//echo(marca_bautizo(TEMPS,$hora_bona,$tipus));
		if (marca_bautizo(TEMPS,$hora_bona,$tipus))
		{	//echo('marca bautizo');
            $cad='<div  id="disponibilidad"    class="marca_bautizo cuadro" style="height:15px;">&nbsp;&nbsp;&nbsp;&nbsp;</div>';
        }
		else $cad='<div  id="disponibilidad"    class="disponible cuadro"  style="height:15px;">&nbsp;&nbsp;&nbsp;&nbsp;</div>';

    /* fin mts */
    }

   $t_aux='i.tipus_event="'.$tipus.'"';

   // graellas dobles amb dos tipus d'events <<  si estreu aixo i es posen tipus queda com abans

  if( $tipus=='ferrari' ){
    $t_aux='(i.tipus_event="ferrari" OR i.tipus_event="ferrari_porsche901") ';
  } elseif($tipus=='lamborghini' ){
    $t_aux='(i.tipus_event="lamborghini_lotus" OR i.tipus_event="lamborghini") ';
  }
// fi graelles dobles
    $tipo_reg = '';

    //$sql='SELECT i.* FROM `events'.$_REQUEST['ciudad'].'` as i WHERE i.id_event="'.TEMPS.'@'.$hora_bona.'" AND '.$t_aux.'';
    $sql='SELECT i.*,b.marca as marca_bautizo FROM `events'.$_REQUEST['ciudad'].'` as i LEFT JOIN bautizos'.$_REQUEST['ciudad'].' b ON i.id_event = b.id_event and i.tipus_event = b.tipus_event WHERE i.id_event="'.TEMPS.'@'.$hora_bona.'" AND '.$t_aux.'';
	
	$result=mysql_query($sql);

    if(mysql_num_rows($result)) { // plaza ocupada
      $cad='<div  id="disponibilidad" class="no_disponible cuadro">&nbsp;&nbsp;&nbsp;&nbsp;</div>';
      $r=mysql_fetch_assoc($result);
      //if($r['plazas']=='1')
	  //$cad='<div  id="disponibilidad"  class="no_disponible_carbassa cuadro"    >&nbsp;&nbsp;&nbsp;&nbsp;</div>';
      if (trim($r['email'])!='' or trim($r['email_confirm'])!='' or trim($r['email_persona_regala'])!='') 
	  $cad='<div  id="disponibilidad"  class="no_disponible_carbassa cuadro"    >&nbsp;&nbsp;&nbsp;&nbsp;</div>';
      
	  if($r['marca_bautizo']=='1') $cad='<div   id="disponibilidad"  class="marca_bautizo cuadro" style="height:15px;" ></div>';
      $tipo_reg = $r['tipus_event'];
 	  $border_style='margin-top:50px !important;margin-bottom:50px !important;';	
     
	  if (strlen(trim($r['codi_consum'])) > 18) $codi_consum=substr($r['codi_consum'],0,18).'<br>'.substr($r['codi_consum'],18);
	  else $codi_consum =  $r['codi_consum'];
	  $info='

         <td style="width:10px;background-color:#FFFFFF;vertical-align:middle;border-top:1px solid #000000;border-bottom:1px solid #000000;border-left:1px solid #000000;'.$border_style.'">
         <!--  <img  src="../img/persona_pdf.png" style="width:8px;height:18px;background-color:#FFFFFF;'.$border_style.'" alt="" />-->
		 </td>
         <td style="width:80px;font-size:10px;vertical-align:middle;border-top:1px solid #000000;border-bottom:1px solid #000000;'.$border_style.'" class="borderg"> 
         '.utf8_encode($r['pilot']).' '.utf8_encode($r['apellidos_piloto']).'  </td>
         <td  style="width:75px;color:#22f;font-weight:bold;font-size:10px;vertical-align:middle;font-weight:bold;border-top:1px solid #000000;border-bottom:1px solid #000000;'.$border_style.'" class="borderg"> '.$r['telefon'].'</td>
          <td  style="width:80px;font-size:10px;vertical-align:middle;border-top:1px solid #000000;border-bottom:1px solid #000000;'.$border_style.'" class="borderg"> 
         '.utf8_encode($r['persona_regala']).' '.utf8_encode($r['apellidos_persona_regala']).'  </td>
        <td style="width:75px;color:#f22;font-weight:bold;font-size:10px;vertical-align:middle;font-weight:bold;border-top:1px solid #000000;border-bottom:1px solid #000000;'.$border_style.'" class="borderg " align="left"  > '.$r['mobil_persona_regala'].' </td>
        <td  style="width:100px;font-size:10px;vertical-align:middle;border-top:1px solid #000000;border-bottom:1px solid #000000;'.$border_style.'" class="borderg " align="left" > '.utf8_encode($r['Observaciones']).' </td>
        <td  style="width:100px;font-size:10px;vertical-align:middle;border-top:1px solid #000000;border-bottom:1px solid #000000;border-right:1px solid #000000;border-bottom:1px solid #000000;'.$border_style.'" class="borderg " align="left" > 
			<table style="border:none;">
			  <tr>
				<td style="width:100px;border:none;">
				Localizador:<br>
				<span style="font-size:10px;" class="codigos">'.$r['codi_localtzador'].'</span><br>
				 Consumo:<br><span style="display:block;width:60px !important;font-size:10px;" class="codigos">'.$codi_consum.'</span>
				</td>
				<td style="width:50px;">'; 
				 if($r['marcat']=='1')
					 //$info.='<a class="_marcat" style=" background: none repeat scroll 0% 0% #0f0; border: 0px solid #000; padding: 1px 18px;width:50px;" href="javascript:void();")">&nbsp;&nbsp;</a>';
					 $info.='<div style="background: none repeat scroll 0% 0% #0f0; border: 0px solid #000; padding: 2px 8px;width:8px;">&nbsp;&nbsp;&nbsp;&nbsp;</div>';
				   //$info.='<a class="_marcat" style=" background: none repeat scroll 0% 0% #f00; border: 0px solid #000; padding: 1px;" href="javascript:marca_event(\''.$r['id'].'\',\''.$r['tipus_event'].'\',0)">&nbsp;&nbsp;</a>';
				 else
					//$info.='<a class="_marcat" style=" background: none repeat scroll 0% 0% #f00; border: 0px solid #000; padding: 1px 18px;width:50px;" href="javascript:void();">&nbsp;&nbsp;</a>';
					 $info.='<div style="background: none repeat scroll 0% 0% #f00; border: 0px solid #000; padding: 2px 8px;width:8px;">&nbsp;&nbsp;&nbsp;&nbsp;</div>';
				
							//$info.='<a class="_marcat" style=" background: none repeat scroll 0% 0% #0f0; border: 0px solid #000; padding: 1px 8px;" href="javascript:marca_event(\''.$r['id'].'\',\''.$r['tipus_event'].'\',0)">&nbsp;&nbsp;</a>';
				   //$info.='<a class="_marcat" style=" background: none repeat scroll 0% 0% #f00; border: 0px solid #000; padding: 1px;" href="javascript:marca_event(\''.$r['id'].'\',\''.$r['tipus_event'].'\',0)">&nbsp;&nbsp;</a>';

				
				
				$info.='
				</td>
		      </tr>
			  <tr>
			    <td style="width:50px;">.</td>
				<td style="width:60px;text-align:left;">
					<span style="font-weight:bold;color:#2222FF;">'.$r['origen'].'</span>
				</td>
			 </tr>
			 </table>
			</td>';

    } else {
	  $info='<td style="width:10px;background-color:#FFFFFF;vertical-align:middle;border:none;"></td>
		 <td style="width:80px;background-color:#FFFFFF;vertical-align:middle;border:none;"></td>
		 <td style="width:75px;background-color:#FFFFFF;vertical-align:middle;border:none;"></td>
		 <td style="width:80px;background-color:#FFFFFF;vertical-align:middle;border:none;"></td>
		 <td style="width:75px;background-color:#FFFFFF;vertical-align:middle;border:none;"></td>
		 <td style="width:100px;background-color:#FFFFFF;vertical-align:middle;border:none;"></td>
		 <td style="width:100px;background-color:#FFFFFF;vertical-align:middle;border:none;"></td>
		'; 

      $libres=true;
    }
 // recuperem info
    ?>
    <tr>
    <td width="50px" align="right" class="info hora" style="font-size:9px;vertical-align:middle;">
      <?php echo  ''.substr($hora,0,strlen($hora)-3)  ?>&#160;&#160; 
    </td>
    <td width="10px;vertical-align:middle;">
        <?php if (!$tipo_reg) $tipo_reg = $_REQUEST['tipus']; ?>
    </td>    
    <td width="38px;vertical-align:middle;" > <?php echo $cad; ?></td>
	<?php echo $info; 
       if(trim($info)==''){
       ?> 
       <?php 
       if($mati) $mati=TEMPS.'@'.$hora_bona.'#'.$mati;
       if($tarda) $tarda=TEMPS.'@'.$hora_bona.'#'.$tarda;
       } ?>
    </tr>
	<tr><td colspan="10" style="border:none;"></td></tr>
    <?php
    // BUGGY mod 3 places
	//mts 20012013 (en el cas dels buggys, com que el número de persones anirà variant, utilitzarem un contador diferent per a les marques de separació.
	if($_REQUEST['tipus'] == '_buggy_')
	{
    if(!(($j+1)%$persones))
	echo '
	<tr><td colspan="10" style="height:0px !important;background:#444;padding:0 0 1px 0;margin: 0 0 10px 0;"></td></tr>
    <tr><td colspan="10" style="border:none;"></td></tr>';
	}
	//fi mts.
	else
    if(!(($i+1)%$persones))
	{
	echo '
	<tr><td colspan="10" style="height:0px !important;background:#444;padding:0 0 1px 0;margin: 0 0 10px 0;"></td></tr>
	<tr><td colspan="10" style="border:none;"></td></tr>';
	}
    echo $sep; 
    $i++;
	$j++;
  }
  ?>
</table>
<?php



 
 //var_dump($matif);
$styles= '<style>
 .mostra{
    display:none;
    width:0px;
}
.cuadro{width:35px;} 

*{
 font-size:12px !important;
}

table{border:1px solid #000000;} 
.texto_cabecera
{
	background: none repeat scroll 0 0 transparent;
    border: none;
    color: #006699;
    font-size: 11px;
    font-weight: normal;
    padding: 2px;
}
';
 echo($styles);

 
echo(' 
</style>');
 }

if($libres==true)echo 'SL';
else echo 'NL';  


function header_pdf()
{
echo('
<tr>
  <td align="right" style="width:50px;" class="info hora"></td>
  <td style="width:10px;"></td>
  <td style="width:28px;"> 		</td>
  <td class="info pilots" style="width:600px !important;padding:0;" colspan="7">
	   <table style="border-spacing:0;border: 1px solid #000000;" >
	   <tr>
	   <td style="width:10px;">
	   </td>
	   <td style="width:80px;font-weight:bold;" class="texto_cabecera"> Piloto</td>
	   <td style="width:60px;font-weight:bold;" class="texto_cabecera" >Telefono</td>
	   <td style="width:95px;font-weight:bold;" class="texto_cabecera">Persona regala</td>
	   <td style="width:95px;font-weight:bold;" class="texto_cabecera ocult" >Telefono regala</td>
	   <td style="width:100px;font-weight:bold;" class="texto_cabecera ocult">Observaciones</td>
	   <td style="width:75px;font-weight:bold;" class="texto_cabecera ocult"></td>
	 </tr>
	   </table></td>
</tr>');

}
?>



