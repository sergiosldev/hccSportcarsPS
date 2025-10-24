<!---->
	
		<?php  
		
		include_once dirname(__FILE__).'/config_events.php'; ?>
		<?php /*
		<script type="text/javascript" src="tabs/js/sha.js"></script>
		<script type="text/javascript" src="tabs/js/funcs_fechas.js"></script>
		<script>
		//
			var pass=0; 
			var index_sha=0;
			do{
			pass = prompt("Introduce password", "")
			if(++index_sha==4)window.location='http://lon.motorclubexperience.com/admin888/'    
			}while(SHA1(pass)!='c90d2c47658527c7269e392e5667d767d36be1af')

		//
		</script>

		<script type="text/javascript" src="tabs/js/funcs_sel.js"></script>
		<script type="text/javascript" src="tabs/js/ajax_load.js"></script>
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
		
	*/	?>
	 <script type="text/javascript" src="tabs/js/funcs_sel.js"></script>
	 <script>
		

		/* VARIABLES GLOBALS */
		var v_mes_sel=<?php echo date('m'); ?>;
		var v_ano_sel=<?php echo date('Y'); ?>;
		var dia_sel_reubic='';
		var tipus_ev_sel;
		var ciudad_aux_sel;
		var ciudad_origen;
		var hora_origen;
		var tipo_origen;

		</script>

<!---->



<div id="reubicar_evento" style="display:none;float:left;width:100%;" >
    <div id='form_reubicar_evento' style='text-align:left;padding:10px; background:#fff;'>
    <fieldset>
    <legend>Reubicar evento</legend>
    <div id="msg_error"></div>   
	<input type="hidden" id="ciudad_origen" value="">
	<input type="hidden" id="tipo_origen" value="">
	<input type="hidden" id="hora_origen" value="">	
	<input type="hidden" id="idev" value="">	
	<!----->
	<FORM ACTION="javascript:;" onsubmit="envia_formulari()" METHOD="POST" id="form_reubicar" name="form_reubicar">
		
		<div id="centrar">
		
		<div id="seleccion_dia">
			<span style="color:#006699;margin-right:524px;font-weight:bold;font-size:14px;">Seleccione la fecha d&oacute;nde desea reubicar el evento</span> 
		  <fieldset>

			  <legend>Calendario</legend>    
		  <div id="calendari_sel" style="float:left;width:53%;min-height:180px" ></div>
		  <div id="tipus_img_sel" style="float:left;width:14%;min-height:180px" >tipus</div>
		  <div id="ciudad_info_p_sel" style="float:left;width:33%;margin-top:10px;font-weight:bold;font-size:20px;text-transform:capitalize;">Barcelona</div>

		  <div id="acciones_dia_reubic" style="float:left;width:33%;margin-top:30px;font-weight:bold;font-size:20px"></div>
		  <div style="float:left;width:33%;margin-top:30px;font-weight:bold;font-size:20px"><input type="button" id="boton_vehichulos" value="Cambiar Deportivo" onclick="actualizar_deportivo_sel();"></div>
		  </fieldset>
		<?php 
		include dirname(__FILE__).'/tipus_sel.php';
		?>
		  <?php 
		  //include dirname(__FILE__).'/scripts/formulario.php';
		  ?>
		</div>
	

		<div class="cabecera" id="header_graella_sel" style="display:none">
		  <div id="dia_reubic"></div>
		  <div id="headers">
			<div class="fl" style="width:140px"></div>
			<div class="fl" style="width:132px"></div> 
			<div class="fl" style="width:75px"></div>
			<div class="fl" style="width:130px"></div>
			<div class="fl" style="width:66px"></div>
		  </div>
		</div> 
		<div class="cl" ></div>
		<div id="graella_sel" ></div>
		</div>

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


		<!-- EXCEL -->
		<form target="_blank" id="form_excel" action="javascript:get_graella_instructors()" method="POST" >
			<input type="hidden" name="dia_listado" id="dia_listado" value=dia_sel_reubic>
		</form>
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

		
		function actualizar_deportivo_sel()
		{
			/*
			id_('seleccion_tipo').style.height='100px';
			id_('seleccion_tipo').style.visibility='visible';
			*/
			id_('seleccion_tipo').style.display='block';
			$.colorbox({width:'85%',height:'450px', inline:true, href:'#form_reubicar',open:true});		
		}
		
		function click_dia_sel(d) { // quan clickes dia a calendari
		   id_('seleccion_tipo').style.display='none';
		   id_('seleccion_dia').style.display='none';
		   id_('dia').style.display='block';
		   id_('graella_sel').style.display='block';
		   $.colorbox({width:"80%",height:"900px", inline:true, href:"#form_reubicar",open:true});
		   
		   get_graella_sel(d);
		   dia_sel_reubic=d;
		   id_('dia_reubic').style.display='block';
		   id_('dia_reubic').innerHTML='Dia actual: <span style="color:#f04;width:100px;text-align:left !important;">'+dia_sel_reubic+'</span><button onclick="volver_calendario();" class="btn_volver_calendario">Volver al Calendario</button>';
		   //id_('alta_reubic').style.display="none"
		   var _d=dia_sel_reubic.split("-"); 
		   _d=_d[2]+'-'+_d[1]+'-'+_d[0];
		   id_('acciones_dia_reubic').innerHTML=''+_d+' &#160;&#160;&#160;&#160;';
		}
		
		function volver_calendario()
		{
		   id_('seleccion_tipo').style.display='none';
		   id_('seleccion_dia').style.display='block';
		   id_('dia_reubic').style.display='none';
		   id_('graella_sel').style.display='none'; 
		   $.colorbox({width:"80%",height:"350px", inline:true, href:"#form_reubicar",open:true});		   
		}

		function ac_dia(d,a) {
		  var ale='&gg'+(Math.floor(Math.random()*50000))+'=1'
		  var r='ll';    
		  /*if (a == 0) {
			r = ajax.load('<?php echo $base_scripts ?>ajax_sel.php?esborra_dia=' + d + '&ciudad='+ciudad_aux+'&tipus='+tipus_ev+ale);
		  } else {
			r = ajax.load('<?php echo $base_scripts ?>ajax_sel.php?marca_dia=' + d + '&ciudad='+ciudad_aux+'&tipus='+tipus_ev+'&color='+a+ale);
			alert(r)
		  }*/
		  id_('calendari_sel').innerHTML=crida_sel(v_mes_sel,v_ano_sel,id_('ciudad_origen').value,id_('tipo_origen').value);
		  


		  //id_('alta_reubic').style.display='none'
		  get_graella_sel(dia_sel_reubic)

		}




		function get_graella_sel(dia) {
		  var ale='&gg'+(Math.floor(Math.random()*50000))+'=1'
		  <?php $f=''; if($front)$f='&front=1' ?>
		  var r=ajax.load('<?php echo $base_scripts ?>graella_sel.php?data='+dia+'&ciudad='+ciudad_aux_sel+'&tipus='+tipus_ev_sel+'<?php echo $f; ?>'+'&idev='+id_('idev').value+ale);  
		  id_('graella_sel').innerHTML=r;
		  setGraella=true
		  id_('header_graella_sel').style.display='block';          
		}


		function get_graella_instructors() {
		  var dia = dia_sel;
		  var ale='&gg'+(Math.floor(Math.random()*50000))+'=1'
		  <?php $f=''; if($front)$f='&front=1' ?>
		  //var r=ajax.load('<?php echo $base_scripts ?>graella_instructors.php?data='+dia+'&ciudad='+ciudad_aux+'&tipus='+tipus_ev+'<?php echo $f; ?>'+ale);  
		  //var r=ajax.load('<?php echo $base_scripts ?>test.php?data='+dia+'&ciudad='+ciudad_aux+'&tipus='+tipus_ev+'<?php echo $f; ?>'+ale);  
		  document.getElementById('form_excel').action= '<?php echo $base_scripts ?>graella_instructors.php?data='+dia+'&ciudad='+ciudad_aux+'&tipus='+tipus_ev+'<?php echo $f; ?>'+ale;
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
		 //alert(r); 
		 
		 
		 
		 document.getElementById('gf_pdf').value=r;
		 document.getElementById('horas').value=_h_;
		 //alert(document.getElementById('gf').value); 
			
		  //document.getElementById('form_pdf').action= '<?php echo $base_scripts ?>graella_organizadores.php?data='+dia+'&ciudad='+ciudad_aux+'&tipus='+tipus_ev+'<?php echo $f; ?>'+ale;
		  document.getElementById('form_pdf').action= '<?php echo $base_scripts ?>generar_pdf_organizadores.php';
		  document.getElementById('form_pdf').submit();
		}


		/*
		function edita(id) // quan esborres pilot
		{
		  var ale='&gg'+(Math.floor(Math.random()*50000))+'=1'
		  id_('msg_error').innerHTML='';
		  document.getElementById('form_alta').reset()
		  $(".form_").colorbox({width:"60%", inline:true, href:"#form_",open:true});
		  //id_('alta').style.display="block"
		  r=ajax.load('<?php echo $base_scripts ?>ajax_2.php?id_edita='+id+ale+'&ciudad='+ciudad_aux);
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
		  r=ajax.load('<?php echo $base_scripts ?>ajax_2.php?id_edita='+id+ale+'&ciudad='+ciudad_aux);
		  eval(r);
		  id_('edicio').value='true';
		}



		function reubicar(ciudad_origen,tipo_origen,hora_origen,ciudad,tipo,hora,idev)     
		{
		  //alert(ciudad_origen+'-'+hora_origen+'->'+ciudad+'-'+hora);   
		  var ale='&gg'+(Math.floor(Math.random()*50000))+'=1';  
		  var fecha_origen = hora_origen.substring(8,10)+'/'+hora_origen.substring(5,7)+'/'+hora_origen.substring(0,4);
		  var fecha = hora.substring(8,10)+'/'+hora.substring(5,7)+'/'+hora.substring(0,4);
		  var hora_orig = hora_origen.substring(11,16);
		  var hora_ = hora.substring(11,16);
		  
		  //id_('alta').style.display="block"
		  if (confirm('El evento '+tipo_origen.toUpperCase()+' de '+((ciudad_origen=='')?'Barcelona':ciudad_origen)+' va a ser reubicado del dia "'+fecha_origen+' a las '+hora_orig+'h." al evento '+tipo.toUpperCase()+' del dia "'+fecha+' a las '+hora_+'h."\n\n Esta seguro de que desea continuar?'))
		  {
			r=ajax.load('<?php echo $base_scripts ?>ajax_sel.php?id_reubica=1'+ale+'&tipo_origen='+tipo_origen+'&ciudad_origen='+ciudad_origen+'&hora_origen='+hora_origen+'&tipo='+tipo+'&ciudad='+ciudad+'&hora='+hora+'&idev='+idev);  
			alert(r);
			ru=r.toUpperCase();
			if (ru.indexOf('ERROR')==-1)
			{
				email(idev,hora);

				click_dia_sel(hora.substring(0,10));
				$.colorbox.close();
			}
				
		  }
		  //eval(r);
		  //id_('edicio').value='true';
		}


		function email(id,t) {
		  if (confirm("Estas seguro que deseas enviar el email") ) {
			  r = ajax.load('<?php echo $base_scripts ?>ajax_2.php?email_=' + id + '&ciudad='+ciudad_aux+'&id_event=' + t);
			  alert(r);
		  }
		}

		function ocupa(h) {
		   var ale='&gg'+(Math.floor(Math.random()*50000))+'=1'
		   r=ajax.load('<?php echo $base_scripts ?>ajax_2.php?ocupa='+h+'&ciudad='+ciudad_aux+'&tipus='+tipus_ev+ale);    
		  // alert(r);
		   get_graella_sel(dia_sel)
		}

		function ocupar_horas(h){
		  if (setGraella) {
			  var  ale = '&gg' + (Math.floor(Math.random() * 50000)) + '=1'
			  r = ajax.load('<?php echo $base_scripts ?>ajax_2.php?ocupat=1&periodo='+h+'&ciudad='+ciudad_aux+'&tipus=' + tipus_ev + ale);
			  alert(r);
			  get_graella_sel(dia_sel)
		   }
		}

		function crida_sel(m,a,ciudad,tipo) {
		//alert(tipo);
		
		  var ale='&gg'+(Math.floor(Math.random()*50000))+'=1';
		  //var r= ajax.load('<?php echo $base_scripts ?>calendari_sel.php?mes='+m+'&ano='+a+'&ciudad='+ciudad_aux_sel+'&tipus='+tipus_ev_sel+ale);
		  var r= ajax.load('<?php echo $base_scripts ?>calendari_sel.php?mes='+m+'&ano='+a+'&ciudad='+ciudad+'&tipus='+tipo+ale);
		  return r;
		}

	    tipus_ev_sel = tipus_ev;
		ciudad_aux_sel = ciudad_aux;		
		ciudad_origen = id_('ciudad_origen').value;
		hora_origen = id_('hora_origen').value;
		//alert(id_('tipo_origen').value+' '+ciudad_origen);
		id_('calendari_sel').innerHTML=crida_sel(v_mes_sel,v_ano_sel,ciudad_origen,id_('tipo_origen').value);
		

		//get_graella(dia_sel)
		//id_('dia').innerHTML='Dia actual: '+dia_sel;




		</script>

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
		  r=ajax.load('<?php echo $base_scripts ?>ajax_2.php?mails='+cad+'&ciudad='+ciudad_aux+'&txt='+msg );
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
		include_once (dirname(__FILE__).'/../disponibles.php');
		?>


		<?php 
		include_once (dirname(__FILE__).'/../modals.php');
		?>
		   </body>
		 </html>
		 
		 
		 
		 
		 </form>

	
	<!----->
    </fieldset>
    </div>
</div>

