<?php

if(!isset($_REQUEST['ciudad']))$_REQUEST['ciudad']='';
//$_REQUEST['ciudad']='';

include('config_events_new.php');  
// BUGGY
/*if($_REQUEST['tipus'] == '_buggy_')
  include 'dies_graella4.php';
  //include 'dies_graella3.php';
  //include 'dies_graella.php';
else if($_REQUEST['tipus']=='_bferrari_' || $_REQUEST['tipus']=='_blamborghini_' || $_REQUEST['tipus']=='_bporsche_' || $_REQUEST['tipus']=='_bcorvette_')  
//else if($_REQUEST['tipus']=='_bferrari_' || $_REQUEST['tipus']=='_blamborghini_')
  include 'dies_graella4.php';
else 
  include 'dies_graella.php';
*/
include_once 'functions.php';

$array_hores=seleccionar_plantilla_graella($_REQUEST['tipus']);	  

define('TEMPS',$_REQUEST['data']); // Dia que li arriba
$libres=false;

graella($array_hores);

/*
 $hores array(hora,info) 
 $lliure array(hora)  
 */
function graella($hores) {
  global $link,$persones,$libres;
?>
<table width="300px" border="0" class="ma" style="float:left;padding-right:45px;">
<?php
if (strpos($_REQUEST['ciudad'],'circuito')!==false)
{
	echo '<br><span style="font-weight:bold;padding:5px;font-size:14px;background-color:#ddd;color:#000">Fórmula ('.strtoupper(explode('circuito',$_REQUEST['ciudad'])[1]).')</span><br><br><br>';
}
else
{
	echo '<br><span style="font-weight:bold;padding:5px;font-size:14px;background-color:#ddd;color:#000">'.return_tipus_e($_REQUEST['tipus']).' ('.((trim($_REQUEST['ciudad'])=='')?'Barcelona':(strtoupper(substr($_REQUEST['ciudad'],0,1)).substr($_REQUEST['ciudad'],1))).')</span><br><br><br>';	
}
header_sel();
?>
<tr>
 <td width="70px" align="left" class="info hora" style="color:#000;font-size:13px"><br><?php echo(utf8_encode('Mañana'));?><br><br /></td>
 <td width="10px"></td>
 <td width="30px" > </td>
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
 ?>
  </table>
  <table width="300px" border="0" class="ta">
	<?php header_sel();  ?>
  
    <tr>
      <td width="70px" align="left" class="info hora" style="color:#000;font-size:13px"><br>Tarde&nbsp;&nbsp;<br><br/></td>
      <td width="10px"></td>
      <td width="30px"> </td>
    </tr>
<?php
  $tarda='#';
  $matif=$mati;
  $mati='';
  continue ; 
}

// cas graella 1 sol cotxe
/*
if(($_REQUEST['tipus']=='_porsche_' || $_REQUEST['tipus']=='_lotus_') && $i%2 ){
    $i++;
    continue ; 
}
*/
if(($_REQUEST['tipus']=='_porsche_' || $_REQUEST['tipus']=='porsche' || $_REQUEST['tipus']=='_corvette_' || $_REQUEST['tipus']=='corvette' ||  $_REQUEST['tipus']=='_lotus_' || $_REQUEST['tipus']=='_bporsche_' || $_REQUEST['tipus']=='_bcorvette_' || strrpos($_REQUEST['tipus'],'ruta_turistica')!==false) && $i%2 ){
//if(($_REQUEST['tipus']=='_porsche_' || $_REQUEST['tipus']=='_corvette_' ||  $_REQUEST['tipus']=='_lotus_' || $_REQUEST['tipus']=='_bporsche_' || $_REQUEST['tipus']=='_bcorvette_' ) && $i%2 ){
    
	if ( $_REQUEST['tipus']=='_bporsche_' ||$_REQUEST['tipus']=='_bcorvette_' )
	{
	if(!(($i+1)%$persones))echo '<tr><td colspan="3" style="height:1px;background:#444"></td></tr>';
    echo $sep; 
	}

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




//if($_REQUEST['tipus']=='_bferrari_' || $_REQUEST['tipus']=='_blamborghini_')
if($_REQUEST['tipus']=='_bferrari_' || $_REQUEST['tipus']=='_blamborghini_' || $_REQUEST['tipus']=='_bporsche_' || $_REQUEST['tipus']=='_bcorvette_' || $_REQUEST['tipus']=='formula')
  $transform = 2;
//mts 24012013
else if($_REQUEST['tipus'] == '_buggy_') {$transform=3;} 
//fi mts.  
else $transform = 1;

$hora = label_hora($hora, $persones, $transform);

    $perms=permisos($tipus,TEMPS,$hora_bona);

    if(!$perms) {
       $cad='<button  id="disponibilidad"    class="no_disponible btn_reubicar">&nbsp;</button>';
    }
    // CAS RESERVA SOCI INACTIVA PERO DINS DEL PLAÇ
    if(substr($perms,0,2)=='@@') {
      $cad='<button  id="disponibilidad"    class="no_disponible  btn_reubicar">&nbsp;</button>';
    }
    /** mts 28042012, desactivamos botón disponibilidad */
    else {        
		//echo(marca_bautizo(TEMPS,$hora_bona,$tipus));
		if (marca_bautizo(TEMPS,$hora_bona,$tipus))
		{	//echo('marca bautizo');
            //$cad='<button  id="disponibilidad"    class="marca_bautizo  btn_reubicar"  onclick="reubicar(id_(\'ciudad_origen\').value,id_(\'hora_origen\').value,\''.$_REQUEST['ciudad'].'\',\''.$_REQUEST['data'].'@'.$hora_bona.'\');">Reubicar</button>';  
			$cad='<button  id="disponibilidad"    class="marca_bautizo  btn_reubicar"  onclick="">Reubicar</button>';  
        }
		else $cad='<button  id="disponibilidad"    class="disponible btn_reubicar"  onclick="reubicar(id_(\'ciudad_origen\').value,id_(\'tipo_origen\').value,id_(\'hora_origen\').value,\''.$_REQUEST['ciudad'].'\',\''.$_REQUEST['tipus'].'\',\''.$_REQUEST['data'].'@'.$hora_bona.'\',\''.$_REQUEST['idev'].'\');">Reubicar</button>';    

    /* fin mts */
    }

   /**$t_aux='i.tipus_event="'.$tipus.'"'; **/
   
   
    if (strpos($tipus,'ferrari_ruta_turistica')!==false)
    	$t_aux='i.tipus_event like "%ferrari_ruta_turistica%"';
    else if (strpos($tipus,'lamborghini_ruta_turistica')!==false)
    	$t_aux='i.tipus_event like "%lamborghini_ruta_turistica%"';
    else	
    	$t_aux='i.tipus_event="'.$tipus.'"';

   // graellas dobles amb dos tipus d'events <<  si estreu aixo i es posen tipus queda com abans

  if( $tipus=='ferrari' )
  {
    $t_aux='(i.tipus_event="ferrari" OR i.tipus_event="ferrari_porsche901") ';
  } 
  elseif($tipus=='lamborghini' )
  {
    $t_aux='(i.tipus_event="lamborghini_lotus" OR i.tipus_event="lamborghini") ';
  }
  elseif($tipus=='_porsche_' )
  {
    $t_aux='(i.tipus_event="_porsche_" OR i.tipus_event="porsche") ';
  }
  elseif($tipus=='_corvette_' )
  {
    $t_aux='(i.tipus_event="_corvette_" OR i.tipus_event="corvette") ';
  }
  elseif($tipus=='porsche' )
  {
    $t_aux='(i.tipus_event="_porsche_" OR i.tipus_event="porsche") ';
  }
  elseif($tipus=='corvette' )
  {
    $t_aux='(i.tipus_event="_corvette_" OR i.tipus_event="corvette") ';
  }   
  else 
  {
	  $t_aux='(i.tipus_event="'.$tipus.'") ';
  }	  
   

   // graellas dobles amb dos tipus d'events <<  si estreu aixo i es posen tipus queda com abans

  if( $tipus=='ferrari' ){
    $t_aux='(i.tipus_event="ferrari" OR i.tipus_event="ferrari_porsche901") ';
  } elseif($tipus=='lamborghini' ){
    $t_aux='(i.tipus_event="lamborghini_lotus" OR i.tipus_event="lamborghini") ';
  }
// fi graelles dobles
    $tipo_reg = '';

    //$sql='SELECT i.* FROM `events'.$_REQUEST['ciudad'].'` as i WHERE i.id_event="'.TEMPS.'@'.$hora_bona.'" AND '.$t_aux.'';
	if (strpos($_REQUEST['ciudad'],'circuito')!==false)
	{
		$sql='SELECT i.*,0 as marca_bautizo FROM `events'.$_REQUEST['ciudad'].'` as i WHERE i.id_event="'.TEMPS.'@'.$hora_bona.'" AND '.$t_aux.'';                                                          
	}
	else
	{
		$sql='SELECT i.*,b.marca as marca_bautizo FROM `events'.$_REQUEST['ciudad'].'` as i LEFT JOIN bautizos'.$_REQUEST['ciudad'].' b ON i.id_event = b.id_event and i.tipus_event = b.tipus_event WHERE i.id_event="'.TEMPS.'@'.$hora_bona.'" AND '.$t_aux.'';	
	}
			
    
	
	$result=mysqli_query($link,$sql);

    if(mysqli_num_rows($result)) { // plaza ocupada
      $cad='<button  id="disponibilidad" class="no_disponible" style="width:65px;">&nbsp;</button>';  
      $r=mysqli_fetch_assoc($result);
      //if($r['plazas']=='1')$cad='<button  id="disponibilidad"  class="no_disponible_carbassa"   >·</button>';
      if(trim($r['email']).trim($r['email_confirm']).trim($r['email_persona_regala'])!='')$cad='<button  id="disponibilidad"  class="no_disponible_carbassa btn_reubicar" >&nbsp;</button>';
	  if($r['marca_bautizo']=='1') $cad='<button   id="disponibilidad"  class="marca_bautizo btn_reubicar" style="height:21px;" onclick="">&nbsp;</button>';
      $tipo_reg = $r['tipus_event'];

	  $info='
         <table width="300px">
         <tr>
         <td width="150px" class="borderg"> 
         '.$r['pilot'].'  </td>
          <td width="150px" class="borderg"> 
         '.$r['persona_regala'].'  </td>
         '; 

         $info.='
		 
		 </tr>
         </table>';
    } else {
      $libres=true;
    }
 // recuperem info
    ?>
    <tr>
    <td width="50px" align="right" class="info hora">
      <?php echo  ''.substr($hora,0,strlen($hora)-3)  ?>&#160;&#160; 
    </td>
    <td class="info pilots" width="100px"><?php echo $info; 
       if(trim($info)==''){
       ?> 
       <?php 
       if($mati) $mati=TEMPS.'@'.$hora_bona.'#'.$mati;
       if($tarda) $tarda=TEMPS.'@'.$hora_bona.'#'.$tarda;
       } ?>
    </td>
    <td width="25px"> <?php echo $cad; ?></td>
    </tr>
    <?php
    // BUGGY mod 3 places
	//mts 20012013 (en el cas dels buggys, com que el número de persones anirà variant, utilitzarem un contador diferent per a les marques de separació.
	if($_REQUEST['tipus'] == '_buggy_')
	{
    if(!(($j+1)%$persones))echo '<tr><td colspan="3" style="height:1px;background:#444"></td></tr>';
	}
	//fi mts.
	else
    if(!(($i+1)%$persones))echo '<tr><td colspan="3" style="height:1px;background:#444"></td></tr>';
    echo $sep; 
    $i++;
	$j++;
  }
  ?>
</table>
<?php
 
}

if($libres==true)echo 'SL';
else echo 'NL';  

?>
<style>
 .mostra{
    display:none;
    width:0px;
}
.btn_reubicar{
	width:65px;
}

.btn_volver_calendario{
	color:#4d4d91;
	border 1px solid;
	padding:7px;
	width:155px;
	float:right;
	margin-right:180px;
}

#dia{
	width:900px !important;
}
body{
	text-align:left !important;
	}
</style>
