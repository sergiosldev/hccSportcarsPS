<?php  

include dirname(__FILE__).'/scripts/config_events.php'; ?>
<script type="text/javascript" src="tabs/js/sha.js"></script>
<script type="text/javascript" src="tabs/js/funcs_fechas.js"></script>

<script>
/*
    var pass=0;
    var index_sha=0;
    do{
    pass = prompt("Introduce password", "")
    if(++index_sha==4)window.location='http://lon.motorclubexperience.com/admin888/'    
    }while(SHA1(pass)!='c90d2c47658527c7269e392e5667d767d36be1af')

*/
</script>

<script type="text/javascript" src="tabs/js/funcs.js?id=<?php echo(rand(0,50000));?>"></script>
<script type="text/javascript" src="tabs/js/ajax_load.js"></script>
<script type="text/javascript" src="tabs/js/ajax_load_post.js"></script>
<link rel="stylesheet" type="text/css" href="tabs/css/style.css">
<link rel="stylesheet" type="text/css" href="tabs/css/botones_menu.css">
<link media="screen" rel="stylesheet" href="tabs/modal/colorbox.css" />
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.4.4/jquery.min.js"></script>
<script src="tabs/modal/colorbox/jquery.colorbox.js"></script>
<script>
$(document).ready(function(){
    //Examples of how to assign the ColorBox event to elements
    $(".example8").colorbox({width:"40%", inline:true, href:"#inline_example1"});
    $(".form_").colorbox({width:"60%", inline:true, href:"#form_"});
    $(".buscar_contact").colorbox({width:"60%", inline:true, href:"#buscar_contact"});
    //Example of preserving a JavaScript event for inline calls.
    
});
</script>
<script>

/* VARIABLES GLOBALS */
var v_mes=<?php echo date('m'); ?>;
var v_ano=<?php echo date('Y'); ?>;
var dia_sel='';
</script>

<div id="centrar">
<?php 
include dirname(__FILE__).'/scripts/tipus.php';
include dirname(__FILE__).'/scripts/formulario_validar_password.php';   

?>

<div>
  <fieldset>
      <legend>Calendario</legend>    
  <div id="calendari" style="float:left;width:50%;min-height:180px" ></div>
  <div id="tipus_img" style="float:left;width:15%;min-height:180px;position:relative;" >tipus</div>
  <div id="ciudad_info_p" style="float:left;width:33%;margin-top:10px;font-weight:bold;font-size:20px;text-transform:capitalize;">Barcelona</div>

  <div id="acciones_dia" style="float:left;width:33%;margin-top:30px;font-weight:bold;font-size:20px"></div>
  </fieldset>
  <?php 
  include dirname(__FILE__).'/scripts/formulario.php';
  include dirname(__FILE__).'/scripts/formulario_reubicacion.php';
  ?>
</div>
<?php 
include 'menu_eines.php'; 
?>

<div id="caixa_editor" style="display:block;padding-left:20px">
  <p style="text-align:left" >
    <a href="javascript:abrir_cerrar(0)"><img alt="" src="tabs/img/esborra.gif"> CERRAR EDITOR</a> | 
    <a href="javascript:envia_email_massiu()"><span style="color:#f33;font-weight:bold;font-size:15px">@</span> ENVIAR</a> 
     <!--
     <button type="button" style="width:130px;font-size:9px" onclick="envia_email_massiu()">ENVIAR</button>
     -->
  </p>
  <p>
   <div id="editorObj" style="width: 50%; height: 300px; border: #a4bed4 1px solid;"></div>
  </p>
</div>
<div class="cabecera" id="header_graella" style="display:none"  >
  <div id="dia"></div>
  <div id="headers">
    <div class="fl" style="width:140px"></div>
    <div class="fl" style="width:132px"></div> 
    <div class="fl" style="width:75px"></div>
    <div class="fl" style="width:130px"></div>
    <div class="fl" style="width:66px"></div>
  </div>
</div> 
<div class="cl" ></div>
<div class="mensaje" id="mensaje_graella"></div>
<div id="graella" ></div>
</div>
<script>
//var tipus_ev=document.getElementById('tipus_ev').options[ document.getElementById('tipus_ev').selectedIndex ].value;

// TIPUS PER DEFECTE
//var tipus_ev='_porsche_';
var tipus_ev='ferrari';
var setGraella=false;
//id_("r_porsche_").checked=true
//id_("_porsche_").className='boton_menu_tipo menu_activo';
id_('tipus_img').innerHTML='<img style="padding:4px;border:1px solid #000" width="100px" alt="" src="../../img/c/8.jpg">';
var ciudad_aux=""                

function click_dia(d) 
{ // quan clickes dia a calendari
   get_graella(d)
   dia_sel=d;
   id_('dia').innerHTML='Dia actual: <span style="color:#f04">'+dia_sel+'</span>';
   id_('alta').style.display="none"
   var _d=dia_sel.split("-"); 
   _d=_d[2]+'-'+_d[1]+'-'+_d[0];
   id_('acciones_dia').innerHTML=''+_d+' &#160;&#160;&#160;&#160;<a style="color:#0f0;background:#0f0;border:1px solid #0f0;padding:1px" href="javascript:ac_dia(\''+dia_sel+'\',1)">&#160;&#160;</a> '+
   ' <a style="border:1px solid #33f;background:#33f;padding:1px" href="javascript:ac_dia(\''+dia_sel+'\',0)">&#160;&#160;</a>'+
   ' <a style="border:1px solid #d0629e;background:#d0629e;padding:1px" href="javascript:ac_dia(\''+dia_sel+'\',3)">&#160;&#160;</a>'+
   ' <a style="border:1px solid #f00;background:#f00;padding:1px" href="javascript:ac_dia(\''+dia_sel+'\',2)">&#160;&#160;</a>' +
   //mts 07052012.
   ' <a style="border:1px solid #888888;background:#888888;padding:1px" href="javascript:ac_dia(\''+dia_sel+'\',4)">&#160;&#160;</a>';
}

function ac_dia(d,a) {
  var ale='&gg'+(Math.floor(Math.random()*50000))+'=1'
  var r='ll';    
  if (a == 0) 
	{
    r = ajax.load('<?php echo $base_scripts ?>ajax.php?esborra_dia=' + d + '&ciudad='+ciudad_aux+'&tipus='+tipus_ev+ale);
    } 
  else 
	{
    r = ajax.load('<?php echo $base_scripts ?>ajax.php?marca_dia=' + d + '&ciudad='+ciudad_aux+'&tipus='+tipus_ev+'&color='+a+ale);     
    alert(r);
  	}
  id_('calendari').innerHTML=crida(v_mes,v_ano)
  id_('alta').style.display='none'
  get_graella(dia_sel)

}

function alta(d,h,h_aux,t) 
{ 
  
  $(".form_").colorbox({width:"80%", inline:true, href:"#form_",open:true});
  document.getElementById('form_alta').reset()
  document.getElementById('id_alta').value=d+'@'+h
  id_('edicio').value='false';
  id_('tipus_field').style.display='block';
  id_('tipus').value='_porsche_'
  id_('ciudad').value=ciudad_aux
  //window.location="#form_alta"
  id_('msg_error').innerHTML='';
}

function esborra(id,id_ev) // quan esborres pilot
{
  var texto='';
  if (ciudad_aux=='rutas_turisticas')
  {
	  texto = 'Estas seguro que deseas borrar esta inscripcion y las posibles reservas asociadas?';
  }	
  else
  {
	  texto = 'Estas seguro que deseas borrar esta inscripcion';
  }
  if (confirm(texto)) {
    var ale='&gg'+(Math.floor(Math.random()*50000))+'=1'         
    r = ajax.load('<?php echo $base_scripts ?>ajax.php?esborra=' + id + '&id_event=' + id_ev + '&ciudad='+ciudad_aux+'&tipus=' + tipus_ev+ale);
    //alert(r);
    get_graella(dia_sel);
    id_('calendari').innerHTML = crida(v_mes, v_ano)
  }
}

function get_graella(dia) {
  var ale='&gg'+(Math.floor(Math.random()*50000))+'=1'
  <?php $f=''; if($front)$f='&front=1' ?>
  var r=ajax.load('<?php echo $base_scripts ?>graella.php?data='+dia+'&ciudad='+ciudad_aux+'&tipus='+tipus_ev+'<?php echo $f; ?>'+ale);  
  id_('graella').innerHTML=r;
  setGraella=true
  id_('header_graella').style.display='block';          
}


function get_graella_instructors() {
  var dia = dia_sel;
  var ale='&gg'+(Math.floor(Math.random()*50000))+'=1'
  <?php $f=''; if($front)$f='&front=1' ?>
  //var r=ajax.load('<?php echo $base_scripts ?>graella_instructors.php?data='+dia+'&ciudad='+ciudad_aux+'&tipus='+tipus_ev+'<?php echo $f; ?>'+ale);  
  //var r=ajax.load('<?php echo $base_scripts ?>test.php?data='+dia+'&ciudad='+ciudad_aux+'&tipus='+tipus_ev+'<?php echo $f; ?>'+ale);  



  var tipo_bautizo='';
 
  document.getElementById('form_excel').action= '<?php echo $base_scripts ?>graella_instructors.php?data='+dia+'&ciudad='+ciudad_aux+'&tipus='+tipus_ev+'&tipus_b='+tipo_bautizo+'<?php echo $f; ?>'+ale;
  document.getElementById('form_excel').submit();


  //id_('graella').innerHTML=r;
  //setGraella=true
  //id_('header_graella').style.display='block';          
}


function get_graella_instructors_20km7km() {
  var dia = dia_sel;
  var ale='&gg'+(Math.floor(Math.random()*50000))+'=1'
  <?php $f=''; if($front)$f='&front=1' ?>
  //var r=ajax.load('<?php echo $base_scripts ?>graella_instructors.php?data='+dia+'&ciudad='+ciudad_aux+'&tipus='+tipus_ev+'<?php echo $f; ?>'+ale);  
  //var r=ajax.load('<?php echo $base_scripts ?>test.php?data='+dia+'&ciudad='+ciudad_aux+'&tipus='+tipus_ev+'<?php echo $f; ?>'+ale);  

  var tipo='';
  switch(tipus_ev)  
  {
    case '_bferrari_':
		tipo = 'ferrari';
	break;
	case '_blamborghini_':
		tipo = 'lamborghini';
	break;
	case '_bporsche_':
		tipo = '_porsche_';
	break;
	default:
		tipo = tipus_ev;
	break;  
 }  



  var tipo_bautizo='';
  switch(tipo)  
  {
    case 'ferrari':
		tipo_bautizo = '_bferrari_';
	break;
	case 'lamborghini':
		tipo_bautizo = '_blamborghini_';
	break;
	case '_porsche_':
		tipo_bautizo = '_bporsche_';
	break;
	default:
	break;  
 }  
 
  document.getElementById('form_excel').action= '<?php echo $base_scripts ?>graella_instructors_20km7km.php?data='+dia+'&ciudad='+ciudad_aux+'&tipus='+tipo+'&tipus_b='+tipo_bautizo+'<?php echo $f; ?>'+ale;
  document.getElementById('form_excel').submit();



  //id_('graella').innerHTML=r;
  //setGraella=true
  //id_('header_graella').style.display='block';          
}


 
function get_graella_organizadores(_h_) {

  var dia = dia_sel;
  var ale='&gg'+(Math.floor(Math.random()*50000))+'=1'
  <?php $f=''; if($front)$f='&front=1' ?>
  //var r=ajax.load('<?php echo $base_scripts ?>graella_instructors.php?data='+dia+'&ciudad='+ciudad_aux+'&tipus='+tipus_ev+'<?php echo $f; ?>'+ale);  
  //var r=ajax.load('<?php echo $base_scripts ?>test.php?data='+dia+'&ciudad='+ciudad_aux+'&tipus='+tipus_ev+'<?php echo $f; ?>'+ale);  


  var r=ajax.load('<?php echo $base_scripts ?>graella_organizadores.php?horas='+_h_+'&data='+dia+'&ciudad='+ciudad_aux+'&tipus='+tipus_ev+'<?php echo $f; ?>'+ale);  


  document.getElementById('gf_pdf').value=r;   
  document.getElementById('horas').value=_h_;
 //alert(document.getElementById('gf').value); 
  	
  //document.getElementById('form_pdf').action= '<?php echo $base_scripts ?>graella_organizadores.php?data='+dia+'&ciudad='+ciudad_aux+'&tipus='+tipus_ev+'<?php echo $f; ?>'+ale;
  document.getElementById('form_pdf').action= '<?php echo $base_scripts ?>generar_pdf_organizadores.php';
  document.getElementById('form_pdf').submit();
}


function get_graella_organizadores_20km7km() {

  var dia = dia_sel;
  var ale='&gg'+(Math.floor(Math.random()*50000))+'=1'
  <?php $f=''; if($front)$f='&front=1' ?>


  var tipo='';
  switch(tipus_ev)  
  {
    case '_bferrari_':
		tipo = 'ferrari';
	break;
	case '_blamborghini_':
		tipo = 'lamborghini';
	break;
	case '_bporsche_':
		tipo = '_porsche_';
	break;
	default:
		tipo=tipus_ev;
	break;  
 }  

  var tipo_bautizo='';
  switch(tipo)  
  {
    case 'ferrari':
		tipo_bautizo = '_bferrari_';
	break;
	case 'lamborghini':
		tipo_bautizo = '_blamborghini_';
	break;
	case '_porsche_':
		tipo_bautizo = '_bporsche_';
	break;
	default:
	break;
 }
 
  var r=ajax.load('<?php echo $base_scripts ?>graella_organizadores_20km7km.php?horas=mt&data='+dia+'&ciudad='+ciudad_aux+'&tipus='+tipo+'<?php echo $f; ?>&tipus_b='+tipo_bautizo+ale);  

  //var r2=ajax.load('<?php echo $base_scripts ?>graella_organizadores.php?horas=t&data='+dia+'&ciudad='+ciudad_aux+'&tipus='+tipo_bautizo+'<?php echo $f; ?>'+ale);  

//alert(r);
  //document.getElementById('gf_pdf').value=r+'<br><br>'+r2;   
  document.getElementById('gf_pdf').value=r;   
  document.getElementById('horas').value='';
  //_h_;
 //alert(document.getElementById('gf').value); 
  	
  //document.getElementById('form_pdf').action= '<?php echo $base_scripts ?>graella_organizadores.php?data='+dia+'&ciudad='+ciudad_aux+'&tipus='+tipus_ev+'<?php echo $f; ?>'+ale;
  document.getElementById('form_pdf').action= '<?php echo $base_scripts ?>generar_pdf_organizadores.php';
  document.getElementById('form_pdf').submit();
}





function desglose_tipos(ptipo)
{
	  var tipo='';
	  switch(ptipo)  
	  {
	    case '_bferrari_':
			tipo = 'ferrari';
		break;
		case '_blamborghini_':
			tipo = 'lamborghini';
		break;
		case '_bporsche_':
			tipo = '_porsche_';
		break;
		case '_bcorvette_':
			tipo = '_corvette_';
		break;
		default:
			tipo=ptipo;
		break;  
	 }  

	  var tipo_bautizo='';
	  switch(tipo)  
	  {
	    case 'ferrari':
			tipo_bautizo = '_bferrari_';
		break;
		case 'lamborghini':
			tipo_bautizo = '_blamborghini_';
		break;
		case '_porsche_':
			tipo_bautizo = '_bporsche_';
		break;
		case '_corvette_':
			tipo_bautizo = '_bcorvette_';
		break;
		default:
		break;
	 }
	return tipo+'#'+tipo_bautizo;	
}

function get_graella_organizadores_20km7km_todos() {

	  var dia = dia_sel;
	  var ale='&gg'+(Math.floor(Math.random()*50000))+'=1';
	  var tipo_bautizo='';
	  var tipo = '';
	  var tiposa=null;
	  var tipos='';
	  var r=null;
	  var k=1;
	  <?php $f=''; if($front)$f='&front=1' ?>


	  var eventos = new Array ('ferrari','lamborghini','_porsche_','_corvette_');	    

	  for (var i=0;i<eventos.length;i++)
	  { 
		tiposa = desglose_tipos(eventos[i]);
	  	tipos = tiposa.split('#');
	  	tipo = tipos[0];
		stipo=tipo.replace('_','');
		stipo=stipo.replace('_',''); 	
	  	tipo_bautizo=tipos[1];
	  	$('#mensaje_graella').html('Espere un momento: Procesando listado <strong>'+((ciudad_aux=='')?'Barcelona':ciudad_aux)+'</strong> - <strong> '+stipo+'...</strong>');
	  	r=ajax.load('<?php echo $base_scripts ?>graella_organizadores_20km7km_todos.php?horas=mt&data='+dia+'&ciudad='+ciudad_aux+'&tipus='+tipo+'<?php echo $f; ?>&tipus_b='+tipo_bautizo+ale);  

		document.getElementById('gf_pdfi').value=r;   
		document.getElementById('hf_pdfi').value=k;   
		document.getElementById('horas_pdfi').value='';	  	
		var dades=obtenirDadesForm('form_pdfi');
	  	r2=ajax_post.load('<?php echo $base_scripts ?>generar_pdf_organizadores_todos.php',dades+ale);
	  	//document.write(r2);
	  	//return;  
	  	
/*		document.getElementById('gf_pdfi').value=r;   
		document.getElementById('hf_pdfi').value=k;   
		document.getElementById('horas_pdfi').value='';
		document.getElementById('form_pdfi').action= '<?php echo $base_scripts ?>generar_pdf_organizadoresb.php';
		
		document.getElementById('form_pdfi').submit();
*/
		k=k+1;
		
	  }   	

	  k=k-1;	
	  document.getElementById('form_pdf').action= '<?php echo $base_scripts ?>concatenar_pdf.php?num_listados='+k+ale;                       
	  document.getElementById('form_pdf').submit();
	  $('#mensaje_graella').html('');

	return;

	}





/*
function get_graella_organizadores_20km7km() {

  var dia = dia_sel;
  var ale='&gg'+(Math.floor(Math.random()*50000))+'=1'
  <?php $f=''; if($front)$f='&front=1' ?>

  var tipo='';
  switch(tipus_ev)  
  {
    case '_bferrari_':
		tipo = 'ferrari';
	break;
	case '_blamborghini_':
		tipo = 'lamborghini';
	break;
	case '_bporsche_':
		tipo = '_porsche_';
	break;
	default:
		tipo=tipus_ev;
	break;  
 }  


  var r=ajax.load('<?php echo $base_scripts ?>graella_organizadores_20km7km.php?&data='+dia+'&ciudad='+ciudad_aux+'&tipus='+tipo+'<?php echo $f; ?>'+ale);  

 //alert(tipo_bautizo);
 
  //var r2=ajax.load('<?php echo $base_scripts ?>graella_organizadores.php?horas='+_h_+'&data='+dia+'&ciudad='+ciudad_aux+'&tipus='+tipo_bautizo+'<?php echo $f; ?>'+ale);  

  document.getElementById('gf_pdf').value=r;   
  //alert(r);
  return;
  document.getElementById('horas').value=''; //_h_; 
 //alert(document.getElementById('gf').value); 
  	
  //document.getElementById('form_pdf').action= '<?php echo $base_scripts ?>graella_organizadores.php?data='+dia+'&ciudad='+ciudad_aux+'&tipus='+tipus_ev+'<?php echo $f; ?>'+ale;
  document.getElementById('form_pdf').action= '<?php echo $base_scripts ?>generar_pdf_organizadores.php';
  document.getElementById('form_pdf').submit();
}
*/


/*
function edita(id) // quan esborres pilot
{
  var ale='&gg'+(Math.floor(Math.random()*50000))+'=1'
  id_('msg_error').innerHTML='';
  document.getElementById('form_alta').reset()
  $(".form_").colorbox({width:"60%", inline:true, href:"#form_",open:true});
  //id_('alta').style.display="block"
  r=ajax.load('<?php echo $base_scripts ?>ajax.php?id_edita='+id+ale+'&ciudad='+ciudad_aux);
  //alert(r);
  id_('edicio').value='true';
}
*/

function edita(id) //quan esborres pilot
{
  var ale='&gg'+(Math.floor(Math.random()*50000))+'=1'
  id_('msg_error').innerHTML='';
  document.getElementById('form_alta').reset()
  $(".form_").colorbox({width:"60%", inline:true, href:"#form_",open:true});
  //id_('alta').style.display="block"
  r=ajax.load('<?php echo $base_scripts ?>ajax.php?id_edita='+id+ale+'&ciudad='+ciudad_aux+'&tipus='+tipus_ev);
  eval(r);
  id_('edicio').value='true';
}

function email(id,t) {
  if (confirm("Estas seguro que deseas enviar el email") ) {
      r = ajax.load('<?php echo $base_scripts ?>ajax.php?email_=' + id + '&ciudad='+ciudad_aux+'&id_event=' + t);
      alert(r);
  }
}

function ocupa(h) {
   var ale='&gg'+(Math.floor(Math.random()*50000))+'=1'
   r=ajax.load('<?php echo $base_scripts ?>ajax.php?ocupa='+h+'&ciudad='+ciudad_aux+'&tipus='+tipus_ev+ale);    
  // alert(r);
   get_graella(dia_sel)
}

function ocupar_horas(h){
  if (setGraella) {
      var  ale = '&gg' + (Math.floor(Math.random() * 50000)) + '=1'
      r = ajax.load('<?php echo $base_scripts ?>ajax.php?ocupat=1&periodo='+h+'&ciudad='+ciudad_aux+'&tipus=' + tipus_ev + ale);
      alert(r);
      get_graella(dia_sel)
   }
}

function crida(m,a) {
	  var ale='&gg'+(Math.floor(Math.random()*50000))+'=1'
  var r= ajax.load('<?php echo $base_scripts ?>calendari.php?mes='+m+'&ano='+a+'&ciudad='+ciudad_aux+'&tipus='+tipus_ev+ale);

  return r;
}

id_('calendari').innerHTML=crida(v_mes,v_ano)
//get_graella(dia_sel)
//id_('dia').innerHTML='Dia actual: '+dia_sel;

function descripcion_ruta(ruta)
{
	var desc = '';
	switch(ruta) 
	{
		case 'ferrari_ruta_turistica1':
			desc = 'BCN (paseo mar韙imo) - Ferrari ';
			break;
		case 'ferrari_ruta_turistica2':
			desc = 'BCN (paseo mar韙imo + sagrada fam韑ia) - Ferrari ';
			break;
		case 'ferrari_ruta_turistica3':
			desc = 'Sitges - Ferrari ';
			break;
		case 'ferrari_ruta_turistica4':
			desc = 'Montserrat - Ferrari ';
			break;
		case 'lamborghini_ruta_turistica1':
			desc = 'BCN (paseo mar韙imo) - Lamborghini ';
			break;
		case 'lamborghini_ruta_turistica2':
			desc = 'BCN (paseo mar韙imo + sagrada fam韑ia) - Lamborghini ';
			break;
		case 'lamborghini_ruta_turistica3':
			desc = 'Sitges - Lamborghini ';
			break;
		case 'lamborghini_ruta_turistica4':
			desc = 'Montserrat - Lamborghini ';
			break;
		}
	return desc;
		
}

function envia_formulari() {
    var ale='&gg'+(Math.floor(Math.random()*50000))+'=1'    
    var dades=obtenirDadesForm('form_alta');
	var plazas=0;
	//alert(tipus_ev.substr(-15));
    switch(tipus_ev.substr(-15))
    {
		case 'ruta_turistica1':
	    	plazas=1;
	    break;
    	case 'ruta_turistica2':
        	plazas=2;
        break;
		case 'ruta_turistica3':
	    	plazas=3;
	    break;
		case 'ruta_turistica4':
	    	plazas=5;
	    break;
    }

if (plazas>0) 
    {
	       if (!confirm('Si es la primera vez que modifica esta reserva se van a crear '+plazas+' reservas para la ruta.'+descripcion_ruta(tipus_ev)+ ' \nEn caso contrario se van a modificar todas las plazas asociadas a esta reserva. Esta seguro?'))
				return;
    }        

    r=ajax.load('<?php echo $base_scripts ?>ajax.php?'+dades+ale+'&ciudad='+ciudad_aux);
    var ok=/OK/;
    if (ok.test(r)) 
    { 
     // recarrega graella
     //alert(r)
     id_('msg_error').innerHTML='Recepci贸n correcte';
      get_graella(dia_sel)
      id_('alta').style.display="none"
    } 
    else 
    {    
     //id_('msg_error').innerHTML=r;
     alert(r);
     get_graella(dia_sel)
    }
}



function descarga_mails_dia(){
  window.location="http://lon.motorclubexperience.com/admin888/tabs/scripts/descargar_mails.php?mails_day="+dia_sel+"&ciudad="+ciudad_aux+"&tipus="+tipus_ev
}
function descarga_mails_dia_conf(){
  window.location="http://lon.motorclubexperience.com/admin888/tabs/scripts/descargar_mails.php?mails_day_conf="+dia_sel+"&ciudad="+ciudad_aux+"&tipus="+tipus_ev
}
function descarga_mails_all(tipoc,fdesde,fhasta){
  window.location="http://lon.motorclubexperience.com/admin888/tabs/scripts/descargar_mails.php?mails_all=1&tipoc="+tipoc+"&fdesde="+fdesde+"&fhasta="+fhasta;
}

function descarga_mails_barcelona(tipoc,fdesde,fhasta){
// alert(tipus_ev)   
  window.location="http://lon.motorclubexperience.com/admin888/tabs/scripts/descargar_mails.php?mails_bcn=1&tipoc="+tipoc+"&fdesde="+fdesde+"&fhasta="+fhasta;
}

function descarga_mails_madrid(tipoc,fdesde,fhasta){
  window.location="http://lon.motorclubexperience.com/admin888/tabs/scripts/descargar_mails.php?mails_mad=1&tipoc="+tipoc+"&fdesde="+fdesde+"&fhasta="+fhasta;
}

function descarga_mails_valencia(tipoc,fdesde,fhasta){
  window.location="http://lon.motorclubexperience.com/admin888/tabs/scripts/descargar_mails.php?mails_val=1&tipoc="+tipoc+"&fdesde="+fdesde+"&fhasta="+fhasta;
}

function descarga_mails_andalucia(tipoc,fdesde,fhasta){
  window.location="http://lon.motorclubexperience.com/admin888/tabs/scripts/descargar_mails.php?mails_and=1&tipoc="+tipoc+"&fdesde="+fdesde+"&fhasta="+fhasta;
}

function descarga_mails_cantabria(tipoc,fdesde,fhasta){
  window.location="http://lon.motorclubexperience.com/admin888/tabs/scripts/descargar_mails.php?mails_can=1&tipoc="+tipoc+"&fdesde="+fdesde+"&fhasta="+fhasta;
}



/* mts 30092012 reestructuraci贸 men煤 eines */

function ocultar_menus() {
  document.getElementById('print').style.display='none';
  document.getElementById('print_organizador').style.display='none';
  document.getElementById('print_instructor').style.display='none';
  document.getElementById('emails').style.display='none';
  document.getElementById('emails_ciudad').style.display='none';
  abrir_cerrar(0);
}
function mostrar_menu_print() {
  document.getElementById('print').style.display='block';
  document.getElementById('emails').style.display='none';
  document.getElementById('emails_ciudad').style.display='none';
  abrir_cerrar(0);
}

function mostrar_menu_print_organizador()
{
  document.getElementById('print_organizador').style.display='block';
  document.getElementById('print_instructor').style.display='none';
  document.getElementById('emails').style.display='none';
  document.getElementById('emails_ciudad').style.display='none';
  abrir_cerrar(0);
}

function mostrar_menu_print_instructor()
{
  document.getElementById('print_organizador').style.display='none';
  document.getElementById('print_instructor').style.display='block';
  document.getElementById('emails').style.display='none';
  document.getElementById('emails_ciudad').style.display='none';
  abrir_cerrar(0);
}


function mostrar_menu_emails() {
  document.getElementById('print').style.display='none';
  document.getElementById('emails').style.display='block';
  document.getElementById('emails_ciudad').style.display='none';
  abrir_cerrar(0);
}
function mostrar_menu_emails_ciudad() {
  document.getElementById('print').style.display='none';
  document.getElementById('emails').style.display='none';
  document.getElementById('emails_ciudad').style.display='block';
  abrir_cerrar(0);
}

/* fin mts 30092012 */

function descargar_cupones() {
   var ale='&gg'+(Math.floor(Math.random()*50000))+'=1';

   r=ajax.load('<?php echo $base_scripts ?>ajax_descargar_cupones.php?a=1'+ale);
    var ok=/OK/;
    if (ok.test(r)) { // recarrega graella
       //alert(r);
    } else {
      //alert(r);
    }
}

function marca_event(id,tipusev,m) {
   var ale='&gg'+(Math.floor(Math.random()*50000))+'=1';
   if (m==1)
   {
	   if (confirm('Desea marcar el cliente como cup贸n ya canjeado?')) 
	   {
		r=ajax.load('<?php echo $base_scripts ?>ajax.php?marca_event='+id+'&ciudad='+ciudad_aux+'&mark='+m+'&tipus='+tipusev+ale);
		alert(r);
		var ok=/OK/;
		if (ok.test(r)) { // recarrega graella
		   //alert(r);
		} else {
		   //alert(r);
		}
		  get_graella(dia_sel);
		  id_('alta').style.display="none";
	  }
	  else return;
  }
  else
  {
	   if (confirm('Desea desmarcar el cliente como cup贸n ya canjeado?')) 
	   {
		 id_('frm_validar_password').reset();
		 id_('archivo_operacion').value= 'ajax.php'
		 id_('archivo_retorno').value = 'events.php';
		 id_('div_retorno').value= '';
		 id_('ancho_div_retorno').value = 80;
		 datos = 'marca_event='+id
		 id_('datos').value = 'marca_event='+id+'&ciudad='+ciudad_aux+'&mark='+m+'&tipus='+tipusev;
						
		 $.colorbox({width:"42%", inline:true, href:"#form_validar_password",open:true}); 
	  }
  }  
  
}

</script>

<!-- IMPRIMIR -->
<form target="_blank" id="form_g" action="<?php echo 'tabs/print.php' ?>" method="POST" >
    <input type="hidden" name="hf" id="hf">
    <input type="hidden" name="gf" id="gf">
    <input type="hidden" name="horas" id="horas">
</form>

<!-- PDF -->
<form target="_blank" id="form_pdf" action="<?php echo 'tabs/download_pdf.php' ?>" method="POST" >
    <input type="hidden" name="hf" id="hf_pdf">
    <input type="hidden" name="gf" id="gf_pdf">
    <input type="hidden" name="horas" id="horas_pdf">
</form>

<form target="iform" id="form_pdfi" action="<?php echo 'tabs/download_pdf.php' ?>" method="POST" >
    <input type="hidden" name="hfi" id="hf_pdfi">
    <input type="hidden" name="gfi" id="gf_pdfi">
    <input type="hidden" name="horasi" id="horas_pdfi">
	<iframe name="iform" style="display:none;"></iframe>    
</form>

<!-- EXCEL -->
<form target="_blank" id="form_excel" action="javascript:get_graella_instructors()" method="POST" >
    <input type="hidden" name="dia_listado" id="dia_listado" value=dia_sel>
</form>
    

<?php 
include 'disponibles.php';
?>

<script>
function envia_email_massiu(){

  var cad=''
  var g = document.getElementsByName("sel[]");
  for (i in g) {
      if (g[i].checked) {
          cad += g[i].value + ',';
      }
  }
  var msg=editor.getContent()
  r=ajax.load('<?php echo $base_scripts ?>ajax.php?mails='+cad+'&ciudad='+ciudad_aux+'&txt='+msg );
  var ok=/OK/;
  alert(r)
  if (ok.test(r)) { // recarrega graella
  }

}
function seleccionar_todos(ch){
  var cad = ''
  var g = document.getElementsByName("sel[]");
  for (i in g) {
      if (ch) 
          g[i].checked = 'checked'
      else 
          g[i].checked = ''
  }
}

function esborra_reserva(h,t){
  alert(h+' '+t);
}

//Reubica un evento a una fecha y hora seleccionadas.
function form_reubicar(id_ev,ciudad,tipo,hora)
{
 //alert(tipo);
  volver_calendario();
  id_('ciudad_origen').value=ciudad;
  id_('tipo_origen').value=tipo;
  id_('hora_origen').value=hora;
  id_('idev').value=id_ev;
  canvia_ciudad_sel(ciudad);
  canvia_tipus_sel(tipo); 
  v_mes_sel = v_mes;
  v_ano_sel = v_ano;
  id_('calendari_sel').innerHTML = crida_sel(v_mes_sel, v_ano_sel,ciudad,tipo);
  
  //if(dia_sel!='')get_graella_sel(dia_sel)
  
  //id_('calendari_sel').innerHTML=crida_sel(v_mes,v_ano)
  id_('graella_sel').innerHTML=''
  id_('header_graella_sel').style.display='none';  
  id_('msg_error').innerHTML='';
  document.getElementById('form_reubicar').reset()
  $.colorbox({width:"80%",height:"350px", inline:true, href:"#form_reubicar",open:true});
    var cbclose = $.colorbox.close;
    $.colorbox.close = function ()
    {
        get_graella(dia_sel);
        $.colorbox.close = cbclose;
        cbclose();
    }
  }



</script> 

<?php 
include 'modals.php';
?>
   </body>
 </html>
 
 
 
 
 
