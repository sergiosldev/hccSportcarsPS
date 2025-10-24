<?php
include(dirname(__FILE__).'/../../../scripts/ip_functions.php');
include_once(dirname(__FILE__).'/../../../classes/LocalizadorRuta.php');
include_once(dirname(__FILE__).'/conversiones_html.php');

function guardarLocalizador($id_tipo_ruta,$codigo_localizador,$nombre_apellidos,$origen,$otros='')
 {
	$localizador_ruta = new LocalizadorRuta();

	$localizador_ruta->codigo_localizador  = $codigo_localizador; 
	
	$localizador_ruta->id_tipo_ruta  = ($id_tipo_ruta=='')?1:$id_tipo_ruta; 
	$localizador_ruta->origen  = $origen; 
	$localizador_ruta->otros  = $otros; 
	$localizador_ruta->nombre_apellidos  = $nombre_apellidos; 
	$localizador_ruta->fecha = date('Y-m-d H:i:s');
	
	$localizador_ruta->ip  = GetUserIp_();
	
	$localizador_ruta->pc=$_SERVER['REMOTE_HOST'];
	
	$localizador = $localizador_ruta->getLocalizadores($id_tipo_ruta,$codigo_localizador);
	if (!empty($localizador))
		$localizador_ruta->id = $localizador[0]->id;
	
	if ($localizador_ruta->save())
			return true;			
	
	return false;
	
 }
 
 
 function getFormLocalizadoresRuta($id_tipo_ruta,$codigo_localizador='')
 {
 
	try {
		if (intval(trim($id_tipo_ruta)) == 0) $id_tipo_ruta = 1;
 		$tmp = new LocalizadorRuta();
		if ($codigo_localizador!='')
			$localizadores = $tmp->getLocalizadores($id_tipo_ruta,$codigo_localizador);
		else	
			$localizadores = $tmp->getLocalizadores($id_tipo_ruta);
		//var_dump($localizadores);
		$tmp = new TipoRuta();
		$tipo_ruta=$tmp->getTiposRuta($id_tipo_ruta);
		$tipo_ruta = $tipo_ruta[0];
		$descripcion = $tipo_ruta->descripcion;
		
		/*
		$form = '<fieldset><legend>Lista de Localizadores para la ruta <span style="font-weight:bold;">"'.$descripcion.'"</span></legend>'
		$form.= '<div class="fila cabecera" style="line-height:20px !important;">';
		$form.= '	<div style="float:left;width:100%;">';
		$form.= '		<span class="celda titulo texto"> C&oacute;digo Localizador</span><span class="celda titulo texto email">Email</span>';
		$form.= '	</div>';
		$form.= '	<div style="float:left;width:100%;">';
		$form.= ' 		<input class="celda" type="text" id="codigo_localizador" name="codigo_localizador"><input type="text" id="email" name="email" class="celda email" >';
		$form.= ' 		<span class="celda titulo texto"> &nbsp;</span>';
		$form.= ' 		<input type="button" id="guardar"name="guardar" style="width:130px;" onclick="guardar_localizador('.$id_tipo_ruta.',id_(\'email\').value,id_(\'codigo_localizador\').value)" value="Guardar">';
		//$form.= '		<input type="hidden" id="id_localizador" name="id_localizador" value=""> ';	
		$form.= '	</div>';		
		$form.= '</div>';
		*/
		$i=0;
		foreach ($localizadores as $localizador)
		{
			//var_dump($localizador);echo('<br><br>');
			$fecha=explode(' ',$localizador->fecha);
			$hora = substr($fecha[1],0,5);
			$fecha = implode('/',array_reverse(explode('-',$fecha[0])));
			$fecha = $fecha.' '.$hora; 
			if (!$i) $margin_top = 'margin-top:20px';
			else $margin_top = '';
			$form.= '<div class="fila" style="float:left;width:100%;'.$margin_top.'">';
			$form.= '	<div style="float:left;width:100%;">';
			$form.= '		<span class="celda titulo texto"> C&oacute;digo Localizador</span>
							<span class="celda titulo texto" >Nombre y apellidos</span>
							<span class="celda titulo texto" style="130px;">Origen</span>
							<span class="celda titulo texto" style="width:100px;">Fecha</span>
							<span class="celda titulo texto" style="width:80px;">Borrar</span>';
			$form.= '	</div>';
			$form.= '	<div style="float:left;width:100%;padding-top:7px;">';
			$form.= '		<span class="celda texto">'.$localizador->codigo_localizador.'</span>
							<span class="celda texto">'.$localizador->nombre_apellidos.'</span>
							<span class="celda texto" style="width:130px;">'.$localizador->origen.'</span>
							<span class="celda texto" style="width:100px;">'.$fecha.'</span>';
			$form.= ' 		<a style="margin-left:45px;" href="javascript:borrar_localizador('.$localizador->id.','.$id_tipo_ruta.')"><img src="tabs/img/esborra.gif"></a>';
			//$form.= ' 		<a style="margin-left:24px;" href="javascript:editar_localizador('.$localizador->id.')"><img src="../img/admin/edit.gif"></a>';
			$form.= '	</div>';
	
			$form.= '</div>';
			//$localizador['id_tipo_ruta'];
			//$localizador['codigo_localizador'];
			//$localizador['email'];
			//$localizador['fecha'];
			//$localizador['ip'];
			//$localizador['pc'];	}
			$i++;
		}	

		
		return $form;		
	}
	catch (Exception $e)
	{
		return "#error";
	}
	
 }
 
 ?>
 
