<?php
include_once(dirname(__FILE__).'/settings.php'); 
include_once(dirname(__FILE__).'/../../../config/config.inc.php');
define('_PS_MAGIC_QUOTES_GPC_',         get_magic_quotes_gpc());
define('_PS_MYSQL_REAL_ESCAPE_STRING_', function_exists('mysql_real_escape_string')); 

//include_once(dirname(__FILE__).'/../../../classes/ImagenOferta.php');
//include_once(dirname(__FILE__).'/../../../classes/FuncionesOfertas.php');
include_once(dirname(__FILE__).'/funciones_ofertas.php');

$id_imagen = $_GET['id_imagen'];
$id_oferta = $_GET['id_oferta'];

$imagen = new ImagenOferta($id_imagen,3,$id_oferta);                      

//mts, validación de contraseña al tratar de borrar una oferta.
/*if (isset($_GET['password'])) 
{
    if ($_GET['password']==_PASSWD_DELETE_)
        {*/
        if ($imagen->delete()) 
        {
			//if (tools::getuserip()=='83.49.151.235') {var_dump($imagen);die;}
			FuncionesOfertas::deleteImagen($imagen->id_oferta,$imagen->id); 
			UpdateOferta($imagen->id_oferta);
        }
        $r='OK';
        /*}
    else $r='error_password'; 
}
*/
echo $r;

?>