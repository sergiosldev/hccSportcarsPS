<?

  function nombre_ciudad($provincia)
  {
	switch ($provincia)
	{
		case  '': return 'Igualada';break;
		case  'madrid': return 'La Cabrera';break;
		case  'valencia': return 'Chiva';break;
		case  'andalucia': return 'Montilla';break;
		case  'cantabria': return 'Reinosa';break;
		default:
			return 'Igualada';
	}
  }


  function GetUserIp()
    {
       $ip = "";
       if(isset($_SERVER)) {
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) 
          {
             $ip=$_SERVER['HTTP_CLIENT_IP'];
          } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
             $ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
          } else {
             $ip=$_SERVER['REMOTE_ADDR'];
          }
       } else {
         if ( getenv( 'HTTP_CLIENT_IP' ) ) {
           $ip = getenv( 'HTTP_CLIENT_IP' );
         } elseif ( getenv( 'HTTP_X_FORWARDED_FOR' ) ) {
           $ip = getenv( 'HTTP_X_FORWARDED_FOR' );
         } else {
           $ip = getenv( 'REMOTE_ADDR' );
      }
  } 
   // En algunos casos muy raros la ip es devuelta repetida dos veces separada por coma 
   if(strstr($ip,','))
    {
      $ip = array_shift(explode(',',$ip));
    }
   return $ip;
  } 

if(!isset($_REQUEST['ciudad']))$_REQUEST['ciudad']='';
//$_REQUEST['ciudad']='';
include('config_events_new.php');

$tipo = $_REQUEST['tipus'];

//TIPO 
	// BUGGY
	if($_REQUEST['tipus'] == '_buggy_')
	  include 'dies_graella3.php';
	else if($_REQUEST['tipus']=='_bferrari_' || $_REQUEST['tipus']=='_blamborghini_' || $_REQUEST['tipus']=='_bporsche_')
	{
	  include 'dies_graella4.php';
	  //$tipo=str_replace('_','',str_replace('_b','',$tipo));
	}  
	else 
	  include 'dies_graella.php';

	  $array_hores_tmp = $array_hores;  
	  $array_hores = array();

	  
	 //	echo('test'.$_REQUEST['tipus_b'] );
	  
//TIPO BAUTIZO
	
	//echo('test '.$_REQUEST['tipus_b']);
	if($_REQUEST['tipus_b'] == '_buggy_')
	  include 'dies_graella3.php';
	else if($_REQUEST['tipus_b']=='_bferrari_' || $_REQUEST['tipus_b']=='_blamborghini_'|| $_REQUEST['tipus_b']=='_bporsche_')
	{
	  include 'dies_graella4.php';
	  //$tipo=str_replace('_','',str_replace('_b','',$tipo));
	}  
	else 
	  //include 'dies_graella.php'; 24072014 
	  include 'dies_graella4.php';
	  //fin modif 24072014
	 $array_horesf=$array_hores;   // 24072014

	 /* 
	$array_horesb = $array_hores; //$array_horesb: calendario bautizos.
	$array_hores = $array_hores_tmp; //$array_hores: calendario ruta 20km
  
  
    if ($_REQUEST['tipus_b']!='') //Caso de listado que incluye las rutas de bautizo y la de 20km (arreglaremos los arrayas para que 20km: mañanas+tardes, 7km:tardes).
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
	
	//var_dump($array_horesf);die;
	//echo('<br><BR>');
	//var_dump($array_horesb);die;
  
  include_once 'functions.php';

define('TEMPS',$_REQUEST['data']); // Dia que li arriba
$libres=false;
$tipob = $_REQUEST['tipus_b'];
graella($array_horesf,$tipo,$tipob);
         
/*
 $hores array(hora,info) 
 $lliure array(hora)  
 */
 
function graella($hores,$tipo,$tipobautizo) {
  global $link,$persones,$libres;
	$hores_final = array();
	$tipos=array($tipo);
	/*
    if ($tipobautizo=='') $tipos=array($tipo); //o bien deportivo con ruta 20km, o bien deportivo con ruta 7km
    else $tipos=array($tipo,$tipobautizo); //listado dónde, para el mismo deportivo, saldrán conjuntamente las parrillas para 7km y 20km.
	*/
//var_dump($tipos);

	//Incluir la libreria PHPExcel 
		require_once '../../../phpexcel/Classes/PHPExcel.php';
		require_once "../../../phpexcel/Classes/PHPExcel/Writer/Excel2007.php";
		// Crea un nuevo objeto PHPExcel
		$objPHPExcel = new PHPExcel();
		 
		// Establecer propiedades
		$objPHPExcel->getProperties()->setCreator("Cattivo");
		$objPHPExcel->getProperties()->setLastModifiedBy("Cattivo");
		$objPHPExcel->getProperties()->setTitle("Listado de clienters por instructor");
		$objPHPExcel->getProperties()->setSubject("Listado de clientes");
		$objPHPExcel->getProperties()->setDescription("Listado de instructores");
		$objPHPExcel->getProperties()->setKeywords("Excel Office 2007 openxml php");
		$objPHPExcel->getProperties()->setCategory("Instructores");

	$j_anterior=1;
	
    foreach($tipos as $tip)
	{	

		$cabecera = array('Hora','Nombre Cliente',$tipo,'porsche','copiloto','Anulado');
		$anchos_columna = array(9,23,9,9,8,8);
		$i=0;
		$A=65;
		$pc = $A+1; //primera columna con datos.
	  
		$prefijo_EXCEL5 = 'FF'; //Sólo cuando abramos el documento con formato Excel5 en lugar de Excel2007.
	  
	  

		//Aplicar estilos

		$estilosCabecera = array(
			'font' => array(
				'bold' => true,
			),
			'alignment' => array(
				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
			),
			'borders' => array(
				'allborders' => array(
					'style' => PHPExcel_Style_Border::BORDER_THIN,
					'color' => array('argb' => '000000')
				)
				
			),
			'fill' => array(
				'type' => PHPExcel_Style_Fill::FILL_SOLID,
				'color' => array(
					'argb' => $prefijo_EXCEL5.'B8CCE4',
				)
			),
		);


		$estilosTexto = array(
			'font' => array(
				'bold' => false,
				'size' => 9,
			),
			'alignment' => array(
				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
			),
			'borders' => array(
				'allborders' => array(
					'style' => PHPExcel_Style_Border::BORDER_THIN,
					'color' => array('argb' => $prefijo_EXCEL5.'000000')
				)
				
			)
		);

		$estilosHora = array(
			'font' => array(
				'bold' => false,
			),
			'alignment' => array(
				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
			),
			'borders' => array(
				'allborders' => array(
					'style' => PHPExcel_Style_Border::BORDER_THIN,
					'color' => array('argb' => $prefijo_EXCEL5.'000000')
				)
				
			)
		);


		$estiloFecha = array(
			'font' => array(
				'bold' => true,
			),
			'alignment' => array(
				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
			)
			
		);


	  /* if ($tip==$tipobautizo) 
	   {
		$objPHPExcel->createSheet(1);	
		$as=1;
		$bautizo='Bautizo';
	   }
	   else {$as=0;$bautizo='';}
	  */
	   $as=0; //$as "Active Sheet" servirá cómo índice de hojas cuando, el listado de bautizos vaya lo queramos en otra hoja.	
	   $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(11);
		

		//$j=1;
		$j=$j_anterior;

		//*****************Cabecera.***************	
		$objPHPExcel->getActiveSheet()->getStyle(chr($pc+2).$j)->applyFromArray($estiloFecha);
		$objPHPExcel->setActiveSheetIndex($as)->setCellValue(chr($pc+2).$j,'DIA '.str_replace('/20','/',implode('/',array_reverse(explode('-',$_REQUEST['data'])))));

		$objPHPExcel->getActiveSheet()->getStyle(chr($pc+1).$j)->applyFromArray($estiloFecha);
		$objPHPExcel->setActiveSheetIndex($as)->setCellValue(chr($pc+1).$j,$bautizo);

		$j++;
		$objPHPExcel->getActiveSheet()->getStyle(chr($pc+2).$j)->applyFromArray($estiloFecha);
		//$objPHPExcel->setActiveSheetIndex($as)->setCellValue(chr($pc+2).$j,'Igualada');
		$objPHPExcel->setActiveSheetIndex($as)->setCellValue(chr($pc+2).$j,nombre_ciudad($_REQUEST['ciudad']));

		$j+=2;
		$objPHPExcel->getActiveSheet()->getStyle(chr($pc).$j.':'.chr($pc+count($cabecera)-1).$j)->applyFromArray($estilosCabecera);

		for ($l=0;$l<=count($cabecera);$l++)
		{
			$columna = chr($pc+$l);
			$objPHPExcel->getActiveSheet()->getColumnDimension($columna)->setWidth($anchos_columna[$l]);
		}

	
		//Llenamos los textos de la cabecera.
		foreach ($cabecera as $campo) 
		{
		$objPHPExcel->setActiveSheetIndex($as)->setCellValue(chr($pc+$i).$j, $campo);
		$i+=1;    
		}
		$rows = $j;
		
		//*************** Fin Cabecera. *****************
		
		$i=0;

		$j++;
		$info=' ';
		//$tipus=$_REQUEST['tipus'];
		//$tipus=$tip;
		$tarda='';
		$mati='#';
		//$hs = ($tip==$tipobautizo)?$horesbautizo:$hores;
		$hs=$hores;
		
		//$hs = $horesbautizo;
		foreach($hs as $hora=>$info) 
		{
			$_h=$info;
			
			$info='';
			
			$hora=str_replace('@','',$hora);
			if($hora=='c')
			{
			
			  $tarda='#';
			  $mati='';
			  continue ; 
			}
 
			// cas graella 1 sol cotxe

			//if(($tip=='_porsche_' || $tip=='_lotus_') && $i%2 ){
			if(( $tip=='_lotus_') && $i%2 ){
				$i++;
				continue ; 
			}

			$sep=''; 
			$hora_bona=$hora;  


			//if($_REQUEST['tipus']=='_bferrari_' || $_REQUEST['tipus']=='_blamborghini_')
			//if($tip=='_bferrari_' || $tip=='_blamborghini_')
			
				//$transform = 2;
			//else $transform = 1;
			//Por la mañana como sólo habrán datos de la ruta de 20km, convertiremos las horas según el formato de graella establecido para dicha ruta (lamborghini,ferrari,_porsche_)
			//Por la tarde, dado que se mezclaran los datos de las rutas de 20km y la de bautizo convertiremos al formato establecido para bautizoas (_blamborghini_,_bferrari_,_bporsche_)
			if ($tarda=='#')
				$hora = label_hora($hora, $persones, 2);
			else
				$hora = label_hora($hora, $persones, 1);

			//echo('mati '.$mati.' tarda '.$tarda.' hora '.$hora);
			
			$t_aux='i.tipus_event="'.$tip.'"';

		   // graellas dobles amb dos tipus d'events <<  si estreu aixo i es posen tipus queda com abans

		  if( $tip=='ferrari' )
		  {
			$t_aux='(i.tipus_event="ferrari" OR i.tipus_event="ferrari_porsche901" OR i.tipus_event="_bferrari_") ';
		  } 
		  elseif($tip=='lamborghini' )
		  {
			$t_aux='(i.tipus_event="lamborghini_lotus" OR i.tipus_event="lamborghini" OR i.tipus_event="_blamborghini_") ';
		  }
		  elseif($tip=='_porsche_' )
		  {
			$t_aux='(i.tipus_event="_porsche_" OR i.tipus_event="_bporsche_" or i.tipus_event="porsche") ';
		  }
		  elseif($tip=='_corvette_' )
	      {
			$t_aux='(i.tipus_event="_corvette_" OR i.tipus_event="_bcorvette_" or i.tipus_event="corvette") ';     
		  }		  
		  $tipo_reg = '';
		
		// fi graelles doblesvf

			$sql='SELECT i.*,b.marca as marca_bautizo FROM `events'.$_REQUEST['ciudad'].'` as i LEFT JOIN bautizos b ON i.id_event = b.id_event and i.tipus_event = b.tipus_event WHERE i.id_event="'.TEMPS.'@'.$hora_bona.'" AND '.$t_aux.'';
			$sql.=' AND trim(i.email_confirm)= (SELECT max(trim(i2.email_confirm)) FROM events'.$_REQUEST['ciudad'].' as i2 WHERE i2.id_event="'.TEMPS.'@'.$hora_bona.'" AND '.str_replace('i.','i2.',$t_aux).')';
			//echo($sql.'<br><br>');
				
			
			$result=mysqli_query($link,$sql);
			if(mysqli_num_rows($result)) 
			{ // plaza ocupada
			  $r=mysqli_fetch_assoc($result);
			  if(trim($r['email']).trim($r['email_confirm']).trim($r['email_persona_regala'])=='') continue;
			  $tipo_reg = $r['tipus_event'];
			  
			  
			  //width="12%" width="13%" width="13%"   width="15%"  width="17%"
			  if (trim($r['email_confirm'])!='')
				 //$cliente = utf8_encode($r['pilot']).' '.utf8_encode($r['apellidos_piloto']);
				 $cliente = $r['pilot'].' '.$r['apellidos_piloto'];
			  else $cliente='';	 
			} 
			else 
			{
				$cliente = '';
			}

			$estilos_especiales = false;
			


		   //Guardamos los datos del cliente en un array que combinará la ruta 20km con la de 7km.
			//Una vez guardada la información recorreremos el array para trasladarla al listado excel. 
			$hora_reducida = explode(':',$hora);
			$hora_reducida[0]=($hora_reducida[0]<10)?substr($hora_reducida[0],1):$hora_reducida[0];
		   //Llenamos la columna Hora.
		   //$hora_reducida = substr($hora,0,strlen($hora)-3);

			if (!($mati='#' && $tip==$tipobautizo))
				$hores_final[$i]=array('hora'=>$hora_reducida,'datos'=>array((($cliente!='no disponible')?$cliente:'') 
				//.'-'.$hora_bona
				));
			
		 
			$i++;
			$j++;
			
			$j_anterior = $j-1;
			//$j_anterior+=2;
	  }
	 
	}

	
		

		$n = count($hores_final);	
		//ordenamos el array hores_final por hora para visualizar los datos.
		/*
		for($i=1;$i<$n;$i++)
		{
			for($j=0;$j<($n-$i);$j++)
			{
				//var_dump($hores_final[$j]['hora']);echo('** <br>');
				//$horaf=explode(':',(string)$hores_final[$j]['hora']);
				$ahoraf=$hores_final[$j]['hora'];
				//var_dump($horaf);echo('<br>');
				$horaf = mktime(intval($ahoraf[0]),intval($ahoraf[1]),intval($ahoraf[2]),0,0,0);           

				//$horaf_sig=explode(':',(string)$hores_final[$j+1]['hora']);
				$ahoraf_sig=$hores_final[$j+1]['hora'];
				$horaf_sig=mktime(intval($ahoraf_sig[0]),intval($ahoraf_sig[1]),intval($ahoraf_sig[2]),0,0,0);           

				if($horaf>$horaf_sig)
				{
				$aux=$hores_final[$j+1];
				$hores_final[$j+1]=$hores_final[$j];
				$hores_final[$j]=$aux;
				
				
				}
			}
		}
		*/
		//echo('1');var_dump($hores_final);die;

	    $j=$rows+1;
		
		foreach ($hores_final as $ho)  
		{
			if ($ho == NULL) continue;
		//Lenamos el campo hora.
		    $hora = $ho['hora'];
			//echo('h ');var_dump($hora);die;
			array_pop($hora);
			$hora = implode(':',$hora);
			$objPHPExcel->setActiveSheetIndex($as)->setCellValue(chr($pc).$j,$hora);   
			$objPHPExcel->getActiveSheet()->getStyle(chr($pc).$j)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
			$objPHPExcel->getActiveSheet()->getStyle(chr($pc).$j)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB($prefijo_EXCEL5.'B2A1C7');
			$objPHPExcel->getActiveSheet()->getStyle(chr($pc).$j)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);    


			//Llenamos los campos de los clientes:
			
			$objPHPExcel->setActiveSheetIndex($as)->setCellValue(chr($pc+1).$j, $ho['datos'][0]);
			$objPHPExcel->getActiveSheet()->getStyle(chr($pc+1).$j.':'.chr($pc+count($cabecera)-1).$j)->applyFromArray($estilosTexto);
			if ($estilos_especiales)
				$objPHPExcel->getActiveSheet()->getStyle(chr($pc+1).$j.':'.chr($pc+count($cabecera)-1).$j)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB($prefijo_EXCEL5.'C5BE97');	

		$j++;
		}
		
		//Creamos 10 filas más para posibles clientes a apuntar.
		for ($m=0;$m<10;$m++)
		{
			$objPHPExcel->setActiveSheetIndex($as)->setCellValue(chr($pc).($j+$m),'');   
			$objPHPExcel->getActiveSheet()->getStyle(chr($pc).($j+$m))->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
			$objPHPExcel->getActiveSheet()->getStyle(chr($pc).($j+$m))->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB($prefijo_EXCEL5.'B2A1C7');
			$objPHPExcel->getActiveSheet()->getStyle(chr($pc).($j+$m))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);    
			
			$objPHPExcel->setActiveSheetIndex($as)->setCellValue(chr($pc+1).($j+$m), '');
			$objPHPExcel->getActiveSheet()->getStyle(chr($pc+1).($j+$m).':'.chr($pc+count($cabecera)-1).($j+$m))->applyFromArray($estilosTexto);
			if ($estilos_especiales)
				$objPHPExcel->getActiveSheet()->getStyle(chr($pc+1).($j+$m).':'.chr($pc+count($cabecera)-1).($j+$m))->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB($prefijo_EXCEL5.'C5BE97');	
			
		}

		$j+=10;

		
		
	

	//Llenamos el pie de página.
		$j++;
		$pie = array('Instructor','Total','Firma instructor','Firma organizador');
		for ($k=0;$k<count($pie)-2;$k++)
		{
		 for ($l=0;$l<2;$l++)       
			{
			$objPHPExcel->setActiveSheetIndex($as)->setCellValue(chr($pc+$l).($j+$k),($l==0)?$pie[$k]:'');
			$objPHPExcel->getActiveSheet()->getStyle(chr($pc+$l).($j+$k))->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
			$objPHPExcel->getActiveSheet()->getStyle(chr($pc+$l).($j+$k))->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB($prefijo_EXCEL5.'FCD5B4');
			}
		}
		$j+=4;
		$objPHPExcel->setActiveSheetIndex($as)->setCellValue(chr($pc+1).($j),$pie[count($pie)-2]);
		$objPHPExcel->setActiveSheetIndex($as)->setCellValue(chr($pc+2).($j),$pie[count($pie)-1]);
	
	
	$objPHPExcel->setActiveSheetIndex(0);
	$objPHPExcel->getActiveSheet()->setTitle(str_replace('_','',$_REQUEST['tipus']));

	$objPHPExcel->getActiveSheet()->getSheetView()->setZoomScale(150);


	// Establecer la hoja activa, para que cuando se abra el documento se muestre primero.
	//$objPHPExcel->setActiveSheetIndex(1);
	//$objPHPExcel->getActiveSheet()->setTitle('Bautizo '.str_replace('_','',str_replace('_b','',$_REQUEST['tipus_b'])));
	
	
	$objPHPExcel->getActiveSheet()->getSheetView()->setZoomScale(150);
//die;
    $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5'); 
    $nombre_tmp=GetUserIp().'-'.$_REQUEST['ciudad'].'-'.$_REQUEST['tipus'].'-'.$_REQUEST['data'].'-'.uniqid();
    $objWriter->save('../../../listados/'.$nombre_tmp.'.xls');
    $content  = file_get_contents('../../../listados/'.$nombre_tmp.'.xls');
    unlink('../../../listados/'.$nombre_tmp.'.xls');
	header("Content-type: application/ms-excel");    
	header("Content-Disposition: attachment; filename=listado_instructor.xls");
    header("Pragma: no-cache");
    header("Expires: 0");
    echo($content);
   
	//exit;   
}
?>
