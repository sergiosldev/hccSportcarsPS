
<!-- mts 02052012 
    funcions ajax para la entidad Establecimientos -->
<script>
function envia_formulari_estab()
  {
    var ale='&gg'+(Math.floor(Math.random()*50000))+'=1'
    var dades=obtenirDadesForm('form_alta_estab');
   
    r=ajax.load('<?php echo $base_scripts ?>ajax.php?'+dades+ale);
  
    var ok=/OK/;
    if (ok.test(r)) { // recarrega graella
     //alert(r)
     //id_('msg_error').innerHTML='Recepción correcta';
      get_lista_establecimientos();
      id_('alta').style.display="none";
      vista('establecimientos');
      
     }
    else {  
     id_('msg_error').innerHTML=r;
     get_lista_establecimientos();
     vista('establecimientos');    
    }
     
  }
  
  
  function edita(id) 
  { 
  var ale='&gg'+(Math.floor(Math.random()*50000))+'=1';
  id_('msg_error').innerHTML='';
  id_('form_alta_estab').reset();

  $.colorbox({width:"42%", inline:true, href:"#form_est",open:true});

  id_('alta').style.display='block';
  //alert('akir');
  id_('edicio_estab').value='edicio';
  id_('titulo_formulario').innerHTML = 'Editar';
  id_('id_establecimiento').value=id;
  r=ajax.load('<?php echo $base_scripts ?>ajax.php?id_edita_estab='+id+ale); 
  ocultar_form_estab();

  
  //alert('aki2');
  eval(r);
  
  }
  
  
  function alta()
  { 
  id_('form_alta_estab').reset()
  id_('edicio_estab').value = 'alta';
  id_('titulo_formulario').innerHTML = 'Alta';
  }  
  

  function esborra(id) // quan esborres pilot
  { 
  if (confirm('Está seguro que desea borrar este establecimiento?')) {
    var ale='&gg'+(Math.floor(Math.random()*50000))+'=1'         
    r = ajax.load('<?php echo $base_scripts ?>ajax.php?esborra_est=' + id +ale);
    get_lista_establecimientos();
    }
  } 
  
  
  function activar_talonarios(id)
  {
      get_lista_talonarios(id);
  }
  
  
//funcion invocada para eliminar un registro de establecimientos.
function borra_establecimiento(id_establecimiento) 
{ 

  id_('id_establecimiento_fbe').value = id_establecimiento;
 
  if (confirm('Esta seguro de que desea borrar este establecimiento?')) {
    id_('frm_borrar_establecimiento').reset();
    $.colorbox({width:"42%", inline:true, href:"#form_borrar_establecimiento",open:true});   
  }
} 
  
//Función encargada de borrar el establecimiento
function envia_formulario_establecimiento(id_establecimiento,password)
  {
    if (password=='') {alert('Debe introducir la contraseña');return;}      
    var aleatorio='&gg'+(Math.floor(Math.random()*50000))+'=1'
    //var dades=obtenirDadesForm('frm_busqueda');
    dades = 'password='+id_('password').value; //el código alfa será único.
    dades+= '&id_establecimiento='+id_establecimiento;
    
    r=ajax.load('<?php echo $base_scripts ?>ajax_establecimiento.php?'+dades+aleatorio); 

    if (r.indexOf('error_password')!=-1) {alert('Contraseña incorrecta. Inténtelo de nuevo.'); id_('frm_borrar_establecimiento').reset();}
    else $.colorbox.close();   
    
    get_lista_establecimientos();
 }
  
 
  
</script>