<?php

function seleccionar_plantilla_graella($tipus)
{
	if($tipus == '_buggy_')
	  include 'dies_graella4.php';
	  //include 'dies_graella3.php';
	  //include 'd ies_graella.php';
	else if($tipus=='_bferrari_' || $tipus=='_blamborghini_' || $tipus=='_bporsche_' || $tipus=='_bcorvette_' || $tipus=='formula')                                       
	  include 'dies_graella4.php';
	else 
	  include 'dies_graella.php';		
	
	return $array_hores;
}


function permisos($tipus,$data,$hora) {
  global $link;
  $id_event_=$data.'@'.$hora;
  // CONTROLEM RESERVES DE SOCIS
  $dataact=date('Y-m-j');    //$dataact='2011-08-06';
  // Si la reserva esta feta en menys de 10 dies es vigent si encara no s'ha validat
  if($r=existeix_reserva_soci($id_event_,$tipus)){
    if($r['exit']!='1' AND quants_dias($dataact,$r['data'])<10)	
	  return '@@'.$r['socio'];
  }	

  $sql='';

  if($tipus=='ferrari') {
	 $sql='SELECT i.* FROM `events'.$_REQUEST['ciudad'].'` as i WHERE (i.id_event="'.$data.'@'.$hora.'"  ) AND 
	 (i.tipus_event="ferrari_porsche901" OR i.tipus_event="ferrari") ';
  } 
  
  else if($tipus=='ferrari_porsche901') {
	 $sql='SELECT i.* FROM `events'.$_REQUEST['ciudad'].'` as i WHERE (i.id_event="'.$data.'@'.$hora.'"  ) AND 
	 (i.tipus_event="ferrari_porsche901" OR i.tipus_event="ferrari")
	 ';
  } 
  
  else if($tipus=='lamborghini') {
	 $sql='SELECT i.* FROM `events'.$_REQUEST['ciudad'].'` as i WHERE (i.id_event="'.$data.'@'.$hora.'"  ) AND 
	 (i.tipus_event="lamborghini_lotus" OR i.tipus_event="lamborghini") ';
  }	

	else if($tipus=='lamborghini_lotus') {
	 $sql='SELECT i.* FROM `events'.$_REQUEST['ciudad'].'` as i WHERE (i.id_event="'.$data.'@'.$hora.'"  ) AND 
	 (i.tipus_event="lamborghini_lotus" OR i.tipus_event="lamborghini")
	 ';
  }
	 // cas 1 cotxe nomes
	else if($tipus=='_porsche_') {
	 $sql='SELECT i.* FROM `events'.$_REQUEST['ciudad'].'` as i WHERE (i.id_event="'.$data.'@'.$hora.'"  ) AND 
	 ( i.tipus_event="_porsche_") ';
  }
	else if($tipus=='_lotus_') {
	 $sql='SELECT i.* FROM `events'.$_REQUEST['ciudad'].'` as i WHERE (i.id_event="'.$data.'@'.$hora.'"  ) AND 
	 ( i.tipus_event="_lotus_") ';
  }
  else if($tipus=='_bferrari_') {
   $sql='SELECT i.* FROM `events'.$_REQUEST['ciudad'].'` as i WHERE (i.id_event="'.$data.'@'.$hora.'"  ) AND 
   ( i.tipus_event="_bferrari_") ';
  }
  else if($tipus=='_blamborghini_') {
   $sql='SELECT i.* FROM `events'.$_REQUEST['ciudad'].'` as i WHERE (i.id_event="'.$data.'@'.$hora.'"  ) AND 
   ( i.tipus_event="_blamborghini_") ';
  }
  else if($tipus=='_bporsche_') {
   $sql='SELECT i.* FROM `events'.$_REQUEST['ciudad'].'` as i WHERE (i.id_event="'.$data.'@'.$hora.'"  ) AND 
   ( i.tipus_event="_bporsche_") ';
  }

  // BUGGY
  else if($tipus=='_buggy_') {
   $sql='SELECT i.* FROM `events'.$_REQUEST['ciudad'].'` as i WHERE (i.id_event="'.$data.'@'.$hora.'"  ) AND 
   ( i.tipus_event="_buggy_") ';
  }

  else  {
   $sql='SELECT i.* FROM `events'.$_REQUEST['ciudad'].'` as i WHERE (i.id_event="'.$data.'@'.$hora.'"  ) AND 
   ( i.tipus_event="'.$tipus.'") ';
  }
	
	$result=mysqli_query($link,$sql);
	
	//if(mysql_num_rows($result))return false;
	//return true;
	

	if (!$result) return true;
	else
	{
	if(mysqli_num_rows($result))
		return false;
	return true;
	
	}
 	
  }

   
function marca_bautizo($data,$hora,$tipus)
{
	//Si es un circuito (y por lo tanto no hay ruta).
	if (strpos($_REQUEST['ciudad'],'circuito')!==false) return false;
	
	//Si és una ruta sin circuito
	global $link;
	$sql='SELECT i.marca FROM `bautizos'.$_REQUEST['ciudad'].'` as i WHERE (i.id_event="'.$data.'@'.$hora.'"  and tipus_event = "'.$tipus.'")';
	$result=mysqli_query($link,$sql);
    $reg = mysqli_fetch_assoc($result);
    if(mysqli_num_rows($result) and $reg['marca']==1) return true;
    return false;
}

  
function marca_bloqueado_solicitar($data,$hora,$tipus)
{
	//Si es un circuito (y por lo tanto no hay ruta).
	if (strpos($_REQUEST['ciudad'],'circuito')!==false) return false;
	
	//Si és una ruta sin circuito
	global $link;
	$sql='SELECT i.marca FROM `events'.$_REQUEST['ciudad'].'` as i WHERE (i.id_event="'.$data.'@'.$hora.'"  and tipus_event = "'.$tipus.'")';
	$result=mysqli_query($link,$sql);
    $reg = mysqli_fetch_assoc($result);
    if(mysqli_num_rows($result) and $reg['ocupado_solicitar']==1) return true;
    return false;
}  
  
  
  /*




function resta_quart($h) {
  $h=explode(':',$h);
	$h[1]=(int)$h[1]-15;
	if($h[1]==0)$h[1]='00';
	else $h[1]='30';
	return implode(':',$h);
}	

*/

// BUGGY
function label_hora($h, $persones, $transform = 1) {
  $h=explode(':',$h);
  switch ($persones) {
    case 2:
      if($transform == 1) { // lambo ferrari
        $h[1]=(int)$h[1];
        if($h[1]==0 || $h[1]==15)
           $h[1]='00';
        else $h[1]='30';
      } else if($transform == 2) { // batejos lambo ferrari
        $h[1]=(int)$h[1];
        if($h[1] < 15)
           $h[1]='00';
        else if($h[1] < 30)
           $h[1]='15';
        else if($h[1] < 45)
           $h[1]='30';
        else if($h[1] < 60)
           $h[1]='45';
      }
	  // mts 24122013(buggys: graella amb grups de 2 persones ampliables fins a 4, utilitzant dies_graella4 - ACTIU -). 
      else if($transform == 3) { 
        $h[1]=(int)$h[1];
		if($h[1]==0 || $h[1]==15)
           $h[1]='00';
        else if ($h[1]==30 || $h[1]==45) //30 37 45 52
		   $h[1]='30';
      } //fi mts.
	  
    break;
    case 3:
	  //mts 24012013: (buggys: graella amb grups de 3 persones ampliables fins a 4, utilitzant dies_graella4 - de moment inactiu -). 
      if($transform == 3)  
	  {
        $h[1]=(int)$h[1];
		if($h[1]==0 || $h[1]==7 || $h[1]==15)
           $h[1]='00';
        else if ($h[1]==30 || $h[1]==37 || $h[1]==45)
		   $h[1]='30';
	  }
	  //fi mts.
	  else
	  {
      $h[1]=(int)$h[1];
      if($h[1]==0 || $h[1]==10 || $h[1]==20)
         $h[1]='00';
      else $h[1]='30';
      }
	break;
	//mts 24012013
	case 4:
      if($transform == 3)  // (buggys: graella amb grups de 4 persones, utilitzant dies_graella4 - de moment inactiu -). 
	  {
        $h[1]=(int)$h[1];
		if($h[1]==0 || $h[1]==7 || $h[1]==15 || $h[1]==22)
           $h[1]='00';
        else if ($h[1]==30 || $h[1]==37 || $h[1]==45 || $h[1]==52)
		   $h[1]='30';
	  }
	
	break;
	//fi mts
	
  }
  return implode(':',$h);
}

function ocupado($h) {
  $sql='SELECT i.* FROM `events'.$_REQUEST['ciudad'].'` as i WHERE i.id_event="'.$h.'" AND (ocupa="555" or ocupa="556" or ocupa="557" or ocupa="558") AND tipus_event="'.calendari_tipus($_REQUEST['tipus']).'"';
  $result=mysqli_query($link,$sql);
  if(mysqli_num_rows($result))return true;
  return false;
}
   
function calendari_tipus($t) {
   switch($t) {
    case 'ferrari_porsche901':
      return 'ferrari';
    break;
    case 'lamborghini_lotus':
      return 'lamborghini';
    break;	
  }	
  return $t;
}

function header_() {
?>
<tr>
  <td align="right" width="50px" class="info hora">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </td>
  <td width="10px"></td>
  <td width="10px"></td>
  <td width="38px"> 		</td>
  <td class="info pilots">
	   <table width="100%">
	   <tbody><tr>
	   <td width="2%">
	     <img width="8px" alt="" src="tabs/img/persona.png">
	   </td>
	   <td width="10%" class="cabecera" style="font-weight:bold"> Piloto</td>
	   <td width="20%" class="cabecera ocult" style="font-weight:bold">Email piloto</td>
	   <td width="12%" class="cabecera" style="font-weight:bold">Telefono</td>
	   <td width="10%" class="cabecera" style="font-weight:bold">Persona regala</td>
	   <td width="15%" class="cabecera ocult" style="font-weight:bold">Email regala</td>
	   <td width="15%" class="cabecera ocult" style="font-weight:bold">Email confirmación</td>
	   
	   <td  class="cabecera mostra" style="font-weight:bold">Tel. regala</td>
	   <td  class="cabecera mostra" style="font-weight:bold">Observaciones</td>
	   <td width="25%" class="cabecera" style="font-weight:bold;text-align:right" > >>Acciones</td>
	  <a href="javascript:;" id="activa"></a> 
	   <a href="javascript:;" id="activa">
	   </a><a href="javascript:;" >&nbsp;&nbsp;</a></tr>
	   </tbody></table></td>
	</tr>
<?php	
} 

function header_2() {
?>
<tr>
  <td align="right" width="50px" class="info hora">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </td>
  <td width="10px"></td>
  <td width="10px"></td>
  <td width="38px"> 		</td>
  <td class="info pilots">
	   <table width="100%">
	   <tbody><tr>
	   <td width="2%">
	     <img width="8px" alt="" src="tabs/img/persona.png">
	   </td>
	   <td width="10%" class="cabecera" style="font-weight:bold"> Piloto</td>
	   <td width="12%" class="cabecera" style="font-weight:bold">Telefono</td>
	   <td width="10%" class="cabecera" style="font-weight:bold">Persona regala</td>
	   <td width="10%" class="cabecera ocult" style="font-weight:bold">Telefono regala</td>
	   <td width="15%" class="cabecera ocult" style="font-weight:bold">Observaciones</td>      
	   <td width="14%" class="cabecera ocult" style="font-weight:bold">F.Canjeado</td>          
	   <td width="27%" class="cabecera" style="font-weight:bold;text-align:right" > @ Acciones
	   <input type="checkbox" onclick="seleccionar_todos(this.checked)" value="2966">
	   </td>
	  <a href="javascript:;" id="activa"></a> 
	   <a href="javascript:;" id="activa">
	   </a><a href="javascript:;" >&nbsp;&nbsp;</a></tr>
	   </tbody></table></td>
	</tr>
<?php	
} 



function header_sel() {
?>
<tr>
  <td align="left" width="70px" class="info hora">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </td>
  <td class="info pilots">
	   <table width="300px">
	   <tbody>
	   <tr>
	   <td width="150px" class="cabecera" style="font-weight:bold"> Piloto</td>
	   <td width="150px" class="cabecera" style="font-weight:bold">Persona regala</td>
	   </tr>
	   </tbody>
	   </table>
   </td>
</tr>
<?php	
} 



function graella_oc($TEMPS)
{
	global $link,$persones;
 // Dia que li arriba
	$libres=false;
	$tipus=$_REQUEST['tipus'];
  // BUGGY
	if($tipus == '_buggy_')
    include 'dies_graella3.php';
  else 
    include 'dies_graella.php';

	$hores=$array_hores;
?>

<?php	
$i=0;
$info=' ';

foreach($hores as $hora=>$info) {

$hora=str_replace('@','',$hora);

if($hora=='c'){
	?>
	<?php
	continue ; 
}	

// cas graella 1 sol cotxe
if($tipus=='_porsche_' && $i%2 ){
	$i++;
	continue ; 
}

$hora_bona=$hora;  
if($persones==2 && $i%$persones){
	$hora=resta_quart($hora);
} else if($persones > 2 && $i%$persones) { // BUGGY
  $hora = label_hora($h, $persones);
}

  $perms=permisos($tipus,$TEMPS,$hora_bona);
  $t_aux='i.tipus_event="'.$tipus.'"';

  // graellas dobles <<  si estreu aixo i es posen tipus queda com abans
  if( $tipus=='ferrari' ){
  	$t_aux='(i.tipus_event="ferrari" OR i.tipus_event="ferrari_porsche901") ';
	}
  if($tipus=='lamborghini' ){
  	$t_aux='(i.tipus_event="lamborghini_lotus" OR i.tipus_event="lamborghini") ';
   }
// fi graelles dobles

	$sql='SELECT i.* FROM `events'.$_REQUEST['ciudad'].'` as i WHERE i.id_event="'.$TEMPS.'@'.$hora_bona.'" AND '.$t_aux.'';
    $result=mysqli_query($link,$sql);

	if(mysqli_num_rows($result) ){
	  // res
	} else { $libres=true;  }
 // recuperem info
	?>
	<?php 
	$i++;
  }
	?>
<?php	
return $libres;
}


function quants_dias($data_act, $data_ant){ 
  return round((strtotime($data_act) - 
     strtotime($data_ant)) / (24 * 60 * 60), 0); 
} 

function existeix_reserva_soci($id_event,$tipus_event){
 global $link;	
 $t_aux=' tipus_event="'.$tipus_event.'" ';
 if( $tipus_event=='ferrari' || $tipus_event=='ferrari_porsche901' ){
  	$t_aux='(tipus_event="ferrari" OR tipus_event="ferrari_porsche901") ';
	}
 else if($tipus_event=='lamborghini' || $tipus_event=='lamborghini_lotus'  )
 {
  	$t_aux='(tipus_event="lamborghini_lotus" OR tipus_event="lamborghini") ';
 }
 
 
  $sql='SELECT * FROM reserva_socio WHERE id_event = "'.$id_event.'" AND '.$t_aux.' AND ciudad  = "'.$_REQUEST['ciudad'].'";';
  $result=mysqli_query($link,$sql);
  //$result=Db::getInstance()->Execute($sql);
  if(mysqli_num_rows($result)>0)return mysqli_fetch_array($result);
  return false;
  }

  
  function km($km,$obs)
  {
 
	if (strpos(strtoupper($obs),$km.'KM')===false && strpos(strtoupper($obs),$km.' KM')===false)
	{
		return false;
	}
	else
	{
		return true;    
	}
  }
  
  function return_tipus_e($t,$observaciones=null)
  {
		
  switch($t)
  {
   case 'ferrari':
		if (km(40,$observaciones))
			return 'Ferrari 430 40 Km   ';
		else
			return 'Ferrari 430 20 Km   ';
   break;		
   case 'ferrari_porsche901':
   	    return 'Ferrari  430 20 Km  + Porsche  20 Km   ';
   break;	
   case 'lamborghini':
		if (km(40,$observaciones))
			return 'Lamborghini 40 Km';
		else
			return 'Lamborghini 20 Km';
   break;		
   case 'lamborghini_lotus':
         return 'Lamborghini 20 Km  + Porcshe 20 Km ';
   break;	
   case '_porsche_':
		if (km(40,$observaciones))
			return 'Porsche 40 Km ';
		else
			return 'Porsche 20 Km ';		
		
   break;	
   case '_lotus_':
    return 'Porsche 20 Km ';
   break;   
   case '_corvette_':
		if (km(40,$observaciones))                  
			return 'Corvette 40 Km';
		else	
			return 'Corvette 20 Km';
   break;		
   case '_bferrari_':
		if (km(14,$observaciones))                  
			return 'Ferrari 430 14 Km ';
		else
			return 'Ferrari 430 7 Km ';
   break;
   case '_blamborghini_':
		if (km(14,$observaciones))                  
			return 'Lamborghini 14 Km';
		else	
			return 'Lamborghini 7 Km';
   break;
   case '_bporsche_':
		if (km(14,$observaciones))                  
			return 'Porsche 14 Km';
		else
			return 'Porsche 7 Km';
   break;
   case '_bcorvette_':
   		if (km(14,$observaciones))                  
			return 'Corvette 14 Km';
		else
			return 'Corvette 7 Km';		
   break;
   case 'formula':
		return 'Fórmula';
	break;
   // BUGGY
   case '_buggy_':
    return 'BUGGY ';
	break;
   default:
	 return $t;
   break;
  }	
 } 


function es_bautizo($tipus)
{
	if (substr($tipus,0,2)=='_b') return true;
	else return false;
} 
 
 
function begin()
{
	@mysql_query("BEGIN");
}
function commit()
{
	@mysql_query("COMMIT");
}
function rollback()
{
	@mysql_query("ROLLBACK");
}
 
?>