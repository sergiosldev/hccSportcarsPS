<?php 
//include('config_events.php');
//include_once 'functions.php';
//die(PS_ADMIN_DIR.'/../classes/LocalizadorRuta.php');
//include_once('http://www.motorclubexperience.com/classes/LocalizadorRuta.php'); 

include_once('../../../config/config.inc.php');
include_once('../../../classes/LocalizadorRuta.php');
include_once('../../../excel/excel_reader2.php');
include (dirname(__FILE__).'/funciones_ruta_localizadores.php'); 
   
$columnas_excel = array('id_tipo_ruta'=>0,'codigo_localizador'=>0,'nombre_apellidos'=>0,'date_add'=>0);
     
$error = "";
$origen=$_POST['origenf'];
$nombre_archivo_tmp = $_FILES['archivo_carga']['tmp_name'];
$nombre_archivo = $_FILES['archivo_carga']['name'];

  
ActualizarParametrosCarga($origen,$columnas_excel);
   
$error=0;
if ((!isset($_FILES['archivo_carga']['tmp_name']) or $_FILES['archivo_carga']['tmp_name'] == NULL)) 
    {
    $error = 1;//"Error: Debe introducir el archivo";
    }

   
CargarLocalizadores($archivo,$origen,$columnas_excel,$nombre_archivo,$nombre_archivo_tmp,$error);
//$error = 'origen '.$origen.' archivo '.$error.'->'.$nombre_archivo_tmp;     
echo('<script>parent.resultadoUpload("'.$error.'");</script>');  
   

function CargarLocalizadores($archivo,$origen,$columnas_excel,$nombre_archivo,$nombre_archivo_tmp,&$error)
{
 //   global $error;
    
	//$archivo = (isset($_FILES['archivo_carga']['tmp_name']) AND $_FILES['archivo_carga']['tmp_name'] != NULL)?$_FILES['archivo_carga']['tmp_name']:'';

	if ($origen == 'LETSBONUS')
	{
		$primera_fila_localizadores = 5;
		$columna_tipo_ruta = 0;
		$fila_tipo_ruta = 0;
		$tipo_archivo = 'csv';
		$separador = ';';
	}
	else if ($origen != 'GROUPON')
	{
		$primera_fila_localizadores = 2;
		$columna_tipo_ruta = 0;
		$fila_tipo_ruta = 0;
		$tipo_archivo = 'csv';
		$separador = ';';
	}
	else
	{
		$primera_fila_localizadores = 11;
		$fila_tipo_ruta = 7;
		$columna_tipo_ruta = 2;
		$tipo_archivo = 'xls';
		$separador = '';
	}
	
	
	   
	$tipo_ruta = '';
	$i=0;
	$destino = dirname(__FILE__).'/localizadores/'.$nombre_archivo;
	
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
		//var_dump($datos);echo('<br>');

		//$error.='\n fila '.$i;
		$numero_columnas = count($datos);
		//$error.='columnas '.$numero_columnas;
		$j=0;
		$datos_a_insertar = array();
		foreach ($datos as $dato)
		{ 
		//$error.='aki0'.$dato;
 
			//para el caso de groupon, el dato de tipo de ruta no aparece con los localizadores sino en una fila aparte, en una cabecera.
			if ($fila_tipo_ruta && $i+1==$fila_tipo_ruta)
			{
				//$error.='aki0';
				if ($j+1==2) $tipo_ruta = $dato;
			}
			//para el resto, el tipo de ruta está contenido en el registro de cada localizador.
		    else if ($i+1>=$primera_fila_localizadores)
				{
					//$error.='aki1';
					foreach ($columnas_excel as $campo=>$columna)
					{ 
						//$error.='aki2 '.$columna.'<br>';
						$columna_actual = $j+1;
						$icolumna = $columna;	 

						if ($icolumna==$columna_actual)
							{
								if ($origen=='LETSBONUS' && $columna==2)
								{
									$datos_a_insertar[$campo].=$datos[1].' '.$datos[2];
								}
								else
								$datos_a_insertar[$campo]=$dato;//iconv("ISO-8859-1","UTF-8", $dato);
								//$tab = array("UTF-8", "ASCII", "Windows-1252", "ISO-8859-15", "ISO-8859-1", "ISO-8859-6", "CP1256"); 
								
								$datos_a_insertar[$campo]  = trim($datos_a_insertar[$campo]);
								//$error.=','.$campo.':'.$datos_a_insertar[$campo];
							}
					}
					
				}
			
		$j++;
		     
		}
		
		
		if (trim($datos_a_insertar['codigo_localizador'])!='')
		{
		$id_tipo_ruta = BuscarTipoRuta($origen,$datos_a_insertar['id_tipo_ruta'],$tipo_ruta);	
		//$error.= '\n fila '.($i+1).$datos_a_insertar['id_tipo_ruta'].'-'.$id_tipo_ruta.'>'; 
		$a=guardarLocalizador($id_tipo_ruta,$datos_a_insertar['codigo_localizador'],$datos_a_insertar['nombre_apellidos'],$origen);
		}

		$i++;

		switch ($tipo_archivo)
		{
			case 'csv':
				//setlocale(LC_ALL, 'es_ES.UTF-8');
				$datos = fgetcsv($fichero, 1000, $separador);
//				var_dump($datos);
				$condicion_while = $datos;				
			break;
			case 'xls':
				$data = new Spreadsheet_Excel_Reader();
				$data->read($destino);
				$datos = $data->sheets[0]['cells'][$i+1];
				$condicion_while =$i+1<=$data->rowcount(0);
				
			break;
			default:
			break;
		}
		
		
	}
	 
	

	@unlink($destino);
		
    return (true);
}

function BuscarTipoRuta($origen,$id_tipo_ruta,$tipo_ruta)    
{
	switch($origen)
	{
		case 'LETSBONUS':
			$id_tipo_ruta = BuscarTipoRutaEnTexto($id_tipo_ruta);
		break;
		case 'GROUPALIA':
			$id_tipo_ruta=substr($id_tipo_ruta,strpos($id_tipo_ruta, '-')+1);
		break;
		case 'GROUPON':
			if ($tipo_ruta!='')
			{
				$id_tipo_ruta = BuscarTipoRutaEnTexto($tipo_ruta);
			}			
		break;
		default:
			//$columnas_excel['id_tipo_ruta']=0;
			//$columnas_excel['codigo_localizador']=1;
			//$columnas_excel['nombre_apellidos']=1;
			//$columnas_excel['codigo_localizador']=1;
			
		break;
	}
	
	return $id_tipo_ruta;
}

function BuscarTipoRutaEnTexto($texto)
{
	$ferrari_lambo = false;
	$bautizo = false;
	$experiencia = false;
	$sdato = strtoupper($texto);
	
	$ferrari_lambo = (strpos($sdato,'FERRARI')!== false) || (strpos($sdato,'LAMBORGHINI')!== false);
	$porsche  = (strpos($sdato,'PORSCHE')!== false);
	$experiencia = (strpos($sdato,'20KM')!== false) || (strpos($sdato,'20 KM')!== false) || (strpos($sdato,'20  KM')!== false);
	$bautizo = (strpos($sdato,'7KM')!== false) || (strpos($sdato,'7 KM')!== false) ||(strpos($sdato,'7  KM')!== false);
	
	if ($experiencia)
	{
		if ($ferrari_lambo) $id_tipo_ruta = 2;
		else if ($porsche) $id_tipo_ruta = 4;
	}
	else if ($bautizo)
	{
		if ($ferrari_lambo) $id_tipo_ruta = 1;
		else if ($porsche) $id_tipo_ruta = 3;
	}
	
return $id_tipo_ruta;
}

function ActualizarParametrosCarga($origen,&$columnas_excel)
{

	switch($origen)
	{
		case 'GROUPON':
			$columnas_excel['id_tipo_ruta']=0; //En groupon el tipo de ruta no se asocia a un localizador sino a todo el archivo.
			$columnas_excel['codigo_localizador']=1;
			$columnas_excel['nombre_apellidos']=0;
		break;
		case 'GROUPALIA':
			$columnas_excel['id_tipo_ruta']=2;
			$columnas_excel['codigo_localizador']=5;
			$columnas_excel['nombre_apellidos']=3;
		break;
		case 'LETSBONUS':
			$columnas_excel['id_tipo_ruta']=4;
			$columnas_excel['codigo_localizador']=5;
			$columnas_excel['nombre_apellidos']=2;
			//array(2,3);
		break;
		default:
			/*$columnas_excel['id_tipo_ruta']=0;
			$columnas_excel['codigo_localizador']=1;
			$columnas_excel['nombre_apellidos']=1;
			$columnas_excel['codigo_localizador']=1;
			*/
		break;
	}
}
	

?>
	


