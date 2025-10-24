<?php
//mts 05052012. Fichero ajax para la inserción y modificación de cupones.
include dirname(__FILE__).'/../settings.php'; 
include dirname(__FILE__).'/funciones_cupon_oferta_ca.php'; 
include dirname(__FILE__).'/funciones_cupon_oferta_historico_ca.php'; 
include dirname(__FILE__).'/../../../../classes/CuponOfertaCA.php'; 
include dirname(__FILE__).'/../../../../classes/CuponOfertaHistoricoCA.php';


$c_id_oferta=$_GET['id_oferta'];
$c_numero_cupon=$_GET['cupon'];
$c_vendido=$_GET['vendido'];
 
$c_usado=($_GET['usado']==0)?'1':(($_GET['usado']==1)?'0':$_GET['usado']);


if (isset($_GET['observaciones']))
{
    $c_observaciones = $_GET['observaciones'];
    if ($_GET['creadas'])
        $r = UpdateCuponObservaciones($c_id_oferta, $c_numero_cupon,$c_observaciones);
    else 
        $r = UpdateCuponObservacionesHistorico($c_id_oferta, $c_numero_cupon,$c_observaciones);

    echo $r;
    return;
} 


elseif (in_array($_GET['usado'],array(3,4,5,6,7,8,9,10)))
//mts, validación de contraseña al tratar de desbloquear un cupón. 
{
    switch($_GET['usado'])
    {
        case 3://caso de cancelación de cupón,.
            if ($_GET['creadas'])
                $r = UpdateCupon($c_id_oferta, $c_numero_cupon,3);
            else {
                $r = UpdateCuponHistorico($c_id_oferta, $c_numero_cupon,3);
//              die($r);
                
                }
        break;
        case 4://caso de eliminación de cupón,.
           if ($_GET['creadas']==0)
           {   
               $cupon_oferta_hist = new CuponOfertaHistoricoCA($c_numero_cupon,null,null,$c_id_oferta);
               $idoferta = $cupon_oferta_hist->idOferta;
               $r=$cupon_oferta_hist->Delete();
               if ($r) $r='OK';
               $cupon_oferta = new CuponOfertaCA($c_numero_cupon,null,$idoferta);
               $r=$cupon_oferta->Delete();
               if ($r) $r='OK';
               unset($cupon_oferta);
               unset($cupon_oferta_hist);
               
           }
        break;
        case 5:case 6:case 7:case 8:case 9:case 10:
            if ($_GET ['creadas'])
                $r = UpdateCupon($c_id_oferta, $c_numero_cupon,$_GET['usado']);
            else        
                $r = UpdateCuponHistorico($c_id_oferta, $c_numero_cupon,$_GET['usado']);
        break;
                                                            
    }
}
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