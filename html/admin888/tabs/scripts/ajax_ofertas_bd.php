<?php    
include('config_events_new.php');                                                                                       
include_once 'functions.php';
include dirname(__FILE__).'/funciones_ofertas.php'; 
include dirname(__FILE__).'/funciones_cupon_oferta_historico.php'; 
include dirname(__FILE__).'/../../../classes/OfertaHistorico.php'; 
include_once dirname(__FILE__).'/../../../scripts/ip_functions.php'; 
//require_once dirname(__FILE__).'/trazas.php'; 
require_once dirname(__FILE__).'/contador_periodos_oferta.php'; 
include_once(dirname(__FILE__).'/conversiones_html.php');
$idoferta="";


if (Tools::getValue('num_opciones')) $num_opciones = Tools::getValue('num_opciones');
else $num_opciones=0;

$nombre_opcion = '_opcion';

//Para una oferta creadas devolvemos el número de cupones en campañas activas.
if (Tools::getValue('buscar_campanyas_activas'))
{
    $nactivas=0;
    $ohrs = GetOfertasHistorico(null,Tools::getValue('id_oferta'));
    foreach ($ohrs as $ohr)
    {
        if ($ohr->activa) $nactivas+=1;
    }
    echo($nactivas);
    die;
    
}


//Para una oferta creadas devolvemos el número de cupones en campañas activas.
if (Tools::getValue('buscar_cupones_oferta'))
{
    $ncupones_campanyas=0;
    if (Tools::getValue('creadas')==1)
        $ohrs = GetOfertasHistorico(null,Tools::getValue('id_oferta'));
    else
        $ohrs = GetOfertasHistorico(Tools::getValue('id_oferta'));
    
    foreach ($ohrs as $ohr)
    {
        //var_dump($ohr);die;
        if ($ohr->activa or Tools::getValue('creadas')==0)
        {
            $cupones = GetCuponesOfertaHistorico(intval($ohr->id));
            if ($cupones) $ncupones_campanyas+=count($cupones);
        }    
     //echo 'cupones '.$ohr->id.' -> '.$ncupones_campanyas;
    }
    echo($ncupones_campanyas);
    die;//die($ncupones_campanyas);
    
}

if (Tools::getValue('guardar_empresas'))
{
    $oferta = new Oferta_(Tools::getValue('id_oferta'));
	$r=$oferta->get();
	
	$hcc=0;$GT=0;
	
	if (Tools::getValue('hcc')==1) $hcc = 1; 
	if (Tools::getValue('gt')==1) $GT = 1; 
	if (Tools::getValue('periodo_automatico')==1) $pa = 1; 
	else $pa=0;
	
	$r=$oferta->UpdateCampo('GT',$GT,Tools::getValue('id_oferta'));
	$r=$oferta->UpdateCampo('hcc',$hcc,Tools::getValue('id_oferta'));
	$r=$oferta->UpdateCampo('periodo_automatico',$pa,Tools::getValue('id_oferta'));
	
	$ohrs = GetOfertasHistorico(null,Tools::getValue('id_oferta'));
    
    foreach ($ohrs as $ohr)  
    {
		$r=$ohr->UpdateCampo('GT',$GT,$ohr->id);
		$r=$ohr->UpdateCampo('hcc',$hcc,$ohr->id);
		$r=$ohr->UpdateCampo('periodo_automatico',$pa,$ohr->id);
    }
	
	/*$cad_eval='';
	
	if ($GT)
		$cad_eval.='id_(\'GT\').checked=true; ';   
	else 
		$cad_eval.='id_(\'GT\').checked=false; ';   

	if ($hcc)
		$cad_eval.='id_(\'hcc\').checked=true; ';   
	else 
		$cad_eval.='id_(\'hcc\').checked=false; ';   

	echo($cad_eval);
	*/
    die;

}

if (Tools::getValue('valores_activacion'))
{
    $oferta = new Oferta_(Tools::getValue('id_oferta'));
	$r=$oferta->get();
	
	if ($oferta->activa=='1')
	{
		$periodo = calcular_periodo($oferta->fechaInicio,$oferta->fechaFin);
		if ($periodo==0) $periodo=24; 
	} 
	else $periodo = 24;
	
	$dias_periodo = (int)$periodo/24; 	
	
	die($periodo.'#'.$oferta->periodoAutomatico.'#'.$oferta->hcc.'#'.$oferta->GT);
}

if (Tools::getValue('reposicionar')!='')
{
    $direccion = Tools::getValue('direccion');
    $posicion = Tools::getValue('posicion'); //$_GET['posicion'];
    $ofertaHist = new OfertaHistorico(Tools::getValue('id_oferta_hist'));
    $r=$ofertaHist->ordenOferta($posicion, $direccion,Tools::getValue('tipo_oferta')); 
    CompactarOrdenOfertas('campanyas');
    die($r);
}

if (Tools::getValue('reposicionar_creada')!='')
{
    $direccion = Tools::getValue('direccion');
    $posicion = Tools::getValue('posicion');
    $oferta = new Oferta_(Tools::getValue('id_oferta'));
    $r=$oferta->ordenOferta($posicion, $direccion,Tools::getValue('tipo_oferta'),Tools::getValue('tipo_servicio'));  
    CompactarOrdenOfertas('ofertas');
    die($r);
}


if (Tools::getValue('marcar_oferta_caducada')!='')
{
    
    $ofertaH = new OfertaHistorico(Tools::getValue('id_oferta_hist'));

    //Si la oferta ha sido activada como especial, en lugar de desactivarla y marcarla como caducada
    //reiniciaremos el contador de tiempo.
    //traza('debug2.txt','marca_caducada');
    if (Tools::getValue('cliente_especial')==1 or Tools::getValue('periodo_automatico')==1)
    {
        $r=GetOfertasHistorico(Tools::getValue('id_oferta_hist'));
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
    $r=GetOfertasHistorico(Tools::getValue('id_oferta_hist'));
    $ofertaH = $r[0];
    if ($ofertaH->caducada!=1)
    {
		$ofertaHtmp = new OfertaHistorico();
        //traza('debug.txt','caducada '.$ofertaH->id);
		$ofertaHtmp->UpdateCampo('active',0,Tools::getValue('id_oferta_hist'));    
        $ofertaHtmp->UpdateCampo('caducada',1,Tools::getValue('id_oferta_hist'));  
        $ofertaHtmp->UpdateCampo('comentarios',Tools::getValue('comentarios'),Tools::getValue('id_oferta_hist'));  
		
		unset($ofertaHtmp);
        /*
		$ofertaH->UpdateCampo('active',0,Tools::getValue('id_oferta_hist'));    
        $ofertaH->UpdateCampo('caducada',1,Tools::getValue('id_oferta_hist'));  
        */    
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
            $oferta->UpdateCampo('active',0,intval($ofertaH->idOferta));
            unset($oferta);    
        }
        else {/*traza('debug.txt','se encontró campaña activa, la oferta no se puede desactivar.');*/}
        unset($ofertaH);
    }
    die;
}
  
 
//Creamos una duplicado de la oferta.
if (Tools::getValue('duplicar')=='1')
{
    $o = new Oferta_(Tools::getValue('id_oferta'));  
    $r=$o->get();  

    $sdestacados = $o->destacados;  
    //$sdescripcion = field_to_save_insert($o->descripcion);   
	//$sdescripcion = $o->descripcion;   
	$sdescripcion = mysqli_real_escape_string($o->descripcion);
    $scondiciones = $o->condiciones;   
    $sdescripcionCupones = $o->descripcionCupones;    

    //echo('destacados '.$sdestacados);die;
	$provincias=$o->getProvincias();
	
    $ret=InsertOferta($o->idDesc,$o->titulo, $o->subtitulo, $sdestacados,$scondiciones, $sdescripcion, $o->precioValor,$o->descuento,$o->ahorro,$o->precioFinal,$o->descripcionCupones,$o->multipleCantidad,$o->linkVideo,$o->linkVideo2,$o->idTipoServicio,$provincias,null,$o->linkVideoGT,$o->linkVideo2GT,$o->ubicaciones);                                                                                                                                      
    
    $opciones = GetOpcionesOferta($o->id);
    $nopc=2;

    foreach ($opciones as $opcion)
    {
		$opc=new OpcionOferta();
		$opc->idOferta = $ret[0];
		$opc->idDesc = $opcion->idDesc;
		$opc->titulo = $opcion->titulo;
		$opc->subtitulo = $opcion->subtitulo;
		$opc->destacados = $opcion->destacados;
		$opc->condiciones = $opcion->condiciones;
		$opc->descripcion = $opcion->descripcion;
		$opc->precioValor = $opcion->precioValor;
		$opc->descuento = $opcion->descuento;
		$opc->precioFinal = $opcion->precioFinal;
		$opc->ahorro= $opcion->ahorro;		
		/*
		$opc->idDesc = Tools::getValue('idinterno'.$nombre_opcion.$nopc);
		$opc->titulo = Tools::getValue('titulo'.$nombre_opcion.$nopc);
		$opc->subtitulo = Tools::getValue('subtitulo'.$nombre_opcion.$nopc);
		$opc->destacados = request_with_tags('destacados'.$nombre_opcion.$nopc);
		$opc->condiciones = request_with_tags('condiciones'.$nombre_opcion.$nopc);
		$opc->descripcion = request_with_tags('descripcion'.$nombre_opcion.$nopc);
		$opc->precioValor = Tools::getValue('precio_valor'.$nombre_opcion.$nopc);
		$opc->descuento = Tools::getValue('descuento'.$nombre_opcion.$nopc);
		$opc->precioFinal = Tools::getValue('precio_final'.$nombre_opcion.$nopc);
		$opc->ahorro= Tools::getValue('ahorro'.$nombre_opcion.$nopc);
		*/
		//die($opc->idDesc.' '.$opc->titulo.' '.$opc->idOferta); 
		$opc->Insert();
		unset ($opc);
		$nopc++;    
    }

    
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
 
//Duplicamos una oferta y la enviamos a Cupones Alfa Online.
if (Tools::getValue('duplicar')=='2')
{
    $o = new Oferta_(Tools::getValue('id_oferta'));
    $r=$o->get();


    $sdestacados = $o->destacados;
    $sdescripcion = $o->descripcion;
    $scondiciones = $o->condiciones;
    $sdescripcionCupones = $o->descripcionCupones;
	$ret=InsertOfertaCuponesAlfaOnline($o->idDesc,$o->titulo, $o->subtitulo, $sdestacados,$scondiciones, $sdescripcion, $o->precioValor,$o->descuento,$o->ahorro,$o->precioFinal,$o->descripcionCupones,$o->multipleCantidad,$o->linkVideo,$o->linkVideo2);

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
    if ($tmp=InsertarImagenesOfertaACopiaCuponesAlfaOnline($o->id,$idoferta)) $error = $tmp;
    if ($tmp=MoverArchivosACopiaCuponesAlfaOnline($o->id,$idoferta)) $error = $tmp;
    
    if ($error) {unset($o);die('Error: '.$error);}
    
    unset($o);
    die('OK');
} 
  

if (!in_array(trim(Tools::getValue('edicio_oferta')),array('consulta','consulta_opciones','activar','desactivar')))    
{
if (Tools::getValue('titulo')=='') die('Error: Debe introducir el título de la oferta');
if (Tools::getValue('idinterno')=='') die('Error: Debe introducir el identificador interno de la oferta');
if (Tools::getValue('precio_valor')=='') die('Error: Debe introducir el precio de la oferta');
if (Tools::getValue('descuento')=='') die('Error: Debe introducir el porcentaje de descuento de la oferta');
if (Tools::getValue('ahorro')=='') die('Error: Debe introducir el ahorro de la oferta');
if (Tools::getValue('precio_final')=='') die('Error: Debe introducir el precio final de la oferta');

for($iopc=2;$iopc<=$num_opciones;$iopc++)
{
	if (Tools::getValue('titulo'.$nombre_opcion.$iopc)=='') die('Error: Debe introducir el título de la opci&oacute;n '.($iopc-1));
	if (Tools::getValue('idinterno'.$nombre_opcion.$iopc)=='') die('Error: Debe introducir el identificador interno de la opci&oacute;n '.($iopc-1));
	if (Tools::getValue('precio_valor'.$nombre_opcion.$iopc)=='') die('Error: Debe introducir el precio de la opci&oacute;n '.($iopc-1));
	if (Tools::getValue('descuento'.$nombre_opcion.$iopc)=='') die('Error: Debe introducir el porcentaje de descuento de la opci&oacute;n '.($iopc-1));
	if (Tools::getValue('ahorro'.$nombre_opcion.$iopc)=='') die('Error: Debe introducir el ahorro de la opci&oacute;n '.($iopc-1));
	if (Tools::getValue('precio_final'.$nombre_opcion.$iopc)=='') die('Error: Debe introducir el precio final de la opci&oacute;n '.($iopc-1));	
}

//echo(Tools::getValue('edicio_oferta'));
//echo(Tools::getValue('idoferta'));
}

if (in_array(trim(Tools::getValue('edicio_oferta')),array('alta','edicio')))
{
    
    $maxlineas = 15;
    //Destacados
/*

    $destacados = strip_tags(Tools::getValue('destacados'));
   
     $destacadosw= explode('\n',$destacados);
    
    $nlineas = count($destacadosw);
    die('lineas '.$nlineas);

    foreach($destacadosw as $d)
    {
    $nlineas+=(int)(strlen($d)/62);    
    }
*/
    //die('Error: lineas '.Tools::getValue('nlineas_destacados').'-'.Tools::getValue('nlineas_condiciones').'-'.Tools::getValue('nlineas_descripcion'));
    $nlineas = Tools::getValue('nlineas_destacados');
    if ($nlineas > $maxlineas)
        die('Error: el campo <b>Destacados </b> es demasiado largo'.' : '.$maxlineas.' líneas máximo (Tamaño actual '.$nlineas.' líneas)');

    //Condiciones
    $nlineas = Tools::getValue('nlineas_condiciones');

    if ($nlineas > $maxlineas)
        die('Error: el campo <b>Condiciones </b> es demasiado largo'.' : '.$maxlineas.' líneas máximo (Tamaño actual '.$nlineas.' líneas)');

    //Descripción cupones.
    $nlineas = Tools::getValue('nlineas_descripcion');

    if ($nlineas > $maxlineas)
        die('Error: el campo <b>Descripción Cupones </b> es demasiado largo'.' : '.$maxlineas.' líneas máximo (Tamaño actual '.$nlineas.' líneas)');

}


//echo('edicio_oferta '.Tools::getValue('edicio_oferta'));
//echo('edicio oferta '.$_GET['edicio_oferta']);
//echo('idoferta '.$_GET['idoferta']);
//echo(Tools::getValue('edicio_oferta'));
/*if(Tools::getValue('idoferta')!='') 
{*/
   $idoferta = Tools::getValue('idoferta');
   if (trim($idoferta)=='undefined') $idoferta=''; 
   //Edición.
      
   if (trim($idoferta)!='')  
   {    
       //echo('aki '.Tools::getValue('edicio_oferta'));
       if (in_array(trim(Tools::getValue('edicio_oferta')),array('activar','desactivar')))              
       {
            $periodo = Tools::getValue('periodo');  
            $error=ActivarOferta($idoferta,$periodo,(Tools::getValue('edicio_oferta')=='activar')?1:0,1);           
            //Volvemos a leer los datos de la oferta para saber cuales son las fechas generadas a patir
            //del nuevo periodo.
			
            $r = new Oferta_($idoferta);
            $res = $r->get();
			
			
			/*
			echo('<br><br>aki</br></br>');
			var_dump($res);
			*7
			/*
			if ($r->motorclub!=Tools::getValue('motorclub'))
				$res2 = $r->UpdateCampo('motorclub',Tools::getValue('motorclub'));
			if ($r->dreamcars!=Tools::getValue('dreamcars'))
				$res2 = $r->UpdateCampo('dreamcars',Tools::getValue('dreamcars'));
			if ($r->hcc!=Tools::getValue('hcc'))
				$res2 = $r->UpdateCampo('hcc',Tools::getValue('hcc'));
*/
           //die ($error);
           if (Tools::getValue('edicio_oferta')=='activar')    
           {
                   
               //En el caso de las ofertas especiales sólo se activará (modificará su periodo) de la campaña activa.    
               if ($r->clienteEspecial==1)
                $ohs = GetOfertasHistorico(null,$idoferta,null,1);
               else
                $ohs = GetOfertasHistorico(null,$idoferta);  
               //Actualizamos la oferta activa de la campaña con las fechas resultantes del nuevo periodo
               //seleccionado.
               
               $campanya_encontrada = false;                 
               
			   
			   foreach ($ohs as $oh)
               {
			   //if (GetUserIp_()=='81.36.139.100') die('ofertahist: '.$oh->id.',oferta: '.$oh->idOferta.',act: '.$oh->active.',cad: '.$oh->caducada);   
                   //s�lo actualizaremos cuando la campa�a ya est� activa y s�lo queramos actualizar el periodo.
				   if ($oh->caducada!=1 && $oh->activa==1)
                   {
                       //traza('debug.txt',$oh->id);
                       //$res=$oh->UpdateCampo('active',1);
                       $res=$oh->UpdateCampo('date_add',$r->fechaInicio);
                       $res=$oh->UpdateCampo('date_upd',$r->fechaFin);
                       //$res=$oh->UpdateCampo('motorclub',Tools::getValue('motorclub'));
                       //$res=$oh->UpdateCampo('dreamcars',Tools::getValue('dreamcars'));
                       //$res=$oh->UpdateCampo('hcc',Tools::getValue('hcc'));
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
			       

                    $ret=InsertOfertaHistorico($idoferta,$r->idDesc,$r->titulo, $r->subtitulo,$sdestacados, $scondiciones,$sdescripcion,$r->precioValor,$r->descuento,$r->ahorro,$r->precioFinal,$r->fechaInicio,$r->fechaFin,$r->activa,$sdescripcionCupones,$r->multipleCantidad,$r->clienteEspecial,$r->linkVideo,$r->linkVideo2,$r->idTipoServicio,Tools::getValue('hcc'),Tools::getValue('gt'),null,$r->linkVideoGT,$r->linkVideo2GT);
				    $opciones = GetOpcionesOferta($idoferta);
                    $idoferta = $ret[0];
                    $error = $ret[1];

					foreach($opciones as $opc)
					{
					$opch = new OpcionOfertaHistorico();
					$opch->idOfertaHist=$idoferta;
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
           } 
           
           unset($r);    
           if ($error) die('Error: '.$error);
           else die('id_(\'oferta_activa\').value=\''. ((Tools::getValue('edicio_oferta')=='activar')?1:0).'\'; ');    
            //fin inserción.
       }
       //caso en que se actualicen las observaciones de una oferta desde la lista de cupones.
       /*else if (Tools::getValue('edicio_oferta')=='update_observaciones')
        {
           $ret = UpdateObservacionesOfertaHistorico(); 
        }*/
       else if (Tools::getValue('edicio_oferta')=='consulta_opciones')
       {
           $opciones = GetOpcionesOferta($idoferta);
           $cad_eval='';
           $nopc=2;
           foreach($opciones as $opcion)
    	   {
    	   	$cad_eval.=formulario_opcion($nopc,$opcion);
    	   	$nopc++;
    	   }	 
    	   die($cad_eval);      	
       }
       else
       {     

           if (Tools::getValue('edicio_oferta')=='edicio')
           { 
                $fecha_inicio = Tools::getValue('fecha_inicio');
                $fecha_fin = Tools::getValue('fecha_fin');
                //date_default_timezone_set("Europe/Paris"); 
                $fecha_inicio = mktime(substr($fecha_inicio,11,2),substr($fecha_inicio,14,2),substr($fecha_inicio,17,2),substr($fecha_inicio,3,2),substr($fecha_inicio,0,2),substr($fecha_inicio,6,4));
                $fecha_inicio = date('Y-m-d H:i:s',$fecha_inicio);
                $fecha_fin = mktime(substr($fecha_fin,11,2),substr($fecha_fin,14,2),substr($fecha_fin,17,2),substr($fecha_fin,3,2),substr($fecha_fin,0,2),substr($fecha_fin,6,4));
                $fecha_fin = date('Y-m-d H:i:s',$fecha_fin);
                 
               // traza('debug.txt','multiplecantidad '.Tools::getValue('multiple_cantidad'));
                //die(request_with_tags('descripcion_cupones'));
                $idTipoServicio = Tools::getValue('tipo_servicio');
				$provincias=explode(',',$_POST['provincias']);
				
				unset($otmp);
				
				$error=UpdateOferta($idoferta,Tools::getValue('idinterno'),Tools::getValue('titulo'), Tools::getValue('subtitulo'), request_with_tags('destacados'), request_with_tags('condiciones'), request_with_tags('descripcion'), Tools::getValue('precio_valor'),Tools::getValue('descuento'),Tools::getValue('ahorro'),Tools::getValue('precio_final'),request_with_tags('descripcion_cupones'),Tools::getValue('multiple_cantidad'),request_with_tags('link_video_oferta'),request_with_tags('link_video_oferta2'),$idTipoServicio,$provincias,Tools::getValue('idinterno_opcion'),request_with_tags('link_video_oferta_GT'),request_with_tags('link_video_oferta_GT2'),request_with_tags('ubicaciones'));                
				
				
               	//Miramos si existe una campa�a activa no caducada para la oferta 
               	//en cuyo caso ya tenemos el id_oferta_hist.
				$ofhs = GetOfertasHistorico(null,$idoferta);  
               
				$idOfertaHistOpciones=0;
					
				foreach ($ofhs as $ofh)
	            {
                  if ($ofh->caducada!=1 && $ofh->activa==1)
                  {

                	$idOfertaHistOpciones = $ofh->id;
                	break;       
                   }
	            }
				
				//die('error '.$idOfertaHistOpciones);
 				for ($nopc=2;$nopc<=$num_opciones;$nopc++)
				{
					$opc=new OpcionOferta();
					$opc->idOferta = Tools::getValue('idoferta');
					$opc->idDesc = Tools::getValue('idinterno'.$nombre_opcion.$nopc);
					$opc->titulo = Tools::getValue('titulo'.$nombre_opcion.$nopc);
					$opc->subtitulo = Tools::getValue('subtitulo'.$nombre_opcion.$nopc);
					$opc->destacados = request_with_tags('destacados'.$nombre_opcion.$nopc);
					$opc->condiciones = request_with_tags('condiciones'.$nombre_opcion.$nopc);
					$opc->descripcion = request_with_tags('descripcion'.$nombre_opcion.$nopc);
					$opc->precioValor = Tools::getValue('precio_valor'.$nombre_opcion.$nopc);
					$opc->descuento = Tools::getValue('descuento'.$nombre_opcion.$nopc);
					$opc->precioFinal = Tools::getValue('precio_final'.$nombre_opcion.$nopc);
					$opc->ahorro= Tools::getValue('ahorro'.$nombre_opcion.$nopc);
								

					
					
					//Actualizamos el regstro para la opci�n de Oferta.
					if (Tools::getValue('idopcion'.$nopc)!= '') 					
					{

						$opc->id=Tools::getValue('idopcion'.$nopc);
						$opc->Update();
						
					}
					else 
					{
						$opc->id=$opc->Insert();
					}
					
					/* si existe la campa�a modificaremos o insertaremos el registro de hist�rico
					 * para las opciones de oferta.
					 */
					
					
					if ($idOfertaHistOpciones)
					{
						$opch = new OpcionOfertaHistorico();
						$opch->idOfertaHist=$idOfertaHistOpciones;
						$opch->idOpcionOferta = $opc->id;
						$res=$opch->get($opch->idOpcionOferta);
						
						//die($res);

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
						//echo('res '.$res.' ');var_dump($opch);die('ERROR ACTUALIZANDO OPCIONHs');
						

						if ($res)
						{
							$opch->Update();	
						}	
						else 
						{
							$opch->Insert();
						}					
					}
					
					
					unset ($opc);
					unset ($opch);						
				}
				
                
                if ($error) die('Error: '.$error);
           
           }
    
          

		   $oftmp=new Oferta_($idoferta);
		   $gprovincias=$oftmp->getProvincias();
		   $sprovincias=implode(',',$gprovincias);
		   unset ($oftmp);
			 
 		   $r = GetOfertas($idoferta);
		 
           $r = $r[0];
           $cad_eval='';
       
           $sdestacados = str_replace(array("\r", "\n"), array("", ""),$r->destacados);
           $sdescripcion = str_replace(array("\r", "\n"), array("", ""),$r->descripcion);
           $sdescripcionCupones = str_replace(array("\r", "\n"), array("", ""),$r->descripcionCupones);
           $scondiciones = str_replace(array("\r", "\n"), array("", ""),$r->condiciones);
		   $subicaciones = str_replace(array("\r", "\n"), array("", ""),$r->ubicaciones);
           
           $titulo = str_replace(array("\r", "\n"), array("", " "),$r->titulo);
           $subtitulo = str_replace(array("\r", "\n"), array("", " "),$r->subtitulo);
           
           
           $cad_eval.='id_(\'idoferta\').value='.  Tools::getValue('idoferta').';';            
           $cad_eval.='id_(\'titulo\').value=\''. $titulo.'\'; ';
           $cad_eval.='id_(\'subtitulo\').value=\''. $subtitulo.'\'; ';
           $cad_eval.='id_(\'idinterno\').value=\''. $r->idDesc.'\'; ';
           $cad_eval.='id_(\'idinterno_opcion\').value=\''. $r->idDescOpcion.'\'; ';
           $cad_eval.='id_(\'precio_valor\').value=\''.$r->precioValor.'\'; ';
           $cad_eval.='id_(\'descuento\').value=\''. $r->descuento.'\'; ';          
           $cad_eval.='id_(\'precio_final\').value=\''.$r->precioFinal.'\'; ';
           $cad_eval.='id_(\'ahorro\').value=\''. $r->ahorro.'\'; ';    
           $cad_eval.='id_(\'oferta_activa\').value=\''. $r->activa.'\'; ';    
           $cad_eval.='id_(\'multiple_cantidad\').value=\''. $r->multipleCantidad.'\'; ';    
           $cad_eval.='id_(\'cliente_especial\').value=\''. $r->clienteEspecial.'\'; ';    
           $cad_eval.='id_(\'link_video_oferta\').value=\''. $r->linkVideo.'\'; ';    
           $cad_eval.='id_(\'link_video_oferta2\').value=\''. $r->linkVideo2.'\'; ';    
           $cad_eval.='id_(\'link_video_oferta_GT\').value=\''. $r->linkVideoGT.'\'; ';    
           $cad_eval.='id_(\'link_video_oferta_GT2\').value=\''. $r->linkVideo2GT.'\'; ';    
                                            
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
		   
		   $cad_eval.=' for (var x=0;x<id_("tipo_servicio").length;x++) ';
		   $cad_eval.=' {';
		   $cad_eval.='  if (id_("tipo_servicio").options[x].value == '.$r->idTipoServicio.')';
		   $cad_eval.='     { ';
		   $cad_eval.='		if (id_("tipo_servicio").selectedIndex!=x) ';
		   $cad_eval.='			{ ';
		   $cad_eval.='				id_("tipo_servicio").selectedIndex=x ';
		   $cad_eval.='			} ';
		   $cad_eval.='			break; ';
		   $cad_eval.='		} ';
		   $cad_eval.='	} ';


		   $cad_eval.=' $(\'#provincia\').val(['.$sprovincias.']);';
		   /*foreach ($provincias as $idprov)
		   {
			   
			   $cad_eval.=' for (var x=0;x<id_("provincia").length;x++) ';
			   $cad_eval.=' {';
			   $cad_eval.='  if (id_("provincia").options[x].value == '.intval($idprov).')';
			   $cad_eval.='     { ';
			   $cad_eval.='		if (id_("provincia").selectedIndex!=x) ';
			   $cad_eval.='			{ ';
			   $cad_eval.='				id_("provincia").selectedIndex=x ';
			   $cad_eval.='			} ';
			   $cad_eval.='			break; ';
			   $cad_eval.='		} ';
			   $cad_eval.='	} ';
			   
		   }*/
			   


		   
           $cad_eval.='tinyMCE.get("destacados").setContent(\''.$sdestacados.'\'); ';
           $cad_eval.='tinyMCE.get("condiciones").setContent(\''.$scondiciones.'\'); ';
           $cad_eval.='tinyMCE.get("descripcion").setContent(\''.$sdescripcion.'\'); ';
           $cad_eval.='tinyMCE.get("descripcion_cupones").setContent(\''.$sdescripcionCupones.'\'); ';
           $cad_eval.='tinyMCE.get("ubicaciones").setContent(\''.$subicaciones.'\'); ';
		   
           /*$cad_eval.='id_(\'password\').value=\''. $r['password'].'\'; ';
           $cad_eval.='id_(\'cpostal\').value=\''. $r['cpostal'].'\'; ';
           */
  	           $opciones = GetOpcionesOferta($idoferta);
			   //echo('idoferta '.$idoferta.' ');
			   //var_dump($opciones);die;
           $nopc=2;
           foreach($opciones as $opcion)
    	   {
    	   	$cad_eval.=formulario_opcion($nopc,$opcion,$nombre_opcion);
    	   	$nopc++;
    	   }	
           
           
           die($cad_eval);
       } 
   }
    //Alta.
    else  if (Tools::getValue('edicio_oferta')=='alta')// if ($_REQUEST['edicio_oferta']!='CARGA_INICIAL') //edicio_oferta será = 'CARGA_INICIAL' cuando seleccionemos "CREAR OFERTA" en el menú de ofertas.
    {
        $fecha_inicio = Tools::getValue('fecha_inicio');
        $fecha_fin = Tools::getValue('fecha_fin');
        //date_default_timezone_set("Europe/Paris"); 
        $fecha_inicio = mktime(substr($fecha_inicio,11,2),substr($fecha_inicio,14,2),substr($fecha_inicio,17,2),substr($fecha_inicio,3,2),substr($fecha_inicio,0,2),substr($fecha_inicio,6,4));
        $fecha_inicio = date('Y-m-d H:i:s',$fecha_inicio);
        $fecha_fin = mktime(substr($fecha_fin,11,2),substr($fecha_fin,14,2),substr($fecha_fin,17,2),substr($fecha_fin,3,2),substr($fecha_fin,0,2),substr($fecha_fin,6,4));
        $fecha_fin = date('Y-m-d H:i:s',$fecha_fin);
        
    //var_dump($_REQUEST);die;
        $idTipoServicio = Tools::getValue('tipo_servicio');
		$provincias=$_POST['provincia'];
	
        $ret=InsertOferta(Tools::getValue('idinterno'),Tools::getValue('titulo'), Tools::getValue('subtitulo'), request_with_tags('destacados'), request_with_tags('condiciones'), request_with_tags('descripcion'), Tools::getValue('precio_valor'),Tools::getValue('descuento'),Tools::getValue('ahorro'),Tools::getValue('precio_final'),request_with_tags('descripcion_cupones'),Tools::getValue('multiple_cantidad'),Tools::getValue('link_video_oferta'),Tools::getValue('link_video_oferta2'),$idTipoServicio,$provincias,Tools::getValue('idinterno_opcion'),request_with_tags('link_video_oferta_GT'),request_with_tags('link_video_oferta_GT2'),request_with_tags('ubicaciones'));
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

    
function formulario_opcion($nopcion,$opcion,$nombre_opcion)
{	   	
   $sdestacados = str_replace(array("\r", "\n"), array("", ""),$opcion->destacados);
   $sdescripcion = str_replace(array("\r", "\n"), array("", ""),$opcion->descripcion);
   $scondiciones = str_replace(array("\r", "\n"), array("", ""),$opcion->condiciones);
   
   $titulo = str_replace(array("\r", "\n"), array("", " "),$opcion->titulo);
   $subtitulo = str_replace(array("\r", "\n"), array("", " "),$opcion->subtitulo);
   
   
   
   $cad_eval_opcion.='id_(\'titulo'.$nombre_opcion.$nopcion.'\').value=\''. $titulo.'\'; ';
   $cad_eval_opcion.='id_(\'subtitulo'.$nombre_opcion.$nopcion.'\').value=\''. $subtitulo.'\'; ';
   $cad_eval_opcion.='id_(\'idinterno'.$nombre_opcion.$nopcion.'\').value=\''. $opcion->idDesc.'\'; ';
   $cad_eval_opcion.='id_(\'precio_valor'.$nombre_opcion.$nopcion.'\').value=\''.$opcion->precioValor.'\'; ';
   $cad_eval_opcion.='id_(\'descuento'.$nombre_opcion.$nopcion.'\').value=\''. $opcion->descuento.'\'; ';          
   $cad_eval_opcion.='id_(\'precio_final'.$nombre_opcion.$nopcion.'\').value=\''.$opcion->precioFinal.'\'; ';
   $cad_eval_opcion.='id_(\'ahorro'.$nombre_opcion.$nopcion.'\').value=\''. $opcion->ahorro.'\'; ';    
   $cad_eval_opcion.='tinyMCE.get("destacados'.$nombre_opcion.$nopcion.'").setContent(\''.str_replace('\'','´',$sdestacados).'\'); ';
   $cad_eval_opcion.='tinyMCE.get("condiciones'.$nombre_opcion.$nopcion.'").setContent(\''.str_replace('\'','´',$scondiciones).'\'); ';
   $cad_eval_opcion.='tinyMCE.get("descripcion'.$nombre_opcion.$nopcion.'").setContent(\''.str_replace('\'','´',$sdescripcion).'\'); ';
   $cad_eval_opcion.='id_(\'idopcion'.$nopcion.'\').value=\''. $opcion->id.'\'; ';        
   
   return $cad_eval_opcion;	
}


  
   
?>