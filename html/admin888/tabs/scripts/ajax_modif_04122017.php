<?php          
include_once('../config/config.inc.php');                                                                    
$inst=db::getInstanceOf();  
switch(strtoupper(substr(_NOMBRE_EMP_,0,3)))
{ 
	case 'HCC':
		$emp='hcc';
		break;
	case 'DRE':
		$emp='dre';
		break;
	default:
		$emp='mcb';
}

$_REQUEST['ciudad']=$_REQUEST['ciudad_sel'];                                                                                                  


if (strtolower($_REQUEST['ciudad'])=='barcelona')
{
    $_REQUEST['ciudad']='';
}
 
$bwonderbox=false;                                                                                                                                                                      

$_REQUEST['tipus']=$_REQUEST['tipo_vehiculo'];                        

if ($_REQUEST['km_ruta']%7==0 && tools::getValue('circuito')==0)    
{
    $_REQUEST['tipus']='_b'.$_REQUEST['tipus'].'_';          
} 
else 
{
    if ($_REQUEST['tipus']=='porsche' || $_REQUEST['tipus']=='corvette')
    {
        $_REQUEST['tipus']=='_'.$_REQUEST['tipus'].'_';
    } 
}    


$_REQUEST['data_reserva']=$_REQUEST['fecha_reserva'];    
$_REQUEST['fecha_entrada']=implode('-',array_reverse(explode('/',$_REQUEST['fecha_hotel'])));                                                                                                                                                                  


if (trim($_REQUEST['origen'])=='WONDERBOX') 
{
	$bwonderbox=true;
}
  

if(isset($_REQUEST['codigo_valida'])) 
{
  if(codigos_validos($_REQUEST['codigo_valida']) )
  {
  	session_start();
	if ($_REQUEST['codigo_valida']=='acliente')
		$_SESSION['reserva_cliente']=1;
		//die('error akir');
	$_SESSION["accessevents"] = date("Y-n-j H:i:s");
	$_SESSION["codigo_valida"]= $_REQUEST['codigo_valida'];
	die('OK1');
	}
  else die('ERROR');	
} 

/*mts 24032012, validamos que el cÃ³digo de localizador no estÃ© registrado */  
function codigo_existe($c)                                                                                              
{
    $sql='SELECT * FROM events WHERE codi_localtzador like "'.$c.'";';
  
	$result=$inst->executeS($sql);    
    
    if(count($result)!=0) return true;  
    else return false;
           
}  
/* fin modif mts */
function codigos_validos($c)
{

 	/* fin validaciÃ³n mts */
 	if(
		strtoupper(substr($c,0,2))=='LT' || 
		 strtoupper(substr($c,0,1))=='A' || 
		 strtoupper(substr($c,0,2))=='TI' || 
		 strtoupper(substr($c,0,3))=='MDT' ||
		 strtoupper(substr($c,0,3))=='O' ||
		 strtoupper(substr($c,0,3))=='F' || 
		 strtoupper($c)=='GTPASION' ||
		 strtoupper($c)=='A6TO6' ||
		 strtoupper($c)=='OSCE895461' ||
		 strtoupper(substr($c,0,2))=='21' 

	)	 
	 return true;
	return false; 
 }
  
 function codigo_excluido($codigo,$plataforma)
 {
	$scodigo=strtoupper($codigo);
	
	$codigos = array(
	'GFT95868362'=>'',
	'GFT38246447'=>'',
	'GFT67385356'=>'',
	'GFT85496376'=>'',
	'140301489476'=>'SUBASTA',
	'140300835269'=>'SUBASTA',
	'140302227146'=>'SUBASTA',
	'140301744322'=>'SUBASTA',
	'140300958718'=>'SUBASTA',
	'140302971802'=>'SUBASTA',
	'140301088985'=>'SUBASTA',
	'140301090879'=>'SUBASTA',
	'140302065382'=>'SUBASTA',
	'1766194'=>'SUBASTA',
	'140301126801'=>'SUBASTA',
	'840457'=>'SUBASTA',
	'140302074902'=>'SUBASTA',
	'1775454'=>'SUBASTA',
	'1775454'=>'SUBASTA',
	'1796746'=>'SUBASTA',
	'140300972877'=>'SUBASTA',
	'691330'=>'SUBASTA',
	'140302619738'=>'SUBASTA',
	'2317142'=>'SUBASTA',
	'140301276042'=>'SUBASTA',
	'986858'=>'SUBASTA',
	'140301624690'=>'SUBASTA',
	'1330464'=>'SUBASTA',
	'140301631222'=>'SUBASTA',
	'1336990'=>'SUBASTA',
	'140301588216'=>'SUBASTA',
	'1294530'=>'SUBASTA',
	'140302097714'=>'SUBASTA',
	'1797600'=>'SUBASTA',
	'140300958718'=>'SUBASTA',
	'140302971802'=>'SUBASTA',
	'140301088985'=>'SUBASTA',
	'140301090879'=>'SUBASTA',
	'140301489476'=>'SUBASTA',
	'140300835269'=>'SUBASTA',
	'140302227146'=>'SUBASTA',
	'140301744322'=>'SUBASTA',
	'140301008687'=>'SUBASTA',
	'140300563449'=>'SUBASTA',
	'140300570112'=>'SUBASTA',
	'140300563314'=>'SUBASTA',
	'140300562407'=>'SUBASTA',
	'140300824523'=>'SUBASTA'
	);
	
	
	
	
/*	if (tools::GetUserIp()=='88.7.96.199')
	{
	foreach ($codigos as $key=>$value)
	{
		if ($value=='')
		{
			$condicion[] = '('.trim($scodigo).'==='.$key.') || ('.trim($scodigo).'==='.'A'.$key.') || ('.trim($scodigo).'=== AA'.$key.') || ('.trim($scodigo).'=== AAA'.$key.')';                                                           
			$condicion2[] = ((trim($scodigo)==$key) || (trim($scodigo)=='A'.$key)  || (trim($scodigo)=='AA'.$key) ||  (trim($scodigo)=='AAA'.$key));                                                           
		}
		else if (strpos(strtoupper($plataforma),$value)!==false )
		{
			$condicion[] ='(strpos(strtoupper($plataforma),SUBASTA)!==false) and (('.trim($scodigo).'=='.$key.') || ('.trim($scodigo).'=='.'A'.$key.') || ('.trim($scodigo).'== AA'.$key.') || ('.trim($scodigo).'==AAA'.$key.'))';                                                           
			$condicion2[] = ((strpos(strtoupper($plataforma),$value)!==false)  and   ((trim(strval($scodigo))==strval($key)) ||  (trim(strval($scodigo))==strval('A'.$key)) ||  (trim(strval($scodigo))==strval('AA'.$key))  ||  (trim(strval($scodigo))==strval('AAA'.$key))));                                                           
		}

	}

	
	
	}
*/

	foreach ($codigos as $key=>$value)
	{
		if ($value=='')
		{
			$condicion[] = ((trim($scodigo)==$key) || (trim($scodigo)=='A'.$key)  || (trim($scodigo)=='AA'.$key) ||  (trim($scodigo)=='AAA'.$key));                                                           
		}
		else if (strpos(strtoupper($plataforma),$value)!==false )
		{
			$condicion[] = ((strpos(strtoupper($plataforma),$value)!==false)  and   ((trim(strval($scodigo))==strval($key)) ||  (trim(strval($scodigo))==strval('A'.$key)) ||  (trim(strval($scodigo))==strval('AA'.$key))  ||  (trim(strval($scodigo))==strval('AAA'.$key))));                                                           
		}
	}

	$condiciones = (bool)array_sum($condicion);

	
	/*if (trim($scodigo)=='GFT95868362' || trim($scodigo)=='GFT38246447' || trim($scodigo)=='GFT67385356' || trim($scodigo)=='GFT85496376' ||
		trim($scodigo)=='AGFT95868362' || trim($scodigo)=='AGFT38246447' || trim($scodigo)=='AGFT67385356' || trim($scodigo)=='AGFT85496376' ||
		trim($scodigo)=='AAGFT95868362' || trim($scodigo)=='AAGFT38246447' || trim($scodigo)=='AAGFT67385356' || trim($scodigo)=='AAGFT85496376' ||
		trim($scodigo)=='AAAGFT95868362' || trim($scodigo)=='AAAGFT38246447' || trim($scodigo)=='AAAGFT67385356' || trim($scodigo)=='AAAGFT85496376' ||
			(
			strpos(strtoupper($plataforma),'SUBASTA')!==false
			and 
				(
				trim($scodigo)=='140301489476' || trim($scodigo)=='140300835269' || trim($scodigo)=='140302227146' || trim($scodigo)=='140301744322' ||        
				trim($scodigo)=='A140301489476' || trim($scodigo)=='A140300835269' || trim($scodigo)=='A140302227146' || trim($scodigo)=='A140301744322' ||     
				trim($scodigo)=='AA140301489476' || trim($scodigo)=='AA140300835269' || trim($scodigo)=='AA140302227146' || trim($scodigo)=='AA140301744322' ||      
				trim($scodigo)=='AAA140301489476' || trim($scodigo)=='AAA140300835269' || trim($scodigo)=='AAA140302227146' || trim($scodigo)=='AAA140301744322' ||             
				
				trim($scodigo)=='140300958718' || trim($scodigo)=='140302971802' || trim($scodigo)=='140301088985' || trim($scodigo)=='140301090879' ||     
				trim($scodigo)=='A140300958718' || trim($scodigo)=='A140302971802' || trim($scodigo)=='A140301088985' || trim($scodigo)=='A140301090879' ||     
				trim($scodigo)=='AA140300958718' || trim($scodigo)=='AA140302971802' || trim($scodigo)=='AA140301088985' || trim($scodigo)=='AA140301090879' ||       
				trim($scodigo)=='AAA140300958718' || trim($scodigo)=='AAA140302971802' || trim($scodigo)=='AAA140301088985' || trim($scodigo)=='AAA140301090879' ||

				trim($scodigo)=='140302065382' || trim($scodigo)=='1766194' || trim($scodigo)=='140301126801' || trim($scodigo)=='840457' ||     
				trim($scodigo)=='A140302065382' || trim($scodigo)=='A1766194' || trim($scodigo)=='A140301126801' || trim($scodigo)=='A840457' ||     
				trim($scodigo)=='AA140302065382' || trim($scodigo)=='AA1766194' || trim($scodigo)=='AA140301126801' || trim($scodigo)=='AA840457' ||       
				trim($scodigo)=='AAA140302065382' || trim($scodigo)=='AAA1766194' || trim($scodigo)=='AAA140301126801' || trim($scodigo)=='AAA840457' ||

				trim($scodigo)=='140302074902' || trim($scodigo)=='1775454' || trim($scodigo)=='140302096860' || trim($scodigo)=='1796746' ||     
				trim($scodigo)=='A140302074902' || trim($scodigo)=='A1775454' || trim($scodigo)=='A140302096860' || trim($scodigo)=='A1796746' ||     
				trim($scodigo)=='AA140302074902' || trim($scodigo)=='AA1775454' || trim($scodigo)=='AA140302096860' || trim($scodigo)=='AA1796746' ||       
				trim($scodigo)=='AAA140302074902' || trim($scodigo)=='AAA1775454' || trim($scodigo)=='AAA140302096860' || trim($scodigo)=='AAA1796746' ||
				
				trim($scodigo)=='140300972877' || trim($scodigo)=='691330' || trim($scodigo)=='140302619738' || trim($scodigo)=='2317142' ||     
				trim($scodigo)=='A140300972877' || trim($scodigo)=='A691330' || trim($scodigo)=='A140302619738' || trim($scodigo)=='A2317142' ||     
				trim($scodigo)=='AA140300972877' || trim($scodigo)=='AA691330' || trim($scodigo)=='AA140302619738' || trim($scodigo)=='AA2317142' ||       
				trim($scodigo)=='AAA140300972877' || trim($scodigo)=='AAA691330' || trim($scodigo)=='AAA140302619738' || trim($scodigo)=='AAA2317142' ||           
				
				trim($scodigo)=='140301276042' || trim($scodigo)=='986858' || trim($scodigo)=='140301624690' || trim($scodigo)=='1330464' ||     
				trim($scodigo)=='A140301276042' || trim($scodigo)=='A986858' || trim($scodigo)=='A140301624690' || trim($scodigo)=='A1330464' ||     
				trim($scodigo)=='AA140301276042' || trim($scodigo)=='AA986858' || trim($scodigo)=='AA140301624690' || trim($scodigo)=='AA1330464' ||       
				trim($scodigo)=='AAA140301276042' || trim($scodigo)=='AAA986858' || trim($scodigo)=='AAA140301624690' || trim($scodigo)=='AAA1330464' ||          

				trim($scodigo)=='140301631222' || trim($scodigo)=='1336990' || trim($scodigo)=='140301588216' || trim($scodigo)=='1294530' ||     
				trim($scodigo)=='A140301631222' || trim($scodigo)=='A1336990' || trim($scodigo)=='A140301588216' || trim($scodigo)=='A1294530' ||     
				trim($scodigo)=='AA140301631222' || trim($scodigo)=='AA1336990' || trim($scodigo)=='AA140301588216' || trim($scodigo)=='AA1294530' ||       
				trim($scodigo)=='AAA140301631222' || trim($scodigo)=='AAA1336990' || trim($scodigo)=='AAA140301588216' || trim($scodigo)=='AAA1294530' ||          

				trim($scodigo)=='140302097714' || trim($scodigo)=='1797600' ||
				trim($scodigo)=='A140302097714' || trim($scodigo)=='A1797600' || 
				trim($scodigo)=='AA140302097714' || trim($scodigo)=='AA1797600' ||
				trim($scodigo)=='AAA140302097714' || trim($scodigo)=='AAA1797600' 
				

				)
			)
		) */
	if ($condiciones)	
		return true;
	else 
		return false;
 

 }
 

 
if (isset($_REQUEST['horas_disponibles']))
{
	$hd=horas_disponibles(tools::getValue('hora'),tools::getValue('tipus'));
} 


//Se utiliza únicamente para las rutas turísticas, que pueden reservar más de una plaza (más de un reg. de reserva), en una misma
//reserva. 
function horas_disponibles($id_event,$tipus)
{	
	global $inst;
	$plazas = plazas($tipus);
	
	$hores1=seleccionar_plantilla_graella($tipus);
	$hores=array();
	$i=0;

	foreach ($hores1 as $h=>$info)
	{
		if($h=='c' || !$h) continue;	
		if ($i%2) {$i++;continue;}
		else {$hores[$h]=$info;$i++;}	
	}
	
	$inicio_comprobacion=false;
	$comprobados=0;
	$rs=array();
	//Para evitar inyecciones sql.
	foreach ($reserva_a_duplicar as $clave=>$campo)
	{
		$rs[$clave]=FuncionesSeguridad::seg($campo);
	}
	
	//Recorremos todo el calendario hasta encontrar la hora de la reserva
	//insertada.  
	//begin();

	foreach($hores as $hora=>$info) 
	{
		$hora_tmp=explode('@',$id_event);
		$dia_event=$hora_tmp[0];
		$hora_event=$hora_tmp[1];
		//if($hora=='c' || !$hora) continue;	
		//Si encontramos la hora de la reserva empezaremos la duplicación.
		if ($hora_event==$hora)
		{
			$inicio_comprobacion=true;
		}
		//Duplicaremos mientras no alcancemos el número de plazas asignado al
		//tipo de ruta turistica.
		else if ($inicio_comprobacion && $comprobados<$plazas-1)
		{
//			//consulta comprobar si ya existe un registro con id_event = $id_event	
			$id_event_nuevo = $dia_event.'@'.$hora;
			$sql = ' SELECT count(*) cont FROM events'.$_REQUEST['ciudad'].' where  id_event="'.$id_event_nuevo.'"';  
			$ocupado=$inst->executeS($sql);
	    	$rocupado=$ocupado[0];
	    	  
	    	if ($rocupado['cont']>0) 
	    	{
	    		die('Error. No se pueden reservar '.$plazas.' celdas seguidas a partir de las '.$hora_event.' dado que ya hay alguna hora ocupada');
	    	}

			
		    $comprobados++;
		}
		else if ($inicio_comprobacion) {break;}
			
	}
	die ($id_event_nuevo.'#'.$id_event); 
	
 }	
 
 
if(isset($_REQUEST['id_alta']) && trim($_REQUEST['edicio'])=='false')  
{
	try
	{
		//mts 25042012.  si se trata de una promociÃ³n, se aÃ±ade el texto Extra 49 euros en observaciones.
		if (tools::getValue('tipus')=='ferrari_porsche901' || tools::getValue('tipus')=='lamborghini_lotus')
		{
			if ($_REQUEST['Observaciones']<>'') $_REQUEST['Observaciones'] = ' Extra 49 &euro; - '.$_REQUEST['Observaciones'];    
			else $_REQUEST['Observaciones'] = ' Extra 49 &euro;';
		} 
			

		if(trim($_REQUEST['alojamiento_ad'])=='')        
			$_alojamiento='';
		else
		{
		if (tools::getValue('alojamiento_ad')=='0') $_alojamiento = '0';
		else if (tools::getValue('alojamiento_ad')=='1')  $_alojamiento = '1';
		}
		//die('akir'.$_alojamiento);
		
		if (tools::getValue('es_spa')=='1') $_spa=1;  
		else $_spa=0;
		
		

		$ffentrada = explode('/',tools::getValue('fecha_entrada'));
		$ffsalida = explode('/',tools::getValue('fecha_salida'));
		
		if($_REQUEST['id_hotel'])                                                                           
		{
			$id_hotel=$_REQUEST['id_hotel'];    
			$nombre_hotel=nombre_hotel($id_hotel);
			if (trim(tools::getValue('fechaentrada'))!='')                                      
			{ 	
				if (valida_formato_fecha_caducidad(tools::getValue('fecha_entrada'))===false)  
				 {
					$_aux= " Formato de fecha de entrada incorrecto.";                  
						
					die('<div style="border:1px solid #f00;margin:3px;padding:3px;color:#f00;font-weight:bold;font-size:12px">'.$_aux.'</div>');   	               
				 }  
				 else if (checkdate($ffentrada[1],$ffentrada[0],$ffentrada[2])===false)
				 {
					$_aux= " Formato de fecha de entrada incorrecto.";
						
					die('<div style="border:1px solid #f00;margin:3px;padding:3px;color:#f00;font-weight:bold;font-size:12px">'.$_aux.'</div>');   	 
				 }
			}
			/*if (trim(tools::getValue('fechasalida'))!='')
			{ 	
				 if (valida_formato_fecha_caducidad(tools::getValue('fechasalida'))===false)
				 {
					$_aux= " Formato de fecha de salida incorrecto.";
						
					die($_aux);   	 
				 }
				 else if (checkdate($ffsalida[1],$ffsalida[0],$ffsalida[2])===false)
				 {
					$_aux= " Formato de fecha de salida incorrecto.";
						
					die($_aux);   	 
								 
				 }
			}	 	*/
			

			
			if ($_REQUEST['fecha_entrada']!='')     
			{
				$_fecha_entrada = $_REQUEST['fecha_entrada'];        
			}

		}
		else
		{
			 $_fecha_entrada = '';
			 $_fecha_salida = '';
		}	 
		
		if (trim(tools::getValue('persona_hotel'))!='') $_persona_hotel = tools::getValue('persona_hotel').'&id='.rand(0,10000);	
		
		if($_REQUEST['id_hotel'])
		{

		 
			$texto_restaurante='';
			if ($_REQUEST['ciudad']=='' && $_REQUEST['id_hotel']==4949)
			{
				$texto_restaurante=utf8_encode('. Si su cupón dispone de cena póngase en contacto con Motor Club Experience al 93 126 32 81. ');
			}
			
			
			 if ($_REQUEST['ciudad'] != 'cantabria' and $_REQUEST['ciudad'] != 'andalucia')
			 {
				 if ($_REQUEST['Observaciones']<>'') 
				 {
					$_REQUEST['Observaciones'] = '!Muy importante! Recuerde llamar al hotel '.nombre_hotel($_REQUEST['id_hotel']).' al '.$_REQUEST['telefono_hotel'].' para confirmar la reserva de la noche  '.$_fecha_entrada.' '.$texto_restaurante.' '.$_REQUEST['Observaciones'];           
				 }
				 else 
				 {
					$_REQUEST['Observaciones'] = '!Muy importante! Recuerde llamar al hotel '.nombre_hotel($_REQUEST['id_hotel']).' al '.$_REQUEST['telefono_hotel'].' para confirmar la reserva de la noche  '.$_fecha_entrada.' '.$texto_restaurante;          
				 }
			 }			 
			 else 
			 {
				 if ($_REQUEST['Observaciones']<>'') 
				 {
					$_REQUEST['Observaciones'] = 'hotel '.nombre_hotel($_REQUEST['id_hotel']).' - '.$_REQUEST['Observaciones'];           
				 }
				 else 
				 {
					$_REQUEST['Observaciones'] = 'hotel '.nombre_hotel($_REQUEST['id_hotel']);          
				 }
				 
			 }	 
		}

		
		if (strtoupper(tools::getValue('origen'))=='OTROS') $origen_observ = tools::getValue('otros');	
		else $origen_observ = tools::getValue('origen');
		
		
		
		
		$_REQUEST['Observaciones'] = str_replace('_',' ',$origen_observ).' - '.$_REQUEST['Observaciones'];    

		if (substr(_NOMBRE_EMP_,0,3)!='MOT')	
			$_REQUEST['Observaciones']=substr(strtoupper(str_replace(' ','',_NOMBRE_EMP_)),0,9).' '.$_REQUEST['Observaciones'];

		if (valida_formato_fecha_caducidad(tools::getValue('fecha_caducidad'))===false)
		{
			$_aux= " Formato de fecha incorrecto.";
				
			die($_aux);        
		}

		if (!valida_fecha_caducidad(tools::getValue('fecha_caducidad'),tools::getValue('id_alta')) && tools::getValue('fecha_caducidad')!=='00/00/0000')                                                                   
		{
			$_aux= " Su cupón está caducado para la fecha que ha escogido para realizar el evento. Contacte con ".EMAIL_INFO." y solicite que le amplíen la fecha de caducidad, y le envíen el cupón de ampliación. Esta gestión es muy importante,  ya que el día del evento los organizadores no admiten cupones caducados sin su confirmación de ampliación. Con lo cual será imposible prestar los servicios. Para más información contacte al 931263281 - 680697109.";                                                                                                      
				
			die($_aux); 	    
		}


		if (str_replace(' ','',$_REQUEST['id_hotel'])=='' && valida_ip(tools::GetUserIp())==false)
		{   
			$_aux= "Ha superado el límite de reservas para este mes. Póngase en contacto con nosotros y se la realizaremos de forma manual.";
				
			die($_aux); 
		}
	   
	   
		
		if (codigo_excluido(tools::getValue('codigo_localizador'),tools::getValue('origen')))
		{
			die('C&oacute;digo localizador inv&aacute;lido'); 
		}
		

		if (codigo_excluido(tools::getValue('codigo_consumo'),tools::getValue('origen')))
		{
			//die('<div style="border:1px solid #f00;margin:3px;padding:3px;color:#f00;font-weight:bold;font-size:12px">C&oacute;digo de consumo inv&aacute;lido</div>'); 
			die('C&oacute;digo de consumo inv&aacute;lido'); 
		}
		
		$_aux_=valida();
		
		
		$_aux_limbo = $_aux_[0];
		$_aux_=$_aux_[1];
		
	

		if($_aux_)	        
		{
			die($_aux_);   	 
			 
		}  

		if (tools::getValue('sv_experiencia_mas_hotel')==1)	
		{
			$_servicio_hotel='experiencia_+_hotel'; 
			if ($_REQUEST['Observaciones']<>'') $_REQUEST['Observaciones']= ' hotel - '.$_REQUEST['Observaciones'];         
			else $_REQUEST['Observaciones'] =  ' hotel ';
			
		}
		else 
		{
			$_servicio_hotel='experiencia';
		}


			

		


		/******/
		

		//Para el caso (Hotel Ciutat Igualada) no validarÃ¡ el nif.
		/*if(!($_REQUEST['id_hotel'] && ($_REQUEST['id_hotel']=='4949' || $_REQUEST['id_hotel']=='2011')))	
		{*/

			//$ret=check_nif_cif_nie(tools::getValue('nif'));
			$ret=true;
			//die('2');
			//die('res:'.$ret);  
			if ($ret===false)
			{
				$_aux= " Formato de nif incorrecto.";
					
				die('<div style="border:1px solid #f00;margin:3px;padding:3px;color:#f00;font-weight:bold;font-size:12px">'.$_aux.'</div>');        
			}
			//else die('a'.$a);
		/*}*/
		if($_REQUEST['tipus']=='porsche996')
		{
			 $sql='SELECT i.* FROM `events'.$_REQUEST['ciudad'].'` as i WHERE ( i.id_event="'.$_REQUEST['id_alta'].'") AND 
		 (i.tipus_event="porsche996" ) ';
		 
		 
		 $result=$inst->executeS($sql);
		 if(count($result)) $_REQUEST['tipus']='porsche997';
		}
	

		if(trim($_REQUEST['origen']=='OTROS'))$_REQUEST['origen']=$_REQUEST['otros'];

		if(!isset($_REQUEST['email1']))$_REQUEST['email1']='';
		
	 
		if(!es_pot_donar_alta())
			die('YA ESTA OCUPADA LA HORA EN QUESTIÓN, HA SIDO OCUPADA MIENTRAS USTED ESTABA EN RESERVAS'); 
		

		


		//if (strtoupper(tools::getValue('fecha_caducidad'))=='CA' || strtoupper(tools::getValue('fecha_caducidad'))=='SI' || strtoupper(tools::getValue('fecha_caducidad'))=='SIN FECHA DE CADUCIDAD'  )
		if (tools::getValue('fecha_caducidad')=='00/00/0000')
			$sfecha_caducidad = '';
		else $sfecha_caducidad = tools::getValue('fecha_caducidad');
		$Observaciones = $_REQUEST['Observaciones'];
		$Observaciones = trim($Observaciones);

		if (in_array(tools::getValue('km_ruta'),array(14,40)))
		{
			if (substr($Observaciones,-1)!='-')	
				$Observaciones .= ' - ruta de ' . tools::getValue('km_ruta') . ' km. ';
			else $Observaciones .= ' ruta de ' . tools::getValue('km_ruta') . ' km. ';
				
		}
		if (strpos(tools::getValue('tipus'),'ruta_turistica')!==false)   
			$brutas_turisticas=true;
		else $brutas_turisticas=false;

		if ($brutas_turisticas) 
			{
			$campo_extra =',id_event_ini';
			$valor_extra=tools::getValue('id_alta').'", "';
			}
		else 
			{
			$campo_extra='';
			$valor_extra='';
			}

			
		//$marca_limbo = strpos($_aux_,'limbo#');	    
		$marca_limbo = strpos($_aux_limbo,'limbo#');	    
		
		//crearemos el evento como validado o no, según la reserva que hubiera en el limbo, y marcaremos el registro del limbo como usado.        
		
		if ($marca_limbo!==false)   
		{
			//$marcat_tmp = explode('#',substr($_aux_,$marca_limbo));
			$marcat_tmp = explode('#',substr($_aux_limbo,$marca_limbo));
			$marcat = intval($marcat_tmp[1]);
			$id_ev = $marcat_tmp[2];
			$sqll = ' UPDATE limbo SET usado=1 WHERE id_evento = '.$id_ev;
			
			
			$resultl=$inst->execute($sqll);
		}		
		else 
		{
			$marcat = '';
		}
		
		
		/************************/

	$existe_reserva_mismo_codigo=reserva_mismo_codigo(tools::getValue('codigo_localizador'),tools::getValue('codigo_consumo'),$_REQUEST['ciudad']);
	
	if ($existe_reserva_mismo_codigo && trim(tools::getValue('codigo_localizador'))!='MCE578092')
	{
		$_aux='Ya existe una reserva con éstos códigos. Póngase en contacto a través del <a style="color:#fff" href="'._BASE_URL_.'/contact-form.php#contactform\'">formulario de contacto</a> para consultar la incidencia ';
		die('<div style="border:1px solid #f00;margin:3px;padding:3px;color:#f00;font-weight:bold;font-size:12px">'.$_aux.'</div>'); 
	}

	$fecha_validacion='';

	/** Heredamos la fecha de validación de la tabla de ampliaciones o de la primera reserva validada anteriormente que tenga fecha de valid. **/
	$existe_ampliacion=comprobar_ampliaciones(tools::getValue('codigo_localizador'),tools::getValue('codigo_consumo'));  
	$sciudad=($_REQUEST['ciudad']=='')?'barcelona':$_REQUEST['ciudad'];
	
	$existe_reserva_canjeada=existe_reserva_canjeada(tools::getValue('codigo_localizador'),tools::getValue('codigo_consumo'),$sciudad);   
	//if (tools::getuserip()=='81.35.51.5') die('error '.$existe_ampliacion.'-'.$existe_reserva_canjeada); 
	
	if ($existe_ampliacion)
	{
		$fecha_canjeado=$existe_ampliacion;
	}
	else if ($existe_reserva_canjeada)
	{
		$fecha_canjeado=$existe_reserva_canjeada;
	}
	else
	{
		$fecha_canjeado='';
	}


	$set_fecha_canjeado='';

	if ($fecha_canjeado && (!trim(tools::getValue('codigo_localizador'))=='MCE578092'))  
	{
		$fecha_validacion=$fecha_canjeado;
		$marcat='1';
	}		
	//Si no se han encontrado los códigos en la tabla de ampliaciones ni en ninguna reserva anterior ponemos como fecha de validación
	//la fecha actual.
	else
	{
		$fecha_validacion='NULL'; 
		$marcat='';
	}
		 
	
	if (trim(tools::getValue('codigo_localizador'))=='')
	{
		$_aux='Debe introducir el/los códigos correspondientes al orígen seleccionado. Si tiene cualquier duda póngase en contacto a través del <a style="color:#fff" href="'._BASE_URL_.'/contact-form.php#contactform\'">formulario de contacto</a> para consultar la incidencia ';
		die('<div style="border:1px solid #f00;margin:3px;padding:3px;color:#f00;font-weight:bold;font-size:12px">'.$_aux.'</div>'); 
	}
			
		
		/************************/
		
		if (strtoupper(tools::getValue('origen'))=='OTROS') $texto_origen = tools::getValue('otros');	
		else $texto_origen = tools::getValue('origen');


		$sql='INSERT INTO `events'.$_REQUEST['ciudad'].'` (                                                               
			id_event'.$campo_extra.',email ,telefon ,marcat,pilot,dia,
			tipus_event,persona_regala,email_persona_regala,mobil_persona_regala,coches,codi_localtzador,codi_consum,
			Observaciones,origen,plazas,email_confirm,data_reserva,data_caducitat_cupo,ip,cupon,nif,alojamiento,spa,persona_hotel,
			id_hotel,nombre_hotel,apellidos_piloto,apellidos_persona_regala,fecha_entrada,fecha_salida,tipo_servicio,ruta,fecha_canjeado,circuito';
		
		if (tools::getValue('circuito')) 
			$sql.=',num_vueltas';
		
		$sql.='	) ';               
		
		$sql.=' VALUES ("'.
		tools::getValue('id_alta').'", "'.
		$valor_extra.
		trim(tools::getValue('email')).'", "'.
		tools::getValue('telefon').'","'.
		intval($marcat).'","'.
		tools::getValue('pilot').'","'.
		$aux[0].'","'.
		$_REQUEST['tipus'].'","'. 
		//tools::getValue('tipus').'","'.
		tools::getValue('persona_regala').'","'.
		trim(tools::getValue('email_regala')).'","'.
		tools::getValue('telefon_regala').'","'.
		tools::getValue('coches').'","'.
		tools::getValue('codigo_localizador').'","'.
		tools::getValue('codigo_consumo').'","'.
		$Observaciones.'","'.
		$texto_origen.'","'.
		plazas($_REQUEST['tipus']).'","'.
		trim(tools::getValue('email1')).'","'.
		tools::getValue('fecha_reserva').'","'.
		$sfecha_caducidad.'",INET_ATON("'.tools::getValue('ip').'"),"'.
		tools::getValue('fileUpload').'","'.
		tools::getValue('nif').'","'.
		$_alojamiento.'","'.
		$_spa.'","'.
		$_persona_hotel.'","'.
		$id_hotel.'","'.
		$nombre_hotel.'","'.
		tools::getValue('apellidos_piloto').'","'.
		tools::getValue('apellidos_persona_regala').'","'.
		$_fecha_entrada.'","'. 
		$_fecha_salida.'","'.
		$_servicio_hotel.'","'.
		//intval($_REQUEST['km_ruta']).'","'.
		tools::getValue('km_ruta').'","'.
		$fecha_validacion.'",'.
		tools::getValue('circuito');
		if (tools::getValue('circuito')) 
			$sql.=','.tools::getValue('num_vueltas');
		$sql.=');';	
		   
		$time_start = microtime(true);  
		
		
		try 
		{
			$result=$inst->execute($sql);
			if (!$result)
			{
			}
			
			$time_end = microtime(true);
			$time = $time_end - $time_start;	
			$id=$inst->Insert_ID();
			$upd= ' update ps_usuarios set telefono = '.trim(tools::getValue('telefon_regala')).' where email="'.trim(tools::getValue('email_regala')).'" ';
			$result2=$inst->execute($upd);
			
			
			if (!$result2)
			{
				$err=mysql_error().'<br /><br /><pre>'.$sql.'</pre>';
				throw new Exception('Error al actualizar el teléfono del usuario con el campo "teléfono de la persona que regala".#'.$upd); 
			}
			
			if ($brutas_turisticas)
			{
					 if ($result)
					 {
						$sql = ' SELECT * FROM events'.$_REQUEST['ciudad'].' where  id="'.$id.'"';  
						$insertado=$inst->executeS($sql);
						if (!$insertado)
						{
							$err=mysql_error().'<br /><br /><pre>'.$sql.'</pre>';
							throw new Exception('Error: no se encontró el registro de la ruta turística.#'.$err); 
						}
						
						$rinsertado=$insertado[0];
						
						if ($rvalidado) 
						{
							$reserva_a_duplicar=$rinsertado;
						}
						else $reserva_a_duplicar=array();
					}

					$result=duplicado_reservas_turisticas(tools::getValue('id_alta'),plazas($_REQUEST['tipus']),$reserva_a_duplicar);	
			}
			
			if($result)
			{
					if (trim(tools::getValue('email1'))=='') 
						$destinatario = tools::getValue('persona_regala');
					else 
						$destinatario = tools::getValue('email1');

					$empresa=ucfirst(str_replace(' ','',_NOMBRE_EMP_));
										
					$body=genera_body_oferta_mails($_REQUEST['ciudad'],$id,$empresa,$destinatario,$imagen_portada,$url_base);
					
					$time_start = microtime(true);  
					envia_mails_pdf($destinatario);	
					enviar_mail_aviso_documentacion($destinatario);   
					echo('enviado doc');
					$time_end = microtime(true);
					$time = $time_end - $time_start;	
					//echo('time envia_mails_pdf: '.$time);		
										   
					if ($bwonderbox)
					{
						envia_mails_pdf_wb($destinatario);
						echo('enviado wb');
					}	
					
					if ($_servicio_hotel == 'experiencia_+_hotel')
					{
						if ($_REQUEST['ciudad'] != 'cantabria' && $_REQUEST['ciudad'] !='andalucia')
							enviar_mail_aviso_hotel($destinatario);
						
						echo('enviado aviso hot');
						
						if ($_REQUEST['ciudad'] != 'cantabria' && $_REQUEST['ciudad'] !='andalucia')
							envia_mails_pdf('hotel');
						
						echo('enviado pdf hotel');
					}
								
					envia_mails_pdf('motorclub');	
					echo('enviado mc');
										   
										   
										   
					if(isset($_SESSION["accessevents"]))
					{
						unset($_SESSION["accessevents"]);			
					}
					
					die('OK');
			}				
		}
		catch(Exception $ex)
		{
			$err=$ex->getMessage().'-'.mysql_error().'<br /><br /><pre>'.$sql.'</pre>';
			$log = new Log(true);
			$log->fileName='errores_reservas';
			$log->escribirLog('error_interno: '.'Error al crear el registro de la reserva.#'.$err);
			unset ($log);
			die('error_interno#'.$error_a[0]);

		}
		
		
		
		/******/
	
	} /** fin Try **/
	catch(Exception $e)
	{
		$error=$e->getMessage();
		$error_a=explode('#',$error);
		$log = new Log(true);
		$log->fileName='errores_reservas';
		$log->escribirLog('error_interno: '.$error_a[1]);
		unset ($log);
		die('error_interno#'.$error_a[0]);

	}
}



function plazas($t)
{
  switch ($t)
    {
	    case 'ferrari_porsche901':
	    case 'lamborghini_lotus':
	    case 'porsche997_porsche996':
	    case 'ferrari_ruta_turistica2':
	    case 'lamborghini_ruta_turistica2':
	    	return 2;         
	    case 'ferrari_ruta_turistica3':
	    case 'lamborghini_ruta_turistica3':
	    	return 3;         
	    case 'ferrari_ruta_turistica4':
	    case 'lamborghini_ruta_turistica4':
	    	return 5;         
    }
    return 1;    
}

function es_pot_donar_alta()
{
   global $inst;
   
   // afegit per assegurar tiro
   $t_aux=' tipus_event="'.tools::getValue('tipus').'" ';
   
    if( $_REQUEST['tipus']=='ferrari' || $_REQUEST['tipus']=='ferrari_porsche901' ){
  	$t_aux='(i.tipus_event="ferrari" OR i.tipus_event="ferrari_porsche901") ';
	}
 else if($_REQUEST['tipus']=='lamborghini' || $_REQUEST['tipus']=='lamborghini_lotus'  ){
  	$t_aux='(i.tipus_event="lamborghini_lotus" OR i.tipus_event="lamborghini") ';
   }
   
   		
   	$sql='SELECT i.* FROM events'.$_REQUEST['ciudad'].' as i WHERE i.id_event="'.tools::getValue('id_alta').'" AND '.$t_aux.'';

    $result=$inst->executeS($sql);
	return (count($result)<1);
}

function valida()
{
   
   	$cad='';
	
	//Para el hotel Ciutat Igualada sÃ³lo se validarÃ¡n el mail de confirmaciÃ³n y la fecha de caducidad.
	/*if(!($_REQUEST['id_hotel'] && ($_REQUEST['id_hotel']=='4949' || $_REQUEST['id_hotel']=='2011')))		
	{*/
	
		 if(trim($_REQUEST['email'])==''){$cad.='El email del piloto es obligatorio<br>'; }  		 
		 else if (!filter_var(trim($_REQUEST['email']), FILTER_VALIDATE_EMAIL)) {
		   $cad.='El email del piloto es no tiene un formato valido<br>';
			  }	

		 if(trim($_REQUEST['email_regala'])==''){$cad.='El email de la persona que regala es obligatorio<br>'; }  
		 elseif ( !filter_var(trim($_REQUEST['email_regala']), FILTER_VALIDATE_EMAIL)) 
		 {
		   $cad.='El email de la persona que regala  no tiene un formato valido<br>';
	     }		    	
		
		 if(trim($_REQUEST['telefon']=='')){$cad.='El telÃ©fono del piloto es obligatorio<br>'; } 
		 else  if ( !preg_match('/^[0-9]{1,}$/',trim($_REQUEST['telefon']))) 
		 {
		   $cad.='El telefono del piloto no es valido<br>';
		 }	
		 
		 if(trim($_REQUEST['pilot'])==''){$cad.='El nombre del piloto es obligatorio<br>'; }
		 if(trim($_REQUEST['apellidos_piloto'])==''){$cad.='Los apellidos del piloto son obligatorios<br>'; }
		 
		 if(!FuncionesValidacion::validar_telefono_movil($_REQUEST['telefon_regala'])) 
		 {
			$cad.= 'Formato de tel&eacute;fono m&oacute;vil incorrecto de la persona que regala. Debe introducir un tel&eacute;fono m&oacute;vil para posibles avisos relacionados con el evento via SMS.<br>';                                  
		 }

		 //if ($_REQUEST['id_hotel'] && $_REQUEST['alojamiento_ad']=='') $cad.='El tipo de alojamiento es obligatorio<br>';
	/*}*/
	
	
	

	if(isset($_REQUEST['email1']))
	{
		if(trim($_REQUEST['email1'])==''){$cad.='El email de confirmación de reserva es obligatorio<br>'; } 
		if(trim($_REQUEST['email2'])==''){$cad.='El email de confirmación de reserva repetido es obligatorio<br>'; }
		if(trim($_REQUEST['email1'])!='' && trim($_REQUEST['email2'])!=''){ 
		  if(trim($_REQUEST['email1'])!=trim($_REQUEST['email2'])){
		  $cad.='Los emails de confirmación de reserva deven coincidir<br>';
		  }
		  if ( !filter_var(trim($_REQUEST['email1']), FILTER_VALIDATE_EMAIL)) {
		  $cad.='El email de  confirmación de reserva  no tiene un formato valido<br>';
		  }	
		  if ( !filter_var(trim($_REQUEST['email2']), FILTER_VALIDATE_EMAIL)) {
		  $cad.='El email de  confirmación de reserva repetido  no tiene un formato valido<br>';
		  }
		}
	} 
	
	
	//Para el hotel Ciutat Igualada sÃ³lo se validarÃ¡n el mail de confirmaciÃ³n y la fecha de caducidad.	
	/*if(!($_REQUEST['id_hotel'] && ($_REQUEST['id_hotel']=='4949' || $_REQUEST['id_hotel']=='2011')))	
	{*/
		 if(trim($_REQUEST['persona_regala']=='')){$cad.='El nombre de la persona que regala  es obligatorio<br>'; } 
		 if(trim($_REQUEST['apellidos_persona_regala']=='')){$cad.='Los apellidos de la persona que regala son obligatorios<br>'; } 
		 if(trim($_REQUEST['nif']=='')){$cad.='El nif es obligatorio<br>'; } 
		 if(trim($_REQUEST['telefon_regala']=='')){$cad.='El telÃ©fono de la persona que regala es obligatorio<br>'; } 

		 else
		   if ( !preg_match('/^[0-9]{1,}$/', trim($_REQUEST['telefon_regala']))) {
		   $cad.='El telefono de la persona que regala  no es valido<br>';
			  }		    
		 
		 
		 $valida_codigos_aux=true;
		 if(!str_replace(' ','',$_REQUEST['origen'])){$cad.='Debe escoger una opcion para el origen<br>'; } 
		 else if(trim($_REQUEST['origen'])!='C.C' &&  !( trim($_REQUEST['origen'])=='OTROS'  && strtoupper(trim($_REQUEST['otros']))=='GTPASION' ) ){
		 
		   $r=canvia_textos_codigo($_REQUEST['origen']);
		   if(!str_replace(' ','',$_REQUEST['codigo_localizador']) )
		   {
			$cad.='El '.$r['0'].' es obligatorio..<br>'; $valida_codigos_aux=false; 
		   }
		   //mts. 18/05. CÃ“DIGO ALFA.
		   if(!str_replace(' ','',$_REQUEST['codigo_consumo'])  && trim($_REQUEST['origen'])!='Ticket descuento' && trim($_REQUEST['origen'])!='EMOCION' && trim($_REQUEST['origen'])!='PLANEO'  && trim($_REQUEST['origen'])!='MOTORCLUBEXPERIENCE'  && trim($_REQUEST['origen'])!='DREAMCARSEXPERIENCE' && trim($_REQUEST['origen'])!='HCCSPORTCARS'&& trim($_REQUEST['origen'])!='DOOPLAN' and trim($_REQUEST['origen'])!='CODIGO_ALFA'  and trim($_REQUEST['origen'])!='LA_TIENDA_MARCA' and trim($_REQUEST['origen'])!='DAKOTABOX' and trim($_REQUEST['origen'])!='WONDERBOX' and trim($_REQUEST['origen'])!='Otros') 
		   {
				$cad.='El '.$r['1'].' es obligatorio...<br>';    
				$valida_codigos_aux=false; 
			}
		 }
		 
		 if(trim($_REQUEST['origen']=='OTROS')){
		   if(trim($_REQUEST['otros']=='')){$cad.='Debe indicar otro origen<br>';  
		   }
		 }
		 $r='';
		 
		 if($valida_codigos_aux && str_replace(' ','',$_REQUEST['origen']!='') )$r=valida_codigos();
	/*}  */
	if($r)
	{
		
		$cad.=$r[1];     
		//die('error  '.$cad);
	}
    return (array($r[0],''.$cad.''));
}


function valida_formato_fecha_caducidad($fecha_caducidad)
{
    
   //return false;//return(is_numeric(substring($fecha_caducidad,1,2)));
    //return ((strtoupper($fecha_caducidad)=='CA' || strtoupper($fecha_caducidad)=='SI' || strtoupper($fecha_caducidad)=='SIN FECHA DE CADUCIDAD'  ) || is_numeric(substr($fecha_caducidad,0,2)) && is_numeric(substr($fecha_caducidad,3,2)) && is_numeric(substr($fecha_caducidad,6,4)) && substr($fecha_caducidad,2,1).substr($fecha_caducidad,5,1)=='//' && substr($fecha_caducidad,10)=='' ); 
	return (is_numeric(substr($fecha_caducidad,0,2)) && is_numeric(substr($fecha_caducidad,3,2)) && is_numeric(substr($fecha_caducidad,6,4)) && substr($fecha_caducidad,2,1).substr($fecha_caducidad,5,1)=='//' && substr($fecha_caducidad,10)=='' ); 
}
//mts 03102012. fecha de caducidad.

function valida_fecha_caducidad($fecha_caducidad,$fecha_escogida)
{
  $valoresPrimera = explode ("/", $fecha_caducidad);   
  $valoresSegunda = explode ("-", $fecha_escogida); 

  $diaPrimera    = $valoresPrimera[0];  
  $mesPrimera  = $valoresPrimera[1];  
  $anyoPrimera   = $valoresPrimera[2]; 


  $diaSegunda   = substr($valoresSegunda[2],0,2);  
  $mesSegunda = $valoresSegunda[1];  
  $anyoSegunda  = $valoresSegunda[0];

    $diasPrimeraJuliano = mktime ( 9 , 0, 0 , $mesPrimera, $diaPrimera, $anyoPrimera ) ;
    $diasSegundaJuliano = mktime ( 9 , 0, 0 , $mesSegunda, $diaSegunda, $anyoSegunda ) ;


  if(!checkdate($mesPrimera, $diaPrimera, $anyoPrimera)){
    // "La fecha ".$primera." no es v&aacute;lida";
    return 0;
  }elseif(!checkdate($mesSegunda, $diaSegunda, $anyoSegunda)){
    // "La fecha ".$segunda." no es v&aacute;lida";
    return 0;
  }else{ 
    return  ($diasPrimeraJuliano - $diasSegundaJuliano>0);
  } 

}

//mts 27092012. funcÃ­Ã³n booleana que devuelve "Verdadero" si no se han realizado ya 4 reservas en el mes de la reserva actual
// para la ip pasada como argumento (ip de la reserva actual).
function valida_ip($ip_arg)
{
	return true;
    global $inst;   

    $sql1='SELECT count(*) as nregs FROM events WHERE substring(data_reserva,1,10) = "'.date('Y-m-d').'" and INET_NTOA(ip)="'.$ip_arg.'"';           
    $sql2='SELECT count(*) as nregs FROM eventsmadrid WHERE substring(data_reserva,1,10) = "'.date('Y-m-d').'" and INET_NTOA(ip)="'.$ip_arg.'"';  
    $sql3='SELECT count(*) as nregs FROM eventsvalencia WHERE substring(data_reserva,1,10) = "'.date('Y-m-d').'" and INET_NTOA(ip)="'.$ip_arg.'"';
    $sql4='SELECT count(*) as nregs FROM eventsandalucia WHERE substring(data_reserva,1,10) = "'.date('Y-m-d').'" and INET_NTOA(ip)="'.$ip_arg.'"';

    //circuito
	$sql5='SELECT count(*) as nregs FROM eventscircuitoandalucia WHERE substring(data_reserva,1,10) = "'.date('Y-m-d').'" and INET_NTOA(ip)="'.$ip_arg.'"';           
    $sql6='SELECT count(*) as nregs FROM eventscircuitosegovia WHERE substring(data_reserva,1,10) = "'.date('Y-m-d').'" and INET_NTOA(ip)="'.$ip_arg.'"';  
    $sql7='SELECT count(*) as nregs FROM eventscircuitovalencia WHERE substring(data_reserva,1,10) = "'.date('Y-m-d').'" and INET_NTOA(ip)="'.$ip_arg.'"';
    $sql8='SELECT count(*) as nregs FROM eventscircuitozaragoza WHERE substring(data_reserva,1,10) = "'.date('Y-m-d').'" and INET_NTOA(ip)="'.$ip_arg.'"';
    $sql9='SELECT count(*) as nregs FROM eventscircuitovendrell WHERE substring(data_reserva,1,10) = "'.date('Y-m-d').'" and INET_NTOA(ip)="'.$ip_arg.'"';
    $sql10='SELECT count(*) as nregs FROM eventscircuitomoradebre WHERE substring(data_reserva,1,10) = "'.date('Y-m-d').'" and INET_NTOA(ip)="'.$ip_arg.'"';


    $result1=$inst->executeS($sql1);
	$result2=$inst->executeS($sql2);
	$result3=$inst->executeS($sql3);
	$result4=$inst->executeS($sql4);
	$result5=$inst->executeS($sql5);
	$result6=$inst->executeS($sql6);
	$result7=$inst->executeS($sql7);
	$result8=$inst->executeS($sql8);
	$result9=$inst->executeS($sql9);
	$result10=$inst->executeS($sql10);
    
    $row1 = $result1[0];
    $row2 = $result2[0];
    $row3 = $result3[0];
    $row4 = $result4[0];    
    $row5 = $result5[0];
    $row6 = $result6[0];
    $row7 = $result7[0];
    $row8 = $result8[0];
    $row9 = $result9[0];
	$row10 = $result10[0];
	
    if (ceil($row1['nregs'])+ceil($row2['nregs'])+ceil($row3['nregs'])+ceil($row4['nregs'])+ceil($row5['nregs'])+ceil($row6['nregs'])+ceil($row7['nregs'])+ceil($row8['nregs'])+ceil($row9['nregs'])+ceil($row10['nregs'])>=4) return false;
    else return true;
 }

 
 
function valida_codigos2()
{
   	global $inst;
	global $emp;
    
    
    if (trim($_REQUEST['origen']) == 'Ticket Descuento' or trim($_REQUEST['origen']) == 'Ticket Especial' or strtoupper( tools::getValue('codigo_localizador')) == 'A6TO6'  or strtoupper(tools::getValue('codigo_localizador')) == 'OSCE895461') 
    return;
 
    // CASO DOOPLAN
    if(trim($_REQUEST['origen'])=='DOOPLAN' ||  trim($_REQUEST['origen'])=='PLANEO'  || trim($_REQUEST['origen'])=='MOTORCLUBEXPERIENCE'  || trim($_REQUEST['origen'])=='DREAMCARSEXPERIENCE' || trim($_REQUEST['origen'])=='HCCSPORTCARS' || trim($_REQUEST['origen'])=='DAKOTABOX' || trim($_REQUEST['origen'])=='WONDERBOX')      
    {
        $sql='SELECT * FROM events'.$_REQUEST['ciudad'].' WHERE (codi_localtzador="'.trim(tools::getValue('codigo_localizador')).'" )';
    }   
    //mts 18/05/2012.
    else if(trim($_REQUEST['origen'])=='CODIGO_ALFA' )
    {
        //$sql='SELECT * FROM events'.$_REQUEST['ciudad'].' WHERE (codi_localtzador="'.trim(tools::getValue('codigo_localizador')).'" )';
        $sql = 'SELECT * FROM ps_cupones WHERE numero='.trim(tools::getValue('codigo_localizador')).' and vendido = 1 ';
    }       
    //ValidaciÃ³n para todos los casos (cualquier origen distinto de dooplan)
    else 
    {
         $sql1='SELECT * FROM events WHERE (codi_localtzador="'.trim(tools::getValue('codigo_localizador')).'" and codi_consum = "'.trim(tools::getValue('codigo_consumo')).'")';
         $sql2='SELECT * FROM eventsmadrid WHERE (codi_localtzador="'.trim(tools::getValue('codigo_localizador')).'" and codi_consum = "'.trim(tools::getValue('codigo_consumo')).'")';
         $sql3='SELECT * FROM eventsvalencia WHERE (codi_localtzador="'.trim(tools::getValue('codigo_localizador')).'" and codi_consum = "'.trim(tools::getValue('codigo_consumo')).'")';
         $sql4='SELECT * FROM eventsandalucia WHERE (codi_localtzador="'.trim(tools::getValue('codigo_localizador')).'" and codi_consum = "'.trim(tools::getValue('codigo_consumo')).'")';
         $sql5='SELECT * FROM eventscantabria WHERE (codi_localtzador="'.trim(tools::getValue('codigo_localizador')).'" and codi_consum = "'.trim(tools::getValue('codigo_consumo')).'")';         
    }


    $r=canvia_textos_codigo($_REQUEST['origen']);
    
    if (strtoupper( tools::getValue('codigo_localizador')) == 'TEST15' )    
        return('Este cupón estÃ¡ caducado y por lo tanto no puede realizarse la reserva.');
    else{
        if (trim($_REQUEST['origen'])=='GROUPON')
           $cadena_aux='Introduza la letra A delante del código para realizar la reserva ';
        elseif (trim($_REQUEST['origen'])=='CODIGO_ALFA') 
           $cadena_aux = 'Debe activar el cupón antes de poder realizar la reserva';
        //mts 21052012
        elseif (trim($_REQUEST['origen'])=='Ticket descuento'){$cadena_aux='';} 

        else 
        {
			$cadena_aux='El '.$r[0].' o el '.$r[1].' ya se encuentran registrados. Póngase en contacto a través del <a style="color:#fff" href="'._BASE_URL_.'contact-form.php#contactform">formulario de contacto</a> para consultar la incidencia ';
			if($r[1]==$r[0])$cadena_aux='El '.$r[0].' ya se encuentra registrado. Póngase en contacto a través del <a style="color:#fff" href="'._BASE_URL_.'contact-form.php#contactform">formulario de contacto</a> para consultar la incidencia ';         
		}
    }

   
    if(trim($_REQUEST['origen'])=='DOOPLAN'  || trim($_REQUEST['origen'])=='PLANEO'  || trim($_REQUEST['origen'])=='MOTORCLUBEXPERIENCE'  || trim($_REQUEST['origen'])=='DREAMCARSEXPERIENCE' || trim($_REQUEST['origen'])=='HCCSPORTCARS' || trim($_REQUEST['origen'])=='DAKOTABOX' || trim($_REQUEST['origen'])=='WONDERBOX')
    {
    $result=$inst->executeS($sql);
    
    if(count($result)!=0)
    { 
      $sql2='SELECT * FROM events'.$_REQUEST['ciudad'].' e,limbo l WHERE e.id=l.id_evento and l.ciudad_evento = \''.$_REQUEST['ciudad'].'\' and (codi_localtzador="'.trim(tools::getValue('codigo_localizador')).'" ) limit 1,1 ';
      $result2=$inst->executeS($sql2);
      if(count($result2)!=0)
      { 
      	$r2=$result2[0];
      	//si hay un resitro de limbo devolveremos si está marcado o no, para aplicar ese mismo criterio
      	//en la nueva reserva.
      	if ($r2) 
      	{
      		$cadena_aux = 'limbo#'.$r['marcat'].'#'.$r['id'];
      		return $cadena_aux;
      	}
      	//si no hay registro de limbo devolveremos la cadena de errores inicial.
      	else return $cadena_aux;
      	
      }
      else   return $cadena_aux;
    }// si no hi ha cap inscrit
        
    }
    //mts 18052012.
    else if (trim($_REQUEST['origen']) == 'CODIGO_ALFA')
    {
    $result=$inst->executeS($sql);
    
    if(count($result)==0)
	{ 
      return $cadena_aux;
    }
    } 
    else{

    $result1=$inst->executeS($sql1);
	$result2=$inst->executeS($sql2);
	$result3=$inst->executeS($sql3);
	$result4=$inst->executeS($sql4);
    
    if(count($result1)!=0 or count($result2)!=0  or count($result3)!=0 or count($result4)!=0 ){
    	{ 
    		//Si los códigos existen haremos una segunda comprobación para ver si se encuentran en el limbo.
	        $sql1='SELECT * FROM limbo l,events e WHERE l.id_evento=e.id and l.ciudad_evento=\'\' and (codi_localtzador="'.trim(tools::getValue('codigo_localizador')).'" and codi_consum = "'.trim(tools::getValue('codigo_consumo')).'")';     
	        $sql2='SELECT * FROM limbo l,eventsmadrid e WHERE l.id_evento=e.id and l.ciudad_evento=\'madrid\' and (codi_localtzador="'.trim(tools::getValue('codigo_localizador')).'" and codi_consum = "'.trim(tools::getValue('codigo_consumo')).'")';     
	        $sql3='SELECT * FROM limbo l,eventsvalencia e WHERE l.id_evento=e.id and l.ciudad_evento=\'valencia\' and (codi_localtzador="'.trim(tools::getValue('codigo_localizador')).'" and codi_consum = "'.trim(tools::getValue('codigo_consumo')).'")';     
	        $sql4='SELECT * FROM limbo l,eventsandalucia e WHERE l.id_evento=e.id and l.ciudad_evento=\'analucia\' and (codi_localtzador="'.trim(tools::getValue('codigo_localizador')).'" and codi_consum = "'.trim(tools::getValue('codigo_consumo')).'")';     
	        $sql5='SELECT * FROM limbo l,eventscantabria e WHERE l.id_evento=e.id and l.ciudad_evento=\'cantabria\' and (codi_localtzador="'.trim(tools::getValue('codigo_localizador')).'" and codi_consum = "'.trim(tools::getValue('codigo_consumo')).'")';     

	        $sql6='SELECT * FROM limbo l,eventscircuitoandalucia e WHERE l.id_evento=e.id and l.ciudad_evento=\'circuitoandalucia\' and (codi_localtzador="'.trim(tools::getValue('codigo_localizador')).'")';     
	        $sql7='SELECT * FROM limbo l,eventscircuitosegovia e WHERE l.id_evento=e.id and l.ciudad_evento=\'circuitosegovia\' and (codi_localtzador="'.trim(tools::getValue('codigo_localizador')).'")';     
	        $sql8='SELECT * FROM limbo l,eventscircuitozaragoza e WHERE l.id_evento=e.id and l.ciudad_evento=\'circuitozaragoza\' and (codi_localtzador="'.trim(tools::getValue('codigo_localizador')).'")';     
	        $sql9='SELECT * FROM limbo l,eventscircuitovalencia e WHERE l.id_evento=e.id and l.ciudad_evento=\'circuitovalencia\' and (codi_localtzador="'.trim(tools::getValue('codigo_localizador')).'")';     
	        $sql10='SELECT * FROM limbo l,eventscircuitovendrell e WHERE l.id_evento=e.id and l.ciudad_evento=\'circuitovendrell\' and (codi_localtzador="'.trim(tools::getValue('codigo_localizador')).'")';     
	        $sql11='SELECT * FROM limbo l,eventscircuitomoradebre e WHERE l.id_evento=e.id and l.ciudad_evento=\'circuitomoradebre\' and (codi_localtzador="'.trim(tools::getValue('codigo_localizador')).'")';     


	        
	        $result1=$inst->executeS($sql1);
		    $result2=$inst->executeS($sql2);
		    $result3=$inst->executeS($sql3);
		    $result4=$inst->executeS($sql4);
		    $result5=$inst->executeS($sql5);
		    $result6=$inst->executeS($sql6);
		    $result7=$inst->executeS($sql7);
		    $result8=$inst->executeS($sql8);
		    $result9=$inst->executeS($sql9);
		    $result10=$inst->executeS($sql10);
		    $result11=$inst->executeS($sql11);

    		if(count($result1)!=0 or count($result2)!=0  or count($result3)!=0 or count($result4)!=0  or count($result5)!=0 or count($result6)!=0 or count($result7)!=0 or count($result8)!=0 or count($result9)!=0 or count($result10)!=0 or count($result11)!=0)
    		{  
      			if (count($result1)!=0)
      			{
 					$r=$result1[0];
      			}
      			else if (count($result2)!=0)
      			{
 					$r=$result2[0];
      			}
      			else if (count($result3)!=0)
      			{
 					$r=$result3[0];
      			}
    		    else if (count($result4)!=0)
      			{
 					$r=$result4[0];
      			}
    		    else if (count($result5)!=0)
      			{
 					$r=$result5[0];
      			}
    		    else if (count($result6)!=0)
      			{
 					$r=$result6[0];
      			}
    		    else if (count($result7)!=0)
      			{
 					$r=$result7[0];
      			}
    		    else if (count($result8)!=0)
      			{
 					$r=$result8[0];
      			}
    		    else if (count($result9)!=0)
      			{
 					$r=$result9[0];
      			}
    		    else if (count($result10)!=0)
      			{
 					$r=$result10[0];
      			}
    		    else if (count($result11)!=0)
      			{
 					$r=$result11[0];
      			}
      			
      			if ($r)
      			{
		      		$cadena_aux = 'limbo#'.$r['marcat'].'#'.$r['id'];
		      		return $cadena_aux;
      			}
      			else return $cadena_aux;     
    		}
    		else 
    		{
      			return $cadena_aux;    			
    		}
    	}
     }// si no hi ha cap inscrit
   //return $sql;
    }
   
}
    
 
 function valida_codigos()
   {
    global $inst;
	global $emp;
	
    if (trim($_REQUEST['origen']) == 'Ticket Descuento' or trim($_REQUEST['origen']) == 'Ticket Especial' or strtoupper( tools::getValue('codigo_localizador')) == 'A6TO6'  or strtoupper(tools::getValue('codigo_localizador')) == 'OSCE895461') 
    return array('','');
 
    // CASO DOOPLAN
    if(trim($_REQUEST['origen'])=='DOOPLAN'  || trim($_REQUEST['origen'])=='PLANEO'  || trim($_REQUEST['origen'])=='MOTORCLUBEXPERIENCE'  || trim($_REQUEST['origen'])=='DREAMCARSEXPERIENCE' || trim($_REQUEST['origen'])=='HCCSPORTCARS' || trim($_REQUEST['origen'])=='DAKOTABOX'  || trim($_REQUEST['origen'])=='WONDERBOX')
    {
        $sql='SELECT * FROM events'.$_REQUEST['ciudad'].' WHERE (codi_localtzador="'.trim(tools::getValue('codigo_localizador')).'" )';                                      
		
    }   
    //mts 18/05/2012.
    else if(trim($_REQUEST['origen'])=='CODIGO_ALFA' )
    {
        $sql = 'SELECT * FROM ps_cupones WHERE numero='.trim(tools::getValue('codigo_localizador')).' and vendido = 1 ';
    }       
    //ValidaciÃ³n para todos los casos (cualquier origen distinto de dooplan)
    else 
	
	
         $sql1='SELECT * FROM events WHERE (codi_localtzador="'.trim(tools::getValue('codigo_localizador')).'" and codi_consum = "'.trim(tools::getValue('codigo_consumo')).'")';
         $sql2='SELECT * FROM eventsmadrid WHERE (codi_localtzador="'.trim(tools::getValue('codigo_localizador')).'" and codi_consum = "'.trim(tools::getValue('codigo_consumo')).'")';
         $sql3='SELECT * FROM eventsvalencia WHERE (codi_localtzador="'.trim(tools::getValue('codigo_localizador')).'" and codi_consum = "'.trim(tools::getValue('codigo_consumo')).'")';
         $sql4='SELECT * FROM eventsandalucia WHERE (codi_localtzador="'.trim(tools::getValue('codigo_localizador')).'" and codi_consum = "'.trim(tools::getValue('codigo_consumo')).'")';
         $sql5='SELECT * FROM eventscantabria WHERE (codi_localtzador="'.trim(tools::getValue('codigo_localizador')).'" and codi_consum = "'.trim(tools::getValue('codigo_consumo')).'")';         
		
	
    {

		 	if (tools::GetUserIp()=='83.231.111.3')
			{
				//echo($sql2);
			}


		/* fin modif. mts. */ 
    }


    $r=canvia_textos_codigo($_REQUEST['origen']);
    
    if (strtoupper( tools::getValue('codigo_localizador')) == 'TEST15' )    
        return(array('','Este cupÃ³n estÃ¡ caducado y por lo tanto no puede realizarse la reserva.'));
    else
	{
        if (trim($_REQUEST['origen'])=='GROUPON')  
		{
           $cadena_aux='Introduza la letra A delante del cÃ³digo para realizar la reserva ';
		}   
        elseif (trim($_REQUEST['origen'])=='CODIGO_ALFA') 
		{
           $cadena_aux = 'Debe activar el cupÃ³n antes de poder realizar la reserva';
		}   
        //mts 21052012
        elseif (trim($_REQUEST['origen'])=='Ticket descuento')
		{
			$cadena_aux='';
		} 
        else 
        {
			$cadena_aux='El '.$r[0].' o el '.$r[1].' ya se encuentran registrados. Póngase en contacto a través del <a style="color:#fff" href="'._BASE_URL_.'contact-form.php#contactform">formulario de contacto</a> para consultar la incidencia ';    
			if($r[1]==$r[0])$cadena_aux='El '.$r[0].' ya se encuentra registrado. Póngase en contacto a través del <a style="color:#fff" href="'._BASE_URL_.'contact-form.php#contactform">formulario de contacto</a> para consultar la incidencia ';             
        }    
    }

	

   
    if(trim($_REQUEST['origen'])=='DOOPLAN' ||trim($_REQUEST['origen'])=='PLANEO' || trim($_REQUEST['origen'])=='MOTORCLUBEXPERIENCE'  || trim($_REQUEST['origen'])=='DREAMCARSEXPERIENCE' || trim($_REQUEST['origen'])=='HCCSPORTCARS' || trim($_REQUEST['origen'])=='DAKOTABOX' || trim($_REQUEST['origen'])=='WONDERBOX') 
    {
    $result=$inst->executeS($sql); 
    
    if(count($result)!=0)
    { 
      $sql2='SELECT * FROM events'.$_REQUEST['ciudad'].' e,limbo l WHERE e.id=l.id_evento and l.ciudad_evento = \''.$_REQUEST['ciudad'].'\' and (codi_localtzador="'.trim(tools::getValue('codigo_localizador')).'" ) limit 1,1 ';


      $result2=$inst->executeS($sql2); 
      if(count($result2)!=0)
      { 
      	$r2=$result2[0];

      	if ($r2) 
      	{
      		$cadena_aux2 = 'limbo#'.$r['marcat'].'#'.$r['id'];
      		return (array($cadena_aux2,$cadena_aux));
      	}
      	//si no hay registro de limbo devolveremos la cadena de errores inicial.
      	else 
		{
			return (array('',$cadena_aux));
		}
      	
      }
      else   
	  {
		return (array('',$cadena_aux));
		
	  }
    }// si no hi ha cap inscrit
        
    }
    //mts 18052012.
    else if (trim($_REQUEST['origen']) == 'CODIGO_ALFA')
    {
    $result=$inst->executeS($sql); 
    
    if(count($result)==0){ 
      return (array('',$cadena_aux));
     }
    } 
    else
	{
	
	if (tools::GetUserIp()=='83.231.111.3')
	{
	}


    $result1=$inst->executeS($sql1); 
    $result2=$inst->executeS($sql2); 
    $result3=$inst->executeS($sql3); 
    $result4=$inst->executeS($sql4); 
    $result5=$inst->executeS($sql5); 
    
    if(count($result1)!=0 or count($result2)!=0  or count($result3)!=0 or count($result4)!=0 or count($result5)!=0 )
	{
    	{ 
			//Si los códigos existen haremos una segunda comprobación para ver si se encuentran en el limbo.
	        $sql1='SELECT * FROM limbo l,events e WHERE l.id_evento=e.id and l.ciudad_evento=\'\' and      	        
			(codi_localtzador="'.trim(tools::getValue('codigo_localizador')).'" OR concat("A",codi_localtzador)="'.trim(tools::getValue('codigo_localizador')).'" OR concat("AA",codi_localtzador)="'.trim(tools::getValue('codigo_localizador')).'")   
			and 
			(codi_consum="'.trim(tools::getValue('codigo_consumo')).'" OR concat("A",codi_consum)="'.trim(tools::getValue('codigo_consumo')).'" OR concat("AA",codi_consum)="'.trim(tools::getValue('codigo_consumo')).'")';
			
	        $sql2='SELECT * FROM limbo l,eventsmadrid e WHERE l.id_evento=e.id and l.ciudad_evento=\'madrid\' and      	        
			(codi_localtzador="'.trim(tools::getValue('codigo_localizador')).'" OR concat("A",codi_localtzador)="'.trim(tools::getValue('codigo_localizador')).'" OR concat("AA",codi_localtzador)="'.trim(tools::getValue('codigo_localizador')).'")
			and 
			(codi_consum="'.trim(tools::getValue('codigo_consumo')).'" OR concat("A",codi_consum)="'.trim(tools::getValue('codigo_consumo')).'" OR concat("AA",codi_consum)="'.trim(tools::getValue('codigo_consumo')).'")';
			
	        $sql3='SELECT * FROM limbo l,eventsvalencia e WHERE l.id_evento=e.id and l.ciudad_evento=\'valencia\' and      	        
			(codi_localtzador="'.trim(tools::getValue('codigo_localizador')).'" OR concat("A",codi_localtzador)="'.trim(tools::getValue('codigo_localizador')).'" OR concat("AA",codi_localtzador)="'.trim(tools::getValue('codigo_localizador')).'")
			and 
			(codi_consum="'.trim(tools::getValue('codigo_consumo')).'" OR concat("A",codi_consum)="'.trim(tools::getValue('codigo_consumo')).'" OR concat("AA",codi_consum)="'.trim(tools::getValue('codigo_consumo')).'")';

	        $sql4='SELECT * FROM limbo l,eventsandalucia e WHERE l.id_evento=e.id and l.ciudad_evento=\'andalucia\' and      	        
			(codi_localtzador="'.trim(tools::getValue('codigo_localizador')).'" OR concat("A",codi_localtzador)="'.trim(tools::getValue('codigo_localizador')).'" OR concat("AA",codi_localtzador)="'.trim(tools::getValue('codigo_localizador')).'")
			and 
			(codi_consum="'.trim(tools::getValue('codigo_consumo')).'" OR concat("A",codi_consum)="'.trim(tools::getValue('codigo_consumo')).'" OR concat("AA",codi_consum)="'.trim(tools::getValue('codigo_consumo')).'")';
			
	        $sql5='SELECT * FROM limbo l,eventcantabria e WHERE l.id_evento=e.id and l.ciudad_evento=\'cantabria\' and      	        
			(codi_localtzador="'.trim(tools::getValue('codigo_localizador')).'" OR concat("A",codi_localtzador)="'.trim(tools::getValue('codigo_localizador')).'" OR concat("AA",codi_localtzador)="'.trim(tools::getValue('codigo_localizador')).'")
			and 
			(codi_consum="'.trim(tools::getValue('codigo_consumo')).'" OR concat("A",codi_consum)="'.trim(tools::getValue('codigo_consumo')).'" OR concat("AA",codi_consum)="'.trim(tools::getValue('codigo_consumo')).'")';         
			
	       
			
			$result1=$inst->executeS($sql1);
		    $result2=$inst->executeS($sql2);
		    $result3=$inst->executeS($sql3);
		    $result4=$inst->executeS($sql4);
		    $result5=$inst->executeS($sql5);

    		
			if (tools::GetUserIp()=='83.231.111.3')
			{
			}
			
			if(count($result1)!=0 or count($result2)!=0  or count($result3)!=0 or count($result4)!=0 or count($result5)!=0)              
    		{  
			
				if (tools::GetUserIp()=='83.231.111.3')
				{
				
				}

      			if (count($result1)!=0)
      			{
 					$r=$result1[0];
      			}
      			else if (count($result2)!=0)
      			{
 					$r=$result2[0];
      			}
      			else if (count($result3)!=0)
      			{
 					$r=$result3[0];  
      			}
    		    else if (count($result4)!=0)   
      			{
 					$r=$result4[0];
      			}
    		    else if (count($result5)!=0)
      			{
 					$r=$result5[0];
      			}
      			
      			if ($r)
      			{
		      		$cadena_aux2 = 'limbo#'.$r['marcat'].'#'.$r['id'];                    
					
					$res=array($cadena_aux2,$cadena_aux);
					
		      		return ($res);
      			}
      			else return (array('',$cadena_aux));     
    		}
    		else 
    		{
      			return (array('',$cadena_aux));    			
    		}
    	}
     }// si no hi ha cap inscrit
	 //return $cadena_aux;
   //return $sql;
    }
   
}
   
   
function canvia_textos_codigo($origen)
{
  
  $r=array();
  switch($origen)
   {
   	case 'LETS BONUS':
	$r[0]='Localizador';
	$r[1]='Codigo consumo';
	break;
	case 'GROUPALIA':
	$r[0]='Numero de vale';
	$r[1]='NumeraciÃ³n codigo de barras completo ';
	break;
	case 'OFFERUM':
	$r[0]='CÃ³digo del bono';
	$r[1]='CÃ³digo de validaciÃ³n';
	break;
	case 'ATRAPALO':
	$r[0]='NÃºmero de vale';
	$r[1]='CÃ³digo de reserva';
	break;
	case 'OFERTIX':
	$r[0]='CÃ³digo reserva';
	$r[1]='CÃ³digo de validaciÃ³n';
	break;
	case 'DOOPLAN':
	$r[0]='CÃ³digo ';
	$r[1]='CÃ³digo ';
	break;
	case 'LA_TIENDA_MARCA':
	$r[0]='NÃºmero de pedido ';
	$r[1]='CÃ³digo ';
	break;
	case 'DISFRUTALO':
	$r[0]='Localizador';
	$r[1]='Codigo consumo';
	break;
	case 'COLECTIVIA':
	$r[0]='CÃ³digo de identificaciÃ³n';
	$r[1]='CÃ³digo de seguridad';
	break;
	case 'DAKOTABOX':
	$r[0]='CÃ³digo de barras del cheque';
	//$r[1]='CÃ³digo de validaciÃ³n';
	$r[1]='';
	break;
	case 'SMARTBOX':
	$r[0]='Localizador';
	$r[1]='Codigo consumo';
	break;
	case 'WONDERBOX':
	$r[0]='Localizador';
	$r[1]='';
	break;


    case 'CODIGO_ALFA':
    $r[0]='CÃ³digo ';
    $r[1]='CÃ³digo ';
    break;

	default:
	$r[0]='Localizador';
	$r[1]='Codigo consumo';
	break;
   }
   return $r;		
}   

  
function return_tipus_e($t,$km)
  {
    
  $fin_texto_vehiculo=strpos($t,'_');
  $t2=substr($t,$fin_texto_vehiculo+1);
  if (strpos($t,'ruta_turistica')!==false) 
	return(descripcion_ruta_turistica($t2));

	//return(descripcion_ruta_turistica($t));

  switch($t)
  {
		case 'ferrari':
			return 'Ferrari 430 '.$km.' Km ';
			break;		
		case 'lamborghini':
			return 'Lamborghini '.$km.' Km ';
			break;		
		case 'porsche':
			return 'Porsche '.$km.' Km ';
			break;		
		case 'corvette':
			return 'Corvette  '.$km.' Km ';
			break;		

  default:
	return $t;  
  
   /*case 'ferrari':
   	    if ($km==40)
			return 'Ferrari 430 40 Km   ';
		else if($km==20)
			return 'Ferrari 430 20 Km   ';
		else 
			return 'Ferrari';
   break;		
   //Bautismos. 
   case '_bferrari_':
        if ($km==14)
			return 'Ferrari 430 14 Km   ';
		else
			return 'Ferrari 430 7 Km   ';
   break;       

   case '_blamborghini_':
        if ($km==14)
         return 'Lamborghini 14 Km';
		else
         return 'Lamborghini 7 Km';
		
   break;       
   case '_bporsche_':
        if ($km==14)
         return 'Porsche 14 Km';
		else
         return 'Porsche 7 Km';
   
         //return 'Porche 7 Km';
   break;       
   case '_bcorvette_':
        if ($km==14)
         return 'Corvette 14 Km';
		else
         return 'Corvette 7 Km';
   //Fin Bautismos
   case 'ferrari_porsche901':
   	    return 'Ferrari  20 Km  + Porsche  20 Km   ';
   break;	
   case 'lamborghini':
		if ($km==40)
         return 'Lamborghini 40 Km';
		else if ($km==20)
         return 'Lamborghini 20 Km';
		else 
		 return 'Lamborghini';
   break;		
   case 'lamborghini_lotus':
         //return 'Lamborghini 20 Km  + Lotus Evora 20 Km ';
   return 'Lamborghini 20 Km  + Porsche 20 Km ';
   break;		
   case 'porsche997_porsche996':
		return 'Porsche Turbo 20 Km +  Porsche Carrera S 20 Km ';		 
   break;	
   case '_corvette_':
		if ($km==40)
         return 'Corvette 40 Km';
		else if ($km==20)
         return 'Corvette 20 Km';
		else 
		 return 'Corvette';
   break;		
   case 'porsche996':    
		if ($km==40)
         return 'Porsche 40 Km';
		else if ($km==20)
         return 'Porsche 20 Km';
		else 
		 return 'Porsche';
   
//		return 'Porsche 20 Km ';		     
   break;
   case 'porsche997':
		if ($km==40)
         return 'Porsche 40 Km';
		else if ($km==20)
         return 'Porsche 20 Km';
		else 
		 return 'Porsche';
   
		//return 'Porsche 20 Km ';		 
   break;
   case '_porsche_':
   		if ($km==40)
         return 'Porsche 40 Km';
		else if ($km==20)
         return 'Porsche 20 Km';
		else 
		 return 'Porsche';

		//return 'Porsche 20Km ';		 
   break;			
  default:
	return $t;
	*/
  }	
  }  

function convert_caracters_hex($cad)
  {
 
  $cad=str_replace('Ã³', '&#243;', $cad);	
  $cad=str_replace('Ã©', '&#233;', $cad);		
  $cad=str_replace('Ã±', '&#241;', $cad);	
  $cad=str_replace('Ãº', '&#250;', $cad);	
  $cad=str_replace('Ã¡', '&#225;', $cad);		
  $cad=str_replace('Ã­', '&#237;', $cad);
  $cad=str_replace('Ã§', '&#231;', $cad);
  $cad=str_replace('Ã²', '&#242;', $cad);	
  $cad=str_replace('Ã¨', '&#232;', $cad);		
  $cad=str_replace('Ã¹', '&#249;', $cad);	
  $cad=str_replace('Ã ', '&#224;', $cad);		
  $cad=str_replace('Ã¬', '&#236;', $cad);
  $cad=str_replace('Ã±', '&#241;', $cad);
  return $cad;
  }  
  
  
   
  
function generar_pdf_confirm_reserva(&$nombre_fichero,$empresa)
{    
	global $Observaciones;
	$ciudad=$_REQUEST['ciudad'];             
	$pciudad=$ciudad;	
	if(trim($ciudad)=='')$ciudad='Barcelona';        
	$ciudad=strtoupper($ciudad);        
	
	$url_base = _BASE_URL_;
	$imagen_fondo = FONDO_CONFIRMACION_RESERVA;
	
    $aux=explode('@',tools::getValue('id_alta'));
		
	if($tipus!='porsche997' && $tipus!='porsche996')
	{
		  $h=explode(':',$aux[1]);
		  if($h[1]=='00' || $h[1]=='15')
		  {
			$aux[1]=$h[0].':00:00';
		  }
		  else if($h[1]=='30' || $h[1]=='45')
		  {
			$aux[1]=$h[0].':30:00';
		  }
	}
	

	
	$id_alta = tools::getValue('id_alta');                                                                                                             
	$email=tools::getValue('email');
	
	$sql= ' select count(*) numregs from events'.$pciudad.' where id_event=\''.$id_alta.'\' and email = \''.$email.'\'';	
	
	$existeEvento=Db::getInstanceOf()->executeS($sql);                                                               
	$existeEvento=intval($existeEvento[0]['numregs']);                        

	if (!$existeEvento)
	{
		die('error al guardar en la base de datos. Por favor, inténtelo más tarde.');
	}
	
	
	
    $fecha_reserva=tools::getValue('fecha_reserva');  
    $ip=tools::getValue('ip');     
	$origen=tools::getValue('origen');     
	
	$piloto=convert_caracters_hex(tools::getValue('pilot'));
	$apellidos_piloto=convert_caracters_hex(tools::getValue('apellidos_piloto'));
	
	$telefono=tools::getValue('telefon');
	$dia=$aux[0];
	$hora=$aux[1];
	//echo(substr(tools::getValue('tipus'),0,strpos(tools::getValue('tipus'),'_')-1));
	$tipo=return_tipus_e(tools::getValue('tipo_vehiculo'),tools::getValue('km_ruta'));
	if (tools::getValue('circuito')==1)
	{	
		$tipo='Fórmula';
		$tipo.=' ('.tools::getValue('num_vueltas').' vueltas)';
	}

	
	$persona_regala=convert_caracters_hex(tools::getValue('persona_regala'));             
	$apellidos_persona_regala=convert_caracters_hex(tools::getValue('apellidos_persona_regala'));                       
	$nif_regala = convert_caracters_hex(tools::getValue('nif'));              
	$email_regala= tools::getValue('email_regala');
	$telefono_regala=tools::getValue('telefon_regala');
	$localizador= tools::getValue('codigo_localizador');
	$consumo= '';
	//$textos_codigos = canvia_textos_codigo(tools::getValue('origen'));
	//$texto_localizador = utf8_decode($textos_codigos[0]);
	$texto_localizador='Localizador';
	if (!in_array(tools::getValue('origen'),array('CODIGO_ALFA','DOOPLAN','LA_TIENDA_MARCA','PLANEO','MOTORCLUBEXPERIENCE','DREAMCARSEXPERIENCE','HCCSPORTCARS','DAKOTABOX','WONDERBOX')))
	{
		$consumo = tools::getValue('codigo_consumo');
		//$texto_consumo = utf8_decode($textos_codigos[1]);
		$texto_consumo='Consumo';
	}
		
	 	
		//$ciudad= $ciudad;
	$ciudad_visible = $ciudad;
	if (tools::getValue('circuito')==1)
	{
		$ctmp=explode('CIRCUITO',$ciudad_visible);
		$ciudad_visible=$ctmp[0].' '.$ctmp[1]; 
	}
	
	if ($ciudad=='RUTAS_TURISTICAS')
	{
			$ciudad_visible=ciudad_ruta(tools::getValue('tipus'));
	}
	
	
	/*
	$Observaciones1 = $Observaciones;
	$Observaciones1 = trim($Observaciones1);

	if (in_array(tools::getValue('km'),array(14,40)))
	{
		if (substr($Observaciones1,-1)!='-')	
			$Observaciones1 .= ' - ruta de ' . tools::getValue('km_ruta') . ' km. ';
		else $Observaciones1 .= ' ruta de ' . tools::getValue('km_ruta') . ' km. ';
			
	}	
	
	$observaciones = convert_caracters_hex($Observaciones1);
	*/
	
	

	$ancho_principal=700;
	$ancho_tabla_cuadro = 334;
	$ancho_cuadro = 334;
	$alto_tabla_cuadro = 150;
	$alto_cuadro = 100;
	$alto_cuadro2 = 70;
	$ancho_pestana1=250;
	$ancho_pestana2=580;
	$ancho_pestana3=145;
	$fuente_general=11;
	
	
    try 
    { 
	
	$cad = '
	<style>
	.borde_cuadro
	{
		border: 1px solid #CCCCCC;
	}
	.borde_pestana
	{
		border: 1px solid #CCCCCC;
		border-bottom:none;
	}
	.importante
	{
		color:#ff0000;
	}
	.tabla_cuadro_principal
	{
		width:'.$ancho_principal.'px;
		font-size:'.$fuente_general.'px;
		margin-top:15px;
		margin-left:20px;
	}
	.cuadro_principal
	{
		width:'.$ancho_principal.'px;
		border-spacing:0;
		padding-top:12px;
		//padding-left:10px;
	}
	.tabla_cuadro_menor
	{
		width:'.$ancho_tabla_cuadro.'px;
		height:'.$alto_tabla_cuadro.'px;
		border-spacing:0;
		padding-top:12px;
	}
	.cuadro_menor
	{
		//width:'.$ancho_cuadro.'px;
		height:'.$alto_cuadro.'px;
		box-shadow: 10px 10px 5px #888888;
		
	}

	.cuadro_menor_inferior
	{
		width:'.$ancho_cuadro.'px;
		height:'.$alto_cuadro2.'px;
	}
	.pestana1
	{
		width:'.$ancho_pestana1.'px;
		height:20px;
		vertical-align:middle;
	}
	.pestana1_resto
	{
		width:'.($ancho_cuadro-$ancho_pestana1).'px;
	}
	.pestana2
	{
		width:'.$ancho_pestana2.'px;
		height:20px;
		vertical-align:middle;		
	}
	.pestana2_resto
	{
		width:'.($ancho_principal-$ancho_pestana2).'px;
	}
	.pestana3
	{
		width:'.$ancho_pestana3.'px;
		height:20px;
		vertical-align:middle;	
	}
	.pestana3_resto
	{
		width:'.($ancho_principal-$ancho_pestana3).'px;
	}

	div.lista_confirm span,div.datos_persona,div.lista_confirm p
	{
		margin:0;
		text-indent:0;
		text-align:left;

	}
	div.lista_confirm p
	{
		padding:5px;
	}
	div.lista_confirm span
	{
		padding: 5px !important;
	}

	div.lista_confirm p.circuito
	{
		padding:2px;
	}

	div.lista_confirm span.circuito
	{
		padding: 2px !important;
	}
	
	#condiciones p{margin-bottom:1px;padding:5px;}
	
	div.datos_pestana
	{
		padding:5px;
	}
	</style> ';
	


			
	
				  
				  
	/** cuadro superior izquierdo **/
				  
	$cuadro1 = 		
	'<table class="tabla_cuadro_menor" cellspacing="0" cellpadding="0">
	  <tr>
		<td class="pestana1 borde_pestana">
			<div class="datos_pestana">
				<strong>Datos del piloto registrados por el usuario </strong>
			</div>
		</td>
		<td class="pestana1_resto">
		</td>
	  </tr>
	  <tr>
		<td colspan="2" class="cuadro_menor borde_cuadro">
			<div class="lista_confirm">
				<p>
					<span style="font-weight:bold;">Evento:</span> <span>'.$tipo.'</span>
				</p>	
				<p>
					<span style="font-weight:bold;">Ciudad:</span> <span>'.$ciudad_visible.'</span>
				</p>	
				<p>
					<span style="font-weight:bold;">DÃ­a de la experiencia:</span> <span>'.implode('/',array_reverse(explode('-',$dia))).'</span>
				</p>	
				<p>
					<span style="font-weight:bold;">Hora escogida:</span> <span>'.$hora.'</span>
				</p>	
				<p>
					<span style="font-weight:bold;">Nombre:</span> <span>'.$piloto.' '.$apellidos_piloto.'</span>
				</p>	
				<p>
					<span style="font-weight:bold;">TelÃ©fono:</span> <span>'.$telefono.'</span>
				</p>	
				<p>
					<span style="font-weight:bold;">Email:</span> <span>'.$email.'</span>
				</p>	
			</div>							
		</td>
	  </tr>
	 </table>';

	/** cuadro superior derecho **/
	$cuadro2 ='
  	<table class="tabla_cuadro_menor" cellspacing="0" cellpadding="0" style="margin-left:20px;">
	  <tr>
		<td class="pestana1 borde_pestana">
			<div class="datos_pestana">
				<strong>Datos de la persona que regala </strong>
			</div>
		</td>
		<td class="pestana1_resto">
		</td>
	  </tr>
	  <tr>
		<td colspan="2"  class="cuadro_menor borde_cuadro">
			<div class="lista_confirm">
				<p>
					<span style="font-weight:bold;">Nombre:</span> <span>'.$persona_regala.'</span>
				</p>	
				<p>
					<span style="font-weight:bold;">Apellidos:</span> <span>'.$apellidos_persona_regala.'</span>
				</p>	
				<p>
					<span style="font-weight:bold;">TelÃ©fono:</span> <span>'.$telefono_regala.'</span>
				</p>	
				<p>
					<span style="font-weight:bold;">Dni/Nie:</span> <span>'.$nif_regala.'</span>
				</p>	
				<p>
					<span style="font-weight:bold;">Email:</span> <span>'.$email_regala.'</span>
				</p>	
				<p>
				&nbsp;
				</p>	
				<p>
				&nbsp;
				</p>	
			</div>							
		</td>
	  </tr>
	 </table>';
		
	/** cuadro inferior izquierdo **/
	$cuadro3='
	<table class="tabla_cuadro_menor" cellspacing="0" cellpadding="0">
	  <tr>
		<td class="pestana1 borde_pestana">
			<div class="datos_pestana">
				<strong>Datos de registro introducidos por el usuario </strong>
			</div>
		</td>
		<td class="pestana1_resto">
		</td>
	  </tr>
	  <tr>
		<td colspan="2"  class="cuadro_menor borde_cuadro">
			<div class="lista_confirm">
				<p>
					<span style="font-weight:bold;">Fecha de registro:</span> <span>'.implode('/',array_reverse(explode('-',substr($fecha_reserva,0,10)))).' a las '.substr($fecha_reserva,11).'</span>
				</p>	
				<p>
					<span style="font-weight:bold;">DirecciÃ³n IP:</span> <span>'.$ip.'</span>
				</p>	
				<p>
					<span style="font-weight:bold;">Origen del cupÃ³n:</span> <span>'.$origen.'</span>
				</p>	
				<p>
					<span style="font-weight:bold;">'.$texto_localizador.':</span> <span>'.$localizador.'</span>
				</p>	';
			if ($consumo!='')
			$cuadro3 .= '
				<p>
					<span style="font-weight:bold;">'.$texto_consumo.':</span> <span>'.$consumo.'</span>
				</p>';	
	$cuadro3 .=						'	
			</div>							
		</td>
	  </tr>
	 </table>';	

	 /** cuadro inferior derecho **/
	$cuadro4='
	<table class="tabla_cuadro_menor" cellspacing="0" cellpadding="0" style="margin-left:20px;">
	  <tr>
		<td class="pestana1 borde_pestana">
			<div class="datos_pestana">
				<strong>Observaciones </strong>
			</div>	
		</td>
		<td class="pestana1_resto">
		</td>
	  </tr>
	  <tr>
		<td colspan="2" class="cuadro_menor borde_cuadro">
			<div class="lista_confirm">
				<p>
					<span>'.$Observaciones.'</span>
				</p>	
			</div>							
		</td>
	  </tr>
	</table>';
 

	
	
   /** Texto de marcos inferiores **/

	$texto_condiciones = 
	'<p>
		<strong>Su reserva ha sido realizada tal y como nos ha indicado y registrado en nuestro sistema</strong>, revise todos sus datos de contacto, fecha y hora del evento y ciudad escogida. En caso de haber escogido alguna opciÃ³n incorrecta o existe algÃºn telÃ©fono o email incorrecto contacte a '.EMAIL_INFO.' para rectificar y recibir la nueva confirmación de reserva correctamente. (el sistema de reservas Ãºnicamente registra los datos que usted nos a indicado por lo que no tiene ninguna validez sin no va acompaÃ±ado del cupÃ³n comprado)
	</p>
	<p>
		<strong>Recuerde que la hora que le asignamos es aproximada</strong>, pero debe presentarse 30 minutos antes de la hora solicitada para entregar la documentaciÃ³n. <span class="importante">Es muy importante presentar esta confirmaciÃ³n junto con el cupÃ³n comprado, fotocopia del DNI y fotocopia del carnet de conducir en nuestras instalaciones. En caso de no presentar dicha documentaciÃ³n no se podrÃ¡ realizar el servicio.</span> Si desea cancelar o modificar esta reserva, debe hacerlo con una antelaciÃ³n mÃ­nima de 7 dÃ­as.
	</p>
    <p> 
		<strong>Tenga en cuenta que pueden derivarse retrasos, por ello la hora que le asignamos es aproximada, y los retrasos de salida con los deportivos pueden estar comprendidos entre 30 minutos y una hora y media aproximadamente como mucho</strong>, no es habitual, pero normalmente esto puede ocurrir a ultima hora de mediodÃ­a y a finales de la tarde.
    </p>
	<p>	
		Si su cupón está a punto de caducar o caduca para el día que quiere realizar el evento póngase en contacto con nosotros para ampliar la fecha de caducidad. Ya que una vez caducado no podremos activarlo ni prestar el servicio.
     <strong>'.$empresa.' no podrá realizar ningún servicio a todo participante que entregue su cupón caducado el día del evento sin su justificante de ampliación de '.$empresa.'</strong></p>
	<p>
		<strong>Os recordamos que dicha actividad está sujeta a condiciones meteorológicas y averías imprevistas. Todos aquellos eventos que sean suspendidos por dichas causas, serÃ¡n notificados al mismo email que ha recibido esta confirmación de reserva. Os recomendamos que la noche antes del evento revise su correo para asegurarse de que no hay ninguna anulación por incidente, ya sea meteorológico, averías imprevistas etc... Revise su correo no deseado por favor.</strong></p>
 	<p>
     <span class="importante">'.$empresa.' no se hace cargo</span> de los alojamientos de Hotel y desplazamientos, ya sean pÃºblicos o privados,  por consecuencia de las molestias ocasionadas por la suspensión de las mencionadas condiciones de incidencias meteorológicas o averías imprevistas que esta sujeta la actividad. Le recomendamos que si realiza un viaje en  aviÃ³n o dispone de una estancia en hotel, asegÃºrese de que tenga la opción de cancelar para que pueda reservar para otro día sin tener los gastos y molestias que puedan derivar una suspensión. Si no esta conforme con las condiciones que le informamos en esta confirmación de reserva póngase en contacto a '.EMAIL_INFO.' para anular su reserva.
	</p>	
	';
 

	if (tools::getValue('circuito')==1)
	{

	$texto_puntos_encuentro =
	'<div class="lista_confirm">
		<p class="circuito"><strong>Mora d\'Ebre:</strong>Circuito Mora d’Ebre: Carretera N- 420, Km. 818, 43740, Tarragona, España</p>
		<p class="circuito"><strong>El Vendrell:</strong>Circuito El Vendrell. Carretera Nacional 340, Km 1189, 43700 El Vendrell, España.</p>
		<p class="circuito"><strong>Segovia:</strong>Circuito Karting Diez Karpetania. Calle Baja, 4, 40191 La Higuera, Segovia, España</p>
		<p class="circuito"><strong>Zaragoza:</strong>Circuito Internacional de Zuera. Carretera Nacional 330 km 521, 50800 Zuera, Zaragoza, España.</p>
		<p class="circuito"><strong>Andalucía:</strong>Circuito Córdoba. Carretera de la Ermita, km 1, 14420 Villafranca de Córdoba, Córdoba, España</p>
		<p class="circuito"><strong>Valencia:</strong>Circuito Cheste escuela Ricardo Tormo circuito replica A-3, Salida 334, 46380 Cheste, Valencia, España</p>
	</div>
	';
		
	}
	else
	{
	$texto_puntos_encuentro =
	'<div class="lista_confirm">
		<p><strong>Madrid:</strong> Hotel Mavi,  Carretera Madrid-Ir&uacute;n, km 58, Avda. de la cabrera, 8  La Cabrera 28751 (Madrid)</p>

		<p><strong>Barcelona:</strong> Avda. Del Mestre Joan Muntaner nº 12. Igualada 08700 ( Barcelona )</p>

		<p><strong>Valencia:</strong> Hotel la Carreta.  Situado en la Carretera de Madrid a Valencia, KM, 334  46370 Chiva (Valencia) 	pegado al circuito de Chester.</p>

		<p><strong>Andalucía:</strong> Hotel Atalaya A-45, Km. 27, 14540 La Rambla - Montilla (C&oacute;rdoba)</p>

		<p><strong>Cantabria:</strong> Hotel nueva ubicación en Santander</p>
	</div>
	';
		
	}


   
	
	
    /** marco inferior arriba **/
	
	$cuadro_inferior1=
	'
	<table class="cuadro_principal" cellspacing="0" cellpadding="0">
	<tr>
		<td class="pestana2 borde_pestana">
			<div class="datos_pestana">
				<span class="importante" style="weight:bold;">Es muy importante que lea esta informaciÃ³n para que conozca las condiciones de uso.</span>
			</div>	
		</td>
		<td class="pestana2_resto">
		</td>
	</tr>
	<tr>
		<td id="condiciones" colspan="2" class="borde_cuadro">
			<div>
			'.$texto_condiciones.'
			</div>

		</td>
	</tr>
	</table>';
	
    /** marco inferior abajo **/
	
	$cuadro_inferior2=
	'
	<table class="cuadro_principal" cellspacing="0" cellpadding="0">
	<tr>
		<td class="pestana3 borde_pestana">
			<div class="datos_pestana">
				<strong>Puntos de encuentro</strong>
			</div>	
		</td>
		<td class="pestana3_resto">
		</td>
	</tr>
	<tr>
		<td colspan="2" class="borde_cuadro">
			<div>
			'.$texto_puntos_encuentro.'
			</div>
		</td>
	</tr>
	</table>';
	
	//$cuadro_inferior1='';
	//$cuadro_inferior2='';
	//$texto_puntos_encuentro='';
	$cad .= ' 
    <table id="confirmacion" class="tabla_cuadro_principal" cellspacing="0" cellpadding="0">
	<tr>
	  <td style="height:70px;" colspan="2">
	  </td>
	</tr>
	<tr>
	  <td>
	  '.$cuadro1.'
	  </td>
	  <td>
	  '.$cuadro2.'
	  </td>
	</tr>
	<tr>
	  <td>
	  '.$cuadro3.'
	  </td>
	  <td>
	  '.$cuadro4.'
	  </td>
	</tr>
	<tr>
		<td colspan="2">
		'.$cuadro_inferior1.'
		</td>
	</tr>
	<tr>
		<td colspan="2"> 
		'.$cuadro_inferior2.'
		</td>
	</tr>
	</table>';
				  
     
	 
     $cad = '<page backimg="'._BASE_URL_.'img/'.$imagen_fondo.'?i=1">'.$cad.'</page>';
				  
	 
	
        $cad = convert_caracters_hex($cad);
		
		$nombref = FuncionesCodigos::genera_num();
		$nombref .= $piloto;
		$nombre_fichero = $nombref;

        
        ob_start();
		
        $html2pdf = new HTML2PDF('P', 'A4', 'fr');
        $html2pdf->setTestTdInOnePage(false);
		$view_html=0;
        $html2pdf -> writeHTML($cad, ($view_html==1));  
        //Si estamos generando la vista previa del cupÃ³n generaremos un cÃ³digo aleatorio para el nombre del archivo pdf.
        //$html2pdf -> Output('confirmacion_reservas/confirm_' . $nombref . '.pdf', 'F');
		$html2pdf -> Output('../confirmacion_reservas/confirm_' . $nombref . '.pdf', 'F');
       
		return true;

         
    } 
	catch(HTML2PDF_exception $e) 
	{
        echo $e;
        eliminar_archivos($nombref);

        return false;
    }
    
}



/** Enviar mail WonderBox **/

function envia_mails_pdf_wb($destinatario)
{ 
	global $emp;
	$nombref='';
	
	$empresa = ucfirst(str_replace(' ','',_NOMBRE_EMP_));
	
	include_once 'class.phpmailer.php';
	include_once 'textos_mensajes.php';


	$mail = new PHPMailer();

    $mail->Host = "localhost";
	$mail -> CharSet = "UTF-8";
	

	if (strpos(tools::getValue('tipus'),'ruta_turistica')!==false) 
		$mail->From = EMAIL_RESERVAS_TURISMO;
	else 
		$mail->From = EMAIL_RESERVAS;


	$mail->FromName = _DOMINIO_EMP_;
	$mail->Subject = "Aviso WonderBox";


	
				
	$body= "<strong>¡ATENCION! Estimado cliente,  para finalizar y conservar su reserva es imprescindible que nos envíe el bono totalmente rellenado y cumplimentado con sus datos a la dirección:</strong><br><br>";  
	$body.= "<strong style='color:#ff0000;'>Dream Cars Experience SL.  Avenida del Mestre Joan Muntaner,  nº 12. Local bajos Código postal 08700,  población Igualada, provincia de  (Barcelona) </strong><br><br>";  
	$body.= "<span style='font-weight:normal;'>¡Muy importante! Tiene que ser un correo certificado y enviado por la Sociedad Estatal de Correos y Telégrafos de España ya que no se admiten cupones escaneados ni enviados por email.</span><br><br>";  
	$body.= "<strong>Es imprescindible que guarde el resguardo del envío de correos y realice una fotocopia de su cupón para entregar ambos el día del evento como justificante.</strong><br><br>";  
	$body.= "<span style='font-weight:normal;'>Este procedimiento se realiza únicamente con Wonderbox por su política de empresa y seguridad a fin de evitarle posibles incidencias como cupones caducados, redimidos o suplantación de identidad. Para  garantizarle al máximo un uso correcto y responsable del bono que dispone.  </span><br><br>";  
	$body.= "<span style='font-weight:normal;'>Si no envía el cupón por correo certificado Y NO ENTREGA FOTOCOPIA ORIGINAL DEL BONO RELLENADO JUNTO CON EL RESGUARDO DEL ENVIO DEL CUPÓN  el día del evento los organizadores del evento no podrán prestarles los servicios contratados. </span><br><br>";  
	$body.= "<span style='font-weight:normal;'>Si tiene alguna duda, contacte con nosotros al 931263281 / 680697109  ¡Estamos para ayudarle y facilitarle las gestiones oportunas!	</span><br><br>";  
	$body.= "<span style='font-weight:normal;color:#6d6d6d;text-decoration:none;'>Este mensaje ha sido enviado por un sistema automático. Por favor no responda a este e-mail directamente</span><br><br>";
	$body.= "<span style='font-weight:normal;'>¡Gracias por su colaboración!</span><br><br>";  
	$body=utf8_encode($body);

	
	$mail->AddAddress($destinatario);
	$mail->AddBCC(EMAIL_INFO,"oculto");

		
	$plantilla=new PlantillaEmail();
	$body = $plantilla->getBodyEmail($body);
	unset($plantilla);
	
	$mail -> Body = $body;
    $mail -> IsHTML(true);
	$mail ->SMTPDebug  = 1;
	try
	{
		if (!$mail -> Send()) {
			echo('error ' . $mail -> ErrorInfo);
			$mail->AddAddress('marctorraso@gmail.com');
			$mail -> Send();
			//unlink(dirname(__FILE__) . '/../cupones/tmp/pdf_cupon' . $ncupon . '.html');
			return false;
		}
	}
	catch (phpmailerException $e) {
	  die ($e->errorMessage()); //Errores de PhpMailer
	  }
	 catch (Exception $e) {
	  die ($e->getMessage()); //Errores de cualquier otra cosa.
	}


}

function enviar_mail_aviso_documentacion($destinatario)
{ 
	global $emp;
	$nombref='';
	
	$empresa=ucfirst(str_replace(' ','',_NOMBRE_EMP_));

	
	include_once 'class.phpmailer.php';
	include_once 'textos_mensajes.php';


	$mail = new PHPMailer();

    $mail->Host = "localhost";
	$mail -> CharSet = "UTF-8";
	

	if (strpos(tools::getValue('tipus'),'ruta_turistica')!==false) 
		$mail->From = EMAIL_RESERVAS_TURISMO;
	else 
		$mail->From = EMAIL_RESERVAS;

	$mail->FromName = _DOMINIO_EMP_;
	$mail->Subject = "Aviso Importante sobre el evento!!";


	$body.= '- <b>!Muy importante!</b> Recuerde presentar la confirmaci&oacute;n de la reserva junto con el cup&oacute;n original de compra ó regalo, la fotocopia del DNI  y la fotocopia del carnet de conducir.<br /><br />';
	
	$body.= '<b>En caso de no presentar dicha documentaci&oacute;n no se podr&aacute; realizar el evento.</b> Recuerde tambi&eacute;n que debe presentarse 30 minutos antes de la hora solicitada. <br><br>';                                               
	$body.= "<span style='font-weight:normal;color:#6d6d6d;text-decoration:none;'>Este mensaje ha sido enviado por un sistema autom&aacute;tico. Por favor no responda a este e-mail directamente</span><br><br>";                        

	//$body=utf8_encode($body);    
	$plantilla=new PlantillaEmail();
	$body = $plantilla->getBodyEmail($body);
	unset($plantilla);
	
	$mail->AddAddress(tools::getValue('email1'));    
	//$mail->AddBCC("info@motorclubexperience.com","oculto");  

		
	
	$mail -> Body = $body;
    $mail -> IsHTML(true);
	$mail ->SMTPDebug  = 1;
	try
	{
		if (!$mail -> Send()) {
			echo('error ' . $mail -> ErrorInfo);
			$mail->AddAddress(EMAIL_ERRORES);
			$mail -> Send();
			//unlink(dirname(__FILE__) . '/../cupones/tmp/pdf_cupon' . $ncupon . '.html');
			return false;
		}
	}
	catch (phpmailerException $e) {
	  die ($e->errorMessage()); //Errores de PhpMailer
	  }
	 catch (Exception $e) {
	  die ($e->getMessage()); //Errores de cualquier otra cosa.
	}


}

function enviar_mail_aviso_hotel($destinatario)
{ 
	global $emp;
	$nombref='';
	
	$empresa=ucfirst(str_replace(' ','',_NOMBRE_EMP_));
	
	include_once 'class.phpmailer.php';
	include_once 'textos_mensajes.php';


	$mail = new PHPMailer();

    $mail->Host = "localhost";
	$mail -> CharSet = "UTF-8";
	

	if (strpos(tools::getValue('tipus'),'ruta_turistica')!==false) 
		$mail->From = EMAIL_RESERVAS_TURISMO;
	else 
		$mail->From = EMAIL_RESERVAS;

	$mail->FromName = _DOMINIO_EMP_;
	$mail->Subject = "Aviso Importante sobre el Hotel!!";
	
	$fentrada=(trim(tools::getValue('fecha_hotel'))=='')?'':implode('/',array_reverse(explode('-',trim(tools::getValue('fecha_hotel')))));                                                                                                                                                           
	
	$body.= '- !Muy importante! Recuerde llamar al hotel '.nombre_hotel(tools::getValue('id_hotel')).' al tel. '.tools::getValue('telefono_hotel').' para confirmar la reserva de la noche '.$fentrada.', ';                                                                                                                                                                            
	$body.= '<b>de lo contrario cabe la posibilidad de que no disponga de plaza para el día del evento</b><br /><br />';                                                                                          
	
	
	if ($_REQUEST['ciudad']=='' && $_REQUEST['id_hotel']==4949)
	{	
		$body.= ' .<br>Si su cupón dispone de cena póngase en contacto con Motor Club Experience al 93 126 32 81. ';                                                                                                                                                                   
	}		
	
	$body.= "<br><br><span style='font-weight:normal;color:#6d6d6d;text-decoration:none;'>Este mensaje ha sido enviado por un sistema automático. Por favor no responda a este e-mail directamente</span><br><br>";
	
	//$body=utf8_encode($body);    

	$plantilla=new PlantillaEmail();
	$body = $plantilla->getBodyEmail($body);
	unset($plantilla);
	
	$mail->AddAddress($destinatario);
	$mail->AddBCC(EMAIL_INFO,"oculto");

		
	
	$mail -> Body = $body;
    $mail -> IsHTML(true);
	$mail ->SMTPDebug  = 1;
	try
	{
		if (!$mail -> Send()) {
			echo('error ' . $mail -> ErrorInfo);
			$mail->AddAddress(EMAIL_ERRORES);
			$mail -> Send();
			//unlink(dirname(__FILE__) . '/../cupones/tmp/pdf_cupon' . $ncupon . '.html');
			return false;
		}
	}
	catch (phpmailerException $e) {
	  die ($e->errorMessage()); //Errores de PhpMailer
	  }
	 catch (Exception $e) {
	  die ($e->getMessage()); //Errores de cualquier otra cosa.
	}


}


function envia_mails_pdf($destinatario)
{ 
	global $emp;
	$nombref='';
	$empresa=ucfirst(str_replace(' ','',_NOMBRE_EMP_));

	generar_pdf_confirm_reserva($nombref,$empresa);
	
	include_once 'class.phpmailer.php';
	include_once 'textos_mensajes.php';

	$tipus=tools::getValue('tipus');
    $aux=explode('@',tools::getValue('id_alta'));

	if($tipus!='porsche997' && $tipus!='porsche996')
	  {
	  $h=explode(':',$aux[1]);
	  if($h[1]=='00' || $h[1]=='15'){
		$aux[1]=$h[0].':00:00';
	  }
	  else if($h[1]=='30' || $h[1]=='45'){
	    $aux[1]=$h[0].':30:00';
	  }
	 }
	
	
	
	$mail = new PHPMailer();

    $mail->Host = "localhost";
	$mail -> CharSet = "UTF-8";
	

	if (strpos(tools::getValue('tipus'),'ruta_turistica')!==false) 
		$mail->From = EMAIL_RESERVAS_TURISMO;
	else 
		$mail->From = EMAIL_RESERVAS;

	$mail->FromName = _DOMINIO_EMP_;
	$mail->Subject = "Confirmación de Reserva "._NOMBRE_EMP_;
 
	
	
	$body='';

    //dirname(__FILE__).'/
    $mail -> AddAttachment('../confirmacion_reservas/confirm_'.$nombref.'.pdf', 'confirmacion_reserva.pdf'); 
	if ($destinatario=='motorclub')
	{
		$mail->AddAddress(EMAIL_MC);   
		//$mail->AddBCC("marctorraso@gmail.com","oculto");
		
		if($emp=='hcc')
		  $mail->AddBCC(EMAIL_EMP,"oculto");
		  
		$body='';
		
		$aux_ciudad=$_REQUEST['ciudad'];
		
		$tipo=return_tipus_e(tools::getValue('tipo_vehiculo'),tools::getValue('km_ruta'));
		

		if(trim($aux_ciudad)=='')$aux_ciudad='Barcelona';
		$aux_ciudad=strtoupper($aux_ciudad );
		
		$ciudad_visible = $aux_ciudad;
		
		if (strtoupper($aux_ciudad)=='RUTAS_TURISTICAS')
		{
			$ciudad_visible = ciudad_ruta(tools::getValue('tipus'));
		}
			
		//return_tipus_e(tools::getValue('tipus'),tools::getValue('km'))
		$body.= "<strong>Su reserva ha sido realizada con los siguientes datos:</strong><br/><br/>";  
		//mts 27092012
		$body.= "<strong>Fecha Reserva: </strong>".tools::getValue('fecha').'<br /><br />';
		$body.= "<strong>Ciudad: </strong>".$ciudad_visible.'<br /><br />';
		$body.= "<strong>Evento: </strong>".$tipo.'<br /><br />';
		$body.= "<strong>Dia: </strong>".$aux[0].'<br /><br />';
		$body.= "<strong>Hora: </strong>".$aux[1].'<br /><br />'; 
		if (tools::getValue('circuito')==1)
			$body.= "<strong>Número de vueltas: </strong>".tools::getValue('num_vueltas')."<br /><br />"; 
		//fin modif mts 27092012
		$body.= "<strong>Nombre piloto: </strong>".convert_caracters_hex(tools::getValue('pilot')).'<br /><br />';
		$body.= "<strong>Apellidos piloto: </strong>".convert_caracters_hex(tools::getValue('apellidos_piloto')).'<br /><br />';
		
		$body.= "<strong>Email piloto: </strong>".tools::getValue('email').'<br /><br />';
		$body.= "<strong>Tel&eacute;fono piloto: </strong>".tools::getValue('telefon').'<br /><br />';

		
		$body.= "<strong>Nombre de la persona que regala: </strong>".convert_caracters_hex(tools::getValue('persona_regala')).'<br /><br />';
		$body.= "<strong>Apellidos de la persona que regala: </strong>".convert_caracters_hex(tools::getValue('apellidos_persona_regala')).'<br /><br />';
		$body.= "<strong>DNI persona que regala: </strong>".convert_caracters_hex(tools::getValue('nif')).'<br /><br />';
		$body.= "<strong>Email persona que regala: </strong>".tools::getValue('email_regala').'<br /><br />';
		$body.= "<strong>M&oacute;vil persona que regala: </strong>".tools::getValue('telefon_regala').'<br /><br />';
		$body.= "<strong>Origen: </strong>".tools::getValue('origen').'<br /><br />';
		$textos_codigos = canvia_textos_codigo(tools::getValue('origen'));
		$body.= "<strong>".utf8_decode($textos_codigos[0]).": </strong>".tools::getValue('codigo_localizador').'<br /><br />';
		if (!in_array(tools::getValue('origen'),array('CODIGO_ALFA','DOOPLAN','LA_TIENDA_MARCA','PLANEO','MOTORCLUBEXPERIENCE','DREAMCARSEXPERIENCE','HCCSPORTCARS','DAKOTABOX','WONDERBOX'))) 
			$body.= "<strong>".utf8_decode($textos_codigos[1]).": </strong>".tools::getValue('codigo_consumo').'<br /><br />';
		//$body.= "<strong>C&oacute;digo localizador: </strong>".tools::getValue('codigo_localizador').'<br>';
		//$body.= "<strong>C&oacute;digo consumo: </strong>".tools::getValue('codigo_consumo').'<br>';
		
		$Observaciones = tools::getValue('Observaciones');
		$Observaciones = trim($Observaciones);

		if (in_array(tools::getValue('km'),array(14,40)))
		{
			if (substr($Observaciones,-1)!='-')	
				$Observaciones .= ' - ruta de ' . tools::getValue('km') . ' km. ';
			else $Observaciones .= ' ruta de ' . tools::getValue('km') . ' km. ';
				
		}
		
		$body.= "<strong>Observaciones: </strong>".convert_caracters_hex($Observaciones).'<br /><br />';
		$body.= "<strong> Direcci&oacute;n IP: </strong>".tools::getValue('ip').'<br /><br />';
	  
		//$body.=direcciones_eventos(); 
	}
	else
	{   
		if ($destinatario=='hotel')                
		{   echo('destinatario hotel1 ');
			$mail->AddAddress(tools::getValue('email1'));                    
			/*$ciudad = $_REQUEST['ciudad'];						
			if(trim($ciudad)=='') $ciudad='barcelona';                                                                                     
			$codigo_hotel= codigo_hotel_ciudad(strtolower($ciudad));                                                                      
			*/
			$ciudad = $_REQUEST['ciudad'];			 			    
			if(trim($ciudad)=='') $ciudad='barcelona';   
			if (trim(tools::getValue('fechaentrada'))!='') 
			{
				$fecha=implode('-',array_reverse(explode('/',trim(tools::getValue('fechaentrada')))));
				$fecha.=' 00:00:00';
			}
			else			
			{
				$fecha_a=explode('@',tools::getValue('id_alta'));

				$fecha=$fecha_a[0].' 00:00:00';
			}
 			
			$c=codigo_hotel_ciudad(strtolower($ciudad),$fecha); 
			 

			$codigo_hotel=$c; 
			  
			if ($codigo_hotel)   
			{
				$email_hotel = email_hotel($codigo_hotel);                                              

				if (_PRUEBAS_==0)
				{
					$mail->AddAddress($email_hotel);     
					/*if ($codigo_hotel=='4949') 
					{	
						$mail->AddAddress('collbato@eada.edu');							              
					}*/														
					
				}
				else
				{
					$mail->AddAddress(EMAIL_TEST);   
				}
				
				 
				
				$mail->AddBCC(EMAIL_INFO,"oculto");

				//$mail->AddAddress('marctorraso@yahoo.es');   
			}			  
		}  
		else 
		{
			$mail->AddAddress(tools::getValue('email1'));
			$mail->AddBCC(EMAIL_INFO,"oculto");
		}
 
		
		$body = "<strong></strong> Reserva para " . date('j/m/Y') . "<br><br>";
		//$body .= "<i>Enviado por ".$empresa." </i><br><br>";
		$body .= "<strong>USUARIO: " . tools::getValue('persona_regala')." ".tools::getValue('apellidos_persona_regala')."</strong><br>
		<br><br>";
		$body .= "<i><strong>Le adjuntamos la confirmación de reserva que debe presentar junto con el vale comprado de la experiencia.</strong></i><br><br>";
		$body.= "<span style='font-weight:normal;color:#6d6d6d;text-decoration:none;'>Este mensaje ha sido enviado por un sistema automático. Por favor no responda a este e-mail directamente</span><br><br>";

    }
	
	$plantilla=new PlantillaEmail();
	$body = $plantilla->getBodyEmail($body);
	$mail->AddBCC('soporte@motorclubexperience.com',"oculto");
	$mail->AddBCC('soporte_hcs@hotmail.com',"oculto"); 
	unset($plantilla);	
	
	$mail -> Body = $body;
    $mail -> IsHTML(true);
	$mail ->SMTPDebug  = 1;
	try
	{
		if (!$mail -> Send()) {
			echo('error ' . $mail -> ErrorInfo);
			if ($nombref!='') eliminar_archivos($nombref);
			unlink(dirname(__FILE__) . '/../confirmacion_reservas/confirm_'.$nombref.'.pdf');
			$mail->AddAddress(EMAIL_ERRORES);
			$mail -> Send();
			return false;
		}
	}
	catch (phpmailerException $e) {
	  die ($e->errorMessage()); //Errores de PhpMailer
	  }
	 catch (Exception $e) {
	  die ($e->getMessage()); //Errores de cualquier otra cosa.
	}
    if ($nombref!='') eliminar_archivos($nombref);


}
/** fin confirmaciÃ³n pdf **/  

function eliminar_archivos($nombref) {
    unlink(dirname(__FILE__) . '/../confirmacion_reservas/confirm_' . $nombref . '.pdf');

}
  

/** promociones enviadas al realizar la reserva **/

function genera_body_oferta_mails($ciudad,$id_evento,$empresa,$destinatario,&$imagen_portada,&$url_base)
{
	global $inst;
	
	$url_base=_BASE_URL_;
	$logo=LOGO_PROMO_EMP;

	$aux_ciudad = $ciudad;
	if(trim($aux_ciudad)=='')  $aux_ciudad='BARCELONA';
	$aux_ciudad=strtoupper($aux_ciudad);
	
	$idoferta = oferta_ciudad($aux_ciudad);
	
	$body = body_email_oferta($aux_ciudad,$idoferta,$url_base,$logo,$imagen_portada);
	

	$sqlenv = ' insert into envios (email,id_evento,ciudad) values ("'.$destinatario.'","'.$id_evento.'","'.$aux_ciudad.'") ';
	$result=$inst->execute($sqlenv);
	
	return ($body);
	
}



function envia_oferta_mails($ciudad,$id_evento,$empresa,$destinatario,$imagen_portada,$pbody,$url_base)     
  {  	   
	include_once 'class.phpmailer.php';                                                                                                                                                                                                                                                                                   
	include_once 'textos_mensajes.php';
	
	$mail = new PHPMailer();

    $mail->Host = "localhost";

	$mail->From = EMAIL_INFO_EMP;
	$mail->FromName = _DOMINIO_EMP_;
	$mail->Subject = _DOMINIO_EMP_;
	  
	$aux_ciudad = $ciudad;
	if(trim($aux_ciudad)=='')  $aux_ciudad='BARCELONA';
	$aux_ciudad=strtoupper($aux_ciudad);
	
	$mail->Subject.= utf8_decode(' [PromociÃ³n exclusiva para clientes: Velada romÃ¡ntica en '.$aux_ciudad.']');
	$mail->AddAddress($destinatario);
    $mail->AddBCC(EMAIL_MC ,"oculto");
   
	$body='';



	$url_base= 'http://'.$url_base.'/';
	
	$idoferta = oferta_ciudad($aux_ciudad);
	
	$body = 'Si no ves correctamente este mail, haz clic <a href="'.$url_base.'lista-ofertas/mailing/'.$idoferta.'-'.$imagen_portada.'-oferta.html">aqu&iacute;</a> para ver la oferta <br><br><br>'.$pbody;
	$plantilla=new PlantillaEmail();
	$body = $plantilla->getBodyEmail($body);
	unset($plantilla);
    $mail->Body = $body;

    $mail->IsHTML(true);

    $mail->Send();

	 
	echo ('OK');

  }  

  function oferta_ciudad($ciudad)
 {
	$idoferta = '';
	switch(strtolower($ciudad))
	{
		case 'barcelona':
			$idoferta = 87;
		break;
		case 'madrid':
			$idoferta = 62;
		break;
		case 'cantabria':
			$idoferta = 74;
		break;
		case 'andalucia':
			$idoferta = 61;
		break;
		case 'valencia':
			$idoferta = 50;
	
		break; 
	}
	return $idoferta;
 }

function body_email_oferta($ciudad,$idoferta,$root,$logo,&$imagen_portada)
{

	
	$oferta = new OfertaHistorico();
	$r=$oferta->get($idoferta);      
		
	$root_im = _BASE_URL_;	

    $body='';
		
	$pathim = "img/oh/";
	$nombref = $root_im.$pathim.$oferta->id.'-'.$oferta->idImagenPortada.'.jpg';
	$imagen_portada = $oferta->idImagenPortada;
	list($widthim,$heightim,$dummy,$dummy) = getimagesize($nombref);   
	//{capture name="heightim"}{getImSizeHeight image=$nombref maxw=284 maxh=258}{/capture}

	//var_dump($oferta);die;
	$wmax=250;
	$hmax=250;
    $h=$heightim;
	$w=$widthim;
	if ($heightim>$widthim)
		{
		$widthim=($widthim/$heightim)*$hmax;
		$heightim=$hmax;	
		}
	if ($heightim<$widthim) 
		{
		$heightim=($heightim/$widthim)*$wmax;
		$widthim=$wmax;
		
		}
		
		
	/**** precios *****/
	
		//si hay opciones pondremos un precio mÃ­nimo alto, para que no se tenga en cuenta el precio final de la oferta.
		if (count($opciones_of)>0) 
			$precio_min = 99999999999999999999;
		else
			$precio_min = $oferta->precioFinal;
		
		$precio_min = $oferta->precioFinal;
		$precioValor=$oferta->precioValor;
		$ahorro=$oferta->ahorro;
		$descuento=$oferta->descuento;
		$precioFinal = $oferta->precioFinal;
	
		
		//$opciones_of=GetOpcionesOfertaHist($oferta->id);
		if ($opciones_of == NULL) $opciones_of = array();
		foreach($opciones_of as $opc) 
			{
				if (floatval($opc->precioFinal)<floatval($precio_min)) 
				{
					$precio_min=floatval($opc->precioFinal);
					$precioValor=$opc->precioValor;
					$ahorro=$opc->ahorro;
					$descuento=$opc->descuento;
					$precioFinal = $opc->precioFinal;
				}
			} 
	
	
	$precio_lista_style = 'height:32px;width:10px;color:#09032F;background-color:#C7C7C7;font-size:18px;font-weight:bold;text-align:center;text-align:center;padding:0;';
	$precio_final_style = 'height:32px;width:20px;color:#09032F;background-color:#FFC401;font-size:18px;font-weight:bold;text-align:center;text-align:center;';
	$texto_boton_oferta = 'text-decoration:none;color:#09032F;font-size:18px;font-weight:bold;text-align:center;';
    $body.='<table width="90%" cellspacing="0" bgcolor="#FFFFFF"><tr><td style="padding:0;width:500px;">';
	$body.='   <table width="500"  cellpadding="0" cellspacing="0" bgcolor="#424242"  align="center"  style="margin-top:20px;margin-bottom:0;border:none;text-align:center;" >
					<tr>
						<td align="left" style="width:500px;">
							<img width="530" src="'.$root_im.'/../img/'.$logo.'" style="width:530px;padding-bottom:20px;">
						</td>
					<tr>
					<tr>
						<td align="left" style="width:500px;padding-top:1px;background-color:#FFFFFF;"></td>
					</tr>
					<tr>
						<td align="left" style="width:500px;">
							<img src="'.$root_im.'/../img/titulo_ofertas_ultima_hora_sf.png" style="height:35px;">
						</td>
					<tr>
			   </table>';
	$body.='</td></tr><tr><td>';			
	$body.= '  <table width="500" cellpadding="0" cellspacing="0" bgcolor="#424242" align="center">
				<tr>
					<td align="left">
					<table width="500" style="background-color:#424242;">
						<tr>
							<td valign="top" align="left" width="250" style="text-align:left;padding-left:10px;">
								<img style="vertical-align:middle;" src="'.$root_im.'img/oh/'.$oferta->id.'-'.$oferta->idImagenPortada.'.jpg" alt="'.$oferta->titulo.'" height="'.$heightim.'" width="'.$widthim.'"/><span style="font-size:1px;" width="1px">&nbsp;</span>
							</td>
							<td valign="top" style="height:170px;width:245px;margin-left:12px;">
								<table style="width:245px;">
								<tr>
								<td style="max-height:94px;overflow:hidden;margin:5px 0 8px;font-size:17px;color:#FF9928;font-family:Trebuchet MS",Arial,Helvetica,sans-serif;">'.
									utf8_decode($oferta->titulo).'
								</td>		
								</tr>
								<tr>
								<td style="font-size:15px;margin-bottom:30px;color:#FFFFFF;font-family:Trebuchet MS",Arial,Helvetica,sans-serif">'.
									utf8_decode($oferta->subtitulo).'
								</td>
								</tr>
								</table>
							</td>
						</tr>

						<tr>
							<td valign="top" align="center" style="width:500px;" colspan="2">
								<table style="width:500px;height:238px;">
								<tr>
								   <td style="height:150px;width:200px;height:60px;padding:0;padding-bottom:50px;">		
									   <table style="height:100px;width:200px;">
									       <tr>
												<td colspan="3">
													<img src="'.$root_im.'img/precios_reducido2.png" width="230">
												</td>
										   </tr>
										   <tr>
												<td style="'.$precio_lista_style.'">'.
													$precioValor.' &euro;
												</td>
												<td id="descuento" style="'.$precio_lista_style.'">'.
													$descuento.' %
												</td>
												<td id="ahorro" style="'.$precio_lista_style.'">'.
													$ahorro.' &euro;
												</td>
										   </tr>
										</table>
									</td>
									<td style="font-size:16px;width:246px;height:60px;margin-top:0;vertical-align:top;">
										<table style="font-size:16px;height:100px;width:246px;margin-top:0;margin-left:20px;">
											<tr>
												<td  style="height:28px;text-align:left;font-size:16px;" colspan="2">
												<span style="font-size:16px;color:#FFFFFF;">'.utf8_decode('Cumple tus sueÃ±os por sÃ³lo:').'</span>
												</td>
											</tr>
											<tr>
												<td  style="'.$precio_final_style.';height:50px;width:50px;">'.
												$precioFinal.' &euro;
											   </td>
											   <td style="width:50px;background-color:#009B01;height:32px;text-align:center;">
												<a  style="'.$texto_boton_oferta.' margin-left:16px;" href="'.$root.'/detalle-oferta/'.$oferta->id.'-0-oferta.html">Ver Oferta</a>
												</td>
										   </tr>
										</table>
									</td>
								</tr>
								</table>
							</td>							
						</tr>
					</table>
					</td>
				</tr>
			 </table>';
    $body.='</td></tr></table>';
	

	$body.='<style>
		h3.oferta_desc {
	    color: #FFFFFF;
	    font-size: 18px;
	    margin-left: 0;
	}
	div#resumen p {
    color: #FFFFFF;
    font-size: 15px;
    margin-bottom: 30px;
	}
	</style>
	';
	
	//Ofertas list
	$body.='	<style>
		html {border:none;background-color:#000000;}
		body {background-color:#000000;}
		</style>';
		
		
	return $body;
}

/** fin promociones **/  
  
  
function envia_mails()
  {
  	global $emp;   
	include 'class.phpmailer.php';
	include 'textos_mensajes.php';
    $tipus=tools::getValue('tipus');
    $aux=explode('@',tools::getValue('id_alta'));
	if($tipus!='porsche997' && $tipus!='porsche996' && $tipus!='_bferrari_' && $tipus!='_blamborghini_')
	  {
    	  $h=explode(':',$aux[1]);
    	  if($h[1]=='00' || $h[1]=='15'){
    		$aux[1]=$h[0].':00:00';
    	  }
    	  else if($h[1]=='30' || $h[1]=='45'){
    	    $aux[1]=$h[0].':30:00';
    	  }
      }
      else if ($tipus=='_bferrari_' || $tipus=='_blamborghini_')
      {   echo($tipus);
          $h=explode(':',$aux[1]);
          for($i=0;$i<=45;$i+=15)
          {
              echo('h1 :'.$h[1]);
              echo('i: '.$i);
            if((int)$h[1]==$i || (int)$h[1]==$i+7){$aux[1]=$h[0].':'.(($i>9)?$i:'0'.$i).':00';}
          }
      }  

	
	
	
	$mail = new PHPMailer();

    $mail->Host = "localhost";
	
	if (strpos(tools::getValue('tipus'),'ruta_turistica')!==false) 
		$mail->From = EMAIL_RESERVAS_MC;
	else 
		$mail->From = EMAIL_RESERVAS;
	

	$dominio=_DOMINIO_EMP_;
	
	$mail->FromName = $dominio;
	$mail->Subject = $dominio;

	$mail->AddAddress(tools::getValue('email1'));
    $mail->AddBCC(_EMAIL_MC_,"oculto");
    
	if($emp=='hcc')
	  $mail->AddBCC(EMAIL_INFO_EMP,"oculto");
   
	$body='';
    
	if($emp=='hcc')
	{
	    $body= texto_reserva_hccsportscar();
	} 
	else if($emp=='dre')
	{
	     $body= texto_reserva_dreamcars();
	}	 
    else 
	{
		$body= texto_reserva();
	}	

	
	$aux_ciudad=$_REQUEST['ciudad'];
	if(trim($aux_ciudad)=='')$aux_ciudad='Barcelona';
	$aux_ciudad=strtoupper($aux_ciudad );
	
	if ($aux_ciudad=='RUTAS_TURISTICAS')
	{
			$ciudad_visible=ciudad_ruta(tools::getValue('tipus'));
	}
	
	
	$body.= "<strong>Su reserva ha sido realizada con los siguientes datos:</strong><br><br>";  
    //mts 27092012
    $body.= "<strong>Fecha Reserva: </strong>".tools::getValue('data_reserva').'<br>';
    $body.= "<strong> Direcci&oacute;n IP: </strong>".tools::getValue('ip').'<br>';
	//fin modif mts 27092012
	$body.= "<strong>Nombre piloto: </strong>".convert_caracters_hex(tools::getValue('pilot')).'<br>';
	$body.= "<strong>Apellidos piloto: </strong>".convert_caracters_hex(tools::getValue('apellidos_piloto')).'<br>';
	
	$body.= "<strong>Email piloto: </strong>".tools::getValue('email').'<br>';
	$body.= "<strong>Tel&eacute;fono piloto: </strong>".tools::getValue('telefon').'<br>';

	$body.= "<strong>Origen: </strong>".tools::getValue('origen').'<br>';
	
	$body.= "<strong>Dia: </strong>".$aux[0].'<br>';
	$body.= "<strong>Hora: </strong>".$aux[1].'<br>';
	$body.= "<strong>Evento: </strong>".return_tipus_e(tools::getValue('tipo_vehiculo'),tools::getValue('km_ruta')).'<br>';
	$body.= "<strong>Nombre de la persona que regala: </strong>".convert_caracters_hex(tools::getValue('persona_regala')).'<br>';
	$body.= "<strong>Apellidos de la persona que regala: </strong>".convert_caracters_hex(tools::getValue('apellidos_persona_regala')).'<br>';
	$body.= "<strong>DNI persona que regala: </strong>".convert_caracters_hex(tools::getValue('nif')).'<br>';
	$body.= "<strong>Email persona que regala: </strong>".tools::getValue('email_regala').'<br>';
	$body.= "<strong>M&oacute;vil persona que regala: </strong>".tools::getValue('telefon_regala').'<br>';
	$textos_codigos = canvia_textos_codigo(tools::getValue('origen'));
	$body.= "<strong>".utf8_decode($textos_codigos[0]).": </strong>".tools::getValue('codigo_localizador').'<br>';
	if (!in_array(tools::getValue('origen'),array('CODIGO_ALFA','DOOPLAN','LA_TIENDA_MARCA','PLANEO','MOTORCLUBEXPERIENCE','DREAMCARSEXPERIENCE','HCCSPORTCARS','DAKOTABOX','WONDERBOX'))) 
		$body.= "<strong>".utf8_decode($textos_codigos[1]).": </strong>".tools::getValue('codigo_consumo').'<br>';
	//$body.= "<strong>C&oacute;digo localizador: </strong>".tools::getValue('codigo_localizador').'<br>';
	//$body.= "<strong>C&oacute;digo consumo: </strong>".tools::getValue('codigo_consumo').'<br>';
	$body.= "<strong>Ciudad: </strong>".$ciudad_visible.'<br>';
	$Observaciones = tools::getValue('Observaciones');
	$Observaciones = trim($Observaciones);

	if (in_array(tools::getValue('km'),array(14,40)))
	{
		if (substr($Observaciones,-1)!='-')	
			$Observaciones .= ' - ruta de ' . tools::getValue('km') . ' km. ';
		else $Observaciones .= ' ruta de ' . tools::getValue('km') . ' km. ';
			
	}	
	$body.= "<strong>Observaciones: </strong>".convert_caracters_hex($Observaciones).'<br>';
  
	$body.=direcciones_eventos();
	$body.="<span style='font-weight:normal;color:#6d6d6d;text-decoration:none;'>Este mensaje ha sido enviado por un sistema automático. Por favor no responda a este e-mail directamente</span><br><br>";
 
	
  // echo $body;
   	$plantilla=new PlantillaEmail();
	$body = $plantilla->getBodyEmail($body);
	unset($plantilla);

    $mail->Body = $body;

    $mail->IsHTML(true);

    $mail->Send();
	
	echo 'OK';

  }  

function codigo_hotel_activo($ciudad,$fecha)                                 
{ 
	include_once (dirname(__FILE__).'/../classes/Db.php');
	include_once (dirname(__FILE__).'/../classes/Hotel.php');
	include_once (dirname(__FILE__).'/../classes/DisponibilidadHotel.php');
	$disponibilidad_hotel = new DisponibilidadHotel();     
						   		
	$hoteles=array();
	$hoteles=$disponibilidad_hotel->getHotelesCiudad($ciudad,$fecha);                                                                                                                                                                                                                            

	$hotel=new Hotel();        
	
	if (count($hoteles)==0)
	{
		$defecto=1;
	}
	else
	{
		$defecto=0;
	}

	$codigo_hotel=$hotel->getCodigoHotelDefecto($ciudad,$defecto);	  
	return array($codigo_hotel,$defecto); 
}   
  

function codigo_hotel_ciudad($ciudad,$fecha)
{
	switch($ciudad)
	{
		case 'barcelona':
			$codigo ='5050';  
			//$codigo=codigo_hotel_activo('barcelona');			
		break;	
		case 'madrid':
		//Sara de Ur
			//$codigo=codigo_hotel_activo('madrid');
			//$codigo = '1111';
			$codigo=codigo_hotel_activo('madrid',$fecha);
			$codigo=$codigo[0];
		break;	
		//Cantabria
		case 'cantabria':
			$codigo = '12345';
			//$codigo=codigo_hotel_activo('cantabria');
			
		break;	
		//Atalaya
		case 'andalucia':
			//$codigo=codigo_hotel_activo('andalucia');
			
			//$codigo = 'Atalaya2015';
			$codigo=codigo_hotel_activo('andalucia',$fecha);
			$codigo=$codigo[0];
		break;
		//La carreta
		case 'valencia':
			//$codigo=codigo_hotel_activo('valencia');
			
			$codigo= '2030';
		break;
		//La carreta
		case 'zaragoza':
			//$codigo=codigo_hotel_activo('zaragoza');
			
			$codigo= '2030';
		break;
		default:
			$codigo='';
	}			
	return $codigo;	
} 

function nombre_hotel($h)
{
  	switch($h)
	{
        case '99999': //test            
		return "test";
        break;
        case '4949': //hotel ciutat d'igualada
			//return "Montserrat Hotel & Training Center (Collbató)";
			return "Hotel América";
        break;
        case '5050': //hotel ciutat d'igualada
			//return "Montserrat Hotel & Training Center (Collbató)";
			return "Hotel Bruch";
        break;
		case 'Atalaya2015': //hotel Atalaya
            return "Hotel Atalaya";
        break;   
		case '12345'://hotel vejo
			return "Hotel Villa María ";			
		break;
        case '1000':
			
			return "Hotel América";
		break;
        case '2929':
            
            return "Hotel Juaneca";
        break;
	    case '1111':
			
			return "Hotel Sara De Ur";
		break;
		case '2011':
			return "Hotel Montserrat Hotel & Training Center (Collbató)";
		break;
		case '2030':
			return "Hotel la Carreta";
		break;
        case '0010':
            return "Hotel Husa Masia Bach";
            break;
        case 'z1':
            return "Zaragoza 1";
            break;
        case 'z2':
            return "Zaragoza 2";
            break;
        case '2':
            return "Hotel Mavi";
            break;
        case '5':
            return "Hotel Castillo de Montemayor";
            break;
			
        default:
		   
		   return _NOMBRE_EMP_;
		break;
		}
}

function email_hotel($h)
   {
   	switch($h){
        case '99999': //test            
		return "marctorraso@gmail.com";
        break;
        case '4949': //hotel ciutat d'igualada
			return "info@hotel-america.es";
			//return "marctorraso2@gmail.com";
        break;
        case '5050': //hotel ciutat d'igualada
			return "hotel@hotel-bruc.es";
			//return "marctorraso2@gmail.com";
        break;

		case 'Atalaya2015':
			return "reservas@hotelatalaya.es";
			break;
		case '12345'://hotel vejo
			return "Hotelvillamariacantabria@gmail.com";			
			//return "marctorraso@gmail.com";			
		break;
/*        case '1000':
			
			return "info@hotel-america.es";
		break;
		*/
        case '2929':
            
            return "recepcion@hoteljuaneca.es";
        break;
	    case '1111':
			//return "marctorraso@yahoo.es";
			return "info@saradeur.com";
		break;
		/*case '2011':
			return "bviamonte@eada.edu";
		break;*/
		case '2030':
			return "reservas@hotel-lacarreta.com";
		break;
        case '0010':
            return "reservas@hotelhusamasiabach.es";
            break;
        case '6666':
            return "Hotelvillamariacantabria@gmail.com";
            break;
        case 'z1':
            return "marctorraso2@gmail.com";
            break;
        case 'z2':
            return "marctorraso@yahoo.es";
            break;
        case '2':
            return "info@hotelmavi.es";
            break;
        case '5':
            return "reservas@hotelcastillodemontemayor.com";
            break;
        default:
		   
		   return EMAIL_MC;
		break;
	}
	
   }
  


function envia_mails_hotel()
  {
  	global $emp;   
	include 'class.phpmailer.php';
	include 'textos_mensajes.php';
    
    $tipus = tools::getValue('tipus');

    $aux=explode('@',tools::getValue('id_alta'));
		
	if($tipus!='porsche997' && $tipus!='porsche996' && $tipus!='_bferrari_' && $tipus!='_blamborghini_')
	  {
    	  $h=explode(':',$aux[1]);
    	  if($h[1]=='00' || $h[1]=='15'){
    		$aux[1]=$h[0].':00:00';
    	  }
    	  else if($h[1]=='30' || $h[1]=='45'){
    	    $aux[1]=$h[0].':30:00';
    	  }
      }
      else if ($tipus=='_bferrari_' || $tipus=='_blamborghini_')
      {   echo($tipus);
          $h=explode(':',$aux[1]);
          for($i=0;$i<=45;$i+=15)
          {
              echo('h1 :'.$h[1]);
              echo('i: '.$i);
            if((int)$h[1]==$i || (int)$h[1]==$i+7){$aux[1]=$h[0].':'.(($i>9)?$i:'0'.$i).':00';}
          }
      }  
	
	
	
	$mail = new PHPMailer();

    $mail->Host = "localhost";

    /****/
	if (strpos(tools::getValue('tipus'),'ruta_turistica')!==false) 
		$mail->From = EMAIL_RESERVAS_TURISMO;
	else 
		$mail->From = EMAIL_RESERVAS;

	$mail->FromName = _DOMINIO_EMP_;
	$mail->Subject = _DOMINIO_EMP_;
	
    $mail->AddBCC(_EMAIL_MC_,"oculto");
   
   
	$mail->AddBCC(tools::getValue('email1'),"oculto");
	
	
	$mail->AddBCC(email_hotel(str_replace(' ','',$_REQUEST['id_hotel'])  ),"oculto");

    
    $body= texto_reserva_hotel();
    
 
	
	$aux_ciudad=$_REQUEST['ciudad'];
	if(trim($aux_ciudad)=='')$aux_ciudad='Barcelona';
	$aux_ciudad=strtoupper($aux_ciudad );
	
	if ($aux_ciudad=='RUTAS_TURISTICAS')
	{
			$ciudad_visible=ciudad_ruta(tools::getValue('tipus'));			
	}
		
	
	$fecha_completa = explode(' ',tools::getValue('data_reserva'));
	$hora = $fecha_completa[1];
	$dia_ = implode('/',array_reverse(explode('-',$fecha_completa[0])));
	$body.= "<strong>Su reserva ha sido realizada con los siguientes datos</strong><br><br>";
    $body.= "<strong>Fecha Reserva: </strong>".$dia_." ".$hora.'<br>';
    $body.= "<strong> Direcci&oacute;n IP: </strong>".tools::getValue('ip').'<br>';	
	$body.= "<strong>Nombre piloto: </strong>".convert_caracters_hex(tools::getValue('pilot')).'<br>';
	$body.= "<strong>Apellidos piloto: </strong>".convert_caracters_hex(tools::getValue('apellidos_piloto')).'<br>';
	$body.= "<strong>Email piloto: </strong>".tools::getValue('email').'<br>';
	$body.= "<strong>Tel&eacute;fono piloto: </strong>".tools::getValue('telefon').'<br>';
	$body.= "<strong>Origen: </strong>".str_replace('_',' ',tools::getValue('origen')).'<br>';

	$body.= "<strong>Hotel: </strong>".nombre_hotel($_REQUEST['id_hotel']).'<br>';
	
	if(trim(tools::getValue('alojamiento_ad'))=='') $alojamiento='';        
	else if (tools::getValue('alojamiento_ad')=='0') $alojamiento = 'Alojamiento + Desayuno';
	else $alojamiento = 'Media Pensi&oacute;n';
	
	$body.= "<strong>Alojamiento: </strong>".$alojamiento.'<br>';
 
	if (trim(tools::getValue('fechaentrada'))!='') $body.= "<strong>Fecha de entrada: </strong>".tools::getValue('fechaentrada')."<br>";
	if (trim(tools::getValue('fechasalida'))!='') $body.= "<strong>Fecha de salida: </strong>".tools::getValue('fechasalida')."<br>";
	
	if (tools::getValue('es_spa')==='1') $body.= "<strong>Este vale dispone de SPA</strong><br>";
	if (trim(tools::getValue('persona_hotel'))!='') $body.= "<strong>Personal del hotel que realiz&oacute; la reserva: </strong>".utf8_decode(tools::getValue('persona_hotel'))."<br>";

	$body.= "<strong>Dia: </strong>".implode('/',array_reverse(explode('-',$aux[0]))).'<br>';
	$body.= "<strong>Hora: </strong>".$aux[1].'<br>';
    $body.= "<strong>Evento: </strong>".return_tipus_e(tools::getValue('tipo_vehiculo'),tools::getValue('km_ruta')).'<br>';
	$body.= "<strong>Nombre de la persona que regala: </strong>".convert_caracters_hex(tools::getValue('persona_regala')).'<br>';
	$body.= "<strong>Apellidos de la persona que regala: </strong>".convert_caracters_hex(tools::getValue('apellidos_persona_regala')).'<br>';
	$body.= "<strong>DNI persona que regala: </strong>".convert_caracters_hex(tools::getValue('nif')).'<br>';
	$body.= "<strong>Email persona que regala: </strong>".tools::getValue('email_regala').'<br>';
	$body.= "<strong>M&oacute;vil persona que regala: </strong>".tools::getValue('telefon_regala').'<br>';
	$textos_codigos = canvia_textos_codigo(tools::getValue('origen'));
	$body.= "<strong>".utf8_decode($textos_codigos[0]).": </strong>".tools::getValue('codigo_localizador').'<br>';
	if (!in_array(tools::getValue('origen'),array('CODIGO_ALFA','DOOPLAN','LA_TIENDA_MARCA','PLANEO','MOTORCLUBEXPERIENCE','DREAMCARSEXPERIENCE','HCCSPORTCARS','DAKOTABOX','WONDERBOX'))) 
		$body.= "<strong>".utf8_decode($textos_codigos[1]).": </strong>".tools::getValue('codigo_consumo').'<br>';

	$body.= "<strong>Ciudad: </strong>".$ciudad_visible.'<br>'; 
	$Observaciones = tools::getValue('Observaciones');
	$Observaciones = trim($Observaciones);

	if (in_array(tools::getValue('km'),array(14,40)))
	{
		if (substr($Observaciones,-1)!='-')	
			$Observaciones .= ' - ruta de ' . tools::getValue('km') . ' km. ';
		else $Observaciones .= ' ruta de ' . tools::getValue('km') . ' km. ';
			
	}		
	$body.= "<strong>Observaciones: </strong>".convert_caracters_hex($Observaciones).'<br>';
	
   	$plantilla=new PlantillaEmail();
	$body = $plantilla->getBodyEmail($body);
	unset($plantilla);

    $mail->Body = $body;

    $mail->IsHTML(true);

    $mail->Send();
    echo 'OK';

  }  
   

   

function seleccionar_plantilla_graella($tipus)
{
	if($tipus == '_buggy_')
	  include 'dies_graella4.php';
	else if($tipus=='_bferrari_' || $tipus=='_blamborghini_' || $tipus=='_bporsche_' || $tipus=='_bcorvette_')                                       
	  include 'dies_graella4.php';
	else 
	  include 'dies_graella.php';		
	
	return $array_hores;
}

function ciudad_ruta($tipo)
{
	$num_ruta = substr($tipo,-1);
	switch(intval($num_ruta)) 
	{
		case 1: 
			$ciudad_='Barcelona';
			break;	
		case 2:
			$ciudad_='Barcelona';
			break;
		case 3: 
			$ciudad_ = 'Sitges';
			break;
		case 4: 
			$ciudad_ = 'Montserrat';
			break;
		default:
			$ciudad_='';
	}	
	return $ciudad_;
}


function descripcion_ruta_turistica($ruta)
{
	switch($ruta)
	{
	case 'ruta_turistica1':
		return utf8_encode("Barcelona Paseo Marítimo.");
		break;
	case 'ruta_turistica2':
		return utf8_encode("Barcelona Sagrada Família");
		break;
	case 'ruta_turistica3':
		return 'Sitges';
		break;
	case 'ruta_turistica4':
		return 'Montserrat';
		break;
	}
}	

  
//Dada una reserva insertada, y un número de plazas (de 2 a 5), que dependerá
//de la ruta turística seleccionada, insertaremos tantas copias de la reserva 
//como plazas nos queden para completar dicho número.
function duplicado_reservas_turisticas($id_event,$plazas,$reserva_a_duplicar)
{	
	global $inst;
	$hores1=seleccionar_plantilla_graella(tools::getValue('tipus'));
	$hores=array();
	$i=0;
  
	foreach ($hores1 as $h=>$info)
	{
		if($h=='c' || !$h) continue;	
		if ($i%2) {$i++;continue;}
		else {$hores[$h]=$info;$i++;}	
	}
	
	$inicio_duplicacion=false;
	$insertados=0;
	$rs=array();
	//Para evitar inyecciones sql.
	foreach ($reserva_a_duplicar as $clave=>$campo)
	{
		$rs[$clave]=FuncionesSeguridad::seg($campo);
	}

	
	
	//Recorremos todo el calendario hasta encontrar la hora de la reserva
	//insertada.  
	$inserts = array();
	foreach($hores as $hora=>$info) 
	{
		$hora_tmp=explode('@',$id_event);
		$dia_event=$hora_tmp[0];
		$hora_event=$hora_tmp[1];
		//Si encontramos la hora de la reserva empezaremos la duplicación.
		if ($hora_event==$hora)
		{
			$inicio_duplicacion=true;
		}
		//Duplicaremos mientras no alcancemos el número de plazas asignado al
		//tipo de ruta turistica.
		else if ($inicio_duplicacion && $insertados<$plazas-1)
		{
//			//consulta comprobar si ya existe un registro con id_event = $id_event	
			$id_event_nuevo = $dia_event.'@'.$hora;
			$sql = ' SELECT count(*) cont FROM events'.$_REQUEST['ciudad'].' where  id_event="'.$id_event_nuevo.'"';
			$ocupado=$inst->executeS($sql);
	    	$rocupado=$ocupado[0];
	    	
	    	if ($rocupado['cont']>0) 
	    	{
	    		die('Error: No se pueden reservar '.$plazas.' plazas consecutivas.');
	    	}

			$sql='INSERT INTO `events'.$_REQUEST['ciudad'].'` (
		    id_event,id_event_ini,email ,telefon ,pilot,dia,tipus_event,persona_regala,email_persona_regala,
		    mobil_persona_regala,coches,codi_localtzador,codi_consum,Observaciones,
		    origen,plazas,email_confirm,data_reserva,data_caducitat_cupo,ip,cupon,nif,alojamiento,spa,persona_hotel,
		    apellidos_piloto,apellidos_persona_regala,fecha_entrada,fecha_salida)
		    VALUES ("'.
			$id_event_nuevo.'", "'.
			$id_event.'", "'.
			$rs['email'].'", "'.
			$rs['telefon'].'","'.
			$rs['pilot'].'","'.
			$aux[0].'","'.
			$rs['tipus_event'].'","'.
			$rs['persona_regala'].'","'.
			$rs['email_persona_regala'].'","'.
			$rs['mobil_persona_regala'].'","'.
			$rs['coches'].'","'.
			$rs['codi_localtzador'].'","'.         
			$rs['codi_consum'].'","'.
			$rs['Observaciones'].'","'.
			$rs['origen'].'","'.
			$rs['plazas'].'","'.
			$rs['email_confirm'].'","'.
			$rs['data_reserva'].'","'.
			$rs['data_caducitat_cupo'].'","'.
			$rs['ip'].'","'.
			$rs['cupon'].'","'.
			$rs['nif'].'","'.
			$rs['alojamiento'].'","'.
			$rs['spa'].'","'.
			$rs['persona_hotel'].'","'.
			$rs['apellidos_piloto'].'","'.
			$rs['apellidos_persona_regala'].'","'.
			$rs['fecha_entrada'].'","'.
			$rs['fecha_salida'].'");';
			
		    $inserts[]=$sql;
		    
		    $insertados++;
		}
		else if ($inicio_duplicacion) {break;}
			
	}
	
	//si todo ha ido bien insertaremos las reservas duplicadas.
	//$sql_primero = ' update  `events'.$_REQUEST['ciudad'].'` set id_event_ini = "'.$id_event.'" where id_event = "'.$id_event.'"';		
	
	foreach ($inserts as $insert)
	{
		$resulti=$inst->execute($insert);
	}
	if ($resulti) return('OK');
	else return 0;
 }	
 
 
 
 
 function comprobar_ampliaciones($localizador,$consumo)                
 {
	$inst=db::getInstanceOf();
	
	$sql=' select * 
		   from ampliaciones 
		   where  (
					trim(localizador)!="" and 
					"'.strtolower($localizador).'" like "a%" and 
					"'.strtolower($localizador).'" like concat("%",lower(localizador),"%" ) 
				  )';          
	
	if (trim($consumo)!='')
	{
		$sql.=' and (trim(consumo)!="" and 
					"'.strtolower($consumo).'" like "a%" and   
					"'.strtolower($consumo).'" like concat("%",lower(consumo),"%" )  
				  )';          
	}
	
	
	$res=$inst->executeS($sql);

	unset ($inst);
	
	return(count($res)?$res[0]['fecha']:'');
	
 }
 
 
 
 function existe_reserva_canjeada($localizador,$consumo,$ciudad)                                                      
 {
	$inst=db::getInstanceOf();
	
	$ciudades_all=array('barcelona','madrid','valencia','andalucia','cantabria');
	$ciudades=array();
	
	//Colocamos la ciudad actual al principio del array dado que será la primera que comprobaremos.
	$indice=array_search(strtolower($ciudad),$ciudades_all);  
	//la eliminamos del array.
	unset($ciudades_all[$indice]);  
	//la colocamos al principio.
	$ciudades=array_merge(array(strtolower($ciudad)),$ciudades_all);     
	
	
	$fecha_canjeado=false;
	
	foreach($ciudades as $c)   
	{  
		$sql=' select * 
			   from events'.(($c=='barcelona')?'':$c).' 
			   where  (
						"'.strtolower($localizador).'" like "a%" and 
						"'.strtolower($localizador).'" like concat("%",lower(codi_localtzador),"%" ) and
						lower(codi_localtzador) not like "a%" and 
						trim(codi_localtzador)!=""
					  )';          
		
		if (trim($consumo)!='')
		{
			$sql.=' and (
						"'.strtolower($consumo).'" like "a%" and   
						"'.strtolower($consumo).'" like concat("%",lower(codi_consum),"%" )  and
						lower(codi_consum) not like "a%" and 
						trim(codi_consum) != ""
					  )';          
		}
		
		$sql.='  and marcat="1" and fecha_canjeado is not null and fecha_canjeado!="0000-00-00 00:00:00" 
				order by fecha_canjeado desc';
		
		$res=$inst->executeS($sql);
		
		if(count($res))
		{
		//if (tools::getuserip()=='88.18.146.46') die('error '.$sql); 
			$fecha_canjeado=$res[0]['fecha_canjeado'];
			break;
		}
		
	}
	unset ($inst);
	return $fecha_canjeado;
	
 }


  
 function reserva_mismo_codigo($localizador,$consumo,$ciudad)                                                      
 {
	$inst=db::getInstanceOf();

	$sql=' select * 
		   from events'.$ciudad.' 
		   where  trim(codi_localtzador)!="" and "'.strtolower($localizador).'" = lower(codi_localtzador)  ';          
	
	if (trim($consumo)!='')
	{
		$sql.=' and trim(codi_consum)!="" and "'.strtolower($consumo).'" = lower(codi_consum)  ';          
	}
	
	$sql.=' 
			order by fecha_canjeado desc ';  
	//if (tools::getuserip()=='81.39.136.83')die('error '.$sql);
	$res=$inst->executeS($sql);
	unset ($inst);	
	return(count($res));
		
 }  


  
?>
 
 
