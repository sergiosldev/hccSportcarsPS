<link rel="stylesheet" type="text/css" href="../css/style.css">

<?php
 
if(!isset($_REQUEST['ciudad']))$_REQUEST['ciudad']='';
//$_REQUEST['ciudad']='';

include('config_events.php');
//TIPO
	// BUGGY
	if($_REQUEST['tipus'] == '_buggy_')
	  include 'dies_graella4.php';
	  //include 'dies_graella3.php';
	  //include 'dies_graella.php';
	//else if($_REQUEST['tipus']=='_bferrari_' || $_REQUEST['tipus']=='_blamborghini_'  || $_REQUEST['tipus']=='_bporsche_' )
	else if($_REQUEST['tipus']=='_bferrari_' || $_REQUEST['tipus']=='_blamborghini_'  || $_REQUEST['tipus']=='_bporsche_' )
	  include 'dies_graella4.php';
	else  
	  include 'dies_graella.php';

	  $array_hores_tmp = $array_hores;  
	  $array_hores = array();	  
	  
//TIPO BAUTIZO
	// BUGGY
	if($_REQUEST['tipus_b'] == '_buggy_')
	  include 'dies_graella4.php';
	  //include 'dies_graella3.php';
	  //include 'dies_graella.php';
	//else if($_REQUEST['tipus_b']=='_bferrari_' || $_REQUEST['tipus_b']=='_blamborghini_')
	else if($_REQUEST['tipus_b']=='_bferrari_' || $_REQUEST['tipus_b']=='_blamborghini_' || $_REQUEST['tipus_b']=='_bporsche_')
	  include 'dies_graella4.php';
	else  
	  include 'dies_graella.php';

	  
	$array_horesb = $array_hores; //$array_horesb: calendario bautizos.
	$array_hores = $array_hores_tmp; //$array_hores: calendario ruta 20km
	  
	  
    if ($_REQUEST['tipus_b']!='') //Caso de listado que incluye las rutas de bautizo y la de 20km (arreglaremos los arrayas para que 20km: ma�anas+tardes, 7km:tardes).
	{
	    //modificamos array horas ruta 20km.
		$array_hores_tmp=array();
		$array_hores_tmp=$array_hores;
		$array_hores=array();
		foreach($array_hores_tmp as $hora=>$info)
		{
			if ($hora=='c') break;
			$array_hores[$hora]=$info;
		}
		
		
		//modificamos array horas ruta 7km.
	    $array_hores_tmp=array();
		$array_hores_tmp=$array_horesb;
		$array_horesb=array();
		$copia=false;
		foreach($array_hores_tmp as $hora=>$info)
		{	
			if($copia) 
				$array_horesb[$hora]=$info;
			if($hora=='c')  {$array_horesb[$hora]=$info;$copia=true;}
		}
		
	//array donde se mezclan las 2 rutas: ma�ana (20km), tarde(20km+7km)
	$array_horesf=array();
	foreach ($array_hores as $clave=>$valor) $array_horesf[$clave]=$valor;
	foreach ($array_horesb as $clave=>$valor) $array_horesf[$clave]=$valor;
	}	  
	  
include_once 'functions.php';

define('TEMPS',$_REQUEST['data']); // Dia que li arriba
$libres=false;
ob_start();
graella($array_horesf);
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
echo('<tr><td style="width:600px;text-align:center;"><legend style="font-weight:bold;padding:5px;font-size:14px;background-color:#ddd;color:#000;text-align:center;">'.str_replace(' 20 Km','',return_tipus_e($_REQUEST['tipus'])).'</legend></td></tr>');
?>
</table> 
<?php 
?>
<table  width="678px" class="ma" id="ma" cellspacing="0" cellpadding="0" style="padding-top:10px;padding-right:5px;border-spacing:0 14px;">
<?php 
header_pdf();
?>
<tr>
 <td style="width:50px;color:#000;font-size:13px;" align="left" class="info hora">Ma�ana<br><br /></td>
 <td style="width:10px;"></td>
 <td style="width:38px;" > </td>
  <td colspan="7"> </td>
</tr>
<?php    





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
	 
	echo('</table>'); 
 ?>
	<table cellspacing="0" cellpadding="0" width="678px" style="padding-top:10px;padding-right:5px;border-spacing:0 14px;"  class="ta" id="tarde">
	<?php header_pdf(); ?>
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
if(($_REQUEST['tipus']=='_porsche_' || $_REQUEST['tipus']=='_lotus_') && $i%2 )
{
    $i++;
    continue ; 
}

// cas graella buggy (2,3 fins a 4 persones per separaci�)
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

/*
if($_REQUEST['tipus']=='_bferrari_' || $_REQUEST['tipus']=='_blamborghini_')
  $transform = 2;
//mts 24012013
else if($_REQUEST['tipus'] == '_buggy_') {$transform=3;} 
//fi mts.  
else $transform = 1;

$hora = label_hora($hora, $persones, $transform);
*/

	if ($tarda=='#')
		$hora = label_hora($hora, $persones, 2);
	else
		$hora = label_hora($hora, $persones, 1);

		
    $perms=permisos($tipus,TEMPS,$hora_bona);
	 
	
    if(!$perms) {
       $cad='<div  id="disponibilidad"    class="no_disponible cuadro">&nbsp;&nbsp;&nbsp;&nbsp;</div>';
    }
    // CAS RESERVA SOCI INACTIVA PERO DINS DEL PLA�
    if(substr($perms,0,2)=='@@') {
      $cad='<div  id="disponibilidad"    class="no_disponible cuadro"></div>';
    }
    /** mts 28042012, desactivamos bot�n disponibilidad */
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
/*
  if( $tipus=='ferrari' ){
    $t_aux='(i.tipus_event="ferrari" OR i.tipus_event="ferrari_porsche901") ';
  } elseif($tipus=='lamborghini' ){
    $t_aux='(i.tipus_event="lamborghini_lotus" OR i.tipus_event="lamborghini") ';
  }
  */
  
  
  if( $tipus=='ferrari' )
  {
	if ($mati=='#') //Por el momento, por la ma�ana no aparecer�n bautizos, luego seguiremos el horario de la ruta de 20km.
					//si m�s adelante se cambia, el horario de ma�ana ser� cada 15 minutos, como el de tarde y tambi�n
					//se mezclar�n las rutas.
		$t_aux='(i.tipus_event="ferrari" OR i.tipus_event="ferrari_porsche901") ';
	else
		$t_aux='(i.tipus_event="ferrari" OR i.tipus_event="ferrari_porsche901" OR i.tipus_event="_bferrari_") ';
  } 
  elseif($tipus=='lamborghini' )
  {
	if ($mati=='#')
		$t_aux='(i.tipus_event="lamborghini_lotus" OR i.tipus_event="lamborghini") ';
	else
		$t_aux='(i.tipus_event="lamborghini_lotus" OR i.tipus_event="lamborghini" OR i.tipus_event="_blamborghini_") ';

  }
  elseif($tipus=='_porsche_' )
  {
	if ($mati=='#')
		$t_aux='(i.tipus_event="_porsche_") ';
	else
		$t_aux='(i.tipus_event="_porsche_" OR i.tipus_event="_bporsche_") ';
  }
  
// fi graelles dobles
    $tipo_reg = '';

    //$sql='SELECT i.* FROM `events'.$_REQUEST['ciudad'].'` as i WHERE i.id_event="'.TEMPS.'@'.$hora_bona.'" AND '.$t_aux.'';
    $sql='SELECT i.*,b.marca as marca_bautizo FROM `events'.$_REQUEST['ciudad'].'` as i LEFT JOIN bautizos'.$_REQUEST['ciudad'].' b ON i.id_event = b.id_event and i.tipus_event = b.tipus_event WHERE i.id_event="'.TEMPS.'@'.$hora_bona.'" AND '.$t_aux.'';
    $sql.=' AND trim(i.email_confirm)= (SELECT max(trim(i2.email_confirm)) FROM events'.$_REQUEST['ciudad'].' as i2 WHERE i2.id_event="'.TEMPS.'@'.$hora_bona.'" AND '.str_replace('i.','i2.',$t_aux).') order by tipus_event  ';
	
	$result=mysql_query($sql);
	
	$texto_bautizo='';
    if($numr=mysql_num_rows($result)) { // plaza ocupada 


	 /* A�adimos una peque�a marca azul para indicar que es un registro de bautizo, tenga o una reserva */
	 /*
	 if(trim(substr($r['tipus_event'],0,2))=='_b' && strtoupper(trim($r['tipus_event']!='_BUGGY_')))
		 $cad2='<div class="marca_bautizo" style="float:left;border: 0px solid #000; height:14px;padding: 1px;width:4px;"></div>';
	 else
		 //indicador de celda bautizo vac�o
		 $cad2='<div  style="background-color:#FFFFFF;float:left;border: none; height:14px;padding: 1px;width:4px;"></div>';
	*/
	  $cad='<div  id="disponibilidad" class="no_disponible cuadro">&nbsp;&nbsp;&nbsp;&nbsp;'.$temps.'</div>';
      $r=mysql_fetch_assoc($result);
      //if($r['plazas']=='1')$cad='<div  id="disponibilidad"  class="no_disponible_carbassa cuadro"    >&nbsp;&nbsp;&nbsp;&nbsp;</div>';

	 if(strtoupper(trim(substr($r['tipus_event'],0,2)))=='_B' && strtoupper(trim($r['tipus_event']))!='_BUGGY_')
	 {
		 $texto_bautizo='BAU'; 
	 }
	 else {$texto_bautizo='';}
	  
	  
	  if(trim($r['email']).trim($r['email_confirm']).trim($r['email_persona_regala'])!='')
	   {
			if ($texto_bautizo=='BAU')
				$cad='<div  id="disponibilidad"  class="no_disponible_carbassa cuadro"    >'.$texto_bautizo.'</div>';
			else	
				$cad='<div  id="disponibilidad"  class="no_disponible_carbassa cuadro"    >&nbsp;&nbsp;&nbsp;&nbsp;</div>';
	   }
 
	  if(trim(substr($r['tipus_event'],0,2))=='_b' && strtoupper(trim($r['tipus_event']!='_BUGGY_')))
	  {
		if (trim($r['email_confirm'])!='')
			$cad='<div   id="disponibilidad"  class="marca_bautizo cuadro" style="height:15px;" >BAU</div>';
		//si s�lo hay un registro de bautizo (no disponible) pero no tiene mail de confirmaci�n, entonces entenderemos
		//que el que evento corresponde a la ruta de 20km.  Por lo tanto lo pondremos como disponible.
		/*elseif ($numr==1)	
			$cad='<div   id="disponibilidad"  class="disponible cuadro" style="height:15px;" ></div>';*/
	  }	
	  elseif($r['marca_bautizo']=='1') $cad='<divid="disponibilidad"  class="marca_bautizo cuadro" style="height:15px;" >'.$texto_bautizo.'</div>';


      $tipo_reg = $r['tipus_event'];
 	  $border_style='margin-top:50px !important;margin-bottom:50px !important;';	
     
	  if (strlen(trim($r['codi_consum'])) > 18) $codi_consum=substr($r['codi_consum'],0,18).'<br>'.substr($r['codi_consum'],18);
	  else $codi_consum =  $r['codi_consum'];
	  $info='

         <td style="width:10px;background-color:#FFFFFF;vertical-align:middle;border-top:1px solid #000000;border-bottom:1px solid #000000;border-left:1px solid #000000;'.$border_style.'">
		 '.''.'
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
      <?php echo  ''.substr($hora,0,strlen($hora)-3)?>&#160;&#160; 
    </td>
    <td width="10px;vertical-align:middle;">
        <?php if (!$tipo_reg) $tipo_reg = $_REQUEST['tipus']; ?>
    </td>    
    <td width="38px;vertical-align:middle;" > 
	<table style="border:none;">
		<tr>
			<td>
				<?php echo $cad; ?>
			</td>	
		</tr>
	</table>
	</td>
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
	//mts 20012013 (en el cas dels buggys, com que el n�mero de persones anir� variant, utilitzarem un contador diferent per a les marques de separaci�.
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



