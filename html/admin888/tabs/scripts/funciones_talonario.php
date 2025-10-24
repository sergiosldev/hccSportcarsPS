<?php
/** mts 04/05/2012. 
 * Funciones para mover información entre  los objetos de la clase talonario (modelo)
 *  y la base de datos (las consultas, altas y modificaciones se harán a través de éstas)
 */

include_once(dirname(__FILE__).'/../../../config/config.inc.php');
include_once('config_events_new.php');

include '../../../Talonario.php';


function GetTalonarios($inIdEstablecimiento=null)
{
	global $link;
    if (!empty($inIdEstablecimiento))
    {
        $sql = "SELECT t.id_establecimiento,t.id_talonario,t.numero numero_talonario,min(cast(c.numero as unsigned)) min_cupon,";
        $sql.= "       max(cast(c.numero as unsigned)) max_cupon ";
        $sql.= "FROM ps_talonarios t,ps_cupones c  ";
        $sql.= "WHERE t.id_talonario = c.id_talonario and  t.id_establecimiento = c.id_establecimiento and t.id_establecimiento = " . $inIdEstablecimiento;
        $sql.= " group by t.id_establecimiento,t.id_talonario";
        $sql.= " ORDER BY t.numero,c.numero DESC ";
        $query = mysqli_query($link,$sql ); 
    }

    $talonarioArray = array();
    while ($row = mysqli_fetch_assoc($query))
    {
        $Talonario = new Talonario($row["id_establecimiento"], $row['id_talonario'],$row['numero_talonario'], $row['min_cupon'], $row['max_cupon']);
        if ($row["id_establecimiento"] != NULL) 
        array_push($talonarioArray, $Talonario);
    }
    return $talonarioArray;
}


function GetTalonario($inIdEstablecimiento,$inIdTalonario,$inNumTalonario=null)
{
	global $link;
    $result = "";
    if (!empty($inIdEstablecimiento) and (!empty($inIdTalonario) or (!empty($inNumTalonario) and $inNumTalonario!=null)))
    {           
        $sql = "SELECT * ";
        $sql.= "FROM ps_talonarios ";
        $sql.= "WHERE  id_establecimiento = " . $inIdEstablecimiento;
		if (!empty($inIdTalonario))
			$sql.= " and id_talonario = " . $inIdTalonario;
 		else if (!empty($inNumTalonario) and $inNumTalonario!=null)
			$sql.= " and numero = " . $inNumTalonario;
		$result = mysqli_query($link,$sql); 
    }

    $Talonario = new Talonario();

    if ($result)
    {
    $row = mysqli_fetch_assoc($result);
    $Talonario = new Talonario($row["id_establecimiento"], $row['id_talonario'],$row['numero_talonario'], $row['min_cupon'], $row['max_cupon'],$row['observaciones']);
    }
    return $Talonario;
    
}

function UpdateObservaciones($inIdEstablecimiento,$inIdTalonario,$inObservaciones)
{
    global $link;
   
    $sql = " UPDATE  ps_talonarios set observaciones = '".$inObservaciones."'";
    $sql = $sql. " WHERE id_establecimiento = ".$inIdEstablecimiento." and id_talonario = ".$inIdTalonario;

    $result=mysqli_query($link,$sql);
    
    if ($result) return 'OK';      
}

function UpdateTalonario($inIdEstablecimiento, $inIdTalonario,$inNumero, $inMinCupon, $inMaxCupon)
{
    global $link;
   
    $sql = " UPDATE  ps_talonarios set numero = ".$inNumero;
    $sql = $sql. " WHERE id_establecimiento = ".$inIdEstablecimiento." and id_talonario = ".$inIdTalonario;

    $result=mysqli_query($link,$sql);
    
    if ($result) return 'OK';      
       
 /*
    //min_cupon_real y max_cupon_real son los números mínimo y máximo de cupón (para el talonario) que hay en la B.D.    
    $sql = " SELECT max(numero) max_cupon_real,min(numero) min_cupon_real FROM ps_cupones where id_establecimiento=".$inIdEstablecimiento." and id_talonario=".$inIdTalonario;
    $result=mysql_query($sql);
    $r = mysql_fetch_assoc($result);
    $min_cupon_real = $r['min_cupon_real'];
    $max_cupon_real = $r['max_cupon_real'];

    //Realizamos un recorrido por todos los cupones de ps_talonarios, entre los valores mínimo y máximo entrados en el formulario.
    
    //Recorrido de los cupones marcados en el formulario que sean mayores que el último cupón de este talonario en la B.D.
    $nCupon = $inMinCupon;

    While ($nCupon<$min_cupon_real)                         
    {           
        //Comprobamos si el cupón existe para el siguiente formulario, en cuyo caso tan sólo lo cambiaremos de talonario.
        $sql = " select numero from ps_cupones where id_establecimiento = ".$inIdEstablecimiento." and id_talonario = ".($inIdTalonario-1)." and numero = ".$nCupon;
        
        $result= mysql_query($sql) or die('error');
        
        $r = mysql_fetch_assoc($result);
         
        $NewId = $r['numero']; 
        if ($NewId!="") 
        {
            $sql = " UPDATE ps_cupones SET id_talonario = ".$inIdTalonario." WHERE = id_establecimiento=".$inIdEstablecimiento." and id_talonario = ".($inIdTalonario-1)." and numero = ".$nCupon;
            $result= mysql_query($sql) or die('error');
        }
        else 
        {
            $sql = " INSERT INTO ps_cupones (id_establecimiento, numero,id_talonario,usado) ";
            $sql = $sql. " values (".$inIdEstablecimiento.",".$nCupon.",".$inIdTalonario.",0)";
            
            $result = mysql_query($sql) or die('error');
        }
    $nCupon+=1;
    }

    //Recorrido de todos los cupones de este talonario que hay en la B.D.
    $nCupon = $min_cupon_real;
    While($nCupon<=$max_cupon_real)
    {
    //Si un cupón de la b.d, está por encima del nuevo máximo establecido, lo reubicaremos al talonario siguiente    
    if ($nCupon>$InMaxCupon)
    {
        
    $sql = " UPDATE ps_talonarios SET id_talonario = ".$inIdTalonario+1;    
    $result=mysql_query($sql);
    }
    //Si un cupón de la b.d, está por debajo del nuevo mínimo establecido, lo reubicaremos al talonario anterior
    if ($nCupon<$InMinCupon)
    {
    $sql = " UPDATE ps_talonarios SET id_talonario = ".$inIdTalonario-1;    
    $result=mysql_query($sql);
    }
    $nCupon+=1;
    }
   
    //Recorrido de los cupones marcados en el formulario que sean mayores que el último cupón de este talonario en la B.D.
    $nCupon = $max_cupon_real;
  
    While ($nCupon<$inMaxCupon)                         
    {           
        //Comprobamos si el cupón existe para el siguiente formulario, en cuyo caso tan sólo lo cambiaremos de talonario.
        $sql = " select numero from ps_cupones where id_establecimiento = ".$inIdEstablecimiento." and id_talonario = ".($inIdTalonario+1)." and numero = ".$nCupon;
        $result= mysql_query($sql) or die('error');
       
        $r = mysql_fetch_assoc($result);
         
        $NewId = $r['numero'];
        if ($NewId!="") 
        {
            $sql = " UPDATE ps_cupones SET id_talonario = ".$inIdTalonario." WHERE = id_establecimiento=".$inIdEstablecimiento." and id_talonario = ".($inIdTalonario+1)." and numero = ".$nCupon;
            $result= mysql_query($sql) or die('error');
        }
        else 
        {
            $sql = " INSERT INTO ps_cupones (id_establecimiento, numero,id_talonario,usado) ";
            $sql = $sql. " values (".$inIdEstablecimiento.",".$nCupon.",".$inIdTalonario.",0)";
            $result = mysql_query($sql) or die('error');
        }
    $nCupon+=1;
    }
*/
 }


function InsertTalonario($inIdEstablecimiento,$inNumero, $inMinCupon, $inMaxCupon)
{
    global $link;
 
 
    $sql = " select (max(id_talonario)+1) maxid from ps_talonarios where id_establecimiento = ".$inIdEstablecimiento;
    $result= mysqli_query($link,$sql) or die('error');;
   
    $r = mysqli_fetch_assoc($result);
     
    $NewId = $r['maxid'];
    if ($NewId=="") $NewId = 1;
   
    $sql = " INSERT INTO ps_talonarios (id_talonario,id_establecimiento, numero) ";
    $sql = $sql. " values (".$NewId.",".$inIdEstablecimiento.",".$inNumero.")";
  
    $result=mysqli_query($link,$sql) or die('error');;
    
    $nCupon = $inMinCupon;
    
    While($nCupon<=$inMaxCupon)
    {
    $sql = " INSERT INTO ps_cupones (id_talonario,id_establecimiento, numero,usado,vendido) ";
    $sql = $sql. " values (".$NewId.",".$inIdEstablecimiento.",".$nCupon.",0,0)";
    $result=mysqli_query($link,$sql) or die('error');;
    $nCupon+=1;
    }
    
    return 'OK';      
       
}   


function DeleteTalonario($inIdEstablecimiento,$inIdTalonario)
{
    global $link;
 
    
    $sql = " delete from ps_talonarios where id_establecimiento = ".$inIdEstablecimiento." and id_talonario = ".$inIdTalonario;
    $result= mysqli_query($link,$sql);
    if (!$result) return 'error';
    else 
        {
        $sql = " delete from ps_cupones where id_establecimiento = ".$inIdEstablecimiento." and id_talonario = ".$inIdTalonario;
        $result= mysqli_query($link,$sql);
        if (!$result) return 'error';
        }
    return 'OK';      
       
}   


function CuponesSolapados ($inMinRango,$inMaxRango)
{
    global $link;
 
    $sql = " select * from ps_cupones where numero in (".$inMinRango.",".$inMaxRango.")";
//return $sql;
    $result= mysqli_query($link,$sql) or die('error');
   
    if (mysqli_num_rows($result)!=0) return 'SOLAPADOS';       

    return 'OK';      
}   


/*
function DeleteEstablecimiento($inId)
{
          
    global $connection;
   
   
    $sql = " delete  from cm_establecimientos where id_establecimiento = '".$inId."'";
    $result=mysql_query($sql);
           
    if($result) return true;
    
    else return false;      
}

*/
?>


