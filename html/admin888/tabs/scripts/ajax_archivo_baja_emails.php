<?php 
//include('config_events.php');
//include_once 'functions.php';
//die(PS_ADMIN_DIR.'/../classes/LocalizadorRuta.php');
//include_once('http://www.motorclubexperience.com/classes/LocalizadorRuta.php'); 

include_once('../../../config/config.inc.php');
include_once('../../../classes/LocalizadorRuta.php');
include_once('../../../excel/excel_reader2.php');
include (dirname(__FILE__).'/funciones_ruta_localizadores.php'); 
   
$columnas_excel = array('email'=>0);
     
$error = "";
$nombre_archivo_tmp = $_FILES['archivo_carga']['tmp_name'];
$nombre_archivo = $_FILES['archivo_carga']['name'];

 
ActualizarParametrosCarga($origen,$columnas_excel);
   
$error=0;
if ((!isset($_FILES['archivo_carga']['tmp_name']) or $_FILES['archivo_carga']['tmp_name'] == NULL)) 
    {
    $error = 1;//"Error: Debe introducir el archivo";
    }

   
CargarEmails($archivo,$columnas_excel,$nombre_archivo,$nombre_archivo_tmp,$error);
//$error = 'origen '.$origen.' archivo '.$error.'->'.$nombre_archivo_tmp;     
echo('<script>parent.resultadoUpload("'.$error.'");</script>');  
   

function CargarEmails($archivo,$columnas_excel,$nombre_archivo,$nombre_archivo_tmp,&$error)
{
	$tipo_archivo = 'xls';
	$separador = '';
	
	

	$i=0;
	$destino = dirname(__FILE__).'/bajas/'.$nombre_archivo;
	
	if(move_uploaded_file($nombre_archivo_tmp, $destino))
		$error = 0;//'El archivo se cargó correctamente';
	else
		$error = 2;//'Error al cargar el archivo';
	
	//$error.='fila_tipo_ruta '.$fila_tipo_ruta;
	
	
	//while ($datos = fgetcsv($fichero, 1000, ';', '"')) 
	switch ($tipo_archivo)
	{
		case 'csv':
			$fichero = fopen($destino, 'r');
			$datos = fgetcsv($fichero, 1000, $separador);
			$condicion_while = $datos;
		break;
		case 'xls':			
			$data = new Spreadsheet_Excel_Reader();
			//$data->setOutputEncoding(‘CP1251′);
			$data->read($destino);
			$datos = $data->sheets[0]['cells'][$i+1];
			$condicion_while =$i+1<=$data->rowcount(0);
		break;
		default:
		break;
	}

	while ($condicion_while) 
	{
		$j=0;
		$emails = array();
		foreach ($datos as $dato)
		{ 
			$email=trim($dato);//iconv("ISO-8859-1","UTF-8", $dato);
			$a=guardarEmail($email);
			$j++;
		}

		$i++;
		
		
	}
	 
	

	@unlink($destino);
		
    return (true);
}




	

?>
	


