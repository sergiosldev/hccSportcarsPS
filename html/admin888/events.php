<?php 
include(dirname(__FILE__).'/config/config.inc.php');

if(intval(Configuration::get('PS_REWRITING_SETTINGS')) === 1)
	$rewrited_url = __PS_BASE_URI__;
	
session_start();

//var_dump($_GET);DIE;
$hccsport=false;
if(isset($_GET["hccsportcars"]))  {$hccsport='?hccsportcars=1';}
//mts 11032012
//else if(isset($_GET["dreamcars"])){$hccsport='?dreamcars=1';}
else if(isset($_GET["dreamcars"])){$hccsport='?dreamcars='.$_GET["dreamcars"];}
//fin mts
if(!isset($_SESSION["accessevents"])){
  	header('location:valida_codigo.php'.$hccsport);
  }
else if(isset($_SESSION["accessevents"])){
  $usession = $_SESSION["accessevents"];
  $ahora = date("Y-n-j H:i:s");
  $t = (strtotime($ahora)-strtotime($usession)); 	
  if($t >= 20) { //43200 mig dia
  	 unset($_SESSION["accessevents"]);
     header('location:valida_codigo.php'.$hccsport);
  }	
}
		

if(!$hccsport)
   include(dirname(__FILE__).'/header.php');
else
   header_();
 
include './scripts/config_events.php';
?>

	 <script type="text/javascript" src="js/funcs.js"></script>
     <script type="text/javascript" src="js/ajax_load.js"></script>
	 <link rel="stylesheet" type="text/css" href="css/style.css">
	 
	<script >
<!--

var i;
var imagenes = new Array("<?php echo(_URL_BASE_);?>/images/carbassa_u.png",
"<?php echo(_URL_BASE_);?>/images/carbassa_n.png",
"<?php echo(_URL_BASE_);?>/images/vermell_n.png",
"<?php echo(_URL_BASE_);?>/images/vermell_u.png");
var lista_imagenes = new Array();

function cargarimagenes(){

   for(i=0;i<imagenes.length;i++){
     lista_imagenes[i] = new Image();
     lista_imagenes[i].src = imágenes[i];
   }
}
cargarimagenes()



//-->
</script>  
	 
   <script>
   	
	/* VARIABLES GLOBALS */
	var v_mes=<?php echo date('m'); ?>;
    var v_ano=<?php echo date('Y'); ?>;
    var dia_sel='';
   </script>


<!-- mts 25032012 modif. pestañas -->
<fieldset  id="tab_ciudad_div" class = "tab" style="border:none;border-bottom:1px solid #777" >
 <div id="legend"><span> 3. Paso</span> <a href="valida_codigo_acceso.php<?php echo($hccsport);?>"><span class="ant">Paso anterior</span></a> </div>  
</fieldset>
<!--fin modif mts --> 
<div style="padding-left:90px;padding-top:5px;">
<div id="ciudad_div">
    <?php 
     include './scripts/ciudad.php';
    ?> 	  
</div>
</div>	 
 
<div >
<!-- mts 25032012 modif. pestañas -->    
<fieldset  id="tab_tipo_evento"  class = "tab"  style="display:none;border:none;border-bottom:1px solid #777" >
 <div id="legend"><span> 4. Paso</span> <a href="javascript:vista(0);"><span class="ant">Paso anterior</span></a> </div>  
</fieldset>    
<!-- fin modif mts -->
<div id="tipo_evento" style="display:none;padding-left:90px;">
   <?php 
   include './scripts/tipo.php';
   ?> 	  
</div>
</div>	
<div class="cl" ></div>
<!-- mts 25032012 modif. pestañas -->
<fieldset  id = "tab_paso_calendario"  class = "tab"  style="display:none;border:none;border-bottom:1px solid #777" >
 <div id="legend"><span> 5. Paso</span> <a href="javascript:vista(1);"><span class="ant">Paso anterior</span></a> </div>  
</fieldset>
<!-- fin modif mts -->
<div id="paso_calendario" style="display:none;padding-left:90px;">
    <h2 class="titulo_reserva">Escoge un día</h2><br>
    <!-- mts 25032012 modif. pestañas -->

	<!--<fieldset>
	   <legend><span class="_legend_"> PASO 3 - Escoge el dia </span>  
	   <!-- mts 24032012, sólo nos quedamos con botón a paso anterior 
	   <a href="javascript:vista(0);" class="_legend_"  >Volver a Paso 1 escoge la ciudad</a> 
	   <a href="javascript:vista(1);" class="_legend_" >Volver a 2 escoge la prueba</a> 
	   --*>
	   <a href="javascript:vista(1);" class="_legend_" >Paso anterior</a> 
	    
	   </legend> -->
	   <!-- fin modif pestañas --> 	
	   <div id="calendari" style="float:left;width:40%;min-height:180px;text-align:center;margin-left:70px;" ></div>
	   <div style="margin-left:100px;margin-top:50px;float:left;width:30%;font-style:italic;background:#000;color:#fff;text-align:center;font-size:16px;padding:10px;border:1px solid #fff">
	    Escoge tu dia<br>
	    <span style="color:#f00">Dias rojos completo</span><br>
	    <span style="color:#0f0">Dias verdes disponible</span><br>
	    <span style="color:#00f">Dias azules pendiente de abrir</span>
       </div>
	</fieldset>
</div>
<div class="cl" ></div>

<!-- mts 25032012 modif. pestañas -->
<fieldset  id = "tab_paso_graella"  class = "tab"  style="display:none;border:none;border-bottom:1px solid #777" >
 <div id="legend"><span> 6. Paso</span> <a href="javascript:vista(2);"><span class="ant">Paso anterior</span></a> </div>  
</fieldset>	
<!-- fin modif mts -->

<div id="paso_graella" style="display:none;padding-left:90px;" >	
 <fieldset>
     <h2 class="titulo_reserva">Escoge una hora</h2><br>
    <!-- mts 25032012 modif. pestañas -->
    
	<!-- <legend><span class="_legend_"> Paso 3 - Escoger la hora </span>
	<!-- mts, sólo dejamos botón ir a paso anterior 
	<a href="javascript:vista(0);" class="_legend_">Volver a 1 escoge la ciudad</a>  
	<a href="javascript:vista(1);" class="_legend_">Volver a 2 escoge la prueba</a> 
	 <a href="javascript:vista(2);" class="_legend_" >Volver a 3 escoge el dia</a> 
	 --*>
	<a href="javascript:vista(2);" class="_legend_" >Paso anterior</a> 
	</legend>
	-->
	<!-- fin modif. mts -->	
	<div class="cabecera" id="header_graella" style="display:none"  >
       <div id="dia"></div>
	</div> 
	
	<div class="cl" ></div>
	<br>
	<div id="graella" style="padding-left:140px;float:left;width:70%" ></div>
<!--   <div style="margin-left:10px;float:left;width:30%;font-style:italic;background:#000;color:#fff;text-align:center;font-size:16px;padding:10px;border:1px solid #fff">
	    Escoge tu hora de inicio de la actividad.<br>
		Recuerda que dicha hora es aproximada ya que puede haver demora de hasta 40 minutos por 
		incidéncias en el evento.<br>
		Aun asi deve presentarse 30 minutos antes de la hora escogida.
	    <br>
	    
       </div>
-->	   
</fieldset>
</div>


<fieldset  id="tab_alta"  class = "tab"  style="display:none;border:none;border-bottom:1px solid #777" >
 <div id="legend"><span> 7. Paso</span> <a href="javascript:vista(3);"><span class="ant">Paso anterior</span></a> </div>  
</fieldset>

<?php 


if(!isset($_GET['socio_reserva'])){
   include './scripts/formulario.php';
}
else include './scripts/formulario_socio.php';

?>

<script>
var ciudad_aux=""  
               
function click_dia(d){ // quan clickes dia a calendari
  
   get_graella(d)
   dia_sel=d;
   id_('dia').innerHTML='Dia seleccionado: <span style="color:#f04">'+dia_sel+'</span>';
   id_('dia_seleccionado').innerHTML="Dia "+d
   //window.location="#dia"
   //id_('alta').style.display="none"
   vista(3)
}

function canvia_tipus(t){
	
	
  //mts 14032012
  if (t=='ferrari_360') tipus_ev='ferrari';
  else tipus_ev= t;
  //fin mts.
  if(dia_sel!='')get_graella(dia_sel)
  vista(2);
  var r=crida(v_mes,v_ano)
  /* mts 24032012 cambiamos texto tipo evento por imagen.
   
   if(document.getElementById('_evento'))
      document.getElementById('_evento').innerHTML='Ha escogido '+return_tipus_e(t)+' ';
  */
 
 switch  (t)
 {
     case 'ferrari': aux_im = '8.jpg';
     break;
     case 'ferrari_360': aux_im = '7.jpg';
     break;
     case 'lamborghini': aux_im = '12.jpg';
     break;
     case 'lotus':aux_im = '10.jpg';   
     default: aux_im = '9.jpg';
 }
 aux_im = 'img/c/'+aux_im;
 id_('eventoimg').src=aux_im;
 
 /* fin modif mts */
  // Preus
  if (document.getElementById('reserva_socio_form')) {
  	document.getElementById('amount').value = return_precio_tipus(t);
    document.getElementById('precio_experiencia').innerHTML = return_precio_tipus(t)+'€';
  }
  id_('calendari').innerHTML=r
  
  }

function ocultar_form(){
	id_('alta').style.display='none'
	window.location='#dia'
}
function alta(d,h,h_aux){ 
   vista(4)
  document.getElementById('form_alta').reset()
  document.getElementById('id_alta').value=d+'@'+h
  id_('edicio').value='false';
  id_('ciudad').value=ciudad_aux
  id_('msg_error').innerHTML='';
  id_('dia_seleccionado').innerHTML="<br><br><br><br>"+id_('dia_seleccionado').innerHTML+" a las  "+h_aux 

  }
   
function get_graella(dia)
   {
   	var ale='&gg'+(Math.floor(Math.random()*50000))+'=1'
   	<?php $f=''; if($front)$f='&front=1' ?>
    id_('graella').innerHTML=ajax.load('<?php echo $base_scripts ?>graella.php?data='+dia+'&ciudad='+ciudad_aux+'&tipus='+tipus_ev+'<?php echo $f; ?>'+ale);  
	id_('header_graella').style.display='block';          
   }   
    

function crida(m,a){
  var ale='&gg'+(Math.floor(Math.random()*50000))+'=1'
  var r=ajax.load('<?php echo $base_scripts ?>calendari.php?mes='+m+'&ano='+a+'&ciudad='+ciudad_aux+'&tipus='+tipus_ev+ale);
  //alert(r)
  return r;
}


//id_('calendari').innerHTML=crida(v_mes,v_ano)

//get_graella(dia_sel)
//id_('dia').innerHTML='Dia actual: '+dia_sel;

<?php
 $jshccsport='';
 if(array_key_exists('hccsportcars', $_REQUEST)){
   $jshccsport='?hccsportcars=1';
 } else if(array_key_exists('dreamcars', $_REQUEST)){
     $jshccsport='?dreamcars=1';	 
 }
?>

function envia_formulari()
  {
  	var dades=obtenirDadesForm('form_alta');
  	//die(dades);
	var ale='&gg'+(Math.floor(Math.random()*50000))+'=1';
    r=ajax.load('<?php echo $base_scripts ?>ajax.php?'+dades+ale);
	var ok=/OK/;
    if (ok.test(r)) { // recarrega graella
	 alert('Solicitud recibida correctamente. Recibira un email de confirmación con sus datos')
	 
	 id_('msg_error').innerHTML='Recepción correcte';
	 window.location="events.php<?php echo $jshccsport ?>"
	 get_graella(dia_sel)
	 }
	else {	
	 window.location='#msg_error'
	 id_('msg_error').innerHTML=r;
	}
  }

</script>
<?php
if(!array_key_exists('hccsportcars', $_REQUEST)
&& !array_key_exists('dreamcars', $_REQUEST)){
  
  ?>
<div style="margin-left:90px;margin-top:10px">
 <!-- mts 15032012 temporalmente canviado por dreamcars 
 <a href="https://www.facebook.com/pages/Motor-Club-Experience/147051325363816" target="_blank"><img width="100px" src="<?php echo $URL_ROOT ?>images/facebook.png" alt="" /></a>
 -->
 <a href="https://www.facebook.com/pages/Dream-Cars-Experience-pagina-oficial/355972841080529" target="_blank"><img width="100px" src="<?php echo $URL_ROOT ?>images/facebook.png" alt="" /></a>

<!-- fin mts -->
</div>
<?php } ?>
<!--
<div style="margin-left:100px;margin-top:6px;">
  <div id="fb-root" ></div>
  <script src="http://connect.facebook.net/es_ES/all.js#appId=210175052354835&amp;xfbml=1"></script><fb:like href="https://www.facebook.com/pages/Motor-Club-Experience/147051325363816" send="true" width="450" show_faces="false" font="arial"></fb:like>		
</div>
-->
<style>
	._legend_{
		font-size:14px;
	}

</style>	

<?php
if(array_key_exists('hccsportcars', $_REQUEST)
|| array_key_exists('dreamcars', $_REQUEST)){
?>
  
  <script>
  	//$('#ferrari_tipus td').css('width','220px');
  	//$('#lamborghini_tipus td').css('width','220px');
  	//$('#porsche_tipus td').css('width','220px');
  </script>	
  
  
	<style>
	input, textarea, select {
    background: none repeat scroll 0 0 #000000;
    border: 1px solid #99f;
    color: #FFFFFF;
     }
    td {
    color: #FFFFFF;
    font-size: 13px;
    }
	/*body{
		background-color:#303030;
		
	}*/

    .titulo_reserva
    {
        font-size:15px;
        font-weight:bold;
        color:white;
        border-bottom: 0 solid #888888;
        border-top: 0 solid #888888;
        font-weight: bold;
        height: 21px;
        line-height: 1.6em;
        margin: 0.5em 0;
        padding-left: 15px;
        text-transform: uppercase;   
        font-family: "Trebuchet MS",Arial,Helvetica,sans-serif;    
    }
	
	</style>
	</body >
  </html>	
  <?php

  } else include(dirname(__FILE__).'/footer.php');
  
  
  function header_() {
  	?>
	<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="{$lang_iso}">
	<head>

		<meta http-equiv="Content-Type" content="application/xhtml+xml; charset=utf-8" />
		<meta name="generator" content="PrestaShop" />
		<meta name="robots" content="{if isset($nobots)}no{/if}index,follow" />
		<link rel="icon" type="image/vnd.microsoft.icon" href="{$img_ps_dir}favicon.ico" />
		<link rel="shortcut icon" type="image/x-icon" href="{$img_ps_dir}favicon.ico" />

		<script type="text/javascript" src="js/tools.js"></script>
		<script type="text/javascript">
			var baseDir = '';
			var static_token = '{$static_token}';
			var token = '{$token}';
			var priceDisplayPrecision = {$priceDisplayPrecision*$currency->decimals};
			var roundMode = {$roundMode};
		</script>
		<script type="text/javascript" src="js/jquery/jquery-1.2.6.pack.js"></script>
		<script type="text/javascript" src="js/jquery/jquery.easing.1.3.js"></script>
		<script type="text/javascript" src="js/jquery/jquery.hotkeys-0.7.8-packed.js"></script>
		
<link rel="stylesheet" href="themes/prestashop/css/menu.css" media="all" />		
		
		
<script  src="js/cufon-yui.js"></script>
<script  src="js/cufon-replace.js"></script> 
<script  src="js/Myriad_Pro_400.font.js"></script> 
<script  src="js/Myriad_Pro_700.font.js"></script> 


<link rel="stylesheet" href="css/ezmark.css" media="all" />
<script type="text/javascript" src="js/jquery.ezmark.min.js"></script>

<body >
		<div id="page">
	<?php
  }
?>