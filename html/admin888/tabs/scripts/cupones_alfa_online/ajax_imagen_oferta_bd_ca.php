<?php 
include_once('../config_events.php');
include_once '../functions.php';
include_once dirname(__FILE__).'/funciones_ofertas_ca.php';      
include_once(PS_ADMIN_DIR.'/../classes/ImagenOfertaCA.php');
include_once(PS_ADMIN_DIR.'/../classes/FuncionesOfertas.php');
//include_once(PS_ADMIN_DIR.'/tabs/scripts/trazas.php');

$error = "";$nombre_imagen="";
$id_imagen=$_POST['id_imagen_ca'];   
$id_oferta=$_POST['idoferta_im_ca']; 
$imagen = new ImagenOfertaCA($id_imagen,3,$id_oferta);                         

//echo('idofertaim '.$_POST['idoferta_im']);
/*$error_carga_fichero=(substr($_FILES['imagen_oferta']['type'],0,5)!='image')?100:$_FILES['imagen_oferta']['error'];

if ($error_carga_fichero)    
{
 switch($error_carga_fichero)
 {
     case 1: $error = "Error: Ha excedido el tamaño máximo permitido para una imagen";break;     
     case 100: $error = "Error: El archivo debe ser de uno de los tipos de imagen especificados";break;
     default: $error = "Error";
 }   
}
else*/ 

if ($_POST['idoferta_im_ca']=='') 
    $error = "Error: Debe guardar antes los datos de la oferta";
else if (!in_array($_POST['edicion_imagen_ca'],array('edicio','reposicionar')) and (!isset($_FILES['imagen_oferta_ca']['tmp_name']) or $_FILES['imagen_oferta_ca']['tmp_name'] == NULL)) 
    {
    $error = "Error: Debe introducir el archivo";
    }
else if ($_POST['edicion_imagen_ca']=='reposicionar')
{
    $direccion = $_POST['direccion_ca'];
    //$imagen->posicion = $_POST['posicion'];
    //var_dump($imagen);
    $imagen->positionImage($imagen->posicion, $direccion); 
    $r=UpdateOfertaCA($id_oferta); 
    $error="";
}
else 
{    
    
    $imagen->portada = $_POST['portada_valor_ca'];    
    $imagen->titulo = $_POST['titulo_im_ca'];
    $imagen->posicion = $_POST['posicion_ca'];
    $imagen->id = $id_imagen;
    $imagen->id_oferta = $_POST['idoferta_im_ca'];
    //traza('reposicionar.txt',$_POST['portada_ca']);
    $imagen->id_lang=3;
    
    if ($id_imagen == 0) //caso Alta.
    {
    $imagen->posicion = $imagen->getHighestPosition($imagen->id_oferta) + 1;
    
    }
    if ($imagen->portada == 1)
        {
        $ret=$imagen->deletePortada($imagen->id_oferta);
        }
        
   // traza('crear_imagen.txt','portada '.$imagen->portada.'   imagenes: '.sizeof($imagen->getImages(3,$imagen->id_oferta)));    
    $imagen->portada = !$imagen->portada ? !sizeof($imagen->getImages(3,$imagen->id_oferta)) : true;
    if($_POST['edicion_imagen_ca']=='borrar')
    {
        $imagen->delete();    
    }
    else 
    {
        //echo('akir');var_dump($imagen);die;
        $ret=GuardarImagenOfertaCA($imagen->id_oferta,$imagen->id);
        
        //Si al grabar los datos de la imagen se detectan errores en la validación de los campos.
        if ($imagen->error) 
            $error = $imagen->error;
    }
    $r=UpdateOfertaCA($id_oferta); 

}
//echo('<script>parent.tester();</script>');
echo('<script>parent.resultadoUploadCA("'.$error.'","'._PS_IMG_DIR_.'od/'.$image->id_oferta.'-'.$image->id.'.jpg'.'");</script>');  


function GuardarImagenOfertaCA($id_oferta,$id_imagen_oferta)
{
    global $imagen;
    global $error;
    global $imagen;
    //echo(_PS_TMP_IMG_DIR_.'oferta_'.$id_oferta.'.jpg');
    
    $imagen->archivo = (isset($_FILES['imagen_oferta']['tmp_name']) AND $_FILES['imagen_oferta']['tmp_name'] != NULL)?$_FILES['imagen_oferta']['tmp_name']:'';
    
    //traza('reposicionar.txt',$imagen->tabla);
    //$error = $imagen->tabla;die;
    if (!$imagen->guardar()) 
        { $error = 'Se ha producido un error al guardar la imagen';return false;} 
    else/*if (isset($_FILES['imagen_oferta']['tmp_name']) AND $_FILES['imagen_oferta']['tmp_name'] != NULL)*/
    {    
        $error = FuncionesOfertas::copyImage($id_oferta, $imagen->id, 'auto','cupones_alfa_online');
        return false;
    }

    if (isset($imagen) AND FuncionesOfertas::isLoadedObject($imagen) AND !file_exists(_PS_IMG_DIR_.'od/'.$id_oferta.'-'.$imagen->id.'.jpg'))
        $imagen->delete();

    @unlink(dirname(__FILE__).'/../../img/tmpd/oferta_'.$id_oferta.'.jpg');
    @unlink(dirname(__FILE__).'/../../img/tmpd/oferta_mini_'.$id_oferta.'.jpg');
    $imagen->archivo = _PS_IMG_DIR_.'od/'.$id_oferta.'-'.$imagen->id.'.jpg';
    return ((isset($imagen->id) AND is_int($imagen->id) AND $imagen->id) ? $imagen->id : true);
}

?>



