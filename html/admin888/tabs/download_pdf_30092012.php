<?php

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
else  $cad_style.='.ma{display:none;}
      ';


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
 
  header('location:http://www.web2pdfconvert.com/engine?curl=http://lon.motorclubexperience.com/admin888/tabs/pdf_reserves.html&outputmode=service');
 
 /*
 $cad=str_replace('<img alt="" src="tabs/img/persona.png" width="8px">','',$cad);

 $cad=str_replace('<img src="tabs/img/persona.png" alt="" width="8px">','',$cad);
 $cad=str_replace('<img src="tabs/img/edit.gif" alt="">','',$cad);
 $cad=str_replace('<img src="tabs/img/email.png" alt="" width="22px">','',$cad);
 $cad=str_replace('<img src="tabs/img/esborra.gif" alt="">','',$cad);
 $cad=str_replace('<img style="width:16px;height:16px" alt="" src="../img/t/AdminTools.gif">','',$cad);
 
 
//echo $cad;



 require_once(dirname(__FILE__).'/html2pdf/html2pdf.class.php');
    try
    {
    $html2pdf = new HTML2PDF('P','A4','es');
    $html2pdf->WriteHTML($cad);
    $html2pdf->Output('reservas.pdf');
    }
    catch(HTML2PDF_exception $e) {
        echo $e;
        exit;
    }


*/



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