

<?php
require_once (dirname(__FILE__) . '/../../../html2pdf/html2pdf.class.php'); 

include('config_events.php');
//require_once(dirname(__FILE__).'/../../../fpdf/fpdf.php');
//require_once(dirname(__FILE__).'/../../../fpdf/fpdi.php');


//$ciudades = array('','madrid','valencia','cantabria','andalucia');
//$eventos = array('ferrari','lamborghini','porsche','corvette');

$content2='';

$html2pdf = new HTML2PDF('P', 'A4', 'fr');    
$html2pdf->setTestTdInOnePage(true);
$html2pdf->pdf->SetDisplayMode('real'); //fullpage, fullwidth, real, default: uses viewer default mode
  //$html2pdf -> writeHTML($cad, true);   
	  
$archivos = array();
$content='';

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
</style>';

ob_start();
echo('<link rel="stylesheet" type="text/css" href="../css/style.css">');
echo($styles);

$ciudad = $_REQUEST['ciudad'];
$evento = $_REQUEST['tipus'];
listado_organizadores($ciudad,$evento);

$content= ob_get_contents();
		//var_dump($content);die;
ob_end_clean();
		//$content=convert_caracters_hex($content);
		//$content='<page backbottom="0px" pageset="old">'.$content.'</page>';
		//$html2pdf -> writeHTML($content, false);
		//$codigo = uniqid();
	    //$archivo = '../listados_eventos/listado' . $codigo . '.pdf';
	    //$archivos[]=$archivo;
	    //$html2pdf -> Output($archivo, 'F');			

 //var_dump($matif);

 //echo($styles);

 


//$cad='<page backbottom="0px" pageset="old">'.$content.$styles.'</page>';
//$cad='<page backbottom="0px">'.$cad.'</page>';

 
 //$cad  = file_get_contents('graella_organizadores.html');
  
  //$html2pdf = new HTML2PDF('P', 'A4', 'fr',true,'UTF-8',array(5,5,0,8));    
  
  //$html2pdf->Output('EPSON SX2010 Series', 'D');
  /*unlink($archivo);	 
  
  header("Content-type: application/pdf");    
  header("Content-Disposition: attachment; filename=listado.pdf");
  header("Pragma: no-cache");
  header("Expires: 0");
*/
  //echo($content);

  die($content);

function listado_organizadores($pciudad,$ptipo)
{
 $tipo='';
  
 /*	switch($ptipo)  
  {
    case '_bferrari_':
		$tipoev = 'ferrari';
	break;
	case '_blamborghini_':
		$tipoev = 'lamborghini';
	break;
	case '_bporsche_':
		$tipoev = '_porsche_';
	break;
	default:
		$tipoev=$ptipo;
	break;  
 }  
*/
  $tipoev=$ptipo; 
  $tipo_bautizo='';
  switch($tipoev)  
  {
    case 'ferrari':
		$tipo_bautizo = '_bferrari_';
	break;
	case 'lamborghini':
		$tipo_bautizo = '_blamborghini_';
	break;
	case '_porsche_':
		$tipo_bautizo = '_bporsche_';
	break;
	default:
	break;
 }
 
//TIPO
	// BUGGY
	if($tipoev == '_buggy_')
	  include 'dies_graella4.php';
	  //include 'dies_graella3.php';
	  //include 'dies_graella.php';
	//else if($tipoev=='_bferrari_' || $tipoev=='_blamborghini_'  || $tipoev=='_bporsche_' )
	else if($tipoev=='_bferrari_' || $tipoev=='_blamborghini_'  || $tipoev=='_bporsche_' )
	  include 'dies_graella4.php';
	else
	{  
	  /* !!!! 17072014, se muestra el calendario mayor, ya que los bautizos
	   * pueden aparecer por la tarde o por la mañana indistintamente.
	   include 'dies_graella.php';
	   */
		include 'dies_graella4.php';
	}
	  

	  $array_hores_tmp = $array_hores;  
	  $array_hores = array();	  
	  
//TIPO BAUTIZO
	// BUGGY
	if($tipo_bautizo == '_buggy_')
	  include 'dies_graella4.php';
	  //include 'dies_graella3.php';
	  //include 'dies_graella.php';
	//else if($tipo_bautizo=='_bferrari_' || $tipo_bautizo=='_blamborghini_')
	else if($tipo_bautizo=='_bferrari_' || $tipo_bautizo=='_blamborghini_' || $tipo_bautizo=='_bporsche_')
	  include 'dies_graella4.php';
	else  
	  //17072014 include 'dies_graella.php';
	  include 'dies_graella4.php';

	$array_horesf=$array_hores;  
	/*
	 * $array_horesb = $array_hores; //$array_horesb: calendario bautizos.
	$array_hores = $array_hores_tmp; //$array_hores: calendario ruta 20km
	  
	  
    if ($tipo_bautizo!='') //Caso de listado que incluye las rutas de bautizo y la de 20km (arreglaremos los arrayas para que 20km: mañanas+tardes, 7km:tardes).
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
		
	//array donde se mezclan las 2 rutas: mañana (20km), tarde(20km+7km)
	$array_horesf=array();
	foreach ($array_hores as $clave=>$valor) $array_horesf[$clave]=$valor;
	foreach ($array_horesb as $clave=>$valor) $array_horesf[$clave]=$valor;
	
	}	  
	*/  
include_once 'functions.php';

if (!defined('TEMPS'))
{
	define('TEMPS',$_REQUEST['data']); // Dia que li arriba
}
$libres=false;
//ob_start();
graella($array_horesf,$tipoev,$tipo_bautizo,$pciudad);
//$content = ob_get_contents();
//return $content;
} //fin función listado organizadores.
/*
 $hores array(hora,info) 
 $lliure array(hora)  
 */
function graella($hores,$tipoev,$tipo_bautizo,$pciudad) 
{
  global $link,$persones,$libres;

// echo('<nobreak>'); 
echo('<page_header>');
//echo('<table><tr><td>');
echo('<div style="padding-left:100px;"><span class="cabecera">Dia actual:</span> <span style="color:#f04;font-weight:bold;">'.implode('/',array_reverse(explode('-',TEMPS))).'</span><span class="cabecera" style="margin-left:300px;">'.strtoupper(($pciudad=='')?'Barcelona':$pciudad).'</span><span style="margin-left:60px;">pág. [[page_cu]]/[[page_nb]]</span></div>');
 //echo('</nobreak>'); 
?>
<?php 
?>
<table style="border:none;">
<?php

//echo('<tr><td></td><td></td><td style="width:100px;text-align:center;"><legend style="font-weight:bold;padding:5px;font-size:14px;background-color:#ddd;color:#000;text-align:center;">'.str_replace(' 20 Km','',return_tipus_e($tipoev)).'</legend></td><td></td></tr>');
echo('  <tr style="margin-bottom:10px;">
  <td align="right" style="width:50px;" class="info hora"></td>
  <td style="width:10px;padding-bottom:10px;"></td>
  <td style="width:33px;"> 		</td>
  <td class="info pilots" style="width:500px !important;padding:0;text-align:left;">
	<legend style="font-weight:bold;padding:5px;font-size:14px;background-color:#ddd;color:#000;text-align:center;margin-left:230px;margin-bottom:4px;">'.str_replace(' 20 Km','',return_tipus_e($tipoev)).'</legend>  
  </td></tr>
');
header_pdf();
?>

</table> 
<?php 
//echo('</td></tr></table>');
echo('</page_header>');

?>
<table  width="678px" class="ma" id="ma" cellspacing="0" cellpadding="0" style="padding-top:10px;padding-right:5px;border-spacing:0 14px;">  
<?php 
//header_pdf();
?>
<tr>
 <td style="width:50px;color:#000;font-size:13px;" align="left" class="info hora">Ma&ntilde;ana<br><br /></td>
 <td style="width:10px;"></td>
 <td style="width:38px;" > </td>
  <td colspan="7"> </td>
</tr>
<?php    





$i=0;
$j=0; //mts 24012013.
$info=' ';
$tipus=$tipoev;
$tarda='';
$mati='#';


 $persones=1;

 if( $tipoev=='ferrari_porsche901' || $tipoev=='lamborghini_lotus' 
 || $tipoev=='ferrari' || $tipoev=='lamborghini' || $tipoev=='_corvette_'    
 || $tipoev=='_bferrari_' || $tipoev=='_blamborghini_'  || $tipoev=='_bporsche_'  || $tipoev=='_bcorvette_') 
 {
	$persones=2;
 } 
 else if  ($tipoev=='_buggy_') 
 {
	$persones=2; 
 }



foreach($hores as $hora=>$info) {
$_h=$info;

$info='';

$tipus=$tipoev;  

$hora=str_replace('@','',$hora);


if($hora=='c'){
	 
	echo('</table>'); 
 ?>
	<!-- <nobreak> -->
	<table cellspacing="0" cellpadding="0" width="678px" style="padding-top:10px;padding-right:5px;border-spacing:0 14px;"  class="ta" id="tarde">
	<?php //header_pdf(); ?>
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
if(($tipoev=='_porsche_' || $tipoev=='_lotus_') && $i%2 )
{
    $i++;
    continue ; 
}

// cas graella buggy (2,3 fins a 4 persones per separació)
if($tipoev=='_buggy_')
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
if($tipoev=='_bferrari_' || $tipoev=='_blamborghini_')
  $transform = 2;
//mts 24012013
else if($tipoev == '_buggy_') {$transform=3;} 
//fi mts.  
else $transform = 1;

$hora = label_hora($hora, $persones, $transform);
*/




	if ($tarda=='#')
		$hora = label_hora($hora, $persones, 2);
	else
		//$hora = label_hora($hora, $persones, 1);
		$hora = label_hora($hora, $persones, 2);

		
    $perms=permisos($tipus,TEMPS,$hora_bona);
	 
	
    if(!$perms) {
       $cad='<div  id="disponibilidad"    class="no_disponible cuadro">&nbsp;&nbsp;&nbsp;&nbsp;</div>';
    }
    // CAS RESERVA SOCI INACTIVA PERO DINS DEL PLAÇ
    if(substr($perms,0,2)=='@@') {
      $cad='<div  id="disponibilidad"    class="no_disponible cuadro"></div>';
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
/*
  if( $tipus=='ferrari' ){
    $t_aux='(i.tipus_event="ferrari" OR i.tipus_event="ferrari_porsche901") ';
  } elseif($tipus=='lamborghini' ){
    $t_aux='(i.tipus_event="lamborghini_lotus" OR i.tipus_event="lamborghini") ';
  }
  */
  
  
  if( $tipus=='ferrari' )
  {
	/*
	 if ($mati=='#') //Por el momento, por la mañana no aparecerán bautizos, luego seguiremos el horario de la ruta de 20km.
					//si más adelante se cambia, el horario de mañana será cada 15 minutos, como el de tarde y también
					//se mezclarán las rutas.
		$t_aux='(i.tipus_event="ferrari" OR i.tipus_event="ferrari_porsche901") ';
	else*/
		$t_aux='(i.tipus_event="ferrari" OR i.tipus_event="ferrari_porsche901" OR i.tipus_event="_bferrari_") ';
  } 
  elseif($tipus=='lamborghini' )
  {
	/*if ($mati=='#')
		$t_aux='(i.tipus_event="lamborghini_lotus" OR i.tipus_event="lamborghini") ';
	else*/
		$t_aux='(i.tipus_event="lamborghini_lotus" OR i.tipus_event="lamborghini" OR i.tipus_event="_blamborghini_") ';

  }
  elseif($tipus=='_porsche_' )
  {
	/*if ($mati=='#')
		$t_aux='(i.tipus_event="_porsche_") ';
	else*/
		$t_aux='(i.tipus_event="_porsche_" OR i.tipus_event="_bporsche_") ';
  }

  elseif($tipus=='_corvette_' )
  {
	/*if ($mati=='#')
		$t_aux='(i.tipus_event="_porsche_") ';
	else*/
		$t_aux='(i.tipus_event="_corvette_" OR i.tipus_event="_bcorvette_") ';
  }
  
// fi graelles dobles
    $tipo_reg = '';

    //$sql='SELECT i.* FROM `events'.pciudad.'` as i WHERE i.id_event="'.TEMPS.'@'.$hora_bona.'" AND '.$t_aux.'';
    $sql='SELECT i.*,b.marca as marca_bautizo FROM `events'.$pciudad.'` as i LEFT JOIN bautizos'.$pciudad.' b ON i.id_event = b.id_event and i.tipus_event = b.tipus_event WHERE i.id_event="'.TEMPS.'@'.$hora_bona.'" AND '.$t_aux.'';
    $sql.=' AND trim(i.email_confirm)= (SELECT max(trim(i2.email_confirm)) FROM events'.$pciudad.' as i2 WHERE i2.id_event="'.TEMPS.'@'.$hora_bona.'" AND '.str_replace('i.','i2.',$t_aux).') order by tipus_event  ';
	
	$result=mysql_query($sql);
	
	$texto_bautizo='';
    if($numr=mysql_num_rows($result)) { // plaza ocupada 


	 /* Añadimos una pequeña marca azul para indicar que es un registro de bautizo, tenga o una reserva */
	 /*
	 if(trim(substr($r['tipus_event'],0,2))=='_b' && strtoupper(trim($r['tipus_event']!='_BUGGY_')))
		 $cad2='<div class="marca_bautizo" style="float:left;border: 0px solid #000; height:14px;padding: 1px;width:4px;"></div>';
	 else
		 //indicador de celda bautizo vacío
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
		//si sólo hay un registro de bautizo (no disponible) pero no tiene mail de confirmación, entonces entenderemos
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
        <?php if (!$tipo_reg) $tipo_reg = $tipoev; ?>
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
	//mts 20012013 (en el cas dels buggys, com que el número de persones anirà variant, utilitzarem un contador diferent per a les marques de separació.
	if($tipoev == '_buggy_')
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
<!-- </nobreak> -->
<?php
}


 
 

if($libres==true)echo 'SL';
else echo 'NL';  



function header_pdf()
{
echo('
<tr>
  <td align="right" style="width:50px;" class="info hora"></td>
  <td style="width:10px;"></td>
  <td style="width:33px;"> 		</td>
  <td class="info pilots" style="width:600px !important;padding:0;">
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
	   </table>
  </td>
</tr>');

}

?>



