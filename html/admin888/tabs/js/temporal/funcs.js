function canvia_tipus(t) {
  tipus_ev = t;
  id_('calendari').innerHTML = crida(v_mes, v_ano)
  if(dia_sel!='')get_graella(dia_sel)
  /* mts 21/04/2012  se incluye la variable nombre_ciudad para imagen ferrari */
  nombre_ciudad = id_('ciudad_info_p').innerHTML;
  var clase='';
  //'_lotus_'
  if ($('#ciudad_rutas_turisticas').attr('class')!='boton_menu menu_activo')
	  {
	  	var tipus_arr = new Array('ferrari','_bferrari_','lamborghini','_blamborghini_','_buggy_','_porsche_','_bporsche_','_corvette_','_bcorvette_');
	  }
  else
  	 {
	  	var tipus_arr = new Array('ferrari_ruta_turistica1','ferrari_ruta_turistica2','ferrari_ruta_turistica3','ferrari_ruta_turistica4','lamborghini_ruta_turistica1','lamborghini_ruta_turistica2','lamborghini_ruta_turistica3','lamborghini_ruta_turistica4');
	  }
	  
  for (var i = 0;i<tipus_arr.length;i++)
  {
	if (tipus_arr[i]=='ferrari' ||tipus_arr[i]=='_bferrari_' ||tipus_arr[i]=='_bporsche_'  ||tipus_arr[i]=='_porsche_'||tipus_arr[i]=='_bcorvette_' ||tipus_arr[i]=='_corvette_') clase='boton_mediano';
	else if (tipus_arr[i]=='lamborghini' || tipus_arr[i]=='_blamborghini_') clase='boton_grande';
	else if (tipus_arr[i].indexOf('ferrari_ruta')!=-1 ||tipus_arr[i].indexOf('lamborghini_ruta')!=-1) clase='boton_grande2';
	else clase='boton_small';

	if (t==tipus_arr[i]) 
	{		
	id_(tipus_arr[i]).className='boton_menu_tipo '+clase+' menu_activo';
	}
	else 
	{
	id_(tipus_arr[i]).className='boton_menu_tipo '+clase;
    }
  }


  /** fin mts */

  
  if ($('#ciudad_rutas_turisticas').attr('class')!='boton_menu menu_activo')
  {
  switch(t){
		case 'ferrari':
		/* mts 21042012, modif. para que la imagen del ferrari para madrid sea distinta */
		   /*if (nombre_ciudad=='madrid')
		   	id_('tipus_img').innerHTML='<img style="padding:4px;border:1px solid #000" width="100px" alt="" src="../../img/c/7.jpg">';
		   else*/	
		   	id_('tipus_img').innerHTML='<img style="padding:4px;border:1px solid #000" width="100px" alt="" src="../../img/c/8.jpg">';
	
		break;
		case 'lamborghini':
		   id_('tipus_img').innerHTML='<img style="padding:4px;border:1px solid #000" width="100px" alt="" src="../../img/c/12.jpg">';
		break;
		case '_porsche_':
		   id_('tipus_img').innerHTML='<img style="padding:4px;border:1px solid #000" width="100px" alt="" src="../../img/c/9.jpg">';
		break;
		case '_bporsche_':
		   id_('tipus_img').innerHTML='<span style="display:inline-block;float:left;position:relative;top:22px;left:10px;color:#ffffff;font-weight:bold;">Bautismo</span><img style="padding:4px;border:1px solid #000" width="100px" alt="" src="../../img/c/bporsche.jpg">';
		break;
		case '_corvette_':
			   id_('tipus_img').innerHTML='<img style="padding:4px;border:1px solid #000" width="100px" alt="" src="../../img/c/corvette.jpg">';
			break;
		case '_bcorvette_':
			   id_('tipus_img').innerHTML='<span style="display:inline-block;float:left;position:relative;top:22px;left:10px;color:#ffffff;font-weight:bold;">Bautismo</span><img style="padding:4px;border:1px solid #000" width="100px" alt="" src="../../img/c/bcorvette.jpg">';
			break;
		case '_lotus_':
		   id_('tipus_img').innerHTML='<img style="padding:4px;border:1px solid #000" width="100px" alt="" src="../../img/c/10.jpg">';
		break;
		case '_bferrari_':
	     id_('tipus_img').innerHTML='<span style="display:inline-block;float:left;position:relative;top:22px;left:10px;color:#ffffff;font-weight:bold;">Bautismo</span><img style="padding:4px;border:1px solid #000" width="100px" alt="" src="../../img/c/bferrari430.jpg">';
	  break;
	  case '_blamborghini_':
	     id_('tipus_img').innerHTML='<span style="display:inline-block;float:left;position:relative;top:22px;left:10px;color:#ffffff;font-weight:bold;">Bautismo</span><img style="padding:4px;border:1px solid #000" width="100px" alt="" src="../../img/c/blamborghini.jpg">';
	  break;
	  // BUGGY
	  case '_buggy_':
	     id_('tipus_img').innerHTML='BUGGY';
	  break;
   }
  }
 else
  {
  switch(t)
   {
	  case 'ferrari_ruta_turistica1':
	   	id_('tipus_img').innerHTML='<img style="padding:4px;border:1px solid #000" width="100px" alt="" src="../../img/c/8.jpg">';
	  break;
	  case 'ferrari_ruta_turistica2':
		   	id_('tipus_img').innerHTML='<img style="padding:4px;border:1px solid #000" width="100px" alt="" src="../../img/c/8.jpg">';
		  break;
	  case 'ferrari_ruta_turistica3':
		   	id_('tipus_img').innerHTML='<img style="padding:4px;border:1px solid #000" width="100px" alt="" src="../../img/c/8.jpg">';
		  break;
	  case 'ferrari_ruta_turistica4':
		   	id_('tipus_img').innerHTML='<img style="padding:4px;border:1px solid #000" width="100px" alt="" src="../../img/c/8.jpg">';
		  break;
	  case 'lamborghini_ruta_turistica1':
		   id_('tipus_img').innerHTML='<img style="padding:4px;border:1px solid #000" width="100px" alt="" src="../../img/c/12.jpg">';
		  break;
	  case 'lamborghini_ruta_turistica2':
		   id_('tipus_img').innerHTML='<img style="padding:4px;border:1px solid #000" width="100px" alt="" src="../../img/c/12.jpg">';
		  break;
	  case 'lamborghini_ruta_turistica3':
		   id_('tipus_img').innerHTML='<img style="padding:4px;border:1px solid #000" width="100px" alt="" src="../../img/c/12.jpg">';
		  break;
	  case 'lamborghini_ruta_turistica4':
		   id_('tipus_img').innerHTML='<img style="padding:4px;border:1px solid #000" width="100px" alt="" src="../../img/c/12.jpg">';
		  break;
   }  
	  	
  }	  
}
  
function canvia_tipus_2(t) {
  id_('tipus').value=t;
}
function canvia_ciudad(t) {
  ciudad_aux=t;
  aux_t=t
  if(aux_t=='')aux_t='Barcelona'
  
  if (t=='rutas_turisticas') tipus_ev = 'ferrari_ruta_turistica1'; 	//tipo por defecto.
  
  var ciudades = new Array('barcelona','madrid','valencia','andalucia','cantabria','rutas_turisticas');
  for (var i = 0;i<ciudades.length;i++)
  {
	if (aux_t.toLowerCase()==ciudades[i]) 
		{
			id_('ciudad_'+ciudades[i]).className='boton_menu menu_activo';
		}
	else 
		{
			id_('ciudad_'+ciudades[i]).className='boton_menu';
		}
  }

  
  if (aux_t.toLowerCase()=='rutas_turisticas')
	  {
	  	$('#grupo_tipo_eventos_turisticos').css('display','block');
	  	$('#grupo_tipo_eventos').css('display','none');
	  }
  else
  {
	  	$('#grupo_tipo_eventos_turisticos').css('display','none');
	  	$('#grupo_tipo_eventos').css('display','block');
	  }
  
  id_('ciudad_info_p').innerHTML =aux_t
 
  id_('calendari').innerHTML = crida(v_mes, v_ano)
  
  if(dia_sel!='')get_graella(dia_sel)

  /* mts 21042012, modif para que nos actualice la imagen de ferrari según la ciudad seleccionada */
  if (tipus_ev == 'ferrari') {
   /*if (aux_t=='madrid')
   id_('tipus_img').innerHTML='<img style="padding:4px;border:1px solid #000" width="100px" alt="" src="../../img/c/7.jpg">';
   else*/	
   	id_('tipus_img').innerHTML='<img style="padding:4px;border:1px solid #000" width="100px" alt="" src="../../img/c/8.jpg">';

  }
  /* fin modif mts. */
}

//Su explorador no soporta java o lo tiene deshabilitado; esta pagina necesita javascript para funcionar correctamente<!--
//Copyright © McAnam.com

function abrir(direccion, pantallacompleta, herramientas, direcciones, estado, barramenu, barrascroll, cambiatamano, ancho, alto, izquierda, arriba, sustituir){
     var opciones = "fullscreen=" + pantallacompleta +
                 ",toolbar=" + herramientas +
                 ",location=" + direcciones +
                 ",status=" + estado +
                 ",menubar=" + barramenu +
                 ",scrollbars=" + barrascroll +
                 ",resizable=" + cambiatamano +
                 ",width=" + ancho +
                 ",height=" + alto +
                 ",left=" + izquierda +
                 ",top=" + arriba;
     var ventana = window.open(direccion,"venta",opciones,sustituir);

}                    
//-->    
   
  
    
function mes(a) {
  if(a=='+')v_mes++;
  else v_mes--;

  if(v_mes<1){v_mes=12;v_ano--}
  if(v_mes>12){v_mes=1;v_ano++}
  id_('calendari').innerHTML=crida(v_mes,v_ano)
  id_('graella').innerHTML=''
  id_('alta').style.display="none"
  id_('header_graella').style.display='none';  
}
function id_(id) {
  return document.getElementById(id);
}

function ano(a) { 
  if(a=='+')v_ano++;
  else v_ano--;
  id_('calendari').innerHTML=crida(v_mes,v_ano)
  id_('graella').innerHTML='' 
  id_('header_graella').style.display='none';  
}
function ocultar_form() {
  id_('alta').style.display='none';
}
/* mts 01052012 */
function mostrar_form() {
  id_('alta').style.display='block';
}

function ocultar_form(){
	id_('alta').style.display='none';
}

function ocultar_form_busqueda_cupon_oferta(){
	id_('buscar_cupon_oferta').style.display='none';
	id_('form_busqueda_oferta').style.display='none';
}

function mostrar_form_busqueda_cupon_oferta(){
	
	id_('buscar_cupon_oferta').style.display='block';
	id_('form_busqueda_oferta').style.display='block';
}

function ocultar_form_busqueda_cliente(){
	id_('buscar_cliente_oferta').style.display='none';
	id_('form_busqueda_cliente').style.display='none';
}

function mostrar_form_busqueda_cliente(){
	
	id_('buscar_cliente_oferta').style.display='block';
	id_('form_busqueda_cliente').style.display='block';
}

function ocultar_form_busqueda_cupon(){
	id_('buscar_cupon').style.display='none';
	id_('form_busqueda').style.display='none';
}

function mostrar_form_busqueda_cupon(){
	
	id_('buscar_cupon').style.display='block';
	id_('form_busqueda').style.display='block';
}


function ocultar_form_fichero_cupones()   
{
	id_('listar_ficheros').style.display='none';
	id_('form_ficheros').style.display='none';
}	

function mostrar_form_fichero_cupones()
{
	id_('listar_ficheros').style.display='block';
	id_('form_ficheros').style.display='block';
}	

function print_g(_h_)
  {
  document.getElementById('gf').value=document.getElementById('graella').innerHTML;
  document.getElementById('hf').value=document.getElementById('header_graella').innerHTML;
  document.getElementById('horas').value=_h_
  document.getElementById('form_g').submit();	
 
 }
function print_pdf(_h_)
  {
  document.getElementById('gf_pdf').value=document.getElementById('graella').innerHTML;
  document.getElementById('hf_pdf').value=document.getElementById('header_graella').innerHTML;
  document.getElementById('horas_pdf').value=_h_
  document.getElementById('form_pdf').submit();	 
 }
 

/*
function checks_tipus(t)
  {
  	
  if(t=='ferrari'){
  	id_("coches_ferrari").style.display="inline"
    id_("coches_ferrari_porsche").style.display="inline"
	id_("coches_porsche").style.display="none"
	id_("coches_porsche_porsche").style.display="none"
	id_("cferrari").checked=true
	     }
  else if(t=='porsche'){
  	id_("coches_ferrari").style.display="none"
    id_("coches_ferrari_porsche").style.display="none"
	id_("coches_porsche").style.display="inline"
	id_("coches_porsche_porsche").style.display="inline"
	id_("cporsche").checked=true
  }	
	
  }
*/


/** mts 01052012. Sección Establecimientos **/
function ocultar_form_estab(){
	id_('alta').style.display='none';
}

function mostrar_form_estab(){
	id_('alta').style.display='block';
	id_('form_alta_estab').reset();
}


function ocultar_lista_estab(){
	id_('establecimientos').style.display='none';
}

function mostrar_lista_estab(){
	id_('establecimientos').style.display='block';
}



function ocultar_lista_talonarios(){
	id_('lista_talonarios').style.display='none';
}

function mostrar_lista_talonarios(){
	id_('lista_talonarios').style.display='block';
}


/** fin sección establecimientos **/

/** mts 30102012. Sección Ofertas **/  
function ocultar_form_oferta(){
	id_('alta_oferta').style.display='none';
}

function mostrar_form_oferta(){
	id_('alta_oferta').style.display='block';
	id_('form_alta_oferta').reset();
}

function ocultar_lista_clientes(){
	id_('lista_clientes').style.display='none';
}

function mostrar_lista_clientes(){
	id_('lista_clientes').style.display='block';
}

function ocultar_lista_distribuidores(){
	id_('lista_distribuidores').style.display='none';
}

function mostrar_lista_distribuidores(){
	id_('lista_distribuidores').style.display='block';
}


function mostrar_form_distribuidores_oferta(){
	//id_('lista_distribuidores').style.display='block';
}

function ocultar_form_distribuidores_oferta(){
	//id_('lista_ofertas').style.display='none';
}

function ocultar_lista_ofertas(){
	ocultar_menu_campanas();
	id_('lista_ofertas').style.display='none';
}


function mostrar_lista_ofertas(){
	mostrar_menu_campanas();
	id_('lista_ofertas').style.display='block';
}

function mostrar_menu_campanas(){
	id_('menu_campanas').style.display='block';
}

function ocultar_menu_campanas(){
	id_('menu_campanas').style.display='none';
}

function mostrar_menu_ofertas(){
	id_('menu_ofertas').style.display='block';
}

function ocultar_menu_ofertas(){
	id_('menu_ofertas').style.display='none';
}


function ocultar_menu_ofertas_creadas()
{
  id_('menu_ofertas_creadas').style.display="none";    
}

function mostrar_menu_ofertas_creadas()
{
  id_('menu_ofertas_creadas').style.display="block";    
}

function mostrar_form_activar_oferta()
{
  id_('activar_oferta').style.display="block";
}

function ocultar_form_activar_oferta()
{
  id_('activar_oferta').style.display="none";
}

function ocultar_form_usuarios_oferta(){
	id_('alta_usuario_oferta').style.display='none';
	id_('form_alta_usuario').style.display='none';
}

function mostrar_form_usuarios_oferta(){
	
	id_('alta_usuario_oferta').style.display='block';
	id_('form_alta_usuario').style.display='block';
}


function ocultar_inicio(){
	id_('form_inicio').style.display='none';
}

function mostrar_inicio(){
	id_('form_inicio').style.display='block';
}

function print_excel(listado)
  {
  if (listado=='i')
	get_graella_instructors();
  else if (listado=='todos')	//el listado tendrá las 2 rutas (7km+20km).
	get_graella_instructors_20km7km();
  //document.getElementById('form_excel').submit();	  
  }

function print_organizadores(listado)
  {
  get_graella_organizadores(listado);
  //document.getElementById('form_excel').submit();	  
  }

function print_organizadores_20km7km(listado)
  {
  get_graella_organizadores_20km7km();
  //document.getElementById('form_excel').submit();	  
  }
  
  
/** fin seccion ofertas **/