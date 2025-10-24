<?php
	$er=error_reporting();
	error_reporting(0);
	$num_listados = intval($_REQUEST['num_listados']);
	define('__PS_BASE_URI__','/');  
	include_once(dirname(__FILE__).'/../../../config/defines.inc.php');
	require_once(dirname(__FILE__).'/../../../fpdf/fpdf.php');
	require_once(dirname(__FILE__).'/../../../fpdf/fpdi.php');
	require_once(dirname(__FILE__).'/../../../fpdf/ConcatPdf.php');
	

	$pdf = new ConcatPdf ();
	$archivos = array();
	for ($i=0;$i<$num_listados;$i++)
	{
		$archivos[]=dirname(__FILE__).'/../listados_eventos/listado'.($i+1).'.pdf';	
	}

	  

	$pdf->setFiles($archivos);

	$pdf->concat();
	$file_concat=dirname(__FILE__).'/../listados_eventos/concat'.time().'.pdf';
	$pdf->Output($file_concat, 'F');

	foreach ($archivos as $a)
	{
	  unlink($a);
	}
  
  //unlink(dirname(__FILE__).'/../listados_eventos/concat_html_test.pdf');  
   
   
   //$content  = file_get_contents(dirname(__FILE__).'/../listados_eventos/concat_html_test.pdf');  
   //var_dump($content);die;
   header_remove();		
   header('location: '._BASE_URL_.'/admin888/tabs/scripts/abrir_pdf.php?filename='.$file_concat); 
   die; 
   
   header("Content-type: application/pdf");    
   header("Content-Disposition: attachment; filename=listado.pdf");
   header("Pragma: no-cache");
   header("Expires: 0");
   echo($content);