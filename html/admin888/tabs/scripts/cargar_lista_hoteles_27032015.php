<?php 
	include_once (dirname(__FILE__).'/../../../config/config.inc.php');
		
	$disponibilidad_hotel = new DisponibilidadHotel();      
	$hoteles=array();
	$hoteles=$disponibilidad_hotel->getHotelesCiudad();
	  
	$sciudad_ant="";

	if (!intval($_GET['html']))
	{
		echo("<script>");
		foreach ($hoteles as $hotel)				
		{
			echo("
				$(function() { 
				$( '#fecha_desde_".$hotel->codigo."').datepicker({
					dateFormat: 'dd/mm/yy',
					monthNames: ['Enero','Febrero','Marzo','Abril','Mayo','Junio',
									'Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'],
					monthNamesShort: ['Ene','Feb','Mar','Abr','May','Jun',
									'Jul','Ago','Sep','Oct','Nov','Dic'],
					dayNames: ['Domingo','Lunes','Martes','Mi&eacute;rcoles','Jueves','Viernes','S&aacute;bado'],
					dayNamesShort: ['Dom','Lun','Mar','Mi&eacute;','Juv','Vie','S&aacute;b'],
					dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','S&aacute;'],
					firstDay: 1,				
					showOn: 'button',
					buttonImage: 'http://www.motorclubexperience.com/scripts/calendario/img/calendario.jpg',
					buttonImageOnly: true
				});
			");
			echo("
				$(function() { 
				$( '#fecha_hasta_".$hotel->codigo."').datepicker({
					dateFormat: 'dd/mm/yy',
					monthNames: ['Enero','Febrero','Marzo','Abril','Mayo','Junio',
									'Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'],
					monthNamesShort: ['Ene','Feb','Mar','Abr','May','Jun',
									'Jul','Ago','Sep','Oct','Nov','Dic'],
					dayNames: ['Domingo','Lunes','Martes','Mi&eacute;rcoles','Jueves','Viernes','S&aacute;bado'],
					dayNamesShort: ['Dom','Lun','Mar','Mi&eacute;','Juv','Vie','S&aacute;b'],
					dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','S&aacute;'],
					firstDay: 1,				
					showOn: 'button',
					buttonImage: 'http://www.motorclubexperience.com/scripts/calendario/img/calendario.jpg',
					buttonImageOnly: true
				});
			");

		}




	/* InicializaciÃƒÂ³n en espaÃƒÂ±ol para la extensiÃƒÂ³n 'UI date picker' para jQuery. */
	/* Traducido por Vester (xvester@gmail.com). */
	echo("(function($) {
        $.ui.datepicker.regional['es'] = {
                renderer: $.ui.datepicker.defaultRenderer,
                monthNames: ['Enero','Febrero','Marzo','Abril','Mayo','Junio',
                'Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'],
                monthNamesShort: ['Ene','Feb','Mar','Abr','May','Jun',
                'Jul','Ago','Sep','Oct','Nov','Dic'],
                dayNames: ['Domingo','Lunes','Martes','Mi&eacute;rcoles','Jueves','Viernes','S&aacute;bado'],
                dayNamesShort: ['Dom','Lun','Mar','Mi&eacute;','Juv','Vie','S&aacute;b'],
                dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','S&aacute;'],
                dateFormat: 'dd/mm/yyyy',
                firstDay: 1,
                prevText: '&#x3c;Ant', prevStatus: '',
                prevJumpText: '&#x3c;&#x3c;', prevJumpStatus: '',
                nextText: 'Sig&#x3e;', nextStatus: '',
                nextJumpText: '&#x3e;&#x3e;', nextJumpStatus: '',
                currentText: 'Hoy', currentStatus: '',
                todayText: 'Hoy', todayStatus: '',
                clearText: '-', clearStatus: '',
                closeText: 'Cerrar', closeStatus: '',
                yearStatus: '', monthStatus: '',
                weekText: 'Sm', weekStatus: '',
                dayStatus: 'DD d MM',
                defaultStatus: '',
                isRTL: false
        };
        $.extend($.ui.datepicker.defaults, $.ui.datepicker.regional['es']);
	})(jQuery);

	</script>
	");
	 
	}


	 //var_dump($hoteles);
	
	if (intval($_GET['html']))
	{	
		foreach ($hoteles as $hotel)				
		{
			if ($sciudad_ant != $hotel->ciudad)
			{
				echo('<span class="label_ lcabecera">'.$hotel->ciudad.'</span>');
				$sciudad_ant = $hotel->ciudad;					
			}
			
			
			echo('<div class="lradio">');
			echo('<input type="radio" id="codigo_'.$hotel->codigo.'" name="ciudad_'.$hotel->ciudad.'" value="'.$hotel->codigo.'" onClick="guardar_codigo(\''.$hotel->ciudad.'\',this.value);" '.(($hotel->activo==1)?'checked="checked"':'').'> '.$hotel->nombre);					
			//echo('<br><span style="width:20px;margin-right:5px;">&nbsp;/&nbsp;Fecha Desde:</span> <input TYPE="text"  NAME="fecha_desde_'.$hotel->codigo.'" id="fecha_desde_'.$hotel->codigo.'" value="" style="width:93px;">');
			//echo('<span style="width:20px;margin-right:5px;">&nbsp;/&nbsp;Fecha Hasta:</span> <input TYPE="text"  NAME="fecha_hasta_'.$hotel->codigo.'" id="fecha_hasta_'.$hotel->codigo.'" value="" style="width:93px;">');
			echo('</div>');
			
		}
	}
	unset($disponibilidad_hotel);
	
?>
