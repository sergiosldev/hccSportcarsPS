<?php 

include('config_events.php');
include dirname(__FILE__).'/funciones_ofertas.php'; 
include_once(PS_ADMIN_DIR.'/../classes/ImagenOferta.php');
include_once(PS_ADMIN_DIR.'/../classes/FuncionesOfertas.php');
    
$error = "";$nombre_imagen="";
$id_imagen=$_POST['id_imagen'];
$id_oferta=$_POST['idoferta_im'];
$imagen = new ImagenOferta($id_imagen,3,$id_oferta);                    

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
else*/ if ($_POST['idoferta_im']=='') 
    $error = "Error: Debe guardar antes los datos de la oferta";
else if (!in_array($_POST['edicion_imagen'],array('edicio','reposicionar')) and (!isset($_FILES['imagen_oferta']['tmp_name']) or $_FILES['imagen_oferta']['tmp_name'] == NULL)) 
    {
    $error = "Error: Debe introducir el archivo";
    }
else if ($_POST['edicion_imagen']=='reposicionar')
{
    $direccion = $_POST['direccion'];
    //$imagen->posicion = $_POST['posicion'];
    //var_dump($imagen);
    $imagen->positionImage($imagen->posicion, $direccion); 
    $r=UpdateOferta($id_oferta); 
    $error="";
}
else 
{
    $imagen->portada = $_POST['portada'];    
    $imagen->titulo = $_POST['titulo_im'];
    $imagen->posicion = $_POST['posicion'];
    $imagen->id = $id_imagen;
    $imagen->id_oferta = $_POST['idoferta_im'];
    
    
    
    $imagen->id_lang=3;
    
    if ($id_imagen == 0) //caso Alta.
    {
    $imagen->posicion = $imagen->getHighestPosition($imagen->id_oferta) + 1;
    
    }
    if ($imagen->portada == 1)
        {
        $ret=$imagen->deletePortada($imagen->id_oferta);
        }
    $imagen->portada = !$imagen->portada ? !sizeof($imagen->getImages(3,$imagen->id_oferta)) : true;
    if($_POST['edicion_imagen']=='borrar')
    {
        $imagen->delete();    
    }
    else 
    {
        $ret=GuardarImagenOferta($imagen->id_oferta,$imagen->id);
        
        //Si al grabar los datos de la imagen se detectan errores en la validación de los campos.
        if ($imagen->error) 
            $error = $imagen->error;
    }
    $r=UpdateOferta($id_oferta); 

}
    
echo('<script>parent.resultadoUpload("'.$error.'","'._PS_IMG_DIR_.'o/'.$imagen->id_oferta.'-'.$imagen->id.'.jpg'.'");</script>');  


function GuardarImagenOferta($id_oferta,$id_imagen_oferta)
{
    global $imagen;
    global $error;
    global $imagen;
    //echo(_PS_TMP_IMG_DIR_.'oferta_'.$id_oferta.'.jpg');
    
    $imagen->archivo = (isset($_FILES['imagen_oferta']['tmp_name']) AND $_FILES['imagen_oferta']['tmp_name'] != NULL)?$_FILES['imagen_oferta']['tmp_name']:'';
    if (!$imagen->guardar()) 
        { $error = 'Se ha producido un error al guardar la imagen';return false;} 
    else/*if (isset($_FILES['imagen_oferta']['tmp_name']) AND $_FILES['imagen_oferta']['tmp_name'] != NULL)*/
    {   
        $error = FuncionesOfertas::copyImage($id_oferta, $imagen->id, 'auto');
        return false;
    }

    if (isset($imagen) AND FuncionesOfertas::isLoadedObject($imagen) AND !file_exists(_PS_IMG_DIR_.'o/'.$id_oferta.'-'.$imagen->id.'.jpg'))
        $imagen->delete();

    $imagen->archivo = _PS_IMG_DIR_.'o/'.$id_oferta.'-'.$imagen->id.'.jpg';
    return ((isset($imagen->id) AND is_int($imagen->id) AND $imagen->id) ? $imagen->id : true);
}



?>



