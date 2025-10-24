<?php  
include dirname(__FILE__).'/scripts/config_events.php'; 
global $cookie;
$perfil=$cookie->profile;
?>
<script type="text/javascript" src="tabs/js/sha.js"></script>
<script type="text/javascript" src="tabs/js/funcs_fechas.js"></script>
    
          
<script type="text/javascript" src="tabs/js/funcs_hoteles.js?id=<?php echo(rand(0,50000));?>"></script>
<script type="text/javascript" src="tabs/js/ajax_load.js"></script>
<script type="text/javascript" src="tabs/js/ajax_load_post.js"></script>
<link rel="stylesheet" type="text/css" href="tabs/css/style.css">
<link rel="stylesheet" type="text/css" href="tabs/css/botones_menu.css">
<link media="screen" rel="stylesheet" href="tabs/modal/colorbox.css" />
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.4.4/jquery.min.js"></script>
<script src="tabs/modal/colorbox/jquery.colorbox.js"></script>
<script>
          
/* VARIABLES GLOBALS */
var v_mesh=<?php echo date('m'); ?>;
var v_anoh=<?php echo date('Y'); ?>;
var dia_selh='';
</script>

<div id="centrar">
<?php 
include dirname(__FILE__).'/scripts/ciudades_hoteles.php';
include dirname(__FILE__).'/scripts/formulario_validar_password.php';    
?>

<div>
  <fieldset>
      <legend>Calendario</legend>    
  <div id="calendarih" style="float:left;width:50%;min-height:180px"></div>                     
  <div id="ciudad_info_ph" style="float:left;width:33%;margin-top:10px;font-weight:bold;font-size:20px;text-transform:capitalize;">Barcelona</div>                       
  <div id="hotel_activoh" style="float:left;width:33%;margin-top:10px;font-weight:bold;font-size:20px;text-transform:capitalize;"></div>                       
  <div id="acciones_diah" style="float:left;width:50%;margin-top:30px;font-weight:bold;font-size:20px"></div>  
  </fieldset>
  <?php 
  //include dirname(__FILE__).'/scripts/formulario.php';                         
  //include dirname(__FILE__).'/scripts/formulario_suspension.php';                     
  include dirname(__FILE__).'/scripts/formulario_hoteles_disponibles.php';                                                          
  ?>
</div>

 
<div class="cabecera" id="header_hoteles" style="display:none"  >
  <div id="diah"></div>
</div> 
<div class="cl" ></div>
<div class="mensaje" id="mensaje_graella"></div>

<script type="text/javascript">
var setHoteles=false;
var ciudad_auxh="";                

function click_diah(d) 
{ 
	// quan clickes dia a calendari
   var ale='&gg'+(Math.floor(Math.random()*50000))+'=1';	
   get_hoteles();  
   dia_selh=d;
   id_('diah').innerHTML='Dia actual: <span style="color:#f04">'+dia_selh+'</span>';
   var _d=dia_selh.split("-"); 
   _d=_d[2]+'-'+_d[1]+'-'+_d[0];
   var ciudad;
   if($.trim(ciudad_auxh)=="") 
	   {
	   	ciudad='barcelona';
	   }	
   else 
	   {
	   	ciudad=ciudad_auxh;
	   }	

   
   var r2=ajax.load('tabs/scripts/consultar_codigo_hotel.php?ciudad='+ciudad+'&fecha='+d+ale);                   
   var hotel = r2.split('#');
   var codigo_hotel_secundario = hotel[0];
   //var nombre_hotel_activo = hotel[1];
   var cambio_a_hotel_defecto = hotel[2];                           
   var texto;

   //hotel_defecto indica si el botón para cambiar de estado nos llevará al hotel por defecto (hotel_defecto=1) 
   //o al secundario (hotel_defecto=2)
   var texto1='Cambiar a hotel secundario ';  
   var texto2='Cambiar a hotel por defecto ';   

   if (cambio_a_hotel_defecto==0) 
	   {
	   texto = texto1;
	   }
   else 
	   {
	   texto=texto2;
	   }

   var r1=ajax.load('tabs/scripts/consultar_hotel_defecto.php?ciudad='+ciudad+'&hotel_defecto=1&fecha='+dia_selh+ale);
   var r2=ajax.load('tabs/scripts/consultar_hotel_defecto.php?ciudad='+ciudad+'&hotel_defecto=0&fecha='+dia_selh+ale);

   r1=r1.split('#');  
   r2=r2.split('#');   

   var codigo_hotel_secundario=r2[0];  
   //alert(r1[0]);
   var codigo_hotel_defecto=r1[0];  
   var nombre_hotel_activo=r1[1];	     
   var disponibilidad_fecha=r1[2];


   if (cambio_a_hotel_defecto==0)
   {
	   nombre_hotel_activo=r1[1];
	   codigo_hotel_cambio=r2[0];    
	   disponibilidad_fecha=1;
   }   
   else
   {
	   nombre_hotel_activo=r2[1];   
	   disponibilidad_fecha=r2[2];  
	   codigo_hotel_cambio=r1[0];  
	   /*
	   if (disponibilidad_fecha==0)
	   {
		   codigo_hotel_activo=r2[0];  //si no hay disponibilidad en el secundario modificaremos la disponibilidad en su registro.
	   }		   
	   else
	   {
		   codigo_hotel_activo=r1[0]; //en caso contrario cambiaremos al hotel por defecto y eliminaremos el registro.
	   }
	   */
   }
/*
alert(1);
alert(r1[0]);   
alert(r2[0]);   
alert(21);
*/
   if (r2.length==1) //si el array2 que contiene los datos del secundario está vacío entonces es que sólo
												 //existe 1 hotel en cuyo caso también mostraremos el botón para eliminar toda disponibilidad.
   {   
	   //alert(3);
	   nombre_hotel_activo=r1[1];	
	   var acciones_dia =_d+' &#160;&#160;&#160;&#160;<a style="margin-bottom:10px;color:#fff;background:#0f0;border:1px solid #0f0;padding:1px;display:inline-block;width:325px;" href="javascript:ac_diah(\''+dia_selh+'\',\'\',0,1)">'+texto1+'</a>'; 		
	   if (disponibilidad_fecha==1)
	   {   
		   acciones_dia += '<br><a style="color:#fff;background:#000;border:1px solid #000;color:#fff;padding:1px;margin-left:153px;font-size:14px;" href="javascript:ac_diah(\''+dia_selh+'\','+'\''+codigo_hotel_defecto+'\',0,0)">Marcar Sin disponibilidad</a>';
	   }
	   else
	   {
		   acciones_dia += '<br><a style="color:#fff;background:#000;border:1px solid #000;color:#fff;padding:1px;margin-left:153px;font-size:14px;" href="javascript:ac_diah(\''+dia_selh+'\','+'\''+codigo_hotel_defecto+'\',0,1)">Marcar disponibilidad</a>';
	   }   
   }
   else
   //else if (cambio_a_hotel_defecto==1)//1: estamos en el secundario.    
   {
		//alert(4);
		var acciones_dia =_d+' &#160;&#160;&#160;&#160;<a style="margin-bottom:10px;color:#fff;background:#0f0;border:1px solid #0f0;padding:1px;display:inline-block;width:325px;" href="javascript:ac_diah(\''+dia_selh+'\','+'\''+codigo_hotel_cambio+'\','+cambio_a_hotel_defecto+',1)">'+texto+'</a>'; 
	   if (disponibilidad_fecha==1)
	   {   
		   //acciones_dia += '<br><a style="color:#fff;background:#000;border:1px solid #000;color:#fff;padding:1px;margin-left:153px;font-size:14px;" href="javascript:ac_diah(\''+dia_selh+'\','+'\''+codigo_hotel_secundario+'\',0,0)">Marcar Sin disponibilidad H.'+nombre_hotel_activo+'</a>';
		   acciones_dia += '<br><a style="color:#fff;background:#000;border:1px solid #000;color:#fff;padding:1px;margin-left:153px;font-size:17px;" href="javascript:ac_diah(\''+dia_selh+'\','+'\''+codigo_hotel_secundario+'\',0,0)">Marcar Sin disponibilidad</a>';
	   }
	   else
	   {
		   //acciones_dia += '<br><a style="color:#fff;background:#000;border:1px solid #000;color:#fff;padding:1px;margin-left:153px;font-size:14px;" href="javascript:ac_diah(\''+dia_selh+'\','+'\''+codigo_hotel_secundario+'\',0,1)">Marcar disponibilidad H.'+nombre_hotel_activo+'</a>';
		   acciones_dia += '<br><a style="color:#fff;background:#000;border:1px solid #000;color:#fff;padding:1px;margin-left:153px;font-size:17px;" href="javascript:ac_diah(\''+dia_selh+'\','+'\''+codigo_hotel_secundario+'\',0,1)">Marcar disponibilidad</a>';
	   }   
   }
   id_('hotel_activoh').innerHTML=nombre_hotel_activo;
   id_('acciones_diah').innerHTML= acciones_dia;}


function ac_diah(d,codigo,hotel_defecto,disponibilidad) 
{
 	var ale='&gg'+(Math.floor(Math.random()*50000))+'=1';
    var ciudad;

	
    if ($.trim(codigo)=='')
    {
        alert('No existe hotel secundario para esta ciudad');
        return;
    }

    if($.trim(ciudad_auxh)=="") 
 	   {
 	   	ciudad='barcelona';
 	   }	
    else 
 	   {
 	   	ciudad=ciudad_auxh;
 	   }
	<?php 
	$texto1 = utf8_decode('Se va a restaurar el hotel por defecto para la fecha seleccionada. Está seguro de que desea continuar?'); 
	$texto2 = utf8_decode('Se va a cambiar a un hotel secundario en la fecha seleccionada. Está seguro de que desea continuar?'); 
	$texto3 = utf8_decode('Se va a eliminar la disponibilidad para todos los hoteles en la fecha seleccionada. Está seguro de que desea continuar?'); 
	?>

	if (hotel_defecto==0)
	{
		if (disponibilidad)
		{
			  texto='<?php echo($texto2)?>';
		}
		else
		{
			  texto='<?php echo($texto3)?>';
		}
	
	}
	else
	{
			  texto='<?php echo($texto1)?>';
    }	
  
	if (confirm(texto))		
	{ 
		var r=ajax.load('tabs/scripts/guardar_codigo_hotel.php?ciudad='+ciudad+'&codigo='+codigo+'&fecha='+d+'&hotel_defecto='+hotel_defecto+'&disponibilidad='+disponibilidad+ale);   
		//alert(r);
		
	}
		 

  id_('calendarih').innerHTML=cridah(v_mesh,v_anoh);
  get_hoteles();
  click_diah(d);

}

                                     
function get_hoteles() 
{
	var ale='?gg'+(Math.floor(Math.random()*50000))+'=1';
	document.getElementById('frm_hoteles_disponibles').reset();
	var rhtml=ajax.load('<?php echo $base_scripts ?>cargar_listado_hoteles.php?html=1'+ale);
	$('#listado_hoteles').html(rhtml);     
}


function cridah(m,a) 
{
	  var ale='&gg'+(Math.floor(Math.random()*50000))+'=1';
	  var ciudad;
	  if($.trim(ciudad_auxh)=="") 
	  {
		 ciudad='barcelona';
	  }	
	  else 
	  {
		 ciudad=ciudad_auxh;
	  }	  
	  var r= ajax.load('<?php echo $base_scripts ?>calendario_hoteles.php?mes='+m+'&ano='+a+'&ciudad='+ciudad);
  	  return r;
}

function mostrar_hotel_defecto(ciudad)
{
	var ale='&gg'+(Math.floor(Math.random()*50000))+'=1';
	var rhtml=ajax.load('<?php echo $base_scripts ?>consultar_hotel_defecto.php?ciudad='+ciudad+ale);   
	$('#hotel_activoh').html(rhtml);     
	
}

id_('calendarih').innerHTML=cridah(v_mesh,v_anoh);




</script>

<div id="lhoteles" style="display:none;float:left;width:100%;">  
<div id="lista_hoteles" style="text-align:left;padding:10px; background:#fff;"> 
	<div id="listado_hoteles" name="listado_hoteles">  
	   
	</div>
</div>
</div>	

<?php 
//include 'disponibles.php';
?>

<script>




function cambiar_hoteles_disponibles()
{
	var ale='?gg'+(Math.floor(Math.random()*50000))+'=1';
	document.getElementById('frm_hoteles_disponibles').reset();
	var rhtml=ajax.load('<?php echo $base_scripts ?>cargar_lista_hoteles.php?html=1'+ale);
	//var rscript=ajax.load('<?php echo $base_scripts ?>cargar_lista_hoteles.php?html=0'+ale);
	// rscript=rscript.replace("/","\/");
	//document.write(rscript);
	$('#frm_hoteles_disponibles').html(rhtml);
  	$.colorbox({width:"55%", height:"550px",inline:true, href:"#form_hoteles_disponibles",open:true});
}      
    

  
</script> 


   </body>
 </html>
 
 
 
 
 

