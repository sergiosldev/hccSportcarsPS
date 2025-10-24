<?php

include dirname(__FILE__).'/settings.php'; 
include dirname(__FILE__).'/funciones_ofertas.php'; 
include dirname(__FILE__).'/../../../classes/Oferta_.php'; 
include dirname(__FILE__).'/../../../classes/OfertaHistorico.php'; 
include dirname(__FILE__).'/trazas.php'; 


$e_id_oferta = $_GET['id_oferta'];
//mts, validación de contraseña al tratar de borrar una oferta.
if (isset($_GET['password'])) 
{
    if ($_GET['password']==_PASSWD_DELETE_)
        {
        if ($_GET['creadas']==1)    
         { 
            $oferta = new Oferta_();
            $r=$oferta->get($e_id_oferta);
            $cliente_especial_nuevo = ($oferta->clienteEspecial==1)?0:1;
            if ($r) $r= 'OK';
            $r=$oferta->UpdateCampo('cliente_especial',$cliente_especial_nuevo,$e_id_oferta);
            $r=$oferta->UpdateCampo('active',$cliente_especial_nuevo,$e_id_oferta);
            //para las ofertas especiales por defecto asignaremos un periodo de 24h que se irá repitiendo
            //de forma cíclica.  Ese periodo se podrá cambiar desde el formulario de activación de ofertas.
            list($fechai,$fechaf) = calcular_fechas_periodo(24);
            $oferta->UpdateCampo('date_add',$fechai,$e_id_oferta);
            $oferta->UpdateCampo('date_upd',$fechaf,$e_id_oferta);
            
            if ($r) $r = 'OK';                 
            $ofertaHist = new OfertaHistorico(null,$e_id_oferta);
            //Buscamos una campaña para la oferta $e_id_oferta que esté marcada como especial.
            //Dicha campaña debería estar siempre activa.
            $r=GetOfertasHistoricoCA(null,$e_id_oferta,null,1);
            $ofertaHist=$r[0];    
            traza('debug.txt','especial '.$cliente_especial_nuevo.' idofhist '.$ofertaHist->id);            
            if ($cliente_especial_nuevo==1)
            {
                if ($ofertaHist->id == null)
                {
                    $sdestacados = $oferta->destacados;    
                    $scondiciones = $oferta->condiciones;    
                    $sdescripcion = $oferta->descripcion;    
                    $sdescripcionCupones = $oferta->descripcionCupones;    
                    /*$sdestacados = field_to_save($sdestacados,'sin_slashes');
                    $sdescripcion = field_to_save($descripcion,'sin_slashes');
                    $scondiciones = field_to_save($scondiciones,'sin_slashes');
                    $sdescripconCupones = field_to_save($sdescripcionCupones,'sin_slashes');*/

                    $r=InsertOfertaHistoricoCA($e_id_oferta,$oferta->idDesc,$oferta->titulo, $oferta->subtitulo, $oferta->destacados, $oferta->condiciones, $oferta->descripcion, $oferta->precioValor,$oferta->descuento,$oferta->ahorro,$oferta->precioFinal,$fechai,$fechaf,'1','',1);                
                    $ofertaHist = new OfertaHistorico(null,$e_id_oferta);
                }    
                $r=$ofertaHist->UpdateCampo('cliente_especial',$cliente_especial_nuevo,$ofertaHist->id);
                $r=$ofertaHist->UpdateCampo('active',$cliente_especial_nuevo,$ofertaHist->id);
            }
            else if($ofertaHist->id!=null) 
            {
                $r=$ofertaHist->UpdateCampo('active',0,$ofertaHist->id);
                $r=$ofertaHist->UpdateCampo('caducada',1,$ofertaHist->id);
            }
                
            if ($r) $r = 'OK';

            unset($oferta);
            unset($ofertaHist);            
         }
        }
    else $r='error_password';         
}

echo $r;
?>