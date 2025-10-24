<?php
/*
//$path = $_SERVER['DOCUMENT_ROOT'].'/cupones/';
//$ftp_server="178.139.56.19";
//$ftp_server="127.0.0.1";
$ftp_server="78.129.148.2";   
$ftp_user_name="www.dreamcarsexperience.com";
$ftp_user_pass="c762144e"; 
// define some variables
// set up basic connection
$conn_id = ftp_connect($ftp_server); 

// login with username and password
$login_result = ftp_login($conn_id, $ftp_user_name, $ftp_user_pass);  



$newdir = "/html/cupones";
$list_tmp = ftp_nlist($conn_id, $newdir);
$list = array();
foreach($list_tmp as $elem) {if (strpos($elem,"/.")===false) array_push($list,$elem);}
//var_dump($list);
$newdir = ftp_chdir($conn_id, "/html/cupones");
$directory = ftp_pwd($conn_id);
echo(' directorio actuala: '.$directory);
//$path = '/cupones';
//$dir=opendir($path);
//$dir = '/cupones/';
/*
$i=0;
   

foreach($list as $file)
//while ($file = readdir($dir))
{

if (//file != "." && $file != ".." && strpos($file,'/.')===false && $i==1)
{
    echo('file '.strrev(substr(strrev($file),0,strpos(strrev($file),'/')))  );
    //echo('file '.strrev(substring(strrev($file),0,strpos(strrev($file),'/'))));    
    $local_file = "testeando";    
    $remote_file = strrev(substr(strrev($file),0,strpos(strrev($file),'/'))) ;

    // try to download $server_file and save to $local_file
    if (ftp_get($conn_id, $local_file, $remote_file, FTP_BINARY)) { 
        echo "Successfully written to $local_file\n";
    } else {
        echo "There was a problem\n";
    }
    // close the connection
    ftp_close($conn_id);   
}
 $i=1;
}
//closedir($dir);  


 */ ?>



<?php
$path = $_SERVER['DOCUMENT_ROOT'].'/cupones/';
   
        //$path = '/cupones';
$dir=opendir($path);

//$dir = '/cupones/';
while ($file = readdir($dir))
{
if ($file != "." && $file != "..")
{
    $filename = $file;
     
    // Modify this line to indicate the location of the files you want people to be able to download
    // This path must not contain a trailing slash. ie. /temp/files/download
    //$download_path = "ficheros/";
     $download_path = $path;
    // Make sure we can't download files above the current directory location.
    if(eregi("\.\.", $filename)) die("I'm sorry, you may not download that file.");
    $file = str_replace("..", "", $filename);
     
    // Make sure we can't download .ht control files.
    if(eregi("\.ht.+", $filename)) die("I'm sorry, you may not download that file.");
     
    // Combine the download path and the filename to create the full path to the file.
    $file = "$download_path$file";
     
    // Test to ensure that the file exists.
    if(!file_exists($file)) die("I'm sorry, the file doesn't seem to exist.");
     
    // Extract the type of file which will be sent to the browser as a header
    $type = filetype($file);
     
    // Get a date and timestamp
    $today = date("F j, Y, g:i a");
    $time = time();
     
    // Send file headers
    header("Content-type: $type");
    header("Content-Disposition: attachment;filename=$filename");
    header("Content-Transfer-Encoding: binary");
    header('Pragma: no-cache');
    header('Expires: 0');
    // Send the file contents.
    set_time_limit(0);
    readfile($file);
}
}
closedir($dir);
?> 

