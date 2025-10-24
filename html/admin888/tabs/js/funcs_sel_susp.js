function canvia_tipus_sel_susp(t) {
  tipus_ev_sel_susp = t;

//**  id_('calendari_sel_susp').innerHTML = crida_sel_susp(v_mes_sel_susp, v_ano_sel_susp) 
//**  if(dia_sel_susp!='')get_graella_sel_susp(dia_sel_susp)
  /* mts 21/04/2012  se incluye la variable nombre_ciudad para imagen ferrari */
  nombre_ciudad = id_('ciudad_info_p_sel_susp').innerHTML;
  var clase='';
  var tipus_arr = new Array('ferrari','_bferrari_','lamborghini','_blamborghini_','_buggy_','_porsche_','_bporsche_');
  for (var i = 0;i<tipus_arr.length;i++)
  {
	if (tipus_arr[i]=='ferrari' ||tipus_arr[i]=='_bferrari_' ||tipus_arr[i]=='_bporsche_'  ||tipus_arr[i]=='_porsche_'||tipus_arr[i]=='_bcorvette_' ||tipus_arr[i]=='_corvette_') clase='boton_mediano';	else if (tipus_arr[i]=='lamborghini' || tipus_arr[i]=='_blamborghini_') clase='boton_grande';
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
	   	id_('tipus_img_sel_susp').innerHTML='<img style="padding:4px;border:1px solid #000" width="100px" alt="" src="../../img/c/8.jpg">';

	break;
	case 'lamborghini':
	   id_('tipus_img_sel_susp').innerHTML='<img style="padding:4px;border:1px solid #000" width="100px" alt="" src="../../img/c/12.jpg">';
	break;
	case '_porsche_':
	   id_('tipus_img_sel_susp').innerHTML='<img style="padding:4px;border:1px solid #000" width="100px" alt="" src="../../img/c/9.jpg">';
	break;
	case '_bporsche_':
	   id_('tipus_img_sel_susp').innerHTML='<span style="display:inline-block;float:left;position:relative;top:22px;left:32px;color:#ffffff;font-weight:bold;">Bautismo</span><img style="padding:4px;border:1px solid #000" width="100px" alt="" src="../../img/c/bporsche.jpg">';
	break;
	case '_corvette_':
		   id_('tipus_img').innerHTML='<img style="padding:4px;border:1px solid #000" width="100px" alt="" src="../../img/c/corvette.jpg">';
		break;
	case '_bcorvette_':
		   id_('tipus_img').innerHTML='<span style="display:inline-block;float:left;position:relative;top:22px;left:32px;color:#ffffff;font-weight:bold;">Bautismo</span><img style="padding:4px;border:1px solid #000" width="100px" alt="" src="../../img/c/bcorvette.jpg">';
		break;	
/*	case '_lotus_':
	   id_('tipus_img_sel_susp').innerHTML='<img style="padding:4px;border:1px solid #000" width="100px" alt="" src="../../img/c/10.jpg">';
	break;*/
	case '_bferrari_':
     id_('tipus_img_sel_susp').innerHTML='<span style="display:inline-block;float:left;position:relative;top:22px;left:32px;color:#ffffff;font-weight:bold;">Bautismo</span><img style="padding:4px;border:1px solid #000" width="100px" alt="" src="../../img/c/bferrari430.jpg">';
  break;
  case '_blamborghini_':
     id_('tipus_img_sel_susp').innerHTML='<span style="display:inline-block;float:left;position:relative;top:22px;left:32px;color:#ffffff;font-weight:bold;">Bautismo</span><img style="padding:4px;border:1px solid #000" width="100px" alt="" src="../../img/c/blamborghini.jpg">';
  break;
  // BUGGY
  case '_buggy_':
     id_('tipus_img_sel_susp').innerHTML='BUGGY';
  break;
  }
}

function canvia_ciudad_sel_susp(t) {
  ciudad_aux_sel_susp=t;
  aux_t=t
  if(aux_t=='')aux_t='Barcelona'
  var ciudades = new Array('barcelona','madrid','valencia','andalucia','cantabria');
  for (var i = 0;i<5;i++)
  {
	if (aux_t.toLowerCase()==ciudades[i]) id_('ciudad_'+ciudades[i]).className='boton_menu menu_activo';
	else id_('ciudad_'+ciudades[i]).className='boton_menu';
  }
  id_('ciudad_info_p_sel_susp').innerHTML =aux_t
  
  if (tipus_ev_sel_susp  == 'ferrari') 
  {
  id_('tipus_img_sel_susp').innerHTML='<img style="padding:4px;border:1px solid #000" width="100px" alt="" src="../../img/c/8.jpg">';
  }
  
  /* fin modif mts. */
}
   
function mes_sel_susp(a,ciudad,tipo) {
  if(a=='+')v_mes_sel_susp++;
  else v_mes_sel_susp--;

  if(v_mes_sel_susp<1){v_mes_sel_susp=12;v_ano_sel_susp--}
  if(v_mes_sel_susp>12){v_mes_sel_susp=1;v_ano_sel_susp++}
  id_('calendari_sel_susp').innerHTML=crida_sel_susp(v_mes_sel_susp,v_ano_sel_susp,ciudad,tipo)
  id_('graella_sel_susp').innerHTML=''
  id_('header_graella_sel_susp').style.display='none';  
}

function id_(id) {
  return document.getElementById(id);
}

function ano_sel_susp(a,ciudad,tipo) { 
  if(a=='+')v_ano_sel_susp++;
  else v_ano_sel_susp--;
  id_('calendari_sel_susp').innerHTML=crida_sel_susp(v_mes_sel_susp,v_ano_sel_susp,ciudad,tipo)
  id_('graella_sel_susp').innerHTML='' 
  id_('header_graella_sel_susp').style.display='none';  
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
