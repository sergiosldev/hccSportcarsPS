<?php  
	include_once dirname(__FILE__).'/config_events_new.php'; 
?>
	<script type="text/javascript" src="tabs/js/funcs_sel_susp.js"></script>
	<script>
		/* VARIABLES GLOBALS */
		var v_mes_sel_susp=<?php echo date('m'); ?>;
		var v_ano_sel_susp=<?php echo date('Y'); ?>;
		var dia_sel_susp='';
		var tipus_ev_sel_susp;
		var ciudad_aux_sel_susp;
		var ciudad_origen_susp;
		var hora_origen_susp;
		var tipo_origen_susp;
		var dias_seleccionados='';
	</script>

<div id="suspender_eventos" style="display:none;float:left;width:100%;" >
    <div id='form_suspender_eventos' style='text-align:left;padding:10px; background:#fff;'>
    <fieldset>
    <legend>Suspender eventos</legend>
    <div id="msg_error"></div>   
	<input type="hidden" id="ciudad_origen_susp" value="">
	<input type="hidden" id="tipo_origen_susp" value="">
	<input type="hidden" id="hora_origen_susp" value="">	
	<input type="hidden" id="idev_susp" value="">	

	<!----->
	<FORM ACTION="javascript:;" onsubmit="envia_formulari()" METHOD="POST" id="form_suspender_eventos" name="form_suspender_eventos">                                                                                             
		<div id="centrar">
		<div id="seleccion_dia">
			<span style="color:#006699;margin-right:524px;font-weight:bold;font-size:14px;">Seleccione las fechas para las que desea suspender eventos</span> 
		  <fieldset>
			  <legend>Calendario</legend>    
		  <div id="calendari_sel_susp" style="float:left;width:53%;min-height:180px" ></div>
		  <div id="tipus_img_sel_susp" style="float:left;width:14%;min-height:180px" >tipus</div>
		  <div id="ciudad_info_p_sel_susp" style="float:left;width:33%;margin-top:10px;font-weight:bold;font-size:20px;text-transform:capitalize;">Barcelona</div>

		  <div id="acciones_dia_susp" style="float:left;width:33%;margin-top:30px;font-weight:bold;font-size:20px"></div>                                                                 
		  </fieldset>   
		<?php 
		    include dirname(__FILE__).'/tipus_sel_suspender.php';

		?>
		</div>
	

		<div class="cabecera" id="header_graella_sel_susp" style="display:none">
		  <div id="dia_susp"></div>
		  <div id="headers">
			<div class="fl" style="width:140px"></div>
			<div class="fl" style="width:132px"></div> 
			<div class="fl" style="width:75px"></div>
			<div class="fl" style="width:130px"></div>
			<div class="fl" style="width:66px"></div>
		  </div>
		</div> 
		<div class="cl" ></div>
		<div id="graella_sel_susp" ></div>
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
		
		function actualizar_deportivo_sel_susp()     
		{
			id_('seleccion_tipo_susp').style.display='block';
			$.colorbox({width:'85%',height:'450px', inline:true, href:'#form_suspender_eventos',open:true});		
		}
		
		function click_dia_sel_susp(id_dia,d) 
		{
		   var adias_sel = new Array();
		   var itemtoRemove;
		   if ($('#'+id_dia).attr('class')!='calendario no_marcat')
		   {			   
			    if (dias_seleccionados=='') dias_seleccionados=d;   	
				else dias_seleccionados = dias_seleccionados+','+d;
				adias_sel = dias_seleccionados.split(',');
		   		$('#'+id_dia).removeClass($('#'+id_dia).attr('class')).addClass('calendario no_marcat');
		   }
		   else
		   { 	
			    adias_sel = dias_seleccionados.split(',');
			    itemtoRemove = d; 
			   	$('#'+id_dia).removeClass($('#'+id_dia).attr('class')).addClass('calendario marcat_blau');
			   	adias_sel.splice($.inArray(itemtoRemove, adias_sel),1);
			   	dias_seleccionados = adias_sel.join(',');
			}
		   id_('dia').style.display='block';           
		   id_('graella_sel_susp').style.display='block';      
		   $.colorbox({width:"80%",height:"900px", inline:true, href:"#form_suspender_eventos",open:true});                    
		   
		   //get_graella_sel_susp(d);
		   dia_sel_susp=d;
		   id_('dia_susp').style.display='block';
		   id_('dia_susp').innerHTML='Dia actual: <span style="color:#f04;width:100px;text-align:left !important;">'+dia_sel_susp+'</span><button onclick="volver_calendario_susp();" class="btn_volver_calendario">Volver al Calendario</button>';    
		   //id_('alta_reubic').style.display="none"
		   var _d=dia_sel_susp.split("-"); 
		   _d=_d[2]+'-'+_d[1]+'-'+_d[0];
		   id_('acciones_dia_susp').innerHTML=''+_d+' &#160;&#160;&#160;&#160;';  
		}
	
		function volver_calendario_susp()
		{
		   //id_('seleccion_tipo_susp').style.display='none';
		   id_('seleccion_dia').style.display='block';
		   id_('dia_susp').style.display='none';
		   id_('graella_sel_susp').style.display='none';
			  		    
		   $.colorbox({width:"80%",height:"600px", inline:true, href:"#form_suspender_eventos",open:true});             		   
		}
		
		function ac_dia(d,a) {
		  var ale='&gg'+(Math.floor(Math.random()*50000))+'=1'
		  var r='ll';    

		  id_('calendari_sel_susp').innerHTML=crida_sel(v_mes_sel,v_ano_sel,id_('ciudad_origen_susp').value,id_('tipo_origen_susp').value);   
		  

		  get_graella_sel_susp(dia_sel_susp);

		}




		function get_graella_sel_susp(dia) {
		  var ale='&gg'+(Math.floor(Math.random()*50000))+'=1'
		  <?php $f=''; if($front)$f='&front=1' ?>;
		  var r=ajax.load('<?php echo $base_scripts ?>graella_sel_susp.php?data='+dia+'&ciudad='+ciudad_aux_sel_susp+'&tipus='+tipus_ev_sel+'<?php echo $f; ?>'+'&idev='+id_('idev').value+ale);               
		  id_('graella_sel').innerHTML=r;
		  setGraella=true
		  id_('header_graella_sel').style.display='block';          
		}


		function get_graella_instructors() {
		  var dia = dia_sel;
		  var ale='&gg'+(Math.floor(Math.random()*50000))+'=1';
		  <?php $f=''; if($front)$f='&front=1' ?>
		  document.getElementById('form_excel').action= '<?php echo $base_scripts ?>graella_instructors.php?data='+dia+'&ciudad='+ciudad_aux+'&tipus='+tipus_ev+'<?php echo $f; ?>'+ale;
		  document.getElementById('form_excel').submit();
		}

		function get_graella_organizadores(_h_) {

		  var dia = dia_sel;
		  var ale='&gg'+(Math.floor(Math.random()*50000))+'=1'
		  <?php $f=''; if($front)$f='&front=1' ?>
		  var r=ajax.load('<?php echo $base_scripts ?>graella_organizadores.php?horas='+_h_+'&data='+dia+'&ciudad='+ciudad_aux+'&tipus='+tipus_ev+'<?php echo $f; ?>'+ale);  
		 
		 
		 
		 document.getElementById('gf_pdf').value=r;
		 document.getElementById('horas').value=_h_;
		 //alert(document.getElementById('gf').value); 
			
		  //document.getElementById('form_pdf').action= '<?php echo $base_scripts ?>graella_organizadores.php?data='+dia+'&ciudad='+ciudad_aux+'&tipus='+tipus_ev+'<?php echo $f; ?>'+ale;
		  document.getElementById('form_pdf').action= '<?php echo $base_scripts ?>generar_pdf_organizadores.php';
		  document.getElementById('form_pdf').submit();
		}



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
 
 
		function suspender(ciudad_origen,tipo_origen,hora_origen,ciudad,tipo,hora,idev)     
		{
		  var ale='&gg'+(Math.floor(Math.random()*50000))+'=1';  
		  var fecha_origen = hora_origen.substring(8,10)+'/'+hora_origen.substring(5,7)+'/'+hora_origen.substring(0,4);
		  var fecha = hora.substring(8,10)+'/'+hora.substring(5,7)+'/'+hora.substring(0,4);
		  var hora_orig = hora_origen.substring(11,16);
		  var hora_ = hora.substring(11,16);
		  
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

		function crida_sel_susp (m,a,ciudad,tipo) 
		{
		  var ale='&gg'+(Math.floor(Math.random()*50000))+'=1';
		  var r= ajax.load('<?php echo $base_scripts ?>calendari_sel_susp.php?mes='+m+'&ano='+a+'&ciudad='+ciudad+'&tipus='+tipo+ale);
		  return r;
		}

		
	    tipus_ev_sel_susp = tipus_ev;
		ciudad_aux_sel_susp = ciudad_aux;		
		ciudad_origen_susp = id_('ciudad_origen_susp').value;
		hora_origen_susp = id_('hora_origen_susp').value;
		id_('calendari_sel_susp').innerHTML=crida_sel_susp(v_mes_sel_susp,v_ano_sel_susp,ciudad_origen_susp,id_('tipo_origen').value);    

		</script>


		<?php 			  

//		include_once (dirname(__FILE__).'/../disponibles.php');
		?>


		<?php 
		include_once (dirname(__FILE__).'/../modals.php');
		?>
		   </body>
		 </html>
		 
		 
		 
		 
		 </form>
    </fieldset>
    </div>
</div>

