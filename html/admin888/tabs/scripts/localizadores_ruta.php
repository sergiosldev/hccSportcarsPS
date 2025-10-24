<?php
	include_once(dirname(__FILE__).'/funciones_ruta_localizadores.php');
	include(dirname(__FILE__).'/../../../config/config.inc.php');	
	
	$operacion = Tools::getValue('operacion');

	switch ($operacion)
	{
		case 'listado':
			$tmp = getFormLocalizadoresRuta(Tools::getValue('id_tipo_ruta'),Tools::getValue('codigo_localizador'));
			echo($tmp);
		break;
		case 'guardar':
			$res = guardarLocalizador(Tools::getValue('id_tipo_ruta'),Tools::getValue('codigo_localizador'),Tools::getValue('nombre_apellidos'),Tools::getValue('origen'),Tools::getValue('otros'));                 
			if ($res) echo 'OK';
			else echo 'ERROR'; 
		break;
		case 'borrar':
			$localizadorRuta = new LocalizadorRuta(Tools::getValue('id_localizador'));
			$res = $localizadorRuta->delete();
			unset($localizadorRuta);
			if ($res) echo 'OK';
			else echo 'ERROR'; 
		break;
		default:
		break;
	}
?>