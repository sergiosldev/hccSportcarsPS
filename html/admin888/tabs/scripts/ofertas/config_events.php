<?php
include_once(dirname(__FILE__).'/../../../../config/settings.inc.php');


$bd=_DB_NAME_;
$host=_DB_SERVER_;
$user=_DB_USER_;
$password=_DB_PASSWD_;

/*
 * link a bd
*/

$link = mysqli_connect($host, $user,$password,$bd);
if (!$link) {
    die('Could not connect: ' . mysql_error());
}

define('MAX_PERSONES',1);

$persones=1;

if(isset($_REQUEST['tipus'])){
	
  if( $_REQUEST['tipus']=='ferrari_porsche901'
   || $_REQUEST['tipus']=='lamborghini_lotus' || $_REQUEST['tipus']=='ferrari' || $_REQUEST['tipus']=='lamborghini' 
   || $_REQUEST['tipus']=='porsche997_porsche996' )
  $persones=2;
 	
}
//define('TIPUS_EVENTS',4);


$front=false;
$base_scripts='tabs/scripts/ofertas/';
define('URL_ROOT','tabs/');



?>