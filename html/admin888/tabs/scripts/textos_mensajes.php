<?php
include_once(dirname(__FILE__).'/../../../config/defines.inc.php');

function texto_reserva()
{

ob_start();

?>
<p class="ecxMsoNormal">
	Mensaje<br />
	Enviado por <?php echo(_NOMBRE_EMP_);?> </p>
<p class="ecxMsoNormal">
	<b style=""><span style="font-size:11.0pt;line-height:115%;color:red">Es muy importante que lea esta confirmaci&oacute;n para que conozca las condiciones de uso.</span></b><br />
	<br />
	<span style="">&nbsp;</span>Su reserva ha sido realizada Tal y como ha indicado m&aacute;s abajo.<br />
	<span style="">&nbsp;</span><br />
	Recuerde que la hora que le asignamos es aproximada, <span style="">&nbsp;</span>pero debe presentarse 30 minutos antes de la hora solicitada<b style="">, <br />
	</b></p>
<p class="ecxMsoNormal">
	<b style="">es muy importante</b> presentar esta confirmaci&oacute;n junto con el ticket bono, fotocopia del DNI y fotocopia del carnet de </p>
<p class="ecxMsoNormal">
	conducir en nuestras instalaciones<b style="">. En caso de no presentar dicha documentaci&oacute;n no se podr&aacute; realizar el servicio.<br />
	</b>Si desea cancelar o modificar esta reserva, debe hacerlo con una antelaci&oacute;n <b style="">m&iacute;nima de 7 d&iacute;as.</b></p>
<p class="ecxMsoNormal">
	Si su cup&oacute;n esta <span style="">&nbsp;</span>caducado o esta apunto de caducar para el d&iacute;a que quiere realizar el evento p&oacute;ngase en contacto con </p>
<p class="ecxMsoNormal">
	nosotros para ampliar la fecha de caducidad. Ya que una vez caducado no podremos activarlo.</p>
<p class="ecxMsoNormal">
	<b style=""><br />
	</b></p>
<p class="ecxMsoNormal">
	<b style="">Motor Club Experiencia no podr&aacute; realizar ning&uacute;n servicio a todo participante que aporte su cup&oacute;n caducado el d&iacute;a del evento.</b></p>
<p class="ecxMsoNormal">
	&nbsp;</p>
<p class="ecxMsoNormal">
	Os recordamos que dicha actividad est&aacute; sujeta a condiciones meteorol&oacute;gicas y aver&iacute;as imprevistas. Todos aquellos eventos que sean suspendidos</p>
<p class="ecxMsoNormal">
	por dichas causas ser&aacute;n notificados al mismo email que ha recibido esta confirmaci&oacute;n. Os recomendamos que la noche antes del evento revise su correo&nbsp; <span style=""><br />
	</span></p>
<p class="ecxMsoNormal">
	para asegurarse de que no hay ninguna anulaci&oacute;n por incidente, ya sea meteorol&oacute;gico, aver&iacute;a etc&hellip;. (Revise su correo no deseado). </p>
<p class="ecxMsoNormal">
	&nbsp;</p>
<p>
	<font color="#FF0000" style=""><b>Motor Club Experience no se responsabiliza de los desplazamientos combinaciones&nbsp; y molestias ocasionadas por las mencionadas condiciones de incidencia y uso.</b></font></p>

<?php

$out = ob_get_contents();
ob_end_clean();
return $out;

}

//echo texto_reserva();


function texto_reserva_hotel()
{

ob_start();

?>
<p class="ecxMsoNormal">
	Mensaje<br />
	Enviado por <?php echo(_NOMBRE_EMP_);?></p>
<p class="ecxMsoNormal">
	<b style=""><span style="font-size:11.0pt;line-height:115%;color:red">Es muy importante que lea esta confirmaci&oacute;n para que conozca las condiciones de uso.</span></b><br />
	<br />
	<span style="">&nbsp;</span>Su reserva ha sido realizada Tal y como ha indicado m&aacute;s abajo.<br />
	<span style="">&nbsp;</span><br />
	Recuerde que la hora que le asignamos es aproximada, <span style="">&nbsp;</span>pero debe presentarse 30 minutos antes de la hora solicitada<b style="">, <br />
	</b></p>
<p class="ecxMsoNormal">
	<b style="">es muy importante</b> presentar esta confirmaci&oacute;n junto con el ticket bono, fotocopia del DNI y fotocopia del carnet de </p>
<p class="ecxMsoNormal">
	conducir en nuestras instalaciones<b style="">. En caso de no presentar dicha documentaci&oacute;n no se podr&aacute; realizar el servicio.<br />
	</b>Si desea cancelar o modificar esta reserva, debe hacerlo con una antelaci&oacute;n <b style="">m&iacute;nima de 7 d&iacute;as.</b></p>
<p class="ecxMsoNormal">
	Si su cup&oacute;n esta <span style="">&nbsp;</span>caducado o esta apunto de caducar para el d&iacute;a que quiere realizar el evento p&oacute;ngase en contacto con </p>
<p class="ecxMsoNormal">
	nosotros para ampliar la fecha de caducidad. Ya que una vez caducado no podremos activarlo.</p>
<p class="ecxMsoNormal">
	<b style=""><br />
	</b></p>
<p class="ecxMsoNormal">
	<b style="">Motor Club Experiencia no podr&aacute; realizar ning&uacute;n servicio a todo participante que aporte su cup&oacute;n caducado el d&iacute;a del evento.</b></p>
<p class="ecxMsoNormal">
	&nbsp;</p>
<p class="ecxMsoNormal">
	Os recordamos que dicha actividad est&aacute; sujeta a condiciones meteorol&oacute;gicas y aver&iacute;as imprevistas. Todos aquellos eventos que sean suspendidos</p>
<p class="ecxMsoNormal">
	por dichas causas ser&aacute;n notificados al mismo email que ha recibido esta confirmaci&oacute;n. Os recomendamos que la noche antes del evento revise su correo&nbsp; <span style=""><br />
	</span></p>
<p class="ecxMsoNormal">
	para asegurarse de que no hay ninguna anulaci&oacute;n por incidente, ya sea meteorol&oacute;gico, aver&iacute;a etc&hellip;. (Revise su correo no deseado). </p>
<p class="ecxMsoNormal">
	&nbsp;</p>
<p class="ecxMsoNormal">
	&nbsp;</p>
<p class="ecxMsoNormal" style="margin-bottom:0.0001pt;line-height:normal">
	<span style="font-size:10pt;font-family:&quot;Arial&quot;,&quot;sans-serif&quot;">La reserva de la habitaci&oacute;n est&aacute; garantizada hasta las 18 horas del d&iacute;a de llegada, si tiene previsto llegar m&aacute;s tarde de esta hora, llame al Hotel <span style="">&nbsp;</span><br />
	</span></p>
<p class="ecxMsoNormal" style="margin-bottom:0cm;margin-bottom:.0001pt;line-height:normal">
	<span style="font-size:10.0pt;font-family:&quot;Arial&quot;,&quot;sans-serif&quot;">para avisar de su retraso para mantener su reserva activada. Cualquier reserva que no haya confirmado su retraso o se haiga presentado despu&eacute;s de las 18:00 podr&aacute; ser anulada.</span></p>
<p>
	<span style="font-size:10.0pt;font-family:&quot;Arial&quot;,&quot;sans-serif&quot;">En caso de querer cancelar una reserva,</span> llamar <span style="">&nbsp;</span>al 93 126 32 81 de 10 a 13h. De martes a viernes.</p>

<?php

$out = ob_get_contents();
ob_end_clean();
return $out;

}

//echo texto_reserva_hotel();






?>