<?php
class AdminMenuOfertas
{	
	public function viewAccess($disable = false)
	{
	}  
}


include_once dirname(__FILE__).'/scripts/config_events_new.php';

include_once dirname(__FILE__).'/scripts/funciones_ofertas.php';

?>
<script>
var campana_activa = 1; //Esta variable global guarda el estado del menú de campañas(0: Todas las campañas, 1: Campañas día, 2:Campañas inactis, 3:Campañas VIP, 0:Todas).
var filtro_servicio_activo = 0;//tipo de servicio con que filtramos las ofertas creadas (1:Experiencia, 2:Experiencia+Hotel, 3:Hotel).
//var filtro_servicio_activo_camp = 1;//tipo de servicio con que filtramos las campañas  (1:Experiencia, 2:Experiencia+Hotel, 3:Hotel).
var filtro_servicio_activo_camp = 0;//tipo de servicio con que filtramos las campañas  (1:Experiencia, 2:Experiencia+Hotel, 3:Hotel).
var filtro_oferta_activo = 1; //guarda el estado del menú ofertas en Ofertas Creadas (1: Ofertas normales, 2:Ofertas VIP).
var boton_menu_campanas_defecto=1; //botón activo por defecto en el menú de campañas. 
var boton_menu_ofertas_defecto=1; //botón activo por defecto en el menú de oferta creadas.
var timer_ofertas='';
var timer_ofertas_primero=-1;
var registros_pagina_cliente=300;
var marcado=0;

function cambiar_camp(camp)
{
	campana_activa=camp;
}

function cambiar_filtro_oferta(filtro)
{
	filtro_oferta_activo=filtro;
}

function cambiar_filtro_servicio(filtro)
{
	filtro_servicio_activo=filtro;
}

function cambiar_filtro_servicio_camp(filtro)
{
	filtro_servicio_activo_camp=filtro;
}

</script>    

<script type="text/javascript" src="tabs/js/sha.js"></script>
     <script type="text/javascript" src="tabs/js/funcs.js"></script>
     <script type="text/javascript" src="tabs/js/ajax_load.js"></script>
     <script type="text/javascript" src="tabs/js/ajax_load_post.js"></script>
     <link rel="stylesheet" type="text/css" href="tabs/css/style.css">
     <link rel="stylesheet" type="text/css" href="tabs/css/botones_menu.css">
     <link media="screen" rel="stylesheet" href="tabs/modal/colorbox.css" />
     <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.4.4/jquery.min.js"></script>
     <script src="tabs/modal/colorbox/jquery.colorbox.js"></script>
	 
<script>
	var cbclose = $.colorbox.close;
</script>	 
<?php 
include_once dirname(__FILE__).'/scripts/funciones_ajax_ofertas.php';
include_once dirname(__FILE__).'/scripts/funciones_ajax_imagen_oferta.php';
?>

<div id="centrar">
<div>
<fieldset>
    <legend>Opciones Oferta</legend><br>
	<?php 
	global $cookie;
	if ($cookie->profile==1)
	{
	?>
    <a href="javascript:vista('alta_oferta')" class="boton_menu menu_activo" id="editar">Crear oferta</a> 
    <a href="javascript:vista('ofertas')" class="boton_menu" id="lista">Ver Campañas</a> 
    <a href="javascript:vista('ofertas_creadas')" class="boton_menu" id="lista_creadas">Ofertas creadas</a> 
    <a href="javascript:vista('clientes')" class="boton_menu" id="lista_clientes_sel">Ver Clientes</a> 
	<?php 
	}?>
	<a href="javascript:vista('validar_cliente')" class="boton_menu" id="validar_cliente">Buscar cliente</a> 
    <a href="javascript:vista('validar_cupon_oferta')" class="boton_menu" id="validar_cupon_oferta">Validar cupón</a> 
	<a href="javascript:vista('baja_cliente')" class="boton_menu" id="baja_clientes_sel">Baja cliente</a> 


<!--    Crear oferta: <INPUT id="editar" TYPE="RADIO" NAME="editar" VALUE="editar" onclick="vista('alta_oferta')"> 
    &nbsp;&nbsp;&nbsp;&nbsp;Ver Campañas: <INPUT TYPE="RADIO" id="lista" NAME="ofertas" VALUE="lista" onclick="vista('ofertas')">
    &nbsp;&nbsp;&nbsp;&nbsp;Ofertas creadas: <INPUT TYPE="RADIO" id="lista_creadas" NAME="ofertas_creadas" VALUE="lista_creadas" onclick="vista('ofertas_creadas')">
    &nbsp;&nbsp;&nbsp;&nbsp;Ver Clientes: <INPUT TYPE="RADIO" id="lista_clientes_sel" NAME="clientes" VALUE="lista_clientes" onclick="vista('clientes')">
    &nbsp;&nbsp;&nbsp;&nbsp;Inicio <INPUT id="inicio_oferta" TYPE="RADIO" NAME="inicio_oferta" VALUE="inicio_oferta" onclick="vista('inicio_oferta')">
    &nbsp;&nbsp;&nbsp;&nbsp;Validar cupón: <INPUT id="validar_cupon_oferta" TYPE="RADIO" NAME="validar_cupon_oferta" VALUE="validar_cupon" onclick="vista('validar_cupon_oferta')">
-->
    <!--&nbsp;&nbsp;&nbsp;&nbsp;Ficheros: <INPUT id="ficheros" TYPE="RADIO" NAME="ficheros" VALUE="ficheros" onclick="vista('ficheros')">-->

</fieldset>
</div>

<div id="menu_campanas" style="display:none;">
<fieldset>
    <legend>Filtrar Campañas</legend><br>  
<!--    <a href="javascript:get_lista_ofertas(0);mostrar_ocultar_elementos_menu_camp('camp_todas');" class="boton_menu menu_activo" style="width:150px;" id="camp_todas">Todas las campañas</a> 
    <a href="javascript:get_lista_ofertas(1);mostrar_ocultar_elementos_menu_camp('camp_dia');" class="boton_menu" id="camp_dia">Campañas día</a> 
    <a href="javascript:get_lista_ofertas(2);mostrar_ocultar_elementos_menu_camp('camp_inactivas');" class="boton_menu" id="camp_inactivas" style="width:140px;" >Campañas inactivas</a> 
    <a href="javascript:get_lista_ofertas(3);mostrar_ocultar_elementos_menu_camp('camp_vip');" class="boton_menu" id="camp_vip">Campañas VIP</a> 
-->
    <a href="javascript:get_lista_ofertas(1);" class="boton_menu" id="camp_dia">Campañas día</a> 
    <a href="javascript:get_lista_ofertas(2);" class="boton_menu" id="camp_inactivas" style="width:140px;" >Campañas inactivas</a> 
    <a href="javascript:get_lista_ofertas(3);" class="boton_menu" id="camp_vip">Campañas VIP</a> 
    <a href="javascript:get_lista_ofertas(0);" class="boton_menu menu_activo" style="width:150px;" id="camp_todas">Todas las campañas</a> 
	<div style="float: right; padding-right: 10px;">
		<span style="font-weight:bold;">Tipo de servicio:</span>
		<select id="tipo_servicio_oferta_camp" name="tipo_servicio_oferta_camp" style="margin-top: 7px; margin-left: 13px;" onclick="if (typeof(this.selectedIndex) != 'undefined') get_lista_ofertas(campana_activa,this.options[this.selectedIndex].value);">
		<?php
			$servicios = getTiposServicio();
			$tipo_servicio_defecto=1;
			foreach($servicios as $servicio)
			{
				//echo('<option value='.$servicio['id'].' '.(($servicio['id']==$tipo_servicio_defecto)?'selected=selected':'').' >'.$servicio['desc'].'</option>');
				echo('<option value='.$servicio['id'].'>'.$servicio['desc'].'</option>');
			}
			echo('<option value=0 selected=selected>Todas</option>');
			 
		?>
		</select>
	</div>
	</fieldset>
</div>

<div id="menu_ofertas" style="display:none;">
<fieldset>
    <legend>Filtrar Ofertas</legend><br>  
    <a href="javascript:get_lista_ofertas_creadas(1);" class="boton_menu menu_activo" style="width:150px;" id="ofertas_normales">Ofertas normales</a> 
    <a href="javascript:get_lista_ofertas_creadas(2);" class="boton_menu" id="ofertas_vip">Ofertas VIP</a> 
    <a href="javascript:get_lista_ofertas_creadas(0);" class="boton_menu menu_activo" style="width:150px;" id="ofertas_todas">Todas las ofertas</a> 
	<div style="float: right; padding-right: 10px;">
	<span style="font-weight:bold;">Seleccione el tipo de servicio:</span>
	<select id="tipo_servicio_oferta" name="tipo_servicio_oferta" style="margin-top: 7px; margin-left: 13px;" onclick="if (typeof(this.selectedIndex) != 'undefined') get_lista_ofertas_creadas(filtro_oferta_activo,this.options[this.selectedIndex].value);">
	<?php
		$servicios = getTiposServicio();
		$tipo_servicio_defecto=1;
		foreach($servicios as $servicio)
		{
			//echo('<option value='.$servicio['id'].' '.(($servicio['id']==$tipo_servicio_defecto)?'selected=selected':'').' >'.$servicio['desc'].'</option>');
			echo('<option value='.$servicio['id'].'>'.$servicio['desc'].'</option>');
		}
		echo('<option value=0 selected=selected>Todas</option>');
		
	?>
	</select>
	</div>
	</fieldset>
</div>


</div>

<?php 
include_once dirname(__FILE__).'/scripts/menu_ofertas_creadas.php';  
?>


<div id="lista_ofertas" ></div>
<div id="alta_oferta" style="display:none;float:left;width:100%;">
<?php 
include_once dirname(__FILE__).'/scripts/formulario_oferta.php'; 
?>

</div>
<?php 
if ($tipo='ofertas_online') 
{?>
<div id="lista_clientes" ></div>
<? } else { ?>}
<div id="lista_distribuidores" ></div>
<?php 
} ?>


<br>


<div id="listado" style="display:none;float:left;width:100%;"  >	
	<input id="btn_mover_a_cupon" type="button" style="display:none;" onclick="javascript:mover_a_cupon();">                       

    <div id='lista_cupones_ofertas' style='text-align:left;padding:10px; background:#fff;'>
    </div>
</div>


<?php 
if ($tipo=='ofertas_online') 
{ ?> 
    <div id="listado_historial" style="display:none;float:left;width:100%;"  >
        <div id='lista_historial_clientes' style='text-align:left;padding:10px; background:#fff;'>
        </div>
    </div>
    <div id="listado_reservas" style="display:none;float:left;width:100%;"  >
        <div id='lista_historial_reservas' style='text-align:left;padding:10px; background:#fff;'>
        </div>
    </div>

<?php 
}

include_once dirname(__FILE__).'/scripts/formulario_busqueda_cupon_oferta.php'; 
include_once dirname(__FILE__).'/scripts/formulario_busqueda_cliente.php'; 
//include dirname(__FILE__).'/scripts/formulario_fichero_cupones.php';  
include_once dirname(__FILE__).'/scripts/formulario_borrar_oferta.php';   
include_once dirname(__FILE__).'/scripts/formulario_borrar_imagen_oferta.php';   
include_once dirname(__FILE__).'/scripts/formulario_desbloquear_cupon_oferta.php';   
include_once dirname(__FILE__).'/scripts/formulario_observaciones_cupon_oferta.php';    
include_once dirname(__FILE__).'/scripts/formulario_email_cupones_oferta.php';   
include_once dirname(__FILE__).'/scripts/formulario_activar_oferta.php';
include_once dirname(__FILE__).'/scripts/formulario_validar_password.php';   
include_once dirname(__FILE__).'/scripts/formulario_desactivar_oferta.php';   
include_once dirname(__FILE__).'/scripts/formulario_usuarios.php';   
include_once dirname(__FILE__).'/scripts/formulario_cliente_especial_oferta.php';   
include_once dirname(__FILE__).'/scripts/formulario_busqueda_baja_cliente.php';   
include_once dirname(__FILE__).'/scripts/formulario_borrar_baja_clientes.php';   

?>


<script>

cbclose = $.colorbox.close;

//Por defecto mostramos la lista de establecimientos y marcamos por tanto la primera opción del radiobutton.
//id_('editar').checked=true;
vista('alta_oferta',true);

function dummy(){}
function mostrar_ocultar_elementos(elemento,tipo)
{
    formularios = new Array();
 
        formularios['ofertas'] = new Array('mostrar_lista_ofertas','ocultar_lista_ofertas');
        formularios['ofertas_creadas'] = new Array('mostrar_lista_ofertas','ocultar_menu_ofertas');
        formularios['alta_oferta']= new Array('mostrar_form_oferta','ocultar_form_oferta');
        formularios['validar_cupon_oferta'] = new Array('mostrar_form_busqueda_cupon_oferta','ocultar_form_busqueda_cupon_oferta');
        formularios['k1']= new Array('mostrar_form_activar_oferta','ocultar_form_activar_oferta');
        formularios['k2']= new Array('mostrar_form_usuarios_oferta','ocultar_form_usuarios_oferta');
        formularios['clientes']= new Array('mostrar_lista_clientes','ocultar_lista_clientes');
		formularios['validar_cliente']= new Array('mostrar_form_busqueda_cliente','ocultar_form_busqueda_cliente');
		formularios['baja_cliente']= new Array('mostrar_form_busqueda_baja_clientes','ocultar_form_busqueda_baja_clientes');
											    
                                    
        selectores = new Array();
        selectores['ofertas_creadas']='lista_creadas';
        selectores['ofertas']='lista';
        selectores['alta_oferta']='editar';
        selectores['validar_cupon_oferta']='validar_cupon_oferta';
		selectores['validar_cliente']='validar_cliente';
        selectores['clientes']='lista_clientes_sel';
		selectores['baja_cliente']='baja_clientes_sel';

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


//cambia los estilos de la opción activa en el menú de campañas.
function mostrar_ocultar_elementos_menu_camp(elemento)
{

	selectores2 = new Array();
	selectores2['camp_todas']='camp_todas';
	selectores2['camp_dia']='camp_dia';
	selectores2['camp_inactivas']='camp_inactivas';
	selectores2['camp_vip']='camp_vip';

    var selector2;

    for (selector2 in selectores2)  
    { 
        if (selector2 != 'indexOf')
        {
        
		if (selector2 == elemento) id_(selectores2[selector2]).className = 'boton_menu menu_activo';
        else if (id_(selectores2[selector2]).className == 'boton_menu menu_activo') id_(selectores2[selector2]).className = 'boton_menu';
        }
    }

}


//cambia los estilos de la opción activa en el menú de ofertas creadas (el que muestra la lista de ofertas creadas, no el de edición).
function mostrar_ocultar_elementos_menu_ofertas(elemento)
{

	var submenu_creadas = new Array();
	submenu_creadas['ofertas_todas']='ofertas_todas';
	submenu_creadas['ofertas_normales']='ofertas_normales';
	submenu_creadas['ofertas_vip']='ofertas_vip';

    var submenu;

    for (submenu in submenu_creadas)  
    { 
        if (submenu != 'indexOf')
        {
		if (submenu == elemento) id_(submenu_creadas[submenu]).className = 'boton_menu menu_activo';
        else if (id_(submenu_creadas[submenu]).className == 'boton_menu menu_activo') id_(submenu_creadas[submenu]).className = 'boton_menu';
        }
    }

}




function vista(nombre,load_ini)
{
    ocultar_menu_ofertas_creadas();   
	//alert(nombre);
	
    switch (nombre)
    {
        case 'ofertas':
            id_('titulo_formulario_oferta').innerHTML='';
			mostrar_ocultar_elementos('ofertas','<?php echo($tipo);?>'); 
			//alert(2);
			mostrar_ocultar_elementos_menu_camp('camp_todas');
            get_lista_ofertas(boton_menu_campanas_defecto);
			ocultar_menu_ofertas();
			mostrar_menu_campanas();
			//ocultar_menu_ofertas_creadas();
			id_('edicio_oferta').value = '';
            
        break;
        case 'ofertas_creadas':
            id_('titulo_formulario_oferta').innerHTML='';
            get_lista_ofertas_creadas(boton_menu_ofertas_defecto);
            mostrar_ocultar_elementos('ofertas_creadas','<?php echo($tipo);?>');
			mostrar_ocultar_elementos_menu_ofertas('ofertas_normales');
			//mostrar_menu_ofertas_creadas();
            ocultar_menu_campanas();
			mostrar_menu_ofertas();			
			get_lista_ofertas_creadas(1);
			id_('edicio_oferta').value = '';
        break;        
        case 'alta_oferta':
            id_('titulo_formulario_oferta').innerHTML='Alta';
            id_('nueva_oferta').style.visibility='hidden';
            nueva_oferta(load_ini);
            mostrar_ocultar_elementos('alta_oferta','<?php echo($tipo);?>');
            ocultar_menu_campanas();
			ocultar_menu_ofertas();			
            id_('msg_error').innerHTML='';  
        break;
        case 'clientes':
            id_('titulo_formulario_oferta').innerHTML='';
            get_lista_clientes(0,1,'',1,registros_pagina_cliente);
            ocultar_menu_campanas();
			ocultar_menu_ofertas();			
            mostrar_ocultar_elementos('clientes','<?php echo($tipo);?>');
        break;
        case 'baja_cliente':
            id_('titulo_formulario_oferta').innerHTML='';
            //get_lista_clientes(0,1,'',1,registros_pagina_cliente);
            ocultar_menu_campanas();
			ocultar_menu_ofertas();		
            mostrar_ocultar_elementos('baja_cliente','<?php echo($tipo);?>');
        break;
        case 'validar_cupon_oferta':
            id_('titulo_formulario_oferta').innerHTML='';
            id_('cupon_oferta').value='';
            mostrar_ocultar_elementos('validar_cupon_oferta','<?php echo($tipo);?>');
			ocultar_menu_ofertas();
            ocultar_menu_campanas();
            break;                             
        case 'validar_cliente':
            id_('titulo_formulario_oferta').innerHTML='';
            id_('filtro_cliente').value='';
			id_('cliente_oferta').value='';
            mostrar_ocultar_elementos('validar_cliente','<?php echo($tipo);?>');
            ocultar_menu_campanas();
			ocultar_menu_ofertas();			
            break;                             
        case 'ficheros':
            id_('titulo_formulario_oferta').innerHTML='';
            mostrar_ocultar_elementos('k1','<?php echo($tipo);?>');
            ocultar_menu_campanas();
			ocultar_menu_ofertas();			
            break;                             

        default:
            id_('titulo_formulario_oferta').innerHTML='';
            ocultar_form_oferta();
            ocultar_form_usuarios_oferta();
            //ocultar_form_fichero_cupones();
            ocultar_form_busqueda_cupon_oferta();
            ocultar_menu_campanas();
			ocultar_menu_ofertas();			
            id_('edicio_oferta').value = '';
        break;         
    }
}


function historial_cliente(id_usuario)
  {
    var aleatorio='&gg'+(Math.floor(Math.random()*50000))+'=1'; 
    dades='id_usuario='+id_usuario;

    r=ajax.load('<?php echo $base_scripts ?>historial_clientes.php?'+dades+aleatorio);      
//alert(r);
    //eval(r);
    if (r.indexOf('error')!=-1) r = " <div style='font-weight:bold;color:red;font-size:18px;'>No existen registros de historial para este usuario</div>";    
    id_('lista_historial_clientes').innerHTML = r;  
    $.colorbox({width:"80%", inline:true, href:"#lista_historial_clientes",open:true}); 
  }  

  function historial_reservas(id_usuario)
  {
    var aleatorio='&gg'+(Math.floor(Math.random()*50000))+'=1'; 
    dades='id_usuario='+id_usuario;

    r=ajax.load('<?php echo $base_scripts ?>historial_reservas.php?'+dades+aleatorio);      
//alert(r);
    //eval(r);
    if (r.indexOf('error')!=-1) r = " <div style='font-weight:bold;color:red;font-size:18px;'>No existen registros de historial de reservas para este usuario</div>";    
    id_('lista_historial_reservas').innerHTML = r;  
    $.colorbox({width:"80%", inline:true, href:"#lista_historial_reservas",open:true}); 
  }  

function envia_cupones(id_usuario,id_oferta_hist,cupones,codigo_reserva,id_opcion)
  {
    var aleatorio='&gg'+(Math.floor(Math.random()*50000))+'=1';
    var sufijo = ''; 
	var todos_cancelados=false;
    dades='id_usuario='+id_usuario;
    dades+='&id_oferta='+id_oferta_hist;
	if (id_opcion != undefined) dades+='&id_opcion_oferta='+id_opcion
                                        
	if (cupones=='@') 
	{
	    if (!confirm('Está seguro de que desea desmarcar la reserva?')) return;
        else
		{		
			r=ajax.load('<?php echo($base_scripts);?>desmarcar_reserva.php?codigo_reserva='+codigo_reserva+aleatorio);       
			ru=r.toUpperCase();
			if(ru.indexOf('ERROR')!=-1) {alert('Se ha producido un error al desmarcar la reserva');return;}
			else 
			{
				get_lista_clientes(0,0,'',1,registros_pagina_cliente);
				return;
			}
	    }	

	}
	
	else if (cupones=='#') //Este caso corresponde a pagos realizados cuyos cupones no fueron generados a causa de que fallaron las 
                      //notificaciones IPN.
    {

		r=ajax.load('<?php echo($base_scripts);?>generar_cupones_perdidos.php?codigo_reserva='+codigo_reserva+'&id_usuario='+id_usuario+aleatorio);       
        ru=r.toUpperCase();
        if(ru.indexOf('ERROR')!=-1) {alert('Se ha producido un error al generar los cupones');return;}
        else 
        {
            cupones = r;
			dades+='&cupones='+cupones;

        }
     get_lista_clientes(0,0,'',1,registros_pagina_cliente);
	}
    else
    {

    r=ajax.load('<?php echo($base_scripts);?>validar_cupones_cancelados.php?id_oferta_hist='+id_oferta_hist+'&cupones='+cupones+aleatorio);      
    var tmp = r.split('#');
    if (r.indexOf('OK')==-1) 
	{
	if (tmp[0]==1) todos_cancelados = true;
	else todos_cancelados = false;
	sufijo='\n\n'+tmp[1]+'\n'+tmp[2]; 
	}
    dades+='&regenerar=1';
    dades+='&cupones='+cupones;

    }
	if (todos_cancelados==false)
		r=ajax.load('../../scripts/generar_pdf_cupon.php?'+dades+aleatorio);    
    //alert(r);   
//alert(r); 
    //eval(r);
    if (r.indexOf('error')!=-1) alert('Se ha producido un error al reenviar los cupones. Vuelva a intentarlo más tarde.');    
    else 
	{
		if (todos_cancelados)
			alert('No se ha podido enviar ningún cupón al cliente. '+sufijo);
		else
			alert('Los cupones han sido enviados a la dirección de correo del cliente. '+sufijo);
	}	
    //id_('lista_historial_clientes').innerHTML = r;  
    //$.colorbox({width:"80%", inline:true, href:"#lista_historial_clientes",open:true}); 
  }  
  
  /*
function envia_cupones(id_usuario,id_oferta_hist,cupones)
  {
    var aleatorio='&gg'+(Math.floor(Math.random()*50000))+'=1';
    var sufijo = ''; 
    dades='id_usuario='+id_usuario;
    dades+='&id_oferta_hist='+id_oferta_hist;
    dades+='&cupones='+cupones;
    dades+='&regenerar=1';
    
    r=ajax.load('<?php echo($base_scripts);?>validar_cupones_cancelados.php?id_oferta_hist='+id_oferta_hist+'&cupones='+cupones+aleatorio);       
    var tmp = r.split('#');
    if (r.indexOf('OK')==-1) sufijo='\n\n'+tmp[0]+'\n'+tmp[1];  
    r=ajax.load('../../scripts/generar_pdf_cupon.php?'+dades+aleatorio);    
    //alert(r);   
//alert(r);
    //eval(r);
    if (r.indexOf('error')!=-1) alert('Se ha producido un error al reenviar los cupones. Vuelva a intentarlo más tarde.');    
    else alert('Los cupones han sido enviados a la dirección de correo del cliente. '+sufijo);
    //id_('lista_historial_clientes').innerHTML = r;  
    //$.colorbox({width:"80%", inline:true, href:"#lista_historial_clientes",open:true}); 
  }  
 */

//Esta función se encarga de listar todos los clientes.    
function get_lista_clientes(orden,direccion,filtro,registro_inicial,nregistros_pagina,compra_cliente)                             
   {       
    //orden -> 0: por id de usuario, 1: por nombre y apellidos.   
	if (filtro==undefined) filtro='';
	if (compra_cliente==undefined) compra_cliente=0;
    var aleatorio='&gg'+(Math.floor(Math.random()*50000))+'=1'
    var r=ajax.load('<?php echo $base_scripts ?>clientes.php?compra_cliente='+compra_cliente+'&orden='+orden+'&direccion='+direccion+'&filtro='+filtro+'&registro_inicio='+registro_inicial+'&nregistros_pagina='+nregistros_pagina+aleatorio);  
    //alert (r);
    id_('lista_clientes').innerHTML = r;         
    id_('direccion_orden').value=direccion;
    id_('orden').value=orden;
   }                         

/*function get_lista_clientes(orden,direccion)
   {
    //orden -> 0: por id de usuario, 1: por nombre y apellidos.   
    var aleatorio='&gg'+(Math.floor(Math.random()*50000))+'=1'
    var r=ajax.load('<?php echo $base_scripts ?>clientes.php?orden='+orden+'&direccion='+direccion+aleatorio);  
    //alert (r);
    id_('lista_clientes').innerHTML = r;         
    id_('direccion_orden').value=direccion;
    id_('orden').value=orden;
   }   
*/
//Esta función responde a los botones para cambiar el orden de la lista de campañas.
function cambiar_posicion_oferta(posicion,direccion,id_oferta_hist)
  {
    var aleatorio='&gg'+(Math.floor(Math.random()*50000))+'=1'
    dades = 'id_oferta_hist='+id_oferta_hist;
    dades += '&posicion='+posicion;
    dades += '&direccion='+direccion;
	//alert('<?php echo($base_scripts);?>ajax_ofertas_bd.php?reposicionar=1&tipo_oferta='+campana_activa+'&'+dades+aleatorio);
    var r=ajax.load('<?php echo($base_scripts);?>ajax_ofertas_bd.php?reposicionar=1&tipo_oferta='+campana_activa+'&'+dades+aleatorio);
    //alert(r);       
    get_lista_ofertas(campana_activa);
  }  

//Esta función responde a los botones para cambiar el orden de las ofertas creadas.
function cambiar_posicion_oferta_creada(posicion,direccion,id_oferta)
  {
    var aleatorio='&gg'+(Math.floor(Math.random()*50000))+'=1'
    dades = 'id_oferta='+id_oferta;
    dades += '&posicion='+posicion;
    dades += '&direccion='+direccion;
    var r=ajax.load('<?php echo($base_scripts);?>ajax_ofertas_bd.php?reposicionar_creada=1&tipo_oferta='+filtro_oferta_activo+'&tipo_servicio='+filtro_servicio_activo+'&'+dades+aleatorio);
    //alert(r);       
    get_lista_ofertas_creadas();
  }  


//Esta función se encarga de listar todos las ofertas.
function get_lista_ofertas(filtro_camp,filtro_servicio) //filtro_camp: filtro para las campañas (1:capañas día, 2:campañas inactivas, 3:campañas VIP).
   {

    var filtro='';
	if (filtro_camp!=undefined) {campana_activa=filtro_camp;filtro=filtro_camp;}
	else {filtro=campana_activa;}
    
    var filtro2='';
	if (filtro_servicio!=undefined) {filtro_servicio_activo_camp=filtro_servicio;filtro2=filtro_servicio;}
	else {filtro2=filtro_servicio_activo_camp;}

	var filtros = '&filtro_camp='+filtro+'&tipo_servicio='+filtro2;
	
	
    var aleatorio='&gg'+(Math.floor(Math.random()*50000))+'=1'
	var r=ajax.load('<?php echo $base_scripts ?>ofertas.php?creadas=0'+filtros+aleatorio);  
    //var r=ajax.load('<?php echo $base_scripts ?>ofertas.php?creadas=0&filtro_camp='+filtro+aleatorio);  
    id_('lista_ofertas').innerHTML = r;         
	var boton_menu='';
	var sufijo='';
	switch(campana_activa)
	{
		case 0:
			boton_menu='camp_todas';
			sufijo='';
			break;
		case 1:
			boton_menu='camp_dia';
			sufijo='d';
			break;
		case 2:
			boton_menu='camp_inactivas';
			sufijo='i';
			break;
		case 3:
			boton_menu='camp_vip';
			sufijo='v';
			break;
		default:
			boton_menu='camp_todas';
			sufijo='';
	}
	//alert('11');
    mostrar_ocultar_elementos_menu_camp(boton_menu);
	//alert('22');
	
	//var maxId = setTimeout(function(){}, 0);
	/*if (timer_ofertas_primero!=-1)
	{
		for(var rr=timer_ofertas_primero; rr < maxId; rr+=1) 
		{ 
			clearTimeout(rr);
		}	
	}*/

	//window.clearTimeout(timer_ofertas);
   iniciar_contador(sufijo);
}   

function GetCount(ddate,ddatenow,iid,indice,cliente_especial,periodo_automatico){

	//alert(1);
     //clearTimeout(timer_of);
	 //alert(2);

    //alert('ddate '+ddate+' ddatenow '+ddatenow);
    var dateNow = new Date(ddatenow.substr(6,4),ddatenow.substr(3,2)-1,ddatenow.substr(0,2),ddatenow.substr(11,2),ddatenow.substr(14,2),ddatenow.substr(17,2));
    var date = new Date(ddate.substr(6,4),ddate.substr(3,2)-1,ddate.substr(0,2),ddate.substr(11,2),ddate.substr(14,2),ddate.substr(17,2));

    amount = date.getTime() - dateNow.getTime();
//alert(iid+indice+'-'+id_('idofertas'+indice).value);
    if(amount < 0 && !marcado){
		window.clearTimeout(timer_ofertas);
        //document.getElementById(iid+idoferta).innerHTML="Oferta Caducada";
        if (cliente_especial!=1 && periodo_automatico!=1)
        {
        id_('titulo_estado_oferta'+indice).className='boton_oferta_caducada';
        id_('estado_oferta'+indice).innerHTML='Inactiva';
        id_('activa_ofertas'+indice).value='';
        }
        var r=ajax.load('<?php echo($base_scripts);?>ajax_ofertas_bd.php?marcar_oferta_caducada=1&id_oferta='+id_('idofertas'+indice).value+'&id_oferta_hist='+id_('idofertash'+indice).value+'&cliente_especial='+cliente_especial+'&periodo_automatico='+periodo_automatico);   
        //vista('ofertas');
		get_lista_ofertas();
	    marcado=1;
        if (cliente_especial==1 || periodo_automatico==1)
        {
            fechas=r.split('#');   
            ddateNew =  fechas[0];  
            ddatenowNew = fechas[1];
            ddateNew = ddateNew.replace(/^\s*|\s*$/g,"");           
            ddatenowNew = ddatenowNew.replace(/^\s*|\s*$/g,"");         
            GetCount(ddateNew,ddatenowNew,iid,indice,cliente_especial,periodo_automatico);     
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
		//alert(iid+' '+indice+' Quedan '+out+' date '+ddate+' datenow '+ddatenow);      
        
        dateNow.setTime(dateNow.getTime()+1000);  
        var dateNow2 = format(dateNow.getDate())+'/'+format(dateNow.getMonth()+1)+'/'+dateNow.getFullYear()+' '+format(dateNow.getHours())+':'+format(dateNow.getMinutes())+':'+format(dateNow.getSeconds());
        var date2 = format(date.getDate())+'/'+format(date.getMonth()+1)+'/'+date.getFullYear()+' '+format(date.getHours())+':'+format(date.getMinutes())+':'+format(date.getSeconds());
       

        //timer_ofertas=setTimeout("GetCount('"+date2+"','"+dateNow2+"','"+iid+"','"+indice+"',"+cliente_especial+")", 1000);
		timer_ofertas=setTimeout("GetCount('"+date2+"','"+dateNow2+"','"+iid+"','"+indice+"',"+cliente_especial+","+periodo_automatico+")", 1000);
		//alert(timer_ofertas);
        delete dateNow;

    }
//    setTimeout("GetCount("+1+")", 1000);
  
}

function format(number)
{
    if (number<10) return '0'+number;
    else return number;
}


function iniciar_contador(sufijo)
{
marcado=0;
dateNow = ajax.load('<?php echo($base_scripts);?>ajax_fecha_actual.php');
dateNowTmp = dateNow;   


for(var i=0;i<id_('num_ofertas').value;i++)
{
    var per_automatico=0;
	if(id_('activa_ofertas'+i).value=='1')
    {

		if (id_('periodo_automatico_ofertas'+i).value==1) per_automatico=1;
		else per_automatico=0;
		/*if (id_('idofertash'+i).value=='14')
			{
			//alert('aki');
			dateNow = '17/01/2013 23:59:50';
			}
	    else */dateNow = dateNowTmp;
		var fecha_futura = id_('fecha_ofertas'+i).value;
        //new Date(fecha.substr(6,4),fecha.substr(3,2)-1,fecha.substr(0,2),fecha.substr(11,2),fecha.substr(14,2),fecha.substr(17,2));       
		timer_ofertas_primero = setTimeout("GetCount('"+fecha_futura+"','"+dateNow+"','tiempo_limite"+sufijo+"','"+i+"',"+id_('especiales_ofertas'+i).value+","+per_automatico+")", 1000);		
		
		//GetCount(fecha_futura,dateNow,'tiempo_limite',i,id_('especiales_ofertas'+i).value);
    }

 }
}     


function get_lista_ofertas_creadas(filtro_oferta,filtro_servicio)
   {
  
    var filtro1='';
	if (filtro_oferta!=undefined) {filtro_oferta_activo=filtro_oferta;filtro1=filtro_oferta;}
	else {filtro1=filtro_oferta_activo;}

    var filtro2='';
	if (filtro_servicio!=undefined) {filtro_servicio_activo=filtro_servicio;filtro2=filtro_servicio;}
	else {filtro2=filtro_servicio_activo;}

	var filtros = '&tipo_oferta='+filtro1+'&tipo_servicio='+filtro2;
  
    var aleatorio='&gg'+(Math.floor(Math.random()*50000))+'=1';

    var r=ajax.load('<?php echo $base_scripts ?>ofertas.php?creadas=1'+filtros+aleatorio);  
//alert(r);
    id_('lista_ofertas').innerHTML = r;       

	var boton_menu='';
	switch(filtro_oferta_activo)
	{
		case 1:
			boton_menu='ofertas_normales';
			break;
		case 2:
			boton_menu='ofertas_vip';
			break;
		default:
			boton_menu='ofertas_todas';
	}
	mostrar_ocultar_elementos('ofertas_creadas','<?php echo($tipo);?>');
	ocultar_menu_campanas();
	ocultar_menu_ofertas_creadas();
	mostrar_ocultar_elementos_menu_ofertas(boton_menu);	
   }   


function edita_menu_oferta(id_oferta,periodo,tipo,cliente_especial,hcc,GT,periodo_automatico)  
{
  //alert('m:'+motorclub+'d:'+dreamcars+'h:'+hcc);
  ocultar_lista_ofertas();
  mostrar_menu_ofertas_creadas();
  id_('id_oferta').value=id_oferta;   
  id_('periodo').value=periodo;
  id_('cliente_especial').value=cliente_especial;
  //alert(codigo_empresa+'aaa');

   if (hcc != undefined)
	{
		if (hcc==1) id_('menu_hcc').value=1;
		else id_('menu_hcc').value=0;
	}
   if (GT != undefined)
	{
		if (GT==1) id_('menu_GT').value=1;
		else id_('menu_GT').value=0;
	}

	
   if (periodo_automatico != undefined)
	{
		if (periodo_automatico==1) {id_('periodo_automatico').value=1;id_('cperiodo_automatico').checked=true;}
		else {id_('periodo_automatico').value=0;id_('cperiodo_automatico').checked=false;}
	}



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
function cupones_usados_ofertas(id_oferta,creadas)
  {
    var aleatorio='&gg'+(Math.floor(Math.random()*50000))+'=1'; 
    dades='id_oferta='+id_oferta;
    //creadas=0 significa que estamos mostrando el registro de ofertas (campañas). con lo que el id_oferta
    //será en realidad el id del histórico (id_oferta_hist).
    dades=dades+'&creadas='+creadas;
  //   alert(1);

    r=ajax.load('<?php echo $base_scripts ?>cupones_ofertas.php?'+dades+aleatorio);      
//alert(r);
    //eval(r);
    if (r.indexOf('No se han encontrado cupones')!=-1) r = " <div style='font-weight:bold;color:red;font-size:18px;'>No existen cupones para esta oferta</div>";    
    id_('lista_cupones_ofertas').innerHTML = r;  
    $.colorbox({width:"80%", inline:true, href:"#lista_cupones_ofertas",open:true}); 
    var cbclose = $.colorbox.close;
    $.colorbox.close = function ()
    {
        id_('titulo_formulario_oferta').innerHTML='';
        mostrar_ocultar_elementos('ofertas');
        get_lista_ofertas();
        id_('edicio_oferta').value = '';
        $.colorbox.close = cbclose;
        cbclose();
    }
    //
    //Recargamos la lista de campañas.
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
   // alert (dades);
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


function borrar_cliente(id)
{
    
   var aleatorio='&gg'+(Math.floor(Math.random()*50000))+'=1'; 
    
   dades='id_cliente='+id;
   dades+='&operacion=borrar';
   dades+='&orden='+id_('orden').value;     
   dades+='&direccion='+id_('direccion_orden').value;     
        
   
 
   if (!confirm('Está seguro de que desea eliminar este cliente?')) 
   {
       return;
   }
   else 
   {
       id_('frm_validar_password').reset();
       id_('archivo_operacion').value= 'ajax_clientes.php'
       id_('archivo_retorno').value = 'clientes.php';
       id_('div_retorno').value= 'lista_clientes';
       id_('ancho_div_retorno').value = 80;
       id_('datos').value = dades;
                        
       $.colorbox({width:"42%", inline:true, href:"#form_validar_password",open:true}); 
       return;          
   }
}


//Función complementaria a validar cupón. Se ejecuta desde el formulario de contraseñas
//cuando tratamos de desbloquear un cheque.
function envia_formulario_desbloquear_cupon_oferta(id_oferta,ncupon,password,creadas)
  {
    if (password=='') {alert('Debe introducir la contraseña');return;}      
    var aleatorio='&gg'+(Math.floor(Math.random()*50000))+'=1'

    var dades = 'password='+id_('password_dc').value; //el código alfa será único.
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
} 


function buscar_cliente_oferta(texto)
{

}


function envia_formulario_usuario()
  {
    var ale='&gg'+(Math.floor(Math.random()*50000))+'=1'
    var dades=obtenirDadesForm('form_alta_usuario');
    dades = dades+'&sexoh='+ (id_('sexoh').checked?'1':'0');
    if (id_('nombre').value==''){alert('Debe introducir el nombre del usuario');return;}
    if (id_('apellidos').value==''){alert('Debe introducir los apellidos del usuario');return;}
    if (id_('email_oferta').value==''){alert('Debe introducir el email del usuario');return;}
    r=ajax.load('<?php echo $base_scripts ?>ajax_usuarios.php?modifica_usuario=1&'+dades+ale);
   //alert(r);
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
  else 
    id_('lista_clientes').style.display='block';  
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
      if (id_oferta != 0)
        abrir_lista_cupones_oferta(id_oferta);
      else
//        abrir_lista_clientes(id_('orden').value,id_('direccion_orden').value);
        
//      $.colorbox.close=cbclose;
      ocultar_form_usuarios_oferta();
      cbclose();
   }

  return;          
  
  
  }

function abrir_lista_clientes(orden,direccion)
{
  var ale='&gg'+(Math.floor(Math.random()*50000))+'=1';
  dades= 'orden='+orden+'&direccion='+direccion;
  r=ajax.load('<?php echo $base_scripts ?>clientes.php?'+dades+ale);  
  $.colorbox.close = cbclose;    
  id_('lista_clientes').innerHTML = r;  
}

function abrir_lista_cupones_oferta(id_oferta)
{
  ocultar_form_usuarios_oferta();
  var ale='&gg'+(Math.floor(Math.random()*50000))+'=1';
  $.colorbox({width:"80%", inline:true, href:"#lista_cupones_ofertas",open:true}); 
  dades= 'id_oferta='+id_oferta;
  r=ajax.load('<?php echo $base_scripts ?>cupones_ofertas.php?'+dades+ale);  
  $.colorbox.close = cbclose;    
  id_('lista_cupones').innerHTML = r;  

}


function mover_a_cupon()
{
	window.location = '#cupon_marcado'; 
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
                    //height: "auto",
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


  