<?php 
$nlineas = 0;

if (isset($_POST['destacados']) or isset($_POST['condiciones2']) or isset($_POST['descripcion_cupones2']))
{
    if (isset($_POST['destacados'])) 
    {
     $lineasa = explode("\n",strip_tags($_POST['destacados']));  
     $nlineas_destacados = count($lineasa); 
     //$lineas=str_replace('\n','**',$_POST['texto_inicio']);
    }
    
    if (isset($_POST['condiciones2']))
    {
     $lineasa = explode("\n",strip_tags($_POST['condiciones2']));  
     $nlineas_condiciones = count($lineasa); 
     //$lineas=str_replace('\n','**',$_POST['texto_inicio']);
    }
    
    if (isset($_POST['descripcion_cupones2']))
    {
     $lineasa = explode("\n",strip_tags($_POST['descripcion_cupones2']));  
     $nlineas_descripcion = count($lineasa); 
     //$lineas=str_replace('\n','**',$_POST['texto_inicio']);
    }
     $nlineas_destacados = 1;
     $nlineas_condiciones = 1;
     $nlineas_descripcion = 1;
     //strip_tags($_POST['descripcion_cupones2'])
    echo("<script> window.parent.guardar_datos_oferta(".$nlineas_destacados.",".$nlineas_condiciones.",".$nlineas_descripcion.");</script>"); 
}
?>
