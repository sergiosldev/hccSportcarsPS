<?php
include_once (dirname(__FILE__).'/scripts/config_events_new.php');   

include_once (dirname(__FILE__).'/scripts/formulario_inicio_oferta.php');   

?> 

<script type="text/javascript" src="tabs/js/funcs.js"></script>
<script type="text/javascript" src="tabs/js/ajax_load_post.js"></script>

<script> 

id_('titulo_formulario_inicio').innerHTML='';
 
function envia_formulari_inicio(nlineas)
  {
    var ale='&gg'+(Math.floor(Math.random()*50000))+'=1';
    
    var dades ='';
    dades='texto_inicio='+id_('texto_inicio').value;
    dades=dades+'&lineas='+nlineas;
    //dades=obtenirDadesForm('form_inicio');
    //alert(dades);
    id_('msg_error_inicio').innerHTML='';
    r=ajax_post.load('<?php echo $base_scripts ?>ajax_inicio_bd.php',dades+ale); 
    //alert(r);
    //id_('msg_error').innerHTML=r;  
    if (r.indexOf('ERROR')==-1) {id_('msg_error_inicio').innerHTML='';return;}
    else     
    {
        id_('msg_error_inicio').innerHTML=r;
        return;
    }
    
  }
 </script>
 
