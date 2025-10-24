<?php
/** mts 01/05/2012. 
 * Funciones para mover información entre la los objetos de la clase (modelo)
 *  y la base de datos (las consultas, altas y modificaciones se harán a través de éstas)
 */

include_once(dirname(__FILE__).'/../../../config/config.inc.php');
include '../../../Oferta_.php';
include '../../../Usuario.php';
include '../../../CuponOferta.php';
include '../../../Db.php';
 
/*$bd=_DB_NAME_;
$user=_DB_USER_;
$server=_DB_SERVER_;
$password=_DB_PASSWD_;
$root='images';

// Change this info so that it works with your system.
$connection = mysql_connect($server, $user, $password) or die ("<p class='error'>Lo sentimos, no se puede conectar con el servidor de base de datos.</p>");    
mysql_select_db($bd, $connection) or die ("<p class='error'>Lo sentimos, no se puede conectar con la base de datos.</p>");

function ErrorBd($err = null)
{
    if (!$err) return (mysql_errno().'-'.mysql_error());
    else return ($err);
}
*/

function GetClientes($inOrden,$inDireccion,$inIdOferta=null,$inFiltros=null)
{
    
    switch ($inOrden)
    {
        case '0':
            $orden = "u.id_usuario ";
            $direccion = ($inDireccion=='0')?'ASC':'DESC';
        break;
        case '1':
            $direccion = ($inDireccion=='1')?'ASC':'DESC';
            $orden = "u.apellidos ";        
        break;
    }   
    
    $where = '';
    if ($inFiltros!=null and trim($inFiltros)!='')
    {
    $inFiltros = pSQL($inFiltros);    
    $where.= ' and u.nombre like "%'.$inFiltros.'%" 
               or u.apellidos like "%'.$inFiltros.'%" 
               or u.email like "%'.$inFiltros.'%"
               or u.direccion like "%'.$inFiltros.'%"
               or u.poblacion like "%'.$inFiltros.'%"
               or u.telefono like "%'.$inFiltros.'%"
               or u.cpostal like "%'.$inFiltros.'%"';
    }           
                                      
    if (!empty($inIdOferta))    
    {
        $sql = "SELECT  u.*,c.*  FROM ps_usuarios u,ps_ofertas_cupones c WHERE c.id_usuario = u.id_usuario and c.id_oferta = '".pSQL($inIdOferta)."'".$where." ORDER BY ".$orden.$direccion;
        //rerturn($sql);
        $query=Db::getInstance()->ExecuteS($sql);
        //$query = mysql_query($sql); 
    }
    else
    {
        $sql = "SELECT  u.*  FROM ps_usuarios u where true ".$where." ORDER BY ".$orden.$direccion;
        //rerturn($sql);
        $query=Db::getInstance()->ExecuteS($sql);
        //$query = mysql_query($sql); 
    }
//return ($sql);
    $usuarioArray = array();
    foreach ($query as $row)
    //while ($row = mysql_fetch_assoc($query))
    {
                
        $Usuario = new Usuario(pSQL($row['id_usuario']), pSQL($row['email']),pSQL($row['password']),pSQL($row['nombre']),pSQL($row['apellidos']),pSQL($row['fecha_nacimiento']), 
                     pSQL($row['sexo']), pSQL($row['telefono']),pSQL($row['activo']),pSQL($row['fecha_alta']),pSQL($row['fecha_baja']),pSQL($row['direccion']),pSQL($row['poblacion']),
                     pSQL($row['cpostal']),pSQL($row['ultimo_pago']),pSQL($row['pagados']),pSQL($row['fechaPagoForm']),pSQL($row['ultima_transaccion']));
        
        array_push($usuarioArray, $Usuario);
    }
    return $usuarioArray;
}

?>


