<?php
//mts 05052012. Fichero ajax para la inserción y modificación de cupones.
include dirname(__FILE__).'/settings.php'; 
include dirname(__FILE__).'/funciones_cupon.php'; 

$c_id_establecimiento=$_GET['id_establecimiento'];
$c_id_talonario=$_GET['id_talonario'];
$c_numero_cupon=$_GET['numero_cupon'];
$c_vendido=$_GET['vendido'];
$c_usado=($_GET['usado']==0)?1:0; 

if (isset($_GET['observaciones']))
{ 
    $c_observaciones = $_GET['observaciones'];

    $r = UpdateCuponObservaciones($c_id_establecimiento, $c_id_talonario,$c_numero_cupon,$c_observaciones);
    echo $r;
    return;
} 


if (isset($_GET['password']))
{
    if ($_GET['password']==_PASSWD_DELETE_)
    {
        switch($_GET['usado'])
        {
            case 1:
                //validación de contraseña al tratar de desbloquear un cupón. 
                $r = UpdateCupon($c_id_establecimiento, $c_id_talonario,$c_numero_cupon,$c_usado);
                break;
                //validación de contraseña al tratar de cambiar el estado de un cupón a disponible. 
            case 2:
                if($_GET['vendido']==1)
                {
                $r = UpdateCupon($c_id_establecimiento, $c_id_talonario,$c_numero_cupon,0); 
                if ($r=='OK')
                    {
                    $r = UpdateCuponVendido($c_id_establecimiento, $c_id_talonario,$c_numero_cupon,0);
                    }
                }
                break;
            case 3:
              //validación de contraseña al tratar de cancelar un cupón. 
               $r = UpdateCupon($c_id_establecimiento, $c_id_talonario,$c_numero_cupon,3);
                break;
              //Caso de quitar la marca de facturado a un cupón.    
            case 5:
               $r = UpdateCupon($c_id_establecimiento, $c_id_talonario,$c_numero_cupon,5);
                break;
        }
        
    }
    else $r="error_password";
            
}
//Si hemos marcado un cupón como facturado.
else if ($_GET['usado'] == 4)
{
    $r = UpdateCupon($c_id_establecimiento,$c_id_talonario,$c_numero_cupon,4);

}

//si el cupón no esta usado, no habremos tenido que introducir la contraseña y por lo tanto 
//simplemente modificaremos su estado o las observaciones.  
else  { 
    $r = UpdateCupon($c_id_establecimiento, $c_id_talonario,$c_numero_cupon,$c_usado);
}
echo $r;

?>

