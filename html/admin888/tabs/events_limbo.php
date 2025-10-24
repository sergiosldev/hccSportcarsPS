<?php
class events_limbo
{
	public function viewAccess($disable = false)
	{
	}
	
}

include_once dirname(__FILE__).'/scripts/config_limbo.php';

include_once(dirname(__FILE__).'/../../config/config.inc.php'); 

$URL_ROOT='http://'.$_SERVER['HTTP_HOST'].__PS_BASE_URI__ ;

$filtro_ciudad = '';
$filtro_tipo_evento = 'ferrari';

if (isset($_GET['dia_sel_limbo']))
{
?>
  <script type="text/javascript">
	var dia_sel_limbo='<?php echo($_GET['dia_sel_limbo']);?>';
	ciudad_aux_limbo='<?php echo($_GET['ciudad_aux_limbo']);?>';
	var tipus_ev_limbo='<?php echo($_GET['tipus_ev_limbo']);?>';
	var v_mes_limbo=<?php echo($_GET['v_mes_limbo']); ?>;
	var v_ano_limbo=<?php echo($_GET['v_ano_limbo']); ?>;
  </script>
<?php	
	
}
else 
{
?>
  <script type="text/javascript">
    var a=1;
	var v_mes_limbo=<?php echo date('m'); ?>;
	var v_ano_limbo=<?php echo date('Y'); ?>;
  </script>
<?php	
	
}
//if ($filtro_ciudad=='')
//	die('Debe seleccionar una ciudad');


?>

<script type="text/javascript" src="tabs/js/ajax_load.js?id=<?php echo(rand(0,50000));?>"></script>
<script type="text/javascript" src="tabs/js/ajax_load_post.js?id=<?php echo(rand(0,50000));?>"></script>
<link rel="stylesheet" type="text/css" href="tabs/css/style.css">
<link rel="stylesheet" type="text/css" href="tabs/css/botones_menu.css?id=<?php echo(rand(0,50000));?>">
<link media="screen" rel="stylesheet" href="tabs/modal/colorbox.css" />
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.4.4/jquery.min.js"></script>
<script src="tabs/modal/colorbox/jquery.colorbox.js"></script>
<script src="<?php echo($URL_ROOT);?>admin888/tabs/js/funcs_limbo.js?id=<?php echo(rand(0,50000));?>"></script>

<script>
/* VARIABLES GLOBALS */
<?php 

if (isset($_GET['dia_sel_limbo']))
{

	
}
else 
{
?>
	var dia_sel_limbo='';
	var ciudad_aux_limbo='';
	var tipus_ev_limbo='ferrari';
<?php	
}
?>




function calendario_limbo(m,a,ciudad,tipo_evento) 
{

	var ale='&gg'+(Math.floor(Math.random()*50000))+'=1';

	var r= ajax.load('<?php echo $base_scripts ?>calendari_limbo.php?mes='+m+'&ano='+a+'&ciudad='+ciudad+'&tipus='+tipo_evento+ale);
	
	return r;
}

function click_dia(d) 
{ 
   get_reservas_limbo(d);
   dia_sel_reubic=d;
   id_('dia_limbo').innerHTML='Dia actual: <span style="color:#f04">'+dia_sel_reubic+'</span>';
   //id_('alta').style.display="none"
   var _d=dia_sel.split("-"); 
   _d=_d[2]+'-'+_d[1]+'-'+_d[0];
   id_('acciones_dia_limbo').innerHTML=''+_d+' &#160;&#160;&#160;&#160;<a style="color:#0f0;background:#0f0;border:1px solid #0f0;padding:1px" href="javascript:ac_dia(\''+dia_sel_reubic+'\',1)">&#160;&#160;</a> '+
   ' <a style="border:1px solid #33f;background:#33f;padding:1px" href="javascript:ac_dia(\''+dia_sel_reubic+'\',0)">&#160;&#160;</a>'+
   ' <a style="border:1px solid #d0629e;background:#d0629e;padding:1px" href="javascript:ac_dia(\''+dia_sel_reubic+'\',3)">&#160;&#160;</a>'+
   ' <a style="border:1px solid #f00;background:#f00;padding:1px" href="javascript:ac_dia(\''+dia_sel_reubic+'\',2)">&#160;&#160;</a>' +
   //mts 07052012.
   ' <a style="border:1px solid #888888;background:#888888;padding:1px" href="javascript:ac_dia(\''+dia_sel_reubic+'\',4)">&#160;&#160;</a>';
} 


//Muestra todos los registros del limbo, según los filtros de ciudad (alguna, o todas) o vehículo (alguno, o todos), pero sin marcar ningún día.
function mostrar_todos(ciudad_limbo,tipo_limbo)
{
	  var ale='&gg'+(Math.floor(Math.random()*50000))+'=1'
	  var dia='';
	  <?php $f=''; if($front)$f='&front=1' ?>
	  var r=ajax.load('<?php echo $base_scripts ?>reservas_limbo.php?filtro_dia='+dia+'&filtro_ciudad='+ciudad_limbo+'&filtro_tipo_evento='+tipo_limbo+'<?php echo $f; ?>'+ale);
	  
	  id_('registros_limbo').innerHTML=r;
}

function get_reservas_limbo(dia) 
{
	  var ale='&gg'+(Math.floor(Math.random()*50000))+'=1'
	  <?php $f=''; if($front)$f='&front=1' ?>
	  var r=ajax.load('<?php echo $base_scripts ?>reservas_limbo.php?filtro_dia='+dia+'&filtro_ciudad='+ciudad_aux_limbo+'&filtro_tipo_evento='+tipus_ev_limbo+'<?php echo $f; ?>'+ale);  
	  id_('registros_limbo').innerHTML=r;
	
	/*setGraella=true
	  id_('header_graella').style.display='block';*/          
}

function get_reservas_limbo_ids(ids) 
{ 
	  var ale='&gg'+(Math.floor(Math.random()*50000))+'=1'
	  <?php $f=''; if($front)$f='&front=1' ?>
	  var r=ajax_post.load('<?php echo $base_scripts ?>reservas_limbo.php','ids="'+ids+'"&filtro_ciudad=todo&filtro_tipo_evento=todo'+'<?php echo $f; ?>'+ale);                         
//	  alert("R: "+r);
	  //alert(r);
	  id_('registros_limbo').innerHTML=r;
//	  alert(id_('registros_limbo').innerHTML);  
}

function buscar_limbo() //quan esborres pilot
{
  var ale='&gg'+(Math.floor(Math.random()*50000))+'=1';

  $.colorbox({width:"42%", inline:true, href:"#buscar_contact_limbo",open:true});

}

function enviar_buscar_limbo()
{ 
	
	var d;
    var ale='&gg'+(Math.floor(Math.random()*50000))+'=1';
    var dades=obtenirDadesForm('form_buscar_limbo');
    //alert('<?php echo $base_scripts ?>ajax.php?buscar_piloto_limbo=1'+dades+ale);
    //return;
    //r=ajax_post.load('<?php echo $base_scripts ?>ajax.php?buscar_limbo=1'+dades+ale);  
	
    r=ajax_post.load('<?php echo $base_scripts ?>ajax.php','buscar_limbo=1&'+dades+ale);
    get_reservas_limbo_ids(r);  
    $.colorbox.close();
    /*
    var ok=/OK/;
    if (ok.test(r)) 
    {
     	//alert(r)
    }
    */

}



//Reubica un evento a una fecha y hora seleccionadas.
function form_reubicarl(id_ev,ciudad,tipo,hora)
{
 //alert(tipo);
  volver_calendario();
  id_('ciudad_origen').value=ciudad;
  id_('tipo_origen').value=tipo;
  id_('hora_origen').value=hora;
  id_('idev').value=id_ev;
  canvia_ciudad_sel(ciudad);
  canvia_tipus_sel(tipo); 
  v_mes_sel = v_mes_limbo;
  v_ano_sel = v_ano_limbo;
  
  id_('calendari_sel').innerHTML = crida_sel(v_mes_sel, v_ano_sel,ciudad,tipo);

  
  //if(dia_sel!='')get_graella_sel(dia_sel)
  
  //id_('calendari_sel').innerHTML=crida_sel(v_mes,v_ano)
  id_('graella_sel').innerHTML=''
  id_('header_graella_sel').style.display='none';  
  id_('msg_error').innerHTML='';
  document.getElementById('form_reubicar').reset()
  $.colorbox({width:"80%",height:"500px", inline:true, href:"#form_reubicar",open:true});
    var cbclose = $.colorbox.close;
    $.colorbox.close = function ()
    {
        get_graellal(dia_sel_reubic);
        $.colorbox.close = cbclose;
        cbclose();
    }
  }

function get_graellal(dia) { 
  var ale='&gg'+(Math.floor(Math.random()*50000))+'=1'
  <?php $f=''; if($front)$f='&front=1' ?>
  var ciudad=ciudad_aux_sel;
  //if (ciudad_aux_sel=='Barcelona') ciudad='';
  //id_('registros_limbo').innerHTML=ajax.load('<?php echo $base_scripts ?>reservas_limbo.php?filtro_dia='+dia_sel+'&filtro_ciudad='+ciudad+'&filtro_tipo_evento='+tipus_ev_sel+ale);                                                                                            
  id_('registros_limbo').innerHTML=ajax.load('<?php echo $base_scripts ?>reservas_limbo.php?filtro_dia='+dia+'&filtro_ciudad='+ciudad+'&filtro_tipo_evento='+tipus_ev_sel+ale);                                                                                             
  //id_('header_graella').style.display='block';
}

/*
function get_graella(dia) {
  var ale='&gg'+(Math.floor(Math.random()*50000))+'=1'
  <?php $f=''; if($front)$f='&front=1' ?>
  var r=ajax.load('<?php echo $base_scripts ?>graella.php?data='+dia+'&ciudad='+ciudad_aux_sel+'&tipus='+tipus_ev_sel+'<?php echo $f; ?>'+'&perfil=<?php echo($perfil);?>'+ale);                                                                    
  id_('graella').innerHTML=r;
  setGraella=true
  id_('header_graella').style.display='block';                                                               
  id_('calendari').innerHTML = crida(v_mes_sel, v_ano_sel);                                                                                         
} 
*/
</script>
  
<div id="centrar"> 
	<h1 style="font-size: 39px;">LIMBO</h1>

   <?php 
   include 'scripts/tipus_limbo.php';
   ?> 	  

<div id="bloque_limbo">
<div id="bloque_calendario">
  <fieldset>
      <legend>Calendario</legend>    
	  <div id="calendari_limbo" style="float:left;width:50%;min-height:180px" ></div>
	  <div id="tipus_img_limbo" style="float:left;width:15%;min-height:180px;position:relative;" >tipus</div>
	  <div id="ciudad_info_limbo" style="float:left;width:33%;margin-top:10px;font-weight:bold;font-size:20px;text-transform:capitalize;">Barcelona</div>
  	  <div id="acciones_dia_limbo" style="float:left;width:33%;margin-top:30px;font-weight:bold;font-size:20px">
  	  </div>  
 </fieldset>
  <?php 
  //include dirname(__FILE__).'/scripts/formulario.php';
  include dirname(__FILE__).'/scripts/formulario_reubicacion.php';
  ?>
</div>
<?php 
include 'modals_limbo.php';  
include 'menu_eines_limbo.php';

?>

<div class="cabecera_limbo">
	<div id="dia_limbo" style="margin-bottom:20px;">
	</div> 
</div>
<div id="registros_limbo">  
</div>
</div>

<script type="text/javascript">
	<?php 
	if (isset($_GET['dia_sel_limbo']))
	{		
		
		echo('$("#ciudad_barcelona_limbo").attr("class","boton_menu");');
		
		if ($_GET['ciudad_aux_limbo']=='') 
			$sciudad = 'barcelona';
		else 
			$ciudad = 	$_GET['ciudad_aux_limbo'];
		
		echo('$("#ciudad_'.$ciudad.'_limbo").attr("class","boton_menu menu_activo");');
		
		echo('$("#ferrari_limbo").attr("class","boton_menu");');
		
		if (substr($_GET['tipus_ev_limbo'],0,1)=='_')
			echo('$("#'.$_GET['tipus_ev_limbo'].'limbo_").attr("class","boton_menu menu_activo");');
		else	
			echo('$("#'.$_GET['tipus_ev_limbo'].'_limbo").attr("class","boton_menu menu_activo");');
		
	}
	?>
	id_('calendari_limbo').innerHTML=calendario_limbo(v_mes_limbo,v_ano_limbo,ciudad_aux_limbo,tipus_ev_limbo);
	get_reservas_limbo(dia_sel_limbo);
	$('#dia_limbo').html('Dia actual: <span style="color:#f04">'+dia_sel_limbo+'</span>');
</script>

