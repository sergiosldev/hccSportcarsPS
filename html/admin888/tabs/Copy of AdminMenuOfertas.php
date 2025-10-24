<?php
class AdminMenuOfertas{}  
include dirname(__FILE__).'/scripts/config_events.php';

?>
<script type="text/javascript" src="tabs/js/sha.js"></script>
     <script type="text/javascript" src="tabs/js/funcs.js"></script>
     <script type="text/javascript" src="tabs/js/ajax_load.js"></script>
     <script type="text/javascript" src="tabs/js/ajax_load_post.js"></script>
     <link rel="stylesheet" type="text/css" href="tabs/css/style.css">
     <link media="screen" rel="stylesheet" href="tabs/modal/colorbox.css" />
     <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.4.4/jquery.min.js"></script>
     <script src="tabs/modal/colorbox/jquery.colorbox.js"></script>
     <script type="text/javascript" src="../../js/ZeroClipboard.js"></script>
<?php 
include dirname(__FILE__).'/scripts/funciones_ajax_ofertas.php';
include dirname(__FILE__).'/scripts/funciones_ajax_imagen_oferta.php';

?>
<script>

</script>    

<div id="centrar">
<div>
<fieldset>
    <legend>Opciones Oferta</legend>
    <!--Validar Cupones: <INPUT TYPE="RADIO" NAME="ciudad_c" VALUE="" checked="checked" onclick="vista('cupones')"> -->
    Crear oferta: <INPUT id="editar" TYPE="RADIO" NAME="editar" VALUE="editar" onclick="vista('alta_oferta')"> 
    &nbsp;&nbsp;&nbsp;&nbsp;Ver Campañas: <INPUT TYPE="RADIO" id="lista" NAME="ofertas" VALUE="lista" onclick="vista('ofertas')">
    &nbsp;&nbsp;&nbsp;&nbsp;Ofertas creadas: <INPUT TYPE="RADIO" id="lista_creadas" NAME="ofertas_creadas" VALUE="lista_creadas" onclick="vista('ofertas_creadas')">
    &nbsp;&nbsp;&nbsp;&nbsp;Validar cupón: <INPUT id="validar_cupon_oferta" TYPE="RADIO" NAME="validar_cupon_oferta" VALUE="validar_cupon" onclick="vista('validar_cupon_oferta')">
    <!--&nbsp;&nbsp;&nbsp;&nbsp;Ficheros: <INPUT id="ficheros" TYPE="RADIO" NAME="ficheros" VALUE="ficheros" onclick="vista('ficheros')">-->

</fieldset>
</div>
</div>
<?php include dirname(__FILE__).'/scripts/menu_ofertas_creadas.php';  ?>


<div id="lista_ofertas" ></div>
<div id="alta_oferta" style="display:none;float:left;width:100%;">
<?php 
include dirname(__FILE__).'/scripts/formulario_oferta.php'; 
?>
</div>



<br>


<div id="listado" style="display:none;float:left;width:100%;"  >
    <div id='lista_cupones_ofertas' style='text-align:left;padding:10px; background:#fff;'>
    </div>
</div>
<?php 

include dirname(__FILE__).'/scripts/formulario_busqueda_cupon_oferta.php'; 
//include dirname(__FILE__).'/scripts/formulario_fichero_cupones.php';  
include dirname(__FILE__).'/scripts/formulario_borrar_oferta.php';   
include dirname(__FILE__).'/scripts/formulario_borrar_imagen_oferta.php';   
include dirname(__FILE__).'/scripts/formulario_desbloquear_cupon_oferta.php';   
include dirname(__FILE__).'/scripts/formulario_observaciones_cupon_oferta.php';    
include dirname(__FILE__).'/scripts/formulario_email_cupones_oferta.php';   
include dirname(__FILE__).'/scripts/formulario_activar_oferta.php';
include dirname(__FILE__).'/scripts/formulario_validar_password.php';   
include dirname(__FILE__).'/scripts/formulario_desactivar_oferta.php';   
include dirname(__FILE__).'/scripts/formulario_usuarios.php';   
include dirname(__FILE__).'/scripts/formulario_cliente_especial_oferta.php';   

?>


<script>

var cbclose = $.colorbox.close;
//Por defecto mostramos la lista de establecimientos y marcamos por tanto la primera opción del radiobutton.
id_('editar').checked=true;
vista('alta_oferta');

function dummy(){}
function mostrar_ocultar_elementos(elemento)
{
    formularios = new Array();
    formularios['ofertas'] = new Array('mostrar_lista_ofertas','ocultar_lista_ofertas');
    formularios['ofertas_creadas'] = new Array('mostrar_lista_ofertas','dummy');
    formularios['alta_oferta']= new Array('mostrar_form_oferta','ocultar_form_oferta');
    formularios['validar_cupon_oferta'] = new Array('mostrar_form_busqueda_cupon_oferta','ocultar_form_busqueda_cupon_oferta');
    formularios['k1']= new Array('mostrar_form_activar_oferta','ocultar_form_activar_oferta');
    formularios['k2']= new Array('mostrar_form_usuarios_oferta','ocultar_form_usuarios_oferta');
                                
    selectores = new Array();
    selectores['ofertas_creadas']='lista_creadas';
    selectores['ofertas']='lista';
    selectores['alta_oferta']='editar';
    selectores['validar_cupon_oferta']='validar_cupon_oferta';
    
    for(var form in formularios)
    {
        if (form == elemento) window[formularios[form][0]](); 
        else window[formularios[form][1]]();
    }
    for (var selector in selectores) 
    {
    if (selector == elemento) id_(selectores[selector]).checked = true;
    else if (id_(selectores[selector]).checked == true) id_(selectores[selector]).checked = false;
    }
}

function vista(nombre)
{
    ocultar_menu_ofertas_creadas();   
    switch (nombre)
    {
        case 'ofertas':
            id_('titulo_formulario_oferta').innerHTML='';
            get_lista_ofertas();
            mostrar_ocultar_elementos('ofertas');
            /*mostrar_lista_ofertas();
            ocultar_form_oferta();
            ocultar_form_busqueda_cupon_oferta();
            //ocultar_form_fichero_cupones();
            ocultar_form_activar_oferta();
            ocultar_form_usuarios_oferta();
            
            id_('lista_creadas').checked=false;
            id_('lista').checked=true;
            id_('editar').checked=false;
            id_('validar_cupon_oferta').checked=false;
            */
            id_('edicio_oferta').value = '';
            
        break;
        case 'ofertas_creadas':
            id_('titulo_formulario_oferta').innerHTML='';
            get_lista_ofertas_creadas();
            mostrar_ocultar_elementos('ofertas_creadas');
/*            mostrar_lista_ofertas();
            ocultar_form_oferta();
            ocultar_form_busqueda_cupon_oferta();
            //ocultar_form_fichero_cupones();
            ocultar_form_activar_oferta();
            ocultar_form_usuarios_oferta();
            
            id_('lista_creadas').checked=true;
            id_('lista').checked=false;
            id_('editar').checked=false;
            id_('validar_cupon_oferta').checked=false;
            */
            //id_('ficheros').checked=false;
            id_('edicio_oferta').value = '';
            
        
        break;        
        case 'alta_oferta':
            //*ocultar_lista_ofertas();
            id_('titulo_formulario_oferta').innerHTML='Alta';
            //*ocultar_form_busqueda_cupon_oferta();
            id_('nueva_oferta').style.visibility='hidden';
            //*mostrar_form_oferta();
            nueva_oferta();
            mostrar_ocultar_elementos('alta_oferta');

            /*ocultar_form_activar_oferta();
            ocultar_form_usuarios_oferta();

                     
            //ocultar_form_fichero_cupones();
            id_('lista_creadas').checked=false;
            id_('lista').checked=false;
            id_('validar_cupon_oferta').checked=false;
            //id_('ficheros').checked=false;            
            id_('editar').checked=true;*/
            id_('msg_error').innerHTML='';  
            //envia_formulari_oferta('');
            //alta();
        break;
        case 'validar_cupon_oferta':
            id_('titulo_formulario_oferta').innerHTML='';
            /*id_('validar_cupon_oferta').checked=true;
            id_('lista_creadas').checked=false;
            id_('lista').checked=false;
            //id_('ficheros').checked=false;            
            id_('editar').checked=false;*/
            id_('cupon_oferta').value='';
            mostrar_ocultar_elementos('validar_cupon_oferta');
            /**ocultar_lista_ofertas();
            ocultar_form_activar_oferta();
            //ocultar_form_fichero_cupones();
            ocultar_form_oferta();
            mostrar_form_busqueda_cupon_oferta();
            ocultar_form_usuarios_oferta();*/
            break;                             
        case 'ficheros':
            id_('titulo_formulario_oferta').innerHTML='';
            mostrar_ocultar_elementos('k1');

/*            id_('validar_cupon_oferta').checked=true;
            id_('lista').checked=false;
            id_('lista_creadas').checked=false;
            id_('editar').checked=false;  
            //id_('ficheros').checked=true;  
            ocultar_lista_ofertas();
            mostrar_form_fichero_cupones();
            ocultar_lista_talonarios();  
            ocultar_form_oferta();
            ocultar_form_busqueda_cupon_oferta();
            ocultar_form_usuarios_oferta();*/
            break;                             

        default:
            id_('titulo_formulario_oferta').innerHTML='';
            ocultar_form_oferta();
            ocultar_form_usuarios_oferta();
            //ocultar_form_fichero_cupones();
            ocultar_form_busqueda_cupon_oferta();
            id_('edicio_oferta').value = '';
        break;        
    }
}




//Esta función se encarga de listar todos los establecimientos.
function get_lista_ofertas()
   {

    var aleatorio='&gg'+(Math.floor(Math.random()*50000))+'=1'

    var r=ajax.load('<?php echo $base_scripts ?>ofertas.php?creadas=0'+aleatorio);  

    id_('lista_ofertas').innerHTML = r;         
   }   


function get_lista_ofertas_creadas()
   {

    var aleatorio='&gg'+(Math.floor(Math.random()*50000))+'=1'

    var r=ajax.load('<?php echo $base_scripts ?>ofertas.php?creadas=1'+aleatorio);  
//alert(r);
    id_('lista_ofertas').innerHTML = r;         
   }   


function edita_menu_oferta(id_oferta)
{
  ocultar_lista_ofertas();
  mostrar_menu_ofertas_creadas();
  id_('id_oferta').value=id_oferta;   
  edita_oferta(id_oferta);
}

function copia_link(link) 
{
    if (window.clipboardData) 
    {
        window.clipboardData.setData('text', link);
        alert('Link copiado');
    }
}        

/*function copia_link(link) 
{
    if (window.clipboardData) {
        window.clipboardData.setData('text', link);
    } else {
        var clipboarddiv = document.getElementById('divclipboardswf');
        if (!clipboarddiv) {
            clipboarddiv = document.createElement('div');
            clipboarddiv.setAttribute("name", "divclipboardswf");
            clipboarddiv.setAttribute("id", "divclipboardswf");
            document.body.appendChild(clipboarddiv);
        //}
        clipboarddiv.innerHTML = '<embed src="clipboard.swf" FlashVars="clipboard=' + encodeURIComponent(link) + '" width="0" height="0" type="application/x-shockwave-flash"></embed>';
    }
    alert('The text is copied to your clipboard...');
}  
*/




////Esta función se encarga de listar los cupones asociados a una oferta.
function cupones_usados_ofertas(id_oferta,creadas)
  {
    var aleatorio='&gg'+(Math.floor(Math.random()*50000))+'=1'; 
    dades='id_oferta='+id_oferta;
    //creadas=0 significa que estamos mostrando el registro de ofertas (campañas). con lo que el id_oferta
    //será en realidad el id del histórico (id_oferta_hist).
    dades=dades+'&creadas='+creadas;
  //   alert(1);
//alert(dades);
    r=ajax.load('<?php echo $base_scripts ?>cupones_ofertas.php?'+dades+aleatorio);      
//alert(r);
    //eval(r);
    if (r.indexOf('error')!=-1) r = " <div style='font-weight:bold;color:red;font-size:18px;'>No existen cupones para esta oferta</div>";    
    id_('lista_cupones_ofertas').innerHTML = r;  
    $.colorbox({width:"80%", inline:true, href:"#lista_cupones_ofertas",open:true}); 
  }  




////Esta función abre una ventana donde podremos introducir unas observaciones.
function observaciones_cupon_oferta(id_oferta,cupon,observaciones,creadas)
  {

    var aleatorio='&gg'+(Math.floor(Math.random()*50000))+'=1'; 
    dades='id_oferta='+id_oferta;
    dades+='&cupon='+cupon;
    dades+='&observaciones='+observaciones;
    dades+='&creadas='+creadas;
    id_('creadas_fo').value=creadas;
    id_('observaciones_oferta').value=observaciones;
    id_('lista_cupones_ofertas').style.display='block';
    id_('frm_observaciones_cupon_oferta').reset();
    id_('id_oferta_fo').value = id_oferta;
    id_('ncupon_fo').value = cupon;
    $.colorbox({width:"42%", inline:true, href:"#form_observaciones_cupon_oferta",open:true}); 

    r=ajax.load('<?php echo $base_scripts ?>ajax_observaciones_oferta.php?'+dades+aleatorio); 

    //esta llamada ajax en principio no sería necesaria ya  que desde la lista de cupones 
    //ya se pasan como parámetro las observaciones. Sinembargo lo dejamos así
    //por si más adelante se añaden otros datos asociados al cupón. 

    //alert(r);
    id_('observaciones_oferta').value = r.replace(/^\s*|\s*$/g,"");
    
    var cbclose = $.colorbox.close;
    $.colorbox.close = function (){envia_formulario_observaciones_cupon_oferta(id_('id_oferta_fo').value,id_('ncupon_fo').value,id_('observaciones_oferta').value,creadas);}
     }  


////Esta función abre una ventana donde podremos introducir el correo al que queremos enviar el mail de confirmación de un cupón.
function mail_cupon_oferta(id_oferta,cupon,creadas)
  {

    var aleatorio='&gg'+(Math.floor(Math.random()*50000))+'=1'; 
    dades='id_oferta='+id_oferta;
    dades+='&cupon='+cupon;
    dades+='&creadas='+creadas;
    id_('creadas_fec').value=creadas;
    id_('lista_cupones_ofertas').style.display='block';
    id_('frm_email_cupones_oferta').reset();
    id_('id_oferta_fec').value = id_oferta;
    id_('ncupon_fec').value = cupon;
    $.colorbox({width:"42%", inline:true, href:"#form_email_cupones_oferta",open:true}); 

    r=ajax.load('<?php echo $base_scripts ?>ajax_email_cupones_oferta.php?'+dades+aleatorio);
  
     } 


function envia_formulario_email_cupon_oferta(id_oferta,ncupon,email,creadas)
  {
      
    var aleatorio='&gg'+(Math.floor(Math.random()*50000))+'=1'

    var dades = 'email='+email; 
    dades+= '&id_oferta='+id_oferta;
    dades+= '&cupon='+ncupon;
    dades+= '&creadas='+creadas;
    //alert (dades);
    r=ajax.load('<?php echo $base_scripts ?>ajax_email_cupones_oferta.php?'+dades+aleatorio);

    if (r.indexOf('Invalid address')!=-1 || r.indexOf('Could not instantiate mail function')!=-1) alert('Se ha producido un error en el envío. Vuelva a inentarlo más tarde.');
    else alert('Su confirmación ha sido enviada');
    //alert(r);
    //$.colorbox.close();  
    $.colorbox({width:"80%", inline:true, href:"#lista_cupones_ofertas",open:true}); 
//alert(dades);
    r=ajax.load('<?php echo $base_scripts ?>cupones_oferta.php?'+dades+aleatorio);  
    $.colorbox.close = cbclose; //recuperamos el código de la función colorbox.close (var. global)
    id_('lista_cupones').innerHTML = r;  
 

 
 }



////Esta función valida o desbloquea un cupón.
function validar_cupon_oferta(id_oferta,cupon,usado,creadas)
  {
    
    var aleatorio='&gg'+(Math.floor(Math.random()*50000))+'=1'; 
    
    dades='id_oferta='+id_oferta;
    dades+='&usado='+usado;
    dades+='&cupon='+cupon;
    dades+='&creadas='+creadas;
    id_('lista_cupones_ofertas').style.display='block';
    switch (usado)
    {
    //usado = 0 significa quqe vamos a validar el cupón.
    case 0:
        if (!confirm('Desea validar este cupón?')) return;
        break;
    //si usado = 1 es que queremos desbloquear el cupón.    
    case 1:
         if (!confirm('Desea desbloquear este cupón?')) 
             return;
         else {
            id_('frm_desbloquear_cupon_oferta').reset();
          
            id_('id_oferta_fd').value = id_oferta;
            id_('ncupon_fd').value = cupon;
            id_('creadas_fd').value = creadas;
            $.colorbox({width:"42%", inline:true, href:"#form_desbloquear_cupon_oferta",open:true}); 
            return;          
         }
         break;    
    //si usado = 3 es que queremos cancelar un cupón.     
    case 3:

         if (!confirm('Desea cancelar este cupón?')) 
         {
             return;
         }
         else {
            id_('frm_validar_password').reset();
            id_('archivo_operacion').value= 'ajax_cupones_ofertas.php'
            id_('archivo_retorno').value = 'cupones_ofertas.php';
            id_('div_retorno').value= 'lista_cupones_ofertas';
            id_('ancho_div_retorno').value = 80;
            id_('datos').value = dades;
                    
            $.colorbox({width:"42%", inline:true, href:"#form_validar_password",open:true}); 
            return;          
         }
         break;    
    //si usado = 4 es que queremos eliminar un cupón.     
    case 4:
         if (!confirm('Desea eliminar este cupón?')) 
         {
             return;
         }
         else {
            id_('frm_validar_password').reset();
            id_('archivo_operacion').value= 'ajax_cupones_ofertas.php'
            id_('archivo_retorno').value = 'cupones_ofertas.php';
            id_('div_retorno').value= 'lista_cupones_ofertas';
            id_('ancho_div_retorno').value = 80;
            id_('datos').value = dades;
            
                    
            $.colorbox({width:"42%", inline:true, href:"#form_validar_password",open:true}); 
            return;          
         }
         break;    
        
    }
 
    r=ajax.load('<?php echo $base_scripts ?>ajax_cupones_ofertas.php?'+dades+aleatorio);

    r=ajax.load('<?php echo $base_scripts ?>cupones_ofertas.php?'+dades+aleatorio);  

    id_('lista_cupones_ofertas').innerHTML = r;  
  }  



//Función complementara a validar cupón. Se ejecuta desde el formulario de contraseñas
//cuando tratamos de cancelar un cupón.
function envia_formulario_validar_password (archivo_operacion,archivo_retorno,datos,div_retorno,ancho_div_retorno,password)
  {
    if (password=='') {alert('Debe introducir la contraseña');return;}      
    var aleatorio='&gg'+(Math.floor(Math.random()*50000))+'=1'
    ///alert(dades);
    r=ajax.load('<?php echo $base_scripts ?>ajax_validar_password.php?password='+password+aleatorio);
    //alert(r); 
    if (r.indexOf('error_password')!=-1) {alert('Contraseña incorrecta. Inténtelo de nuevo.'); id_('frm_validar_password').reset();}
    else 
    {
        //$.colorbox.close();  
        //antes width:80%
        //alert('llamada operacion: '+'<?php echo $base_scripts ?>'+archivo_operacion+'?'+datos+aleatorio);
        
        r=ajax.load('<?php echo $base_scripts ?>'+archivo_operacion+'?'+datos+aleatorio);
        //si hemos eliminado el cupón, lo quitaremos de la lista de parámetros para la llamada a la carga del grid de cupones,
        //ya que en caso de recibir un número de cupón lo utiliza para comprobaciones que una vez eliminado ya no tienen sentido.
        //alert(datos);        
        if (r.indexOf('OK')==-1) {alert(r);}
        else 
            { 
          //  alert(' colorbox ret '+{width:ancho_div_retorno+"%", inline:true, href:"#"+div_retorno,open:true});
            $.colorbox({width:ancho_div_retorno+"%", inline:true, href:"#"+div_retorno,open:true}); 
            r=ajax.load('<?php echo $base_scripts ?>'+archivo_retorno+'?'+datos+aleatorio);  
            if (r.indexOf('error')!=-1)
            {
                if (archivo_retorno=='cupones_ofertas.php')
                 r = " <div style='font-weight:bold;color:red;font-size:18px;'>No existen cupones para esta oferta</div>";    
                
            }
            id_(div_retorno).innerHTML = r;  
            }
    }
    

 }

//Función complementaria a validar cupón. Se ejecuta desde el formulario de contraseñas
//cuando tratamos de desbloquear un cheque.
function envia_formulario_desbloquear_cupon_oferta(id_oferta,ncupon,password,creadas)
  {
    if (password=='') {alert('Debe introducir la contraseña');return;}      
    var aleatorio='&gg'+(Math.floor(Math.random()*50000))+'=1'

    var dades = 'password='+id_('password').value; //el código alfa será único.
    dades+= '&id_oferta='+id_oferta;
    dades+= '&cupon='+ncupon;
    dades+= '&vendido=1';
    dades+= '&usado=1';
    dades+= '&creadas='+creadas;    
  
    r=ajax.load('<?php echo $base_scripts ?>ajax_cupones_ofertas.php?'+dades+aleatorio);

    if (r.indexOf('error_password')!=-1) {alert('Contraseña incorrecta. Inténtelo de nuevo.'); id_('frm_desbloquear_cupon_oferta').reset();}
    else 
    {
    //$.colorbox.close();  
    $.colorbox({width:"80%", inline:true, href:"#lista_cupones_ofertas",open:true}); 
    }
   
    //alert(dades);
    r=ajax.load('<?php echo $base_scripts ?>cupones_ofertas.php?'+dades+aleatorio);  

    id_('lista_cupones_ofertas').innerHTML = r;  
 }
  


//Función complementaria a observaciones_cupon. Se ejecuta desde el formulario de observaciones    
//cuando tratamos de modificar su texto.
//Función encargada de actualizar el texto de una observación.
function envia_formulario_observaciones_cupon_oferta(id_oferta,ncupon,observaciones,creadas)
  {
    var aleatorio='&gg'+(Math.floor(Math.random()*50000))+'=1'

    var dades = 'observaciones='+id_('observaciones_oferta').value; 
    dades+= '&id_oferta='+id_oferta;
    dades+= '&cupon='+ncupon;
    dades+= '&creadas='+creadas;
    //alert (dades); 
    
    //Si el número de cupón es 0 siginfica que las observaciones corresponden al talonario.
    if (ncupon==0)
        r=ajax.load('<?php echo $base_scripts ?>ajax_ofertas.php?'+dades+aleatorio);
    else
        r=ajax.load('<?php echo $base_scripts ?>ajax_cupones_ofertas.php?'+dades+aleatorio);
    //$.colorbox.close();  
    $.colorbox({width:"80%", inline:true, href:"#lista_cupones_ofertas",open:true}); 
  
    r=ajax.load('<?php echo $base_scripts ?>cupones_ofertas.php?'+dades+aleatorio);  

    $.colorbox.close = cbclose; //recuperamos el código de la función colorbox.close (var. global)
    id_('lista_cupones_ofertas').innerHTML = r;  
 }



////Esta función abre el formulario de búsqueda de cupones.
function buscar_cheque_oferta(id_oferta)
  {
  var ale='&gg'+(Math.floor(Math.random()*50000))+'=1';
  id_('msg_error').innerHTML='';
  id_('frm_busqueda_oferta').reset();
  id_('id_oferta').value=id_oferta;

  //$.colorbox({width:"42%", inline:true, href:"#form_busqueda",open:true});
    
} 


function envia_formulario_usuario()
  {
    var ale='&gg'+(Math.floor(Math.random()*50000))+'=1'
    var dades=obtenirDadesForm('form_alta_usuario');
    dades = dades+'&sexoh='+ (id_('sexoh').checked?'1':'0');
    if (id_('nombre').value=''){alert('Debe introducir el nombre del usuario');return;}
    if (id_('apellidos').value=''){alert('Debe introducir los apellidos del usuario');return;}
    if (id_('email').value=''){alert('Debe introducir el email del usuario');return;}
    r=ajax.load('<?php echo $base_scripts ?>ajax_usuarios.php?modifica_usuario=1&'+dades+ale);
   alert(r);
    var ok=/OK/;
    if (ok.test(r)) { // recarrega graella
     //alert(r)
     //id_('msg_error').innerHTML='Recepción correcta';
      //get_lista_establecimientos();
      //id_('alta_usuario').style.display="none";
      //vista('establecimientos');
     }
    else {  
     id_('msg_error').innerHTML=r;
     //get_lista_establecimientos();
     //vista('establecimientos');    
    }

     
  }
  


 //Función para editar los datos del establecimiento.
  
  function edita_usuario(id_usuario,id_oferta) 
  { 
  var ale='&gg'+(Math.floor(Math.random()*50000))+'=1';  
  mostrar_form_usuarios_oferta();
  if (id_oferta != 0) 
    id_('lista_cupones_ofertas').style.display='block';
  id_('msg_error').innerHTML='';
  id_('form_alta_usuario').reset();

  $.colorbox({width:"42%", inline:true, href:"#form_usu",open:true});
  id_('alta_usuario_oferta').style.display='block';
  //alert('akir');
  id_('edicio_usu').value='edicio';
  id_('titulo_formulario').innerHTML = 'Editar';
  id_('id_usuario').value=id_usuario;
  r=ajax.load('<?php echo $base_scripts ?>ajax_usuarios.php?id_usuario='+id_usuario+'&id_edita_usuario=1'+ale); 

  ru=r.toUpperCase();
  
  if (ru.indexOf('ERROR')==-1) eval(r);
  else alert('Error al realizar la consulta');

  var cbclose = $.colorbox.close;
  $.colorbox.close =   function (){
      $.colorbox.close=cbclose;
      if (id_oferta != 0)
      {
      ocultar_form_usuarios_oferta();
      abrir_lista_cupones_oferta(id_oferta);
      }
   }

  return;          
  
  
  }


function abrir_lista_cupones_oferta(id_oferta)
{
  var ale='&gg'+(Math.floor(Math.random()*50000))+'=1';
  $.colorbox({width:"80%", inline:true, href:"#lista_cupones_ofertas",open:true}); 
  dades= 'id_oferta='+id_oferta;
  r=ajax.load('<?php echo $base_scripts ?>cupones_ofertas.php?'+dades+ale);  
  $.colorbox.close = cbclose;    
  id_('lista_cupones').innerHTML = r;  
  

}

</script>

<?php   
        echo '
        <script type="text/javascript" src="'.__PS_BASE_URI__.'js/tinymce/jscripts/tiny_mce/jquery.tinymce.js"></script>

        <script type="text/javascript">
        function tinyMCEInit(element)
        {
            $().ready(function() {
                $(element).tinymce({
                    // Location of TinyMCE script
                    script_url : \''.__PS_BASE_URI__.'js/tinymce/jscripts/tiny_mce/tiny_mce.js\',
                    // General options
                    theme : "advanced",
                    plugins : "safari,pagebreak,style,layer,table,advimage,advlink,inlinepopups,media,searchreplace,contextmenu,paste,directionality,fullscreen",
                    // Theme options
                    theme_advanced_buttons1 : "newdocument,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,styleselect,formatselect,fontselect,fontsizeselect",
                    theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,,|,forecolor,backcolor",
                    theme_advanced_buttons3 : "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,media,|,ltr,rtl,|,fullscreen",
                    theme_advanced_buttons4 : "insertlayer,moveforward,movebackward,absolute,|,styleprops,|,cite,abbr,acronym,del,ins,attribs,|,pagebreak",
                    theme_advanced_toolbar_location : "top",
                    theme_advanced_toolbar_align : "left",
                    theme_advanced_statusbar_location : "bottom",
                    theme_advanced_resizing : false,
                    content_css : "'.__PS_BASE_URI__.'themes/'._THEME_NAME_.'/css/global.css",
                    document_base_url : "'.__PS_BASE_URI__.'",
                    width: "582",
                    height: "auto",
                    font_size_style_values : "8pt, 10pt, 12pt, 14pt, 18pt, 24pt, 36pt",
                    // Drop lists for link/image/media/template dialogs
                    template_external_list_url : "lists/template_list.js",
                    external_link_list_url : "lists/link_list.js",
                    external_image_list_url : "lists/image_list.js",
                    media_external_list_url : "lists/media_list.js",
                    elements : "nourlconvert",
                    convert_urls : false,
                    language : "'.(file_exists(_PS_ROOT_DIR_.'/js/tinymce/jscripts/tiny_mce/langs/'.$iso.'.js') ? $iso : 'en').'"
                });
            });
        }
        tinyMCEInit(\'textarea.rte\');
        </script>
        ';              

?>
 