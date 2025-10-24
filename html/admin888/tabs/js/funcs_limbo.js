function canvia_tipus_limbo(t) 
{
  tipus_ev_limbo = t;
  //id_('calendari').innerHTML=calendario_limbo(v_mes_limbo,v_ano_limbo,ciudad_aux_limbo,tipus_ev_limbo);

//**  id_('calendari_limbo').innerHTML = crida_limbo(v_mes_limbo, v_ano_limbo) 
//**  if(dia_limbo!='')get_graella_limbo(dia_limbo)
  /* mts 21/04/2012  se incluye la variable nombre_ciudad para imagen ferrari */
  nombre_ciudad = id_('ciudad_info_limbo').innerHTML;
  id_('bloque_calendario').style.display='block';
  var clase='';
  
  /****/
  if ($('#ciudad_rutas_turisticas_limbo').attr('class')!='boton_menu menu_activo')
  {
  	var tipus_arr = new Array('ferrari','_bferrari_','lamborghini','_blamborghini_','_buggy_','_porsche_','_bporsche_','_corvette_','_bcorvette_','todo');
  }
  else
  {
  	var tipus_arr = new Array('ferrari_ruta_turistica1','ferrari_ruta_turistica2','ferrari_ruta_turistica3','ferrari_ruta_turistica4','lamborghini_ruta_turistica1','lamborghini_ruta_turistica2','lamborghini_ruta_turistica3','lamborghini_ruta_turistica4','todo');
  }
  
	for (var i = 0;i<tipus_arr.length;i++)
	{
	if (tipus_arr[i]=='ferrari' ||tipus_arr[i]=='_bferrari_' ||tipus_arr[i]=='_bporsche_'  ||tipus_arr[i]=='_porsche_'||tipus_arr[i]=='_bcorvette_' ||tipus_arr[i]=='_corvette_'||tipus_arr[i]=='todo') clase='boton_mediano';
	else if (tipus_arr[i]=='lamborghini' || tipus_arr[i]=='_blamborghini_') clase='boton_grande';
	else if (tipus_arr[i].indexOf('ferrari_ruta')!=-1 ||tipus_arr[i].indexOf('lamborghini_ruta')!=-1) clase='boton_grande2';
	else clase='boton_small';
	switch (tipus_arr[i].toString().substring(0,1))
	{
	case '_':
		sufijo = 'limbo_';
		break;
	default:
		sufijo = '_limbo';
	}
	if (t==tipus_arr[i]) 
	{		
	id_(tipus_arr[i]+sufijo).className='boton_menu_tipo '+clase+' menu_activo';
	}
	else 
	{
	id_(tipus_arr[i]+sufijo).className='boton_menu_tipo '+clase;
	}
	}
	
	
	/** fin mts */
	
	
	if ($('#ciudad_rutas_turisticas_limbo').attr('class')!='boton_menu menu_activo')
	{
	
	switch(t)
		{
		 case 'ferrari':
		/* mts 21042012, modif. para que la imagen del ferrari para madrid sea distinta */
		   /*if (nombre_ciudad=='madrid')
		   	id_('tipus_img_limbo').innerHTML='<img style="padding:4px;border:1px solid #000" width="100px" alt="" src="../../img/c/7.jpg">';
		   else*/	
		   	id_('tipus_img_limbo').innerHTML='<img style="padding:4px;border:1px solid #000" width="100px" alt="" src="../../img/c/8.jpg">';
	
		 break;
		 case 'lamborghini':
		   id_('tipus_img_limbo').innerHTML='<img style="padding:4px;border:1px solid #000" width="100px" alt="" src="../../img/c/12.jpg">';
		 break;
		 case '_porsche_':
		   id_('tipus_img_limbo').innerHTML='<img style="padding:4px;border:1px solid #000" width="100px" alt="" src="../../img/c/9.jpg">';
		 break;
		 case '_bporsche_':
		   id_('tipus_img_limbo').innerHTML='<span style="display:inline-block;float:left;position:relative;top:22px;left:10px;color:#ffffff;font-weight:bold;">Bautismo</span><img style="padding:4px;border:1px solid #000" width="100px" alt="" src="../../img/c/bporsche.jpg">';
		 break;
		 case '_corvette_':
			   id_('tipus_img_limbo').innerHTML='<img style="padding:4px;border:1px solid #000" width="100px" alt="" src="../../img/c/corvette.jpg">';
			break;
		 case '_bcorvette_':
			   id_('tipus_img_limbo').innerHTML='<span style="display:inline-block;float:left;position:relative;top:22px;left:10px;color:#ffffff;font-weight:bold;">Bautismo</span><img style="padding:4px;border:1px solid #000" width="100px" alt="" src="../../img/c/bcorvette.jpg">';
			break;
		 case '_lotus_':
			 id_('tipus_img_limbo').innerHTML='<img style="padding:4px;border:1px solid #000" width="100px" alt="" src="../../img/c/10.jpg">';
		 break;
		 case '_bferrari_':
			 id_('tipus_img_limbo').innerHTML='<span style="display:inline-block;float:left;position:relative;top:22px;left:10px;color:#ffffff;font-weight:bold;">Bautismo</span><img style="padding:4px;border:1px solid #000" width="100px" alt="" src="../../img/c/bferrari430.jpg">';
	     break;
		 case '_blamborghini_':
			 id_('tipus_img_limbo').innerHTML='<span style="display:inline-block;float:left;position:relative;top:22px;left:10px;color:#ffffff;font-weight:bold;">Bautismo</span><img style="padding:4px;border:1px solid #000" width="100px" alt="" src="../../img/c/blamborghini.jpg">';
	     break;
		 case 'todos':
			 id_('todo_limbo').innerHTML='<span style="display:inline-block;float:left;position:relative;top:22px;left:10px;color:#ffffff;font-weight:bold;">Todos</span>';
	     // BUGGY
		 case '_buggy_':
			 id_('tipus_img_limbo').innerHTML='BUGGY';
	     break;
		 case 'todo':
		 	 id_('tipus_img_limbo').innerHTML='TODOS';
			 id_('bloque_calendario').style.display='none';
		 break;
		}
	}
	else
	{
		switch(t)
		{
		  case 'ferrari_ruta_turistica1':
		   	id_('tipus_img_limbo').innerHTML='<img style="padding:4px;border:1px solid #000" width="100px" alt="" src="../../img/c/8.jpg">';
		  break;
		  case 'ferrari_ruta_turistica2':
			   	id_('tipus_img_limbo').innerHTML='<img style="padding:4px;border:1px solid #000" width="100px" alt="" src="../../img/c/8.jpg">';
			  break;
		  case 'ferrari_ruta_turistica3':
			   	id_('tipus_img_limbo').innerHTML='<img style="padding:4px;border:1px solid #000" width="100px" alt="" src="../../img/c/8.jpg">';
			  break;
		  case 'ferrari_ruta_turistica4':
			   	id_('tipus_img_limbo').innerHTML='<img style="padding:4px;border:1px solid #000" width="100px" alt="" src="../../img/c/8.jpg">';
			  break;
		  case 'lamborghini_ruta_turistica1':
			   id_('tipus_img_limbo').innerHTML='<img style="padding:4px;border:1px solid #000" width="100px" alt="" src="../../img/c/12.jpg">';
			  break;
		  case 'lamborghini_ruta_turistica2':
			   id_('tipus_img_limbo').innerHTML='<img style="padding:4px;border:1px solid #000" width="100px" alt="" src="../../img/c/12.jpg">';
			  break;
		  case 'lamborghini_ruta_turistica3':
			   id_('tipus_img_limbo').innerHTML='<img style="padding:4px;border:1px solid #000" width="100px" alt="" src="../../img/c/12.jpg">';
			  break;
		  case 'lamborghini_ruta_turistica4':
			   id_('tipus_img_limbo').innerHTML='<img style="padding:4px;border:1px solid #000" width="100px" alt="" src="../../img/c/12.jpg">';
			  break;
		 case 'todo':
		 	 id_('tipus_img_limbo').innerHTML='TODOS';
			 id_('bloque_calendario').style.display='none';
			 
		 break;		
		 }  
		  	
  }	

   mostrar_todos(ciudad_aux_limbo,tipus_ev_limbo);
  
}

function canvia_ciudad_limbo(t) 
{
  ciudad_aux_limbo=t;
 
  aux_t=t
  if(aux_t=='')aux_t='Barcelona'
  id_('bloque_calendario').style.display='block';
  var ciudades = new Array('barcelona','madrid','valencia','andalucia','cantabria','rutas_turisticas','todo');
  var sufijo = '_limbo';
  for (var i = 0;i<ciudades.length;i++)
  {
	if (aux_t.toLowerCase()==ciudades[i]) 
		{
			id_('ciudad_'+ciudades[i]+sufijo).className='boton_menu menu_activo';
		}
	else 
		{
			id_('ciudad_'+ciudades[i]+sufijo).className='boton_menu';
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
  
  id_('ciudad_info_limbo').innerHTML =aux_t
  
  id_('calendari_limbo').innerHTML = calendario_limbo(v_mes_limbo,v_ano_limbo,ciudad_aux_limbo,tipus_ev_limbo);
  
  //**if(dia_limbo!='')get_graella_limbo(dia_limbo)

  /* mts 21042012, modif para que nos actualice la imagen de ferrari según la ciudad seleccionada */
  if (tipus_ev_limbo  == 'ferrari') 
  {
   /*if (aux_t=='madrid')
   id_('tipus_img').innerHTML='<img style="padding:4px;border:1px solid #000" width="100px" alt="" src="../../img/c/7.jpg">';
   else*/	
   	id_('tipus_img_limbo').innerHTML='<img style="padding:4px;border:1px solid #000" width="100px" alt="" src="../../img/c/8.jpg">';

  }
  
  if (ciudad_aux_limbo=='todo')
  {
	id_('bloque_calendario').style.display='none';
  }
   mostrar_todos(ciudad_aux_limbo,tipus_ev_limbo);
  /* fin modif mts. */
}
   
function mes_limbo(a,ciudad,tipo) {
  if(a=='+')v_mes_limbo++;
  else v_mes_limbo--;

  if(v_mes_limbo<1){v_mes_limbo=12;v_ano_limbo--}
  if(v_mes_limbo>12){v_mes_limbo=1;v_ano_limbo++}

  id_('calendari_limbo').innerHTML=calendario_limbo(v_mes_limbo,v_ano_limbo,ciudad,tipo);
 
  //id_('registros_limbo').innerHTML=''
  //id_('header_graella_limbo').style.display='none';  
}

function id_(id) {
  return document.getElementById(id);
}

function ano_limbo(a,ciudad,tipo) { 
  if(a=='+')v_ano_limbo++;
  else v_ano_limbo--;
  id_('calendari_limbo').innerHTML=calendario_limbo(v_mes_limbo,v_ano_limbo,ciudad,tipo);
  //id_('header_graella_limbo').style.display='none';  
}
