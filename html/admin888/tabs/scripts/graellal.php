<?php

if(!isset($_REQUEST['ciudad']))$_REQUEST['ciudad']='';
//$_REQUEST['ciudad']='';

include('config_events.php');
include_once 'functions.php';

$array_hores=seleccionar_plantilla_graella($_REQUEST['tipus']);	
/*

// BUGGY
if($_REQUEST['tipus'] == '_buggy_')
  include 'dies_graella4.php';
  //include 'dies_graella3.php';
  //include 'd ies_graella.php';
else if($_REQUEST['tipus']=='_bferrari_' || $_REQUEST['tipus']=='_blamborghini_' || $_REQUEST['tipus']=='_bporsche_' || $_REQUEST['tipus']=='_bcorvette_')                                       
  include 'dies_graella4.php';
else 
  include 'dies_graella.php';
*/

define('TEMPS',$_REQUEST['data']); // Dia que li arriba
$libres=false;

graella($array_hores);

/*
 $hores array(hora,info) 
 $lliure array(hora)  
 */
function graella($hores) {
  global $link,$persones,$libres;
  $inicializar_no_disponibles=false;
?>

<table width="100%" border="0" class="ma">
<?php
echo '<br><span style="font-weight:bold;padding:5px;font-size:14px;background-color:#ddd;color:#000">'.return_tipus_e($_REQUEST['tipus']).'</span>';
header_2();
?>
<tr>
 <td width="50px" align="left" class="info hora" style="color:#000;font-size:13px">Mañana<br><br /></td>
 <td width="10px"></td>
 <td width="30px" > </td>
  <td width="600px"  > </td>
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
  <table width="100%" border="0" class="ta">
    <tr>
      <td width="50px" align="left" class="info hora" style="color:#000;font-size:13px"><br>Tarde<br><br /></td>
      <td width="10px"></td>
      <td width="30px"> </td>
      <td width="600px"> </td>
    </tr>
<?php
  $tarda='#';
  $matif=$mati;
  $mati='';
  continue ; 
}

// cas graella 1 sol cotxe
if(($_REQUEST['tipus']=='_porsche_' || $_REQUEST['tipus']=='_corvette_' ||  $_REQUEST['tipus']=='_lotus_' || $_REQUEST['tipus']=='_bporsche_' || $_REQUEST['tipus']=='_bcorvette_' || strrpos($_REQUEST['tipus'],'ruta_turistica')!==false) && $i%2 ){
    
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


if($_REQUEST['tipus']=='_bferrari_' || $_REQUEST['tipus']=='_blamborghini_' || $_REQUEST['tipus']=='_bporsche_' || $_REQUEST['tipus']=='_bcorvette_')
  $transform = 2;
//mts 24012013
else if($_REQUEST['tipus'] == '_buggy_') {$transform=3;} 
//fi mts.  
else $transform = 1;
//echo('transform: '.$transform.' persones: '.$persones);
$hora = label_hora($hora, $persones, $transform);

    $perms=permisos($tipus,TEMPS,$hora_bona);

    if(!$perms) 
	{
       $cad='<button  id="disponibilidad"    class="no_disponible">·</button>';
    }
/*	else if (intval(substr($hora,0,2))<8 || (intval(substr($hora,0,2))==20 && intval(substr($hora,3,2))>15 ) || intval(substr($hora,0,2))>20 )
	{
       $cad='<button  id="disponibilidad"    class="no_disponible">·</button>';
    }*/
    // CAS RESERVA SOCI INACTIVA PERO DINS DEL PLAÇ
    if(substr($perms,0,2)=='@@') 
	{
      $cad='<button  id="disponibilidad"    class="no_disponible" onclick="esborra_reserva(\''.TEMPS.'@'.$hora_bona.'\',\''.$tipus.'\')"   >'.$perms.'</button>';
    }
    /** mts 28042012, desactivamos botón disponibilidad */
    else 
	{        
		//echo(marca_bautizo(TEMPS,$hora_bona,$tipus));
		if (marca_bautizo(TEMPS,$hora_bona,$tipus))
		{	//echo('marca bautizo');
            $cad='<button  id="disponibilidad"    class="marca_bautizo"  >·</button>';
        }
		/*else if (intval(substr($hora,0,2))<8 ||(intval(substr($hora,0,2))==20 && intval(substr($hora,3,2))>15 ) || intval(substr($hora,0,2))>20 )
		{
			$cad='<button  id="disponibilidad"    class="no_disponible">·</button>';
		}*/
		else
		{
			$cad='<button  id="disponibilidad"    class="disponible"  >·</button>';
			
		}

    /* fin mts */
    }

    
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
// fi graelles dobles
  $tipo_reg = '';
	
    
	//Al comprobar la primera hora del calendario, miraremos si ya existe alguna reserva para ese día y vehículo.   
	if  (substr($hora,0,5)=='07:00')
	{
			$sql_comprobacion='SELECT i.* FROM `events'.$_REQUEST['ciudad'].'` as i WHERE substring(i.id_event,1,10)="'.TEMPS.'" AND substring(i.id_event,12,2)!="07" AND '.$t_aux.'';  
//		die($sql_comprobacion);
		$result_comprobacion=mysql_query($sql_comprobacion);

		if(mysql_num_rows($result_comprobacion)) 
		{
			$inicializar_no_disponibles=false;
		}
		else
		{
			//si no hay ninguna reserva, es que todas las horas están libres, y por lo tanto inicializaremos la extensión de horas (de 7 a 8, de 20:30 a 22:00), como no disponibles.
			$inicializar_no_disponibles=true;
		}
	}
	
	//$inicializar_no_disponibles=true;
	//$sql='SELECT i.* FROM `events'.$_REQUEST['ciudad'].'` as i WHERE i.id_event="'.TEMPS.'@'.$hora_bona.'" AND '.$t_aux.'';
    if (strrpos($_REQUEST['ciudad'],'rutas_turisticas') === false)
    	$sql='SELECT i.*,b.marca as marca_bautizo FROM `events'.$_REQUEST['ciudad'].'` as i LEFT JOIN bautizos'.$_REQUEST['ciudad'].' b ON i.id_event = b.id_event and i.tipus_event = b.tipus_event WHERE i.id_event="'.TEMPS.'@'.$hora_bona.'" AND '.$t_aux.'';
	else
    	$sql='SELECT i.*,0 as marca_bautizo FROM `events'.$_REQUEST['ciudad'].'` as i WHERE i.id_event="'.TEMPS.'@'.$hora_bona.'" AND '.$t_aux.'';
	
	//die($sql);
	$result=mysql_query($sql);

    if(mysql_num_rows($result)) 
	{ // plaza ocupada
      $cad='<button  id="disponibilidad" class="no_disponible" >·</button>';
      $r=mysql_fetch_assoc($result);
      //if($r['plazas']=='1')$cad='<button  id="disponibilidad"  class="no_disponible_carbassa">·</button>';
      if(trim($r['email']).trim($r['email_confirm']).trim($r['email_persona_regala'])!='')$cad='<button  id="disponibilidad"  class="no_disponible_carbassa"   >·</button>';
      if($r['marca_bautizo']=='1') $cad='<button   id="disponibilidad"  class="marca_bautizo" style="height:21px;"></button>';
      $tipo_reg = $r['tipus_event'];

	  $info='
         <table width="100%">
         <tr>
         <td width="2%">
           <img src="'.URL_ROOT.'img/persona.png" width="8px" alt="" />
         </td>
         <td width="12%" class="borderg"> 
         '.$r['pilot'].' '.$r['apellidos_piloto'].'  </td>
        <!-- <td  width="21%" class="borderg ocult" > '.str_replace('@','<br>@',$r['email']).' </td>-->
         <td width="13%" class="borderg" style="color:#22f;font-weight:bold"> '.$r['telefon'].'</td>
          <td width="13%" class="borderg"> 
         '.$r['persona_regala'].' '.$r['apellidos_persona_regala'].'  </td>
        <!-- <td  width="15%" class="borderg ocult" > '.str_replace('@','<br>@',$r['email_persona_regala']).' </td>
        
         <td  width="15%" class="borderg ocult" > '.str_replace('@','<br>@',$r['email_confirm']).' </td>
        -->
        <td  width="13%" class="borderg " align="left" style="color:#f22;font-weight:bold" > '.$r['mobil_persona_regala'].' </td>
        <td  width="17%" class="borderg " align="left" > '.$r['Observaciones'].' </td>
        <td  width="110px" class="borderg " align="left" > Localizador:<br>
        <span class="codigos">'.$r['codi_localtzador'].'</span><br>
         Consumo:<br><span class="codigos">'.$r['codi_consum'].'</span></td>';
		 
        $info.= '<td align="right" valign="center" style="width:115px;" ><table><tr><td>'; 
		 if($r['marcat']=='1')
			$info.='<a class="_marcat" style=" background: none repeat scroll 0% 0% #0f0; border: 0px solid #000; padding: 1px 8px;" href="javascript:marca_event(\''.$r['id'].'\',\''.$r['tipus_event'].'\',0)">&nbsp;&nbsp;</a>';
		   //$info.='<a class="_marcat" style=" background: none repeat scroll 0% 0% #f00; border: 0px solid #000; padding: 1px;" href="javascript:marca_event(\''.$r['id'].'\',\''.$r['tipus_event'].'\',0)">&nbsp;&nbsp;</a>';
         else
			$info.='<a class="_marcat" style=" background: none repeat scroll 0% 0% #f00; border: 0px solid #000; padding: 1px 8px;" href="javascript:marca_event(\''.$r['id'].'\',\''.$r['tipus_event'].'\',1)">&nbsp;&nbsp;</a>';
           //$info.='<a class="_marcat" style=" background: none repeat scroll 0% 0% #0f0; border: 0px solid #000; padding: 1px;" href="javascript:marca_event(\''.$r['id'].'\',\''.$r['tipus_event'].'\',1)">&nbsp;&nbsp;</a>';

		   
        $info.=' <a id="activa" href="javascript:esborra(\''.$r['id'].'\',\''.TEMPS.'@'.$hora.'\')">
            <img src="'.URL_ROOT.'img/esborra.gif"  alt="" />
         </a> 
         <a id="activa" href="javascript:edita(\''.$r['id'].'\')">
             <img src="'.URL_ROOT.'img/edit.gif"  alt="" />
         </a>
         '; 


         $info.='
         <a id="activa" href="javascript:email(\''.$r['id'].'\',\''.TEMPS.'@'.$hora.'\')">
             <img src="'.URL_ROOT.'img/email.png" width="22px"  alt=""  />
         </a>';
		 if(trim($r['email']).trim($r['email_confirm']).trim($r['email_persona_regala'])!='')
		 {
		 $info.=  
		 '<a style="width:10px;" id="activa" href="javascript:form_reubicar(\''.$r['id'].'\',\''.$_REQUEST['ciudad'].'\',\''.$_REQUEST['tipus'].'\',\''.TEMPS.'@'.$hora_bona.'\')">  
              <img title="Reubicar evento" src="'.URL_ROOT.'img/reubicar.jpg" width="18px" alt="" />
		  </a>';
		 }
		 else
		{		 
		 $info.=  
		 '<a style="visibility:hidden;width:10px;" id="activa" href="javascript:form_reubicar(\''.$r['id'].'\',\''.$_REQUEST['ciudad'].'\',\''.$_REQUEST['tipus'].'\',\''.TEMPS.'@'.$hora_bona.'\')">  
              <img title="Reubicar evento" src="'.URL_ROOT.'img/reubicar.jpg" width="18px" alt="" />
		  </a>';
		 }
		  
         $info.='<div style="display:inline;width:10px;position:absolute;padding-top:3px;margin-left:2px">
           <input   type="checkbox"  value="'.$r['id'].'" name="sel[]"   />
         </div>
         
		 ';
 
		 $info.='
			   </td>
			  </tr>
			  <tr>
				<td style="width:150px;text-align:center;"><span style="font-weight:bold;color:#2222FF;">'.$r['origen'].'</span></td>
			  </tr>
			</table>
		   </td>
		  </tr>
         </table>';
    } 
	//se añade para la extensión de horas, hasta las 7 por la mañana, hasta las 22h de la noche, por la tarde.
	
	else if  ($inicializar_no_disponibles && (intval(substr($hora,0,2))<8 || (intval(substr($hora,0,2))==20 && intval(substr($hora,3,2))>15 ) || intval(substr($hora,0,2))>20 ))
	{	
	      $cad='<button  id="disponibilidad"    class="no_disponible">·</button>';

		
		//insertaremos el registro como no disponible, para que por defecto, los horarios anteriores a las 8 y posteriores a las 20:15 tengan un registro
		//en events, marcando que la hora no está disponible.  De lo contrario aparecerían como libres en el calendario de reservas de la web.
	    if($_REQUEST['tipus']=='_porsche_' || $_REQUEST['tipus']=='_lotus_'
		
           || $_REQUEST['tipus']=='_bferrari_' || $_REQUEST['tipus']=='_blamborghini_')
		   {		
			$sqln='INSERT INTO `events'.$_REQUEST['ciudad'].'` (id_event,ocupa,pilot,tipus_event,plazas) VALUES("'.TEMPS.'@'.$hora_bona.'","555","no disponible","'.$_REQUEST['tipus'].'",0)'; 
			$resultn=mysql_query($sqln,$link)  or die('error');	
			$idn = mysql_insert_id();
		   }
		   else
		   {
			$sqln='INSERT INTO `events'.$_REQUEST['ciudad'].'` (id_event,ocupa,pilot,tipus_event) VALUES("'.TEMPS.'@'.$hora_bona.'","555","no disponible","'.$_REQUEST['tipus'].'")';    
			$resultn=mysql_query($sqln,$link)  or die('error');	
			$idn = mysql_insert_id();
		   }

		  $info='
			 <table width="100%">
			 <tr>
			 <td width="2%">
			   <img src="'.URL_ROOT.'img/persona.png" width="8px" alt="" />
			 </td>
			 <td width="12%" class="borderg"> 
			 no disponible </td>
			 <td width="13%" class="borderg" style="color:#22f;font-weight:bold"> </td>
			 <td width="13%" class="borderg"> </td>
			 <td  width="13%" class="borderg " align="left" style="color:#f22;font-weight:bold" ></td>
		     <td  width="17%" class="borderg " align="left" ></td>
			 <td  width="110px" class="borderg " align="left" >Localizador:<br>
			 <span class="codigos"></span><br>
			 Consumo:<br><span class="codigos"></span></td>';
			 
			 
			 
			$info.= '<td align="right" valign="center" style="width:115px;" ><table><tr><td>'; 
			$info.='<a class="_marcat" style=" background: none repeat scroll 0% 0% #f00; border: 0px solid #000; padding: 1px 8px;" href="javascript:marca_event(\''.$idn.'\',\''.$r['tipus_event'].'\',1)">&nbsp;&nbsp;</a>';

			   
			$info.=' <a id="activa" href="javascript:esborra(\''.$idn.'\',\''.TEMPS.'@'.$hora.'\')">
				<img src="'.URL_ROOT.'img/esborra.gif"  alt="" />
			 </a> 
			 <a id="activa" href="javascript:edita(\''.$idn.'\')">
				 <img src="'.URL_ROOT.'img/edit.gif"  alt="" />
			 </a>
			 '; 


			 $info.='
			 <a id="activa" href="javascript:email(\''.$idn.'\',\''.TEMPS.'@'.$hora.'\')">
				 <img src="'.URL_ROOT.'img/email.png" width="22px"  alt=""  />
			 </a>';

			 '<a style="visibility:hidden;width:10px;" id="activa" href="javascript:form_reubicar(\''.$idn.'\',\''.$_REQUEST['ciudad'].'\',\''.$_REQUEST['tipus'].'\',\''.TEMPS.'@'.$hora_bona.'\')">  
				  <img title="Reubicar evento" src="'.URL_ROOT.'img/reubicar.jpg" width="18px" alt="" />
			  </a>';
			  
			 $info.='<div style="display:inline;width:10px;position:absolute;padding-top:3px;margin-left:2px">
			   <input   type="checkbox"  value="'.$idn.'" name="sel[]"   />
			 </div>
			 
			 ';
	 
			 $info.='
				   </td>
				  </tr>
				  <tr>
					<td style="width:150px;text-align:center;"><span style="font-weight:bold;color:#2222FF;"></span></td>
				  </tr>
				</table>
			   </td>
			  </tr>
			 </table>';		   

	}
	else 
	{
      $libres=true;
    }
 // recuperem info
    ?>
    <tr>
    <td width="50px" align="right" class="info hora">
      <?php echo  ''.substr($hora,0,strlen($hora)-3)  ?>&#160;&#160; 
    </td>
    <td width="10px">
        <?php if (!$tipo_reg) $tipo_reg = $_REQUEST['tipus']; ?>
        <a class="marca_bautizo" href="javascript:marca_event('<?php echo($_REQUEST['data'].'@'.$hora_bona);?>','<?php echo($tipo_reg);?>',3)">&nbsp;&nbsp;</a>
    </td>    
    <td width="28px" > <?php echo $cad; ?></td>
    <td class="info pilots"><?php echo $info; 
       if(trim($info)==''){
       ?> 
       <a href="javascript:ocupa('<?php echo TEMPS.'@'.$hora_bona; ?>')" class="ocupa" >&nbsp;&nbsp;</a>
       <?php 
       if($mati) $mati=TEMPS.'@'.$hora_bona.'#'.$mati;
       if($tarda) $tarda=TEMPS.'@'.$hora_bona.'#'.$tarda;
       } ?>
    </td>
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
 //var_dump($matif);
  file_put_contents('mati.js',''.$matif.'');     
  file_put_contents('tarda.js',''.$tarda.'');     
}

if($libres==true)echo 'SL';
else echo 'NL';  

?>
<style>
 .mostra{
    display:none;
    width:0px;
}
</style>
