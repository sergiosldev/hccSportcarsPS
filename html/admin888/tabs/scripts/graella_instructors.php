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
	else if($_REQUEST['tipus']=='_bferrari_' || $_REQUEST['tipus']=='_blamborghini_' || $_REQUEST['tipus']=='formula')
	{
	  include 'dies_graella4.php';
	  //$tipo=str_replace('_','',str_replace('_b','',$tipo));
	}  
	else 
	  include 'dies_graella.php';

	  $array_hores_tmp = $array_hores;  
	  $array_hores = array();

//TIPO BAUTIZO
	if($_REQUEST['tipus_b'] == '_buggy_')
	  include 'dies_graella3.php';
	else if($_REQUEST['tipus_b']=='_bferrari_' || $_REQUEST['tipus_b']=='_blamborghini_' || $tipus=='formula')
	{
	  include 'dies_graella4.php';
	  //$tipo=str_replace('_','',str_replace('_b','',$tipo));
	}  
	else 
	  include 'dies_graella.php';

	$array_horesb = $array_hores;
	$array_hores = $array_hores_tmp;
  
  
    if ($_REQUEST['tipus_b']!='') //Caso de listado que incluye las rutas de bautizo y la de 20km (arreglaremos los arrayas para que 20km: mañanas, 7km:tardes).
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
			if($copia) $array_horesb[$hora]=$info;
			if($hora=='c') $copia=true;
		}
		
	}
  
  include_once 'functions.php';

define('TEMPS',$_REQUEST['data']); // Dia que li arriba
$libres=false;
$tipob = $_REQUEST['tipus_b'];
graella($array_hores,$array_horesb,$tipo,$tipob);
         
/*
 $hores array(hora,info) 
 $lliure array(hora)  
 */
 
function graella($hores,$horesbautizo,$tipo,$tipobautizo) {
  global $link,$persones,$libres;
    if ($tipobautizo=='') $tipos=array($tipo); //o bien deportivo con ruta 20km, o bien deportivo con ruta 7km
    else $tipos=array($tipo,$tipobautizo); //listado dónde, para el mismo deportivo, saldrán conjuntamente las parrillas para 7km y 20km.

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

		if ($tip!='formula')
		{
			$cabecera = array('Hora','Nombre Cliente',$tipo,'porsche','copiloto','Anulado');
			$anchos_columna = array(9,23,9,9,8,8);
		}
		else 
		{
			$cabecera = array('Hora','Nombre Cliente',$tipo,'copiloto','Anulado');
			$anchos_columna = array(9,23,9,8,8);
		}
		
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
		
		if ($tipobautizo=='' || $tip!=$tipobautizo) //si $tipobautizo tiene valor será el listado 20km + bautizo, y sólo mostraremos la cabecera 1 vez.
		{
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
		}

		$i=0;

		$j++;    ;
		$info=' ';
		//$tipus=$_REQUEST['tipus'];
		$tipus=$tip;
		$tarda='';
		$mati='#';
		$hs = ($tip==$tipobautizo)?$horesbautizo:$hores;
		foreach($hs as $hora=>$info) 
		{
		$_h=$info;
		
		$info='';
		
		$tipus=$tip;//$_REQUEST['tipus'];  
		$hora=str_replace('@','',$hora);
		if($hora=='c')
		{
		
		  $tarda='#';
		  $mati='';
		  continue ; 
		}

		// cas graella 1 sol cotxe
		// if(($_REQUEST['tipus']=='_porsche_' || $_REQUEST['tipus']=='_lotus_') && $i%2 ){
		if(($tip=='_porsche_' || $tip=='_lotus_') && $i%2 ){
			$i++;
			continue ; 
		}

		$sep=''; 
		$hora_bona=$hora;  


		//if($_REQUEST['tipus']=='_bferrari_' || $_REQUEST['tipus']=='_blamborghini_')
		if($tip=='_bferrari_' || $tip=='_blamborghini_'|| $tip=='_bporsche_'|| $tip=='_bcorvette_' || $tip=='formula')
		  $transform = 2;
		else $transform = 1;
		
		$hora = label_hora($hora, $persones, $transform);

		$t_aux='i.tipus_event="'.$tipus.'"';

	   // graellas dobles amb dos tipus d'events <<  si estreu aixo i es posen tipus queda com abans

	  if( $tipus=='ferrari' ){
		$t_aux='(i.tipus_event="ferrari" OR i.tipus_event="ferrari_porsche901") ';
	  } elseif($tipus=='lamborghini' ){
		$t_aux='(i.tipus_event="lamborghini_lotus" OR i.tipus_event="lamborghini") ';
	  }
		$tipo_reg = '';
	// fi graelles doblesvf
		if ($tipus=='formula')
		{
			$sql='SELECT i.*,0 as marca_bautizo FROM `events'.$_REQUEST['ciudad'].'` as i WHERE i.id_event="'.TEMPS.'@'.$hora_bona.'" AND '.$t_aux.'';	
		}
		else
		{
			$sql='SELECT i.*,b.marca as marca_bautizo FROM `events'.$_REQUEST['ciudad'].'` as i LEFT JOIN bautizos b ON i.id_event = b.id_event and i.tipus_event = b.tipus_event WHERE i.id_event="'.TEMPS.'@'.$hora_bona.'" AND '.$t_aux.'';
		}
		
		//echo($sql);
		$result=mysqli_query($link,$sql);
		if(mysqli_num_rows($result)) { // plaza ocupada
		  $r=mysqli_fetch_assoc($result);
		  $tipo_reg = $r['tipus_event'];
		  
		  
		  //width="12%" width="13%" width="13%"   width="15%"  width="17%"
		     if (trim($r['email_confirm'])!='')
				$cliente = $r['pilot'].' '.$r['apellidos_piloto'];
			 else $cliente='';	
		} else {
			$cliente = '';
		}

		$hora_cmp = $hora;
		//echo('hora '.$hora_cmp.' comparacion '.(strtotime($hora_cmp)==strtotime('12:00')));
		$estilos_especiales = false;
	/*    if (strtotime($hora_cmp) >= strtotime('12:00') and strtotime($hora_cmp)<strtotime('12:30') or 
			strtotime($hora_cmp) >= strtotime('14:30') and strtotime($hora_cmp)<strtotime('16:00') or 
			strtotime($hora_cmp) >= strtotime('19:30')
			) 
			 $estilos_especiales=true;  
	  */  
		
		//Llenamos los campos de los clientes:
		
		$objPHPExcel->setActiveSheetIndex($as)->setCellValue(chr($pc+1).$j, (($cliente!='no disponible')?$cliente:''));
		$objPHPExcel->getActiveSheet()->getStyle(chr($pc+1).$j.':'.chr($pc+count($cabecera)-1).$j)->applyFromArray($estilosTexto);
		if ($estilos_especiales)
			$objPHPExcel->getActiveSheet()->getStyle(chr($pc+1).$j.':'.chr($pc+count($cabecera)-1).$j)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB($prefijo_EXCEL5.'C5BE97');	

			
	   //Llenamos la columna Hora.
		//$hora_reducida = substr($hora,0,strlen($hora)-3);
		$hora_reducida = explode(':',$hora);
		$hora_reducida[0]=($hora_reducida[0]<10)?substr($hora_reducida[0],1):$hora_reducida[0];
		$objPHPExcel->setActiveSheetIndex($as)->setCellValue(chr($pc).$j,$hora_reducida[0].':'.$hora_reducida[1]);
		$objPHPExcel->getActiveSheet()->getStyle(chr($pc).$j)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
		$objPHPExcel->getActiveSheet()->getStyle(chr($pc).$j)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB($prefijo_EXCEL5.'B2A1C7');
		$objPHPExcel->getActiveSheet()->getStyle(chr($pc).$j)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);    

		
	 
		$i++;
		$j++;
		
		$j_anterior = $j-1;
		//$j_anterior+=2;
	  }
	 
/*
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
*/
	}

	
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
