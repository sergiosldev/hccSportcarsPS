function canvia_ciudad_hotel(t) 
{  
  ciudad_auxh=t;
  aux_th=t
  if(aux_th=='') aux_th='Barcelona';
        

/*
  if (t=='rutas_turisticas') tipus_ev = 'ferrari_ruta_turistica1'; 	//tipo por defecto.
  else tipus_ev='ferrari';
  */
	  
  var ciudades = new Array('barcelona','madrid','valencia','andalucia','cantabria','zaragoza','rutas_turisticas');        
  
  for (var i = 0;i<ciudades.length;i++)
  {
	if (aux_th.toLowerCase()==ciudades[i]) 
		{
			//id_('ciudad_'+ciudades[i]+'h').className='boton_menu menu_activo';
			$('#'+'ciudad_'+ciudades[i]+'h').addClass("boton_menu menu_activo");  
		
		}
	else 
		{
			$('#'+'ciudad_'+ciudades[i]+'h').removeClass();
			$('#'+'ciudad_'+ciudades[i]+'h').addClass("boton_menu");
		}
  }
 
  
  if (aux_th.toLowerCase()=='rutas_turisticas')
	  {
	  	$('#grupo_tipo_eventos_turisticos').css('display','block');
	  	$('#grupo_tipo_eventos').css('display','none');
	  }
  else
  {
	  	$('#grupo_tipo_eventos_turisticos').css('display','none');
	  	$('#grupo_tipo_eventos').css('display','block');
	  }
    
  id_('ciudad_info_ph').innerHTML =aux_th;
    
  id_('calendarih').innerHTML = cridah(v_mesh, v_anoh);
        
  dia_selh=v_anoh+'-'+v_mesh+'-01';
  //if(dia_selh!='') get_hoteles(dia_selh);  
  click_diah(dia_selh);
  //mostrar_hotel_defecto(ciudad_auxh);     
}
 
               
function mesh(a) 
{
  if(a=='+')v_mesh++;
  else v_mesh--;

  if(v_mesh<1){v_mesh=12;v_anoh--}
  if(v_mesh>12){v_mesh=1;v_anoh++}
  id_('calendarih').innerHTML=cridah(v_mesh,v_anoh);
  id_('listado_hoteles').innerHTML='';
  id_('header_hoteles').style.display='none';  
}

function anoh(a) { 
  if(a=='+')v_anoh++;
  else v_anoh--;
  id_('calendarih').innerHTML=cridah(v_mesh,v_anoh)
  id_('listado_hoteles').innerHTML=''; 
  id_('header_hoteles').style.display='none';  
}
function ocultar_listado_hoteles(){
	id_('listado_hoteles').style.display='none';
}

function mostrar_listado_hoteles(){
	id_('listado_hoteles').style.display='block';
}

function id_(id) {
	  return document.getElementById(id);
	}
