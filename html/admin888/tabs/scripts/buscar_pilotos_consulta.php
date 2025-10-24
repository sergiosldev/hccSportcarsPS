<?php
include_once(dirname(__FILE__).'/../../../config/defines.inc.php'); 
  
 function consultar_pilotos($nombreb,$codigob,$ciudadb,$emailb,$telefonob,$diab,$tipob)
  {
	//Revisar casos buits i caracters especials.
	echo "	
	  <script>
			function canviar_pag(page) {	 
			  
			  var xhttp = new XMLHttpRequest();
			  
			  xhttp.onreadystatechange = function() {
				if (xhttp.readyState == 4 && xhttp.status == 200) {
				  document.getElementById(\"res_consulta\").innerHTML = xhttp.responseText;
				}
			  };
	
			  xhttp.open('GET','"._BASE_URL_."/admin888/tabs/scripts/buscar_pilotos_ajax.php?";
	           
	          //Control parametres.
			  if($emailb!=null){
				 echo "emailb=".$emailb."&";
			  }
			  else{
			      echo "emailb=&";
			  }
			  
			  if($nombreb!=null){
			     echo "nombreb=".$nombreb."&";
			  }
			  else{
			      echo "nombreb=&";
			  }
			  
			  if($codigob!=null){
			      echo "codigob=".$codigob."&";
			  } 
			  else{
			      echo "codigob=&";
			  } 
			  
			  if($telefonob!=null){
			      echo "telefonob=".$telefonob."&";
			  }
			  else{
			      echo "telefonob=&";
			  }
			  
			  if($diab!=null){
			      echo "diab=".$diab."&";
			  }
			  else{
			      echo "diab=&";
			  }
			  
			  if($tipob!=null)
			  {
			      echo "tipob=".$tipob."&";
			  }
			  else{
			      echo "tipob=&";
			  }
			  
			  if(ciudadb!=null){
			      echo "ciudadb=".$ciudadb."&";
			  }

			  
			  //fi control				
			echo "p='+page, true);
				xhttp.send();
			}
			$( document ).ready(canviar_pag(1));
	  </script>
    ";


	
	//Imprimir resultats consulta dins el div.
	echo '<div id="res_consulta">';
	
	echo '</div>';
  }
  

?>