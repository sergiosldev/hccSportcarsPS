<?php  
include dirname(__FILE__).'/scripts/config_events.php';

?>
 <script type="text/javascript" src="tabs/js/sha.js"></script>
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


	 <script type="text/javascript" src="tabs/js/funcs.js"></script>
     <script type="text/javascript" src="tabs/js/ajax_load.js"></script>
	 <link rel="stylesheet" type="text/css" href="tabs/css/style.css">
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
?>
	
<div>
<fieldset>
    <legend>Calendario</legend>	
<div id="calendari" style="float:left;width:50%;min-height:180px" ></div>
<div id="tipus_img" style="float:left;width:15%;min-height:180px" >tipus</div>

<div id="ciudad_info_p" style="float:left;width:33%;margin-top:10px;font-weight:bold;font-size:20px;text-transform:capitalize;">Barcelona</div>

<div id="acciones_dia" style="float:left;width:33%;margin-top:30px;font-weight:bold;font-size:20px"></div>
</fieldset>
<?php 
include dirname(__FILE__).'/scripts/formulario.php';
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
<p >
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
<div id="graella" ></div>
</div>
<script>
//var tipus_ev=document.getElementById('tipus_ev').options[ document.getElementById('tipus_ev').selectedIndex ].value;

// TIPUS PER DEFECTE
var tipus_ev='_porsche_';
var setGraella=false;
id_("r_porsche_").checked=true
id_('tipus_img').innerHTML='<img style="padding:4px;border:1px solid #000" width="100px" alt="" src="../../img/c/9.jpg">';
var ciudad_aux=""                

function click_dia(d){ // quan clickes dia a calendari
  
   get_graella(d)
   dia_sel=d;
   id_('dia').innerHTML='Dia actual: <span style="color:#f04">'+dia_sel+'</span>';
   id_('alta').style.display="none"
   var _d=dia_sel.split("-"); 
   _d=_d[2]+'-'+_d[1]+'-'+_d[0];
   id_('acciones_dia').innerHTML=''+_d+' &#160;&#160;&#160;&#160;<a style="color:#0f0;background:#0f0;border:1px solid #0f0;padding:1px" href="javascript:ac_dia(\''+dia_sel+'\',1)">&#160;&#160;</a> '+
   ' <a style="border:1px solid #33f;background:#33f;padding:1px" href="javascript:ac_dia(\''+dia_sel+'\',0)">&#160;&#160;</a>'+
   ' <a style="border:1px solid #d0629e;background:#d0629e;padding:1px" href="javascript:ac_dia(\''+dia_sel+'\',3)">&#160;&#160;</a>'+
   ' <a style="border:1px solid #f00;background:#f00;padding:1px" href="javascript:ac_dia(\''+dia_sel+'\',2)">&#160;&#160;</a>';
  
}

function ac_dia(d,a)
  {
   var ale='&gg'+(Math.floor(Math.random()*50000))+'=1'
		
  var r='ll';	
  if (a == 0) {
  	r = ajax.load('<?php echo $base_scripts ?>ajax.php?esborra_dia=' + d + '&ciudad='+ciudad_aux+'&tipus='+tipus_ev+ale);
  }
  else {
 	r = ajax.load('<?php echo $base_scripts ?>ajax.php?marca_dia=' + d + '&ciudad='+ciudad_aux+'&tipus='+tipus_ev+'&color='+a+ale);
  alert(r)
  }
  
   id_('calendari').innerHTML=crida(v_mes,v_ano)
   id_('alta').style.display='none'
   get_graella(dia_sel)
    
  }


function alta(d,h,h_aux,t)
  { 
  $(".form_").colorbox({width:"80%", inline:true, href:"#form_",open:true});
  //id_('alta').style.display="block"
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
  if (confirm('Estas seguro que deseas borrar esta inscripcion')) {
  	var ale='&gg'+(Math.floor(Math.random()*50000))+'=1'
	r = ajax.load('<?php echo $base_scripts ?>ajax.php?esborra=' + id + '&id_event=' + id_ev + '&ciudad='+ciudad_aux+'&tipus=' + tipus_ev+ale);
  	//alert(r);
	get_graella(dia_sel);
	id_('calendari').innerHTML = crida(v_mes, v_ano)
	}
  }  
function get_graella(dia)
   {
  var ale='&gg'+(Math.floor(Math.random()*50000))+'=1'
   	<?php $f=''; if($front)$f='&front=1' ?>
    var r=ajax.load('<?php echo $base_scripts ?>graella.php?data='+dia+'&ciudad='+ciudad_aux+'&tipus='+tipus_ev+'<?php echo $f; ?>'+ale);  
	id_('graella').innerHTML=r;
	setGraella=true
	id_('header_graella').style.display='block';          
   }   


function edita(id) // quan esborres pilot
  { 
  var ale='&gg'+(Math.floor(Math.random()*50000))+'=1'
  id_('msg_error').innerHTML='';
   document.getElementById('form_alta').reset()
  $(".form_").colorbox({width:"60%", inline:true, href:"#form_",open:true});
  
  //id_('alta').style.display="block"
  r=ajax.load('<?php echo $base_scripts ?>ajax.php?id_edita='+id+ale+'&ciudad='+ciudad_aux);
  eval(r);
  id_('edicio').value='true';
  }  
    
function email(id,t) // 
  { 
  if (confirm("Estas seguro que deseas enviar el email") ) {
  	r = ajax.load('<?php echo $base_scripts ?>ajax.php?email_=' + id + '&ciudad='+ciudad_aux+'&id_event=' + t);
  	alert(r);
  }
  }  

  function ocupa(h)
    {
	 var ale='&gg'+(Math.floor(Math.random()*50000))+'=1'
	 r=ajax.load('<?php echo $base_scripts ?>ajax.php?ocupa='+h+'&ciudad='+ciudad_aux+'&tipus='+tipus_ev+ale);	
	// alert(r);
	 get_graella(dia_sel)
	} 

  function ocupar_tarde(h)
    {
	if (setGraella) {
		var ale = '&gg' + (Math.floor(Math.random() * 50000)) + '=1'
		r = ajax.load('<?php echo $base_scripts ?>ajax.php?ocupat=1&ciudad='+ciudad_aux+'&tipus=' + tipus_ev + ale);
		alert(r);
		get_graella(dia_sel)
	 }
	} 

function crida(m,a){
var ale='&gg'+(Math.floor(Math.random()*50000))+'=1'

var r= ajax.load('<?php echo $base_scripts ?>calendari.php?mes='+m+'&ano='+a+'&ciudad='+ciudad_aux+'&tipus='+tipus_ev+ale);

return r;
}

id_('calendari').innerHTML=crida(v_mes,v_ano)
//get_graella(dia_sel)
//id_('dia').innerHTML='Dia actual: '+dia_sel;

function envia_formulari()
  {
  	var ale='&gg'+(Math.floor(Math.random()*50000))+'=1'
  	var dades=obtenirDadesForm('form_alta');
    r=ajax.load('<?php echo $base_scripts ?>ajax.php?'+dades+ale+'&ciudad='+ciudad_aux);
	var ok=/OK/;
    if (ok.test(r)) { // recarrega graella
	 //alert(r)
	 id_('msg_error').innerHTML='Recepción correcte';
	  get_graella(dia_sel)
	  id_('alta').style.display="none"
	 }
	else {	
	 id_('msg_error').innerHTML=r;
	 get_graella(dia_sel)
	}
	 
  }

function descarga_mails_dia(){
// alert(tipus_ev)	 
  window.location="http://lon.motorclubexperience.com/admin888/tabs/scripts/descargar_mails.php?mails_day="+dia_sel+"&ciudad="+ciudad_aux+"&tipus="+tipus_ev
  }
function descarga_mails_dia_conf(){
// alert(tipus_ev)	 
  window.location="http://lon.motorclubexperience.com/admin888/tabs/scripts/descargar_mails.php?mails_day_conf="+dia_sel+"&ciudad="+ciudad_aux+"&tipus="+tipus_ev
  }  
function descarga_mails_all(){
// alert(tipus_ev)	 
  window.location="http://lon.motorclubexperience.com/admin888/tabs/scripts/descargar_mails.php?mails_all=1"
  }  


function marca_event(id,m)
  {
   var ale='&gg'+(Math.floor(Math.random()*50000))+'=1'
		
   r=ajax.load('<?php echo $base_scripts ?>ajax.php?marca_event='+id+'&ciudad='+ciudad_aux+'&mark='+m+ale);
	var ok=/OK/;
    if (ok.test(r)) { // recarrega graella
	   //alert(r);
	}
	else {
	 	//alert(r);
	}
	  get_graella(dia_sel)
	  id_('alta').style.display="none"
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

</script> 

<?php 
include 'modals.php';
?>
   
   </body>
 </html>

 

