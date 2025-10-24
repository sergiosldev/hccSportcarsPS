<?php
include_once(dirname(__FILE__).'/../../config/defines.inc.php');

$cad='
 <html>
   <head>
     <title>DIAS</title>
     <link rel="stylesheet" type="text/css" href="../../css/admin.css">
     <link rel="stylesheet" type="text/css" href="../../css/ext-all.css">
	 <link rel="stylesheet" type="text/css" href="css/style.css">
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
 
 // header("Content-type: application/octet-stream");
 // header("Content-Disposition: attachment; filename=\"mails.html\"\n");
  file_put_contents('pdf_reserves.html',convert_caracters_hex($cad));
  //echo  file_get_contents('pdf_reserves.html');
 
  header('location:http://www.web2pdfconvert.com/engine?curl='._BASE_URL_.'/admin888/tabs/pdf_reserves.html&outputmode=service');
 



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