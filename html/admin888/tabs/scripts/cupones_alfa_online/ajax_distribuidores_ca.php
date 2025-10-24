<?php 
//mts 05052012. Fichero ajax para la inserción y modificación de cupones.
    include dirname(__FILE__).'/../settings.php'; 
    include_once(dirname(__FILE__).'/../../../../config/config.inc.php');
    include_once dirname(__FILE__).'/../../../../classes/Distribuidor.php'; 
    include_once dirname(__FILE__).'/../../../../classes/CuponOfertaHistoricoCA.php'; 
    include_once dirname(__FILE__).'/../conversiones_html.php'; 
    include_once(dirname(__FILE__).'/../../../../scripts/funciones_validacion.php');
        //include dirname(__FILE__).'/../trazas.php'; 
     
    $id_distribuidor =request('id_distribuidor');
     ///die('aki');  
    
	
	
    if (request('id_edita_distribuidor'))   
    {
			

        $dist = new Distribuidor();

        $r=$dist->get($id_distribuidor);    
		$email_distribuidor = $dist->email;
		$telefono_distribuidor = $dist->telefono;
        if($r===false) die('Error');
        else 
        {   
			if ($id_distribuidor==_DISTRIBUIDOR_PRUEBA_)
			{
				if(request('cupon') and request('cupon')!=0)
				{
					$cupon = new CuponOfertaHistoricoCA();  
					$r=$cupon->get(request('cupon'));  
					$email_distribuidor = $cupon->emailCompra;
					$telefono_distribuidor = $cupon->telefono;
				}
			}

		    $cad_eval.='id_(\'nombre_ca\').value=\''. $dist->nombre.'\'; ';
            $cad_eval.='id_(\'nombre_contacto_ca\').value=\''. $dist->nombreContacto.'\'; ';
            $cad_eval.='id_(\'apellidos_contacto_ca\').value=\''. $dist->apellidosContacto.'\'; ';
            $cad_eval.='id_(\'usuario_ca\').value=\''. $dist->usuario.'\'; ';
            $cad_eval.='id_(\'email_oferta_ca\').value=\''. $email_distribuidor.'\'; ';
            $cad_eval.='id_(\'password_ca\').value=\''. $dist->password.'\'; ';
            $cad_eval.='id_(\'telefono_ca\').value=\''. $telefono_distribuidor.'\'; ';
            $cad_eval.='id_(\'direcciond_ca\').value=\''. $dist->direccion.'\'; ';
            $cad_eval.='id_(\'ciudad_ca\').value=\''. $dist->poblacion.'\'; ';
            $cad_eval.='id_(\'cpostal_ca\').value=\''. $dist->cPostal.'\'; ';
            $cad_eval.='id_(\'nif_ca\').value=\''. $dist->nif.'\'; ';
            unset($dist);
            die ($cad_eval); 
        }
    }
    else if (request('modifica_distribuidor'))
    {
            
        
        foreach ($GET as $key=>$value) $GET[$key]=(($valor=='')?' ':$valor);
        
		

		
        $email=request('email_oferta_ca');
        $nombre=request('nombre_ca');
        $nombre_contacto=(request('nombre_contacto_ca')=='')?' ':request('nombre_contacto_ca');
        $apellidos_contacto=(request('apellidos_contacto_ca')=='')?' ':request('apellidos_contacto_ca');
        $usuario=request('usuario_ca');
        $password=request('password_ca');

        $direccion=request('direcciond_ca');
        $ciudad=request('ciudad_ca');
        $cpostal=request('cpostal_ca');
        $telefono=request('telefono_ca');
        $nif=request('nif_ca');

        if (!check_nif_cif_nie($nif)) die('Error: el nif introducido no es válido');
		
		
        $test = new Distribuidor();
        $r=$test->get(null,$usuario);
        if ($r and $test->id!=$id_distribuidor) die('Error: el código de usuario ya existe');        
        
        $dist = new Distribuidor($id_distribuidor,$email,$nombre,$usuario,$password,$telefono,
                                 null,null,$direccion,$ciudad,$cpostal,null,null,$nombre_contacto,$apellidos_contacto,$nif);
        $r=$dist->Update();
        //die($r);
        //var_dump($r);die; 
        unset($dist);
        if ($r===false) $r='error'; else $r='OK';
    }
    
    else if (request('nuevo_distribuidor'))
    {
        foreach ($GET as $key=>$value) $GET[$key]=(($valor=='')?' ':$valor);
        


        $email=request('email_oferta_ca');
        $nombre=request('nombre_ca');
        $nombre_contacto=request('nombre_contacto_ca');
        $apellidos_contacto=request('apellidos_contacto_ca');
        $usuario=request('usuario_ca');
        $password=request('password_ca');

        $direccion=request('direcciond_ca');
        $ciudad=request('ciudad_ca');
        $cpostal=request('cpostal_ca');
        $telefono=request('telefono_ca');
        $nif=request('nif_ca');
        $fecha_alta = date('Y-m-d H:i:s');
      
		if (!check_nif_cif_nie($nif)) die('Error: el nif introducido no es válido');

        $test = new Distribuidor();
        $r=$test->get(null,$usuario);
        unset($test);
        if ($r) die('Error: el código de usuario ya existe');
        $dist = new Distribuidor(null,$email,$nombre,$usuario,$password,$telefono,
                                 $fecha_alta,null,$direccion,$ciudad,$cpostal,1,null,$nombre_contacto,$apellidos_contacto,$nif);
          
        $r=$dist->Insert();
        //die($r); 
        //die($r);
        //var_dump($r);die; 
        unset($dist);
        if ($r===false) $r='error'; else $r='OK';
    }
    else if (request('borrar_distribuidor'))
    {
        //traza('test.txt','aki1');
        $distribuidor = new Distribuidor($id_distribuidor);
        $distribuidor->sufijo='_distribuidores';
        //traza('test.txt',$distribuidor);
        $r=$distribuidor->Delete();
        if ($r) $r='OK';
        else $r='Error al eliminar el distribuidor';    
    }
    echo($r);
 
?>

