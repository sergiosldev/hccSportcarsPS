<script>  




//function envia_formulari_oferta(idoferta,num_opciones,nlineas_destacados,nlineas_condiciones,nlineas_descripcioncupones)
function envia_formulari_oferta(idoferta,num_opciones,boton)
  {
    var ale='&gg'+(Math.floor(Math.random()*50000))+'=1';
    var div_error = (boton==1)?'msg_errorh':'msg_error';
    var nombre_opcion = '_opcion';
    
	
	
	if (idoferta!='')  
    {
        id_('idoferta').value = idoferta;
        id_('idoferta_im').value = idoferta;
    
    }      
        
    var dades ='';
    //Actualizamos los textareas con los valores que hayamos modificado sobre los editores TinyMCE.
    $('#destacados').val(tinyMCE.get("destacados").getContent());
    $('#condiciones').val(tinyMCE.get("condiciones").getContent());
    $('#descripcion').val(tinyMCE.get("descripcion").getContent());
    $('#descripcion_cupones').val(tinyMCE.get("descripcion_cupones").getContent());


    for (var iopc=2;iopc<=num_opciones;iopc++)
    {
        //Actualizamos los textareas con los valores que hayamos modificado sobre los editores TinyMCE.
        $('#destacados'+nombre_opcion+iopc).val(tinyMCE.get("destacados"+nombre_opcion+iopc).getContent());
        $('#condiciones'+nombre_opcion+iopc).val(tinyMCE.get("condiciones"+nombre_opcion+iopc).getContent());
        $('#descripcion'+nombre_opcion+iopc).val(tinyMCE.get("descripcion"+nombre_opcion+iopc).getContent());
    }
    dades=obtenirDadesForm('form_alta_oferta');

	dades+='&num_opciones='+num_opciones;
    //Validamos los campos del formulario y si todo va bien guardamos su contenido en B.D.
    id_('msg_error').innerHTML='';
    id_('msg_errorh').innerHTML='';
    var multiple_cantidad;


    if (id_('multiple_dos').checked==true) multiple_cantidad = 2;
    else multiple_cantidad = 1;
	
    dades+='&multiple_cantidad='+multiple_cantidad;
    r=ajax_post.load('<?php echo $base_scripts ?>ajax_ofertas_bd.php',dades+ale); 

    if (r.indexOf('Error')==-1) 
    {
        eval(r);
        id_('idoferta_im').value=id_('idoferta').value;
        id_('boton_vista_previa').style.visibility='visible';
        id_('boton_vista_oferta').style.visibility='visible';
    }
    else     
    {
        id_(div_error).innerHTML=r;
        return -1;
    }
    

    //Al finalizar el alta limpiaremos el formulario.
   if (id_('idoferta').value!='' && id_('edicio_oferta').value!='edicio') {id_('nueva_oferta').style.visibility='visible';}
   else {id_('nueva_oferta').style.visibility='hidden';}
   return 1;
  }

  function envia_formulario_clientes(nregistros_pagina)
  {
    if (id_('cliente_oferta').value=='') {alert('Debe introducir alg�n criterio de b�squeda para la oferta');return;}
       
    
    var aleatorio='&gg'+(Math.floor(Math.random()*50000))+'=1'
    if (id_('cliente_oferta').value==undefined) dades='filtro=';
	else dades = 'filtro='+id_('cliente_oferta').value; 
    dades += '&direccion=0&orden=0&registro_inicio=1&nregistros_pagina='+nregistros_pagina; 
    r=ajax.load('<?php echo $base_scripts ?>clientes.php?'+dades+aleatorio);  
    id_('lista_clientes').style.display='block';
    id_('lista_clientes').innerHTML = r;  
	ocultar_form_busqueda_cliente();
 }

  
  function nueva_oferta(load_ini)
  {    
    var ale='&gg'+(Math.floor(Math.random()*50000))+'=1';

    id_('lista_opciones').innerHTML=crear_formulario_oferta();
    id_('form_alta_oferta').reset();
    id_('form_alta_imagen').reset();
    id_('idoferta').value='';
    id_('oferta_activa').value='';
    id_('edicio_oferta').value='alta';
    id_('titulo_formulario_oferta').innerHTML='Alta';
    id_('boton_vista_previa').style.visibility='hidden';    
    id_('boton_vista_oferta').style.visibility='hidden';    
    r=ajax.load('<?php echo $base_scripts ?>formulario_imagenes_oferta.php?imagen=&idoferta='+ale); 
    id_('step2').innerHTML=r;
    id_('titulo_formulario_imagen').innerHTML='Nueva Imagen';
    //tinyMCEInit('textarea.rte'); 
	if (!(load_ini==true))
		tinyMCEInit('textarea.rte');
    
    reset_imagen();
  }

  function edita_oferta(id,tipo,operacion_opcion,id_opcion) 
  { 

  var ale='&gg'+(Math.floor(Math.random()*50000))+'=1';

  oferta = '&id_oferta='+id;
  var op = '&operacion_opcion='+operacion_opcion;
  if (id_opcion==undefined) 
	id_opcion = 0;
  
  var idopcionp = '&id_opcion='+id_opcion;


	
	//la operacion 4 corresponde a guardar la oferta. En este caso cargaremos la lista de opciones despu�s de comprobar si no se ha producido error al salvar.
	//if (operacion_opcion!=4)
	//{
		r=ajax_post.load('<?php echo $base_scripts ?>opciones_oferta.php','tab=1'+op+idopcionp+oferta+ale);
	//}	
    
	if (operacion_opcion==2) //hemos eliminado una opci�n por lo tanto reeditamos las oferta.
	  {
	  edita_oferta(id,'',3);
	  return;
	  }

 
   /*if (operacion_opcion!=4)
   {*/
 		id_('lista_opciones').innerHTML=r; 
	    id_('msg_error').innerHTML='';
	    id_('form_alta_oferta').reset();
	    id_('alta_oferta').style.display='block';
	    		
   //}
  
  id_('edicio_oferta').value='consulta';  
  //inicializamos los par�metros del editor tinyMCE
  tinyMCEInit('textarea.rte');
 
   
  //tipo = (ofertas_online o cupones_alfa_online)
  r=ajax_post.load('<?php echo $base_scripts ?>ajax_ofertas_bd.php','idoferta='+ id +'&edicio_oferta='+id_('edicio_oferta').value +'&tipo='+tipo+ ale);

  //alert(r);
  eval(r);
  var error;
  if (r.indexOf('Error: Debe introducir')!=-1)
	error = true;
  else error = false;
  /*if ((operacion_opcion==4) && !error) 
   {
     //actualizamos las opciones a�adidas para la oferta.	
      r=ajax_post.load('<?php echo $base_scripts ?>opciones_oferta.php','tab=1'+op+idopcionp+oferta+ale);
	  id_('lista_opciones').innerHTML=r; 
	  id_('msg_error').innerHTML='';
	  id_('form_alta_oferta').reset();
	  id_('alta_oferta').style.display='block';
	  id_('edicio_oferta').value='consulta';  
	 }
  */
  //alert(tinyMCE.get("destacados").getContent());


  id_('edicio_oferta').value='edicio';
  id_('idoferta').value=id;
  id_('idoferta_im').value=id;

  ocultar_form_activar_oferta();

  id_('boton_vista_previa').style.visibility='visible';  
  id_('boton_vista_oferta').style.visibility='visible';  
  id_('titulo_formulario_oferta').innerHTML='Editar';
  

  //actualizamos formulario imagenes.
 
   
  r=ajax.load('<?php echo $base_scripts ?>formulario_imagenes_oferta.php?imagen='+oferta+'&tipo='+tipo+ale); 
  id_('step2').innerHTML=r;
  id_('titulo_formulario_imagen').innerHTML='Nueva Imagen';

  reset_imagen();

  }
  
  function nueva_opcion_oferta(idoferta)
  {
	  var ale='&gg'+(Math.floor(Math.random()*50000))+'=1';
	  var nombre_opcion = 'opcion';
	  var opc_nueva;
	  var num_opciones;
	  oferta = '&id_oferta='+idoferta;
	  nop =  '&operacion_opcion=1';
	  idopcion = '&id_opcion=0';
	  //actualizamos las opciones a�adidas para la oferta.	
	  r=ajax_post.load('<?php echo $base_scripts ?>opciones_oferta.php','tab=1'+nop+idopcion+oferta+ale);


	  id_('tab_opciones').innerHTML=id_('tab_opciones').innerHTML+r;
	   
	  opc_nueva=ajax_post.load('<?php echo $base_scripts ?>opciones_oferta.php','tab=0'+nop+idopcion+oferta+ale);

//	  opc_nueva = opc_nueva.split('##');
//	  alert(opc_nueva[1]);
//	  opc_nueva = opc_nueva[0];
//	  num_opciones = opc_nueva[1];
	  id_('lista_opciones').innerHTML = id_('lista_opciones').innerHTML+opc_nueva;
	//  id_('nopciones').value = num_opciones;


	  var num_opciones = 0;
	  if (id_('nopciones').value!=null) num_opciones =id_('nopciones').value;
	  
	  //Actualizamos los par�metros de "CambiarTab" con el nuevo n�mero de opciones.	
	  var nombre_tab; 
	  for(var i=1;i<=num_opciones;i++)
		{
		 if (i==1) nombre_tab = 'Datos de la Oferta';
		 else nombre_tab='Opci&oacute;n '+(i-1);	
		 id_('tabopcion'+i).innerHTML='<a class="cabecera" href="#" onclick="CambiarTab(\''+nombre_opcion+'\','+i+','+(parseInt(num_opciones)+1)+');">'+nombre_tab+'</a>';
		}
	  
	  id_('msg_error').innerHTML='';

	  //inicializamos los par�metros del editor tinyMCE
	  tinyMCEInit('textarea.rte');
	   
	  //tipo = (ofertas_online o cupones_alfa_online)
	  r=ajax.load('<?php echo $base_scripts ?>ajax_ofertas_bd.php?idoferta='+ idoferta +'&edicio_oferta=consulta'+ ale);  
	

	  eval(r);

	   
  }

  function edita_opciones_oferta(id,operacion_opcion,id_opcion) 
  { 

  var ale='&gg'+(Math.floor(Math.random()*50000))+'=1';
  
  oferta = '&id_oferta='+id;

  nop =  '&operacion_opcion='+operacion_opcion;
  idopcion = '&id_opcion='+id_opcion;
  
  //creamos el formulario de la oferta
  //var rof=crear_formulario_oferta();
  var rt;
  var ropc;
//alert(rof);
  //actualizamos las opciones a�adidas para la oferta.	
  rt=ajax.load('<?php echo $base_scripts ?>opciones_oferta.php?tab=1'+nop+idopcion+oferta+ale);
  id_('tab_opciones').innerHTML=rt; 
  ropc=ajax.load('<?php echo $base_scripts ?>opciones_oferta.php?tab=0'+nop+idopcion+oferta+ale);
  id_('lista_opciones').innerHTML=rof+ropc; 

  id_('msg_error').innerHTML='';
  
  //inicializamos los par�metros del editor tinyMCE
  tinyMCEInit('textarea.rte');
  
   
  //tipo = (ofertas_online o cupones_alfa_online)
  r=ajax.load('<?php echo $base_scripts ?>ajax_ofertas_bd.php?idoferta='+ id +'&edicio_oferta=consulta_opciones'+ ale);  

//alert(r);
  eval(r);
  
  id_('edicio_oferta').value='edicio';  
  id_('idoferta').value=id;
  id_('idoferta_im').value=id;
  ocultar_form_activar_oferta();
  id_('boton_vista_previa').style.visibility='visible';  
  id_('boton_vista_oferta').style.visibility='visible';  
  id_('titulo_formulario_oferta').innerHTML='Editar';

  //actualizamos formulario imagenes.
  
   
  r=ajax.load('<?php echo $base_scripts ?>formulario_imagenes_oferta.php?imagen='+oferta+'&tipo='+tipo+ale); 
  id_('step2').innerHTML=r;
  id_('titulo_formulario_imagen').innerHTML='Nueva Imagen';




  reset_imagen();

  }


  function crear_formulario_oferta()
  {
	  var nombre_opcion = 'opcion';
	  var ale='&gg'+(Math.floor(Math.random()*50000))+'=1';

	  //Bloque que corresponde a la oferta.
	  r=ajax.load('<?php echo $base_scripts ?>crear_formulario_oferta.php?nombre_opcion='+nombre_opcion+ale);
	  return r; 

  } 
  


  function reset_imagen()
  {
   id_('titulo_im').value='';
   id_('imagen_oferta').value='';
   id_('id_imagen').value='';
   id_('portada').value=0;
   id_('posicion').value='';
   id_('edicion_imagen').value='alta';

  }  
  

  function alta_oferta()
  { 
  id_('form_alta_oferta').reset()
  id_('edicio_oferta').value = 'alta';
  id_('titulo_formulario_oferta').innerHTML = 'Alta';
  }  
  

  function esborra_oferta(id) // quan esborres oferta
  { 
  if (confirm('Está seguro que desea borrar esta oferta?')) {
    var ale='&gg'+(Math.floor(Math.random()*50000))+'=1'         
    r = ajax.load('<?php echo $base_scripts ?>ajax_ofertas_bd.php?esborra_ofe=' + id +ale);
    get_lista_ofertas();
    }
  } 
  
  
//funcion invocada para eliminar un registro de ofertas.
 function borrar_oferta(id_oferta,creadas,cupones,especial) 
 { 
  /*if (especial==1) //especial sólo será 1 en el caso de una campaña, para validar que sólo se puedan eliminar aquellas con oferta no especial.
  {
      alert('Las campañas especiales sólo se pueden eliminar marcando la oferta como "no especial"')
      return;
  }*/
 
  //id_oferta hará referencia al id histórico en caso de que estemos visualizando las campañas.  
  id_('creadas_fbo').value=creadas;
  id_('id_oferta_fbo').value = id_oferta;
  id_('tipo_password_fbo').value='';
  
  var texto = '';
  var texto2 = '';  

  var ale='&gg'+(Math.floor(Math.random()*50000))+'=1';         
  
  if (creadas==0)
   {
    r = ajax.load('<?php echo $base_scripts ?>ajax_ofertas_bd.php?buscar_cupones_oferta=1&creadas=0&id_oferta=' + id_oferta +ale);
    cupones = r;
    if (cupones>0)
      texto = '!!!ATENCIÓN!!! ESTA CAMPAÑA TIENE CUPONES ASOCIADOS.\n\n                 ¿Está seguro de que desea borrarla?';
    else texto = '¿Está seguro de que desea borrar esta campaña?';
   }
  else
   {
    r = ajax.load('<?php echo $base_scripts ?>ajax_ofertas_bd.php?buscar_cupones_oferta=1&creadas=1&id_oferta=' + id_oferta +ale);
    cupones = r;
    r = ajax.load('<?php echo $base_scripts ?>ajax_ofertas_bd.php?buscar_campanyas_activas=1&id_oferta=' + id_oferta +ale);
    activas = r;
    texto_cupones='!!!ATENCIÓN!!! existen CAMPAÑAS ACTIVAS con CUPONES ASOCIADOS.\n';
    texto_activas='!!!ATENCIÓN!!! ESTA OFERTA TIENE CAMPAÑAS ACTIVAS ASOCIADAS.\n';
    texto_cliente_especial = '!!!ATENCIÓN!!! Al borrar esta OFERTA la CAMPAÑA asociada se marcará como INACTIVA.\n';
    texto_modif = 'Tenga en cuenta que al eliminar la oferta, los textos e imagenes de\n las CAMPAÑAS ACTIVAS no se podrán modificar.\n\n                           ';
    
    if (especial==1)
    {
       texto+=texto_cliente_especial;
    }
    else
    {
    if (parseInt(cupones)>0) texto+=texto_cupones + texto_modif;
    else if (parseInt(activas)>0) texto+=texto_activas + texto_modif;
    }
    //texto+= '¿Está seguro de que desea borrarla?';
    if (texto=='')
        texto2 = '¿Está seguro de que desea borrar esta oferta?';
    else texto2 = '¿Está seguro de que desea borrarla?';    
   }
  if (parseInt(cupones)>0) {id_('tipo_password_fbo').value='facturados';}
  texto = texto+((texto!='')?'\n                     ':'')+texto2;
  if (confirm(texto)) 
    {
    id_('frm_borrar_oferta').reset();
    $.colorbox({width:"42%", inline:true, href:"#form_borrar_oferta",open:true});   
    }

 } 
 
 
function marca_cliente_especial(id_oferta,creadas,marcado)
{
  id_('creadas_fmce').value=creadas;
  id_('id_oferta_fmce').value = id_oferta;
  var prefijo = '';
  var sufijo='';
  if (marcado=='1') {prefijo = 'des';sufijo=' La oferta y la campaña serán desactivadas.';}
    if (confirm('Esta seguro de que desea '+prefijo+'marcar esta oferta como "cliente especial"?'+sufijo)) 
    //if (confirm('Esta seguro de que desea marcar esta oferta como "cliente especial"?')) 
    {  
        id_('frm_marcar_cliente_especial').reset();
        $.colorbox({width:"42%", inline:true, href:"#form_marcar_cliente_especial",open:true});   
    }
}    

  
 function duplicar_oferta(id_oferta)
 {
    
   var aleatorio='&gg'+(Math.floor(Math.random()*50000))+'=1'; 
    
   dades='id_oferta='+id_oferta;
   dades+='&duplicar=1';   
   dades+='&creadas=1';
   if (!confirm('Está seguro de que duplicar esta oferta?')) 
   {
       return;
   }
   else 
   {
       id_('frm_validar_password').reset();
       id_('archivo_operacion').value= 'ajax_ofertas_bd.php'
       id_('archivo_retorno').value = 'ofertas.php';
       id_('div_retorno').value= 'lista_ofertas';
       id_('ancho_div_retorno').value = 80;
       id_('datos').value = dades;
                        
       $.colorbox({width:"42%", inline:true, href:"#form_validar_password",open:true}); 
       return;          
   }

     
 }
  
 function copiar_oferas_a_cupones_online(id_oferta)
 {
    
   var aleatorio='&gg'+(Math.floor(Math.random()*50000))+'=1'; 
    
   dades='id_oferta='+id_oferta;
   dades+='&duplicar=2';   
   dades+='&creadas=1';
   dades+='&tipo_password=';
   if (!confirm('Está seguro de que desea copiar esta oferta en Cupones Alfa Online?')) 
   {
       return;
   }
   else 
   { 
       id_('frm_validar_password').reset();
       id_('archivo_operacion').value= 'ajax_ofertas_bd.php'
       id_('archivo_retorno').value = 'ofertas.php';
       id_('div_retorno').value= 'lista_ofertas';
       id_('ancho_div_retorno').value = 80;
       id_('datos').value = dades;
                        
       $.colorbox({width:"42%", inline:true, href:"#form_validar_password",open:true});     
       return;          
   }

     
 }
  
  
  
 function activar_oferta(id_oferta,activar,periodo,tipo,cliente_especial,motorclub,dreamcars,hcc,periodo_automatico)
 {
  id_('msg_error_activ').innerHTML='';  
  id_('periodo_fba').value=periodo;
  
  if (activar)
  {
		  
      ocultar_lista_ofertas();
      ocultar_form_oferta();
      mostrar_form_activar_oferta();
	  /*
	  if (cliente_especial==1)
		id_('bguardar_empresa').style.display='none';
	  else
		id_('bguardar_empresa').style.display='inline';
		*/
	  id_('bguardar_empresa').style.display='inline';
      
	  id_('id_oferta_fba').value=id_oferta;
      id_('frm_activar_oferta').reset(); 
      id_('tipo_oferta_fba').value=tipo;
      id_('activa_fba').value=id_('oferta_activa').value;
	  id_('cliente_especial_fba').value = cliente_especial;
	  id_('periodo_automatico_fba').value = periodo_automatico;
	  
	  $('#tperiodo').val(parseInt(periodo)/24);

	  /*switch(periodo)
	  {
		case '24': 
			id_('24h').checked=true;
		break;
		case '48': 
			id_('48h').checked=true;
		break;
		case '72': 
			id_('72h').checked=true;
		break;
		case '96': 
			id_('96h').checked=true;
		break;
	  }*/
	  
		//alert('m:'+motorclub+'d:'+dreamcars+'h:'+hcc);
		if (motorclub==1) id_('motorclub').checked=true;
		if (dreamcars==1) id_('dreamcars').checked=true;
		if (hcc==1) id_('hcc').checked = true;
		if (periodo_automatico==1) id_('cperiodo_automatico').checked=true;
		
		/*
		if (cliente_especial!=1) id_('empresas').style.display='block'; //definido en archivo formulario_activar_oferta.php.
		else id_('empresas').style.display='none'; 
		*/
  }
  else
  {
      if (id_('oferta_activa').value!='1') {alert('La oferta ya está desactivada');edita_oferta(id_oferta,tipo);}
      else
      {
      ocultar_form_activar_oferta();
      id_('id_oferta_fbdo').value = id_oferta;
      id_('tipo_oferta_fbdo').value=tipo;
      if (confirm('Esta seguro de que desea desactivar esta oferta?')) {
      id_('frm_desactivar_oferta').reset();
      $.colorbox({width:"42%", inline:true, href:"#form_desactivar_oferta",open:true});     
      }
  }
      
  }
 } 
  

 function envia_formulario_desactivar_oferta(id_oferta,password,tipo)
 {
    var ale='&gg'+(Math.floor(Math.random()*50000))+'=1';

    r=ajax.load('<?php echo $base_scripts ?>ajax_validar_password.php?id_oferta='+id_oferta+'&password='+password+'&tipo='+tipo+ale); 
    if (r.indexOf('OK')!=-1) 
    {
        envia_formulario_activar_oferta(id_oferta,0,0,tipo);
    }
    else id_('msg_error_desact').innerHTML = r;
 }
 
 function envia_formulario_activar_oferta(id_oferta,periodo,activar,tipo,motorclub,dreamcars,hcc)
 {
    var ale='&gg'+(Math.floor(Math.random()*50000))+'=1';

    id_('msg_error').innerHTML='';
    
    r=ajax.load('<?php echo $base_scripts ?>ajax_ofertas_bd.php?idoferta='+id_oferta+'&periodo='+periodo+'&activar='+activar+'&edicio_oferta='+(activar?'activar':'desactivar')+'&tipo='+tipo+'&motorclub='+motorclub+'&dreamcars='+dreamcars+'&hcc='+hcc+ale); 
    if (r.indexOf('Error')!=-1) 
    {   
        $.colorbox.close();
        alert(r);
        id_('msg_error_activ').innerHTML=r; 
        return;
    }
    //else if (activar) {eval(r);alert(' Oferta activada para un periodo de '+periodo+' horas');id_('activa_fba').value=1;}
	else if (activar) {eval(r);alert(' Oferta activada para un periodo de '+parseInt(periodo)/24+' dias');id_('activa_fba').value=1;}
	
    else {eval(r);$.colorbox.close()} //caso desactivar oferta.

 } 
  

//Al activar una oferta guarda las empresas seleccionadas as� como si el periodo se va a reiniciar
//de forma autom�tica.
 function enviar_formulario_guardar_empresa(id_oferta,motorclub,dreamcars,hcc,periodo_automatico,show_message)
 {
    var ale='&gg'+(Math.floor(Math.random()*50000))+'=1';

    id_('msg_error').innerHTML='';
    
    r=ajax.load('<?php echo $base_scripts ?>ajax_ofertas_bd.php?id_oferta='+id_oferta+'&guardar_empresas=1&motorclub='+motorclub+'&dreamcars='+dreamcars+'&hcc='+hcc+'&periodo_automatico='+periodo_automatico+ale); 
    if (r.indexOf('Error')!=-1) 
    {   
        $.colorbox.close();
        alert(r);
        id_('msg_error_activ').innerHTML=r; 
        return;
    }
    else  {eval(r);if (show_message) alert(' Los datos de empresas han sido modificados ');}

 } 



  //Función encargada de borrar la oferta
 function envia_formulario_borrar_oferta(id_oferta,password,creadas,tipo,tipo_password)
  {
    if (password=='') {alert('Debe introducir la contraseña');return;}      
    var aleatorio='&gg'+(Math.floor(Math.random()*50000))+'=1'
    //var dades=obtenirDadesForm('frm_busqueda');
    dades = 'password='+id_('password').value; 
    dades+= '&id_oferta='+id_oferta;
    dades+= '&creadas='+creadas;
    dades+= '&tipo='+tipo;
    dades+= '&tipo_password='+tipo_password;
	
	r=ajax.load('<?php echo $base_scripts ?>ajax_borrar_ofertas.php?'+dades+aleatorio);  
    //alert(r);
    if (r.indexOf('error_password')!=-1) {alert('Contraseña incorrecta. Inténtelo de nuevo.'); id_('frm_borrar_oferta').reset();}
    else 
    {
	cbclose();
	//$.colorbox.close();	 
	//alert('campaña borrada');
    id_('titulo_formulario_oferta').innerHTML='';
    if (creadas == '1')
        //get_lista_ofertas_creadas(tipo);
		get_lista_ofertas_creadas(filtro_oferta_activo,filtro_servicio_activo);
    else
        //get_lista_ofertas(tipo);
		get_lista_ofertas(campana_activa,filtro_servicio_activo_camp);
        
	
    mostrar_lista_ofertas();
    ocultar_form_oferta();
	
	if (creadas=='1') ocultar_menu_campanas();
    id_('menu_ofertas_creadas').style.display='none';
 
	}
 }


 //Función encargada de marcar una oferta "para un cliente especial"
 function envia_formulario_marcar_oferta(id_oferta,password,creadas)
  {
    if (password=='') {alert('Debe introducir la contraseña');return;}      
    var aleatorio='&gg'+(Math.floor(Math.random()*50000))+'=1'
    //var dades=obtenirDadesForm('frm_busqueda');
    dades = 'password='+id_('password').value; 
    dades+= '&id_oferta='+id_oferta;
    dades+= '&creadas='+creadas;
    r=ajax.load('<?php echo $base_scripts ?>ajax_marcar_oferta.php?'+dades+aleatorio); 

    if (r.indexOf('error_password')!=-1) {alert('Contraseña incorrecta. Inténtelo de nuevo.'); id_('frm_marcar_cliente_especial').reset();}
    else 
    {
    $.colorbox.close();   
    id_('titulo_formulario_oferta').innerHTML='';
    get_lista_ofertas_creadas();
    mostrar_lista_ofertas();
    ocultar_form_oferta();
    }
 }



function envia_formulario_cupon_oferta(string_buscado)
  {
	
	/**
	* En cas de no contenir valor agafa el nou assignat.
	*/
	var string_buscado = string_buscado || $.trim(id_('cupon_oferta').value);

	/**
	* En cas de ser cadena buida entrarem al if i fara el return per lo que no cal else if.
	*/
    if (string_buscado=='') {alert('Debe introducir el número de cupón');return;}
	
    if (string_buscado.length!=13  && string_buscado.length!=12 && string_buscado.length!=17) 
	{alert('El número debe tener 13 dígitos si corresponde a un cupón y 17 si es un número de transacción paypal y 12 para transaccion tpv');return;}             
          
      
    var aleatorio='&gg'+(Math.floor(Math.random()*50000))+'=1'
    //var dades=obtenirDadesForm('frm_busqueda');
    dades = 'cupon='+string_buscado; //el código alfa será único.
	dades+= '&creadas=0';
    //dades+= '&id_oferta='+id_('id_oferta').value;
//alert(dades);
     //alert(dades);
	//alert('<?php echo $base_scripts ?>cupones_ofertas.php?'+dades+aleatorio);
    r=ajax.load('<?php echo $base_scripts ;?>cupones_ofertas.php?'+dades+aleatorio);  

    id_('lista_cupones_ofertas').innerHTML = r;  
    $.colorbox({width:"80%", inline:true, href:"#lista_cupones_ofertas",open:true}); 
	mover_a_cupon();
}
 

  


</script>   



                
