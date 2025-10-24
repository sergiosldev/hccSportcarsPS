

<!-- mts 02052012 
    funciones ajax para la entidad Oferta_ -->
<script>
function envia_formulario_imagen(id_imagen)
  {
    var ale='&gg'+(Math.floor(Math.random()*50000))+'=1';
    if (id_imagen!='')  id_('id_imagen_ca').value = id_imagen;
    var dades ='';
    var oferta = '';
    oferta = '&id_oferta='+id_('idoferta_ca').value;
    imagen = '&id_imagen='+id_('id_imagen_ca').value;
   
    dades=obtenirDadesForm('form_alta_imagen_ca');
    //Validamos los campos del formulario y si todo va bien guardamos su contenido en B.D.
    id_('msg_error_im').innerHTML='';
    r=ajax.load('<?php echo $base_scripts_ca ?>ajax_imagen_oferta_bd_ca.php?'+dades+oferta+ale); 

    /*
    if (r.indexOf('Error')==-1) 
    {
        //eval(r);*/
        <?php /* r=ajax.load('<?php echo $base_scripts_ca ?>formulario_imagenes_oferta.php?'+imagen+oferta+ale); */ ?>
    /*        id_('step2').innerHTML=r;

    }
    else     
    {
        id_('msg_error_im').innerHTML=r; 
        return;
    }
    
    reset_imagen();
    */
    }
 

  function cambiar_posicion(posicion,direccion,imagen)
  {
    id_('msg_error_im_ca').innerHTML='';
    id_('edicion_imagen_ca').value='reposicionar';
    id_('posicion_ca').value = posicion;
    id_('direccion_ca').value = direccion;
    id_('id_imagen_ca').value = imagen;
    id_('guardar_imagen_ca').click();
  }  

  function editar_imagen_oferta(id,idoferta,titulo,portada,posicion) 
  { 
  id_('msg_error_im_ca').innerHTML='';
  id_('form_alta_imagen_ca').reset();
  id_('edicion_imagen_ca').value='edicio';  
  id_('id_imagen_ca').value=id;
  id_('idoferta_im_ca').value=idoferta;
  id_('titulo_im_ca').value=titulo;
  id_('posicion_ca').value=posicion;

  if (portada == 1)
  {
    id_('portada_ca').checked = true;
    id_('portada_valor_ca').value = 1;
  } 
  else
  {  
    id_('portada_ca').checked = false;
    id_('portada_valor_ca').value = 0;
  }

    id_('titulo_formulario_imagen_ca').innerHTML='Editar Imagen';
  }
  
  
  function alta_oferta()
  { 
  id_('form_alta_imagen_ca').reset()
  id_('edicion_imagen_ca').value = 'alta';
  id_('titulo_formulario_imagen_ca').innerHTML = 'Alta';
  }  
  

  function esborra_imagen(id) // quan esborres imatge
  { 
    if (confirm('Está seguro que desea borrar esta imagen?')) {
    var ale='&gg'+(Math.floor(Math.random()*50000))+'=1'         
    r = ajax.load('<?php echo $base_scripts_ca ?>ajax_imagen_oferta_bd_ca.php?esborra_im=' + id +ale);
    //get_lista_imagenes();
    }
  } 
  
  
//funcion invocada para eliminar un registro de imagenes.
function borrar_imagen(id_imagen,id_oferta) 
{ 

  id_('id_imagen_fbi_ca').value = id_imagen;
  id_('id_oferta_fbi_ca').value = id_oferta;
 
  if (confirm('Esta seguro de que desea borrar esta imagen?')) {
    //id_('frm_borrar_imagen_oferta_ca').reset();
    //$.colorbox({width:"42%", inline:true, href:"#form_borrar_imagen_oferta_ca",open:true});   
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
   //alert(dades);
    r=ajax.load('<?php echo $base_scripts_ca ?>ajax_borrar_imagen_oferta_ca.php?'+dades+ale); 

    if (r.indexOf('error_password')!=-1) {alert('Contraseña incorrecta. Inténtelo de nuevo.'); id_('frm_borrar_imagen_oferta_ca').reset();}
    else 
    {
        $.colorbox.close();
        id_('msg_error_im_ca').innerHTML='';
        r=ajax.load('<?php echo $base_scripts_ca ?>formulario_imagenes_oferta_ca.php?id_imagen'+id_imagen+'&id_oferta='+id_('idoferta_ca').value+ale); 
        id_('step2_ca').innerHTML=r;

     }  
  
  } 
</script>