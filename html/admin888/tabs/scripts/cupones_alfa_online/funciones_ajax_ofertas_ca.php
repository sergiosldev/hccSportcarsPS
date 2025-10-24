<!-- mts 02052012 
    funciones ajax para la entidad Oferta_ -->

<?php
//include 'ajax_borrar_ofertas.php';
?>

<script>



function envia_formulari_oferta_ca(idoferta,nlineas_destacados,nlineas_condiciones,nlineas_descripcioncupones)
  {
    var ale='&gg'+(Math.floor(Math.random()*50000))+'=1';
    
    if (idoferta!='')  
    {
        id_('idoferta_ca').value = idoferta;
        id_('idoferta_im_ca').value = idoferta;
    
    }          
    var dades ='';
    //Actualizamos los textareas con los valores que hayamos modificado sobre los editores TinyMCE.
    $('#destacados_ca').val(tinyMCE.get("destacados_ca").getContent());
    $('#condiciones_ca').val(tinyMCE.get("condiciones_ca").getContent());
    $('#descripcion_ca').val(tinyMCE.get("descripcion_ca").getContent());
    $('#descripcion_cupones_ca').val(tinyMCE.get("descripcion_cupones_ca").getContent());


    dades=obtenirDadesForm('form_alta_oferta_ca');
    dades+='&nlineas_destacados='+nlineas_destacados;
    dades+='&nlineas_condiciones='+nlineas_condiciones;
    dades+='&nlineas_descripcion='+nlineas_descripcioncupones;
    //alert(dades)
    //Validamos los campos del formulario y si todo va bien guardamos su contenido en B.D.
    id_('msg_error_ca').innerHTML='';
    var multiple_cantidad;
    //alert(id_('multiple_dos').checked);
    if (id_('multiple_dos_ca').checked==true) multiple_cantidad = 2;
    else multiple_cantidad = 1;
    dades+='&multiple_cantidad='+multiple_cantidad;
    //alert(dades.substr(1100));+
   // alert('idoferta='+idoferta+'&edicio_oferta='+id_('edicio_oferta_ca').value+'&'+dades+ale);
    r=ajax_post.load('<?php echo $base_scripts_ca ?>ajax_ofertas_bd_ca.php','idoferta='+idoferta+'&edicio_oferta='+id_('edicio_oferta_ca').value+'&'+dades+ale); 
    
    //id_('msg_error').innerHTML=r;  
    if (r.indexOf('Error')==-1) 
    {

    	eval(r);
    	
        id_('idoferta_im_ca').value=id_('idoferta_ca').value;
        id_('boton_vista_previa_ca').style.visibility='visible';
        id_('boton_vista_oferta_ca').style.visibility='visible';
    }
    else     
    {
    
        id_('msg_error_ca').innerHTML=r;

        return;
    }


    //Al finalizar el alta limpiaremos el formulario.
   if (id_('idoferta_ca').value!='' && id_('edicio_oferta_ca').value!='edicio') {id_('nueva_oferta_ca').style.visibility='visible';}
   else {id_('nueva_oferta_ca').style.visibility='hidden';}
  }


  function envia_formulario_distribuidores()
  {
    if (id_('distribuidor_oferta_ca').value=='') {alert('Debe introducir algún criterio de búsqueda para los distribuidores');return;}
       
    
    var aleatorio='&gg'+(Math.floor(Math.random()*50000))+'=1'
    if (id_('distribuidor_oferta_ca').value==undefined) dades='filtro=';
    else dades = 'filtro='+id_('distribuidor_oferta_ca').value; 
    dades += '&direccion=0&orden=0'; 
    //alert(dades);
    r=ajax.load('<?php echo $base_scripts_ca ?>distribuidores.php?'+dades+aleatorio);  
    id_('lista_distribuidores_ca').style.display='block';
    id_('lista_distribuidores_ca').innerHTML = r;  
    ocultar_form_busqueda_distribuidor_ca();
    //$.colorbox({width:"80%", inline:true, href:"#lista_clientes",open:true}); 
 }


  function nueva_oferta()
  {
    
    var ale='&gg'+(Math.floor(Math.random()*50000))+'=1';
    id_('form_alta_oferta_ca').reset();
    try{
    id_('form_alta_imagen_ca').reset();
    } catch (e){}
    id_('idoferta_ca').value='';
    id_('oferta_activa_ca').value='';
    id_('edicio_oferta_ca').value='alta';
    id_('titulo_formulario_oferta_ca').innerHTML='Alta';
    id_('boton_vista_previa_ca').style.visibility='hidden';    
    id_('boton_vista_oferta_ca').style.visibility='hidden';    
    r=ajax.load('<?php echo $base_scripts_ca ?>formulario_imagenes_oferta_ca.php?imagen=&idoferta='+ale); 
    id_('step2_ca').innerHTML=r;
    id_('titulo_formulario_imagen_ca').innerHTML='Nueva Imagen';
    
    reset_imagen();
  }

  function edita_oferta(id) 
  { 

  var ale='&gg'+(Math.floor(Math.random()*50000))+'=1';
  id_('msg_error_ca').innerHTML='';
  id_('form_alta_oferta_ca').reset();
  id_('alta_oferta_ca').style.display='block';
  id_('edicio_oferta_ca').value='consulta';  
  
  //tipo = (ofertas_online o cupones_alfa_online)
  r=ajax.load('<?php echo $base_scripts_ca ?>ajax_ofertas_bd_ca.php?idoferta='+ id +'&edicio_oferta='+id_('edicio_oferta_ca').value + ale);       

//alert(r);
  eval(r);
  
  id_('edicio_oferta_ca').value='edicio';  
  id_('idoferta_ca').value=id;
  id_('idoferta_im_ca').value=id;
  ocultar_form_activar_oferta_ca();
  id_('boton_vista_previa_ca').style.visibility='visible';  
  id_('boton_vista_oferta_ca').style.visibility='visible';  
  id_('titulo_formulario_oferta_ca').innerHTML='Editar';

  //actualizamos formulario imagenes.
  
  oferta = '&id_oferta='+id;
   
  r=ajax.load('<?php echo $base_scripts_ca ?>formulario_imagenes_oferta_ca.php?imagen='+oferta+ale); 
  id_('step2_ca').innerHTML=r;
  id_('titulo_formulario_imagen_ca').innerHTML='Nueva Imagen';
  reset_imagen();

  }
  
  function reset_imagen()
  {
   id_('titulo_im_ca').value='';
   id_('imagen_oferta_ca').value='';
   id_('id_imagen_ca').value='';
   id_('portada_ca').value=0;
   id_('posicion_ca').value='';
   id_('edicion_imagen_ca').value='alta';

  }  
  

  function alta_oferta()
  { 
  id_('form_alta_oferta_ca').reset()
  id_('edicio_oferta_ca').value = 'alta';
  id_('titulo_formulario_oferta_ca').innerHTML = 'Alta';
  }  
  

  function esborra_oferta(id) // quan esborres oferta
  { 
  if (confirm('Está seguro que desea borrar esta oferta?')) {
    var ale='&gg'+(Math.floor(Math.random()*50000))+'=1'         
    r = ajax.load('<?php echo $base_scripts_ca ?>ajax_ofertas_bd_ca.php?esborra_ofe=' + id +ale);
    get_lista_ofertas();
    }
  } 
  
  
//funcion invocada para eliminar un registro de ofertas.
 function borrar_oferta_ca(id_oferta,creadas,cupones) 
 { 
  var ale='&gg'+(Math.floor(Math.random()*50000))+'=1'; 
    
  //id_oferta hará referencia al id histórico en caso de que estemos visualizando las campañas.  
  id_('creadas_fbo_ca').value=creadas;
  id_('id_oferta_fbo_ca').value = id_oferta;
  id_('tipo_password_fbo_ca').value='';
  
  var texto='';
  var texto2='';
  var texto_cupones='';
  var texto_activas='';
  var texto_modif = ''; 
   //texto_cliente_especial = '!!!ATENCIÓN!!! Al borrar esta OFERTA la CAMPAÑA asociada se marcará como INACTIVA.\n';
  //Campañas.
  if (creadas==0)
   {
    r = ajax.load('<?php echo $base_scripts_ca ?>ajax_ofertas_bd_ca.php?buscar_cupones_oferta=1&creadas=0&id_oferta=' + id_oferta +ale);
    cupones = r;
    if (cupones>0)
      texto = '!!!ATENCIÓN!!! ESTA CAMPAÑA TIENE CUPONES ASOCIADOS.\n\n                 ¿Está seguro de que desea borrarla?';
    else texto = '¿Está seguro de que desea borrar esta campaña?';
   }
  //Ofertas Creadas. 
  else
   {
    r = ajax.load('<?php echo $base_scripts_ca ?>ajax_ofertas_bd_ca.php?buscar_cupones_oferta=1&creadas=1&id_oferta=' + id_oferta +ale);
    cupones = r;
    r = ajax.load('<?php echo $base_scripts_ca ?>ajax_ofertas_bd_ca.php?buscar_campanyas_activas=1&id_oferta=' + id_oferta +ale);
    activas = r;
    texto_cupones='!!!ATENCIÓN!!! existen CAMPAÑAS ACTIVAS con CUPONES ASOCIADOS.\n';
    texto_activas='!!!ATENCIÓN!!! ESTA OFERTA TIENE CAMPAÑAS ACTIVAS ASOCIADAS.\n';
    //texto_cliente_especial = '!!!ATENCIÓN!!! Al borrar esta OFERTA la CAMPAÑA asociada se marcará como INACTIVA.\n';
    texto_modif = 'Tenga en cuenta que al eliminar la oferta, los textos e imagenes de\n las CAMPAÑAS ACTIVAS no se podrán modificar.\n\n                           ';
    
    /*if (especial==1)
    {
       texto+=texto_cliente_especial;
    }
    else
    {*/
    if (parseInt(cupones)>0) texto+=texto_cupones + texto_modif;
    else if (parseInt(activas)>0) texto+=texto_activas + texto_modif;
    //}
    //texto+= '¿Está seguro de que desea borrarla?';
    if (texto=='')
        texto2 = '¿Está seguro de que desea borrar esta oferta?';
    else texto2 = '¿Está seguro de que desea borrarla?';      
   }
 


  if (parseInt(cupones)>0) {id_('tipo_password_fbo_ca').value='facturados';}
  texto = texto+((texto!='')?'\n                     ':'')+texto2;

  if (confirm(texto)) 
    {
    id_('frm_borrar_oferta_ca').reset();
    $.colorbox({width:"42%", inline:true, href:"#form_borrar_oferta_ca",open:true});   
    }

} 
 
/*
function marca_cliente_especial(id_oferta,creadas,marcado)
{
  id_('creadas_fmce').value=creadas;
  id_('id_oferta_fmce').value = id_oferta;
  var prefijo = '';
  var sufijo='';
  if (marcado=='1') {prefijo = 'des';sufijo=' La oferta será desactivada.';}
    if (confirm('Esta seguro de que desea '+prefijo+'marcar esta oferta como "cliente especial"?'+sufijo)) 
    //if (confirm('Esta seguro de que desea marcar esta oferta como "cliente especial"?')) 
    {  
        id_('frm_marcar_cliente_especial').reset();
        $.colorbox({width:"42%", inline:true, href:"#form_marcar_cliente_especial",open:true});   
    }
}    
*/
  
 function duplicar_oferta_ca(id_oferta)
 {
    
   var aleatorio='&gg'+(Math.floor(Math.random()*50000))+'=1'; 
    
   dades='id_oferta='+id_oferta;
   dades+='&duplicar=1';   
   dades+='&creadas=1';
   dades+='&tipo_password=';
   if (!confirm('Está seguro de que desea duplicar esta oferta?')) 
   {
       return;
   }
   else 
   {
       id_('frm_validar_password_ca').reset();
       id_('archivo_operacion_ca').value= 'ajax_ofertas_bd_ca.php'
       id_('archivo_retorno_ca').value = 'ofertas_ca.php';
       id_('div_retorno_ca').value= 'lista_ofertas_ca';
       id_('ancho_div_retorno_ca').value = 80;
       id_('datos_ca').value = dades;
                        
       $.colorbox({width:"42%", inline:true, href:"#form_validar_password_ca",open:true}); 
       return;          
   }

     
 }
  


 function duplicar_ofertas_online_ca(id_oferta)
 {
    
   var aleatorio='&gg'+(Math.floor(Math.random()*50000))+'=1'; 
    
   dades='id_oferta='+id_oferta;
   dades+='&duplicar=2';   
   dades+='&creadas=1';
   dades+='&tipo_password=';
   if (!confirm('Está seguro de que desea copiar esta oferta en Ofertas Online?')) 
   {
       return;
   }
   else 
   {
       id_('frm_validar_password_ca').reset();
       id_('archivo_operacion_ca').value= 'ajax_ofertas_bd_ca.php'
       id_('archivo_retorno_ca').value = 'ofertas_ca.php';
       id_('div_retorno_ca').value= 'lista_ofertas_ca';
       id_('ancho_div_retorno_ca').value = 80;
       id_('datos_ca').value = dades;
                        
       $.colorbox({width:"42%", inline:true, href:"#form_validar_password_ca",open:true});     
       return;          
   }

     
 }

  
 function activar_oferta(id_oferta,activar)
 {
  //,periodo,tipo
  id_('msg_error_activ_ca').innerHTML='';  
  //id_('periodo_fba_ca').value=periodo;

  if (activar)
  {
      
      envia_formulario_activar_oferta(id_oferta,1);
     /* ocultar_lista_ofertas_ca();
      ocultar_form_oferta_ca();
      mostrar_form_activar_oferta_ca();
      id_('id_oferta_fba_ca').value=id_oferta;
      id_('frm_activar_oferta_ca').reset();
       
//      id_('tipo_oferta_fba_ca').value=tipo;

      id_('activa_fba_ca').value=id_('oferta_activa_ca').value;
      */ 
  }
  else
  {
      if (id_('oferta_activa_ca').value!='1') {alert('La oferta ya está desactivada');edita_oferta(id_oferta);}
      else
      {
      ocultar_form_activar_oferta_ca();
      id_('id_oferta_fbdo_ca').value = id_oferta;
      //id_('tipo_oferta_fbdo_ca').value=tipo;
      if (confirm('Esta seguro de que desea desactivar esta oferta?')) {
      id_('frm_desactivar_oferta_ca').reset();
      $.colorbox({width:"42%", inline:true, href:"#form_desactivar_oferta_ca",open:true});     
      }
  }
      
  }
 } 
  

 function envia_formulario_desactivar_oferta(id_oferta,password)
 {
    var ale='&gg'+(Math.floor(Math.random()*50000))+'=1';

    r=ajax.load('<?php echo $base_scripts_ca ?>ajax_validar_password_ca.php?id_oferta='+id_oferta+'&password='+password+ale); 
    if (r.indexOf('OK')!=-1) 
    {
        envia_formulario_activar_oferta(id_oferta,0);
    }
    else id_('msg_error_desact_ca').innerHTML = r;
 }
 
 function envia_formulario_activar_oferta(id_oferta,activar)
 {
    var ale='&gg'+(Math.floor(Math.random()*50000))+'=1';

    id_('msg_error_ca').innerHTML=''; 
    
    r=ajax.load('<?php echo $base_scripts_ca ?>ajax_ofertas_bd_ca.php?idoferta='+id_oferta+'&activar='+activar+'&edicio_oferta='+(activar?'activar':'desactivar')+ale); 
    if (r.indexOf('Error')!=-1) 
    {   
        if (r.indexOf('Campanya activa')!=-1) alert('Ya existe una campaña activa.');
        $.colorbox.close();
        //alert(r);
        id_('msg_error_activ_ca').innerHTML=r; 
        return;
    }
    else if (activar) {eval(r);alert(' Oferta activada');id_('activa_fba_ca').value=1;}
    else {eval(r);$.colorbox.close()} //caso desactivar oferta.
 } 
   
 //Función encargada de borrar la oferta
 function envia_formulario_borrar_oferta(id_oferta,password,creadas,tipo_password)
  {
    if (password=='') {alert('Debe introducir la contraseña');return;}      
    var aleatorio='&gg'+(Math.floor(Math.random()*50000))+'=1'
    //var dades=obtenirDadesForm('frm_busqueda');
    dades = 'password='+id_('password').value;   
    dades+= '&id_oferta='+id_oferta;  
    dades+= '&creadas='+creadas;  
    dades+= '&tipo_password='+tipo_password;      
    //alert(dades);
    r=ajax.load('<?php echo $base_scripts_ca ?>ajax_borrar_ofertas_ca.php?'+dades+aleatorio); 
    //alert(r);
    if (r.indexOf('error_password')!=-1) {alert('Contraseña incorrecta. Inténtelo de nuevo.'); id_('frm_borrar_oferta_ca').reset();}
    else 
    {
    $.colorbox.close();   
    id_('titulo_formulario_oferta_ca').innerHTML='';
    if (creadas == '1')
        get_lista_ofertas_creadas();
    else
        get_lista_ofertas();
        
    mostrar_lista_ofertas_ca();
    ocultar_form_oferta_ca();
    id_('menu_ofertas_creadas_ca').style.display='none';
    }
 }

/*
 //Función encargada de marcar una oferta "para un cliente especial"
 function envia_formulario_marcar_oferta(id_oferta,password,creadas)
  {
    if (password=='') {alert('Debe introducir la contraseña');return;}      
    var aleatorio='&gg'+(Math.floor(Math.random()*50000))+'=1'
    //var dades=obtenirDadesForm('frm_busqueda');
    dades = 'password='+id_('password').value; 
    dades+= '&id_oferta='+id_oferta;
    dades+= '&creadas='+creadas;
    r=ajax.load('<php echo $base_scripts_ca ?>ajax_marcar_oferta.php?'+dades+aleatorio); 

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

*/

function envia_formulario_cupon_oferta()
  {
    if (id_('cupon_oferta_ca').value=='') {alert('Debe introducir el número de cupón');return;}
    if (id_('cupon_oferta_ca').value.length!=13 && id_('cupon_oferta_ca').value.length!=17) {alert('El número debe tener 13 dígitos si corresponde a un cupón y 17 si es un número de transacción');return;}
          
      
    var aleatorio='&gg'+(Math.floor(Math.random()*50000))+'=1'
    //var dades=obtenirDadesForm('frm_busqueda');
    dades = 'cupon='+id_('cupon_oferta_ca').value; //el código alfa será único.
    dades +='&creadas=0';
	//dades+= '&id_oferta='+id_('id_oferta_ca').value;
//alert(dades);
    r=ajax.load('<?php echo $base_scripts_ca ?>cupones_oferta_ca.php?'+dades+aleatorio);  

    id_('lista_cupones_ofertas_ca').innerHTML = r;  
    $.colorbox({width:"80%", inline:true, href:"#lista_cupones_ofertas_ca",open:true}); 
 
 }


  
</script>   