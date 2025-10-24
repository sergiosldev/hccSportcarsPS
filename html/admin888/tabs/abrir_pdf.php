<?php
  unlink(dirname(__FILE__).'/../listados_eventos/concat.pdf');  
  header_remove();
  header("Content-type: application/pdf");    
  header("Content-Disposition: attachment; filename=listado.pdf");
  header("Pragma: no-cache");
  header("Expires: 0");
  echo($content); 
?>