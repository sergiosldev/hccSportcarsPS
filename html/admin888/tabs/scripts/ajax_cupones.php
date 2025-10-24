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
    if ($_GET['password']==_PASSWD_DELETE_ and !in_array($_GET['usado'],array(5,7,9)))
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
            
        }
        
    }
    else if ($_GET['password']==_PASSWD_DELETE_FACTURADOS_)
    {
                      //Caso de quitar la marca de facturado, cobrado o comercial a un cupón.    
                switch($_GET['usado'])
                { 
                case 5:case 7:case 9:
                   $r = UpdateCupon($c_id_establecimiento, $c_id_talonario,$c_numero_cupon,$_GET['usado']);
                    break;
                }
    }
    else $r="error_password";
            
}
//Si hemos marcado un cupón como facturado, cobrado o comercial.
else if ($_GET['usado'] == 4 or $_GET['usado'] == 6 or $_GET['usado'] == 8)
{
    $r = UpdateCupon($c_id_establecimiento,$c_id_talonario,$c_numero_cupon,$_GET['usado']);

}

//si el cupón no esta usado, no habremos tenido que introducir la contraseña y por lo tanto 
//simplemente modificaremos su estado o las observaciones.  
else  { 
    $r = UpdateCupon($c_id_establecimiento, $c_id_talonario,$c_numero_cupon,$c_usado);
}
echo $r;

?>

