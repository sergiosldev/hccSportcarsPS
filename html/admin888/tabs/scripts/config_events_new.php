<?php
include_once(dirname(__FILE__).'/../../../config/settings.inc.php');


$bd=_DB_NAME_;
$host=_DB_SERVER_;
$user=_DB_USER_;
$password=_DB_PASSWD_;
 
/*
 * link a bd
*/
include_once(dirname(__FILE__).'/../../../config/defines.inc.php');
$link = mysqli_connect($host, $user,$password,$bd);
if (!$link) {
    die('Could not connect: ' . mysql_error());
}
 
//mysql_select_db($bd);   
define('MAX_PERSONES',1);

$persones=1;

if(isset($_REQUEST['tipus'])) 
{
  if( $_REQUEST['tipus']=='ferrari_porsche901' || $_REQUEST['tipus']=='lamborghini_lotus' 
  || $_REQUEST['tipus']=='ferrari' || $_REQUEST['tipus']=='lamborghini' || $_REQUEST['tipus']=='_corvette_'
  || $_REQUEST['tipus']=='_bferrari_' || $_REQUEST['tipus']=='_blamborghini_'  || $_REQUEST['tipus']=='_bporsche_' || $_REQUEST['tipus']=='_bcorvette_' || $_REQUEST['tipus']=='formula') 
  {
    $persones=2;
  } 
  else if  ($_REQUEST['tipus']=='_buggy_') 
 {
    $persones=2; 
	//$persones=3;
  }
}

/*if(isset($_REQUEST['tipus'])) 
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
*/
//define('TIPUS_EVENTS',4);

$front=false;
$base_tabs=_BASE_URL_.'admin888/tabs';
$base_scripts='tabs/scripts/';
$base_scripts=_BASE_URL_.'admin888/'.$base_scripts;
$base_scripts_ca='tabs/scripts/cupones_alfa_online/';
define('URL_ROOT','tabs/');



?>