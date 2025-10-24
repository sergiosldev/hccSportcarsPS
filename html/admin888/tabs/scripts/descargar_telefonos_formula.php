<?php

include('config_events_new.php');
$sql='';
  
  $seleccion_piloto = false;
  $seleccion_persona_regala = false;

  if ($_REQUEST['sel_cliente']!='') 
	{
		 switch($_REQUEST['sel_cliente'])
		 {
			case 'telef_piloto': 
				$seleccion_piloto=true;
				break;
			case 'telef_persona_regala': 
				$seleccion_persona_regala=true;
				break;
			default:
		}
	}
//var_dump($_REQUEST);
  
  if(isset($_REQUEST['telefons_all']))
  {    
	  $where1=' where (substr(trim(telefon),1,1)!=9 or substr(trim(mobil_persona_regala),1,1)!=9)';
	  $where2=' where (substr(trim(telefon),1,1)!=9 or substr(trim(mobil_persona_regala),1,1)!=9)';
	  $where3=' where (substr(trim(telefon),1,1)!=9 or substr(trim(mobil_persona_regala),1,1)!=9)';
	  $where4=' where (substr(trim(telefon),1,1)!=9 or substr(trim(mobil_persona_regala),1,1)!=9)';
	  $where5=' where (substr(trim(telefon),1,1)!=9 or substr(trim(mobil_persona_regala),1,1)!=9)';
	  $where6=' where (substr(trim(telefon),1,1)!=9 or substr(trim(mobil_persona_regala),1,1)!=9)';

	  $where1.='(eve.tipus_event="formula")';
	  $where2.='(em.tipus_event="formula")';
	  $where3.='(ev.tipus_event="formula")';
	  $where4.='(ea.tipus_event="formula")';
	  $where5.='(es.tipus_event="formula")';
	  $where6.='(ez.tipus_event="formula")';
	  
		
	  if ($_REQUEST['fdesde']!='') 
		{
		 $where1 .=  ' and date(substring(eve.id_event,1,10))>=date("'.$_REQUEST['fdesde'].'")';         
		 $where2 .=  ' and date(substring(em.id_event,1,10))>=date("'.$_REQUEST['fdesde'].'")';   
		 $where3 .=  ' and date(substring(ev.id_event,1,10))>=date("'.$_REQUEST['fdesde'].'")';   
		 $where4 .=  ' and date(substring(ea.id_event,1,10))>=date("'.$_REQUEST['fdesde'].'")';
		 $where5 .=  ' and date(substring(es.id_event,1,10))>=date("'.$_REQUEST['fdesde'].'")';
		 $where6 .=  ' and date(substring(ez.id_event,1,10))>=date("'.$_REQUEST['fdesde'].'")';
		}
	  if ($_REQUEST['fhasta']!='') 
		{
		 $where1 .=  ' and date(substring(eve.id_event,1,10))<=date("'.$_REQUEST['fhasta'].'")';
		 $where2 .=  ' and date(substring(em.id_event,1,10))<=date("'.$_REQUEST['fhasta'].'")';
		 $where3 .=  ' and date(substring(ev.id_event,1,10))<=date("'.$_REQUEST['fhasta'].'")';
		 $where4 .=  ' and date(substring(ea.id_event,1,10))<=date("'.$_REQUEST['fhasta'].'")';
		 $where5 .=  ' and date(substring(es.id_event,1,10))<=date("'.$_REQUEST['fhasta'].'")';
		 $where6 .=  ' and date(substring(ez.id_event,1,10))<=date("'.$_REQUEST['fhasta'].'")';
		} 


	  if ($_REQUEST['hdesde']!='' && $_REQUEST['hdesde']!='0') 
		{

		$where1 .=  ' and concat(substring(eve.id_event,1,10),\' \',substring(eve.id_event,12,5)) >= "'.$_REQUEST['fdesde'].' '.$_REQUEST['hdesde'].'"';
		$where2 .=  ' and concat(substring(em.id_event,1,10),\' \',substring(em.id_event,12,5)) >= "'.$_REQUEST['fdesde'].' '.$_REQUEST['hdesde'].'"';
		$where3 .=  ' and concat(substring(ev.id_event,1,10),\' \',substring(ev.id_event,12,5)) >= "'.$_REQUEST['fdesde'].' '.$_REQUEST['hdesde'].'"';
		$where4 .=  ' and concat(substring(ea.id_event,1,10),\' \',substring(ea.id_event,12,5)) >= "'.$_REQUEST['fdesde'].' '.$_REQUEST['hdesde'].'"';
		$where5 .=  ' and concat(substring(es.id_event,1,10),\' \',substring(es.id_event,12,5)) >= "'.$_REQUEST['fdesde'].' '.$_REQUEST['hdesde'].'"';
		$where6 .=  ' and concat(substring(ez.id_event,1,10),\' \',substring(ez.id_event,12,5)) >= "'.$_REQUEST['fdesde'].' '.$_REQUEST['hdesde'].'"';

		}
	  if ($_REQUEST['hhasta']!='' && $_REQUEST['hhasta']!='0')   
		{
		$where1 .=  ' and concat(substring(eve.id_event,1,10),\' \',substring(eve.id_event,12,5)) <= "'.$_REQUEST['fhasta'].' '.$_REQUEST['hhasta'].'"';
		$where2 .=  ' and concat(substring(em.id_event,1,10),\' \',substring(em.id_event,12,5)) <= "'.$_REQUEST['fhasta'].' '.$_REQUEST['hhasta'].'"';
		$where3 .=  ' and concat(substring(ev.id_event,1,10),\' \',substring(ev.id_event,12,5)) <= "'.$_REQUEST['fhasta'].' '.$_REQUEST['hhasta'].'"';
		$where4 .=  ' and concat(substring(ea.id_event,1,10),\' \',substring(ea.id_event,12,5)) <= "'.$_REQUEST['fhasta'].' '.$_REQUEST['hhasta'].'"';
		$where5 .=  ' and concat(substring(es.id_event,1,10),\' \',substring(es.id_event,12,5)) <= "'.$_REQUEST['fhasta'].' '.$_REQUEST['hhasta'].'"';
		$where6 .=  ' and concat(substring(ez.id_event,1,10),\' \',substring(ez.id_event,12,5)) <= "'.$_REQUEST['fhasta'].' '.$_REQUEST['hhasta'].'"';
		
		} 
  
	  $sql='
	  
	  SELECT pilot,telefon,persona_regala,mobil_persona_regala from eventscircuitovendrell eve '.$where1.'
	  UNION ALL
	  SELECT pilot,telefon,persona_regala,mobil_persona_regala from eventscircuitomoradebre em '.$where2.' 
	  UNION ALL
	  SELECT pilot,telefon,persona_regala,mobil_persona_regala from eventscircuitovalencia ev '.$where3.' 
	  UNION ALL
	  SELECT pilot,telefon,persona_regala,mobil_persona_regala from eventscircuitoandalucia ea '.$where4.' 
	  UNION ALL
	  SELECT pilot,telefon,persona_regala,mobil_persona_regala from eventscircuitosegovia es '.$where5.'         
	  UNION ALL
	  SELECT pilot,telefon,persona_regala,mobil_persona_regala from eventscircuitozaragoza ez '.$where5.'         
	  ';		
		
  //die($sql);
  $result=mysqli_query($link,$sql); 
} 


elseif(isset($_REQUEST['telefons_circuito_ven']))
{
	$where=' where (substr(trim(telefon),1,1)!=9 or substr(trim(mobil_persona_regala),1,1)!=9)';

	if ($_REQUEST['fdesde']!='') $where .=  ' and date(substring(id_event,1,10))>=date("'.$_REQUEST['fdesde'].'")';
	if ($_REQUEST['fhasta']!='') $where .=  ' and date(substring(id_event,1,10))<=date("'.$_REQUEST['fhasta'].'")';
	if ($_REQUEST['hdesde']!='' && $_REQUEST['hdesde']!='0') 
		$where .=  ' and concat(substring(id_event,1,10),\' \',substring(id_event,12,5)) >= "'.$_REQUEST['fdesde'].' '.$_REQUEST['hdesde'].'"';
	if ($_REQUEST['hhasta']!='' && $_REQUEST['hhasta']!='0') 
		$where .=  ' and concat(substring(id_event,1,10),\' \',substring(id_event,12,5)) <= "'.$_REQUEST['fhasta'].' '.$_REQUEST['hhasta'].'"';
    
	$sql='
	SELECT pilot,telefon,persona_regala,mobil_persona_regala from eventscircuitovendrell '.$where.' and tipus_event="formula" ';
	//die($sql);
	$result=mysqli_query($link,$sql);
}
elseif(isset($_REQUEST['telefons_circuito_mor']))
{
	$where=' where (substr(trim(telefon),1,1)!=9 or substr(trim(mobil_persona_regala),1,1)!=9)';

	if ($_REQUEST['fdesde']!='') $where .=  ' and date(substring(id_event,1,10))>=date("'.$_REQUEST['fdesde'].'")';
	if ($_REQUEST['fhasta']!='') $where .=  ' and date(substring(id_event,1,10))<=date("'.$_REQUEST['fhasta'].'")';
	if ($_REQUEST['hdesde']!='' && $_REQUEST['hdesde']!='0') 
		$where .=  ' and concat(substring(id_event,1,10),\' \',substring(id_event,12,5)) >= "'.$_REQUEST['fdesde'].' '.$_REQUEST['hdesde'].'"';
	if ($_REQUEST['hhasta']!='' && $_REQUEST['hhasta']!='0') 
		$where .=  ' and concat(substring(id_event,1,10),\' \',substring(id_event,12,5)) <= "'.$_REQUEST['fhasta'].' '.$_REQUEST['hhasta'].'"';
    
	$sql='
	SELECT pilot,telefon,persona_regala,mobil_persona_regala from eventscircuitomoradebre '.$where.' and tipus_event="formula" ';
	//die($sql);
	$result=mysqli_query($link,$sql);
}
elseif(isset($_REQUEST['telefons_circuito_zar']))
{
	$where=' where (substr(trim(telefon),1,1)!=9 or substr(trim(mobil_persona_regala),1,1)!=9)';

	if ($_REQUEST['fdesde']!='') $where .=  ' and date(substring(id_event,1,10))>=date("'.$_REQUEST['fdesde'].'")';
	if ($_REQUEST['fhasta']!='') $where .=  ' and date(substring(id_event,1,10))<=date("'.$_REQUEST['fhasta'].'")';
	if ($_REQUEST['hdesde']!='' && $_REQUEST['hdesde']!='0') 
		$where .=  ' and concat(substring(id_event,1,10),\' \',substring(id_event,12,5)) >= "'.$_REQUEST['fdesde'].' '.$_REQUEST['hdesde'].'"';
	if ($_REQUEST['hhasta']!='' && $_REQUEST['hhasta']!='0') 
		$where .=  ' and concat(substring(id_event,1,10),\' \',substring(id_event,12,5)) <= "'.$_REQUEST['fhasta'].' '.$_REQUEST['hhasta'].'"';
    
	$sql='
	SELECT pilot,telefon,persona_regala,mobil_persona_regala from eventscircuitozaragoza '.$where.' and tipus_event="formula" ';
	//die($sql);
	$result=mysqli_query($link,$sql);
}
elseif(isset($_REQUEST['telefons_circuito_seg']))
{
	$where=' where (substr(trim(telefon),1,1)!=9 or substr(trim(mobil_persona_regala),1,1)!=9)';

	if ($_REQUEST['fdesde']!='') $where .=  ' and date(substring(id_event,1,10))>=date("'.$_REQUEST['fdesde'].'")';
	if ($_REQUEST['fhasta']!='') $where .=  ' and date(substring(id_event,1,10))<=date("'.$_REQUEST['fhasta'].'")';
	if ($_REQUEST['hdesde']!='' && $_REQUEST['hdesde']!='0') 
		$where .=  ' and concat(substring(id_event,1,10),\' \',substring(id_event,12,5)) >= "'.$_REQUEST['fdesde'].' '.$_REQUEST['hdesde'].'"';
	if ($_REQUEST['hhasta']!='' && $_REQUEST['hhasta']!='0') 
		$where .=  ' and concat(substring(id_event,1,10),\' \',substring(id_event,12,5)) <= "'.$_REQUEST['fhasta'].' '.$_REQUEST['hhasta'].'"';
    
	$sql='
	SELECT pilot,telefon,persona_regala,mobil_persona_regala from eventscircuitosegovia'.$where.' and tipus_event="formula" ';
	//die($sql);
	$result=mysqli_query($link,$sql);
}
elseif(isset($_REQUEST['telefons_circuito_val']))
{
	$where=' where (substr(trim(telefon),1,1)!=9 or substr(trim(mobil_persona_regala),1,1)!=9)';

	if ($_REQUEST['fdesde']!='') $where .=  ' and date(substring(id_event,1,10))>=date("'.$_REQUEST['fdesde'].'")';
	if ($_REQUEST['fhasta']!='') $where .=  ' and date(substring(id_event,1,10))<=date("'.$_REQUEST['fhasta'].'")';
	if ($_REQUEST['hdesde']!='' && $_REQUEST['hdesde']!='0') 
		$where .=  ' and concat(substring(id_event,1,10),\' \',substring(id_event,12,5)) >= "'.$_REQUEST['fdesde'].' '.$_REQUEST['hdesde'].'"';
	if ($_REQUEST['hhasta']!='' && $_REQUEST['hhasta']!='0') 
		$where .=  ' and concat(substring(id_event,1,10),\' \',substring(id_event,12,5)) <= "'.$_REQUEST['fhasta'].' '.$_REQUEST['hhasta'].'"';
    
	$sql='
	SELECT pilot,telefon,persona_regala,mobil_persona_regala from eventscircuitovalencia '.$where.' and tipus_event="formula" ';
	//die($sql);
	$result=mysqli_query($link,$sql);
}
elseif(isset($_REQUEST['telefons_circuito_and']))
{
	$where=' where (substr(trim(telefon),1,1)!=9 or substr(trim(mobil_persona_regala),1,1)!=9)';

	if ($_REQUEST['fdesde']!='') $where .=  ' and date(substring(id_event,1,10))>=date("'.$_REQUEST['fdesde'].'")';
	if ($_REQUEST['fhasta']!='') $where .=  ' and date(substring(id_event,1,10))<=date("'.$_REQUEST['fhasta'].'")';
	if ($_REQUEST['hdesde']!='' && $_REQUEST['hdesde']!='0') 
		$where .=  ' and concat(substring(id_event,1,10),\' \',substring(id_event,12,5)) >= "'.$_REQUEST['fdesde'].' '.$_REQUEST['hdesde'].'"';
	if ($_REQUEST['hhasta']!='' && $_REQUEST['hhasta']!='0') 
		$where .=  ' and concat(substring(id_event,1,10),\' \',substring(id_event,12,5)) <= "'.$_REQUEST['fhasta'].' '.$_REQUEST['hhasta'].'"';
    
	$sql='
	SELECT pilot,telefon,persona_regala,mobil_persona_regala from eventscircuitoandalucia '.$where.' and tipus_event="formula" ';
	//die($sql);
	$result=mysqli_query($link,$sql);
}
else 
{ 	
  // $sql='SELECT id_event,email_persona_regala,email,email_confirm   from events where id_event like "'.$_REQUEST['telefons_day'].'%" ';
  $sql='SELECT pilot,telefon,persona_regala,mobil_persona_regala  from events'.$_REQUEST['ciudad'].' where id_event like "'.$_REQUEST['telefons_day'].'%" AND '.$t_aux.'';                              
  $result=mysqli_query($link,$sql);     
 
}  
   

   //die($sql);
   

	$telefons=array();
	$telefons['660024877']='Alfonso Morales';
//	$telefons['680540771']='Loren Quiñones';
	
 while($r=mysqli_fetch_object($result))
	 {
	 	 $actualizar_telefon_pilot=false;
	 	 $actualizar_telefon_persona_regala=false;

		 //if(isset($r->telefon) && !isset($telefons[trim($r->telefon)]) && validar_telefono($r->telefon))
		 if(isset($r->telefon) && !isset($telefons[trim($r->telefon)]))
		 {
			$actualizar_telefon_pilot = true;
		 }	  	
		 
		 //if(isset($r->mobil_persona_regala) && !isset($telefons[trim($r->mobil_persona_regala)]) && validar_telefono($r->mobil_persona_regala))		 
		 if(isset($r->mobil_persona_regala) && !isset($telefons[trim($r->mobil_persona_regala)]) )		 
		 {     
			$actualizar_telefon_persona_regala = true;  	
		 }
	 	 
	 	 /*
	 	 if ($r->telefon=='687623549' or $r->mobil_persona_regala=='687623549')
	 	 {
	 	 	echo('');
	 	 }
	 	 */
	 	 
		 if ($seleccion_piloto)
		 {
			if ($actualizar_telefon_pilot)
			{
				$telefons[trim($r->telefon)]=$r->pilot;
			}
			else if ($actualizar_telefon_persona_regala)
			{
				$telefons[trim($r->mobil_persona_regala)]=$r->persona_regala;
			}
		 }
		 else if ($seleccion_persona_regala)
		 {
			if ($actualizar_telefon_persona_regala)
			{
				$telefons[trim($r->mobil_persona_regala)]=$r->persona_regala;
			}
			else if ($actualizar_telefon_pilot)
			{
				$telefons[trim($r->telefon)]=$r->pilot;
			}
		 }
		 //todos los teléfonos.
		 else
		 {
			 //si los teléfonos del piloto i la persona que regala son iguales, pondremos siempre el nombre de la persona que regala.
			 if ($actualizar_telefon_pilot && $actualizar_telefon_persona_regala && trim($r->telefon)==trim($r->mobil_persona_regala))
			 {
				$telefons[trim($r->telefon)]=$r->persona_regala;
			 }
			 
			 else 
			 {
				 if ($actualizar_telefon_pilot)	 	 
				 {
					$telefons[trim($r->telefon)]=$r->pilot;
				 }
				 if ($actualizar_telefon_persona_regala)
				 {
					$telefons[trim($r->mobil_persona_regala)]=$r->persona_regala;
				 }
			 }		 
		 }
	/*	 
		 else
		 {
			 if(isset($r->telefon) && !isset($telefons[trim($r->telefon)]) && validar_telefono($r->telefon))
			 {
				$actualizar_telefon_pilot = true;
			 }	  	
			 
			 if(isset($r->mobil_persona_regala) && !isset($telefons[trim($r->mobil_persona_regala)]) && validar_telefono($r->mobil_persona_regala))		 
			 {     
				$actualizar_telefon_persona_regala = true;  	
			 }
		 
		 
			 //si los teléfonos del piloto i la persona que regala son iguales, pondremos siempre el nombre de la persona que regala.
			 if ($actualizar_telefon_pilot && $actualizar_telefon_persona_regala && trim($r->telefon)==trim($r->mobil_persona_regala))
			 {
				$telefons[trim($r->telefon)]=$r->persona_regala;
			 }
			 
			 else 
			 {
				 if ($actualizar_telefon_pilot)	 	 
				 {
					$telefons[trim($r->telefon)]=$r->pilot;
				 }
				 if ($actualizar_telefon_persona_regala)
				 {
					$telefons[trim($r->mobil_persona_regala)]=$r->persona_regala;
				 }
			 }		 
		 }
*/ 
	 }
  
	 
	function validar_telefono($numeros)
	{
	    $numeros=preg_replace("/[^0-9]/","",$numeros);//quitamos la basura
	    $primer_numero=substr($numeros,0,1); // muy obio el promer digito
	    $total=strlen($numeros);// el total de digitos
	    if(($primer_numero==6  || $primer_numero==7) && $total==9) // la validacion tambien obvia
	        return true;
	    else return false;
	} 	 
	 
	   

	//Incluir la libreria PHPExcel 
	require_once '../../../phpexcel/Classes/PHPExcel.php';
	require_once "../../../phpexcel/Classes/PHPExcel/Writer/Excel2007.php";
	// Crea un nuevo objeto PHPExcel
	$objPHPExcel = new PHPExcel();
	 
	// Establecer propiedades
	$objPHPExcel->getProperties()->setCreator("Cattivo");
	$objPHPExcel->getProperties()->setLastModifiedBy("Cattivo");
	$objPHPExcel->getProperties()->setTitle("Listado de telefonos");
	$objPHPExcel->getProperties()->setSubject("Listado de telefonos");
	$objPHPExcel->getProperties()->setDescription("Listado de telefonos");
	$objPHPExcel->getProperties()->setKeywords("Excel Office 2007 openxml php");
	$objPHPExcel->getProperties()->setCategory("Telefonos"); 
	
	
	$anchos_columna = array(9,23);
	$i=0;
	$A=65;
	//$pc = $A+1; //primera columna con datos.
	$pc = $A;
	$prefijo_EXCEL5 = 'FF'; //Sólo cuando abramos el documento con formato Excel5 en lugar de Excel2007.
	
	$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(11);
	
	//**header("Content-type: application/ms-excel");       
	//**header("Content-Disposition: attachment; filename=telefonos.xls");   
  
  //echo $sql."\n\r";
  //echo 'Numero contactos:'.count($telefons)."\r\n\r\n";                                                                                                                       
   $j=1;		
   $objPHPExcel->setActiveSheetIndex(0)->setCellValue(chr($pc).$j,'cont');
   $objPHPExcel->setActiveSheetIndex(0)->setCellValue(chr($pc+1).$j,count($telefons));
  

   $j=2;




   
   //var_dump($telefons);die;
   foreach($telefons as $k=>$v)
   {
  	if (trim($v)=='') $sv = 'cliente';
  	else $sv = $v;
  	//$sv=utf8_decode($sv);
  	$tmp=explode(' ',$sv);
  	$tmp=$tmp[0];
    //echo $k.chr(9).$sv.chr(9).$tmp."  \r\n";
  	if (trim($tmp)=='') $tmp='cliente';
  	$objPHPExcel->setActiveSheetIndex(0)->setCellValue(chr($pc).$j,$k);
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue(chr($pc+1).$j,$tmp);
    $j++;
   }               
 
  
	$objPHPExcel->getActiveSheet()->getSheetView()->setZoomScale(100);

    $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5'); 
    $nombre_tmp=uniqid();
    $objWriter->save('../../../listados/'.$nombre_tmp.'.xls');
    $content  = file_get_contents('../../../listados/'.$nombre_tmp.'.xls');
	
    unlink('../../../listados/'.$nombre_tmp.'.xls');
	header("Content-type: application/ms-excel");    
	header("Content-Disposition: attachment; filename=listado_telefonos.xls");   
    header("Pragma: no-cache");
    header("Expires: 0");
    echo($content);
  
  
  
?>


