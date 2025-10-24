/*** CUPONES ALFA ONLINE ***/
function id_(id) {
  return document.getElementById(id);
}

function ocultar_form_oferta_ca(){
	id_('alta_oferta_ca').style.display='none';
}

function mostrar_form_oferta_ca(){
	id_('alta_oferta_ca').style.display='block';
	id_('form_alta_oferta_ca').reset();
}


function ocultar_lista_distribuidores_ca(){
	id_('lista_distribuidores_ca').style.display='none';
}

function mostrar_lista_distribuidores_ca(){
	id_('lista_distribuidores_ca').style.display='block';
}


function mostrar_form_distribuidores_oferta_ca(){
	id_('alta_distribuidor_oferta_ca').style.display='block';
}

function ocultar_form_distribuidores_oferta_ca(){
	id_('alta_distribuidor_oferta_ca').style.display='none';
}


function ocultar_form_busqueda_distribuidor_ca(){
	id_('buscar_distribuidor_oferta_ca').style.display='none';
	id_('form_busqueda_distribuidor_ca').style.display='none';
}

function mostrar_form_busqueda_distribuidor_ca(){
	
	id_('buscar_distribuidor_oferta_ca').style.display='block';
	id_('form_busqueda_distribuidor_ca').style.display='block';
}



function ocultar_lista_ofertas_ca(){
	id_('lista_ofertas_ca').style.display='none';
}


function mostrar_lista_ofertas_ca(){
	id_('lista_ofertas_ca').style.display='block';
}

function ocultar_menu_ofertas_creadas_ca()
{
  id_('menu_ofertas_creadas_ca').style.display="none";    
}

function mostrar_menu_ofertas_creadas_ca()
{
  id_('menu_ofertas_creadas_ca').style.display="block";    
}

function mostrar_form_activar_oferta_ca()
{
  id_('activar_oferta_ca').style.display="block";
}

function ocultar_form_activar_oferta_ca()
{
  id_('activar_oferta_ca').style.display="none";
}

function ocultar_form_busqueda_cupon_oferta_ca(){
	id_('buscar_cupon_oferta_ca').style.display='none';
	id_('form_busqueda_oferta_ca').style.display='none';
}

function mostrar_form_busqueda_cupon_oferta_ca(){
	
	id_('buscar_cupon_oferta_ca').style.display='block';
	id_('form_busqueda_oferta_ca').style.display='block';
}


/***************************/
