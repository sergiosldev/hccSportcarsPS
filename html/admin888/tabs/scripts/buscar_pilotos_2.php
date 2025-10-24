<?php

function consultar_pilotos_gen_consulta($nombreb,$codigob,$ciudadb,$emailb,$telefonob,$diab,$tipob,&$lista_codigos)
{
  $nombre_apellidos = explode(' ',$nombreb);	
  $nombre_apellidos = array_map('trim',$nombre_apellidos);
  $nombre='';
  $apellido1 = '';
  $apellido2 = '';
  
  switch(count($nombre_apellidos))
  {
	case 1:	
		$nombre = $nombre_apellidos[0];
	break;
	case 2:	
		$nombre = $nombre_apellidos[0];
		$apellido1 = $nombre_apellidos[1];
	break;
	case 3:	 
		$nombre = $nombre_apellidos[0];
		$apellido1 = $nombre_apellidos[1];
		$apellido2 = $nombre_apellidos[2];
	break;

	case 4:	 
		$nombre = $nombre_apellidos[0];
		$apellido1 = $nombre_apellidos[1].' '.$nombre_apellidos[2].' '.$nombre_apellidos[3];
		$apellido2 = '';
	break;

}
 
  $apellido1 = normalizar($apellido1);
  $apellido2 = normalizar($apellido2);
  $nombre = normalizar($nombre);
 
  //$nombre = str_replace('\t','',$nombre);
  $nombre=rtrim(trim($nombre));
  //echo(ord($nombre[strlen($nombre)-1]).'a');

  $apellido1=trim($apellido1);
  $apellido2=trim($apellido2);
  
  /** CONDICIÃƒâ€œN CÃƒâ€œDIGOS **/
  $codigos = trim($codigob);                 
  
  $lista_codigos = str_replace("\r","",$codigos);             
  
  $lista_codigos = explode("\n",$codigos);                                                                                                                     
  
  //var_dump($lista_codigos);
  $lista_codigos = array_map(function ($a){return trim($a);},$lista_codigos);                                               
  $slista_codigos = implode(",",$lista_codigos);    
      
  $indice=0;
  $condicion_codigos='';
    

  foreach($lista_codigos as $scodigo)
  {
	  
  	$condicion_codigos2 =  
	  ' (codi_localtzador   like "%'.$scodigo.'%" OR
	  codi_consum    like "%'.$scodigo.'%") ';
  	   
  	if ($indice==1) 
  	{  
  		$condicion_codigos .= ' OR '.$condicion_codigos2;     
  	}    	 
  	else 
  	{
  		$condicion_codigos .= $condicion_codigos2;
  	}
  	 
  	$indice=1;	 
  	 
  }
   
  $condicion_codigos = ' ('.$condicion_codigos.') ';
  
  /** FIN CONDICIÃƒâ€œN CÃƒâ€œDIGOS **/ 
  
  
 
  $condicion_nombre1='
  ucase(pilot)  like "%'.$nombre.'%" and ucase(pilot) like "%'.$apellido1.'%" and ucase(pilot) like "%'.$apellido2.'%" 
  OR
  ucase(pilot)  like "%'.$nombre.'%" and ucase(apellidos_piloto) like "%'.$apellido1.'%" and apellidos_piloto like "%'.$apellido2.'%"';

  $condicion_nombre2='
  ucase(persona_regala) like "%'.$nombre.'%" and ucase(persona_regala) like "%'.$apellido1.'%" and ucase(persona_regala) like "%'.$apellido2.'%" 
  OR
  ucase(persona_regala) like "%'.$nombre.'%" and ucase(apellidos_persona_regala) like "%'.$apellido1.'%" and ucase(apellidos_persona_regala) like "%'.$apellido2.'%"   
  ';

  $condicion_nombre3='
  ucase(apellidos_piloto) like "%'.$nombre.'%" and ucase(apellidos_piloto) like "%'.$apellido1.'%"   
  ';

  $condicion_nombre4='
  ucase(apellidos_persona_regala) like "%'.$nombre.'%" and ucase(apellidos_persona_regala) like "%'.$apellido1.'%"   
  ';

  $condicion_nombre = '('.$condicion_nombre1.' OR '.$condicion_nombre2.' OR '.$condicion_nombre3.' OR '.$condicion_nombre4.')';

/*  $condicion_nombre.= 'OR
  persona_regala   like "%'.$nombre.'%")
  ';
*/
     	
//  $nombre = $_REQUEST['nombreb'];
//  $apellidos = $_REQUEST['nombreb'];
 

  if($ciudadb!='*')  
  $sql='SELECT *,null fecha_baja,"'.strtoupper($ciudadb).'" ciudad
  from events'.$ciudadb.
  ' where 
  (email_persona_regala like "%'.trim($emailb).'%" OR 
  email  like "%'.trim($emailb).'%" OR
  email_confirm   like "%'.trim($emailb).'%") 
  AND
  (telefon  like "%'.trim($telefonob).'%" OR
  mobil_persona_regala  like "%'.trim($telefonob).'%") 
  AND
  '.$condicion_nombre.'
  AND
  '.$condicion_codigos.'
  AND
  id_event  like "%'.trim($diab).'%" 
  
  AND
  tipus_event   like "%'.trim($tipob).'%" 
  
  ORDER BY id_event 
  ';
  else $sql='
  SELECT *,null fecha_baja,"Barcelona" ciudad
  from events where 
  (email_persona_regala like "%'.trim($emailb).'%" OR 
  email  like "%'.trim($emailb).'%" OR
  email_confirm   like "%'.trim($emailb).'%") 
  AND
  (telefon  like "%'.trim($telefonob).'%" OR
  mobil_persona_regala  like "%'.trim($telefonob).'%") 
  AND
  '.$condicion_nombre.'
  AND
  '.$condicion_codigos.'
  AND
  id_event  like "%'.trim($diab).'%" 
  
  AND
  tipus_event   like "%'.trim($tipob).'%" 
  
  
  UNION ALL
  
  SELECT *,null fecha_baja,"Madrid" ciudad
  from eventsmadrid where 
  (email_persona_regala like "%'.trim($emailb).'%" OR 
  email  like "%'.trim($emailb).'%" OR
  email_confirm   like "%'.trim($emailb).'%") 
  AND
  (telefon  like "%'.trim($telefonob).'%" OR
  mobil_persona_regala  like "%'.trim($telefonob).'%") 
  AND
  '.$condicion_nombre.'
  AND
  '.$condicion_codigos.'
  AND
  id_event  like "%'.trim($diab).'%"   
  AND
  tipus_event   like "%'.trim($tipob).'%" 
  
  
  UNION ALL
   
  SELECT *,null fecha_baja,"Valencia" ciudad
  from eventsvalencia where 
  (email_persona_regala like "%'.trim($emailb).'%" OR 
  email  like "%'.trim($emailb).'%" OR
  email_confirm   like "%'.trim($emailb).'%") 
  AND
  (telefon  like "%'.trim($telefonob).'%" OR
  mobil_persona_regala  like "%'.trim($telefonob).'%") 
  AND
  '.$condicion_nombre.'
  AND
  '.$condicion_codigos.'
  AND
  id_event  like "%'.trim($diab).'%" 
  
  AND
  tipus_event   like "%'.trim($tipob).'%" 
  
  
  UNION ALL
   
  SELECT *,null fecha_baja,"Andalucía" ciudad 
  from eventsandalucia where 
  (email_persona_regala like "%'.trim($emailb).'%" OR 
  email  like "%'.trim($emailb).'%" OR
  email_confirm   like "%'.trim($emailb).'%") 
  AND
  (telefon  like "%'.trim($telefonob).'%" OR
  mobil_persona_regala  like "%'.trim($telefonob).'%") 
  AND
  '.$condicion_nombre.'
  AND
  '.$condicion_codigos.'
  AND
  id_event  like "%'.trim($diab).'%" 
  
  AND
  tipus_event   like "%'.trim($tipob).'%" 
   
  UNION ALL
   
  SELECT *,null fecha_baja,"Cantabria" ciudad
  from eventscantabria where 
  (email_persona_regala like "%'.trim($emailb).'%" OR 
  email  like "%'.trim($emailb).'%" OR
  email_confirm   like "%'.trim($emailb).'%") 
  AND
  (telefon  like "%'.trim($telefonob).'%" OR
  mobil_persona_regala  like "%'.trim($telefonob).'%") 
  AND
  '.$condicion_nombre.'
  AND
  '.$condicion_codigos.'
  AND
  id_event  like "%'.trim($diab).'%" 
  
  AND
  tipus_event   like "%'.trim($tipob).'%" 
  
  UNION ALL
   
  SELECT *,null fecha_baja,"Circuitovendrell" ciudad
  from eventscircuitovendrell where 
  (email_persona_regala like "%'.trim($emailb).'%" OR 
  email  like "%'.trim($emailb).'%" OR
  email_confirm   like "%'.trim($emailb).'%") 
  AND
  (telefon  like "%'.trim($telefonob).'%" OR
  mobil_persona_regala  like "%'.trim($telefonob).'%") 
  AND
  '.$condicion_nombre.'
  AND
  '.$condicion_codigos.'
  AND
  id_event  like "%'.trim($diab).'%" 
  
  AND
  tipus_event   like "%'.trim($tipob).'%" 

  UNION ALL
   
  SELECT *,null fecha_baja,"Circuitomoradebre" ciudad   
  from eventscircuitomoradebre where 
  (email_persona_regala like "%'.trim($emailb).'%" OR 
  email  like "%'.trim($emailb).'%" OR
  email_confirm   like "%'.trim($emailb).'%") 
  AND
  (telefon  like "%'.trim($telefonob).'%" OR
  mobil_persona_regala  like "%'.trim($telefonob).'%") 
  AND
  '.$condicion_nombre.'
  AND
  '.$condicion_codigos.'
  AND
  id_event  like "%'.trim($diab).'%" 
  
  AND
  tipus_event   like "%'.trim($tipob).'%" 
  UNION ALL
   
  SELECT *,null fecha_baja,"Circuitoandalucía" ciudad
  from eventscircuitoandalucia where 
  (email_persona_regala like "%'.trim($emailb).'%" OR 
  email  like "%'.trim($emailb).'%" OR
  email_confirm   like "%'.trim($emailb).'%") 
  AND
  (telefon  like "%'.trim($telefonob).'%" OR
  mobil_persona_regala  like "%'.trim($telefonob).'%") 
  AND
  '.$condicion_nombre.'
  AND
  '.$condicion_codigos.'
  AND
  id_event  like "%'.trim($diab).'%" 
  
  AND
  tipus_event   like "%'.trim($tipob).'%" 
  UNION ALL
   
  SELECT *,null fecha_baja,"Circuitosegovia" ciudad
  from eventscircuitosegovia where 
  (email_persona_regala like "%'.trim($emailb).'%" OR 
  email  like "%'.trim($emailb).'%" OR
  email_confirm   like "%'.trim($emailb).'%") 
  AND
  (telefon  like "%'.trim($telefonob).'%" OR
  mobil_persona_regala  like "%'.trim($telefonob).'%") 
  AND
  '.$condicion_nombre.'
  AND
  '.$condicion_codigos.'
  AND
  id_event  like "%'.trim($diab).'%" 
  
  AND
  tipus_event   like "%'.trim($tipob).'%" 
  UNION ALL
   
  SELECT *,null fecha_baja,"Circuitovalencia" ciudad
  from eventscircuitovalencia where 
  (email_persona_regala like "%'.trim($emailb).'%" OR 
  email  like "%'.trim($emailb).'%" OR
  email_confirm   like "%'.trim($emailb).'%") 
  AND
  (telefon  like "%'.trim($telefonob).'%" OR
  mobil_persona_regala  like "%'.trim($telefonob).'%") 
  AND
  '.$condicion_nombre.'
  AND
  '.$condicion_codigos.'
  AND
  id_event  like "%'.trim($diab).'%" 
  
  AND
  tipus_event   like "%'.trim($tipob).'%" 
  UNION ALL
   
  SELECT *,null fecha_baja, "Circuitozaragoza" ciudad
  from eventscircuitozaragoza where 
  (email_persona_regala like "%'.trim($emailb).'%" OR 
  email  like "%'.trim($emailb).'%" OR
  email_confirm   like "%'.trim($emailb).'%") 
  AND
  (telefon  like "%'.trim($telefonob).'%" OR
  mobil_persona_regala  like "%'.trim($telefonob).'%") 
  AND
  '.$condicion_nombre.'
  AND
  '.$condicion_codigos.'
  AND
  id_event  like "%'.trim($diab).'%" 
  
  AND
  tipus_event   like "%'.trim($tipob).'%" 
  
  
  
  UNION ALL
   
  SELECT *,null fecha_baja, "rutas_turisticas" ciudad
  from eventsrutas_turisticas where 
  (email_persona_regala like "%'.trim($emailb).'%" OR 
  email  like "%'.trim($emailb).'%" OR
  email_confirm   like "%'.trim($emailb).'%") 
  AND
  (telefon  like "%'.trim($telefonob).'%" OR
  mobil_persona_regala  like "%'.trim($telefonob).'%") 
  AND
  '.$condicion_nombre.'
  AND
  '.$condicion_codigos.'
  AND
  id_event  like "%'.trim($diab).'%" 
  
  AND
  tipus_event   like "%'.trim($tipob).'%"   
  
  

  
  UNION ALL
   
  SELECT *
  from events_baja 
  where 
  (email_persona_regala like "%'.trim($emailb).'%" OR 
  email  like "%'.trim($emailb).'%" OR
  email_confirm   like "%'.trim($emailb).'%") 
  AND
  (telefon  like "%'.trim($telefonob).'%" OR
  mobil_persona_regala  like "%'.trim($telefonob).'%") 
  AND
  '.$condicion_nombre.'
  AND
  '.$condicion_codigos.'
  AND
  id_event  like "%'.trim($diab).'%" 
  
  AND
  tipus_event   like "%'.trim($tipob).'%"   
  
  ORDER BY id_event 
  
  
  ';
  
  $sql = ' select a.* from ('.$sql.') a where trim(a.pilot) != "no disponible" order by date(substr(a.id_event,1,10)) desc ';
  
  //die($sql); 
  
  //echo $sql;
  return $sql;
}

/**
 *Funcio per convertir caracters especials a caracters normals.
 *@param $cads Cadena ha normalitzar.
 *@return Torna la cadena amb els caracters convertits.
 */
function  normalizar($cads)
{
    $originales =  'Ã€Ã�Ã‚ÃƒÃ„Ã…Ã†Ã‡ÃˆÃ‰ÃŠÃ‹ÃŒÃ�ÃŽÃ�Ã�Ã‘Ã’Ã“Ã”Ã•Ã–Ã˜Ã™ÃšÃ›ÃœÃ�ÃžÃŸÃ Ã¡Ã¢Ã£Ã¤Ã¥Ã¦Ã§Ã¨Ã©ÃªÃ«Ã¬	Ã®Ã¯Ã°Ã±Ã²Ã³Ã´ÃµÃ¶Ã¸Ã¹ÃºÃ»Ã½Ã½Ã¾Ã¿Å”Å•';
    $modificadas = 'aaaaaaaceeeeiiiidnoooooouuuuybsaaaaaaaceeeeiiiidnoooooouuuyybyRr';
    //$str=strtr($cadena,'\t\n\r\0\x0B','     ');
    $str=strtr($cads,utf8_decode($originales),$modificadas);
    $strf='';
    //$strf = $str;
    for($i=0;$i<strlen($str);$i++)
    {
        if ((ord($str[$i])>64 and ord($str[$i])<123) || ord($str[$i])==32) $strf.= $str[$i];
}
//for($i=0;$i<strlen($strf);$i++) echo(ord($strf[$i]));
//echo('<br>');
return $strf;
  }
  

  /**
   * FunciÃ³ per convertir els caracters especials a codi hexadecimal que podem mostrar.
   *@param $cad Cadena que contÃ© la informaciÃ³ a transformar.
   *@return Retorna la cadena amb els caracters especials transformats.
   */
  function convert_caracters_hex($cad)
  {
  
      $cad=str_replace('Ã³', '&#243;', $cad);
      $cad=str_replace('Ã©', '&#233;', $cad);
      $cad=str_replace('Ã±', '&#241;', $cad);
      $cad=str_replace('Ãº', '&#250;', $cad);
      $cad=str_replace('Ã¡', '&#225;', $cad);
      $cad=str_replace('Ã­', '&#237;', $cad);
      $cad=str_replace('Ã§', '&#231;', $cad);
      $cad=str_replace('Ã²', '&#242;', $cad);
      $cad=str_replace('Ã¨', '&#232;', $cad);
      $cad=str_replace('Ã¹', '&#249;', $cad);
      $cad=str_replace('Ã ', '&#224;', $cad);
      $cad=str_replace('Ã¬', '&#236;', $cad);
      $cad=str_replace('Ã±', '&#241;', $cad);
      return $cad;
  }
  
  
  /**
   * FunciÃ³ per identificar el vehicle a partir d'una variable.
   *@param $t
   *@return retorna el tipus de vehicle que conte la variable.
   */
  function return_tipus($t)
  {
      $tipos=array('_bferrari_','ferrari','_blamborghini_','lamborghini','_bporsche_','_porsche_','_bcorvette_','_corvette_','formula');
      $tipos_cmp=array('_bferrari_','ferrari','_blamborghini_','lamborghini','_bporsche_','porsche','_bcorvette_','corvette','formula');
      $stipo='ferrari';
      $i=0;
      foreach($tipos_cmp as $tipo)
      {
          if (strpos($t,$tipo)!==false)
          {
              $stipo=$tipos[$i];
              break;
          }
          $i++;
      }
       
      return $stipo;
  }
  
  /**
   * FunciÃ³ per identificar les experiencies a partir d'un vehicle d'una variable.
   *@param $t
   *@return El tipus d'experencia que conte la variable.
   */
  function return_tipus_e($t,$ruta=null)
  {
      switch($t)
      {
          case 'ferrari':
              return 'Ferrari 430 20 Km   ';
              break;
          case 'ferrari_porsche901':
              return 'Ferrari  430 20 Km  + Porsche  20 Km   ';
              break;
          case 'lamborghini':
              return 'Lamborghini 20 Km';
              break;
          case 'lamborghini_lotus':
              return 'Lamborghini 20 Km  + Porsche 20 Km ';
              break;
          case 'porsche997_porsche996':
              return 'Porsche Turbo 20 Km +  Porsche Carrera S 20 Km ';
              break;
          case 'porsche996':
              return 'Porsche 20 Km ';
              break;
          case 'porsche997':
              return 'Porsche 20 Km ';
              break;
		  case 'porsche':
					return 'Porsche '.$ruta.' Km ';
              break;
		  case 'corvette':
					return 'Corvette '.$ruta.' Km ';
              break;
          case '_porsche_':
              return 'Porsche 20 Km ';
              break;
          case '_bporsche_':
              return 'Porsche  7 Km ';
              break;
          case '_lotus_':
              return 'Porsche 20 Km ';
              break;
          case '_bferrari_':
              return 'Ferrari 430 7 Km ';
              break;
          case '_blamborghini_':
              return 'Lamborghini 7 Km';
              break;
          case '_corvette_':
              return 'Corvette 20 Km';
              break;
          case '_bcorvette_':
              return 'Corvette 7 Km';
              break;
              // BUGGY
          case '_buggy_':
              return 'BUGGY ';
              break;
		  default:
			  if (strpos($t,'formula')!==false)
				return 'Formula';
			  else 
				return t;
  
      }
  }
?>