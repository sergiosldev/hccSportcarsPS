<?php 
//mts 05052012. Fichero ajax para la inserción y modificación de cupones.
    include dirname(__FILE__).'/settings.php'; 
    include_once(dirname(__FILE__).'/../../../../config/config.inc.php');

    $id_usuario=$_GET['id_usuario'];
    
    if (isset($_GET['id_edita_usuario']))   
    {  
        $usu = new Usuario();
        $r=$usu->get($id_usuario);    
        if($r===false) die('Error');
        else 
        {   
            $cad_eval.='id_(\'nombre\').value=\''. $usu->nombre.'\'; ';
            $cad_eval.='id_(\'apellidos\').value=\''. $usu->apellidos.'\'; ';
            $cad_eval.='id_(\'email_oferta\').value=\''. $usu->email.'\'; ';
            $cad_eval.='id_(\'sexoh\').checked=\''.($usu->sexo==1).'\'; ';
            $cad_eval.='id_(\'sexom\').checked=\''.($usu->sexo==2).'\'; ';
            //$cad_eval.='id_(\'password\').value=\''. $usu->password.'\'; ';
            $cad_eval.='id_(\'telefono\').value=\''. $usu->telefono.'\'; ';
            $cad_eval.='id_(\'fecha_nacimiento\').value=\''. substr($usu->fechaNacimiento,8,2).'/'.substr($usu->fechaNacimiento,5,2).'/'.substr($usu->fechaNacimiento,0,4).'\'; ';                   
            $cad_eval.='id_(\'direccion\').value=\''. $usu->direccion.'\'; ';       
            $cad_eval.='id_(\'ciudad\').value=\''. $usu->poblacion.'\'; ';          
            $cad_eval.='id_(\'cpostal\').value=\''. $usu->cPostal.'\'; ';                
            unset($usu);
            die ($cad_eval); 
        }
    }
    else if (isset($_GET['modifica_usuario']))
    {
        foreach ($_GET as $key=>$value) $_GET[$key]=(($value=='')?' ':$value);
        
        $email=$_GET['email_oferta'];
        $nombre=$_GET['nombre'];
        $apellidos=$_GET['apellidos'];
        $password='';
		$password2=$_GET['password'];
        $sexo=($_GET['sexoh']==='1')?1:2;    

        $fecha_nacimiento=substr($_GET['fecha_nacimiento'],6,4).'-'.substr($_GET['fecha_nacimiento'],3,2).'-'.substr($_GET['fecha_nacimiento'],0,2);
        $direccion=$_GET['direccion'];
        $ciudad=$_GET['ciudad'];
        $cpostal=$_GET['cpostal'];
        $telefono=$_GET['telefono'];
        $usu = new Usuario($id_usuario,$email,$password,$nombre, $apellidos, $fecha_nacimiento, 
                             $sexo,$telefono,null,null,null,$direccion,$ciudad,$cpostal,null,null,null);
		$usu->password2=$password2;		
		
        $r=$usu->Update();
		//echo($r);die;
        //var_dump($r);die;
        unset($usu);
        if ($r===false) $r='error'; else $r='OK';
    }
    echo($r);
 
?>

