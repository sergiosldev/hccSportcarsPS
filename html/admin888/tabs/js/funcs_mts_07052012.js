function canvia_tipus(t)
  {
  tipus_ev = t;
  id_('calendari').innerHTML = crida(v_mes, v_ano)
  if(dia_sel!='')get_graella(dia_sel)
  /* mts 21/04/2012  se incluye la variable nombre_ciudad para imagen ferrari */
  nombre_ciudad = id_('ciudad_info_p').innerHTML;
  /** fin mts */
  switch(t){
  	case 'porsche996':
	   id_('tipus_img').innerHTML='<img style="padding:4px;border:1px solid #000" width="100px" alt="" src="../../img/c/9.jpg">';
	break;
	case 'ferrari':
	/* mts 21042012, modif. para que la imagen del ferrari para madrid sea distinta */
	   if (nombre_ciudad=='madrid')
	   	id_('tipus_img').innerHTML='<img style="padding:4px;border:1px solid #000" width="100px" alt="" src="../../img/c/7.jpg">';
	   else	
	   	id_('tipus_img').innerHTML='<img style="padding:4px;border:1px solid #000" width="100px" alt="" src="../../img/c/8.jpg">';

	break;
	case 'lamborghini':
	   id_('tipus_img').innerHTML='<img style="padding:4px;border:1px solid #000" width="100px" alt="" src="../../img/c/12.jpg">';
	break;
	case '_porsche_':
	   id_('tipus_img').innerHTML='<img style="padding:4px;border:1px solid #000" width="100px" alt="" src="../../img/c/9.jpg">';
	break;
	case '_lotus_':
	   id_('tipus_img').innerHTML='<img style="padding:4px;border:1px solid #000" width="100px" alt="" src="../../img/c/10.jpg">';
	break;
  }
  
  
  }
function canvia_tipus_2(t){
  id_('tipus').value=t;
  }
function canvia_ciudad(t){
  ciudad_aux=t;
  
  aux_t=t
  if(aux_t=='')aux_t='Barcelona'
  

  id_('ciudad_info_p').innerHTML =aux_t
 
  id_('calendari').innerHTML = crida(v_mes, v_ano)
  
  if(dia_sel!='')get_graella(dia_sel)

  /* mts 21042012, modif para que nos actualice la imagen de ferrari según la ciudad seleccionada */
  if (tipus_ev == 'ferrari') 
  {
 	   if (aux_t=='madrid')
	   	id_('tipus_img').innerHTML='<img style="padding:4px;border:1px solid #000" width="100px" alt="" src="../../img/c/7.jpg">';
	   else	
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
   
  
    
function mes(a)
  { 
  if(a=='+')v_mes++;
  else v_mes--;

  if(v_mes<1){v_mes=12;v_ano--}
  if(v_mes>12){v_mes=1;v_ano++}
  id_('calendari').innerHTML=crida(v_mes,v_ano)
  id_('graella').innerHTML=''
  id_('alta').style.display="none"
  id_('header_graella').style.display='none';  
}
function id_(id){
return document.getElementById(id);
}

function ano(a)
  { 
  if(a=='+')v_ano++;
  else v_ano--;
  id_('calendari').innerHTML=crida(v_mes,v_ano)
  id_('graella').innerHTML='' 
  id_('header_graella').style.display='none';  
 }
function ocultar_form(){
	id_('alta').style.display='none'
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
