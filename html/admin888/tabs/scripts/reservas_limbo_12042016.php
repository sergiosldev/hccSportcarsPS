<?php
include_once(dirname(__FILE__).'/config_events.php'); 
include_once dirname(__FILE__).'/../../../classes/Limbo.php';
include_once dirname(__FILE__).'/../../../classes/FuncionesSeguridad.php';


$rlimbo = new Limbo(); 
$class='';
if (isset($_GET['filtro_ciudad'])) $filtro_ciudad = FuncionesSeguridad::seg($_GET['filtro_ciudad']);
if (isset($_GET['filtro_tipo_evento'])) $filtro_tipo_evento = FuncionesSeguridad::seg($_GET['filtro_tipo_evento']);    
if (isset($_GET['filtro_dia'])) $filtro_dia = FuncionesSeguridad::seg($_GET['filtro_dia']);    
if (isset($_GET['ids'])) $filtro_ids = FuncionesSeguridad::seg($_GET['ids']);    

if (isset($_POST['filtro_ciudad'])) $filtro_ciudad = FuncionesSeguridad::seg($_POST['filtro_ciudad']);
if (isset($_POST['filtro_tipo_evento'])) $filtro_tipo_evento = FuncionesSeguridad::seg($_POST['filtro_tipo_evento']);    
if (isset($_POST['filtro_dia'])) $filtro_dia = FuncionesSeguridad::seg($_POST['filtro_dia']);    
if (isset($_POST['ids'])) $filtro_ids = FuncionesSeguridad::seg($_POST['ids']);    


$rlimbo = $rlimbo->getReservasLimbo($filtro_dia,$filtro_ciudad,$filtro_tipo_evento,$filtro_ids);       

$sfiltrociudad=($filtro_ciudad?$filtro_ciudad:'Barcelona');
 
$reservas_limbo= '
   <table '.$class.'  width="100%"  style="border:1px solid #CCCCCC;margin-left:12px;width:950px;padding:7px;">
   <tr style="height:33px;vertical-align:top;"'.$class.'>   
	   <td width="25%" colspan="2" style = "text-align:left;" class="cabecera_oferta">
	   	Reservas en el Limbo ('.$sfiltrociudad.')
	   </td> 
	</tr>
	<tr>   
	   <td width="13%" class="cabecera_limbo">Ciudad</td> 
	   <td width="13%" class="cabecera_limbo">Tipo Evento</td> 
	   <td width="13%" class="cabecera_limbo">F. Limbo</td> 
	   <td width="13%" class="cabecera_limbo">F. Reserva</td> 
	   <td width="12%" class="cabecera_limbo">Piloto</td> 
	   <td width="12%" class="cabecera_limbo">P.Regala</td> 
	   <td width="12%" class="cabecera_limbo">Tipo Limbo</td> 
	   <td width="12%"  class="cabecera_limbo">Localizador</td>    
	   <td width="12%"  class="cabecera_limbo">Consumo</td>    
	   <td width="12%"  class="cabecera_limbo">Usado</td>    
   </tr>';
   $reservas_limbo.='</hr>';	
   foreach ($rlimbo as $rl)
   {
   
	if ($rl->ciudad=='Barcelona')
	{
		$sciudad = '';
	}
	else 
	{
		$sciudad = $rl->ciudad;
	}
	
	if (substr($rl->fecha,0,10)==$filtro_dia)
	{
		$style='background:#8ff;';
	}
	else
	{
		$style='';
	}	
	$reservas_limbo.='
	  <tr '.$style.'>
		   <td width="13%" class="">'.$rl->ciudad.'</td> 
		   <td width="13%" class="">'.$rl->tipus_event.'</td> 		   
		   <td width="13%" class="">'.implode('/',array_reverse(explode('-',substr($rl->fecha,0,10)))).substr($rl->fecha,10,9).'</td> 
	  	   <td width="13%" class="">'.implode('/',array_reverse(explode('-',substr($rl->fechaReserva,0,10)))).substr($rl->fechaReserva,10,9).'</td> 
		   <td width="12%" class="">'.$rl->piloto.'</td> 
		   <td width="12%" class="">'.$rl->persona_regala.'</td> 
		   <td width="12%" class="">'.(($rl->tipo==1)?'Cancel.Sin Fecha':'Suspensi&oacute;n').'</td> 
		   <td width="12%" class="">'.$rl->localizador.'</td>    
		   <td width="12%" class="">'.$rl->consumo.'</td> 	   
		   <td width="12%" class="">'.(($rl->usado==1)?'S&iacute;':'No').'</td> 	    
		   <td><a style="width:10px;" id="activa" href="javascript:form_reubicarl(\''.$rl->idEvento.'\',\''.$sciudad.'\',\''.$rl->tipus_event.'\',\''.substr($rl->fechaReserva,0,10).'@'.substr($rl->fechaReserva,11,9).'\')">  
              <img title="Reubicar evento" src="'.URL_ROOT.'img/reubicar.jpg" width="18px" alt="" />
		  </a></td>
      </tr>';
   }
   
   $reservas_limbo.='</table>';
   unset($rlimbo);
   echo($reservas_limbo);

