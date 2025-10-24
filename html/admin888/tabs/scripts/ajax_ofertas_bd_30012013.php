<?php
include('config_events.php');
include_once 'functions.php';
include dirname(__FILE__).'/funciones_ofertas.php'; 
include dirname(__FILE__).'/funciones_cupon_oferta_historico.php'; 
include dirname(__FILE__).'/../../../classes/OfertaHistorico.php'; 
//require_once dirname(__FILE__).'/trazas.php'; 
require_once dirname(__FILE__).'/contador_periodos_oferta.php'; 
$idoferta="";





//Para una oferta creadas devolvemos el número de cupones en campañas activas.
if (request('buscar_campanyas_activas'))
{
    $nactivas=0;
    $ohrs = GetOfertasHistorico(null,request('id_oferta'));
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
        $ohrs = GetOfertasHistorico(null,request('id_oferta'));
    else
        $ohrs = GetOfertasHistorico(request('id_oferta'));
    
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
    $direccion = request('direccion');
    $posicion = request('posicion'); //$_GET['posicion'];
    $ofertaHist = new OfertaHistorico(request('id_oferta_hist'));
    $r=$ofertaHist->ordenOferta($posicion, $direccion); 
    CompactarOrdenOfertas('campanyas');
    die($r);
}

if (request('reposicionar_creada')!='')
{
    $direccion = request('direccion');
    $posicion = request('posicion');
    $oferta = new Oferta_(request('id_oferta'));
    $r=$oferta->ordenOferta($posicion, $direccion); 
    CompactarOrdenOfertas('ofertas');
    die($r);
}


if (request('marcar_oferta_caducada')!='')
{
    
    $ofertaH = new OfertaHistorico(request('id_oferta_hist'));

    //Si la oferta ha sido activada como especial, en lugar de desactivarla y marcarla como caducada
    //reiniciaremos el contador de tiempo.
    //traza('debug2.txt','marca_caducada');
    if (request('cliente_especial')==1)
    {
        $r=GetOfertasHistorico(request('id_oferta_hist'));
        //var_dump($r);die;
        $ofertaH = $r[0];  
        $fechaIni = $ofertaH->fechaInicio;
        $fechaFin = $ofertaH->fechaFin;
        if ($ofertaH->caducada!=1)
        {
            //traza('debug2.txt','oferta_especial');
                    //$fechaFin = '2013-01-18 00:00:00';
            if ($ofertaH->activa=='1')
               {
                $periodo = calcular_periodo($fechaIni,$fechaFin);
                if ($periodo==0) $periodo=24; 
               } 
            else $periodo = 24;
            $dias_periodo = (int)$periodo/24; 
            //traza('debug2.txt','periodo: '.$periodo.'oferta: '.$ofertaH->id);
            $hora_actual = time(); 
            //if ($ofertaH->id==13)
            //$hora_actual = mktime(23,59,50,1,16,2013);
            
            $fecha_actual_bd = date("Y-m-d H:i:s",$hora_actual);
            $fecha_actual = date("d/m/Y H:i:s",$hora_actual);
            
            $fecha_actual_arr = explode(' ',$fecha_actual_bd);
            list($a,$m,$d) = explode('-',$fecha_actual_arr[0]); 
            //return($a.'-'.$m.'-'.$d); 
            $fecha_fin_periodo = mktime(0,0,0, $m,$d,$a) + $dias_periodo * 24 * 60 * 60;
            $fecha_fin_periodo_bd = date("Y-m-d H:i:s",$fecha_fin_periodo);
            $fecha_fin_periodo = date("d/m/Y H:i:s",$fecha_fin_periodo);

            //traza('debug2.txt','fecha act:'.$fecha_actual.' fecha fin periodo: '.$fecha_fin_periodo);        
             
            //modificamos el periodo de la campaña.
            $r=$ofertaH->UpdateCampo('date_add',$fecha_actual_bd);
            $r=$ofertaH->UpdateCampo('date_upd',$fecha_fin_periodo_bd);
            
            //modificamos el periodo de la oferta que debe ser igual al de la campaña.
            $oferta = new Oferta_();
            $r=$oferta->UpdateCampo('date_add',$fecha_actual_bd,$ofertaH->idOferta);
            $r=$oferta->UpdateCampo('date_upd',$fecha_fin_periodo_bd,$ofertaH->idOferta);
    
            unset($oferta);    
            unset ($ofertaH);
            die($fecha_fin_periodo.'#'.$fecha_actual);
        } 
    }


    //Si no es una oferta especial la marcaremos como caducada.
    $r=GetOfertasHistorico(request('id_oferta_hist'));
    $ofertaH = $r[0];
    if ($ofertaH->caducada!=1)
    {
        //traza('debug.txt','caducada '.$ofertaH->id);
        $ofertaH->UpdateCampo('active',0,request('id_oferta_hist'));    
        $ofertaH->UpdateCampo('caducada',1,request('id_oferta_hist'));  
            
        $ofertashist = GetOfertasHistorico(null,$ofertaH->idOferta);
        //var_dump($ofertashist);die;
        
        //traza('debug.txt','campaña desactivada autom.');
        $camp_inactivas = true; //por defecto supondremos que todas las campañas están inactivas
        //var_dump($ofertashist);die;
        foreach($ofertashist as $oh)
        {
            //traza('debug.txt','camp: '.$oh->id.' activa '.$oh->activa);
            if ($oh->activa==1) {$camp_inactivas = false;break;}
        }
        
        if ($camp_inactivas)
        {   // traza('debug.txt','oferta '.$ofertaH->idOferta.' desactivada autom.');
            $oferta = new Oferta_();
            $oferta->UpdateCampo('active',0,$ofertaH->idOferta);
            unset($oferta);    
        }
        else {/*traza('debug.txt','se encontró campaña activa, la oferta no se puede desactivar.');*/}
        unset($ofertaH);
    }
    die;
}
  
 
if (request('duplicar')=='1')
{
    $o = new Oferta_(request('id_oferta'));
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
    $ret=InsertOferta($o->idDesc,$o->titulo, $o->subtitulo, $sdestacados,$scondiciones, $sdescripcion, $o->precioValor,$o->descuento,$o->ahorro,$o->precioFinal,$o->descripcionCupones,$o->multipleCantidad,$o->linkVideo,$o->linkVideo2);

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
    if ($tmp=InsertarImagenesOfertaADuplicado($o->id,$idoferta)) $error = $tmp;
    if ($tmp=MoverArchivosADuplicado($o->id,$idoferta)) $error = $tmp;
    
    if ($error) {unset($o);die('Error: '.$error);}
    
    unset($o);
    die('OK');
} 
 

if (!in_array(trim(request('edicio_oferta')),array('consulta','activar','desactivar')))
{
if (request('titulo')=='') die('Error: Debe introducir el título de la oferta');
if (request('idinterno')=='') die('Error: Debe introducir el identificador interno de la oferta');
if (request('precio_valor')=='') die('Error: Debe introducir el precio de la oferta');
if (request('descuento')=='') die('Error: Debe introducir el porcentaje de descuento de la oferta');
if (request('ahorro')=='') die('Error: Debe introducir el ahorro de la oferta');
if (request('precio_final')=='') die('Error: Debe introducir el precio final de la oferta');
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

            $error=ActivarOferta($idoferta,$periodo,(request('edicio_oferta')=='activar')?1:0,1);           
            //Volvemos a leer los datos de la oferta para saber cuales son las fechas generadas a patir
            //del nuevo periodo.
            $r = new Oferta_($idoferta);
            $res = $r->get();

           //die ($error);
           if (request('edicio_oferta')=='activar')    
           {
               $ohs = GetOfertasHistorico(null,$idoferta);  
               //Actualizamos la oferta activa de la campaña con las fechas resultantes del nuevo periodo
               //seleccionado.
               
               $campanya_encontrada = false;                 
               foreach ($ohs as $oh)
               {
                   if ($oh->caducada!=1)
                   {
                       //traza('debug.txt',$oh->id);
                       $res=$oh->UpdateCampo('active',1);
                       $res=$oh->UpdateCampo('date_add',$r->fechaInicio);
                       $res=$oh->UpdateCampo('date_upd',$r->fechaFin);
                       $campanya_encontrada = true;
                   }
               }

               if (!$campanya_encontrada)               
               {
                   /*
                   $sdestacados = str_replace(array("\r", "\n"), array("", ""),field_with_tags($r->destacados));
                   $sdescripcion = str_replace(array("\r", "\n"), array("", ""),field_with_tags($r->descripcion));
                   $scondiciones = str_replace(array("\r", "\n"), array("", ""),field_with_tags($r->condiciones));
                   $sdescripcionCupones = str_replace(array("\r", "\n"), array("", ""),field_with_tags($r->descripcionCupones));
                   */
                   $sdestacados = $r->destacados;
                   $sdescripcion = $r->descripcion;
                   $scondiciones = $r->condiciones;
                   $sdescripcionCupones = $r->descripcionCupones;
                   /*$sdestacados = str_replace(array("\r", "\n"), array("", ""),$r->destacados);
                   $sdescripcion = str_replace(array("\r", "\n"), array("", ""),$r->descripcion);
                   $scondiciones = str_replace(array("\r", "\n"), array("", ""),$r->condiciones);
                   $sdescripcionCupones = str_replace(array("\r", "\n"), array("", ""),$r->descripcionCupones);
                   $sdestacados = field_to_save($sdestacados,'no_decode_html');
                   $sdescripcion = field_to_save($descripcion,'no_decode_html');
                   $scondiciones = field_to_save($scondiciones,'no_decode_html');
                   $sdescripconCupones = field_to_save($sdescripcionCupones,'no_decode_html');
                    */

                   $ret=InsertOfertaHistorico($idoferta,$r->idDesc,$r->titulo, $r->subtitulo,$sdestacados, $scondiciones,$sdescripcion,$r->precioValor,$r->descuento,$r->ahorro,$r->precioFinal,$r->fechaInicio,$r->fechaFin,$r->activa,$sdescripcionCupones,$r->multipleCantidad,$r->clienteEspecial,$r->linkVideo,$r->linkVideo2);
                   
                   $idoferta = $ret[0];
                   $error = $ret[1];
               }
           } 
           
           unset($r);    
           if ($error) die('Error: '.$error);
           else die('id_(\'oferta_activa\').value=\''. ((request('edicio_oferta')=='activar')?1:0).'\'; ');    
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
                $fecha_inicio = request('fecha_inicio');
                $fecha_fin = request('fecha_fin');
                //date_default_timezone_set("Europe/Paris"); 
                $fecha_inicio = mktime(substr($fecha_inicio,11,2),substr($fecha_inicio,14,2),substr($fecha_inicio,17,2),substr($fecha_inicio,3,2),substr($fecha_inicio,0,2),substr($fecha_inicio,6,4));
                $fecha_inicio = date('Y-m-d H:i:s',$fecha_inicio);
                $fecha_fin = mktime(substr($fecha_fin,11,2),substr($fecha_fin,14,2),substr($fecha_fin,17,2),substr($fecha_fin,3,2),substr($fecha_fin,0,2),substr($fecha_fin,6,4));
                $fecha_fin = date('Y-m-d H:i:s',$fecha_fin);
                
               // traza('debug.txt','multiplecantidad '.request('multiple_cantidad'));
                //die(request_with_tags('descripcion_cupones'));
                $error=UpdateOferta($idoferta,request('idinterno'),request('titulo'), request('subtitulo'), request_with_tags('destacados'), request_with_tags('condiciones'), request_with_tags('descripcion'), request('precio_valor'),request('descuento'),request('ahorro'),request('precio_final'),request_with_tags('descripcion_cupones'),request('multiple_cantidad'),request('link_video_oferta'),request('link_video_oferta2'));
                
                if ($error) die('Error: '.$error);
           
           }
    
           $r = GetOfertas($idoferta);
           $r = $r[0];
    
       
           $sdestacados = str_replace(array("\r", "\n"), array("", ""),$r->destacados);
           $sdescripcion = str_replace(array("\r", "\n"), array("", ""),$r->descripcion);
           $sdescripcionCupones = str_replace(array("\r", "\n"), array("", ""),$r->descripcionCupones);
           $scondiciones = str_replace(array("\r", "\n"), array("", ""),$r->condiciones);
           
           
           
           
           
           $cad_eval='';
           $cad_eval.='id_(\'titulo\').value=\''. $r->titulo.'\'; ';
           $cad_eval.='id_(\'subtitulo\').value=\''. $r->subtitulo.'\'; ';
           $cad_eval.='id_(\'idinterno\').value=\''. $r->idDesc.'\'; ';
           $cad_eval.='id_(\'precio_valor\').value=\''.$r->precioValor.'\'; ';
           $cad_eval.='id_(\'descuento\').value=\''. $r->descuento.'\'; ';          
           $cad_eval.='id_(\'precio_final\').value=\''.$r->precioFinal.'\'; ';
           $cad_eval.='id_(\'ahorro\').value=\''. $r->ahorro.'\'; ';    
           $cad_eval.='id_(\'oferta_activa\').value=\''. $r->activa.'\'; ';    
           $cad_eval.='id_(\'multiple_cantidad\').value=\''. $r->multipleCantidad.'\'; ';    
           $cad_eval.='id_(\'cliente_especial\').value=\''. $r->clienteEspecial.'\'; ';    
           $cad_eval.='id_(\'link_video_oferta\').value=\''. $r->linkVideo.'\'; ';    
           $cad_eval.='id_(\'link_video_oferta2\').value=\''. $r->linkVideo2.'\'; ';    
                                            
           if ($r->multipleCantidad==2)
           {
                $cad_eval.='id_(\'multiple_dos\').checked=true; ';    
                $cad_eval.='id_(\'multiple_uno\').checked=false; ';    
           }
           else
           {    
                $cad_eval.='id_(\'multiple_dos\').checked=false; ';    
                $cad_eval.='id_(\'multiple_uno\').checked=true; ';    
           }                      
           $cad_eval.='tinyMCE.get("destacados").setContent(\''.$sdestacados.'\'); ';
           $cad_eval.='tinyMCE.get("condiciones").setContent(\''.$scondiciones.'\'); ';
           $cad_eval.='tinyMCE.get("descripcion").setContent(\''.$sdescripcion.'\'); ';
           $cad_eval.='tinyMCE.get("descripcion_cupones").setContent(\''.$sdescripcionCupones.'\'); ';
           /*$cad_eval.='id_(\'password\').value=\''. $r['password'].'\'; ';
           $cad_eval.='id_(\'cpostal\').value=\''. $r['cpostal'].'\'; ';
           */
           die($cad_eval);
       } 
   }
    //Alta.
    else  if (request('edicio_oferta')=='alta')// if ($_REQUEST['edicio_oferta']!='CARGA_INICIAL') //edicio_oferta será = 'CARGA_INICIAL' cuando seleccionemos "CREAR OFERTA" en el menú de ofertas.
    {
        $fecha_inicio = request('fecha_inicio');
        $fecha_fin = request('fecha_fin');
        //date_default_timezone_set("Europe/Paris"); 
        $fecha_inicio = mktime(substr($fecha_inicio,11,2),substr($fecha_inicio,14,2),substr($fecha_inicio,17,2),substr($fecha_inicio,3,2),substr($fecha_inicio,0,2),substr($fecha_inicio,6,4));
        $fecha_inicio = date('Y-m-d H:i:s',$fecha_inicio);
        $fecha_fin = mktime(substr($fecha_fin,11,2),substr($fecha_fin,14,2),substr($fecha_fin,17,2),substr($fecha_fin,3,2),substr($fecha_fin,0,2),substr($fecha_fin,6,4));
        $fecha_fin = date('Y-m-d H:i:s',$fecha_fin);
        
    //var_dump($_REQUEST);die;

        $ret=InsertOferta(request('idinterno'),request('titulo'), request('subtitulo'), request_with_tags('destacados'), request_with_tags('condiciones'), request_with_tags('descripcion'), request('precio_valor'),request('descuento'),request('ahorro'),request('precio_final'),request_with_tags('descripcion_cupones'),request('multiple_cantidad'),request('link_video_oferta'),request('link_video_oferta2'));
        $idoferta = $ret[0];
        $error = $ret[1];
        if ($error) die('Error: '.$error);
        $r = array();
        $cad_eval='id_(\'idoferta\').value=\''. $idoferta.'\'; ';      
        
        die($cad_eval);
    }
/*
function traza($fichero,$texto){
    file_put_contents($fichero, "[".date("r")."] $texto".PHP_EOL, FILE_APPEND | LOCK_EX); 
} 
 * */

//}   
?>