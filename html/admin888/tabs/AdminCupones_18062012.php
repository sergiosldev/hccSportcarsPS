<?php
class AdminCupones{}  
include dirname(__FILE__).'/scripts/config_events.php';

?>
 <script type="text/javascript" src="tabs/js/sha.js"></script>
<script>
/*
    var pass=0;
    var index_sha=0;
    do{
    pass = prompt("Introduce password", "")
    if(++index_sha==4)window.location='http://lon.motorclubexperience.com/admin888/'    
    }while(SHA1(pass)!='c90d2c47658527c7269e392e5667d767d36be1af')
        
    
*/
</script>


     <script type="text/javascript" src="tabs/js/funcs.js"></script>
     <script type="text/javascript" src="tabs/js/ajax_load.js"></script>
     <link rel="stylesheet" type="text/css" href="tabs/css/style.css">
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
    Establecimientos: <INPUT TYPE="RADIO" id="lista" NAME="establecimientos" VALUE="lista" onclick="vista('establecimientos')"> 
    &nbsp;&nbsp;&nbsp;&nbsp;Dar de alta un establecimiento: <INPUT id="editar" TYPE="RADIO" NAME="editar" VALUE="editar" onclick="vista('alta_estab')">
    &nbsp;&nbsp;&nbsp;&nbsp;Validar cupón: <INPUT id="validar_cupon" TYPE="RADIO" NAME="validar_cupon" VALUE="validar_cupon" onclick="vista('validar_cupon')">

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
include dirname(__FILE__).'/scripts/formulario_borrar_talonario.php'; 
include dirname(__FILE__).'/scripts/formulario_borrar_establecimiento.php'; 
include dirname(__FILE__).'/scripts/formulario_desbloquear_cupon.php'; 

?>


<script>

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
            id_('lista').checked=true;
            id_('editar').checked=false;
            id_('validar_cupon').checked=false;
            id_('edicio_estab').value = '';
        break;
        case 'alta_estab':
            ocultar_lista_estab();
            ocultar_lista_talonarios();
            ocultar_form_busqueda_cupon();
            document.getElementById('form_alta_estab').reset()
            mostrar_form_estab();
            id_('lista').checked=false;
            id_('validar_cupon').checked=false;
            id_('editar').checked=true;
            alta();
        break;
        case 'validar_cupon':
            id_('validar_cupon').checked=true;
            id_('lista').checked=false;
            id_('editar').checked=false;     
            ocultar_lista_estab();
            ocultar_lista_talonarios();  
            ocultar_form_estab();
            mostrar_form_busqueda_cupon();
            break;                             
        default:
            ocultar_form_estab();
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
    $.colorbox({width:"42%", inline:true, href:"#lista_cupones",open:true}); 

    
  }  

////Esta función valida o desbloquea un cupón.
function validar_cupon(id_establecimiento,numero_talonario,id_talonario,numero,usado)
  {

    var aleatorio='&gg'+(Math.floor(Math.random()*50000))+'=1'; 
    dades='id_establecimiento='+id_establecimiento;
    dades+='&id_talonario='+id_talonario;
    dades+='&numero_cupon='+numero;
    dades+='&usado='+usado;
    id_('lista_cupones').style.display='block';
    
    
  
    if (usado==0){if (!confirm('Desea validar este cupón?')) return;}
    else 
    {
     if (!confirm('Desea desbloquear este cupón?')) 
         return;
     else {
        id_('frm_desbloquear_cupon').reset();
        id_('id_establecimiento_fd').value = id_establecimiento;
        id_('id_talonario_fd').value = id_talonario;
        id_('num_talonario_fd').value = numero_talonario;
        id_('ncupon_fd').value = numero;
        $.colorbox({width:"42%", inline:true, href:"#form_desbloquear_cupon",open:true}); 
        return;          
     }
    }
    
    r=ajax.load('<?php echo $base_scripts ?>ajax_cupones.php?'+dades+aleatorio);
  
    dades+='&numero_talonario='+numero_talonario;
    r=ajax.load('<?php echo $base_scripts ?>cupones.php?'+dades+aleatorio);  

    //eval(r);
    id_('lista_cupones').innerHTML = r;  
    //id_('lista_cupones').style.display='none';
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
    if (r.substring(4,18)=='error_password') {alert('Contraseña incorrecta. Inténtelo de nuevo.'); id_('frm_desbloquear_cupon').reset();}
    else 
    {
    //$.colorbox.close();  
    $.colorbox({width:"42%", inline:true, href:"#lista_cupones",open:true}); 
    }

    dades+='&numero_talonario='+numero_talonario;
    //alert(dades);
    r=ajax.load('<?php echo $base_scripts ?>cupones.php?'+dades+aleatorio);  

    id_('lista_cupones').innerHTML = r;  
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
 