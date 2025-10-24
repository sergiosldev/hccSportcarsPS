<?php
require_once (dirname(__FILE__) . '/../../../html2pdf/html2pdf.class.php');
require_once (dirname(__FILE__) . '/../../../classes/PDF_AutoPrint.php');
//var_dump($_REQUEST);die;
$cad=$_REQUEST['gf'];
if($_REQUEST['horas']=='m') 
 $cad.=' <style>.ta{display:none;}</style>';
elseif($_REQUEST['horas']=='t')  
 $cad.=' <style>.ma{display:none;}</style>';
 else {}
 
 //die($cad);
 // header("Content-type: application/octet-stream");
$cad=convert_caracters_hex($cad);
//$cad='<page backbottom="0px" pageset="old">'.$cad.'</page>';
	$cad=convert_caracters_hex($cad);
	$cad='<page backtop="70px" backbottom="0px">'.$cad.'</page>';



 
 //$cad  = file_get_contents('graella_organizadores.html');
  
  //$html2pdf = new HTML2PDF('P', 'A4', 'fr',true,'UTF-8',array(5,5,0,8));    
  $html2pdf = new HTML2PDF('P', 'A4', 'fr');    
  
  $html2pdf->setTestTdInOnePage(true);
  $html2pdf->pdf->SetDisplayMode('real'); //fullpage, fullwidth, real, default: uses viewer default mode
  //$html2pdf -> writeHTML($cad, true);   
  $html2pdf -> writeHTML($cad, false);
  
  $codigo = uniqid();
  $archivo = '../listados_eventos/listado' . $codigo . '.pdf';
  $html2pdf -> Output($archivo, 'F');

  
  $content  = file_get_contents($archivo);
  unlink($archivo);
  header("Content-type: application/pdf");    
  header("Content-Disposition: attachment; filename=listado.pdf");
  header("Pragma: no-cache");
  header("Expires: 0");
  echo($content);
  

 function convert_caracters_hex($cad)
  {
 
  $cad=str_replace('ó', '&#243;', $cad);    
  $cad=str_replace('é', '&#233;', $cad);        
  $cad=str_replace('ñ', '&#241;', $cad);    
  $cad=str_replace('ú', '&#250;', $cad);    
  $cad=str_replace('á', '&#225;', $cad);        
  $cad=str_replace('í', '&#237;', $cad);
  $cad=str_replace('ç', '&#231;', $cad);
  $cad=str_replace('ò', '&#242;', $cad);    
  $cad=str_replace('è', '&#232;', $cad);        
  $cad=str_replace('ù', '&#249;', $cad);    
  $cad=str_replace('à', '&#224;', $cad);        
  $cad=str_replace('ì', '&#236;', $cad);
  $cad=str_replace('ñ', '&#241;', $cad);
  return $cad;
  }
  
?>
