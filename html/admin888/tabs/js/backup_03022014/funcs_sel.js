function canvia_tipus_sel(t) {
  tipus_ev_sel = t;

//**  id_('calendari_sel').innerHTML = crida_sel(v_mes_sel, v_ano_sel) 
//**  if(dia_sel!='')get_graella_sel(dia_sel)
  /* mts 21/04/2012  se incluye la variable nombre_ciudad para imagen ferrari */
  nombre_ciudad = id_('ciudad_info_p_sel').innerHTML;
  var clase='';
  var tipus_arr = new Array('ferrari','_bferrari_','lamborghini','_blamborghini_','_buggy_','_porsche_','_bporsche_');
  for (var i = 0;i<tipus_arr.length;i++)
  {
	if (tipus_arr[i]=='ferrari' ||tipus_arr[i]=='_bferrari_' ||tipus_arr[i]=='_bporsche_' || tipus_arr[i]=='_porsche_') clase='boton_mediano';
	else if (tipus_arr[i]=='lamborghini' || tipus_arr[i]=='_blamborghini_') clase='boton_grande';
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
  switch(t){
	case 'ferrari':
	/* mts 21042012, modif. para que la imagen del ferrari para madrid sea distinta */
	   /*if (nombre_ciudad=='madrid')
	   	id_('tipus_img').innerHTML='<img style="padding:4px;border:1px solid #000" width="100px" alt="" src="../../img/c/7.jpg">';
	   else*/	
	   	id_('tipus_img_sel').innerHTML='<img style="padding:4px;border:1px solid #000" width="100px" alt="" src="../../img/c/8.jpg">';

	break;
	case 'lamborghini':
	   id_('tipus_img_sel').innerHTML='<img style="padding:4px;border:1px solid #000" width="100px" alt="" src="../../img/c/12.jpg">';
	break;
	case '_porsche_':
	   id_('tipus_img_sel').innerHTML='<img style="padding:4px;border:1px solid #000" width="100px" alt="" src="../../img/c/9.jpg">';
	break;
	case '_bporsche_':
	   id_('tipus_img_sel').innerHTML='<img style="padding:4px;border:1px solid #000" width="100px" alt="" src="../../img/c/bporsche.jpg">';
	break;
/*	case '_lotus_':
	   id_('tipus_img_sel').innerHTML='<img style="padding:4px;border:1px solid #000" width="100px" alt="" src="../../img/c/10.jpg">';
	break;*/
	case '_bferrari_':
     id_('tipus_img_sel').innerHTML='<img style="padding:4px;border:1px solid #000" width="100px" alt="" src="../../img/c/bferrari430.jpg">';
  break;
  case '_blamborghini_':
     id_('tipus_img_sel').innerHTML='<img style="padding:4px;border:1px solid #000" width="100px" alt="" src="../../img/c/blamborghini.jpg">';
  break;
  // BUGGY
  case '_buggy_':
     id_('tipus_img_sel').innerHTML='BUGGY';
  break;
  }
}

function canvia_ciudad_sel(t) {
  ciudad_aux_sel=t;
 
  aux_t=t
  if(aux_t=='')aux_t='Barcelona'
  var ciudades = new Array('barcelona','madrid','valencia','andalucia','cantabria');
  for (var i = 0;i<5;i++)
  {
	if (aux_t.toLowerCase()==ciudades[i]) id_('ciudad_'+ciudades[i]).className='boton_menu menu_activo';
	else id_('ciudad_'+ciudades[i]).className='boton_menu';
  }

  id_('ciudad_info_p_sel').innerHTML =aux_t
  //**id_('calendari_sel').innerHTML = crida_sel(v_mes_sel, v_ano_sel)
  
  //**if(dia_sel!='')get_graella_sel(dia_sel)

  /* mts 21042012, modif para que nos actualice la imagen de ferrari según la ciudad seleccionada */
  if (tipus_ev_sel  == 'ferrari') {
   /*if (aux_t=='madrid')
   id_('tipus_img').innerHTML='<img style="padding:4px;border:1px solid #000" width="100px" alt="" src="../../img/c/7.jpg">';
   else*/	
   	id_('tipus_img_sel').innerHTML='<img style="padding:4px;border:1px solid #000" width="100px" alt="" src="../../img/c/8.jpg">';

  }
  /* fin modif mts. */
}
   
function mes_sel(a,ciudad,tipo) {
  if(a=='+')v_mes_sel++;
  else v_mes_sel--;

  if(v_mes_sel<1){v_mes_sel=12;v_ano_sel--}
  if(v_mes_sel>12){v_mes_sel=1;v_ano_sel++}
  id_('calendari_sel').innerHTML=crida_sel(v_mes_sel,v_ano_sel,ciudad,tipo)
  id_('graella_sel').innerHTML=''
  id_('header_graella_sel').style.display='none';  
}

function id_(id) {
  return document.getElementById(id);
}

function ano_sel(a,ciudad,tipo) { 
  if(a=='+')v_ano_sel++;
  else v_ano_sel--;
  id_('calendari_sel').innerHTML=crida_sel(v_mes_sel,v_ano_sel,ciudad,tipo)
  id_('graella_sel').innerHTML='' 
  id_('header_graella_sel').style.display='none';  
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
