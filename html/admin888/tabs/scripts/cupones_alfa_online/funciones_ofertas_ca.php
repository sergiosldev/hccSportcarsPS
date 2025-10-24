<?php
/** mts 01/05/2012. 
 * Funciones para mover información entre la los objetos de la clase (modelo)
 *  y la base de datos (las consultas, altas y modificaciones se harán a través de éstas)
 */
include_once(dirname(__FILE__).'/../../../../config/config.inc.php');
//include_once(dirname(__FILE__).'/../../../../classes/FuncionesOfertas.php');
//include_once(dirname(__FILE__).'/../../../../classes/Db.php');

include_once(dirname(__FILE__).'/../conversiones_html.php');
//include_once(dirname(__FILE__).'/contador_periodos_oferta.php');
//include_once(dirname(__FILE__).'/../trazas.php');
//include '../../../../classes/OfertaCA.php';
//include '../../../../classes/OfertaHistoricoCA.php';

$sufijo = '_distribuidores';

function ErrorBd($err = null)
{
    if (!$err) return (mysql_errno().'-'.mysql_error());
    else return ($err);
}

function GetOfertasCA($inId=null,$orden=null)
{
    global $sufijo;
    //echo('akir');
    switch($orden)
    {
        case 'orden': 
            $order_by = " ORDER BY o.orden DESC ";
            break;
        default:
            $order_by = " ORDER BY o.id_oferta DESC ";
    }
    if (!empty($inId))    
    {
  
        $sql = "SELECT  o.*,ol.*  FROM ps_oferta".$sufijo." o,ps_oferta_lang".$sufijo." ol where o.id_oferta = ol.id_oferta and o.id_oferta = " . intval($inId) . " ORDER BY ol.name ASC";
        
//        $query = mysql_query($sql); 
          $query=Db::getInstance()->ExecuteS($sql);
    }
    else
    {
        //$sql = "SELECT  o.*,ol.*  FROM ps_oferta o,ps_oferta_lang ol where o.id_oferta = ol.id_oferta  ORDER BY ol.name ASC";   
        $sql = "SELECT  o.*,ol.*  FROM ps_oferta".$sufijo." o,ps_oferta_lang".$sufijo." ol where o.id_oferta = ol.id_oferta  ".$order_by;
        //echo('sql '.$sql);
        //$query = mysql_query($sql); 
        $query=Db::getInstance()->ExecuteS($sql);
    }

    $ofertaArray = array();
    foreach ($query as $row)
    //while ($row = mysql_fetch_assoc($query))
    {
     //******
        $price = floatval($row["price"]);
        $reduction_price=floatval($row["reduction_price"]);
        $final_price=floatval($row["final_price"]);
                                              
        $Oferta = new OfertaCA(intval($row["id_oferta"]),$row["id_desc"], $row['name'], $row['subtitle'], $row['description_short'], $row["realiza"], $row['description'],$price, $row['reduction_percent'],$reduction_price,$final_price,$row['date_add'],$row['date_upd'],$row['active'],$row['observaciones'],$row['cliente_especial'],$row['descripcion_cupones'],$row['multiple_cantidad'],$row['orden'],$row['link_video'],$row['link_video2'],$row['fecha_alta']);
        
 //       $inId=null, $inTitulo=null, $inSubtitulo=null, $inDestacados=null, $inCondiciones=null, $inDescripcion=null, $inPrecioValor=null,$inPrecioOferta=null
        array_push($ofertaArray, $Oferta);
    }
    return $ofertaArray;
}


//Compacta los valores del campo orden de las ofertas (entidad='ofertas') o de las Campañas (entidad='campanyas').
function CompactarOrdenOfertasCA($entidad='campanyas')
{
    global $connection;
    global $sufijo;
    
    $error = '';

    if ($entidad == 'ofertas')
    {
        $error_consulta = "al consultar las ofertas para la compactación";
        $sql = " select id_oferta,orden from ps_oferta".$sufijo." order by orden ASC ";
        //$result= mysql_query($sql);
        $result=Db::getInstance()->ExecuteS($sql);
        if (!$result) $error = ErrorBd($error_consulta);
        
        $orden=1;
        
        foreach($result as $r)
        //while ($r = mysql_fetch_assoc($result))
        {
            $sql = " update ps_oferta".$sufijo." set orden = ".intval($orden).' where id_oferta = '.intval($r['id_oferta']); 
            //$result2= mysql_query($sql);
            $result2=Db::getInstance()->Execute($sql);
            
            if (!$result2) {$error = ErrorBd('Error durante la compactación');}
            $orden++;
        }    
        
    }
    else 
    {
        $error_consulta = "al consultar las campañas para la compactación";
        $sql = " select id_oferta_hist,orden from ps_oferta_historico".$sufijo." order by orden ASC ";
        //$result= mysql_query($sql);
        $result=Db::getInstance()->ExecuteS($sql);
        if (!$result) $error = ErrorBd($error_consulta);
        
        $orden=1;
        
        foreach($result as $r)
        //while ($r = mysql_fetch_assoc($result))
        {
            $sql = " update ps_oferta_historico".$sufijo." set orden = ".intval($orden).' where id_oferta_hist = '.intval($r['id_oferta_hist']); 
            //$result2= mysql_query($sql);
            $result2=Db::getInstance()->Execute($sql);
            if (!$result2) {$error = ErrorBd('Error durante la compactación');}
            $orden++;
        }    
            
    }
    
    return $error;
}

function GetOfertasHistoricoCA($inId=null,$inIdOferta=null,$orden=null,$clienteEspecial=null)
{
            
    global $sufijo;     
    $where = '';
    if ($inId!=null)
        $where.= ' and o.id_oferta_hist="'.intval($inId).'"';
    if ($inIdOferta!=null)
        $where.= ' and o.id_oferta="'.intval($inIdOferta).'"';
    if ($clienteEspecial!=null)
        $where.= ' and o.cliente_especial="'.intval($clienteEspecial).'"';

    $orderby = '';

    switch($orden)  
    {
        case 'activas':
            $orderby = " ORDER BY o.active DESC ";
        case 'fecha': 
            $orderby = " ORDER BY o.date_add DESC ";
            break; 
        case 'orden': 
            $orderby = " ORDER BY o.orden DESC ";
            break; 
        case 'activas_inactivas':    
            $orderby = " ORDER BY orden1,convert(orden2,UNSIGNED) DESC ";
            break;
        default: $orderby = " ORDER BY ol.name ASC";        
    }

    $sql = "SELECT  o.*,ol.*,
                    case active when 1 then 1 else 2 end orden1,
                    case active when 1 then orden else fecha_alta end orden2  
            FROM ps_oferta_historico".$sufijo." o,ps_oferta_historico_lang".$sufijo." ol where o.id_oferta_hist = ol.id_oferta_hist ".
    $where.' '.$orderby;
    
    //if ($clienteEspecial==1) traza('debug.txt',$sql);
    //$query = mysql_query($sql); 
    $query=Db::getInstance()->ExecuteS($sql);
    
    $ofertaArray = array();
    foreach($query as $row)
    //while ($row = mysql_fetch_assoc($query))
    {
     //******
       
        $price = floatval($row["price"]);
        $reduction_price=floatval($row["reduction_price"]);
        $final_price=floatval($row["final_price"]);
                
        $Oferta = new OfertaHistoricoCA(intval($row["id_oferta_hist"]),intval($row["id_oferta"]),$row["id_desc"], $row['name'], $row['subtitle'], $row['description_short'], $row["realiza"], $row['description'],$price, $row['reduction_percent'],$reduction_price,$final_price,$row['date_add'],$row['date_upd'],$row['active'],$row['observaciones'],$row['cliente_especial'],null,$row['orden'],$row['caducada'],$row['descripcion_cupones'],$row['multiple_cantidad'],$row['link_video'],$row['link_video2'],$row['fecha_alta']);
        
 //       $inId=null, $inTitulo=null, $inSubtitulo=null, $inDestacados=null, $inCondiciones=null, $inDescripcion=null, $inPrecioValor=null,$inPrecioOferta=null
        array_push($ofertaArray, $Oferta);
    }
    return $ofertaArray;
}


function InsertOfertaCA($inIdDesc,$inTitulo, $inSubtitulo, $inDestacados, $inCondiciones, $inDescripcion, $inPrecioValor,$inDescuento,$inAhorro,$inPrecioFinal,$inDescripcionCupones,$inMultipleCantidad,$inLinkVideo=null,$inLinkVideo2=null)
{          
    global $connection;
    global $sufijo;
    $error = "";
    
  
    $sql = " select (max(id_oferta)+1) maxid,(max(orden)+1) maxorden from ps_oferta".$sufijo;
    //$result= mysql_query($sql);
    //return('aqui '.$sql);
    $result=Db::getInstance()->ExecuteS($sql);
    
    if (!$result) $error = ErrorBd();
   
    
    //$r = mysql_fetch_assoc($result);
    $r=$result[0]; 
    
    $NewId = $r['maxid'];
    $NewOrden = $r['maxorden'];
    
    if ($NewId=="") $NewId = 1;
    if ($NewOrden=="") $NewOrden = 1;
   
   // $Oferta = new OfertaCA($row["id_oferta"],$row["id_desc"], $row['name'], $row['subtitle'], $row['description_short'], $row["realiza"], $row['description'],$price, $row['reduction_percent'], $row['reduction_price'],$row['final_price']);
 
   
    $sql = " insert into ps_oferta".$sufijo." (id_oferta,orden,id_desc,id_category_default,price,reduction_percent,active,reduction_price,final_price,realiza,descripcion_cupones,multiple_cantidad,link_video,link_video2) ";
 
    $sql = $sql. " values (".intval($NewId).",".intval($NewOrden).",'".$inIdDesc."',2,'".$inPrecioValor."','".$inDescuento."',0,'".$inAhorro."','".$inPrecioFinal."','".$inCondiciones."','".$inDescripcionCupones."','".$inMultipleCantidad."','".$inLinkVideo."','".$inLinkVideo2."')";

    //return($sql);
    //$result=mysql_query($sql);
    $result=Db::getInstance()->Execute($sql);
 
    if (!$result) $error = ErrorBd('al crear la oferta');

    $sql = " insert into ps_oferta_lang".$sufijo." (id_oferta,id_lang,name,subtitle,description,description_short) ";
 
    $sql = $sql. " values (".intval($NewId).",'3','".$inTitulo."','".$inSubtitulo."','".$inDescripcion."','".$inDestacados."')";
     //traza('debug.txt',$sql);
    //$result=mysql_query($sql);
    $result=Db::getInstance()->Execute($sql);
    
    if (!$result) $error = ErrorBd('al crear el registro de idiomas de la oferta');

    if(!$error) return array($NewId,"");
    else return array(0,$error);      
}



function InsertOfertaOnline($inIdDesc,$inTitulo, $inSubtitulo, $inDestacados, $inCondiciones, $inDescripcion, $inPrecioValor,$inDescuento,$inAhorro,$inPrecioFinal,$inDescripcionCupones,$inMultipleCantidad,$inLinkVideo=null,$inLinkVideo2=null,$inTipoServicio=null)
{          
    global $connection;
    $error = "";
    
  
    $sql = " select (max(id_oferta)+1) maxid,(max(orden)+1) maxorden from ps_oferta";
    //$result= mysql_query($sql);
    //return('aqui '.$sql);
    $result=Db::getInstance()->ExecuteS($sql);
    
    if (!$result) $error = ErrorBd();
   
    
    //$r = mysql_fetch_assoc($result);
    $r=$result[0]; 
    
    $NewId = $r['maxid'];
    $NewOrden = $r['maxorden'];
    
    if ($NewId=="") $NewId = 1;
    if ($NewOrden=="") $NewOrden = 1;
   
   // $Oferta = new OfertaCA($row["id_oferta"],$row["id_desc"], $row['name'], $row['subtitle'], $row['description_short'], $row["realiza"], $row['description'],$price, $row['reduction_percent'], $row['reduction_price'],$row['final_price']);
 
   
    $sql = " insert into ps_oferta (id_oferta,orden,id_desc,id_category_default,price,reduction_percent,active,reduction_price,final_price,realiza,descripcion_cupones,multiple_cantidad,link_video,link_video2,id_tipo_servicio) ";
 
    $sql = $sql. " values (".intval($NewId).",".intval($NewOrden).",'".$inIdDesc."',2,'".$inPrecioValor."','".$inDescuento."',0,'".$inAhorro."','".$inPrecioFinal."','".$inCondiciones."','".$inDescripcionCupones."','".$inMultipleCantidad."','".$inLinkVideo."','".$inLinkVideo2."','".$inTipoServicio."')";

    //return($sql);
    //$result=mysql_query($sql);
    $result=Db::getInstance()->Execute($sql);
 
    if (!$result) $error = ErrorBd('al crear la oferta');

    $sql = " insert into ps_oferta_lang (id_oferta,id_lang,name,subtitle,description,description_short) ";
 
    $sql = $sql. " values (".intval($NewId).",'3','".$inTitulo."','".$inSubtitulo."','".$inDescripcion."','".$inDestacados."')";
     //traza('debug.txt',$sql);
    //$result=mysql_query($sql);
    $result=Db::getInstance()->Execute($sql);
    
    if (!$result) $error = ErrorBd('al crear el registro de idiomas de la oferta');

    if(!$error) return array($NewId,"");
    else return array(0,$error);      
}

function InsertarImagenesOfertaACopiaOfertasOnline($idoferta,$idoferta_dest)
{
    $error = "";
    global $sufijo;
    $sql = " select * from ps_image_oferta".$sufijo." i where  i.id_oferta = '".intval($idoferta)."'";
    
    //$results= mysql_query($sql);
    $results=Db::getInstance()->ExecuteS($sql);
    
    if (!$results) $error = ErrorBd();
   
    foreach($results as $r)
    //while($r = mysql_fetch_assoc($results))
    {
        $insert = " insert into ps_image_oferta
        (id_oferta,id_image_oferta,position,cover) 
        values 
        ('".intval($idoferta_dest)."','".intval($r['id_image_oferta'])."','".intval($r['position'])."','".intval($r['cover'])."')";    
        
        //traza('debug.txt',$insert);
        //$result=mysql_query($insert);
        $result=Db::getInstance()->Execute($insert);
        if (!$result) $error = ErrorBd('al mover el registro de imagen de "Cupones Online" a "Ofertas Online"');
     
     }   

    return $error;
}

function InsertarImagenesOfertaADuplicadoCA($idoferta,$idoferta_dest)
{
    $error = "";
    global $sufijo;
    $sql = " select * from ps_image_oferta".$sufijo." i where  i.id_oferta = '".intval($idoferta)."'";
    
    //$results= mysql_query($sql);
    $results=Db::getInstance()->ExecuteS($sql);
    
    if (!$results) $error = ErrorBd();
   
    foreach($results as $r)
    //while($r = mysql_fetch_assoc($results))
    {
        $insert = " insert into ps_image_oferta".$sufijo."
        (id_oferta,id_image_oferta,position,cover) 
        values 
        ('".intval($idoferta_dest)."','".intval($r['id_image_oferta'])."','".intval($r['position'])."','".intval($r['cover'])."')";    
        
        //traza('debug.txt',$insert);
        //$result=mysql_query($insert);
        $result=Db::getInstance()->Execute($insert);
        if (!$result) $error = ErrorBd('al mover el registro de imagen a la oferta duplicada');
     
     }   

    return $error;
}

function MoverArchivosACopiaOfertasOnline($idoferta,$idoferta_dest)
{
$path=_PS_OFER_IMG_DIR_DISTR_;    
$path_dest= _PS_OFER_IMG_DIR_;
$directorio=dir($path);
$error='';

$i=0;

if (!$dir=opendir($path)) $error = " No se pudo acceder al directorio origen ";
chdir($path_dest);
while ($archivo = readdir($dir))
{
    $i++;
    $pos = strpos($archivo,'-');
    if ($pos!=-1 && substr($archivo,0,$pos)==$idoferta)
    {
        //traza(44,$path.$archivo.'->'.$path_dest.$idoferta_dest.'-'.substr($archivo,$pos+1)); 
        //echo(' fuente: '.$path.$archivo.' destino: '.$path_dest.$archivo);
        if (!@copy($path.$archivo,$path_dest.$idoferta_dest.'-'.substr($archivo,$pos+1))) $error = " No se pudieron copiar los archivos de imagen desde 'Cupones Alfa Online' a 'Ofertas Online' ";
    }
}

closedir($dir);
return $error;
}


function MoverArchivosADuplicadoCA($idoferta,$idoferta_dest)  
{
$path=_PS_OFER_IMG_DIR_DISTR_;    
$path_dest= _PS_OFER_IMG_DIR_DISTR_;
$directorio=dir($path);
$error='';

$i=0;

if (!$dir=opendir(_PS_OFER_IMG_DIR_DISTR_)) $error = " No se pudo acceder al directorio destino ";
chdir($path_dest);
while ($archivo = readdir($dir))
{
    $i++;
    $pos = strpos($archivo,'-');
    if ($pos!=-1 && substr($archivo,0,$pos)==$idoferta)
    {
        //echo(' fuente: '.$path.$archivo.' destino: '.$path_dest.$archivo);
        if (!@copy($path.$archivo,$path_dest.$idoferta_dest.'-'.substr($archivo,$pos+1))) $error = " No se pudieron copiar los archivos de imagen a la oferta duplicada ";
    }
}

closedir($dir);
return $error;
}



function InsertOfertaHistoricoCA($inIdOferta,$inIdDesc,$inTitulo, $inSubtitulo, $inDestacados, $inCondiciones, $inDescripcion, $inPrecioValor,$inDescuento,$inAhorro,$inPrecioFinal,$inFechaInicio,$inFechaFin,$inActiva,$inDescripcionCupones,$inMultipleCantidad,$inLinkVideo=null,$inLinkVideo2=null)
{          
    global $connection;
    global $sufijo;
    $error = "";
  
 
    /*$sql = " select id_oferta_hist from ps_oferta_historico where id_oferta = '".$inIdOferta."'";
    $result = mysql_query($sql);
    if ($result) { $r=mysql_fetch_assoc($result);$tmp=DeleteOfertasHist($r['id_oferta_hist']);}
     */
    //return array(0,$tmp);
 
    $sql = " select (max(id_oferta_hist)+1) maxid,(max(orden)+1) maxorden from ps_oferta_historico".$sufijo." ";
    //$result= mysql_query($sql);
    $result=Db::getInstance()->ExecuteS($sql);
    
    if (!$result) $error = ErrorBd();
   
    
    //$r = mysql_fetch_assoc($result);
    $r=$result[0]; 
    $NewId = $r['maxid'];
    $NewOrden = $r['maxorden'];
    
    if ($NewId=="") $NewId = 1;
    if ($NewOrden=="") $NewOrden = 1;
    
   
    //$Oferta = new OfertaHistorico($row["id_oferta_hist"],$row["id_oferta"],$row["id_desc"], $row['name'], $row['subtitle'], $row['description_short'], $row["realiza"], $row['description'],$price, $row['reduction_percent'], $row['reduction_price'],$row['final_price']);
 
   
    $sql = " insert into ps_oferta_historico".$sufijo." (id_oferta_hist,id_oferta,id_desc,id_category_default,price,reduction_percent,active,reduction_price,final_price,realiza,date_add,date_upd,orden,descripcion_cupones,multiple_cantidad,link_video,link_video2,fecha_alta) ";
 
    $sql = $sql. " values (".intval($NewId).",".intval($inIdOferta).",'".$inIdDesc."',2,'".$inPrecioValor."','".$inDescuento."',".$inActiva.",'".$inAhorro."','".$inPrecioFinal."','".$inCondiciones."','".$inFechaInicio."','".$inFechaFin."','".$NewOrden."','".$inDescripcionCupones."','".$inMultipleCantidad."','".$inLinkVideo."','".$inLinkVideo2."','".$inFechaInicio."')";
    //traza('debug.txt',$sql);
    //return array(1,$sql);
    //$result=mysql_query($sql);
    $result=Db::getInstance()->Execute($sql);
     
    if (!$result) $error = ErrorBd('al crear la oferta');


    $sql = " insert into ps_oferta_historico_lang".$sufijo." (id_oferta_hist,id_lang,name,subtitle,description,description_short) ";
 
    $sql = $sql. " values (".intval($NewId).",'3','".$inTitulo."','".$inSubtitulo."','".$inDescripcion."','".$inDestacados."')";
    //traza('debug.txt','hist: '.$sql); 
    //$result=mysql_query($sql);
    $result=Db::getInstance()->Execute($sql);
    
    if (!$result) $error = ErrorBd('al crear el registro de idiomas de la oferta');


    if ($tmp=InsertarImagenesOfertaAHistoricoCA($NewId,$inIdOferta)) $error = $tmp;
    
    //if ($tmp=InsertarCuponesOfertaAHistorico($NewId,$inIdOferta)) $error = $tmp;
    
    if ($tmp=MoverArchivosAHistoricoCA($inIdOferta,$NewId)) $error = $tmp;
    //return array(0,$tmp);
    
     
    if(!$error) return array($NewId,"");
    else return array(0,$error);      
}



function InsertarImagenesOfertaAHistoricoCA($idofertahist,$idoferta)
{
    global $sufijo;
    $error = "";
    //$sql = " select * from ps_image_oferta i,ps_image_oferta_lang l where i.id_image_oferta = l.id_image_oferta and i.id_oferta = '".$idoferta."'";
    $sql = " select * from ps_image_oferta".$sufijo." i where  i.id_oferta = '".intval($idoferta)."'";
    //$results= mysql_query($sql);
    $results=Db::getInstance()->ExecuteS($sql);
        
    if (!$results) $error = ErrorBd();
   
    foreach ($results as $r)
    //while($r = mysql_fetch_assoc($results))
    {
        $insert = " insert into ps_image_oferta_historico".$sufijo."
        (id_oferta_hist,id_image_oferta,position,cover) 
        values 
        ('".intval($idofertahist)."','".intval($r['id_image_oferta'])."','".intval($r['position'])."','".intval($r['cover'])."')";    
        //$result=mysql_query($insert);
        $result=Db::getInstance()->Execute($insert);
        
        if (!$result) $error = ErrorBd('al mover el registro de imagen al histórico de imágenes de ofertas');
    
    
    /*    $insert = " insert into ps_image_oferta_historico_lang
        (id_image_oferta,id_lang,legend) 
        values 
        ('".$r['id_image_oferta']."','".$r['id_lang']."','".$r['legend']."')";    
        $result=mysql_query($insert);
        if (!$result) $error = ErrorBd('al mover el registro de idiomas de la imagen al histórico de imágenes de ofertas');
        //$error = $insert;
    */
     
     }   

    return $error;
}



function InsertarCuponesOfertaAHistoricoCA($idofertahist,$idoferta)
{
    
    global $sufijo;
    $error = "";
    $sql = " select * from ps_ofertas_cupones".$sufijo." where id_oferta = '".intval($idoferta)."'";
    
    //$results= mysql_query($sql);
    $results=Db::getInstance()->ExecuteS($sql);
        
    if (!$results) $error = ErrorBd();
   
    foreach($resultas as $r)
   //    while($r = mysql_fetch_assoc($results))
    {
        
    $insert = " insert into ps_ofertas_cupones_historico".$sufijo." 
    (codigo_reserva,id_oferta_hist,id_usuario,cupon,descripcion,fecha_ini,fecha_fin,usado,vendido,observaciones) 
    values 
    ('".$r['codigo_reserva']."','".intval($idofertahist)."','".intval($r['id_usuario'])."','".$r['cupon']."','".$r['descripcion']."','".$r['fecha_ini']."','".$r['fecha_fin']."','".$r['usado']."','".$r['vendido']."','".$r['observaciones']."')";    
    
    //$result=mysql_query($insert);
    $result=Db::getInstance()->Execute($insert);
        
    if (!$result) $error = ErrorBd('al mover el registro de cupón al histórico de ofertas');
    }

    return $error;
}


 

function MoverArchivosAHistoricoCA($idoferta,$idofertahist)  
{
$path=_PS_OFER_IMG_DIR_DISTR_;    
//$path_dest=dirname(__FILE__).'/../../../img/oh/';
$path_dest= _PS_OFER_HIST_IMG_DIR_DISTR_;
//echo('dir '.$path_dest);
$directorio=dir($path);
$error='';
//echo "Directorio ".$path.":<br><br>";
$i=0;

if (!$dir=opendir(_PS_OFER_IMG_DIR_DISTR_)) $error = " No se pudo acceder al directorio destino ";
chdir($path_dest);
while ($archivo = readdir($dir))
{
    $i++;
    $pos = strpos($archivo,'-');
    if ($pos!=-1 && substr($archivo,0,$pos)==$idoferta)
    {
        //echo(' fuente: '.$path.$archivo.' destino: '.$path_dest.$archivo);
        if (!@copy($path.$archivo,$path_dest.$idofertahist.'-'.substr($archivo,$pos+1))) $error = " No se pudieron copiar los archivos de imagen al histórico";
    }
}

closedir($dir);
return $error;
}


function UpdateOfertaCA($inId, $inIdDesc=null,$inTitulo=null, $inSubtitulo=null, $inDestacados=null, $inCondiciones=null, $inDescripcion=null, $inPrecioValor=null,$inDescuento=null,$inAhorro=null,$inPrecioFinal=null,$inDescripcionCupones=null,$inMultipleCantidad=null,$inLinkVideo=null,$inLinkVideo2=null)
{
          
    global $connection;
    global $sufijo;
    $error = '';
    $sql = " select id_oferta from ps_oferta".$sufijo." where id_oferta = '".intval($inId)."'";
    //return($sql);
    //$result= mysql_query($sql);
    $result=Db::getInstance()->ExecuteS($sql);
    if (!$result) $error = ErrorBd($error = "al modificar los datos de la oferta");
        
    $sql = "";
    
    if ($result)
    {
    $sql = " update ps_oferta".$sufijo." set id_category_default = 2 ";
    if ($inIdDesc!=null)
        $sql .=  " ,id_desc = '".$inIdDesc."'";
    if ($inPrecioValor!=null)
        $sql .=  " ,price = '".$inPrecioValor."'";
    if ($inDescuento!=null)
        $sql .=  " ,reduction_percent = '".$inDescuento."'";
    if ($inPrecioFinal!=null)
        $sql .=  " ,final_price = '".$inPrecioFinal."'";
    if ($inAhorro!=null)
        $sql .=  " ,reduction_price = '".$inAhorro."'";
    if ($inCondiciones!=null)
        $sql .=  ", realiza = '".$inCondiciones."'";
    if ($inDescripcionCupones!=null)
        $sql .=  ", descripcion_cupones = '".$inDescripcionCupones."'";
    if ($inMultipleCantidad!=null)
        $sql .=  ", multiple_cantidad = '".$inMultipleCantidad."'";
    if ($inLinkVideo!=null)
        $sql .=  ", link_video = '".$inLinkVideo."'";
    if ($inLinkVideo2!=null)
        $sql .=  ", link_video2 = '".$inLinkVideo2."'";
                
    $sql .=  " where id_oferta = '".intval($inId)."'";
    //$result= mysql_query($sql);
    $result=Db::getInstance()->Execute($sql);
    
    //traza('debug.sql','update oferta '.$sql);
    
    if (!$result) $error = ErrorBd($error);
    
    $sql = " update ps_oferta_lang".$sufijo." set ";
    $sql .=  " id_lang = '3'";
    if ($inTitulo!=null)
        $sql .=  ", name = '".$inTitulo."'";
    if ($inSubtitulo!=null)
        $sql .=  ", subtitle = '".$inSubtitulo."'";
    if ($inDescripcion!=null)
        $sql .=  ", description = '".$inDescripcion."'";
    if ($inDestacados!=null)
        $sql .=  ", description_short = '".$inDestacados."'";
    $sql .=  " where id_oferta = '".intval($inId)."'";
    //traza('debug.txt',$sql);
    //traza('debug.sql','update oferta  lang'.$sql);
    ///    $result= mysql_query($sql);
    $result=Db::getInstance()->Execute($sql);
    if (!$result) $error = ErrorBd($error="al modificar los datos del registro de idiomas");

    }

    $sql = " select id_oferta_hist,active from ps_oferta_historico".$sufijo." where id_oferta = '".intval($inId)."'";
//    $result= mysql_query($sql);
//die('Error: '.$sql);
    $result=Db::getInstance()->ExecuteS($sql);
  //  if (!$result) $error = ErrorBd($error="al buscar las campañas asociadas");
     
        
    $sql = "";
    
    if ($result)
    {
     foreach($result as $r)   
     //while($r=mysql_fetch_assoc($result))
     {
        if ($r['active']) //sólo modificaremos los datos de una campaña si ésta está activa. 
        {
            $sql = " update ps_oferta_historico".$sufijo." set ";
            if ($inIdDesc!=null)
                $sql .=  " id_desc = '".$inIdDesc."',";
            $sql .=  " id_category_default= 2";
            if ($inPrecioValor!=null)
                $sql .=  " ,price = '".$inPrecioValor."'";
            if ($inDescuento!=null)
                $sql .=  " ,reduction_percent = '".$inDescuento."'";
            if ($inPrecioFinal!=null)
                $sql .=  " ,final_price = '".$inPrecioFinal."'";
            if ($inAhorro!=null)
                $sql .=  " ,reduction_price = '".$inAhorro."'";
            if ($inCondiciones!=null)
                $sql .=  " ,realiza = '".$inCondiciones."'";
            if ($inDescripcionCupones!=null)
                $sql .=  " ,descripcion_cupones = '".$inDescripcionCupones."'";
            if ($inMultipleCantidad!=null)
                $sql .=  " ,multiple_cantidad = '".$inMultipleCantidad."'";
            if ($inLinkVideo!=null)
                $sql .=  ",link_video = '".$inLinkVideo."'";
            if ($inLinkVideo2!=null)
                $sql .=  ",link_video2 = '".$inLinkVideo2."'";
                                
            $sql .=  " where id_oferta_hist = '".intval($r['id_oferta_hist'])."'";
        
            //$result2= mysql_query($sql);
            $result2=Db::getInstance()->Execute($sql);
                    
            if (!$result2) $error = ErrorBd($error="al modificar la campaña");
            
            $sql = " update ps_oferta_historico_lang".$sufijo." set ";
            $sql .=  " id_lang = '3'";
            if ($inTitulo!=null)
                $sql .=  " ,name = '".$inTitulo."'";
            if ($inSubtitulo!=null)
                $sql .=  " ,subtitle = '".$inSubtitulo."'";
            if ($inDescripcion!=null)
                $sql .=  " ,description = '".$inDescripcion."'";
            if ($inDestacados!=null)
                $sql .=  " ,description_short = '".$inDestacados."'";
            $sql .=  " where id_oferta_hist = '".intval($r['id_oferta_hist'])."'";
            
            //$result2= mysql_query($sql);
            $result2=Db::getInstance()->Execute($sql);
            
            if (!$result2) $error = ErrorBd($error="al modificar el reg. de idiomas de la campaña");
            if (!$tmp=deleteImagenesHistoricoCA($r['id_oferta_hist'])) return ErrorBd('al eliminar las imagenes de la oferta');
            if ($tmp=InsertarImagenesOfertaAHistoricoCA($r['id_oferta_hist'],$inId)) $error = $tmp;
            if ($tmp=MoverArchivosAHistoricoCA($inId,$r['id_oferta_hist'])) $error = $tmp;                         
       }
      }
    }
    if ($error) return ($error);
    return('');
}



function DeleteOfertasCA($inId)
{
    global $connection;
    global $sufijo;
   
    $sql = " delete from ps_oferta".$sufijo." where id_oferta = '".intval($inId)."'";  
        //$result=mysql_query($sql);
    $result=Db::getInstance()->Execute($sql);
    if (!$result) return ErrorBd('al eliminar la oferta');
    
    $sql = " delete  from ps_oferta_lang".$sufijo." where id_oferta = '".intval($inId)."'";
    //    $result=mysql_query($sql);
    $result=Db::getInstance()->Execute($sql);
        
    if (!$result) return ErrorBd('al eliminar el registro de idioma de la oferta');

    $sql = " delete from ps_ofertas_cupones".$sufijo." where id_oferta = '".intval($inId)."'";
    //    $result=mysql_query($sql);
    $result=Db::getInstance()->Execute($sql);
    if (!$result) return ErrorBd('al eliminar el cupón de la oferta');
    
 
    if (!deleteImagenesCA($inId)) return ErrorBd('al eliminar las imagenes de la oferta');
 
    if($result) return false;
    
    else return ErrorBd();      
}


function DeleteOfertasHistCA($inId) 
{
    global $connection;
    global $sufijo;
    
    
    //----- Antes de eliminar la campaña comprobaremos si hay que desactivar la oferta asociada.
    
    //Recuperamos el identificador de la oferta a la cual pertenece la campaña eliminada.
    $sql = " select id_oferta from ps_oferta_historico".$sufijo." where id_oferta_hist = '".intval($inId)."'";
    //$result = mysql_query($sql);
    $result=Db::getInstance()->ExecuteS($sql);
    //traza('debug.txt','1:'.$sql);
    //$r=mysql_fetch_assoc($result);
    $r=$result[0];
     
    if ($result) 
    {
        //Comprobamos si existe alguna campaña activa, en caso contrario desactivaremos la oferta asociada.
        $sql = " select count(*) camp_activas from ps_oferta_historico".$sufijo." where active=1 and id_oferta = '".intval($r['id_oferta'])."' and id_oferta_hist != '".intval($inId)."'";
        //traza('debug.txt','2:'.$sql);
        
        //$result2 = mysql_query($sql);
        $result2=Db::getInstance()->ExecuteS($sql);
        //$r2=mysql_fetch_assoc($result2);
        $r2=$result2[0];
        if ($result2 and $r2['camp_activas']==0) 
        {
            $sql = " update ps_oferta".$sufijo." set active=0 where id_oferta = '".intval($r['id_oferta'])."'";  
            //traza('debug.txt','3:'.$sql);
            
            //$result2=mysql_query($sql);
            $result2=Db::getInstance()->Execute($sql);
            }
        else if (!$result2) return ErrorBd('al consultar los registros de histórico '); 
    }
        
    
    //------

    if (!$tmp=deleteImagenesHistoricoCA($inId)) return ErrorBd('al eliminar las imagenes de la oferta');  
   
    $sql = " delete from ps_oferta_historico".$sufijo." where id_oferta_hist = '".intval($inId)."'";  
    //$result=mysql_query($sql);
    $result=Db::getInstance()->Execute($sql);
    if (!$result) return ErrorBd('al eliminar la oferta');
    
    $sql = " delete  from ps_oferta_historico_lang".$sufijo." where id_oferta_hist = '".intval($inId)."'";
    //$result=mysql_query($sql);
    $result=Db::getInstance()->Execute($sql);
    
    if (!$result) return ErrorBd('al eliminar el registro de idioma de la oferta');
    
    $sql = " delete from ps_ofertas_cupones_historico".$sufijo." where id_oferta_hist = '".intval($inId)."'";
    //$result=mysql_query($sql);
    $result=Db::getInstance()->Execute($sql);
    
    if (!$result) return ErrorBd('al eliminar el cupón de la oferta');
    

    //return $tmp;
    if($result) return false;
    
    else return ErrorBd();      
}




function ActivarOfertaCA($idoferta,$periodo,$activar,$desactivacion_manual)
{
    //calculamos la fecha fin de la oferta a partir del periodo.
    //traza('debug.txt','activar-desactivar '.$activar);
    global $sufijo;
    if ($activar)
    {
        list($fechaInicio,$fechaFin)=calcular_fechas_periodo($periodo);
        $fechaInicio = "'".$fechaInicio."'";
        $fechaFin = "'".$fechaFin."'";
    }
    
    $sql = " update ps_oferta".$sufijo." set ";
    if ($activar)
    {
    $sql .=  " date_add = ".$fechaInicio.",";
    $sql .=  " date_upd = ".$fechaInicio.",";
    $sql .=  " fecha_alta = CASE isnull(fecha_alta) or trim(fecha_alta)='' when true then ".$fechaInicio." else fecha_alta end,";
        
    }
    $sql .=  " active = ".intval($activar);
    $sql .=  " where id_oferta = '".intval($idoferta)."'";  
     
    //$result= mysql_query($sql);
    //return 'Error: '.$sql;
    $result=Db::getInstance()->Execute($sql);
    //return $sql;
    $error="al ".($activar?"":"des")."activar la oferta ";


    if ($activar=='0')
    {
        //traza('debug.txt','desactivada');
        $sql = " select id_oferta_hist,active from ps_oferta_historico".$sufijo." where id_oferta = '".intval($idoferta)."'";
        
        //$result = mysql_query($sql);
        $result=Db::getInstance()->ExecuteS($sql);
                //traza('debug.txt',$sql);
        if ($result) 
        {
            foreach($result as $r)
        //     while($r=mysql_fetch_assoc($result))
             {
                 //traza('debug.txt',' active '.$r['active']);

                 //if ($r['active']==0) return(ErrorBd('Esta oferta se desactivó de forma automática. Si desea eliminarla debe hacerlo desde el registro de campañas'));
                //return ('active hist '.$r['active'].' desactmanual '.$desactivacion_manual. 'id_hist '.$r['id_oferta_hist']);
                 
                 
                 //Oferta desactivada de forma automática al alcanzar la fecha de caducidad. 
                 //En ese caso el registro de histórico (campaña) no se elimina sino que se 
                 //marca como desactivado.
                 $set = " set active = 0";
                 if ($desactivacion_manual=='0')
                 {
                     $set .= ",caducada=1";
                 }
                 $sql = " update ps_oferta_historico".$sufijo." ".$set." where active=1 and id_oferta_hist = '".intval($r['id_oferta_hist'])."'";
                 // = mysql_query($sql);
                 $result_update=Db::getInstance()->Execute($sql);
                 if (!$result_update) return ErrorBd('al desactivar el histórico de ofertas');
                 
                 //else $tmp=DeleteOfertasHist($r['id_oferta_hist']);
                 //return(($tmp)?ErrorBd($tmp):false);
             } 
             return false;
   
        }
    }
    return((!$result)?ErrorBd($error):false);
    
}

function deleteImagenesCA($idoferta)
{ 
    global $sufijo;    
    $sql = '
    SELECT `id_image_oferta`
    FROM `ps_image_oferta'.$sufijo.'`
    WHERE `id_oferta` = '.intval($idoferta);
    $result = Db::getInstance()->ExecuteS($sql);

    foreach($result as $row)
    {   //die(FuncionesOfertas::deleteImagen(intval($idoferta), $row['id_image_oferta']));    

        if (!FuncionesOfertas::deleteImagen(intval($idoferta), $row['id_image_oferta'],'oferta','cupones_alfa_online') OR !Db::getInstance()->Execute('DELETE FROM `ps_image_oferta_lang'.$sufijo.'` WHERE `id_image_oferta` = '.intval($row['id_image_oferta'])))
            return false;
    }
    return Db::getInstance()->Execute('DELETE FROM `ps_image_oferta'.$sufijo.'` WHERE `id_oferta` = '.intval($idoferta));       
  }


function deleteImagenesHistoricoCA($idofertahist)
{
    
            
    //return ('param: '.$idofertahist);    
    global $sufijo;
        
    $sql = '
    SELECT ih.id_image_oferta,h.id_oferta
    FROM ps_image_oferta_historico'.$sufijo.' ih,ps_oferta_historico'.$sufijo.' h
    WHERE  ih.id_oferta_hist = h.id_oferta_hist and h.id_oferta_hist = '.intval($idofertahist);
    //return(_PS_OFER_HIST_IMG_DIR_.'error.log');
                                                                                
    //return($sql);
    $result = Db::getInstance()->ExecuteS($sql);
    foreach($result as $row)
    {   //die(FuncionesOfertas::deleteImagen(intval($idoferta), $row['id_image_oferta']));    
        //return 'id_image_oferta: '.intval($row['id_image_oferta']);
        //echo('image: '.intval($row['id_image_oferta']));
        if (!FuncionesOfertas::deleteImagen($idofertahist, $row['id_image_oferta'],'oferta_historico','cupones_alfa_online')) return false;  
        /*if(!Db::getInstance()->Execute('DELETE FROM `ps_image_oferta_historico_lang` WHERE `id_image_oferta` = '.intval($row['id_image_oferta']))) return false;*/
    
    }
    return Db::getInstance()->Execute('DELETE FROM `ps_image_oferta_historico'.$sufijo.'` WHERE `id_oferta_hist` = '.intval($idofertahist));       
  }




?>


