<?php                             
include_once(dirname(__FILE__).'/../../../config/config.inc.php');         
$sql = ' delete
		 from eventos_marcados ';

$re=Db::getInstance()->Execute($sql);

?>   
