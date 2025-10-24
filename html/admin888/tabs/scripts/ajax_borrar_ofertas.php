<?php

include dirname(__FILE__).'/settings.php'; 
include dirname(__FILE__).'/funciones_ofertas.php'; 
include dirname(__FILE__).'/funciones_cupon_oferta_historico.php'; 
include dirname(__FILE__).'/../../../classes/OfertaHistorico.php';
include dirname(__FILE__).'/../../../classes/Oferta_.php';

$password2 = (request('tipo_password')=='facturados')?_PASSWD_DELETE_FACTURADOS_:_PASSWD_DELETE_; 
$e_id_oferta = intval(request('id_oferta'));
$password = request('password');
$creadas = intval(request('creadas'));

//mts, validación de contraseña al tratar de borrar una oferta.
if ($password) 
{
    if ($password==$password2)
        {
        if ($creadas==1)    
         {
                $oferta=new Oferta_($e_id_oferta);    
                $r=$oferta->get();
                $r=DeleteOfertas($e_id_oferta);
                CompactarOrdenOfertas('ofertas');
                if ($oferta->clienteEspecial==1)
                {
                    $ofertasHistorico = GetOfertasHistorico(null,$e_id_oferta);
                    foreach($ofertasHistorico as $oh)        
                    {
                        if ($oh and $oh->clienteEspecial==1)
                        {
                            $oh->updateCampo('active',0);
                            $oh->updateCampo('caducada',1);
                            CompactarOrdenOfertas('campanyas');
                            break;
                        }
                    }
                }
         }                
        else //si creadas==0 significa que estamos en el registro de campañas, luego e_id_oferta 
            // se corresponderá con el campo id_oferta_hist de la tabla de histórico.
               $r=DeleteOfertasHist($e_id_oferta);                                   
        }
    else $r='error_password'; 
        
}

echo $r;
?>