<?php 
$nlineas = 0;

if (isset($_POST['destacados2']) or isset($_POST['condiciones2']) or isset($_POST['descripcion_cupones2']))
{
    if (isset($_POST['destacados2'])) 
    {
     $lineasa = explode("\n",$_POST['destacados2']);  
     $nlineas_destacados = count($lineasa); 
     //$lineas=str_replace('\n','**',$_POST['texto_inicio']);
    }
    
    if (isset($_POST['condiciones2']))
    {
     $lineasa = explode("\n",$_POST['condiciones2']);  
     $nlineas_condiciones = count($lineasa); 
     //$lineas=str_replace('\n','**',$_POST['texto_inicio']);
    }
    
    if (isset($_POST['descripcion_cupones2']))
    {
     $lineasa = explode("\n",$_POST['descripcion_cupones2']);  
     $nlineas_descripcion = count($lineasa); 
     //$lineas=str_replace('\n','**',$_POST['texto_inicio']);
    }
     
    echo("<script> window.parent.ActualizarNumLineas(".$nlineas_destacados.",".$nlineas_condiciones.",".$nlineas_descripcion.");</script>"); 
}
/*
if (isset($_POST['texto_inicio']))
{
 $lineasa = explode("\n",$_POST['texto_inicio']);  
 $nlineas = count($lineasa); 
 echo("<script> window.parent.ActualizarNumLineas(".$nlineas.");</script>"); 
 //$lineas=str_replace('\n','**',$_POST['texto_inicio']);
}
*/
 
 /*foreach($lineasa as $l)
 {
 echo("<script> alert('".$l."');</script>"); 
 }*/
?>
