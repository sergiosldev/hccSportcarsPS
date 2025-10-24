<?php
  $content  = file_get_contents($_GET['filename']);  
  unlink($_GET['filename']);  
  header_remove();
  header("Content-type: application/pdf");    
  header("Content-Disposition: attachment; filename=listado.pdf");
  header("Pragma: no-cache");
  header("Expires: 0");
  echo($content); 
?>