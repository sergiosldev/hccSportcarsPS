<?php
$url=_BASE_URL_.'/admin888/tabs/scripts/graella.php?data=2011-04-16&tipus=porsche996';
							
$source= @file_get_contents($url)or die('se ha producido un error');
echo substr($source,strlen($source)-2);
?>