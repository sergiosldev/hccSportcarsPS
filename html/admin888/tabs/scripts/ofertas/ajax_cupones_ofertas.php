<?php
//mts 05052012. Fichero ajax para la inserción y modificación de cupones.
include dirname(__FILE__).'/settings.php'; 
include dirname(__FILE__).'/funciones_cupon_oferta.php'; 
include dirname(__FILE__).'/funciones_cupon_oferta_historico.php'; 
include dirname(__FILE__).'/../../../../classes/CuponOferta.php'; 
include dirname(__FILE__).'/../../../../classes/CuponOfertaHistorico.php';


$c_id_oferta=$_GET['id_oferta'];
$c_numero_cupon=$_GET['cupon'];
//if (isset($_GET['cupon'])
$c_vendido=$_GET['vendido'];  
 
$c_usado=($_GET['usado']==0)?'1':(($_GET['usado']==1)?'0':$_GET['usado']);

if ($_GET['usado'] == 3) //caso de cancelación de cupón,.
{
        if ($_GET['creadas'])
            $r = UpdateCupon($c_id_oferta, $c_numero_cupon,3);
        else 
            $r = UpdateCuponHistorico($c_id_oferta, $c_numero_cupon,3);
}
elseif ($_GET['usado'] == 4) //caso de eliminación de cupón,.
{
       if ($_GET['creadas']==0)
       {   
           $cupon_oferta_hist = new CuponOfertaHistorico($c_numero_cupon,null,null,$c_id_oferta);
           $idoferta = $cupon_oferta_hist->idOferta;
           $r=$cupon_oferta_hist->Delete();
           if ($r) $r='OK';
           $cupon_oferta = new CuponOferta($c_numero_cupon,null,$idoferta);
           $r=$cupon_oferta->Delete();
           if ($r) $r='OK';
           unset($cupon_oferta);
           unset($cupon_oferta_hist);
       }
 
}

elseif (isset($_GET['observaciones']))
{
    $c_observaciones = $_GET['observaciones'];
    if ($_GET['creadas'])
        $r = UpdateCuponObservaciones($c_id_oferta, $c_numero_cupon,$c_observaciones);
    else 
        $r = UpdateCuponObservacionesHistorico($c_id_oferta, $c_numero_cupon,$c_observaciones);

    echo $r;
    return;
} 

//mts, validación de contraseña al tratar de desbloquear un cupón. 
elseif (isset($_GET['password']) and $_GET['usado']==1) 
{ 
    if ($_GET['password']==_PASSWD_DELETE_)
        {
//            if (isset($_GET['usado']))
        if ($_GET['creadas'])
            $r = UpdateCupon($c_id_oferta, $c_numero_cupon,$c_usado);
        else 
            $r = UpdateCuponHistorico($c_id_oferta, $c_numero_cupon,$c_usado);
            
        
        }
    else $r="error_password";
}
//si el cupón no esta usado, no habremos tenido que introducir la contraseña y por lo tanto 
//simplemente modificaremos su estado o las observaciones.  
else  
    {
    if ($_GET ['creadas'])
        $r = UpdateCupon($c_id_oferta, $c_numero_cupon,$c_usado);
    else        
        $r = UpdateCuponHistorico($c_id_oferta, $c_numero_cupon,$c_usado);
    
    }
echo $r;

?>