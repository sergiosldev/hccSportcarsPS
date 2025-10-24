<?php  

  include_once(dirname(__FILE__).'/../../config/defines.inc.php');
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>---Galeria---</title>
 
 <link rel="stylesheet" type="text/css" href="../css/css_back.css" />

 <script type="text/javascript" src="../LB/js/jquery.js"></script>
 <script type="text/javascript" src="../LB/js/jquery.lightbox-0.5.js"></script>
 <link rel="stylesheet" type="text/css" href="../LB/css/jquery.lightbox-0.5.css" media="screen" />
 


<style type="text/css" media="all">
body {
	background-color:transparent; /* fondo transparente para los navegadores NORMALES */
	font-family:Arial, Helvetica, sans-serif; font-size:14px;
}

</style>
<!--[if gte IE 6]>
<style type="text/css">
    #capaPng {background-image:none; filter:progid:DXImageTransform.Microsoft.AlphaImageLoader (src='imagenes/huevo.png', sizingMethod='crop');}
</style>
<![endif]-->

<link href="../css/css_back.css" rel="stylesheet" rev="stylesheet" type="text/css">
</head>

<body id="cos_" >
	
<h3><?php echo $_REQUEST['taula'] ?></h3>	
	


<?php


$bd='motorclubexperie';
$user='motorclubexperie';
$host='localhost';
$password='7e1d54b4';


include './scripts/mysql.php';



$db= new _mysql($host,$user,$password,$bd,FALSE);



class Galeria 
   {
 
   private $taula_galeria='galeria_netne';
   private $id_registre=null;
   private $taula='documents'; // taula del registre que conte la galeria
   private $camp='galeria_pdf'; // nom del camp galeria
   private $idioma='idioma';
   private $path='uploads_media/';
   private $action='upload_clase.php';
   private $max_fitxers_galeria=10; // maxim nombre de fitxers a la galeria
   private $max_uploads;   // Comptador fitxers que resten per omplir galeria
   private $max_input_upload=5; // Maxim nombre de carregues alhora
   private $array_nous=null;
   private $db; // conexio a BD
   private $extensions=array('*');
   private $cad_ext='*';
   private $max_size=1024;
   private $form;
  // private $dades;
  // private $log=null;
   private $funcio_crea_element='funcio_crea_element';
   private $array_tasques=array(); // Array amb coses que s'han de fer per configurar correctament true false true....
   private $parametre1=true;
   private $parametre2=true;
function __construct($con,$form=true)
     { 
	 $this->db=$con;
	 $this->array_nous=array();
	 $this->info_processa=array();
	 $this->form=$form;
	 $this->max_uploads=$this->max_fitxers_galeria;
    
	 } 
function getDades()
     { 
	   return $this->dades;
	 } 	 
	 	   
function setTaulaGaleries($taula)
     { $this->taula_galeria=$taula;}
	 /*
	  * @param object $id
	  * Especifica el camp id_registre ,taula $camp  que fa referencia a la galeria 
	  */     
function setParamsLinkGaleria($id_registre,$camp,$taula,$idioma)
     { $this->id_registre=$id_registre;
	   $this->taula=$taula;
	   $this->camp=$camp;
	   $this->idioma=$idioma;
	 }
	 
 /*
	  * @param object $f
	  * Especifica la funcio que s'encarrega de mostrar els elements al llistat de la galeria
	  */  	 
	 
	  
function setFuncioCreaElement($f)
     { $this->funcio_crea_element=$f;
	 }
	    
function setPath($path)
     { $this->path=$path.$this->path;}   
   /*
	  * @param object $form
	  * Indica si es crea un formulari a part o la galeria esta inclosa dins un formulari
	  */  
function setForm($form)
     { $this->form=$form;} 
function Mida_maxima($max_size)
     { $this->max_size=$max_size; }   	   
                                  
 /*
	  * @param object $form
	  * Indica si es crea un formulari a part o la galeria esta inclosa dins un formulari
	  */  
function Extensions_Permeses($array_extensions)
     { 
	 $this->extensions=explode(',',$array_extensions);
	 $this->cad_ext=$array_extensions;
	 }   
/*
	  * @param object $form
	  * Indica el numero maxim de fitxers a la galeri
	  */  
function Maxim_Fitxers_Galeria($max)
     {  $this->max_uploads=$this->max_fitxers_galeria=$max; }   
      /*
	  * @param object $form
	  * Indica el maxim fitxers que es poden carregar alhora
	  */
function setMaxInputUpload($max)
     {  $this->max_input_upload=$max; }   
                    
private function extensio($nom)
  { 
  return substr(strrchr($nom, "."), 1); //$extensions[$image['type']];
  }	   

       
private function crea_nom_random_fitxer($nom)
{ 

 $ext = substr(strrchr($nom, "."), 1); //$extensions[$image['type']];
 echo $nom_aux=str_replace('.'.$ext,'',$nom);
 
// generem nou nom per al fitxer per evitar conflictes
 $nom =$nom_aux .'-'.md5(rand() * time())  .".$ext";
return $nom;
}	

private function obtenir_extensio($nom_fitxer)
    {
	$ext = substr($nom_fitxer, strrpos($nom_fitxer,".") + 1);
    return $ext;
	}
	
public function estan_definits_els_parametres($array_p)
  {
  $def=array();	
  $def[0]=1;
  foreach($array_p as $p)
    {
    eval('if(!$this->'.$p.'){$def[0]=0;$def[\''.$p.'\']=0;}');	
    }
  return $def;	
  }

		
function processa()
   {
		 $count = $_POST['count_'.$this->camp];
		 
         for($i = 1; $i < $count + 2; $i++){
		if(isset($_FILES["upload_".$this->camp.'_'.$i]) && $_FILES["upload_".$this->camp.'_'.$i]["name"] != "")
			{
            echo "<br>Estado del fichero cargado ::::..";
			
            $nom_arxiu=$fname=$this->crea_nom_random_fitxer($_FILES["upload_".$this->camp.'_'.$i]["name"]);
			$posicio=$_POST["pos_".$this->camp.'_'.$i];
			$descripcio=$_POST["desc_".$this->camp.'_'.$i];
			 
		    // Si l'extensio no es permesa no desis o si supera la mida maxima
	try{
            if(!in_array($this->obtenir_extensio($fname),$this->extensions)){
			 throw new Excepcio('Extensio incorrecte', -1); 
			}
			echo  ($_FILES["upload_".$this->camp.'_'.$i]['size']/1024).'';
			if( $_FILES["upload_".$this->camp.'_'.$i]['size']/1024>$this->max_size  ){
				
throw new Excepcio('Tamany_incorrecte '.($_FILES["upload_".$this->camp.'_'.$i]['size']/1024).'>'.$this->max_size, -2); 

}


			 
			$tname=$_FILES["upload_".$this->camp.'_'.$i]["tmp_name"];
	        if($fname=="")continue;
			
            if(move_uploaded_file($tname,$this->path."/".$fname))
	           {
	           if($this->log)
    			 {		
	             $this->log->newLogRegistre();	
	             $this->log->logMessage(':'.$fname.": ha estat carregat !!! ",'',Logger::INFO);
				 }
	         echo '<br/>:'.$fname.": ha estat carregat !!! "; 
				
				// S'ha de desar en matriu els arxius nous per si va alguna cosa malament esborrar-los
				$this->array_nous[]=$fname;
				$a_insert=array('id'=>NULL,'id_registre'=>$this->id_registre,'taula'=>$this->taula,"camp"=>$this->camp,"idioma"=>$this->idioma,'Nom'=>$nom_arxiu,'Posicio'=>$posicio,'descripcio'=>$descripcio);
				if(!$this->db->insert($a_insert,$this->taula_galeria))
				throw new Excepcio('Error insercio '.!$this->db->get_last_query(), -2); 

			   }
	           
	           	
	}catch(Excepcio $e)
	        {
	       echo '<br/>'.$e.' '; 	
	       if($this->log)
    	    {	
	         $this->log->newLogRegistre();
		     $this->log->logMessage($fname.": error de carrega !!! ",$e.':'.$fname.':'.$_FILES["upload_".$this->camp.'_'.$i]["name"],Logger::ERROR);	
		 	 }
			
	        }
		}
		
		// modifiquem posicions i descripcio   
		
		 $_where=array('id'=>$_POST['id_'.$i]);	 // Es pot fer per nom o id S'ha d'arreglar
		 // print_r($P_where);
		 $_valors=array('Descripcio'=>$_POST['textarea_'.$i],'Posicio'=>$_POST['posicio_'.$i]);
		 $this->db->update($_valors,$this->taula_galeria,$_where);
		
		
	}
	
	// Aqui esborrarem els marcats-------------------
   
	if($_POST['esborra_total']!='0') // Si s'ha marcat algun
	 {	
	
     $cont_esborra=intval($_POST['esborra_total']);
	 while($cont_esborra)
	    {
	   	
	    if(isset($_POST['esborra_'.$cont_esborra]))
		  {	
		  
	      
		  $P_where=array('Nom'=>$_POST['esborra_'.$cont_esborra]);	 // Es pot fer per nom o id S'ha d'arreglar
		 // print_r($P_where);
		  
		  $this->db->del($this->taula_galeria,$P_where);
		  unlink($this->path.$_POST['esborra_'.$cont_esborra]);
		   
		  }
		  $cont_esborra--;	
			
	    }
		
	 }

 crea_arxiu_xml($this->db);

 }// Fi processa

// echo fitxers_multiple($this->camp,5);

function printa_multiple_upload($f,$string=array('Ficheros','Borrar'))
   {
 
  $nom=$this->camp;
  if(!$this->id_registre){ echo 'No id Registre'; exit(0);}
  else $id_registre=$this->id_registre;
    $galeria='<div id="galeria">';
	
		 ?>
<script>		 
var array_checks=new Array();
	
var select=false;

function selecciona_tots_taula()
   { 
   
   if (select) {
   	desselecciona_tots_taula();
   	select = false;
   }
   else {
   	select = true;
   	for (i_ in array_checks) {
   		document.getElementById('esborra_' + i_).checked = 'checked';
   	   }
     }  
	}	
function desselecciona_tots_taula()
   { 
    for(i_ in array_checks)
	  {
	  document.getElementById('esborra_'+i_).checked='';
	  }  
	} 
		 
</script>	
		 
		 <?php
	 
	
   
   if($this->form)$galeria.='<form action="'.$this->action.'" method="POST" enctype="multipart/form-data" accept-charset="utf-8">
    <input type="hidden"  name="processa" value="1">
   ';
   else $galeria.='';
   
   $this->db->query('SELECT * from '.$this->taula_galeria.' WHERE id_registre="'.$this->id_registre.'" AND (taula="'.$this->taula.'") '); 

  
   $cont=0; 
   if($this->db->row_count()) // edicio
     {
	
	 $galeria.='
	 <input type="hidden"  id="fitxers_actuals" value="---">
	 <fieldset style="3px;border:1px solid #efefff; background-color:#fff">
     <legend style="font-weight:bold;font-size:15px;padding:3px;border:1px outset #eee; background-image:url(../images/toolbar/barra.png);background-repeat:repeat-x;">Galeria</legend>
	 <table width="80%"  cellspacing="0" cellpadding="2" >
	 <tr>
		<th  align="left" style="border-bottom:1px dashed #888;vertical-align: bottom;"  >
           '.$string[0].'<br>  
		</th>
		<th  align="left" style="border-bottom:1px dashed #888" > 
		</th>
		<th align="left" style="border-bottom:1px dashed #888" >
           '.$string[1].'<input  type="checkbox" name="sel_tot" value="" onclick="selecciona_tots_taula()" /><br>
		</th>
	 </tr>
	 <tr>
		<th  align="left"  >
        <br>
		</th>
	 </tr>
	 ';
	 
	
	while($r=$this->db->row())
	    {
	    
		$cont++;
        	 
		  $galeria.='
					 <tr >
					    <td   >'.
						$f($r,$this->path).'</td><td><b>Nombre:</b> '.$r->Nom.'
											<input type="hidden" value="'.$r->Nom.'" name="'.'nom_'.($cont).'" />
											<input type="hidden" value="'.$r->id.'" name="'.'id_'.($cont).'" />
											<br/><b>Descripcion:</b> <br/><textarea style="background:none;border:1px dashed #888" name="'.'textarea_'.($cont).'" cols="60" >'.$r->Descripcio.'</textarea>
											<br/><b>Posicion:</b> <br/><input type="text" style="background:none;border:1px dashed #888" name="'.'posicio_'.($cont).'" value="'.$r->Posicio.'" /> </td>';  
					    
						 $galeria.='<td>
                           <input  type="checkbox" name="'.'esborra_'.($cont).'" id="'.'esborra_'.($cont).'" value="'.$r->Nom.'" />
						   <script> array_checks["'.($cont).'"]="'.($cont).'"; </script>
						 </td>
                      </tr>';
		$this->max_uploads--; 
		
		}
		
		
		 $galeria.='<tr><td><input type="submit" style="background:none;background-color:#eef;font-size:14px;font-weight:bold"  value="Guarda" ></td></tr></table></fieldset><input  type="hidden" name="esborra_total" value="'.$cont.'" />';
		 
	
	 }
	 
if($this->max_uploads>0) // sempre hi entra-------------------
    {
    	
		
    $galeria.='
             <fieldset style=""  >
         <legend style="font-weight:bold;font-size:15px;padding:3px;border:1px outset #efefff;background-image:url(../images/toolbar/barra.png);background-repeat:repeat-x;">Upload</legend>
				
               <table  cellspacing="1" cellpadding="2" id="uploadtable_'.$nom.'">
                      <tr>
					    <td>
                          <input type="button" style="background:none;background-color:#eef;font-size:14px;font-weight:bold"  name="add" value="Mas ficheros ?"  onClick="javascript:addRow()">
						</td>
					  </tr>
					  <tr>	
                        <td>
                            <strong>
                            Fichero:<br/><input type="file" name="upload_'.$nom.'_1" class="ctrl">
						    
							Posicion:
							<select name="pos_'.$nom.'_1" ><option selected="selected" value="0">0</option><option value="1">1</option> <option value="2">2</option><option value="3">3</option><option value="4">4</option><option value="5">5</option><option value="6">6</option><option value="7">7</option><option value="8">8</option><option value="9">9</option></select>
							
							<!-- <input type="text" name="pos_'.$nom.'_1" class="ctrl">-->
						    <br/>
							Descripcion:<br/><textarea name="desc_'.$nom.'_1" class="ctrl" cols="60"></textarea><br/>
                            </strong> 
						</td>
                      </tr>
                      </table>
                      <table border="0" cellspacing="1" cellpadding="2">
                      <tr>
                        <td></td>
                        <td> <strong>
                          
                          </strong></td>
                      </tr>
                    <input type="hidden" name="'.$nom.'" id="'.$nom.'" value="1">
                    <input type="hidden" name="count_'.$nom.'" id="count_'.$nom.'" value="'.($cont+1).'">
					<input type="hidden" value="'.$this->id_registre.'" name="id_registre">
					<input type="hidden" value="'.$this->taula.'" name="taula">
					<input type="hidden" value="'.$this->camp.'" name="camp">
					<input type="hidden" value="'.$this->idioma.'" name="idioma">
					<input type="hidden" value="'.$this->cad_ext.'" name="extensions">
					<input type="hidden" value="'.$this->max_fitxers_galeria.'" name="max_fitxers_galeria">
					<input type="hidden"   name="processa">
					
					<input type="submit"  style="margin-left:30px;background:none;background-color:#eef;font-size:14px;font-weight:bold"   value="Upload" >
                    </table></fieldset>';
					if($this->form)$galeria.='</form>';
                    echo $galeria;
					
					
   }
else { 
$galeria.=' <tr>
                        <td></td>
                        <td> <strong>
                          
                          </strong></td>
                      </tr>
                    <input type="hidden" name="'.$nom.'" id="'.$nom.'" value="'.($cont+1).'">
                    <input type="hidden" name="count_'.$nom.'" id="count_'.$nom.'" value="1">
					<input type="hidden" value="'.$this->id_registre.'" name="id_registre">
					<input type="hidden" value="'.$this->taula.'" name="taula">
					<input type="hidden" value="'.$this->camp.'" name="camp">
					<input type="hidden" value="'.$this->idioma.'" name="idioma">
					<input type="hidden" value="'.$this->cad_ext.'" name="extensions">
					<input type="hidden" value="'.$this->max_fitxers_galeria.'" name="max_fitxers_galeria">
					<input type="hidden"   name="processa">
					<input type="submit"   style="background:none;background-color:#eef;font-size:14px;font-weight:bold"   value="Upload" >
                    </table></fieldset>';               
       if($this->form)$galeria.='</form>';
	   echo $galeria.'</div>';
	  
     }
	 
$this->printa_javascript();	
}

private function printa_javascript()
   {
   if($this->max_uploads-$this->max_input_upload>0)$this->max_uploads=$this->max_input_upload; 

?>

<script>
var i=1 ;
function addRow() {
               		if(i<<?php echo $this->max_uploads; ?>)i++;
					else { alert('excedit el numero de fitxers'); return 0; }
					document.getElementById('count_<?php echo $this->camp; ?>').value = parseInt(document.getElementById('count_<?php echo $this->camp; ?>').value) + 1;
  	         		var table;
	                
					table = document.getElementById('uploadtable_<?php echo $this->camp; ?>');
	                   if (table && table.rows && table.insertRow) {
	                     var tr = table.insertRow(table.rows.length);
	                     var td = tr.insertCell(tr.cells.length);
                         data = '<b>Fichero:</b><br/><input type="file" name="upload_<?php echo $this->camp; ?>_' + i + '" class="ctrl">'+
						 ' <b>Posición:</b><select name="pos_<?php echo $this->camp; ?>_' + i + '" class="ctrl" ><option selected="selected" value="0">0</option><option value="1">1</option> <option value="2">2</option><option value="3">3</option><option value="4">4</option><option value="5">5</option><option value="6">6</option><option value="7">7</option><option value="8">8</option><option value="9">9</option></select>'+
						 '<br/><b>Descripción:</b><br/><textarea name="desc_<?php echo $this->camp; ?>_' + i + '" class="ctrl" cols="60"></textarea><br/>';
	                     td.innerHTML = data;
	                   }
					   redim()
	                }
</script>

<?php

   }
 }  // Fi classe
 
 function funcio_crea_element($r,$path,$id=0)
   {
		return '<a  href="javascript:;"  title="Abrir iFrame"><img width="100px" style="margin:3px;border:1px solid #000" id="'.$id.'" src="../../uploads_media/'.$r->Nom.'"></a>'; 
	 }
   
   
 //print_r($_GET);  
 //print '=========';
 //print_r($_POST);  
 
 $galeria=new Galeria($db);
// $galeria->setFuncioCreaElement("funcio_crea_element");
 
 $galeria->Mida_maxima(2000);
 $galeria->setTaulaGaleries('ps_galeria_netne');
 $galeria->setPath('../../');
 
 

 
 // aqui van els camps d'enllaç del registre o sigui els valors del $_GET
 
 if(isset($_POST['id_registre'])){
 	 $_GET['id_registre']=$_POST['id_registre'];
	 $_GET['camp']=$_POST['camp'];
	 $_REQUEST['taula']=$_POST['taula'];
	 $_GET['idioma']=$_POST['idioma'];
	 $_GET['max_fitxers_galeria']=$_POST['max_fitxers_galeria'];
	 $_GET['extensions']=$_POST['extensions'];
 }
 $galeria->Extensions_Permeses('jpg,png,jpeg,JPG,PNG,GIF,gif');
 $galeria->Maxim_Fitxers_Galeria(300); 
 $galeria->setParamsLinkGaleria('999','camp',$_REQUEST['taula'],'');
 
 if(isset($_POST['processa']))$galeria->processa(); 

 ?>
 

 
 
 
 <?php

 $galeria->printa_multiple_upload("funcio_crea_element");
 

function crea_arxiu_xml($db)
   {
   	$cad='';
   	$cad.='<images>';
	$db->query('SELECT * from ps_galeria_netne ORDER BY Posicio');
	//'.$r->Descripcio.' 
   	while($r=$db->row())
	    {
	$cad.='<photo image="uploads_media/'.$r->Nom.'" colorboxImage="uploads_media/'.$r->Nom.'" colorboxInfo="Item 01" colorboxClass="image" url = "javascript:void();" target="_self">
	<![CDATA[<head>'._NOMBRE_LOGO_.'.com</head><body></body>]]></photo>';
}
	$cad.='</images>';
	file_put_contents('../../images.xml', $cad);
   }


?>


<style>

#galeria textarea,input,select
		{
		margin-left:20px;  font: 11px Verdana, arial, helvetica, sans-serif; background-color:#fff; border: #000000 1px solid;
		}
	
#galeria table td{
	margin-left:auto;
	margin-right:auto;
	border:0px solid #bbb;
	padding:0px;
}	
	
</style>




</body>


<script>


function getDimensions (oElement) {   //  alert(getDimensions(obj[0]).y);

	var x, y, w, h;
	x = y = w = h = 0;
	if (document.getBoxObjectFor) { // Mozilla
	var oBox = document.getBoxObjectFor(oElement);
	x = oBox.x-1;
	w = oBox.width;
	y = oBox.y-1;
	h = oBox.height;

}

else if (oElement.getBoundingClientRect) { // IE

	var oRect = oElement.getBoundingClientRect();
	x = oRect.left-2;
	w = oElement.clientWidth;
	y = oRect.top-2;
	h = oElement.clientHeight;
  }

return {x: x, y: y, w: w, h: h};

}

function redim()
 {
 var he=getDimensions(document.getElementById('galeria')).h
 parent.document.getElementById('iframe').style.height=(he+40)+'px'	
}  
redim()	
</script>


</html>