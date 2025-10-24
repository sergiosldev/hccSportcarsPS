<?php	

  function consultar_pilotos_gen_consulta($nombreb,$codigob,$ciudadb,$emailb,$telefonob,$diab,$tipob)
  {

  //Tots els request canvian per les noves variables.
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
  

  /** CONDICIÓN CÓDIGOS **/
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
  
  /** FIN CONDICIÓN CÓDIGOS **/ 
  
  
 
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
  $sql='SELECT *,"'.strtoupper($ciudadb).'" ciudad    
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
  SELECT *,"Barcelona" ciudad    from events where 
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
  
  SELECT *,"Madrid" ciudad    from eventsmadrid where 
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
   
  SELECT *,"Valencia" ciudad    from eventsvalencia where 
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
   
  SELECT *,"Andalucía" ciudad    from eventsandalucia where 
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
   
  SELECT *,"Cantabria" ciudad  from eventscantabria where 
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
   
  SELECT *,"rutas_turisticas" ciudad  from eventsrutas_turisticas where 
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
 ?>