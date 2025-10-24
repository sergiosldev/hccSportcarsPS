<?php
require_once (dirname(__FILE__) . '/../../html2pdf/html2pdf.class.php');

//header_remove();


$cad='
 <html>
   <head>
     <title>DIAS</title>
	</head>
   <body>
    <div id="centrar">	
    <div  id="header_graella" class="cabecera" style="margin-left:20px;display: block;">
	'.$_REQUEST['hf'].'
	</div>
	
	 <div class="cl"></div>
	 <div id="graella">
	 '.$_REQUEST['gf'].'
	 </div>
 ';


$cad_style='   <style>
    *{
	font-size:12px;
}';

 if($_REQUEST['horas']=='m')
	  {
	  $cad_style.='.ta{display:none;}
	  ';
	  }
 elseif($_REQUEST['horas']=='t')  $cad_style.='.ma{display:none;}
      ';

 else {}
$cad_style.=' 	.ocupa{
	display:none;
}

img{visibility:hidden}
	._marcat{
	display:none;
}
input{visibility:hidden}

table{border:1px solid #000}	

img,input{display:none}

   </style>';




$cad.=$cad_style;

$cad.='
  </div>
 </body>
</html>';
  $cad = str_replace('tabs/img','img',$cad);
  $cad = str_replace('verdana','tt',$cad);
  //$cad = str_replace('<body','<cuerpo',$cad);
  //	$cad = str_replace('<body','<cuerpo',$cad);
  //$cad2 = eregi_replace("color: #[^>]*;","font-weight:bold;",$cad2);

  $cad = convert_caracters_hex($cad);
  //echo($cad);
  //header_remove();
  
  //ob_start();
  //ob_start();
  
  $cad  = file_get_contents('scripts/test_graella.html');
  
  $html2pdf = new HTML2PDF('P', 'A4', 'fr');     
  //$html2pdf->setTestTdInOnePage(false);
  
  $html2pdf -> writeHTML($cad, false);  
  $codigo = uniqid();
  $archivo = 'listados_eventos/listado' . $codigo . '.pdf';
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