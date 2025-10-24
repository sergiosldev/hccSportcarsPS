  function buscar_en_lista(buscado,lista)
  {
      for(var i=0;i<lista.options.length;i++)
      {
          if (lista.options[i].value==buscado)
          {
              lista.selectedIndex = i;
              break;
          }
      }
  }
  
  function validar_fecha(dia,mes,anyo)
  {

	if ((dia==0 || mes==0 || anyo==0) && dia+mes+anyo!='000') return false;
	else return true;
  }
  
  function limpiar_fecha(diaf,mesf,anyof,fechaf)
  {
	buscar_en_lista(0,id_(diaf)); 
	buscar_en_lista(0,id_(mesf));
	buscar_en_lista(0,id_(anyof));
	id_(fechaf).value='';
  }
  
  function actualizar_fecha(diaf,mesf,anyf,fechaf,elem,formato)  
    {
        //alert(lpad('k','22',1));
		
        var dia = id_(diaf).value.toString();
        var mes = id_(mesf).value.toString();
        var any = id_(anyf).value.toString();
		
        
		if (typeof formato == 'undefined')
			var fecha_valida = esFechaValida(dia,mes,any);
		else
			var fecha_valida = esFechaValida(dia,mes,any,formato);
	
        if (fecha_valida >=0)
        {        
            if (dia+mes+any!='')
                if (typeof formato == 'undefined')
					id_(fechaf).value = any+'-'+lpad('0',mes,2)+'-'+lpad('0',dia,2);
				else
					id_(fechaf).value = lpad('0',dia,2)+'/'+lpad('0',mes,2)+'/'+lpad('0',any,4);
            else id_(fechaf).value = '';
        }
        else 
        {
         switch (elem)
         {
             case 0:   
                dia=parseInt(id_(fechaf).value.toString().substring(0,2));
                if (fecha_valida==-1)
					buscar_en_lista(dia,id_(diaf));
				else buscar_en_lista(0,id_(diaf));	
                break;
             case 1:
                //alert(id_('fecha_nacimiento').value.toString().substring(3,5));break;
                mes=parseInt(id_(fechaf).value.toString().substring(3,5));
                //alert(mes);
                if (fecha_valida==-1)
					buscar_en_lista(mes,id_(mesf));
				else
					buscar_en_lista(0,id_(mesf));
                break;
             case 2:
                 any=parseInt(id_(fechaf).value.toString().substring(6,10));
                 if (fecha_valida==-1)
					buscar_en_lista(any,id_(anyf));
				 else
					buscar_en_lista(0,id_(anyf));
				 break;
             default: alert ('parámetro erróneo');
         }   
        }
    }
    
  function esFechaValida(dia,mes,anio,formato)
  {
	switch(mes){
        case '1':case '3':case '5':case '7':case '8':case '10':case '12':
            numDias=31;
            break;
        case '4':case '6':case '9':case '11':
            numDias=30;
            break;
        case '2':
			if (anio!=0){
				if (comprobarSiBisiesto(anio)){ numDias=29; }else{ numDias=28;}}
			else numDias=29;	
            break;
			
		case '0':
			if (typeof formato == 'undefined')
			return -1;
			break;
		default:            
            return -1;
    }
    if (dia!=0 && mes!=0)
		if(dia>numDias)
		{
         alert("Formato de fecha incorrecto. El mes seleccionado tiene "+numDias+" días ");
         return -2;
		}
  return true;  
  }
 
  function comprobarSiBisiesto(anio)
  {
    if ( ( anio % 100 != 0) && ((anio % 4 == 0) || (anio % 400 == 0))) return true;
    else return false;
  }    
  function lpad(caracter,cadena,longitud_final)
  {
      if (longitud_final<cadena.length) return cadena;
      var cadena_final = cadena;
      for (var i = 0;i<longitud_final-cadena.length;i++)
      {
          cadena_final = caracter+cadena_final; 
      }
     return (cadena_final);
  }

  
   
  
  function validar_hora(h)  
  {
	  //alert('hora '+$('#'+h).val());       
	  
	  /*
	  if ($('#fdesde').val()=='0' || $('#fhasta').val()=='0' || 
		  ($('#fdesde').val()!='0' && $('#fhasta').val()!='0' && $('#fdesde').val()!=$('#fhasta').val()))
	  {
		  alert('para seleccionar un rango de horas, previamente debe seleccionar la misma fecha en f.desde y f.hasta ');
		  $('#'+h).val('0');
		  return false;
	  }	  
	  */
	  if ($('#fdesde').val() == $('#fhasta').val() && $('#hdesde').val()!='0' && $('#hhasta').val()!='0' && ($('#hhasta').val() < $('#hdesde').val()))
	  {
		  alert('El campo "H. Desde" debe ser inferior o igual al campo "H. Hasta"');
		  $('#'+h).val('0');
		  return false;
		  
	  }	  
	  
	  return true;
	  
  }
  