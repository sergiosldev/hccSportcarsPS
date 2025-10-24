<?php
  include_once dirname(__FILE__).'/../../../classes/Provincia.php';     
  include_once dirname(__FILE__).'/funciones_ofertas.php';     
  echo('<div class="tab-row" id="row">');
  echo('	<h4 class="tab sub selected"  style="border-bottom:none !important;" id="tab'.$_GET['nombre_opcion'].'"><a class="cabecera" align="left" href="#" onclick="CambiarTab(\"opcion\",1,'.($nopciones+1).');">Datos de la oferta</a> </h4>');
  echo('</div>');
  echo('<input type="button" id="opcion_nueva" name="opcion_nueva" value="+" style="float:left;margin-left: 4px;width: 20px;height: 20px;" onclick="add_tab_opcion(this);">');
  echo('	<div id="step'.$_GET['nombre_opcion'] .'1" class="tab-page sub selected" style="display: block;background-color:#FFFFFF;">');
  include 	"tabla_oferta.php";
  echo('	</div>');

?>