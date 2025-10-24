<?php
/** mts 01/05/2012. 
 * Funciones para mover información entre la los objetos de la clase (modelo)
 *  y la base de datos (las consultas, altas y modificaciones se harán a través de éstas)
 */
  
include_once(dirname(__FILE__).'/../../../config/config.inc.php');
include_once(dirname(__FILE__).'/../../../classes/FuncionesOfertas.php');

include_once(dirname(__FILE__).'/conversiones_html.php');
include_once(dirname(__FILE__).'/contador_periodos_oferta.php');
//include_once(dirname(__FILE__).'/trazas.php');
include '../../../Oferta_.php';
include '../../../OfertaHistorico.php';

$bd=_DB_NAME_;
$user=_DB_USER_;
$server=_DB_SERVER_;
$password=_DB_PASSWD_;
$root='images';

$connection = mysql_connect($server, $user, $password) or die ("<p class='error'>Lo sentimos, no se puede conectar con el servidor de base de datos.</p>");
mysql_select_db($bd, $connection) or die ("<p class='error'>Lo sentimos, no se puede conectar con la base de datos.</p>");

function ErrorBd($err = null)
{
    if (!$err) return (mysql_errno().'-'.mysql_error());
    else return ($err);
}

function GetOfertas($inId=null,$orden=null)
{
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
  
        $sql = "SELECT  o.*,ol.*  FROM ps_oferta o,ps_oferta_lang ol where o.id_oferta = ol.id_oferta and o.id_oferta = " . $inId . " ORDER BY ol.name ASC";
         
        $query = mysql_query($sql); 
    }
    else
    {
        //$sql = "SELECT  o.*,ol.*  FROM ps_oferta o,ps_oferta_lang ol where o.id_oferta = ol.id_oferta  ORDER BY ol.name ASC";   
        $sql = "SELECT  o.*,ol.*  FROM ps_oferta o,ps_oferta_lang ol where o.id_oferta = ol.id_oferta  ".$order_by;
        $query = mysql_query($sql); 
    }

    $ofertaArray = array();
    while ($row = mysql_fetch_assoc($query))
    {
     //******
       
        $price = floatval($row["price"]);
        $reduction_price=floatval($row["reduction_price"]);
        $final_price=floatval($row["final_price"]);
        $Oferta = new Oferta_($row["id_oferta"],$row["id_desc"], $row['name'], $row['subtitle'], $row['description_short'], $row["realiza"], $row['description'],$price, $row['reduction_percent'],$reduction_price,$final_price,$row['date_add'],$row['date_upd'],$row['active'],$row['observaciones'],$row['cliente_especial'],$row['descripcion_cupones'],$row['multiple_cantidad'],$row['orden'],$row['link_video'],$row['link_video2']);
        
 //       $inId=null, $inTitulo=null, $inSubtitulo=null, $inDestacados=null, $inCondiciones=null, $inDescripcion=null, $inPrecioValor=null,$inPrecioOferta=null
        array_push($ofertaArray, $Oferta);
    }
    return $ofertaArray;
}


//Compacta los valores del campo orden de las ofertas (entidad='ofertas') o de las Campañas (entidad='campanyas').
function CompactarOrdenOfertas($entidad='campanyas')
{
    global $connection;
    $error = '';

    if ($entidad == 'ofertas')
    {
        $error_consulta = "al consultar las ofertas para la compactación";
        $sql = " select id_oferta,orden from ps_oferta order by orden ASC ";
        $result= mysql_query($sql);
        if (!$result) $error = ErrorBd($error_consulta);
        
        $orden=1;
        
        while ($r = mysql_fetch_assoc($result))
        {
            $sql = " update ps_oferta set orden = ".$orden.' where id_oferta = '.$r['id_oferta']; 
            $result2= mysql_query($sql);
            if (!$result2) {$error = ErrorBd('Error durante la compactación');}
            $orden++;
        }    
        
    }
    else 
    {
        $error_consulta = "al consultar las campañas para la compactación";
        $sql = " select id_oferta_hist,orden from ps_oferta_historico order by orden ASC ";
        $result= mysql_query($sql);
        if (!$result) $error = ErrorBd($error_consulta);
        
        $orden=1;
        
        while ($r = mysql_fetch_assoc($result))
        {
            $sql = " update ps_oferta_historico set orden = ".$orden.' where id_oferta_hist = '.$r['id_oferta_hist']; 
            $result2= mysql_query($sql);
            if (!$result2) {$error = ErrorBd('Error durante la compactación');}
            $orden++;
        }    
            
    }
    
    return $error;
}

function GetOfertasHistorico($inId=null,$inIdOferta=null,$orden=null,$clienteEspecial=null)
{
    $where = '';
    if ($inId!=null)
        $where.= ' and o.id_oferta_hist="'.$inId.'"';
    if ($inIdOferta!=null)
        $where.= ' and o.id_oferta="'.$inIdOferta.'"';
    if ($clienteEspecial!=null)
        $where.= ' and o.cliente_especial="'.$clienteEspecial.'"';

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
            $orderby = " ORDER BY orden1,orden2 DESC ";
            break;
        default: $orderby = " ORDER BY ol.name ASC";        
    }

    $sql = "SELECT  o.*,ol.*,
                    case active when 1 then 1 else 2 end orden1,
                    case active when 1 then orden else date_add end orden2  
            FROM ps_oferta_historico o,ps_oferta_historico_lang ol where o.id_oferta_hist = ol.id_oferta_hist ".
    $where.' '.$orderby;
    
    //if ($clienteEspecial==1) traza('debug.txt',$sql);
    $query = mysql_query($sql); 

    $ofertaArray = array();
    while ($row = mysql_fetch_assoc($query))
    {
     //******
       
        $price = floatval($row["price"]);
        $reduction_price=floatval($row["reduction_price"]);
        $final_price=floatval($row["final_price"]);
                
        $Oferta = new OfertaHistorico($row["id_oferta_hist"],$row["id_oferta"],$row["id_desc"], $row['name'], $row['subtitle'], $row['description_short'], $row["realiza"], $row['description'],$price, $row['reduction_percent'],$reduction_price,$final_price,$row['date_add'],$row['date_upd'],$row['active'],$row['observaciones'],$row['cliente_especial'],null,$row['orden'],$row['caducada'],$row['descripcion_cupones'],$row['multiple_cantidad'],$row['link_video'],$row['link_video2']);
        
 //       $inId=null, $inTitulo=null, $inSubtitulo=null, $inDestacados=null, $inCondiciones=null, $inDescripcion=null, $inPrecioValor=null,$inPrecioOferta=null
        array_push($ofertaArray, $Oferta);
    }
    return $ofertaArray;
}


function InsertOferta($inIdDesc,$inTitulo, $inSubtitulo, $inDestacados, $inCondiciones, $inDescripcion, $inPrecioValor,$inDescuento,$inAhorro,$inPrecioFinal,$inDescripcionCupones,$inMultipleCantidad,$inLinkVideo=null,$inLinkVideo=null)
{          
    global $connection;
    $error = "";
    
  
    $sql = " select (max(id_oferta)+1) maxid,(max(orden)+1) maxorden from ps_oferta ";
    $result= mysql_query($sql);
    
    if (!$result) $error = ErrorBd();
   
    
    $r = mysql_fetch_assoc($result);
     
    $NewId = $r['maxid'];
    $NewOrden = $r['maxorden'];
    
    if ($NewId=="") $NewId = 1;
    if ($NewOrden=="") $NewOrden = 1;
   
    //$Oferta = new Oferta_($row["id_oferta"],$row["id_desc"], $row['name'], $row['subtitle'], $row['description_short'], $row["realiza"], $row['description'],$price, $row['reduction_percent'], $row['reduction_price'],$row['final_price']);
 
   
    $sql = " insert into ps_oferta (id_oferta,orden,id_desc,id_category_default,price,reduction_percent,active,reduction_price,final_price,realiza,descripcion_cupones,multiple_cantidad,link_video,link_video2) ";
 
    $sql = $sql. " values (".$NewId.",".$NewOrden.",'".$inIdDesc."',2,'".$inPrecioValor."','".$inDescuento."',0,'".$inAhorro."','".$inPrecioFinal."','".$inCondiciones."','".$inDescripcionCupones."','".$inMultipleCantidad."','".$inLinkVideo."','".$inLinkVideo2."')";

    $result=mysql_query($sql);
 
    if (!$result) $error = ErrorBd('al crear la oferta');

    $sql = " insert into ps_oferta_lang (id_oferta,id_lang,name,subtitle,description,description_short) ";
 
    $sql = $sql. " values (".$NewId.",'3','".$inTitulo."','".$inSubtitulo."','".$inDescripcion."','".$inDestacados."')";
     //traza('debug.txt',$sql);
    $result=mysql_query($sql);

    if (!$result) $error = ErrorBd('al crear el registro de idiomas de la oferta');

    if(!$error) return array($NewId,"");
    else return array(0,$error);      
}



function InsertarImagenesOfertaADuplicado($idoferta,$idoferta_dest)
{
    $error = "";
    $sql = " select * from ps_image_oferta i where  i.id_oferta = '".$idoferta."'";
    
    $results= mysql_query($sql);
    
    if (!$results) $error = ErrorBd();
   
    while($r = mysql_fetch_assoc($results))
    {
        $insert = " insert into ps_image_oferta
        (id_oferta,id_image_oferta,position,cover) 
        values 
        ('".$idoferta_dest."','".$r['id_image_oferta']."','".$r['position']."','".$r['cover']."')";    
        
        //traza('debug.txt',$insert);
        $result=mysql_query($insert);
        if (!$result) $error = ErrorBd('al mover el registro de imagen a la oferta duplicada');
     
     }   

    return $error;
}


function MoverArchivosADuplicado($idoferta,$idoferta_dest)  
{
$path=_PS_OFER_IMG_DIR_;    
$path_dest= _PS_OFER_IMG_DIR_;
$directorio=dir($path);
$error='';

$i=0;

if (!$dir=opendir(_PS_OFER_IMG_DIR_)) $error = " No se pudo acceder al directorio destino ";
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



function InsertOfertaHistorico($inIdOferta,$inIdDesc,$inTitulo, $inSubtitulo, $inDestacados, $inCondiciones, $inDescripcion, $inPrecioValor,$inDescuento,$inAhorro,$inPrecioFinal,$inFechaInicio,$inFechaFin,$inActiva,$inDescripcionCupones,$inMultipleCantidad,$inClienteEspecial=null,$inLinkVideo=null,$inLinkVideo2=null)
{          
    global $connection;
    $error = "";
  
 
    /*$sql = " select id_oferta_hist from ps_oferta_historico where id_oferta = '".$inIdOferta."'";
    $result = mysql_query($sql);
    if ($result) { $r=mysql_fetch_assoc($result);$tmp=DeleteOfertasHist($r['id_oferta_hist']);}
     */
    //return array(0,$tmp);
 
    $sql = " select (max(id_oferta_hist)+1) maxid,(max(orden)+1) maxorden from ps_oferta_historico ";
    $result= mysql_query($sql);
    
    if (!$result) $error = ErrorBd();
   
    
    $r = mysql_fetch_assoc($result);
     
    $NewId = $r['maxid'];
    $NewOrden = $r['maxorden'];
    
    if ($NewId=="") $NewId = 1;
    if ($NewOrden=="") $NewOrden = 1;
    
   
    //$Oferta = new OfertaHistorico($row["id_oferta_hist"],$row["id_oferta"],$row["id_desc"], $row['name'], $row['subtitle'], $row['description_short'], $row["realiza"], $row['description'],$price, $row['reduction_percent'], $row['reduction_price'],$row['final_price']);
 
    $clienteEspecial = ($inClienteEspecial==1)?$inClienteEspecial:0;
    $sql = " insert into ps_oferta_historico (id_oferta_hist,id_oferta,id_desc,id_category_default,price,reduction_percent,active,reduction_price,final_price,realiza,date_add,date_upd,orden,descripcion_cupones,multiple_cantidad,cliente_especial,link_video,link_video2) ";
 
    $sql = $sql. " values (".$NewId.",".$inIdOferta.",'".$inIdDesc."',2,'".$inPrecioValor."','".$inDescuento."',".$inActiva.",'".$inAhorro."','".$inPrecioFinal."','".$inCondiciones."','".$inFechaInicio."','".$inFechaFin."','".$NewOrden."','".$inDescripcionCupones."','".$inMultipleCantidad."','".$clienteEspecial."','".$inLinkVideo."','".$inLinkVideo2."')";
    
    //traza('debug.txt',$sql);
    //return array(1,$sql);
    $result=mysql_query($sql);
 
    if (!$result) $error = ErrorBd('al crear la oferta');


    $sql = " insert into ps_oferta_historico_lang (id_oferta_hist,id_lang,name,subtitle,description,description_short) ";
 
    $sql = $sql. " values (".$NewId.",'3','".$inTitulo."','".$inSubtitulo."','".$inDescripcion."','".$inDestacados."')";
    //traza('debug.txt','hist: '.$sql); 
    $result=mysql_query($sql);

    if (!$result) $error = ErrorBd('al crear el registro de idiomas de la oferta');


    if ($tmp=InsertarImagenesOfertaAHistorico($NewId,$inIdOferta)) $error = $tmp;
    
    //if ($tmp=InsertarCuponesOfertaAHistorico($NewId,$inIdOferta)) $error = $tmp;
    
    if ($tmp=MoverArchivosAHistorico($inIdOferta,$NewId)) $error = $tmp;
    //return array(0,$tmp);
    
     
    if(!$error) return array($NewId,"");
    else return array(0,$error);      
}



function InsertarImagenesOfertaAHistorico($idofertahist,$idoferta)
{
    $error = "";
    //$sql = " select * from ps_image_oferta i,ps_image_oferta_lang l where i.id_image_oferta = l.id_image_oferta and i.id_oferta = '".$idoferta."'";
    $sql = " select * from ps_image_oferta i where  i.id_oferta = '".$idoferta."'";
    
    $results= mysql_query($sql);
    
    if (!$results) $error = ErrorBd();
   
    while($r = mysql_fetch_assoc($results))
    {
        $insert = " insert into ps_image_oferta_historico
        (id_oferta_hist,id_image_oferta,position,cover) 
        values 
        ('".$idofertahist."','".$r['id_image_oferta']."','".$r['position']."','".$r['cover']."')";    
        $result=mysql_query($insert);
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



function InsertarCuponesOfertaAHistorico($idofertahist,$idoferta)
{
    
    
    $error = "";
    $sql = " select * from ps_ofertas_cupones where id_oferta = '".$idoferta."'";
    
    $results= mysql_query($sql);
    
    if (!$results) $error = ErrorBd();
   
    while($r = mysql_fetch_assoc($results))
    {
        
    $insert = " insert into ps_ofertas_cupones_historico 
    (codigo_reserva,id_oferta_hist,id_usuario,cupon,descripcion,fecha_ini,fecha_fin,usado,vendido,observaciones) 
    values 
    ('".$r['codigo_reserva']."','".$idofertahist."','".$r['id_usuario']."','".$r['cupon']."','".$r['descripcion']."','".$r['fecha_ini']."','".$r['fecha_fin']."','".$r['usado']."','".$r['vendido']."','".$r['observaciones']."')";    
    
    $result=mysql_query($insert);
    if (!$result) $error = ErrorBd('al mover el registro de cupón al histórico de ofertas');
    }

    return $error;
}


 

function MoverArchivosAHistorico($idoferta,$idofertahist)  
{
$path=_PS_OFER_IMG_DIR_;    
//$path_dest=dirname(__FILE__).'/../../../img/oh/';
$path_dest= _PS_OFER_HIST_IMG_DIR_;
//echo('dir '.$path_dest);
$directorio=dir($path);
$error='';
//echo "Directorio ".$path.":<br><br>";
$i=0;

if (!$dir=opendir(_PS_OFER_IMG_DIR_)) $error = " No se pudo acceder al directorio destino ";
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


function UpdateOferta($inId, $inIdDesc=null,$inTitulo=null, $inSubtitulo=null, $inDestacados=null, $inCondiciones=null, $inDescripcion=null, $inPrecioValor=null,$inDescuento=null,$inAhorro=null,$inPrecioFinal=null,$inDescripcionCupones=null,$inMultipleCantidad=null,$inLinkVideo = null,$inLinkVideo2 = null)
{
          
    global $connection;
    $error = '';
    $sql = " select id_oferta from ps_oferta where id_oferta = '".$inId."'";
    $result= mysql_query($sql);
    if (!$result) $error = ErrorBd($error = "al modificar los datos de la oferta");
    
        
    $sql = "";
    
    if ($result)
    {
    $sql = " update ps_oferta set id_category_default= 2 ";
    if ($inIdDesc!=null)
        $sql .=  ",id_desc = '".$inIdDesc."'";
    if ($inPrecioValor!=null)
        $sql .=  ",price = '".$inPrecioValor."'";
    if ($inDescuento!=null)
        $sql .=  ",reduction_percent = '".$inDescuento."'";
    if ($inPrecioFinal!=null)
        $sql .=  ",final_price = '".$inPrecioFinal."'";
    if ($inAhorro!=null)
        $sql .=  ",reduction_price = '".$inAhorro."'";
    if ($inCondiciones!=null)
        $sql .=  ",realiza = '".$inCondiciones."'";
    if ($inDescripcionCupones!=null)
        $sql .=  ",descripcion_cupones = '".$inDescripcionCupones."'";
    if ($inMultipleCantidad!=null)
        $sql .=  ",multiple_cantidad = '".$inMultipleCantidad."'";
    if ($inLinkVideo!=null)
        $sql .=  ",link_video = '".$inLinkVideo."'";
    if ($inLinkVideo2!=null)
        $sql .=  ",link_video2 = '".$inLinkVideo2."'";
                
    $sql .=  " where id_oferta = '".$inId."'";
    $result= mysql_query($sql);

    if (!$result) $error = ErrorBd($error);
    
    $sql = " update ps_oferta_lang set ";
    $sql .=  " id_lang = '3'";
    if ($inTitulo!=null)
        $sql .=  ", name = '".$inTitulo."'";
    if ($inSubtitulo!=null)
        $sql .=  ", subtitle = '".$inSubtitulo."'";
    if ($inDescripcion!=null)
        $sql .=  ", description = '".$inDescripcion."'";
    if ($inDestacados!=null)
        $sql .=  ", description_short = '".$inDestacados."'";
    $sql .=  " where id_oferta = '".$inId."'";
    //traza('debug.txt    ',$sql);
    $result= mysql_query($sql);
    if (!$result) $error = ErrorBd($error="al modificar los datos del registro de idiomas");

    }

    $sql = " select id_oferta_hist,active from ps_oferta_historico where id_oferta = '".$inId."'";
    $result= mysql_query($sql);
    //traza('debugOfHist.txt',$sql);
    if (!$result) $error = ErrorBd($error="al buscar las campañas asociadas");
     
        
    $sql = "";
    
    if ($result)
    {
     while($r=mysql_fetch_assoc($result))
     {
        if ($r['active']) //sólo modificaremos los datos de una campaña si ésta está activa. 
        {      
            $sql = " update ps_oferta_historico set ";
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
                $sql .=  " ,link_video = '".$inLinkVideo."'";
            if ($inLinkVideo2!=null)
                $sql .=  " ,link_video2 = '".$inLinkVideo2."'";
                                
            $sql .=  " where id_oferta_hist = '".$r['id_oferta_hist']."'";
        //traza('debugOfHist.txt','2: '.$sql);
            $result2= mysql_query($sql);
        
            if (!$result2) $error = ErrorBd($error="al modificar la campaña");
            
            $sql = " update ps_oferta_historico_lang set ";
            $sql .=  " id_lang = '3'";
            if ($inTitulo!=null)
                $sql .=  " ,name = '".$inTitulo."'";
            if ($inSubtitulo!=null)
                $sql .=  " ,subtitle = '".$inSubtitulo."'";
            if ($inDescripcion!=null)
                $sql .=  " ,description = '".$inDescripcion."'";
            if ($inDestacados!=null)
                $sql .=  " ,description_short = '".$inDestacados."'";
            $sql .=  " where id_oferta_hist = '".$r['id_oferta_hist']."'";
            
            $result2= mysql_query($sql);
            if (!$result2) $error = ErrorBd($error="al modificar el reg. de idiomas de la campaña");
            
            if (!$tmp=deleteImagenesHistorico($r['id_oferta_hist'])) return ErrorBd('al eliminar las imagenes de la oferta');
                        
            if ($tmp=InsertarImagenesOfertaAHistorico($r['id_oferta_hist'],$inId)) $error = $tmp;
            if ($tmp=MoverArchivosAHistorico($inId,$r['id_oferta_hist'])) $error = $tmp;                         
       }
      }
    }
    if ($error) return ($error);
    return('');
}



function DeleteOfertas($inId)
{
    global $connection;
   
    $sql = " delete from ps_oferta where id_oferta = '".$inId."'";  
    $result=mysql_query($sql);
    if (!$result) return ErrorBd('al eliminar la oferta');
    
    $sql = " delete  from ps_oferta_lang where id_oferta = '".$inId."'";
    $result=mysql_query($sql);
    if (!$result) return ErrorBd('al eliminar el registro de idioma de la oferta');

    $sql = " delete from ps_ofertas_cupones where id_oferta = '".$inId."'";
    $result=mysql_query($sql);
    if (!$result) return ErrorBd('al eliminar el cupón de la oferta');
    

    if (!deleteImagenes($inId)) return ErrorBd('al eliminar las imagenes de la oferta');
 
    if($result) return false;
    
    else return ErrorBd();      
}


function DeleteOfertasHist($inId) 
{
    global $connection;
    
    
    //----- Antes de eliminar la campaña comprobaremos si hay que desactivar la oferta asociada.
    
    //Recuperamos el identificador de la oferta a la cual pertenece la campaña eliminada.
    $sql = " select id_oferta,cliente_especial from ps_oferta_historico where id_oferta_hist = '".$inId."'";
    $result = mysql_query($sql);
    //traza('debug.txt','1:'.$sql);
    $r=mysql_fetch_assoc($result);
    
    if ($result) 
    {
        //Comprobamos si existe alguna campaña activa, en caso contrario desactivaremos la oferta asociada.
        $sql = " select count(*) camp_activas from ps_oferta_historico where active=1 and id_oferta = '".$r['id_oferta']."' and id_oferta_hist != '".$inId."'";
        //traza('debug.txt','2:'.$sql);
        
        $result2 = mysql_query($sql);
        $r2=mysql_fetch_assoc($result2);
        if ($result2 and $r2['camp_activas']==0 and $r['cliente_especial']!=1) 
        {
            $sql = " update ps_oferta set active=0 where id_oferta = '".$r['id_oferta']."' and cliente_especial != 1 ";  
            //traza('debug.txt','3:'.$sql);
            
            $result2=mysql_query($sql);
        }
        else if (!$result2) return ErrorBd('al consultar los registros de histórico '); 
    }
        
    
    //------

    if (!$tmp=deleteImagenesHistorico($inId)) return ErrorBd('al eliminar las imagenes de la oferta');  
   
    $sql = " delete from ps_oferta_historico where id_oferta_hist = '".$inId."'";  
    $result=mysql_query($sql);
    if (!$result) return ErrorBd('al eliminar la oferta');
    
    $sql = " delete  from ps_oferta_historico_lang where id_oferta_hist = '".$inId."'";
    $result=mysql_query($sql);
    if (!$result) return ErrorBd('al eliminar el registro de idioma de la oferta');
    
    $sql = " delete from ps_ofertas_cupones_historico where id_oferta_hist = '".$inId."'";
    $result=mysql_query($sql);
    if (!$result) return ErrorBd('al eliminar el cupón de la oferta');
    

    //return $tmp;
    if($result) return false;
    
    else return ErrorBd();      
}




function ActivarOferta($idoferta,$periodo,$activar,$desactivacion_manual)
{
    //calculamos la fecha fin de la oferta a partir del periodo.
    //traza('debug.txt','activar-desactivar '.$activar);
    
    if ($activar)
    {
        list($fechaInicio,$fechaFin)=calcular_fechas_periodo($periodo); 
        $fechaInicio = "'".$fechaInicio."'";
        $fechaFin = "'".$fechaFin."'";
    }
    
    $sql = " update ps_oferta set ";
    if ($activar)
    {
    $sql .=  " date_add = ".$fechaInicio.",";
    $sql .=  " date_upd = ".$fechaFin.",";
    }
    $sql .=  " active = ".$activar;
    $sql .=  " where id_oferta = '".$idoferta."'";  
     
    $result= mysql_query($sql);
    //return $sql;
    $error="al ".($activar?"":"des")."activar la oferta ";


    if ($activar=='0')
    {
        //traza('debug.txt','desactivada');
        $sql = " select id_oferta_hist,active from ps_oferta_historico where id_oferta = '".$idoferta."'";
        
        $result = mysql_query($sql);
        //traza('debug.txt',$sql);
        if ($result) 
        {
             while($r=mysql_fetch_assoc($result))
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
                 $sql = " update ps_oferta_historico ".$set." where active=1 and id_oferta_hist = '".$r['id_oferta_hist']."'";
                 $result_update = mysql_query($sql);
                 if (!$result_update) return ErrorBd('al desactivar el histórico de ofertas');
                 
                 //else $tmp=DeleteOfertasHist($r['id_oferta_hist']);
                 //return(($tmp)?ErrorBd($tmp):false);
             } 
             return false;
   
        }
    }
    return((!$result)?ErrorBd($error):false);
    
}

function deleteImagenes($idoferta)
{ 
    
    $sql = '
    SELECT `id_image_oferta`
    FROM `ps_image_oferta`
    WHERE `id_oferta` = '.intval($idoferta);
    $result = Db::getInstance()->ExecuteS($sql);

    foreach($result as $row)
    {   //die(FuncionesOfertas::deleteImagen(intval($idoferta), $row['id_image_oferta']));    

        if (!FuncionesOfertas::deleteImagen(intval($idoferta), $row['id_image_oferta'],'oferta') OR !Db::getInstance()->Execute('DELETE FROM `ps_image_oferta_lang` WHERE `id_image_oferta` = '.intval($row['id_image_oferta'])))
            return false;
    }
    return Db::getInstance()->Execute('DELETE FROM `ps_image_oferta` WHERE `id_oferta` = '.intval($idoferta));       
  }


function deleteImagenesHistorico($idofertahist)
{
    
            
    //return ('param: '.$idofertahist);    
    
    $sql = '
    SELECT ih.id_image_oferta,h.id_oferta
    FROM ps_image_oferta_historico ih,ps_oferta_historico h
    WHERE  ih.id_oferta_hist = h.id_oferta_hist and h.id_oferta_hist = '.intval($idofertahist);
    //return(_PS_OFER_HIST_IMG_DIR_.'error.log');
                                                                                
    //return($sql);
    $result = Db::getInstance()->ExecuteS($sql);
    foreach($result as $row)
    {   //die(FuncionesOfertas::deleteImagen(intval($idoferta), $row['id_image_oferta']));    
        //return 'id_image_oferta: '.intval($row['id_image_oferta']);
        //echo('image: '.intval($row['id_image_oferta']));
        if (!FuncionesOfertas::deleteImagen($idofertahist, $row['id_image_oferta'],'oferta_historico')) return false;  
        /*if(!Db::getInstance()->Execute('DELETE FROM `ps_image_oferta_historico_lang` WHERE `id_image_oferta` = '.intval($row['id_image_oferta']))) return false;*/
    
    }
    return Db::getInstance()->Execute('DELETE FROM `ps_image_oferta_historico` WHERE `id_oferta_hist` = '.intval($idofertahist));       
  }




?>


