<?php

include dirname(__FILE__).'/settings.php'; 
include dirname(__FILE__).'/funciones_ofertas.php'; 
include dirname(__FILE__).'/../../../../classes/Oferta_.php'; 
include dirname(__FILE__).'/../../../../classes/OfertaHistorico.php'; 
//include dirname(__FILE__).'/trazas.php'; 


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
            if ($cliente_especial_nuevo==1)
				$r=$oferta->UpdateCampo('motorclub',1,$e_id_oferta);
			
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
            $r2=GetOfertasHistorico(null,$e_id_oferta,null,1);
            $ofertaHist=$r2[0];    
            //traza('debug.txt','especial '.$cliente_especial_nuevo.' idofhist '.$ofertaHist->id);            
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
/*function InsertOfertaHistorico($inIdOferta,$inIdDesc,$inTitulo, $inSubtitulo, $inDestacados, $inCondiciones, $inDescripcion, $inPrecioValor,$inDescuento,$inAhorro,$inPrecioFinal,$inFechaInicio,$inFechaFin,
                                                                                                                                                                                                        $inActiva,$inDescripcionCupones,$inMultipleCantidad,$inClienteEspecial=null,$inLinkVideo=null,$inLinkVideo2=null)
                                                                                                                                                                                                        */
                    
                    $r=InsertOfertaHistorico($e_id_oferta,$oferta->idDesc,$oferta->titulo, $oferta->subtitulo, $oferta->destacados, $oferta->condiciones, $oferta->descripcion, $oferta->precioValor,$oferta->descuento,$oferta->ahorro,$oferta->precioFinal,$fechai,$fechaf,'1',$sdescripcionCupones,$oferta->multipleCantidad,null,$oferta->linkVideo,$oferta->linkVideo2);                
                    $ofertaHist = new OfertaHistorico($r[0],$e_id_oferta);
					
				    $opciones = GetOpcionesOferta($e_id_oferta);
                    $idofertah = $r[0];
                    $error = $r[1];

					foreach($opciones as $opc)
					{
					$opch = new OpcionOfertaHistorico();
					$opch->idOfertaHist=$idofertah;
					$opch->idOpcionOferta=$opc->id;
					$opch->idDesc=$opc->idDesc;
					$opch->titulo=$opc->titulo;
					$opch->subtitulo=$opc->subtitulo;
					$opch->destacados=$opc->destacados;
					$opch->condiciones=$opc->condiciones;
					$opch->descripcion=$opc->descripcion;
					$opch->precioValor=$opc->precioValor;
					$opch->descuento=$opc->descuento;
					$opch->precioFinal=$opc->precioFinal;
					$opch->ahorro=$opc->ahorro;	               	
					$opch->Insert();
					}			
					
					
                }    
                $r=$ofertaHist->UpdateCampo('cliente_especial',$cliente_especial_nuevo,$ofertaHist->id);
                $r=$ofertaHist->UpdateCampo('active',$cliente_especial_nuevo,$ofertaHist->id);
                $r=$ofertaHist->UpdateCampo('motorclub',1,$ofertaHist->id);
            }
            //cuando marquemos una oferta para "cliente especial" como "no especial" la desactivaremos y marcaremos como caducada.
            else if($ofertaHist->id!=null) 
            {
                
                $r=$ofertaHist->UpdateCampo('active',0,$ofertaHist->id);
                $r=$ofertaHist->UpdateCampo('caducada',1,$ofertaHist->id);
                //traza('debug.txt','oferta '.$ofertaHist->id.' desactivada ');
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