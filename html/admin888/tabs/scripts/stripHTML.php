<?php
$cadena = $_POST['cadena'];
$cadena = eregi_replace("<strong[^>]*>","<strong>",$cadena);

/*$cadenas = explode("\n",$cadena);
$cadena2= '';
foreach ($cadenas as $c)
{
$cadena2.=$c.'|';
}
*/

if ($_POST['all']==1)
    $cadena=utf8_encode(html_entity_decode(strip_tags($cadena)));
else
{
//$cadena=$cadena2;
$cadena=utf8_encode(html_entity_decode(strip_tags($cadena,'<ul><li><ol><strong><em><br>')));    
}
die($cadena);
?>