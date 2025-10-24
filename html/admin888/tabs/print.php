<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd"> 
 <html lang="es" id="p">
   <head>
     <title>DIAS</title>
     <link rel="stylesheet" type="text/css" href="../../css/admin.css">
     <link rel="stylesheet" type="text/css" href="../../css/ext-all.css">
	 <link rel="stylesheet" type="text/css" href="css/style.css">
	</head>
   <body>
    <div id="centrar">	
    <div  id="header_graella" class="cabecera" style="margin-left:20px;display: block;">
	<?php 
	 echo convert_caracters_hex($_REQUEST['hf']);
	 ?>
	</div>
	
	 <div class="cl"></div>
	 <div id="graella">
	 <?php
	 echo convert_caracters_hex($_REQUEST['gf']);
	  ?>
	 </div>
   
    <style>
    *{
	font-size:12px;
}

<?php 
 if($_REQUEST['horas']=='m')
	  {
	  echo '.ta{display:none;}
	  ';
	  }
else   echo '.ma{display:none;}
      ';
?>
   	.ocupa{
	display:none;
}
/*
  	.ocult{
	display:none;
}
*/
img{visibility:hidden}
	._marcat{
	display:none;
}
 /*
	.mostra{
	display:inline;
	width:160px;
}
*/
img,input{visibility:none}

   </style>
   
   </div>
   
  
   	 
   </body>
   
   
   <script>

	 
function ImprimirVar(id)
{
	
		var htmlcode = ' ';
		var ImprimeElem = document.getElementById(id);
		htmlcode += ImprimeElem.innerHTML;
		
		var printing = window.open("","Imprimir_window");
		printing.document.open();
		printing.document.write(htmlcode);
		printing.document.close();
		if (autoimprimir)
			printing.print();

            printing.close();
	
}

var autoimprimir = true;
ImprimirVar('p')
window.close();   

   </script>
 </html>
 
<?php

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
