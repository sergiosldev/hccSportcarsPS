<?php

include dirname(__FILE__).'/../settings.php'; 
include dirname(__FILE__).'/funciones_ofertas_ca.php'; 
include dirname(__FILE__).'/../../../../classes/OfertaHistoricoCA.php';
include dirname(__FILE__).'/../../../../classes/OfertaCA.php';

$password2 = (request('tipo_password')=='facturados')?_PASSWD_DELETE_FACTURADOS_:_PASSWD_DELETE_;
$password = request('password');
$creadas = intval(request('creadas'));
$e_id_oferta = intval(request('id_oferta'));
//mts, validación de contraseña al tratar de borrar una oferta.
if ($password) 
{
    if ($password==$password2)
        {
        if ($creadas==1)    
            {
                
                $r=DeleteOfertasCA($e_id_oferta);
                CompactarOrdenOfertasCA('ofertas');
                
                //$oh = new OfertaHistorico(null,$e_id_oferta);                       
                $ofertasHistorico = GetOfertasHistoricoCA(null,$e_id_oferta);
                foreach($ofertasHistorico as $oh)
                {
                if ($oh)
                $r=DeleteOfertasHistCA($oh->id);
                CompactarOrdenOfertasCA('campanyas');
                }
            
            }                                   
        else //si creadas==0 significa que estamos en el registro de campañas, luego e_id_oferta 
            // se corresponderá con el campo id_oferta_hist de la tabla de histórico.
            $r=DeleteOfertasHistCA($e_id_oferta);                                   
        }
    else $r='error_password'; 
        
}

echo $r;
?>