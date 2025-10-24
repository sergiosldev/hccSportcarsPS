<?php

include('../config_events.php');
include_once '../functions.php';
include dirname(__FILE__).'/funciones_ofertas_ca.php'; 
include dirname(__FILE__).'/funciones_cupon_oferta_historico_ca.php'; 

include dirname(__FILE__).'/../../../../classes/OfertaHistoricoCA.php'; 

//require_once dirname(__FILE__).'/trazas.php'; 
require_once dirname(__FILE__).'/../contador_periodos_oferta.php'; 

//die('akir');
//if (isset($_POST['idoferta'])) {var_dump($_POST);die;}
//var_dump($_GET['idoferta']);die;
$idoferta="";
//die('condiciones '.request_with_tags('condiciones'));
//echo('edicio_oferta: '.$_GET['idoferta']);var_dump(request('edicio_oferta'));die;


//Para una oferta creadas devolvemos el número de cupones en campañas activas.
if (request('buscar_campanyas_activas'))
{
    $nactivas=0;
    $ohrs = GetOfertasHistoricoCA(null,request('id_oferta'));
    foreach ($ohrs as $ohr)
    {
        if ($ohr->activa) $nactivas+=1;
    }
    echo($nactivas);
    die;
    
}


//Para una oferta creadas devolvemos el número de cupones en campañas activas.
if (request('buscar_cupones_oferta'))
{ 
    $ncupones_campanyas=0;
    if (request('creadas')==1)
        $ohrs = GetOfertasHistoricoCA(null,request('id_oferta'));
    else
        $ohrs = GetOfertasHistoricoCA(request('id_oferta'));
 
    foreach ($ohrs as $ohr)
    {
        //var_dump($ohr);die;
        if ($ohr->activa or request('creadas')==0)
        {
            $cupones = GetCuponesOfertaHistorico($ohr->id);
            if ($cupones) $ncupones_campanyas+=count($cupones);
        }    
     //echo 'cupones '.$ohr->id.' -> '.$ncupones_campanyas;
    }
    echo($ncupones_campanyas);
    die;//die($ncupones_campanyas);
    
}

if (request('reposicionar')!='')
{
    $direccion = $_GET['direccion'];
    $posicion = $_GET['posicion'];
    $ofertaHist = new OfertaHistoricoCA(request('id_oferta_hist'));
    $r=$ofertaHist->ordenOferta($posicion, $direccion); 
    CompactarOrdenOfertasCA('campanyas');
    die($r);
}

if (request('reposicionar_creada')!='')
{
    $direccion = $_GET['direccion'];
    $posicion = $_GET['posicion'];
    $oferta = new OfertaCA(request('id_oferta'));
	//echo($posicion.' '.$direccion);die;
    $r=$oferta->ordenOferta($posicion, $direccion); 
    CompactarOrdenOfertasCA('ofertas');
    die($r);
}
/* 
if (request('marcar_oferta_caducada')!='')
*/ 
if (request('duplicar')=='1')
{
    $o = new OfertaCA(request('id_oferta'));
    $r=$o->get();


    $sdestacados = $o->destacados;
    $sdescripcion = $o->descripcion;
    $scondiciones = $o->condiciones;
    $sdescripcionCupones = $o->descripcionCupones;

    //echo('destacados '.$sdestacados);die;
/*
    $sdestacados = field_to_save($sdestacados,'no_decode_html');
    $sdescripcion = field_to_save($sdescripcion,'no_decode_html');
    $scondiciones = field_to_save($scondiciones,'no_decode_html');
    $sdescripcionCupones = field_to_save($sdescripcionCupones,'no_decode_html');
*/
    $ret=InsertOfertaCA($o->idDesc,$o->titulo, $o->subtitulo, $sdestacados,$scondiciones, $sdescripcion, $o->precioValor,$o->descuento,$o->ahorro,$o->precioFinal,$o->descripcionCupones,$o->multipleCantidad,$o->linkVideo,$o->linkVideo2);

    $idoferta = $ret[0];
    $error = $ret[1];
    if ($error) {unset($o);die('Error: '.$error);}

    $fecha = date('Y-m-d H:i:s');
    $o->UpdateCampo('date_add',$fecha,$idoferta);
    if ($o->clienteEspecial==1)
    {
        //para las ofertas especiales por defecto asignaremos un periodo de 24h que se irá repitiendo
        //de forma cíclica.  Ese periodo se podrá cambiar desde el formulario de activación de ofertas.
        list($fechai,$fechaf) = calcular_fechas_periodo(24);
        $o->UpdateCampo('date_add',$fechai);
        $o->UpdateCampo('date_upd',$fechaf);
    }
    if ($tmp=InsertarImagenesOfertaADuplicadoCA($o->id,$idoferta)) $error = $tmp;
    if ($tmp=MoverArchivosADuplicadoCA($o->id,$idoferta)) $error = $tmp;
    
    if ($error) {unset($o);die('Error: '.$error);}
    
    unset($o);
    die('OK');
} 
 

if (request('duplicar')=='2')
{
    $o = new OfertaCA(request('id_oferta'));
    $r=$o->get();


    $sdestacados = $o->destacados;
    $sdescripcion = $o->descripcion;
    $scondiciones = $o->condiciones;
    $sdescripcionCupones = $o->descripcionCupones;

    //echo('destacados '.$sdestacados);die;
/*
    $sdestacados = field_to_save($sdestacados,'no_decode_html');
    $sdescripcion = field_to_save($sdescripcion,'no_decode_html');
    $scondiciones = field_to_save($scondiciones,'no_decode_html');
    $sdescripcionCupones = field_to_save($sdescripcionCupones,'no_decode_html');
*/
    $ret=InsertOfertaOnline($o->idDesc,$o->titulo, $o->subtitulo, $sdestacados,$scondiciones, $sdescripcion, $o->precioValor,$o->descuento,$o->ahorro,$o->precioFinal,$o->descripcionCupones,$o->multipleCantidad,$o->linkVideo,$o->linkVideo2,1);

    $idoferta = $ret[0];
    $error = $ret[1];
    if ($error) {unset($o);die('Error: '.$error);}

    $fecha = date('Y-m-d H:i:s');
    $o->UpdateCampo('date_add',$fecha,$idoferta);
    if ($o->clienteEspecial==1)
    {
        //para las ofertas especiales por defecto asignaremos un periodo de 24h que se irá repitiendo
        //de forma cíclica.  Ese periodo se podrá cambiar desde el formulario de activación de ofertas.
        list($fechai,$fechaf) = calcular_fechas_periodo(24);
        $o->UpdateCampo('date_add',$fechai);
        $o->UpdateCampo('date_upd',$fechaf);
    }
    if ($tmp=InsertarImagenesOfertaACopiaOfertasOnline($o->id,$idoferta)) $error = $tmp;
    if ($tmp=MoverArchivosACopiaOfertasOnline($o->id,$idoferta)) $error = $tmp;
    
    if ($error) {unset($o);die('Error: '.$error);}
    
    unset($o);
    die('OK');
} 
 
 
 
if (!in_array(trim(request('edicio_oferta')),array('consulta','activar','desactivar')))
{
if (request('titulo_ca')=='') die('Error: Debe introducir el título de la oferta');
if (request('idinterno_ca')=='') die('Error: Debe introducir el identificador interno de la oferta');
if (request('precio_valor_ca')=='') die('Error: Debe introducir el precio de la oferta');
if (request('descuento_ca')=='') die('Error: Debe introducir el porcentaje de descuento de la oferta');
if (request('ahorro_ca')=='') die('Error: Debe introducir el ahorro de la oferta');
if (request('precio_final_ca')=='') die('Error: Debe introducir el precio final de la oferta');
//echo(request('edicio_oferta'));
//echo(request('idoferta'));
}

if (in_array(trim(request('edicio_oferta')),array('alta','edicio')))
{
    
    $maxlineas = 15;
    //Destacados
/*

    $destacados = strip_tags(request('destacados'));
   
     $destacadosw= explode('\n',$destacados);
    
    $nlineas = count($destacadosw);
    die('lineas '.$nlineas);

    foreach($destacadosw as $d)
    {
    $nlineas+=(int)(strlen($d)/62);    
    }
*/
    //die('Error: lineas '.request('nlineas_destacados').'-'.request('nlineas_condiciones').'-'.request('nlineas_descripcion'));
    $nlineas = request('nlineas_destacados');
    if ($nlineas > $maxlineas)
        die('Error: el campo <b>Destacados </b> es demasiado largo'.' : '.$maxlineas.' líneas máximo (Tamaño actual '.$nlineas.' líneas)');

    //Condiciones
    $nlineas = request('nlineas_condiciones');

    if ($nlineas > $maxlineas)
        die('Error: el campo <b>Condiciones </b> es demasiado largo'.' : '.$maxlineas.' líneas máximo (Tamaño actual '.$nlineas.' líneas)');

    //Descripción cupones.
    $nlineas = request('nlineas_descripcion');

    if ($nlineas > $maxlineas)
        die('Error: el campo <b>Descripción Cupones </b> es demasiado largo'.' : '.$maxlineas.' líneas máximo (Tamaño actual '.$nlineas.' líneas)');

}


//echo('edicio_oferta '.request('edicio_oferta'));
//echo('edicio oferta '.$_GET['edicio_oferta']);
//echo('idoferta '.$_GET['idoferta']);
//echo(request('edicio_oferta'));
/*if(request('idoferta')!='') 
{*/
   $idoferta = request('idoferta');
   if (trim($idoferta)=='undefined') $idoferta=''; 
   //Edición.
     
   if (trim($idoferta)!='')  
   {    
       //echo('aki '.request('edicio_oferta'));
       if (in_array(trim(request('edicio_oferta')),array('activar','desactivar')))              
       {
            $periodo = request('periodo');  

            $error=ActivarOfertaCA($idoferta,$periodo,(request('edicio_oferta')=='activar')?1:0,1);           
            //Volvemos a leer los datos de la oferta para saber cuales son las fechas generadas a patir
            //del nuevo periodo.
            $r = new OfertaCA($idoferta);
            $res = $r->get();

           //die ($error);
           if (request('edicio_oferta')=='activar')    
           {
               $ohs = GetOfertasHistoricoCA(null,$idoferta);
               //Actualizamos la oferta activa de la campaña con las fechas resultantes del nuevo periodo
               //seleccionado.
               
               $campanya_encontrada = false;                 
               foreach ($ohs as $oh)
               {
                   //if ($oh->caducada!=1)
                   if ($oh->activa==1)
                   {
                       $campanya_encontrada = true;
                   }
               }
            

               if (!$campanya_encontrada)               
               {
                   $sdestacados = $r->destacados;
                   $sdescripcion = $r->descripcion;
                   $scondiciones = $r->condiciones;
                   $sdescripcionCupones = $r->descripcionCupones;

                   $ret=InsertOfertaHistoricoCA($idoferta,$r->idDesc,$r->titulo, $r->subtitulo,$sdestacados, $scondiciones,$sdescripcion,$r->precioValor,$r->descuento,$r->ahorro,$r->precioFinal,$r->fechaInicio,$r->fechaFin,$r->activa,$sdescripcionCupones,$r->multipleCantidad,$r->linkVideo,$r->linkVideo2);
                   
                   $idoferta = $ret[0];
                   $error = $ret[1];
               }
           } 
           
           unset($r);    
           if ($campanya_encontrada) die('Error: Campanya activa');
           if ($error) die('Error: '.$error);
           else die('id_(\'oferta_activa_ca\').value=\''. ((request('edicio_oferta')=='activar')?1:0).'\'; ');    
            //fin inserción.
       }
       //caso en que se actualicen las observaciones de una oferta desde la lista de cupones.
       /*else if (request('edicio_oferta')=='update_observaciones')
        {
           $ret = UpdateObservacionesOfertaHistorico(); 
        }*/
       else
       {     
           if (request('edicio_oferta')=='edicio')
           { 
                $fecha_inicio = request('fecha_inicio_ca');
                $fecha_fin = request('fecha_fin_ca');
                //date_default_timezone_set("Europe/Paris"); 
                $fecha_inicio = mktime(substr($fecha_inicio,11,2),substr($fecha_inicio,14,2),substr($fecha_inicio,17,2),substr($fecha_inicio,3,2),substr($fecha_inicio,0,2),substr($fecha_inicio,6,4));
                $fecha_inicio = date('Y-m-d H:i:s',$fecha_inicio);
                $fecha_fin = mktime(substr($fecha_fin,11,2),substr($fecha_fin,14,2),substr($fecha_fin,17,2),substr($fecha_fin,3,2),substr($fecha_fin,0,2),substr($fecha_fin,6,4));
                $fecha_fin = date('Y-m-d H:i:s',$fecha_fin);
                
               // traza('debug.txt','multiplecantidad '.request('multiple_cantidad'));
                //die(request_with_tags('descripcion_cupones'));
                $sufijo_desc_cupones = '';

                //die('cantidad '.request('multiple_cantidad_ca'));
                $error=UpdateOfertaCA($idoferta,request('idinterno_ca'),request('titulo_ca'), request('subtitulo_ca'), request_with_tags('destacados_ca'), request_with_tags('condiciones_ca'), request_with_tags('descripcion_ca'), request('precio_valor_ca'),request('descuento_ca'),request('ahorro_ca'),request('precio_final_ca'),request_with_tags('descripcion_cupones_ca'),request('multiple_cantidad_ca'),request('link_video_oferta_ca'),request('link_video_oferta2_ca'));
                                                                                                                                                                                                          
                if ($error) die('Error: '.$error); 
           
           }
    
           $r = GetOfertasCA($idoferta);
           $r = $r[0];
    
       
           $sdestacados = str_replace(array("\r", "\n"), array("", ""),$r->destacados);
           $sdescripcion = str_replace(array("\r", "\n"), array("", ""),$r->descripcion);
           $sdescripcionCupones = str_replace(array("\r", "\n"), array("", ""),$r->descripcionCupones);
           $scondiciones = str_replace(array("\r", "\n"), array("", ""),$r->condiciones);
        
		   $titulo = str_replace(array("\r", "\n"), array("", " "),$r->titulo);
           $subtitulo = str_replace(array("\r", "\n"), array("", " "),$r->subtitulo);
           
           
           $cad_eval='';
           $cad_eval.='id_(\'titulo_ca\').value=\''. $titulo.'\'; ';
           $cad_eval.='id_(\'subtitulo_ca\').value=\''. $subtitulo.'\'; ';
           $cad_eval.='id_(\'idinterno_ca\').value=\''. $r->idDesc.'\'; ';
           $cad_eval.='id_(\'precio_valor_ca\').value=\''.$r->precioValor.'\'; ';
           $cad_eval.='id_(\'descuento_ca\').value=\''. $r->descuento.'\'; ';          
           $cad_eval.='id_(\'precio_final_ca\').value=\''.$r->precioFinal.'\'; ';
           $cad_eval.='id_(\'ahorro_ca\').value=\''. $r->ahorro.'\'; ';    
           $cad_eval.='id_(\'oferta_activa_ca\').value=\''. $r->activa.'\'; ';    
           $cad_eval.='id_(\'multiple_cantidad_ca\').value=\''. $r->multipleCantidad.'\'; '; 
           $cad_eval.='id_(\'link_video_oferta_ca\').value=\''. $r->linkVideo.'\'; ';    
           $cad_eval.='id_(\'link_video_oferta2_ca\').value=\''. $r->linkVideo2.'\'; ';    
                         
           //$cad_eval.='id_(\'cliente_especial_ca\').value=\''. $r->clienteEspecial.'\'; ';    
                      
           if ($r->multipleCantidad==2)
           {
                $cad_eval.='id_(\'multiple_dos_ca\').checked=true; ';    
                $cad_eval.='id_(\'multiple_uno_ca\').checked=false; ';    
           }
           else
           {    
                $cad_eval.='id_(\'multiple_dos_ca\').checked=false; ';    
                $cad_eval.='id_(\'multiple_uno_ca\').checked=true; ';    
           }                      
           $cad_eval.='tinyMCE.get("destacados_ca").setContent(\''.$sdestacados.'\'); ';
           $cad_eval.='tinyMCE.get("condiciones_ca").setContent(\''.$scondiciones.'\'); ';
           $cad_eval.='tinyMCE.get("descripcion_ca").setContent(\''.$sdescripcion.'\'); ';
           $cad_eval.='tinyMCE.get("descripcion_cupones_ca").setContent(\''.$sdescripcionCupones.'\'); ';
           die($cad_eval);
       } 
   }
    //Alta.
    else  if (request('edicio_oferta')=='alta')// if ($_REQUEST['edicio_oferta']!='CARGA_INICIAL') //edicio_oferta será = 'CARGA_INICIAL' cuando seleccionemos "CREAR OFERTA" en el menú de ofertas.
    {
       
        $fecha_inicio = request('fecha_inicio_ca');
        $fecha_fin = request('fecha_fin_ca');
        //date_default_timezone_set("Europe/Paris"); 
        $fecha_inicio = mktime(substr($fecha_inicio,11,2),substr($fecha_inicio,14,2),substr($fecha_inicio,17,2),substr($fecha_inicio,3,2),substr($fecha_inicio,0,2),substr($fecha_inicio,6,4));
        $fecha_inicio = date('Y-m-d H:i:s',$fecha_inicio);
        $fecha_fin = mktime(substr($fecha_fin,11,2),substr($fecha_fin,14,2),substr($fecha_fin,17,2),substr($fecha_fin,3,2),substr($fecha_fin,0,2),substr($fecha_fin,6,4));
        $fecha_fin = date('Y-m-d H:i:s',$fecha_fin);
        
    //var_dump($_REQUEST);die;
        $ret=InsertOfertaCA(request('idinterno_ca'),request('titulo_ca'), request('subtitulo_ca'), request_with_tags('destacados_ca'), request_with_tags('condiciones_ca'), request_with_tags('descripcion_ca'), request('precio_valor_ca'),request('descuento_ca'),request('ahorro_ca'),request('precio_final_ca'),request_with_tags('descripcion_cupones_ca'),request('multiple_cantidad_ca'),request('link_video_oferta_ca'),request('link_video_oferta2_ca'));
         //die('Error: '.$ret);
        $idoferta = $ret[0];
        $error = $ret[1];
        if ($error) die('Error: '.$error);
        $r = array();
        $cad_eval='id_(\'idoferta_ca\').value=\''. $idoferta.'\'; ';
        
        die($cad_eval);
    }

//}   
?>