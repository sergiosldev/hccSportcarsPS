

<!-- mts 02052012 
    funciones ajax para la entidad Oferta_ -->
<script>
function envia_formulario_imagen(id_imagen)
  {
    var ale='&gg'+(Math.floor(Math.random()*50000))+'=1';
    if (id_imagen!='')  id_('id_imagen').value = id_imagen;
    var dades ='';
    var oferta = '';
    oferta = '&id_oferta='+id_('idoferta').value;
    imagen = '&id_imagen='+id_('id_imagen').value;
   
    dades=obtenirDadesForm('form_alta_imagen');
    //Validamos los campos del formulario y si todo va bien guardamos su contenido en B.D.
    id_('msg_error_im').innerHTML='';
    r=ajax.load('<?php echo $base_scripts ?>ajax_imagen_oferta_bd.php?'+dades+oferta+ale); 

    }
 

  function cambiar_posicion(posicion,direccion,imagen)
  {
    id_('msg_error_im').innerHTML='';
    id_('edicion_imagen').value='reposicionar';
    id_('posicion').value = posicion;
    id_('direccion').value = direccion;
    id_('id_imagen').value = imagen;
    id_('guardar_imagen').click();
  }  

  function editar_imagen_oferta(id,idoferta,titulo,portada,posicion) 
  { 
  id_('msg_error_im').innerHTML='';
  id_('form_alta_imagen').reset();
  id_('edicion_imagen').value='edicio';  
  id_('id_imagen').value=id;
  id_('idoferta_im').value=idoferta;
  id_('titulo_im').value=titulo;
  id_('posicion').value=posicion;

  if (portada == 1)
    id_('portada').checked = true;
  else  
    id_('portada').checked = false;

  id_('titulo_formulario_imagen').innerHTML='Editar Imagen';
  }
  
  
  function alta_oferta()
  { 
  id_('form_alta_imagen').reset()
  id_('edicion_imagen').value = 'alta';
  id_('titulo_formulario_imagen').innerHTML = 'Alta';
  }  
  

  function esborra_imagen(id) // quan esborres imatge
  { 
    if (confirm('Está seguro que desea borrar esta imagen?')) {
    var ale='&gg'+(Math.floor(Math.random()*50000))+'=1'         
    r = ajax.load('<?php echo $base_scripts ?>ajax_imagen_oferta_bd.php?esborra_im=' + id +ale);
    //get_lista_imagenes();
    }
  } 
  
  
//funcion invocada para eliminar un registro de imagenes.
function borrar_imagen(id_imagen,id_oferta) 
{ 

  id_('id_imagen_fbi').value = id_imagen;
  id_('id_oferta_fbi').value = id_oferta;
 
  if (confirm('Esta seguro de que desea borrar esta imagen?')) {
    //id_('frm_borrar_imagen_oferta').reset();
    //$.colorbox({width:"42%", inline:true, href:"#form_borrar_imagen_oferta",open:true});   
	envia_form_borrar_imagen_oferta(id_imagen,id_oferta,'')
  }
} 
  
//Función encargada de borrar la imagen
function envia_form_borrar_imagen_oferta(id_imagen,id_oferta,password)
  {
    
    //if (password=='') {alert('Debe introducir la contraseña');return;}      
    var ale='&gg'+(Math.floor(Math.random()*50000))+'=1'
    //var dades=obtenirDadesForm('frm_busqueda');
    dades = 'password='+password; 
    dades+= '&id_imagen='+id_imagen;
	dades+= '&id_oferta='+id_oferta;
    r=ajax.load('<?php echo $base_scripts ?>ajax_borrar_imagen_oferta.php?'+dades+ale); 

    if (r.indexOf('error_password')!=-1) {alert('Contraseña incorrecta. Inténtelo de nuevo.'); id_('frm_borrar_imagen_oferta').reset();}
    else 
    {
        $.colorbox.close();
        id_('msg_error_im').innerHTML='';
        r=ajax.load('<?php echo $base_scripts ?>formulario_imagenes_oferta.php?id_imagen'+id_imagen+'&id_oferta='+id_('idoferta').value+ale); 
        id_('step2').innerHTML=r;

     }  
  
  } 
</script>