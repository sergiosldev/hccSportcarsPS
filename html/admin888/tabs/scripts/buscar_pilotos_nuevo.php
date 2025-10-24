<style>         
*{:
font-size:11px;	
}	
.capsalera{
font-size:13px;
font-weight:bold;
padding:5px;
color:#555;
border:1px solid #aaa;
background:#fff;		
}
.columna
{
font-size:13px;
}

.pagination {
    height: 36px;
    margin: 15px 0;
	
}
.pagination ul {
    border-radius: 3px 3px 3px 3px;
    box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
    display: inline-block;
    margin-bottom: 10px;
	margin-left:92px;
	box-shadow: 0 2px 5px #666666;
}
.pagination li {
    display: inline;
}
.pagination a {
    -moz-border-bottom-colors: none;
    -moz-border-image: none;
    -moz-border-left-colors: none;
    -moz-border-right-colors: none;
    -moz-border-top-colors: none;
    border-color: #DDDDDD;
    border-style: solid;
    border-width: 1px 1px 1px 0;
    float: left;
    line-height: 34px;
    padding: 0 14px;
    text-decoration: none;
	cursor:pointer;
}
</style>	
<?php

  include('config_events_new.php');      
  include_once('buscar_pilotos_consulta.php');   
	//Fins el ultim include, seria un nou fitxer.
	//$_REQUEST hauran de canviar per els parametres necessaris.
	//Enviar el parametre al include nou.
	
	
  $nombreb = $_REQUEST['nombreb'];	
  $codigob = $_REQUEST['codigob'];                 
  $ciudadb = $_REQUEST['ciudadb'];  
  $emailb = $_REQUEST['emailb'];
  $telefonob = $_REQUEST['telefonob'];
  $diab = $_REQUEST['diab']; 
  $tipob = $_REQUEST['tipob'];  
  
  //Mostrar un text en referencia la localitat.
  if($ciudadb=='*')echo 'CIUDAD TODAS<br><br>'; 
  else if($ciudadb=='')echo 'CIUDAD BARCELONA<br><br>';
  else echo 'CIUDAD '.strtoupper($ciudadb).'<br><br>';
  
  consultar_pilotos($nombreb,$codigob,$ciudadb,$emailb,$telefonob,$diab,$tipob);
  
  
  
 // header("Content-type: application/octet-stream");
 // header("Content-Disposition: attachment; filename=\"mails.rtf\"\n");

  
 

?>