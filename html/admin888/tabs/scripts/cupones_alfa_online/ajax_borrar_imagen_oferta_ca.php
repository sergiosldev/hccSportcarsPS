<?php

include_once dirname(__FILE__).'/../settings.php'; 
//include_once(dirname(__FILE__).'/../../../config/config.inc.php');
define('_PS_MAGIC_QUOTES_GPC_',         get_magic_quotes_gpc());
define('_PS_MYSQL_REAL_ESCAPE_STRING_', function_exists('mysql_real_escape_string'));

//include_once(dirname(__FILE__).'/../../../../classes/ImagenOfertaCA.php');
//include_once(dirname(__FILE__).'/../../../../classes/FuncionesOfertas.php');
include_once(dirname(__FILE__).'/funciones_ofertas_ca.php');
include_once(dirname(__FILE__).'/../trazas.php');

$id_imagen = $_GET['id_imagen'];
$id_oferta = $_GET['id_oferta'];
$imagen = new ImagenOfertaCA($id_imagen,3,$id_oferta);  
//var_dump($imagen);die;                
//$imagen->id_oferta = $_GET['id_oferta'];
//mts, validación de contraseña al tratar de borrar una oferta.
//traza('imagen.txt','idimagen: '.$id_imagen.'imagen->id: '.$imagen->id);
/*if (isset($_GET['password'])) 
{
    if ($_GET['password']==_PASSWD_DELETE_)
        {*/
        if ($imagen->delete()) 
        {
        FuncionesOfertas::deleteImagen($imagen->id_oferta,$imagen->id,'oferta','cupones_alfa_online');
        UpdateOfertaCA($imagen->id_oferta);
        }
        $r='OK';
        /*}
		
    else $r='error_password'; 
}
*/
echo $r;

?>