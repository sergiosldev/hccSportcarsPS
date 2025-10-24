<?php

function calcular_periodo($fechaIni,$fechaFin)
{
   //restamos un minuto ya que el periodo siempre va hasta las 00 de la noche que corresponde por lo tanto al día
   //siguiente al del fin de periodo. 
   $hora_fin = mktime(0,0,0,substr($fechaFin,5,2),substr($fechaFin,8,2),substr($fechaFin,0,4))-1*60;
   $fecha_fin = date("Y-m-d H:i:s",$hora_fin);
   list($a,$m,$d) = explode('-',substr($fecha_fin,0,10));
   //substituimos la hora por ceros, para el cálculo del periodo.
   $hora_fin = mktime(0,0,0, $m,$d,$a);

   $hf = date("Y-m-d H:i:s",$hora_fin);
   $hora_ini = mktime(0,0,0,substr($fechaIni,5,2),substr($fechaIni,8,2),substr($fechaIni,0,4));
   $hi = date("Y-m-d H:i:s",$hora_ini);
   $periodo = (($hora_fin-$hora_ini)/60)/60+24;
  //$periodo = $fechaIni.'-'.$hf;
   ///60/60+1;

   if (($hora_fin-$hora_ini)<0) return 0;

   return $periodo;
}

//Devuelve las fecha actual y la fecha final según el periodo
//es decir, si el periodo es de 24h. la fecha final serán las 00h del día siguiente.
// si es de 48h, las 00h de 2 días posteriores a la fecha actual, etc...
// devuelve la fecha actual y la fecha fin periodo  en formato "YY-MM-DD HH:MM:SS").
function calcular_fechas_periodo($periodo)
{
    
    $dias_periodo = (int)$periodo/24; 
    
    $hora_actual = time();
    $fechaInicio = date("Y-m-d H:i:s",$hora_actual);
    $fechaInicioArr = explode(' ',$fechaInicio);
    list($a,$m,$d) = explode('-',$fechaInicioArr[0]); 
    //return($a.'-'.$m.'-'.$d); 
    $fechaFin = mktime(0,0,0, $m,$d,$a) + $dias_periodo * 24 * 60 * 60;
    $fechaFin = date("Y-m-d H:i:s",$fechaFin);
    
    return array($fechaInicio,$fechaFin);    
}


?>