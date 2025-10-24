<?php
	include(dirname(__FILE__).'/class.phpmailer.php');		
	include(dirname(__FILE__).'/verify_email.php');	
	//include(dirname(__FILE__).'/trazas.php');
	
	include(dirname(__FILE__).'/../../../config/config.inc.php');	
	


	//filtro
	
	$bd=_DB_NAME_; 
	$user=_DB_USER_;
	$server=_DB_SERVER_;
	$password=_DB_PASSWD_;

	
	
	
	
	
//envia_mails('marctorraso2@gmail.com','');
//die;

	/*
	if (isset($_GET['param']) && $_GET['param']=23)
	{
	
		mysql_query("SET CHARACTER SET utf8 ");

		$link2 = mysql_connect($server, $user, $password) or die ("<p class='error'>Lo sentimos, no se puede conectar con el servidor de base de datos.</p>");
		mysql_select_db($bd, $link2) or die ("<p class='error'>Lo sentimos, no se puede conectar con la base de datos.</p>");	
		enviar_lista_emails();   
	}
	else
	{
		die('error par.');
	}	
	
	*/
		//$ciudad='madrid';
		//$tipus_event='ferrari';
		//$fecha='2014-09-20';	
	
	function envio_mails($ciudad,$tipus_event,$fecha)
	{
		mysql_query("SET CHARACTER SET utf8 ");

		//$link2 = mysql_connect($server, $user, $password) or die ("<p class='error'>Lo sentimos, no se puede conectar con el servidor de base de datos.</p>");
		//mysql_select_db($bd, $link2) or die ("<p class='error'>Lo sentimos, no se puede conectar con la base de datos.</p>");	
		
		enviar_lista_emails($ciudad,$tipus_event,$fecha);   
	}	



	function enviar_lista_emails($ciudad,$tipus_event,$fecha)
	{
	
		global $link2;
		global $bd;
		global $user; 
		global $server;
		global $password;	
		$categoria_plantilla_correo = 39;
		//listado de 1000 emails pendientes de enviar.
		//$sql = " select b.bnc_id,b.bnc_email from mshop_bounces b,volcado_emails_barcelona v where v.email=b.bnc_email and v.enviado=0 and v.email='marctorrasoasdfasdfadsfdasfdasfadsfsafdafas@gmail.com' limit 1  ";     
			//$sql = " select b.bnc_id,b.bnc_email,b.bnc_control from mshop_bounces b,volcado_emails_barcelona v where v.email=b.bnc_email and v.enviado=0 and v.email='marctorraso@gmail.com' limit 1  ";     
		//$sql = " select b.bnc_id,b.bnc_email,b.bnc_control from mshop_bounces b where bnc_id=4301 ";     
		//$sql = " select email from emails_verificados where enviado=0 and email like '%marctorraso%' order by email limit 100  ";     
		//$sql = " select email,bnc_id,bnc_control from emails_verificados_todos_ciudades ev,mshop_bounces mb where mb.bnc_email=ev.email and not(ev.error is not null and error!='0') and ev.enviado=0 order by ev.email limit 500  ";     
		$link1 = mysql_connect($server, $user, $password) or die ("<p class='error'>Lo sentimos, no se puede conectar con el servidor de base de datos.</p>");
		mysql_select_db($bd, $link1) or die ("<p class='error'>Lo sentimos, no se puede conectar con la base de datos.</p>");
	    $sbody = ' select titulo,description from ps_product p,ps_product_lang l where l.id_product = p.id_product and p.active=1 and p.id_category_default  = '.$categoria_plantilla_correo.' limit 1 ';
		$rbody= mysql_query($sbody);
		$row1 = mysql_fetch_assoc($rbody);
		$body = utf8_decode($row1['description']);
		$asunto = $row1['titulo'];
		
	    mysql_close($link1);	
		
	
		//$ciudad='madrid';
		//$tipus_event='ferrari';
		//$fecha='2014-09-20';
		$sql = actualizar_tabla_enviados($ciudad,$tipus_event,$fecha);
		//die;
		$sql = "  select email from emails_enviados where enviado=0 limit 500  ";        
		//$sql = " select email,bnc_id,bnc_control from emails_verificados ev,mshop_bounces mb where mb.bnc_email=ev.email and ev.enviado=0 and ev.email = 'marctorrasoasdfasdfadsfdasfdasfadsfsafdafas@gmail.com' order by ev.email limit 1  ";     
		
		//$result=Db::getInstance()->ExecuteS($sql);       
		$link1_ = mysql_connect($server, $user, $password) or die ("<p class='error'>Lo sentimos, no se puede conectar con el servidor de base de datos.</p>");
		mysql_select_db($bd, $link1_) or die ("<p class='error'>Lo sentimos, no se puede conectar con la base de datos.</p>");                


		$query = mysql_query($sql);
		
		$emails=array();  
		$k=0;
		
		
		//los guardamos en un array.
		//los guardamos en un array.
		//foreach ($result as $row)
		/*foreach ($result as $row)*/
		$rnd2=rand(1,10000);
		
		while ($row = mysql_fetch_assoc($query))
		{
			$emails[]=$row['email'];
			$k++;
		}

		//var_dump($emails);die;
		mysql_close($link1_);  
		//$emails2=implode('<br>',$emails);
		//var_dump($emails2);
		//die;
		
		//Enviamos los emails
		$i=0;
		//echo('count '.count($emails));
		//var_dump($emails);die;
		for ($i=0;$i<count($emails);$i++)
		{
			$email=$emails[$i];
			$envio=envia_mails($email,$headers,$asunto,$body);
			//echo('envio: '.$envio.'<br>');
			//Si no hay error marcamos el registro como enviado.
			if ($envio=='OK')
			{
				$upd = ' UPDATE emails_enviados
						 SET  enviado = 1,error=0
						 WHERE email = \''.$email.'\'';
			}
			//Si hubo error en el envío lo añadimos en la  tabla.
			else
			{
				$upd = ' UPDATE emails_enviados
						 SET  enviado=0,error=\''.$envio.'\' 
						 WHERE email = \''.$email.'\'';
			}
					 
			//antes de modificar la tabla añadimos una traza para registrar si hubo error en el envío.
			traza2('volcado_emails_barcelona'.$rnd2.'.csv',$email.';'.(($envio!='OK')?0:1).';'.$envio);

			mysql_query("SET CHARACTER SET utf8 ");

			$link3 = mysql_connect($server, $user, $password) or die ("<p class='error'>Lo sentimos, no se puede conectar con el servidor de base de datos.</p>");
			mysql_select_db($bd, $link3) or die ("<p class='error'>Lo sentimos, no se puede conectar con la base de datos.</p>");
			
            $result2= mysql_query($upd);
            if (!$result2) {echo('Error durante la actualización');}
			mysql_close($link3);			
			//$result2 = Db::getInstance()->ExecuteS($upd);
			

			//if ($i==1) die;
		}		
    }
	
	

function envia_mails($email,$header,$asunto,$body)
  { 
  	  
	//die($mail);

	$mail = new PHPMailer();
	//$mail->IsSMTP();
    $mail->Host = "localhost";
	/***/
	$mail->SMTPDebug  = 1; 
    
    $mail->SMTPAuth = true; 
	$mail->Port       = 25;    
	$mail->Username = EMAIL_INFO; 
    $mail->Password = PASSWD_EMAIL_INFO;   
	$mail->Helo = "www.".strtolower(_NOMBRE_LOGO_).".com";	
  /***/
	
 	$mail->From = EMAIL_INFO;
	
    $mail->FromName = _NOMBRE_LOGO_;
    $mail->Subject = $asunto.' - '.$email;
  
	$mail->Body = $body.'test';
	$mail->AddCustomHeader ($header);

    $mail->IsHTML(true);
	
	
	
    
    $exito=$mail->Send();

	if (!$exito)
	{	

		return ($mail->ErrorInfo);
	}
	
	else 
	{
		return ('OK');
	}

  }  	
  
  //envía un email de test a alfonso, para ver como queda la plantilla para las suspensiones.
  function envia_mail_test()
  { 
	global $bd;  	  
	global $server;
	global $user;
	global $password;
	//echo($server.'.'.$user.'.'.$password);
	$categoria_plantilla_correo = 39;
	$link2_ = mysql_connect($server, $user, $password) or die ("<p class='error'>Lo sentimos, no se puede conectar con el servidor de base de datos.</p>");
	mysql_select_db($bd, $link2_) or die ("<p class='error'>Lo sentimos, no se puede conectar con la base de datos.</p>");
	$sbody = ' select titulo,description from ps_product p,ps_product_lang l where l.id_product = p.id_product and p.active=1 and p.id_category_default  = '.$categoria_plantilla_correo.' limit 1 ';
	$rbody= mysql_query($sbody);
	$row1 = mysql_fetch_assoc($rbody);
	$body = utf8_decode($row1['description']);
	$asunto = $row1['titulo'];
		
	mysql_close($link2_);	  
	  
	$mail = new PHPMailer();
	//$mail->IsSMTP();
    $mail->Host = "localhost";
	/***/
	$mail->SMTPDebug  = 1; 
    
    $mail->SMTPAuth = true; 
	$mail->Port       = 25;    
	$mail->Username = EMAIL_INFO; 
    $mail->Password = PASSWD_EMAIL_INFO;   
	$mail->Helo = "www.".strtolower(_NOMBRE_LOGO_).".com";	
  /***/
	
 	$mail->From = EMAIL_INFO;
	
	//$mail->From = "marctorraso@gmail.com";
    $mail->FromName = _NOMBRE_EMP_;
    $mail->Subject = $asunto;
  

	$mail->AddAddress(EMAIL_INFO);         
	$mail->AddBCC("soporte@hccsoft.com","oc");       
   
	$mail->Body = $body;
	$mail->AddCustomHeader ($header);

    $mail->IsHTML(true);
	
	
	
    
    $exito=$mail->Send();

	if (!$exito)
	{	

		return ($mail->ErrorInfo);
	}
	
	else 
	{
		return ('OK');
	}

  }  	
  
  function actualizar_tabla_enviados($ciudad=null,$tipus_event=null,$fecha=null)
  {
	global $bd;
	global $user; 
	global $server;
	global $password;	
	
	//Eliminamos el contenido de la tabla emails_enviados
	$linkd = mysql_connect($server, $user, $password) or die ("<p class='error'>Lo sentimos, no se puede conectar con el servidor de base de datos.</p>");
	mysql_select_db($bd, $linkd) or die ("<p class='error'>Lo sentimos, no se puede conectar con la base de datos.</p>");
	
	$del = 'delete from emails_enviados;';
	$resultd= mysql_query($del);
	if (!$resultd) {echo('Error durante la actualización');}    
	mysql_close($linkd);			
	


	//Llenamos la tabla con los emails no erróneos (según resultado del procedimiento para verificar emails y el resultado de los envíos en la tabla mshop_bounces)
	$linki = mysql_connect($server, $user, $password) or die ("<p class='error'>Lo sentimos, no se puede conectar con el servidor de base de datos.</p>");
	mysql_select_db($bd, $linki) or die ("<p class='error'>Lo sentimos, no se puede conectar con la base de datos.</p>");
	
	
	$where_fecha='';
	$where_tipus_event='';
	
	if ($fecha!=null) 
	{
		$where_fecha = '  d.fecha = "'.$fecha.'"';
	}
	
	if ($tipus_event!=null)
	{
		//$where_tipus_event = ' and d.tipus_event like "%'.$tipus_event.'%"';
		$where_tipus_event = ' and d.tipus_event = "'.$tipus_event.'"';
	}
	
	$insert = '
	insert into emails_enviados
	(email,enviado,error)
	select df.emailf as email,0,null
	from
	(';
	
	
	$insert1='
	select    \'barcelona\' ciudad,d.email1 as  emailf
	from
	(
			select lower(trim(a.email)) email1,a.tipus_event,substring(a.id_event,1,10) fecha
			from events a      
			where trim(a.email)!=\'\' and instr(a.email,\'@\')!=0 
			union all

			select lower(trim(b.email_confirm)) email1,b.tipus_event,substring(b.id_event,1,10) fecha
			from events b             
			where trim(b.email_confirm)!=\'\' and instr(b.email_confirm,\'@\')!=0 
			union all

			select lower(trim(c.email_persona_regala)) email1,c.tipus_event,substring(c.id_event,1,10) fecha
			from events c                           
			where trim(c.email_persona_regala)!=""  and instr(c.email_persona_regala,\'@\')!=0             

	) d 
	where '.$where_fecha.$where_tipus_event.'

	group by d.email1';
	
	$insert2='
	select    \'madrid\' ciudad,d.email2 as  emailf
	from
	(
			select lower(trim(a.email)) email2,a.tipus_event,substring(a.id_event,1,10) fecha
			from eventsmadrid a      
			where trim(a.email)!=\'\' and instr(a.email,\'@\')!=0 
			union all

			select lower(trim(b.email_confirm)) email2,b.tipus_event,substring(b.id_event,1,10) fecha
			from eventsmadrid b             
			where trim(b.email_confirm)!=\'\' and instr(b.email_confirm,\'@\')!=0 
			union all

			select lower(trim(c.email_persona_regala)) email2,c.tipus_event,substring(c.id_event,1,10) fecha
			from eventsmadrid c                           
			where trim(c.email_persona_regala)!=""  and instr(c.email_persona_regala,\'@\')!=0             

	) d 
	where 
	'.$where_fecha.$where_tipus_event.'

	group by d.email2';
	

	$insert3='
	select    \'valencia\' ciudad,d.email3 as  emailf
	from
	(
			select lower(trim(a.email)) email3,a.tipus_event,substring(a.id_event,1,10) fecha
			from eventsvalencia a      
			where trim(a.email)!=\'\' and instr(a.email,\'@\')!=0 
			union all

			select lower(trim(b.email_confirm)) email3,b.tipus_event,substring(b.id_event,1,10) fecha
			from eventsvalencia b             
			where trim(b.email_confirm)!=\'\' and instr(b.email_confirm,\'@\')!=0 
			union all

			select lower(trim(c.email_persona_regala)) email3,c.tipus_event,substring(c.id_event,1,10) fecha
			from eventsvalencia c                           
			where trim(c.email_persona_regala)!=""  and instr(c.email_persona_regala,\'@\')!=0             

	) d 
	where 
	'.$where_fecha.$where_tipus_event.'

	group by d.email3';
	

	$insert4='
	select    \'andalucia\' ciudad,d.email4 as  emailf
	from
	(
			select lower(trim(a.email)) email4,a.tipus_event,substring(a.id_event,1,10) fecha
			from eventsandalucia a      
			where trim(a.email)!=\'\' and instr(a.email,\'@\')!=0 
			union all

			select lower(trim(b.email_confirm)) email4,b.tipus_event,substring(b.id_event,1,10) fecha
			from eventsandalucia b             
			where trim(b.email_confirm)!=\'\' and instr(b.email_confirm,\'@\')!=0 
			union all

			select lower(trim(c.email_persona_regala)) email4,c.tipus_event,substring(c.id_event,1,10) fecha
			from eventsandalucia c                           
			where trim(c.email_persona_regala)!=""  and instr(c.email_persona_regala,\'@\')!=0             

	) d 
	where 
	'.$where_fecha.$where_tipus_event.'

	group by d.email4';
	

	$insert5='
	select    \'andalucia\' ciudad,d.email5 as  emailf
	from
	(
			select lower(trim(a.email)) email5,a.tipus_event,substring(a.id_event,1,10) fecha
			from eventscantabria a      
			where trim(a.email)!=\'\' and instr(a.email,\'@\')!=0 
			union all

			select lower(trim(b.email_confirm)) email5,b.tipus_event,substring(b.id_event,1,10) fecha
			from eventscantabria b             
			where trim(b.email_confirm)!=\'\' and instr(b.email_confirm,\'@\')!=0 
			union all

			select lower(trim(c.email_persona_regala)) email5,c.tipus_event,substring(c.id_event,1,10) fecha
			from eventscantabria c                           
			where trim(c.email_persona_regala)!=""  and instr(c.email_persona_regala,\'@\')!=0             

	) d 
	where 
	'.$where_fecha.$where_tipus_event.'

	group by d.email5 ';	
	
	/*
	$insert1='
	select    \'barcelona\' ciudad,d.email as  emailf
	from
	(
			select lower(trim(a.email)) email,a.tipus_event,substring(a.id_event,1,10) fecha
			from events a      
			where trim(a.email)!=\'\' and instr(a.email,\'@\')!=0 
			union all

			select lower(trim(b.email_confirm)) email,b.tipus_event,substring(b.id_event,1,10) fecha
			from events b             
			where trim(b.email_confirm)!=\'\' and instr(b.email_confirm,\'@\')!=0 
			union all

			select lower(trim(c.email_persona_regala)) email,c.tipus_event,substring(c.id_event,1,10) fecha
			from events c                           
			where trim(c.email_persona_regala)!=""  and instr(c.email_persona_regala,\'@\')!=0             

	) d 
	where d.email REGEXP \'^[a-zA-Z0-9_-][a-zA-Z0-9._-]*[a-zA-Z0-9._-]@[a-zA-Z0-9][a-zA-Z0-9._-]*[a-zA-Z0-9_-]\.[a-zA-Z]{2,4}$\'
	'.$where_fecha.$where_tipus_event.'

	group by d.email';
	
	$insert2='
	select    \'madrid\' ciudad,d.email as  emailf
	from
	(
			select lower(trim(a.email)) email,a.tipus_event,substring(a.id_event,1,10) fecha
			from eventsmadrid a      
			where trim(a.email)!=\'\' and instr(a.email,\'@\')!=0 
			union all

			select lower(trim(b.email_confirm)) email,b.tipus_event,substring(b.id_event,1,10) fecha
			from eventsmadrid b             
			where trim(b.email_confirm)!=\'\' and instr(b.email_confirm,\'@\')!=0 
			union all

			select lower(trim(c.email_persona_regala)) email,c.tipus_event,substring(c.id_event,1,10) fecha
			from eventsmadrid c                           
			where trim(c.email_persona_regala)!=""  and instr(c.email_persona_regala,\'@\')!=0             

	) d 
	where d.email REGEXP \'^[a-zA-Z0-9_-][a-zA-Z0-9._-]*[a-zA-Z0-9._-]@[a-zA-Z0-9][a-zA-Z0-9._-]*[a-zA-Z0-9_-]\.[a-zA-Z]{2,4}$\'
	'.$where_fecha.$where_tipus_event.'

	group by d.email';
	

	$insert3='
	select    \'valencia\' ciudad,d.email as  emailf
	from
	(
			select lower(trim(a.email)) email,a.tipus_event,substring(a.id_event,1,10) fecha
			from eventsvalencia a      
			where trim(a.email)!=\'\' and instr(a.email,\'@\')!=0 
			union all

			select lower(trim(b.email_confirm)) email,b.tipus_event,substring(b.id_event,1,10) fecha
			from eventsvalencia b             
			where trim(b.email_confirm)!=\'\' and instr(b.email_confirm,\'@\')!=0 
			union all

			select lower(trim(c.email_persona_regala)) email,c.tipus_event,substring(c.id_event,1,10) fecha
			from eventsvalencia c                           
			where trim(c.email_persona_regala)!=""  and instr(c.email_persona_regala,\'@\')!=0             

	) d 
	where d.email REGEXP \'^[a-zA-Z0-9_-][a-zA-Z0-9._-]*[a-zA-Z0-9._-]@[a-zA-Z0-9][a-zA-Z0-9._-]*[a-zA-Z0-9_-]\.[a-zA-Z]{2,4}$\'
	'.$where_fecha.$where_tipus_event.'

	group by d.email';
	

	$insert4='
	select    \'andalucia\' ciudad,d.email as  emailf
	from
	(
			select lower(trim(a.email)) email,a.tipus_event,substring(a.id_event,1,10) fecha
			from eventsandalucia a      
			where trim(a.email)!=\'\' and instr(a.email,\'@\')!=0 
			union all

			select lower(trim(b.email_confirm)) email,b.tipus_event,substring(b.id_event,1,10) fecha
			from eventsandalucia b             
			where trim(b.email_confirm)!=\'\' and instr(b.email_confirm,\'@\')!=0 
			union all

			select lower(trim(c.email_persona_regala)) email,c.tipus_event,substring(c.id_event,1,10) fecha
			from eventsandalucia c                           
			where trim(c.email_persona_regala)!=""  and instr(c.email_persona_regala,\'@\')!=0             

	) d 
	where d.email REGEXP \'^[a-zA-Z0-9_-][a-zA-Z0-9._-]*[a-zA-Z0-9._-]@[a-zA-Z0-9][a-zA-Z0-9._-]*[a-zA-Z0-9_-]\.[a-zA-Z]{2,4}$\'
	'.$where_fecha.$where_tipus_event.'

	group by d.email';
	

	$insert5='
	select    \'andalucia\' ciudad,d.email as  emailf
	from
	(
			select lower(trim(a.email)) email,a.tipus_event,substring(a.id_event,1,10) fecha
			from eventscantabria a      
			where trim(a.email)!=\'\' and instr(a.email,\'@\')!=0 
			union all

			select lower(trim(b.email_confirm)) email,b.tipus_event,substring(b.id_event,1,10) fecha
			from eventscantabria b             
			where trim(b.email_confirm)!=\'\' and instr(b.email_confirm,\'@\')!=0 
			union all

			select lower(trim(c.email_persona_regala)) email,c.tipus_event,substring(c.id_event,1,10) fecha
			from eventscantabria c                           
			where trim(c.email_persona_regala)!=""  and instr(c.email_persona_regala,\'@\')!=0             

	) d 
	where d.email REGEXP \'^[a-zA-Z0-9_-][a-zA-Z0-9._-]*[a-zA-Z0-9._-]@[a-zA-Z0-9][a-zA-Z0-9._-]*[a-zA-Z0-9_-]\.[a-zA-Z]{2,4}$\'
	'.$where_fecha.$where_tipus_event.'

	group by d.email';
	*/
	
	$insert .= $insert1.' union '.$insert2.' union '.$insert3.' union '.$insert4.' union '.$insert5.
	') df
	where df.emailf not in (select lower(trim(email))  from emails_enviados)    ';
	if ($ciudad=='') $ciudad = 'barcelona'; 
	if ($ciudad!=null) $insert.= ' and df.ciudad="'.$ciudad.'"';    

	$insert .= ' group by df.emailf ';
	 
	/*
	
	$insert .= $insert1.' union '.$insert2.' union '.$insert3.' union '.$insert4.' union '.$insert5.                
	') df
	where df.emailf not in (select lower(trim(email))  from emails_enviados) and df.emailf not in (select email from emails_erroneos) 
	group by df.emailf
	 ';
	
	*/
  
	$resulti= mysql_query($insert);
	//die($insert);
	if (!$resulti) {echo('Error durante la actualización');}
	mysql_close($linki);			  

	}
	
  
  ?>