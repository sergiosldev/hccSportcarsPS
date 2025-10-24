<?php
include_once (dirname(__FILE__).'/../../../config/settings.inc.php');

/*
$bd='motorclubexperie';
$user='root';
$host='localhost';
$password='';
*/

$bd=_DB_NAME_;
$user=_DB_USER_;
$host=_DB_SERVER_;
$password=_DB_PASSWD_;

/*
 * link a bd
*/

$link = mysql_connect($host, $user,$password);
if (!$link) {
    die('Could not connect: ' . mysql_error());
}
mysql_select_db($bd);
define('MAX_PERSONES',1);

$persones=1;

if(isset($_REQUEST['tipus'])) 
{
  if( $_REQUEST['tipus']=='ferrari_porsche901' || $_REQUEST['tipus']=='lamborghini_lotus' 
  || $_REQUEST['tipus']=='ferrari' || $_REQUEST['tipus']=='lamborghini' 
  || $_REQUEST['tipus']=='_bferrari_' || $_REQUEST['tipus']=='_blamborghini_'  || $_REQUEST['tipus']=='_bporsche_') 
  {
    $persones=2;
  } 
  else if  ($_REQUEST['tipus']=='_buggy_') 
 {
    $persones=2; 
	//$persones=3;
  }
}
//define('TIPUS_EVENTS',4);

$front=false;
$base_scripts='tabs/scripts/';
define('URL_ROOT','tabs/');



?>