<?php 
function request($c)
   {
       if (isset($_REQUEST[$c]))   
        return mysql_real_escape_string(strip_tags($_REQUEST[$c]));
       else if (isset($_GET[$c]))
        return mysql_real_escape_string(strip_tags($_GET[$c]));
       else 
        return mysql_real_escape_string(strip_tags($_POST[$c]));
       
   }  
   

function request_with_tags($c)
   {
       if (isset($_REQUEST[$c]))
       {   
       $save_c = $_REQUEST[$c];
       $c_without_tags = strip_tags($_REQUEST[$c]);
       }
       else if (isset($_GET[$c]))
       {
       $save_c = $_GET[$c];
       $c_without_tags = strip_tags($_GET[$c]);
       }
       else
       {
       $save_c = $_POST[$c];
       $c_without_tags = strip_tags($_POST[$c]);
       }
        
       $save_c = str_replace("<ul>\n<ul>","<ul>",$save_c); 
       $save_c = str_replace("</ul>\n</ul>","</ul>",$save_c); 
       $save_c = utf8_encode(html_entity_decode($save_c));
       $save_c = addslashes($save_c);
       $save_c = mysql_real_escape_string($save_c);
       if ($save_c=='') $save_c=' '; 
       return ($save_c);
   }  



/*function get($c)
   {   
       return mysql_real_escape_string(strip_tags($_POST[$c]));
   }  
   

function get_with_tags($c)
   {
       $save_c = $_GET[$c];
       $c_without_tags = strip_tags($_GET[$c]);
       $c_without_tags_escaped = mysql_real_escape_string($c_without_tags);
       $save_c = str_replace($c_without_tags,$c_without_tags_escaped,$save_c);       
       return ($save_c);
   }  

*/
function field_to_save($c,$cond=null)
{
       $save_c = $c;
       $save_c = str_replace("<ul>\n<ul>","<ul>",$save_c); 
       $save_c = str_replace("</ul>\n</ul>","</ul>",$save_c); 
       
       //la condición no_decode_html indica que no es un campo de texto el que se va a guardar a la b.d (tinymce),
       //sino un campo de b.d (por lo tanto sólo tendremos que formatear )
       if ($cond!='no_decode_html') 
       {
       $save_c = html_entity_decode($save_c); 
       } 
       $save_c = utf8_encode($save_c);
       if ($cond!='no_decode_html')
       {
        $save_c = addslashes($save_c);
        $save_c = mysql_real_escape_string($save_c); 
       }
       return ($save_c);
}

function field_to_read($c)
{
       $save_c = $c; 
       $save_c = htmlentities(utf8_decode($save_c));
       $save_c = str_replace(array('&lt;','&gt;'),array('<','>'), $save_c);
       $save_c = str_replace(array('&amp;lt;','&amp;gt'),array('&lt;','&gt;'), $save_c);    
       $save_c = stripslashes($save_c);
       return ($save_c);
}


function substr_without_tags($c,$ini,$len,$rest_string)
{
       $save_c = $c;
       $c_without_tags = strip_tags($c);
       $save_c = substr($c_without_tags,$ini,$len);
       
       if (strlen($c_without_tags)>strlen($save_c)) $save_c=$save_c.$rest_string;
       $save_c = stripslashes($save_c);
       return ($save_c);
    
}

?>