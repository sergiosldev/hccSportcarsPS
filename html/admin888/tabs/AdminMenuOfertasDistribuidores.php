<?php
class AdminMenuOfertasDistribuidores 
{
	public function viewAccess($disable = false)
	{
	}  
}   

include_once dirname(__FILE__).'/scripts/config_events_new.php';
?>
<script type="text/javascript" src="tabs/js/sha.js"></script>
     <script type="text/javascript" src="tabs/js/funcs_cupones_alfa_online.js"></script>
     <script type="text/javascript" src="tabs/js/ajax_load.js"></script>
     <script type="text/javascript" src="tabs/js/ajax_load_post.js"></script>
     <link rel="stylesheet" type="text/css" href="tabs/css/style.css">
     <link rel="stylesheet" type="text/css" href="tabs/css/botones_menu.css">
     <link media="screen" rel="stylesheet" href="tabs/modal/colorbox.css" />
     <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.4.4/jquery.min.js"></script>
     <script src="tabs/modal/colorbox/jquery.colorbox.js"></script>
<?php 
include_once dirname(__FILE__).'/scripts/cupones_alfa_online/funciones_ajax_ofertas_ca.php';
include_once dirname(__FILE__).'/scripts/cupones_alfa_online/funciones_ajax_imagen_oferta_ca.php';
?>
<script>
 
</script>    

<div id="centrar" >
<div>
<fieldset>
    <legend>Opciones Oferta</legend><br>
    <a href="javascript:vista('alta_oferta')" class="boton_menu menu_activo" style="width:96px;" id="editar_ca">Crear Oferta</a> 
    <a href="javascript:vista('ofertas')" class="boton_menu"  style="width:100px;" id="lista_ca">Ver Campañas</a> 
    <a href="javascript:vista('ofertas_creadas')" class="boton_menu"  style="width:109px;" id="lista_creadas_ca">Ofertas Creadas</a> 
    <a href="javascript:vista('alta_distribuidor')" class="boton_menu"  style="width:108px;" id="editar_distribuidor_ca">Alta Distribuidor</a> 
    <a href="javascript:vista('distribuidores')" class="boton_menu"  style="width:121px;"  id="lista_distribuidores_sel_ca">Ver Distribuidores</a>
    <a href="javascript:vista('validar_distribuidor')" class="boton_menu"  style="width:127px;" id="validar_distribuidor_ca">Buscar Distribuidor</a>      
    <a href="javascript:vista('validar_cupon_oferta')" class="boton_menu"  style="width:100px;" id="validar_cupon_oferta_ca">Validar Cupón</a> 
</fieldset>
</div>
</div>

<?php include_once (dirname(__FILE__).'/scripts/cupones_alfa_online/menu_ofertas_creadas_ca.php'); ?>

<div id="lista_ofertas_ca" ></div>
<div id="alta_oferta_ca" style="display:none;float:left;width:100%;">
<?php
include_once (dirname(__FILE__).'/scripts/cupones_alfa_online/formulario_oferta_ca.php'); 
?>
</div>
<div id="lista_distribuidores_ca" ></div>

<div id="listado_historial" style="display:none;float:left;width:100%;"  >
    <div id='lista_historial_distribuidores' style='text-align:left;padding:10px; background:#fff;'>
    </div>
</div>

<br>


<div id="listado" style="display:none;float:left;width:100%;"  >
    <div id='lista_cupones_ofertas_ca' style='text-align:left;padding:10px; background:#fff;'>
    </div>
</div>

<?php

include_once dirname(__FILE__).'/scripts/cupones_alfa_online/formulario_busqueda_cupon_oferta_ca.php'; 
include_once dirname(__FILE__).'/scripts/cupones_alfa_online/formulario_busqueda_distribuidor.php'; 
include_once dirname(__FILE__).'/scripts/cupones_alfa_online/formulario_borrar_oferta_ca.php';   
include_once dirname(__FILE__).'/scripts/cupones_alfa_online/formulario_borrar_imagen_oferta_ca.php';   
include_once dirname(__FILE__).'/scripts/cupones_alfa_online/formulario_desbloquear_cupon_oferta_ca.php';   
include_once dirname(__FILE__).'/scripts/cupones_alfa_online/formulario_observaciones_cupon_oferta_ca.php';    
include_once dirname(__FILE__).'/scripts/cupones_alfa_online/formulario_email_cupones_oferta_ca.php';   
include_once dirname(__FILE__).'/scripts/cupones_alfa_online/formulario_activar_oferta_ca.php';
include_once dirname(__FILE__).'/scripts/cupones_alfa_online/formulario_validar_password_ca.php';   
include_once dirname(__FILE__).'/scripts/cupones_alfa_online/formulario_desactivar_oferta_ca.php';   
include_once dirname(__FILE__).'/scripts/cupones_alfa_online/formulario_distribuidores_ca.php';       
// include dirname(__FILE__).'/scripts/cupones_alfa_online/formulario_cliente_especial_oferta_ca.php';                         
?>


<script>

var cbclose = $.colorbox.close;
//Por defecto mostramos la lista de establecimientos y marcamos por tanto la primera opción del radiobutton.
//id_('editar').checked=true;
vista('alta_oferta');

function dummy(){}
function mostrar_ocultar_elementos(elemento,tipo)
{
    formularios = new Array();
 

    formularios['ofertas'] = new Array('mostrar_lista_ofertas_ca','ocultar_lista_ofertas_ca');
    formularios['ofertas_creadas'] = new Array('mostrar_lista_ofertas_ca','dummy');
    formularios['alta_oferta']= new Array('mostrar_form_oferta_ca','ocultar_form_oferta_ca');
    formularios['validar_cupon_oferta'] = new Array('mostrar_form_busqueda_cupon_oferta_ca','ocultar_form_busqueda_cupon_oferta_ca');
    formularios['alta_distribuidor'] = new Array('mostrar_form_distribuidores_oferta_ca','ocultar_form_distribuidores_oferta_ca');
    formularios['k1']= new Array('mostrar_form_activar_oferta_ca','ocultar_form_activar_oferta_ca');
   // formularios['k2']= new Array('mostrar_form_distribuidores_oferta_ca','ocultar_form_distribuidores_oferta_ca');  
    formularios['distribuidores']= new Array('mostrar_lista_distribuidores_ca','ocultar_lista_distribuidores_ca');
    formularios['validar_distribuidor']= new Array('mostrar_form_busqueda_distribuidor_ca','ocultar_form_busqueda_distribuidor_ca');

                                 
    selectores = new Array();
    selectores['ofertas_creadas']='lista_creadas_ca';
    selectores['ofertas']='lista_ca';
    selectores['alta_oferta']='editar_ca';
    selectores['validar_cupon_oferta']='validar_cupon_oferta_ca';
    selectores['distribuidores']='lista_distribuidores_sel_ca';
    selectores['validar_distribuidor']='validar_distribuidor_ca';    
    selectores['alta_distribuidor']='editar_distribuidor_ca';
    

    for(var form in formularios)
    {   if (form != 'indexOf')
        {
        if (form == elemento) window[formularios[form][0]](); 
        else window[formularios[form][1]]();
        }
    }
    var selector;
    for (selector in selectores) 
    { 
        if (selector != 'indexOf')
        {
        if (selector == elemento) id_(selectores[selector]).className = 'boton_menu menu_activo';
        else if (id_(selectores[selector]).className == 'boton_menu menu_activo') id_(selectores[selector]).className = 'boton_menu';
        }
    }
}

function vista(nombre)
{
    ocultar_menu_ofertas_creadas_ca();
	if (nombre!='alta_distribuidor' && !validar_datos_distribuidor() && id_('id_distribuidor_ca').value=='' && id_('editar_distribuidor_ca').className=='boton_menu menu_activo') 
	{
		if (!confirm('Se han introducido datos en el formulario de Distribuidores. \n\n¿Está seguro de que NO desea guardarlos?')) return;       
	}
    
	switch (nombre)
    {
        case 'ofertas':
            id_('titulo_formulario_oferta_ca').innerHTML='';
            get_lista_ofertas();
            mostrar_ocultar_elementos('ofertas'); 
            id_('edicio_oferta_ca').value = '';
            
        break;
        case 'ofertas_creadas':
            id_('titulo_formulario_oferta_ca').innerHTML='';
            get_lista_ofertas_creadas();
            mostrar_ocultar_elementos('ofertas_creadas');
            id_('edicio_oferta_ca').value = '';
        break;        
        case 'alta_oferta':
            id_('titulo_formulario_oferta_ca').innerHTML='Alta';
            id_('nueva_oferta_ca').style.visibility='hidden';
            nueva_oferta();
            mostrar_ocultar_elementos('alta_oferta');
            id_('msg_error').innerHTML='';  
        break;
        case 'alta_distribuidor':
            id_('titulo_formulario_oferta_ca').innerHTML='';
            id_('form_alta_distribuidor_ca').reset();
            id_('id_distribuidor_ca').value='';
            mostrar_ocultar_elementos('alta_distribuidor');
            id_('msg_error').innerHTML='';  
        break;
        case 'distribuidores':
            id_('titulo_formulario_oferta_ca').innerHTML='';
            get_lista_distribuidores(0,0);
            mostrar_ocultar_elementos('distribuidores');
        break;
        case 'validar_cupon_oferta':
            id_('titulo_formulario_oferta_ca').innerHTML='';
            id_('cupon_oferta_ca').value='';
            mostrar_ocultar_elementos('validar_cupon_oferta');
            break;                             
        case 'validar_distribuidor':
            id_('titulo_formulario_oferta_ca').innerHTML='';
            id_('filtro_distribuidor_ca').value='';
            id_('distribuidor_oferta_ca').value='';
            mostrar_ocultar_elementos('validar_distribuidor');
            break;                             
        case 'ficheros':
            id_('titulo_formulario_oferta_ca').innerHTML='';
            mostrar_ocultar_elementos('k1');
            break;                             

        default:
            id_('titulo_formulario_oferta_ca').innerHTML='';
            ocultar_form_oferta_ca();
            ocultar_form_distribuidores_oferta_ca();
            //ocultar_form_fichero_cupones();
            ocultar_form_busqueda_cupon_oferta_ca();
            id_('edicio_oferta_ca').value = '';
        break;         
    }
}

function validar_datos_distribuidor()
{
	if (id_('nombre_ca').value!='') return false;
	if (id_('usuario_ca').value!='') return false;
	if (id_('password_ca').value!='') return false;
	if (id_('email_oferta_ca').value!='') return false;
	if (id_('nombre_contacto_ca').value!='') return false;
	if (id_('telefono_ca').value!='') return false;
	if (id_('direcciond_ca').value!='') return false;
	if (id_('cpostal_ca').value!='') return false;
	if (id_('ciudad_ca').value!='') return false;
	if (id_('nif_ca').value!='') return false;
	return true;
}

function envia_cupones_dist(id_distribuidor,id_oferta_hist,cupones)
  {
    var aleatorio='&gg'+(Math.floor(Math.random()*50000))+'=1';
    var sufijo = ''; 
    dades='id_distribuidor='+id_distribuidor;
    dades+='&id_oferta_hist='+id_oferta_hist;
    

    r=ajax.load('<?php echo($base_scripts_ca);?>validar_cupones_cancelados_ca.php?id_oferta_hist='+id_oferta_hist+'&cupones='+cupones+aleatorio);       
    var tmp = r.split('#');
    if (r.indexOf('OK')==-1) sufijo='\n\n'+tmp[0]+'\n'+tmp[1];
    //#mts 
    dades+='&cupones='+cupones;
    dades+='&regenerar=1';
    r=ajax.load('../../generar_cupon_alfa.php?'+dades+aleatorio);    

    if (r.indexOf('error')!=-1) alert('Se ha producido un error al renviar los cupones. Vuelva a intentarlo más tarde.');    
    else alert('Los cupones han sido enviados a la dirección de correo del cliente. '+sufijo);
  }  
    
 //Esta función se encarga de listar todos los distribuidores.
function get_lista_distribuidores(orden,direccion,filtro)  
   {
    //orden -> 0: por id de distribuidor, 1: por usuario.  

    if (filtro==undefined) filtro='';
     
    var aleatorio='&gg'+(Math.floor(Math.random()*50000))+'=1'
    var r=ajax.load('<?php echo $base_scripts_ca ?>distribuidores.php?orden='+orden+'&direccion='+direccion+'&filtro='+filtro+aleatorio);  
    //alert (r);
    id_('lista_distribuidores_ca').innerHTML = r;         
    id_('direccion_orden_ca').value=direccion;
    id_('orden_ca').value=orden;
   }   




function historial_distribuidor(id_distribuidor)
  {
    var aleatorio='&gg'+(Math.floor(Math.random()*50000))+'=1'; 
    dades='id_distribuidor='+id_distribuidor;

    r=ajax.load('<?php echo $base_scripts_ca ?>historial_distribuidores.php?'+dades+aleatorio);      
//alert(r);
    //eval(r);
    if (r.indexOf('error')!=-1) r = " <div style='font-weight:bold;color:red;font-size:18px;'>No existen registros de historial para este distribuidor</div>";    
    id_('lista_historial_distribuidores').innerHTML = r;  
    $.colorbox({width:"80%", inline:true, href:"#lista_historial_distribuidores",open:true}); 
  }  



//Esta función responde a los botones para cambiar el orden de la lista de campañas.
function cambiar_posicion_oferta_ca(posicion,direccion,id_oferta_hist)
  {
    var aleatorio='&gg'+(Math.floor(Math.random()*50000))+'=1'
    dades = 'id_oferta_hist='+id_oferta_hist;
    dades += '&posicion='+posicion;
    dades += '&direccion='+direccion;
    var r=ajax.load('<?php echo($base_scripts_ca);?>ajax_ofertas_bd_ca.php?reposicionar=1&'+dades+aleatorio);
    //alert(r);       
    get_lista_ofertas();
  }  

//Esta función responde a los botones para cambiar el orden de las ofertas creadas.
function cambiar_posicion_oferta_creada(posicion,direccion,id_oferta)  
  {
    var aleatorio='&gg'+(Math.floor(Math.random()*50000))+'=1'
    dades = 'id_oferta='+id_oferta;
    dades += '&posicion='+posicion;
    dades += '&direccion='+direccion;
	//alert('<?php echo($base_scripts_ca);?>ajax_ofertas_bd_ca.php?reposicionar_creada=1&'+dades+aleatorio);
    var r=ajax.load('<?php echo($base_scripts_ca);?>ajax_ofertas_bd_ca.php?reposicionar_creada=1&'+dades+aleatorio);
    //alert(r);       
    get_lista_ofertas_creadas();
  }  

//Esta función se encarga de listar todos las ofertas.
function get_lista_ofertas()
   {

    var aleatorio='&gg'+(Math.floor(Math.random()*50000))+'=1'
    var r=ajax.load('<?php echo $base_scripts_ca; ?>ofertas_ca.php?creadas=0'+aleatorio);  

    id_('lista_ofertas_ca').innerHTML = r;         
    
    //iniciar_contador();
    
   }   

function GetCount(ddate,ddatenow,iid,indice,cliente_especial){

    //alert('ddate '+ddate+' ddatenow '+ddatenow);
    var dateNow = new Date(ddatenow.substr(6,4),ddatenow.substr(3,2)-1,ddatenow.substr(0,2),ddatenow.substr(11,2),ddatenow.substr(14,2),ddatenow.substr(17,2));
    var date = new Date(ddate.substr(6,4),ddate.substr(3,2)-1,ddate.substr(0,2),ddate.substr(11,2),ddate.substr(14,2),ddate.substr(17,2));

    amount = date.getTime() - dateNow.getTime();
//alert(iid+indice+'-'+id_('idofertas'+indice).value);
    if(amount < 0){
        //document.getElementById(iid+idoferta).innerHTML="Oferta Caducada";
        if (cliente_especial!=1)
        {
        id_('titulo_estado_oferta'+indice).className='boton_oferta_caducada';
        id_('estado_oferta'+indice).innerHTML='Inactiva';
        id_('activa_ofertas'+indice).value='';
        }
        var r=ajax.load('<?php //echo($base_scripts_ca);?>//ajax_ofertas_bd.php?marcar_oferta_caducada=1&id_oferta='+id_('idofertas'+indice).value+'&id_oferta_hist='+id_('idofertash'+indice).value+'&cliente_especial='+cliente_especial);

        if (cliente_especial==1)
        {
            fechas=r.split('#');   
            ddateNew =  fechas[0];  
            ddatenowNew = fechas[1];
            ddateNew = ddateNew.replace(/^\s*|\s*$/g,"");           
            ddatenowNew = ddatenowNew.replace(/^\s*|\s*$/g,"");         
            GetCount(ddateNew,ddatenowNew,iid,indice,1);     
        }

//          alert(r);
    }
    // else date is still good
    else
    {
        days=0;hours=0;mins=0;secs=0;out="";
        
        amount = Math.floor(amount/1000);//kill the "milliseconds" so just secs
        
        days=Math.floor(amount/86400);//days
        amount=amount%86400;
        
        hours=Math.floor(amount/3600);//hours
        amount=amount%3600;
        
        mins=Math.floor(amount/60);//minutes
        amount=amount%60;
        
        secs=Math.floor(amount);//seconds
        
        if(days != 0){out += days +" "+((days==1)?"día":"días")+" ";}
        if(hours != 0){out += format(hours) +":";}
        out += format(mins) +":";
        out += format(secs) ;
        //out = out.substr(0,out.length-2);
        document.getElementById(iid+indice).innerHTML=' Quedan '+out+' date '+ddate+' datenow '+ddatenow;
      
        
        dateNow.setTime(dateNow.getTime()+1000);  
        var dateNow2 = format(dateNow.getDate())+'/'+format(dateNow.getMonth()+1)+'/'+dateNow.getFullYear()+' '+format(dateNow.getHours())+':'+format(dateNow.getMinutes())+':'+format(dateNow.getSeconds());
        var date2 = format(date.getDate())+'/'+format(date.getMonth()+1)+'/'+date.getFullYear()+' '+format(date.getHours())+':'+format(date.getMinutes())+':'+format(date.getSeconds());
       
      
        setTimeout("GetCount('"+date2+"','"+dateNow2+"','"+iid+"','"+indice+"',"+cliente_especial+")", 1000);
        delete dateNow;

    }
//    setTimeout("GetCount("+1+")", 1000);
  
}


function format(number)
{
    if (number<10) return '0'+number;
    else return number;
}




function iniciar_contador()
{
dateNow = ajax.load('<?php echo($base_scripts_ca);?>ajax_fecha_actual.php');
    
for(var i=0;i<id_('num_ofertas').value;i++)
{
    if(id_('activa_ofertas'+i).value=='1')
    {
        var fecha_futura = id_('fecha_ofertas'+i).value;
        //new Date(fecha.substr(6,4),fecha.substr(3,2)-1,fecha.substr(0,2),fecha.substr(11,2),fecha.substr(14,2),fecha.substr(17,2));       
        GetCount(fecha_futura,dateNow,'tiempo_limite',i,id_('especiales_ofertas'+i).value);
    }

 }
}     


function get_lista_ofertas_creadas()
   {
  
    var aleatorio='&gg'+(Math.floor(Math.random()*50000))+'=1'

    var r=ajax.load('<?php echo $base_scripts_ca ?>ofertas_ca.php?creadas=1'+aleatorio);  
//alert(r);
    id_('lista_ofertas_ca').innerHTML = r;         
   }   


function edita_menu_oferta(id_oferta,periodo,tipo)  
{
  ocultar_lista_ofertas_ca();
  mostrar_menu_ofertas_creadas_ca();
  id_('id_oferta_ca').value=id_oferta;   
  id_('periodo_ca').value=periodo;
  
  edita_oferta(id_oferta,tipo);
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
function cupones_usados_ofertas_ca(id_oferta,creadas,id_distribuidor)
  {
    var aleatorio='&gg'+(Math.floor(Math.random()*50000))+'=1'; 
    dades='id_oferta='+id_oferta;
    
    var cupones_oferta = true;
    
    if (id_distribuidor!=undefined) 
    {
        //alert('id_distribuidor '+id_distribuidor);
        dades+='&id_distribuidor='+id_distribuidor;
        cupones_oferta = false;
    }
    //creadas=0 significa que estamos mostrando el registro de ofertas (campañas). con lo que el id_oferta
    //será en realidad el id del histórico (id_oferta_hist).
    dades=dades+'&creadas='+creadas;
  //   alert(1);
//alert(dades);
    r=ajax.load('<?php echo $base_scripts_ca ?>cupones_oferta_ca.php?'+dades+aleatorio);      
//alert(r);
    //eval(r);
    if (r.indexOf('error')!=-1) r = " <div style='font-weight:bold;color:red;font-size:18px;'>No existen cupones para esta oferta</div>";    
    id_('lista_cupones_ofertas_ca').innerHTML = r;  
    $.colorbox({width:"80%", inline:true, href:"#lista_cupones_ofertas_ca",open:true}); 
    var cbclose = $.colorbox.close;
    $.colorbox.close = function ()
    {
        id_('titulo_formulario_oferta_ca').innerHTML='';
        if (cupones_oferta)
        {
        get_lista_ofertas();
        mostrar_ocultar_elementos('ofertas');
        }
        else
        {
        get_lista_distribuidores(0,0);
        mostrar_ocultar_elementos('distribuidores');
        }
        id_('edicio_oferta_ca').value = '';
        $.colorbox.close = cbclose;
        cbclose();
    }
    //
    //Recargamos la lista de campañas.
  }  

////Esta función abre una ventana donde podremos introducir unas observaciones.
function observaciones_cupon_oferta(id_oferta,cupon,observaciones,creadas,id_distribuidor)
  {

    var aleatorio='&gg'+(Math.floor(Math.random()*50000))+'=1'; 
    dades='id_oferta='+id_oferta;
    dades+='&cupon='+cupon;
    dades+='&observaciones='+observaciones;
    dades+='&creadas='+creadas;
    id_('creadas_fo_ca').value=creadas;
    id_('lista_cupones_ofertas_ca').style.display='block';
   // id_('frm_observaciones_cupon_oferta_ca').reset();
    id_('observacionesoferta_ca').value=observaciones;
    id_('id_oferta_fo_ca').value = id_oferta;
    if (id_distribuidor!='undefined')
    {
        dades+='&id_distribuidor='+id_distribuidor;
        id_('id_distribuidor_fo_ca').value = id_distribuidor;
    }
    else id_('id_distribuidor_fo_ca').value = '';
 
    id_('ncupon_fo_ca').value = cupon;
    $.colorbox({width:"42%", inline:true, href:"#form_observaciones_cupon_oferta_ca",open:true}); 
    r=ajax.load('<?php echo $base_scripts_ca ?>ajax_observaciones_oferta_ca.php?'+dades+aleatorio); 
    //esta llamada ajax en principio no sería necesaria ya  que desde la lista de cupones 
    //ya se pasan como parámetro las observaciones. Sinembargo lo dejamos así
    //por si más adelante se añaden otros datos asociados al cupón. 

    //alert(r);
    id_('observacionesoferta_ca').value = r.replace(/^\s*|\s*$/g,"");
    
    var cbclose = $.colorbox.close;
    $.colorbox.close = function ()
    {
        //envia_formulario_observaciones_cupon_oferta(id_('id_oferta_fo_ca').value,id_('ncupon_fo_ca').value,id_('observaciones_oferta_ca').value,creadas);}
        if (id_distribuidor!=undefined)
            cupones_usados_ofertas_ca(0,0,id_distribuidor);
        else    
            cupones_usados_ofertas_ca(id_oferta,0);
        $.colorbox.close = cbclose;
        return;
    }  


 }
////Esta función abre una ventana donde podremos introducir el correo al que queremos enviar el mail de confirmación de un cupón.
function mail_cupon_oferta(id_oferta,cupon,creadas,id_distribuidor)
  {

    var aleatorio='&gg'+(Math.floor(Math.random()*50000))+'=1'; 
    dades='id_oferta='+id_oferta;
    dades+='&cupon='+cupon;
    dades+='&creadas='+creadas;
    id_('creadas_fec').value=creadas;
    id_('lista_cupones_ofertas_ca').style.display='block';
    id_('frm_email_cupones_oferta').reset();
    id_('id_oferta_fec').value = id_oferta;
    id_('ncupon_fec').value = cupon;
    $.colorbox({width:"42%", inline:true, href:"#form_email_cupones_oferta",open:true}); 

    var cbclose = $.colorbox.close;
    $.colorbox.close = function ()
    {
        //envia_formulario_observaciones_cupon_oferta(id_('id_oferta_fo_ca').value,id_('ncupon_fo_ca').value,id_('observaciones_oferta_ca').value,creadas);}
        if (id_distribuidor!=undefined)
            cupones_usados_ofertas_ca(0,0,id_distribuidor);
        else    
            cupones_usados_ofertas_ca(id_oferta,0);
        $.colorbox.close = cbclose;
        return;
    }  
  
  } 


function envia_formulario_email_cupon_oferta(id_oferta,ncupon,email,creadas,id_distribuidor)
  {
      
    var aleatorio='&gg'+(Math.floor(Math.random()*50000))+'=1'

    var dades = 'email='+email; 
    dades+= '&id_oferta='+id_oferta;
    //dades+= '&cupon='+ncupon;
    dades+= '&creadas='+creadas;
    if (id_distribuidor!='undefined')
    {
        dades+='&id_distribuidor='+id_distribuidor;    
    }
        
    dades2=dades+'&cupon='+ncupon;    
    //alert (dades);
    r=ajax.load('<?php echo $base_scripts_ca ?>ajax_email_cupones_oferta_ca.php?'+dades2+aleatorio);

    if (r.indexOf('Invalid address')!=-1 || r.indexOf('Could not instantiate mail function')!=-1) alert('Se ha producido un error en el envío. Vuelva a inentarlo más tarde.');
    else 
    {
        alert('Su confirmación ha sido enviada');
    }
    //alert(r);
    //$.colorbox.close();  
  //alert(dades);
  $.colorbox.close();
//alert(dades);
    //$.colorbox.close();



 }


////Esta función valida o desbloquea un cupón.
function validar_cupon_oferta(id_oferta,cupon,usado,creadas,id_distribuidor)
  {    
    var aleatorio='&gg'+(Math.floor(Math.random()*50000))+'=1'; 
    
    dades='id_oferta='+id_oferta;
    dades+='&usado='+usado;
    dades+='&cupon='+cupon;
    dades+='&creadas='+creadas;
    if (id_distribuidor!=undefined) dades+='&id_distribuidor='+id_distribuidor;
    id_('lista_cupones_ofertas_ca').style.display='block';
    //alert(dades);
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
            id_('frm_desbloquear_cupon_oferta_ca').reset();
          
            id_('id_oferta_fd_ca').value = id_oferta;
            id_('ncupon_fd_ca').value = cupon;
            id_('creadas_fd_ca').value = creadas;
            if (id_distribuidor!=undefined) id_('id_distribuidor_ca').value = id_distribuidor;
            else id_('id_distribuidor_ca').value = '';
            $.colorbox({width:"42%", inline:true, href:"#form_desbloquear_cupon_oferta_ca",open:true}); 
            
            var cbclose = $.colorbox.close;
            $.colorbox.close = function(){
                $.colorbox({width:"80%", inline:true, href:"#lista_cupones_ofertas_ca",open:true});   
                r=ajax.load('<?php echo $base_scripts_ca ?>cupones_oferta_ca.php?'+dades+aleatorio);
                id_('lista_cupones_ofertas_ca').innerHTML = r;    
                $.colorbox.close=cbclose;
               
                return;
            }            
            return;          
         }
         break;    
/*        case 2:
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
  */       
    //si usado = 3 es que queremos cancelar un cupón.     
    case 3:

         if (!confirm('Desea cancelar este cupón?')) 
         {
             return;
         }
         else {
            
             validar_cupon_password(dades,''); 
             return;          
         }
         break;    
    //si usado = 4 es que queremos eliminar un cupón.     
    case 4:
         if (!confirm('Desea eliminar este cupón?')) 
         {
             return;
         }
         else 
         {
          
             validar_cupon_password(dades,''); 
             return;          
         }
         break;    
        //el estado usado=5 indica que hemos marcado el cupón como facturado.
      case 5:             
         if (!confirm('Está seguro de que desea marcar este cupón como facturado?')) 
             return;
         else 
         {
            validar_cupon_password(dades,''); 
            return;          
         }
        break;
    
        //el estado usado=6 indica que hemos desmarcado un cupón facturado.
      case 6:
         if (!confirm('Está seguro de que desea que este cupón deje de figurar como facturado?')) 
             return;
         else {
            validar_cupon_password(dades,'facturados'); 
            return;          
            //$.colorbox({width:"42%", inline:true, href:"#form_desfacturar_cupon",open:true}); 
            //var cbclose = $.colorbox.close;
           // $.colorbox.close = function (){abrir_lista_cupones(id_establecimiento,id_talonario,numero_talonario);}  
            return;          
         }
        break;
        //el estado usado=7 indica que hemos marcado el cupón como cobrado.
      case 7:             
             if (!confirm('Está seguro de que desea marcar  este cupón como cobrado?')) 
                 return;
             else 
             {
                validar_cupon_password(dades,''); 
                return;          
             }
            break;
    
        //el estado usado=8 indica que hemos desmarcado un cupón cobrado.
        case 8:
             if (!confirm('Está seguro de que desea que este cupón deje de figurar como cobrado?')) 
                 return;
             else {
                validar_cupon_password(dades,'facturados'); 
                return;          
             }
            break;
        //el estado usado=9 indica que hemos marcado el cupón como comercial.
        case 9:             
             if (!confirm('Está seguro de que desea marcar este cupón como comercial?')) 
                 return;
             else 
             {
                validar_cupon_password(dades,''); 
                return;          
             }
            break;
    
        //el estado usado=10 indica que hemos desmarcado un cupón comercial.
        case 10:
             if (!confirm('Está seguro de que desea que este cupón deje de figurar como comercial?')) 
                 return;
             else {
                validar_cupon_password(dades,'facturados'); 
                return;          
             }
            break;
        
    }
 
    r=ajax.load('<?php echo $base_scripts_ca ?>ajax_cupones_ofertas_ca.php?'+dades+aleatorio);

    r=ajax.load('<?php echo $base_scripts_ca ?>cupones_oferta_ca.php?'+dades+aleatorio);  

    id_('lista_cupones_ofertas_ca').innerHTML = r;  
  }  


function validar_cupon_password(dades,tipo_password)
{
    var aleatorio='&gg'+(Math.floor(Math.random()*50000))+'=1'; 

    id_('frm_validar_password_ca').reset();
    id_('archivo_operacion_ca').value= 'ajax_cupones_ofertas_ca.php'
    id_('archivo_retorno_ca').value = 'cupones_oferta_ca.php';
    id_('div_retorno_ca').value= 'lista_cupones_ofertas_ca';
    id_('ancho_div_retorno_ca').value = 80;
    id_('datos_ca').value = dades+'&tipo_password='+tipo_password;
                            
    $.colorbox({width:"42%", inline:true, href:"#form_validar_password_ca",open:true}); 
    
    var cbclose = $.colorbox.close;
    $.colorbox.close = function(){
        $.colorbox({width:"80%", inline:true, href:"#lista_cupones_ofertas_ca",open:true});   
        r=ajax.load('<?php echo $base_scripts_ca ?>cupones_oferta_ca.php?'+dades+aleatorio);
        id_('lista_cupones_ofertas_ca').innerHTML = r;    
        $.colorbox.close=cbclose;
        return;
    }

}

function validar_form_password(dades,archivo_operacion,archivo_retorno,div_retorno,tipo_password)
{
    var aleatorio='&gg'+(Math.floor(Math.random()*50000))+'=1'; 

    id_('frm_validar_password_ca').reset();
    id_('archivo_operacion_ca').value= archivo_operacion;//'ajax_cupones_ofertas_ca.php'
    id_('archivo_retorno_ca').value = archivo_retorno //'cupones_oferta_ca.php';
    id_('div_retorno_ca').value= div_retorno//'lista_cupones_ofertas_ca';
    id_('ancho_div_retorno_ca').value = 80;
    id_('datos_ca').value = dades+'&tipo_password='+tipo_password;
                            
    $.colorbox({width:"42%", inline:true, href:"#form_validar_password_ca",open:true}); 
    
    var cbclose = $.colorbox.close;
    $.colorbox.close = function(){
        $.colorbox({width:"80%", inline:true, href:"#lista_cupones_ofertas_ca",open:true});   
        r=ajax.load('<?php echo $base_scripts_ca ?>cupones_oferta_ca.php?'+dades+aleatorio);
        id_('lista_cupones_ofertas_ca').innerHTML = r;    
        $.colorbox.close=cbclose;
        return;
    }

}


function borrar_distribuidor(id)
{
    
   var aleatorio='&gg'+(Math.floor(Math.random()*50000))+'=1'; 
    
   dades='id_distribuidor='+id;
   dades+='&borrar_distribuidor=1';
   dades+='&orden='+id_('orden_ca').value;     
   dades+='&direccion='+id_('direccion_orden_ca').value;   
   dades+='&tipo_password=';  
   
 
   if (!confirm('Está seguro de que desea eliminar este distribuidor?')) 
   {
       return;
   }
   else 
   {
       id_('frm_validar_password_ca').reset();
       id_('archivo_operacion_ca').value= 'ajax_distribuidores_ca.php'
       id_('archivo_retorno_ca').value = 'distribuidores.php';
       id_('div_retorno_ca').value= 'lista_distribuidores_ca';
       id_('ancho_div_retorno_ca').value = 80;
       id_('datos_ca').value = dades;
                        
       $.colorbox({width:"42%", inline:true, href:"#form_validar_password_ca",open:true}); 
       return;          
   }
}


//Función complementara a validar cupón. Se ejecuta desde el formulario de contraseñas
//cuando tratamos de cancelar un cupón.
function envia_formulario_validar_password (archivo_operacion,archivo_retorno,datos,div_retorno,ancho_div_retorno,password)
  {
    if (password=='') {alert('Debe introducir la contraseña');return;}      
    var aleatorio='&gg'+(Math.floor(Math.random()*50000))+'=1';
    var tipo_password_search =new Array();
    var cond = ''; 
    var tipo_password='';
    //alert(datos);
    tipo_password_search = datos.match(/tipo_password=.*/);
    if (tipo_password_search !=null)
    {
    tipo_password = tipo_password_search[0].replace(' ','');
    if (tipo_password!='') cond = '&'+tipo_password;
    }
    //alert();
    ///alert(dades); 
    if (tipo_password.split('=')[1].toUpperCase() !='NO')
        r=ajax.load('<?php echo $base_scripts_ca ?>ajax_validar_password_ca.php?password='+password+cond+aleatorio);    
    //alert(r); 
    if (r.indexOf('error_password')!=-1) {alert('Contraseña incorrecta. Inténtelo de nuevo.'); id_('frm_validar_password_ca').reset();}
    else 
    {
        //$.colorbox.close();  
        //antes width:80%
        //alert('llamada operacion: '+'<?php echo $base_scripts_ca ?>'+archivo_operacion+'?'+datos+aleatorio);
        
        r=ajax.load('<?php echo $base_scripts_ca ?>'+archivo_operacion+'?'+datos+aleatorio);
        //si hemos eliminado el cupón, lo quitaremos de la lista de parámetros para la llamada a la carga del grid de cupones,
        //ya que en caso de recibir un número de cupón lo utiliza para comprobaciones que una vez eliminado ya no tienen sentido.
        //alert(datos);   
        //alert(r);
        ru = r.toUpperCase();     
        if (ru.indexOf('OK')==-1) {alert(r);}
        else 
            { 
          //  alert(' colorbox ret '+{width:ancho_div_retorno+"%", inline:true, href:"#"+div_retorno,open:true});
                if (archivo_retorno!='distribuidores.php' && archivo_retorno!='ofertas_ca.php')
                    $.colorbox({width:ancho_div_retorno+"%", inline:true, href:"#"+div_retorno,open:true}); 
                //alert(datos+aleatorio);    
                r=ajax.load('<?php echo $base_scripts_ca ?>'+archivo_retorno+'?'+datos+aleatorio);  
                if (r.indexOf('error')!=-1)
                {
                    if (archivo_retorno=='cupones_oferta_ca.php')
                     r = " <div style='font-weight:bold;color:red;font-size:18px;'>No existen cupones para esta oferta</div>";    
                    
                }

                $.colorbox.close=cbclose;

                switch(archivo_retorno)
                {
                    case 'distribuidores.php':
                       id_(div_retorno).innerHTML = r;
                       $.colorbox.close();
                       break;
                    case 'ofertas_ca.php':  
                       id_(div_retorno).innerHTML = r;
                       $.colorbox.close();
                       break;    
                    default:
                       id_(div_retorno).innerHTML = r;   
                        
                        
                }
            }
    }
    

 }

//Función complementaria a validar cupón. Se ejecuta desde el formulario de contraseñas
//cuando tratamos de desbloquear un cheque.
function envia_formulario_desbloquear_cupon_oferta(id_oferta,ncupon,password,creadas,id_distribuidor)
  {
    if (password=='') {alert('Debe introducir la contraseña');return;}      
    var aleatorio='&gg'+(Math.floor(Math.random()*50000))+'=1'

    var dades = 'password='+id_('password').value; //el código alfa será único.
    dades+= '&id_oferta='+id_oferta;
    dades+= '&cupon='+ncupon;
    dades+= '&vendido=1';
    dades+= '&usado=1';
    dades+= '&creadas='+creadas;    
    if (id_distribuidor!=undefined && id_distribuidor!='') dades+='&id_distribuidor='+id_distribuidor;
  
    r=ajax.load('<?php echo $base_scripts_ca ?>ajax_cupones_ofertas_ca.php?'+dades+aleatorio);

    if (r.indexOf('error_password')!=-1) {alert('Contraseña incorrecta. Inténtelo de nuevo.'); id_('frm_desbloquear_cupon_oferta_ca').reset();}
    else 
    {
    //$.colorbox.close();  
    $.colorbox({width:"80%", inline:true, href:"#lista_cupones_ofertas_ca",open:true});   
    }
   
   
    $.colorbox.close=cbclose;

    //alert(dades);
    r=ajax.load('<?php echo $base_scripts_ca ?>cupones_oferta_ca.php?'+dades+aleatorio);  

    id_('lista_cupones_ofertas_ca').innerHTML = r;  
 }
  


//Función complementaria a observaciones_cupon. Se ejecuta desde el formulario de observaciones    
//cuando tratamos de modificar su texto.
//Función encargada de actualizar el texto de una observación.
function envia_formulario_observaciones_cupon_oferta(id_oferta,ncupon,observaciones,creadas,id_distribuidor)
  {
      
    var aleatorio='&gg'+(Math.floor(Math.random()*50000))+'=1';

    var dades = 'observaciones='+id_('observacionesoferta_ca').value; 
    dades+= '&cupon='+ncupon;
    dades+= '&creadas='+creadas;
    if (id_distribuidor!='undefined')
    {
        dades+='&id_distribuidor='+id_distribuidor;
        dades+= '&id_oferta=';
    }
    else dades+= '&id_oferta='+id_oferta;
    
    dades+= '&tipo_password=NO';
    
    //alert (dades); 
    
    //validar_form_password(dades,'ajax_cupones_ofertas_ca','cupones_oferta_ca.php','lista_cupones_ofertas_ca','no');
    envia_formulario_validar_password ('ajax_cupones_ofertas_ca.php','cupones_oferta_ca.php',dades,'lista_cupones_ofertas_ca',80,'sin_password');
 }



////Esta función abre el formulario de búsqueda de cupones.
function buscar_cheque_oferta(id_oferta)
  {
  var ale='&gg'+(Math.floor(Math.random()*50000))+'=1';
  id_('msg_error_ca').innerHTML='';
  id_('frm_busqueda_oferta_ca').reset();
  id_('id_oferta_ca').value=id_oferta;
} 

 
function envia_formulario_distribuidor(id_oferta) 
  {
    var ale='&gg'+(Math.floor(Math.random()*50000))+'=1'
    var dades=obtenirDadesForm('form_alta_distribuidor_ca');
    if (id_('nombre_ca').value==''){alert('Debe introducir el nombre del distribuidor');return;}
    if (id_('usuario_ca').value==''){alert('Debe introducir el usuario del distribuidor');return;}
    if (id_('email_oferta_ca').value==''){alert('Debe introducir el email del distribuidor');return;}
    if (id_('password_ca').value==''){alert('Debe introducir la contraseña');return;}
    if (id_('telefono_ca').value==''){alert('Debe introducir el teléfono del distribuidor');return;}
    if (id_('direcciond_ca').value==''){alert('Debe introducir la dirección del distribuidor');return;}
    if (id_('cpostal_ca').value==''){alert('Debe introducir el código postal del distribuidor');return;}
    if (id_('nif_ca').value==''){alert('Debe introducir el NIF del distribuidor');return;}
    var operacion;
    if (id_('id_distribuidor_ca').value!='') operacion = 'modifica_distribuidor';
    else operacion = 'nuevo_distribuidor';
    //alert(operacion);
    r=ajax.load('<?php echo $base_scripts_ca ?>ajax_distribuidores_ca.php?'+operacion+'=1&id_distribuidor='+id_('id_distribuidor_ca').value+'&'+dades+ale);
   //alert(r);
    var ok=/OK/;

    if (ok.test(r)) { // recarrega graella
	
		if (operacion == 'nuevo_distribuidor')
			id_('form_alta_distribuidor_ca').reset();
        id_('msg_error_distribuidores').innerHTML='';
        if (id_('desde_cupones_ca').value==1) 
        {
        if (id_oferta!=0)   
            abrir_lista_cupones_oferta(id_oferta);
        else    
            abrir_lista_cupones_oferta(id_oferta,id_('id_distribuidor_ca').value);
        }
        else
        {
            if (id_('desde_cupones_ca').value!='')
                vista('distribuidores'); 
            else
                abrir_lista_distribuidores(id_('orden_ca').value,id_('direccion_orden_ca').value);
                ocultar_form_distribuidores_oferta_ca();
        } 

     //alert(r)
     //id_('msg_error').innerHTML='Recepción correcta';
      //get_lista_establecimientos();
      //id_('alta_usuario').style.display="none";
      //vista('establecimientos');
     }
    else {  
     id_('msg_error_distribuidores').innerHTML=r;
     //get_lista_establecimientos();
     //vista('establecimientos');    
    }

     
  }
  


 //Función para editar los datos del distribuidor.
  
  function edita_distribuidor(id_distribuidor,id_oferta,desde_cupones,cupon) 
  { 
  var ale='&gg'+(Math.floor(Math.random()*50000))+'=1';  
  mostrar_form_distribuidores_oferta_ca();
  if (id_oferta != 0) 
    {
    id_('lista_cupones_ofertas_ca').style.display='block';
    id_('id_oferta_distribuidor_ca').value = id_oferta;
    }
    else
    { 
    id_('lista_distribuidores_ca').style.display='block';
    id_('id_oferta_distribuidor_ca').value = 0; 
    }  
  id_('msg_error_distribuidores').innerHTML='';
  id_('form_alta_distribuidor_ca').reset();
  if (desde_cupones!=undefined) id_('desde_cupones_ca').value = 1;
  else id_('desde_cupones_ca').value = 0;
 
  $.colorbox({width:"42%", inline:true, href:"#form_distribuidor_ca",open:true});
  id_('alta_distribuidor_oferta_ca').style.display='block'; 
  //alert('akir');
  id_('edicio_distribuidor_ca').value='edicio';
  id_('titulo_formulario_ca').innerHTML = 'Editar';
  id_('id_distribuidor_ca').value=id_distribuidor;
  
  //El cupón sólo nos intereserá para el caso de los usuarios de prueba, en cuyo caso el teléfono y email del usuario que se mostrará
  //será el que figura en el cupón.
  if (cupon!=undefined && cupon!=0)
	r=ajax.load('<?php echo $base_scripts_ca ?>ajax_distribuidores_ca.php?id_distribuidor='+id_distribuidor+'&id_edita_distribuidor=1&cupon='+cupon+ale); 
  else
    r=ajax.load('<?php echo $base_scripts_ca ?>ajax_distribuidores_ca.php?id_distribuidor='+id_distribuidor+'&id_edita_distribuidor=1'+ale); 

  ru=r.toUpperCase();
  
  if (ru.indexOf('ERROR')==-1) eval(r);
  else alert('Error al realizar la consulta');
  var cbclose = $.colorbox.close;
  //alert(id_oferta);
  $.colorbox.close =   function (){
      
      if (desde_cupones == '1' )
      {
        if (id_oferta!=0)   
            abrir_lista_cupones_oferta(id_oferta);
        else    
            abrir_lista_cupones_oferta(id_oferta,id_distribuidor);
      }  
      else
      {
        abrir_lista_distribuidores(id_('orden_ca').value,id_('direccion_orden_ca').value);
        cbclose();
      }
        
//      $.colorbox.close=cbclose;
      ocultar_form_distribuidores_oferta_ca();
     
   }

  return;          
}

function abrir_lista_distribuidores(orden,direccion)
{
  var ale='&gg'+(Math.floor(Math.random()*50000))+'=1';
  dades= 'orden='+orden+'&direccion='+direccion;
  r=ajax.load('<?php echo $base_scripts_ca ?>distribuidores.php?'+dades+ale);  
  $.colorbox.close = cbclose;    
  id_('lista_distribuidores_ca').innerHTML = r;  
}

function abrir_lista_cupones_oferta(id_oferta,id_distribuidor)
{
  ocultar_form_distribuidores_oferta_ca();
  var ale='&gg'+(Math.floor(Math.random()*50000))+'=1';
  $.colorbox({width:"80%", inline:true, href:"#lista_cupones_ofertas_ca",open:true}); 
  if (id_distribuidor==undefined)
  {
  dades= 'id_oferta='+id_oferta;
  }
  else dades = 'id_oferta=0&id_distribuidor='+id_distribuidor;
  r=ajax.load('<?php echo $base_scripts_ca ?>cupones_oferta_ca.php?'+dades+ale);  
  $.colorbox.close = cbclose;    
  id_('lista_cupones_ofertas_ca').innerHTML = r;
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
                    plugins : "safari,pagebreak,style,layer,table,advimage,advlink,inlinepopups,media,searchreplace,contextmenu,paste,directionality,fullscreen,spellchecker",
                    //theme_advanced_buttons3_add : "emotions,iespell,advhr,separator,print,fullscreen",
                    spellchecker_languages : "+Spanish=es,Catalan=ca",
//English=en
                    // Theme options
                    theme_advanced_buttons1 : "newdocument,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,styleselect,formatselect,fontselect,fontsizeselect",
                    theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,,|,forecolor,backcolor",
                    theme_advanced_buttons3 : "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,media,|,ltr,rtl,|,fullscreen",                   
                    theme_advanced_buttons4 : "insertlayer,moveforward,movebackward,absolute,|,styleprops,|,cite,abbr,acronym,del,ins,attribs,|,pagebreak",
                    //theme_advanced_buttons4_add : "emotions,iespell,advhr,separator,print,fullscreen,spellchecker",
                    theme_advanced_buttons4_add : "spellchecker",
                    theme_advanced_toolbar_location : "top",
                    theme_advanced_toolbar_align : "left",
                    theme_advanced_statusbar_location : "bottom",
                    theme_advanced_resizing : false,
                    content_css : "'.__PS_BASE_URI__.'themes/'._THEME_NAME_.'/css/global.css",
                    document_base_url : "'.__PS_BASE_URI__.'",
                    width: "600", //582
                    font_size_style_values : "8pt, 10pt, 12pt, 14pt, 18pt, 24pt, 36pt",
                    // Drop lists for link/image/media/template dialogs
                    template_external_list_url : "lists/template_list.js",
                    external_link_list_url : "lists/link_list.js",
                    external_image_list_url : "lists/image_list.js",
                    media_external_list_url : "lists/media_list.js",
                    force_br_newlines : true,
                    force_p_newlines : false,    
                    elements : "nourlconvert",
                    convert_urls : false,
					apply_source_formatting : true,
                    spellchecker_rpc_url : \''.__PS_BASE_URI__.'js/tinymce/jscripts/tiny_mce/plugins/spellchecker/rpc.php\',
                    language : "'.(file_exists(_PS_ROOT_DIR_.'/js/tinymce/jscripts/tiny_mce/langs/es.js') ? 'es' : 'en').'"
                });
            });
        }



        tinyMCEInit(\'textarea.rte\');

        </script>
        <style>
        iframe#descripcion_cupones_ifr ul{font-size:11px !important;font-family:Times New Roman !important;}
                </style>';              

//echo(dirname(__FILE__));
//        tinyMCEInit(\'textarea.rte\',\'input.rte\');

?>


 