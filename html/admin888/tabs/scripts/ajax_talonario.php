<?php
//mts 05052012. Fichero ajax para la inserción y modificación de talonarios.

include dirname(__FILE__).'/settings.php'; 
include dirname(__FILE__).'/funciones_talonario.php'; 

$t_id_establecimiento=$_GET['id_establecimiento'];
$t_id_talonario=$_GET['id_talonario'];
$t_numero = $_GET['numero'];
$t_min_rango = $_GET['min_rango'];
$t_max_rango = $_GET['max_rango'];
$t_observaciones = $_GET['observaciones'];

//die($t_id_establecimiento.'-'.$t_id_talonario.'-'.$t_numero.'-'.$t_min_rango.'-'.$t_max_rango);
//mts, validación de contraseña al tratar de borrar un talonario. 
if (isset($_GET['password'])) 
{
    if ($_GET['password']==_PASSWD_DELETE_)
        {
        if ($_GET['operacion']=='delete')    
            $r=DeleteTalonario($t_id_establecimiento,$t_id_talonario);
        }
    else $r='error_password'; 
        
}

else
{


 if ($_GET['operacion']=='update_observaciones')
   {
   $r=UpdateObservaciones($t_id_establecimiento,$t_id_talonario,$t_observaciones);
   }
    
 //alta y modificación de talonarios.
 else if ($t_id_talonario=='null') 
   {
    $cs = CuponesSolapados($t_min_rango,$t_max_rango);
 
    if ($cs!='SOLAPADOS')   
        $r=InsertTalonario($t_id_establecimiento,$t_numero, $t_min_rango, $t_max_rango);
    else die($cs);
   }
 else $r=UpdateTalonario($t_id_establecimiento, $t_id_talonario,$t_numero, $t_min_rango, $t_max_rango);
}

echo $r;

?>