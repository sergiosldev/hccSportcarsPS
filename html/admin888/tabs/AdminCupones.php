<?php
class AdminCupones{}  
include dirname(__FILE__).'/scripts/config_events_new.php';

?>
 <script type="text/javascript" src="tabs/js/sha.js"></script>
<script>

</script>


     <script type="text/javascript" src="tabs/js/funcs.js"></script>
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


<?php 

include dirname(__FILE__).'/scripts/funciones_ajax_establecimientos.php';
include dirname(__FILE__).'/scripts/funciones_ajax_talonarios.php';


?>
<script>

</script>    

<div id="centrar">
<div>
<fieldset>
    <legend>Opciones Cupón</legend>
    <!--Validar Cupones: <INPUT TYPE="RADIO" NAME="ciudad_c" VALUE="" checked="checked" onclick="vista('cupones')"> -->
<!--    Establecimientos: <INPUT TYPE="RADIO" id="lista" NAME="establecimientos" VALUE="lista" onclick="vista('establecimientos')"> 
    &nbsp;&nbsp;&nbsp;&nbsp;Dar de alta un establecimiento: <INPUT id="editar" TYPE="RADIO" NAME="editar" VALUE="editar" onclick="vista('alta_estab')">
    &nbsp;&nbsp;&nbsp;&nbsp;Validar cupón: <INPUT id="validar_cupon" TYPE="RADIO" NAME="validar_cupon" VALUE="validar_cupon" onclick="vista('validar_cupon')">
    &nbsp;&nbsp;&nbsp;&nbsp;Ficheros: <INPUT id="ficheros" TYPE="RADIO" NAME="ficheros" VALUE="ficheros" onclick="vista('ficheros')">  -->
	<a href="javascript:vista('establecimientos')" class="boton_menu menu_activo" id="lista">Establecimientos</a> 
	<a href="javascript:vista('alta_estab')" class="boton_menu" id="editar" style="width:206px;" >Dar de alta un establecimiento</a> 
	<a href="javascript:vista('validar_cupon')" class="boton_menu" id="validar_cupon">Validar cupón</a> 
	<a href="javascript:vista('ficheros')" class="boton_menu" style="visibility:hidden;" id="ficheros" >Ficheros</a> 

</fieldset>
</div>
</div>




<div id="lista_establecimientos" ></div>
<?php include dirname(__FILE__).'/scripts/formulario_establecimiento.php'; 
?>
<br>
<div id="lista_talonarios"></div>

<div id="listado" style="display:none;float:left;width:100%;"  >
    <div id='lista_cupones' style='text-align:left;padding:10px; background:#fff;'>
    </div>
</div>
<?php 

include dirname(__FILE__).'/scripts/formulario_busqueda_cupon.php'; 
include dirname(__FILE__).'/scripts/formulario_fichero_cupones.php';  
include dirname(__FILE__).'/scripts/formulario_borrar_talonario.php';   
include dirname(__FILE__).'/scripts/formulario_borrar_establecimiento.php';   
include dirname(__FILE__).'/scripts/formulario_desbloquear_cupon.php';   
include dirname(__FILE__).'/scripts/formulario_observaciones_cupon.php';    
include dirname(__FILE__).'/scripts/formulario_cupon_disponible.php';
include dirname(__FILE__).'/scripts/formulario_cancelar_cupon.php';    
include dirname(__FILE__).'/scripts/formulario_email_cupones.php';   
include dirname(__FILE__).'/scripts/formulario_desfacturar_cupon.php';   


?>


<script>
var cbclose = $.colorbox.close;
//Por defecto mostramos la lista de establecimientos y marcamos por tanto la primera opción del radiobutton.
id_('lista').checked=true;
vista('establecimientos');
function vista(nombre)
{

    switch (nombre)
    {
                   

        /*case 'cupones':
            ocultar_lista_estab();
            ocultar_form_estab();
        break;*/
        case 'establecimientos':
            get_lista_establecimientos();
            mostrar_lista_estab();
            ocultar_lista_talonarios();
            ocultar_form_estab();
            ocultar_form_busqueda_cupon();
            ocultar_form_fichero_cupones();
            /*id_('lista').checked=true;
            id_('editar').checked=false;
            id_('validar_cupon').checked=false;
            id_('ficheros').checked=false;
            id_('edicio_estab').value = '';
			*/
			id_('lista').className='boton_menu menu_activo';
            id_('editar').className='boton_menu';
            id_('validar_cupon').className='boton_menu';
            id_('ficheros').className='boton_menu';
            id_('edicio_estab').value = '';
			
		break;
        case 'alta_estab':
            ocultar_lista_estab();
            ocultar_lista_talonarios();
            ocultar_form_busqueda_cupon();
            document.getElementById('form_alta_estab').reset()
            mostrar_form_estab();
            ocultar_form_fichero_cupones();
/*            id_('lista').checked=false;
            id_('validar_cupon').checked=false;
            id_('ficheros').checked=false;            
            id_('editar').checked=true;
*/
			id_('lista').className='boton_menu';
            id_('editar').className='boton_menu menu_activo';
            id_('validar_cupon').className='boton_menu';
            id_('ficheros').className='boton_menu';
			
            alta();
        break;
        case 'validar_cupon':
/*            id_('validar_cupon').checked=true;
            id_('lista').checked=false;
            id_('editar').checked=false;     
            id_('ficheros').checked=false;            
			*/
			id_('lista').className='boton_menu';
            id_('editar').className='boton_menu';
            id_('validar_cupon').className='boton_menu menu_activo';
            id_('ficheros').className='boton_menu';

			
			
            ocultar_lista_estab();
            ocultar_form_fichero_cupones();
            ocultar_lista_talonarios();  
            ocultar_form_estab();
            mostrar_form_busqueda_cupon();
            break;                             
        case 'ficheros':
/*            id_('validar_cupon').checked=false;
            id_('lista').checked=false;
            id_('editar').checked=false;  
            id_('ficheros').checked=true;          */
			id_('lista').className='boton_menu';
            id_('editar').className='boton_menu';
            id_('validar_cupon').className='boton_menu';
            id_('ficheros').className='boton_menu menu_activo';
			
            ocultar_lista_estab();
            mostrar_form_fichero_cupones();
            ocultar_lista_talonarios();  
            ocultar_form_estab();
            ocultar_form_busqueda_cupon();
            break;                             

        default:
            ocultar_form_estab();
            ocultar_form_fichero_cupones();
            ocultar_form_busqueda_cupon();
            id_('edicio_estab').value = '';
        break;        
    }
}

//Esta función se encarga de listar todos los establecimientos.
function get_lista_establecimientos()
   {

    var aleatorio='&gg'+(Math.floor(Math.random()*50000))+'=1'

    var r=ajax.load('<?php echo $base_scripts ?>establecimientos.php?x=1'+aleatorio);  

    id_('lista_establecimientos').innerHTML = r;            
   }   
  

//Esta función se encarga de listar los talonarios asociados a un establecimiento.
function get_lista_talonarios(id)
{
    

    var aleatorio='&gg'+(Math.floor(Math.random()*50000))+'=1'

    var r=ajax.load('<?php echo $base_scripts ?>talonarios.php?id_establecimiento='+id+'&alta=0'+aleatorio);  
    
    mostrar_lista_talonarios();
    id_('lista_talonarios').innerHTML = r;     
}

function alta_talonario(id)
{
    var aleatorio='&gg'+(Math.floor(Math.random()*50000))+'=1'

    var r=ajax.load('<?php echo $base_scripts ?>talonarios.php?id_establecimiento='+id+'&alta=1'+aleatorio);  

    mostrar_lista_talonarios();
    id_('lista_talonarios').innerHTML = r;     
    
}

////Esta función se encarga de listar los cupones asociados a un talonario.
function cupones_usados(id_establecimiento,id_talonario,numero_talonario)
  {
    var aleatorio='&gg'+(Math.floor(Math.random()*50000))+'=1'; 
    dades='id_establecimiento='+id_establecimiento;
    dades+='&id_talonario='+id_talonario;
    dades+='&numero_talonario='+numero_talonario;
    
    r=ajax.load('<?php echo $base_scripts ?>cupones.php?'+dades+aleatorio);    
    //eval(r);
    id_('lista_cupones').innerHTML = r;  
    $.colorbox({width:"80%", inline:true, href:"#lista_cupones",open:true}); 

    
  }  


////Esta función abre una ventana donde podremos introducir unas observaciones.
function observaciones_cupon(id_establecimiento,numero_talonario,id_talonario,numero,observaciones)
  {
    var aleatorio='&gg'+(Math.floor(Math.random()*50000))+'=1'; 
    dades='id_establecimiento='+id_establecimiento;
    dades+='&id_talonario='+id_talonario;
    dades+='&numero_talonario='+numero_talonario;
    dades+='&numero_cupon='+numero;
    dades+='&observaciones='+observaciones;
    id_('lista_cupones').style.display='block';
    id_('frm_observaciones_cupon').reset();
    id_('id_establecimiento_fo').value = id_establecimiento;
    id_('id_talonario_fo').value = id_talonario;
    id_('num_talonario_fo').value = numero_talonario;
    id_('ncupon_fo').value = numero;
    $.colorbox({width:"42%", inline:true, href:"#form_observaciones_cupon",open:true}); 
    r=ajax.load('<?php echo $base_scripts ?>ajax_observaciones.php?'+dades+aleatorio);
 
 
    //esta llamada ajax en principio no sería necesaria ya  que desde la lista de cupones 
    //ya se pasan como parámetro las observaciones. Sinembargo lo dejamos así
    //por si más adelante se añaden otros datos asociados al cupón.
    id_('observaciones').value = r.replace(/^\s*|\s*$/g,"");
    var cbclose = $.colorbox.close;
//alert(5);
    $.colorbox.close = function (){envia_formulario_observaciones_cupon(id_('id_establecimiento_fo').value,id_('id_talonario_fo').value,id_('num_talonario_fo').value,id_('ncupon_fo').value,id_('observaciones').value);}
//alert(6);
  <?php /*
    r=ajax.load('<?php echo $base_scripts ?>ajax_cupones.php?'+dades+aleatorio);.
  
    dades+='&numero_talonario='+numero_talonario;
    r=ajax. load('<?php echo $base_scripts ?>cupones.php?'+dades+aleatorio);  

    //eval(r);
    id_('lista_cupones').innerHTML = r;  
  
    //id_('lista_cupones').style.display='none';

 */ ?>  
     }  


////Esta función abre una ventana donde podremos introducir el correo al que queremos enviar el mail de confirmación de un cupón.
function mail_cupon(id_establecimiento,numero_talonario,id_talonario,numero)
  {

    var aleatorio='&gg'+(Math.floor(Math.random()*50000))+'=1'; 
    dades='id_establecimiento='+id_establecimiento;
    dades+='&id_talonario='+id_talonario;
    dades+='&numero_talonario='+numero_talonario;
    dades+='&numero_cupon='+numero;
    id_('lista_cupones').style.display='block';
    id_('frm_email_cupones').reset();
    id_('id_establecimiento_fec').value = id_establecimiento;
    id_('id_talonario_fec').value = id_talonario;
    id_('num_talonario_fec').value = numero_talonario;
    id_('ncupon_fec').value = numero;
    $.colorbox({width:"42%", inline:true, href:"#form_email_cupones",open:true}); 


    var cbclose = $.colorbox.close;
    $.colorbox.close = function (){abrir_lista_cupones(id_establecimiento,id_talonario,numero_talonario);}  
    return;          


<?php /*    r=ajax.load('<?php echo $base_scripts ?>ajax_email_cupones.php?'+dades+aleatorio); */ ?>
//    var cbclose = $.colorbox.close;
//    $.colorbox.close = function (){envia_formulario_email_cupon(id_('id_establecimiento_fec').value,id_('id_talonario_fec').value,id_('num_talonario_fec').value,id_('ncupon_fec').value,'');}

     } 


function envia_formulario_email_cupon(id_establecimiento,id_talonario,numero_talonario,ncupon,email)
  {
    var aleatorio='&gg'+(Math.floor(Math.random()*50000))+'=1'

    var dades = 'email='+email; 
    dades+= '&id_establecimiento='+id_establecimiento;
    dades+= '&id_talonario='+id_talonario;
    dades+= '&numero_talonario='+numero_talonario;
    dades+= '&numero_cupon='+ncupon;
    //alert (dades);
    r=ajax.load('<?php echo $base_scripts ?>ajax_email_cupones.php?'+dades+aleatorio);
   // alert(r);
    if (email!='' && (r.indexOf('Invalid address')!=-1 || r.indexOf('Could not instantiate mail function')!=-1)) alert('Se ha producido un error en el envío. Vuelva a inentarlo más tarde.');
    else if (email!='') alert('Su confirmación ha sido enviada');
    //alert(r);
    //$.colorbox.close();  
    $.colorbox({width:"80%", inline:true, href:"#lista_cupones",open:true}); 

    dades+='&numero_talonario='+numero_talonario;
    //alert(dades);
    r=ajax.load('<?php echo $base_scripts ?>cupones.php?'+dades+aleatorio);  
    $.colorbox.close = cbclose; //recuperamos el código de la función colorbox.close (var. global)
    id_('lista_cupones').innerHTML = r;  
 }


  //Función para editar los datos del establecimiento.
  
  function edita_establecimiento(id,id_talonario,num_talonario) 
  { 
  var ale='&gg'+(Math.floor(Math.random()*50000))+'=1';           
  id_('lista_cupones').style.display='block';
  id_('msg_error').innerHTML='';
  id_('form_alta_estab').reset();
  id_('botones_establecimiento').style.visibility='hidden';

  id_('nombre').disabled=true;
  id_('direccion').disabled=true;
  id_('email').disabled=true;
  id_('telefono').disabled=true;
  id_('nif').disabled=true;
  id_('usuario').disabled=true;
  id_('password').disabled=true;
  id_('poblacion').disabled=true;
  id_('cpostal').disabled=true;
  id_('provincia').disabled=true;
  $.colorbox({width:"42%", inline:true, href:"#form_est",open:true});
  id_('alta').style.display='block';
  //alert('akir');
  id_('edicio_estab').value='edicio';
  id_('titulo_formulario').innerHTML = 'Consulta';
  id_('id_establecimiento').value=id;
  r=ajax.load('<?php echo $base_scripts ?>ajax.php?id_edita_estab='+id+ale); 
  ocultar_form_estab();
  eval(r);
  

  var cbclose = $.colorbox.close;
  $.colorbox.close =   function (){
      id_('botones_establecimiento').style.visibility='visible';      
      id_('nombre').disabled=false;
      id_('direccion').disabled=false;
      id_('email').disabled=false;
      id_('telefono').disabled=false;
      id_('nif').disabled=false;
      id_('usuario').disabled=false;
      id_('password').disabled=false;
      id_('poblacion').disabled=false;
      id_('cpostal').disabled=false;
      id_('provincia').disabled=false;
      abrir_lista_cupones(id,id_talonario,num_talonario);
      }
  
    return;          
  
  
  }

function abrir_lista_cupones(id,id_talonario,num_talonario)
{
  var ale='&gg'+(Math.floor(Math.random()*50000))+'=1';
  $.colorbox({width:"80%", inline:true, href:"#lista_cupones",open:true}); 
  dades= '&id_establecimiento='+id;
  dades+= '&id_talonario='+id_talonario;
  dades+= '&numero_talonario='+num_talonario; 
  r=ajax.load('<?php echo $base_scripts ?>cupones.php?'+dades+ale);  
  $.colorbox.close = cbclose;    
  id_('lista_cupones').innerHTML = r;  
  

}

////Esta función valida o desbloquea un cupón, además de realizar otras funciones según el valor del parámetro usado.
function validar_cupon(id_establecimiento,numero_talonario,id_talonario,numero,usado)
  {
    var aleatorio='&gg'+(Math.floor(Math.random()*50000))+'=1'; 
    dades='id_establecimiento='+id_establecimiento;
    dades+='&id_talonario='+id_talonario;
    dades+='&numero_cupon='+numero;
    dades+='&usado='+usado;
    id_('lista_cupones').style.display='block';

    switch(usado)
    {
        //usado = 0 indica que el cupón va a ser validado.
        case 0:
            if (!confirm('Desea validar este cupón?')) return;
            else
            {
                r=ajax.load('<?php echo $base_scripts ?>ajax_cupones.php?'+dades+aleatorio);
                dades+='&numero_talonario='+numero_talonario;
                r=ajax.load('<?php echo $base_scripts ?>cupones.php?'+dades+aleatorio);  
                id_('lista_cupones').innerHTML = r;  
            }
            break;
        //usado = 1 indica que el cupón va a ser desbloqueado.
        case 1: 
             if (!confirm('Desea desbloquear este cupón?')) 
                 return;
             else {
                id_('frm_desbloquear_cupon').reset();
                id_('id_establecimiento_fd').value = id_establecimiento;
                id_('id_talonario_fd').value = id_talonario;
                id_('num_talonario_fd').value = numero_talonario;
                id_('ncupon_fd').value = numero;
                $.colorbox({width:"42%", inline:true, href:"#form_desbloquear_cupon",open:true}); 
                //var cbclose = $.colorbox.close;
                //$.colorbox.close = function (){abrir_lista_cupones(id_establecimiento,id_talonario,numero_talonario);}  
                return;          
             }
            break;
        case 2:
            //usado=2 equivaldrá a estado vendido únicamente para esta función.
             if (!confirm('Está seguro de que desea cambiar el estado del cupón a disponible?')) 
                 return;
             else {
                dades+='&vendido=1'; 
                id_('frm_disponible_cupon').reset();
                id_('id_establecimiento_dc').value = id_establecimiento;
                id_('id_talonario_dc').value = id_talonario;
                id_('num_talonario_dc').value = numero_talonario;
                id_('ncupon_dc').value = numero;
                $.colorbox({width:"42%", inline:true, href:"#form_disponible_cupon",open:true}); 
                //var cbclose = $.colorbox.close;
                //$.colorbox.close = function (){abrir_lista_cupones(id_establecimiento,id_talonario,numero_talonario);}  
                return;          
             }
            break;
        
        case 3:
            //el estado usado=3 corresponde a un cupón cancelado.     
             if (!confirm('Está seguro de que desea cancelar este cupón?')) 
                 return;
             else {
                id_('frm_cancelar_cupon').reset();
                id_('id_establecimiento_cc').value = id_establecimiento;
                id_('id_talonario_cc').value = id_talonario;
                id_('num_talonario_cc').value = numero_talonario;
                id_('ncupon_cc').value = numero;
                $.colorbox({width:"42%", inline:true, href:"#form_cancelar_cupon",open:true}); 
                //var cbclose = $.colorbox.close;
                //$.colorbox.close = function (){abrir_lista_cupones(id_establecimiento,id_talonario,numero_talonario);}  
                return;          
             }
            break;
        //el estado usado=4 indica que hemos marcado el cupón como facturado.
        case 4:             
                 if (!confirm('Está seguro de que desea marcar  este cupón como facturado?')) 
                     return;
                 else 
                 {
                    r=ajax.load('<?php echo $base_scripts ?>ajax_cupones.php?'+dades+aleatorio);
                    //alert(r);
                    dades+='&numero_talonario='+numero_talonario;
                    r=ajax.load('<?php echo $base_scripts ?>cupones.php?'+dades+aleatorio);  
                    id_('lista_cupones').innerHTML = r;  
                 }
                break;
    
        //el estado usado=5 indica que hemos desmarcado un cupón facturado.
        case 5:
                 if (!confirm('Está seguro de que desea que este cupón deje de figurar como facturado?')) 
                     return;
                 else {
                    id_('frm_desfacturar_cupon').reset();
                    id_('id_establecimiento_desc').value = id_establecimiento;
                    id_('id_talonario_desc').value = id_talonario;
                    id_('num_talonario_desc').value = numero_talonario;
                    id_('ncupon_desc').value = numero;
                    id_('tipod').value = 'facturado';
                    $.colorbox({width:"42%", inline:true, href:"#form_desfacturar_cupon",open:true}); 
                    //var cbclose = $.colorbox.close;
                   // $.colorbox.close = function (){abrir_lista_cupones(id_establecimiento,id_talonario,numero_talonario);}  
                    return;          
                 }
                break;
        //el estado usado=6 indica que hemos marcado el cupón como cobrado.
        case 6:             
                 if (!confirm('Está seguro de que desea marcar  este cupón como cobrado?')) 
                     return;
                 else 
                 {
                    r=ajax.load('<?php echo $base_scripts ?>ajax_cupones.php?'+dades+aleatorio);
                    //alert(r);
                    dades+='&numero_talonario='+numero_talonario;
                    r=ajax.load('<?php echo $base_scripts ?>cupones.php?'+dades+aleatorio);  
                    id_('lista_cupones').innerHTML = r;  
                 }
                break;
    
        //el estado usado=7 indica que hemos desmarcado un cupón cobrado.
        case 7:
                 if (!confirm('Está seguro de que desea que este cupón deje de figurar como cobrado?')) 
                     return;
                 else {
                    id_('frm_desfacturar_cupon').reset();
                    id_('id_establecimiento_desc').value = id_establecimiento;
                    id_('id_talonario_desc').value = id_talonario;
                    id_('num_talonario_desc').value = numero_talonario;
                    id_('ncupon_desc').value = numero;
                    id_('texto_desfacturar').innerHTML='Marcar cupón como no cobrado';
                    id_('tipod').value = 'cobrado';
                    $.colorbox({width:"42%", inline:true, href:"#form_desfacturar_cupon",open:true}); 
                    //var cbclose = $.colorbox.close;
                   // $.colorbox.close = function (){abrir_lista_cupones(id_establecimiento,id_talonario,numero_talonario);}  
                    return;          
                 }
                break;
        //el estado usado=8 indica que hemos marcado el cupón como comercial.
        case 8:             
                 if (!confirm('Está seguro de que desea marcar  este cupón como comercial?')) 
                     return;
                 else 
                 {
                    r=ajax.load('<?php echo $base_scripts ?>ajax_cupones.php?'+dades+aleatorio);
                    //alert(r);
                    dades+='&numero_talonario='+numero_talonario;
                    r=ajax.load('<?php echo $base_scripts ?>cupones.php?'+dades+aleatorio);  
                    id_('lista_cupones').innerHTML = r;  
                 }
                break;
    
        //el estado usado=9 indica que hemos desmarcado un cupón comercial.
        case 9:
                 if (!confirm('Está seguro de que desea que este cupón deje de figurar como comercial?')) 
                     return;
                 else {
                    id_('frm_desfacturar_cupon').reset();
                    id_('id_establecimiento_desc').value = id_establecimiento;
                    id_('id_talonario_desc').value = id_talonario;
                    id_('num_talonario_desc').value = numero_talonario;
                    id_('ncupon_desc').value = numero;
                    id_('texto_desfacturar').innerHTML='Marcar cupón como no comercial';
                    id_('tipod').value = 'comercial';
                    $.colorbox({width:"42%", inline:true, href:"#form_desfacturar_cupon",open:true}); 
                    //var cbclose = $.colorbox.close;
                   // $.colorbox.close = function (){abrir_lista_cupones(id_establecimiento,id_talonario,numero_talonario);}  
                    return;          
                 }
                break;
        }

  }  



//Función complementara a validar cupón. Se ejecuta desde el formulario de contraseñas
//cuando tratamos de cancelar un cupón.
function envia_formulario_cancelar_cupon (id_establecimiento,id_talonario,numero_talonario,ncupon,password)
  {
    if (password=='') {alert('Debe introducir la contraseña');return;}      
    var aleatorio='&gg'+(Math.floor(Math.random()*50000))+'=1'

    var dades = 'password='+id_('password').value; //el código alfa será único.
    dades+= '&id_establecimiento='+id_establecimiento;
    dades+= '&id_talonario='+id_talonario;
    dades+= '&numero_cupon='+ncupon;
    dades+= '&usado=3'; //utilizamos usado = 3 para indicar que intentamos cancelar un cupón.     
    ///alert(dades);
    r=ajax.load('<?php echo $base_scripts ?>ajax_cupones.php?'+dades+aleatorio);
    //alert(r); 
    if (r.indexOf('error_password')!=-1) {alert('Contraseña incorrecta. Inténtelo de nuevo.'); id_('frm_cancelar_cupon').reset();}
    else 
    {
    //$.colorbox.close();  
    //antes width:58%
    $.colorbox({width:"80%", inline:true, href:"#lista_cupones",open:true}); 
    }
    
    
    dades+='&numero_talonario='+numero_talonario;
    r=ajax.load('<?php echo $base_scripts ?>cupones.php?'+dades+aleatorio);  
    
    id_('lista_cupones').innerHTML = r;  

 }


//Función complementara a validar cupón. Se ejecuta desde el formulario de contraseñas
//cuando tratamos de desmarcar un cupón facturado.
function envia_formulario_desfacturar_cupon (id_establecimiento,id_talonario,numero_talonario,ncupon,password,tipod)
  {
    if (password=='') {alert('Debe introducir la contraseña');return;}      
    var aleatorio='&gg'+(Math.floor(Math.random()*50000))+'=1'

    var dades = 'password='+id_('password').value; //el código alfa será único.
    dades+= '&id_establecimiento='+id_establecimiento;
    dades+= '&id_talonario='+id_talonario;
    dades+= '&numero_cupon='+ncupon;
    switch(tipod)
    {
        case 'facturado':
            dades+= '&usado=5'; //utilizamos usado = 3 para indicar que intentamos cancelar un cupón.     
            break;
        case 'cobrado':
            dades+= '&usado=7'; //utilizamos usado = 3 para indicar que intentamos cancelar un cupón.     
            break;
        case 'comercial':
            dades+= '&usado=9'; //utilizamos usado = 3 para indicar que intentamos cancelar un cupón.     
            break;
    }
    ///alert(dades);
    r=ajax.load('<?php echo $base_scripts ?>ajax_cupones.php?'+dades+aleatorio);
    //alert(r); 
    if (r.indexOf('error_password')!=-1) {alert('Contraseña incorrecta. Inténtelo de nuevo.'); id_('frm_desfacturar_cupon').reset();}
    else 
    {
    //$.colorbox.close();  
    //antes width:58%
    $.colorbox({width:"80%", inline:true, href:"#lista_cupones",open:true}); 
    }
     
    
    dades+='&numero_talonario='+numero_talonario;
    r=ajax.load('<?php echo $base_scripts ?>cupones.php?'+dades+aleatorio);  
    
    id_('lista_cupones').innerHTML = r;  

 }




//Función complementaria a validar cupón. Se ejecuta desde el formulario de contraseñas
//cuando tratamos de cambiar el estado de un cupón a disponible.
function envia_formulario_cambiar_cupon_disponible (id_establecimiento,id_talonario,numero_talonario,ncupon,password)
  {
    if (password=='') {alert('Debe introducir la contraseña');return;}      
    var aleatorio='&gg'+(Math.floor(Math.random()*50000))+'=1'

    var dades = 'password='+id_('password').value; //el código alfa será único.
    dades+= '&id_establecimiento='+id_establecimiento;
    dades+= '&id_talonario='+id_talonario;
    dades+= '&numero_cupon='+ncupon;
    dades+= '&vendido=1';
    dades+= '&usado=2'; //utilizamos usado = 2 para indicar que intentamos cambiar a disponible un cupón vendido.     
  //alert(dades);
    r=ajax.load('<?php echo $base_scripts ?>ajax_cupones.php?'+dades+aleatorio);
    //alert(r); 
    if (r.indexOf('error_password')!=-1) {alert('Contraseña incorrecta. Inténtelo de nuevo.'); id_('frm_disponible_cupon').reset();}
    else 
    {
    //$.colorbox.close();  
    $.colorbox({width:"80%", inline:true, href:"#lista_cupones",open:true}); 
    }

    dades+='&numero_talonario='+numero_talonario;
    //alert(dades);
    r=ajax.load('<?php echo $base_scripts ?>cupones.php?'+dades+aleatorio);  
    $.colorbox.close = cbclose; //recuperamos el código de la función colorbox.close (var. global)

    id_('lista_cupones').innerHTML = r;  
 }




//Función complementaria a validar cupón. Se ejecuta desde el formulario de contraseñas
//cuando tratamos de desbloquear un cheque.
//Función encargada de borrar el establecimiento
function envia_formulario_desbloquear_cupon(id_establecimiento,id_talonario,numero_talonario,ncupon,password)
  {
    if (password=='') {alert('Debe introducir la contraseña');return;}      
    var aleatorio='&gg'+(Math.floor(Math.random()*50000))+'=1'

    var dades = 'password='+id_('password').value; //el código alfa será único.
    dades+= '&id_establecimiento='+id_establecimiento;
    dades+= '&id_talonario='+id_talonario;
    dades+= '&numero_cupon='+ncupon;
    dades+= '&vendido=1';
    dades+= '&usado=1';    
  
    r=ajax.load('<?php echo $base_scripts ?>ajax_cupones.php?'+dades+aleatorio);
    if (r.indexOf('error_password')!=-1) {alert('Contraseña incorrecta. Inténtelo de nuevo.'); id_('frm_desbloquear_cupon').reset();}
    else 
    {
    //$.colorbox.close();  
    $.colorbox({width:"80%", inline:true, href:"#lista_cupones",open:true}); 
    }

    dades+='&numero_talonario='+numero_talonario;
    //alert(dades);
    r=ajax.load('<?php echo $base_scripts ?>cupones.php?'+dades+aleatorio);  
    $.colorbox.close = cbclose; //recuperamos el código de la función colorbox.close (var. global)

    id_('lista_cupones').innerHTML = r;  
 }
  


//Función complementaria a observaciones_cupon. Se ejecuta desde el formulario de observaciones    
//cuando tratamos de modificar su texto.
//Función encargada de actualizar el texto de una observación.
function envia_formulario_observaciones_cupon(id_establecimiento,id_talonario,numero_talonario,ncupon,observaciones)
  {
    var aleatorio='&gg'+(Math.floor(Math.random()*50000))+'=1'

    var dades = 'observaciones='+id_('observaciones').value; 
    dades+= '&id_establecimiento='+id_establecimiento;
    dades+= '&id_talonario='+id_talonario;
    dades+= '&numero_cupon='+ncupon;
    dades+= '&operacion=update_observaciones';
    //alert (dades);
    
    //Si el número de cupón es 0 siginfica que las observaciones corresponden al talonario.
    if (ncupon==0)
        r=ajax.load('<?php echo $base_scripts ?>ajax_talonario.php?'+dades+aleatorio);
    else
        r=ajax.load('<?php echo $base_scripts ?>ajax_cupones.php?'+dades+aleatorio);
    


    abrir_lista_cupones(id_establecimiento,id_talonario,numero_talonario);

 }



////Esta función abre el formulario de búsqueda de cupones.
function buscar_cheque(id_establecimiento)
  {
  var ale='&gg'+(Math.floor(Math.random()*50000))+'=1';
  id_('msg_error').innerHTML='';
  id_('frm_busqueda').reset();
  id_('id_establecimien').value=id_establecimiento;

  //$.colorbox({width:"42%", inline:true, href:"#form_busqueda",open:true});
    
} 

</script>
 