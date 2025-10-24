<?php
/** mts 01/05/2012. 
 * Funciones para mover información entre la los objetos de la clase (modelo)
 *  y la base de datos (las consultas, altas y modificaciones se harán a través de éstas)
 */

include_once(dirname(__FILE__).'/../../../config/config.inc.php');

//include '../../../Establecimiento.php';

/*$bd=_DB_NAME_;
$user=_DB_USER_;
$server=_DB_SERVER_;
$password=_DB_PASSWD_;
$root='images';

// Change this info so that it works with your system.
$connection = mysql_connect($server, $user, $password) or die ("<p class='error'>Lo sentimos, no se puede conectar con el servidor de base de datos.</p>");
mysql_select_db($bd, $connection) or die ("<p class='error'>Lo sentimos, no se puede conectar con la base de datos.</p>");
*/

function GetEstablecimientos($inId=null)
{
	global $link;
    if (!empty($inId))
    {
        $query = mysqli_query($link,"SELECT  e.nombre as nombre_est,e.*,p.*  FROM ps_establecimientos e,provincias p WHERE e.id_provincia = p.id and e.id_establecimiento = " . $inId . " ORDER BY p.nombre,e.nombre DESC"); 
    }
    else
    {
        $query = mysqli_query($link,"SELECT  e.nombre as nombre_est,e.*,p.*  FROM ps_establecimientos e,provincias p where e.id_provincia = p.id  ORDER BY p.nombre,e.nombre DESC"); 
    }

    $establecimientoArray = array();
    while ($row = mysqli_fetch_assoc($query))
    {
     
        $Estab = new Establecimiento($row["id_establecimiento"], $row['nombre_est'], $row['direccion'], $row['email'], $row["telefono"], $row['nif'],$row['usuario'], $row['password'], $row['poblacion'],$row['cpostal'],$row['id_provincia'],$row['fecha_alta'],$row['nombre_contacto'],$row['apellidos_contacto']);
        array_push($establecimientoArray, $Estab);
    }
    return $establecimientoArray;
}


function GetEstablecimientosUSU($inUsuario=null,$inPassword=null)
{
	global $link;
    if (!empty($inUsuario) and !empty($inPassword))
    {
        $query = mysqli_query($link,"SELECT  e.nombre as nombre_est,e.*,p.*  FROM ps_establecimientos e,provincias p WHERE e.id_provincia = p.id and e.usuario = '" . $inUsuario . "' and e.password = '".$inPassword." ' ORDER BY p.nombre,e.nombre DESC"); 
    }
    /*else
    {
        $query = mysql_query("SELECT  e.nombre as nombre_est,e.*,p.*  FROM ps_establecimientos e,provincias p where e.id_provincia = p.id  ORDER BY p.nombre,e.nombre DESC"); 
    }*/
    else $query='';

    $establecimientoArray = array();
    
	if ($query)
	while ($row = mysqli_fetch_assoc($query))   
    {
        $Estab = new Establecimiento($row["id_establecimiento"], $row['nombre_est'], $row['direccion'], $row['email'], $row["telefono"], $row['nif'],$row['usuario'], $row['password'], $row['poblacion'],$row['cpostal'],$row['id_provincia'],$row['fecha_alta'],$row['nombre_contacto'],$row['apellidos_contacto']);
        array_push($establecimientoArray, $Estab);
    }
    return $establecimientoArray;
}

function InsertEstablecimiento($inId, $inNombre, $inDireccion, $inEmail, $inTelefono, $inNif, $inUsuario,$inPassword,$inPoblacion,$inCpostal,$inIdProvincia,$inFechaAlta,$inNombreContacto,$inApellidosContacto)
{
	global $link;
    $sql = " select (max(id_establecimiento)+1) maxid from ps_establecimientos ";
    $result= mysqli_query($link,$sql);
   
    $r = mysqli_fetch_assoc($result);
     
    $NewId = $r['maxid'];
    if ($NewId=="") $NewId = 1;
   
    $sql = " insert into ps_establecimientos (id_establecimiento, nombre, direccion, email, telefono, nif,usuario, password, poblacion,cpostal,id_provincia,fecha_alta,nombre_contacto,apellidos_contacto) ";
    $sql = $sql. " values (".$NewId.",'".$inNombre."','".$inDireccion."','".$inEmail."','".$inTelefono."','".$inNif."','".$inUsuario."','".$inPassword."','".$inPoblacion."','".$inCpostal."',".$inIdProvincia."',".$inIdProvincia.",'".$inFechaAlta."','".$inNombreContacto."','".$inApellidosContacto."')";

    $result=mysqli_query($link,$sql);
 
    if($result) return true;
    else return false;      
}



function UpdateEstablecimiento($inId, $inNombre, $inDireccion, $inEmail, $inTelefono, $inNif, $inUsuario,$inPassword,$inPoblacion,$inCpostal,$inIdProvincia,$inFechaAlta,$inNombreContacto,$inApellidosContacto)
{
	global $link;
    $sql = " select (id_establecimiento from ps_establecimientos where id_establecimiento = '".$inId."'";
    $result= mysqli_query($link,$sql);
    if ($result)
    {
    $sql = " update ps_establecimientos set ";
    $sql = $sql + " nombre = '".$inNombre."',";
    $sql = $sql + " direccion= '".$inDireccion."',";
    $sql = $sql + " email = '".$inEmail."',";
    $sql = $sql + " telefono = '".$inTelefono."',";
    $sql = $sql + " nif = '".$inNif."',";
    $sql = $sql + " usuario = '".$inUsuario."',";
    $sql = $sql + " password = '".$inPassword."',";
    $sql = $sql + " poblacion = '".$inPoblacion."',";
    $sql = $sql + " cpostal = '".$inCpostal."',";
    $sql = $sql + " id_provincia = ".$inIdProvincia.",";
    $sql = $sql + " fecha_alta = '".$inFechaAlta."',";
    $sql = $sql + " nombre_contacto = '".$inNombreContacto."',";
    $sql = $sql + " apellidos_contacto = '".$inApellidosContacto."'";
    $sql = $sql + " where id_establecimiento = '".$inId."'";
    
    $result= mysqli_query($link,$sql);
    if ($result) return true;
    else return false;
    }
    else return false;
}



function DeleteEstablecimiento($inId)
{
          
    global $link;
   
   
    $sql = " delete  from ps_cupones where id_establecimiento = '".$inId."'";
    $result=mysqli_query($link,$sql);


    $sql = " delete  from ps_talonarios where id_establecimiento = '".$inId."'";
    $result=mysqli_query($link,$sql);


    $sql = " delete  from ps_establecimientos where id_establecimiento = '".$inId."'";
    $result=mysqli_query($link,$sql);
           
    if($result) return true;
    
    else return false;      
}


?>


