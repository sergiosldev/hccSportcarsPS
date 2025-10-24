<?php
include_once(dirname(__FILE__).'/../../../config/config.inc.php');                                    
             

if (tools::getValue('reposicionar')!='') 
{
    $direccion = tools::getValue('direccion');
    $posicion = tools::getValue('posicion'); //$_GET['posicion'];
    $svideo = new Video(tools::getValue('id_video'));
	$svideo->id=intval(tools::getValue('id_video'));
    $r=$svideo->ordenVideo($posicion, $direccion); 
    $svideo->CompactarOrden();
	$videos=$svideo->getVideos();
	$htmlvideos=$svideo->htmlVideos($videos);
    die($htmlvideos); 
	
}

if (tools::getValue('nuevo')!='') 
{
    $svideo = new Video();     
	$svideo->link=tools::getValue('link_video');           
	$svideo->titulo=tools::getValue('titulo');           
    $r=$svideo->Add();   

    $svideo->CompactarOrden();	
	$videos=$svideo->getVideos();
	$htmlvideos=$svideo->htmlVideos($videos);
    die($htmlvideos); 
	
}

if (tools::getValue('borrar')!='') 
{
    $svideo = new Video();     
	$svideo->id=tools::getValue('id_video');           
    $r=$svideo->Delete();   
    $svideo->CompactarOrden();
	$videos=$svideo->getVideos();	
	$htmlvideos=$svideo->htmlVideos($videos);
    die($htmlvideos); 
	
}




?>